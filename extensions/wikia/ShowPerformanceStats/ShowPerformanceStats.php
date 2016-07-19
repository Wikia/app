<?php
/**
 * @author Sean Colombo
 *
 * This extensions returns human-readable performance stats
 * so that certain users can be made aware of how long load-time
 * took and what parts of the stack were responsible for that time.
 *
 * The metrics are stored in a cookie named 'loadtime' and currently
 * this extension is used to display the stats in the footer toolbar
 * in Oasis for WikiaStaff members.
 *
 * NOTE: Only varnish stats are available on most pages, the rest of the
 * stats are sampled.  At the time of this writing, 1% of cache-misses
 * get the detailed profiling (eg: CPU Duration, Apache time, etc.).
 *
 * Enable/disable this extension using the 'wgEnableShowPerformanceStatsExt'
 * WikiFactory variable.
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'ShowPerformanceStats',
	'author' => 'Sean Colombo',
	'descriptionmsg' => 'showperformancestats-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ShowPerformanceStats'
);

$wgExtensionMessagesFiles['ShowPerformanceStats'] = dirname(__FILE__) . '/ShowPerformanceStats.i18n.php';

function wfGetPerformanceStats(){
	wfProfileIn( __METHOD__ );
	$statsString = "";
	$precision = 3;

	$COOKIE_NAME = "loadtime";
	if(isset($_COOKIE[$COOKIE_NAME])){
		$data = explode(",", $_COOKIE[$COOKIE_NAME]);
		$metrics = array(); // associative array of metric-name (all uppercase) to its value.
		foreach($data as $dataPair){
			$matches = array();
			if(0 < preg_match("/^([a-zA-Z]+)([0-9\.]+)$/", $dataPair, $matches)){
				$metrics[strtoupper($matches[1])] = $matches[2];
			} else {
				trigger_error("Loadtime cookie had data that we couldn't parse: \"$dataPair\"", E_USER_NOTICE);
			}
		}

		// NOTE: Each metric should be treated as optional.  Full metrics are only on 1% of cache-misses.
		if(isset($metrics['VS']) && isset($metrics['VE'])){
			$statsString .= ($statsString == "" ? "" : ", ");
			$statsString .= wfMsg('performancestat-total', round(($metrics['VE'] - $metrics['VS'])/1000, $precision));
		}
		if(isset($metrics['AS']) && isset($metrics['AE'])){
			$statsString .= ($statsString == "" ? "" : ", ");
			$statsString .= wfMsg('performancestat-apache', round(($metrics['AE'] - $metrics['AS'])/1000, $precision));
		}
		if(isset($metrics['CD'])){
			$statsString .= ($statsString == "" ? "" : ", ");
			$statsString .= wfMsg('performancestat-cpu', round(($metrics['CD'])/1000, $precision));
		}
	}

	wfProfileOut( __METHOD__ );
	return $statsString;
} // end wfGetPerformanceStats()
