<!-- s:<?= __FILE__ ?> -->
<h2>Tags</h2>
<div>
	Tags defined for this wiki:
<?php
foreach( $tags as $id => $tag ):
	echo "<strong>{$tag}</strong><sup>remove</sup> ";
endforeach;
?>
	<br />
	Add new tag:
	<form>
		<input type="text" />
	</form>
</div>
<!-- e:<?= __FILE__ ?> -->
