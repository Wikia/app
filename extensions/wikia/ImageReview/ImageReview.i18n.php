<?php

$messages = [];

$messages['en'] = [
	'imagereview-desc' => 'Internal tool to help review images post-upload and remove Terms of Use violations',
	'imagereview-reason' => "Violation of Wikia's [[wikia:Terms of Use|Terms of Use]]",
	'imagereview-header' => 'Images awaiting review',
	'imagereview-header-questionable' => 'Questionable images awaiting staff review',
	'imagereview-header-rejected' => 'Rejected images awaiting staff review',
	'imagereview-header-invalid' => 'Invalid images awaiting staff review',
	'imagereview-noresults' => 'No images found.',

	'imagereview-state-0' => 'Unreviewed',
	'imagereview-state-1' => 'In review',
	'imagereview-state-2' => 'Approved',
	'imagereview-state-3' => 'Deleted',
	'imagereview-state-4' => 'Rejected',
	'imagereview-state-5' => 'Questionable',

	'imagereview-label-ok' => 'Mark as OK',
	'imagereview-label-delete' => 'Delete',
	'imagereview-label-questionable' => 'Questionable',
	'imagereview-gotoimage' => 'Go to image page',
	'imagereview-option-ok' => 'OK',
	'imagereview-option-delete' => 'Del',
	'imagereview-option-questionable' => 'Q',

	'imagereview-imagepage-header' => 'Image Review history',
	'imagereview-imagepage-not-in-queue' => 'Warning: this image has not been added to the review queue.',
	'imagereview-imagepage-table-header-reviewer' => 'Reviewer',
	'imagereview-imagepage-table-header-state' => 'State',
	'imagereview-imagepage-table-header-time' => 'Time',

	'right-imagereview' => 'Allows access to Special:ImageReview',
	'right-imagereviewstats' => 'Allows access to Special:ImageReview/stats',
	'right-questionableimagereview' => 'Allows access to Special:ImageReview/questionable',
	'right-rejectedimagereview' => 'Allows access to Special:ImageReview/rejected',
	'right-imagereviewcontrols' => 'Allows access to image review controls',
	'right-promoteimagereview' => 'Allows access to Special:PromoteImageReview',
	'right-promoteimagereviewquestionableimagereview' => 'Allows access to Special:PromoteImageReview/questionable',
	'right-promoteimagereviewrejectedimagereview' => 'Allows access to Special:PromoteImageReview/rejected',
	'right-promoteimagereviewstats' => 'Allows access to Special:PromoteImageReview/stats',
	'right-promoteimagereviewcontrols' => 'View controls on images uploaded through Special:Promote',
];

$messages['qqq'] = [
	'imagereview-desc' => '{{desc}}',
	'imagereview-label-ok' => 'Label tooltip content for option to mark an image as OK.',
	'imagereview-label-delete' => 'Label tooltip content for option to mark an image for deletion.',
	'imagereview-label-questionable' => 'Label tooltip content for option to mark an image as questionable.',
	'imagereview-gotoimage' => 'Tooltip for link to go to image page',
	'imagereview-option-ok' => 'Text of option to mark an image as OK.',
	'imagereview-option-delete' => 'Text of option to mark an image for deletion.',
	'imagereview-option-questionable' => 'Text of option to mark an image as questionable.',
];

$messages['pl'] = [
	'imagereview-reason' => "Naruszenie [[wikia:Terms of Use|Regulaminu]] serwisu Wikia",
];
