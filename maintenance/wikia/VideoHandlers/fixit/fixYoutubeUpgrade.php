<?php
/**
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class FixYoutubeUpgrade extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Fix problem created by upgradeYoutube script where 'px' was left off the width";
		$this->addOption('test', "Run this script without changing anything", false, false, 't');
	}

	public function execute() {
		global $wgTestMode, $wgUser;
		$wgTestMode = $this->getOption('test');

		if ($wgTestMode) {
			echo "=== TEST MODE ===\n";
		}

		// Load wikia user
		$wgUser = User::newFromName( 'WikiaBot' );
		if ( !$wgUser ) {
			echo "WARN: Could not load WikiaBot user\n";
			exit(1);
		}

		$pages = $this->getPages();

		foreach ( $pages as $pageID ) {
			$this->fixTags($pageID);
		}

		exit( 0 );
	}

	/**
	 * Get all the pages in this wiki that have YouTube tags on them
	 * @return array
	 */
	public function getPages ( ) {
		// Find all pages in this wiki that have YouTube tags
		$dbr = wfGetDB( DB_SLAVE );
		$sql = "select il_from
				from image, imagelinks
				where il_to = img_name
				  and img_major_mime = 'video'
				  and img_minor_mime = 'youtube'
				  and img_timestamp > '20130617000000'";

		$result = $dbr->query($sql);

		// Get an array of pages that have YT tags on them
		$pages = array();
		foreach ($result as $row) {
			$pages[] = $row->il_from;
		}

		return $pages;
	}

	/**
	 * Fix broken [[File:...]] wiki tag
	 *
	 * @param $pageID
	 * @return bool - Whether this upgrade was successful
	 */
	public function fixTags ( $pageID ) {
		global $wgUser, $wgTestMode;

		$page = Article::newFromID( $pageID );
		if ( empty($page) ) {
			echo "\tERROR: Couldn't load page ID $pageID\n";
			return false;
		}

		echo "Checking ".$page->getTitle()->getPrefixedDBkey()."\n";

		$text = $page->getText();
		$matchFile = 'File|'.wfMessage('nstab-image')->text();

		global $wgTagFixes;
		$wgTagFixes = 0;

		$text = preg_replace_callback(
			"/\[\[((?:$matchFile):[^\|\]]+)\|([0-9]+)([^\|\]]*)\]\]/i",
			function ($matches) {
				global $wgTagFixes;

				// Name the bits we're matching, for sanity
				$original = $matches[0];
				$file = $matches[1];
				$width = $matches[2];
				$suffix = $matches[3];

				echo "\tChecking '$original'\n";
				echo "\t- file: '$file' / width: $width / suffix: '$suffix'\n";

				// See if our width is suffixed by 'px' or not.  If so
				// leave it as is, unchanged.
				if ( preg_match('/^ *$/', $suffix) ) {
					$rewrite = "[[$file|${width}px]]";
					echo "\t- FIX AS '$rewrite\n";
					$wgTagFixes++;
					return $rewrite;
				} else {
					echo "\t- Leaving unchanged\n";
					return $original;
				}
			},
			$text
		);

		if ( $wgTagFixes == 0 ) {
			echo "\tNo changes for this article\n";
			return true;
		}

		if ( $wgTestMode ) {
			return true;
		}

		# Do the edit
		$status = $page->doEdit( $text, "Adding missing 'px' suffix to video pixel width",
								 EDIT_MINOR | EDIT_FORCE_BOT | EDIT_SUPPRESS_RC );

		$retval = true;
		if ( !$status->isGood() ) {
			echo "\t".$status->getWikiText()."\n";
			$retval = false;
		}

		return $retval;
	}
}

$maintClass = "FixYoutubeUpgrade";
require_once( RUN_MAINTENANCE_IF_MAIN );

