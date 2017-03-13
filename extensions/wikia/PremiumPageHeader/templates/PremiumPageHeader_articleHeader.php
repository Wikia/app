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
						<div class="pph-dropdown-container">
							<a href="#">and <?= $moreCategoriesLength ?> more</a>
							<ul class="pph-dropdown">
								<li><a href="#">Category 1</a></li>
								<li><a href="#">Category 2</a></li>
								<li><a href="#">Category 3</a></li>
								<li><a href="#">Category 4</a></li>
								<li><a href="#">Category 5</a></li>
								<li><a href="#">Category 6</a></li>
							</ul>
						</div>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>
		<h1><?= $title ?></h1>
	</div>
	<div class="pph-article-contribution">
		<div class="pph-languages pph-dropdown-container">
			<span>
				English
				<?= DesignSystemHelper::renderSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny'
				) ?>
			</span>
			<ul class="pph-dropdown">
				<li><a href="#">Polish</a></li>
				<li><a href="#">German</a></li>
				<li><a href="#">Spanish</a></li>
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
				<div class="pph-dropdown-container">
					<a href="#" class="pph-button pph-button-chevron">
						<?= DesignSystemHelper::renderSvg(
							'wds-icons-dropdown-tiny',
							'wds-icon wds-icon-tiny pph-local-nav-chevron'
						) ?>
					</a>
					<ul class="pph-dropdown">
						<li><a href="#">Visual Editor</a></li>
						<li><a href="#">History</a></li>
						<li><a href="#">Rename</a></li>
						<li><a href="#">Delete</a></li>
						<li><a href="#">Talk</a></li>
						<li><a href="#">Talk</a></li>
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
