<?php

class WikiaQuizHooks {
	public static function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);

		switch ($title->getNamespace()) {
			case NS_WIKIA_QUIZ:
				$article = new WikiaQuizIndexArticle($title);
				break;
			case NS_WIKIA_QUIZARTICLE:
				$article = new WikiaQuizArticle($title);
				break;
			case NS_WIKIA_PLAYQUIZ:
				$article = new WikiaQuizPlayArticle($title);
				break;
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	/**
	 * Override the edit button to point to the special page instead of the normal editor
	 */

	public static function onAlternateEdit( $editPage ) {
		global $wgOut;

		$title = $editPage->getArticle()->getTitle();

		switch($title->getNamespace()) {
			case NS_WIKIA_QUIZ:
				$specialPageTitle = Title::newFromText( 'CreateQuiz', NS_SPECIAL );
				break;
			case NS_WIKIA_QUIZARTICLE:
				$specialPageTitle = Title::newFromText( 'CreateQuizArticle', NS_SPECIAL );
				break;
		}
	
		if (!empty($specialPageTitle)) {
			$wgOut->redirect( $specialPageTitle->getFullUrl() . '/' . $title->getPartialURL() );
		}
		
		return true;
	}

	 /**
	 * Purge quiz article after an edit
	 */
	public static function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . "\n");

		$title = $article->getTitle();

		if (!empty($title)) {
			switch ($title->getNamespace()) {
				case NS_WIKIA_QUIZ:
					$quizIndexArticle = new WikiaQuizIndexArticle($title);
					$quizIndexArticle->doPurge();
//					$quiz = WikiaQuiz::newFromArticle($article);
//					$quiz->purge();
					break;
				case NS_WIKIA_QUIZARTICLE:
					$quizArticle = new WikiaQuizArticle($title);
					$quizArticle->doPurge();
//					$quizElement = WikiaQuizElement::newFromArticle($article);
//					$quizElement->purge();
					break;
			}
		}
			
		wfProfileOut(__METHOD__);
		return true;
	}

	public static function onTitleMoveComplete(&$title, &$newTitle, &$user, $oldid, $newid) {
		if( $title instanceof Title && $newTitle instanceof Title && $title->getNamespace() === NS_WIKIA_QUIZ ) {
			$wikiaQuizNew = WikiaQuiz::newFromTitle($newTitle);

			//if we tried to create an instance of WikiaQuiz from old title here
			//the returned value from WikiaQuiz::newFromTitle wasn't an instance
			//but the instance of WikiaQuiz created with the new title gives
			//an instance with wrong values in its fields f.e. mMemcacheKey and mQuizId
			//contains ids of the old articles instead of the new one
			//TODO:we need to add here an action that copies elements of the old quiz to the new one
			if( $wikiaQuizNew instanceof WikiaQuiz ) {
				$wikiaQuizNew->purge();
			}
		}

		return true;
	}

}
