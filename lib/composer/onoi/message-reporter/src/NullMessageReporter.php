<?php

namespace Onoi\MessageReporter;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NullMessageReporter implements MessageReporter {

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function reportMessage( $message ) {}

}
