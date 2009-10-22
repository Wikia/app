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

if (!defined('MEDIAWIKI')) die();

$messages = array();

$messages['en'] = array
	(
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
	);
	
$messages['pl'] = array
	(
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


$messages['fi'] = array(
	'problemreports' => 'Ongelmaraporttien lista',
	'reportproblem' => 'Raportoi ongelmasta',
	'prlogtext' => 'Ongelmaraportit',
	'prlogheader' => 'Lista raportoiduista ongelmista ja muutoksista niiden statuksiin',
	'prlog_reportedentry' => 'raportoi ongelman sivussa $1 ($2)',
	'prlog_changedentry' => 'merkkasi ongelmalle $1 tilan "$2"',
	'prlog_removedentry' => 'poisti ongelman $1',
	'pr_introductory_text' => 'Useimmat tämän wikin sivut ovat muokattavissa, ja olet tervetullut muokkaamaan niitä ja korjaamaan virheitä itse! Jos tarvitset apua, katso [[Ohje:Muokkaaminen|kuinka muokataan]] ja [[Ohje:Palauttaminen|kuinka vandalismia kumotaan]].

Ottaaksesi yhteyttä henkilökuntaan tai raportoidaksesi tekijänoikeusongelmista, katso [[w:c:fi:Ota yhteyttä|Wikian "ota yhteyttä" -sivu]].

Ohjelmistobugeista voi raportoida foorumeilla. Tämän lomakkeen kautta tehdyt raportit [[Special:ProblemReports|näkyvät wikissä]].',
	'pr_what_problem' => 'Mitä ongelmaa ilmoitat?',
	'pr_what_problem_spam' => 'täällä on spämmilinkki',
	'pr_what_problem_vandalised' => 'tätä sivua on vandalisoitu',
	'pr_what_problem_incorrect_content' => 'tämä sisältö on virheellistä',
	'pr_what_problem_software_bug' => 'ohjelmistossa on bugi',
	'pr_what_problem_other' => 'muu',
	'pr_what_problem_spam_short' => 'spämmiä',
	'pr_what_problem_vandalised_short' => 'vandalisoitu sivu',
	'pr_what_problem_incorrect_content_short' => 'virheellinen sisältö',
	'pr_what_problem_software_bug_short' => 'ohjelmistobugi',
	'pr_what_problem_other_short' => 'muu',
	'pr_describe_problem' => 'Ole hyvä ja kuvaile ongelmaa tässä. Voit käyttää wikitekstiä muttet ulkoisia linkkejä.',
	'pr_what_page' => 'Millä sivulla ongelma on?',
	'pr_email_visible_only_to_staff' => 'näkyy vain henkilökunnalle',
	'pr_thank_you' => 'Kiitos ongelman raportoimisesta',
	'pr_thank_you_error' => 'Virhe tapahtui, kun ongelmaraporttia lähetettiin, koita myöhemmin uudestaan...',
	'pr_spam_found' => 'Raportin yhteenvedosta löytyi spämmiä. Ole hyvä ja vaihda yhteenvedon sisältöä',
	'pr_empty_summary' => 'Ole hyvä ja anna lyhyt kuvaus ongelmasta',
	'pr_total_number' => 'Raporttien yhteismäärä',
	'pr_view_archive' => 'Katso arkistoidut ongelmat',
	'pr_view_all' => 'Näytä kaikki raportit',
	'pr_view_staff' => 'Näytä raportit, jotka tarvitsevat henkilökunnan apua',
	'pr_raports_from_this_wikia' => 'Katso raportit vain tästä Wikiasta',
	'pr_reports_from' => 'Raportit vain',
	'pr_no_reports' => 'Mitkään raportit eivät täsmää kriteereihisi',
	'pr_table_problem_id' => 'Ongelman ID',
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
	'pr_status_2' => 'ei ole ongelma',
	'pr_status_3' => 'tarvitsee henkilökunnan apua',
	'pr_status_10' => 'poista raportti',
	'pr_status_undo' => 'Kumoa raportin statuksen muutos',
	'pr_status_ask' => 'Vaihda raportin statusta?',
	'pr_remove_ask' => 'Poista raportti pysyvästi?',
	'pr_status_wait' => 'odota...',
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
	'pr_introductory_text' => 'De meeste pagina\'s op deze wiki kunnen bewerkt worden, en je bent welkom om deze pagina te bewerken en zelf fouten te veranderen! Als je hulp nodig hebt om dit te doen, zie [[Help:Editing|Hoe te bewerken]] en [[Help:Revert|hoe vandalisme terug te draaien]].

Om contact op te nemen met staff of om auteursrecht problemen te melden, gebruik dan [[w:contact us|Wikia\'s "contact us" pagina]].

Software bugs kunnen gemeld worden op de forums. Meldingen die hier gemaakt worden zullen
[[Special:ProblemReports|te zien zijn op deze wiki]].',
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
	'pr_sysops_notice' => 'Als je de status van je report op de wiki wilt wijzigen, ga dan a.u.b. naar hier...',
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
);


$messages['no'] = array(
	'problemreports' => 'Problemrapportsliste',
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


$messages['fr'] = array(
	'reportproblem' => 'Rapporter un problème',
	'pr_empty_summary' => 'Merci d\'écrire un court déscripion du problème',
	'pr_mailer_tmp_info' => 'Vous pouvez modifier vos modèles de la réponse [[MediaWiki:ProblemReportsResponses|ici]].',
	'pr_msg_exceeded' => 'Le maximum des caractères dans ce box sont 512. Veulliez écrire ce message encore une fois.',
	'pr_msg_exchead' => 'Le message est trop long',
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
