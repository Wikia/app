<?php

class ImportantArticles extends WikiaModel {

	protected $db;
	protected $wikiId;
	protected $api;
	protected $app;
	protected $wikiTopics;

	const MAX_ELEM_IN_RANK = 150;

	public function __construct( $wikiId ) {

		$dbName = false;
		if ( !empty( $wikiId ) ) {
			$wikiInfo = WikiFactory::getWikiByID( $wikiId );
			$dbName = $wikiInfo->city_dbname;
		}
		$this->db = $this->getWikiDB( DB_SLAVE, $dbName );
		$this->wikiId = $wikiId;
		$this->api = new EntityAPIClient();
		$this->api->setLogLevel( 5 );
		$this->app = F::app();
	}

	protected function getScoreFromPosition( $position, $totalCnt ) {
		return $totalCnt/$position;
	}

	public function getCommonPrefix() {
		$wikiTopics = $this->getMostImportantTopics();
		$names = array();
		foreach ( $wikiTopics as $topic ) {
						$names[] = $topic['name'];
		}

		$commonPrefix = new CommonPrefix();
		$prefix = $commonPrefix->longest( $names );

		return $prefix;
	}

	public function getImportantPhrasesByInterlinks() {

		$topLinks = $this->getTopLinks();
		$wikiTopics = $this->getWikiTopics();
		$topLinksSanitized = array();
		foreach ( $topLinks as $link ) {
			$topLinksSanitized[] = str_replace( "_", " ", $link['title'] );
		}
		unset( $topLinks );

		$result = $this->fetchCommon( $wikiTopics, $topLinksSanitized, "name" );
		return $result;
	}

	private function fetchCommon( &$wikiTopics, &$searchArray, $searchKey = "name" ) {

		$searchArrayCnt = count( $searchArray );
		$result = array();
		foreach ( $wikiTopics as $topic ) {
			$entry = array(
				"pageId" => $topic->pageId
			);
			foreach ( $topic->entities as $entity ) {
				if ( in_array( $entity->type, array('movie', 'game', 'book') ) ) {
					$entry["name"] = $entity->name;
					$entry["type"] = $entity->type;
					$names[] = $entity->name;
				}
			}
			$entry["score"] = 0;
			if ( isset( $entry['name'] ) ) {
				$poz = array_search( $entry[ $searchKey ], $searchArray );
			} else {
				$poz = false;
			}
			if ( $poz !== false ) {
				$entry["score"] += $this->getScoreFromPosition( $poz+1, $searchArrayCnt );
			}
			if ( isset( $entry["name"]) && $entry["score"] > 0 ) {
				$result[] = $entry;
			}
		}
		$this->sortResult( $result );

		return $result;
	}

	public function getImportantPhrasesByDomainNames() {

	}

	public function getImportantPhrasesByRedirects() {

	}

	public function getMostImportantTopics() {
		// ByTopPages + ByRedirect + ByInterlinks() + DomainNames()
		$topPages = $this->getImportantPhrasesByTopPages();
		$pageLinks = $this->getImportantPhrasesByInterlinks();
		$merged = array();
		foreach ( $topPages as $r ) {
			$merged[ $r['name'] ] = $r;
		}
		foreach ( $pageLinks as $r ) {
			if ( isset( $merged[ $r['name'] ] ) ) {
				$merged[ $r['name'] ]['score'] += $r['score'];
			} else {
				$merged[ $r['name'] ] = $r;
			}
		}
		$values = array_values( $merged );
		unset( $merged );
		$this->sortResult( $values );
		return array_slice( $values, 0, 15 );
	}

	public function getImportantPhrasesByTopPages() {

		$wikiTopics = $this->getWikiTopics();
		$topArticles = $this->getTopWikiArticles();
		$result = $this->fetchCommon( $wikiTopics, $topArticles, "pageId" );
		return $result;
	}

	protected function sortResult( &$result ) {
		$scores = array();
		if ( is_array( $result ) ) {
			foreach ( $result as $k => $r ) {
				$scores[ $k ] = $r["score"];
			}
			array_multisort( $scores, SORT_DESC, $result );
		}
	}

	public function getWikiTopics() {
		if ( empty( $this->wikiTopics ) ) {
			$topics = $this->api->get( $this->api->getDecisionsEndpoint( $this->wikiId ) );
			$this->wikiTopics = $topics['response'];
		}
		return $this->wikiTopics;
	}

	public function getTopWikiArticles() {

		if ( $this->wikiId == 3125 && $this->app->wg->develEnvironment ) { // mock data for devbox
			return array(555118, 515985, 1000000001, 8917, 538188, 555190, 557683, 462105, 558329, 558347, 352876, 508820, 558551, 558346, 522515, 558349, 508610, 508604, 464461, 9947, 499151, 11095, 558620, 508883, 16585, 494944, 555346, 28027, 527672, 12581, 542097, 508274, 558004, 557802, 478287, 7396, 330385, 542128, 510727, 347365, 540972, 541716, 2793, 558453, 7582, 12260, 540187, 539434, 66998, 510708, 515860, 557859, 12655, 231308, 8241, 383993, 12645, 386142, 542154, 1000000005, 295154, 558059, 508034, 508121, 525634, 11092, 516886, 11420, 1881, 3126, 11945, 102675, 346620, 265165, 526114, 340164, 557784, 463607, 13012, 141183, 539437, 557807, 2051, 558103, 197844, 2502, 2519, 542106, 555347, 87058, 555348, 539432, 557785, 527578, 305450, 539436, 499717, 479686, 336449, 514548, 11021, 246281, 526287, 11093, 463600, 495341, 103097, 542052, 540180, 10996, 7991, 555349, 10391, 558466, 71619, 14889, 17924, 555350, 1000000002, 8740, 273630, 344941, 522500, 11094, 1000000000, 526588, 558436, 197894, 10608, 501630, 508541, 526338, 16527, 2022, 13134, 545200, 197863, 265238, 558060, 508401, 463459, 13250, 557655, 330668, 273256, 330653, 508421, 220998, 2345, 309380, 522504, 557808, 542303, 11131, 10606, 490365, 71603, 231298, 481029, 547547, 276156, 161089, 502996, 396534, 540703, 3369, 476459, 508286, 273550, 490298, 548270, 492123, 0, 277937, 158170, 490297, 519330, 554509, 508694, 503268, 526985, 1797, 3681, 492134, 469776, 508792, 499138, 16502, 482416, 542100, 198083, 7487, 11011, 548103, 464776, 17576, 383534, 529481, 231726, 520467);
		}

		$articles = DataMartService::getTopArticlesByPageview(
			$this->wikiId,
			null,
			null,
			null,
			self::MAX_ELEM_IN_RANK
		);
		$articleId = array();
		foreach ( $articles as $id => $a ) {
			$articleId[] = $id;
		}

		return $articleId;
	}

	protected function getTopLinks() {

		$result = $this->db->select(	array( "pagelinks" ),
										array( "count(pl_from) as cnt", "pl_title"),
										array(),
										__METHOD__,
										array(	"GROUP BY"=> array( "pl_title" ),
												"LIMIT" => self::MAX_ELEM_IN_RANK,
												"ORDER BY" => array ("cnt DESC" ) ) );
		$topLinks = array();
		while ( $row = $result->fetchObject() ) {
			$topLinks[] = array( "title"=> $row->pl_title, "cnt" => $row->cnt );
		}
		return $topLinks;
	}
}