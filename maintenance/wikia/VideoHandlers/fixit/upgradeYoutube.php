<?php
/**
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class UpgradeYoutube extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Find <youtube> tags and convert them to video files";
		$this->addOption('test', "Run this script without changing anything", false, false, 't');
	}

	public function execute() {
		global $wgTestMode, $wgUser;
		$wgTestMode = $this->getOption('test');

		if ($wgTestMode) {
			echo "=== TEST MODE ===\n";
		}

		// Load wikia user
		$wgUser = User::newFromName( Wikia::BOT_USER );
		if ( !$wgUser ) {
			echo "WARN: Could not load WikiaBot user\n";
			exit(1);
		}

		$pages = $this->getPages();

		foreach ( $pages as $page ) {
			$editors = $this->findEditors($page);

			if ( !empty($editors) ) {
				$this->convertTags($page, $editors);
			}
		}

		exit( 0 );
	}

	/**
	 * Get all the pages in this wiki that have YouTube tags on them
	 * @return array
	 */
	public function getPages ( ) {
		global $wgCityId, $wgStatsDB;

		// Find all pages in this wiki that have YouTube tags
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$sql = "SELECT ct_page_id FROM city_used_tags WHERE ct_wikia_id = $wgCityId and ct_kind = 'youtube'";
		$result = $dbr->query($sql);

		// Get an array of pages that have YT tags on them
		$pages = array();
		foreach ($result as $row) {
			$page = Article::newFromID($row->ct_page_id);
			if ( !empty($page) ) {
				$pages[] = $page;
			}
		}

		return $pages;
	}

	/**
	 * Find the proper editor for every tag added to this page
	 * @param Article $page - A page with Youtube tags
	 * @return array
	 */
	public function findEditors ( Article $page ) {
		global $wgTitle;

		$wgTitle = $page->getTitle();
		if ( !$wgTitle ) {
			echo "WARN: Could not find title '".$wgTitle->getDBkey()."'\n";
			return null;
		}
		echo '-- Scanning '.$wgTitle->getDBkey()."'\n";

		// Find all the youtube tags in the current version
		$text = $page->getText();
		if (preg_match_all('/(<nowiki>.*?<\/nowiki>)|(<youtube([^>]*)>([^<]+)<\/youtube>)/i', $text, $matches)) {
			$tagsToFind = array_filter($matches[4], 'trim');
			echo "\tFound ".count($tagsToFind)." <youtube> tag(s)\n";

			$noWiki = array_filter($matches[1], 'trim');
			if ( count($noWiki) > 0 ) {
				echo "\tFound ".count($noWiki)." <nowiki> tag(s)\n";
			}
		} else {
			echo "\tThis page no longer has any youtube tags\n";
			return null;
		}

		$ownersFound = array();
		foreach ($tagsToFind as $tag) {
			$ownersFound[$tag] = 'WikiaBot';
		}
		return $ownersFound;

/*
		$ownersFound = array();
		$limit = 100;
		$offset = 0;
	 	$done = false;
		$prevUserText = $page->getUserText();

		// Go back through as many revisions as necessary to find the authors of each tag found
		while ( !$done ) {
			// Get the next $limit revisions to check for YT tags
			$items = $this->getRevs( $page, $limit, $offset, HistoryPage::DIR_NEXT );
			$offset += $limit;

			if ( $items->numRows() ) {
				foreach ( $items as $row ) {
					// Get the text for this revision
					$r = Revision::newFromTitle($wgTitle, $row->rev_id);
					$text = $r->getRawText();

					// Check each tag
					foreach ( $tagsToFind as $tag ) {
						// If we haven't found the owner yet and we don't see $tag
						// anymore, mark this tag as found with the previous user_text
						if ( empty($ownersFound[$tag]) &&
							!preg_match("/<youtube[^>]*>".preg_quote($tag, '/')."<\/youtube>/i", $text) ) {
							$ownersFound[$tag] = $prevUserText;
						}
					}

					// If we've found owners for all the tags in this page, exit
					if ( count($ownersFound) == count($tagsToFind) ) {
						$done = true;
						break;
					}

					$prevUserText = $row->rev_user_text;
				}
			} else {
				// If there weren't any rows returned, we're done.  Associate the
				// tags with the current user and assume the first edit added the tag
				foreach ($tagsToFind as $tag) {
					if ( empty($ownersFound[$tag]) ) {
						$ownersFound[$tag] = $prevUserText;
					}
				}

				$done = true;
			}

			if ( count($tagsToFind) == 0 ) {
				$done = true;
			}
		}

		return $ownersFound;
*/
	}

	/**
	 * Get previous revisions of a page
	 * @param Article $page - The page to find previous revisions for
	 * @param int $limit - The number of history revisions to retrieve at once
	 * @param int $offset - How many revisions to skip before grabbing $limit
	 * @param int $direction - Whether to search forward or backward
	 * @return ResultWrapper - A list of rows from the revision table
	 */
	public function getRevs ( Article $page, $limit, $offset, $direction ) {
		$dbr = wfGetDB( DB_SLAVE );

		if ( $direction == HistoryPage::DIR_PREV ) {
			list( $dirs, $oper ) = array( "ASC", ">=" );
		} else { /* $direction == HistoryPage::DIR_NEXT */
			list( $dirs, $oper ) = array( "DESC", "<=" );
		}

		if ( $offset ) {
			$offsets = array( "rev_timestamp $oper '$offset'" );
		} else {
			$offsets = array();
		}

		$page_id = $page->getID();

		return $dbr->select( 'revision',
			Revision::selectFields(),
			array_merge( array( "rev_page=$page_id" ), $offsets ),
			__METHOD__,
			array( 'ORDER BY' => "rev_timestamp $dirs",
				'USE INDEX' => 'page_timestamp', 'LIMIT' => $limit )
		);
	}

	/**
	 * @param Article $page - The page that contains the text we need to update
	 * @param $editors - An associative array of editor to youtube tag
	 */
	public function convertTags ( Article $page, $editors ) {
		global $wgCityId, $wgCurPageID;

		foreach ( $editors as $ytTag => $userText ) {
			echo "\tAttributing YT tag ".trim($ytTag)." to '$userText'\n";

			$wgCurPageID = $page->getID();
			if ( ! $this->upgradeTag( $page, $ytTag, $userText ) ) {
				echo "NoConvert: $wgCityId,".$page->getID()."\n";
			}
		}
	}

	/**
	 * Convert the youtube tag to a [[File:...]] wiki tag
	 *
	 * @param Article $page - The page on which the tag exists
	 * @param $ytid - The Youtube tag ID
	 * @param $userText - The user who made the edit
	 * @return bool - Whether this upgrade was successful
	 */
	public function upgradeTag ( Article $page, $ytid, $userText ) {
		global $wgUser;
		global $wgTestMode, $wgCityId, $wgCurPageID, $wgChangeMade;

/*
		// Load the user who embedded this video
		$wgUser = User::newFromName( $userText );

		// Fall back to user WikiaBot if we can't find this user
		if ( !$wgUser ) {
			$wgUser = User::newFromName( Wikia::BOT_USER );
		}

		// If we still can't load the user, bail here
		if ( !$wgUser ) {
			echo "WARN: Could not load user $userText\n";
			return false;
		}
		if ( $wgUser->isAnon() ) {
			$wgUser->addToDatabase();
		}
*/

		$wgChangeMade = 0;

		$text = $page->getText();

		$text = preg_replace_callback(
			"/(<nowiki>.*?<\/nowiki>)|<youtube([^>]*)>(".preg_quote($ytid, '/').")<\/youtube>/i",
			function ($matches) {
				global $wgTestMode, $wgCityId, $wgCurPageID, $wgChangeMade;

				// Some limits and defaults
				$width_max  = 640;
				$height_max = 385;
				$width_def  = 425;
				$height_def = 355;

				// If this matched a <nowiki> tag (and thus no param or ytid, don't do anything
				if ( empty( $matches[3] ) ) {
					return $matches[0];
				}

				// Separate the Youtube ID and parameters
				$paramText = trim($matches[2]);
				$ytid      = $matches[3];

				// Parse out the width and height parameters
				$params = array();
				if ( preg_match_all('/(width|height)\s*=\s*["\']?([0-9]+)["\']?/', $paramText, $paramMatches) ) {
					$paramKeys = $paramMatches[1];
					$paramVals = $paramMatches[2];

					foreach ($paramKeys as $key) {
						$params[$key] = array_shift($paramVals);
					}
				}

				// Fill in a default value if none was given
				if ( empty( $params['height'] ) ) {
					$params['height'] = $height_def;
				}
				if ( empty ($params['width'] ) ) {
					$params['width']  = $width_def;
				}

				// Constrain the max height and width
				if ( $params['height'] > $height_max ) {
					$params['height'] = $height_max;
				}
				if ( $params['width'] > $width_max ) {
					$params['width'] = $width_max;
				}

				// If height is less than 30px they probably want this for audio.  Don't convert
				if ( $params['height'] < 30 ) {
					echo "\t[Skip:$wgCityId,$wgCurPageID] Ignoring tag meant for audio (height = ".$params['height'].")\n";
					return $matches[0];
				}

				if ( preg_match('/^https?:\/\//', $ytid) ) {
					$url = trim($ytid);
				} else {
					$url = 'https://www.youtube.com/watch?v='.trim($ytid);
				}

				$videoService = new VideoService();

				if ( $wgTestMode ) {
					echo "\t[TEST] Replacing: ".$matches[0]."\n" .
						 "\t            with: $url\n";
					return $matches[0];
				} else {
					try {
						$retval = $videoService->addVideo( $url );
					} catch (Exception $e) {
						echo "\t[Skip:$wgCityId,$wgCurPageID] Call to addVideo failed: ".$e->getMessage()."\n";
						return $matches[0];
					}
				}
				if ( is_array($retval) ) {
					list( $title, $videoPageId, $videoProvider ) = $retval;

					$wgChangeMade++;
					return "[[$title|".$params['width']."px]]";
				} else {
					echo "\t[Skip:$wgCityId,$wgCurPageID] Unable to upload video\n";
					return $matches[0];
				}
			},
			$text
		);

/*
		// Load wikia user
		$wgUser = User::newFromName( Wikia::BOT_USER );
		if ( !$wgUser ) {
			echo "WARN: Could not load WikiaBot user\n";
			return false;
		}
*/

		if ( $wgTestMode ) {
			return true;
		}

		if ( $wgChangeMade == 0 ) {
			echo "\tNo changes made, skipping edit\n";
			return true;
		}

		try {
			# Do the edit
			$status = $page->doEdit( $text, 'Automatically converting <youtube> tags and uploading video',
									 EDIT_MINOR | EDIT_FORCE_BOT | EDIT_AUTOSUMMARY | EDIT_SUPPRESS_RC );
		} catch ( Exception $e ) {
			echo "\t[Skip:$wgCityId,$wgCurPageID] Edit failed: ".$e->getMessage()."\n";
			return false;
		}

		$retval = true;
		if ( !$status->isGood() ) {
			echo "\t[Skip:$wgCityId,$wgCurPageID] Edit is not good: ".$status->getWikiText()."\n";
			$retval = false;
		}

		return $retval;
	}
}

$maintClass = "UpgradeYoutube";
require_once( RUN_MAINTENANCE_IF_MAIN );

