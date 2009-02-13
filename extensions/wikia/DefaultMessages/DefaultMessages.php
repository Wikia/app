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

function efGetDefaultMessage( $lckey, $lang, &$message, $useDB ) {
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
	return true;
}

