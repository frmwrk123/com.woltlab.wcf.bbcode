<?php
namespace wcf\system\bbcode;
use wcf\data\bbcode\BBCodeCache;
use wcf\data\user\User;
use wcf\system\event\EventHandler;
use wcf\system\Callback;
use wcf\system\Regex;
use wcf\system\SingletonFactory;
use wcf\util\StringUtil;

/**
 * Parses message before inserting them into the database.
 * 
 * @author	Tim Duesterhus, Marcel Werk
 * @copyright	2001-2013 WoltLab GmbH
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.woltlab.wcf.bbcode
 * @subpackage	system.bbcode
 * @category	Community Framework
 */
class PreParser extends SingletonFactory {
	/**
	 * forbidden characters
	 * @var	string
	 */
	protected static $illegalChars = '[^\x0-\x2C\x2E\x2F\x3A-\x40\x5B-\x60\x7B-\x7F]+';
	
	/**
	 * regular expression for source codes
	 * @var	string
	 */
	protected $sourceCodeRegEx = '';
	
	/**
	 * cached codes
	 * @var	array
	 */
	public $cachedCodes = array();
	
	/**
	 * text
	 * @var	string
	 */
	public $text = '';
	
	/**
	 * @see	wcf\system\SingletonFactory::init()
	 */
	protected function init() {
		$sourceCodeTags = array();
		foreach (BBCodeCache::getInstance()->getBBCodes() as $bbcode) {
			// skip user bbcode, as we have to parse it
			if ($bbcode->isSourceCode && $bbcode->bbcodeTag != 'user') $sourceCodeTags[] = $bbcode->bbcodeTag;
		}
		if (!empty($sourceCodeTags)) $this->sourceCodeRegEx = implode('|', $sourceCodeTags);
	}
	
	/**
	 * Preparses the given text.
	 * 
	 * @param	string		$text
	 * @return	string
	 */
	public function parse($text) {
		$this->text = $text;
		
		// cache codes
		$this->cacheCodes();
		
		// call event
		EventHandler::getInstance()->fireAction($this, 'beforeParsing');
		
		
		$this->parseURLs();
		$this->parseEmails();
		$this->parseUserBBCodes();
		
		// call event
		EventHandler::getInstance()->fireAction($this, 'afterParsing');
		
		if (!empty($this->cachedCodes)) {
			// insert cached codes
			$this->insertCachedCodes();
		}
		
		return $this->text;
	}
	
	/**
	 * Handles pre-parsing of email addresses.
	 */
	protected function parseEmails() {
		if (StringUtil::indexOf($this->text, '@') === false) return;
		
		static $emailPattern = null;
		if ($emailPattern === null) {
			$emailPattern = new Regex('
			(?<!\B|"|\'|=|/|\]|,|:)
			(?:)
			\w+(?:[\.\-]\w+)*
			@
			(?:'.self::$illegalChars.'\.)+		# hostname
			(?:[a-z]{2,4}(?=\b))
			(?!"|\'|\[|\-|\.[a-z])', Regex::IGNORE_WHITESPACE | Regex::CASE_INSENSITIVE);
		}
	
		$this->text = $emailPattern->replace($this->text, '[email]\\0[/email]');
	}
	
	/**
	 * Handles pre-parsing of URLs.
	 */
	protected function parseURLs() {
		static $urlPattern = null;
		if ($urlPattern === null) {
			$urlPattern = new Regex('
			(?<!\B|"|\'|=|/|\]|,|\?)
			(?:						# hostname
				(?:ftp|https?)://'.static::$illegalChars.'(?:\.'.static::$illegalChars.')*
				|
				www\.(?:'.static::$illegalChars.'\.)+
				(?:[a-z]{2,4}(?=\b))
			)
		
			(?::\d+)?					# port
		
			(?:
				/
				[^!.,?;"\'<>()\[\]{}\s]*
				(?:
					[!.,?;(){}]+ [^!.,?;"\'<>()\[\]{}\s]+
				)*
			)?', Regex::IGNORE_WHITESPACE | Regex::CASE_INSENSITIVE);
		}
		
		$this->text = $urlPattern->replace($this->text, '[url]\\0[/url]');
	}
	
	/**
	 * Inserts the userID into the user bbcode.
	 */
	protected function parseUserBBCodes() {
		static $userRegex = null;
		if ($userRegex === null) {
			// the only one we do not get is a username that contains "[/user]". But who would name himself that way?
			$userRegex = new Regex('\[user\]([^,]+)\[/user\]', Regex::UNGREEDY);
		}
		
		$userRegex->match($this->text, true);
		$matches = $userRegex->getMatches();
		
		// remove duplicates, saves queries
		array_unique($matches[1]);
		foreach ($matches[1] as $match) {
			$user = User::getUserByUsername($match);
		
			if (!$user->userID) {
				// remove bbcode entirely
				$this->text = StringUtil::replace('[user]'.$match.'[/user]', $match, $this->text);
			}
			else {
				// insert userID
				$this->text = StringUtil::replace('[user]'.$match.'[/user]', '[user='.$user->userID.']'.$user->username.'[/user]', $this->text);
			}
		}
	}
	
	/**
	 * Caches code bbcodes to avoid parsing inside them.
	 */
	protected function cacheCodes() {
		if (!empty($this->sourceCodeRegEx)) {
			static $bbcodeRegex = null;
			static $callback = null;
			if ($bbcodeRegex === null) {
				$bbcodeRegex = new Regex("
				(\[(".$this->sourceCodeRegEx.")
				(?:=
					(?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^,\]]*)
					(?:,(?:\'[^\'\\\\]*(?:\\\\.[^\'\\\\]*)*\'|[^,\]]*))*
				)?\])
				(.*?)
				(?:\[/\\2\])", Regex::DOT_ALL | Regex::IGNORE_WHITESPACE | Regex::CASE_INSENSITIVE);
				
				$_this = $this;
				$callback = new Callback(function ($matches) use ($_this) {
					// create hash
					$hash = '@@'.StringUtil::getHash(uniqid(microtime()).$matches[0]).'@@';
					
					// save tag
					$_this->cachedCodes[$hash] = $matches[0];
					
					return $hash;
				});
			}
			
			$this->cachedCodes = array();
			$this->text = $bbcodeRegex->replace($this->text, $callback);
		}
	}
	
	/**
	 * Reinserts cached code bbcodes.
	 */
	protected function insertCachedCodes() {
		$this->text = strtr($this->text, $this->cachedCodes);
	}
}
