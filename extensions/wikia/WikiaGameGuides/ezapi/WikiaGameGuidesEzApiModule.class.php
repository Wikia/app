<?php
/**
 * Wikia Game Guides mobile app EzAPI module
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiaGameGuidesEzApiModule extends EzApiModuleBase {
	const API_VERSION = 1;
	const API_REVISION = 1;
	const SCRIBE_KEY = 'mobile_apps';
	const APP_NAME = 'GameGuides';
	
	private $mModel = null;
	private $mOS = null;
	
	function __construct( WebRequest $request ) {
		global $wgDevelEnvironment;
		$requestedVersion = $request->getInt( 'ver', self::API_VERSION );
		$requestedRevision = $request->getInt( 'rev', self::API_REVISION );
		
		if ( $requestedVersion != self::API_VERSION || $requestedRevision != self::API_REVISION ) {
			throw new WikiaGameGuidesWrongAPIVersionException();
		}
		
		if ( !$wgDevelEnvironment ) {
			$this->setRequiresPost( true );//only POST requests allowed
		}
		
		parent::__construct( $request );
		
		$this->mModel = new WikiaGameGuidesWikisModel();
		$this->mOS = $request->getText( 'os', 'undefined' );
	}
	
	/*
	 * Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function listWikis(){
		wfProfileIn( __METHOD__ );
		
		$this->track(array( 'list_games' ));
		
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
		global $wgDBname;
		
		$this->track(array( 'list_wiki_contents', $wgDBname ));
		
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
		
		$this->track(array( 'list_category_contents', $wgDBname, $entry ));
		
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
		
		$this->track(array( 'local_search', $wgDBname ));
		
		$ret = $this->mModel->getLocalSearchResults( $this->getRequest()->getText('term') );
		
		$this->setContentType( EzApiContentTypes::JSON );
		$this->setResponseContent( Wikia::json_encode( $ret ) );
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/**
	 * Tracks API requests via Scribe
	 *
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 * @param $trackingData Array Required, a set of strings/numbers that will be concatenated with '/'
	 */
	private function track( $trackingData ){
		global $wgDevelEnvironment;
		
		if( !$wgDevelEnvironment ) {
			try {
				$params = array(
					'app' => self::APP_NAME,
					'os' => $this->mOS,
					'uri' => implode('/', $trackingData),
					'time' => time(),
				);
								
				$data = Wikia::json_encode( array(
					'method' => self::SCRIBE_KEY,
					'params' => $params
				) );
				
				WScribeClient::singleton( 'trigger' )->send( $data );
			}
			catch( TException $e ) {
				Wikia::log( __METHOD__, 'scribeClient exception', $e->getMessage() );
			}
		}
	}
}
