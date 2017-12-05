<?php

class MakerstudiosVideoHandler extends VideoHandler {

	protected $apiName = 'MakerstudiosWrapper';
	protected static $urlTemplate = 'https://www.maker.tv/player/$1';
	protected static $providerHomeUrl = 'https://www.makerstudios.com/';

	public function getEmbed( $width, array $options = [] ) {
		$height =  $this->getHeight( $width );
		$sizeString = $this->getSizeString( $width, $height );
		$url = $this->getEmbedUrl();
		if ( !empty( $options['autoplay'] ) ) {
			$url .= '?autoplay=true';
		}

		$html = <<< EOF
<iframe class='videoplayer' src='$url' $sizeString style='border:0; overflow:hidden;' allowfullscreen seamless scrolling='no'></iframe>
EOF;
		return [
			'html'	=> $html,
			'width' => $width,
			'height' => $height,
		];
	}

}
