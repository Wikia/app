<?php

class SpecialNotificator extends SpecialPage {

function __construct() {
	parent::__construct( 'Notificator' );
}

function execute( $par ) {
	global $wgRequest, $wgOut, $wgUser;

	$this->setHeaders();

	# Get request data from, e.g.
	$pageId = $wgRequest->getText( 'pageId' );
	$revId = $wgRequest->getText( 'revId' );
	$receiver = $wgRequest->getText( 'receiver' );

	if ( !$pageId || !$revId || !$receiver ) {
		$output = '<span class="error">' . htmlspecialchars(
			wfMsg( 'notificator-special-page-accessed-directly' ) ) . '</span>';
	} else {
		$titleObj = Title::newFromID( $pageId );
		$pageTitle = $titleObj->getFullText();
		$linkToPage = $titleObj->getFullURL();

		if ( !Notificator::receiverIsValid( $receiver ) ) {
			$output = '<span class="error">' . htmlspecialchars(
				wfMsg( 'notificator-e-mail-address-invalid' ) . ' ' .
				wfMsg( 'notificator-notification-not-sent' ) ) . '</span>';
			$output .= Notificator::getReturnToText( $linkToPage, $pageTitle );
			$wgOut->addHTML( $output );
			return;
		}

		$oldRevId = Notificator::getLastNotifiedRevId( $pageId, $revId, $receiver );

		if ( $oldRevId >= 0 ) {
			if ( $oldRevId > 0 ) {
				// Receiver has been notified before - send the diff to the last notified revision
				$mailSubjectPrefix = '[' . htmlspecialchars( wfMsg( 'notificator-change-tag' ) ) . '] ';

				$wgOut->addModules( 'mediawiki.action.history.diff' );
				$diff = Notificator::getNotificationDiffHtml( $oldRevId, $revId );
				$notificationText = wfMsg( 'notificator-notification-text-changes',
					htmlspecialchars( $wgUser->getName() ),
					Html::element(
						'a',
						array( 'href' => $linkToPage ),
						$pageTitle
						)
					) .
					Html::rawElement(
						'div',
						array( 'style' => 'margin-top: 1em' ),
						$diff
						);
			} else {
				// Receiver has never been notified about this page - so don't send a diff, just the link
				$mailSubjectPrefix = '[' . htmlspecialchars( wfMsg( 'notificator-new-tag' ) ) . '] ';
				$notificationText = wfMsg( 'notificator-notification-text-new',
					htmlspecialchars( $wgUser->getName() ),
					Html::element(
						'a',
						array( 'href' => $linkToPage ),
						$pageTitle
						)
					);
			}
			$mailSubject = htmlspecialchars( $mailSubjectPrefix . $pageTitle );

			if ( Notificator::sendNotificationMail( $receiver, $mailSubject, $notificationText ) ) {
				$output = '<strong>' . htmlspecialchars( wfMsg( 'notificator-following-e-mail-sent-to',
					$receiver ) ) . '</strong><div style="margin-top: 1em;"><h3>' .
					wfMsg( 'notificator-subject' ) . ' ' . $mailSubject . '</h3><p>' . $notificationText .
					'</p></div>';
				Notificator::recordNotificationInDatabase( $pageId, $revId, $receiver );
			} else {
				$output = '<span class="error">' . htmlspecialchars(
					wfMsg( 'notificator-error-sending-e-mail', $receiver ) ) . '</span>';
			}
		} elseif ( $oldRevId == -1 ) {
			$output = '<span class="error">' . htmlspecialchars(
				wfMsg( 'notificator-error-parameter-missing' ) ) . '</span>';
		} elseif ( $oldRevId == -2 ) {
			$output = '<strong>' . htmlspecialchars ( wfMsg( 'notificator-notified-already',
				$receiver ) . ' ' . wfMsg( 'notificator-notification-not-sent' ) ) . '</strong>';
		}

		$output .= Notificator::getReturnToText( $linkToPage, $pageTitle );
	}

	$wgOut->addHTML( $output );
}

}
