<?php
abstract class WikiaParserTagController extends WikiaController {

	/**
	 * @desc Checks if parameter from parameters array is valid
	 *
	 * @param String $paramName name of parameter which should get validated
	 * @param String|Mixed $paramValue value of the parameter
	 * @param String $errorMessage reference to a string variable which will get error message if one occurs
	 *
	 * @return bool
	 */
	protected function isTagParamValid( $paramName, $paramValue, &$errorMessage ) {
		$isValid = false;

		$validator = $this->buildParamValidator( $paramName );
		if( !is_null($validator) && $validator instanceof WikiaValidator ) {
			$isValid = $validator->isValid( $paramValue );

			if( !$isValid ) {
				$errorMessage = $validator->getError()->getMsg();
			}
		}

		return $isValid;
	}

	/**
	 * @desc Factory method to create validators for params; returns false if validator can't be created
	 *
	 * @param String $paramName
	 * @return null|WikiaValidator
	 */
	protected function buildParamValidator( $paramName ) {
		return null;
	}
}
