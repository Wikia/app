<?php

class OoyalaVideoHandler extends VideoHandler {

	protected $apiName = 'OoyalaApiWrapper';
	protected static $urlTemplate = 'http://player.ooyala.com/player.swf?embedCode=$1&version=2';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {
		$height = $this->getHeight($width);
		$autoPlayStr = ( $autoplay && !$this->isAgeGate() ) ? 1 : 0;
		$containerId = 'ooyalaplayer-'.$this->videoId.'-'.time();

		$embed = <<<EOT
<div id="{$containerId}" style="width:{$width}px; height:{$height}px"></div>
<script type="text/javascript" src="http://player.ooyala.com/player.js?embedCode={$this->videoId}&width={$width}&height={$height}&playerContainerId={$containerId}&autoplay={$autoPlayStr}&wmode=opaque"></script>
EOT;

		return $embed;
	}

}
