<?php
/**
 * Internationalization file for the Video extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author David Pean <david.pean@gmail.com>
 */
$messages['en'] = array(
	// Special page titles, as seen on Special:SpecialPages
	'addvideo' => 'Add Video',
	'newvideos' => 'New Videos',

	// Various Special:AddVideo UI messages
	'video-addvideo-title' => 'Add Video',
	'video-addvideo-dest' => 'Add Video for $1',
	'video-addvideo-button' => 'Add Video',
	'video-provider-list' => '*[http://www.youtube.com/ YouTube]
*[http://vids.myspace.com/ MySpaceTV]
*[http://video.google.com/ Google Video]
*[http://www.metacafe.com/ Metacafe]
*[http://archive.org/ Archive.org]
*[http://blip.tv/ Blip.tv]
*[http://www.dailymotion.com/ Dailymotion]
*[http://www.gametrailers.com Gametrailers]
*[http://gamevideos.1up.com/ Gamevideos]
*[http://www.gogreentube.com/ GoGreenTube]
*[http://www.hulu.com/ Hulu]
*[http://www.myvideo.de/ MyVideo]
*[http://movieclips.com/ MovieClips]
*[http://www.sevenload.com/ Sevenload]
*[http://www.southparkstudios.com/ South Park Studios]
*[http://www.viddler.com/ Viddler]
*[http://www.vimeo.com/ Vimeo]
*[http://www.wegame.com/ WeGame]', // list of all available video providers; used in the msg below; do not translate!
	'video-addvideo-instructions' => "Adding a video to {{SITENAME}} is easy.
Just paste the video embed code ''or'' the video's URL into the following form, add a name for the video, and press the \"{{int:video-addvideo-button}}\" button.
If you want to embed the video on a page use the following format: '''<nowiki>[[Video:Video Title]]</nowiki>'''.
You can add a video from the following providers:
{{int:video-provider-list}}
===Example of a Video Embed Code===
This is an example video embed code from YouTube:

<pre style=\"background-color: #F9F9F9; border: 1px dashed #2F6FAB; color: black; line-height: 1.1em; padding: 1em;\">
<nowiki><object width=\"425\" height=\"355\">
<param name=\"movie\" value=\"http://www.youtube.com/v/hUcFWPgB8oY\"></param>
<param name=\"wmode\" value=\"transparent\"></param>
<embed src=\"http://www.youtube.com/v/hUcFWPgB8oY\" type=\"application/x-shockwave-flash\"
wmode=\"transparent\" width=\"425\" height=\"355\"></embed>
</object></nowiki>
</pre>

===Example of a Video URL===
Below is an example of a video's URL from YouTube:
<pre style=\"background-color: #F9F9F9; border: 1px dashed #2F6FAB; color: black; line-height: 1.1em; padding: 1em;\">http://www.youtube.com/watch?v=hUcFWPgB8oY</pre>",
	'video-addvideo-invalidcode' => 'The code or URL you pasted is invalid. Please try again.',
	'video-addvideo-exists' => 'The title for your video already exists. Please choose another title for the video.',
	'video-addvideo-title-label' => 'Video Title:',
	'video-addvideo-embed-label' => 'Embed Code or URL:',

	// Shown on Special:NewVideos when it's empty
	'video-no-videos' => 'No new videos.',

	// Log of added videos at Special:Log/video
	'video-log-page' => 'Video log',
	'video-log-page-text' => 'This is a log of added videos and updates to existing videos.',
	'video-log-entry' => '', # do not translate this into other languages!
	'video-log-added-entry' => 'added video [[$1]]',
	'video-log-updated-entry' => 'updated video [[$1]]',

	// Shown on category pages
	'category-video-header' => 'Videos in category "$1"',
	#'category-video-count'  => '{{PLURAL:$2|This category contains only the following video.|The following {{PLURAL:$1|video is|$1 videos are}} in this category, out of $2 total.}}',
	'category-video-count' => 'There {{PLURAL:$1|is one video|are $1 videos}} in this category.',

	'video-novideo-linktext' => 'add it',
	'video-novideo' => 'No video by this name exists, you can $1.', // $1 is novideo-linktext
	'video-embed' => 'Embed',
	'video-history' => 'Video History',
	'video-revert' => 'rev',
	'video-histlegend' => 'Legend: ({{int:cur}}) = this is the current video, ({{int:video-revert}}) = revert to this old version.
<br /><i>Click on date to see the video URL on that date</i>.',
	'video-revert-success' => 'Revert to earlier version was successful.',
	'video-revert-legend' => 'Revert Video',
	'video-revert-intro' => "You are about to revert the video '''[[:Video:$1|$1]]''' to the [$4 version as of $3, $2].",

	'video-category-name' => 'Videos', // name of the category where videos will be stored

	// Pages linking to the current video -- this feature does not work (yet), see
	// VideoPage::videoLinks() for details
	'video-links' => 'Video links',
	'video-links-to-video' => 'The following {{PLURAL:$1|page links|$1 pages link}} to this video:',
	'video-no-links-to-video' => 'There are no pages that link to this video.',
	'video-more-links-to-video' => 'View [[Special:WhatLinksHere/$1|more links]] to this video.',

	// For Special:ListGroupRights
	'right-addvideo' => 'Add videos from external services into the site',
);

/** Message Documentation
 * @author John Du Hart <john@compwhizii.net>
 */
$messages['qqq'] = array(
	'video-revert-legend' => 'Legend of the fieldset for the revert form',
	'video-revert-intro' => "Message displayed when you try to revert a version of a video.
* $1 is the name of the media
* $2 is a date
* $3 is a hour
* $4 is a URL and must follow square bracket: [$4
{{Identical|Revert}}",
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'addvideo' => 'Lisää video',
	'newvideos' => 'Uudet videot',
	'video-no-videos' => 'Ei uusia videoja.',
	'video-log-page' => 'Videoloki',
	'video-log-page-text' => 'Tämä on loki lisätyistä videoista ja päivityksistä olemassaoleviin videoihin.',
	'video-log-added-entry' => 'lisäsi videon [[$1]]',
	'video-log-updated-entry' => 'päivitti videon [[$1]]',
	'category-video-header' => 'Videot luokassa "$1"',
	'category-video-count' => 'Tässä luokassa on {{PLURAL:$1|yksi video|$1 videoa}}.',
	#'category-video-count' => '{{PLURAL:$2|Tässä luokassa on vain seuraava video.|{{PLURAL:$1|Seuraava video kuuluu|Seuraavat $1 videoa kuuluvat}} tähän luokkaan. Sivujen kokonaismäärä luokassa on $2.}}',
	'video-novideo' => 'Tämännimistä videoa ei ole olemassa, voit $1.',
	'video-novideo-linktext' => 'lisätä sen',
	'video-embed' => 'Upota',
	'video-addvideo-title' => 'Lisää video',
	'video-addvideo-dest' => 'Lisää uusi versio videosta $1', // "Add a new version of video $1"
	'video-addvideo-button' => 'Lisää video',
	'video-addvideo-instructions' => "Videon lisääminen {{GRAMMAR:illative|{{SITENAME}}}} on helppoa.
Liitä vain videon upotuskoodi ''tai'' videon URL seuraavaan lomakkeeseen, lisää nimi videolle ja paina \"{{int:video-addvideo-button}}\" -painiketta.
Jos haluat upottaa videon sivulle, käytä seuraavaa muotoa: '''<nowiki>[[Video:Videon otsikko]]</nowiki>'''.
Voit lisätä videoita seuraavista palveluista:
{{int:video-provider-list}}
===Esimerkki videon upotuskoodista===
Tämä on esimerkki videon upotuskoodista YouTubesta:

<pre style=\"background-color: #F9F9F9; border: 1px dashed #2F6FAB; color: black; line-height: 1.1em; padding: 1em;\">
<nowiki><object width=\"425\" height=\"355\">
<param name=\"movie\" value=\"http://www.youtube.com/v/hUcFWPgB8oY\"></param>
<param name=\"wmode\" value=\"transparent\"></param>
<embed src=\"http://www.youtube.com/v/hUcFWPgB8oY\" type=\"application/x-shockwave-flash\"
wmode=\"transparent\" width=\"425\" height=\"355\"></embed>
</object></nowiki>
</pre>

===Esimerkki videon URL:ista===
Alapuolella on esimerkki YouTube-videon URL:ista:
<pre style=\"background-color: #F9F9F9; border: 1px dashed #2F6FAB; color: black; line-height: 1.1em; padding: 1em;\">http://www.youtube.com/watch?v=hUcFWPgB8oY</pre>",
	'video-addvideo-invalidcode' => 'Liittämäsi koodi tai URL on kelvoton. Ole hyvä ja kokeile uudestaan.',
	'video-addvideo-exists' => 'Videosi otsikko on jo olemassa. Ole hyvä ja valitse toinen otsikko videollesi.',
	'video-addvideo-title-label' => 'Videon otsikko:',
	'video-addvideo-embed-label' => 'Upotuskoodi tai URL:',
	'video-history' => 'Videon historia',
	'video-revert' => 'pal',
	'video-histlegend' => 'Merkinnät: ({{int:cur}}) = tämä on nykyinen video, ({{int:video-revert}}) = palauta tähän vanhaan versioon.
<br /><i>Napsauta päivämäärää nähdäksesi videon URL kyseisenä päivänä</i>.',
	'video-revert-success' => 'Palauttaminen aiempaan versioon onnistui.',
	'video-category-name' => 'Videot',
	'video-links' => 'Linkit videoon',
	'video-links-to-video' => '{{PLURAL:$1|Seuraava sivu linkittää|Seuraavat $1 sivua linkittävät}} tähän videoon:',
	'video-no-links-to-video' => 'Mikään sivu ei linkitä tähän videoon.',
	'video-more-links-to-video' => 'Katso [[Special:WhatLinksHere/$1|lisää linkkejä]] tähän videoon.',
	'right-addvideo' => 'Lisätä videoita ulkoisista palveluista sivustolle',
);