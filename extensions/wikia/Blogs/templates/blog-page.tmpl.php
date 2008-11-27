<!-- s:<?= __FILE__ ?> -->
<div class="wk_blogs_panel reset" style="<?=(isset($aOptions['style']))?$aOptions['style']:''?>">
<? if ( !empty($aOptions['title']) ) { ?>
<div class="wk_blogs_title color1"><?=$aOptions['title']?></div>
<? } ?>
<div class="wk_blogs_body">
<?
if (!empty($aRows)) {
?>	
<ul class="list">
<?	
foreach ($aRows as $pageId => $aRow) {
       $oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
?>
<li>
<div class="wk_blogs_link"><a href="<?=$oTitle->getLocalUrl()?>"><?=$oTitle->getSubpageText()?></a></div>
<?
/* s: TIMESTAMP */
	if ( !empty($aOptions['timestamp']) ) {
		$aUserLinks = BlogTemplateClass::getUserNameRecord($aRow['username']);
		$sUserLinks = ""; 
		if ( !empty($aUserLinks) ) {
			$sUserLinks = $aUserLinks['userpage']." (".$aUserLinks['talkpage']."|".$aUserLinks['contribs'].")";
		}
?>		
<div class="wk_blogs_details"><span class="wk_blogs_date"><?=$wgLang->sprintfDate("F j, Y", wfTimestamp(TS_MW, $aRow['timestamp']))?></span><span class="wk_blogs_author"><?=$sUserLinks?></span></div>
<?		
	}
/* e: TIMESTAMP */
/* s: SUMMARY */
	if ( !empty($aOptions['summary']) ) {
?>
<div class="wk_blogs_summary"><?= $aRow['text'] ?></div>
<?		
	}
	/* s: COMMENTS */
?>	
<div class="wk_blogs_comments"><?=$skin->makeLinkObj($oTitle, wfMsg('blog-comments', $aRow['comments']))?> | <?=$skin->makeLinkObj($oTitle, wfMsg('blog-continuereading'))?></div>
<?
	/* e: COMMENTS */
/* e: SUMMARY */
?>
</li>
<?
} /* foreach */
?>
</ul>
<?	
} /* if (!empty($aRows)) */
?>
</div>
</div>
<!-- e:<?= __FILE__ ?> -->
