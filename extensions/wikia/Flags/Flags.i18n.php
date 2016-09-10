<?php
$messages = array();

$messages['en'] = array(
	'flags-description' => 'Flags are per article information for reader or editors that describe the content or action required',
	'flags-special-title' => 'Manage Flags',
	'flags-special-header-text' => 'Built on top of the notice templates you already know and use, Flags allow for more powerful article organization, management, and labeling than ever before. Visit [[Help:Flags]] to learn more.',
	'flags-special-zero-state' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]].",
	'flags-special-create-button-text' => 'Create a flag',
	'flags-special-create-form-title-new' => 'Create a flag',
	'flags-special-create-form-title-edit' => 'Edit the flag',
	'flags-special-create-form-name' => 'Name:',
	'flags-special-create-form-template' => 'Template:',
	'flags-special-create-form-group' => 'Group:',
	'flags-special-create-form-targeting' => 'Targeting:',
	'flags-special-create-form-parameters' => 'Parameters:',
	'flags-special-create-form-parameters-name' => 'Name',
	'flags-special-create-form-parameters-description' => 'Description',
	'flags-special-create-form-parameters-add' => 'Add a new parameter',
	'flags-special-create-form-cancel' => 'Cancel',
	'flags-special-create-form-save' => 'Save',
	'flags-special-create-form-invalid-name' => 'Please enter an appropriate name for the flag.',
	'flags-special-create-form-invalid-name-exists' => 'The name of the flag is already used. Please, choose another one.',
	'flags-special-create-form-invalid-template' => 'Please enter an appropriate name of a template for the flag.',
	'flags-special-create-form-invalid-param-name' => 'Please enter an appropriate names for all parameters or remove the empty ones.',
	'flags-special-create-form-save-success' => 'The flag has been added!',
	'flags-special-create-form-save-failure' => 'Unfortunately, an error happened. Can you try again?',
	'flags-special-create-form-save-nochange' => 'It seems that no changes were made.',
	'flags-special-create-form-no-parameters' => 'No parameters were found in the given template.',
	'flags-special-create-form-fetch-params' => 'Get parameters already used in the template',
	'flags-special-autoload-delete-confirm' => 'Deleting the $1 flag will also remove it from all articles. This cannot be undone. Are you sure?',
	'flags-special-autoload-delete-success' => 'The flag has been successfully removed.',
	'flags-special-autoload-delete-error' => 'Unfortunately, we were not able to remove the flag. Please try again or contact us.',
	'flags-special-list-header-name' => 'Flag name',
	'flags-special-list-header-template' => 'Template name',
	'flags-special-list-header-group' => 'Flag group',
	'flags-special-list-header-target' => 'Target',
	'flags-special-list-header-parameters' => 'Parameters',
	'flags-special-list-header-actions' => 'Actions',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|See Fandom Flags in action!]]',
	'flags-edit-flags-button-text' => 'Edit flags',
	'flags-edit-form-more-info' => 'More info >',
	'flags-edit-modal-cancel-button-text' => 'Cancel',
	'flags-edit-modal-close-button-text' => 'Close',
	'flags-edit-modal-done-button-text' => 'Done',
	'flags-edit-modal-no-flags-on-community' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]] or [[Special:Flags|define the flags for this community]].",
	'flags-edit-modal-title' => 'Flags',
	'flags-edit-modal-exception' => 'Unfortunately, we are not able to display this due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Fandom support team if you continue to see this issue.',
	'flags-edit-modal-post-exception' => 'Unfortunately, we are not able to complete the process due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Fandom support team if you continue to see this issue.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Disambiguation',
	'flags-groups-canon' => 'Canon',
	'flags-groups-stub' => 'Stub',
	'flags-groups-delete' => 'Delete',
	'flags-groups-improvements' => 'Improvements',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Other',
	'flags-groups-navigation' => 'Navigation',
	'flags-target-readers' => 'Readers',
	'flags-target-contributors' => 'Contributors',
	'flags-icons-actions-edit' => 'Edit',
	'flags-icons-actions-delete' => 'Delete this type of flags',
	'flags-icons-actions-insights' => 'Open a new tab with an Insights list of pages with this flag',
	'flags-notification-templates-extraction' => "The following templates: ''$1'' were recognized as [[Special:Flags|Flags]] and automatically converted. To see the change visit [[Special:RecentChanges]] or [[Special:Log]].",
	'flags-edit-intro-notification' => 'This template is associated with a Flag. Manage Flags at [[Special:Flags]].',
	'flags-log-name' => 'Flags log',
	'logentry-flags-flag-added' => "$1 added flag '$4' to page $3",
	'logentry-flags-flag-removed' => "$1 removed flag '$4' from page $3",
	'logentry-flags-flag-parameter-added' => "$1 added value '$7' for parameter '$5' of flag '$4' on page $3",
	'logentry-flags-flag-parameter-modified' => "$1 modified parameter '$5' of flag '$4' on page $3 from '$6' to '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 removed value '$6' for parameter '$5' of flag '$4' on page $3",
);

$messages['qqq'] = array(
	'flags-description' => '{{desc}}',
	'flags-special-title' => 'A title of the Flags special page (Flags HQ).',
	'flags-special-header-text' => 'A brief description of what Flags are and where a user can find more information about them.',
	'flags-special-zero-state' => 'A message shown to a user if the given wikia has no types of flags defined.',
	'flags-special-create-button-text' => 'Label for button to create new flag type',
	'flags-special-create-form-title-new' => 'Title of modal when creating new flag',
	'flags-special-create-form-title-edit' => 'Title of modal when editing a flag',
	'flags-special-create-form-name' => 'Label for flag name input field (with colon)',
	'flags-special-create-form-template' => 'Label for used template name input field (with colon)',
	'flags-special-create-form-group' => 'Label for flag groups drop-down list (with colon)',
	'flags-special-create-form-targeting' => 'Label for flag targeting drop-down list (with colon)',
	'flags-special-create-form-parameters' => 'Label for flag parameters fieldset (with colon)',
	'flags-special-create-form-parameters-name' => 'Label for flag parameter name input field',
	'flags-special-create-form-parameters-description' => 'Label for flag parameter description input field',
	'flags-special-create-form-parameters-add' => 'Label for button to add new parameter to flag',
	'flags-special-create-form-cancel' => 'Label for button to cancel',
	'flags-special-create-form-save' => 'Label for button to save',
	'flags-special-create-form-invalid-name' => 'Error message which ask user to enter appropriate flag name',
	'flags-special-create-form-invalid-name-exists' => 'Error message which inform that entered flag name is already used and ask to choose another one.',
	'flags-special-create-form-invalid-template' => 'Error message which ask user to enter appropriate flag template name',
	'flags-special-create-form-invalid-param-name' => 'Error message which ask user to enter appropriate parameter names or remove the empty ones.',
	'flags-special-create-form-save-success' => 'Success message after click save which inform user that flag has been added',
	'flags-special-create-form-save-failure' => 'Error message after click save which inform user that an error occurs and ask to try again',
	'flags-special-create-form-fetch-params' => "Text of a link that allows users to fetch parameters already used in an existing template. Displayed below an input field for the template's name.",
	'flags-special-create-form-save-nochange' => 'Message which inform user that there were no change mage',
	'flags-special-autoload-delete-confirm' => 'Message warning the user that if removes flag then it also will be removed from all articles and this action cannot be undone. Ask user if is sure to perform this action.',
	'flags-special-autoload-delete-success' => 'Success message which inform user that flag has been removed',
	'flags-special-autoload-delete-error' => 'Error message which inform user that an error occurs and flag was not removed. Ask to try again later or contact us.',
	'flags-special-list-header-name' => 'A column name for a Flag name.',
	'flags-special-list-header-template' => 'A column name for an associated Template name.',
	'flags-special-list-header-group' => 'A column name for a Flag group.',
	'flags-special-list-header-target' => 'A column name for a Flag targeting (who should we display the flag to - everybody or only contributors).',
	'flags-special-list-header-parameters' => 'A column name for a Flag parameters.',
	'flags-special-list-header-actions' => 'A column name for actions',
	'flags-edit-flags-button-text' => 'Text on button that opens edit flags modal; button contains flag icon; button is displayed near generated flags',
	'flags-edit-form-more-info' => 'A link that is displayed next to a checkbox in the edit form of Flags. It links to a template used by the flag that it is next to.',
	'flags-edit-modal-cancel-button-text' => 'Text on the button that closes flags edit modal and ignores changes.',
	'flags-edit-modal-close-button-text' => 'Text on the button that closes flags edit modal.',
	'flags-edit-modal-done-button-text' => 'Text on the button that submits changes done to flags.',
	'flags-edit-modal-no-flags-on-community' => 'Message on modal appearing when there are no flags types defined on the wiki.',
	'flags-edit-modal-title' => 'Title of the form for editing flags displayed on headline of modal containing the form.',
	'flags-edit-modal-exception' => 'A message shown in the modal instead of an edit form if an error makes it impossible to display it. $1 is a text of the error.',
	'flags-edit-modal-post-exception' => 'A message shown in a banner notification if posting of edit forms fails due to an error. $1 is a text of the error.',
	'flags-groups-spoiler' => 'A name of a Spoiler group of flags',
	'flags-groups-disambig' => 'A name of a Disambiguation group of flags',
	'flags-groups-canon' => 'A name of a Canon group of flags',
	'flags-groups-stub' => 'A name of a Stub group of flags',
	'flags-groups-delete' => 'A name of a Delete group of flags',
	'flags-groups-improvements' => 'A name of a Improvements group of flags',
	'flags-groups-status' => 'A name of a Status group of flags',
	'flags-groups-other' => 'A name of a Other group of flags',
	'flags-groups-navigation' => 'A name of Navigation group of flags',
	'flags-target-readers' => 'Target for displaying flags - Readers',
	'flags-target-contributors' => 'Target for displaying flags - Contributors',
	'flags-icons-actions-edit' => 'Label for link to edit flag.',
	'flags-icons-actions-delete' => 'Trash icon tooltip text to delete given flag',
	'flags-icons-actions-insights' => 'Icon tooltip text to open page in new tab with list of pages with given flag enabled',
	'flags-notification-templates-extraction' => 'A message shown as a banner notification when a user inserts a template mapped as a Flag. It notifies them that these templates were removed from the content and converted into Flags.',
	'flags-edit-intro-notification' => 'A message shown as a banner notification or intro when a user edits or views template mapped as a Flag',
	'flags-log-name' => 'Name of log type displayed on Special:Log',
	'logentry-flags-flag-added' => 'Message used for generating log entry on Special:Log with info about added flag
		$1 info about user that added a flag passed as a generated link to user page
		$2 plain user name of user that added a flag
		$3 link to modified page
		$4 name of flag added',
	'logentry-flags-flag-removed' => 'Same as logentry-flags-flag-added message but concerns removal',
);

