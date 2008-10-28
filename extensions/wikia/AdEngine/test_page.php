<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
ini_set('display_errors', true);
# Mediwiki setup.
/*
define( 'MEDIAWIKI', true );
require "$IP/StartProfiler.php";
require "$IP/includes/Defines.php";
require "$IP/LocalSettings.php";
require "$IP/includes/Setup.php";
*/
$IP = getenv('DOCUMENT_ROOT');
require "$IP/includes/memcached-client.php";
require "$IP/extensions/wikia/AdEngine/AdEngine.php";
require "$IP/extensions/wikia/AdEngine/AdProviderGAM.php";
require "$IP/extensions/wikia/AdEngine/AdProviderDART.php";
require "$IP/extensions/wikia/AdEngine/AdProviderOpenX.php";
require "$IP/extensions/wikia/AdEngine/AdProviderNull.php";
require "$IP/extensions/wikia/AdEngine/AdProviderGoogle.php";
require "$IP/extensions/wikia/AdEngine/AdProviderPubMatic.php";

// Global variables
$_GET['forceCategory']=array ( 'id' => '3', 'name' => 'Entertainment');
$wgShowAds = true;
$wgDBname = "muppet";
$wgExtensionsPath='/extensions';
$wgLanguageCode = "en";

// Configs: Tip: Use var_export to generate these from a real site.
$slots=array (
  'HOME_TOP_LEADERBOARD' => 
  array (
    'as_id' => '1',
    'size' => '728x90',
    'provider_id' => '1',
    'enabled' => 'Yes',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'HOME_TOP_RIGHT_BOXAD' => 
  array (
    'as_id' => '2',
    'size' => '300x250',
    'provider_id' => '1',
    'enabled' => 'Yes',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'HOME_LEFT_SKYSCRAPER_1' => 
  array (
    'as_id' => '3',
    'size' => '160x600',
    'provider_id' => '1',
    'enabled' => 'Yes',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'HOME_LEFT_SKYSCRAPER_2' => 
  array (
    'as_id' => '4',
    'size' => '160x600',
    'provider_id' => '1',
    'enabled' => 'No',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'TOP_LEADERBOARD' => 
  array (
    'as_id' => '5',
    'size' => '728x90',
    'provider_id' => '1',
    'enabled' => 'Yes',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'TOP_RIGHT_BOXAD' => 
  array (
    'as_id' => '6',
    'size' => '300x250',
    'provider_id' => '1',
    'enabled' => 'Yes',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'LEFT_SKYSCRAPER_1' => 
  array (
    'as_id' => '7',
    'size' => '160x600',
    'provider_id' => '1',
    'enabled' => 'Yes',
    'provider_values' => 
    array (
      0 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'tv',
      ),
      1 => 
      array (
        'keyname' => 'media',
        'keyvalue' => 'movie',
      ),
      2 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comic',
      ),
      3 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'comedy',
      ),
      4 => 
      array (
        'keyname' => 'egnre',
        'keyvalue' => 'family',
      ),
      5 => 
      array (
        'keyname' => 'age',
        'keyvalue' => 'yadult',
      ),
    ),
  ),
  'LEFT_SKYSCRAPER_2' => 
  array (
    'as_id' => '8',
    'size' => '160x600',
    'provider_id' => '2',
    'enabled' => 'Yes',
  ),
  'FOOTER_BOXAD' => 
  array (
    'as_id' => '9',
    'size' => '300x250',
    'provider_id' => '3',
    'enabled' => 'Yes',
  ),
  'LEFT_SPOTLIGHT_1' => 
  array (
    'as_id' => '10',
    'size' => '200x75',
    'provider_id' => '2',
    'enabled' => 'Yes',
  ),
  'FOOTER_SPOTLIGHT_LEFT' => 
  array (
    'as_id' => '11',
    'size' => '200x75',
    'provider_id' => '2',
    'enabled' => 'Yes',
  ),
  'FOOTER_SPOTLIGHT_MIDDLE' => 
  array (
    'as_id' => '12',
    'size' => '200x75',
    'provider_id' => '2',
    'enabled' => 'Yes',
  ),
  'FOOTER_SPOTLIGHT_RIGHT' => 
  array (
    'as_id' => '13',
    'size' => '200x75',
    'provider_id' => '2',
    'enabled' => 'Yes',
  ),
  'LEFT_SKYSCRAPER_3' => 
  array (
    'as_id' => '14',
    'size' => '160x600',
    'provider_id' => '2',
    'enabled' => 'Yes',
  ),
);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<title>Test Page for AdEngine</title>
<script type= "text/javascript">/*<![CDATA[*/
var skin = "monaco";
var stylepath = "http://images.wikia.com/common/releases_current/skins";
var wgArticlePath = "/wiki/$1";
var wgScriptPath = "";
var wgScript = "/index.php";
var wgVariantArticlePath = false;
var wgActionPaths = [];
var wgServer = "http://familyguy.wikia.com";
var wgCanonicalNamespace = "";
var wgCanonicalSpecialPageName = false;
var wgNamespaceNumber = 0;
var wgPageName = "Main_Page";
var wgTitle = "Main Page";
var wgAction = "view";
var wgArticleId = "2246";
var wgIsArticle = true;
var wgUserName = null;
var wgUserGroups = null;
var wgUserLanguage = "en";
var wgContentLanguage = "en";
var wgBreakFrames = false;
var wgCurRevisionId = "23804";
var wgVersion = "1.13.2";
var wgEnableAPI = true;
var wgEnableWriteAPI = false;
var wgRestrictionEdit = ["autoconfirmed"];
var wgRestrictionMove = ["sysop"];
var wgCatId = 3;
var wgParentCatId = 0;
var wgCurse = null;
var wgCityId = "376";
var wgID = 376;
var wgEnableAjaxLogin = true;
var wgReturnTo = "";
var wgDB = "familyguy";
var wgPrivateTracker = true;
var wgMainpage = "Main Page";
var wgIsMainpage = true;
var wgStyleVersion = "2662";
var themename = "custom";
var wgExtensionsPath = "http://images.wikia.com/common/releases_current/extensions";
/*]]>*/</script>
<?php echo AdEngine::getInstance($slots)->getSetupHtml(); // Set up the AdEngine instance with hard coded slots. ?>

<script type="text/javascript" src="http://images.wikia.com/common/releases_current/skins/monaco/js/allinone_non_loggedin.js?2638"></script>
<script type="text/javascript" src="http://images.wikia.com/common/releases_current/skins/common/ajax.js?2638"></script>
<script>
// From custom js
if (!window.skin) {
	var skin = 'monaco';
	var stylepath = 'http://images.wikia.com/common/releases_current/skins';
}

</script>
<style type="text/css">
body {
	background-color: #F5F5F5;
	font-family: arial, sans-serif;
	font-size: 10pt;
	margin: 0;	
}
.monaco_shrinkwrap {
	position: relative;
	width: 100%;	
}
#wikia_header {
	background-color: #F5F5F5;
	border-bottom: 1px solid #999;
	height: 50px;	
	position: relative;
}
#background_strip {
	background-color: #FFF;
	border-bottom: 1px solid #999;
	height: 155px;
}
#wikia_page {
	background-color: #FFF;
	border: 1px solid #AAA;
	height: 1%;
	margin: 0 5px 0 216px;
	overflow: hidden;
	position: relative;
	top: -176px;
	z-index: 5;	
}
#page_bar {
	background-color: #36C;
	color: #FFF;
	font-family: tahoma, sans-serif;
	font-size: 11pt;
	line-height: 32px;	
	margin: 2px 2px 0;
	overflow: hidden;
	padding: 0 5px;
}
#article {
	min-height: 200px;
	padding: 10px;
	position: relative;	
}
#articleFooter {
	border-top: 1px dashed #CCC;
	height: 100px;
	padding: 10px;	
}
#widget_sidebar {
	left: 5px;
	position: absolute;
	top: 5px;
	width: 206px;
	z-index: 20;	
}
#spotlight_footer {
	width: 100%;
}
/*** SLOTS STYLES ***/
#HOME_TOP_LEADERBOARD {
	margin-bottom: 10px;
	margin-left: auto;
}
#HOME_TOP_RIGHT_BOXAD {
	float: right;
	margin-bottom: 10px;
}
#HOME_LEFT_SKYSCRAPER_1 {
	margin: 0 auto 10px auto;
}
#HOME_LEFT_SKYSCRAPER_2 {
	margin: 0 auto;
}

