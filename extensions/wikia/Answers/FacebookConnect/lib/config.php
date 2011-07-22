<?php
/*
 * To install:
 *   1. Copy this file to config.php
 *   2. Follow the instructions below to make the app work.
 */

/*
 * Enter your callback URL here. That's the location where index.php
 * resides. Make sure it's your exact root - facebook.com
 * and www.facebook.com are different.
 */
$callback_url     = 'http://answers.wikia.com';

/*
 * Get the API key and secret from http://facebook.com/developers
 * Note that each callback URL needs its own app id.
 *
 * Set the callback URL in your developer app to match the one you chose above.
 * This is important so that the Javascript cross-domain library works correctly.
 *
 */
$api_key         = 'e11b25c5d360fd91226da57ee027362f';
$api_secret      = '092d5e16ee3c32446d6b790912447376';



/*
 * The Run Around has a single feed story, which is displayed when you add a run.
 * The feed story template needs to be registered with your app_key, and then just passed
 * at run time. To register the feed bundle for your app, visit:
 *
 * www.yourapp.com/register_feed_forms.php
 *
 * Then copy/paste the resulting feed bundle ID here.
 */
$wgFacebookAnswersTemplateID  = 60990631653;
