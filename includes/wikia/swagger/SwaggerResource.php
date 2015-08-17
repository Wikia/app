<?php

class SwaggerResource {
	public $context = "";
	public $apiVersion;
	public $swaggerVersion;
	public $resourcePath;
	public $apis;
	public $models;

	public function __construct($path) {
		$this->resourcePath = self::parseResourcePath($path);
		$this->apis = [];
		$this->models = [];
	}

	public function getResourcePath() {
		return $this->resourcePath;
	}

	public function getApis() {
		return $this->apis;
	}

	public function getApiVersion() {
		return $this->apiVersion;
	}

	public function getSwaggerVersion() {
		return $this->swaggerVersion;
	}

	public function addOperations(Swagger $swagger, $path, $operations) {
		$api = new SwaggerApi($path, $operations);

		foreach ($api->operations as $operation) {
			/** @var SwaggerOperation $operation */
			if (isset($operation->responseClass)) {
				$this->addModel($swagger, $operation->responseClass);
			}
		}

		$this->apis[] = $api;
	}

	private function addModel(Swagger $swagger, $modelClass) {
		if (!isset($this->models[$modelClass]) && isset($swagger->models[$modelClass])) {
			/** @var SwaggerModel $model */
			$model = $swagger->models[$modelClass];
			$this->models[$modelClass] = $model;
			foreach ($model->properties as $property) {
				/** @var SwaggerModelProperty $property */
				if (!SwaggerModelProperty::isPrimitiveType($property->type)) {
					$this->addModel($swagger, $property->type);
				} elseif ($property->type == SwaggerModelProperty::TYPE_ARRAY && isset($property->items->type) && !SwaggerModelProperty::isPrimitiveType($property->items->type)) {
					$this->addModel($swagger, $property->items->type);
				}
			}
		}
	}

	public static function parseResourcePath($path) {
		if (preg_match('/^\/([A-Za-z]+)/', $path, $matches)) {
			return $matches[1];
		}

		return null;
	}
}