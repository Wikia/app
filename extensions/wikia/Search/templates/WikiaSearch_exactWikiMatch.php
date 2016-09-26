<div class="exact-wiki-match">
	<h1 class="exact-wiki-match__header"><?= wfMessage('wikiasearch3-related-wiki')->escaped(); ?></h1>
	<div class="exact-wiki-match__result">
		<a href="<?= $url ?>" title="<?= $title ?>" data-event="image">
			<img src="<?= $imageURL ?>" alt="<?= $title ?>" class="exact-wiki-match__image" />
		</a>
		<div class="exact-wiki-match__content">
			<h1 class="exact-wiki-match__wiki-header">
				<a href="<?= $url ?>" data-event="title"><?= $title ?></a>
			</h1>
			<p class="exact-wiki-match__hub subtle"><?= $hub ?></p>
			<ul class="exact-wiki-match__statistics">
				<li><?= wfMessage( 'wikiasearch2-pages' )->params( $wg->Lang->shortenNumberDecorator( $pagesCount), $pagesCount )->escaped(); ?></li>
				<li><?= wfMessage( 'wikiasearch2-images' )->params( $wg->Lang->shortenNumberDecorator( $imagesCount), $imagesCount )->escaped(); ?></li>
				<li><?= wfMessage( 'wikiasearch2-videos' )->params( $wg->Lang->shortenNumberDecorator( $videosCount), $videosCount )->escaped(); ?></li>
			</ul>
			<p class="exact-wiki-match__wiki-description"><?= $description; ?></p>
		</div>
	</div>
	<a href="<?= $viewMoreWikisLink ?>" data-event="view-more"><?= wfMessage('wikiasearch3-view-more-wikis')->escaped(); ?> <?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-icon wds-icon-small exact-wiki-match__arrow' ); ?></a>
</div>
