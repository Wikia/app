<?php

class HiddenField extends InputField
{
	const TYPE = 'hidden';

	protected function getType() {
		return self::TYPE;
	}
}
