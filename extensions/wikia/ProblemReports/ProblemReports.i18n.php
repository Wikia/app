<?php

/**
 * Internationalization for ProblemReports extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

$messages = array();

$messages['en'] = array(
	'problemreports' => 'Problem reports list',
	'reportproblem' => 'Report a problem',
		
	'prlogtext' => 'Problem reports',
	'prlogheader' => 'List of reported problems and changes of their status',
	'prlog_reportedentry' => 'reported a problem on $1 ($2)',
	'prlog_changedentry' => 'marked problem $1 as "$2"',
	'prlog_typeentry'    => 'changed problem $1 type to "$2"',
	'prlog_removedentry' => 'removed problem $1',
	'prlog_emailedentry' => 'sent email message to $2 ($3)',

	'pr_introductory_text' => 'Most pages on this wiki are editable, and you are welcome to edit the page and correct mistakes yourself! If you need help doing that, see [[help:editing|how to edit]] and [[help:revert|how to revert vandalism]].

To contact staff or to report copyright problems, please see [[w:contact us|Wikia\'s "contact us" page]].

Software bugs can be reported on the forums. Reports made here will be [[Special:ProblemReports|displayed on the wiki]].',

	'pr_what_problem' => 'Subject',
	'pr_what_problem_spam' => 'there is a spam link here',
	'pr_what_problem_vandalised' => 'this page has been vandalised',
	'pr_what_problem_incorrect_content' => 'this content is incorrect',
	'pr_what_problem_software_bug' => 'there is a bug in the wiki software',
	'pr_what_problem_other' => 'other',

	'pr_what_problem_select' => 'Please select problem type',
	'pr_what_problem_unselect' => 'all',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandal',
	'pr_what_problem_incorrect_content_short' => 'content',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'other',
		
	'pr_what_problem_change' => 'Change problem type',

	'pr_describe_problem' => 'Message',
	'pr_what_page' => 'Title of the page',
	'pr_email_visible_only_to_staff' => 'visible only to staff',
	'pr_thank_you' => "Thank you for reporting a problem!\n\n[[Special:ProblemReports/$1|You can watch progress of fixing it]].",
	'pr_thank_you_error' => 'Error occured when sending problem report, please try later...',
	'pr_spam_found' => 'Spam has been found in your report summary. Please change summary content',
	'pr_empty_summary' => 'Please provide short problem description',
	'pr_empty_email' => 'Please provide your email address',
		
	'pr_mailer_notice'  => 'The email address you entered in your user preferences will apper as the "From" address of the mail, so the recipient will be able to reply.',
	'pr_mailer_subject' => 'Reported problem on',
	'pr_mailer_tmp_info' => 'You can edit templated responses [[MediaWiki:ProblemReportsResponses|here]]',
	'pr_mailer_to_default' => 'Wikia User',
	'pr_mailer_go_to_wiki' => 'To send email please go to [$1 wiki problem was reported from]',

	'pr_total_number'       => 'Total number of reports',
	'pr_view_archive'       => 'View archived problems',
	'pr_view_all'           => 'Show all reports',
	'pr_view_staff'         => 'Show reports that needs staff help',
	'pr_raports_from_this_wikia' => 'View reports from this Wikia only',
	'pr_reports_from'       => 'Reports only from',
	'pr_no_reports' => 'No reports matching your criteria',

	'pr_sysops_notice' => 'If you want to change status of problem reports from your wiki, please go <a href="$1">here</a>...',

	'pr_table_problem_id'   => 'Problem ID',
	'pr_table_wiki_name'    => 'Wiki name',
	'pr_table_problem_type' => 'Problem type',
	'pr_table_page_link'    => 'Page',
	'pr_table_date_submitted' => 'Date submitted',
	'pr_table_reporter_name'=> 'Reporter name',
	'pr_table_description'  => 'Description',
	'pr_table_comments'     => 'Comments',
	'pr_table_status'       => 'Status',
	'pr_table_actions'      => 'Actions',

	'pr_status_0' => 'pending',
	'pr_status_1' => 'fixed',
	'pr_status_2' => 'closed',
	'pr_status_3' => 'need staff help',
	'pr_status_10' => 'remove report',

	'pr_status_undo' => 'Undo report status change',
	'pr_status_ask'  => 'Change report status?',
		
	'pr_remove_ask'  => 'Permanently remove report?',

	'pr_status_wait' => 'wait...',

	'pr_read_only' => 'New reports cannot be filled right now, please try again later.',

	'pr_msg_exceeded' => 'The maximum number of characters in the Message field is 512. Please rewrite your message.',
	'pr_msg_exchead' => 'Message is too long',

	'right-problemreports_action' => 'Change state and type of ProblemReports',
	'right-problemreports_global' => 'Change state and type of ProblemReports across wikis',
);

$messages['pl'] = array(
	'problemreports' => 'Lista zgłoszonych problemów',
	'reportproblem' => 'Zgłoś problem',
		
	'prlogtext' => 'Zgłoszone problemy',
	'prlogheader' => 'Lista zgłoszonych problemów i zmian w ich statusach',
	'prlog_reportedentry' => 'zgłoszono problem z $1 ($2)',
	'prlog_changedentry' => 'oznaczono problem $1 jako "$2"',
	'prlog_typeentry'    => 'zmieniono rodzaj problemu $1 na "$2"',
	'prlog_removedentry' => 'usunięto problem $1',
	'prlog_emailedentry' => 'wysłał wiadomość email do $2 ($3)',

	'pr_introductory_text' => 'Większość stron na tej wiki jest edytowalna i zachęcamy Ciebie do ich edycji oraz korygowania błędów w ich treści! Jeśli potrzebujesz pomocy, zobacz poradnik [[help:editing|jak edytować strony]] i [[help:revert|jak usuwać wandalizmy]].

Aby skontaktować się z zarządcami wiki lub zgłosić problem związany z prawami autorskimi, zajrzyj na stronę [[w:contact us|kontakt z Wikią]].

Błędy w oprogramowaniu mogą być zgłaszane na forach. Problemy zgłaszane tutaj będą [[Special:ProblemReports|widoczne na wiki]].',

	'pr_what_problem' => 'Temat',
	'pr_what_problem_spam' => 'na stronie znajduje się link spamera',
	'pr_what_problem_vandalised' => 'strona padła ofiarą wandala',
	'pr_what_problem_incorrect_content' => 'zawartość strony jest niepoprawna',
	'pr_what_problem_software_bug' => 'w oprogramowaniu znajduje się błąd',
	'pr_what_problem_other' => 'inny',

	'pr_what_problem_select' => 'Proszę wybrać rodzaj problemu',
	'pr_what_problem_unselect' => 'wszystkie',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'wandalizm',
	'pr_what_problem_incorrect_content_short' => 'zawartość',
	'pr_what_problem_software_bug_short' => 'błąd',
	'pr_what_problem_other_short' => 'inny',
		
	'pr_what_problem_change' => 'Zmień rodzaj problemu',

	'pr_describe_problem' => 'Wiadomość',
	'pr_what_page' => 'Tytuł strony',
	'pr_email_visible_only_to_staff' => 'dostępny tylko dla administracji Wikii',
	'pr_thank_you' => "Dziękujemy za zgłoszenie problemu!\n\n[[Special:ProblemReports/$1|Możesz obserować postępy w jego rozwiązywaniu]].",
	'pr_thank_you_error' => 'Wystąpił problem w czasie wysyłania raportu, spróbuj później...',
	'pr_spam_found' => 'Wykryto spam w treści komentarza. Prosimy skorygować jego treść',
	'pr_empty_summary' => 'Podaj krótki opis problemu',
	'pr_empty_email' => 'Podaj swój adres emailowy',
		
	'pr_mailer_notice' => 'Adres e-mailowy, który został przez Ciebie wprowadzony w Twoich preferencjach pojawi się w polu "Od", dzięki temu odbiorca będzie mógł Ci odpowiedzieć',
	'pr_mailer_subject' => 'Zgłoszono problem związany z',
	'pr_mailer_tmp_info' => 'Możesz edytować schematy odpowiedzi na [[MediaWiki:ProblemReportsResponses|tej stronie]]',
	'pr_mailer_to_default' => 'Użytkownik Wikii',

	'pr_total_number'       => 'Łączna liczba raportów',
	'pr_view_archive'       => 'Przejrzyj archiwalne raporty',
	'pr_view_all'           => 'Przeglądaj wszystkie raporty',
	'pr_view_staff'         => 'Przejrzyj raporty wymagające pomocy administracji Wikii',
	'pr_raports_from_this_wikia' => 'Przejrzyj raporty dotyczące tylko tej Wikii',
	'pr_reports_from'       => 'Raporty z',
	'pr_no_reports' => 'Brak raportów',
		
	'pr_sysops_notice' => 'Jeśli chcesz dokonać zmian w statusie raportów, proszę przejść <a href="$1">tutaj</a>...',

	'pr_table_problem_id'   => 'ID problemu',
	'pr_table_wiki_name'    => 'Nazwa Wikii',
	'pr_table_problem_type' => 'Rodzaj problemu',
	'pr_table_page_link'    => 'Strona',
	'pr_table_date_submitted' => 'Data zgłoszenia',
	'pr_table_reporter_name'=> 'Kto zgłosił',
	'pr_table_description'  => 'Opis',
	'pr_table_comments'  => 'Komentarze',
	'pr_table_status'       => 'Status',
	'pr_table_actions'      => 'Akcje',

	'pr_status_0' => 'oczekuje',
	'pr_status_1' => 'naprawione',
	'pr_status_2' => 'to nie jest problem',
	'pr_status_3' => 'konieczna pomoc',
	'pr_status_10' => 'usuń raport',

	'pr_status_undo' => 'Cofnij zmianę statusu raportu',
	'pr_status_ask'  => 'Zmienić status raportu?',
		
	'pr_remove_ask'  => 'Na pewno usunąć raport?',

	'pr_status_wait' => 'czekaj...',

	'pr_read_only' => 'Nowe zgłoszenia nie mogą zostać teraz dodane, prosimy spróbować później.',

                'pr_msg_exceeded' => 'Maksymalna liczba znaków w polu Wiadomości wynosi 512, prosimy o zmianę zawartości tego pola.',
                'pr_msg_exchead' => 'Wiadomość jest zbyt długa',
);

$messages['de'] = array(
	'problemreports' => 'Liste der Problemmeldungen',
	'reportproblem' => 'Problem melden',
	'prlogtext' => 'Problemmeldungs-Logbuch',
	'prlogheader' => 'Liste gemeldeter Probleme und des jeweiligen Status',
	'prlog_reportedentry' => 'meldete ein Problem mit $1 ($2)',
	'prlog_changedentry' => 'markierte Problem $1 als "$2"',
	'prlog_typeentry' => 'änderte Art des Problems $1 auf "$2"',
	'prlog_removedentry' => 'löschte Problem $1',
	'prlog_emailedentry' => 'sandte E-Mail an $2 ($3)',
	'pr_introductory_text' => 'Die meisten Seiten in diesem Wiki können bearbeitet werden und du bist ebenfalls herzlich eingeladen dies zu tun und Fehler zu korrigieren, falls dir welche auffallen. Auf der Seite [[w:c:de:Hilfe:Editieren|Hilfe:Editieren]] findest du weitere Hilfe.

Um Wikia direkt zu kontaktieren und Urheberrechtsprobleme zu melden, benutze bitte die Seite [[Special:Contact|Kontakt zu Wikia]].

Berichte, die über dieses Formular abgeschickt werden, sind für jeden [[Special:ProblemReports|im Wiki einsehbar]].',
	'pr_what_problem' => 'Betreff',
	'pr_what_problem_spam' => 'Seite enthält Spam',
	'pr_what_problem_vandalised' => 'Die Seite wurde vandaliert',
	'pr_what_problem_incorrect_content' => 'Der Inhalt ist falsch',
	'pr_what_problem_software_bug' => 'Fehler in der Wiki-Software',
	'pr_what_problem_other' => 'Sonstiges',
	'pr_what_problem_select' => 'Bitte wähle die Art des Problems',
	'pr_what_problem_unselect' => 'Alle',
	'pr_what_problem_spam_short' => 'Spam',
	'pr_what_problem_vandalised_short' => 'Vandalismus',
	'pr_what_problem_incorrect_content_short' => 'Inhalt',
	'pr_what_problem_software_bug_short' => 'Bug',
	'pr_what_problem_other_short' => 'Sonstiges',
	'pr_what_problem_change' => 'Art des Problems ändern',
	'pr_describe_problem' => 'Nachricht',
	'pr_what_page' => 'Name der Seite',
	'pr_email_visible_only_to_staff' => 'nur sichtbar für Staff',
	'pr_thank_you' => 'Danke für die Meldung des Problems! [[Special:ProblemReports/$1|Du kannst den aktuellen Status hier verfolgen]].',
	'pr_thank_you_error' => 'Ein Fehler ist beim Versand der Problemmeldung aufgetreten, bitte probier es später noch einmal.',
	'pr_spam_found' => 'In deiner Zusammenfassung wurde Spam gefunden. Bitte passe sie an.',
	'pr_empty_summary' => 'Bitte gib eine kurze Problembeschreibung an',
	'pr_empty_email' => 'Bitte gib deine E-Mail-Adresse an',
	'pr_mailer_notice' => 'Die von dir in deinen Einstellungen angegebene E-Mail-Adresse wird im "From"-Header der Mail angegeben, so dass der Empfänger dir antworten kann.',
	'pr_mailer_subject' => 'Problembericht über',
	'pr_mailer_tmp_info' => 'Du kannst die Antwortvorlagen [[MediaWiki:ProblemReportsResponses|hier]] anpassen.',
	'pr_mailer_to_default' => 'Wikia-Benutzer',
	'pr_mailer_go_to_wiki' => 'Um eine Mail zu schicken, gehe bitte zum [$1 Wiki, wo das Problem gemeldet wurde].',
	'pr_total_number' => 'Gesamtzahl Problemmeldungen',
	'pr_view_archive' => 'Zeige archivierte Meldungen',
	'pr_view_all' => 'Zeige alle Meldungen',
	'pr_view_staff' => 'Zeige Meldungen die Staff-Hilfe benötigen',
	'pr_raports_from_this_wikia' => 'Zeige nur Problemmeldungen dieses Wikis',
	'pr_reports_from' => 'Zeige nur Meldungen von',
	'pr_no_reports' => 'Keine passenden Problemmeldungen gefunden',
	'pr_sysops_notice' => 'Wenn du den Status von Problemmeldungen deines Wikis ändern möchtest, kannst du das <a href="$1">hier</a> tun...',
	'pr_table_problem_id' => 'Problem-ID',
	'pr_table_wiki_name' => 'Wiki-Name',
	'pr_table_problem_type' => 'Art des Problems',
	'pr_table_page_link' => 'Seite',
	'pr_table_date_submitted' => 'Gemeldet am',
	'pr_table_reporter_name' => 'Gemeldet von',
	'pr_table_description' => 'Beschreibung',
	'pr_table_comments' => 'Kommentare',
	'pr_table_actions' => 'Aktionen',
	'pr_status_0' => 'offen',
	'pr_status_1' => 'behoben',
	'pr_status_2' => 'geschlossen',
	'pr_status_3' => 'benötigt Hilfe von Staff',
	'pr_status_10' => 'Meldung entfernen',
	'pr_status_undo' => 'Änderung des Status rückgängig machen',
	'pr_status_ask' => 'Status der Meldung ändern?',
	'pr_remove_ask' => 'Meldung endgültig löschen?',
	'pr_status_wait' => 'Etwas Geduld...',
	'pr_msg_exceeded' => 'Das Maximum der Zeichen in diesem Nachrichtenfeld ist 512. Bitte schreibe deine Nachricht neu.',
	'pr_msg_exchead' => 'Die Nachricht ist zu lang',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 */
