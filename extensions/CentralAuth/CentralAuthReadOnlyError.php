<?php

/**
 * Show an error when the CentralAuth database is locked/read-only
 * and the user tries to do something that requires CentralAuth
 * write access
 * @ingroup Exception
 */
class CentralAuthReadOnlyError extends ErrorPageError {
	public function __construct(){
		parent::__construct(
			'centralauth-readonly',
			'centralauth-readonlytext'
		);
	}
}
