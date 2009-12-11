
<?php global $wgAdminSkin, $wgContLang, $NWBmessages; ?>

<div id="wikistickies-admintools">
<h2 class="bigger"><?= wfMsg('wikistickies-admins-hd'); ?></h2>
<p><?= wfMsg('wikistickies-admins-msg'); ?></p>

<script type="text/javascript">
	NWB.language = "<?= $wgContLang->getCode() ?>";
	NWB.messages = {"<?php echo $wgContLang->getCode() . '": ' . json_encode($NWBmessages[$wgContLang->getCode()]) . "};"?>
</script>

<ul>

<!-- ############## Add a logo ############ -->
<li id="step2" class="step">
<div class="wrapper clearfix">
<h2><?php echo wfMsg("wikistickies-logo-hd")?></h2>
        <!-- Hidden iframe to handle the file upload -->
        <iframe id="hidden_iframe" src="about:blank" style="display:none" name="hidden_iframe" onLoad="NWB.iframeFormUpload(this)"></iframe>

        <div style="float: left;">
        <form action="/api.php" method="post" enctype="multipart/form-data" target="hidden_iframe" onSubmit='return NWB.iframeFormInit(this)' id="logo_form">
                <input type="hidden" name="action" value="uploadlogo">
                <input type="hidden" name="format" value="xml">
                <input id="logo_article" type="hidden" name="title" value="Wiki.png">
                <input type="file" name="logo_file" id="logo_file" onclick="WIKIA.WikiStickies.track('/admin/browse');"/> <input type="submit" value="<?php echo wfMsg("nwb-preview")?>" onclick="WIKIA.WikiStickies.track( '/admin/preview' ); this.form.title.value='Wiki-Preview.png'"/>
                <!--<input type="submit" value="Save" onclick="this.form.title.value='Wiki.png'"/>-->
        </form>

        <div id="logo_preview_wrapper">
                <label><?php echo wfMsg("nwb-logo-preview")?>:</label>
                <div id="logo_preview"></div>
        </div>

	<div id="wikistickies_save_all_upper">
		<a id="WikistickiesToolsSubmitUpper" class="wikia_button" href="#" onclick="WIKIA.WikiStickies.track( '/admin/save' ); NWB.changeTheme($('input[name=theme]:checked').val(), true); NWB.uploadLogo();" ><span><?= wfMsg("wikistickies-save-changes") ?></span></a>
	</div>

        </div><!--float-->
</div>
</li>

<!-- ############## Pick Theme ############## -->

<li id="step3" class="step">
<div class="wrapper clearfix">
<h2><?php echo wfMsg("wikistickies-theme-hd")?></h2>
        <div id="theme_template" style="display:none" class="theme_selekction">
                <label for="theme_radio_$theme"><img id="theme_preview_image_$theme" /></label>
                <input onclick="NWB.changeTheme('monaco-$theme', false)" type="radio" name="theme" value="monaco-$theme" id="theme_radio_$theme"> <label for="theme_radio_$theme">$Theme</label>
        </div>
        <div id="theme_scroller" class="accent">
                <table><tr></tr></table>
        </div>


<script>

var wgAdminSkin = '<?php echo $wgAdminSkin?>';

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

        // Check the box with the current theme ($wgAdminSkin)
        if (wgAdminSkin.replace(/monaco-/, '')  == ltheme) {
                // Check the box and change the theme 
                $("#theme_radio_" + ltheme).attr("checked", true);
                NWB.changeTheme(ltheme, false);
        }
}
</script>
	<div id="wikistickies_save_all">
		<a id="WikistickiesToolsSubmit" class="wikia_button" href="#" onclick="WIKIA.WikiStickies.track( '/admin/save' ); NWB.changeTheme($('input[name=theme]:checked').val(), true); NWB.uploadLogo();" ><span><?= wfMsg("wikistickies-save-changes") ?></span></a>
	</div>

</div>
</li>

</ul>
</div>
