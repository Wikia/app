<?php

class MakerstudiosFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'AnyclipApiWrapper';
	protected static $PROVIDER = 'anyclip';
	protected static $FEED_URL = 'https://devvmsapi.makerstudios.com/v1/feed/mrss/makerdemo?authorization=og9znuMr26krIdkgV0HcPg8PdOwSwZdz&allContent=true';

	/** @var  DOMDocument */
	private $content;
	/** @var  DOMElement */
	private $currentVideo;
	private $videos = [];
	private $numberCreatedVideos = 0;
	private $params;

	public function downloadFeed() {

		print( "Connecting to "  . self::$FEED_URL . "...\n" );
		$content = $this->getUrlContent( self::$FEED_URL );
		if ( !$content ) {
			$this->videoErrors( "ERROR: problem downloading content.\n" );
			// TODO Throw exception here
			return 0;
		}

		return $content;
	}

	public function import( $content = '', $params = array() ) {
		$this->setParams( $params );
		$this->setContentAsXML( $content );
		$this->setVideosFromContent();
		$this->createVideos();
		return $this->numberCreatedVideos;
	}

	private function setParams( $params ) {
		$this->params = $params;
	}

	private function setContentAsXML( $content ) {
		$doc = new DOMDocument( '1.0', 'UTF-8' );
		@$doc->loadXML( $content );
		$this->content = $doc;
	}

	private function setVideosFromContent() {
		foreach( $this->content->getElementsByTagName('item') as $video ) {
			try {
				$this->setCurrentVideo( $video );
				$videoData = $this->getCurrentVideoData();
				$this->videos[] = $videoData;
			} catch ( Exception $e ) {
				// TODO Add skipping logging here
			}
		}
	}

	private function setCurrentVideo( $video ) {
		$this->currentVideo = $video;
	}

	private function getCurrentVideoData() {
		$videoData = [];
		$videoData['titleName'] = html_entity_decode( $this->getRequiredField( 'title' ) );
		$videoData['videoId'] = $this->getRequiredField( 'guid' );
		$videoData['description'] = $this->getOptionalField( 'description' );
		$videoData['keywords'] = $this->getOptionalField( 'keywords' );
		$videoData['thumbnail'] = $this->getOptionalField( 'thumbnail', 'url' );
		$videoData['published'] = strtotime( $this->getOptionalField( 'pubdate' ) );
		$videoData['uniqueName'] = $videoData['titleName'];

		return $videoData;
	}

	private function getRequiredField( $fieldName ) {
		$tag = $this->currentVideo->getElementsByTagName( $fieldName );
		if ( $tag ) {
			return $tag->item(0)->textContent;
		}
		throw new MakerStudioException();
	}

	private function getOptionalField( $fieldName, $attributeName = null ) {
		$value = '';
		$tag = $this->currentVideo->getElementsByTagName( $fieldName );
		if ( $tag->length ) {
			$value = is_null( $attributeName ) ?
				$tag->item(0)->textContent :
				$tag->item(0)->getAttribute( $attributeName );
		}
		return $value;
	}

	private function createVideos() {
		foreach( $this->videos as $video ) {
			$msg = '';
			$this->numberCreatedVideos += $this->createVideo( $video, $msg, $this->params );
		}
	}

	public function generateCategories( array $data, $categories ) {
		return [ 'Maker Studios' ];
	}

	// TODO: tie this into videoSkipped code.
	private function debugLog( $msg ) {
		if ( $this->debugMode() ) {
			echo $msg . "\n";
		}
	}
}

class MakerStudioException extends Exception {}
