<?php

$messages = array();

$messages['en'] = array(
	'follow-desc' => 'Improvements for the watchlist functionality',
	'wikiafollowedpages-special-heading-category' => "Categories ($1) ",
	'wikiafollowedpages-special-heading-article' => "Articles ($1)",
	'wikiafollowedpages-special-heading-blogs' => "Blogs and posts ($1)",
	'wikiafollowedpages-special-heading-forum' => 'Forum threads ($1)',
	'wikiafollowedpages-special-heading-project' => 'Project pages ($1)',
	'wikiafollowedpages-special-heading-user' => 'User pages ($1)',
	'wikiafollowedpages-special-heading-templates' => 'Templates pages ($1)',
	'wikiafollowedpages-special-heading-mediawiki' => 'MediaWiki pages ($1)',
	'wikiafollowedpages-special-heading-media' => 'Images and videos ($1)',
	'wikiafollowedpages-special-namespace' => "($1 page) ",
	'wikiafollowedpages-special-empty' => "This user's followed pages list is empty.
Add pages to this list by clicking \"{{int:watch}}\" at the top of a page.",
	'wikiafollowedpages-special-anon' => 'Please [[Special:Signup|log in]] to create or view your followed pages list.',

	'wikiafollowedpages-special-showall' => 'Show all',
	'wikiafollowedpages-special-title' => 'Followed pages',
	'wikiafollowedpages-special-delete-tooltip' => 'Remove this page',

	'wikiafollowedpages-special-hidden' => 'This user has chosen to hide their followed pages list from public view.',
	'wikiafollowedpages-special-hidden-unhide' => 'Unhide this list.',
	'wikiafollowedpages-special-blog-by' => 'by $1',
	'wikiafollowedpages-masthead' => 'Followed pages',
	'wikiafollowedpages-following' => 'Following',
	'wikiafollowedpages-special-title-userbar' => 'Followed pages',

	'tog-enotiffollowedpages' => 'E-mail me when a page I am following is changed',
	'tog-enotiffollowedminoredits' => 'E-mail me for minor edits to pages I am following',

	'wikiafollowedpages-prefs-advanced' => 'Advanced options',
	'wikiafollowedpages-prefs-watchlist' => '[[Special:Watchlist|Watchlist]] only',

	'tog-hidefollowedpages' => 'Make my followed pages lists private',
	'follow-categoryadd-summary' => "Page added to category", //TODO check this
	'follow-bloglisting-summary' => "Blog posted on blog page",

	'wikiafollowedpages-userpage-heading' => "Pages I am following",
	'wikiafollowedpages-userpage-more' => 'More',
	'wikiafollowedpages-userpage-hide' => 'hide',
	'wikiafollowedpages-userpage-empty' => "This user's followed pages list is empty.
Add pages to this list by clicking \"Follow\" at the top of a page.",

	'enotif_subject_categoryadd' => '{{SITENAME}} page $PAGETITLE has been added to $CATEGORYNAME by $PAGEEDITOR',
	'enotif_body_categoryadd' => 'Dear $WATCHINGUSERNAME,

A page has been added to a category you are following on {{SITENAME}}.

See "$PAGETITLE_URL" for the new page.

Please visit and edit often...

{{SITENAME}}

___________________________________________
* Check out our featured wikis! http://www.wikia.com

* Want to control which e-mails you receive?
Go to: {{fullurl:{{ns:special}}:Preferences}}.',

	'enotif_body_categoryadd-html' => '<p>
Dear $WATCHINGUSERNAME,
<br /><br />
A page has been added to a category you are following on {{SITENAME}}.
<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the new page.
<br /><br />
Please visit and edit often...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Check out our featured wikis!</a></li>
<li>Want to control which e-mails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User preferences</a></li>
</ul>
</p>',

	'enotif_subject_blogpost' => '{{SITENAME}} page $PAGETITLE has been posted to $BLOGLISTINGNAME by $PAGEEDITOR',
	'enotif_body_blogpost' => 'Dear $WATCHINGUSERNAME,

There has been an edit to a blog listing page you are following on {{SITENAME}}.

See "$PAGETITLE_URL" for the new post.

Please visit and edit often...

{{SITENAME}}

___________________________________________
* Check out our featured wikis! http://www.wikia.com

* Want to control which e-mails you receive?
Go to: {{fullurl:{{ns:special}}:Preferences}}.',
	'enotif_body_blogpost-HTML' => '<p>
Dear $WATCHINGUSERNAME,
<br /><br />
There has been an edit to a blog listing page you are following on {{SITENAME}}.
<br /><br />
See <a href="$PAGETITLE_URL">$PAGETITLE</a> for the new post.
<br /><br />
Please visit and edit often...
<br /><br />
{{SITENAME}}
<br /><hr />
<ul>
<li><a href="http://www.wikia.com">Check out our featured wikis!</a></li>
<li>Want to control which e-mails you receive? Go to <a href="{{fullurl:{{ns:special}}:Preferences}}">User preferences</a></li>
</ul>
</p>'
);
