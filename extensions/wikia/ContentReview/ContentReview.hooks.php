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

			$wikiPage = new \WikiPage( $wgTitle );

			if ( !( $currentPageData['status'] )
				|| intval( $currentPageData['revision_id'] ) !== $wikiPage->getLatest()
			) {
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
