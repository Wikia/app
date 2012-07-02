<?php

class Notificator {

public static function notificator_Render( $parser, $receiver = '', $receiverLabel = '' ) {

	global $wgTitle;

	if ( !$receiverLabel ) {
		$receiverLabel = $receiver;
	}

	// Check that the database table is in place
	if ( !Notificator::checkDatabaseTableExists() ) {
		$output = '<span class="error">' .
			htmlspecialchars( wfMsg( 'notificator-db-table-does-not-exist' ) ) . '</span>';
		return array( $output, 'noparse' => true, 'isHTML' => true );
	}

	// The rendering is different, depending on whether a valid e-mail address
	// has been provided, or not - the differing part of the HTML form is being
	// built here
	if ( Notificator::receiverIsValid( $receiver ) ) {
		// Valid e-mail address available, so build a hidden input with that address
		// set, and a button
		$receiverInputAndSubmitButton = Html::hidden( 'receiver', $receiver ) .
		Html::element(
			'input',
			array( 'type' => 'submit',
				     'value' => wfMsg( 'notificator-notify-address-or-name', $receiverLabel )
				)
			);
	} else {
		// No (valid) e-mail address available, build a text input and a button
		$receiverInputAndSubmitButton = Html::element(
			'input',
			array( 'type' => 'text',
				     'name' => 'receiver',
				     'value' => wfMsg( 'notificator-e-mail-address' ),
				     'onfocus' => 'if (this.value == \'' .
					                wfMsg( 'notificator-e-mail-address' ) .
					                '\') {this.value=\'\'}'
				)
			) .
		Html::element(
			'input',
			array( 'type' => 'submit',
				     'value' => wfMsg( 'notificator-notify' )
				)
			);
	}

	// Now we assemble the form, consisting of two hidden inputs for page ID and rev ID,
	// as well as the $receiverInputAndSubmitButton built above
	$output = Html::rawElement(
			'form',
			array( 'action' => SpecialPage::getTitleFor( 'Notificator' )->getLocalURL(),
				     'method' => 'post',
				     'enctype' => 'multipart/form-data'
				),
			Html::hidden( 'pageId', $wgTitle->getArticleID() ) .
				Html::hidden( 'revId', $wgTitle->getLatestRevID() ) .
				$receiverInputAndSubmitButton
		);

	return $parser->insertStripItem( $output, $parser->mStripState );
}

private function checkDatabaseTableExists() {
	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->tableExists( 'notificator' );
	return $res;
}

public static function receiverIsValid( $receiver ) {
	// Returns true if the parameter is a valid e-mail address, false if not
	$receiverIsValid = true;

	// There may be multiple e-mail addresses, divided by commas - which is valid
	// for us, but not for the validation functions we use below. So get the single
	// address into an array first, validate them one by one, and only if all are ok,
	// return true.
	$receiverArray = explode( ',', str_replace ( ', ', ',', $receiver ) );

	// To make sure some joker doesn't copy in a large number of e-mail addresses
	// and spams them all, lets set a (admittedly arbitrary) limit of 10.
	if ( count( $receiverArray ) > 10 ) {
		return false;
	}

	if ( method_exists( 'Sanitizer', 'validateEmail' ) ) {
	// User::isValidEmailAddr() has been moved to Sanitizer::validateEmail as of
	// MediaWiki version 1.18 (I think).
		foreach ( $receiverArray as $singleEmailAddress ) {
			if ( !Sanitizer::validateEmail( $singleEmailAddress ) ) {
				$receiverIsValid = false;
			}
		}
	} else {
		foreach ( $receiverArray as $singleEmailAddress ) {
			if ( !User::isValidEmailAddr( $singleEmailAddress ) ) {
				$receiverIsValid = false;
			}
		}
	}
	return $receiverIsValid;
}

public static function getLastNotifiedRevId( $pageId, $revId, $receiver ) {
	// Returns -1 if any parameter is missing
	// Returns -2 if the database revId is the same as the given revId
	//            (= notified already)
	// Returns revId from the database - if there is no record, return 0

	if ( !$pageId || !$revId || !$receiver ) {
		return -1;
	}

	// Get $oldRevId from database
	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select(
		'notificator',                       // table
		'rev_id',                            // vars (columns of the table)
		array(                               // conds
			'page_id'        => (int)$pageId,
			'receiver_email' => $receiver
			)
		);

	$row = $dbr->fetchRow( $res );

	$oldRevId = $row['rev_id'];

	if ( !$oldRevId ) {
		$oldRevId = 0;
	} elseif ( $oldRevId == $revId ) {
		$oldRevId = -2;
	}

	return $oldRevId;
}

public static function getNotificationDiffHtml( $oldRevId, $revId ) {
	$oldRevisionObj = Revision::newFromId( $oldRevId );
	$newRevisionObj = Revision::newFromId( $revId );

	if ( $oldRevisionObj->getTitle() != $newRevisionObj->getTitle() ) {
		return '<span class="error">' .
			htmlspecialchars( wfMsg( 'notificator-revs-not-from-same-title' ) ) . '</span>';
	}

	$titleObj = $oldRevisionObj->getTitle();

	$differenceEngineObj = new DifferenceEngine( $titleObj, $oldRevId, $revId );

	$notificationDiffHtml = '<style media="screen" type="text/css">' .
		file_get_contents( dirname( __FILE__ ) . '/diff-in-mail.css' ) . '</style><table class="diff">
<col class="diff-marker" />
<col class="diff-content" />
<col class="diff-marker" />
<col class="diff-content" />
' . $differenceEngineObj->getDiffBody() . '
</table>';

	return $notificationDiffHtml;
}

public static function sendNotificationMail( $receiver, $mailSubject, $notificationText ) {
	global $ngFromAddress;
	$headers = 'From: ' . $ngFromAddress . "\r\n" .
             'X-Mailer: PHP/' . phpversion() . "\r\n" .
             'MIME-Version: 1.0' . "\r\n" .
             'Content-type: text/html; charset=utf-8' . "\r\n";
	$encodedMailSubject = mb_encode_mimeheader( $mailSubject, "UTF-8", "B", "\n" );

	return mail( $receiver, $encodedMailSubject, $notificationText, $headers );
}

public static function recordNotificationInDatabase( $pageId, $revId, $receiver ) {
	$lastNotifiedRevId = Notificator::getLastNotifiedRevId( $pageId, $revId, $receiver );
	if ( $lastNotifiedRevId > 0 ) {
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->update(
			'notificator',                       // table
			array(                               // vars (columns of the table)
				'rev_id' => (int)$revId
				),
			array(                               // conds
				'page_id'        => (int)$pageId,
				'receiver_email' => $receiver
				)
			);
		return $res;
	} elseif ( $lastNotifiedRevId == 0 ) {
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->insert(
			'notificator',                       // table
			array(                               // "$a"
				'page_id' => (int)$pageId,
				'rev_id' => (int)$revId,
				'receiver_email' => $receiver
				)
			);
		return $res;
	} elseif ( $lastNotifiedRevId < 0 ) {
		return false;
	}
}

public static function getReturnToText( $linkToPage, $pageTitle ) {
	$aElement = Html::element(
		'a',
		array( 'href' => $linkToPage ),
		$pageTitle
	);

	$returnToText = Html::rawElement(
		'p',
		array( 'style' => 'margin-top: 2em;' ),
		htmlspecialchars( wfMsg( 'notificator-return-to' ) ) . ' ' . $aElement
	);

	return $returnToText;
}

}
