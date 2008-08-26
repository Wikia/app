<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Wikia.Logo");

YAHOO.Wikia.Logo.UploadCallback = {
    upload: function( oResponse ) {
        // response is json array with message, status and eventually image url
        YAHOO.log( oResponse.responseText );
        var aResponse = YAHOO.Tools.JSONParse(oResponse.responseText);
        YAHOO.util.Dom.get("logo-upload-progress").innerHTML = aResponse["msg"];
        // replace logo with current image
        if ( aResponse["error"] != 1 ) {
            YAHOO.util.Dom.get("logo-upload-img").src = aResponse["img"];
        }
    },
};

YAHOO.Wikia.Logo.Upload = function(e) {
    var oForm = YAHOO.util.Dom.get("logo-upload");
    var ajaxpath = "<?php echo "{$GLOBALS['wgScriptPath']}/index.php"; ?>";
    
    YAHOO.util.Event.preventDefault(e);
    YAHOO.util.Connect.setForm( oForm, true);
    YAHOO.util.Dom.get("logo-upload-progress").innerHTML = '<?php echo Wikia::ImageProgress( "bar"); ?>&nbsp;';
    YAHOO.util.Connect.asyncRequest( "POST", ajaxpath + "?action=ajax&rs=axUploadLogo", YAHOO.Wikia.Logo.UploadCallback );
}

YAHOO.util.Event.addListener( "logo-upload-file", "change", YAHOO.Wikia.Logo.Upload );
YAHOO.util.Event.addListener( "logo-upload-submit", "click", YAHOO.Wikia.Logo.Upload );
/*]]>*/
</script>
<?php
    if (isset($postinfo->status)) {
        echo ( $postinfo->status === true )
        ? Wikia::successbox( $postinfo->message )
        : Wikia::errorbox( $postinfo->message );
    }
?>
<div id="customuploadlogo">
    <p>
        <?= wfMsgForContent("customizewiki_logoinfo") ?>
    </p>
    <form id="logo-upload" method="post" enctype="multipart/form-data" action="<?= $title->getFullURL() ?>">
        <img src="<?= $currentlogo->getURL() ?>" id="logo-upload-img" />
        <input tabindex="1" type="file" name="wpUploadFile" id="logo-upload-file" size="30" />
        <input type="hidden" name="wpDestFile" value="<?= $currentlogo->getName() ?>" />
        <input type="hidden" name="wpIgnoreWarning" value="1" />
        <input type="hidden" name="wpUploadDescription" value="New logo for site" />
        <input type="hidden" name="wpWatchthis" value="1" />
        <noscript>
            <input type="submit" id="logo-upload-submit" name="wpSubmitUpload" value="<?= wfMsgForContent("Upload") ?>" />
        </noscript>
        <div id="logo-upload-progress">&nbsp;</div>
    </form>
    <form id="logo-upload" method="post" enctype="multipart/form-data" action="<?= $title->getFullURL() ?>">
        <div style="clear: both"></div>
        <div class="actionBar">
            <input type="hidden" name="wpModule" value="<?= $module->getName() ?>" />
            <input type="submit" name="wpSubmit" id="customize-wiki-form-submit" value="<?= wfMsgForContent("customizewiki_gotomain") ?>" class="button" />
        </div>
    </form>
</div>
<!-- e:<?= __FILE__ ?> -->
