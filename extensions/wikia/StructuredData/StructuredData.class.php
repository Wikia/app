<?php
/**
 * @author ADi
 */
class StructuredData {
	/**
	 * @var StructuredDataAPIClient
	 */
	protected $APIClient = null;
	/**
	 * @var SDContext
	 */
	private $context = null;

	public function __construct( StructuredDataAPIClient $apiClient ) {
		$this->context = F::build( 'SDContext', array( 'apiClient' => $apiClient ) );
		$this->APIClient = $apiClient;
	}

	/**
	 * @param int $id
	 * @param int $elementDepth
	 * @return SDElement
	 */
	public function getSDElementById($id, $elementDepth = 0) {
		try {
			$element = $this->APIClient->getObject( $id );
		}
		catch( WikiaException $exception ) {
			return null;
		}
		return $this->getSDElement( $element, $elementDepth );
	}

	public function getSDElementByURL($url, $elementDepth = 0) {
		$element = $this->APIClient->getObjectByURL($url);
		return $this->getSDElement( $element, $elementDepth );
	}

	public function getSDElementByTypeAndName($type, $name, $elementDepth = 0) {
		try {
			$element = $this->APIClient->getObjectByTypeAndName($type, $name);
		}
		catch( WikiaException $exception ) {
			return null;
		}
		return $this->getSDElement( $element, $elementDepth );
	}

	/**
	 * fetch all objects of given type from SDS
	 * @param $type
	 * @return array
	 */
	public function getCollectionByType( $type, $extraFields=array() ) {
		return $this->APIClient->getCollection( $type, $extraFields );
	}

	public function updateSDElement(SDElement $element, array $params) {
		$element->update($params);
		return $this->APIClient->saveObject($element->getId(), $element->toSDSJson());
	}

	private function getSDElement(stdClass $element, $elementDepth = 0) {
		$template = $this->APIClient->getTemplate( $element->type );

		$SDElement = F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => $element, 'depth' => $elementDepth ), 'newFromTemplate');

		return $SDElement;
	}

	public function onParserFirstCallInitParserFunctionHook( Parser &$parser ) {
		$parser->setFunctionHook('data', array( $this, 'dataParserFunction') );
		return true;
	}

	public function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'data', array( $this, 'dataParserHook' ) );
		return true;
	}

	public function onBeforeInternalParse( Parser &$parser ) {
		$parser->setHook( 'data', array( $this, 'dataParserHook' ) );
		return true;
	}

	public function dataParserFunction( $parser, $param1='', $param2='' ) {
		return $this->dataParserHook( $param1, null, $parser );
	}

	public function dataParserHook( $input, $args, Parser $parser, PPFrame $frame = null ) {
		$result = '';
		if ( !empty( $frame ) ) {
			$input = $parser->recursiveTagParse($input, $frame);
		}
		$inputData = $this->parseHookInput($input);

		if( isset($inputData['hash']) ) {
			$SDElement = $this->getSDElementById($inputData['hash']);
		}
		else {
			$SDElement = $this->getSDElementByTypeAndName($inputData['type'], $inputData['name']);
		}

		if($SDElement instanceof SDElement) {
			$currentElement = $SDElement;
			do {
				$propertyName = array_shift( $inputData['propertyChain'] );
				$valueIndex = null;

				if(empty($propertyName)) {
					break;
				}

				$matches = array();
				preg_match('/([a-z,0-9,:,_]{1,})\[(\d{1,})\]/i', $propertyName, $matches);
				if(count($matches) == 3) {
					$propertyName = $matches[1];
					$valueIndex = $matches[2];
				}

				$property = $currentElement->getProperty( $propertyName );
				if($property instanceof SDElement) {
					$currentElement = $property;
				}
				elseif($property instanceof SDElementProperty ) {
					if(!count($inputData['propertyChain']) && is_null($valueIndex)) {
						// last element in chain, try to render it
						$result = $property->render();
						if($result !== false) {
							$currentElement = null;
							break;
						}
					}

					$result = $property->getValue();
					if ($property->isCollection()) {
						$result =  $result[!is_null($valueIndex) ? $valueIndex : 0];
					}

					if(is_object($result) && ($result->object instanceof SDElement)) {
						$currentElement = $result->object;
					}
					elseif(!empty($result)) {
						$currentElement = null;
						$renderedResult = $property->render();
						if($renderedResult !== false) {
							$result = $renderedResult;
						}
					}
					else {
						$result = "Unknown value: " . $propertyName . ( !empty($valueIndex) ? "[$valueIndex]" : "" );
						$currentElement = null;
					}
				}
				else {
					$result = "Unknown property: " . $propertyName;
					$currentElement = null;
				}
			}
			while( $currentElement instanceof SDElement );

			if($currentElement instanceof SDElement) {
				$result = $currentElement->render();
			}
		}
		else {
			if(isset( $inputData['hash'] )) {
				$result = "Unknown element:" . ( $inputData['hash'] );
			}
			else {
				$result = "Unknown element: " . ( $inputData['type'] . '/' . $inputData['name'] );
			}
		}
		return trim($result);
	}

	private function parseHookInput( $input ) {
		$inputParts = explode( '/', $input );
		if( count( $inputParts ) >= 2 ) {
			if( strpos( $inputParts[0], '#') === 0 ) {
				$object['hash'] = substr( $inputParts[0], 1 );
				$object['propertyChain'] = array_slice( $inputParts, 1, count($inputParts) );
			}
			else {
				$object['type'] = $inputParts[0];
				$object['name'] = $inputParts[1];
				$object['propertyChain'] = array_slice( $inputParts, 2, count($inputParts) );
			}
		}

		return $object;
	}
}
