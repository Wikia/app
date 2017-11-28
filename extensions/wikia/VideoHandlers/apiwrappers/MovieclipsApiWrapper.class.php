<?php

class MovieclipsApiWrapper extends ApiWrapper {
	
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	// HTTPS-note: api.movieclips.com doesn't seem to work over https
	protected static $API_URL = 'http://api.movieclips.com/v2/videos/$1';
	protected static $CACHE_KEY = 'movieclipsapi';
	protected static $MOVIECLIPS_XMLNS = 'http://api.movieclips.com/schemas/2010';
	protected static $aspectRatio = 1.84210526;	// 560 x 304

	public static function isMatchingHostname( $hostname ) {
		return endsWith($hostname, "movieclips.com" ) ? true : false;
	}

	public static function newFromUrl( $url ) {
		$url = trim($url, '/');
		$parsed = explode( "/", $url );
		if( is_array( $parsed ) ) {
			return new static( array_pop( $parsed ) );
		}

		return null;
	}

	public function getTitle() {

		wfProfileIn( __METHOD__ );

		if (!empty($this->metadata['title'])) {
			wfProfileOut( __METHOD__ );
			return $this->metadata['title'];
		}

		$title = '';
		$title .= $this->getMovieTitleAndYear() . ' - ';
		$title .= $this->getVideoTitle();

		wfProfileOut( __METHOD__ );

		return $title;
	}

	protected function getMovieTitleAndYear() {
		if (!empty($this->metadata['movieTitleAndYear'])) {
			return $this->metadata['movieTitleAndYear'];
		}
		else {
			$description = $this->getOriginalDescription(false);
			preg_match('/(.+? \(\d{4}\)) - /', $description, $matches);
			if (is_array($matches) && sizeof($matches) > 1) {
				return $matches[1];
			}
		}

		return '';
	}

	protected function getVideoTitle() {
		if (!empty($this->metadata['videoTitle'])) {
			return $this->metadata['videoTitle'];
		}
		elseif (!empty($this->interfaceObj)) {
			return html_entity_decode( $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['title'][0]['data'] );
		}

		return '';
	}

	public function getDescription() {
		return $this->getOriginalDescription();
	}
	
	public function getThumbnailUrl() {
		if (!empty($this->metadata['thumbnailUrl'])) {
			return $this->metadata['thumbnailUrl'];
		}
		elseif (!empty($this->interfaceObj)) {
			$thumbnails = $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['group'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['thumbnail'];
			return $this->getLargestThumbnailUrl($thumbnails);
		}
		
		return '';
	}

	private function getLargestThumbnailUrl($thumbnails) {
		$highestVal = 0;
		$highestUrl = '';

		if (is_array($thumbnails)) {
			foreach ($thumbnails as $thumbnail) {
				if ($thumbnail['attribs']['']['height'] > $highestVal) {
					$highestUrl = $thumbnail['attribs']['']['url'];
				}
			}
		}

		return $highestUrl;
	}
		
	protected function getOriginalDescription($stripTitleAndYear=true) {

		wfProfileIn( __METHOD__ );
		if (!empty($this->metadata['description'])) {
			wfProfileOut( __METHOD__ );
			return $this->metadata['description'];
		}
		elseif (!empty($this->interfaceObj)) {
			$description = strip_tags( html_entity_decode( $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['content'][0]['data'] ) );
			if ($stripTitleAndYear) {
				$description = str_replace("{$this->getMovieTitleAndYear()} - {$this->getVideoTitle()} - ", '', $description);
			}
			wfProfileOut( __METHOD__ );
			return $description;
		}
		wfProfileOut( __METHOD__ );
		return '';		
	}
	
	protected function getVideoPublished() {
		if (!empty($this->metadata['published'])) {
			return $this->metadata['published'];
		}
		elseif (!empty($this->interfaceObj)) {
			return strtotime($this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['published'][0]['data']);
		}
		
		return '';
	}
	
	protected function getVideoDuration() {
		if (!empty($this->metadata['duration'])) {
			return $this->metadata['duration'];
		}
		elseif (!empty($this->interfaceObj)) {
			return $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['group'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['content'][0]['attribs']['']['duration'];
		}
		
		return '';
	}	
}