<?php
namespace wcf\data\smiley\category;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\WCF;

/**
 * Executes smiley category-related actions.
 * 
 * @author	Alexander Ebert
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.smiley.category
 * @category	Community Framework
 */
class SmileyCategoryAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\smiley\category\SmileyCategoryEditor';
	
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$allowGuestAccess
	 */
	protected $allowGuestAccess = array('getSmilies');
	
	/**
	 * active smiley category
	 * @var	wcf\data\smiley\category\SmileyCategory
	 */
	public $smileyCategory = null;
	
	/**
	 * Validates smiley category id.
	 */
	public function validateGetSmilies() {
		$this->smileyCategory = $this->getSingleObject();
	}
	
	/**
	 * Returns parsed template for smiley category's smilies.
	 * 
	 * @return	array
	 */
	public function getSmilies() {
		$this->smileyCategory->loadSmilies();
		
		WCF::getTPL()->assign(array(
			'smilies' => $this->smileyCategory->getDecoratedObject()
		));
		
		return array(
			'smileyCategoryID' => $this->smileyCategory->smileyCategoryID,
			'template' => WCF::getTPL()->fetch('__messageFormSmilies')
		);
	}
}
