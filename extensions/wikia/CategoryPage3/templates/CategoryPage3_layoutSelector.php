<ul class="category-layout-selector">
	<li class="category-layout-selector__information"
		title="<?= Sanitizer::encodeAttribute( wfMessage( 'category-page3-layout-selector-information' )->escaped() ) ?>">
		<?= DesignSystemHelper::renderSvg( 'wds-icons-information', 'wds-icon wds-icon-small' ); ?>
	</li>

	<?php /** @var string $currentLayout */ ?>
	<li title="<?= Sanitizer::encodeAttribute( wfMessage( 'category-page3-layout-selector-mediawiki' )->escaped() ) ?>"
		class="category-layout-selector__item<?= $currentLayout === CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI ? ' is-active' : '' ?>"
		data-category-layout="<?= CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI ?>">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-bullet-list-small',
			'category-layout-selector__icon wds-icon wds-icon-small'
		) ?>
	</li>
	<li title="<?= Sanitizer::encodeAttribute( wfMessage( 'category-page3-layout-selector-category-exhibition' )->escaped() ) ?>"
		class="category-layout-selector__item<?= $currentLayout === CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION ? ' is-active' : '' ?>"
		data-category-layout="<?= CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_EXHIBITION ?>">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-grid-small',
			'category-layout-selector__icon wds-icon wds-icon-small'
		) ?>
	</li>
	<li title="<?= Sanitizer::encodeAttribute( wfMessage( 'category-page3-layout-selector-category-page3' )->escaped() ) ?>"
		class="category-layout-selector__item<?= $currentLayout === CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3 ? ' is-active' : '' ?>"
		data-category-layout="<?= CategoryPageWithLayoutSelector::LAYOUT_CATEGORY_PAGE3 ?>">
		<?= DesignSystemHelper::renderSvg(
			'wds-icons-pages-small',
			'category-layout-selector__icon wds-icon wds-icon-small'
		) ?>
	</li>
</ul>
