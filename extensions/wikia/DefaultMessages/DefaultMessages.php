<?php

if( empty( $wgDefaultMessagesDB ) ) {
	$wgDefaultMessagesDB = 'messaging';
}

if( $wgDefaultMessagesDB == $wgDBname ) {
	$wgHooks['MessageCacheReplace'][] = 'DefaultMessages::onMessageCacheReplace';
} else {
	$wgExtensionFunctions[] = 'efDefaultMessagesSetup';
}

class DefaultMessages {
	const expire = 3600;

	private static function memcKey() {
		global $wgDefaultMessagesDB;
		return $wgDefaultMessagesDB . ':default_messages';
	}

	private static function filecache() {
		global $wgDefaultMessagesDB;
		return '/tmp/default_messages.ser';
	}

	public static function loadMessages() {
		global $wgMemc, $wgMessageCache, $wgContLang, $wgDefaultMessagesDB;
		if( !empty( $wgDefaultMessagesDB ) && is_object( $wgMessageCache ) ) {
			$_touched = $wgMemc->get( self::memcKey() . ":touched" );
			$defaultMessages = WikiFactory::fetch( self::filecache(), $_touched );

			if( empty( $defaultMessages ) ) {
				// try memcached
				$defaultMessages = $wgMemc->get( self::memcKey() );
				if( !empty( $defaultMessages ) ) {
					WikiFactory::store( self::filecache(), $defaultMessages, self::expire, $_touched );
				}
			}

			if( empty( $defaultMessages ) ) {
				// fetch from db as a last resort
				$dbr = wfGetDB( DB_SLAVE );
				$res = $dbr->select(
						array( "`$wgDefaultMessagesDB`.`page`", "`$wgDefaultMessagesDB`.`revision`", "`$wgDefaultMessagesDB`.`text`" ),
						array( 'page_title', 'old_text', 'old_flags' ),
						array( 
							'page_is_redirect' => 0,
							'page_namespace' => NS_MEDIAWIKI,
							'page_latest=rev_id',
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
				$wgMemc->set( self::memcKey(), $defaultMessages, self::expire );
				WikiFactory::store( self::filecache(), $defaultMessages, self::expire, $_touched );
			} else {
				foreach( $defaultMessages as $msg ) {
					$wgMessageCache->addMessage( $msg['key'], $msg['value'], $msg['lang'] );
				}
			}
		}
	}

	public static function onMessageCacheReplace( $title, $text ) {
		global $wgMemc, $wgContLang;

		$defaultMessages = $wgMemc->get( self::memcKey() );
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
			$wgMemc->set( self::memcKey(), $defaultMessages, self::expire );
			$_touched = time();
			$wgMemc->set( self::memcKey() . ":touched", $_touched );
			WikiFactory::store( self::filecache(), $defaultMessages, self::expire, $_touched );
		}

		return true;
	}
}

function efDefaultMessagesSetup() {
	DefaultMessages::loadMessages();
}
