<?php

/**
 * HAWelcomeJob -- Welcome user after first edit
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2009-02-02
 * @version 0.5
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'name' => 'HAWelcome',
	'version' => '0.5',
	'author' => array('Krzysztof Krzyżaniak', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'),
	'description' => 'Highly Automated Welcome Tool',
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
		$mUserId,
		$mUserName,
		$mUserIP,
		$mUser,
		$mAnon,
		$mSysop;

	const WELCOMEUSER = "Wikia";

	/**
	 * Construct a job
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		wfLoadExtensionMessages( "HAWelcome" );
		parent::__construct( "HAWelcome", $title, $params, $id );
		$this->mUserId = $params[ "user_id" ];
		$this->mUserIP = $params[ "user_ip" ];
		$this->mUserName = $params[ "user_name" ];

		$this->mAnon = (bool )$params[ "is_anon" ];
		if( $this->mAnon ) {
			$this->mUser = User::newFromName( $this->mUserIP, false );
		}
		else {
			$this->mUser = User::newFromId( $this->mUserId );
		}

		/**
		 * fallback
		 */
		if( ! $this->mUser ) {
			$this->mUser = User::newFromName( $this->mUserName );
		}
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {
		global $wgUser, $wgTitle;

		wfProfileIn( __METHOD__ );

		/**
		 * overwrite $wgUser for ~~~~ expanding
		 */
		$tmpUser = $wgUser;
		$wgUser  = User::newFromName( self::WELCOMEUSER );
		$flags = 0;
		if( $wgUser->isAllowed( 'bot' ) ) {
			$flags = EDIT_FORCE_BOT;
		}
		Wikia::log( __METHOD__, "user", $this->mUser->getName() );

		if( $this->mUser && $this->mUser->getName() !== self::WELCOMEUSER ) {
			/**
			 * check again if talk page exists
			 */
			$talkPage  = $this->mUser->getUserPage()->getTalkPage();
			Wikia::log( __METHOD__, "talk", $talkPage->getLocalUrl() );

			if( $talkPage ) {
				$tmpTitle  = $wgTitle;
				$sysop     = $this->getLastSysop();
				$sysopPage = $sysop->getUserPage()->getTalkPage();
				$signature = $this->expandSig();

				$wgTitle = $talkPage;
				$talkArticle = new Article( $talkPage, 0 );

				if( ! $talkArticle->exists() ) {
					if( $this->mAnon ) {
						$welcomeMsg = wfMsg( "welcome-message-anon", array(
							$this->title->getPrefixedText(),
							$sysopPage->getPrefixedText(),
							$signature
						));
					}
					else {
						/**
						 * now create user page (if not exists of course)
						 */
						$userPage = $this->mUser->getUserPage();
						if( $userPage ) {
							$wgTitle = $userPage;
							$userArticle = new Article( $userPage, 0 );
							if( ! $userArticle->exists() ) {
								$welcomeMsg = wfMsg( "welcome-user-page" );
								$userArticle->doEdit( $welcomeMsg, false, $flags );
							}
						}

						$welcomeMsg = wfMsg( "welcome-message-user", array(
							$this->title->getPrefixedText(),
							$sysopPage->getPrefixedText(),
							$signature
						));
					}
					$wgTitle = $talkPage; /** is it necessary there? **/
					$talkArticle->doEdit( $welcomeMsg, wfMsg( "welcome-message-log" ), $flags );
					Wikia::log( __METHOD__, "edit", $welcomeMsg );
				}
				$wgTitle = $tmpTitle;
			}
		}

		$wgUser = $tmpUser;

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * get last active sysop for this wiki, use local user database
	 *
	 * @access public
	 *
	 * @return User class instance
	 */
	public function getLastSysop() {
		global $wgCityId;

		wfProfileIn( __METHOD__ );

		if( ! $this->mSysop instanceof User ) {

			$sysop = trim( wfMsg( "welcome-user" ) );

			if( $sysop !== "-" && $sysop !== "@latest" && $sysop !== "@disabled" && $sysop !== "@sysop" ) {
				$this->mSysop = User::newFromName( $sysop );
			}
			else {
				$dbr = wfGetDB( DB_SLAVE );
				$aWhere = ($sysop !== "@sysop") ? array('staff', 'sysop', 'helper') : array('sysop');
				$res = $dbr->query(
					"SELECT ug_group, GROUP_CONCAT(DISTINCT ug_user SEPARATOR ',') AS user_id" .
					" FROM user_groups" .
					" WHERE ug_group IN ('" . implode("','", $aWhere) . "', 'bot')" .
					" GROUP BY ug_group;",
					__METHOD__
				);

				$idsInGroups = array();
				while( $row = $dbr->fetchObject( $res ) ) {
					$idsInGroups[$row->ug_group] = explode(',', $row->user_id);
				}
				$idsBot = isset($idsInGroups['bot']) ? $idsInGroups['bot'] : array();
				unset($idsInGroups['bot']);
				//combine $idsInGroups['sysop'], $idsInGroups['staff'], .... etc. into one unique array
				$idsUser = array_unique(call_user_func_array('array_merge', $idsInGroups));
				//remove users that has 'bot' flag
				$idsInGroups = array_diff($idsUser, $idsBot);

				$res = $dbr->query("
					SELECT rev_user
					FROM revision
					WHERE revision.rev_user IN ('" . implode("','", $idsInGroups) . "')
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
		global $wgUser, $wgCityId, $wgCommandLineMode, $wgSharedDB;

		wfProfileIn( __METHOD__ );

		/**
		 * Do not create task when DB is locked (rt#12229)
		 */
		if ( !wfReadOnly() ) {
			wfLoadExtensionMessages( "HAWelcome" );

			/**
			 * Revision has valid Title field but sometimes not filled
			 */
			$Title = $revision->getTitle();
			if( !$Title ) {
				$Title = Title::newFromId( $revision->getPage(), GAID_FOR_UPDATE );
				$revision->setTitle( $Title );
			}
			$skip = (bool)(
				$wgUser->isAllowed( "bot" )    ||
				$wgUser->isAllowed( "staff" )  ||
				$wgUser->isAllowed( "helper" ) ||
				$wgUser->isAllowed( "sysop" )  ||
				$wgUser->isAllowed( "bureaucrat" ) );

			if( $Title && !$wgCommandLineMode && !$skip && !empty( $wgSharedDB ) ) {

				Wikia::log( __METHOD__, "title", $Title->getFullURL() );

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
						if( !$talkArticle->exists( ) ) {
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
							Wikia::log( __METHOD__, "task" );
						}
						else {
							Wikia::log( __METHOD__, "exists", sprintf( "Talk page for user %s alredy exits", $wgUser->getName() ) );
						}
					}
				}
				else {
					Wikia::log( __METHOD__, "disabled" );
				}
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
			"-- [[%s:%s|%s]] ([[%s:%s|%s]]) %s",
			$wgContLang->getNsText(NS_USER),
			wfEscapeWikiText( $Sysop->getName() ),
			wfEscapeWikiText( $Sysop->getName() ),
			$wgContLang->getNsText(NS_USER_TALK),
			wfEscapeWikiText( $Sysop->getName() ),
			wfMsg( "talkpagelinktext" ),
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

	/**
	 * check if some (or all) functionality is disabled
	 *
	 * @param String $message
	 * @param String $what default false
	 *
	 * possible vaules for $what: page-user, message-anon, message-user
	 *
	 * @access public
	 * @static
	 *
	 * @return Bool disabled or not
	 */
	public static function isDisabled( $message, $what = false ) {
		if( !$what ) {
			$return = substr( $message, 0, 9) === "@disabled";
		}
		else {
			if( in_array( $what, array( "page-user", "message-anon", "message-user" ) ) ) {
				$return = false;
			}
		}

		return $return;
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

		parent::__construct();
		$this->mType = "welcome";
		$this->mVisible = false;
		$this->mTTL = 1800;
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

		$this->mTaskID = $params->task_id;
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