$messages['de'] = array(
	'flags-description' => 'Markierungen sind artikelbezogene Informationen für Leser oder Beitragende, die den Inhalt des Artikels oder eine erforderliche Aktion beschreiben.',
	'flags-special-title' => 'Markierungen verwalten',
	'flags-special-header-text' => 'Die Markierungen sind auf die Benachrichtigungsvorlagen aufgesetzt, die du ja bereits kennst und nutzt und sie bieten dir eine  leistungsstärkere Organisation, Verwaltung und Beschriftung von Artikeln als jemals zuvor. Unter [[Help:Flags]] erfährst du mehr.',
	'flags-special-zero-state' => 'In dieser Community sind keine Markierungen eingerichtet. [[Help:Flags|Erfahre mehr über Markierungen]].',
	'flags-special-create-button-text' => 'Markierung erstellen',
	'flags-special-create-form-title-new' => 'Markierung erstellen',
	'flags-special-create-form-title-edit' => 'Die Markierung bearbeiten',
	'flags-special-create-form-name' => 'Name:',
	'flags-special-create-form-template' => 'Vorlage:',
	'flags-special-create-form-group' => 'Gruppe:',
	'flags-special-create-form-targeting' => 'Zielgruppe:',
	'flags-special-create-form-parameters' => 'Parameter:',
	'flags-special-create-form-parameters-name' => 'Name',
	'flags-special-create-form-parameters-description' => 'Beschreibung',
	'flags-special-create-form-parameters-add' => 'Neuen Parameter hinzufügen',
	'flags-special-create-form-cancel' => 'Abbrechen',
	'flags-special-create-form-save' => 'Speichern',
	'flags-special-create-form-invalid-name' => 'Bitte gib für die Markierung einen geeigneten Namen ein.',
	'flags-special-create-form-invalid-name-exists' => 'Der Name der Markierung wird bereits verwendet. Wähle bitte einen anderen aus.',
	'flags-special-create-form-invalid-template' => 'Bitte gib für die Markierung einen geeigneten Vorlagennamen ein.',
	'flags-special-create-form-invalid-param-name' => 'Gib bitte für alle Parameter einen geeigneten Namen ein oder entferne sie, wenn sie keinen Inhalt haben.',
	'flags-special-create-form-save-success' => 'Die Markierung wurde hinzugefügt!',
	'flags-special-create-form-save-failure' => 'Leider ist ein Fehler aufgetreten. Kannst du es noch einmal probieren?',
	'flags-special-create-form-save-nochange' => 'Es wurden scheinbar keine Änderungen vorgenommen.',
	'flags-special-create-form-no-parameters' => 'In der angegebenen Vorlage wurden keine Parameter gefunden.',
	'flags-special-create-form-fetch-params' => 'Parameter abrufen, die bereits in der Vorlage verwendet werden.',
	'flags-special-autoload-delete-confirm' => 'Wenn die Markierung $1 gelöscht wird, wird sie auch aus allen Artikeln entfernt. Dieser Schritt kann nicht rückgängig gemacht werden. Bist du sicher, dass du fortfahren möchtest?',
	'flags-special-autoload-delete-success' => 'Die Markierung wurde erfolgreich entfernt.',
	'flags-special-autoload-delete-error' => 'Leider konnten wir die Markierung nicht löschen. Versuche es bitte noch einmal oder nimm Kontakt zu uns auf.',
	'flags-special-list-header-name' => 'Name der Markierung',
	'flags-special-list-header-template' => 'Name der Vorlage',
	'flags-special-list-header-group' => 'Markierungsgruppe',
	'flags-special-list-header-target' => 'Zielgruppe',
	'flags-special-list-header-parameters' => 'Parameter',
	'flags-special-list-header-actions' => 'Aktionen',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|Hier siehst du Wikia-Markierungen in Aktion!]]',
	'flags-edit-flags-button-text' => 'Markierungen bearbeiten',
	'flags-edit-form-more-info' => 'Mehr Informationen >',
	'flags-edit-modal-cancel-button-text' => 'Abbrechen',
	'flags-edit-modal-close-button-text' => 'Schließen',
	'flags-edit-modal-done-button-text' => 'Fertig',
	'flags-edit-modal-no-flags-on-community' => 'In dieser Community sind keine Markierungen eingerichtet. [[Help:Flags|Erfahre mehr über Markierungen]] oder [[Special:Flags|definiere Markierungen für diese Community]].',
	'flags-edit-modal-title' => 'Markierungen',
	'flags-edit-modal-exception' => 'Leider kann die gewünschte Information aufgrund des folgenden Fehlers nicht angezeigt werden:



$1



Der Fehler wurde bereits an das technische Team weitergeleitet. Zögere bitte nicht und nimm [[Special:Kontakt]] zum Wikia Support-Team auf, falls dieses Problem weiterhin besteht.',
	'flags-edit-modal-post-exception' => 'Leider kann dieser Vorgang aufgrund des folgenden Fehlers nicht ausgeführt werden:



$1



Der Fehler wurde bereits an das technische Team weitergeleitet. Zögere bitte nicht und nimm [[Special:Kontakt]] zum Wikia Support-Team auf, falls dieses Problem weiterhin besteht.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Begriffsklärung',
	'flags-groups-canon' => 'Kanon',
	'flags-groups-stub' => 'Stub',
	'flags-groups-delete' => 'Löschen',
	'flags-groups-improvements' => 'Verbesserungen',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Sonstige',
	'flags-groups-navigation' => 'Navigation',
	'flags-target-readers' => 'Leser',
	'flags-target-contributors' => 'Benutzer',
	'flags-icons-actions-edit' => 'Bearbeiten',
	'flags-icons-actions-delete' => 'Diesen Markierungstyp löschen.',
	'flags-icons-actions-insights' => 'Öffne eine neue Registerkarte mit einer Insights-Liste von Seiten mit dieser Markierung.',
	'flags-notification-templates-extraction' => "Die folgenden Vorlagen: ''$1'' wurden als [[Special:Flags|Markierungen]] erkannt und automatisch konvertiert. Du kannst die Änderungen unter [[Special:RecentChanges]] oder [[Special:Log]] ansehen.",
	'flags-edit-intro-notification' => 'Diese Vorlage ist mit einer Markierung verbunden. Du kannst Markierungen unter [[Special:Flags]] verwalten.',
	'flags-log-name' => 'Markierungsprotokoll',
	'logentry-flags-flag-added' => "$1 hat der Seite $3 die Markierung '$4' hinzugefügt",
	'logentry-flags-flag-removed' => "$1 hat die Markierung '$4' von der Seite $3 entfernt",
	'logentry-flags-flag-parameter-added' => "$1 hat für den Parameter '$5' der Markierung '$4' auf der Seite $3 den Wert '$7' hinzugefügt",
	'logentry-flags-flag-parameter-modified' => "$1 hat den Parameter '$5' der Markierung '$4' auf der Seite $3 von '$6' bis '$7' modifiziert",
	'logentry-flags-flag-parameter-removed' => "$1 hat für den Parameter '$5' der Markierung '$4' auf der Seite $3 den Wert '$6' entfernt",
);

