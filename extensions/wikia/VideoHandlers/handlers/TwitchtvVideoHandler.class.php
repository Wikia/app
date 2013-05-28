<?php

class TwitchtvVideoHandler extends VideoHandler {

	protected $apiName = 'TwitchtvApiWrapper';
	protected static $urlTemplate = 'http://www.twitch.tv/widgets/$1';
	protected static $providerDetailUrlTemplate = 'http://www.twitch.tv/$1';
	protected static $providerHomeUrl = 'http://www.twitch.tv';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload = false ) {
		$height = $this->getHeight( $width );
		$autoplayStr = $autoplay ? 'true' : 'false';
		$sizeString = $this->getSizeString( $width, $height );
		$url = $this->getEmbedUrl();

		if ( $this->isLiveVideo() ) {
			$flashvars = "hostname=www.twitch.tv&channel={$this->videoId}&auto_play={$autoplayStr}&start_volume=25";
		} else {
			$channel = $this->getVideoChannel();
			$chapter_id = filter_var( $this->videoId, FILTER_SANITIZE_NUMBER_INT );
			$flashvars = "channel={$channel}&start_volume=25&auto_play={$autoplayStr}&chapter_id={$chapter_id}";
		}

		$html = <<<EOT
<object type="application/x-shockwave-flash" $sizeString data="$url">
	<param name="allowFullScreen" value="true" />
	<param name="allowScriptAccess" value="always" />
	<param name="allowNetworking" value="all" />
	<param name="movie" value="$url" />
	<param name="flashvars" value="$flashvars" />
</object>
EOT;

		return array( 'html' => $html );
	}

	protected function getVideoChannel() {
		return $this->getMetadataValue( 'channel' );
	}

	protected function getVideoUrl() {
		return $this->getMetadataValue( 'videoUrl' );
	}

	public function getProviderDetailUrl() {
		$url = $this->getVideoUrl();
		if ( !empty( $url ) ) {
			return $url;
		}

		return parent::getProviderDetailUrl();
	}

	public function getEmbedUrl() {
		if ( $this->isLiveVideo() ) {
			$param = 'live_embed_player.swf?channel='.$this->getEmbedVideoId();
		} else {
			$param = 'archive_embed_player.swf';
		}

		return str_replace( '$1', $param, static::$urlTemplate );
	}

	protected function isLiveVideo() {
		$category = $this->getVideoCategory();
		if ( empty( $category ) || $category == 'live gaming' ) {
			return true;
		}

		return false;
	}

}