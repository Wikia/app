<?php
/**
 * Add the ==Description== text to video pages that don't have it
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class AddDescHeader extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Add the description header";
		$this->addOption( 'user', 'Username', false, true, 'u' );
		$this->addOption( 'test', 'Test', false, false, 't' );
	}

	public function execute() {
		global $wgUser;

		$userName = $this->getOption( 'user', 'WikiaBot' );
		$test = $this->hasOption('test') ? true : false;

		if (!$test) {
			$wgUser = User::newFromName( $userName );
			if ( !$wgUser ) {
				$this->error( "Invalid username", true );
			}
			if ( $wgUser->isAnon() ) {
				$wgUser->addToDatabase();
			}
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
				$ret = $this->addDescriptionHeader($row->page_id, $test);
			}
			$dbs->freeResult($res);
		}
	}

	/**
	 * @param $pageId integer The file page ID to add a description header to
	 * @param $test boolean Whether this is a test run or not
	 * @return boolean Whether the action succeeded
	 */
	public function addDescriptionHeader ( $pageId, $test = false ) {
		global $wgTitle, $wgServer;

		$wgTitle = Title::newFromID( $pageId );
		if ( !$wgTitle ) {
			$this->error( "Invalid title", true );
		}

		$page = WikiPage::factory( $wgTitle );

		// Read the text
		$text = $page->getText();

		$catText = '('.wfMessage( 'nstab-category' ).'|Category)';

		// Get the visible content by removing category tags
		$content = preg_replace("/\[\[$catText:[^\]]+\]\]/", '', $text);

		// Return early if there's no text at all (don't need a description header when there's nothing there)
		if ( trim($content) == '' ) {
			return true;
		}

		$headerText = wfMessage( 'videohandler-description' );

		// Return early if there's already a description header here
		if (preg_match("/^==\s*$headerText\s*==/mi", $text)) {
			return true;
		}

		$newText = "== $headerText ==\n".$text;

		$this->output( "Adding the description back: '".$wgServer.'/wiki/File:'.$wgTitle->getText()."' ... " );

		// Do the edit
		if ($test) {
			$this->output("(test) done\n");
		} else {
			$summary = 'Removing the description header';
			$status = $page->doEdit( $newText, $summary, EDIT_MINOR | EDIT_FORCE_BOT | EDIT_SUPPRESS_RC );

			if ( $status->isOK() ) {
				$this->output( "done\n" );
			} else {
				$this->output( "failed\n" );
				return false;
			}
			if ( !$status->isGood() ) {
				$this->output( $status->getWikiText() . "\n" );
			}
		}

		return true;
	}
}

$maintClass = "AddDescHeader";
require_once( RUN_MAINTENANCE_IF_MAIN );

