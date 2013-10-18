<?
class SpecialPromoteHooks {
	public static function onFileDeleteComplete($file, $oldimage, $page) {
		global $wgCityId, $wgContLang;

		$visualization = new CityVisualization();
		$visualization->removeImageFromReviewByName($wgCityId, $page->getTitle()->getText(), $wgContLang->getCode());
		$visualization->purgeWikiPromoteDataCache($wgCityId, $wgContLang->getCode());
		return true;
	}
}
