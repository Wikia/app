<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#close-title {text-align: center; font-size:150%; padding:15px; }
#close-info { text-align: center; font-size:110%; }
#closed-urls a { font-size: 110% }
</style>
<div style="text-align:center">
	<div><img src="<?=$wgExtensionsPath?>/wikia/WikiFactory/Close/images/Installation_animation.jpg" width="700" height="142" /></div>
<?php if ( !empty($isDisabled) ) { ?>
	<div id="close-title"><?= wfMsg('disabled-wiki-info') ?></div>
<? } else { ?>
	<div id="close-title"><?= wfMsg('closed-wiki-info') ?></div>
	<div id="close-info">
<?php
if ( $bShowDumps ) {
	echo wfMsg('closed-wiki-dump-exists');
	echo wfMsgExt( 'closed-wiki-dump-links', 'parse', $aDumps['pages_current'], $aDumps['pages_full'], $aDumps['images'] );
} else {
	echo wfMsg('closed-wiki-dump-noexists');
}
?>
	</div>
<? } ?>
</div>
<br /><br /><br />
<table width="90%" align="center" id="closed-urls">
    <tr>
        <td width="50%" style="text-align:center"><a href="http://www.wikia.com/Special:CreateWiki"><?=wfMsgExt('closed-wiki-create-wiki', "parse")?></a></td>
        <td width="50%" style="text-align:center"><a href="/wiki/Wikia:Closed_Wikia"><?=wfMsg('closed-wiki-policy')?></a></td>
    </tr>
</table>
<!-- e:<?= __FILE__ ?> -->
