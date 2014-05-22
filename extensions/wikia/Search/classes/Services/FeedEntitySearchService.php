<?php

namespace Wikia\Search\Services;

class FeedEntitySearchService extends EntitySearchService {

	const ALLOWED_NAMESPACE = 0;
	const ROWS_NUMBER = 100;
	private $urls;
	private $ids;
	private $categories;
	private $hosts;
	private $sorts;

	/**
	 * @param mixed $sorts
	 */
	public function setSorts( $sorts ) {
		$this->sorts = $sorts;
	}

	/**
	 * @return mixed
	 */
	public function getSorts() {
		return $this->sorts;
	}
	/**
	 * @param mixed $host
	 */
	public function setHosts( $hosts ) {
		$this->hosts = $hosts;
	}

	/**
	 * @return mixed
	 */
	public function getHosts() {
		return $this->hosts;
	}

	/**
	 * @param mixed $categories
	 */
	public function setCategories( $categories ) {
		$this->categories = $categories;
	}

	/**
	 * @return mixed
	 */
	public function getCategories() {
		return $this->categories;
	}
	/**
	 * @param mixed $ids
	 */
	public function setIds( $ids ) {
		$this->ids = $ids;
	}

	/**
	 * @return mixed
	 */
	public function getIds() {
		return $this->ids;
	}
	protected function prepareQuery( $query ) {
		$select = $this->getSelect();

		$dismax = $select->getDisMax();
		$dismax->setQueryParser( 'edismax' );

		$select->setQuery( $this->createQuery( $query ) );
		if(!empty($this->sorts)){
			$select->addSorts($this->sorts);
		}
		//	$select->createFilterQuery( 'ns' )->setQuery( '+(ns:' . static::ALLOWED_NAMESPACE . ')' );


		$select->createFilterQuery( 'mp' )->setQuery( '-(is_main_page:true)' );

		$select->setRows( static::ROWS_NUMBER );

		return $select;
	}

	public function setUrls( $data ) {
		foreach ( $data as $item ) {
			$this->urls[ ] = '"' . $item . '"';
		}
	}

	private function createQuery( $query ) {
		$q = $this->getQuality();
		$l = $this->getLang();
		$wid = $this->getWikiId();
		if ( !empty( $wid ) ) {
			$wids = is_array( $wid ) ? $wid : [ $wid ];
		}
		$hub = $this->getHubs();
		if ( !empty( $hub ) ) {
			$hubs = is_array( $hub ) ? $hub : [ $hub ];
		}
		if(!empty($this->ids)){
			$query .= '+id:(' . implode( ' | ', $this->ids ) . ') ';
		}
		if(!empty($this->urls)){
			$query .= ' +url:(' . implode( ' | ', $this->urls ) . ')';
		}

		if(!empty($this->categories)){
			$query .= ' +categories_mv_en:(' . implode( ' AND ', $this->categories ) . ')';
		}
		if(!empty($this->hosts)){
			$query .= ' +host:(' . implode( ' | ', $this->hosts ) . ') ';
		}


		$query .=
			 ( isset( $q ) ? ' AND +(article_quality_i:[' . $q . ' TO *])' : '' )
			. ( isset( $l ) ? ' AND +(lang:' . $l . ')' : '' )
			. ( isset( $wids ) ? ' AND +wid:( ' . implode( ' | ', $wids ) . ')' : '' )
			. ( isset( $hubs ) ? ' AND +hub:( ' . implode( ' | ', $hubs ) . ')' : '' );

		return $query;
	}

	protected function consumeResponse( $response ) {
		$items = [ ];
		foreach ( $response as $res ) {
			$items[ ] = [
				'id' => $res[ 'id' ],
				'pageid' => $res[ 'pageid' ],
				'url' => $res[ 'url' ],
				'title' => $res[  'title_en' ],
				'timestamp' => strtotime( $res[ 'created' ] ),
				'description' => substr( $res[ 'html_en' ], 0, 100 ),
				'host' => $res[ 'host' ],
				'wid' => $res[ 'wid' ],
				'wikititle' => $res['wikititle_en']
			];
		}
		return $items;
	}
}
