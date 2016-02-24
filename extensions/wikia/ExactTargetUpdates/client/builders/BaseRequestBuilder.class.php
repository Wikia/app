<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\Util\Assert;

class BaseRequestBuilder {
	const EXACT_TARGET_API_URL = 'http://exacttarget.com/wsdl/partnerAPI';

	const SUBSCRIBER_OBJECT_TYPE = 'Subscriber';
	const DATA_EXTENSION_OBJECT_TYPE = 'DataExtensionObject';

	const CUSTOMER_KEY_USER = 'user';
	const CUSTOMER_KEY_USER_PROPERTIES = 'user_properties';
	const CUSTOMER_KEY_USER_GROUPS = 'user_groups';

	const GROUP_TYPE = 'group';
	const USER_TYPE = 'user';
	const SUBSCRIBER_TYPE = 'subscriber';
	const PROPERTIES_TYPE = 'properties';

	protected $email;
	protected $userId;
	protected $properties;
	protected $group;
	protected $type;
	// empty means accept all types
	protected static $supportedTypes = [ ];

	public function __construct( $type = '' ) {
		Assert::true( empty( static::$supportedTypes ) || in_array( $type, static::$supportedTypes ),
			'Not supported request type' );
		$this->type = $type;
	}

	public function withUserEmail( $email ) {
		$this->email = $email;
		return $this;
	}

	public function withUserId( $userId ) {
		$this->userId = $userId;
		return $this;
	}

	public function withProperties( $properties ) {
		$this->properties = $properties;
		return $this;
	}

	public function withGroup( $group ) {
		$this->group = $group;
		return $this;
	}

	/**
	 * Prepares an array of SoapVar objects by looping over an array of objects
	 *
	 * @param $aObjects
	 * @return array
	 */
	protected function prepareSoapVars( $aObjects, $type ) {
		$aSoapVars = [ ];
		foreach ( $aObjects as $object ) {
			$aSoapVars[] = $this->wrapToSoapVar( $object, $type );
		}
		return $aSoapVars;
	}

	/**
	 * Wraps an ExactTarget object to a SoapVar
	 *
	 * @param $oObject
	 * @param $sObjectType
	 * @return \SoapVar
	 *
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	protected function wrapToSoapVar( $oObject, $sObjectType ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $sObjectType, self::EXACT_TARGET_API_URL );
	}

	protected function prepareSubscriber( $key, $email = '' ) {
		$subscriber = new \ExactTarget_Subscriber();
		$subscriber->SubscriberKey = $key;
		if ( !empty( $email ) ) {
			$subscriber->EmailAddress = $email;
		}

		return $subscriber;
	}

	protected function prepareDataObject( $customerKey, $keys, $properties = null ) {
		$obj = new \ExactTarget_DataExtensionObject();
		$obj->CustomerKey = $customerKey;
		if ( !empty( $keys ) ) {
			$obj->Keys = $this->wrapApiProperties( $keys );
		}
		// accept empty array as valid properties list
		if ( isset( $properties ) ) {
			$obj->Properties = $this->wrapApiProperties( $properties );
		}

		return $obj;
	}

	protected function wrapApiProperties( $properties ) {
		$result = [ ];
		foreach ( $properties as $key => $value ) {
			$result[] = $this->wrapApiProperty( $key, $value );
		}

		return $result;
	}

	/**
	 * Returns ExactTarget_APIProperty object
	 * This object can be used as ExactTarget_DataExtensionObject property
	 * It stores key-value pair
	 * @param String $key Property name
	 * @param String $value Propert yvalue
	 * @return \ExactTarget_APIProperty
	 */
	protected function wrapApiProperty( $key, $value ) {
		$apiProperty = new \ExactTarget_APIProperty();
		$apiProperty->Name = $key;
		$apiProperty->Value = $value;
		return $apiProperty;
	}

}
