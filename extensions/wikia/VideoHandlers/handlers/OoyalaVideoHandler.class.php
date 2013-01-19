<?php

class OoyalaVideoHandler extends VideoHandler {

	protected $apiName = 'OoyalaApiWrapper';
	protected static $urlTemplate = 'http://player.ooyala.com/player.swf?embedCode=$1&version=2';
	protected static $providerDetailUrlTemplate = 'http://video.wikia.com/';
	protected static $providerHomeUrl = 'http://video.wikia.com/';

	public function getEmbed( $articleId, $width, $autoplay = false, $isAjax = false, $postOnload=false ) {
		$height = $this->getHeight($width);
		$autoPlayStr = ( $autoplay ) ? 1 : 0;
		$containerId = 'ooyalaplayer-'.$this->videoId.'-'.time();

		$embed = <<<EOT
<div id="{$containerId}" style="width:{$width}px;"></div>
<script type="text/javascript" src="http://player.ooyala.com/player.js?embedCode={$this->videoId}&width={$width}&height={$height}&playerContainerId={$containerId}&autoplay={$autoPlayStr}"></script>
EOT;

		return $embed;
	}

}

class WikiawebinarsVideoHandler extends OoyalaVideoHandler {
}

class FunimationVideoHandler extends OoyalaVideoHandler {
}

class WbieVideoHandler extends OoyalaVideoHandler {
}

class SoeVideoHandler extends OoyalaVideoHandler {
}

class WikiaproductionsVideoHandler extends OoyalaVideoHandler {
}

class KonamiVideoHandler extends OoyalaVideoHandler {
}

class EaVideoHandler extends OoyalaVideoHandler {
}

class KabamVideoHandler extends OoyalaVideoHandler {
}

class SonypicturesVideoHandler extends OoyalaVideoHandler {
}

class UniversalVideoHandler extends OoyalaVideoHandler {
}

class WarnerbrothersVideoHandler extends OoyalaVideoHandler {
}

class FoxVideoHandler extends OoyalaVideoHandler {
}

class AllianceVideoHandler extends OoyalaVideoHandler {
}

class BiowareVideoHandler extends OoyalaVideoHandler {
}

class SquareenixVideoHandler extends OoyalaVideoHandler {
}

class TrionVideoHandler extends OoyalaVideoHandler {
}

class MadhouseVideoHandler extends OoyalaVideoHandler {
}

class BandaiVideoHandler extends OoyalaVideoHandler {
}

class CapcomVideoHandler extends OoyalaVideoHandler {
}

class GamesworkshopVideoHandler extends OoyalaVideoHandler {
}

class JagexVideoHandler extends OoyalaVideoHandler {
}

class PerfectworldVideoHandler extends OoyalaVideoHandler {
}

class WaltdisneyVideoHandler extends OoyalaVideoHandler {
}

class DreamworksVideoHandler extends OoyalaVideoHandler {
}

class PixarVideoHandler extends OoyalaVideoHandler {
}

class TatemultimediaVideoHandler extends OoyalaVideoHandler {
}

class EpktvVideoHandler extends OoyalaVideoHandler {
}

class LionsgateVideoHandler extends OoyalaVideoHandler {
}

class SummitVideoHandler extends OoyalaVideoHandler {
}

class CbsfilmsVideoHandler extends OoyalaVideoHandler {
}

class WeinsteincoVideoHandler extends OoyalaVideoHandler {
}

class GamespressVideoHandler extends OoyalaVideoHandler {
}

class SegaVideoHandler extends OoyalaVideoHandler {
}

class OpenroadfilmsVideoHandler extends OoyalaVideoHandler {
}

class UbisoftVideoHandler extends OoyalaVideoHandler {
}

class NamcoVideoHandler extends OoyalaVideoHandler {
}

class GrindinggearVideoHandler extends OoyalaVideoHandler {
}
