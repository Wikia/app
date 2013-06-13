<?php

/**
 * Class GWTService
 */
class GWTService {
	/**
	 * @var GWTUserRepository|null
	 */
	private $userRepository;
	/**
	 * @var GWTWikiRepository|null
	 */
	private $wikiRepository;
	/**
	 * @var null|WebmasterToolsUtil
	 */
	private $webmasterToolsUtil;
	/**
	 * @var int
	 */
	private $maxSitesPerAccount = 495;

	/**
	 * @param null|GWTUserRepository $userRepository
	 * @param null|GWTWikiRepository $wikiRepository
	 * @param null|WebmasterToolsUtil $webmasterToolsUtil
	 */
	function __construct( $userRepository = null, $wikiRepository = null, $webmasterToolsUtil = null ) {
		if( $userRepository == null ) $userRepository = new GWTUserRepository();
		if( $webmasterToolsUtil == null ) $webmasterToolsUtil = new WebmasterToolsUtil();
		if( $wikiRepository == null ) $wikiRepository = new GWTWikiRepository();
		$this->userRepository = $userRepository;
		$this->webmasterToolsUtil = $webmasterToolsUtil;
		$this->wikiRepository = $wikiRepository;
	}

	/**
	 * Get all users that don't have to much sites added.
	 * @return GWTUser[]
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

	/**
	 * Get all wikis not marked as uploaded to google webmaster toolkit
	 * @return GWTWiki[]
	 */
	function getWikisToUpload() {
		$wikis = $this->wikiRepository->allUnassignedGt( 50 );
		return $wikis;
	}

	/**
	 * Sends page to webmaster toolkit. Will update wiki and user
	 * @param GWTWiki $wiki
	 * @param GWTUser $user
	 */
	function uploadWikiAsUser( GWTWiki $wiki, GWTUser $user ) {
		$this->webmasterToolsUtil->upload( $wiki->getWikiId(), $user );
		$user->setCount( $user->getCount() + 1 );
		$this->userRepository->update( $user );
		$wiki->setUserId( $user->getId() );
		$wiki->setUploadDate( date("Y-m-d") );
		$this->wikiRepository->updateWiki( $wiki );
	}

	/**
	 * Get wiki info.
	 * @param $wikiId - city_id
	 * @return null|GWTSiteSyncStatus
	 */
	function getWikiInfo( $wikiId ) {
		$wikiId = strval($wikiId);
		$wiki = $this->wikiRepository->getById( $wikiId );
		if( $wiki && $wiki->getUserId() ) {
			$user = $this->userRepository->getById( $wiki->getUserId() );
			return $this->webmasterToolsUtil->getInfo( $wikiId , $user );
		}
		return null;
	}

	/**
	 * Sends wiki verification request
	 * @param GWTWiki $wiki
	 * @param IGoogleCredentials $user
	 * @return mixed
	 */
	function verifyWiki( $wiki, $user ) {
		return $this->webmasterToolsUtil->verify( $wiki->getWikiId(), $user );
	}

	/**
	 * Sends sitemap to google webmaster tools.
	 * @param GWTWiki $wiki
	 * @param IGoogleCredentials $user
	 * @return mixed
	 */
	function sendSitemap( $wiki, $user ) {
		return $this->webmasterToolsUtil->sendSitemap( $wiki->getWikiId(), $user );
	}

	/**
	 * @param $maxSitesPerAccount
	 */
	public function setMaxSitesPerAccount($maxSitesPerAccount)
	{
		$this->maxSitesPerAccount = $maxSitesPerAccount;
	}

	/**
	 * @return int
	 */
	public function getMaxSitesPerAccount()
	{
		return $this->maxSitesPerAccount;
	}

	/**
	 * @return GWTUserRepository|null
	 */
	public function getUserRepository()
	{
		return $this->userRepository;
	}

	/**
	 * @return null|WebmasterToolsUtil
	 */
	public function getWebmasterToolsUtil()
	{
		return $this->webmasterToolsUtil;
	}

	/**
	 * @return GWTWikiRepository|null
	 */
	public function getWikiRepository()
	{
		return $this->wikiRepository;
	}

}
