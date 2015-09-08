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
		$wgHooks['MsgGetFromNamespaceAfter'][] = 'efGetDefaultMessage';
		$wgDefaultMessagesCache = new DefaultMessagesCache( $messageMemc, $wgUseDatabaseMessages, $wgMsgCacheExpiry );
	}

	wfProfileOut(__FUNCTION__);
}

function efGetDefaultMessage( $lckey, $lang, &$message, $useDB ) {
	// Please note: the following code has been inlined in MessageCache::get
	// to improve performance, any changes here will not have any effect
	wfProfileIn(__FUNCTION__);
	if( $message === false ) {
		global $wgDefaultMessagesCache, $wgContLang;
		if( is_object( $wgDefaultMessagesCache ) ) {
			$title = $wgContLang->ucfirst( $lckey );
			if( $lang !== 'en' ) {
				$pos = strrpos( $title, '/' );
				if( $pos === false ) {
					$title .= '/' . $lang;
				}
			}
			$message = $wgDefaultMessagesCache->get( $title, $lang, $useDB );
		}
	}
	wfProfileOut(__FUNCTION__);

	return true;
}
