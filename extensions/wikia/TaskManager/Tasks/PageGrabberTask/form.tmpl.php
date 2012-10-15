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
#task-form div.hint {font-style: italic; text-align: justify;margin-left: 22em;}
#task-form div.info {color: #fe0000;}
/*]]>*/
</style>
<form id="task-form" action="<?= $title->getLocalUrl( "action=save" ) ?>" method="post">
    <input type="hidden" name="wpType" value="<?= $type ?>" />
    <fieldset>
        <legend>Add Page Grabber Task</legend>
        <div class="row">
            <label>Source wiki url</label>
            <input
                type="text" name="task-source-wiki-url" id="task-source-wiki-url"
                value="<?= $data["values"]["task-source-wiki-url"] ?>"
            />
            <div class="info">
                <?=
                    (!empty($data["errors"]["task-source-wiki-url"]))
                        ? $data["errors"]["task-source-wiki-url"]
                        : "&nbsp;"
                ?>
            </div>
            <div class="hint">
                For example: http://wikiangela.com/w/index.php
            </div>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="wpSubmit" value="Add task to queue" />
        </div>
    </fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
