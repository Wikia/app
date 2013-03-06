<?php
/**
 * Internationalisation file for the WikiaHubs V2 extension.
 *
 * @addtogroup Languages
 */

$messages = array();

$messages['en'] = array(
	// general
	'wikiahubs-button-cancel' => 'Cancel',

	// suggest article
	'wikiahubs-suggest-article-header' => 'Suggest an Article',
	'wikiahubs-suggest-article-submit-button' => 'Submit',
	'wikiahubs-suggest-article-what-article' => 'What URL do you want to share? (255 character limit)',
	'wikiahubs-suggest-article-reason' => 'Why is this cool? (140 characters limit)',
	'wikiahubs-suggest-article-success' => 'Thanks for suggesting an article, our editors will look over it. Check back often to see if it\'s up!',
	'wikiahubs-error-invalid-article-url-length' => 'Article url requires at least 10 characters',
	'wikiahubs-error-invalid-reason-length' => 'Comment must be between 1 and 140 characters',

	// wikia hubs
	'wikiahubs-vertical-VideoGames' => 'Video Games',
	'wikiahubs-vertical-Entertainment' => 'Entertainment',
	'wikiahubs-vertical-Lifestyle' => 'Lifestyle',
	
	// from the community
	'wikiahubs-from-community-promoted' => 'Get Promoted',
	'wikiahubs-from-community-caption' => 'From [$1 $2] on [$3 $4]',

	//featured video
	'wikiahubs-sponsored-by' => 'Sponsored by $1',

	// 404 page
	'wikiahubs-404-title' => 'The page you are looking for cannot be found',
	'wikiahubs-404-message' => "We couldn't find the page you are looking for. [[$1|Click here]] to go to today's hub."
);

$messages['de'] = array(
	'wikiahubs-button-cancel' => 'Abbrechen',

	'wikiahubs-suggest-article-header' => 'Artikel vorschlagen',
	'wikiahubs-suggest-article-submit-button' => 'Abschicken',
	'wikiahubs-suggest-article-what-article' => 'Was möchtest du teilen? (255 Zeichen maximal)',
	'wikiahubs-suggest-article-reason' => 'Warum ist das cool? (140 Zeichen maximal)',
	'wikiahubs-suggest-article-success' => 'Danke für deinen Vorschlag! Wie schauen ihn uns schnellstmöglich an. Schau bald wieder vorbei!',
	'wikiahubs-error-invalid-article-url-length' => 'Die Artikel-URL muss mindestens 10 Zeichen lang sein.',
	'wikiahubs-error-invalid-reason-length' => 'Dein Kommentar muss zwischen 1 und 140 Zeichen lang sein.',

	// wikia hubs
	'wikiahubs-vertical-video-games' => 'Videospiele',
	'wikiahubs-vertical-entertainment' => 'Entertainment',
	'wikiahubs-vertical-lifestyle' => 'Lifestyle',
);

$messages['qqq'] = array(
	// general
	'wikiahubs-button-cancel' => 'Cancel',

	// suggest article
	'wikiahubs-suggest-article-header' => 'Get promoted - modal title',
	'wikiahubs-suggest-article-submit-button' => 'Get promoted - text on submit button on modal',
	'wikiahubs-suggest-article-what-article' => 'Get promoted - Label for article Url field - should include info about 255 chars max',
	'wikiahubs-suggest-article-reason' => 'Get promoted - Label for reason field - should include info about 140 chars max',
	'wikiahubs-suggest-article-success' => 'Get promoted - message after successful add',
	'wikiahubs-error-invalid-article-url-length' => 'Get promoted - Article url validation error message',
	'wikiahubs-error-invalid-reason-length' => 'Get promoted - Reason validation error message',

	// wikia hubs
	'wikiahubs-vertical-VideoGames' => 'Video Games hub name',
	'wikiahubs-vertical-Entertainment' => 'Entertainment hub name',
	'wikiahubs-vertical-Lifestyle' => 'Lifestyle hub name',

	// from the community
	'wikiahubs-from-community-promoted' => 'Text on button next to FTC title - suggest new article',
	'wikiahubs-from-community-caption' => 'From [$1 $2] on [$3 $4] - 1st parameter: Users URL, 2nd - User Name, 3rd - Article Url, 4th - wiki name',

	//featured video
	'wikiahubs-sponsored-by' => 'Just a text next to the sponsor image (logo). First parameter is <img /> tag with the image path',

	// 404 page
	'wikiahubs-404-title' => '404 page title',
	'wikiahubs-404-message' => '404 page message, first parameter is link to actual hub page'
);
