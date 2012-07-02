<?php
/**
 * AJAX functions used by FanBoxes extension.
 */

$wgAjaxExportList[] = 'wfFanBoxShowaddRemoveMessage';
function wfFanBoxShowaddRemoveMessage( $addremove, $title, $individual_fantag_id ) {
	global $wgUser;
	$out = '';

	$fanbox = FanBox::newFromName( $title );

	if( $addremove == 1 ) {
		$fanbox->changeCount( $individual_fantag_id, +1 );
		$fanbox->addUserFan( $individual_fantag_id );

		if( $wgUser->isLoggedIn() ) {
			$check = $fanbox->checkIfUserHasFanBox();
			if( $check == 0 ) {
				$out .= $fanbox->outputIfUserDoesntHaveFanBox();
			} else {
				$out .= $fanbox->outputIfUserHasFanBox();
			}
		} else {
			$out .= $fanbox->outputIfUserNotLoggedIn();
		}

		$out.= '<div class="show-individual-addremove-message">' .
			wfMsg( 'fanbox-successful-add' ) .
		'</div>';
	}

	if( $addremove == 2 ) {
		$fanbox->changeCount( $individual_fantag_id, -1 );
		$fanbox->removeUserFanBox( $individual_fantag_id );

		if( $wgUser->isLoggedIn() ) {
			$check = $fanbox->checkIfUserHasFanBox();
			if( $check == 0 ) {
				$out .= $fanbox->outputIfUserDoesntHaveFanBox();
			} else {
				$out .= $fanbox->outputIfUserHasFanBox();
			}
		} else {
			$out .= $fanbox->outputIfUserNotLoggedIn();
		}

		$out.= '<div class="show-individual-addremove-message">' .
			wfMsg( 'fanbox-successful-remove' ) .
		'</div>';
	}

	return $out;
}

$wgAjaxExportList[] = 'wfMessageAddRemoveUserPage';
function wfMessageAddRemoveUserPage( $addRemove, $id, $style ) {
	global $wgUser;
	$out = '';

	if( $addRemove == 1 ) {
		$number = +1;

		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'user_fantag',
			array(
				'userft_fantag_id' => $id,
				'userft_user_id' => $wgUser->getID(),
				'userft_user_name' => $wgUser->getName(),
				'userft_date' => date( 'Y-m-d H:i:s' ),
			),
			__METHOD__
		);
		$dbw->commit();

		$out .= "<div class=\"$style\">" . wfMsg( 'fanbox-successful-add' ) .
			'</div>';
	}

	if( $addRemove == 2 ) {
		$number = -1;

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'user_fantag',
			array(
				'userft_user_id' => $wgUser->getID(),
				'userft_fantag_id' => $id
			),
			__METHOD__
		);
		$dbw->commit();

		$out.= "<div class=\"$style\">" . wfMsg( 'fanbox-successful-remove' ) .
			'</div>';
	}

	$dbw->update(
		'fantag',
		/* SET */array( "fantag_count=fantag_count+{$number}" ),
		/* WHERE */array( 'fantag_id' => $id ),
		__METHOD__
	);

	$dbw->commit();

	return $out;
}

$wgAjaxExportList[] = 'wfFanBoxesTitleExists';
function wfFanBoxesTitleExists( $page_name ) {
	// Construct page title object to convert to Database Key
	$pageTitle = Title::makeTitle( NS_MAIN, urldecode( $page_name ) );
	$dbKey = $pageTitle->getDBkey();

	// Database key would be in page title if the page already exists
	$dbw = wfGetDB( DB_MASTER );
	$s = $dbw->selectRow(
		'page',
		array( 'page_id' ),
		array( 'page_title' => $dbKey, 'page_namespace' => NS_FANTAG ),
		__METHOD__
	);

	if ( $s !== false ) {
		return 'Page exists';
	} else {
		return 'OK';
	}
}