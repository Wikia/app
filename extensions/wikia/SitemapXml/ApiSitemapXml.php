<?php

use MediaWiki\MediaWikiServices;
use Sitemap\SitemapXmlDataService;

class ApiSitemapXml extends ApiBase {

	public function execute() {

		$params = $this->getRequest()->getQueryValues();
		$subpage = $params['file'];
		$response = F::app()->sendRequest( 'SitemapXml', 'index', [ 'path' => $subpage ] );
		$response->sendHeaders();
		echo $response->getBody();
		die;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

}
