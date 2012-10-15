<?php
/**
 * Group-level based edit page access for MediaWiki. Monitors current edit sessions.
 * Version 0.4.2
 *
 */

/**
 * Messages list.
 */

$messages = array();

/** English (English)
 * @author QuestPC
 */
$messages['en'] = array(
	'currentedits' => 'Monitors current edit sessions',
	'editconflict_desc' => 'Group-level based edit page access. Monitors current edit sessions.',
	'ec_already_editing'=>'The user which has a higher group weight<br />already edits this page.<br/>Please wait until he/she ends the editing session.',
	'ec_close_warning'=>'Close warning',
	'ec_copied_revisions'=>'Following your edits were copied into the subpage of your userpage due to edit conflict with another user who belongs to usergroup of higher weight than yours:',
	'ec_header_warning'=>'Warning: user edits which has (group weight = 0) are not included to reduce server load',
	'ec_order_page'=>'page title',
	'ec_order_user'=>'user name',
	'ec_order_time'=>'editing time',
	'ec_header_order'=>'Order by: $1, $2, $3.',
	'ec_list_order_page'=>'$1, $2 (weight=$3), editing time $4. Click to close: $5',
	'ec_list_order_user'=>'$2 (weight=$3), $1, editing time $4. Click to close: $5',
	'ec_list_order_time'=>'Editing time $4, $1, $2 (weight=$3). Click to close: $5',
	'ec_time_sprintf'=>'%02d:%02d:%02d'
);

/** Russian (Русский)
 * @author QuestPC
 */
$messages['ru'] = array(
	'currentedits' => 'Просмотр текущих сессий редактирования',
	'editconflict_desc' => 'Доступ к странице правки в соответствии с правами группы. Просмотр текущих сессий редактирования.',
	'ec_already_editing'=>'Пользователь с более высоким статусом<br />уже редактирует данную страницу.<br/>Пожалуйста подождите окончания редактирования.',
	'ec_close_warning'=>'Закрыть предупреждение',
	'ec_copied_revisions'=>'Следующие Ваши правки были перенесены в подстраницу Вашей пользовательской страницы из-за конфликта правок с пользователем, имеющим более высокий статус чем Ваш:',
	'ec_header_warning'=>'Предупреждение: сессии правок пользователей, входящих в группы с минимальным приоритетом (вес = 0) не включаются в список для уменьшения нагрузки на сервер',
	'ec_order_page'=>'названию страницы',
	'ec_order_user'=>'имени пользователя',
	'ec_order_time'=>'времени с начала редактирования',
	'ec_header_order'=>'Сортировать по: $1, $2, $3.',
	'ec_list_order_page'=>'$1, $2 (вес=$3), время редактирования $4. Закрыть: $5',
	'ec_list_order_user'=>'$2 (вес=$3), $1, время редактирования $4. Закрыть: $5',
	'ec_list_order_time'=>'Время редактирования $4, $1, $2 (вес=$3). Закрыть: $5'
);
