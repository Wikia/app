<?php

class PasswordField extends InputField
{
	const TYPE = 'password';

	protected function getType() {
		return self::TYPE;
	}
}
