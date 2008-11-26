<div class="blog-comm-input">
	<form action="#" method="post" id="blog-comm-form-<?php echo $position ?>">
		<!-- avatar -->
		<?php echo $avatar->getLinkTag( 50, 50 ); ?>
		<!-- textarea -->
		<textarea width="80%" name="wpBlogComment" id="blog-comm-<?php echo $position ?>"></textarea>
		<!-- submit -->
		<input type="submit" class="submit" name="wpBlogSubmit" id="blog-comm-submit-<?php echo $position ?>" value="<?php echo wfMsg("blog-comment-post") ?>" />
	</form>
</div>
