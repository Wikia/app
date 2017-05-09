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
		$blocker = $row->ps_blocker_hit ?: $row->ps_blocker_type;
		$type = implode( ', ', Phalanx::getTypeNames( $blocker ) );
		$username = $row->ps_blocked_user;
		$timestamp = $this->getLanguage()->timeanddate( $row->ps_timestamp );

		$url = $row->ps_referrer ?: '';
		if ( empty( $url ) ) {
			$wiki = WikiFactory::getWikiByID( $row->ps_wiki_id );
			if ( $wiki ) {
				$url = $wiki->city_url;
			}
		}

		// SUS-184: Render usernames containing spaces correctly
		$encUserName = str_replace( ' ', '_', $username );

		$specialContributions = GlobalTitle::newFromText(
			'Contributions',
			NS_SPECIAL,
			$row->ps_wiki_id
		);

		if ( $specialContributions->getServer() ) {
			$specialContributionsURL = $specialContributions->getFullURL();
			$username = '[' . $specialContributionsURL . '/' . $encUserName . ' ' . $username . ']';
		}

		$html  = Html::openElement( 'li' );
		$html .= $this->msg( 'phalanx-stats-row', $type, $username, $url, $timestamp )->parse();
		$html .= Html::closeElement( 'li' );

		return $html;
	}
}
