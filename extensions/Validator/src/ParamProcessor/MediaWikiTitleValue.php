<?php

namespace ParamProcessor;

use DataValues\DataValueObject;
use InvalidArgumentException;
use Title;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MediaWikiTitleValue extends DataValueObject {

	/**
	 * @since 0.1
	 *
	 * @var Title
	 */
	protected $title;

	/**
	 * @since 0.1
	 *
	 * @param Title $title
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( Title $title ) {
		$this->title = $title;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function serialize() {
		return $this->title->getFullText();
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @return MediaWikiTitleValue
	 */
	public function unserialize( $value ) {
		$this->__construct( Title::newFromText( $value ) );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType() {
		return 'mediawikititle';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @since 0.1
	 *
	 * @return string|float|int
	 */
	public function getSortKey() {
		return $this->title->getCategorySortkey();
	}

	/**
	 * Returns the Title object.
	 * @see DataValue::getValue
	 *
	 * @since 0.1
	 *
	 * @return Title
	 */
	public function getValue() {
		return $this->title;
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param mixed $data
	 *
	 * @return MediaWikiTitleValue
	 */
	public static function newFromArray( $data ) {
		return new static( $data );
	}

}