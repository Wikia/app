<?php
	if( $list ):
?>
<a name="comments"></a>
<h2><?php echo wfMsg("blog-comments") ?></h2>
<div id="blog-comments" class="reset clearfix">
<?php
	endif; // $list
	if( ! $comments ):
		echo wfMsg( "blog-zero-comments" );
	else:
		echo "<ul id=\"blog-comments-ul\" >";
		foreach( $comments as $comment ):

?>
	<li>
		<a name="<?php echo isset( $comment["anchor"][2] ) ? $comment["anchor"][2] : "" ?>"></a>
		<div style="float: left;">
			<?php echo $comment["avatar"] ?>
		</div>
		<div style="float: left;">
			<strong><?php echo $comment["sig"] ?></strong>
			<?php echo $comment["timestamp"] ?>
			<br />
			<?php
				echo $comment["text"];
			?>
		</div>
		<br style="clear: both;" />
	</li>
<?php
		endforeach;
		echo "</ul>";
	endif; // comments
	if( $list )
		echo "</div>"
?>
