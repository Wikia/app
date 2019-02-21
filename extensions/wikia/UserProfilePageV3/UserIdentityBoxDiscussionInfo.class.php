<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\ContributionApi;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;

class UserIdentityBoxDiscussionInfo {

	const DISCUSSION_SERVICE_NAME = 'discussion';
	const TIMEOUT = 5;

	private $logger = null;
	private $userId = null;
	private $discussionActive = false;
	private $discussionPostsCount = 0;
	private $discussionAllPostsByUserLink = '';

	private function __construct( $user ) {
		$this->logger = WikiaLogger::instance();
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

	private function fetchDiscussionPostsNumber() {
		global $wgEnableDiscussions, $wgScriptPath;

		$this->discussionActive = $wgEnableDiscussions;

		if ( $this->discussionActive ) {
			$this->discussionPostsCount = $this->fetchDiscussionPostsCount();
			$this->discussionAllPostsByUserLink = "$wgScriptPath/d/u/{$this->userId}";
		}
	}

	private function getDiscussionApi( $apiClass ) {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi( self::DISCUSSION_SERVICE_NAME, $apiClass );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}

	private function fetchDiscussionPostsCount() {
		$postCount = 0;
		$siteId = F::app()->wg->CityId;

		try {
			$postCount = $this->getDiscussionContributionApi()->getPosts( $siteId, $this->userId )->getPostCount();
		} catch ( ApiException $e ) {
			$this->logger->debug( 'Getting posts caused an error',
				[
					'siteId' => $siteId,
					'userId' => $this->userId,
					'error' => $e->getMessage()
				] );
		}

		return $postCount;
	}

	/**
	 * @return ContributionApi
	 */
	private function getDiscussionContributionApi(): ContributionApi {
		return $this->getDiscussionApi( ContributionApi::class );
	}

	/**
	 * Creates discussion info for given user.
	 *
	 * @param $user
	 * @return UserIdentityBoxDiscussionInfo
	 */
	public static function createFor( $user ): UserIdentityBoxDiscussionInfo {
		$discussionInfo = new UserIdentityBoxDiscussionInfo( $user );
		$discussionInfo->fetchDiscussionPostsNumber();
		return $discussionInfo;
	}
}
