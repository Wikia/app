<?php

namespace Onoi\MessageReporter;

/**
 * Message reporter that reports messages by passing them along to all
 * registered handlers.
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ObservableMessageReporter implements MessageReporter {

	/**
	 * @since 1.0
	 *
	 * @var MessageReporter[]
	 */
	protected $reporters = array();

	/**
	 * @since 1.0
	 *
	 * @var callable[]
	 */
	protected $callbacks = array();

	/**
	 * @see MessageReporter::report
	 *
	 * @since 1.0
	 *
	 * @param string $message
	 */
	public function reportMessage( $message ) {
		foreach ( $this->reporters as $reporter ) {
			$reporter->reportMessage( $message );
		}

		foreach ( $this->callbacks as $callback ) {
			call_user_func( $callback, $message );
		}
	}

	/**
	 * Register a new message reporter.
	 *
	 * @since 1.0
	 *
	 * @param MessageReporter $reporter
	 */
	public function registerMessageReporter( MessageReporter $reporter ) {
		$this->reporters[] = $reporter;
	}

	/**
	 * Register a callback as message reporter.
	 *
	 * @since 1.0
	 *
	 * @param callable $handler|null
	 */
	public function registerReporterCallback( $handler = null ) {
		if ( is_callable( $handler ) ) {
			$this->callbacks[] = $handler;
		}
	}

}
