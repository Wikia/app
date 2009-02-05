<?php

/**
 * HAWelcomeJob -- Welcome user after first edit
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2009-02-02
 * @version 0.1
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
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

	private $mUser,
		$mAnon;

	/**
	 * Construct a job
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		Wikia::log( __METHOD__, $params );
		wfLoadExtensionMessages( "HAWelcome" );
		parent::__construct( "HAWelcome", $title, $params, $id );
		$user_id = $params[ "user_id" ];

		$this->mAnon = (bool )$params[ "is_anon" ];
		$this->mUser = User::newFromId( $user_id );
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgDevelEnvironment;

		/**
		 * overwrite $wgUser for ~~~~ expanding
		 */
		$tmpUser = $wgUser;

		if( $this->mUser ) {
			/**
			 * check again if talk page exists
			 */
			$talkPage  = $this->mUser->getUserPage()->getTalkPage();
			if( $talkPage ) {
				$wgUser    = $this->getLastSysop();
				$sysopPage = $wgUser->getUserPage()->getTalkPage();

				$talkArticle = new Article( $talkPage, 0 );
				if( ! $talkArticle->exists() || $wgDevelEnvironment ) {
					if( $this->mAnon ) {
						$welcomeMsg = wfMsg( "hawelcome-message-anon", array(
							sprintf("%s:%s", $this->title->getNsText(), $this->title->getText() ),
							sprintf("%s:%s", $sysopPage->getNsText(), $sysopPage->getText() )
						));
					}
					else {
						$welcomeMsg = wfMsg( "hawelcome-message-user", array(
							sprintf("%s:%s", $this->title->getNsText(), $this->title->getText() ),
							sprintf("%s:%s", $sysopPage->getNsText(), $sysopPage->getText() )
						));
					}
					$talkArticle->doEdit( $welcomeMsg, wfMsg( "hawelcome-message-log" ) );
				}
			}
		}

		$wgUser = $tmpUser;
		return true;
	}

	/**
	 * get last active sysop for this wiki, use local user database and blobs
	 * from dataware
	 *
	 * @access public
	 */
	public function getLastSysop() {
		global $wgCityId;

		$dbr = wfGetDBExt( DB_SLAVE );
		$Row = $dbr->selectRow(
			array( "city_local_users", "blobs" ),
			array( "rev_timestamp", "lu_user_id" ),
			array(
				"lu_user_id = rev_user",
				"lu_allgroups like '%sysop%'",
				"rev_wikia_id" => $wgCityId
			),
			__METHOD__,
			array( "order by" => "rev_timestamp desc" )
		);

		return User::newFromId( $Row->lu_user_id );
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
		global $wgTitle, $wgUser, $wgDevelEnvironment;

		/**
		 * check if talk page for wgUser exists
		 *
		 * @todo check editcount for user
		 */
		$talkPage = $wgUser->getUserPage()->getTalkPage();
		if( $talkPage ) {
			$talkArticle = new Article( $talkPage, 0 );
			if( !$talkArticle->exists( ) || $wgDevelEnvironment ) {
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
