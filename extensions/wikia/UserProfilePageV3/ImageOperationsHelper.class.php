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
		//resizes if needed
		if( $aOrigSize['width'] > $this->defaultWidth && $aOrigSize['height'] > $this->defaultHeight ) {
			//bugId:7527
			//we don't want to resize anything we wont to crop only
		} else if( $aOrigSize['width'] > $this->defaultWidth ) {
			$oImgOrig = $this->resize($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		} else if( $aOrigSize['height'] > $this->defaultHeight ) {
			$oImgOrig = $this->resize($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		}
		
		//calculating destination start point
		$iDestX = 0;
		$iDestY = 0;
		if( ($aOrigSize['width'] > $this->defaultWidth && $aOrigSize['height'] > $this->defaultHeight) ||
		 ($aOrigSize['width'] < $this->defaultWidth && $aOrigSize['height'] < $this->defaultHeight) ) {
		//center the image vertically and horizontally
			$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
			$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
		} else if( $aOrigSize['width'] >= $this->defaultWidth ) {
			$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
		} else if( $aOrigSize['height'] >= $this->defaultHeight ) {
			$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
		}
		
		//empty image with thumb size on red background
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
}