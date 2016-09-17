<div class="exact-wiki-match">
	<h1 class="exact-match__header"><?= wfMessage('wikiasearch3-related-wiki')->escaped(); ?></h1>
	<div class="exact-match__result">
		<a href="<?= $url ?>" title="<?= $title ?>" data-event="image">
			<img src="<?= $imageURL ?>" alt="<?= $title ?>" class="exact-match__image" />
		</a>
		<div class="exact-match__content">
			<h1 class="exact-match__wiki-header">
				<a href="<?= $url ?>" data-event="title"><?= $title ?></a>
			</h1>
			<p class="exact-match__hub subtle"><?= $hub ?></p>
			<ul class="exact-match__statistics">
				<li>
					<div><?= $pages['count'] ?></div>
					<div class="exact-match__statistics-message"><?= $pages['message'] ?></div>
				</li>
				<li>
					<div><?= $img['count'] ?></div>
					<div class="exact-match__statistics-message"><?= $img['message'] ?></div>
				</li>
				<li>
					<div><?= $video['count'] ?></div>
					<div class="exact-match__statistics-message"><?= $video['message'] ?></div>
				</li>
			</ul>
			<p class="exact-match__wiki-description"><?= $description; ?></p>
		</div>
	</div>
	<a href="<?= $viewMoreWikisLink ?>" data-event="view-more"><?= wfMessage('wikiasearch3-view-more-wikis')->escaped(); ?> <?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-icon wds-icon-small exact-match__arrow' ); ?></a>
</div>
