<!-- s:<?= __FILE__ ?> -->
<!-- DISTRIBUTION TABLE -->
<p class='error'><?=$error?></p>
<form method="get" action="<?=$action?>">
<div style="padding:3px"><?=wfMsgExt('tagsreportpagesfound', 'parsemag', (!is_array($tagList)) ? 0 : array_sum($tagList))?></div>
<? if (!empty($tagList)) { ?>
<? foreach ($tagList as $tag => $cnt) { ?>
<div style="margin:4px 10px">
<label>
	<span style="vertical-align: middle;"><?= Xml::radio('target', $tag, ($tag == $mTag)); ?></span>
	<span style="vertical-align: middle; font-family: monospace;" class="tagname"><?=$tag ?></span>
	<span style="vertical-align: middle;" class="tagcount"><?=wfMsg('tagsreportpages', $cnt); ?></span>
</label>
</div>
<? } ?>
<? } ?>
<div style="margin:4px">
	<input type="submit" value="<?=wfMsg('tagsreportgo')?>">
</div>
</form>
<!-- END OF DISTRIBUTION TABLE -->
<!-- e:<?= __FILE__ ?> -->
