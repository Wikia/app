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

	$html .= Xml::element( 'h2', array(), wfMsg( 'imagereview-imagepage-header' ) );

	$reviews = array();
	$headers = array(
		wfMessage('imagereview-imagepage-table-header-reviewer')->text(),
		wfMessage('imagereview-imagepage-table-header-state')->text(),
		wfMessage('imagereview-imagepage-table-header-time')->text(),
	);
	$where = array(
			'wiki_id' => $wgCityId,
			'page_id' => $imagePage->getId(),
	);

	$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );

	$res = $dbr->select(
		'image_review_stats',
		'*',
		$where
	);

	if ( $dbr->numRows( $res ) == 0 ) {
		//check if image is in the queue at all!

		$imgCurState = $dbr->selectField(
			'image_review',
			'state',
			$where	
		);

		if ( false === $imgCurState ) {
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
				if ( $scribeEventProducer->buildEditPackage( $imagePage, $user, null, null, $file ) ) {
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
			$html .= wfMsg( 'imagereview-imagepage-not-in-queue' );

		} else {
			// image is in the queue but not reviewed yet
			$html .= wfMsg( 'imagereview-state-0' );
		}
	} else {
		// go through the list and display review states

		while ( $row = $dbr->fetchObject( $res ) ) {
			$data = array();
			$data[] = User::newFromId( $row->reviewer_id )->getName();
			$data[] = wfMsg( 'imagereview-state-' . $row->review_state );
			$data[] = $row->review_end . ' (UTC)';

			$reviews[] = $data;
		}

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
