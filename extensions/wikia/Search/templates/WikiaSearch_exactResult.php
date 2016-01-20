
<div class="Results exact">
	<p class="result-count subtle">
		<?= wfMsg('wikiasearch2-exact-result', '<strong>'.$title.'</strong>'); ?>
	</p>

	<div class="result">

		<?php
			$trackingData = 'class="result-link" data-pos="' . $pos . '"';
		?>

		<a href="<?= $url ?>" title="<?= $title ?>" <?= $thumbTracking
			?>>
			<img src="<?= $imageURL ?>" alt="<?= $title ?>" class="wikiPromoteThumbnail" />
		</a>
		<div class="result-description">

			<h1>
				<a href="<?= $url ?>" <?=$trackingData;?> ><?= $title ?></a>
			</h1>

			<p class="hub subtle"><?= strtoupper($hub); ?></p>
			<p class="description"><?= $description; ?></p>

			<ul class="wiki-statistics subtle">
				<li><?= $pagesMsg ?></li>
				<li><?= $imgMsg ?></li>
				<li><?= $videoMsg ?></li>
			</ul>
		</div>
	</div>
</div>