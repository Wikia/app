<?php
/**
 * Maintenance script to clean up after incomplete user renames
 * Sometimes user edits are left lying around under the old name,
 * check for that and assign them to the new username
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
 * @author Ariel Glenn <ariel@wikimedia.org>
 */

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class RenameUserCleanup extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Maintenance script to finish incomplete rename user, in particular to reassign edits that were missed";
		$this->addOption( 'olduser', 'Old user name', true, true );
		$this->addOption( 'newuser', 'New user name', true, true );
		$this->addOption( 'olduid', 'Old user id in revision records (DANGEROUS)', false, true );
		$this->mBatchSize = 1000;
	}

	public function execute() {
		$this->output( "Rename User Cleanup starting...\n\n" );
		$olduser = User::newFromName( $this->getOption( 'olduser' ) );
		$newuser = User::newFromName( $this->getOption( 'newuser' ) );
		$olduid = $this->getOption( 'olduid' );

		$this->checkUserExistence( $olduser, $newuser );
		$this->checkRenameLog( $olduser, $newuser );

		if ( $olduid ) {
			$this->doUpdates( $olduser, $newuser, $olduid );
		}
		$this->doUpdates( $olduser, $newuser, $newuser->getId() );
		$this->doUpdates( $olduser, $newuser, 0 );
		
		print "Done!\n";
		exit(0);
	}

	/**
	 * @param $olduser User
	 * @param $newuser User
	 */
	public function checkUserExistence( $olduser, $newuser ) {
		if ( !$newuser->getId() ) {
			$this->error( "No such user: " . $this->getOption( 'newuser' ), true );
			exit(1);
		}
		if ($olduser->getId() ) {
			print "WARNING!!: Old user still exists: " . $this->getOption( 'olduser' ) . "\n";
			print "proceed anyways? We'll only re-attribute edits that have the new user uid (or 0)";
			print " or the uid specified by the caller, and the old user name.  [N/y]   ";
			$stdin = fopen ("php://stdin","rt");
			$line = fgets($stdin);
			fclose($stdin);
			if ( $line[0] != "Y" && $line[0] != "y" ) {
				print "Exiting at user's request\n";
				exit(0);
			}
		}
	}

	/**
	 * @param $olduser User
	 * @param $newuser User
	 */
	public function checkRenameLog( $olduser, $newuser ) {
		$dbr = wfGetDB( DB_SLAVE );

		$oldTitle = Title::makeTitle( NS_USER, $olduser->getName() );

		$result = $dbr->select( 'logging', '*',
			array( 'log_type' => 'renameuser',
				'log_action'    => 'renameuser',
				'log_namespace' => NS_USER,
				'log_title'     => $oldTitle->getDBkey(),
				'log_params'    => $newuser->getName()
			     ),
			__METHOD__
		);
		if (! $result || ! $result->numRows() ) {
			// try the old format
			$result = $dbr->select( 'logging', '*',
			array( 'log_type' => 'renameuser',
				'log_action'    => 'renameuser',
				'log_namespace' => NS_USER,
				'log_title'     => $olduser->getName(),
			     ),
				__METHOD__
			);
			if (! $result ||  ! $result->numRows() ) {
				print "No log entry found for a rename of ".$olduser->getName()." to ".$newuser->getName().", proceed anyways??? [N/y] ";
				$stdin = fopen ("php://stdin","rt");
				$line = fgets($stdin);
				fclose($stdin);
				if ( $line[0] != "Y" && $line[0] != "y" ) {
					print "Exiting at user's request\n";
					exit(1);
				}
			} else {
				foreach ( $result as $row ) {
					print "Found possible log entry of the rename, please check: ".$row->log_title." with comment ".$row->log_comment." on $row->log_timestamp\n";
				}
			}
		} else {
			foreach ( $result as $row ) {
				print "Found log entry of the rename: ".$olduser->getName()." to ".$newuser->getName()." on $row->log_timestamp\n";
			}
		}
		if ($result && $result->numRows() > 1) {
			print "More than one rename entry found in the log, not sure what to do. Continue anyways? [N/y]  ";
			$stdin = fopen ("php://stdin","rt");
			$line = fgets($stdin);
			fclose($stdin);
			if ( $line[0] != "Y" && $line[0] != "y" ) {
				print "Exiting at user's request\n";
				exit(1);
			}
		}
	}

	/**
	 * @param $olduser User
	 * @param $newuser User
	 * @param $uid
	 */
	public function doUpdates( $olduser, $newuser, $uid ) {
		$this->updateTable( 'revision', 'rev_user_text', 'rev_user', 'rev_timestamp', $olduser, $newuser, $uid );
		$this->updateTable( 'archive', 'ar_user_text', 'ar_user', 'ar_timestamp',  $olduser, $newuser, $uid );
		$this->updateTable( 'logging', 'log_user_text', 'log_user', 'log_timestamp', $olduser, $newuser, $uid );
		$this->updateTable( 'image', 'img_user_text', 'img_user', 'img_timestamp', $olduser, $newuser, $uid );
		$this->updateTable( 'oldimage', 'oi_user_text', 'oi_user', 'oi_timestamp', $olduser, $newuser, $uid );
		$this->updateTable( 'filearchive', 'fa_user_text','fa_user', 'fa_timestamp', $olduser, $newuser, $uid );
	}

	/**
	 * @param $table
	 * @param $usernamefield
	 * @param $useridfield
	 * @param $timestampfield
	 * @param $olduser User
	 * @param $newuser User
	 * @param $uid
	 * @return int
	 */
	public function updateTable( $table, $usernamefield, $useridfield, $timestampfield, $olduser, $newuser, $uid ) {
		$dbw = wfGetDB( DB_MASTER );

		$contribs = $dbw->selectField( $table, 'count(*)',
			array( $usernamefield => $olduser->getName(), $useridfield => $uid ), __METHOD__ );

		if ( $contribs == 0 ) {
			print "No edits to be re-attributed from table $table for uid $uid\n" ;
			return(0);
		}

		print "Found $contribs edits to be re-attributed from table $table for uid $uid\n";
		if ( $uid != $newuser->getId() ) {
			print "If you proceed, the uid field will be set to that of the new user name (i.e. ".$newuser->getId().") in these rows.\n";
		}

		print "Proceed? [N/y]  ";
		$stdin = fopen ("php://stdin","rt");
		$line = fgets($stdin);
		fclose($stdin);
		if ( $line[0] != "Y" && $line[0] != "y" ) {
			print "Skipping at user's request\n";
			return(0);
		}

		$selectConds = array( $usernamefield => $olduser->getName(), $useridfield => $uid );
		$updateFields = array( $usernamefield => $newuser->getName(), $useridfield => $newuser->getId() );

		while ( $contribs > 0 ) {
			print "Doing batch of up to approximately ".$this->mBatchSize."\n";
			print "Do this batch? [N/y]  ";
			$stdin = fopen ("php://stdin","rt");
			$line = fgets($stdin);
			fclose($stdin);
			if ( $line[0] != "Y" && $line[0] != "y" ) {
				print "Skipping at user's request\n";
				return(0);
			}
			$dbw->begin();
			$result = $dbw->select( $table, $timestampfield, $selectConds , __METHOD__,
				array( 'ORDER BY' => $timestampfield.' DESC', 'LIMIT' => $this->mBatchSize ) );
			if (! $result) {
				print "There were rows for updating but now they are gone. Skipping.\n";
				$dbw->rollback();
				return(0);
			}
			$result->seek($result->numRows() -1 );
			$row = $result->fetchObject();
			$timestamp = $row->$timestampfield;
			$updateCondsWithTime = array_merge( $selectConds, array ("$timestampfield >= $timestamp") );
			$success = $dbw->update( $table, $updateFields, $updateCondsWithTime, __METHOD__ );
			if ( $success ) {
				$rowsDone = $dbw->affectedRows();
				$dbw->commit();
			} else {
				print "Problem with the update, rolling back and exiting\n";
				$dbw->rollback();
				exit(1);
			}
			//$contribs = User::edits( $olduser->getId() );
			$contribs = $dbw->selectField( $table, 'count(*)', $selectConds, __METHOD__ );
			print "Updated $rowsDone edits; $contribs edits remaining to be re-attributed\n";
		}
		return(0);
	}

}

$maintClass = "RenameUserCleanup";
require_once( RUN_MAINTENANCE_IF_MAIN );
