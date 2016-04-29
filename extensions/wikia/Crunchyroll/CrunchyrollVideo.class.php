<?php

/**
 *
 * @author Jakub 'Szeryf' Kurcek <jakub at wikia-inc.com>
 * @date 2011-02-23
 * @copyright Copyright (C) 2010 Jakub 'Szeryf' Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class CrunchyrollVideo {

	const  CRUNCHYROLL_COLLUMNS = 4;
	const  CRUNCHYROLL_ROWS = 2;

	private $getPaginatedData = false;

	public $title;
	private $serie;
	private $number;
	private $currentPage;
	private $defaultNumber = 0;
	private $allowedSeries = array(
				    'gundam'	=> 18329,
				    'digimon'	=> 788
				);
	private $app;

	public function setSerie( $sSerie ){
		$this->serie = ( isset ( $sSerie, $this->allowedSeries[ $sSerie ] ) ) ? $this->allowedSeries[ $sSerie ] : false;
	}

	public function setSerieId( $iSerie ){
		$this->serie = (int)$iSerie;
	}

	public function getSerie(){
		return $this->serie;
	}

	public function setNumber( $iNumber ){
		$this->number = ( (int)$iNumber > 0 ) ? (int)$iNumber : 0;
	}

	public function getNumber(){
		return ( empty( $this->number ) ) ? $this->defaultNumber : $this->number;
	}

	public function getRowsNumber(){
		$rows = (int) $this->app->getGlobal('wgCrunchyrollGalleryRows');
		return ( empty( $rows ) || ( $rows < 1 ) ) ? self::CRUNCHYROLL_ROWS : $rows;
	}

	public function __construct() {
		$this->app = F::app();
	}

	protected function getRSSData(){

		$crunchyrollRSS = CrunchyrollRSS::newFromUrl( $this->getURLFromSerie() );
		$crunchyrollRSS->setMaxItems( $this->number );
		$crunchyrollRSS->setSerie( $this->serie );

		return $crunchyrollRSS;
	}

	protected function getPaginatedRSSData(){

		if( empty( $this->getPaginatedData ) ){
			$crRSS = $this->getRSSData();
			$this->title = $crRSS->getTitle();
			$pages = Paginator::newFromArray(
				$crRSS->getItems(),
				( self::CRUNCHYROLL_COLLUMNS * $this->getRowsNumber() )
			);
			$this->getPaginatedData = $pages;
		}
		return $this->getPaginatedData;
	}

	public function getGallery( $collumns = 3 ){

		$crunchyrollRSS = $this->getRSSData();

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
			    'items'	=> $crunchyrollRSS->getItems(),
			    'collumns'	=> $collumns,
			    'toolbar'	=> ''
			)
		);
		return $oTmpl->render( "CrunchyrollGallery" );
	}

	public function getPageURL(){

		$url = '/wiki/special:crunchyroll/%s';
		if ( !empty( $this->serie ) ){
			$url.= '/'.$this->serie;
		}
		return $url;
	}

	public function getBarHTML(){
		$cachedData = $this->getFromCache();
		if ( !empty($cachedData) && is_array($cachedData) && isset( $cachedData['toolbar'] ) ){
			return $cachedData['toolbar'];
		} else {
			$crunchyrollRSS = $this->getPaginatedRSSData();
			return $crunchyrollRSS->getBarHTML( $this->getPageURL() );
		}
	}

	public function getPaginatedGallery( $page = 1, $fromAjax = false ){
		global $wgOut, $wgJsMimeType, $wgExtensionsPath;

		$this->currentPage = $page;

		$cachedData = $this->getFromCache();

		if ( !empty($cachedData) && is_array($cachedData) && isset( $cachedData['toolbar'] ) && isset( $cachedData['title'] ) && isset( $cachedData['data'] ) ){
			$this->title = $cachedData['title'];
			$aTmpData = $cachedData['data'];
			$toolbar = $cachedData['toolbar'];
		} else {
			$crunchyrollRSS = $this->getPaginatedRSSData();
			$crunchyrollRSS->setActivePage( $this->currentPage );
			$aTmpData = $crunchyrollRSS->getCurrentPage();
			$toolbar = $this->getBarHTML();
			$this->saveToCache(
				array(
				    'title' => $this->title,
				    'data' => $aTmpData,
				    'toolbar' => $toolbar
				)
			);
		}

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Crunchyroll/js/Crunchyroll.js\"></script>\n");

		if ( is_array( $aTmpData ) && count( $aTmpData ) > 0 ){
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars(
				array(
				    'items'	=> $aTmpData,
				    'collumns'	=> self::CRUNCHYROLL_COLLUMNS,
				    'toolbar'	=> $toolbar,
				    'serieId'	=> $this->getSerie()
				)
			);
			if ( $fromAjax ){
				return $oTmpl->render( "CrunchyrollGallery" );
			} else {
				return $oTmpl->render( "CrunchyrollPaginatedGallery" );
			}
		} else {
			return '';
		}
	}

	private function getURLFromSerie(){

		if ( empty( $this->serie ) ){
			return 'http://www.crunchyroll.com/syndication/feed?type=series';
		} else {
			return 'http://www.crunchyroll.com/syndication/feed?type=episodes&id='.$this->serie;
		}
	}

	// cache functions

	protected function getKey( ) {
		return wfSharedMemcKey(
			'CrunchyrollVideoFromRSS',
			$this->getSerie(),
			$this->number,
			$this->currentPage,
			$this->getRowsNumber()
		);
	}

	protected function saveToCache( $content ) {
		global $wgMemc;

		$memcData = $this->getFromCache( );
		if ( empty($memcData) ){
			$wgMemc->set( $this->getKey( ), $content, 60*60*6 );
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

