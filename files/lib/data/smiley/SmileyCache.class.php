<?php
namespace wcf\data\smiley;
use wcf\system\cache\builder\SmileyCacheBuilder;
use wcf\system\SingletonFactory;

/**
 * Manages the smiley cache.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley
 * @category	Community Framework
 */
class SmileyCache extends SingletonFactory {
	/**
	 * cached smilies
	 * @var	array
	 */
	protected $cachedSmilies = array();
	
	/**
	 * cached smiley categories
	 * @var	array<wcf\data\smiley\category\SmileyCategory>
	 */
	protected $cachedCategories = array();
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		// get smiley cache
		$this->cachedSmilies = SmileyCacheBuilder::getInstance()->getData(array(), 'smilies');
		$this->cachedCategories = SmileyCacheBuilder::getInstance()->getData(array(), 'categories');
	}
	
	/**
	 * Returns all smilies.
	 * 
	 * @return	array
	 */
	public function getSmilies() {
		return $this->cachedSmilies;
	}
	
	/**
	 * Returns all smiley categories.
	 * 
	 * @return	array<wcf\data\smiley\category\SmileyCategory>
	 */
	public function getCategories() {
		return $this->cachedCategories;
	}
	
	/**
	 * Returns all the smilies of a category.
	 * 
	 * @param	integer		$categoryID
	 * @return	array
	 */
	public function getCategorySmilies($categoryID = null) {
		if (isset($this->cachedSmilies[$categoryID])) return $this->cachedSmilies[$categoryID];
		
		return array();
	}
}