$messages['qqq'] = array(
	'pr_table_description' => '{{Identical|Description}}',
	'pr_table_actions' => '{{Identical|Action}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'reportproblem' => "Rapporteer 'n probleem",
	'prlog_reportedentry' => "'n probleem gerapporteer op $1 ($2)",
	'prlog_changedentry' => 'probleem $1 gemerk as "$2"',
	'prlog_typeentry' => 'tipe probleem $1 verander na "$2"',
	'prlog_removedentry' => 'het probleem $1 verwyder',
	'prlog_emailedentry' => 'e-pos gestuur na $2 ($3)',
	'pr_what_problem' => 'Onderwerp',
	'pr_what_problem_spam' => "daar is 'n spam-skakel in",
	'pr_what_problem_vandalised' => 'die bladsy is gevandaliseer',
	'pr_what_problem_incorrect_content' => 'die inhoud is verkeerd',
	'pr_what_problem_software_bug' => "daar is 'n fout in die wiki-sagteware",
	'pr_what_problem_other' => 'ander',
	'pr_what_problem_select' => "Kies asseblief 'n probleem-tipe",
	'pr_what_problem_unselect' => 'alle',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalisme',
	'pr_what_problem_incorrect_content_short' => 'inhoud',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'ander',
	'pr_describe_problem' => 'Boodskap',
	'pr_what_page' => 'Titel van die bladsy',
	'pr_email_visible_only_to_staff' => 'slegs vir personeel sigbaar',
	'pr_mailer_to_default' => 'Wikia-gebruiker',
	'pr_total_number' => 'Totale aantal verslae',
	'pr_view_archive' => 'Wys geargiveerde probleme',
	'pr_view_all' => 'Wys alle verslae',
	'pr_view_staff' => 'Wys verslae waar hulp vanaf personeel benodig word',
	'pr_raports_from_this_wikia' => 'Wys slegs hierdie Wikia se verslae',
	'pr_reports_from' => 'Slegs verslae van',
	'pr_table_problem_id' => 'Probleem-ID',
	'pr_table_wiki_name' => 'Wiki-naam',
	'pr_table_problem_type' => 'Probleem-tipe',
	'pr_table_page_link' => 'Bladsy',
	'pr_table_date_submitted' => 'Datum ingedien',
	'pr_table_reporter_name' => 'Gerapporteer deur',
	'pr_table_description' => 'Beskrywing',
	'pr_table_comments' => 'Kommentaar',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Aksies',
	'pr_status_0' => 'afwagtend',
	'pr_status_1' => 'Reggemaak',
	'pr_status_2' => 'gesluit',
	'pr_status_3' => 'benodig hulp van personeel',
	'pr_status_10' => 'verwyder verslag',
	'pr_status_wait' => 'wag...',
	'pr_msg_exchead' => 'Boodskap is te lank',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'pr_table_description' => 'Апісаньне',
	'pr_table_actions' => 'Дзеяньні',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'pr_what_problem' => 'Objed',
	'pr_what_problem_other' => 'all',
	'pr_what_problem_unselect' => 'pep tra',
	'pr_what_problem_spam_short' => 'strob',
	'pr_what_problem_incorrect_content_short' => 'danvez',
	'pr_what_problem_other_short' => 'all',
	'pr_describe_problem' => 'Kemennadenn',
	'pr_what_page' => 'Titl ar bajenn',
	'pr_mailer_to_default' => 'Implijer Wikia',
	'pr_table_problem_id' => 'ID ar gudenn',
	'pr_table_wiki_name' => 'Anv ar wiki',
	'pr_table_page_link' => 'Pajenn',
	'pr_table_comments' => 'Evezhiadennoù',
	'pr_table_status' => 'Statud',
	'pr_table_actions' => 'Oberoù',
	'pr_status_2' => 'serret',
	'pr_status_wait' => 'gortozit...',
);

