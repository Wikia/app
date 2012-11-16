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
	const SECONDS_IN_A_DAY = 86400; //24h
	const SIX_HOURS = 21600; //6h
	const LIMIT = 25;

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
	 * Simple DRY function to set cache for 24 hours
	 */
	private function cacheMeFor( $days = 1 ){
		$this->response->setCacheValidity(
			self::SECONDS_IN_A_DAY * $days, //86400 = 24h
			self::SECONDS_IN_A_DAY * $days,
			array(
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}

	/**
	 * @brief Api entry point to get a page and globals and messages that are relevant to the page
	 *
	 * @example wikia.php?controller=GameGuides&method=getPage&title={Title}
	 */
	public function getPage(){
		//This will always return json
		$this->response->setFormat( 'json' );

		$this->cacheMeFor( 7 );//a week

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
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	static function onTitleGetSquidURLs( $title, &$urls ){
		$urls[] = GameGuidesController::getUrl( 'getPage', array(
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
		$this->wf->profileIn( __METHOD__ );

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

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * @brief helper function to build a GameGuidesSpecial Preview
	 * it returns a page and all 'global' assets
	 */
	public function renderFullPage(){
		$this->wf->profileIn( __METHOD__ );

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

		$this->wf->profileOut( __METHOD__ );
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

		$this->response->setVal( 'cb', (string) $this->wg->StyleVersion );
	}

	/**
	 * function returns globals needed for an Article
	 */
	public function getGlobals(){
		$this->wf->profileIn( __METHOD__ );

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

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * API to get data from Game Guides Content Managment Tool in json
	 *
	 * make sure that name of this function is aligned
	 * with what is in onGameGuidesContentSave to purge varnish correctly
	 *
	 * @return {}
	 *
	 * getList - list of tags on a wiki or list of all categories if GGCMT was not used (this will be cached)
	 * getList&offset='' - next page of categories if no tages were given
	 * getList&tag='' - list of all members of a given tag
	 *
	 */
	public function getList(){
		$this->wf->profileIn( __METHOD__ );

		$this->response->setFormat( 'json' );

		$content = WikiFactory::getVarValueByName( 'wgWikiaGameGuidesContent', $this->wg->CityId );

		if ( empty( $content ) ) {
			$this->getCategories();
		} else {
			$tag = $this->request->getVal( 'tag' );

			if ( empty( $tag ) ) {
				$this->cacheMeFor( 14 ); //2 weeks
				$this->getTags( $content );
			} else {
				$this->getTagCategories( $content, $tag );
			}
		}

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 *
	 * Returns list of categories on a wiki in batches by self::LIMIT
	 *
	 * @requestParam Integer limit
	 * @requestParam String offset
	 *
	 * @response categories
	 * @response offset
	 */
	private function getCategories(){
		$this->wf->profileIn( __METHOD__ );

		$limit = $this->request->getVal( 'limit', self::LIMIT );
		$offset = $this->request->getVal( 'offset', '' );

		$categories = WikiaDataAccess::cache(
			$this->wf->memcKey( __METHOD__, $offset, $limit ),
			self::SIX_HOURS,
			function() use ( $limit, $offset ) {
				return ApiService::call(
					array(
						'action' => 'query',
						'list' => 'allcategories',
						'aclimit' => $limit,
						'acfrom' => $offset
					)
				);
			}
		);

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
			$this->response->setVal( 'error', 'No Categories' );
		}

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 *
	 * Returns Categories under a given Tag
	 *
	 * @param $content
	 * @param $requestTag
	 *
	 * @responseReturn Array|false Categories or false if tag was not found
	 */
	private function getTagCategories( $content, $requestTag ){
		$this->wf->profileIn( __METHOD__ );

		$ret = false;

		foreach( $content as $tag ){
			if ( $requestTag == $tag['name'] ) {
				$ret = $tag['categories'];
			}
		}

		$this->response->setVal( 'categories', $ret );

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * @param $content Array content of a wgWikiaGameGuidesContent
	 *
	 * @responseReturn Array tags List of tags on a wiki
	 * @responseReturn See getTagCategories
	 */
	private function getTags( $content ) {
		$this->wf->profileIn( __METHOD__ );

		$this->response->setVal(
			'tags',
			array_reduce(
				$content,
				function( $ret, $item ) {
					$ret[] = array( 'name' => $item['name'] );
					return $ret;
				}
			)
		);

		//there also might be some categories without TAG, lets find them as well
		$this->getTagCategories( $content, '' );

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * @requestParam String category
	 * @requestParam Integer limit [optional]
	 * @requestParam String offset [optional]
	 *
	 * @return Array of articles
	 *
	 * @example method=getArticles&category=Category_Name
	 * @example method=getArticles&category=Category_Name&offset=Offset
	 * @example method=getArticles&category=Category:Category_Name&offset=Offset
	 */
	public function getArticles(){
		$this->wf->profileIn( __METHOD__ );

		$this->response->setFormat( 'json' );

		$this->cacheMeFor( 1 );

		$category = $this->request->getVal( 'category' );

		if( !empty( $category ) ) {
			//if $category does not have Category: in it, add it as API needs it
			$category = Title::newFromText( $category, NS_CATEGORY );

			if( !is_null( $category ) ) {
				$category = $category->getFullText();

				$limit = $this->request->getVal( 'limit', self::LIMIT );
				$offset = $this->request->getVal( 'offset', '' );

				$articles = WikiaDataAccess::cache(
					$this->wf->memcKey( __METHOD__, $category, $offset, $limit ),
					self::SIX_HOURS,
					function() use ( $category, $limit, $offset ){
						return ApiService::call(
							array(
								'action' => 'query',
								'list' => 'categorymembers',
								'cmtype' => 'page|subcat',
								'cmprop' => 'ids|title',
								'cmtitle' => $category,
								'cmlimit' => $limit,
								'cmcontinue' => $offset
							)
						);
					}
				);

				if ( !empty( $articles['query']['categorymembers'] ) ) {
					$this->response->setVal( 'articles', $articles['query']['categorymembers']);

					if ( !empty( $articles['query-continue'] ) ) {
						$this->response->setVal( 'offset', $articles['query-continue']['categorymembers']['cmcontinue']);
					}
				} else {
					$this->response->setVal( 'error', 'No members' );
				}
			} else {
				$this->response->setVal( 'error', 'Title::newFromText returned null' );
			}
		} else {
			$this->response->setVal( 'error', 'No category given' );
		}


		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * @brief Whenever data is saved in GG Content Managment Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onGameGuidesContentSave(){
		self::purgeMethod( 'getList' );

		return true;
	}
}

class GameGuidesWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}
