<?php
$messages = array();

$messages['en'] = array(
	'flags-description' => 'Flags are per article information for reader or editors that describe the content or action required',
	'flags-special-title' => 'Manage Flags',
	'flags-special-header-text' => 'Built on top of the notice templates you already know and use, Flags allow for more powerful article organization, management, and labeling than ever before. Visit [[Help:Flags]] to learn more.',
	'flags-special-zero-state' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]].",
	'flags-special-list-header-name' => 'Flag name',
	'flags-special-list-header-template' => 'Template name',
	'flags-special-list-header-group' => 'Flag group',
	'flags-special-list-header-target' => 'Target',
	'flags-special-list-header-parameters' => 'Parameters',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|See Wikia Flags in action!]]',
	'flags-edit-flags-button-text' => 'Edit flags',
	'flags-edit-form-more-info' => 'More info >',
	'flags-edit-modal-cancel-button-text' => 'Cancel',
	'flags-edit-modal-close-button-text' => 'Close',
	'flags-edit-modal-done-button-text' => 'Done',
	'flags-edit-modal-no-flags-on-community' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]] or [[Special:Flags|define the flags for this community]].",
	'flags-edit-modal-title' => 'Flags',
	'flags-edit-modal-exception' => 'Unfortunately, we are not able to display this due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Wikia support team if you continue to see this issue.',
	'flags-edit-modal-post-exception' => 'Unfortunately, we are not able to complete the process due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Wikia support team if you continue to see this issue.',
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
	'flags-special-list-header-name' => 'A column name for a Flag name.',
	'flags-special-list-header-template' => 'A column name for an associated Template name.',
	'flags-special-list-header-group' => 'A column name for a Flag group.',
	'flags-special-list-header-target' => 'A column name for a Flag targeting (who should we display the flag to - everybody or only contributors).',
	'flags-special-list-header-parameters' => 'A column name for a Flag parameters.',
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
	'flags-special-list-header-name' => 'Name der Markierung',
	'flags-special-list-header-template' => 'Name der Vorlage',
	'flags-special-list-header-group' => 'Markierungsgruppe',
	'flags-special-list-header-target' => 'Zielgruppe',
	'flags-special-list-header-parameters' => 'Parameter',
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
	'flags-target-readers' => 'Leser',
	'flags-target-contributors' => 'Benutzer',
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
	'flags-special-header-text' => 'Creados arriba de las plantillas de notificaciones que ya conoces y usas, los avisos permiten que los artículos se organicen, manejen y etiqueten de mejor manera que antes. Visita [[Help:Avisos]] para saber más.',
	'flags-special-zero-state' => 'Esta comunidad no tiene configurado ningún aviso. [[Help:Avisos|Conoce más sobre los avisos]].',
	'flags-special-list-header-name' => 'Nombre del aviso',
	'flags-special-list-header-template' => 'Nombre de la plantilla',
	'flags-special-list-header-group' => 'Grupo de avisos',
	'flags-special-list-header-target' => 'Destinatario',
	'flags-special-list-header-parameters' => 'Parámetros',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|¡Mira los avisos de Wikia en acción!]]',
	'flags-edit-flags-button-text' => 'Editar avisos',
	'flags-edit-form-more-info' => 'Más información >',
	'flags-edit-modal-cancel-button-text' => 'Cancelar',
	'flags-edit-modal-close-button-text' => 'Cerrar',
	'flags-edit-modal-done-button-text' => 'Hecho',
	'flags-edit-modal-no-flags-on-community' => 'Esta comunidad no tiene avisos configurados. [[Help:Avisos|Learn more about flags]] or [[Special:Flags|definir los avisos para esta comunidad]].',
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
	'flags-target-readers' => 'Lectores',
	'flags-target-contributors' => 'Editores',
	'flags-notification-templates-extraction' => "Las siguientes plantillas: ''$1''fueron reconocidas como [[Special:Flags|Avisos]] y se convirtieron automáticamente. Para ver el cambio visita [[Special:RecentChanges]] o [[Special:Log]].",
	'flags-edit-intro-notification' => 'Esta plantilla está asociada con un aviso. Maneja los avisos en [[Special:Flags]].',
	'flags-log-name' => 'Registro de avisos',
	'logentry-flags-flag-added' => "$1 añadió el aviso '$4' a la página $3",
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
	'flags-special-list-header-name' => 'Nom du flag',
	'flags-special-list-header-template' => 'Nom du modèle',
	'flags-special-list-header-group' => 'Groupe du flag',
	'flags-special-list-header-target' => 'Cible',
	'flags-special-list-header-parameters' => 'Paramètres',
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
	'flags-target-readers' => 'Lecteurs',
	'flags-target-contributors' => 'Contributeurs',
	'flags-notification-templates-extraction' => "Les modèles ''$1'' ont été reconnus comme des [[Special:Flags|flags]] et automatiquement convertis. Pour voir ce qui a changé, visitez la page [[Spécial:Modifications_récentes]] ou [[Spécial:Journal]].",
	'flags-edit-intro-notification' => 'Ce modèle est associé à un flag. Pour gérer les flags, visitez la page [[Special:Flags]].',
	'flags-log-name' => 'Journal des flags',
	'logentry-flags-flag-added' => "$1 a ajouté le flag '$4' à la page $3.",
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
	'flags-special-list-header-name' => 'Nome del contrassegno',
	'flags-special-list-header-template' => 'Nome del modello',
	'flags-special-list-header-group' => 'Gruppo di contrassegni',
	'flags-special-list-header-target' => 'Destinatario',
	'flags-special-list-header-parameters' => 'Parametri',
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
	'flags-target-readers' => 'Lettori',
	'flags-target-contributors' => 'Collaboratori',
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
	'flags-special-header-text' => 'すでに使い慣れている通知テンプレートをベースに構築されたフラッグは、これまでよりもさらに効果的に記事を整理、管理、ラベル付けすることができる機能です。詳しくは、[[Help:フラッグ]]をご覧ください。',
	'flags-special-zero-state' => 'このコミュニティにはフラッグが設定されていません。[[Help:フラッグ|フラッグについての詳細]]をご覧ください。',
	'flags-special-list-header-name' => 'フラッグ名',
	'flags-special-list-header-template' => 'テンプレート名',
	'flags-special-list-header-group' => 'フラッググループ',
	'flags-special-list-header-target' => 'ターゲット',
	'flags-special-list-header-parameters' => 'パラメータ',
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
	'flags-target-readers' => '閲覧者',
	'flags-target-contributors' => '投稿者',
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
	'flags-special-list-header-name' => 'Flag name',
	'flags-special-list-header-template' => 'Template name',
	'flags-special-list-header-group' => 'Flag group',
	'flags-special-list-header-target' => 'Target',
	'flags-special-list-header-parameters' => 'Parameters',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|See Wikia Flags in action!]]',
	'flags-edit-flags-button-text' => 'Edit flags',
	'flags-edit-form-more-info' => 'More info >',
	'flags-edit-modal-cancel-button-text' => 'Cancel',
	'flags-edit-modal-close-button-text' => 'Close',
	'flags-edit-modal-done-button-text' => 'Done',
	'flags-edit-modal-no-flags-on-community' => "This community doesn't have any flags set up. [[Help:Flags|Learn more about flags]] or [[Special:Flags|define the flags for this community]].",
	'flags-edit-modal-title' => 'Flags',
	'flags-edit-modal-exception' => 'Unfortunately, we are not able to display this due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Wikia support team if you continue to see this issue.',
	'flags-edit-modal-post-exception' => 'Unfortunately, we are not able to complete the process due to the following error:



