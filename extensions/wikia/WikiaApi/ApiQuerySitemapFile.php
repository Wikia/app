<?php

/**
 * very simple method, it just returns path to sitemap file
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 */


class ApiQuerySitemapFile extends ApiQueryBase {

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

		global $wgDBname, $wgSitemapBaseDirectory, $wgSitemapBasePath;

		$params = array();
		$file   = sprintf( "sitemap-index-%s.xml", $wgDBname );
		$result = array();
		$result[] = array(
			"path" => sprintf( "%s/%s/%s/%s/%s", $wgSitemapBasePath, substr( $wgDBname, 0, 1 ), substr( $wgDBname, 0, 2 ), $wgDBname, $file ),
			"file"  => sprintf( "%s/%s/%s/%s/%s", $wgSitemapBaseDirectory, substr( $wgDBname, 0, 1 ), substr( $wgDBname, 0, 2 ), $wgDBname, $file )
		);
		$this->getResult()->setIndexedTagName( $result, "path" );
		$this->getResult()->addValue(null, $this->getModuleName(), $result );
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiCreatorReminderEmail.php 18310 2010-02-10 12:10:30Z eloy $';
	}

    /**
     * standard api function
     *
     * @access public

     */
	public function getExamples() {
        return array (
            "api.php?action=sitemapdata"
        );
    }

	/**
	 * method demands writing rights
	 */
    public function isWriteMode() {
        return false;
    }

	public function getDescription() {
        return "Collect data for generating SiteMaps";
    }
}