$messages['es'] = array(
	'flags-description' => 'Los avisos son información del artículo para lectores o editores que describen el contenido o la acción requerida',
	'flags-special-title' => 'Manejar avisos',
	'flags-special-header-text' => 'Creados arriba de las plantillas de notificaciones que ya conoces y usas, los avisos permiten que los artículos se organicen, manejen y etiqueten de mejor manera que antes. Visita [[w:c:es:Ayuda:Avisos]] para saber más.',
	'flags-special-zero-state' => 'Esta comunidad no tiene configurado ningún aviso. [[w:c:es:Ayuda:Avisos|Conoce más sobre los avisos]].',
	'flags-special-create-button-text' => 'Crear un aviso',
	'flags-special-create-form-title-new' => 'Crear un aviso',
	'flags-special-create-form-title-edit' => 'Editar un aviso',
	'flags-special-create-form-name' => 'Nombre:',
	'flags-special-create-form-template' => 'Plantilla:',
	'flags-special-create-form-group' => 'Grupo:',
	'flags-special-create-form-targeting' => 'Destinatario:',
	'flags-special-create-form-parameters' => 'Parámetros:',
	'flags-special-create-form-parameters-name' => 'Nombre',
	'flags-special-create-form-parameters-description' => 'Descripción',
	'flags-special-create-form-parameters-add' => 'Añade un nuevo parametro',
	'flags-special-create-form-cancel' => 'Cancelar',
	'flags-special-create-form-save' => 'Guardar',
	'flags-special-create-form-invalid-name' => 'Por favor ingresa el nombre apropiado para el aviso.',
	'flags-special-create-form-invalid-name-exists' => 'El nombre del aviso ya se encuentra en uso. Por favor, elige otro.',
	'flags-special-create-form-invalid-template' => 'Por favor ingresa un nombre apropiado de plantilla para un aviso.',
	'flags-special-create-form-invalid-param-name' => 'Por favor ingresa nombres apropiados para todos los parámetros o retira los parámetros vacíos.',
	'flags-special-create-form-save-success' => '¡El aviso ha sido añadido!',
	'flags-special-create-form-save-failure' => 'Desafortunadamente, ha ocurrido un error. ¿Deseas intentar nuevamente?',
	'flags-special-create-form-save-nochange' => 'Parece que no se han realizado cambios.',
	'flags-special-create-form-no-parameters' => 'No se han encontrado parámetros en la plantilla dada.',
	'flags-special-create-form-fetch-params' => 'Obtén parámetros ya utilizados en una plantilla',
	'flags-special-autoload-delete-confirm' => 'Borrar el aviso $1 también lo retirará de todos los artículos. Esto no puede ser deshecho. ¿Estás seguro?',
	'flags-special-autoload-delete-success' => 'El aviso ha sido satisfactoriamente retirado.',
	'flags-special-autoload-delete-error' => 'Desafortunadamente, no hemos podido retirar el aviso. Por favor intenta nuevamente y contáctanos.',
	'flags-special-list-header-name' => 'Nombre del aviso',
	'flags-special-list-header-template' => 'Nombre de la plantilla',
	'flags-special-list-header-group' => 'Grupo de avisos',
	'flags-special-list-header-target' => 'Destinatario',
	'flags-special-list-header-parameters' => 'Parámetros',
	'flags-special-list-header-actions' => 'Acciones',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|¡Mira los avisos de Wikia en acción!]]',
	'flags-edit-flags-button-text' => 'Editar avisos',
	'flags-edit-form-more-info' => 'Más información >',
	'flags-edit-modal-cancel-button-text' => 'Cancelar',
	'flags-edit-modal-close-button-text' => 'Cerrar',
	'flags-edit-modal-done-button-text' => 'Hecho',
	'flags-edit-modal-no-flags-on-community' => 'Esta comunidad no tiene avisos configurados. [[w:c:es:Ayuda:Avisos|Learn more about flags]] or [[Special:Flags|definir los avisos para esta comunidad]].',
	'flags-edit-modal-title' => 'Avisos',
	'flags-edit-modal-exception' => 'Desafortunadamente no podemos mostrar esto debido al siguiente error:



$1



Ya se reportó este error al equipo técnico. No dudes en usar [[Special:Contact]] para ponerte en contacto con el equipo de apoyo de Wikia si sigues viendo este problema.',
	'flags-edit-modal-post-exception' => 'Desafortunadamente no podemos completar el proceso debido al siguiente error:



$1



Ya se reportó este error al equipo técnico. No dudes en usar [[Special:Contact]] para ponerte en contacto con el equipo de apoyo de Wikia si sigues viendo este problema.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Desambiguación',
	'flags-groups-canon' => 'Canon',
	'flags-groups-stub' => 'Talón',
	'flags-groups-delete' => 'Borrar',
	'flags-groups-improvements' => 'Mejoras',
	'flags-groups-status' => 'Estado',
	'flags-groups-other' => 'Otro',
	'flags-groups-navigation' => 'Navegación',
	'flags-target-readers' => 'Lectores',
	'flags-target-contributors' => 'Editores',
	'flags-icons-actions-edit' => 'Editar',
	'flags-icons-actions-delete' => 'Borra este tipo de avisos',
	'flags-icons-actions-insights' => 'Abre una nueva viñeta con una lista de pagina de Sugerencias con este aviso',
	'flags-notification-templates-extraction' => "Las siguientes plantillas: ''$1''fueron reconocidas como [[Special:Flags|Avisos]] y se convirtieron automáticamente. Para ver el cambio visita [[Special:RecentChanges]] o [[Special:Log]].",
	'flags-edit-intro-notification' => 'Esta plantilla está asociada con un aviso. Maneja los avisos en [[Special:Flags]].',
	'flags-log-name' => 'Registro de avisos',
	'logentry-flags-flag-added' => "$1 añadido aviso '$4' a la pagina $3",
	'logentry-flags-flag-removed' => "$1 quitó el aviso '$4' de la página $3",
	'logentry-flags-flag-parameter-added' => "$1 agregó el valor '$7' para el parámetro '$5' del aviso '$4' en la página $3",
	'logentry-flags-flag-parameter-modified' => "$1 modificó el parámetro '$5' del aviso '$4' en la página $3 de '$6' a '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 quitó el valor '$6' para el parámetro '$5' del aviso '$4' en la página $3",
);

$messages['fr'] = array(
	'flags-description' => "Les flags sont des informations destinées aux lecteurs ou aux contributeurs décrivant le contenu ou l'action nécessaire sur un article.",
	'flags-special-title' => 'Gestion des flags',
	'flags-special-header-text' => "Créés en plus des modèles de notification que vous connaissez et utilisez déjà, les flags permettent une organisation, une gestion et un étiquetage des articles plus avancés qu'avant. Pour en savoir plus, visitez la page [[Aide:Flags]].",
	'flags-special-zero-state' => "Aucun flag n'a été configuré pour cette communauté. [[Aide:Flags|En savoir plus sur les flags]]",
	'flags-special-create-button-text' => 'Créer un flag',
	'flags-special-create-form-title-new' => 'Créer un flag',
	'flags-special-create-form-title-edit' => 'Modifier le flag',
	'flags-special-create-form-name' => 'Nom :',
	'flags-special-create-form-template' => 'Modèle :',
	'flags-special-create-form-group' => 'Groupe :',
	'flags-special-create-form-targeting' => 'Cible :',
	'flags-special-create-form-parameters' => 'Paramètres :',
	'flags-special-create-form-parameters-name' => 'Nom',
	'flags-special-create-form-parameters-description' => 'Description',
	'flags-special-create-form-parameters-add' => 'Ajouter un nouveau paramètre',
	'flags-special-create-form-cancel' => 'Annuler',
	'flags-special-create-form-save' => 'Enregistrer',
	'flags-special-create-form-invalid-name' => 'Veuillez saisir un nom approprié pour le flag.',
	'flags-special-create-form-invalid-name-exists' => 'Ce nom de flag est déjà utilisé. Veuillez en choisir un autre.',
	'flags-special-create-form-invalid-template' => 'Veuillez saisir un nom de modèle approprié pour le flag.',
	'flags-special-create-form-invalid-param-name' => 'Veuillez saisir des noms appropriés pour tous les paramètres ou supprimer ceux qui sont vides.',
	'flags-special-create-form-save-success' => 'Le flag a été ajouté.',
	'flags-special-create-form-save-failure' => 'Une erreur est survenue. Veuillez réessayer.',
	'flags-special-create-form-save-nochange' => "Il semble qu'aucune modification n'ait été apportée.",
	'flags-special-create-form-no-parameters' => "Aucun paramètre n'a été trouvé dans le modèle fourni.",
	'flags-special-create-form-fetch-params' => 'Récupérer les paramètres déjà utilisés dans le modèle',
	'flags-special-autoload-delete-confirm' => 'Supprimer le flag $1 le retirera également de tous les articles. Cette opération ne peut pas être annulée. Voulez-vous vraiment continuer ?',
	'flags-special-autoload-delete-success' => 'Le flag été supprimé.',
	'flags-special-autoload-delete-error' => "Nous n'avons pas pu supprimer le flag. Veuillez réessayer ou nous contacter.",
	'flags-special-list-header-name' => 'Nom du flag',
	'flags-special-list-header-template' => 'Nom du modèle',
	'flags-special-list-header-group' => 'Groupe du flag',
	'flags-special-list-header-target' => 'Cible',
	'flags-special-list-header-parameters' => 'Paramètres',
	'flags-special-list-header-actions' => 'Actions',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|Voir les flags Wikia en action !]]',
	'flags-edit-flags-button-text' => 'Modifier les flags',
	'flags-edit-form-more-info' => "Plus d'infos >",
	'flags-edit-modal-cancel-button-text' => 'Annuler',
	'flags-edit-modal-close-button-text' => 'Fermer',
	'flags-edit-modal-done-button-text' => 'Terminé',
	'flags-edit-modal-no-flags-on-community' => "Aucun flag n'a été configuré pour cette communauté. [[Aide:Flags|Découvrez ce que sont les flags]] ou [[Special:Flags|définissez-en pour cette communauté]].",
	'flags-edit-modal-title' => 'Flags',
	'flags-edit-modal-exception' => "Nous n'avons pas pu afficher cela en raison de l'erreur suivante :



$1



Cette erreur a déjà été signalée à l'équipe technique. Si le problème persiste, vous pouvez visiter la page [[Spécial:Contact]] pour vous adresser à l'équipe d'assistance de Wikia.",
	'flags-edit-modal-post-exception' => "Nous n'avons pas pu terminer le processus en raison de l'erreur suivante :



$1



Cette erreur a déjà été signalée à l'équipe technique. Si le problème persiste, vous pouvez visiter la page [[Spécial:Contact]] pour vous adresser à l'équipe d'assistance de Wikia.",
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Désambiguïsation',
	'flags-groups-canon' => 'Canon',
	'flags-groups-stub' => 'Ébauche',
	'flags-groups-delete' => 'Supprimer',
	'flags-groups-improvements' => 'Améliorations',
	'flags-groups-status' => 'État',
	'flags-groups-other' => 'Autre',
	'flags-groups-navigation' => 'Navigation',
	'flags-target-readers' => 'Lecteurs',
	'flags-target-contributors' => 'Contributeurs',
	'flags-icons-actions-edit' => 'Modifier',
	'flags-icons-actions-delete' => 'Supprimer ce type de flag',
	'flags-icons-actions-insights' => 'Ouvrir un nouvel onglet contenant une liste de pages avec ce flag',
	'flags-notification-templates-extraction' => "Les modèles ''$1'' ont été reconnus comme des [[Special:Flags|flags]] et automatiquement convertis. Pour voir ce qui a changé, visitez la page [[Spécial:Modifications_récentes]] ou [[Spécial:Journal]].",
	'flags-edit-intro-notification' => 'Ce modèle est associé à un flag. Pour gérer les flags, visitez la page [[Special:Flags]].',
	'flags-log-name' => 'Journal des flags',
	'logentry-flags-flag-added' => "$1 a ajouté le flag '$4' à la page $3",
	'logentry-flags-flag-removed' => "$1 a supprimé le flag '$4' de la page $3.",
	'logentry-flags-flag-parameter-added' => "$1 a ajouté la valeur '$7' pour le paramètre '$5' du flag '$4' de la page $3.",
	'logentry-flags-flag-parameter-modified' => "$1 a modifié le paramètre '$5' du flag '$4' de la page $3 de '$6' en '$7'.",
	'logentry-flags-flag-parameter-removed' => "$1 a supprimé la valeur '$6' du paramètre '$5' du flag '$4' de la page $3.",
);

