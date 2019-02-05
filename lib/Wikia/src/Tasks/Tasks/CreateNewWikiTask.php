<?php
/**
 * CreateNewWikiTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

use Wikia\Util\GlobalStateWrapper;

class CreateNewWikiTask extends BaseTask {

	/** @var \User */
	private $founder;

	private $wikiName;

	private $wikiLang;

	public function init() {
		global $wgForceMasterDatabase;

		// Set this flag to ensure that all select operations go against master
		// Slave lag can cause random errors during wiki creation process
		$wgForceMasterDatabase = true;
		parent::init();

		$this->title = \Title::newFromText( NS_MAIN, "Main" );
	}

	public function postCreationSetup( $params ) {
		global $wgErrorLog, $wgServer, $wgInternalServer, $wgStatsDBEnabled;

		$wgServer = \WikiFactory::cityUrlToDomain( $params['url'] );
		$wgInternalServer = $wgServer;
		$wgStatsDBEnabled = false;   // disable any DW queries/hooks during wiki creation

		$wgErrorLog = false;

		if ( $params['founderId'] ) {
			$this->info('loading founding user', ['founder_id' => $params['founderId']]);
			$this->founder = \User::newFromId( $params['founderId'] );
			$this->founder->load();
		}

		if ( !$this->founder || $this->founder->isAnon() ) {
			$this->warning('cannot load founding user', ['founder_id' => $params['founderId']]);
			if ( !empty( $params['founderName'] ) ) {
				$this->founder = \User::newFromName( $params['founderName'] );
				$this->founder->load();
			}
		}

		$this->wikiName = isset( $params['sitename'] ) ? $params['sitename'] : \WikiFactory::getVarValueByName( 'wgSitename', $params['city_id'], true );
		$this->wikiLang = isset( $params['language'] ) ? $params['language'] : \WikiFactory::getVarValueByName( 'wgLanguageCode', $params['city_id'] );

		$this->moveMainPage();

		if ( !$params['fc_community_id'] ) {
			$this->changeStarterContributions( $params );
			$this->setWelcomeTalkPage();
		}

		$this->protectKeyPages();

		$hookParams = [
			'title' => $params['sitename'],
			'url' => $params['url'],
			'city_id' => $params['city_id'],
			'fc_community_id' => $params['fc_community_id'],
		];

		\Hooks::run( 'CreateWikiLocalJob-complete', [ $hookParams ] );

		return true;
	}

	public function maintenance( $server ) {
		global $wgCityId, $IP;

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/update.php --server={$server} --quick --nopurge" );
		$output = wfShellExec( $cmd, $exitStatus );
		$this->info( 'run update.php', ['exitStatus' => $exitStatus, 'output' => $output] );

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/initStats.php --server={$server}" );
		$output = wfShellExec( $cmd, $exitStatus );
		$this->info( 'run initStats.php', ['exitStatus' => $exitStatus, 'output' => $output] );

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/refreshLinks.php --server={$server} --new-only" );
		$output = wfShellExec( $cmd, $exitStatus );
		$this->info( 'run refreshLinks.php', ['exitStatus' => $exitStatus, 'output' => $output] );

		$cmd = sprintf( "SERVER_ID={$wgCityId} php {$IP}/maintenance/updateSpecialPages.php --server={$server}" );
		$output = wfShellExec( $cmd, $exitStatus );
		$this->info( 'run updateSpecialPages.php', ['exitStatus' => $exitStatus, 'output' => $output] );

		// SUS-3264 | set up events_local_users entries directly, instead of calling backend script
		$this->info( "Setting up events_local_users table entries" );
		\ListusersData::populateEventsLocalUsers( $wgCityId );

		return true;
	}

	/**
	 * move main page to SEO-friendly name
	 */
	private function moveMainPage() {
		global $wgSitename;

		$source = wfMsgForContent( 'Mainpage' );
		$target = $wgSitename;

		$sourceTitle = \Title::newFromText( $source );
		if ( !$sourceTitle ) {
			$sourceTitle = \Title::newFromText( 'Main_Page' );
			if ( !$sourceTitle ) {
				$this->error( 'invalid page title', [ 'title' => $source ] );
				return;
			}
		}

		$mainArticle = new \Article( $sourceTitle, 0 );
		if ( $mainArticle->exists() ) {
			/**
			 * check target title
			 */
			$targetTitle = \Title::newFromText( $target );
			if ( $targetTitle ) {
				$moveContext = [
					'source' => $sourceTitle->getPrefixedText(),
					'target' => $targetTitle->getPrefixedText(),
				];
				if ( $sourceTitle->getPrefixedText() !== $targetTitle->getPrefixedText() ) {
					$wikiaUser = \User::newFromName( \Wikia::USER );
					$wrapper = new GlobalStateWrapper( [
						'wgUser' => $wikiaUser
					] );

					$err = $wrapper->wrap( function() use ( $sourceTitle, $targetTitle ) {
						return $sourceTitle->moveTo( $targetTitle, false, 'SEO' );
					});

					if ( $err !== true ) {
						$this->error('main page move failed', $moveContext);
					} else {
						$this->info('main page moved', $moveContext);
						/**
						 * fill Mediawiki:Mainpage with new title
						 */
						$mwMainPageTitle = \Title::newFromText( 'Mainpage', NS_MEDIAWIKI );
						$mwMainPageArticle = new \Article( $mwMainPageTitle, 0 );
						$mwMainPageArticle->doEdit(
							$targetTitle->getText(),
							'SEO',
							EDIT_SUPPRESS_RC | EDIT_MINOR | EDIT_FORCE_BOT,
							false,
							$wikiaUser
						);
						$mwMainPageArticle->doPurge();

						/**
						 * also move associated talk page if it exists
						 */
						$sourceTalkTitle = $sourceTitle->getTalkPage();
						$targetTalkTitle = $targetTitle->getTalkPage();
						if ( $sourceTalkTitle instanceof \Title && $sourceTalkTitle->exists() && $targetTalkTitle instanceof \Title ) {
							$moveContext = [
								'source' => $sourceTalkTitle->getPrefixedText(),
								'target' => $targetTalkTitle->getPrefixedText(),
							];
							$err = $wrapper->wrap( function() use ( $sourceTalkTitle, $targetTitle ) {
								return $sourceTalkTitle->moveTo( $targetTitle->getTalkPage(), false, "SEO" );
							} );
							if ( $err === true ) {
								$this->info( 'talk page moved', $moveContext );
							} else {
								$this->warning( 'talk page move failed', $moveContext );
							}
						}
					}
				} else {
					$this->info( 'talk page not moved. source, destination are the same', $moveContext );
				}
			}
		}
	}

	/**
	 * this method updates rev_user and rev_user_text for language starters
	 * update is performed on local (freshly created) database
	 */
	private function changeStarterContributions( $params ) {
		$dbw = wfGetDB( DB_MASTER );
		$contributor = \User::newFromName( \Wikia::USER );
		$lastRevTimestamp = 0;

		/**
		 * BugId:15644 - We want to change contributions only for
		 * revisions created during the starter import - (timestamp not
		 * greater than the timestamp of the latest starter revision.
		 */
		$updateSql = ( new \WikiaSQL() )
			->UPDATE( 'revision' )
			->SET( 'rev_user', $contributor->getId() )
			->SET( 'rev_user_text', $contributor->getName() )
			->SET_RAW( 'rev_timestamp', 'date_format(now(), "%Y%m%d%H%i%S")' );

		/**
		 * determine the timestamp of the latest starter revision
		 */
		if ( !empty( $params['sDbStarter'] ) ) {
			$starterDb = wfGetDb( DB_SLAVE, array(), $params['sDbStarter'] );

			if ( is_object( $starterDb ) ) {
				$lastRevTimestamp = ( new \WikiaSQL() )
					->SELECT( 'max(rev_timestamp)' )->AS_( 'rev_timestamp' )
					->FROM( 'revision' )
					->run( $starterDb, function ( \ResultWrapper $res ) use ( $updateSql ) {
						$row = $res->fetchObject();

						if ( $row ) {
							$updateSql->WHERE( 'rev_timestamp' )->LESS_THAN_OR_EQUAL( $row->rev_timestamp );
						}

						return $row->rev_timestamp;
					} );

				$starterDb->close();
			}
		}

		$updateSql->run( $dbw );
		$rows = $dbw->affectedRows();

		$this->info('rev_user, rev_user_text updated', [
			'rev_timestamp' => $lastRevTimestamp,
			'rows_affected' => $rows,
		]);
	}

	/**
	 * setWelcomeTalkPage
	 *
	 * @return boolean status
	 */
	private function setWelcomeTalkPage() {
		global $wgUser, $wgEnableWallExt;
		$saveUser = $wgUser;

		$this->info( 'Setting welcome talk page on new wiki or Wall', [
			'sitename' => $this->wikiName,
			'language' => $this->wikiLang,
		] );

		/**
		 * set apropriate staff member
		 */
		$wgUser = \Wikia::staffForLang( $this->wikiLang );
		$wgUser = ( $wgUser instanceof \User ) ? $wgUser : \User::newFromName( \CreateWiki::DEFAULT_STAFF );

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
			try {
				$wallPage = $this->founder->getTalkPage();

				( new \WallMessageBuilder() )
					->setMessageAuthor( $wgUser )
					->setMessageTitle( $wallTitle )
					->setMessageText( $talkBody )
					->setParentPageTitle( $wallPage )
					->build();
			} catch ( \WallBuilderException $builderException ) {
				$this->error( $builderException->getMessage(), $builderException->getContext() );
				return false;
			}

			$this->info( "wall message created", ['founder_name' => $this->founder->getName()] );

			return true;
		}

		$talkPage = $this->founder->getTalkPage();
		if ( $talkPage ) {
			/**
			 * and now create talk article
			 */
			$talkArticle = new \Article( $talkPage, 0 );
			if ( !$talkArticle->exists() ) {
				$talkArticle->doEdit( $talkBody, wfMsg( "autocreatewiki-welcometalk-log" ), EDIT_SUPPRESS_RC | EDIT_MINOR | EDIT_FORCE_BOT );
			} else {
				$this->warning( 'talkpage already exists', ['url' => $talkPage->getFullURL()] );
			}
		} else {
			$this->error( "Can't take talk page for user", ['founder_id' => $this->founder->getId()] );
		}
		$wgUser = $saveUser; // Restore user object after creating talk message
		return true;
	}

	/**
	 * protect key pages
	 *
	 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
	 */
	private function protectKeyPages() {
		global $wgUser, $wgWikiaKeyPages;

		$saveUser = $wgUser;
		$wgUser = \User::newFromName( \Wikia::USER );

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
		$expiry_string = \Block::infinity();
		$expiry_array = array( 'edit' => $expiry_string, 'move' => $expiry_string );

		/**
		 *  define reason msg and fetch it
		 */
		$reason = wfMsgForContent( 'autocreatewiki-protect-reason' );

		foreach ( $wgWikiaKeyPages as $pageName ) {
			$title = \Title::newFromText( $pageName );
			$article = new \Article( $title );

			if ( $article->exists() ) {
				$cascade = 0;
				$ok = $article->updateRestrictions( $restrictions, $reason, $cascade, $expiry_array );
			} else {
				$wikiPage = \WikiPage::factory( $title );
				$ignored_reference = false; // doing this because MW1.19 doUpdateRestrictions() is weird, and has this passed by reference
				$status = $wikiPage->doUpdateRestrictions( array( 'create' => $titleRestrictions ), array( 'create' => $expiry_string ), $ignored_reference, $reason, $wgUser );
				$ok = $status->isOK();
			}

			if ( $ok ) {
				$this->info('Protected key page', ['page_name' => $pageName]);
			} else {
				$this->warning('failed to protect key page', ['page_name' => $pageName]);
			}
		}

		$wgUser = $saveUser;
	}
}
