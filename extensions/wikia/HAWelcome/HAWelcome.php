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
 * @version 0.2
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'HAWelcome',
	'version' => '0.2',
	'author' => 'Krzysztof Krzyźaniak',
	'description' => 'Highly Automated Welcome Tool ',
);


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
$wgExtensionMessagesFiles[ "HAWelcome" ] = dirname(__FILE__) . '/HAWelcome.i18n.php';

/**
 * register task
 */
$wgWikiaBatchTasks[ "welcome" ] = "HAWelcomeTask";

class HAWelcomeJob extends Job {

	private
		$mUser,
		$mAnon,
		$mSysop;

	const WELCOMEUSER = "Wikia-welcome";

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
		$user_ip = $params[ "user_ip" ];

		$this->mAnon = (bool )$params[ "is_anon" ];
		if( $this->mAnon ) {
			$this->mUser = User::newFromName( $user_ip, false );
		}
		else {
			$this->mUser = User::newFromId( $user_id );
		}
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgDevelEnvironment;

		wfProfileIn( __METHOD__ );

		/**
		 * overwrite $wgUser for ~~~~ expanding
		 */
		$tmpUser = $wgUser;
		$wgUser  = User::newFromName( self::WELCOMEUSER );

		if( $this->mUser && $this->mUser->getName() !== self::WELCOMEUSER ) {
			/**
			 * check again if talk page exists
			 */
			$talkPage  = $this->mUser->getUserPage()->getTalkPage();
			if( $talkPage ) {
				$sysop     = $this->getLastSysop();
				$sysopPage = $sysop->getUserPage()->getTalkPage();
				$signature = $this->expandSig();

				$talkArticle = new Article( $talkPage, 0 );

				if( ! $talkArticle->exists() || $wgDevelEnvironment ) {
					if( $this->mAnon ) {
						$welcomeMsg = wfMsg( "welcome-message-anon", array(
							sprintf("%s:%s", $this->title->getNsText(), $this->title->getText() ),
							sprintf("%s:%s", $sysopPage->getNsText(), $sysopPage->getText() ),
							$signature
						));
					}
					else {
						/**
						 * now create user page (if not exists of course)
						 */
						$userPage = $this->mUser->getUserPage();
						if( $userPage ) {
							$userArticle = new Article( $userPage, 0 );
							if( ! $userArticle->exists() || $wgDevelEnvironment ) {
								$welcomeMsg = wfMsg( "welcome-user-page" );
								$userArticle->doEdit( $welcomeMsg, false, EDIT_FORCE_BOT );
							}
						}

						$welcomeMsg = wfMsg( "welcome-message-user", array(
							sprintf("%s:%s", $this->title->getNsText(), $this->title->getText() ),
							sprintf("%s:%s", $sysopPage->getNsText(), $sysopPage->getText() ),
							$signature
						));
					}
					$talkArticle->doEdit( $welcomeMsg, wfMsg( "welcome-message-log" ), EDIT_FORCE_BOT );
				}
			}
		}

		$wgUser = $tmpUser;

		wfProfileOut( __METHOD__ );

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

		wfProfileIn( __METHOD__ );

