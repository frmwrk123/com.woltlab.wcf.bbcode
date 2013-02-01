<?php
namespace wcf\system\bbcode\highlighter;
use wcf\system\Regex;

/**
 * Highlights syntax of TeX source code.
 * 
 * @author	Tim Duesterhus
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode.highlighter
 * @category	Community Framework
 */
class TexHighlighter extends Highlighter {
	// highlighter syntax
	protected $quotes = array();
	protected $singleLineComment = array('%');
	
	/**
	 * @see wcf\system\bbcode\highlighter\Highlighter::highlightKeywords()
	 */
	protected function highlightKeywords($string) {
		$string = Regex::compile('(\\\\(?:[a-z]+))(\\[[^\\]\\\\]+\\])?(\\{[^\\}]*\\})?', Regex::CASE_INSENSITIVE)->replace($string, '<span class="hlKeywords3">\\1</span><span class="hlKeywords4">\\2</span><span class="hlKeywords1">\\3</span>');
		$string = str_replace('\\\\', '<span class="hlKeywords3">\\\\</span>', $string);
		
		return $string;
	}
	
	/**
	 * @see wcf\system\bbcode\highlighter\Highlighter::highlightNumbers()
	 */
	protected function highlightNumbers($string) {
		// do not highlight numbers
		return $string;
	}
}
