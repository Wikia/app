<?php
namespace Wikia\ExactTarget\Builders;

class DeleteRequestBuilder extends BaseRequestBuilder {

	const CUSTOMER_KEY_USER_GROUPS = 'user_groups';

	private $group;

	public function withGroup( $group ) {
		$this->group = $group;
		return $this;
	}

	public function build() {
		if ( isset( $this->group ) ) {
			$objects = $this->prepareGroup( $this->userId, $this->group );
			$soapType = self::DATA_EXTENSION_OBJECT_TYPE;
		} else {
			$objects = $this->prepareSubscriber( $this->email );
			$soapType = self::SUBSCRIBER_OBJECT_TYPE;
		}
		$aSoapVars = $this->prepareSoapVars( [ $objects ], $soapType );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}

	private function prepareGroup( $userId, $group ) {
		$obj = new \ExactTarget_DataExtensionObject();
		$obj->CustomerKey = self::CUSTOMER_KEY_USER_GROUPS;
		$obj->Keys = [
			$this->wrapApiProperty( 'ug_user', $userId ),
			$this->wrapApiProperty( 'ug_group', $group ),
		];

		return $obj;
	}
}
