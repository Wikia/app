<?php

class MyvideoVideoHandler extends VideoHandler {
	
	protected $apiName = 'MyvideoApiWrapper';
	protected static $urlTemplate = 'http://www.myvideo.de/movie/$1';
	protected static $providerDetailUrlTemplate = 'http://www.myvideo.de/watch/$1';
	protected static $providerHomeUrl = 'http://www.myvideo.de/';
	
	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		$height =  $this->getHeight( $width );
		
		$url = $this->getEmbedUrl();
		
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