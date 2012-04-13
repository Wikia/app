<?php

/*
 * This is simple 'hack' to get HTML response
 * Created for a Hackathon to be able to call Wikia API through MW API
 *
 * @author Jakub Olek
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once ( 'ApiFormatBase.php' );
}

/**
 * @ingroup API
 */
class ApiFormatHTML extends ApiFormatBase {

	public function __construct( $main, $format ) {
		parent :: __construct( $main, $format );
	}

	public function getMimeType() {
		return 'text/html';
	}

	public function execute() {
		$data = $this->getResultData();
		$this->printText( end ( end( $data ) ) );
	}

	public function getDescription() {
		return 'Output data in HTML format' . parent :: getDescription();
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: HTML outputer jolek ';
	}
}
