<?php

class AnyclipVideoHandler extends VideoHandler {

	protected $apiName = 'AnyclipApiWrapper';
	protected static $urlTemplate = 'http://player.anyclip.com/AnyClipPlayer.swf?clipid=$1';
	protected static $providerDetailUrlTemplate = 'http://www.anyclip.com/$1/';
	protected static $providerHomeUrl = 'http://www.anyclip.com';

	public function getProviderDetailUrl() {
		$metadata = $this->getMetadata( true );
		$url = $metadata['videoUrl'];

		return $url;
	}

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height =  $this->getHeight( $width );
		$autoPlayStr = ( $autoplay ) ? ', autoPlay:true' : '';
		$ajaxStr = (bool) $isAjax;
		$jsFile = 'http://player.anyclip.com/embed/AnyClipPlayerLite.min.js'; // Note: This file depends on jQuery

		$html = <<<EOT
<div id="AnyClipPlayer-{$this->videoId}-{$ajaxStr}" style="width: {$width}px; height: {$height}px;"></div>
EOT;

		/* Notes on AnyClipPlayer.load():
		 * Each parameter passed to load() is an array that represents a new player instance
		 * Array[0] = DOM element and player id
		 * Array[1] = flash vars to be added
		 * Array[2] = params for object tag
		 */
		
		if ( $isAjax || $postOnload ) {
			$html .= <<<EOT
<script type="text/javascript">
	$.when(
		$.getScript('{$jsFile}')
	).done(function() {
		AnyClipPlayer.load(["#AnyClipPlayer-{$this->videoId}-{$ajaxStr}", {clipID:"{$this->videoId}"{$autoPlayStr}}, {wmode: "opaque"}]);
	});
</script>
EOT;
		} else {
			$html .= <<<EOT
<script type="text/javascript" src="{$jsFile}"></script>
<script type="text/javascript">AnyClipPlayer.load(["#AnyClipPlayer-{$this->videoId}-{$ajaxStr}", {clipID:"{$this->videoId}{$autoPlayStr}"}, {wmode: "opaque"}]);</script>
EOT;
		}

		return $html;
	}

}
