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
	/**
	 * Using monobook.
	 *
	 * @param OutputPage $out
	 */
	function initPage( OutputPage $out ) {
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

	// add credit buttons (instead of wikia messsages)
	function wikiaBox() {
		global $wgStylePath;

		$html = <<<HTML
	<div id="projects" class="portlet">
		<h5>projects</h5>
		<div class="pBody">
			<a href="http://stillwatersca.blogspot.com/">
				<img src="$wgStylePath/uncyclopedia/stillwaters-button.png" alt="Stillwaters" width="80" height="15" />
			</a>
			<a href="http://www.chronarion.org/">
				<img src="$wgStylePath/uncyclopedia/chronarionbutton.png" alt="chronarion.org" width="80" height="15" />
			</a>
		</div>
	</div>
HTML;

		echo $html;
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
	</ul>
	<div id="f-hosting"><i>Wikia</i>&reg; is a registered service mark of Wikia, Inc. All rights reserved.</div>

	<!-- RT #79534 -->
	<script type="text/javascript">/*<![CDATA[*/Wikia.LazyQueue.makeQueue(wgAfterContentAndJS, function(fn) {fn();}); wgAfterContentAndJS.start();}/*]]>*/</script>
<?php	}
}
