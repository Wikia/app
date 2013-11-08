<?
class SpecialPromoteHooks {
	/**
	 * Called once a file has been deleted.
	 *
	 * @param $file reference to the deleted file
	 * @param $oldimage in case of the deletion of an old image, the name of the old file
	 * @param $article in case all revisions of the file have been deleted a reference to the article associated with the file.
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/FileDeleteComplete
	 */
	public static function onFileDeleteComplete($file, $oldimage, $page) {
		/**
		 * No $page when deleting an old image ($oldimage). Nothing to do.
		 *
		 * @see FileDeleteForm::doDelete()
		 */
		if ( ! $page instanceof Page ) {
			return true;
		}

		global $wgCityId, $wgContLang;
		$visualization = new CityVisualization();
		$visualization->removeImageFromReviewByName($wgCityId, $page->getTitle()->getText(), $wgContLang->getCode());
		$visualization->purgeWikiPromoteDataCache($wgCityId, $wgContLang->getCode());
		return true;
	}
}
