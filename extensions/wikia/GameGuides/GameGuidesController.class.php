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
	const SKIN_NAME = 'wikiamobile';
	const SECONDS_IN_A_DAY = 86400; //24h
	const SIX_HOURS = 21600; //6h
	const LIMIT = 25;

	const NEW_API_VERSION = 1;

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

		$this->mModel = (new GameGuidesModel);
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
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->mModel->getWikisList( $limit, $batch );

		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
	}

	/*
	 * @brief Returns a collection of data for the current wiki to use in the
	 * per-wiki screen of the application
	 *
	 * @responseParam see GameGuidesModel::getWikiContents
	 * @see GameGuidesModel::getWikiContents
	 */

	public function listWikiContents(){
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$result = $this->mModel->getWikiContents();

		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$category = $this->getVal('category');


		$limit = $this->request->getInt( 'limit', null );
		$batch = $this->request->getInt( 'batch', 1 );
		$result = $this->mModel->getCategoryContents( $category, $limit, $batch );

		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		Wikia::log( __METHOD__, '', '', true );

		$this->response->setFormat( 'json' );

		$term = $this->request->getVal( 'term' );
		$limit = $this->request->getInt( 'limit', GameGuidesModel::SEARCH_RESULTS_LIMIT );
		$result = $this->mModel->getSearchResults( $term, $limit );

		foreach( $result as $key => $value ){
			$this->response->setVal( $key, $value );
		}

		wfProfileOut( __METHOD__ );
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
	 * @example wikia.php?controller=GameGuides&method=getPage&page={Title}
	 */
	public function getPage(){
		global $wgTitle;

		//This will always return json
		$this->response->setFormat( 'json' );

		$this->cacheMeFor( 7 );//a week

		//set mobile skin as this is based on it
		RequestContext::getMain()->setSkin(
			Skin::newFromKey( 'wikiamobile' )
		);

		$titleName = $this->getVal( 'page' );

		$title = Title::newFromText( $titleName );

		if ( $title instanceof Title ) {
			RequestContext::getMain()->setTitle( $title );
			$wgTitle = $title;

			$revId = $title->getLatestRevID();

			if ( $revId > 0 ) {
				$relatedPages = (
					!empty( $this->wg->EnableRelatedPagesExt ) &&
						empty( $this->wg->MakeWikiWebsite ) &&
						empty( $this->wg->EnableAnswers ) ) ?
					$this->app->sendRequest( 'RelatedPages', 'index',
						array(
							'categories' => $this->wg->Title->getParentCategories()
						)
					) : null;

				if ( !is_null( $relatedPages ) ) {
					$relatedPages = $relatedPages->getVal( 'pages' );

					if ( !empty ( $relatedPages ) ) {
						$this->response->setVal( 'relatedPages', $relatedPages );
					}
				}

				$this->response->setVal(
					'html',
					$this->sendSelfRequest( 'renderPage', array(
							'page' => $titleName
						)
					)->toString() );

				$this->response->setVal(
					'revisionid',
					$revId
				);
			} else {
				throw new NotFoundApiException( 'Revision ID = 0' );
			}
		} else {
			throw new NotFoundApiException( 'Title not found' );
		}
	}

	/**
	 * @param $title Title
	 * @param $urls String[]
	 * @return bool
	 */
	static function onTitleGetSquidURLs( $title, &$urls ){
		$urls[] = GameGuidesController::getUrl( 'getPage', array(
			'page' => $title->getPartialURL()
		));

		return true;
	}

	/**
	 * @brief this is a function that return rendered article
	 *
	 * @requestParam String title of a page
	 */
	public function renderPage(){
		wfProfileIn( __METHOD__ );

		$titleName = $this->request->getVal( 'page' );

		$html = ApiService::call(
			array(
				'action' => 'parse',
				'page' => $titleName,
				'prop' => 'text',
				'redirects' => 1,
				'useskin' => 'wikiamobile'
			)
		);

		$this->response->setVal( 'globals', Skin::newFromKey( 'wikiamobile' )->getTopScripts() );
		$this->response->setVal( 'messages', JSMessages::getPackages( array( 'GameGuides' ) ) );
		$this->response->setVal( 'title', Title::newFromText( $titleName )->getText() );
		$this->response->setVal( 'html', $html['parse']['text']['*'] );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief helper function to build a GameGuidesSpecial Preview
	 * it returns a page and all 'global' assets
	 */
	public function renderFullPage(){
		wfProfileIn( __METHOD__ );

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
			'page' => $this->getVal( 'page')
		) );

		$this->response->setVal( 'html', $page->getVal( 'html' ) );
		$this->response->setVal( 'js', $scripts );
		$this->response->setVal( 'css', $styles );

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( 'json' );

		$content = $this->wg->WikiaGameGuidesContent;

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

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		$limit = $this->request->getVal( 'limit', self::LIMIT * 2 );
		$offset = $this->request->getVal( 'offset', '' );

		$categories = WikiaDataAccess::cache(
			wfMemcKey( __METHOD__, $offset, $limit, self::NEW_API_VERSION ),
			self::SIX_HOURS,
			function() use ( $limit, $offset ) {
				return ApiService::call(
					array(
						'action' => 'query',
						'list' => 'allcategories',
						'redirects' => true,
						'aclimit' => $limit,
						'acfrom' => $offset,
						'acprop' => 'id|size',
						//We don't want empty categories to show up
						'acmin' => 1
					)
				);
			}
		);

		$allCategories = $categories['query']['allcategories'];

		if ( !empty( $allCategories ) ) {

			$ret = [];

			foreach( $allCategories as $value ) {
				if($value['size'] - $value['files'] > 0){

					$ret[] = array(
						'title' => $value['*'],
						'id'=> isset( $value['pageid'] ) ? (int) $value['pageid'] : 0
					);
				}
			}

			$this->response->setVal( 'items', $ret );

			if ( !empty( $categories['query-continue'] ) ) {
				$this->response->setVal( 'offset', $categories['query-continue']['allcategories']['acfrom'] );
			}

		} else {
			wfProfileOut( __METHOD__ );
			throw new NotFoundApiException( 'No Categories' );
		}

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		$ret = false;

		foreach( $content as $tag ){
			if ( $requestTag == $tag['title'] ) {
				$ret = $tag['categories'];
			}
		}

		if ( !empty( $ret ) ) {
			$sort = $this->request->getVal( 'sort' );

			if ( !empty( $sort ) ) {
				if ( $sort == 'alpha' ) {
					usort($ret, function( $a, $b ){
						return strcasecmp($a['title'], $b['title']);
					});
				} else if ( $sort == 'hot' ) {
					$hot = array_keys(
						DataMartService::getTopArticlesByPageview(
							$this->wg->CityId,
							array_reduce($ret, function($ret, $item){
								$ret[] = $item['id'];
								return $ret;
							}),
							null,
							false,
							//I need all of them basically
							count( $ret )
						)
					);

					$sorted = [];
					$left = [];
					foreach ( $ret as $value ) {
						$key = array_search( $value['id'], $hot );

						if ( $key === false ) {
							$left[] = $value;
						} else {
							$sorted[$key] = $value;
						}
					}

					ksort( $sorted );

					$ret = array_merge( $sorted, $left );
				} else {
					wfProfileOut( __METHOD__ );
					throw new InvalidParameterApiException( 'sort' );
				}
			}

			//Use 'id' instead of image_id
			foreach( $ret as &$value ) {
				if ( !empty( $value['image_id'] ) ) {
					$value['id'] = $value['image_id'];
				}
				unset($value['image_id']);
			}

			$this->response->setVal( 'items', $ret );
		} else if ( $requestTag !== '' ) {
			wfProfileOut( __METHOD__ );
			throw new InvalidParameterApiException( 'tag' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @param $content Array content of a wgWikiaGameGuidesContent
	 *
	 * @responseReturn Array tags List of tags on a wiki
	 * @responseReturn See getTagCategories
	 */
	private function getTags( $content ) {
		wfProfileIn( __METHOD__ );

		$this->response->setVal(
			'tags',
			array_reduce(
				$content,
				function( $ret, $item ) {
					if( $item['title'] !== '' ) {
						$ret[] = array(
							'title' => $item['title'],
							'id' => isset( $item['image_id'] ) ? $item['image_id'] : 0
						);
					}

					return $ret;
				}
			)
		);

		//there also might be some categories without TAG, lets find them as well
		$this->getTagCategories( $content, '' );

		wfProfileOut( __METHOD__ );
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

	/**
	 *
	 */
	function getVideos() {
		wfProfileIn( __METHOD__ );

		$this->response->setFormat( 'json' );
		//We have full control on when this data change so lets cache it for a longer period of time
		$this->cacheMeFor( 120 );

		$lang = $this->request->getVal( 'lang' , 'en' );

		$languages = $this->wg->WikiaGameGuidesSponsoredVideos;

		if( !empty( $languages ) ) {
			if ( array_key_exists( $lang, $languages ) ) {
				$this->response->setVal( 'items', $languages[$lang] );
			} else if ( $lang == 'list' ) {
				$this->response->setVal( 'items', array_keys( $languages ) );
			} else {
				throw new NotFoundApiException( 'No data found for \'' . $lang . '\' language' );
			}

		} else {
			throw new NotFoundApiException( 'No data is available now' );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @brief Whenever data is saved in GG Sponsored Videos Tool
	 * purge Varnish cache for it
	 *
	 * @return bool
	 */
	static function onGameGuidesSponsoredSave(){
		$languages = array_keys( F::app()->wg->WikiaGameGuidesSponsoredVideos );
		//Empty array is there to purge call to getVideos without any language
		$variants = [
			[],
			['lang' => 'list']
		];

		foreach ( $languages as $lang ) {
			$variants[] = [
				'lang' => $lang
			];
		}

		self::purgeMethodVariants(
			'getVideos',
			$variants
		);

		return true;
	}
}

class GameGuidesWrongAPIVersionException extends WikiaException {
	function __construct() {
		parent::__construct( 'Wrong API version', 801 );
	}
}
