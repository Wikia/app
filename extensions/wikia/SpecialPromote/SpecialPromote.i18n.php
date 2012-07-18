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

	'promote-introduction-copy' => "This page allows you to promote your wiki by making it eligible to appear on www.wikia.com! Add images and a summary to introduce your wiki to visitors on Wikia's main page. Find more tips here.",

	'promote-description' => 'Description',
	'promote-description-header' => 'Headline',
	'promote-description-header-explanation' => 'Something as simple as "Learn more about the Bacon Wiki" or "Welcome to the Bacon Wiki" is great!',

	'promote-description-about' => "What's your wiki about?",
	'promote-description-about-explanation' => "Write a summary about your wiki's topic.  Don't be afraid to make it detailed, you want to get visitors excited about the topic and make sure they have a clear idea of what your wiki is all about.",

	'promote-upload' => 'Add Images',
	'promote-upload-main-photo-header' => 'Main Image',
	'promote-upload-main-photo-explanation' => "This image defines your wiki.  It will be the main image we use to represent your wiki on wikia.com so make sure it's a great one! Don't forget, you can always update this image so it's current and most represents your wiki.",
	'promote-upload-additional-photos-header' => 'Additional Images',
	'promote-upload-additional-photos-explanation' => 'Adding more images makes your wiki look more interesting and engaging to potential visitors.You can add up to nine images here, and we strongly recommend you hit the limit!',

	'promote-publish' => 'Publish',

	'promote-upload-tool' => 'Admin Upload Tool',
	'promote-add-photo' => 'Add a photo',
	'promote-remove-photo' => 'Remove',
	'promote-modify-photo' => 'Modify',

	'promote-upload-main-image-form-modal-title' => 'Main Image',
	'promote-upload-main-image-form-modal-copy' => "Upload an image that represents your wiki's topic. Make sure it's a \".png\" file with a minimum size of 480x320.",
	'promote-upload-additional-image-form-modal-title' => 'More Images',
	'promote-upload-additional-image-form-modal-copy' => "Upload additional images to tell people more about your wiki's topic. Make sure your images are \".png\" files with a minimum size of 480x320.",
	'promote-upload-form-modal-cancel' => 'Cancel',

	'promote-upload-submit-button' => 'Submit',

	'promote-error-less-characters-than-minimum' => 'Oops! Your headline needs to be at least $2 characters.',
	'promote-error-more-characters-than-maximum' => 'Oops! Your headline needs to be $2 characters or less.',
	'promote-error-upload-unknown-error' => 'Unknown upload error',
	'promote-error-upload-filetype-error' => 'Make sure your file is saved as a ".png"',
	'promote-error-upload-dimensions-error' => '',
	'promote-error-too-many-images' => 'Oops! You already have nine images. Remove some if you want to add more.',
	'promote-error-upload-type' => "Oops! Wrong upload type.",
	'promote-error-upload-form' => "Wrong upload type in getUploadForm.",

	'promote-manual-file-size-error' => 'Main image has a minimum size of 480x320px.',
	'promote-manual-upload-error' => 'This file cannot be uploaded manually. Please use Admin Upload Tool.',
	'promote-wrong-rights' => "Darn, looks like you don't have permission to access this page. Make sure you're logged in!",

	 'promote-image-rejected' => 'Rejected',
	'promote-image-accepted' => 'Accepted',
	'promote-image-in-review' => 'In review',

	'promote-statusbar-icon' => 'Status',
	'promote-statusbar-inreview' => 'One or more of your images are currently in review. Your wiki will appear on [http://www.wikia.com www.wikia.com] when images have been approved.',
	'promote-statusbar-approved' => 'Woohoo! $1 is promoted on [http://www.wikia.com www.wikia.com]!',
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

