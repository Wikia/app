<?php

class TwitchtvVideoHandler extends VideoHandler {

	protected $apiName = 'TwitchtvApiWrapper';
	protected static $urlTemplate = 'https://www.twitch.tv/widgets/live_embed_player.swf?channel=$1';
	protected static $providerDetailUrlTemplate = 'https://www.twitch.tv/$1';
	protected static $providerHomeUrl = 'https://www.twitch.tv';

	public function getEmbed( $width, array $options = [] ) {
		$autoplay = !empty( $options['autoplay'] );
		$height = $this->getHeight( $width );
		$url = $this->getEmbedUrl();
		$autoplayStr = $autoplay ? 'true' : 'false';
		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object type="application/x-shockwave-flash" $sizeString data="$url">
	<param name="allowFullScreen" value="true" />
	<param name="allowScriptAccess" value="always" />
	<param name="allowNetworking" value="all" />
	<param name="movie" value="https://www.twitch.tv/widgets/live_embed_player.swf" />
	<param name="flashvars" value="hostname=www.twitch.tv&channel={$this->videoId}&auto_play={$autoplayStr}&start_volume=25" />
</object>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

}