$messages['it'] = array(
	'flags-description' => "I contrassegni sono informazioni sugli articoli, utili a lettori e collaboratori, che ne descrivono il contenuto o l'azione richiesta",
	'flags-special-title' => 'Organizza contrassegni',
	'flags-special-header-text' => 'Creati sulla base dei modelli di notifica che già conosci e usi, Contrassegni migliora drasticamente la tua esperienza di organizzazione, gestione e categorizzazione degli articoli. Visita [[Help:Flags]] per saperne di più.',
	'flags-special-zero-state' => 'Questa community non ha alcun contrassegno predefinito. [[Help:Flags|Per saperne di più sui contrassegni]].',
	'flags-special-create-button-text' => 'Crea un contrassegno',
	'flags-special-create-form-title-new' => 'Crea un contrassegno',
	'flags-special-create-form-title-edit' => 'Modifica contrassegno',
	'flags-special-create-form-name' => 'Nome:',
	'flags-special-create-form-template' => 'Modello:',
	'flags-special-create-form-group' => 'Gruppo:',
	'flags-special-create-form-targeting' => 'Destinatario:',
	'flags-special-create-form-parameters' => 'Parametri:',
	'flags-special-create-form-parameters-name' => 'Nome',
	'flags-special-create-form-parameters-description' => 'Descrizione',
	'flags-special-create-form-parameters-add' => 'Aggiungi un nuovo parametro',
	'flags-special-create-form-cancel' => 'Annulla',
	'flags-special-create-form-save' => 'Salva',
	'flags-special-create-form-invalid-name' => 'Assegna un nome appropriato al contrassegno.',
	'flags-special-create-form-invalid-name-exists' => 'Il nome del contrassegno esiste già. Scegline un altro.',
	'flags-special-create-form-invalid-template' => 'Assegna al contrassegno un nome di modello appropriato.',
	'flags-special-create-form-invalid-param-name' => 'Assegna un nome appropriato a tutti i parametri o rimuovi quelli vuoti.',
	'flags-special-create-form-save-success' => 'Il contrassegno è stato aggiunto!',
	'flags-special-create-form-save-failure' => 'Sfortunatamente si è verificato un errore. Riprova.',
	'flags-special-create-form-save-nochange' => 'Non è stata fatta alcuna modifica.',
	'flags-special-create-form-no-parameters' => 'Nel modello dato non sono stati trovati parametri.',
	'flags-special-create-form-fetch-params' => 'Importa i parametri già usati nel modello',
	'flags-special-autoload-delete-confirm' => "Se elimini il contrassegno $1, questo scomparirà da tutti gli articoli e l'azione sarà irreversibile. Desideri procedere comunque?",
	'flags-special-autoload-delete-success' => 'Il contrassegno è stato rimosso.',
	'flags-special-autoload-delete-error' => 'Sfortunatamente non abbiamo potuto rimuovere il contrassegno. Sei pregato di riprovare o di contattarci.',
	'flags-special-list-header-name' => 'Nome del contrassegno',
	'flags-special-list-header-template' => 'Nome del modello',
	'flags-special-list-header-group' => 'Gruppo di contrassegni',
	'flags-special-list-header-target' => 'Destinatario',
	'flags-special-list-header-parameters' => 'Parametri',
	'flags-special-list-header-actions' => 'Azioni',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|Vedi i contrassegni di Wikia in azione!]]',
	'flags-edit-flags-button-text' => 'Modifica contrassegni',
	'flags-edit-form-more-info' => 'Ulteriori informazioni >',
	'flags-edit-modal-cancel-button-text' => 'Annulla',
	'flags-edit-modal-close-button-text' => 'Chiudi',
	'flags-edit-modal-done-button-text' => 'Fatto',
	'flags-edit-modal-no-flags-on-community' => 'Non hai ancora predefinito i contrassegni per questa community.  [[Help:Flags|Per saperne di più sui contrassegni]] o [[Special:Flags|definisci i contrassegni per questa community]].',
	'flags-edit-modal-title' => 'Contrassegni',
	'flags-edit-modal-exception' => 'Purtroppo non siamo in grado di visualizzarlo a causa del seguente errore:



$1



Questo errore è già stato riportato ai nostri tecnici. Se il problema persiste, puoi usare [[Special:Contact]] per metterti direttamente in contatto con il team di supporto di Wikia.',
	'flags-edit-modal-post-exception' => 'Purtroppo non siamo in grado di completare il processo a causa del seguente errore:



$1



Questo errore è già stato riportato ai nostri tecnici. Se il problema persiste, puoi usare [[Special:Contact]] per metterti direttamente in contatto con il team di supporto di Wikia.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Disambiguazione',
	'flags-groups-canon' => 'Canone',
	'flags-groups-stub' => 'Bozza',
	'flags-groups-delete' => 'Rimuovi',
	'flags-groups-improvements' => 'Miglioramenti',
	'flags-groups-status' => 'Stato',
	'flags-groups-other' => 'Altro',
	'flags-groups-navigation' => 'Navigazione',
	'flags-target-readers' => 'Lettori',
	'flags-target-contributors' => 'Collaboratori',
	'flags-icons-actions-edit' => 'Modifica',
	'flags-icons-actions-delete' => 'Cancella questo tipo di contrassegni',
	'flags-icons-actions-insights' => 'Apri una nuova scheda che elenchi le pagine con questo contrassegno',
	'flags-notification-templates-extraction' => "I seguenti modelli: ''$1'' sono stati identificati come [[Special:Flags|Contrassegni]] e automaticamente convertiti. Per vedere la modifica visita [[Special:RecentChanges]] o [[Special:Log]].",
	'flags-edit-intro-notification' => 'Questo modello è associato a un contrassegno. Gestisci i contrassegni qui [[Special:Flags]].',
	'flags-log-name' => 'Registro contrassegni',
	'logentry-flags-flag-added' => "$1 ha aggiunto il contrassegno '$4' alla pagina $3",
	'logentry-flags-flag-removed' => "$1 ha rimosso il contrassegno '$4' dalla pagina $3",
	'logentry-flags-flag-parameter-added' => "$1 ha aggiunto il valore '$7' al parametro '$5' del contrassegno '$4' alla pagina $3",
	'logentry-flags-flag-parameter-modified' => "$1 ha modificato il parametro '$5' del contrassegno '$4' alla pagina $3 da '$6' a '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 ha rimosso il valore '$6' per il parametro '$5' del contrassegno '$4' alla pagina $3",
);

$messages['ja'] = array(
	'flags-description' => 'フラッグは閲覧者や編集者向けに表示される記事ごとの情報で、記事のコンテンツや必要な対処について説明しています',
	'flags-special-title' => 'フラッグの管理',
	'flags-special-header-text' => 'すでに使い慣れている通知テンプレートをベースに構築されたフラッグを使用すると、これまでよりもさらに効果的に記事を整理、管理、ラベル付けすることができます。詳しくは、[[Help:フラッグ]]をご覧ください。',
	'flags-special-zero-state' => 'このコミュニティにはフラッグが設定されていません。[[Help:フラッグ|フラッグについての詳細]]をご覧ください。',
	'flags-special-create-button-text' => 'フラッグを作成',
	'flags-special-create-form-title-new' => 'フラッグの作成',
	'flags-special-create-form-title-edit' => 'フラッグの編集',
	'flags-special-create-form-name' => '名前：',
	'flags-special-create-form-template' => 'テンプレート：',
	'flags-special-create-form-group' => 'グループ：',
	'flags-special-create-form-targeting' => 'ターゲット：',
	'flags-special-create-form-parameters' => 'パラメータ：',
	'flags-special-create-form-parameters-name' => '名前',
	'flags-special-create-form-parameters-description' => '説明',
	'flags-special-create-form-parameters-add' => '新しいパラメータを追加',
	'flags-special-create-form-cancel' => 'キャンセル',
	'flags-special-create-form-save' => '保存',
	'flags-special-create-form-invalid-name' => 'フラッグの適切な名前を入力してください。',
	'flags-special-create-form-invalid-name-exists' => 'このフラッグの名前はすでに存在します。別の名前を指定してください。',
	'flags-special-create-form-invalid-template' => 'フラッグのテンプレートの適切な名前を入力してください。',
	'flags-special-create-form-invalid-param-name' => 'すべてのパラメータの適切な名前を入力するか、空白のパラメータを削除してください。',
	'flags-special-create-form-save-success' => 'フラッグを追加しました。',
	'flags-special-create-form-save-failure' => 'エラーが発生したようです。申し訳ありませんが、もう一度お試しください。',
	'flags-special-create-form-save-nochange' => 'まだ何も変更を加えていないようです。',
	'flags-special-create-form-no-parameters' => '指定したテンプレートのパラメータは見つかりませんでした。',
	'flags-special-create-form-fetch-params' => 'テンプレートで使用済みのパラメータを取得',
	'flags-special-autoload-delete-confirm' => 'フラッグ「$1」を削除すると、すべての記事からも削除されます。この操作は元に戻せません。実行してもよろしいですか？',
	'flags-special-autoload-delete-success' => 'フラッグを削除しました。',
	'flags-special-autoload-delete-error' => 'フラッグを削除できませんでした。申し訳ありませんが、もう一度お試しになるかスタッフにお問い合わせください。',
	'flags-special-list-header-name' => 'フラッグ名',
	'flags-special-list-header-template' => 'テンプレート名',
	'flags-special-list-header-group' => 'フラッググループ',
	'flags-special-list-header-target' => 'ターゲット',
	'flags-special-list-header-parameters' => 'パラメータ',
	'flags-special-list-header-actions' => '対処',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|ウィキアフラッグについての動画をご覧ください。]]',
	'flags-edit-flags-button-text' => 'フラッグを編集',
	'flags-edit-form-more-info' => '詳細 >',
	'flags-edit-modal-cancel-button-text' => 'キャンセル',
	'flags-edit-modal-close-button-text' => '閉じる',
	'flags-edit-modal-done-button-text' => '完了',
	'flags-edit-modal-no-flags-on-community' => 'このコミュニティにはフラッグが設定されていません。[[Help:フラッグ|フラッグについての詳細]]をご覧になるか、[[Special:Flags|このコミュニティのフラッグを定義]]してみてください。',
	'flags-edit-modal-title' => 'フラッグ',
	'flags-edit-modal-exception' => '申し訳ございませんが、次のエラーのためこれを表示できません。



