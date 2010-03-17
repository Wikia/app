<!-- s:<?= __FILE__ ?> -->
<div class="wk_blogs_panel" style="<?=(isset($aOptions['style']))?$aOptions['style']:''?>">
<div class="wk_blogs_title color1"><div><?= ( !empty($aOptions['title']) ) ? $aOptions['title'] : "" ?></div>
<div class="wk_blogs_title_refresh"><?=$skin->makeLinkObj($wgTitle, "<img src=\"{$wgStylePath}/common/blank.gif\" border=\"0\" class=\"sprite refresh\" />", "action=purge")?></div>
</div>
<div class="wk_blogs_body">
<? if (!empty($aRows)) { ?>
<ul class="list" style="list-style-image:none;list-style-position:outside;list-style-type:none;margin:0.3em 0 0 0.5em">
<?
foreach ($aRows as $pageId => $aRow) {
	$oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
	if ( !$oTitle instanceof Title ) continue;
	$isVoting = $isCommenting = 0;
	if (isset($aRow['props']) && array_key_exists('voting', $aRow['props'])) {
		$isVoting = $aRow['props']['voting'];
	}
	if (isset($aRow['props']) && array_key_exists('commenting', $aRow['props'])) {
		$isCommenting = $aRow['props']['commenting'];
	}
?>
<li style="line-height:normal;margin:0;padding:0;">
<div class="wk_blogs_link"><a href="<?=$oTitle->getLocalUrl()?>"><?=BlogTemplateClass::getSubpageText($oTitle)?></a></div>
<?
/* s: TIMESTAMP */
	if ( !empty($aOptions['timestamp']) ) {
		$aUserLinks = BlogTemplateClass::getUserNameRecord($aRow['username'], true);
		$sUserLinks = "";
		if ( !empty($aUserLinks) ) {
			$sUserLinks = $aUserLinks['userpage']." (".$aUserLinks['talkpage']."|".$aUserLinks['contribs'].")";
		}
?>
<div class="wk_blogs_details"><span class="wk_blogs_date"><?=$wgLang->date($aRow['rev_timestamp'], true)?></span><span class="wk_blogs_author"><?=$sUserLinks?></span></div>
<?
	}
/* e: TIMESTAMP */
/* s: SUMMARY */
	if ( !empty($aOptions['summary']) ) {
		global $wgBlankImgUrl;
?>
<div class="wk_blogs_summary"><?= $aRow['text'] ?></div>
<div class="wk_blogs_comments"><?php if (!empty($isCommenting)) : ?><?php $commentTitle = clone $oTitle; $commentTitle->setFragment("#comments"); ?><span class="blog-comment"><img src="<?php print $wgBlankImgUrl; ?>" class="sprite talk" /><?=$skin->link($commentTitle, wfMsg('blog-nbrcomments', intval($aRow['comments'])), array('rel' => 'nofollow'))?></span> | <?php endif ?><?=$skin->link($oTitle, wfMsg('blog-continuereading'), array('rel' => 'nofollow'))?></div>
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
