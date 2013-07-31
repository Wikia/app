<?php
class PhalanxStatsWikiaPager extends PhalanxStatsPager {
	public function __construct( $id ) {
		parent::__construct( $id );
		$this->qCond = 'ps_wiki_id';
		$this->pInx = 'wikiId';
		$this->mTitle = Title::newFromText( 'Phalanx', NS_SPECIAL );
		$this->mTitleStats = Title::newFromText( 'PhalanxStats', NS_SPECIAL );
	}
	
	function formatRow( $row ) {
		$type = implode( ", ", Phalanx::getTypeNames( ( isset( $row->ps_blocker_hit ) ) ? $row->ps_blocker_hit : $row->ps_blocker_type ) );
		$username = $row->ps_blocked_user;
		$timestamp = $this->app->wg->Lang->timeanddate( $row->ps_timestamp );
		$url = $row->ps_referrer;
		$blockId = (int) $row->ps_blocker_id;
		# block
		$phalanxUrl = $this->mSkin->makeLinkObj( $this->mTitle, $blockId, 'id=' . $blockId );
		# stats
		$statsUrl = $this->mSkin->makeLinkObj( $this->mTitleStats, wfMsg('phalanx-link-stats'), 'blockId=' . $blockId );

		$html  = Html::openElement( 'li' );
		$html .= wfMsgExt( 'phalanx-stats-row-per-wiki', array('parseinline', 'replaceafter'), $type, $username, $phalanxUrl, $timestamp, $statsUrl, $url );
		$html .= Html::closeElement( 'li' );

		return $html;
	}
}
