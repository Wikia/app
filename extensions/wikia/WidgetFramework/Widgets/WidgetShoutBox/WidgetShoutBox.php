<?php
/*
 * @author Maciej Brencz

CREATE TABLE `shout_box_messages` (
  `id` int(11) NOT NULL auto_increment,
  `city` int(9) default NULL,
  `wikia` varchar(200) default NULL,
  `user` int(11) default NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `message` text,
  PRIMARY KEY  (`id`),
  KEY `wikia_idx` (`wikia`),
  KEY `city_idx` (`city`)
)

CREATE INDEX wikia_idx ON shout_box_messages (wikia);
ALTER TABLE shout_box_messages ADD city int(9) AFTER id;
CREATE INDEX city_idx ON shout_box_messages (city);

This is SHARED table (wikicities DB)

TODO: if WhosOnline is never coming back, remove traces from widget, make logic simpler
 */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetShoutBox'] = array(
	'callback' => 'WidgetShoutBox',
	'title' => 'widget-title-shoutbox',
	'desc' => 'widget-desc-shoutbox',
    	'params' => array(
		'limit' => array(
		    'type'    => 'text',
		    'default' => 5
		),
	),
	'closeable' => true,
	'editable' => true
);


function WidgetShoutBox($id, $params) {

	global $wgUser, $wgTitle, $wgRequest, $wgSitename, $wgLang, $wgEnableWidgetShoutbox;

	wfProfileIn(__METHOD__);

	// check if widget is enabled for this wiki and quit early if not
	if ( isset( $wgEnableWidgetShoutbox ) && !$wgEnableWidgetShoutbox ) {
		return wfMsg('widget-shoutbox-disabled');
	}

	// maybe user is trying to add a message to chat
	if ( $wgRequest->getVal('message') && $wgRequest->getVal('rs') == 'WidgetFrameworkAjax' ) {
		$showChat = WidgetShoutBoxAddMessage( $wgRequest->getVal('message') );
	}
	elseif ( $wgRequest->getVal('msgid') && $wgRequest->getVal('rs') == 'WidgetFrameworkAjax' ) {	//remove a message
		WidgetShoutBoxRemoveMessage( $wgRequest->getVal('msgid') );
	}

	$ret = '';

	// should we show "chat" part of widget?
	$showChat = isset($showChat) || ( isset($_COOKIE[$id.'_showChat']) && intval($_COOKIE[$id.'_showChat']) == 1 );

	$online = WidgetShoutBoxGetOnline();

	//WhosOnline is turned on
	if ( is_array($online) ) {
		// generate HTML for "who's online" part of widget
		$ret .= '<div id="'.$id.'_online"' . ($showChat ? ' style="display:none"' : '') . '>';

		$ret .= '<h5>'.wfMsg('monaco-whos-online').' (<a onclick="WidgetShoutboxTabToogle(\''.$id.'\', 0)" style="cursor: pointer">chat! &raquo;</a>)</h5>'.
			'<p style="margin:8px 0">Guests: ' . $online['anons'] . ' <span style="margin-left: 10px">Users: ' . $online['users'] . '</span></p>';

		$list = array();

		foreach($online['whosonline'] as $user) {
			$url = Title::newFromText($user['user'], NS_USER);
			$list[] = array( 'href' => $url->getLocalURL(), 'name' => $user['user'] );
		}

		$more = Title::newFromText('WhosOnline', NS_SPECIAL);

		$ret .= WidgetFrameworkWrapLinks($list) . WidgetFrameworkMoreLink($more->getLocalURL());

		unset($list, $more);
		$ret .= '</div>';
	}
	else {
		// fallback when WhosOnline is turned off
		$showChat = true;
	}

	// generate HTML for "chat" part of widget
	$ret .= '<div id="'.$id.'_chat" class="WidgetShoutBoxChat"' . (!$showChat ? ' style="display:none"' : '') . '>';

	#temp disable header. (remove hardcoded 'Chat' text + WhosOnline has been disabled forever, and not coming back?)
	#$ret .= '<h5>Chat' . ($online !== false ? ' (<a onclick="WidgetShoutboxTabToogle(\''.$id.'\', 1)" style="cursor: pointer">'.
	#	wfMsg('monaco-whos-online').'? &raquo;</a>)' : '') . '</h5>';

	$msgs = WidgetShoutBoxGetMessages();

	// date limiter - dates after that timestamp will be outputed in HH:mm (9:38) format, before in d M (8 Sep)
	$midnight = strtotime('today 00:00');

	// time offset (set by user in his preferences)
	$time_offset = $wgUser->getOption('timecorrection') ? (int) $wgUser->getOption('timecorrection') * 3600 : 0;

	$count = 0;

	// limit amount of messages
	$limit = intval($params['limit']);
	$limit = ($limit <=0 || $limit > 50) ? 15 : $limit;

	$msgs = array_slice($msgs, 0, $limit);

	// last message author
	$last_msg_author = '';
	$last_msg_time = 0;

	$ret .= '<ul>';

	$id = intval(substr($id, 7));

	if (count($msgs) == 0) {
		$ret .= '<li>&lt;'.htmlspecialchars($wgSitename).'&gt; '.wfMsg('wt_shoutbox_initial_message').'</li>';
	}
	else {
		// create parser instance
		$options = new ParserOptions();
		$options->setMaxIncludeSize(100); // refs #1939

		$parser = new Parser();
		// display messages
		foreach ( array_reverse($msgs) as $msg)
		{
			// trim message
			$msg['message'] = trim($msg['message']);

			// include offset in timestamp
			$msg['time'] += $time_offset;

			//add remove link for privlidged users
			$removeLink = '';
			if (!isset($params['_widgetTag']) && $wgUser->isAllowed('shoutboxremove')) {
				$removeLink = '<a href="#" onclick="WidgetShoutBoxRemoveMsg(' . $id . ', ' . $msg['id'] . '); return false;">x</a> ';
			}
			// time
			//adjust user's timezone
			$msg['time'] = intval( $wgLang->sprintfDate('U', $wgLang->userAdjust(wfTimestamp(TS_MW, $msg['time']))) );
			$ret .= '<li' . ($count++ % 2 ? ' class="msgOdd"' : '') . '>' .
				$removeLink.
				htmlspecialchars( '['.date( $msg['time'] < $midnight ? 'j M' : 'G:i', $msg['time']) . ']' ) . '&nbsp;';

			// user page link
			$userPage = Title::newFromText($msg['user'], NS_USER);
			$userLink = '<a href="' . $userPage->getLocalURL() . '">' . htmlspecialchars($msg['user']) . '</a>';

			// interprete IRC-like command (e.g. /me is going away for a while)
			//
			// @see www.ircbeginner.com/ircinfo/ircc-commands.html
			//
			if (substr($msg['message'], 0, 1) == '/') {
				$cmd = substr($msg['message'], 1, strpos($msg['message'], ' ') - 1);
				$msg['message'] = substr($msg['message'], 2 + strlen($cmd));
			}
			else {
				$cmd = '';
			}

			// parse message
			$parsedMsg = $parser->parse($msg['message'], $wgTitle, $options)->getText();

			// remove unwanted HTML tags
			$parsedMsg = strip_tags($parsedMsg, '<i><b><a>');

			// remove wrapping <p></p> tags
			$parsedMsg = trim(str_replace(array('<p>', '</p>'), '', $parsedMsg));

			// interpret irc-like command
			switch($cmd) {
				case 'me':	// macbre: that's the only one that might me useful for us - ideas?
					$ret .= '<strong>* '.$userLink.' <span class="shoutBoxMsg">'.$parsedMsg.'</span></strong>';
					$last_msg_author = '';
					$last_msg_time = 0;
					break;

				default:
					// repeating authors folding (Skype a'like ;)
					$ret .= ($last_msg_author == $msg['user'] && ($msg['time'] - $last_msg_time < 1200) ? '<strong>...</strong> ' : '&lt;'.$userLink.'&gt; ').
							'<span class="shoutBoxMsg">'.$parsedMsg.'</span>';

					$last_msg_author = $msg['user'];
					$last_msg_time   = $msg['time'];
			}

			// close message
			$ret .= '</li>';
		}
	}

	$ret .= '</ul>';

	// show form only for non-blocked and logged in users
	if ( $wgUser->isLoggedIn() && !$wgUser->isBlocked() && !isset($params['_widgetTag']) ) {
		$ret .= '<form onsubmit="WidgetShoutBoxSend('.$id.'); return false;" action="">'."\n";
		$ret .= '<input type="text" name="message" autocomplete="off" id="widget_'.$id.'_message" maxlength="100" />'."\n";
		$ret .= '<input type="submit" value="'.wfMsg('send').'" />'."\n";
		$ret .= '</form>';
	}

	$ret .= '</div>'; // close chat div

	wfProfileOut(__METHOD__);

	return $ret;
}

