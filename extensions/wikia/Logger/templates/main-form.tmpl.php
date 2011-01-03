<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<form method="get" action="<?=$action?>">
<? if (!empty($logList)) { ?>
<div style="margin:4px 10px">
<select name="target">
<? foreach ($logList as $log => $cnt) { ?>
<option <?= ( $log == $mLog) ? 'selected="selected"' : '' ?> value="<?=$log?>"><?=$log?> (<?= wfMsg('loggerrecords', $cnt) ?>)</option>
<? } ?>
</select><input type="submit" value="<?=wfMsg('tagsreportgo')?>">
<? } ?>
</div>
</form>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
