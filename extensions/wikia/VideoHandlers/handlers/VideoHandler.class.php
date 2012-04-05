<?php

/*
 * Handler layer between specyfic video handler and the rest of BitmapHandlers
 * Used mainly for identyfication of Video hanlders
 *
 * In future common handler logic will be migrated here
 * If you are using public video handler specyfic function write them down here
 * 
 */

abstract class VideoHandler extends BitmapHandler {

	protected $api = null;
	protected $apiName = 'video/*';
	protected $videoId = '';
	protected $title = '';
	protected $metadata = null;
	protected $thumbnailImage = null;
	protected static $aspectRatio = 1.7777778;
	protected static $classnameSuffix = 'VideoHandler';
	protected static $providerDetailUrlTemplate = '';	// must have a token called "$1"

	function normaliseParams( $image, &$params ) {
		global $wgMaxImageArea, $wgMaxThumbnailArea;
		
		if ( !ImageHandler::normaliseParams( $image, $params ) ) {
			return false;
		}

		$params['physicalWidth'] = $params['width'];
		$params['physicalHeight'] = $params['height'];

		
		// Video files can be bigger than usuall images. We are alowing them to stretch up to WikiaVideoService::maxWideoWidth px.
		if ( $params['physicalWidth'] > WikiaVideoService::maxWideoWidth ) {
			$srcWidth = $image->getWidth( $params['page'] );
			$srcHeight = $image->getHeight( $params['page'] );
			$params['physicalWidth'] = WikiaVideoService::maxWideoWidth;
			$params['physicalHeight'] = round( ($params['physicalWidth'] * $srcHeight ) / $srcWidth );
		}

		# Same as srcWidth * srcHeight above but:
		# - no free pass for jpeg
		# - thumbs should be smaller
		if ( $params['physicalWidth'] * $params['physicalHeight'] > $wgMaxThumbnailArea ) {
			return false;
		}

		return true;
	}

	function getPlayerAssetUrl() {
		return '';
	}
	
	/**
	 * Returns embed code for a provider
	 * @return string Embed HTML
	 */
	abstract function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false );
	
	public function getProviderDetailUrl() {
		return str_replace('$1', $this->videoId, static::$providerDetailUrlTemplate);
	}
	
	public function getProviderHomeUrl() {
		return static::$providerHomeUrl;
	}

	
	function setVideoId( $videoId ){
		$this->videoId = $videoId;
	}
	
	public function getVideoId() {
		return $this->videoId;
	}
	
	function setTitle( $title ) {
		$this->title = $title;
	}
	
	function getTitle() {
		return $this->title;
	}

	function getAspectRatio(){
		$metadata = $this->getMetadata(true);
		if (!empty($metadata['aspectRatio'])) {
			return $metadata['aspectRatio'];
		}
		return static::$aspectRatio;
	}

	function getHeight( $width ){
		return (integer) ( $width / $this->getAspectRatio() );
	}

	/**
	 * Get metadata. Connects with Api if metadata is not in database.
	 * @return mixed array of data, or serialized version
	 */
	function getMetadata( $unserialize = false ) {
		if ( empty($this->metadata)) {
			$this->metadata = $this->getApi() instanceof ApiWrapper
				? serialize( $this->getApi()->getMetadata() )
				: null;
		}

		return empty($unserialize) ? $this->metadata : unserialize($this->metadata);
	}
	
	/**
	 *
	 * @param string $metadata serialized array
	 */
	function setMetadata( $metadata ) {
		$this->metadata = $metadata;
	}

	/**
	 *
	 * @param ThumbnailImage $thumbnailImage 
	 */
	function setThumbnailImage( $thumbnailImage ) {
		$this->thumbnailImage = $thumbnailImage;
	}
	
	/**
	 * Returns propper api for a current handler
	 * @return ApiWrapper object
	 */
	function getApi() {
		if ( !empty( $this->videoId ) && empty( $this->api ) ){
			$this->api = F::build ( $this->apiName, array( $this->videoId ) );
		}
		return $this->api;
	}

	function isMetadataValid( $image, $metadata ) {
		return true;
	}

	public function isBroken() {
		return strlen( (string) $this->videoId ) <= 3 ? true : false;
	}

	/**
	 *
	 * @return boolean
	 */
	protected function isHd() {
		$metadata = $this->getMetadata(true);
		return (!empty($metadata['hd']));
	}
	
	/**
	 *
	 * @return int duration in seconds, or null
	 */
	protected function getDuration() {
		$metadata = $this->getMetadata(true);
		return (!empty($metadata['duration']) ? $metadata['duration'] : null);
	}
  
	public function getFormattedDuration() {

		$metadata = $this->getMetadata(true);
		if (!empty($metadata['duration'])) {

			$sec = $metadata['duration'];

			if ( (int)$sec == $sec ) {

				$hms = "";
				$hours = intval(intval($sec) / 3600);  
				if ($hours > 0) {
					$hms .= str_pad($hours, 2, "0", STR_PAD_LEFT). ":";          
				}

				$minutes = intval(($sec / 60) % 60); 
				$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

				$seconds = intval($sec % 60); 
				$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
				
				return $hms;

			} else {

				return $metadata['duration'];
			}
		}

		return '';
	}
	
	/**
	 * Get the video id that is used for embed code
	 * @return string
	 */
	protected function getEmbedVideoId() {
		$metadata = $this->getMetadata(true);
		if (!empty($metadata['altVideoId'])) {
			return $metadata['altVideoId'];
		}
		return $this->videoId;
	}
	

	/**
	 * Returns fedault thumbnail mime type
	 * @return array thumbnail extension and MIME type
	 */
	function getThumbType( $ext, $mime, $params = null ) {
		return array( 'jpg', 'image/jpeg' );
	}

	/**
	 * Get the thumbnail code for videos
	 * @return object ThumbnailVideo object or error object
	 */
	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgOut, $wgExtensionsPath;

		$oThumbnailImage = parent::doTransform( $image, $dstPath, $dstUrl, $params, $flags );

		return new ThumbnailVideo(
			$oThumbnailImage->file,
			$oThumbnailImage->url,
			$oThumbnailImage->width,
			$oThumbnailImage->height,
//			!empty( $this::$aspectRatio )
//				? round( $oThumbnailImage->width / $this::$aspectRatio )
//				: $oThumbnailImage->height,
			$oThumbnailImage->path,
			$oThumbnailImage->page,
			$this::$aspectRatio
		);		
	}
}
