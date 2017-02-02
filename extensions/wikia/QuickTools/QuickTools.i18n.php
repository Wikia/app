<?php
/** Internationalization file for /extensions/wikia/QuickTools/QuickTools extension. */
$messages = [];

$messages['en'] = [
	'quicktools' => 'QuickTools',
	'quicktools-desc' => 'A collection of tools to make fighting spam and vandalism, and other tasks for staff and volunteers easier',
	'right-quicktools' => 'Quickly revert and delete spam and vandalism',
	'right-quickadopt' => 'Quickly grant rights when approving adoption requests',
	'quicktools-contrib-link' => 'Quick Tools',
	'quicktools-invalidtime' => 'Invalid time provided.',
	'quicktools-notitles' => 'No titles to revert or delete.',
	'quicktools-success' => 'Successfully reverted edits by $1.',
	'quicktools-success-rollback' => 'Successfully reverted edits by $1.',
	'quicktools-success-delete' => 'Successfully deleted page creations by $1.',
	'quicktools-success-rollback-delete' => 'Successfully reverted and deleted edits and page creations by $1.',
	'quicktools-permissionerror' => 'You do not have the appropriate permissions to use Quick Tools.',
	'quicktools-tokenerror' => 'Token was not provided or is incorrect.',
	'quicktools-posterror' => 'This action must be posted.',
	'quicktools-modal-title' => 'Quick Tools &mdash; $1',
	'quicktools-rollback-all' => 'Rollback all',
	'quicktools-delete-all' => 'Delete all',
	'quicktools-revert-all' => 'Rollback and delete',
	'quicktools-block' => 'Block',
	'quicktools-block-and-revert' => 'All of the above',
	'quicktools-label-reason' => 'Reason:',
	'quicktools-label-default-reason' => '[[w:help:Spam|spam]]',
	'quicktools-label-time' => 'Perform actions on edits since:',
	'quicktools-label-block-length' => 'Block length:',
	'quicktools-placeholder-time' => 'yyyy-mm-dd hh:mm:ss',
	'quicktools-success-block' => 'Successfully blocked $1.',
	'quicktools-bot-reason' => 'Cleanup',
	'quicktools-botflag-add' => 'Bot me',
	'quicktools-botflag-remove' => 'Unbot me',
	'quicktools-createuserpage-link' => 'Create user page',
	'quicktools-createuserpage-reason' => 'Creating user page',
	'quicktools-createuserpage-success' => 'Successfully created page!',
	'quicktools-createuserpage-exists' => 'User page already exists!',
	'quicktools-createuserpage-error' => 'Creating page failed!',
	'quicktools-adopt-contrib-link' => 'Quick Adopt',
	'quicktools-adopt-reason' => 'Adopting Wiki',
	'quicktools-adopt-success' => 'User rights change succeeded!',
	'quicktools-adopt-error' => 'User rights change failed!',
	'quicktools-adopt-confirm' => 'Are you sure you want to grant this user administrator and bureaucrat rights?',
	'quicktools-adopt-confirm-ok' => 'Yes',
	'quicktools-adopt-confirm-cancel' => 'No',
	'quicktools-adopt-confirm-title' => 'Confirm Adoption',
];

