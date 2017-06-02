<?php if ( $categories->hasVisibleCategories() ): ?>
	<div class="page-header__main-categories">
		<span class="page-header__main-categories-in" data-tracking="categories-top-in"><?= $categories->inCategoriesText ?>:</span>
		<div class="page-header__main-categories-links">
			<?= $categories->visibleCategoriesHTML ?>
			<?php if ( $categories->hasMoreCategories() ): ?>
				<div class="wds-dropdown page-header__main-categories-dropdown">
					<a class="push-dropdown-down wds-dropdown__toggle" data-tracking="categories-more"><?= $categories->moreCategoriesText ?></a>
					<div class="wds-dropdown__content page-header__main-categories-dropdown-content">
						<ul class="wds-list wds-is-linked">
							<?php foreach ( $categories->moreCategories as $i => $category ): ?>
								<li><a href="<?= $category->getLocalURL() ?>" data-tracking="categories-top-more-<?= $i ?>"><?= $category->getText(); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