$1



This error has already been reported to the technical team. Please feel free to use [[Special:Contact]] to get in contact with Wikia support team if you continue to see this issue.',
	'flags-groups-spoiler' => 'Spoiler',
	'flags-groups-disambig' => 'Disambiguation',
	'flags-groups-canon' => 'Canon',
	'flags-groups-stub' => 'Stub',
	'flags-groups-delete' => 'Delete',
	'flags-groups-improvements' => 'Improvements',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Other',
	'flags-target-readers' => 'Readers',
	'flags-target-contributors' => 'Contributors',
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
	'logentry-flags-flag-added' => "Użytkownik $1 dodał flagę '$4' do strony $3",
	'logentry-flags-flag-removed' => "Użytkownik $1 usunął flagę '$4' ze strony $3",
	'flags-special-title' => 'Zarządzaj Flagami',
	'flags-special-header-text' => 'Zbudowane na bazie szablonów uwag, które znasz i z których korzystasz, Flagi pozwalają lepiej organizować, zarządzać i znakować artykuły. Odwiedź stronę [[Help:Flagi]], aby dowiedzieć się więcej.',
	'flags-special-zero-state' => 'Ta społeczność nie ma ustawionych flag. [[Help:Flags|Więcej informacji na temat flag]].',
	'flags-special-list-header-name' => 'Nazwa flagi',
	'flags-special-list-header-template' => 'Nazwa szablonu',
	'flags-special-list-header-group' => 'Grupa flag',
	'flags-special-list-header-target' => 'Grupa docelowa',
	'flags-special-list-header-parameters' => 'Parametry',
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
	'flags-groups-stub' => 'Kupon',
	'flags-groups-delete' => 'Usuń',
	'flags-groups-improvements' => 'Ulepszenia',
	'flags-groups-status' => 'Status',
	'flags-groups-other' => 'Inne',
	'flags-target-readers' => 'Czytelnicy',
	'flags-target-contributors' => 'Użytkownicy',
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
	'flags-special-list-header-name' => 'Nome da bandeira',
	'flags-special-list-header-template' => 'Nome da predefinição',
	'flags-special-list-header-group' => 'Grupo de bandeiras',
	'flags-special-list-header-target' => 'Audiência',
	'flags-special-list-header-parameters' => 'Parâmetros',
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
	'flags-target-readers' => 'Leitores',
	'flags-target-contributors' => 'Contribuidores',
	'flags-notification-templates-extraction' => 'As seguintes predefinições: "$1" foram reconhecidas como [[Special:Flags|Bandeiras]] e convertidas automaticamente. Para ver a mudança, visite [[Special:RecentChanges]] or [[Special:Log]].',
	'flags-edit-intro-notification' => 'Esta predefinição está associada com uma bandeira. Administre as bandeiras em [[Special:Flags]].',
	'flags-log-name' => 'Registro de bandeiras',
	'logentry-flags-flag-added' => "$1 adicionou a bandeira '$4' à página $3",
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
	'flags-special-list-header-name' => 'Название флага',
	'flags-special-list-header-template' => 'Название шаблона',
	'flags-special-list-header-group' => 'Группа флагов',
	'flags-special-list-header-target' => 'Целевая аудитория',
	'flags-special-list-header-parameters' => 'Параметры',
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
	'flags-groups-other' => 'Другие',
	'flags-target-readers' => 'Посетители',
	'flags-target-contributors' => 'Участники',
	'flags-notification-templates-extraction' => "Шаблон(ы): ''$1'' были распознаны, как [[Special:Flags|Флаги]] и автоматически конвертированы. Посетите [[Special:RecentChanges]] или [[Special:Log]], чтобы увидеть изменения.",
	'flags-edit-intro-notification' => 'Этот шаблон распознан, как [[Справка:Флаги|Флаг]]. [[Special:Flags|Управление флагами]].',
	'flags-log-name' => 'Журнал флагов',
	'logentry-flags-flag-added' => "$1 добавил флаг '$4' на страницу $3",
	'logentry-flags-flag-removed' => "$1 убрал флаг '$4' со страницы $3",
	'logentry-flags-flag-parameter-added' => "$1 установил значение '$7' для параметра '$5' флага '$4' на странице $3",
	'logentry-flags-flag-parameter-modified' => "$1 изменил параметр '$5' флага '$4' на странице $3 с '$6' на '$7'",
	'logentry-flags-flag-parameter-removed' => "$1 убрал значение '$6' параметра '$5' флага '$4' на странице $3",
);

