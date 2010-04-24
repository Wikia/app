<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Google AdSense code generator
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) 2007 Tomasz Klim (private, proprietary code)
 *
 * PERMISSION FOR ADSENSE CODE MODIFICATION AND INTEGRATION WITH CUSTOM APPLICATION
 * GRANTED EXCLUSIVELY FOR TOMASZ KLIM (#111346957). DO NOT EDIT THIS CLASS YOURSELF.
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'WikiAdsense',
	'description' => 'google adsense code generator module',
	'author' => 'Tomasz Klim'
);


class WikiAdsense
{
    var $client = 'pub-4086838842346968';
    var $channel = '';
    var $alt_url = 'http://wikia.com/skins/monobook/google_adsense_script.html';

    var $color_bg = 'FFFFFF';
    var $color_url = '008000';
    var $color_link = '0000FF';
    var $color_text = '000000';
    var $color_border = 'FFFFFF';

    function setColors( $color_bg, $color_url, $color_link, $color_text, $color_border ) {
	$this->color_bg = $color_bg;
	$this->color_url = $color_url;
	$this->color_link = $color_link;
	$this->color_text = $color_text;
	$this->color_border = $color_border;
    }

    // supported types: 234x60 468x60 728x90 - 120x240 120x600 160x600 - 125x125 180x150 200x200 250x250 300x250 336x280
    function getBannerCode( $width, $height, $type = false, $hints = false ) {
	$ad_type = ( $type ? "\ngoogle_ad_type = \"$type\";" : "" );
	$ad_hints = ( $hints ? "\ngoogle_hints = \"$hints\";" : "" );
	return "
<script type=\"text/javascript\"><!--
google_ad_client = \"$this->client\";
google_ad_width = $width;
google_ad_height = $height;
google_ad_format = \"{$width}x{$height}_as\";{$ad_type}
google_ad_region = \"region\";
google_ad_channel = \"$this->channel\";{$ad_hints}
google_alternate_ad_url = \"$this->alt_url\";
google_color_border = \"$this->color_border\";
google_color_bg = \"$this->color_bg\";
google_color_link = \"$this->color_link\";
google_color_text = \"$this->color_text\";
google_color_url = \"$this->color_url\";
//--></script>
<script type=\"text/javascript\"
  src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
</script>
";
    }
}


?>
