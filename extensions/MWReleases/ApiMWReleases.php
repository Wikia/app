<?php

/**
 * Class definition for MWReleases API Module
 */

class ApiMWReleases extends ApiBase {
	
	// Possible releases. Current is the latest stable,
	// Alpha is trunk, Beta is release candidates
	private $tags = array( 'current', 'alpha', 'beta' );
	
	public function __construct($main, $action) {
		parent :: __construct($main, $action);
	}

	public function execute() {
		$results = array();
		$releases = explode( "\n", wfMsgForContent( 'mwreleases-list' ) );
		foreach( $releases as $release ) {
			$release = trim( $release );
			if( substr( $release, 0, 1 ) == '#' ) {
				continue;
			}
			if( strpos( $release, ':' ) !== false ) {
				list( $status, $version ) = explode( ':', $release, 2 );
				$r = array( 'version' => $version );
				if( in_array( $status, $this->tags ) )
					$r[$status] = '';
				$results[] = $r;
			}
		}
		$this->getResult()->setIndexedTagName($results, 'release');
		$this->getResult()->addValue(null, $this->getModuleName(), $results);
	}

	public function getDescription() {
		return array (
			'Get the list of current Mediawiki releases'
		);
	}

	protected function getExamples() {
		return array(
			'api.php?action=mwreleases'
		);
	}
	public function getVersion() {
		return __CLASS__ . ': ' . MWRELEASES_VERSION;
	}
}
