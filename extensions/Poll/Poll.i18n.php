<?php
/**
 * Internationalisation file for Poll extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();
 
/** English
 * @author Jan Luca
 */
$messages['en'] = array(
	'poll' => 'List of the Polls',
	'poll-desc' => 'Add a [[Special:Poll|special page]] for using polls',
	'poll-title-create' => 'Create a new poll',
	'poll-title-vote' => 'Voting page',
	'poll-title-score' => 'Score',
	'poll-create-right-error' => 'You are not allowed to create a new poll(needed right: poll-create)',
	'poll-vote-right-error' => 'You are not allowed to vote(needed right: poll-vote)',
	'poll-alternative' => 'Alternative',
	'poll-question' => 'Question',
	'poll-submit' => 'Submit',
	'right-poll-create' => 'Create Poll',
	'right-poll-vote' => 'Vote by a Poll',
	'right-poll-admin' => 'Manage the Polls',
	'poll-create-fields-error' => 'The fields Question, Alternative 1 and Alternative 2 must be set',
	'poll-dis' => 'Description',
	'poll-list-current' => '== Current Polls ==',
	'poll-create-pass' => 'Poll created!',
	'poll-vote-pass' => 'Voted!',
	'poll-vote-already-error' => 'You has already voted!',
	'poll-create-link' => 'Create a new Poll',
	'poll-back' => 'Back to Overview!',
	'poll-change' => 'Change Poll',
	'poll-delete' => 'Delete Poll',
	'poll-title-change' => 'Change Poll',
	'poll-title-delete' => 'Delete Poll',
	'poll-change-right-error' => 'You must be the creater of the Poll or have the "poll-admin" right to change this Poll',
	'poll-change-pass' => 'Changed!',
	'poll-number-poll' => 'Number of Votes',
	'poll-title-delete' => 'Delete Poll',
	'poll-delete-question' => 'Do you really want to delete the Poll "$1"?',
	'poll-delete-right-error' => 'You must be the creater of the Poll or have the "poll-admin" right to delete this Poll',
	'poll-delete-pass' => 'Deleted!',
	'poll-delete-cancel' => 'Poll wasn\'t deleted (checkbox not set)',
	'poll-invalid-id' => 'Invalid poll id',
	'poll-logpage' => 'Poll log',
	'poll-logpagetext' => 'This is a log of changes to polls.',
	'poll-log-create' => '$1 created poll "$2"',
	'poll-log-change' => '$1 changed poll "$2"',
	'poll-log-delete' => '$1 deleted poll "$2"',
	'poll-logentry' => 'Polls changed',
	'poll-score-created' => 'created from [[User:$1]]',
	'poll-administration' => 'Administration:',
	'poll-no-dis' => 'No Description!',
	'poll-create-allow-more' => 'Allow Multi-Vote',
	'poll-vote-changed' => 'Vote has been changed!',
	'poll-vote-other' => 'Other answers: '
);

/** German (Deutsch)
 * @author Jan Luca
 */
$messages['de'] = array(
	'poll' => 'Liste der Umfragen',
	'poll-desc' => 'Erstellt eine [[Special:Poll|Spezialsite]], um Umfragen zu nutzen',
	'poll-title-create' => 'Eine neue Umfrage erstellen',
	'poll-title-vote' => 'Abstimmen',
	'poll-title-score' => 'Auswertung',
	'poll-create-right-error' => 'Leider darfst du keine neue Umfrage erstellen(benötige Gruppenberechttigung: poll-create)',
	'poll-vote-right-error' => 'Leider darfst du nicht abstimmen(benötige Gruppenberechttigung: poll-vote)',
	'poll-alternative' => 'Antwortmöglichkeit',
	'poll-question' => 'Frage',
	'poll-submit' => 'Absenden',
	'right-poll-create' => 'Umfrage erstellen',
	'right-poll-vote' => 'Bei einer Umfrage abstimmen',
	'right-poll-admin' => 'Umfragen verwalten',
	'poll-create-fields-error' => 'Die Felder Frage, Antwortmöglichkeit 1 sowie Antwortmöglichkeit 2 müssen ausgefüllt sein',
	'poll-dis' => 'Beschreibung',
	'poll-list-current' => '== Aktuelle Umfragen ==',
	'poll-create-pass' => 'Umfrage erfolgreich erstellt!',
	'poll-vote-pass' => 'Erfolgreich abgestimmt!',
	'poll-vote-already-error' => 'Du hast bereits abgestimmt!',
	'poll-create-link' => 'Eine neue Umfrage erstellen',
	'poll-back' => 'Zurück zur Übersicht!',
	'poll-change' => 'Umfrage ändern',
	'poll-delete' => 'Umfrage löschen',
	'poll-title-change' => 'Umfrage ändern',
	'poll-title-delete' => 'Umfrage löschen',
	'poll-change-right-error' => 'Du musst der Autor dieser Umfrage sein oder die "poll-admin"-Gruppenberechtigung haben, um diese Umfrage zu ändern',
	'poll-change-pass' => 'Umfrage erfolgreich geändert!',
	'poll-number-poll' => 'Anzahl der abgegebenen Stimmen',
	'poll-title-delete' => 'Umfrage löschen',
	'poll-delete-question' => 'Möchtest du wirklich die Umfrage "$1" löschen?',
	'poll-delete-right-error' => 'Du musst der Autor dieser Umfrage sein oder die "poll-admin"-Gruppenberechtigung haben, um diese Umfrage zu löschen',
	'poll-delete-pass' => 'Umfrage erfolgreich gelöscht',
	'poll-delete-cancel' => 'Umfrage wurde nicht gelöscht(Häckchen nicht gesetzt)!',
	'poll-logpage' => 'Umfrage-Logbuch',
	'poll-logpagetext' => 'Dieses Logbuch zeigt Änderungen an den Umfragen.',
	'poll-log-create' => '$1 hat "$2" erstellt!',
	'poll-log-change' => '$1 hat "$2" geändert!',
	'poll-log-delete' => '$1 hat "$2" gelöscht!',
	'poll-logentry' => 'Änderung an den Umfragen wurde vorgenommen',
	'poll-score-created' => 'erstellt von [[Benutzer:$1]]',
	'poll-administration' => 'Administration:',
	'poll-no-dis' => 'Keine Beschreibung vorhanden!',
	'poll-create-allow-more' => 'Mehfachabstimmung erlaubt',
	'poll-vote-changed' => 'Stimme wurde geändert!',
	'poll-vote-other' => 'Andere Antworten: '
);
