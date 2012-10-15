<?php

$messages = array(
'en' => 
	array(
		'wikifeeds'=>'Wiki Feeds',
		'wikifeeds_unknownformat' => "==Unknown format==\nThe feed format you requested is not available.",
		'wikifeeds_unknownfeed' => "==Unknown feed==\nThe feed you selected is not available.",
		'wikifeeds_undefinedcategory' => "==Undefined category==\nThe feed you requested requires that the ''category'' parameter be defined",
		'wikifeeds_categorynoexist' => "==Unknown category==\nThe category you tried to request does not exist.  Category names are case sensitive.  Be sure the category is listed at [[Special:Categories]]",
		'wikifeeds_undefineduser' => "==Undefined user==\nThe feed you requested requires that the ''user'' parameter be defined",
		'wikifeeds_unknownuser' => "==Unknown user==\nThe user specified does not exist. Be sure the user is listed at [[Special:User]]",
		'wikifeeds_nowatchlisttoken' => "==No Token==\nYou must supply a token to access your user watchlist",
		'wikifeeds_invalidwatchlisttoken' => "==Invalid Token==\nThe token specified to access the watchlist is invalid",
		'wikifeeds_tokeninfo' => "==Watchlist Token==\nYour private watchlist token is $1.  Access your watchlist via $2",
		'wikifeeds_feed_newestarticles_title' => 'Newest Articles',
		'wikifeeds_feed_newestarticles_description' => 'Newest articles in the wiki',
		'wikifeeds_feed_recentarticlechanges_title' => 'Recently Changed Articles',
		'wikifeeds_feed_recentarticlechanges_description' => 'Recently changed articles in the wiki',
		'wikifeeds_feed_newestarticlesbyuser_title' => 'Newest articles created by $1',
		'wikifeeds_feed_newestarticlesbyuser_description' => 'Newest articles created by $1',
		'wikifeeds_feed_recentuserchanges_title' => 'Recent changes by $1',
		'wikifeeds_feed_recentuserchanges_description' => 'Recent changes made by user $1',
		'wikifeeds_feed_userwatchlist_title' => 'Watchlist for $1',
		'wikifeeds_feed_userwatchlist_description' => 'Watchlist for $1',
		'wikifeeds_feed_recentcategorychanges_title' => 'Recently changed articles in $1',
		'wikifeeds_feed_recentcategorychanges_description' => 'Recently changed articles in category $1',
		'wikifeeds_feed_newestarticlesincategory_title' => 'Newest articles in the category $1',
		'wikifeeds_feed_newestarticlesincategory_description' => 'Newly created articles that are part of the category $1',

		'wikifeeds_mainpage' =>
"WikiFeeds generates syndicated feeds for this wiki.

==Available feeds==
Feeds are requested using an intuitive URL scheme.  All requests take the form of ''Special:WikiFeeds/'''format'''/'''feed'''/'''param1'''/'''value1'''/'''param2'''/'''value2''''' etc

===Formats===
Feeds ara available in the following formats
*ATOM 1.0 ('''format''' = ''atom'')
*RSS 2.0 ('''format''' = ''rss'')

===Feeds===
*Newest articles ('''newestarticles''') ([[Special:WikiFeeds/atom/newestarticles|atom]], [[Special:WikiFeeds/rss/newestarticles|rss]])
*Recently changed articles ('''recentarticlechanges''') ([[Special:WikiFeeds/atom/recentarticlechanges|atom]], [[Special:WikiFeeds/rss/recentarticlechanges|rss]])
*Recent changes by user ('''recentuserchanges''')
*Newest articles for a user ('''newestuserarticles''')
*User watchlist ('''watchlist''')
*Recent changes for articles in category ('''recentcategorychanges''')
*Newest articles in category ('''newestcategoryarticles''')

===Parameters===
*user (required for user-related feeds)
*category (required for category-related feed)
*count - overrides default item limit

==Example requests==

*{{fullurl:Special:WikiFeeds/atom/newestarticles}} - ATOM 1.0 feed of newest articles in the wiki
*{{fullurl:Special:WikiFeeds/atom/recentuserchanges/user/Gregory.Szorc}} - ATOM 1.0 feed for recent changes by [[User:Gregory.Szorc|Gregory.Szorc]]
*{{fullurl:Special:WikiFeeds/rss/watchlist/user/Jeremy.Smith/count/50}} - RSS feed for [[User:Jeremy.Smith|Jeremy.Smith]]'s watchlist
*{{fullurl:Special:WikiFeeds/rss/recentcategorychanges/category/Buildings}} - RSS feed for recently changed articles in the [[:Category:Buildings|Buildings]] category

__NOTOC__
",
	)
);
