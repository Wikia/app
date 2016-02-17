<?php

namespace Wikia\ExactTarget\Builders;

class CreateRequestBuilder extends BaseRequestBuilder {

	public function build() {
		$subscriber = $this->prepareSubscriber( $this->email, $this->email );
		$aSoapVars = $this->prepareSoapVars( [ $subscriber ], self::SUBSCRIBER_OBJECT_TYPE );

		$oRequest = new \ExactTarget_CreateRequest();
		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;

		return $oRequest;
	}

}
