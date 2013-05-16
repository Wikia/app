<?php

class IvaVideoHandler extends VideoHandler {

	protected $apiName = 'IvaApiWrapper';
	protected static $urlTemplate = 'http://www.videodetective.com/embed/video/?publishedid=$1';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {
		$height = $this->getHeight($width);
		$autoPlayStr = $autoplay ? 'true' : 'false';

		$url = $this->getEmbedUrl();
		$url .= "&options=DangDang&autostart={$autoPlayStr}&playlist=none&width={$width}&height={$height}";
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<iframe $sizeString src='{$url}' frameborder='0' scrolling='no'></iframe>
EOT;

		return array( 'html' => $html );
	}

}
