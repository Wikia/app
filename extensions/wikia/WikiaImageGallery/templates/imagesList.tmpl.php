<table class="WikiaImageGalleryResults" style="display: none">
	<tr>
<?php
	foreach($images as $i => $image) {
?>
			<td>
				<span><a title="<?= htmlspecialchars($image['name']) ?>" href="#"><?= $image['thumb'] ?></a></span>
				<a class="WikiaImageGalleryResultsInsertLink" title="<?= htmlspecialchars($image['name']) ?>" href="#"><?= wfMsg('wig-upload-filesinsert') ?></a>
			</td>
<?php
		// add new row every $perRow images
		if ( ($i % $perRow) == ($perRow - 1) ) {
?>
	</tr>
	<tr>
<?php
		}
	}
?>
	</tr>
</table>
