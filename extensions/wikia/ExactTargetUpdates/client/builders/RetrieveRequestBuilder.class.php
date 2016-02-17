<?php

namespace Wikia\ExactTarget\Builders;

class RetrieveRequestBuilder extends BaseRequestBuilder {

	private $filterProperty;
	private $filterValues;
	private $properties;

	const DATA_EXTENSION_OBJECT_USER_TYPE = 'DataExtensionObject[user]';
	const SIMPLE_FILTER_PART = 'SimpleFilterPart';

	public function build() {
		$retrieveRequest = $this->wrapRetrieveRequest();
		$retrieveRequest->Filter = $this->wrapToSoapVar( $this->wrapSimpleFilterPart(), self::SIMPLE_FILTER_PART );
		$retrieveRequest->Options = null;

		return $retrieveRequest;
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

	/**
	 * Returns a new RetrieveRequest object from prepared params
	 * @return ExactTarget_RetrieveRequest  An ExactTarget's request object
	 */
	public function wrapRetrieveRequest() {
		$retrieveRequest = new \ExactTarget_RetrieveRequest();
		$retrieveRequest->ObjectType = self::DATA_EXTENSION_OBJECT_USER_TYPE;
		$retrieveRequest->Properties = $this->properties;
		return $retrieveRequest;
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
}
