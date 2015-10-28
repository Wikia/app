<?php

/**
 * Class to get html title (the contents of <title>)
 */
class WikiaHtmlTitle {

	/**
	 * Get page title
	 * @param string $name
	 * @param boolean $isMainPage
	 * @return string
	 */
	public static function getPageTitle( $name, $isMainPage ) {
		// First apply the per-wiki template (editable by communitiess)
		if ( $isMainPage ) {
			$title = wfMessage( 'pagetitle-view-mainpage', $name )->inContentLanguage()->text();
		} else {
			$title = wfMessage( 'pagetitle', $name )->inContentLanguage()->text();
		}

		// Now apply Wikia-wide template on top of that
		$fullTitle = wfMessage( 'wikia-pagetitle', $title )->inContentLanguage()->text();

		return $fullTitle;
	}

}
