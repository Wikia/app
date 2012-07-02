<?php

class HtmlUiFormElementCollection {
	
	/* Abstract Protected Methods */
	
	protected function getDefaultOptions() {
		return array();
	}
	
	/* Protected Members */
	
	protected $options;
	protected $elements;
	
	/* Methods */
	
	public function __construct( array $elements = array(), $options = array() ) {
		$this->addElements( $elements );
		$this->options = array_merge( $this->getDefaultOptions(), $options );
	}
	
	public function addElement( HtmlUiFormElement $element ) {
		$this->elements[] = $element;
	}
	
	public function addElements( array $elements ) {
		foreach ( $elements as $element ) {
			$this->addElement( $element );
		}
	}
	
	public function removeElement( HtmlUiFormElement $element ) {
		$index = array_search( $element, $this->elements, true );
		if ( $index !== false ) {
			array_splice( $this->elements, $index, 1 );
		}
	}
	
	public function getOption( $option ) {
		return isset( $this->options[$option] ) ? $this->options[$option] : null;
	}
	
	public function setOption( $option, $value ) {
		return isset( $this->options[$option] ) ? $this->options[$option] = $value : null;
	}
}
