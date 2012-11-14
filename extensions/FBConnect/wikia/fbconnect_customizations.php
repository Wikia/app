<?php
/**
 * @author Sean Colombo
 *
 * This file contains wikia-specific customizations to the FBConnect extension that are
 * not core to the extension itself.
 *
 * Among other things, this includes the form for finishing registration after an anonymous
 * user connects through facebook.
 *
 * This script depends on /extensions/wikia/AjaxFunctions.php for wfValidateUsername().
 *
 * NOTE: This script doesn't take into account $fbConnectOnly since it works off of the assumption
 * that Wikia has its own accounts and currently has no reason to expect that it won't in the
 * forseeable future.
 */

/**
 * Extra initialization for Facebook Connect which is Wikia-specific.
 */
function wikia_fbconnect_init(){
} // end wikia_fbconnect_init()

/**
 * Called when a user was just created or attached (safe to call at any time later as well).  This
 * function will check to see if the user has a Wikia Avatar and if they don't, it will attempt to
 * use this Facebook-connected user's profile picture as their Wikia Avatar.
 *
 * FIXME: Is there a way to make this fail gracefully if we ever un-include the Masthead extension?
 */
function wikia_fbconnect_considerProfilePic( &$specialConnect ){
	wfProfileIn(__METHOD__);
	global $wgUser;

	// We need the facebook id to have any chance of getting a profile pic.
	$fb_ids = FBConnectDB::getFacebookIDs($wgUser);
	if(count($fb_ids) > 0){
		$fb_id = array_shift($fb_ids);
		if ( class_exists( 'Masthead' ) ){
			// If the useralready has a masthead avatar, don't overwrite it, this function shouldn't alter anything in that case.
			$masthead = Masthead::newFromUser($wgUser);
			if( !$masthead->hasAvatar() ) {
				global $wgEnableUserProfilePagesV3;

				if( !empty($wgEnableUserProfilePagesV3) ) {
				//bugId:10580
					// Attempt to store the facebook profile pic as the Wikia avatar.
					$picUrl = FBConnectProfilePic::getImgUrlById($fb_id, FB_PIC_BIG);
				} else {
					// Attempt to store the facebook profile pic as the Wikia avatar.
					$picUrl = FBConnectProfilePic::getImgUrlById($fb_id, FB_PIC_SQUARE);
				}

				if( $picUrl != "" ) {
					if( !empty($wgEnableUserProfilePagesV3) ) {
					//bugId:10580
						$tmpFile = '';
						$sUrl = $masthead->uploadByUrlToTempFile($picUrl, $tmpFile);

						$app = F::app();
						$userProfilePageV3 = new UserProfilePageController($app);
						$data->source = 'facebook';
						$data->file = $tmpFile;
						$userProfilePageV3->saveUsersAvatar($wgUser->getId(), $data);
					} else {
						$errorNo = $masthead->uploadByUrl($picUrl);

						// Apply this as the user's new avatar if the image-pull went okay.
						if($errorNo == UPLOAD_ERR_OK){
							$sUrl = $masthead->getLocalPath();
							if ( !empty($sUrl) ) {
								/* set user option */
								$wgUser->setOption( AVATAR_USER_OPTION_NAME, $sUrl );
								$wgUser->saveSettings();
							}
						}
					}
				}
			}
		}
	}

	wfProfileOut(__METHOD__);
	return true;
} // end wikia_fbconnect_considerProfilePic()
