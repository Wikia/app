<?php

namespace Wikia\CreateNewWiki\Tasks;

class RunResult {

	const ERROR_NO_ERROR			                   = 0;
	const ERROR_SQL_FILE_BROKEN                        = 8;

	private $isOk = false;

	/** @var int */
	private $statusCode = 0;

	/** @var string */
	private $message = "";

	/** @var [] */
	private $context = [];

	private function __construct( $isOk, $message, $statusCode, $context ) {
		$this->isOk = $isOk;
		$this->message = $message;
		$this->statusCode = $statusCode;
		$this->context = $context;
	}

	public static function createForSuccess( $context = false ) {
		return new RunResult( true, '', self::ERROR_NO_ERROR, $context );
	}

	public static function createForError( $message, $statusCode, $context = false ) {
		return new RunResult( false, $message, $statusCode, $context );
	}

	public function isOk() {
		return $this->isOk;
	}

	public function getStatusCode() {
		return $this->statusCode;
	}

	public function getMessage() {
		return $this->message;
	}

	public function createLoggingContext( TaskContext $taskContext ) {

		//TODO combine most important data from TaskContext with local message, status code and context data

		return $this->context;
	}
}