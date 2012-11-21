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
