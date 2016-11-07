<?php

namespace Onoi\MessageReporter;

/**
 * Interface for objects that can report messages
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface MessageReporter {

	/**
	 * Report the provided message
	 *
	 * @since 1.0
	 *
	 * @param string $message
	 */
	public function reportMessage( $message );

}
