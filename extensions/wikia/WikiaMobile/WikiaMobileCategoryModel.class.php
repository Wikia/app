<?php
/**
 * Category model (and related classes) for Wikia Mobile
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaMobileCategoryModel extends WikiaModel{
	const CACHE_TTL_ITEMSCOLLECTION = 1800;//30 mins, same TTL used by CategoryExhibition

	public function getItemsCollection( Category $category ){
		$this->wf->profileIn( __METHOD__ );

		$cacheKey = $this->getItemsCollectionCacheKey( $category->getName() );
		$contents = $this->wg->memc->get( $cacheKey );

		if ( empty( $contents ) ) {
			$items = array();
			$count = 0;

			foreach ( $category->getMembers() as $title ) {
				$index = strtolower( $this->wg->ContLang->firstChar( $title->getDBkey() ) );
				$type = ( $title->getNamespace() == NS_CATEGORY ) ? WikiaMobileCategoryItem::TYPE_SUBCATEGORY : WikiaMobileCategoryItem::TYPE_ARTICLE;

				if ( empty( $items[$index] ) ) {
					$items[$index] = F::build( 'WikiaMobileCategoryItemsCollection' );
				}

				$items[$index]->addItem( F::build( 'WikiaMobileCategoryItem', array( $title->getText(), $title->getLocalUrl(), $type ) ) );
				$count++;
			}

			if ( $count > 0 ) {
				ksort( $items );
			}

			$contents = F::build( 'WikiaMobileCategoryContents', array( $items, $count ) );
			$this->wg->memc->set( $cacheKey, $contents, self::CACHE_TTL_ITEMSCOLLECTION );
		}

		$this->wf->profileOut( __METHOD__ );
		return $contents;
	}

	private function getItemsCollectionCacheKey( $categoryName ){
		return $this->wf->memcKey( __CLASS__, 'ItemsCollection', $categoryName );
	}

	public function purgeItemsCollectionCache( $categoryName ){
		$this->wg->memc->delete( $this->getItemsCollectionCacheKey( $categoryName ) );
	}
}

/**
 * Simple DTO to handle the indexed contents of a category
 */
class WikiaMobileCategoryContents{
	private $items;
	private $count;

	function __construct( Array $items, $count ){
		$this->items = $items;
		$this->count = (int) $count;
	}

	public function setItems( Array $items ){
		$this->items = $items;
	}

	public function getItems(){
		return $this->items;
	}

	public function setCount( $count ){
		$this->count = (int) $count;
	}

	public function getCount(){
		return $this->count;
	}
}

/**
 * Paginated container for all the members of a category starting with a specific letter
 */
class WikiaMobileCategoryItemsCollection extends WikiaObject{
	private $items;
	private $count;

	function __construct(){
		parent::__construct();
		$this->items = array();
		$this->count = 0;
	}

	public function getItems( $batch = null, $batchSize = 25 ){
		if ( is_int( $batch ) && is_int( $batchSize ) ) {
			return $this->wf->PaginateArray( $this->items, $batchSize, $batch );
		}

		return $this->items;
	}

	public function addItem( WikiaMobileCategoryItem $item ){
		$this->items[] = $item;
		$this->count++;
	}

	public function getCount(){
		return $this->count;
	}
}

class WikiaMobileCategoryItem{
	const TYPE_ARTICLE = 1;
	const TYPE_SUBCATEGORY = 2;

	private $name;
	private $url;
	private $type;

	function __construct( $name, $url, $type ){
		$this->name = $name;
		$this->url = $url;
		$this->type = $type;
	}

	public function getName(){
		return $this->name;
	}

	public function getUrl(){
		return $this->url;
	}

	public function getType(){
		return $this->type;
	}
}