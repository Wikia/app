<?php

abstract class BaseVideoProvider {

	/**
	 * Video object for this embed
	 *
	 * @var Video
	 */
	protected $video;

	/**
	 * Video ID
	 *
	 * @var string
	 */
	protected $videoId = null;

	/**
	 * Regular expression used to extract the video ID
	 *
	 * @var null
	 */
	protected $videoIdRegex = null;

	/**
	 * Template for embedding
	 *
	 * @var null
	 */
	protected $embedTemplate = null;

	public function __construct( $video ) {
		if ( !($video instanceof Video) ) {
			throw new MWException( 'Video Provider constructor given bogus video object.' );
		}

		$this->video = $video;
		// TODO: This sucks fix it
		$this->video->ratio = $this->getRatio();

		$matches = array();
		if ( $this->videoIdRegex !== null && preg_match( $this->videoIdRegex, $this->video->getURL(), $matches ) ) {
			$this->videoId = $matches[1];
		} else {
			$this->videoId = $this->extractVideoId( $this->video->getURL() );
		}

		if ( $this->videoId === null ) {
			return null;
		}
	}

	/**
	 * Function to extract the video id
	 *
	 * Override to use instead of regular expression
	 *
	 * @param $url
	 * @return null
	 */
	protected function extractVideoId( $url ) {
		return null;
	}

	/**
	 * Returns the raw HTML to embed the video
	 *
	 * @return string
	 */
	public function getEmbedCode() {
		if ( $this->embedTemplate === null ) {
			return '';
		}

		return str_replace( array(
				'$video_id',
				'$height',
				'$width',
			), array(
				$this->videoId,
				$this->video->getHeight(),
				$this->video->getWidth(),
			), $this->embedTemplate );
	}

	/**
	 * Returns the (aspect?) ratio for the video
	 *
	 * @return int
	 */
	protected function getRatio() {
		return 1;
	}

	/**
	 * Returns all domains associated with the provider
	 *
	 * @return array
	 */
	public static function getDomains() {
		return array();
	}

}