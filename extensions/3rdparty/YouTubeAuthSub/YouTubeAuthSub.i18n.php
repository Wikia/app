<?php
/**
 * Internationalisation file for YouTubeAuthSub extension.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Travis Derouin
 */
$messages['en'] = array(
	'youtubeauthsub'                     => 'Upload YouTube Video',
	'youtubeauthsub-desc'                => 'Allows users to [[Special:YouTubeAuthSub|upload videos]] directly to YouTube',
	'youtubeauthsub_info'                => "To upload a video to YouTube to include on a page, fill out the following information:",
	'youtubeauthsub_title'               => 'Title',
	'youtubeauthsub_description'         => 'Description',
	'youtubeauthsub_password'            => "YouTube Passsword",
	'youtubeauthsub_username'            => "YouTube Username",
	'youtubeauthsub_keywords'            => 'Keywords',
	'youtubeauthsub_category'            => 'Category',
	'youtubeauthsub_submit'              => 'Submit',
	'youtubeauthsub_clickhere'           => 'Click here to log in to YouTube',
	'youtubeauthsub_tokenerror'          => 'Error generating authorization token, try refreshing.',
	'youtubeauthsub_success'             => "Congratulations!
Your video is uploaded.
To view your video click <a href='http://www.youtube.com/watch?v=$1'>here</a>.
YouTube may require some time to process your video, so it might not be ready just yet.

To include your video in a page on the wiki, insert the following code into a page:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "To upload a video, you will be required to first log in to YouTube.",
	'youtubeauthsub_uploadhere'          => "Upload your video from here:",
	'youtubeauthsub_uploadbutton'        => 'Upload',
	'youtubeauthsub_code'                => '{{#ev:youtube|$1}}.

This video can be viewed [http://www.youtube.com/watch?v=$1 here]',
	'youtubeauthsub_summary'             => 'Uploading YouTube video',
	'youtubeauthsub_uploading'           => 'Your video is being uploaded.
Please be patient.',
	'youtubeauthsub_viewpage'            => 'Alternatively, you can view your video [[$1|here]].',
	'youtubeauthsub_jserror_nokeywords'  => 'Please enter 1 or more keywords.',
	'youtubeauthsub_jserror_notitle'     => 'Please enter a title for the video.',
	'youtubeauthsub_jserror_nodesc'      => 'Please enter a description for the video.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'youtubeauthsub'                     => 'YouTube-video uploaden',
	'youtubeauthsub-desc'                => "Laat gebruikers direct [[Special:YouTubeAuthSub|video's uploaden]] naar YouTube",
	'youtubeauthsub_info'                => 'Geef de volgende informatie op om een video naar YouTube te uploaden om die later aan een pagina te kunnen toevoegen:',
	'youtubeauthsub_title'               => 'Naam',
	'youtubeauthsub_description'         => 'Beschrijving',
	'youtubeauthsub_password'            => 'Wachtwoord YouTube',
	'youtubeauthsub_username'            => 'Gebruiker YouTube',
	'youtubeauthsub_keywords'            => 'Trefwoorden',
	'youtubeauthsub_category'            => 'Categorie',
	'youtubeauthsub_submit'              => 'Uploaden',
	'youtubeauthsub_clickhere'           => 'Klik hier om aan te melden bij YouTube',
	'youtubeauthsub_tokenerror'          => 'Fout bij het maken van het autorisatietoken. Vernieuw de pagina.',
	'youtubeauthsub_success'             => "Gefeliciteerd!
Uw video is geüpload.
Klik <a href='http://www.youtube.com/watch?v=$1'>hier</a> om uw video te bekijken.
Het komt voor dat YouTube enige tijd nodig heeft om uw video te verwerken, dus wellicht is die nog niet beschikbaar.

Voeg de volgende code toe om uw video in een pagina op te nemen:
<code>{{&#35;ev:youtube|$1}}</code>",
	'youtubeauthsub_authsubinstructions' => "Meld u eerst aan bij YouTube voordat u video's gaat uploaden.",
	'youtubeauthsub_uploadhere'          => 'Uw video van hier uploaden:',
	'youtubeauthsub_uploadbutton'        => 'Uploaden',
	'youtubeauthsub_code'                => '{{#ev:youtube|$1}}.

U kunt deze video [http://www.youtube.com/watch?v=$1 hier] bekijken',
	'youtubeauthsub_summary'             => 'Bezig met uploaden van de YouTube video',
	'youtubeauthsub_uploading'           => 'Uw video wordt geüpload.
Even geduld alstublieft.',
	'youtubeauthsub_viewpage'            => 'U kunt uw video ook [[$1|hier]] bekijken.',
	'youtubeauthsub_jserror_nokeywords'  => 'Geef alstublieft een of meer trefwoorden op.',
	'youtubeauthsub_jserror_notitle'     => 'Geef alstublieft een naam voor de video op.',
	'youtubeauthsub_jserror_nodesc'      => 'Geef alstublieft een beschrijving voor de video op.',
);

