<?php
/**
 * Internationalisation file for extension Todo.
 *
 * @addtogroup Extensions
 * @author Bertrand GRONDIN
 */

$messages = array();

$messages['en'] = array(
	'todo'                  => 'Todo list',
	'todo-desc'             => 'Experimental personal [[Special:Todo|todo list]] extension',
	'todo-tab'              => 'todo',
	'todo-new-queue'        => 'new',
	'todo-mail-subject'     => "Completed item on $1's todo list",
	'todo-mail-body'        => "You requested e-mail confirmation about the completion of an item you submitted to $1's online todo list.

Item: $2
Submitted: $3

This item has been marked as completed, with this comment:
$4",
	'todo-invalid-item'     => "Missing or invalid item",
	'todo-update-else-item' => "Trying to update someone else's items",
	'todo-unrecognize-type' => "Unrecognized type",
	'todo-user-invalide'    => "Todo given invalid, missing, or un-todoable user.",
	'todo-item-list'        => 'Your items',
	'todo-no-item'          => 'No todo items.',
	'todo-invalid-owner'    => 'Invalid owner on this item',
	'todo-add-queue'        => 'Add queue…',
	'todo-move-queue'       => 'Move to queue…',
	'todo-list-for'         => 'Todo list for',
	'todo-list-change'      => 'Change',
	'todo-list-cancel'      => 'Cancel',
	'todo-new-item'         => 'New item',
	'todo-issue-summary'    => 'Issue summary:',
	'todo-form-details'     => 'Details:',
	'todo-form-email'       => 'To receive notification by e-mail when the item is closed, type your address here:',
	'todo-form-submit'      => 'Submit query',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 */
$messages['qqq'] = array(
	'todo-desc' => 'Short description of the Todo extension, shown in [[Special:Version]]. Do not translate or change links.',
	'todo-new-queue' => '{{Identical|New}}',
	'todo-list-for' => '{{Identical|Todo list for}}',
	'todo-list-cancel' => '{{Identical|Cancel}}',
	'todo-form-details' => '{{Identical|Details}}',
	'todo-form-submit' => '{{Identical|Submit query}}',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'todo-list-cancel' => "Mao'ạki",
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'todo-list-cancel' => 'Keskevytä',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'todo-list-cancel' => 'Tiaki',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'todo-new-queue' => 'nuut',
	'todo-list-cancel' => 'Kanselleer',
	'todo-form-details' => 'Details:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'todo-new-queue' => 'አዲስ',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'todo' => 'قائمة للعمل',
	'todo-desc' => 'امتداد [[Special:Todo|قائمة للعمل]] شخصية تجريبي',
	'todo-tab' => 'للعمل',
	'todo-new-queue' => 'جديد',
	'todo-mail-subject' => 'المدخلة المكملة في قائمة $1 للعمل',
	'todo-mail-body' => 'أنت طلبت تأكيدا بالبريد الإلكتروني حول إكمال مدخلة أنت أضفتها إلى قائمة $1 للعمل.

المدخلة: $2
المنفذة: $3

هذه المدخلة تم التعليم عليها كمكملة، مع هذا التعليق:
$4',
	'todo-invalid-item' => 'مدخلة مفقودة أو غير صحيحة',
	'todo-update-else-item' => 'محاولة تحديث مدخلات شخص آخر',
	'todo-unrecognize-type' => 'نوع غير متعرف عليه',
	'todo-user-invalide' => 'للعمل معطاة مستخدم غير صحيح، مفقود، أو لا يمكن إضافته للعمل.',
	'todo-item-list' => 'مدخلاتك',
	'todo-no-item' => 'لا مدخلات للعمل.',
	'todo-invalid-owner' => 'مالك غير صحيح لهذه المدخلة',
	'todo-add-queue' => 'أضف الطابور...',
	'todo-move-queue' => 'انقل إلى الطابور...',
	'todo-list-for' => 'قائمة للعمل ل',
	'todo-list-change' => 'تغيير',
	'todo-list-cancel' => 'إلغاء',
	'todo-new-item' => 'مدخلة جديدة',
	'todo-issue-summary' => 'ملخص القضية:',
	'todo-form-details' => 'التفاصيل:',
	'todo-form-email' => 'لاستقبال إخطار بواسطة البريد الإلكتروني عندما يتم إغلاق المدخلة، اكتب عنوانك هنا:',
	'todo-form-submit' => 'تنفيذ الاستعلام',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'todo' => 'قائمة للعمل',
	'todo-desc' => 'امتداد [[Special:Todo|قائمة للعمل]] شخصية تجريبي',
	'todo-tab' => 'للعمل',
	'todo-new-queue' => 'جديد',
	'todo-mail-subject' => 'المدخلة المكملة فى قائمة $1 للعمل',
	'todo-mail-body' => 'أنت طلبت تأكيدا بالبريد الإلكترونى حول إكمال مدخلة أنت أضفتها إلى قائمة $1 للعمل.

المدخلة: $2
المنفذة: $3

هذه المدخلة تم التعليم عليها كمكملة، مع هذا التعليق:
$4',
	'todo-invalid-item' => 'مدخلة مفقودة أو غير صحيحة',
	'todo-update-else-item' => 'محاولة تحديث مدخلات شخص آخر',
	'todo-unrecognize-type' => 'نوع غير متعرف عليه',
	'todo-user-invalide' => 'للعمل معطاة يوزر مش  صحيح، مفقود، أو مش ممكن إضافته للعمل.',
	'todo-item-list' => 'مدخلاتك',
	'todo-no-item' => 'لا مدخلات للعمل.',
	'todo-invalid-owner' => 'مالك غير صحيح لهذه المدخلة',
	'todo-add-queue' => 'أضف الطابور...',
	'todo-move-queue' => 'انقل إلى الطابور...',
	'todo-list-for' => 'قائمة للعمل ل',
	'todo-list-change' => 'تغيير',
	'todo-list-cancel' => 'إلغاء',
	'todo-new-item' => 'مدخلة جديدة',
	'todo-issue-summary' => 'ملخص القضية:',
	'todo-form-details' => 'التفاصيل:',
	'todo-form-email' => 'لاستقبال إخطار بواسطة البريد الإلكترونى عندما يتم إغلاق المدخلة، اكتب عنوانك هنا:',
	'todo-form-submit' => 'تنفيذ الاستعلام',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'todo' => 'Списък със задачи',
	'todo-desc' => 'Експериментално разширение за създаване на персонален [[Special:Todo|списък със задачи]]',
	'todo-unrecognize-type' => 'Неразпознат тип',
	'todo-add-queue' => 'Добавяне на опашка…',
	'todo-move-queue' => 'Преместване в опашка…',
	'todo-list-for' => 'Списък със задачи за',
	'todo-list-change' => 'Промяна',
	'todo-list-cancel' => 'Отмяна',
	'todo-issue-summary' => 'Резюме:',
	'todo-form-details' => 'Детайли:',
	'todo-form-email' => 'За получаване на оповестително писмо при приключване на задачата е необходимо да въведете своя адрес за е-поща:',
	'todo-form-submit' => 'Изпращане на заявка',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'todo-new-queue' => 'novi',
	'todo-form-details' => 'Detalji:',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'todo' => 'Seznam úkolů',
	'todo-desc' => 'Osobní [[Special:Todo|seznam úkolů]] (experimentální rozšíření)',
	'todo-tab' => 'seznam úkolů',
	'todo-new-queue' => 'nová',
	'todo-mail-subject' => 'Dokončený úkol ze seznamu uživatele $1',
	'todo-mail-body' => 'Žádali jste o potvrzovací email po dokončení úkolu, který jste poslali do seznamu úloh uživatele $1.

Úkol: $2
Posláno: $3

Tento úkol byl označen jako dokončený s tímto komentářem:
$4',
	'todo-invalid-item' => 'Chybějící nebo neplatný úkol',
	'todo-update-else-item' => 'Pokoušíte se aktualizovat úkoly někoho jiného',
	'todo-unrecognize-type' => 'Nerozpoznaný typ',
	'todo-user-invalide' => 'Zadaný úkol je neplatný, chybí nebo uživatel nepoužívá seznam úkolů.',
	'todo-item-list' => 'Vaše úkoly',
	'todo-no-item' => 'Žádné úkoly.',
	'todo-invalid-owner' => 'Vlastník této položky je neplatný',
	'todo-add-queue' => 'Přidat frontu…',
	'todo-move-queue' => 'Přesunout do fronty…',
	'todo-list-for' => 'Seznam úkolů uživatele',
	'todo-list-change' => 'Změnit',
	'todo-list-cancel' => 'Zrušit',
	'todo-new-item' => 'Nový úkol',
	'todo-issue-summary' => 'Shrnutí problému:',
	'todo-form-details' => 'Podrobnosti:',
	'todo-form-email' => 'Dostávat upozornění emailem, pokud bude úkol uzavřen. Napište svoji adresu sem:',
	'todo-form-submit' => 'Odeslat požadavek',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'todo-new-queue' => 'ny',
	'todo-list-cancel' => 'Afbryd',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Revolus
 */
$messages['de'] = array(
	'todo' => 'Aufgabenliste',
	'todo-desc' => 'Experimentelle persönliche [[Special:Todo|Aufgabenliste]]',
	'todo-tab' => 'Aufgaben',
	'todo-new-queue' => 'Neu',
	'todo-mail-subject' => 'Eintrag auf $1s Aufgabenliste abgeschlossen',
	'todo-mail-body' => 'Du hast um eine Benachrichtigung gebeten, wenn ein Auftrag, den du an $1 übergeben hast, abgeschlossen wurde.

Eintrag: $2
Übergeben: $3

Dieser Eintrag wurde mit diesem Kommentar als abgeschlossen markiert:
$4',
	'todo-invalid-item' => 'Fehlender oder falscher Eintrag',
	'todo-update-else-item' => 'Du versuchst, die Einträge von jemand anderem zu bearbeiten',
	'todo-unrecognize-type' => 'Unbekannter Typ',
	'todo-user-invalide' => 'Der erteilte Auftrag ist ungültig: Benutzer fehlt oder hat keine Aufgabenliste.',
	'todo-item-list' => 'Deine Einträge',
	'todo-no-item' => 'Keine Aufgaben.',
	'todo-invalid-owner' => 'Ungültiger Besitzer für diesen Eintrag',
	'todo-add-queue' => 'Warteschlange hinzufügen …',
	'todo-move-queue' => 'In Warteschlange verschieben …',
	'todo-list-for' => 'Aufgabenliste für',
	'todo-list-change' => 'Ändern',
	'todo-list-cancel' => 'Abbrechen',
	'todo-new-item' => 'Neuer Eintrag',
	'todo-issue-summary' => 'Zusammenfassung des Auftrags:',
	'todo-form-details' => 'Details:',
	'todo-form-email' => 'Gib deine E-Mail-Adresse ein, um eine Benachrichtigung zu erhalten, wenn der Eintrag geschlossen wurde:',
	'todo-form-submit' => 'Anfrage übergeben',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 */
$messages['de-formal'] = array(
	'todo-mail-body' => 'Sie haben um eine Benachrichtigung gebeten, wenn ein Auftrag, den Sie an $1 übergeben haben, abgeschlossen wurde.

Eintrag: $2
Übergeben: $3

Dieser Eintrag wurde mit diesem Kommentar als abgeschlossen markiert:
$4',
	'todo-update-else-item' => 'Sie versuchen, die Einträge von jemand anderem zu bearbeiten',
	'todo-item-list' => 'Ihre Einträge',
	'todo-form-email' => 'Geben Sie Ihre E-Mail-Adresse ein, um eine Benachrichtigung zu erhalten, wenn der Eintrag geschlossen wurde:',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'todo' => 'Lisćina nadawkow',
	'todo-desc' => 'Eksperimentelne rozšyrjenje za wósobinsku [[Special:Todo|lisćinu nadawkow]]',
	'todo-tab' => 'nadawki',
	'todo-new-queue' => 'nowy',
	'todo-mail-subject' => 'Dokóńcony zapisk na lisćinje nadawkow wužywarja $1',
	'todo-mail-body' => 'Sy pominał e-mailow wobkšuśenje wo dokóńcenju zapiska, kótaryž sy pósłał k lisćinje nadawkow online wužywarja $1.

Zapisk: $2
Wótpósłany: $3

Toś ten zapisk jo se markěrował ako dokóńcony, z toś tym komentarom:
$4',
	'todo-invalid-item' => 'Felujucy abo njepłaśiwy zapisk',
	'todo-update-else-item' => 'Wopyt zapiski někogo drugego aktualizěrowaś',
	'todo-unrecognize-type' => 'Njeznaty typ',
	'todo-user-invalide' => 'Nadawk njepłaśiwy, felujucy abo wužywaŕ njama lisćinu nadawkow',
	'todo-item-list' => 'Twóje zapiski',
	'todo-no-item' => 'Žedne zapiski za nadawki.',
	'todo-invalid-owner' => 'Njepłaśiwy wobsejźaŕ za toś ten zapisk',
	'todo-add-queue' => 'Rěd cakajucych pśidaś',
	'todo-move-queue' => 'Do rěda cakajucych pśesunuś',
	'todo-list-for' => 'Lisćina nadawkow za',
	'todo-list-change' => 'Změniś',
	'todo-list-cancel' => 'Pśetergnuś',
	'todo-new-item' => 'Nowy zapisk',
	'todo-issue-summary' => 'Zespominanje problema:',
	'todo-form-details' => 'Drobnostki:',
	'todo-form-email' => 'Zapiš swóju e-mailowu adresu, aby dostał powěsć, gaž zapisk se zacynja',
	'todo-form-submit' => 'Napšašanje wótpósłaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'todo-item-list' => 'Τα αντικείμενα σας',
	'todo-list-change' => 'Αλλαγή',
	'todo-list-cancel' => 'Έξοδος',
	'todo-new-item' => 'Νέο αντικείμενο',
	'todo-form-details' => 'Λεπτομέρειες:',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'todo' => 'Tasklisto',
	'todo-desc' => 'Eksperimenta persona etendilo [[Special:Todo|tasklisto]]',
	'todo-tab' => 'tasko',
	'todo-new-queue' => 'nova',
	'todo-mail-subject' => 'Kompletis taskon en taskolisto de $1',
	'todo-invalid-item' => 'Mankanta aŭ nevalida aĵo',
	'todo-update-else-item' => 'Provante ĝisdatigi taskojn de alia persono',
	'todo-unrecognize-type' => 'Nekonata tipo',
	'todo-item-list' => 'Viaj taskoj',
	'todo-no-item' => 'Neniuj taskoj.',
	'todo-invalid-owner' => 'Nevalida apartenanto de ĉi tiu aĵo',
	'todo-add-queue' => 'Aldoni atendovico…',
	'todo-list-for' => 'Tasklisto por',
	'todo-list-change' => 'Ŝanĝu',
	'todo-list-cancel' => 'Nuligi',
	'todo-new-item' => 'Nova aĵo',
	'todo-issue-summary' => 'Enmeti resumon:',
	'todo-form-details' => 'Detaloj:',
	'todo-form-submit' => 'Enigi serĉomendon',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'todo-new-queue' => 'nuevo',
	'todo-list-cancel' => 'Cancelar',
	'todo-form-details' => 'Detalles:',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'todo-new-queue' => 'berria',
	'todo-add-queue' => 'Ilarara gehitu...',
	'todo-move-queue' => 'Ilarara mugitu...',
	'todo-list-change' => 'Aldatu',
	'todo-list-cancel' => 'Utzi',
	'todo-issue-summary' => 'Gaiaren laburpena:',
	'todo-form-details' => 'Xehetasunak:',
);

/** French (Français)
 * @author McDutchie
 * @author Urhixidur
 */
$messages['fr'] = array(
	'todo' => 'Liste des tâches à exécuter',
	'todo-desc' => 'Extension expérimentale d’une [[Special:Todo|liste personnelle de tâches à accomplir]]',
	'todo-tab' => 'à faire',
	'todo-new-queue' => 'Nouveau',
	'todo-mail-subject' => 'Article achevé sur la liste des tâches de $1',
	'todo-mail-body' => "Vous avez demandé la confirmation par courriel en ce qui concerne l'achèvement d'un article que vous aviez sur la liste des tâches de $1.

Article : $2
Soumis : $3

Cet article a été marqué comme terminé avec le commentaire suivant :
$4",
	'todo-invalid-item' => 'Article manquant ou invalide',
	'todo-update-else-item' => "Tentative de mise à jour des articles de quelqu'un d'autre",
	'todo-unrecognize-type' => 'Type non reconnu',
	'todo-user-invalide' => 'Tâche à faire invalide, manquante, ou utilisateur ne disposant pas des droits nécessaires pour cela.',
	'todo-item-list' => 'Vos articles',
	'todo-no-item' => 'Aucune tâche à exécuter',
	'todo-invalid-owner' => 'Propriétaire de cet article invalide',
	'todo-add-queue' => 'Ajouter une queue…',
	'todo-move-queue' => 'Déplacer vers la queue…',
	'todo-list-for' => 'Liste des tâches à exécuter pour',
	'todo-list-change' => 'Modifier',
	'todo-list-cancel' => 'Annuler',
	'todo-new-item' => 'Nouvel article',
	'todo-issue-summary' => 'Résumé sommaire :',
	'todo-form-details' => 'Précisions :',
	'todo-form-email' => 'Pour recevoir les notifications par courriel une fois l’article clôturé, inscrivez votre adresse dans le cadre ci-dessous :',
	'todo-form-submit' => 'Soumettre la requête',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'todo' => 'Lista de tarefas pendentes',
	'todo-desc' => 'Extensión experimental da [[Special:Todo|lista persoal de tarefas pendentes]]',
	'todo-tab' => 'tarefas pendentes',
	'todo-new-queue' => 'novo',
	'todo-mail-subject' => 'Completado o elemento da lista de tarefas pendentes de $1',
	'todo-mail-body' => 'Solicitou unha confirmación por correo electrónico acerca do remate dun elemento que enviou á lista en liña de tarefas pendentes de $1.

Elemento: $2
Enviado: $3

Este elemento foi marcado como completado, con este comentario:
$4',
	'todo-invalid-item' => 'Artigo perdido ou non válido',
	'todo-update-else-item' => 'Intentando actualizar os elementos de alguén',
	'todo-unrecognize-type' => 'Tipo non recoñecido',
	'todo-user-invalide' => 'As tarefas pendentas dadas son inválidas, faltan, ou son dun usuario que non ten dereito para telas.',
	'todo-item-list' => 'Os seus artigos',
	'todo-no-item' => 'Non hai tarefas pendentes.',
	'todo-invalid-owner' => 'Propietario inválido deste elemento',
	'todo-add-queue' => 'Engadir cola…',
	'todo-move-queue' => 'Mover á cola…',
	'todo-list-for' => 'Lista de tarefas pendentes para',
	'todo-list-change' => 'Cambiar',
	'todo-list-cancel' => 'Cancelar',
	'todo-new-item' => 'Novo artigo',
	'todo-issue-summary' => 'Resumo do tema:',
	'todo-form-details' => 'Detalles:',
	'todo-form-email' => 'Para recibir unha notificación por correo electrónico cando o artigo esté pechado, teclee o seu enderezo aquí:',
	'todo-form-submit' => 'Enviar a consulta',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'todo-new-queue' => 'νέα',
	'todo-list-cancel' => 'Ἀκυροῦν',
	'todo-form-details' => 'Λεπτομέρειαι:',
);

/** Swiss German (Alemannisch)
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'todo-new-queue' => 'Nöu',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'todo' => 'רשימת מטלות',
	'todo-desc' => 'הרחבה נסיונית ל[[Special:Todo|רשימת מטלות]] אישית',
	'todo-tab' => 'מטלה',
	'todo-new-queue' => 'חדשה',
	'todo-mail-subject' => 'הושלם הפריט ברשימת המטלות של $1',
	'todo-mail-body' => 'ביקשתם התראה בדוא"ל אודות השלמת פריט אליו נרשמתם מרשימת המטלות המקוונת של $1.

פריט: $2
נשלח: $3

פריט זה סומן כהושלם, עם ההערה הבאה:
$4',
	'todo-invalid-item' => 'פריט חסר או בלתי תקין',
	'todo-update-else-item' => 'נסיון לעדכון פריטים של משתמש אחר',
	'todo-unrecognize-type' => 'סוג לא מוכר',
	'todo-user-invalide' => 'למטלה ניתן משתמש בלתי תקין, חסר או נטול רשימת מטלות.',
	'todo-item-list' => 'הפריטים שלכם',
	'todo-no-item' => 'אין פריטי מטלות לביצוע.',
	'todo-invalid-owner' => 'בעלים שגויים לפריט זה',
	'todo-add-queue' => 'הוספת תור...',
	'todo-move-queue' => 'העברה לתור...',
	'todo-list-for' => 'רשימת המטלות עבור',
	'todo-list-change' => 'שינוי',
	'todo-list-cancel' => 'ביטול',
	'todo-new-item' => 'פריט חדש',
	'todo-issue-summary' => 'תקציר הנושא:',
	'todo-form-details' => 'פרטים:',
	'todo-form-email' => 'על מנת לקבל התראה בדוא"ל אודות סגירת פריט, הזינו את כתובת הדוא"ל שלכם כאן:',
	'todo-form-submit' => 'שליחת השאילתה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'todo-list-cancel' => 'रद्द करें',
	'todo-form-details' => 'विस्तॄत ज़ानकारी:',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'todo-list-cancel' => 'Kanselahon',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'todo' => 'Lisćina nadawkow',
	'todo-desc' => 'Eksperimentelne rozšěrjenje za wosobinsku [[Special:Todo|lisćinu nadawkow]]',
	'todo-tab' => 'nadawk',
	'todo-new-queue' => 'nowy',
	'todo-mail-subject' => 'Sčinjeny nadawk na lisćinje nadawkow $1',
	'todo-mail-body' => 'Ty sy wo e-mejlowe potwjerdźenje wo sčinjenju nadawka požadał, kotryž sy do lisćiny nadawkow $1 w syći pósłał.

Nadawk: $2
Pósłany: $3

Tutón nadawk bu jako sčinjeny markěrowany, z tutym komentarom:
$4',
	'todo-invalid-item' => 'Falowacy abo njepłaćiwy nadawk',
	'todo-update-else-item' => 'Pospyt nadawki někoho druheho aktualizować',
	'todo-unrecognize-type' => 'Njespóznaty typ',
	'todo-user-invalide' => 'Daty nadawk je njepłaćiwy, faluje, abo wužiwar, kiž njemóže nadawk sčinić.',
	'todo-item-list' => 'Twoje nadawki',
	'todo-no-item' => 'Žane nadawki.',
	'todo-invalid-owner' => 'Njepłaćiwy swójstwownik na tutym nadawku',
	'todo-add-queue' => 'Čakanski rynk přidać...',
	'todo-move-queue' => 'Do čakanskeho rynka přesunyć...',
	'todo-list-for' => 'Lisćina nadawkow za',
	'todo-list-change' => 'Změnić',
	'todo-list-cancel' => 'Přetorhnyć',
	'todo-new-item' => 'Nowy nadawk',
	'todo-issue-summary' => 'Zjeće wudać:',
	'todo-form-details' => 'Podrobnosće',
	'todo-form-email' => 'Zo by zdźělenje z e-mejlu dóstał, hdyž so nadawk kónči, zapodaj tu swoju adresu:',
	'todo-form-submit' => 'Naprašowanje wotesłać',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'todo-new-queue' => 'új',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'todo' => 'Lista de cargas a facer',
	'todo-desc' => 'Extension experimental pro un lista personal de [[Special:Todo|cargas a facer]]',
	'todo-tab' => 'a facer',
	'todo-new-queue' => 'nove',
	'todo-mail-subject' => 'Action complite in le lista de cargas de $1',
	'todo-mail-body' => 'Tu requestava confirmation per e-mail super le completion de un carga que tu submitteva al lista in-linea de cargas a facer de $1.

Carga: $2
Submittite: $3

Iste action ha essite marcate como complite, con iste commento:
$4',
	'todo-invalid-item' => 'Carga mancante o invalide',
	'todo-update-else-item' => 'Tentativa de actualisar le cargas de alcuno altere',
	'todo-unrecognize-type' => 'Typo non recognoscite',
	'todo-user-invalide' => 'Todo recipeva un usator invalide, mancante, o sin derectos requisite.',
	'todo-item-list' => 'Tu cargas',
	'todo-no-item' => 'Nulle cargas a facer.',
	'todo-invalid-owner' => 'Le proprietario de iste carga es invalide',
	'todo-add-queue' => 'Adder cauda…',
	'todo-move-queue' => 'Displaciar verso cauda…',
	'todo-list-for' => 'Lista de cargas a facer pro',
	'todo-list-change' => 'Cambiar',
	'todo-list-cancel' => 'Cancellar',
	'todo-new-item' => 'Nove carga',
	'todo-issue-summary' => 'Summario:',
	'todo-form-details' => 'Detalios:',
	'todo-form-email' => 'Pro reciper notification per e-mail quando le carga es claudite, entra tu adresse hic:',
	'todo-form-submit' => 'Submitter requesta',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'todo-list-cancel' => 'Batalkan',
	'todo-form-details' => 'Rincian:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'todo-form-details' => 'Dettagli:',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'todo-new-queue' => '新規',
	'todo-list-change' => '変更',
	'todo-list-cancel' => 'キャンセル',
	'todo-form-details' => '詳細:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'todo' => 'Daftar tugas',
	'todo-desc' => "Èkstènsi [[Special:Todo|dhaptar ayahan]] (''todo list'') pribadi èkspèrimèntal",
	'todo-tab' => 'ayahan/tugas',
	'todo-new-queue' => 'anyar',
	'todo-mail-subject' => 'Perkara sing wis dilaksanakaké ing daftar tugas $1',
	'todo-unrecognize-type' => 'Jenisé ora ditepungi',
	'todo-add-queue' => 'Tambah antrian…',
	'todo-move-queue' => 'Pindhahna menyang antrian…',
	'todo-list-for' => 'Daftar tugas kanggo',
	'todo-list-change' => 'Ganti',
	'todo-list-cancel' => 'Batal',
	'todo-new-item' => 'Item anyar',
	'todo-issue-summary' => 'Ringkesan:',
	'todo-form-details' => 'Détail:',
	'todo-form-submit' => 'Kirimna kwéri',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'todo' => 'បញ្ជីកិច្ចការ​ត្រូវ​ធ្វើ',
	'todo-tab' => 'ត្រូវធ្វើ',
	'todo-new-queue' => 'ថ្មី',
	'todo-unrecognize-type' => 'ប្រភេទមិនស្គាល់',
	'todo-item-list' => 'ធាតុ​របស់​អ្នក',
	'todo-add-queue' => 'បន្ថែម ជួររង់ចាំ...',
	'todo-list-change' => 'ផ្លាស់ប្តូរ',
	'todo-list-cancel' => 'បោះបង់',
	'todo-new-item' => 'របស់ថ្មី',
	'todo-form-details' => 'លំអិត ៖',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'todo-list-cancel' => 'Kanselar',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'todo' => 'Opjaveliss',
	'todo-desc' => 'Ene Zosatz för en persönliche [[Special:Todo|Opjaveliss]] för zem Ußprobeere.',
	'todo-tab' => 'Opjav',
	'todo-new-queue' => 'neu',
	'todo-mail-subject' => 'Erledichte Opjav en däm $1 sing Opjaveliss',
	'todo-mail-body' => 'Do häs Der en E-Mail jewönsch, wann en Opjav erledich wöhr, die De em $1 en sing Opjaveliss jedonn häs. He is se:

De Opjav: $2
Enjedrage: $3

Se wood als erledich makeet mit dä Bemerkung:
$4

Ene schone Jroß.',
	'todo-invalid-item' => 'Die Opjav fäält, odder se es kapott',
	'todo-update-else-item' => 'Enem andere Metmaacher sing Opjave ändere',
	'todo-unrecognize-type' => 'Di Aat Opjaav kenne mer nit',
	'todo-user-invalide' => 'Die Opjav es kapott, nit doh, odder dä Medmaacher kann jaa kein Opjave han.',
	'todo-item-list' => 'Ding Opjave',
	'todo-no-item' => 'Kein Opjave en de Liss.',
	'todo-invalid-owner' => 'Dä Medmaacher för die Opjaav is nit müjjelisch',
	'todo-add-queue' => 'En Schlang dobei donn&nbsp;…',
	'todo-move-queue' => 'En de Schlang donn&nbsp;…',
	'todo-list-for' => 'Opjaveliss för',
	'todo-list-change' => 'Ändere',
	'todo-list-cancel' => 'Draanjevve',
	'todo-new-item' => 'En neu Opjav',
	'todo-issue-summary' => 'Zosammefassung:',
	'todo-form-details' => 'Einzelheite:',
	'todo-form-email' => 'Öm en E-Mail ze krijje, wann di Opjav avjeschlosse weed, jiv Ding E-Mai Adress hee en:',
	'todo-form-submit' => 'Loß Jonn!',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'todo' => 'Lëscht vun den Aufgaben',
	'todo-desc' => 'Experimentell Erweiderung mat der perséinlecher [[Special:Todo|Lëscht vun Aufgaben]]',
	'todo-tab' => 'fir ze maachen',
	'todo-new-queue' => 'nei',
	'todo-invalid-item' => 'Keen oder ongëltegen Objet',
	'todo-update-else-item' => "Versuch engem anere seng Objeten z'aktualiséieren",
	'todo-unrecognize-type' => 'Onbekannten Typ',
	'todo-item-list' => 'Är Objeten',
	'todo-no-item' => 'Keng Objeten op der Lëscht vun den Aufgaben.',
	'todo-list-for' => 'Lëscht vun den Aufgabe fir',
	'todo-list-change' => 'Änneren',
	'todo-list-cancel' => 'Annulléieren',
	'todo-new-item' => 'Neien Objet',
	'todo-issue-summary' => 'Resumé vun der Aufgab:',
	'todo-form-details' => 'Detailer:',
	'todo-form-submit' => 'Ufro starten',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'todo-list-cancel' => 'Чараш',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'todo-new-queue' => 'പുതിയത്',
	'todo-list-change' => 'മാറ്റം',
	'todo-list-cancel' => 'റദ്ദാക്കുക',
	'todo-new-item' => 'പുതിയ ഇനം',
	'todo-form-details' => 'വിശദാംശങ്ങള്‍:',
	'todo-form-submit' => 'ചോദ്യം (query) സമര്‍പ്പിക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'todo' => 'करण्याची यादी',
	'todo-tab' => 'करावयाच्या गोष्टी',
	'todo-new-queue' => 'नवे',
	'todo-mail-subject' => '$1 च्या करावयच्या गोष्टींच्या यादीतील पूर्ण झालेल्या नोंदी',
	'todo-invalid-item' => 'चुकीचा किंवा अस्तित्वात नसलेला आयटम',
	'todo-unrecognize-type' => 'अनोळखी प्रकार',
	'todo-item-list' => 'तुमचे आयटेम्स',
	'todo-no-item' => 'करावयाच्या नोंदी नाहीत.',
	'todo-invalid-owner' => 'या आयटमचा चुकीचा मालक',
	'todo-add-queue' => 'रांग वाढवा...',
	'todo-move-queue' => 'रांगेमध्ये हलवा...',
	'todo-list-for' => '(ची) करावयाच्या गोष्टींची यादी',
	'todo-list-change' => 'बदल',
	'todo-list-cancel' => 'रद्द करा',
	'todo-new-item' => 'नवीन नोंद',
	'todo-issue-summary' => 'चर्चा सारांश:',
	'todo-form-details' => 'तपशील:',
	'todo-form-submit' => 'पृच्छा पाठवा',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'todo-list-cancel' => 'Annulla',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'todo' => 'Мезе теемс ледстемка',
	'todo-tab' => 'мезе теемс',
	'todo-new-queue' => 'од',
	'todo-unrecognize-type' => 'Апак содань тип',
	'todo-item-list' => 'Эсеть тевпельксэть',
	'todo-no-item' => 'Тевпелькст арасть',
	'todo-add-queue' => 'Теемс чиполас аравтома',
	'todo-move-queue' => 'Ютавтомс пулос…',
	'todo-list-change' => 'Полавтомс',
	'todo-list-cancel' => 'А теемс',
	'todo-new-item' => 'Од тевпелькс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'todo' => 'mochi ic tlachīhua',
	'todo-tab' => 'mochi',
	'todo-list-change' => 'Ticpatlāz',
	'todo-list-cancel' => 'Ticcuepāz',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'todo' => 'Opgavenlist',
	'todo-tab' => 'Opgaven',
	'todo-new-queue' => 'nee',
	'todo-no-item' => 'Nix op de Opgavenlist.',
	'todo-list-for' => 'Opgavenlist för',
	'todo-list-change' => 'Ännern',
	'todo-list-cancel' => 'Afbreken',
	'todo-new-item' => 'Ne’e Opgaav',
	'todo-form-details' => 'Details:',
);

/** Dutch (Nederlands)
 * @author GerardM
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'todo' => 'Takenlijst',
	'todo-desc' => 'Experimentele uitbreiding voor een persoonlijke [[Special:Todo|takenlijst]]',
	'todo-tab' => 'taken',
	'todo-new-queue' => 'nieuw',
	'todo-mail-subject' => 'Afgerond actiepunt op actielijst $1',
	'todo-mail-body' => 'U hebt gevraagd om een waarschuwing bij het sluiten van een actiepunt op de actielijst van $1.

Onderwerp: $2
Geopend: $3

Dit onderwerp is nu gemarkeerd als afgerond, met de volgende opmerking:
$4',
	'todo-invalid-item' => 'Missend of ongeldig item',
	'todo-update-else-item' => 'Bezig met het bijwerken van de punten van iemand anders',
	'todo-unrecognize-type' => 'Onherkend type',
	'todo-user-invalide' => 'Aan dit actiepunt hangt een gebruiker die een onjuiste naam heeft, niet bestaat, of geen gebruik kan maken van actiepunten.',
	'todo-item-list' => 'Uw items',
	'todo-no-item' => 'Geen te-doen-items.',
	'todo-invalid-owner' => 'Ongeldige eigenaar voor dit item',
	'todo-add-queue' => 'Wachtrij toevoegen…',
	'todo-move-queue' => 'Verplaats naar wachtrij…',
	'todo-list-for' => 'Takenlijst voor',
	'todo-list-change' => 'Wijzigen',
	'todo-list-cancel' => 'Annuleren',
	'todo-new-item' => 'Nieuw item',
	'todo-issue-summary' => 'Samenvatting onderwerp:',
	'todo-form-details' => 'Details:',
	'todo-form-email' => 'Voer hier uw e-mailadres in om een melding te krijgen als dit onderwerp wordt gesloten:',
	'todo-form-submit' => 'Zoekopdracht uitvoeren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'todo' => 'Oppgåveliste',
	'todo-desc' => 'Eksperimentell personleg utviding for [[Special:Todo|oppgåvelister]].',
	'todo-tab' => 'oppgåver',
	'todo-new-queue' => 'ny',
	'todo-mail-subject' => 'Fullført oppgåve på oppgåvelista til $1',
	'todo-mail-body' => 'Du bad om ei e-poststadfesting om fullføringa av ei oppgåve på oppgåvelista til $1.

Oppgåve: $2
Fullført: $3

Oppgåva er merka som fullført, med denne kommentaren:
$4',
	'todo-invalid-item' => 'Manglande eller ugyldig oppgåve',
	'todo-update-else-item' => 'Prøver å oppdatere ein annan person sine oppgåver',
	'todo-unrecognize-type' => 'Ukjend type',
	'todo-user-invalide' => 'Oppgåva er gjeve til ugyldig, mangalande eller upassande brukar.',
	'todo-item-list' => 'Dine oppgåver',
	'todo-no-item' => 'Ingen oppgåver.',
	'todo-invalid-owner' => 'Ugyldig oppgåveeigar.',
	'todo-add-queue' => 'Legg til kø…',
	'todo-move-queue' => 'Flytt til kø…',
	'todo-list-for' => 'Oppgåveliste for',
	'todo-list-change' => 'Endre',
	'todo-list-cancel' => 'Avbryt',
	'todo-new-item' => 'Ny oppgåve',
	'todo-issue-summary' => 'Samandrag:',
	'todo-form-details' => 'Detaljar:',
	'todo-form-email' => 'Skriv inn e-postadressa din her for å motta melding på e-post når oppgava er fullført:',
	'todo-form-submit' => 'Utfør',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'todo' => 'Oppgaveliste',
	'todo-desc' => 'Eksperimentell personlig utvidelse for [[Special:Todo|oppgavelister]].',
	'todo-tab' => 'oppgaver',
	'todo-new-queue' => 'ny',
	'todo-mail-subject' => 'Fullførte oppgave på $1s oppgaveliste',
	'todo-mail-body' => 'Du ba om en e-postbekreftelse om fullføringen av en oppgave på $1s oppgaveliste.

Oppgave: $2
Fullført: $3

Oppgaven er merket som fullført, med denne kommentaren:
$4',
	'todo-invalid-item' => 'Manglende eller ugyldig oppgave',
	'todo-update-else-item' => 'Prøver å oppdatere en annen persons oppgaver',
	'todo-unrecognize-type' => 'Type ikke gjenkjent',
	'todo-user-invalide' => 'Oppgaven gitt til ugydlig, manglende eller upassende bruker.',
	'todo-item-list' => 'Dine oppgaver',
	'todo-no-item' => 'Ingen oppgaver.',
	'todo-invalid-owner' => 'Ugyldig oppgaveeier.',
	'todo-add-queue' => 'Legg til kø…',
	'todo-move-queue' => 'Flytt til kø…',
	'todo-list-for' => 'Oppgaveliste for',
	'todo-list-change' => 'Endre',
	'todo-list-cancel' => 'Avbryt',
	'todo-new-item' => 'Ny oppgave',
	'todo-issue-summary' => 'Sammendrag:',
	'todo-form-details' => 'Detaljer:',
	'todo-form-email' => 'Skriv inn e-postadressen din her for å mottå beskjed på e-post når oppgaven er fullført:',
	'todo-form-submit' => 'Utfør',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'todo' => "Lista dels prètzfaches d'executar",
	'todo-desc' => 'Extension experimentala d’una [[Special:Todo|lista personala de prètzfaches de realizar]]',
	'todo-tab' => 'de far',
	'todo-new-queue' => 'Novèl',
	'todo-mail-subject' => 'Article acabat sus la lista dels prètzfaches de $1',
	'todo-mail-body' => "Avètz demandat la confirmacion per corrièr electronic per çò que concernís l'acabament d'un article qu'aviatz sus la lista dels preètzfaches de $1. Article : $2 Somes : $3 Aqueste article es estat marcat coma acabat amb lo comentari seguent : $4",
	'todo-invalid-item' => 'Article mancant o invalid',
	'todo-update-else-item' => "Temptativa de metre a jorn los articles de qualqu'un d'autre",
	'todo-unrecognize-type' => 'Tipe pas reconegut',
	'todo-user-invalide' => 'Prètzfach de far invalid, mancant, o utilizaire disposant pas dels dreches necessaris per aquò.',
	'todo-item-list' => 'Vòstres articles',
	'todo-no-item' => "Cap de prètzfach d'executar pas",
	'todo-invalid-owner' => "Proprietari d'aqueste article invalid",
	'todo-add-queue' => 'Apondre a la coa…',
	'todo-move-queue' => 'Desplaçar cap a la coa…',
	'todo-list-for' => "Lista dels prètzfaches d'executar per",
	'todo-list-change' => 'Modificar',
	'todo-list-cancel' => 'Anullar',
	'todo-new-item' => 'Article novèl',
	'todo-issue-summary' => 'Resumit brèu :',
	'todo-form-details' => 'Precisions :',
	'todo-form-email' => 'Per recebre las notificacions per corrièr electronic un còp l’article clausurat, inscrivètz vòstra adreça dins lo quadre çaijós :',
	'todo-form-submit' => 'Sometre la requèsta',
);

/** Polish (Polski)
 * @author McMonster
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'todo' => 'Lista zadań do wykonania',
	'todo-desc' => 'Eksperymentalne rozszerzenie udostępniające osobistą [[Special:Todo|listę zadań do wykonania]]',
	'todo-tab' => 'zadania',
	'todo-new-queue' => 'nowe',
	'todo-mail-subject' => 'Zamknięto pozycję na liście zadań użytkownika $1',
	'todo-mail-body' => 'Zaznaczyłeś opcję poinformowania Cię o zakończeniu czynności, którą dodałeś do listy zadań użytkownika $1 w trybie online.

Pozycja: $2
Przesłano: $3

Pozycję oznaczono jako wykonaną z następującym komentarzem:
$4',
	'todo-invalid-item' => 'Nieprawidłowa lub nieistniejąca pozycja',
	'todo-update-else-item' => 'Próba uaktualnienia listy pozycji innego użytkownika',
	'todo-unrecognize-type' => 'Nie rozpoznano typu',
	'todo-user-invalide' => 'Podano nieprawidłową lub nieistniejącą nazwę użytkownika, albo użytkownik nie jest w stanie wykorzystywać funkcji zadań do wykonania.',
	'todo-item-list' => 'Twoje zadania',
	'todo-no-item' => 'Brak wpisów na liście zadań do wykonania.',
	'todo-invalid-owner' => 'Właściciel tego zadania jest nieprawidłowy',
	'todo-add-queue' => 'Dodaj kolejkę…',
	'todo-move-queue' => 'Przesuń do kolejki…',
	'todo-list-for' => 'Lista zadań dla',
	'todo-list-change' => 'Zmień',
	'todo-list-cancel' => 'Anuluj',
	'todo-new-item' => 'Nowa pozycja',
	'todo-issue-summary' => 'Podsumowanie kwestii:',
	'todo-form-details' => 'Szczegóły:',
	'todo-form-email' => 'Jeśli chcesz otrzymać powiadomienie pocztą elektroniczna po zamknięciu tej pozycji, wpisz w polu poniżej swój adres e-mail:',
	'todo-form-submit' => 'Wyślij zapytanie',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'todo-new-queue' => 'نوی',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'todo' => 'Lista de tarefas',
	'todo-tab' => 'tarefas',
	'todo-new-queue' => 'novo',
	'todo-mail-subject' => 'Itens completos na lista de tarefas de $1',
	'todo-invalid-item' => 'Item em falta ou inválido',
	'todo-unrecognize-type' => 'Tipo não reconhecido',
	'todo-item-list' => 'Seus itens',
	'todo-no-item' => 'Sem tarefas.',
	'todo-list-for' => 'Lista de tarefas de',
	'todo-list-change' => 'Alterar',
	'todo-list-cancel' => 'Cancelar',
	'todo-new-item' => 'Novo item',
	'todo-form-details' => 'Detalhes:',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'todo-new-queue' => 'amaynu',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'todo-unrecognize-type' => 'Tip nerecunoscut',
	'todo-list-cancel' => 'Anulează',
	'todo-form-details' => 'Detalii:',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'todo' => 'Liste de le cose da fà',
	'todo-tab' => 'da fà',
	'todo-new-queue' => 'nueve',
	'todo-add-queue' => 'Mitte in coda...',
	'todo-list-for' => 'Liste de le cose da fà pe',
	'todo-list-change' => 'Cange',
	'todo-list-cancel' => 'Scangille',
);

/** Russian (Русский)
 * @author Ferrer
 */
$messages['ru'] = array(
	'todo-add-queue' => 'Добавить очередь…',
	'todo-move-queue' => 'Переместить в очередь…',
	'todo-list-change' => 'Выбрать',
	'todo-list-cancel' => 'Отмена',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'todo' => 'Zoznam úloh',
	'todo-desc' => 'Experimentálne rozšírenie osobný [[Special:Todo|Zoznam úloh]]',
	'todo-tab' => 'zoznam úloh',
	'todo-new-queue' => 'nová',
	'todo-mail-subject' => 'Dokončená úloha zo zoznamu používateľa $1',
	'todo-mail-body' => 'Žiadali ste o potvrdzovací email po dokončení úlohy, ktorú ste poslali do zoznamu úloh používateľa $1.

Úloha: $2
Poslaná: $3

Táto úloha bola označená ako dokončená s týmto komentárom:
$4',
	'todo-invalid-item' => 'Chýbajúca alebo neplatná úloha',
	'todo-update-else-item' => 'Pokúšate sa aktualizovať úlohy niekoho iného',
	'todo-unrecognize-type' => 'Nerozpoznaný typ',
	'todo-user-invalide' => 'Zadaná úloha je neplatná, chýba alebo používateľ nepoužíva zoznam úloh',
	'todo-item-list' => 'Vaše úlohy',
	'todo-no-item' => 'Žiadne úlohy.',
	'todo-invalid-owner' => 'Vlastník tejto položky je neplatný',
	'todo-add-queue' => 'Pridať front…',
	'todo-move-queue' => 'Presunúť do frontu…',
	'todo-list-for' => 'Zoznam úloh používateľa',
	'todo-list-change' => 'Zmeniť',
	'todo-list-cancel' => 'Zrušiť',
	'todo-new-item' => 'Nová úloha',
	'todo-issue-summary' => 'Zhrnutie problému:',
	'todo-form-details' => 'Podrobnosti:',
	'todo-form-email' => 'Dostať upozornenie emailom, keď bude úloha uzatvorená. Napíšte svoju adresu:',
	'todo-form-submit' => 'Poslať požiadavku',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'todo' => 'Uppgiftslista',
	'todo-desc' => 'Exprimentell personligt tillägg för [[Special:Todo|uppgiftslistor]].',
	'todo-tab' => 'uppgifter',
	'todo-new-queue' => 'ny',
	'todo-mail-subject' => 'Slutförde uppgift på $1s uppgiftslista',
	'todo-mail-body' => 'Du efterfrågade en e-postbekräftning om slutförningen av en uppgift på $1s uppgiftslista.

Uppgift: $2
Slutförd: $3

Uppgiften har markerats som slutförd, med den här kommentaren:
$4',
	'todo-invalid-item' => 'Missad eller ogiltig uppgift',
	'todo-update-else-item' => 'Prövar att uppdatera en annan persons uppgifter',
	'todo-unrecognize-type' => 'Okänd typ',
	'todo-user-invalide' => 'Uppgiften angiven som ogiltig, missad eller opassande användare.',
	'todo-item-list' => 'Dina uppgifter',
	'todo-no-item' => 'Inga uppgifter.',
	'todo-invalid-owner' => 'Ogiltig ägare av uppgiften',
	'todo-add-queue' => 'Lägg till kö…',
	'todo-move-queue' => 'Flytta till kö…',
	'todo-list-for' => 'Uppgiftslista för',
	'todo-list-change' => 'Ändra',
	'todo-list-cancel' => 'Avbryt',
	'todo-new-item' => 'Ny uppgift',
	'todo-issue-summary' => 'Sammandrag:',
	'todo-form-details' => 'Detaljer:',
	'todo-form-email' => 'Skriv in din e-postadress här för att motta meddelanden på e-post när uppgiften är slutförd:',
	'todo-form-submit' => 'Utför',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'todo' => 'చేయాల్సిన జాబితా',
	'todo-new-queue' => 'కొత్తది',
	'todo-unrecognize-type' => 'గుర్తుతెలియని రకం',
	'todo-item-list' => 'మీ అంశాలు',
	'todo-no-item' => 'చేయాల్సిన అంశాలేమీ లేవు.',
	'todo-list-change' => 'మార్చు',
	'todo-list-cancel' => 'రద్దుచేయి',
	'todo-new-item' => 'కొత్త అంశం',
	'todo-form-details' => 'వివరాలు:',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'todo-new-queue' => 'foun',
	'todo-list-cancel' => 'Para',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'todo-new-queue' => 'нав',
	'todo-unrecognize-type' => 'Навъи ношинос',
	'todo-list-change' => 'Тағйир',
	'todo-list-cancel' => 'Лағв',
	'todo-new-item' => 'Маводи ҷадид',
	'todo-issue-summary' => 'Хулосаи амал:',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'todo-list-change' => 'เปลี่ยน',
	'todo-list-cancel' => 'ยกเลิก',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'todo' => 'Talaan ng mga gagawin',
	'todo-desc' => 'Sinusubok pang karugtong na pansariling [[Special:Todo|talaan ng mga gagawin]]',
	'todo-tab' => 'mga gagawin',
	'todo-new-queue' => 'bago',
	'todo-mail-subject' => 'Bagay na nagawang nasa talaa ng mga gagawin ni $1',
	'todo-mail-body' => 'Ang hiniling mong pagpapatotoo hinggil sa pagkakabuo (pagkatapos) na ng isang bagay na ipinasa/ipinadala mo sa pang-habang nakakunekta sa internet na talaan ng mga gagawin ni $1 sa pamamagitan ng e-liham.

Bagay (paksa): $2
Ipinasa/ipinadala noong: $3

Tinatakan ang bagay na ito bilang natapos na, na may ganitong kumento/puna:
$4',
	'todo-invalid-item' => 'Nawawala o hindi tanggap na bagay',
	'todo-update-else-item' => 'Sinusubok na isapanahon ang mga bagay-bagay ng ibang tao',
	'todo-unrecognize-type' => 'Hindi nakikilalang uri',
	'todo-user-invalide' => 'Hindi tanggap ang gagawin, nawawala, o tagagamit na hindi para sa mga maaaring magawa',
	'todo-item-list' => 'Mga bagay-bagay mo',
	'todo-no-item' => 'Walang mga bagay na gagawin.',
	'todo-invalid-owner' => 'Hindi tanggap na may-ari para sa bagay na ito',
	'todo-add-queue' => 'Idagdag ang pila (naghihintay na hanay)…',
	'todo-move-queue' => 'Ilipat sa pila (hanay na naghihintay)…',
	'todo-list-for' => 'Talaan ng mga gagawin para kay',
	'todo-list-change' => 'Baguhin',
	'todo-list-cancel' => 'Huwag ipagpatuloy',
	'todo-new-item' => 'Bagong bagay',
	'todo-issue-summary' => 'Ibigay ang buod:',
	'todo-form-details' => 'Mga detalye:',
	'todo-form-email' => 'Upang makatanggap ng pagbibigay-alam sa pamamagitan ng e-liham kung naisara na ang bagay, makinilyahin dito ang adres mo:',
	'todo-form-submit' => 'Ipasa/ipadala ang katanungan',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'todo-new-queue' => 'yeni',
	'todo-list-cancel' => 'İptal',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'todo' => 'Danh sách việc cần làm',
	'todo-desc' => 'Phần mở rộng thí nghiệm cung cấp [[Special:Todo|danh sách việc cần làm]] cá nhân',
	'todo-tab' => 'cần làm',
	'todo-new-queue' => 'mới',
	'todo-no-item' => 'Không có việc cần làm.',
	'todo-list-for' => 'Danh sách việc cần làm của',
	'todo-list-change' => 'Thay đổi',
	'todo-list-cancel' => 'Bãi bỏ',
	'todo-form-details' => 'Chi tiết:',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'todo-new-queue' => 'nulik',
	'todo-list-change' => 'Votükön',
	'todo-form-details' => 'Notets:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'todo-list-cancel' => '取消',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'todo-list-cancel' => '取消',
);

