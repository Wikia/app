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
		// callofduty:Character/Dimitri_Petrenko/schema:birthDate
		//callofduty:Weapon/M16/callofduty:weaponClass[2]/name

		$result = '';
		$inputData = $this->parseHookInput($input);

		// @todo hack! :-)
		if($inputData['url'] == 'callofduty:Weapon/M16') {
			$SDElement = $this->getSDElementById('50258c6fac50ed470f00000c');
		}
		else {
			$SDElement = $this->getSDElementByURL($inputData['url']);
		}

		if($SDElement instanceof SDElement) {
			$currentElement = $SDElement;
			do {
				$propertyName = array_shift( $inputData['propertyChain'] );
				$property = $currentElement->getProperty( $propertyName );
				if($property instanceof SDElement) {
					$currentElement = $property;
				}
				elseif($property instanceof SDElementProperty ) {
					$result = $property->getValue();
					if(is_object($result) && ($result->object instanceof SDElement)) {
						$currentElement = $result->object;
					}
					else {
						$currentElement = null;
					}
				}
				else {
					$result = 'Unknown property: ' . $propertyName;
					$currentElement = null;
				}
			}
			while( $currentElement instanceof SDElement );
		}
		return $result;
	}

	private function parseHookInput( $input ) {

		$inputParts = explode( '/', $input );
		if( count( $inputParts ) >= 2 ) {
			//$object['type'] = ;
			//$object['name'] = ;
			$object['url'] = $inputParts[0] . '/' . $inputParts[1];
			$object['propertyChain'] = array_slice( $inputParts, 2, count($inputParts) );
		}

		return $object;
	}
}
