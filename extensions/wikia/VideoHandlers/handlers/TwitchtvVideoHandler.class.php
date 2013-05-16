<?php

class TwitchtvVideoHandler extends VideoHandler {

	protected $apiName = 'TwitchtvApiWrapper';
	protected static $urlTemplate = 'http://www.twitch.tv/widgets/live_embed_player.swf?channel=$1';
	protected static $providerDetailUrlTemplate = 'http://www.twitch.tv/$1';
	protected static $providerHomeUrl = 'http://www.twitch.tv';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height = $this->getHeight( $width );
		$url = $this->getEmbedUrl();
		$autoplayStr = $autoplay ? 'true' : 'false';
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object type="application/x-shockwave-flash" $sizeString data="$url">
	<param name="allowFullScreen" value="true" />
	<param name="allowScriptAccess" value="always" />
	<param name="allowNetworking" value="all" />
	<param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" />
	<param name="flashvars" value="hostname=www.twitch.tv&channel={$this->videoId}&auto_play={$autoplayStr}&start_volume=25" />
</object>
EOT;

		return array( 'html' => $html );
	}

}