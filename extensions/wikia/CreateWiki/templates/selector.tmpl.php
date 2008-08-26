<!-- s:<?= __FILE__ ?> -->
<div>
    <form action="<?php echo $title->getLocalUrl() ?>" method="post">
    <fieldset>
        <input type="hidden" name="action" value="load" />
        <legend>Choose request from list</legend>
        <select name="request" id="request">
        <?php
            foreach ($requests as $rq):
                $default = ($request == $rq->request_id) ? "default=\"default\"" : $default = "";
                echo "<option value=\"{$rq->request_id}\" {$default}>";
                echo wfRequestTitle( $rq->request_name, $rq->request_language )->getText();
                echo "</option>";
            endforeach
        ?>
        </select>
        <input type="submit" name="submit" value="Get this request" />
    </fieldset>
    </form>
<a href="<?php echo $title->getFullUrl("action=unlock") ?>">Remove create lock (beware! you'll lost your form data)</a>
</div>
<!-- e:<?= __FILE__ ?> -->
