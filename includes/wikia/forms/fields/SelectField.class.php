<?php

class SelectField extends BaseField
{
	/**
	 * @see BaseField::render()
	 */
	public function render($htmlAttributes = [], $index = null) {
		$data = [];

		$choices = $this->getChoices();
		$data[self::PROPERTY_CHOICES] = !empty($choices) ? $choices : [];

		return $this->renderInternal(__CLASS__, $htmlAttributes, $data, $index);
	}
}
