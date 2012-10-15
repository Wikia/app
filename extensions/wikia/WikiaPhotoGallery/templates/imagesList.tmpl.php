<ul class="WikiaPhotoGalleryResults" type="<?= $type ?>" style="display: none">
<?php
	if (!empty($images)) {
		foreach($images as $i => $image) {
			$id = "WikiaPhotoGalleryResults-{$type}-{$i}";
?>
	<li title="<?= htmlspecialchars($image['name']) ?>">
		<label for="<?= $id ?>" style="background-image: url(<?= $image['thumb'] ?>)"></label>
		<input id="<?= $id ?>" type="checkbox" value="<?= htmlspecialchars($image['name']) ?>" />
	</li>
<?php
		}
	}
?>
</ul>
