<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\ContributionApi;
use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class UserIdentityBoxDiscussion {

	const DISCUSSION_SERVICE_NAME = 'discussion';
	const TIMEOUT = 5;

	private $userId = null;
	private $discussionActive = false;
	private $discussionPostsCount = 0;
	private $discussionAllPostsByUserLink = '';

	function __construct($user) {
		$this->userId = $user->getId();
	}

	public function isDiscussionActive() {
		return $this->discussionActive;
	}

	public function getDiscussionPostsCount() {
		return $this->discussionPostsCount;
	}

	public function getDiscussionAllPostsByUserLink() {
		return $this->discussionAllPostsByUserLink;
	}

	public function fetchDiscussionPostsNumber() {
		$siteId = F::app()->wg->CityId;

		$this->discussionActive = $this->checkDiscussionActive($siteId);
		if ( $this->discussionActive ) {
			$this->discussionPostsCount = $this->fetchDiscussionPostsCount($siteId);
			$this->discussionAllPostsByUserLink = "/d/u/{$this->userId}";
		}
	}

	private function checkDiscussionActive($siteId) {
		try {
			$this->getDiscussionSitesApi()->getSite( $siteId );
			return true;
		} catch ( ApiException $e ) {
			Wikia\Logger\WikiaLogger::instance()->debug( 'Getting site caused an error',
				[
					'siteId' => $siteId,
					'error' => $e->getMessage(),
				] );
		}

		return false;
	}

	private function getDiscussionSitesApi() {
		return $this->getDiscussionApi(SitesApi::class);
	}

	private function getDiscussionApi($apiClass) {
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		$api = $apiProvider->getApi(self::DISCUSSION_SERVICE_NAME, $apiClass);
		$api->getApiClient()->getConfig()->setCurlTimeout(self::TIMEOUT);

		return $api;
	}

	private function fetchDiscussionPostsCount($siteId) {
		$postCount = 0;

		try {
			$postCount = $this->getDiscussionContributionApi()->getPosts($siteId, $this->userId)['post_count'];
		} catch ( ApiException $e ) {
			Wikia\Logger\WikiaLogger::instance()->debug( 'Getting posts caused an error',
				[
					'siteId' => $siteId,
					'userId' => $this->userId,
					'error' => $e->getMessage()
				] );
		}

		return $postCount;
	}

	private function getDiscussionContributionApi() {
		return $this->getDiscussionApi(ContributionApi::class);
	}
}