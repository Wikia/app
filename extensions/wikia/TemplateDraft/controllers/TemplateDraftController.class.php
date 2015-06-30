<?php

class TemplateDraftController extends WikiaController {

	/**
	 * Properties used in page_props table, construction:
	 * * tc- - prefix for "template classification"
	 * * -marked- - signifies classification decision made by human
	 * * -auto- - signifies classification decision made by AI
	 * * -infobox - suffix denoting the type of template we identified
	 */
	const TEMPLATE_INFOBOX_PROP = 'tc-marked-infobox';

	/**
	 * Flags indicating type of the template
	 */
	const TEMPLATE_GENERAL = 1;
	const TEMPLATE_INFOBOX = 2;

	/**
	 * Converts the content of the template according to the given flags.
	 *
	 * @param $content
	 * @param $flags Array
	 * @return string
	 */
	public function createDraftContent( Title $title, $content, Array $flags ) {
		$flagsSum = array_sum( $flags );

		if ( self::TEMPLATE_INFOBOX & $flagsSum ) {
			$templateConverter = new TemplateConverter( $title );
			$newContent = $templateConverter->convertAsInfobox( $content );
			$newContent .= $templateConverter->generatePreviewSection( $content );
		}

		return $newContent;
	}

	/**
	 * Overrides content of parent page with contents of draft page
	 * @param Title $title Title object of sub page (draft)
	 * @throws PermissionsException
	 */
	public function approveDraft( Title $title ) {
		// Get Title object of parent page
		$helper = new TemplateDraftHelper();
		$parentTitle = $helper->getParentTitle( $title );

		// Check edit rights
		if ( !$parentTitle->userCan( 'templatedraft' ) ) {
			throw new PermissionsException( 'edit' );
		}

		// Get contents of draft page
		$article = Article::newFromId( $title->getArticleID() );
		$draftContent = $article->getContent();
		// Get WikiPage object of parent page
		$page = WikiPage::newFromID( $parentTitle->getArticleID() );
		// Save to parent page
		$page->doEdit( $draftContent, wfMessage( 'templatedraft-approval-summary' )->inContentLanguage()->plain() );
	}

	public function markTemplateAsNotInfobox() {
		/**
		 * First, validate a request
		 */
		if ( !$this->wg->Title->userCan( 'templatedraft', $this->wg->User )
			|| !$this->isValidPostRequest()
		) {
			$this->response->setVal( 'status', false );
			return false;
		}

		/**
		 * Then check the pageId param
		 */
		$pageId = $this->getRequest()->getInt( 'pageId' );
		if ( $pageId === 0 ) {
			$this->response->setVal( 'status', false );
			return false;
		}

		/**
		 * Wikia::setProps unfortunately fails silently so if we get to this point
		 * we can set the response's status to true anyway...
		 */
		$this->response->setVal( 'status', true );

		Wikia::setProps( $pageId, [
			self::TEMPLATE_INFOBOX_PROP => 0,
		] );

		return true;
	}

	private function isValidPostRequest() {
		$editToken = $this->getRequest()->getParams()['editToken'];
		return $this->getRequest()->wasPosted()
			&& $this->wg->User->matchEditToken( $editToken );
	}
}
