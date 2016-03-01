<?php
/**
 * Move draft page content to parent page
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA
 *
 * @file
 * @ingroup Actions
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

class ApprovedraftAction extends FormlessAction {
	const ACTION_NAME = 'approvedraft';

	public function getName() {
		return self::ACTION_NAME;
	}

	protected function getDescription() {
		return '';
	}

	public function onView() {
		$title = $this->getTitle();
		$request = $this->getRequest();

		$redirectParams = wfArrayToCGI( array_diff_key(
			$this->getRequest()->getQueryValues(),
			[ 'title' => null, 'action' => null, 'token' => null ]
		) );

		// Must have valid token for this action/title
		$salt = [ $this->getName(), $title->getDBkey() ];

		if ( !$this->getUser()->matchEditToken( $request->getVal( 'token' ), $salt ) ) {
			$this->addBannerNotificationMessage( 'sessionfailure' );
			$redirectTitle = $title;
		} elseif ( !$title->exists() ) {

			$this->addBannerNotificationMessage( 'templatedraft-approval-no-page-error' );
			$redirectTitle = $title;

		} elseif ( !TemplateDraftHelper::isTitleDraft( $title ) ) {

			$this->addBannerNotificationMessage( 'templatedraft-approval-no-templatedraft-error' );
			$redirectTitle = $title;

		} else {

			$this->approveDraft( $title );

			$redirectTitle = $title->getBaseText();
			$redirectTitle = Title::newFromText( $redirectTitle, $title->getNamespace() );

		}

		$this->getOutput()->redirect( $redirectTitle->getFullUrl( $redirectParams ) );
	}

	/**
	 * Get token to approve a draft page for a user.
	 *
	 * @param Title $title Title object of the draft page to approve
	 * @param User $user User for whom the action is going to be performed
	 * @return string Token
	 */
	public static function getApproveToken( Title $title, User $user ) {
		$salt = [ self::ACTION_NAME, $title->getDBkey() ];

		// This token stronger salted
		// It's title/action specific because index.php is GET and API is POST
		return $user->getEditToken( $salt );
	}

	/**
	 * Overrides content of parent page with contents of draft page
	 * @param Title $draftTitle Title object of sub page (draft)
	 * @throws PermissionsException
	 */
	private function approveDraft( Title $draftTitle ) {
		global $wgEnableInsightsInfoboxes;

		// Get Title object of parent page
		$parentTitle = TemplateDraftHelper::getParentTitle( $draftTitle );

		// Check edit rights
		if ( !$parentTitle->userCan( 'templatedraft' ) || !$parentTitle->userCan( 'edit' ) ) {
			throw new ErrorPageError( 'badaccess', 'templatedraft-protect-edit' );
		}

		// Get contents of draft page
		$article = Article::newFromId( $draftTitle->getArticleID() );
		$draftContent = $article->getContent();

		// update the draft to show a preview of the correct page
		$draftContent = str_replace(
			$draftTitle->getText(),
			$draftTitle->getBaseText(),
			$draftContent
		);

		// Get WikiPage object of parent page
		$page = WikiPage::factory( $parentTitle );
		// Save to parent page
		$page->doEdit( $draftContent, wfMessage( 'templatedraft-approval-summary' )->inContentLanguage()->plain() );

		// Remove Draft page
		$draftPage = WikiPage::newFromID( $draftTitle->getArticleID() );
		$draftPage->doDeleteArticle( wfMessage( 'templatedraft-draft-removal-summary' )->inContentLanguage()->plain() );

		// Update Infoboxes Insights list if enabled
		if ( $wgEnableInsightsInfoboxes ) {
			$model = new InsightsUnconvertedInfoboxesModel();
			( new InsightsCache( $model->getConfig() ) )->updateInsightsCache( $parentTitle->getArticleID() );
		}

		// Show a confirmation message to a user after redirect
		BannerNotificationsController::addConfirmation(
			wfMessage( 'templatedraft-approval-success-confirmation' )->escaped(),
			BannerNotificationsController::CONFIRMATION_CONFIRM
		);
	}

	/**
	 * Show a friendly error message to a user after redirect
	 */
	private function addBannerNotificationMessage( $messageName ) {
		BannerNotificationsController::addConfirmation(
			wfMessage( $messageName )->escaped(),
			BannerNotificationsController::CONFIRMATION_ERROR
		);
	}

}
