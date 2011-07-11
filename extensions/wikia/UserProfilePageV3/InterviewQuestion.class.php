<?php

class InterviewQuestion {

	/**
	 * @var WikiaApp
	 */
	private $app = null;
	private $id = 0;
	private $wikiId = 0;
	private $body = null;
	private $order = 1;
	private $answersCount = 0;
	private $answerBody = null;
	private $caption = null;

	public function __construct( WikiaApp $app, $id = 0 ) {
		$this->app = $app;
		if( !empty($id) ) {
			$this->loadFromDd( $id );
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getWikiId() {
		return $this->wikiId;
	}

	public function setWikiId( $value ) {
		$this->wikiId = $value;
	}

	public function getBody() {
		return $this->body;
	}

	public function setBody( $value ) {
		$this->body = $value;
	}

	public function getOrder() {
		return $this->order;
	}

	public function setOrder( $value ) {
		$this->order = $value;
	}

	public function getAnswersCount() {
		return $this->answersCount;
	}

	public function setAnswersCount( $value ) {
		$this->answersCount = $value;
	}

	public function getAnswerBody() {
		return $this->answerBody;
	}

	public function setAnswerBody( $value ) {
		$this->answerBody = $value;
	}

	public function getCaption() {
		return $this->caption;
	}

	public function setCaption( $value ) {
		$this->caption = $value;
	}

	public function hasAnswer() {
		return !empty( $this->answerBody );
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_SLAVE ) {
		return $this->app->wf->getDB( $type, array(), $this->app->wg->ExternalDatawareDB );
	}

	public function loadFromDd( $id ) {
		$questionData = $this->getDb()->selectRow(
			array( 'upp_interview_question' ),
			array( 'uiqu_wiki_id', 'uiqu_body', 'uiqu_order', 'uiqu_answers_count' ),
			array( 'uiqu_id' => $id ),
			__METHOD__
		);

		if(!empty($questionData)) {
			$this->populateData( $id, $questionData );
		}
	}

	public function populateData( $id, stdClass $questionData ) {
		$this->id = $id;
		$this->wikiId = $questionData->uiqu_wiki_id;
		$this->body = $questionData->uiqu_body;
		$this->order = $questionData->uiqu_order;
		$this->answersCount = $questionData->uiqu_answers_count;
	}

	public function update() {
		$db = $this->getDb( DB_MASTER );

		$fields = array(
			'uiqu_wiki_id' => $this->wikiId,
			'uiqu_body' => $this->body,
			'uiqu_order' => $this->order,
			'uiqu_answers_count' => $this->answersCount
		);

		if($this->getId()) {
			$db->update(
				'upp_interview_question',
				$fields,
				array( "uiqu_id" => $this->getId() ),
				__METHOD__
			);
		}
		else {
			$db->insert(
				'upp_interview_question',
				$fields,
				__METHOD__
			);
			$this->id = $db->insertId();
		}
		$db->commit();
	}

	public function delete() {
		if($this->getId()) {
			$db = $this->getDb( DB_MASTER );

			$db->delete( 'upp_interview_question', array( "uiqu_id" => $this->getId() ) );
			$db->commit();
		}
	}

	public function incrAnswersCount() {
		if( $this->getId() ) {
			$db = $this->getDb( DB_MASTER );
			$db->update( 'upp_interview_question', array( "uiqu_answers_count=uiqu_answers_count+1" ), array( "uiqu_id" => $this->getId() ), __METHOD__ );
			$db->commit();

			$this->answersCount++;
		}
	}

	public function decrAnswersCount() {
		if( $this->getId() && ( $this->getAnswersCount() > 0 ) ) {
			$db = $this->getDb( DB_MASTER );
			$db->update( 'upp_interview_question', array( "uiqu_answers_count=uiqu_answers_count-1" ), array( "uiqu_id" => $this->getId() ), __METHOD__ );
			$db->commit();

			$this->answersCount--;
		}

	}

	public function toArray() {
		return array(
			'id' => $this->getId(),
			'body' => $this->getBody(),
			'answerBody' => $this->getAnswerBody(),
			'caption' => $this->getCaption()
		);
	}

}