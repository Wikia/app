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
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Change <videogallery> tags to <gallery> for a specific wiki";
		$this->addOption( 'user', 'Username', false, true, 'u' );
		$this->addOption( 'test', 'Test', false, false, 't' );
	}

	public function execute() {
		global $wgUser, $wgStatsDB;

		$userName = $this->getOption( 'user', 'Maintenance script' );
		$test = $this->hasOption('test');

		$wgUser = User::newFromName( $userName );
		if ( !$wgUser ) {
			$this->error( "Invalid username", true );
		}
		if ( $wgUser->isAnon() ) {
			$wgUser->addToDatabase();
		}

		global $wgDBname;
		$this->output("Wiki: ".$wgDBname."\n");

		$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		if (!is_null($dbs)) {
			global $wgCityId;

			$query = "select ct_page_id, ct_wikia_id ".
					"from city_used_tags ".
					"where ct_kind = 'videogallery'".
					" and ct_wikia_id = {$wgCityId}";
			$res = $dbs->query($query);
			while ($row = $dbs->fetchObject($res)) {
				$ret = $this->replaceVideoGalleryTag($row->ct_page_id, $test);
			}
			$dbs->freeResult($res);
		}
	}

	public function replaceVideoGalleryTag ( $pageId, $test = null ) {
		global $wgTitle;

		$wgTitle = Title::newFromID( $pageId );
		if ( !$wgTitle ) {
			$this->error( "Invalid title", true );
		}

		$page = WikiPage::factory( $wgTitle );

		# Read the text
		$text = $page->getText();

		$text = preg_replace('/<(\/?)videogallery([^>]*)>/', '<$1gallery$2>', $text);
		$summary = 'Updating <videogallery> to <gallery>';

		# Do the edit
		$this->output( "Replacing page (".$wgTitle->getDBkey().") ... " );
		if ($test) {
			$this->output("(test: no changes) done\n");
		} else {
			$status = $page->doEdit( $text, $summary, EDIT_MINOR | EDIT_FORCE_BOT | EDIT_SUPPRESS_RC );

			if ( $status->isOK() ) {
				$this->output( "done\n" );
			} else {
				$this->output( "failed\n" );
				return 0;
			}
			if ( !$status->isGood() ) {
				$this->output( $status->getWikiText() . "\n" );
			}
		}

		return 1;
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

