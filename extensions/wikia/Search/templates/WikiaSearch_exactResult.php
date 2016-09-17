<div class="exact-match">
	<h1 class="exact-match__header">Related Wiki</h1>
	<div class="exact-match__result">
		<a href="<?= $url ?>" title="<?= $title ?>" data-pos="<?=$pos?>" data-event="search_click_wiki-<?=$thumbTracking?>">
			<img src="<?= $imageURL ?>" alt="<?= $title ?>" class="exact-match__image" />
		</a>
		<div class="exact-match__content">
			<h1 class="exact-match__wiki-header">
				<a href="<?= $url ?>" class="" data-pos="<?=$pos?>" ><?= $title ?></a>
			</h1>
			<p class="exact-match__hub subtle"><?= $hub ?></p>
			<ul class="exact-match__statistics">
				<li><?= str_replace(' ', '<br>', $pagesMsg) ?></li>
				<li><?= str_replace(' ', '<br>', $imgMsg) ?></li>
				<li><?= str_replace(' ', '<br>', $videoMsg) ?></li>
			</ul>
			<p class="exact-match__wiki-description"><?= $description; ?></p>
		</div>
	</div>
	<a href="<?= $viewMoreWikisLink ?>">View More Wikis ></a>
</div>
