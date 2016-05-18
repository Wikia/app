<?php

namespace Wikia\ExactTarget\Builders;

use Wikia\ExactTarget\ResourceEnum as Enum;

class CreateRequestBuilder extends BaseRequestBuilder {
	private static $supportedTypes = [ self::GROUP_TYPE, self::SUBSCRIBER_TYPE ];

	public function build() {
		$type = self::DATA_EXTENSION_OBJECT_TYPE;

		switch ( $this->type ) {
			case self::GROUP_TYPE:
				$objects = [ $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_GROUPS,
					[ ], [ Enum::USER_GROUP_USER => $this->userId, Enum::USER_GROUP_GROUP => $this->group ] ) ];
				break;
			case self::SUBSCRIBER_TYPE:
				$objects = [ $this->prepareSubscriber( $this->email, $this->email ) ];
				$type = self::SUBSCRIBER_OBJECT_TYPE;
				break;
		}
		$aSoapVars = $this->prepareSoapVars( $objects, $type );

		$oRequest = new \ExactTarget_CreateRequest();
		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;

		return $oRequest;
	}

	protected function getSupportedTypes() {
		return self::$supportedTypes;
	}

}
