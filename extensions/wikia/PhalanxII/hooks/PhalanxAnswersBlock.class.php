<?php

/**
 * This filter blocks questions (articles) from being displayed
 * in a number of outputs (widgets, lists, tag-generated listings).
 *
 * It does not block those articles from being created.
 *
 * Note: works only on Answers-type wikis
 */

class PhalanxAnswersBlock extends WikiaObject {
	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	public function badWordsTest( $title ) {
		$this->wf->profileIn( __METHOD__ );

		$ret = true;
		$phalanxModel = F::build('PhalanxTitleModel', array( $title ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}

		$text = preg_replace('/[^\PP]+/', '', $title->getText());
		$text = preg_replace('/\s+/', ' ', $text);
		
		$result = $phalanxModel->setText( $text )->match( "question_title", $this->wg->LangugeCode );
		if ( $result !== false ) {
			if ( is_numeric( $result ) && $result > 0 ) {
				/* user is blocked - we have block ID and send information to logger */
				$phalanxModel->setBlockId( $result )->logBlock();
				$ret = false;
			}
		} else {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/QuestionTitleBlock.class.php';
			// $ret = QuestionTitleBlock::badWordsTest( $title );		
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}

	public function filterWordsTest( $title ) {
		$this->wf->profileIn( __METHOD__ );

		$ret = true;
		$phalanxModel = F::build('PhalanxTitleModel', array( $title ) );

		if ( $phalanxModel->isOk() ) {
			$this->wf->profileOut( __METHOD__ );
			return true;
		}

		$question = $title->getText();
		$text = preg_replace('/[^\PP]+/', '', $question );
		$text = preg_replace('/\s+/', ' ', $text);
		
		$result = $phalanxModel->setText( $text )->match( "recent_questions", $this->wg->LangugeCode );
		if ( $result !== false ) {
			if ( is_numeric( $result ) && $result > 0 ) {
				/* user is blocked - we have block ID */
				$phalanxModel->setBlockId( $result )->logBlock( $text );
				$ret = false;
			}
		} else {
			// TO DO
			/* problem with Phalanx service? */
			// include_once( dirname(__FILE__) . '/../prev_hooks/RecentQuestionsBlock.class.php';
			// $ret = RecentQuestionsBlock::filterWordsTest( $question );		
		}
		
		$this->wf->profileOut( __METHOD__ );
		return $ret;
	}
}
