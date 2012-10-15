<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

class FeedsFromPrivateWikis {

	static function efUserCan( &$title, &$user, $action, &$result ) {
		global $wgRequest;
		$feed = $wgRequest->getText( 'feed' );
		
		if ( $action != 'read' || $feed != 'atom' ) {
			return true;
		}
	
		$username = $wgRequest->getText( 'username' );
		$key = $wgRequest->getText( 'key' );
		$editor = User::newFromName( $username );
		$result = null;
		if ( $editor ) {
			if ( $key == $editor->getOption( 'watchlisttoken' ) ) {
				$result = true;
			}
		}
		
		return false;
	}
}
