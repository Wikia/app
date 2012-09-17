<?php

class BliptvVideoHandler extends VideoHandler {
	
	protected $apiName = 'BliptvApiWrapper';
	protected static $urlTemplate = 'http://a.blip.tv/api.swf#$1';
	protected static $providerDetailUrlTemplate = 'http://blip.tv/play/$1';
	protected static $providerHomeUrl = 'http://blip.tv/';
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$url = $this->getEmbedUrl();
		$embedVideoId = $this->getEmbedVideoId();
                $autoStartParam = $autoplay ? 'true' :  'false';
		$code = <<<EOT
<iframe src="http://blip.tv/play/$embedVideoId.html?p=1&autoStart={$autoStartParam}" width="{$width}" height="{$height}" frameborder="0" allowfullscreen></iframe><embed type="application/x-shockwave-flash" src="$url" style="display:none"></embed>
EOT;
		return $code;
	}

	public function getProviderDetailUrl() {
		return str_replace('$1', $this->getEmbedVideoId(), static::$providerDetailUrlTemplate);
	}
}
