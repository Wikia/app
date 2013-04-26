<?php

class ArticleMetaDescriptionHelpers {
	public static function descriptionFromMessage( $wgTitle ) {
		$sMessage = null;
		if( !wfEmptyMsg( "Description" ) ) {
			$sMainPage = wfMsgForContent('Mainpage');
			if(strpos($sMainPage, ':') !== false) {
				$sTitle = $wgTitle->getFullText();
			}
			else {
				$sTitle = $wgTitle->getText();
			}

			if(strcmp($sTitle, $sMainPage) == 0) {
				// we're on Main Page, check MediaWiki:Description message
				$sMessage = wfMsg("Description");
			}
		}
		return $sMessage;
	}

	public static function descriptionFromSnippet( $wgTitle ) {
		$DESC_LENGTH = 100;
		$articleId = $wgTitle->getArticleID();
		$articleService = new ArticleService( $articleId );
		return $articleService->getTextSnippet( $DESC_LENGTH );
	}

}
