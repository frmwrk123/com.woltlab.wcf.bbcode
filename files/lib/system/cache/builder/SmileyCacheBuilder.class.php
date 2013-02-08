<?php
namespace wcf\system\cache\builder;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * Caches the smilies.
 * 
 * @author	Marcel Werk
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.cache.builder
 * @category	Community Framework
 */
class SmileyCacheBuilder extends AbstractCacheBuilder {
	/**
	 * @see	wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	protected function rebuild(array $parameters) {
		$data = array('categories' => array(), 'smilies' => array());
		
		// get categories
		$sql = "SELECT		smiley_category.*,
					(SELECT COUNT(*) AS count FROM wcf".WCF_N."_smiley WHERE smileyCategoryID = smiley_category.smileyCategoryID) AS smilies
			FROM		wcf".WCF_N."_smiley_category smiley_category
			ORDER BY	showOrder";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($object = $statement->fetchObject('wcf\data\smiley\category\SmileyCategory')) {
			$data['categories'][$object->smileyCategoryID] = $object;
		}
		
		// get smilies
		$sql = "SELECT		*
			FROM		wcf".WCF_N."_smiley
			ORDER BY	showOrder";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute();
		while ($object = $statement->fetchObject('wcf\data\smiley\Smiley')) {
			$object->smileyCodes = explode("\n", StringUtil::unifyNewlines($object->aliases));
			if ($object->smileyCodes[0] != '') $object->smileyCodes[] = $object->smileyCode;
			else $object->smileyCodes = array($object->smileyCode);
			
			$data['smilies'][$object->smileyCategoryID][$object->smileyID] = $object;
		}
		
		return $data;
	}
}
