<?php
abstract class WikiaParserTagController extends WikiaController {

	/**
	 * Simple counter used in generating markers' ids
	 * @var int
	 */
	private $count = 1;

	/**
	 * An array with markers ids and real output for our tags
	 * @var array
	 */
	protected $markers = [];

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
		if( $validator instanceof WikiaValidator ) {
			$isValid = $validator->isValid( $paramValue );

			if( !$isValid ) {
				$errorMessage = $validator->getError()->getMsg();
			}
		}

		return $isValid;
	}

	/**
	 * @desc Factory method to create validators for params
	 * if should return WikiaValidatorAlwaysTrue if validator can't be created or won't be used
	 *
	 * @param String $paramName
	 * @return WikiaValidator
	 */
	abstract protected function buildParamValidator( $paramName );

	protected function generateMarkerId( Parser $parser ) {
		$wikiaParserMarkerSufix = '-WIKIA-PARSER-MARKER-' . $this->count;
		$this->count++;
		return $parser->uniqPrefix() . $wikiaParserMarkerSufix . "-\x7f";
	}

	protected function addMarkerOutput( $markerId, $output ) {
		$this->markers[$markerId] = $output;
	}

	public function getMarkers() {
		return $this->markers;
	}
}
