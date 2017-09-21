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

		// Get row data
		$type = $this->buildTypeNames( $row );
		$username = $row->ps_blocked_user;
		$phalanxUrl = $this->buildPhalanxUrl( $blockId );
		$timestamp = $this->getLanguage()->timeanddate( $row->ps_timestamp );
		$statsUrl = $this->buildStatsUrl( $blockId );
		$url = $this->getReferrerWikiLink( $row );

		// Format the data with the phalanx-stats-row-per-wiki key and wrap it in an <li> tag
		$html = Html::openElement( 'li' );
		$html .= $this->msg( 'phalanx-stats-row-per-wiki' )
			->params( $type, $username )
			->rawParams( $phalanxUrl )
			->params( $timestamp )
			->rawParams( $statsUrl )
			->params( $url )
			->parse();
		$html .= Html::closeElement( 'li' );

		return $html;
	}

	private function buildPhalanxUrl( $blockId ) {
		return Linker::linkKnown(
			$this->mTitle, $blockId, "id=$blockId"
		);
	}

	private function buildStatsUrl( $blockId ) {
		return Linker::linkKnown(
			$this->mTitleStats,
			$this->msg( 'phalanx-link-stats' )->escaped(),
			'blockId=' . $blockId
		);
	}

	private function buildTypeNames( $row ) {
		$bitMask = isset( $row->ps_blocker_hit ) ? $row->ps_blocker_hit : $row->ps_blocker_type;
		return implode( ', ', Phalanx::getTypeNames( $bitMask ) );
	}
}
