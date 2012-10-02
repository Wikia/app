<?php
/**
 * Game Guides mobile app API controller
 * 
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class GameGuidesController extends WikiaController {
	const API_VERSION = 1;
	const API_REVISION = 6;
	const API_MINOR_REVISION = 5;
	const APP_NAME = 'GameGuides';
	const SKIN_NAME = 'wikiaapp';

	/**
	 * @var $mModel GameGuidesModel
	 */
	private $mModel = null;
	private $mPlatform = null;
	
	function init() {
		$requestedVersion = $this->request->getInt( 'ver', self::API_VERSION );
		$requestedRevision = $this->request->getInt( 'rev', self::API_REVISION );
		
		if ( $requestedVersion != self::API_VERSION || $requestedRevision != self::API_REVISION ) {
			throw new  GameGuidesWrongAPIVersionException();
		}
		
		$this->mModel = F::build( 'GameGuidesModel' );
		$this->mPlatform = $this->request->getVal( 'os' );
	}
	
	/*
	 * @brief Returns a list of recommended wikis with some data from Oasis' ThemeSettings
	 * 
	 * @requestParam integer $limit [OPTIONAL] the maximum number of results for this call
	 * @requestParam integer $batch [OPTIONAL] the batch of results for this call, used only when $limit is passed in
	 * 
	 * @responseParam see GameGuidesModel::getWikiList
	 * @see GameGuidesModel::getWikiList
	 */
	public function listWikis(){
		$this->wf->profileIn( __METHOD__ );
		$this->track( array( 'list_games' ) );
		
		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->mModel->getWikisList( $limit, $batch );
		
		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}
		
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/*
	 * @brief Returns a collection of data for the current wiki to use in the
	 * per-wiki screen of the application
	 * 
	 * @responseParam see GameGuidesModel::getWikiContents
	 * @see GameGuidesModel::getWikiContents
	 */
	public function listWikiContents(){
		$this->wf->profileIn( __METHOD__ );
		$this->track( array( 'list_wiki_contents', $this->wg->DBname ) );
		
		$result = $this->mModel->getWikiContents();
		
		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/*
	 * @brief Returns all the contents associated to a category for the current wiki
	 * 
	 * @requestParam string $category the name of the category to fetch contents from
	 * @requestParam integer $limit [OPTIONAL] the maximum number of results for this call
	 * @requestParam integer $batch [OPTIONAL] the batch of results for this call, used only when $limit is passed in
	 * 
	 * @responseParam see GameGuidesModel::getCategoryContents
	 * @see GameGuidesModel::getCategoryContents
	 */
	public function listCategoryContents(){
		$this->wf->profileIn( __METHOD__ );
		
		$category = $this->getVal('category');
		$this->track( array( 'list_category_contents', $this->wg->DBname, $category ) );
		
		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->mModel->getCategoryContents( $category, $limit, $batch );
		
		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * @brief Returns the results from a local wiki search for the passed in term
	 * 
	 * @reqeustParam string $term the term to search for
	 * @requestParam integer $limit [OPTIONAL] the maximum number of results for this call
	 * @requestParam integer $batch [OPTIONAL] the batch of results for this call, used only when $limit is passed in
	 * 
	 * @responseParam see GameGuidesModel::getSearchResults
	 * @see GameGuidesModel::getSearchResults
	 */
	public function search(){
		$this->wf->profileIn( __METHOD__ );
		
		$this->track( array( 'local_search', $this->wg->DBname ) );
		
		$term = $this->request->getVal( 'term' );
		$limit = $this->request->getInt( 'limit', GameGuidesModel::SEARCH_RESULTS_LIMIT );
		$result = $this->mModel->getSearchResults( $term, $limit );
		
		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}
		
		$this->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * @brief Tracks API requests via Scribe
	 * 
	 * @param array $trackingData Required, a set of strings/numbers that will be concatenated with '/'
	 * 
	 * @see MobileStatsController
	 */
	private function track( $trackingData ){
		$this->sendRequest( 'MobileStats', 'track', array(
			'appName' => self::APP_NAME,
			'URIData' => $trackingData,
			'platform' => $this->mPlatform
		) );
	}

	/**
	 * Api entry point to get a page and globals and messages that are relevant to the page
	 *
	 * @example wikia.php?controller=GameGuides&method=getPage&title={Title}
	 */
	public function getPage(){
		$this->response->setFormat( 'json' );

		//set mobile skin as this is based on it
		RequestContext::getMain()->setSkin(
			Skin::newFromKey( 'wikiamobile' )
		);

		$titleName = $this->getVal( 'title' );

		$relatedPages = ( !empty( $this->wg->EnableRelatedPagesExt ) &&
			empty( $this->wg->MakeWikiWebsite ) &&
			empty( $this->wg->EnableAnswers ) ) ? $this->app->sendRequest( 'RelatedPagesController', 'index', array(
				'categories' => $this->wg->Title->getParentCategories()
			) ) : null;

		if ( !is_null( $relatedPages ) ) {
			$this->response->setVal( 'relatedPages', $relatedPages->getVal( 'pages' ) );
		}

		$this->response->setVal( 'html', $this->sendSelfRequest( 'renderPage', array(
			'title' => $titleName
		) )->toString() );
	}

	public function renderPage(){
		$titleName = $this->request->getVal( 'title' );

		$params = array(
			'action' => 'parse',
			'page' => $titleName,
			'prop' => 'text',
			'redirects' => 1,
			'useskin' => 'wikiamobile'
		);

		$html = ApiService::call( $params );

		$globals = $this->sendSelfRequest( 'getGlobals' );

		$this->response->setVal( 'globals', $globals->getVal( 'globals' ) );
		$this->response->setVal( 'messages', F::build( 'JSMessages' )->getPackages( array( 'GameGuides' ) ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		$this->response->setVal( 'html', $html['parse']['text']['*'] );
	}

	/**
	 * helper function to build a GameGuidesSpecial Preview
	 * it returns a page and all 'global' assets
	 */
	public function renderFullPage(){
		$resources = $this->sendRequest( 'AssetsManager', 'getMultiTypePackage', array(
			'scripts' => 'gameguides_js,wikiamobile_scroll_js,wikiamobile_tables_js',
			'styles' => '//extensions/wikia/GameGuides/css/GameGuides.scss'
		) );

		$js = $resources->getVal( 'scripts', '' );
		$scripts = '';

		foreach( $js as $s ) {
			$scripts .= $s;
		}

		$styles = $resources->getVal( 'styles', '' );

		$page = $this->sendSelfRequest( 'getPage', array(
			'title' => $this->getVal( 'title')
		) );

		$this->response->setVal( 'html', $page->getVal( 'html' ) );
		$this->response->setVal( 'js', $scripts );
		$this->response->setVal( 'css', $styles );
	}

	public function getResourcesUrl(){
		$cb = $this->wg->CacheBuster;
		$this->response->setVal( 'url',
			//How can I build this url ?
			'wikia.php?controller=AssetsManager&method=getMultiTypePackage&scripts=gameguides_js,wikiamobile_tables_js,wikiamobile_scroll_js&styles=//extensions/wikia/GameGuides/css/GameGuides.scss?cb=' . $cb
		);
		$this->response->setVal( 'cb', $cb );
	}

	/**
	 * Simple API Call to get latest CB value
	 *
	 * @return Integer CB Value
	 */
	public function getCB(){
		$this->setVal( 'cb', $this->wg->CacheBuster );
	}

	/**
	 * function returns globals needed for an Article
	 */
	public function getGlobals(){
		$wg = F::app()->wg;
		$skin = Skin::newFromKey( 'wikiamobile' );

		//global variables
		//from Output class
		//and from ResourceLoaderStartUpModule
		$res = new ResourceVariablesGetter();
		$vars = array_intersect_key(
			$wg->Out->getJSVars() + $res->get(),
			array_flip( $wg->GameGuidesGlobalsWhiteList )
		);

		$this->setVal( 'globals', WikiaSkin::makeInlineVariablesScript( $vars ) . $skin->getTopScripts() );
	}

	public function getContent(){
		$this->response->setFormat( 'json' );

		$this->response->setVal( 'content', WikiFactory::getVarValueByName( 'wgWikiaGameGuidesContent', $this->wg->CityId ) );
	}
}

class GameGuidesWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}