<?php

namespace Onoi\MessageReporter;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class MessageReporterFactory {

	/**
	 * @var MessageReporterFactory
	 */
	private static $instance = null;

	/**
	 * @since 1.0
	 *
	 * @return MessageReporterFactory
	 */
	public static function getInstance() {

		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * @since 1.0
	 */
	public static function clear() {
		self::$instance = null;
	}

	/**
	 * @since 1.0
	 *
	 * @return NullMessageReporter
	 */
	public function newNullMessageReporter() {
		return new NullMessageReporter();
	}

	/**
	 * @since 1.0
	 *
	 * @return ObservableMessageReporter
	 */
	public function newObservableMessageReporter() {
		return new ObservableMessageReporter();
	}

	/**
	 * @since 1.2
	 *
	 * @return SpyMessageReporter
	 */
	public function newSpyMessageReporter() {
		return new SpyMessageReporter();
	}

}
