<?php

if( empty( $wgDefaultMessagesDB ) ) {
	$wgDefaultMessagesDB = 'messaging';
}

if( $wgDefaultMessagesDB == $wgDBname ) {
	$wgHooks['MessageCacheReplace'][] = 'DefaultMessages::onMessageCacheReplace';
} else {
	$wgHooks['MessagesGetFromNamespaceAfter'][] = 'DefaultMessages::get';
}

class DefaultMessages {
	const expire = 3600;
	static $cache, $loaded = false;

	private static function memcKey() {
		global $wgDefaultMessagesDB;
		return $wgDefaultMessagesDB . ':default_messages_new';
	}
	
	private static function memcKeyTouched() {
		global $wgDefaultMessagesDB;
		return $wgDefaultMessagesDB . ':default_messages:touched';
	}

	private static function filecache() {
		global $wgDefaultMessagesDB;
		return '/tmp/default_messages_new.ser';
	}

	public static function get( $key, $lang, &$message ) {
		if( $message === false ) {
			self::load();

			if( isset( self::$cache[$key][$lang] ) ) {
				$message = self::$cache[$key][$lang];
			}
		}

		return true;
	}

	public static function load() {
		global $wgMemc, $wgContLang, $wgDefaultMessagesDB;
		if( !empty( $wgDefaultMessagesDB ) ) {
			if( self::$loaded ) {
				return;
			}

			$_touched = $wgMemc->get( self::memcKeyTouched() );
			self::$cache = WikiFactory::fetch( self::filecache(), $_touched );

			if( empty( self::$cache ) ) {
				// try memcached
				self::$cache = $wgMemc->get( self::memcKey() );
				if( !empty( self::$cache ) ) {
					WikiFactory::store( self::filecache(), self::$cache, self::expire, $_touched );
				}
			}

			if( empty( self::$cache ) ) {
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

				self::$cache = array();
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
					self::$cache[$key][$lang] = $value;
				}
				$dbr->freeResult( $res );
				$wgMemc->set( self::memcKey(), self::$cache, self::expire );
				WikiFactory::store( self::filecache(), self::$cache, self::expire, $_touched );
			}

			self::$loaded = true;
		}
	}

	public static function onMessageCacheReplace( $title, $text ) {
		global $wgMemc, $wgContLang;

		self::$cache = $wgMemc->get( self::memcKey() );
		if( !empty( self::$cache ) ) {
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
				unset( self::$cache[$key][$lang] );
			} else {
				self::$cache[$key][$lang] = $text;
			}
			$wgMemc->set( self::memcKey(), self::$cache, self::expire );
			$_touched = time();
			$wgMemc->set( self::memcKeyTouched(), $_touched );
			WikiFactory::store( self::filecache(), self::$cache, self::expire, $_touched );
		}

		return true;
	}
}

function efDefaultMessagesSetup() {
	DefaultMessages::loadMessages();
}
