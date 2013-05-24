<?php

class TwitchtvVideoHandler extends VideoHandler {

	protected $apiName = 'TwitchtvApiWrapper';
	protected static $urlTemplate = 'http://www.twitch.tv/widgets/live_embed_player.swf?channel=$1';
	protected static $providerDetailUrlTemplate = 'http://www.twitch.tv/$1';
	protected static $providerHomeUrl = 'http://www.twitch.tv';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height = $this->getHeight( $width );
		$autoplayStr = $autoplay ? 'true' : 'false';
		$sizeString = $this->getSizeString( $width, $height );
		$category = $this->getVideoCategory();

		if ( $category == 'live gaming') {
			$url = $this->getEmbedUrl();
			$movieParam = 'http://www.twitch.tv/widgets/live_embed_player.swf';
			$flashvars = "hostname=www.twitch.tv&channel={$this->videoId}&auto_play={$autoplayStr}&start_volume=25";
		} else {
			$url = 'http://www.twitch.tv/widgets/archive_embed_player.swf';
			$movieParam = $url;
			$channel = $this->getVideoChannel();
			$chapter_id = filter_var( $this->videoId, FILTER_SANITIZE_NUMBER_INT );
			$flashvars = "channel={$channel}&start_volume=25&auto_play={$autoplayStr}&chapter_id={$chapter_id}";
		}

		$html = <<<EOT
<object type="application/x-shockwave-flash" $sizeString data="$url">
	<param name="allowFullScreen" value="true" />
	<param name="allowScriptAccess" value="always" />
	<param name="allowNetworking" value="all" />
	<param name="movie" value="$movieParam" />
	<param name="flashvars" value="$flashvars" />
</object>
EOT;

		return array( 'html' => $html );
	}

	protected function getVideoChannel() {
		return $this->getMetadataValue( 'channel', '' );
	}

}