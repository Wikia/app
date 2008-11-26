<!-- s:<?= __FILE__ ?> -->
<div id="wk-blogs-panel">
<?
if (!empty($aRows)) {
?>	
<div id="wk-blogs-body">
<ul class="panellist">
<?
#echo "<pre>".print_r($aRows, true)."</pre>";
foreach ($aRows as $pageId => $aRow) {
	$oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
?>
<li>
<div class="wk-blogs-link"><a href="<?=$oTitle->getLocalUrl()?>"><?=$oTitle->getSubpageText()?></a></div>
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
<div class="wk-blogs-timestamp"><span class="left"><?=$wgLang->sprintfDate("F j, Y", wfTimestamp(TS_MW, $aRow['timestamp']))?></span><span class="right"><?=$sUserLinks?></span></div>
<?		
	}
/* e: TIMESTAMP */
/* s: SUMMARY */
	if ( !empty($aOptions['summary']) ) {
?>
<div class="wk-blogs-summary"><?= $aRow['text'] ?></div>
<?		
	}
	/* s: COMMENTS */
?>	
<div class="wk-blogs-comments">
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
</div>
<?	
} /* if (!empty($aRows)) */
?>
<div style="float:right;white-space:nowrap;">
<? if (!empty($sPager)) { ?>
<?=$sPager?>
<? } ?>
</div>
</div>
<!-- e:<?= __FILE__ ?> -->
