<?php

class FormTextField extends FormInputField
{
	const TYPE = 'text';

	protected function getType() {
		return self::TYPE;
	}
}
