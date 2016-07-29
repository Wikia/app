<?php

namespace DataValues;

/**
 * Interface for objects that represent a single data value.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface DataValue extends \Hashable, \Comparable, \Serializable, \Immutable, \Copyable {

	/**
	 * Returns the identifier of the datavalues type.
	 *
	 * This is not to be confused with the DataType provided by the DataTypes extension.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public static function getType();

	/**
	 * Returns a key that can be used to sort the data value with.
	 * It can be either numeric or a string.
	 *
	 * @since 0.1
	 *
	 * @return string|float|int
	 */
	public function getSortKey();

	/**
	 * Returns the value contained by the DataValue. If this value is not simple and
	 * does not have it's own type that represents it, the DataValue itself will be returned.
	 * In essence, this method returns the "simplest" representation of the value.
	 *
	 * Example:
	 * - NumberDataValue returns a float or integer
	 * - MediaWikiTitleValue returns a Title object
	 * - QuantityValue returns itself
	 *
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getValue();

	/**
	 * Returns the value in array form.
	 *
	 * For simple values (ie a string) the return value will be equal to that of @see getValue.
	 *
	 * Complex DataValues can provide a nicer implementation though, for instance a
	 * geographical coordinate value could provide an array with keys latitude,
	 * longitude and altitude, each pointing to a simple float value.
	 *
	 * @since 0.1
	 *
	 * @return mixed
	 */
	public function getArrayValue();

	/**
	 * Returns the whole DataValue in array form.
	 *
	 * The array contains:
	 * - value: mixed, same as the result of @see getArrayValue
	 * - type: string, same as the result of @see getType
	 *
	 * This is sufficient for unserialization in a factory.
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	public function toArray();

}
