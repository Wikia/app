<?php

abstract class InputField extends BaseField
{
	abstract protected function getType();

	public function render($attributes = [], $index = null) {
		$data = [];
		$data['type'] = $this->getType();
		return $this->renderInternal(__CLASS__, $attributes, $data, $index);
	}

}
