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

		$dbw = wfGetDB(DB_MASTER);
		$dbr = wfGetDB(DB_SLAVE);
		$dbDataware = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);

		if (!is_null($dbDataware)) {
			global $wgCityId;

			$sql = "select img_name, img_user, img_user_text " .
				   "from image " .
				   "where img_user = " . self::wikiaBotID;

			global $wgDBname;
			$this->output("---- Resetting attribution on $wgDBname ");

			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject($res)) {
				// Figure out what user should really be used here
				$realUserInfo = $this->getRealUserInfo($dbDataware, $row->img_name);
				if (!$realUserInfo) {
					continue;
				}

				$this->output("\n" . ($test ? '[TEST]' : '') .
							  " Assigning attribution on '".$row->img_name .
							  "' to " . $realUserInfo['img_user_text']);

				$ret = $this->fixAttribution($dbw, $realUserInfo, $test);
			}
			$dbDataware->freeResult($res);
			$this->output(" done\n");
		}
	}

	public function getRealUserInfo ($db, $img_name) {
		global $wgCityId;

		$sql = "select img_user, img_user_text " .
			   "from video_imagetable_backup " .
			   "where img_name = " . $db->addQuotes(':'.$img_name) . ' '. 
			   "  and wiki_id = " . $wgCityId;

		$res = $db->query($sql);
		$row = $db->fetchObject($res);
		$db->freeResult($res);

		return $row ? array('img_name'      => $img_name,
							'img_user'      => $row->img_user,
							'img_user_text' => $row->img_user_text,
							)
					: null;
	}

	public function fixAttribution ( $dbw, $realUserInfo, $test = null ) {

		if (!$test) {
			// Update the image table
			$this->updateImageTable($dbw, $realUserInfo);

			// Update the video_info table
			$this->updateVideoInfoTable($dbw, $realUserInfo);
		}

		return 1;
	}

	public function updateImageTable ( $dbw, $realUserInfo ) {

		$sql = "update image " .
				"set img_user = " . $realUserInfo['img_user'] . ', ' .
				"    img_user_text = " . $dbw->addQuotes($realUserInfo['img_user_text']) . ' ' .
				"where img_name = ". $dbw->addQuotes($realUserInfo['img_name']);
		$res = $dbw->query($sql);
	}

	public function updateVideoInfoTable ( $dbw, $realUserInfo ) {

		$sql = "update video_info " .
				"set added_by = " . $realUserInfo['img_user'] . ' ' .
				"where video_title = ". $dbw->addQuotes($realUserInfo['img_name']);
		$res = $dbw->query($sql);
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

