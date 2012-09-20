<?php
/**********************************************************************************
Copyright (C) 2007-08 Sean Colombo (sean@lyricwiki.org)
Copyright (C) 2007-08 Bradley Pesicka (teknomunk@bluebottle.com)

Tested on
# MediaWiki: 1.7.1, 1.11.1
# PHP: 5.0.5-2ubuntu1.5 (apache2handler)
# MySQL: 4.0.24_Debian-10ubuntu2.3-log

Developed for use by LryicWiki.org (http://www.lyricwiki.org/)

Please refer to Templates.php for full version description

**********************************************************************************/

$messages = array();
$messages['en'] = array(
	'lwtemp-artist-template' => <<<DOC
{{Wikipedia}}

<!-- Replace ALBUM_TITLE_#1 with the name of the album, etc. -->
==[[{{ARTIST}}:ALBUM_TITLE_#1 (YEAR)|ALBUM_TITLE_#1 (YEAR)]]==
# '''[[{{ARTIST}}:SONG_TITLE_#1|SONG_TITLE_#1]]'''
# '''[[{{ARTIST}}:SONG_TITLE_#2|SONG_TITLE_#2]]'''

==[[{{ARTIST}}:ALBUM_TITLE_#2 (YEAR)|ALBUM_TITLE_#2 (YEAR)]]==
# '''[[{{ARTIST}}:SONG_TITLE_#1|SONG_TITLE_#1]]'''
# '''[[{{ARTIST}}:SONG_TITLE_#2|SONG_TITLE_#2]]'''

{{Artist
| wikipedia    =
| artist       = {{ARTIST}}
| officialSite =
| fLetter      = {{ARTISTFLETTER}}
}}
{{Hometown
| country  =
| state    =
| hometown =
}}
DOC
,
	'lwtemp-album-template'=> <<<DOC
{{Album
|Artist   = {{ARTIST}}
|Album    = {{ALBUM}}
|fLetter  = {{ALBUMFLETTER}}
|Released = {{ALBUMYEAR}}
|Genre    =
|Length   =
|Cover    =
}}

# '''[[{{ARTIST}}:SONG_NAME_HERE|SONG_NAME_HERE]]'''
# '''[[{{ARTIST}}:SONG_NAME_HERE|SONG_NAME_HERE]]'''

{{AlbumFooter
|artist = {{ARTIST}}
|album  = {{ALBUM}}
}}
DOC
,
	'lwtemp-song-template'=> <<<DOC
{{Song||{{ARTIST}}}}

<lyrics>
<!-- Replace PUT LYRICS HERE (and delete this entire line) -->
</lyrics>

{{SongFooter
|artist   = {{ARTIST}}
|album    =
|song     = {{SONG}}
|fLetter  = {{SONGFLETTER}}
|video    =
|language =
|asin     =
|iTunes   =
}}
DOC
,
	'lwtemp-talk-template'=> <<<DOC
{{Star Box}}
{{Song/Album/Artist Rank|Green}}
<!-- Watcher -->
<!-- Cert -->
|}
__TOC__
<!--
The text above sets up Page Ranking info.
If you were just trying to comment on the page, please do so below.
-->
DOC
,
	'lwtemp-extra-templates'=>""
);

