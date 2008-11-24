<h2><?php echo wfMsg("blog-comments") ?></h2>
<div id="blog-comments">
<?php if( ! $comments ): ?>
<?php echo wfMsg( "blog-zero-comments" ); ?>
<?php else : ?>
	<?php foreach( $comments as $comment ): ?>
	<div class="blog-comment">
		<span>
			<?php echo $comment["avatar"] ?>
		</span>
		<span>
		<strong><?php echo $comment["sig"] ?></strong>
		<?php echo $comment["timestamp"] ?>
		<br />
		<?php
			echo $comment["text"];
		?>
		</span>
	</div>
	<?php endforeach ?>
<?php endif ?>
</div>
