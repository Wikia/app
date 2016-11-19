<?php
/**
 * Special handling for category pages
 */
class WikiCategoryPage extends WikiPage {

	/**
	 * Don't return a 404 for categories in use.
	 * In use defined as: either the actual page exists
	 * or the category currently has members.
	 *
	 * @return bool
	 */
	public function hasViewableContent() {
		/* Wikia change - begin */
		$cat = Category::newFromTitle( $this->mTitle );
		return $cat->hasMembers();
		/* Wikia change - end */
	}

}
