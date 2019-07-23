<?php

/**
 * Discussion user log hooks
 */
class SpecialDiscussionsLogHooks {
	private static function getDiscussionLogQueryParamsFromTarget( Title $target ): array {
		$targetName = $target->getText();
		$targetUserId = User::idFromName( $targetName );

		if ( $targetUserId ) {
			return [ 'username' => $targetName ];
		}

		return [ 'ip' => $targetName ];
	}

	public static function onContributionsToolLinks( $id, Title $nt, &$tools ) {
		global $wgServer, $wgScriptPath, $wgUser;

		if ( $wgUser->isAllowed( 'specialdiscussionslog' ) ) {
			$query = http_build_query( self::getDiscussionLogQueryParamsFromTarget( $nt ) );
			$tools[] = Linker::makeExternalLink(
				$wgServer . $wgScriptPath . '/d/log?' . $query,
				wfMessage( 'discussionslog-contributions-link-title' )->escaped()
			);
		}

		return true;
	}

}