		if( ! $this->mSysop instanceof User ) {

			$sysop = trim( wfMsg( "welcome-user" ) );
			if( $sysop !== "-" && $sysop !== "@latest" && $sysop !== "@disabled" ) {
				$this->mSysop = User::newFromName( $sysop );
			}
			else {
				$dbr = wfGetDB( DB_SLAVE );
				$res = $dbr->query("
					SELECT rev_user, rev_timestamp
					FROM revision
					WHERE revision.rev_user IN (
						SELECT ug_user
						FROM user_groups
						WHERE ug_group IN ( 'staff', 'sysop', 'helper')
					)
					ORDER BY rev_timestamp DESC
					LIMIT 1",
					__METHOD__
				);
				$row = $dbr->fetchObject( $res );
				$dbr->freeResult( $res );

				$this->mSysop = User::newFromId( $row->rev_user );
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->mSysop;
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
		global $wgUser, $wgDevelEnvironment, $wgCityId, $wgCommandLineMode;

		wfProfileIn( __METHOD__ );

		wfLoadExtensionMessages( "HAWelcome" );

		/**
		 * Revision has valid Title field
		 */
		$Title = $revision->getTitle();
		if( $Title && ! $wgCommandLineMode ) {
			$welcomer = trim( wfMsgForContent( "welcome-user" ) );
			Wikia::log( __METHOD__, "welcomer", $welcomer );
			if( $welcomer !== "@disabled" && $welcomer !== "-" ) {
				/**
				 * check if talk page for wgUser exists
				 *
				 * @todo check editcount for user
				 */
				Wikia::log( __METHOD__, "user", $wgUser->getName() );
				$talkPage = $wgUser->getUserPage()->getTalkPage();
				if( $talkPage ) {
					$talkArticle = new Article( $talkPage, 0 );
					if( !$talkArticle->exists( ) || $wgDevelEnvironment ) {
						$welcomeJob = new HAWelcomeJob(
							$Title,
							array(
								"is_anon"   => $wgUser->isAnon(),
								"user_id"   => $wgUser->getId(),
								"user_ip"   => wfGetIP(),
								"user_name" => $wgUser->getName(),
							)
						);
						$welcomeJob->insert();
						Wikia::log( __METHOD__, "job" );

						/**
						 * inform task manager
						 */
						$Task = new HAWelcomeTask();
						$Task->createTask( array( "city_id" => $wgCityId ), TASK_QUEUED  );
					}
				}
			}
			else {
				Wikia::log( __METHOD__, "disabled" );
			}
		}
		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * expandSig -- hack, expand signature from message for sysop
	 *
	 * @access private
	 */
	private function expandSig( ) {

		global $wgContLang, $wgUser;

		wfProfileIn( __METHOD__ );

		$Sysop = $this->getLastSysop();
		$tmpUser = $wgUser;
		$wgUser = $Sysop;
		$signature = sprintf(
			"-- [[User:%s|%s]] ([[User_talk:%s|%s]]) %s",
			wfEscapeWikiText( $Sysop->getName() ),
			wfEscapeWikiText( $Sysop->getName() ),
			wfEscapeWikiText( $Sysop->getName() ),
			$wgContLang->lc( wfMsg( "talkpagelinktext" ) ),
			$wgContLang->timeanddate( wfTimestampNow( TS_MW ) )
		);
		$wgUser = $tmpUser;

		wfProfileOut( __METHOD__ );

		return $signature;
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


/**
 * Task, will run runJobs for specified city_id
 */
class HAWelcomeTask extends BatchTask {

	private $mParams;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {
		$this->mType = "welcome";
		$this->mVisible = false;
		$this->mTTL = 1800;
		parent::__construct();
		$this->mDebug = false;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

		$this->mParams = unserialize( $params->task_arguments );
		$city_id = $this->mParams["city_id"];
		if( $city_id ) {
			/**
			 * execute maintenance script
			 */
			$cmd = sprintf( "SERVER_ID={$city_id} php {$IP}/maintenance/runJobs.php --type HAWelcome --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
			$this->addLog( "Running {$cmd}" );
			$retval = wfShellExec( $cmd, $status );
			$this->addLog( $retval );
		}

		return true;
	}

	/**
	 * getForm
	 *
	 * this task is not visible in selector so it doesn't have real HTML form
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param Title $title: Title struct
	 * @param mixes $data: params from HTML form
	 *
	 * @return false
	 */
	public function getForm( $title, $data = false ) {
		return false;
	}

	/**
	 * getType
	 *
	 * return string with codename type of task
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return string: unique name
	 */
	public function getType() {
		return $this->mType;
	}

	/**
	 * isVisible
	 *
	 * check if class is visible in TaskManager from dropdown
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return boolean: visible or not
	 */
	public function isVisible() {
		return $this->mVisible;
	}

	/**
	 * submitForm
	 *
	 * since this task is invisible for form selector we use this method for
	 * saving request data in database
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @return true
	 */
	public function submitForm() {
		return true;
	}
}
