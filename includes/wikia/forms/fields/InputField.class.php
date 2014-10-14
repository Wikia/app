<?php

abstract class InputField extends BaseField
{
	abstract protected function getType();

	/**
	 * @see BaseField::render()
	 */
	public function render($attributes = [], $index = null) {
		$data = [];
		$data['type'] = $this->getType();
		return $this->renderInternal(__CLASS__, $attributes, $data, $index);
	}

}
