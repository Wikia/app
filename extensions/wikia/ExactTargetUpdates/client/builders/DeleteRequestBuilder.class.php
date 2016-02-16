<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\ExactTarget\ExactTargetApiHelper;

class DeleteRequestBuilder extends BaseRequestBuilder {
	const SUBSCRIBER_OBJECT_TYPE = 'Subscriber';

	private $email;

	public function withUserEmail( $email ) {
		$this->email = $email;
		return $this;
	}

	public function build() {
		$subscriber = $this->prepareSubscriber( $this->email );
		$aSoapVars = $this->prepareSoapVars( [ $subscriber ], self::SUBSCRIBER_OBJECT_TYPE );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}

	public function prepareSubscriber( $email ) {
		$subscriber = new \ExactTarget_Subscriber();
		$subscriber->SubscriberKey = $email;

		return $subscriber;
	}
}
