<?php

class PrototypeVideoHandler extends VideoHandler {
	
	
	/**
	 * Get an associative array mapping magic word IDs to parameter names.
	 * Will be used by the parser to identify parameters.
	 */
//	function getParamMap(){
//		return array(
//			'img_width' => 'width'
//		);
//	}

	/*
	 * Validate a thumbnail parameter at parse time.
	 * Return true to accept the parameter, and false to reject it.
	 * If you return false, the parser will do something quiet and forgiving.
	 */
//
//	function validateParam( $name, $value ){
//		return true;
//	}

	/**
	 * Merge a parameter array into a string appropriate for inclusion in filenames
	 */
//	function makeParamString( $params ){
//		return 'something';
//
//	}

	/**
	 * Parse a param string made with makeParamString back into an array
	 */
//	function parseParamString( $str ) {
//		return array( 'width' => 666 );
//
//	}

	/**
	 * Changes the parameter array as necessary, ready for transformation.
	 * Should be idempotent.
	 * Returns false if the parameters are unacceptable and the transform should fail
	 */
//	function normaliseParams( $image, &$params ) {
		
//		$mimeType = $image->getMimeType();
//		$srcWidth = $image->getWidth( $params['page'] );
//		$srcHeight = $image->getHeight( $params['page'] );
//
//		# Don't thumbnail an image so big that it will fill hard drives and send servers into swap
//		# JPEG has the handy property of allowing thumbnailing without full decompression, so we make
//		# an exception for it.
//		if ( $mimeType !== 'image/jpeg' &&
//			$this->getImageArea( $image, $srcWidth, $srcHeight ) > $wgMaxImageArea )
//		{
//			return false;
//		}
//
//		# Don't make an image bigger than the source
//		$params['physicalWidth'] = $params['width'];
//		$params['physicalHeight'] = $params['height'];
//
//		if ( $params['physicalWidth'] >= $srcWidth ) {
//			$params['physicalWidth'] = $srcWidth;
//			$params['physicalHeight'] = $srcHeight;
//		}

		# Same as srcWidth * srcHeight above but:
		# - no free pass for jpeg
		# - thumbs should be smaller
//		if ( $params['physicalWidth'] * $params['physicalHeight'] > $wgMaxThumbnailArea ) {
//			return false;
//		}

//		return true;
//	}

	/**
	 * Get an image size array like that returned by getimagesize(), or false if it
	 * can't be determined.
	 *
	 * @param $image File: the image object, or false if there isn't one
	 * @param $fileName String: the filename
	 * @return Array
	 */
//	function getImageSize( $image, $path ){
//		return array();
//	}

	/**
	 * Get a MediaTransformOutput object representing the transformed output. Does the
	 * transform unless $flags contains self::TRANSFORM_LATER.
	 *
	 * @param $image File: the image object
	 * @param $dstPath String: filesystem destination path
	 * @param $dstUrl String: destination URL to use in output HTML
	 * @param $params Array: arbitrary set of parameters validated by $this->validateParam()
	 * @param $flags Integer: a bitfield, may contain self::TRANSFORM_LATER
	 */
//	function doTransform( $file, $dstPath, $dstUrl, $params, $flags = 0 ){
//
//		if ( !$this->normaliseParams( $file, $params ) ) {
//			return new TransformParameterError( $params );
//		}
//
//		$clientWidth = $params['width'];
//		$iconUrl = F::app()->wg->extensionsPath . '/wikia/VideoHandlers/handlers/PrototypePlaceholderImage.jpg';
//		return F::build( 'ThumbnailVideo', array( $file, $iconUrl, 30, 80 ) );
//	}

	/**
	 * Get the thumbnail extension and MIME type for a given source MIME type
	 * @return array thumbnail extension and MIME type
	 */

//	function getThumbType( $ext, $mime, $params = null ) {
//		return array( 'jpg', 'image/jpeg' );
//	}

	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {

		$oThumbnailImage = parent::doTransform( $image, $dstPath, $dstUrl, $params, $flags );

		return new ThumbnailVideo(
			$oThumbnailImage->file,
			$oThumbnailImage->url,
			$oThumbnailImage->width,
			$oThumbnailImage->height,
			$oThumbnailImage->path,
			$oThumbnailImage->page
		);
	}

	function getEmbed(){

		// hardcoden but this is only a prototype. In future it will be handled in a better way
		
		return '<div class="embedHtml">
				<object id="rg_player_ac330d90-cb46-012e-f91c-12313d18e962" name="rg_player_ac330d90-cb46-012e-f91c-12313d18e962" type="application/x-shockwave-flash" width="660" height="371" classid="clsid:ac330d90-cb46-012e-f91c-12313d18e962" style="visibility: visible;" data="http://anomaly.realgravity.com/flash/player.swf">
				<param name="allowscriptaccess" value="always">
				<param name="allowNetworking" value="all">
				<param name="menu" value="false">
				<param name="wmode" value="transparent">
				<param name="allowFullScreen" value="true">
				<param name="flashvars" value="&amp;config=http://mediacast.realgravity.com/vs/api/playerxml/ac330d90-cb46-012e-f91c-12313d18e962">
				<embed id="ac330d90-cb46-012e-f91c-12313d18e962" name="ac330d90-cb46-012e-f91c-12313d18e962" width="660" height="371" allownetworking="all" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" flashvars="config=http://mediacast.realgravity.com/vs/api/playerxml/ac330d90-cb46-012e-f91c-12313d18e962?video_guid=6fb1e3829bb6915446d08368cd8b1a2300f0" src="http://anomaly.realgravity.com/flash/player.swf">
			</object></div>';
	}
	
}
