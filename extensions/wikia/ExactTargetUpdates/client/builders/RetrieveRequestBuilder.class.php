<?php

namespace Wikia\ExactTarget\Builders;

use Wikia\ExactTarget\ExactTargetApiHelper;
use Wikia\ExactTarget\ExactTargetUserTaskHelper;

class RetrieveRequestBuilder extends BaseRequestBuilder {

	private $filterProperty;
	private $filterValues;
	private $properties;

	public function build() {
		$helper = new ExactTargetUserTaskHelper();
		$apiParams = $helper->prepareUserRetrieveParams( $this->properties, $this->filterProperty, $this->filterValues );

		$callObjectParams = $apiParams[ 'DataExtension' ];
		$simpleFilterParams = $apiParams[ 'SimpleFilterPart' ];

		$apiHelper = new ExactTargetApiHelper();
		$retrieveRequest = $apiHelper->wrapRetrieveRequest( $callObjectParams );
		$simpleFilterPart = $apiHelper->wrapSimpleFilterPart( $simpleFilterParams );
		$retrieveRequest->Filter = $apiHelper->wrapToSoapVar( $simpleFilterPart, 'SimpleFilterPart' );
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

}
