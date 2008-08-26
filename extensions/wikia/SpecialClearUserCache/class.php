<?php

/**
 * Class definition file for the special page to clear user cache
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Przemek Piotrowski <ppiotr@wikia.com>
 * @copyright
 * @licence
 */

class ClearUserCache extends SpecialPage
{
	protected $debug = array();

	public function __construct()
	{
		parent::__construct('ClearUserCache', 'checkuser');
		self::loadMessages();
	}

	public function execute($params)
	{
		global $wgUser;
		if (!$wgUser->isAllowed('checkuser'))
		{
			$this->displayRestrictionError();
			return false;
		}

		$params =& $this->parseParams();
		$this->clearCache($params['uid']);
		$this->setOutput();

		return true;
	}

	protected function parseParams()
	{
		$params = array
		(
			'username' => '',
			'uid'      => 0,
		);

		global $wgRequest;

		$username = $wgRequest->getText('username');
		$username =  Title::newFromText( $username );
		if (is_object($username))
		{
			$params['username'] = $username->getText();
			$params['uid']      = User::idFromName($params['username']);
		}

		return $params;
	}
	
	protected function clearCache($uid)
	{
		global $wgMemc;

		$db =& wfGetDB(DB_SLAVE);
		$sql = "SELECT city_dbname FROM wikicities.city_list;";
		$res =& $db->query($sql);

		while ($row =& $db->fetchObject($res))
		{
			$key =  wfForeignMemcKey($row->city_dbname, null, 'user', 'id', $uid);
			if ($wgMemc->delete($key))
			{
				$this->debug[] = "Key {$key} deleted.";
			}
		}

		$db->freeResult($res);

		return true;
	}

	protected function setOutput()
	{
		$this->setHeaders();
	
		global $wgOut;

		$wgOut->addHtml('<form method="POST"><input name="username"/><input type="submit"></form>');

		if ($this->debug)
		{
			$wgOut->addHtml('<p><small>' . join('<br/>', $this->debug) . '</small></p>');
		}

	}

	static function loadMessages()
	{
		static $messagesLoaded = false;
		if ($messagesLoaded)
		{
			return;
		} else
		{
			$messagesLoaded = true;
		}

		global $wgMessageCache;

		require_once dirname(__FILE__) . '/i18n.php';
		foreach ($allMessages as $lang => $messages)
		{
			$wgMessageCache->addMessages($messages, $lang);
		}
	}
}

?>
