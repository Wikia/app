<?php

/**
 * PHP Failsafe Fallback - checks the article's content and determines if it is 'easy'
 * or not
 *
 * @author Bartek Łapiński <bartek(at)wikia-inc.com>
 */

class FailsafeFallback
{

	public function checkWikitext( $wikitext ) {
		wfProfileIn(__METHOD__);

		/* basically, run through wikimarkup and decide, if it's 'easy' or not */

		wfProfileOut(__METHOD__);

		return true ; // as a default, let's assume it's good
	}
}
