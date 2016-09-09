<?php
/**
 * ImageReviewTask
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

use \Wikia\Logger\WikiaLogger;

class ImageReviewTask extends BaseTask {

	public function delete( $pageList, $suppress = false ) {
		global $IP;

		$user = \User::newFromId( $this->createdBy );
		$userName = $user->getName();
		$articlesDeleted = 0;

		foreach ( $pageList as $imageData ) {
			list( $wikiId, $imageId ) = $imageData;

			if ( !\WikiFactory::isPublic( $wikiId ) ) {
				$this->notice( 'wiki has been disabled', ['wiki_id' => $wikiId] );
				continue;
			}

			$dbname = \WikiFactory::getWikiByID( $wikiId );
			if ( !$dbname ) {
				$this->warning( 'did not find database', ['wiki_id' => $wikiId] );
				continue;
			}

			$cityUrl = \WikiFactory::getVarValueByName( 'wgServer', $wikiId );
			if ( empty( $cityUrl ) ) {
				$this->warning( 'could not determine city url', ['wiki_id' => $wikiId] );
				continue;
			}

			$cityLang = \WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId );
			$reason = wfMsgExt( 'imagereview-reason', ['language' => $cityLang] );

			$command = "SERVER_ID={$wikiId} php {$IP}/maintenance/wikia/deleteOn.php" .
				' -u ' . escapeshellarg( $userName ) .
				' --id ' . $imageId;

			if ( $reason ) {
				$command .= ' -r ' . escapeshellarg( $reason );
			}
			if ( $suppress ) {
				$command .= ' -s';
			}

			$title = wfShellExec( $command, $exitStatus );

			if ( $exitStatus !== 0 ) {
				$this->error( 'article deletion error', [
					'city_url' => $cityUrl,
					'exit_status' => $exitStatus,
					'error' => $title,
				] );

				continue;
			}

			$cityPath = \WikiFactory::getVarValueByName( 'wgScript', $wikiId );
			$escapedTitle = wfEscapeWikiText( $title );

			$this->info( 'removed image', [
				'link' => "{$cityUrl}{$cityPath}?title={$escapedTitle}",
				'title' => $escapedTitle,
			] );

			++$articlesDeleted;
		}

		$success = $articlesDeleted == count( $pageList );
		if ( !$success ) {
			$this->sendNotification();
		}

		return $success;
	}

	public function deleteFromQueue( Array $aDeletionList ) {
		global $wgExternalDatawareDB;

		$oDB = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );

		foreach ( $aDeletionList as $aRow ) {
			$aImageData = [
				'wiki_id' => $aRow['wiki_id'],
				'page_id' => $aRow['page_id'],
			];

			$oDB->delete(
				'image_review',
				$aImageData,
				__METHOD__
			);

			WikiaLogger::instance()->info( 'ImageReviewLog', [
				'method' => __METHOD__,
				'message' => 'Image removed from queue',
				'params' => $aRow,
			] );
		}
	}

	public function addToQueue() {
		global $wgExternalDatawareDB;
		$title = $this->getTitle();
		$wikiId = $this->getWikiId();
		$latestRevId = $title->getLatestRevID( \Title::GAID_FOR_UPDATE );

		$imageData = [
			'wiki_id' => $wikiId,
			'page_id' => $title->getArticleID(),
			'revision_id' => $latestRevId,
			'user_id' => wfLocalFile( $title )->getUser( 'id' ),
			'last_edited' => \Revision::newFromId( $latestRevId, \Revision::READ_LATEST )->getTimestamp(),
			'top_200' => $this->isTop200( $wikiId ) ? 1 : 0,
			'state' => \ImageReviewStatuses::STATE_UNREVIEWED,
		];

		$dbw = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		$result = $dbw->upsert(
			'image_review',
			$imageData,
			[],
			[
				'last_edited = values(last_edited)',
				'revision_id = values(revision_id)',
				'state = values(state)',
				'user_id = values(user_id)',
			],
			__METHOD__
		);

		if ( $result ) {
			$this->info( 'Image Review - Added uploaded file', $imageData );
		} else {
			$this->error( 'Image Review - Failed to add uploaded file', $imageData );
		}

		return $result;
	}

	private function isTop200( $wikiId ) {
		global $wgExternalDatawareDB;
		$dbr = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );

		$result = $dbr->selectRow(
			'image_review',
			[ 'top_200' ],
			[
				'wiki_id' => $wikiId,
				'top_200' => 1,
			],
			__METHOD__
		);

		return $result !== false;
	}

	private function sendNotification() {
		global $wgFlowerUrl;

		$subject = "ImageReview deletion failed #{$this->taskId}";
		$body = "{$wgFlowerUrl}/task/{$this->taskId}";
		$recipients = [
			new \MailAddress( 'tor@wikia-inc.com' ),
			new \MailAddress( 'adamk@wikia-inc.com' ),
			new \MailAddress( 'sannse@wikia-inc.com' ),
		];
		$from = $recipients[0];

		foreach ( $recipients as $recipient ) {
			\UserMailer::send( $recipient, $from, $subject, $body );
		}

		WikiaLogger::instance()->error( "ImageReviewLog", [
			'method' => __METHOD__,
			'message' => "Task #{$this->taskId} deleting images did not succeed. Please check.",
			'taskId' => $this->taskId,
			'taskUrl' => $body,
		] );
	}
}
