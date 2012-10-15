<?php
/**
 * Provides a way of importing properly licensed photos from flickr
 *
 * @file
 * @ingroup Extensions
 * @version 2.0
 * @author Bryan Tong Minh <bryan.tongminh@gmail.com>
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:ImportFreeImages Documentation
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}

// Configuration settings
$wgIFI_FlickrAPIKey = ''; // the flickr API key. This is required for the extension to work.
$wgIFI_CreditsTemplate = 'flickr'; // use this to format the image content with some key parameters
$wgIFI_GetOriginal = true; // import the original version of the photo
$wgIFI_PromptForFilename = true; // prompt the user through JavaScript for the destination filename
$wgIFI_phpFlickr = 'phpFlickr-2.2.0/phpFlickr.php'; // Path to your phpFlickr file

$wgIFI_ResultsPerPage = 20;
$wgIFI_ResultsPerRow = 4;
// see the flickr API page for more information on these params
// for license info http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
// default 4 is CC Attribution License
$wgIFI_FlickrLicense = '4,5';
$wgIFI_FlickrSort = 'interestingness-desc';
$wgIFI_FlickrSearchBy = 'tags'; // Can be tags or text. See http://www.flickr.com/services/api/flickr.photos.search.html
$wgIFI_AppendRandomNumber = true; // append random # to destination filename
$wgIFI_ThumbType = 't'; // s for square, t for thumbnail

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ImportFreeImages',
	'author' => array( 'Travis Derouin', 'Bryan Tong Minh' ),
	'version' => '2.0',
	'descriptionmsg' => 'importfreeimages-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ImportFreeImages',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ImportFreeImages'] = $dir . 'ImportFreeImages.body.php';
$wgAutoloadClasses['SpecialImportFreeImages'] = $dir . 'SpecialImportFreeImages.php';
$wgAutoloadClasses['UploadFreeImage'] = $dir . 'UploadFreeImage.php';
$wgExtensionMessagesFiles['ImportFreeImages'] = $dir . 'ImportFreeImages.i18n.php';
$wgExtensionMessagesFiles['ImportFreeImagesAlias'] = $dir . 'ImportFreeImages.alias.php';

$wgSpecialPages['ImportFreeImages'] = 'SpecialImportFreeImages';
// Special page group for MW 1.13+
$wgSpecialPageGroups['ImportFreeImages'] = 'media';

// Upload hooks
$wgHooks['UploadCreateFromRequest'][] = 'UploadFreeImage::onUploadCreateFromRequest';
$wgHooks['UploadFormSourceDescriptors'][] = 'UploadFreeImage::onUploadFormSourceDescriptors';
$wgHooks['UploadFormInitDescriptor'][] = 'UploadFreeImage::onUploadFormInitDescriptor';
