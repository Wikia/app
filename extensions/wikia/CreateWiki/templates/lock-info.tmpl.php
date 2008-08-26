<!-- s:<?= __FILE__ ?> -->
<?php
    if ($lock->isLocked() === true):
?>
<style type="text/css">/*<![CDATA[*/
#cw-lock-info {
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    padding: 0.5em;
    background: #eeeeee;
    border: 1px solid #DCDCDC;
}

/*]]>*/</style>
<div id="cw-lock-info">
    <div class="error">
        <?php
           echo wfMsg( "createwiki_requestlocked", array($info[0]["user"], $info[0]["time"]) );
        ?>
    </div>
    <ul>
    History of locks for this request:
    <?php
        foreach( $info as $i ):
            $status = $i["locked"] ? wfMsg("locked") : wfMsg("unlocked");
            echo "<li><b>{$i["user"]}</b> {$status} {$i["time"]}</li>";
        endforeach;
    ?>
    </ul>
    <br />
    You can
    <a href="<?php echo $title->getLocalUrl("action=unlock&id=".$lock->getId()) ?>">
        <strong>unlock</strong>
    </a> this request if You want. But first check time of last lock -
    maybe someone is creating this wiki right now?
</div>
<?php
    endif;
?>
<!-- e:<?= __FILE__ ?> -->
