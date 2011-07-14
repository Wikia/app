<?php

class Question {

	private $title;
	private $question;

	function __construct( $question ) {
		//if its all caps, tone it down!
		if( strtoupper( $question ) == $question ) {
			$question = strtolower( $question );
		}

		//strip question marks and slashes
		$question = ucfirst(trim($question, "¿? \t\n\r\0\x0B"));
		$question = str_replace("?", " ", $question);


		$this->title = Title::makeTitleSafe( NS_QUESTION, $question );
		if ( !$this->title ) {
			return null;
		}

		$this->question = $this->title->getText();
	}

	function getTitle() { return $this->title; }
	function getQuestion() { return $this->question; }

	function create() {
		global $wgContLang;

		if ( wfReadOnly() ) {
			return false;
		}

		if ( empty( $this->title ) || !$this->title->userCan( 'ask-questions' ) ) {
			return false;
		}

		if ( $this->badWordsTest() ) {
			return false;
		}

		if ( !wfRunHooks( 'CreateDefaultQuestionPageFilter', array($this->title) ) ) {
			wfDebug(__METHOD__ . ": question '{$this->title}' filtered out by hook\n");
			return false;
		}

		if ( $this->searchTest() ) {
			return false;
		}

		$default_text = '[['.$wgContLang->getNsText(NS_CATEGORY).':'.wfMsgForContent('unanswered-category').']]';

		$article = new Article( $this->title );
		$article->doEdit( $default_text, wfMsgForContent("new-question"), EDIT_NEW );

		return true;
	}

	// redirect one or two word questions to search
	function searchTest() {
		global $wgDisableAnswersShortQuestionsRedirect;
		if (!empty($wgDisableAnswersShortQuestionsRedirect)) {
			return false;
		}

		$words = explode(" ", $this->question );
		if( count( $words ) < 3 ) {
			return true;
		}

		return false;
	}

	function getBadWords() {
		$swear_content = wfMsgForContent("BadWords");

		// FIXME: hack for #41845 -- to be removed when we have correct fallback
		if ( wfEmptyMsg( 'BadWords', $swear_content ) ) {
			$swear_content = wfMsgExt( 'BadWords', array( 'language' => 'en' ) );
		}

		$swear_list = explode( "\n", $swear_content );
		foreach ( $swear_list as $swear ) {
			if ( $swear ) {
				$swear_words[] = $swear;
			}
		}
		return $swear_words;
	}

	// don't allow swear words when creating new question / generating list of recenlty asked questions (via HPL)
	function badWordsTest() {
		global $wgOut;

		// TODO: temporary check for Phalanx (don't perform additional filtering when enabled)
		global $wgEnablePhalanxExt;
		if (!empty($wgEnablePhalanxExt)) {
			return false;
		}

		// remove punctations
		$search_test = preg_replace('/\pP+/', '', $this->question);
		$search_test = preg_replace('/\s+/', ' ', $search_test);

		$found = preg_match('/\s('.implode('|',$this->getBadWords()).')\s/i', ' ' . $search_test . ' ' );
		if( $found ){
			return true;
		}

		return false;
	}

	function getFilterWords() {
		global $wgMemc;
		$mkey =  wfMemcKey(__METHOD__);
		$filtered_words = $wgMemc->get($mkey);
		if ( empty($filtered_words) ) {
			$filtered = wfMsgForContent("FilterWords");
			if ( !wfEmptyMsg( 'FilterWords', $filtered ) ) {
				$aFiltered = explode( "\n", $filtered );
				foreach ( $aFiltered as $filter ) {
					if ( $filter ) {
						$filtered_words[] = $filter;
					}
				}
				$wgMemc->set($mkey, $filtered_words, 3*60);
			}
		}
		return $filtered_words;
	}

	// don't allow swear words when generating list of recenlty asked questions (via HPL)
	function filterWordsTest() {
		global $wgOut;

		if ( !wfRunHooks( 'Question::filterWordsTest' , array($this->question)) ) {
			wfDebug(__METHOD__ . ": question '{$this->question}' filtered out by hook\n");
			return true;
		}

		// TODO: temporary check for Phalanx (don't perform additional filtering when enabled)
		global $wgEnablePhalanxExt;
		if (!empty($wgEnablePhalanxExt)) {
			return false;
		}

		// remove punctations
		$search_test = preg_replace('/\pP+/', '', $this->question);
		$search_test = preg_replace('/\s+/', ' ', $search_test);

		$words = $this->getFilterWords();
		if ( !empty($words) ) {
			$found = preg_match('/\s('.implode('|', $words).')\s/i', ' ' . $search_test . ' ' );
			if( $found ){
				wfDebug(__METHOD__ . ": question '{$search_test}' filtered out\n");
				return true;
			}
		}

		return false;
	}
}
