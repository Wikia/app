<?php

class YoutubeApiWrapper extends ApiWrapper{

//	private static $interfaceObject;

	private $videoId;
//	private $videoEntry;
	
	public function __construct($videoId) {
		$this->videoId = $videoId;
	}

//	private static function getInterfaceObject() {
//		global $wgHTTPProxy;
//		
//		if (!isset(self::$interfaceObject)) {
//			$httpProxySettings = explode(':', $wgHTTPProxy);
//			$config = array(
//			    'adapter'    => 'Zend_Http_Client_Adapter_Proxy',
//			    'proxy_host' => $httpProxySettings[0],
//			    'proxy_port' => $httpProxySettings[1]
//			);
//			$proxiedHttpClient = new Zend_Http_Client(null, $config);
//			self::$interfaceObject = new Zend_Gdata_YouTube($proxiedHttpClient);
//		}
//		
//		return self::$interfaceObject;
//	}
//	
//	private function getVideoEntry() {
//		if (!isset($this->videoEntry)) {
//			$this->videoEntry = self::getInterfaceObject()->getVideoEntry($this->videoId);
//		}
//		
//		return $this->videoEntry;
//	}
//	
//	/**
//	 *
//	 * @return type string
//	 */
//	public function getVideoTitle() {
//		return $this->getVideoEntry()->getVideoTitle();
//	}
//	
//	/**
//	 *
//	 * @return type string
//	 */
//	public function getVideoDescription() {
//		return $this->getVideoEntry()->getVideoDescription();
//	}
//	
//	/**
//	 *
//	 * @return type array
//	 */
//	public function getVideoTags() {
//		return $this->getVideoEntry()->getVideoTags();
//	}
//	
//	/**
//	 *
//	 * @return type string
//	 */
//	public function getVideoCategory() {
//		return $this->getVideoEntry()->getVideoCategory();
//	}
//	
//	/**
//	 *
//	 * @return type 
//	 */
//	public function getVideoUploaded() {
//		return $this->getVideoEntry()->getMediaGroup()->getUploaded();
//	}
//	
//	/**
//	 * Video duration, in seconds
//	 * @return type int
//	 */
//	public function getVideoDuration() {
//		return $this->getVideoEntry()->getVideoDuration();		
//	}
//	
//	public function getDuration() {
//		return $this->getVideoEntry()->getMediaGroup()->getDuration();
//	}
//	
//	/**
//	 * returns array of thumbnail data. Thumbnails taken from different 
//	 * points of video. Elements: time, height, width, url
//	 * @return type array
//	 */
//	public function getVideoThumbnails() {
//		return $this->getVideoEntry()->getVideoThumbnails();
//	}
//	
//	public function getVideoState() {
//		return $this->getVideoEntry()->getVideoState();
//	}
//	
//	public function getVideoDeveloperTags() {
//		return $this->getVideoEntry()->getVideoDeveloperTags();
//	}
//	public function isVideoPrivate() {
//		return $this->getVideoEntry()->isVideoPrivate();
//	}
//	public function getVideoRatingInfo() {
//		return $this->getVideoEntry()->getVideoRatingInfo();
//	}
//	public function getDOM() {
//		return $this->getVideoEntry()->getDOM();
//	}
}