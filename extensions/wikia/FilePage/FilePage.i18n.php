<?php
/**
 * @addtogroup Extensions
*/

$messages = array();
$messages['en'] = array(
	/* video page */
	'video-page-file-list-header' => 'Appears on these pages',
	'video-page-global-file-list-header' => 'Appears on these wikis',
	'video-page-from-provider' => 'From $1',
	'video-page-expires' => 'Content expires on $1',
	'video-page-views' => '$1 Views',
	'video-page-see-more-info' => 'Show more info',
	'video-page-see-less-info' => 'Show less info',
	'video-page-description-heading' => 'Description',
	'video-page-description-zero-state' => 'There is no description for this file yet.', // file or video? --TOR
	'video-page-file-list-pagination' => '$1 of $2', // why are we using custom pagination instead of one of the existing compoments? --TOR

	/* file page */
	'file-page-replace-button' => 'Replace',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	/* video page */
	'video-page-file-list-header' => 'Heading for file list on Video File Page',
	'video-page-global-file-list-header' => 'Heading for global usage list on Video File Page',
	'video-page-from-provider' => '$1 is the provider name. The provider is where we got the video content from.  Some current examples are IGN and Ooyala.',
	'video-page-expires' => '$1 is a date. After the date specified, the video content will no longer be available to view.',
	'video-page-see-more-info' => 'Label to uncollapse UI that shows more info',
	'video-page-see-less-info' => 'Label to collapse UI that shows more info',
	'video-page-description-heading' => 'Description heading',
	'video-page-description-zero-state' => 'Placeholder file page content that states there is no description for this file',
	'video-page-file-list-pagination' => 'Pagination for file listing.  e.g. 1 of 2.  $1 is current page, $2 is total pages',

	/* file page */
	'file-page-replace-button' => 'Label for a button (part of the "edit" button dropdown menu). This is a verb, like "edit" in that context.', 
);
