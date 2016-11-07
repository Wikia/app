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
	 * @var string
	 */
	private $text;

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @since 0.1
	 *
	 * @param string $languageCode
	 * @param string $text
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( $languageCode, $text ) {
		if ( !is_string( $languageCode ) ) {
			throw new IllegalValueException( 'Can only construct MonolingualTextValue with a string language code.' );
		}
		elseif ( $languageCode === '' ) {
			throw new IllegalValueException( 'Can not construct a MonolingualTextValue with an empty language code.' );
		}

		if ( !is_string( $text ) ) {
			throw new IllegalValueException( 'Can only construct a MonolingualTextValue with a string value.' );
		}

		$this->text = $text;
		$this->languageCode = $languageCode;
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( array( $this->languageCode, $this->text ) );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 */
	public function unserialize( $value ) {
		list( $languageCode, $text ) = unserialize( $value );
		$this->__construct( $languageCode, $text );
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
		return $this->languageCode . $this->text;
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
		return $this->text;
	}

	/**
	 * Returns the language code.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getLanguageCode() {
		return $this->languageCode;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return string[]
	 */
	public function getArrayValue() {
		return array(
			'text' => $this->text,
			'language' => $this->languageCode,
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
