<?php

namespace Email;

abstract class ControllerException extends \Exception {
	abstract public function getErrorType();
}

class Check extends ControllerException {
	const ERROR_TYPE = 'checkError';
	public function getErrorType() {
		return self::ERROR_TYPE;
	}
};

class Fatal extends ControllerException {
	const ERROR_TYPE = 'fatalError';
	public function getErrorType() {
		return self::ERROR_TYPE;
	}
};
