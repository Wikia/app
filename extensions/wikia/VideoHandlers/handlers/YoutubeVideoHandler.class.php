<?php

class YoutubeVideoHandler extends VideoHandler {
	
	protected $apiName = 'YoutubeApiWrapper';
	protected static $aspectRatio = 1.7777778;
	
	public function getEmbed($width, $autoplay=false) {
		willdebug(__METHOD__."\n");
		$height = (integer) ($width / self::$aspectRatio);
		
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
