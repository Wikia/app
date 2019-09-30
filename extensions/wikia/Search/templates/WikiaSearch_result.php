<li class="result">
	<article>
		<?php

		use Wikia\Search\UnifiedSearch\UnifiedSearchPageResultItem;

		/** @var UnifiedSearchPageResultItem $result */
		if ( $result['ns'] == NS_FILE ) {
			$thumbnail = $result['thumbnail'];
		}
		?>
		<?php
		$title = $result->getText( 'title' );
		$trackingData =
			 'data-pos="' . $pos . '"' .
			' data-page-id="' . $result['pageid'] . '"' .
			' data-wiki-id="' . $result['wikiId'] . '"' .
			' data-name="' . $title . '"' .
			' data-thumbnail="' . !empty( $thumbnail ) . '"';
		?>
		<?php if ( !empty( $thumbnail ) ): ?>
		<div class="grid-1 alpha">
			<a href="<?= $result->getEscapedUrl() ?>" class="image"><img src="<?= $thumbnail ?>" class="thumbimage"/></a>
		</div>
		<div class="media-text grid-2"> <? // Open media-text div when there's a thumbnail ?>
			<?php endif; ?>
			<h1>
				<a href="<?= $result->getEscapedUrl() ?>" class="result-link" <?= $trackingData; ?>><?= $title ?></a>
			</h1>

			<?= $result->getText(); ?>

			<?php if ( empty( $inGroup ) ): ?>
				<?php if ( $scope === \Wikia\Search\Config::SCOPE_CROSS_WIKI ): ?>
					<ul>
						<li class="WikiaSearchResultItemSitename">
							<a href="<?= $result['wikiUrl']; ?>" class="result-link community-result-link" <?= $trackingData; ?>>
								<?= Language::factory( $wg->ContentLanguage )->truncate( $result['sitename'], 90 ); ?>
							</a>
						</li>
					</ul>
				<?php else: ?>
					<ul>
						<li>
							<a href="<?= $result->getEscapedUrl(); ?>" class="result-link" <?= $trackingData; ?> >
								<?= Language::factory( $wg->ContentLanguage )->truncate( $result->getTextUrl(), 90 ); ?>
							</a>
						</li>
					</ul>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( !empty( $thumbnail ) ): ?>
		</div> <? // Close media-text div when there's a thumbnail ?>
	<?php endif; ?>

	</article>
</li>
