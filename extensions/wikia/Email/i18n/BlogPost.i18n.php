<?php
$messages = array();

$messages['en'] = array(
	'emailext-blogpost-user-subject' => '$1 has written a new post: $2',
	'emailext-blogpost-list-subject' => '$1 has written a new post on $2: $3',
	'emailext-blogpost-user-summary' => "There is a new post on [$1 $2's blog] on [{{SERVER}} {{SITENAME}}]. Take a look!",
	'emailext-blogpost-list-summary' => "There is a new post on [$1 $2] on [{{SERVER}} {{SITENAME}}]. Take a look!",
	'emailext-blogpost-link-label' => 'Read Full Post',
	'emailext-blogpost-view-all' => '[$1 All recent blog posts on $2]',
	'emailext-blogpost-unfollow-text' => "No longer interested in receiving these updates? Click [$1 here] to unfollow $2's blog on {{SITENAME}}.",
);

$messages['qqq'] = array(
	'emailext-blogpost-user-subject' => 'Subject for the user blog email being sent.  $1 is the user who wrote the post and $2 is the post title',
	'emailext-blogpost-list-subject' => 'Subject for the blog list email being sent.  $1 is the user who wrote the post, $2 is the blog listing page name and $3 is the post title',
	'emailext-blogpost-user-summary' => "Information about the post on a user's blog.  $1 is a link to the user's blog page and $2 is the user's name",
	'emailext-blogpost-list-summary' => 'Information about the post on the blog listing.  $1 is the link to the listing and $2 is the title of the blog listing page.',
	'emailext-blogpost-link-label' => 'Label text for a button a user can click to view the post',
	'emailext-blogpost-view-all' => 'A link to the listing page with all recent posts.  $1 is the link itself, and must remain at the beginning of the string with a space after it and $2 is the name of the listing page',
	'emailext-blogpost-unfollow-text' => "Asks the user if they want to stop following this blog and provides a link to unfollow the blog. $1 -> unfollow url, $2 blog author name",
);
