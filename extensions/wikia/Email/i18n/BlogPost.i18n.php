<?php
$messages = array();

$messages['en'] = array(
	'emailext-blogpost-subject' => '$1 has written a new post on $2: $3',
	'emailext-blogpost-summary' => "There's a new post on [$1 $2] on [{{SERVER}} {{SITENAME}}]. Take a look!",
	'emailext-blogpost-link-label' => 'Read Full Post',
	'emailext-blogpost-view-all' => '[$1 All recent blog posts on $2]'
);

$messages['qqq'] = array(
	'emailext-blogpost-subject' => 'Subject for the email being sent.  $1 is the user who wrote the post, $2 is the blog listing page name and $3 is the post title',
	'emailext-blogpost-summary' => 'Information about a the post.  $1 is the link and $2 is the title of the blog listing page.',
	'emailext-blogpost-link-label' => 'Label text for a button a user can click to view the post',
	'emailext-blogpost-view-all' => 'A link to the listing page with all recent posts.  $1 is the link itself, and must remain at the beginning of the string with a space after it and $2 is the name of the listing page'
);
