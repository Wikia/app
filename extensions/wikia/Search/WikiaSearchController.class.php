<?php
class WikiaSearchController extends WikiaSpecialPageController {


	const RESULTS_PER_PAGE = 25;
	const PAGES_PER_WINDOW = 5;

	/**
	 * @var WikiaSearch
	 */
	protected $wikiaSearch = null;

	public function __construct() {
        // note: this is required since we haven't constructed $this->wg yet
		global $wgWikiaSearchIsDefault;

		$this->wikiaSearch = F::build('WikiaSearch');
		$specialPageName = $wgWikiaSearchIsDefault ? 'Search' : 'WikiaSearch';
		parent::__construct( $specialPageName, $specialPageName, false );
	}

	protected function  isCorporateWiki() {
		return !empty($this->wg->EnableWikiaHomePageExt);
	}

	public function index() {
		$this->wg->Out->addHTML( F::build('JSSnippets')->addToStack( array( "/extensions/wikia/Search/js/WikiaSearch.js" ) ) );
		$this->wg->SuppressRail = true;

		$skin = $this->wg->User->getSkin();
		$showSearchAds = false;
		if (!empty($this->wg->EnableWikiaSearchAds)) {
			if (!empty($this->wg->NoExternals)) {
				// don't show ads in search
			} elseif (is_object($this->wg->User) && $this->wg->User->isLoggedIn() && !($this->wg->User->getOption('showAds') || !empty($_GET['showads']))) {
				// don't show ads in search
			} elseif ((! $skin instanceof SkinMonoBook) && (! $skin instanceof SkinVector)) {
				$this->app->registerHook('MakeGlobalVariablesScript', 'WikiaSearchAdsController', 'onMakeGlobalVariablesScript');
				$this->response->addAsset('extensions/wikia/Search/js/WikiaSearchAds.js');
				$showSearchAds = true;
			}
		}

		if ( $skin instanceof SkinMonoBook ) {
			$this->response->addAsset('extensions/wikia/Search/monobook/monobook.scss');
		}
		if ( get_class($this->wg->User->getSkin()) == 'SkinOasis' ) {
			$this->response->addAsset('extensions/wikia/Search/css/WikiaSearch.scss');
		}

		$searchConfig = F::build('WikiaSearchConfig');
		
		$query = $this->getVal('query', $this->getVal('search'));
		$query = htmlentities( Sanitizer::StripAllTags ( $query ), ENT_COMPAT, 'UTF-8' );
		$limit = $this->getVal('limit', self::RESULTS_PER_PAGE);
		$page = $this->getVal('page', 1);
		$rank = $this->getVal('rank', 'default');
		$debug = $this->request->getBool('debug', false);
		$crossWikia = $this->request->getBool('crossWikia', false);
		$skipCache = $this->request->getBool('skipCache', false);
		$advanced = $this->getVal( 'advanced', false );
		$hub = ($this->getVal('nohub') != '1') ? $this->getVal('hub', false) : false;
		$redirs = !empty($advanced) ? $this->request->getBool('redirs', false) : false;

		$searchableNamespaces = SearchEngine::searchableNamespaces();
		$namespaces = array();
		foreach($searchableNamespaces as $i => $name) {
			if ($ns = $this->getVal('ns'.$i)) {
				$namespaces[] = $i;
			}
		}
		if (empty($namespaces) && $this->wg->User->getOption('searchAllNamespaces')) {
			$namespaces = array_keys($searchableNamespaces);
		}

		//  Check for crossWikia value set in url.  Otherwise, check if we're on the corporate wiki
		$isInterWiki = $crossWikia ? true : $this->isCorporateWiki();

		if($this->isCorporateWiki()) {
			OasisController::addBodyClass('inter-wiki-search');
		}

		$results = false;
		$resultsFound = 0;
		$paginationLinks = '';
		if( !empty( $query ) ) {
			$articleMatch = $this->wikiaSearch->getArticleMatch($query);
			if (!empty($articleMatch) && $this->getVal('fulltext', '0') === '0') {

				$article = isset($articleMatch['redirect']) ? $articleMatch['redirect'] : $articleMatch['article'];
				$title = $article->getTitle();

				wfRunHooks( 'SpecialSearchIsgomatch', array( &$title, $query ) );

				Track::event( 'search_start_gomatch', array( 'sterm' => $query, 'rver' => 0 ) );
				$this->response->redirect( $title->getFullURL() );
			}
			elseif(!empty($articleMatch)) {
				Track::event( 'search_start_match', array( 'sterm' => $query, 'rver' => 0 ) );
			} else {
				$title = Title::newFromText( $query );
				if ( !is_null( $title ) ) {
					wfRunHooks( 'SpecialSearchNogomatch', array( &$title ) );
				}
			}

			$isGrouped = $isInterWiki || $this->getVal('grouped', false);

			$searchConfig->setQuery				( $query )
						 ->setLength			( $limit )
						 ->setPage				( $page )
						 ->setRank				( $rank )
						 ->setCityId			( $isInterWiki ? 0 : $this->wg->CityId )
						 ->setGroupResults		( $isGrouped )
						 ->setHub				( $hub )
						 ->setVideoSearch		( $this->getVal('videoSearch', false) )
						 ->setSkipCache			( $skipCache )
						 ->setIncludeRedirects	( $redirs )
						 ->setNamespaces		( $namespaces )
						 ->setArticleMatch		( $articleMatch )
			;

			$results = $this->wikiaSearch->doSearch( $query, $searchConfig );

			$resultsFound = $results->getResultsFound();

			if(!empty($resultsFound)) {
				// @TODO: refactor paginationparams into SearchConfig, use searchConfig in self request controller action
				$paginationParams = array(
						'query' => $query, 
						'page' => $page, 
						'count' => $resultsFound, 
						'crossWikia' => $isInterWiki, 
						'skipCache' => $skipCache, 
						'debug' => $debug, 
						'namespaces' => $namespaces, 
						'advanced' => $advanced, 
						'redirs' => $redirs, 
						'limit'=>$limit);
				$paginationLinks = $this->sendSelfRequest( 	'pagination',  $paginationParams);
			}

			$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-with-query', array(ucwords($query), $this->wg->Sitename) )  );
		} else {
			if($isInterWiki) {
				$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-interwiki' ) );
			} else {
				$this->app->wg->Out->setPageTitle( $this->wf->msg( 'wikiasearch2-page-title-no-query-intrawiki', array($this->wg->Sitename) )  );
			}
		}

		$activeTab = $this->getActiveTab( $namespaces );

		if(!$isInterWiki) {
			// @TODO refactor advancedParams into searchfonfig, using searchconfig in self request
			$advancedParams = array(
					'term' => $query, 
					'namespaces' => $namespaces, 
					'searchableNamespaces' => $searchableNamespaces, 
					'advanced' => $advanced, 
					'redirs' => $redirs 
					);
			$advancedSearchBox = $this->sendSelfRequest( 'advancedBox', $advancedParams );
			$this->setval( 'advancedSearchBox', $advancedSearchBox );
		}

        if ( $this->app->checkSkin( 'wikiamobile' ) ) {
            $this->overrideTemplate( 'WikiaMobileIndex' );
        }

		/*
		 * Done to return results in json format
		 * Can be removed after upgrade to 5.4 and specify serialized Json data on WikiaSearchResult
		 * http://php.net/manual/en/jsonserializable.jsonserialize.php
		*/
		$format = $this->response->getFormat();
		if( ($format == 'json' || $format == 'jsonp') && count( $results ) ){
			$tempResults = array();
			foreach( $results as $result ){
				if($result instanceof WikiaSearchResult){
					$tempResults[] = $result->toArray(array('title', 'url'));
				}
			}
			$results = $tempResults;
		}

		//@todo see how many of these we can re-handle as searchconfig
		$this->setVal( 'results', $results );
		$this->setVal( 'resultsFound', $resultsFound );
		$this->setVal( 'resultsFoundTruncated', $this->wg->Lang->formatNum( $this->getTruncatedResultsNum($resultsFound) ) );
		$this->setVal( 'isOneResultsPageOnly', ( $resultsFound <= $limit ) );
		$this->setVal( 'pagesCount', ceil($resultsFound/$limit) );
		$this->setVal( 'currentPage',  $page );
		$this->setVal( 'paginationLinks', $paginationLinks );
		$this->setVal( 'tabs', $this->sendSelfRequest( 'tabs', array( 'term' => $query, 'redirs' => $redirs,  'activeTab' => $activeTab) ) );
		$this->setVal( 'query', $query );
		$this->setVal( 'resultsPerPage', $this->getVal('limit', $limit) );
		$this->setVal( 'pageUrl', $this->wg->Title->getFullUrl() );
		$this->setVal( 'debug', $debug );
		$this->setVal( 'solrHost', $this->wg->SolrHost);
		$this->setVal( 'isInterWiki', $isInterWiki );
		$this->setVal( 'relevancyFunctionId', WikiaSearch::RELEVANCY_FUNCTION_ID );
		$this->setVal( 'namespaces', $namespaces );
		$this->setVal( 'hub', $hub );
		$this->setVal( 'hasArticleMatch', (isset($articleMatch) && !empty($articleMatch)) );
		$this->setVal( 'isMonobook', ($this->wg->User->getSkin() instanceof SkinMonobook) );
		$this->setVal( 'showSearchAds', $query ? $showSearchAds : false );
		$this->setVal( 'isCorporateWiki', $this->isCorporateWiki() );
	}

