<?php
/**
 * lvsUpdateSuggestions
 *
 * This script examines all non-premium videos in a wiki and updates their LicensedVideoSwap (LVS) suggestions
 * if they don't have any or if the existing suggestions have expired.
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class LVSUpdateSuggestions
 */
class LVSUpdateSuggestions extends Maintenance {

	protected $verbose = false;
	protected $test    = false;
	protected $force   = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
		$this->addOption( 'force', 'Force a rebuild of all suggestions', false, false, 'f' );
	}

	public function execute() {
		$this->test = $this->hasOption('test') ? true : false;
		$this->verbose = $this->hasOption('verbose') ? true : false;
		$this->force = $this->hasOption('force') ? true : false;

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug("(debugging output enabled)\n");

		$startTime = time();

		// Clear existing suggestions if we are forcing a rebuild
		if ( $this->force ) {
			$this->clearSuggestions();
		}

		$this->processVideoList( );

		$delta = $this->formatDuration(time() - $startTime);

		$stats = $this->usageStats();

		$wgDBName = WikiFactory::IDtoDB($_ENV['SERVER_ID']);
		echo "[$wgDBName] Finished in $delta.\n";
		echo "[$wgDBName] Usage Stats: Total videos before swapping videos=".( $stats['totalVids'] + $stats['swapTypes'][2] + $stats['swapTypes'][3] ).", ";
		echo "Total videos=".$stats['totalVids']." (Videos with suggestions=".$stats['vidsWithSuggestions']."), ";
		echo "Total suggestions=".$stats['numSuggestions'].", Avg per video=".sprintf("%.1f", $stats['avgSuggestions']).", ";
		echo "Total kept videos=".$stats['swapTypes'][1].", Total swapped videos=".( $stats['swapTypes'][2] + $stats['swapTypes'][3] )." (Exact title=".$stats['swapTypes'][3].")\n";
	}

	/**
	 * Examine every non-premium video on this wiki and add suggestions where needed.
	 * @return array - An associative array of stats from processing the videos
	 */
	private function processVideoList() {
		wfProfileIn( __METHOD__ );

		$suggestDateProp = WPP_LVS_SUGGEST_DATE;
		$suggestExpire = time() - LicensedVideoSwapHelper::SUGGESTIONS_TTL;
		$pageNS = NS_FILE;

		// Only select videos with nonexistent or expired suggestions unless --force is on
		$whereExpired = '';
		if ( ! $this->force ) {
			$whereExpired = " AND (props IS NULL OR props <= $suggestExpire)";
		}

		// A list of all videos, returning the video title, its file page ID and
		$sql = "SELECT video_title as title,
					   page.page_id as page_id,
					   props as suggest_date
				  FROM video_info
				  JOIN page
				    ON video_title = page_title
				   AND page_namespace = $pageNS
				  LEFT JOIN page_wikia_props
				    ON page.page_id = page_wikia_props.page_id
				   AND propname = $suggestDateProp
				 WHERE removed = 0
				   AND premium = 0
				   $whereExpired";

		$db = wfGetDB( DB_SLAVE );
		$results = $db->query($sql);

		$lvsHelper = new LicensedVideoSwapHelper();

		$vidsFound = 0;
		$vidsWithSugggestions = 0;
		$totalSuggestions = 0;

		// Get the total count of relevant videos
		while( $row = $db->fetchObject($results) ) {
			$vidsFound++;
			$title = $row->title;

			$this->debug("Processing '$title'\n");

			// This sets page_wikia_props for WPP_LVS_SUGGEST_DATE, WPP_LVS_EMPTY_SUGGEST and WPP_LVS_SUGGEST
			$suggestions = $lvsHelper->suggestionSearch( $title, $this->test );

			if ( $suggestions ) {
				$vidsWithSugggestions++;
				$totalSuggestions += count($suggestions);

				$this->debug("\tFound ".count($suggestions)." suggestion(s)\n");
			} else {
				$this->debug("\tNo suggestions found\n");
			}
		}

		wfProfileOut( __METHOD__ );

		return array('vidsFound'           => $vidsFound,
					 'vidsWithSuggestions' => $vidsWithSugggestions,
					 'totalSuggestions'    => $totalSuggestions,
					);
	}

	/**
	 * Remove all existing suggestions
	 */
	public function clearSuggestions() {
		$sql = "delete from page_wikia_props
		 		where propname in (".WPP_LVS_SUGGEST.", ".WPP_LVS_SUGGEST_DATE.", ".WPP_LVS_EMPTY_SUGGEST.")";
		$db = wfGetDB( DB_MASTER );

		$db->query($sql);
	}

	public function usageStats() {
		$db = wfGetDB( DB_SLAVE );

		$sqlTotal = "SELECT count(*) as cnt
					 FROM video_info
					 WHERE removed = 0
					   AND premium = 0";

		$results = $db->query($sqlTotal);

		$totalVids = 0;
		while( $row = $db->fetchObject($results) ) {
			$totalVids = $row->cnt;
		}

		$sqlStatus = "select substr(props, locate('status\";i', props)+10, 1) as status,
		 			  count(*) as cnt
		 			  from page_wikia_props
		 			  where propname = 18
		 			  group by status";

		$results = $db->query($sqlStatus);

		$swapTypes = array('1' => 0,
						   '2' => 0,
						   '3' => 0);
		while( $row = $db->fetchObject($results) ) {
			$swapTypes[$row->status] = $row->cnt;
		}

		$sqlCounts = "select substring_index(substring_index(props, ':', 2), ':', -1) as suggestions
					  from page_wikia_props
					  where propname = 19";

		$results = $db->query($sqlCounts);

		$vidsWithSuggestions = 0;
		$numSuggestions = 0;
		while( $row = $db->fetchObject($results) ) {
			$vidsWithSuggestions++;
			$numSuggestions += $row->suggestions;
		}
		$avgSuggestions = empty( $vidsWithSuggestions ) ? 0 : $numSuggestions/$vidsWithSuggestions;

		return array("totalVids"           => $totalVids,
					 "vidsWithSuggestions" => $vidsWithSuggestions,
					 "numSuggestions"      => $numSuggestions,
					 "avgSuggestions"      => $avgSuggestions,
					 "swapTypes"           => $swapTypes,
					 );
	}


	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}

	/**
	 * Format a number in seconds into hours, minutes and seconds
	 * @param int $sec - A number in seconds
	 * @return string - A friendlier version of seconds expressed in hours, minutes and seconds
	 */
	private function formatDuration( $sec ) {
		$output = '';

		$min = $sec >= 60 ? $sec/60 : 0;
		$sec = $sec%60;

		$hour = $min >= 60 ? $min/60 : 0;
		$min = $min%60;

		if ( $hour ) {
			$output .= $this->addUnits($hour, 'hour');
		}
		if ( $hour || $min ) {
			$output .= (strlen($output) > 0 ? ' ' : '') . $this->addUnits($min, 'min');
		}
		$output .= (strlen($output) > 0 ? ' ' : '') . $this->addUnits($sec, 'sec');

		return $output;
	}

	/**
	 * Combine a number and a unit and pluralize when necessary
	 * @param $num - A number
	 * @param $unit - A unit for the number
	 * @return string - The combination of number and (possibly) pluralized unit
	 */
	private function addUnits( $num, $unit ) {
		$pl = $num == 1 ? '' : 's';
		return "$num $unit$pl";
	}
}

$maintClass = "LVSUpdateSuggestions";
require_once( RUN_MAINTENANCE_IF_MAIN );

