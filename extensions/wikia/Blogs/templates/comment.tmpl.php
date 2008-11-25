<?php
	if( $list ):
?>
<h2><?php echo wfMsg("blog-comments") ?></h2>
<div id="blog-comments" class="reset clearfix">
<?php
	endif; // $list
	if( ! $comments ):
		echo wfMsg( "blog-zero-comments" );
	else:
		foreach( $comments as $comment ):
?>
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
<?php
		endforeach;
	endif; // comments
	if( $list )
		echo "</div>"
?>
