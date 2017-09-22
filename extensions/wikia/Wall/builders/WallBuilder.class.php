<?php

/**
 * Abstract base class for Wall Content Builders
 */
abstract class WallBuilder {
	/**
	 * Populate an exception with proper context for logging, and throw it
	 *
	 * @param string $class
	 * @param string $message
	 * @param array $additionalContext
	 *
	 * @return
	 */
	abstract protected function throwException( string $class, string $message, array $additionalContext=[] );

	/**
	 * Get the data which should be generated at the end of the builder flow
	 * @return mixed
	 */
	abstract public function build();
}