$1



このエラーはすでに技術チームに報告済みです。この問題が引き続き発生する場合は、[[Special:Contact]]からウィキア・サポートチームまでお気軽にお問い合わせください。',
	'flags-edit-modal-post-exception' => '申し訳ございませんが、次のエラーのためこの処理を完了できません。



$1



このエラーはすでに技術チームに報告済みです。この問題が引き続き発生する場合は、[[Special:Contact]]からウィキア・サポートチームまでお気軽にお問い合わせください。',
	'flags-groups-spoiler' => 'ネタバレ',
	'flags-groups-disambig' => '曖昧さ回避',
	'flags-groups-canon' => '規則',
	'flags-groups-stub' => 'スタブ',
	'flags-groups-delete' => '削除',
	'flags-groups-improvements' => '改善',
	'flags-groups-status' => 'ステータス',
	'flags-groups-other' => 'その他',
	'flags-groups-navigation' => 'ナビゲーション',
	'flags-target-readers' => '閲覧者',
	'flags-target-contributors' => '投稿者',
	'flags-icons-actions-edit' => '編集',
	'flags-icons-actions-delete' => 'この種類のフラッグを削除',
	'flags-icons-actions-insights' => '新しいタブに、このフラッグを含むページのインサイトのリストを開く',
	'flags-notification-templates-extraction' => "テンプレート''$1''は[[Special:Flags|フラッグ]]として認識されたため、自動変換されました。変更を確認するには、[[Special:RecentChanges]]または[[Special:Log]]をご覧ください。",
	'flags-edit-intro-notification' => 'このテンプレートはフラッグに関連付けられています。フラッグの管理は[[Special:Flags]]で行っていただけます。',
	'flags-log-name' => 'フラッグログ',
	'logentry-flags-flag-added' => '$1さんがページ$3にフラッグ「$4」を追加しました',
	'logentry-flags-flag-removed' => '$1さんがページ$3からフラッグ「$4」を削除しました',
	'logentry-flags-flag-parameter-added' => '$1さんがページ$3のフラッグ「$4」のパラメータ「$5」に値「$7」を追加しました',
	'logentry-flags-flag-parameter-modified' => '$1さんがページ$3のフラッグ「$4」のパラメータ「$5」を「$6」から「$7」に変更しました',
	'logentry-flags-flag-parameter-removed' => '$1さんがページ$3のフラッグ「$4」のパラメータ「$5」から値「$6」を削除しました',
);

$messages['nl'] = array(
	'flags-description' => 'Flags are per article information for reader or editors that describe the content or action required',
	'flags-special-title' => 'Manage Flags',
	'flags-special-header-text' => 'Built on top of the notice templates you already know and use, Flags allow for more powerful article organization, management, and labeling than ever before. Visit [[Help:Flags]] to learn more.',
	'flags-special-zero-state' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]].",
	'flags-special-create-button-text' => 'Create a flag',
	'flags-special-create-form-title-new' => 'Create a flag',
	'flags-special-create-form-title-edit' => 'Edit the flag',
	'flags-special-create-form-name' => 'Name:',
	'flags-special-create-form-template' => 'Template:',
	'flags-special-create-form-group' => 'Group:',
	'flags-special-create-form-targeting' => 'Targeting:',
	'flags-special-create-form-parameters' => 'Parameters:',
	'flags-special-create-form-parameters-name' => 'Name',
	'flags-special-create-form-parameters-description' => 'Description',
	'flags-special-create-form-parameters-add' => 'Add a new parameter',
	'flags-special-create-form-cancel' => 'Cancel',
	'flags-special-create-form-save' => 'Save',
	'flags-special-create-form-invalid-name' => 'Please enter an appropriate name for the flag.',
	'flags-special-create-form-invalid-name-exists' => 'The name of the flag is already used. Please, choose another one.',
	'flags-special-create-form-invalid-template' => 'Please enter an appropriate name of a template for the flag.',
	'flags-special-create-form-invalid-param-name' => 'Please enter an appropriate names for all parameters or remove the empty ones.',
	'flags-special-create-form-save-success' => 'The flag has been added!',
	'flags-special-create-form-save-failure' => 'Unfortunately, an error happened. Can you try again?',
	'flags-special-create-form-save-nochange' => 'It seems that no changes were made.',
	'flags-special-create-form-no-parameters' => 'No parameters were found in the given template.',
	'flags-special-create-form-fetch-params' => 'Get parameters already used in the template',
	'flags-special-autoload-delete-confirm' => 'Deleting the $1 flag will also remove it from all articles. This cannot be undone. Are you sure?',
	'flags-special-autoload-delete-success' => 'The flag has been successfully removed.',
	'flags-special-autoload-delete-error' => 'Unfortunately, we were not able to remove the flag. Please try again or contact us.',
	'flags-special-list-header-name' => 'Flag name',
	'flags-special-list-header-template' => 'Template name',
	'flags-special-list-header-group' => 'Flag group',
	'flags-special-list-header-target' => 'Target',
	'flags-special-list-header-parameters' => 'Parameters',
	'flags-special-list-header-actions' => 'Actions',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|See Fandom Flags in action!]]',
	'flags-edit-flags-button-text' => 'Edit flags',
	'flags-edit-form-more-info' => 'More info >',
	'flags-edit-modal-cancel-button-text' => 'Cancel',
	'flags-edit-modal-close-button-text' => 'Close',
	'flags-edit-modal-done-button-text' => 'Done',
	'flags-edit-modal-no-flags-on-community' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]] or [[Special:Flags|define the flags for this community]].",
	'flags-edit-modal-title' => 'Flags',
	'flags-edit-modal-exception' => 'Unfortunately, we are not able to display this due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Fandom support team if you continue to see this issue.',
	'flags-edit-modal-post-exception' => 'Unfortunately, we are not able to complete the process due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Fandom support team if you continue to see this issue.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Disambiguation',
	'flags-groups-canon' => 'Canon',
	'flags-groups-stub' => 'Stub',
	'flags-groups-delete' => 'Delete',
	'flags-groups-improvements' => 'Improvements',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Other',
	'flags-groups-navigation' => 'Navigation',
	'flags-target-readers' => 'Readers',
	'flags-target-contributors' => 'Contributors',
	'flags-icons-actions-edit' => 'Edit',
	'flags-icons-actions-delete' => 'Delete this type of flags',
	'flags-icons-actions-insights' => 'Open a new tab with an Insights list of pages with this flag',
	'flags-notification-templates-extraction' => "The following templates: ''$1'' were recognized as [[Special:Flags|Flags]] and automatically converted. To see the change visit [[Special:RecentChanges]] or [[Special:Log]].",
	'flags-edit-intro-notification' => 'This template is associated with a Flag. Manage Flags at [[Special:Flags]].',
	'flags-log-name' => 'Flags log',
	'logentry-flags-flag-added' => "$1 added flag '$4' to page $3",
	'logentry-flags-flag-removed' => "$1 removed flag '$4' from page $3",
	'logentry-flags-flag-parameter-added' => "$1 added value '$7' for parameter '$5' of flag '$4' on page $3",
	'logentry-flags-flag-parameter-modified' => "$1 modified parameter '$5' of flag '$4' on page $3 from '$6' to '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 removed value '$6' for parameter '$5' of flag '$4' on page $3",
);

