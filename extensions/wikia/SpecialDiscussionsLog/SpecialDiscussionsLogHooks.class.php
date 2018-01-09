<?php

/**
 * Discussion user log hooks
 */
class SpecialDiscussionsLogHooks {
	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		global $wgTitle;

		if ( F::app()->wg->User->isAllowed( 'specialdiscussionslog' ) ) {
			$urlHost = parse_url( $wgTitle->getFullURL(), PHP_URL_HOST );
			$tools[] = Linker::makeExternalLink(
				'http://' . $urlHost . '/d/log?username=' . User::newFromId( $id )->getName(),
				wfMessage( 'discussionslog-contributions-link-title' )->escaped()
			);
		}

		return true;
	}

}
