<?php

class GWTService {
	private $userRepository;
	private $wikiRepository;
	private $webmasterToolsUtil;
	private $maxSitesPerAccount = 495;

	function __construct( $userRepository = null, $wikiRepository = null, $webmasterToolsUtil = null ) {
		if( $userRepository == null ) $userRepository = new GWTUserRepository();
		if( $webmasterToolsUtil == null ) $webmasterToolsUtil = new WebmasterToolsUtil();
		if( $wikiRepository == null ) $wikiRepository = new GWTWikiRepository();
		$this->userRepository = $userRepository;
		$this->webmasterToolsUtil = $webmasterToolsUtil;
		$this->wikiRepository = $wikiRepository;
	}

	/*
	 * Get all users that don't have to much sites added.
	 * @returns array of GWTClient.
	 */
	function getAvailableUsers() {
		$users = $this->userRepository->allCountLt( $this->getMaxSitesPerAccount() );
		$resultUsers = array();
		foreach( $users as $i => $u ) { /* @var $u GWTUser */
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

	/*
	 * Get all wikis not marked as uploaded to google webmaster toolkit.
	 * @returns array of GWTWiki.
	 */
	function getWikisToUpload() {
		$wikis = $this->wikiRepository->allUnassigned();
		return $wikis;
	}

	/*
	 * Sends page to webmaster toolkit. Will update wiki and user
	 *
	 */
	function uploadWikiAsUser( GWTWiki $wiki, GWTUser $user ) {
		$this->webmasterToolsUtil->upload( $wiki->getWikiId(), $user );
		$user->setCount( $user->getCount() + 1 );
		$this->userRepository->update( $user );
		$wiki->setUserId( $user->getId() );
		$wiki->setUploadDate( date("Y-m-d") );
		$this->wikiRepository->updateWiki( $wiki );
	}

	/*
	 * Get wiki info.
	 * @param $wikiId - city_id
	 * @return GWTSiteSyncStatus
	 */
	function getWikiInfo( $wikiId ) {
		$wikiId = strval($wikiId);
		$wiki = $this->wikiRepository->oneByWikiId( $wikiId );
		if( $wiki && $wiki->getUserId() ) {
			$user = $this->userRepository->getById( $wiki->getUserId() );
			return $this->webmasterToolsUtil->getInfo( $wikiId , $user );
		}
		return null;
	}

	/*
	 * Sends wiki verification request
	 * @return GWTSiteSyncStatus
	 */
	function verifyWiki( $wiki, $user ) {
		return $this->webmasterToolsUtil->verify( $wiki->getWikiId(), $user );
	}

	/*
	 * Sends sitemap to google webmaster tools.
	 * @return GWTSiteSyncStatus
	 */
	function sendSitemap( $wiki, $user ) {
		return $this->webmasterToolsUtil->sendSitemap( $wiki->getWikiId(), $user );
	}

	public function setMaxSitesPerAccount($maxSitesPerAccount)
	{
		$this->maxSitesPerAccount = $maxSitesPerAccount;
	}

	public function getMaxSitesPerAccount()
	{
		return $this->maxSitesPerAccount;
	}

	public function getUserRepository()
	{
		return $this->userRepository;
	}

	public function getWebmasterToolsUtil()
	{
		return $this->webmasterToolsUtil;
	}

	public function getWikiRepository()
	{
		return $this->wikiRepository;
	}

}
