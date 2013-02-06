<?php
namespace wcf\acp\form;
use wcf\data\bbcode\attribute\BBCodeAttribute;
use wcf\data\bbcode\attribute\BBCodeAttributeAction;
use wcf\data\bbcode\BBCode;
use wcf\data\bbcode\BBCodeAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

/**
 * Shows the bbcode edit form.
 * 
 * @author	Tim Duesterhus
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category	Community Framework
 */
class BBCodeEditForm extends BBCodeAddForm {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode';
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.canEditBBCode');
	
	/**
	 * bbcode id
	 * @var	integer
	 */
	public $bbcodeID = 0;
	
	/**
	 * bbcode object
	 * @var	wcf\data\bbcode\BBCode
	 */
	public $bbcodeObj = null;
	
	/**
	 * @see	wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->bbcodeID = intval($_REQUEST['id']);
		$this->bbcodeObj = new BBCode($this->bbcodeID);
		if (!$this->bbcodeObj->bbcodeID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	wcf\form\IForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// update bbcode
		$this->objectAction = new BBCodeAction(array($this->bbcodeID), 'update', array('data' => array(
			'bbcodeTag' => $this->bbcodeTag,
			'htmlOpen' => $this->htmlOpen,
			'htmlClose' => $this->htmlClose,
			'allowedChildren' => $this->allowedChildren,
			'isSourceCode' => (int) $this->isSourceCode,
			'className' => $this->className
		)));
		$this->objectAction->executeAction();
		
		// clear existing attributes
		$sql = "DELETE FROM	wcf".WCF_N."_bbcode_attribute
			WHERE		bbcodeID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array($this->bbcodeID));
		
		foreach ($this->attributes as $attribute) {
			$attributeAction = new BBCodeAttributeAction(array(), 'create', array('data' => array(
				'bbcodeID' => $this->bbcodeID,
				'attributeNo' => $attribute->attributeNo,
				'attributeHtml' => $attribute->attributeHtml,
				'validationPattern' => $attribute->validationPattern,
				'required' => $attribute->required,
				'useText' => $attribute->useText,
			)));
			$attributeAction->executeAction();
		}
		
		$this->saved();
		
		// show success
		WCF::getTPL()->assign(array(
			'success' => true
		));
	}
	
	/**
	 * @see	wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();
		
		if (empty($_POST)) {
			$this->attributes = BBCodeAttribute::getAttributesByBBCode($this->bbcodeObj);
			$this->bbcodeTag = $this->bbcodeObj->bbcodeTag;
			$this->htmlOpen = $this->bbcodeObj->htmlOpen;
			$this->htmlClose = $this->bbcodeObj->htmlClose;
			$this->allowedChildren = $this->bbcodeObj->allowedChildren;
			$this->isSourceCode = $this->isSourceCode;
			$this->className = $this->bbcodeObj->className;
		}
	}
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'bbcodeID' => $this->bbcodeID,
			'action' => 'edit'
		));
	}
}
