<?php

class HuluVideoHandler extends VideoHandler {

	protected $apiName = 'HuluApiWrapper';
	protected static $urlTemplate = 'https://www.hulu.com/embed/$1';
	protected static $providerDetailUrlTemplate = 'https://www.hulu.com/watch/$1';
	protected static $providerHomeUrl = 'https://www.hulu.com/';
	protected static $autoplayParam = "";
	protected static $autoplayValue = "";

	public function getEmbed( $width, array $options = [] ) {
		$height = $this->getHeight( $width );
		$url = $this->getEmbedUrl();

		$sizeString = $this->getSizeString( $width, $height );

		$html = <<<EOT
<object $sizeString>
	<param name="movie" value="$url"></param>
	<param name="allowFullScreen" value="true"></param>
	<embed src="$url" type="application/x-shockwave-flash" width="$width" height="$height" allowFullScreen="true" wmode="transparent" allowscriptaccess="always"></embed>
</object>
EOT;

		return array(
			'html' => $html,
			'width' => $width,
			'height' => $height,
		);
	}

}