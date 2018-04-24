<?php
/**
 * Generic handler for bitmap images
 *
 * @file
 * @ingroup Media
 */

/**
 * Generic handler for bitmap images
 *
 * @ingroup Media
 */
class BitmapHandler extends ImageHandler {
	/**
	 * @param $image File
	 * @param $params array Transform parameters. Entries with the keys 'width'
	 * and 'height' are the respective screen width and height, while the keys
	 * 'physicalWidth' and 'physicalHeight' indicate the thumbnail dimensions.
	 * @return bool
	 */
	function normaliseParams( $image, &$params ) {
		if ( !parent::normaliseParams( $image, $params ) ) {
			return false;
		}

		# Obtain the source, pre-rotation dimensions
		$srcWidth = $image->getWidth( $params['page'] );
		$srcHeight = $image->getHeight( $params['page'] );

		# Don't make an image bigger than the source
		if ( $params['physicalWidth'] >= $srcWidth ) {
			$params['physicalWidth'] = $srcWidth;
			$params['physicalHeight'] = $srcHeight;

			# Skip scaling limit checks if no scaling is required
			# due to requested size being bigger than source.
			if ( !$image->mustRender() ) {
				return true;
			}
		}

		# Check if the file is smaller than the maximum image area for thumbnailing
		$checkImageAreaHookResult = null;
		Hooks::run( 'BitmapHandlerCheckImageArea', array( $image, &$params, &$checkImageAreaHookResult ) );
		if ( is_null( $checkImageAreaHookResult ) ) {
			global $wgMaxImageArea;

			if ( $srcWidth * $srcHeight > $wgMaxImageArea &&
					!( $image->getMimeType() == 'image/jpeg' &&
						self::getScalerType( false, false ) == 'im' ) ) {
				# Only ImageMagick can efficiently downsize jpg images without loading
				# the entire file in memory
				return false;
			}
		} else {
			return $checkImageAreaHookResult;
		}

		return true;
	}


	/**
	 * Extracts the width/height if the image will be scaled before rotating
	 *
	 * This will match the physical size/aspect ratio of the original image
	 * prior to application of the rotation -- so for a portrait image that's
	 * stored as raw landscape with 90-degress rotation, the resulting size
	 * will be wider than it is tall.
	 *
	 * @param $params array Parameters as returned by normaliseParams
	 * @param $rotation int The rotation angle that will be applied
	 * @return array ($width, $height) array
	 */
	public function extractPreRotationDimensions( $params, $rotation ) {
		if ( $rotation == 90 || $rotation == 270 ) {
			# We'll resize before rotation, so swap the dimensions again
			$width = $params['physicalHeight'];
			$height = $params['physicalWidth'];
		} else {
			$width = $params['physicalWidth'];
			$height = $params['physicalHeight'];
		}
		return array( $width, $height );
	}


	/**
	 * Function that returns the number of pixels to be thumbnailed.
	 * Intended for animated GIFs to multiply by the number of frames.
	 *
	 * @param File $image
	 * @return int
	 */
	function getImageArea( $image ) {
		return $image->getWidth() * $image->getHeight();
	}

	/**
	 * @param $image File
	 * @param  $dstPath
	 * @param  $dstUrl
	 * @param  $params
	 * @param int $flags
	 * @return MediaTransformError|ThumbnailImage|TransformParameterError
	 */
	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		if ( !$this->normaliseParams( $image, $params ) ) {
			return new TransformParameterError( $params );
		}
		# Create a parameter array to pass to the scaler
		$scalerParams = array(
			# The size to which the image will be resized
			'physicalWidth' => $params['physicalWidth'],
			'physicalHeight' => $params['physicalHeight'],
			'physicalDimensions' => "{$params['physicalWidth']}x{$params['physicalHeight']}",
			# The size of the image on the page
			'clientWidth' => $params['width'],
			'clientHeight' => $params['height'],
			# Comment as will be added to the EXIF of the thumbnail
			'comment' => isset( $params['descriptionUrl'] ) ?
				"File source: {$params['descriptionUrl']}" : '',
			# Properties of the original image
			'srcWidth' => $image->getWidth(),
			'srcHeight' => $image->getHeight(),
			'mimeType' => $image->getMimeType(),
			'dstPath' => $dstPath,
			'dstUrl' => $dstUrl,
		);

