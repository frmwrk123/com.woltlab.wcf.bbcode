<?php
namespace wcf\acp\page;
use wcf\page\SortablePage;

/**
 * Lists the available BBCodes.
 * 
 * @author	Tim Duesterhus
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.page
 * @category	Community Framework
 */
class BBCodeListPage extends SortablePage {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.list';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$defaultSortField
	 */
	public $defaultSortField = 'bbcodeTag';
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.canEditBBCode', 'admin.content.bbcode.canDeleteBBCode');
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\bbcode\BBCodeList';
	
	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'bbcodeList';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$validSortFields
	 */
	public $validSortFields = array('bbcodeID', 'bbcodeTag', 'className');
}
