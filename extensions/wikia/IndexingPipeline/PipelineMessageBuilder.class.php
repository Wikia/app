<?php

namespace Wikia\IndexingPipeline;

class PipelineMessageBuilder {

	protected $msg;

	protected function __construct() {
		$this->msg = new \stdClass();
	}

	/**
	 * Creates new message builder instance
	 * @return PipelineMessageBuilder
	 */
	public static function create() {
		return new PipelineMessageBuilder();
	}

	/**
	 * Adds wiki id to message
	 *
	 * @param null|integer $id defaults to current wiki id
	 *
	 * @return PipelineMessageBuilder $this
	 */
	public function addWikiId( $id = null ) {
		if ( !isset( $id ) ) {
			global $wgCityId;
			$id = $wgCityId;
		}

		return $this->addParam( 'cityId', $id );
	}

	/**
	 * Adds page id to message
	 *
	 * @param $id
	 *
	 * @return $this
	 */
	public function addPageId( $id ) {
		return $this->addParam( 'pageId', $id );
	}

	/**
	 * Adds revision id to message
	 *
	 * @param $id
	 *
	 * @return $this
	 */
	public function addRevisionId( $id ) {
		return $this->addParam( 'revisionId', $id );
	}

	/**
	 * Adds params to message
	 *
	 * @param array $params array of name => value pairs
	 *
	 * @return PipelineMessageBuilder $this
	 */
	public function addParams( array $params ) {
		foreach ( $params as $name => $value ) {
			$this->addParam( $name, $value );
		}

		return $this;
	}

	/**
	 * Adds param to message
	 *
	 * @param string $name param key
	 * @param string $value param value
	 *
	 * @return $this
	 */
	public function addParam( $name, $value ) {
		$this->msg->{$name} = $value;

		return $this;
	}

	/**
	 * Returns ready to use message object (terminal operation)
	 * @return \stdClass message
	 */
	public function build() {
		return $this->msg;
	}

}
