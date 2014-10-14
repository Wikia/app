<?php

/**
 * AutoCreateWikiCentralJob -- Welcome user after first edit
 *
 * @file
 * @ingroup JobQueue
 *
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @date 2009-03-12
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * sometimes class Job is uknown in this point
 */
include_once( "$IP/includes/job/JobQueue.php" );
$wgJobClasses[ "ACWLocal" ] = "AutoCreateWikiLocalJob";

/**
 * maintenance script from CheckUser
 */
include_once( "$IP/extensions/CheckUser/install.inc" );


class AutoCreateWikiLocalJob extends Job {

	const DEFAULT_USER   = 'Default';
	const REMINDER_URL   = "http://theschwartz/function/TheSchwartz::Worker::URL";
	const REMINDER_DELAY =  172800; # 48h

	/* @var User */
	private $mFounder;
	public $wikiaName, $wikiaLang;

	/**
	 * constructor
	 *
	 * @access public
	 */
	public function __construct( $title, $params, $id = 0 ) {
		parent::__construct( "ACWLocal", $title, $params, $id );
		$this->mParams = $params;
	}

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function run() {

		global $wgUser, $wgErrorLog, $wgExtensionMessagesFiles, $wgInternalServer, $wgServer;

		wfProfileIn( __METHOD__ );

		/**
		 * @see SquidUpdate::expand
		 */
		$wgInternalServer = $wgServer;

		$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = dirname(__FILE__) . "/AutoCreateWiki.i18n.php";
		$wgErrorLog = false;

		/**
		 * setup founder user
		 */
		if( $this->mParams[ "founder"] ) {
			$this->mFounder = User::newFromId( $this->mParams[ "founder"] );
			$this->mFounder->load();
		}
		if( ! $this->mFounder ) {
			Wikia::log( __METHOD__, "user", "Cannot load user with user_id = {$this->mParams[ "founder"]}" );
			if( !empty( $this->mParams[ "founder-name"] ) ) {
				$this->mFounder = User::newFromName( $this->mParams[ "founder-name"] );
				$this->mFounder->load();
			}
		}
		$wgUser = User::newFromName( "CreateWiki script" );

		/**
		 * main page should be move in first stage of create wiki, but sometimes
		 * is too early for that. This is fallback function
		 */

		$this->wikiaName = isset( $this->mParams[ "title" ] )
			? $this->mParams[ "title" ]
			: WikiFactory::getVarValueByName( "wgSitename", $this->mParams[ "city_id"], true );
		$this->wikiaLang = isset( $this->mParams[ "language" ] )
			? $this->mParams[ "language" ]
			: WikiFactory::getVarValueByName( "wgLanguageCode", $this->mParams[ "city_id"], true );


		$this->moveMainPage();
		$this->changeStarterContributions();
		$this->setWelcomeTalkPage();
		$this->sendWelcomeMail();
		$this->populateCheckUserTables();
		$this->protectKeyPages();
		$this->queueReminderMail();
		$this->sendRevisionToScribe();
		$this->addStarterImagesToUploadLog();

		/**
		 * different things for different types
		 */
		switch( $this->mParams[ "type" ] ) {
			case "answers":
				$this->copyDefaultAvatars();
				break;
		}

		wfRunHooks( 'CreateWikiLocalJob-complete', array( &$this->mParams ) );

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * inherited "insert" function add job to current database, for this job
	 * we need to add job to newly created wiki
	 *
	 * @param integer $city_id	wiki identifier in city_list table
	 * @param string  $database target database name
	 */
	public function WFinsert( $city_id, $database = false ) {

		global $wgErrorLog;

		/**
		 * we can take local database from city_id in params array
		 */
		$oldValue = $wgErrorLog;
		$wgErrorLog = true;
		Wikia::log( __METHOD__ , "id", $city_id );

		if( !$database ) {
			$database = Wikifactory::IdtoDB( $city_id );
		}

		Wikia::log( __METHOD__ , "db", $database );
		if( $database ) {
			$fields = $this->insertFields();

			$dbw_local = wfGetDB( DB_MASTER, array(), $database );

			if ( $this->removeDuplicates ) {
				$res = $dbw_local->select( 'job', array( '1' ), $fields, __METHOD__ );
				if ( $dbw_local->numRows( $res ) ) {
					return;
				}
			}
			$fields['job_id'] = $dbw_local->nextSequenceValue( 'job_job_id_seq' );
			$dbw_local->insert( 'job', $fields, __METHOD__ );

			/**
			 * we need to commit before switching databases
			 */
			$dbw_local->commit();
		}
		$wgErrorLog = $oldValue;
	}

	/**
	 * setWelcomeTalkPage
	 *
	 * @access private
	 *
	 * @return boolean status
	 */
	private function setWelcomeTalkPage() {
		global $wgUser;

		Wikia::log( __METHOD__, "talk", "Setting welcome talk page on new wiki" );

		$talkPage = $this->mFounder->getTalkPage();
		if( $talkPage ) {
			Wikia::log( __METHOD__, "talk", $talkPage->getFullUrl() );

			Wikia::log( __METHOD__, "vars", "sitename: {$this->wikiaName}; language: {$this->wikiaLang}" );

			/**
			 * set apropriate staff member
			 */
			$wgUser = Wikia::staffForLang( $this->wikiaLang );
			$wgUser = ( $wgUser instanceof User ) ? $wgUser : User::newFromName( "Sannse" );

			$talkParams = array(
				$this->mFounder->getName(),
				$wgUser->getName(),
				$wgUser->getRealName(),
				$this->wikiaName
			);

			$talkBody = false;
			if (! empty( $this->wikiaLang ) ) {
				/**
				 * custom lang translation
				 */
				$talkBody = wfMsgExt( "autocreatewiki-welcometalk", array( 'language' => $this->wikiaLang ), $talkParams );
			}

			if( ! $talkBody ) {
				/**
				 * wfMsgExt should always return message, but just in case...
				 */
				$talkBody = wfMsg( "autocreatewiki-welcometalk", $talkParams );
			}

			/**
			 * and now create talk article
			 */
			$talkArticle = new Article( $talkPage, 0 );
			if( !$talkArticle->exists() ) {
				$talkArticle->doEdit( $talkBody,  wfMsg( "autocreatewiki-welcometalk-log" ), EDIT_SUPPRESS_RC | EDIT_MINOR | EDIT_FORCE_BOT );
			}
			else {
				Wikia::log( __METHOD__, "talkpage", sprintf("%s already exists", $talkPage->getFullURL()) );
			}
		}
		else {
			Wikia::log( __METHOD__, "error", "Can't take talk page for user " . $this->mFounder->getId() );
		}
		return true;
	}

	/**
	 * move main page to SEO-friendly name
	 */
	private function moveMainPage() {
		global $wgSitename, $parserMemc, $wgContLanguageCode;

		$source = wfMsgForContent('Mainpage');
		$target = $wgSitename;

		$sourceTitle = Title::newFromText( "Main_Page" );
		if( !$sourceTitle ) {
			Wikia::log( __METHOD__, "err", "Invalid page title: {$source} and Main_page" );
			return;
		}

		$mainArticle = new Article( $sourceTitle, 0 );
		if( $mainArticle->exists() ) {
			/**
			 * check target title
			 */
			$targetTitle = Title::newFromText( $target );
			if( $targetTitle ) {
				if( $sourceTitle->getPrefixedText() !== $targetTitle->getPrefixedText() ) {
					Wikia::log( __METHOD__, "move", $sourceTitle->getPrefixedText() . ' --> ' . $targetTitle->getPrefixedText() );
					$err = $sourceTitle->moveTo( $targetTitle, false, "SEO" );
					if( $err !== true ) {
						Wikia::log( __METHOD__, "move", "Moving FAILED" );
					}
					else {
						/**
						 * fill Mediawiki:Mainpage with new title
						 */
						$mwMainPageTitle = Title::newFromText( "Mainpage", NS_MEDIAWIKI );
						$mwMainPageArticle = new Article( $mwMainPageTitle, 0 );
						$mwMainPageArticle->doEdit( $targetTitle->getText(), "SEO", EDIT_SUPPRESS_RC | EDIT_MINOR | EDIT_FORCE_BOT );
						$mwMainPageArticle->doPurge();

						Wikia::log( __METHOD__, "move", "Page moved" );

						/**
						 * also move associated talk page if it exists
						 */
						$sourceTalkTitle = $sourceTitle->getTalkPage();
						$targetTalkTitle = $targetTitle->getTalkPage();
						if ( $sourceTalkTitle instanceof Title && $sourceTalkTitle->exists() && $targetTalkTitle instanceof Title ) {
							Wikia::log( __METHOD__, "move", $sourceTalkTitle->getPrefixedText() . ' --> ' . $targetTalkTitle->getPrefixedText() );
							$err = $sourceTalkTitle->moveTo( $targetTitle->getTalkPage(), false, "SEO");
							if ( $err === true ) {
									Wikia::log( __METHOD__, "move", "Moved talk page" );
							} else {
									Wikia::log( __METHOD__, "move", "Found talk page but moving FAILED" );
							}
						}
					}
				}
				else {
					Wikia::log( __METHOD__, "move", "source {$source} and target {$target} are the same" );
				}
			}
		}

		/**
		 * clear skin cache for rt#63874
		 * @todo establish what $code is exactly in this case
		 */
		$parserMemc->delete( wfMemcKey( 'sidebar',  $wgContLanguageCode ) );

		$parserMemc->delete( wfMemcKey( 'quartzsidebar' ) );
		$parserMemc->delete( wfMemcKey( 'navlinks' ) );
		$parserMemc->delete( wfMemcKey( 'MonacoData' ) );
		$parserMemc->delete( wfMemcKey( 'MonacoDataOld' ) );
	}

	/**
	 * protect key pages
	 *
	 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
	 */
	private function protectKeyPages() {
		global $wgUser, $wgWikiaKeyPages;

		$wgUser = User::newFromName( "CreateWiki script" );
		if ( $wgUser->isAnon() ) {
			$wgUser->addToDatabase();
		}
		if(	empty($wgWikiaKeyPages ) ) {
			$wgWikiaKeyPages = array ( 'File:Wiki.png', 'File:Favicon.ico' );
		}

		/**
		 * define restriction level and duration
		 */
		$restrictions[ "edit"   ] = 'sysop';
		$restrictions[ "move"   ] = 'sysop';
		$restrictions[ "create" ] = 'sysop';
		$titleRestrictions = 'sysop';
		$expiry_string = Block::infinity();
		$expiry_array = array('edit' => $expiry_string, 'move' => $expiry_string);

		/**
		 *  define reason msg and fetch it
		 */
		$reason = wfMsgForContent('autocreatewiki-protect-reason');

		$wgUser->addGroup( 'staff' );

		foreach( $wgWikiaKeyPages as $pageName ) {
			$title = Title::newFromText( $pageName );
			$article = new Article( $title );

			if ( $article->exists() ) {
				$cascade = 0;
				$ok = $article->updateRestrictions( $restrictions, $reason, $cascade, $expiry_array );
			}
			else {
				$ok = $title->updateTitleProtection( $titleRestrictions, $reason, $expiry_string );
			}

			if ( $ok ) {
				Wikia::log( __METHOD__, "ok", "Protected key page: $pageName" );
			}
			else {
				Wikia::log( __METHOD__, "err", "Failed while trying to protect $pageName" );
			}
		}
		$wgUser->removeGroup( "staff" );
	}


	/**
	 * tables are created in first step. there we only fill them
	 */
	private function populateCheckUserTables() {
		$dbw = wfGetDB( DB_MASTER );
		create_cu_changes( $dbw, true );
		create_cu_log( $dbw );
	}

	/**
	 * sendWelcomeMail
	 *
	 * sensd welcome email to founder (if founder has set email address)
	 *
	 * @author eloy@wikia-inc.com
	 * @author adi@wikia-inc.com
	 * @author moli@wikia-inc.com
	 * @access private
	 *
	 * @return boolean status
	 */
	private function sendWelcomeMail() {
		global $wgPasswordSender, $wgWikiaEnableFounderEmailsExt;

		if(!empty($wgWikiaEnableFounderEmailsExt)) {
			// skip this step when FounderEmails extension is enabled
			Wikia::log( __METHOD__, "mail", "FounderEmails extension is enabled. Welcome email is not sent" );
			return true;
		}

		$oReceiver = $this->mFounder;
		$sServer = $this->mParams["url"];

		/**
		 * set apropriate staff member
		 */
		$oStaffUser = Wikia::staffForLang( $this->mParams[ "language" ] );
		$oStaffUser = ( $oStaffUser instanceof User ) ? $oStaffUser : User::newFromName( "Sannse" );

		$sFrom = new MailAddress( $wgPasswordSender, "The Wikia Community Team" );
		$sTo = $oReceiver->getEmail();

		$aBodyParams = array (
			$sServer,
			$oReceiver->getName(),
			$oStaffUser->getRealName(),
			htmlspecialchars( $oStaffUser->getTitleKey() ),
			htmlspecialchars( $oReceiver->getTalkPage()->getFullURL() ),
		);

		$sBody = $sBodyHTML = $sSubject = null;

		$language = empty($this->mParams['language']) ? 'en' : $this->mParams['language'];
		list($sBody, $sBodyHTML) = wfMsgHTMLwithLanguage('autocreatewiki-welcomebody', $language, array(), $aBodyParams);

		$sSubject = wfMsgExt('autocreatewiki-welcomesubject',
			array( 'language' => $language ),
			array( $this->mParams[ "title" ] )
		);

		if ( !empty($sTo) ) {
			$status = $oReceiver->sendMail( $sSubject, $sBody, $sFrom, null, 'AutoCreateWiki', $sBodyHTML );
			if( $status ) {
				Wikia::log( __METHOD__, "mail", "Mail to founder {$sTo} sent." );
			}
		} else {
			Wikia::log( __METHOD__, "mail", "Founder email is not set. Welcome email is not sent" );
		}
	}

	/**
	 * this method updates rev_user and rev_user_text for language starters
	 * update is performed on local (freshly created) database
	 *
	 * @access private
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 */
	private function changeStarterContributions( ) {

		wfProfileIn( __METHOD__ );

		/**
		 * check if we are connected to local db
		 *
		 */
		$contributor = User::newFromName(self::DEFAULT_USER);

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			"revision",
			array(
				"rev_user"      => $contributor->getId(),
				"rev_user_text" => $contributor->getName()
			),
			'*', /* mean all */
			__METHOD__
		);
		$rows = $dbw->affectedRows();
		Wikia::log( __METHOD__, "info", "change rev_user and rev_user_text in revisions: {$rows} rows" );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * send http post to TheSchwartz which queue reminder call for 48hours.
	 * TheSchwartz will call api.php?method=awcreminder
	 */
	private function queueReminderMail() {
		global $wgServer, $wgTheSchwartzSecretToken, $wgWikiaEnableFounderEmailsExt;

		if(!empty($wgWikiaEnableFounderEmailsExt)) {
			// skip this step when FounderEmails extension is enabled
			return true;
		}

		$backurl = sprintf( "%s/api.php?action=awcreminder&user_id=%d&token=%s",
			$wgServer, $this->mFounder->getId(), $wgTheSchwartzSecretToken );

		Wikia::log( __METHOD__, "info", "Queue reminder email $backurl" );

		Http::post( self::REMINDER_URL, array (
			CURLOPT_POSTFIELDS => array (
				"theschwartz_run_after" => time() + self::REMINDER_DELAY,
				"url" => $backurl
			),
			CURLOPT_PROXY => "127.0.0.1:6081",
			'timeout' => 'default'
		));
	}

	/**
	 * some wikis have social tools enabled, they demand default avatars
	 *
	 * TODO: Fixme... the NY Social Tools have been deleted.  This function and any calls
	 * to it can _PROBABLY_ be deleted.  UserMasthead or something might need default avatars though.
	 *
	 * @access private
	 */
	private function copyDefaultAvatars() {
		global $wgUploadDirectory;

		wfProfileIn( __METHOD__ );

		/**
		 * avatars folder
		 */
		$target = "{$wgUploadDirectory}/avatars";
		wfMkdirParents( $target );
		if( is_dir( $target ) ) {
			wfShellExec("/bin/cp -af /images/a/answers/images/avatars/default* {$target}/");
			Wikia::log( __METHOD__, "info", "copy default avatars to {$target}" );
		}
		else {
			Wikia::log( __METHOD__, "error", "Cannot create {$target} folder" );
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * send pages from starters to scribe
	 *
	 * @access private
	 * @author Piotr Molski (moli)
	 *
	 */
	private function sendRevisionToScribe( ) {
		global $wgEnableScribeNewReport;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );
		$pages = array();
		$oRes = $dbr->select(
			array( 'revision' ),
			array( 'rev_page as page_id, rev_id, rev_user' ),
			array( 'rev_page > 0' ),
			__METHOD__,
			array( 'ORDER BY' => 'rev_id' )
		);
		$loop = 0;
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			# article
			$oArticle = Article::newFromID($oRow->page_id);
			# user
			$oUser = User::newFromId($oRow->rev_user);
			# revision
			$oRevision = Revision::newFromId($oRow->rev_id);
			if ( $wgEnableScribeNewReport ) {
				$key = ( isset($pages[$oRow->page_id]) ) ? 'edit' : 'create';
				$oScribeProducer = F::build( 'ScribeEventProducer', array( 'key' => $key, 'archive' => 0 ) );
				if ( is_object( $oScribeProducer ) ) {
					if ( $oScribeProducer->buildEditPackage( $oArticle, $oUser, $oRevision ) ) {
						$oScribeProducer->sendLog();
					}
				}
			} else {
				$flags = "";
				# status - new or edit
				$status = Status::newGood( array() );
				# check is new
				$status->value['new'] = ( isset($pages[$oRow->page_id]) ? false : true );
				# call function
				$archive = 0;

				ScribeProducer::saveComplete( $oArticle, $oUser, null, null, null, $archive, null, $flags, $oRevision, $status, 0 );
			}

			$pages[$oRow->page_id] = $oRow->rev_id;
			$loop++;
		}

		Wikia::log( __METHOD__, "info", "send starter revisions to scribe: {$loop} rows" );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * log starter images to upload_log table
	 *
	 * @access private
	 * @author Piotr Molski (moli)
	 *
	 */
	private function addStarterImagesToUploadLog( ) {
		global $wgEnableUploadInfoExt;
		wfProfileIn( __METHOD__ );

		if ( empty($wgEnableUploadInfoExt) ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		$files = array("Wiki.png", "Favicon.ico");
		$dbr = wfGetDB( DB_SLAVE );
		$oRes = $dbr->select(
			array( 'page' ),
			array( 'page_title' ),
			array( 'page_namespace' => NS_IMAGE ),
			__METHOD__
		);
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			if ( !in_array($oRow->page_title, $files) ) {
				$files[] = $oRow->page_title;
			}
		}
		$dbr->freeResult( $oRes );

		$loop = 0;
		foreach ( $files as $image ) {
			$oTitle = Title::newFromText($image, NS_IMAGE);
			$file = wfLocalFile( $oTitle );
			if ( is_object($file) ) {
				# add to upload_log
				UploadInfo::log( $oTitle, $file->getFullPath(), $file->getRel(), "", "u" );
				$loop++;
			}
		}

		Wikia::log( __METHOD__, "info", "added {$loop} images to upload_log table" );

		wfProfileOut( __METHOD__ );
	}
}
