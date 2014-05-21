<?php
class TVEpisodePremiereService extends WikiaService {

	const tvrage_rss_yesterday = "http://www.tvrage.com/myrss.php?class=scripted&date=yesterday";
	const tvrage_rss_today = "http://www.tvrage.com/myrss.php?class=scripted&date=today";

	const MIN_ARTICLE_QUALITY = 30;

	/* @var Solarium_Client $solariumClient  */
	protected $solariumClient = null;

	private function getSolariumClient() {
		if (empty($this->solariumClient)) {
		$config = (new Wikia\Search\QueryService\Factory)->getSolariumClientConfig();
		$this->solariumClient = new Solarium_Client($config);
		}
		return $this->solariumClient;
	}

	private function parseTitle($episodeRssTitle) {
		$episodeRssTitle = str_replace("- ", "", trim($episodeRssTitle));
		$titleArr = explode(" (", $episodeRssTitle);
		$parsed = array(
			"title" => $titleArr[0],
			"series" => "",
			"episode" => ""
		);
		if ( count($titleArr) > 1) {
			$epData = explode("x", trim($titleArr[1], ")"));
			$parsed['series'] = $epData[0];
			$parsed['episode'] = $epData[1];
		}
		return $parsed;
	}

	public function getTVEpisodes() {
		$data = simplexml_load_file( self::tvrage_rss_yesterday) ;
		$elems = $data->children();
		$episodes = [];
		foreach ($elems->children() as $elem) {
			if (!empty($elem->title)) {
				$EData = $this->parseTitle((string)$elem->title);
				$EData['episode_title'] = (string)$elem->description;
				if (!empty($EData['episode_title'])) {
					$episodes[] = $EData;
				}
			}
		}
		return $episodes;
	}

	public function getWikiaArticles( $episodes ) {

		foreach ( $episodes as $i => $episode ) {
			$requestData = array(
				'seriesName' => $episode['title'],
				'episodeName' => $episode['episode_title'],
				'minArticleQuality' => self::MIN_ARTICLE_QUALITY
			);
			try {
				$response = $this->sendRequest('TvApiController', 'getEpisode', $requestData );
				$episodes[$i]['wikia'] = $response->getData();
			} catch (Exception $e) {

			}
		}
		return $episodes;
	}

	public function otherArticles($wikiId) {

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
				$service->setArticleId( $row->page_id );
				$service->setWikiId( $community );
				$urlField = Wikia\Search\Utilities::field( 'url' );
				$qualityField = Wikia\Search\Utilities::field( 'article_quality_i' );
				$document = $service->getResult();

				$sql = 'select * from rollup_wiki_article_pageviews where wiki_id = ' . (int)$community . ' and period_id = 2 and namespace_id = 0 and time_id="2014-05-18" and article_id=' . (int)$row->page_id . ' ';
				$stats = $ddb->query( $sql );
				$stats_record = $stats->fetchObject();
				$pageviews = intval( $stats_record->pageviews );
				if (($document !== null) && (isset($document[$urlField]) && (isset($document[$qualityField])) && intval( $document[$qualityField] ) >= 80)) {
					$pages[] = array("url" => $document[$urlField], "wiki_id"=>$community, "article_id"=>$row->page_id );
					$touches [] = $row->page_touched;
					$pvs [] = $pageviews;
				}
			}
			$sdb->close();
			array_multisort( $pvs, SORT_DESC, SORT_NUMERIC, $pages );
			$rec_list = array_merge( $rec_list, array_slice( $pages, 0, 200 ) );
		}

		$batches = [];
		$items = 0;

		foreach ($rec_list as $item) {
			if (!is_array( $batches[$items / 5] )) {
				$batches[$items / 5] = [];
			}
			$batches[$items / 5] [] = $item;

			$items++;
		}

		return $batches;
	}

}


