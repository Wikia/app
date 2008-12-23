<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<p class='error'><?=$error?></p>
<form method="get" action="<?=$action?>">
<div style="padding:3px"><?=wfMsg('tagsreportpagesfound', (!is_array($tagList)) ? 0 : array_sum($tagList))?></div>
<? if (!empty($tagList)) { ?>
<? foreach ($tagList as $tag => $cnt) { ?>
<div style="margin:4px 10px">
<span style="vertical-align: middle"><input type="radio" name="target" value="<?=$tag?>" "<?=($tag == $mTag)?"checked":""?>"></span>
<span style="vertical-align: middle"><?=$tag?> (<?= ($cnt == 1) ? wfMsg('tagsreportpage', $cnt) : wfMsg('tagsreportpages', $cnt) ?>)</span>
</div>
<? } ?>
<? } ?>
<div style="margin:4px">
	<input type="submit" value="<?=wfMsg('tagsreportgo')?>">
</div>
</form>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
