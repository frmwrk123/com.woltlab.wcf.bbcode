<?php
namespace wcf\data\bbcode\media\provider;
use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\cache\CacheHandler;

/**
 * Provides functions to edit BBCode media providers.
 * 
 * @author	Tim Düsterhus
 * @copyright	2011-2012 Tim Düsterhus
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	data.bbcode.media.provider
 * @category	Community Framework
 */
class BBCodeMediaProviderEditor extends DatabaseObjectEditor implements IEditableCachedObject {
	/**
	 * @see	wcf\data\DatabaseObjectDecorator::$baseClass
	 */
	public static $baseClass = 'wcf\data\bbcode\media\provider\BBCodeMediaProvider';
	
	/**
	 * @see	wcf\data\IEditableCachedObject::resetCache()
	 */
	public static function resetCache() {
		CacheHandler::getInstance()->clear(WCF_DIR.'cache', 'cache.bbcodeMediaProvider.php');
	}
}
