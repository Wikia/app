<?php

/**
 * SiteWideMessages
 *
 * A SiteWideMessages extension for MediaWiki
 * Provides an interface for sending messages seen on all wikis
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2008-01-09
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/SiteWideMessages/SpecialSiteWideMessages.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named SiteWideMessages.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'sitewidemessages'			=> 'Site wide messages',	//the name displayed on Special:SpecialPages
		'swm-page-title-editor'		=> 'Site wide messages :: Editor',
		'swm-page-title-preview'	=> 'Site wide messages :: Preview',
		'swm-page-title-send'		=> 'Site wide messages :: Send',
		'swm-page-title-sent'		=> 'Site wide messages :: Sent',
		'swm-page-title-dismiss'	=> 'Site wide messages :: Dismiss',
		'swm-page-title-list'		=> 'Site wide messages :: List',
		'swm-label-preview'			=> 'Preview',
		'swm-label-edit'			=> 'Edit',
		'swm-label-remove'			=> 'Remove',
		'swm-label-sent'			=> 'Sent',
		'swm-label-list'			=> 'List',
		'swm-label-recipient'		=> 'Recipients',
		'swm-label-recipient-wikis'	=> 'Wikis',
		'swm-label-recipient-users'	=> 'Users',
		'swm-label-expiration'		=> 'Expiration time',
		'swm-label-mode-wikis-all'	=> 'All wikis',
		'swm-label-mode-wikis-hub'	=> 'Selected hub',
		'swm-label-mode-wikis-wiki'	=> 'Selected wiki',
		'swm-label-mode-users-all'	=> 'All users',
		'swm-label-mode-users-active'		=> 'Active users',
		'swm-label-mode-users-group'		=> 'Users belonging to the group',
		'swm-label-mode-users-group-hint'	=> '<i>Pick a group from drop down or write name by hand to overwrite drop down selection.</i>',
		'swm-label-mode-users-user'			=> 'Selected user',
		'swm-label-mode-users-user-hint'	=> '<i>This option ignores selection in group "Wikis".</i>',
		'swm-label-content'			=> 'Content',
		'swm-label-comment'			=> 'Comment',
		'swm-label-dismissed'		=> 'Dismissed',
		'swm-label-language'		=> 'Language',
		'swm-button-lang-checkall'	=> '[ Check all ]',
		'swm-button-lang-checknone'	=> '[ Check none ]',
		'swm-taskmanager-hint'		=> '<i>Note that some options are more time consuming and will be queued in TaskManager.</i>',
		'swm-button-preview'		=> '[ Preview ]',
		'swm-button-send'			=> '[ Send ]',
		'swm-button-save'			=> '[ Save ]',
		'swm-button-new'			=> '[ New ]',
		'swm-msg-sent-ok'			=> '<h3>The message has been sent.</h3>',
		'swm-msg-sent-err'			=> '<h3>The message has NOT been sent.</h3>See error log for more informations.',
		'swm-msg-remove'			=> 'Are you sure you want to remove this message? This can not be undone!',
		'swm-days'					=> 'never,hour,hours,day,days',	//[0] => never expire, [1] => 1 hour, [2] => 2 hours and more, [3] => 1 day, [4] => 2 days and more
		'swm-expire-options'		=> '0,1h,6h,12h,1,3,7,14,30,60',	//0 = never
		'swm-expire-info'			=> 'This message will expire on $1.',
		'swm-link-dismiss'			=> 'dismiss this message',
		'swm-dismiss-content'		=> '<p>The message was dismissed.</p><p>%s</p>',
		'swm-list-no-messages'		=> 'No messages.',
		'swm-list-table-id'			=> 'ID',
		'swm-list-table-sender'		=> 'Sender',
		'swm-list-table-wiki'		=> 'Wiki',
		'swm-list-table-recipient'	=> 'Recipient',
		'swm-list-table-group'		=> 'Group',
		'swm-list-table-expire'		=> 'Expire',
		'swm-list-table-date'		=> 'Send date',
		'swm-list-table-removed'	=> 'Removed',
		'swm-list-table-content'	=> 'Content',
		'swm-list-table-tools'		=> 'Tools',
		'swm-list-table-lang'		=> 'Languages',
		'swm-yes'					=> 'Yes',
		'swm-no'					=> 'No',
		'swm-error-no-such-wiki'	=> 'There is no such wiki!',
		'swm-error-no-such-user'	=> "Specified user doesn't exist.",
		'swm-error-empty-message'	=> 'Enter the content of the message.',
		'swm-error-empty-group'		=> 'Enter the name of the group.',
		'swm-lang-other'		=> 'all remaining languages'
	)
);

$messages['de'] = array(
	'sitewidemessages' => 'Nachricht an Alle',
	'swm-page-title-editor' => 'Nachricht an Alle :: Editor',
	'swm-page-title-preview' => 'Nachricht an Alle :: Vorschau',
	'swm-page-title-send' => 'Nachricht an Alle :: Abschicken',
	'swm-page-title-sent' => 'Nachricht an Alle :: Abgeschickt',
	'swm-page-title-dismiss' => 'Nachricht an Alle :: Ausblenden',
	'swm-page-title-list' => 'Nachricht an Alle :: Übersicht',
	'swm-label-preview' => 'Vorschau',
	'swm-label-edit' => 'Bearbeiten',
	'swm-label-remove' => 'Entfernen',
	'swm-label-sent' => 'Abgeschickt',
	'swm-label-list' => 'Übersicht',
	'swm-label-recipient' => 'Empfänger',
	'swm-label-expiration' => 'Verfallsdatum',
	'swm-label-content' => 'Inhalt',
	'swm-label-comment' => 'Kommentar',
	'swm-label-dismissed' => 'Ausgeblendet',
	'swm-button-preview' => '[ Vorschau ]',
	'swm-button-send' => '[ Abschicken ]',
	'swm-button-save' => '[ Speichern ]',
	'swm-button-new' => '[ Neu ]',
	'swm-msg-sent-ok' => '<h3>Die Nachricht wurde verschickt.</h3>',
	'swm-msg-sent-err' => '<h3>Die Nachricht wurde NICHT verschickt.</h3>
Mehr Informationen findest du im Fehler-Log.',
	'swm-days' => 'nie,Tag,Tage',
	'swm-expire-options' => '0,1,3,7,14,30,60',
	'swm-expire-info' => 'Diese Nachricht wird am $1 ablaufen.',
	'swm-link-dismiss' => 'Nachricht ausblenden',
	'swm-dismiss-content' => '<p>Die Nachricht wurde ausgeblendet.</p><p>%s</p>',
	'swm-list-no-messages' => 'Keine Nachrichten.',
	'swm-list-table-id' => 'ID',
	'swm-list-table-sender' => 'Absender',
	'swm-list-table-wiki' => 'Wiki',
	'swm-list-table-recipient' => 'Empfänger',
	'swm-list-table-group' => 'Gruppe',
	'swm-list-table-expire' => 'Beenden',
	'swm-list-table-date' => 'Versanddatum',
	'swm-list-table-removed' => 'Entfernt',
	'swm-list-table-content' => 'Inhalt',
	'swm-list-table-tools' => 'Tools',
	'swm-yes' => 'Ja',
	'swm-no' => 'Nein',
	'swm-error-no-such-wiki' => 'Es gibt kein solches Wiki!',
	'swm-error-empty-message' => 'Gib den Inhalt der Nachricht ein.',
	'swm-error-empty-group' => 'Gib den Namen der Gruppe ein.',
);


$messages['ja'] = array(
	'sitewidemessages' => 'サイト横断メッセージ',
	'swm-page-title-editor' => 'サイト横断メッセージ:編集',
	'swm-page-title-preview' => 'サイト横断メッセージ:プレビュー',
	'swm-page-title-send' => 'サイト横断メッセージ:送信',
	'swm-page-title-sent' => 'サイト横断メッセージ:送信済',
	'swm-page-title-list' => 'サイト横断メッセージ:リスト',
	'swm-label-preview' => 'プレビュー',
	'swm-label-edit' => '編集',
	'swm-label-remove' => '削除',
	'swm-label-sent' => '送信しました',
	'swm-label-list' => 'リスト',
	'swm-label-recipient' => '宛先',
	'swm-label-expiration' => '期限',
	'swm-label-content' => '内容',
	'swm-label-comment' => 'コメント',
	'swm-button-preview' => '[ プレビュー ]',
	'swm-button-send' => '[ 送信 ]',
	'swm-button-save' => '[ 保存 ]',
	'swm-button-new' => '[ 新規メッセージ ]',
	'swm-msg-sent-ok' => '<h3>メッセージが送信されました。</h3>',
	'swm-msg-sent-err' => '<h3>このメッセージはまだ送信されていません。</h3>詳しくはエラーログをお読みください。',
	'swm-msg-remove' => 'このメッセージの送信をやめますか? この作業は取り消せません!',
	'swm-days' => '期限なし,日,日',
	'swm-expire-info' => 'このメッセージは$1に期限が切れます。',
	'swm-link-dismiss' => 'メッセージを隠す',
	'swm-dismiss-content' => '<p>メッセージが存在しませんでした。</p><p>%s</p>',
	'swm-list-no-messages' => 'メッセージがありません',
	'swm-list-table-sender' => '送信者',
	'swm-list-table-wiki' => 'ウィキ',
	'swm-list-table-recipient' => '宛先',
	'swm-list-table-group' => 'グループ',
	'swm-list-table-expire' => '期限',
	'swm-list-table-date' => '送信日付',
	'swm-list-table-removed' => '削除済',
	'swm-list-table-content' => '内容',
	'swm-list-table-tools' => '作業',
	'swm-error-no-such-wiki' => 'そのようなウィキは存在しません。',
	'swm-error-no-such-user' => '指定された利用者が存在していません。',
	'swm-error-empty-message' => 'メッセージを入力してください。',
	'swm-error-empty-group' => 'グループ名を入力してください。',
);


$messages['es'] = array(
	'swm-label-preview' => 'Previsualización',
	'swm-label-edit' => 'Editar',
	'swm-label-remove' => 'Quitar',
	'swm-label-sent' => 'Enviar',
	'swm-label-list' => 'Lista',
	'swm-label-recipient' => 'Receptor',
	'swm-label-expiration' => 'Tiempo de expiración',
	'swm-label-content' => 'Contenido',
	'swm-label-dismissed' => 'Descartado',
	'swm-button-preview' => '[ Previsualizar ]',
	'swm-button-send' => '[ Enviar ]',
	'swm-button-save' => '[ Guardar ]',
	'swm-button-new' => '[ Nuevo ]',
	'swm-days' => 'nunca,hora,horas,día,días',
	'swm-expire-info' => 'Este mensaje expirará en $1.',
	'swm-link-dismiss' => 'descartar este mensaje',
	'swm-dismiss-content' => '<p>El mensaje fue descartado.</p><p>%s</p>',
	'swm-list-table-sender' => 'Remitente',
	'swm-list-table-recipient' => 'Destinatario',
	'swm-list-table-group' => 'Grupo',
	'swm-list-table-expire' => 'Expira',
	'swm-list-table-date' => 'Fecha de envío',
	'swm-list-table-removed' => 'Quitado',
	'swm-error-no-such-user' => '¡El usuario especificado no existe!',
	'swm-error-empty-message' => 'Introduce el contenido del mensaje.',
	'swm-error-empty-group' => 'Introduce el nombre del grupo.',
);


$messages['fr'] = array(
	'swm-label-mode-wikis-all' => 'Tous les wikis',
);
