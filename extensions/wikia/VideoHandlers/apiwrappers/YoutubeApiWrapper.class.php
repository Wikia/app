<?php

class YoutubeApiWrapper extends ApiWrapper {

	private $interfaceObj = null;

	protected static $API_URL = 'http://gdata.youtube.com/feeds/api/videos/$1?v=2&alt=json';
	private static $CACHE_KEY = 'youtubeapi';
	private static $CACHE_EXPIRY = 86400;

	public function __construct($videoId) {
		parent::__construct($videoId);
		$this->getInterfaceObject();
	}
	
	public function getTitle() {
		return $this->getVideoTitle();
	}
	
	public function getDescription() {
		$text = '';
		if ($this->getVideoCategory()) $text .= 'Category: ' . $this->getVideoCategory();
		if ($this->getVideoKeywords()) $text .= "\n\nKeywords: {$this->getVideoKeywords()}";
		return $text;
	}
	
	public function getThumbnailUrl() {
		$lowresUrl = '';
		$hiresUrl = '';
		
		$thumbnailDatas = $this->getVideoThumbnails();
		foreach ($thumbnailDatas as $thumbnailData) {
			switch ($thumbnailData['yt$name']) {
				case 'default':
					$lowresUrl = $thumbnailData['url'];
					break;
				case 'hqdefault':
					$hiresUrl = $thumbnailData['url'];
					break;
			}
		}
		
		return !empty($hiresUrl) ? $hiresUrl : $lowresUrl;
	}

	public function getMetadata() {
		$metadata = array();
		
		$metadata['videoId'] = $this->videoId;
		$metadata['published'] = $this->getVideoPublished();
		$metadata['category'] = $this->getVideoCategory();
		$metadata['canEmbed'] = $this->canEmbed();
		$metadata['hd'] = $this->isHdAvailable();
		$metadata['keywords'] = $this->getVideoKeywords();
		$metadata['duration'] = $this->getVideoDuration();
		
		return $metadata;
	}

	/**
	 * Connect to YouTube's API and retrieve a data structure containing the response
	 * @return type 
	 */
	protected function getInterfaceObject() {
		global $wgMemc;
		
		if ($this->interfaceObj == null) {
			$apiUrl = str_replace('$1', $this->videoId, self::$API_URL);
			$memcKey = wfMemcKey( self::$CACHE_KEY, $apiUrl ); 
			$response = $wgMemc->get( $memcKey );
			if (empty($response)) {
				$response = @Http::get($apiUrl);
				$wgMemc->set( $memcKey, $response, self::$CACHE_EXPIRY );				
			}
			$this->interfaceObj = json_decode($response, true);
		}
		
		return $this->interfaceObj;
	}

	/**
	 * Title
	 * @return string
	 */
	protected function getVideoTitle() {
		if (!empty($this->interfaceObj['entry']['title']['$t'])) {
			
			return $this->interfaceObj['entry']['title']['$t'];
		}
		
		return '';
	}
	
	/**
	 * User-defined description
	 * @return string
	 */
	protected function getVideoDescription() {
		if (!empty($this->interfaceObj['entry']['media$group']['media$description']['$t'])) {
			
			return $this->interfaceObj['entry']['media$group']['media$description']['$t'];
		}
		
		return '';
	}
	
	/**
	 * User-defined keywords
	 * @return array
	 */
	protected function getVideoKeywords() {
		if (!empty($this->interfaceObj['entry']['media$group']['media$keywords']['$t'])) {
			
			return $this->interfaceObj['entry']['media$group']['media$keywords']['$t'];
		}
		
		return '';
	}
	
	/**
	 * YouTube category
	 * @return string
	 */
	protected function getVideoCategory() {
		if (!empty($this->interfaceObj['entry']['media$group']['media$category'][0]['$t'])) {
			
			return $this->interfaceObj['entry']['media$group']['media$category'][0]['$t'];
		}
		
		return '';
	}
	
	/**
	 * Time that this feed entry was created, in UTC
	 * @return string
	 */
	protected function getVideoPublished() {
		if (!empty($this->interfaceObj['entry']['published']['$t'])) {
			
			return $this->interfaceObj['entry']['published']['$t'];
		}
		
		return '';
	}
	
	/**
	 * Video duration, in seconds
	 * @return int
	 */
	protected function getVideoDuration() {
		if (!empty($this->interfaceObj['entry']['media$group']['yt$duration']['seconds'])) {
			
			return $this->interfaceObj['entry']['media$group']['yt$duration']['seconds'];
		}
		
		return '';
	}
	
	/**
	 * returns array of thumbnail data. Thumbnails taken from different 
	 * points of video. Elements: time, height, width, url
	 * @return array
	 */
	protected function getVideoThumbnails() {
		if (!empty($this->interfaceObj['entry']['media$group']['media$thumbnail'])) {
			
			return $this->interfaceObj['entry']['media$group']['media$thumbnail'];
		}
		
		return array();
	}
	
	/**
	 * Is resolution of 720 or higher available
	 * @return boolean 
	 */
	protected function isHdAvailable() {
		return isset($this->interfaceObj['entry']['yt$hd']);
	}
	
	/**
	 * Can video be embedded
	 * @return boolean
	 */
	protected function canEmbed() {
		if (!empty($this->interfaceObj['entry']['yt$accessControl'])) {
			foreach ($this->interfaceObj['entry']['yt$accessControl'] as $accessControl) {
				if ($accessControl['action'] == 'embed') {
					return $accessControl['permission'] == 'allowed';
				}
			}
		}
		
		return true;
	}
}