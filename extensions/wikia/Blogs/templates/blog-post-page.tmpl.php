<!-- s:<?= __FILE__ ?> -->
<div class="wk_blogs_post" id="wk_blogs_post">
<?php
global $wgBlankImgUrl;
if (!empty($aRows)) {
?>
	<ul class="list">
	<?php
	foreach ($aRows as $pageId => $aRow) {
		$oTitle = Title::newFromText($aRow['title'], $aRow['namespace']);
	?>
		<li class="list">
		<div class="wk_blogs_link"><a href="<?= $oTitle->getLocalUrl() ?>"><?= BlogTemplateClass::getSubpageText($oTitle) ?></a></div>
		<?php
		/* s: TIMESTAMP */
		if ( !empty($aOptions['timestamp']) ) {
			$sUserLinks = '';
			if ( $wgTitle->getNamespace() != NS_BLOG_ARTICLE ) {
				$aUserLinks = BlogTemplateClass::getUserNameRecord($aRow['username']);
				if ( !empty($aUserLinks) ) {
					$sUserLinks = $aUserLinks['userpage'] . ' (' . $aUserLinks['talkpage'] . '|' . $aUserLinks['contribs'] . ')';
				}
			}
		?>
		<div class="wk_date"><span class="left"><?= $wgLang->date($aRow['rev_timestamp'], true) ?></span><span class="right"><?= $sUserLinks ?></span></div>
		<?php
		}
		/* e: TIMESTAMP */
		/* s: SUMMARY */
		if ( !empty($aOptions['summary']) ) {
		?>
		<div class="wk_blogs_summary"><?= $aRow['text'] ?></div>
		<?php
		}
		/* s: COMMENTS */
		?>
		<div class="wk_blogs_comments">
			<ul class="links">
			<?php $commentTitle = clone $oTitle; $commentTitle->setFragment('#WikiaArticleComments'); ?>
				<li class="blog-comment"><img src="<?= $wgBlankImgUrl ?>" border="0" class="sprite talk" /> <?= $skin->makeLinkObj($commentTitle, wfMsg('blog-nbrcomments', intval($aRow['comments']))) ?></li>
				<li><?= $skin->makeLinkObj($oTitle, wfMsg('blog-readfullpost')) ?></li>
			</ul>
		</div>
		<?php
		/* e: COMMENTS */
		/* e: SUMMARY */
		?>
		</li>
	<?php
	} /* foreach */
	?>
	</ul>
<?php
} /* if (!empty($aRows)) */
?>
	<div id="wk_blogs_loader" style="float:right;"></div>
	<div class="wk_blogs_pager"><?php if (!empty($sPager)) { echo $sPager; } ?></div>
</div>
<!-- e:<?= __FILE__ ?> -->
