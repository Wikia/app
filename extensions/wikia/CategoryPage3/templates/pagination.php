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
