<?php

/*
 * @author: Tomek Odrobny
 *
 * This class is used to get image list for custom namespaces
 */

abstract class ImageServingDriverBase {
	private $articles;
	private $proportion;

	protected $db;
	protected $imagesList;
	protected $articleCountList;
	protected $filterdOut;

	protected $minWidth;
	protected $minHeight;

	/**
	 * @param $db DatabaseBase
	 * @param $imageServing ImageServing
	 * @param $proportion
	 */
	function __construct($db, $imageServing, $proportion) {
		$this->app = F::app();
		$this->db = $db;
		$this->proportion = $proportion;
		//TODO: remove it
		$this->imageServing = $imageServing;
		$this->memc =  $this->app->wg->Memc;

		$this->minHeight = $this->imageServing->getRequestedHeight();
		$this->minWidth = $this->imageServing->getRequestedWidth();
	}

	abstract protected function getImagesFromDB($articles = array());
	abstract protected function filterImages($imagesList = array());

	final public function setArticlesList($articles = array()) {
		$this->articles = $articles;
	}

	final protected function getArticlesList() {
		return $this->articles;
	}

	final protected function getSimpleArticlesList() {
		return array_keys($this->articles);
	}

	/**
	 * Returns matching images for requested article(s)
	 *
	 * Will return up to ImageServing::MAX_LIMIT images
	 *
	 * @return array
	 */
	final public function execute() {
		wfProfileIn( __METHOD__ );

		$articles = $this->getSimpleArticlesList();
		$cacheOut = $this->loadFromCache($articles);
		$articles = $cacheOut['rest'];

		if(count($articles) == 0) {
			wfProfileOut( __METHOD__ );
			return $cacheOut['data'];
		}

		$this->imagesList = array();
		$this->articleCountList = array();
		$this->filterdOut = array();

		$this->executeGetData( $articles );

		$dbOut = $this->formatResult($this->imagesList, $this->filterdOut);

		$this->storeInCache($dbOut);

		$ret = $dbOut + $cacheOut['data'];

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	protected function executeGetData($articles) {
		$this->getImagesFromDB($articles);

		if(count($this->imagesList) > 0) {
			$this->filterImages($this->imagesList);
		}

		return $this->imagesList;
	}

	protected function addToFiltredList($name, $count, $width, $height, $minorMime) {
		$this->filterdOut[ $name ] = array(
			'cnt'            => $count,
			'il_to'          => $name,
			'img_width'      => $width,
			'img_height'     => $height,
			'img_minor_mime' => $minorMime
		);
	}

	protected function addImagesList($imageName, $pageId, $order, $limit = 999 ) {
		$isNew = false;
		if(!isset($this->imagesList[$imageName])) {
			$isNew = true;
		}

		if ( !isset($this->imagesList[$imageName][$pageId]) &&
			(empty($this->articleCountList[$pageId]) || $this->articleCountList[$pageId] <  $limit) ) {
			$this->articleCountList[$pageId] = empty($this->articleCountList[$pageId]) ? 1:($this->articleCountList[$pageId] + 1);
			$this->imagesList[$imageName][$pageId] = $order;
		}
		return $isNew;
	}

	protected function getImagesCountBeforeFiltr($pageId){
		if(!empty($this->articleCountList[$pageId])) {
			return $this->articleCountList[$pageId];
		} else {
			return 0;
		}
	}

	protected function loadFromCache($articles = array()) {
		$out = array();
		$articlesRest = array();
		foreach ( $articles as $value ) {
			$mcOut = $this->memc->get( $this->makeKey( $value ), null );
			if(!empty($mcOut)) {
				$out[ $value ] = $mcOut;
			} else {
				$articlesRest[] = $value;
			}
		}
		return array( 'data' => $out, 'rest' => $articlesRest ) ;
	}

	protected function formatResult($imageList ,$dbOut) {
		wfProfileIn( __METHOD__ );

		$out = [ ];
		$pageOrderedImages = [ ];
		foreach ( $imageList as $imageName => $pageData ) {
			if ( isset( $dbOut[ $imageName ] ) ) {
				foreach ( $pageData as $pageId => $pageImageOrder ) {
					// unit tests say that this can be an array. I don't see how, but maybe there's case I'm not aware of
					if (is_array($pageImageOrder)) {
						$pageImageOrder = $pageImageOrder[0];
					}

					// insert into an array so we can ensure the $order is respected
					$pageOrderedImages[ $pageId ][ $pageImageOrder ] = $imageName;
				}
			}
		}

		foreach ( $pageOrderedImages as $pageId => $pageImageList ) {
			ksort( $pageImageList );
			foreach ( $pageImageList as $imageName ) {
				$img = $this->getImageFile( $imageName );
				$out[ $pageId ][ ] = [
					"name" => $imageName,
					"original_dimensions" => [
						"width" => !empty( $img ) ? $img->getWidth() : 0,
						"height" => !empty( $img ) ? $img->getHeight() : 0
					],
					"url" => !empty( $img ) ? $this->imageServing->getUrl( $img, $dbOut[ $imageName ][ 'img_width' ], $dbOut[ $imageName ][ 'img_height' ] ) : ''
				];
			}
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}

	protected function getImageFile( $text ) {
		$file_title = Title::newFromText( $text, NS_FILE );
		$img = wfFindFile( $file_title );
		return $img;
	}

	protected function storeInCache($dbOut) {
		// store images for each article separately
		foreach ($dbOut as $articleId => $images) {
			$this->memc->set( $this->makeKey( $articleId ), $images, 3600 );
		}
	}

	/**
	 * Returns memcache key to be used to cache images for articles
	 *
	 * @param $articleId int
	 * @return String
	 *
	 * @author Federico "Lox" Lucignano
	 */
	protected function makeKey( $articleId  ) {
		return wfMemcKey("imageserving-images-data", $articleId, $this->minWidth, $this->minHeight);
	}
}