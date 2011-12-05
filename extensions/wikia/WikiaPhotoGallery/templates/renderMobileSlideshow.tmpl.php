<aside class=<?= $class ?> id=<?= $id ?> hash=<?= $hash ?>
		<?php
		echo "data-image-count=".count($images);
		foreach ( $images as $key => $val) {
			echo " data-slideshow-image-id-{$key}={$val}";
		}
		?>
	>
	<img class=placeholderImg src=<?=$images[0]?>>
	<footer><?= $counterValue ?></footer>
</aside>