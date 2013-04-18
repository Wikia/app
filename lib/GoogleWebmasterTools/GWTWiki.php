<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 16:48
 */

class GWTWiki {
	private $wikiId;
	private $userId;
	private $uploadDate;

	function __construct( $wikiId, $userId, $uploadDate )
	{
		$this->userId = $userId;
		$this->wikiId = $wikiId;
		$this->uploadDate = $uploadDate;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setWikiId($wikiId)
	{
		$this->wikiId = $wikiId;
	}

	public function getWikiId()
	{
		return $this->wikiId;
	}

	public function setUploadDate($uploadDate)
	{
		$this->uploadDate = $uploadDate;
	}

	public function getUploadDate()
	{
		return $this->uploadDate;
	}

	public function getDb() {
		return WikiFactory::IDtoDB( $this->wikiId );
	}

	public function getUrl() {
		$wiki = WikiFactory::getWikiByID( $this->wikiId );
		return $this->normalize_site( $wiki );
	}

	private function normalize_site ( $site ) {
		if (!preg_match('!^http://!', $site)) $site = 'http://'.$site;
		if (!preg_match('!/$!', $site))       $site = $site.'/';

		return $site;
	}

	private function make_site_uri ( $wiki ) {
		$site = $this->normalize_site( $wiki->city_url );
		$uri = self::FEED_URI . '/sites/' . urlencode($site);
		return $uri;
	}
}
