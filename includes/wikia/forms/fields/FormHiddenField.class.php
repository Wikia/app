<?php

class FormHiddenField extends FormInputField
{
	const TYPE = 'hidden';

	protected function getType() {
		return self::TYPE;
	}
}
