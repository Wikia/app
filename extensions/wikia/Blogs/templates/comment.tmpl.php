<?php
	if( $list ):
?>
<a name="comments"></a>
<h2 class="wikia_header"><?php echo wfMsg("blog-comments") ?></h2>
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
		<div class="blog-comment">
		<a name="<?php echo isset( $comment["anchor"][2] ) ? $comment["anchor"][2] : "" ?>"></a>
		<div class="comment_avatar">
			<?php echo $comment["avatar"] ?>
		</div>
		<div class="comment">
			<div class="details">
				<strong><?php echo $comment["sig"] ?></strong>
				<span class="timestamp"><?php echo $comment["timestamp"] ?></span>
			</div>
			<?php
				echo $comment["text"];
			?>
		</div>
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
