<div>
	<div style="border-bottom: 1px solid gray;">
		Autor: <?php echo $parser->getUserSig( $autor ) ?>
		<? echo $timestamp ?>
	</div>
	<?php
		echo $comment->getText();
	?>
</div>
<br />
