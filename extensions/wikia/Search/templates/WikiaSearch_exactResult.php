
<div class="Results exact">
	<p class="result-count subtle">
		<?= wfMsg('wikiasearch2-exact-result', '<strong>'.$title.'</strong>'); ?>
	</p>

	<div class="result">

		<a href="<?= $url ?>" title="<?= $title ?>" class="wiki-thumb-tracking" data-pos="<?=$pos?>" data-event="search_click_wiki-<?=$thumbTracking?>">
			<img src="<?= $imageURL ?>" alt="<?= $title ?>" class="wikiPromoteThumbnail" />
		</a>
		<div class="result-description">

			<h1>
				<a href="<?= $url ?>" class="result-link" data-pos="<?=$pos?>" ><?= $title ?></a>
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