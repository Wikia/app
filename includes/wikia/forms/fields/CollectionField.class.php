<?php

abstract class CollectionField extends InputField
{
	public function getName() {
		return parent::getName() . '[]';
	}

	public function getId($index = null) {
		return parent::getId() . $index;
	}

	public function getValue($index = null) {
		$values = parent::getValue();
		return isset($values[$index]) ? $values[$index] : $values;
	}

	protected function renderInternal($className, $htmlAttributes = [], $data = [], $index) {
		$out = '';
		if (isset($index)) {
			$out .= parent::renderInternal($className, $htmlAttributes, $data);
		} else {
			$values = $this->getValue();
			foreach ($values as $index => $value) {
				$out .= parent::renderInternal($className, $htmlAttributes, $data, $index);
			}
		}
		return $out;
	}
}