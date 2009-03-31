<?php
/**
 *  Provides a way of importing properly licensed photos from flickr
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:ImportFreeImages Documentation
 */
if ( ! defined( 'MEDIAWIKI' ) )
	die();

# Configuration settings
$wgIFI_FlickrAPIKey = ''; // the flickr API key. This is required for the extension to work.
$wgIFI_CreditsTemplate = 'flickr'; // use this to format the image content with some key parameters
$wgIFI_GetOriginal = true; // import the original version of the photo
$wgIFI_PromptForFilename = true;  // prompt the user through javascript for the destination filename

$wgIFI_ResultsPerPage = 20;
$wgIFI_ResultsPerRow = 4;
// see the flickr api page for more information on these params
// for license info http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
// default 4 is CC Attribution License
$wgIFI_FlickrLicense = '4,5';
$wgIFI_FlickrSort = 'interestingness-desc';
$wgIFI_FlickrSearchBy = 'tags'; // Can be tags or text. See http://www.flickr.com/services/api/flickr.photos.search.html
$wgIFI_AppendRandomNumber = true; // append random # to destination filename
$wgIFI_ThumbType = 't'; // s for square t for thumbnail

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'ImportFreeImages',
	'author' => 'Travis Derouin',
	'version' => '1.0',
	'description' => 'Provides a way of importing properly licensed photos from flickr.',
	'descriptionmsg' => 'importfreeimages-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ImportFreeImages',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ImportFreeImages'] = $dir . 'ImportFreeImages.body.php';
$wgExtensionMessagesFiles['ImportFreeImages'] = $dir . 'ImportFreeImages.i18n.php';
$wgExtensionAliasesFiles['ImportFreeImages'] = $dir . 'ImportFreeImages.alias.php';
$wgSpecialPages['ImportFreeImages'] = 'ImportFreeImages';
// Special page group for MW 1.13+
$wgSpecialPageGroups['ImportFreeImages'] = 'media';