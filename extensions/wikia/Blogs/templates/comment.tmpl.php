<h2><?php echo wfMsg("blog-comments") ?></h2>
<div id="blog-comments">
<?php if( ! $comments ): ?>
<?php echo wfMsg( "blog-zero-comments" ); ?>
<?php else : ?>
	<?php foreach( $comments as $comment ): ?>
	<div class="blog-comment">
		Autor: [[User:<?php echo $comment["autor"]->getName() ?>|<?php echo $comment["autor"]->getName() ?>]]
		<?php echo $comment["timestamp"] ?>
		<br />
		<?php
			echo $comment["comment"]->getText();
		?>
	</div>
	<?php endforeach ?>
<?php endif ?>
</div>