$messages['pl'] = array(
	'flags-description' => 'Flagi są dla czytelników lub użytkowników danego artykułu informacją, która opisuje jego zawartość lub działania, które należy podjąć',
	'flags-edit-flags-button-text' => 'Edytuj flagi',
	'flags-edit-form-more-info' => 'Więcej informacji >',
	'flags-edit-modal-cancel-button-text' => 'Anuluj',
	'flags-edit-modal-close-button-text' => 'Zamknij',
	'flags-edit-modal-done-button-text' => 'Gotowe',
	'flags-edit-modal-no-flags-on-community' => 'Ta społeczność nie ma ustawionych flag. [[Help:Flags|Więcej informacji na temat flag]] lub [[Special:Flags|określ flagi dla tej społeczności]].',
	'flags-edit-modal-title' => 'Flagi',
	'flags-log-name' => 'Protokół Flag',
	'logentry-flags-flag-added' => "$1 {{GENDER:$2|dodał|dodała}} flagę '$4' do strony $3",
	'logentry-flags-flag-removed' => "Użytkownik $1 usunął flagę '$4' ze strony $3",
	'flags-special-title' => 'Zarządzaj Flagami',
	'flags-special-header-text' => 'Zbudowane na bazie szablonów uwag, które znasz i z których korzystasz, Flagi pozwalają na lepsze organizowanie, zarządzanie i znakowanie artykułów. Odwiedź stronę [[Pomoc:Flagi]], aby dowiedzieć się więcej.',
	'flags-special-zero-state' => 'Ta społeczność nie ma ustawionych flag. [[Help:Flags|Więcej informacji na temat flag]].',
	'flags-special-create-button-text' => 'Utwórz flagę',
	'flags-special-create-form-title-new' => 'Utwórz flagę',
	'flags-special-create-form-title-edit' => 'Edytuj flagę',
	'flags-special-create-form-name' => 'Nazwa:',
	'flags-special-create-form-template' => 'Szablon:',
	'flags-special-create-form-group' => 'Grupa:',
	'flags-special-create-form-targeting' => 'Grupa docelowa:',
	'flags-special-create-form-parameters' => 'Parametry:',
	'flags-special-create-form-parameters-name' => 'Nazwa',
	'flags-special-create-form-parameters-description' => 'Opis',
	'flags-special-create-form-parameters-add' => 'Dodaj nowy parametr',
	'flags-special-create-form-cancel' => 'Anuluj',
	'flags-special-create-form-save' => 'Zapisz',
	'flags-special-create-form-invalid-name' => 'Wpisz poprawną nazwę flagi.',
	'flags-special-create-form-invalid-name-exists' => 'Nazwa flagi jest już wykorzystywana. Wybierz inną nazwę.',
	'flags-special-create-form-invalid-template' => 'Wpisz poprawną nazwę szablonu flagi.',
	'flags-special-create-form-invalid-param-name' => 'Wpisz poprawne nazwy wszystkich parametrów albo usuń te, które są puste.',
	'flags-special-create-form-save-success' => 'Flaga została dodana!',
	'flags-special-create-form-save-failure' => 'Niestety wystąpił błąd. Spróbuj ponownie.',
	'flags-special-create-form-save-nochange' => 'Nie dokonano zmian.',
	'flags-special-create-form-no-parameters' => 'W podanym szablonie nie znaleziono parametrów.',
	'flags-special-create-form-fetch-params' => 'Pobierz parametry już wykorzystywane w szabonie',
	'flags-special-autoload-delete-confirm' => 'Usunięcie flagi $1 sprawi, że zostanie ona usunięta ze wszystkich artykułów. Tej czynności nie da się cofnąć. Czy jesteś tego pewien?',
	'flags-special-autoload-delete-success' => 'Flaga została usunięta.',
	'flags-special-autoload-delete-error' => 'Niestety nie udało się usunąć flagi. Spróbuj ponownie lub skontaktuj się z nami.',
	'flags-special-list-header-name' => 'Nazwa flagi',
	'flags-special-list-header-template' => 'Nazwa szablonu',
	'flags-special-list-header-group' => 'Grupa flag',
	'flags-special-list-header-target' => 'Grupa docelowa',
	'flags-special-list-header-parameters' => 'Parametry',
	'flags-special-list-header-actions' => 'Działania',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|Zobacz jak działają Flagi na portalu Wikia!]]',
	'flags-edit-modal-exception' => 'Niestety nie jesteśmy w stanie tego wyświetlić ze względu na następujący błąd:



$1



Błąd został już zgłoszony zespołowi technicznemu. Jeśli w dalszym ciągu widzisz ten błąd, skontaktuj się z zespołem wsparcia portalu Wikia korzystając z [[Special:Contact]].',
	'flags-edit-modal-post-exception' => 'Niestety nie jesteśmy w stanie ukończyć tego procesu ze względu na następujący błąd:



$1



Błąd został już zgłoszony zespołowi technicznemu. Jeśli w dalszym ciągu widzisz ten błąd, skontaktuj się z zespołem wsparcia portalu Wikia korzystając z [[Special:Contact]].',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Ujednoznacznienie',
	'flags-groups-canon' => 'Kanon',
	'flags-groups-stub' => 'Zalążek',
	'flags-groups-delete' => 'Usuń',
	'flags-groups-improvements' => 'Ulepszenia',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Inne',
	'flags-groups-navigation' => 'Nawigacja',
	'flags-target-readers' => 'Czytelnicy',
	'flags-target-contributors' => 'Użytkownicy',
	'flags-icons-actions-edit' => 'Edytuj',
	'flags-icons-actions-delete' => 'Usuń ten rodzaj flag',
	'flags-icons-actions-insights' => 'Otwórz nową kartę Podpowiedziami dotyczącymi listy stron, na których znajduje się ta flaga',
	'flags-notification-templates-extraction' => "Następujące szablony: ''$1'' zostały rozpoznane jako [[Special:Flags|Flagi]] i zostały  automatycznie przekształcone. Aby zobaczyć zmianę przejdź do [[Special:RecentChanges]] lub [[Special:Log]].",
	'flags-edit-intro-notification' => 'Ten szablon jest powiązany z Flagą. Zarządzaj Flagami na stronie [[Special:Flags]].',
	'logentry-flags-flag-parameter-added' => "Użytkownik $1 dodał wartość '$7' dla parametru '$5' flagi '$4' na stronie $3",
	'logentry-flags-flag-parameter-modified' => "Użytkownik $1 zmodyfikował parametr '$5' flagi '$4' na stronie $3 z '$6' na '$7'",
	'logentry-flags-flag-parameter-removed' => "Użytkownik $1 usunął wartość '$6' dla parametru '$5' flagi '$4' na stronie $3",
);

$messages['pt'] = array(
	'flags-description' => 'Bandeiras são informações contidas em artigos que permitem ao leitor ou editores descrever o conteúdo ou uma ação necessária',
	'flags-special-title' => 'Administrar bandeiras',
	'flags-special-header-text' => 'Criadas acima das predefinições de notificação que você já conhece e usa, as bandeiras permitem melhor organização, gerenciamento e marcação de artigo do que nunca. Visite [[Help:Bandeiras]] para saber mais.',
	'flags-special-zero-state' => 'Esta comunidade não tem nenhuma bandeira configurada. [[Help:Bandeiras|Saiba mais sobre as bandeiras]].',
	'flags-special-create-button-text' => 'Criar uma bandeira',
	'flags-special-create-form-title-new' => 'Criar uma bandeira',
	'flags-special-create-form-title-edit' => 'Editar a bandeira',
	'flags-special-create-form-name' => 'Nome:',
	'flags-special-create-form-template' => 'Predefinição:',
	'flags-special-create-form-group' => 'Grupo:',
	'flags-special-create-form-targeting' => 'Audiência:',
	'flags-special-create-form-parameters' => 'Parâmetros:',
	'flags-special-create-form-parameters-name' => 'Nome',
	'flags-special-create-form-parameters-description' => 'Descrição',
	'flags-special-create-form-parameters-add' => 'Adicionar um novo parâmetro',
	'flags-special-create-form-cancel' => 'Cancelar',
	'flags-special-create-form-save' => 'Salvar',
	'flags-special-create-form-invalid-name' => 'Por favor, insira um nome adequado para a bandeira.',
	'flags-special-create-form-invalid-name-exists' => 'O nome da bandeira já está em uso. Por favor, escolha outro.',
	'flags-special-create-form-invalid-template' => 'Por favor, insira um nome adequado de predefinição para a bandeira.',
	'flags-special-create-form-invalid-param-name' => 'Por favor, insira nomes adequados para todos os parâmetros ou remova aqueles que estão vazios.',
	'flags-special-create-form-save-success' => 'Esta bandeira foi adicionada!',
	'flags-special-create-form-save-failure' => 'Infelizmente houve um erro. Tente novamente.',
	'flags-special-create-form-save-nochange' => 'Aparentemente nenhuma alteração foi feita.',
	'flags-special-create-form-no-parameters' => 'Nenhum parâmetro foi encontrado na predefinição fornecida.',
	'flags-special-create-form-fetch-params' => 'Obtenha parâmetros já utilizados na predefinição',
	'flags-special-autoload-delete-confirm' => 'Ao excluir a bandeira $1, ela também será removida de todos os artigos. Essa ação não pode ser desfeita. Você tem certeza?',
	'flags-special-autoload-delete-success' => 'A bandeira foi removida com sucesso.',
	'flags-special-autoload-delete-error' => 'Infelizmente não foi possível remover a bandeira. Por favor, tente novamente ou contate-nos.',
	'flags-special-list-header-name' => 'Nome da bandeira',
	'flags-special-list-header-template' => 'Nome da predefinição',
	'flags-special-list-header-group' => 'Grupo de bandeiras',
	'flags-special-list-header-target' => 'Audiência',
	'flags-special-list-header-parameters' => 'Parâmetros',
	'flags-special-list-header-actions' => 'Ações',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|Veja as bandeiras da Wikia em ação!]]',
	'flags-edit-flags-button-text' => 'Editar bandeiras',
	'flags-edit-form-more-info' => 'Mais informações >',
	'flags-edit-modal-cancel-button-text' => 'Cancelar',
	'flags-edit-modal-close-button-text' => 'Fechar',
	'flags-edit-modal-done-button-text' => 'Feito',
	'flags-edit-modal-no-flags-on-community' => 'Esta comunidade não tem nenhuma bandeira configurada. [[Help:Bandeiras|Saiba mais sobre as bandeiras]] ou [[Special:Flags|defina as bandeiras para esta comunidade]].',
	'flags-edit-modal-title' => 'Bandeiras',
	'flags-edit-modal-exception' => 'Infelizmente esta exibição não é possível em virtude do seguinte erro:


$1


Este erro já foi comunicado à equipe técnica. Sinta-se à vontade para usar [[Special:Contact]] para entrar em contato com a equipe de apoio da Wikia se este problema continuar.',
	'flags-edit-modal-post-exception' => 'Infelizmente não é possível completar o processo em virtude do seguinte erro:


