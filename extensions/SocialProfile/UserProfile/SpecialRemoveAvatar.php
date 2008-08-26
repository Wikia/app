<?php
class RemoveAvatar extends SpecialPage {

	function RemoveAvatar(){
		SpecialPage::SpecialPage('RemoveAvatar', 'avatarremove');
		wfLoadExtensionMessages('SocialProfileUserProfile');
	}

	function execute( $user ){
		global $wgUser, $wgOut, $wgRequest, $wgUploadAvatarInRecentChanges;

		$this->title = Title::makeTitle( NS_SPECIAL, "RemoveAvatar");

		if ( $wgUser->isBlocked() ) {
		    $wgOut->blockedPage();
		    return;
		}

		if ( wfReadOnly() ) {
		    $wgOut->readOnlyPage();
		    return;
		}

		if ( !$wgUser->isLoggedIn() ) {
		    $this->displayRestrictionError();
		    return;
		}

		if ( !$wgUser->isAllowed( 'avatarremove' ) ) {
		    $this->displayRestrictionError();
		    return;
		}

		$wgOut->setPageTitle( wfMsg('avatarupload-removeavatar') );

		if( $wgRequest->getVal("user") != "" ){
			$wgOut->redirect( $this->title->getFullURL() . "/" . $wgRequest->getVal("user") );
		}

		if( $wgRequest->wasPosted() ) {
			//delete avatar
			$user_id = $wgRequest->getVal("user_id");
			$user_deleted = User::newFromId( $user_id );
			$user_deleted->loadFromDatabase();

			$this->deleteImage( $user_id, "s");
			$this->deleteImage( $user_id, "m");
			$this->deleteImage( $user_id, "l");
			$this->deleteImage( $user_id, "ml");

			$log = new LogPage( wfMsgForContent( 'user-profile-picture-log' ) );
			if( !$wgUploadAvatarInRecentChanges ){
				$log->updateRecentChanges = false;
			}
			$log->addEntry( wfMsg( 'user-profile-picture-log' ), $wgUser->getUserPage(), wfMsg( 'user-profile-picture-log-delete-entry', $user_deleted->getName() ) );

			$wgOut->addHTML( "<div>" . wfMsg("avatarupload-removesuccess") . "</div>" );
			$wgOut->addHTML( "<div><a href=\"" . $this->title->escapeFullURL() . "\">" . wfMsg('avatarupload-removeanother') . "</a></div>" );
		} else {
			if( $user ){
				$wgOut->addHTML( $this->showUserAvatar( $user ) );
			} else {
				$wgOut->addHTML( $this->showUserForm() );
			}
		}
	}

	function showUserForm(){
		$output = "";
		$output = "<form method=\"get\" name=\"avatar\">
				<b>" . wfMsg("username") . "</b>
				<input type=\"text\" name=\"user\">
				<input type=\"submit\" value=\"" . wfMsg('search') . "\">
			</form>";
		return $output;
	}

	function showUserAvatar( $user_name ){
		$user_id = User::idFromName($user_name);

		$avatar = new wAvatar($user_id, "l");

		$output = "";
		$output .= "<div><b>" . wfMsg('avatarupload-currentavatar', $user_name). "</b></div><p>";
		$output .= "<div>{$avatar->getAvatarURL()}</div><p><p>";
		$output .= "<div><form method=\"post\" name=\"avatar\">
				<input type=\"hidden\" name=\"user_id\" value=\"{$user_id}\">
				<input type=\"submit\" value=\"" . wfMsg('delete') . "\">
			</form></div>";
		return $output;
	}

	function deleteImage( $id, $size ){
		global $wgUploadDirectory, $wgDBname, $wgMemc;
		$avatar = new wAvatar( $id, $size);
		$files = glob($wgUploadDirectory . "/avatars/" . $wgDBname . "_" . $id .  "_" . $size . "*");
		$img  = basename($files[0]);
		if( $img ){
			unlink($wgUploadDirectory . "/avatars/" .  $img);
		}

		//clear cache
		$key = wfMemcKey( 'user', 'profile', 'avatar', $id, $size );
		$wgMemc->delete( $key );
	}
}
