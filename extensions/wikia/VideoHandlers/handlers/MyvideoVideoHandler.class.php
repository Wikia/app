<?php

class MyvideoVideoHandler extends VideoHandler {

	protected $apiName = 'MyvideoApiWrapper';
	protected static $urlTemplate = 'http://www.myvideo.de/movie/$1';
	protected static $providerDetailUrlTemplate = 'http://www.myvideo.de/watch/$1';
	protected static $providerHomeUrl = 'http://www.myvideo.de/';
	protected static $autoplayParam = "";
	protected static $autoplayValue = "";

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		$height =  $this->getHeight( $width );

		$url = $this->getEmbedUrl();

		$sizeString = $this->getSizeString( '611', '383', 'inline' );
		$sizeStringElement = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object $sizeString $sizeStringElement>
	<embed src='$url' $sizeStringElement type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true'></embed>
	<param name='movie' value='$url'></param>
	<param name='AllowFullscreen' value='true'></param>
	<param name='AllowScriptAccess' value='always'></param>
</object>
EOT;

		return array( 'html' => $html );
	}

}