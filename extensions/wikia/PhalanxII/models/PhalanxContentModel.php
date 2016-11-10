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
	public function isOk() {
		return (
			$this->wg->User->isAllowed( 'phalanxexempt' ) ||
			!( $this->title instanceof Title ) ||
			$this->isWikiaInternalRequest()
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
		$this->wg->Out->addHTML( Html::element( 'p', [], wfMessage( 'phalanx-stats-table-id' )->text() . " #{$this->block->id}" ) );
		$this->wg->Out->addWikiMsg( 'spamprotectionmatch', "<nowiki>{$this->block->text}</nowiki>" );

		// SUS-1090: Only indicate that the edit summary was blocked if it was indeed a summary block
		if ( $this->block->type === Phalanx::TYPE_SUMMARY ) {
			$this->wg->Out->addWikiMsg( 'phalanx-content-spam-summary' );
		}

		// SUS-1090: Use page title, not destination page
		$this->wg->Out->returnToMain( false, $this->wg->Title );
		$this->wg->Out->addHTML( Html::closeElement( 'div' ) );
		$this->logBlock();
	}

	public function getBlockMessage() {
		$msg = wfMessage( 'spamprotectiontext' )->parse();
		$msg .= wfMessage( 'spamprotectionmatch', $this->contentBlock() )->parse();
		return $msg;
	}

	public function contentBlock() {
		$msg = "{$this->block->text} (Block #{$this->block->id})";
		$this->logBlock();
		return $msg;
	}

	public function textBlock() {
		$this->logBlock();
		return $this->block->text;
	}

	public function match_summary( $summary ) {
		return $this->setText( $summary )->match( "summary" );
	}

	public function match_summary_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return ContentBlock::onEditFilter( '', $this->getText(), $this->block );
	}

	public function match_content( $textbox ) {
		return $this->setText( $textbox )->match( "content" );
	}

	public function match_content_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return ContentBlock::onEditFilter( $this->getText(), '', $this->block );
	}

	public function match_title() {
		return $this->match( "title" );
	}

	public function match_title_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return TitleBlock::genericTitleCheck( $this->title, $this->block );
	}

	public function match_question_title() {
		return $this->match( "question_title" );
	}

	public function match_question_title_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension - tested */
		return QuestionTitleBlock::badWordsTest( $this->title, $this->block );
	}
}
