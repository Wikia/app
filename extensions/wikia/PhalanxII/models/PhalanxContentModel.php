<?php

class PhalanxContentModel extends PhalanxModel {

	/* @var Title $title */
	protected $title = null;

	/**
	 * @param Title $title
	 */
	public function __construct( Title $title ) {
		parent::__construct();
		$this->title = $title;
	}

	/**
	 * Skip calls to Phalanx service if this method returns true
	 *
	 * @return bool
	 */
	public function isOk(): bool {
		global $wgUser;

		return (
			!( $this->title instanceof Title ) ||
			$this->isWikiaInternalRequest() ||
			$wgUser->isAllowed( 'phalanxexempt' )
		);
	}

	public function getText() {
		return !is_null( $this->text ) ? $this->text : $this->title->getFullText();
	}

	public function displayBlock() {
		$this->wg->Out->setPageTitle( wfMessage( 'spamprotectiontitle' ) );
		$this->wg->Out->setRobotPolicy( 'noindex,nofollow' );
		$this->wg->Out->setArticleRelated( false );
		$this->wg->Out->addHTML( Html::openElement( 'div', [ 'id' => 'spamprotected_summary' ] ) );
		$this->wg->Out->addWikiMsg( 'spamprotectiontext' );
		$this->wg->Out->addHTML( Html::element( 'p', [], wfMessage( 'phalanx-stats-table-id' )->text() . " #{$this->block->getId()}" ) );
		$this->wg->Out->addWikiMsg( 'spamprotectionmatch', "<nowiki>{$this->block->getText()}</nowiki>" );

		// SUS-1090: Only indicate that the edit summary was blocked if it was indeed a summary block
		if ( $this->block->getType() === Phalanx::TYPE_SUMMARY ) {
			$this->wg->Out->addWikiMsg( 'phalanx-content-spam-summary' );
		}

		// SUS-1090: Use page title, not destination page
		$this->wg->Out->returnToMain( false, $this->wg->Title );
		$this->wg->Out->addHTML( Html::closeElement( 'div' ) );
	}

	public function getBlockMessage() {
		$msg = wfMessage( 'spamprotectiontext' )->parse();
		$msg .= wfMessage( 'spamprotectionmatch', $this->contentBlock() )->parse();
		return $msg;
	}

	public function contentBlock() {
		$msg = "{$this->block->getText()} (Block #{$this->block->getId()})";
		return $msg;
	}

	public function textBlock() {
		return $this->block->getText();
	}

	public function match_summary( $summary ) {
		return $this->setText( $summary )->match( "summary" );
	}

	public function match_content( $textbox ) {
		return $this->setText( $textbox )->match( "content" );
	}

	public function match_title() {
		return $this->match( "title" );
	}

	public function match_question_title() {
		return $this->match( "question_title" );
	}
}
