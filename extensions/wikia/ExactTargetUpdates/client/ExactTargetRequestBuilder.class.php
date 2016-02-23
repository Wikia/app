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

	public static function getDeleteBuilder() {
		return new DeleteRequestBuilder();
	}

	public static function getCreateBuilder() {
		return new CreateRequestBuilder();
	}

	public static function getRetrieveBuilder() {
		return new RetrieveRequestBuilder();
	}
}
