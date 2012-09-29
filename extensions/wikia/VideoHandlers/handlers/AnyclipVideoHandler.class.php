<?php

class AnyclipVideoHandler extends VideoHandler {

	protected $apiName = 'AnyclipApiWrapper';
	protected static $urlTemplate = '';
	protected static $providerDetailUrlTemplate = 'http://www.anyclip.com/$1/';
	protected static $providerHomeUrl = 'http://www.anyclip.com';

	public function getProviderDetailUrl() {
		$metadata = $this->getMetadata( true );
		$url = $metadata['videoUrl'];

		return $url;
	}

	public function getEmbedUrl() {
		$metadata = $this->getMetadata( true );
		$url = $metadata['videoUrl'];

		return $url;
	}

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$autoPlay = ( $autoplay ) ? ', autoPlay:true' : '' ;

		$html = <<<EOT
<div id="AnyClipPlayer" style="width: {$width}px; height: {$height}px;"></div>
<script type="text/javascript" src="http://player.anyclip.com/embed/AnyClipPlayer.js"></script>
<script type="text/javascript">AnyClipPlayer.load(["#AnyClipPlayer", {clipID:"{$this->videoId}"{$autoPlay}}]);</script>
EOT;

		return $html;
	}

}
