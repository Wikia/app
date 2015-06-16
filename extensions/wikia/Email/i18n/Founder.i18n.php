<?php
$messages = array();

$messages['en'] = array(
	'emailext-founder-active-subject' => '{{SITENAME}} is heating up!',
	'emailext-founder-subject' => '$1 on {{SITENAME}} has been edited by $2',
	'emailext-founder-anon-subject' => '$1 on {{SITENAME}} has been edited',
	'emailext-founder-summary' => '[$1 $2] on [{{SERVER}} {{SITENAME}}] has been edited.',
	'emailext-founder-active-summary' => "Congratulations, there's a lot going on at {{SITENAME}} today! Here are some recent updates:",
	'emailext-founder-body' => 'This is [$1 $2]’s first edit on your wikia. Help them feel like they are a part of the community and encourage them to keep that good stuff coming!',
	'emailext-founder-link-label' => 'Compare Changes',
	'emailext-founder-active-link-label' => 'All Recent Activity',
	'emailext-founder-footer-article' => "Head over to [$1 $2] to see what's new",
	'emailext-founder-footer-all-changes' => 'View all changes to [$1 $2]',
	'emailext-founder-encourage' => 'This is [$1 $2]’s first edit on your wikia. Help them feel like they are a part of the community and encourage them to keep that good stuff coming!',
	'emailext-founder-anon-encourage' => 'Wikia fans are people who make edits without logging in to a registered account. Go see what this mysterious friend added to your wikia!',
	'emailext-founder-multi-encourage' => '[$1 $2] has made multiple edits on your wikia. Thank them for their contributions. It’s all about community-building!',
	'emailext-founder-new-update' => 'Created [$1 $2]',
	'emailext-founder-edit-update' => 'Updated [$1 $2]',
	'emailext-founder-active-footer-1' => "If you haven't already, you can see all of the great work that's been happening on your community’s activity page. Since there's so much going on, keep in mind you can change your email preferences to digest mode. With digest mode, you'll receive one email that lists all of the activity on your wikia each day.",
	'emailext-founder-active-footer-2' => 'Way to go on creating such an active fan community!',
);

$messages['qqq'] = array(
	'emailext-founder-active-subject' => 'Subject of the email sent to founders when there is increased edit activity on the wiki',
	'emailext-founder-subject' => 'Subject of the email sent to founders on an edit to their wiki.  $1 -> page title, $2 -> author',
	'emailext-founder-anon-subject' => 'Subject of the email sent to founder on an anonymous edit to their wiki.  $1 -> page title',
	'emailext-founder-summary' => 'Summary text in the body of the email.  $1 -> page URL, $2 -> page title',
	'emailext-founder-active-summary' => "Summary text in the body of the email when there is increased edit activity on the wiki",
	'emailext-founder-body' => 'Body text of the email.  $1 -> author profile page URL, $2 -> author name',
	'emailext-founder-link-label' => 'Button label linking to diff page of changes to the article changed',
	'emailext-founder-active-link-label' => 'Button label linking to the wiki activity page',
	'emailext-founder-footer-article' => "Footer text with link inviting user to see changes since last edit.  $1 -> diff URL, $2 -> page title",
	'emailext-founder-footer-all-changes' => 'Foot text with link inviting user to see all changes on the page.  $1 -> history page URL, $2 -> page title',
	'emailext-founder-encourage' => 'Encouragement text for the founder to support the user who just edited.  $1 -> author profile URL, $2-> author name',
	'emailext-founder-anon-encourage' => 'Text explaining what an anonymous edit is',
	'emailext-founder-multi-encourage' => 'Text letting the founder know a contributor has made multiple edits.  $1 -> author profile URL, $2 -> author name',
	'emailext-founder-new-update' => 'Text shown next to a wiki change related to a new page.  $1 -> new page URL, $2 -> new page title',
	'emailext-founder-edit-update' => 'Text shown next to a wiki change related to an edited page.  $1 -> new page URL, $2 -> new page title',
	'emailext-founder-active-footer-1' => "Instructional text shown to a wiki founder who has gotten a lot of recent edit activity",
	'emailext-founder-active-footer-2' => 'Encouragement text shown to a wiki founder who has gotten a lot of recent edit activity',
);
