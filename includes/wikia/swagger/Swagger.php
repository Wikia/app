<?php

class Swagger {
	protected $filepath;
	protected $registry;
	protected $defaultApiVersion;
	protected $defaultSwaggerVersion;
	protected $defaultBasePath;
	public $models;

	public function __construct($filepath) {
		$this->filepath = $filepath;

		$raw = json_decode(file_get_contents($this->filepath));
		$this->models = $this->parseDefinitions($raw->definitions);
		$this->registry = $this->parsePaths($raw->paths);
		$this->defaultSwaggerVersion = $raw->swagger;
		$this->defaultApiVersion = $raw->info->version;
		$this->defaultBasePath = "{$raw->schemes[0]}://{$raw->host}{$raw->basePath}";
	}

	public function getRegistry() {
		return $this->registry;
	}

	public function getDefaultApiVersion() {
		return $this->defaultApiVersion;
	}

	public function getDefaultSwaggerVersion() {
		return $this->defaultSwaggerVersion;
	}

	public function getDefaultBasePath() {
		return $this->defaultBasePath;
	}

	public function getResource($resourceName) {
		if (!isset($this->registry[$resourceName])) {
			return false;
		}

		$resource = $this->registry[$resourceName];
		return self::export($resource);
	}

	private function parseDefinitions($defs) {
		$models = [];

		foreach ($defs as $name => $def) {
			$models[$name] = new SwaggerModel($def);
		}

		return $models;
	}

	private function parsePaths($paths) {
		$registry = [];

		foreach ($paths as $path => $operations) {
			$registryKey = SwaggerResource::parseResourcePath($path);

			if (!isset($registry[$registryKey])) {
				$registry[$registryKey] = new SwaggerResource($path);
			}

			$registry[$registryKey]->addOperations($this, $path, $operations);
		}

		return $registry;
	}

	private static function export($data) {
		if (is_object($data)) {
			if (method_exists($data, 'jsonSerialize')) {
				$data = $data->jsonSerialize();
			} else {
				$data = get_object_vars($data);
			}
		}
		if (is_array($data) === false) {
			return $data;
		}
		$output = array();
		foreach ($data as $key => $value) {
			$output[$key] = self::export($value);
		}
		return $output;
	}
}
