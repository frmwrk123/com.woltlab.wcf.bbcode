<?php
namespace wcf\acp\action;
use wcf\action\AbstractAction;
use wcf\system\exception\SystemException;
use wcf\system\Regex;
use wcf\system\WCF;
use wcf\util\JSON;
use wcf\util\StringUtil;

/**
 * Validates the regex for BBCodeMediaProviderAddForm
 *
 * @author	Tim Duesterhus
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	acp.action
 * @category	Community Framework
 */
class BBCodeMediaProviderValidateRegexAction extends AbstractAction {
	/**
	 * @see	wcf\action\AbstractAction::$loginRequired
	 */
	public $loginRequired = true;
	
	/**
	 * regular expression
	 * @var	string
	 */
	public $regex = '';
	
	/**
	 * test url
	 * @var	string
	 */
	public $url = '';
	
	/**
	 * @see	wcf\action\IAction::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['regex'])) $this->regex = StringUtil::trim($_REQUEST['regex']);
		if (isset($_REQUEST['url'])) $this->url = StringUtil::trim($_REQUEST['url']);
	}
	
	/**
	 * @see	wcf\action\IAction::execute()
	 */
	public function execute() {
		parent::execute();
		
		@header('Content-type: application/json');
		try {
			$lines = explode("\n", StringUtil::unifyNewlines($this->regex));
			
			foreach ($lines as $line) {
				$regex = new Regex($line);
				if (!$regex->match($this->url)) continue;
				$matches = $regex->getMatches();
				
				foreach ($matches as $key => $match) {
					if (is_int($key)) {
						unset($matches[$key]);
					}
				}
				
				echo JSON::encode($matches);
				
				$this->executed();
				exit;
			}
			
			echo JSON::encode(array(
				'_error' => 'noMatch'
			));
		}
		catch (SystemException $e) {
			echo JSON::encode(array(
				'_error' => 'invalid'
			));
		}
		
		$this->executed();
		exit;
	}
}
