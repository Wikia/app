<?php

$wgExtensionFunctions[] = 'efDefaultMessagesSetup';
$wgAutoloadClasses['DefaultMessagesCache'] = dirname(__FILE__) . '/DefaultMessagesCache.php';

function efDefaultMessagesSetup() {
	global $wgDefaultMessagesDB, $wgDefaultMessagesCache;
	global $wgDBname, $wgHooks;
	global $messageMemc, $wgUseDatabaseMessages, $wgMsgCacheExpiry;

	if( empty( $wgDefaultMessagesDB ) ) {
		$wgDefaultMessagesDB = 'messaging';
	}

	if( $wgDefaultMessagesDB != $wgDBname ) {
		$wgHooks['MsgGetFromNamespaceAfter'][] = 'efGetDefaultMessage';
		$wgDefaultMessagesCache = new DefaultMessagesCache( $messageMemc, $wgUseDatabaseMessages, $wgMsgCacheExpiry );
	}
}

function efGetDefaultMessage( $title, $lang, &$message ) {
	if( $message === false ) {
		global $wgDefaultMessagesCache;
		if( is_object( $wgDefaultMessagesCache ) ) {
			$message = $wgDefaultMessagesCache->get( $title, $lang );
		}
	}
	return true;
}

