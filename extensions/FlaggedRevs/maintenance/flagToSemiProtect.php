<?php
/**
 * @ingroup Maintenance
 */
if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class FlagProtectToSemiProtect extends Maintenance {

	public function __construct() {
		$this->mDescription = 'Convert flag-protected pages to semi-protection.';
		$this->addOption( 'user', 'The name of the admin user to use as the "protector"', true, true );
		$this->addOption( 'reason', 'The reason for the conversion', false, true );
		$this->setBatchSize( 500 );
	}

	public function execute() {
		global $wgFlaggedRevsProtection;

		if ( !$wgFlaggedRevsProtection ) {
			$this->output( "\$wgFlaggedRevsProtection not enabled.\n" );
			return;
		}

		$user = User::newFromName( $this->getOption( 'user' ) );
		if ( !$user || !$user->getID() ) {
			$this->error( "Invalid user specified!", true );
		}
		$reason = $this->getOption( 'reason',
			"Converting flagged protection settings to edit protection settings." );

		$this->output( "Protecter username: \"" . $user->getName() . "\"\n" );
		$this->output( "Running in 5 seconds...Press ctrl-c to abort.\n" );
		sleep( 5 );

		$this->flag_to_semi_protect( $user, $reason );
	}

	protected function flag_to_semi_protect( User $user, $reason ) {
		global $wgFlaggedRevsNamespaces;

		$this->output( "Semi-protecting all flag-protected pages...\n" );
		if ( !$wgFlaggedRevsNamespaces ) {
			$this->output( "\$wgFlaggedRevsNamespaces is empty.\n" );
			return;
		}

		$db = wfGetDB( DB_MASTER );
		$start = $db->selectField( 'flaggedpage_config', 'MIN(fpc_page_id)', false, __FUNCTION__ );
		$end = $db->selectField( 'flaggedpage_config', 'MAX(fpc_page_id)', false, __FUNCTION__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output(  "...flaggedpage_config table seems to be empty.\n" );
			return;
		}
		# Do remaining chunk
		$end += $this->mBatchSize - 1;
		$blockStart = $start;
		$blockEnd = $start + $this->mBatchSize - 1;
		$count = 0;
		while ( $blockEnd <= $end ) {
			$this->output( "...doing fpc_page_id from $blockStart to $blockEnd\n" );
			$res = $db->select(
				array( 'flaggedpage_config', 'page' ),
				array( 'fpc_page_id', 'fpc_level', 'fpc_expiry' ), 
				array( "fpc_page_id BETWEEN $blockStart AND $blockEnd",
					'page_namespace' => $wgFlaggedRevsNamespaces,
					'page_id = fpc_page_id',
					"fpc_level != ''" ),
				__FUNCTION__
			);
			# Go through and protect each page...
			foreach ( $res as $row ) {
				$title = Title::newFromId( $row->fpc_page_id );
				if ( $title->isProtected( 'edit' ) ) {
					continue; // page already has edit protection - skip it
				}
				# Flagged protection settings
				$frLimit = trim( $row->fpc_level );
				$frExpiry = ( $row->fpc_expiry === $db->getInfinity() )
					? 'infinity'
					: wfTimestamp( TS_MW, $row->fpc_expiry );
				# Build the new protection settings
				$cascade = 0;
				$limit = $expiry = array();
				$desc = array(); // for output
				foreach ( $title->getRestrictionTypes() as $type ) {
					# Get existing restrictions for this action
					$oldLimit = $title->getRestrictions( $type ); // array
					$oldExpiry = $title->getRestrictionExpiry( $type ); // MW_TS
					# Move or Edit rights - take highest of (flag,type) settings
					if ( $type == 'edit' || $type == 'move' ) {
						# Sysop flag-protect -> full protect
						if ( $frLimit == 'sysop' || in_array( 'sysop', $oldLimit ) ) {
							$newLimit = 'sysop';
						# Reviewer/autoconfirmed flag-protect -> semi-protect
						} else {
							$newLimit = 'autoconfirmed';
						}
						# Take highest expiry of (flag,type) settings
						$newExpiry = ( !$oldLimit || $frExpiry >= $oldExpiry )
							? $frExpiry // note: 'infinity' > '99999999999999'
							: $oldExpiry;
					# Otherwise - maintain original limits
					} else {
						$newLimit = $oldLimit;
						$newExpiry = $oldExpiry;
					}
					$limit[$type] = $newLimit;
					$expiry[$type] = $newExpiry;
					$desc[] = "{$type}={$newLimit}: {$newExpiry}";
				}
				
				$db->begin();
				$article = new WikiPage( $title );
				$ok = $article->updateRestrictions( $limit, $reason, $cascade, $expiry, $user );
				if ( $ok ) {
					$count++;
				} else {
					$this->output( "Could not protect: " . $title->getPrefixedText() . "\n" );
				}
				$db->commit();
			}
			$db->freeResult( $res );
			$blockStart += $this->mBatchSize - 1;
			$blockEnd += $this->mBatchSize - 1;
			wfWaitForSlaves( 5 );
		}
		$this->output( "Protection of all flag-protected pages complete ... {$count} pages\n" );
	}
}

$maintClass = "FlagProtectToSemiProtect";
require_once( RUN_MAINTENANCE_IF_MAIN );