function WidgetShoutBoxAddMessage($msg) {

	global $wgUser, $wgMemc, $wgCityId, $wgExternalSharedDB;

	wfProfileIn(__METHOD__);

	// check whether user is banned or anon
	if (!$wgUser->isLoggedIn() || $wgUser->isBlocked()) {
		// user is not allowed to chat
		wfProfileOut(__METHOD__);
		return;
	}

	// add only non-empty messages
	if ( !empty($msg) ) {
		$message = substr(trim(urldecode($msg), ' :'), 0, 100);	// limit message length (100 chars)

		wfDebug('Shoutbox: adding msg ' . $message . "...\n");

		if (!empty($message)) {
			$row = array(
				'wikia' => WidgetShoutBoxGenerateHostname(),
				'city' => $wgCityId,
				'user' => $wgUser->getID(), // #3813
				'message' => $message
			);

			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

			// add message to shared table
			$dbw->insert('shout_box_messages', $row, __METHOD__);

			$insertId = $dbw->insertId();

			// make sure to store message in DB
			$dbw->commit();

			wfDebug('Shoutbox: msg #' . $insertId. " added\n");

			// add msg also to memcache entry - avoid using unecessary updates queries
			$key = wfMemcKey('widget::shoutbox::messages:1');
			$msgs = $wgMemc->get($key);

			if (!is_array($msgs)) {
				$smsgs = array();
			}

			$msgs[$insertId] = array(
				'id' => $insertId,
				'time' => time(),
				'user' => $wgUser->getName(),
				'message' => stripslashes($message),
				'*' => ''
			);

			// sort and limit array size (keep key association)
			krsort($msgs, SORT_NUMERIC);
			$msgs = array_slice($msgs, 0, 50, true);

			// save to cache
			$wgMemc->set($key, $msgs, 3600); // cache for an hour
		}
	}

	wfProfileOut(__METHOD__);

	return;
}

