<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
/*<![CDATA[*/
/*]]>*/
</style>
<form id="tm-form" action="<?= $title->getLocalURL() ?>" method="post">
    <fieldset>
        <legend>
            Current filters:
            [status:
            <strong>
            <?php
            if (!isset($current["task_status"]) || is_null($current["task_status"])) {
                echo "not set";
            }
            else {
                echo $statuses[$current["task_status"]];
            }
            echo "</strong>]&nbsp;[type: <strong>";
            if (!isset($current["task_type"]) || is_null($current["task_type"])) {
                echo "not set";
            }
            else {
                echo $types[$current["task_type"]];
            }
            ?></strong>]
        </legend>
        <label>Status</label>
        <select name="wpStatus">
            <option value="-1">Not set</option>
            <?php foreach ( $statuses as $id => $status ):?>
            <option
                value="<?= $id ?>"
                <?php
                if ( isset($current["task_status"]) &&
                    $current["task_status"] == $id &&
                    !is_null($current["task_status"])
                ){
                    echo "selected=\"selected\"";
                }
                ?>
            ><?= $status ?></option>
            <?php endforeach ?>
        </select>
        &nbsp;
        <label>Type</label>
        <select name="wpType">
            <option value="-1">Not set</option>
            <?php foreach ( $types as $id => $type ):?>
            <option
                value="<?= $id ?>"
                <?php
                if (isset($current["task_type"]) &&
                    $current["task_type"] == $id &&
                    !is_null($current["task_type"])
                ){
                    echo "selected=\"selected\"";
                }
                ?>
            ><?= $id ?></option>
            <?php endforeach ?>
        </select>
        <input type="submit" value="Set filter" name="wpSubmit" />
    </fieldset>
</form>
<!-- e:<?= __FILE__ ?> -->
