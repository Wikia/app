<!-- s:<?= __FILE__ ?> -->
<a name="comments"></a>
<h2 class="wikia_header">
<?php echo wfMsg('article-comments-comments') ?>
</h2>
<?php
if ( count( $comments ) > 1 ) {
?>
<form action="<?php echo $title->getFullURL() ?>" method="get" id="article-comm-form-select">
<select name="order" style="margin-top:-26px;" id="article-comm-order">
	<option value="desc" <?php if ($order=="desc") echo 'selected="selected"' ?>><?php echo wfMsg('article-comments-dsc') ?></option>
	<option value="asc" <?php if ($order=="asc") echo 'selected="selected"' ?>><?php echo wfMsg('article-comments-asc') ?></option>
</select>
</form>
<?php
}
?>
<div id="article-comments" class="clearfix">
<?php
if ( count( $comments ) > 10 ) {
	if ( $canEdit ) {
?>
	<div class="article-comm-input reset clearfix">
	<form action="<?php echo $title->getFullURL() ?>" method="post" id="article-comm-form-top">
	<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<!-- avatar -->
		<div class="article-comm-input-avatar">
			<?php echo $avatar->getImageTag( 50, 50 ); ?>
		</div>
		<!-- textarea -->
		<div class="article-comm-input-text">
		<textarea name="wpArticleComment" id="article-comm-top"></textarea><br />
		<!-- submit -->
		<? if (!$isReadOnly) { ?>
		<script type="text/javascript">
		document.write("<a href=\"<?php echo $title->getFullURL() ?>\" name=\"wpArticleSubmit\" id=\"article-comm-submit-top\" class=\"wikia_button\"><span><? echo wfMsg('article-comments-post') ?></span></a>");
		</script>
		<noscript>
		<input type="submit" name="wpArticleSubmit" id="article-comm-submit-top" value="<? echo wfMsg('article-comments-post') ?>" />
		</noscript>
		<? } ?>
		<div class="right" style="font-style: italic;"><?php echo wfMsg('article-comments-info') ?></div>
		</div>
	</form>
	</div>
<?php
	} else {
		echo wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl() );
	}
}

	if ( ! count( $comments ) ) {
		echo '<ul id="article-comments-ul"><li>';
		echo '<div id="article-comments-zero">' . wfMsg('article-comments-zero-comments') . '</div>';
		echo '</li></ul>';
	} else {
		echo '<ul id="article-comments-ul">';
		$odd = true;
		foreach( $comments as $comment ):
			$class = $odd ? 'odd' : 'even'; $odd = !$odd;
			echo "<li id=\"comm-{$comment->getTitle()->getArticleId()}\" class=\"article-comments-li article-comment-row-{$class}\">\n";
			echo $comment->render();
			echo "\n</li>\n";
		endforeach;
		echo '</ul>';
	}

	if ( $canEdit && !$isBlocked ) {
?>
<div class="article-comm-input reset clearfix">
	<div id="article-comm-bottom-info">&nbsp;</div>
	<form action="<?php echo $title->getFullURL() ?>" method="post" id="article-comm-form-bottom">
	<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<!-- avatar -->
		<div class="article-comm-input-avatar">
		<?php
			echo $avatar->getImageTag( 50, 50 );
		?>
		</div>
		<!-- textarea -->
		<div class="article-comm-input-text">
		<textarea name="wpArticleComment" id="article-comm-bottom"></textarea><br />
		<!-- submit -->
		<? if (!$isReadOnly) { ?>
		<script type="text/javascript">
		document.write("<a href=\"<?php echo $title->getFullURL() ?>\" name=\"wpArticleSubmit\" id=\"article-comm-submit-bottom\" class=\"wikia_button\"><span><? echo wfMsg('article-comments-post') ?></span></a>");
		</script>
		<noscript>
		<input type="submit" name="wpArticleSubmit" id="article-comm-submit-bottom" value="<? echo wfMsg('article-comments-post') ?>" />
		</noscript>
		<? } ?>
		<div class="right" style="font-style: italic;"><?php echo wfMsg('article-comments-info') ?></div>
		</div>
	</form>
</div>
<?php
	} else {
		if ( $isBlocked ) {
?>			
<div class="article-comm-input reset clearfix">
	<div id="article-comm-bottom-info"><p><?=wfMsg('article-comments-comment-cannot-add')?></p><br/><p><?=$output->parse($reason)?></p></div>
</div>	
<?php	
		} else {
			echo wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl() );
		}
	}
?>
</div>
<!-- e:<?= __FILE__ ?> -->
