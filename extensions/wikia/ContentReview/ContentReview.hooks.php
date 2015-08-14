<?php

namespace Wikia\ContentReview;

class Hooks {

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgCityId, $wgTitle, $wgUser;

		if ( $wgTitle->inNamespace( NS_MEDIAWIKI ) && $wgTitle->userCan( 'edit', $wgUser ) ) {
			$revisionData = \F::app()->sendRequest(
				'ContentReviewApiController',
				'getLatestReviewedRevision',
				[
					'wikiId' => $wgCityId,
					'pageId' => $wgTitle->getArticleID(),
				],
				true
			)->getData();

			$wikiPage = new \WikiPage( $wgTitle );

			if ( !( $revisionData['status'] )
				|| intval( $revisionData['revision_id'] ) !== $wikiPage->getLatest()
			) {
				$railModuleList[1503] = [ 'ContentReviewModule', 'Unreviewed', null ];
			}
		}

		return true;
	}
}
