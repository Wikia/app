<?php

/**
 * Discussion user log hooks
 */
class SpecialDiscussionsLogHooks {
	public static function onContributionsToolLinks( $id, $nt, &$tools ) {
		if ( F::app()->wg->User->isAllowed( 'specialdiscussionslog' ) ) {
			$tools[] = Linker::link(
				SpecialPage::getSafeTitleFor( 'DiscussionsLog' ),
				wfMessage( 'discussionslog-contributions-link-title' )->escaped(),
				[],
				['username' => User::newFromId( $id )->getName()]
			);
		}

		return true;
	}

}
