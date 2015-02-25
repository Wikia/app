<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSection {
	const CACHE_VERSION = 3;
	const EXHIBITION_LIMIT = 2000;

	protected $thumbWidth = 130;
	protected $thumbHeight = 115;
	protected $thumbMedia = 130;		// width for media section
	protected $displayOption = false;	// current state of display option
	protected $sortOption = false;		// current state of sort option

	protected $categoryExhibitionEnabled;
	protected $allowedSortOptions = array( 'mostvisited', 'alphabetical' );
	protected $allowedDisplayOptions = array( 'exhibition', 'page' );

	protected $verifyChecker = '';
	public $urlParameter = 'section';	// contains section url variable that stores pagination
	public $paginatorPosition = 1;		// default pagination
	public $sUrl = '';
	/* @var Title */
	public $categoryTitle = false;		// title object of category
	public $templateName = 'section';	// name of the section template
	public $isFromAjax = false;		// true if request comes from ajax

	public function __construct( $oCategoryTitle ){

		global $wgUser;

		$this->categoryTitle = $oCategoryTitle;

		if ( $wgUser->isAnon() && empty($oCategoryTitle) ){
			$this->setDisplayTypeFromParam();
			$this->setSortTypeFromParam();
		}
	}

	/**
	 * @return boolean
	 */
	public function isCategoryExhibitionEnabled() {
		if ( !isset( $this->categoryExhibitionEnabled ) ) {
			$this->categoryExhibitionEnabled =
				CategoryDataService::getArticleCount( $this->categoryTitle->getDBkey() ) > self::EXHIBITION_LIMIT ? false : true;
		}
		return $this->categoryExhibitionEnabled;
	}

	/**
	 * fetchSectionItems - returns gets array of items from category from specyfic namespace.
	 * @param $sCategoryDBKey int category namespace
	 * @param $mNamespace mixed: int namespace or array of int for category query
	 * @return array
	 */

	protected function fetchSectionItems( $mNamespace = NS_MAIN, $negative = false ) {

		$sCategoryDBKey = $this->categoryTitle->getDBkey();

		// Check if page is a redirect
		if( $this->categoryTitle->isRedirect() ){
			/* @var WikiPage $oTmpArticle */
			$oTmpArticle = new Article( $this->categoryTitle );
			if ( !is_null( $oTmpArticle ) ) {
				$rdTitle = $oTmpArticle->getRedirectTarget();
				if ( !is_null( $rdTitle ) && ( $rdTitle->getNamespace() == NS_CATEGORY ) ) {
					$sCategoryDBKey = $rdTitle->getDBkey();
				}
			}
		}
		if (!is_array($mNamespace)){
			$ns = (int)$mNamespace;
		} else {
			$ns = implode(',', $mNamespace);
		}

		switch ( $this->getSortType() ){
			case 'mostvisited':
				if ( !is_array( $mNamespace ) ) {
					$mNamespace = array( (int) $mNamespace );
				}

				$res = CategoryDataService::getMostVisited( $sCategoryDBKey, $mNamespace, false, $negative );
				//FB#26239 - fall back to alphabetical order if most visited data is empty
				return ( !empty( $res ) ) ? $res : CategoryDataService::getAlphabetical( $sCategoryDBKey, $ns, $negative );
			case 'alphabetical': return CategoryDataService::getAlphabetical( $sCategoryDBKey, $ns, $negative );
		}
		return array();
	}

	/**
	 * Sort type setters and getters
	 */

	public function getSortTypes(){

		return $this->allowedSortOptions;
	}

	public function getSortType(){

		global $wgUser;

		if ( in_array( $this->sortOption, $this->allowedSortOptions ) ) {
			return $this->sortOption;
		}
		if ( $wgUser->isAnon() ){
			$this->setSortTypeFromParam();
			$return = $this->sortOption;
		} else {
			$return = $wgUser->getOption( 'CategoryExhibitionSortType', $this->allowedSortOptions[0] );
		}

		if ( !empty( $return ) && in_array( $return, $this->allowedSortOptions ) ){
			return $return;
		} else {
			return $this->allowedSortOptions[0];
		}
	}

	public function setSortType( $sortType ){

		global $wgUser;

		if ( in_array( $sortType, $this->allowedSortOptions ) ) {
			if ( !$wgUser->isAnon() ) {
				$wgUser->setOption('CategoryExhibitionSortType', $sortType );
				$wgUser->saveSettings();
			}
			$this->sortOption = $sortType;
		}
	}

	public function setSortTypeFromParam(){

		global $wgRequest;

		$paramVar = $wgRequest->getText( 'sort' );
		if ( !empty( $paramVar ) ){
			$this->setSortType( $paramVar );
		}
	}

	/**
	 * Display type setters and getters
	 */

	public function setDisplayTypeFromParam(){

		global $wgRequest;

		$paramVar = $wgRequest->getText( 'display' );
		if ( !empty( $paramVar ) ){
			$this->setDisplayType( $paramVar );
		}
	}

	public function setDisplayType( $displayType ){

		global $wgUser;
		if ( in_array( $displayType, $this->allowedDisplayOptions ) ) {
			if ( !$wgUser->isAnon() ) {
				$wgUser->setOption('CategoryExhibitionDisplayType', $displayType );
				$wgUser->saveSettings();
			}
			$this->displayOption = $displayType;
		}
	}

	public function getDisplayType(){

		global $wgUser;

		if ( !empty( $this->displayOption ) && in_array( $this->displayOption, $this->allowedDisplayOptions ) ){
			return $this->displayOption;
		}

		if ( $wgUser->isAnon() ){
			$this->setDisplayTypeFromParam();
			$return = $this->displayOption;
		} else {
			$return = $wgUser->getOption( 'CategoryExhibitionDisplayType', $this->allowedDisplayOptions[0] );
		}

		if ( !empty( $return ) && in_array( $return, $this->allowedDisplayOptions ) ){
			return $return;
		} else {
			return $this->allowedDisplayOptions[0];
		}
	}

	/**
	 * main function returning filled template ready to print.
	 * @param $itemsPerPage int number of articles per page
	 * @param $namespace mixed: int namespace or array of int for category query
	 * @return EasyTemplate object
	 */
	protected function getTemplateForNameSpace( $namespace, $itemsPerPage = 16, $negative = false ){

		$cachedContent = $this->getFromCache();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		if( empty( $cachedContent ) ){
			$aTmpData = $this->fetchSectionItems( $namespace, $negative );
			$pages = Paginator::newFromArray( $aTmpData, $itemsPerPage );
			if ( is_array( $aTmpData ) && count( $aTmpData ) > 0 ){
				$aTmpData = $pages->getPage( $this->paginatorPosition, true );
				$aData = $this->getArticles( $aTmpData );
				$oTmpl->set_vars(
					array (
						'data'		=> $aData,
						'category'	=> $this->categoryTitle->getText(),
						'paginator'	=> $pages->getBarHTML( $this->sUrl )
					)
				);
				$this->saveToCache( $oTmpl->mVars );
				return $oTmpl;
			} else {
				return null;
			}
		} else {
			$oTmpl->set_vars( $cachedContent );
			return $oTmpl;
		}
	}

	/**
	 * Exacutes template. Checks if it is done from Ajax request.
	 * @param $oTmpl EasyTemplate template obj
	 * @return string
	 */

	protected function executeTemplate( $oTmpl ){

		if ( !empty($oTmpl) ){
		$oTmpl->set_vars(array('fromAjax' => $this->isFromAjax));
			if ( $this->isFromAjax ){
				return array(
					'page'	=> $oTmpl->render( 'page' ),
					'paginator'	=> $oTmpl->mVars['paginator']
				);
			} else {
				return $oTmpl->render( $this->templateName );
			}
		} else {
			return '';
		}
	}

	public function getSectionHTML( ) {

		# for overloading
	}

	/**
	 * Returns image from page.
	 * @param $mPageId int page id
	 * @return string - image url
	 */

	protected function getImageFromPageId( $mPageId ){

		if ( !is_array( $mPageId ) ){
			$mPageId = array( $mPageId );
		}

		$imageServing = new ImageServing( $mPageId, $this->thumbWidth , array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
		$imageUrl = '';

		foreach ( $imageServing->getImages( 1 ) as $value ){
			if ( !empty( $value[0]['name'] ) ){
				$tmpTitle = Title::newFromText( $value[0]['name'], NS_FILE );
				$image = wfFindFile( $tmpTitle );
				if ( empty( $image ) ){
					return '';
				}
				$imageUrl = wfReplaceImageServer(
					$image->getThumbUrl(
						$imageServing->getCut( $image->getWidth(), $image->getHeight() )."-".$image->getName()
					)
				);
			}
		}
		return $imageUrl;
	}

	/**
	 * Loads detail data for articles that will be displayed in current page.
	 * @param $aTmpData array articles in sections page
	 * @return array - data for template
	 */

	protected function getArticles( $aTmpData ){

		$aData = array();
		foreach( $aTmpData as $item ){
			$articleData = $this->getArticleData( $item['page_id'] );
			if(!empty($articleData)) {
				$aData[] = $articleData;
			}
		};
		return $aData;
	}

	protected function isVerify(){

		if ( empty( $this->verifyChecker ) ){
			$this->verifyChecker = md5( F::app()->wg->server );
		}
		return $this->verifyChecker;
	}

	protected function getArticleData( $pageId ){
		global $wgVideoHandlersVideosMigrated;

		$oTitle = Title::newFromID( $pageId );
		if(!($oTitle instanceof Title)) {
			return false;
		}

		$oMemCache = F::App()->wg->memc;
		$sKey = wfSharedMemcKey(
			'category_exhibition_category_cache_1',
			$pageId,
			F::App()->wg->cityId,
			$this->isVerify(),
			$wgVideoHandlersVideosMigrated ? 1 : 0,
			$this->getTouched($oTitle)
		);

		$cachedResult = $oMemCache->get( $sKey );

		if ( !empty( $cachedResult ) ) {
			return $cachedResult;
		}

		$snippetText = '';
		$imageUrl = $this->getImageFromPageId( $pageId );

		if ( empty( $imageUrl ) ){
			$snippetService = new ArticleService ( $oTitle );
			$snippetText = $snippetService->getTextSnippet();
		}

		$returnData = array(
			'id'		=> $pageId,
			'img'		=> $imageUrl,
			'width'     => $this->thumbWidth,
			'height'    => $this->thumbHeight,
			'snippet'	=> $snippetText,
			'title'		=> $this->getTitleForElement( $oTitle ),
			'url'		=> $oTitle->getFullURL()
		);

		// will be purged elsewhere after edit
		$oMemCache->set( $sKey, $returnData, 60*60*24 );

		return $returnData;
	}

	/**
	 * @param Title $oTitle
	 * @return mixed
	 */
	protected function getTitleForElement( $oTitle ){
		return $oTitle->getText();
	}

	/**
	 * Loads data for pagination.
	 */

	function loadPaginationVars( ){

		global $wgTitle, $wgRequest;
		$variableName = $this->urlParameter;
		$paginatorPosition = 1;
		$reqValues = $wgRequest->getValues();
		if ( !empty( $reqValues[ $variableName ] ) ){
			$paginatorPosition = (int)$reqValues[ $variableName ];
			unset( $reqValues[ $variableName ] );
		};
		$return = array();
		foreach( $reqValues AS $key => $value ) {
			$return[] = urlencode( $key ) . '=' . urlencode( $value );
		}

		$url = $wgTitle->getFullURL().'?'.implode( '&', $return );
		if ( count($return) > 0 ){
			$url.= '&'.$variableName.'=%s';
		} else {
			$url.= '?'.$variableName.'=%s';
		}
		$this->sUrl = $url;
		$this->paginatorPosition = $paginatorPosition;
		return array( 'url' => $url, 'position' => $paginatorPosition );
	}

	/**
	 * Caching functions.
	 */
	protected function getKey() {
		global $wgVideoHandlersVideosMigrated;
		return wfMemcKey(
			'category_exhibition_section_0',
			md5($this->categoryTitle->getDBKey()),
			$this->templateName,
			$this->paginatorPosition,
			$this->getDisplayType(),
			$this->getSortType(),
			$this->isVerify(),
			($wgVideoHandlersVideosMigrated ? 1 : 0),
			$this->getTouched($this->categoryTitle),
			self::CACHE_VERSION
		);
	}

	/**
	 * this method help us to invalidate cache on any change on category, sub cat, page
	 */
	protected function getTouched($title) {
		global $wgMemc;
		return $wgMemc->get($this->getTouchedKey($title), 0);
	}

	public function setTouched($title) {
		global $wgMemc;
		$wgMemc->set($this->getTouchedKey($title), time() . rand(0,9999), 60*60*24 );
	}

	protected function getTouchedKey($title) {
		//fb#24914
		if( $title instanceof Title ) {
			$key = wfMemcKey( 'category_touched', md5($title->getDBKey()), self::CACHE_VERSION );
			return $key;
		} else {
			Wikia::log(__METHOD__, '', '$title not an instance of Title');
			Wikia::logBacktrace(__METHOD__);
			return null;
		}
	}

	protected function saveToCache( $content ) {
		global $wgMemc;
		$memcData = $this->getFromCache( );
		if ( empty($memcData) ){
			$wgMemc->set( $this->getKey( ), $content, 60*30 );
			return false;
		}
		return true;
	}

	protected function getFromCache ( ){
		global $wgMemc;
		return $wgMemc->get( $this->getKey( ) );
	}

	protected function clearCache ( ){
		global $wgMemc;
		return $wgMemc->delete( $this->getKey( ) );
	}
}
