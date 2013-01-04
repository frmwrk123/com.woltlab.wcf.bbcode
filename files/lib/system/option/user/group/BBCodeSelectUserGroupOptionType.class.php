<?php
namespace wcf\system\option\user\group;
use wcf\data\option\Option;
use wcf\data\bbcode\BBCodeCache;
use wcf\system\option\AbstractOptionType;
use wcf\system\WCF;
use wcf\util\StringUtil;

/**
 * User group option type implementation for BBCode select lists.
 * 
 * @author	Matthias Schmidt
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.option
 * @category	Community Framework
 */
class BBCodeSelectUserGroupOptionType extends AbstractOptionType implements IUserGroupOptionType {
	/**
	 * available BBCodes
	 * @var	array<string>
	 */
	protected $bbCodes = null;
	
	/**
	 * @see	wcf\system\option\IOptionType::getData()
	 */
	public function getData(Option $option, $newValue) {
		if (!is_array($newValue)) {
			$newValue = array();
		}
		
		return implode(',', $newValue);
	}
	
	/**
	 * @see	wcf\system\option\IOptionType::getFormElement()
	 */
	public function getFormElement(Option $option, $value) {
		if ($this->bbCodes === null) {
			$this->loadBBCodeSelection();
		}
		
		$selectedBBCodes = array();
		if ($value == 'all') {
			$selectedBBCodes = $this->bbCodes;
		}
		else {
			$selectedBBCodes = explode(',', $value);
		}
		
		WCF::getTPL()->assign(array(
			'bbCodes' => $this->bbCodes,
			'option' => $option,
			'selectedBBCodes' => $selectedBBCodes
		));
		
		return WCF::getTPL()->fetch('bbCodeSelectOptionType');
	}
	
	/**
	 * Loads the list of BBCodes for the HTML select element.
	 * 
	 * @return	array<string>
	 */
	protected function loadBBCodeSelection() {
		$this->bbCodes = array();
		foreach (BBCodeCache::getInstance()->getBBCodes() as $tag => $bbCode) {
			$this->bbCodes[$tag] = $tag;
		}
		
		asort($this->bbCodes);
	}
	
	/**
	 * @see	wcf\system\option\user\group\IUserGroupOptionType::merge()
	 */
	public function merge($defaultValue, $groupValue) {
		if ($this->bbCodes === null) {
			$this->loadBBCodeSelection();
		}
		
		if ($defaultValue == 'all') {
			$defaultValue = $this->bbCodes;
		}
		else {
			$defaultValue = explode(',', StringUtil::unifyNewlines($defaultValue));
		}
		if ($groupValue == 'all') {
			$groupValue = $this->bbCodes;
		}
		else {
			$groupValue = explode(',', StringUtil::unifyNewlines($groupValue));
		}
		
		$result = array_diff($groupValue, $defaultValue);
		if (empty($result)) {
			return null;
		}
		
		return implode(',', $result);
	}
	
	/**
	 * @see	wcf\system\option\IOptionType::validate()
	 */
	public function validate(Option $option, $newValue) {
		if (!is_array($newValue)) {
			$newValue = array();
		}
		
		if ($this->bbCodes === null) {
			$this->loadBBCodeSelection();
		}
		
		foreach ($newValue as $tag) {
			if (!isset($this->bbCodes[$tag])) {
				throw new UserInputException($option->optionName, 'validationFailed');
			}
		}
	}
}
