<?php

class IgnVideoHandler extends VideoHandler {

	protected $apiName = 'IgnApiWrapper';
	protected static $urlTemplate = '';
	protected static $providerDetailUrlTemplate = 'http://www.ign.com/watch?v=$1';
	protected static $providerPlayerUrl = 'http://media.ign.com/ev/prod/embed.swf';
	protected static $providerHomeUrl = 'http://www.ign.com/';
	protected static $autoplayParam = "qs_autoplay";
	protected static $autoplayValue = "true";

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		return $this->getEmbedNative($width, $autoplay);
	}

	private function getEmbedNative($width, $autoplay=false) {
		// YouTube parameters: http://code.google.com/apis/youtube/player_parameters.html
		$height =  $this->getHeight( $width );
		$videoUrl = $this->getEmbedUrl();
		$autoplay = $autoplay ? '?' . self::$autoplayParam . '=' . self::$autoplayValue : '';
		$playerUrl = self::$providerPlayerUrl;

		$code = <<<EOT
		<object id="vid_{$this->videoId}" class="ign-videoplayer" width="$width" height="$height" data="{$playerUrl}" type="application/x-shockwave-flash"><param name="movie" value="{$playerUrl}" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="bgcolor" value="#000000" /><param name="flashvars" value="url={$videoUrl}{$autoplay}"/></object>
EOT;
		return $code;
	}

	public function getEmbedUrl() {
		$metadata = $this->getMetadata(true);
		$url = $metadata['videoUrl'];

		return $url;
	}


	public function getEmbedSrcData() {
		$data = array();
		$data['autoplayParam'] = $this->getAutoplayString();
		$data['srcParam'] = static::$providerPlayerUrl . '?url='.$this->getEmbedUrl();
		$data['srcType'] = 'player';

		return $data;
	}

}
