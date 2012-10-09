<?php
/**
 * @author ADi
 */
class SDElement {
	private $id = 0;
	private static $excludedNames = array(
		'@context',
		'type',
		'id'
	);
	protected $type = null;
	protected $properties = array();


	public function __construct( $type, $id = 0) {
		$this->type = $type;
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}

	public function addProperty(SDElementProperty $property) {
		$this->properties[] = $property;
	}

	public static function newFromTemplate(stdClass $template, stdClass $data = null) {
		if(!empty($data) && isset($data->id)) {
			$elementId = $data->id;
		}
		$element = F::build( 'SDElement', array( $template->type, $elementId ) );


		foreach($template as $propertyName => $propertyValue) {
			// @todo implement
			$propertyType = false;

			if(isset($data->{"$propertyName"})) {
				$propertyValue = $data->{"$propertyName"};
			}

			if(!in_array( $propertyName, self::$excludedNames )) {
				$element->addProperty( F::build( 'SDElementProperty', array( $propertyName, $propertyValue, $propertyType) ) );
			}
		}

		return $element;
	}

	public function toArray() {
		$properties = array();

		foreach($this->properties as $property) {
			$properties[] = $property->toArray();
		}

		return array(
			'id' => $this->getId(),
			'type' => $this->getType(),
			'properties' => $properties,
		);
	}

	public function __toString() {
		return json_encode( $this->toArray() );
	}

}
