<?php
class ImageOperationsHelper {
	const UPLOAD_ERR_RESOLUTION = 101;

	private $app = null;
	private $defaultWidth = null;
	private $defaultHeight = null;

	/**
	 * @brief "Empty" constructor returns instance of this object
	 *
	 * @param WikiaApp $app wikia application object
	 *
	 * @return ImageOperationsHelper
	 */
	public function __construct( $width = UserProfilePageController::AVATAR_DEFAULT_SIZE, $height = UserProfilePageController::AVATAR_DEFAULT_SIZE ) {
		$this->app = F::app();
		$this->defaultWidth = $width;
		$this->defaultHeight = $height;
		return $this;
	}

	public static function getAllowedMime() {
		return array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
	}

	/* this function is c&p from masthead will be remove in future */

	public function postProcessFile( $sTmpFile  ) {
		$aImgInfo = getimagesize( $sTmpFile );
		/**
		 * check if mimetype is allowed
		 */
		$aAllowMime = self::getAllowedMime();
		if ( !in_array( $aImgInfo['mime'], $aAllowMime ) ) {
			// This seems to be the most appropriate error message to describe that the image type is invalid.
			// Available error codes; http://php.net/manual/en/features.file-upload.errors.php
			return UPLOAD_ERR_EXTENSION;
		}

		switch ( $aImgInfo['mime'] ) {
			case 'image/gif':
				$oImgOrig = @imagecreatefromgif( $sTmpFile );
				break;
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$oImgOrig = @imagecreatefromjpeg( $sTmpFile );
				break;
			case 'image/x-png':
			case 'image/png':
				$oImgOrig = @imagecreatefrompng( $sTmpFile );
				break;
		}
		$aOrigSize = array( 'width' => $aImgInfo[0], 'height' => $aImgInfo[1] );

		$oImg = $this->postProcess( $oImgOrig, $aOrigSize );

		if ( $oImg === self::UPLOAD_ERR_RESOLUTION ) {
			return self::UPLOAD_ERR_RESOLUTION;
		}

		if ( !imagepng( $oImg, $sTmpFile ) ) {
			return UPLOAD_ERR_CANT_WRITE;
		}

		return true;
	}

	public function postProcess( $oImgOrig, $aOrigSize  ) {
		wfProfileIn( __METHOD__ );

		$widthBeforeResizing = $aOrigSize['width'];
		$heightBeforeResizing = $aOrigSize['height'];

		if ( $widthBeforeResizing > 2000 && $heightBeforeResizing > 2000 ) {
			wfProfileOut( __METHOD__ );
			return self::UPLOAD_ERR_RESOLUTION;
		}

		// resizes if needed
		if ( $widthBeforeResizing > $this->defaultWidth && $heightBeforeResizing > $this->defaultHeight ) {
		// bugId:7527
			$oImgOrig = $this->resizeByTheSmallestSide( $oImgOrig, $aOrigSize['width'], $aOrigSize['height'] );
		} else if ( $widthBeforeResizing > $this->defaultWidth ) {
			$oImgOrig = $this->resize( $oImgOrig, $aOrigSize['width'], $aOrigSize['height'] );
		} else if ( $heightBeforeResizing > $this->defaultHeight ) {
			$oImgOrig = $this->resize( $oImgOrig, $aOrigSize['width'], $aOrigSize['height'] );
		}

		// calculating destination start point
		$iDestX = 0;
		$iDestY = 0;
		if ( $widthBeforeResizing > $this->defaultWidth && $heightBeforeResizing > $this->defaultHeight ) {
		// if avatar is non-square image with width&height bigger than default
			if ( $widthBeforeResizing > $heightBeforeResizing ) {
			// center the image horizontally
				$iDestX = ( $this->defaultWidth / 2 ) - floor( $aOrigSize['width'] / 2 );
			} else {
			// cut from the top of the image
				$iDestY = 0;
			}
		} else if ( $aOrigSize['width'] == $this->defaultWidth ) {
		// width of re-sized image is equal to default (height not not necessarily)
		// center the image vertically
			$iDestY = floor( $this->defaultHeight / 2 ) - floor( $aOrigSize['height'] / 2 );
		} else if ( $aOrigSize['height'] == $this->defaultHeight ) {
		// height of re-sized image is equal to default (width not not necessarily)
		// center the image horizontally
			$iDestX = ( $this->defaultWidth / 2 ) - floor( $aOrigSize['width'] / 2 );
		} else {
		// center the image vertically and horizontally
			$iDestX = ( $this->defaultWidth / 2 ) - floor( $aOrigSize['width'] / 2 );
			$iDestY = floor( $this->defaultHeight / 2 ) - floor( $aOrigSize['height'] / 2 );
		}

		// empty image with thumb size
		$oImg = @imagecreatetruecolor( $this->defaultWidth, $this->defaultHeight );
		$white = imagecolorallocate( $oImg, 255, 255, 255 );
		imagefill( $oImg, 0, 0, $white );

		imagecopymerge(
			$oImg, // dimg
			$oImgOrig, // simg
			$iDestX, // dx
			$iDestY, // dy
			0, // sx
			0, // sy
			$aOrigSize['width'], // sw
			$aOrigSize['height'], // sh
			100
		);

		wfProfileOut( __METHOD__ );
		return $oImg;
	}

