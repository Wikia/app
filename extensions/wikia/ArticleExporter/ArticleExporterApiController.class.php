<?php
/**
* API Controller to get article content for the taxonomy content classifier
*
* @author Lore team
* @package ArticleExporter
* @subpackage Controller
*/
class ArticleExporterApiController extends WikiaApiController {
	public function getArticles() {
		global $wgCityId;
		global $wgRequest;

		$ids = $wgRequest->getArray( 'ids' );

		$exporter = new ArticleExporter();
		$articles = $exporter->build($wgCityId, $ids);

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues( [ 'articles' => $articles ] );
	}
}
