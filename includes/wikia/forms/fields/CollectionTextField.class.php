<?php

class CollectionTextField extends CollectionField
{
	const TYPE = 'text';

	/**
	 * Get field type
	 *
	 * @return string
	 */
	protected function getType() {
		return static::TYPE;
	}
}