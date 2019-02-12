<?php

/**
 * Discussion user log hooks
 */
class SpecialDiscussionsLogHooks {
	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgServer, $wgScriptPath;

		if ( F::app()->wg->User->isAllowed( 'specialdiscussionslog' ) ) {
			$tools[] = Linker::makeExternalLink(
				$wgServer . $wgScriptPath . '/d/log?username=' . User::newFromId( $id )->getName(),
				wfMessage( 'discussionslog-contributions-link-title' )->escaped()
			);
		}

		return true;
	}

}
