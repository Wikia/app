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

	public static function getEditsUpdateBuilder() {
		return new UpdateRequestBuilder( BaseRequestBuilder::EDITS_TYPE );
	}

	public static function getUserUpdateBuilder() {
		return new UpdateRequestBuilder( BaseRequestBuilder::USER_TYPE );
	}

	public static function getPropertiesUpdateBuilder() {
		return new UpdateRequestBuilder( BaseRequestBuilder::PROPERTIES_TYPE );
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

	public static function getWikiUpdateBuilder() {
		return new UpdateRequestBuilder( BaseRequestBuilder::WIKI_TYPE );
	}

	public static function getWikiDeleteBuilder() {
		return new DeleteRequestBuilder( BaseRequestBuilder::WIKI_TYPE );
	}

	public static function getWikiCategoriesMappingUpdateBuilder() {
		return new UpdateRequestBuilder( BaseRequestBuilder::WIKI_CAT_TYPE );
	}

	public static function getWikiCategoriesMappingDeleteBuilder() {
		return new DeleteRequestBuilder( BaseRequestBuilder::WIKI_CAT_TYPE );
	}

	public static function getRetrieveBuilder() {
		return new RetrieveRequestBuilder();
	}
}
