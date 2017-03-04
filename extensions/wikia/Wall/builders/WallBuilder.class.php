<?php

/**
 * Abstract base class for Wall Content Builders
 */
abstract class WallBuilder {
	/**
	 * Populate an exception with proper context for logging, and throw it
	 * @param string $message
	 * @throws WallBuilderException
	 */
	abstract protected function throwException( string $message );

	/**
	 * Get the data which should be generated at the end of the builder flow
	 * @return mixed
	 */
	abstract public function build();
}
