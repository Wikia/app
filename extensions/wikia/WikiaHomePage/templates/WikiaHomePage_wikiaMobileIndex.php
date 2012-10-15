<section class=wkhome>
	<h1><?= wfMsg('wikiahome-page-header-heading') ?></h1>
	<h2><?= wfMsg('wikiahome-page-header-subheading') ?></h2>
	<section class="wkhome-section wkhome-games">
		<a href="<?= wfMsg('wikiahome-hubs-videogames-url') ?>" class=wkhome-hero>
			<img class=wkhome-img src=<?= $hubImages['Video_Games'] ?>>
			<h2><?= wfMsg('wikiahome-hubs-videogames-heading') ?></h2>
		</a>
		<p><?= wfMsg('wikiahome-hubs-videogames-creative') ?></p>
	</section>
	<section class="wkhome-section wkhome-entertainment">
		<a href="<?= wfMsg('wikiahome-hubs-entertainment-url') ?>" class=wkhome-hero>
			<img class=wkhome-img src=<?= $hubImages['Entertainment'] ?>>
			<h2><?= wfMsg('wikiahome-hubs-entertainment-heading') ?></h2>
		</a>
		<p><?= wfMsg('wikiahome-hubs-entertainment-creative') ?></p>
	</section>
	<section class="wkhome-section wkhome-lifestyle">
		<a href="<?= wfMsg('wikiahome-hubs-lifestyle-url') ?>" class=wkhome-hero>
			<img class=wkhome-img src=<?= $hubImages['Lifestyle'] ?>>
			<h2><?= wfMsg('wikiahome-hubs-lifestyle-heading') ?></h2>
		</a>
		<p><?= wfMsg('wikiahome-hubs-lifestyle-creative') ?></p>
	</section>
		<section class="wkhome-section wkhome-community  wkhome-community-<?= $lang ?>">
		<a href="<?= wfMsg('wikiahome-community-column1-link') ?>" class=wkhome-hero>
			<img class=wkhome-img src="<?= $wg->BlankImgUrl ?>">
		</a>
		<p><?=wfMsg('wikiahome-community-column1-creative') ?></p>
	</section>

</section>