$messages['zh-hans'] = array(
	'flags-description' => '提醒是为读者或编辑提供的文章相关信息，对内容或需要进行的操作进行描述。',
	'flags-special-title' => '管理提醒条目',
	'flags-special-header-text' => '提醒条目建在您已经知道和使用的通知模版的顶部，让您能够更加有效地对文章进行组织、管理和标注。此功能比以往任何时候都更强大。如需了解更多信息，请访问[[Help:提醒]]。',
	'flags-special-zero-state' => '此社区尚未设置提醒。[[Help:Flags|进一步了解提醒]]。',
	'flags-special-list-header-name' => '提醒名称',
	'flags-special-list-header-template' => '模版名称',
	'flags-special-list-header-group' => '提醒群组',
	'flags-special-list-header-target' => '目标用户群',
	'flags-special-list-header-parameters' => '参量',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|查看使用中的维基提醒条目！]]',
	'flags-edit-flags-button-text' => '编辑提醒',
	'flags-edit-form-more-info' => '更多信息 >',
	'flags-edit-modal-cancel-button-text' => '取消',
	'flags-edit-modal-close-button-text' => '关闭',
	'flags-edit-modal-done-button-text' => '完成',
	'flags-edit-modal-no-flags-on-community' => '此社区尚未设置提醒。[[Help:Flags|进一步了解提醒]]或[[Special:Flags|为此社区设置提醒。]]。',
	'flags-edit-modal-title' => '提醒',
	'flags-edit-modal-exception' => '抱歉，由于下列错误，我们无法显示此信息：



$1



此错误已经报告给技术团队。如果您再碰到这个问题，请随时通过[[Special：联系我们]]与Wikia的支持团队联系。',
	'flags-edit-modal-post-exception' => '抱歉，由于下列错误，我们无法显示此信息：



$1



