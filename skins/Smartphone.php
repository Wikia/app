<?php
/**
 * See docs/skin.txt
 *
 * @todo document
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/** */
//require_once( dirname(__FILE__) . '/MonoBook.php' );

/**
 * @todo document
 * @ingroup Skins
 */
class SkinSmartphone extends SkinTemplate {
	function initPage( OutputPage $out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'smartphone';
		$this->stylename = 'smartphone';
		$this->template  = 'SmartphoneTemplate';
	}

	function setupSkinUserCss( OutputPage $out ){
		parent::setupSkinUserCss( $out );
		$out->addMeta("viewport", "width=device-width");
		// Append to the default screen common & print styles...
		// TODO: does this actually do anything?
		$out->addStyle( 'wikiaphone/main.css', 'screen,handheld' );

		$out->addScript(AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW));
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory()));
		global $wgCityId;
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId)));
		$out->addScript(AnalyticsEngine::track('GA_Urchin', 'pagetime', array('lean_monaco')));
		// TODO: does this actually do anything?
		$out->addScriptFile( '../wikiaphone/main.js' );
	}

	function printTopHtml() {
	  echo AdEngine::getInstance()->getAd('MOBILE_TOP_LEADERBOARD');
	}
}

class SmartphoneTemplate extends QuickTemplate {

	var $skin;

	function wideSkyscraper() {
		global $wgDBname;
		$wideSkyscraperWikis = array('yugioh', 'transformers', 'swg', 'paragon');
		if (in_array($wgDBname, $wideSkyscraperWikis)) {
			echo ' style="margin-right: 165px;"';
		}
	}

	function isSkyscraper() {
		global $wgDBname, $wgEnableAdsInContent;
		$noSkyscraperWikis = array('espokemon');
		if (in_array($wgDBname, $noSkyscraperWikis) && $wgEnableAdsInContent) {
			return true;
		}
		else {
			return false;
		}
	}

	function noSkyscraper() {
		if ( $this->isSkyscraper() ) {
                        echo ' style="margin-right: 0px;"';
                }
        }

	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgRequest;
		$this->skin = $skin = $this->data['skin'];
		$action = $wgRequest->getText( 'action' );

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php $this->text('xhtmldefaultnamespace') ?>" <?php
	foreach($this->data['xhtmlnamespaces'] as $tag => $ns) {
		?>xmlns:<?php echo "{$tag}=\"{$ns}\" ";
	} ?>xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>
		<?php# $this->html('csslinks') ?>
<!--
		<link rel="stylesheet" href="<?php $this->text('stylepath') ?>/smartphone/test.css" />
		
-->
		<link rel="stylesheet" href="<?= wfGetSassUrl("skins/oasis/css/mobile.scss") ?>">
		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

		<?php $this->html('wikia_headscripts'); ?>

