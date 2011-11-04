<?php

/**
 * This is faken ExternalStoreDB class for active-active cluster. It does not
 * read data from local database but instead it reads data via HTTP from other
 * cluster
 *
 * Only supports reading, not storing.
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * @ingroup ExternalStorage
 */
class ExternalStoreDB {

	/**
	 * Fetch data from given URL
	 *
	 * @param $url String: the URL
	 * @return String: the content at $url
	 */
	function fetchFromURL( $url ) {
		wfProfileIn( __METHOD__ );

		/**
		 * use noProxy because we don't want to redirect this through localhost
		 * @see includes/HttpFunctions.php proxySetup()
		 */
		$ret = Http::get( $this->buildUrl( $url ), 'default', array( 'noProxy' => true ) );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * actually we never should be there but anyway we are handling that case
	 */
	function store( $cluster, $data ) {
		$wgOut = F::app()->getGlobal( "wgOut" );
		$wgOut->setPageTitle( 'DB Error' );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setStatusCode( 701 );
		$wgOut->clearHTML();
		exit;
	}

	/**
	 * @param string $url uri for blob resource
	 */
	private function buildUrl( $url ) {

		wfProfileIn( __METHOD__ );
		$app = F::app();

		$path = explode( '/', $url );
		$cluster  = $path[2];
		$id	  = $path[3];
		$query = wfArrayToCGI( array(
			"action" => "blob",
			"blobid" => $id,
			"cluster" => $cluster
		));

		$url = sprintf( "%s/api.php?%s", $app->getGlobal( "wgServer" ), $query );

		wfProfileOut( __METHOD__ );

		return $url;
	}
}
