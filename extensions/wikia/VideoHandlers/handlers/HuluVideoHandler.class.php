<?php

class HuluVideoHandler extends VideoHandler {
	
	protected $apiName = 'HuluApiWrapper';
	protected static $urlTemplate = 'http://www.hulu.com/embed/$1';
	protected static $providerDetailUrlTemplate = 'http://www.hulu.com/watch/$1';
	protected static $providerHomeUrl = 'http://www.hulu.com/';
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height = $this->getHeight($width);
		$url = str_replace('$1', $this->getEmbedVideoId(), static::$urlTemplate);
		$html = <<<EOT
<object width="$width" height="$height">
	<param name="movie" value="$url"></param>
	<param name="allowFullScreen" value="true"></param>
	<embed src="$url" type="application/x-shockwave-flash" width="$width" height="$height" allowFullScreen="true" wmode="transparent" allowscriptaccess="always"></embed>
</object>
EOT;
		return $html;
	}
	
}