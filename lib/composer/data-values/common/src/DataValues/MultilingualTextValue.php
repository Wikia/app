<?php

namespace DataValues;

/**
 * Class representing a multilingual text value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MultilingualTextValue extends DataValueObject {

	/**
	 * Array with language codes pointing to their associated texts.
	 *
	 * @var MonolingualTextValue[]
	 */
	private $texts = array();

	/**
	 * @since 0.1
	 *
	 * @param MonolingualTextValue[] $monolingualValues
	 *
	 * @throws IllegalValueException
	 */
	public function __construct( array $monolingualValues ) {
		foreach ( $monolingualValues as $monolingualValue ) {
			if ( !( $monolingualValue instanceof MonolingualTextValue ) ) {
				throw new IllegalValueException( 'Can only construct MultilingualTextValue from MonolingualTextValue objects' );
			}

			$languageCode = $monolingualValue->getLanguageCode();

			if ( array_key_exists( $languageCode, $this->texts ) ) {
				throw new IllegalValueException( 'Can only add a single MonolingualTextValue per language to a MultilingualTextValue' );
			}

			$this->texts[$languageCode] = $monolingualValue;
		}
	}

	/**
	 * @see Serializable::serialize
	 *
	 * @return string
	 */
	public function serialize() {
		return serialize( $this->texts );
	}

	/**
	 * @see Serializable::unserialize
	 *
	 * @param string $value
	 */
	public function unserialize( $value ) {
		$this->__construct( unserialize( $value ) );
	}

	/**
	 * @see DataValue::getType
	 *
	 * @return string
	 */
	public static function getType() {
		return 'multilingualtext';
	}

	/**
	 * @see DataValue::getSortKey
	 *
	 * @return string|float|int
	 */
	public function getSortKey() {
		return empty( $this->texts ) ? '' : reset( $this->texts )->getSortKey();
	}

	/**
	 * Returns the texts as an array of monolingual text values.
	 *
	 * @since 0.1
	 *
	 * @return MonolingualTextValue[]
	 */
	public function getTexts() {
		return $this->texts;
	}

	/**
	 * Returns the multilingual text value
	 * @see DataValue::getValue
	 *
	 * @return MultilingualTextValue
	 */
	public function getValue() {
		return $this;
	}

	/**
	 * @see DataValue::getArrayValue
	 *
	 * @return mixed
	 */
	public function getArrayValue() {
		$values = array();

		/**
		 * @var MonolingualTextValue $text
		 */
		foreach ( $this->texts as $text ) {
			$values[] = $text->getArrayValue();
		}

		return $values;
	}

	/**
	 * Constructs a new instance of the DataValue from the provided data.
	 * This can round-trip with
	 * @see   getArrayValue
	 *
	 * @since 0.1
	 *
	 * @param mixed $data
	 *
	 * @throws IllegalValueException if $data is not an array.
	 * @return MultilingualTextValue
	 */
	public static function newFromArray( $data ) {
		if ( !is_array( $data ) ) {
			throw new IllegalValueException( "array expected" );
		}

		$values = array();

		foreach ( $data as $monolingualValue ) {
			$values[] = MonolingualTextValue::newFromArray( $monolingualValue );
		}

		return new static( $values );
	}

}
