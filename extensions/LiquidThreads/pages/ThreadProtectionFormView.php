<?php

if ( !defined( 'MEDIAWIKI' ) ) die;

class ThreadProtectionFormView {
	function customizeTabs( $skintemplate, $content_actions ) {
		unset( $content_actions['edit'] );
		unset( $content_actions['addsection'] );
		unset( $content_actions['viewsource'] );
		unset( $content_actions['talk'] );

		$content_actions['talk']['class'] = false;
		if ( array_key_exists( 'protect', $content_actions ) )
		$content_actions['protect']['class'] = 'selected';
		else if ( array_key_exists( 'unprotect', $content_actions ) )
		$content_actions['unprotect']['class'] = 'selected';

		return true;
	}

	function show() {
		global $wgHooks;
		$wgHooks['SkinTemplateTabs'][] = array( $this, 'customizeTabs' );
		return true;
	}
}
