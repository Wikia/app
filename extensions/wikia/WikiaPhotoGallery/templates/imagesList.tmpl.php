<table class="WikiaPhotoGalleryResults" style="display: none" type="<?= $type ?>">
	<tr>
<?php
	foreach($images as $i => $image) {
?>
			<td>
				<table style="width: 100%"><tr><td class="WikiaPhotoGallerySearchResultsCell">
					<a title="<?= htmlspecialchars($image['name']) ?>" num="<?= intval($i+1) ?>" href="#"><?= $image['thumb'] ?></a>
				</td></tr></table>
				<a class="WikiaPhotoGalleryResultsInsertLink" title="<?= htmlspecialchars($image['name']) ?>" num=<?= intval($i) ?>" href="#"><?= wfMsg('wikiaPhotoGallery-upload-filesinsert') ?></a>
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
