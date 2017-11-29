<?php
class PhalanxStatsPager extends PhalanxPager {
	public $qCond = 'ps_blocker_id';
	public $pInx = 'blockId';

	protected $id;
	public $mDb;

	public function __construct( int $id ) {
		parent::__construct();

		$this->id = $id;
		$this->mDb = $this->getDatabase( DB_SLAVE );

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
		$timestamp = $this->getLanguage()->timeanddate( $row->ps_timestamp );

		// SUS-3443: we either store (user ID, "") or (0, IP address) pair
		$username = User::getUsername( (int) $row->ps_blocked_user_id, $row->ps_blocked_user );

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

	/**
	 * Get connection to Phalanx Stats table on specials DB
	 *
	 * Phalanx stats table is encoded in utf-8, while in most cases MW communicates with
	 * databases using latin1, so sometimes we get strings in wrong encoding.
	 * The only way to force utf-8 communication (adding SET NAMES utf8) is setting
	 * global variable wgDBmysql5.
	 *
	 * @see https://github.com/Wikia/app/blob/dev/includes/db/DatabaseMysqlBase.php#L113
	 *
	 * @param int $dbType master or slave
	 * @return DatabaseBase
	 */
	protected function getDatabase( int $dbType = DB_SLAVE ): DatabaseBase {
		$wrapper = new Wikia\Util\GlobalStateWrapper( [
			'wgDBmysql5' => true
		] );

		return $wrapper->wrap( function () use ( $dbType ) {
			global $wgSpecialsDB;
			return wfGetDB( $dbType, [], $wgSpecialsDB );
		} );
	}
}
