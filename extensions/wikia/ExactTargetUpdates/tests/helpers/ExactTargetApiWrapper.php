<?php
/**
 * Wrapper for ExactTargetApi which does not export sendRequest. For testing
 * purposes only.
 */

use Wikia\ExactTarget\ExactTargetApi;

class ExactTargetApiWrapper extends ExactTargetApi {

	public function sendRequest( $sType, $oRequestObject ) {
		return parent::sendRequest( $sType, $oRequestObject );
	}

}
