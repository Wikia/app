<?php
/**
 * French language file for the 'Tasks' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
		'tasks_tab' => 'Tâches',
		'tasks_title' => 'Tâches pour « $1 »',
		'tasks_form_new' => 'Créer tâche',
		'tasks_form_comment' => 'Commentaire',
		'tasks_error1' => 'Tâche non créée : il existe déjà une tâche de ce type !',
		'tasks_ok1' => 'Nouvelle tâche créée !',
		'tasks_create_header' => 'Créer une nouvelle tâche',
		'tasks_existing_header' => 'Tâches existantes',
		'tasks_existing_table_header' => 'Tâche|Dates|Commentaire|Assignement/Actions/Page',
		'tasks_noone' => 'aucune',
		'tasks_assign_me' => 'Me l’assigner',
		'tasks_unassign_me' => 'Me désassigner',
		'tasks_close' => 'Clôturer',
		'tasks_wontfix' => "Ne sera pas réparée",
		'tasks_reopen' => 'Réouvrir',
		'tasks_assignedto' => 'Assignée à $1',
		'tasks_created_by' => 'Créée par $1',
		'tasks_discussion_page_link' => 'Discuter de la tâche',
		'tasks_closedby' => 'Fermée par $1',
		'tasks_assigned_myself_log' => 'Auto assignement de la tâche « $1 »',
		'tasks_discussion_page_for' => 'Cette tâche est pour la page « $1 ». La liste de toutes les tâches de cette page est $2.',
		'tasks_sidebar_title' => 'Tâches en cours',
		'tasks_here' => 'ici',
		'tasks_returnto' => 'Vous allez être redirigé maintenant. Si vous ne l’êtes pas, cliquez $1.',
		'tasks_see_page_tasks' => '(tâches de la page)',
		'tasks_task_is_assigned' => '(assignée)',
		'tasks_plain_text_only' => '(texte brut seulement)',
		'tasks_help_page' => 'Tâches',
		'tasks_help_page_link' => '?',
		'tasks_help_separator' => '$2 | $1',
		'tasks_more_like_it' => 'plus',

		'tasks_task_types' => "1:cleanup:Cleanup|2:wikify:Wikify|3:rewrite:Rewrite|4:delete:Delete|5:create:Create|6:write:Write",
		'tasks_significance_order' => 'réécrire<supprimer',
		'tasks_creation_tasks' => "5,6",
//		'tasks_link_your_assignments' => "open assignments",
		'tasks_see_your_assignments' => 'Vous avez actuellement $1 tâches assignées. Voyez vos $2.',
		'tasks_my_assignments' => 'Vos assignements en cours',
		'tasks_table_header_page' => 'Page',
		'tasks_you_have_no_assignments' => 'Vous n’avez aucune tâche',
		'tasks_search_form_title' => 'Chercher',
		'tasks_search_tasks' => 'Tâches',
		'tasks_search_status' => 'Statut',
		'tasks_search_no_tasks_chosen_note' => '(Aucune sélection, recherche de tous types de tâches.)',
		'tasks_search_results' => 'Résultats de recherche',
		'tasks_previous' => 'Précédent',
		'tasks_next' => 'Suivant',
		'tasks_sort' => 'Trier',
		'tasks_ascending' => 'Plus anciennes d’abord',
		'tasks_search_limit' => '10',
		
		'tasks_status_open' => 'Ouverte',
		'tasks_status_assigned' => 'Assignée',
		'tasks_status_closed' => 'Fermée',
//		'tasks_status_wontfix' => "Won't fix",
		'tasks_action_open' => 'Tâche « $1 » ouverte.',
		'tasks_action_assigned' => 'Tâche « $1 » assignée.',
		'tasks_action_closed' => 'Tâche « $1 » fermée.',
//		'tasks_action_wontfix' => 'Won\'t fix task « $1 ».',
		
//		'tasks_sign_delete' => "<b>They want it dead! Kaaaaaaaahn!</b>",
		
		'tasks_logpage' => 'Historique des tâches',
		'tasks_logpagetext' => 'Ceci est un historique des changements dans les tâches',
		'tasks_logentry' => 'Pour « [[$1]] »',
		
//		'tog-show_task_comments' => 'Transclude task comments page.',
	)
);