$messages['qqq'] = [
	'quicktools' => 'Extension name',
	'quicktools-desc' => '{{desc}}',
	'right-quicktools' => '{{doc-right|quicktools}}',
	'right-quickadopt' => '{{doc-right|quickadopt}}',
	'quicktools-contrib-link' => 'Link name on Special:Contributions.',
	'quicktools-invalidtime' => 'Error message displayed when an invalid time is provided.',
	'quicktools-notitles' => 'Error message displayed when there are no titles to revert for the user',
	'quicktools-success' => 'Success message when the tool completes reverting the user.',
	'quicktools-success-rollback' => 'Success message when the tool completes reverting the user.',
	'quicktools-success-delete' => 'Success message when the tool completes deleting the user\'s page creations.',
	'quicktools-success-rollback-delete' => 'Success message when the tool completes reverting and deleting the user\'s edits and page creations. $1 is the user name of the user whose edits were reverted or deleted',
	'quicktools-permissionerror' => 'Permissions error returned by script when user does not have the appropriate rights.',
	'quicktools-tokenerror' => 'Error returned when provided token is not provided or is incorrect.',
	'quicktools-posterror' => 'Error returned when the request needed to be a POST request.',
	'quicktools-modal-title' => 'The popup menu title. $1 is the user name.',
	'quicktools-rollback-all' => 'Label for button to rollback all user edits.',
	'quicktools-delete-all' => 'Label for button to delete all user page creations.',
	'quicktools-revert-all' => 'Label for button to rollback and delete all user edits and page creations.',
	'quicktools-block' => 'Label for button to block user.',
	'quicktools-block-and-revert' => 'Label for button to rollback and delete all user edits and page creations as well as block user all at once.',
	'quicktools-label-reason' => 'Label for the reason field which will be used as the revert and deletion summary.',
	'quicktools-label-default-reason' => 'Default reason for reverting and deleting.',
	'quicktools-label-time' => 'Label for timestamp to revert back to.',
	'quicktools-label-block-length' => 'Label for block expiration time.',
	'quicktools-placeholder-time' => 'Placeholder text in the timestamp input box that shows the format the timestamp should be in.',
	'quicktools-success-block' => 'Success message when the tool successfully blocks a user. $1 is the name of the user who was blocked.',
	'quicktools-bot-reason' => 'Reason for adding bot flag',
	'quicktools-botflag-add' => 'Label for button to add bot flag',
	'quicktools-botflag-remove' => 'Label for button to remove bot flag',
	'quicktools-createuserpage-link' => 'Link in the account navigation menu to create user page.',
	'quicktools-createuserpage-reason' => 'Edit summary used when creating user page',
	'quicktools-createuserpage-success' => 'Success message displayed when user page was successfully created',
	'quicktools-createuserpage-exists' => 'Message displayed when the user page already exists',
	'quicktools-createuserpage-error' => 'Error message shown when creating user page failed',
	'quicktools-adopt-contrib-link' => 'Link name on Special:Contributions for approving adoption request for user',
	'quicktools-adopt-reason' => 'Summary used in the rights change when approving adoption request for user',
	'quicktools-adopt-success' => 'Success message displayed when user rights change was successful',
	'quicktools-adopt-error' => 'Error message displayed when user rights change failed',
	'quicktools-adopt-confirm' => 'Message shown in a prompt to check that user wants to give the user rights',
	'quicktools-adopt-confirm-ok' => 'Message for the OK button in the confirm dialog',
	'quicktools-adopt-confirm-cancel' => 'Message for the cancel button in the confirm dialog',
	'quicktools-adopt-confirm-title' => 'Title of confirm dialog',
];

$messages['es'] = [
	'quicktools-adopt-contrib-link' => 'Adopción Rápida',
	'quicktools-adopt-error' => '¡Falló el cambio de permisos de usuario!',
	'quicktools-adopt-reason' => 'Adoptando el wiki',
	'quicktools-adopt-success' => '¡Cambiados los permisos de usuario!',
	'quicktools-block-and-revert' => 'Todo lo anterior',
	'quicktools-block' => 'Bloquear',
	'quicktools-botflag-add' => 'Darme bot',
	'quicktools-botflag-remove' => 'Quitarme bot',
	'quicktools-contrib-link' => 'RapiTareas',
	'quicktools-createuserpage-error' => '¡Falló al crear la página!',
	'quicktools-createuserpage-exists' => '¡La página de usuario ya existe!',
	'quicktools-createuserpage-link' => 'Crear página de usuario',
	'quicktools-createuserpage-success' => '¡La página se creó satisfactoriamente!',
	'quicktools-delete-all' => 'Borrar todo',
	'quicktools-desc' => 'Una colección de herramientas para combatir fácilmente el spam y el vandalismo, y otras tareas para el staff y usuarios voluntarios',
	'quicktools-invalidtime' => 'Fecha y hora inválidas',
	'quicktools-label-block-length' => 'Duración del bloqueo:',
	'quicktools-label-default-reason' => '[[w:Help:Spam|Spam]]',
	'quicktools-label-reason' => 'Motivo:',
	'quicktools-label-time' => 'Realizar acciones desde:',
	'quicktools-modal-title' => 'RapiTareas &mdash; $1',
	'quicktools-notitles' => 'No hay títulos que revertir',
	'quicktools-permissionerror' => 'No tienes los permisos apropiados para usar Quick Tools.',
	'quicktools-revert-all' => 'Revertir y borrar',
	'quicktools-rollback-all' => 'Revertir todo',
	'quicktools-success-block' => '$1 ha sido bloqueado.',
	'quicktools-success-delete' => 'Borradas las páginas creadas por $1.',
	'quicktools-success-rollback-delete' => 'Revertidas y borradas las ediciones y las páginas creadas por $1.',
	'quicktools-success-rollback' => 'Revertidas las ediciones de $1.',
	'quicktools-success' => 'Revertidas las ediciones de $1.',
	'quicktools' => 'RapiTareas',
];