	public function advancedBox() {
		$term = $this->getVal( 'term' );
		$namespaces = $this->getVal( 'namespaces', $this->wikiaSearch->getNamespaces() );
		$searchableNamespaces = $this->getVal( 'searchableNamespaces' );
		$advanced = $this->getVal( 'advanced' );
		$redirs = $this->getVal( 'redirs' );

		$bareterm = $term;
		if( $this->termStartsWithImage( $term ) ) {
			// Deletes prefixes
			$bareterm = substr( $term, strpos( $term, ':' ) + 1 );
		}

		$this->setVal( 'term',  $term);
		$this->setVal( 'bareterm', $bareterm );
		$this->setVal( 'namespaces', $namespaces );
		$this->setVal( 'searchableNamespaces', $searchableNamespaces );
		$this->setVal( 'redirs', $redirs );
		$this->setVal( 'advanced', $advanced);
	}

	public function tabs() {
		$term = $this->getVal( 'term' );
		$namespaces = $this->getVal( 'namespaces', $this->wikiaSearch->getNamespaces() );
		$redirs = $this->getVal( 'redirs' );
		$activeTab = $this->getVal( 'activeTab' );

		$bareterm = $term;
		if( $this->termStartsWithImage( $term ) ) {
			// Deletes prefixes
			$bareterm = substr( $term, strpos( $term, ':' ) + 1 );
		}

		$this->setVal( 'bareterm', $bareterm );
		$this->setVal( 'searchProfiles', $this->getSearchProfiles($namespaces));
		$this->setVal( 'redirs', $redirs );
		$this->setVal( 'activeTab', $activeTab );
	}

