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
