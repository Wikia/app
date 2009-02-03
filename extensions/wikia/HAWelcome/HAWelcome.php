<?php

/**
 * Welcome user after first edit
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @ingroup JobQueue
 */

/**
 * used hooks
 */
$wgHooks[ "RevisionInsertComplete" ][]	= "HAWelcomeJob::revisionInsertComplete";

/**
 * register job class
 */
$wgJobClasses[ "HAWelcome" ] = "HAWelcomeJob";

/**
 * used messages
 */
$wgExtensionMessagesFiles["HAWelcome"] = dirname(__FILE__) . '/HAWelcome.i18n.php';

class HAWelcomeJob extends Job {

	private $mUser;

	/**
	 * Construct a job
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		wfLoadExtensionMessages( "HAWelcome" );
		parent::__construct( "HAWelcome", $title, $params, $id );
		$user_id = $params[ "user_id" ];
		$this->mUser = User::newFromId( $user_id );
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {

		print $this->title->getText();
		print $this->title->getNsText();
		if( $this->mUser ) {
			/**
			 * check again if talk page exists
			 */
			$talkPage = $this->mUser->getUserPage()->getTalkPage();
			$welcomeMsg = wfMsg( "hawelcome-message-user",
				array(
					sprintf("%s:%s", $this->title->getNsText(),  $this->title->getText() )
				)
			);
			$talkArticle = new Article( $talkPage, 0 );
			$talkArticle->doEdit( $welcomeMsg, "test" );
		}

		return true;
	}

	/**
	 * get last active sysop for this wiki, use local user database and blobs
	 * from dataware
	 *
	 * @access public
	 */
	public function getLastSysyop() {
		global $wgCityId;
#		select max(rev_timestamp), lu_user_name from city_local_users, blobs where lu_user_name = rev_user_text and lu_allgroups like '%staff%' and rev_wikia_id = 165 group by lu_user_name order by 1 desc limit 1;
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
		 *
		 * @todo check editcount for user
		 */
		$talkPage = $wgUser->getUserPage()->getTalkPage();
		if( $talkPage ) {
			$talkArticle = new Article( $talkPage, 0 );
			if( !$talkArticle->exists( ) || 1 ) { // for while every edition create job
				$welcomeJob = new HAWelcomeJob(
					$wgTitle,
					array(
						"is_anon" => $wgUser->isAnon(),
						"user_id" => $wgUser->getId(),
						"user_name" => $wgUser->getName(),
					)
				);
				$welcomeJob->insert();
			}
		}
		return true;
	}

	/**
	 * @access public
	 *
	 * @return Title instance of Title object
	 */
	public function getTitle() {
		return $this->title;
	}
}
