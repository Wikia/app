<?php
/**
 * Daddio skin. Skin for getting work done.
 * Based on Modern, modified by Rufus Post, Aaron Schulz
 *
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

global $IP;
// @todo Fixme: autoload ModernTemplate
require_once( "$IP/skins/Modern.php" );

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */
class SkinDaddio extends SkinTemplate {
	var $skinname = 'daddio', $stylename = 'daddio',
		$template = 'DaddioTemplate', $useHeadElement = true;

	function setupSkinUserCss( OutputPage $out ){
		global $wgScriptPath;

		$path = "{$wgScriptPath}/extensions/skins/Daddio";

		// Do not call parent::setupSkinUserCss(), we have our own print style
		$out->addStyle( 'common/shared.css', 'screen' );
		$out->addStyle( "$path/daddio/main.css", 'screen' );
		$out->addStyle( "$path/daddio/print.css", 'print' );
		$out->addStyle( "$path/daddio/rtl.css", 'screen', '', 'rtl' );
	}

}

/**
 * @todo document
 * @ingroup Skins
 */
class DaddioTemplate extends ModernTemplate {
	/**
	 * Template filter callback for Daddio skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		$this->skin = $skin = $this->data['skin'];
		
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->html( 'headelement' );

?>
	<!-- heading -->

	<div id="mw_main">
	<div id="mw_contentwrapper">
	<!-- navigation portlet -->
	<div class="portlet" id="p-cactions">
      <h5><?php $this->msg('views') ?></h5>
		<div class="pBody">
			<ul>
	<?php			foreach($this->data['content_actions'] as $key => $tab) { ?>
				 <li id="ca-<?php echo Sanitizer::escapeId($key) ?>"<?php
					 	if($tab['class']) { ?> class="<?php echo htmlspecialchars($tab['class']) ?>"<?php }
					 ?>><a href="<?php echo htmlspecialchars($tab['href']) ?>"<?php echo $skin->tooltipAndAccesskey('ca-'.$key) ?>><?php
					 echo htmlspecialchars($tab['text']) ?></a></li>
	<?php			 } ?>
			</ul>
		</div>
	</div>

	<!-- content -->
	<div id="mw_content">
	<!-- contentholder does nothing by default, but it allows users to style the text inside
	     the content area without affecting the meaning of 'em' in #mw_content, which is used
	     for the margins -->
	<div id="mw_contentholder">
		<div class='mw-topboxes'>
			<div id="mw-js-message" style="display:none;"></div>
			<div class="mw-topbox" id="siteSub"><?php $this->msg('tagline') ?></div>
			<?php if($this->data['newtalk'] ) {
				?><div class="usermessage mw-topbox"><?php $this->html('newtalk')  ?></div>
			<?php } ?>
			<?php if($this->data['sitenotice']) {
				?><div class="mw-topbox" id="siteNotice"><?php $this->html('sitenotice') ?></div>
			<?php } ?>
		</div>
		<div id="mw_header"><h1 id="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1></div>
		<div id="contentSub"><?php $this->html('subtitle') ?></div>

		<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
		<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>

		<?php $this->html('bodytext') ?>
		<div class='mw_clear'></div>
		<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
		<?php $this->html('dataAfterContent') ?>
	</div><!-- mw_contentholder -->
	</div><!-- mw_content -->
	</div><!-- mw_contentwrapper -->

	<div id="mw_portlets">

	<?php 
		$sidebar = $this->data['sidebar'];		
		if ( !isset( $sidebar['SEARCH'] ) ) $sidebar['SEARCH'] = true;
		if ( !isset( $sidebar['TOOLBOX'] ) ) $sidebar['TOOLBOX'] = true;
		if ( !isset( $sidebar['LANGUAGES'] ) ) $sidebar['LANGUAGES'] = true;

		foreach ($sidebar as $boxName => $cont) {
			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $cont );
			}
		}
	?>

	</div><!-- mw_portlets -->


	</div><!-- main -->

	<div class="mw_clear"></div>

	<!-- personal portlet -->
	<div class="portlet_top" id="p-personal">
		<h5><?php $this->msg('personaltools') ?></h5>
		<div class="pBody">
			<ul>
<?php 			foreach($this->data['personal_urls'] as $key => $item) { ?>
				<li id="pt-<?php echo Sanitizer::escapeId($key) ?>"<?php
					if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
				echo htmlspecialchars($item['href']) ?>"<?php echo $skin->tooltipAndAccesskey('pt-'.$key) ?><?php
				if(!empty($item['class'])) { ?> class="<?php
				echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
				echo htmlspecialchars($item['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div>

	<!-- bottom of page --> 
	<div id="mw_bottom">

	<!-- footer --> 
	<div id="footer">
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
		</ul>
	</div>

	<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>
-->
<?php endif; ?>
</div> <!-- bottom of page --> 
</body></html>
<?php
	wfRestoreWarnings();
	} // end of execute() method
} // end of class

