<?php
namespace Wikia\ExactTarget\Builders;

class DeleteRequestBuilder extends BaseRequestBuilder {
	public function build() {
		$subscriber = $this->prepareSubscriber( $this->email );
		$aSoapVars = $this->prepareSoapVars( [ $subscriber ], self::SUBSCRIBER_OBJECT_TYPE );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}
}
