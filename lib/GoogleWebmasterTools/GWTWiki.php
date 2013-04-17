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
}
