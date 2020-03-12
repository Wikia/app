<?php

class GoogleTagManagerHooks {
	public static function onBeforePageDisplay( OutputPage $out ) {
		wfProfileIn( __METHOD__ );
		global $wgEnableGoogleTagManager;

		$out->addModules( 'ext.wikia.GoogleTagManager' );
		
		wfProfileOut( __METHOD__ );
		return true;
	}
}
