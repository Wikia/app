<?php

class PhalanxContentModel extends PhalanxModel {
	protected $title = null;
	const SPAM_WHITELIST_TITLE = 'Spam-whitelist';
	const SPAM_WHITELIST_NS_TITLE = 'Mediawiki:Spam-whitelist';

	public function __construct( $title, $lang = '', $id = 0 ) {
		parent::__construct( __CLASS__, array( 'title' => $title, 'lang' => $lang, 'id' => $id ) );
	}
	
	public function isOk() { 
		return ( !( $this->title instanceof Title ) || ( $this->title->getPrefixedText() == self::SPAM_WHITELIST_NS_TITLE ) );
	}

	public function getText() {
		return preg_replace( '/\s+/', ' ', preg_replace( '/[^\PP]+/', '', ( isset( $this->text ) ) ? $this->text : $this->title->getFullText() ) );
	}

	public function buildWhiteList() {
		$this->wf->profileIn( __METHOD__ );

		$whitelist = array();
		$content = $this->wf->msgForContent( self::SPAM_WHITELIST_TITLE );
		
		if ( $this->wf->emptyMsg( self::SPAM_WHITELIST_TITLE, $content ) ) {
			$this->wf->profileOut( __METHOD__ );
			return $whitelist;
		}
			
		$content = array_filter( array_map( 'trim', preg_replace( '/#.*$/', '', explode( "\n", $content ) ) ) );
		if ( !empty( $content ) ) {
			foreach ( $content as $regex ) {
				$regex = str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $regex) );
				$regex = "/https?:\/\/+[a-z0-9_.-]*$regex/i";
				$this->wf->suppressWarnings();
				$regexValid = preg_match($regex, '');
				$this->wf->restoreWarnings();
				if ( $regexValid === false ) continue;
				$whitelist[] = $regex;
			}
		}

		Wikia::log( __METHOD__, __LINE__, count( $whitelist ) . ' whitelist entries loaded.' );

		$this->wf->profileOut( __METHOD__ );
		return $whitelist;
	}
	
	public function displayBlock() {
		$this->wg->Out->setPageTitle( $this->wf->msg( 'spamprotectiontitle' ) );
		$this->wg->Out->setRobotPolicy( 'noindex,nofollow' );
		$this->wg->Out->setArticleRelated( false );
		$this->wg->Out->addHTML( Html::openElement( 'div', array( 'id' => 'spamprotected_summary' ) ) );
		$this->wg->Out->addWikiMsg( 'spamprotectiontext' );
		$this->wg->Out->addHTML( Html::element( 'p', array(), wfMsg( '( Call ' . get_class( $this ) . ' )' ) ) );
		$this->wg->Out->addWikiMsg( 'spamprotectionmatch', "<nowiki>{Block #{$this->block->id}</nowiki>" );
		$this->wg->Out->addWikiMsg( 'phalanx-content-spam-summary' );
		$this->wg->Out->returnToMain( false, $this->title );
		$this->wg->Out->addHTML( Html::closeElement( 'div' ) );
		$this->logBlock();
	}
	
	public function contentBlock() {
		$msg = "Block #{$this->block->id}";
		$this->logBlock();
		return $msg;
	}
	
	public function reasonBlock() {
		$msg = $this->wf->msgExt( 'phalanx-title-move-summary', 'parseinline' );
		$msg .= $this->wf->msgExt( 'spamprotectionmatch', 'parseinline', "<nowiki>{Block #{$this->block->id}</nowiki>" );
		$this->logBlock();
		
		return $msg;
	}
	
	public function match_summary( $summary ) {
		return $this->setText( $summary )->match( "summary" );
	} 
	
	public function match_summary_old() {
		// TO DO
		/* problem with Phalanx service? */
		// include_once( dirname(__FILE__) . '/../prev_hooks/ContentBlock.class.php';
		// $ret = ContentBlock::onEditFilter( $editPage, $text, $section, &$hookError, $summary );
		return true;
	}
	
	public function match_content( $textbox ) {
		return $this->setText( $textbox )->match( "content" );
	}
	
	public function match_content_old() {
		// TO DO
		/* problem with Phalanx service? */
		// include_once( dirname(__FILE__) . '/../prev_hooks/ContentBlock.class.php';
		// $ret = ContentBlock::onEditFilter( $editPage );
		return true;
	}
	
	public function match_title() {
		return $this->match( "title" );
	}
	
	public function match_title_old() {
		// TO DO
		/* problem with Phalanx service? */
		// include_once( dirname(__FILE__) . '/../prev_hooks/TitleBlock.class.php';
		// $ret = TitleBlock::genericTitleCheck( $title );
		return true;
	}

	public function match_question_title() {
		return $this->match( "question_title" );
	}
	
	public function match_question_title_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension */
		return QuestionTitleBlock::badWordsTest( $this->title );			
	}
	
	public function match_recent_questions() {
		return $this->match( "recent_questions" );
	}
	
	public function match_recent_questions_old() {
		/* problem with Phalanx service? - use previous version of Phalanx extension */
		return RecentQuestionsBlock::filterWordsTest( $this->getText() );					
	}
}
