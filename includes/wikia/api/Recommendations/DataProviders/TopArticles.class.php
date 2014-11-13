<?
namespace Wikia\Api\Recommendations\DataProviders;

class TopArticles implements IDataProvider {
	public function get( $articleId, $limit ) {
		global $wgCityId, $wgContLang;

		// Yes, we need this old category name because rollups don't use new verticals
		$hubName = \WikiFactoryHub::getInstance()->getCategoryName( $wgCityId );

		$results = \DataMartService::getTopCrossWikiArticlesByPageview(
			$hubName,
			[$wgContLang->getCode()],
			null,
			$limit
		);

		foreach ( $results as $wikiSet ) {

		}
		// TODO slice correct number of elems


		// TODO
		return [[],[],[]];
	}
}
