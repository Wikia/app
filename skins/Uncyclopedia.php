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

class SkinUncyclopedia extends SkinMonoBook {
	/** Using monobook. */
	function initPage( &$out ) {
		parent::initPage( $out );
		$this->skinname  = 'uncyclopedia';
		$this->stylename = 'uncyclopedia';
		$this->template  = 'UncyclopediaTemplate';

		// turn off ads
		$this->ads = false;
	}

	function setupSkinUserCss( OutputPage $out ) {
		// Append to the default screen common & print styles...
		WikiaSkinMonobook::setupSkinUserCss( $out );

		$out->addStyle( 'uncyclopedia/main.css', 'screen' );

		$out->addStyle( 'uncyclopedia/IE50Fixes.css', 'screen', 'lt IE 5.5000' );
		$out->addStyle( 'uncyclopedia/IE55Fixes.css', 'screen', 'IE 5.5000' );
		$out->addStyle( 'uncyclopedia/IE60Fixes.css', 'screen', 'IE 6' );
		$out->addStyle( 'uncyclopedia/IE70Fixes.css', 'screen', 'IE 7' );

		$out->addStyle( 'uncyclopedia/rtl.css', 'screen', '', 'rtl' );
	}

	// add credit buttons
	protected function buildWikiaToolbox() {
		global $wgStylePath;
		return "
	<div id=\"projects\" class=\"portlet\">
		<h5>projects</h5>
		<div class=\"pBody\"><a href=\"http://stillwatersca.blogspot.com/\">
			<img src=\"{$wgStylePath}/uncyclopedia/stillwaters-button.png\" alt=\"Stillwaters\" width=\"80\" height=\"15\" /></a>
			<a href=\"http://www.chronarion.org/\">
				<img src=\"{$wgStylePath}/uncyclopedia/chronarionbutton.png\" alt=\"chronarion.org\" width=\"80\" height=\"15\" />
			</a>
		</div>
	</div>
";
	}

	public function addWikiaCss(&$out) {
		return true;
	}

	public function addWikiaVars(&$obj, &$tpl) {
		wfProfileIn(__METHOD__);

		parent::addWikiaVars($obj, $tpl);
/*
		$tpl->set('copyright', '<a href="http://www.gnu.org/copyleft/fdl.html" class="external " title="http://www.gnu.org/copyleft/fdl.html" rel="nofollow">GFDL</a>');
		$tpl->set('privacy', '<a href="http://www.wikia.com/wiki/Wikia:Privacy_Policy" title="w:Wikia:Privacy Policy">Terms of use</a>');
		$tpl->set('about', '<a href="/WoWWiki:About" title="WoWWiki:About">About WoWWiki</a>');
		$tpl->set('disclaimer', '<a href="/WoWWiki:General_disclaimer" title="WoWWiki:General disclaimer">Disclaimers</a>');
*/
		wfProfileOut(__METHOD__);
		return true;
	}

}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class UncyclopediaTemplate extends MonoBookTemplate {

	function footer() {
		global $wgUser;
		$skin = $wgUser->getSkin();

		if($this->data['poweredbyico']) { ?>
				<div id="f-poweredbyico"><?php $this->html('poweredbyico') ?></div>
<?php 	}
		if($this->data['copyrightico']) { ?>
				<div id="f-copyrightico"><?php $this->html('copyrightico') ?></div>
<?php	}

		// Generate additional footer links
?>
	<div id="f-hostedbyico" style="float:right">
		<a href="http://www.wikia.com/">
			<img src="http://images.wikia.com/uncyclopedia/images/e/e1/Hosted_by_wikicities.png" alt="Wikia" />
		</a>
	</div>

	<ul id="f-list">
	  <li id="f-lastmod"><?= $this->html('lastmod') ?></li>
	  <li id="f-copyright">Content is available under a <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/">Creative Commons License</a>.</li>
	  <li id="f-about"><a href="<?= $skin->makeUrl('Uncyclopedia:About');?>" title="Uncyclopedia:About">About Uncyclopedia</a></li>
	  <li id="f-disclaimer"><a href="<?= $skin->makeUrl('Uncyclopedia:General_disclaimer');?>" title="Uncyclopedia:General disclaimer">Disclaimers</a></li>
	  <li id="f-diggs"><a href="http://digg.com/submit"  onclick="location.href='http://digg.com/submit?phase=2&amp;url='+encodeURIComponent(location.href)+'&amp;title='+encodeURIComponent(document.title); return false;"><img src="http://images.wikia.com/common/91x17-digg-button.png?js=0" width="91" height="17" id="digg-icon" alt="Digg!" />
	    </a></li>
	  <li id="f-delicious"><a href="http://del.icio.us/post" onclick="location.href='https://api.del.icio.us/v1/posts/add?description='+encodeURIComponent(document.title)+'&amp;url='+encodeURIComponent(location.href); return false;"><img src="http://images.wikia.com/common/OPmydel.gif" alt="delicious" /></a></li>
	</ul>
	<div id="f-hosting"><i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.</div>
<?php	}
}
