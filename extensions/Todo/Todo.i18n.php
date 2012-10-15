<?php
/**
 * Internationalisation file for extension Todo.
 *
 * @file
 * @ingroup Extensions
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
	'todo-list-for'         => 'Todo list for $1',
	'todo-list-change'      => 'Change',
	'todo-list-cancel'      => 'Cancel',
	'todo-new-item'         => 'New item',
	'todo-not-updated'      => 'Could not update database record',
	'todo-issue-summary'    => 'Issue summary:',
	'todo-form-details'     => 'Details:',
	'todo-form-email'       => 'To receive notification by e-mail when the item is closed, provide your address:',
	'todo-form-submit'      => 'Submit query',
	'right-todo'            => 'Have todo list',
	'right-todosubmit'      => 'Restrict user\'s todo list right',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 * @author Siebrand
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'todo-desc' => '{{desc}}',
	'todo-new-queue' => '{{Identical|New}}',
	'todo-mail-body' => '* $1 is a user name
* $2 is a page name
* $3 is a timestamp
* $4 is a reason (free text)',
	'todo-list-for' => '{{Identical|Todo list for}}',
	'todo-list-change' => '{{Identical|Change}}',
	'todo-list-cancel' => '{{Identical|Cancel}}',
	'todo-form-details' => '{{Identical|Details}}',
	'todo-form-submit' => '{{Identical|Submit query}}',
	'right-todo' => '{{doc-right|todo}}',
	'right-todosubmit' => '{{doc-right|todosubmit}}',
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

/** толышә зывон (толышә зывон)
 * @author Гусейн
 */
$messages['tly'] = array(
	'todo-list-change' => 'Дәгиш кардеј',
	'todo-list-cancel' => 'Ләғв кардеј',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'todo-new-queue' => 'nuut',
	'todo-list-change' => 'Wysig',
	'todo-list-cancel' => 'Kanselleer',
	'todo-form-details' => 'Details:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'todo-new-queue' => 'አዲስ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'todo-list-cancel' => 'Cancelar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 * @author روخو
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
	'todo-list-for' => 'قائمة للعمل ل $1',
	'todo-list-change' => 'غيّر',
	'todo-list-cancel' => 'ألغِ',
	'todo-new-item' => 'مدخلة جديدة',
	'todo-not-updated' => 'لا يمكن تحديث سجل قاعدة بيانات',
	'todo-issue-summary' => 'ملخص القضية:',
	'todo-form-details' => 'التفاصيل:',
	'todo-form-email' => 'لاستقبال إخطار بواسطة البريد الإلكتروني عندما يتم إغلاق المدخلة، اكتب عنوانك هنا:',
	'todo-form-submit' => 'تنفيذ الاستعلام',
	'right-todo' => 'امتلاك قائمة للعمل',
	'right-todosubmit' => 'تحديد صلاحية قائمة للعمل للمستخدم',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'todo-new-queue' => 'ܚܕܬܐ',
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
	'todo-list-for' => 'قائمة للعمل ل $1',
	'todo-list-change' => 'تغيير',
	'todo-list-cancel' => 'إلغاء',
	'todo-new-item' => 'مدخلة جديدة',
	'todo-issue-summary' => 'ملخص القضية:',
	'todo-form-details' => 'التفاصيل:',
	'todo-form-email' => 'لاستقبال إخطار بواسطة البريد الإلكترونى عندما يتم إغلاق المدخلة، اكتب عنوانك هنا:',
	'todo-form-submit' => 'تنفيذ الاستعلام',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'todo-new-queue' => 'yeni',
	'todo-list-cancel' => 'Ləğv et',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'todo' => 'Сьпіс заданьняў',
	'todo-desc' => 'Экспэрымэнтальнае пашырэньне [[Special:Todo|пэрсанальнага сьпісу заданьняў]]',
	'todo-tab' => 'заданьні',
	'todo-new-queue' => 'новае(ыя)',
	'todo-mail-subject' => 'Выкананае заданьне са сьпісу заданьняў удзельніка $1',
	'todo-mail-body' => 'Вы запатрабавалі пацьверджаньне пра выкананьне заданьня са сьпісу заданьняў удзельніка $1.

Заданьне: $2
Выкананае: $3

Заданьне пазначанае як выкананае з наступным камэнтарам:
$4',
	'todo-invalid-item' => 'Неіснуючае ці няслушнае заданьне',
	'todo-update-else-item' => 'Спроба зьмены сьпісу заданьняў іншага ўдзельніка',
	'todo-unrecognize-type' => 'Невядомы тып',
	'todo-user-invalide' => 'Пададзенае няслушнае, неіснуючае альбо немагчымае да выкананьня заданьне.',
	'todo-item-list' => 'Вашыя заданьні',
	'todo-no-item' => 'Няма заданьняў.',
	'todo-invalid-owner' => 'Няслушны ўладальнік гэтага заданьня',
	'todo-add-queue' => 'Дадаць чаргу…',
	'todo-move-queue' => 'Перанесьці ў чаргу…',
	'todo-list-for' => 'Сьпіс заданьняў для $1',
	'todo-list-change' => 'Зьмяніць',
	'todo-list-cancel' => 'Скасаваць',
	'todo-new-item' => 'Новае заданьне',
	'todo-not-updated' => 'Немагчыма абнавіць запіс базы зьвестак',
	'todo-issue-summary' => 'Агульная колькасьць:',
	'todo-form-details' => 'Падрабязнасьці:',
	'todo-form-email' => 'Каб атрымліваць паведамленьні пра выкананьні заданьняў па электроннай пошце, упішыце сюды свой адрас электроннай пошты:',
	'todo-form-submit' => 'Запытаць',
	'right-todo' => 'сьпіс заданьняў',
	'right-todosubmit' => 'абмежаваньне правоў іншых удзельнікаў для сьпісаў заданьняў',
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
	'todo-list-for' => 'Списък със задачи за $1',
	'todo-list-change' => 'Промяна',
	'todo-list-cancel' => 'Отмяна',
	'todo-issue-summary' => 'Резюме:',
	'todo-form-details' => 'Детайли:',
	'todo-form-email' => 'За получаване на оповестително писмо при приключване на задачата е необходимо да въведете своя адрес за е-поща:',
	'todo-form-submit' => 'Изпращане на заявка',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'todo' => 'করণীয় তালিকা',
	'todo-tab' => 'করণীয়',
	'todo-new-queue' => 'নতুন',
	'todo-list-change' => 'পরিবর্তন',
	'todo-list-cancel' => 'বাতিল',
	'todo-form-details' => 'বিস্তারিত:',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'todo' => 'Roll traoù da ober',
	'todo-desc' => 'Astenn arnodel evit ur [[Special:Todo|roll hiniennel eus an trevelloù da gas da benn]]',
	'todo-tab' => "d'ober",
	'todo-new-queue' => 'nevez',
	'todo-mail-subject' => "Kraf kaset da benn e-touez roll traoù d'ober $1",
	'todo-mail-body' => "Goulennet hoc'h eus resev ur c'hmenn dre bostel pa vo bet kaset da benn un elfenn lakaet ganeoc'h war roll trevelloù da gas da benn $1.

Elfenn : $2
Kaset : $3

Merket eo bet an elfenn-mañ evel echuet, gant an evezhiadenn-mañ :
$4",
	'todo-invalid-item' => 'Elfenn diank pe direizh',
	'todo-update-else-item' => 'O klask hizivaat elfennoù unan all',
	'todo-unrecognize-type' => "Seurt n'eo ket bet anavezet",
	'todo-user-invalide' => "Direizh pe ezvezant eo an dra spisaet pe neuze n'eus ket gant an implijer a roll trevelloù da gas da benn.",
	'todo-item-list' => "Hoc'h elfennoù",
	'todo-no-item' => "N'eus netra da ober.",
	'todo-invalid-owner' => "Direizh eo perc'henn an elfenn-mañ",
	'todo-add-queue' => "Ouzhpennañ d'ar roll gortoz...",
	'todo-move-queue' => "Kas d'ar roll gortoz...",
	'todo-list-for' => "Roll traoù d'ober gant $1",
	'todo-list-change' => 'Kemmañ',
	'todo-list-cancel' => 'Nullañ',
	'todo-new-item' => 'Elfenn nevez',
	'todo-not-updated' => "N'eus ket bet gallet hizivaat an enrolladenn en diaz roadennoù",
	'todo-issue-summary' => 'Diverrañ eus ar gudenn :',
	'todo-form-details' => 'Munudoù :',
	'todo-form-email' => "Evit resev ur c'hemenn dre bostel pa vez serr an elfenn, lakait ho postel er framm dindan :",
	'todo-form-submit' => 'Kas ar reked',
	'right-todo' => 'Kaout ur roll "traoù d\'ober".',
	'right-todosubmit' => "Strishaat gwirioù rolloù traoù d'ober an implijerien",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'todo' => 'Spisak za uraditi',
	'todo-desc' => 'Probno proširenje ličnog [[Special:Todo|spiska za uraditi]]',
	'todo-tab' => 'zadaci',
	'todo-new-queue' => 'novi',
	'todo-mail-subject' => 'Završena stavka na spisku za uraditi korisnika $1',
	'todo-mail-body' => 'Tražili ste e-mail potvrdu o završetku svake stavke koju ste poslali online na spisku zadataka za korisnika $1.

Stavka: $2
Poslano: $3

Ova stavka je označena završenom, sa slijedećim komentarom:
$4',
	'todo-invalid-item' => 'Nedostajuća ili nevaljana stavka',
	'todo-update-else-item' => 'Pokušavate ažurirati stavke nekog drugog',
	'todo-unrecognize-type' => 'Neprepoznati tip',
	'todo-user-invalide' => 'Zadatku pripojen nevaljan, nepostojeći ili korisnik kojem se ne može dodijeliti zadatak.',
	'todo-item-list' => 'Vaše stavke',
	'todo-no-item' => 'Nema stavki za uraditi.',
	'todo-invalid-owner' => 'Nevaljan vlasnik ove stavke',
	'todo-add-queue' => 'Dodaj red…',
	'todo-move-queue' => 'Premjesti u red…',
	'todo-list-for' => 'Spisak za uraditi za $1',
	'todo-list-change' => 'Izmjena',
	'todo-list-cancel' => 'Odustani',
	'todo-new-item' => 'Nova stavka',
	'todo-not-updated' => 'Ne mogu ažurirati bazu podataka',
	'todo-issue-summary' => 'Sažetak zadatka:',
	'todo-form-details' => 'Detalji:',
	'todo-form-email' => 'Da bi ste dobili obavještenje putem e-maila kada je stavka zatvorena, unesite Vašu adresu ovdje:',
	'todo-form-submit' => 'Pošalji upit',
	'right-todo' => 'Imati spisak zadataka za uraditi',
	'right-todosubmit' => 'Onemogućiti pravo korisnika na spisak zadataka',
);

