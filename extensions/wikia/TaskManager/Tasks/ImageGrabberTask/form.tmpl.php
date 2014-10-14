<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#task-form label { display: block; width: 14em !important; float: left; padding-right: 1em; text-align: right;}
#task-form input.text { width: 24em;}
#task-form option {width: 4em; }
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
        <legend>Add Image Grabber Task</legend>
        <div class="row">
            <label>Source wiki</label>
            <input
                type="text" name="task-source-wiki" id="task-source-wiki"
                value="<?= $data["values"]["task-source-wiki"] ?>"
            />
            <div class="info">
            <?php
                echo (!empty($data["errors"]["task-source-wiki"]))
                    ? $data["errors"]["task-source-wiki"]
                    : "&nbsp;"
            ?>
            </div>
            <div class="hint">
                Give full path to index.php on that wiki
            </div>
        </div>
        <div class="row">
            <label>Source wiki version</label>
            <select name="task-version-wiki" id="task-version-wiki">
                <option value="1.9">1.9+</option>
            </select>
            <div class="info">

            </div>
            <div class="hint">
                Check Special:Version from this wiki and match with above
            </div>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="wpSubmit" value="Add task to queue" />
        </div>
    </fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
