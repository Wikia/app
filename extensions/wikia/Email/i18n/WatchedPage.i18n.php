<?php
$messages = [];

$messages['en'] = [
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => '[[$1|$2]] on [[$3|$4]] has been edited. [[$1|Check it out!]]',
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-article-link-text' => "Head over to '''[[$1]]''' to see what's new",
	'emailext-watchedpage-unfollow-text' => 'No longer interested in receiving these updates?',
	'emailext-watchedpage-unfollow-link-text' => 'Click here to unfollow $1 on $2.',
	'emailext-watchedpage-recipient-notice' => 'Email sent to $1 from Wikia',
	'emailext-watchedpage-update-frequency' => 'To change which emails you receive or their frequency, please visit your [[Special:Preferences|Preferences]] page.',
	'emailext-watchedpage-unsubscribe' => 'To unsubscribe from all Wikia emails, [[$1|click here]].',
];

$messages['qqq'] = [
	'emailext-watchedpage-salutation' => 'Email greeting. $1 is the recipient\'s username.',
	'emailext-watchedpage-article-edited' => 'Message to the user that an article they are following has been edited. $1 -> article url, $2 -> article title, $3 -> wikia url, $4 -> wikia name ',
	'emailext-watchedpage-diff-button-text' => 'Text for button that, when clicked, navigates to the diff page referencing this change.',
	'emailext-watchedpage-article-link-text' => "Call to action to visit the article page. $1 is the name of the article.",
	'emailext-watchedpage-unfollow-text' => 'Asks the user if they want to stop following this page. Question is answered with "emailext-watchedpage-unfollow-link-text"',
	'emailext-watchedpage-unfollow-link-text' => 'Follows question asked in "emailext-watchedpage-unfollow-text". $1 -> article name, $2 -> wikia name.',
	'emailext-watchedpage-recipient-notice' => 'Informs the user who the intended recipient of the email is. $1 is the recipient\'s email address.',
	'emailext-watchedpage-update-frequency' => 'Provides a link for users to update their email preferences',
	'emailext-watchedpage-unsubscribe' => 'Provides a link for users to opt out of emails altogether. $1 is the unsubscribe link.',
];
