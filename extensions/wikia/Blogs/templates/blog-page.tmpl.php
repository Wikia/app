<!-- s:<?= __FILE__ ?> -->
<div class="wk_blogs_panel reset" style="<?=(isset($aOptions['style']))?$aOptions['style']:''?>">
<div class="wk_blogs_title color1"><div><?= ( !empty($aOptions['title']) ) ? $aOptions['title'] : "" ?></div>
<div class="wk_blogs_title_refresh"><?=$skin->makeLinkObj($wgTitle, "<img src=\"{$wgExtensionsPath}/wikia/Blogs/images/refresh.gif\" border=0 />", "action=purge")?></div>
</div>
<div class="wk_blogs_body">
<? if (!empty($aRows)) { ?>	
<ul class="list">
<?	
foreach ($aRows as $pageId => $aRow) {
	$oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
	$isVoting = $isCommenting = 0; 
	if (isset($aRow['props']) && array_key_exists('voting', $aRow['props'])) {
		$isVoting = $aRow['props']['voting'];
	}
	if (isset($aRow['props']) && array_key_exists('commenting', $aRow['props'])) {
		$isCommenting = $aRow['props']['commenting'];
	}
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
<div class="wk_blogs_details"><span class="wk_blogs_date"><?=$wgLang->sprintfDate("F j, Y", $aRow['rev_timestamp'])?></span><span class="wk_blogs_author"><?=$sUserLinks?></span></div>
<?		
	}
/* e: TIMESTAMP */
/* s: SUMMARY */
	if ( !empty($aOptions['summary']) ) {
?>
<div class="wk_blogs_summary"><?= $aRow['text'] ?></div>
<div class="wk_blogs_comments"><?php if (!empty($isCommenting)) : ?><span style="margin:0 2px"><img src="<?=$wgExtensionsPath?>/wikia/Blogs/images/comment.gif" border="0" /></span><?=$skin->makeLinkObj($oTitle, wfMsg('blog-nbrcomments', intval($aRow['comments'])))?> | <?php endif ?><?=$skin->makeLinkObj($oTitle, wfMsg('blog-continuereading'))?></div>
<?		
	}
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
