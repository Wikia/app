<?php
/**
 * Wikia Game Guides mobile app EzAPI module
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiaGameGuidesEzApiModule extends EzApiModuleBase {
	const API_VERSION = 1;
	const API_REVISION = 0;
	
	private $mModel = null;
	
	function __construct( WebRequest $request ) {
		global $wgDevelEnvironment;
		
		if( !$wgDevelEnvironment ) {
			$this->setRequiresPost( true );//only POST requests allowed
		}
		
		parent::__construct( $request );
		
		$this->mModel = new WikiaGameGuidesWikisModel();
	}
	
	/*
	 * Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikis(){
		wfProfileIn( __METHOD__ );
		
		$ret = $this->mModel->getWikisList();
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Returns a collection of data for the current wiki to use in the
	 * per-wiki screen of the application
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikiContents(){
		wfProfileIn( __METHOD__ );
		
		$ret = $this->mModel->getWikiContents();
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Returns all the contents associated to an entry for the current wiki
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listEntryContents(){
		wfProfileIn( __METHOD__ );
		
		$ret = $this->mModel->getCategoryContents( $this->getRequest()->getText('entry') );
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Returns the results from a local wiki search for the passed in term
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listLocalSearchResults(){
		wfProfileIn( __METHOD__ );
		
		$ret = $this->mModel->getLocalSearchResults( $this->getRequest()->getText('term') );
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
}