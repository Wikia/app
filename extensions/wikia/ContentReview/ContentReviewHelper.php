<?php

namespace Wikia\ContentReview;

class Helper
{

	public function getSiteJsScriptsHash() {
		global $wgCityId;

		$maxTimestamp = 0;

		$currentRevisionModel = new Models\CurrentRevisionModel();
		$revisions = $currentRevisionModel->getLatestReviewedRevisionForWiki( $wgCityId );

		foreach ( $revisions as $revision ) {
			$maxTimestamp = max( $maxTimestamp, $revision['touched'] );
		}

		return $maxTimestamp;
	}

	public function getReviewedRevisionIdFromText( $pageName ) {
		global $wgCityId;

		$title = \Title::newFromText( $pageName );
		$pageId = $title->getArticleID();

		$currentRevisionModel = new Models\CurrentRevisionModel();
		$revision = $currentRevisionModel->getLatestReviewedRevision( $wgCityId, $pageId );

		return $revision['revision_id'];
	}
}
