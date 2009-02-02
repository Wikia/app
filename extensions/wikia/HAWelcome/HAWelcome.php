<?php

/**
 * Welcome user after first edit
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @ingroup JobQueue
 */

$wgHooks[ "RevisionInsertComplete" ][]	= "HAWelcome::revisionInsertComplete";

class HAWelcome extends Job {

	/**
	 * Construct a job
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( 'HAWelcome', $title, $params, $id );
	}

	public function run() {
		return true;
	}

	/**
	 * revisionInsertComplete
	 *
	 * static method called as hook
	 *
	 * @static
	 * @access public
	 *
	 * @param Revision	$revision	revision object
	 * @param string	$url		url to external object
	 * @param string	$flags		flags for this revision
	 *
	 * @return true means process other hooks
	 */
	public static function revisionInsertComplete( &$revision, &$url, &$flags ) {
		global $wgTitle, $wgUser;

		/**
		 * check if talk page for wgUser exists
		 */
		$talkPage = $wgUser->getUserPage()->getTalkPage();
		if( $talkPage ) {
			$talkArticle = new Article( $talkPage, 0 );
			if( !$talkArticle->exits( ) ) {
				$welcomeJob = new HAWelcome( $wgTitle, array( "user" => $wgUser ) );
				$welcomeJob->insert();
			}
		}
		return true;
	}
}
