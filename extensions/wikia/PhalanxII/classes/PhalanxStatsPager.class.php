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
		// $row->ps_blocker_hit can be null or zero
		$type = implode( ", ",
			Phalanx::getTypeNames( empty( $row->ps_blocker_hit ) ? $row->ps_blocker_type : $row->ps_blocker_hit ) );

		$username = $row->ps_blocked_user;
		$timestamp = $this->getLanguage()->timeanddate( $row->ps_timestamp );
		$oWiki = WikiFactory::getWikiByID( $row->ps_wiki_id );
		$url = $row->ps_referrer ?? '';
		$url = ( empty( $url ) && isset( $oWiki ) ) ? $oWiki->city_url : $url;

		// SUS-184: Render usernames containing spaces correctly
		$encUserName = $this->replaceSpaces( $username );

		$specialContributionsURL =
			GlobalTitle::newFromText( 'Contributions', NS_SPECIAL, $row->ps_wiki_id )->getFullURL();

		if ( !empty( $specialContributionsURL ) ) {
			$specialContributionsURL = "[$specialContributionsURL/$encUserName $encUserName]";
		}

		$html  = Html::openElement( 'li' );
		$html .= $this->msg( 'phalanx-stats-row', $type, $specialContributionsURL, $url, $timestamp )->parse();
		$html .= Html::closeElement( 'li' );

		return $html;
	}

	private function replaceSpaces( $text ) {
		return str_replace( ' ', '_', $text );
	}
}
