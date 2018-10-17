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
								'wds-icon wds-icon-small category-page__member-left-icon'
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
