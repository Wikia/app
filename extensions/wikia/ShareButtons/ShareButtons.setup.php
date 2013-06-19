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

// autoloaded classes
$wgAutoloadClasses['ShareButton'] =  "$dir/ShareButton.class.php";

// providers
$wgAutoloadClasses['ShareButtonFacebook'] =  "$dir/providers/ShareButtonFacebook.class.php";
$wgAutoloadClasses['ShareButtonGooglePlus'] =  "$dir/providers/ShareButtonGooglePlus.class.php";
$wgAutoloadClasses['ShareButtonTwitter'] =  "$dir/providers/ShareButtonTwitter.class.php";
$wgAutoloadClasses['ShareButtonMailController'] =  "$dir/modules/ShareButtonMailController.class.php";
$wgAutoloadClasses['ShareButtonMail'] =  "$dir/providers/ShareButtonMail.class.php";
