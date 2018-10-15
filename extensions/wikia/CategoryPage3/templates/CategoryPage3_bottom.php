<?php if ( !empty( $trendingPages ) ) : ?>
	<div class="category-page__trending-pages-header">Trending pages</div>
	<ul class="category-page__trending-pages">
		<?php foreach ( $trendingPages as $trendingPage ) : ?>
			<li class="category-page__trending-page">
				<a href="<?= $trendingPage['url'] ?>">
					<figure>
						<img src="<?= Sanitizer::encodeAttribute( $trendingPage['thumbnail'] ); ?>"
							 srcset="<?= CategoryPage3::getSrcset( $trendingPage['thumbnail'] ) ?>"
							 sizes="auto"
							 alt="<?= Sanitizer::encodeAttribute( $trendingPage['title'] ); ?>"
							 class="category-page__trending-page-thumbnail"
						>
						<figcaption class="category-page__trending-page-title"><?= htmlspecialchars( $trendingPage['title'] ) ?></figcaption>
					</figure>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
<p class="category-page__total-number">
	<?= wfMessage( 'category-page3-total-number', $totalNumberOfMembers )->escaped() ?>
</p>
<div class="category-page__members">
	<?php /** @var array $membersGroupedByChar */ ?>
	<?php foreach ( $membersGroupedByChar as $firstChar => $members ) : ?>
		<?php if ( $firstChar !== ' ' ): ?>
			<div class="category-page__first-char">
				<?= htmlspecialchars( $firstChar ) ?>
			</div>
		<?php endif; ?>
        <ul class="category-page__members-for-char">
			<?php foreach ( $members as $member ) : ?>
				<?php /** @var CategoryPage3Member $member */ ?>
				<li class="category-page__member<?= $member->isBreakColumnAfter() ? ' category-page__member-break-column-after' : '' ?>">
					<div class="category-page__member-left">
						<?php if ( $member->isSubcategory() ) : ?>
							<?= DesignSystemHelper::renderSvg(
								'wds-icons-pages-small',
								'wds-icon-small category-page__member-left-icon'
							) ?>
						<?php endif; ?>
						<?php if ( $member->getImage() ) : ?>
							<img src="<?= wfBlankImgUrl() ?>"
								 data-src="<?= Sanitizer::encodeAttribute( $member->getImage() ); ?>"
								 alt="<?= Sanitizer::encodeAttribute( $member->getTitle()->getText() ); ?>"
								 class="category-page__member-thumbnail <?= Sanitizer::encodeAttribute( ImageLazyLoad::LAZY_IMAGE_CLASSES ) ?>"
								 onload="<?= Sanitizer::encodeAttribute( ImageLazyLoad::IMG_ONLOAD ) ?>"
							>
							<noscript><img src="<?= Sanitizer::encodeAttribute( $member->getImage() ); ?>"
								 alt="<?= Sanitizer::encodeAttribute( $member->getTitle()->getText() ); ?>"
								 class="category-page__member-thumbnail"
							></noscript>
						<?php endif; ?>
					</div>
					<?= Linker::linkKnown( $member->getTitle(), null, [ 'class' => 'category-page__member-link' ] ) ?>
				</li>
			<?php endforeach; ?>
        </ul>
	<?php endforeach; ?>
</div>
<?php /** @var CategoryPage3Pagination $pagination */ ?>
<?php if ( !$pagination->isEmpty() ) : ?>
    <div class="category-page__pagination">
		<?php if ( !empty( $pagination->getFirstPageUrl() ) ): ?>
            <a href="<?= $pagination->getFirstPageUrl() ?>" class="wds-button wds-is-text">
                <?= wfMessage( 'category-page3-pagination-first' )->escaped() ?>
            </a>
		<?php endif; ?>
		<?php if ( !empty( $pagination->getPrevPageUrl() ) ): ?>
            <a href="<?= $pagination->getPrevPageUrl() ?>" class="category-page__pagination-prev wds-button wds-is-secondary">
				<?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny' ); ?>
				<span><?= wfMessage( 'category-page3-pagination-previous' )->escaped() ?></span>
            </a>
		<?php endif; ?>
		<?php if ( !empty( $pagination->getNextPageUrl() ) ): ?>
            <a href="<?= $pagination->getNextPageUrl() ?>" class="category-page__pagination-next wds-button wds-is-secondary">
				<span><?= wfMessage( 'category-page3-pagination-next' )->escaped() ?></span>
				<?= DesignSystemHelper::renderSvg( 'wds-icons-menu-control-tiny', 'wds-icon wds-icon-tiny' ); ?>
            </a>
		<?php endif; ?>
		<?php if ( !empty( $pagination->getLastPageUrl() ) ): ?>
            <a href="<?= $pagination->getLastPageUrl() ?>" class="wds-button wds-is-text">
				<?= wfMessage( 'category-page3-pagination-last' )->escaped() ?>
            </a>
		<?php endif; ?>
    </div>
<?php endif; ?>
