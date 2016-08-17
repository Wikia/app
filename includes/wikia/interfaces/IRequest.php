<?php

/**
 * Interface IRequest
 *
 * An interface implemented by classes like WebRequest or WikiaRequest.
 * Ensures that basic methods for interacting with a request exist.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 */

namespace Wikia\Interfaces;

interface IRequest {

	/**
	 * Return true if the named value is set in the input, whatever that
	 * value is (even "0"). Return false if the named value is not set.
	 *
	 * @param string $name
	 * @return bool
	 */
	public function getCheck( $name );

	/**
	 * Fetch a scalar from the input or return $default if it's not set.
	 * Returns a string. Arrays are discarded. Useful for
	 * non-freeform text inputs (e.g. predefined internal text keys
	 * selected by a drop-down menu).
	 *
	 * @param string $name
	 * @param string|null $default
	 * @return string
	 */
	public function getVal( $name, $default = null );

	/**
	 * Fetch a boolean value from the input or return $default if not set.
	 * Guaranteed to return true or false, with normal PHP semantics for
	 * boolean interpretation of strings.
	 *
	 * @param string $name
	 * @param bool $default
	 * @return bool
	 */
	public function getBool( $name, $default = false );

	/**
	 * Fetch an integer value from the input or return $default if not set.
	 * Guaranteed to return an integer; non-numeric input should return 0.
	 *
	 * @param string $name
	 * @param int $default
	 * @return int
	 */
	public function getInt( $name, $default = 0 );

	/**
	 * Fetch an array from the input or return $default if it's not set.
	 * If source was scalar, should return an array with a single element.
	 * If no source and no default, should return an empty array.
	 *
	 * @param string $name
	 * @param array $default
	 * @return array
	 */
	public function getArray( $name, $default = [] );

	/**
	 * Set an arbitrary value into our get/post data.
	 *
	 * @param string $name Key name to use
	 * @param mixed $value Value to set
	 * @return mixed
	 */
	public function setVal( $name, $value );

	/**
	 * Get data from $_SESSION
	 *
	 * @param string $key Name of a key in $_SESSION
	 * @return mixed
	 */
	public function getSessionData( $key );

	/**
	 * Set data to $_SESSION
	 *
	 * @param string $key Name of a key in $_SESSION
	 * @param mixed $data
	 */
	public function setSessionData( $key, $data );

	/**
	 * Should verify if a request was a POST one and
	 * return true if it was and false otherwise.
	 *
	 * @return bool
	 */
	public function wasPosted();

	/**
	 * Should verify if write request is a valid, non-CSRF request
	 * (uses POST and contains a valid edit token)
	 *
	 * @param \User $user
	 * @return mixed
	 * @throws BadRequestException
	 */
	public function assertValidWriteRequest( \User $user );
}
