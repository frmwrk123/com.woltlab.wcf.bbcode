<?php
namespace wcf\system\bbcode\highlighter;

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
	 * Highlights keywords.
	 */
	protected function highlightKeywords($string) {
		$string = preg_replace('!(\\\\(?:[a-z]+))(\\[[^\\]\\\\]+\\])?(\\{[^\\}]*\\})?!i', '<span class="hlKeywords3">\\1</span><span class="hlKeywords4">\\2</span><span class="hlKeywords1">\\3</span>', $string);
		$string = preg_replace('!\\\\\\\\!', '<span class="hlKeywords3">\\0</span>', $string);
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