#LEFT_SKYSCRAPER_1 {
	margin: 0 auto 10px auto;
}
#LEFT_SKYSCRAPER_2 {
	margin: 0 auto;
}
#TOP_LEADERBOARD {
	margin-bottom: 10px;
	margin-left: auto;
}
#TOP_RIGHT_BOXAD {
	float: right;
	margin-left: 10px;
	margin-bottom: 10px;
}
#FOOTER_SPOTLIGHT_LEFT, #FOOTER_SPOTLIGHT_MIDDLE, #FOOTER_SPOTLIGHT_RIGHT {
	margin: 0 auto;
}

/* general ads/spotlights styling */
.wikia_ad {
	z-index: 15;
	display: none;
	position: absolute;
}
.wikia_spotlight {
	display: none;
	position: absolute;
}
#HOME_LEFT_SKYSCRAPER_1_load, #HOME_LEFT_SKYSCRAPER_2_load, #LEFT_SKYSCRAPER_1_load, #LEFT_SKYSCRAPER_2_load, #LEFT_SKYSCRAPER_3_load, #LEFT_SPOTLIGHT_1_load {
	z-index: 20;
}
#LEFT_SKYSCRAPER_1_load, #LEFT_SKYSCRAPER_2_load, #LEFT_SKYSCRAPER_3_load, #HOME_LEFT_SKYSCRAPER_1_load, #HOME_LEFT_SKYSCRAPER_2_load {
	height: 600px;
	width: 160px;
}
#TOP_LEADERBOARD_load, #HOME_TOP_LEADERBOARD_load {
	height: 90px;
	width: 728px;
}
#TOP_RIGHT_BOXAD_load, #HOME_TOP_RIGHT_BOXAD_load, #FOOTER_BOXAD_load {
	height: 250px;
	width: 300px;
}


