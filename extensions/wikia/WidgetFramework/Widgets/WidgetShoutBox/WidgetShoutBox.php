<?php
/**
 * @author Maciej Brencz

  CREATE TABLE `shout_box_messages` (
  `id` int(11) NOT NULL auto_increment,
  `wikia` varchar(200) default NULL,
  `user` int(11) default NULL,
  `time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `message` text,
  PRIMARY KEY  (`id`)
)

 This is SHARED table ('wikicities' DB) !!!

 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetShoutBox'] = array(
	'callback' => 'WidgetShoutBox',
	'title' => array(
		'en' => 'Shout Box',
		'pl' => 'Czat'
	),
	'desc' => array(
		'en' => 'See who\'s online and chat with your friends',
		'pl' => 'Zobacz kto jest online i rozmawiaj ze swoimi znajomymi'
	),
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

    global $wgUser, $wgTitle, $wgRequest, $wgSitename;

    wfProfileIn(__METHOD__);

    // maybe user is trying to add a message to chat
    if ( $wgRequest->getVal('message') && $wgRequest->getVal('rs') == 'WidgetFrameworkAjax' ) {
		$showChat = WidgetShoutBoxAddMessage( $wgRequest->getVal('message') );
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

	$ret .= '<h5>Chat' . ($online !== false ? ' (<a onclick="WidgetShoutboxTabToogle(\''.$id.'\', 1)" style="cursor: pointer">'.
		wfMsg('monaco-whos-online').'? &raquo;</a>)' : '') . '</h5>';

	$msgs = WidgetShoutBoxGetMessages();

    // date limiter - dates after that timestamp will be outputed in HH:mm (9:38) format, before in d M (8 Sep)
    $midnight = strtotime('today 00:00');

    // time offset (set by user in his preferences)
    $time_offset = $wgUser->getOption('timecorrection') ? (int) $wgUser->getOption('timecorrection') * 3600 : 0;

    $count = 0;

    //print_pre($msgs);

    // limit amount of messages
    $limit = intval($params['limit']);
    $limit = ($limit <=0 || $limit > 50) ? 15 : $limit;

    $msgs = array_slice($msgs, 0, $limit);

    // last message author
    $last_msg_author = '';
    $last_msg_time = 0;

    $ret .= '<ul>';

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

			// time
			$ret .= '<li'. ($count++ % 2 ? ' class="msgOdd"' : '').'>'.
				htmlspecialchars( '['.date( $msg['time'] < $midnight ? 'j M' : 'G:i',$msg['time']).']' ).'&nbsp;';

			// user page link
			$userPage = Title::newFromText($msg['user'], NS_USER);
			$userLink = '<a href="'.$userPage->getLocalURL().'">'.htmlspecialchars($msg['user']).'</a>';

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
			switch($cmd)
			{
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
	if ( $wgUser->isLoggedIn() && !$wgUser->isBlocked() && !isset($params['_widgetTag']) )
	{
		$ret .= '<form onsubmit="WidgetShoutBoxSend(\''.$id.'\'); return false;" action="">'."\n";
		$ret .= '<input type="text" name="message" autocomplete="off" id="'.$id.'_message" maxlength="100" />'."\n";
		$ret .= '<input type="submit" value="'.wfMsg('send').'" />'."\n";
		$ret .= '</form>';
	}

	$ret .= '</div>'; // close chat div

	wfProfileOut(__METHOD__);

	return $ret;
}


function WidgetShoutBoxAddMessage($msg) {

	global $wgUser, $wgMemc;

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

			$row = array (
				'wikia'	=> WidgetShoutBoxGenerateHostname(),
				'user'	=> $wgUser->getID(),
				// 'time'	=> 'NOW()',
				'message'	=> $message
			);

			$dbw =& wfGetDB(DB_MASTER);

			// add message to shared table
			$dbw->insert(wfSharedTable('shout_box_messages'), $row, __METHOD__);

			$insertId = $dbw->insertId();

			wfDebug('Shoutbox: msg #' . $insertId. " added\n");

			// add msg also to memcache entry - avoid using unecessary updates queries
			$key = wfMemcKey('widget::shoutbox::messages:1');
			$msgs = $wgMemc->get($key);

			if (is_array($msgs)) {
				$msgs[$insertId] = array
				(
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
	}

	wfProfileOut(__METHOD__);

	return;
}


function WidgetShoutBoxGetMessages() {

    global $wgMemc;

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
    $dbr = wfGetDB(DB_SLAVE);

    // build query params
    $tables = array( wfSharedTable('shout_box_messages').' AS s', wfSharedTable('user').' AS u' );
    $fields = array(
		's.id AS id',
		'UNIX_TIMESTAMP(s.time) AS time',
		's.message AS message',
		'u.user_name AS user'
    );

    $wikia = WidgetShoutBoxGenerateHostname();

    wfDebug("Getting messages for wikia '$wikia'\n");

    $conds   = array( 'wikia' => $wikia, 'u.user_id = s.user' );
    $options = array( 'LIMIT' => 50, 'ORDER BY' => 'time DESC' );

    // do query
    $res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options );

    while ($row = $dbr->fetchObject($res)) {
        $msgs[$row->id] = array(
            'id'	=> $row->id,
            'time'	=> $row->time,
            'user'	=> $row->user,
            'message' 	=> stripslashes($row->message)
        );
    }

    $dbr->freeResult($res);

    // store in memcache
    $wgMemc->set($key, $msgs, 3600);

    wfProfileOut(__METHOD__);

    return $msgs;
}


function WidgetShoutBoxGetOnline() {

	global $wgEnableWhosOnlineExt;
	if( empty( $wgEnableWhosOnlineExt ) ) {
		return false;
	}

    global $wgMemc;

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

    // #3094: dirty fix for dofus
    if ($wgCityId == 602) {
        return 'dofus.wikia.com';
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
