<?php 
$numSteps = 5;
require dirname(__FILE__) . '/header.php';
?>
<ul>

<!-- ##############  Add a description to main page ############## -->
<li id="step1" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-step1-headline")?></h1>
<div class="wrapper clearfix">
	<div id="step1_example">
		<div class="accent note">
			<?php echo wfMsgForContent("nwb-step1-example")?>
		</div>
	</div>
	<?php echo wfMsgForContent("nwb-step1-text")?>
	<form id="step1_form" name="step1_form"><!-- Name needed for selenium tests -->
		<textarea name="desc" id="desc_textarea"></textarea>
	</form>

	<script type="text/javascript">
	// Setup
	$(function() {
		Mediawiki.pullArticleContent(Mediawiki.followRedirect(wgMainpage), NWB.pullWikiDescriptionCallback, {"rvsection": 1});
	});
	</script>
</div>
<div class="nav">
	<a href="#step2" id="skip_step_1" onclick="WET.byStr('nwb/step1skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="WET.byStr('nwb/step1save');$('#step1_form').submit();"><span><?php echo wfMsgForContent("nwb-save-description")?></span></button>
	<input onclick="$('#step1_form').submit();" type="button" id="hidden_description_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Add a logo ############ -->
<li id="step2" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-step2-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsgForContent("nwb-step2-text")?>	
	<!-- Hidden iframe to handle the file upload -->
	<iframe id="hidden_iframe" src="about:blank" style="display:none" name="hidden_iframe" onLoad="NWB.iframeFormUpload(this)"></iframe>

	<div style="float: left;">
	<form action="/api.php" method="post" enctype="multipart/form-data" target="hidden_iframe" onSubmit='return NWB.iframeFormInit(this)' id="logo_form">
		<input type="hidden" name="action" value="uploadlogo">	
		<input type="hidden" name="format" value="xml">	
		<input id="logo_article" type="hidden" name="title" value="Wiki.png">	
		<label><?php echo wfMsgForContent("nwb-choose-logo")?>:</label><input type="file" name="logo_file" id="logo_file" onclick="WET.byStr('nwb/step2browse');"/> <input type="submit" value="<?php echo wfMsgForContent("nwb-preview")?>" onclick="WET.byStr('nwb/step2preview');this.form.title.value='Wiki-Preview.png'"/>
	</form>

	<div id="logo_preview_wrapper">
		<label><?php echo wfMsgForContent("nwb-logo-preview")?>:</label>
		<div id="logo_preview"></div>
	</div>
	
	</div><!--float-->
	<div class="accent note">
		<img src="/extensions/wikia/NewWikiBuilder/sample_logo.jpg" id="sample_logo" /><br />
		<?php echo wfMsgForContent("nwb-step2-example")?>
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('nwb/step2back');NWB.gotostep(1);"><span><?php echo wfMsgForContent("nwb-back-to-step-1")?></span></button>
	</span>
	<a href="#step3" id="skip_step_2" onclick="WET.byStr('nwb/step2skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="WET.byStr('nwb/step2save');NWB.uploadLogo();"><span><?php echo wfMsgForContent("nwb-save-logo")?></span></button>
</div>
</li>

<!-- ############## Pick Theme ############## -->

<li id="step3" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-step3-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsgForContent("nwb-step3-text")?>
	<div id="theme_template" style="display:none" class="theme_selekction">
		<label for="theme_radio_$theme"><img id="theme_preview_image_$theme" /></label>
		<input onclick="NWB.changeTheme('monaco-$theme', false)" type="radio" name="theme" value="monaco-$theme" id="theme_radio_$theme"> <label for="theme_radio_$theme">$Theme</label>
	</div>
	<div id="theme_scroller" class="accent">
		<table><tr></tr></table>
	</div>


<script type="text/javascript">
var wgAdminSkin = '<?php echo $wgAdminSkin?>';

