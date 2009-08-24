<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadWatchView extends ThreadPermalinkView {
	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );
		return true;
	}
}
