<?php
namespace wcf\data\bbcode;
use wcf\system\cache\builder\BBCodeCacheBuilder;
use wcf\system\SingletonFactory;

/**
 * Manages the bbcode cache.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode
 * @category	Community Framework
 */
class BBCodeCache extends SingletonFactory {
	/**
	 * cached bbcodes
	 * @var	array<wcf\data\bbcode\BBCode>
	 */
	protected $cachedBBCodes = array();
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		// get bbcode cache
		$this->cachedBBCodes = BBCodeCacheBuilder::getInstance()->getData();
	}
	
	/**
	 * Returns all bbcodes.
	 * 
	 * @return	array<wcf\data\bbcode\BBCode>
	 */
	public function getBBCodes() {
		return $this->cachedBBCodes;
	}
	
	/**
	 * Returns all attributes of a bbcode.
	 * 
	 * @param	string		$tag
	 * @return	array<wcf\data\bbcode\attribute\BBCodeAttribute>
	 */
	public function getBBCodeAttributes($tag) {
		return $this->cachedBBCodes[$tag]->getAttributes();
	}
}
