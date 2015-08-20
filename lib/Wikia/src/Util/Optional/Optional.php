<?php

namespace Wikia\Util\Optional;

use Exception;
use Wikia\Util\Assert;

class Optional {

	/** @var mixed */
	private $value;

	private function __construct($value) {
		$this->value = $value;
	}

	public function isPresent() {
		return $this->value !== null;
	}

	public function get() {
		return $this->orElseThrow();
	}

	public function orElse($value) {
		if ($this->isPresent()) {
			return $this->value;
		}

		return $value;
	}

	public function orElseThrow(Exception $exception=null) {
		if ($this->isPresent()) {
			return $this->value;
		}

		if ($exception == null) {
			$exception = new InvalidOptionalOperation();
		}

		throw $exception;
	}

	public static function of($value) {
		Assert::true($value !== null);
		return new Optional($value);
	}

	public static function ofNullable($value) {
		if ($value === null) {
			return self::emptyOptional();
		}

		return self::of($value);
	}

	public static function emptyOptional() {
		return new Optional(null);
	}
}
