<?php

namespace Wikia\ContentReview;

class Hooks {

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgCityId, $wgTitle, $wgUser;

		if ( $wgTitle->inNamespace( NS_MEDIAWIKI )
			&& $wgTitle->isJsPage()
			&& $wgTitle->userCan( 'edit', $wgUser )
		) {
			$currentPageData = \F::app()->sendRequest(
				'ContentReviewApiController',
				'getCurrentPageData',
				[
					'wikiId' => $wgCityId,
					'pageId' => $wgTitle->getArticleID(),
				],
				true
			)->getData();

			if ( intval( $currentPageData['revision_id'] ) !== $wgTitle->getLatestRevID() ) {
				if ( intval( $currentPageData['review_status'] ) !== null ) {
					$railModuleList[1503] = [ 'ContentReviewModule', 'InReview', null ];
				} else {
					$railModuleList[1503] = [ 'ContentReviewModule', 'Unreviewed', null ];
				}
			}
		}

		return true;
	}
}
