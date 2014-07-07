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
	private $rowLimit;
	private $filters;

	/**
	 * @param mixed $filters
	 */
	public function setFilters( $filters ) {
		$this->filters = $filters;
	}

	/**
	 * @return mixed
	 */
	public function getFilters() {
		return $this->filters;
	}

	/**
	 * @param mixed $rowLimit
	 */
	public function setRowLimit( $rowLimit ) {
		$this->rowLimit = $rowLimit;
	}

	/**
	 * @return mixed
	 */
	public function getRowLimit() {
		return $this->rowLimit;
	}

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

		$select->createFilterQuery( 'mp' )->setQuery( '-(is_main_page:true)' );
		if(!empty($this->filters)){
			foreach($this->filters as $name => $query){
				$select->createFilterQuery( $name )->setQuery( $query );
			}
		}
		$select->setRows( $this->rowLimit ? $this->rowLimit : static::ROWS_NUMBER );

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
				'page_id' => $res[ 'pageid' ],
				'url' => $res[ 'url' ],
				'title' => $res[  'title_en' ],
				'timestamp' => strtotime( $res[ 'created' ] ),
				'host' => $res[ 'host' ],
				'wid' => $res[ 'wid' ],
				'wikia_id' =>$res[ 'wid' ],
				'wikititle' => $res['wikititle_en'],
				'ns' => $res['ns']
			];
		}
		return $items;
	}
}
