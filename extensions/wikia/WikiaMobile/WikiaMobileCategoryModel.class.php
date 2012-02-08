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
		$items = $this->wg->memc->get( $cacheKey );

		//this routine can return an empty array, so using empty is not wise
		if ( !is_array( $items ) ) {
			$items = array();

			foreach ( $category->getMembers() as $title ) {
				$name = $title->getText();
				$url = $title->getLocalUrl();
				$firstLetter = strtolower( substr( $name, 0, 1 ) );
				$type = ( $title->getNamespace() == NS_CATEGORY ) ? CategoryItem::TYPE_SUBCATEGORY : CategoryItem::TYPE_ARTICLE;

				if ( empty( $items[$firstLetter] ) ) {
					$items[$firstLetter] = F::build( 'CategoryItemsCollection' );
				}

				$items[$firstLetter]->addItem( F::build( 'CategoryItem', array( $name, $url, $type ) ) );
			}

			$this->wg->memc->set( $cacheKey, $items, self::CACHE_TTL_ITEMSCOLLECTION );
		}

		$this->wf->profileOut( __METHOD__ );
		return $items;
	}

	private function getItemsCollectionCacheKey( $categoryName ){
		return $this->wf->memcKey( __CLASS__, __METHOD__, $categoryName );
	}

	public function purgeItemsCollectionCache( $categoryName ){
		$this->wg->memc->delete( $this->getItemsCollectionCacheKey( $categoryName ) );
	}
}

/**
 * Paginated container for all the members of a category starting with a specific letter
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class CategoryItemsCollection extends WikiaObject{
	private $items = null;

	function __construct(){
		parent::__construct();
		$this->items = array();
	}

	public function getItems( $batch = null, $batchSize = 25 ){
		if ( is_int( $batch ) && is_int( $batchSize ) ) {
			return $this->wg->PaginateArray( $this->items, $batch, $batchSize );
		}

		return $this->items;
	}

	public function addItem( CategoryItem $item ){
		$this->items[] = $item;
	}
}

class CategoryItem{
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