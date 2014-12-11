<?php

/**
 * Share buttons
 *
 * Provides generic code for rendering share buttons from various social networks
 *
 * @see http://www.phpied.com/social-button-bffs/
 */

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'ShareButton',
	'author' => 'Wikia',
	'descriptionmsg' => 'share-buttons-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ShareButtons',
);

//i18n
$wgExtensionMessagesFiles['ShareButton'] = $dir . '/ShareButton.i18n.php';


// autoloaded classes
$wgAutoloadClasses['ShareButton'] =  "$dir/ShareButton.class.php";

// providers
$wgAutoloadClasses['ShareButtonFacebook'] =  "$dir/providers/ShareButtonFacebook.class.php";
$wgAutoloadClasses['ShareButtonGooglePlus'] =  "$dir/providers/ShareButtonGooglePlus.class.php";
$wgAutoloadClasses['ShareButtonTwitter'] =  "$dir/providers/ShareButtonTwitter.class.php";
$wgAutoloadClasses['ShareButtonMailController'] =  "$dir/modules/ShareButtonMailController.class.php";
$wgAutoloadClasses['ShareButtonMail'] =  "$dir/providers/ShareButtonMail.class.php";
