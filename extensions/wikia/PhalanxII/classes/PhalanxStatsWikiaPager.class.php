<?php
class PhalanxStatsWikiaPager extends PhalanxStatsPager {
	public $qCond = 'ps_wiki_id';
	public $pInx = false;
	public $mTitle;
	public $mTitleStats;

	public function __construct( $id ) {
		parent::__construct( $id );
		$this->mTitle = Title::newFromText( 'Phalanx', NS_SPECIAL );
		$this->mTitleStats = Title::newFromText( 'PhalanxStats', NS_SPECIAL );
	}

	function formatRow( $row ) {
		$blockId = (int) $row->ps_blocker_id;

		// Get row data
		$type = $this->buildTypeNames( $row );
		$username = $row->ps_blocked_user;
		$phalanxUrl = $this->buildPhalanxUrl( $blockId );
		$timestamp = $this->app->wg->Lang->timeanddate( $row->ps_timestamp );
		$statsUrl = $this->buildStatsUrl( $blockId );
		$url = $row->ps_referrer;

		// Format the data with the phalanx-stats-row-per-wiki key and wrap it in an <li> tag
		$html = Html::openElement( 'li' );
		$html .= wfMsgExt(
			'phalanx-stats-row-per-wiki',
			[ 'parseinline', 'replaceafter' ],
			$type, $username, $phalanxUrl, $timestamp, $statsUrl, $url
		);
		$html .= Html::closeElement( 'li' );

		return $html;
	}

	private function buildPhalanxUrl( $blockId ) {
		return $this->mSkin->makeLinkObj(
			$this->mTitle, $blockId, "id=$blockId"
		);
	}

	private function buildStatsUrl( $blockId ) {
		return $this->mSkin->makeLinkObj(
			$this->mTitleStats,
			wfMessage( 'phalanx-link-stats' )->text(),
			'blockId=' . $blockId
		);
	}

	private function buildTypeNames( $row ) {
		$bitMask = isset( $row->ps_blocker_hit ) ? $row->ps_blocker_hit : $row->ps_blocker_type;
		return implode( ', ', Phalanx::getTypeNames( $bitMask ) );
	}
}