$messages['es'] = array(
	'problemreports' => 'Lista de informes de problemas',
	'reportproblem' => 'Informar sobre un problema',
	'prlogtext' => 'Problemas notificados',
	'prlogheader' => 'Lista de informes sobre problemas y cambios de sus estados',
	'prlog_reportedentry' => 'reportado un problema en $1 ($2)',
	'prlog_changedentry' => 'marcado problema $1 como "$2"',
	'prlog_typeentry' => 'cambiado problema de tipo $1 a "$2"',
	'prlog_removedentry' => 'borrado problema $1',
	'prlog_emailedentry' => 'envió un correo electrónico a $2 ($3)',
	'pr_introductory_text' => '¡La mayoría de las páginas de este wiki son editables, y tú eres bienvenido para editar la página y corregir los errores tú mismo! Si tú necesitas ayuda para hacer eso, mira [[Help:Editing|cómo editar]] y [[Help:Reverting|cómo revertir vandalismos]].

Para contactar con el equipo o para informar sobre problemas de copyright, por favor mira [[w:contact us|la página de "contáctanos" de Wikia]].

Los bugs de software puede ser informados en los foros. Los informes que estén aquí [[Special:ProblemReports|se verán en el wiki]].',
	'pr_what_problem' => 'Tema',
	'pr_what_problem_spam' => 'hay spam aquí',
	'pr_what_problem_vandalised' => 'esta página ha sido vandalizada',
	'pr_what_problem_incorrect_content' => 'este contenido es incorrecto',
	'pr_what_problem_software_bug' => 'hay un bug en el software wiki',
	'pr_what_problem_other' => 'otro',
	'pr_what_problem_select' => 'Selecciona el tipo de problema',
	'pr_what_problem_unselect' => 'todo',
	'pr_what_problem_vandalised_short' => 'vándalo',
	'pr_what_problem_incorrect_content_short' => 'contenido',
	'pr_what_problem_other_short' => 'otro',
	'pr_what_problem_change' => 'Cambia el tipo de problema',
	'pr_describe_problem' => 'Describe el problema',
	'pr_what_page' => 'Nombre de la página',
	'pr_email_visible_only_to_staff' => 'visible solamente para el staff',
	'pr_thank_you' => '¡Gracias por informar sobre un problema! [[Special:ProblemReports/$1|Tú puedes ver su progreso de reparación]]',
	'pr_thank_you_error' => 'Ha ocurrido un error mientras enviaba el informe sobre un problema, por favor, inténtelo más tarde...',
	'pr_spam_found' => 'Ha sido encontrado en el sumario de tu informe spam. Por favor cambia el contenido del sumario',
	'pr_empty_summary' => 'Por favor da una pequeña descripción del problema',
	'pr_empty_email' => 'Por favor da tu dirección de correo electrónico',
	'pr_mailer_notice' => 'La dirección de correo electrónico que tú introduciste en tus preferencias de usuario aparecerá en "De", para que el destinatario pueda responder.',
	'pr_mailer_subject' => 'Problema reportado en',
	'pr_mailer_tmp_info' => 'Puedes añadir una plantilla de respuesta [[MediaWiki:ProblemReportsResponses|aquí]].<br/>Busca más en [[w:c:help:Help:ProblemReports|Help:ProblemReports]].',
	'pr_total_number' => 'Número total de informes',
	'pr_view_archive' => 'Ver problemas archivados',
	'pr_view_all' => 'Mostrar todos los informes',
	'pr_view_staff' => 'Mostrar informes que necesiten ayuda del staff',
	'pr_raports_from_this_wikia' => 'Ver informes solamente de este wiki',
	'pr_reports_from' => 'Informes solamente de',
	'pr_no_reports' => 'No hay informes con este criterio',
	'pr_sysops_notice' => 'Si tú quieres cambiar el estado de un informe sobre un problema de tu wiki, por favor ve <a href="$1">aquí</a>...',
	'pr_table_problem_id' => 'ID del problema',
	'pr_table_wiki_name' => 'Nombre del wiki',
	'pr_table_problem_type' => 'Tipo de problema',
	'pr_table_page_link' => 'Página',
	'pr_table_date_submitted' => 'Fecha de envío',
	'pr_table_reporter_name' => 'Quién informa',
	'pr_table_description' => 'Descripción',
	'pr_table_comments' => 'Comentarios',
	'pr_table_status' => 'Estado',
	'pr_table_actions' => 'Acciones',
	'pr_status_0' => 'pendiente',
	'pr_status_1' => 'reparado',
	'pr_status_2' => 'cerrado',
	'pr_status_3' => 'necesaria ayuda del equipo',
	'pr_status_10' => 'borrar informe',
	'pr_status_undo' => 'Deshacer cambio en el estado del informe',
	'pr_status_ask' => '¿Cambiar estado del informe?',
	'pr_remove_ask' => '¿Borrar permanentemente el informe?',
	'pr_status_wait' => 'espere...',
	'pr_read_only' => 'Los nuevos informes no pueden ser introducidos por ahora, por favor inténtalo más tarde.',
	'pr_msg_exceeded' => 'El número máximo de caracteres en el mensaje es de 512. Por favor, reescribe tu mensaje.',
	'pr_msg_exchead' => 'Mensaje demasiado largo',
);

