<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#close-title {text-align: center; font-size:150%; padding:15px; }
#close-info { text-align: center; font-size:110%; }
#closed-urls a { font-size: 110% }
</style>
<div style="text-align:center">
	<div><img src="<?=$wgExtensionsPath?>/wikia/WikiFactory/Close/images/Installation_animation.jpg" width="700" height="142" /></div>
<?php if ( !empty($isDisabled) ) { ?>
	<div id="close-title"><?= wfMessage( 'disabled-wiki-info' )->escaped() ?></div>
<? } else { ?>
	<div id="close-title"><?= wfMessage( 'closed-wiki-info' )->escaped() ?></div>
	<div id="close-info">
<?php
if ( $bShowDumps ) {
	echo wfMessage( 'closed-wiki-dump-exists' )->parseAsBlock();
	echo wfMessage( 'closed-wiki-dump-links', $aDumps['pages_current'], $aDumps['pages_full'] )->parseAsBlock();
} else {
	echo wfMessage( 'closed-wiki-dump-noexists' )->escaped();
}
?>
	</div>
<? } ?>
</div>
<br /><br /><br />
<table width="90%" align="center" id="closed-urls">
    <tr>
        <td width="50%" style="text-align:center"><a href="http://www.wikia.com/Special:CreateWiki"><?= wfMessage( 'closed-wiki-create-wiki' )->parse() ?></a></td>
        <td width="50%" style="text-align:center"><a href="<?= wfMessage( 'closed-wiki-policy-url' )->useDatabase( false )->escaped() ?>"><?= wfMessage( 'closed-wiki-policy' )->escaped() ?></a></td>
    </tr>
</table>
<!-- e:<?= __FILE__ ?> -->