/** Catalan (Català)
 * @author Aleator
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'todo' => 'Llista de feines per fer',
	'todo-desc' => 'Extensió de [[Special:Todo|llista de tasques]] personal i experimental',
	'todo-tab' => 'per fer',
	'todo-new-queue' => 'nou',
	'todo-item-list' => 'Els teus ítems',
	'todo-no-item' => 'No hi ha ítems a la llista de tasques.',
	'todo-add-queue' => 'Afegeix a la coa...',
	'todo-move-queue' => 'Mou a la coa...',
	'todo-list-change' => 'Canvia',
	'todo-list-cancel' => 'Cancel·la',
	'todo-new-item' => 'Nou ítem',
	'todo-form-submit' => 'Tramet una consulta',
	'right-todo' => 'Tenir una llista de coses a fer',
	'right-todosubmit' => 'Restringir els drets de la llista pròpia de coses a fer',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'todo-tab' => 'дадезарш',
	'todo-new-queue' => 'керла',
	'todo-list-cancel' => 'Цаоьшу',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'todo-new-queue' => 'نوێ',
	'todo-list-change' => 'گۆڕان',
	'todo-list-cancel' => 'هەڵوەشاندنەوە',
	'todo-form-details' => 'وردەکاریەکان:',
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
	'todo-list-for' => 'Seznam úkolů uživatele $1',
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
 * @author Kghbln
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'todo' => 'Aufgabenliste',
	'todo-desc' => 'Ermöglicht eine persönliche [[Special:Todo|Aufgabenliste]] (experimentell)',
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
	'todo-list-for' => 'Aufgabenliste für $1',
	'todo-list-change' => 'Ändern',
	'todo-list-cancel' => 'Abbrechen',
	'todo-new-item' => 'Neuer Eintrag',
	'todo-not-updated' => 'Der Datensatz konnte nicht in der Datenbank aktualisiert werden',
	'todo-issue-summary' => 'Zusammenfassung des Auftrags:',
	'todo-form-details' => 'Einzelheiten:',
	'todo-form-email' => 'Gib deine E-Mail-Adresse ein, um eine Benachrichtigung zu erhalten, wenn der Eintrag geschlossen wurde:',
	'todo-form-submit' => 'Anfrage übergeben',
	'right-todo' => 'Aufgabenliste haben',
	'right-todosubmit' => 'Benutzerrechte auf Aufgabenliste beschränken',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
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
	'todo-list-for' => 'Lisćina nadawkow za $1',
	'todo-list-change' => 'Změniś',
	'todo-list-cancel' => 'Pśetergnuś',
	'todo-new-item' => 'Nowy zapisk',
	'todo-not-updated' => 'Datowa sajźba datoweje banki njejo se dała aktualizěrowaś',
	'todo-issue-summary' => 'Zespominanje problema:',
	'todo-form-details' => 'Drobnostki:',
	'todo-form-email' => 'Zapiš swóju e-mailowu adresu, aby dostał powěsć, gaž zapisk se zacynja',
	'todo-form-submit' => 'Napšašanje wótpósłaś',
	'right-todo' => 'Lisćina nadawkow',
	'right-todosubmit' => 'Pšawo wužywarskeje lisćiny nadawkow wobgranicowaś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author K sal 15
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'todo' => 'Λίστα εργασιών',
	'todo-tab' => 'τα πρακτέα',
	'todo-new-queue' => 'Νέο',
	'todo-mail-subject' => 'Ολοκληρώθηκε το αντικείμενο στην todo λίστα της $1',
	'todo-invalid-item' => 'Χαμένο ή άκυρο στοιχείο',
	'todo-update-else-item' => 'Προσπάθεια ενημέρωσης αντικειμένων κάποιου άλλου',
	'todo-unrecognize-type' => 'Μη αναγνωρισμένος τύπος',
	'todo-item-list' => 'Τα αντικείμενα σας',
	'todo-no-item' => 'Κανένα αντικείμενο προς υλοποίηση.',
	'todo-invalid-owner' => 'Άκυρος ιδιοκτήτης αυτού του αντικειμένου',
	'todo-add-queue' => 'Προσθήκη ουράς…',
	'todo-move-queue' => 'Μετακίνηση στην ουρά...',
	'todo-list-for' => 'Λίστα πρακτέων για $1',
	'todo-list-change' => 'Αλλαγή',
	'todo-list-cancel' => 'Έξοδος',
	'todo-new-item' => 'Νέο αντικείμενο',
	'todo-issue-summary' => 'Σύνοψη τεύχους:',
	'todo-form-details' => 'Λεπτομέρειες:',
	'todo-form-submit' => 'Καταχώρηση αιτήματος',
	'right-todo' => 'Λίστα πρακτέων',
);

/** British English (British English)
 * @author Reedy
 */
