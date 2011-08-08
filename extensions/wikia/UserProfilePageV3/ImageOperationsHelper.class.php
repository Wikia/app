<?php 
class ImageOperationsHelper {
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
	public function __construct($width = null, $height = null) {
		$this->app = F::app();
		if( !is_null($width) && !is_null($height) ) {
			$this->defaultWidth = $width;
			$this->defaultHeight = $height;
		}
		
		return $this;
	}
	
	public function postProcess( $oImgOrig, $aOrigSize  ) {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$widthBeforeResizing = $aOrigSize['width'];
		$heightBeforeResizing = $aOrigSize['height'];
		
		//resizes if needed
		if( $widthBeforeResizing > $this->defaultWidth && $heightBeforeResizing > $this->defaultHeight ) {
		//bugId:7527
			$oImgOrig = $this->resizeByTheSmallestSide($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		} else if( $widthBeforeResizing > $this->defaultWidth ) {
			$oImgOrig = $this->resize($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		} else if( $heightBeforeResizing > $this->defaultHeight ) {
			$oImgOrig = $this->resize($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		}
		
		//calculating destination start point
		$iDestX = 0;
		$iDestY = 0;
		if( $widthBeforeResizing > $this->defaultWidth && $heightBeforeResizing > $this->defaultHeight ) {
		//if avatar is non-square image with width&height bigger than default
			if( $widthBeforeResizing > $heightBeforeResizing ) {
			//center the image horizontally
				$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
			} else {
			//center the image vertically
				$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
			}
		} else if( $aOrigSize['width'] == $this->defaultWidth ) {
		//width of re-sized image is equal to default (height not not necessarily)
		//center the image vertically
			$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
		} else if( $aOrigSize['height'] == $this->defaultHeight ) {
		//height of re-sized image is equal to default (width not not necessarily)
		//center the image horizontally
			$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
		} else {
		//center the image vertically and horizontally
			$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
			$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
		}
		
		//empty image with thumb size
		$oImg = @imagecreatetruecolor($this->defaultWidth, $this->defaultHeight);
		$white = imagecolorallocate($oImg, 255, 255, 255);
		imagefill($oImg, 0, 0, $white);
		
		imagecopymerge(
			$oImg, //dimg
			$oImgOrig, //simg
			$iDestX, //dx
			$iDestY, //dy
			0, //sx
			0, //sy
			$aOrigSize['width'], //sw
			$aOrigSize['height'], //sh
			100
		);
		
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
	protected function resize($oImgOrig, &$width, &$height) {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$iImgW = $this->defaultWidth;
		$iImgH = $this->defaultHeight;
		
		if ( $width > $height ) {
			$iImgH = $iImgW * ( $height / $width );
		}
		
		if ( $width < $height ) {
			$iImgW = $iImgH * ( $width / $height );
		}
		
		//empty image with thumb size on white background
		$oImg = @imagecreatetruecolor($iImgW, $iImgH);
		$white = imagecolorallocate($oImg, 255, 255, 255);
		imagefill($oImg, 0, 0, $white);
		
		$result = imagecopyresampled(
			$oImg,
			$oImgOrig,
			0, //dx
			0, //dy
			0, //sx,
			0, //sy,
			$iImgW, //dw
			$iImgH, //dh
			$width, //sw
			$height //sh
		);
		
		if( $result ) {
			$width = $iImgW;
			$height = $iImgH;
			
			$this->app->wf->ProfileOut(__METHOD__);
			return $oImg;
		}
		
		$this->app->wf->ProfileOut(__METHOD__);
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
	protected function resizeByTheSmallestSide($oImgOrig, &$width, &$height) {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$iImgW = $this->defaultWidth;
		$iImgH = $this->defaultHeight;
		
		if ( $width > $height ) {
			$iImgW = ($width * $iImgW) / $height;
		}
		
		if ( $width < $height ) {
			$iImgH = ($height * $iImgH) / $width;
		}
		
		//empty image with thumb size on white background
		$oImg = @imagecreatetruecolor($iImgW, $iImgH);
		$white = imagecolorallocate($oImg, 255, 255, 255);
		imagefill($oImg, 0, 0, $white);
		
		$result = imagecopyresampled(
			$oImg,
			$oImgOrig,
			0, //dx
			0, //dy
			0, //sx,
			0, //sy,
			$iImgW, //dw
			$iImgH, //dh
			$width, //sw
			$height //sh
		);
		
		if( $result ) {
			$width = $iImgW;
			$height = $iImgH;
			
			$this->app->wf->ProfileOut(__METHOD__);
			return $oImg;
		}
		
		$this->app->wf->ProfileOut(__METHOD__);
		return false;
	}
}