		# Determine scaler type
		$scaler = self::getScalerType( $dstPath );

		if ( !$image->mustRender() &&
				$scalerParams['physicalWidth'] == $scalerParams['srcWidth']
				&& $scalerParams['physicalHeight'] == $scalerParams['srcHeight'] ) {

			# normaliseParams (or the user) wants us to return the unscaled image
			wfDebug( __METHOD__ . ": returning unscaled image\n" );
			return $this->getClientScalingThumbnailImage( $image, $scalerParams );
		}


		if ( $scaler == 'client' ) {
			# Client-side image scaling, use the source URL
			# Using the destination URL in a TRANSFORM_LATER request would be incorrect
			return $this->getClientScalingThumbnailImage( $image, $scalerParams );
		}

		if ( $flags & self::TRANSFORM_LATER ) {
			wfDebug( __METHOD__ . ": Transforming later per flags.\n" );
			return new ThumbnailImage( $image, $dstUrl, $scalerParams['clientWidth'],
				$scalerParams['clientHeight'], false );
		}

		wfDebug( __METHOD__ . ": creating {$scalerParams['physicalDimensions']} thumbnail at $dstPath using scaler $scaler\n" );

		# Try to make a target path for the thumbnail
		if ( !wfMkdirParents( dirname( $dstPath ), null, __METHOD__ ) ) {
			wfDebug( __METHOD__ . ": Unable to create thumbnail destination directory, falling back to client scaling\n" );
			return $this->getClientScalingThumbnailImage( $image, $scalerParams );
		}

		# Transform functions and binaries need a FS source file
		$scalerParams['srcPath'] = $image->getLocalRefPath();

		# Try a hook
		$mto = null;
		Hooks::run( 'BitmapHandlerTransform', array( $this, $image, &$scalerParams, &$mto ) );
		if ( !is_null( $mto ) ) {
			wfDebug( __METHOD__ . ": Hook to BitmapHandlerTransform created an mto\n" );
			$scaler = 'hookaborted';
		}

		switch ( $scaler ) {
			case 'hookaborted':
				# Handled by the hook above
				$err = $mto->isError() ? $mto : false;
				break;
			case 'custom':
				$err = $this->transformCustom( $image, $scalerParams );
				break;
			case 'gd':
			default:
				$err = $this->transformGd( $image, $scalerParams );
				break;
		}

