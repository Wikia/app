<?php
/**
 * Remove the ==Description== text from video pages that have it
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
		$this->mDescription = "Remove the description header";
		$this->addOption( 'user', 'Username', false, true, 'u' );
		$this->addOption( 'test', 'Test', false, false, 't' );
	}

	public function execute() {
		global $wgUser;

		$userName = $this->getOption( 'user', 'Maintenance script' );
		$test = $this->hasOption('test');

		$wgUser = User::newFromName( $userName );
		if ( !$wgUser ) {
			$this->error( "Invalid username", true );
		}
		if ( $wgUser->isAnon() ) {
			$wgUser->addToDatabase();
		}

		$dbs = wfGetDB(DB_SLAVE);
		if (!is_null($dbs)) {

			# Find all video file pages
			$query = "select page_id " .
					 "from page join video_info " .
					 "  on video_title=page_title " .
					 "where page_namespace = 6";
			$res = $dbs->query($query);

			while ($row = $dbs->fetchObject($res)) {
				$ret = $this->removeDescriptionHeader($row->page_id, $test);
			}
			$dbs->freeResult($res);
		}
	}

	public function removeDescriptionHeader ( $pageId, $test = null ) {
		global $wgTitle;

		$wgTitle = Title::newFromID( $pageId );
		if ( !$wgTitle ) {
			$this->error( "Invalid title", true );
		}

		$page = WikiPage::factory( $wgTitle );

		# Read the text
		$text = $page->getText();
		$newText = preg_replace('/^==\s*description\s*==/mi', '', $text);
		$changed = $newText == $text ? 0 : 1;

		$this->output( "Removing the description for '".$wgTitle->getText()."' ... " );
		if (!$changed) {
			$this->output("no match, skipping\n");
			return 1;
		}

		# Do the edit
		if ($test) {
			$this->output("(test: found header) done\n");
		} else {
			$summary = 'Removing the description header';
			$status = $page->doEdit( $newText, $summary, EDIT_MINOR | EDIT_FORCE_BOT | EDIT_SUPPRESS_RC );

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

