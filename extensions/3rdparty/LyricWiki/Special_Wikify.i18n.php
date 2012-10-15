<?php
/**
 * Internationalisation file for Special:Wikify extension.
 *
 * @addtogroup Extensions
 */

$messages = array();
$messages['en'] = array(
	'wikify' => "Wikify Album",
	'wft-artist' => "Artist",
	'wft-album' => "Album Name",
	'wft-year' => "Album Year",
	'wft-discog' => "Raw Discography",
	'wft-showcover' => "Show album cover",

	'wft-wikify' => "Wikify",
	'wft-wikify-key' => "W",

	'wft-wikipedia_quoted-desc' => "Wikipedia (surrounded by quotes)",
	'wft-allmusic-desc' => "Allmusic.com format",
	'wft-plain_list-desc'=> "List (one song per line... no numbers or other extra text)",
	'wft-numbered_list-desc' => "Numbered List",
	'wft-musicbrainz-desc' => "MusicBrainz",
	'wft-discogs-desc' => "Discogs",

	'wft-album-header' => "==[[\$1:\$2 (\$4)|\$3 (\$4)]]==\n{{Album Art|\$1 - \$2.jpg|\$3}}",
	'wft-album-header-nocover' => "==[[\$1:\$2 (\$4)|\$3 (\$4)]]==",
	'wft-track'  => "# '''[[\$1:\$2|\$3]]'''",
	'wft-album-footer' => "{{clear}}",

	'wft-footer' =>
		"This tool was inspired by [[User:Lentando|Lentando]]'s wikify script which we now also host the ".
		"[http://lyricwiki.org/wikify_Lentando.php original version] of as well as an [http://lyricwiki.org/wikify.php upgraded version] (the best fallback if this page is broken).<br/>".
		"This tool is currently maintained by [[User:Sean Colombo|Sean Colombo]] and [[User:Teknomunk|teknomunk]].  ".
		"Please leave bug reports / feature requests on [[User_talk:Sean Colombo|Sean's]] or [[User_talk:Teknomunk|teknomunk's]] ".
		"talk page.",
			

	'wft-error-toofewtracks' => "WARNING: The wikifier found \$1 tracks, but the largest track number was \$2",
	'wft-error-unknownmethod' => "Unknown formatting method: \$1",
	'wft-error-nomatch' => "No match found",
	'wft-error-noformats' => "There are currently no available formats available. Please contact the site administrator to enable this functionality"
);
