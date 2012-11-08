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
	protected $range = array();

	public function __construct( SDObject $object, $value, $range = array() ) {
		$this->object = $object;
		$this->value = $value;
		$this->range = $range;
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

	public function setRange($range) {
		$this->range = $range;
	}

	public function getRange() {
		return $this->range;
	}

	public function getRendererNames() {
		return array( 'value_default' );
	}

	public function render( $context = SD_CONTEXT_DEFAULT ) {
		$renderedContent = parent::render( $context );
		return ( $renderedContent !== false ) ? $renderedContent : $this->getValue();
	}

}
