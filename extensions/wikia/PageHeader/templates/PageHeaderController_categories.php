	<?php if ( $categories->hasVisibleCategories() ): ?>
		<div class="page-header__categories">
			<span class="page-header__categories__in pph-track" data-tracking="categories-top-in"><?= $categories->inCategoriesText ?>:</span>
			<span class="page-header__categories-links">
					<?= join( ', ', $categories->visibleCategories ); ?>
				 <?php if ( $categories->moreCategoriesLength > 0 ): ?>
						<div class="wds-dropdown page-header__dropdown-padding"><?= $categories->moreCategoriesSeparator ?>
						<a class="push-dropdown-down wds-dropdown__toggle"
					          data-tracking="categories-more"><?= $categories->moreCategoriesText ?></a>
							<div class="wds-dropdown__content">
								<ul class="wds-list wds-is-linked">
									<?php foreach ( $categories->moreCategories as $category ): ?>
										<li><?= $category; ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
				<?php endif; ?>
				</span>
		</div>
	<?php endif; ?>
