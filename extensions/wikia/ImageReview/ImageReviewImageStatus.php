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
	global $wgCityId, $wgExternalDatawareDB;

	$context = $imagePage->getContext();

	if ( !$context->getUser()->isAllowed( 'imagereviewstats' ) ) {
		return true;
	}

	if ( !$imagePage->getTitle()->exists() ) {
		return true;
	}

	$html .= Xml::element( 'h2', [], $context->msg( 'imagereview-imagepage-header' )->escaped() );

	$headers = [
		$context->msg( 'imagereview-imagepage-table-header-reviewer' )->text(),
		$context->msg( 'imagereview-imagepage-table-header-state' )->text(),
		$context->msg( 'imagereview-imagepage-table-header-time' )->text(),
	];

	$dbr = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );

	$reviews =
		fetchReviewHistoryFromService( $wgCityId, $imagePage->getTitle() );

	// TODO: temporary solution, remove it as soon as image review history is migrated to the new tool
	// display history of review for images reviewed by old ImageReview tool
	if ( empty( $reviews ) ) {
		$reviews = fetchReviewHistory( $dbr, $wgCityId, $imagePage->getID() );
	}

	if ( empty( $reviews ) ) {
		// image is in the queue but not reviewed yet
		$html .= $context->msg( 'imagereview-state-0' )->escaped();
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
		$data[] = wfMessage( 'imagereview-state-' . $row->review_state )->text();
		$data[] = $row->review_end . ' (UTC)';

		$reviews[] = $data;
	}

	return $reviews;
}

function fetchReviewHistoryFromService( $cityId, Title $title ) {
	$db = wfGetDB( DB_SLAVE );
	$timestamp = wfLocalFile( $title )->getTimestamp();
	// latest revision of image is needed so we can not use $title->getLatestRevisionId() as it would return
	// revision id for image description
	$revisionId = $db->selectField(
		['revision'],
		'rev_id',
		[
			'rev_page' => $title->getArticleID(),
			'rev_timestamp' => $timestamp
		]
	);

	$key = wfForeignMemcKey( $cityId, 'image-review', $title->getArticleID(), $revisionId );

	return WikiaDataAccess::cache( $key, WikiaResponse::CACHE_STANDARD, function() use( $cityId, $title, $revisionId ) {
		$statusMessages = [
			'UNREVIEWED' => wfMessage( 'imagereview-state-0' )->escaped(),
			'ACCEPTED' => wfMessage( 'imagereview-state-2' )->escaped(),
			'QUESTIONABLE' => wfMessage( 'imagereview-state-5' )->escaped(),
			'REJECTED' => wfMessage( 'imagereview-state-4' )->escaped(),
			'REMOVED' => wfMessage( 'imagereview-state-3' )->escaped()
		];

		$reviewHistory = ( new ImageReviewService() )->getImageHistory(
			$cityId,
			$title->getArticleID(),
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
			array_filter(
				$reviewHistory,
				function ( ImageHistoryEntry $item ) {
					// Filter out entry with status 'UNREVIEWED' as it does make sense to display entry about unreviewed status with user that uploaded the file
					return $item->getStatus() != 'UNREVIEWED';
				}
			)
		);
	} );
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
