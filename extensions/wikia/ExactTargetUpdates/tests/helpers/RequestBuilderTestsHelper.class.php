<?php

class RequestBuilderTestsHelper {

	public static function prepareApiProperty( $name, $value ) {
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = $name;
		$apiProperty->Value = $value;
		return $apiProperty;
	}

	public static function prepareSubscriber( $email, $createMode = false ) {
		$oSubscriber = new \ExactTarget_Subscriber();
		$oSubscriber->SubscriberKey = $email;
		if ( $createMode ) {
			$oSubscriber->EmailAddress = $email;
		}

		return [ $oSubscriber ];
	}

}
