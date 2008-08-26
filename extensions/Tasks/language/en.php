<?php
/**
 * English language file for the 'Tasks' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
		'tasks_tab' => 'Tasks',
		'tasks_title' => "Tasks for \"$1\"",
		'tasks_form_new' => "Create new task",
		'tasks_form_comment' => "Comment",
		'tasks_error1' => "Task was not created: there is already such a task!",
		'tasks_ok1' => "New task has been created!",
		'tasks_create_header' => "Create a new task",
		'tasks_existing_header' => "Existing tasks",
		'tasks_existing_table_header' => "Task|Dates|Initial comment|Assignment/Actions/Page",
		'tasks_noone' => "no one",
		'tasks_assign_me' => "Assign myself",
		'tasks_assign_to' => "Assign to",
		'tasks_unassign_me' => "Remove my assignment",
		'tasks_close' => "Close task",
		'tasks_wontfix' => "Won't fix",
		'tasks_delete' => "Delete",
		'tasks_no_task_delete_title' => "Not allowed",
		'tasks_no_task_delete_texe' => "You are not allowed to delete a task. Only admins can do that.",
		'tasks_action_delete' => "A task was deleted.",
		'tasks_task_was_deleted' => "The task was successfully deleted.",
		'tasks_reopen' => "Reopen task",
		'tasks_assignedto' => "Assigned to $1",
		'tasks_created_by' => "Created by $1",
		'tasks_discussion_page_link' => "Task discussion page",
		'tasks_closedby' => "Closed by $1",
		'tasks_assigned_myself_log' => "Self-assignment of task \"$1\"",
		'tasks_discussion_page_for' => "This task is for the page \"$1\". The list of all tasks for that page is $2.",
		'tasks_sidebar_title' => "Open tasks",
		'tasks_here' => "here",
		'tasks_returnto' => "You will be redirected now. If you have not been redirected in a few seconds, click $1.",
		'tasks_see_page_tasks' => "(tasks of this page)",
		'tasks_task_is_assigned' => "(assigned)",
		'tasks_plain_text_only' => "(plain text, 256 chars only)",
		'tasks_help_page' => "Tasks",
		'tasks_help_page_link' => "?",
		'tasks_help_separator' => "$2 | $1",
		'tasks_more_like_it' => "more",

		'tasks_task_types' => "1:cleanup:Cleanup|2:wikify:Wikify|3:rewrite:Rewrite|4:delete:Delete|5:create:Create|6:write:Write|7:check:Check",
		'tasks_significance_order' => "rewrite<delete",
		'tasks_creation_tasks' => "5,6",
		
		'tasks_event_on_creation' => "check",
		'tasks_event_on_creation_anon' => "check",
		'tasks_on_creation_comment' => "Automatic task, generated on article creation",
		
		'tasks_link_your_assignments' => "open assignments",
		'tasks_see_your_assignments' => "You currently have $1 open assignments. See your $2.",
		'tasks_my_assignments' => "Your current assignments",
		'tasks_table_header_page' => "Page",
		'tasks_you_have_no_assignments' => "You have no open assignments",
		'tasks_search_form_title' => "Search",
		'tasks_search_tasks' => "Tasks",
		'tasks_search_status' => "Status",
		'tasks_search_no_tasks_chosen_note' => "(No selection here will search all task types.)",
		'tasks_search_results' => "Search results",
		'tasks_previous' => "Previous",
		'tasks_next' => "Next",
		'tasks_sort' => "Sort",
		'tasks_ascending' => "Oldest first",
		'tasks_search_limit' => "10",
		
		'tasks_status_open' => "Open",
		'tasks_status_assigned' => "Assigned",
		'tasks_status_closed' => "Closed",
		'tasks_status_wontfix' => "Won't fix",
		'tasks_action_open' => "Task \"$1\" opened.",
		'tasks_action_assigned' => "Task \"$1\" assigned.",
		'tasks_action_closed' => "Task \"$1\" closed.",
		'tasks_action_wontfix' => "Won't fix task \"$1\".",
		
		'tasks_sign_delete' => "<b>It has been asked to delete this page!</b>",
		
		'tasks_logpage' => "Tasks log",
		'tasks_logpagetext' => 'This is a log of changes to tasks',
		'tasks_logentry' => 'For "[[$1]]"',
		
		'tog-show_task_comments' => 'Transclude task comments page.',
	)
);

