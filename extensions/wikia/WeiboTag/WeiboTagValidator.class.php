<?php

class WeiboTagValidator {

	public static function validateParams($params) {
		foreach ($params as $paramName => $paramValue) {
			switch ($paramName) {
				case 'uids': {
					$validator = new WikiaValidatorString([
						'required' => true
					]);
					return $validator->isValid($paramValue);
					break;
				}
				default: {
					return true;
				}
			}
		}
	}
}
