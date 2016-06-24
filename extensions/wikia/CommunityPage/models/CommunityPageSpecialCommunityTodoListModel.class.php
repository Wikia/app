<?php

class CommunityPageSpecialCommunityTodoListModel {
	public function getData() {
		$title = Title::newFromText(
			wfMessage( 'communitypage-todo-module-page-name' )->inContentLanguage()->plain(),
			NS_MEDIAWIKI
		);

		$editUrl = $title->getFullURL( ['action' => 'edit'] );

		if ( $title->exists() ) {
			$parsedArticle = ( Article::newFromTitle( $title, RequestContext::getMain() ) )->getParserOutput();

			return [
				'haveContent' => true,
				'editUrl' => $editUrl,
				'data' => $parsedArticle->getText(),
			];
		} else {
			return [
				'haveContent' => false,
				'editUrl' => $editUrl,
			];
		}
	}
}
