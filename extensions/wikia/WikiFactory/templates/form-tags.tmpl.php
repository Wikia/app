<!-- s:<?= __FILE__ ?> -->
<script type="text/javascript">
/*<![CDATA[*/
function deletechecked() {
    var answer = confirm("Delete tag?")
	return answer;
}
/*]]>*/
</script>
<h2>Tags</h2>
<div>
<?php
	if( !empty( $info ) ):
		echo $info;
	endif;
?>
	<br />
	Tags defined for this wiki:
<?php
	foreach( $tags as $id => $tag ):
		echo " <strong>{$tag}</strong><sup><a href=\"";
		echo $title->getFullUrl( array( "tag" => $id, "city" => $wiki->city_id ) );
		echo "\" class=\"wfTagRemove\" onclick=\"return deletechecked()\" >remove</a></sup> ";
	endforeach;
?>
	<br />
	<div>
	Add new tag:
	<form action="<?php echo $title->getFullUrl() ?>" method="post">
		<input type="text" name="wpTag" />
		<input type="submit" value="Add" />
	</form>
	</div>
</div>
<!-- e:<?= __FILE__ ?> -->
