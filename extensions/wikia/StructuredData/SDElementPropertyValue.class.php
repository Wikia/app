<?php
/**
 * @author ADi
 */
class SDElementPropertyValue extends SDRenderableObject {
	/**
	 * @var SDElementPropertyType
	 */
	protected $type = null;
	protected $value = null;
	protected $propertyName = null;

	public function __construct( SDElementPropertyType $type, $value, $propertyName ) {
		$this->type = $type;
		$this->value = $value;
		$this->propertyName = $propertyName;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * return the actual value of this property. In case the value is a reference to another
	 * SDElement instance, this method returns an object with id and object attributes
	 * (and object attribute is lazy-loaded, but can be null in case this load fails)
	 */
	public function getValue() {
		if ( is_object( $this->value ) && ( !isset($this->value->object) ) && ( !empty($this->value->id) ) ) {
			$structuredData = F::build( 'StructuredData' );
			try {
				$SDElement = $structuredData->getSDElementById($this->value->id);
				$this->value->object = $SDElement;
			}
			catch(WikiaException $e) {
				$this->value->object = null;
			}

		}
		return $this->value;
	}

	/**
	 * @param \SDElementPropertyType $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @return \SDElementPropertyType
	 */
	public function getType() {
		return $this->type;
	}

	public function getRendererNames() {
		$value = $this->getValue();
		if (is_object($value) && isset($value->object) && ( !is_null($value->object))) {
			$result = array();
			$range = $this->getType()->getRange();
			if ($range) {
				foreach($range->getClasses() as $c) {
					$result[] = array('renderingSubject'=>$value->object, 'rendererName' => 'value_'.$c);
				}
			}
			//$result[] = 'value_'.$this->type->getName();
			$result[] = array('renderingSubject'=>$value->object, 'rendererName' => 'sdelement');
			return $result;
		}
		return array( 'value_'.$this->type->getName(), 'value_default' );
	}

	public function setPropertyName($propertyName) {
		$this->propertyName = $propertyName;
	}

	public function getPropertyName() {
		return $this->propertyName;
	}

	public function render( $context = SD_CONTEXT_DEFAULT, array $params = array() ) {
		$renderedContent = parent::render( $context, $params );
		return ( $renderedContent !== false ) ? $renderedContent : $this->getValue();
	}

	/**
	 * used by toSDSJson to convert a single value
	 * @return string
	 */
	public function convertValueToSDSJson() {
		if ( is_object($this->value) ) {
			$valueObject = new stdClass();
			if(isset($this->value->id)) {
				$valueObject->id = $this->value->id;
			}
			return $valueObject;
		}
		return $this->value;
	}

}
