<?php
/**
 * CreateNewWikiTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

use Wikia\Tasks\Tasks\BaseTask;

include_once( "$IP/extensions/CheckUser/install.inc" );

class CreateNewWikiTask extends BaseTask {
	const DEFAULT_USER = 'Default';

	/** @var User */
	private $founder;

	private $wikiName;

	private $wikiLang;

	public function init() {
		parent::init();

		$this->title = Title::newFromText( NS_MAIN, "Main" );
	}

	public function postCreationSetup( $params ) {
		global $wgUser, $wgErrorLog, $wgDebugLogFile, $wgServer, $wgInternalServer;

		$wgServer = rtrim( $params->url, '/' );
		$wgInternalServer = $wgServer;

		$debugLogFile = $wgDebugLogFile;
		$wgDebugLogFile = 'php://stdout';
		$wgErrorLog = false;

		if ( $params->founderId ) {
			Wikia::log( __METHOD__, 'user', "Loading user with user id = {$params->founderId}" );
			$this->founder = User::newFromId( $params->founderId );
			$this->founder->load();
		} else {
			Wikia::log( __METHOD__, 'user', "Founder user_id is unknown" );
		}

		if ( !$this->founder || $this->founder->isAnon() ) {
			Wikia::log( __METHOD__, 'user', "Cannot load user with user_id = {$params->founderId}" );
			if ( !empty( $params->founderName ) ) {
				$this->founder = User::newFromName( $params->founderName );
				$this->founder->load();
			}
		}

		if ( !$this->founder || $this->founder->isAnon() ) {
			global $wgExternalAuthType;
			if ( $wgExternalAuthType ) {
				$extUser = ExternalUser::newFromName( $params->founderName );
				if ( is_object( $extUser ) ) {
					$extUser->linkToLocal( $extUser->getId() );
				}
			}
		}

		$wgUser = User::newFromName( 'CreateWiki script' );

		$this->wikiName = isset( $params->sitename ) ? $params->sitename : WikiFactory::getVarValueByName( 'wgSitename', $params->city_id, true );
		$this->wikiLang = isset( $params->language ) ? $params->language : WikiFactory::getVarValueByName( 'wgLanguageCode', $params->city_id );

		$this->moveMainPage();
		$this->changeStarterContributions( $params );
		$this->setWelcomeTalkPage();
		$this->populateCheckUserTables();
		$this->protectKeyPages();
		$this->sendRevisionToScribe();

		$hookParams = [ 'title' => $params->sitename, 'url' => $params->url, 'city_id' => $params->city_id ];

		if ( empty( $params->disableCompleteHook ) ) {
			wfRunHooks( 'CreateWikiLocalJob-complete', array( $hookParams ) );
		}

		$wgDebugLogFile = $debugLogFile;

		return true;
	}

	public function maintenance( $server ) {
		global $wgCityId, $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/update.php --server={$server} --quick --nopurge --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
		$this->log( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->log( $retval );

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/initStats.php --server={$server} --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
		$this->log( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->log( $retval );

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/refreshLinks.php --server={$server} --new-only --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
		$this->log( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->log( $retval );

		$this->log( "Remove edit lock" );
		$variable = WikiFactory::getVarByName( 'wgReadOnly', $wgCityId );
		if ( isset( $variable->cv_variable_id ) ) {
			WikiFactory::removeVarById( $variable->cv_variable_id, $wgCityId );
			WikiFactory::clearCache( $wgCityId );
		}

		$dbname = WikiFactory::IDtoDB( $wgCityId );
		$cmd = sprintf( "perl /usr/wikia/backend/bin/scribe/events_local_users.pl --usedb={$dbname} " );
		$this->log( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->log( $retval );

		$wgMemc = wfGetMainCache();
		$wgMemc->delete( WikiFactory::getVarsKey( $wgCityId ) );
	}

	/**
	 * move main page to SEO-friendly name
	 */
	private function moveMainPage() {
		global $wgSitename, $parserMemc, $wgContLanguageCode;

		$source = wfMsgForContent( 'Mainpage' );
		$target = $wgSitename;

		$sourceTitle = Title::newFromText( $source );
		if ( !$sourceTitle ) {
			$sourceTitle = Title::newFromText( "Main_Page" );
			if ( !$sourceTitle ) {
				Wikia::log( __METHOD__, "err", "Invalid page title: {$source} and Main_page" );

				return;
			}
		}

		$mainArticle = new Article( $sourceTitle, 0 );
		if ( $mainArticle->exists() ) {
			/**
			 * check target title
			 */
			$targetTitle = Title::newFromText( $target );
			if ( $targetTitle ) {
				if ( $sourceTitle->getPrefixedText() !== $targetTitle->getPrefixedText() ) {
					Wikia::log( __METHOD__, "move", $sourceTitle->getPrefixedText() . ' --> ' . $targetTitle->getPrefixedText() );
					$err = $sourceTitle->moveTo( $targetTitle, false, "SEO" );
					if ( $err !== true ) {
						Wikia::log( __METHOD__, "move", "Moving FAILED" );
					} else {
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
							$err = $sourceTalkTitle->moveTo( $targetTitle->getTalkPage(), false, "SEO" );
							if ( $err === true ) {
								Wikia::log( __METHOD__, "move", "Moved talk page" );
							} else {
								Wikia::log( __METHOD__, "move", "Found talk page but moving FAILED" );
							}
						}
					}
				} else {
					Wikia::log( __METHOD__, "move", "source {$source} and target {$target} are the same" );
				}
			}
		}

		/**
		 * clear skin cache for rt#63874
		 *
		 * @todo establish what $code is exactly in this case
		 */
		$parserMemc->delete( wfMemcKey( 'sidebar', $wgContLanguageCode ) );

		$parserMemc->delete( wfMemcKey( 'quartzsidebar' ) );
		$parserMemc->delete( wfMemcKey( 'navlinks' ) );
		$parserMemc->delete( wfMemcKey( 'MonacoData' ) );
		$parserMemc->delete( wfMemcKey( 'MonacoDataOld' ) );
	}

	/**
	 * this method updates rev_user and rev_user_text for language starters
	 * update is performed on local (freshly created) database
	 */
	private function changeStarterContributions( $params ) {
		$dbw = wfGetDB( DB_MASTER );
		$contributor = User::newFromName( self::DEFAULT_USER );

		/**
		 * BugId:15644 - We want to change contributions only for
		 * revisions created during the starter import - (timestamp not
		 * greater than the timestamp of the latest starter revision.
		 */
		$sCondsRev = array();
		$updateSql = ( new WikiaSQL() )
			->UPDATE( 'revision' )
			->SET( 'rev_user', $contributor->getId() )
			->SET( 'rev_user_text', $contributor->getName() )
			->SET( 'rev_timestamp = date_format(now(), "%Y%m%d%H%i%S")' );

		/**
		 * determine the timestamp of the latest starter revision
		 */
		if ( !empty( $params->sDbStarter ) ) {
			$starterDb = wfGetDb( DB_SLAVE, array(), $params->sDbStarter );

			if ( is_object( $starterDb ) ) {
				( new WikiaSQL() )
					->SELECT( 'max(rev_timestamp)' )->AS_( 'rev_timestamp' )
					->FROM( 'revision' )
					->run( $starterDb, function ( ResultWrapper $res ) use ( $updateSql ) {
						$row = $res->fetchObject();

						if ( $row ) {
							$updateSql->WHERE( 'rev_timestamp' )->LESS_THAN_OR_EQUAL( $row->rev_timestamp );
						}

						return;
					} );

				$starterDb->close();
			}
		}

		Wikia::log( __METHOD__, 'info', "about to change rev_user, rev_user_text and rev_timestamp in revisions older than {$sCondsRev}" );

		$updateSql->run( $dbw );
		$rows = $dbw->affectedRows();

		Wikia::log( __METHOD__, "info", "change rev_user and rev_user_text in revisions: {$rows} rows" );
	}

	/**
	 * setWelcomeTalkPage
	 *
	 * @return boolean status
	 */
	private function setWelcomeTalkPage() {
		global $wgUser, $wgEnableWallExt;
		$saveUser = $wgUser;

		Wikia::log( __METHOD__, "talk", "Setting welcome talk page on new wiki or Wall" );

		Wikia::log( __METHOD__, "vars", "sitename: {$this->wikiName}; language: {$this->wikiLang}" );
		/**
		 * set apropriate staff member
		 */
		$wgUser = Wikia::staffForLang( $this->wikiLang );
		$wgUser = ( $wgUser instanceof User ) ? $wgUser : User::newFromName( "Angela" );

		$talkParams = array( $this->founder->getName(), $wgUser->getName(), $wgUser->getRealName(), $this->wikiName );

		$wallTitle = false;
		if ( !empty( $this->wikiLang ) ) {
			$wallTitle = wfMsgExt( "autocreatewiki-welcometalk-wall-title", array( 'language' => $this->wikiLang ) );
		}

		if ( !$wallTitle ) {
			$wallTitle = wfMsg( "autocreatewiki-welcometalk-wall-title" );
		}

		if ( !empty( $wgEnableWallExt ) ) {
			$msg = "autocreatewiki-welcometalk-wall";
		} else {
			$msg = "autocreatewiki-welcometalk";
		}

		$talkBody = false;
		if ( !empty( $this->wikiLang ) ) {
			/**
			 * custom lang translation
			 */
			$talkBody = wfMsgExt( $msg, array( 'language' => $this->wikiLang ), $talkParams );
		}

		if ( !$talkBody ) {
			/**
			 * wfMsgExt should always return message, but just in case...
			 */
			$talkBody = wfMsg( $msg, $talkParams );
		}

		if ( !empty( $wgEnableWallExt ) ) {
			$wallMessage = WallMessage::buildNewMessageAndPost( $talkBody, $this->founder->getName(), $wgUser, $wallTitle,
				false, array(), true, false );
			if ( $wallMessage === false ) {
				return false;
			}

			Wikia::log( __METHOD__, "wall", $this->founder->getName() );

			return true;
		}

		$talkPage = $this->founder->getTalkPage();
		if ( $talkPage ) {
			Wikia::log( __METHOD__, "talk", $talkPage->getFullUrl() );
			/**
			 * and now create talk article
			 */
			$talkArticle = new Article( $talkPage, 0 );
			if ( !$talkArticle->exists() ) {
				$talkArticle->doEdit( $talkBody, wfMsg( "autocreatewiki-welcometalk-log" ), EDIT_SUPPRESS_RC | EDIT_MINOR | EDIT_FORCE_BOT );
			} else {
				Wikia::log( __METHOD__, "talkpage", sprintf( "%s already exists", $talkPage->getFullURL() ) );
			}
		} else {
			Wikia::log( __METHOD__, "error", "Can't take talk page for user " . $this->founder->getId() );
		}
		$wgUser = $saveUser; // Restore user object after creating talk message
		return true;
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
		if ( empty( $wgWikiaKeyPages ) ) {
			$wgWikiaKeyPages = array( 'File:Wiki.png', 'File:Favicon.ico' );
		}

		/**
		 * define restriction level and duration
		 */
		$restrictions[ "edit" ] = 'sysop';
		$restrictions[ "move" ] = 'sysop';
		$restrictions[ "create" ] = 'sysop';
		$titleRestrictions = 'sysop';
		$expiry_string = Block::infinity();
		$expiry_array = array( 'edit' => $expiry_string, 'move' => $expiry_string );

		/**
		 *  define reason msg and fetch it
		 */
		$reason = wfMsgForContent( 'autocreatewiki-protect-reason' );

		$wgUser->addGroup( 'staff' );

		foreach ( $wgWikiaKeyPages as $pageName ) {
			$title = Title::newFromText( $pageName );
			$article = new Article( $title );

			if ( $article->exists() ) {
				$cascade = 0;
				$ok = $article->updateRestrictions( $restrictions, $reason, $cascade, $expiry_array );
			} else {
				$wikiPage = WikiPage::factory( $title );
				$ignored_reference = false; // doing this because MW1.19 doUpdateRestrictions() is weird, and has this passed by reference
				$status = $wikiPage->doUpdateRestrictions( array( 'create' => $titleRestrictions ), array( 'create' => $expiry_string ), $ignored_reference, $reason, $wgUser );
				$ok = $status->isOK();
			}

			if ( $ok ) {
				Wikia::log( __METHOD__, "ok", "Protected key page: $pageName" );
			} else {
				Wikia::log( __METHOD__, "err", "Failed while trying to protect $pageName" );
			}
		}
		$wgUser->removeGroup( "staff" );
	}

	/**
	 * send pages from starters to scribe
	 *
	 * @access private
	 * @author Piotr Molski (moli)
	 *
	 */
	private function sendRevisionToScribe() {
		$dbr = wfGetDB( DB_SLAVE );

		$numRows = ( new WikiaSQL() )
			->SELECT( 'rev_page as page_id', 'rev_id', 'rev_user' )
			->FROM( 'revision' )
			->WHERE( 'rev_page' )->GREATER_THAN( 0 )
			->ORDER_BY( 'rev_id' )
			->run( $dbr, function ( ResultWrapper $res ) {
				global $wgEnableScribeNewReport;

				$numRows = 0;
				$pages = [ ];

				while ( $row = $res->fetchObject() ) {
					$article = Article::newFromID( $row->page_id );
					$user = User::newFromId( $row->rev_user );
					$revision = Revision::newFromId( $row->rev_id );

					if ( $wgEnableScribeNewReport ) {
						$key = ( isset( $pages[ $row->page_id ] ) ) ? 'edit' : 'create';
						$scribeProducer = new ScribeEventProducer( $key, 0 );
						if ( is_object( $scribeProducer ) ) {
							if ( $scribeProducer->buildEditPackage( $article, $user, $revision ) ) {
								$scribeProducer->sendLog();
							}
						}
					} else {
						$flags = "";
						$status = Status::newGood( array() );
						$status->value[ 'new' ] = ( isset( $pages[ $row->page_id ] ) ? false : true );
						$archive = 0;

						ScribeProducer::saveComplete( $article, $user, null, null, null, $archive, null, $flags, $revision, $status, 0 );
					}

					$pages[ $row->page_id ] = $row->rev_id;
					++$numRows;
				}

				return $numRows;
			} );

		Wikia::log( __METHOD__, "info", "send starter revisions to scribe: {$numRows} rows" );
	}
} 