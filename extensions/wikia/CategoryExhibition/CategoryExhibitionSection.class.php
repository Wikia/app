<?php

/**
 * Main Category Gallery class
 */
class CategoryExhibitionSection {

	protected $thumbWidth = 105;
	protected $thumbHeight = 90;		
	protected $thumbMedia = 130;		// width for media section
	protected $displayOption = false;	// current state of display option
	protected $sortOption = false;		// current state of sort option

	protected $allowedSortOptions = array( 'alphabetical', 'recentedits', 'mostvisited' );
	protected $allowedDisplayOptions = array( 'exhibition', 'page' );

	public $urlParameter = 'section';	// contains section url variable that stores pagination
	public $paginatorPosition = 1;		// default pagination
	public $sUrl = '';
	public $categoryTitle = false;		// title object of category
	public $templateName = 'section';	// name of the section template
	public $isFromAjax = false;		// true if request comes from ajax

	public function __construct( $oCategoryTitle ){

		global $wgRequest, $wgUser;

		$this->categoryTitle = $oCategoryTitle;

		if ( $wgUser->isAnon() ){
			$this->setDisplayTypeFromParam();
			$this->setSortTypeFromParam();
		}
	}

	/**
	 * fetchSectionItems - returns gets array of items from category from specyfic namespace.
	 * @param $sCategoryDBKey int category namespace
	 * @param $mNamespace int namespace for category query
	 * @return array
	 */

	protected function fetchSectionItems( $mNamespace = NS_MAIN ) {

		global $wgDevelEnvironment;
		$sCategoryDBKey = mysql_real_escape_string( $this->categoryTitle->getDBkey() );
		if (!is_array($mNamespace)){
			$mNamespace = (int)$mNamespace;
		} else {
			$mNamespace = implode(',', $mNamespace);
		}
		switch ( $this->getSortType() ){
			case 'alphabetical': return CategoryDataService::getAlphabetical( $sCategoryDBKey, $mNamespace );
			case 'recentedits': return CategoryDataService::getRecentlyEdited( $sCategoryDBKey, $mNamespace );
			case 'mostvisited': return CategoryDataService::getMostVisited( $sCategoryDBKey, $mNamespace );
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

		global $wgUser, $wgCookiePrefix;

		if ( in_array( $this->sortOption, $this->allowedSortOptions ) ) {
			return $this->sortOption;
		}
		if ( $wgUser->isAnon() ){
			$this->setSortTypeFromParam();
			$return = $this->sortOption;
		} else {
			$return = $wgUser->getOption('CategoryExhibitionSortType', $this->allowedSortOptions[0]);
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

		global $wgUser, $wgCookiePrefix;
		
		if ( !empty( $this->displayOption ) && in_array( $this->displayOption, $this->allowedDisplayOptions ) ){
			return $this->displayOption;
		}
		$cookieName = $wgCookiePrefix . 'CategoryExhibitionDisplayType';
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
	 * main function returning fillet template ready to print.
	 * @param $itemsPerPage int number of articles per page
	 * @param $namespace int namespace for category query
	 * @return EasyTemplate object
	 */

	protected function getTemplateForNameSpace( $namespace, $itemsPerPage = 16 ){

		global $wgTitle;
		$cachedContent = $this->getFromCache();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		if( empty( $cachedContent ) ){
			$aTmpData = $this->fetchSectionItems( $namespace );
			$pages = Paginator::newFromArray( $aTmpData, $itemsPerPage );
			if ( is_array($aTmpData) && count($aTmpData) > 0 ){
				$aTmpData = $pages->getPage( $this->paginatorPosition, true);
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
				    'page'	=> $oTmpl->execute( 'page' ),
				    'paginator'	=> $oTmpl->mVars['paginator']
				);
			} else {
				return $oTmpl->execute( $this->templateName );
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
		
		$imageServing = new imageServing( $mPageId, $this->thumbWidth , array( "w" => $this->thumbWidth, "h" => $this->thumbHeight ) );
		$imageUrl = '';
		
		foreach ( $imageServing->getImages( 1 ) as $key => $value ){
			if ( !empty( $value[0]['name'] ) ){
				$tmpTitle = Title::newFromText( $value[0]['name'], NS_FILE );
				$image = wfFindFile( $tmpTitle );
				$imageInfo = getimagesize( $image->getPath() );
				$imageUrl = wfReplaceImageServer(
					$image->getThumbUrl(
						$imageServing->getCut( $imageInfo[0], $imageInfo[1] )."-".$image->getName()
					)
				);
			};
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
			$snippetText = '';
			$imageUrl = $this->getImageFromPageId( $item['page_id'] );

			if ( $imageUrl == '' ){
				if ( empty($snippetText) && empty($imageUrl) ){
					$snippetService = new ArticleService ( $item['page_id'] );
					$snippetText = $snippetService->getTextSnippet();
				}
			}
			
			$aData[] = array(
			    'id'	=> $item['page_id'],
			    'title'	=> Title::newFromDBkey($item['page_title'])->getText(),
			    'img'	=> $imageUrl,
			    'url'	=> Title::newFromID($item['page_id'])->getFullURL(),
			    'snippet'	=> $snippetText
			);
		};
		return $aData;
	}

	/**
	 * Loads data for pagination.
	 */
	
	function loadPaginationVars( ){

		global $wgTitle, $wgRequest;
		$variableName = $this->urlParameter;
		$paginatorPosition = 0;
		$reqValues = $wgRequest->getValues();
		if ( !empty( $reqValues[ $variableName ] ) ){
			$paginatorPosition = (int)$reqValues[ $variableName ];
			unset( $reqValues[ $variableName ] );
		};
		$return = array();
		foreach($reqValues AS $key => $value) {
			$return[] = $key.'='.$value;
		}

		$url = $wgTitle->getFullURL().'?'.implode('&', $return);
		if ( count($value) > 0 ){
			$url.= '&'.$variableName.'=%s';
		} else {
			$url.= '?'.$variableName.'=%s';
		}
		$this->sUrl = $url;
		$this->paginatorPosition = $paginatorPosition;
		return array( 'url' => $url, 'position' => $paginatorPosition );;
	}

	/**
	 * Caching functions.
	 */

	protected function getKey( ) {
		global $wgCityId;
		return wfSharedMemcKey(
			'category_exhibition_section',
			$this->categoryTitle->getDBKey(),
			$this->templateName,
			$this->paginatorPosition,
			$this->getDisplayType(),
			$this->getSortType(),
			$wgCityId
		);
	}

	protected function saveToCache( $content ) {
		global $wgMemc;
		$memcData = $this->getFromCache( );
		if ( empty($memcData) ){
			$wgMemc->set( $this->getKey( ), $content, 60*30);
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