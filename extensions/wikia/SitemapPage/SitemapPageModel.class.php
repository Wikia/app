<?php

class SitemapPageModel extends WikiaModel {

	const SITEMAP_PAGE = 'Sitemap';
	const CACHE_VERSION = '1';
	const CACHE_TTL = 86400;
	const DEFAULT_LIMIT_PER_PAGE = 100;
	const MAX_LEVEL = 3;
	const MIN_LEVEL = 1;
	const VERTICAL_UNKNOWN = 'Unknown';

	protected $verticals = null;

	/**
	 * Check for top level
	 * @param int $level
	 * @return bool
	 */
	public static function isTopLevel( $level ) {
		return ( $level >= self::MIN_LEVEL && $level < self::MAX_LEVEL );
	}

	/**
	 * Get limit for each list (top level)
	 * @param $level
	 * @return int
	 */
	public function getLimitPerList( $level ) {
		$exp = self::isTopLevel( $level ) ? self::MAX_LEVEL - $level : 0 ;
		$base = $this->getLimitPerPage();
		return pow( $base, $exp );
	}

	/**
	 * Get limit per page
	 * @return int
	 */
	public function getLimitPerPage() {
		$total = (int) $this->getTotalWikis();
		$base = self::DEFAULT_LIMIT_PER_PAGE;
		while ( pow( $base, self::MAX_LEVEL ) < $total ) {
			$base += 50;
		}

		return $base;
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
	 * Get list of wikis ordered by title (for detail page)
	 * @param string $from - from wiki (dbname)
	 * @param string $to - to wiki (dbname)
	 * @return array
	 */
	public function getWikiList( $from, $to ) {
		$limit = $this->getLimitPerPage();
		$db = $this->getSharedDB();
		$memcKey = $this->getMemcKeyWikiList( $from, $to );
		$query = ( new WikiaSQL() )->cacheGlobal( self::CACHE_TTL, $memcKey )
			->SELECT()
				->FIELD( 'city_list.city_id' )
				->FIELD( 'trim(city_list.city_title) as title' )
				->FIELD( 'city_list.city_url' )
				->FIELD( 'city_list.city_lang' )
				->FIELD( 'city_list.city_vertical' )
				->FIELD( 'trim(city_visualization.city_description) as description' )
			->FROM( 'city_list' )
			->LEFT_JOIN( 'city_visualization' )->ON( 'city_list.city_id', 'city_visualization.city_id' )
			->WHERE( 'city_list.city_public' )->EQUAL_TO( 1 )
				->AND_( 'city_list.city_created' )->LESS_THAN( 'curdate()' )
			->ORDER_BY( 'title' )
			->LIMIT( $limit );

		if ( !empty( $from ) ) {
			$query->AND_( 'city_list.city_dbname' )->GREATER_THAN_OR_EQUAL( $from );
		}

		if ( !empty( $to ) ) {
			$query->AND_( 'city_list.city_dbname' )->LESS_THAN_OR_EQUAL( $to );
		}

		$wikis = $query->runLoop( $db, function( &$wikis, $row ) {
			$wikis[] = [
				'title'       => $row->title,
				'url'         => $row->city_url,
				'language'    => strtoupper( $row->city_lang ),
				'vertical'    => $this->getVerticalName( $row->city_vertical ),
				'description' => empty( $row->description ) ? '' : $row->description,
			];
		});

		return empty( $wikis ) ? [] : $wikis;
	}

	/**
	 * Get list of wikis ordered by dbname (for top level page)
	 * @param int $level - page level
	 * @param string $from - from wiki (dbname)
	 * @param string $to - to wiki (dbname)
	 * @return array
	 */
	public function getWikiListTopLevel( $level, $from, $to ) {
		$memcKey = $this->getMemcKeyWikiListTopLevel( $level, $from, $to );
		$wikis = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $wikis ) ) {
			$where = [
				'mainFrom'  => $from,
				'mainTo'    => $to,
				'chunkFrom' => '',
			];
			$wikis = $this->getWikiTitles( $where, 'city_dbname ASC', 1 );
			if ( !empty( $wikis ) ) {
				$done = false;
				$offset = $this->getLimitPerList( $level ) - 1;
				while ( !$done ) {
					$list = $this->getWikiTitles( $where, 'city_dbname ASC', 2, $offset );
					if ( empty( $list ) ) {
						$done = true;
						$last = $this->getWikiTitles( $where, 'city_dbname DESC', 1 );
						if ( !empty( $last ) && !array_key_exists( key( $last ), $wikis ) ) {
							$wikis += $last;
						}
					} else {
						$wikis += $list;
						end( $list );
						$where['chunkFrom'] = key( $list );
					}
				}
			}

			$this->wg->Memc->set( $memcKey, $wikis, self::CACHE_TTL );
		}

