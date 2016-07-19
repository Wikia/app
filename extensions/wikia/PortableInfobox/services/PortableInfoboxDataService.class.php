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
		$this->cachekey = wfMemcKey( __CLASS__, $this->title->getArticleID(), self::INFOBOXES_PROPERTY_NAME );
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
	 * Returns infobox data, chain terminator method
	 *
	 * @return array in format [ [ 'data' => [], 'sources' => [] ] or [] will be returned
	 */
	public function getData() {
		if ( $this->title && $this->title->exists() && $this->title->inNamespace( NS_TEMPLATE ) ) {
			$incOnlyTemplates = $this->templateHelper->parseInfoboxes( $this->title );
			if ( $incOnlyTemplates ) {
				$this->delete();
				$this->set( $incOnlyTemplates );
			};
		}
		$result = $this->get();

		return $result !== null ? $result : [ ];
	}

	/**
	* @param $title
	* @return array of strings (infobox markups)
	*/
	public function getInfoboxes() {
		return $this->templateHelper->getMarkup($this->title);
	}

	/**
	 * Get image list from multiple infoboxes data
	 *
	 * @return array
	 */
	public function getImages() {
		$images = [];
		foreach ( $this->getData() as $infobox ) {
			if ( is_array( $infobox[ 'data' ] ) ) {
				$images = array_merge( $images, $this->getImageFromOneInfoboxData( $infobox[ 'data' ] ) );
			}
		}
		return array_unique( $images );
	}

	/**
	 * Get image list from single infobox data
	 *
	 * @return array
	 */
	private function getImageFromOneInfoboxData( $infoboxData ) {
		$images = [];
		foreach ( $infoboxData as $infoboxDataField ) {
			if ( $infoboxDataField[ 'type' ] === self::IMAGE_FIELD_TYPE && isset( $infoboxDataField[ 'data' ] ) ) {
				$images = array_merge( $images, $this->getImagesFromOneNodeImageData( $infoboxDataField[ 'data' ] ) );
			}
		}
		return $images;
	}

	/**
	 * Get image list from single NodeImage data
	 *
	 * @return array
	 */
	private function getImagesFromOneNodeImageData( $nodeImageData ) {
		$images = [];
		for ( $i = 0; $i < count( $nodeImageData ); $i++ ) {
			if ( !empty( $nodeImageData[ $i ] [ 'key' ] ) ) {
				$images[] = $nodeImageData[ $i ][ 'key' ];
			}
		}
		return $images;
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
		WikiaDataAccess::cachePurge( $this->cachekey );
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
			return WikiaDataAccess::cache( $this->cachekey, WikiaResponse::CACHE_STANDARD, function () use ( $id ) {
				return json_decode( $this->propsProxy->get( $id, self::INFOBOXES_PROPERTY_NAME ), true );
			} );
		}

		return [ ];
	}

	protected function store( $data ) {
		$id = $this->title->getArticleID();
		if ( $id ) {
			WikiaDataAccess::cacheWithOptions( $this->cachekey, function () use ( $data ) {
				return $data;
			}, [ 'command' => WikiaDataAccess::REFRESH_CACHE, 'cacheTTL' => WikiaResponse::CACHE_STANDARD ] );
			$this->propsProxy->set( $id, [ self::INFOBOXES_PROPERTY_NAME => json_encode( $data ) ] );
		}
	}

	protected function clear() {
		$id = $this->title->getArticleID();
		if ( $id ) {
			$this->propsProxy->set( $id, [ self::INFOBOXES_PROPERTY_NAME => '' ] );
			// don't cache clear state
			$this->purge();
		}
	}
}
