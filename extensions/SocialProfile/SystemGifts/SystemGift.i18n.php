<?php
/**
 * Internationalization file for SystemGifts extension.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Wikia, Inc.
 * @author Purodha
 */
$messages['en'] = array(
	'systemgiftmanager' => 'System gifts manager', 
	'ga-addnew' => '+ Add new gift',
	'ga-back-edit-gift' => 'Back to edit this gift',
	'ga-back-gift-list' => 'Back to gift list',
	'ga-back-link' => '<a href="$1">< Back to $2\'s profile</a>',
	'ga-choosefile' => 'Choose file:',
	'ga-count' => '$1 has $2 {{PLURAL:$2|award|awards}}.',
	'ga-create-gift' => 'Create gift',
	'ga-created' => 'The gift has been created',
	'ga-currentimage' => 'Current image',
	'ga-error-message-invalid-link' => 'The link you have entered is invalid.',
	'ga-error-message-no-user' => 'The user you are trying to view does not exist.',
	'ga-error-title' => 'Woops, you took a wrong turn!',
	'ga-file-instructions' => 'Your image must be a jpeg, png or gif (no animated gifs), and must be less than 100kb in size.',
	'ga-gift' => 'gift',
	'ga-gift-given-count' => 'This gift has been given out $1 {{PLURAL:$1|time|times}}',
	'ga-gift-title' => '$1\'s "$2"',
	'ga-giftdesc' => 'gift description',
	'ga-giftimage' => 'gift image',
	'ga-giftname' => 'gift name',
	'ga-gifttype' => 'gift type',
	'ga-goback' => 'Go back',
	'ga-imagesbelow' => 'Below are your images that will be used on the site',
	'ga-img' => 'add/replace image',
	'ga-large' => 'Large',
	'ga-medium' => 'Medium',
	'ga-mediumlarge' => 'Medium-large',
	'ga-new' => 'New',
	'ga-next' => 'Next',
	'ga-previous' => 'Prev',
	'ga-recent-recipients-award' => 'Other recent recipients of this award',
	'ga-saved' => 'The gift has been saved',
	'ga-small' => 'Small',
	'ga-threshold' => 'threshold',
	'ga-title' => '$1\'s awards',
	'ga-uploadsuccess' => 'Upload successful',
	'ga-viewlist' => 'View gift list',
	'system_gift_received_subject' => 'You have received the $1 award on {{SITENAME}}!',
	'system_gift_received_body' => 'Hi $1.

You have just received the $2 award on {{SITENAME}}!

"$3"

Click below to check out your trophy case!

$4

We hope you like it!

Thanks,


The {{SITENAME}} team

---

Hey, want to stop getting emails from us?  

Click $5
and change your settings to disable email notifications.',
	// For Special:ListGroupRights
	'right-awardsmanage' => 'Create new and edit existing awards',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 */
$messages['qqq'] = array(
	'ga-large' => '{{Identical|Large}}',
	'ga-medium' => '{{Identical|Medium}}',
	'ga-new' => '{{Identical|New}}',
	'ga-next' => '{{Identical|Next}}',
	'ga-previous' => '{{Identical|Prev}}',
	'ga-small' => '{{Identical|Small}}',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'systemgiftmanager' => 'مدير هدايا النظام',
	'ga-addnew' => '+ إضافة هدية جديدة',
	'ga-back-edit-gift' => 'رجوع لتعديل هذه الهدية',
	'ga-back-gift-list' => 'رجوع لقائمة الهدايا',
	'ga-back-link' => '<a href="$1">< رجوع إلى ملف $2</a>',
	'ga-choosefile' => 'اختر الملف:',
	'ga-count' => '$1 يمتلك $2 {{PLURAL:$2|جائزة|جائزة}}.',
	'ga-create-gift' => 'إنشاء الهدية',
	'ga-created' => 'الهدية تم إنشاؤها',
	'ga-currentimage' => 'الصورة الحالية',
	'ga-error-message-invalid-link' => 'الوصلة التي أدخلتها غير صحيحة.',
	'ga-error-message-no-user' => 'المستخدم الذي تحاول رؤيته غير موجود.',
	'ga-error-title' => 'آه، أنت أخذت منحنى خاطئا!',
	'ga-file-instructions' => 'صورتك يجب أن تكون jpeg، png أو gif (لا gif فيديو)، ويجب أن تكون أقل من 100 كيلوبت في الحجم.',
	'ga-gift' => 'هدية',
	'ga-gift-given-count' => 'هذه الهدية تم منحها $1 {{PLURAL:$1|مرة|مرة}}',
	'ga-gift-title' => '"$2" الخاصة ب$1',
	'ga-giftdesc' => 'وصف الهدية',
	'ga-giftimage' => 'صورة الهدية',
	'ga-giftname' => 'اسم الهدية',
	'ga-gifttype' => 'نوع الهدية',
	'ga-goback' => 'رجوع',
	'ga-imagesbelow' => 'بالأسفل صورك التي سيتم استخدامها في الموقع',
	'ga-img' => 'أضف/استبدل الصورة',
	'ga-large' => 'كبير',
	'ga-medium' => 'متوسط',
	'ga-mediumlarge' => 'كبير-متوسط',
	'ga-new' => 'جديد',
	'ga-next' => 'تالي',
	'ga-previous' => 'سابق',
	'ga-recent-recipients-award' => 'المتلقون الجدد الآخرون لهذه الهدية',
	'ga-saved' => 'الهدية تم حفظها',
	'ga-small' => 'صغير',
	'ga-threshold' => 'حد',
	'ga-title' => 'جوائز $1',
	'ga-uploadsuccess' => 'الرفع نجح',
	'ga-viewlist' => 'عرض قائمة الهدايا',
	'system_gift_received_subject' => 'أنت تلقيت جائزة $1 في {{SITENAME}}!',
	'system_gift_received_body' => 'مرحبا $1:

أنت تلقيت حالا جائزة $2 في {{SITENAME}}!

"$3"

اضغط بالأسفل للتحقق من صندوق جوائزك!

$4

نأمل أن تعجبك!

شكرا،


فريق {{SITENAME}}

---

ها، تريد أن تتوقف عن تلقي رسائل البريد الإلكتروني منا؟   

اضغط $5
وغير إعداداتك لتعطيل إخطارات البريد الإكتروني.',
	'right-awardsmanage' => 'إنشاء جوائز جديدة وتعديل الموجودة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'systemgiftmanager' => 'مدير هدايا النظام',
	'ga-addnew' => '+ إضافة هدية جديدة',
	'ga-back-edit-gift' => 'رجوع لتعديل هذه الهدية',
	'ga-back-gift-list' => 'رجوع لقائمة الهدايا',
	'ga-back-link' => '<a href="$1">< رجوع إلى ملف $2</a>',
	'ga-choosefile' => 'اختر الملف:',
	'ga-count' => '$1 يمتلك $2 {{PLURAL:$2|جائزة|جائزة}}.',
	'ga-create-gift' => 'إنشاء الهدية',
	'ga-created' => 'الهدية تم إنشاؤها',
	'ga-currentimage' => 'الصورة الحالية',
	'ga-error-message-invalid-link' => 'الوصلة التى أدخلتها غير صحيحة.',
	'ga-error-message-no-user' => 'المستخدم الذى تحاول رؤيته غير موجود.',
	'ga-error-title' => 'آه، أنت أخذت منحنى خاطئا!',
	'ga-file-instructions' => 'صورتك يجب أن تكون jpeg، png أو gif (لا gif فيديو)، ويجب أن تكون أقل من 100 كيلوبت فى الحجم.',
	'ga-gift' => 'هدية',
	'ga-gift-given-count' => 'هذه الهدية تم منحها $1 {{PLURAL:$1|مرة|مرة}}',
	'ga-gift-title' => '"$2" الخاصة ب$1',
	'ga-giftdesc' => 'وصف الهدية',
	'ga-giftimage' => 'صورة الهدية',
	'ga-giftname' => 'اسم الهدية',
	'ga-gifttype' => 'نوع الهدية',
	'ga-goback' => 'رجوع',
	'ga-imagesbelow' => 'بالأسفل صورك التى سيتم استخدامها فى الموقع',
	'ga-img' => 'أضف/استبدل الصورة',
	'ga-large' => 'كبير',
	'ga-medium' => 'متوسط',
	'ga-mediumlarge' => 'كبير-متوسط',
	'ga-new' => 'جديد',
	'ga-next' => 'تالى',
	'ga-previous' => 'سابق',
	'ga-recent-recipients-award' => 'المتلقون الجدد الآخرون لهذه الهدية',
	'ga-saved' => 'الهدية تم حفظها',
	'ga-small' => 'صغير',
	'ga-threshold' => 'حد',
	'ga-title' => 'جوائز $1',
	'ga-uploadsuccess' => 'الرفع نجح',
	'ga-viewlist' => 'عرض قائمة الهدايا',
	'system_gift_received_subject' => 'أنت تلقيت جائزة $1 فى {{SITENAME}}!',
	'system_gift_received_body' => 'مرحبا $1:

أنت تلقيت حالا جائزة $2 فى {{SITENAME}}!

"$3"

اضغط بالأسفل للتحقق من صندوق جوائزك!

$4

نأمل أن تعجبك!

شكرا،


فريق {{SITENAME}}

---

ها، تريد أن تتوقف عن تلقى رسائل البريد الإلكترونى منا؟   

اضغط $5
وغير إعداداتك لتعطيل إخطارات البريد الإكترونى.',
	'right-awardsmanage' => 'إنشاء جوائز جديدة وتعديل الموجودة',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'systemgiftmanager' => 'Сыстэма кіраваньня падарункамі',
	'ga-addnew' => '+ Дадаць новы падарунак',
	'ga-back-edit-gift' => 'Вярнуцца да рэдагаваньня гэтага падарунка',
	'ga-back-gift-list' => 'Вярнуцца да сьпісу падарункаў',
	'ga-back-link' => '<a href="$1">< Вярнуцца да профілю $2</a>',
	'ga-choosefile' => 'Выберыце файл:',
	'ga-count' => '$1 мае $2 {{PLURAL:$2|узнагароду|узнагароды|узнагародаў}}.',
	'ga-create-gift' => 'Стварыць падарунак',
	'ga-created' => 'Падарунак быў створаны',
	'ga-currentimage' => 'Цяперашняя выява',
	'ga-error-message-invalid-link' => 'Спасылка, якую Вы ўвялі — няслушная.',
	'ga-error-message-no-user' => 'Удзельніка, якога Вы спрабуеце праглядзець, не існуе.',
	'ga-error-title' => 'Ой, Вы выбралі няслушны накірунак!',
	'ga-file-instructions' => 'Ваша выява павінна быць у фармаце jpeg, png альбо gif (анімаваныя выявы не дазволеныя) і мець памер меней за 100 кб.',
	'ga-gift' => 'падарунак',
	'ga-gift-given-count' => 'Гэты падарунак быў падараваны $1 {{PLURAL:$1|раз|разы|разоў}}',
	'ga-gift-title' => '«$2» удзельніка $1',
	'ga-giftdesc' => 'апісаньне падарунка',
	'ga-giftimage' => 'выява падарунка',
	'ga-giftname' => 'назва падарунка',
	'ga-gifttype' => 'тып падарунка',
	'ga-goback' => 'Вярнуцца',
	'ga-imagesbelow' => 'Ніжэй знаходзяцца Вашыя выявы, якія будуць выкарыстаныя на сайце',
	'ga-img' => 'дадаць/зьмяніць выяву',
	'ga-large' => 'Вялікая',
	'ga-medium' => 'Сярэдняя',
	'ga-mediumlarge' => 'Сярэдне-вялікая',
	'ga-new' => 'Новая',
	'ga-next' => 'Наступная',
	'ga-previous' => 'Папярэдняя',
	'ga-recent-recipients-award' => 'Іншыя апошнія атрымальнікі гэтай узнагароды',
	'ga-saved' => 'Падарунак быў захаваны',
	'ga-small' => 'Маленькая',
	'ga-threshold' => 'парог',
	'ga-title' => 'Узнагароды $1',
	'ga-uploadsuccess' => 'Пасьпяховая загрузка',
	'ga-viewlist' => 'Паказаць сьпіс падарункаў',
	'system_gift_received_subject' => 'Вы атрымалі ўзнагароду $1 у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Прывітаньне, $1.

Вы толькі што атрымалі ўзнагароду $2 у {{GRAMMAR:месны|{{SITENAME}}}}!

«$3»

Націсьніце ніжэй, каб пабачыць Ваш трафэй!

$4

Мы спадзяемся, што Вам яна спадабаецца!

Дзякуй,


Каманда {{SITENAME}}

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $5 і зьмяніце Вашыя ўстаноўкі, каб спыніць паведамленьні па электроннай пошце.',
	'right-awardsmanage' => 'Стварыць новую і рэдагаваць існуючыя ўзнагароды',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'ga-addnew' => '+ Добавяне на нов подарък',
	'ga-choosefile' => 'Избиране на файл:',
);

/** German (Deutsch)
 * @author Umherirrender
 */
$messages['de'] = array(
	'systemgiftmanager' => 'Systemgeschenke-Verwaltung',
	'ga-addnew' => '+ Neues Geschenk hinzufügen',
	'ga-back-edit-gift' => 'Zurück zur Geschenkbearbeitung',
	'ga-back-gift-list' => 'Zurück zur Geschenkeliste',
	'ga-back-link' => '<a href="$1">< Zurück zum Profil von $2</a>',
	'ga-choosefile' => 'Wähle Datei:',
	'ga-count' => '$1 hat $2 {{PLURAL:$2|Auszeichnung|Auszeichnungen}}.',
	'ga-create-gift' => 'Geschenk erstellen',
	'ga-created' => 'Das Geschenk wurde erstellt',
	'ga-currentimage' => 'Aktuelles Bild',
	'ga-error-message-invalid-link' => 'Der eingegebende Link ist ungültig.',
	'ga-error-message-no-user' => 'Der Benutzer, den du anschauen möchtest, existiert nicht.',
	'ga-error-title' => 'Ops, da ging etwas schief!',
	'ga-file-instructions' => 'Das Bild muss ein „jpeg“, „png“, „gif“ (kein animiertes) sein, und eine Dateigröße kleiner als 100 kb haben.',
	'ga-gift' => 'Geschenk',
	'ga-gift-given-count' => 'Dieses Geschenk wurde {{PLURAL:$1|einmal|$1 mal}} ausgegeben',
	'ga-gift-title' => '„$2“ von $1',
	'ga-giftdesc' => 'Geschenkbeschreibung',
	'ga-giftimage' => 'Geschenkabbildung',
	'ga-giftname' => 'Geschenkname',
	'ga-gifttype' => 'Geschenkart',
	'ga-goback' => 'gehe zurück',
	'ga-imagesbelow' => 'Hier drunter folgen alle Bilder, die auf dieser Seite genutzt werden',
	'ga-img' => 'Bild hinzufügen / entfernen',
	'ga-large' => 'Groß',
	'ga-medium' => 'Mittel',
	'ga-mediumlarge' => 'Mittelgroß',
	'ga-new' => 'Neu',
	'ga-next' => 'Nächste',
	'ga-previous' => 'Vorherige',
	'ga-recent-recipients-award' => 'Andere aktuelle Empfänger dieser Auszeichnung',
	'ga-saved' => 'Das Geschenk wurde gespeichert',
	'ga-small' => 'Schmal',
	'ga-threshold' => 'Schwelle',
	'ga-title' => 'Auszeichnungen von $1',
	'ga-uploadsuccess' => 'Hochladen erfolgreich',
	'ga-viewlist' => 'Geschenkeliste ansehen',
	'system_gift_received_subject' => 'Du hast die $1-Auszeichnung auf {{SITENAME}} erhalten!',
	'system_gift_received_body' => 'Hallo $1,

du hast eben die $2-Auszeichnung auf {{SITENAME}} erhalten!

„$3“

Klicke nachfolgend um deine Trophäe anzusehen!

$4

Wir hoffen, es gefällt dir!

Danke,

Das {{SITENAME}}-Team

---

Du möchtest keine E-Mails von uns erhalten?

Klicke $5
und ändere deine Einstellungen auf deaktivierte E-Mail-Benachrichtigung.',
	'right-awardsmanage' => 'Neue erstellen und bestehende Auszeichnungen bearbeiten',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'ga-error-message-no-user' => 'Der Benutzer, den Sie anschauen möchten, existiert nicht.',
	'system_gift_received_subject' => 'Sie haben die $1-Auszeichnung auf {{SITENAME}} erhalten!',
	'system_gift_received_body' => 'Hallo $1,

Sie haben eben die $2-Auszeichnung auf {{SITENAME}} erhalten!

„$3“

Klicken Sie nachfolgend um Ihre Trophäe anzusehen!

$4

Wir hoffen, es gefällt Ihnen!

Danke,

Das {{SITENAME}}-Team

---

Sie möchten keine E-Mails von uns erhalten?

Klicken Sie $5
und änderen Sie Ihre Einstellungen auf deaktivierte E-Mail-Benachrichtigung.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'systemgiftmanager' => 'Zastojnik systemowych darow',
	'ga-addnew' => '+ Nowy dar pśidaś',
	'ga-back-edit-gift' => 'Slědk k wobźěłanjeju toś togo dara',
	'ga-back-gift-list' => 'Slědk k lisćinje darow',
	'ga-back-link' => '<a href="$1">< Slědk k profiloju wót $2</a>',
	'ga-choosefile' => 'Dataju wubraś:',
	'ga-count' => '$1 ma $2 {{PLURAL:$2|myto|myśe|myta|mytow}}.',
	'ga-create-gift' => 'Dar napóraś',
	'ga-created' => 'Dar jo se napórał.',
	'ga-currentimage' => 'Aktualny wobraz',
	'ga-error-message-invalid-link' => 'Wótkaz, kótaryž sy zapódał, jo njepłaśiwy.',
	'ga-error-message-no-user' => 'Wužywaŕ, kótaregož wopytujoš se woglědaś, njeeksistěrujo.',
	'ga-error-title' => 'Hopla, sy cynił něco wopaki!',
	'ga-file-instructions' => 'Twój wobraz musy typ jpeg, png abo gif (njeaniměerowany) měś a musy mjenjej ako 100 kb wjeliki byś.',
	'ga-gift' => 'dar',
	'ga-gift-given-count' => 'Toś ten dar jo se wudał {{PLURAL:$1|raz|dwójcy|$1 razy|$1 razow}}',
	'ga-gift-title' => '"$2" wót $1',
	'ga-giftdesc' => 'wopisanje dara',
	'ga-giftimage' => 'wobraz dara',
	'ga-giftname' => 'mě dara',
	'ga-gifttype' => 'typ dara',
	'ga-goback' => 'Źi slědk',
	'ga-imagesbelow' => 'Dołojce su twóje wobraze, kótarež wužywaju se na sedle.',
	'ga-img' => 'wobraz pśidaś/wuměniś',
	'ga-large' => 'Wjeliki',
	'ga-medium' => 'Srědny',
	'ga-mediumlarge' => 'Wósrědny',
	'ga-new' => 'Nowy',
	'ga-next' => 'Pśiducy',
	'ga-previous' => 'Pjerwjejšny',
	'ga-recent-recipients-award' => 'Druge aktualne dostawarje toś togo myta',
	'ga-saved' => 'Dar jo se składł.',
	'ga-small' => 'Mały',
	'ga-threshold' => 'prog',
	'ga-title' => 'Myta wót $1',
	'ga-uploadsuccess' => 'Nagraśe wuspěšne',
	'ga-viewlist' => 'Lisćinu darow se woglědaś',
	'system_gift_received_subject' => 'Sy dostał myto $1 na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Witaj $1.

Sy rowno dostał myto $2 na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

"$3"

Klikni dołojce, aby wiźeł swóju trofeju!

$4

Naźejamy se, až se śi spódaba!

Źěkujomy se,


Team {{GRAMMAR:genitiw|{{SITENAME}}}}

---

Njocoš wěcej e-mail wót nas dostaś?

Klikni na $5
a změń nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'right-awardsmanage' => 'Nowe myta napóraś a eksistěrujuce wobźěłaś',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'ga-addnew' => '+ Agregar nuevo regalo',
	'ga-back-edit-gift' => 'Regresar a editar este regalo',
	'ga-back-gift-list' => 'Regresar a la lista de regalos',
	'ga-back-link' => '<a href="$1">< regresar a perfil de $2</a>',
	'ga-choosefile' => 'Escoger archivo:',
	'ga-count' => '$1 tiene $2 {{PLURAL:$2|premio|premios}}.',
	'ga-create-gift' => 'Crear regalo',
	'ga-created' => 'El regalo ha sido creado',
	'ga-currentimage' => 'Imagen actual',
	'ga-error-message-invalid-link' => 'El vínculo que ha ingresado es inválido.',
	'ga-error-message-no-user' => 'El usuario que está tratando de ver no existe',
	'ga-error-title' => 'Woops, usted tomó un turno equivocado!',
	'ga-file-instructions' => 'Tu imagen debe ser un jpeg, png o gif (no gif animado), y debe ser menor que 100kb en tamaño.',
	'ga-gift' => 'regalo',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descripción de regalo',
	'ga-giftimage' => 'imagen de regalo',
	'ga-giftname' => 'nombre de regalo',
	'ga-gifttype' => 'tipo de regalo',
	'ga-goback' => 'Volver',
	'ga-imagesbelow' => 'Debajo están sus imágenes que serán usadas en el sitio',
	'ga-img' => 'agregar/reemplazar imagen',
	'ga-large' => 'Grande',
	'ga-medium' => 'Medio',
	'ga-mediumlarge' => 'Medio-Grande',
	'ga-new' => 'Nuevo',
	'ga-next' => 'Próximo',
	'ga-previous' => 'Anterior',
	'ga-recent-recipients-award' => 'Otros receptores recientes de este premio',
	'ga-saved' => 'El regalo ha sido grabado',
	'ga-small' => 'Pequeño',
	'ga-title' => 'premios de $1',
	'ga-uploadsuccess' => 'Carga exitosa',
	'ga-viewlist' => 'Ver lista de regalos',
	'system_gift_received_subject' => 'Usted ha recibido el premio $1 en {{SITENAME}}!',
	'right-awardsmanage' => 'Crear nuevo y editar premios existentes',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'systemgiftmanager' => 'Järjestelmälahjojen hallinta',
	'ga-addnew' => '+ Lisää uusi lahja',
	'ga-back-edit-gift' => 'Takaisin tämän lahjan muokkaamiseen',
	'ga-back-gift-list' => 'Takaisin lahjalistaan',
	'ga-back-link' => '<a href="$1">< Takaisin käyttäjän $2 profiiliin</a>',
	'ga-choosefile' => 'Valitse tiedosto:',
	'ga-count' => 'Käyttäjällä $1 on $2 {{PLURAL:$2|palkinto|palkintoa}}.',
	'ga-create-gift' => 'Luo lahja',
	'ga-created' => 'Lahja on luotu',
	'ga-currentimage' => 'Tämänhetkinen kuva',
	'ga-error-message-invalid-link' => 'Antamasi linkki on kelvoton.',
	'ga-error-message-no-user' => 'Käyttäjää, jota yrität katsoa, ei ole olemassa.',
	'ga-error-title' => 'Hups, astuit harhaan!',
	'ga-file-instructions' => 'Kuvasi tulee olla jpeg, png tai gif-muotoinen (ei animoituja gif-kuvia) ja sen tulee olla kooltaan alle 100Kb.',
	'ga-gift' => 'lahja',
	'ga-gift-given-count' => 'Tämä lahja on annettu $1 {{PLURAL:$1|kerran|kertaa}}',
	'ga-gift-title' => 'Käyttäjän $1 "$2"',
	'ga-giftdesc' => 'lahjan kuvaus',
	'ga-giftimage' => 'lahjan kuva',
	'ga-giftname' => 'lahjan nimi',
	'ga-gifttype' => 'lahjan tyyppi',
	'ga-goback' => 'Palaa takaisin',
	'ga-imagesbelow' => 'Alapuolella ovat kuvasi, joita käytetään sivustolla',
	'ga-img' => 'lisää/korvaa kuva',
	'ga-large' => 'Suuri',
	'ga-medium' => 'Keskikokoinen',
	'ga-mediumlarge' => 'Keskikokoinen - suuri',
	'ga-new' => 'Uusi',
	'ga-next' => 'Seur.',
	'ga-previous' => 'Edell.',
	'ga-recent-recipients-award' => 'Muut tämän palkinnon tuoreet saajat',
	'ga-saved' => 'Lahja on tallennettu',
	'ga-small' => 'Pieni',
	'ga-threshold' => 'kynnys',
	'ga-title' => 'Käyttäjän $1 palkinnot',
	'ga-uploadsuccess' => 'Tallentaminen onnistui',
	'ga-viewlist' => 'Katso lahjalista',
	'system_gift_received_subject' => 'Olet saanut $1-palkinnon {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'system_gift_received_body' => 'Hei $1:

Olet juuri saanut $2-palkinnon {{GRAMMAR:inessive|{{SITENAME}}}}!

"$3"

Napsauta alapuolella olevaa linkkiä tarkistaaksesi palkintorasiasi!

$4

Toivomme, että pidät siitä!

Kiittäen,


{{GRAMMAR:genitive|{{SITENAME}}}} tiimi

---

Hei, etkö halua enää saada sähköposteja meiltä?

Napsauta $5
ja muuta asetuksiasi poistaaksesi sähköpostitoiminnot käytöstä.',
	'right-awardsmanage' => 'Luoda uusia ja muokata olemassaolevia palkintoja',
);

/** French (Français)
 * @author IAlex
 * @author PieRRoMaN
 * @author Verdy p
 */
$messages['fr'] = array(
	'systemgiftmanager' => 'Système de gestion de cadeaux',
	'ga-addnew' => '+ Ajouter un nouveau cadeau',
	'ga-back-edit-gift' => 'Revenir à la modification de ce cadeau',
	'ga-back-gift-list' => 'Revenir à la liste des cadeaux',
	'ga-back-link' => '<a href="$1">< Revenir au profil de $2</a>',
	'ga-choosefile' => 'Choisir le fichier :',
	'ga-count' => '$1 a {{PLURAL:$2|un prix|$2 prix}}.',
	'ga-create-gift' => 'Créer un cadeau',
	'ga-created' => 'Le cadeau a été créé',
	'ga-currentimage' => 'Image actuelle',
	'ga-error-message-invalid-link' => 'Le lien que vous avez entré est invalide.',
	'ga-error-message-no-user' => "L'utilisateur que vous essayez de voir n'existe pas.",
	'ga-error-title' => 'Oops, vous avez pris un mauvais tour !',
	'ga-file-instructions' => 'Voir image doit être jpeg, png ou gif (mais pas animée) et doit être plus petite que 100 Ko.',
	'ga-gift' => 'cadeau',
	'ga-gift-given-count' => 'Ce cadeau a été donné {{PLURAL:$1|une fois|$1 fois}}',
	'ga-gift-title' => '« $2 » de $1',
	'ga-giftdesc' => 'description du cadeau',
	'ga-giftimage' => 'image du cadeau',
	'ga-giftname' => 'nom du cadeau',
	'ga-gifttype' => 'type de cadeau',
	'ga-goback' => 'Revenir',
	'ga-imagesbelow' => 'Les image qui seront utilisées sur ce site sont affichées ci-dessous',
	'ga-img' => "ajouter / modifier l'image",
	'ga-large' => 'Grand',
	'ga-medium' => 'Moyen',
	'ga-mediumlarge' => 'Moyen-Grand',
	'ga-new' => 'Nouveau',
	'ga-next' => 'Suivant',
	'ga-previous' => 'Précédent',
	'ga-recent-recipients-award' => 'Autres bénéficiaires de ce prix',
	'ga-saved' => 'Ce cadeau a été sauvegardé',
	'ga-small' => 'Petit',
	'ga-threshold' => 'seuil',
	'ga-title' => 'Prix de $1',
	'ga-uploadsuccess' => 'Téléchargement effectué avec succès',
	'ga-viewlist' => 'Voir la liste des cadeaux',
	'system_gift_received_subject' => 'Vous avez reçu le prix $1 sur {{SITENAME}} !',
	'system_gift_received_body' => "Bonjour $1,

Vous avez reçu le prix $2 sur {{SITENAME}} !

« $3 »

Cliquez sur le lien ci-dessous pour voir votre trophée

$4

Nous espérons que l'apprécierez !

Merci,


L'équipe de {{SITENAME}}

---

Vous ne voulez plus recevoir de courriels de notre part ?

Cliquez $5
et modifiez vos préférences pour désactiver les notifications par courriel.",
	'right-awardsmanage' => 'Créer et modifier les prix existants',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'systemgiftmanager' => 'Xestor de agasallos do sistema',
	'ga-addnew' => '+ Engadir un novo agasallo',
	'ga-back-edit-gift' => 'Voltar ao editor de agasallos',
	'ga-back-gift-list' => 'Voltar á lista de agasallos',
	'ga-back-link' => '<a href="$1">< Voltar ao perfil de $2</a>',
	'ga-choosefile' => 'Elixir o ficheiro:',
	'ga-count' => '$1 ten $2 {{PLURAL:$2|premio|premios}}.',
	'ga-create-gift' => 'Crear un agasallo',
	'ga-created' => 'O agasallo foi creado',
	'ga-currentimage' => 'Imaxe actual',
	'ga-error-message-invalid-link' => 'A ligazón que inseriu é inválida.',
	'ga-error-message-no-user' => 'O usuario que está intentando ver non existe.',
	'ga-error-title' => 'Vaites, tomou un xiro erróneo!',
	'ga-file-instructions' => 'A súa imaxe debe ser jpeg, png ou gif (que non sexa animado), e debe ter un tamaño menor a 100kb.',
	'ga-gift' => 'agasallo',
	'ga-gift-given-count' => 'Este agasallo foi concedido {{PLURAL:$1|unha vez|$1 veces}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descrición do agasallo',
	'ga-giftimage' => 'imaxe do agasallo',
	'ga-giftname' => 'nome do agasallo',
	'ga-gifttype' => 'tipo de agasallo',
	'ga-goback' => 'Voltar',
	'ga-imagesbelow' => 'Embaixo están as súas imaxes, que serán usadas no sitio',
	'ga-img' => 'engadir/substituír a imaxe',
	'ga-large' => 'Grande',
	'ga-medium' => 'Mediano',
	'ga-mediumlarge' => 'Mediano-Grande',
	'ga-new' => 'Novo',
	'ga-next' => 'Seguinte',
	'ga-previous' => 'Previo',
	'ga-recent-recipients-award' => 'Outros galardoados recentes con este agasallo',
	'ga-saved' => 'O agasallo foi gardado',
	'ga-small' => 'Pequeno',
	'ga-threshold' => 'límite',
	'ga-title' => 'Premios de $1',
	'ga-uploadsuccess' => 'Carga exitosa',
	'ga-viewlist' => 'Ver a lista dos agasallos',
	'system_gift_received_subject' => 'Recibiu o premio $1 en {{SITENAME}}!',
	'system_gift_received_body' => 'Ola $1:

Acaba de recibir o premio $2 en {{SITENAME}}!

"$3"

Prema embaixo para ver o seu trofeo!

$4

Agardamos que lle guste!

Grazas,


O equipo de {{SITENAME}}

---

Quere deixar de recibir os nosos correos electrónicos?  

Prema $5
e cambie as súas preferencias para desactivar as notificacións por correo electrónico.',
	'right-awardsmanage' => 'Crear novos agasallos e editar os existentes',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'ga-new' => 'Νέα',
	'ga-next' => 'Ἑπομέναι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'systemgiftmanager' => 'Syschtem-Gschänkverwaltig',
	'ga-addnew' => '+ Nej Gschänk zuefiege',
	'ga-back-edit-gift' => 'Zrugg zum Bearbeite vu däm Gschänk',
	'ga-back-gift-list' => 'Zrugg zue dr Gschänklischt',
	'ga-back-link' => '<a href="$1">< Zrugg zum Profil vu $2</a>',
	'ga-choosefile' => 'Wehl e Datei:',
	'ga-count' => '$1 het $2 {{PLURAL:$2|Uuszeichnig|Uuszeichnige}}.',
	'ga-create-gift' => 'Gschänk aalege',
	'ga-created' => 'S Gschänk isch aagleit wore',
	'ga-currentimage' => 'Aktuäll Bild',
	'ga-error-message-invalid-link' => 'S Gleich, wu Du yygee hesch, isch nit giltig.',
	'ga-error-message-no-user' => 'Dr Benutzer, wu Du wetsch aaluege, git s nit.',
	'ga-error-title' => 'Hoppla, do lauft ebis scheps!',
	'ga-file-instructions' => 'S Bild muess e „jpeg“, „png“, „gif“ (kei animiert) syy, un d Dateigreßi muess chleiner syy wie 100 kb.',
	'ga-gift' => 'Gschänk',
	'ga-gift-given-count' => 'Des Gschänk isch scho $1 {{PLURAL:$1|Mol|Mol}} verschänkt wore',
	'ga-gift-title' => '„$2“ vu $1',
	'ga-giftdesc' => 'Bschryybig',
	'ga-giftimage' => 'Bild',
	'ga-giftname' => 'Name',
	'ga-gifttype' => 'Typ',
	'ga-goback' => 'Gang zrugg',
	'ga-imagesbelow' => 'Doo drunter chemme alli Bilder, wu uf däre Syte bruucht wäre',
	'ga-img' => 'Bild dryysetze / useneh',
	'ga-large' => 'Groß',
	'ga-medium' => 'Mittel',
	'ga-mediumlarge' => 'Mittelgroß',
	'ga-new' => 'Nej',
	'ga-next' => 'Negschti',
	'ga-previous' => 'Vorigi',
	'ga-recent-recipients-award' => 'Anderi, wu die Uuszeichnig iberchu hän',
	'ga-saved' => 'S Gschänk isch gspycheret wore',
	'ga-small' => 'Chlei',
	'ga-threshold' => 'Schwelli',
	'ga-title' => 'Uuszeichnige vu $1',
	'ga-uploadsuccess' => 'Erfolgryych uffeglade',
	'ga-viewlist' => 'Gschänklischt bschaue',
	'system_gift_received_subject' => 'Du hesch d $1 Uuszeichnig iberchu uf {{SITENAME}}!',
	'system_gift_received_body' => 'Sali $1:

Du hesch grad d $2 Uuszeichnig iberchu uf {{SITENAME}}!

"$3"

Druck doo go die Uuszeichnig iberpriefe!

$4

Mir hoffe, s gfallt Dir!

Dankschen,


D Lyt vu {{SITENAME}}

---

Ha, Du wetsch gar keini E-Mai meh vun is iberchu?   

Druck $5
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abstelle.',
	'right-awardsmanage' => 'Neji Uuszeichnige aalege un sonigi bearbeite wu s scho het',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'systemgiftmanager' => 'מנהל מתנות המערכת',
	'ga-addnew' => '+ הוספת מתנה חדשה',
	'ga-back-edit-gift' => 'חזרה לעריכת מתנה זו',
	'ga-back-gift-list' => 'חזרה לרשימת המתנות',
	'ga-back-link' => '<a href="$1">< חזרה לפרופיל של $2</a>',
	'ga-choosefile' => 'בחירת קובץ:',
	'ga-count' => 'ל־$1 יש {{PLURAL:$2|פרס אחד|$2 פרסים}}.',
	'ga-create-gift' => 'יצירת מתנה',
	'ga-created' => 'המתנה נוצרה',
	'ga-currentimage' => 'התמונה הנוכחית',
	'ga-error-message-invalid-link' => 'הקישור שכתבתם אינו תקין.',
	'ga-error-message-no-user' => 'המשתמש בו אתם מנסים לצפות אינו קיים.',
	'ga-error-title' => 'אופס, טעות בפנייה!',
	'ga-file-instructions' => 'על תמונתכם להיות מסוג jpeg, מסוג png או מסוג gif (לא מונפש), ועליה להיות קטנה מ־100 קילובייט.',
	'ga-gift' => 'מתנה',
	'ga-gift-given-count' => 'מתנה זו הוענקה {{PLURAL:$1|פעם אחת|$1 פעמים|פעמיים}}',
	'ga-gift-title' => 'ה־"$2" של $1',
	'ga-giftdesc' => 'תיאור המתנה',
	'ga-giftimage' => 'תמונת המתנה',
	'ga-giftname' => 'שם המתנה',
	'ga-gifttype' => 'סוג המתנה',
	'ga-goback' => 'חזרה',
	'ga-imagesbelow' => 'להלן תמונותיכם שתשמשנה אתכם באתר',
	'ga-img' => 'הוספת/החלפת תמונה',
	'ga-large' => 'גדולה',
	'ga-medium' => 'בינונית',
	'ga-mediumlarge' => 'בינונית־גדולה',
	'ga-new' => 'חדש',
	'ga-next' => 'הבא',
	'ga-previous' => 'הקודם',
	'ga-recent-recipients-award' => 'הענקות אחרות של פרס זה לאחרונה',
	'ga-saved' => 'המתנה נשמרה',
	'ga-small' => 'קטנה',
	'ga-threshold' => 'סף',
	'ga-title' => 'הפרסים של $1',
	'ga-uploadsuccess' => 'ההעלאה הושלמה בהצלחה',
	'ga-viewlist' => 'צפייה ברשימת המתנות',
	'system_gift_received_subject' => 'קיבלתם את פרס ה$1 ב{{grammar:תחילית|{{SITENAME}}}}!',
	'system_gift_received_body' => 'היי $1.

הרגע קיבלתם את פרס ה$2 ב{{grammar:תחילית|{{SITENAME}}}}!

"$3"

לחצו להלן כדי לצפות בגביע שקיבלתם!

$4

אנו מקווים שתאהבו אותו!

רב תודות,

צוות {{SITENAME}}

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות בדוא"ל?

לחצו על $5
ושנו את הגדרותיכם לביטול התרעות בדוא"ל',
	'right-awardsmanage' => 'יצירת פרסים חדשים ועריכת פרסים קיימים',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'systemgiftmanager' => 'Zrjadowak systemowych darow',
	'ga-addnew' => '+ Nowy dar přidać',
	'ga-back-edit-gift' => 'Wróćo k wobdźěłanju tutoho dara',
	'ga-back-gift-list' => 'Wróćo k lisćinje darow',
	'ga-back-link' => '<a href="$1">< Wróćo k profilej wot $2</a>',
	'ga-choosefile' => 'Wubjer dataju:',
	'ga-count' => '$1 ma $2 {{PLURAL:$2|myto|myće|myta|mytow}}.',
	'ga-create-gift' => 'Dar wutworić',
	'ga-created' => 'Dar bu wutworjeny.',
	'ga-currentimage' => 'Aktualny wobraz',
	'ga-error-message-invalid-link' => 'Wotkaz, kotryž sy zapodał, je njepłaćiwy.',
	'ga-error-message-no-user' => 'Wužiwar, kotrehož pospytuješ sej wobhladać, njeeksistuje.',
	'ga-error-title' => 'Hopla, sy něšto wopak činił!',
	'ga-file-instructions' => 'Twój wobraz dyrbi typ jpeg, png abo gif (žane animěrowane gif) měć a mjeńši hač 100 kb być.',
	'ga-gift' => 'dar',
	'ga-gift-given-count' => 'Tutón dar bu {{PLURAL:$1|jedyn raz|dwójce|$1 razy|$1 razow}} wudaty',
	'ga-gift-title' => '"$2" wot $1',
	'ga-giftdesc' => 'wopisanje dara',
	'ga-giftimage' => 'wobraz dara',
	'ga-giftname' => 'mjeno dara',
	'ga-gifttype' => 'typ dara',
	'ga-goback' => 'Wróćo',
	'ga-imagesbelow' => 'Deleka su twoje wobrazy, kotrež so na sydle wužiwaja',
	'ga-img' => 'Wobraz přidać/narunać',
	'ga-large' => 'Wulki',
	'ga-medium' => 'Srěni',
	'ga-mediumlarge' => 'Srěnjowulki',
	'ga-new' => 'Nowy',
	'ga-next' => 'Přichodny',
	'ga-previous' => 'Předchadny',
	'ga-recent-recipients-award' => 'Druzy aktualni přijimowarjo tutoho myta',
	'ga-saved' => 'Dar bu składowany',
	'ga-small' => 'Mały',
	'ga-threshold' => 'próh',
	'ga-title' => 'Myta wot $1',
	'ga-uploadsuccess' => 'Nahraće wuspěšne',
	'ga-viewlist' => 'Lisćinu darow sej wobhladać',
	'system_gift_received_subject' => 'Sy myto $1 na {{GRAMMAR:lokatiw|{{SITENAME}}}} dóstał!',
	'system_gift_received_body' => 'Witaj $1.

Sy runje myto $2 na {{GRAMMAR:lokatiw|{{SITENAME}}}} dóstał!

"$3"

Klikń deleka, zo by sej swoju trofeju wobhladał!

$4

Nadźijamy so, zo so ći spodoba!

Dźakujemy so,

Team {{SITENAME}}

---

Hej, hižo nochceš nam e-mejle słać?

Klikń na $5
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'right-awardsmanage' => 'Nowe myta wutworić a eksistowace wobdźěłać',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'systemgiftmanager' => 'Gerente de donos del systema',
	'ga-addnew' => '+ Adder un nove dono',
	'ga-back-edit-gift' => 'Retornar verso Modificar iste dono',
	'ga-back-gift-list' => 'Retornar al lista de donos',
	'ga-back-link' => '<a href="$1">< Retornar al profilo de $2</a>',
	'ga-choosefile' => 'Selige un file:',
	'ga-count' => '$1 ha $2 {{PLURAL:$2|premio|premios}}.',
	'ga-create-gift' => 'Crear un dono',
	'ga-created' => 'Le dono ha essite create',
	'ga-currentimage' => 'Imagine actual',
	'ga-error-message-invalid-link' => 'Le ligamine que tu ha entrate es invalide.',
	'ga-error-message-no-user' => 'Le usator que tu tenta vider non existe.',
	'ga-error-title' => 'Ups, tu ha errate!',
	'ga-file-instructions' => 'Tu imagine debe esser in formato jpeg, png o gif (sin animation), e debe esser minus grande que 100kb.',
	'ga-gift' => 'dono',
	'ga-gift-given-count' => 'Iste dono ha essite date $1 {{PLURAL:$1|vice|vices}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'description del dono',
	'ga-giftimage' => 'imagine del dono',
	'ga-giftname' => 'nomine del dono',
	'ga-gifttype' => 'typo de dono',
	'ga-goback' => 'Retornar',
	'ga-imagesbelow' => 'Infra se trova tu imagines que essera usate in le sito',
	'ga-img' => 'adder/reimplaciar imagine',
	'ga-large' => 'Grande',
	'ga-medium' => 'Medie',
	'ga-mediumlarge' => 'Medie-grande',
	'ga-new' => 'Nove',
	'ga-next' => 'Proxime',
	'ga-previous' => 'Previe',
	'ga-recent-recipients-award' => 'Altere ganiatores recente de iste premio',
	'ga-saved' => 'Le dono ha essite immagazinate',
	'ga-small' => 'Parve',
	'ga-threshold' => 'limine',
	'ga-title' => 'Le premios de $1',
	'ga-uploadsuccess' => 'Cargamento succedite',
	'ga-viewlist' => 'Vider le lista de donos',
	'system_gift_received_subject' => 'Tu ha recipite le premio $1 in {{SITENAME}}!',
	'system_gift_received_body' => 'Salute $1.

Tu ha justo recipite le premio $2 in {{SITENAME}}!

"$3"

Clicca infra pro vider tu armario de tropheos!

$4

Nos spera que isto te place!

Gratias,


Le equipa de {{SITENAME}}

---

Tu non vole reciper plus messages de nos?

Clicca $5
e disactiva in tu preferentias le notificationes per e-mail.',
	'right-awardsmanage' => 'Crear nove premios e modificar existentes',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'systemgiftmanager' => 'システムギフトマネージャー',
	'ga-addnew' => '+ 新しいプレゼントを追加',
	'ga-back-edit-gift' => '戻ってこのプレゼントを編集する',
	'ga-back-gift-list' => 'プレゼントリストへ戻る',
	'ga-back-link' => '<a href="$1">< $2のプロフィールへ戻る</a>',
	'ga-choosefile' => 'ファイルを選ぶ:',
	'ga-count' => '$1 は $2 回表彰されています',
	'ga-create-gift' => 'プレゼントを作成',
	'ga-created' => 'プレゼントは作成されました。',
	'ga-currentimage' => '現在の画像',
	'ga-error-message-invalid-link' => '入力されたリンクは無効です',
	'ga-error-message-no-user' => '表示しようとした利用者は存在しません。',
	'ga-gift' => 'ギフト',
	'ga-giftdesc' => 'プレゼントの説明',
	'ga-giftimage' => 'ギフト画像',
	'ga-giftname' => 'ギフト名',
	'ga-gifttype' => 'ギフトタイプ',
	'ga-goback' => '戻る',
	'ga-img' => '画像を追加もしくは置き換え',
	'ga-large' => '大',
	'ga-medium' => '中',
	'ga-mediumlarge' => '中大',
	'ga-new' => '新規',
	'ga-next' => '次',
	'ga-previous' => '前',
	'ga-saved' => 'プレゼントは保存されました。',
	'ga-small' => '小',
	'ga-threshold' => '閾値',
	'ga-uploadsuccess' => 'アップロード成功',
	'ga-viewlist' => 'プレゼントリストを見る',
	'right-awardsmanage' => '賞の編集・新規作成',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'systemgiftmanager' => 'Jeschenke vum Süstem verwallde',
	'ga-addnew' => '+ Neu Jeschenk dobei donn',
	'ga-back-edit-gift' => 'Jangk retuur un donn dat Jeschengk beärbeide',
	'ga-back-gift-list' => 'Jangk retuur op de Leß met de Jeschengke',
	'ga-back-link' => '<a href="$1">← Jangk retuur noh däm „$2“ singem Profil</a>',
	'ga-choosefile' => 'Sök en Datei uß:',
	'ga-count' => 'Dä Metmaacher „$1“ hät {{PLURAL:$2|eij <span class="plainlinks">gif</span> hann, ävver Belohnung|$2 Belohnunge|keij Belohnung}}.',
	'ga-create-gift' => 'Jeschenk aanlääje',
	'ga-created' => 'Dat Jeschenk es jez aanjelaat',
	'ga-currentimage' => 'Dat aktoälle Beld',
	'ga-error-message-invalid-link' => 'Do häss_enne unjöltijje Lengk enjejovve.',
	'ga-error-message-no-user' => 'Dä Metmaacher jidd_et nit, däm De aanloore wells.',
	'ga-error-title' => 'Och, do es jet donevve jejange!',
	'ga-file-instructions' => 'Ding Beld-Datei moß et Fommaat <code>jpeg</code>, <code>png</code>, odder <span class="plainlinks">gif</span> hann, ävver annimeete <span class="plainlinks">gif</span> donn et nit, un moß ene Dateiömfang fun 100&nbsp;KB odder winnijer han.',
	'ga-gift' => 'Jeschenk',
	'ga-gift-given-count' => 'Dat jeschenk wood {{PLURAL:$1|eijmol|$1 mol|noch nie}} ußjejovve.',
	'ga-gift-title' => 'Däm $1 sing „$2“',
	'ga-giftdesc' => 'Jeschenk beschrieve',
	'ga-giftimage' => 'Beld vun däm Jeschenk',
	'ga-giftname' => 'Name vum Jeschenk',
	'ga-gifttype' => 'Zoot vun jeschenk',
	'ga-goback' => 'Jangk Retuur',
	'ga-imagesbelow' => 'Hee drunger sin Ding Belder, die hee jebruch wäde',
	'ga-img' => 'Beld dobei donn udder ußtuusche',
	'ga-large' => 'Jrooß',
	'ga-medium' => 'Meddel bes kleijn',
	'ga-mediumlarge' => 'Meddel bes jrooß',
	'ga-new' => 'Neu',
	'ga-next' => 'Nächs',
	'ga-previous' => 'Vörije',
	'ga-recent-recipients-award' => 'Andere Metmaacher, die die Belohnung krääje han',
	'ga-saved' => 'Dat Jeschenk es afjeshpeichert',
	'ga-small' => 'Kleijn',
	'ga-threshold' => 'Grenz ov Schwell',
	'ga-title' => 'Dem $1 sing Belohnunge',
	'ga-uploadsuccess' => 'Dat Huhlaade hät jeflupp',
	'ga-viewlist' => 'Leß met Jeschenke aanloore',
	'system_gift_received_subject' => 'Do häs de Belohnung „$1“ op de {{SITENAME}} krääje!',
	'system_gift_received_body' => 'Joden Daach $1,

Op de {{SITENAME}} häs De jrad de Belohung $2 bekumme!

„$3“

Jangl op die Sigg hee, un don Ding Sammlung vun Belohnunge beloore:

$4

Mer hoffe, Do maachs dat!

Mer bedanke uns.

---

Wells de kein e-mail mieh vun uns krijje?

Dann jangk noh $5
un donn en Dinge Ensstellunge de Nohrechte övver e-mail affschallde.',
	'right-awardsmanage' => 'Belohnunge ändere udder neu aanlööje',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'ga-addnew' => '+ Neie Cadeau derbäisetzen',
	'ga-back-edit-gift' => "Zréck fir dëse Cadeau z'änneren",
	'ga-back-gift-list' => "Zréck op d'Lëscht vun de Cadeauen",
	'ga-back-link' => '<a href="$1">< Zréck op dem $2 säi Profil</a>',
	'ga-choosefile' => 'Wielt e Fichier:',
	'ga-create-gift' => 'Cadeau uleeën',
	'ga-created' => 'De Cadeau gouf ugeluecht',
	'ga-currentimage' => 'Aktuellt Bild',
	'ga-error-message-invalid-link' => 'De Link deen Dir uginn hutt ass net valabel.',
	'ga-error-message-no-user' => 'De Benotzer, deen Dir kucke wëllt, gëtt et net.',
	'ga-file-instructions' => 'Är Bild muss e jpeg, png oder gif (keng animéiert Gifen) a muss méi kleng si wéi 100 kb.',
	'ga-gift' => 'Cadeau',
	'ga-giftdesc' => 'Bechreiwung vum Cadeau',
	'ga-giftimage' => 'Bild vum Cadeau',
	'ga-giftname' => 'Numm vum Cadeau',
	'ga-gifttype' => 'Typ vu Cadeau',
	'ga-goback' => 'Zréckgoen',
	'ga-imagesbelow' => 'Hei ënnedrënner sinn Är Biller déi um Site benotzt werte ginn',
	'ga-img' => 'Bild derbäisetzen/ersetzen',
	'ga-large' => 'Grouss',
	'ga-medium' => 'Mëttel',
	'ga-new' => 'Nei',
	'ga-next' => 'Nächst',
	'ga-previous' => 'Vireg',
	'ga-saved' => 'De Cadeau gouf gespäichert',
	'ga-small' => 'Kleng',
	'ga-uploadsuccess' => 'Eroplueden ofgeschloss',
	'ga-viewlist' => 'Lëscht vun de Cadeaue kucken',
);

/** Dutch (Nederlands)
 * @author GerardM
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'systemgiftmanager' => 'Giftenbeheer van systeem',
	'ga-addnew' => '+ Nieuwe gift toevoegen',
	'ga-back-edit-gift' => 'Terug naar gift bewerken',
	'ga-back-gift-list' => 'Terug naar giftenlijst',
	'ga-back-link' => '<a href="$1">< Terug naar het profiel van $2</a>',
	'ga-choosefile' => 'Bestand kiezen:',
	'ga-count' => '$1 heeft $2 {{PLURAL:$2|prijs|prijzen}}.',
	'ga-create-gift' => 'Gift aanmaken',
	'ga-created' => 'De gift is aangemaakt',
	'ga-currentimage' => 'Huidige afbeelding',
	'ga-error-message-invalid-link' => 'De verwijzing die u ingevoerd heeft is onjuist.',
	'ga-error-message-no-user' => 'De gebruiker die u wilt bekijken bestaat niet.',
	'ga-error-title' => 'Oeps, er ging iets fout!',
	'ga-file-instructions' => 'Uw afbeelding moet een JPEG-, PNG- of GIF-bestand (niet geanimeerd) zijn en dient minder dan 100 KB in grootte te zijn.',
	'ga-gift' => 'gift',
	'ga-gift-given-count' => 'Deze gift is $1 {{PLURAL:$1|keer|keren}} gegeven',
	'ga-gift-title' => '"$2" van $1',
	'ga-giftdesc' => 'giftomschrijving',
	'ga-giftimage' => 'giftafbeelding',
	'ga-giftname' => 'giftnaam',
	'ga-gifttype' => 'gifttype',
	'ga-goback' => 'Teruggaan',
	'ga-imagesbelow' => 'Hieronder volgen de afbeeldingen die gebruikt gaan worden op de site',
	'ga-img' => 'afbeelding toevoegen/vervangen',
	'ga-large' => 'Groot',
	'ga-medium' => 'Middelmatig',
	'ga-mediumlarge' => 'Middelgroot',
	'ga-new' => 'Nieuw',
	'ga-next' => 'Volgende',
	'ga-previous' => 'Vorige',
	'ga-recent-recipients-award' => 'Andere recente ontvangers van deze prijs',
	'ga-saved' => 'De gift is opgeslagen',
	'ga-small' => 'Klein',
	'ga-threshold' => 'drempel',
	'ga-title' => 'Prijzen van $1',
	'ga-uploadsuccess' => 'Uploaden voltooid',
	'ga-viewlist' => 'Giftenlijst weergeven',
	'system_gift_received_subject' => 'U hebt de $1-prijs gekregen op {{SITENAME}}!',
	'system_gift_received_body' => 'Hallo $1,

U hebt zojuist de $2-prijs op {{SITENAME}} gekregen!

"$3"

Klik op de verwijzing hieronder om uw prijzenkast te bekijken!

$4

We hopen dat u er blij mee bent!

Bedankt,


Het {{SITENAME}}-team

---

Wilt u geen e-mails meer van ons ontvangen?   

Klik op $5
en wijzig uw instellingen om e-mailwaarschuwingen uit te schakelen.',
	'right-awardsmanage' => 'Nieuwe prijzen aanmaken en bestaande prijzen bewerken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'systemgiftmanager' => 'Systemgåvehandsamar',
	'ga-addnew' => '+ legg til ei ny gåva',
	'ga-back-edit-gift' => 'Attende til endring av gåva',
	'ga-back-gift-list' => 'Attende til gåvelista',
	'ga-back-link' => '<a href="$1">< attende til profilen til $2</a>',
	'ga-choosefile' => 'Vel fil:',
	'ga-count' => '$1 har {{PLURAL:$2|éi utmerking|$2 utmerkingar}}.',
	'ga-create-gift' => 'Opprett gåva',
	'ga-created' => 'Gåva vart oppretta',
	'ga-currentimage' => 'Noverande bilete',
	'ga-error-message-invalid-link' => 'Lenkja du oppgav er ugyldig.',
	'ga-error-message-no-user' => 'Brukaren du ynskjer å sjå finst ikkje.',
	'ga-error-title' => 'Oi, du svingte feil!',
	'ga-file-instructions' => 'Biletet ditt lyt vera eit jpeg, png eller gif (ingen animerte gif-filer) og ha ein storleik på mindre enn 100 kb.',
	'ga-gift' => 'gåva',
	'ga-gift-given-count' => 'Denne gåva har vorten gjeven {{PLURAL:$1|éin gong|$1 gonger}}',
	'ga-gift-title' => '$2 til $1',
	'ga-giftdesc' => 'gåveskildring',
	'ga-giftimage' => 'gåvebilete',
	'ga-giftname' => 'gåvenamn',
	'ga-gifttype' => 'gåvetype',
	'ga-goback' => 'Attende',
	'ga-imagesbelow' => 'Nedanfor er bileta dine som vil verta nytta på sida',
	'ga-img' => 'legg til/erstatt bilete',
	'ga-large' => 'Stort',
	'ga-medium' => 'Medels',
	'ga-mediumlarge' => 'Medelsstort',
	'ga-new' => 'Ny',
	'ga-next' => 'Neste',
	'ga-previous' => 'Førre',
	'ga-recent-recipients-award' => 'Andre som nyleg mottok denne utmerkinga',
	'ga-saved' => 'Gåva har vorten lagra',
	'ga-small' => 'Lite',
	'ga-threshold' => 'terskel',
	'ga-title' => 'utmerkingane til $1',
	'ga-uploadsuccess' => 'Opplasting lukkast',
	'ga-viewlist' => 'Sjå gåvelista',
	'system_gift_received_subject' => 'Du har motteke utmerkinga $1 på {{SITENAME}}!',
	'system_gift_received_body' => 'Hei $1:

Du har nett motteke $2-utmerkinga på {{SITENAME}}!   

«$3»

Trykk nedanfor for å sjå trofeet ditt!

$4

Me håpar du vil lika det!

Takk,


{{SITENAME}}-laget

----

Vil du ikkje lenger motta e-postar frå oss?

Trykk $5
og endra innstillingane dine for å slå av e-postmeldingar.',
	'right-awardsmanage' => 'Opprett nye og endra eksisterande utmerkingar',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'systemgiftmanager' => 'Sistèma de gestion de presents',
	'ga-addnew' => '+ Apondre un present novèl',
	'ga-back-edit-gift' => "Tornar a la modificacion d'aqueste present",
	'ga-back-gift-list' => 'Tornar a la lista dels presents',
	'ga-back-link' => '<a href="$1">< Tornar al perfil de $2</a>',
	'ga-choosefile' => 'Causir lo fichièr :',
	'ga-count' => '$1 a $2 {{PLURAL:$2|prèmi|prèmis}}.',
	'ga-create-gift' => 'Crear un present',
	'ga-created' => 'Lo present es estat creat',
	'ga-currentimage' => 'Imatge actual',
	'ga-error-message-invalid-link' => "Lo ligam qu'avètz picat es invalid.",
	'ga-error-message-no-user' => "L'utilizaire qu'ensajatz de veire existís pas.",
	'ga-error-title' => 'Ops, avètz pres un marrit torn !',
	'ga-file-instructions' => 'Vòstre imatge deu èsser en jpeg, png o gif (mas pas animat) e deu èsser mai pichona que 100 Ko.',
	'ga-gift' => 'present',
	'ga-gift-given-count' => 'Aqueste present es estat balhat $1 {{PLURAL:$1|còp|còps}}',
	'ga-gift-title' => '« $2 » de $1',
	'ga-giftdesc' => 'descripcion del present',
	'ga-giftimage' => 'imatge del present',
	'ga-giftname' => 'nom del present',
	'ga-gifttype' => 'tipe del present',
	'ga-goback' => 'Tornar',
	'ga-imagesbelow' => 'Los imatges que seràn utilizats sus aquel sit son afichats çaijós',
	'ga-img' => "apondre / modificar l'imatge",
	'ga-large' => 'Grand',
	'ga-medium' => 'Mejan',
	'ga-mediumlarge' => 'Mejan-Grand',
	'ga-new' => 'Novèl',
	'ga-next' => 'Seguent',
	'ga-previous' => 'Precedent',
	'ga-recent-recipients-award' => "Autres beneficiaris d'aquel prèmi",
	'ga-saved' => 'Aquel present es estat salvat',
	'ga-small' => 'Pichon',
	'ga-threshold' => 'sulhet',
	'ga-title' => 'Prèmi de $1',
	'ga-uploadsuccess' => 'Telecargament efectuat amb succès',
	'ga-viewlist' => 'Vejatz la lista dels presents',
	'system_gift_received_subject' => 'Avètz recebut lo prèmi $1 sus {{SITENAME}} !',
	'system_gift_received_body' => "Bonjorn $1,

Avètz recebut lo prèmi $2 sus {{SITENAME}} !

« $3 »

Clicatz sul ligam çaijós per veire vòstre trofèu

$4

Esperam que vos agradarà !

Mercés,


L'equipa de {{SITENAME}}

---

Volètz pas recebre mai de corrièrs electronics de nòstra part ?

Clicatz $5
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.",
	'right-awardsmanage' => 'Crear de prèmis novèls e modificar los prèmis existents',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'systemgiftmanager' => 'System zarządzania prezentami',
	'ga-addnew' => '+ Dodaj nowy prezent',
	'ga-back-edit-gift' => 'Powrót do edycji tego prezentu',
	'ga-back-gift-list' => 'Powrót do listy prezentów',
	'ga-back-link' => '<a href="$1">< Powrót do profilu $2</a>',
	'ga-choosefile' => 'Wybierz plik',
	'ga-count' => '$1 dostał $2 {{PLURAL:$2|nagrodę|nagrody|nagród}}.',
	'ga-create-gift' => 'Utwórz prezent',
	'ga-created' => 'Prezent został utworzony',
	'ga-currentimage' => 'Obecna grafika',
	'ga-error-message-invalid-link' => 'Wprowadzone łącze jest nieprawidłowe.',
	'ga-error-message-no-user' => 'Użytkownik, którego próbujesz wyświetlić nie istnieje.',
	'ga-error-title' => 'Ojej, chciałeś wykonać nieprawidłową operację!',
	'ga-file-instructions' => 'Grafika musi być w formacie jpeg, png lub gif (bez animacji) i musi być mniejsza niż 100kb.',
	'ga-gift' => 'prezent',
	'ga-gift-given-count' => 'Ten prezent został podrowany $1 dolar {{PLURAL:$1|raz|razy}}',
	'ga-gift-title' => '$1 – „$2”',
	'ga-giftdesc' => 'opis prezentu',
	'ga-giftimage' => 'grafika prezentu',
	'ga-giftname' => 'nazwa prezentu',
	'ga-gifttype' => 'rodzaj prezentu',
	'ga-goback' => 'Wróć',
	'ga-imagesbelow' => 'Poniżej znajdują się grafiki, które zostaną wykorzystane',
	'ga-img' => 'dodaj lub wymień grafikę',
	'ga-large' => 'Duży',
	'ga-medium' => 'Średni',
	'ga-mediumlarge' => 'Średnio‐duży',
	'ga-new' => 'Nowy',
	'ga-next' => 'Następny',
	'ga-previous' => 'Poprzedni',
	'ga-recent-recipients-award' => 'Inni, którzy ostatnio otrzymali tę nagrodę',
	'ga-saved' => 'Prezent został zapisany',
	'ga-small' => 'Nieduża',
	'ga-threshold' => 'próg',
	'ga-title' => 'nagrody $1',
	'ga-uploadsuccess' => 'Przesłano',
	'ga-viewlist' => 'Zobacz listę prezentu',
	'system_gift_received_subject' => 'Dostałeś nagrodę $1 na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'right-awardsmanage' => 'Tworzenie nowych oraz edytowanie istniejących nagród',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'ga-addnew' => '+ نوې ډالۍ ورګډول',
	'ga-choosefile' => 'دوتنه ټاکل:',
	'ga-create-gift' => 'ډالۍ جوړول',
	'ga-created' => 'ډالۍ مو جوړه شوه',
	'ga-gift' => 'ډالۍ',
	'ga-giftimage' => 'د ډالۍ انځور',
	'ga-giftname' => 'د ډالۍ نوم',
	'ga-new' => 'نوی',
	'ga-saved' => 'ډالۍ مو خوندي شوه',
	'ga-viewlist' => 'د ډاليو لړليک کتل',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Vanessa Sabino
 * @author Waldir
 */
$messages['pt'] = array(
	'systemgiftmanager' => 'Gerenciador do Sistema de Presentes',
	'ga-addnew' => '+ Adicionar Novo Presente',
	'ga-back-edit-gift' => 'Voltar para Editar Este Presente',
	'ga-back-gift-list' => 'Voltar para Lista de Presentes',
	'ga-back-link' => '<a href="$1">< Voltar para Perfil de $2</a>',
	'ga-choosefile' => 'Escolher Arquivo:',
	'ga-count' => '$1 tem $2 {{PLURAL:$2|prêmio|prêmios}}.',
	'ga-create-gift' => 'Criar presente',
	'ga-created' => 'O presente foi criado',
	'ga-currentimage' => 'Imagem Atual',
	'ga-error-message-invalid-link' => 'O link que você colocou é inválido.',
	'ga-error-message-no-user' => 'O utilizador que você está tentando ver não existe.',
	'ga-error-title' => 'Ops, você entrou no lugar errado!',
	'ga-file-instructions' => 'Sua imagem precisa ser um jpeg, png or gif (sem gifs animados), e precisa ter tamanho menor que 100kb.',
	'ga-gift' => 'presente',
	'ga-gift-given-count' => 'Este presente foi dado a $1 {{PLURAL:$1|vez|vezes}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descrição do presente',
	'ga-giftimage' => 'imagem do presente',
	'ga-giftname' => 'nome do presente',
	'ga-gifttype' => 'tipo do presente',
	'ga-goback' => 'Voltar',
	'ga-imagesbelow' => 'Abaixo estão suas imagens que serão usadas no site',
	'ga-img' => 'adicionar/substituir imagem',
	'ga-large' => 'Grande',
	'ga-medium' => 'Médio',
	'ga-mediumlarge' => 'Médio/Grande',
	'ga-new' => 'Novo',
	'ga-next' => 'Próximo',
	'ga-previous' => 'Anterior',
	'ga-recent-recipients-award' => 'Outros ganhadores recentes deste prêmio',
	'ga-saved' => 'Este presente foi salvo',
	'ga-small' => 'Pequeno',
	'ga-threshold' => 'threshold',
	'ga-title' => 'Presentes de $1',
	'ga-uploadsuccess' => 'Upload bem sucedido',
	'ga-viewlist' => 'Ver Lista de Presentes',
	'system_gift_received_subject' => 'Você recebeu o prêmio $1 em {{SITENAME}}!',
	'system_gift_received_body' => 'Oi $1:

Você acaba de receber o prêmio $2 em {{SITENAME}}!

"$3"

Clique abaixo para ver sua estante de troféis!

$4

Esperamos que tenha gostado!

Obrigado,


O Time de {{SITENAME}}

---

Ei, quer parer de receber e-mails de nós?

Clique $5
e altere suas preferências para desabilitar e-mails de notificação.',
	'right-awardsmanage' => 'Crie novos e edite galardões existentes',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'systemgiftmanager' => 'Gerenciador do Sistema de Presentes',
	'ga-addnew' => '+ Adicionar Novo Presente',
	'ga-back-edit-gift' => 'Voltar para Editar Este Presente',
	'ga-back-gift-list' => 'Voltar para Lista de Presentes',
	'ga-back-link' => '<a href="$1">< Voltar para Perfil de $2</a>',
	'ga-choosefile' => 'Escolher arquivo:',
	'ga-count' => '$1 tem $2 {{PLURAL:$2|prêmio|prêmios}}.',
	'ga-create-gift' => 'Criar presente',
	'ga-created' => 'O presente foi criado',
	'ga-currentimage' => 'Imagem atual',
	'ga-error-message-invalid-link' => 'A ligação que você colocou é inválida.',
	'ga-error-message-no-user' => 'O utilizador que você está tentando ver não existe.',
	'ga-error-title' => 'Ops, você entrou no lugar errado!',
	'ga-file-instructions' => 'Sua imagem precisa ser um jpeg, png ou gif (sem gifs animados), e precisa ter tamanho menor que 100kb.',
	'ga-gift' => 'presente',
	'ga-gift-given-count' => 'Este presente foi dado $1 {{PLURAL:$1|vez|vezes}}',
	'ga-gift-title' => '"$2" de $1',
	'ga-giftdesc' => 'descrição do presente',
	'ga-giftimage' => 'imagem do presente',
	'ga-giftname' => 'nome do presente',
	'ga-gifttype' => 'tipo do presente',
	'ga-goback' => 'Voltar',
	'ga-imagesbelow' => 'Abaixo estão suas imagens que serão usadas no sítio',
	'ga-img' => 'adicionar/substituir imagem',
	'ga-large' => 'Grande',
	'ga-medium' => 'Médio',
	'ga-mediumlarge' => 'Médio/Grande',
	'ga-new' => 'Novo',
	'ga-next' => 'Próximo',
	'ga-previous' => 'Anterior',
	'ga-recent-recipients-award' => 'Outros ganhadores recentes deste prêmio',
	'ga-saved' => 'Este presente foi salvo',
	'ga-small' => 'Pequeno',
	'ga-threshold' => 'threshold',
	'ga-title' => 'Prêmios de $1',
	'ga-uploadsuccess' => 'Carregamento bem sucedido',
	'ga-viewlist' => 'Ver Lista de Presentes',
	'system_gift_received_subject' => 'Você recebeu o prêmio $1 em {{SITENAME}}!',
	'system_gift_received_body' => 'Oi $1:

Você acaba de receber o prêmio $2 em {{SITENAME}}!

"$3"

Clique abaixo para ver sua estante de troféis!

$4

Esperamos que tenha gostado!

Obrigado,


O Time de {{SITENAME}}

---

Ei, quer parer de receber e-mails de nós?

Clique $5
e altere suas preferências para desabilitar e-mails de notificação.',
	'right-awardsmanage' => 'Crie novos e edite prêmios existentes',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'systemgiftmanager' => 'Systémový správca darčekov',
	'ga-addnew' => '+ Pridať nový darček',
	'ga-back-edit-gift' => 'Späť na Upraviť tento darček',
	'ga-back-gift-list' => 'Späť na zoznam darčekov',
	'ga-back-link' => '<a href="$1">< Späť na profil $2</a>',
	'ga-choosefile' => 'Vybrať súbor:',
	'ga-count' => '$1 má $2 {{PLURAL:$2|ocenenie|ocenenia|ocenení}}.',
	'ga-create-gift' => 'Vytvoriť darček',
	'ga-created' => 'Darček bol vytvorený',
	'ga-currentimage' => 'Aktuálny obrázok',
	'ga-error-message-invalid-link' => 'Odkaz, ktorý ste zadali je neplatný.',
	'ga-error-message-no-user' => 'Používateľ, ktorého sa snažíte zobraziť, neexistuje.',
	'ga-error-title' => 'Ops, niečo ste spravili zle!',
	'ga-file-instructions' => 'Váš obrázok musí byť jpeg, png alebo gif (nie animovaný gif) a musí mať veľkosť menšiu ako 100 kb.',
	'ga-gift' => 'darček',
	'ga-gift-given-count' => 'Tento darček bol darovaný {{PLURAL:$1|jedenkrát|$1-krát}}',
	'ga-gift-title' => '„$2“ používateľa $1',
	'ga-giftdesc' => 'popis darčeka',
	'ga-giftimage' => 'obrázok darčeka',
	'ga-giftname' => 'názov darčeka',
	'ga-gifttype' => 'typ darčeka',
	'ga-goback' => 'Vrátiť sa späť',
	'ga-imagesbelow' => 'Dolu je zoznam vašich obrázkov, ktoré sa použijú na stránke',
	'ga-img' => 'pridať/nahradiť obrázok',
	'ga-large' => 'Veľký',
	'ga-medium' => 'Stredný',
	'ga-mediumlarge' => 'Stredne veľký',
	'ga-new' => 'Nový',
	'ga-next' => 'Ďalší',
	'ga-previous' => 'Predošlý',
	'ga-recent-recipients-award' => 'Ďalší, ktorí nedávno dostali toto ocenenie',
	'ga-saved' => 'Darček bol uložený',
	'ga-small' => 'Malý',
	'ga-threshold' => 'hraničná hodnota',
	'ga-title' => 'Ocenenia používateľa $1',
	'ga-uploadsuccess' => 'Nahrávanie prebehlo úspešne',
	'ga-viewlist' => 'Zobraziť zoznam darčekov',
	'system_gift_received_subject' => 'Dostali ste ocenenie $1 na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'system_gift_received_body' => 'Ahoj $1:

Práve ste dostali ocenenie $2 na {{GRAMMAR:lokál|{{SITENAME}}}}

„$3“

Chcete si pozrieť svoje ocenenie? Kliknite na nasledovný odkaz:

$4

Dúfame, že sa vám bude páčiť!

Vďaka,


Tím {{GRAMMAR:genitív|{{SITENAME}}}}

---

Neželáte si od nás dostávať emaily?

Kliknite na $5
a zmeňte svoje nastavenia týkajúce sa upozornení emailom.',
	'right-awardsmanage' => 'Vytvárať nové alebo upravovať existujúce ocenenia',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'ga-giftdesc' => 'బహుమతి వివరణ',
	'ga-giftname' => 'బహుమతి పేరు',
	'ga-gifttype' => 'బహుమతి రకం',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'systemgiftmanager' => 'Tagapamahala ng Sistema ng mga Handog',
	'ga-addnew' => '+ Magdagdag ng Bagong Handog',
	'ga-back-edit-gift' => 'Bumalik sa Baguhin ang Handog na Ito',
	'ga-back-gift-list' => 'Bumalik sa Talaan ng Handog',
	'ga-back-link' => '<a href="$1">< Bumalik sa Talaan ng Katangian ni $2</a>',
	'ga-choosefile' => 'Pumili ng Talaksan:',
	'ga-count' => 'Si $1 ay may $2 {{PLURAL:$2|gantimpala|mga gantimpala}}.',
	'ga-create-gift' => 'Lumikha ng handog',
	'ga-created' => 'Nalikha na ang handog',
	'ga-currentimage' => 'Kasalukuyang larawan',
	'ga-error-message-invalid-link' => 'Hindi tanggap ang ipinasok mong kawing.',
	'ga-error-message-no-user' => 'Hindi umiiral ang tagagamit na sinusubukan mong tingnan.',
	'ga-error-title' => "Ay 'sus, nagkamali ka sa pagliko!",
	'ga-file-instructions' => 'Dapat na isang jpeg, png o gif ang larawan mo (walang gumagalaw na mga gif), at dapat na mas mababa kaysa 100 mga kb ang sukat.',
	'ga-gift' => 'handog',
	'ga-gift-given-count' => 'Naipamigay na ng $1 {{PLURAL:$1|ulit|mga ulit}} ang handog na ito',
	'ga-gift-title' => '"$2" ni $1',
	'ga-giftdesc' => 'paglalarawan ng handog',
	'ga-giftimage' => 'larawan ng handog',
	'ga-giftname' => 'pangalan ng handog',
	'ga-gifttype' => 'uri ng handog',
	'ga-goback' => 'Magbalik',
	'ga-imagesbelow' => 'Nasa ibaba ang iyong mga larawang gagamitin sa sityo',
	'ga-img' => 'idagdag/palitan ang larawan',
	'ga-large' => 'Malaki',
	'ga-medium' => 'Gitnang sukat',
	'ga-mediumlarge' => 'Gitnang Sukat-Malaki',
	'ga-new' => 'Bago',
	'ga-next' => 'Susunod',
	'ga-previous' => 'Dati',
	'ga-recent-recipients-award' => 'Iba pang kamakailang mga nakatanggap ng gantimpalang ito',
	'ga-saved' => 'Nasagip na ang handog',
	'ga-small' => 'Maliit',
	'ga-threshold' => 'katindihan/abot ng saklaw',
	'ga-title' => 'Mga Gantimpala ni $1',
	'ga-uploadsuccess' => 'Tagumpay sa Pagkarga',
	'ga-viewlist' => 'Tingnan ang Talaan ng Handog',
	'system_gift_received_subject' => 'Natanggap mo ang gantimpalang $1 sa {{SITENAME}}!',
	'system_gift_received_body' => 'Kumusta ka $1:

Katatanggap mo pa lang ng gantimpalang $2 sa {{SITENAME}}!

"$3"

Pindutin sa ibaba upang suriin ang lalagyan mo ng tropeo!

$4

Sana ay magustuhan mo ito!

Salamat,


Ang Pangkat ng {{SITENAME}}

---

Hoy, nais mo bang huminto na ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $5
at baguhin ang mga pagtatakda mo upang huwag nang paganahin ang mga pagpapabatid sa pamamagitan ng e-liham.',
	'right-awardsmanage' => 'Lumikha ng bago at baguhin ang umiiral na mga gantimpala',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'ga-large' => 'Büyük',
	'ga-new' => 'Yeni',
	'ga-next' => 'Sonraki',
	'ga-small' => 'Küçük',
);

