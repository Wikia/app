<?php

class HiddenField extends InputField
{
	const TYPE = 'hidden';

	/**
	 * Get field type
	 *
	 * @return string
	 */
	protected function getType() {
		return self::TYPE;
	}

	/**
	 * @see BaseField::renderRow()
	 */
	public function renderRow($htmlAttributes = [], $index = null) {
		return $this->render($htmlAttributes, $index);
	}
}
