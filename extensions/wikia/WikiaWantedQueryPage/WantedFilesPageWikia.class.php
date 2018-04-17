<?php
/**
 * Class WantedFilesPageWikia
 *
 * Wikia specific functionality for the WantedFilesPage
 *
 * @author Garth <garth@wikia-inc.com>
 * @author Liz <liz@wikia-inc.com>
 * @author Saipetch <saipetch@wikia-inc.com>
 * @author Kenneth <kenneth@wikia-inc.com>
 */
class WantedFilesPageWikia extends WantedFilesPage {

	/**
	 * Returns additional query conditions to use when constructing the wanted files SQL.  In this case we
	 * are adding:
	 * - the ability to filter out specific files by file name.
	 *
	 * @return array
	 */
	public function getQueryInfo() {
		global $wgExcludedWantedFiles;

		$queryInfo = parent::getQueryInfo();

		if ( !empty($wgExcludedWantedFiles) && is_array($wgExcludedWantedFiles) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$queryInfo['conds'][] = "il_to not in (" . $dbr->makeList($wgExcludedWantedFiles) . ") ";
		}

		return $queryInfo;
	}

	/**
	 * Override the default formatResult method in the parent.  The difference is that the parent will display
	 * titles that turn out to pass the 'isKnown' test with a strikethrough whereas we will simply not display
	 * these results in this version.
	 * @param Skin $skin - The skin used to display this special page
	 * @param Result $result - The result line to format
	 * @return string - The HTML to use for this result line
	 */
	public function formatResult( $skin, $result ) {
		$title = Title::makeTitleSafe( $result->namespace, $result->title );
		if ( $title instanceof Title && $title->isKnown() ) {
			return '';
		}

		return parent::formatResult( $skin, $result );
	}
}