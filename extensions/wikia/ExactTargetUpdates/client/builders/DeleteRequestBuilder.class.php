<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\Util\Assert;

class DeleteRequestBuilder extends BaseRequestBuilder {

	const CUSTOMER_KEY_USER_GROUPS = 'user_groups';
	const DELETE_GROUP_TYPE = 'group';
	const DELETE_USER_TYPE = 'user';
	const DELETE_SUBSCRIBER_TYPE = 'subscriber';
	const DELETE_PROPERTIES_TYPE = 'properties';

	private static $supportedTypes = [
		self::DELETE_GROUP_TYPE, self::DELETE_USER_TYPE, self::DELETE_SUBSCRIBER_TYPE, self::DELETE_PROPERTIES_TYPE ];

	private $type;
	private $group;

	public function __construct( $type ) {
		Assert::true( in_array( $type, self::$supportedTypes ), 'Not supported delete request' );
		$this->type = $type;
	}

	public function withGroup( $group ) {
		$this->group = $group;
		return $this;
	}

	public function build() {
		$objects = [ ];
		$soapType = self::DATA_EXTENSION_OBJECT_TYPE;

		if ( $this->type === self::DELETE_GROUP_TYPE ) {
			$objects = [ $this->prepareDataObject( self::CUSTOMER_KEY_USER_GROUPS,
				[ 'ug_user' => $this->userId, 'ug_group' => $this->group ] ) ];
		} elseif ( $this->type === self::DELETE_SUBSCRIBER_TYPE ) {
			$objects = [ $this->prepareSubscriber( $this->email ) ];
			$soapType = self::SUBSCRIBER_OBJECT_TYPE;
		} elseif ( $this->type === self::DELETE_USER_TYPE ) {
			$objects = [ $this->prepareDataObject( self::CUSTOMER_KEY_USER, [ 'user_id' => $this->userId ] ) ];
		} elseif ( $this->type === self::DELETE_PROPERTIES_TYPE ) {
			$objects = [ ];
			foreach ( $this->properties as $property ) {
				$objects[] = $this->prepareDataObject( self::CUSTOMER_KEY_USER_PROPERTIES,
					[ 'up_user' => $this->userId, 'up_property' => $property ] );
			}
		}
		$aSoapVars = $this->prepareSoapVars( $objects, $soapType );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		return $oDeleteRequest;
	}
}
