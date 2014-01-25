<?php

class ArticleQualityService extends Service {

	const SQL_CACHE_TIME = 86399; // 12h

	const MEMC_CACHE_TIME = 86400; // 24h

	const CACHE_BUSTER = '0';

	/**
	 * @var WikiaApp
	 */
	protected $app;

	/**
	 * @var int
	 */
	protected $articleId;

	/**
	 * @var array
	 */
	protected $percentiles = [
		0 => 0,
		1 => 30.2842712474619,
		2 => 39.0960235873233,
		3 => 44.0722112987808,
		4 => 47.0265021285938,
		5 => 49.7931187091788,
		6 => 53.2161591523565,
		7 => 55.5855957413421,
		8 => 56.9209978830308,
		9 => 56.9209978830308,
		10 => 59.9411254969543,
		11 => 63.7654759319752,
		12 => 66.2718872423573,
		13 => 69.5340628486792,
		14 => 71.7864450885824,
		15 => 73.4818955369284,
		16 => 75.071655931941,
		17 => 76.8880192678122,
		18 => 78.2752848603135,
		19 => 80.0768648707832,
		20 => 81.5164776741336,
		21 => 82.7411238477095,
		22 => 83.8802756589934,
		23 => 85.1684463962826,
		24 => 86.3123455129347,
		25 => 87.3904521146499,
		26 => 88.4930880922933,
		27 => 89.5635711055112,
		28 => 90.7180164826868,
		29 => 91.6596316367368,
		30 => 92.7883986039752,
		31 => 93.96995561753,
		32 => 94.8892989616586,
		33 => 95.8283344895795,
		34 => 96.6549980981929,
		35 => 97.3717923344589,
		36 => 98.1112693141799,
		37 => 98.8959423304531,
		38 => 99.8195620673063,
		39 => 100.551302547289,
		40 => 101.463263597035,
		41 => 102.156444648994,
		42 => 102.842307220998,
		43 => 103.758084743217,
		44 => 104.81912692288,
		45 => 105.741325508683,
		46 => 106.552730931918,
		47 => 107.296706492275,
		48 => 108.25229394523,
		49 => 108.928715317562,
		50 => 109.761011282468,
		51 => 110.794845450033,
		52 => 111.652182077143,
		53 => 112.464540522165,
		54 => 113.339217478715,
		55 => 114.152790896765,
		56 => 114.792509458012,
		57 => 115.633270838436,
		58 => 116.335242552926,
		59 => 117.263359851978,
		60 => 118.003848512446,
		61 => 118.871902436704,
		62 => 119.782547497364,
		63 => 120.919009296101,
		64 => 121.912808773496,
		65 => 122.991198784554,
		66 => 123.983488618448,
		67 => 125.476882402337,
		68 => 126.60772712292,
		69 => 127.805549329835,
		70 => 129.695258260289,
		71 => 130.90012837242,
		72 => 132.366971100159,
		73 => 134.179519143954,
		74 => 135.939488150217,
		75 => 137.619748084244,
		76 => 139.656774425107,
		77 => 141.667573499958,
		78 => 143.599111334915,
		79 => 146.210881742473,
		80 => 149.209808639864,
		81 => 151.61561041,
		82 => 154.955000554264,
		83 => 157.714630595467,
		84 => 160.659307663767,
		85 => 164.09600174524,
		86 => 168.479090749578,
		87 => 172.234395628804,
		88 => 175.839745187979,
		89 => 181.124259036326,
		90 => 186.411133298116,
		91 => 191.833285245601,
		92 => 196.803966593887,
		93 => 204.541847083834,
		94 => 213.733694567047,
		95 => 223.331363107717,
		96 => 237.377429029918,
		97 => 255.691539048018,
		98 => 279.950527050516,
		99 => 322.646075843896,
	];

	public function __construct() {
		$this->app = F::app();
	}

	/**
	 * Sets articleId
	 * @param $articleId
	 */
	public function setArticleById( $articleId ) {
		$this->articleId = (int)$articleId;
	}

