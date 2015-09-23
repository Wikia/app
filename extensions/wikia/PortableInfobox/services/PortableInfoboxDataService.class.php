<?php

use Wikia\PortableInfobox\Helpers\PagePropsProxy;
use Wikia\PortableInfobox\Helpers\PortableInfoboxTemplatesHelper;
use Wikia\PortableInfobox\Parser\Nodes\NodeInfobox;

class PortableInfoboxDataService {

	const IMAGE_FIELD_TYPE = 'image';
	const INFOBOXES_PROPERTY_NAME = 'infoboxes';

	protected $title;
	protected $templateHelper;
	protected $propsProxy;
	protected $cache;
	protected $cachekey;

	/**
	 * @param $title Title
	 *
	 * @internal param $helper
	 */
	protected function __construct( $title ) {
		$this->title = $title !== null ? $title : new Title();
		$this->templateHelper = new PortableInfoboxTemplatesHelper();
		$this->propsProxy = new PagePropsProxy();
		$this->cachekey = wfMemcKey( $this->title->getArticleID(), self::INFOBOXES_PROPERTY_NAME );
	}

	public static function newFromTitle( $title ) {
		return new PortableInfoboxDataService( $title );
	}

	public static function newFromPageID( $pageid ) {
		return new PortableInfoboxDataService( Title::newFromID( $pageid ) );
	}

	// set internal helpers methods
	public function setTemplatesHelper( $helper ) {
		$this->templateHelper = $helper;

		return $this;
	}

	public function setPagePropsProxy( $proxy ) {
		$this->propsProxy = $proxy;

		return $this;
	}

	/**
	 * Returns infobox data, terminal method
	 *
	 * @return array in format [ 'data' => [], 'sources' => [] ] or [] will be returned
	 */
	public function getData() {
		if ( $this->title && $this->title->exists() && $this->title->inNamespace( NS_TEMPLATE ) ) {
			$hidden = $this->templateHelper->parseInfoboxes( $this->title );
			if ( $hidden ) {
				$this->delete();
				$this->set( $hidden );
			};
		}
		$result = $this->get();

		return $result !== null ? $result : [ ];
	}

	/**
	 * Get image list from infobox data, terminal method
	 *
	 * @return array
	 */
	public function getImages() {
		$images = [ ];

		foreach ( $this->getData() as $infobox ) {
			// ensure data array exists
			$data = is_array( $infobox[ 'data' ] ) ? $infobox[ 'data' ] : [ ];
			foreach ( $data as $field ) {
				if ( $field[ 'type' ] == self::IMAGE_FIELD_TYPE &&
					 isset( $field[ 'data' ] ) &&
					 !empty( $field[ 'data' ][ 'key' ] )
				) {
					$images[ $field[ 'data' ][ 'key' ] ] = true;
				}
			}
		}

		return array_keys( $images );
	}

	/**
	 * Save infobox data, permanently
	 *
	 * @param NodeInfobox $raw infobox parser output
	 *
	 * @return $this
	 */
	public function save( NodeInfobox $raw ) {
		if ( $raw ) {
			$stored = $this->get();
			$stored[] = [ 'data' => $raw->getRenderData(), 'sources' => $raw->getSource() ];
			$this->set( $stored );
		}

		return $this;
	}

	/**
	 * Remove infobox data from page props and memcache
	 */
	public function delete() {
		$this->clear();
		unset( $this->cache );

		return $this;
	}

	/**
	 * Purge mem cache and local cache
	 */
	public function purge() {
		wfDebug( __CLASS__ . ": PURGE" );
		global $wgMemc;
		$wgMemc->delete( $this->cachekey );
		unset( $this->cache );

		return $this;
	}

	// soft cache handlers
	protected function get() {
		if ( !isset( $this->cache ) ) {
			$this->cache = $this->load();
		}

		return $this->cache;
	}

	protected function set( $data ) {
		$this->store( $data );
		$this->cache = $data;
	}

	// PageProps handlers with memcache wrappers
	protected function load() {
		$id = $this->title->getArticleID();
		if ( $id ) {
			global $wgMemc;
			// first try memcache, then go to props
			$data = $wgMemc->get( $this->cachekey );
			if ( $data === false ) {
				$data = json_decode( $this->propsProxy->get( $id, self::INFOBOXES_PROPERTY_NAME ), true );
				$wgMemc->set( $this->cachekey, $data, WikiaResponse::CACHE_STANDARD );
			}

			return $data;
		}

		return [ ];
	}

	protected function store( $data ) {
		$id = $this->title->getArticleID();
		if ( $id ) {
			global $wgMemc;
			$wgMemc->set( $this->cachekey, $data, WikiaResponse::CACHE_STANDARD );
			$this->propsProxy->set( $id, [ self::INFOBOXES_PROPERTY_NAME => json_encode( $data ) ] );
		}
	}

	protected function clear() {
		$id = $this->title->getArticleID();
		if ( $id ) {
			global $wgMemc;
			$wgMemc->set( $this->cachekey, '', WikiaResponse::CACHE_STANDARD );
			$this->propsProxy->set( $id, [ self::INFOBOXES_PROPERTY_NAME => '' ] );
		}
	}
}
