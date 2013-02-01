<?php
namespace wcf\system\bbcode\highlighter;
use wcf\system\Callback;
use wcf\system\Regex;
use wcf\util\StringStack;
use wcf\util\StringUtil;

/**
 * Highlights syntax of xml sourcecode.
 * 
 * @author	Tim Düsterhus, Michael Schaefer
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category	Community Framework
 */
class XmlHighlighter extends Highlighter {
	// highlighter syntax
	protected $allowsNewslinesInQuotes = true;
	protected $quotes = array('"');
	protected $singleLineComment = array();
	protected $commentStart = array("<!--");
	protected $commentEnd = array("-->");
	protected $separators = array("<", ">");
	protected $operators = array();
	const XML_ATTRIBUTE_NAME = '[a-z0-9](?:(?:(?<!-)-)?[a-z0-9])*';
	
	/**
	 * @see	wcf\system\bbcode\highlighter\Highlighter::highlightKeywords()
	 */
	protected function highlightKeywords($string) {
		$string = parent::highlightKeywords($string);
		// find tags
		$regex = new Regex('&lt;(?:/|\!|\?)?[a-z0-9]+(?:\s+'.self::XML_ATTRIBUTE_NAME.'(?:=[^\s/\?&]+)?)*(?:\s+/|\?)?&gt;', Regex::CASE_INSENSITIVE);
		$string = $regex->replace($string, new Callback(function ($matches) {
			// highlight attributes
			$tag = Regex::compile(XmlHighlighter::XML_ATTRIBUTE_NAME.'(?:=[^\s/\?&]+)?(?=\s|&)', Regex::CASE_INSENSITIVE)->replace($matches[0], '<span class="hlKeywords2">\\0</span>');
			
			// highlight tag
			return '<span class="hlKeywords1">'.$tag.'</span>';
		}));
		
		return $string;
	}
	
	/**
	 * Highlight CDATA-Tags as quotes.
	 *
	 * @see	wcf\system\bbcode\highlighter\Highlighter::cacheQuotes()
	 */
	protected function cacheQuotes($string) {
		$string = Regex::compile('<!\[CDATA\[.*?\]\]>', Regex::DOT_ALL)->replace($string, new Callback(function (array $matches) {
			return StringStack::pushToStringStack('<span class="hlQuotes">'.StringUtil::encodeHTML($matches[0]).'</span>', 'highlighterQuotes');
		}));
		
		$string = parent::cacheQuotes($string);
		
		return $string;
	}
}
