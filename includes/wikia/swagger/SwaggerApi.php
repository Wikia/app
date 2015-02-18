<?php
class SwaggerApi {
	public $context = "";
	public $path;
	public $operations;
	public $description;

	public function __construct($path, $operations) {
		$this->path = $path;
		$this->operations = $this->parseOperations($operations);
	}

	private function parseOperations($operationList) {
		$operations = [];

		foreach ($operationList as $method => $operation) {
			$newOperation = $operations[] = new SwaggerOperation($method, $operation);
			if (!isset($this->description)) {
				if (!empty($newOperation->description)) {
					$this->description = $newOperation->description;
				} elseif (!empty($newOperation->summary)) {
					$this->description = $newOperation->summary;
				}
			}
		}

		return $operations;
	}
}
