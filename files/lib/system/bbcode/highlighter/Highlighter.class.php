<?php
namespace wcf\system\bbcode\highlighter;
use wcf\system\Callback;
use wcf\system\Regex;
use wcf\system\SingletonFactory;
use wcf\system\WCF;
use wcf\util\StringStack;
use wcf\util\StringUtil;

/**
 * Highlights syntax of source code.
 * 
 * @author	Tim Duesterhus, Michael Schaefer
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category	Community Framework
 */
abstract class Highlighter extends SingletonFactory {
	// highlighter syntax
	// @todo: comment properties
	protected $quotes = array("'", "\"");
	protected $singleLineComment = array("//");
	protected $commentStart = array("/*");
	protected $commentEnd = array("*/");
	protected $escapeSequence = array("\\");
	protected $separators = array();
	protected $operators = array();
	protected $keywords1 = array(), $keywords2 = array(), $keywords3 = array(), $keywords4 = array(), $keywords5 = array();
	protected $allowsNewslinesInQuotes = false;
	
	// regular expressions
	// @todo: comment properties
	public $cacheCommentsRegEx = null;
	public $quotesRegEx = null;
	public $separatorsRegEx = '';
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$this->buildRegularExpressions();
	}
	
	/**
	 * Returns the title of this highlighter.
	 * 
	 * @return	string
	 */
	public function getTitle() {
		// regex to extract the Highlighter out of the namespaced classname
		$reType = new Regex('\\\\?wcf\\\\system\\\\bbcode\\\\highlighter\\\\(.*)Highlighter', Regex::CASE_INSENSITIVE);
		
		return WCF::getLanguage()->get('wcf.bbcode.code.'.$reType->replace(strtolower(get_class($this)), '\1').'.title');
	}
	
	/**
	 * Highlights syntax of source code.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	public function highlight($string) {
		// cache comments
		$string = $this->cacheComments($string);
		
		// cache quotes
		$string = $this->cacheQuotes($string);
		
		// encode html
		$string = StringUtil::encodeHTML($string);
		
		// do highlight
		$string = $this->highlightOperators($string);
		$string = $this->highlightKeywords($string);
		$string = $this->highlightNumbers($string);
		
		// insert and highlight quotes
		$string = $this->highlightQuotes($string);
		
		// insert and highlight comments
		$string = $this->highlightComments($string);
		
		return $string;
	}
	
	/**
	 * Builds regular expressions.
	 */
	protected function buildRegularExpressions() {
		// quotes regex
		$quotedEscapeSequence = preg_quote(implode('', $this->escapeSequence));
		$quotesRegEx = '';
		foreach ($this->quotes as $quote) {
			if ($quotesRegEx !== '') $quotesRegEx .= '|';
			
			$quote = preg_quote($quote);
			$quotesRegEx .= $quote.'(?:[^'.$quote.$quotedEscapeSequence.']|'.$quotedEscapeSequence.'.)*'.$quote;
		}
		
		if ($quotesRegEx !== '') {
			$quotesRegEx = '(?:'.$quotesRegEx.')';
			$this->quotesRegEx = new Regex($quotesRegEx, ($this->allowsNewslinesInQuotes) ? Regex::DOT_ALL : Regex::MODIFIER_NONE);
		}
		
		// cache comment regex
		if (!empty($this->singleLineComment) || !empty($this->commentStart)) {
			$cacheCommentsRegEx = '';
			
			if ($quotesRegEx !== '') {
				$cacheCommentsRegEx .= "(".$quotesRegEx.")|";
			}
			else {
				$cacheCommentsRegEx .= "()";
			}
			
			$cacheCommentsRegEx .= "(";
			if (!empty($this->singleLineComment)) {
				$cacheCommentsRegEx .= "(?:".implode('|', array_map('preg_quote', $this->singleLineComment)).")[^\n]*";
				if (!empty($this->commentStart)) {
					$cacheCommentsRegEx .= '|';
				}
			}
			
			if (!empty($this->commentStart)) {
				$cacheCommentsRegEx .= '(?:'.implode('|', array_map('preg_quote', $this->commentStart)).').*?(?:'.implode('|', array_map('preg_quote', $this->commentEnd)).')';
			}
			$cacheCommentsRegEx .= ")";
			
			$this->cacheCommentsRegEx = new Regex($cacheCommentsRegEx, Regex::DOT_ALL);
		}
		
		$this->separatorsRegEx = StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->separators))).'|\s|&nbsp;|^|$|>|<';
	}
	
	/**
	 * Caches comments.
	 */
	protected function cacheComments($string) {
		if ($this->cacheCommentsRegEx !== null) {
			$string = $this->cacheCommentsRegEx->replace($string, new Callback(function (array $matches) {
				$string = $matches[1];
				if (isset($matches[2])) $comment = $matches[2];
				else $comment = '';
				
				// strip slashes
				$string = str_replace("\\\"", "\"", $string);
				$hash = '';
				if (!empty($comment)) {
					$comment = str_replace("\\\"", "\"", $comment);
						
					// create hash
					$hash = StringStack::pushToStringStack('<span class="hlComments">'.StringUtil::encodeHTML($comment).'</span>', 'highlighterComments');
				}
				
				return $string.$hash;
			}));
		}
		
		return $string;
	}
	
	/**
	 * Caches quotes.
	 */
	protected function cacheQuotes($string) {
		if ($this->quotesRegEx !== null) {
			$string = $this->quotesRegEx->replace($string, new Callback(function (array $matches) {
				return StringStack::pushToStringStack('<span class="hlQuotes">'.StringUtil::encodeHTML($matches[0]).'</span>', 'highlighterQuotes');
			}));
		}
		
		return $string;
	}
	
	/**
	 * Highlights operators.
	 */
	protected function highlightOperators($string) {
		if (!empty($this->operators)) {
			$string = preg_replace('!('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $this->operators))).')!i', '<span class="hlOperators">\\0</span>', $string);
		}
		
		return $string;
	}
	
	/**
	 * Highlights keywords.
	 */
	protected function highlightKeywords($string) {
		$_this = $this;
		$buildKeywordRegex = function (array $keywords) use ($_this) {
			return '!(?<='.$_this->separatorsRegEx.')('.StringUtil::encodeHTML(implode('|', array_map('preg_quote', $keywords))).')(?='.$_this->separatorsRegEx.')!i';
		};
		
		if (!empty($this->keywords1)) {
			$string = preg_replace($buildKeywordRegex($this->keywords1), '<span class="hlKeywords1">\\0</span>', $string);
		}
		if (!empty($this->keywords2)) {
			$string = preg_replace($buildKeywordRegex($this->keywords2), '<span class="hlKeywords2">\\0</span>', $string);
		}
		if (!empty($this->keywords3)) {
			$string = preg_replace($buildKeywordRegex($this->keywords3), '<span class="hlKeywords3">\\0</span>', $string);
		}
		if (!empty($this->keywords4)) {
			$string = preg_replace($buildKeywordRegex($this->keywords4), '<span class="hlKeywords4">\\0</span>', $string);
		}
		if (!empty($this->keywords5)) {
			$string = preg_replace($buildKeywordRegex($this->keywords5), '<span class="hlKeywords5">\\0</span>', $string);
		}
		
		return $string;
	}
	
	/**
	 * Highlights numbers.
	 */
	protected function highlightNumbers($string) {
		$string = preg_replace('!(?<='.$this->separatorsRegEx.')(-?\d+)(?='.$this->separatorsRegEx.')!i', '<span class="hlNumbers">\\0</span>', $string);
		
		return $string;
	}
	
	/**
	 * Highlights quotes.
	 */
	protected function highlightQuotes($string) {
		return StringStack::reinsertStrings($string, 'highlighterQuotes');
	}
	
	/**
	 * Highlights comments.
	 */
	protected function highlightComments($string) {
		return StringStack::reinsertStrings($string, 'highlighterComments');
	}
}
