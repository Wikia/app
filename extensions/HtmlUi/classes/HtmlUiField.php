<?php

abstract class HtmlUiField implements HtmlUiFormElement {
	
	/* Protected Members */
	
	protected $id;
	
	/* Protected Methods */
	
	protected function getDefaultOptions() {
		return array();
	}
	
	/* Methods */
	
	public function getId() {
		return $this->id;
	}
	
	public function setId( $id ) {
		return $this->id = $id;
	}
	
	abstract public function render();
	abstract public function getValue();
	abstract public function setValue( $value );
}
