<?php
/**
 * Adds image review stats information to file pages
 *
 * @author tor
 * @date 2012-10-04
 */

use Swagger\Client\ImageReview\Models\ImageHistoryEntry;

$wgHooks['ImagePageAfterImageLinks'][] = 'efImageReviewDisplayStatus';

function efImageReviewDisplayStatus( ImagePage $imagePage, &$html ) {
	global $wgCityId, $wgExternalDatawareDB, $wgUser, $wgImageReviewTestCommunities;

	if ( !$wgUser->isAllowed( 'imagereviewstats' ) ) {
		return true;
	}

	if ( !$imagePage->getTitle()->exists() ) {
		return true;
	}

	$html .= Xml::element( 'h2', [], wfMessage( 'imagereview-imagepage-header' )->escaped() );

	$headers = [
		wfMessage( 'imagereview-imagepage-table-header-reviewer' )->text(),
		wfMessage( 'imagereview-imagepage-table-header-state' )->text(),
		wfMessage( 'imagereview-imagepage-table-header-time' )->text(),
	];

	$dbr = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );

	if ( in_array( $wgCityId, $wgImageReviewTestCommunities ) ) {
		$reviews =
			fetchReviewHistoryFromService( $wgCityId, $imagePage->getID(), $imagePage->getTitle()->getLatestRevID() );
	} else {
		$reviews = fetchReviewHistory( $dbr, $wgCityId, $imagePage->getID() );
	}

	if ( empty( $reviews ) ) {
		if ( !in_array( $wgCityId, $wgImageReviewTestCommunities ) && false === isImageInReviewQueue( $dbr, $wgCityId, $imagePage->getID() ) ) {
			/**
			 * If the file is a local one and is older than 1 hour - send it to ImageReview
			 * since it's probably been restored, and is not just a fresh file.
			 */
			$lastTouched = new DateTime( $imagePage->getRevisionFetched()->getTimestamp() );
			$now = new DateTime();
			$file = $imagePage->getDisplayedFile();
			if ( $file instanceof WikiaLocalFile && $lastTouched < $now->modify( '-1 hour' ) ) {
				$scribeEventProducer = new ScribeEventProducer( 'edit' );
				$user = User::newFromName( $file->getUser() );
				if ( $scribeEventProducer->buildEditPackage( $imagePage, $user, null, $file ) ) {
					$logParams = [
						'cityId' => $wgCityId,
						'pageId' => $imagePage->getID(),
						'pageTitle' => $imagePage->getTitle()->getText(),
						'uploadUser' => $user->getName(),
					];
					\Wikia\Logger\WikiaLogger::instance()->info(
						'ImageReviewLog',
						[
							'message' => 'Image moved back to queue',
							'params' => $logParams,
						]
					);

					$scribeEventProducer->sendLog();
				}
			}

			// oh oh, image is not in queue at all
			$html .= wfMessage( 'imagereview-imagepage-not-in-queue' )->escaped();
		} else {
			// image is in the queue but not reviewed yet
			$html .= wfMessage( 'imagereview-state-0' )->escaped();
		}
	} else {
		$html .= Xml::buildTable(
			$reviews,
			[
				'class' => 'wikitable filehistory sortable',
				'style' => 'width: 60%',
			],
			$headers
		);
	}

	return true;
}

function fetchReviewHistory( $dbr, $cityId, $pageId ) {
	$res = $dbr->select(
		'image_review_stats',
		'*',
		[
			'wiki_id' => $cityId,
			'page_id' => $pageId,
		]
	);

	$reviews = [];
	while ( $row = $dbr->fetchObject( $res ) ) {
		$data = [];
		$data[] = User::newFromId( $row->reviewer_id )->getName();

		//Possible keys:
		// imagereview-state-0
		// imagereview-state-1
		// imagereview-state-2
		// imagereview-state-3
		// imagereview-state-4
		// imagereview-state-5
		$data[] = wfMessage( 'imagereview-state-' . $row->review_state )->escaped();
		$data[] = $row->review_end . ' (UTC)';

		$reviews[] = $data;
	}

	return $reviews;
}

function fetchReviewHistoryFromService( $cityId, $pageId, $revisionId ) {
	$statusMessages = [
		'UNREVIEWED' => wfMessage( 'imagereview-state-0' )->escaped(),
		'ACCEPTED' => wfMessage( 'imagereview-state-2' )->escaped(),
		'QUESTIONABLE' => wfMessage( 'imagereview-state-5' )->escaped(),
		'REJECTED' => wfMessage( 'imagereview-state-4' )->escaped(),
		'REMOVED' => wfMessage( 'imagereview-state-3' )->escaped()
	];

	$reviewHistory = ( new ImageReviewService() )->getImageHistory(
		$cityId,
		$pageId,
		$revisionId,
		RequestContext::getMain()->getUser()
	);

	return array_map(
		function ( ImageHistoryEntry $item ) use ( $statusMessages ) {
			return [
				$item->getUser(),
				$statusMessages[$item->getStatus()],
				$item->getDate()
			];
		},
		array_filter( $reviewHistory, function( ImageHistoryEntry $item ) {
			// Filter out entry with status 'UNREVIEWED' as it does make sense to display entry about unreviewed status with user that uploaded the file
			return $item->getStatus() != 'UNREVIEWED';
		} )
	);
}

function isImageInReviewQueue( $dbr, $cityId, $pageId ) {
	return $dbr->selectField(
		'image_review',
		'state',
		[
			'wiki_id' => $cityId,
			'page_id' => $pageId,
		]
	);
}