$messages['en-gb'] = array(
	'todo-unrecognize-type' => 'Unrecognised type',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'todo' => 'Tasklisto',
	'todo-desc' => 'Eksperimenta propra kromprogramo [[Special:Todo|tasklisto]]',
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
	'todo-list-for' => 'Tasklisto por $1',
	'todo-list-change' => 'Ŝanĝu',
	'todo-list-cancel' => 'Nuligi',
	'todo-new-item' => 'Nova aĵo',
	'todo-issue-summary' => 'Enmeti resumon:',
	'todo-form-details' => 'Detaloj:',
	'todo-form-submit' => 'Enigi serĉomendon',
	'right-todo' => 'Havi taskliston',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'todo' => 'Lista de quehaceres',
	'todo-desc' => 'Extensión de [[Special:Todo|Lista de quehaceres]] personal experimental',
	'todo-tab' => 'quehaceres',
	'todo-new-queue' => 'nuevo',
	'todo-mail-subject' => 'Item completado en la lista de quehaceres de $1',
	'todo-mail-body' => 'Solicitaste confirmación de correo electrónico acerca lo completado de un item que has enviado a la lista de quehaceres en línea de $1.

Item: $2
Enviado: $3

Este item ha sido marcado como completo, con este comentario:
$4',
	'todo-invalid-item' => 'Item perdido o inválido',
	'todo-update-else-item' => 'Tratando de actualizar items de alguien más',
	'todo-unrecognize-type' => 'Tipo no reconocido',
	'todo-user-invalide' => 'Quehaceres dados inválidos, perdidos, o usuario que no puede realizar quehaceres.',
	'todo-item-list' => 'Sus items',
	'todo-no-item' => 'Sin items de quehaceres.',
	'todo-invalid-owner' => 'Propietario inválido en este item',
	'todo-add-queue' => 'Agregar cola...',
	'todo-move-queue' => 'Mover a la cola...',
	'todo-list-for' => 'Lista de quehaceres para $1',
	'todo-list-change' => 'Cambiar',
	'todo-list-cancel' => 'Cancelar',
	'todo-new-item' => 'Nuevo item',
	'todo-not-updated' => 'No se pudo actualizar el registro de base de datos',
	'todo-issue-summary' => 'Resumen de asuntos:',
	'todo-form-details' => 'Detalles:',
	'todo-form-email' => 'Para recibir notificación por correo electrónico cuando el item está cerrado, escriba su dirección aquí:',
	'todo-form-submit' => 'enviar pregunta',
	'right-todo' => 'Tener lista de quehaceres',
	'right-todosubmit' => 'Restringir derecho de lista de quehaceres de usuario',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'todo' => 'Egitekoen zerrenda',
	'todo-new-queue' => 'berria',
	'todo-add-queue' => 'Ilarara gehitu...',
	'todo-move-queue' => 'Ilarara mugitu...',
	'todo-list-change' => 'Aldatu',
	'todo-list-cancel' => 'Utzi',
	'todo-issue-summary' => 'Gaiaren laburpena:',
	'todo-form-details' => 'Xehetasunak:',
	'todo-form-submit' => 'Galdeketa bidali',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Silvonen
 * @author Str4nd
 * @author ZeiP
 */
$messages['fi'] = array(
	'todo' => 'Tehtävälista',
	'todo-desc' => 'Kokeellinen laajennus henkilökohtaisille [[Special:Todo|tehtävälistoille]]',
	'todo-tab' => 'tehtävät',
	'todo-new-queue' => 'uusi',
	'todo-mail-subject' => 'Suoritettu tehtävä $1:n muistilistalta',
	'todo-mail-body' => 'Pyysit sähköpostivahvistusta käyttäjän $1 tehtävämuistilistalle lisäämäsi tehtävän suorittamisesta.

Tehtävä: $2
Lisätty: $3

Tämä tehtävä on merkitty suoritetuksi kommentilla:
$4',
	'todo-invalid-item' => 'Puuttuva tai virheellinen tehtävä',
	'todo-update-else-item' => 'Yritetään päivittää jonkin muun tehtävää',
	'todo-unrecognize-type' => 'Tunnistamaton tyyppi',
	'todo-user-invalide' => 'Annettu tehtävä on kelvoton tai puuttuva, tai käyttäjä on sopimaton.',
	'todo-item-list' => 'Tehtäväsi',
	'todo-no-item' => 'Ei tehtäviä.',
	'todo-invalid-owner' => 'Tässä tehtävässä on virheellinen omistaja',
	'todo-add-queue' => 'Lisää jonoon…',
	'todo-move-queue' => 'Siirrä jonoon…',
	'todo-list-for' => 'Tehtävälista käyttäjälle $1',
	'todo-list-change' => 'Muuta',
	'todo-list-cancel' => 'Peruuta',
	'todo-new-item' => 'Uusi tehtävä',
	'todo-issue-summary' => 'Tehtävän yhteenveto',
	'todo-form-details' => 'Tiedot',
	'todo-form-email' => 'Saadaksesi ilmoituksen sähköpostitse kun tämä merkintä on suljettu, syötä sähköpostiosoitteesi:',
	'todo-form-submit' => 'Lähetä kysely',
	'right-todo' => 'Käyttää tehtäväluetteloa',
	'right-todosubmit' => 'Rajoittaa käyttäjien tehtäväluettelojen oikeuksia',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author McDutchie
 * @author Peter17
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'todo' => 'Liste des choses à faire',
	'todo-desc' => 'Extension expérimentale pour une [[Special:Todo|liste personnelle de choses à faire]]',
	'todo-tab' => 'à faire',
	'todo-new-queue' => 'Nouveau',
	'todo-mail-subject' => 'Élément achevé dans la liste des choses à faire de $1',
	'todo-mail-body' => 'Vous avez demandé à être notifié par courriel lors de l’achèvement d’un élément que vous inscrit dans la liste des choses à faire de $1.

Élément : $2
Soumis : $3

Cet élément a été marqué comme terminé, avec le commentaire suivant :
$4',
	'todo-invalid-item' => 'Élément manquant ou invalide',
	'todo-update-else-item' => 'Tentative de mise à jour des éléments de quelqu’un d’autre',
	'todo-unrecognize-type' => 'Type non reconnu',
	'todo-user-invalide' => 'La chose à faire spécifiée est invalide, manquante, ou l’utilisateur n’a pas de liste de choses à faire.',
	'todo-item-list' => 'Vos éléments',
	'todo-no-item' => 'Aucun élément à accomplir.',
	'todo-invalid-owner' => 'Propriétaire de cet élément invalide',
	'todo-add-queue' => 'Ajouter à la liste d’attente…',
	'todo-move-queue' => 'Déplacer vers la liste d’attente…',
	'todo-list-for' => 'Liste des choses à faire pour $1',
	'todo-list-change' => 'Changer',
	'todo-list-cancel' => 'Annuler',
	'todo-new-item' => 'Nouvel élément',
	'todo-not-updated' => 'Impossible de mettre à jour l’enregistrement dans la base de données',
	'todo-issue-summary' => 'Résumé du problème :',
	'todo-form-details' => 'Précisions :',
	'todo-form-email' => 'Pour recevoir un courriel de notification lorsque l’élément sera fermé, inscrivez votre adresse dans le cadre ci-dessous :',
	'todo-form-submit' => 'Soumettre la requête',
	'right-todo' => 'Avoir une liste de choses à faire',
	'right-todosubmit' => 'Restreindre les droits des listes personnelles de choses à faire',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'todo' => 'Lista de chouses a fâre',
	'todo-desc' => 'Èxtension èxpèrimentâla por una [[Special:Todo|lista a sè de chouses a fâre]].',
	'todo-tab' => 'a fâre',
	'todo-new-queue' => 'Novél',
	'todo-mail-subject' => 'Èlèment chavonâ dens la lista de chouses a fâre de $1',
	'todo-invalid-item' => 'Èlèment manquent ou ben envalido',
	'todo-update-else-item' => 'Tentativa de misa a jorn des èlèments de quârqu’un d’ôtro',
	'todo-unrecognize-type' => 'Tipo pas recognu',
	'todo-user-invalide' => 'La chousa a fâre spècefiâ est envalida, manquenta, ou ben l’usanciér at pas de lista de chouses a fâre.',
	'todo-item-list' => 'Voutros èlèments',
	'todo-no-item' => 'Gins d’èlèment a fâre.',
	'todo-invalid-owner' => 'Propriètèro de ceti èlèment envalido',
	'todo-add-queue' => 'Apondre a la lista d’atenta...',
	'todo-move-queue' => 'Dèplaciér vers la lista d’atenta...',
	'todo-list-for' => 'Lista de chouses a fâre por $1',
	'todo-list-change' => 'Changiér',
	'todo-list-cancel' => 'Anular',
	'todo-new-item' => 'Novél èlèment',
	'todo-not-updated' => 'Empossiblo de betar a jorn l’encartâjo dens la bâsa de balyês',
	'todo-issue-summary' => 'Rèsumâ du problèmo :',
	'todo-form-details' => 'Dètalys :',
	'todo-form-email' => 'Por recêvre un mèssâjo de notificacion quand l’èlèment serat cllôs, enscrîde voutra adrèce dens lo câdro ce-desot :',
	'todo-form-submit' => 'Sometre la requéta',
	'right-todo' => 'Avêr una lista de chouses a fâre',
	'right-todosubmit' => 'Rètrendre los drêts de les listes a sè de chouses a fâre',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 */
$messages['fy'] = array(
	'todo-list-cancel' => 'Ofbrekke',
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
	'todo-list-for' => 'Lista de tarefas pendentes de $1',
	'todo-list-change' => 'Cambiar',
	'todo-list-cancel' => 'Cancelar',
	'todo-new-item' => 'Novo artigo',
	'todo-not-updated' => 'Non se puido actualizar o rexistro da base de datos',
	'todo-issue-summary' => 'Resumo do tema:',
	'todo-form-details' => 'Detalles:',
	'todo-form-email' => 'Para recibir unha notificación por correo electrónico cando o artigo esté pechado, teclee o seu enderezo aquí:',
	'todo-form-submit' => 'Enviar a consulta',
	'right-todo' => 'Ter unha lista coas tarefas pendentes por facer',
	'right-todosubmit' => 'Restrinxir o dereito de usuario de ter unha lista coas tarefas pendentes',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'todo-new-queue' => 'νέα',
	'todo-add-queue' => 'Προσθήκη οὐρᾶς…',
	'todo-list-cancel' => 'Ἀκυροῦν',
	'todo-issue-summary' => 'Σύνοψις τεύχους:',
	'todo-form-details' => 'Λεπτομέρειαι:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'todo' => 'Ufgabelischt',
	'todo-desc' => 'Experimentälli persenligi [[Special:Todo|Ufgabelischt]]',
	'todo-tab' => 'Ufgabe',
	'todo-new-queue' => 'Nöu',
	'todo-mail-subject' => 'Yytrag uf dr Ufgabelischt vu $1 abgschlosse',
	'todo-mail-body' => 'Du hesch e Nochricht gwinscht, wänn e Uftrag abgschlosse woren isch, wu Du an $1 wytergee hesh.

Yytrag: $2
Wytergeen: $3

Dää Yytrag isch as abgschlosse markiert mit däm Kommentar:
$4',
	'todo-invalid-item' => 'Yytrag fählt oder isch falsch',
	'todo-update-else-item' => 'Du versuechsch, d Yyträg vu eber anderem z bearbeite',
	'todo-unrecognize-type' => 'Nit bekannter Typ',
	'todo-user-invalide' => 'Dr erteilt Uftrag isch nit giltig: Benutzer fählt oder het kei Ufgabelischt.',
	'todo-item-list' => 'Dyyni Yyträg',
	'todo-no-item' => 'Kei Ufgabe.',
	'todo-invalid-owner' => 'Uugiltiger Bsitzer fir dää Yytrag',
	'todo-add-queue' => 'Warteschlang zuefiege …',
	'todo-move-queue' => 'In d Warteschlang verschiebe ...',
	'todo-list-for' => 'Ufgabelischt fir $1',
	'todo-list-change' => 'Ändere',
	'todo-list-cancel' => 'Abbräche',
	'todo-new-item' => 'Neije Yytrag',
	'todo-not-updated' => 'Dr Datensatz het nit chenne aktualisiert wäre in dr Datebank',
	'todo-issue-summary' => 'Zämmefassig vum Uftrag:',
	'todo-form-details' => 'Detail:',
	'todo-form-email' => 'Gib Dyy E-Mail-Adräss yy go ne Benochrichtigung iberchu, wänn dr Yytrag zuegmacht woren isch:',
	'todo-form-submit' => 'Aafrog ibergee',
	'right-todo' => 'Ufgabe-Lischt haa',
	'right-todosubmit' => 'S Rächt vum e Benutzer yyschränke, e Ufgabe-Lischt z haa',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'todo-list-cancel' => 'Soke',
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
	'todo-list-for' => 'רשימת המטלות עבור $1',
	'todo-list-change' => 'שינוי',
	'todo-list-cancel' => 'ביטול',
	'todo-new-item' => 'פריט חדש',
	'todo-not-updated' => 'לא ניתן לעדכן את הרשומה במסד הנתונים',
	'todo-issue-summary' => 'תקציר הנושא:',
	'todo-form-details' => 'פרטים:',
	'todo-form-email' => 'על מנת לקבל התראה בדוא"ל אודות סגירת פריט, הזינו את כתובת הדוא"ל שלכם כאן:',
	'todo-form-submit' => 'שליחת השאילתה',
	'right-todo' => 'החזקת רשימת מטלות',
	'right-todosubmit' => 'הגבלת הרשאות המשתמש לרשימת המטלות',
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
	'todo-list-for' => 'Lisćina nadawkow za $1',
	'todo-list-change' => 'Změnić',
	'todo-list-cancel' => 'Přetorhnyć',
	'todo-new-item' => 'Nowy nadawk',
	'todo-not-updated' => 'Datowa sadźba datoweje banki njeda so aktualizować',
	'todo-issue-summary' => 'Zjeće wudać:',
	'todo-form-details' => 'Podrobnosće',
	'todo-form-email' => 'Zo by zdźělenje z e-mejlu dóstał, hdyž so nadawk kónči, zapodaj tu swoju adresu:',
	'todo-form-submit' => 'Naprašowanje wotesłać',
	'right-todo' => 'Lisćina nadawkow',
	'right-todosubmit' => 'Prawo wužiwarskeje lisćiny nadawkow wobmjezować',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dj
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'todo' => 'Tennivalók listája',
	'todo-desc' => 'Kísérleti személyes [[Special:Todo|feladatlista]] kiterjesztés',
	'todo-tab' => 'tennivalók',
	'todo-new-queue' => 'új',
	'todo-mail-subject' => 'Elvégzett feladat $1 teendőlistáján',
	'todo-mail-body' => 'E-mail értesítést kértél $1 online feladatlistájára küldött teendő elvégzéséről.

Feladat: $2
Elküldve: $3

Ezt a feladatot késznek jelölték, a következő megjegyzéssel:
$4',
	'todo-invalid-item' => 'Hiányzó vagy érvénytelen feladat',
	'todo-update-else-item' => 'Valaki másnak a teendőit próbálod frissíteni',
	'todo-unrecognize-type' => 'Ismeretlen típus',
	'todo-user-invalide' => 'A feladatot érvénytelen, nem létező vagy feladatlistával nem rendelkező felhasználó kapta.',
	'todo-item-list' => 'Saját feladataid',
	'todo-no-item' => 'Nincsenek feladatok.',
	'todo-invalid-owner' => 'Érvénytelen tulajdonos ennél a feladatnál',
	'todo-add-queue' => 'Várakozási sor hozzáadása…',
	'todo-move-queue' => 'Áthelyezés várakozási sorba…',
	'todo-list-for' => '$1 feladatlistája',
	'todo-list-change' => 'Változtatás',
	'todo-list-cancel' => 'Mégse',
	'todo-new-item' => 'Új teendő',
	'todo-not-updated' => 'Adatbázis rekord frissítése sikertelen',
	'todo-issue-summary' => 'Ügy összefoglalója:',
	'todo-form-details' => 'Részletek:',
	'todo-form-email' => 'Ha szeretnél értesítést kapni e-mailben a feladat lezárásakor, add meg a címedet:',
	'todo-form-submit' => 'Lekérdezés elküldése',
	'right-todo' => 'van feladatlistája',
	'right-todosubmit' => 'feladatlista jogosultsága korlátozva',
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
	'todo-list-for' => 'Lista de cargas a facer pro $1',
	'todo-list-change' => 'Cambiar',
	'todo-list-cancel' => 'Cancellar',
	'todo-new-item' => 'Nove carga',
	'todo-not-updated' => 'Non poteva actualisar le registro de base de datos',
	'todo-issue-summary' => 'Summario:',
	'todo-form-details' => 'Detalios:',
	'todo-form-email' => 'Pro reciper notification per e-mail quando le carga es claudite, entra tu adresse hic:',
	'todo-form-submit' => 'Submitter requesta',
	'right-todo' => 'Haber un lista de cosas a facer',
	'right-todosubmit' => 'Restringer le derectos de usatores al lista de cosas a facer',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'todo' => 'Daftar tugas',
	'todo-desc' => 'Ekstensi [[Special:Todo|daftar tugas]] pribadi eksperimental',
	'todo-tab' => 'tugas',
	'todo-new-queue' => 'baru',
	'todo-mail-subject' => 'Butir yang terselesaikan pada daftar tugas $1',
	'todo-mail-body' => 'Anda meminta konfirmasi surel tentang penyelesaian suatu tugas yang Anda kirimkan pada daftar tugas daring milik $1.

Tugas: $2
Dikirim: $3

Tugas ini telah ditandai selesai dengan komentar berikut:
$4',
	'todo-invalid-item' => 'Tugas tidak ditemukan atau tidak valid',
	'todo-update-else-item' => 'Mencoba untuk memperbarui tugas orang lain',
	'todo-unrecognize-type' => 'Tipe tak dikenal',
	'todo-user-invalide' => 'Tugas yang diberikan tidak valid, tidak ditemukan, atau pengguna tidak dapat ditugasi',
	'todo-item-list' => 'Tugas Anda',
	'todo-no-item' => 'Tidak ada tugas.',
	'todo-invalid-owner' => 'Pemilik tidak valid dari tugas ini',
	'todo-add-queue' => 'Menambahkan antrean...',
	'todo-move-queue' => 'Pindahkan ke antrean...',
	'todo-list-for' => 'Daftar tugas untuk $1',
	'todo-list-change' => 'Berubah',
	'todo-list-cancel' => 'Batalkan',
	'todo-new-item' => 'Butir baru',
	'todo-not-updated' => 'Tidak dapat memperbarui basis data',
	'todo-issue-summary' => 'Ringkasan isu:',
	'todo-form-details' => 'Rincian:',
	'todo-form-email' => 'Untuk menerima pemberitahuan melalui surel ketika tugas tersebut ditutup, masukkan alamat Anda:',
	'todo-form-submit' => 'Kirim kueri',
	'right-todo' => 'Memiliki daftar tugas',
	'right-todosubmit' => 'Membatasi hak daftar tugas pengguna',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'todo-list-change' => 'Gbanwe',
	'todo-list-cancel' => 'Kàchá',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'todo-list-cancel' => 'Annulla',
	'todo-form-details' => 'Dettagli:',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author 青子守歌
 */
$messages['ja'] = array(
	'todo' => 'ToDo一覧',
	'todo-desc' => '個人用の[[Special:Todo|ToDo一覧]]を実現する実験的な拡張機能',
	'todo-tab' => 'やること',
	'todo-new-queue' => '新規',
	'todo-mail-subject' => '$1 のToDoリスト上の項目が完了しました',
	'todo-mail-body' => 'ご依頼にそって、あなたが $1 のToDo一覧に登録した項目の完了をメールにて通知いたしました。

項目: $2
登録日時: $3

この項目は以下のコメントを添えて、完了済みとされました。
$4',
	'todo-invalid-item' => '項目が見当たらないか、不正です',
	'todo-update-else-item' => '他の誰かの項目を更新しようとしています',
	'todo-unrecognize-type' => '認識されない種類',
	'todo-user-invalide' => '指定された利用者は、不正、見つけれない、またはこの機能を利用できません。',
	'todo-item-list' => 'あなたの項目',
	'todo-no-item' => 'やるべき課題はありません。',
	'todo-invalid-owner' => 'この項目の担当者が無効です',
	'todo-add-queue' => 'キューに追加…',
	'todo-move-queue' => 'キューに移動…',
	'todo-list-for' => '$1 のToDo一覧',
	'todo-list-change' => '変更',
	'todo-list-cancel' => '中止',
	'todo-new-item' => '新規項目',
	'todo-not-updated' => 'データベースレコードを更新できませんでした',
	'todo-issue-summary' => '課題要約:',
	'todo-form-details' => '詳細:',
	'todo-form-email' => '項目が完了した際に電子メールで通知を希望するなら、あなたのアドレスをここに入力してください:',
	'todo-form-submit' => '送信',
	'right-todo' => 'ToDo一覧をもつ',
	'right-todosubmit' => '利用者のToDo一覧に関する権限を制限する',
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
	'todo-list-for' => 'Daftar tugas kanggo $1',
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
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'todo' => 'បញ្ជីកិច្ចការ​ត្រូវ​ធ្វើ',
	'todo-tab' => 'ត្រូវធ្វើ',
	'todo-new-queue' => 'ថ្មី',
	'todo-unrecognize-type' => 'ប្រភេទមិនស្គាល់',
	'todo-item-list' => 'ធាតុ​របស់​អ្នក',
	'todo-add-queue' => 'បន្ថែម ជួររង់ចាំ...',
	'todo-list-for' => 'បញ្ជី​កិច្ចការ​ដែល​ត្រូវ​ធ្វើ​ សម្រាប់​ $1',
	'todo-list-change' => 'ផ្លាស់ប្តូរ',
	'todo-list-cancel' => 'បោះបង់',
	'todo-new-item' => 'របស់ថ្មី',
	'todo-issue-summary' => 'សេចក្ដី​សង្ខេប​នៃ​បញ្ហា​៖',
	'todo-form-details' => 'លំអិត ៖',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'todo-new-queue' => 'ಹೊಸ',
	'todo-list-cancel' => 'ರದ್ದು ಮಾಡು',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'todo-list-cancel' => 'Kanselar',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'todo' => 'Aufjabeleß',
	'todo-desc' => 'Ene Zosatz för en persönliche [[Special:Todo|Aufjabeleß]] för zem Ußprobeere.',
	'todo-tab' => 'Aufjab',
	'todo-new-queue' => 'neu',
	'todo-mail-subject' => 'Erledichte Aufjab en {{GENDER:$1|däm $1 sing|däm $1 sing|däm Metmaacher $1 sing|däm $1 sing|dä $1 ier}} Aufjabeleß',
	'todo-mail-body' => 'Do häs Der en <i lang="en">e-Mail</i> jewönsch, wann en Aufjab erledich wöhr, die De {{GENDER:$1|dem $1 en sing|em $1 en sing|däm Metmaacher $1 en de|däm $1 en sing|dä $1 en ier}} Aufjabeleß jedonn häs. He is se:

De Aufjab: $2
Enjedrage: $3

Se wood als erledich makeet mit dä Bemerkung:
$4

Ene schone Jroß.',
	'todo-invalid-item' => 'Die Aufjab fäält, odder se es kapott',
	'todo-update-else-item' => 'Enem andere Metmaacher sing Aufjabe ändere',
	'todo-unrecognize-type' => 'Di Aat Aufjab kenne mer nit',
	'todo-user-invalide' => 'Die Aufjab es kapott, odder se es nit doh, odder dä Medmaacher kann jaa kein Aufjabe han.',
	'todo-item-list' => 'Ding Aufjabe',
	'todo-no-item' => 'Kein Aufjabe en de Leß.',
	'todo-invalid-owner' => 'Dä Medmaacher för di Aufjab is nit müjjelisch',
	'todo-add-queue' => 'En Schlang dobei donn&nbsp;…',
	'todo-move-queue' => 'En de Schlang donn&nbsp;…',
	'todo-list-for' => '{{GENDER:$1|Dämm $1 sing|Em $1 sing|Däm Metmaacher $1 de|Däm $1 sing|Dä $1 ier}} Aufjabeleß',
	'todo-list-change' => 'Ändere',
	'todo-list-cancel' => 'Draanjevve',
	'todo-new-item' => 'En neu Aufjab',
	'todo-not-updated' => 'Mer kunnte dä Daatesaz en dä Daatebangk nit op der neue Schtand bränge.',
	'todo-issue-summary' => 'Zosammefassung:',
	'todo-form-details' => 'Einzelheite:',
	'todo-form-email' => 'Öm en <i lang="en">e-mail</i> ze krijje, wann di Aufjab afjeschlosse weed, jif Ding Adress för de <i lang="en">e-mail</i> hee en:',
	'todo-form-submit' => 'Loß Jonn!',
	'right-todo' => 'En Aufjabeleß han künne',
	'right-todosubmit' => 'Anderlücks Rääsch an un op en Aufjabeleß beschrängke',
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
	'todo-add-queue' => 'Lëscht (queue) derbäisetzen ...',
	'todo-move-queue' => "Op d'Lëscht (queue) derbäisetzen",
	'todo-list-for' => 'Lëscht vun den Aufgabe fir $1',
	'todo-list-change' => 'Änneren',
	'todo-list-cancel' => 'Annulléieren',
	'todo-new-item' => 'Neien Objet',
	'todo-issue-summary' => 'Resumé vun der Aufgab:',
	'todo-form-details' => 'Detailer:',
	'todo-form-submit' => 'Ufro starten',
);

/** Lazuri (Lazuri)
 * @author Bombola
 */
$messages['lzz'] = array(
	'todo-new-queue' => 'ağani',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'todo-list-cancel' => 'Чараш',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'todo' => 'Список на задачи',
	'todo-desc' => 'Експериментален додаток за личен [[Special:Todo|список на задачи]]',
	'todo-tab' => 'задачи',
	'todo-new-queue' => 'нова',
	'todo-mail-subject' => 'Завршена задача на списокот на задачи на $1',
	'todo-mail-body' => 'Побаравте потврда по е-пошта за завршувањето на задача која сте ја поставиле на списокот на задачи на $1.

Задача: $2
Поставено: $3

Оваа задача е означена како завршена, заедно со следниов коментар:
$4',
	'todo-invalid-item' => 'Изгубена или неважечка задача',
	'todo-update-else-item' => 'Обид за поднова на туѓи задачи',
	'todo-unrecognize-type' => 'Непризнаен тип',
	'todo-user-invalide' => 'На задачите им е зададен погрешен или отсутен корисник, или пак корисник кој нема надлежност за задачата.',
	'todo-item-list' => 'Ваши задачи',
	'todo-no-item' => 'Нема задачи.',
	'todo-invalid-owner' => 'Погрешен сопственик за оваа задача',
	'todo-add-queue' => 'Додај редица...',
	'todo-move-queue' => 'Премести во редот на чекање...',
	'todo-list-for' => 'Список на задачи за $1',
	'todo-list-change' => 'Смени',
	'todo-list-cancel' => 'Откажи',
	'todo-new-item' => 'Нова задача',
	'todo-not-updated' => 'Не можев да ја подновам евиденцијата во базата',
	'todo-issue-summary' => 'Преглед на проблемот:',
	'todo-form-details' => 'Подробно:',
	'todo-form-email' => 'За да добивате известување по е-пошта кога некоја задача е затворена, внесете ја вашата адреса:',
	'todo-form-submit' => 'Постави барање',
	'right-todo' => 'Имање на список на задачи',
	'right-todosubmit' => 'Ограничување на правото на списокот на задачи на еден корисник',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'todo-new-queue' => 'പുതിയത്',
	'todo-list-change' => 'മാറ്റം',
	'todo-list-cancel' => 'റദ്ദാക്കുക',
	'todo-new-item' => 'പുതിയ ഇനം',
	'todo-form-details' => 'വിശദാംശങ്ങൾ:',
	'todo-form-submit' => 'ചോദ്യം (query) സമർപ്പിക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'todo-list-cancel' => 'Цуцлах',
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
	'todo-list-for' => '(ची) करावयाच्या गोष्टींची यादी $1',
	'todo-list-change' => 'बदल',
	'todo-list-cancel' => 'रद्द करा',
	'todo-new-item' => 'नवीन नोंद',
	'todo-issue-summary' => 'चर्चा सारांश:',
	'todo-form-details' => 'तपशील:',
	'todo-form-submit' => 'पृच्छा पाठवा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'todo-new-queue' => 'baru',
	'todo-list-cancel' => 'Batalkan',
	'todo-form-details' => 'Butiran:',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
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
	'todo-list-for' => 'Oppgaveliste for $1',
	'todo-list-change' => 'Endre',
	'todo-list-cancel' => 'Avbryt',
	'todo-new-item' => 'Ny oppgave',
	'todo-not-updated' => 'Kunne ikke oppdatere databaseoppføringen',
	'todo-issue-summary' => 'Sammendrag:',
	'todo-form-details' => 'Detaljer:',
	'todo-form-email' => 'Skriv inn e-postadressen din her for å mottå beskjed på e-post når oppgaven er fullført:',
	'todo-form-submit' => 'Utfør',
	'right-todo' => 'Ha en å gjøre-liste',
	'right-todosubmit' => 'Begrens en brukers å gjøre-listerettigheter',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'todo' => 'Opgavenlist',
	'todo-tab' => 'Opgaven',
	'todo-new-queue' => 'nee',
	'todo-no-item' => 'Nix op de Opgavenlist.',
	'todo-list-for' => 'Opgavenlist för $1',
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
	'todo-list-for' => 'Takenlijst voor $1',
	'todo-list-change' => 'Wijzigen',
	'todo-list-cancel' => 'Annuleren',
	'todo-new-item' => 'Nieuw item',
	'todo-not-updated' => 'Het databaserecord kon niet bijgewerkt worden',
	'todo-issue-summary' => 'Samenvatting onderwerp:',
	'todo-form-details' => 'Details:',
	'todo-form-email' => 'Voer hier uw e-mailadres in om een melding te krijgen als dit onderwerp wordt gesloten:',
	'todo-form-submit' => 'Zoekopdracht uitvoeren',
	'right-todo' => 'Todo-lijst hebben',
	'right-todosubmit' => 'Gebruikersrechten op todo-lijst beperken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
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

Oppgåva er merkt som fullført, med denne kommentaren:
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
	'todo-list-for' => 'Oppgåveliste for $1',
	'todo-list-change' => 'Endre',
	'todo-list-cancel' => 'Avbryt',
	'todo-new-item' => 'Ny oppgåve',
	'todo-issue-summary' => 'Samandrag:',
	'todo-form-details' => 'Detaljar:',
	'todo-form-email' => 'Skriv inn e-postadressa din her for å motta melding på e-post når oppgava er fullført:',
	'todo-form-submit' => 'Utfør',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'todo-list-change' => 'Fetloa',
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
	'todo-list-for' => "Lista dels prètzfaches d'executar per $1",
	'todo-list-change' => 'Modificar',
	'todo-list-cancel' => 'Anullar',
	'todo-new-item' => 'Article novèl',
	'todo-issue-summary' => 'Resumit brèu :',
	'todo-form-details' => 'Precisions :',
	'todo-form-email' => 'Per recebre las notificacions per corrièr electronic un còp l’article clausurat, inscrivètz vòstra adreça dins lo quadre çaijós :',
	'todo-form-submit' => 'Sometre la requèsta',
	'right-todo' => 'Aver una lista de causas de far',
	'right-todosubmit' => 'Restrénher los dreches de las listas personalas de causas de far',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'todo' => 'କାମ ତାଲିକା',
	'todo-desc' => 'ଆପଣା ପରଖ [[Special:Todo|କରିବାକୁ ଥିବା କାମର ତାଲିକା]] ଏକ୍ସଟେନସନ',
	'todo-tab' => 'କରିବାକୁ ଥିବା କାମ',
	'todo-new-queue' => 'ନୂଆ',
	'todo-mail-subject' => '$1ର କରିବାକୁ ଥିବା କାମର ତାଲିକାରେ ଥିବା ସମାପ୍ତ କାମ',
	'todo-mail-body' => '$1ଙ୍କର କରିବାକୁ ଥିବା କାମର ଅନଲାଇନ ତାଲିକାରେ ଏକ କାମ ବାବଦରେ ଆପଣ ଇ-ମେଲ ଥୟ କରିବା ନିମନ୍ତେ ପଠାଇଛନ୍ତି ।

ବସ୍ତୁ: $2
ପଠାଗଲା: $3

ଏହି ବସ୍ତୁଟି ସରିଯାଇଛି ବୋଲି ଚିହ୍ନିତ କରାଗଲା, ମତାମତ:
$4',
	'todo-invalid-item' => 'ନଥିବା ବା ଅବୈଧ ବସ୍ତୁ',
	'todo-update-else-item' => 'ଆଉଅଜଣକର ବସ୍ତୁ ସତେଜ କରାଉଛି',
	'todo-unrecognize-type' => 'ଅଚିହ୍ନା ପ୍ରକାର',
	'todo-list-cancel' => 'ନାକଚ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'todo-list-cancel' => 'Нæ бæззы',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'todo-new-queue' => 'Nei',
	'todo-list-change' => 'Ennere',
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
	'todo-list-for' => 'Lista zadań dla $1',
	'todo-list-change' => 'Zmień',
	'todo-list-cancel' => 'Anuluj',
	'todo-new-item' => 'Nowa pozycja',
	'todo-not-updated' => 'Nie można wykonać aktualizacji rekordu bazy danych',
	'todo-issue-summary' => 'Podsumowanie kwestii:',
	'todo-form-details' => 'Szczegóły:',
	'todo-form-email' => 'Jeśli chcesz otrzymać powiadomienie pocztą elektroniczna po zamknięciu tej pozycji, wpisz w polu poniżej swój adres e‐mail:',
	'todo-form-submit' => 'Wyślij zapytanie',
	'right-todo' => 'Posiada listę zadań do wykonania',
	'right-todosubmit' => 'Ograniczanie dostępu użytkowników do listy zadań',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'todo' => 'lista da fé',
	'todo-desc' => 'Estension përsonal sperimental [[Special:Todo|lista da fé]]',
	'todo-tab' => 'da fé',
	'todo-new-queue' => 'neuv',
	'todo-mail-subject' => 'Element completà an sla lista da fé ëd $1',
	'todo-mail-body' => "Ti it l'has ciamà la conferma për pòsta eletrònica dël completament ëd n'element ch'it l'has butà an sla lista an linia da fé ëd $1.

Element: $2
Butà: $3

Sto element-sì a l'é stàit marcà com completà, con sto coment-sì:
$4",
	'todo-invalid-item' => 'Element mancant o pa bon',
	'todo-update-else-item' => "Tentativ d'agiorné j'element ëd cheidun d'àutr",
	'todo-unrecognize-type' => 'Sòrt pa arconossùa',
	'todo-user-invalide' => "Ròba da fé pa bon-a, mancanta o l'utent a l'ha pa na lista ëd ròbe da fé.",
	'todo-item-list' => 'Tò element',
	'todo-no-item' => 'Pa gnun element da fé.',
	'todo-invalid-owner' => 'Assignatari pa bon dzora sto element-sì',
	'todo-add-queue' => 'Gionta coa ...',
	'todo-move-queue' => 'Tramuda a la coa ...',
	'todo-list-for' => 'Lista da fé për $1',
	'todo-list-change' => 'Cambia',
	'todo-list-cancel' => 'Scancela',
	'todo-new-item' => 'Element neuv',
	'todo-not-updated' => "A l'é impossìbil agiorné l'argistrassion ant la base ëd dàit",
	'todo-issue-summary' => 'Resumé dël problema:',
	'todo-form-details' => 'Detaj',
	'todo-form-email' => "Për arsèive notìfiche për pòsta eletrònica quand che l'element a l'é sarà, dà toa adrëssa:",
	'todo-form-submit' => 'Anseriss la query',
	'right-todo' => 'Oten la lista da fé',
	'right-todosubmit' => "Strenz ij drit ëd la lista da fé ëd l'utent",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'todo-new-queue' => 'نوی',
	'todo-list-change' => 'بدلول',
	'todo-list-cancel' => 'ناګارل',
	'todo-new-item' => 'نوی توکی',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'todo' => 'Lista de tarefas',
	'todo-desc' => 'Extensão experimental de [[Special:Todo|lista pessoal de tarefas]]',
	'todo-tab' => 'tarefas',
	'todo-new-queue' => 'novo',
	'todo-mail-subject' => 'Tarefa finalizada na lista de tarefas de $1',
	'todo-mail-body' => "Pediu confirmação da finalização de uma tarefa que inseriu na lista de tarefas ''online'' de $1.

Tarefa: $2
Submetida a: $3

Esta tarefa foi marcada como completa, com este comentário:
$4",
	'todo-invalid-item' => 'Tarefa inexistente ou inválida',
	'todo-update-else-item' => 'A tentar actualizar as tarefas de outra pessoa',
	'todo-unrecognize-type' => 'Tipo não reconhecido',
	'todo-user-invalide' => 'Tarefa atribuída a utilizador inválido, inexistente ou sem lista de tarefas',
	'todo-item-list' => 'As suas tarefas',
	'todo-no-item' => 'Sem tarefas.',
	'todo-invalid-owner' => 'Proprietário inválido nesta tarefa',
	'todo-add-queue' => 'Adicionar fila…',
	'todo-move-queue' => 'Mover para fila…',
	'todo-list-for' => 'Lista de tarefas de $1',
	'todo-list-change' => 'Alterar',
	'todo-list-cancel' => 'Cancelar',
	'todo-new-item' => 'Novo item',
	'todo-not-updated' => 'Não foi possível actualizar o registo na base de dados',
	'todo-issue-summary' => 'Resumo do problema:',
	'todo-form-details' => 'Detalhes:',
	'todo-form-email' => 'Para receber uma notificação por correio electrónico quando esta tarefa for finalizada, escreva o seu endereço aqui:',
	'todo-form-submit' => 'Submeter pesquisa',
	'right-todo' => 'Possuir lista de tarefas',
	'right-todosubmit' => 'Restringir o privilégio de possuir uma lista de tarefas',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 */
$messages['pt-br'] = array(
	'todo' => 'Lista de tarefas',
	'todo-desc' => 'Extensão experimental de [[Special:Todo|lista pessoal de tarefas]]',
	'todo-tab' => 'tarefas',
	'todo-new-queue' => 'novo',
	'todo-mail-subject' => 'Itens completos na lista de tarefas de $1',
	'todo-mail-body' => 'Você pediu um e-mail de confirmação sobre a finalização de um item que você submeteu para a lista de tarefas online de $1.

Item: $2
Submetido em: $3

Este item foi marcado como completo, com este comentário:
$4',
	'todo-invalid-item' => 'Item em falta ou inválido',
	'todo-update-else-item' => 'Tentando atualizar os itens de outra pessoa',
	'todo-unrecognize-type' => 'Tipo não reconhecido',
	'todo-user-invalide' => 'Tarefa fornecida inválida, em falta, ou utilizador sem possibilidade de tarefas',
	'todo-item-list' => 'Seus itens',
	'todo-no-item' => 'Sem tarefas.',
	'todo-invalid-owner' => 'Proprietário inválido neste item',
	'todo-add-queue' => 'Adicionar fila…',
	'todo-move-queue' => 'Mover para fila…',
	'todo-list-for' => 'Lista de tarefas de $1',
	'todo-list-change' => 'Alterar',
	'todo-list-cancel' => 'Cancelar',
	'todo-new-item' => 'Novo item',
	'todo-not-updated' => 'Não foi possível atualizar o registro na base de dados',
	'todo-issue-summary' => 'Sumário do problema:',
	'todo-form-details' => 'Detalhes:',
	'todo-form-email' => 'Para receber uma notificação por e-mail quando este item for fechado, escreva o seu endereço aqui:',
	'todo-form-submit' => 'Submeter pesquisa',
	'right-todo' => 'Possuir lista de afazeres',
	'right-todosubmit' => 'Restringir o privilégio de lista de afazeres de utilizadores',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'todo-new-queue' => 'amaynu',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'todo' => 'Listă de făcut',
	'todo-tab' => 'de făcut',
	'todo-new-queue' => 'nou',
	'todo-unrecognize-type' => 'Tip nerecunoscut',
	'todo-item-list' => 'Elementele dumneavoastră',
	'todo-add-queue' => 'Adaugă coadă...',
	'todo-list-change' => 'Modifică',
	'todo-list-cancel' => 'Anulează',
	'todo-new-item' => 'Element nou',
	'todo-form-details' => 'Detalii:',
	'todo-form-submit' => 'Trimiteți interogare',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'todo' => 'Liste de le cose da fà',
	'todo-tab' => 'da fà',
	'todo-new-queue' => 'nueve',
	'todo-add-queue' => 'Mitte in coda...',
	'todo-list-for' => 'Liste de le cose da fà pe $1',
	'todo-list-change' => 'Cange',
	'todo-list-cancel' => 'Scangille',
	'todo-form-submit' => 'Conferme inderrogazione',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'todo' => 'Перечень задач',
	'todo-desc' => 'Экспериментальное расширение персональный [[Special:Todo|перечень задач]] (Todo list)',
	'todo-tab' => 'задачи',
	'todo-new-queue' => 'новая',
	'todo-mail-subject' => 'Завершённый пункты в перечне задач $1',
	'todo-mail-body' => 'Вы указали уведомлять по эл. подтверждение о выполнении пунктов, помещённых в перечень задач $1.

Пункт: $2
Размещён: $3

Этот пункт отмечен как выполненный, примечание:
$4',
	'todo-invalid-item' => 'Ошибочный пункт',
	'todo-update-else-item' => 'Попытка обновить чужие пункты',
	'todo-unrecognize-type' => 'Неизвестный тип',
	'todo-user-invalide' => 'Указанный участник ошибочен, отсутствует или не может использоваться в перечне задач.',
	'todo-item-list' => 'Ваши задачи',
	'todo-no-item' => 'Нет записей.',
	'todo-invalid-owner' => 'У этой записи ошибочный владелец',
	'todo-add-queue' => 'Добавить очередь…',
	'todo-move-queue' => 'Переместить в очередь…',
	'todo-list-for' => 'Перечень задач для $1',
	'todo-list-change' => 'Выбрать',
	'todo-list-cancel' => 'Отмена',
	'todo-new-item' => 'Новая запись',
	'todo-not-updated' => 'Не удалось обновить запись базы данных',
	'todo-issue-summary' => 'Краткое описание:',
	'todo-form-details' => 'Подробности:',
	'todo-form-email' => 'Укажите адрес эл. почты, чтобы получить уведомление о выполнении задания.',
	'todo-form-submit' => 'Отправить запрос',
	'right-todo' => 'возможность вести перечень задач',
	'right-todosubmit' => 'ограничивать права участников на ведение перечня задач',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'todo-tab' => 'список задач',
	'todo-new-queue' => 'нова',
	'todo-list-change' => 'Змінити',
	'todo-list-cancel' => 'Зрушыти',
	'todo-new-item' => 'Нова задача',
	'todo-form-details' => 'Детайлы:',
);

/** Sinhala (සිංහල)
 * @author බිඟුවා
 */
$messages['si'] = array(
	'todo-list-change' => 'වෙනස් කිරීම්',
	'todo-list-cancel' => 'අත් හරින්න',
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
	'todo-list-for' => 'Zoznam úloh používateľa $1',
	'todo-list-change' => 'Zmeniť',
	'todo-list-cancel' => 'Zrušiť',
	'todo-new-item' => 'Nová úloha',
	'todo-issue-summary' => 'Zhrnutie problému:',
	'todo-form-details' => 'Podrobnosti:',
	'todo-form-email' => 'Dostať upozornenie emailom, keď bude úloha uzatvorená. Napíšte svoju adresu:',
	'todo-form-submit' => 'Poslať požiadavku',
	'right-todo' => 'Zoznam čo treba spraviť',
	'right-todosubmit' => 'Obmedziť právo používateľa na zoznam čo treba spraviť',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'todo' => 'Списак ствари за урадити',
	'todo-desc' => 'Експериментално [[Special:Todo|todo list]] проширење',
	'todo-tab' => 'за урадити',
	'todo-new-queue' => 'ново',
	'todo-unrecognize-type' => 'Непознат тип',
	'todo-no-item' => 'Нема ствари за урадити.',
	'todo-add-queue' => 'Додај ред…',
	'todo-move-queue' => 'Премести у ред…',
	'todo-list-for' => 'Списак ствари за урадити, за $1',
	'todo-list-change' => 'Измени',
	'todo-list-cancel' => 'Откажи',
	'todo-form-details' => 'Детаљи:',
	'todo-form-submit' => 'Пошањи упит',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'todo' => 'Spisak stvari za uraditi',
	'todo-desc' => 'Eksperimentalno [[Special:Todo|todo list]] proširenje',
	'todo-tab' => 'za uraditi',
	'todo-new-queue' => 'novo',
	'todo-unrecognize-type' => 'Nepoznat tip',
	'todo-no-item' => 'Nema stvari za uraditi.',
	'todo-add-queue' => 'Dodaj red…',
	'todo-move-queue' => 'Premesti u red…',
	'todo-list-for' => 'Spisak stvari za uraditi, za $1',
	'todo-list-change' => 'Izmeni',
	'todo-list-cancel' => 'Otkaži',
	'todo-form-details' => 'Detalji:',
	'todo-form-submit' => 'Pošanji upit',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'todo' => 'Apgoawenlieste',
	'todo-desc' => 'Experimentelle persöönelke [[Special:Todo|Apgoawenlieste]]',
	'todo-tab' => 'Apgoawen',
	'todo-new-queue' => 'Näi',
	'todo-mail-subject' => 'Iendraach foar $1s Apgoawenlieste ousleeten',
	'todo-mail-body' => 'Du hääst uum Beskeed bidded, wan n Apdraach, dän du an $1 uurroat hääst, ousleeten wuude.

Iendraach: $2
Uurroat: $3

Dissen Iendraach wuud mäd dissen Kommentoar as ousleeten markierd:
$4',
	'todo-invalid-item' => 'Failjenden of falsken Iendraach',
	'todo-update-else-item' => 'De fersäkst, do Iendraage fon uurswäl tou beoarbaidjen',
	'todo-unrecognize-type' => 'Uunbekoanden Typ',
	'todo-user-invalide' => 'Die roate Apdraach is uungultich: Benutser failt of häd neen Apgoawenlieste.',
	'todo-item-list' => 'Dien Iendraage',
	'todo-no-item' => 'Neen Apgoawen',
	'todo-invalid-owner' => 'Uungultigen Besitter foar dissen Iendraach',
	'todo-add-queue' => 'Täiweslange bietouföigje ...',
	'todo-move-queue' => 'Ätter Täiweslange ferskuuwe ...',
	'todo-list-for' => 'Apgoawenlieste foar $1',
	'todo-list-change' => 'Annerje',
	'todo-list-cancel' => 'Oubreeke',
	'todo-new-item' => 'Näien Iendraach',
	'todo-issue-summary' => 'Touhoopefoatenge fon dän Apdraach:',
	'todo-form-details' => 'Details:',
	'todo-form-email' => 'Reek dien E-Mail-Adresse ien, uum Beskeed tou kriegen, wan dän Iendraach sleeten wuude:',
	'todo-form-submit' => 'Anfroage uurreeke',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author Lokal Profil
 * @author M.M.S.
 * @author Najami
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
	'todo-list-for' => 'Uppgiftslista för $1',
	'todo-list-change' => 'Ändra',
	'todo-list-cancel' => 'Avbryt',
	'todo-new-item' => 'Ny uppgift',
	'todo-not-updated' => 'Kunde inte uppdatera databaspost',
	'todo-issue-summary' => 'Sammandrag:',
	'todo-form-details' => 'Detaljer:',
	'todo-form-email' => 'Skriv in din e-postadress här för att motta meddelanden på e-post när uppgiften är slutförd:',
	'todo-form-submit' => 'Utför',
	'right-todo' => 'Ha en att göra-lista',
	'right-todosubmit' => 'Begränsa användares att göra-listrättigheter',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'todo' => 'చేయాల్సిన జాబితా',
	'todo-desc' => 'ప్రయోగాత్మక వ్యక్తిగత [[Special:Todo|పనుల జాబితా]] పొడగింత',
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

/** Tajik (Cyrillic script) (Тоҷикӣ)
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

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'todo-new-queue' => 'nav',
	'todo-unrecognize-type' => "Nav'i noşinos",
	'todo-list-change' => 'Taƣjir',
	'todo-list-cancel' => 'Laƣv',
	'todo-new-item' => 'Mavodi çadid',
	'todo-issue-summary' => 'Xulosai amal:',
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
	'todo-list-for' => 'Talaan ng mga gagawin para kay $1',
	'todo-list-change' => 'Baguhin',
	'todo-list-cancel' => 'Huwag ipagpatuloy',
	'todo-new-item' => 'Bagong bagay',
	'todo-not-updated' => 'Hindi maisapanahon ang rekord ng kalipunan ng dato',
	'todo-issue-summary' => 'Ibigay ang buod:',
	'todo-form-details' => 'Mga detalye:',
	'todo-form-email' => 'Upang makatanggap ng pagbibigay-alam sa pamamagitan ng e-liham kung naisara na ang bagay, makinilyahin dito ang adres mo:',
	'todo-form-submit' => 'Ipasa/ipadala ang katanungan',
	'right-todo' => 'May talaan ng mga gagawin',
	'right-todosubmit' => 'Limitahan ang talaan ng karapatan na panggagawin ng tagagamit',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'todo-new-queue' => 'niu',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Manco Capac
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'todo' => 'Yapılacaklar listesi',
	'todo-tab' => 'yapılacaklar',
	'todo-new-queue' => 'yeni',
	'todo-invalid-item' => 'Eksik veya geçersiz öğe',
	'todo-update-else-item' => 'Bir başkasının işlemleri güncellenmeye çalışılıyor',
	'todo-unrecognize-type' => 'Tanımlanamayan tip',
	'todo-item-list' => 'Sizin öğeniz',
	'todo-invalid-owner' => 'Bu öğede geçersiz sahip',
	'todo-add-queue' => 'Kuyruk ekle...',
	'todo-move-queue' => 'Kuyruğa taşındı...',
	'todo-list-for' => '$1 için yapılacaklar listesi',
	'todo-list-change' => 'Değiştir',
	'todo-list-cancel' => 'İptal',
	'todo-new-item' => 'Yeni öğe',
	'todo-form-details' => 'Detaylar:',
	'todo-form-submit' => 'Sorguyu gir',
	'right-todosubmit' => 'Kullanıcının yapılacaklar listesi haklarını kısıtla',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 * @author Тест
 */
$messages['uk'] = array(
	'todo' => 'Список завдань',
	'todo-desc' => 'Експерементальне персональний додаток [[Special:Todo|списку завдань]].',
	'todo-tab' => 'завдання',
	'todo-new-queue' => 'нові',
	'todo-mail-subject' => 'Виконані пункти в списку завдань $1',
	'todo-mail-body' => 'Ви запросили підтвердження по електронній пошті про завершення завдання, переданого до  $1 в онлайн списку завдань.

Завдання: $2 
Відправлено: $3 

Це завдання було відзначене як завершене, з наступним коментарем: 
$4',
	'todo-invalid-item' => 'Відсутнє або недійсне завдання',
	'todo-update-else-item' => 'Спроба оновити чужі завдання',
	'todo-unrecognize-type' => 'Невідомий тип',
	'todo-user-invalide' => 'Завданню призначений відсутній або неуповноважений користувач',
	'todo-item-list' => 'Ваші завдання',
	'todo-no-item' => 'Немає завдань',
	'todo-invalid-owner' => 'Невідомий власник завдання',
	'todo-add-queue' => 'Додати чергу...',
	'todo-move-queue' => 'Перемістити до черги ...',
	'todo-list-for' => 'Список завдань для $1',
	'todo-list-change' => 'Змінити',
	'todo-list-cancel' => 'Скасувати',
	'todo-new-item' => 'Нове завдання',
	'todo-not-updated' => 'Не вдалося оновити запис у базі даних',
	'todo-issue-summary' => 'Підсумок роботи:',
	'todo-form-details' => 'Деталі:',
	'todo-form-email' => 'Щоб отримати сповіщення по електронній пошті, коли це завдання закрите, вкажіть свою адресу:',
	'todo-form-submit' => 'Відправити запит',
	'right-todo' => 'Присутній список завдань',
	'right-todosubmit' => 'Заборона списку завдань користувача',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'todo-list-cancel' => 'منسوخ',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'todo' => 'Radoiden nimikirjutez',
	'todo-tab' => 'radod',
	'todo-new-queue' => "uz'",
	'todo-unrecognize-type' => 'Tundištamatoi tip',
	'todo-list-change' => 'Vajehtada',
	'todo-list-cancel' => 'Heitta pätand',
	'todo-new-item' => "Uz' kirjutez",
	'todo-issue-summary' => 'Lühüd ümbrikirjutamine:',
	'todo-form-details' => 'Detalid:',
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
	'todo-add-queue' => 'Thêm hàng đợi…',
	'todo-move-queue' => 'Chuyển qua hàng đợi…',
	'todo-list-for' => 'Danh sách việc cần làm của $1',
	'todo-list-change' => 'Thay đổi',
	'todo-list-cancel' => 'Hủy bỏ',
	'todo-issue-summary' => 'Tóm lược vấn đề:',
	'todo-form-details' => 'Chi tiết:',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'todo-new-queue' => 'nulik',
	'todo-list-change' => 'Votükön',
	'todo-form-details' => 'Notets:',
	'todo-form-submit' => 'Sedön seividi',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'todo-list-cancel' => '取消',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'todo-form-details' => 'פרטים:',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'todo-new-queue' => '新',
	'todo-list-change' => '更改',
	'todo-list-cancel' => '取消',
	'todo-form-submit' => '递交查询',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'todo-new-queue' => '新',
	'todo-list-change' => '更改',
	'todo-list-cancel' => '取消',
	'todo-form-submit' => '遞交查詢',
);

