<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die;
}

abstract class DeleteQueueView {
	abstract function show( $params );

	function __construct( $page ) {
		$this->mPage = $page;
	}

	function getTitle( $subpage = null ) {
		return $this->mPage->getTitle( $subpage );
	}
}
