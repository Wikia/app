<?php
/**
 * ImageReviewTask
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

use \Wikia\Logger\WikiaLogger;
use WikiaDataAccess;

class ImageReviewTask extends BaseTask {

	public function delete( $pageList, $suppress = false ) {
		global $IP;

		$user = \User::newFromId( $this->createdBy );
		$userName = $user->getName();
		$articlesDeleted = 0;

		foreach ( $pageList as $imageData ) {
			// prevent notices
			if ( count( $imageData ) == 3 ) {
				list( $wikiId, $imageId, $revisionId ) = $imageData;
			} else {
				list( $wikiId, $imageId ) = $imageData;
			}

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
			$reason = wfMessage( 'imagereview-reason' )->inLanguage( $cityLang );

			if ( count( $imageData ) == 3 ) {
				$command =
					"php {$IP}/maintenance/wikia/deleteImageRevision.php --pageId=${imageId} --revisionId=${revisionId}";

				$output = wfShellExec( $command, $exitStatus, [ 'SERVER_ID' => $wikiId ] );

				if ( $exitStatus !== 0 ) {
					$this->error( 'article deletion error', [
						'cityId' => $wikiId,
						'pageId' => $imageId,
						'revisionId' => $revisionId,
						'exit_status' => $exitStatus,
						'output' => $output,
					] );

					continue;
				}

				$this->info( 'removed image', [
					'cityId' => $wikiId,
					'pageId' => $imageId,
					'revisionId' => $revisionId,
					'exit_status' => $exitStatus,
				] );

			} else {
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
			}


			++$articlesDeleted;
		}

		$success = $articlesDeleted == count( $pageList );
		if ( !$success ) {
			$this->sendNotification();
		}

		return $success;
	}

	public function update( $pageList ) {
		foreach ( $pageList as list( $cityId, $pageId, $revisionId ) ) {
			$key = wfForeignMemcKey( $cityId, 'image-review', $pageId, $revisionId );

			WikiaDataAccess::cachePurge( $key );

			// SUS-2650: invalidate file page of reviewed image
			$task = new ImageReviewTask();
			$task->call( 'invalidateFilePage', (int) $pageId );
			$task->wikiId( $cityId );
			$task->queue();
		}
	}

	/**
	 * Invalidates provided file page (use page ID) by bumping page_touched entry in `page` table
	 * and purging CDN cache.
	 *
	 * This task is queued when image review status changes to reflect this change on the file page.
	 *
	 * @see SUS-2650
	 *
	 * @param int $pageId
	 */
	public function invalidateFilePage( int $pageId ) {
		$title = \Title::newFromId( $pageId );

		$title->invalidateCache();
		$title->purgeSquid();
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
