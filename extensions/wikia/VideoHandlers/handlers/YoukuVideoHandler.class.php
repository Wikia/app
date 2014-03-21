<?php

class YoukuVideoHandler extends VideoHandler {

	protected $apiName = 'YoukuApiWrapper';
	protected static $urlTemplate = 'http://player.youku.com/player.php/sid/$1/v.swf';
	protected static $providerDetailUrlTemplate = "http://v.youku.com/v_show/id_$1.html";
	protected static $providerHomeUrl = 'http://www.youku.com/';

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {

		$height =  $this->getHeight( $width );
		$youKuConfig = F::app()->wg->YoukuConfig;
		$html = <<< EOF
<div id="youkuplayer" style="width: {$width}px; height: {$height}px"></div>
EOF;

		return array(
			'html'	=> $html,
			'width' => $width,
			'height' => $height,
			'scripts' => array(
				'http://player.youku.com/jsapi',
				"extensions/wikia/VideoHandlers/js/handlers/Youku.js"
			),
			'jsParams' => array(
				'styleid'	=> $youKuConfig['playerColor'],
				'client_id'	=> $youKuConfig['AppKey'],
				'vid'		=> $this->videoId,
				'autoplay'	=> $autoplay,
			),
			'init' => 'wikia.videohandler.youku',
		);
	}

}
