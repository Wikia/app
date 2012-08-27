<?php

class IgnVideoHandler extends VideoHandler {

	protected $apiName = 'IgnApiWrapper';
	protected static $urlTemplate = '';
	protected static $providerDetailUrlTemplate = 'http://www.ign.com/watch?v=$1';
	protected static $providerHomeUrl = 'http://www.ign.com/';

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		return $this->getEmbedNative($width, $autoplay);
	}

	private function getEmbedNative($width, $autoplay=false) {
		// YouTube parameters: http://code.google.com/apis/youtube/player_parameters.html
		$height =  $this->getHeight( $width );
		$videoUrl = $this->getEmbedUrl();
		$autoplay = $autoplay ? '?qs_autoplay=true' : '';

		$code = <<<EOT
		<object id="vid_{$this->videoId}" class="ign-videoplayer" width="$width" height="$height" data="http://media.ign.com/ev/prod/embed.swf" type="application/x-shockwave-flash"><param name="movie" value="http://media.ign.com/ev/prod/embed.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="bgcolor" value="#000000" /><param name="flashvars" value="url={$videoUrl}{$autoplay}"/></object>
EOT;
		return $code;
	}

	public function getEmbedUrl() {
		$metadata = $this->getMetadata(true);
		$url = $metadata['videoUrl'];

		return $url;
	}

}
