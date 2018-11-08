<?php

class CategoryPageMediawiki extends CategoryPageWithLayoutSelector {
	protected function getCurrentLayout() {
		return CategoryPageWithLayoutSelector::LAYOUT_MEDIAWIKI;
	}
}
