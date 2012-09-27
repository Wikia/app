<?php

class MetacafeVideoHandler extends VideoHandler {
	
	protected $apiName = 'MetacafeApiWrapper';
	protected static $urlTemplate = 'http://www.metacafe.com/fplayer/$1/.swf';
	protected static $providerDetailUrlTemplate = 'http://www.metacafe.com/watch/$1';
	protected static $providerHomeUrl = 'http://www.metacafe.com/';
	protected static $autoplayParam = "autoPlay=yes";
	
	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload = false) {
		$height =  $this->getHeight( $width );
		$sAutoPlay = $autoplay  ? 'yes' : 'no';
		$url = $this->getEmbedUrl();

		$embedCode = <<<EOT
<embed flashVars="playerVars=autoPlay={$sAutoPlay}" src="{$url}" width="{$width}" height="{$height}" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_{$articleId}" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
EOT;
		return $embedCode;
	}

}