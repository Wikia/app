<?php

class CategoryPageMediawiki extends CategoryPageWithLayoutSelector {
	// CategoryTree extension is enabled everywhere so let's use it
	protected $mCategoryViewerClass = 'CategoryTreeCategoryViewer';

	protected function getCurrentLayout() {
		return CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI;
	}
}
