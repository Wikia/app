<?php global $wgAdminSkin; ?>
<div id="wikistickies-admintools">
    <h2>Admins Only</h2>
    <p><?= wfMsg('wikistickies-admins-msg'); ?></p>
    <ul>
        <li id="wikistickies-admintool-step2" class="step">
            <h3><?php echo wfMsg("wikistickies-theme-hd")?></h3>

            <div id="wikistickies-themechooser">
                <!-- TODO: i18n for the preview image alt="" attribute. -->
                <!-- TODO: Fill in value for src="" attribute. Cannot be left blank. -->
                <label for="theme_radio__THEME"><img id="theme_preview_image__THEME" src="" alt="Theme preview image." /></label>
                <input type="radio" id="theme_radio__THEME" name="theme" value="monaco-_THEME" onclick="NWB.changeTheme('monaco-_THEME', false);" />
                <label for="theme_radio__THEME">$Theme</label>
            </div>
            <div id="theme_scroller" class="accent">
            </div>
            <script type="text/javascript">
                WIKIA.WikiStickies.wgAdminSkin = '<?php echo $wgAdminSkin?>';
            </script>
        </li>

        <li id="wikistickies-admintools-step3" class="step">
            <h3><?php echo wfMsg("wikistickies-logo-hd")?></h3>

            <!-- Hidden iframe to handle the file upload -->
            <iframe id="hidden_iframe" src="about:blank" style="display:none" name="hidden_iframe" onload="NWB.iframeFormUpload(this)"></iframe>

            <form action="/api.php" method="post" enctype="multipart/form-data" target="hidden_iframe" onsubmit='return NWB.iframeFormInit(this)' id="logo_form">
                <input type="hidden" name="action" value="uploadlogo" />
                <input type="hidden" name="format" value="xml" />
                <input id="logo_article" type="hidden" name="title" value="Wiki.png" />
                <input type="file" name="logo_file" id="logo_file" onclick="WIKIA.WikiStickies.track('/admin/browse');"/> <input type="submit" value="<?php echo wfMsg("nwb-preview")?>" onclick="WIKIA.WikiStickies.track( '/admin/preview' ); this.form.title.value='Wiki-Preview.png'"/>
            </form>

            <div id="logo_preview_wrapper">
                    <label><?php echo wfMsg("nwb-logo-preview")?>:</label>
                    <div id="logo_preview"></div>
            </div>
        </li>

    </ul>

    <!-- TODO: Need to gracefully degrade this functionality. Why isn't it a <form>? -->
    <div id="wikistickies-admintools-submit">
        <a class="wikia_button" href="#" onclick="WIKIA.WikiStickies.track( '/admin/save' ); NWB.changeTheme($('input[name=theme]:checked').val(), true); NWB.uploadLogo();" ><span><?php print wfMsg("wikistickies-save-changes") ?></span></a>
    </div>

</div><!-- END #wikistickies-admintools -->
