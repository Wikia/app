<?php
class SwaggerOperation {
	public $context = "";
	public $httpMethod;
	public $summary;
	public $description;
	public $nickname;
	public $responseClass;
	public $parameters;
	public $errorResponses;
	public $notes;
	public $deprecated;

	public function __construct($method, $operation) {
		$this->operation = $operation;

		$this->httpMethod = strtoupper($method);
		$this->summary = $operation->summary;
		$this->description = $operation->description;
		$this->nickname = $operation->operationId;
		$this->responseClass = $this->parseResponseClass($operation);
		$this->parameters = $this->parseParameters($operation);
		$this->errorResponses = $this->parseErrorResponses($operation);
	}

	private function parseResponseClass($operation) {
		if (isset($operation->responses->{"200"}->schema->{'$ref'})) {
			return $operation->responses->{"200"}->schema->{'$ref'};
		}

		return null;
	}

	private function parseParameters($operation) {
		$parameters = [];

		if (isset($operation->parameters)) {
			foreach ($operation->parameters as $parameter) {
				$parameters[] = new SwaggerParameter($parameter);
			}
		}

		return $parameters;
	}

	private function parseErrorResponses($operation) {
		$responses = [];

		foreach ($operation->responses as $code => $response) {
			if ($code != 200) {
				$responses[] = new SwaggerErrorResponse($code, $response);
			}
		}

		return $responses;
	}
}