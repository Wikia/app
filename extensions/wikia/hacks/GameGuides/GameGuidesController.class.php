<?php
/**
 * Game Guides mobile app API controller
 * 
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class GameGuidesController extends WikiaController {
	const API_VERSION = 1;
	const API_REVISION = 6;
	const APP_NAME = 'GameGuides';
	
	private $mModel = null;
	private $mPlatform = null;
	
	function init() {
		$requestedVersion = $this->request->getInt( 'ver', self::API_VERSION );
		$requestedRevision = $this->request->getInt( 'rev', self::API_REVISION );
		
		if ( $requestedVersion != self::API_VERSION || $requestedRevision != self::API_REVISION ) {
			throw new GameGuidesWrongAPIVersionException();
		}
		
		if ( !$this->wg->develEnvironment && !$this->request->wasPosted() ) {
			throw new GameGuidesRequestNotPostedException();
		}
		
		$this->mModel = F::build( 'GameGuidesModel' );
		$this->mPlatform = $this->request->getVal( 'os' );
	}
	
	/*
	 * @brief Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 */
	public function listWikis(){
		$this->wf->profileIn( __METHOD__ );
		$this->track( array( 'list_games' ) );
		
		$limit = $this->request->getInt( 'limit', null );
		$offset = $this->request->getInt( 'offset', 0 );
		
		$this->setVal( 'data', $this->mModel->getWikisList( $limit, $offset ) );
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/*
	 * Returns a collection of data for the current wiki to use in the
	 * per-wiki screen of the application
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikiContents(){
		wfProfileIn( __METHOD__ );
		global $wgDBname;
		
		$this->track( array( 'list_wiki_contents', $wgDBname ) );
		
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
		global $wgDBname;
		$entry = $this->getRequest()->getText('entry');
		
		$this->track( array( 'list_category_contents', $wgDBname, $entry ) );
		
		$ret = $this->mModel->getCategoryContents( $this->getRequest()->getText('entry') );
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/**
	 * Returns the results from a local wiki search for the passed in term
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listLocalSearchResults(){
		wfProfileIn( __METHOD__ );
		global $wgDBname;
		
		$this->track( array( 'local_search', $wgDBname ) );
		
		$ret = $this->mModel->getLocalSearchResults( $this->getRequest()->getText('term') );
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/**
	 * @brief Tracks API requests via Scribe
	 * @param array $trackingData Required, a set of strings/numbers that will be concatenated with '/'
	 * @see MobileStatsController
	 */
	private function track( $trackingData ){
		$this->sendRequest( 'MobileStats', 'track', array(
			'appName' => self::APP_NAME,
			'URIData' => $trackingData,
			'platform' => $this->mPlatform
		) );
	}
}

class GameGuidesWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 501 );
	}
}

class GameGuidesRequestNotPostedException extends WikiaException {
	function __construct() {
		parent::__construct( 'Only POST requests allowed', 406 );
	}
}
