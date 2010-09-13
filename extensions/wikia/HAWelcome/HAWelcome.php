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
	'version' => '0.6',
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
	 *
	 * @param Title $title The title linked to
	 * @param array $params Job parameters (table, start and end page_ids)
	 * @param integer $id job_id
	 */
	public function __construct( $title, $params, $id = 0 ) {
		wfLoadExtensionMessages( "HAWelcome" );
		parent::__construct( "HAWelcome", $title, $params, $id );

		$this->mUserId   = $params[ "user_id" ];
		$this->mUserIP   = $params[ "user_ip" ];
		$this->mUserName = $params[ "user_name" ];
		$this->mAnon     = (bool )$params[ "is_anon" ];
		$this->mSysop    = false;

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
		global $wgUser, $wgTitle, $wgErrorLog;

		wfProfileIn( __METHOD__ );

		$oldValue = $wgErrorLog;
		$wgErrorLog = true;

		/**
		 * overwrite $wgUser for ~~~~ expanding
		 */
		$sysop = trim( wfMsg( "welcome-user" ) );
		if( !in_array( $sysop, array( "@disabled", "-" ) ) ) {
			$tmpUser = $wgUser;
			$wgUser  = User::newFromName( self::WELCOMEUSER );
			$flags = 0;
			$bot_message = trim( wfMsgForContent( "welcome-bot" ) );
			if( ($bot_message == '@bot') || ($wgUser && $wgUser->isAllowed( 'bot' )) ) {
				$flags = EDIT_FORCE_BOT;
			}
			Wikia::log( __METHOD__, "user", $this->mUser->getName() );

			if( $this->mUser && $this->mUser->getName() !== self::WELCOMEUSER && !$wgUser->isBlocked() ) {
				/**
				 * check again if talk page exists
				 */
				$talkPage  = $this->mUser->getUserPage()->getTalkPage();
				Wikia::log( __METHOD__, "talk", $talkPage->getFullUrl() );

				if( $talkPage ) {
					$this->mSysop = $this->getLastSysop();
					$gEG = $this->mSysop->getEffectiveGroups();
					$isSysop = in_array('sysop', $gEG);
					$isStaff = in_array('staff', $gEG);
					unset($gEG);
					$tmpTitle     = $wgTitle;
					$sysopPage    = $this->mSysop->getUserPage()->getTalkPage();
					$signature    = $this->expandSig();

					$wgTitle     = $talkPage;
					$welcomeMsg  = false;
					$talkArticle = new Article( $talkPage, 0 );

					if( ! $talkArticle->exists() ) {
						if( $this->mAnon ) {
							if( $this->isEnabled( "message-anon" ) ) {
								if( $isStaff && !$isSysop ) {
									$key = "welcome-message-anon-staff";
								}
								else {
									$key = "welcome-message-anon";
								}
								$welcomeMsg = wfMsgExt( $key, "parsemag",
								array(
									$this->getPrefixedText(),
									$sysopPage->getPrefixedText(),
									$signature,
									wfEscapeWikiText( $this->mUser->getName() ),
								));
							}
							else {
								Wikia::log( __METHOD__, "talk", "message-anon disabled" );
							}
						}
						else {
							/**
							 * now create user page (if not exists of course)
							 */
							if( $this->isEnabled( "page-user" ) ) {
								$userPage = $this->mUser->getUserPage();
								if( $userPage ) {
									$wgTitle = $userPage;
									$userArticle = new Article( $userPage, 0 );
									Wikia::log( __METHOD__, "userpage", $userPage->getFullUrl() );
									if( ! $userArticle->exists() ) {
										$pageMsg = wfMsg( "welcome-user-page" );
										$userArticle->doEdit( $pageMsg, false, $flags );
									}
								}
								else {
									Wikia::log( __METHOD__, "page", "user page already exists." );
								}
							}
							else {
								Wikia::log( __METHOD__, "page", "page-user disabled" );
							}

							if( $this->isEnabled( "message-user" ) ) {
								if( $isStaff && !$isSysop ) {
									$key = "welcome-message-user-staff";
								}
								else {
									$key = "welcome-message-user";
								}
								$welcomeMsg = wfMsgExt( $key, "parsemag",
								array(
									$this->getPrefixedText(),
									$sysopPage->getPrefixedText(),
									$signature,
									wfEscapeWikiText( $this->mUser->getName() ),
								));
							}
							else {
								Wikia::log( __METHOD__, "talk", "message-user disabled" );
							}
						}
						if( $welcomeMsg ) {
							$wgTitle = $talkPage; /** is it necessary there? **/
							$talkArticle->doEdit( $welcomeMsg, wfMsg( "welcome-message-log" ), $flags );
						}
					}
					$wgTitle = $tmpTitle;
				}
			}

			$wgUser = $tmpUser;
			$wgErrorLog = $oldValue;
		}
		else {
			Wikia::log( __METHOD__, "disabled", $sysop );
		}

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
		global $wgCityId, $wgMemc, $wgLanguageCode;

		wfProfileIn( __METHOD__ );

		/**
		 * maybe already loaded?
		 */
		if( ! $this->mSysop ) {

			$sysop = trim( wfMsgForContent( "welcome-user" ) );
			if( !in_array( $sysop, array( "@disabled", "-" ) ) ) {

				if( in_array( $sysop, array( "@latest", "@sysop" ) ) ) {
					/**
					 * first: check memcache, maybe we have already stored id of sysop
					 */
					$sysopId = $wgMemc->get( wfMemcKey( "last-sysop-id" ) );
					if( $sysopId ) {
						Wikia::log( __METHOD__, "sysop", "Have sysop id from memcached: {$sysopId}" );
						$this->mSysop = User::newFromId( $sysopId );
					}
					else {
						/**
						 * second: check database, could be expensive for database
						 */
						$dbr = wfGetDB( DB_SLAVE );

						/**
						 * get all users which are sysops/sysops or staff or helpers
						 * but not bots
						 *
						 * @todo check $db->makeList( $array )
						 */
						$groups = ($sysop !== "@sysop")
							? array( "ug_group" => array( "staff", "sysop", "helper", "bot" ) )
							: array( "ug_group" => array( "sysop", "bot" ) );

						$bots   = array();
						$admins = array();
						$res = $dbr->select(
							array( "user_groups" ),
							array( "ug_user, ug_group" ),
							$dbr->makeList( $groups, LIST_OR ),
							__METHOD__
						);
						while( $row = $dbr->fetchObject( $res ) ) {
							if( $row->ug_group == "bot" ) {
								$bots[] = $row->ug_user;
							}
							else {
								$admins[] = $row->ug_user;
							}
						}
						$dbr->freeResult( $res );

						/**
						 * remove bots from admins
						 */
						$admins = array( "rev_user" => array_unique( array_diff( $admins, $bots ) ) );
						$row = $dbr->selectRow(
							array( "revision" ),
							array( "rev_user", "rev_user_text"),
							array(
								$dbr->makeList( $admins, LIST_OR ),
								"rev_timestamp > " . $dbr->addQuotes(  $dbr->timestamp( time() - 5184000 ) ) // 60 days ago (24*60*60*60)
							),
							__METHOD__,
							array( "ORDER BY" => "rev_timestamp DESC")
						);
						Wikia::log( __METHOD__, "query", $dbr->lastQuery() );
						if( $row->rev_user ) {
							$this->mSysop = User::newFromId( $row->rev_user );
							$wgMemc->set( wfMemcKey( "last-sysop-id" ), $row->rev_user, 86400 );
						}
					}
				}
				else {
					Wikia::log( __METHOD__, "sysop", "Hardcoded sysop: {$sysop}" );
					$this->mSysop = User::newFromName( $sysop );
				}
			}

			/**
			 * fallback, if still user is uknown we use Wikia user
			 */
			if( $this->mSysop instanceof User && $this->mSysop->getId() ) {
				Wikia::log( __METHOD__, "sysop", "Found sysop: " . $this->mSysop->getName() );
			}
			else {
				$this->mSysop = Wikia::staffForLang( $wgLanguageCode );
				Wikia::log( __METHOD__, "sysop", "Fallback to hardcoded user: " . $this->mSysop->getName() );
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
	public static function revisionInsertComplete( &$revision, $url, $flags ) {
		global $wgUser, $wgCityId, $wgCommandLineMode, $wgSharedDB,
			$wgErrorLog, $wgMemc;

		wfProfileIn( __METHOD__ );

		/**
		 * Do not create task when DB is locked (rt#12229)
		 * Do not create task when we are in $wgCommandLineMode
		 */
		$oldValue = $wgErrorLog;
		$wgErrorLog = true;
		if( !wfReadOnly() && ! $wgCommandLineMode ) {
			wfLoadExtensionMessages( "HAWelcome" );

			/**
			 * Revision has valid Title field but sometimes not filled
			 */
			$Title = $revision->getTitle();
			if( !$Title ) {
				$Title = Title::newFromId( $revision->getPage(), GAID_FOR_UPDATE );
				$revision->setTitle( $Title );
			}

			/**
			 * get groups for user rt#12215
			 */
			$groups = $wgUser->getEffectiveGroups();
			$invalid = array(
				"bot" => true,
				"staff" => true,
				"helper" => true,
				"sysop" => true,
				"bureaucrat" => true,
				"vstf" => true,
			);
			$canWelcome = true;
			foreach( $groups as $group ) {
				if( isset( $invalid[ $group ] ) && $invalid[ $group ] ) {
					$canWelcome = false;
					Wikia::log( __METHOD__, $wgUser->getId(), "Skip welcome, user is at least in group: " . $group );
					break;
				}
			}

			/**
			 * put possible welcomer into memcached, RT#14067
			 */
			if( $wgUser->getId() && self::isWelcomer( $wgUser ) ) {
				$wgMemc->set( wfMemcKey( "last-sysop-id" ), $wgUser->getId(), 86400 );
				Wikia::log( __METHOD__, $wgUser->getId(), "Store possible welcomer in memcached" );
			}

			if( $Title && $canWelcome && !empty( $wgSharedDB ) ) {

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
							$taskId = $Task->createTask( array( "city_id" => $wgCityId ), TASK_QUEUED  );
							Wikia::log( __METHOD__, "task", $taskId );
						}
						else {
							Wikia::log( __METHOD__, "exists", sprintf( "Talk page for user %s already exits", $wgUser->getName() ) );
						}
					}
				}
				else {
					Wikia::log( __METHOD__, "disabled" );
				}
			}
		}
		$wgErrorLog = $oldValue;
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

		// get the welcomer
		$this->mSysop = $this->getLastSysop();

		// backup the current
		$tmpUser = $wgUser;
		// swap in the welcomer (why do we need to do this?)
		$wgUser = $this->mSysop;

		// figure out who/what this welcomer is
		$gEG = $this->mSysop->getEffectiveGroups();
		$isStaff = in_array('staff', $gEG);
		$isSysop = in_array('sysop', $gEG);

		// only build these once, since its used both cases
		$SysopName = wfEscapeWikiText( $this->mSysop->getName() );
		$userLink = sprintf(
			'[[%s:%s|%s]]',
			$wgContLang->getNsText(NS_USER),
			$SysopName,
			$SysopName
			);

		// in cases where user is both staff and sysop, use sysop mode
		if(!$isStaff || $isSysop) {
			$signature = sprintf(
				"-- %s ([[%s:%s|%s]]) %s",
				$userLink,
				$wgContLang->getNsText(NS_USER_TALK),
				$SysopName,
				wfMsg( "talkpagelinktext" ),
				$wgContLang->timeanddate( wfTimestampNow( TS_MW ) )
				);
		} else {
			// $1 = wiki link to user's user: page
			// $2 = plain version of user's name (for future use)
			$signature = wfMsg('staffsig-text', $userLink, $SysopName);
		}

		// restore from backup
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
	 * @access private
	 *
	 * @return Title instance of Title object
	 */
	public function getPrefixedText() {
		return $this->title->getPrefixedText();

		# bad code! it relay that central wikia has blogs activated
		#$oT = ($ns == NS_BLOG_ARTICLE_TALK) ? BlogArticle::commentToUserBlog($this->title) : $this->title;
		#$pText = "";
		#if ($oT instanceof Title) {
		#	$pText = ($ns == NS_BLOG_ARTICLE_TALK) ? $oT->getFullText() : $oT->getPrefixedText();
		#}
		#return $pText;
	}


	/**
	 * check if some (or all) functionality is disabled/enabled
	 *
	 * @param String $what default false
	 *
	 * possible vaules for $what: page-user, message-anon, message-user
	 *
	 * @access public
	 *
	 * @return Bool disabled or not
	 */
	public function isEnabled( $what ) {

		wfProfileIn( __METHOD__ );

		$return = false;
		$message = wfMsgForContent( "welcome-enabled" );
		Wikia::log( __METHOD__, "enabled", $message );
		if( in_array( $what, array( "page-user", "message-anon", "message-user" ) )
			&& strpos( $message, $what  ) !== false ) {
			$return	= true;
		}

		wfProfileOut( __METHOD__ );

		return $return;
	}

	/**
	 * check if user can welcome other users
	 *
	 * @static
	 * @access public
	 *
	 * @param User	$User	instance of User class
	 *
	 * @return boolean	status of operation
	 */
	static public function isWelcomer( &$User ) {

		wfProfileIn( __METHOD__ );

		$sysop  = trim( wfMsg( "welcome-user" ) );
		$groups = $User->getEffectiveGroups();
		$result = false;

		/**
		 * bots can't welcome
		 */
		if( !in_array( "bot", $groups ) ) {
			if( $sysop === "@sysop" ) {
				$result = in_array( "sysop", $groups ) ? true : false;
			}
			else {
				$result =
					in_array( "sysop", $groups ) ||
					in_array( "staff", $groups ) ||
					in_array( "helper", $groups )
						? true : false;
			}
		}
		wfProfileOut( __METHOD__ );

		return $result;
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
