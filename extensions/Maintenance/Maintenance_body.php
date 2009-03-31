<?php
if( !defined('MEDIAWIKI') ) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

class Maintenance extends SpecialPage {
	var $type = '';
	static $scripts = array(
		'changePassword', 'createAndPromote', 'deleteBatch', 'deleteRevision',
		'initEditCount', 'initStats', 'moveBatch', 'runJobs', 'showJobs', 'stats',
		'sql', 'eval', 'reassignEdits', 
	);

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Maintenance'/*class*/, 'maintenance'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If the user doesn't have the required 'maintenance' permission, display an error
		if( !$wgUser->isAllowed( 'maintenance' ) ) {
			$wgOut->permissionRequired( 'maintenance' );
			return;
		}

		$this->type = $par ? $par : '';
		if( $this->type === '') {
			$this->makeInitialForm();
		} elseif( $this->type !== '' && !$wgRequest->wasPosted() ) {
			$this->makeForm( $this->type );
		} elseif( $this->type !== '' && $wgRequest->wasPosted() ) {
			$this->executeScript( $this->type );
		}
	}

	function makeInitialForm() {
		global $wgOut, $wgUser;

		wfLoadExtensionMessages( 'Maintenance' );
		$this->setHeaders();
		$wgOut->addWikiMsg( 'maintenance-header' );
		$sk = $wgUser->getSkin();
		$wgOut->addHTML( '<ul>' );

		//scripts that we allow to run via this interface. keep them to the same name as the xxx.php in the /maintenance dir
		//(minus the .php part... duh)
		$scripts = self::$scripts;
		sort( $scripts );
		foreach( $scripts as $type ) {
			$title = $this->getTitle( $type );
			$wgOut->addHTML( '<li>'. $sk->makeKnownLinkObj( $title, htmlspecialchars( $type ) ) . ' -- '.
				wfMsgExt( 'maintenance-'.$type.'-desc', array( 'parseinline' ) ) . '</li>' );
		}
		$wgOut->addHTML( '</ul>' );
	}

	function makeForm( $type ) {
		global $wgOut, $wgUser;
		wfLoadExtensionMessages( 'Maintenance' );
		$this->setHeaders();
		$wgOut->addHTML( $wgUser->getSkin()->makeKnownLinkObj( $this->getTitle(), wfMsgHtml( 'maintenance-backlink' ) ). '<br />' );
		
		if( !in_array( $type, self::$scripts ) ) {
			$wgOut->addWikiMsg( 'maintenance-invalidtype' );
			return;
		}
		
		$wgOut->addWikiMsg( 'maintenance-' . $type );

		$wgOut->addHTML( Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle( $type )->getFullURL() ) ) );
		switch( $type ) {
			case 'changePassword':
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-name' ), 'wpName', 'wpName' ) . '<br /><br />' );
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-password' ), 'wpPassword', 'wpPassword', false, false, array( 'type' => 'password' ) ) . '<br /><br />' );
				break;
			case 'createAndPromote':
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-name' ), 'wpName', 'wpName' ) . '<br /><br />' );
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-password' ), 'wpPassword', 'wpPassword', false, false, array( 'type' => 'password' ) ) . '<br /><br />' );
				$wgOut->addHTML( Xml::checkLabel( wfMsg('maintenance-bureaucrat'), 'wpBcrat', 'wpBcrat' ) . '<br /><br />' );
				break;
			case 'deleteBatch':
				$wgOut->addHTML('<textarea name="wpDelete" rows="25" cols="80"></textarea><br /><br />');
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-reason' ), 'wpReason', 'wpReason', '60', false, array( 'maxlength' => 200 ) ) . '<br /><br />' );
				break;
			case 'deleteRevision':
				$wgOut->addHTML('<textarea name="wpDelete" rows="25" cols="80"></textarea><br /><br />');
				break;
			case 'eval':
				$wgOut->addHTML('<textarea name="wpCode" rows="25" cols="80"></textarea><br /><br />');
				break;
			case 'initEditCount':
				//just hit the button to start this, no additional settings are needed :)
				break;
			case 'initStats':
				$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-update' ), 'wpUpdate', 'wpUpdate', true ) . '<br /><br />' );
				$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-noviews' ), 'wpNoviews', 'wpNoviews' ) . '<br /><br />' );
				break;
			case 'moveBatch':
				$wgOut->addHTML('<textarea name="wpMove" rows="25" cols="80"></textarea><br /><br />');
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-reason' ), 'wpReason', 'wpReason', '60', false, array( 'maxlength' => 200 ) ) . '<br /><br />' );
				break;
			case 'reassignEdits':
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-re-from' ), 'wpFrom', 'wpFrom', '60' ) . '<br /><br />' );
				$wgOut->addHTML( Xml::inputLabel( wfMsg( 'maintenance-re-to' ), 'wpTo', 'wpTo', '60' ) . '<br /><br />' );
				$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-re-force' ), 'wpForce', 'wpForce' ) . '<br /><br />' );
				$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-re-rc' ), 'wpRc', 'wpRc' ) . '<br /><br />' );
				$wgOut->addHTML( Xml::checkLabel( wfMsg( 'maintenance-re-report' ), 'wpReport', 'wpReport' ) . '<br /><br />' );
				break;
			case 'runJobs':
				//just hit the button to start this, no additional settings are needed :)
				break;
			case 'showJobs':
				//just hit the button to start this, no additional settings are needed :)
				break;
			case 'stats':
				//just hit the button to start this, no additional settings are needed :)
				break;
			case 'sql':
				$wgOut->addHTML('<textarea name="wpQuery" rows="25" cols="80"></textarea><br /><br />');
				break;
			default:
				$wgOut->addHTML( '</form>' );
				$wgOut->addWikiMsg( 'maintenance-invalidtype' );
				return;
		}
		$wgOut->addHTML( Xml::submitButton( wfMsg( 'maintenance-confirm' ), array( 'name' => 'wpConfirm' ) ) . '</form>' );
		return;
	}

	function executeScript( $type ) {
		global $wgOut, $wgRequest, $wgUser;
		wfLoadExtensionMessages('Maintenance');
		@set_time_limit(0); //if we can, disable the time limit
		$this->setHeaders();
		$wgOut->addHTML( $wgUser->getSkin()->makeKnownLinkObj( $this->getTitle(), wfMsgHtml( 'maintenance-backlink' ) ). '<br />' );
		switch( $type ) {
			case 'changePassword':
				$name = $wgRequest->getText( 'wpName' );
				$password = $wgRequest->getText( 'wpPassword' );
				$user = User::newFromName( $name );
				if( !is_object( $user ) || !$user->getId() ) {
					$wgOut->addWikiMsg( 'maintenance-invalidname' );
					return;
				}
				$dbw = wfGetDB( DB_MASTER );

				$user->setPassword( $password );
				$user->saveSettings();
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'createAndPromote':
				$name = $wgRequest->getText( 'wpName' );
				$password = $wgRequest->getText( 'wpPassword' );
				$bcrat = $wgRequest->getCheck( 'wpBcrat' );
				$user = User::newFromName( $name );
				if( !is_object( $user ) ) {
					$wgOut->addWikiMsg( 'maintenance-invalidname' );
					return;
				} elseif( 0 != $user->idForName() ) {
					$wgOut->addWikiMsg( 'maintenance-userexists' );
					return;
				}
				$user->addToDatabase();
				$user->setPassword( $password );
				$user->saveSettings();
				$user->addGroup( 'sysop');
				if( $bcrat )
					$user->addGroup( 'bureaucrat' );
				$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
				$ssu->doUpdate();
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'deleteBatch':
				$reason = $wgRequest->getText( 'wpReason', '' );
				$interval = 0;
				$pages = $wgRequest->getText( 'wpDelete' );
				$dbw = wfGetDB( DB_MASTER );
				$lines = explode( "\n", $pages );
				foreach( $lines as &$line ) {
					$line = trim( $line );
					if( $line == '' )
						continue;
					$page = Title::newFromText( $line );
					if( is_null( $page ) ) {
						$wgOut->addWikiMsg( 'maintenance-invalidtitle', $line );
						continue;
					}
					if( !$page->exists() ) {
						$wgOut->addWikiMsg( 'maintenance-titlenoexist', $line );
						continue;
					}
					$return = '* ' . $page->getPrefixedText();
					// Switch the user here from the current user to Delete page script
					$OldUser = $wgUser;
					$wgUser = User::newFromName( 'Delete page script' );
					// Begin transaction
					$dbw->begin();
					if( $page->getNamespace() == NS_IMAGE ) {
						$art = new ImagePage( $page );
						$img = wfFindFile( $art->mTitle );
						if( !$img || !$img->delete( $reason ) ) {
							$return .= '... ' . wfMsg('maintenance-failed');
						}
					} else {
						$art = new Article( $page );
					}
					$success = $art->doDeleteArticle( $reason );
					// Commit changes to the database
					$dbw->commit();
					// ...and switch user back to the old user
					$wgUser = $OldUser;
					if ( $success ) {
						$return .= '... ' . wfMsg( 'maintenance-deleted' );
					} else {
						$return .= '... ' . wfMsg( 'maintenance-failed' );
					}
					$wgOut->addWikiText( $return );
					waitForSlaves( 5 );
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'deleteRevision':
				$delete = $wgRequest->getText( 'wpDelete' );
				$revisions = explode( "\n", $delete );
				$wgOut->addWikiMsg( 'maintenance-revdelete', implode( ', ', $revisions ), wfWikiID() );
				$affected = 0;
				// Switch the user here from the current user to Delete page script
				$OldUser = $wgUser;
				$wgUser = User::newFromName( 'Delete page script' );
				$dbw = wfGetDB( DB_MASTER );
				foreach ( $revisions as $revID ) {
					$dbw->insertSelect( 'archive', array( 'page', 'revision' ),
						array(
							'ar_namespace'  => 'page_namespace',
							'ar_title'      => 'page_title',
							'ar_comment'    => 'rev_comment',
							'ar_user'       => 'rev_user',
							'ar_user_text'  => 'rev_user_text',
							'ar_timestamp'  => 'rev_timestamp',
							'ar_minor_edit' => 'rev_minor_edit',
							'ar_rev_id'     => 'rev_id',
							'ar_text_id'    => 'rev_text_id',
						), array(
							'rev_id' => $revID,
							'page_id = rev_page'
						), __METHOD__
					);
					if ( !$dbw->affectedRows() ) {
						$wgOut->addWikiMsg( 'maintenance-revnotfound', array( $revID ) );
					} else {
						$affected += $dbw->affectedRows();
						$dbw->delete( 'revision', array( 'rev_id' => $revID ) );
					}
				}
				// ...and switch user back to the old user
				$wgUser = $OldUser;
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'eval':
				$temp = error_reporting( E_ALL );
				ob_start();
				$str = eval( $wgRequest->getText( 'wpCode', 'return;' ) );
				$ext = ob_get_clean();
				error_reporting( 0 );
				if( $ext ) {
					$wgOut->addHTML( nl2br($ext) . '<hr />' );
				}
				if( !$str ) {
					// do nothing
				} elseif( is_string( $str ) ) {
					$wgOut->addHTML( nl2br($str) . '<hr />' );
				} else {
					$wgOut->addHTML( nl2br( var_export( $str, true ) ) . '<hr />' );
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'initEditCount':
				global $wgDBservers;
				$dbw = wfGetDB( DB_MASTER );
				$user = $dbw->tableName( 'user' );
				$revision = $dbw->tableName( 'revision' );
				$dbver = $dbw->getServerVersion();
				$dbr = wfGetDB( DB_SLAVE );
				$chunkSize = 100;
				$lastUser = $dbr->selectField( 'user', 'MAX(user_id)', '', __FUNCTION__ );
				$start = microtime( true );
				$migrated = 0;
				for( $min = 0; $min <= $lastUser; $min += $chunkSize ) {
					$max = $min + $chunkSize;
					$result = $dbr->query(
						"SELECT
							user_id,
							COUNT(rev_user) AS user_editcount
						FROM $user
						LEFT OUTER JOIN $revision ON user_id=rev_user
						WHERE user_id > $min AND user_id <= $max
						GROUP BY user_id",
						'initEditCount' );
					while( $row = $dbr->fetchObject( $result ) ) {
						$dbw->update( 'user',
							array( 'user_editcount' => $row->user_editcount ),
							array( 'user_id' => $row->user_id ),
							'initEditCount' );
						++$migrated;
					}
					$dbr->freeResult( $result );
					waitForSlaves( 10 );
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'initStats':
				$dbr = wfGetDB( DB_SLAVE );
				$edits = $dbr->selectField( 'revision', 'COUNT(*)', '', __METHOD__ );
				$edits += $dbr->selectField( 'archive', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiMsg( 'maintenance-stats-edits', $edits );
				global $wgContentNamespaces;
				$good = $dbr->selectField( 'page', 'COUNT(*)', array( 'page_namespace' => $wgContentNamespaces, 'page_is_redirect' => 0, 'page_len > 0' ), __METHOD__ );
				$wgOut->addWikiMsg( 'maintenance-stats-articles', $good );
				$pages = $dbr->selectField( 'page', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiMsg( 'maintenance-stats-pages', $pages );
				$users = $dbr->selectField( 'user', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiMsg( 'maintenance-stats-users', $users );
				$admin = $dbr->selectField( 'user_groups', 'COUNT(*)', array( 'ug_group' => 'sysop' ), __METHOD__ );
				$wgOut->addWikiMsg( 'maintenance-stats-admins', $admin );
				$image = $dbr->selectField( 'image', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiMsg( 'maintenance-stats-images', $image );
				if( !$wgRequest->getCheck('wpNoview') ) {
					$views = $dbr->selectField( 'page', 'SUM(page_counter)', '', __METHOD__ );
					$wgOut->addWikiMsg( 'maintenance-stats-views', $views );
				}
				$wgOut->addWikiMsg('maintenance-stats-update');
				$dbw = wfGetDB( DB_MASTER );
				$values = array( 'ss_total_edits' => $edits,
								'ss_good_articles' => $good,
								'ss_total_pages' => $pages,
								'ss_users' => $users,
								'ss_admins' => $admin,
								'ss_images' => $image );
				$conds = array( 'ss_row_id' => 1 );
				$views = array( 'ss_total_views' => isset( $views ) ? $views : 0 );

				if( $wgRequest->getCheck('wpUpdate') ) {
					$dbw->update( 'site_stats', $values, $conds, __METHOD__ );
				} else {
					$dbw->delete( 'site_stats', $conds, __METHOD__ );
					$dbw->insert( 'site_stats', array_merge( $values, $conds, $views ), __METHOD__ );
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'moveBatch':
				$reason = $wgRequest->getText('wpReason', '');
				$interval = 0;
				$pages = $wgRequest->getText('wpMove');
				$dbw = wfGetDB( DB_MASTER );
				$lines = explode( "\n", $pages );
				foreach( $lines as $line ) {
					$parts = array_map( 'trim', explode( '|', $line ) );
					if ( count( $parts ) != 2 ) {
						continue;
					}
					$source = Title::newFromText( $parts[0] );
					$dest = Title::newFromText( $parts[1] );
					if ( is_null( $source ) || is_null( $dest ) ) {
						continue;
					}
					$wgOut->addWikiText( '* '.wfMsg( 'maintenance-move', array( $source->getPrefixedText(), $dest->getPrefixedText() ) ) );
					$dbw->begin();
					$err = $source->moveTo( $dest, false, $reason );
					if( $err !== true ) {
						$wgOut->addWikiText('** '.wfMsg('maintenance-movefail', array( $err ) ) );
					}
					$dbw->commit();
					waitForSlaves( 5 );
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'reassignEdits':
				$wpFrom = $wgRequest->getVal( 'wpFrom' );
				$wpTo = $wgRequest->getVal( 'wpTo' );
				if( User::isIP( $wpFrom ) ) {
					$from = new User();
					$from->setId( 0 );
					$from->setName( $wpFrom );
				} else {
					$from = User::newFromName( $wpFrom );
				}
				if( User::isIP( $wpTo ) ) {
					$to = new User();
					$to->setId( 0 );
					$to->setName( $wpTo );
				} else {
					$to = User::newFromName( $wpTo );
				}
				if( $to->getId() || $wgRequest->getCheck( 'wpForce' ) ) {
					$report = $wgRequest->getCheck( 'wpReport' );
					$dbw = wfGetDB( DB_MASTER );
					$dbw->immediateBegin();
					$rcond = $from->getId() ? array( 'rev_user' => $from->getId() ) : array( 'rev_user_text' => $from->getName() );
					$res = $dbw->select( 'revision', 'COUNT(*) AS count', $rcond, 'Maintenance::reassignEdits' );
					$row = $dbw->fetchObject( $res );
					$cur = $row->count;
					$wgOut->addWikiMsg( 'maintenance-re-ce', $cur );
					$acond = $from->getId() ? array( 'ar_user' => $from->getId() ) : array( 'ar_user_text' => $from->getName() );
					$res = $dbw->select( 'archive', 'COUNT(*) AS count', $acond, 'Maintenance::reassignEdits' );
					$row = $dbw->fetchObject( $res );
					$del = $row->count;
					$wgOut->addWikiMsg( 'maintenance-re-de', $del );
					if( !$wgRequest->getCheck( 'wpRc' ) ) {
						$ccond = $from->getId() ? array( 'rc_user' => $from->getId() ) : array( 'rc_user_text' => $from->getName() );
						$res = $dbw->select( 'recentchanges', 'COUNT(*) AS count', $ccond, 'Maintenance::reassignEdits' );
						$row = $dbw->fetchObject( $res );
						$rec = $row->count;
						$wgOut->addWikiMsg( 'maintenance-re-rce', $rec );
					} else {
						$rec = 0;
					}
					$total = $cur + $del + $rec;
					$wgOut->addWikiMsg( 'maintenance-re-total', $total );
					if( !$report ) {
						$rspec = array( 'rev_user' => $to->getId(), 'rev_user_text' => $to->getName() );
						$res = $dbw->update( 'revision', $rspec, $rcond, 'Maintenance::reassignEdits' );
						$aspec = array( 'ar_user' => $to->getId(), 'ar_user_text' => $to->getName() );
						$res = $dbw->update( 'archive', $aspec, $acond, 'Maintenance::reassignEdits' );
						if( !$wgRequest->getCheck( 'wpRc' ) ) {
							$cspec = array( 'rc_user' => $to->getId(), 'rc_user_text' => $to->getName() );
							$res = $dbw->update( 'recentchanges', $cspec, $ccond, 'Maintenance::reassignEdits' );
						}
					}
					$dbw->immediateCommit();
					if( $report ) {
						$wgOut->addWikiMsg( 'maintenance-re-rr', wfMsg( 'maintenance-re-report' ) );
					}
				} else {
					$ton = $to->getName();
					$wgOut->addWikiMsg( 'maintenance-re-nf', $ton );
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'runJobs':
				$maxJobs = 10000;
				$dbw = wfGetDB( DB_MASTER );
				$n = 0;
				while ( $dbw->selectField( 'job', 'count(*)', '', 'runJobs.php' ) ) {
					$offset = 0;
					for (;;) {
						$job = 	Job::pop($offset);
						if ( $job == false )
							break;
						waitForSlaves( 5 );
						$wgOut->addWikiText("* ".$job->id . "  " . $job->toString() );
						$offset = $job->id;
						if ( !$job->run() ) {
							$wgOut->addWikiText("** ".wfMsg('maintenance-error', array( $job->error ) ) );
						}
						if ( $maxJobs && ++$n > $maxJobs ) {
							break 2;
						}
					}
				}
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'showJobs':
				$dbw = wfGetDB( DB_MASTER );
				$count = $dbw->selectField( 'job', 'count(*)', '', 'runJobs.php' );
				$wgOut->addHTML( $count );
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'stats':
				global $wgMemc;
				if( get_class( $wgMemc ) == 'FakeMemCachedClient' ) {
					$wgOut->addWikiMsg('maintenance-memc-fake');
					return;
				}
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-requests').'</h2>');
				$session = intval( $wgMemc->get( wfMemcKey('stats', 'request_with_session') ) );
				$noSession = intval( $wgMemc->get( wfMemcKey('stats', 'request_without_session') ) );
				$total = $session + $noSession;
				$requests = sprintf( wfMsg('maintenance-memc-withsession')."      %-10d %6.2f%%\n", $session, $session/$total*100 ) . '<br />';
				$requests .= sprintf( wfMsg('maintenance-memc-withoutsession')."   %-10d %6.2f%%\n", $noSession, $noSession/$total*100 ). '<br />';
				$requests .= sprintf( wfMsg('maintenance-memc-total')."             %-10d %6.2f%%\n", $total, 100 ). '<br />';
				$wgOut->addWikiText($requests);
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-parsercache').'</h2>');
				$hits = intval( $wgMemc->get( wfMemcKey('stats', 'pcache_hit') ) );
				$invalid = intval( $wgMemc->get( wfMemcKey('stats', 'pcache_miss_invalid') ) );
				$expired = intval( $wgMemc->get( wfMemcKey('stats', 'pcache_miss_expired') ) );
				$absent = intval( $wgMemc->get( wfMemcKey('stats', 'pcache_miss_absent') ) );
				$stub = intval( $wgMemc->get( wfMemcKey('stats', 'pcache_miss_stub') ) );
				$total = $hits + $invalid + $expired + $absent + $stub;
				$pcache = sprintf( wfMsg('maintenance-memc-hits')."              %-10d %6.2f%%\n", $hits, $hits/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-invalid')."           %-10d %6.2f%%\n", $invalid, $invalid/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-expired')."           %-10d %6.2f%%\n", $expired, $expired/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-absent')."            %-10d %6.2f%%\n", $absent, $absent/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-stub')."    %-10d %6.2f%%\n", $stub, $stub/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-total')."             %-10d %6.2f%%\n", $total, 100 ). '<br />';
				$wgOut->addWikiText($pcache);
				$hits = intval( $wgMemc->get( wfMemcKey('stats', 'image_cache_hit') ) );
				$misses = intval( $wgMemc->get( wfMemcKey('stats', 'image_cache_miss') ) );
				$updates = intval( $wgMemc->get( wfMemcKey('stats', 'image_cache_update') ) );
				$total = $hits + $misses;
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-imagecache').'</h2>');
				$icache = sprintf( wfMsg('maintenance-memc-hits')."              %-10d %6.2f%%\n", $hits, $hits/$total*100 ). '<br />';
				$icache .= sprintf( wfMsg('maintenance-memc-misses')."            %-10d %6.2f%%\n", $misses, $misses/$total*100 ). '<br />';
				$icache .= sprintf( wfMsg('maintenance-memc-updates')."           %-10d\n", $updates ). '<br />';
				$wgOut->addWikiText($icache);
				$hits = intval( $wgMemc->get( wfMemcKey('stats', 'diff_cache_hit') ) );
				$misses = intval( $wgMemc->get( wfMemcKey('stats', 'diff_cache_miss') ) );
				$uncacheable = intval( $wgMemc->get( wfMemcKey('stats', 'diff_uncacheable') ) );
				$total = $hits + $misses + $uncacheable;
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-diffcache').'</h2>');
				$dcache = sprintf( wfMsg('maintenance-memc-hits')."              %-10d %6.2f%%\n", $hits, $hits/$total*100 ). '<br />';
				$dcache .= sprintf( wfMsg('maintenance-memc-misses')."            %-10d %6.2f%%\n", $misses, $misses/$total*100 ). '<br />';
				$dcache .= sprintf( wfMsg('maintenance-memc-uncacheable')."       %-10d %6.2f%%\n", $uncacheable, $uncacheable/$total*100 ). '<br />';
				$wgOut->addWikiText($dcache);
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			case 'sql':
				$db = wfGetDB( DB_MASTER );
				$q = $wgRequest->getText('wpQuery', '');
				$db->begin();
				try {
					$r = $db->query( $q, 'Maintenance::sql.php' );
				} catch(DBQueryError $e) {
					global $wgShowSQLErrors;
					$temp = $wgShowSQLErrors;
					$wgShowSQLErrors = true;
					$wgOut->addWikiText( '<pre style="overflow: auto">' . $e->getText() . '</pre>' );
					$wgShowSQLErrors = $temp;
					$r = false;
				}
				if($r === true) {
					$wgOut->addWikiMsg( 'maintenance-sql-aff', $db->affectedRows() );
				} elseif( $r instanceOf ResultWrapper ) {
					$res = array();
					for( $i = 0; $i < $r->numRows(); $i++ ) {
						$row = $r->fetchRow();
						$res[] = $row;
						foreach( $row as $key => $meh ) {
							$names[] = $key;
						}
					}
					$names = array_unique($names);
					$rtable = '<table class="wikitable"><tr>';
					foreach($names as $name) {
						if( is_numeric($name) ) continue;
						$rtable .= '<th>' . $name . '</th>';
					}
					$rtable .= '</tr>';
					foreach( $res as $data ) {
						$rtable .= '<tr>';
						foreach( $data as $key => $value ) {
							if( is_numeric($key) ) continue;
							$rtable .= '<td><nowiki>' . $value . '</nowiki></td>';
						}
						$rtable .= '</tr>';
					}
					$rtable .= '</table>';
					$wgOut->addWikiMsg( 'maintenance-sql-res', $r->numRows(), $rtable );
					$db->freeResult($r);
				}
				$db->commit();
				$wgOut->addWikiMsg( 'maintenance-success', $type );
				break;
			default:
				$wgOut->addWikiMsg( 'maintenance-invalidtype' );
				return;
		}
	}
}

function waitForSlaves( $maxLag ) {
	if( $maxLag ) {
		$lb = wfGetLB();
		list( $host, $lag ) = $lb->getMaxLag();
		while( $lag > $maxLag ) {
			$name = @gethostbyaddr( $host );
			if( $name !== false ) {
				$host = $name;
			}
			sleep($maxLag);
			list( $host, $lag ) = $lb->getMaxLag();
		}
	}
}

// Helper classes
