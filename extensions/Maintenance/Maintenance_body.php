<?php
if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

class Maintenance extends SpecialPage {
	var $type = '';

	function __construct() {
		SpecialPage::SpecialPage( 'Maintenance', 'maintenance' );
	}

	function execute($par) {
		global $wgRequest, $wgOut, $wgUser;
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
		//scripts that we allow to run via this interface. keep them to the same name as the xxx.php in the /maintenance dir
		//(minus the .php part... duh)
		$scripts = array(
			'changePassword', 'createAndPromote', 'deleteBatch', 'deleteRevision',
			'initEditCount',	'initStats', 'moveBatch', 'runJobs', 'showJobs', 'stats'
		);
		global $wgOut;
		wfLoadExtensionMessages('Maintenance');
		$this->setHeaders();
		$title = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$url = $title->getFullUrl() . '/';
		$wgOut->addWikiText(wfMsg('maintenance-header'));
		$wgOut->addHTML( '<ul>' );
		foreach( $scripts as $type ) {
			$wgOut->addHTML( '<li><a href="'.$url.$type.'">'.$type.'</a> -- '.wfMsg('maintenance-'.$type.'-desc').'</li>' );
		}
		$wgOut->addHTML( '</ul>' );
	}

	function makeForm( $type ) {
		global $wgOut;
		wfLoadExtensionMessages('Maintenance');
		$this->setHeaders();
		$title = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$wgOut->addHTML('<a href="'.$title->getFullURL().'">'.wfMsg('maintenance-backlink').'</a><br />');
		$wgOut->addHTML('<form method="post" action="'.$title->getFullURL().'/'.$type.'">');
		$wgOut->addHTML('<p>'.wfMsg('maintenance-'.$type).'</p><br />');
		switch( $type ) {
			case 'changePassword':
				$wgOut->addHTML('<label for="wpName">'.wfMsg('maintenance-name').'</label> <input type="text" name="wpName" /><br /><br />');
				$wgOut->addHTML('<label for="wpPassword">'.wfMsg('maintenance-password').'</label> <input type="password" name="wpPassword" /><br /><br />');
				break;
			case 'createAndPromote':
				$wgOut->addHTML('<label for="wpName">'.wfMsg('maintenance-name').'</label> <input type="text" name="wpName" /><br /><br />');
				$wgOut->addHTML('<label for="wpPassword">'.wfMsg('maintenance-password').'</label> <input type="password" name="wpPassword" /><br /><br />');
				$wgOut->addHTML('<input type="checkbox" name="wpBcrat" value="0" /><label for="wpBcrat">'.wfMsg('maintenance-bureaucrat').'</label><br /><br />');
				break;
			case 'deleteBatch':
				$wgOut->addHTML('<textarea name="wpDelete" rows="25" cols="80"></textarea><br /><br />');
				$wgOut->addHTML('<label for="wpReason">'.wfMsg('maintenance-reason').'</label> <input type="text" name="wpReason" maxlength="200" size="60" /><br /><br />');
				break;
			case 'deleteRevision':
				$wgOut->addHTML('<textarea name="wpDelete" rows="25" cols="80"></textarea><br /><br />');
				break;
			case 'initEditCount':
				//just hit the button to start this, no additional settings are needed :)
				break;
			case 'initStats':
				$wgOut->addHTML('<input type="checkbox" name="wpUpdate" value="0" checked="checked"/><label for="wpUpdate">'.wfMsg('maintenance-update').'</label><br /><br />');
				$wgOut->addHTML('<input type="checkbox" name="wpNoviews" value="0" /><label for="wpNoviews">'.wfMsg('maintenance-noviews').'</label><br /><br />');
				break;
			case 'moveBatch':
				$wgOut->addHTML('<textarea name="wpMove" rows="25" cols="80"></textarea><br /><br />');
				$wgOut->addHTML('<label for="wpReason">'.wfMsg('maintenance-reason').'</label> <input type="text" name="wpReason" maxlength="200" size="60" /><br /><br />');
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
			default:
				$wgOut->addHTML('<p>'.wfMsg('maintenance-invalidtype').'</p></form>');
				return;
		}
		$wgOut->addHTML('<input type="submit" name="wpConfirm" value="'.wfMsg('maintenance-confirm').'" /></form>');
		return;
	}

