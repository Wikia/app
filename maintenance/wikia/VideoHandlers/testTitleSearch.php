<?php
/**
 * Try to find matches in our video library for youtube URLs
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class EditCLI extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Try to match youtube tags in the wiki with premium video";
		$this->addOption( 'title', 'Title', false, true, 't' );
		$this->addOption( 'verbose', 'Verbose', false, false, 'v' );
	}

	public function execute() {

		// See if we have a one off title search
		$title = $this->getOption( 'title' );

		// If we have a one off title, don't search this wiki for them
		if ($title) {
			$titles = array($title);
		} else {
			$tagTitles = $this->fromYouTubeTag();
			$embedTitles = $this->fromEmbedded();

			$titles = array_merge($tagTitles, $embedTitles);
		}

		$count = 0;
		$fuzzy = 0;
		$exact = 0;

		foreach ($titles as $youtube_title) {
			$premium_title = $this->closestMatch($youtube_title);
			$premium_title = preg_replace('/^file:/i', '', $premium_title);

			$this->log("# YouTube: $youtube_title\n" .
						  "# Premium: $premium_title\n" .
						  "# ------------------\n");

			$youtube_title = preg_replace('/"/', '""', $youtube_title);
			$premium_title = preg_replace('/"/', '""', $premium_title);

			$this->output('"'.$youtube_title.'","'.$premium_title.'"');
			$count++;

			$typed = 0;
			if ($premium_title == $youtube_title) {
				$exact++;
				$this->output(',"exact"');
				$typed = 1;
			}

			$norm_youtube_title = preg_replace('/[^0-9a-zA-Z]+/', '', $youtube_title);
			$norm_premium_title = preg_replace('/[^0-9a-zA-Z]+/', '', $premium_title);

			if (!$typed && ($norm_premium_title == $norm_youtube_title)) {
				$fuzzy++;
				$this->output(',"fuzzy"');
				$typed = 1;
			}

			if (!$typed) {
				$this->output(',"no match"');
			}

			$this->output("\n");
		}

		$this->log("\n# Found $exact exact matches, $fuzzy fuzzy matches of $count total\n\n");
	}

	function fromYouTubeTag () {
		$app = F::App();
		$titles = array();

		$dbs = wfGetDB(DB_SLAVE, array(), $app->wg->StatsDB);

		if (!is_null($dbs)) {
			$this->log("# -- Finding <youtube> tags ... ");

			$query = "select ct_page_id " .
				"from city_used_tags " .
				"where ct_kind = 'youtube' " .
				"  and ct_wikia_id = " . $app->wg->CityId;
			$res = $dbs->query($query);
			$this->log("done\n");

			while ($row = $dbs->fetchObject($res)) {
				$wgTitle = Title::newFromID( $row->ct_page_id );
				if ( !$wgTitle ) {
					$this->log("# Unable to create title for page ".$row->ct_page_id."\n");
					continue;
				}

				$page = WikiPage::factory( $wgTitle );

				$this->log('# '.$wgTitle->getFullText()."\n");

				# Read the text
				$text = $page->getText();
				preg_match_all('/<youtube[^>]*>([^<]+)<\/?youtube>/', $text, $matches);
				$found = $this->pullTitles($matches[1]);

				if ($found && count($found)) {
					$titles = array_merge($titles, $found);
				}
			}

			$dbs->freeResult($res);
		}
		return $titles;
	}

	function fromEmbedded () {
		$titles = array();

		$dbs = wfGetDB(DB_SLAVE);

		if (!is_null($dbs)) {
			$this->log("# -- Finding embedded youtube videos ... ");

			$query = "select img_name from image where img_major_mime = 'video' and img_minor_mime = 'youtube'";
			$res = $dbs->query($query);
			$this->log("done\n");

			while ($row = $dbs->fetchObject($res)) {
				$titles[] = preg_replace('/_/', ' ', $row->img_name);
			}

			$dbs->freeResult($res);
		}

		return $titles;
	}

	function pullTitles ( $matches ) {
		$titles = array();

		foreach ($matches as $key) {
			if (preg_match('/^http:/', $key)) {
				$url = $key;
			} else {
				$url = 'http://www.youtube.com/watch?v='.$key;
			}

			$url = trim($url);

			try {
				$youtube = YoutubeApiWrapper::newFromUrl($url);
			}
			catch( VideoIsPrivateException $e ) {
				echo ("# [ERROR] video is private: $url\n");
				continue;
			}
			catch( VideoNotFoundException $e ) {
				echo ("# [ERROR] video not found: $url\n");
				continue;
			}
			catch( NegativeResponseException $e ) {
				echo ("# [ERROR] negative response: $url\n");
				continue;
			}
			catch (Exception $e) {
				echo '# [ERROR] Caught exception: ',  $e->getMessage(), ": $url\n";
			}

			$t = $youtube->getTitle();

			if (trim($t) != '') {
				$titles[] = $t;
			}
		}

		return $titles;
	}

	function closestMatch ( $titleText ) {
		$app = F::App();
		$data = $app->sendRequest('WikiaSearchController', 'searchVideosByTitle',
								  array('title' => $titleText))->getData();

		if ( empty( $data[0]['title'] ) ) {
			return '';
		} else {
			return $data[0]['title'];
		}
	}

	private function log ( $msg ) {
		if ($this->hasOption('verbose')) {
			$this->output($msg);
		}
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

