<?php if ( $categories->hasVisibleCategories() ): ?>
	<div class="page-header__categories">
		<span class="page-header__categories-in" data-tracking="categories-top-in"><?= $categories->inCategoriesText ?>:</span>
		<div class="page-header__categories-links">
			<?= $categories->visibleCategoriesHTML ?>
			<?php if ( $categories->hasMoreCategories() ): ?>
				<div class="wds-dropdown page-header__categories-dropdown">
					<a class="wds-dropdown__toggle" data-tracking="categories-more"><?= $categories->moreCategoriesText ?></a>
					<div class="wds-dropdown__content page-header__categories-dropdown-content wds-is-left-aligned">
						<ul class="wds-list wds-is-linked">
							<?php foreach ( $categories->moreCategories as $i => $category ): ?>
								<li>
									<?= Html::element(
										'a',
										[
											'href' => $category->getLocalURL(),
											'data-tracking' => 'categories-top-more-' . $i
										],
										$category->getText()
									) ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
