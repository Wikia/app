<?php

class WikiaPollController extends WikiaController {

	public function init() {
		$this->data = null;
		$this->poll = null;
		$this->embedded = null;
	}

	/**
	 * Render HTML Poll namespace pages
	 */
	public function executeIndex($params) {
		if (!empty($params['poll'])) {
			$this->poll = $params['poll'];
			$data = $this->poll->getData();
			$data = $this->formatResults($data);
			$this->data = $data;
		}

		$this->embedded = !empty($params['embedded']);

		if( $this->app->checkSkin( 'wikiamobile' ) ) {
			$answer = $this->wg->Request->getInt( 'answer' );
			$this->response->setVal( 'showButton' , empty( $answer ) );
			$this->response->setVal( 'answerNum' , $answer );
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}
	}

	public function executeSpecialPage() {
		$this->editToken = $this->getContext()->getUser()->getEditToken();
	}

	public function executeSpecialPageEdit($params) {
		$title = Title::newFromText ($params['title'], NS_WIKIA_POLL) ;

		if ($title instanceof Title && $title->exists()) {
			$this->poll = WikiaPoll::NewFromTitle($title);
			$this->data = $this->poll->getData();
			$this->editToken = $this->getContext()->getUser()->getEditToken();
		}
	}

	/**
	 * Calculate percantage for votes and scale bars
	 */
	private function formatResults($data) {
		// format results
		foreach($data['answers'] as &$answer) {
			if ($data['votes'] > 0) {
				$answer['percentage'] = round($answer['votes'] / $data['votes'] * 100);
			}
			else {
				$answer['percentage'] = 0;
			}
		}

		return $data;
	}
}
