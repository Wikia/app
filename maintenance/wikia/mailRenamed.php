<?php

require_once( "../commandLine.inc" );

$sSubject = 'WebsiteWiki: Benutzerkonto-Umbennung';
$sFrom = 'avatar@wikia-inc.com';
$sBody = 'Hallo,

wie du vielleicht schon mitbekommen hast, ist das WebsiteWiki zu Wikia
(http://de.wikia.com) umgezogen.

Wir versprechen uns davon eine Reihe von Vorteilen, die sich auch in
Zukunft positiv auf das WebsiteWiki auswirken werden.

Wikia betreibt mehr als 50.000 Wikis zu den verschiedensten Themen -
als Anmeldung reicht dein Login im WebsiteWiki. Das kann aber nur
funktionieren, wenn alle Nutzernamen an einer gemeinsamen Stelle
gespeichert sind.

Stößt jetzt ein neues Wiki wie das WebsiteWiki zu Wikia, so kann es
passieren, dass bereits Wikia-Benutzer existieren, deren Benutzerkonto
den selben Namen aufweisen. Passiert dies, so wird der entsprechende
WebsiteWiki-Benutzer erst einmal automatisch umbenannt. Dazu wird dem
Benutzenamen der Prefix "WSW-" vorangestellt.
Das bedeutet, dass der WebsiteWiki-Benutzer "Karl" sich erst einmal
unter dem Namen "WSW-Karl" anmelden muss.

Die meisten Konflikte treffen Benutzer, die nicht (mehr) aktiv sind.
Aber manchmal kommt es auch bei aktiven Benutzer zu Überschneidungen -
das ist bei dir leider der Fall.

Jetzt gibt es mehrere Möglichkeiten:
1) Du bist mit der Umbenennung einverstanden. Dann musst du gar nichts machen.
2) Du möchtest deinen alten Benutzernamen wiederhaben. Das ist kein
Problem, wenn der Wikia-Benutzer mit dem gleichen Namen nicht mehr
aktiv ist. Im seltenen Fall wo beide Nutzer aktiv sind, hängt es vom
Einzelfall ab, wie das weitere Vorgehen aussieht.
3) Du möchtest einen ganz anderen Benutzernamen haben.

In den Fällen 2 und 3, hinterlasse bitte eine kurze Nachricht mit
deinem Wunsch auf meine Benutzerseite
(http://websitewiki.wikia.com/wiki/Benutzer_Diskussion:Avatar) oder
schicke eine private Nachricht via
http://websitewiki.wikia.com/Spezial:Contact an Wikia. Vergiss bitte
nicht, deinen bisherigen und deinen gewünschten Namen (und ggf. eine
Alternative) anzugeben.

Wir werden in den nächsten 14 Tagen in zwei Schüben die Umbenennungen
durchführen.

Weiterhin viel Spaß im WebsiteWiki,
Tim \'Avatar\' Bartel';

$dbr = wfGetDB( DB_SLAVE, array(), 'wikicities' );

$res = $dbr->select( 'user', array( 'user_id', 'user_name' ), array( 'user_name LIKE "WSW-%"' ) );

while ( $row = $dbr->fetchObject( $res ) ) {
	echo "ID: " . $row->user_id . " NAME: " . $row->user_name . "\n";

	$user = User::newFromId( $row->user_id );

	$user->sendMail(
		$sSubject,
		$sBody,
		$sFrom,
		null,
		'importRename'
	);
}
