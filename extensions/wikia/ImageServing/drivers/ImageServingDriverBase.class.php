<?php

/**
 * @author: Tomek Odrobny
 *
 * This class is used to get image list for custom namespaces
 */
abstract class ImageServingDriverBase {
	protected $db;
	protected $allImages;
	protected $imageCountsByArticle;
	protected $filteredImages;
	protected $minWidth;
	protected $minHeight;
	private $articles;

	/**
	 * @param $db DatabaseBase
	 * @param $imageServing ImageServing
	 */
	function __construct( $db, $imageServing ) {
		$this->app = F::app();
		$this->db = $db;
		//TODO: remove it
		$this->imageServing = $imageServing;
		$this->memc = $this->app->wg->Memc;

		$this->minHeight = $this->imageServing->getRequestedHeight();
		$this->minWidth = $this->imageServing->getRequestedWidth();
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

		$cacheResult = $this->loadFromCache();
		$articleIds = $cacheResult['miss'];

		if ( count( $articleIds ) == 0 ) {
			wfProfileOut( __METHOD__ );

			return $cacheResult['cache'];
		}

		$this->allImages = [];
		$this->imageCountsByArticle = [];
		$this->filteredImages = [];

		$this->loadFromDb( $articleIds );

		$dbOut = $this->formatResult( $this->allImages, $this->filteredImages );

		$this->storeInCache( $dbOut );

		$ret = $dbOut + $cacheResult['cache'];

		wfProfileOut( __METHOD__ );

		return $ret;
	}

	final protected function getArticleIds() {
		return array_keys( $this->articles );
	}

	protected function loadFromCache() {
		$cached = [];
		$cacheMissArticleIds = [];
		foreach ( $this->articles as $articleId => $pageInfo ) {
			$articleCache = $this->memc->get( $this->makeKey( $articleId, $pageInfo['page_latest'] ) );
			if ( !empty( $articleCache ) ) {
				$cached[$articleId] = $articleCache;
			} else {
				$cacheMissArticleIds[] = $articleId;
			}
		}

		return [ 'cache' => $cached, 'miss' => $cacheMissArticleIds ];
	}

	/**
	 * Returns memcache key to be used to cache images for articles
	 *
	 * @param $articleId int
	 * @return String
	 *
	 * @author Federico "Lox" Lucignano
	 */
	protected function makeKey( $articleId, $revId ) {
		return wfMemcKey( "image-serving-images-data", $articleId, $revId, $this->minWidth, $this->minHeight );
	}

	protected function loadFromDb( $articleIds ) {
		$this->loadImagesFromDb( $articleIds );

		if ( count( $this->allImages ) > 0 ) {
			$this->loadImageDetails( array_keys( $this->allImages ) );
		}

		return $this->allImages;
	}

	abstract protected function loadImagesFromDb( $articleIds = [] );

	abstract protected function loadImageDetails( $imageNames = [] );

	protected function formatResult( $allImages, $filteredImages ) {
		wfProfileIn( __METHOD__ );

		$out = [];
		$pageOrderedImages = [];
		foreach ( $allImages as $imageName => $pageData ) {
			if ( isset( $filteredImages[$imageName] ) ) {
				foreach ( $pageData as $pageId => $pageImageOrder ) {
					// unit tests say that this can be an array. I don't see how, but maybe there's case I'm not aware of
					if ( is_array( $pageImageOrder ) ) {
						$pageImageOrder = $pageImageOrder[0];
					}

					// insert into an array so we can ensure the $order is respected
					$pageOrderedImages[$pageId][$pageImageOrder] = $imageName;
				}
			}
		}

		foreach ( $pageOrderedImages as $pageId => $pageImageList ) {
			ksort( $pageImageList );
			foreach ( $pageImageList as $imageName ) {
				$img = $this->getFileByName( $imageName );
				$out[$pageId][] = [
					"name" => $imageName,
					"original_dimensions" => [
						"width" => !empty( $img ) ? $img->getWidth() : 0,
						"height" => !empty( $img ) ? $img->getHeight() : 0
					],
					"url" => !empty( $img ) ? $this->imageServing->getUrl( $img, $filteredImages[$imageName]['img_width'], $filteredImages[$imageName]['img_height'] ) : ''
				];
			}
		}

		wfProfileOut( __METHOD__ );

		return $out;
	}

	protected function getFileByName( $fileName ) {
		$title = Title::newFromText( $fileName, NS_FILE );
		$img = wfFindFile( $title );

		return $img;
	}

	protected function storeInCache( $articleImageIndex ) {
		// store images for each article separately
		foreach ( $articleImageIndex as $articleId => $imageIndex ) {
			$this->memc->set( $this->makeKey( $articleId, $this->articles[$articleId]['page_latest'] ), $imageIndex, 3600 );
		}
	}

	final protected function getArticles() {
		return $this->articles;
	}

	final public function setArticles( $articles = [] ) {
		$this->articles = $articles;
	}

	protected function addImageDetails( $name, $count, $width, $height, $minorMime ) {
		$this->filteredImages[$name] = [
			'cnt' => $count,
			'il_to' => $name,
			'img_width' => $width,
			'img_height' => $height,
			'img_minor_mime' => $minorMime
		];
	}

	protected function addImage( $imageName, $pageId, $order, $limit = 999 ) {
		$isNew = false;
		if ( !isset( $this->allImages[$imageName] ) ) {
			$isNew = true;
		}

		if ( !isset( $this->allImages[$imageName][$pageId] ) &&
			( empty( $this->imageCountsByArticle[$pageId] ) || $this->imageCountsByArticle[$pageId] < $limit )
		) {
			$this->imageCountsByArticle[$pageId] = empty( $this->imageCountsByArticle[$pageId] ) ? 1 : ( $this->imageCountsByArticle[$pageId] + 1 );
			$this->allImages[$imageName][$pageId] = $order;
		}

		return $isNew;
	}

	protected function getAllImagesCountForArticle( $pageId ) {
		if ( !empty( $this->imageCountsByArticle[$pageId] ) ) {
			return $this->imageCountsByArticle[$pageId];
		} else {
			return 0;
		}
	}
}
