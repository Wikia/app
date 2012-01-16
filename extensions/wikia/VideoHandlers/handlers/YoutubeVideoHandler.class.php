<?php

class YoutubeVideoHandler extends VideoHandler {
	
	protected $apiName = 'YoutubeApiWrapper';
	protected static $aspectRatio = 1.7777778;
	protected static $urlTemplate = 'http://www.youtube.com/watch?v=';
	
	public function getPlayerAssetUrl() {
		return JWPlayer::getAssetUrl();
	}
	
	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false) {
		$height = (integer) ($width / self::$aspectRatio);
		return JWPlayer::getEmbedCode($articleId, $this->getVideoId(), self::$urlTemplate.$this->getVideoId(), $this->getTitle(), $width, $height, false, $this->getDuration(), $this->isHd(), null, null, null, $autoplay, $isAjax);
	}
		
	private function getEmbedNative($width, $autoplay=false) {
		// YouTube parameters: http://code.google.com/apis/youtube/player_parameters.html
		$params = array('rel'=>0);
		if ($autoplay) $params['autoplay'] = 1;		
		$qs = http_build_query($params);
		
		$code = <<<EOT
<iframe width="$width" height="$height" src="http://www.youtube.com/embed/{$this->videoId}?$qs" frameborder="0" allowfullscreen></iframe>
EOT;
		
		return $code;
	}	
}
