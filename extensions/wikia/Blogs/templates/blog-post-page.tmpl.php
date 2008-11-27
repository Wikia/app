<!-- s:<?= __FILE__ ?> -->
<div class="wk_blogs_post">
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
		$sUserLinks = ""; 
		if ($wgUser->getName() != $aRow['username']) { 
			$aUserLinks = BlogTemplateClass::getUserNameRecord($aRow['username']);
			if ( !empty($aUserLinks) ) {
				$sUserLinks = $aUserLinks['userpage']." (".$aUserLinks['talkpage']."|".$aUserLinks['contribs'].")";
			}
		}
?>		
<div class="wk_date"><span class="left"><?=$wgLang->sprintfDate("F j, Y", wfTimestamp(TS_MW, $aRow['timestamp']))?></span><span class="right"><?=$sUserLinks?></span></div>
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
<div class="wk_blogs_comments">
<ul class="links">
<li><span style="margin:0 2px"><img src="<?=$wgExtensionsPath?>/wikia/Blogs/images/comment.gif" border="0" /></span><?=$skin->makeLinkObj($oTitle, wfMsg('blog-nbrcomments', intval($aRow['comments'])), "#comments")?></li>
<li>|</li>
<li><?=$aRow['votes']?></li>
<li>|</li>
<li><?=$skin->makeLinkObj($oTitle, wfMsg('blog-readfullpost'))?></li>
</ul>
</div>
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
<div class="wk_blogs_pager">
<? if (!empty($sPager)) { ?>
<?=$sPager?>
<? } ?>
</div>
</div>
<!-- e:<?= __FILE__ ?> -->