function WidgetShoutBoxGetMessages() {

	global $wgMemc, $wgExternalSharedDB;

	wfProfileIn(__METHOD__);

	// try memcache
	$key = wfMemcKey('widget::shoutbox::messages:1');
	$msgs = $wgMemc->get($key);

	// return cached messages list
	if ( is_array($msgs) ) {
		wfProfileOut(__METHOD__);
		return $msgs;
	}

	$msgs = array();

	// get them from DB (don't use API)
	$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

	// build query params
	$tables = array( 'shout_box_messages AS s', 'user AS u' );
	$fields = array(
		's.id AS id',
		'UNIX_TIMESTAMP(s.time) AS time',
		's.message AS message',
		'u.user_name AS user'
	);

	$wikia = WidgetShoutBoxGenerateHostname();

	wfDebug("Getting messages for wikia '$wikia'\n");

	$conds   = array( 'wikia' => $wikia, 'u.user_id = s.user' );
	$options = array( 'LIMIT' => 50, 'ORDER BY' => 'id DESC' );

	// do query
	$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options );

	while ($row = $dbr->fetchObject($res)) {
		$msgs[$row->id] = array(
			'id' => $row->id,
			'time' => $row->time,
			'user' => $row->user,
			'message' => stripslashes($row->message)
		);
	}

	$dbr->freeResult($res);

	// store in memcache
	$wgMemc->set($key, $msgs, 3600);

	wfProfileOut(__METHOD__);

	return $msgs;
}


function WidgetShoutBoxGetOnline() {
	global $wgEnableWhosOnlineExt, $wgMemc;
	if( empty($wgEnableWhosOnlineExt)) {
		return false;
	}

	wfProfileIn(__METHOD__);

	// try memcache
	$key = wfMemcKey('widget::shoutbox::online');
	$online = $wgMemc->get($key);

	// return cached online data
	if ( is_array($online) ) {
		wfProfileOut(__METHOD__);
		return $online;
	}

	$online = WidgetFrameworkCallAPI(array(
		'action' => 'query',
		'list'   => 'whosonline',
		'wklimit'=> '10'
	));

	// store in memcache
	if ( is_array($online) && isset($online['query']) ) {
		$wgMemc->set($key, $online['query'], 600);
	}
	else {
		$online['query'] = false;
	}

	wfProfileOut(__METHOD__);

	return $online['query'];
}

