<?php

class MakerstudiosFeedIngester extends VideoFeedIngester {
	protected static $API_WRAPPER = 'MakerstudiosApiWrapper';
	protected static $PROVIDER = 'makerstudios';
	protected static $FEED_URL = 'https://vmsapi.makerstudios.com/v1/feed/mrss/wikia?allContent=true&authorization=X9XZGApFwPV9zeRhCP82mD5RwqI7x4xG';

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
			$this->logger->videoErrors( "ERROR: problem downloading content.\n" );
			return 0;
		}

		return $content;
	}

	public function import( $content = '', array $params = [] ) {
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
				$this->logger->videoSkipped( "Skipping video. " . $e->getMessage() );
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
		$videoData['thumbnail'] = $this->getOptionalField( 'thumbnail', 'url' );
		$videoData['duration'] = $this->getOptionalField( 'content', 'duration' );
		$videoData['published'] = strtotime( $this->getOptionalField( 'pubdate' ) );
		$videoData['keywords'] = str_replace( ',', ', ', $this->getOptionalField( 'keywords' ) );
		$videoData['provider'] = 'makerstudios';

		return $videoData;
	}

	private function getRequiredField( $fieldName ) {
		$tag = $this->currentVideo->getElementsByTagName( $fieldName );
		if ( empty( $tag ) ) {
			throw new MakerStudioException( "Missing required field: $fieldName\n" );
		}

		return $tag->item(0)->textContent;
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
			$this->numberCreatedVideos += $this->createVideo( $video );
		}
	}

	public function generateCategories( array $addlCategories ) {
		return [ 'Maker Studios' ];
	}
}

class MakerStudioException extends Exception {}