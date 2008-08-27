<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
ini_set('display_errors', true);
# Mediwiki setup.
$IP = getenv('DOCUMENT_ROOT');
define( 'MEDIAWIKI', true );
require "$IP/StartProfiler.php";
require "$IP/includes/Defines.php";
require "$IP/LocalSettings.php";
require "$IP/includes/Setup.php";
class_exists('AdEngine') || require "$IP/extensions/wikia/AdEngine/AdEngine.php";
$wgShowAds=true;
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<title>Test Page</title>
<script>
var wgContentLanguage = "en";
var wgCatId = 3;
function $() {
	var elements = new Array();
	for (var i = 0; i < arguments.length; i++) {
		var element = arguments[i];
		if (typeof element == 'string')
			element = document.getElementById(element);
		if (arguments.length == 1)
			return element;
		elements.push(element);
	}
	return elements;
}

function toggleAds(ad) {
	if (ad == 'TOP_LEADERBOARD') {
		document.getElementById('TOP_LEADERBOARD').style.display = 'block';
		document.getElementById('TOP_RIGHT_BOXAD').style.display = 'none';
	} else {
		document.getElementById('TOP_LEADERBOARD').style.display = 'none';
		document.getElementById('TOP_RIGHT_BOXAD').style.display = 'block';
	}
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
#TOP_LEADERBOARD {
	background: #333;
	display: none;
	margin-bottom: 10px;
}
#TOP_RIGHT_BOXAD {
	background: #333;
	float: right;
	margin: 0 0 10px 10px;
}
#FASTsleeper1 {
	display: none;
	position: absolute;
	top: 10px;	
}
#FASTsleeper2 {
	display: none;
	position: absolute;
	top: 10px;	
	width: 100%;
}
</style>
</head>
<script>
function FASTisCollisionTop(){
	// stub
	return true;
}
</script>
<!-- Dependency --> 
<script src="http://yui.yahooapis.com/2.5.2/build/yahoo/yahoo-min.js"></script> 
<!-- Used for Custom Events and event listener bindings --> 
<script src="http://yui.yahooapis.com/2.5.2/build/event/event-min.js"></script> 
<!-- Source file --> 
<script src="http://yui.yahooapis.com/2.5.2/build/connection/connection-min.js"></script>
<?php
$html=file_get_contents(dirname(__FILE__) . '/testfiles/longArticleWithImagesNoCollision.html'); 
?>
<body>
<div id="wikia_header">
	<input type="button" value="TOP_LEADERBOARD" onclick="toggleAds(this.value);" />
	<input type="button" value="TOP_RIGHT_BOXAD" onclick="toggleAds(this.value);" />
</div>
<div id="background_strip"></div>
<div class="monaco_shrinkwrap">
	<div id="wikia_page">
		<div id="page_bar">controls here</div>
		<div id="article">
			<?php echo AdEngine::getInstance()->getPlaceHolderDiv("TOP_LEADERBOARD"); ?>
			<?php echo AdEngine::getInstance()->getPlaceHolderDiv("TOP_RIGHT_BOXAD"); ?>
			<?php echo $html;?>
			
		</div><!-- Closing "article" -->
		<div id="articleFooter">
			Article controls here
			<div>
			  Footer Right box ad: <br />
			  <?php /* echo AdEngine::getInstance()->getPlaceHolderDiv("FOOTER_BOXAD"); */?>
			</div>
		
			<br clear="all">
			<hr />
			
			<table id="spotlight_footer">
			<tr>
				<td>
		  	  		Left spotlight: <br />
			  		<?php echo AdEngine::getInstance()->getAd("FOOTER_SPOTLIGHT_LEFT"); ?>
			  	</td>
				<td>
			  		Right spotlight: <br />
			  		<?php echo AdEngine::getInstance()->getAd("FOOTER_SPOTLIGHT_RIGHT"); ?>
				</td>
				<td>
			  		Center spotlight: <br />
			  		<?php echo AdEngine::getInstance()->getAd("FOOTER_SPOTLIGHT_MIDDLE"); ?>
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
		<?php echo AdEngine::getInstance()->getAd("LEFT_SPOTLIGHT_1"); ?>

		<p>
		Left Skyscraper 2:
		<?php echo AdEngine::getInstance()->getPlaceHolderDiv("LEFT_SKYSCRAPER_2", false); ?>
	
	</div>
</div><!--Closing "monaco_shrinkwrap" -->
<?php echo AdEngine::getInstance()->getDelayedLoadingCode()?>


<script language="javascript">
// Temporary div swap code, to be replaced by tie div, when it's ready.
function swapMe(slot){
  realDiv=document.getElementById(slot);
  loadDiv=document.getElementById(slot+'_load');
  realDiv.innerHTML=loadDiv.innerHTML;
}
<?php
foreach (AdEngine::getInstance()->getPlaceholders() as $ph){
	echo "swapMe('$ph');\n";
}
?>
</script>
</body>
<?php echo ArticleAdLogic::getCollisionCollision($html); ?>
</html>
