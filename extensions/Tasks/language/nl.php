<?php
/**
 * Dutch language file for the 'Tasks' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
		'tasks_tab' => 'Taken',
		'tasks_title' => "Taken voor \"$1\"",
		'tasks_form_new' => "Maak nieuwe taak",
		'tasks_form_comment' => "Opmerking",
		'tasks_error1' => "Taak is niet aangemaakt; er was al een dergelijke taak!",
		'tasks_ok1' => "Nieuw taak is aangemaakt!",
		'tasks_create_header' => "Maak een nieuwe taak",
		'tasks_existing_header' => "Bestaande taken",
		'tasks_existing_table_header' => "Taak|Datums|Eerste opmerking|Toewijzing/Acties/Pagina",
		'tasks_noone' => "niemand",
		'tasks_assign_me' => "Wijs toe aan mezelf",
		'tasks_assign_to' => "Wijs toe aan",
		'tasks_unassign_me' => "Verwijder mijn toewijzing",
		'tasks_close' => "Sluit taak",
		'tasks_wontfix' => "Wordt niet opgelost",
		'tasks_delete' => "Verwijder",
		'tasks_no_task_delete_title' => "Niet toegestaan",
		'tasks_no_task_delete_texe' => "U kunt geen taken verwijderen. Alleen beheerders kunnen dat.",
		'tasks_action_delete' => "Er is een taak verwijderd.",
		'tasks_task_was_deleted' => "De taak is succesvol verwijderd.",
		'tasks_reopen' => "Heropen taak",
		'tasks_assignedto' => "Toegewezen aan $1",
		'tasks_created_by' => "Aangemaakt door $1",
		'tasks_discussion_page_link' => "Overlegpagina taak",
		'tasks_closedby' => "Gesloten door $1",
		'tasks_assigned_myself_log' => "Zelftoewijzing van taak \"$1\"",
		'tasks_discussion_page_for' => "Deze taak is voor de pagina \"$1\". Het overzicht van alle taken voor die pagina is $2.",
		'tasks_sidebar_title' => "Open taken",
		'tasks_here' => "hier",
		'tasks_returnto' => "U wordt nu doorverwezen. Als u over een aantal seconden niet bent doorverwezen, klik dan $1.",
		'tasks_see_page_tasks' => "(taken van deze pagina)",
		'tasks_task_is_assigned' => "(toegewezen)",
		'tasks_plain_text_only' => "(platte tekst, maximaal 256 tekens)",
		'tasks_help_page' => "Taken",
		'tasks_help_page_link' => "?",
		'tasks_help_separator' => "$2 | $1",
		'tasks_more_like_it' => "meer",

		'tasks_task_types' => "1:cleanup:Opschonen|2:wikify:Wikify|3:rewrite:Herschrijven|4:delete:Verwijderen|5:create:Maken|6:write:Schrijven|7:check:Controleren",
		'tasks_significance_order' => "herschrijven<verwijderen",
		'tasks_creation_tasks' => "5,6",
		
		'tasks_event_on_creation' => "controleer",
		'tasks_event_on_creation_anon' => "controleer",
		'tasks_on_creation_comment' => "Automatische taak, gemaakt bij het aanmaken van de pagina",
		
		'tasks_link_your_assignments' => "open toewijzingen",
		'tasks_see_your_assignments' => "U heeft op het momnet $1 open toewijzingen. Zie uw $2.",
		'tasks_my_assignments' => "Uw huidige toewijzingen",
		'tasks_table_header_page' => "Pagina",
		'tasks_you_have_no_assignments' => "U heeft geen open toewijzingen",
		'tasks_search_form_title' => "Zoeken",
		'tasks_search_tasks' => "Taken",
		'tasks_search_status' => "Status",
		'tasks_search_no_tasks_chosen_note' => "(Bij geen selectie hier worden alle taaktypen doorzocht.)",
		'tasks_search_results' => "Zoekresulaten",
		'tasks_previous' => "Vorige",
		'tasks_next' => "Volgende",
		'tasks_sort' => "Sorteren",
		'tasks_ascending' => "Oudere eerst",
		'tasks_search_limit' => "10",
		
		'tasks_status_open' => "Open",
		'tasks_status_assigned' => "Toegewezen",
		'tasks_status_closed' => "Gesloten",
		'tasks_status_wontfix' => "Wordt niet opgelost",
		'tasks_action_open' => "Taak \"$1\" geopend.",
		'tasks_action_assigned' => "Taak \"$1\" toegewezen.",
		'tasks_action_closed' => "Taak \"$1\" gesloten.",
		'tasks_action_wontfix' => "Taak \"$1\" wordt niet opgelost.",
		
		'tasks_sign_delete' => "<b>Er is een verzoek tot verwijdering van deze pagina ingediend!</b>",
		
		'tasks_logpage' => "Takenlogboek",
		'tasks_logpagetext' => 'Hieronder staan alle wijzigingen aan taken',
		'tasks_logentry' => 'Voor "[[$1]]"',
		
		'tog-show_task_comments' => 'Transcludeer opmerkingenpagina voor taak.',
	)
);

