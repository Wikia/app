<?php $counter = 0; ?>

<?php if ( !empty( $stories ) ) : ?>
	<div class="side-articles fandom-stories RailModule">
		<h1 class="side-articles-header"><?= wfMessage( 'wikiasearch2-fandom-stories-title', count( $stories ) )->escaped(); ?></h1>
		<div>
		<?php foreach ( $stories as $story ) : ?>
			<div class="side-article side-article-<?= Sanitizer::encodeAttribute( mb_strtolower($story['vertical'], 'UTF-8') ); ?> result">
				<div class="side-article-category"><?= htmlspecialchars( $story['vertical'] ); ?></div>
				<div class="side-article-thumbnail">
					<? if ( isset( $story['image'] ) ) : ?>
						<a href="<?= Sanitizer::encodeAttribute( $story['url'] ); ?>" class="fandom-story-image" data-pos="<?= $counter ?>">
							<img src="<?= Sanitizer::encodeAttribute( $story['image'] ); ?>" />
						</a>
					<? endif; ?>
				</div>
				<div class="side-article-text">
					<a href="<?= Sanitizer::encodeAttribute( $story['url'] ); ?>" class="fandom-story-link" data-pos="<?= $counter ?>"><?= htmlspecialchars( $story['title'] ); ?></a>
					<div class="fandom-annotation">fandom</div>
				</div>
			</div>
		<?php $counter++; ?>
		<?php endforeach; ?>
		</div>
		<?php if ( !empty( $viewMoreLink ) ) : ?>
			<div class="side-articles-footer">
				<a href="<?= Sanitizer::encodeAttribute( $viewMoreLink ); ?>"><?= wfMessage( 'wikiasearch2-fandom-stories-view-more' )->escaped(); ?>  <?= DesignSystemHelper::renderSvg( 'wds-icons-arrow', 'wds-icon wds-icon-small fandom-stories__arrow' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
