<?php

/*
 * don't include this file in trnaslation process it is only staff tool
 */

$messages = array();

$messages['en'] = array(
   'chatfailover' => 'Chatfailover control center',

    'chat-failover-warning-title' => 'Read this carefully !!!',

    'chat-failover-warning' => "This special page allows you to switch the chat to failover mode.
<br /><br />If you're not an engineer, performing this operation requires consultation.<br /><br />
		If chat is operating allready in failover mode and the chat app is not working: DO not switch it beck to regular mode without consultating an operations engineer",

    'chat-failover-server-list' => 'Chat servers in use:',

    'chat-failover-operating-failover' => 'Chat is operating now in: <span>failover mode</span>',
    'chat-failover-operating-regular' => 'Chat is operating now in: <span>regular mode</span>',

    'chat-failover-reason' => 'To switch mode enter a reason and press button',

    'chat-failover-switchmode-failover' => 'To switch to regular mode',
    'chat-failover-switchmode-regular' => 'To switch to failover mode',

    'chat-failover-mode-areyousure' => 'Do you understands the consequences of this operation ???',
    'chat-failover-reason-empty' => 'Reason can not be empty',

    'chat-failover-log-entry' => "$1 Chat operating mode changed by user [[User:$2]] to $3. '''Reason''': $4",
);