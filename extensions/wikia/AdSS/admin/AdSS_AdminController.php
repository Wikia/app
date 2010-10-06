<?php

class AdSS_AdminController {

	function execute( $subpage ) {
		global $wgOut, $wgAdSS_templatesDir, $wgAdSS_DBname, $wgUser;

		if( !$wgUser->isAllowed( 'adss-admin' ) ) {
			$wgOut->permissionRequired( 'adss-admin' );
			return;
		}

		$pager = new AdSS_AdminPager();
		if( $pager->getNumRows() ) {
			$wgOut->addHTML( $pager->getBody() . $pager->getNavigationBar() );
		}
	}

}
