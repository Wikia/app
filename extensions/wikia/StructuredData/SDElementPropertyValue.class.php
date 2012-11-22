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

	public function getValue() {
		if ( is_object( $this->value ) && ( !isset($this->value->object) ) ) {
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
			return array( array('renderingSubject'=>$value->object, 'rendererName' => 'sdelement') );
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

}
