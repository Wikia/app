<!-- s:<?= __FILE__ ?> -->
<li>
<div style="padding:6px;">
	<div>Multi-wiki edit mode: <b><?=$modeText?></b></div>
	<div>Article: <b><?=$sTitle?></b> </div>
	<div>Added by user: <a href="<?=$wgUser->getUserPage()->getLocalUrl()?>"><?=$mTaskParams['admin']?></a></div>
	<div>Text:<?=$mTaskParams['text']?></div>
	<div>Summary: <b><?=$mTaskParams['summary']?></b> </div>
	<div>Number of Wikis to edit: <b><?=$countWikis?></b></div>
	<div>Language of Wikis: <b><?= ( $lang ) ? $lang : " - " ?></b></div>
	<div>Category of Wikis: <b><?= ( $cat ) ? $cat : " - " ?></b></div>
	<div>Flags: 
<? 
foreach($mTaskParams['flags'] as $id => $flag ) { 
	if ( !empty($flag) ) { 
?>
		<b><?=strtolower($obj->mFlags[$id])?></b>, 
<?  } 
} 
?>
	</div>
<? if ( $error ) { ?> 
	<div style="color:#BF0000"><strong><?=wfMsg ('multiwikiedit_task_error' )?></strong></div>
<? } else { ?>
	<div style="color:#2AAF00"><strong><?=wfMsg ('multiwikiedit_task_added', $submit_id )?></strong></div>
<? } ?>
</div>	
</li>
<!-- e:<?= __FILE__ ?> -->
