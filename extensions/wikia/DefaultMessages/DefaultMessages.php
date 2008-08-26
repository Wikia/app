<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (defined('MEDIAWIKI')) {

if( empty( $wgDefaultMessagesDB ) ) {
	$wgDefaultMessagesDB = 'messaging';
}

if( $wgDefaultMessagesDB == $wgDBname ) {
	$wgHooks['wfMessageCacheReplace'][] = 'wfDefaultMessagesReplace';
} else {
	$wgExtensionFunctions[] = 'wfReplaceDefaultMessages';
}

function wfReplaceDefaultMessages() {
	$maxRevId = 5366;

	global $wgMemc, $wgMessageCache, $wgContLang, $wgDefaultMessagesDB, $wgDBprefix;
	if( !empty( $wgDefaultMessagesDB ) && is_object( $wgMessageCache ) ) {
		$_filecache = '/tmp/default_messages.ser';
		$memcKey = "$wgDefaultMessagesDB:default_messages";

		$_touched = $wgMemc->get( $memcKey . ":touched" );
		wfDebug( "trying file cache $_filecache with touched=$_touched\n" );
		$defaultMessages = WikiFactory::fetch( $_filecache, $_touched );

		if( empty( $defaultMessages ) ) {
			wfDebug( "trying memcached ($memcKey)\n" );
			$defaultMessages = $wgMemc->get( $memcKey );
			if( !empty( $defaultMessages ) ) {
				WikiFactory::store( $_filecache, $defaultMessages, 60*60, $_touched );
				wfDebug( "stored in $_filecache with touched=$_touched\n" );
			}
		}

		if( empty( $defaultMessages ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( array( "`$wgDefaultMessagesDB`.`page`", "`$wgDefaultMessagesDB`.`revision`", "`$wgDefaultMessagesDB`.`text`" ),
				array( 'page_title', 'old_text', 'old_flags' ),
				array( 
					'page_is_redirect' => 0,
					'page_namespace' => NS_MEDIAWIKI,
					'page_latest=rev_id',
					"rev_id > $maxRevId",
					'rev_text_id=old_id' ),
				__METHOD__ );

			$defaultMessages = array();
			for ( $row = $dbr->fetchObject( $res ); $row; $row = $dbr->fetchObject( $res ) ) {
				$lckey = $wgContLang->lcfirst( $row->page_title );
				if( strpos( $lckey, '/' ) ) {
					$t = explode( '/', $lckey );
					$key = $t[0];
					$lang = $t[1];
				} else {
					$key = $lckey;
					$lang = 'en';
				}
				$value = Revision::getRevisionText( $row );
				$wgMessageCache->addMessage( $key, $value, $lang );
				$defaultMessages["$key/$lang"] = array( 'key' => $key, 'value' => $value, 'lang' => $lang );
			}
			$dbr->freeResult( $res );
			$wgMemc->set( $memcKey, $defaultMessages, 60*60 );
			WikiFactory::store( $_filecache, $defaultMessages, 60*60, $_touched );
		} else {
			foreach( $defaultMessages as $msg ) {
				$wgMessageCache->addMessage( $msg['key'], $msg['value'], $msg['lang'] );
			}
		}
	}
}

function wfDefaultMessagesReplace( $title, $text ) {
	global $wgDefaultMessagesDB, $wgMemc, $wgContLang;

	$_filecache = "/tmp/default_messages.ser";
	$memcKey = "$wgDefaultMessagesDB:default_messages";

	$defaultMessages = $wgMemc->get( $memcKey );
	if( !empty( $defaultMessages ) ) {
		$lckey = $wgContLang->lcfirst( $title );
		if( strpos( $lckey, '/' ) ) {
			$t = explode( '/', $lckey );
			$key = $t[0];
			$lang = $t[1];
		} else {
			$key = $lckey;
			$lang = 'en';
		}

		if( $text === false ) {
			# Article was deleted
			unset( $defaultMessages["$key/$lang"] );
		} else {
			$defaultMessages["$key/$lang"] = array( 'key' => $key, 'value' => $text, 'lang' => $lang );
		}
		$wgMemc->set( $memcKey, $defaultMessages, 60*60 );
		$_touched = time();
		$wgMemc->set( $memcKey . ":touched", $_touched );
		WikiFactory::store( $_filecache, $defaultMessages, 60*60, $_touched );
	}

	return true;
}

}

?>
