<div id="blog-comments">
<?php if( ! $comments ): ?>
<?php echo wfMsg( "blog-zero-comments" ); ?>
<?php else : ?>
	<?php foreach( $comments as $comment ): ?>
	<div style="border-bottom: 1px solid gray;">
		Autor: <?php echo $comment["parser"]->getUserSig( $autor ) ?>
		<? echo $comment["timestamp"] ?>
	</div>
	<?php
		echo $comment["comment"]->getText();
	?>
	<?php endforeach ?>
<?php endif ?>
</div>
