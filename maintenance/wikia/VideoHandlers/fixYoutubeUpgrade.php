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
		global $wgTestMode;
		$wgTestMode = $this->getOption('test');

		if ($wgTestMode) {
			echo "=== TEST MODE ===\n";
		}

		$pages = $this->getPages();

		foreach ( $pages as $page ) {
			$this->fixTags($page);
		}

		exit( 0 );
	}

	/**
	 * Get all the pages in this wiki that have YouTube tags on them
	 * @return array
	 */
	public function getPages ( ) {
		$line = trim(fgets(STDIN));
		$pageKeys = explode("\t", $line);

		foreach ( $pageKeys as $dbKey ) {
			$page = Article::newFromTitle( $dbKey );
			if ( !empty($page) ) {
				$pages[] = $page;
			}
		}

		return $pages;
	}

	/**
	 * Fix broken [[File:...]] wiki tag
	 *
	 * @param Article $page - The page on which the tag exists
	 * @return bool - Whether this upgrade was successful
	 */
	public function fixTags ( Article $page ) {
		global $wgUser, $wgTestMode;

		$text = $page->getText();
		$matchFile = 'File|'.wfMessage('nstab-image')->text();

		$text = preg_replace_callback(
			"/\[\[((?:$matchFile):[\|]+)\|([0-9]+)([^\|\]]*)\]\]/i",
			function ($matches) {

				// Name the bits we're matching, for sanity
				$original = $matches[0];
				$file = $matches[1];
				$width = $matches[2];
				$suffix = $matches[3];

				echo "\tChecking '$original'\n";
				echo "\t- file: '$file' / width: $width / suffix: '$suffix'\n";

				// See if our width is suffixed by 'px' or not.  If so
				// leave it as is, unchanged.
				if ( preg_match('/^ *px/', $suffix) ) {
					echo "\t- Leaving unchanged";
					return $original;
				} else {
					$rewrite = "[[$file|${width}px]]";
					echo "\t- FIXING as '$rewrite\n";
					return $rewrite;
				}
			},
			$text
		);

		// Load wikia user
		$wgUser = User::newFromName( 'WikiaBot' );
		if ( !$wgUser ) {
			echo "WARN: Could not load WikiaBot user\n";
			return false;
		}

		if ( $wgTestMode ) {
			return true;
		}

		# Do the edit
		$status = $page->doEdit( $text, "Adding missing 'px' suffix to video pixel width",
								 EDIT_MINOR | EDIT_FORCE_BOT | EDIT_AUTOSUMMARY | EDIT_SUPPRESS_RC );

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

