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
		<div class="pph-languages pph-button-dropdown-container">
			<span>
				English
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny'
				) ?>
			</span>
			<ul class="pph-button-dropdown">
				<li class="pph-button-dropdownu-item"><a href="#">Polish</a></li>
				<li class="pph-button-dropdown-item"><a href="#">German</a></li>
				<li class="pph-button-dropdown-item"><a href="#">Spanish</a></li>
			</ul>
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
				<div class="pph-button-dropdown-container">
					<a href="#" class="pph-button pph-button-chevron">
						<?= DesignSystemHelper::renderSvg(
							'wds-icons-dropdown-tiny',
							'wds-icon wds-icon-tiny pph-local-nav-chevron'
						) ?>
					</a>
					<ul class="pph-button-dropdown">
						<li class="pph-button-dropdownu-item"><a href="#">Visual Editor</a></li>
						<li class="pph-button-dropdown-item"><a href="#">History</a></li>
						<li class="pph-button-dropdown-item"><a href="#">Rename</a></li>
						<li class="pph-button-dropdown-item"><a href="#">Delete</a></li>
						<li class="pph-button-dropdown-item"><a href="#">Talk</a></li>
						<li class="pph-button-dropdown-item"><a href="#">Talk</a></li>
					</ul>
				</div>
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
