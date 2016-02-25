<?php

namespace Wikia\ExactTarget\Builders;

class CreateRequestBuilder extends BaseRequestBuilder {
	private static $supportedTypes = [ self::GROUP_TYPE, self::SUBSCRIBER_TYPE ];

	public function build() {
		$type = self::DATA_EXTENSION_OBJECT_TYPE;

		if ( $this->type === self::GROUP_TYPE ) {
			$objects = [ $this->prepareDataObject( self::CUSTOMER_KEY_USER_GROUPS,
				[ ], [ 'ug_user' => $this->userId, 'ug_group' => $this->group ] ) ];
		} elseif ( $this->type === self::SUBSCRIBER_TYPE ) {
			$objects = [ $this->prepareSubscriber( $this->email, $this->email ) ];
			$type = self::SUBSCRIBER_OBJECT_TYPE;
		} else {
			$objects = [ ];
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
