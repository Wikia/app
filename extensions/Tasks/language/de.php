<?php
/**
 * German language file for the 'Tasks' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
		'tasks_tab' => 'Aufgaben',
		'tasks_title' => "Aufgaben für \"$1\"",
		'tasks_form_new' => "Neue Aufgabe erstellen",
		'tasks_form_comment' => "Kommentar",
		'tasks_error1' => "Aufgabe wurde nicht erstellt: Es gibt bereits eine solche Aufgabe!",
		'tasks_ok1' => "Neue Aufgabe wurde erstellt!",
		'tasks_create_header' => "Neue Aufgabe erstellen",
		'tasks_existing_header' => "Vorhandene Aufgaben",
		'tasks_existing_table_header' => "Aufgabe|Datum|Kommentar|Zuordnung/Aktionen/Seite",
		'tasks_noone' => "no one",
		'tasks_assign_me' => "Selbst zuweisen",
		'tasks_assign_to' => "Zuweisen an",
		'tasks_unassign_me' => "Meine Zuordnung entfernen",
		'tasks_close' => "Schliessen",
		'tasks_wontfix' => "Ablehnen",
		'tasks_delete' => "Löschen",
		'tasks_no_task_delete_title' => "Nicht erlaubt",
		'tasks_no_task_delete_texe' => "Sie dürfen keine Aufgabe löschen. Nur Administratoren dürfen dies tun.",
		'tasks_action_delete' => "Eine Aufgabe wurde gelöscht.",
		'tasks_task_was_deleted' => "Die Aufgabe wurde erfolgreich gelöscht.",
		'tasks_reopen' => "Aufgabe wieder eröffnen",
		'tasks_assignedto' => "Zuweisen an $1",
		'tasks_created_by' => "Erstellt von $1",
		'tasks_discussion_page_link' => "Aufgaben-Diskussionsseite",
		'tasks_closedby' => "Geschlossen von $1",
		'tasks_assigned_myself_log' => "Selbstzuweisung von Aufgabe $1",
		'tasks_discussion_page_for' => "Diese Aufgabe ist für die Seite \"$1\". Die Liste für alle Aufgaben für diese Seite ist $2.",
		'tasks_sidebar_title' => "Aufgaben öffnen",
		'tasks_here' => "hier",
		'tasks_returnto' => "Sie werden nun weitergeleitet. Falls Sie nicht in ein paar Sekunden weitergeitet wurden, klicken Sie $1.",
		'tasks_see_page_tasks' => "(Aufgaben dieser Seite)",
		'tasks_task_is_assigned' => "(zugewiesen)",
		'tasks_plain_text_only' => "(Klartext, nur 256 Zeichen)",
		'tasks_help_page' => "Aufgaben",
		'tasks_help_page_link' => "Hilfe",
		'tasks_help_separator' => "$2 | $1",
		'tasks_more_like_it' => "mehr",

		'tasks_task_types' => "1:cleanup:Säubern|2:wikify:Wikify|3:rewrite:Umschreiben|4:delete:Löschen|5:create:Erstellen|6:write:Schreiben|7:check:Prüfen",
		'tasks_significance_order' => "rewrite<delete",
		'tasks_creation_tasks' => "5,6",
		
		'tasks_event_on_creation' => "prüfen",
		'tasks_event_on_creation_anon' => "prüfen",
		'tasks_on_creation_comment' => "Automatische Aufgabe, angelegt durch Seitenerstellung",
		
		'tasks_link_your_assignments' => "offenen Aufgaben",
		'tasks_see_your_assignments' => "Sie haben $1 offene Aufgaben. Siehe Ihre $2.",
		'tasks_my_assignments' => "Ihre aktuellen Aufgaben",
		'tasks_table_header_page' => "Seite",
		'tasks_you_have_no_assignments' => "Sie haben keine offenen Aufgaben",
		'tasks_search_form_title' => "Ausführen",
		'tasks_search_tasks' => "Aufgaben",
		'tasks_search_status' => "Status",
		'tasks_search_no_tasks_chosen_note' => "(keine Auswahl sucht in allen Aufgaben)",
		'tasks_search_results' => "Suche Ergebnisse",
		'tasks_previous' => "Vorherige",
		'tasks_next' => "Nächster",
		'tasks_sort' => "Sortieren",
		'tasks_ascending' => "Älteste zuerst",
		'tasks_search_limit' => "10",
		
		'tasks_status_open' => "Offen",
		'tasks_status_assigned' => "Zugewiesen",
		'tasks_status_closed' => "Geschlossen",
		'tasks_status_wontfix' => "Abgelehnt",
		'tasks_action_open' => "Aufgabe \"$1\" geöffnet.",
		'tasks_action_assigned' => "Aufgabe \"$1\" zugewiesen.",
		'tasks_action_closed' => "Aufgabe \"$1\" geschlosssen.",
		'tasks_action_wontfix' => "Aufgabe \"$1\" abgelehnt.",
		
		'tasks_sign_delete' => "<b>Es wurde angefordert diese Seite zu löschen!</b>",
		
		'tasks_logpage' => "Aufgaben-Logbuch",
		'tasks_logpagetext' => 'Dieses Logbuch protokolliert Änderungen an Aufgaben.',
		'tasks_logentry' => 'Für "[[$1]]"',
		
		'tog-show_task_comments' => 'Aufgaben-Diskussionsseite einbinden.',
	)
);

