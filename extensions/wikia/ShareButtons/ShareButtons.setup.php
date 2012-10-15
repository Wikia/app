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
$app->registerClass('ShareButton', "$dir/ShareButton.class.php");

// providers
$app->registerClass('ShareButtonFacebook', "$dir/providers/ShareButtonFacebook.class.php");
$app->registerClass('ShareButtonGooglePlus', "$dir/providers/ShareButtonGooglePlus.class.php");
$app->registerClass('ShareButtonTwitter', "$dir/providers/ShareButtonTwitter.class.php");
$app->registerClass('ShareButtonMailController', "$dir/modules/ShareButtonMailController.class.php");
$app->registerClass('ShareButtonMail', "$dir/providers/ShareButtonMail.class.php");
