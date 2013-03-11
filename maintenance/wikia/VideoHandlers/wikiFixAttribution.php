<?php
/**
 * Change <videogallery> to just <gallery> for a specific wiki
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class EditCLI extends Maintenance {
	const wikiaBotID = 4663069;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Fix video attribution";
		$this->addOption( 'test', 'Test', false, false, 't' );
	}

	public function execute() {
		global $wgExternalDatawareDB;

		$test = $this->hasOption('test');

		$dbw = wfGetDB(DB_MASTER, array());
		$dbDataware = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);

		if (!is_null($dbDataware)) {
			global $wgCityId;

			$query = "select img_name, img_user, img_user_text ".
					"from video_imagetable_backup ".
					"where img_user = " . self::wikiaBotID .
					" and wiki_id = " . $wgCityId;

			$this->output('-- Resetting attribution ');

			$res = $dbDataware->query($query);
			while ($row = $dbDataware->fetchObject($res)) {
				if ($test) {
					$this->output("\n[TEST] Assigning attribution to " . $row->img_user_text);
				} else {
					$this->output('.');
				}
				$ret = $this->fixAttribution($dbw, $row, $test);
			}
			$dbDataware->freeResult($res);
			$this->output(" done\n");
		}
	}

	public function fixAttribution ( $dbw, $row, $test = null ) {

		if (!$test) {
			// Update the image table
			$this->updateImageTable($dbw, $row);

			// Update the video_info table
			$this->updateVideoInfoTable($dbw, $row);
		}

		return 1;
	}

	public function updateImageTable ( $dbw, $row ) {
		$title = preg_replace('/^:/', '', $row->img_name);

		$sql = "update image " .
				"set img_user = " . $row->img_user . ', ' .
				"    img_user_text = " . $dbw->addQuotes($row->img_user_text) . ' ' .
				"where img_name = ". $dbw->addQuotes($title);
		$res = $dbw->query($sql);
	}

	public function updateVideoInfoTable ( $dbw, $row ) {
		$title = preg_replace('/^:/', '', $row->img_name);

		$sql = "update video_info " .
				"set added_by = " . $row->img_user . ' ' .
				"where video_title = ". $dbw->addQuotes($title);
		$res = $dbw->query($sql);
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