	public function advancedTabLink() {
		$term = $this->getVal('term');
		$namespaces = $this->getVal('namespaces');
		$label = $this->getVal('label');
		$tooltip = $this->getVal('tooltip');
		$params = $this->getVal('params');
		$redirs = $this->getVal('redirs');

		$opt = $params;
		foreach( $namespaces as $n ) {
			$opt['ns' . $n] = 1;
		}

		$opt['redirs'] = !empty($redirs) ? 1 : 0;
		$stParams = array_merge( array( 'search' => $term ), $opt );

		$title = F::build('SpecialPage', array( 'WikiaSearch' ), 'getTitleFor');

		$this->setVal( 'href', $title->getLocalURL( $stParams ) );
		$this->setVal( 'title', $tooltip );
		$this->setVal( 'label', $label );
		$this->setVal( 'tooltip', $tooltip );
	}

	private function getTruncatedResultsNum($resultsNum) {
		$result = $resultsNum;

		$digits = strlen( $resultsNum );
		if( $digits > 1 ) {
			$zeros = ( $digits > 3 ) ? ( $digits - 1 ) : $digits;
			$result = round( $resultsNum, ( 0 - ( $zeros - 1 ) ) );
		}

		return $result;
	}

	/*
	 * Check if query starts with image: prefix
	 * @return bool
	 */
	protected function termStartsWithImage( $term ) {
		$p = explode( ':', $term );
		if( count( $p ) > 1 ) {
			return $this->wg->ContLang->getNsIndex( $p[0] ) == NS_FILE;
		}
		return false;
	}

