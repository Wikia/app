<?php
if (!defined('MEDIAWIKI')) die();
/**
 * QuartzSlate skin
 *
 * @package MediaWiki
 * @subpackage Skins
 *
 * @author Maciej Brencz <macbre@wikia.com>
 * @author Inez Korczynski <inez@wikia.com>
 * @author Tomasz Klim <tomek@wikia.com>
 * @copyright Copyright (C) Wikia Inc. 2007
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
global $IP;
require_once("$IP/includes/SkinTemplate.php");
require_once("$IP/extensions/wikia/AnalyticsEngine/AnalyticsEngine.php");

define('STAR_RATINGS_WIDTH_MULTIPLIER', 17);

class SkinQuartz extends SkinTemplate {

	var $themename;

	function initPage( &$out ) {

		wfProfileIn( __METHOD__ );

		SkinTemplate::initPage( $out );
		$this->skinname  = 'quartz';
		$this->stylename = 'quartz';
		$this->template  = 'QuartzTemplate';

 		wfProfileOut( __METHOD__ );
	}

	function &setupTemplate( $classname, $repository = false, $cache_dir = false ) {
		$tpl = new $classname();

		if(empty($this->themename)) {
			global $wgSkinTheme;
			if(empty($wgSkinTheme)) {
				$this->themename = 'sapphire';
			} else {
				$this->themename = $wgSkinTheme['quartz'][0];
			}
		}

		$tpl->themename = $this->themename;
		return $tpl;
	}
}


class QuartzTemplate extends QuickTemplate {

	var $themename;

	var $abmode = -1;

	function getLoginLogoutUserMenu($left = true, $buttons = true) {
		$o = '<ul id="welcome" style="'.($left ? 'left' : 'right').': 10px">';
		if(!$this->data['loggedin']) {
			$o .= '<li style="background: none;">';
			if($buttons == true) {
				$o .= '<div class="smallGreenButton"><div class="left">';
			}
			$o .= '<a href="' . htmlentities( empty( $this->data['personal_urls']['login'] ) ? $this->data['personal_urls']['anonlogin']['href'] : $this->data['personal_urls']['login']['href'] ) . '" id="login">' . wfMsgExt('login', array('parseinline')) . '</a>';
			if($buttons == true) {
				$o .= '</div><div class="right"></div></div>';
			}
			$o .= '</li>';
			$o .= '<li style="background: none;">' . wfMsg('or') . '</li>';
			$o .= '<li style="background: none;">';
			if($buttons == true) {
				$o .= '<div class="smallGreenButton"><div class="left">';
			}
			$o .= '<a href="' . htmlentities( Skin::makeSpecialUrl( 'Userlogin', "type=signup" )) . '" id="register">' . wfMsg('create_an_account') . '</a>';
			if($buttons == true) {
				$o .= '</div><div class="right"></div></div>';
			}
			$o .= '</li>';
		} else {
			global $wgUser;

			$skin = $wgUser->getSkin();

			$o .= '<li style="background: none;">' . trim(wfMsgExt('login_greeting', array('parseinline'), $wgUser->getName())) . '</li>';
			$o .= '<li class="user" id="userMenuToggle">';
			$o .= $wgUser->getName();
			$o .= '<div id="userMenuMain" class="yuimenu bd" style="visibility: hidden">';
			$o .= '<div id="userMenu" class="bd">';
			$o .= '<ul style="list-style-type: none; margin-left: 0px">';
			$userMenuLinks = $this->data['personal_urls'];
			unset( $userMenuLinks['logout'], $userMenuLinks['login']);
			if(!empty($userMenuLinks['userpage'])) {
				$userMenuLinks['userpage']['text'] = wfMsg('tooltip-pt-userpage');
			}
			$userMenuLinks['cockpit_show'] = array('text' => wfMsg('manage_widgets'), 'href' => '');
			foreach($userMenuLinks as $linkkey => $linkval) {
				$o .= '<li><a id="um-'. $linkkey .'" href="' . htmlentities($linkval['href']) . '" ' . $skin->tooltipAndAccesskey('pt-'.$linkkey) . '>' . $linkval['text'] . '</a></li>';
			}
			$o .= '</ul></div></div></li><li style="background: none;"> - <span>[</span><a id="logout" href="' . htmlspecialchars( $this->data['personal_urls']['logout']['href'] ) . '" '. $skin->tooltipAndAccesskey('pt-logout') .'>' . htmlspecialchars( $this->data['personal_urls']['logout']['text'] ) . '</a><span>]</span></li>';
		}
		$o .= '</ul>';
		return $o;
	}

	function getBreadCrumbs($absolute = false) {
		global $wgEnableBreadCrumb, $wgLang;
		if($wgEnableBreadCrumb == true) {
  			$breadCrumbs = wfGetBreadCrumb();
			if(!empty($breadCrumbs)) {
				$o = '<ul id="breadCrumb"'.($absolute == true ? ' style="position: absolute;"' : '').'>';
    				foreach($breadCrumbs as $key => $val) {
					$o .= '<li><a href="' . htmlspecialchars($val['url']) . '">' . htmlspecialchars($val['name']) . '</a>' . ($key+1 < count($breadCrumbs) ? ' &raquo; ' : '') . '</li>';
				}
				$o .= '</ul>';
				return $o;
			}
		}
		return '';
	}

	function getLeftTopBar() {
		if($this->abmode == 1) {
			return $this->getLoginLogoutUserMenu(false) . $this->getBreadCrumbs(true) ;
		} else if($this->abmode == 2) {
			return $this->getLoginLogoutUserMenu(true, true);
		}
		//if($this->abmode == -1) {
			return $this->getLoginLogoutUserMenu();
		//}
	}

	function getRightTopBar() {
		if($this->abmode == 1) {
			return '';
		} else if($this->abmode == 2) {
			return $this->getBreadCrumbs();
		}
		//if($this->abmode == -1) {
			return $this->getBreadCrumbs();
		//}
	}

	function getLangBarData() {
		global $wgContLang, $wgLanguageCode;

		//return array( 'Polish', array('en' => array('href'=>'en', 'text'=>'English'), 'de' => array('href'=>'de','text'=>'Deutsch') ) ); // macbre: for testing only!

		return array( $wgContLang->getLanguageName($wgLanguageCode), $this->data['language_urls'] );
	}

	function getNavLinks() {
		wfProfileIn( __METHOD__ );

		$navlinks_temp = GetLinksArrayFromMessage('navlinks');

		$navlinks = array();

		if(!empty($navlinks_temp[1])) {
			$navlinks[1] = array_slice($navlinks_temp[1], 0, 4);
		}

		if(!empty($navlinks_temp[2])) {
			$navlinks[2] = array_slice($navlinks_temp[2], 0, 4);
		}

		wfProfileOut( __METHOD__ );
		return $navlinks;
	}

	function getAds($pos) {
		global $wgNoWideAd, $wgUser, $wgForceSkin;
		switch( $pos ) {
			case 'tr':
				if($wgUser->isLoggedIn() || $wgNoWideAd) {

					$spots = '';

					$ad = AdEngine::getInstance()->getAd('RIGHT_SPOTLIGHT_1');

					if( !empty( $ad ) ) {
						$spots .= "\n\t".'<div id="spotlight-1">'.$ad.'</div>'."\n";
					}

					$ad = AdEngine::getInstance()->getAd('RIGHT_SPOTLIGHT_2');

					if( !empty( $ad ) ) {
						$spots .= "\n\t".'<div id="spotlight-2">'.$ad.'</div>'."\n";
					}

					// macbre: return spotlights container only if we have spotlights
					return (!empty($spots) ? '<div id="spotlights" class="clearfix">'.$spots.'</div>' : '');
				}
				else
				{
					return AdEngine::getInstance()->getAd('TOP_RIGHT_BOXAD');
				}


			case 'br':
				if($wgUser->isLoggedIn() || $wgNoWideAd) {
					// Display nothing, they already saw the spotlights at the top
				} else {
					$ad = AdEngine::getInstance()->getAd('RIGHT_SPOTLIGHT_1');

					if( !empty( $ad ) ) {
						$spots .= "\n\t".'<div id="spotlight-1">'.$ad.'</div>'."\n";
					}

					$ad = AdEngine::getInstance()->getAd('RIGHT_SPOTLIGHT_2');

					if( !empty( $ad ) ) {
						$spots .= "\n\t".'<div id="spotlight-2">'.$ad.'</div>'."\n";
					}

					// macbre: return spotlights container only if we have spotlights
					return (!empty($spots) ? '<div id="spotlights" class="clearfix">'.$spots.'</div>' : '');
				}
		}
	}

	function getArticleBarLinks() {

		global $wgTitle;

		$actions = $this->data['content_actions'];

		if ( isset ( $actions['edit'] ) ) {
			$actions['edit']['class'] = 'editButton';
			$actions['edit']['text'] = '<span>'.$actions['edit']['text'].'</span>';
		}
		if ( isset ( $actions['viewsource'] ) ) {
			$actions['viewsource']['class'] = 'editButton';
			$actions['viewsource']['text'] = '<span>'.$actions['viewsource']['text'].'</span>';
		}

		if ( isset ( $actions['addsection'] ) ) {
			$actions['addsection']['text'] = wfMsg( "add_comment" );
		}

		// Build array of left links
		$leftLinks[key($actions)] = current($actions);
		unset($actions[key($actions)]);

		// ugly code, I know
		if( !$wgTitle->isTalkPage() ) {
			if(!empty($actions['edit'])) {
				$leftLinks['edit'] = $actions['edit'];
				unset($actions['edit']);
			}
			elseif(!empty($actions['viewsource'])) {
				$leftLinks['viewsource'] = $actions['viewsource'];
				unset($actions['viewsource']);
			}

			if(!empty($actions['talk'])) {
				$actions['talk']['class'] .= ' divider';
				$leftLinks['talk'] = $actions['talk'];
				unset($actions['talk']);
			}

			if(!empty($actions['userprofile'])) {
				$leftLinks['userprofile'] = $actions['userprofile'];
				unset($actions['userprofile']);
			}
		} else {
			if(!empty($actions['talk'])) {
				$actions['talk']['class'] .= ' divider';
				$leftLinks['talk'] = $actions['talk'];
				unset($actions['talk']);
			}

			if(!empty($actions['edit'])) {
				$leftLinks['edit'] = $actions['edit'];
				unset($actions['edit']);
			}
			elseif(!empty($actions['viewsource'])) {
				$leftLinks['viewsource'] = $actions['viewsource'];
				unset($actions['viewsource']);
			}

			if(!empty($actions['userprofile'])) {
				$actions['userprofile']['class'] .= ' divider';
				$leftLinks['userprofile'] = $actions['userprofile'];
				unset($actions['userprofile']);
			}
		}

		// Assign rest of the elements to right array
		$rightLinks = $actions;

		return array( $leftLinks, $rightLinks );
	}

	function printWikiaFooter() {
		global $wgMemc, $wgLang, $wgContLang;
		wfProfileIn( __METHOD__ );

		$cacheWikiaFooter = $wgLang->getCode() == $wgContLang->getCode();
		if( $cacheWikiaFooter ) {
			$memcKey = wfMemcKey( 'WikiaFooter', $wgLang->getCode() );
			$ret = $wgMemc->get( $memcKey );
		}

		if( empty( $ret ) ) {
			ob_start();
?>
<table cellspacing="0" id="wikiafooter">
<tr>
	<th><?= wfMsg('shared-Footer_header_1') ?></th>
	<th><?= wfMsg('shared-Footer_header_2') ?></th>
	<th><?php $title = Title::newFromText("footer_header_3", 8); echo wfMsg((($title->getArticleID() > 0) ? 'footer_header_3' : 'shared-Footer_header_3')) ?></th>
	<th><?= wfMsg('wikia_messages') ?></th>
</tr>
<tr>
	<td id="footerLinks2">
		<?= wfMsgExt('shared-Footer_links_1', array('parseinline')) ?>
	</td>
	<td id="footerLinks3">
		<?= wfMsgExt('shared-Footer_links_2', array('parseinline')) ?>
	</td>
	<td id="footerLinks4">
		<?php $title = Title::newFromText("footer_links_3", 8); echo wfMsgExt((($title->getArticleID() > 0) ? 'footer_links_3' : 'shared-Footer_links_3'), array('parseinline')) ?>
	</td>
	<td id="footerLinks5">
		<?= wfMsgExt('shared-News_box', array('parseinline')) ?>
	</td>

</tr>
<tr>
	<td colspan="4" id="footerLinks1" class="legal">
		<a href="http://www.wikia.com" id="wikiaFooterLogo"></a>
		<?php
		echo wfMsgExt( 'footer_About_Wikia', array( 'parseinline' ) );
		echo wfMsgExt( 'footer_Contact_Wikia', array( 'parseinline' ) );
		echo wfMsgExt( 'footer_Terms_of_use', array( 'parseinline' ) );
		echo wfMsgExt( 'footer_MediaWiki', array( 'parseinline' ) );
		if (!empty($this->data['copyright']))
		{
			echo $this->data['copyright'];
		} else
		{
			echo wfMsgExt( 'footer_License', array( 'parseinline' ) );
		}
		echo wfMsgExt( 'footer_Advertise_on_Wikia', array( 'parseinline' ) ) . '<br/>';
		?>

		<?= wfMsg('shared-Footer_policy') ?>
	</td>
</tr>
</table>
<?php
			$ret = ob_get_contents();
			if( $cacheWikiaFooter ) {
				$wgMemc->set( $memcKey, $ret, 5*60 );
			}
			ob_end_flush();
		} else {
			echo $ret;
		}
		wfProfileOut( __METHOD__ );
	}

	function execute() {
		global $wgUser, $wgTitle, $wgOut, $wgRequest, $wgContLang, $wgSkinTranslationMap, $wgWikiaLogo, $wgSitename;
		global $wgNotificationEnableSend;

		if(empty($wgWikiaLogo)) {
			global $wgLogo;
			$wgWikiaLogo = $wgLogo;
		}

		$wgSkinTranslationMap = array(
			'this_article'=>'nstab-main',
			'this_message'=>'nstab-mediawiki',
			'edit_contribute'=>'edit',
			'this_wiki'=>'wikicities-nav',
			'edit_this_page'=>'edit',
			'discuss'=>'talk',
			'preferences'=>'mypreferences',
			'contris'=>'contris_s',
			'watchlist'=>'watchlist_s'
		);

		$this->dataProvider =& DataProvider::singleton( $this );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="<?php $this->text('mimetype') ?>; charset=<?php $this->text('charset') ?>" />
		<?php $this->html('headlinks') ?>
		<title><?php $this->text('pagetitle') ?></title>

		<style type="text/css" media="screen,projection">/*<![CDATA[*/
		    @import "<?php $this->text('stylepath') ?>/monobook/main.css?<?= $GLOBALS['wgStyleVersion'] ?>";
		/*]]>*/</style>
		<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/common/commonPrint.css?<?= $GLOBALS['wgStyleVersion'] ?>" />
		<!--[if lt IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/monobook/IE50Fixes.css?<?= $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 5.5000]><style type="text/css">@import "<?php $this->text('stylepath') ?>/monobook/IE55Fixes.css?<?= $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 6]><style type="text/css">@import "<?php $this->text('stylepath') ?>/monobook/IE60Fixes.css?<?= $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if IE 7]><style type="text/css">@import "<?php $this->text('stylepath') ?>/monobook/IE70Fixes.css?<?= $GLOBALS['wgStyleVersion'] ?>";</style><![endif]-->
		<!--[if lt IE 7]><script type="text/javascript" src="<?php $this->text('stylepath') ?>/common/IEFixes.js?<?= $GLOBALS['wgStyleVersion'] ?>"></script>
		<meta http-equiv="imagetoolbar" content="no" /><![endif]-->

		<?=Skin::makeGlobalVariablesScript( $this->data );?>

		<?= GetReferences('quartz_js') ?>

		<!-- YUI CSS -->
		<link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/common/yui_2.5.2/container/assets/container.css?<?= $GLOBALS['wgStyleVersion'] ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/common/yui_2.5.2/logger/assets/logger.css?<?= $GLOBALS['wgStyleVersion'] ?>"/>
		<link rel="stylesheet" type="text/css" href="<?php $this->text('stylepath') ?>/common/yui_2.5.2/tabview/assets/tabview.css?<?= $GLOBALS['wgStyleVersion'] ?>"/>

		<link rel="stylesheet" href="<?php $this->text('stylepath') ?>/quartz/css/main.css?<?= $GLOBALS['wgStyleVersion'] ?>" type="text/css" />
