<?php
/**
 * Rollback all edits by a given user or IP provided they're the most
 * recent edit (just like real rollback)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @ingroup Maintenance
 */

require_once( dirname(__FILE__) . '/../../../../maintenance/Maintenance.php' );

class RollbackEditsMulti extends Maintenance {
	
	const USER_NAME = 'Maintenance script';
	
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Rollback all edits by a given user or IP provided they're the most recent edit";
		$this->addOption( 'titles', 'A list of titles, none means all titles where the given user is the most recent', false, true );
		$this->addOption( 'users', 'A user or IP to rollback all edits for', true, true );
		$this->addOption( 'time', 'Starting time after which edits should be rolled back', true, true );
		$this->addOption( 'summary', 'Edit summary to use', false, true );
		$this->addOption( 'bot', 'Mark the edits as bot' );
		$this->addOption( 'onlyshared', 'Process wikis with shared users database' );
	}

	public function execute() {
		global $wgUser, $wgSharedDB;
		
		if ( $this->getOption( 'onlyshared', false ) && empty($wgSharedDB) ) {
			$this->output( "Skipping wiki due to non-shared users database\n" );
			return;
		}
		
		$wgUser = User::newFromName(self::USER_NAME);
		$bot = true;
		
		$time = $this->getOption( 'time' );
		$time = wfTimestamp( TS_UNIX, $time );
		if ( !$time ) {
			$this->error( 'Invalid time', true );
		}
		$time = wfTimestamp( TS_MW, $time );
		
		$users = explode('|', $this->getOption( 'users' ));
		foreach ($users as $user) {
			$username = User::isIP( $user ) ? $user : User::getCanonicalName( $user );
			if( !$username ) {
				$this->error( 'Invalid username', true );
			}
		}

		$summary = $this->getOption( 'summary', 'mass rollback' );
		$titles = array();
		$results = array();
		if( $this->hasOption( 'titles' ) ) {
			foreach( explode( '|', $this->getOption( 'titles' ) ) as $title ) {
				$t = Title::newFromText( $title );
				if( !$t ) {
					$this->error( 'Invalid title, ' . $title );
				} else {
					$titles[] = $t;
				}
			}
		} else {
			$titles = $this->getRollbackTitles( $users, $time );
		}

		if( !$titles ) {
			$this->output( "No suitable titles to be rolled back\n" );
			return;
		}
		
		$this->output( "Found " . count($titles) . " title(s) to process\n" );
		
		global $wgTitle;
		foreach ( $titles as $t ) {
			$wgTitle = $t;
			$this->output( 'Processing ' . $t->getPrefixedText() . '...' );
			$messages = '';
			$status = $this->rollbackTitle( $t, $users, $time, $summary, $messages );
			if ($status) {
				$this->output( "done ({$messages})\n" );
			} else {
				$this->output( "failed ({$messages})\n" );
			}
		}
	}

	/**
	 * Get all pages that should be rolled back for a given user
	 * @param $user String a name to check against rev_user_text
	 */
	private function getRollbackTitles( $users, $time ) {
		$dbr = wfGetDB( DB_SLAVE );
		$titles = array();
		$results = $dbr->select(
			array( 'page', 'revision' ),
			array( 'page_namespace', 'page_title' ),
			array( 
				'page_latest = rev_id', 
				'rev_user_text' => $users,
				"rev_timestamp >= \"{$time}\"",
			),
			__METHOD__,
			array(
				'ORDER BY' => 'page_namespace, page_title',
			)
		);
		while( $row = $dbr->fetchObject( $results ) ) {
			$titles[] = Title::makeTitle( $row->page_namespace, $row->page_title );
		}
		return $titles;
	}
	
	private function rollbackTitle( $title, $users, $time, $summary, &$messages = '' ) {
		global $wgUser;
		
		// build article object and find article id
		$a = new Article($title);
		$pageId = $a->getID();
		
		// check if article exists
		if ( $pageId <= 0 ) {
			$messages = 'page not found';
			return false;
		}
		
		// fetch revisions from this article
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'revision',
			array( 'rev_id', 'rev_user_text', 'rev_timestamp' ),
			array(
				'rev_page' => $pageId,
			),
			__METHOD__,
			array(
				'ORDER BY' => 'rev_id DESC',
			)
		);
		
		// find the newest edit done by other user
		$revertRevId = false;
		while ( $row = $dbw->fetchObject($res) ) {
			if ( !in_array( $row->rev_user_text, $users ) || $row->rev_timestamp < $time ) {
				$revertRevId = $row->rev_id;
				break;
			} 
		}
		$dbw->freeResult($res);
		
		
		if ($revertRevId) { // found an edit by other user - reverting
			$rev = Revision::newFromId($revertRevId);
			$text = $rev->getRawText();
			$status = $a->doEdit( $text, $summary, EDIT_UPDATE|EDIT_MINOR|EDIT_FORCE_BOT );
			if ($status->isOK()) {
				$messages = 'reverted';
				return true;
			} else {
				$messages = "edit errors: " . implode(', ',$status->getErrorsArray());
			}
		} else { // no edits by other users - deleting page
			$errorDelete = '';
			$status = $this->deleteArticle( $a, $summary, false, $errorDelete );
			if ($status) {
				$messages = 'deleted';
				return true;
			} else {
				$messages = "delete errors: " . $errorDelete;
			}
		}
		return false;
	}
	
	private function deleteArticle( $article, $reason, $suppress = false, &$error = '' ) {
		global $wgOut, $wgUser;
		$id = $article->getTitle()->getArticleID( Title::GAID_FOR_UPDATE );

		if ( wfRunHooks( 'ArticleDelete', array( &$article, &$wgUser, &$reason, &$error ) ) ) {
			if ( $article->doDeleteArticle( $reason, $suppress, $id ) ) {
				wfRunHooks( 'ArticleDeleteComplete', array( &$article, &$wgUser, $reason, $id ) );
				return true;
			}
		}
		return false;
	}
}

$maintClass = 'RollbackEditsMulti';
require_once( DO_MAINTENANCE );
