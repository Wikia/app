<?php
/**
 * Forum extension namespaces file
 */

$namespaces = [ ];

/**
 * English (English)
 */
$namespaces['en'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Board',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Topic',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Board_Thread',
];

/**
 * German (Deutsch)
 */
$namespaces['de'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Diskussionsforum',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Thema',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Forum-Diskussionsfaden',
];

/**
 * Spanish (Español)
 */
$namespaces['es'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Subforo',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Tema',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Tema_del_foro',
];

/**
 * Finnish (Suomi)
 */
$namespaces['fi'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Palsta',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Aihe',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Palstan_ketju',
];

/**
 * French (Français)
 */
$namespaces['fr'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Sous-forum',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Sujet',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Fil_de_forum',
];

/**
 * Hungarian (magyar)
 * @author TK-999
 */
$namespaces['hu'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Aloldal',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Téma',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Aloldali_beszélgetésfolyam',
];

/**
 * Italian (Italiano)
 */
$namespaces['it'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Sottoforum',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Argomento',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Discussione_forum',
];

/**
 * Japanese (日本語)
 */
$namespaces['ja'] = [
	NS_WIKIA_FORUM_BOARD		=> 'ボード',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'トピック',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'ボード・スレッド',
];

/**
 * Korean (한국어)
 */
$namespaces['ko'] = [
	NS_WIKIA_FORUM_BOARD		=> '게시판',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> '주제',
	NS_WIKIA_FORUM_BOARD_THREAD	=> '게시판_글',
];

/**
 * Dutch (Nederlands)
 */
$namespaces['nl'] = [
	// "Board" and "Topic" are the same as English
	// but case varies for "Board_Thread"
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Board_thread',
];

/**
 * Polish (Polski)
 */
$namespaces['pl'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Subforum',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Temat',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Wątek_forum',
];

/**
 * Portuguese (Português)
 */
$namespaces['pt'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Quadro',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Tópico',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Conversa_no_quadro',
];

/**
 * Brazilian Portuguese (Português do Brasil)
 */
$namespaces['pt-br'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Quadro',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Tópico',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Conversa_no_quadro',
];

/**
 * Ukrainian (Українська)
 */
$namespaces['uk'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Головна_тема',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Спільна_тема',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Тема_форума'
];

/**
 * Russian (Русский)
 */
$namespaces['ru'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Главная_тема',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Общая_тема',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Тема_форума',
];

/**
 * Vietnamese (Tiếng Việt)
 */
$namespaces['vi'] = [
	NS_WIKIA_FORUM_BOARD		=> 'Bảng',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> 'Vấn_đề',
	NS_WIKIA_FORUM_BOARD_THREAD	=> 'Luồng_bảng',
];

/**
 * Chinese (中文)
 */
$namespaces['zh'] = [
	NS_WIKIA_FORUM_BOARD		=> '版块',
	NS_WIKIA_FORUM_TOPIC_BOARD	=> '话题',
	NS_WIKIA_FORUM_BOARD_THREAD	=> '版块帖子',
];

/**
 * Aliases
 */
$namespaceAliases = [
	// Japanese (日本語)
	// VOLDEV-90
	'ボード_スレッド' => NS_WIKIA_FORUM_BOARD_THREAD,
];
