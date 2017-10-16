<?php

class TwitchtvApiWrapper extends ApiWrapper {

	protected static $API_URL = 'https://api.twitch.tv/kraken/$2/$1';
	protected static $CACHE_KEY = 'twitchtvapi';
	protected static $aspectRatio = 1.7777778;

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "twitch.tv") ? true : false;
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$url = trim( $url, "/" );
		$parsed = explode( "/", $url );
		if( is_array($parsed) && count($parsed) < 5 ) {
			$videoId = array_pop( $parsed );
			if ( empty($videoId) ) {
				$videoId = array_pop( $parsed );
			}

			wfProfileOut( __METHOD__ );

			return new static( $videoId );
		}

		wfProfileOut( __METHOD__ );

		return null;
	}

	public function getDescription() {
		$description = $this->getOriginalDescription();
		if ( $category = $this->getVideoCategory() ) {
			$description .= "\n\nCategory: $category";
		}

		return $description;
	}

	protected function getOriginalDescription() {
		$description = "Name: ".$this->interfaceObj['name'];
		if ( isset($this->interfaceObj['game']) ) {
			$description .= "\n\nGame: {$this->interfaceObj['game']}";
		}
		if ( isset($this->interfaceObj['teams'][0]['display_name']) ) {
			$description .= "\n\nTeam: {$this->interfaceObj['teams'][0]['display_name']}";
		}

		return $description;
	}

	public function getThumbnailUrl() {
		$thumb = LegacyVideoApiWrapper::$THUMBNAIL_URL;

		$url = str_replace( '$2', 'streams', static::$API_URL );
		$url = str_replace( '$1', $this->videoId, $url );

		$content = ExternalHttp::get( $url );
		if ( !empty( $content ) ) {
			$result = json_decode( $content, true );
			if ( isset( $result['stream']['preview']['large'] ) ) {
				$thumb = $result['stream']['preview']['large'];
			} else if ( isset( $this->interfaceObj['video_banner'] ) ) {
				$thumb = $this->interfaceObj['video_banner'];
			}
		}

		return $thumb;
	}

	protected function getVideoTitle() {
		$title = ucfirst($this->interfaceObj['name']);
		if ( isset($this->interfaceObj['game']) ) {
			$title .= ' playing '.$this->interfaceObj['game'];
		}

		if ( isset($this->interfaceObj['teams'][0]['display_name']) ) {
			$title .= ' on '.$this->interfaceObj['teams'][0]['display_name'];
		}

		return $title;
	}

	protected function getVideoCategory(){
		return 'live gaming';
	}

	protected function getApiUrl() {
		$apiUrl = str_replace( '$2', 'channels', static::$API_URL );
		$apiUrl = str_replace( '$1', $this->videoId, $apiUrl );

		return $apiUrl;
	}

}