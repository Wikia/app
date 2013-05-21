<?php

class HiddenField extends InputField
{
	const TYPE = 'hidden';

	protected function getType() {
		return self::TYPE;
	}

	public function renderRow($htmlAttributes = [], $index = null) {
		return $this->render($htmlAttributes, $index);
	}
}
