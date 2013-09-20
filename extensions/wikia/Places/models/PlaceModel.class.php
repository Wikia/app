<?php
class PlaceModel {
	private $align = 'right';
	private $width = 200;
	private $height = 200;
	private $lat = false;
	private $lon = false;
	private $address = '';
	private $zoom = 14;
	private $pageId = 0;
	private $categories = array();
	private $caption = false;

	public static function newFromAttributes( $array = null ){
		$oModel = (new PlaceModel);
		if ( is_array( $array ) ){
			foreach ( $array as $key => $val ){
				$setter = 'set'.ucfirst( strtolower( $key ) );
				if ( method_exists( 'PlaceModel', $setter ) ){
					$oModel->$setter( $val );
				}
			}
		}
		return $oModel;
	}

	public function setAlign( $text ){
		if ( in_array( $text, array( 'right', 'left' ) ) ) {
			$this->align = $text;
		}
	}

	public function setWidth( $int ){
		$int = (int) $int;
		if ( $int > 0 ){
			$this->width = $int;
		}
	}

	public function setCaption($caption) {
		$this->caption = $caption;
	}

	public function setCategories( $mix ){
		if ( is_array( $mix ) ){
			$this->categories = $mix;
		} else {
			$array = explode( '|', $mix );
			if ( count( $array ) > 0 ){
				$this->categories = array();
				foreach( $array as $val ){
					$this->categories[] = ucfirst( $val );
				}
			}
		}
	}

	public function setHeight( $int ){
		$int = (int) $int;
		if ( $int > 0 ){
			$this->height = $int;
		}
	}

	public function setLat( $float ){
		if (is_numeric($float)) {
			$this->lat = (double) $float;
		}
	}

	public function setLon( $float ){
		if (is_numeric($float)) {
			$this->lon = (double) $float;
		}
	}

	public function setAddress( $text ){
		if ( !empty( $text ) ){
			$this->address = $text;
		}
	}

	public function setZoom( $int ){
		$int = (int) $int;
		if ( ( $int > 0 ) && ( $int < 21 ) ){
			$this->zoom = $int;
		}
	}

	public function setPageId( $int ){
		$int = (int) $int;
		if ( $int > 0 ){
			$this->pageId = $int;
		}
	}

	public function getAlign(){
		return $this->align;
	}

	public function getWidth(){
		return $this->width;
	}

	public function getHeight(){
		return $this->height;
	}

	public function getLat(){
		return $this->lat;
	}

	public function getLon(){
		return $this->lon;
	}

	public function getLatLon() {
		return array(
			'lat' => $this->getLat(),
			'lon' => $this->getLon(),
		);
	}

	public function isEmpty() {
		return ($this->getLat() === false) || ($this->getLon() === false);
	}

	public function getAddress(){
		return $this->address;
	}

	public function getZoom(){
		return $this->zoom;
	}

	public function getPageId(){
		return $this->pageId;
	}

	public function getCaption() {
		return ($this->caption === false) ? $this->getDefaultCaption() : $this->caption;
	}

	public function getDefaultCaption() {
		$latDir = ($this->lat >= 0) ? 'N' : 'S';
		$lonDir = ($this->lon >= 0) ? 'E' : 'W';

		$lat = abs($this->lat);
		$lon = abs($this->lon);

		// 52° 40.798' N 16° 93.363' E
		return sprintf("%d° %.3f' %s %d° %.3f' %s",
			floor($lat),
			($lat - floor($lat)) * 60,
			$latDir,
			floor($lon),
			($lon - floor($lon)) * 60,
			$lonDir
		);
	}

	public function getCategories(){
		return $this->categories;
	}

	public function getCategoriesAsText(){
		return implode( '|', $this->categories );
	}

	// Logic
	public function getStaticMapUrl(){
		$latLon = implode( ',', $this->getLatLon() );

		// use SASS button color for marker
		$colors = SassUtil::getOasisSettings();
		$markerColor = '0x' . ltrim($colors['color-buttons'], '#');

		$aParams = array(
			'center' => $latLon,
			'markers' => "color:{$markerColor}|{$latLon}",
			'size' => $this->getWidth().'x'.$this->getHeight(),
			'zoom' => $this->getZoom(),
			'maptype' => 'roadmap',
			'sensor' => 'false',
		);
		$sParams = http_build_query( $aParams );
		return 'http://maps.googleapis.com/maps/api/staticmap?'.$sParams;
	}

	/**
	 * Returns data needed to render marker for a given place on a map with multiple places
	 *
	 * This method returns article's URL, text snippet and an image for current place
	 *
	 * TODO: add caching
	 */
	public function getForMap(){
		if ( $this->isEmpty() ){
			return false;
		};

		wfProfileIn(__METHOD__);

		$pageId = $this->getPageId();
		$oTitle = Title::newFromID($pageId);

		if (empty($oTitle) || !$oTitle->exists()) {
			wfProfileOut(__METHOD__);
			return array();
		}

		// TODO: getImages() are not cached
		$imageServing = new ImageServing( array( $pageId ), 100, array( 'w' => 1, 'h' => 1 ) );
		$images = $imageServing->getImages(1);
		if ( !empty( $images[$pageId][0]['url'] ) ){
			$imageUrl = $images[$pageId][0]['url'];
		}
		else {
			$imageUrl = '';
		}

		$oArticleService = new ArticleService();
		$oArticleService->setArticleById( $pageId );

		$textSnippet = $oArticleService->getTextSnippet( 120 );
		$strPos = mb_strrpos( $textSnippet, ' ' );
		$textSnippet = mb_substr( $textSnippet, 0, ( $strPos ) );
		$textSnippet.= ' ...';

		$ret = array(
			'lat' => $this->getLat(),
			'lan' => $this->getLon(),
			'label' => $oTitle->getText(),
			'imageUrl' => $imageUrl,
			'articleUrl' => $oTitle->getLocalUrl(),
			'textSnippet' => $textSnippet
		);

		wfProfileOut(__METHOD__);
		return $ret;
	}

	public function getDistanceTo(PlaceModel $place) {

	}
}