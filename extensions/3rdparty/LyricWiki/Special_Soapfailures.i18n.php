<?php

$messages = array();
$messages['en'] = array(
	'soapfailures' => 'SOAP Page Failures',

	'soapfailures-stats-header' => 'Please note that since successful responses get cached by Varnish, these numbers will show a high skew towards "not-found".',
	'soapfailures-stats-timeperiod' => 'Time period',
	'soapfailures-stats-numfound' => 'Num found',
	'soapfailures-stats-numnotfound' => 'Not found',
	'soapfailures-stats-period-today' => 'Today',
	'soapfailures-stats-period-thisweek' => 'This week',
	'soapfailures-stats-period-thismonth' => 'This month',

	'soapfailures-header-requests' => 'Requests',
	'soapfailures-header-artist' => 'Artist',
	'soapfailures-header-song' => 'Song',
	'soapfailures-header-looked-for' => 'Titles looked for',
	'soapfailures-header-fixed' => 'Fixed',

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

$messages['de'] = array(
	'soapfailures' => 'SOAP Fehlgeschlagene Anfragen',

	'soapfailures-stats-timeperiod' => 'Zeitraum',
	'soapfailures-stats-numfound' => 'Gefunden',
	'soapfailures-stats-numnotfound' => 'Nicht gefunden',
	'soapfailures-stats-period-today' => 'Heute',
	'soapfailures-stats-period-thisweek' => 'Diese Woche',
	'soapfailures-stats-period-thismonth' => 'Diesen Monat',

	'soapfailures-header-requests' => 'Anfragen',
	'soapfailures-header-artist' => 'Künstler',
	'soapfailures-header-song' => 'Titel',
	'soapfailures-header-looked-for' => 'Gesucht nach',
	'soapfailures-header-fixed' => 'Behoben',

	'soapfailures-mark-as-fixed' => 'Markiere einen Song als behoben (führt vorher einen Test durch):',
	'soapfailures-fixed' => 'Behoben',
	'soapfailures-artist' => 'Künstler:',
	'soapfailures-song' => 'Titel:',
	'soapfailures-intro' => "<em>Sobald du eine fehlende Seite erstellt hast, eine Weiterleitung für sie eingerichtet hast, oder das Problem anderweitig behoben hast, sodass sie
	nicht länger eine unerfüllte Anfrage sein dürfte... trage den Künstler und den Titel oben in das Formular ein und klicke auf die \"Behoben\"-Schaltfläche, und der SOAP Webservice wird den Song erneut testen.
	Wird der Song dann erfolgreich ermittelt, wird er von der Liste entfernt und der Cache geleert,
	sodass du die erneuerte Liste sofort sehen kannst.</em><br/>
	<br/>
	Diskutiere den [[LyricWiki talk:SOAP|SOAP Webservice]].\n
	<br/><br/>\n"
);