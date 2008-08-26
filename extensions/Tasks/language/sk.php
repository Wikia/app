<?php
/**
 * Slovak language file for the 'Tasks' extension, by helix84
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
		'tasks_tab' => 'Úlohy',
		'tasks_title' => "Úlohy pre \"$1\"",
		'tasks_form_new' => "Vytvoriť novú úlohu",
		'tasks_form_comment' => "Komentár",
		'tasks_error1' => "Úloha nebola vytvorená: taká úloha už existuje!",
		'tasks_ok1' => "Nová úloha bola vytvorená!",
		'tasks_create_header' => "Vytvoriť novú úlohu",
		'tasks_existing_header' => "Existujúce úlohy",
		'tasks_existing_table_header' => "Úlohy|Dátumy|Úvodný komentár|Pridelenie/Činnosti/Stránka",
		'tasks_noone' => "nikto",
		'tasks_assign_me' => "Prideliť sebe",
		'tasks_assign_to' => "Prideliť pre",
		'tasks_unassign_me' => "Odstrániť pridelenie mne",
		'tasks_close' => "Zatvoriť úlohu",
		'tasks_wontfix' => "Neopravíme",
		'tasks_delete' => "Zmazať",
		'tasks_no_task_delete_title' => "Nepovolené",
		'tasks_no_task_delete_texe' => "Nemáte povolenie zmazať úlohu. To môžu iba správci.",
		'tasks_action_delete' => "Úloha bola zmazaná.",
		'tasks_task_was_deleted' => "Úloha bola úspešne zmazaná.",
		'tasks_reopen' => "Znovuotvoriť úlohu",
		'tasks_assignedto' => "Pridelené pre $1",
		'tasks_created_by' => "Vytvoril $1",
		'tasks_discussion_page_link' => "Diskusná stránka úlohy",
		'tasks_closedby' => "Zatvoril $1",
		'tasks_assigned_myself_log' => "Úlohu priradil sebe \"$1\"",
		'tasks_discussion_page_for' => "Táto úloha je pre stránku \"$1\". Zoznam všetkých úloh pre túto stránku je $2.",
		'tasks_sidebar_title' => "Otvorené úlohy",
		'tasks_here' => "tu",
		'tasks_returnto' => "Teraz budete presmerovaní. Ak nebudete presmerovaní do niekoľkých sekúnd, kliknite na $1.",
		'tasks_see_page_tasks' => "(úlohy k tejto stránke)",
		'tasks_task_is_assigned' => "(pridelené)",
		'tasks_plain_text_only' => "(čistý text, max. 256 znakov)",
		'tasks_help_page' => "Úlohy",
		'tasks_help_page_link' => "?",
		'tasks_help_separator' => "$2 | $1",
		'tasks_more_like_it' => "viac",

		'tasks_task_types' => "1:cleanup:Vyčistiť|2:wikify:Wikifikácia|3:rewrite:Prepísať|4:delete:Zmazať|5:create:Vytvoriť|6:write:Napísať|7:check:Skontolovať",
		'tasks_significance_order' => "rewrite<delete",
		'tasks_creation_tasks' => "5,6",

		'tasks_event_on_creation' => "skontrolovať",
		'tasks_event_on_creation_anon' => "skontrolovať",
		'tasks_on_creation_comment' => "Automatický úloha, vygenerovaná pri vytvorení článku",

		'tasks_link_your_assignments' => "otvoriť pridelené úlohy",
		'tasks_see_your_assignments' => "Momentálne máte $1 otvorených pridelených úloh. Pozrite si váš $2.",
		'tasks_my_assignments' => "Vaše súčasné pridelené úlohy",
		'tasks_table_header_page' => "Stránka",
		'tasks_you_have_no_assignments' => "Nemáte otvorené pridelené úlohy",
		'tasks_search_form_title' => "Hľadať",
		'tasks_search_tasks' => "Úlohy",
		'tasks_search_status' => "Stav",
		'tasks_search_no_tasks_chosen_note' => "(Žiadny výber odtiaľto nevyhľadá všetky typy úloh.)",
		'tasks_search_results' => "Výsledky vyhľadávania",
		'tasks_previous' => "Predchádzajúce",
		'tasks_next' => "Nasledovné",
		'tasks_sort' => "Triediť",
		'tasks_ascending' => "Najstaršie na začiatku",
		'tasks_search_limit' => "10",

		'tasks_status_open' => "Otvorená",
		'tasks_status_assigned' => "Pridelená",
		'tasks_status_closed' => "Zatvorená",
		'tasks_status_wontfix' => "Neopravíme",
		'tasks_action_open' => "Úloha \"$1\" bola otvorená.",
		'tasks_action_assigned' => "Úloha \"$1\" bola pridelená.",
		'tasks_action_closed' => "Úloha \"$1\" bola zatvorená.",
		'tasks_action_wontfix' => "Neopravíme úlohu \"$1\".",

		'tasks_sign_delete' => "<b>Bolo žiadané zmazanie tejto stránky!</b>",

		'tasks_logpage' => "Záznam úloh",
		'tasks_logpagetext' => 'Toto je záznam zmien v úlohách',
		'tasks_logentry' => 'Pre "[[$1]]"',

		'tog-show_task_comments' => 'Transklúzia diskusnej stránky úlohy.',
	)
);