<?php
if($this->themename != 'custom') {
	$themeCssLink = $this->textret('stylepath') . '/quartz/' . $this->themename . '/css/main.css?' . $GLOBALS['wgStyleVersion'];
}
else {
	$themeCssLink = '';
}
?>
		<link rel="stylesheet" href="<?= $themeCssLink ?>" type="text/css" />

		<!--[if lt IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/quartz/css/main_ie.css?<?= $GLOBALS['wgStyleVersion'] ?>" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/quartz/css/main_ie7.css?<?= $GLOBALS['wgStyleVersion'] ?>" /><![endif]-->
		<link rel="stylesheet" type="text/css" <?php if(empty($this->data['printable']) ) { ?>media="print"<?php } ?> href="<?php $this->text('stylepath') ?>/quartz/css/print.css?<?= $GLOBALS['wgStyleVersion'] ?>" />

		<!-- widgets -->
		<link rel="stylesheet" href="<?php $this->text('stylepath') ?>/common/widgets/css/widgets_base.css?<?= $GLOBALS['wgStyleVersion'] ?>" />
		<?= GetReferences('quartz_css') ?>
		<!--[if lt IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/common/widgets/css/widgets_ie.css?<?= $GLOBALS['wgStyleVersion'] ?>" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" href="<?php $this->text('stylepath') ?>/common/widgets/css/widgets_ie7.css?<?= $GLOBALS['wgStyleVersion'] ?>" /><![endif]-->
		<?php $this->html('csslinks') ?>

		<!-- MediaWiki -->
<?php	if($this->data['jsvarurl'  ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('jsvarurl'  ) ?>"><!-- site js --></script>
<?php	} ?>
<?php	if($this->data['pagecss'   ]) { ?>
		<style type="text/css"><?php $this->html('pagecss') ?></style>
<?php	}
        if($this->data['usercss'   ]) { ?>
		<style type="text/css"><?php $this->html('usercss') ?></style>
<?php	}
        if($this->data['userjs'    ]) { ?>
		<script type="<?php $this->text('jsmimetype') ?>" src="<?php $this->text('userjs' ) ?>"></script>
<?php	}
        if($this->data['userjsprev']) { ?>
		<script type="<?php $this->text('jsmimetype') ?>"><?php $this->html('userjsprev') ?></script>
<?php	}
        if($this->data['trackbackhtml']) echo $this->data['trackbackhtml']; ?>
	        <?php $this->html('headscripts');
?>
	</head>

<body<?php if($this->data['body_onload']) { ?> onload="<?php $this->text('body_onload') ?>"<?php } ?> class="mediawiki <?php $this->text('dir') ?> <?php $this->text('pageclass') ?><?php if (!$wgUser->isLoggedIn()) { ?> loggedout<?php } ?> wikiaSkinQuartz">
<?php
$html = "";
wfRunHooks('GetHTMLAfterBody', array( $this, &$html ) );
echo $html;
?>
	<div id="header" class="clearfix abmode<?= $this->abmode ?> abmode<?= $this->abmode ?>-<?= !$this->data['loggedin'] ? 'anon' : 'loggedin' ?>">
	<?= $this->getLeftTopBar() ?>
	<ul id="wikia">
		<li id="wikia-inside">
			<a href="http://www.wikia.com" id="wikiaLogo">&nbsp;</a>
			<form action="<?= htmlentities(Skin::makeSpecialUrl('Search')) ?>" id="searchform">
				<div id="search">
					<div id="searchSubmit">&nbsp;</div>
					<input type="text" id="searchfield" name="search" class="gray" value="<?= wfMsg('ilsubmit') ?> <?= $wgSitename ?>" />
					<? global $wgSearchDefaultFulltext; ?>
					<input type="hidden" name="<?= ( $wgSearchDefaultFulltext ) ? 'fulltext' : 'go'; ?>" value="1" />
				</div>
			</form>
			<div id="searchSuggestContainer" class="yui-ac-container">
			</div>

<?php
list($language, $languageUrls) = $this->getLangBarData();
if ( !empty( $languageUrls ) ) {
?>
			<div id="gelButtons">
				<div class="gelButton language" id="languageMenuToggle">
					<a style="cursor: pointer"><?=$language?></a>

					<div id="languageMenuMain" class="yuimenu bd" style="visibility: hidden">
					    <div id="languageMenu" class="bd" style="display:block">
						<ul style="list-style-type: none; margin-left: 0px"><?php
	if ( is_array( $languageUrls ) ) {
	foreach ($languageUrls as $key => $val) {?><li id="lm-<?= $key ?>"><a href="<?= htmlspecialchars($val['href']) ?>" class="<?= $val['class'] == 'home' ? 'home' : 'page' ?>"><?= $val['text'] ?></a></li><?php
	}
	}
?></ul>
					    </div>
					</div>
				</div>
			</div>
<?php
}
?>
			<?= $this->getRightTopBar(); ?>
		</li>
	</ul>
<?php
	if(wfRunHooks('AlternateNavLinks')) {
?>
	<table cellspacing="0" id="navLinksWikia">
		<tr>
			<td id="wikiLogo">
				<a id="wikiLogoLink" style="background-image: url(<?= $wgWikiaLogo ?>)" href="<?= htmlspecialchars($this->data['nav_urls']['mainpage']['href'])?>"<?= $wgUser->getSkin()->tooltipAndAccesskey('n-mainpage') ?>></a>
				<!--[if lt IE 7]>
				<style type="text/css">
					#wikiLogoLink {
						background-image: none !important;
						filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?= $wgWikiaLogo ?>', sizingMethod='image');
					}
				</style>
				<![endif]-->
			</td>
			<td id="navLinks1">
<?php
$navLinks = $this->getNavLinks();
if(isset($navLinks[1])) {
	foreach( $navLinks[1] as $key => $val) {
?>
				<a href="<?= htmlspecialchars($val['href']) ?>" title="<?= htmlspecialchars($val['text']) ?>"><?= $val['text'] ?></a><!--<br />-->
<?php
	}
}
?>
			</td>
			<td id="navLinks2">
<?php
if(isset($navLinks[2])) {
	foreach( $navLinks[2] as $key => $val) {
?>
				<a href="<?= htmlspecialchars($val['href']) ?>" title="<?= htmlspecialchars($val['text']) ?>"><?= $val['text'] ?></a>
<?php
	}
}
?>
			</td>
		</tr>
	</table>
<?php
	}
?>
</div><!--Header-->

<!--google_ad_section_start-->
<!--contextual_targeting_start-->
<div id="articleWrapper">
	<div class="articleBar">

		<!-- right links begin -->
		<div>
<?php
	list( $leftLinks, $rightLinks ) = $this->getArticleBarLinks();

	foreach($rightLinks as $key => $val) {
?>
			<a id="<?= 'ca-'.Sanitizer::escapeId($key) ?>" class="<?= $val['class'] ?>" href="<?= htmlspecialchars( $val['href'] ) ?>" <?= $wgUser->getSkin()->tooltipAndAccesskey('ca-'.$key) ?>><?= ucfirst($val['text']) ?></a>
<?php
	}
?>
		</div>
		<!-- right links end -->

		<!-- left links begin -->
<?php
	foreach($leftLinks as $key => $val) {
?>
		<a id="<?= 'ca-'.Sanitizer::escapeId($key) ?>" class="<?= $val['class'] ?>" href="<?= htmlspecialchars( $val['href'] ) ?>" <?= $wgUser->getSkin()->tooltipAndAccesskey('ca-'.$key) ?>><?= ucfirst($val['text']) ?></a>
<?
	}
?>
		<!-- left links end -->

	</div>


	<!-- widget cockpit - begin -->
	<div id="widget_cockpit" class="roundedDiv" style="display: none;">
		<div class="r_boxContent" style="position: relative;">

			<div id="carousel-prev">
				<img id="prev-arrow" class="left-button-image" src="http://images.wikia.com/common/left-enabled.gif" alt="Previous Button"/>
			</div>

			<div id="carousel-next">
				<img id="next-arrow" class="right-button-image" src="http://images.wikia.com/common/right-enabled.gif" alt="Next Button"/>
			</div>

			<div id="mycarousel" class="carousel-component">
				<div class="carousel-clip-region" id="widget_cockpit_overlay" style="margin: 0">
					<ul id="widget_cockpit_list" class="carousel-list"></ul>
				</div>
			</div>

			<div id="cockpit_hide" style="position: absolute; top: 0px; right: 21px; cursor: pointer;">X</div>
		</div>
	</div>
	<div id="ghost"></div>
	<!-- widget cockpit - end -->

	<div id="article" class="clearfix" <?php if($this->data['body_ondblclick']) { ?>ondblclick="<?php $this->text('body_ondblclick') ?>"<?php } ?>>
	<!-- article -->
		<a name="top" id="top"></a>
		<?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>
		<h1 class="firstHeading"><?php $this->data['displaytitle']!=""?$this->html('title'):$this->text('title') ?></h1>

		<div id="bodyContent">
			<h3 id="siteSub"><?php $this->msg('tagline') ?></h3>
			<div id="contentSub"><?php $this->html('subtitle'); ?></div>

			<?php if($this->data['undelete']) { ?><div id="contentSub2"><?php     $this->html('undelete') ?></div><?php } ?>
			<?php if($this->data['newtalk'] ) { ?><div class="usermessage noprint"><?php $this->html('newtalk')  ?></div><?php } ?>
			<?php if($this->data['showjumplinks']) { ?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php } ?>
			<!-- start content -->
        	<?php $this->html('bodytext') ?>
			<?php
			global $wgRightsText, $wgInPageEnabled ;
			//make people happy and load only when wikiwyg is enabled
			if ( !empty($wgInPageEnabled)) {
				$copywarn = "<div id=\"editpage-copywarn\" style=\"display: none\">\n" .
				wfMsg( $wgRightsText ? 'copyrightwarning' : 'copyrightwarning2',
				'[[' . wfMsgForContent( 'copyrightpage' ) . ']]',
				$wgRightsText ) . "\n</div>";
				echo $copywarn ;
			}
			?>
        	<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
			<!-- end content -->
		</div>
	<!-- /article -->
	</div>

	<!--contextual_targeting_end-->
	<!--google_ad_section_end-->

<?php
###
# Footer Enhancements Begin
###
$displayArticleFooter = $wgTitle->exists() && $wgTitle->isContentPage() && !$wgTitle->isTalkPage() && $wgOut->isArticle();
if($displayArticleFooter) {
	global $wgArticle, $wgLang, $wgSitename, $wgStylePath;
?>


	<div id="articleFooter">
	<table cellspacing="0">
	<tr>
		<td class="col1">
			<ul class="actions">
				<li><a id="fe_edit_icon" href="<?= $wgTitle->getEditURL() ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_edit_icon" class="sprite" /></a> <div>Improve Wikia by <a href="<?= $wgTitle->getEditURL() ?>"><?= wfMsg('footer_1.5') ?></a></div></li>
				<?php
					if(!$wgTitle->isTalkPage()) {
						$talkPageTitle = $wgTitle->getTalkPage();
				?>
				<li><a id="fe_talk_icon" href="<?= $talkPageTitle->getLocalURL() ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_talk_icon" class="sprite" /></a> <div><a <?= $talkPageTitle->exists() ? '' : ' class="new" ' ?>href="<?= $talkPageTitle->getLocalURL() ?>"><?= wfMsg('footer_2') ?></a></div></li>
				<?php
					}
					$timestamp = $wgArticle->getTimestamp();
					$lastUpdate = $wgLang->date($timestamp);
					$userId = $wgArticle->getUser();
					if($userId > 0) {
						$userText = $wgArticle->getUserText();
						$userPageTitle = Title::makeTitle(NS_USER, $userText);
						$userPageLink = $userPageTitle->getLocalUrl();
						$userPageExists = $userPageTitle->exists();
				?>
				<li><?= $userPageExists ? '<a id="fe_user_icon" href="'.$userPageLink.'">' : '' ?><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_user_icon" class="sprite" /><?= $userPageExists ? '</a>' : '' ?> <div><?= wfMsg('footer_5', '<a id="fe_user_link" '.($userPageExists ? '' : ' class="new" ').'href="'.$userPageLink.'">'.$userText.'</a>', $lastUpdate) ?></div></li>
				<?php
					}
				?>
			</ul>
			<h1>Rate this article: </h1>

			<?php
				$FauxRequest = new FauxRequest(array( "action" => "query", "list" => "wkvoteart", "wkpage" => $this->data['articleid'], "wkuservote" => true ));
				$oApi = new ApiMain($FauxRequest);
				$oApi->execute();
				$aResult =& $oApi->GetResultData();

				if(count($aResult['query']['wkvoteart']) > 0) {
					if(!empty($aResult['query']['wkvoteart'][$this->data['articleid']]['uservote'])) {
						$voted = true;
					} else {
						$voted = false;
					}
					$rating = $aResult['query']['wkvoteart'][$this->data['articleid']]['votesavg'];
				} else {
					$voted = false;
					$rating = 0;
				}

				$hidden_star = $voted ? ' style="display: none;"' : '';
				$ratingPx = round($rating * STAR_RATINGS_WIDTH_MULTIPLIER);
			?>
			<div id="star-rating-wrapper">
				<ul id="star-rating" class="star-rating" rel="<?=STAR_RATINGS_WIDTH_MULTIPLIER;?>">
					<li style="width: <?= $ratingPx ?>px;" id="current-rating" class="current-rating"><?= $rating ?>/5</li>
					<li><a class="one-star" id="star1" title="1/5"<?=$hidden_star?>>1</a></li>
					<li><a class="two-stars" id="star2" title="2/5"<?=$hidden_star?>>2</a></li>
					<li><a class="three-stars" id="star3" title="3/5"<?=$hidden_star?>>3</a></li>
					<li><a class="four-stars" id="star4" title="4/5"<?=$hidden_star?>>4</a></li>
					<li><a class="five-stars" id="star5" title="5/5"<?=$hidden_star?>>5</a></li>
				</ul>
				<span style="<?= ($voted ? '' : 'display: none;') ?>" id="unrateLink"><a id="unrate" href="#"><?= wfMsg( 'unrate_it' ) ?></a></span>
			</div>

		</td>
		<td class="col2">
			<ul class="actions">
				<li><a id="fe_random_icon" href="<?= Skin::makeSpecialUrl( 'Randompage' ) ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_random_icon" class="sprite" /></a> <div><a id="fe_random_link" href="<?= Skin::makeSpecialUrl( 'Randompage' ) ?>"><?= wfMsg('footer_6') ?></a></div></li>
				<li><a id="fe_create_icon" href="<?= Skin::makeSpecialUrl( 'Createpage' ) ?>"><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_create_icon" class="sprite" /></a> <div><a id="fe_create_link" href="<?= Skin::makeSpecialUrl( 'Createpage' ) ?>"><?= wfMsg('createpage') ?></a></div></li>
				<?php
					if(!empty($wgNotificationEnableSend)) {
				?>
				<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="fe_email_icon" class="sprite" /> <div><a href="#" id="shareEmail_a"><?= wfMsg('footer_7') ?></a></div></li>
				<?php
					}
				?>
			</ul>

			<h1><?= wfMsg('footer_8') ?>:</h1>
			<ul id="shareIt" class="actions">
				<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="shareDelicious_img" class="sprite" /> <div><a href="#" id="shareDelicious_a">del.icio.us</a></div></li>
				<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="shareStumble_img" class="sprite" /> <div><a href="#" id="shareStumble_a">StumbleUpon</a></div></li>
				<li><img src="<?= $wgStylePath ?>/monobook/blank.gif" id="shareDigg_img" class="sprite" /> <div><a href="#" id="shareDigg_a">Digg</a></div></li>
			</ul>

		</td>
	</tr>
	</table>
	</div>

<?php
}
###
# Footer Enhancements End
###

self::printWikiaFooter();

AdEngine::getInstance()->setLoadType('inline');
echo AdEngine::getInstance()->getSetupHtml();

?>

	<div id="wikia_header" style="display:none"></div><!-- Hack because ads have code that references this. Awful -->
	<div id="sidebar">
		<?php wfRunHooks('HTMLBeforeWidgets'); ?>
		<div id="sidebar_widgets" style="clear: both">
			<!-- ads begin -->
			<?php if ($adBody = $this->getAds('tr')) { ?>
			<div id="adSpace1" class="adSpace">
			<?= $adBody ?>
			</div>
			<?php } ?>
			<!-- ads end -->

			<!-- widgets begin -->
			<ul class="widgets widgets_vertical" id="widgets_1">
			<?= WidgetFramework::getInstance()->Draw(1) ?>
			</ul>
			<!-- widgets end -->

			<!-- ads begin -->
			<?php if ($adBody = $this->getAds('br')) { ?>
			<div id="adSpace2" class="adSpace">
			<?= $adBody ?>
			</div>
			<?php } ?>
			<!-- ads end -->
		</div>
	</div>

<?php
if( !empty($wgNotificationEnableSend) ) {
	echo wfSendAjaxForm_return(false);
}
?>

</div>

<?php
echo AnalyticsEngine::track('GA_Urchin', AnalyticsEngine::EVENT_PAGEVIEW);
global $wgCityId;
echo AnalyticsEngine::track('GA_Urchin', 'onewiki', array($wgCityId));
echo AnalyticsEngine::track('GA_Urchin', 'hub', AdEngine::getCachedCategory());
echo AnalyticsEngine::track('QuantServe', AnalyticsEngine::EVENT_PAGEVIEW);

?>
<!-- analytics (end) -->

<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>

<?php $this->html('reporttime') ?>

</body>
</html>
<?php
	}
}
?>
