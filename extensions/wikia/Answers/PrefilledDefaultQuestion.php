<?php

class PrefilledDefaultQuestion extends DefaultQuestion {
	function create( $text ) {
		global $wgOut, $wgUser, $wgContLang;

		if ( wfReadOnly() ) {
			return false;
		}

		if ( $this->badWordsTest() ) {
			return false;
		}

		if ( !wfRunHooks( 'CreateDefaultQuestionPageFilter', array($this->title) ) ) {
			return false;
		}

		if ( !$this->title->userCan( 'edit' ) || !$this->title->userCan( 'create' ) ) {
			return false;
		}

		if ( $this->searchTest() ) {
			return false;
		}

		$default_text = $text . Answer::getSpecialCategoryTag("unanswered");

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
			$wgUser->addWatch( $this->title );
		}

		//store question in session so we can give attribution if they create an account afterwards
		$_SESSION['wsQuestionAsk'] = "";
		if( $wgUser->isAnon() ){
			$_SESSION['wsQuestionAsk'] = $this->question;
		}

		return true;
	}
}


