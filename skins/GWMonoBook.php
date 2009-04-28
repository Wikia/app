<?php
/**
 * MonoBook nouveau
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/**
 * Inherit main code from MonoBookTemplate, set the CSS and custom template elements.
 * @todo document
 * @ingroup Skins
 */

require_once("skins/MonoBook.php");

class SkinGuildWars extends SkinMonoBook {
	/** Using monobook. */
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'monobook';
		$this->stylename = 'monobook/gw';
		$this->template  = 'GuildWarsTemplate';
	}

	function setupSkinUserCss( OutputPage $out ) {
		// Append to the default screen common & print styles...
		WikiaSkinMonobook::setupSkinUserCss( $out );

		$out->addStyle( 'monobook/gw/main.css', 'screen' );

		$out->addStyle( 'monobook/gw/IE50Fixes.css', 'screen', 'lt IE 5.5000' );
		$out->addStyle( 'monobook/gw/IE55Fixes.css', 'screen', 'IE 5.5000' );
		$out->addStyle( 'monobook/gw/IE60Fixes.css', 'screen', 'IE 6' );
		$out->addStyle( 'monobook/gw/IE70Fixes.css', 'screen', 'IE 7' );

		$out->addStyle( 'monobook/gw/rtl.css', 'screen', '', 'rtl' );
	}

	// don't return "wikia" toolbox
	protected function buildWikiaToolbox() {
		return '';
	}

	public function addWikiaCss(&$out) {
		return true;
	}
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class GuildWarsTemplate extends MonoBookTemplate {

	function execute() {

		$this->data['ads_bottomjs'] = <<<ADS
<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
<script type="text/javascript">_qacct="p-8bG6eLqkH6Avk";quantserve();</script>
<noscript>
<a href="http://www.quantcast.com/p-8bG6eLqkH6Avk" target="_blank"><img src="http://pixel.quantserve.com/pixel/p-8bG6eLqkH6Avk.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/></a>
</noscript>
<script type='text/javascript'><!--//<![CDATA[
var m3_u = (location.protocol=='https:'?'https://wikia-ads.wikia.com/www/delivery/ajs.php':'http://wikia-ads.wikia.com/www/delivery/ajs.php');
var m3_r = Math.floor(Math.random()*99999999999);
if (!document.MAX_used) document.MAX_used = ',';
document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
document.write ("?zoneid=15");
document.write ('&amp;cb=' + m3_r);
if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
document.write ("&amp;loc=" + escape(window.location));
if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
if (document.context) document.write ("&context=" + escape(document.context));
if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://wikia-ads.wikia.com/www/delivery/ck.php?n=a1137749&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://wikia-ads.wikia.com/www/delivery/avw.php?zoneid=15&amp;n=a1137749' border='0' alt='' /></a></noscript>
ADS;
		parent::execute();
	}

	// HTML to be added between footer and end of page
	function navbar() {
?>
<div id="navbar">
	<ul>
		<li>More <a href="http://gamewikis.org">GameWikis</a> projects: </li><li><a href="http://fury.gamewikis.org">FuryWiki</a> (Fury)</li><li><a href="http://war.gamewikis.org">HammerWiki</a> (Warhammer Online)</li><li><a href="http://oblivion.gamewikis.org">OblivioWiki</a> (TES IV: Oblivion)</li><li class="suggesta"><a href="http://requests.wikia.com/">Suggest a wiki</a></li>
	</ul>
</div>
<?php		
	}

	// customize wowwiki search box
	function searchBox() {
		parent::searchBox();
?>
	<div class="portlet" id="p-seg" style="padding-top: 2px; border: none;">
		<h5>Sponsors</h5>
		<div class="pBody" style="border: none; padding-left: 15px;">
<script type="text/javascript"><!--
google_ad_client = "pub-4086838842346968";
google_ad_width = 125;
google_ad_height = 125;
google_ad_format = "125x125_as";
google_ad_type = "text_image";
google_ad_channel = "9000000019";
google_color_border = "ffffff";
google_color_bg = "FFFFFF";
google_color_link = "0000FF";
google_color_text = "000000";
google_color_url = "008000";
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
		</div>
	</div>
<?php	}

	function footer() {
		if($this->data['poweredbyico']) { ?>
				<div id="f-poweredbyico"><?php $this->html('poweredbyico') ?></div>
<?php 	}
		if($this->data['copyrightico']) { ?>
				<div id="f-copyrightico"><?php $this->html('copyrightico') ?></div>
<?php	}

		// Generate additional footer links
?>
			<ul id="f-list">
<?php
		$footerlinks = array(
			'lastmod', 'viewcount', 'numberofwatchingusers', 'credits', 'copyright',
			'privacy', 'about', 'disclaimer', 'tagline',
		);
		foreach( $footerlinks as $aLink ) {
			if( $this->data[$aLink] ) {
?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
<?php 		}
		}
?>
			</ul>
<?php	}

}