// for compatibility with previous widget framework
function WidgetShoutBoxGenerateHostname() {
	wfProfileIn( __METHOD__ );
	global $wgServer, $wgCityId;

	$hack_domains = array(
		4533	=> 'ca.dofus.wikia.com',
		1177	=> 'cs.dofus.wikia.com',
		1982	=> 'de.dofus.wikia.com',
		602	=> 'en.dofus.wikia.com',
		1630	=> 'es.dofus.wikia.com',
		7491	=> 'fi.dofus.wikia.com',
		1112	=> 'fr.dofus.wikia.com',
		4763	=> 'hu.dofus.wikia.com',
		7645	=> 'it.dofus.wikia.com',
		2278	=> 'nl.dofus.wikia.com',
		1922	=> 'pl.dofus.wikia.com',
		1809	=> 'pt.dofus.wikia.com',
		2788	=> 'ru.dofus.wikia.com',
		2791	=> 'tr.dofus.wikia.com',

		8416	=> 'bg.memory-alpha.org',
		2422	=> 'cs.memory-alpha.org',
		114	=> 'de.memory-alpha.org',
		113	=> 'en.memory-alpha.org',
		765	=> 'eo.memory-alpha.org',
		1260	=> 'es.memory-alpha.org',
		763	=> 'fr.memory-alpha.org',
		6613	=> 'it.memory-alpha.org',
		5379	=> 'ja.memory-alpha.org',
		2067	=> 'mu.memory-alpha.org',
		115	=> 'nl.memory-alpha.org',
		548	=> 'pl.memory-alpha.org',
		2556	=> 'pt.memory-alpha.org',
		2421	=> 'ru.memory-alpha.org',
		2255	=> 'sr.memory-alpha.org',
		365	=> 'sv.memory-alpha.org',
		2698	=> 'zh-cn.memory-alpha.org',
	);
	if (!empty($hack_domains[$wgCityId])) {
		return $hack_domains[$wgCityId];
	}

	if ( isset( $wgServer ) ) {
		$host = substr( $wgServer, strpos( $wgServer, "://" ) + 3 );
		if ( $host != '' ) {
			wfProfileOut( __METHOD__ );
			return ( substr( $host, 0, 4 ) == 'www.' ? substr( $host, 4 ) : $host );
		}
	}

	if ( $_SERVER['SERVER_NAME'] != '' ) {
		$host = $_SERVER['SERVER_NAME'];
		wfProfileOut( __METHOD__ );
		return ( substr( $host, 0, 4 ) == 'www.' ? substr( $host, 4 ) : $host );
	}

	wfProfileOut( __METHOD__ );
	return 'notreal.wikia.com';
}

function WidgetShoutBoxRemoveMessage($msgId) {
	global $wgUser, $wgMemc, $wgExternalSharedDB;

	wfProfileIn(__METHOD__);

	// check whether user is banned or not allowed to remove a message
	if (!$wgUser->isAllowed('shoutboxremove') || $wgUser->isBlocked()) {
		// user is not allowed to chat
		wfProfileOut(__METHOD__);
		return false;
	}

	// msgId must be a number
	if (ctype_digit($msgId)) {
		wfDebug("Shoutbox: removing msg id=$msgId\n");


		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);

		// remove a message from shared table
		$dbw->delete('shout_box_messages', array('id' => $msgId), __FUNCTION__ );

		// fix RT #14396
		$dbw->commit();

		// add msg also to memcache entry - avoid using unecessary updates queries
		$key = wfMemcKey('widget::shoutbox::messages:1');
		$msgs = $wgMemc->get($key);
		if (is_array($msgs)) {
			// remove a message from cache
			unset($msgs[$msgId]);

			// save to cache
			$wgMemc->set($key, $msgs, 3600); // cache for an hour
		}
	}

	wfProfileOut(__METHOD__);

	return true;
}
