<?php

if (!defined('MEDIAWIKI')) {
	die();
}

class WikiaApiQueryBlob extends ApiQueryBase {

	public function __construct($main, $action) {
		parent :: __construct($main, $action, '');
	}

	public function execute() {
		global $wgRevisionCacheExpiry, $wgMemc;
		wfProfileIn( __METHOD__ );		

		$cluster = $blobid = null;

		extract($this->extractRequestParams());

		if ( empty($blobid) ) {
			$this->dieUsage( 'Invalid blobid', 1, 404 );
		}
		
		if ( empty($cluster) ) {
			$this->dieUsage( 'Invalid cluster', 2, 404 );
		}
		
		$url = sprintf( "DB://%s/%d", $cluster, $blobid );
		$text = ExternalStore::fetchFromURL( $url );

		if ( $text === false ) {
			$this->dieUsage( 'Text not found', 3, 404 );
		}
		
		$result = $this->getResult();
				
		$result->setRawMode();
		$result->disableSizeCheck();
		$result->reset();
		$result->addValue( null, 'text', $text );
		$result->addValue( null, 'mime', 'text/plain' );		
		$result->enableSizeCheck();		
	}
	
	public function getCustomPrinter() {
		return new ApiFormatRaw( $this->getMain(), $this->getMain()->createPrinterByName( 'txt' ) );
	}

	public function getAllowedParams() {
		return array (
			'cluster'	=> null,
			'blobid' 	=> null
		);
	}

	public function getParamDescription() {
		return array (
			'cluster' 	=> 'cluster name',
			'blobid' 	=> 'identifier of text'
		);
	}
	
	public function getDescription() {
		return 'Fetch revision text';
	}

	public function getExamples() {
		return array (
			'api.php?action=blob&blobid=1',
		);
	}	
	
	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryBlob.php 17065 2011-02-07 02:11:29Z moli $';
	}
}

