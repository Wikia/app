<?php
/**
 * Internationalisation file for Special:CategoryIntersection extension.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'categoryintersection' => 'Category Intersection API demonstration',
	'categoryintersection-desc' => 'A front-end for the "categoryintersection" API function to show what it can use and assist in understanding it for actual use via the MediaWiki API',
	'categoryintersection-header-title' => 'About',
	'categoryintersection-header-body' => 'This page is designed to show the types of things that the CategoryIntersection API function can do and make it easy to learn how to use it.  For more information please see: $1',
	'categoryintersection-docs-linktext' => 'Category Intersection MediaWiki API documentation',
	'categoryintersection-form-title' => 'Try it out',
	'categoryintersection-form-submit' => 'Find matches',
	'categoryintersection-and' => '- and -',
	'categoryintersection-limit' => 'Limit',
	'categoryintersection-instructions-title' => 'Instructions',
	'categoryintersection-instructions' => 'Type in two categories (including the "Category:" part at the beginning) to see all articles which are in BOTH of those categories and to see an example URL of how that was obtained using the API.',
	'categoryintersection-results-title' => 'API Results',
	'categoryintersection-noresults' => 'No results. Please check that the category names are correct if you think there should be results.',
	'categoryintersection-query-used' => 'API query used:',
	'categoryintersection-footer-title' => 'Examples',
	'categoryintersection-footer-body' => 'Here are some example queries, just to show a few of the types of things that can be done with this API. There are numerous other cool possibilies though... Be creative!',
	'categoryintersection-summary' => 'Searched for categories: $1; limit: $2; number of results returned: $3',
);

/** Message documentation (Message documentation)
 *
 */
$messages['qqq'] = array(
	'categoryintersection-desc' => '{{desc}}',
	'categoryintersection-and' => 'Displayed between consecutive boxes for categories. Separates the categories visually but shows that adding more of them is a logical-and operation (ie: articles will have to be in ALL of the categories to be in the result set.'
);
