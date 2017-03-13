<div class="pph-article-header">
	<div class="pph-article-title">
		<?php if ( count( $visibleCategories ) ): ?>
			<div class="pph-categories">
				in:&nbsp;
				<span class="pph-category-links">
					<?php foreach($visibleCategories as $i => $category): ?>
						<?php if ($i === $visibleCategoriesLength - 1 && count($moreCategories) === 0): ?>
							<?= $category ?>
						<?php else: ?>
							<?= $category ?>,
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if($moreCategoriesLength > 0): ?>
						<a href="#">and <?= $moreCategoriesLength ?> more</a>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>
		<h1><?= $title ?></h1>
	</div>
	<div class="pph-article-contribution">
		<div class="pph-languages">
			English
			<?= DesignSystemHelper::renderSvg(
				'wds-icons-dropdown-tiny',
				'wds-icon wds-icon-tiny'
			) ?>
		</div>
		<div class="pph-contribution-buttons">
			<div class="pph-button-group">
				<a href="#" class="pph-button">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-pencil',
						'wds-icon wds-icon-tiny pph-button-icon'
					) ?>
					Edit
				</a>
				<a href="#" class="pph-button pph-button-chevron">
					<?= DesignSystemHelper::renderSvg(
						'wds-icons-dropdown-tiny',
						'wds-icon wds-icon-tiny pph-local-nav-chevron'
					) ?>
				</a>
			</div>
			<a href="#" class="pph-button pph-button-secondary">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-reply-tiny',
					'wds-icon wds-icon-tiny pph-button-icon'
				) ?>
				Talk
			</a>
			<a href="#" class="pph-button pph-button-secondary">
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-share-small',
					'wds-icon wds-icon-tiny pph-button-icon'
				) ?>
				Share
			</a>
		</div>
	</div>
</div>