$1


Este erro já foi comunicado à equipe técnica. Sinta-se à vontade para usar [[Special:Contact]] para entrar em contato com a equipe de apoio da Wikia se este problema continuar.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Desambiguação',
	'flags-groups-canon' => 'Cânone',
	'flags-groups-stub' => 'Bilhete',
	'flags-groups-delete' => 'Excluir',
	'flags-groups-improvements' => 'Melhorias',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Outro',
	'flags-groups-navigation' => 'Navegação',
	'flags-target-readers' => 'Leitores',
	'flags-target-contributors' => 'Contribuidores',
	'flags-icons-actions-edit' => 'Editar',
	'flags-icons-actions-delete' => 'Excluir este tipo de bandeiras',
	'flags-icons-actions-insights' => 'Abra uma nova aba contendo uma lista de páginas com esta bandeira',
	'flags-notification-templates-extraction' => 'As seguintes predefinições: "$1" foram reconhecidas como [[Special:Flags|Bandeiras]] e convertidas automaticamente. Para ver a mudança, visite [[Special:RecentChanges]] or [[Special:Log]].',
	'flags-edit-intro-notification' => 'Esta predefinição está associada com uma bandeira. Administre as bandeiras em [[Special:Flags]].',
	'flags-log-name' => 'Registro de bandeiras',
	'logentry-flags-flag-added' => '$1 adicionou a bandeira \'$4" à página $3',
	'logentry-flags-flag-removed' => "$1 removeu a bandeira '$4' da página $3",
	'logentry-flags-flag-parameter-added' => "$1 adicionou o valor '$7' como parâmetro '$5' da bandeira '$4' na página $3",
	'logentry-flags-flag-parameter-modified' => "$1 modificou o parâmetro '$5' da bandeira '$4' na página $3 de '$6' para '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 removeu o valor '$6' do parâmetro '$5' da bandeira '$4' na página $3",
);

$messages['ru'] = array(
	'flags-description' => 'Флаги предоставляют читателям и редакторам информацию о каждой статье, описывая содержание статьи, и/или действия, которые необходимо предпринять по отношению к статье',
	'flags-special-title' => 'Управление флагами',
	'flags-special-header-text' => 'Созданные на основе широко используемых информационных шаблонов, Флаги позволяют поднять организацию и маркировку статей на новый уровень. [[Справка:Флаги|Подробнее о флагах]].',
	'flags-special-zero-state' => 'Флаги на этой вики ещё не настроены. [[Справка:Флаги|Узнайте больше о флагах]].',
	'flags-special-create-button-text' => 'Создать флаг',
	'flags-special-create-form-title-new' => 'Создать флаг',
	'flags-special-create-form-title-edit' => 'Редактировать флаг',
	'flags-special-create-form-name' => 'Название:',
	'flags-special-create-form-template' => 'Шаблон:',
	'flags-special-create-form-group' => 'Группа:',
	'flags-special-create-form-targeting' => 'Целевая аудитория:',
	'flags-special-create-form-parameters' => 'Параметры:',
	'flags-special-create-form-parameters-name' => 'Название',
	'flags-special-create-form-parameters-description' => 'Описание',
	'flags-special-create-form-parameters-add' => 'Добавить новый параметр',
	'flags-special-create-form-cancel' => 'Отмена',
	'flags-special-create-form-save' => 'Сохранить',
	'flags-special-create-form-invalid-name' => 'Пожалуйста, введите допустимое название флага.',
	'flags-special-create-form-invalid-name-exists' => 'Название флага уже используется. Пожалуйста, выберите другое.',
	'flags-special-create-form-invalid-template' => 'Пожалуйста, введите правильное название шаблона для флага.',
	'flags-special-create-form-invalid-param-name' => 'Пожалуйста, введите правильные название всех параметров, или уберите незаполненные параметры.',
	'flags-special-create-form-save-success' => 'Флаг был успешно добавлен!',
	'flags-special-create-form-save-failure' => 'Произошла ошибка. Пожалуйста, попробуйте снова.',
	'flags-special-create-form-save-nochange' => 'Изменения не были применены.',
	'flags-special-create-form-no-parameters' => 'В данном шаблоне не было найдено ни одного параметра.',
	'flags-special-create-form-fetch-params' => 'Получить параметры, уже используемые в шаблоне',
	'flags-special-autoload-delete-confirm' => 'Удаление флага $1 также удалит его из всех статей. Это действие нельзя отменить. Вы уверены, что хотите удалить флаг?',
	'flags-special-autoload-delete-success' => 'Флаг был успешно удалён.',
	'flags-special-autoload-delete-error' => 'Произошла ошибка во время удаления флага. Пожалуйста, попробуйте снова, или свяжитесь с поддержкой Викия.',
	'flags-special-list-header-name' => 'Название флага',
	'flags-special-list-header-template' => 'Название шаблона',
	'flags-special-list-header-group' => 'Группа флагов',
	'flags-special-list-header-target' => 'Целевая аудитория',
	'flags-special-list-header-parameters' => 'Параметры',
	'flags-special-list-header-actions' => 'Действия',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|Взгляните  на Флаги в действии!]]',
	'flags-edit-flags-button-text' => 'Править флаги',
	'flags-edit-form-more-info' => 'Больше информации >',
	'flags-edit-modal-cancel-button-text' => 'Отмена',
	'flags-edit-modal-close-button-text' => 'Закрыть',
	'flags-edit-modal-done-button-text' => 'Готово',
	'flags-edit-modal-no-flags-on-community' => 'Флаги на этой вики ещё не настроены. [[Справка:Флаги|Узнайте больше о флагах]] или [[Special:Flags|настройте флаги для вашего сообщества]].',
	'flags-edit-modal-title' => 'Флаги',
	'flags-edit-modal-exception' => 'К сожалению, произошла следующая ошибка при отображении формы редактирования:



$1



Сообщение об ошибке было автоматически отправлено нашей команде инженеров. Пожалуйста, [[Special:Contact|свяжитесь с поддержкой Викия]], если вы продолжаете сталкиваться с этой ошибкой.',
	'flags-edit-modal-post-exception' => 'К сожалению, во время сохранения изменений произошла следующая ошибка:



$1



Сообщение об ошибке было автоматически отправлено нашей команде инженеров. Пожалуйста, [[Special:Contact|свяжитесь с поддержкой Викия]], если вы продолжаете сталкиваться с этой ошибкой.',
	'flags-groups-spoiler' => 'Спойлер',
	'flags-groups-disambig' => 'Неоднозначность',
	'flags-groups-canon' => 'Правила',
	'flags-groups-stub' => 'Требуется дополнение',
	'flags-groups-delete' => 'К удалению',
	'flags-groups-improvements' => 'К улучшению',
	'flags-groups-status' => 'Статус',
	'flags-groups-other' => 'Прочее',
	'flags-groups-navigation' => 'Навигация',
	'flags-target-readers' => 'Посетители',
	'flags-target-contributors' => 'Участники',
	'flags-icons-actions-edit' => 'Править',
	'flags-icons-actions-delete' => 'Удалить эту группу флагов',
	'flags-icons-actions-insights' => 'Открыть новую вкладку со списком статей, отмеченных данным флагом',
	'flags-notification-templates-extraction' => "Шаблон(ы): ''$1'' были распознаны, как [[Special:Flags|Флаги]] и автоматически конвертированы. Посетите [[Special:RecentChanges]] или [[Special:Log]], чтобы увидеть изменения.",
	'flags-edit-intro-notification' => 'Этот шаблон может быть использован, как [[Справка:Флаги|Флаг]]. [[Special:Flags|Управление флагами]].',
	'flags-log-name' => 'Журнал флагов',
	'logentry-flags-flag-added' => "$1 добавил флаг '$4' на страницу $3",
	'logentry-flags-flag-removed' => "$1 убрал флаг '$4' со страницы $3",
	'logentry-flags-flag-parameter-added' => "$1 установил значение '$7' для параметра '$5' флага '$4' на странице $3",
	'logentry-flags-flag-parameter-modified' => "$1 изменил параметр '$5' флага '$4' на странице $3 с '$6' на '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 убрал значение '$6' параметра '$5' флага '$4' на странице $3",
);

