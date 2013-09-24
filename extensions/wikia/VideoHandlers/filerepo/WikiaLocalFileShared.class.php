<?php
/**
 * Leaf to WikiaLocalFile Composite
 *
 * Handles logic shared through Wikia LocalFile Wrappers
 */

class WikiaLocalFileShared  {

	var $forceMime = '';
	var $oFile = null;
	var $videoId = '';
	var $trackingArticleId = false;
	var $embedCodeMaxHeight = false;
	var $metadata = null;

	/**
	 * @param $oWikiaLocalFile WikiaLocalFile
	 */
	function __construct( $oWikiaLocalFile ) {
		$this->oFile = $oWikiaLocalFile;
	}

	/**
	 * Checks if file is a video
	 * @return boolean true if this file is a video, false otherwise
	 */
	public function isVideo() {
		wfProfileIn( __METHOD__ );
		$ret = ($this->oFile->getHandler() instanceof VideoHandler);
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Embed code max height
	 */
	public function setEmbedCodeMaxHeight( $height ) {
		$this->embedCodeMaxHeight = $height;
	}

	public function addExtraBorder( $width ) {
		if ( $this->isVideo() ) {
			return ($this->oFile->getHandler()->addExtraBorder( $width ));
		}
		return 0;
	}

	/**
	 * Returns embed HTML
	 *
	 * @param string $width Desired width of video player
	 * @param bool $autoplay Whether the video should play on page load
	 * @param bool $isAjax Whether the curent request is part of an ajax call
	 * @param bool $postOnload
	 * @return bool|string
	 */
	public function getEmbedCode( $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		wfProfileIn( __METHOD__ );
		if ( ( $this->trackingArticleId !== false ) && ( F::app()->wg->title instanceof Title ) ) {
			$this->trackingArticleId = F::app()->wg->title->getArticleID();
		}
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty($handler) ) {
			if ( $this->embedCodeMaxHeight !== false && $this->embedCodeMaxHeight > 0 ) {
				$handler->setMaxHeight( $this->embedCodeMaxHeight );
			}
			$handler->setThumbnailImage( $this->oFile->transform( array( 'width' => $width ) ) );
			$this->trackingArticleId = false;
			$res = $handler->getEmbed( $this->trackingArticleId, $width, $autoplay, $isAjax, $postOnload );
			$res['title'] = $this->oFile->getTitle()->getDBKey();
			$res['provider'] = $this->getProviderName();
		} else {
			$this->trackingArticleId = false;
			$res = false;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getPlayerAssetUrl() {

		wfProfileIn( __METHOD__ );
		if ( $this->isVideo() ) {
			$asset = $this->oFile->getHandler()->getPlayerAssetUrl();
			$res = $asset;
		}
		else {
			$res = false;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getVideoUniqueId() {
		return $this->getProviderName() . $this->getVideoId();
	}

	public function getProviderName() {
		return $this->metaValue('provider', $this->oFile->minor_mime);
	}

	/**
	 * Get the metadata description field.  There is a description field on the image
	 * table so this calls out that this grabs the metadata description
	 */
	public function getMetaDescription() {
		return $this->metaValue('description');
	}

	/**
	 * get duration from metadata
	 * @return string
	 */
	public function getMetadataDuration() {
		return $this->metaValue('duration');
	}

	public function getProviderDetailUrl() {
		wfProfileIn( __METHOD__ );
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty( $handler ) ) {
			$detail = $handler->getProviderDetailUrl();
			wfProfileOut( __METHOD__ );
			return $detail;
		}
		wfProfileOut( __METHOD__ );
		return false;
	}

	public function getProviderHomeUrl() {
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty( $handler ) ) {
			return $handler->getProviderHomeUrl();
		}

		return false;
	}

	public function getExpirationDate() {
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty( $handler ) ) {
			return $handler->getExpirationDate();
		}

		return false;
	}

	/**
	 * Force file to use some specyfic mimetype
	 *
	 * MediaWiki is getting mime type directly from a file.
	 * Need to alter this behavior for videos
	 * as they are represented in filesystem by an image
	 */
	function forceMime( $aMime ) {
		$this->forceMime = $aMime;
	}

	/**
	 * Used only as part of video migration process (prevent
	 * connecting to Provider, because we take metadata from
	 * previously stored information)
	 * and in video ingestion scripts from premium partners
	 *
	 * @param $metadata
	 */
	function forceMetadata( $metadata ) {
		$this->forceMetadata = $metadata;
	}

	function setVideoId( $videoId ) {
		$this->videoId = $videoId;
	}

	function getVideoId() {
		if ( empty( $this->videoId ) ) {
			$this->videoId = $this->metaValue('videoId');
		}

		return $this->videoId;
	}

	/**
	 * Alter LocalFile getHandler logic
	 *
	 * @param $handler
	 */
	function afterGetHandler( &$handler ) {
		wfProfileIn( __METHOD__ );
		if ( !empty($handler) && $handler instanceof VideoHandler ) {
			// make sure that the new handler ( if video ) will have videoId
			if ( $this->oFile->media_type == MEDIATYPE_VIDEO ) {
				$videoId = $this->getVideoId();
				if ( !empty( $videoId ) ) {
					$handler->setVideoId( $videoId );
				}
				$handler->setTitle($this->oFile->getTitle()->getText());
				$handler->setMetadata($this->oFile->metadata);
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Alter LocalFile setProps logic
	 */
	function afterSetProps() {
		global $wgMediaHandlers;

		if ( $this->forceMime ) {
			// if mime type was forced, repopulate File with proper data
			$this->oFile->dataLoaded = true;
			$this->oFile->mime = $this->forceMime;
			list( $this->oFile->major_mime, $this->oFile->minor_mime ) = LocalFile::splitMime( $this->oFile->mime );
			// normally, this kind of method would call
			// MediaHandler::getHandler(). However, this function
			// may be called repeatedly in one session (by a video
			// ingestion script) for different videos. MediaHandler::getHandler()
			// reads its own cache and returns the same video handler for different videos.
			// We must create the proper video handler ourselves.
			$type = $this->oFile->getMimeType();
			$class = $wgMediaHandlers[$type];
			/* @var $handler VideoHandler */
			$handler = new $class();
			$handler->setVideoId( $this->oFile->videoId );

			$this->oFile->metadata = ( isset( $this->forceMetadata ) ) ? $this->forceMetadata : $handler->getMetadata();
			$this->oFile->media_type = MEDIATYPE_VIDEO;
			$this->forceMime = false;
		}
	}

	/**
	 * Alter loadFromFile logic
	 *
	 * loadFromFile resets few params in class based on actual file in file system.
	 * As videos are represented as image files we want some data not to be reseted.
	 */
	private $lockedProperties = array( 'metadata', 'minor_mime', 'major_mime', 'mime', 'media_type' );
	private $lockedPropertiesValues = array();

	function beforeLoadFromFile() {
		if ( $this->isVideo() ) {
			$this->lockedPropertiesValues = array();
			foreach ( $this->lockedProperties as $param ) {
				$this->lockedPropertiesValues[ $param ] = $this->oFile->$param;
			}
		}
	}

	function afterLoadFromFile() {
		if ( $this->isVideo() ) {
			foreach ( $this->lockedProperties as $param ) {
				$this->oFile->$param = $this->lockedPropertiesValues[ $param ];
			}
		}
	}

	function isBroken() {
		return 	$this->oFile->getSize() == 0
			? true
			: $this->oFile->getHandler()->isBroken();
	}

	/**
	 * De-serialize the file metadata once and serve up values when requested
	 * @param $key string The metadata key to retrieve
	 * @param $default string What to return if there is no value set
	 * @return string
	 */
	function metaValue( $key, $default = '' ) {
		wfProfileIn( __METHOD__ );

		if ( empty($this->metadata) ) {
			if ( !empty( $this->oFile->metadata ) ) {
				$this->metadata = unserialize( $this->oFile->metadata );
			}
		}

		if ( !empty($this->metadata[$key]) ) {
			$value = $this->metadata[$key];
		} else {
			$value = $default;
		}

		wfProfileOut( __METHOD__ );
		return $value;
	}
}
