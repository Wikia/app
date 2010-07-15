<!-- s:<?= __FILE__ ?> -->
<a name="comments"></a>
<h2 class="wikia_header">
<?php echo wfMsg("blog-comments")." ($commCount)" ?>
</h2>
<?php
if( isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1  && count( $comments ) > 1 ):
?>
<form action="<?php echo $title->getFullURL() ?>" method="get" id="blog-comm-form-select">
<select name="order" style="margin-top:-26px;" id="blog-comm-order">
	<option value="asc" <?php if ($order=="asc") echo 'selected="selected"' ?>><?php echo wfMsg("blog-comments-asc") ?></option>
	<option value="desc" <?php if ($order=="desc") echo 'selected="selected"' ?>><?php echo wfMsg("blog-comments-dsc") ?></option>
</select>
</form>
<?php
endif;
?>
<div id="blog-comments" class="clearfix">
<?php
if( count( $comments ) > 10 && isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1 && !$isReadOnly ):
	if( $canEdit ):
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
		<textarea name="wpBlogComment" id="blog-comm-top"></textarea><br />
		<!-- submit -->
		<script type="text/javascript">
		document.write("<input type=\"submit\" value=\"<? echo wfMsg("blog-comment-post") ?>\" name=\"wpBlogSubmit\" id=\"blog-comm-submit-top\" />");
		</script>
		<noscript>
		<input type="submit" name="wpBlogSubmit" id="blog-comm-submit-top" value="<? echo wfMsg("blog-comment-post") ?>" />
		</noscript>
		<div class="right" style="font-style: italic;"><?php echo wfMsg("blog-comments-info") ?></div>
		</div>
	</form>
	</div>
<?php
	else:
		echo wfMsg("blog-comments-login", SpecialPage::getTitleFor("UserLogin")->getLocalUrl() );
	endif;
endif;

	if( ! count( $comments ) ):
		if( isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1 ):
			echo "<ul id=\"blog-comments-ul\"><li>";
			echo "<div id=\"blog-comments-zero\">" . wfMsg( "blog-zero-comments" ) . "</div>";
			echo "</li></ul>";
		endif;
	else:
		echo "<ul id=\"blog-comments-ul\" >";
		$odd = true;
		foreach( $comments as $comment ):
			$class = $odd ? 'odd' : 'even'; $odd = !$odd;
			echo "<li id=\"comm-{$comment->getTitle()->getArticleId()}\" class=\"blog-comments-li blog-comment-row-{$class}\">\n";
			echo $comment->render();
			echo "\n</li>\n";
		endforeach;
		echo "</ul>";
	endif;

	$order_param = $order == 'asc' ? '&order=asc' : '';
	$prev_url = $page - 1 ? $title->getFullURL().'?page='.($page - 1).$order_param : null;
	$prev_txt = wfMsg('blog-comments-prev');
	$next_url = $page >= $lastPage ? null : $title->getFullURL().'?page='.($page + 1).$order_param;
	$next_txt = wfMsg('blog-comments-next');
?>
<p>
	<?= wfMsg('blog-comments-summary', $page, $lastPage) ?> :
	<?php if ($prev_url): ?><a href="<?= $prev_url ?>"><?= $prev_txt ?></a>
		<?php else: ?><span style="color: #CCCCCC"><?= $prev_txt ?></span><?php endif; ?>
	|
	<?php if ($next_url): ?><a href="<?= $next_url ?>"><?= $next_txt ?></a>
		<?php else: ?><span style="color: #CCCCCC"><?= $next_txt ?></span><?php endif; ?>
</p>
<?php
	if( isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1 ):
		if( $canEdit && !$isBlocked && !$isReadOnly ):
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
		<textarea name="wpBlogComment" id="blog-comm-bottom"></textarea><br />
		<!-- submit -->
		<script type="text/javascript">
		document.write("<input type=\"submit\" value=\"<? echo wfMsg("blog-comment-post") ?>\" name=\"wpBlogSubmit\" id=\"blog-comm-submit-bottom\" />");
		</script>
		<noscript>
		<input type="submit" name="wpBlogSubmit" id="blog-comm-submit-bottom" value="<? echo wfMsg("blog-comment-post") ?>" />
		</noscript>
		<div class="right" style="font-style: italic;"><?php echo wfMsg("blog-comments-info") ?></div>
		</div>
	</form>
</div>
<?php
		else:
			if ( $isBlocked ) :
?>
<div class="blog-comm-input reset clearfix">
	<div id="blog-comm-bottom-info"><p><?=wfMsg("blog-comment-cannot-add")?></p><br/><p><?=$reason?></p></div>
</div>
<?php
			elseif ( $isReadOnly ) :
?>
<div class="blog-comm-input reset clearfix">
	<div id="blog-comm-bottom-info"><p><?=wfMsg("blog-comment-cannot-add")?></p></div>
</div>
<?php
			else :
				echo wfMsg("blog-comments-login", SpecialPage::getTitleFor("UserLogin")->getLocalUrl() );
			endif;
		endif;
	endif;
?>
</div>
<!-- e:<?= __FILE__ ?> -->
