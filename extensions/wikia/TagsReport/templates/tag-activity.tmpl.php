<!-- s:<?= __FILE__ ?> -->
<? if ( $mTag == "" ) { ?>
<br/><?=wfMsg('tagsreportnotspecify')?>
<? } elseif (empty($articles)) { ?>
<br /><?=wfMsg('tagsreportnoresults')?>
<? } else {?>
	<? foreach ($articles as $nspace => $aRows) { ?>
<div><h2><span class="mw-headline"> <?=($nspace == 0) ? wfMsg('tagsreportmainnspace') : $wgContLang->getNsText($nspace)?> </span></h2></div>
		<? if (!empty($aRows) && is_array($aRows)) { ?>
<div><ul>
			<? foreach ($aRows as $id => $pageId) { ?>
				<? $oTitle = Title::newFromID($pageId); ?>
				<? if ($oTitle instanceof Title) { ?>
<li><?=$skin->makeLinkObj($oTitle);?></li>
				<? } else { ?>
<li><?= wfMsg('tagsreportpageremoved', $pageId) ?></li>
				<? } ?>
			<? } ?>
		<? } ?>
</ul></div>		
	<? } ?>
<? } ?>
<!-- e:<?= __FILE__ ?> -->
