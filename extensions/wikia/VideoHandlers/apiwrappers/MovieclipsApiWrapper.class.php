<?php

class MovieclipsApiWrapper extends ApiWrapper {
	
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://api.movieclips.com/v2/videos/$1';
	protected static $CACHE_KEY = 'movieclipsapi';
	protected static $MOVIECLIPS_XMLNS = 'http://api.movieclips.com/schemas/2010';

	public function getTitle() {
		$title = '';
		$title .= $this->getMovieTitleAndYear() . ' - ';
		$title .= $this->getVideoTitle();
		return $title;
	}

	protected function getMovieTitleAndYear() {
		$description = $this->getOriginalDescription(false);
		preg_match('/(.+? \(\d{4}\)) - /', $description, $matches);
		if (is_array($matches) && sizeof($matches) > 1) {
			return $matches[1];
		}

		return '';
	}

	protected function getVideoTitle() {
		if (!empty($this->interfaceObj)) {
			return $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['title'][0]['data'];
		}

		return '';
	}

	public function getDescription() {
		return $this->getOriginalDescription();
	}
	
	public function getThumbnailUrl() {
		if (!empty($this->interfaceObj)) {
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
		if (!empty($this->interfaceObj)) {
			$description = strip_tags( html_entity_decode( $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['content'][0]['data'] ) );
			if ($stripTitleAndYear) {
				$description = str_replace("{$this->getMovieTitleAndYear()} - {$this->getVideoTitle()} - ", '', $description);
			}
			return $description;
		}
		
		return '';		
	}
	
	protected function getVideoPublished() {
		return strtotime($this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['published'][0]['data']);
	}
	
	protected function getVideoDuration() {
		return $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['group'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['content'][0]['attribs']['']['duration'];
	}	
}