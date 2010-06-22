<?php

/**
 * generate data for sitemaps redirector
 *
 * @author Przemek Piotrowski <nef@wikia-inc.com>
 */

class GenerateSitemapForApi extends GenerateSitemap {

	/**
	 * @access public
	 */
	public function __construct() {
		global $wgScriptPath;

		$this->url_limit = 50000;
		$this->size_limit = pow( 2, 20 ) * 10;
		$this->fspath = '';

		$this->compress = false;

		$this->stderr = fopen( 'php://stderr', 'wt' );
		$this->dbr = wfGetDB( DB_SLAVE );
		$this->generateNamespaces();
		$this->timestamp = wfTimestamp( TS_ISO_8601, wfTimestampNow() );
	}
}

class ApiQuerySitemapData extends ApiQueryBase {

	public function __construct( $query, $moduleName) {
		parent :: __construct( $query, $moduleName, 'sm');
	}

	/**
	 * execute -- main entry point to api method
	 *
	 * @access public
	 *
	 * @return api result,
	 */
	public function execute() {

		$sitemap = new GenerateSitemapForApi();

		$params = $this->extractRequestParams();
		$result = array();

		$this->getResult()->setIndexedTagName($result, 'page');
		$this->getResult()->addValue(null, $this->getModuleName(), $result );
	}
}
