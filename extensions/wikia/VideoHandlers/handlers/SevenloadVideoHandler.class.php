<?php

class SevenloadVideoHandler extends VideoHandler {
	protected $apiName = 'SevenloadApiWrapper';
	protected static $urlTemplate = 'http://en.sevenload.com/pl/$1';
	protected static $providerDetailUrlTemplate = 'http://sevenload.com/videos/$1';
	protected static $providerHomeUrl = 'http://sevenload.com/';
	protected static $autoplayParam = "play";

	public function getEmbed($articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false) {
		$height = $this->getHeight($width);
		$autoplayStr = ( $autoplay ) ? '/' . self::$autoplayParam : '' ;
		$url = $this->getEmbedUrl();
		$url .= '/'.$width.'x'.$height.'/swf'.$autoplayStr;
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object type="application/x-shockwave-flash" data="$url" $sizeString>
	<param name="allowFullscreen" value="true" />
	<param name="allowScriptAccess" value="always" />
	<param name="movie" value="{$url}" />
</object>
EOT;

		return array( 'html' => $html );
	}

}