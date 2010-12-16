<?php

class RemoveAvatar extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'RemoveAvatar'/*class*/, 'avatarremove'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $user Mixed: parameter passed to the page or null
	 */
	public function execute( $user ) {
		global $wgUser, $wgOut, $wgRequest, $wgUploadAvatarInRecentChanges;
		wfLoadExtensionMessages( 'SocialProfileUserProfile' );

		$this->title = SpecialPage::getTitleFor( 'RemoveAvatar' );

		# If the user isn't logged in, display an error
		if ( !$wgUser->isLoggedIn() ) {
			$this->displayRestrictionError();
			return;
		}

		# If the user doesn't have 'avatarremove' permission, display an error
		if ( !$wgUser->isAllowed( 'avatarremove' ) ) {
			$this->displayRestrictionError();
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$wgOut->setPageTitle( wfMsg( 'avatarupload-removeavatar' ) );

		if ( $wgRequest->getVal( 'user' ) != '' ) {
			$wgOut->redirect( $this->title->getFullURL() . '/' . $wgRequest->getVal( 'user' ) );
		}

		// If the request was POSTed, then delete the avatar
		if ( $wgRequest->wasPosted() ) {
			$user_id = $wgRequest->getVal( 'user_id' );
			$user_deleted = User::newFromId( $user_id );
			$user_deleted->loadFromDatabase();

			$this->deleteImage( $user_id, 's' );
			$this->deleteImage( $user_id, 'm' );
			$this->deleteImage( $user_id, 'l' );
			$this->deleteImage( $user_id, 'ml' );

			$log = new LogPage( wfMsgForContent( 'user-profile-picture-log' ) );
			if ( !$wgUploadAvatarInRecentChanges ) {
				$log->updateRecentChanges = false;
			}
			$log->addEntry(
				wfMsg( 'user-profile-picture-log' ),
				$wgUser->getUserPage(),
				wfMsg( 'user-profile-picture-log-delete-entry', $user_deleted->getName() )
			);
			$wgOut->addHTML( '<div>' . wfMsg( 'avatarupload-removesuccess' ) . '</div>' );
			$wgOut->addHTML( '<div><a href="' . $this->title->escapeFullURL() . '">' . wfMsg( 'avatarupload-removeanother' ) . '</a></div>' );
		} else {
			if ( $user ) {
				$wgOut->addHTML( $this->showUserAvatar( $user ) );
			} else {
				$wgOut->addHTML( $this->showUserForm() );
			}
		}
	}

	/**
	 * Show the form for retrieving a user's current avatar
	 */
	function showUserForm() {
		$output = '<form method="get" name="avatar" action="">'
				. Xml::hidden( 'title', $this->getTitle() ) .
				'<b>' . wfMsg( 'username' ) . '</b>
				<input type="text" name="user" />
				<input type="submit" value="' . wfMsg( 'search' ) . '" />
			</form>';
		return $output;
	}

	/**
	 * Shows the requested user's current avatar and the button for deleting it
	 */
	function showUserAvatar( $user_name ) {
		$user_name = str_replace( '_', ' ', $user_name ); // replace underscores with spaces
		$user_id = User::idFromName( $user_name );

		$avatar = new wAvatar( $user_id, 'l' );

		$output = '<div><b>' . wfMsg( 'avatarupload-currentavatar', $user_name ) . '</b></div>';
		$output .= "<div>{$avatar->getAvatarURL()}</div>";
		$output .= '<div><form method="post" name="avatar" action="">
				<input type="hidden" name="user_id" value="' . $user_id . '" />
				<br />
				<input type="submit" value="' . wfMsg( 'delete' ) . '" />
			</form></div>';
		return $output;
	}

	/**
	 * Deletes all of the requested user's avatar images from the filesystem
	 *
	 * @param $id Int: user ID
	 * @param $size Int: size of the avatar image to delete (small, medium or large).
	 * 			Doesn't really matter since we're just going to blast 'em all.
	 */
	function deleteImage( $id, $size ) {
		global $wgUploadDirectory, $wgDBname, $wgMemc;
		$avatar = new wAvatar( $id, $size );
		$files = glob( $wgUploadDirectory . '/avatars/' . $wgDBname . '_' . $id .  '_' . $size . "*" );
		$img = basename( $files[0] );
		if ( $img && $img[0] ) {
			unlink( $wgUploadDirectory . '/avatars/' . $img );
		}

		// clear cache
		$key = wfMemcKey( 'user', 'profile', 'avatar', $id, $size );
		$wgMemc->delete( $key );
	}
}
