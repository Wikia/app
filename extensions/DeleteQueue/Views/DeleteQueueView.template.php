<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die;
}

class DeleteQueueViewX extends DeleteQueueView {
	function show( $params ) {
		global $wgOut;
		$wgOut->setPageTitle( '' );
	}
}
