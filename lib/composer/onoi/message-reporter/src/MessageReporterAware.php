<?php

namespace Onoi\MessageReporter;

/**
 * @license GNU GPL v2+
 * @since 1.2
 *
 * @author mwjames
 */
interface MessageReporterAware {

	/**
	 * Allows to inject a MessageReporter and make an object aware of its
	 * existence.
	 *
	 * @since 1.2
	 *
	 * @param MessageReporter $messageReporter
	 */
	public function setMessageReporter( MessageReporter $messageReporter );

}
