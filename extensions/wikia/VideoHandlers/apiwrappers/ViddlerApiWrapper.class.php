<?php

class ViddlerApiWrapper extends ApiWrapper {
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_PHP;
	protected static $API_URL = 'http://api.viddler.com/api/v2/viddler.videos.getDetails.php?key=$1&add_embed_code=1&url=';
	protected static $WATCH_URL = 'http://www.viddler.com/explore/$1';
	protected static $CACHE_KEY = 'viddlerapi';
	
	protected function getVideoTitle() {
		return $this->interfaceObj['video']['title'];
	}
	
	public function getDescription() {
		$description = $this->getOriginalDescription();
		$keywords = $this->getVideoKeywords();
		if (!empty($keywords)) {
			$keywords = 'Keywords: ' . $keywords;
			if (!empty($description)) {
				$description .= "\n\n";
			}
			$description .= $keywords;
		}
		
		return $description;
	}
	
	public function getThumbnailUrl() {
		return $this->interfaceObj['video']['thumbnail_url'];
	}
	
	
	protected function getApiUrl() {
		global $wgViddlerApiKey;
		$watchUrl = str_replace( '$1', trim($this->videoId, '/'), static::$WATCH_URL );
		$apiUrl = str_replace( '$1', $wgViddlerApiKey, static::$API_URL ) . urlencode($watchUrl);
		return $apiUrl;
	}

	protected function getAltVideoId() {
		return $this->interfaceObj['video']['id'];
	}
	
	protected function getVideoDuration() {
		return $this->interfaceObj['video']['length'];
	}
	
	protected function getOriginalDescription() {
		return $this->interfaceObj['video']['description'];
	}
	
	protected function getVideoPublished() {
		return $this->interfaceObj['video']['made_public_time'];
	}
	
	protected function getVideoKeywords() {
		$keywords = array();
		if (!empty($this->interfaceObj['video']['tags']) && is_array($this->interfaceObj['video']['tags'])) {
			foreach ($this->interfaceObj['video']['tags'] as $tagArr) {
				$keywords[] = $tagArr['text'];
			}
		}
		return implode(', ', $keywords);
	}
	
	protected function getAspectRatio() {
		$embed_code = $this->interfaceObj['video']['embed_code'];
		$matches = array();
		if (preg_match('/width="(\d+)"/', $embed_code, $matches)) {
			$width = $matches[1];
			$matches = array();
			if (preg_match('/height="(\d+)"/', $embed_code, $matches)) {
				$height = $matches[1];
			}
		}
		
		if ($width && $height) {
			return $width / $height;
		}
			
		return '';			
	}
}