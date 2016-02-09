<?php

use Wikia\Logger\WikiaLogger;

class HAWelcomeTaskHooks {

	/**
	 * Enqueues a job based on a few simple preliminary checks.
	 *
	 * Called once an article has been saved.
	 *
	 * @param WikiPage $articleObject The WikiPage object for the contribution.
	 * @param User $userObject The User object for the contribution.
	 * @param string $editContent The contributed text.
	 * @param string $editSummary The summary for the contribution.
	 * @param int $isMinorEdit Indicates whether a contribution has been marked as a minor one.
	 * @param null $watchThis Not used as of MW 1.8
	 * @param null $sectionAnchor Not used as of MW 1.8
	 * @param int $editFlags Bitmask flags for the edit.
	 * @param Revision $revisionObject The Revision object.
	 * @param Status $statusObject The Status object returned by Article::doEdit().
	 * @param int $baseRevisionId The ID of the revision, the current edit is based on (or Boolean False).
	 *
	 * @return Boolean True so the calling method would continue.
	 *
	 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
	 * @since MediaWiki 1.19.4
	 * @internal
	 */
	public static function onArticleSaveComplete( &$articleObject, &$userObject, $editContent, $editSummary, $isMinorEdit, $watchThis, $sectionAnchor, &$editFlags, $revisionObject, $statusObject, $baseRevisionId ) {
		global $wgCityId, $wgCommandLineMode, $wgMemc, $wgUser;

		// means we're dealing with a null edit (no content change) and therefore we don't have to welcome anybody
		if ( is_null( $revisionObject ) ) {
			return true;
		}

		// Ignore revisions created in the command-line mode. Otherwise this job could
		// invoke HAWelcome::onRevisionInsertComplete(), too which may cause an infinite loop
		// and serious performance problems.
		if ( $wgCommandLineMode ) {
			return true;
		}

		$dispatcher = new HAWelcomeTaskHookDispatcher();
		$dispatcher->setRevisionObject( $revisionObject )
			->setCityId( $wgCityId )
			->setMemcacheClient( $wgMemc )
			->setCurrentUser( $wgUser );

		return $dispatcher->dispatch();
	}
}
