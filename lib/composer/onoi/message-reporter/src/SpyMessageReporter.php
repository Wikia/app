<?php

namespace Onoi\MessageReporter;

/**
 * @license GNU GPL v2+
 * @since 1.2
 *
 * @author mwjames
 */
class SpyMessageReporter implements MessageReporter {

	/**
	 * @var array
	 */
	private $messages = array();

	/**
	 * @since 1.2
	 *
	 * {@inheritDoc}
	 */
	public function reportMessage( $message ) {
		$this->messages[] = $message;
	}

	/**
	 * @since 1.2
	 *
	 * @return array
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * @since 1.2
	 *
	 * @return string
	 */
	public function getMessagesAsString() {
		return implode( ', ', $this->messages );
	}

	/**
	 * @since 1.2
	 */
	public function clearMessages() {
		$this->messages =  array();
	}

}
