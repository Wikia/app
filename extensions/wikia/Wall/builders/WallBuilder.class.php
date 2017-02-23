<?php

/**
 * Abstract base class for Wall Content Builders
 */
abstract class WallBuilder {
	/**
	 * Populate an exception with proper context for logging, and throw it
	 *
	 * @param string $message
	 * @param string $reason
	 *
	 * @return
	 */
	abstract protected function throwException( string $message, string $reason = '' );

	/**
	 * Get the data which should be generated at the end of the builder flow
	 * @return mixed
	 */
	abstract public function build();
}
