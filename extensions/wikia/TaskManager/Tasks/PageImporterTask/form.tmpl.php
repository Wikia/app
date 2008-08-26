<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
#task-form label { display: block; width: 14em !important; float: left; padding-right: 1em; text-align: right;}
#task-form input.text { width: 24em;}
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
        <legend>Add Page Import Task</legend>
        <div class="row">
            <label>Source task id</label>
            <select name="task-source-task-id">
            <?php foreach($grabbers as $grabber): ?>
                <?php // $data["values"]["task-source-task-id"] ?>
                <option value="<?php echo $grabber["id"] ?>">
                    <?php echo $grabber["title"] ?>
                </option>
            <?php endforeach ?>
            </select>
            <div class="info">
                <?php
                    echo (!empty($data["errors"]["task-source-task-id"]))
                        ? $data["errors"]["task-source-task-id"]
                        : "&nbsp;"
                ?>
            </div>
            <div class="hint">
                Specify the Page Grabber Dump task id on which results this task should work
            </div>
        </div>
        <div class="row">
            <label>Target wiki domain name</label>
            <input
                type="text" name="task-target-wiki" id="task-target-wiki"
                value="<?= $data["values"]["task-target-wiki"] ?>"
            />
            <div class="info">
                <?php
                    echo (!empty($data["errors"]["task-target-wiki"]))
                        ? $data["errors"]["task-target-wiki"]
                        : "&nbsp;"
                ?>
            </div>
            <div class="hint">
                Specify the domain name of wiki to which you want to import content.
            </div>
        </div>
        <div style="text-align: center;">
            <input type="submit" name="wpSubmit" value="Add task to queue" />
        </div>
    </fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
