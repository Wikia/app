<?php

class ScreenplayVideoHandler extends VideoHandler {
	
	protected $apiName = 'ScreenplayApiWrapper';
	protected static $urlTemplate = 'http://www.totaleclips.com/Player/Bounce.aspx?';
	protected static $providerDetailUrlTemplate = 'http://screenplayinc.com/';
	protected static $providerHomeUrl = 'http://screenplayinc.com/';
	
	public function getPlayerAssetUrl() {
		return JWPlayer::getJavascriptPlayerUrl();
	}
	
	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		$height =  $this->getHeight( $width );
				
		$file = $this->getFileUrl(ScreenplayApiWrapper::VIDEO_TYPE, $this->getStandardBitrateCode());
		$hdfile = $this->getFileUrl(ScreenplayApiWrapper::VIDEO_TYPE, ScreenplayApiWrapper::HIGHDEF_BITRATE_ID);
		
		$thumbUrl = '';
		if (empty($autoplay)) {
			$thumbUrl = $this->thumbnailImage->url;
		}
		
		// cityshort
		$cat = AdEngine::getCachedCategory();
		
		$playerOptions = array();
		$playerOptions['provider'] = 'video';
		
		return JWPlayer::getEmbedCode($articleId, $this->getVideoId(), $file, $this->getTitle(), $width, $height, true, $this->getDuration(), $this->isHd(), $hdfile, $thumbUrl, $cat['short'], $autoplay, $isAjax, $postOnload, $playerOptions);
	}
	
	protected function getFileUrl($type, $bitrateid) {
		$fileParams = array(
				'eclipid' => $this->videoId,
				'vendorid' => ScreenplayApiWrapper::VENDOR_ID
				);
		
		$urlCommonPart = self::$urlTemplate . http_build_query($fileParams);
		return $urlCommonPart . '&type=' . $type . '&bitrateid=' . $bitrateid;		
	}
	
	protected function getStandardBitrateCode() {
		if ($metadata = $this->getMetadata(true)) {
			if (!empty($metadata['stdBitrateCode'])) {
				return $metadata['stdBitrateCode'];
			}
		}
		
		return $this->getAspectRatio() <= (4/3) ? ScreenplayApiWrapper::STANDARD_43_BITRATE_ID : ScreenplayApiWrapper::STANDARD_BITRATE_ID;
	}
		
}
