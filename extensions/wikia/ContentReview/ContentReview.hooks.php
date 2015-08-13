<?php

namespace Wikia\ContentReview;

class Hooks {

	public static function onGetRailModuleList( Array &$railModuleList ) {
		global $wgTitle, $wgUser;

		if ( $wgTitle->getNamespace() === NS_MEDIAWIKI && $wgTitle->userCan( 'edit', $wgUser ) ) {
			$railModuleList[1503] = [ 'ContentReviewModule', 'Unreviewed', null ];
		}

		return true;
	}
}
