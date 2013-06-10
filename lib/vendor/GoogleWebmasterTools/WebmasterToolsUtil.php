<?php


class WebmasterToolsUtil {

	public function __construct( ) {
	}

	/*
	 * @param $wiki GWTWiki
	 * @param $credentials IUserCredentials
	 * @return - GWTSiteSyncStatus.
	 */
	public function add( $wiki, IGoogleCredentials $credentials ) {
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wiki);
		$client->add_site();
		return $client->site_info();
	}

	/*
	 * Sends verify request to google webmaster tools ( uses wgGoogleSiteVerification variable )
	 * @param $wikiId - id of wiki to verify (city_id)
	 * @param $credentials - ICredentials implementation. Google account credentials.
	 * @param $force - send verify request even if already verified.
	 * @return google verify response
	 */
	public function verify( $wikiId, IGoogleCredentials $credentials = null , $force = false ) {
		//if ( is_array($credentials) ) $credentials = $this->findAccount( $wikiId, $credentials );
		if ( !$credentials ) throw new InvalidArgumentException("credentials = null");

		$info = $this->getInfo( $wikiId, $credentials );
		if( $info == null ) {
			throw new GWTException("No info for wikiId = $wikiId.");
		}
		if( !$force && $info->getVerified() ) return true;
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		return $client->verify_site();
	}

	/*
	 * Sends sitemap to google webmaster tools
	 * @param $wikiId - id of wiki to verify (city_id)
	 * @param $credentials - ICredentials implementation. Google account credentials.
	*/
	public function sendSitemap( $wikiId, IGoogleCredentials $credentials ) {
		//if ( is_array($credentials) ) $credentials = $this->findAccount( $wikiId, $credentials );
		if ( !$credentials ) throw new InvalidArgumentException("credentials = null");

		//$info = $this->getInfo( $wikiId, $credentials );
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		$client->send_sitemap();
	}

	/*
	 * Sends information to given google account. Do this before verify
	 * @param $wikiId - id of wiki to verify (city_id)
	 * @param $credentials - ICredentials implementation. Google account credentials.
	 */
	public function upload( $wikiId, IGoogleCredentials $credentials ) {
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		$client->add_site();
	}

	/**
	 * Fetch all sites added to google webmaster toolkit account.
	 * @param $credentials - ICredentials implementation. Google account credentials.
	 * @return GWTSiteSyncStatus[]
	 */
	public function getSites( IGoogleCredentials $credentials ) {
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword());

		return $client->get_sites();
	}

	/**
	 * Gets wiki sync status
	 * @param $wikiId - city_id
	 * @param \IGoogleCredentials $credentials - google webmaster tools credentials.
	 * @throws InvalidArgumentException
	 * @return GWTSiteSyncStatus|null
	 */
	public function getInfo( $wikiId, IGoogleCredentials $credentials = null ) {
		//if ( is_array($credentials) ) $credentials = $this->findAccount( $wikiId, $credentials );
		if ( !$credentials ) throw new InvalidArgumentException("$credentials = null");

		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), intval($wikiId) );
		return $client->site_info();
	}

	public function findAccount( $wikiId, $accounts ) {
		foreach ( $accounts as $i => $u ) {
			/** @var IGoogleCredentials $u  */
			$client = new GWTClient($u->getEmail(), $u->getPassword(), $wikiId);
			if ( $client->site_info() ) { return $u; }
			//else {
			//	echo $u->getEmail() . " " . $u->getPassword() . " " . $wikiId . "\n";
			//}
		}
		return null;
	}
}
