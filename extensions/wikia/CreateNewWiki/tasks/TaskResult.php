<?php

namespace Wikia\CreateNewWiki\Tasks;

class TaskResult {

	private $isOk = false;

	/** @var string */
	private $message = "";

	/** @var [] */
	private $context = [];

	private function __construct( $isOk, $message, $context ) {
		$this->isOk = $isOk;
		$this->message = $message;
		$this->context = $context;
	}

	public static function createForSuccess( $context = false ) {
		return new TaskResult( true, '', $context );
	}

	public static function createForError( $message, $context = false ) {
		return new TaskResult( false, $message, $context );
	}

	public function isOk() {
		return $this->isOk;
	}

	public function getMessage() {
		return $this->message;
	}

	public function createLoggingContext( ) {

		//TODO combine most important data from TaskContext with local message, status code and context data

		return $this->context;
	}
}