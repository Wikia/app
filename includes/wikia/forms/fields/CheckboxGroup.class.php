<?php

class CheckboxGroup extends CollectionField
{
	const TYPE = 'checkbox';

	protected function getType() {
		return static::TYPE;
	}
}
