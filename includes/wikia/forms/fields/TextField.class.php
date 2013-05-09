<?php

class TextField extends InputField
{
	const TYPE = 'text';

	protected function getType() {
		return self::TYPE;
	}
}
