<?php

/**
 * TODO: doc
 * 
 * @since 0.1
 * 
 * @ingroup Distribution
 * 
 * @author Chad Horohoe
 */
class SpecialDownloadMediaWiki extends SpecialPage {

	public function __construct() {
		parent::__construct( 'DownloadMediaWiki' );
	}

	public function execute( $par ) {
		$this->setHeaders();
		$releases = ReleaseRepo::singleton()->getSupportedReleases();
	}
}