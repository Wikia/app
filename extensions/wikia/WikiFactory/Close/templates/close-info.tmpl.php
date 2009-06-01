<!-- s:<?= __FILE__ ?> -->
<style type="text/css">
#close-info { text-align: center; font-size:110%; }
#closed-urls a { font-size: 110% }
</style>
<div style="text-align:center">
	<div><img src="<?=$wgExtensionsPath?>/wikia/AutoCreateWiki/images/Installation_animation.gif?<?=$wgStyleVersion?>" width="700" height="142" /></div>
	<div id="close-info"><?= ($dbDumpExist == true) ? wfMsgExt('closed-wiki-dump-exists', "parse", $dbDumpUrl) : wfMsg('closed-wiki-dump-noexists') ?></div>
</div>
<br /><br /><br />
<table width="90%" align="center" id="closed-urls">
    <tr>
        <td width="50%" style="text-align:center"><a href="/index.php?title=Special:CreateWiki"><?=wfMsgExt('closed-wiki-create-wiki', "parse")?></a></td>
        <td width="50%" style="text-align:center"><a href="#"><?=wfMsg('closed-wiki-policy')?></a></td>
    </tr>
</table>
<!-- e:<?= __FILE__ ?> -->
