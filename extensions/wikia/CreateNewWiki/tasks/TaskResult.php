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

	public static function createForSuccess( $context = [] ) {
		return new TaskResult( true, '', $context );
	}

	public static function createForError( $message, $context = [] ) {
		return new TaskResult( false, $message, $context );
	}

	public function isOk() {
		return $this->isOk;
	}

	public function getMessage() {
		return $this->message;
	}

	public function createLoggingContext( ) {
		$resultContext = array_merge( get_object_vars( $this ), $this->context );

		return $resultContext;
	}
}
