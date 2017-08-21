<?php
namespace Wikia\Tasks\Tasks;

/**
 * DismissCommunityMessageTask - asynchronously dismiss the Community Messages notification
 * when an user views Special:WikiActivity
 *
 * @see https://wikia-inc.atlassian.net/browse/SUS-2585
 * @package Wikia\Tasks\Tasks
 */
class DismissCommunityMessageTask extends BaseTask {
	public function dismissCommunityMessage( $communityMessagesTimestamp ) {
		global $wgExternalDatawareDB;

		$wikiId = $this->getWikiId();
		$userId = $this->createdBy;

		$row = [
			'city_id' => $wikiId,
			'user_id' => $userId,
			'type' => \CommunityMessages::USER_FLAGS_COMMUNITY_MESSAGES,
			'data' => wfTimestamp( TS_DB, $communityMessagesTimestamp ),
		];

		$dbw = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$dbw->replace( 'user_flags', null /*not used*/, $row, __METHOD__ );
	}
}