</style>
</head>
<script>
function FASTisCollisionTop(){
	// stub
	return true;
}
</script>
<?php
$html=file_get_contents(dirname(__FILE__) . '/testfiles/longArticleWithImagesNoCollision.html'); 
?>
<body>
<div id="wikia_header">
</div>
<div id="background_strip"></div>
<div id="bodyContent">
<div class="monaco_shrinkwrap">
	<div id="wikia_page">
		<div id="page_bar">controls here</div>
		<div id="article">
			<div id="HOME_TOP_LEADERBOARD"><?php echo AdEngine::getInstance()->getPlaceHolderDiv("TOP_LEADERBOARD"); ?></div>
			<div id="HOME_TOP_RIGHT_BOXAD"><?php echo AdEngine::getInstance()->getPlaceHolderDiv("TOP_RIGHT_BOXAD"); ?></div>
			<?php echo $html;?>
			
		</div><!-- Closing "article" -->
		<div id="articleFooter">
<!--
			Article controls here
			<div>
			  Footer Right box ad: <br />
			  <?php /* echo AdEngine::getInstance()->getPlaceHolderDiv("FOOTER_BOXAD"); */?>
			</div>
-->
		
			<br clear="all">
			
			<table id="spotlight_footer">
			<tr>
				<td>
		  	  		Left spotlight: <br />
			  		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("FOOTER_SPOTLIGHT_LEFT"); ?>
			  	</td>
				<td>
			  		Right spotlight: <br />
			  		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("FOOTER_SPOTLIGHT_RIGHT"); ?>
				</td>
				<td>
			  		Center spotlight: <br />
			  		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("FOOTER_SPOTLIGHT_MIDDLE"); ?>
				</td>
			</tr>
			</table>
		</div>
	</div><!-- Closing "wikia_page" -->
	<div id="widget_sidebar">
		Left Skyscraper 1:
		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("LEFT_SKYSCRAPER_1", false); ?>
		<p>
		Left Spotlight:
		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("LEFT_SPOTLIGHT_1"); ?>

		<p>
		Left Skyscraper 2:
		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("LEFT_SKYSCRAPER_2", false); ?>
	
	</div>
  </div><!-- Closing bodyContent -->
</div><!--Closing "monaco_shrinkwrap" -->
<?php echo AdEngine::getInstance()->getDelayedLoadingCode() ?>
</body>
</html>
