<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 15.04.13
 * Time: 17:55
 * To change this template use File | Settings | File Templates.
 */

class WebmasterToolsUtil {

	public function __construct( ) {
	}

	public function add( $wiki, $credentials ) {
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wiki);
		$client->add_site();
		return $client->site_info();
	}

	public function verify( $wikiId, $credentials = null , $force = false ) {
		if ( is_array($credentials) ) $credentials = $this->findAccount( $wikiId, $credentials );
		if ( !$credentials ) throw new InvalidArgumentException("$credentials = null");

		$info = $this->getInfo( $wikiId, $credentials );
		if( !$force && $info['verified'] ) return true;
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		return $client->verify_site();
	}

	public function getSites( $credentials ) {
		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword());

		return $client->get_sites();
	}

	public function getInfo( $wikiId, $credentials = null ) {
		if ( is_array($credentials) ) $credentials = $this->findAccount( $wikiId, $credentials );
		if ( !$credentials ) throw new InvalidArgumentException("$credentials = null");

		$client = new GWTClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		return $client->site_info();
	}

	public function findAccount( $wikiId, $accounts ) {
		foreach ( $accounts as $i => $u ) {
			$client = new GWTClient($u->getEmail(), $u->getPassword(), $wikiId);
			if ( $client->site_info() ) return $u;
			//else {
			//	echo $u->getEmail() . " " . $u->getPassword() . " " . $wikiId . "\n";
			//}
		}
		return null;
	}
}
