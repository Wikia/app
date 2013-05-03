<?php

class SearchedKeywordsController extends WikiaSpecialPageController {

	/**
	 * @var SearchedKeywords
	 */
	protected $searchedKeywords = null;

	public function __construct() {
		$this->searchedKeywords = new SearchedKeywords( F::app() );

		parent::__construct( 'SearchedKeywords', 'SearchedKeywords', false );
	}

	public function index() {
		$this->wg->Out->setPageTitle( "Most searched keywords on this wiki" );

		$this->wg->Out->addScriptFile( "http://dev-adi:8080/socket.io/socket.io.js" );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . "/wikia/hacks/JSMemcBridge/memc-client.js" );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . "/wikia/hacks/SearchedKeywords/js/SearchedKeywords.js" );
		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . "/wikia/hacks/SearchedKeywords/js/jquery.tagcloud.js" );
	}

	public function onSearchBeforeBackendCall( &$query, &$offset, &$limit, &$params ) {
		$this->searchedKeywords->recordKeyword( $query );
		return true;
	}

}