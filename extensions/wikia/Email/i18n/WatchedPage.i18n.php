<?php
$messages = [];

$messages['en'] = [
	'emailext-watchedpage-subject' => '$1 on {{SITENAME}} has been edited.',
	'emailext-watchedpage-salutation' => 'Hi $1,',
	'emailext-watchedpage-article-edited' => '[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited. Check it out!',
	'emailext-watchedpage-anonymous-editor' => 'Anonymous',
	'emailext-watchedpage-diff-button-text' => 'Compare changes',
	'emailext-watchedpage-article-link-text' => "Head over to '''[$1 $2]''' to see what's new",
	'emailext-watchedpage-view-all-changes' => 'View all changes to [$1 $2]',
	'emailext-watchedpage-unfollow-text' => 'No longer interested in receiving these updates? Click [$1 here] to unfollow $2 on {{SITENAME}}.',
];

$messages['qqq'] = [
	'emailext-watchedpage-subject' => 'Subject line for watched article email. $1 -> article name',
	'emailext-watchedpage-salutation' => 'Email greeting. $1 is the recipient\'s username.',
	'emailext-watchedpage-article-edited' => 'Message to the user that an article they are following has been edited. $1 -> article url, $2 -> article title, $3 -> wikia url',
	'emailext-watchedpage-anonymous-editor' => "Word used in place of a username when the page was edited by an anonymous (logged out) user.",
	'emailext-watchedpage-diff-button-text' => 'Text for button that, when clicked, navigates to the diff page referencing this change.',
	'emailext-watchedpage-article-link-text' => "Call to action to visit the article page. $1 -> article url, $2 -> article title.",
	'emailext-watchedpage-view-all-changes' => 'Call to action to visit history of the article page. $1 -> article history url, $2 -> article title',
	'emailext-watchedpage-unfollow-text' => 'Asks the user if they want to stop following this page and provides a link to unfollow the page. $1 -> unfollow url, $2 article title',
];
