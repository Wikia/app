<?php
/**
 * Created by PhpStorm.
 * User: krzychu
 * Date: 22.05.14
 * Time: 10:52
 */

class PopularArticlesModel {

	protected function lastRollupDate(){

		$now = strtotime('last Sunday');
		return date('Y-m-d',$now);
	}

	public function getArticles($wikiId) {
		//TODO: FILTER IN SOLR!!!!
		//TODO: REFACTOR
		//TODO: REMOVE MAIN PAGES
		//TODO: USE \Wikia\Search\Services\FeedEntitySearchService
		global $wgDatamartDB;
		$wikis = [$wikiId];

		$rec_list = [];
		foreach ($wikis as $community) {
			$pages = [];
			$sdb = wfGetDB( DB_SLAVE, [], WikiFactory::IDtoDB( $community ) );
			$ddb = wfGetDB( DB_SLAVE, [], $wgDatamartDB );

			$result = $sdb->query( 'select page_id,page_touched
									from page where page_namespace in (0)
									order by page_latest desc
									limit 100' );

			while ($row = $result->fetchObject()) {
				$service = new SolrDocumentService();
				$service->setArticleId($row->page_id );
				$service->setWikiId( $community );
				$urlField = Wikia\Search\Utilities::field( 'url' );
				$qualityField = Wikia\Search\Utilities::field( 'article_quality_i' );
				$document = $service->getResult();

				$sql = 'select * from rollup_wiki_article_pageviews where wiki_id = ' . (int)$community . ' and period_id = 2 and namespace_id = 0 and time_id="'.$this->lastRollupDate().'" and article_id=' . (int)$row->page_id . ' ';

				$stats = $ddb->query( $sql );
				$stats_record = $stats->fetchObject();
				$pageviews = intval( $stats_record->pageviews );

				if (($document !== null) && (isset($document[$urlField]) && (isset($document[$qualityField])) && intval( $document[$qualityField] ) >= 80
					)) {
					$pages[] = array("url" => $document[$urlField], "wikia_id"=>$community, "page_id"=>$row->page_id );
					$touches [] = $row->page_touched;
					$pvs [] = $pageviews;
				}
			}
			$sdb->close();
			array_multisort( $pvs, SORT_DESC, SORT_NUMERIC, $pages );
			$rec_list = array_merge( $rec_list, array_slice( $pages, 0, 200 ) );
		}

		return $rec_list;

	}
} 