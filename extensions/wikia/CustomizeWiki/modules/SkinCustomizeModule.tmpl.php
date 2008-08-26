<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Wikia.Customize");
var $D = YAHOO.util.Dom;

YAHOO.Wikia.Customize.img = function( theme ) {
    return "http://images.wikia.com/common/skins/quartz/" + theme + "/images/preview.gif";
}
YAHOO.Wikia.Customize.over = function( e, theme ) {
    $D.get("previewImageThumb").src = YAHOO.Wikia.Customize.img( theme );
}

YAHOO.Wikia.Customize.out = function( e ) {
    // which radio is selected? should be more easy way than this

    var theme = null;
    var radios = $D.get("skinThumbs");
    if ( radios ) {
        var inputs = radios.getElementsByTagName ("input");
        if (inputs) {
            for (var i = 0; i < inputs.length; ++i) {
                if (inputs[i].type == 'radio' && inputs[i].name == "wpTheme" && inputs[i].checked ) {
                    theme = inputs[i].value;
                }
            }
        }
    }
    if ( theme ) {
        $D.get("previewImageThumb").src = YAHOO.Wikia.Customize.img( theme );
    }
}

YAHOO.Wikia.Customize.click = function( e, theme ) {
    $D.get("previewImageThumb").src = YAHOO.Wikia.Customize.img( theme );
}

/*]]>*/
</script>
<?php
    if (isset($postinfo->status)) {
        echo ( $postinfo->status === true )
        ? Wikia::successbox( $postinfo->message )
        : Wikia::errorbox( $postinfo->message );
    }
?>
<div id="customskin">
    <p>
        <?= wfMsgForContent("customizewiki_skininfo") ?>
    </p>
    <form id="customskin-change" method="post" action="<?= $title->getFullURL() ?>">
    <input type="hidden" name="wpSkin" value="quartz" />
    <div id="previewImage">
        <h5>Theme Preview</h5>
        <img src="http://images.wikia.com/common/skins/quartz/<?= $current ?>/images/preview.gif" id="previewImageThumb" />
    </div>
    <div id="skinThumbs">
<?php
    foreach($themes as $theme):
        if ($theme == "gamespot") continue;
        if ($theme == $current) $checked = 'checked="checked"'; else $checked = "";
?>
    <div class="skinframe">
        <label for="radio-<?= $theme ?>">
            <img id="img-<?= $theme ?>" src="http://images.wikia.com/common/skins/quartz/<?= $theme ?>/images/preview.gif" height="60" />
        </label>
        <br />
        <div>
            <input type="radio" name="wpTheme" id="radio-<?= $theme ?>" value="<?= $theme ?>" <?= $checked ?>/>
            <label for="radio-<?= $theme ?>"><?= $theme ?></label>
        </div>
        <script type="text/javascript">
            /*<![CDATA[*/
            YAHOO.util.Event.addListener( "img-<?= $theme ?>", "mouseover", YAHOO.Wikia.Customize.over, "<?= $theme ?>" );
            YAHOO.util.Event.addListener( "img-<?= $theme ?>", "mouseout", YAHOO.Wikia.Customize.out );
            YAHOO.util.Event.addListener( "radio-<?= $theme ?>", "click", YAHOO.Wikia.Customize.click, "<?= $theme ?>" );
            /*]]>*/
        </script>
    </div>
<?php
    endforeach
?>
    </div>
    <div style="clear: both"></div>
    <div class="actionBar">
            <input type="hidden" name="wpModule" value="<?= $module->getName() ?>" />
            <a href="<?= $title->getFullURL("module={$next->getName()}") ?>"><?= wfMsgForContent("customizewiki_skipstep") ?></a>
            <input type="submit" name="wpSubmit" id="customize-wiki-form-submit" value="<?= wfMsg("customizewiki_savecontinue") ?>" class="button" />
    </div>
    </form>
</div>
<!-- e:<?= __FILE__ ?> -->
