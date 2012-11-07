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
	const VARNISH_CACHE_TIME = 86400; //24h

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
		
		$term = $this->request->getVal( 'term' );
		$limit = $this->request->getInt( 'limit', GameGuidesModel::SEARCH_RESULTS_LIMIT );
		$result = $this->mModel->getSearchResults( $term, $limit );
		
		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}
		
		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * @brief Api entry point to get a page and globals and messages that are relevant to the page
	 *
	 * @example wikia.php?controller=GameGuides&method=getPage&title={Title}
	 */
	public function getPage(){
		//This will always return json
		$this->response->setFormat( 'json' );

		$this->response->setCacheValidity(
			self::VARNISH_CACHE_TIME,
			self::VARNISH_CACHE_TIME,
			array(
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		//set mobile skin as this is based on it
		RequestContext::getMain()->setSkin(
			Skin::newFromKey( 'wikiamobile' )
		);

		$titleName = $this->getVal( 'title' );

		$title = Title::newFromText( $titleName );
		$revId = $title->getLatestRevID();

		if ( $revId > 0 ) {
			$relatedPages = (
				!empty( $this->wg->EnableRelatedPagesExt ) &&
					empty( $this->wg->MakeWikiWebsite ) &&
					empty( $this->wg->EnableAnswers ) ) ?
				$this->app->sendRequest( 'RelatedPagesController', 'index', array(
						'categories' => $this->wg->Title->getParentCategories()
					)
				) : null;

			if ( !is_null( $relatedPages ) ) {
				$relatedPages = $relatedPages->getVal('pages');

				if ( !empty ( $relatedPages ) ) {
					$this->response->setVal( 'relatedPages', $relatedPages );
				}
			}

			$this->response->setVal(
				'html',
				$this->sendSelfRequest( 'renderPage', array(
						'title' => $titleName
					)
				)->toString() );

			$this->response->setVal(
				'revisionid',
				$title->getLatestRevID()
			);
		} else {
			$this->response->setVal( 'error', 'Revision ID = 0' );
		}
	}

	/**
	 * @param string $method method name
	 * @param array $parameters parameters that are part of a url
	 * @return string url to be purged
	 */
	static function getVarnishUrl( $method = 'index', $parameters = array() ){
		$app = F::app();

		$url = $app->wg->Server . '/wikia.php?';

		$params = array(
			'controller' => str_replace( 'Controller', '', __CLASS__ ),
			'method' => $method
		);

		$params = array_merge( $params, $parameters );

		return $url . http_build_query( $params );
	}

	/**
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	static function onTitleGetSquidURLs( $title, &$urls ){
		$urls[] = GameGuidesController::getVarnishUrl( 'getPage', array(
			'title' => $title->getPartialURL()
		));

		return true;
	}

	/**
	 * @brief this is a function that return rendered article
	 *
	 * @requestParam String title of a page
	 */
	public function renderPage(){
		$titleName = $this->request->getVal( 'title' );

		$html = ApiService::call(
			array(
				'action' => 'parse',
				'page' => $titleName,
				'prop' => 'text',
				'redirects' => 1,
				'useskin' => 'wikiamobile'
			)
		);

		$globals = $this->sendSelfRequest( 'getGlobals' );

		$this->response->setVal( 'globals', $globals->getVal( 'globals' ) );
		$this->response->setVal( 'messages', F::build( 'JSMessages' )->getPackages( array( 'GameGuides' ) ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		$this->response->setVal( 'html', $html['parse']['text']['*'] );
	}

	/**
	 * @brief helper function to build a GameGuidesSpecial Preview
	 * it returns a page and all 'global' assets
	 */
	public function renderFullPage(){
		$resources = $this->sendRequest( 'AssetsManager', 'getMultiTypePackage', array(
			'scripts' => 'gameguides_js',
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

	/**
	 * @brief function that returns a valid and current link to resources of GG
	 *
	 * @responseParam String url to current resources
	 * @responseParam Integer cb current style version number
	 */
	public function getResourcesUrl(){
		$this->response->setFormat( 'json' );

		$this->response->setVal( 'url',
			AssetsManager::getInstance()->getMultiTypePackageURL(
				array(
					'scripts' => 'gameguides_js',
					'styles' => '//extensions/wikia/GameGuides/css/GameGuides.scss'
				),
				true
			)
		);

		$this->response->setVal( 'cb', $this->wg->StyleVersion );
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

	/**
	 * API to get data from Game Guides Content Managment Tool in json
	 *
	 * make sure that name of this function is aligned
	 * with what is in onGameGuidesContentSave to purge varnish correctly
	 *
	 * $return response['tags'] List of tags in a format:
	 *
	 * {tags:[
	 * 		{
	 * 			name: 'name',
	 * 			categories:
	 * 			{
	 * 				category: 'Category',
	 * 				name: 'Name'
	 * 			}
	 * 		}
	 * ]}
	 */
	public function getList(){
		$this->response->setFormat( 'json' );

		$this->response->setCacheValidity(
			self::VARNISH_CACHE_TIME,
			self::VARNISH_CACHE_TIME,
			array(
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$content = WikiFactory::getVarValueByName( 'wgWikiaGameGuidesContent', $this->wg->CityId );

		if ( empty( $content ) ) {
			$this->getCategories();
		} else {
			$tag = $this->request->getVal( 'tag' );

			if ( empty( $tag ) ) {
				$this->getTags( $content );
			} else {
				$this->getTagCategories( $content, $tag );
			}
		}
	}

	/**
	 *
	 * Returns list of categories on a wiki in batches by 25
	 *
	 * @requestParam Integer limit
	 * @requestParam String offset
	 *
	 * @response categories
	 * @response offset
	 */
	private function getCategories(){
		$limit = $this->request->getVal( 'limit', 25 );
		$continue = $this->request->getVal( 'offset' );

		$params = array(
			'action' => 'query',
			'list' => 'allcategories',
			'aclimit' => $limit
		);

		if( !is_null( $continue ) ) {
			$params['acfrom'] = $continue;
		}

		$categories = ApiService::call( $params );
		$allCategories = $categories['query']['allcategories'];

		if ( !empty( $allCategories ) ) {

			foreach( $allCategories as $key => $value ) {
				$allCategories[$key] = array( 'name' => $value['*'] );
			}

			$this->response->setVal( 'categories', $allCategories );

			if ( !empty( $categories['query-continue'] ) ) {
				$this->response->setVal( 'offset', $categories['query-continue']['allcategories']['acfrom'] );
			}

		} else {
			$this->response->setVal( 'error', true );
		}
	}

	private function getTagCategories( $content, $requestTag ){
		$ret = false;

		foreach( $content as $tag ){
			if ( $requestTag == $tag['name'] ) {
				$ret = $tag;
			}
		}

		$this->response->setVal( 'tag', $ret );
	}

	private function getTags( $content ) {
		$this->response->setVal(
			'tags',
			array_reduce(
				$content,
				function( $ret, $item){
					$ret[] = array( 'name' => $item['name'] );
					return $ret;
				}
			)
		);
	}

	/**
	 * @requestParam String category
	 * @requestParam Integer limit [optional]
	 * @requestParam String offset [optional]
	 *
	 * @return Array of articles
	 */
	public function getArticles(){
		$this->response->setFormat( 'json' );

		$requestCategory = $this->request->getVal( 'category' );
		$limit = $this->request->getVal( 'limit', 25 );
		$continue = $this->request->getVal( 'offset' );

		$params = array(
			'action' => 'query',
			'list' => 'categorymembers',
			'cmtitle' => 'Category:' . $requestCategory,
			'cmlimit' => $limit,
			'cmtype' => 'page|subcat',
			'cmprop' => 'ids|title'
		);

		if( !is_null( $continue ) ) {
			$params['cmcontinue'] = $continue;
		}

		$articles = ApiService::call( $params );

		if ( !empty( $articles['query']['categorymembers'] ) ) {
			$this->response->setVal( 'articles', $articles['query']['categorymembers']);

			if ( !empty( $articles['query-continue'] ) ) {
				$this->response->setVal( 'offset', $articles['query-continue']['categorymembers']['cmcontinue']);
			}
		} else {
			$this->response->setVal( 'error', true );
		}

	}

	/**
	 * @brief Whenever data is saved in GG Content Managment Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onGameGuidesContentSave(){
		$app = F::app();

		SquidUpdate::purge(
			array(
				$app->wf->AppendQuery(
					$app->wf->ExpandUrl( $app->wg->Server . $app->wg->ScriptPath . '/wikia.php' ),
					array(
						'controller' => __CLASS__,
						'method' => 'getList'
					)
				)
			)
		);

		return true;
	}
}

class GameGuidesWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}