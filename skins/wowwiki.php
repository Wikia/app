<?php
/**
 * MonoBook nouveau
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
 *
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */

if( !defined( 'MEDIAWIKI' ) )
	die( -1 );

/** */
require_once('includes/SkinTemplate.php');

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class SkinWowwiki extends SkinTemplate {
	/** Using monobook. */
	function initPage( &$out ) {
		SkinTemplate::initPage( $out );
		$this->skinname  = 'wowwiki';
		$this->stylename = 'wowwiki';
		$this->template  = 'WowWikiTemplate';
	}
}

/**
 * @todo document
 * @package MediaWiki
 * @subpackage Skins
 */
class WowWikiTemplate extends QuickTemplate {
	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgTitle, $wgShowAds, $wgUseAdServer, $wgCurse, $wgMemc;
		$this->set('adserver_ads', $wgShowAds && $wgUseAdServer);

		$wf_did_adsense = false;

		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php $this->text('lang') ?>" lang="<?php $this->text('lang') ?>" dir="<?php $this->text('dir') ?>">
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>
		<style type="text/css" media="screen,projection">/*<![CDATA[*/ @import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/main.css?<?php echo $GLOBALS['wgStyleVersion'] ?>"; /*]]>*/</style>
		<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/common/commonPrint.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" />
		<!--[if lt IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE50Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE55Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 6]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE60Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 7]><style type="text/css">@import "<?php $this->text('stylepath') ?>/<?php $this->text('stylename') ?>/IE70Fixes.css?<?php echo $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if lt IE 7]><script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"></script>
		<meta http-equiv="imagetoolbar" content="no" /><![endif]-->

		<?php print Skin::makeGlobalVariablesScript( $this->data ); ?>

		<?php if( !empty( $wgCurse ) ) { ?>
		<link rel="stylesheet" href="<?php $this->text('stylepath') ?>/wowwiki/curse.css?<?php echo $GLOBALS['wgStyleVersion'] ?>" type="text/css" />
		<?php } ?>

		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('stylepath' ) ?>/common/wikibits.js?<?php echo $GLOBALS['wgStyleVersion'] ?>"><!-- wikibits js --></script>
