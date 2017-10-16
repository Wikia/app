<?php
class SwaggerParameter {
	public $context = "";
	public $name;
	public $description;
	public $allowMultiple = false;
	public $dataType;
	public $paramType;
	public $required = false;
	public $allowableValues;
	public $defaultValue;

	public function __construct($param) {
		$this->parseParam($param);
	}

	private function parseParam($param) {
		$this->paramType = $param->in;
		$this->description = $param->description;
		$this->dataType = $param->type;
		$this->name = $param->name;

		if (isset($param->required)) {
			$this->required = $param->required;
		}

		if (isset($param->default)) {
			$this->defaultValue = $param->default;
		}
	}
}
