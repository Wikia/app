<?php
/**
 * @author: Sean Colombo
 * Date: <s>20061207</s> rewritten 20101017
 *
 * NOTE: ON 20101017, REWRITING TO USE MEMCACHE INSTEAD OF STORING THIS DATA TO MYSQL TABLES.
 * We'll have a webnumbr track the changes over time instead of storing this in the db.
 * Tracking this in mysql is way too much load, but using incr() in memcached is probably okay.
 */

define('LW_TERM_DAILY', 'daily');
define('LW_TERM_WEEKLY', 'weekly');
define('LW_TERM_MONTHLY', 'monthly');
define('LW_API_FOUND', 'FOUND');
define('LW_API_NOT_FOUND', 'NOT_FOUND');
define('LW_API_PERCENT_FOUND', 'PERCENT_FOUND');
define('LW_API_STATS_MEMKEY', 'LW_API_STATS');

/**
 * Logs a SOAP webservice hit and records whether the result was found
 * successfully or not.
 */
function lw_soapStats_logHit($resultsFound){
	wfProfileIn(__METHOD__);
	lw_soapStats_term($resultsFound, LW_TERM_DAILY);
	lw_soapStats_term($resultsFound, LW_TERM_WEEKLY);
	lw_soapStats_term($resultsFound, LW_TERM_MONTHLY);
	wfProfileOut(__METHOD__);
} // end lw_soapStats_logHit()

/**
 * Given a term type {daily, weekly, monthly}, and the actual date() value for that
 * term, returns the stats for that term if available.  By default, returns the stats
 * for the current day.  If a termValue isn't provided, regardless of the term-type,
 * the current timeperiod (today, this week, this month) will be used for the termValue.
 *
 * The results will be an associative array with keys of LW_API_FOUND, LW_API_NOT_FOUND,
 * and LW_API_PERCENT_FOUND.
 *
 * If a stat could not be found in memcached for a metric, 0 will be returned for that statistic.
 */
function lw_soapStats_getStats($termType = LW_TERM_DAILY, $termValue = ""){
	global $wgMemc;
	wfProfileIn(__METHOD__);
	
	if($termValue == ""){
		$termValue = lw_soapStats_currentTermValue($termType);
	}

	$foundKey = wfMemcKey(LW_API_STATS_MEMKEY, LW_API_FOUND, $termType, $termValue);
	$notFoundKey = wfMemcKey(LW_API_STATS_MEMKEY, LW_API_NOT_FOUND, $termType, $termValue);
	
	$numFound = $wgMemc->get($foundKey);
	$numNotFound = $wgMemc->get($notFoundKey);
	
	// Default to 0 if a value was not found.
	$numFound = ($numFound===null ? 0 : $numFound);
	$numNotFound = ($numNotFound===null ? 0 : $numNotFound);

	if(($numFound + $numNotFound) == 0){
		$percentFound = 0;
	} else {
		$percentFound = round(($numFound * 100) / ($numFound + $numNotFound));
	}

	$stats = array(
		LW_API_FOUND => $numFound,
		LW_API_NOT_FOUND => $numNotFound,
		LW_API_PERCENT_FOUND => $percentFound
	);

	return $stats;
	wfProfileOut(__METHOD__);
} // end lw_soapStats_getStats()

/**
 * Logs the SOAP hit for the given term, flushes old entries when their term
 * is over.
 */
function lw_soapStats_term($resultsFound, $term){
	global $wgMemc;
	wfProfileIn(__METHOD__);

	$termValue = lw_soapStats_currentTermValue($term);
	if($termValue === null){return;} // can't do anything useful if there is an invalid term-type.

	$memcKey = wfMemcKey(LW_API_STATS_MEMKEY, ($resultsFound ? LW_API_FOUND : LW_API_NOT_FOUND), $term, $termValue);

	// Incr doesn't create keys, so if incr fails: create the key.
	$result = $wgMemc->incr($memcKey);
	if($result === null){
		$EXP_DAYS = 32; // just over one months (the longest period we track).
		$EXP_IN_SECONDS = (60 * 60 * 24 * $EXP_DAYS);
		$wgMemc->set($memcKey, 1, strtotime("+$EXP_DAYS day"));
	}
	wfProfileOut(__METHOD__);
} // end lw_soapStats_term()

/**
 * Returns the term-value (a timestamp with enough info to represent
 * that duration) of the current term of the given type.  If the term-type
 * is not recognized {LW_TERM_DAILY, LW_TERM_WEEKLY, LW_TERM_MONTHLY}, then
 * null is returned.
 */
function lw_soapStats_currentTermValue($termType){
	switch($termType){
	case LW_TERM_DAILY:
		$termValue = date("Ymd");
		break;
	case LW_TERM_WEEKLY:
		$termValue = date("WY"); // this is ok because Year will always be 4 digits, so week can be one or two chars.
		break;
	case LW_TERM_MONTHLY:
		$termValue = date("Ym");
		break;
	default:
		$termValue = null; // fail
	}
	return $termValue;
} // end lw_soapStats_currentTermValue()

?>
