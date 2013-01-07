<?php
namespace wcf\acp\form;
use wcf\data\bbcode\media\provider\BBCodeMediaProvider;
use wcf\data\bbcode\media\provider\BBCodeMediaProviderAction;
use wcf\form\AbstractForm;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

/**
 * Shows the BBCode media provider edit form.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.form
 * @category	Community Framework
 */
class BBCodeMediaProviderEditForm extends BBCodeMediaProviderAddForm {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode';
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.canEditBBCodeMediaProvider');
	
	/**
	 * media-provider id
	 * @var	integer
	 */
	public $providerID = 0;
	
	/**
	 * media-provider object
	 * @var	wcf\data\bbcode\media\provider\BBCodeMediaProvider
	 */
	public $mediaProviderObj = null;
	
	/**
	 * @see	wcf\page\IPage::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['id'])) $this->providerID = intval($_REQUEST['id']);
		$this->mediaProviderObj = new BBCodeMediaProvider($this->providerID);
		if (!$this->mediaProviderObj->providerID) {
			throw new IllegalLinkException();
		}
	}
	
	/**
	 * @see	wcf\form\IForm::save()
	 */
	public function save() {
		AbstractForm::save();
		
		// update media-provider
		$this->objectAction = new BBCodeMediaProviderAction(array($this->providerID), 'update', array('data' => array(
			'title' => $this->title,
			'regex' => $this->regex,
			'html' => $this->html
		)));
		$this->objectAction->executeAction();
		
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
			$this->title = $this->mediaProviderObj->title;
			$this->regex = $this->mediaProviderObj->regex;
			$this->html = $this->mediaProviderObj->html;
		}
	}
	
	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'providerID' => $this->providerID,
			'action' => 'edit'
		));
	}
}
