<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\ExactTarget\ExactTargetException;
use Wikia\ExactTarget\ResourceEnum as Enum;
use Wikia\Logger\WikiaLogger;

class DeleteRequestBuilder extends BaseRequestBuilder {
	private static $supportedTypes = [
		self::GROUP_TYPE, self::USER_TYPE, self::SUBSCRIBER_TYPE, self::PROPERTIES_TYPE
	];

	public function build() {
		$soapType = self::DATA_EXTENSION_OBJECT_TYPE;

		if ( $this->type === self::GROUP_TYPE ) {
			$objects = [ $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_GROUPS,
				[ Enum::USER_GROUP_USER => $this->userId, Enum::USER_GROUP_GROUP => $this->group ] ) ];
		} elseif ( $this->type === self::SUBSCRIBER_TYPE ) {
			$objects = [ $this->prepareSubscriber( $this->email ) ];
			$soapType = self::SUBSCRIBER_OBJECT_TYPE;
		} elseif ( $this->type === self::USER_TYPE ) {
			$objects = [ $this->prepareDataObject( Enum::CUSTOMER_KEY_USER, [ Enum::USER_ID => $this->userId ] ) ];
		} elseif ( $this->type === self::PROPERTIES_TYPE ) {
			$objects = [ ];
			foreach ( $this->properties as $property ) {
				$objects[] = $this->prepareDataObject( Enum::CUSTOMER_KEY_USER_PROPERTIES,
					[ Enum::USER_PROPERTIES_USER => $this->userId, Enum::USER_PROPERTIES_PROPERTY => $property ] );
			}
		} else {
			$exception = new ExactTargetException();
			WikiaLogger::instance()->error( 'Not supported request type by delete request', [
				'exception' => $exception,
				'type_provided' => $this->type
			] );
			throw $exception;
		}
		$aSoapVars = $this->prepareSoapVars( $objects, $soapType );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}

	protected function getSupportedTypes() {
		return self::$supportedTypes;
	}
}