	function executeScript( $type ) {
		global $wgOut, $wgRequest;
		wfLoadExtensionMessages('Maintenance');
		$this->setHeaders();
		$title = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$wgOut->addHTML('<a href="'.$title->getFullURL().'">'.wfMsg('maintenance-backlink').'</a><br />');
		switch( $type ) {
			case 'changePassword':
				$name = $wgRequest->getText('wpName');
				$password = $wgRequest->getText('wpPassword');
				$user = User::newFromName($name);
				if( !$user->getId() ) {
					$wgOut->addWikiText( wfMsg('maintenance-invalidname') );
					return;
				}
				$dbw = wfGetDB( DB_MASTER );
				$fname = 'ChangePassword::main';

				$user->setPassword( $password );
				$user->saveSettings();
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'createAndPromote':
				$name = $wgRequest->getText('wpName');
				$password = $wgRequest->getText('wpPassword');
				$bcrat = $wgRequest->getCheck('wpBcrat');
				$user = User::newFromName($name);
				if( !is_object($user) ) {
					$wgOut->addWikiText( wfMsg('maintenance-invalidname') );
					return;
				} elseif( 0 != $user->idForName() ) {
					$wgOut->addWikiText( wfMsg('maintenance-userexists') );
					return;
				}
				$user->addToDatabase();
				$user->setPassword( $password );
				$user->saveSettings();
				$user->addGroup('sysop');
				if($bcrat)
					$user->addGroup('bureaucrat');
				$ssu = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
				$ssu->doUpdate();
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'deleteBatch':
				$reason = $wgRequest->getText('wpReason', '');
				$interval = 0;
				$pages = $wgRequest->getText('wpDelete');
				$dbw = wfGetDB( DB_MASTER );
				$lines = explode( "\n", $pages );
				foreach( $lines as &$line ) {
					$line = trim($line);
					if($line == '')
						continue;
					$page = Title::newFromText($line);
					if( is_null( $page ) ) {
						$wgOut->addWikiText( wfMsg( 'maintenance-invalidtitle', array( $line ) ) );
						continue;
					}
					if( !$page->exists() ) {
						$wgOut->addWikiText( wfMsg( 'maintenance-titlenoexist', array( $line ) ) );
						continue;
					}
					$return = '* ' . $page->getPrefixedText();
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
					$dbw->immediateCommit();
					if ( $success ) {
						$return .= '... ' . wfMsg('maintenance-deleted');
					} else {
						$return .= '... ' . wfMsg('maintenance-failed');
					}
					$wgOut->addWikiText($return);
					waitForSlaves( 5 );
				}
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'deleteRevision':
				$delete = $wgRequest->getText('wpDelete');
				$revisions = explode( "\n", $delete );
				$wgOut->addWikiText(wfMsg('maintenance-revdelete', array(implode(', ',$revisions), wfWikiId())));
				$affected = 0;
				$fname = 'deleteRevision';
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
						), $fname
					);
					if ( !$dbw->affectedRows() ) {
						$wgOut->addWikiText( wfMsg('maintenance-revnotfound', array( $revID ) ) );
					} else {
						$affected += $dbw->affectedRows();
						$dbw->delete( 'revision', array( 'rev_id' => $revID ) );
					}
				}
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
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
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'initStats':
				$dbr = wfGetDB( DB_SLAVE );
				$edits = $dbr->selectField( 'revision', 'COUNT(*)', '', __METHOD__ );
				$edits += $dbr->selectField( 'archive', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiText(wfMsg('maintenance-stats-edits', array( $edits ) ) );
				global $wgContentNamespaces;
				$good  = $dbr->selectField( 'page', 'COUNT(*)', array( 'page_namespace' => $wgContentNamespaces, 'page_is_redirect' => 0, 'page_len > 0' ), __METHOD__ );
				$wgOut->addWikiText(wfMsg('maintenance-stats-articles', array( $good ) ) );
				$pages = $dbr->selectField( 'page', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiText(wfMsg('maintenance-stats-pages', array( $pages ) ) );
				$users = $dbr->selectField( 'user', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiText(wfMsg('maintenance-stats-users', array( $users ) ) );
				$admin = $dbr->selectField( 'user_groups', 'COUNT(*)', array( 'ug_group' => 'sysop' ), __METHOD__ );
				$wgOut->addWikiText(wfMsg('maintenance-stats-admins', array( $admin ) ) );
				$image = $dbr->selectField( 'image', 'COUNT(*)', '', __METHOD__ );
				$wgOut->addWikiText(wfMsg('maintenance-stats-images', array( $image ) ) );
				if( !$wgRequest->getCheck('wpNoview') ) {
					$views = $dbr->selectField( 'page', 'SUM(page_counter)', '', __METHOD__ );
					$wgOut->addWikiText(wfMsg('maintenance-stats-views', array( $views ) ) );
				}
				$wgOut->addWikiText(wfMsg('maintenance-stats-update') );
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
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'moveBatch':
				$reason = $wgRequest->getText('wpReason', '');
				$interval = 0;
				$pages = $wgRequest->getText('wpDelete');
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
					$wgOut->addWikiText('* '.wfMsg('maintenance-move', array($source->getPrefixedText(), $dest->getPrefixedText())));
					$dbw->begin();
					$err = $source->moveTo( $dest, false, $reason );
					if( $err !== true ) {
						$wgOut->addWikiText('** '.wfMsg('maintenance-movefail', array( $err ) ) );
					}
					$dbw->immediateCommit();
					waitForSlaves( 5 );
				}
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'runJobs':
				$maxJobs = 10000;
				$type = false;
				$dbw = wfGetDB( DB_MASTER );
				$n = 0;
				$conds = '';
				while ( $dbw->selectField( 'job', 'count(*)', $conds, 'runJobs.php' ) ) {
					$offset=0;
					for (;;) {
						$job = 	Job::pop($offset);
						if ($job == false)
							break;
						waitForSlaves( 5 );
						$wgOut->addWikiText("* ".$job->id . "  " . $job->toString() );
						$offset=$job->id;
						if ( !$job->run() ) {
							$wgOut->addWikiText("** ".wfMsg('maintenance-error', array( $job->error ) ) );
						}
						if ( $maxJobs && ++$n > $maxJobs ) {
							break 2;
						}
					}
				}
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'showJobs':
				$dbw = wfGetDB( DB_MASTER );
				$count = $dbw->selectField( 'job', 'count(*)', '', 'runJobs.php' );
				$wgOut->addHTML( $count );
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			case 'stats':
				global $wgMemc;
				if( get_class( $wgMemc ) == 'FakeMemCachedClient' ) {
					$wgOut->addWikiText(wfMsg('maintenance-memc-fake'));
					return;
				}
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-requests').'</h2>');
				$session = intval($wgMemc->get(wfMemcKey('stats','request_with_session')));
				$noSession = intval($wgMemc->get(wfMemcKey('stats','request_without_session')));
				$total = $session + $noSession;
				$requests = sprintf( wfMsg('maintenance-memc-withsession')."      %-10d %6.2f%%\n", $session, $session/$total*100 ) . '<br />';
				$requests .= sprintf( wfMsg('maintenance-memc-withoutsession')."   %-10d %6.2f%%\n", $noSession, $noSession/$total*100 ). '<br />';
				$requests .= sprintf( wfMsg('maintenance-memc-total')."             %-10d %6.2f%%\n", $total, 100 ). '<br />';
				$wgOut->addWikiText($requests);
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-parsercache').'</h2>');
				$hits = intval($wgMemc->get(wfMemcKey('stats','pcache_hit')));
				$invalid = intval($wgMemc->get(wfMemcKey('stats','pcache_miss_invalid')));
				$expired = intval($wgMemc->get(wfMemcKey('stats','pcache_miss_expired')));
				$absent = intval($wgMemc->get(wfMemcKey('stats','pcache_miss_absent')));
				$stub = intval($wgMemc->get(wfMemcKey('stats','pcache_miss_stub')));
				$total = $hits + $invalid + $expired + $absent + $stub;
				$pcache = sprintf( wfMsg('maintenance-memc-hits')."              %-10d %6.2f%%\n", $hits, $hits/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-invalid')."           %-10d %6.2f%%\n", $invalid, $invalid/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-expired')."           %-10d %6.2f%%\n", $expired, $expired/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-absent')."            %-10d %6.2f%%\n", $absent, $absent/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-stub')."    %-10d %6.2f%%\n", $stub, $stub/$total*100 ). '<br />';
				$pcache .= sprintf( wfMsg('maintenance-memc-total')."             %-10d %6.2f%%\n", $total, 100 ). '<br />';
				$wgOut->addWikiText($pcache);
				$hits = intval($wgMemc->get(wfMemcKey('stats','image_cache_hit')));
				$misses = intval($wgMemc->get(wfMemcKey('stats','image_cache_miss')));
				$updates = intval($wgMemc->get(wfMemcKey('stats','image_cache_update')));
				$total = $hits + $misses;
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-imagecache').'</h2>');
				$icache = sprintf( wfMsg('maintenance-memc-hits')."              %-10d %6.2f%%\n", $hits, $hits/$total*100 ). '<br />';
				$icache .= sprintf( wfMsg('maintenance-memc-misses')."            %-10d %6.2f%%\n", $misses, $misses/$total*100 ). '<br />';
				$icache .= sprintf( wfMsg('maintenance-memc-updates')."           %-10d\n", $updates ). '<br />';
				$wgOut->addWikiText($icache);
				$hits = intval($wgMemc->get(wfMemcKey('stats','diff_cache_hit')));
				$misses = intval($wgMemc->get(wfMemcKey('stats','diff_cache_miss')));
				$uncacheable = intval($wgMemc->get(wfMemcKey('stats','diff_uncacheable')));
				$total = $hits + $misses + $uncacheable;
				$wgOut->addWikiText('<h2>'.wfMsg('maintenance-memc-diffcache').'</h2>');
				$dcache = sprintf( wfMsg('maintenance-memc-hits')."              %-10d %6.2f%%\n", $hits, $hits/$total*100 ). '<br />';
				$dcache .= sprintf( wfMsg('maintenance-memc-misses')."            %-10d %6.2f%%\n", $misses, $misses/$total*100 ). '<br />';
				$dcache .= sprintf( wfMsg('maintenance-memc-uncacheable')."       %-10d %6.2f%%\n", $uncacheable, $uncacheable/$total*100 ). '<br />';
				$wgOut->addWikiText($dcache);
				$wgOut->addWikiText( wfMsg('maintenance-success', array( $type ) ) );
				break;
			default:
				$wgOut->addHTML('<p>'.wfMsg('maintenance-invalidtype').'</p></form>');
				return;
		}
	}
}

function waitForSlaves($maxLag) {
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
