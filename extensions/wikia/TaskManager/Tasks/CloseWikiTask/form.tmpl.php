<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#task-form label { display: block; width: 14em !important; float: left; padding-right: 1em; text-align: right;}
#task-form input.text { width: 24em;}
#task-form option {width: 20em; }
#task-form textarea { width: 24em; height: 16em;}
#task-form .inactive {color: #2F4F4F; padding: 0.2em; font-weight: bold;}
#task-form .admin {background: #F0E68C;}
#task-form div.row { padding: 0.8em; margin-bottom: 0.8em; display: block; clear: both; border-bottom: 1px solid #DCDCDC; }
#task-form div.info, div.hint { text-align: center;}
#task-form div.hint {font-style: italic; margin-left: 22em;}
#task-form div.info {color: #fe0000;}
/*]]>*/
</style>
<script type="text/javascript">
/*<![CDATA[*/
YAHOO.namespace("Wiki.Close");
var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WC = YAHOO.Wiki.Close;

YAHOO.Wiki.Close.watchCheckbox = function( e, target ) {
    var cbox = e.originalTarget.id;

    if ( YD.get( cbox ).checked == true ) {
        YD.get( target ).disabled = false;
        YD.setStyle( target, "background", "inherit" );
    }
    else {
        YD.get( target ).disabled = true;
        YD.setStyle( target, "background", "#dcdcdc" );
    }
}

YE.addListener( "task-export", "change", WC.watchCheckbox, "task-p-wiki" );
/*]]>*/
</script>
<form id="task-form" action="<?= $title->getLocalUrl( "action=save" ) ?>" method="post">
    <input type="hidden" name="wpType" value="<?= $type ?>" />
    <fieldset>
        <legend>Add Close Wiki task</legend>
        <div class="row">
            <label>Wiki for closing</label>
            <input
                type="text" name="task-c-wiki" id="task-c-wiki"
                value="<?= $data["values"]["task-c-wiki"] ?>"
            />
            <div class="info">
                <?=
                    (!empty($data["errors"]["task-c-wiki"]))
                        ? $data["errors"]["task-c-wiki"]
                        : "&nbsp;"
                ?>
            </div>
            <div class="hint">
                Valid wikia domain or subdomain
            </div>
        </div>
        <div class="row">
            <label>Move articles to parent wiki</label>
            <input type="checkbox" name="task-export" id="task-export" checked="checked" />
            <div class="hint">
                check if you want to migrate articles to parent wiki
            </div>
        </div>
        <div class="row">
            <label>Parent wiki</label>
            <input
                type="text" name="task-p-wiki" id="task-p-wiki"
                value="<?= $data["values"]["task-p-wiki"] ?>"
            />
            <div class="info">
                <?=
                    (!empty($data["errors"]["task-p-wiki"]))
                    ?  $data["errors"]["task-p-wiki"]
                    : "&nbsp;"
                ?>
            </div>
            <div class="hint">
                Valid wikia domain or subdomain.
            </div>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="wpSubmit" value="Add task to queue" />
        </div>
    </fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
