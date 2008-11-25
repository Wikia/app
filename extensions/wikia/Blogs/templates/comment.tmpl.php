<h2><?php echo wfMsg("blog-comments") ?></h2>
<div id="blog-comments" class="reset clearfix">
<?php if( ! $comments ): ?>
<?php echo wfMsg( "blog-zero-comments" ); ?>
<?php else : ?>
	<?php foreach( $comments as $comment ): ?>
	<div class="clearfix">
		<a name="<?php echo $comment["title"]->getDBkey() ?>"></a>
		<span style="float: left;">
			<?php echo $comment["avatar"] ?>
		</span>
		<div>
			<strong><?php echo $comment["sig"] ?></strong>
			<?php echo $comment["timestamp"] ?>
			<br />
			<?php
				echo $comment["text"];
			?>
		</div>
	</div>
	<br />
	<?php endforeach ?>
<?php endif ?>
</div>
