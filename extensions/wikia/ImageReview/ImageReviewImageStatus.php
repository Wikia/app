<?php
/**
 * Adds image review stats information to file pages
 * @author tor
 * @date 2012-10-04
 */

$wgHooks['ImagePageAfterImageLinks'][] = 'efImageReviewDisplayStatus';

function efImageReviewDisplayStatus( ImagePage $imagePage, &$html ) {
	global $wgCityId, $wgExternalDatawareDB, $wgUser;

	if ( !$wgUser->isAllowed( 'imagereviewstats' ) ) {
		return true;
	}

	if ( !$imagePage->getTitle()->exists() ) {
		return true;
	}

	$html .= Xml::element( 'h2', array(), wfMessage( 'imagereview-imagepage-header' )->escaped() );

	$headers = [
		wfMessage('imagereview-imagepage-table-header-reviewer')->text(),
		wfMessage('imagereview-imagepage-table-header-state')->text(),
		wfMessage('imagereview-imagepage-table-header-time')->text(),
	];

	$dbr = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );

	$reviews = fetchReviewHistory( $dbr, $wgCityId, $imagePage->getID() );
	if ( empty( $reviews ) ) {

		// TODO: consider if in the new flow this also should be checked
		if ( false === isImageInReviewQueue( $dbr, $wgCityId, $imagePage->getID() ) ) {
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
					\Wikia\Logger\WikiaLogger::instance()->info( 'ImageReviewLog',
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
			array(
				'class' => 'wikitable filehistory sortable',
				'style' => 'width: 60%',
			),
			$headers
		);
	}

	return true;
}

function fetchReviewHistory( $dbr, $cityId, $pageId ) {
	// TODO: fetch history from ImageReview service

	$res = $dbr->select(
		'image_review_stats',
		'*',
		[
			'wiki_id' => $cityId,
			'page_id' => $pageId,
		]
	);

	$reveiws = [];
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

	return $reveiws;
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
