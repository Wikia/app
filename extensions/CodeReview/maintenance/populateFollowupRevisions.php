<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PopulateFollowupRevisions extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Populates followup revisions. Useful for setting them on old revisions, without reimporting";
		$this->addArg( 'repo', 'The name of the repo. Cannot be all.' );
		$this->addArg( 'revisions', "The revisions to set followups revisions for. Format: start:end" );
		$this->addOption( 'dry-run', 'Perform a dry run' );
	}

	public function execute() {
		$repoName = $this->getArg( 0 );

		if ( $repoName == "all" ) {
			$this->error( "Cannot use the 'all' repo", true );
		}

		$repo = CodeRepository::newFromName( $repoName );
		if ( !$repo ) {
			$this->error( "Repo '{$repoName}' is not a valid Repository", true );
		}

		$revisions = $this->getArg( 1 );
		if ( strpos( $revisions, ':' ) !== false ) {
			$revisionVals = explode( ':', $revisions, 2 );
		} else {
			$this->error( "Invalid revision range", true );
		}

		$start = intval( $revisionVals[0] );
		$end = intval( $revisionVals[1] );

		$revisions = range( $start, $end );

		$dryrun = $this->hasOption( 'dry-run' );

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'code_rev', '*', array( 'cr_id' => $revisions, 'cr_repo_id' => $repo->getId() ),
			__METHOD__ );

		foreach ( $res as $row ) {
			$rev = CodeRevision::newFromRow( $repo, $row );

			$affectedRevs = $rev->getUniqueAffectedRevs();

			$this->output( "r{$row->cr_id}: " );

			if ( count( $affectedRevs ) ) {
				$this->output( "associating revs " . implode( ',', $affectedRevs ) . "\n" );

				if ( !$dryrun ) {
					$rev->addReferencesTo( $affectedRevs );
				}
			} else {
				$this->output( "no revisions followed up\n" );
			}
		}
		$this->output( "Done!\n" );
	}
}

$maintClass = "PopulateFollowupRevisions";
require_once( DO_MAINTENANCE );
