<?php
namespace Wikia\ExactTarget;

use Wikia\ExactTarget\Builders\CreateRequestBuilder;
use Wikia\ExactTarget\Builders\DeleteRequestBuilder;
use Wikia\ExactTarget\Builders\RetrieveRequestBuilder;
use Wikia\ExactTarget\Builders\UpdateRequestBuilder;

class ExactTargetRequestBuilder {

	private function __construct() {
	}

	public static function createUpdate() {
		return new UpdateRequestBuilder();
	}

	public static function createDelete() {
		return new DeleteRequestBuilder();
	}

	public static function createCreate() {
		return new CreateRequestBuilder();
	}

	public static function createRetrieve() {
		return new RetrieveRequestBuilder();
	}
}
