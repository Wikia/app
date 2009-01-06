<!-- s:<?= __FILE__ ?> -->
<div id="wk_blogs_loader" style="float:right;"></div>
<div class="wk_blogs_post" id="wk_blogs_post">
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
<li class="list"><div class="wk_blogs_link"><a href="<?=$oTitle->getLocalUrl()?>"><?=$oTitle->getSubpageText()?></a></div>
<?
/* s: TIMESTAMP */
	if ( !empty($aOptions['timestamp']) ) {
		$sUserLinks = "";
		if( $wgTitle->getNamespace() != NS_BLOG_ARTICLE ) {
			$aUserLinks = BlogTemplateClass::getUserNameRecord($aRow['username']);
			if ( !empty($aUserLinks) ) {
				$sUserLinks = $aUserLinks['userpage']." (".$aUserLinks['talkpage']."|".$aUserLinks['contribs'].")";
			}
		}
?>
<div class="wk_date"><span class="left"><?=$wgLang->sprintfDate("F j, Y", $aRow['rev_timestamp'])?></span><span class="right"><?=$sUserLinks?></span></div>
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
<div class="wk_blogs_comments"><ul class="links">
<? if (!empty($isCommenting)) { ?><li><span style="margin:0 2px"><img src="<?=$wgExtensionsPath?>/wikia/Blogs/images/comment.gif" border="0" /></span><?=$skin->makeLinkObj($oTitle, wfMsg('blog-nbrcomments', intval($aRow['comments'])), "#comments")?></li><li>|</li><? } ?>
<? if (!empty($isVoting)) { ?><li class="wk_star_list"><?=$aRow['votes']?></li><li>|</li><? } ?>
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
<div class="wk_blogs_pager"><? if (!empty($sPager)) { ?><?=$sPager?><? } ?></div>
</div>
<!-- e:<?= __FILE__ ?> -->
