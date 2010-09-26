<?php
/**
 * @ingroup Wikia
 * @package AutoHubsPages
 * @file AutoHubsPages.i18n.php
 */

$messages = array();

$messages['en'] = array(
	'unhide' => 'Unhide',
	'hub-blog-header' => 'Top $1 Posts',
	'hub-hotspot-header' => 'Hot Spots',
	'hub-topusers-header' => 'Top $1 Users',
	'hub-featured' => 'Top $1 wikis',
	'hub-header' => '$1 Wikis',
	'hub-hotspot-info' => 'These are the hottest pages this week, ranked by most editors.',
	'hub-blog-comments' => '{{PLURAL:$1|one comment|$1 comments}}',
	'hub-blog-continue' => 'Continue reading',
	'hub-blog-showarticle' => 'Show page',
	'hub-topusers-editpoints' => '<span class="userPoints">$1</span><span class="txt">edit {{PLURAL:$1|point|points}}</span>',
	'hub-hotspot-from' => 'from', # @todo FIXME: should be followed by a parameter; requires template change.
	'hub-hide-feed' => 'Hide feed',
	'hub-show-feed' => 'Show Feed',
	'hub-contributors-info' => 'These are the top users this week, ranked by most edits.',
	'hub-editors' => '<strong>$1</strong><span>{{PLURAL:$1|editor|editors}}</span>',
);

$messages['qqq'] = array(
	'unhide' => 'Toggle link to show what is hidden.',
	'hub-blog-header' => 'Parameters:
* $1 is the blog title.',
	'hub-topusers-header' => 'Parameters:
* $1 is the list title.',
	'hub-featured' => 'Parameters:
* $1 is a page title.',
	'hub-header' => 'Parameters:
* $1 is a hub page title.',
	'hub-blog-comments' => 'Parameters:
* $1 is the number of comments.',
	'hub-topusers-editpoints' => 'Parameters:
* $1 is the number of edit points.',
	'hub-hotspot-from' => 'from',
	'hub-editors' => 'Parameters:
* $1 is the number of editors.',
);
