<?php

namespace Wikia\ExactTarget\Builders;

class RetrieveRequestBuilder extends BaseRequestBuilder {

	private $filterProperty;
	private $filterValues;
	private $properties;
	private $resource;

	const DATA_EXTENSION_OBJECT_USER_TYPE = 'DataExtensionObject[user]';
	const SIMPLE_FILTER_PART = 'SimpleFilterPart';

	public function build() {
		$retrieveRequest = new \ExactTarget_RetrieveRequest();
		$retrieveRequest->ObjectType = $this->getResource();
		$retrieveRequest->Properties = $this->properties;
		$retrieveRequest->Filter = $this->wrapToSoapVar( $this->wrapSimpleFilterPart(), self::SIMPLE_FILTER_PART );

		$oRetrieveRequestMsg = new \ExactTarget_RetrieveRequestMsg();
		$oRetrieveRequestMsg->RetrieveRequest = $retrieveRequest;

		return $oRetrieveRequestMsg;
	}

	public function withProperties( $properties ) {
		$this->properties = $properties;
		return $this;
	}

	public function withFilterProperty( $filterProperty ) {
		$this->filterProperty = $filterProperty;
		return $this;
	}

	public function withFilterValues( $filterValues ) {
		$this->filterValues = $filterValues;
		return $this;
	}

	public function withResource( $resource ) {
		$this->resource = $resource;
		return $this;
	}

	/**
	 * Returns a new SimpleFilterPart object from given parameters
	 * @return ExactTarget_SimpleFilterPart object
	 */
	public function wrapSimpleFilterPart() {
		$simpleFilterPart = new \ExactTarget_SimpleFilterPart();
		$simpleFilterPart->Value = $this->filterValues;
		$simpleFilterPart->SimpleOperator = $this->getSimpleFilterOperator();
		$simpleFilterPart->Property = $this->filterProperty;
		return $simpleFilterPart;
	}

	/**
	 * @return string
	 */
	private function getSimpleFilterOperator() {
		return count( $this->filterValues ) > 1
			? \ExactTarget_SimpleOperators::IN
			: \ExactTarget_SimpleOperators::equals;
	}

	private function getResource() {
		return "DataExtensionObject[{$this->resource}]";
	}
}
