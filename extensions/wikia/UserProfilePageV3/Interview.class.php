<?php

class Interview {

	const MAX_QUESTIONS = 6;

	/**
	 * @var WikiaApp
	 */
	private $app = null;
	private $wikiId = 0;
	private $questions = null;

	public function __construct( WikiaApp $app, $wikiId ) {
		$this->app = $app;
		$this->wikiId = $wikiId;
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_MASTER ) {
		return $this->app->wf->getDB( $type, array(), $this->app->wg->ExternalDatawareDB );
	}

	public function addOrModifyQuestion( $questionBody, $questionId = 0 ) {
		$question = F::build( 'InterviewQuestion', array( 'id' => $questionId ) );
		$question->setBody( $questionBody );
		$question->setWikiId( $this->wikiId );
		$question->update();

		$this->questions = null;

		return $question;
	}

	public function isAddingAllowed() {
		return (bool) ( $this->getQuestionsNum() < self::MAX_QUESTIONS );
	}

	public function getQuestionsNum() {
		return count( $this->getQuestions() );
	}

	public function getQuestions() {
		if( $this->questions == null ) {
			$this->questions = array();
			$res = $this->getDb()->select(
				array( 'upp_interview_question' ),
				array( '*' ),
				array( 'uiqu_wiki_id' => $this->wikiId ),
				__METHOD__,
				array( 'ORDER BY' => 'uiqu_order' )
			);

			while( $row = $this->getDb()->fetchObject( $res ) ) {
				$question = F::build( 'InterviewQuestion' );
				$question->populateData( $row->uiqu_id, $row );

				$this->questions[$row->uiqu_id] = $question;
			}

		}

		return $this->questions;
	}

	public function removeQuestion( $questionId ) {
		$question = F::build( 'InterviewQuestion', array( 'id' => $questionId ) );
		$question->delete();

		unset($this->questions[$questionId]);
	}

}