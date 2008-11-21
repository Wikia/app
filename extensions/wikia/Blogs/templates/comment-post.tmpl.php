<div class="blog-comment-input">
	<form action="#" method="post">
		<!-- avatar -->
		<?php
			#echo $avatar->getAvatarImageTag();
		?>
		<!-- textarea -->
		<textarea width="80%" name="wpBlogComment" id="blog-comment-<?php echo $position ?>"></textarea>
		<!-- submit -->
		<input type="submit" name="wpBlogSubmit" value="<?php echo wfMsg("blog-comment-post") ?>"/>
	</form>
</div>
