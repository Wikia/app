<!-- s:<?= __FILE__ ?> -->
<div id="<?= ( $aOptions['style'] == 'box' ) ? 'wk_blogs_box' : 'wk_blogs_panel'?>">
<? if ( !empty($aOptions['title']) ) { ?>
<div id="wk_blogs_title"><?=$aOptions['title']?></div>
<? } ?>
<div id="wk_blogs_body">
<?
if (!empty($aRows)) {
?>	
<ul class="list">
<?	
foreach ($aRows as $pageId => $aRow) {
       $oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
?>
<li>
<div class="wk-blogs-link"><a href="<?=$oTitle->getLocalUrl()?>"><?=$oTitle->getText()?></a></div>
<?
/* s: TIMESTAMP */
	if ( !empty($aOptions['timestamp']) ) {
		$aUserLinks = BlogTemplateClass::getUserNameRecord($aRow['username']);
		$sUserLinks = ""; 
		if ( !empty($aUserLinks) ) {
			$sUserLinks = $aUserLinks['userpage']." (".$aUserLinks['talkpage']."|".$aUserLinks['contribs'].")";
		}
?>		
<div class="wk_blogs_timestamp"><span class="left"><?=$wgLang->sprintfDate("F j, Y", wfTimestamp(TS_MW, $aRow['timestamp']))?></span><span class="right"><?=$sUserLinks?></span></div>
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
