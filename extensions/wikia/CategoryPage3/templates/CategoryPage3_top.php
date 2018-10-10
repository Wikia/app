<ul class="category-layout-selector">
	<?php /** @var string $currentLayout */ ?>
	<li class="category-layout-selector__item" title="Classic Categories">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-bullet-list-small',
			$currentLayout === CategoryPage3::LAYOUT_MEDIAWIKI ?
				'category-layout-selector__icon category-layout-selector__icon-active wds-icon-small' :
				'category-layout-selector__icon wds-icon-small'
		) ?>
	</li>
	<li class="category-layout-selector__item" title="Category Exhibition">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-grid-small',
			$currentLayout === CategoryPage3::LAYOUT_CATEGORY_EXHIBITION ?
				'category-layout-selector__icon category-layout-selector__icon-active wds-icon-small' :
				'category-layout-selector__icon wds-icon-small'
		) ?>
	</li>
	<li class="category-layout-selector__item" title="Dynamic Categories">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-pages-small',
			$currentLayout === CategoryPage3::LAYOUT_CATEGORY_PAGE3 ?
				'category-layout-selector__icon category-layout-selector__icon-active wds-icon-small' :
				'category-layout-selector__icon wds-icon-small'
		) ?>
	</li>
</ul>