	protected function getSearchProfiles($namespaces) {
		// Builds list of Search Types (profiles)
		$nsAllSet = array_keys( SearchEngine::searchableNamespaces() );
		$profiles = array(
			'default' => array(
				'message' => 'wikiasearch2-tabs-articles',
				'tooltip' => 'searchprofile-articles-tooltip',
				'namespaces' => SearchEngine::defaultNamespaces(),
				'namespace-messages' => SearchEngine::namespacesAsText(
					SearchEngine::defaultNamespaces()
				),
			),
			'images' => array(
				'message' => 'wikiasearch2-tabs-photos-and-videos',
				'tooltip' => 'searchprofile-images-tooltip',
				'namespaces' => array( NS_FILE ),
			),
			'users' => array(
				'message' => 'wikiasearch2-users',
				'tooltip' => 'wikiasearch2-users-tooltip',
				'namespaces' => array( NS_USER )
			),
			'all' => array(
				'message' => 'searchprofile-everything',
				'tooltip' => 'searchprofile-everything-tooltip',
				'namespaces' => $nsAllSet,
			),
			'advanced' => array(
				'message' => 'searchprofile-advanced',
				'tooltip' => 'searchprofile-advanced-tooltip',
				'namespaces' => $namespaces,
				'parameters' => array( 'advanced' => 1 ),
			)
		);

		$this->wf->RunHooks( 'SpecialSearchProfiles', array( &$profiles ) );

		foreach( $profiles as $key => &$data ) {
			sort($data['namespaces']);
		}

		return $profiles;
	}

	protected function getActiveTab( $namespaces ) {
		if($this->request->getVal('advanced')) {
			return 'advanced';
		}

		$searchableNamespaces = array_keys( SearchEngine::searchableNamespaces() );
		$nsVals = array();

		foreach($searchableNamespaces as $ns) {
			if ($val = $this->request->getVal('ns'.$ns)) {
				$nsVals[] = $ns;
			}
		}

		if(empty($nsVals)) {
			return $this->wg->User->getOption('searchAllNamespaces') ? 'all' :  'default';
		}

		foreach( $this->getSearchProfiles( $namespaces ) as $name => $profile ) {
			if ( !count( array_diff( $nsVals, $profile['namespaces'] ) ) && !count( array_diff($profile['namespaces'], $nsVals ) )) {
				return $name;
			}
		}

		return 'advanced';
	}


	public function pagination() {
		$query = $this->getVal('query');
		$page = $this->getVal( 'page', 1 );
		$resultsCount = $this->getVal( 'count', 0);
		$limit = $this->getVal('limit', self::RESULTS_PER_PAGE);
		$pagesNum = ceil( $resultsCount / $limit );

		$crossWikia = $this->getVal('crossWikia');
		$debug = $this->getVal('debug');
		$skipCache = $this->getVal('skipCache');
		$namespaces = $this->getVal('namespaces', array());
		$advanced = $this->getVal( 'advanced' );
		$redirs = $this->getVal( 'redirs' );

		$this->setVal( 'query', $query );
		$this->setVal( 'pagesNum', $pagesNum );
		$this->setVal( 'currentPage', $page );
		$this->setVal( 'windowFirstPage', ( ( ( $page - self::PAGES_PER_WINDOW ) > 0 ) ? ( $page - self::PAGES_PER_WINDOW ) : 1 ) );
		$this->setVal( 'windowLastPage', ( ( ( $page + self::PAGES_PER_WINDOW ) < $pagesNum ) ? ( $page + self::PAGES_PER_WINDOW ) : $pagesNum ) );
		$this->setVal( 'pageTitle', $this->wg->Title );
		$this->setVal( 'crossWikia', $crossWikia );
		$this->setVal( 'resultsCount', $resultsCount );
		$this->setVal( 'skipCache', $skipCache );
		$this->setVal( 'debug', $debug );
		$this->setVal( 'namespaces', $namespaces );
		$this->setVal( 'advanced', $advanced );
		$this->setVal( 'redirs', $redirs );
		$this->setVal( 'limit', $limit );
	}

