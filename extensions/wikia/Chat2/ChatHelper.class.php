<?php

use Wikia\Logger\WikiaLogger;

class ChatHelper {


	static public function info( $message, Array $params = [ ] ) {
		WikiaLogger::instance()->info( 'CHAT: ' . $message, $params );
	}

	static public function debug( $message, Array $params = [ ] ) {
		WikiaLogger::instance()->debug( 'CHAT: ' . $message, $params );
	}

	public static function getChatters() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( "ChatServerApiClient::getChatters" );

		// data are store in memcache and set by node.js
		$chatters = $wgMemc->get( $memKey );
		if ( !$chatters ) {
			$chatters = array();
		}

		wfProfileOut( __METHOD__ );

		return $chatters;
	}

	public static function setChatters( $chatters ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$memKey = wfMemcKey( "ChatServerApiClient::getChatters" );
		$wgMemc->set( $memKey, $chatters, 60 * 60 * 24 );

		wfProfileOut( __METHOD__ );
	}


}
