<?php

class HuluVideoHandler extends VideoHandler {
	
	protected $apiName = 'HuluApiWrapper';
	protected static $aspectRatio = 1.7777778;
	protected static $urlTemplate = 'http://www.hulu.com/embed/$1';
	
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height = $this->getHeight($width);
		$url = str_replace('$1', $this->getEmbedVideoId(), static::$urlTemplate);
		$html = <<<EOT
<object width="$width" height="$height">
	<param name="movie" value="$url"></param>
	<param name="allowFullScreen" value="true"></param>
	<embed src="$url" type="application/x-shockwave-flash" width="$width" height="$height" allowFullScreen="true"></embed>
</object>
EOT;
		return $html;
	}
	
}