		<!-- Head Scripts -->
<?php $this->html('headscripts') ?>
<?php	if($this->data['jsvarurl']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl') ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss']) { ?>
		<style type="text/css"><?php $this->html('pagecss') ?></style>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
	</head>
<?php
	global $wgTitle;
	if (Title::newMainPage()->getArticleId() == $wgTitle->getArticleId()) {
		$isMainpage = ' mainpage';
	} else {
		$isMainpage = null;
	}
?>
<body<?php if($this->data['body_onload']) { ?> onload="<?php $this->text('body_onload') ?>"<?php } ?>
 class="mediawiki <?php $this->text('dir') ?> <?php $this->text('pageclass') ?> <?php $this->text('skinnameclass') ?> wikiaSkinSmartphone<?=$isMainpage?>">
<?php $this->navbar(); ?>
	<div id="globalWrapper">
	<div id="column-content">
	<!--printTopHtml -->
		<?php /* Allow for sub classes to print content here */
		method_exists($this->skin, "printTopHtml") && $this->skin->printTopHtml(); ?>
	<!--printTopHtml -->
  <div id="mobileHeader">
    <div class="logo"><a href="#"><img src="<?php $this->text('stylepath') ?>/smartphone/wikialogo.jpg" alt="Wikia" /></a></div>
    <div class="buttons">
      <form method="get" action="index.php?title=Special:Search" class="WikiaSearch" id="WikiaSearch">
      	<input type="text" accesskey="f" autocomplete="off" placeholder="Search this wiki" name="search" class="placeholder">
      	<input type="hidden" value="0" name="fulltext">
      	<input type="submit">
      	<button class="wikia-chiclet-button"><img src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif"></button>
      </form>
    	<a data-id="randompage" class="wikia-button secondary" accesskey="x" title="Special:Random" href="/wiki/Special:Random"><img src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif">Random Page</a>
    </div>
  </div>
  
	<div id="content" class="content-ads"<?php $this->wideSkyscraper();?><?php $this->noSkyscraper();?>>
		<a name="top" id="top"></a>
		<h1 id="siteSub"><a href="/"><?php $this->msg('tagline') ?></a></h3>
		<h1 id="firstHeading" class="firstHeading"><?php $this->text('title') ?></h1>
		
		<!--contextual_targeting_start-->
		<!--google_ad_section_start-->

		<div id="bodyContent">
			<h2 id="siteSub"><?php $this->html('subtitle') ?></h2>
			<!-- start content -->
			<?php $this->html('bodytext') ?>
			<h2><span class="mw-headline">Static Content Starts Here</span><span class="moreless"><a class="wikia-button secondary" href="#">Show more</a></span></h2>
			<p>Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text Text</p>
			<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
			<!-- end content -->
			<?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>
			<div class="visualClear"></div>
		</div>

		<!--google_ad_section_end-->
		<!--contextual_targeting_end-->
	</div>
  </div>
	<div id="column-one">
	  <h2 class="related-heading">Related Pages</h2>
	  <p><a href="#">Page One</a>, <a href="#">Page Two</a>, <a href="#">Page Three</a>, <a href="#">Page Four</a></p>
	  <p><a href="#">Wiki Activity</a></p>
	</div><!-- end of the left (by default at least) column -->
</div><!-- macbre: fixes strange footer bug in IE6 (#2068) -->
<div class="visualClear"></div>
		<?php
    // macbre: google adsense column

if ( !$this->isSkyscraper() ) {
    $this->html('ads_columngoogle');
}
?>
<div id="footer">
  <p><a href="#">About Us</a>  |  <a href="#">Contact</a>  |  </li>
    <a href="#">Terms of Use</a>  |  <a href="#">Privacy</a></p>
</div>
<?php $this->html('ads_bottomjs'); ?>
<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>

-->
<?php endif; ?>
</body></html>
<?php
	wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/
	function searchBox() {
		global $wgUseTwoButtonsSearchForm;
?>
	<div id="p-search" class="portlet">
		<h5><label for="searchInput"><?php $this->msg('search') ?></label></h5>
		<div id="searchBody" class="pBody">
			<form action="<?php $this->text('wgScript') ?>" id="searchform"><div>
				<input type='hidden' name="title" value="<?php $this->text('searchtitle') ?>"/>
				<input id="searchInput" name="search" type="text"<?php echo $this->skin->tooltipAndAccesskey('search');
					if( isset( $this->data['search'] ) ) {
						?> value="<?php $this->text('search') ?>"<?php } ?> />
				<input type='submit' name="go" class="searchButton" id="searchGoButton"	value="<?php $this->msg('searcharticle') ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-go' ); ?> /><?php if ($wgUseTwoButtonsSearchForm) { ?>&nbsp;
				<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>"<?php echo $this->skin->tooltipAndAccesskey( 'search-fulltext' ); ?> /><?php } else { ?>

				<div><a href="<?php $this->text('searchaction') ?>" rel="search"><?php $this->msg('powersearch-legend') ?></a></div><?php } ?>

			</div></form>
		</div>
	</div>
<?php
	}

	/*************************************************************************************************/
	function toolbox() {
?>
	<div class="portlet" id="p-tb">
		<h5><?php $this->msg('toolbox') ?></h5>
		<div class="pBody">
			<ul>
<?php
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-whatlinkshere') ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-recentchangeslinked') ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 		}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-trackbacklink') ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
		if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
					?><a id="<?php echo Sanitizer::escapeId( "feed-$key" ) ?>" href="<?php
					echo htmlspecialchars($feed['href']) ?>" rel="alternate" type="application/<?php echo $key ?>+xml" class="feedlink"<?php echo $this->skin->tooltipAndAccesskey('feed-'.$key) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;
					<?php } ?></li><?php
		}

		foreach( array('contributions', 'log', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) {
				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-'.$special) ?>><?php $this->msg($special) ?></a></li>
<?php		}
		}

		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>" rel="alternate"<?php echo $this->skin->tooltipAndAccesskey('t-print') ?>><?php $this->msg('printableversion') ?></a></li><?php
		}

		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"<?php echo $this->skin->tooltipAndAccesskey('t-permalink') ?>><?php $this->msg('permalink') ?></a></li><?php
		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"<?php echo $this->skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
		}

		wfRunHooks( 'MonoBookTemplateToolboxEnd', array( &$this ) );
		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
?>
			</ul>
		</div>
	</div>

<?php

    // wikia toolbox addon
    $this->html('wikia_toolbox');

?>

<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if( $this->data['language_urls'] ) {
?>
	<div id="p-lang" class="portlet">
		<h5><?php $this->msg('otherlanguages') ?></h5>
		<div class="pBody">
			<ul>
<?php		foreach($this->data['language_urls'] as $langlink) { ?>
				<li class="<?php echo htmlspecialchars($langlink['class'])?>"><?php
				?><a href="<?php echo htmlspecialchars($langlink['href']) ?>"><?php echo $langlink['text'] ?></a></li>
<?php		} ?>
			</ul>
		</div>
	</div>
<?php
		}
	}

	/*************************************************************************************************/
	function customBox( $bar, $cont ) {
?>
	<div class='generated-sidebar portlet' id='<?php echo Sanitizer::escapeId( "p-$bar" ) ?>'<?php echo $this->skin->tooltip('p-'.$bar) ?>>
		<h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
		<div class='pBody'>
<?php   if ( is_array( $cont ) ) { ?>
			<ul>
<?php 			foreach($cont as $key => $val) { ?>
				<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
					if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $this->skin->tooltipAndAccesskey($val['id']) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php			} ?>
			</ul>
<?php   } else {
			# allow raw HTML block to be defined by extensions
			print $cont;
		}
?>
		</div>
	</div>
<?php
	}

	/*************************************************************************************************/
	function navbar() {}

} // end of class
