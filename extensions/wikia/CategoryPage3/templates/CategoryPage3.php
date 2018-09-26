<div class="category-page__members">
	<?php /** @var array $members */ ?>
	<?php foreach ( $members as $firstChar => $items ) : ?>
        <h3><?= $firstChar ?></h3>
        <ul>
			<?php foreach ( $items as $item ) : ?>
                <li><?= $item ?></li>
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
