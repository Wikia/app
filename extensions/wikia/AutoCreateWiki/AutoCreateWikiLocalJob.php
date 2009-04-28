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
include_once( $GLOBALS[ "IP" ] . "/includes/JobQueue.php" );
$wgJobClasses[ "ACWLocal" ] = "AutoCreateWikiLocalJob";

/**
 * maintenance script from CheckUser
 */
include_once( $GLOBALS['IP'] . "/extensions/CheckUser/install.inc" );


class AutoCreateWikiLocalJob extends Job {

	private
		$mFounder;

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

		global $wgUser, $wgErrorLog, $wgExtensionMessagesFiles;

		wfProfileIn( __METHOD__ );

		$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = dirname(__FILE__) . "/AutoCreateWiki.i18n.php";
		wfLoadExtensionMessages( "AutoCreateWiki" );

		$wgErrorLog = true;
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

		$this->moveMainPage();
		$this->setWelcomeTalkPage();
		$this->sendWelcomeMail();
		$this->populateCheckUserTables();
		$this->protectKeyPages();

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * inherited "insert" function add job to current database, for this job
	 * we need to add job to newly created wiki
	 *
	 * @param Integer $city_id	wiki identifier in city_list table
	 */
	public function WFinsert( $city_id, $database = false ) {

		global $wgDBname, $wgErrorLog;

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

			$dbw = wfGetDB( DB_MASTER );
			$dbw->selectDB( $database );

			if ( $this->removeDuplicates ) {
				$res = $dbw->select( 'job', array( '1' ), $fields, __METHOD__ );
				if ( $dbw->numRows( $res ) ) {
					return;
				}
			}
			$fields['job_id'] = $dbw->nextSequenceValue( 'job_job_id_seq' );
			$dbw->insert( 'job', $fields, __METHOD__ );

			/**
			 * we need to commit before switching databases
			 */
			$dbw->commit();
			$dbw->selectDB( $wgDBname );
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
			$wikiaName = isset( $this->mParams[ "title" ] )
				? $this->mParams[ "title" ]
				: WikiFactory::getVarValueByName( "wgSitename", $this->mParams[ "city_id"], true );
			$wikiaLang = isset( $this->mParams[ "language" ] )
				? $this->mParams[ "language" ]
				: WikiFactory::getVarValueByName( "wgLanguageCode", $this->mParams[ "city_id"] );

			Wikia::log( __METHOD__, "vars", "sitename: {$wikiaName}; language: {$wikiaLang}" );

			/**
			 * set apropriate staff member
			 */
			$wgUser = Wikia::staffForLang( $wikiaLang );
			$wgUser = ( $wgUser instanceof User ) ? $wgUser : User::newFromName( "Angela" );

			$talkParams = array(
				$this->mFounder->getName(),
				$wgUser->getName(),
				$wgUser->getRealName(),
				$wikiaName
			);

			$talkBody = false;
			if (! empty( $wikiaLang ) ) {
				/**
				 * custom lang translation
				 */
				$talkBody = wfMsgExt( "createwiki_welcometalk", array( 'language' => $wikiaLang ), $talkParams );
			}

			if( ! $talkBody ) {
				/**
				 * wfMsgExt should always return message, but just in case...
				 */
				$talkBody = wfMsg( "createwiki_welcometalk", $talkParams );
			}

			/**
			 * and now create talk article
			 */
			$talkArticle = new Article( $talkPage, 0 );
			if( !$talkArticle->exists() ) {
				$talkArticle->doEdit( $talkBody,  wfMsg( "autocreatewiki-welcometalk-log" ), EDIT_FORCE_BOT );
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
		global $wgSitename, $wgUser;

		$source = wfMsgForContent('Mainpage');
		$target = $wgSitename;

		$sourceTitle = Title::newFromText( $source );
		if( !$sourceTitle ) {
		    Wikia::log( __METHOD__, "err", "Invalid page title: {$source}" );
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
						$mwMainPageArticle->doEdit( $targetTitle->getText(), "SEO", EDIT_MINOR | EDIT_FORCE_BOT );

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
	}

	/**
	 * protect key pages
	 *
	 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
	 */
	private function protectKeyPages() {
		global $wgUser, $wgWikiaKeyPages, $wgMessageCache;

		$wgUser = User::newFromName( "CreateWiki script" );
		if ( $wgUser->isAnon() ) {
			$wgUser->addToDatabase();
		}
		if(	empty($wgWikiaKeyPages ) ) {
			$wgWikiaKeyPages = array ( 'Image:Wiki.png', 'Image:Wiki_wide.png', 'Image:Favicon.ico' );
		}

		/**
		 * define restriction level and duration
		 */
		$restrictions[ "edit"   ] = 'sysop';
		$restrictions[ "move"   ] = 'sysop';
		$restrictions[ "create" ] = 'sysop';
		$titleRestrictions = 'sysop';
		$expiry = Block::infinity();

		/**
		 *  define reason msg and fetch it
		 */
		$wgMessageCache->addMessages( array ('createwiki-protect-reason' => 'Part of the official interface') );
		$reason = wfMsgForContent('createwiki-protect-reason');

		$wgUser->addGroup( 'staff' );
		$wgUser->addGroup( 'bot' );

		foreach( $wgWikiaKeyPages as $pageName ) {
			$title = Title::newFromText( $pageName );
			$article = new Article( $title );

			if ( $article->exists() ) {
				$cascade = 0;
				$ok = $article->updateRestrictions( $restrictions, $reason, $cascade, $expiry );
			}
			else {
				$ok = $title->updateTitleProtection( $titleRestrictions, $reason, $expiry );
			}

			if ( $ok ) {
				Wikia::log( __METHOD__, "ok", "Protected key page: $pageName" );
			}
			else {
				Wikia::log( __METHOD__, "err", "Failed while trying to protect $pageName" );
			}
		}
		$wgUser->removeGroup( "staff" );
		$wgUser->removeGroup( "bot" );
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
		global $wgUser, $wgPasswordSender;

		$oReceiver = $this->mFounder;
		$sServer = sprintf("http://%s.wikia.com", $this->mParams["subdomain"] );

		/**
		 * set apropriate staff member
		 */
		$oStaffUser = Wikia::staffForLang( $this->mParams[ "language" ] );
		$oStaffUser = ( $oStaffUser instanceof User ) ? $oStaffUser : User::newFromName( "Angela" );

		$sFrom = new MailAddress( $wgPasswordSender, "The Wikia Community Team" );
		$sTo = $oReceiver->getEmail();

		$aBodyParams = array (
			$sServer,
			$oReceiver->getName(),
			$oStaffUser->getRealName(),
			htmlspecialchars( $oStaffUser->getName() ),
			htmlspecialchars( $oReceiver->getTalkPage()->getFullURL() ),
		);

		$sBody = $sSubject = null;
		if ( !empty( $this->mParams['language'] ) ) {
			// custom lang translation
			$sBody = wfMsgExt("createwiki_welcomebody",
				array( 'language' => $this->mParams['language'] ),
				$aBodyParams
			);
			$sSubject = wfMsgExt("createwiki_welcomesubject",
				array( 'language' => $this->mParams['language'] ),
				array( $this->mParams[ "title" ] )
			);
		}

		/**
		 * fallback to english
		 */
		if( empty( $sBody ) ) {
			$sBody = wfMsg( "createwiki_welcomebody", $aBodyParams );
		}
		if( empty( $sSubject ) ) {
			$sSubject = wfMsg( "createwiki_welcomesubject", array( $this->mParams[ 'title' ] ) );
		}

		if ( !empty($sTo) ) {
			$status = $oReceiver->sendMail( $sSubject, $sBody, $sFrom );
			Wikia::log( __METHOD__, "mail", "Mail to founder {$sTo} sent." );
		} else {
			Wikia::log( __METHOD__, "mail", "Founder email is not set. Welcome email is not sent" );
		}
	}
}
