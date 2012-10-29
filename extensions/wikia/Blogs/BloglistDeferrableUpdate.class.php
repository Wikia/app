<?php
/**
 * A DeferrableUpdate for bloglists.
 *
 * The class was created in order to fix BugId:25123 - caching issues
 * related to the bloglist tag.
 *
 * @see includes/DeferredUpdates.php
 *
 * @author Michał Roszka (Mix) <mix@wikia-inc.com>
 * @since October 24, 2012
 */
class BloglistDeferrableUpdate implements DeferrableUpdate {

	/**
	 * The actual update.
	 */
	public function doUpdate() {
		wfProfileIn( __METHOD__ );

		$oDB = wfGetDB( DB_SLAVE );

		/**
		 * Ask for all the pages containing the bloglist tag.
		 */
		$oData = $oDB->select(
			'page_props',
			array( 'pp_page' ),
			array( 'pp_propname' => BLOGTPL_TAG ),
			__METHOD__
		);

		/**
		 * And purge their cache.
		 */
		while ( $oRow = $oDB->fetchObject( $oData ) ) {

			$oArticle = Article::newFromID( $oRow->pp_page );

			// The check here is because I am not sure how deleted
			// pages are handled, I mean whether the corresponding
			// page_props are moved somewhere or not.
			if ( $oArticle instanceof Article ) {
				$oArticle->doPurge();
			}
		}

		wfProfileOut( __METHOD__ );
	}
}
