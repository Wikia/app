<?php
/**
 * Fix image attribution from WikiBot to the user who actually uploaded it
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class Dedupe extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Fix image attribution";
		$this->addOption( 'test', 'Test', false, false, 't' );
		$this->addOption( 'verbose', 'Verbose', false, false, 'v' );
		$this->addOption( 'file', 'Dupe file', true, true, 'f' );
	}

	public function execute() {
		global $wgExternalDatawareDB;

		$file = $this->getOption('file');
		$test = $this->hasOption('test');
		$verbose = $this->hasOption('verbose');

		if ($test) {
			$this->output("*** TEST MODE ***\n");
		}

		$sets = explode( "\n", file_get_contents( $file ) );

		$toDelete = [];

		foreach ( $sets as $set ) {
			$used = [];
			$unused = [];
			foreach ( $set as $title ) {
				if ( $this->titleInUse( $title ) ) {
					$used[] = $title;
				} else {
					$unused[] = $title;
				}
			}

			// See if any in this set are unused
			if ( count( $unused ) > 0 ) {
				// See if there are already some we're keeping
				if ( count( $used ) == 0 ) {
					// Not using any yet, keep at least one
					array_pop($unused);

				}
				$toDelete = array_merge( $toDelete, $unused );
			}

			if ( $test ) {
				echo "Deleting:".implode( "\n\t", $toDelete )."\n";
			} else {

			}
		}
	}

	public function titleInUse( $title ) {
		$db = wfGetDB( DB_SLAVE );

		$sql = "select 1 from globalimagelinks where gil_to = ".$db->addQuotes( $title );

		$res = $db->query($sql);

		while ($row = $db->fetchObject($res)) {
			// If we get anything back simply return true
			$db->freeResult($res);
			return true;
		}

		// If we're here, $title is not in use
		return false;
	}
}

$maintClass = "Dedupe";
require_once( RUN_MAINTENANCE_IF_MAIN );