	/**
	 * @brief Resizes the image and put white borders to fit default size
	 *
	 * @param object $oImgOrig original image object
	 * @param integer $width a reference with original's object width
	 * @param integer $height a reference with original's object height
	 *
	 * @return object resized image or false
	 */
	protected function resize( $oImgOrig, &$width, &$height ) {
		wfProfileIn( __METHOD__ );

		$iImgW = $this->defaultWidth;
		$iImgH = $this->defaultHeight;

		if ( $width > $height ) {
			$iImgH = $iImgW * ( $height / $width );
		}

		if ( $width < $height ) {
			$iImgW = $iImgH * ( $width / $height );
		}

		// empty image with thumb size on white background
		$oImg = @imagecreatetruecolor( $iImgW, $iImgH );
		$white = imagecolorallocate( $oImg, 255, 255, 255 );
		imagefill( $oImg, 0, 0, $white );

		$result = imagecopyresampled(
			$oImg,
			$oImgOrig,
			0, // dx
			0, // dy
			0, // sx,
			0, // sy,
			$iImgW, // dw
			$iImgH, // dh
			$width, // sw
			$height // sh
		);

		if ( $result ) {
			$width = $iImgW;
			$height = $iImgH;

			wfProfileOut( __METHOD__ );
			return $oImg;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}

	/**
	 * @brief Resizes the image by the smallest side
	 *
	 * @desc The small side (for example width) is set to default size and the bigger (for example height) is
	 * calcualted by proportion. If everything goes well it'll change width and height passed by reference
	 * and set it to new calculated values.
	 *
	 * @param object $oImgOrig original image object
	 * @param integer $width a reference with original's object width
	 * @param integer $height a reference with original's object height
	 *
	 * @return object resized image or false
	 */
	protected function resizeByTheSmallestSide( $oImgOrig, &$width, &$height ) {
		wfProfileIn( __METHOD__ );

		$iImgW = $this->defaultWidth;
		$iImgH = $this->defaultHeight;

		if ( $width > $height ) {
			$iImgW = ( $width * $iImgW ) / $height;
		}

		if ( $width < $height ) {
			$iImgH = ( $height * $iImgH ) / $width;
		}

		// empty image with thumb size on white background
		$oImg = @imagecreatetruecolor( $iImgW, $iImgH );
		$white = imagecolorallocate( $oImg, 255, 255, 255 );
		imagefill( $oImg, 0, 0, $white );

		$result = imagecopyresampled(
			$oImg,
			$oImgOrig,
			0, // dx
			0, // dy
			0, // sx,
			0, // sy,
			$iImgW, // dw
			$iImgH, // dh
			$width, // sw
			$height // sh
		);

		if ( $result ) {
			$width = $iImgW;
			$height = $iImgH;

			wfProfileOut( __METHOD__ );
			return $oImg;
		}

		wfProfileOut( __METHOD__ );
		return false;
	}
}
