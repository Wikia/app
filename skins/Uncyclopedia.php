<?php
/**
 * MonoBook nouveau
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @todo document
 * @addtogroup Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

require_once('includes/SkinTemplate.php');
$wgValidSkinNames['uncyclopedia'] = 'Uncyclopedia default';
require "extensions/wikia/AnalyticsEngine/AnalyticsEngine.php";

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @addtogroup Skins
 */
class SkinUncyclopedia extends SkinTemplate {
	/** Using monobook. */
	function initPage( &$out ) {
		wfProfileIn( __METHOD__ );
		SkinTemplate::initPage( $out );
		$this->skinname  = 'uncyclopedia';
		$this->stylename = 'uncyclopedia';
		$this->template  = 'UncyclopediaTemplate';
 		wfProfileOut( __METHOD__ );
	}

	// macbre: serve powered by MW logo from images.wikia.com/common
	function getPoweredBy() {
		return '<a href="http://www.mediawiki.org/"><img alt="Powered by MediaWiki" src="http://images.wikia.com/common/skins/common/images/poweredby_mediawiki_88x31.png"/></a>';
	}
}

/**
 * @todo document
 * @addtogroup Skins
 */
class UncyclopediaTemplate extends QuickTemplate {

	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgUser;
		$skin = $wgUser->getSkin();

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

		<!-- YUI -->
		<script type="text/javascript" src="http://images.wikia.com/common/yui/utilities/utilities.js"></script>
		<script type="text/javascript" src="http://images.wikia.com/common/yui/container/container-min.js"></script>
		<script type="text/javascript" src="http://images.wikia.com/common/yui/autocomplete/autocomplete-min.js"></script>
		<script type="text/javascript" src="http://images.wikia.com/common/yui/logger/logger-min.js"></script>
		<script type="text/javascript" src="http://images.wikia.com/common/yui/3rdpart/yui-cookie.js"></script>
		<script type="text/javascript" src="http://images.wikia.com/common/yui/3rdpart/tools-min.js"></script>

		<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/yui/container/assets/container.css" />
		<link rel="stylesheet" type="text/css" href="http://images.wikia.com/common/yui/logger/assets/logger.css" />

		<style type="text/css" media="screen,projection">/*<![CDATA[*/ @import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/main.css?<?php echo $GLOBALS['wgStyleVersion'] ?>"; /*]]>*/</style>
		<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/common/commonPrint.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
		<link rel="stylesheet" type="text/css" media="handheld" href="<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/handheld.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
		<!--[if lt IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE50Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE55Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 6]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE60Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 7]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE70Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if lt IE 7]><script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
		<meta http-equiv="imagetoolbar" content="no" /><![endif]-->

		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>

		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/uncyclopedia/main.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikia YUI dialog js --></script>
