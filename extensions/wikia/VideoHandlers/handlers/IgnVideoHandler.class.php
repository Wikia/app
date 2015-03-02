<?php

class IgnVideoHandler extends VideoHandler {

	protected $apiName = 'IgnApiWrapper';
	protected static $urlTemplate = '';
	protected static $providerDetailUrlTemplate = 'http://www.ign.com/watch?v=$1';
	protected static $providerPlayerUrl = 'http://widgets.ign.com/video/embed/content.html';
	protected static $providerHomeUrl = 'http://www.ign.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "true";

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		return $this->getEmbedNative( $width, $autoplay );
	}

	private function getEmbedNative( $width, $autoplay = false ) {
		$height =  $this->getHeight( $width );
		$autoplay = $autoplay ? '&' . self::$autoplayParam . '=' . self::$autoplayValue : '';
		$url = self::$providerPlayerUrl.'?url='.$this->getEmbedUrl().$autoplay;
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<iframe src="{$url}" $sizeString scrolling="no" frameborder="0" allowfullscreen></iframe>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

	public function getEmbedUrl() {
		$metadata = $this->getVideoMetadata(true);
		$url = $metadata['videoUrl'];

		return $url;
	}


	public function getEmbedSrcData() {
		$data = array();
		$data['autoplayParam'] = $this->getAutoplayString();
		$data['srcParam'] = static::$providerPlayerUrl . '?url='.$this->getEmbedUrl();
		$data['srcType'] = 'player';

		return $data;
	}

}
