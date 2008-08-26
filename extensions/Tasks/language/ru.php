<?php
/**
 * Russian language file for the 'Tasks' extension
 */

// We will add messages to the global cache
global $wgMessageCache;

// Add messages
$wgMessageCache->addMessages(
	array(
		'tasks_tab' => 'Задачи',
		'tasks_title' => "Задачи для «$1»",
		'tasks_form_new' => "Установить новую задачу",
		'tasks_form_comment' => "Примечание",
		'tasks_error1' => "Задача не была установлена: уже существует такая задача!",
		'tasks_ok1' => "Была установлена новая задача!",
		'tasks_create_header' => "Создание новой задачи",
		'tasks_existing_header' => "Существующие задачи",
		'tasks_existing_table_header' => "Задача|Даты|Первоначальное примечание|Назначен/Действия/Страница",
		'tasks_noone' => "никто",
		'tasks_assign_me' => "Взять задачу себе",
		'tasks_assign_to' => "Назначить участнику",
		'tasks_unassign_me' => "Убрать моё назначение",
		'tasks_close' => "Закрыть задачу",
		'tasks_wontfix' => "Не будет решаться",
		'tasks_delete' => "Удалить",
		'tasks_no_task_delete_title' => "Нет доступа",
		'tasks_no_task_delete_texe' => "Вам не разрешено удалять задания. Это могут делать только администраторы.",
		'tasks_action_delete' => "Задание было удалено.",
		'tasks_task_was_deleted' => "Заданиче было успешно удалено.",
		'tasks_reopen' => "Открыть задачу вновь",
		'tasks_assignedto' => "Назначено участнику $1",
		'tasks_created_by' => "Создано участником $1",
		'tasks_discussion_page_link' => "страница обсуждение задачи",
		'tasks_closedby' => "Закрыта участником $1",
		'tasks_assigned_myself_log' => "Самоназначение на задачу «$1»",
		'tasks_discussion_page_for' => "Это задача для страницы «$1». Список всех задач для этой страницы $2.",
		'tasks_sidebar_title' => "Открытые задачи",
		'tasks_here' => "здесь",
		'tasks_returnto' => "Сейчас вы будите перенаправлены. Если вы не были перенаправлены в течение нескольких секунд, нажмите $1.",
		'tasks_see_page_tasks' => "(задачи этой страницы)",
		'tasks_task_is_assigned' => "(назначена)",
		'tasks_plain_text_only' => "(простой текст, не более 256 символов)",
		'tasks_help_page' => "Задачи",
		'tasks_help_page_link' => "?",
		'tasks_help_separator' => "$2 | $1",
		'tasks_more_like_it' => "далее",

		'tasks_task_types' => "1:cleanup:Почистить|2:wikify:Викифицировать|3:rewrite:Переписать|4:delete:Удалить|5:create:Создать|6:write:Написать|7:check:Проверить",
		'tasks_significance_order' => "rewrite<delete",
		'tasks_creation_tasks' => "5,6",
		
		'tasks_event_on_creation' => "проверить",
		'tasks_event_on_creation_anon' => "проверить",
		'tasks_on_creation_comment' => "Автоматическая задача, установлена после создания статьи",
		
		'tasks_link_your_assignments' => "текущие назначения",
		'tasks_see_your_assignments' => "У вас сейчас $1 назначений. См. ваш $2.",
		'tasks_my_assignments' => "Ваши текущие назначений",
		'tasks_table_header_page' => "Страница",
		'tasks_you_have_no_assignments' => "У вас нет текущих назначений",
		'tasks_search_form_title' => "Поиск",
		'tasks_search_tasks' => "Задачи",
		'tasks_search_status' => "Статус",
		'tasks_search_no_tasks_chosen_note' => "(если здесь ничего не выбрано, то будут искаться все типы задач)",
		'tasks_search_results' => "Результаты поиска",
		'tasks_previous' => "назад",
		'tasks_next' => "Далее",
		'tasks_sort' => "Сортировка",
		'tasks_ascending' => "Старые первыми",
		'tasks_search_limit' => "10",
		
		'tasks_status_open' => "Открыта",
		'tasks_status_assigned' => "Назначена",
		'tasks_status_closed' => "Закрыта",
		'tasks_status_wontfix' => "Не будет решаться",
		'tasks_action_open' => "Открыта задача «$1».",
		'tasks_action_assigned' => "Задача «$1» назначена.",
		'tasks_action_closed' => "Закрыта задача «$1».",
		'tasks_action_wontfix' => "Задача «$1» не будет решаться.",
		
		'tasks_sign_delete' => "<b>Был запрос на удаление этой страницы!</b>",
		
		'tasks_logpage' => "Журнал задач",
		'tasks_logpagetext' => 'Это журнал изменения задач',
		'tasks_logentry' => 'Для «[[$1]]»',
		
		'tog-show_task_comments' => 'Включить страницу примечаний задачи.',
	)
);

