<!-- s:<?= __FILE__ ?> -->
<?php global $wgLang; ?>
<div id="article-comments-wrapper">
	<h2 class="neutral" id="article-comment-header">
		<span class="dark_text_1" id="article-comments-counter"><?= wfMsg('article-comments-comments', $wgLang->formatNum($countCommentsNested)) ?></span>
	</h2>
	<?php
	if ( $countComments > 1 ) {
	?>
	<div class="article-helper-links">
		<a href="<?= $title->getFullURL('showall=1') ?>#article-comment-header"><?= wfMsg('article-comments-show-all') ?></a>
	</div>
	<?php
	}
	?>
	<div id="article-comments" class="clearfix">
	<?php
	if ( $canEdit && !$isBlocked ) {
	?>
		<div class="article-comm-input reset clearfix">
			<div id="article-comm-info">&nbsp;</div>
			<form action="<?= $title->getFullURL() ?>" method="post" id="article-comm-form">
				<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
				<!-- avatar -->
				<div class="article-comm-input-avatar">
				<?php
					echo $avatar->getImageTag( 50, 50 );
				?>
				</div>
				<!-- textarea -->
				<div class="article-comm-input-text">
					<textarea name="wpArticleComment" id="article-comm"></textarea><br />
					<? if (!$isReadOnly) { ?>
					<input type="submit" name="wpArticleSubmit" id="article-comm-submit" value="<?= wfMsg('article-comments-post') ?>" />
					<? } ?>
					<img src="<?= $stylePath ?>/common/images/ajax.gif" class="throbber" />
				</div>
			</form>
		</div>
	<?php
	} else {
		if ( $isBlocked ) {
	?>
		<div class="article-comm-input reset clearfix">
			<div id="article-comm-info">
				<p><?= wfMsg('article-comments-comment-cannot-add') ?></p>
				<br/>
				<p><?= $reason ?></p>
			</div>
		</div>
	<?php } else { ?>
		<div id="article-comments-login">
			<?= wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl() ); ?>
		</div>
	<?php
		}
	}

	echo $commentListText;
	if ($countComments) {
		echo '<div id="article-comments-pagination"><div>' . $pagination . '</div></div>';
	}
	?>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
