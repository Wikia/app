<?php

class SubmitButton extends BaseField
{
	/**
	 * @see BaseField::_construct()
	 */
	public function __construct($options = []) {
		if ( isset($options['value']) ) {
			$this->setValue( $options['value'] );
		}
		parent::__construct($options);
	}

	/**
	 * We don't want labels for submit button
	 *
	 * @see BaseField::renderLabel()
	 *
	 * @return null
	 */
	public function renderLabel() {
		return null;
	}

	/**
	 * We don't want error messages for submit button
	 *
	 * @see BaseField::renderErrorMessage()
	 *
	 * @return null
	 */
	public function renderErrorMessage() {
		return null;
	}
}
