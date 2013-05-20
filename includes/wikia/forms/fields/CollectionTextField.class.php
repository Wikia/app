<?php

class CollectionTextField extends CollectionField
{
	const TYPE = 'text';

	protected function getType() {
		return static::TYPE;
	}
}