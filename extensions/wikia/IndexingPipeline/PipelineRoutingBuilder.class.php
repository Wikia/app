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

	private $keys;
	private $name;

	private function __construct() {
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
		if ( $this->isAllowedType( $type ) ) {
			$this->keys[ self::ROUTE_TYPE_KEY ] = $type;
		} else {
			throw new \RuntimeException( "Wrong \"{$type}\" type routing key provided" );
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
		if ( $this->isAllowedAction( $action ) ) {
			$this->keys[ self::ROUTE_ACTION_KEY ] = $action;
		} else {
			throw new \RuntimeException( "Wrong \"{$action}\" action routing key provided" );
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
	private static function preparePageNamespaceName( $namespaceId ) {
		global $wgContentNamespaces;

		if ( in_array( $namespaceId, $wgContentNamespaces ) ) {
			return self::NS_CONTENT;
		}

		return strtolower( \MWNamespace::getCanonicalName( $namespaceId ) );
	}

	private function isAllowedAction( $action ) {
		return in_array( $action, [ self::ACTION_CREATE, self::ACTION_DELETE, self::ACTION_UPDATE ] );
	}

	private function isAllowedType( $type ) {
		return in_array( $type, [ self::TYPE_ARTICLE, self::TYPE_WIKIA ] );
	}
}