<?php	if($this->data['jsvarurl'  ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss'   ]) { ?>
		<style type="text/css"><?php $this->html('pagecss'   ) ?></style>
<?php	}
		if($this->data['usercss'   ]) { ?>
		<style type="text/css"><?php $this->html('usercss'   ) ?></style>
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
 class="<?php $this->text('nsclass') ?> <?php $this->text('dir') ?>">
	<?php if( !empty( $wgCurse ) ) $this->printCustomHeader(); ?>
	<div id="globalWrapper">
		<div id="column-content">
	<div id="content">
		<a name="top" id="top"></a>
		<?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
		<h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->text('title'):$this->html('title') ?></h1>
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
		<ul>
<?php			foreach($this->data['content_actions'] as $key => $tab) { ?>
				 <li id="ca-<?php echo htmlspecialchars($key) ?>"<?php
				 	if($tab['class']) { ?> class="<?php echo htmlspecialchars($tab['class']) ?>"<?php }
				 ?>><a href="<?php echo htmlspecialchars($tab['href']) ?>"><?php
				 echo htmlspecialchars($tab['text']) ?></a></li>
<?php			 } ?>
		</ul>
	</div>
	<div class="portlet" id="p-personal">
		<h5><?php $this->msg('personaltools') ?></h5>
		<div class="pBody">
			<ul>
<?php 			foreach($this->data['personal_urls'] as $key => $item) { ?>
				<li id="pt-<?php echo htmlspecialchars($key) ?>"<?php
					if ($item['active']) { ?> class="active"<?php } ?>><a href="<?php
				echo htmlspecialchars($item['href']) ?>"<?php
				if(!empty($item['class'])) { ?> class="<?php
				echo htmlspecialchars($item['class']) ?>"<?php } ?>><?php
				echo htmlspecialchars($item['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div>
	<div class="portlet" id="p-logo">
		<a style="background-image: url(<?php $this->text('logopath') ?>);" <?php
			?>href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>" <?php
			?>title="<?php $this->msg('mainpage') ?>"></a>
	</div>
	<script type="<?php $this->text('jsmimetype') ?>"> if (window.isMSIE55) fixalpha(); </script>
	<?php foreach ($this->data['sidebar'] as $bar => $cont) { ?>
	<div class='portlet' id='p-<?php echo htmlspecialchars($bar) ?>'>
		<h5><?php $out = wfMsg( $bar ); if (wfEmptyMsg($bar, $out)) echo $bar; else echo $out; ?></h5>
		<div class='pBody'>
			<ul>
<?php 			foreach($cont as $key => $val) { ?>
				<li id="<?php echo htmlspecialchars($val['id']) ?>"<?php
					if ( $val['active'] ) { ?> class="active" <?php }
				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"><?php echo htmlspecialchars($val['text']) ?></a></li>
<?php			} ?>
			</ul>
		</div>
	</div>
	<?php if ($bar == "navigation") { ?>
	<?php if ( $this->data['adserver_ads'] ) { ?>
	<div class="portlet" id="ads_topleft">
	<h5>Google Ads</h5>
	<div class="pBody" style="background: #333333; border: none; padding: 0px 10px 0px 13px;">
	<?= AdServer::getInstance()->getAd('tl') ?>
	</div></div>
	<?php } ?>
	<?php } ?>
	<?php } ?>
	<div id="p-search" class="portlet">
		<h5><label for="searchInput"><?php $this->msg('search') ?></label></h5>
		<?php print google_sitesearch(); ?>
	</div>
	<div class="portlet" id="p-tb">
		<h5><?php $this->msg('toolbox') ?></h5>
		<div class="pBody">
			<ul>
<?php
		if($this->data['notspecialpage']) { ?>
				<li id="t-whatlinkshere"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
				?>"><?php $this->msg('whatlinkshere') ?></a></li>
<?php
			if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
				<li id="t-recentchangeslinked"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
				?>"><?php $this->msg('recentchangeslinked') ?></a></li>
<?php 		}
		}
		if(isset($this->data['nav_urls']['trackbacklink'])) { ?>
			<li id="t-trackbacklink"><a href="<?php
				echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
				?>"><?php $this->msg('trackbacklink') ?></a></li>
<?php 	}
		if($this->data['feeds']) { ?>
			<li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
					?><span id="feed-<?php echo htmlspecialchars($key) ?>"><a href="<?php
					echo htmlspecialchars($feed['href']) ?>"><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
					<?php } ?></li><?php
		}

		foreach( array('contributions', 'blockip', 'emailuser', 'upload', 'specialpages') as $special ) {

			if($this->data['nav_urls'][$special]) {
				?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
				?>"><?php $this->msg($special) ?></a></li>
<?php		}
		}

		if(!empty($this->data['nav_urls']['print']['href'])) { ?>
				<li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
				?>"><?php $this->msg('printableversion') ?></a></li><?php
		}

		if(!empty($this->data['nav_urls']['permalink']['href'])) { ?>
				<li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
				?>"><?php $this->msg('permalink') ?></a></li><?php
		} elseif ($this->data['nav_urls']['permalink']['href'] === '') { ?>
				<li id="t-ispermalink"><?php $this->msg('permalink') ?></li><?php
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
	<?php if ( $this->data['adserver_ads'] ) { ?>
	<div class='portlet' id='ads-left'>
	<div class="pBody" style="background: #333333; border: none; padding: 0px 10px 0px 13px;">
	<?= AdServer::getInstance()->getAd('l') ?>
	</div></div>
	<div class='portlet' id='ads-botleft'>
	<?= AdServer::getInstance()->getAd('bl') ?>
	</div>
	<?php } ?>
		</div><!-- end of the left (by default at least) column -->
			<div class="visualClear"></div>
			<div id="footer">
<?php
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
		</div>
	<script type="text/javascript"> if (window.runOnloadHook) runOnloadHook();</script>
</div>
<?php $this->html('reporttime') ?>

<?php
print google_urchin();

if ( $this->data['adserver_ads'] ) {
	echo "\n<!-- js_bot1 start -->" . AdServer::getInstance()->getAd('js_bot1') . "<!-- js_bot1 end -->";
	echo "\n<!-- js_bot2 start -->" . AdServer::getInstance()->getAd('js_bot2') . "<!-- js_bot2 end -->";
	echo "\n<!-- js_bot3 start -->" . AdServer::getInstance()->getAd('js_bot3') . "<!-- js_bot3 end -->";
}
?>
<?php if( !empty( $wgCurse ) ) $this->printCustomFooter(); ?>
</body></html>
<?php
	wfRestoreWarnings();
	} // end of execute() method

	function printCustomHeader()
	{
?>
		<div id="header">
		<div id="hticker">
			<ul id="hlinks">
				<li class=""><a href="http://news.curse.com/">News</a></li>
				<li><a href="http://forums.curse.com/">Forums</a></li>
				<li><a href="http://downloads.curse.com/">Downloads</a></li>
				<li><a href="http://blogs.curse.com/">Blogs</a></li>
				<li><a href="http://videos.curse.com/">Videos</a></li>

				<li><a href="http://images.curse.com/">Images</a></li>
			</ul><!-- end links -->
	   		<ul id="htabs">
				<li class="active"><a href="http://www.curse.com">Home</a></li>
				<li class="dropdown"><a href="http://my.curse.com">My Curse <span class="inline"><div class="icon icon_dropdown"><!--More--></div></span></a></li>
				<li class="dropdown"><a href="http://www.curse.com/set-portal/">Portals<span class="inline"><div class="icon icon_dropdown"><!--More--></div></span></a><ul>
						<li><a href="http://aoc.curse.com/">Age of Conan</a></li>
						<li><a href="http://df.curse.com/">Darkfall Online</a></li>
						<li><a href="http://gw.curse.com/">Guild Wars</a></li>
						<li><a href="http://lotro.curse.com/">Lord of the Rings Online</a></li>
						<li><a href="http://sc2.curse.com/">Starcraft 2</a></li>
						<li><a href="http://tr.curse.com/">Tabula Rasa</a></li>
						<li><a href="http://uo.curse.com/">Ultima Online</a></li>
						<li><a href="http://vg.curse.com/">Vanguard</a></li>
						<li><a href="http://war.curse.com/">Warhammer Online</a></li>
						<li><a href="http://wow.curse.com/">World of Warcraft</a></li>
				</ul></li>
			</ul><!-- end tabs -->
		</div><!-- end ticker -->
		<div id="hmain">
			<div id="hlogo"><a href="http://www.curse.com/">Logo</a></div>
			<div id="hsearch">
				<form style="margin: 0pt; padding: 0pt;" action="http://search.curse.com/" method="get">
				<label for="id_gsearch">Search:</label> <input type="text" class="vTextInput ac_input" name="q" id="id_gsearch" autocomplete="off"/>  <input type="submit" class="vSubmitInput" value="Go"/>
				</form>
			</div>
		</div><!-- end main -->
	</div>
<?php
	}


	function printCustomFooter()
	{
?>
		<div id="footerCurse">
<!-- Footer -->
	<p>
	<a href="http://corp.curse.com/terms-of-use/">Terms of Use</a> | <a href="http://corp.curse.com/privacy-policy/">Privacy Policy</a> | <a href="http://corp.curse.com/technology/">Technology</a>
	</p>
	<p>Copyright &copy; 2007 <a href="http://corp.curse.com">Curse, Inc.</a></p>

<!-- End Footer --></div>
<!-- X-Forwarded-For: <?= $_SERVER["HTTP_X_FORWARDED_FOR"] ?> -->
<?php
	}
} // end of class


/* google bits */
function google_adsense($which) {
  $ch = '7089763643'; /* anon */
  global $wgUser;
  if ($wgUser->isLoggedIn()) {
    $ch = '1459374554';
  }

  if ($which == 1) {
    return '<div class="portlet">
<h5>Google Ads</h5>
<div class="pBody" style="background: #333333; border: none; padding: 0px 10px 0px 13px;">
<script type="text/javascript"><!--
google_ad_client = "pub-4086838842346968";
google_ad_width = 120;
google_ad_height = 240;
google_ad_format = "120x240_as";
google_ad_type = "text";
google_ad_channel ="' . $ch . '";
google_color_border = "003366";
google_color_bg = "333333";
google_color_link = "FFFFFF";
google_color_url = "FFE600";
google_color_text = "FFE600";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div></div>';
  } elseif ($which == 2) {
   return '<div class="portlet">
<div class="pBody" style="background: #333333; border: none; padding: 0px 10px 0px 13px;">
<script type="text/javascript"><!--
google_ad_client = "pub-4086838842346968";
google_ad_width = 120;
google_ad_height = 90;
google_ad_format = "120x90_0ads_al";
google_ad_channel ="' . $ch . '";
google_color_border = "003366";
google_color_bg = "333333";
google_color_link = "FFFFFF";
google_color_url = "FFE600";
google_color_text = "FFE600";
//--></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</center>
</div></div>';
  }
}

function google_sitesearch() {
  $ch = '6987656965'; /* anon */
  global $wgUser;
  if ($wgUser->isLoggedIn()) {
    $ch = '9345733685';
  }

return '<!-- SiteSearch Google -->
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
<!-- SiteSearch Google -->';
}

function google_urchin() {
   return '<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script><script type="text/javascript">_uacct = "UA-288915-4"; urchinTracker();</script>';
}

