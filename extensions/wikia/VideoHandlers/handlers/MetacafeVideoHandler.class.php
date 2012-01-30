<?php

class MetacafeVideoHandler extends VideoHandler {
	
	protected $apiName = 'MetacafeApiWrapper';
	protected static $urlTemplate = 'http://www.metacafe.com/fplayer/$1/.swf';
	
	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false) {
		$height =  $this->getHeight( $width );
		$sAutoPlay = $autoplay  ? 'yes' : 'no';
		$url = str_replace('$1', $this->videoId,  self::$urlTemplate);

		$embedCode = <<<EOT
<embed flashVars="playerVars=autoPlay={$sAutoPlay}" src="{$url}" width="{$width}" height="{$height}" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_{$articleId}" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
EOT;
		return $embedCode;
	}

	function getAspectRatio(){
		$metadata = $this->getMetadata( true );
		return $metadata['aspectRatio'];
	}
}