$messages['zh-hans'] = array(
	'flags-description' => '标识模版是为读者或编辑提供的文章相关信息，对内容或需要进行的操作进行描述。',
	'flags-special-title' => '管理标识模版条目',
	'flags-special-header-text' => '标识模版条目建在您已经知道和使用的通知模版的顶部，让您能够更加有效地对文章进行组织、管理和标注。此功能比以往任何时候都更强大。如需了解更多信息，请访问[[Help:Flags|标识模版帮助页]]。',
	'flags-special-zero-state' => '此社区尚未设置标识模版。[[Help:Flags|进一步了解标识模版功能]]。',
	'flags-special-create-button-text' => '创建标识',
	'flags-special-create-form-title-new' => '创建标识',
	'flags-special-create-form-title-edit' => '编辑标识',
	'flags-special-create-form-name' => '名称：',
	'flags-special-create-form-template' => '模板：',
	'flags-special-create-form-group' => '群组：',
	'flags-special-create-form-targeting' => '目標：',
	'flags-special-create-form-parameters' => '参量：',
	'flags-special-create-form-parameters-name' => '名称',
	'flags-special-create-form-parameters-description' => '描述',
	'flags-special-create-form-parameters-add' => '添加新的参量',
	'flags-special-create-form-cancel' => '取消',
	'flags-special-create-form-save' => '保存',
	'flags-special-create-form-invalid-name' => '请输入一个适当的标识名。',
	'flags-special-create-form-invalid-name-exists' => '这个标识名已有人使用。请选择其他标识名称。',
	'flags-special-create-form-invalid-template' => '请输入一个适当的标识模版名称。',
	'flags-special-create-form-invalid-param-name' => '请为所有参量输入适当的名称，或移除空白。',
	'flags-special-create-form-save-success' => '标识已添加！',
	'flags-special-create-form-save-failure' => '抱歉，出现错误。能再试一次吗？',
	'flags-special-create-form-save-nochange' => '似乎未进行任何更改。',
	'flags-special-create-form-no-parameters' => '在所提供的模版中未找到任何参量。',
	'flags-special-create-form-fetch-params' => '获取该模版中所用的参量',
	'flags-special-autoload-delete-confirm' => '删除$1 标识会移除所有的文章。此操作无法撤消。确定要删除？',
	'flags-special-autoload-delete-success' => '标识已被成功地移除。',
	'flags-special-autoload-delete-error' => '抱歉，我们无法移除这个标识。请再试一次或联系我们。',
	'flags-special-list-header-name' => '标识模版名称',
	'flags-special-list-header-template' => '模版名称',
	'flags-special-list-header-group' => '标识模版群组',
	'flags-special-list-header-target' => '目标用户群',
	'flags-special-list-header-parameters' => '参量',
	'flags-special-list-header-actions' => '操作',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|查看使用中的维基标识模版条目！]]',
	'flags-edit-flags-button-text' => '编辑模版标识',
	'flags-edit-form-more-info' => '更多信息 >',
	'flags-edit-modal-cancel-button-text' => '取消',
	'flags-edit-modal-close-button-text' => '关闭',
	'flags-edit-modal-done-button-text' => '完成',
	'flags-edit-modal-no-flags-on-community' => '此社区尚未设置模版标识。[[Help:Flags|进一步了解标识模版功能]]或[[Special:Flags|为此社区设置标识模版]]。',
	'flags-edit-modal-title' => '标识模版',
	'flags-edit-modal-exception' => '抱歉，由于下列错误，我们无法显示此信息：



$1



此错误已经报告给技术团队。如果您再碰到这个问题，请随时通过[[Special:Contact|联系我们]]与Wikia的支持团队联系。',
	'flags-edit-modal-post-exception' => '抱歉，由于下列错误，我们无法显示此信息：



$1



此错误已经报告给技术团队。如果您再次碰到这个问题，请随时通过[[Special:Contact|联系我们]]与Wikia支持团队联系。',
	'flags-groups-spoiler' => '剧透',
	'flags-groups-disambig' => '模棱两可',
	'flags-groups-canon' => '标准',
	'flags-groups-stub' => '存根',
	'flags-groups-delete' => '删除',
	'flags-groups-improvements' => '提升',
	'flags-groups-status' => '状况',
	'flags-groups-other' => '其他',
	'flags-groups-navigation' => '导航',
	'flags-target-readers' => '读者',
	'flags-target-contributors' => '贡献者',
	'flags-icons-actions-edit' => '编辑',
	'flags-icons-actions-delete' => '删除此类标识',
	'flags-icons-actions-insights' => '打开一个含此标识的新的问题页面列表选项卡',
	'flags-notification-templates-extraction' => "下面的模版''\$ 1''被识别为[[Special:Flags|标识模版]]并自动转换。如需查看此更改，请访问[[Special:最新更改]]或[[Special:日志]]。",
	'flags-edit-intro-notification' => '此模版与标识模版有关。点击[[Special:Flags|标识模版]]管理条目。',
	'flags-log-name' => '标识模版日志',
	'logentry-flags-flag-added' => "$1添加了一个'$4'标识到$3页面",
	'logentry-flags-flag-removed' => "$1已从$3页面删除了'$4'的标识模版",
	'logentry-flags-flag-parameter-added' => "$1已在$3页面添加了'$4'标识模版中参量'$5'的'$7'值",
	'logentry-flags-flag-parameter-modified' => "$1已将$3页面上'$4'标识模版的'$5' 参量由'$6'改为'$7'",
	'logentry-flags-flag-parameter-removed' => "$1已移除了$3页面上'$4'的标识模版中参量'$5'的'$6'值",
);

$messages['zh-hant'] = array(
	'flags-description' => '標誌模板是為讀者或編輯提供的文章相關信息，對内容或需要進行的操作進行描述。',
	'flags-special-title' => '管理標誌模板條目',
	'flags-special-header-text' => '標誌模板條目出現在你已經知道和使用的通知模版的頂部，讓你能夠更加有效地對文章進行組織、管理和標註。此功能比以往任何時候都更強大。如需了解更多資訊，請訪問[[Help:Flags|標誌模板幫助頁]]。',
	'flags-special-zero-state' => '這個社區還沒有設置標誌模板。[[Help:Flags|進一步了解標誌模板功能]]。',
	'flags-special-create-button-text' => '创建標誌',
	'flags-special-create-form-title-new' => '创建標誌',
	'flags-special-create-form-title-edit' => '編輯標誌',
	'flags-special-create-form-name' => '名稱：',
	'flags-special-create-form-template' => '模版：',
	'flags-special-create-form-group' => '群組：',
	'flags-special-create-form-targeting' => '目標：',
	'flags-special-create-form-parameters' => '參量：',
	'flags-special-create-form-parameters-name' => '名稱',
	'flags-special-create-form-parameters-description' => '描述',
	'flags-special-create-form-parameters-add' => '添加新的參量',
	'flags-special-create-form-cancel' => '取消',
	'flags-special-create-form-save' => '保存',
	'flags-special-create-form-invalid-name' => '請輸入一個適當的標誌名稱。',
	'flags-special-create-form-invalid-name-exists' => '這個標誌名稱已被使用。請選擇其他標識名稱。',
	'flags-special-create-form-invalid-template' => '請輸入一個適當的標誌模版名稱。',
	'flags-special-create-form-invalid-param-name' => '請為所有參量輸入適當的名稱，或移除空白字元。',
	'flags-special-create-form-save-success' => '標誌已添加！',
	'flags-special-create-form-save-failure' => '抱歉，出現錯誤。能再試一次嗎？',
	'flags-special-create-form-save-nochange' => '似乎沒有進行任何更改。',
	'flags-special-create-form-no-parameters' => '在給定模版中沒有找到任何參量。',
	'flags-special-create-form-fetch-params' => '獲取這個模版中所用的參量',
	'flags-special-autoload-delete-confirm' => '刪除$1 標誌會移除所有的文章。這個操作無法撤銷。確定要刪除嗎？',
	'flags-special-autoload-delete-success' => '已成功移除這個標誌',
	'flags-special-autoload-delete-error' => '抱歉，我們無法移除這個標識。請再試一次或聯係我們。',
	'flags-special-list-header-name' => '標誌模板名稱',
	'flags-special-list-header-template' => '模版名稱',
	'flags-special-list-header-group' => '標誌模板群組',
	'flags-special-list-header-target' => '目標用戶群',
	'flags-special-list-header-parameters' => '參量',
	'flags-special-list-header-actions' => '操作',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|查看使用中的維基標誌模板條目！]]',
	'flags-edit-flags-button-text' => '編輯標誌模版',
	'flags-edit-form-more-info' => '更多信息 >',
	'flags-edit-modal-cancel-button-text' => '取消',
	'flags-edit-modal-close-button-text' => '關閉',
	'flags-edit-modal-done-button-text' => '完成',
	'flags-edit-modal-no-flags-on-community' => '這個社區還沒有設置模板標誌功能。[[Help:Flags|進一步了解標誌模板]]或[[Special:Flags|為這個社區定義標誌模板]]。',
	'flags-edit-modal-title' => '標誌模板',
	'flags-edit-modal-exception' => '抱歉，由於下列錯誤，我們無法顯示此信息：



$1




這個錯誤已經被報告給技術團隊。如果再踫到這個問題，請隨時透過[[Special:Contact|Special:聯係我們]]與Wikia的支援團隊聯係。',
	'flags-edit-modal-post-exception' => '抱歉，由於下列錯誤，我們無法顯示此信息：



$1




這個錯誤已經被報告給技術團隊。如果再踫到這個問題，請隨時透過[[Special:Contact|聯係我們]]與Wikia的支援團隊聯係。',
	'flags-groups-spoiler' => '劇透',
	'flags-groups-disambig' => '模棱兩可',
	'flags-groups-canon' => '標準',
	'flags-groups-stub' => '存根',
	'flags-groups-delete' => '刪除',
	'flags-groups-improvements' => '提升',
	'flags-groups-status' => '狀況',
	'flags-groups-other' => '其他',
	'flags-groups-navigation' => '導航',
	'flags-target-readers' => '讀者',
	'flags-target-contributors' => '貢獻者',
	'flags-icons-actions-edit' => '編輯',
	'flags-icons-actions-delete' => '刪除此類標誌',
	'flags-icons-actions-insights' => '打開一個標有這個標誌的新的問題頁面列表選項卡',
	'flags-notification-templates-extraction' => "下面的模版''\$ 1''被辨識為[[Special:Flags|標誌模板]]並已自動轉換。如需查看所做的更改，請訪問[[Special:RecentChanges|Special:更新更改]]或[[Special:Log|Special:日志]]。",
	'flags-edit-intro-notification' => '這個模版與標誌模板關聯。如果要管理標誌模板條目，請按一下[[Special:Flags|Special:標誌模板]]。',
	'flags-log-name' => '標誌模板日誌',
	'logentry-flags-flag-added' => "$1 添加了一個'$4'標識到$3",
	'logentry-flags-flag-removed' => "$1 已經從$3頁面刪除了'$4'標誌",
	'logentry-flags-flag-parameter-added' => "$1已經在$3頁面上添加了'$4'提醒中參量'$5'的'$7'值",
	'logentry-flags-flag-parameter-modified' => "$1已經將$3頁面上'$4'標誌模板的'$5'參量由'$6'改爲'$7'",
	'logentry-flags-flag-parameter-removed' => "$1已經移除$3頁面上'$4'標誌模板中參量'$5'的'$6'值",
);

