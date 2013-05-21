<?php

class SubmitButton extends BaseField
{

	public function __construct($options = []) {
		if ( isset($options['value']) ) {
			$this->setValue( $options['value'] );
		}
		parent::__construct($options);
	}

	public function renderLabel() {
		return null;
	}

	public function renderErrorMessage() {
		return null;
	}
}
