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
			$contents = F::build( 'WikiaMobileCategoryViewer', array( $category ) )->getContents();
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
 * CategoryViewer specialization to access the data using the correct sort-keys
 *
 */
class WikiaMobileCategoryViewer extends CategoryViewer{
	private $items;
	private $count;

	function __construct( Category $category ){
		parent::__construct( $category->getTitle() );

		//get all the members in the category
		$this->limit = null;
	}

	function addImage( Title $title, $sortkey, $pageLength, $isRedirect = false ){
		$this->addItem( $title, $sortkey );
	}

	function addPage( Title $title, $sortkey, $pageLength, $isRedirect = false ){
		$this->addItem( $title, $sortkey );
	}

	function addSubcategory( $title, $sortkey, $pageLength ){
		$this->addItem( $title, $sortkey );
	}

	private function addItem( $title, $sortkey ){
		if ( !is_array( $this->items ) ) {
			$this->items = array();
		}

		if ( !is_int( $this->count ) ) {
			$this->count = 0;
		}
	
 		if ( $title instanceof Title ) {
			$index = strtolower( substr( $sortkey, 0, 1 ) );

			if ( empty( $this->items[$index] ) ) {
				$this->items[$index] = F::build( 'WikiaMobileCategoryItemsCollection' );
			}

			$this->items[$index]->addItem( F::build( 'WikiaMobileCategoryItem', array( $title ) ) );
			$this->count++;
		}
	}

	/**
	 * Executes CategoryViewer::doCategoryQuery() and returns the contents wrapped in a DTO
	 *
	 * @return WikiaMobileCategoryContents The contents of the category
	 */
	public function getContents(){
		parent::doCategoryQuery();

		if ( $this->count > 0 ) {
			ksort( $this->items );
		}

		$ret = F::build( 'WikiaMobileCategoryContents', array( $this->items, $this->count ) );

		$this->count = $this->items = null;

		return $ret;
	}
}

/**
 * Simple DTO to handle the indexed contents of a category
 */
class WikiaMobileCategoryContents implements arrayaccess{
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

	public function offsetSet( $offset, $value ){
        if ( is_null( $offset ) ) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists( $offset ){
        return isset( $this->items[$offset] );
    }

    public function offsetUnset( $offset ){
        unset( $this->container[$offset] );
    }

    public function offsetGet( $offset ){
        return isset( $this->container[$offset] ) ? $this->container[$offset] : null;
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

/**
 * Simple DTO representing one item in a Category
 */
class WikiaMobileCategoryItem{
	const TYPE_ARTICLE = 1;
	const TYPE_SUBCATEGORY = 2;

	private $name;
	private $url;
	private $type;

	function __construct( Title $title ){
		$this->name = $title->getText();
		$this->url = $title->getLocalUrl();
		$this->type = ( $title->getNamespace() == NS_CATEGORY ) ? self::TYPE_SUBCATEGORY : self::TYPE_ARTICLE;;
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