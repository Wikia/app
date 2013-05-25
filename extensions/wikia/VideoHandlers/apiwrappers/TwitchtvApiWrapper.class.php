<?php

class TwitchtvApiWrapper extends ApiWrapper {

	protected $ingestion = true;

	protected static $API_URL = 'https://api.twitch.tv/kraken/$2/$1';
	protected static $CACHE_KEY = 'twitchtvapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "twitch.tv") ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$apiWrapper = null;

		$url = trim( $url, "/" );
		$parsed = explode( "/", $url );
		if( is_array($parsed) && count($parsed) < 5 ) {
			$videoId = array_pop( $parsed );
			if ( empty($videoId) ) {
				$videoId = array_pop( $parsed );
			}

			$apiWrapper = new static( $videoId );
			$apiWrapper->ingestion = false;
		}

		wfProfileOut( __METHOD__ );

		return $apiWrapper;
	}

	public function isIngestion() {
		return $this->ingestion;
	}

	public function getDescription() {
		$description = $this->getOriginalDescription();

		return $description;
	}

	protected function getOriginalDescription() {
		if ( !empty( $this->metadata['description'] ) ) {
			return $this->metadata['description'];
		}

		$description = "Name: ".$this->interfaceObj['name'];
		if ( isset($this->interfaceObj['game']) ) {
			$description .= "\n\nGame: {$this->interfaceObj['game']}";
		}
		if ( isset($this->interfaceObj['teams'][0]['display_name']) ) {
			$description .= "\n\nTeam: {$this->interfaceObj['teams'][0]['display_name']}";
		}

		return $description;
	}

	protected function loadMetadata(array $overrideFields = array()) {
		parent::loadMetadata($overrideFields);

		if ( !isset($metadata['videoUrl']) ) {
			$metadata['videoUrl'] = $this->getVideoUrl();
		}
		if ( !isset($metadata['channel']) ) {
			$metadata['channel'] = $this->getVideoChannel();
		}

		$this->metadata = array_merge( $this->metadata, $metadata );
	}

	public function getThumbnailUrl() {
		if ( !empty( $this->metadata['thumbnail'] ) ) {
			return $this->metadata['thumbnail'];
		}

		$url = str_replace( '$2', 'streams', static::$API_URL );
		$url = str_replace( '$1', $this->videoId, $url );
		$content = Http::get( $url );
		$result = json_decode( $content, true );
		if ( !empty( $result['stream']['preview'] ) ) {
			if ( is_array( $result['stream']['preview'] ) ) {
				$thumb = $result['stream']['preview']['large'];
			} else {
				$thumb = $result['stream']['preview'];
			}
		} else if ( isset($this->interfaceObj['video_banner']) ) {
			$thumb = $this->interfaceObj['video_banner'];
		} else {
			$thumb = LegacyVideoApiWrapper::$THUMBNAIL_URL;
		}

		return $thumb;
	}

	protected function getVideoTitle() {
		if ( !empty( $this->videoName ) ) {
			return $this->videoName;
		}

		$title = ucfirst($this->interfaceObj['name']);
		if ( isset($this->interfaceObj['game']) ) {
			$title .= ' playing '.$this->interfaceObj['game'];
		}

		if ( isset($this->interfaceObj['teams'][0]['display_name']) ) {
			$title .= ' on '.$this->interfaceObj['teams'][0]['display_name'];
		}

		return $title;
	}

	public function getAspectRatio() {
		return self::$aspectRatio;
	}

	protected function getVideoPublished() {
		if ( !empty($this->metadata['published']) ) {
			return $this->metadata['published'];
		}

		if ( !empty($this->interfaceObj['created_at']) ) {
			return strtotime( $this->interfaceObj['created_at'] );
		}

		return '';
	}

	protected function getVideoCategory(){
		if ( !empty( $this->metadata['category'] ) ) {
			return $this->metadata['category'];
		}

		return 'live gaming';
	}

	protected function getVideoKeywords() {
		if ( !empty( $this->metadata['keywords'] ) ) {
			return $this->metadata['keywords'];
		}

		if ( !empty( $this->interfaceObj['game'] ) ) {
			return $this->interfaceObj['game'];
		}

		return '';
	}

	protected function getVideoUrl() {
		if ( !empty( $this->metadata['videoUrl'] ) ) {
			return $this->metadata['videoUrl'];
		}

		if ( !empty( $this->interfaceObj['url'] ) ) {
			return $this->interfaceObj['url'];
		}

		return '';
	}

	protected function getVideoChannel() {
		if ( !empty( $this->metadata['channel'] ) ) {
			return $this->metadata['channel'];
		}

		if ( !empty( $this->interfaceObj['name'] ) ) {
			return $this->interfaceObj['name'];
		}

		return '';
	}

	protected function getApiUrl() {
		$apiUrl = str_replace( '$2', 'channels', static::$API_URL );
		$apiUrl = str_replace( '$1', $this->videoId, $apiUrl );

		return $apiUrl;
	}

}