<div class="exact-wiki-match">
	<h1 class="exact-wiki-match__header"><?= wfMessage('wikiasearch3-related-wiki')->escaped(); ?></h1>
	<div class="exact-wiki-match__result">
		<?php
		$trackingData = 'data-pos="' . 0 . '"' .
				   ' data-wiki-id="' . $community['id'] . '"' .
				   ' data-thumbnail="' . isset( $community['thumbnail'] ) . '"';
		?>
		<a href="<?= Sanitizer::encodeAttribute( $community['url'] ) ?>" title="<?= Sanitizer::encodeAttribute( $community['name'] ) ?>"
		   data-event="image">
			<img src="<?= Sanitizer::encodeAttribute( $community['thumbnail'] ) ?>" alt="<?= Sanitizer::encodeAttribute(
				$community['name'] ) ?>" <?= $trackingData; ?> data-name="thumbnail"
				 class="exact-wiki-match__image" />
		</a>
		<div class="exact-wiki-match__content">
			<h1 class="exact-wiki-match__wiki-header">
				<a href="<?= Sanitizer::encodeAttribute( $community['url'] ) ?>" data-event="title"
					<?= $trackingData; ?> data-name="<?= Sanitizer::encodeAttribute( $community['name'] ) ?>">
					<?= Sanitizer::encodeAttribute( $community['name'] ) ?>
				</a>
			</h1>
			<p class="exact-wiki-match__hub subtle"><?= htmlspecialchars( $community['hub'] ) ?></p>
			<ul class="exact-wiki-match__statistics">
				<?
					$shortenedPageCount = $wg->Lang->shortenNumberDecorator( $community['pageCount'] );
					$shortenedImageCount = $wg->Lang->shortenNumberDecorator( $community['imageCount'] );
					$shortenedVideoCount = $wg->Lang->shortenNumberDecorator( $community['videoCount'] );
				?>
				<li><?= wfMessage( 'wikiasearch2-pages' )->rawParams( HTML::element( 'div', [], $shortenedPageCount->decorated ) )->params( $shortenedPageCount->rounded )->escaped(); ?></li>
				<li><?= wfMessage( 'wikiasearch2-images' )->rawParams( HTML::element( 'div', [], $shortenedImageCount->decorated ) )->params( $shortenedImageCount->rounded )->escaped(); ?></li>
				<li><?= wfMessage( 'wikiasearch2-videos' )->rawParams( HTML::element( 'div', [], $shortenedVideoCount->decorated ) )->params( $shortenedVideoCount->rounded )->escaped(); ?></li>
			</ul>
			<p class="exact-wiki-match__wiki-description"><?= \Wikia\Search\Result::limitTextLength( htmlspecialchars
				( $community['description'] ), $community['descriptionWordLimit'] ); ?></p>
		</div>
	</div>
	<a href="<?= Sanitizer::encodeAttribute( $community['viewMoreWikisLink'] ) ?>" data-event="view-more"><?= wfMessage
		('wikiasearch3-view-more-wikis')->escaped(); ?> <?= DesignSystemHelper::renderSvg( 'wds-icons-arrow', 'wds-icon wds-icon-small exact-wiki-match__arrow' ); ?></a>
</div>
