<?php

namespace Wikia\CircuitBreaker;

interface DataStorage {
	/**
	 * @param string $key
	 * @return string
	 */
	public function fetch( $key );

	/**
	 * @param string $key
	 * @param string $value
	 * @return void
	 */
	public function store( $key, $value );

}
