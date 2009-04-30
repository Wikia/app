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

class SkinLostbook extends SkinMonoBook {
	/** Using lostbook. */
	function initPage( &$out ) {
		parent::initPage( $out );
		$this->skinname  = 'lostbook';
		$this->stylename = 'lostbook';
		$this->template  = 'lostbookTemplate';

		// register hook to add "Digg This Story" button to toolbox portlet
		global $wgHooks;
		$wgHooks['MonoBookTemplateToolboxEnd'][] = array(&$this, addDiggButton);
	}

	function setupSkinUserCss( OutputPage $out ) {
		// Append to the default screen common & print styles...
		WikiaSkinMonobook::setupSkinUserCss( $out );

		$out->addStyle( 'lostbook/main.css', 'screen' );

		$out->addStyle( 'lostbook/IE50Fixes.css', 'screen', 'lt IE 5.5000' );
		$out->addStyle( 'lostbook/IE55Fixes.css', 'screen', 'IE 5.5000' );
		$out->addStyle( 'lostbook/IE60Fixes.css', 'screen', 'IE 6' );
		$out->addStyle( 'lostbook/IE70Fixes.css', 'screen', 'IE 7' );

		$out->addStyle( 'lostbook/rtl.css', 'screen', '', 'rtl' );
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
		$tpl->set('privacy', $this->privacyLink());
		$tpl->set('about', $this->aboutLink());
		$tpl->set('disclaimer', $this->disclaimerLink());

		wfProfileOut(__METHOD__);
		return true;
	}

	function addDiggButton($tpl) {
		if($tpl->data['notspecialpage']) { 
			global $wgTitle;
			$url = htmlspecialchars($wgTitle->getFullURL());
?>

					<li id="t-digglink"><a href="http://digg.com/submit?phase=2&amp;topic=television&amp;url=<?= $url ?>"><img src="http://digg.com/img/badges/91x17-digg-button-alt.png" width="91" height="17" alt="Digg!" /></a></li>
<?php
		}
		return true;
	}
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class lostbookTemplate extends MonoBookTemplate {

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
			if( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>				<li id="<?php echo$aLink?>"><?php $this->html($aLink) ?></li>
<?php 		}
		}
?>
<li id="footer-amung"><a href="http://whos.amung.us/show/mcrbmil5"><img src="http://whos.amung.us/swidget/mcrbmil5.gif" alt="tracker" width="80" height="15" border="0" /></a></li>
<li id="footer-coolness"><a href="http://www.coolness.com">Coolness Domains</a></li>
<li id="footer-logoby">Logo by Placid Azylum</li>
<li id="footer-cssby">CSS by jabberwock &amp; plkrtn</li>
			</ul>
<?php	}

}
