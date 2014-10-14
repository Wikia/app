<?php

class PasswordField extends InputField
{
	const TYPE = 'password';

	/**
	 * Get field type
	 *
	 * @return string
	 */
	protected function getType() {
		return self::TYPE;
	}
}
