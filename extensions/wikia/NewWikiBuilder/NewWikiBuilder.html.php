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
<h1 class="headline">Describe your wiki</h1>
<div class="wrapper clearfix">
	<div id="step1_example">
		<div class="accent note">
			<b>Example</b><br />
			Muppet Wiki is an encyclopedia about everything related to Jim Henson, The Muppet Show and Sesame Street. The wiki format allows anyone to create or edit any article, so we can all work together to create a comprehensive database for fans of the Muppets.
		</div>
	</div>
	<p>Let's start setting up <b><?php echo $wgSitename?></b>. You can skip any step and come back to it later on.</p> 
	<p>First: Write a message for the front page of your wiki that describes what <b><?php echo $wgSitename?></b> is about.</p>
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
	<button onclick="$('#step1_form').submit();"><span>Save Description</span></button>
	<input onclick="$('#step1_form').submit();" type="button" id="hidden_description_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Add a logo ############ -->
<li id="step2" class="step">
<h1 class="headline">Upload a logo</h1>
<div class="wrapper clearfix">
	<p>Next: Choose a logo for <b><?php echo $wgSitename?></b>.</p>
	<p>Upload a picture from your computer to represent your wiki.</p>
	<p>You can skip this step if you don't have a picture that you want to use right now.</p>
	
	<!-- Hidden iframe to handle the file upload -->
	<iframe id="hidden_iframe" src="about:blank" style="display:none" name="hidden_iframe" onLoad="NWB.iframeFormUpload(this)"></iframe>

	<div style="float: left;">
	<form action="/api.php" method="post" enctype="multipart/form-data" target="hidden_iframe" onSubmit='return NWB.iframeFormInit(this)' id="logo_form">
		<input type="hidden" name="action" value="uploadlogo">	
		<input type="hidden" name="format" value="xml">	
		<input id="logo_article" type="hidden" name="title" value="Wiki.png">	
		<label>Choose logo:</label><input type="file" name="logo_file"> <input type="submit" value="Preview" onClick="this.form.title.value='Wiki-Preview.png'"/> 
		<!--<input type="submit" value="Save" onClick="this.form.title.value='Wiki.png'"/>-->
	</form>

	<div id="logo_preview_wrapper">
		<label>Logo preview:</label>
		<div id="logo_preview"></div>
	</div>
	
	<div id="logo_current" style="display: none;"></div>
	
	</div><!--float-->
	<div class="accent note">
		<img src="/extensions/wikia/NewWikiBuilder/sample_logo.jpg" id="sample_logo" /><br />
		This would be a good logo for a skateboarding wiki.
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
		<button class="secondary" onclick="NWB.gotostep(1);"><span>Back to step 1</span></button>
	</span>
	<a href="#step3" id="skip_step_2"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onClick="f=document.getElementById('logo_form'); f.title.value='Wiki.png'; f.submit();"><span>Save Logo</span></button>
</div>
</li>

<!-- ############## Pick Theme ############## -->

<li id="step3" class="step">
<h1 class="headline">Pick a Theme</h1>
<div class="wrapper clearfix">
	<p>Now choose a color scheme for <b><?php echo $wgSitename?></b>.</p>
	<p>You can change this later on if you change your mind.</p>
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
		<button class="secondary" onclick="NWB.gotostep(2);"><span>Back to step 2</span></button>
	</span>
	<a href="#step4" id="skip_step_3"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onclick="NWB.gotostep(4);"><span>Save Theme</span></button>
</div>
</li>


<!-- ############## Create first pages ############## -->

<li id="step4" class="step">
<h1 class="headline">Create pages</h1>
<div class="wrapper clearfix">
	<p>What do you want to write about?</p>
	<p>Make a list of some pages you want to have on your wiki.</p>
	<div class="accent note">
		<b>Example</b><br />
		TBD Danny
	</div>
	<form id="step4_form">
		<input type="hidden" name="category" value="<?php echo htmlspecialchars(wfMsg("nwb-coming-soon"))?>">
		<div id="all_fp">
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
		<button class="secondary" onclick="NWB.gotostep(3);"><span>Back to step 3</span></button>
	</span>
	<a href="#step5" id="skip_step_4"><?php echo wfMsg("nwb-skip-this-step")?></a> or 
	<button onclick="$('#step4_form').submit();"><span>Create Pages</span></button>
	<input onclick="$('#step4_form').submit();" type="button" id="hidden_step_4_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Dones ############## -->

<li id="step5" class="step">
<h1 class="headline">What's Next?</h1>
<div class="wrapper clearfix">
	<p>That's all the steps! <b><?php echo $wgSitename?></b> is ready to go.</p>
	<p>Now it's time to start writing and adding some pictures, to give people something to read when they find your wiki.</p>
	<p>The list of pages that you made in the last step has been added to a "Coming Soon" box on the main page. You can get started by clicking on those pages. Have fun!</p>
	<div id="wiki_army_container">
		<img src="wiki_army.gif" id="wiki_army" />
		<img src="wiki_army_logo.png" id ="wiki_army_logo" />
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="NWB.gotostep(4);"><span>Back to step 4</span></button>
	</span>
	<button><span id="finito">Go to your Wiki</span></button>
</div>
</li>
</ul>


</body>
</html>