<?php	if($this->data['jsvarurl'  ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss'   ]) { ?>
		<style type="text/css"><?php htmlentities($this->html('pagecss'   )) ?></style>
<?php	}
		if($this->data['usercss'   ]) { ?>
		<style type="text/css"><?php htmlentities($this->html('usercss'  )) ?></style>
<?php	}
		if($this->data['userjs'    ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
		if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
		if($this->data['trackbackhtml']) print $this->data['trackbackhtml']; ?>
		<!-- Head Scripts -->
<?php $this->html('headscripts') ?>
	</head>
<body <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>
<?php if($this->data['body_onload'    ]) { ?>onload="<?php     $this->text('body_onload')     ?>"<?php } ?>
 class="mediawiki <?php $this->text('nsclass') ?> <?php $this->text('dir') ?> <?php $this->text('pageclass') ?>">
	<div id="container"><div id="globalWrapper">
		<div id="column-content">
	<div id="content">
		<a name="top" id="top"></a>
		<?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
		<h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>
		<div id="bodyContent">
			<h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
			<div id="contentSub"><?php $this->html('subtitle') ?></div>
			<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
			<?php if($this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html('newtalk')  ?></div><?php } ?>
			<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
			<!-- start content -->
			<?php $this->html('bodytext') ?>
			<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
			<!-- end content -->
			<div class="visualClear"></div>
		</div>
	</div>
		</div>
		<div id="column-one">
	<div id="p-cactions" class="portlet">
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
	<div class="portlet" id="p-personal">
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
	<div class="portlet" id="p-logo">
		<a style="background-image: url(<?php $this->text('logopath') ?>);" <?php
			?>href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>"<?php
			echo $skin->tooltipAndAccesskey('n-mainpage') ?>></a>
	</div>
	<script type="<?php $this->text('jsmimetype') ?>"> if (window.isMSIE55) fixalpha(); </script>
	<?php foreach ($this->data['sidebar'] as $bar => $cont) { ?>
	<div class='portlet' id='p-<?php echo Sanitizer::escapeId($bar) ?>'<?php echo $skin->tooltip('p-'.$bar) ?>>
		<h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
		<div class='pBody'>
			<ul>
<?php 			foreach($cont as $key => $val) { ?>
				<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
					if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"<?php echo $skin->tooltipAndAccesskey($val['id']) ?>><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div>
	<?php } ?>
	<div id="p-search" class="portlet">
		<h5><label for="searchInput"><?php $this->msg('search') ?></label></h5>
		<div id="searchBody" class="pBody">
			<form action="<?php $this->text('searchaction') ?>" id="searchform"><div>
				<input id="searchInput" name="search" type="text"<?php echo $skin->tooltipAndAccesskey('search');
					if( isset( $this->data['search'] ) ) {
						?> value="<?php $this->text('search') ?>"<?php } ?> />
				<input type='submit' name="go" class="searchButton" id="searchGoButton"	value="<?php $this->msg('searcharticle') ?>" />&nbsp;
				<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton') ?>" />
			</div></form>
		</div>
	</div>
	<div class="portlet" id="p-tb">
		<h5><?php $this->msg('toolbox') ?></h5>
		<div class="pBody">
			<ul>
<?php
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"<?php echo $skin->tooltipAndAccesskey('t-whatlinkshere') ?>><?php $this->msg('whatlinkshere') ?></a></li>
<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"<?php echo $skin->tooltipAndAccesskey('t-recentchangeslinked') ?>><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 		}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"<?php echo $skin->tooltipAndAccesskey('t-trackbacklink') ?>><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
		if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
					?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
					echo htmlspecialchars($feed['href']) ?>"<?php echo $skin->tooltipAndAccesskey('feed-'.$key) ?>><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
					<?php } ?></li><?php
		}

		foreach( array('contributions', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) {
				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"<?php echo $skin->tooltipAndAccesskey('t-'.$special) ?>><?php $this->msg($special) ?></a></li>
<?php		}
		}

		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>"<?php echo $skin->tooltipAndAccesskey('t-print') ?>><?php $this->msg('printableversion') ?></a></li><?php
		}

		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"<?php echo $skin->tooltipAndAccesskey('t-permalink') ?>><?php $this->msg('permalink') ?></a></li><?php
		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"<?php echo $skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
		}

		wfRunHooks( 'MonoBookTemplateToolboxEnd', array( &$this ) );
?>
			</ul>
		</div>
	</div>
<?php
		if( $this->data['language_urls'] ) { ?>
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
<?php	} ?>

<!-- PATCH: Begin addons -->

	<div id="projects" class="portlet">
	<h5>projects</h5>
	<div class ="pBody"> <a href ="http://stillwatersca.blogspot.com/">
	<img src="<?php $this->text('stylepath') ?>/uncyclopedia/stillwaters-button.png" alt="Stillwaters" width="80" height="15" /></a><a href="http://www.chronarion.org/"><img src="<?php $this->text('stylepath') ?>/uncyclopedia/chronarionbutton.png" alt="chronarion.org" width="80" height="15" /></a>
	</div>
	</div>

	<?php
	AdEngine::getInstance()->setLoadType('inline');
	echo AdEngine::getInstance()->getSetupHtml();
    	echo AdEngine::getInstance()->getAd('LEFT_SPOTLIGHT_2');
	?>


<!-- END addons -->


		</div><!-- end of the left (by default at least) column -->
			<div class="visualClear"></div>
            <div id="footer" style="font-size:75%"><?php /* macbre: making skin to validate as xHTML1.0 caused font in footer to grow */ ?>
<?php
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
   </div>

   <script type="text/javascript"><!--
	    document.getElementById('digg-icon').src = "http://images.wikia.com/common/91x17-digg-button.png?js=1";
	    //--></script>

    <?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>

<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>

-->
<?php endif;
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
echo AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory());
echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);
?>
</div><!-- end of globalWrapper -->
</div><!-- end of container -->

</body></html>
<?php
    wfRestoreWarnings();
    } // end of execute() method
} // end of class
?>
