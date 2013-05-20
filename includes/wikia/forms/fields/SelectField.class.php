<?php

class SelectField extends BaseField
{
	public function __construct($options) {
		parent::__construct($options);

		if( isset($options['choices']) ) {
			$this->setProperty(self::PROPERTY_CHOICES, $options['choices']);
		}
	}

	public function render($htmlAttributes = [], $index = null) {
		$data = [];

		$choices = $this->getChoices();
		$data[self::PROPERTY_CHOICES] = !empty($choices) ? $choices : [];

		return $this->renderInternal(__CLASS__, $htmlAttributes, $data, $index);
	}
}
