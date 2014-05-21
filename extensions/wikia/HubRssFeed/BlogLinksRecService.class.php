<?php

class BlogLinksRecService extends WikiaService {

	/* @var Solarium_Client $solariumClient  */
	protected $solariumClient = null;

	private function getSolariumClient() {
		if (empty($this->solariumClient)) {
			$config = (new Wikia\Search\QueryService\Factory)->getSolariumClientConfig();
			$this->solariumClient = new Solarium_Client($config);
		}
		return $this->solariumClient;
	}

	private function getTvShowWikis() {
		//STUB: TODO: get from wikiFactory => wgDartCustomKeyValues | media=tv
		return '25,113,119,125,165,277,312,323,339,374,376,390,393,410,411,463,532,534,537,543,662,673,680,681,684,690,693,694,706,739,745,775,790,827,831,835,843,847,866,867,922,932,942,968,971,977,1014,1055,1081,1135,1155,1166,1228,1248,1295,1304,1318,1345,1395,1396,1417,1418,1434,1550,1552,1573,1581,1624,1647,1705,1746,1752,1771,1795,1845,1872,1912,2061,2108,2111,2120,2137,2154,2180,2199,2202,2237,2242,2257,2342,2429,2467,2485,2501,2514,2552,2562,2569,2618,2632,2703,2718,2778,2805,2860,2866,2889,2934,2947,2956,2966,3024,3049,3058,3124,3156,3180,3200,3264,3328,3337,3338,3339,3340,3401,3581,3655,3765,3766,3778,3792,3917,3989,4002,4026,4045,4082,4091,4095,4098,4122,4226,4385,4428,4490,4610,4643,4689,4728,4732,4780,4830,4858,4859,4913,4930,5035,5102,5173,5278,5360,5404,5463,5497,5618,5880,5885,5896,6228,6262,6327,6444,6475,6482,6519,6521,6801,6877,6913,6971,7017,7089,7107,7116,7138,7147,7153,7176,7238,7273,7305,7384,7403,7413,7445,7540,7589,7593,7736,7852,7876,7976,8262,8273,8388,8453,9863,11344,11432,12114,12606,13346,18733,24357,26337,38969,43771,46584,70256,73168,91051,91319,94146,101230,111180,129529,167712,194308,260417,279056,283651,286326,321995,329580,342218,366780,422285,470661,535888';
	}

	public function getBlogPagesList() {

		$this->getSolariumClient();
		$q = "ns:500 AND outbound_links_txt:* AND touched:[NOW-14DAY/DAY TO NOW]";
		//$q .= " AND wid:(" . implode(" OR ", explode(",", $this->getTvShowWikis())) . ") ";
		$query = $this->solariumClient->createSelect();

		//var_dump( $q ); die;

		$query->setQuery($q);
		//$query->createFilterQuery('wikilist')->setQuery("wid:(" . implode(" OR ", explode(",", $this->getTvShowWikis())) . ")");
		$query->setStart( 0 );
		$query->setRows( 1000 );
		$query->addSort( 'touched', Solarium_Query_Select::SORT_DESC );

		$resultSet  = $this->solariumClient->select( $query );

		$linkz = array();
		$linkz_cnt = array();
		$unique_entry = array();

		foreach ($resultSet as $res ) {

			foreach ( $res['outbound_links_txt'] as $outbound ) {
				//die("A: $outbound");

				$outArr = explode(" | ", $outbound);
				$linkArr = explode("_", $outArr[0]);
				$unique_entry[$outbound['id'].$outArr[0]]++;

				if ($unique_entry[$outbound['id'].$outArr[0]] > 1 ) {
					echo $outbound['id'].$outArr[0];
					continue;
				}

				$linkz[$outArr[0]] = array(
							    "wid"=>$linkArr[0],
							    "article_id"=>$linkArr[1],
								"title" => $outArr[1],
								"wiki_url" => substr($res['url'], 0, strpos($res['url'], 'wiki/')),
								"touched" => $outbound['touched']
				);
				$linkz_cnt[$outArr[0]]+=1;
			}

		}

		//var_dump( $linkz, $linkz_cnt );
		echo '<pre>'; echo count($linkz_cnt); print_r( $linkz_cnt );

		//var_dump( $resultSet );
		die("AAAAA");

		$results = [];
		return $results;
	}
}