<?php
namespace wcf\system\bbcode;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Parses the [code] bbcode tag.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2011 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category 	Community Framework
 */
class CodeBBCode extends AbstractBBCode {
	/**
	 * Keeps track of used code-ids to prevent duplicate IDs in Output
	 * 
	 * @var	array<string>
	 */
	private static $codeIDs = array();

	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		if ($parser->getOutputType() == 'text/html') {	
			// encode html
			$content = self::trim($content);
			$content = StringUtil::encodeHTML($content);
			
			// show template
			WCF::getTPL()->assign(array(
				'lineNumbers' => self::makeLineNumbers($content, self::getLineNumbersStart($openingTag)),
				'content' => $content,
				'codeBoxName' => WCF::getLanguage()->get('wcf.bbcode.code.title')
			));
			return WCF::getTPL()->fetch('codeBBCodeTag', array(), false);
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return WCF::getLanguage()->getDynamicVariable('wcf.bbcode.code.text', array('content' => $content));
		}
	}
	
	/**
	 * Returns the preferred start of the line numbers.
	 * 
	 * @param	array		$openingTag
	 * @return	integer
	 */
	protected static function getLineNumbersStart(array $openingTag) {
		$start = 1;
		if (!empty($openingTag['attributes'][0])) {
			$start = intval($openingTag['attributes'][0]);
			if ($start < 1) $start = 1;
		}
		
		return $start;
	}
	
	/**
	 * Returns a string with all line numbers
	 * 
	 * @param	string		$code
	 * @param	integer		$start
	 * @return	string
	 */
	protected static function makeLineNumbers($code, $start, $split = "\n") {
		$lines = explode($split, $code);
		
		$lineNumbers = '';
		$i = -1;
		// find an unused codeID
		do {
			$codeID = StringUtil::substring(StringUtil::getHash($code), 0, 6).(++$i ? '_'.$i : '');
		}
		while(isset(self::$codeIDs[$codeID]));
		// mark codeID as used
		self::$codeIDs[$codeID] = true;
		
		for ($i = $start, $j = count($lines) + $start; $i < $j; $i++) {
			$lineID = 'codeLine_'.$i.'_'.$codeID;
			// insert $_SERVER['REQUEST_URI'] 'cause some browsers tend to prepend the base-href
			$lineNumbers .= '<a id="'.$lineID.'" href="'.$_SERVER['REQUEST_URI'].'#'.$lineID.'">'.$i."</a>\n";
		}
		return $lineNumbers;
	}
	
	/**
	 * Removes empty lines from the beginning and end of a string.
	 * 
	 * @param	string		$string
	 * @return	string
	 */
	protected static function trim($string) {
		$string = preg_replace('/^\s*\n/', '', $string);
		$string = preg_replace('/\n\s*$/', '', $string);
		return $string;
	}
}