$messages['fa'] = array(
	'problemreports' => 'فهرست گزارش‌ اشکال‌ها',
	'reportproblem' => 'گزارش اشکال',
	'pr_status_1' => 'اصلاح شد',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'problemreports' => 'Ongelmaraporttien lista',
	'reportproblem' => 'Ilmoita ongelmasta',
	'prlogtext' => 'Ongelmaraportit',
	'prlogheader' => 'Lista ilmoitetuista ongelmista ja muutoksista niiden tilaan',
	'prlog_reportedentry' => 'ilmoitti ongelman sivussa $1 ($2)',
	'prlog_changedentry' => 'merkitsi ongelmalle $1 tilan ”$2”',
	'prlog_removedentry' => 'poisti ongelman $1',
	'pr_introductory_text' => 'Useimmat tämän wikin sivut ovat muokattavissa, ja olet tervetullut muokkaamaan niitä ja korjaamaan virheitä itse! Jos tarvitset apua, katso [[Help:Muokkaaminen|kuinka muokataan]] ja [[Help:Palauttaminen|kuinka vandalismia kumotaan]].

Ottaaksesi yhteyttä henkilökuntaan tai ilmoittaaksesi tekijänoikeusongelmista, katso [[w:c:fi:Ota yhteyttä|Wikian ”ota yhteyttä” -sivu]].

Ohjelmistovirheistä voi ilmoittaa foorumeilla. Tämän lomakkeen kautta tehdyt ilmoitukset [[Special:ProblemReports|näkyvät wikissä]].',
	'pr_what_problem' => 'Aihe',
	'pr_what_problem_spam' => 'täällä on mainoslinkki',
	'pr_what_problem_vandalised' => 'tätä sivua on vandalisoitu',
	'pr_what_problem_incorrect_content' => 'tämä sisältö on virheellistä',
	'pr_what_problem_software_bug' => 'ohjelmistovirhe wikiohjelmistossa',
	'pr_what_problem_other' => 'muu',
	'pr_what_problem_unselect' => 'kaikki',
	'pr_what_problem_spam_short' => 'mainoslinkki',
	'pr_what_problem_vandalised_short' => 'vandalisoitu sivu',
	'pr_what_problem_incorrect_content_short' => 'sisältö',
	'pr_what_problem_software_bug_short' => 'ohjelmistovirhe',
	'pr_what_problem_other_short' => 'muu',
	'pr_describe_problem' => 'Viesti',
	'pr_what_page' => 'Ongelmasivun nimi',
	'pr_email_visible_only_to_staff' => 'näkyy vain henkilökunnalle',
	'pr_thank_you' => 'Kiitos ongelman ilmoittamisesta.

[[Special:ProblemReports/$1|Voit tarkkailla ongelman korjausprosessia]].',
	'pr_thank_you_error' => 'Tapahtui virhe, kun ongelmaraporttia lähetettiin. Yritä myöhemmin uudestaan...',
	'pr_spam_found' => 'Raportin yhteenvedosta löytyi mainoslinkki. Muuta yhteenvedon sisältöä.',
	'pr_empty_summary' => 'Anna lyhyt kuvaus ongelmasta',
	'pr_total_number' => 'Raporttien yhteismäärä',
	'pr_view_archive' => 'Näytä arkistoidut ongelmat',
	'pr_view_all' => 'Näytä kaikki ilmoitukset',
	'pr_view_staff' => 'Näytä ilmoitukset, joissa tarvitaan henkilökunnan apua',
	'pr_raports_from_this_wikia' => 'Näytä ilmoitukset vain tästä Wikiasta',
	'pr_reports_from' => 'Raportit vain',
	'pr_no_reports' => 'Mikään ilmoitus ei täsmää kriteereihisi',
	'pr_table_problem_id' => 'Ongelmatunniste',
	'pr_table_wiki_name' => 'Wikin nimi',
	'pr_table_problem_type' => 'Ongelman tyyppi',
	'pr_table_page_link' => 'Sivu',
	'pr_table_date_submitted' => 'Päivä, jolloin jätetty',
	'pr_table_reporter_name' => 'Raportoijan nimi',
	'pr_table_description' => 'Kuvaus',
	'pr_table_comments' => 'Kommentit',
	'pr_table_actions' => 'Toiminnot',
	'pr_status_0' => 'odottaa',
	'pr_status_1' => 'korjattu',
	'pr_status_2' => 'suljettu',
	'pr_status_3' => 'tarvitsee henkilökunnan apua',
	'pr_status_10' => 'poista ilmoitus',
	'pr_status_undo' => 'Kumoa ilmoituksen tilan muutos',
	'pr_status_ask' => 'Vaihda ilmoituksen tilaa?',
	'pr_remove_ask' => 'Poista ilmoitus pysyvästi?',
	'pr_status_wait' => 'odota...',
);

/** French (Français)
 * @author IAlex
 */
$messages['fr'] = array(
	'problemreports' => 'Liste des rapports de problème',
	'reportproblem' => 'Rapporter un problème',
	'prlogtext' => 'Rapports de problème',
	'prlogheader' => 'Liste des problèmes rapportés et les modifications de leurs statuts',
	'prlog_reportedentry' => 'a rapporté un problème sur $1 ($2)',
	'prlog_changedentry' => 'a marqué le problème $1 comme « $2 »',
	'prlog_typeentry' => 'a modifié le type du problème $1 à « $2 »',
	'prlog_removedentry' => 'a supprimé le problème $1',
	'prlog_emailedentry' => 'a envoyé un courriel $ $2 ($3)',
	'pr_introductory_text' => "La plupart des pages de ce wiki sont modifiables, et vous êtes invité à les modifier et corriger les erreurs vous-même ! Si vous avez besoin d'aide pendant cela, voyez [[help:editing|comment modifier]] et [[help:revert|comment révoquer le vandalisme]].

Pour contacter le personnel ou rapporter des problèmes de droits d'auteur, utilisez [[w:contact us|la page « contactez nous » de Wikia]].

Les bogues du logiciel peuvent être rapportés sur les forums. Les rapports faits ici seront [[Special:ProblemReports|affichés sur le wiki]].",
	'pr_what_problem' => 'Objet',
	'pr_what_problem_spam' => 'il y a un lien de spam ici',
	'pr_what_problem_vandalised' => 'cette page a été vandalisée',
	'pr_what_problem_incorrect_content' => 'ce contenu est incorrect',
	'pr_what_problem_software_bug' => 'il y a un bogue dans le logiciel du wiki',
	'pr_what_problem_other' => 'autre',
	'pr_what_problem_select' => 'Sélectionnez le type du problème',
	'pr_what_problem_unselect' => 'tout',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandale',
	'pr_what_problem_incorrect_content_short' => 'contenu',
	'pr_what_problem_software_bug_short' => 'bogue',
	'pr_what_problem_other_short' => 'autre',
	'pr_what_problem_change' => 'Modifier le type de problème',
	'pr_describe_problem' => 'Message',
	'pr_what_page' => 'Titre de la page',
	'pr_email_visible_only_to_staff' => 'visible uniquement au staff',
	'pr_thank_you' => "Merci d'avoir rapporté votre problème !

[[Special:ProblemReports/$1|Vous pouvez suivre de progrès de sa résolution]].",
	'pr_thank_you_error' => "Une erreur est survenue lors de l'envoi du rapport de problème, veuillez réessayer plus tard...",
	'pr_spam_found' => 'Du spam a été trouvé de le résumé de votre rapport. Veuillez change le contenu du résumé.',
	'pr_empty_summary' => "Merci d'écrire un court déscripion du problème",
	'pr_empty_email' => 'Veuillez fournir votre adresse de courriel',
	'pr_mailer_notice' => "L'adresse de courriel que vous avez entrée dans vos préférences utilisateur apparaîtra and le champ « De » du courriel, ce qui permettra aux destinataires de vous répondre.",
	'pr_mailer_subject' => 'Problème rapporté sur',
	'pr_mailer_tmp_info' => 'Vous pouvez modifier vos modèles de la réponse [[MediaWiki:ProblemReportsResponses|ici]].',
	'pr_mailer_to_default' => 'Utilisateur de Wikia',
	'pr_mailer_go_to_wiki' => 'Pour envoyer un courriel allez sur [$1 le wiki sur lequel le problème a été rapporté]',
	'pr_total_number' => 'Nombre total de rapports',
	'pr_view_archive' => 'Voir les rapports affichés',
	'pr_view_all' => 'Afficher tous les rapports',
	'pr_view_staff' => "Afficher les rapports qui nécessitent l'aide du staff",
	'pr_raports_from_this_wikia' => 'Voir les rapports de ce Wikia seulement',
	'pr_reports_from' => 'Rapports seulement depuis',
	'pr_no_reports' => 'Aucun rapport ne correspond à vos critères',
	'pr_sysops_notice' => 'Si vous voulez changer le statut du rapport de problème depuis votre wiki, allez <a href="$1">ici</a>...',
	'pr_table_problem_id' => 'ID du problème',
	'pr_table_wiki_name' => 'Nom du wiki',
	'pr_table_problem_type' => 'Type du problème',
	'pr_table_page_link' => 'Page',
	'pr_table_date_submitted' => 'Date de soumission',
	'pr_table_reporter_name' => 'Nom du rapporteur',
	'pr_table_description' => 'Description',
	'pr_table_comments' => 'Commentaires',
	'pr_table_status' => 'Statut',
	'pr_table_actions' => 'Actions',
	'pr_status_0' => 'en attente',
	'pr_status_1' => 'résolu',
	'pr_status_2' => 'fermé',
	'pr_status_3' => "nécessite l'aide du personnel",
	'pr_status_10' => 'supprimer le rapport',
	'pr_status_undo' => 'Défaire la modification de statut',
	'pr_status_ask' => 'Modifier le statut du rapport ?',
	'pr_remove_ask' => 'Supprimer le rapport de manière permanente ?',
	'pr_status_wait' => 'patientez...',
	'pr_read_only' => 'Les nouveaux rapports ne peuvent pas êtres ajoutés actuellement, veuillez réessayer plus tard.',
	'pr_msg_exceeded' => 'Le maximum des caractères dans ce box sont 512. Veulliez écrire ce message encore une fois.',
	'pr_msg_exchead' => 'Le message est trop long',
	'right-problemreports_action' => 'Modifier le statut et le type de rapports de problèmes',
	'right-problemreports_global' => 'Modifier le statut et le type de rapports de problèmes au travers des wikis',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'reportproblem' => 'Probléma jelentése',
	'prlogtext' => 'Problémajelentések',
	'pr_what_problem' => 'Tárgy',
	'pr_what_problem_other' => 'egyéb',
	'pr_what_problem_unselect' => 'összes',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalizmus',
	'pr_what_problem_incorrect_content_short' => 'tartalom',
	'pr_what_problem_other_short' => 'egyéb',
	'pr_what_problem_change' => 'Probléma típusának megváltoztatása',
	'pr_describe_problem' => 'Üzenet',
	'pr_what_page' => 'A lap címe',
	'pr_mailer_subject' => 'Problémabejelentése ideje:',
	'pr_mailer_to_default' => 'Wikia felhasználó',
	'pr_view_all' => 'Összes bejelentés megjelenítése',
	'pr_table_problem_id' => 'Probléma azonosító',
	'pr_table_wiki_name' => 'Wiki neve',
	'pr_table_problem_type' => 'Probléma típusa',
	'pr_table_page_link' => 'Lap',
	'pr_table_date_submitted' => 'Beküldve',
	'pr_table_reporter_name' => 'Bejelentő neve',
	'pr_table_description' => 'Leírás',
	'pr_table_comments' => 'Megjegyzések',
	'pr_table_status' => 'Állapot',
	'pr_table_actions' => 'Műveletek',
	'pr_status_wait' => 'várj…',
	'pr_msg_exchead' => 'Az üzenet túl hosszú',
);

