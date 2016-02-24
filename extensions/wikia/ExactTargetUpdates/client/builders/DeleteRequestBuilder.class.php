<?php
namespace Wikia\ExactTarget\Builders;

class DeleteRequestBuilder extends BaseRequestBuilder {
	protected static $supportedTypes = [
		self::GROUP_TYPE, self::USER_TYPE, self::SUBSCRIBER_TYPE, self::PROPERTIES_TYPE ];

	public function build() {
		$soapType = self::DATA_EXTENSION_OBJECT_TYPE;

		if ( $this->type === self::GROUP_TYPE ) {
			$objects = [ $this->prepareDataObject( self::CUSTOMER_KEY_USER_GROUPS,
				[ 'ug_user' => $this->userId, 'ug_group' => $this->group ] ) ];
		} elseif ( $this->type === self::SUBSCRIBER_TYPE ) {
			$objects = [ $this->prepareSubscriber( $this->email ) ];
			$soapType = self::SUBSCRIBER_OBJECT_TYPE;
		} elseif ( $this->type === self::USER_TYPE ) {
			$objects = [ $this->prepareDataObject( self::CUSTOMER_KEY_USER, [ 'user_id' => $this->userId ] ) ];
		} elseif ( $this->type === self::PROPERTIES_TYPE ) {
			$objects = [ ];
			foreach ( $this->properties as $property ) {
				$objects[] = $this->prepareDataObject( self::CUSTOMER_KEY_USER_PROPERTIES,
					[ 'up_user' => $this->userId, 'up_property' => $property ] );
			}
		} else {
			$objects = [ ];
		}
		$aSoapVars = $this->prepareSoapVars( $objects, $soapType );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}
}
