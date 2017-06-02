<?php if ( $categories->hasVisibleCategories() ): ?>
	<div class="page-header__categories">
		<span class="page-header__categories__in" data-tracking="categories-top-in"><?= $categories->inCategoriesText ?>:</span>
		<div class="page-header__categories-links">
			<?= $categories->visibleCategories ?>
			<?php if ( $categories->hasMoreCategories() ): ?>
				<div class="wds-dropdown page-header__dropdown-padding">
					<a class="push-dropdown-down wds-dropdown__toggle" data-tracking="categories-more"><?= $categories->moreCategoriesText ?></a>
					<div class="wds-dropdown__content">
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
