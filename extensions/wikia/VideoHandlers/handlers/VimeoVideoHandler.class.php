<?php

class VimeoVideoHandler extends VideoHandler {

	protected $apiName = 'VimeoApiWrapper';
	protected $googleSitemapCustomVideoUrl = 'https://vimeo.com/moogaloop.swf?clip_id=$1';
	protected static $urlTemplate = 'https://player.vimeo.com/video/$1';
	protected static $providerDetailUrlTemplate = 'https://vimeo.com/$1';
	protected static $providerHomeUrl = 'https://vimeo.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "1";

	public function getPlayerAssetUrl() {
		return '';
	}

	public function getGoogleSitemapCustomVideoUrl() {
		return str_replace('$1', $this->getEmbedVideoId(), $this->googleSitemapCustomVideoUrl);
	}

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$height =  $this->getHeight( $width );

		$autoplayStrParam = self::$autoplayParam;
		$autoplayStrValue = $autoplay ? self::$autoplayValue : '0';
		$url = $this->getEmbedUrl();
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<iframe src="$url?$autoplayStrParam=$autoplayStrValue" $sizeString frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

	public function getEmbedSrcData() {
		$data = array();
		$data['autoplayParam'] = $this->getAutoplayString();
		$data['srcParam'] = $this->getGoogleSitemapCustomVideoUrl();
		$data['srcType'] = 'player';
		return $data;
	}

}