<?php
/**
 * User: artur
 * Date: 18.04.13
 * Time: 10:11
 */

class GWTSiteSyncStatus {
	private $url;
	private $verified;

	function __construct($url, $verified)
	{
		$this->url = $url;
		$this->verified = $verified;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setVerified($verified)
	{
		$this->verified = $verified;
	}

	public function getVerified()
	{
		return $this->verified;
	}
}
