<?php

class TemplateDraftHelper {

	/**
	 * Overrides content of parent page with contents of draft page
	 * @param Title $draftTitle Title object of sub page (draft)
	 * @throws PermissionsException
	 */
	public function approveDraft( Title $draftTitle ) {
		// Get Title object of parent page
		$helper = new TemplateDraftHelper();
		$parentTitle = $helper->getParentTitle( $draftTitle );

		// Check edit rights
		if ( !$parentTitle->userCan( 'templatedraft' ) ) {
			throw new PermissionsException( 'edit' );
		}

		// Get contents of draft page
		$article = Article::newFromId( $draftTitle->getArticleID() );
		$draftContent = $article->getContent();
		// Get WikiPage object of parent page
		$page = WikiPage::newFromID( $parentTitle->getArticleID() );
		// Save to parent page
		$page->doEdit( $draftContent, wfMessage( 'templatedraft-approval-summary' )->inContentLanguage()->plain() );

		// Remove Draft page
		$draftPage = WikiPage::newFromID( $draftTitle->getArticleID() );
		$draftPage->doDeleteArticle( wfMessage( 'templatedraft-draft-removal-summary' )->inContentLanguage()->plain() );

		// Show a confirmation message to a user after redirect
		BannerNotificationsController::addConfirmation(
			wfMessage( 'templatedraft-approval-success-confirmation' )->escaped(),
			BannerNotificationsController::CONFIRMATION_CONFIRM,
			true
		);
	}

	/**
	 * Checks if a Title is a new one and if it fits /Draft criteria.
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function isTitleNewDraft( Title $title ) {
		return !$title->exists()
			&& $this->isTitleDraft( $title );
	}

	/**
	 * Checks if the Title object is a Draft subpage of a template
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function isTitleDraft( Title $title ) {
		return $title->getNamespace() === NS_TEMPLATE
			&& $title->isSubpage()
			&& ( $title->getSubpageText() === wfMessage( 'templatedraft-subpage' )->inContentLanguage()->escaped()
				|| $title->getSubpageText() === wfMessage( 'templatedraft-subpage' )->inLanguage( 'en' )->escaped() );
	}

	/**
	 * Checks if the template (Title object) is marked by human as infobox
	 *
	 * @param Title $title
	 * @return bool
	 */
	public function isMarkedAsInfobox( Title $title ) {
		return Wikia::getProps( $title->getArticleID(), TemplateDraftController::TEMPLATE_INFOBOX_PROP ) !== '0';
	}

	/**
	 * Parent page has to meet criteria to allow showing template draft rail modules
	 * Assuming namespace and existance is already chacked
	 * @param Title $title
	 * @return bool
	 */
	public function isParentValid( Title $title ) {
		return $title->userCan( 'templatedraft' ) && $this->isMarkedAsInfobox( $title );
	}

	/**
	 * Retrieves parent Title object from provided $title
	 *
	 * @param Title $title
	 * @return Title Parent Title
	 * @throws MWException
	 */
	public function getParentTitle( Title $title ) {
		return Title::newFromText( $title->getBaseText(), NS_TEMPLATE );
	}
}
