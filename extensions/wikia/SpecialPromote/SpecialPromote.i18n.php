<?php

/**
 * Internationalisation file for the SpecialPromote extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	'promote' => 'Promote',

	'promote-title' => 'Promote',
	'promote-introduction-header' => 'Promote your wiki on wikia.com',

	'promote-introduction-copy' => 'Using this tool allows you to promote your wiki by making it eligible to appear on wikia.com!
	 	Choose an images that identify your wiki and write an introduction to tell people more about your wikis topic.',

	'promote-description' => 'Describe your wiki',
	'promote-description-header' => 'Headline',
	'promote-description-header-explanation' => 'Something as simple as "Learn more about the Bacon Wiki" or "Welcome to the Bacon Wiki" is great!',

	'promote-description-about' => 'Description',
	'promote-description-about-explanation' => 'This is your chance to tell people more about your wiki. Include information about the subject of the wiki, a summary of your wiki\'s topic and let people know that anyone can contribute.',

	'promote-upload' => 'Add Images',
	'promote-upload-main-photo-header' => 'Main Image',
	'promote-upload-main-photo-explanation' => 'This is the main image that will represent your wiki on wikia.com. Choose an image that will show people what the wiki is about. You can always change it to keep it current.',
	'promote-upload-additional-photos-header' => 'More Images',
	'promote-upload-additional-photos-explanation' => ' Add a few more images that show people more about your wiki\'s topic. You can add up to nine. Adding more images makes your wiki look more interesting and engaging to potential visitors.',

	'promote-publish' => 'Publish',

	'promote-upload-tool' => 'Admin Upload Tool',
	'promote-add-photo' => 'Add a photo',
	'promote-remove-photo' => 'Remove',
	'promote-modify-photo' => 'Modify',

	'promote-upload-main-image-form-modal-title' => 'Main Image',
	'promote-upload-main-image-form-modal-copy' => 'Upload an image to represent your wiki. Your image should be a ".png" file with a minimum size of 480x320.',
	'promote-upload-additional-image-form-modal-title' => 'More Images',
	'promote-upload-additional-image-form-modal-copy' => 'Upload additional images that represent your wiki',
	'promote-upload-form-modal-cancel' => 'Cancel',

	'promote-upload-submit-button' => 'Submit',

	'promote-error-less-characters-than-minimum' => 'You entered $1 characters, but $2 is the minimum',
	'promote-error-more-characters-than-maximum' => 'You entered $1 characters, but $2 is the maximum',
	'promote-error-upload-unknown-error' => 'Unknown upload error',
	'promote-error-upload-filetype-error' => 'Wrong file type (should be PNG)',
	'promote-error-upload-dimensions-error' => 'Wrong file dimensions - file should be at least 480x320px',
	'promote-error-too-many-images' => 'Oops! You already have nine images. Remove some if you want to add more.',
	'promote-error-upload-type' => "Wrong upload type.",
	'promote-error-upload-form' => "Wrong upload type in getUploadForm.",

	'promote-manual-file-size-error' => 'Main image has a minimum size of 480x320px.',
	'promote-manual-upload-error' => 'This file cannot be uploaded manually. Please use Admin Upload Tool.',
	'promote-wrong-rights' => "You are probably logged-out or you don't have permissions to use this special page.",

	'promote-image-rejected' => 'Rejected',
	'promote-image-accepted' => 'Accepted',
	'promote-image-in-review' => 'In review',

	'promote-statusbar-icon' => 'Status',
	'promote-statusbar-inreview' => 'One or more of your images are currently in review. Your wiki will appear on www.wikia.com when the images have been approved.',
	'promote-statusbar-approved' => 'Your wiki is currently being promoted on www.wikia.com!',
	'promote-statusbar-rejected' => 'One or more of your images was not approved. Find out why.',

);

$messages['qqq'] = array(
	'promote' => 'Promote page heading',

	'promote-title' => 'Promote page title',
	'promote-introduction-header' => 'Promote page header inviting admin to promote his/her wiki',
	'promote-introduction-copy' => 'Promote page explanatory copy and invitation to fill in wiki data',

	'promote-description' => 'Title inviting to describe the wiki',
	'promote-description-header' => 'Label for wiki headline input field',
	'promote-description-header-explanation' => 'Explanatory text for headline input field',

	'promote-description-about' => 'Label for wiki description text input field',
	'promote-description-about-explanation' => 'Explanatory text for wiki description input field',

	'promote-upload' => 'Title inviting to add images',
	'promote-upload-main-photo-header' => 'Label for main wiki image',
	'promote-upload-main-photo-explanation' => 'Explanatory text for main wiki image',
	'promote-upload-additional-photos-header' => 'Label for additional images section',
	'promote-upload-additional-photos-explanation' => 'Explanatory text for additional optional images section',
	'promote-upload-form-modal-cancel' => 'Cancel (close) image upload modal',

	'promote-publish' => 'Label for publish button',

	'promote-upload-tool' => 'Admin Upload Tool name',
	'promote-add-photo' => 'Label for add a photo button',
	'promote-remove-photo' => 'Label for image removal',
	'promote-modify-photo' => 'Label for image modification',

	'promote-upload-main-image-form-modal-title' => 'Headline for Main Image upload modal',
	'promote-upload-main-image-form-modal-copy' => 'Explanatory text for Main Image upload',
	'promote-upload-additional-image-form-modal-title' => 'Headline for Additional Images upload modal',
	'promote-upload-additional-image-form-modal-copy' => 'Explanatory text for Additional Images upload',

	'promote-upload-submit-button' => 'Submit button text',

	'promote-error-less-characters-than-minimum' => 'Information about lower than minimal ($2) number of entered characters ($1)',
	'promote-error-more-characters-than-maximum' => 'Information about higher than maximal ($2) number of entered characters ($1)',
	'promote-error-upload-unknown-error' => 'Information about unknown upload error',
	'promote-error-upload-filetype-error' => 'Information about wrong file type',
	'promote-error-upload-dimensions-error' => 'Information about wrong file dimensions error',
	'promote-error-too-many-images' => 'Information about exceeding maxim number of additional images',
	'promote-error-upload-type' => 'Information about wrong file upload type passed to form (internal error)',
	'promote-error-upload-form' => 'Information about wrong file upload type passed in upload request (internal error)',

	'promote-manual-file-size-error' => 'Information about minimum main image size',
	'promote-manual-upload-error' => 'Information about the restriction to upload visualization images by means other than Admin Upload Tool',
	'promote-wrong-rights' => 'Information about lost session / lack of permissions to this extension',

	'promote-image-rejected' => 'Information about image rejection',
	'promote-image-accepted' => 'Information about image approval',
	'promote-image-in-review' => 'Information about image being in review',

	'promote-statusbar-icon' => 'Text on the status icon at the top of the special:promote page',
	'promote-statusbar-inreview' => 'Status information when wiki is in review',
	'promote-statusbar-approved' => 'Status information when wiki is in approved',
	'promote-statusbar-rejected' => 'Status information when wiki is in rejected',

);