$messages['ja'] = array(
	'problemreports' => '報告された問題のリスト',
	'reportproblem' => '問題の報告',
	'prlogtext' => '問題を報告する',
	'prlogheader' => '問題の報告と問題のステータス変更についての記録です。',
	'prlog_reportedentry' => '$1 ($2) の問題を報告',
	'prlog_changedentry' => '問題 $1 を "$2" にマーク',
	'prlog_typeentry' => '問題のタイプを $1 から $2 へ変更',
	'prlog_emailedentry' => '$2 に $3 についてのメールを送信',
	'pr_introductory_text' => 'このウィキのほとんどのページは編集可能です。もし間違いがあったら、是非とも編集して、間違いを直してしまってください。編集の仕方がわからない場合は、[[Help:編集の仕方|ヘルプページ]]などをご覧ください。

スタッフと連絡をとったり、著作権上の問題を報告する場合は、[[w:c:ja:連絡先|ウィキアの連絡用ページ]]をご覧ください。

ソフトウェアのバグは、[[w:c:ja:Forum:不具合・要望|フォーラム]]で報告できます。ウィキに報告された各種問題は、[[Special:ProblemReports|こちら]]で見ることができます。',
	'pr_what_problem' => '問題の種類',
	'pr_what_problem_spam' => '宣伝リンクがあります',
	'pr_what_problem_vandalised' => 'ページが荒されています',
	'pr_what_problem_incorrect_content' => '内容に誤りがあります',
	'pr_what_problem_software_bug' => 'ソフトウェアにバグがあります',
	'pr_what_problem_other' => 'その他',
	'pr_what_problem_select' => '問題の種類を教えてください',
	'pr_what_problem_unselect' => '全て',
	'pr_what_problem_spam_short' => 'スパム',
	'pr_what_problem_vandalised_short' => '荒し',
	'pr_what_problem_incorrect_content_short' => '内容の誤り',
	'pr_what_problem_software_bug_short' => 'バグ',
	'pr_what_problem_other_short' => 'その他',
	'pr_what_problem_change' => '問題のタイプを変更',
	'pr_describe_problem' => '詳細',
	'pr_what_page' => 'ページ名',
	'pr_thank_you' => '報告ありがとうございます!

[[Special:ProblemReports/$1|こちらから修正の確認を行えます]]',
	'pr_thank_you_error' => 'エラーが発生して、問題の送信が出来ませんでした。あとでもう一度お願いいたします。',
	'pr_empty_summary' => '問題の詳細を入力してください',
	'pr_empty_email' => 'メールアドレスを入力してください',
	'pr_mailer_notice' => 'メールを受け取った人が返信できるように、あなたがオプションページで設定したEメールアドレスが送信されるメールの送信元 (From) として設定されます。',
	'pr_mailer_subject' => '報告された問題について',
	'pr_mailer_go_to_wiki' => 'メールを送信するには[$1 問題が報告されたウィキを訪れる必要があります]。',
	'pr_total_number' => '報告の総数',
	'pr_view_archive' => 'アーカイブにされた問題を見る',
	'pr_view_all' => '全ての報告を見る',
	'pr_view_staff' => 'スタッフのヘルプが必要な問題を見る',
	'pr_table_problem_id' => 'ID',
	'pr_table_wiki_name' => 'ウィキ名',
	'pr_table_problem_type' => '問題のタイプ',
	'pr_table_page_link' => 'ページ',
	'pr_table_date_submitted' => '報告された日時',
	'pr_table_reporter_name' => '報告者',
	'pr_table_description' => '解説',
	'pr_table_comments' => 'コメント',
	'pr_table_status' => '状況',
	'pr_table_actions' => '問題の状況の変更',
	'pr_status_0' => '継続中',
	'pr_status_1' => '解決',
	'pr_status_2' => '終了',
	'pr_status_3' => 'スタッフによるヘルプが必要',
	'pr_status_wait' => 'お待ちください....',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'problemreports' => 'Листа на пријавени проблеми',
	'reportproblem' => 'Пријави проблем',
	'prlogtext' => 'Пријавени проблеми',
	'prlogheader' => 'Листа на пријавени проблеми и промени во нивниот статус',
	'prlog_reportedentry' => 'пријавен проблем на $1 ($2)',
	'prlog_changedentry' => 'означен проблемот $1 како „$2“',
	'prlog_typeentry' => 'променет типот на проблемот $1 во „$2“',
	'prlog_removedentry' => 'отстранет проблем $1',
	'prlog_emailedentry' => 'испратена порака по е-пошта на $2 ($3)',
	'pr_introductory_text' => 'Највеќето страници на ова вики се уредливи, и затоа сте добредојдени самите да ја уредите страницата и да ги поправите грешките! Ако ви треба помош со тоа, погледајте ги напатствијата [[help:editing|како се уредува]] и [[help:revert|како се враќаат вандализми]].

За да го контактирате персоналот или да пријавите проблеми со авторски права, одете на [[w:contact us|страницата за контакт на Викија]].

Грешките во програмот можат да се пријават на форумите. Таквите пријави ќе бидат [[Special:ProblemReports|истакнати на викито]].',
	'pr_what_problem' => 'Наслов',
	'pr_what_problem_spam' => 'тука има спам-врска',
	'pr_what_problem_vandalised' => 'оваа страница е вандализирана',
	'pr_what_problem_incorrect_content' => 'оваа содржина не е точна',
	'pr_what_problem_software_bug' => 'има грешка во викисофтверот',
	'pr_what_problem_other' => 'друго',
	'pr_what_problem_select' => 'Изберете тип на проблем',
	'pr_what_problem_unselect' => 'сите',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандализам',
	'pr_what_problem_incorrect_content_short' => 'содржина',
	'pr_what_problem_software_bug_short' => 'грешка',
	'pr_what_problem_other_short' => 'друго',
	'pr_what_problem_change' => 'Промени тип на проблем',
	'pr_describe_problem' => 'Порака',
	'pr_what_page' => 'Наслов на страницата',
	'pr_email_visible_only_to_staff' => 'видливо само за персонал',
	'pr_thank_you' => 'Ви благодариме што пријавивте проблем!

[[Special:ProblemReports/$1|Можете да го набљудувате напредокот во неговото поправање]].',
	'pr_thank_you_error' => 'Се појави грешка при испраќањето на пријавата. Обидете се подоцна...',
	'pr_spam_found' => 'Во описот на вашата пријава е пронајден спам. Променете ја содржината на описот',
	'pr_empty_summary' => 'Накратко опишете го проблемот',
	'pr_empty_email' => 'Наведете ја вашата е-поштенска адреса',
	'pr_mailer_notice' => 'Е-поштенската адреса што ја внесовте во вашите кориснички нагодувања ќе се прикаже како адреса на испраќачот („Од“) во писмото, за да може примачот да ви одговори.',
	'pr_mailer_subject' => 'Пријавен проблем на',
	'pr_mailer_tmp_info' => 'Можете да уредувате шаблонизирани одговори [[MediaWiki:ProblemReportsResponses|овде]]',
	'pr_mailer_to_default' => 'Корисник на Викија',
	'pr_mailer_go_to_wiki' => 'За да испратите е-пошта одете на [$1 викито од кое е пријавен проблемот]',
	'pr_total_number' => 'Вкупен број на пријави',
	'pr_view_archive' => 'Прикажи архивирани проблеми',
	'pr_view_all' => 'Прикажи ги сите пријави',
	'pr_view_staff' => 'Прикажи пријави што бараат помош од персонал',
	'pr_raports_from_this_wikia' => 'Прикажи пријави само од оваа Викија',
	'pr_reports_from' => 'Само пријави од',
	'pr_no_reports' => 'Нема пријави што се совпаѓаат со бараното',
	'pr_sysops_notice' => 'Ако сакате да го промените статусот на некој пријавен проблем за вашето вики, појдете <a href="$1">тука</a>...',
	'pr_table_problem_id' => 'ID на проблемот',
	'pr_table_wiki_name' => 'Име на викито',
	'pr_table_problem_type' => 'Тип на проблем',
	'pr_table_page_link' => 'Страница',
	'pr_table_date_submitted' => 'Поднесено на',
	'pr_table_reporter_name' => 'Име на пријавувачот',
	'pr_table_description' => 'Опис',
	'pr_table_comments' => 'Коментари',
	'pr_table_status' => 'Статус',
	'pr_table_actions' => 'Мерки',
	'pr_status_0' => 'во исчекување',
	'pr_status_1' => 'поправено',
	'pr_status_2' => 'затворено',
	'pr_status_3' => 'потребна помош од персонал',
	'pr_status_10' => 'отстрани пријава',
	'pr_status_undo' => 'Врати промена на статус на пријавата',
	'pr_status_ask' => 'Да го променам статусот на пријавата?',
	'pr_remove_ask' => 'Да ја отстранам пријавата засекогаш?',
	'pr_status_wait' => 'почекајте...',
	'pr_read_only' => 'Во моментов не можат да се поднесуваат нови пријави. Обидете се подоцна.',
	'pr_msg_exceeded' => 'Во полето за пишување на порака дозволени се највеќе 512 знаци. Препишете ја пораката пократко.',
	'pr_msg_exchead' => 'Пораката е преголема',
	'right-problemreports_action' => 'Измени состојба и тип на ПријавувањеПроблеми',
	'right-problemreports_global' => 'Менување на состојба и тип на ПријавувањПроблеми низ разни викија',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'problemreports' => 'Probleem meldingen lijst',
	'reportproblem' => 'Meld een probleem',
	'prlogtext' => 'Probleem meldingen',
	'prlogheader' => 'Lijst van gemelde problemen en veranderingen van hun status',
	'prlog_reportedentry' => 'een probleem gemeld op $1 ($2)',
	'prlog_changedentry' => 'probleem $1 gemarkeerd als "$2"',
	'prlog_typeentry' => 'type van probleem $1 veranderd in "$2"',
	'prlog_removedentry' => 'probleem $1 verwijderd',
	'prlog_emailedentry' => 'email verstuurd naar $2 ($3)',
	'pr_introductory_text' => 'De meeste pagina\'s op deze wiki kunnen bewerkt worden, en het staat u vrij de pagina te bewerken en fouten te corrigeren!
Als u hierbij help nodig hebt, zie dan de hulppagina\'s "[[help:editing|Hoe te bewerken]]" en "[[help:revert|hoe vandalisme terug te draaien]]."

Om contact op te nemen met staf of om auteursrechtenproblemen te melden, kunt u gebruik make van de [[w:contact us|contactpagina van Wikia]].

Softwareproblemen kunt u melden op de forums.
Hier gemelde problemen zijn [[Special:ProblemReports|zichtbaar op de wiki]].',
	'pr_what_problem' => 'Onderwerp',
	'pr_what_problem_spam' => 'er is hier een spam link',
	'pr_what_problem_vandalised' => 'deze pagina is gevandaliseerd',
	'pr_what_problem_incorrect_content' => 'deze inhoud is incorrect',
	'pr_what_problem_software_bug' => 'er is een bug in de wiki software',
	'pr_what_problem_other' => 'overige',
	'pr_what_problem_select' => 'Selecteer a.u.b. een probleem type',
	'pr_what_problem_unselect' => 'alle',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandalisme',
	'pr_what_problem_incorrect_content_short' => 'inhoud',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'overige',
	'pr_what_problem_change' => 'Verander probleem type',
	'pr_describe_problem' => 'Bericht',
	'pr_what_page' => 'Titel van de pagina',
	'pr_email_visible_only_to_staff' => 'alleen zichtbaar voor staff',
	'pr_thank_you' => 'Bedankt voor het melden van een probleem! 

[[Special:ProblemReports/$1|Je kan de status van het oplossen ervan volgen.]]',
	'pr_thank_you_error' => 'Een fout trad op toen het probleem verstuurd was, probeer het a.u.b. later nog een keer...',
	'pr_spam_found' => 'Er is spam gevonden in je meldings samenvatting. Verander a.u.b. de inhoud van de samenvatting',
	'pr_empty_summary' => 'Geef a.u.b. een korte samenvatting',
	'pr_empty_email' => 'Geef a.u.b. je email adres op',
	'pr_mailer_notice' => 'Het email adres dat je ingevuld hebt bij je gebruikers voorkeuren zal verschijnen als het "Van" adres van de mail, zodat de ontvanger mail terug kan antwoorden.',
	'pr_mailer_subject' => 'Probleem gemeld op',
	'pr_mailer_tmp_info' => 'Je kan sjabloon antwoorden [[MediaWiki:ProblemReportsResponses|hier]] bewerken',
	'pr_mailer_to_default' => 'Wikia Gebruiker',
	'pr_mailer_go_to_wiki' => 'Om een email te sturen ga a.u.b. naar [$1 wiki probleem was gemeld van]',
	'pr_total_number' => 'Totaal aantal meldingen',
	'pr_view_archive' => 'Bekijk gearchiveerde meldingen',
	'pr_view_all' => 'Bekijk alle meldingen',
	'pr_view_staff' => 'Bekijk meldingen die staff hulp nodig hebben',
	'pr_raports_from_this_wikia' => 'Bekijk alleen meldingen van deze Wikia',
	'pr_reports_from' => 'Meldingen alleen van',
	'pr_no_reports' => 'Geen meldingen die voldoen aan je criteria',
	'pr_sysops_notice' => '<a href="$1">Wijzig de status van probleemrapporten van uw wiki</a>.',
	'pr_table_problem_id' => 'Probleem ID',
	'pr_table_wiki_name' => 'Wiki naam',
	'pr_table_problem_type' => 'Probleem type',
	'pr_table_page_link' => 'Pagina',
	'pr_table_date_submitted' => 'Datum gemeld',
	'pr_table_reporter_name' => 'Reporter naam',
	'pr_table_description' => 'Omschrijving',
	'pr_table_comments' => 'Opmerkingen',
	'pr_table_status' => 'Status',
	'pr_table_actions' => 'Acties',
	'pr_status_0' => 'mee bezig',
	'pr_status_1' => 'gemaakt',
	'pr_status_2' => 'gesloten',
	'pr_status_3' => 'staff hulp nodig',
	'pr_status_10' => 'verwijder melding',
	'pr_status_undo' => 'Maak melding status ongedaan',
	'pr_status_ask' => 'Verander melding status?',
	'pr_remove_ask' => 'Permanent melding verwijderen?',
	'pr_status_wait' => 'wacht...',
	'pr_read_only' => 'Nieuwe meldingen kunnen nu niet toegevoegd worden, probeer het a.u.b. later.',
	'pr_msg_exceeded' => 'Het maximum aantal tekens in het Berichten veld is 512. Verander a.u.b. je bericht.',
	'pr_msg_exchead' => 'Bericht is te lang',
	'right-problemreports_action' => 'Status en type van probeemrapporten wijzigen',
	'right-problemreports_global' => "Status en type van probeemrapporten in alle wiki's wijzigen",
);

