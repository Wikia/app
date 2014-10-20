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
		$this->addOption( 'user', 'Username', false, true, 'u' );
		$this->addOption( 'test', 'Test', false, false, 't' );
		$this->addOption( 'conf', 'Configuration file', true, true, 't' );
	}

	public function execute() {
		global $wgUser, $wgStatsDB;

		$conf = $this->getOption('conf');
		$userName = $this->getOption( 'user', 'Maintenance script' );
		$test = $this->hasOption('test');

		if ($test) {
			$this->output("=== TEST MODE ===\n");
		}

		$wgUser = User::newFromName( $userName );
		if ( !$wgUser ) {
			$this->error( "Invalid username", true );
		}
		if ( $wgUser->isAnon() ) {
			$wgUser->addToDatabase();
		}

		$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);

		if (!is_null($dbs)) {
			$this->output("-- Finding wiki's using <videogalery> ... ");
			// We are selecting everything here because we know there are only
			// about 900 rows that meet this criteria
			$query = "select distinct(ct_wikia_id) as wiki_id ".
					"from city_used_tags ".
					"where ct_kind = 'videogallery' ";
			$res = $dbs->query($query);
			$this->output("done\n");

			while ($row = $dbs->fetchObject($res)) {
				$this->output("-- Updating wiki ID: ". $row->wiki_id." --\n");
				$this->replaceForWiki($conf, $row->wiki_id, $userName, $test);
			}
			$dbs->freeResult($res);
		}
	}

	public function replaceForWiki ( $conf, $wikiId, $userName, $test = null ) {
		$dir = dirname( __FILE__ );
		$cmd = "SERVER_ID=$wikiId php $dir/wikiMigrateVideoGallery.php --conf $conf --user '$userName'";
		if ($test) {
			$cmd .= ' --test';
		}
		system($cmd, $retval);
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

