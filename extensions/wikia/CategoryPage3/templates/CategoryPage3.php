<p class="wds-font-size-base wds-font-weight-bold wds-text-transform-uppercase">
	All items (<?= $totalNumberOfMembers; ?>)
</p>
<div class="category-page__members">
	<?php /** @var array $membersGroupedByChar */ ?>
	<?php foreach ( $membersGroupedByChar as $firstChar => $members ) : ?>
        <div class="category-page__first-char wds-font-size-xl wds-font-weight-bold"><?= htmlspecialchars( $firstChar ) ?></div>
        <ul class="category-page__members-for-char">
			<?php foreach ( $members as $member ) : ?>
				<?php /** @var CategoryPage3Member $member */ ?>
				<li class="category-page__member<?= $member->isBreakColumnAfter() ? ' category-page__member-break-column-after' : '' ?>">
					<div class="category-page__member-left">
						<?php if ( $member->isSubcategory() ) : ?>
							<?= DesignSystemHelper::renderSvg('wds-icons-pages-small', 'wds-icon-small') ?>
						<?php endif; ?>
						<?php if ( $member->getImage() ) : ?>
							<img src="<?= Sanitizer::encodeAttribute( $member->getImage() ); ?>"
								 alt="<?= Sanitizer::encodeAttribute( $member->getTitle()->getText() ); ?>"
								 class="category-page__member-thumbnail"
							>
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
                First
            </a>
		<?php endif; ?>
		<?php if ( !empty( $pagination->getPrevPageUrl() ) ): ?>
            <a href="<?= $pagination->getPrevPageUrl() ?>" class="wds-button">
                < Previous
            </a>
		<?php endif; ?>
		<?php if ( !empty( $pagination->getNextPageUrl() ) ): ?>
            <a href="<?= $pagination->getNextPageUrl() ?>" class="wds-button">
                Next >
            </a>
		<?php endif; ?>
		<?php if ( !empty( $pagination->getLastPageUrl() ) ): ?>
            <a href="<?= $pagination->getLastPageUrl() ?>" class="wds-button wds-is-text">
                Last
            </a>
		<?php endif; ?>
    </div>
<?php endif; ?>
