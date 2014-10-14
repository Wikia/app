<?
class MarketingToolboxTop10listModel extends WikiaModel {
	public function getWikiListByCategoryId($langCode, $categoryId, $limit = 10) {
		$date = new DateTime();
		$maxDate = $date->format('Y-m-d');
		$date->modify('-30 days');
		$minDate = $date->format('Y-m-d');

		$list = DataMartService::getTopCategoriesWikisByPageviews(
			$categoryId,
			'2011-12-06',//$minDate, TODO revert this variable after story review (we dont have actual data)
			$maxDate,
			$langCode,
			null,
			$limit
		);

		$out = array();
		foreach ($list as $wikiId => $pageViews) {
			$out[$wikiId] = WikiFactory::getWikiByID($wikiId)->city_title;
		}
		return $out;
	}
}