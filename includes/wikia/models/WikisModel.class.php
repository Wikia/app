<?php
/**
 * Model for Wikia-specific information about wikis
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @author Artur Klajnerok <arturk@wikia-inc.com>
 */

class WikisModel extends WikiaModel {
	const CACHE_VERSION = '4';
	const MAX_RESULTS = 250;

	const FLAG_PROMOTED = 4;
	const FLAG_BLOCKED = 8;
	const FLAG_OFFICIAL = 16;

	/**
	 * Get details about one or more wikis
	 *
	 * @param Array $wikiIds An array of one or more wiki ID's
	 * @param bool $getBlocked If set to true, will return also blocked (not displayed on global page) wikias
	 *
	 * @return Array A collection of results, the index is the wiki ID and each item has a name,
	 * url, lang, hubId, headline, desc, image and flags index.
	 */
	public function getDetails( Array $wikiIds = null, $getBlocked = false ) {
		wfProfileIn(__METHOD__);

		$results = array();

		if ( !empty( $wikiIds ) ) {
			$notFound = array();

			foreach ( $wikiIds as $index => $val ) {
				$val = (int) $val;

				if ( !empty( $val ) ) {
					$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, $val );
					$item = $this->wg->Memc->get( $cacheKey );

					if ( is_array( $item ) ) {
						$results[$val] = $item;
					}else {
						$notFound[] = $val;
					}
				}
			}

			$wikiIds = $notFound;
		}

		if ( !empty( $wikiIds ) ) {
			$db = $this->getSharedDB();

			$where = array(
				'city_list.city_public' => 1,
				'city_list.city_id IN (' . implode( ',', $wikiIds ) . ')'
			);
			if ( !$getBlocked ) {
				$where[] = '((city_visualization.city_flags & ' . self::FLAG_BLOCKED . ') != ' .
					self::FLAG_BLOCKED . ' OR city_visualization.city_flags IS NULL)';
			}
			$rows = $db->select(
				array(
					'city_visualization',
					'city_list'
				),
				array(
					'city_list.city_id',
					'city_list.city_title',
					'city_list.city_url',
					'city_visualization.city_lang_code',
					'city_visualization.city_vertical',
					'city_visualization.city_headline',
					'city_visualization.city_description',
					'city_visualization.city_main_image',
					'city_visualization.city_flags',
				),
				$where,
				__METHOD__,
				array(),
				array(
					'city_visualization' => array(
						'LEFT JOIN',
						'city_list.city_id = city_visualization.city_id'
					)
				)
			);

			while( $row = $db->fetchObject( $rows ) ) {
				$item = array(
					'name' => $row->city_title,
					'url' => $row->city_url,
					'lang' => $row->city_lang_code,
					'hubId' => $row->city_vertical,
					'headline' => $row->city_headline,
					'desc' => $row->city_description,
					//this is stored in a pretty peculiar format,
					'image' => PromoImage::fromPathname($row->city_main_image)->ensureCityIdIsSet($row->city_id)->getPathname(),
					'flags' => array(
						'official' => ( ( $row->city_flags & self::FLAG_OFFICIAL ) == self::FLAG_OFFICIAL ),
						'promoted' => ( ( $row->city_flags & self::FLAG_PROMOTED ) == self::FLAG_PROMOTED )
					)
				);

				$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, $row->city_id );
				$this->wg->Memc->set( $cacheKey, $item, 43200 /* 12h */ );
				$results[$row->city_id] = $item;
			}
		}

		wfProfileOut(__METHOD__);
		return $results;
	}
}