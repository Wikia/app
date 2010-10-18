<?php

$messages = array();
$messages['en'] = array(
	'soapfailures' => 'SOAP Page Failures',
	
	'soapfailures-stats-timeperiod' => 'Time period',
	'soapfailures-stats-numfound' => 'Num found',
	'soapfailures-stats-numnotfound' => 'Not found',
	'soapfailures-stats-period-today' => 'Today',
	'soapfailures-stats-period-thisweek' => 'This week',
	'soapfailures-stats-period-thismonth' => 'This month',

	'soapfailures-mark-as-fixed' => 'Mark a song as fixed (does a test first):',
	'soapfailures-fixed' => 'Fixed',
	'soapfailures-artist' => 'Artist:',
	'soapfailures-song' => 'Song:',
	'soapfailures-intro' => "<em>Once you have created a missing page, made a redirect for it, or otherwise fixed it so that it should 
			no longer be a failed request... type the artist and song name into the form at the top of the page and click the \"Fixed\" button and the SOAP webservice will test the song again. 
			If the song is then retrieved successfully, it will be removed from the failures list and the cache will be cleared 
			so that you can see the updated list right away.</em><br/>
			<br/>
			Discuss the [[LyricWiki_talk:SOAP|SOAP webservice]].\n
			<br/><br/>\n"
);

?>
