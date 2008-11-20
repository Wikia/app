<hr style="clear: both" />
<div id="blog-comments">
<?php if( ! $comments ): ?>
<?php echo wfMsg( "blog-zero-comments" ); ?>
<?php else : ?>
	<?php foreach( $comments as $comment ): ?>
	<div class="blog-comment">
		Autor: <?php echo $parser->getUserSig( $comment["autor"] ) . ' ' . $comment["timestamp"] ?>
		<br />
		<?php
			echo $comment["comment"]->getText();
		?>
	</div>
	<?php endforeach ?>
<?php endif ?>
</div>
