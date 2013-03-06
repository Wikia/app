<?php
/**
 * Change <videogallery> to just <gallery>
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class EditCLI extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Change <videogallery> tags to <gallery>";
		$this->addOption( 'test', 'Test', false, false, 't' );
		$this->addOption( 'conf', 'Configuration file', true, true, 't' );
	}

	public function execute() {
		global $wgExternalDatawareDB;

		$conf = $this->getOption('conf');
		$test = $this->hasOption('test');

		if ($test) {
			$this->output("*** TEST MODE ***\n");
		}

		$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);

		if (!is_null($dbs)) {
			$this->output("== Finding wiki's with missattribution ... ");

			// Find all the distinct wikis that had videos migrated, about 45,000
			$query = "select distinct(wiki_id) as wiki_id " .
					"from video_imagetable_backup";
			$res = $dbs->query($query);
			$this->output("done\n");

			while ($row = $dbs->fetchObject($res)) {
				$this->output("== Fixing wiki ID: " . $row->wiki_id . "\n");
				$this->fixForWiki($conf, $row->wiki_id, $test);
			}
			$dbs->freeResult($res);
		}
	}

	public function fixForWiki ( $conf, $wikiId, $test = null ) {
		$dir = dirname( __FILE__ );
		$cmd = "SERVER_ID=$wikiId php $dir/wikiMigrateVideoGallery.php --conf $conf";
		if (isset($test)) {
			$cmd .= ' --test';
		}
		system($cmd, $retval);
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

