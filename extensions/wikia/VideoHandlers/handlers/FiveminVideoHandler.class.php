<?php

class FiveminVideoHandler extends VideoHandler {
	
	protected $apiName = 'FiveminApiWrapper';
	protected static $urlTemplate = 'http://www.5min.com/Embeded/$1/&autostart=$2';
	protected static $providerDetailUrlTemplate = 'http://www.5min.com/Video/$1';
	protected static $providerHomeUrl = 'http://www.5min.com/';
		
	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$sAutoPlay = $autoplay  ? 'true' : 'false';
		$url = str_replace( '$1', $this->videoId, self::$urlTemplate );
		$url = str_replace( '$2', $sAutoPlay, $url );
		$embedCode = <<<EOT
<embed src='{$url}' type='application/x-shockwave-flash' width="{$width}" height="{$height}" allowfullscreen='true' allowScriptAccess='always'></embed>
EOT;
		return $embedCode;
	}
}