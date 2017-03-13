<?php

class TextField extends InputField
{
	const TYPE = 'text';

	/**
	 * Get field type
	 *
	 * @return string
	 */
	protected function getType() {
		return self::TYPE;
	}
}
