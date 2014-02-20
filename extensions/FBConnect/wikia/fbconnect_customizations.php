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
 * This function is depended on Masthead and UserProfilePageController classes
 */
function wikia_fbconnect_considerProfilePic( &$specialConnect ){
	wfProfileIn( __METHOD__ );
	global $wgUser;

	// We need the facebook id to have any chance of getting a profile pic.
	$fb_ids = FBConnectDB::getFacebookIDs( $wgUser );

	if( count( $fb_ids ) > 0 ) {
		$fb_id = array_shift( $fb_ids );

		// If the user already has a masthead avatar, don't overwrite it,
		// this function shouldn't alter anything in that case.
		$masthead = Masthead::newFromUser( $wgUser );

		if( !$masthead->hasAvatar() ) {
			// Attempt to store the facebook profile pic as the Wikia avatar.
			$picUrl = FBConnectProfilePic::getImgUrlById( $fb_id, FB_PIC_BIG );

			if( $picUrl != '' ) {
				$app = F::app();

				// UPPv3 has been enabled in 2012 sitewide
				// https://github.com/Wikia/config/blob/dev/CommonExtensions.php#L1714
				$userProfilePageV3 = new UserProfilePageController( $app );

				$data = new stdClass();
				$data->source = 'facebook';
				$data->file = $picUrl;

				$userProfilePageV3->saveUsersAvatar( $wgUser->getId(), $data );
			}
		}
	}

	wfProfileOut( __METHOD__ );
	return true;
} // end wikia_fbconnect_considerProfilePic()
