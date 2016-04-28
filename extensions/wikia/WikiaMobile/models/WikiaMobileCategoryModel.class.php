<?php

/**
 * Category model (and related classes) for Wikia Mobile
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileCategoryModel extends WikiaModel {
	const CACHE_TTL_ITEMSCOLLECTION = 1800;// 30 mins, same TTL used by CategoryExhibition
	const CACHE_TTL_EXHIBITION = 21600;// 6h
	const EXHIBITION_ITEMS_LIMIT = 4;// maximum number of items in Category Exhibition to display
	const CACHE_VERSION = 0;
	const BATCH_SIZE = 25;

	public function getCollection( Category $category, $format = 'json' ) {
		return WikiaDataAccess::cache(
			$this->getItemsCollectionCacheKey( $category->getID(), $format ),
			self::CACHE_TTL_ITEMSCOLLECTION,
			function () use ( $category, $format ) {
				wfProfileIn( __METHOD__ );

				$viewer = new WikiaMobileCategoryViewer( $category, $format );
				$viewer->doCategoryQuery();

				wfProfileOut( __METHOD__ );
				return $viewer->getData();
			}
		);
	}

	public function getExhibitionItems( Title $title ) {
		wfProfileIn( __METHOD__ );

		if ( class_exists( 'CategoryDataService' ) ) {
			$cacheKey = $this->getExhibitionItemsCacheKey( $title->getText() );
			$items = $this->wg->memc->get( $cacheKey );

			if ( !is_array( $items ) ) {
				$exh = CategoryDataService::getMostVisited( $title->getDBkey(), null, self::EXHIBITION_ITEMS_LIMIT );
				$ids = array_keys( $exh );
				$length = count( $ids );
				$items = [ ];

				for ( $i = 0; $i < $length; $i++ ) {
					$pageId = $ids[$i];

					$imgRespnse = $this->app->sendRequest(
						'ImageServing',
						'index',
						[ 'ids' => [ $pageId ], 'height' => 150, 'width' => 150, 'count' => 1 ]
					);
					$img = $imgRespnse->getVal( 'result' );

					if ( !empty( $img[$pageId] ) ) {
						$img = $img[$pageId][0]['url'];
					} else {
						$img = false;
					}

					$oTitle = Title::newFromID( $pageId );
					$items[] = [
						'img' => $img,
						'title' => $oTitle->getText(),
						'url' => $oTitle->getFullURL()
					];
				}

				$this->wg->memc->set( $cacheKey, $items, self::CACHE_TTL_EXHIBITION );
			}

			wfProfileOut( __METHOD__ );
			return $items;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	private function getItemsCollectionCacheKey( $categoryId ) {
		return wfmemcKey( __CLASS__, 'ItemsCollection', $categoryId, self::CACHE_VERSION );
	}

	private function getExhibitionItemsCacheKey( $titleText ) {
		return wfmemcKey( __CLASS__, 'Exhibition', md5( $titleText ), self::CACHE_VERSION );
	}

	public function purgeItemsCollectionCache( $categoryName ) {
		$this->wg->memc->delete( $this->getItemsCollectionCacheKey( $categoryName ) );
	}

	public function purgeExhibitionItemsCacheKey( $titleText ) {
		$this->wg->memc->delete( $this->getExhibitionItemsCacheKey( $titleText ) );
	}
}

/**
 * CategoryViewer specialization to access the data using the correct sort-keys
 *
 */
class WikiaMobileCategoryViewer extends CategoryViewer {
	private $items;
	private $count;
	public $isJSON;

	const LIMIT = 5000;

	function __construct( Category $category, $format = 'json' ) {
		parent::__construct( $category->getTitle(), RequestContext::getMain() );

		$this->limit = self::LIMIT; # BAC-265

		$this->items = [ ];
		$this->count = 0;
		$this->isJSON = ( $format === 'json' || F::app()->checkSkin( 'wikiamobile' ) );
	}

	function addImage( Title $title, $sortkey, $pageLength, $isRedirect = false ) {
		$this->addItem( $title, $sortkey );
	}

	function addPage( Title $title, $sortkey, $pageLength, $isRedirect = false ) {
		$this->addItem( $title, $sortkey );
	}

	function addSubcategoryObject( Category $cat, $sortkey, $pageLength ) {
		$this->addItem( $cat->getTitle(), $sortkey );
	}

	private function addItem( $title, $sortkey ) {
		if ( $title instanceof Title ) {
			$sortkey = str_replace( [ "\n", "\t", "\r", ' ' ], '', $sortkey );
			$index = (string) mb_strtoupper( mb_substr( $sortkey, 0, 1 ) );

			if ( empty( $this->items[$index] ) ) {
				$this->items[$index] = [ ];
			}

			$this->items[$index][] = [
				'name' => $title->getText(),
				'url' => $title->getLocalUrl(),
				'is_category' => $title->getNamespace() == NS_CATEGORY
			];
			$this->count++;
		}
	}

	public function getData() {
		if ( !empty( $this->blogs ) ) {
			$items = $this->items + [ wfMessage( 'wikiamobile-categories-blogs' )->text() => $this->blogs ];

			$count = $this->count + count( $this->blogs );
		} else {
			$items = $this->items;
			$count = $this->count;
		}

		return [
			'items' => $items,
			'count' => $count
		];
	}
}
