
<?php global $wgAdminSkin; ?>

<ul>
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
                <label><?php echo wfMsg("nwb-choose-logo")?>:</label><input type="file" name="logo_file" id="logo_file" onclick="WET.byStr('nwb/step2browse');"/> <input type="submit" value="<?php echo wfMsg("nwb-preview")?>" onclick="WET.byStr('nwb/step2preview');this.form.title.value='Wiki-Preview.png'"/>
                <!--<input type="submit" value="Save" onclick="this.form.title.value='Wiki.png'"/>-->
        </form>

        <div id="logo_preview_wrapper">
                <label><?php echo wfMsg("nwb-logo-preview")?>:</label>
                <div id="logo_preview"></div>
        </div>

        </div><!--float-->
        <div class="accent note">
                <img src="/extensions/wikia/NewWikiBuilder/sample_logo.jpg" id="sample_logo" /><br />
                <?php echo wfMsg("nwb-step2-example")?>
        </div>
</div>
<div class="nav">
        <span class="nav_reverse">
                <button class="secondary" onclick="WET.byStr('nwb/step2back');NWB.gotostep(1);"><span><?php echo wfMsg("nwb-back-to-step-1")?></span></button>
        </span>
        <a href="#step3" id="skip_step_2" onclick="WET.byStr('nwb/step2skip');"><?php echo wfMsg("nwb-skip-this-step")?></a> <?php echo wfMsg("nwb-or")?><button onclick="WET.byStr('nwb/step2save');NWB.uploadLogo();"><span><?php echo wfMsg("nwb-save-logo")?></span></button>
</div>
</li>
</ul>

<!-- ############## Pick Theme ############## -->

<li id="step3" class="step">
<h1 class="headline"><?php echo wfMsg("nwb-step3-headline")?></h1>
<div class="wrapper clearfix">
        <?php echo wfMsg("nwb-step3-text")?>
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
</div>
<div class="nav">
        <span class="nav_reverse">
                <button class="secondary" onclick="WET.byStr('nwb/step3back');NWB.gotostep(2);"><span><?php echo wfMsg("nwb-back-to-step-2")?></span></button>
        </span>
        <a href="#step4" id="skip_step_3" onclick="WET.byStr('nwb/step3skip');"><?php echo wfMsg("nwb-skip-this-step")?></a> <?php echo wfMsg("nwb-or")?><button onclick="NWB.changeTheme($('input[name=theme]:checked').val(), true);WET.byStr('nwb/step3save');NWB.gotostep(4);"><span><?php echo wfMsg("nwb-save-theme")?></span></button>
        <input onclick="NWB.changeTheme($('input[name=theme]:checked').val(), true);WET.byStr('nwb/step3save');NWB.gotostep(4);" type="button" id="hidden_theme_submit" style="display:none"><!-- For selenium tests -->
</div>
</li>


