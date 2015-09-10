<?php

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'DefaultMessages',
	'author' => 'Wikia',
	'descriptionmsg' => 'defaultmessages-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DefaultMessages',
);

//i18n
$wgExtensionMessagesFiles['DefaultMessages'] = __DIR__ . '/DefaultMessages.i18n.php';

$wgExtensionFunctions[] = 'efDefaultMessagesSetup';
$wgAutoloadClasses['DefaultMessagesCache'] = dirname(__FILE__) . '/DefaultMessagesCache.php';

function efDefaultMessagesSetup() {
	global $wgDefaultMessagesDB, $wgDefaultMessagesCache;
	global $wgDBname, $wgHooks;
	global $messageMemc, $wgUseDatabaseMessages, $wgMsgCacheExpiry;

	wfProfileIn(__FUNCTION__);

	if( empty( $wgDefaultMessagesDB ) ) {
		$wgDefaultMessagesDB = 'messaging';
	}

	if( $wgDefaultMessagesDB != $wgDBname ) {
		$wgDefaultMessagesCache = new DefaultMessagesCache( $messageMemc, $wgUseDatabaseMessages, $wgMsgCacheExpiry );
	}

	wfProfileOut(__FUNCTION__);
}
