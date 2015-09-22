<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxTemplatesHelper;
use Wikia\PortableInfobox\Parser\Nodes\NodeInfobox;

class PortableInfoboxDataService {

	const IMAGE_FIELD_TYPE = 'image';
	const INFOBOXES_PROPERTY_NAME = 'infoboxes';

	/**
	 * @var Title $title
	 */
	protected $title;
	protected $templateHelper;
	protected $cache;
	protected $cachekey;

	/**
	 * @param $title Title
	 * @param $helper
	 */
	protected function __construct( $title, $helper ) {
		$this->title = $title;
		$this->templateHelper = $helper ? $helper : new PortableInfoboxTemplatesHelper();
		$this->cachekey = wfMemcKey( $title->getArticleID(), self::INFOBOXES_PROPERTY_NAME );
	}

	public static function newFromTitle( $title, $helper = null ) {
		return new PortableInfoboxDataService( $title, $helper );
	}

	public static function newFromPageID( $pageid, $helper = null ) {
		return new PortableInfoboxDataService( Title::newFromID( $pageid ), $helper );
	}

	/**
	 * Returns infobox data
	 *
	 * @return array in format [ 'data' => [], 'sources' => [] ] or [] will be returned
	 */
	public function getData() {
		if ( $this->title && $this->title->exists() && $this->title->inNamespace( NS_TEMPLATE ) ) {
			$hidden = $this->templateHelper->parseInfoboxes( $this->title );
			if ( $hidden ) {
				$this->delete();
				$this->set( json_decode( $hidden, true ) );
			};
		}

		return $this->get();
	}

	/**
	 * Get image list from infobox data
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
	 */
	public function save( NodeInfobox $raw ) {
		if ( $raw ) {
			$stored = $this->get();
			$stored[] = [ 'data' => $raw->getRenderData(), 'sources' => $raw->getSource() ];
			$this->set( $stored );
		}
	}

	/**
	 * Remove infobox data from page props and memcache
	 */
	public function delete() {
		$this->clear();
		unset( $this->cache );
	}

	/**
	 * Purge mem cache and local cache
	 */
	public function purge() {
		wfDebug( __CLASS__ . ": PURGE" );
		global $wgMemc;
		$wgMemc->delete( $this->cachekey );
		unset( $this->cache );
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
				$data = json_decode( Wikia::getProps( $id, self::INFOBOXES_PROPERTY_NAME ), true );
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
			Wikia::setProps( $id, [ self::INFOBOXES_PROPERTY_NAME => json_encode( $data ) ] );
		}
	}

	protected function clear() {
		$id = $this->title->getArticleID();
		if ( $id ) {
			global $wgMemc;
			$wgMemc->set( $this->cachekey, '', WikiaResponse::CACHE_STANDARD );
			Wikia::setProps( $id, [ self::INFOBOXES_PROPERTY_NAME => '' ] );
		}
	}
}
