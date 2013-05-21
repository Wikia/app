<?php

class SubmitButton extends BaseField
{
	const SUBMIT_DEFAULT_VALUE = 'Send';

	public function __construct($options = []) {
		$this->setValue(isset($options['value']) ? $options['value'] : self::SUBMIT_DEFAULT_VALUE);
		$this->setProperty(self::PROPERTY_ERROR_MESSAGE, null);
		unset($options['label']);

		parent::__construct($options);
	}
}
