<?php

class MovieclipsVideoHandler extends VideoHandler {
	
	protected $apiName = 'MovieclipsApiWrapper';
	protected static $urlTemplate = 'http://movieclips.com/e/$1/';
	protected static $providerDetailUrlTemplate = 'http://movieclips.com/$1';
	protected static $providerHomeUrl = 'http://movieclips.com/';
	protected static $autoplayParam = "autoplay";
	protected static $autoplayValue = "true";

	public function getEmbed($articleId, $width, $autoplay=false, $isAjax=false, $postOnload=false) {
		$height =  $this->getHeight( $width );
		
		$url = $this->getEmbedUrl();

		$sizeString = $this->getSizeString( $width, $height );

		if ( F::app()->checkSkin( 'wikiamobile' ) ) {
			$style = '';
		} else {
			$style = "style='background: #000000; display:block; overflow: hidden;'";
		}
		
		$embedCode = <<<EOT
<object $sizeString type="application/x-shockwave-flash" data="$url/" $style>
	<param name="movie" value="$url" />
	<param name="allowfullscreen" value="true" />
	<param name="bgcolor" value="#000000" />
	<param name="wmode" value="transparent" />
	<param name="allowscriptaccess" value="always" />
EOT;
		$embedCode .= '<param name="FlashVars" value="'.self::$autoplayParam.'='.($autoplay ? self::$autoplayValue : 'false').'" />';
		$embedCode .= <<<EOT
	<embed src="$url" type="application/x-shockwave-flash" allowfullscreen="true" movie="$url" wmode="transparent" allowscriptaccess="always" ></embed>
</object>
EOT;
	
		return $embedCode;
	}
		
}