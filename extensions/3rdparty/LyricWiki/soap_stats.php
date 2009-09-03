<?php
////
// Author: Sean Colombo
// Date: 20061207
//
// This file has functions to log the SOAP stats.
// This runs as a sub-script of motive.php (ie: it uses the Motive Traffic
// database connection).
//
// Make sure soap_stats.sql has been installed to the mysql server first!
////

include_once 'motive.php';

////
// Logs a SOAP webservice hit and records whether the result was found
// successfully or not.
////
function lw_soapStats_logHit($resultsFound){
	lw_soapStats_term($resultsFound, "daily");
	lw_soapStats_term($resultsFound, "weekly");
	lw_soapStats_term($resultsFound, "monthly");
} // end lw_soapStats_logHit

// Just a wrapper for sending a query so that errors can be printed xor ignored more easily.
function lw_soapQuery($queryString){
	GLOBAL $motive_db;
	if(!mysql_query($queryString, $motive_db)){
		// Don't display errors in release version.
		//print "Error with query:<br/><em>$queryString</em><br/><strong>".mysql_error()."</strong><br/>\n";
	}
}

////
// Logs the SOAP hit for the given term, flushes old entries when their term
// is over.
////
function lw_soapStats_term($resultsFound, $term){
	GLOBAL $motive_db;
	switch($term){
	case "daily":
		$termValue = date("Ymd");
		break;
	case "weekly":
		$termValue = date("WY"); // this is ok because Year will always be 4 digits, so week can be one or two chars.
		break;
	case "monthly":
		$termValue = date("Ym");
		break;
	default:return; // it it isn't allowed... the queries would just bomb anyway
	}
	$tablePrefix = "lw_soap_";

	// Check to see if we are now in a new term.  If we are, delete the old values.
	$lastTerm = motive_simpleQuery("SELECT val FROM motive_map WHERE keyName='last_$term' LIMIT 1");
	if($lastTerm != $termValue){
		// Use lastTerm to avoid syncronization problems for multiple hits at nearly the same time.
		lw_soapQuery("DELETE FROM $tablePrefix"."ipLog_$term WHERE term='$lastTerm'");
		lw_soapQuery("UPDATE motive_map SET val='$termValue' WHERE keyName='last_$term'");
	}

	// Log the IP and increment the hits for the period.
	$site = motive_getSite();
	$ip = $_SERVER['REMOTE_ADDR'];
	if("" == motive_simpleQuery("SELECT hits FROM $tablePrefix"."ipLog_$term WHERE term='$termValue' AND site='$site' AND ip='$ip'")){
		// Log the hit as well as the addition of a unique IP.
		$queryString = "SELECT COUNT(*) FROM $tablePrefix"."traffic_$term WHERE site='$site' AND term='$termValue'";
		if(0 == motive_simpleQuery("SELECT COUNT(*) FROM $tablePrefix"."traffic_$term WHERE site='$site' AND term='$termValue'")){
			if($resultsFound){
				lw_soapQuery("INSERT INTO $tablePrefix"."traffic_$term (site, term, hits, uniqueIps, resultsFound, notFound) VALUES ('$site', '$termValue', hits+1, uniqueIps+1, resultsFound+1, notFound)");
			} else {
				lw_soapQuery("INSERT INTO $tablePrefix"."traffic_$term (site, term, hits, uniqueIps, resultsFound, notFound) VALUES ('$site', '$termValue', hits+1, uniqueIps+1, resultsFound, notFound+1)");
			}
		} else {
			$foundCol = ($resultsFound?"resultsFound":"notFound");
			lw_soapQuery("UPDATE $tablePrefix"."traffic_$term SET hits=hits+1, uniqueIps=uniqueIps+1, $foundCol=$foundCol+1 WHERE site='$site' AND term='$termValue'");
		}
		$queryString = "INSERT INTO $tablePrefix"."ipLog_$term (site,term,ip,hits,firstHit) VALUES ('$site', '$termValue', '$ip', hits+1, NOW())";
	} else {
		$foundCol = ($resultsFound?"resultsFound":"notFound");
		lw_soapQuery("UPDATE $tablePrefix"."traffic_$term SET hits=hits+1, $foundCol=$foundCol+1 WHERE site='$site' AND term='$termValue'");
		$queryString = "UPDATE $tablePrefix"."ipLog_$term SET hits=hits+1 WHERE term='$termValue' AND ip='$ip' AND site='$site'";
	}
	lw_soapQuery($queryString);
} // end lw_soapStats_term(...)

?>
