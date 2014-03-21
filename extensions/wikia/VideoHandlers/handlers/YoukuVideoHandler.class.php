<?php

class YoukuVideoHandler extends VideoHandler {

	protected $apiName = 'YoukuApiWrapper';
	protected static $urlTemplate = 'http://www.youtube.com/embed/$1';
	protected static $providerDetailUrlTemplate = "http://v.youku.com/v_show/id_$1.html";
	protected static $providerHomeUrl = 'http://www.youku.com/';

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {

		$height =  $this->getHeight( $width );
		$apiKey = F::app()->wg->YoukuConfig['AppKey'];
		$jsFile = 'http://player.youku.com/jsapi';

		$html = <<< EOF
<div id="youkuplayer" style="width: {$width}px; height: {$height}px"></div>
EOF;


		return array(
			'html'	=> $html,
			'width' => $width,
			'height' => $height,
			'scripts' => array(
				$jsFile,
				"extensions/wikia/VideoHandlers/js/handlers/Youku.js"
			),
			'jsParams' => array(
				'styleid'	=> '0',
				'client_id'	=> F::app()->wg->YoukuConfig['AppKey'],
				'vid'		=> $this->videoId,
				'autoplay'	=> true,
			),
			'init' => 'wikia.videohandler.youku',
		);
	}

}
