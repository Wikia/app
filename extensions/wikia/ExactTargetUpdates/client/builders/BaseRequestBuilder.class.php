<?php
namespace Wikia\ExactTarget\Builders;

use Wikia\Util\Assert;

class BaseRequestBuilder {
	const EXACT_TARGET_API_URL = 'http://exacttarget.com/wsdl/partnerAPI';

	const SUBSCRIBER_OBJECT_TYPE = 'Subscriber';
	const DATA_EXTENSION_OBJECT_TYPE = 'DataExtensionObject';

	const GROUP_TYPE = 'group';
	const USER_TYPE = 'user';
	const SUBSCRIBER_TYPE = 'subscriber';
	const PROPERTIES_TYPE = 'properties';
	const EDITS_TYPE = 'edits';
	const WIKI_CAT_TYPE = 'city_cat';
	const WIKI_TYPE = 'wiki';

	protected $email;
	protected $userId;
	protected $properties;
	protected $group;
	protected $type;
	protected $wikiCategories = [];
	// empty means accept all types
	private static $supportedTypes = [ ];

	public function __construct( $type = '' ) {
		$supported = $this->getSupportedTypes();
		Assert::true( empty( $supported ) || in_array( $type, $supported ),
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

	public function withWikiCategories( $categories ) {
		$this->wikiCategories = $categories;
		return $this;
	}

	/**
	 * Prepares an array of SoapVar objects by looping over an array of objects
	 *
	 * @param $objects
	 * @param string $objectType soap vars types (use const SUBSCRIBER_OBJECT_TYPE|DATA_EXTENSION_OBJECT_TYPE)
	 * @return array
	 */
	protected function prepareSoapVars( $objects, $objectType ) {
		$aSoapVars = [ ];
		foreach ( $objects as $object ) {
			$aSoapVars[] = $this->wrapToSoapVar( $object, $objectType );
		}
		return $aSoapVars;
	}

	/**
	 * Wraps an ExactTarget object to a SoapVar
	 *
	 * @param $object
	 * @param $objectType
	 * @return \SoapVar
	 *
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	protected function wrapToSoapVar( $object, $objectType ) {
		return new \SoapVar( $object, SOAP_ENC_OBJECT, $objectType, self::EXACT_TARGET_API_URL );
	}

	/**
	 * Prepares subscriber object
	 *
	 * @param string $key user email
	 * @param string $subscriberEmail user email
	 * @return \ExactTarget_Subscriber
	 */
	protected function prepareSubscriber( $key, $subscriberEmail = '' ) {
		$subscriber = new \ExactTarget_Subscriber();
		$subscriber->SubscriberKey = $key;
		if ( !empty( $subscriberEmail ) ) {
			$subscriber->EmailAddress = $subscriberEmail;
		}

		return $subscriber;
	}

	/**
	 * General DataExtension object producer
	 *
	 * @param string $customerKey use const here CUSTOMER_KEY_*
	 * @param array $keys
	 * @param null|array $objectProperties
	 * @return \ExactTarget_DataExtensionObject
	 */
	protected function prepareDataObject( $customerKey, $keys, $objectProperties = null ) {
		$obj = new \ExactTarget_DataExtensionObject();
		$obj->CustomerKey = $customerKey;
		if ( !empty( $keys ) ) {
			$obj->Keys = $this->wrapApiProperties( $keys );
		}
		// accept empty array as valid properties list
		if ( isset( $objectProperties ) ) {
			$obj->Properties = $this->wrapApiProperties( $objectProperties );
		}

		return $obj;
	}

	/**
	 * Wraps properties list in api property objects
	 *
	 * @param array $apiProperties
	 * @return array
	 */
	protected function wrapApiProperties( $apiProperties ) {
		$result = [ ];
		foreach ( $apiProperties as $key => $value ) {
			$result[] = $this->wrapApiProperty( $key, $value );
		}

		return $result;
	}

	/**
	 * Returns ExactTarget_APIProperty object
	 * This object can be used as ExactTarget_DataExtensionObject property
	 * It stores key-value pair
	 *
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

	/**
	 * Used to determine if given request type is supported
	 *
	 * @return array
	 */
	protected function getSupportedTypes() {
		return self::$supportedTypes;
	}

}
