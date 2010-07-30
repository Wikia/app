<!-- s:<?php print __FILE__ ?> -->
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
<li class="list"><div class="wk_blogs_link"> <a href="<?php print $oTitle->getLocalUrl()?>"><?php print BlogTemplateClass::getSubpageText($oTitle)?></a></div>
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
<div class="wk_date"><span class="left"><?php print $wgLang->date($aRow['rev_timestamp'], true)?></span><span class="right"><?php print $sUserLinks?></span></div>
<?
	}
/* e: TIMESTAMP */
/* s: SUMMARY */
	if ( !empty($aOptions['summary']) ) {
?>
<div class="wk_blogs_summary"><?php print $aRow['text'] ?></div>
<?
	}
	/* s: COMMENTS */
?>
<div class="wk_blogs_comments"><ul class="links">
<? $commentTitle = clone $oTitle; $commentTitle->setFragment("#comments"); ?>
<? if (!empty($isCommenting)) { global $wgBlankImgUrl; ?><li class="blog-comment"><img src="<?php print $wgBlankImgUrl; ?>" border="0" class="sprite talk" /> <?php print $skin->makeLinkObj($commentTitle, wfMsg('blog-nbrcomments', intval($aRow['comments'])))?></li><? } ?>
<? if (!empty($isVoting)) { ?><li class="wk_star_list"><?php print $aRow['votes']?></li><? } ?>
<li><?php print $skin->makeLinkObj($oTitle, wfMsg('blog-readfullpost'))?></li>
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
<div class="wk_blogs_pager"><? if (!empty($sPager)) { ?><?php print $sPager?><? } ?></div>
</div>
<!-- e:<?php print __FILE__ ?> -->