$messages['pl'] = [
	'quicktools-adopt-contrib-link' => 'Adopcja',
	'quicktools-adopt-error' => 'Zmiana uprawnień użytkownika nie powiodła się!',
	'quicktools-adopt-reason' => 'Adopcja wiki',
	'quicktools-adopt-success' => 'Zmiana uprawnień użytkownika powiodła się!',
	'quicktools-block-and-revert' => 'Wszystkie powyższe',
	'quicktools-block' => 'Zablokuj',
	'quicktools-bot-reason' => 'Porządki',
	'quicktools-botflag-add' => 'Flaga bota',
	'quicktools-botflag-remove' => 'Zdejmij flagę bota',
	'quicktools-contrib-link' => 'Narzędzia',
	'quicktools-createuserpage-error' => 'Tworzenie strony nie powiodło się!',
	'quicktools-createuserpage-exists' => 'Profil użytkownika już istnieje!',
	'quicktools-createuserpage-link' => 'Utwórz profil',
	'quicktools-createuserpage-reason' => 'Tworzenie profilu użytkownika',
	'quicktools-createuserpage-success' => 'Utworzono profil!',
	'quicktools-delete-all' => 'Usuń wszystko',
	'quicktools-desc' => 'Zbiór narzędzi ułatwiających walkę ze spamem i wandalizmem a także wykonywaniem innych zadań pracowników i wolontariuszy Wikii.',
	'quicktools-invalidtime' => 'Niewłaściwy limit czasu',
	'quicktools-label-block-length' => 'Czas trwania blokady:',
	'quicktools-label-default-reason' => 'Spam',
	'quicktools-label-reason' => 'Powód:',
	'quicktools-label-time' => 'Wykonaj na edycjach od:',
	'quicktools-modal-title' => 'Narzędzia &mdash; $1',
	'quicktools-notitles' => 'Brak stron do odwrócenia zmian',
	'quicktools-permissionerror' => 'Nie masz uprawnień do korzystania z tych narzędzi.',
	'quicktools-revert-all' => 'Cofnij i usuń',
	'quicktools-rollback-all' => 'Cofnij wszystko',
	'quicktools-success-block' => 'Zablokowano użytkownika $1.',
	'quicktools-success-delete' => 'Usunięto strony utworzone przez użytkownika $1.',
	'quicktools-success-rollback-delete' => 'Usunięto strony i edycje wykonane przez użytkownika $1.',
	'quicktools-success-rollback' => 'Wycofano edycje użytkownika $1.',
	'quicktools-success' => 'Wycofano edycje użytkownika $1.',
	'quicktools' => 'Narzędzia',
];

$messages['fr'] = [
	'quicktools-desc' => 'Divers outils pour rendre le combat contre le spam et le vandalisme et autres tâches du staff plus simple',
];

$messages['it'] = [
	'quicktools-createuserpage-link' => 'Crea pagina utente',
];

$messages['ja'] = [
	'quicktools-createuserpage-exists' => 'ユーザーページはすでに作成されています。',
	'quicktools-createuserpage-link' => 'ユーザーページ作成',
	'quicktools-createuserpage-success' => 'ユーザーページの作成に成功しました。',
];

$messages['ko'] = [
	'quicktools-createuserpage-error' => '문서를 생성하는 데에 실패했습니다!',
	'quicktools-createuserpage-exists' => '사용자 문서가 이미 존재합니다!',
	'quicktools-createuserpage-link' => '사용자 문서 생성',
	'quicktools-createuserpage-reason' => '사용자 문서 생성하는 중...',
];

$messages['zh'] = [
	'quicktools-createuserpage-exists' => '用户页面已存在！',
	'quicktools-createuserpage-link' => '创建用户页面',
];

$messages['zh-hans'] = [
	'quicktools-createuserpage-exists' => '用户页面已存在！',
	'quicktools-createuserpage-link' => '创建用户页面',
];

$messages['zh-hant'] = [
	'quicktools-createuserpage-exists' => '用戶頁面已存在！',
	'quicktools-createuserpage-link' => '創建用戶頁面',
];

$messages['zh-hk'] = [
	'quicktools-createuserpage-exists' => '用戶頁面已存在！',
	'quicktools-createuserpage-link' => '創建用戶頁面',
];

$messages['zh-tw'] = [
	'quicktools-createuserpage-exists' => '用戶頁面已存在！',
	'quicktools-createuserpage-link' => '創建用戶頁面',
];