// TODO: Pull this list from wgSkinTheme? 
// TODO: convert this to a loop in PHP?
var themes = ['Sapphire','Jade','Sky','Spring','Beach','Forest','Moonlight','Carbon','Obsession'];
for (var i = 0; i < themes.length; i++){
	// Copy the template, search and replace the values
	var ltheme = themes[i].toLowerCase();
	var thtml = $("#theme_template").html();
	thtml = thtml.replace(/\$Theme/g, themes[i]);
	thtml = thtml.replace(/\$theme/g, ltheme);

	// Create element with that preview and append it
	$("#theme_scroller tr").append("<td>" + thtml + "</td>");
	$("#theme_preview_image_" + ltheme).attr("src", "http://images.wikia.com/common/skins/monaco/" + ltheme + "/images/preview.png");

	// Check the box with the current theme ($wgAdminSkin)
	if (wgAdminSkin.replace(/monaco-/, '')  == ltheme) {
		// Check the box and change the theme 
		$("#theme_radio_" + ltheme).attr("checked", true);
		NWB.changeTheme(ltheme, false);
	}
}
</script>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('nwb/step3back');NWB.gotostep(2);"><span><?php echo wfMsgForContent("nwb-back-to-step-2")?></span></button>
	</span>
	<a href="#step4" id="skip_step_3" onclick="WET.byStr('nwb/step3skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="NWB.changeTheme($('input[name=theme]:checked').val(), true);WET.byStr('nwb/step3save');NWB.gotostep(4);"><span><?php echo wfMsgForContent("nwb-save-theme")?></span></button>
	<input onclick="NWB.changeTheme($('input[name=theme]:checked').val(), true);WET.byStr('nwb/step3save');NWB.gotostep(4);" type="button" id="hidden_theme_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>


<!-- ############## Create first pages ############## -->

<li id="step4" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-step4-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsgForContent("nwb-step4-text")?>
	<form id="first_pages_form">
		<input type="hidden" name="category" value="<?php echo htmlspecialchars(wfMsgForContent("nwb-new-pages"))?>">
		<div id="all_fp" class="bullets">
			<ul class="fp_block" id="fp_block_1">
				<!-- Ids aren't necessary for the form, only used for Selenium -->
				<li><input id="fp_1" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_2" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_3" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_4" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /></li>
				<li><input id="fp_5" class="fp_page" type="text" onfocus="NWB.firstPagesInputs()" /></li>
			</ul>
			<!-- Other fp_blocks will be inserted into the dom here with javascript:NWB.firstPagesInputs() -->
		</div><!-- all_fp -->
	</form>
	<div class="accent note">
		<?php echo wfMsgForContent("nwb-step4-example")?>
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('nwb/step4back');NWB.gotostep(3);"><span><?php echo wfMsgForContent("nwb-back-to-step-3")?></span></button>
	</span>
	<a href="#step5" id="skip_step_4" onclick="WET.byStr('nwb/step4skip');"><?php echo wfMsgForContent("nwb-skip-this-step")?></a> <?php echo wfMsgForContent("nwb-or")?><button onclick="WET.byStr('nwb/step4save');$('#first_pages_form').submit();"><span><?php echo wfMsgForContent("nwb-create-pages")?></span></button>
	<input onclick="$('#first_pages_form').submit();" type="button" id="hidden_step_4_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>

<!-- ############## Dones ############## -->

<li id="step5" class="step">
<h1 class="headline"><?php echo wfMsgForContent("nwb-step5-headline")?></h1>
<div class="wrapper clearfix">
	<?php echo wfMsgForContent("nwb-step5-text")?>
	<div id="wiki_army_container">
		<img src="/extensions/wikia/NewWikiBuilder/wiki_army.gif" id="wiki_army" />
		<img src="/extensions/wikia/NewWikiBuilder/wiki_army_logo.png" id ="wiki_army_logo" />
	</div>
</div>
<div class="nav">
	<span class="nav_reverse">
		<button class="secondary" onclick="WET.byStr('nwb/step5back');NWB.gotostep(4);"><span><?php echo wfMsgForContent("nwb-back-to-step-4")?></span></button>
	</span>
	<button onclick="WET.byStr('nwb/step5go');NWB.finalize('<?php echo $wgServer ?>');"><span id="finito"><?php echo wfMsgForContent("nwb-go-to-your-wiki")?></span></button>
</div>
</li>
</ul>

<?php require dirname(__FILE__) . '/footer.php'; ?>
