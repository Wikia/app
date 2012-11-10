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

		$html = <<<EOT
<div id="AnyClipPlayer-{$this->videoId}-{$ajaxStr}" style="width: {$width}px; height: {$height}px;"></div>
EOT;

		if ( $isAjax || $postOnload ) {
			$html .= <<<EOT
<script type="text/javascript">
	$.when(
		$.getScript('http://player.anyclip.com/embed/AnyClipPlayer.js')
	).done(function() {
		AnyClipPlayer.load(["#AnyClipPlayer-{$this->videoId}-{$ajaxStr}", {clipID:"{$this->videoId}"{$autoPlayStr}}]);
	});
</script>
EOT;
		} else {
			$html .= <<<EOT
<script type="text/javascript" src="http://player.anyclip.com/embed/AnyClipPlayer.js"></script>
<script type="text/javascript">AnyClipPlayer.load(["#AnyClipPlayer-{$this->videoId}-{$ajaxStr}", {clipID:"{$this->videoId}{$autoPlayStr}"}]);</script>
EOT;
		}

		return $html;
	}

}
