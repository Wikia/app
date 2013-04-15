<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 15.04.13
 * Time: 17:55
 * To change this template use File | Settings | File Templates.
 */

require_once(__DIR__.'/UserCredentials.php');
require_once(__DIR__.'/GoogleWebmasterToolsClient.php');

class WebmasterToolsService {
	private $accounts = array();
	public function __construct( ) {
		$this->accounts = array(
		);
	}

	public function add( $wiki, $credentials ) {
		$client = new GoogleWebmasterToolsClient($credentials->getEmail(), $credentials->getPassword(), $wiki);
		$client->add_site();
		return $client->site_info();
	}

	public function verify( $wikiId, $credentials = null , $force = false ) {
		if ( !$credentials ) $credentials = $this->findAccount( $wikiId );
		if ( !$credentials ) return false;

		$info = $this->getInfo( $wikiId, $credentials );
		if( !$force && $info['verified'] ) return true;
		$client = new GoogleWebmasterToolsClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		return $client->verify_site();
	}

	public function getSites( $credentials ) {
		$client = new GoogleWebmasterToolsClient($credentials->getEmail(), $credentials->getPassword());

		return $client->get_sites();
	}

	public function getInfo( $wikiId, $credentials = null ) {
		if ( !$credentials ) $credentials = $this->findAccount( $wikiId );
		if ( !$credentials ) return null;

		$client = new GoogleWebmasterToolsClient($credentials->getEmail(), $credentials->getPassword(), $wikiId);
		return $client->site_info();
	}

	public function findAccount( $wikiId ) {
		foreach ( $this->accounts as $i => $u ) {
			$client = new GoogleWebmasterToolsClient($u->getEmail(), $u->getPassword(), $wikiId);
			if ( $client->site_info() ) return $u;
			//else {
			//	echo $u->getEmail() . " " . $u->getPassword() . " " . $wikiId . "\n";
			//}
		}
		return null;
	}
}
