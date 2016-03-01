<?php

class DefaultQuestion {

	function __construct( $question ) {
		global $wgRequest;

		//if its all caps, tone it down!
		if( strtoupper( $question ) == $question ){
			$question = strtolower( $question );
		}

		//strip question marks and slashes
		$question = Answer::q2s($question);
		$question = str_replace("?", " ", $question);

		//remove "Ask a question" or equivalent if it got here
		//question is in DBkey form, with underscores
		$search = str_replace( " ", "_", wfMsgForContent( 'ask_a_question' ) );
		if ( strpos( $question, $search ) === 0 ) {
			$question = substr( $question, strlen( $search ) );
			$question = ltrim( $question );
		}

		$this->title = Title::makeTitleSafe( NS_MAIN, $question );
		if ( !$this->title ) {
			return null;
		}

		$this->question = $this->title->getText();

		$this->categories = $wgRequest->getVal("categories");
	}

	function create() {
		global $wgUser, $wgContLang;

		if ( wfReadOnly() ) {
			return false;
		}

		if ( empty( $this->title ) || !$this->title->userCan( 'edit' ) || !$this->title->userCan( 'create' ) ) {
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

		$default_text = Answer::getSpecialCategoryTag("unanswered");

		//add default category tags passed in
		if( $this->categories ){
			$categories_array = explode("|", $this->categories);
			foreach( $categories_array as $category ){
				$default_text .= "\n[[" . $wgContLang->getNsText( NS_CATEGORY ) . ":" . ucfirst( $category ) . "]]";
			}
		}

		$flags = EDIT_NEW;
		$article = new Article( $this->title );
		$article->doEdit( $default_text, wfMsgForContent("new_question_comment"), $flags );

		if( $wgUser->isLoggedIn() ){
			// check user preferences before adding to watchlist (RT #45647)
			$watchCreations = $wgUser->getGlobalPreference('watchcreations');
			if (!empty($watchCreations)) {
				$wgUser->addWatch( $this->title );
			}
		}

		//store question in session so we can give attribution if they create an account afterwards
		$_SESSION['wsQuestionAsk'] = "";
		if( $wgUser->isAnon() ){
			$_SESSION['wsQuestionAsk'] = $this->question;
		}

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

		$swear_words = array();
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
		// changed $this->question => $this->title (2013/01/27)
		if ( !wfRunHooks( 'DefaultQuestion::filterWordsTest' , array( $this->title )) ) {
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
