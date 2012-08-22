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
	'wikiahubs-button-close' => 'Finished',

	// suggest video
	'wikiahubs-suggest-video-submit-button' => 'Suggest Video',
	'wikiahubs-suggest-video-what-video' => 'What video do you want to share?',
	'wikiahubs-suggest-video-what-video-default-value' => 'From YouTube, Hulu, your favorite wiki, etc.',
	'wikiahubs-suggest-video-which-wiki' => 'Which wiki is this from?',
	'wikiahubs-suggest-video-which-wiki-default-value' => 'Star Wars, ...',
	'wikiahubs-suggest-video-success' => 'Thanks for suggesting a video, our editors will look over it. Check back often to see if it\'s up!',
	'wikiahubs-error-invalid-video-url-length' => 'Video url requires at least 10 characters',
	'wikiahubs-error-invalid-wikiname-length' => 'Wikiname requires at least 1 character',

	// suggest article
	'wikiahubs-suggest-article-header' => 'Suggest an Article',
	'wikiahubs-suggest-article-submit-button' => 'Submit',
	'wikiahubs-suggest-article-what-article' => 'What do you want to share?',
	'wikiahubs-suggest-article-reason' => 'Why is this cool? (140 characters limit)',
	'wikiahubs-suggest-article-success' => 'Thanks for suggesting an article, our editors will look over it. Check back often to see if it\'s up!',
	'wikiahubs-error-invalid-article-url-length' => 'Article url requires at least 10 characters',
	'wikiahubs-error-invalid-reason-length' => 'Comment must be between 1 and 140 characters',

	//popular videos
	'wikiahubs-popular-videos-suggested-by' => 'Suggested by [[User:$1|$1]]',
	'wikiahubs-popular-videos-suggested-by-profile' => 'Suggested by [$2 $1]',

	// wikia hubs
	'wikiahubs-vertical-VideoGames' => 'Video Games',
	'wikiahubs-vertical-Entertainment' => 'Entertainment',
	'wikiahubs-vertical-Lifestyle' => 'Lifestyle',
	
	// from the community
	'wikiahubs-from-community-promoted' => 'Get Promoted',
	'wikiahubs-from-community-caption' => 'From [$1 $2] on [$3 $4]',
	
	// pulse
	'wikiahubs-pulse' => 'The Pulse on [$1 $2]',
	'wikiahubs-pulse-whats-your-game' => 'What\'s your game?',

	//featured video
	'wikiahubs-sponsored-by' => 'Sponsored by $1',
);

$messages['de'] = array(
	'wikiahubs-button-cancel' => 'Abbrechen',
	'wikiahubs-button-close' => 'Schließen',

	'wikiahubs-suggest-video-header' => 'Schlag ein Video vor',
	'wikiahubs-suggest-video-submit-button' => 'Video vorschlagen',
	'wikiahubs-suggest-video-what-video' => 'Welches Video möchtest du teilen?',
	'wikiahubs-suggest-video-what-video-default-value' => 'Von YouTube, aus deinem Lieblingswiki, etc.',
	'wikiahubs-suggest-video-which-wiki' => 'Aus welchem Wiki stammt dieses Video?',
	'wikiahubs-suggest-video-which-wiki-default-value' => 'StarWars, Harry Potter, ...',
	'wikiahubs-suggest-video-success' => 'Danke für deinen Vorschlag! Wir schauen ihn uns schnellstmöglich an. Schau bald wieder vorbei!',
	'wikiahubs-error-invalid-video-url-length' => 'Die Video-URL muss mindestens 10 Zeichen lang sein.',
	'wikiahubs-error-invalid-wikiname-length' => 'Der Wiki-Name muss mindestens 1 Zeichen lang sein.',

	'wikiahubs-suggest-article-header' => 'Artikel vorschlagen',
	'wikiahubs-suggest-article-submit-button' => 'Abschicken',
	'wikiahubs-suggest-article-what-article' => 'Was möchtest du teilen?',
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
	'wikiahubs-popular-videos-suggested-by' => 'A link under video thumbnail on hubs page. The only parameter is username.',
	'wikiahubs-popular-videos-suggested-by-profile' => "A link under video thumbnail on hubs page. The first parameter is username and second one is a full page address to user's profile page.",
	'wikiahubs-sponsored-by' => 'Just a text next to the sponsor image (logo). First parameter is <img /> tag with the image path',
);
