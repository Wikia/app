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
		$trackingData =
			'class="result-link"' . ' data-pos="' . $pos . '"' . ' data-page-id="' . $result['pageid'] . '"' .
			' data-thumbnail="' . !empty( $thumbnail ) . '"';
		?>
		<?php if ( !empty( $thumbnail ) ): ?>
		<div class="grid-1 alpha">
			<a href="<?= $result->getEscapedUrl() ?>" <?= $trackingData; ?>><img src="<?= $thumbnail ?>"/></a>
		</div>
		<div class="media-text grid-2"> <? // Open media-text div when there's a thumbnail ?>
			<?php endif; ?>
			<h1>
				<?php $title = $result->getText( 'title' ); ?>

				<a href="<?= $result->getEscapedUrl() ?>" <?= $trackingData; ?>><?= $title ?></a>
			</h1>

			<?= $result->getText(); ?>

			<?php if ( empty( $inGroup ) ): ?>
				<ul>
					<li>
						<a href="<?= $result->getEscapedUrl(); ?>" <?= $trackingData; ?> ><?= Language::factory( $wg->ContentLanguage )
								->truncate( $result->getTextUrl(), 90 ); ?></a></li>
				</ul>
			<?php endif; ?>

			<?php if ( !empty( $thumbnail ) ): ?>
		</div> <? // Close media-text div when there's a thumbnail ?>
	<?php endif; ?>

	</article>
</li>
