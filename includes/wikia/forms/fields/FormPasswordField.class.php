<?php

class FormPasswordField extends FormInputField
{
	const TYPE = 'password';

	protected function getType() {
		return self::TYPE;
	}
}
