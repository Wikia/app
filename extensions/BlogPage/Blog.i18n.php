<?php
/**
 * Internationalization file for the BlogPage extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author David Pean
 */
$messages['en'] = array(
	'blog-and' => 'and',
	'blog-anonymous-name' => 'Anonymous Fanatic',
	'blog-author-comments' => '$1 {{PLURAL:$1|comment|comments}}',
	'blog-author-more-by' => 'More By $1', // $1 is a user name
	'blog-author-points' => '$1 pts',
	'blog-author-title' => 'About the {{PLURAL:$1|Author|Authors}}',
	'blog-author-votes' => '$1 {{PLURAL:$1|vote|votes}}',
	'blog-by' => 'by',
	'blog-by-user-category' => '$1 by User', // $1 is MediaWiki:Blog-category
	'blog-category' => 'Articles', // replaces $wgBlogCategory config variable
	'blog-comments-of-day' => 'Comments of the Day',
	'blog-created' => 'created $1',
	'blog-created-ago' => 'created $1 ago',
	'blog-embed-title' => 'Embed This On Your Site',
	'blog-in-the-news' => 'In the News',
	'blog-last-edited' => 'last edited $1',
	'blog-login' => 'You have to [[Special:UserLogin|log in]] to create articles.',
	'blog-login-edit' => 'You have to [[Special:UserLogin|log in]] to edit blog articles.',
	'blog-new-articles' => 'New Articles',
	'blog-permission-required' => 'You do not have the permission to create articles.',
	'blog-popular-articles' => 'Don\'t Miss',
	'blog-multiple-authors' => 'This article was written collaboratively by $1',
	'blog-recent-editors' => 'Other recent contributors',
	'blog-recent-editors-message' => 'Make this page better by editing it.',
	'blog-recent-voters' => 'Other recent voters',
	'blog-recent-voters-message' => 'If you like the article, vote for it.',
	'blog-view-archive-link' => 'View All',
	// Duplicates RandomGameUnit's messages, I dunno why
	'game-unit-quiz-title' => 'Never Ending Quiz',
	'game-unit-poll-title' => 'Take a Poll',
	'game-unit-picturegame-title' => 'Play the Picture Game',
	// ArticlesHome
	// title of Special:ArticleLists, as shown on Special:SpecialPages.
	// I could've used ah-new-articles but I figured that people will mistake
	// it to wiki articles as opposed to blog articles so I decided to create a
	// new message instead.
	'articlelists' => 'New Blog Articles',
	'ah-no-results' => 'No pages found.',
	'ah-popular-articles' => 'Popular Articles',
	'ah-new-articles' => 'New Articles',
	'ah-rss-feed' => 'RSS feed',
	'ah-write-article' => 'Write an Article',
	'ah-todays-articles' => 'Today\'s Articles',
	'ah-most-votes' => 'Most Votes (72 hours)',
	'ah-what-talking-about' => 'Most Comments (72 hours)',
	'articleshome' => 'Blog Homepage',
	// Special:CreateBlogPost
	'createblogpost' => 'Create Blog Post',
	'blog-create-rules' => '', // rules shown above the title field; do not translate!
	'blog-tagcloud-blacklist' => '', // list of categories that won't be shown on the tagcloud; format is: * cat name\n* another
	'blog-create-category-help' => 'Categories help organize information on the site. To add multiple categories, separate them by commas.',
	'blog-create-title' => 'Title',
	'blog-create-text' => 'Text',
	'blog-create-categories' => 'Categories',
	'blog-create-button' => 'Create!',
	'blog-create-summary' => 'New blog post created.',
	'blog-create-error-need-content' => "'''Error:''' Your blog post must have some content!",
	'blog-create-error-need-title' => "'''Error:''' You need to supply a title for the blog post!",
	'blog-create-error-page-exists' => "'''Error:''' There is already a blog post with that title. Please choose a different title for your blog post.",
	'blog-js-create-error-need-content' => 'Your blog post must have some content!',
	'blog-js-create-error-need-title' => 'You need to supply a title for the blog post!',
	'blog-js-create-error-page-exists' => 'There is already a blog post with that title. Please choose a different title for your blog post.',
	// Ported from ListPages
	'blog-more' => 'more',
	'blog-time-ago' => '$1 ago',
	'blog-time-days' => '{{PLURAL:$1|one day|$1 days}}',
	'blog-time-hours' => '{{PLURAL:$1|one hour|$1 hours}}',
	'blog-time-minutes' => '{{PLURAL:$1|one minute|$1 minutes}}',
	'blog-time-seconds' => '{{PLURAL:$1|one second|$1 seconds}}',
	'right-createblogpost' => '[[Special:CreateBlogPost|Create new blog posts]]',
	// Integration with UserProfile
	// These messages didn't originally have the blog- prefix
	'blog-user-articles-title' => 'Blogs',
	'blog-user-articles-votes' => '{{PLURAL:$1|one vote|$1 votes}}',
	'blog-user-article-comment' => '{{PLURAL:$1|one comment|$1 comments}}',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'blog-and' => 'ja',
	'blog-anonymous-name' => 'Anonyymi fanaatikko',
	'blog-author-comments' => '$1 {{PLURAL:$1|kommentti|kommenttia}}',
	'blog-author-more-by' => 'Lisää kirjoituksia käyttäjältä $1',
	'blog-author-title' => 'Tietoa {{PLURAL:$1|tekijästä|tekijöistä}}',
	'blog-author-votes' => '$1 {{PLURAL:$1|ääni|ääntä}}',
	'blog-by' => 'kirjoittanut',
	'blog-by-user-category' => '$1, jotka on kirjoittanut',
	'blog-category' => 'Artikkelit',
	'blog-comments-of-day' => 'Päivän kommentit',
	'blog-created' => 'luotu $1',
	'blog-created-ago' => 'luotu $1 sitten',
	'blog-in-the-news' => 'Uutisissa',
	'blog-last-edited' => 'viimeisin muokkaus $1',
	'blog-login' => 'Sinun tulee [[Special:UserLogin|kirjautua sisään]] luodaksesi artikkeleita.',
	'blog-login-edit' => 'Sinun tulee [[Special:UserLogin|kirjautua sisään]] muokataksesi blogiartikkeleita.',
	'blog-more' => 'lisää',
	'blog-new-articles' => 'Uudet artikkelit',
	'blog-permission-required' => 'Sinulla ei ole oikeutta luoda artikkeleita.',
	'blog-popular-articles' => 'Älä unohda',
	'blog-multiple-authors' => 'Tämän artikkelin kirjoittivat yhdessä $1',
	'blog-recent-editors' => 'Muut tuoreet muokkaajat',
	'blog-recent-editors-message' => 'Tee tästä sivusta parempi muokkaamalla sitä.',
	'blog-recent-voters' => 'Muut tuoreet äänestäjät',
	'blog-recent-voters-message' => 'Jos pidit artikkelista, äänestä sitä.',
	'blog-time-ago' => '$1 sitten',
	'blog-time-days' => '{{PLURAL:$1|päivä|$1 päivää}}',
	'blog-time-hours' => '{{PLURAL:$1|tunti|$1 tuntia}}',
	'blog-time-minutes' => '{{PLURAL:$1|minuutti|$1 minuuttia}}',
	'blog-time-seconds' => '{{PLURAL:$1|sekunti|$1 sekuntia}}',
	'blog-view-archive-link' => 'Katso kaikki',
	'game-unit-poll-title' => 'Ota osaa äänestykseen',
	'game-unit-quiz-title' => 'Pelaa tietovisapeliä',
	'game-unit-picturegame-title' => 'Pelaa kuvapeliä',
	'articlelists' => 'Uudet blogiartikkelit',
	'ah-no-results' => 'Sivuja ei löytynyt.',
	'ah-popular-articles' => 'Suositut artikkelit',
	'ah-new-articles' => 'Uudet artikkelit',
	'ah-rss-feed' => 'RSS-syöte',
	'ah-write-article' => 'Kirjoita artikkeli',
	'ah-todays-articles' => 'Tämänpäiväiset artikkelit',
	'ah-most-votes' => 'Eniten ääniä (72 tuntia)',
	'ah-what-talking-about' => 'Eniten kommentteja (72 tuntia)',
	'articleshome' => 'Blogien kotisivu',
	'createblogpost' => 'Luo blogikirjoitus',
	'blog-create-category-help' => 'Luokat auttavat järjestämään tämän sivuston tietoa. Lisätäksesi useampia luokkia erottele ne pilkuin.',
	'blog-create-title' => 'Otsikko',
	'blog-create-text' => 'Teksti',
	'blog-create-categories' => 'Luokat',
	'blog-create-button' => 'Luo!',
	'blog-create-summary' => 'Uusi blogikirjoitus luotu.',
	'blog-create-error-need-content' => "'''Virhe:''' Blogikirjoituksellasi tulee olla myös sisältöä!",
	'blog-create-error-need-title' => "'''Virhe:''' Sinun tulee antaa otsikko blogikirjoituksellesi!",
	'blog-create-error-page-exists' => "'''Virhe:''' Olemassaolevalla blogikirjoituksella on jo sama otsikko. Annathan erilaisen otsikon blogikirjoituksellesi.",
	'blog-js-create-error-need-content' => 'Blogikirjoituksellasi tulee olla myös sisältöä!',
	'blog-js-create-error-need-title' => 'Sinun tulee antaa otsikko blogikirjoituksellesi!',
	'blog-js-create-error-page-exists' => 'Olemassaolevalla blogikirjoituksella on jo sama otsikko. Annathan erilaisen otsikon blogikirjoituksellesi.',
	'right-createblogpost' => '[[Special:CreateBlogPost|Luoda uusia blogikirjoituksia]]',
	'blog-user-articles-title' => 'Blogit',
	'blog-user-articles-votes' => '{{PLURAL:$1|yksi ääni|$1 ääntä}}',
	'blog-user-article-comment' => '{{PLURAL:$1|yksi kommentti|$1 kommenttia}}',
);