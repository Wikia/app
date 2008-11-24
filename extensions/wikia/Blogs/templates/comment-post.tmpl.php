<div class="blog-comment-input">
	<form action="#" method="post" id="blog-comment-form-<?php echo $position ?>">
		<!-- avatar -->
		<?php
			echo $avatar->getImageTag();
			//  onclick="YAHOO.Wikia.Blogs.submit( 'blog-comment-form-{ echo $position }' )"
		?>
		<!-- textarea -->
		<textarea width="80%" name="wpBlogComment" id="blog-comment-<?php echo $position ?>"></textarea>
		<!-- submit -->
		<input type="submit" name="wpBlogSubmit" value="<?php echo wfMsg("blog-comment-post") ?>" />
	</form>
</div>
