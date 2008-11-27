<div class="blog-comm-input reset clearfix">
	<form action="#" method="post" id="blog-comm-form-<?php echo $position ?>">
		<!-- avatar -->
		<div class="blog-comm-input-avatar">
		<?php
			echo $avatar->getImageTag( 50, 50 );
		?>
		</div>
		<!-- textarea -->
		<div class="blog-comm-input-text">
		<textarea name="wpBlogComment" id="blog-comm-<?php echo $position ?>"></textarea><br />
		<!-- submit -->
		<a href="#" name="wpBlogSubmit" id="blog-comm-submit-<?php echo $position ?>" class="bigButton">
			<big><? echo wfMsg("blog-comment-post") ?></big>
			<small></small>
		</a>
		</div>
	</form>
</div>
