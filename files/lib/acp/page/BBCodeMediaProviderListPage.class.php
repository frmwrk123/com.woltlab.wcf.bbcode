<?php
namespace wcf\acp\page;
use wcf\page\SortablePage;

/**
 * Lists available media-providers
 * 
 * @author	Tim Düsterhus
 * @copyright	2011 - 2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.page
 * @category	Community Framework
 */
class BBCodeMediaProviderListPage extends SortablePage {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.acp.menu.link.bbcode.mediaprovider.list';
	
	/**
	 * @see	wcf\page\AbstractPage::$templateName
	 */
	public $templateName = 'bbcodeMediaProviderList';
	
	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('admin.content.bbcode.mediaprovider.canEditMediaProvider', 'admin.content.bbcode.mediaprovider.canDeleteMediaProvider');
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\bbcode\media\MediaProviderList';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$defaultSortField
	 */
	public $defaultSortField = 'title';
	
	/**
	 * @see	wcf\page\MultipleLinkPage::$validSortFields
	 */
	public $validSortFields = array('providerID', 'title');
}
