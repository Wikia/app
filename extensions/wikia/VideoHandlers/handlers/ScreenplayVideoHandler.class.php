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

		$app = F::app();

		if ( $app->checkSkin( 'wikiamobile' ) ) {
			$url = $this->getEmbedUrl();
			$fileObj = wfFindFile( $this->getTitle() );
			$poster = '';

			if ( $fileObj instanceof File ) {
				$thumb = $fileObj->transform( array( 'width' => $width, 'height' => $height ) );
				$poster = ' poster="' . wfReplaceImageServer( $thumb->getUrl(), $fileObj->getTimestamp() ) . '"';
			}

			$result = array( 'html' => '<video controls ' . $poster . '><source src="' . $url . '">' . wfMsg( 'wikiamobile-unsupported-video-download', $url ) . '</video>' );
		} else {
			$metadata = $this->getMetadata( true );
			$file = $this->getStreamUrl( $metadata );
			$hdfile = $this->getStreamHdUrl( $metadata );

			$jwplayer = new JWPlayer($this->getVideoId());
			$jwplayer->setArticleId($articleId);
			$jwplayer->setUrl($file);
			$jwplayer->setTitle($this->getTitle());
			$jwplayer->setWidth($width);
			$jwplayer->setHeight($height);
			$jwplayer->setDuration($this->getDuration());
			$jwplayer->setHd($this->isHd());
			$jwplayer->setHdFile($hdfile);
			$jwplayer->setThumbUrl($this->thumbnailImage->url);
			$jwplayer->setAgeGate($this->isAgeGate());
			$jwplayer->setAutoplay($autoplay);
			$jwplayer->setShowAd(true);
			$jwplayer->setAjax($isAjax);
			$jwplayer->setPostOnload($postOnload);

			$result = $jwplayer->getEmbedCode();
		}

		return $result;
	}

	public function getEmbedSrcData() {
		$metadata = $this->getMetadata( true );
		$file = $this->getStreamUrl( $metadata );

		$data = array();
		$data['autoplayParam'] = $this->getAutoplayString();
		$data['srcParam'] = $file;
		$data['srcType'] = 'content';

		return $data;
	}

	protected function getFileUrl($type, $bitrateid) {
		$fileParams = array(
				'eclipid' => $this->videoId,
				'vendorid' => ScreenplayApiWrapper::VENDOR_ID
				);

		$urlCommonPart = self::$urlTemplate . http_build_query($fileParams);
		return $urlCommonPart . '&type=' . $type . '&bitrateid=' . $bitrateid;
	}

	protected function getStreamUrl( $metadata ) {
		if ( isset($metadata['streamUrl']) ) {
			$file = $metadata['streamUrl'];
		} else {
			$file = $this->getFileUrl( ScreenplayApiWrapper::VIDEO_TYPE, $this->getStandardBitrateCode() );
		}

		return $file;
	}

	protected function getStreamHdUrl( $metadata ) {
		if ( isset($metadata['streamHdUrl']) ) {
			$hdfile = $metadata['streamHdUrl'];
		} else {
			$hdfile = $this->getFileUrl( ScreenplayApiWrapper::VIDEO_TYPE, ScreenplayApiWrapper::HIGHDEF_BITRATE_ID );
		}

		return $hdfile;
	}

	public function getEmbedUrl() {
		$metadata = $this->getMetadata( true );
		$file = $this->getStreamUrl( $metadata );
		$hdfile = $this->getStreamHdUrl( $metadata );
		$url = ( $this->isHd() ) ? $hdfile : $file ;

		return $url;
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
