<?php
namespace Wikia\CreateNewWiki;

use Exception;

abstract class ValidationException extends Exception {
	/** @var int $httpStatusCode */
	protected $httpStatusCode = 400;

	/** @var string $headerMessageKey */
	protected $headerMessageKey = '';

	/** @var array $headerMessageParams */
	protected $headerMessageParams = [];

	/** @var string $errorMessageKey */
	protected $errorMessageKey = '';

	/** @var array $errorMessageParams */
	protected $errorMessageParams = [];

	/**
	 * @return int
	 */
	public function getHttpStatusCode(): int {
		return $this->httpStatusCode;
	}

	/**
	 * @return string
	 */
	public function getHeaderMessageKey(): string {
		return $this->headerMessageKey;
	}

	/**
	 * @return string
	 */
	public function getErrorMessageKey(): string {
		return $this->errorMessageKey;
	}

	/**
	 * @return array
	 */
	public function getHeaderMessageParams(): array {
		return $this->headerMessageParams;
	}

	/**
	 * @return array
	 */
	public function getErrorMessageParams(): array {
		return $this->errorMessageParams;
	}
}
