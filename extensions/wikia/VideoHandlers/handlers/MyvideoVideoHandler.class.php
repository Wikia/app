<?php

class MyvideoVideoHandler extends VideoHandler {
	
	protected $apiName = 'MyvideoApiWrapper';
	protected static $aspectRatio = 1.59530026;	// 611 x 383
	protected static $urlTemplate = 'http://www.myvideo.de/movie/';
	
	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false) {
		$height =  $this->getHeight( $width );
		
		$url = self::$urlTemplate . $this->videoId;
		
		$embedCode = <<<EOT
<object style='width:611px;height:383px;' width='$width' height='$height'>
	<embed src='$url' width='$width' height='$height' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true'></embed>
	<param name='movie' value='$url'></param>
	<param name='AllowFullscreen' value='true'></param>
	<param name='AllowScriptAccess' value='always'></param>
</object>
EOT;
	
		return $embedCode;
	}
		
}