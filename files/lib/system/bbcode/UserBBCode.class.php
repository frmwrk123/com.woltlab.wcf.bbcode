<?php
namespace wcf\system\bbcode;
use wcf\data\user\User;
use wcf\system\request\LinkHandler;
use wcf\util\StringUtil;

/**
 * Parses the [user] bbcode tag.
 * 
 * @author	Tim Duesterhus
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category	Community Framework
 */
class UserBBCode extends AbstractBBCode {
	/**
	 * @see	wcf\system\bbcode\IBBCode::getParsedTag()
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) {
		$userID = intval(isset($openingTag['attributes'][0]) ? $openingTag['attributes'][0] : 0);
		
		if ($userID == 0) {
			$user = User::getUserByUsername($content);
			$userID = $user->userID;
			$username = $user->username;
		}
		else {
			$username = $content;
		}
		
		if ($parser->getOutputType() == 'text/html') {
			if (!$userID) return StringUtil::encodeHTML($content);
			
			$profile = LinkHandler::getInstance()->getLink('User', array(
				'id' => $userID,
				'title' => $username
			));
			
			return '<a href="'.StringUtil::encodeHTML($profile).'" class="userLink" data-user-id="'.$userID.'">'.StringUtil::encodeHTML($username).'</a>';
		}
		else if ($parser->getOutputType() == 'text/plain') {
			return $username;
		}
	}
}
