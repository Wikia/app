<?php
class PhalanxStatsPager extends PhalanxPager {
	public $qCond = 'ps_blocker_id';
	public $pInx = 'blockId';

	public function __construct( $id ) {
		global $wgSpecialsDB;

		parent::__construct();
		$this->id = (int) $id;
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
		if ( !empty( $this->pInx ) ) {
			$this->mDefaultQuery[$this->pInx] = $this->id;
		}
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
			if ( !empty( $this->pInx ) ) {
				$query[ $this->pInx ] = $this->id;
			}
			$queries[$type] = $query;
		}

		return $queries;
	}

	function formatRow( $row ) {
		$type = implode( ", ", Phalanx::getTypeNames( ( isset( $row->ps_blocker_hit ) ) ? $row->ps_blocker_hit : $row->ps_blocker_type ) );
		$username = $row->ps_blocked_user;
		$timestamp = $this->app->wg->Lang->timeanddate( $row->ps_timestamp );
		$oWiki = WikiFactory::getWikiById( $row->ps_wiki_id );
		$url = ( isset( $row->ps_referrer ) ) ? $row->ps_referrer : "";
		$url = ( empty( $url ) && isset( $oWiki ) ) ? $oWiki->city_url : $url;

		// SUS-184: Render usernames containing spaces correctly
		$encUserName = str_replace(' ', '_', $username );

		$specialContributionsURL = GlobalTitle::newFromText( 'Contributions', NS_SPECIAL, $row->ps_wiki_id )->getFullURL();

		if ( !empty( $specialContributionsURL ) ) {
			$username = '[' . $specialContributionsURL . '/' . $encUserName . ' ' . $username . ']';
		}

		$html  = Html::openElement( 'li' );
		$html .= wfMessage( 'phalanx-stats-row', $type, $username, $url, $timestamp )->parse();
		$html .= Html::closeElement( 'li' );

		return $html;
	}
}
