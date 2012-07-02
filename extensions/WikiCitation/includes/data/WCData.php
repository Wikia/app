<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


abstract class WCData {

	/**
	 * Tests whether $this can be considered a short form of argument $data.
	 * @param WCData $data
	 */
	abstract public function shortFormMatches( WCData $data );

}
