<?php

namespace DataValues;

/**
 * Class representing a monolingual text value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MonolingualTextValue extends DataValueObject {

	/**
	 * String value.
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Language code.
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	protected $language;

	/**
	 * @since 0.1
	 *
	 * @param string $languageCode
	 * @param string $value
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( $languageCode, $value ) {
		if ( !is_string( $languageCode ) ) {
			throw new IllegalValueException( 'Can only construct MonolingualTextValue with a string language code.' );
		}
		elseif ( $languageCode === '' ) {
			throw new IllegalValueException( 'Can not construct a MonolingualTextValue with an empty language code.' );
		}

		if ( !is_string( $value ) ) {
			throw new IllegalValueException( 'Can only construct a MonolingualTextValue with a string value.' );
		}

		$this->value = $value;
		$this->language = $languageCode;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( array( $this->language, $this->value ) );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 *
	 * @return MonolingualTextValue
	 */
	public function unserialize( $value ) {
		list ( $languageCode, $value ) = unserialize( $value );
		$this->__construct( $languageCode, $value );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @return string
	 */
	public static function getType() {
		return 'monolingualtext';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @return string
	 */
	public function getSortKey() {
		// TODO: we might want to re-think this key. Perhaps the language should simply be omitted.
		return $this->language . $this->value;
	}

	/**
	 * @see DataValue::getValue
	 *
	 * @return MonolingualTextValue
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * Returns the text.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getText() {
		return $this->value;
	}

	/**
	 * Returns the language code.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->language;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return string[]
	 */
	public function getArrayValue() {
		return array(
			'text' => $this->value,
			'language' => $this->language,
		);
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with @see getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param string[] $data
	 *
	 * @return MonolingualTextValue
	 * @throws IllegalValueException
	 */
	public static function newFromArray( $data ) {
		self::requireArrayFields( $data, array( 'language', 'text' ) );

		return new static( $data['language'], $data['text'] );
	}

}
