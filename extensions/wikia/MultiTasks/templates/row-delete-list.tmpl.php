<!-- s:<?= __FILE__ ?> -->
<li>
<div style="padding:6px;">
	<div>Multi-wiki delete mode: <b><?=$modeText?></b></div>
	<div>Article: <b><?=$sTitle?></b> </div>
	<div>Run as: <a href="<?=$wgUser->getUserPage()->getLocalUrl()?>"><?=$mTaskParams['admin']?></a></div>
	<div>Delete as: <?=$mTaskParams['user']?></div>
	<div>Reason: <b><?=$mTaskParams['reason']?></b> </div>
	<div>Number of wikis to delete at: <b><?=$countWikis?></b></div>
	<div>Language of Wikis: <b><?= ( $lang ) ? $lang : " - " ?></b></div>
<? if ( $error ) { ?> 
	<div style="color:#BF0000"><strong><?=wfMsg ('multidelete_task_error' )?></strong></div>
<? } else { ?>
	<div style="color:#2AAF00"><strong><?=wfMsg ('multidelete_task_added', $submit_id )?></strong></div>
<? } ?>
</div>	
</li>
<!-- e:<?= __FILE__ ?> -->
