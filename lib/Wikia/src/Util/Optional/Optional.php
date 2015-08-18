<?php

namespace Wikia\Util\Optional;

use Wikia\Util\Assert;

class Optional {

	/** @var bool */
	private $isPresent;

	/** @var mixed */
	private $value;

	public function isPresent() {
		return $this->isPresent;
	}

	public function get() {
		return $this->orElseThrow();
	}

	public function orElse($value) {
		if ($this->isPresent) {
			return $this->value;
		}

		return $value;
	}

	public function orElseThrow($exception=null) {
		if ($this->isPresent) {
			return $this->value;
		}

		if ($exception == null) {
			$exception = new InvalidOptionalOperation();
		}

		throw $exception;
	}

	public static function of($value) {
		Assert::true($value !== null);

		$optional = new Optional();
		$optional->value = $value;
		$optional->isPresent = true;

		return $optional;
	}

	public static function ofNullable($value) {
		if ($value === null) {
			return self::emptyOptional();
		}

		return self::of($value);
	}

	public static function emptyOptional() {
		$optional = new Optional();
		$optional->isPresent = false;

		return $optional;
	}
}
