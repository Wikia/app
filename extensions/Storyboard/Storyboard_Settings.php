<?php
/**
 * File defining the settings for the Storyboard extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Storyboard
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of Storyboard.
 *
 * @file Storyboard_Settings.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * The maximum length of a story (in characters) that can be submitted via the storysubmission tag.
 * Can be overriden by the maxlength parameter in the storysubmission tag.
 * @var integer
 */
$egStoryboardMaxStoryLen = 1000;
/**
 * The minimum length of a story (in characters) that can be submitted via the storysubmission tag.
 * Can be overriden by the minlength parameter in the storysubmission tag.
 * @var integer
 */
$egStoryboardMinStoryLen = 10;

/**
 * The default width of storyboards, either in pixels, or as percentage.
 * @var mixed
 */
$egStoryboardWidth = '80%';
/**
 * The default height of storyboards, either in pixels, or as percentage.
 * @var mixed
 */
$egStoryboardHeight = 400;

/**
 * The default width of storysubmission forms, either in pixels, or as percentage.
 * @var mixed
 */
$egStorysubmissionWidth = '740px';

/**
 * The address that should be displayed as sender in submission confirmation emails.
 * @var string
 */
$egStoryboardEmailSender = 'noreply@wikimediafoundation.org';

/**
 * The name that should be displayed as sender in submission confirmation emails.
 * @var string
 */
$egStoryboardEmailSenderName = 'Wikimedia Foundation';

/**
 * The url to the storyboard.
 * @var string
 */
$egStoryboardBoardUrl = 'http://wikimediafoundation.org/wiki/Home';