	public function getPage() {
		$pageId = $this->getVal('id');
		$metaData = $this->getVal('meta', true);

		if( !empty( $pageId ) ) {
			$page = $this->wikiaSearch->getPage( $pageId, $metaData );

			$this->response->setData( $page );
		}

		// force output format as there's no template file (BugId:18831)
		$this->getResponse()->setFormat('json');
	}

	public function getPages() {
	  $this->wg->AllowMemcacheWrites = false;
	  $ids = $this->getVal('ids');
	  $metaData = $this->getVal('meta', true);

	  if ( !empty( $ids ) ) {
	    $this->response->setData( $this->wikiaSearch->getPages($ids) );
	  }
	  $this->getResponse()->setFormat('json');

	}

	public function getPageMetaData() {
		$pageId = $this->getVal('id');

		if( !empty( $pageId ) ) {
			$metaData = $this->wikiaSearch->getPageMetaData( $pageId );

			$this->response->setData( $metaData );
		}
	}

	public function getRelatedVideos() {

	       $pageId = $this->getVal('id');
	       $params = array();
	       if ( !empty( $pageId ) ) {
		 $params['pageId'] = $pageId;
	       }
	       $responseData = $this->wikiaSearch->getRelatedVideos( $params );
	       $this->response->setData($responseData);
	       $this->response->setFormat('json');

	}

	public function getSimilarPagesExternal() {

	       $url = $this->getVal('url');
	       if ( !empty($url) ) {
		 $params = array('stream.url'=>$url);
	       } else if ($contents = $this->getVal('contents')) {
		 $params = array('stream.body'=>$contents);
	       } else {
		 throw new Exception('Please provide a url or stream contents');
	       }
	       $responseData = $this->wikiaSearch->getSimilarPages(false, $params);
	       $this->response->setData($responseData);
	       $this->response->setFormat('json');

	}

	public function getKeywords() {

       	       $pageId = $this->getVal('id');
	       $params = array();
	       if ( !empty( $pageId ) ) {
		 $params['pageId'] = $pageId;
	       }
	       $responseData = $this->wikiaSearch->getKeywords( $params );
	       $this->response->setData($responseData);
	       $this->response->setFormat('json');


	}

	public function getTagCloud() {

	  $params = $this->getTagCloudParams();

	  $this->response->setData($this->wikiaSearch->getTagCloud($params));
	  $this->response->setFormat('json');

	}

	private function getTagCloudParams()
	{
	  $params = array();
	  $params['maxpages']    = $this->getVal('maxpages', 25);
	  $params['termcount']   = $this->getVal('termcount', 50);
	  $params['maxfontsize'] = $this->getVal('maxfontsize', 56);
	  $params['minfontsize'] = $this->getVal('minfontsize', 10);
	  $params['sizetype']    = $this->getVal('sizetype', 'pt');
	  return $params;
	}

	//WikiaMobile hook to add assets so they are minified and concatenated
	public function onWikiaMobileAssetsPackages( &$jsHeadPackages, &$jsBodyPackages, &$scssPackages){
		if( F::app()->wg->Title->isSpecial('Search') ) {
			$jsBodyPackages[] = 'wikiasearch_js_wikiamobile';
			$scssPackages[] = 'wikiasearch_scss_wikiamobile';
		}

		return true;
	}

	public function videoSearch()
	{
		$query = $this->getVal('q');

		$params = array('cityId' => $this->wg->cityId);

		$results = $this->wikiaSearch->searchVideos($query, $params);
		
		// up to whoever's using this service as to what they want from here. I'm just going to return JSON.
		// if you just want to search for only videos in the traditional video interface, then you should 
		// be setting 'videoSearch' in the query string of the search index page
		$processedResultArray = array();
		foreach ($results as $result) {
			$processedResultArray[] = (array) $result;
		}
		$this->getResponse()->setFormat('json');
		$this->getResponse()->setData( $processedResultArray );
		
	}
	
}
