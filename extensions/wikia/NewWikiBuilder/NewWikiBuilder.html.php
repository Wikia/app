<?php
if (!defined('MEDIAWIKI')){
$wgSitename = "Wiki Name";
$wgDefaultTheme = "slate";
$language = "en";
// Stub
function wfMsg($in) {
	return $in;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- Called as a standalone file -->
<html>
<body>
<?php } else {
global $wgSitename, $wgDefaultTheme, $wgSkinTheme, $wgContLang;
$language = $wgContLang->getCode();
}
?>
<!-- Jquery is required for the API itself -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="/extensions/wikia/NewWikiBuilder/main.css"/>

<script src="/extensions/wikia/JavascriptAPI/Mediawiki.js"></script>
<script src="/extensions/wikia/NewWikiBuilder/main.js"></script>

<script>
// Set up the cookie prefix, which is set in Mediawiki as $wgCookiePrefix
Mediawiki.cookiePrefix = "wikicities";
var match = window.location.search.match(/js_debug=([0-9])/);
if (match !== null){
	Mediawiki.debugLevel = match[1];
}
<?php 
global $NWBmessages;
echo "NWB.messages = {'" . $language . "': " . json_encode($NWBmessages[$language]) . "}";
?>
</script>
</head>
<!-- End Mediawiki API setup -->
<body>

<div id="header" class="clearfix">
	<img src="/extensions/wikia/NewWikiBuilder/logo.png" id="logo" />
	<ul id="progress">
		<li id="progress_step1">1</li>
		<li id="progress_step2">2</li>
		<li id="progress_step3">3</li>
		<li id="progress_step4">4</li>
		<li id="progress_step5">5</li>
	</ul>
</div>

<ul>

<!-- ##############  Add a description to main page ############## -->
<li id="step1" class="step">
<h1 class="headline"><?php echo wfMsg("nwb-step1-headline")?></h1>
<div class="wrapper clearfix">
	<div id="step1_example">
		<div class="accent note">
			<?php echo wfMsg("nwb-step1-example")?>
		</div>
	</div>
	<?php echo wfMsg("nwb-step1-text")?>
	<form id="step1_form" name="step1_form"><!-- Name needed for selenium tests -->
		<textarea name="desc" id="desc_textarea"></textarea>
	</form>

	<script>
	// Setup
	$(function() {
		Mediawiki.pullArticleContent(Mediawiki.followRedirect("Main Page"), NWB.pullWikiDescriptionCallback, {"rvsection": 0});
	});
	</script>
</div>
<div class="nav">
	<a href="#step2" id="skip_step_1"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onclick="$('#step1_form').submit();"><span><?php echo wfMsg("nwb-save-description")?></span></button>
	<input onclick="$('#step1_form').submit();" type="button" id="hidden_description_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Add a logo ############ -->
<li id="step2" class="step">
<h1 class="headline"><?php echo wfMsg("nwb-step2-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsg("nwb-step2-text")?>	
	<!-- Hidden iframe to handle the file upload -->
	<iframe id="hidden_iframe" src="about:blank" style="display:none" name="hidden_iframe" onLoad="NWB.iframeFormUpload(this)"></iframe>

	<div style="float: left;">
	<form action="/api.php" method="post" enctype="multipart/form-data" target="hidden_iframe" onSubmit='return NWB.iframeFormInit(this)' id="logo_form">
		<input type="hidden" name="action" value="uploadlogo">	
		<input type="hidden" name="format" value="xml">	
		<input id="logo_article" type="hidden" name="title" value="Wiki.png">	
		<label><?php echo wfMsg("nwb-choose-logo")?>:</label><input type="file" name="logo_file"> <input type="submit" value="<?php echo wfMsg("nwb-preview")?>" onClick="this.form.title.value='Wiki-Preview.png'"/> 
		<!--<input type="submit" value="Save" onClick="this.form.title.value='Wiki.png'"/>-->
	</form>

	<div id="logo_preview_wrapper">
		<label><?php echo wfMsg("nwb-logo-preview")?>:</label>
		<div id="logo_preview"></div>
	</div>
	
	<div id="logo_current" style="display: none;"></div>
	
	</div><!--float-->
	<div class="accent note">
		<img src="/extensions/wikia/NewWikiBuilder/sample_logo.jpg" id="sample_logo" /><br />
		<?php echo wfMsg("nwb-step2-example")?>
	</div>
	<script> 
	// Fill in the background image for the logo
	$(function() {
		normalizedLogo = Mediawiki.getNormalizedTitle(Mediawiki.$("logo_article").value);
		url = Mediawiki.getImageUrl(normalizedLogo) + '?' + Math.random();
		$("#logo_current").css("backgroundImage", "url(" + url + ")");
	});
	</script>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="NWB.gotostep(1);"><span><?php echo wfMsg("nwb-back-to-step-1")?></span></button>
	</span>
	<a href="#step3" id="skip_step_2"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onClick="f=document.getElementById('logo_form'); f.title.value='Wiki.png'; f.submit();"><span><?php echo wfMsg("nwb-save-logo")?></span></button>
</div>
</li>

<!-- ############## Pick Theme ############## -->

<li id="step3" class="step">
<h1 class="headline"><?php echo wfMsg("nwb-step3-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsg("nwb-step3-text")?>
	<div id="theme_template" style="display:none" class="theme_selekction">
		<label for="theme_radio_$theme"><img id="theme_preview_image_$theme" /></label>
		<input onClick="NWB.changeTheme('$theme')" type="radio" name="theme" value="$theme" id="theme_radio_$theme"> <label for="theme_radio_$theme">$Theme</label>
	</div>
	<div id="theme_scroller" class="accent">
		<table><tr></tr></table>
	</div>


<script>
var wgDefaultTheme = '<?php echo $wgDefaultTheme?>';

// TODO: Pull this list from wgSkinTheme?
var themes = ['Sapphire', 'Jade', 'Slate', 'Smoke', 'Beach', 'Brick', 'Gaming'];
for (var i = 0; i < themes.length; i++){
	// Copy the template, search and replace the values
	var ltheme = themes[i].toLowerCase();
	var thtml = $("#theme_template").html();
	thtml = thtml.replace(/\$Theme/g, themes[i]);
	thtml = thtml.replace(/\$theme/g, ltheme);

	// Create element with that preview and append it
	$("#theme_scroller tr").append("<td>" + thtml + "</td>");
	$("#theme_preview_image_" + ltheme).attr("src", "http://images.wikia.com/common/skins/monaco/" + ltheme + "/images/preview.png");

	// Check the box with the current theme ($wgDefaultTheme)
	if (wgDefaultTheme == ltheme) {
		// Check the box and change the theme 
		$("#theme_radio_" + ltheme).attr("checked", true);
		NWB.changeTheme(ltheme);
	}
}
</script>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="NWB.gotostep(2);"><span><?php echo wfMsg("nwb-back-to-step-2")?></span></button>
	</span>
	<a href="#step4" id="skip_step_3"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onclick="NWB.gotostep(4);"><span><?php echo wfMsg("nwb-save-theme")?></span></button>
</div>
</li>


<!-- ############## Create first pages ############## -->

<li id="step4" class="step">
<h1 class="headline"><?php echo wfMsg("nwb-step4-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsg("nwb-step4-text")?>
	<div class="accent note">
		<?php echo wfMsg("nwb-step4-example")?>
	</div>
	<form id="step4_form">
		<input type="hidden" name="category" value="<?php echo htmlspecialchars(wfMsg("nwb-coming-soon"))?>">
		<div id="all_fp" class="bullets">
			<ul class="fp_block" id="fp_block_1">
				<!-- Ids aren't necessary for the form, only used for Selenium -->
				<li><input id="fp_1" class="fp_page" type="text" onblur="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_2" class="fp_page" type="text" onblur="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_3" class="fp_page" type="text" onblur="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_4" class="fp_page" type="text" onblur="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_5" class="fp_page" type="text" onblur="NWB.firstPagesInputs()" /></li>
			</ul>
			<!-- Other fp_blocks will be inserted into the dom here with javascript:NWB.firstPagesInputs() -->
		</div><!-- all_fp -->
	</form>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="NWB.gotostep(3);"><span><?php echo wfMsg("nwb-back-to-step-3")?></span></button>
	</span>
	<a href="#step5" id="skip_step_4"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onclick="$('#step4_form').submit();"><span><?php echo wfMsg("nwb-create-pages")?></span></button>
	<input onclick="$('#step4_form').submit();" type="button" id="hidden_step_4_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Dones ############## -->

<li id="step5" class="step">
<h1 class="headline"><?php echo wfMsg("nwb-step5-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsg("nwb-step5-text")?>
	<div id="wiki_army_container">
		<img src="/extensions/wikia/NewWikiBuilder/wiki_army.gif" id="wiki_army" />
		<img src="/extensions/wikia/NewWikiBuilder/wiki_army_logo.png" id ="wiki_army_logo" />
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="NWB.gotostep(4);"><span><?php echo wfMsg("nwb-back-to-step-4")?></span></button>
	</span>
	<button><span id="finito"><?php echo wfMsg("nwb-go-to-your-wiki")?></span></button>
</div>
</li>
</ul>

</body>
</html>
