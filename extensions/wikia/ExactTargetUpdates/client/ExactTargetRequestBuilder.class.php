<?php
namespace Wikia\ExactTarget;

use Wikia\ExactTarget\Builders\BaseRequestBuilder;
use Wikia\ExactTarget\Builders\CreateRequestBuilder;
use Wikia\ExactTarget\Builders\DeleteRequestBuilder;
use Wikia\ExactTarget\Builders\RetrieveRequestBuilder;
use Wikia\ExactTarget\Builders\UpdateRequestBuilder;

class ExactTargetRequestBuilder {

	private function __construct() {
	}

	public static function getUpdateBuilder() {
		return new UpdateRequestBuilder();
	}

	public static function getUserGroupDeleteBuilder() {
		return new DeleteRequestBuilder( BaseRequestBuilder::GROUP_TYPE );
	}

	public static function getSubscriberDeleteBuilder() {
		return new DeleteRequestBuilder( BaseRequestBuilder::SUBSCRIBER_TYPE );
	}

	public static function getUserDeleteBuilder() {
		return new DeleteRequestBuilder( BaseRequestBuilder::USER_TYPE );
	}

	public static function getPropertiesDeleteBuilder() {
		return new DeleteRequestBuilder( BaseRequestBuilder::PROPERTIES_TYPE );
	}

	public static function getSubscriberCreateBuilder() {
		return new CreateRequestBuilder( BaseRequestBuilder::SUBSCRIBER_TYPE );
	}

	public static function getUserGroupCreateBuilder() {
		return new CreateRequestBuilder( BaseRequestBuilder::GROUP_TYPE );
	}

	public static function getRetrieveBuilder() {
		return new RetrieveRequestBuilder();
	}
}
