<?php
class SwaggerModel {
	public $id;
	public $description;
	public $properties;

	public function __construct($model) {
		$this->id = $model->id;
		$this->properties = $this->parseProperties($model);
		$this->description = $model->description ?: null;
	}

	private function parseProperties($model) {
		$properties = [];
		$required = $model->required ?: [];

		foreach ($model->properties as $name => $property) {
			$properties[$name] = new SwaggerModelProperty($name, $property, in_array($name, $required));
		}

		return $properties;
	}
}