		# Remove the file if a zero-byte thumbnail was created, or if there was an error
		$removed = $this->removeBadFile( $dstPath, (bool)$err );
		if ( $err ) {
			# transform returned MediaTransforError
			return $err;
		} elseif ( $removed ) {
			# Thumbnail was zero-byte and had to be removed
			return new MediaTransformError( 'thumbnail_error',
				$scalerParams['clientWidth'], $scalerParams['clientHeight'] );
		} elseif ( $mto ) {
			return $mto;
		} else {
			return new ThumbnailImage( $image, $dstUrl, $scalerParams['clientWidth'],
				$scalerParams['clientHeight'], $dstPath );
		}
	}

	/**
	 * Returns which scaler type should be used. Creates parent directories
	 * for $dstPath and returns 'client' on error
	 *
	 * @return string client,im,custom,gd
	 */
	protected static function getScalerType( $dstPath, $checkDstPath = true ) {
		global $wgUseImageResize, $wgCustomConvertCommand;

		if ( !$dstPath && $checkDstPath ) {
			# No output path available, client side scaling only
			$scaler = 'client';
		} elseif ( !$wgUseImageResize ) {
			$scaler = 'client';
		} elseif ( $wgCustomConvertCommand ) {
			$scaler = 'custom';
		} elseif ( function_exists( 'imagecreatetruecolor' ) ) {
			$scaler = 'gd';
		} else {
			$scaler = 'client';
		}
		return $scaler;
	}

	/**
	 * Get a ThumbnailImage that respresents an image that will be scaled
	 * client side
	 *
	 * @param $image File File associated with this thumbnail
	 * @param $params array Array with scaler params
	 * @return ThumbnailImage
	 *
	 * @fixme no rotation support
	 */
	protected function getClientScalingThumbnailImage( $image, $params ) {
		return new ThumbnailImage( $image, $image->getURL(),
			$params['clientWidth'], $params['clientHeight'], null );
	}

	/**
	 * Transform an image using a custom command
	 *
	 * @param $image File File associated with this thumbnail
	 * @param $params array Array with scaler params
	 *
	 * @return MediaTransformError Error object if error occured, false (=no error) otherwise
	 */
	protected function transformCustom( $image, $params ) {
		# Use a custom convert command
		global $wgCustomConvertCommand;

		# Variables: %s %d %w %h
		$src = wfEscapeShellArg( $params['srcPath'] );
		$dst = wfEscapeShellArg( $params['dstPath'] );
		$cmd = $wgCustomConvertCommand;
		$cmd = str_replace( '%s', $src, str_replace( '%d', $dst, $cmd ) ); # Filenames
		$cmd = str_replace( '%h', wfEscapeShellArg( $params['physicalHeight'] ),
			str_replace( '%w', wfEscapeShellArg( $params['physicalWidth'] ), $cmd ) ); # Size
		wfDebug( __METHOD__ . ": Running custom convert command $cmd\n" );
		wfProfileIn( 'convert' );
		$retval = 0;
		$err = wfShellExec( $cmd, $retval );
		wfProfileOut( 'convert' );

		if ( $retval !== 0 ) {
			$this->logErrorForExternalProcess( $retval, $err, $cmd );
			return $this->getMediaTransformError( $params, $err );
		}
		return false; # No error
	}

	/**
	 * Log an error that occured in an external process
	 *
	 * @param $retval int
	 * @param $err int
	 * @param $cmd string
	 */
	protected function logErrorForExternalProcess( $retval, $err, $cmd ) {
		wfDebugLog( 'thumbnail',
			sprintf( 'thumbnail failed on %s: error %d "%s" from "%s"',
					wfHostname(), $retval, trim( $err ), $cmd ) );
	}
	/**
	 * Get a MediaTransformError with error 'thumbnail_error'
	 *
	 * @param $params array Parameter array as passed to the transform* functions
	 * @param $errMsg string Error message
	 * @return MediaTransformError
	 */
	public function getMediaTransformError( $params, $errMsg ) {
		return new MediaTransformError( 'thumbnail_error', $params['clientWidth'],
					$params['clientHeight'], $errMsg );
	}

	/**
	 * Transform an image using the built in GD library
	 *
	 * @param $image File File associated with this thumbnail
	 * @param $params array Array with scaler params
	 *
	 * @return MediaTransformError Error object if error occured, false (=no error) otherwise
	 */
	protected function transformGd( $image, $params ) {
		# Use PHP's builtin GD library functions.
		#
		# First find out what kind of file this is, and select the correct
		# input routine for this.

		$typemap = array(
			'image/gif'          => array( 'imagecreatefromgif',  'palette',   'imagegif'  ),
			'image/jpeg'         => array( 'imagecreatefromjpeg', 'truecolor', array( __CLASS__, 'imageJpegWrapper' ) ),
			'image/png'          => array( 'imagecreatefrompng',  'bits',      'imagepng'  ),
			'image/vnd.wap.wbmp' => array( 'imagecreatefromwbmp', 'palette',   'imagewbmp'  ),
			'image/xbm'          => array( 'imagecreatefromxbm',  'palette',   'imagexbm'  ),
		);
		if ( !isset( $typemap[$params['mimeType']] ) ) {
			$err = 'Image type not supported';
			wfDebug( "$err\n" );
			$errMsg = wfMsg( 'thumbnail_image-type' );
			return $this->getMediaTransformError( $params, $errMsg );
		}
		list( $loader, $colorStyle, $saveType ) = $typemap[$params['mimeType']];

		if ( !function_exists( $loader ) ) {
			$err = "Incomplete GD library configuration: missing function $loader";
			wfDebug( "$err\n" );
			$errMsg = wfMsg( 'thumbnail_gd-library', $loader );
			return $this->getMediaTransformError( $params, $errMsg );
		}

		if ( !file_exists( $params['srcPath'] ) ) {
			$err = "File seems to be missing: {$params['srcPath']}";
			wfDebug( "$err\n" );
			$errMsg = wfMsg( 'thumbnail_image-missing', $params['srcPath'] );
			return $this->getMediaTransformError( $params, $errMsg );
		}

		$src_image = call_user_func( $loader, $params['srcPath'] );

		$rotation = function_exists( 'imagerotate' ) ? $this->getRotation( $image ) : 0;
		list( $width, $height ) = $this->extractPreRotationDimensions( $params, $rotation );
		$dst_image = imagecreatetruecolor( $width, $height );

		// Initialise the destination image to transparent instead of
		// the default solid black, to support PNG and GIF transparency nicely
		$background = imagecolorallocate( $dst_image, 0, 0, 0 );
		imagecolortransparent( $dst_image, $background );
		imagealphablending( $dst_image, false );

		if ( $colorStyle == 'palette' ) {
			// Don't resample for paletted GIF images.
			// It may just uglify them, and completely breaks transparency.
			imagecopyresized( $dst_image, $src_image,
				0, 0, 0, 0,
				$width, $height,
				imagesx( $src_image ), imagesy( $src_image ) );
		} else {
			imagecopyresampled( $dst_image, $src_image,
				0, 0, 0, 0,
				$width, $height,
				imagesx( $src_image ), imagesy( $src_image ) );
		}

		if ( $rotation % 360 != 0 && $rotation % 90 == 0 ) {
			$rot_image = imagerotate( $dst_image, $rotation, 0 );
			imagedestroy( $dst_image );
			$dst_image = $rot_image;
		}

		imagesavealpha( $dst_image, true );

		call_user_func( $saveType, $dst_image, $params['dstPath'] );
		imagedestroy( $dst_image );
		imagedestroy( $src_image );

		return false; # No error
	}

	static function imageJpegWrapper( $dst_image, $thumbPath ) {
		imageinterlace( $dst_image );
		imagejpeg( $dst_image, $thumbPath, 95 );
	}

	/**
	 * On supporting image formats, try to read out the low-level orientation
	 * of the file and return the angle that the file needs to be rotated to
	 * be viewed.
	 *
	 * This information is only useful when manipulating the original file;
	 * the width and height we normally work with is logical, and will match
	 * any produced output views.
	 *
	 * The base BitmapHandler doesn't understand any metadata formats, so this
	 * is left up to child classes to implement.
	 *
	 * @param $file File
	 * @return int 0, 90, 180 or 270
	 */
	public function getRotation( $file ) {
		return 0;
	}

	/**
	 * Returns whether the current scaler supports rotation (im and gd do)
	 *
	 * @return bool
	 */
	public static function canRotate() {
		$scaler = self::getScalerType( null, false );
		switch ( $scaler ) {
			case 'gd':
				# GD's imagerotate function is used to rotate images, but not
				# all precompiled PHP versions have that function
				return function_exists( 'imagerotate' );
			default:
				# Other scalers don't support rotation
				return false;
		}
	}

	/**
	 * Rerurns whether the file needs to be rendered. Returns true if the
	 * file requires rotation and we are able to rotate it.
	 *
	 * @param $file File
	 * @return bool
	 */
	public function mustRender( $file ) {
		return self::canRotate() && $this->getRotation( $file ) != 0;
	}
}
