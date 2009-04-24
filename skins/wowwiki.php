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
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */

// macbre: use monobook skin as base
require_once("skins/MonoBook.php");

class SkinWowwiki extends SkinMonoBook {
	/** Using monobook. */
	function initPage( OutputPage &$out ) {
		parent::initPage( $out );
		$this->skinname  = 'wowwiki';
		$this->stylename = 'wowwiki';
		$this->template  = 'WowWikiTemplate';

		// turn off ads
		$this->ads = false;
	}

	function setupSkinUserCss( OutputPage $out ) {
		// Append to the default screen common & print styles...
		WikiaSkinMonobook::setupSkinUserCss( $out );

		$out->addStyle( 'wowwiki/main.css', 'screen' );

		$out->addStyle( 'wowwiki/IE50Fixes.css', 'screen', 'lt IE 5.5000' );
		$out->addStyle( 'wowwiki/IE55Fixes.css', 'screen', 'IE 5.5000' );
		$out->addStyle( 'wowwiki/IE60Fixes.css', 'screen', 'IE 6' );
		$out->addStyle( 'wowwiki/IE70Fixes.css', 'screen', 'IE 7' );

		$out->addStyle( 'wowwiki/rtl.css', 'screen', '', 'rtl' );
	}

	// don't return "wikia" toolbox
	protected function buildWikiaToolbox() {
		return '';
	}

	public function addWikiaCss(&$out) {
		return true;
	}

	public function addWikiaVars(&$obj, &$tpl) {
		wfProfileIn(__METHOD__);

		parent::addWikiaVars($obj, $tpl);

		$tpl->set('copyright', '<a href="http://www.gnu.org/copyleft/fdl.html" class="external " title="http://www.gnu.org/copyleft/fdl.html" rel="nofollow">GFDL</a>');
		$tpl->set('privacy', '<a href="http://www.wikia.com/wiki/Wikia:Privacy_Policy" title="w:Wikia:Privacy Policy">Terms of use</a>');
		$tpl->set('about', '<a href="/WoWWiki:About" title="WoWWiki:About">About WoWWiki</a>');
		$tpl->set('disclaimer', '<a href="/WoWWiki:General_disclaimer" title="WoWWiki:General disclaimer">Disclaimers</a>');

		wfProfileOut(__METHOD__);
		return true;
	}
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class WowWikiTemplate extends MonoBookTemplate {

	// customize wowwiki search box
	function searchBox() {
		global $wgUser;
		if ($wgUser->isLoggedIn()) {
			$ch = '9345733685';
		}
		else {
			$ch = '6987656965'; /* anon */
		}
?>
	<div id="p-search" class="portlet">
		<h5><label for="searchInput"><?php $this->msg('search') ?></label></h5>
<!-- SiteSearch Google -->
<div id="searchBody" class="pBody" style="background: #333333;">
<form method="get" action="http://www.google.com/custom" target="_top">
<table border="0" style="background: #333333; border: none">
<tr><td nowrap="nowrap" valign="top" align="left" height="32">
<a href="http://www.google.com/">
<img src="http://www.google.com/logos/Logo_25blk.gif"
border="0" alt="Google"></img></a>
<br/>
<input type="hidden" name="domains" value="wowwiki.com"></input>
<input type="text" name="q" size="25" maxlength="255" value="" style="width: 125px"></input>
</td></tr>
<tr>
<td nowrap="nowrap">
<table style="background: transparent">
<tr style="padding-left: 0px;">
<td>
<input type="radio" name="sitesearch" value=""></input>
<font size="-1" color="#ffffff">Web</font>
</td>
<td>
<input type="radio" name="sitesearch" value="wowwiki.com" checked="checked"></input>
<font size="-1" color="#ffffff">wowwiki</font>
</td>
</tr>
</table><br>
<input type="submit" name="sa" value="Search" class="searchButton"></input>
<input type="hidden" name="client" value="pub-4086838842346968"></input>
<input type="hidden" name="forid" value="1"></input>
<input type="hidden" name="channel" value="' . $ch . '"></input>
<input type="hidden" name="ie" value="UTF-8"></input>
<input type="hidden" name="oe" value="UTF-8"></input>
<input type="hidden" name="cof" value="GALT:#46ABFF;GL:1;DIV:#EEEEEE;VLC:4274FF;AH:center;BGC:333333;LBGC:FFFF99;ALC:46ABFF;LC:46ABFF;T:EEEEEE;GFNT:AAAAAA;GIMP:AAAAAA;LH:100;LW:100;L:http://images.wikia.com/common/skins-wow/common/images/wiki-100.jpg;S:http://www.wowwiki.com/;LP:1;FORID:1;"></input>
<input type="hidden" name="hl" value="en"></input>
</td></tr></table>
</form>
</div>
<!-- SiteSearch Google -->
	</div>
<?php
	}

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
