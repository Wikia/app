<?

/**
 * @package MediaWiki
 * @subpackage WikiaEvents
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiEvents.\n";
    exit( 1 ) ;
}

$wgHookEvents = array();

define ("COOKIE_EVENT_NAME", 'wkSystemEventsDisplay');
define ("COOKIE_EVENTS", 'wkSystemEventsCookie');
define ("DEFAULT_COOKIE_VALUE", 1000000);
define ("DEFAULT_COOKIE_EXPIRE_TIME", 2592000);

class WikiaEventsConditions
{
	var $event = null;	
	var $basicKey = null;
	var $systemMsg = null;
	var $eventName = null;
	var $eventUsers = null;
	#---
	var $dbev = null;
	
	/*
	 * contructor 
	 */
	function __construct($event_id = 0)
	{
		#---
		wfProfileIn( __METHOD__ );
		
		$this->event = $event_id;
		$this->basicKey = 'events';
		#---
		$this->systemMsg = array();
		$this->systemMsg[$this->basicKey] = array();
		
		#---
		$this->dbev = new WikiaEventsDBConditions($event_id);
		
		wfProfileOut( __METHOD__ );
	}

	/*
	 */
	public function getEventId()
	{
		return $this->event;
	}	

	/*
	 */
	public function setEventId($event_id)
	{
		$this->event = $event_id;
	}	
	
	/*
	 * get event's types
	 */
	static public function getEventTypes()
	{
		return WikiaEventsDBConditions::getEventTypes();
	}

	/*
	 * get event's texts
	 */
	static public function getEventAllTexts($type = 0)
	{
		return WikiaEventsDBConditions::getEventAllTexts($type);
	}
	
	/*
	 * change user's counter 
	 */
	static public function changeEventsCounter($event_id, $event_type, $set_active = 1)
	{
		return WikiaEventsDBConditions::startUserEventsCounter($event_id, $event_type, $set_active);
	}
	
	/*
	 * check if message should be shown user
	 */
	public function executeCondition($after_pause = 0)
	{
		global $wgEnableSystemEvents;
		#---
		$after_pause = (empty($after_pause)) ? 0 : $after_pause;
		#---		
		if (empty($wgEnableSystemEvents))
		{
			return false;
		}
		#---
		$needSelect = false;
		#---
		$this->eventUsers = $this->dbev->getEventsUser(false, $after_pause);
		#---
		if (empty($this->eventUsers))
		{
			$needSelect = true;
			$result = $this->dbev->addEventForUser($needSelect);
			if ($result !== false)
			{
				$this->eventUsers = $result;
			}
		}
		#---
		$this->parseEventMessages();
	}
	
	/*
	 * get message(s) from database by event id (and selected event's type if defined)
	 */	
	public function getMessagesByEventId($event_type = 0)
	{
		wfProfileIn( __METHOD__ );

		$eventText = $this->dbev->getEventText($event_type);
		
		wfProfileOut( __METHOD__ );
		return $eventText;
	}

	/*
	 * set event message array or send email or ....
	 */
	private function parseEventMessages()
	{
		global $wgMessageCache, $wgOut;
		global $wgSystemEventSetup;
		#---
		wfProfileIn( __METHOD__ );
		#---
		$result = false;
		//
		if ( (!empty($this->eventUsers[$this->event])) && (is_array($this->eventUsers[$this->event])) )
		{
			foreach ($this->eventUsers[$this->event] as $event_type => $userEvents)
			{
				if ( !is_array($userEvents) )
				{
					continue;
				}
				#---
				if ( empty($userEvents['active']) )
				{
					continue;
				}
				#---
				switch ($event_type) 
				{
					case 1: /* MessageBox */
					{
						if ($userEvents['cnt'] > $wgSystemEventSetup['DisplayLength'])
						{
							#--- user didn't click on event - so switch off event's message
							#--- and save that information to db
							$this->dbev->updateUserEvents($event_type, 0);
							$this->dbev->addUserEventAction($event_type, 'no_action');
						}
						else
						{
							// do it?
							//$this->dbev->updateUserEvents($event_type, 1);
						}
						break;
					}
					case 2: /* Email */
					{
						if ($userEvents['cnt'] >= $wgSystemEventSetup['EmailsCount'])
						{
							$this->dbev->updateUserEvents($event_type, 0, 0); #--- such situation is not possible, but ... :-)
						}
						else
						{
							//send email and update counter
							$this->dbev->updateUserEvents($event_type, 0, 0);
						}
						break;
					}
				}
			}
		}
		else
		{
			#--- no events for this user and event's type - so should be added
		}
		
		wfProfileOut( __METHOD__ );
		//
		return $this->systemMsg;
	}
	
	/*
	 * switch off messages ...
	 */
	private function disableEventMessages()
	{
		global $wgMessageCache, $wgOut;
		#---
		wfProfileIn( __METHOD__ );
		#---
		$result = false;
		//
		if ( (!empty($this->eventUsers[$this->event])) && (is_array($this->eventUsers[$this->event])) )
		{
			foreach ($this->eventUsers[$this->event] as $event_type => $userEvents)
			{
				if ( !is_array($userEvents) )
				{
					return false;
				}
				#---
				if ( $userEvents['active'] )
				{
					#---
					$this->dbev->updateUserEvents($event_type, 0);
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		//
		return $this->systemMsg;
	}

	#---
	static public function setDisplayOptions($option = "title")
	{
		global $wgSystemEventSetup;
		#---
		wfProfileIn( __METHOD__ );
		#---
		$text_style = array();
		$text = "";
		#---
		switch ($option)
		{
			case 'title' : 
			{
				if ($wgSystemEventSetup['TitleBold'] == true) {
					$text_style[] = "font-weight:bold";
				}
				if ($wgSystemEventSetup['TitleItalic'] == true) {
					$text_style[] = "font-style:italic";
				}
				if ($wgSystemEventSetup['TitleUnderline'] == true) {
					$text_style[] = "text-decoration:underline";
				}
				break;
			}
			case 'content'	:
			{
				if ($wgSystemEventSetup['ContentBold'] == true) {
					$text_style[] = "font-weight:bold";
				}
				if ($wgSystemEventSetup['ContentItalic'] == true) {
					$text_style[] = "font-style:italic";
				}
				if ($wgSystemEventSetup['ContentUnderline'] == true) {
					$text_style[] = "text-decoration:underline";
				}
				break;
			}
		}
		
		#---
		$text = "<font style=\"".implode(";", $text_style)."\">%s</font>";
		#---
		
		wfProfileOut( __METHOD__ );
		
		return $text;
	}
	
	public function switchOffMessage()
	{
		$this->eventUsers = $this->dbev->getEventsUser(false);
		#---
		$this->disableEventMessages();
	}

	/*
	 * get article's contributors
	 */	
	public function checkIsArticleContributor($user, $article_id = 0)
	{
		wfProfileIn( __METHOD__ );

		$result = false;
		
		if ($article_id > 0)
		{
			$res = $this->dbev->checkIsArticleContributorDB($user, $article_id);
			$result = ($res == -1) ? false : true;
		}
		
		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	/*
	 * check number of user's votes
	 */
	public function getUserCountVotes($user_id)
	{
		return $this->dbev->getUserCountVotesDB($user_id);
	}
	
	/*
	 * 
	 * Cookies functions
	 * 
	 */ 
	private function setDataValue($value) 
	{
		global $wgOut;
		#---
		wfProfileIn( __METHOD__ );
		$this->systemMsg[$this->basicKey][$this->eventKey] = $value;
		
		wfProfileOut( __METHOD__ );
		return $this->systemMsg;
	}
	 
	private function isCookieEventSet()
	{
		wfProfileIn( __METHOD__ );
	 	$val = $_COOKIE[COOKIE_EVENT_NAME] & (1 << $this->event);
	 	$result = true;
	 	#---
	 	if ($val == 0) {
	 		$result = false;
		} else {
	 		setcookie(COOKIE_EVENTS."[".$this->event."]", 0, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
	 		if ( (int)$_COOKIE[COOKIE_EVENTS]['display'] == $this->event )
	 		{ 
	 			setcookie(COOKIE_EVENTS."[display]", 0, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
			}
			$result = true;
		}
		wfProfileOut( __METHOD__ );
		#---
		return $result;
	}
	 
	private function isCookieDisplay()
	{
		global $wgSystemEventSetup;
		
		wfProfileIn( __METHOD__ );
	 	//
	 	$result = true;
	 	if (isset($_COOKIE[COOKIE_EVENTS])) {
	 		if ( isset($_COOKIE[COOKIE_EVENTS][$this->event]) && ($_COOKIE[COOKIE_EVENTS]['display'] == $this->event ) ) {
	 			$val = $_COOKIE[COOKIE_EVENTS][$this->event];
	 			#---
	 			
				if ( $val < $wgSystemEventSetup['DisplayLength'] ) {
	 				$val++; setcookie(COOKIE_EVENTS."[".$this->event."]", $val, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
				} else {
					$val = $_COOKIE[COOKIE_EVENT_NAME] & (1 << $this->event);
					if ($val == 0) {
						#---
						$val = $_COOKIE[COOKIE_EVENT_NAME] | (1 << $this->event);
						setcookie(COOKIE_EVENT_NAME, $val, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
						#---
						setcookie(COOKIE_EVENTS."[".$this->event."]", DEFAULT_COOKIE_VALUE, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
						setcookie(COOKIE_EVENTS."[display]", 0, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
						$this->saveSystemStatToDB($this->event, "1", "no_action");
						$result = false;
					}
				}
			} else {
				if ( isset($_COOKIE[COOKIE_EVENTS]['display']) && ((int)($_COOKIE[COOKIE_EVENTS]['display']) > 0) )
					$result = false;
				else {
					setcookie(COOKIE_EVENTS."[display]", $this->event, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
					setcookie(COOKIE_EVENTS."[".$this->event."]", 1, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
				}
			}
		} else {
			setcookie(COOKIE_EVENTS, 0, time() + DEFAULT_COOKIE_EXPIRE_TIME, "/");
		}
		#---
		wfProfileOut( __METHOD__ );
		return $result;
	}	 
	 
	static public function setAjaxHiddenElements(&$events, $type)
	{
		global $wgOut;
		wfProfileIn( __METHOD__ );
		
		#---
		$text = "<input type=\"hidden\" id=\"eventName\" value=\"".$events['id']."\">";
		$text .= "<input type=\"hidden\" id=\"eventType\" value=\"".$type."\">";
		#---
		if ( !empty($events['message']) ) 
		{
			$events['message'] .= $text;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	static public function setAjaxListenerElements(&$text, $event_type, $event_id)
	{
		global $wgSystemEventSetup;
		
		wfProfileIn( __METHOD__ );
		#---
		$listener = array();
		$result = "";
		#---
		$captures = array();
		#---
		$color = ($wgSystemEventSetup['LinkColor']) ? "style=\"color:".$wgSystemEventSetup['LinkColor']."\"" : "";
		if (!empty($text)) 
		{
			if (preg_match_all('#href\s*?=\s*?[\'"]?([^\'" ]*)[\'"]?.*?title\s*?=\s*?[\'"]?([^\'"]*)[\'"]?#i', $text, $captures)) 
			{
				foreach ($captures[0] as $id => $link)
				{
					if ( !empty($captures[2][$id]) ) 
					{
						$captures[2][$id] = preg_replace('/\s/', '_', $captures[2][$id]);
						$text = str_replace($link, $link." id=\"".$captures[2][$id]."\" {$color}", $text);
						if ($event_type == 1) // MessageBox ...
						{
							$listener[] = "YAHOO.util.Event.addListener(\"".$captures[2][$id]."\", \"click\", wikiaClickEventMessageBox, {id:'".$captures[2][$id]."', event_id: '$event_id', type_id: '$event_type'});";
						}
					}
				}
			}
		}
		
		#---
		if (!empty($listener)) 
		{
			$result = implode("\n", $listener);
		}
		#---

		wfProfileOut( __METHOD__ );
		#---
		return $result;		
	}
	 
    static public function displayMessage($userMessages)
    {
    	global $wgSystemEventSetup;
    	
        wfProfileIn( __METHOD__ );

		$user_messages = "";
		$loop = 0;

		if ( (!empty($userMessages)) && (is_array($userMessages)) )
		{
			foreach ($userMessages as $message)
			{
				#--- title
				$ajaxListener = "";
				if (isset($message['title']))
				{
					$msg_title = $message['title'];
					$ajaxListener .= self::setAjaxListenerElements($msg_title, $message['event'], $message['event_id']);
					$to_display[$message['event_id']][0] = sprintf($message['title_style'], $msg_title);
					$loop++;
				}
				#--- content
				if (isset($message['content']))
				{
					$msg_content = $message['content'];
					$ajaxListener .= self::setAjaxListenerElements($msg_content, $message['event'], $message['event_id']);
					$to_display[$message['event_id']][1] = sprintf($message['content_style'], $msg_content);
					$loop++;
				}
			}			
		}
		#---
		if (!empty($loop) && (!empty($to_display))) 
		{
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
				array(
					'text_display' => $to_display,
					'js_display' => $ajaxListener,
					'setup' => $wgSystemEventSetup
				)
			);
			#---
			$user_messages = $oTmpl->execute("events-display-msg");
		}

		wfProfileOut( __METHOD__ );
		return $user_messages;
    }
	 
}

/*
 * 
 */
class WikiaEventsDBConditions 
{
	const MEMKEY_TIME = 60;
	
	var $event = null;
	
	/*
	 * contructor 
	 */
	function __construct($event_id)
	{
		wfProfileIn( __METHOD__ );
		#---
		$this->event = $event_id;
		#---
		wfProfileOut( __METHOD__ );
	}
	
	private function getMemKey($fname)
	{
		return $fname . "::" . $this->event;
	}

	/*
	 * 
	 */
	public function getEventText($type = 0) 
	{
		wfProfileIn( __METHOD__ );
		#---
		$fname = 'WikiaEventsDBConditions::getEventText::'.$type;
		#---
		$evMessages = array();
		#---
        $oMemc = wfGetCache(CACHE_MEMCACHED);
        $key = $this->getMemKey($fname);
        #---
        if ( !($evMessages = $oMemc->get($key)) )
        {
			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$where = " te_ev_id = " . $dbr->addQuotes($this->event);
			#---
			if (!empty($type))
			{
				$where .= " and te_et_id = " . $dbr->addQuotes($type) . " ";
			}
			#---
			$sql = "SELECT te_id, te_title, te_content, te_et_id as type from ".SYSTEM_EVENTS_TEXT." where {$where}";
			$res = $dbr->query($sql);
			#---
			$evMessages = array();
			while ( $row = $dbr->fetchObject( $res ) )
			{ 
				$evMessages[$row->type]['id'] = $row->te_id;
				#---		
				$evMessages[$row->type]['title'] = ( !empty($row->te_title) ) ? $row->te_title : "";
				#---
				$evMessages[$row->type]['content'] = ( !empty($row->te_content) ) ? $row->te_content : "";
			}
			$dbr->freeResult ($res);
			#---
			$oMemc->set($key, $evMessages, self::MEMKEY_TIME);
		}

		#---
		wfProfileOut( __METHOD__ );
		return $evMessages;
	}	
	
	/*
	 * get event's types
	 */
	static public function getEventTypes()
	{
		wfProfileIn( __METHOD__ );
		#---
		$fname = 'WikiaEventsDBConditions::getEventTypes';
		#---
		$evTypes = array();
		#---
        $oMemc = wfGetCache(CACHE_MEMCACHED);
        #---
        if ( !($evTypes = $oMemc->get($fname)) )
        {
			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$where = " et_active = 1 ";
			#---
			$sql = "SELECT et_id as id, et_name as name from ".SYSTEM_EVENTS_TYPES." where {$where}";
			$res = $dbr->query($sql);
			#---
			$evTypes = array();
			while ( $row = $dbr->fetchObject( $res ) )
			{ 
				$evTypes[$row->id] = $row->name;
			}
			$dbr->freeResult ($res);
			#---
			$oMemc->set($fname, $evTypes, self::MEMKEY_TIME);
		}

		#---
		wfProfileOut( __METHOD__ );
		return $evTypes;
	}

	/*
	 * get all event's texts
	 */
	static public function getEventAllTexts($type = 0)
	{
		wfProfileIn( __METHOD__ );
		#---
		$fname = 'WikiaEventsDBConditions::getEventAllTexts::'.$type;
		#---
		$evTexts = array();
		#---
        $oMemc = wfGetCache(CACHE_MEMCACHED);
        #---
        if ( !($evTexts = $oMemc->get($fname)) )
        {
			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$where = (!empty($type)) ? " 1=1 " : " te_et_id = '".$type."' ";
			#---
			$sql = "SELECT te_ev_id as event, te_title as title, te_content as content from ".SYSTEM_EVENTS_TEXT." where {$where}";
			$res = $dbr->query($sql);
			#---
			$evTexts = array();
			while ( $row = $dbr->fetchObject( $res ) )
			{ 
				$evTexts[$row->event] = array('title' => $row->title, 'content' => $row->content);
			}
			$dbr->freeResult ($res);
			#---
			$oMemc->set($fname, $evTexts, self::MEMKEY_TIME);
		}

		#---
		wfProfileOut( __METHOD__ );
		return $evTexts;
	}
	
	/*
	 * 
	 */
	public function getEventsUser($useMemc = true, $after_pause = 0)
	{
		global $wgUser;
		wfProfileIn( __METHOD__ );		
		#---
		$fname = 'WikiaEventsDBConditions::getEventsUser::'.$wgUser->getName().'::'.$this->event;
		#---
		$evUsers = array();
		#---
        $oMemc = wfGetCache(CACHE_MEMCACHED);
        $key = $this->getMemKey($fname);
        #---
        if ($useMemc)
        {
        	$evUsers = $oMemc->get($key);
		}
		#---
        if ( empty($evUsers) )
        {
			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$where = " eu_ev_id = " . $dbr->addQuotes($this->event);
			#$where .= " and eu_active = 1 ";
			#---
			if ($wgUser->getID() == 0)
			{
				$ip = wfGetIP();
				$where .= " and eu_user_ip = " . $dbr->addQuotes($ip);
			}
			else
			{
				$where .= " and eu_user_id = " . $dbr->addQuotes($wgUser->getID());
			}
			#---
			$sql = "SELECT eu_ev_id as event, eu_et_id as type, eu_user_id as user_id, eu_user_ip as user_ip, eu_visible_count as cnt, eu_active as active from ".SYSTEM_EVENTS_USERS." where {$where}";
			$res = $dbr->query($sql);
			#---
			$evUsers = array();
			while ( $row = $dbr->fetchObject( $res ) )
			{ 
				$evUsers[$row->event][$row->type] = array(
								'id' => $row->event,
								'type' => $row->type,
								'user_id' => $row->user_id,
								'user_ip' => $row->user_ip,
								'cnt' => $row->cnt,
								'active' => ( (!empty($after_pause)) && ($row->type == 1) ) ? 1 : $row->active,
								);
			}
			$dbr->freeResult ($res);
			#---
			if ($useMemc)
			{
				$oMemc->set($key, $evUsers, self::MEMKEY_TIME);
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return $evUsers;
	}

	/*
	 * 
	 */	
	public function addEventForUser($needSelect = false)
	{
		global $wgUser;
		#---
		wfProfileIn( __METHOD__ );
		#---
		$result = true;
		#---
		if ( empty($this->event) ) {
			return false;
		}
		#---
		$CityId = $this->getCityId();
		if (empty($CityId)) {
			return false;
		}
		#---
		$evTypes = self::getEventTypes();
		#---
		$user_id = $wgUser->getID();
		$user_id = (!empty($user_id)) ? $user_id : 0;
		$ip = wfGetIP();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		#---
		foreach ($evTypes as $evId => $evName)
		{
			$sql = "INSERT INTO ".SYSTEM_EVENTS_USERS." (eu_id, eu_city_id, eu_ev_id, eu_et_id, eu_user_id, eu_user_ip, eu_visible_count, eu_active, eu_timestamp) values ";
			$sql .= "(null,".$dbr->addQuotes($CityId).",".$dbr->addQuotes($this->event).",".$dbr->addQuotes($evId).",".$dbr->addQuotes($user_id).",".$dbr->addQuotes($ip).",0,1,".$dbr->addQuotes(wfTimestampNow()).")";
			#---
			$res = $dbr->query($sql);
			$id = ($res) ? $dbr->insertId() : false;
			#---
			if ($id === false)
			{
				$result = false;
				break;
			}
		}
	
		if ($needSelect && $result)
		{
			$result = $this->getEventsUser(false);
		}

		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	/*
	 * 
	 */
	public function addUserEventAction($event_type, $event_field)
	{
		global $wgUser;
		#---
		wfProfileIn( __METHOD__ );
		#---
		if ( empty($this->event) ) {
			return false;
		}
		#---
		if ( empty($event_type) || empty($event_field) ) {
			return false;
		}
		#---
		$CityId = $this->getCityId();
		if (empty($CityId)) {
			return false;
		}

		$user_id = $wgUser->getID();
		$user_id = (!empty($user_id)) ? $user_id : 0;
		$ip = wfGetIP();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		#---
		$sql = "INSERT INTO ".SYSTEM_EVENTS_DATA." (ed_id, ed_ev_id, ed_et_id, ed_user_id, ed_user_ip, ed_field_id, ed_timestamp, ed_city_id) values ";
		$sql .= "(null, ".$dbr->addQuotes($this->event).", ".$dbr->addQuotes($event_type).", ".$dbr->addQuotes($user_id).", ".$dbr->addQuotes($ip).", ".$dbr->addQuotes($event_field).", ".$dbr->addQuotes(wfTimestampNow()).", ".$dbr->addQuotes($CityId).")";
		#---
		$res = $dbr->query($sql);
		$id = ($res) ? $dbr->insertId() : false;

		wfProfileOut( __METHOD__ );
		return $id;
	}

	/*
	 * 
	 */
	public function updateUserEvents($event_type, $set_active = 0, $visible_count = 1)
	{
		global $wgUser;
		#---
		wfProfileIn( __METHOD__ );
		#---
		if ( empty($this->event) ) {
			return false;
		}
		#---
		if ( empty($event_type) ) {
			return false;
		}
		#---
		$CityId = $this->getCityId();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		#---
		$user_id = intval($wgUser->getID());
		$whereUser = "";
		if (empty($user_id))
		{
			$ip = wfGetIP();
			$whereUser = " and eu_user_ip = ".$dbr->addQuotes($ip);
		}
		else
		{
			$whereUser = " and eu_user_id = ".$dbr->addQuotes($user_id);
		}
		#---
		$sql = "UPDATE ".SYSTEM_EVENTS_USERS." SET ";
		$sql .= " eu_visible_count = eu_visible_count + 1, ";
		$sql .= " eu_timestamp = ".$dbr->addQuotes(wfTimestampNow()).", ";
		if (!empty($CityId)) {
			$sql .= " eu_city_id = ".$dbr->addQuotes($CityId).", ";
		}
		$sql .= " eu_active = ".$dbr->addQuotes($set_active);
		$sql .= " WHERE eu_visible_count >= '".intval($visible_count)."' and ";
		$sql .= " eu_ev_id = ".$dbr->addQuotes($this->event)." and ";
		$sql .= " eu_et_id = ".$dbr->addQuotes($event_type)." {$whereUser} ";
		if (!empty($CityId)) {
			$sql .= " and eu_city_id = ".$dbr->addQuotes($CityId);
		}
		
		#---
		$res = $dbr->query($sql);

		wfProfileOut( __METHOD__ );
		return true;
	}

	public function getUserCountVotesDB($user_id)
	{
		global $wgSharedDB, $wgDBname;
		
		$dbname = (!isset($wgSharedDB)) ? "wgDBname" : "wgSharedDB";
		
		wfProfileIn( __METHOD__ );
		$dbr =& wfGetDB( DB_SLAVE );
		$fname = 'SiteEvents::getUserCountVotesDB';
		
		$where = "user_id = '{$user_id}'";
		#---
		$sql = "SELECT count(0) as cnt from `".$$dbname."`.`page_vote` where {$where}";
		$res = $dbr->query($sql);
		#---
		$row = $dbr->fetchObject( $res ) ;

		$result = (empty($row->cnt))?false:true;
			
		#----
		$dbr->freeResult ($res);
		
		wfProfileOut( __METHOD__ );
		return $result;		
	}

	public function checkIsArticleContributorDB($user, $article_id)
	{
		wfProfileIn( __METHOD__ );
		#---
		$fname = 'WikiaEventsDBConditions::checkIsArticleContributorDB::'.$user->getName().'::'.$article_id;
		#---
		$evTexts = array();
		#---
        $oMemc = wfGetCache(CACHE_MEMCACHED);
        #---
        if ( !($result = $oMemc->get($fname)) )
        {
			#---
			$dbr =& wfGetDB( DB_SLAVE );
			#---
			$sql = "SELECT count(*) as cnt from revision where rev_user = ".$dbr->addQuotes($user->getID())." and rev_page = ".$dbr->addQuotes($article_id);
			$res = $dbr->query($sql);
			#---
			$row = $dbr->fetchRow( $res );
			$result = (!empty($row->cnt)) ? $row->cnt : -1;
			#---
			$dbr->freeResult ($res);
			#---
			$oMemc->set($fname, $result, self::MEMKEY_TIME);
		}

		#---
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/*
	 * start counter to display messages
	 */
	static public function startUserEventsCounter($event_id, $event_type, $set_active = 1)
	{
		global $wgUser, $wgCityId;
		#---
		wfProfileIn( __METHOD__ );
		#---
		if ( empty($event_id) ) {
			return false;
		}
		#---
		if ( empty($event_type) ) {
			return false;
		}
		#---
		$CityId = (empty($wgCityId)) ? self::getDomainFromCache($_SERVER['SERVER_NAME']) : $wgCityId;
		#---
		#---
		$dbr =& wfGetDB( DB_MASTER );
		#---

		$user_id = intval($wgUser->getID());
		$whereUser = "";
		if (empty($user_id))
		{
			$ip = wfGetIP();
			$whereUser = " and eu_user_ip = ".$dbr->addQuotes($ip);
		}
		else
		{
			$whereUser = " and eu_user_id = ".$dbr->addQuotes($user_id);
		}

		$sql = "UPDATE ".SYSTEM_EVENTS_USERS." SET ";
		$sql .= " eu_visible_count = eu_visible_count + 1, ";
		$sql .= " eu_timestamp = ".$dbr->addQuotes(wfTimestampNow()).", ";
		$sql .= " eu_active = ".$dbr->addQuotes(intval($set_active));
		$sql .= " WHERE eu_ev_id = ".$dbr->addQuotes($event_id)." and eu_et_id = ".$dbr->addQuotes($event_type);
		if (!empty($CityId)) {
			$sql .= " and eu_city_id = ".$dbr->addQuotes($CityId);
		}
		$sql .= " {$whereUser} ";
		
		#---
		$res = $dbr->query($sql);

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	/*
	 */
    private function checkIsInt($number) 
    {
    	return (is_numeric($number) ? intval($number) == $number : false);
    }
	
	/*
	 * get city_id from WikiFactory
	 */
    static private function getDomainFromCache( $domain ) 
    {
    	$city_id = 0;
    	if (class_exists("WikiFactory"))
    	{
    		$city_id = WikiFactory::DomainToID( $domain );
		}
		#---
		return $city_id;
	}
	
	/*
	 */
	private function getCityId()
	{
		global $wgCityId;
		#---
		$city_id = null;			
		#---
		$domain = $_SERVER['SERVER_NAME'];
        if ( $this->checkIsInt($wgCityId) ) 
        {
            $city_id = $wgCityId;
        }
        else 
        {
        	$city_id = self::getDomainFromCache($domain);
        	if ( (empty($city_id)) || (!$this->checkIsInt($city_id)) ) 
        	{
        		$city_id = $this->getIdFromDomain( $domain );
			}
        }
        
        return $city_id;
	}
	
    /**
     * get city ID for selected domain
     * 
     * return $cityid
     */
    private function getIdFromDomain( $domain ) 
    {
    	global $wgSharedDB;
    	#---
		$dbr =& wfGetDB( DB_SLAVE );
		#---
    	$dbr->selectDB($wgSharedDB);
    	#---
    	$sth = $dbr->select( "city_domains","city_id, city_domain",array("city_domain" => $domain), array("limit" => 1) );
    	$row = $dbr->fetchObject( $sth );
    	$dbr->freeResult( $sth );
    	return $row->city_id;
    }
		
}


?>
