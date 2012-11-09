<?php
/**
 * @author ADi
 */
class SDValueObject extends SDRenderableObject {
	/**
	 * @var SDElementPropertyType
	 */
	protected $type = null;
	protected $value = null;

	public function __construct( SDElementPropertyType $type, $value ) {
		$this->type = $type;
		$this->value = $value;
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
		return array( 'value_default' );
	}

	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$renderedContent = parent::render( $context );
		return ( $renderedContent !== false ) ? $renderedContent : $this->getValue();
	}

}