此错误已经报告给技术团队。如果您再次碰到这个问题，请随时通过[[Special：联系我们]与Wikia支持团队联系。',
	'flags-groups-spoiler' => '剧透',
	'flags-groups-disambig' => '模棱两可',
	'flags-groups-canon' => '标准',
	'flags-groups-stub' => '存根',
	'flags-groups-delete' => '删除',
	'flags-groups-improvements' => '提升',
	'flags-groups-status' => '状况',
	'flags-groups-other' => '其他',
	'flags-target-readers' => '读者',
	'flags-target-contributors' => '贡献者',
	'flags-notification-templates-extraction' => "下面的模版''\$ 1''被识别为[Special:Flags|提醒]]并自动转换。如需查看此更改，请访问[[Special:最新更改]]或[[Special:日志]。",
	'flags-edit-intro-notification' => '此模版与提醒关联。点击[[Special:提醒]]管理提醒条目。',
	'flags-log-name' => '提醒日志',
	'logentry-flags-flag-added' => "$1 已将'$4'的提醒添加到$3页面",
	'logentry-flags-flag-removed' => "$1已从$3页面删除了'$4'的提醒",
	'logentry-flags-flag-parameter-added' => "$1已在$3页面添加了'$4'提醒中参量'$5'的'$7'值",
	'logentry-flags-flag-parameter-modified' => "$1已将$3页面上'$4'提醒的'$5' 参量由'$6'改为'$7'",
	'logentry-flags-flag-parameter-removed' => "$1已移除了$3页面上'$4'的提醒中参量'$5'的'$6'值",
);

$messages['zh-hant'] = array(
	'flags-description' => '提醒是為讀者或編輯提供的文章相關信息，對内容或需要進行的操作進行描述。',
	'flags-special-title' => '管理提醒條目',
	'flags-special-header-text' => '提醒條目建在你已經知道和使用的通知模版的頂部，讓你能夠更加有效地對文章進行組織、管理和標註。此功能比以往任何時候都更強大。如需了解更多資訊，請訪問[[Help:提醒]]。',
	'flags-special-zero-state' => '這個社區還沒有設置提醒。[[Help:Flags|進一步了解提醒]]。',
	'flags-special-list-header-name' => '提醒名稱',
	'flags-special-list-header-template' => '模版名稱',
	'flags-special-list-header-group' => '提醒群組',
	'flags-special-list-header-target' => '目標用戶群',
	'flags-special-list-header-parameters' => '參量',
	'flags-special-video' => '[[File:Wikia_Flags|250px|right|查看使用中的維基提醒條目！]]',
	'flags-edit-flags-button-text' => '編輯提醒',
	'flags-edit-form-more-info' => '更多信息 >',
	'flags-edit-modal-cancel-button-text' => '取消',
	'flags-edit-modal-close-button-text' => '關閉',
	'flags-edit-modal-done-button-text' => '完成',
	'flags-edit-modal-no-flags-on-community' => '這個社區還沒有設置提醒。[[Help:Flags|進一步了解提醒]]或[[Special:Flags|為這個社區定義提醒]]。',
	'flags-edit-modal-title' => '提醒',
	'flags-edit-modal-exception' => '抱歉，由於下列錯誤，我們無法顯示此信息：



$1




這個錯誤已經被報告給技術團隊。如果再踫到這個問題，請隨時透過[[Special：聯係我們]]與Wikia的支援團隊聯係。',
	'flags-edit-modal-post-exception' => '抱歉，由於下列錯誤，我們無法顯示此信息：



$1




這個錯誤已經被報告給技術團隊。如果再踫到這個問題，請隨時透過[[Special：聯係我們]]與Wikia的支援團隊聯係。',
	'flags-groups-spoiler' => '劇透',
	'flags-groups-disambig' => '模棱兩可',
	'flags-groups-canon' => '標準',
	'flags-groups-stub' => '存根',
	'flags-groups-delete' => '刪除',
	'flags-groups-improvements' => '提升',
	'flags-groups-status' => '狀況',
	'flags-groups-other' => '其他',
	'flags-target-readers' => '讀者',
	'flags-target-contributors' => '貢獻者',
	'flags-notification-templates-extraction' => "下面的模版''\$ 1''被辨識為[Special:Flags|提醒]]並已自動轉換。如需查看所做的更改，請訪問[[Special:更新更改]]或[[Special:日至]。",
	'flags-edit-intro-notification' => '這個模版與提醒關聯。如果要管理提醒條目，請按一下[[Special:提醒]]。',
	'flags-log-name' => '提醒日誌',
	'logentry-flags-flag-added' => "$1 已經將'$4'提醒添加到$3頁面",
	'logentry-flags-flag-removed' => "$1 已經從$3頁面刪除了'$4'標誌",
	'logentry-flags-flag-parameter-added' => "$1已經在$3頁面上添加了'$4'提醒中參量'$5'的'$7'值",
	'logentry-flags-flag-parameter-modified' => "$1已經將$3頁面上'$4'提醒的'$5'參量由'$6'改爲'$7'",
	'logentry-flags-flag-parameter-removed' => "$1已經移除$3頁面上'$4'提醒中參量'$5'的'$6'值",
);

