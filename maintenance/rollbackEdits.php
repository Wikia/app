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

require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class RollbackEdits extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Rollback all edits by a given user or IP provided they're the most recent edit";
		$this->addOption( 'titles', 'A list of titles, none means all titles where the given user is the most recent', false, true );
		$this->addOption( 'user', 'A user or IP to rollback all edits for', true, true );
		$this->addOption( 'summary', 'Edit summary to use', false, true );
		$this->addOption( 'bot', 'Mark the edits as bot' );
	}

	public function execute() {
		$user = $this->getOption( 'user' );
		$username = User::isIP( $user ) ? $user : User::getCanonicalName( $user );
		if ( !$username ) {
			$this->error( 'Invalid username', true );
		}

		$bot = $this->hasOption( 'bot' );
		$summary = $this->getOption( 'summary', $this->mSelf . ' mass rollback' );
		$titles = array();
		$results = array();
		if ( $this->hasOption( 'titles' ) ) {
			foreach ( explode( '|', $this->getOption( 'titles' ) ) as $title ) {
				$t = Title::newFromText( $title );
				if ( !$t ) {
					$this->error( 'Invalid title, ' . $title );
				} else {
					$titles[] = $t;
				}
			}
		} else {
			$titles = $this->getRollbackTitles( $user );
		}

		if ( !$titles ) {
			$this->output( 'No suitable titles to be rolled back' );
			return;
		}

		$doer = User::newFromName( 'Maintenance script' );

		foreach ( $titles as $t ) {
			$page = WikiPage::factory( $t );
			$this->output( 'Processing ' . $t->getPrefixedText() . '... ' );
			if ( !$page->commitRollback( $user, $summary, $bot, $results, $doer ) ) {
				$this->output( "done\n" );
			} else {
				$this->output( "failed\n" );
			}
		}
	}

	/**
	 * Get all pages that should be rolled back for a given user
	 * @param $username String a name to check against rev_user_text
	 * @return array
	 */
	private function getRollbackTitles( $username ) {
		$dbr = wfGetDB( DB_SLAVE );
		$titles = [];
		$conditions = [ 'page_latest = rev_id' ];

		// SUS-807
		$userId = User::idFromName( $username );
		if ( $userId ) {
			$conditions['rev_user'] = $userId;
		} else {
			$conditions['rev_user_text'] = $username;
		}

		$results = $dbr->select(
			[ 'page', 'revision' ],
			[ 'page_namespace', 'page_title' ],
			$conditions,
			__METHOD__
		);
		foreach ( $results as $row ) {
			$titles[] = Title::makeTitle( $row->page_namespace, $row->page_title );
		}
		return $titles;
	}
}

$maintClass = 'RollbackEdits';
require_once( RUN_MAINTENANCE_IF_MAIN );
