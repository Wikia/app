<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 12:19
 */

class GWTService {
	private $userRepository;
	private $wikiRepository;
	private $webmasterToolsUtil;
	private $maxSitesPerAccount = 495;

	function __construct( $userRepository, $wikiRepository, $webmasterToolsUtil )
	{
		if( $userRepository == null ) $userRepository = new GWTUserRepository();
		if( $webmasterToolsUtil == null ) $webmasterToolsUtil = new WebmasterToolsUtil();
		if( $wikiRepository == null ) $wikiRepository = new GWTWikiRepository();
		$this->userRepository = $userRepository;
		$this->webmasterToolsUtil = $webmasterToolsUtil;
		$this->wikiRepository = $wikiRepository;
	}

	function getAvailableUsers() {
		$users = $this->userRepository->allCountLt( $this->getMaxSitesPerAccount() );
		$resultUsers = array();
		foreach( $users as $i => $u ) {
			$sites = $this->webmasterToolsUtil->getSites( $u );
			if( $u->getCount() != count( $sites ) ) {
				$u->setCount( count( $sites ) );
				$this->userRepository->update( $u );
			}
			if ( $u->getCount() < $this->getMaxSitesPerAccount() ) {
				$resultUsers[] = $u;
			}
		}
		return $resultUsers;
	}

	function getWikisToUpload() {
		$wikis = $this->wikiRepository->allUnassigned();
		return $wikis;
	}

	function uploadWikiAsUser( $wiki, $user ) {
		$this->webmasterToolsUtil->upload( $wiki, $user );
	}

	function verifyWiki( $wiki, $user ) {
		return $this->webmasterToolsUtil->verify( $wiki->getId(), $user );
	}

	public function setMaxSitesPerAccount($maxSitesPerAccount)
	{
		$this->maxSitesPerAccount = $maxSitesPerAccount;
	}

	public function getMaxSitesPerAccount()
	{
		return $this->maxSitesPerAccount;
	}

}
