<?php

class OoyalaVideoHandler extends VideoHandler {

	protected $apiName = 'OoyalaApiWrapper';
	protected static $urlTemplate = 'http://player.ooyala.com/player.swf?embedCode=$1&version=2';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {

		$height = $this->getHeight($width);
		$url = $this->getEmbedUrl();
		if ( $autoplay ) {
			$autoPlayStr = '&autoplay=1';
			$playStr = 'true';
		} else {
			$autoPlayStr = '';
			$playStr = 'false';
		}

		$embed = <<<EOT
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="ooyalaPlayer_{$this->videoId}" 
width="{$width}" height="{$height}" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
	<param name="movie" value="{$url}" />
	<param name="bgcolor" value="#000000" />
	<param name="allowScriptAccess" value="always" />
	<param name="allowFullScreen" value="true" />
	<param name="flashvars" value="embedCode={$this->videoId}&videoPcode=J0MTUxOtPDJVNZastij14_v7VDRS{$autoPlayStr}" />
	<embed src="{$url}" bgcolor="#000000" 
	width="{$width}" height="{$height}" name="ooyalaPlayer_{$this->videoId}" align="middle" play="{$playStr}" loop="false" 
	allowscriptaccess="always" allowfullscreen="true" type="application/x-shockwave-flash" 
	flashvars="embedCode={$this->videoId}&videoPcode=J0MTUxOtPDJVNZastij14_v7VDRS{$autoPlayStr}"
	pluginspage="http://www.adobe.com/go/getflashplayer"></embed>
</object>
EOT;

		return $embed;
	}

}
