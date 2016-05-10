<?php

namespace Wikia\CreateNewWiki\Tasks;

class PreValidationResult {

	const ERROR_NO_ERROR			                   = 0;
	const ERROR_BAD_EXECUTABLE_PATH                    = 1;
	const ERROR_DOMAIN_NAME_TAKEN                      = 2;
	const ERROR_DOMAIN_BAD_NAME                        = 3;
	const ERROR_DOMAIN_IS_EMPTY                        = 4;
	const ERROR_DOMAIN_TOO_LONG                        = 5;
	const ERROR_DOMAIN_TOO_SHORT	                   = 6;
	const ERROR_DOMAIN_POLICY_VIOLATIONS               = 7;
	const ERROR_SQL_FILE_BROKEN                        = 8;
	const ERROR_DATABASE_ALREADY_EXISTS                = 9;
	const ERROR_DATABASE_WIKI_FACTORY_TABLES_BROKEN    = 10;
	const ERROR_DATABASE_WRITE_TO_CITY_DOMAINS_BROKEN  = 11;
	const ERROR_USER_IN_ANON                           = 12;
	const ERROR_READONLY                               = 13;
	const ERROR_DATABASE_WRITE_TO_CITY_LIST_BROKEN     = 15;

	/** @var bool */
	private $isValid = false;

	/** @var int */
	private $statusCode = 0;

	/** @var string */
	private $message = "";

	/** @var [] */
	private $context = [];

	private function __construct( $isValid, $message, $statusCode, $context ) {
		$this->isValid = $isValid;
		$this->message = $message;
		$this->statusCode = $statusCode;
		$this->context = $context;
	}

	public static function createForSuccess( $context = false ) {
		return new PreValidationResult(true, '', self::ERROR_NO_ERROR, $context );
	}

	public static function createForError( $message, $statusCode, $context = false ) {
		return new PreValidationResult(false, $message, $statusCode, $context );
	}

	public function isValid() {
		return $this->isValid;
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