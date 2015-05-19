<?php

class SitemapPageModel extends WikiaModel {

	const SITEMAP_PAGE = 'Sitemap';
	const CACHE_VERSION = '1';
	const CACHE_TTL = 86400;
	const WIKI_LIMIT_PER_PAGE = 100;
	const VERTICAL_UNKNOWN = 'Unknown';

	protected static $verticalNames = [
		WikiFactoryHub::VERTICAL_ID_OTHER => 'Other',
		WikiFactoryHub::VERTICAL_ID_TV => 'TV',
		WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES => 'Games',
		WikiFactoryHub::VERTICAL_ID_BOOKS => 'Books',
		WikiFactoryHub::VERTICAL_ID_COMICS => 'Comics',
		WikiFactoryHub::VERTICAL_ID_LIFESTYLE => 'Lifestyle',
		WikiFactoryHub::VERTICAL_ID_MUSIC => 'Music',
		WikiFactoryHub::VERTICAL_ID_MOVIES => 'Movies',
	];

	protected $maxDate;	// maximum date

	public function __construct() {
		parent::__construct();
		$this->maxDate = date( 'Ymd' );
	}

	/**
	 * Get maximum date
	 * @return string
	 */
	public function getMaxDate() {
		return $this->maxDate;
	}

	/**
	 * Check if the page is sitemap page
	 * @param Title $title
	 * @return bool
	 */
	public function isSitemapPage( $title ) {
		if ( WikiaPageType::isCorporatePage() && $title->getDBkey() == self::SITEMAP_PAGE ) {
			return true;
		}

		return false;
	}

	/**
	 * Get list of wikis for the page
	 * @param int $page
	 * @return array
	 */
	public function getWikis( $page ) {
		$db = $this->getSharedDB();
		$memcKey = $this->getMemcKeyWikis( $page );
		$query = ( new WikiaSQL() )->cacheGlobal( self::CACHE_TTL, $memcKey )
			->SELECT()
				->FIELD( 'city_list.city_id' )
				->FIELD( 'trim(city_list.city_title) as title' )
				->FIELD( 'city_list.city_url' )
				->FIELD( 'city_visualization.city_lang_code' )
				->FIELD( 'city_visualization.city_vertical' )
				->FIELD( 'trim(city_visualization.city_description) as description' )
			->FROM( 'city_list' )
			->LEFT_JOIN( 'city_visualization' )->ON( 'city_list.city_id', 'city_visualization.city_id' )
			->WHERE( 'city_list.city_public' )->EQUAL_TO( 1 )
				->AND_( 'city_list.city_created' )->LESS_THAN( $this->getMaxDate() )
			->ORDER_BY( 'title' )
			->LIMIT( self::WIKI_LIMIT_PER_PAGE );

		if ( $page > 1 ) {
			$query->OFFSET( ($page - 1) * self::WIKI_LIMIT_PER_PAGE );
		}

		$wikis = $query->runLoop( $db, function( &$wikis, $row ) {
			$wikis[$row->city_id] = [
				'title'       => $row->title,
				'url'         => $row->city_url,
				'language'    => strtoupper( $row->city_lang_code ),
				'vertical'    => $this->getVerticalName( $row->city_vertical ),
				'description' => empty( $row->description ) ? '' : $row->description,
			];
		});

		return empty( $wikis ) ? [] : $wikis;
	}

	/**
	 * Get the total number of wikis
	 * @return int $total
	 */
	public function getTotalWikis() {
		$memcKey = $this->getMemcKeyTotalWikis();
		$db = $this->getSharedDB();
		$total = ( new WikiaSQL() )->cacheGlobal( self::CACHE_TTL, $memcKey )
			->SELECT( 'count(*) total' )
			->FROM( 'city_list' )
			->LEFT_JOIN( 'city_visualization' )->ON( 'city_list.city_id', 'city_visualization.city_id' )
			->WHERE( 'city_list.city_public' )->EQUAL_TO( 1 )
				->AND_( 'city_list.city_created' )->LESS_THAN( $this->getMaxDate() )
			->run( $db, function ( $result ) {
				$row = $result->fetchObject( $result );
				return empty( $row ) ? 0 : $row->total;
			});

		return $total;
	}

	/**
	 * Get Pagination (HTML)
	 * @param int $page
	 * @return string $pagination
	 */
	public function getPagination( $page ) {
		$pagination = '';
		$totalWikis = $this->getTotalWikis();
		if ( $totalWikis > self::WIKI_LIMIT_PER_PAGE ) {
			$pages = Paginator::newFromArray( array_fill( 0, $totalWikis, '' ), self::WIKI_LIMIT_PER_PAGE );
			$pages->setActivePage( $page - 1 );
			$pagination = $pages->getBarHTML( $this->wg->Title->getLocalURL( 'page=%s' ) );
		}

		return $pagination;
	}

	/**
	 * Get memcache key for getWikis
	 * @param int $page
	 * @return string
	 */
	protected function getMemcKeyWikis( $page ) {
		$date = $this->getMaxDate();
		return wfSharedMemcKey( 'sitemap_page', 'wikis', self::CACHE_VERSION, $date, $page );
	}

	/**
	 * Get memcache key for getTotalWikis
	 * @return string
	 */
	protected function getMemcKeyTotalWikis() {
		$date = $this->getMaxDate();
		return wfSharedMemcKey( 'sitemap_page', 'total_wikis', self::CACHE_VERSION, $date );
	}

	/**
	 * Get vertical name
	 * @param int $verticalId - vertical id
	 * @return string $name - vertical name
	 */
	protected function getVerticalName( $verticalId ) {
		if ( empty( self::$verticalNames[$verticalId] ) ) {
			$name = self::VERTICAL_UNKNOWN;
		} else {
			$name = self::$verticalNames[$verticalId];
		}

		return $name;
	}

}
