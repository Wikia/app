<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Called as a standalone file -->
<html>
<head>
<title><?php echo wfMsgForContent("newwikibuilder")?></title>
<body>
<?php
global $wgStyleVersion, $wgSitename, $wgAdminSkin, $wgContLang, $wgServer, $wgUser, $NWBmessages;
?>
<link rel="stylesheet" type="text/css" href="/extensions/wikia/NewWikiBuilder/main.css?<?= $wgStyleVersion ?>"/>
<?php echo Skin::makeGlobalVariablesScript( @$this->data ); ?>
<?php
$StaticChute = new StaticChute('js');
$StaticChute->useLocalChuteUrl();
echo $StaticChute->getChuteHtmlForPackage('monaco_loggedin_js');
?>
<script type="text/javascript" src="/extensions/wikia/JavascriptAPI/Mediawiki.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript" src="/extensions/wikia/NewWikiBuilder/main.js?<?= $wgStyleVersion ?>"></script>
<script type="text/javascript">
// Set up the cookie prefix, which is set in Mediawiki as $wgCookiePrefix
Mediawiki.cookiePrefix = "wikicities";
var match = window.location.search.match(/js_debug=([0-9])/);
if (match !== null){
	Mediawiki.debugLevel = match[1];
}
NWB.language = "<?php echo $this->lang?>";
NWB.messages = {"<?php echo $this->lang . '": ' . json_encode($NWBmessages[$this->lang]) . "};"?>
</script>
</head>
<!-- End Mediawiki API setup -->
<body>

<div id="header" class="clearfix">
	<img src="/extensions/wikia/NewWikiBuilder/logo.png" id="logo" />
	<ul id="progress">
	  <?php
           for($i=1; $i<= $numSteps; $i++){ ?>
		<li id="progress_step<?php echo $i?>"><?php echo $i?></li>
          <?php } ?>
	</ul>
</div>
