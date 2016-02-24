<?php
namespace Wikia\ExactTarget;

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
		return new DeleteRequestBuilder( DeleteRequestBuilder::DELETE_GROUP_TYPE );
	}

	public static function getSubscriberDeleteBuilder() {
		return new DeleteRequestBuilder( DeleteRequestBuilder::DELETE_SUBSCRIBER_TYPE );
	}

	public static function getUserDeleteBuilder() {
		return new DeleteRequestBuilder( DeleteRequestBuilder::DELETE_USER_TYPE );
	}

	public static function getPropertiesDeleteBuilder() {
		return new DeleteRequestBuilder( DeleteRequestBuilder::DELETE_PROPERTIES_TYPE );
	}

	public static function getCreateBuilder() {
		return new CreateRequestBuilder();
	}

	public static function getRetrieveBuilder() {
		return new RetrieveRequestBuilder();
	}
}
