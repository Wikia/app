<ul class="category-layout-selector">
	<?php /** @var string $currentLayout */ ?>
	<li title="Classic Categories"
		class="category-layout-selector__item<?= $currentLayout === CategoryPage3::LAYOUT_MEDIAWIKI ? ' is-active' : '' ?>"
		data-category-layout="<?= CategoryPage3::LAYOUT_MEDIAWIKI ?>">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-bullet-list-small',
			'category-layout-selector__icon wds-icon-small'
		) ?>
	</li>
	<li title="Category Exhibition"
		class="category-layout-selector__item<?= $currentLayout === CategoryPage3::LAYOUT_CATEGORY_EXHIBITION ? ' is-active' : '' ?>"
		data-category-layout="<?= CategoryPage3::LAYOUT_CATEGORY_EXHIBITION ?>">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-grid-small',
			'category-layout-selector__icon wds-icon-small'
		) ?>
	</li>
	<li title="Dynamic Categories"
		class="category-layout-selector__item<?= $currentLayout === CategoryPage3::LAYOUT_CATEGORY_PAGE3 ? ' is-active' : '' ?>"
		data-category-layout="<?= CategoryPage3::LAYOUT_CATEGORY_PAGE3 ?>">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-pages-small',
			'category-layout-selector__icon wds-icon-small'
		) ?>
	</li>
</ul>
