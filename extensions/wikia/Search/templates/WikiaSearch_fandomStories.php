<?php if ( !empty( $stories ) ) : ?>
	<div class="side-articles RailModule">
		<h1 class="side-articles-header"><?= wfMessage( 'wikiasearch2-fandom-stories-title', count( $stories ) ); ?></h1>
		<div>
		<?php foreach ( $stories as $story ) : ?>
			<div class="side-article side-article-<?= mb_strtolower($story['vertical'], 'UTF-8') ?> result">
				<div class="side-article-category"><?= $story['vertical'] ?></div>
				<div class="side-article-thumbnail">
					<? if ( isset( $story['image'] ) ) : ?>
						<a href="<?=$story['url']?>" data-pos="<?= $counter ?>">
							<img src="<?= $story['image'] ?>" />
						</a>
					<? endif; ?>
				</div>
				<div class="side-article-text">
					<a href="<?= $story['url'] ?>" data-pos="<?= $counter ?>"><?= $story['title'] ?></a>
					<div class="fandom-annotation">fandom</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		<?php if ( !empty( $viewMoreLink ) ) : ?>
			<div class="side-articles-footer">
				<a href="<?= $viewMoreLink ?>"><?= wfMessage( 'wikiasearch2-fandom-stories-view-more' ); ?>  <?= DesignSystemHelper::getSvg( 'wds-icons-arrow', 'wds-icon wds-icon-small fandom-stories__arrow' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
