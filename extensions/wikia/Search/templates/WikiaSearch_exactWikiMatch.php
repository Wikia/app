<div class="exact-wiki-match">
	<h1 class="exact-wiki-match__header"><?= wfMessage('wikiasearch3-related-wiki')->escaped(); ?></h1>
	<div class="exact-wiki-match__result">
		<a href="<?= Sanitizer::encodeAttribute( $url ) ?>" title="<?= Sanitizer::encodeAttribute( $title ) ?>" data-event="image">
			<img src="<?= Sanitizer::encodeAttribute( $imageURL ) ?>" alt="<?= Sanitizer::encodeAttribute( $title ) ?>" class="exact-wiki-match__image" />
		</a>
		<div class="exact-wiki-match__content">
			<h1 class="exact-wiki-match__wiki-header">
				<a href="<?= Sanitizer::encodeAttribute( $url ) ?>" data-event="title"><?= Sanitizer::encodeAttribute( $title ) ?></a>
			</h1>
			<p class="exact-wiki-match__hub subtle"><?= htmlspecialchars( $hub ) ?></p>
			<ul class="exact-wiki-match__statistics">
				<li><?= wfMessage( 'wikiasearch2-pages' )->rawParams( HTML::element( 'div', [], $wg->Lang->shortenNumberDecorator( $pagesCount) ) )->params( $pagesCount )->escaped(); ?></li>
				<li><?= wfMessage( 'wikiasearch2-images' )->rawParams( HTML::element( 'div', [], $wg->Lang->shortenNumberDecorator( $imagesCount) ) )->params( $imagesCount )->escaped(); ?></li>
				<li><?= wfMessage( 'wikiasearch2-videos' )->rawParams( HTML::element( 'div', [], $wg->Lang->shortenNumberDecorator( $videosCount) ) )->params( $videosCount )->escaped(); ?></li>
			</ul>
			<p class="exact-wiki-match__wiki-description"><?= htmlspecialchars( $description ); ?></p>
		</div>
	</div>
	<a href="<?= Sanitizer::encodeAttribute( $viewMoreWikisLink ) ?>" data-event="view-more"><?= wfMessage('wikiasearch3-view-more-wikis')->escaped(); ?> <?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-icon wds-icon-small exact-wiki-match__arrow' ); ?></a>
</div>
