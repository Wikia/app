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
		$element = $this->APIClient->getObject($id);
		return $this->getSDElement( $element, $elementDepth );
	}

	public function getSDElementByURL($url, $elementDepth = 0) {
		$element = $this->APIClient->getObjectByURL($url);
		return $this->getSDElement( $element, $elementDepth );
	}

	public function getSDElementByTypeAndName($type, $name, $elementDepth = 0) {
		$element = $this->APIClient->getObjectByTypeAndName($type, $name);
		return $this->getSDElement( $element, $elementDepth );
	}

	private function getSDElement(stdClass $element, $elementDepth = 0) {
		$template = $this->APIClient->getTemplate( $element->type );

		$SDElement = F::build( 'SDElement', array( 'template' => $template, 'context' => $this->context, 'data' => $element, 'depth' => $elementDepth ), 'newFromTemplate');

		return $SDElement;
	}

	public function onParserFirstCallInit( Parser &$parser ) {
		$parser->setHook( 'data', array( $this, 'dataParserHook' ) );
		return true;
	}

	public function dataParserHook( $input, $args, $parser ) {
		$result = '';
		$inputData = $this->parseHookInput($input);

		if( isset($inputData['hash']) ) {
			$SDElement = $this->getSDElementById($inputData['hash']);
		}
		else {
			// @todo hack! :-) remove when API will be working again..
			switch( $inputData['url'] ) {
				case 'callofduty:Weapon/M16':
					$SDElement = $this->getSDElementById('50258c6fac50ed470f00000c');
					break;
				case 'callofduty:Character/Dimitri_Petrenko':
					$SDElement = $this->getSDElementById('50258490ac50ed479a000005');
					break;
				default:
					$SDElement = $this->getSDElementByURL($inputData['url']);
			}
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

					$result = $property->getValue( !is_null($valueIndex) ? $valueIndex : 0 );

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
		return $result;
	}

	private function parseHookInput( $input ) {
		$inputParts = explode( '/', $input );
		if( count( $inputParts ) >= 2 ) {
			if( strpos( $inputParts[0], '#') === 0 ) {
				$object['hash'] = substr( $inputParts[0], 1 );
				$object['propertyChain'] = array_slice( $inputParts, 1, count($inputParts) );
			}
			else {
				$object['url'] = $inputParts[0] . '/' . $inputParts[1];
				$object['propertyChain'] = array_slice( $inputParts, 2, count($inputParts) );
			}
		}

		return $object;
	}
}
