<?php

if (!defined('MEDIAWIKI')) {
	die();
}

class WikiaApiQueryBlob extends ApiBase {

	private $type = 'plain';

	public function __construct($main, $action) {
		parent :: __construct($main, $action);
	}

	public function execute() {
		global $wgRevisionCacheExpiry, $wgMemc;
		wfProfileIn( __METHOD__ );		

		$cluster = $blobid = $type = null;

		extract($this->extractRequestParams());

		if ( empty($blobid) ) {
			$this->dieUsage( 'Invalid blobid', 1, 404 );
		}
		
		if ( empty($cluster) ) {
			$this->dieUsage( 'Invalid cluster', 2, 404 );
		}
		
		$this->type = $type;
		
		$url = sprintf( "DB://%s/%d", $cluster, $blobid );
		$text = ExternalStore::fetchFromURL( $url );

		if ( $text !== false ) {
			if ( $this->type == 'plain' ) {
				try {
					$ungzipped = @gzinflate( $text );
					
					if ( $ungzipped !== false ) {
						$text = $ungzipped;
					}
				} catch ( Exception $e ) {
					// is not gzipped
				}
			}
		} else {
			$this->dieUsage( 'Text not found', 3, 404 );
		}			
		
		$result = $this->getResult();
				
		$result->setRawMode();
		$result->disableSizeCheck();
		$result->reset();
		$result->addValue( null, 'text', $text );
		$result->addValue( null, 'mime', ( $this->type == 'gzip' ) ? 'application/octet-stream' : 'text/plain' );		
		$result->enableSizeCheck();		
	}
	
	public function getCustomPrinter() {
		if ( $this->type == 'plain' ) {
			return new ApiFormatRaw( $this->getMain(), $this->getMain()->createPrinterByName( 'txt' ) );
		} elseif ( $this->type == 'gzip' ) {
			return new ApiFormatRaw( $this->getMain(), 'raw' );
		} else {
			return null;
		}
	}

	public function getAllowedParams() {
		return array (
			'cluster'	=> null,
			'blobid' 	=> null,
			'type' 	=> null
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiQueryBlob.php 17065 2011-02-07 02:11:29Z moli $';
	}
}

