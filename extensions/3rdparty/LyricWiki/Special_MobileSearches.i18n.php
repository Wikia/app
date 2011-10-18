<?php

$messages = array();
$messages['en'] = array(
	'mobilesearches' => 'Mobile Searches',

	'mobilesearches-stats-header' => 'Please note that since successful responses get cached by Varnish, these numbers will show a high skew towards "not-found".',
	'mobilesearches-stats-timeperiod' => 'Time period',
	'mobilesearches-stats-numfound' => 'Num found',
	'mobilesearches-stats-numnotfound' => 'Not found',
	'mobilesearches-stats-period-today' => 'Today',
	'mobilesearches-stats-period-thisweek' => 'This week',
	'mobilesearches-stats-period-thismonth' => 'This month',
	
	'mobilesearches-header-requests' => 'Requests',
	'mobilesearches-header-artist' => 'Artist',
	'mobilesearches-header-song' => 'Song',
	'mobilesearches-header-looked-for' => 'Titles looked for',
	'mobilesearches-header-fixed' => 'Fixed',

	'mobilesearches-mark-as-fixed' => 'Mark a song as fixed (does a test first):',
	'mobilesearches-fixed' => 'Fixed',
	'mobilesearches-artist' => 'Artist:',
	'mobilesearches-song' => 'Song:',
	'mobilesearches-intro' => "<em>Once you have created a missing page, made a redirect for it, or otherwise fixed it so that it should 
			no longer be a failed request... type the artist and song name into the form at the top of the page and click the \"Fixed\" button and the SOAP webservice will test the song again. 
			If the song is then retrieved successfully, it will be removed from the failures list and the cache will be cleared 
			so that you can see the updated list right away.</em><br/>
			<br/>
			This page differs from [[Special:Soapfailures]] primarily in that it only shows the requests that came from the <a href='https://market.android.com/details?id=com.wikia.lyricwiki'>LyricWiki Android app</a> and the LyricWiki iPhone app (once there is one).<br/>
			<br/>
			Discuss the [[LyricWiki_talk:SOAP|SOAP webservice]].\n
			<br/><br/>\n"
);
