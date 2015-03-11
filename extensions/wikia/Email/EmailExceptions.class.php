<?php

namespace Email;

class ControllerException extends \Exception {
	public $errorType = 'error';
}

class Check extends ControllerException {
	public $errorType = 'checkError';
};

class Fatal extends ControllerException {
	public $errorType = 'fatalError';
};
