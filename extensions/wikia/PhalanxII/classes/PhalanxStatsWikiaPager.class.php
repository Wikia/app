<?php
class PhalanxStatsWikiaPager extends PhalanxStatsPager {
	public $qCond = 'ps_wiki_id';
	public $pInx = false;
	public $mTitle;
	public $mTitleStats;

	public function __construct( $id ) {
		parent::__construct( $id );
		$this->mTitle = SpecialPage::getTitleFor( 'Phalanx' );
		$this->mTitleStats = SpecialPage::getTitleFor( 'PhalanxStats' );
	}

	function formatRow( $row ) {
		$blockId = (int) $row->ps_blocker_id;

		$type = $this->buildTypeNames( $row );
		// SUS-3443: we either store (user ID, "") or (0, IP address) pair
		$userName = User::getUsername( (int) $row->ps_blocked_user_id, $row->ps_blocked_user );

		$phalanxUrl = $this->buildPhalanxUrl( $blockId );
		$timestamp = $this->getLanguage()->timeanddate( $row->ps_timestamp );
		$statsUrl = $this->buildStatsUrl( $blockId );
		$url = $row->ps_referrer;

		// Format the data with the phalanx-stats-row-per-wiki key and wrap it in an <li> tag
		$html = Html::openElement( 'li' );
		$html .= $this->msg( 'phalanx-stats-row-per-wiki' )->rawParams(
			$type, $userName, $phalanxUrl, $timestamp, $statsUrl, $url
		)->parse();
		$html .= Html::closeElement( 'li' );

		return $html;
	}

	private function buildPhalanxUrl( int $blockId ) {
		return Linker::linkKnown( $this->mTitle, $blockId, [], [ 'blockId' => $blockId ] );
	}

	private function buildStatsUrl( int $blockId ) {
		return Linker::linkKnown(
			$this->mTitleStats,
			$this->msg( 'phalanx-link-stats' )->escaped(),
			[],
			[ 'blockId' => $blockId ]
		);
	}

	private function buildTypeNames( $row ) {
		$bitMask = isset( $row->ps_blocker_hit ) ? $row->ps_blocker_hit : $row->ps_blocker_type;
		return implode( ', ', Phalanx::getTypeNames( $bitMask ) );
	}
}
