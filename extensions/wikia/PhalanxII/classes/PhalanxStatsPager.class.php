<?php
class PhalanxStatsPager extends PhalanxPager {
	public $qCond = '';
	public $pInx = '';

	public function __construct( $id ) {
		parent::__construct();
		$this->id = (int) $id;
		$this->mDb = wfGetDB( DB_SLAVE, array(), $this->app->wg->ExternalDatawareDB );
		$this->mDefaultQuery['blockId'] = $this->id;
		$this->qCond = 'ps_blocker_id';
		$this->pInx = 'blockId';
	}

	function getQueryInfo() {
		$query['tables'] = 'phalanx_stats';
		$query['fields'] = '*';
		$query['conds'] = array(
			$this->qCond => $this->id,
		);

		return $query;
	}

	function getIndexField() {
		return 'ps_timestamp';
	}

	function getPagingQueries() {
		$queries = parent::getPagingQueries();

		foreach ( $queries as $type => $query ) {
			if ( $query === false ) {
				continue;
			}
			$query[ $this->pInx ] = $this->id;
			$queries[$type] = $query;
		}

		return $queries;
	}

	function formatRow( $row ) {
		$type = implode( Phalanx::getTypeNames( $row->ps_blocker_type ) );
		$username = $row->ps_blocked_user;
		$timestamp = $this->app->wg->Lang->timeanddate( $row->ps_timestamp );
		$oWiki = WikiFactory::getWikiById( $row->ps_wiki_id );
		$url = ( isset( $oWiki ) ) ? $oWiki->city_url : "";

		$html  = Html::openElement( 'li' );
		$html .= $this->app->wf->MsgExt( 'phalanx-stats-row', array('parseinline'), $type, $username, $url, $timestamp );
		$html .= Html::closeElement( 'li' );

		return $html;
	}
}