$messages['no'] = array(
	'problemreports' => 'Problemrapportsliste',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'problemreports' => 'Lista dij rapòrt ëd problema',
	'reportproblem' => 'Arpòrta un problema',
	'prlogtext' => 'Rapòrt ëd problema',
	'prlogheader' => 'Lista dij problema riportà e dij cangiament dij sò stat',
	'prlog_reportedentry' => "a l'ha arportà un problema su $1 ($2)",
	'prlog_changedentry' => 'a l\'ha marcà ël problema $1 com "$2"',
	'prlog_typeentry' => 'a l\'ha cangià la sòrt dël problema $1 a "$2"',
	'prlog_removedentry' => "a l'ha gavà ël problema $1",
	'prlog_emailedentry' => "a l'ha mandà un mëssagi ëd pòsta eletrònica a $2 ($3)",
	'pr_introductory_text' => "La pi part ëd le pàgine su sta wiki-sì a son modificàbij, e chiel-midem a l'é bin ëvnù a modifiché pàgine e corege j'eror! S'a l'ha dabzògn d'agiut për felo, ch'a varda [[help:editing|com modifiché]] e [[help:revert|com gavé ij vandalism]].

Për contaté l'echip o për arporté problema ëd drit d'autor, për piasì ch'a varda la [[w:contact us|pàgina \"contatne\" ëd Wikia]].

Ij difet dël programa a peulo esse arportà an sle piasse ëd discussion. Ij rapòrt fàit ambelelà a saran [[Special:ProblemReports|visualisà an sla wiki]].",
	'pr_what_problem' => 'Soget',
	'pr_what_problem_spam' => 'a-i é un colegament ëd rumenta sì',
	'pr_what_problem_vandalised' => "sta pàgina-sì a l'é stàita vandalisà",
	'pr_what_problem_incorrect_content' => "sto contnù-sì a l'é pa giust",
	'pr_what_problem_software_bug' => 'a-i é un bigat ant ël programa dla wiki',
	'pr_what_problem_other' => 'àutr',
	'pr_what_problem_select' => "Për piasì, ch'a selession-a ël tipo ëd problema",
	'pr_what_problem_unselect' => 'tut',
	'pr_what_problem_spam_short' => 'rumenta',
	'pr_what_problem_vandalised_short' => 'vàndal',
	'pr_what_problem_incorrect_content_short' => 'contnù',
	'pr_what_problem_software_bug_short' => 'bigat',
	'pr_what_problem_other_short' => 'àutr',
	'pr_what_problem_change' => 'cangé sòrt ëd problema',
	'pr_describe_problem' => 'Mëssagi',
	'pr_what_page' => 'Tìtol ëd la pàgina',
	'pr_email_visible_only_to_staff' => "visìbil mach a l'echip",
	'pr_thank_you' => "Mersì d'avèj arpòrtà un problema!

[[Special:ProblemReports/$1|A peule ten-e sot euj ël progress ëd soa coression]].",
	'pr_thank_you_error' => "Eror capità an mandand ël rapòrt ëd problema, për piasì ch'a preuva pi tard...",
	'pr_spam_found' => "A l'é stàita trovà dla rumenta ant ël resumé ëd tò rapòrt. Për piasì ch'a cangia ël contnù dël resumé.",
	'pr_empty_summary' => 'Për piasì, dé na curta descrission dël problema',
	'pr_empty_email' => "Për piasì, ch'a buta soa adrëssa ëd pòsta eletrònica",
	'pr_mailer_notice' => "L'adrëssa ëd pòsta eletrònica ch'a l'ha anserì ant ij sò gust d'utent a comparirà ant ël camp \"Da\" dël mëssagi, parèj ël destinatari a podrà arsponde.",
	'pr_mailer_subject' => 'Problema arportà dzora a',
	'pr_mailer_tmp_info' => "It peule modifiché j'arsposte a stamp [[MediaWiki:ProblemReportsResponses|ambelessì]]",
	'pr_mailer_to_default' => 'Utent ëd Wikia',
	'pr_mailer_go_to_wiki' => "Për mandé un mëssagi ëd pòsta eletrònica, për piasì ch'a vada an sla [$1 wiki anté che 'l problema a l'é stàit arportà]",
	'pr_total_number' => 'Nùmer total ëd rapòrt',
	'pr_view_archive' => 'Vëdde ij problema archivià',
	'pr_view_all' => 'Smon-e tùit ij rapòrt',
	'pr_view_staff' => "Smon-e ij rapòrt ch'a l'han dabzògn ëd l'agiut ëd l'echip",
	'pr_raports_from_this_wikia' => 'Varda mach ij rapòrt da sta Wikia-sì',
	'pr_reports_from' => 'Rapòrt mach da',
	'pr_no_reports' => 'Pa gnun rapòrt a rispeta tò criteri',
	'pr_sysops_notice' => 'S\'a veul cangé lë stat dij rapòrt ëd problema da soa wiki, për piasì ch\'a vada a <a href="$1">ambelessì</a>...',
	'pr_table_problem_id' => 'ID dël problema',
	'pr_table_wiki_name' => 'Nòm dla wiki',
	'pr_table_problem_type' => 'Sòrt ëd problema',
	'pr_table_page_link' => 'Pàgina',
	'pr_table_date_submitted' => 'Data ëd presentassion',
	'pr_table_reporter_name' => "Nòm ëd chi a l'ha fàit ël rapòrt",
	'pr_table_description' => 'Descrission',
	'pr_table_comments' => 'Coment',
	'pr_table_status' => 'Stat',
	'pr_table_actions' => 'Assion',
	'pr_status_0' => "ch'a speto",
	'pr_status_1' => 'coregiù',
	'pr_status_2' => 'sarà',
	'pr_status_3' => "a l'han dabzògn ëd l'agiut ëd l'echip",
	'pr_status_10' => 'gava rapòrt',
	'pr_status_undo' => 'Gavé ël cangiament dlë stat dël rapòrt',
	'pr_status_ask' => 'Cangé stat dël rapòrt?',
	'pr_remove_ask' => 'Gavé rapòrt përmanentement?',
	'pr_status_wait' => 'speta...',
	'pr_read_only' => "Ij rapòrt neuv a peulo pa esse compilà ant ës moment-sì, për piasì ch'a preuva torna pi tard.",
	'pr_msg_exceeded' => "Ël nùmer màssim ëd caràter ant ël camp Mëssagi a l'é 512. Për piasì, ch'a scriva torna sò mëssagi.",
	'pr_msg_exchead' => 'Mëssagi tròp longh',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Jesielt
 */
$messages['pt-br'] = array(
	'reportproblem' => 'Reporte um problema',
	'pr_introductory_text' => 'A maioria das páginas nessa wiki são editáveis e você é bem-vindo para editá-las e corrigir erros você mesmo! Se você está procurando por ajuda, veja [[help:editing|como editar]] e [[help:revert|como reverter vandalismos]].

Para contatar o pessoal para reportar violações de direitos autorais, por favor, veja a página [[w:contact us|"fale conosco" do Wikia]].

Bugs do software podem ser reportados nos fóruns. As reportagens feitas aqui serão [[Special:ProblemReports|mostradas nessa wiki]].',
	'pr_what_problem' => 'Assunto',
	'pr_what_problem_spam' => 'há um link spam aqui',
	'pr_what_problem_vandalised' => 'essa página foi vandalizada',
	'pr_what_problem_incorrect_content' => 'esse conteúdo está incorreto',
	'pr_what_problem_software_bug' => 'há um bug no software wiki',
	'pr_what_problem_other' => 'outro',
	'pr_what_problem_select' => 'Por favor selecione um tipo de problema',
	'pr_what_problem_unselect' => 'tudo',
	'pr_what_problem_vandalised_short' => 'vândalo',
	'pr_what_problem_incorrect_content_short' => 'conteúdo',
	'pr_what_problem_other_short' => 'outro',
	'pr_what_problem_change' => 'Mudar o tipo de problema',
	'pr_describe_problem' => 'Mensagem',
	'pr_what_page' => 'Título da página',
	'pr_email_visible_only_to_staff' => 'Visível apenas para o pessoal',
	'pr_thank_you' => 'Obrigado por reportar um problema!

[[Special:ProblemReports/$1|Você pode vigiar o progresso da correção dele aqui]].',
	'pr_thank_you_error' => 'Ocorreu um erro enquanto estava sendo enviado a reportagem de problema, por favor, tente novamente mais tarde...',
);

/** Russian (Русский)
 * @author Lockal
 */
$messages['ru'] = array(
	'reportproblem' => 'Сообщить о проблеме',
	'prlogtext' => 'Сообщения о проблемах',
	'pr_introductory_text' => 'Большинство страниц в этой вики доступны для редактирования, что позволяет изменить их и исправить ошибки самостоятельно. Если вам нужна помощь в этом, см. [[help:editing|справку по редактированию]] и [[help:revert|по откату вандализма]].

Для связи с сотрудниками или сообщений о проблемах с авторским правом, пожалуйста, используйте [[w:contact us|страницу обратной связи Викия]].

Об ошибках в программном обеспечении можно сообщить на форуме. Такие сообщения будут [[Special:ProblemReports|отображены в вики]].',
	'pr_what_problem' => 'Тема',
	'pr_what_problem_select' => 'Пожалуйста, выберите тип проблемы',
	'pr_what_problem_spam_short' => 'спам',
	'pr_what_problem_vandalised_short' => 'вандализм',
	'pr_what_problem_incorrect_content_short' => 'содержание',
	'pr_describe_problem' => 'Сообщение',
	'pr_what_page' => 'Название страницы',
	'pr_table_problem_type' => 'Тип проблемы',
	'pr_table_page_link' => 'Страница',
);

/** Swedish (Svenska)
 * @author Per
 */
$messages['sv'] = array(
	'problemreports' => 'Problemrapportlista',
	'reportproblem' => 'Rapportera ett problem',
	'prlogtext' => 'Problemrapporter',
	'prlogheader' => 'Lista över rapporterade problem och ändringar på deras status',
	'prlog_emailedentry' => 'skickat e-post till $2 ($3)',
	'pr_what_problem' => 'Ärende',
	'pr_what_problem_spam' => 'det finns en spam-länk här',
	'pr_what_problem_vandalised' => 'den här sidan har blivit vandaliserad',
	'pr_what_problem_incorrect_content' => 'innehållet är felaktigt',
	'pr_what_problem_software_bug' => 'Det finns en bug i wiki-mjukvaran',
	'pr_what_problem_other' => 'annat',
	'pr_what_problem_select' => 'Välj typ av problem',
	'pr_what_problem_unselect' => 'alla',
	'pr_what_problem_spam_short' => 'spam',
	'pr_what_problem_vandalised_short' => 'vandal',
	'pr_what_problem_incorrect_content_short' => 'innehåll',
	'pr_what_problem_software_bug_short' => 'bug',
	'pr_what_problem_other_short' => 'annat',
	'pr_what_problem_change' => 'Ändra problemtyp',
	'pr_describe_problem' => 'Meddelande',
	'pr_empty_summary' => 'Ge en kort problembeskrivning',
	'pr_empty_email' => 'Ange din e-postadress',
	'pr_mailer_subject' => 'Rapportera problem angående',
	'pr_mailer_to_default' => 'Wikia-användare',
	'pr_total_number' => 'Totalt antal rapporter',
	'pr_view_all' => 'Visa alla rapporter',
	'pr_reports_from' => 'Rapporter endast från',
	'pr_no_reports' => 'Inga rapporter stämmer in på angivna kriterier',
	'pr_table_problem_id' => 'Problem-ID',
	'pr_table_wiki_name' => 'Wiki-namn',
	'pr_table_problem_type' => 'Problem typ',
	'pr_table_page_link' => 'Sida',
	'pr_table_date_submitted' => 'Rapportdatum',
	'pr_table_reporter_name' => 'Rapportör',
	'pr_table_description' => 'Beskrivning',
	'pr_table_comments' => 'Kommentarer',
	'pr_table_status' => 'Status',
	'pr_status_0' => 'öppen',
	'pr_status_1' => 'fixat',
	'pr_status_2' => 'stängt',
	'pr_status_3' => 'behöver hjälp från anställd',
	'pr_status_10' => 'ta bort rapport',
	'pr_status_wait' => 'vänta...',
	'pr_msg_exchead' => 'Meddelandet är för långt',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'pr_what_problem' => 'Тема',
	'pr_what_problem_vandalised_short' => 'вандал',
	'pr_what_problem_software_bug_short' => 'помилка',
	'pr_describe_problem' => 'Повідомлення',
	'pr_what_page' => 'Назва сторінки',
	'pr_empty_email' => 'Будь ласка, вкажіть вашу адресу електронної пошти',
	'pr_table_wiki_name' => 'Назва вікі',
	'pr_table_page_link' => 'Сторінка',
	'pr_table_description' => 'Опис',
	'pr_table_actions' => 'Дії',
);


$messages['zh'] = array(
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '問題類型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_status' => '狀態',
);

$messages['zh-cn'] = array(
	'problemreports' => '问题回报列表',
	'reportproblem' => '问题回报',
	'pr_what_problem_change' => '更改问题类型',
	'pr_mailer_notice' => '您在个人资料中所留下的电子邮件，将会自动显示在「发信人」的栏位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回报总数',
	'pr_view_all' => '显示所有回报',
	'pr_table_problem_id' => '问题编号',
	'pr_table_problem_type' => '问题类型',
	'pr_table_reporter_name' => '回报人',
	'pr_table_status' => '状态',
);

$messages['zh-hans'] = array(
	'problemreports' => '问题回报列表',
	'pr_what_problem_change' => '更改问题类型',
	'pr_mailer_notice' => '您在个人资料中所留下的电子邮件，将会自动显示在「发信人」的栏位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回报总数',
	'pr_view_all' => '显示所有回报',
	'pr_table_problem_id' => '问题编号',
	'pr_table_reporter_name' => '回报人',
	'pr_table_status' => '状态',
);

$messages['zh-hant'] = array(
	'problemreports' => '問題回報列表',
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '问题类型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_status' => '狀態',
);

$messages['zh-hk'] = array(
	'problemreports' => '問題回報列表',
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '問題類型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_status' => '狀態',
);

$messages['zh-sg'] = array(
	'reportproblem' => '问题回报',
	'pr_what_problem_change' => '更改问题类型',
	'pr_mailer_notice' => '您在个人资料中所留下的电子邮件，将会自动显示在「发信人」的栏位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回报总数',
	'pr_view_all' => '显示所有回报',
	'pr_table_problem_id' => '问题编号',
	'pr_table_problem_type' => '问题类型',
	'pr_table_reporter_name' => '回报人',
	'pr_table_status' => '状态',
);

$messages['zh-tw'] = array(
	'problemreports' => '問題回報列表',
	'reportproblem' => '問題回報',
	'pr_what_problem_change' => '更改問題類型',
	'pr_thank_you' => '感謝您的回報！',
	'pr_mailer_notice' => '您在個人資料中所留下的電子郵件，將會自動顯示在「發信人」的欄位中，所以收件人能直接回覆您的信件。',
	'pr_total_number' => '回報總數',
	'pr_view_all' => '顯示所有回報',
	'pr_raports_from_this_wikia' => '僅檢視此Wikia的回報',
	'pr_table_problem_id' => '問題編號',
	'pr_table_problem_type' => '問題類型',
	'pr_table_reporter_name' => '回報人',
	'pr_table_comments' => '發表意見',
	'pr_table_status' => '狀態',
	'pr_status_10' => '移除回報',
	'pr_status_ask' => '更改提報問題的狀態？',
);

