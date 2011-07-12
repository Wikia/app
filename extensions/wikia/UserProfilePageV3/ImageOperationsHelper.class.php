<?php 
class ImageOperationsHelper {
	private $app = null;
	private $defaultWidth = null;
	private $defaultHeight = null;
	private $avatarPath = false;
	
	/**
	 * @brief "Empty" constructor returns instance of this object
	 * 
	 * @param WikiaApp $app wikia application object
	 * 
	 * @return ImageOperationsHelper
	 */
	public function __construct(WikiaApp $app, $width = null, $height = null) {
		$this->app = $app;
		
		if( !is_null($width) && !is_null($height) ) {
			$this->defaultWidth = $width;
			$this->defaultHeight = $height;
		}
		
		return $this;
	}
	
	/**
	 * @brief Creates file path from user identifier
	 */
	public function getLocalPath($userId) {
		$this->app->wf->ProfileIn( __METHOD__ );
		
		if( $this->avatarPath ) {
			return $this->avatarPath;
		}
		
		$image = sprintf('%s.png', $userId);
		$hash = sha1( (string)$userId );
		$folder = substr($hash, 0, 1).'/'.substr($hash, 0, 2);
		
		$this->avatarPath = "/{$folder}/{$image}";
		
		$this->app->wf->ProfileOut( __METHOD__ );
		return $this->avatarPath;
	}
	
	/**
	 * @brief Given the filename of the temporary image, post-process the image to be the right size, format, etc.
	 *
	 * @desc Returns an error code if there is an error or UPLOAD_ERR_OK if there were no errors. Most code from Masthead.php.
	 *
	 * @param String $sTmpFile   the full path to the temporary image file (will be deleted after processing)
	 * @param array $userData    user data array; contains: user id (key: userId), full page url (fullPageUrl), user name (username)
	 * @param $errorNo           optional initial error-code state.
	 * @param $errorMsg          optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION.
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function postProcessImageInternal($sTmpFile, $userData, $errorNo = UPLOAD_ERR_OK, &$errorMsg='') {
		$this->app->wf->ProfileIn(__METHOD__);
		$aImgInfo = getimagesize($sTmpFile);

		//check if mimetype is allowed
		$aAllowMime = array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
		if( !in_array($aImgInfo['mime'], $aAllowMime) ) {
			// This seems to be the most appropriate error message to describe that the image type is invalid.
			// Available error codes; http://php.net/manual/en/features.file-upload.errors.php
			$errorNo = UPLOAD_ERR_EXTENSION;
			$errorMsg = wfMsg('blog-avatar-error-type', $aImgInfo['mime'], $this->app->wg->Lang->listToText( $aAllowMime ) );
			
			$this->app->wf->ProfileOut(__METHOD__);
			return $errorNo;
		}
		
		switch( $aImgInfo['mime'] ) {
			case 'image/gif':
				$oImgOrig = @imagecreatefromgif($sTmpFile);
				break;
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$oImgOrig = @imagecreatefromjpeg($sTmpFile);
				break;
			case 'image/x-png':
			case 'image/png':
				$oImgOrig = @imagecreatefrompng($sTmpFile);
				break;
		}
		$aOrigSize = array('width' => $aImgInfo[0], 'height' => $aImgInfo[1]);
		
		//generate new image to png format
		$addedAvatars = array();
		$sFilePath = $this->app->wg->BlogAvatarDirectory.$userData['localPath'];
		
		//resizes if needed
		if( $aOrigSize['width'] > $this->defaultWidth ) {
			$oImgOrig = $this->resize($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		} else if( $aOrigSize['height'] > $this->defaultHeight ) {
			$oImgOrig = $this->resize($oImgOrig, $aOrigSize['width'], $aOrigSize['height']);
		}
		
		//calculating destination start point
		$iDestX = 0;
		$iDestY = 0;
		if( $aOrigSize['width'] >= $this->defaultWidth ) {
			$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
		} else if( $aOrigSize['height'] >= $this->defaultHeight ) {
			$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
		} else {
			//center the image vertically and horizontally
			$iDestX = ($this->defaultWidth/2) - floor($aOrigSize['width']/2);
			$iDestY = floor($this->defaultHeight/2) - floor($aOrigSize['height']/2);
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
		
		//save to new file ... but create folder for it first
		if( !is_dir(dirname($sFilePath)) && !$this->app->wf->MkdirParents(dirname($sFilePath)) ) {
			$this->app->wf->ProfileOut( __METHOD__ );
			return UPLOAD_ERR_CANT_WRITE;
		}
		
		if( !imagepng($oImg, $sFilePath) ) {
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		} else {
			//remove tmp object
			imagedestroy($oImg);
			
			$sUserText =  $userData['username'];
			$userPage = F::build('Title', array($sUserText, NS_USER), 'newFromText');
			unlink($sTmpFile);
			
			//notify image replication system
			if( $this->app->wg->EnableUploadInfoExt ) {
				F::build('UploadInfo', array($userPage, $sFilePath, $this->getLocalPath($userData['userId'])), 'log');
			}
			$errorNo = UPLOAD_ERR_OK;
		}
		
		$this->app->wf->ProfileOut(__METHOD__);
		return $errorNo;
	}
	
	/**
	 *
	 */
	private function resize($oImgOrig, &$width, &$height) {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$iImgW = $this->defaultWidth;
		$iImgH = $this->defaultHeight;
		
		//WIDTH > HEIGHT
		if ( $width > $height ) {
			$iImgH = $iImgW * ( $height / $width );
		}
		//HEIGHT > WIDTH
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