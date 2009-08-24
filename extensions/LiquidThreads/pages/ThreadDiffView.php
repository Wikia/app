<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadDiffView {
	function customizeTabs( $skintemplate, $content_actions ) {
		unset( $content_actions['edit'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['talk'] );

		$content_actions['talk']['class'] = false;
		$content_actions['history']['class'] = 'selected';

		return true;
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );
		return true;
	}
}
