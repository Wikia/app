<?php

namespace Wikia\IndexingPipeline;

class PipelineRoutingBuilder {
	const NS_CONTENT = 'content';
	const ROUTE_ACTION_KEY = '_action';
	const ROUTE_NAMESPACE_KEY = '_namespace';
	const ROUTE_TYPE_KEY = '_type';
	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';
	const TYPE_ARTICLE = 'article';
	const TYPE_WIKIA = 'wikia';

	protected $keys;
	protected $name;

	protected function __construct() {
		$this->keys = [ ];
	}

	/**
	 * Provides routing key builder
	 * @return PipelineRoutingBuilder
	 */
	public static function create() {
		return new PipelineRoutingBuilder();
	}

	/**
	 * Sets producer name
	 *
	 * @param string $name
	 *
	 * @return PipelineRoutingBuilder $this
	 */
	public function addName( $name ) {
		$this->name = $name;

		return $this;
	}

	public function addType( $type ) {
		if ( in_array( $type, [ self::TYPE_ARTICLE, self::TYPE_WIKIA ] ) ) {
			$this->keys[ self::ROUTE_TYPE_KEY ] = $type;
		}

		return $this;
	}

	/**
	 * Adds action key to routing
	 *
	 * @param string $action
	 *
	 * @return PipelineRoutingBuilder $this
	 */
	public function addAction( $action ) {
		if ( in_array( $action, [ self::ACTION_CREATE, self::ACTION_DELETE, self::ACTION_UPDATE ] ) ) {
			$this->keys[ self::ROUTE_ACTION_KEY ] = $action;
		}

		return $this;
	}

	/**
	 * Adds namespace key to routing, will translate numeric namespace to english name
	 *
	 * @param integer|string $ns
	 *
	 * @return PipelineRoutingBuilder $this
	 */
	public function addNamespace( $ns ) {
		if ( is_numeric( $ns ) ) {
			$ns = static::preparePageNamespaceName( $ns );
		}
		if ( !empty( $ns ) ) {
			$this->keys[ self::ROUTE_NAMESPACE_KEY ] = $ns;
		}

		return $this;
	}

	/**
	 * Returns created routing key
	 * @return string routing key
	 */
	public function build() {
		$keys = array_map( function ( $key, $value ) {
			return "{$key}:{$value}";
		}, array_keys( $this->keys ), $this->keys );

		return implode( ".", array_merge( [ $this->name ], $keys ) );
	}

	/**
	 * @desc For given page title returns it's lowercase namespace in english.
	 * Namespace CONTENT means that page is in 0 or one of the custom content namespaces.
	 *
	 * @param integer $namespaceId
	 *
	 * @return string lowercase english namespace
	 */
	protected static function preparePageNamespaceName( $namespaceId ) {
		global $wgContentNamespaces;

		if ( in_array( $namespaceId, $wgContentNamespaces ) ) {
			return self::NS_CONTENT;
		}

		return strtolower( \MWNamespace::getCanonicalName( $namespaceId ) );
	}
}
