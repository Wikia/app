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
		wfProfileIn( __METHOD__ );

		$siteId = F::app()->wg->CityId;

		$this->discussionActive = $this->checkDiscussionActive($siteId);
		if ( $this->discussionActive ) {
			$this->discussionPostsCount = $this->fetchDiscussionPostsCount($siteId);
			$this->discussionAllPostsByUserLink = "/d/u/{$this->userId}";
		}

		wfProfileOut( __METHOD__ );
	}

	private function checkDiscussionActive($siteId) {
		wfProfileIn( __METHOD__ );

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

		wfProfileOut( __METHOD__ );

		return false;
	}

	private function getDiscussionSitesApi() {
		return $this->getDiscussionApi(SitesApi::class);
	}

	private function getDiscussionApi($apiClass) {
		wfProfileIn( __METHOD__ );

		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		$api = $apiProvider->getApi(self::DISCUSSION_SERVICE_NAME, $apiClass);
		$api->getApiClient()->getConfig()->setCurlTimeout(self::TIMEOUT);

		wfProfileOut( __METHOD__ );

		return $api;
	}

	private function fetchDiscussionPostsCount($siteId) {
		wfProfileIn( __METHOD__ );

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

		wfProfileOut( __METHOD__ );

		return $postCount;
	}

	private function getDiscussionContributionApi() {
		return $this->getDiscussionApi(ContributionApi::class);
	}
}