	/**
	 * Returns percentile quality of articleId or null if not found
	 * @return int|null
	 */
	public function getArticleQuality() {

		$cacheKey = wfMemcKey(
			__CLASS__,
			self::CACHE_BUSTER,
			$this->articleId
		);

		$percentile = $this->app->wg->Memc->get( $cacheKey );

		if ( $percentile === false ) {
			$title = Title::newFromID( $this->articleId );
			if ( $title === null ) {
				return null;
			}
			$article = new Article( $title );
			$parser = $article->getParserOutput();

			$inputs = [
				'outbound' => 0,
				'inbound' => 0,
				'length' => 0,
				'sections' => 0,
				'images' => 0
			];

			/**
			 *  $title->getLinksTo() and  $title->getLinksFrom() function are
			 * too expensive to call it here as we want only the number of links
			 */
			$inputs[ 'outbound' ] = $this->countOutboundLinks( $this->articleId );
			$inputs[ 'inbound' ] = $this->countInboundLinks( $this->articleId );
			$inputs[ 'sections' ] = count( $parser->getSections() );
			$inputs[ 'images' ] = count( $parser->getImages() );
			$inputs[ 'length' ] = $this->getCharsCountFromHTML( $parser->getText() );
			$quality = $this->computeFormula( $inputs );
			$percentile = $this->searchPercentile( $quality );

			$this->app->wg->Memc->set( $cacheKey, $percentile, self::MEMC_CACHE_TIME );
		}
		return $percentile;
	}

	/**
	 * compute quality against v1 formula
	 * @param $inputs
	 * @return int
	 */
	protected function computeFormula( $inputs ) {
		$quality = 0;
		$quality += $inputs[ 'outbound' ] ? 4 * sqrt( min( $inputs[ 'outbound' ], 10 ) ) : -10;
		$quality += $inputs[ 'inbound' ] ? 4 * sqrt( min( $inputs[ 'inbound' ], 10 ) ) : -10;
		$quality += 2 * sqrt( min( $inputs[ 'length' ], 100000 ) );
		$quality += 10 * sqrt( min( $inputs[ 'sections' ], 6 ) );
		$quality += $inputs[ 'images' ] ? 10 * sqrt( min( $inputs[ 'images' ], 10 ) ) : -40;

		return $quality;
	}

	/**
	 * Compute text length in html output
	 * @param $text
	 * @return int
	 */
	protected function getCharsCountFromHTML( $text ) {
		return strlen( strip_tags( $text ) );
	}

	/**
	 * Binary search on $percentiles where $value >= k and $value < k + 1
	 * @param $value int searched value in $percentiles
	 * @return int|null
	 */
	protected function searchPercentile( $value ) {
		reset( $this->percentiles );
		$firstElement = key( $this->percentiles );
		$min = $firstElement;
		end( $this->percentiles );
		$max = key( $this->percentiles );

		while ( 1 ) {
			if ( $max < $min ) {
				return $firstElement;
			}

			//calculate middle point
			$diff = $max - $min;
			$add = 0;
			//check if diff is odd, increment it to make it even
			//this is quicker than e.q modulo
			if ( ( $diff & 1 ) == 1 ) {
				$add = 1;
			}
			// Quicker than normal division, prevents from non-integer results
			$diff = $add + $min + ( $diff >> 1 );

			if ( $value >= $this->percentiles[ $diff ] ) {

				if ( $diff + 1 > $max || $value < $this->percentiles[ $diff + 1 ] ) {
					return $diff;
				}
				$min = $diff + 1 - $add;
			}
			else {
				$max = $diff - 1;
			}
		}
	}

	protected function countOutboundLinks( $articleId ) {
		//select count(*) aa from pagelinks left join page on ( page.page_title=pl_title and page.page_namespace = pl_namespace) where pl_from=8449 and page_id is not null
		$db = wfGetDB( DB_SLAVE );
		$links = ( new WikiaSQL() )
			->SELECT( "count(*)" )->AS_( 'c' )
			->FROM( 'pagelinks' )
			->LEFT_JOIN( 'page' )
			->ON( 'page.page_title=pl_title AND page.page_namespace = pl_namespace ' )
			->WHERE( 'pl_from' )->EQUAL_TO( (int)$articleId )
			->AND_( 'page_id' )->IS_NOT_NULL()
			->cache( self::SQL_CACHE_TIME )
			->run( $db, function ( $result ) {
				$row = $result->fetchObject( $result );

				if ( $row && isset( $row->c ) ) {
					return (int)$row->c;
				}

				return 0;
			} );

		return $links;
	}


	protected function countInboundLinks( $articleId ) {
		//select count(*) from pagelinks join page on (pl_title = page_title and pl_namespace =  page_namespace) where page_id=50;
		$db = wfGetDB( DB_SLAVE );
		$links = ( new WikiaSQL() )
			->SELECT( "count(*)" )->AS_( 'c' )
			->FROM( 'pagelinks' )
			->JOIN( 'page' )
			->ON( 'pl_title = page_title and pl_namespace =  page_namespace ' )
			->WHERE( 'page_id' )->EQUAL_TO( (int)$articleId )
			->cache( self::SQL_CACHE_TIME )
			->run( $db, function ( $result ) {
				$row = $result->fetchObject( $result );

				if ( $row && isset( $row->c ) ) {
					return (int)$row->c;
				}

				return 0;
			} );

		return $links;
	}


}