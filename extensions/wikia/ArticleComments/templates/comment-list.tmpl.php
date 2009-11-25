<!-- s:<?= __FILE__ ?> -->
<a name="comments"></a>
<h2 class="wikia_header">
<?php echo wfMsg('article-comments-comments') ?>
</h2>
<?php
if ( count( $comments ) > 1 ) {
?>
<form action="<?php echo $title->getFullURL() ?>" method="get" id="blog-comm-form-select">
<select name="order" style="margin-top:-26px;" id="blog-comm-order">
	<option value="desc" <?php if ($order=="desc") echo 'selected="selected"' ?>><?php echo wfMsg('article-comments-dsc') ?></option>
	<option value="asc" <?php if ($order=="asc") echo 'selected="selected"' ?>><?php echo wfMsg('article-comments-asc') ?></option>
</select>
</form>
<?php
}
?>
<div id="blog-comments" class="clearfix">
<?php
if ( count( $comments ) > 10 ) {
	if ( $canEdit ) {
?>
	<div class="blog-comm-input reset clearfix">
	<form action="<?php echo $title->getFullURL() ?>" method="post" id="blog-comm-form-top">
	<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<!-- avatar -->
		<div class="blog-comm-input-avatar">
			<?php echo $avatar->getImageTag( 50, 50 ); ?>
		</div>
		<!-- textarea -->
		<div class="blog-comm-input-text">
		<textarea name="wpArticleComment" id="blog-comm-top"></textarea><br />
		<!-- submit -->
		<? if (!$isReadOnly) { ?>
		<script type="text/javascript">
		document.write("<a href=\"<?php echo $title->getFullURL() ?>\" name=\"wpBlogSubmit\" id=\"blog-comm-submit-top\" class=\"wikia_button\"><span><? echo wfMsg('article-comments-post') ?></span></a>");
		</script>
		<noscript>
		<input type="submit" name="wpBlogSubmit" id="blog-comm-submit-top" value="<? echo wfMsg('article-comments-post') ?>" />
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
		echo '<ul id="blog-comments-ul"><li>';
		echo '<div id="blog-comments-zero">' . wfMsg('article-comments-zero-comments') . '</div>';
		echo '</li></ul>';
	} else {
		echo '<ul id="blog-comments-ul">';
		$odd = true;
		foreach( $comments as $comment ):
			$class = $odd ? 'odd' : 'even'; $odd = !$odd;
			echo "<li id=\"comm-{$comment->getTitle()->getArticleId()}\" class=\"blog-comments-li blog-comment-row-{$class}\">\n";
			echo $comment->render();
			echo "\n</li>\n";
		endforeach;
		echo '</ul>';
	}

	if ( $canEdit && !$isBlocked ) {
?>
<div class="blog-comm-input reset clearfix">
	<div id="blog-comm-bottom-info">&nbsp;</div>
	<form action="<?php echo $title->getFullURL() ?>" method="post" id="blog-comm-form-bottom">
	<input type="hidden" name="wpArticleId" value="<?= $title->getArticleId() ?>" />
		<!-- avatar -->
		<div class="blog-comm-input-avatar">
		<?php
			echo $avatar->getImageTag( 50, 50 );
		?>
		</div>
		<!-- textarea -->
		<div class="blog-comm-input-text">
		<textarea name="wpArticleComment" id="blog-comm-bottom"></textarea><br />
		<!-- submit -->
		<? if (!$isReadOnly) { ?>
		<script type="text/javascript">
		document.write("<a href=\"<?php echo $title->getFullURL() ?>\" name=\"wpBlogSubmit\" id=\"blog-comm-submit-bottom\" class=\"wikia_button\"><span><? echo wfMsg('article-comments-post') ?></span></a>");
		</script>
		<noscript>
		<input type="submit" name="wpBlogSubmit" id="blog-comm-submit-bottom" value="<? echo wfMsg('article-comments-post') ?>" />
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
<div class="blog-comm-input reset clearfix">
	<div id="blog-comm-bottom-info"><p><?=wfMsg('article-comments-comment-cannot-add')?></p><br/><p><?=$output->parse($reason)?></p></div>
</div>	
<?php	
		} else {
			echo wfMsg('article-comments-login', SpecialPage::getTitleFor('UserLogin')->getLocalUrl() );
		}
	}
?>
</div>
<!-- e:<?= __FILE__ ?> -->
