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

		$html = <<<EOT
<div id="AnyClipPlayer" style="width: {$width}px; height: {$height}px;"></div>
EOT;

		if ( $autoplay ) {
			$html .= <<<EOT
<script type="text/javascript">
	$.when(
		$.getScript('http://player.anyclip.com/embed/AnyClipPlayer.js')
	).done(function() {
		AnyClipPlayer.load(["#AnyClipPlayer", {clipID:"{$this->videoId}", autoPlay:true}]);
	});
</script>
EOT;
		} else {
			$html .= <<<EOT
<script type="text/javascript" src="http://player.anyclip.com/embed/AnyClipPlayer.js"></script>
<script type="text/javascript">AnyClipPlayer.load(["#AnyClipPlayer", {clipID:"{$this->videoId}"}]);</script>
EOT;
		}

		return $html;
	}

}