		return $wikis;
	}

	/**
	 * Get list of wiki titles
	 * @param array $where - query conditions. Format: [ 'mainFrom' => '', 'mainTo' => '', 'chunkFrom' => '' ]
	 * @param string $order
	 * @param int $limit
	 * @param int|null $offset
	 * @return array
	 */
	public function getWikiTitles( $where, $order, $limit, $offset = null ) {
		$db = $this->getSharedDB();
		$query = ( new WikiaSQL() )->cacheGlobal( 5 )
			->SELECT()
			->FIELD( 'city_dbname' )
			->FIELD( 'trim(city_title) as title' )
			->FROM( 'city_list' )
			->WHERE( 'city_public' )->EQUAL_TO( 1 )
				->AND_( 'city_created' )->LESS_THAN( 'curdate()' )
			->ORDER_BY( $order )
			->LIMIT( $limit );

		if ( !empty( $where['mainFrom'] ) ) {
			$query->AND_( 'city_dbname' )->GREATER_THAN_OR_EQUAL( $where['mainFrom'] );
		}

		if ( !empty( $where['mainTo'] ) ) {
			$query->AND_( 'city_dbname' )->LESS_THAN_OR_EQUAL( $where['mainTo'] );
		}

		if ( !empty( $where['chunkFrom'] ) ) {
			$query->AND_( 'city_dbname' )->GREATER_THAN_OR_EQUAL( $where['chunkFrom'] );
		}

		if ( !empty( $offset ) ) {
			$query->OFFSET( $offset );
		}

		$wikis = $query->runLoop( $db, function( &$wikis, $row ) {
			$wikis[$row->city_dbname] = [
				'title'       => $row->title,
				'dbname'      => $row->city_dbname,
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
			->WHERE( 'city_public' )->EQUAL_TO( 1 )
				->AND_( 'city_created' )->LESS_THAN( 'curdate()' )
			->run( $db, function ( $result ) {
				$row = $result->fetchObject( $result );
				return empty( $row ) ? 0 : $row->total;
			});

		return $total;
	}

	/**
	 * Get memcache key for getWikiListTopLevel
	 * @param int $level
	 * @param string $from - from wiki (dbname)
	 * @param string $to - to wiki (dbname)
	 * @return string
	 */
	protected function getMemcKeyWikiListTopLevel( $level, $from, $to ) {
		return wfSharedMemcKey( 'sitemap_page', 'wiki_list_level', self::CACHE_VERSION, $level, $from, $to );
	}

	/**
	 * Get memcache key for getWikiList
	 * @param string $from - from wiki (dbname)
	 * @param string $to - to wiki (dbname)
	 * @return string
	 */
	protected function getMemcKeyWikiList( $from, $to ) {
		return wfSharedMemcKey( 'sitemap_page', 'wiki_list', self::CACHE_VERSION, $from, $to );
	}

	/**
	 * Get memcache key for getTotalWikis
	 * @return string
	 */
	protected function getMemcKeyTotalWikis() {
		return wfSharedMemcKey( 'sitemap_page', 'total_wikis', self::CACHE_VERSION );
	}

	/**
	 * Get all verticals
	 * @return array
	 */
	protected function getVerticals() {
		if ( is_null( $this->verticals ) ) {
			$this->verticals = WikiFactoryHub::getInstance()->getAllVerticals();
		}

		return $this->verticals;
	}

	/**
	 * Get vertical name
	 * @param int $verticalId - vertical id
	 * @return string $name - vertical name
	 */
	public function getVerticalName( $verticalId ) {
		$verticals = $this->getVerticals();
		return ( empty( $verticals[$verticalId]['name'] ) ) ? self::VERTICAL_UNKNOWN : $verticals[$verticalId]['name'];
	}

}
