<?
namespace Wikia\Api\Recommendations\DataProviders;

class TopArticles implements IDataProvider {
	public function get( $articleId, $limit ) {

		$results = \DataMartService::getTopCrossWikiArticlesByPageview( 'games', ['en'], null, 10 );
		var_dump($results);die;
		// TODO
		return [[],[],[]];
	}
}
