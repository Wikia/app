<?php
if( isset( $single ) && $single ):
/**
 * this is exactly the same comment schema as below between <li>/<li>
 * it's used for ajaxed inserting new child. So if you want to change anything
 * you have to change in both cases
 */
?>
<div class="blog-comment">
	<a name="<?php echo isset( $comment["anchor"][2] ) ? $comment["anchor"][2] : "" ?>"></a>
	<div class="comment_avatar">
		<?php echo $comment["avatar"] ?>
	</div>
	<div class="comment">
		<div class="details">
			<strong><?php echo $comment["sig"] ?></strong>
			<span class="timestamp"><?php echo $comment["timestamp"] ?></span>
		</div>
		<?php
			echo $comment["text"];
		?>
	</div>
</div>
<br style="clear: both;" />
<?php
else:
?>
<a name="comments"></a>
<h2 class="wikia_header">
<?php echo wfMsg("blog-comments") ?>
</h2>
<?php if( count( $comments ) > 10 && isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1 ): ?>
<form action="<?php echo $title->getFullURL() ?>" method="get" id="blog-comm-form-select">
<select name="order">
	<option value="asc" <?php if ($order=="asc") echo 'selected="selected"' ?>><?php echo wfMsg("blog-comments-asc") ?></option>
	<option value="desc" <?php if ($order=="desc") echo 'selected="selected"' ?>><?php echo wfMsg("blog-comments-dsc") ?></option>
</select>
</form>
<?php endif ?>
<div id="blog-comments" class="reset clearfix">
<?php
	if( count( $comments ) > 10 && isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1 ):
		// show top input
?>
<div class="blog-comm-input reset clearfix">
	<form action="<?php $title->getFullURL() ?>" method="post" id="blog-comm-form-top">
		<!-- avatar -->
		<div class="blog-comm-input-avatar">
		<?php
			echo $avatar->getImageTag( 50, 50 );
		?>
		</div>
		<!-- textarea -->
		<div class="blog-comm-input-text">
		<textarea name="wpBlogComment" id="blog-comm-top"></textarea><br />
		<!-- submit -->
		<a href="<?php $title->getFullURL() ?>" name="wpBlogSubmit" id="blog-comm-submit-top" class="bigButton">
			<big><? echo wfMsg("blog-comment-post") ?></big>
			<small></small>
		</a>
		</div>
	</form>
</div>
<?php
	endif;

	if( ! $comments ):
		echo wfMsg( "blog-zero-comments" );
	else:
		echo "<ul id=\"blog-comments-ul\" >";
		foreach( $comments as $comment ):
?>
	<li>
		<div class="blog-comment">
		<a name="<?php echo isset( $comment["anchor"][2] ) ? $comment["anchor"][2] : "" ?>"></a>
		<div class="comment_avatar">
			<?php echo $comment["avatar"] ?>
		</div>
		<div class="comment">
			<div class="details">
				<strong><?php echo $comment["sig"] ?></strong>
				<span class="timestamp"><?php echo $comment["timestamp"] ?></span>
			</div>
			<?php
				echo $comment["text"];
			?>
		</div>
		</div>
		<br style="clear: both;" />
	</li>
<?php
		endforeach;
		echo "</ul>";
	endif; // comments

	if( isset( $props[ "commenting" ] ) && $props[ "commenting" ] == 1 ):
?>
<div class="blog-comm-input reset clearfix">
	<form action="<?php $title->getFullURL() ?>" method="post" id="blog-comm-form-bottom">
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
		<a href="<?php $title->getFullURL() ?>" name="wpBlogSubmit" id="blog-comm-submit-bottom" class="bigButton">
			<big><? echo wfMsg("blog-comment-post") ?></big>
			<small></small>
		</a>
		</div>
	</form>
</div>
<?php
	endif;
	echo "</div>";
endif; # $justLi
?>
