<?php
/**
 * @author Sean Colombo
 * @date 20111005
 *
 * This class is used to process usage stats for ApiGate whether in-line or asynchronously after-the-fact
 * by processing log files.
 *
 * NOTE: Since the initial use-case for Wikia is processing all of the stats asynchronously, that will be implemented first.
 */


class ApiGate_StatsProcessor{

	/**
	 * Records a hit and enforces rate limits unless that is explicitly disabled in the call (see 'enforceRateLimits' param).
	 *
	 * @param apiKey - string - the API key of the app that made the request we are now logging
	 * @param method - string - the method-name that was called in this request (should include class-name if appropriate - eg: 'MyClass::myMethod').
	 * @param timestamp - int - number of seconds since the unix epoch at the time that this hit was made.
	 * @param params - array - array of key-value pairs of the parameters that were passed into the method
	 * @param enforceRateLimits - boolean - optional (default:true) - if true, then this function will check rate-limits after logging, and ban the apiKey if
	 *                                      it has surpassed any of its rate-limits.
	 */
	public function processHit( $apiKey, $method, $timestamp, $params, $enforceRateLimits = true){
		wfProfileIn( __METHOD__ );

		// TODO: IMPLEMENT
		// TODO: IMPLEMENT

		wfProfileOut( __METHOD__ );
	} // end processHit()

} // end class ApiGate_StatsProcessor
