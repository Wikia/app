<?php

$messages = [];

$messages['en'] = [
	'insights' => 'Insights',
	'insights-desc' => 'Insights description',
	'insights-landing-title' => 'Welcome to Insights',
	'insights-landing-lead' => 'Spend your time efficiently and make informed decisions about which articles you should edit with these insights. This feature is currently in beta. Love it? Hate it? Have ideas? Please submit your thoughts via [[Special:Contact/feedback]].',
	'insights-last-edit' => 'Last edited by $1, $2',
	'insights-list-no-items' => 'Great work! There are no articles in this queue that need attention.',
	'insights-list-header-page' => 'Page',
	'insights-list-header-pageviews' => 'Page views',
	// Uncategorized pages
	'insights-list-subtitle-uncategorizedpages' => 'Pages without categories',
	'insights-list-description-uncategorizedpages' => 'Add categories to these pages. Good categorization is vital to a successfully organized wikia!',
	'insights-notification-message-inprogress-uncategorizedpages' => 'This page needs categories added. ',
	'insights-notification-message-fixed-uncategorizedpages' => 'Awesome, this page is now categorized.',
	'insights-notification-next-item-uncategorizedpages' => 'Go to the next uncategorized article.',
	// Without image pages
	'insights-list-subtitle-withoutimages' => 'Pages without images',
	'insights-list-description-withoutimages' => 'Articles with images are read more often, shared more often, and perform better in search engines than those without images. Even adding a loosely related image can help.',
	'insights-notification-message-inprogress-withoutimages' => 'This page needs an image. ',
	'insights-notification-message-fixed-withoutimages' => 'Great, the page looks much better!',
	'insights-notification-next-item-withoutimages' => ' Go to the next article that could use one.',
	// Deadend/Without links pages
	'insights-list-subtitle-deadendpages' => 'Pages without links',
	'insights-list-description-deadendpages' => 'These pages should link to other articles on your wikia. Well-linked articles help readers discover more information about your topic and improve search engine rankings.',
	'insights-notification-message-inprogress-deadendpages' => 'This page needs links to other pages. ',
	'insights-notification-message-fixed-deadendpages' => 'Yay, this page is now linked!',
	'insights-notification-next-item-deadendpages' => 'Go to the next article that needs links.',
	// Wanted pages
	'insights-list-subtitle-wantedpages' => 'Wanted pages',
	'insights-list-description-wantedpages' => 'There are redlinks pointing to these pages, but the pages don\'t exist! Create the article or make it a redirect to the correct article to help readers navigate your community.',
	'insights-notification-message-inprogress-wantedpages' => 'This page needs to be created. ',
	'insights-notification-message-fixed-wantedpages' => 'Thanks for making this page!',
	'insights-notification-next-item-wantedpages' => 'Create another article.',
	// Popular pages
	'insights-list-subtitle-popularpages' => 'Popular pages',
	'insights-list-description-popularpages' => 'These pages are gaining traction with your readers! Make sure they are up to your standards and have all the latest images and information.',
	'insights-notification-message-inprogress-popularpages' => 'This page is frequently read. Make sure it looks great!',
	'insights-notification-next-item-popularpages' => 'Go to the next uncategorized article.',

	// Sorting
	'insights-sort-label' => 'Sort by',
	'insights-sort-pageviews-1week' => 'Page views, last week',
	'insights-sort-pageviews-4weeks' => 'Page views, last 4 weeks',
	'insights-sort-pageviews-risingfast' => 'Recent increase in page views',
	'insights-sort-alphabetical' => 'Alphabetical',

	'insights-notification-message-alldone' => 'Congratulations! There are no more items in this queue.',
	'insights-notification-message-fixit' => 'Let\'s fix it.',
	'insights-notification-list-button' => 'Go back to the list',
	'insights-notification-see-more' => 'See more insights.',
	'insights-wanted-by' => '$1 referral links',

	// WikiActivity module
	'insights-module-see-more' => 'See more insights',
];

$messages['qqq'] = [
	'insights' => 'Name of the insights page',
	'insights-desc' => 'Insights description',
	'insights-landing-title' => 'A title of the Insights landing page appearing as an h1 element.',
	'insights-landing-lead' => 'A lead for the Insights special page with a general description, appearing below the title.',
	'insights-last-edit' => 'Information who and when made last edit for chosen article on the list',
	'insights-list-no-items' => 'A message that is shown when there are no items to work on left on a list',
	'insights-list-header-page' => 'A header of an Insights list table for a column with a title and last revision data',
	'insights-list-header-pageviews' => 'A header of an Insights list table for a column with a number of views of an article',
	// Uncategorized pages
	'insights-list-subtitle-uncategorizedpages' => 'A title of a subpage with a list of uncategorized pages',
	'insights-list-description-uncategorizedpages' => 'A description for a subpage with a list of uncategorized pages',
	'insights-notification-message-inprogress-uncategorizedpages' => 'Message displayed on notification banner informing user that category should be added to the page',
	'insights-notification-message-fixed-uncategorizedpages' => 'Message displayed on notification banner informing user that category was added to the page',
	'insights-notification-next-item-uncategorizedpages' => 'Link text to redirect to next uncategorized page',
	// Without image pages
	'insights-list-subtitle-withoutimages' => 'A title of a subpage with a list of pages without images',
	'insights-list-description-withoutimages' => 'A description for a subpage with a list of pages without images',
	'insights-notification-message-inprogress-withoutimages' => 'Message displayed on notification banner informing user that image should be added to the page',
	'insights-notification-message-fixed-withoutimages' => 'Message displayed on notification banner informing user that image was added to the page',
	'insights-notification-next-item-withoutimages' => ' Link text to redirect to next page without image',
	// Deadend/Without links pages
	'insights-list-subtitle-deadendpages' => 'A title of a subpage with a list of pages with no links',
	'insights-list-description-deadendpages' => 'A description for a subpage with a list of pages with no links',
	'insights-notification-message-inprogress-deadendpages' => 'Message displayed on notification banner informing user that the page needs links',
	'insights-notification-message-fixed-deadendpages' => 'Message displayed on notification banner informing user that links were added to the page',
	'insights-notification-next-item-deadendpages' => 'Link text to redirect to next page without links',
	//Wanted pages
	'insights-list-subtitle-wantedpages' => 'A title of a subpage with a list of wanted pages',
	'insights-list-description-wantedpages' => 'A description for a subpage with a list of wanted pages',
	'insights-notification-message-inprogress-wantedpages' => 'Message displayed on notification banner informing user that page should be created',
	'insights-notification-message-fixed-wantedpages' => 'Message displayed on notification banner informing user that page was created',
	'insights-notification-next-item-wantedpages' => 'Link text to redirect to next not existing page',

	'insights-wanted-by' => 'An information on how many other articles links to the one displayed above.',

	'insights-notification-message-alldone' => 'Message displayed on notification banner informing user that there is no more articles to fix in current Insight type',
	'insights-notification-message-fixit' => 'Text encouraging user to fix an issue',
	'insights-notification-list-button' => 'Text on button that redirects to list of insights',
	'insights-notification-see-more' => 'Link text to redirect to Insights main page to see more Insight types',
];
