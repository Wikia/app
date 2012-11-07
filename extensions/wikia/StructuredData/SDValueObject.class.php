<?php
/**
 * @author ADi
 */
class SDValueObject extends SDRenderableObject {
	/**
	 * @var SDObject
	 */
	protected $object = null;
	protected $value = null;

	public function __construct( SDObject $object, $value ) {
		$this->object = $object;
		$this->value = $value;
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}

	/**
	 * @param SDObject $object
	 */
	public function setObject($object) {
		$this->object = $object;
	}

	/**
	 * @return SDObject
	 */
	public function getObject() {
		return $this->object;
	}

	public function getRendererNames() {
		return array( 'value_default' );
	}

	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$renderedContent = parent::render( $context );
		return ( $renderedContent !== false ) ? $renderedContent : $this->getValue();
	}

}
