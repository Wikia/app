<?php
class PhalanxTitleModel extends PhalanxContentModel {
	public function isOk() {
		return ( !( $this->title instanceof Title ) );
	}

	public function displayBlock( $text ) {
		$this->wg->Out->setPageTitle( $this->wf->msg( 'spamprotectiontitle' ) );
		$this->wg->Out->setRobotPolicy( 'noindex,nofollow' );
		$this->wg->Out->setArticleRelated( false );
		$this->wg->Out->addWikiMsg( 'spamprotectiontext' );
		$this->wg->Out->addHTML( Html::element( 'p', array(), wfMsg( '( Call #9 )' ) ) );
		$this->wg->Out->addWikiMsg( 'spamprotectionmatch', "<nowiki>{Block #{$this->blockId}</nowiki>" );
		$this->wg->Out->returnToMain( false, $this->title );
		Wikia::log( __METHOD__, __LINE__, "Block '#{$this->blockId}' blocked '{$text}'." );
	}
}
