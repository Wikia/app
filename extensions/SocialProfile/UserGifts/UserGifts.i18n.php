<?php
/**
 * Internationalization file for the UserGifts extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Wikia, Inc.
 * @author Purodha
 */
$messages['en'] = array(
	'giftmanager' => 'Gifts manager',
	'giftmanager-addgift' => '+ Add new gift',
	'giftmanager-access' => 'gift access',
	'giftmanager-description' => 'gift description',
	'giftmanager-giftimage' => 'gift image',
	'giftmanager-image' => 'add/replace image',
	'giftmanager-giftcreated' => 'The gift has been created',
	'giftmanager-giftsaved' => 'The gift has been saved',
	'giftmanager-public' => 'public',
	'giftmanager-private' => 'private',
	'giftmanager-view' => 'View gift list',
	'g-add-message' => 'Add a message',
	'g-back-edit-gift' => 'Back to edit this gift',
	'g-back-gift-list' => 'Back to gift list',
	'g-back-link' => '< Back to $1\'s page',
	'g-choose-file' => 'Choose file:',
	'g-cancel' => 'Cancel',
	'g-count' => '$1 has $2 {{PLURAL:$2|gift|gifts}}.',
	'g-create-gift' => 'Create gift',
	'g-created-by' => 'created by', # this message supports {{GENDER}}
	'g-current-image' => 'Current image',
	'g-delete-message' => 'Are you sure you want to delete the gift "$1"?
This will also delete it from users who may have received it.',
	'g-description-title' => '$1\'s gift "$2"', # This message supports {{GENDER}}
	'g-error-do-not-own' => 'You do not own this gift.',
	'g-error-message-blocked' => 'You are currently blocked and cannot give gifts',
	'g-error-message-invalid-link' => 'The link you have entered is invalid.',
	'g-error-message-login' => 'You must log-in to give gifts',
	'g-error-message-no-user' => 'The user you are trying to view does not exist.',
	'g-error-message-to-yourself' => 'You cannot give a gift to yourself.',
	'g-error-title' => 'Woops, you took a wrong turn!',
	'g-file-instructions' => 'Your image must be a jpeg, png or gif (no animated gifs), and must be less than 100kb in size.',
	'g-from' => 'from <a href="$1">$2</a>',
	'g-gift' => 'gift',
	'g-gift-name' => 'gift name',
	'g-give-gift' => 'Give gift',
	'g-give-all' => 'Want to give $1 a gift?
Just click one of the gifts below and click "Send gift".
It is that easy.',
	'g-give-all-message-title' => 'Add a message',
	'g-give-all-title' => 'Give a gift to $1',
	'g-give-enter-friend-title' => 'If you know the name of the user, type it in below',
	'g-given' => 'This gift has been given out $1 {{PLURAL:$1|time|times}}',
	'g-give-list-friends-title' => 'Select from your list of friends',
	'g-give-list-select' => 'select a friend',
	'g-give-separator' => 'or',
	'g-give-no-user-message' => 'Gifts and awards are a great way to acknowledge your friends!',
	'g-give-no-user-title' => 'Who would you like to give a gift to?',
	'g-give-to-user-title' => 'Send the gift "$1" to $2',
	'g-give-to-user-message' => 'Want to give $1 a <a href="$2">different gift</a>?',
	'g-go-back' => 'Go back',
	'g-imagesbelow' => 'Below are your images that will be used on the site',
	'g-large' => 'Large',
	'g-list-title' => '$1\'s gift list',
	'g-main-page' => 'Main page',
	'g-medium' => 'Medium',
	'g-mediumlarge' => 'Medium-large',
	'g-new' => 'new',
	'g-next' => 'Next',
	'g-previous' => 'Prev',
	'g-remove' => 'Remove',
	'g-remove-gift' => 'Remove this gift',
	'g-remove-message' => 'Are you sure you want to remove the gift "$1"?',
	'g-recent-recipients' => 'Other recent recipients of this gift',
	'g-remove-success-title' => 'You have successfully removed the gift "$1"',
	'g-remove-success-message' => 'The gift "$1" has been removed.',
	'g-remove-title' => 'Remove "$1"?',
	'g-send-gift' => 'Send gift',
	'g-select-a-friend' => 'select a friend',
	'g-sent-title' => 'You have sent a gift to $1',
	'g-sent-message' => 'You have sent the following gift to $1.',
	'g-small' => 'Small',
	'g-to-another' => 'Give to someone else',
	'g-uploadsuccess' => 'Upload successful',
	'g-viewgiftlist' => 'View gift list',
	'g-your-profile' => 'Your profile',
	'gift_received_subject' => '$1 has sent you the $2 gift on {{SITENAME}}!',
	'gift_received_body' => 'Hi $1.

$2 just sent you the $3 gift on {{SITENAME}}.

Want to read the note $2 left you and see your gift?   Click the link below:

$4

We hope you like it!

Thanks,


The {{SITENAME}} team

---

Hey, want to stop getting emails from us?

Click $5
and change your settings to disable email notifications.',
	// For Special:ListGroupRights
	'right-giftadmin' => 'Create new and edit existing gifts',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Purodha
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'giftmanager-public' => '{{Identical|Public}}',
	'giftmanager-private' => '{{Identical|Private}}',
	'g-cancel' => '{{Identical|Cancel}}',
	'g-count' => "* '''$1''' is a user name
* '''$2''' is his or her count of gifts",
	'g-created-by' => 'Complete contents of a cell in a table. The next cell (horizontally) contains the user name of the creator of a gift. {{gender}}
* (optional) $1 is a user name that is used in the next cell',
	'g-description-title' => '{{gender}}
* $1 is a user name
* $2 is the name of a gift',
	'g-give-separator' => '{{Identical|Or}}',
	'g-go-back' => '{{Identical|Go back}}',
	'g-large' => '{{Identical|Large}}',
	'g-main-page' => '{{Identical|Main page}}',
	'g-medium' => '{{Identical|Medium}}',
	'g-new' => '{{Identical|New}}',
	'g-next' => '{{Identical|Next}}',
	'g-previous' => '{{Identical|Prev}}',
	'g-small' => '{{Identical|Small}}',
	'gift_received_body' => "* $1 is a the (real) user name
* $2 is the giving user's name
* $3 is the gift name
* $4 is a link to the given gift
* $5 is a link to the user preferences",
	'right-giftadmin' => '{{doc-right|giftadmin}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'giftmanager-private' => 'privaat',
	'g-cancel' => 'Kanselleer',
	'g-go-back' => 'Gaan terug',
	'g-large' => 'Groot',
	'g-main-page' => 'Tuisblad',
	'g-medium' => 'Middelmatig',
	'g-new' => 'nuut',
	'g-next' => 'Volgende',
	'g-previous' => 'Vorige',
	'g-small' => 'Klein',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'giftmanager' => 'menaxher Gifts',
	'giftmanager-addgift' => '+ Shto dhuratë të reja',
	'giftmanager-access' => 'qasje dhuratë',
	'giftmanager-description' => 'Përshkrimi dhuratë',
	'giftmanager-giftimage' => 'image dhuratë',
	'giftmanager-image' => 'shtoni / zëvendësojë imazhin',
	'giftmanager-giftcreated' => 'Dhuratë është krijuar',
	'giftmanager-giftsaved' => 'Dhuratë u ruajt',
	'giftmanager-public' => 'publik',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Lista Shiko dhuratë',
	'g-add-message' => 'Shto një mesazh',
	'g-back-edit-gift' => 'Prapa te redaktoni këtë dhuratë',
	'g-back-gift-list' => 'Kthehu tek lista dhuratë',
	'g-back-link' => '<Kthehu tek $1 për faqe',
	'g-choose-file' => 'Zgjidhni skedar:',
	'g-cancel' => 'Anuloj',
	'g-count' => '$1 ka $2 {{PLURAL:$2|dhuratë|dhurata}}.',
	'g-create-gift' => 'dhuratë Krijo',
	'g-created-by' => 'krijuar nga',
	'g-current-image' => 'imazhin e tanishme',
	'g-delete-message' => 'A jeni i sigurt se doni te fshini dhuratë "$1"? Kjo gjithashtu do të fshijë atë nga përdoruesit të cilët mund të kenë marrë atë.',
	'g-description-title' => '$1 është dhuratë "$2"',
	'g-error-do-not-own' => 'Ju nuk zotërojnë këtë dhuratë.',
	'g-error-message-blocked' => 'Ju jeni bllokuar për momentin dhe nuk mund të japin dhurata',
	'g-error-message-invalid-link' => 'Lidhje e keni futur është i pavlefshëm.',
	'g-error-message-login' => 'Ju duhet të hyni-në për të dhënë dhurata',
	'g-error-message-no-user' => 'Perdoruesi jeni duke u përpjekur për të parë nuk ekziston.',
	'g-error-message-to-yourself' => 'Ju nuk mund të japë një dhuratë për veten.',
	'g-error-title' => 'Woops, ju mori një kthesë të gabuar!',
	'g-file-instructions' => 'Imazhi yt duhet të jetë një jpeg, png ose gif (pa animuar gifs), dhe duhet të jetë më pak se 100kb në madhësi.',
	'g-from' => 'nga <a href="$1">$2</a>',
	'g-gift' => 'dhuratë',
	'g-gift-name' => 'Emri dhuratë',
	'g-give-gift' => 'Jepni dhuratë',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'g-cancel' => 'Cancelar',
	'g-small' => 'Chicot',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'giftmanager' => 'مدير الهدايا',
	'giftmanager-addgift' => '+ إضافة هدية جديدة',
	'giftmanager-access' => 'وصول الهدية',
	'giftmanager-description' => 'وصف الهدية',
	'giftmanager-giftimage' => 'صورة الهدية',
	'giftmanager-image' => 'أضف/استبدل الصورة',
	'giftmanager-giftcreated' => 'الهدية تم إنشاؤها',
	'giftmanager-giftsaved' => 'الهدية تم حفظها',
	'giftmanager-public' => 'علني',
	'giftmanager-private' => 'خاص',
	'giftmanager-view' => 'عرض قائمة الهدايا',
	'g-add-message' => 'أضف رسالة',
	'g-back-edit-gift' => 'رجوع لتعديل هذه الهدية',
	'g-back-gift-list' => 'رجوع لقائمة الهدايا',
	'g-back-link' => '< رجوع إلى صفحة $1',
	'g-choose-file' => 'اختر الملف:',
	'g-cancel' => 'ألغِ',
	'g-count' => 'لدى $1 {{PLURAL:$2||هدية واحدة|هديتان|$2 هدايا|$2 هدية}}.',
	'g-create-gift' => 'إنشاء الهدية',
	'g-created-by' => '{{GENDER:$1|أنشأها|أنشأتها}}',
	'g-current-image' => 'الصورة الحالية',
	'g-delete-message' => 'هل أنت متأكد أنك تريد حذف الهدية "$1"؟ هذا سيحذفها أيضا من المستخدمين الذين ربما كانوا قد تلقوها.',
	'g-description-title' => 'الهدية "$2" الخاصة ب$1',
	'g-error-do-not-own' => 'أنت لا تمتلك هذه الهدية.',
	'g-error-message-blocked' => 'أنت حاليا ممنوع ولا يمكنك إعطاء هدايا',
	'g-error-message-invalid-link' => 'الوصلة التي أدخلتها غير صحيحة.',
	'g-error-message-login' => 'يجب عليك تسجيل الدخول لإعطاء هدايا',
	'g-error-message-no-user' => 'المستخدم الذي تحاول رؤيته غير موجود.',
	'g-error-message-to-yourself' => 'أنت لا يمكنك منح هدية لنفسك.',
	'g-error-title' => 'آه، أنت أخذت منحنى خاطئا!',
	'g-file-instructions' => 'صورتك يجب أن تكون jpeg، png أو gif (لا gif فيديو)، ويجب أن تكون أقل من 100 كيلوبت في الحجم.',
	'g-from' => 'من <a href="$1">$2</a>',
	'g-gift' => 'هدية',
	'g-gift-name' => 'اسم الهدية',
	'g-give-gift' => 'منح هدية',
	'g-give-all' => 'تريد إعطاء $1 هدية؟ فقط اضغط على واحد من الهدايا بالأسفل واضغط "إرسال الهدية." الموضوع بهذه السهولة.',
	'g-give-all-message-title' => 'إضافة رسالة',
	'g-give-all-title' => 'إعطاء هدية إلى $1',
	'g-give-enter-friend-title' => 'لو كنت تعرف اسم المستخدم، اكتبه بالأسفل',
	'g-given' => 'أعطيت هذه الهدية {{PLURAL:$1||مرة واحدة|مرتين|$1 مرات|$1 مرة}}',
	'g-give-list-friends-title' => 'اختر من قائمة أصدقائك',
	'g-give-list-select' => 'اختر صديقا',
	'g-give-separator' => 'أو',
	'g-give-no-user-message' => 'الهدايا والجوائز طريقة عظيمة لمعرفة أصدقائك!',
	'g-give-no-user-title' => 'من تريد إعطاء هدية له؟',
	'g-give-to-user-title' => 'أرسل الهدية "$1" إلى $2',
	'g-give-to-user-message' => 'تريد إعطاء $1 a <a href="$2">هدية مختلفة</a>؟',
	'g-go-back' => 'رجوع',
	'g-imagesbelow' => 'بالأسفل صورك التي سيتم استخدامها في الموقع',
	'g-large' => 'كبير',
	'g-list-title' => 'قائمة الهدايا الخاصة ب$1',
	'g-main-page' => 'الصفحة الرئيسية',
	'g-medium' => 'متوسط',
	'g-mediumlarge' => 'كبير-متوسط',
	'g-new' => 'جديد',
	'g-next' => 'تالي',
	'g-previous' => 'سابق',
	'g-remove' => 'إزالة',
	'g-remove-gift' => 'إزالة هذه الهدية',
	'g-remove-message' => 'هل أنت متأكد أنك تريد إزالة الهدية "$1"؟',
	'g-recent-recipients' => 'المتلقون الجدد الآخرون لهذه الهدية',
	'g-remove-success-title' => 'أنت أزلت بنجاح الهدية "$1"',
	'g-remove-success-message' => 'الهدية "$1" تمت إزالتها.',
	'g-remove-title' => 'إزالة "$1"؟',
	'g-send-gift' => 'إرسال الهدية',
	'g-select-a-friend' => 'اختر صديقا',
	'g-sent-title' => 'أنت أرسلت هدية إلى $1',
	'g-sent-message' => 'أنت أرسلت الهدية التالية إلى $1.',
	'g-small' => 'صغير',
	'g-to-another' => 'منح إلى شخص آخر',
	'g-uploadsuccess' => 'الرفع نجح',
	'g-viewgiftlist' => 'عرض قائمة الهدايا',
	'g-your-profile' => 'ملفك',
	'gift_received_subject' => '$1 أرسل لك الهدية $2 في {{SITENAME}}!',
	'gift_received_body' => 'مرحبا $1:

$2 أرسل حالا لك الهدية $3 في {{SITENAME}}.

تريد قراءة الملاحظة التي تركها $2 لك ورؤية هديتك؟  اضغط على الوصلة بالأسفل:

$4

نأمل أن تعجبك!

شكرا،


فريق {{SITENAME}}

---

ها، تريد التوقف عن تلقي رسائل بريد إلكتروني منا؟

اضغط $5
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'right-giftadmin' => 'إنشاء هدايا جديدة وتعديل الموجودة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'giftmanager' => 'ܕܒܘܪܐ ܕܕ̈ܫܢܐ',
	'giftmanager-addgift' => '+ ܐܘܣܦ ܕܫܢܐ ܚܕܬܐ',
	'giftmanager-description' => 'ܫܘܡܗܐ ܕܕܫܢܐ',
	'giftmanager-giftimage' => 'ܨܘܪܬܐ ܕܕܫܢܐ',
	'giftmanager-private' => 'ܦܪܨܘܦܝܐ',
	'giftmanager-view' => 'ܚܙܝ ܡܟܬܒܘܬܐ ܕܕ̈ܫܢܐ',
	'g-add-message' => 'ܐܘܣܦ ܐܓܪܬܐ',
	'g-choose-file' => 'ܓܒܝ ܠܦܦܐ:',
	'g-cancel' => 'ܒܛܘܠ',
	'g-count' => '$1 ܐܝܬ ܠܗ $2 {{PLURAL:$2|ܕܫܢܐ|ܕܫܢ̈ܐ}}.',
	'g-create-gift' => 'ܒܪܝ ܕܫܢܐ',
	'g-current-image' => 'ܨܘܪܬܐ ܗܫܝܬܐ',
	'g-gift' => 'ܕܫܢܐ',
	'g-gift-name' => 'ܫܡܐ ܕܕܫܢܐ',
	'g-give-gift' => 'ܝܗܒ ܕܫܢܐ',
	'g-give-all-message-title' => 'ܐܘܣܦ ܐܓܪܬܐ',
	'g-give-all-title' => 'ܝܗܒ ܕܫܢܐ ܠ $1',
	'g-give-list-select' => 'ܓܒܝ ܪܚܡܐ',
	'g-give-separator' => 'ܐܘ',
	'g-large' => 'ܪܒܐ',
	'g-list-title' => 'ܡܟܬܒܘܬܐ ܕܕ̈ܫܢܐ ܕ $1',
	'g-main-page' => 'ܦܐܬܐ ܪܫܝܬܐ',
	'g-medium' => 'ܡܨܥܝܐ',
	'g-mediumlarge' => 'ܡܨܥܝܐ - ܪܒܐ',
	'g-new' => 'ܚܕܬܐ',
	'g-next' => 'ܒܬܪ',
	'g-previous' => 'ܩܕܡ',
	'g-remove' => 'ܠܚܝ',
	'g-remove-title' => 'ܠܚܝ "$1"؟',
	'g-send-gift' => 'ܫܕܪ ܕܫܢܐ',
	'g-small' => 'ܙܥܘܪܐ',
	'g-uploadsuccess' => 'ܐܣܩܬܐ ܕܠܦܦܐ ܢܨܚ',
	'g-viewgiftlist' => 'ܚܙܝ ܡܟܬܒܘܬܐ ܕܕ̈ܫܢܐ',
	'g-your-profile' => 'ܦܘܓܪܦܐ ܕܝܠܟ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'giftmanager' => 'مدير الهدايا',
	'giftmanager-addgift' => '+ إضافة هدية جديدة',
	'giftmanager-access' => 'وصول الهدية',
	'giftmanager-description' => 'وصف الهدية',
	'giftmanager-giftimage' => 'صورة الهدية',
	'giftmanager-image' => 'أضف/استبدل الصورة',
	'giftmanager-giftcreated' => 'الهدية تم إنشاؤها',
	'giftmanager-giftsaved' => 'الهدية تم حفظها',
	'giftmanager-public' => 'علنى',
	'giftmanager-private' => 'خاص',
	'giftmanager-view' => 'عرض قائمة الهدايا',
	'g-add-message' => 'ضيف رساله',
	'g-back-edit-gift' => 'رجوع لتعديل هذه الهدية',
	'g-back-gift-list' => 'رجوع لقائمة الهدايا',
	'g-back-link' => '< رجوع إلى صفحة $1',
	'g-choose-file' => 'اختر الملف:',
	'g-cancel' => 'إلغاء',
	'g-count' => '$1 يمتلك $2 {{PLURAL:$2|هدية|هدية}}.',
	'g-create-gift' => 'إنشاء الهدية',
	'g-created-by' => 'تم إنشاؤها بواسطة',
	'g-current-image' => 'الصورة الحالية',
	'g-delete-message' => 'هل أنت متأكد أنك تريد حذف الهدية "$1"؟ هذا سيحذفها أيضا من المستخدمين الذين ربما كانوا قد تلقوها.',
	'g-description-title' => 'الهدية "$2" الخاصة ب$1',
	'g-error-do-not-own' => 'أنت لا تمتلك هذه الهدية.',
	'g-error-message-blocked' => 'أنت حاليا ممنوع ولا يمكنك إعطاء هدايا',
	'g-error-message-invalid-link' => 'الوصلة التى أدخلتها غير صحيحة.',
	'g-error-message-login' => 'يجب عليك تسجيل الدخول لإعطاء هدايا',
	'g-error-message-no-user' => 'المستخدم الذى تحاول رؤيته غير موجود.',
	'g-error-message-to-yourself' => 'أنت لا يمكنك منح هدية لنفسك.',
	'g-error-title' => 'آه، أنت أخذت منحنى خاطئا!',
	'g-file-instructions' => 'صورتك يجب أن تكون jpeg، png أو gif (لا gif فيديو)، ويجب أن تكون أقل من 100 كيلوبت فى الحجم.',
	'g-from' => 'من <a href="$1">$2</a>',
	'g-gift' => 'هدية',
	'g-gift-name' => 'اسم الهدية',
	'g-give-gift' => 'منح هدية',
	'g-give-all' => 'تريد إعطاء $1 هدية؟ فقط اضغط على واحد من الهدايا بالأسفل واضغط "إرسال الهدية." الموضوع بهذه السهولة.',
	'g-give-all-message-title' => 'إضافة رسالة',
	'g-give-all-title' => 'إعطاء هدية إلى $1',
	'g-give-enter-friend-title' => 'لو كنت تعرف اسم المستخدم، اكتبه بالأسفل',
	'g-given' => 'هذه الهدية تم إعطاؤها $1 {{PLURAL:$1|مرة|مرة}}',
	'g-give-list-friends-title' => 'اختر من قائمة أصدقائك',
	'g-give-list-select' => 'اختر صديقا',
	'g-give-separator' => 'أو',
	'g-give-no-user-message' => 'الهدايا والجوائز طريقة عظيمة لمعرفة أصدقائك!',
	'g-give-no-user-title' => 'من تريد إعطاء هدية له؟',
	'g-give-to-user-title' => 'أرسل الهدية "$1" إلى $2',
	'g-give-to-user-message' => 'تريد إعطاء $1 a <a href="$2">هدية مختلفة</a>؟',
	'g-go-back' => 'رجوع',
	'g-imagesbelow' => 'بالأسفل صورك التى سيتم استخدامها فى الموقع',
	'g-large' => 'كبير',
	'g-list-title' => 'قائمة الهدايا الخاصة ب$1',
	'g-main-page' => 'الصفحة الرئيسية',
	'g-medium' => 'متوسط',
	'g-mediumlarge' => 'كبير-متوسط',
	'g-new' => 'جديد',
	'g-next' => 'تالى',
	'g-previous' => 'سابق',
	'g-remove' => 'إزالة',
	'g-remove-gift' => 'إزالة هذه الهدية',
	'g-remove-message' => 'هل أنت متأكد أنك تريد إزالة الهدية "$1"؟',
	'g-recent-recipients' => 'المتلقون الجدد الآخرون لهذه الهدية',
	'g-remove-success-title' => 'أنت أزلت بنجاح الهدية "$1"',
	'g-remove-success-message' => 'الهدية "$1" تمت إزالتها.',
	'g-remove-title' => 'إزالة "$1"؟',
	'g-send-gift' => 'إرسال الهدية',
	'g-select-a-friend' => 'اختر صديقا',
	'g-sent-title' => 'أنت أرسلت هدية إلى $1',
	'g-sent-message' => 'أنت أرسلت الهدية التالية إلى $1.',
	'g-small' => 'صغير',
	'g-to-another' => 'منح إلى شخص آخر',
	'g-uploadsuccess' => 'الرفع نجح',
	'g-viewgiftlist' => 'عرض قائمة الهدايا',
	'g-your-profile' => 'ملفك',
	'gift_received_subject' => '$1 أرسل لك الهدية $2 فى {{SITENAME}}!',
	'gift_received_body' => 'مرحبا $1:

$2 أرسل حالا لك الهدية $3 فى {{SITENAME}}.

تريد قراءة الملاحظة التى تركها $2 لك ورؤية هديتك؟  اضغط على الوصلة بالأسفل:

$4

نأمل أن تعجبك!

شكرا،


فريق {{SITENAME}}

---

ها، تريد التوقف عن تلقى رسائل بريد إلكترونى منا؟

اضغط $5
وغير إعداداتك لتعطيل إخطارات البريد الإلكترونى.',
	'right-giftadmin' => 'إنشاء هدايا جديدة وتعديل الموجودة',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'giftmanager-public' => 'ictimai',
	'g-cancel' => 'İmtina',
	'g-medium' => 'Orta',
	'g-new' => 'yeni',
	'g-next' => 'Növbəti',
	'g-small' => 'Kiçik',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'giftmanager' => 'Кіраваньне падарункамі',
	'giftmanager-addgift' => '+ Дадаць новы падарунак',
	'giftmanager-access' => 'доступ да падарунка',
	'giftmanager-description' => 'апісаньне падарунка',
	'giftmanager-giftimage' => 'выява падарунка',
	'giftmanager-image' => 'дадаць/замяніць выяву',
	'giftmanager-giftcreated' => 'Падарунак быў створаны',
	'giftmanager-giftsaved' => 'Падарунак быў захаваны',
	'giftmanager-public' => 'публічны',
	'giftmanager-private' => 'прыватны',
	'giftmanager-view' => 'Паказаць сьпіс падарункаў',
	'g-add-message' => 'Дадаць паведамленьне',
	'g-back-edit-gift' => 'Вярнуцца да рэдагаваньня гэтага падарунка',
	'g-back-gift-list' => 'Вярнуцца да сьпісу падарункаў',
	'g-back-link' => '< Вярнуцца на старонку $1',
	'g-choose-file' => 'Выбраць файл:',
	'g-cancel' => 'Скасаваць',
	'g-count' => '$1 мае $2 {{PLURAL:$2|падарунак|падарункі|падарункаў}}.',
	'g-create-gift' => 'Стварыць падарунак',
	'g-created-by' => 'створаны',
	'g-current-image' => 'Цяперашняя выява',
	'g-delete-message' => 'Вы ўпэўненыя, што жадаеце выдаліць падарунак «$1»? Ён будзе выдалены і ва ўдзельнікаў, якія маглі яго атрымаць.',
	'g-description-title' => 'падарунак «$2» ад $1',
	'g-error-do-not-own' => 'Вы не валодаеце гэтым падарункам.',
	'g-error-message-blocked' => 'Цяпер Вы заблякаваныя і ня можаце дарыць падарункі',
	'g-error-message-invalid-link' => 'Вы ўвялі няслушную спасылку.',
	'g-error-message-login' => 'Вам неабходна ўвайсьці ў сыстэму, каб дарыць падарункі',
	'g-error-message-no-user' => 'Удзельніка, якога Вы спрабуеце паглядзець, не існуе.',
	'g-error-message-to-yourself' => 'Вы ня можаце дарыць падарункі сабе.',
	'g-error-title' => 'Ой! Вы выбралі няслушны кірунак!',
	'g-file-instructions' => 'Ваша выява павінна быць у фармаце jpeg, png альбо gif (анімаваныя выявы не дазволеныя) і мець памер меней за 100 кб.',
	'g-from' => 'ад <a href="$1">$2</a>',
	'g-gift' => 'падарунак',
	'g-gift-name' => 'назва падарунка',
	'g-give-gift' => 'Зрабіць падарунак',
	'g-give-all' => 'Жадаеце падарыць $1 падарунак? Проста націсьніце на падарункі, якія знаходзяцца ніжэй, я потым націсьніце «Даслаць падарунак». Гэта вельмі проста.',
	'g-give-all-message-title' => 'Дадаць паведамленьне',
	'g-give-all-title' => 'Зрабіць падарунак $1',
	'g-give-enter-friend-title' => 'Калі Вы ведаеце імя ўдзельніка, проста ўвядзіце яго ніжэй',
	'g-given' => 'Гэты падарунак быў падараваны $1 {{PLURAL:$1|раз|разы|разоў}}',
	'g-give-list-friends-title' => 'Выбраць з Вашага сьпісу сяброў',
	'g-give-list-select' => 'выбраць сябра',
	'g-give-separator' => 'ці',
	'g-give-no-user-message' => 'Падарункі і ўзнагароды — найлепшы шлях да выразу ўдзячнасьці Вашым сябрам!',
	'g-give-no-user-title' => 'Каму Вы жадаеце зрабіць падарунак?',
	'g-give-to-user-title' => 'Даслаць падарунак «$1» у адрас $2',
	'g-give-to-user-message' => 'Жадаеце падарыць $1 <a href="$2">іншы падарунак</a>?',
	'g-go-back' => 'Вярнуцца',
	'g-imagesbelow' => 'Ніжэй знаходзяцца Вашы выявы, якія будуць выкарыстоўваюцца на сайце',
	'g-large' => 'Вялікія',
	'g-list-title' => 'Сьпіс падарункаў $1',
	'g-main-page' => 'Галоўная старонка',
	'g-medium' => 'Сярэднія',
	'g-mediumlarge' => 'Сярэдне-вялікія',
	'g-new' => 'новыя',
	'g-next' => 'Наступны',
	'g-previous' => 'Папярэдні',
	'g-remove' => 'Выдаліць',
	'g-remove-gift' => 'Выдаліць гэты падарунак',
	'g-remove-message' => 'Вы ўпэўнены, што жадаеце выдаліць падарунак «$1»?',
	'g-recent-recipients' => 'Іншыя апошнія атрымальнікі гэтага падарунка',
	'g-remove-success-title' => 'Вы пасьпяхова выдалілі падарунак «$1»',
	'g-remove-success-message' => 'Падарунак «$1» быў выдалены.',
	'g-remove-title' => 'Выдаліць «$1»?',
	'g-send-gift' => 'Даслаць падарунак',
	'g-select-a-friend' => 'выбраць сябра',
	'g-sent-title' => 'Вы даслалі падарунак у адрас $1',
	'g-sent-message' => 'Вы даслалі наступныя падарункі ў адрас $1.',
	'g-small' => 'Маленькі',
	'g-to-another' => 'Падарыць каму-небудзь іншаму',
	'g-uploadsuccess' => 'Пасьпяхова загружаны',
	'g-viewgiftlist' => 'Паказаць сьпіс падарункаў',
	'g-your-profile' => 'Ваш профіль',
	'gift_received_subject' => '$1 даслаў Вам падарунак $2 у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'gift_received_body' => 'Прывітаньне, $1.

$2 толькі што даслаў Вам падарунак $3 падарунак у {{GRAMMAR:месны|{{SITENAME}}}}.

Жадаеце прачытаць пажаданьні $2 далучаныя да падарунка і паглядзець сам падарунак? Націсьніце спасылку ніжэй:

$4

Мы спадзяемся, што ён Вам спадабаецца!

Дзякуй,


Каманда {{SITENAME}}

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $5 і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
	'right-giftadmin' => 'Стварыць новы падарунак альбо рэдагаваць існуючыя падарункі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'giftmanager-addgift' => '+ Добавяне на нов подарък',
	'giftmanager-description' => 'описание на подаръка',
	'giftmanager-image' => 'добавяне/заменяне на картинката',
	'giftmanager-giftcreated' => 'Подаръкът беше създаден',
	'giftmanager-giftsaved' => 'Подаръкът беше съхранен',
	'giftmanager-view' => 'Преглеждане на списъка с подаръци',
	'g-add-message' => 'Добавяне на съобщение',
	'g-back-link' => '< Връщане към страницата на $1',
	'g-choose-file' => 'Избиране на файл:',
	'g-cancel' => 'Отмяна',
	'g-count' => '$1 има $2 {{PLURAL:$2|подарък|подаръка}}.',
	'g-created-by' => 'създаден от',
	'g-current-image' => 'Текуща картинка',
	'g-error-message-login' => 'За да давате подаръци е необходимо да влезете в системата',
	'g-from' => 'от <a href="$1">$2</a>',
	'g-gift' => 'подарък',
	'g-gift-name' => 'име на подаръка',
	'g-give-all-message-title' => 'Добавяне на съобщение',
	'g-give-list-select' => 'избиране на приятел',
	'g-give-separator' => 'или',
	'g-large' => 'Голяма',
	'g-medium' => 'Средна',
	'g-next' => 'Следваща',
	'g-previous' => 'Предишна',
	'g-remove' => 'Премахване',
	'g-small' => 'Малка',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'giftmanager-description' => 'উপহারের বিবরণ',
	'giftmanager-giftimage' => 'উপহারের ছবি',
	'giftmanager-image' => 'ছবি যোগ/প্রতিস্থাপন',
	'giftmanager-giftcreated' => 'উপহারটি তৈরি করা হয়েছে',
	'giftmanager-giftsaved' => 'উপহারটি সংরক্ষিত হয়েছে',
	'giftmanager-public' => 'সর্বসাধারণের',
	'giftmanager-private' => 'ব্যক্তিগত',
	'giftmanager-view' => 'উপহারের তালিকা দেখাও',
	'g-add-message' => 'একটি বার্তা যোগ করো',
	'g-choose-file' => 'ফাইল পছন্দ করুন:',
	'g-cancel' => 'বাতিল',
	'g-create-gift' => 'উপহার তৈরি করুন',
	'g-created-by' => 'তৈরি করেছেন',
	'g-current-image' => 'বর্তমান ছবি',
	'g-gift' => 'উপহার',
	'g-gift-name' => 'উপহারের নাম',
	'g-give-gift' => 'উপহার দিন',
	'g-give-all-message-title' => 'একটি বার্তা যোগ করো',
	'g-give-all-title' => '$1-কে একটি উপহার দিন',
	'g-give-list-select' => 'একজন বন্ধু নির্বাচন করুন',
	'g-give-separator' => 'অথবা',
	'g-go-back' => 'ফিরে যান',
	'g-large' => 'বিশাল',
	'g-main-page' => 'প্রধান পাতা',
	'g-medium' => 'মধ্যম',
	'g-mediumlarge' => 'মধ্যম-বড়',
	'g-new' => 'নতুন',
	'g-next' => 'পরবর্তী',
	'g-previous' => 'পূর্ববর্তী',
	'g-remove' => 'অপসারণ',
	'g-remove-gift' => 'এই উপহারটি অপসারণ করো',
	'g-send-gift' => 'উপহার প্রেরণ করো',
	'g-select-a-friend' => 'একজন বন্ধু নির্বাচন করুন',
	'g-sent-title' => 'আপনি $1-এর কাছে একটি উপহার পাঠিয়েছেন',
	'g-small' => 'ছোট',
	'g-viewgiftlist' => 'উপহারের তালিকা দেখাও',
	'g-your-profile' => 'আপনার বৃত্তান্ত',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 */
$messages['br'] = array(
	'giftmanager' => 'Merour ar profoù',
	'giftmanager-addgift' => '+ Ouzhpennañ ur prof nevez',
	'giftmanager-access' => "Mont d'ar prof",
	'giftmanager-description' => 'deskrivadur ar prof',
	'giftmanager-giftimage' => 'skeudenn ar prof',
	'giftmanager-image' => "ouzhpennañ / erlec'hiañ ar skeudenn",
	'giftmanager-giftcreated' => 'Krouet eo bet ar prof',
	'giftmanager-giftsaved' => 'Enrollet eo bet ar prof',
	'giftmanager-public' => 'foran',
	'giftmanager-private' => 'prevez',
	'giftmanager-view' => 'Gwelet roll ar profoù',
	'g-add-message' => 'Ouzhpennañ ur gemennadenn',
	'g-back-edit-gift' => 'Distreiñ da aozañ ar prof-mañ',
	'g-back-gift-list' => 'Distreiñ da roll ar profoù',
	'g-back-link' => '< Distreiñ da bajenn $1',
	'g-choose-file' => 'Dibab ur restr :',
	'g-cancel' => 'Nullañ',
	'g-count' => '$1 en deus $2 {{PLURAL:$2|prof|prof}}.',
	'g-create-gift' => 'Krouiñ ur prof',
	'g-created-by' => 'krouet gant',
	'g-current-image' => 'Skeudenn red',
	'g-delete-message' => "Ha sur oc'h hoc'h eus c'hoant da zilemel ar prof « $1 » ? 
Dilamet e vo ivez evit ar re o deus e resevet.",
	'g-description-title' => 'Prof « $2 » a-berzh $1',
	'g-error-do-not-own' => "N'eo ket deoc'h ar prof-mañ.",
	'g-error-message-blocked' => "Stanket oc'h evit bremañ ha ne c'hallit ket reiñ profoù",
	'g-error-message-invalid-link' => "Direizh eo al liamm hoc'h eus ebarzhet.",
	'g-error-message-login' => "Ret eo deoc'h kevreañ evit reiñ profoù",
	'g-error-message-no-user' => "N'eus ket eus an implijer emaoc'h o klask gwelet.",
	'g-error-message-to-yourself' => "Ne c'hallit ket reiñ ur prof deoc'h-c'hwi hoc'h-unan.",
	'g-error-title' => "Hopala, kemeret hoc'h eus un hent fall !",
	'g-file-instructions' => "Ret eo d'ho skeudenn bezañ er furmad jpeg, png pe gif (gif n'eo ket bev) ha ne c'hall ket he ment bezañ ouzhpenn 100 ko.",
	'g-from' => 'eus <a href="$1">$2</a>',
	'g-gift' => 'prof',
	'g-gift-name' => 'anv ar prof',
	'g-give-gift' => 'Reiñ ur prof',
	'g-give-all' => 'C\'hoant hoc\'h eus da reiñ ur prof da $1 ?
Klikit war unan eus ar profoù amañ dindan ha klikit war "Kas ar prof".
Ken aes-se eo.',
	'g-give-all-message-title' => 'Ouzhpennañ ur gemennadenn',
	'g-give-all-title' => 'Reiñ ur prof da $1',
	'g-give-enter-friend-title' => 'Ma anavezit anv an implijer, skriverezit-eñ amañ dindan',
	'g-given' => 'Roet eo bet ar prof-mañ {{PLURAL:$1|wech|gwech}}',
	'g-give-list-friends-title' => 'Diuzit diwar ho roll mignoned',
	'g-give-list-select' => 'diuzañ ur mignon',
	'g-give-separator' => 'pe',
	'g-give-no-user-message' => 'Dispar eo ar profoù hag ar garedonoù evit anavezout ho mignoned !',
	'g-give-no-user-title' => "Da biv hoc'h eus c'hoant da reiñ ur prof ?",
	'g-give-to-user-title' => 'Kas ar prof « $1 » da $2',
	'g-give-to-user-message' => 'Ha c\'hoant hoc\'h eus da reiñ <a href="$2">ur prof disheñvel</a> da $1 ?',
	'g-go-back' => 'Distreiñ',
	'g-imagesbelow' => "Amañ dindan emañ ar skeudennoù a vo implijet war al lec'hienn",
	'g-large' => 'Bras',
	'g-list-title' => 'Roll profoù $1',
	'g-main-page' => 'Pajenn degemer',
	'g-medium' => 'Etre',
	'g-mediumlarge' => 'Etre-bras',
	'g-new' => 'nevez',
	'g-next' => "War-lerc'h",
	'g-previous' => 'Kent',
	'g-remove' => 'Lemel',
	'g-remove-gift' => 'Lemel ar prof-mañ',
	'g-remove-message' => "Ha sur oc'h hoc'h eus c'hoant da lemel ar prof « $1 » ?",
	'g-recent-recipients' => 'Re all o deus bet ar prof-mañ nevez zo',
	'g-remove-success-title' => "Lamet hoc'h eus ar prof « $1 »",
	'g-remove-success-message' => 'Lamet eo bet ar prof « $1 ».',
	'g-remove-title' => 'Lemel « $1 » ?',
	'g-send-gift' => 'Kas ar prof',
	'g-select-a-friend' => 'diuzañ ur mignon',
	'g-sent-title' => "Kaset hoc'h eus ur prof da $1",
	'g-sent-message' => "Kaset hoc'h eus ar prof-mañ da $1.",
	'g-small' => 'Bihan',
	'g-to-another' => 'Reiñ da unan bennak all',
	'g-uploadsuccess' => 'Kaset eo bet',
	'g-viewgiftlist' => 'Gwelet roll ar profoù',
	'g-your-profile' => 'Ho profil',
	'gift_received_subject' => "$1 en deus kaset deoc'h ar prof $2 war {{SITENAME}} !",
	'gift_received_body' => "Salud deoc'h, $1.

Emañ $2 o paouez kas ar prof $3 deoc'h war {{SITENAME}}.

C'hoant hoc'h eus da lenn an notenn zo bet lezet gant $2 evidoc'h ha da welet ho prof ?  Klikit war al liamm amañ dindan :

$4

Emichañs e plijo deoc'h !

Trugarez deoc'h,


Skipailh {{SITENAME}}

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $5
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
	'right-giftadmin' => 'Krouiñ pe aozañ profoù',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Palapa
 */
$messages['bs'] = array(
	'giftmanager' => 'Upravljanje poklonima',
	'giftmanager-addgift' => '+ Dodaj novi poklon',
	'giftmanager-description' => 'opis poklona',
	'giftmanager-giftimage' => 'slika poklona',
	'giftmanager-image' => 'dodaj/zamijeni sliku',
	'giftmanager-giftcreated' => 'Poklon je napravljen',
	'giftmanager-giftsaved' => 'Poklon je sačuvan',
	'giftmanager-public' => 'javno',
	'giftmanager-private' => 'privatno',
	'giftmanager-view' => 'Pogledaj spisak poklona',
	'g-add-message' => 'Dodaj poruku',
	'g-back-edit-gift' => 'Nazad na uređivanje ovog poklona',
	'g-back-gift-list' => 'Nazad na spisak poklona',
	'g-back-link' => '< Nazad na stranicu korisnika $1',
	'g-choose-file' => 'Odaberite datoteku:',
	'g-cancel' => 'Odustani',
	'g-count' => 'Korisnik $1 ima $2 {{PLURAL:$2|poklon|poklona}}.',
	'g-create-gift' => 'Napravi poklon',
	'g-created-by' => 'napravljeno od strane',
	'g-current-image' => 'Trenutna slika',
	'g-description-title' => 'Poklon $2 korisnika $1',
	'g-error-do-not-own' => 'Vi ne posjedujete ovaj poklon.',
	'g-error-message-no-user' => 'Korisnik kojeg pokušavate vidjeti ne postoji.',
	'g-error-message-to-yourself' => 'Ne možete poslati poklon samom sebi.',
	'g-from' => 'iz <a href="$1">$2</a>',
	'g-gift' => 'poklon',
	'g-gift-name' => 'naziv poklona',
	'g-give-gift' => 'Pokloni poklon',
	'g-give-all-message-title' => 'Dodaj poruku',
	'g-give-all-title' => 'Pošalji poklon za $1',
	'g-give-list-select' => 'odaberi prijatelja',
	'g-give-separator' => 'ili',
	'g-go-back' => 'Idi nazad',
	'g-large' => 'Veliki',
	'g-list-title' => 'Spisak poklona korisnika $1',
	'g-main-page' => 'Početna stranica',
	'g-medium' => 'Srednje',
	'g-mediumlarge' => 'Srednje-veliki',
	'g-new' => 'novo',
	'g-next' => 'Slijedeći',
	'g-previous' => 'Preth',
	'g-remove' => 'Ukloni',
	'g-remove-gift' => 'Ukloni ovaj poklon',
	'g-remove-success-message' => 'Poklon "$1" je uklonjen.',
	'g-remove-title' => 'Ukloni "$1"?',
	'g-send-gift' => 'Pošalji poklon',
	'g-select-a-friend' => 'odaberite prijatelja',
	'g-small' => 'Malo',
	'g-to-another' => 'Daj nekome drugom',
	'g-uploadsuccess' => 'Postavljanje uspješno',
	'g-viewgiftlist' => 'Pogledaj spisak poklona',
	'g-your-profile' => 'Vaš profil',
	'right-giftadmin' => 'Pravljenje novih i uređivanje postojećih poklona',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'giftmanager-public' => 'públic',
	'giftmanager-private' => 'privat',
	'g-choose-file' => 'Escull el fitxer:',
	'g-cancel' => 'Cancel·la',
	'g-create-gift' => 'Crea un regal',
	'g-current-image' => 'Imatge actual',
	'g-gift' => 'regal',
	'g-gift-name' => 'nom del regal',
	'g-give-list-select' => 'selecciona un amic',
	'g-give-separator' => 'o',
	'g-go-back' => 'Retorna',
	'g-main-page' => 'Pàgina principal',
	'g-medium' => 'Mitjà',
	'g-mediumlarge' => 'Mitjà-alt',
	'g-new' => 'nou',
	'g-next' => 'Següent',
	'g-previous' => 'Ant',
	'g-remove' => 'Elimina',
	'g-remove-gift' => 'Elimina aquest regal',
	'g-send-gift' => 'Envia un regal',
	'g-select-a-friend' => 'selecciona un amic',
	'g-small' => 'Petit',
	'g-your-profile' => 'El teu perfil',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'g-go-back' => 'گەڕانەوە بۆ دواوە',
	'g-next' => 'پاش',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'giftmanager-public' => 'veřejné',
	'giftmanager-private' => 'privátní',
	'g-go-back' => 'Zpět',
	'g-large' => 'Velká',
	'g-medium' => 'Střední',
	'g-new' => 'nová',
	'g-next' => 'Další',
	'g-previous' => 'Předchozí',
	'g-remove' => 'Odstranit',
	'g-small' => 'Malá',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Imre
 * @author Jorges
 * @author Kghbln
 * @author Purodha
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'giftmanager' => 'Geschenke-Verwaltung',
	'giftmanager-addgift' => '+ Neues Geschenk hinzufügen',
	'giftmanager-access' => 'Geschenkfortschritt',
	'giftmanager-description' => 'Geschenkbeschreibung',
	'giftmanager-giftimage' => 'Geschenkabbildung',
	'giftmanager-image' => 'Bild hinzufügen oder ersetzen',
	'giftmanager-giftcreated' => 'Das Geschenk wurde erstellt',
	'giftmanager-giftsaved' => 'Das Geschenk wurde gespeichert',
	'giftmanager-public' => 'öffentlich',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Geschenkeliste ansehen',
	'g-add-message' => 'Füge eine Nachricht hinzu',
	'g-back-edit-gift' => 'Zurück zur Geschenkbearbeitung',
	'g-back-gift-list' => 'Zurück zur Geschenkeliste',
	'g-back-link' => '< Zurück zum Profil von $1',
	'g-choose-file' => 'Wähle Datei:',
	'g-cancel' => 'Abbrechen',
	'g-count' => '$1 hat $2 {{PLURAL:$2|Geschenk|Geschenke}}.',
	'g-create-gift' => 'Geschenk erstellen',
	'g-created-by' => 'erstellt von',
	'g-current-image' => 'Aktuelles Bild',
	'g-delete-message' => 'Bist du dir sicher, das du das Geschenk „$1“ löschen möchtest?
Dies wird es auch bei Benutzern löschen, die es bereits erhalten haben.',
	'g-description-title' => 'Geschenk „$2“ von $1',
	'g-error-do-not-own' => 'Du besitzt dieses Geschenk nicht.',
	'g-error-message-blocked' => 'Du bist aktuell gesperrt und kannst keine Geschenke vergeben',
	'g-error-message-invalid-link' => 'Der eingegebende Link ist ungültig.',
	'g-error-message-login' => 'Du musst dich anmelden um Geschenke zu vergeben',
	'g-error-message-no-user' => 'Der Benutzer, den du anschauen möchtest, existiert nicht.',
	'g-error-message-to-yourself' => 'Du kannst dir selber keine Geschenke geben.',
	'g-error-title' => 'Oops, da ging etwas schief!',
	'g-file-instructions' => 'Das Bild muss ein „JPEG“, „PNG“ oder ein nicht animiertes „GIF“ sein sowie eine Dateigröße unter 100 KB haben.',
	'g-from' => 'von <a href="$1">$2</a>',
	'g-gift' => 'Geschenk',
	'g-gift-name' => 'Geschenkname',
	'g-give-gift' => 'Geschenk machen',
	'g-give-all' => 'Möchtest du $1 ein Geschenk geben? Suche eins der folgenden Geschenke aus und klicke „Geschenk senden“. Es ist ganz einfach.',
	'g-give-all-message-title' => 'Füge eine Nachricht hinzu',
	'g-give-all-title' => '$1 ein Geschenk machen',
	'g-give-enter-friend-title' => 'Falls du einen Benutzernamen weißt, trage ihn hier unten ein',
	'g-given' => 'Dieses Geschenk wurde {{PLURAL:$1|einmal|$1 mal}} ausgegeben',
	'g-give-list-friends-title' => 'Wähle aus deiner Freundesliste',
	'g-give-list-select' => 'wähle einen Freund aus',
	'g-give-separator' => 'oder',
	'g-give-no-user-message' => 'Geschenke und Auszeichnungen sind ein großartiger Weg um seine Freunde zu würdigen!',
	'g-give-no-user-title' => 'Wem möchtest du ein Geschenk geben?',
	'g-give-to-user-title' => 'Das Geschenk „$1“ an $2 geben',
	'g-give-to-user-message' => 'Möchest du $1 ein <a href="$2">anderes Geschenk geben</a>?',
	'g-go-back' => 'Gehe zurück',
	'g-imagesbelow' => 'Hier drunter folgen alle Bilder, die auf dieser Seite genutzt werden',
	'g-large' => 'Groß',
	'g-list-title' => 'Geschenkeliste von $1',
	'g-main-page' => 'Hauptseite',
	'g-medium' => 'Mittel',
	'g-mediumlarge' => 'Mittelgroß',
	'g-new' => 'neu',
	'g-next' => 'Nächste',
	'g-previous' => 'Vorherige',
	'g-remove' => 'Entfernen',
	'g-remove-gift' => 'Dieses Geschenk entfernen',
	'g-remove-message' => 'Bist du dir sicher, das Geschenk „$1“ zu entfernen?',
	'g-recent-recipients' => 'Andere aktuelle Empfänger dieses Geschenkes',
	'g-remove-success-title' => 'Du hast das Geschenk „$1“ erfolgreich entfernt.',
	'g-remove-success-message' => 'Das Geschenk „$1“ wurde entfernt.',
	'g-remove-title' => '„$1“ entfernen?',
	'g-send-gift' => 'Geschenk senden',
	'g-select-a-friend' => 'wähle einen Freund aus',
	'g-sent-title' => 'Du hast ein Geschenk an $1 gesendet',
	'g-sent-message' => 'Du hast die folgenden Geschenke an $1 gesendet.',
	'g-small' => 'Schmal',
	'g-to-another' => 'An jemand anders geben',
	'g-uploadsuccess' => 'Hochladen erfolgreich',
	'g-viewgiftlist' => 'Geschenkeliste ansehen',
	'g-your-profile' => 'Dein Profil',
	'gift_received_subject' => '[{{SITENAME}}] $1 hat dir das $2-Geschenk gesendet!',
	'gift_received_body' => 'Hallo $1,

$2 hat dir eben das $3-Geschenk auf {{SITENAME}} gesendet!

Möchtest du die Notiz von $2 lesen und dein Geschenk sehen? Klicke den folgenden Link:

$4

Wir hoffen, es gefällt dir!

Danke,

Das {{SITENAME}}-Team

---

Du möchtest keine E-Mails von uns erhalten?

Klicke $5
und ändere deine Einstellungen auf deaktivierte E-Mail-Benachrichtigung.',
	'right-giftadmin' => 'Neue erstellen und bestehende Geschenke bearbeiten',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author Kghbln
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'g-delete-message' => 'Sind Sie sich sicher, das Sie das Geschenk „$1“ löschen möchten?
Dies wird es auch bei Benutzern löschen, die es bereits erhalten haben.',
	'g-error-do-not-own' => 'Sie besitzen dieses Geschenk nicht.',
	'g-error-message-blocked' => 'Sie sind aktuell gesperrt und können keine Geschenke vergeben',
	'g-error-message-login' => 'Sie müssen sich anmelden um Geschenke zu vergeben',
	'g-error-message-no-user' => 'Der Benutzer, den Sie anschauen möchten, existiert nicht.',
	'g-error-message-to-yourself' => 'Sie können sich selber keine Geschenke geben.',
	'g-give-all' => 'Möchten Sie $1 ein Geschenk geben? Suchen Sie eins der folgenden Geschenke aus und klicken Sie „Geschenk senden“. Es ist ganz einfach.',
	'g-give-enter-friend-title' => 'Falls Sie einen Benutzernamen wissen, tragen Sie ihn hier unten ein',
	'g-give-list-friends-title' => 'Wählen Sie aus Ihrer Freundesliste',
	'g-give-no-user-title' => 'Wem möchten Sie ein Geschenk geben?',
	'g-give-to-user-message' => 'Möchen Sie $1 ein <a href="$2">anderes Geschenk geben</a>?',
	'g-remove-message' => 'Sind Sie sich sicher, das Geschenk „$1“ zu entfernen?',
	'g-remove-success-title' => 'Sie haben das Geschenk „$1“ erfolgreich entfernt.',
	'g-sent-title' => 'Sie haben ein Geschenk an $1 gesendet',
	'g-sent-message' => 'Sie haben die folgenden Geschenke an $1 gesendet.',
	'g-your-profile' => 'Ihr Profil',
	'gift_received_subject' => '[{{SITENAME}}] $1 hat Ihnen das $2-Geschenk gesendet!',
	'gift_received_body' => 'Hallo $1,

$2 hat Ihnen eben das $3-Geschenk auf {{SITENAME}} gesendet!

Möchten Sie die Notiz von $2 lesen und Ihr Geschenk sehen? Klicken Sie den folgenden Link:

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
	'giftmanager' => 'Zastojnik darow',
	'giftmanager-addgift' => '+ Nowy dar pśidaś',
	'giftmanager-access' => 'pśistup k daroju',
	'giftmanager-description' => 'wopisanje dara',
	'giftmanager-giftimage' => 'wobraz dara',
	'giftmanager-image' => 'wobraz pśidaś/wuměniś',
	'giftmanager-giftcreated' => 'Dar jo se napórał',
	'giftmanager-giftsaved' => 'Dar jo se składł',
	'giftmanager-public' => 'zjawny',
	'giftmanager-private' => 'priwatny',
	'giftmanager-view' => 'Lisćinu darow se woglědaś',
	'g-add-message' => 'Powěsć pśidaś',
	'g-back-edit-gift' => 'Slědk k wobźěłanjeju toś togo dara',
	'g-back-gift-list' => 'Slědk k lisćinje darow',
	'g-back-link' => '< Slědk k bokoju wužywarja $1',
	'g-choose-file' => 'Wubjeŕ dataju:',
	'g-cancel' => 'Pśetergnuś',
	'g-count' => '$1 ma $2 {{PLURAL:$2|dar|dara|dary|darow}}.',
	'g-create-gift' => 'Dar napóraś',
	'g-created-by' => 'napórany wót',
	'g-current-image' => 'Aktualny wobraz',
	'g-delete-message' => 'Coš dar "$1" napšawdu wulašowaś?
To wulašujo jen teke z wužywarjow, kótarež su jen dostali.',
	'g-description-title' => 'Dar "$2" wužywarja $1',
	'g-error-do-not-own' => 'Njewobsejźiš toś ten dar.',
	'g-error-message-blocked' => 'Sy tuchylu blokěrowany a njamóžoš nic dariś',
	'g-error-message-invalid-link' => 'Wótkaz, kótaryž sy zapódał, jo njepłaśiwy.',
	'g-error-message-login' => 'Musyš se pśizjawiś, aby něco darił',
	'g-error-message-no-user' => 'Wužywaŕ, kótaregož wopytujoš se woglědaś, njeeksistěrujo.',
	'g-error-message-to-yourself' => 'Njamóžoš sebje samemu nic dariś',
	'g-error-title' => 'Hopla, sy cynił něco wopaki!',
	'g-file-instructions' => 'Twój wobraz musy typ jpeg, png abo gif (žedne animěrowane gif) měś a mjeńšy ako 100 kb wjeliki byś.',
	'g-from' => 'z <a href="$1">$2</a>',
	'g-gift' => 'dar',
	'g-gift-name' => 'mě dara',
	'g-give-gift' => 'Dariś',
	'g-give-all' => 'Coš wužywarjeju $1 něco dariś?
Klikni jadnorje na jaden ze slědujucych darow a pón na "Dar pósłaś".
Jo cele lažko.',
	'g-give-all-message-title' => 'Powěsć pśidaś',
	'g-give-all-title' => 'Wužywarjeju $1 něco dariś',
	'g-give-enter-friend-title' => 'Jolic wěš mě wužywarja, zapiš jo dołojce',
	'g-given' => 'Dar jo se wudał {{PLURAL:$1|raz|dwójcy|$1 raze|$1 raz}}',
	'g-give-list-friends-title' => 'Z twójeje lisćiny pśijaśelow wubraś',
	'g-give-list-select' => 'pśijaśela wubraś',
	'g-give-separator' => 'abo',
	'g-give-no-user-message' => 'Dary a myta su wjelicny nałog twójim pśijaśelam pśipóznaśe wopokazaś!',
	'g-give-no-user-title' => 'Komu coš něco dariś?',
	'g-give-to-user-title' => 'Dar "$1" wužywarjeju $2 pósłaś',
	'g-give-to-user-message' => 'Coš wužywarjeju $1 <a href="$2">něco druge dariś</a>?',
	'g-go-back' => 'Źi slědk',
	'g-imagesbelow' => 'Dołojce slěduju wobraze, kótarež se wužywaju na toś tom sedle',
	'g-large' => 'Wjeliki',
	'g-list-title' => 'Lisćina darow wužywarja $1',
	'g-main-page' => 'Głowny bok',
	'g-medium' => 'Srědny',
	'g-mediumlarge' => 'Wósrědny',
	'g-new' => 'nowy',
	'g-next' => 'Pśiducy',
	'g-previous' => 'Pjerwjejšny',
	'g-remove' => 'Wotpóraś',
	'g-remove-gift' => 'Toś ten dar wótpóraś',
	'g-remove-message' => 'Coš dar "$1" napšawdu wótpóraś?',
	'g-recent-recipients' => 'Druge aktualne dostawarje toś togo dara',
	'g-remove-success-title' => 'Sy wuspěšnje wótpórał dar "$1"',
	'g-remove-success-message' => 'Dar "$1" jo se wótpórał.',
	'g-remove-title' => '"$1" wótpóraś?',
	'g-send-gift' => 'Dar pósłaś',
	'g-select-a-friend' => 'wubjeŕ pśijaśela',
	'g-sent-title' => 'Sy pósłał dar wužywarjeju $1',
	'g-sent-message' => 'Sy pósłał slědujucy dar wužywarjeju $1.',
	'g-small' => 'Mały',
	'g-to-another' => 'Někomu drugemu daś',
	'g-uploadsuccess' => 'Nagraśe wuspěšne',
	'g-viewgiftlist' => 'Lisćinu darow se woglědaś',
	'g-your-profile' => 'Twój profil',
	'gift_received_subject' => '$1 jo śi pósłał dar $2 na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'gift_received_body' => 'Witaj $1.

$2 jo śi rowno pósłał dar $3 na {{GRAMMAR:lokatiw|{{SITENAME}}}}.

Coš powěźeńku cytaś, kótaruž $2 jo śi zawóstajił a swój dar wiźeś? Klikni na slědujucy wótkaz:

$4

Naźejamy se, až se śi spódoba!

Źěkujomy se,

team {{SITENAME}}

---

Hej, južo njocoš e-maile wót nas dostaś?

Klikni na $5
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'right-giftadmin' => 'Nowe dary napóraś a eksistěrujuce wobźěłaś',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Lou
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'giftmanager' => 'Διαχειριστής δώρων',
	'giftmanager-addgift' => '+ Προσθήκη νέου δώρου',
	'giftmanager-access' => 'πρόσβαση δώρου',
	'giftmanager-description' => 'περιγραφή δώρου',
	'giftmanager-giftimage' => 'εικόνα δώρου',
	'giftmanager-image' => 'προσθήκη/αντικατάσταση εικόνας',
	'giftmanager-giftcreated' => 'Το δώρο δημιουργήθηκε',
	'giftmanager-giftsaved' => 'Το δώρο αποθηκεύτηκε',
	'giftmanager-public' => 'δημόσιο',
	'giftmanager-private' => 'ιδιωτικός',
	'giftmanager-view' => 'Προβολή λίστας δώρων',
	'g-add-message' => 'Προσθήκη ενός μηνύματος',
	'g-back-edit-gift' => 'Πίσω στην επεξεργασία αυτού του δώρου',
	'g-back-gift-list' => 'Πίσω στη λίστα δώρων',
	'g-back-link' => '< Πίσω στη σελίδα του $1',
	'g-choose-file' => 'Επιλογή αρχείου:',
	'g-cancel' => 'Ακύρωση',
	'g-count' => 'Ο $1 έχει $2 {{PLURAL:$2|δώρο|δώρα}}.',
	'g-create-gift' => 'Δημιουργία δώρου',
	'g-created-by' => 'δημιουργήθηκε από',
	'g-current-image' => 'Τωρινή εικόνα',
	'g-description-title' => 'Το δώρο του $1 "$2"',
	'g-error-do-not-own' => 'Δεν σου ανήκει αυτό το δώρο.',
	'g-error-message-invalid-link' => 'Ο σύνδεσμος που δώσατε είναι άκυρος.',
	'g-error-message-login' => 'Πρέπει να συνδεθείτε για να δώσετε δώρα',
	'g-error-message-no-user' => 'Ο χρήστης που προσπαθείτε να δείτε δεν υπάρχει.',
	'g-error-message-to-yourself' => 'Δεν μπορείς να δώσεις ένα δώρο στον εαυτό σου.',
	'g-error-title' => 'Ουπς, πήρες μια λάθος στροφή!',
	'g-from' => 'από <a href="$1">$2</a>',
	'g-gift' => 'δώρο',
	'g-gift-name' => 'όνομα δώρου',
	'g-give-gift' => 'Δώστε δώρο',
	'g-give-all-message-title' => 'Προσθήκη ενός μηνύματος',
	'g-give-all-title' => 'Δώστε ένα δώρο στόν $1',
	'g-give-enter-friend-title' => 'Εάν γνωρίζετε το όνομα του χρήστη, πληκτρολογήστε το παρακάτω',
	'g-give-list-friends-title' => 'Επιλογή από τη λίστα φίλων σας',
	'g-give-list-select' => 'επιλέξτε έναν φίλο',
	'g-give-separator' => 'ή',
	'g-give-no-user-title' => 'Σε ποιον θα θέλατε να δώσετε ένα δώρο;',
	'g-give-to-user-title' => 'Αποστολή του δώρου "$1" στον $2',
	'g-go-back' => 'Πήγαινε πίσω',
	'g-imagesbelow' => 'Ακολουθούν οι εικόνες σας που θα χρησιμοποιηθούν στην ιστοσελίδα',
	'g-large' => 'Μεγάλος',
	'g-list-title' => 'Η λίστα δώρων του $1',
	'g-main-page' => 'Κύρια σελίδα',
	'g-medium' => 'Μέσος',
	'g-mediumlarge' => 'Μεσαίο-μεγάλο',
	'g-new' => 'νέο',
	'g-next' => 'Επομ',
	'g-previous' => 'Προηγ',
	'g-remove' => 'Αφαίρεση',
	'g-remove-gift' => 'Αφαίρεση αυτού του δώρου',
	'g-recent-recipients' => 'Άλλοι πρόσφατοι παραλήπτες αυτού του δώρου',
	'g-remove-success-title' => 'Έχετε επιτυχώς αφαιρέσει το δώρο "$1"',
	'g-remove-success-message' => 'Το δώρο "$1" έχει αφαιρεθεί.',
	'g-remove-title' => 'Διαγραφή "$1";',
	'g-send-gift' => 'Αποστολή δώρου',
	'g-select-a-friend' => 'επιλέξτε έναν φίλο',
	'g-sent-title' => 'Στείλατε ένα δώρο στον $1',
	'g-sent-message' => 'Έχεις αποστείλει το παρακάτω δώρο στο $1.',
	'g-small' => 'Μικρός',
	'g-to-another' => 'Δώστε σε κάποιον άλλο',
	'g-uploadsuccess' => 'Επιτυχής φόρτωση',
	'g-viewgiftlist' => 'Προβολή λίστας δώρων',
	'g-your-profile' => 'Το προφίλ σας',
	'gift_received_subject' => 'Ο $1 σου έστειλε το δώρο $2 στο {{SITENAME}}!',
	'gift_received_body' => 'Γεια $1.

Ο $2 μόλις σας έστειλε το δώρο $3 στο {{SITENAME}}.

Θέλετε να διαβάσετε την σημείωση $2 που σας άφησε και να δείτε το δώρο σας; Κάνετε κλικ στον παρακάτω σύνδεσμο:

$4

Ελπίζουμε να σας αρέσει!

Ευχαριστούμε,


Η ομάδα του {{SITENAME}}

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $5
και αλλάξετε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'right-giftadmin' => 'Δημιουργία νέων και υπάρχοντων δώρων',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'giftmanager' => 'Donaca administrilo',
	'giftmanager-addgift' => '+ Aldoni novan donacon',
	'giftmanager-giftcreated' => 'La donaco estis kreita',
	'giftmanager-giftsaved' => 'La donaco estis konservita',
	'giftmanager-public' => 'publika',
	'giftmanager-private' => 'privata',
	'g-add-message' => 'Aldoni mesaĝon',
	'g-back-link' => '< Reiri al paĝo de $1',
	'g-choose-file' => 'Elekti dosieron:',
	'g-cancel' => 'Nuligi',
	'g-count' => '$1 havas $2 {{PLURAL:$2|donacon|donacojn}}.',
	'g-create-gift' => 'Krei donacon',
	'g-created-by' => 'kreita de',
	'g-current-image' => 'Nuna bildo',
	'g-description-title' => 'Donaco "$2" de $1',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'donaco',
	'g-gift-name' => 'donaca nomo',
	'g-give-all-message-title' => 'Aldoni mesaĝon',
	'g-give-all-title' => 'Donaci donacon al $1',
	'g-give-list-select' => 'elekti amikon',
	'g-give-separator' => 'aŭ',
	'g-go-back' => 'Retroiri',
	'g-large' => 'Granda',
	'g-list-title' => 'Donaclisto de $1',
	'g-main-page' => 'Ĉefa paĝo',
	'g-medium' => 'Meza',
	'g-mediumlarge' => 'Mezgranda',
	'g-new' => 'nova',
	'g-next' => 'Poste',
	'g-previous' => 'Antaŭe',
	'g-remove' => 'Forigi',
	'g-remove-gift' => 'Forigi ĉi tiun donacon',
	'g-remove-title' => 'Ĉu forigi "$1"?',
	'g-send-gift' => 'Sendi donacon',
	'g-select-a-friend' => 'elekti amikon',
	'g-small' => 'Malgranda',
	'g-uploadsuccess' => 'Alŝuto sukcesis',
	'g-viewgiftlist' => 'Vidi donacliston',
	'g-your-profile' => 'Via profilo',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Mor
 */
$messages['es'] = array(
	'giftmanager' => 'Administrador de regalos',
	'giftmanager-addgift' => '+ Agregar nuevo regalo',
	'giftmanager-access' => 'acceso a regalo',
	'giftmanager-description' => 'descripción de regalo',
	'giftmanager-giftimage' => 'imagen de regalo',
	'giftmanager-image' => 'agregar/reemplazar imagen',
	'giftmanager-giftcreated' => 'El regalo ha sido creado',
	'giftmanager-giftsaved' => 'El regalo ha sido grabado',
	'giftmanager-public' => 'público',
	'giftmanager-private' => 'privado',
	'giftmanager-view' => 'Ver lista de regalos',
	'g-add-message' => 'Agregar un mensaje',
	'g-back-edit-gift' => 'Regresar a editar este regalo',
	'g-back-gift-list' => 'Regresar a lista de regalos',
	'g-back-link' => '< Regresar a la página de $1',
	'g-choose-file' => 'Escoger archivo:',
	'g-cancel' => 'Cancelar',
	'g-count' => '$1 tiene $2 {{PLURAL:$2|regalo|regalos}}.',
	'g-create-gift' => 'Crear regalo',
	'g-created-by' => 'creado por',
	'g-current-image' => 'Imagen actual',
	'g-delete-message' => 'Estás seguro de desear borrar el regalo "$1"?
Esto también lo borrará de los usuarios quienes pueden haberlo recibido.',
	'g-description-title' => '"$2" Regalos de $1',
	'g-error-do-not-own' => 'No te pertenece este regalo',
	'g-error-message-blocked' => 'Estás actualmente bloqueado y no puedes dar regalos',
	'g-error-message-invalid-link' => 'El vínculo que usted han ingresado es inválido.',
	'g-error-message-login' => 'Tienes que iniciar sesión para dar regalos',
	'g-error-message-no-user' => 'El usuario que estás tratando de ver no existe.',
	'g-error-message-to-yourself' => 'No puede darse un regalo a sí mismo.',
	'g-error-title' => 'Woops, tomó un turno erróneo!',
	'g-file-instructions' => 'La imagen debe ser jpeg, png o gif (no gif animado), y debe tener menos de 100kb de tamaño.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'regalo',
	'g-gift-name' => 'nombre de regalo',
	'g-give-gift' => 'Dar regalo',
	'g-give-all' => 'Desea dar a $1 un regalo?
Solo haga click en uno de los regaLos de abajo y haga click en "enviar regalo".
Es fácil.',
	'g-give-all-message-title' => 'Agregar un mensaje',
	'g-give-all-title' => 'De un regalo a $1',
	'g-give-enter-friend-title' => 'Si usted sabe el nombre del usuario, escríbalo debajo',
	'g-given' => 'Este regalo ha sido enviado $1 {{PLURAL:$1|vez|veces}}',
	'g-give-list-friends-title' => 'Seleccione de su lista de amigos',
	'g-give-list-select' => 'seleccione un amigo',
	'g-give-separator' => 'o',
	'g-give-no-user-message' => 'Regalos y premios son una gran forma de reconocer a sus amigos!',
	'g-give-no-user-title' => 'A quién le gustaría dar un regalo?',
	'g-give-to-user-title' => 'Enviar el regalo "$1" a $2',
	'g-give-to-user-message' => 'Desea dar $1 un <a href="$2">regalo diferente</a>?',
	'g-go-back' => 'Regrese',
	'g-imagesbelow' => 'Debajo están sus imágenes que serán usadas en el sitio',
	'g-large' => 'Grande',
	'g-list-title' => 'Lista de regalos de $1',
	'g-main-page' => 'Página principal',
	'g-medium' => 'Medio',
	'g-mediumlarge' => 'Medio-grande',
	'g-new' => 'nuevo',
	'g-next' => 'Próximo',
	'g-previous' => 'Anterior',
	'g-remove' => 'Quitar',
	'g-remove-gift' => 'Quitar este regalo',
	'g-remove-message' => '¿Está seguro de que desea quitar el regalo "$1"?',
	'g-recent-recipients' => 'Otros receptores recientes de este regalo',
	'g-remove-success-title' => 'Ha quitado exitosamente el regalo "$1"',
	'g-remove-success-message' => 'El regalo "$1" ha sido eliminado.',
	'g-remove-title' => '¿Quitar "$1"?',
	'g-send-gift' => 'Enviar regalo',
	'g-select-a-friend' => 'seleccione un amigo',
	'g-sent-title' => 'Ha enviado un regalo a $1',
	'g-sent-message' => 'Ha enviado el siguiente regalo a $1.',
	'g-small' => 'Pequeño',
	'g-to-another' => 'Dar a alguien más',
	'g-uploadsuccess' => 'Carga exirosa',
	'g-viewgiftlist' => 'Ver lista de regalos',
	'g-your-profile' => 'Su perfil',
	'gift_received_subject' => '$1 le ha enviado el regalo $2 en {{SITENAME}}!',
	'gift_received_body' => 'Hola $1.

$2 acaba de enviarte el regalo $3 en {{SITENAME}}.

Deseas leer la nota $2 que te dejó y ver tu regalo?  Haz click en el vínculo de abajo:

$4

Esperamos que te guste!

Gracias,


El equipo {{SITENAME}}

---

Hey, Deseas no recibir más correos electrónicos de nosotros?

Haz click en $5
y cambia tus configuraciones para deshabilitar notificaciones por correo electrónico.',
	'right-giftadmin' => 'Crear nuevo y editar regalos existentes',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'giftmanager-addgift' => '+ Lisa uus kingitus',
	'giftmanager-description' => 'kingituse kirjeldus',
	'giftmanager-giftimage' => 'kingituse pilt',
	'giftmanager-giftcreated' => 'Kingitus on loodud',
	'giftmanager-giftsaved' => 'Kingitus on salvestatud',
	'giftmanager-public' => 'avalik',
	'giftmanager-private' => 'privaatne',
	'giftmanager-view' => 'Vaata kingituste nimekirja',
	'g-add-message' => 'Lisa teade',
	'g-error-message-to-yourself' => 'Endale ei saa kingitust teha.',
	'g-gift' => 'kingitus',
	'g-gift-name' => 'kingituse nimi',
	'g-give-gift' => 'Anna kingitus',
	'g-give-all' => 'Tahad anda kasutajale $1 kingituse?
Kliki lihtsalt ühel kingitustest ja kliki "Saada kingitus".
Nii lihtne see ongi.',
	'g-give-all-message-title' => 'Lisa sõnum',
	'g-give-all-title' => 'Anna kingitus kasutajale $1',
	'g-give-list-friends-title' => 'Vali oma sõbraloendist',
	'g-give-list-select' => 'vali sõber',
	'g-give-separator' => 'või',
	'g-go-back' => 'Tagasi',
	'g-large' => 'Suur',
	'g-main-page' => 'Esileht',
	'g-medium' => 'Keskmine',
	'g-new' => 'uus',
	'g-next' => 'Järgmine',
	'g-previous' => 'Eelmine',
	'g-remove' => 'Eemalda',
	'g-remove-gift' => 'Eemalda see kingitus',
	'g-send-gift' => 'Saada kingitus',
	'g-select-a-friend' => 'vali sõber',
	'g-small' => 'Väike',
	'g-viewgiftlist' => 'Vaata kingituste nimekirja',
	'g-your-profile' => 'Sinu profiil',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'giftmanager-addgift' => '+ Opari berria gehitu',
	'giftmanager-description' => 'opariaren deskribapena',
	'giftmanager-giftimage' => 'opariaren irudia',
	'giftmanager-image' => 'gehitu/ordeztu irudia',
	'giftmanager-public' => 'publikoa',
	'giftmanager-private' => 'pribatua',
	'giftmanager-view' => 'Ikusi oparien zerrenda',
	'g-add-message' => 'Mezu bat erantsi',
	'g-back-gift-list' => 'Itzuli oparien zerrendara',
	'g-back-link' => '< Itzuli $1(r)en orrialdera',
	'g-cancel' => 'Utzi',
	'g-count' => '$1-(e)k {{PLURAL:$2|opari bat du|$2 opari ditu}}.',
	'g-create-gift' => 'Oparia sortu',
	'g-gift' => 'oparia',
	'g-give-gift' => 'Oparia eman',
	'g-give-list-select' => 'hautatu lagun bat',
	'g-give-separator' => 'edo',
	'g-go-back' => 'Atzera joan',
	'g-new' => 'berria',
	'g-next' => 'Hurrengoa',
	'g-previous' => 'Aurrekoa',
	'g-remove' => 'Kendu',
	'g-remove-gift' => 'Opari hau kendu',
	'g-remove-message' => 'Ziur al zaude "$1" oparia kendu nahi duzula?',
	'g-remove-title' => '"$1" kendu?',
	'g-send-gift' => 'Oparia bidali',
	'g-select-a-friend' => 'lagun bat aukeratu',
	'g-small' => 'Txikia',
	'g-viewgiftlist' => 'Ikusi oparien zerrenda',
	'g-your-profile' => 'Zure profila',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'giftmanager-public' => 'عمومی',
	'giftmanager-private' => 'خصوصی',
	'g-choose-file' => 'انتخاب پرونده:',
	'g-cancel' => 'انصراف',
	'g-give-all-message-title' => 'افزودن یک پیام',
	'g-give-separator' => 'یا',
	'g-go-back' => 'بازگشت به عقب',
	'g-large' => 'بزرگ',
	'g-main-page' => 'صفحهٔ اصلی',
	'g-medium' => 'متوسط',
	'g-mediumlarge' => 'متوسط-بزرگ',
	'g-new' => 'جدید',
	'g-next' => 'بعدی',
	'g-previous' => 'قبلی',
	'g-remove' => 'حذف',
	'g-small' => 'کوچک',
	'g-your-profile' => 'نمایهٔ شما',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'giftmanager' => 'Lahjojen hallinta',
	'giftmanager-addgift' => '+ Lisää uusi lahja',
	'giftmanager-access' => 'lahjan tyyppi',
	'giftmanager-description' => 'lahjan kuvaus',
	'giftmanager-giftimage' => 'lahjan kuva',
	'giftmanager-image' => 'lisää tai korvaa kuva',
	'giftmanager-giftcreated' => 'Lahja on luotu',
	'giftmanager-giftsaved' => 'Lahja on tallennettu',
	'giftmanager-public' => 'julkinen',
	'giftmanager-private' => 'yksityinen',
	'giftmanager-view' => 'Näytä lahjalista',
	'g-add-message' => 'Lisää viesti',
	'g-back-edit-gift' => 'Takaisin tämän lahjan muokkaamiseen',
	'g-back-gift-list' => 'Takaisin lahjalistaan',
	'g-back-link' => '< Takaisin käyttäjän $1 sivulle',
	'g-choose-file' => 'Valitse tiedosto:',
	'g-cancel' => 'Peruuta',
	'g-count' => 'Käyttäjällä $1 on $2 {{PLURAL:$2|lahja|lahjaa}}.',
	'g-create-gift' => 'Luo lahja',
	'g-created-by' => 'tehnyt',
	'g-current-image' => 'Nykyinen kuva',
	'g-delete-message' => 'Oletko varma, että haluat poistaa lahjan ”$1”?
Tämä poistaa sen myös käyttäjiltä, jotka ovat saattaneet saada sen.',
	'g-description-title' => 'Käyttäjän $1 lahja ”$2”',
	'g-error-do-not-own' => 'Et omista tätä lahjaa.',
	'g-error-message-blocked' => 'Olet tällä hetkellä muokkauseston alaisena etkä voi antaa lahjoja',
	'g-error-message-invalid-link' => 'Antamasi linkki ei kelpaa.',
	'g-error-message-login' => 'Sinun tulee kirjautua sisään antaaksesi lahjoja',
	'g-error-message-no-user' => 'Käyttäjää, jota yrität katsoa, ei ole olemassa.',
	'g-error-message-to-yourself' => 'Et voi antaa lahjaa itsellesi.',
	'g-error-title' => 'Hups, astuit harhaan!',
	'g-file-instructions' => 'Kuvasi tulee olla jpeg, png tai gif-muotoinen (ei animoituja gif-kuvia) ja sen tulee olla kooltaan alle 100Kb.',
	'g-from' => 'käyttäjältä <a href="$1">$2</a>',
	'g-gift' => 'lahja',
	'g-gift-name' => 'lahjan nimi',
	'g-give-gift' => 'Anna lahja',
	'g-give-all' => 'Haluatko antaa käyttäjälle $1 lahjan?
Napsauta vain yhtä lahjoista alempana ja napsauta ”Lähetä lahja”.
Se on helppoa.',
	'g-give-all-message-title' => 'Lisää viesti',
	'g-give-all-title' => 'Anna lahja käyttäjälle $1',
	'g-give-enter-friend-title' => 'Jos tiedät käyttäjän nimen, kirjoita se alapuolelle',
	'g-given' => 'Tämä lahja on annettu $1 {{PLURAL:$1|kerran|kertaa}}',
	'g-give-list-friends-title' => 'Valitse ystävälistaltasi',
	'g-give-list-select' => 'valitse ystävä',
	'g-give-separator' => 'tai',
	'g-give-no-user-message' => 'Lahjat ja palkinnot ovat loistava tapa huomioida ystäviäsi!',
	'g-give-no-user-title' => 'Kenelle haluaisit antaa lahjan?',
	'g-give-to-user-title' => 'Lähetä lahja ”$1” käyttäjälle $2',
	'g-give-to-user-message' => 'Haluatko antaa käyttäjälle $1 <a href="$2">erilaisen lahjan</a>?',
	'g-go-back' => 'Palaa takaisin',
	'g-imagesbelow' => 'Alapuolella ovat kuvasi, joita käytetään sivustolla',
	'g-large' => 'Suuri',
	'g-list-title' => 'Käyttäjän $1 lahjalista',
	'g-main-page' => 'Etusivu',
	'g-medium' => 'Keskikokoinen',
	'g-mediumlarge' => 'Keskikokoinen – suuri',
	'g-new' => 'uusi',
	'g-next' => 'Seuraava',
	'g-previous' => 'Edell.',
	'g-remove' => 'Poista',
	'g-remove-gift' => 'Poista tämä lahja',
	'g-remove-message' => 'Oletko varma, että haluat poistaa lahjan ”$1”?',
	'g-recent-recipients' => 'Muut tämän lahjan tuoreet saajat',
	'g-remove-success-title' => 'Olet onnistuneesti poistanut lahjan ”$1”',
	'g-remove-success-message' => 'Lahja ”$1” on poistettu.',
	'g-remove-title' => 'Poista ”$1”?',
	'g-send-gift' => 'Lähetä lahja',
	'g-select-a-friend' => 'valitse ystävä',
	'g-sent-title' => 'Olet lähettänyt lahjan käyttäjälle $1',
	'g-sent-message' => 'Olet lähettänyt seuraavan lahjan käyttäjälle $1.',
	'g-small' => 'Pieni',
	'g-to-another' => 'Anna jollekulle muulle',
	'g-uploadsuccess' => 'Tallentaminen onnistui',
	'g-viewgiftlist' => 'Näytä lahjalista',
	'g-your-profile' => 'Profiilisi',
	'gift_received_subject' => '$1 on lähettänyt sinulle lahjan $2 {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'gift_received_body' => 'Hei $1:

$2 juuri lähetti sinulle $3-lahjan {{GRAMMAR:inessive|{{SITENAME}}}}.

Haluatko lukea viestin, jonka $2 jätti sinulle ja nähdä lahjasi?   Napsauta linkkiä alapuolella:

$4

Toivomme, että pidät siitä!

Kiittäen,


{{GRAMMAR:genitive|{{SITENAME}}}} tiimi

---

Hei, etkö halua enää saada sähköposteja meiltä?

Napsauta $5
ja muuta asetuksiasi poistaaksesi sähköpostitoiminnot käytöstä.',
	'right-giftadmin' => 'Luoda uusia ja muokata olemassa olevia lahjoja',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author Od1n
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'giftmanager' => 'Gestionnaire de cadeaux',
	'giftmanager-addgift' => '+ Ajouter un cadeau',
	'giftmanager-access' => 'accès au cadeau',
	'giftmanager-description' => 'description du cadeau',
	'giftmanager-giftimage' => 'image du cadeau',
	'giftmanager-image' => 'ajouter ou remplacer l’image',
	'giftmanager-giftcreated' => 'Le cadeau a été créé',
	'giftmanager-giftsaved' => 'Le cadeau a été sauvegardé',
	'giftmanager-public' => 'public',
	'giftmanager-private' => 'privé',
	'giftmanager-view' => 'Voir la liste des cadeaux',
	'g-add-message' => 'Ajouter un message',
	'g-back-edit-gift' => 'Revenir à la modification de ce cadeau',
	'g-back-gift-list' => 'Revenir à la liste des cadeaux',
	'g-back-link' => '< Revenir à la page de $1',
	'g-choose-file' => 'Choisir le fichier :',
	'g-cancel' => 'Annuler',
	'g-count' => '$1 a $2 cadeau{{PLURAL:$2||x}}.',
	'g-create-gift' => 'Créer un cadeau',
	'g-created-by' => 'créé par',
	'g-current-image' => 'Image actuelle',
	'g-delete-message' => 'Êtes-vous certain{{GENDER:||e|(e)}} de vouloir supprimer le cadeau « $1 » ? Ceci va également le supprimer des utilisateurs qui l’ont reçu.',
	'g-description-title' => 'Cadeau « $2 » de la part de $1',
	'g-error-do-not-own' => 'Vous ne possédez pas ce cadeau.',
	'g-error-message-blocked' => 'Vous êtes bloqué{{GENDER:||e|(e)}} et ne pouvez donc pas donner de cadeaux',
	'g-error-message-invalid-link' => 'Le lien que vous avez fourni est invalide.',
	'g-error-message-login' => 'Vous devez vous connecter pour donner des cadeaux',
	'g-error-message-no-user' => 'L’utilisateur que vous essayez de voir n’existe pas.',
	'g-error-message-to-yourself' => 'Vous ne pouvez pas vous donner un cadeau à vous-même.',
	'g-error-title' => 'Oups, vous avez pris un mauvais virage !',
	'g-file-instructions' => 'Votre image doit être au format jpeg, png ou gif (non animé) et sa taille ne doit pas dépasser 100 ko.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'cadeau',
	'g-gift-name' => 'nom du cadeau',
	'g-give-gift' => 'Donner le cadeau',
	'g-give-all' => 'Envie de donner un cadeau à $1 ? Cliquez sur un cadeau ci-dessous et cliquez ensuite sur « {{int:g-send-gift}} ». C’est facile.',
	'g-give-all-message-title' => 'Ajouter un message',
	'g-give-all-title' => 'Donner un cadeau à $1',
	'g-give-enter-friend-title' => 'Si vous connaissez le nom de l’utilisateur, entrez-le ci-dessous',
	'g-given' => 'Ce cadeau a été donné {{PLURAL:$1|une|$1}} fois',
	'g-give-list-friends-title' => 'Sélectionnez depuis la liste de vos amis',
	'g-give-list-select' => 'sélectionnez un ami',
	'g-give-separator' => 'ou',
	'g-give-no-user-message' => 'Les cadeaux et les prix sont bien pour faire connaitre vos amis !',
	'g-give-no-user-title' => 'À qui voulez-vous donner un cadeau ?',
	'g-give-to-user-title' => 'Envoyer le cadeau « $1 » à $2',
	'g-give-to-user-message' => 'Envie de donner <a href="$2">un cadeau différent</a> à $1 ?',
	'g-go-back' => 'Revenir',
	'g-imagesbelow' => 'Les images qui seront utilisées sur le site sont affichées ci-dessous',
	'g-large' => 'Grand',
	'g-list-title' => 'Liste des cadeaux de $1',
	'g-main-page' => 'Accueil',
	'g-medium' => 'Moyen',
	'g-mediumlarge' => 'Moyen-grand',
	'g-new' => 'nouveau',
	'g-next' => 'Suivant',
	'g-previous' => 'Précédent',
	'g-remove' => 'Enlever',
	'g-remove-gift' => 'Enlever ce cadeau',
	'g-remove-message' => 'Êtes-vous sûr(e) de vouloir enlever le cadeau « $1 » ?',
	'g-recent-recipients' => 'Autres bénéficiaires récents de ce cadeau',
	'g-remove-success-title' => 'Vous avez enlevé avec succès le cadeau « $1 »',
	'g-remove-success-message' => 'Le cadeau « $1 » a été enlevé.',
	'g-remove-title' => 'Enlever « $1 » ?',
	'g-send-gift' => 'Envoyer le cadeau',
	'g-select-a-friend' => 'sélectionnez un ami',
	'g-sent-title' => 'Vous avez envoyé le cadeau à $1',
	'g-sent-message' => 'Vous avez envoyé le cadeau suivant à $1.',
	'g-small' => 'Petit',
	'g-to-another' => 'Donner à quelqu’un d’autre',
	'g-uploadsuccess' => 'Téléversement effectué avec succès',
	'g-viewgiftlist' => 'Voir la liste des cadeaux',
	'g-your-profile' => 'Votre profil',
	'gift_received_subject' => '$1 vous a envoyé le cadeau $2 sur {{SITENAME}} !',
	'gift_received_body' => 'Bonjour $1,

$2 vient de vous envoyer le cadeau $3 sur {{SITENAME}}.

Pour lire la note $2 qui vous est adressée et voir votre cadeau, cliquez sur le lien ci-dessous :

$4

Nous espérons que vous l’apprécierez !

Merci,


L’équipe de {{SITENAME}}

---

Vous ne voulez plus recevoir de courriels de notre part ?

Cliquez $5
et modifiez vos préférences pour désactiver les notifications par courriel.',
	'right-giftadmin' => 'Créer ou modifier des cadeaux',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'giftmanager' => 'Administrator de presents',
	'giftmanager-addgift' => '+ Apondre un present novél',
	'giftmanager-access' => 'accès u present',
	'giftmanager-description' => 'dèscripcion du present',
	'giftmanager-giftimage' => 'émâge du present',
	'giftmanager-image' => 'apondre / remplaciér l’émâge',
	'giftmanager-giftcreated' => 'Lo present at étâ fêt',
	'giftmanager-giftsaved' => 'Lo present at étâ sôvâ',
	'giftmanager-public' => 'publico',
	'giftmanager-private' => 'privâ',
	'giftmanager-view' => 'Vêre la lista des presents',
	'g-add-message' => 'Apondre un mèssâjo',
	'g-back-edit-gift' => 'Tornar u changement de ceti present',
	'g-back-gift-list' => 'Tornar a la lista des presents',
	'g-back-link' => '< Tornar a la pâge a $1',
	'g-choose-file' => 'Chouèsir lo fichiér :',
	'g-cancel' => 'Anular',
	'g-count' => '$1 at $2 present{{PLURAL:$2||s}}.',
	'g-create-gift' => 'Fâre un present',
	'g-created-by' => 'fêt per',
	'g-current-image' => 'Émâge d’ora',
	'g-description-title' => 'Present « $2 » a $1',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'present',
	'g-gift-name' => 'nom du present',
	'g-give-gift' => 'Balyér lo present',
	'g-give-all-message-title' => 'Apondre un mèssâjo',
	'g-give-all-title' => 'Balyér un present a $1',
	'g-give-list-friends-title' => 'Chouèsésséd dês la lista a voutros amis',
	'g-give-list-select' => 'chouèsésséd un ami',
	'g-give-separator' => 'ou ben',
	'g-give-to-user-title' => 'Mandar lo present « $1 » a $2',
	'g-go-back' => 'Tornar',
	'g-large' => 'Grant',
	'g-list-title' => 'Lista des presents a $1',
	'g-main-page' => 'Reçua',
	'g-medium' => 'Moyen',
	'g-mediumlarge' => 'Moyen-grant',
	'g-new' => 'novél',
	'g-next' => 'Aprés',
	'g-previous' => 'Devant',
	'g-remove' => 'Enlevar',
	'g-remove-gift' => 'Enlevar ceti present',
	'g-remove-title' => 'Enlevar « $1 » ?',
	'g-send-gift' => 'Mandar lo present',
	'g-select-a-friend' => 'chouèsésséd un ami',
	'g-sent-title' => 'Vos éd mandâ lo present a $1',
	'g-small' => 'Petiôt',
	'g-to-another' => 'Balyér a quârqu’un d’ôtro',
	'g-uploadsuccess' => 'Tèlèchargement reussi',
	'g-viewgiftlist' => 'Vêre la lista des presents',
	'g-your-profile' => 'Voutron profil',
	'gift_received_subject' => '$1 vos at mandâ lo present $2 dessus {{SITENAME}} !',
	'right-giftadmin' => 'Fâre ou ben changiér des presents',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 */
$messages['fy'] = array(
	'g-cancel' => 'Ofbrekke',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'giftmanager' => 'Xestor de agasallos',
	'giftmanager-addgift' => '+ Engadir un novo agasallo',
	'giftmanager-access' => 'acceso ao agasallo',
	'giftmanager-description' => 'descrición do agasallo',
	'giftmanager-giftimage' => 'imaxe do agasallo',
	'giftmanager-image' => 'engadir/substituír a imaxe',
	'giftmanager-giftcreated' => 'O agasallo foi creado',
	'giftmanager-giftsaved' => 'O agasallo foi gardado',
	'giftmanager-public' => 'público',
	'giftmanager-private' => 'privado',
	'giftmanager-view' => 'Ver a lista de agasallos',
	'g-add-message' => 'Engadir unha mensaxe',
	'g-back-edit-gift' => 'Volver á edición deste agasallo',
	'g-back-gift-list' => 'Volver á lista de agasallos',
	'g-back-link' => '< Volver á páxina de $1',
	'g-choose-file' => 'Elixir o ficheiro:',
	'g-cancel' => 'Cancelar',
	'g-count' => '$1 ten {{PLURAL:$2|un agasallo|$2 agasallos}}.',
	'g-create-gift' => 'Crear un agasallo',
	'g-created-by' => 'creado por',
	'g-current-image' => 'Imaxe actual',
	'g-delete-message' => 'Está seguro de querer eliminar o agasallo "$1"? Isto tamén o borrará dos usuarios que o recibiron.',
	'g-description-title' => 'Agasallo "$2" de $1',
	'g-error-do-not-own' => 'Non é o dono deste agasallo.',
	'g-error-message-blocked' => 'Actualmente está bloqueado e non pode dar agasallos',
	'g-error-message-invalid-link' => 'A ligazón que inseriu é inválida.',
	'g-error-message-login' => 'Debe acceder ao sistema para agasallar',
	'g-error-message-no-user' => 'O usuario que intenta ver non existe.',
	'g-error-message-to-yourself' => 'Non se pode agasallar a si mesmo.',
	'g-error-title' => 'Vaites, tomou un xiro erróneo!',
	'g-file-instructions' => 'A súa imaxe debe ser jpeg, png ou gif (que non sexan animados), e debe ter un tamaño menor de 100kb.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'agasallo',
	'g-gift-name' => 'nome do agasallo',
	'g-give-gift' => 'Dar o agasallo',
	'g-give-all' => 'Quere agasallar a $1? Prema nun dos agasallos de embaixo e logo en "Enviar o agasallo". Así de sinxelo.',
	'g-give-all-message-title' => 'Engadir unha mensaxe',
	'g-give-all-title' => 'Darlle un agasallo a $1',
	'g-give-enter-friend-title' => 'Se sabe o nome do usuario, insírao embaixo',
	'g-given' => 'Este agasallo foi entregado {{PLURAL:$1|unha vez|$1 veces}}',
	'g-give-list-friends-title' => 'Seleccione da súa lista de amigos',
	'g-give-list-select' => 'seleccionar un amigo',
	'g-give-separator' => 'ou',
	'g-give-no-user-message' => 'Os agasallos e premios son un fantástico modo de recoñecer o labor dos seus amigos!',
	'g-give-no-user-title' => 'A quen quere agasallar?',
	'g-give-to-user-title' => 'Enviar o agasallo "$1" a $2',
	'g-give-to-user-message' => 'Quere darlle a $1 un <a href="$2">agasallo diferente</a>?',
	'g-go-back' => 'Volver',
	'g-imagesbelow' => 'Embaixo están as súas imaxes, que serán usadas no sitio',
	'g-large' => 'Grande',
	'g-list-title' => 'Lista de agasallos de $1',
	'g-main-page' => 'Portada',
	'g-medium' => 'Mediano',
	'g-mediumlarge' => 'Mediano-Grande',
	'g-new' => 'novo',
	'g-next' => 'Seguinte',
	'g-previous' => 'Previo',
	'g-remove' => 'Eliminar',
	'g-remove-gift' => 'Eliminar este agasallo',
	'g-remove-message' => 'Está seguro de querer eliminar o agasallo "$1"?',
	'g-recent-recipients' => 'Outros receptores recentes deste agasallo',
	'g-remove-success-title' => 'Eliminou con éxito o agasallo "$1"',
	'g-remove-success-message' => 'O agasallo "$1" foi eliminado.',
	'g-remove-title' => 'Quere eliminar "$1"?',
	'g-send-gift' => 'Enviar o agasallo',
	'g-select-a-friend' => 'seleccionar un amigo',
	'g-sent-title' => 'Envioulle un agasallo a $1',
	'g-sent-message' => 'Envioulle o seguinte agasallo a $1.',
	'g-small' => 'Pequeno',
	'g-to-another' => 'Agasallar a alguén',
	'g-uploadsuccess' => 'Carga exitosa',
	'g-viewgiftlist' => 'Ver a lista de agasallos',
	'g-your-profile' => 'O seu perfil',
	'gift_received_subject' => '$1 envioulle o agasallo $2 en {{SITENAME}}!',
	'gift_received_body' => 'Ola $1:

$2 acaba de enviarlle o agasallo $3 en {{SITENAME}}.

Quere ler a nota $2 que lle deixaron e ver o seu agasallo?  Prema na ligazón de embaixo:

$4

Agardamos que lle guste!

Grazas,

O equipo de {{SITENAME}}

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $5
e troque as súas configuracións para desactivar as notificacións por correo electrónico.',
	'right-giftadmin' => 'Crear novos agasallos e editar os existentes',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'giftmanager-public' => 'δημοσία',
	'giftmanager-private' => 'ἰδιωτική',
	'g-choose-file' => 'Ἐπιλέγειν ἀρχεῖον:',
	'g-cancel' => 'Ἀκυροῦν',
	'g-current-image' => 'Παροῦσα εἰκών',
	'g-gift' => 'δῶρον',
	'g-give-separator' => 'ἢ',
	'g-large' => 'Εὐμέγεθες',
	'g-main-page' => 'Κυρία δέλτος',
	'g-medium' => 'Μέσον',
	'g-mediumlarge' => 'Μέσον-μέγα',
	'g-new' => 'Νέα',
	'g-next' => 'Ἑπoμ',
	'g-previous' => 'Προηγ',
	'g-small' => 'Σμικρόν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'giftmanager' => 'Gschänkverwaltig',
	'giftmanager-addgift' => '+ E nej Gschänk dezuefiege',
	'giftmanager-access' => 'Fortschritt',
	'giftmanager-description' => 'Gschänkbschryybig',
	'giftmanager-giftimage' => 'Bild vum Gschänk',
	'giftmanager-image' => 'Bild dryysetze /useneh',
	'giftmanager-giftcreated' => 'S Gschänk isch aagleit wore',
	'giftmanager-giftsaved' => 'S Gschänk isch gspycheret wore',
	'giftmanager-public' => 'effentli',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'D Gschänklischt aaluege',
	'g-add-message' => 'Fieg e Nochricht dezue',
	'g-back-edit-gift' => 'Zrugg zum Bearbeite vu däm Gschänk',
	'g-back-gift-list' => 'Zrugg zue dr Gschänklischt',
	'g-back-link' => '< Zrugg zum Profil vu $1',
	'g-choose-file' => 'Wehl Datei:',
	'g-cancel' => 'Abbräche',
	'g-count' => '$1 het $2 {{PLURAL:$2|Gschänk|Gschänk}}.',
	'g-create-gift' => 'Gschänk aalege',
	'g-created-by' => 'aagleit vu',
	'g-current-image' => 'Aktuäll Bild',
	'g-delete-message' => 'Bisch sicher, ass Du s "$1" witt lesche? Derno wird s au bi Benutzer glescht, wu s villicht iberchu hän.',
	'g-description-title' => 'S Gschänk "$2" vu $1',
	'g-error-do-not-own' => 'Dir ghert des Gschänk nit.',
	'g-error-message-blocked' => 'Du bisch im Momänt gsperrt un chasch kei Gschänk mache',
	'g-error-message-invalid-link' => 'S Gleich, wu Du yygee hesch, isch nit giltig.',
	'g-error-message-login' => 'Du muesch aagmäldet syy go Gschänk mache',
	'g-error-message-no-user' => 'Dää Benutzer, wu Du witt aelueg, git s nit.',
	'g-error-message-to-yourself' => 'Du chasch Dir nit sälber e Gschänk mache.',
	'g-error-title' => 'Hoppla, do lauft ebis scheps!',
	'g-file-instructions' => 'S Bild muess e „jpeg“, „png“, „gif“ (kei animiert) syy, un e Dateigreßi haa, wu chleiner isch wie 100 kb.',
	'g-from' => 'vu <a href="$1">$2</a>',
	'g-gift' => 'Gschänk',
	'g-gift-name' => 'Gschänkname',
	'g-give-gift' => 'Schänke',
	'g-give-all' => 'Witt $1 e Gschänk mache? Nume uf eis vu dr Gschänk unte drucke und uf „Gschänk schicke” drucke. Eso eifach goht s!',
	'g-give-all-message-title' => 'E Nochricht zuefiege',
	'g-give-all-title' => 'Mach $1 e Gschänk',
	'g-give-enter-friend-title' => 'Wänn Du dr Benutzername vum Benutzer weisch, no trag en unten yy',
	'g-given' => 'Des Gschänk isch scho $1 {{PLURAL:$1|Mol|Mol}} verschänkt wore',
	'g-give-list-friends-title' => 'Wehl us Dyynere Fryndlischt',
	'g-give-list-select' => 'wehl e Frynd uus',
	'g-give-separator' => 'oder',
	'g-give-no-user-message' => 'Gschänk un Uuszeichnige sin e scheni Art Dyyne Frynd e Freid z mache!',
	'g-give-no-user-title' => 'Wäm wetsch ebis schänke?',
	'g-give-to-user-title' => 'Schick s Gschänk "$1" an $2',
	'g-give-to-user-message' => 'Wetsch $1 e <a href="$2">ander Gschänk</a> gee?',
	'g-go-back' => 'Gang zrugg',
	'g-imagesbelow' => 'Do unte chemme alli Bilder, wu uf däre Syte bruucht wäre',
	'g-large' => 'Groß',
	'g-list-title' => 'D Gschänklischt vu $1',
	'g-main-page' => 'Hauptsyte',
	'g-medium' => 'Mittel',
	'g-mediumlarge' => 'Mittelgroß',
	'g-new' => 'nej',
	'g-next' => 'Negscht',
	'g-previous' => 'Vorig',
	'g-remove' => 'Useneh',
	'g-remove-gift' => 'Des Gschänk useneh',
	'g-remove-message' => 'Bisch sicher, ass Du s Gschänk "$1" wetsch useneh?',
	'g-recent-recipients' => 'Andere Empfänger vu däm Gschänk',
	'g-remove-success-title' => 'Du hesch s Gschänk "$1" erfolgryych usegnuh',
	'g-remove-success-message' => 'S Gschänk "$1" isch usegnuh wore.',
	'g-remove-title' => '„$1“ useneh?',
	'g-send-gift' => 'Gschänk schicke',
	'g-select-a-friend' => 'wehl e Frynd uus',
	'g-sent-title' => 'Du hesch e Gschänk an $1 gschickt',
	'g-sent-message' => 'Du hesch des Gschänk an $1 gschickt:',
	'g-small' => 'Chlei',
	'g-to-another' => 'Eber anderem schänke',
	'g-uploadsuccess' => 'erfolgryych uffeglade',
	'g-viewgiftlist' => 'D Gschänklischt aaluege',
	'g-your-profile' => 'Dyy Profil',
	'gift_received_subject' => '$1 het Dir uf {{SITENAME}} $2 gschänkt!',
	'gift_received_body' => 'Sali $1:

$2 het Dir grad $3 gschänkt uf {{SITENAME}}.

Wetsch d Notiz läse, wu $2 Dir derzue gschribe het un, un Dyy Gschänk bschaue?  Druck s Gleich do unte:

$4

Mir hoffe, s gfallt Dir!

Dankschen,


D Lyt vum {{SITENAME}}
---

Ha, Du wetsch gar keini E-Mail meh iberchu vun is?

Druck $5
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge verhindere.',
	'right-giftadmin' => 'Leg neji Gschänk aa un bearbeit sonigi, wu s scho het',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'g-cancel' => 'Soke',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'giftmanager' => 'מנהל מתנות',
	'giftmanager-addgift' => '+ הוספת מתנה חדשה',
	'giftmanager-access' => 'גישה למתנה',
	'giftmanager-description' => 'תיאור המתנה',
	'giftmanager-giftimage' => 'תמונת המתנה',
	'giftmanager-image' => 'הוספת/החלפת תמונה',
	'giftmanager-giftcreated' => 'המתנה נוצרה',
	'giftmanager-giftsaved' => 'המתנה נשמרה',
	'giftmanager-public' => 'ציבורי',
	'giftmanager-private' => 'פרטי',
	'giftmanager-view' => 'צפייה ברשימת המתנות',
	'g-add-message' => 'הוספת הודעה',
	'g-back-edit-gift' => 'חזרה לעריכת מתנה זו',
	'g-back-gift-list' => 'חזרה לרשימת המתנות',
	'g-back-link' => '< חזרה לדף של $1',
	'g-choose-file' => 'בחירת קובץ:',
	'g-cancel' => 'ביטול',
	'g-count' => 'ל־$1 יש {{PLURAL:$2|מתנה אחת|$2 מתנות}}.',
	'g-create-gift' => 'יצירת מתנה',
	'g-created-by' => 'נוצרה על ידי',
	'g-current-image' => 'התמונה הנוכחית',
	'g-delete-message' => 'האם אתם באמת רוצים למחוק את המתנה "$1"?
פעולה זו תמחק את המתנה גם מהמשתמשים שקיבלו אותה.',
	'g-description-title' => 'המתנה של $1 "$2"',
	'g-error-do-not-own' => 'אינכם הבעלים של מתנה זו.',
	'g-error-message-blocked' => 'אתם חסומים ואינכם יכולים להעניק מתנות',
	'g-error-message-invalid-link' => 'הקישור שכתבתם אינו תקין.',
	'g-error-message-login' => 'עליכם להיכנס לחשבון כדי להעניק מתנות',
	'g-error-message-no-user' => 'המשתמש שאתם מנסים לצפות בו אינו קיים.',
	'g-error-message-to-yourself' => 'אינכם יכולים להעניק מתנה לעצמכם.',
	'g-error-title' => 'אופס, טעות בפנייה!',
	'g-file-instructions' => 'על תמונתכם להיות מסוג jpeg, png או gif (לא מונפש), ועליה להיות קטנה מ־100 קילו־בייט.',
	'g-from' => 'מ־<a href="$1">$2</a>',
	'g-gift' => 'מתנה',
	'g-gift-name' => 'שם המתנה',
	'g-give-gift' => 'הענקת מתנה',
	'g-give-all' => 'מעוניינים לתת ל־$1 מתנה?
פשוט לחצו על אחת מהמתנות שלהלן ולחצו על "שליחת מתנה".
זה באמת קל.',
	'g-give-all-message-title' => 'הוספת הודעה',
	'g-give-all-title' => 'הענקת מתנה ל־$1',
	'g-give-enter-friend-title' => 'אם אתם יודעים את שם המשתמש, הקלידו אותו בתיבה שלהלן',
	'g-given' => 'מתנה זו הוענקה {{PLURAL:$1|פעם אחת|$1 פעמים}}',
	'g-give-list-friends-title' => 'בחירה מרשימת החברים שלכם',
	'g-give-list-select' => 'בחירת חבר',
	'g-give-separator' => 'או',
	'g-give-no-user-message' => 'מתנות ופרסים הינן דרך מעולה להוקיר את חבריכם!',
	'g-give-no-user-title' => 'למי ברצונכם לתת את המתנה הזו?',
	'g-give-to-user-title' => 'שליחת המתנה "$1" ל־$2',
	'g-give-to-user-message' => 'מעוניינים להעניק ל־$1 <a href="$2">מתנה אחרת</a>?',
	'g-go-back' => 'חזרה',
	'g-imagesbelow' => 'להלן תמונותיכם שתשמשנה באתר',
	'g-large' => 'גדולה',
	'g-list-title' => 'רשימת המתנות של $1',
	'g-main-page' => 'הדף הראשי',
	'g-medium' => 'בינונית',
	'g-mediumlarge' => 'בינונית־גדולה',
	'g-new' => 'חדשה',
	'g-next' => 'הבא',
	'g-previous' => 'הקודם',
	'g-remove' => 'הסרה',
	'g-remove-gift' => 'הסרת מתנה זו',
	'g-remove-message' => 'האם אתם בטוחים שברצונם להסיר את המתנה "$1"?',
	'g-recent-recipients' => 'משתמשים שקיבלו את המתנה לאחרונה גם כן',
	'g-remove-success-title' => 'הסרתם בהצלחה את המתנה "$1"',
	'g-remove-success-message' => 'המתנה "$1" הוסרה.',
	'g-remove-title' => 'האם להסיר את "$1"?',
	'g-send-gift' => 'שליחת מתנה',
	'g-select-a-friend' => 'בחירת חבר',
	'g-sent-title' => 'שלחתם מתנה ל־$1',
	'g-sent-message' => 'שלחתם את המתנה הבאה ל־$1.',
	'g-small' => 'קטנה',
	'g-to-another' => 'העניקו למישהו אחר',
	'g-uploadsuccess' => 'ההעלאה הושלמה',
	'g-viewgiftlist' => 'צפייה ברשימת המתנות',
	'g-your-profile' => 'הפרופיל שלך',
	'gift_received_subject' => 'המתנה $2 נשלחה אליך מאת $1 ב{{grammar:תחילית|{{SITENAME}}}}!',
	'gift_received_body' => 'שלום $1.

כרגע נשלחה אליכם המתנה $3 מ$2 ב{{grammar:תחילית|{{SITENAME}}}}.

מעוניינים לקרוא את ההערה שנכתבה על ידי $2 ולצפות במתנה שלכם? לחצו על הקישור שלהלן:

$4

אנו מקווים שתאהבו אותה!

תודה,

צוות {{SITENAME}}

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו על $5
ושנו את הגדרותיכם כדי לבטל הודעות בדוא"ל.',
	'right-giftadmin' => 'יצירת מתנות חדשות ועריכת מתנות קיימות',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'giftmanager' => 'Zrjadowak darow',
	'giftmanager-addgift' => '+ Nowy dar přidać',
	'giftmanager-access' => 'přistup k darej',
	'giftmanager-description' => 'wopisanje dara',
	'giftmanager-giftimage' => 'wobraz dara',
	'giftmanager-image' => 'wobraz přidać/narunać',
	'giftmanager-giftcreated' => 'Dar bu wutworjeny',
	'giftmanager-giftsaved' => 'Dar bu składowany',
	'giftmanager-public' => 'zjawny',
	'giftmanager-private' => 'priwatny',
	'giftmanager-view' => 'Lisćinu darow sej wobhladać',
	'g-add-message' => 'Powěsć přidać',
	'g-back-edit-gift' => 'Wróćo k wobdźěłanju tutoho dara',
	'g-back-gift-list' => 'Wróćo k lisćinje darow',
	'g-back-link' => '< Wróćo k stronje wužiwarja $1',
	'g-choose-file' => 'Wubjer dataju:',
	'g-cancel' => 'Přetorhnyć',
	'g-count' => '$1 ma $2 {{PLURAL:$2|dar|daraj|dary|darow}}.',
	'g-create-gift' => 'Dar wutworić',
	'g-created-by' => 'wutworjeny wot',
	'g-current-image' => 'Aktualny wobraz',
	'g-delete-message' => 'Chceš woprawdźe dar "$1" wušmórnyć?
To wušmórnje jón tež z wužiwarjow, kotřiž su jón dostali.',
	'g-description-title' => 'Dar "$2" wužiwarja $1',
	'g-error-do-not-own' => 'Tutón dar njewobsedźiš.',
	'g-error-message-blocked' => 'Sy tuchwilu zablokowany a njemóžeš ničo darić',
	'g-error-message-invalid-link' => 'Wotkaz, kotryž sy zapodał, je njepłaćiwy.',
	'g-error-message-login' => 'Dyrbiš so přizjewić, zo by něšto darił',
	'g-error-message-no-user' => 'Wužiwar, kotrehož pospytuješ sej wobhladać, njeeksistuje.',
	'g-error-message-to-yourself' => 'Njemóžeš sej samomu ničo darić.',
	'g-error-title' => 'Hopla, sy něšto wopak činił!',
	'g-file-instructions' => 'Twój wobraz dyrbi typ jpeg, png abo gif (žane animěrowane gif) měć a dyrbi mjeńši hač 100 kb wulki być.',
	'g-from' => 'z <a href="$1">$2</a>',
	'g-gift' => 'dar',
	'g-gift-name' => 'mjeno dara',
	'g-give-gift' => 'Darić',
	'g-give-all' => 'Chceš wužiwarjej $1 něšsto darić?
Klikń prosće na jedyn ze slědowacych darow a na "Dar pósłać".
Je to cyle lochko.',
	'g-give-all-message-title' => 'Powěsć přidać',
	'g-give-all-title' => 'Wužiwarjej $1 něšto darić',
	'g-give-enter-friend-title' => 'Jeli wěš mjeno wužiwarja, zapisaj jo deleka',
	'g-given' => 'Tutón dar bu {{PLURAL:$1|jedyn raz|dwójce|$1 razy|$1 razow}} wudaty',
	'g-give-list-friends-title' => 'Z lisćiny twojich přećelow wubrać',
	'g-give-list-select' => 'přećela wubrać',
	'g-give-separator' => 'abo',
	'g-give-no-user-message' => 'Dary a myta su wulkotne wašnje, zo by swojim přećelam připóznaće wopokazał!',
	'g-give-no-user-title' => 'Komu chceš něšto darić?',
	'g-give-to-user-title' => 'Dar "$1" wužiwarjej $2 pósłać',
	'g-give-to-user-message' => 'Chceš wužiwarjej $1 <a href="$2">něšto druhe darić</a>?',
	'g-go-back' => 'Wróćo hić',
	'g-imagesbelow' => 'Deleka slěduja twoje wobrazy, kotrež budu so na tutym sydle wužiwać',
	'g-large' => 'Wulki',
	'g-list-title' => 'Lisćina darow wužiwarja $1',
	'g-main-page' => 'Hłowna strona',
	'g-medium' => 'Srěni',
	'g-mediumlarge' => 'Srěnjowulki',
	'g-new' => 'nowy',
	'g-next' => 'Přichodny',
	'g-previous' => 'Předchadny',
	'g-remove' => 'Wotstronić',
	'g-remove-gift' => 'Tutón dar wotstronić',
	'g-remove-message' => 'Chceš dar "$1" woprawdźe wotstronić?',
	'g-recent-recipients' => 'Druzy aktualni přijimowarjo tutoho dara',
	'g-remove-success-title' => 'Sy dar "$1" wuspěšnje wotstronił',
	'g-remove-success-message' => 'Dar "$1" bu wotstronjeny.',
	'g-remove-title' => '"$1" wotstronić?',
	'g-send-gift' => 'Dar pósłać',
	'g-select-a-friend' => 'přećela wubrać',
	'g-sent-title' => 'Sy wužiwarjej $1 dar pósłał',
	'g-sent-message' => 'Sy slědowacy dar wužiwarjej $1 pósłał.',
	'g-small' => 'Mały',
	'g-to-another' => 'Někomu druhemu dać',
	'g-uploadsuccess' => 'Nahraće wuspěšne',
	'g-viewgiftlist' => 'Lisćinu darow sej wobhladać',
	'g-your-profile' => 'Twój profil',
	'gift_received_subject' => '$1 je ći dar $2 na {{GRAMMAR:lokatiw|{{SITENAME}}}} pósłał.',
	'gift_received_body' => 'Witaj $1.

$2 je ći runje dar $3 na {{GRAMMAR:lokatiw|{{SITENAME}}}} pósłał.

Chceš zdźělenku čitać, kotruž $2 je ći zawostajił a swój dar widźeć? Klikń na slědowacy wotkaz:

$4

Nadźijamy so, zo so ći spodoba!

Dźakujemy so,

team {{SITENAME}}

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $5
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'right-giftadmin' => 'Nowe dary wutworić a eksistowace wobdźěłać',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'giftmanager' => 'Ajándékkezelő',
	'giftmanager-addgift' => '+ új ajándék hozzáadása',
	'giftmanager-access' => 'hozzáférés az ajándékhoz',
	'giftmanager-description' => 'ajándék leírása',
	'giftmanager-giftimage' => 'ajándék képe',
	'giftmanager-image' => 'kép hozzáadása/lecserélése',
	'giftmanager-giftcreated' => 'Az ajándék elkészült',
	'giftmanager-giftsaved' => 'Az ajándék elmentve',
	'giftmanager-public' => 'nyilvános',
	'giftmanager-private' => 'privát',
	'giftmanager-view' => 'Ajándékok listájának megjelenítése',
	'g-add-message' => 'Üzenet hozzáadása',
	'g-back-edit-gift' => 'Vissza az ajándék szerkesztéséhez',
	'g-back-gift-list' => 'Vissza az ajándéklistához',
	'g-back-link' => '< vissza $1 lapjára',
	'g-choose-file' => 'Válassz fájlt:',
	'g-cancel' => 'Mégse',
	'g-count' => '$1 felhasználónak $2 ajándéka van.',
	'g-create-gift' => 'Ajándék készítése',
	'g-created-by' => 'készítette',
	'g-current-image' => 'Jelenlegi kép',
	'g-delete-message' => 'Biztos vagy benne hogy törölni szeretnéd a(z) „$1” ajándékot?
Ez törölni fogja azoktól a felhasználóktól is, akik eddig megkapták.',
	'g-description-title' => '$1 $2 ajándéka',
	'g-error-do-not-own' => 'Ez nem a te ajándékod.',
	'g-error-message-blocked' => 'Jelenleg blokkolva vagy, és nem adhatsz ajándékokat',
	'g-error-message-invalid-link' => 'A megadott hivatkozás érvénytelen',
	'g-error-message-login' => 'Be kell jelentkezned ajándékok küldéséhez',
	'g-error-message-no-user' => 'A felhasználó, akit meg próbáltál nézni, nem létezik.',
	'g-error-message-to-yourself' => 'Nem adhatsz ajándékot saját magadnak.',
	'g-error-title' => 'Hoppá, eltévedtél!',
	'g-file-instructions' => 'A képnek jpeg, png vagy (nem animált) gif formátumúnak, és 100 KB-nál kisebb méretűnek kell lennie.',
	'g-from' => 'tőle: <a href="$1">$2</a>',
	'g-gift' => 'ajándék',
	'g-gift-name' => 'ajándék neve',
	'g-give-gift' => 'Ajándék küldése',
	'g-give-all' => 'Szeretnél ajándékot adni $1 felhasználónak?
Csak válassz egyet az alábbi ajándékokból, és kattints az „Ajándék küldése” gombra.
Ilyen egyszerű.',
	'g-give-all-message-title' => 'Üzenet hozzáadása',
	'g-give-all-title' => 'Ajándék küldése neki: $1',
	'g-give-enter-friend-title' => 'Ha tudod a felhasználó nevét, írd be alább',
	'g-given' => 'Ezt az ajándékot már {{PLURAL:$1|egy|$1}} alkalommal adták oda',
	'g-give-list-friends-title' => 'Válassz valakit a barátaid listájáról',
	'g-give-list-select' => 'válassz ki egy barátot',
	'g-give-separator' => 'vagy',
	'g-give-no-user-message' => 'Az ajándékok és díjak remek módjai barátaid elismerésének!',
	'g-give-no-user-title' => 'Kinek szeretnél ajándékot küldeni?',
	'g-give-to-user-title' => '„$1” ajándék elküldése $2 részére',
	'g-give-to-user-message' => '<a href="$2">Más ajándékot</a> szeretnél küldeni $1 részére?',
	'g-go-back' => 'Visszalépés',
	'g-imagesbelow' => 'Alább láthatóak a képed, melyek használva lesznek az oldalon',
	'g-large' => 'Nagy',
	'g-list-title' => '$1 ajándéklistája',
	'g-main-page' => 'Kezdőlap',
	'g-medium' => 'Közepes',
	'g-mediumlarge' => 'Közepesen nagy',
	'g-new' => 'új',
	'g-next' => 'Következő',
	'g-previous' => 'Előző',
	'g-remove' => 'Eltávolítás',
	'g-remove-gift' => 'Ajándék eltávolítása',
	'g-remove-message' => 'Biztosan el szeretnéd távolítani a(z) „$1” ajándékot?',
	'g-recent-recipients' => 'Mások, akik a közelmúltban megkapták ezt az ajándékot',
	'g-remove-success-title' => 'Sikeresen eltávolítottad a(z) „$1” ajándékot',
	'g-remove-success-message' => 'A(z) „$1” ajándék eltávolítva.',
	'g-remove-title' => 'Eltávolítod ezt: „$1”?',
	'g-send-gift' => 'Ajándék küldése',
	'g-select-a-friend' => 'válassz egy barátot',
	'g-sent-title' => 'Ajándékot küldtél $1 részére',
	'g-sent-message' => 'A következő ajándékot küldted el $1 részére.',
	'g-small' => 'Kicsi',
	'g-to-another' => 'Átadás valaki másnak',
	'g-uploadsuccess' => 'Sikeres feltöltés',
	'g-viewgiftlist' => 'Ajándéklista megjelenítése',
	'g-your-profile' => 'A profilod',
	'gift_received_subject' => '$1 $2 ajándékot küldött neked a(z) {{SITENAME}} wikin!',
	'gift_received_body' => 'Szia, $1!

$2 épp most küldte neked a(z) $3 ajándékot a(z) {{SITENAME}} wikin.

Meg szeretnéd nézni az ajándékodat, és a megjegyzést, amit $2 fűzött hozzá? Csak kattints az alábbi linkre:

$4

Reméljük tetszeni fog!

Köszönettel:
a(z) {{SITENAME}} csapata

---
Szeretnéd ha nem zaklatnánk több e-maillel?

Kattints a linkre: $5
és tiltsd le az e-mail értesítéseket a beállításaidban',
	'right-giftadmin' => 'Új ajándékok készítése és meglevők szerkesztése',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'giftmanager' => 'Gestor de donos',
	'giftmanager-addgift' => '+ Adder un nove dono',
	'giftmanager-access' => 'accesso al dono',
	'giftmanager-description' => 'description del dono',
	'giftmanager-giftimage' => 'imagine del dono',
	'giftmanager-image' => 'adder/reimplaciar imagine',
	'giftmanager-giftcreated' => 'Le dono ha essite create',
	'giftmanager-giftsaved' => 'Le dono ha essite salveguardate',
	'giftmanager-public' => 'public',
	'giftmanager-private' => 'private',
	'giftmanager-view' => 'Vider lista de donos',
	'g-add-message' => 'Adder un message',
	'g-back-edit-gift' => 'Retornar a modificar iste dono',
	'g-back-gift-list' => 'Retornar al lista de donos',
	'g-back-link' => '< Retornar al pagina de $1',
	'g-choose-file' => 'Selige file:',
	'g-cancel' => 'Cancellar',
	'g-count' => '$1 ha $2 {{PLURAL:$2|dono|donos}}.',
	'g-create-gift' => 'Crear dono',
	'g-created-by' => 'create per',
	'g-current-image' => 'Imagine actual',
	'g-delete-message' => 'Es tu secur que tu vole deler le dono "$1"? Isto va equalmente deler lo de omne usator qui lo ha recipite.',
	'g-description-title' => 'dono "$2" de $1',
	'g-error-do-not-own' => 'Tu non possede iste dono.',
	'g-error-message-blocked' => 'Tu es blocate al momento e non pote dar donos',
	'g-error-message-invalid-link' => 'Le ligamine que tu ha entrate es invalide.',
	'g-error-message-login' => 'Tu debe aperir un session pro dar donos',
	'g-error-message-no-user' => 'Le usator que tu tenta vider non existe.',
	'g-error-message-to-yourself' => 'Tu non pote dar un dono a te mesme.',
	'g-error-title' => 'Ups, tu ha errate!',
	'g-file-instructions' => 'Tu imagine debe esser in formato jpeg, png o gif (non animate), e debe esser minus grande que 100kb.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'dono',
	'g-gift-name' => 'nomine del dono',
	'g-give-gift' => 'Dar dono',
	'g-give-all' => 'Vole dar un dono a $1? Simplemente clicca super un del donos infra e clicca "Inviar dono". Es facile.',
	'g-give-all-message-title' => 'Adder un message',
	'g-give-all-title' => 'Dar un dono a $1',
	'g-give-enter-friend-title' => 'Si tu cognosce le nomine de iste usator, entra lo infra',
	'g-given' => 'Iste dono ha essite date $1 {{PLURAL:$1|vice|vices}}',
	'g-give-list-friends-title' => 'Selige de tu lista de amicos',
	'g-give-list-select' => 'selige un amico',
	'g-give-separator' => 'o',
	'g-give-no-user-message' => 'Le donos e premios es un optime maniera de dar recognoscimento a tu amicos!',
	'g-give-no-user-title' => 'A qui vole tu dar un dono?',
	'g-give-to-user-title' => 'Inviar le dono "$1" a $2',
	'g-give-to-user-message' => 'Vole dar un <a href="$2">altere dono</a> a $1?',
	'g-go-back' => 'Retornar',
	'g-imagesbelow' => 'In basso es tu imagines que essera usate in iste sito',
	'g-large' => 'Grande',
	'g-list-title' => 'Lista de donos de $1',
	'g-main-page' => 'Pagina principal',
	'g-medium' => 'Medie',
	'g-mediumlarge' => 'Medie-grande',
	'g-new' => 'nove',
	'g-next' => 'Proxime',
	'g-previous' => 'Previe',
	'g-remove' => 'Remover',
	'g-remove-gift' => 'Remover iste dono',
	'g-remove-message' => 'Es tu secur que tu vole remover le dono "$1"?',
	'g-recent-recipients' => 'Altere beneficiarios recente de iste dono',
	'g-remove-success-title' => 'Tu ha removite le dono "$1" con successo',
	'g-remove-success-message' => 'Le dono "$1" ha essite removite.',
	'g-remove-title' => 'Remover "$1"?',
	'g-send-gift' => 'Inviar dono',
	'g-select-a-friend' => 'selige un amico',
	'g-sent-title' => 'Tu ha inviate un dono a $1',
	'g-sent-message' => 'Tu ha inviate le dono sequente a $1.',
	'g-small' => 'Parve',
	'g-to-another' => 'Dar a un altere persona',
	'g-uploadsuccess' => 'Incargamento succedite',
	'g-viewgiftlist' => 'Vider lista de donos',
	'g-your-profile' => 'Tu profilo',
	'gift_received_subject' => '$1 te ha inviate le dono $2 in {{SITENAME}}!',
	'gift_received_body' => 'Salute $1,

$2 justo te inviava le dono $3 in {{SITENAME}}.

Vole leger le nota que $2 te lassava e vider tu dono? Clicca super le ligamine sequente:

$4

Nos spera que illo te placera!

Gratias,


Le equipa de {{SITENAME}}

---

Tu non vole reciper plus e-mail de nos?

Clicca $5
e cambia tu configurationes pro disactivar le notificationes in e-mail.',
	'right-giftadmin' => 'Crear nove donos e modificar existentes',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 */
$messages['id'] = array(
	'giftmanager' => 'Pengelolaan hadiah',
	'giftmanager-addgift' => '+ Tambah hadiah baru',
	'giftmanager-access' => 'akses hadiah',
	'giftmanager-description' => 'Keterangan hadiah',
	'giftmanager-giftimage' => 'Gambar hadiah',
	'giftmanager-image' => 'tambah/ganti gambar',
	'giftmanager-giftcreated' => 'Hadiah sudah dibuat',
	'giftmanager-giftsaved' => 'Hadiah sudah disimpan',
	'giftmanager-public' => 'publik',
	'giftmanager-private' => 'pribadi',
	'giftmanager-view' => 'Lihat daftar hadiah',
	'g-add-message' => 'Sisipkan surat',
	'g-back-edit-gift' => 'Kembali untuk menyunting hadiah ini',
	'g-back-gift-list' => 'Kembali ke daftar hadiah',
	'g-back-link' => '< Kembali ke halaman $1',
	'g-choose-file' => 'Pilih berkas:',
	'g-cancel' => 'Batalkan',
	'g-count' => '$1 memiliki $2 {{PLURAL:$2|hadiah|hadiah}}.',
	'g-create-gift' => 'Buat hadiah',
	'g-created-by' => 'dibuat oleh',
	'g-current-image' => 'Gambar sekarang',
	'g-delete-message' => 'Apakah anda yakin untuk menghapus hadiah "$1"?
Karena ini juga akan mengakibatkan terhapusnya hadiah dari si penerima.',
	'g-description-title' => '"$2" hadiah $1',
	'g-error-do-not-own' => 'Anda tidak memiliki hadiah ini.',
	'g-error-message-blocked' => 'Saat ini anda sedang diblok dan tidak bisa memberi hadiah',
	'g-error-message-invalid-link' => 'Pranala yang anda masukkan tidak benar.',
	'g-error-message-login' => 'Anda harus masuk log untuk bisa memberi hadiah',
	'g-error-message-no-user' => 'Pengguna yang anda coba buka tidak ada.',
	'g-error-message-to-yourself' => 'Anda tidak bisa memberi hadiah kepada diri sendiri.',
	'g-error-title' => 'Aduh, anda salah belok!',
	'g-file-instructions' => 'Gambar anda harus berupa jpeg, png, atau gif (tanpa animasi), dan besarnya tidak boleh melebihi 100kb.',
	'g-from' => 'dari <a href="$1">$2</a>',
	'g-gift' => 'hadiah',
	'g-gift-name' => 'nama hadiah',
	'g-give-gift' => 'Berikan hadiah',
	'g-give-all' => 'Ingin memberi hadiah kepada $1?
Silakan klik salah satu hadiah di bawah ini, lalu klik "Kirim hadiah".
Sangat mudah.',
	'g-give-all-message-title' => 'Sisipkan surat',
	'g-give-all-title' => 'Berikan hadiah kepada $1',
	'g-give-enter-friend-title' => 'Jika anda tahu nama penggunanya, silakan langsung diketikkan di bawah ini',
	'g-given' => 'Hadiah ini telah diberikan $1 {{PLURAL:$1|kali|kali}}',
	'g-give-list-friends-title' => 'Pilih dari daftar teman anda',
	'g-give-list-select' => 'pilih seorang teman',
	'g-give-separator' => 'atau',
	'g-give-no-user-message' => 'Hadiah dan penghargaan adalah hal yang bagus untuk mengetahui teman anda!',
	'g-give-no-user-title' => 'Siapa yang ingin anda beri hadiah?',
	'g-give-to-user-title' => 'Kirim hadiah "$1" ke $2',
	'g-give-to-user-message' => 'Ingin memberikan <a href="$2">hadiah istimewa</a> kepada $1?',
	'g-go-back' => 'Kembali',
	'g-imagesbelow' => 'Di bawah ini adalah gambar-gambar yang akan digunakan dalam situs',
	'g-large' => 'Besar',
	'g-list-title' => 'Daftar hadiah $1',
	'g-main-page' => 'Halaman utama',
	'g-medium' => 'Menengah',
	'g-mediumlarge' => 'Sedang-besar',
	'g-new' => 'baru',
	'g-next' => 'Selanjutnya',
	'g-previous' => 'Sebelumnya',
	'g-remove' => 'Hapus',
	'g-remove-gift' => 'Singkirkan hadiah ini',
	'g-remove-message' => 'Anda yakin ingin menyingkirkan hadiah "$1"?',
	'g-recent-recipients' => 'Penerima hadiah yang sama baru-baru ini',
	'g-remove-success-title' => 'Hadiah "$1" sudah disingkirkan',
	'g-remove-success-message' => 'Hadiah "$1" sudah disingkirkan.',
	'g-remove-title' => 'Singkirkan "$1"?',
	'g-send-gift' => 'Kirim hadiah',
	'g-select-a-friend' => 'pilih teman',
	'g-sent-title' => 'Anda telah mengirim hadiah ke $1',
	'g-sent-message' => 'Anda telah mengirim hadiah berikut ini ke $1.',
	'g-small' => 'Kecil',
	'g-to-another' => 'Berikan ke orang lain',
	'g-uploadsuccess' => 'Berhasil memuat',
	'g-viewgiftlist' => 'Lihat daftar hadiah',
	'g-your-profile' => 'Profil anda',
	'gift_received_subject' => '$1 telah mengirimi anda hadiah $2 di {{SITENAME}}!',
	'gift_received_body' => 'Hai $1.

$2 baru saja mengirim Anda hadiah $3 pada {{SITENAME}}.

Ingin membaca catatan $2 tinggalkan untuk anda dan lihat hadiah Anda? Klik pranala di bawah:

$4

Kami harap Anda senang!

Terima kasih,


Tim {{SITENAME}} 

---

Hai, ingin berhenti mendapatkan surel dari kami?

Klik $5
dan ubah seting untuk nonaktifkan notifikasi surel.',
	'right-giftadmin' => 'Buat baru dan sunting hadiah yang sudah ada',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'g-cancel' => 'Kàchá',
	'g-large' => 'Ukwu',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'giftmanager-public' => 'pubblico',
	'giftmanager-private' => 'privata',
	'g-cancel' => 'Annulla',
	'g-give-separator' => 'o',
	'g-large' => 'Grande',
	'g-medium' => 'Medio',
	'g-new' => 'nuovo',
	'g-next' => 'Succ',
	'g-previous' => 'Prec',
	'g-remove' => 'Rimuovi',
	'g-small' => 'Piccolo',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'giftmanager' => '贈り物の管理',
	'giftmanager-addgift' => '+ 新しい贈り物の追加',
	'giftmanager-access' => '贈り物のアクセス',
	'giftmanager-description' => '贈り物の説明',
	'giftmanager-giftimage' => '贈り物用画像',
	'giftmanager-image' => '画像を追加/置き換え',
	'giftmanager-giftcreated' => '贈り物を作成しました',
	'giftmanager-giftsaved' => '贈り物を保存しました',
	'giftmanager-public' => '公開',
	'giftmanager-private' => '非公開',
	'giftmanager-view' => '贈り物の一覧を表示',
	'g-add-message' => 'メッセージを追加',
	'g-back-edit-gift' => '戻ってこの贈り物を編集する',
	'g-back-gift-list' => '贈り物一覧に戻る',
	'g-back-link' => '< $1のページに戻る',
	'g-choose-file' => 'ファイルを選ぶ:',
	'g-cancel' => '中止',
	'g-count' => '$1は$2個の{{PLURAL:$2|贈り物|贈り物}}を所有しています。',
	'g-create-gift' => '贈り物を作成',
	'g-created-by' => '作成者',
	'g-current-image' => '現在の画像',
	'g-delete-message' => '贈り物「$1」を本当に削除しますか？この操作を行うと送り先の手元からも削除されます。',
	'g-description-title' => '$1からの贈り物「$2」',
	'g-error-do-not-own' => 'あなたはこの贈り物を所持してません。',
	'g-error-message-blocked' => 'あなたは現在ブロックされているため贈り物を贈ることはできません',
	'g-error-message-invalid-link' => 'あなたの入力したリンクは無効です。',
	'g-error-message-login' => '贈り物を贈るにはログインする必要があります',
	'g-error-message-no-user' => 'あなたが閲覧しようとした利用者は存在しません。',
	'g-error-message-to-yourself' => '自分自身へ贈り物を贈ることはできません。',
	'g-error-title' => 'おっと、操作を間違えましたよ！',
	'g-file-instructions' => '画像はjpeg、pngまたはgif (アニメーションgifは不可)である必要があり、サイズは100キロバイトよりも小さくする必要があります。',
	'g-from' => '<a href="$1">$2</a>から',
	'g-gift' => '贈り物',
	'g-gift-name' => '贈り物名',
	'g-give-gift' => '贈り物を贈る',
	'g-give-all' => '$1に贈り物を贈りますか？下の贈り物のどれか1つをクリックし、「贈り物を送る」をクリックしてください。操作はたったそれだけです。',
	'g-give-all-message-title' => 'メッセージの追加',
	'g-give-all-title' => '$1に贈り物を贈る',
	'g-give-enter-friend-title' => '利用者の名前を知っているなら、以下に入力してください',
	'g-given' => 'この贈り物は$1{{PLURAL:$1|回}}贈られています',
	'g-give-list-friends-title' => '友達一覧から選択してください',
	'g-give-list-select' => '友達を選択',
	'g-give-separator' => 'または',
	'g-give-no-user-message' => '贈り物と賞は友人に対して感謝の気持ちを表すのにぴったりな方法です！',
	'g-give-no-user-title' => '誰に贈り物を贈りますか？',
	'g-give-to-user-title' => '贈り物「$1」を$2 へ送る',
	'g-give-to-user-message' => '$1 へ<a href="$2">別の贈り物</a>を贈りますか？',
	'g-go-back' => '戻る',
	'g-imagesbelow' => '以下はサイトで使用されるあなたの画像です',
	'g-large' => '大',
	'g-list-title' => '$1 の贈り物一覧',
	'g-main-page' => 'メインページ',
	'g-medium' => '中',
	'g-mediumlarge' => 'やや大',
	'g-new' => '新規',
	'g-next' => '次',
	'g-previous' => '前',
	'g-remove' => '削除',
	'g-remove-gift' => 'この贈り物を削除する',
	'g-remove-message' => '本当に贈り物「$1」を削除してよろしいですか？',
	'g-recent-recipients' => '最近この贈り物を受け取った他の人',
	'g-remove-success-title' => '贈り物「$1」の削除に成功しました',
	'g-remove-success-message' => '贈り物「$1」は削除されました。',
	'g-remove-title' => '「$1」を削除しますか？',
	'g-send-gift' => '贈り物を送る',
	'g-select-a-friend' => '友達を選択',
	'g-sent-title' => '$1に贈り物を送りました。',
	'g-sent-message' => '以下の贈り物を$1に送りました。',
	'g-small' => '小',
	'g-to-another' => '他の人に贈る',
	'g-uploadsuccess' => 'アップロード成功',
	'g-viewgiftlist' => '贈り物一覧を表示',
	'g-your-profile' => 'あなたのプロフィール',
	'gift_received_subject' => '{{SITENAME}}上に$1さんからの$2の贈り物が届いています！',
	'gift_received_body' => 'こんにちは、$1 さん。

{{SITENAME}}上に、$2さんからあなたへ$3の贈り物が届いています。

$2さんからのメッセージと贈り物を見るには以下のリンクをクリックしてください。

$4

贈り物が気に入れば幸いです。

{{SITENAME}}チーム

---
メール受信を停止したい場合は、
$5
をクリックして、メール通知を無効にするよう設定変更してください。',
	'right-giftadmin' => '現在の贈り物を編集または新しく作成',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'giftmanager-description' => 'បរិយាយ​អំណោយ​',
	'giftmanager-giftimage' => 'រូបភាពអំណោយ​',
	'giftmanager-giftcreated' => 'អំណោយ​ត្រូវ​បាន​បង្កើត​ហើយ​',
	'giftmanager-giftsaved' => 'អំណោយ​ត្រូវ​បាន​រក្សាទុក​ហើយ',
	'giftmanager-public' => 'សាធារណៈ​',
	'giftmanager-private' => 'ឯកជន​',
	'giftmanager-view' => 'មើល​បញ្ជី​អំណោយ​',
	'g-add-message' => 'បន្ថែម​សារ​',
	'g-back-gift-list' => 'ត្រឡប់ទៅកាន់បញ្ជីអំណោយ​',
	'g-choose-file' => 'ជ្រើសរើស​ឯកសារ​៖​',
	'g-cancel' => 'បោះបង់​',
	'g-create-gift' => 'បង្កើត​អំណោយ​',
	'g-created-by' => 'បង្កើត​ដោយ​',
	'g-current-image' => 'រូបភាពបច្ចុប្បន្ន',
	'g-gift' => 'អំណោយ​',
	'g-gift-name' => 'ឈ្មោះ​អំណោយ​',
	'g-give-gift' => 'ផ្ដល់​ជូន​អំណោយ​​',
	'g-give-all-message-title' => 'បន្ថែម​សារ​',
	'g-give-all-title' => 'ជូនអំណោយទៅ $1',
	'g-give-list-select' => 'ជ្រើសរើស​មិត្តភ័ក្ដិ',
	'g-give-separator' => 'ឬ​',
	'g-go-back' => 'ទៅ​ក្រាយ​',
	'g-large' => 'ធំ​',
	'g-list-title' => 'បញ្ជី​អំណោយ​​របស់ $1',
	'g-main-page' => 'ទំព័រ​ដើម​',
	'g-medium' => 'មធ្យម​',
	'g-mediumlarge' => 'ធំគួរសម',
	'g-new' => 'ថ្មី​',
	'g-next' => 'បន្ទាប់​',
	'g-previous' => 'មុន​',
	'g-remove' => 'ដកចេញ',
	'g-remove-gift' => 'ដក​ចេញ​អំណោយ​នេះ​',
	'g-send-gift' => 'ជូនអំណោយ',
	'g-select-a-friend' => 'ជ្រើសរើស​មិត្តភ័ក្ដិ',
	'g-small' => 'តូច​',
	'g-your-profile' => 'ប្រវត្តិរូប​របស់​អ្នក​',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'g-cancel' => 'ರದ್ದು ಮಾಡು',
	'g-main-page' => 'ಮುಖ್ಯ ಪುಟ',
	'g-new' => 'ಹೊಸ',
	'g-next' => 'ಮುಂದಿನ',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'giftmanager' => 'Jeschenke Verwallde',
	'giftmanager-addgift' => '+ e neu Jeschenk dobei donn',
	'giftmanager-access' => 'Zohjang nohm Jeschengk',
	'giftmanager-description' => 'Jeschengk beschrieve',
	'giftmanager-giftimage' => 'Beld fum Jeschengk',
	'giftmanager-image' => 'e Beld dobei donn udder ußtuusche',
	'giftmanager-giftcreated' => 'Dat Jeschengk es aanjelaat',
	'giftmanager-giftsaved' => 'Dat Jeschengk es afjeshpeichert',
	'giftmanager-public' => 'öffentlesh',
	'giftmanager-private' => 'privaat',
	'giftmanager-view' => 'Less met Jeschengke beloore',
	'g-add-message' => 'En Nohreesch dobei donn',
	'g-back-edit-gift' => 'Jangk retuur noh em Ändere för dat Jeschenk',
	'g-back-gift-list' => 'Jangk retuur op de Leß met de Jeschenke',
	'g-back-link' => '< Retuur noh dem $1 sing Sigg',
	'g-choose-file' => 'Donn de Datei ußwähle:',
	'g-cancel' => 'Stopp! Avbreche!',
	'g-count' => '{{GENDER:$1|Dä|Dat|Dä Metmaacher}} $1 hät {{PLURAL:$2|ei Jeschengk|$2 Geschengke|kei Jeschengk}}.',
	'g-create-gift' => 'Jeschengk äschaffe',
	'g-created-by' => 'aanjelaat {{GENDER:$1|fum|fum|fum Metmaacher|fum|fun dä}}',
	'g-current-image' => 'Et aktoälle Beld',
	'g-delete-message' => 'Beß De Der sescher, dat de dat Jeschengk „$1“ fott maacher wells?
Domet verschwindt et och bei all de Metmaacher, di dat ald ens krääje han.',
	'g-description-title' => 'Däm $1 sing Jeschengk „$2“',
	'g-error-do-not-own' => 'Dat Jeschengk jehüert Der nit.',
	'g-error-message-blocked' => 'Do bes jraad jeshpert un kanns dröm kei Jeschengke maache.',
	'g-error-message-invalid-link' => 'Dä Lengk es unjöltesch, dä De do enjejovve häs.',
	'g-error-message-login' => 'Do moß ald enjelogg sin, öm Jeschengke maache eze künne',
	'g-error-message-no-user' => 'Dä Metmaacher, dä De aanloore wells, dä jidd_et jaa nit.',
	'g-error-message-to-yourself' => 'Do kanns Desch net sellevs beschengke.',
	'g-error-title' => 'Hoppla, Häzje, do bes De öhnzwi verkeht jejange!',
	'g-file-instructions' => 'Ding Beld moß em <code>jpeg</code>, <code>png</code> odder em <span class="plainlinks">gif</span> Fommaat sin, ävver kei bewääschlesch  <code>gif</code>, un der Ömfang darf nit mieh wie 100 Killo<i lang="en">byte</i> bedraare.',
	'g-from' => 'vun <a href="$1">$2</a>',
	'g-gift' => 'Jeschengk',
	'g-gift-name' => 'em Jeschengk singe Name',
	'g-give-gift' => 'einem e Jeschengk maache',
	'g-give-all' => 'Wells de {{GENDER:$1|dämm|dämm|dämm Metmaacher}} $1 e Jeschngk maache?
Dann don op ein fun dä Jeschengke hee dronger klecke,
un dann donn „{{int:G-send-gift}}“ klecke, esu eijfach es dat.',
	'g-give-all-message-title' => 'Donn en Nohreesch dobei',
	'g-give-all-title' => 'Mach däm $1 e Jeschengk',
	'g-give-enter-friend-title' => 'Wann de dä Metmaacher-Name weiß, da donn en unge entippe',
	'g-given' => 'Dat Jeschengk woodt {{PLURAL:$1|ald eimol|ald $1 Mohle|noch nie}} ußjejovve.',
	'g-give-list-friends-title' => 'Uß de Leß met Dinge Fründe ußsöke',
	'g-give-list-select' => 'Sök ene Fründ uß',
	'g-give-separator' => 'udder',
	'g-give-no-user-message' => 'Jeschengke un Ußzeishnunge sin en joode Saach, öm Dinge Fründe Ding Aanerkennung ußzedröcke un en Beshtäätejung ze jävve!',
	'g-give-no-user-title' => 'Wämm wööds De jään e Jeschengk maache?',
	'g-give-to-user-title' => 'Donn {{GENDER:$2:dämm|dämm|dämm|dä|dämm}} $2 dat Jeschengk „$1“ maache',
	'g-give-to-user-message' => 'Wells De {{GENDER:$1|dämm|dämm|dämm Metmaacher|dä|dämm}} $1 en <a href="$2">ander Jeschengk</a> maache?',
	'g-go-back' => 'Jangk retuur',
	'g-imagesbelow' => 'Hee dronger sin Ding Bellder, die hee en däm Wiki jebruch wäde.',
	'g-large' => 'Jruß',
	'g-list-title' => 'Däm $1 sing Leß met Jeschengke',
	'g-main-page' => '{{int:mainpage}}',
	'g-medium' => 'Meddel',
	'g-mediumlarge' => 'Meddeljruuß',
	'g-new' => 'neu',
	'g-next' => 'Nächsde',
	'g-previous' => 'Vörijje',
	'g-remove' => 'Fott nämme',
	'g-remove-gift' => 'Dat Jeschengk fott nämme',
	'g-remove-message' => 'Bes de Der sesher, dat De dat Jeschengk „$1“ fott nämme wells?',
	'g-recent-recipients' => 'Ander, di dat sellve Jeschengk köözlesch krääje han.',
	'g-remove-success-title' => 'Dat Jeschengk „$1“ es fott jenumme.',
	'g-remove-success-message' => 'Dat Jeschengk „$1“ es jetz widder fott.',
	'g-remove-title' => '„$1“ fott nämme?',
	'g-send-gift' => 'Dat Jeschengk maache!',
	'g-select-a-friend' => 'sök ene Fründ uß',
	'g-sent-title' => 'Do häs dämm $1 e Jeschengk jemaat',
	'g-sent-message' => 'Do häs dämm $1 dat Jeschengk hee jemaat.',
	'g-small' => 'Kleij',
	'g-to-another' => 'Donn dat enem andere jevve',
	'g-uploadsuccess' => 'Et Huhlaade hät jeflupp',
	'g-viewgiftlist' => 'Donn de Leß met Jeschengke aanloore',
	'g-your-profile' => 'Ding Profil',
	'gift_received_subject' => '{{GENDER:$1|Dä Metmaacher|De Metmaacheren|Dä Metmaacher|Dat Metmaacherin|-}}
$1 hät Der {{GRAMMAR:em|{{SITENAME}}}} dat Jeschengk $2 jemaat!',
	'gift_received_body' => 'Jooden Daach, $1,

{{GENDER:$2|dä|dat|dä Metmaacher|de|dat}} $2 {{GRAMMAR:em|{{SITENAME}}}} hät Der jrad dat Jeschengk $3 jejovve

Wells De lesse, wat {{GENDER:$2|dä|et|dä Metmaacher|de|et}} $2 Der met dämm Jeschengk för en Nohreesch hät zohkumme lohße? Donn op dä Link klekke:

$4

Mer hoffe, Do maachs_et!

Schööne Dank,


De Lück vun de {{SITENAME}}

---

Wells De kei e-mail mieh vun uns krijje?

Dann donn op $5 klekke,
un donn Ding Enshtellunge ändere, öm kei Metteilunge mieh övver e-mail ze krijje.',
	'right-giftadmin' => 'E neu jeschengk äscahffe, un all de Jeschengke ändere, di ad doo sin.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'giftmanager' => "Cadeau's-Verwaltung",
	'giftmanager-addgift' => '+ En neie Cadeau derbäisetzen',
	'giftmanager-access' => 'Zougang zu de Cadeauen',
	'giftmanager-description' => 'Beschreiwung vum Cadeau',
	'giftmanager-giftimage' => 'Bild vum Cadeau',
	'giftmanager-image' => 'Bild derbäisetzen/ersetzen',
	'giftmanager-giftcreated' => 'De Cadeau gouf ugeluecht.',
	'giftmanager-giftsaved' => 'De Cadeau ouf gespäichert',
	'giftmanager-public' => 'ëffentlech',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Lëscht vun de Cadeaue kucken',
	'g-add-message' => 'Eng Noriicht derbäisetzen',
	'g-back-edit-gift' => "Zréck fir dëse Cadeau z'änneren",
	'g-back-gift-list' => "Zréck op d'Lëscht vun de Cadeauen",
	'g-back-link' => '< Zréck op dem $1 seng Säit',
	'g-choose-file' => 'Fichier wielen:',
	'g-cancel' => 'Ofbriechen',
	'g-count' => '$1 huet  $2 {{PLURAL:$2|Cadeau|Cadeauen}}.',
	'g-create-gift' => 'Cadeau uleeën',
	'g-created-by' => 'ugeluecht vum',
	'g-current-image' => 'Aktuellt Bild',
	'g-delete-message' => 'Sidd dir sécher datt dir de Cadeau $1 läsche wëllt?
Et gëtt dann och bäi de Benotzer geläscht déi e kritt hunn.',
	'g-description-title' => 'Cadeau "$2" vum $1',
	'g-error-do-not-own' => 'Dëse Cadeau gehéiert Iech net.',
	'g-error-message-blocked' => 'Dir sidd den Ament gespaart a kënnt keng Cadeaue maachen',
	'g-error-message-invalid-link' => 'De Link deen Dir uginn hutt ass net valabel.',
	'g-error-message-login' => 'Dir musst Iech aloggen fir Cadeauen ze maachen',
	'g-error-message-no-user' => 'De Benotzer deen Dir versicht ze kucken gëtt et net.',
	'g-error-message-to-yourself' => 'Dir kënnt Iech net selwer e Cadeau maachen.',
	'g-error-title' => 'Oups, do ass eppes schief gaang!',
	'g-file-instructions' => 'Äert Bild muss e jpeg, png oder gif (keng animéiert Gifen) sinn, a muss manner wéi 100KB grouss sinn.',
	'g-from' => 'vum <a href="$1">$2</a>',
	'g-gift' => 'Cadeau',
	'g-gift-name' => 'Numm vum Cadeau',
	'g-give-gift' => 'E Cadeau maachen',
	'g-give-all' => 'Wëllt Dir dem $1 e Cadeau maachen?
Klickt just op e vun de Cadeauen ënnendrënner a klickt op "Cadeau schécken".
Et ass esou einfach.',
	'g-give-all-message-title' => 'Eng Noriicht derbäisetzen',
	'g-give-all-title' => 'Dem $1 e Cadeau maachen',
	'g-give-enter-friend-title' => 'Wann Dir den Numm vum Benotzer wësst, dann tippt en ënndrënner an.',
	'g-given' => 'Dëse Cadeau gouf $1 {{PLURAL:$1|mol|mol}} gemaach',
	'g-give-list-friends-title' => 'Aus Ärer Lëscht vu Frënn auswielen',
	'g-give-list-select' => 'e Frënd auswielen',
	'g-give-separator' => 'oder',
	'g-give-no-user-message' => 'Cadeauen an Auszeechnunge sinn eng groussarteg Manéier fir senge Frënn Unerkennung auszedrécken!',
	'g-give-no-user-title' => 'Wiem wëllt Dir e Cadeau maachen?',
	'g-give-to-user-title' => 'Dem $2 de Cadeau "$1" maachen',
	'g-give-to-user-message' => 'Wëllt Dir dem $1 en <a href="$2">anere Cadeau</a> maachen?',
	'g-go-back' => 'Zréck goen',
	'g-imagesbelow' => 'Ënndrënner sinn Är Biller déi op dësem Site benotzt gi werten',
	'g-large' => 'Grouss',
	'g-list-title' => 'Lëscht vun de Cadeaue vum $1',
	'g-main-page' => 'Haaptsäit',
	'g-medium' => 'Mëttel',
	'g-mediumlarge' => 'Mëttelgrouss',
	'g-new' => 'nei',
	'g-next' => 'Nächst',
	'g-previous' => 'Vireg',
	'g-remove' => 'Ewechhuelen',
	'g-remove-gift' => 'Dëse Cadeau ewechhuelen',
	'g-remove-message' => 'Sidd Dir sécher datt Dir de Cadeau "$1" ewechhuele wëllt?',
	'g-recent-recipients' => 'Anerer déi dëse Cadeau viru kuerzem kritt hunn',
	'g-remove-success-title' => 'Dir hutt de Cadeau "$1" ewechgeholl',
	'g-remove-success-message' => 'De Cadeau "$1" gouf ewechgeholl.',
	'g-remove-title' => '"$1" ewechhuelen?',
	'g-send-gift' => 'Cadeau schécken',
	'g-select-a-friend' => 'a Frënd auswielen',
	'g-sent-title' => 'Dir hutt dem $1 e Cadeau geschéckt',
	'g-sent-message' => 'Dir hutt dem $1 dëse Cadeau geschéckt.',
	'g-small' => 'Kleng',
	'g-to-another' => 'Engem Anere ginn',
	'g-uploadsuccess' => 'Eroplueden ofgeschloss',
	'g-viewgiftlist' => 'Lëscht vun de Cadeaue kucken',
	'g-your-profile' => 'Äre Profil',
	'gift_received_subject' => 'De Benotzer $1 huet Iech de Cadeau $2 op {{SITENAME}} gemaach!',
	'gift_received_body' => "Salut $1.

De Benotzer $2 Huet Iech eclo grad de Cadeau $3 op {{SITENAME}} geschéckt.

Wëllt Dir de Message den de Benotzer $2 Iech hannerlooss huet and Äre Cadeau gesinn?  Da klickt op de lInk hei ënnendrënner:

$4

Mir hoffen e gefällt Iech!

Merci,


D'Equipe vu(n) {{SITENAME}}

---

Wëllt Dir keng E-Maile méi vun eis kréien?

Klickt op $5
an ännert Är Astellunge fir d'E-Mail-Notifikatioun auszeschalten.",
	'right-giftadmin' => 'Nei Cadeauen uleeën a bestoender änneren',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'g-created-by' => 'aangemaak door',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'giftmanager' => 'Раководител со подароци',
	'giftmanager-addgift' => '+ Додај нов подарок',
	'giftmanager-access' => 'пристап до подарокот',
	'giftmanager-description' => 'опис на подарокот',
	'giftmanager-giftimage' => 'слика на подарокот',
	'giftmanager-image' => 'додај/замени слика',
	'giftmanager-giftcreated' => 'Подарокот е создаден',
	'giftmanager-giftsaved' => 'Подарокот е зачуван',
	'giftmanager-public' => 'јавни',
	'giftmanager-private' => 'приватни',
	'giftmanager-view' => 'Прикажи список на подароци',
	'g-add-message' => 'Додај порака',
	'g-back-edit-gift' => 'Назад кон уредувањето на подарокот',
	'g-back-gift-list' => 'Назад кон списокот на подароци',
	'g-back-link' => '< Назад кон страницата на $1',
	'g-choose-file' => 'Одберете податотека:',
	'g-cancel' => 'Откажи',
	'g-count' => '$1 има $2 {{PLURAL:$2|подарок|подароци}}.',
	'g-create-gift' => 'Создај подарок',
	'g-created-by' => 'создавач:',
	'g-current-image' => 'Тековна слика',
	'g-delete-message' => 'Дали сте сигурни дека сакате да го избришете подарокот „$1“?
Со ова истиот ќе биде избришан и кај корисниците кои го имаат примено.',
	'g-description-title' => 'Подарокот на $1 „$2“',
	'g-error-do-not-own' => 'Не сте сопственик на овој подарок.',
	'g-error-message-blocked' => 'Моментално сте блокирани и не можете да давате подароци',
	'g-error-message-invalid-link' => 'Внесената врска е неважечка.',
	'g-error-message-login' => 'Мора да се најавите за можете да давате подароци',
	'g-error-message-no-user' => 'Корисникот што сакате да го видите не постои.',
	'g-error-message-to-yourself' => 'Не можете да си подарувате на самите себеси.',
	'g-error-title' => 'Упс, направивте погрешен потег!',
	'g-file-instructions' => 'Вашата слика мора да биде од типот jpeg, png или gif (но не анимиран gif) , и мора да биде помала од 100кб.',
	'g-from' => 'од <a href="$1">$2</a>',
	'g-gift' => 'подарок',
	'g-gift-name' => 'име на подарокот',
	'g-give-gift' => 'Подари подарок',
	'g-give-all' => 'Сакате да му подарите нешто на $1?
Одберете еден од подароците подолу и кликнете на „Испрати подарок“.
Баш е лесно.',
	'g-give-all-message-title' => 'Додај порака',
	'g-give-all-title' => 'Подари му подарок на $1',
	'g-give-enter-friend-title' => 'Ако му го знаете името на корисникот, внесете го подолу',
	'g-given' => 'Овој подарок бил подаруван {{PLURAL:$1|еднаш|$1 пати}}',
	'g-give-list-friends-title' => 'Одберете од списокот на ваши пријатели',
	'g-give-list-select' => 'одберете пријател',
	'g-give-separator' => 'или',
	'g-give-no-user-message' => 'Подароците и наградите се одличен начин да им оддадете почит на вашите пријатели!',
	'g-give-no-user-title' => 'Кому сакате да испратите подарок?',
	'g-give-to-user-title' => 'Испрати го подарокот „$1“ на $2',
	'g-give-to-user-message' => 'Сакате на $1 да му подарите <a href="$2">поинаков подарок</a>?',
	'g-go-back' => 'Назад',
	'g-imagesbelow' => 'Подолу се наведени вашите слики кои ќе се користат на ова мрежно место',
	'g-large' => 'Голем',
	'g-list-title' => 'Список на подароци на $1',
	'g-main-page' => 'Главна страница',
	'g-medium' => 'Среден',
	'g-mediumlarge' => 'Средно-голем',
	'g-new' => 'нов',
	'g-next' => 'Следен',
	'g-previous' => 'Претходен',
	'g-remove' => 'Отстрани',
	'g-remove-gift' => 'Отстрани го подароков',
	'g-remove-message' => 'Дали сте сигурни дека сакате да го остраните подарокот „$1“?',
	'g-recent-recipients' => 'Други скорешни примачи на овој подарок',
	'g-remove-success-title' => 'Успешно го отстранивте подарокот „$1“',
	'g-remove-success-message' => 'Подарокот „$1“ е отстранет.',
	'g-remove-title' => 'Да го отстранам „$1“?',
	'g-send-gift' => 'Испрати подарок',
	'g-select-a-friend' => 'одберете пријател',
	'g-sent-title' => 'Му испративте подарок на $1',
	'g-sent-message' => 'Го испративте следниов подарок на $1.',
	'g-small' => 'Мал',
	'g-to-another' => 'Дај и на друг',
	'g-uploadsuccess' => 'Подигањето успеа',
	'g-viewgiftlist' => 'Прикажи список на подароци',
	'g-your-profile' => 'Вашиот профил',
	'gift_received_subject' => '$1 ви го испрати подарокот $2 на {{SITENAME}}!',
	'gift_received_body' => 'Здраво $1.

$2 штотуку ви го испрати подарокот $3 на {{SITENAME}}.

Сакате ли да ја прочитате белешката што ви ја напиша $2 и да го видите подарокот?  Кликнете на врската подолу:

$4

Се надеваме дека ви се допаѓа!

Благодариме,


Екипата на {{SITENAME}}

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $5
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
	'right-giftadmin' => 'Создајте нови и уредете постоечки подароци',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'g-main-page' => 'Нүүр хуудас',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'giftmanager' => 'Pengurus hadiah',
	'g-choose-file' => 'Pilih fail:',
	'g-cancel' => 'Batalkan',
	'g-count' => '$1 ada $2 hadiah.',
	'g-give-separator' => 'atau',
	'g-go-back' => 'Kembali',
	'g-large' => 'Besar',
	'g-medium' => 'Sederhana',
	'g-new' => 'baru',
	'g-next' => 'Berikutnya',
	'g-previous' => 'Sebelumnya',
	'g-small' => 'Kecil',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'giftmanager' => 'Giftenbeheer',
	'giftmanager-addgift' => '+ Nieuwe gift toevoegen',
	'giftmanager-access' => 'gifttoegang',
	'giftmanager-description' => 'giftomschrijving',
	'giftmanager-giftimage' => 'giftafbeelding',
	'giftmanager-image' => 'afbeelding toevoegen/vervangen',
	'giftmanager-giftcreated' => 'De gift is aangemaakt',
	'giftmanager-giftsaved' => 'De gift is opgeslagen',
	'giftmanager-public' => 'publiek',
	'giftmanager-private' => 'privé',
	'giftmanager-view' => 'Giftenlijst weergeven',
	'g-add-message' => 'Een bericht toevoegen',
	'g-back-edit-gift' => 'Terug naar gift bewerken',
	'g-back-gift-list' => 'Terug naar giftenlijst',
	'g-back-link' => '< Terug naar de pagina van $1',
	'g-choose-file' => 'Bestand kiezen:',
	'g-cancel' => 'Annuleren',
	'g-count' => '$1 heeft $2 {{PLURAL:$2|gift|giften}}.',
	'g-create-gift' => 'Gift aanmaken',
	'g-created-by' => 'aangemaakt door',
	'g-current-image' => 'Huidige afbeelding',
	'g-delete-message' => 'Weet u zeker dat u de gift "$1" wilt verwijderen? Dit zal hem ook verwijderen van gebruikers die hem ontvangen hebben.',
	'g-description-title' => 'De gift "$2" van $1',
	'g-error-do-not-own' => 'U bezit deze gift niet.',
	'g-error-message-blocked' => 'U bent momenteel geblokkeerd en u kunt geen giften geven',
	'g-error-message-invalid-link' => 'De verwijzing die u hebt ingevoerd is ongeldig.',
	'g-error-message-login' => 'U dient in te loggen om giften te kunnen geven',
	'g-error-message-no-user' => 'De gebruiker die u wilt weergeven bestaat niet.',
	'g-error-message-to-yourself' => 'U kunt geen gift aan uzelf geven.',
	'g-error-title' => 'Oeps, er ging iets fout!',
	'g-file-instructions' => 'Uw afbeelding dient een JPEG-, PNG- of GIF-bestand (niet geanimeerd) te zijn en moet minder dan 100 KB in grootte zijn.',
	'g-from' => 'van <a href="$1">$2</a>',
	'g-gift' => 'gift',
	'g-gift-name' => 'giftnaam',
	'g-give-gift' => 'Gift geven',
	'g-give-all' => 'Wilt u $1 een gift geven? Klik dan op één van de onderstaande giften en klik vervolgens op "Gift verzenden". Het is erg gemakkelijk.',
	'g-give-all-message-title' => 'Een bericht toevoegen',
	'g-give-all-title' => 'Een gift aan $1 geven',
	'g-give-enter-friend-title' => 'Indien u de gebruikersnaam weet, voert u die hieronder in',
	'g-given' => 'Deze gift is $1 {{PLURAL:$1|keer|keren}} gegeven',
	'g-give-list-friends-title' => 'Selecteren uit uw vriendenlijst',
	'g-give-list-select' => 'selecteer een vriend',
	'g-give-separator' => 'of',
	'g-give-no-user-message' => 'Giften en prijzen zijn een goede manier om waardering te tonen voor de verdiensten van uw vrienden!',
	'g-give-no-user-title' => 'Aan wie wilt u een gift geven?',
	'g-give-to-user-title' => 'De gift "$1" naar $2 sturen',
	'g-give-to-user-message' => 'Wilt u $1 een <a href="$2">andere gift geven</a>?',
	'g-go-back' => 'Teruggaan',
	'g-imagesbelow' => 'Hieronder volgen uw afbeeldingen die op de site gebruikt zullen worden',
	'g-large' => 'Groot',
	'g-list-title' => 'Giftenlijst van $1',
	'g-main-page' => 'Hoofdpagina',
	'g-medium' => 'Middelmatig',
	'g-mediumlarge' => 'Middelgroot',
	'g-new' => 'nieuw',
	'g-next' => 'Volgende',
	'g-previous' => 'Vorige',
	'g-remove' => 'Verwijderen',
	'g-remove-gift' => 'Deze gift verwijderen',
	'g-remove-message' => 'Weet u zeker dat u de gift "$1" wilt verwijderen?',
	'g-recent-recipients' => 'Andere recente ontvangers van deze gift',
	'g-remove-success-title' => 'U hebt de gift "$1" succesvol verwijderd',
	'g-remove-success-message' => 'De gift "$1" is verwijderd.',
	'g-remove-title' => '"$1" verwijderen?',
	'g-send-gift' => 'Gift verzenden',
	'g-select-a-friend' => 'selecteer een vriend',
	'g-sent-title' => 'U hebt een gift verzonden aan $1',
	'g-sent-message' => 'U hebt de volgende gift aan $1 gestuurd.',
	'g-small' => 'Klein',
	'g-to-another' => 'Aan iemand anders geven',
	'g-uploadsuccess' => 'Uploaden voltooid',
	'g-viewgiftlist' => 'Giftenlijst weergeven',
	'g-your-profile' => 'Uw profiel',
	'gift_received_subject' => '$1 hebt u de $2-gift gezonden op {{SITENAME}}!',
	'gift_received_body' => 'Hallo $1,

$2 heeft u zojuist de $3-gift gestuurd op {{SITENAME}}.

Wilt u het bericht lezen dat $2 voor u gemaakt hebt en uw gift weergeven? Klik dan op de onderstaande verwijzing:

$4

We hopen dat u er blij mee bent!

Bedankt,


Het {{SITENAME}}-team

---

Wilt u geen e-mails meer van ons ontvangen?

Klik op $5 en wijzig uw instellingen om e-mailwaarschuwingen uit te schakelen.',
	'right-giftadmin' => 'Een nieuwe gift aanmaken en bestaande giften bewerken',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Nghtwlkr
 * @author Ranveig
 */
$messages['nn'] = array(
	'giftmanager' => 'Gåvehandsamar',
	'giftmanager-addgift' => '+ legg til ei ny gåva',
	'giftmanager-access' => 'gåvetilgjenge',
	'giftmanager-description' => 'skildring av gåva',
	'giftmanager-giftimage' => 'gåvebilete',
	'giftmanager-image' => 'legg til/erstatt bilete',
	'giftmanager-giftcreated' => 'Gåva har vorten oppretta',
	'giftmanager-giftsaved' => 'Gåva har vorten lagra',
	'giftmanager-public' => 'offentleg',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Sjå gåvelista',
	'g-add-message' => 'Legg til ei melding',
	'g-back-edit-gift' => 'Attende til endring av gåva',
	'g-back-gift-list' => 'Attende til gåvelista',
	'g-back-link' => '< attende til sida til $1',
	'g-choose-file' => 'Vel fil:',
	'g-cancel' => 'Avbryt',
	'g-count' => '$1 har $2 {{PLURAL:$2|éi gåva|gåver}}.',
	'g-create-gift' => 'Opprett gåva',
	'g-created-by' => 'oppretta av',
	'g-current-image' => 'Noverande bilete',
	'g-delete-message' => 'Er du sikker på at du vil sletta gåva «$1»? Dette vil òg sletta ho frå brukaren som kanskje har fått ho.',
	'g-description-title' => 'gåva «$2» til $1',
	'g-error-do-not-own' => 'Du eig ikkje denne gåva.',
	'g-error-message-blocked' => 'Du er nett no blokkert og kan ikkje senda gåver.',
	'g-error-message-invalid-link' => 'Lenkja du oppgav er ugyldig.',
	'g-error-message-login' => 'Du lyt vera innlogga for å kunna gje gåver.',
	'g-error-message-no-user' => 'Brukaren du ynskjer å sjå finst ikkje.',
	'g-error-message-to-yourself' => 'Du kan ikkje gje ei gåva til deg sjølv.',
	'g-error-title' => 'Oi, du svingte feil!',
	'g-file-instructions' => 'Biletet ditt lyt vera eit jpeg, png eller gif (ingen animerte gif-filer) og ha ein storleik på mindre enn 100 kb.',
	'g-from' => 'frå <a href="$1">$2</a>',
	'g-gift' => 'gåva',
	'g-gift-name' => 'gåvenamn',
	'g-give-gift' => 'Gje ei gåva',
	'g-give-all' => 'Ynskjer du å gje $1 ei gåva? Trykk på ei av gåvene nedanfor og trykk so på «Send gåva». So enkelt er det.',
	'g-give-all-message-title' => 'Legg til ei melding',
	'g-give-all-title' => 'Gje ei gåva til $1',
	'g-give-enter-friend-title' => 'Viss du kjenner namnet på brukaren, skriv det inn under.',
	'g-given' => 'Denne gåva har vorten gjeven {{PLURAL:$1|éin gong|$1 gonger}}',
	'g-give-list-friends-title' => 'Vel frå lista di over venner',
	'g-give-list-select' => 'vel ein venn',
	'g-give-separator' => 'eller',
	'g-give-no-user-message' => 'Gåver og utmerkingar er ein flott måte å visa at du set pris på vennene dine.',
	'g-give-no-user-title' => 'Kven ynskjer du å gje ei gåva til?',
	'g-give-to-user-title' => 'Send gåva «$1» til $2',
	'g-give-to-user-message' => 'Ynskjer du å gje $1 ei <a href="$2">anna gåva</a>?',
	'g-go-back' => 'Attende',
	'g-imagesbelow' => 'Nedanfor er bileta dine som vil verta nytta på sida',
	'g-large' => 'Stort',
	'g-list-title' => 'gåvelista til $1',
	'g-main-page' => 'Hovudsida',
	'g-medium' => 'Medels',
	'g-mediumlarge' => 'Medelsstort',
	'g-new' => 'ny',
	'g-next' => 'Neste',
	'g-previous' => 'Førre',
	'g-remove' => 'Fjern',
	'g-remove-gift' => 'Fjern denne gåva',
	'g-remove-message' => 'Er du sikker på at du ynskjer å fjerna gåva «$1»?',
	'g-recent-recipients' => 'Andre som nyleg mottok denne gåva',
	'g-remove-success-title' => 'Gåva «$1» vart fjerna av deg',
	'g-remove-success-message' => 'Gåva «$1» vart fjerna.',
	'g-remove-title' => 'Fjerna «$1»?',
	'g-send-gift' => 'Send gåva',
	'g-select-a-friend' => 'vel ein venn',
	'g-sent-title' => 'Du har sendt ei gåva til $1',
	'g-sent-message' => 'Du har sendt den følgjande gåva til $1.',
	'g-small' => 'Lite',
	'g-to-another' => 'Gje til nokon andre',
	'g-uploadsuccess' => 'Opplasting lukkast',
	'g-viewgiftlist' => 'Sjå gåvelista',
	'g-your-profile' => 'Profilen din',
	'gift_received_subject' => '$1 har sendt deg gåva «$2» på {{SITENAME}}!',
	'gift_received_body' => 'Hei $1:

$2 sendte deg nett $3-gåva på {{SITENAME}}.

Ynskjer du å sjå merknaden $2 lét att til deg, og å sjå gåva?  Trykk på lenkja nedanfor:

$4

Me håpar du vil lika ho!

Takk,


{{SITENAME}}-laget

----

Vil du ikkje lenger motta e-postar frå oss?

Trykk $5
og endra innstillingane dine for å slå av e-postmeldingar.',
	'right-giftadmin' => 'Opprett nye og endra eksisterande gåver',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 * @author Simny
 */
$messages['nb'] = array(
	'giftmanager' => 'Gavebehandler',
	'giftmanager-addgift' => '+ Legg til ny gave',
	'giftmanager-access' => 'gavetilgang',
	'giftmanager-description' => 'gavebeskrivelse',
	'giftmanager-giftimage' => 'gavebilde',
	'giftmanager-image' => 'legg til/erstatt bilde',
	'giftmanager-giftcreated' => 'Gaven har blitt opprettet',
	'giftmanager-giftsaved' => 'Gaven har blitt lagret',
	'giftmanager-public' => 'offentlig',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Se gaveliste',
	'g-add-message' => 'Legg til en melding',
	'g-back-edit-gift' => 'Tilbake for å endre av gaven',
	'g-back-gift-list' => 'Tilbake til gavelisten',
	'g-back-link' => '< Tilbake til siden til $1',
	'g-choose-file' => 'Velg fil:',
	'g-cancel' => 'Avbryt',
	'g-count' => '$1 har {{PLURAL:$2|én gave|$2 gaver}}.',
	'g-create-gift' => 'Opprett gave',
	'g-created-by' => 'opprettet av',
	'g-current-image' => 'Nåværende bilde',
	'g-delete-message' => 'Er du sikker på at du vil slette gaven «$1»?
Dette vil også slette den fra brukere som kanskje allerede har fått den.',
	'g-description-title' => 'Gaven «$2» til $1',
	'g-error-do-not-own' => 'Du eier ikke denne gava.',
	'g-error-message-blocked' => 'Du er for tiden blokkert og kan ikke gi gaver',
	'g-error-message-invalid-link' => 'Lenken du oppga er ugyldig.',
	'g-error-message-login' => 'Du må være innlogget for å gi gaver',
	'g-error-message-no-user' => 'Brukeren som du ønsker å se finnes ikke.',
	'g-error-message-to-yourself' => 'Du kan ikke gi gaver til degselv.',
	'g-error-title' => 'Oi da, der svingte du feil!',
	'g-file-instructions' => 'Bildet digg må være en jpeg, png eller gif (ingen animerte gif-filer) og må være mindre enn 100kb.',
	'g-from' => 'fra <a href="$1">$2</a>',
	'g-gift' => 'gave',
	'g-gift-name' => 'gavenavn',
	'g-give-gift' => 'Gi ei gave',
	'g-give-all' => 'Ønsker du å gi $1 ei gave? 
Bare klikk på en av gavene nedenfor og trykk deretter på «Send gave». 
Så enkelt er det.',
	'g-give-all-message-title' => 'Legg til en melding',
	'g-give-all-title' => 'Gi en gave til $1',
	'g-give-enter-friend-title' => 'Hvis du kjenner navnet på brukeren, skriv det inn under.',
	'g-given' => 'Denne gaven har blitt gitt {{PLURAL:$1|én gang|$1 ganger}}',
	'g-give-list-friends-title' => 'Velg fra din liste over venner',
	'g-give-list-select' => 'velg en venn',
	'g-give-separator' => 'eller',
	'g-give-no-user-message' => 'Gaver og utmerkelser er en flott måte å vise at du setter pris på vennene dine!',
	'g-give-no-user-title' => 'Hvem vil du gi en gave til?',
	'g-give-to-user-title' => 'Send gaven «$1» til $2',
	'g-give-to-user-message' => 'Vil du gi $1 en <a href="$2">annen gave</a>?',
	'g-go-back' => 'Tilbake',
	'g-imagesbelow' => 'Under er dine bilde som vil bli brukt på denne siden',
	'g-large' => 'Stort',
	'g-list-title' => 'Gavelisten til $1',
	'g-main-page' => 'Hovedside',
	'g-medium' => 'Medium',
	'g-mediumlarge' => 'Medium-stor',
	'g-new' => 'ny',
	'g-next' => 'Neste',
	'g-previous' => 'Forrige',
	'g-remove' => 'Fjern',
	'g-remove-gift' => 'Fjern denne gaven',
	'g-remove-message' => 'Er du sikker på at du vil fjerne gaven «$1»?',
	'g-recent-recipients' => 'Andre som nylig mottok denne gaven',
	'g-remove-success-title' => 'Du har fjernet gaven «$1»',
	'g-remove-success-message' => 'Gaven «$1» har blitt fjernet.',
	'g-remove-title' => 'Fjern «$1»?',
	'g-send-gift' => 'Send gave',
	'g-select-a-friend' => 'velg en venn',
	'g-sent-title' => 'Du har har sendt ei gave til $1',
	'g-sent-message' => 'Du har sendt følgende gave til $1.',
	'g-small' => 'Liten',
	'g-to-another' => 'Gi til noen andre',
	'g-uploadsuccess' => 'Vellykket opplasting',
	'g-viewgiftlist' => 'Se gavelisten',
	'g-your-profile' => 'Profilen din',
	'gift_received_subject' => '$1 har send deg gava «$2» på {{SITENAME}}!',
	'gift_received_body' => 'Hei $1.

$2 sendte deg akkurat $3-gava på {{SITENAME}}.

Vil du lese det som $2 skrev til deg og se gaven din? Klikk på linken under:

$4

Vi håper at du vil like den!

Takk,

{{SITENAME}}-laget

---

Vil du ikke lenger motta e-poster fra oss?

Klikk på $5
og forandre på dine instillinger for å slå av e-postmeldinger.',
	'right-giftadmin' => 'Opprett ny og endre eksisterende gaver',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author Jfblanc
 */
$messages['oc'] = array(
	'giftmanager' => 'Gestionari de presents',
	'giftmanager-addgift' => '+ Apondre un present novèl',
	'giftmanager-access' => 'accès al present',
	'giftmanager-description' => 'descripcion del present',
	'giftmanager-giftimage' => 'imatge del present',
	'giftmanager-image' => "apondre / remplaçar l'imatge",
	'giftmanager-giftcreated' => 'Lo present es estat creat',
	'giftmanager-giftsaved' => 'Lo present es estat salvat',
	'giftmanager-public' => 'public',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Veire la lista dels presents',
	'g-add-message' => 'Apondre un messatge',
	'g-back-edit-gift' => "Tornar a la modificacion d'aqueste present",
	'g-back-gift-list' => 'Tornar a la lista dels presents',
	'g-back-link' => '< Tornar a la pagina de $1',
	'g-choose-file' => 'Causir lo fichièr :',
	'g-cancel' => 'Anullar',
	'g-count' => '$1 a $2 {{PLURAL:$2|present|presents}}.',
	'g-create-gift' => 'Crear un present',
	'g-created-by' => 'creat per',
	'g-current-image' => 'Imatge actual',
	'g-delete-message' => "Sètz segur(a) que volètz suprimir lo present « $1 » ? Aquò o suprimirà tanben als utilizaires que l'an recebut.",
	'g-description-title' => 'Present « $2 » de $1',
	'g-error-do-not-own' => 'Possedètz pas aqueste present.',
	'g-error-message-blocked' => 'Sètz blocat(ada) e doncas, podètz pas donar de presents',
	'g-error-message-invalid-link' => "Lo ligam qu'avètz provesit es invalid.",
	'g-error-message-login' => 'Vos cal connectar per donar de presents',
	'g-error-message-no-user' => "L'utilizaire qu'ensajatz de veire existís pas.",
	'g-error-message-to-yourself' => 'Podètz pas vos donar un present a vos meteis.',
	'g-error-title' => 'Ops, avètz pres un marrit torn !',
	'g-file-instructions' => 'Vòstre imatge deu èsser jpeg, png o gif (mas pas animada) e deu èsser mai pichona que 100 Ko.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'present',
	'g-gift-name' => 'nom del present',
	'g-give-gift' => 'Donar lo present',
	'g-give-all' => 'Enveja de donar un present a $1 ? Clicatz sus un present çaijós e clicatz enseguida sus « Mandar lo present ». Es aisit.',
	'g-give-all-message-title' => 'Apondre un messatge',
	'g-give-all-title' => 'Donar un present a $1',
	'g-give-enter-friend-title' => "Se coneissètz lo nom de l'utilizaire, picatz-o çaijós",
	'g-given' => 'Lo present es estat donat $1 {{PLURAL:$1|còp|còps}}',
	'g-give-list-friends-title' => 'Seleccionatz dempuèi la lista de vòstres amics',
	'g-give-list-select' => 'seleccionatz un amic',
	'g-give-separator' => 'o',
	'g-give-no-user-message' => 'Los presents e prèmis son plan per far conéisser vòstres amics !',
	'g-give-no-user-title' => 'A qui volètz donar un present ?',
	'g-give-to-user-title' => 'Mandar lo present « $1 » a $2',
	'g-give-to-user-message' => 'Enveja de donar un present diferent <a href="$2">un present diferent</a> a $1 ?',
	'g-go-back' => 'Tornar',
	'g-imagesbelow' => 'Los imatges que seràn utilizats sul site son afichats çaijós',
	'g-large' => 'Grand',
	'g-list-title' => 'Lista dels presents de $1',
	'g-main-page' => 'Acuèlh',
	'g-medium' => 'Mejan',
	'g-mediumlarge' => 'Mejan-Grand',
	'g-new' => 'novèl',
	'g-next' => 'Seguent',
	'g-previous' => 'Precedent',
	'g-remove' => 'Levar',
	'g-remove-gift' => 'Levar aqueste present',
	'g-remove-message' => 'Sètz segur(a) que volètz levar lo present « $1 » ?',
	'g-recent-recipients' => "Autres beneficiaris recents d'aqueste present",
	'g-remove-success-title' => 'Avètz levat lo present « $1 » amb succès',
	'g-remove-success-message' => 'Lo present « $1 » es estat levat.',
	'g-remove-title' => 'Levar « $1 » ?',
	'g-send-gift' => 'Mandar lo present',
	'g-select-a-friend' => 'seleccionatz un amic',
	'g-sent-title' => 'Avètz mandat lo present a $1',
	'g-sent-message' => 'Avètz mandat lo present seguent a $1.',
	'g-small' => 'Pichon',
	'g-to-another' => "Donar a qualqu'un mai",
	'g-uploadsuccess' => 'Telecargament efectuat amb succès',
	'g-viewgiftlist' => 'Veire la lista dels presents',
	'g-your-profile' => 'Vòstre perfil',
	'gift_received_subject' => '$1 vos a mandat lo present $2 sus {{SITENAME}} !',
	'gift_received_body' => "Bonjorn $1,

$2 vos ven de mandar lo present $3 sus {{SITENAME}}.

Volètz veire la nòta $2 que vos es adreçada e veire vòstre present ? Clicatz sul ligam çaijós :

$4

Esperam que vos agradarà !

Mercés,


L'equipa de {{SITENAME}}

---

Volètz pas recebre mai de corrièrs electronics de nòstra part ?

Clicatz $5
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.",
	'right-giftadmin' => "Crear de presents novèls e modificar los qu'existisson",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'g-next' => 'ପର',
	'g-previous' => 'ଆଗ',
	'g-remove' => 'ବାହାର କରିବା',
	'g-remove-title' => 'ବାହାର କରିବା "$1"?',
);

/** Ossetic (Ирон)
 * @author Amikeco
 * @author Bouron
 */
$messages['os'] = array(
	'g-cancel' => 'Ныууадзын',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'giftmanager-public' => 'public',
	'giftmanager-private' => 'private',
	'g-back-link' => 'Zerrick zur Uffstelling vun $1',
	'g-from' => 'vun <a href="$1">$2</a>',
	'g-give-separator' => 'odder',
	'g-go-back' => 'Geh zerrick',
	'g-large' => 'Gross',
	'g-main-page' => 'Haaptblatt',
	'g-new' => 'nei',
	'g-next' => 'Neegschte',
	'g-small' => 'glee',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'g-next' => 'Negschte',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'giftmanager' => 'Zarządzanie prezentami',
	'giftmanager-addgift' => '+ Dodaj nowy prezent',
	'giftmanager-access' => 'dostęp do prezentu',
	'giftmanager-description' => 'opis prezentu',
	'giftmanager-giftimage' => 'obrazu prezentu',
	'giftmanager-image' => 'Dodaj lub zastąp grafikę',
	'giftmanager-giftcreated' => 'Prezent został utworzony',
	'giftmanager-giftsaved' => 'Prezent został zapisany',
	'giftmanager-public' => 'publiczny',
	'giftmanager-private' => 'prywatny',
	'giftmanager-view' => 'Zobacz listę prezentów',
	'g-add-message' => 'Dodaj wiadomość',
	'g-back-edit-gift' => 'Powrót do edycji tego prezentu',
	'g-back-gift-list' => 'Powrót do listy prezentów',
	'g-back-link' => '< Powrót do strony $1',
	'g-choose-file' => 'Wybierz plik',
	'g-cancel' => 'Anuluj',
	'g-count' => '$1 otrzymał $2 {{PLURAL:$2|prezent|prezenty|prezentów}}.',
	'g-create-gift' => 'Tworzenie prezentu',
	'g-created-by' => 'utworzony przez',
	'g-current-image' => 'Aktualna grafika',
	'g-delete-message' => 'Czy jesteś pewien, że chcesz usunąć prezent „$1”?
Spowoduje to również usunięcie go u użytkowników, którzy go otrzymali.',
	'g-description-title' => 'Prezent „$2” od $1',
	'g-error-do-not-own' => 'Nie masz tego prezentu.',
	'g-error-message-blocked' => 'Jesteś obecnie zablokowany i nie możesz dawać prezentów',
	'g-error-message-invalid-link' => 'Link który wprowadziłeś jest nieprawidłowy.',
	'g-error-message-login' => 'Należy zalogować się aby dawać prezenty',
	'g-error-message-no-user' => 'Użytkownik, którego próbujesz wyświetlić nie istnieje.',
	'g-error-message-to-yourself' => 'Nie można dać prezentu samemu siebie.',
	'g-error-title' => 'Ojej. Nie można tego zrobić!',
	'g-file-instructions' => 'Obrazek musi być w formacie jpeg, png lub gif (gif bez animacji) oraz musi być mniejszy niż 100kb.',
	'g-from' => 'od <a href="$1">$2</a>',
	'g-gift' => 'prezent',
	'g-gift-name' => 'nazwa prezentu',
	'g-give-gift' => 'Daj prezent',
	'g-give-all' => 'Chcesz ofiarować $1 prezent?
Wystarczy kliknąć jeden z prezentów poniżej, a następnie przycisk „Wyślij prezent”.
To bardzo łatwe.',
	'g-give-all-message-title' => 'Dodaj wiadomość',
	'g-give-all-title' => 'Prezent dla $1',
	'g-give-enter-friend-title' => 'Jeśli znasz nazwę użytkownika, wpisz ją poniżej',
	'g-given' => 'Ten prezent został podarowany $1 {{PLURAL:$1|raz|razy}}',
	'g-give-list-friends-title' => 'Wybierz z listy przyjaciół',
	'g-give-list-select' => 'wybierz znajomego',
	'g-give-separator' => 'lub',
	'g-give-no-user-message' => 'Prezenty i nagrody to świetny sposób aby okazać swoją przyjaźń!',
	'g-give-no-user-title' => 'Komu chciałbyś dać prezent?',
	'g-give-to-user-title' => 'Wyślij prezent „$1” do $2',
	'g-give-to-user-message' => 'Czy chcesz dać $1 <a href="$2">inny prezent</a>?',
	'g-go-back' => 'Wróć',
	'g-imagesbelow' => 'Poniżej znajdują się Twoje grafiki, które zostaną wykorzystane na stronie',
	'g-large' => 'Duży',
	'g-list-title' => 'lista prezentów $1',
	'g-main-page' => 'Strona główna',
	'g-medium' => 'Średni',
	'g-mediumlarge' => 'Średnio–duży',
	'g-new' => 'nowy',
	'g-next' => 'Następny',
	'g-previous' => 'Poprzedni',
	'g-remove' => 'Usuń',
	'g-remove-gift' => 'Usuń ten prezent',
	'g-remove-message' => 'Czy na pewno chcesz usunąć prezent „$1”?',
	'g-recent-recipients' => 'Pozostali ostatnio obdarowani tym darem',
	'g-remove-success-title' => 'Usunąłeś prezent „$1”',
	'g-remove-success-message' => 'Prezent „$1” został usunięty.',
	'g-remove-title' => 'Usunąć „$1”?',
	'g-send-gift' => 'Wyślij prezent',
	'g-select-a-friend' => 'wybierz znajomego',
	'g-sent-title' => 'Wysłałeś prezent do $1',
	'g-sent-message' => 'Wysłałeś następujący prezent do $1.',
	'g-small' => 'Mały',
	'g-to-another' => 'Daj komuś innemu',
	'g-uploadsuccess' => 'Przesłano',
	'g-viewgiftlist' => 'Zobacz listę prezentów',
	'g-your-profile' => 'Twój profil',
	'gift_received_subject' => '$1 dał Ci prezent $2 na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'gift_received_body' => 'Cześć $1.

$2 wysłał prezent $3 dla Ciebie na {{GRAMMAR:MS.lp|{{SITENAME}}}}.

Chcesz przeczytać dedykację od $2 i zobaczyć prezent? Kliknij poniższy link:

$4

Mamy nadzieję, że prezent sprawił Ci radość!

Dziękujemy,

zespół {{GRAMMAR:D.lp|{{SITENAME}}}}

---
Nie chcesz otrzymywać więcej wiadomości od nas?

Kliknij $5
i zmień ustawienia dla powiadomień email.',
	'right-giftadmin' => 'Tworzenie nowych oraz edytowanie istniejących prezentów',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'giftmanager' => 'Mansé dij cadò',
	'giftmanager-addgift' => '+ Gionté un cadò neuv',
	'giftmanager-access' => 'acess al cadò',
	'giftmanager-description' => 'descrission dël cadò',
	'giftmanager-giftimage' => 'figura dël cadò',
	'giftmanager-image' => 'gionta/rimpiassa plancia',
	'giftmanager-giftcreated' => "Ël cadò a l'é stàit creà",
	'giftmanager-giftsaved' => "Ël cadò a l'é stàit salvà",
	'giftmanager-public' => 'pùblich',
	'giftmanager-private' => 'privà',
	'giftmanager-view' => 'Visualisé la lista dij cadò',
	'g-add-message' => 'Gionta un mëssagi',
	'g-back-edit-gift' => 'André për modifiché ës cadò-sì',
	'g-back-gift-list' => 'André a la lista dij cadò',
	'g-back-link' => '< André a la pàgina ëd $1',
	'g-choose-file' => "Serne l'archivi:",
	'g-cancel' => 'Scancelé',
	'g-count' => "$1 a l'ha $2 {{PLURAL:$2|cadò|cadò}}.",
	'g-create-gift' => 'Creé un cadò',
	'g-created-by' => 'creà da',
	'g-current-image' => 'Figura corenta',
	'g-delete-message' => 'É-lo sigur ëd vorèj scancelé ël cadò "$1"?
Sòn a lo scancelërà ëdcò da j\'utent che a l\'han arseivulo.',
	'g-description-title' => 'Cadò $2 da la part ëd $1',
	'g-error-do-not-own' => "A l'ha pa sto cadò-sì.",
	'g-error-message-blocked' => "A l'é blocà al moment e a peul pa fé ëd cadò",
	'g-error-message-invalid-link' => "Ël colegament ch'it l'has anserì a l'é pa bon.",
	'g-error-message-login' => 'A deuv intré ant ël sistema për fé dij cadò',
	'g-error-message-no-user' => "L'utent ch'it l'has provà a visualisé a esist pa.",
	'g-error-message-to-yourself' => 'A peul pa fesse un cadò da sol.',
	'g-error-title' => "Contacc, a l'é andaje mal!",
	'g-file-instructions' => 'Toa figura a deuv esse na jpeg, png o gif (gif pa animà), e a deuv esse meno ëd 100kb an dimension.',
	'g-from' => 'da <a href="$1">$2</a>',
	'g-gift' => 'cadò',
	'g-gift-name' => 'nòm dël cadò',
	'g-give-gift' => 'Fa un cadò',
	'g-give-all' => 'Veul-lo feje un cadò a $1?
A basta mach ësgnaché ansima a un dij cadò sì-sota e sgnaché "mandé ël cadò".
A l\'é bel fé.',
	'g-give-all-message-title' => 'Gionté un mëssagi.',
	'g-give-all-title' => 'Feje un cadò a $1.',
	'g-give-enter-friend-title' => "S'a conòss ël nòm ëd l'utent, ch'a lo scriva sì-sota",
	'g-given' => "Ës cadò a l'é stàit dàit $1 {{PLURAL:$1|vira|vire}}",
	'g-give-list-friends-title' => "Selession-a da toa lista d'amis",
	'g-give-list-select' => "selession-a n'amis",
	'g-give-separator' => 'o',
	'g-give-no-user-message' => "Cadò e premi a son na gran manera d'arcompensé ij sò amis!",
	'g-give-no-user-title' => 'A chi a vorërìa feje un cadò?',
	'g-give-to-user-title' => 'Mandé ël cadò "$1" a $2',
	'g-give-to-user-message' => 'Veul-lo feje a $1 un <a href="$2">cadò diferent</a>?',
	'g-go-back' => 'Va andré',
	'g-imagesbelow' => "Sota a-i son toe figure ch'a saran dovrà an sël sit",
	'g-large' => 'Gròss',
	'g-list-title' => 'Lista dij cadò ëd $1',
	'g-main-page' => 'Pàgina prinsipal',
	'g-medium' => 'Medi',
	'g-mediumlarge' => 'Gròss-medi',
	'g-new' => 'neuv',
	'g-next' => 'Dapress',
	'g-previous' => 'Prima',
	'g-remove' => 'Gava',
	'g-remove-gift' => 'Gavé sto cadò-sì',
	'g-remove-message' => 'É-lo sigur ëd vorèj gavé ël cadò "$1"?',
	'g-recent-recipients' => "Àutri ch'a l'han arseivù ëd recent ës cadò",
	'g-remove-success-title' => 'A l\'ha gavà da bin ël cadò "$1"',
	'g-remove-success-message' => 'Ël cadò "$1" a l\'é stàit gavà.',
	'g-remove-title' => 'Gavé "$1"?',
	'g-send-gift' => 'Mandé ël cadò',
	'g-select-a-friend' => "ch'a selession-a n'amis",
	'g-sent-title' => "A l'ha mandà un cadò a $1",
	'g-sent-message' => "A l'ha mandà ël cadò sì-sota a $1.",
	'g-small' => 'Cit',
	'g-to-another' => "Delo a cheidun d'àutri",
	'g-uploadsuccess' => 'Carià da bin',
	'g-viewgiftlist' => 'Vëdde la lista dij cadò',
	'g-your-profile' => 'Tò profil',
	'gift_received_subject' => "$1 a l'ha mandaje ël cadò $2 dzora a {{SITENAME}}!",
	'gift_received_body' => "Cerea $1.

$2 a l'ha pen-a mandaje ël cadò $3 dzora a {{SITENAME}}.

Veul-lo lese le nòte che $2 a l'ha lassaje e vardé sò cadò? Ch'a sgnaca l'anliura sota:

$4

I speroma ch'a-j piasa!

L'echip ëd {{SITENAME}}

---

Ch'a scota, veul-lo pa pi arsèive ëd mëssagi da noiàutri?

Ch'a sgnaca $5
e ch'a cambia ij sò gust për disabilité le notìfiche an pòsta eletrònica.",
	'right-giftadmin' => 'Creé ëd cadò neuv e modifiché coj esistent',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'giftmanager-view' => 'د ډاليو لړليک کتل',
	'g-add-message' => 'يو پيغام ورسره کول',
	'g-choose-file' => 'دوتنه ټاکل:',
	'g-cancel' => 'ناګارل',
	'g-create-gift' => 'ډالۍ جوړول',
	'g-current-image' => 'اوسنی انځور',
	'g-gift' => 'ډالۍ',
	'g-gift-name' => 'د ډالۍ نوم',
	'g-give-gift' => 'ډالۍ ورکول',
	'g-give-all-message-title' => 'يو پيغام ورګډول',
	'g-give-list-select' => 'يو ملګری ټاکل',
	'g-large' => 'لوی',
	'g-main-page' => 'لومړی مخ',
	'g-new' => 'نوی',
	'g-next' => 'راتلونکی',
	'g-previous' => 'پخوانی',
	'g-send-gift' => 'ډالۍ لېږل',
	'g-select-a-friend' => 'يو ملګری ټاکل',
	'g-small' => 'وړوکی',
	'g-viewgiftlist' => 'د ډاليو لړليک کتل',
	'g-your-profile' => 'ستاسې پېژنليک',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Vanessa Sabino
 * @author Waldir
 */
$messages['pt'] = array(
	'giftmanager' => 'Administrador de prendas',
	'giftmanager-addgift' => '+ Adicionar nova prenda',
	'giftmanager-access' => 'acesso à prenda',
	'giftmanager-description' => 'descrição da prenda',
	'giftmanager-giftimage' => 'imagem da prenda',
	'giftmanager-image' => 'adicionar/substituir imagem',
	'giftmanager-giftcreated' => 'A prenda foi criada',
	'giftmanager-giftsaved' => 'A prenda foi gravada',
	'giftmanager-public' => 'público',
	'giftmanager-private' => 'privado',
	'giftmanager-view' => 'Ver lista de prendas',
	'g-add-message' => 'Adicionar mensagem',
	'g-back-edit-gift' => 'Voltar para editar esta prenda',
	'g-back-gift-list' => 'Voltar à lista de prendas',
	'g-back-link' => '< Voltar à página de $1',
	'g-choose-file' => 'Escolher ficheiro:',
	'g-cancel' => 'Cancelar',
	'g-count' => '$1 tem {{PLURAL:$2|uma prenda|$2 prendas}}.',
	'g-create-gift' => 'Criar prenda',
	'g-created-by' => 'criada por',
	'g-current-image' => 'Imagem actual',
	'g-delete-message' => 'Tem a certeza de que deseja eliminar a prenda "$1"?
Isto irá também retirá-la aos utilizadores que a tenham recebido.',
	'g-description-title' => 'prenda "$2" de $1',
	'g-error-do-not-own' => 'Esta prenda não lhe pertence.',
	'g-error-message-blocked' => 'Está bloqueado e não pode dar prendas',
	'g-error-message-invalid-link' => 'O link que forneceu é inválido.',
	'g-error-message-login' => 'Tem de estar autenticado para dar prendas',
	'g-error-message-no-user' => 'O utilizador que está tentando ver não existe.',
	'g-error-message-to-yourself' => 'Não pode dar prendas a si próprio.',
	'g-error-title' => 'Ui, enganou-se no caminho!',
	'g-file-instructions' => 'A imagem tem de ser um jpeg, png or gif (sem gifs animados) e ter tamanho inferior a 100KB.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'prenda',
	'g-gift-name' => 'nome da prenda',
	'g-give-gift' => 'Dar prenda',
	'g-give-all' => 'Quer dar uma prenda a $1?
Clique numa das prendas abaixo e depois em "Enviar prenda".
É mesmo fácil.',
	'g-give-all-message-title' => 'Adicionar mensagem',
	'g-give-all-title' => 'Dar uma prenda a $1',
	'g-give-enter-friend-title' => 'Se conhece o nome do utilizador, escreva-o abaixo',
	'g-given' => 'Esta prenda foi dada {{PLURAL:$1|uma vez|$1 vezes}}',
	'g-give-list-friends-title' => 'Seleccione da sua lista de amigos',
	'g-give-list-select' => 'seleccione um amigo',
	'g-give-separator' => 'ou',
	'g-give-no-user-message' => 'Prendas e prémios são uma óptima forma de dar reconhecimento aos seus amigos!',
	'g-give-no-user-title' => 'A quem gostaria de dar uma prenda?',
	'g-give-to-user-title' => 'Enviar a prenda "$1" a $2',
	'g-give-to-user-message' => 'Quer dar a $1 uma <a href="$2">prenda diferente</a>?',
	'g-go-back' => 'Voltar',
	'g-imagesbelow' => 'Abaixo estão as imagens que serão usadas no site',
	'g-large' => 'Grande',
	'g-list-title' => 'Lista de prendas de $1',
	'g-main-page' => 'Página principal',
	'g-medium' => 'Médio',
	'g-mediumlarge' => 'Médio-Grande',
	'g-new' => 'novo',
	'g-next' => 'Próximo',
	'g-previous' => 'Anterior',
	'g-remove' => 'Remover',
	'g-remove-gift' => 'Remover esta prenda',
	'g-remove-message' => 'Tem a certeza de que deseja remover a prenda "$1"?',
	'g-recent-recipients' => 'Outros que receberam esta prenda recentemente',
	'g-remove-success-title' => 'Removeu a prenda "$1"',
	'g-remove-success-message' => 'A prenda "$1" foi removida.',
	'g-remove-title' => 'Remover "$1"?',
	'g-send-gift' => 'Enviar prenda',
	'g-select-a-friend' => 'seleccionar um amigo',
	'g-sent-title' => 'Enviou uma prenda a $1',
	'g-sent-message' => 'Enviou a seguinte prenda a $1.',
	'g-small' => 'Pequeno',
	'g-to-another' => 'Dar a outra pessoa',
	'g-uploadsuccess' => 'Upload bem sucedido',
	'g-viewgiftlist' => 'Ver lista de prendas',
	'g-your-profile' => 'O seu perfil',
	'gift_received_subject' => '$1 enviou-lhe a prenda $2 na {{SITENAME}}!',
	'gift_received_body' => 'Olá $1,

$2 acabou de enviar-lhe a prenda $3 na {{SITENAME}}.

Quer ler o recado que $2 deixou e ver a sua prenda? Clique no link abaixo:

$4

Esperamos que tenha gostado!

Obrigado,


A equipa da {{SITENAME}}

---

Olhe, quer parar de receber as nossas mensagens?

Clique $5
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'right-giftadmin' => 'Crie novas prendas e edite as existentes',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'giftmanager' => 'Gerenciador de Presentes',
	'giftmanager-addgift' => '+ Adicionar Novo Presente',
	'giftmanager-access' => 'acesso ao presente',
	'giftmanager-description' => 'descrição do presente',
	'giftmanager-giftimage' => 'imagem do presente',
	'giftmanager-image' => 'adicionar/substituir imagem',
	'giftmanager-giftcreated' => 'O presente foi criado',
	'giftmanager-giftsaved' => 'O presente foi salvo',
	'giftmanager-public' => 'público',
	'giftmanager-private' => 'privado',
	'giftmanager-view' => 'Ver Lista de Presentes',
	'g-add-message' => 'Adicionar Mensagem',
	'g-back-edit-gift' => 'Voltar para Editar Este Presente',
	'g-back-gift-list' => 'Voltar para Lista de Presentes',
	'g-back-link' => '< Voltar para página de $1',
	'g-choose-file' => 'Escolher Arquivo:',
	'g-cancel' => 'Cancelar',
	'g-count' => '$1 tem $2 {{PLURAL:$2|presente|presentes}}.',
	'g-create-gift' => 'Criar Presente',
	'g-created-by' => 'criado por',
	'g-current-image' => 'Imagem Atual',
	'g-delete-message' => 'Você tem certeza de que quer excluir o presente "$1"? Isto também irá excluí-lo de usuários que podem tê-lo recebido.',
	'g-description-title' => 'presente "$2" de $1',
	'g-error-do-not-own' => 'Você não possui este presente.',
	'g-error-message-blocked' => 'Você está bloqueado atualmente e não pode dar presentes',
	'g-error-message-invalid-link' => 'A ligação em que você entrou é inválida.',
	'g-error-message-login' => 'Você precisa estar autenticado para enviar presentes',
	'g-error-message-no-user' => 'O utilizador que você está tentando ver não existe.',
	'g-error-message-to-yourself' => 'Você não pode dar um presente a si mesmo',
	'g-error-title' => 'Ops, você entrou no lugar errado!',
	'g-file-instructions' => 'Sua imagem precisa ser um jpeg, png or gif (sem gifs animados), e precisa ter tamanho menor que 100kb.',
	'g-from' => 'de <a href="$1">$2</a>',
	'g-gift' => 'presente',
	'g-gift-name' => 'nome do presente',
	'g-give-gift' => 'Dar Presente',
	'g-give-all' => 'Quer dar um presente para $1?
Apenas clique em um dos presentes abaixo e clique em "Enviar Presente".
É fácil assim.',
	'g-give-all-message-title' => 'Adicionar Mensagem',
	'g-give-all-title' => 'Dar um Presente para $1',
	'g-give-enter-friend-title' => 'Se você sabe o nome do utilizador, escreva-o abaixo',
	'g-given' => 'Este presente foi dado $1 {{PLURAL:$1|vez|vezes}}',
	'g-give-list-friends-title' => 'Selecione da sua lista de amigos',
	'g-give-list-select' => 'selecione um amigo',
	'g-give-separator' => 'ou',
	'g-give-no-user-message' => 'Presentes e prêmios são uma ótima maneira de dar reconhecimento aos seus amigos!',
	'g-give-no-user-title' => 'Para quem você gostaria de dar um presente?',
	'g-give-to-user-title' => 'Enviar presente "$1" para $2',
	'g-give-to-user-message' => 'Quer dar a $1 um <a href="$2">presente diferente</a>?',
	'g-go-back' => 'Voltar',
	'g-imagesbelow' => 'Abaixo estão as imagens que serão usadas no site',
	'g-large' => 'Grande',
	'g-list-title' => 'Lista de Presentes de $1',
	'g-main-page' => 'Página Principal',
	'g-medium' => 'Médio',
	'g-mediumlarge' => 'Médio-Grande',
	'g-new' => 'novo',
	'g-next' => 'Próximo',
	'g-previous' => 'Anterior',
	'g-remove' => 'Remover',
	'g-remove-gift' => 'Remover este Presente',
	'g-remove-message' => 'Tem certeza de que deseja remover o presente "$1"?',
	'g-recent-recipients' => 'Outros ganhadores deste presente',
	'g-remove-success-title' => 'Você removeu com sucesso o presente "$1"',
	'g-remove-success-message' => 'O presente "$1" foi removido.',
	'g-remove-title' => 'Remover "$1"?',
	'g-send-gift' => 'Enviar Presente',
	'g-select-a-friend' => 'selecionar um amigo',
	'g-sent-title' => 'Você enviou um presente para $1',
	'g-sent-message' => 'Você enviou o seguinte presente para $1.',
	'g-small' => 'Pequeno',
	'g-to-another' => 'Dar para Outra Pessoa',
	'g-uploadsuccess' => 'Carregamento bem sucedido',
	'g-viewgiftlist' => 'Ver Lista de Presentes',
	'g-your-profile' => 'Seu Perfil',
	'gift_received_subject' => '$1 enviou para você o Presente $2 Gift em {{SITENAME}}!',
	'gift_received_body' => 'Oi $1:

$2 acabou de enviar o presente $3 em {{SITENAME}}.

Quer ler o recado que $2 deixou e ver seu presente? Clique na ligação abaixo:

$4

Esperamos que tenha gostado!

Obrigado,


O Time de {{SITENAME}}

---

Ei, quer parer de receber e-mails de nós?

Clique $5
e altere suas preferências para desabilitar e-mails de notificação.',
	'right-giftadmin' => 'Crie novos e edite presentes existentes',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'giftmanager-public' => 'public',
	'giftmanager-private' => 'privat',
	'g-choose-file' => 'Alegeți fișierul:',
	'g-cancel' => 'Revocare',
	'g-create-gift' => 'Creați cadou',
	'g-created-by' => 'creat de',
	'g-current-image' => 'Imagine actuală',
	'g-error-do-not-own' => 'Nu dețineți acest cadou.',
	'g-error-message-blocked' => 'Sunteți în prezent blocat și nu puteți da cadouri',
	'g-error-message-invalid-link' => 'Legătura introdusă nu este corectă.',
	'g-error-message-login' => 'Trebuie să vă autentificați pentru a da cadouri',
	'g-error-message-no-user' => 'Utilizatorul pe care încercați să îl vizualizați nu există.',
	'g-error-message-to-yourself' => 'Nu vă puteți da un cadou dumneavoastră.',
	'g-from' => 'de la <a href="$1">$2</a>',
	'g-gift' => 'cadou',
	'g-gift-name' => 'numele cadoului',
	'g-give-gift' => 'Dați cadoul',
	'g-give-all-message-title' => 'Adaugă un mesaj',
	'g-give-all-title' => 'Dați un cadou lui $1',
	'g-give-list-select' => 'alegeți un prieten',
	'g-give-separator' => 'sau',
	'g-go-back' => 'Mergeți înapoi',
	'g-large' => 'Mare',
	'g-list-title' => 'lista de cadouri a lui $1',
	'g-main-page' => 'Pagina principală',
	'g-medium' => 'Mediu',
	'g-mediumlarge' => 'Mediu-mare',
	'g-new' => 'nou',
	'g-next' => 'Următorul',
	'g-previous' => 'Prec',
	'g-remove' => 'Eliminare',
	'g-remove-gift' => 'Eliminați acest cadou',
	'g-remove-title' => 'Eliminați "$1"?',
	'g-send-gift' => 'Trimitere cadou',
	'g-select-a-friend' => 'selectați un prieten',
	'g-small' => 'Mic',
	'g-uploadsuccess' => 'Încărcare reușită',
	'g-viewgiftlist' => 'Vedeți lista de cadouri',
	'g-your-profile' => 'Profilul dvs.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'giftmanager' => 'Gestore de le riale',
	'giftmanager-addgift' => "+ Aggiunge 'nu riale nuève",
	'giftmanager-access' => 'accede a le riale',
	'giftmanager-description' => "descrizione d'u riale",
	'giftmanager-giftimage' => "immagine d'u riale",
	'giftmanager-image' => "aggiunge/cange 'n'immaggine",
	'giftmanager-giftcreated' => "'U riale ha state ccrejate",
	'giftmanager-giftsaved' => "'U riale ha state reggistrate",
	'giftmanager-public' => 'pubbliche',
	'giftmanager-private' => 'private',
	'giftmanager-view' => "Vide 'a liste de le riale",
	'g-add-message' => "Aggiunge 'nu messagge",
	'g-gift' => 'riale',
	'g-gift-name' => "nome d'u riale",
	'g-give-gift' => "Fà 'u riale",
	'g-give-separator' => 'o',
	'g-go-back' => 'Tuèrne rrete',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Innv
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'giftmanager' => 'Управление подарками',
	'giftmanager-addgift' => '+ Добавить новый подарок',
	'giftmanager-access' => 'доступ подарка',
	'giftmanager-description' => 'описание подарка',
	'giftmanager-giftimage' => 'изображение подарка',
	'giftmanager-image' => 'добавить/заменить изображение',
	'giftmanager-giftcreated' => 'Подарок был создан',
	'giftmanager-giftsaved' => 'Подарок был сохранён',
	'giftmanager-public' => 'публичные',
	'giftmanager-private' => 'частные',
	'giftmanager-view' => 'Просмотр списка подарков',
	'g-add-message' => 'Добавить сообщение',
	'g-back-edit-gift' => 'Вернуться к редактированию этого подарка',
	'g-back-gift-list' => 'Вернуться к списку подарков',
	'g-back-link' => '< Вернуться к странице $1',
	'g-choose-file' => 'Выберите файл:',
	'g-cancel' => 'Отмена',
	'g-count' => '$1 имеет $2 {{PLURAL:$2|подарок|подарка|подарков}}',
	'g-create-gift' => 'Создать подарок',
	'g-created-by' => 'создан',
	'g-current-image' => 'Текущее изображение',
	'g-delete-message' => 'Вы уверены, что хотите удалить подарок «$1»?
Это также удалит его у всех участников, которым он был передан.',
	'g-description-title' => 'Подарок $1 «$2»',
	'g-error-do-not-own' => 'Вы не владеете этим подарком.',
	'g-error-message-blocked' => 'Вы сейчас заблокированы и не можете дарить подарки',
	'g-error-message-invalid-link' => 'Введённая вами ссылка ошибочна.',
	'g-error-message-login' => 'Вы должны представиться системе, чтобы дарить подарки',
	'g-error-message-no-user' => 'Участник, которого вы хотите просмотреть, не существует',
	'g-error-message-to-yourself' => 'Вы не можете дарить подарки сами себе.',
	'g-error-title' => 'Опа, вы ввели неправильное название!',
	'g-file-instructions' => 'Ваше изображение должно быть в формате jpeg, png или gif (неанимированный gif), и быть меньше 100 КБ.',
	'g-from' => 'от <a href="$1">$2</a>',
	'g-gift' => 'подарок',
	'g-gift-name' => 'название подарка',
	'g-give-gift' => 'Подарить подарок',
	'g-give-all' => 'Хотите передать $1 подарок?
Выберите один из подарков ниже и нажмите «Отправить подарок».
Это просто.',
	'g-give-all-message-title' => 'Добавить сообщение',
	'g-give-all-title' => 'Подарить подарок для $1',
	'g-give-enter-friend-title' => 'Если вы знаете имя участника, введите его ниже',
	'g-given' => 'Этот подарок был подарен $1 {{PLURAL:$1|раз|раза|раза}}',
	'g-give-list-friends-title' => 'Выбор из вашего списка друзей',
	'g-give-list-select' => 'выбрать друга',
	'g-give-separator' => 'или',
	'g-give-no-user-message' => 'Подарки и награды — хороший способ отметить ваших друзей!',
	'g-give-no-user-title' => 'Кому бы вы хотели подарить подарок?',
	'g-give-to-user-title' => 'Отправить подарок «$1» к $2',
	'g-give-to-user-message' => 'Хотите подарить $1 <a href="$2">другой подарок</a>?',
	'g-go-back' => 'Назад',
	'g-imagesbelow' => 'Ниже находятся ваши изображения, которые будут использоваться на сайте',
	'g-large' => 'Большой',
	'g-list-title' => 'Список подарков $1',
	'g-main-page' => 'Заглавная страница',
	'g-medium' => 'Средний',
	'g-mediumlarge' => 'Средний-большой',
	'g-new' => 'новый',
	'g-next' => 'Следующий',
	'g-previous' => 'Предыдущий',
	'g-remove' => 'Удалить',
	'g-remove-gift' => 'Удалить этот подарок',
	'g-remove-message' => 'Вы действительно хотите удалить подарок «$1»?',
	'g-recent-recipients' => 'Другие недавние получатели этого подарка',
	'g-remove-success-title' => 'Вы успешно удалили подарок «$1»',
	'g-remove-success-message' => 'Подарок «$1» был удалён.',
	'g-remove-title' => 'Удалить «$1» ?',
	'g-send-gift' => 'Отправить подарок',
	'g-select-a-friend' => 'выберите из друзей',
	'g-sent-title' => 'Вы отправили подарок к $1',
	'g-sent-message' => 'Вы отправили следующий подарок к $1.',
	'g-small' => 'Маленький',
	'g-to-another' => 'Подарить кому-нибудь ещё',
	'g-uploadsuccess' => 'Загрузка успешно завершена',
	'g-viewgiftlist' => 'Просмотр списка подарков',
	'g-your-profile' => 'Ваш профиль',
	'gift_received_subject' => '$1 отправил вам подарок $2 на {{SITENAME}}!',
	'gift_received_body' => 'Здравствуйте, $1.

$2 только что отправил вам подарок $3 на {{SITENAME}}.

Хотите прочитать примечание $2, отправленное вам, и просмотреть ваш подарок? Нажмите ниже:

$4

Мы надеемся, что вам понравится!

Спасибо,


Команда {{SITENAME}}

---

Хотите остановить отправку вам электронной почты?

Нажмите $5
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'right-giftadmin' => 'создание новых и правка существующих подарков',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'g-choose-file' => 'Выбрати файл:',
	'g-cancel' => 'Сторно',
	'g-gift' => 'подарунок',
	'g-gift-name' => 'мено подарунку',
	'g-give-gift' => 'Дати подарунок',
	'g-give-list-select' => 'выбрати приятеля',
	'g-give-separator' => 'або',
	'g-go-back' => 'Назад',
	'g-large' => 'Великый',
	'g-main-page' => 'Головна сторінка',
	'g-medium' => 'Середнїй',
	'g-new' => 'нове',
	'g-next' => 'Далшый',
	'g-previous' => 'Попереднїй',
	'g-remove' => 'Одстранити',
	'g-small' => 'Маленькый',
	'g-your-profile' => 'Ваш профіл',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'giftmanager' => 'Správca darčekov',
	'giftmanager-addgift' => '+ Pridať nový darček',
	'giftmanager-access' => 'prístup k darčeku',
	'giftmanager-description' => 'popis darčeka',
	'giftmanager-giftimage' => 'obrázok darčeka',
	'giftmanager-image' => 'pridať/nahradiť obrázok',
	'giftmanager-giftcreated' => 'Darček bol vytvorený',
	'giftmanager-giftsaved' => 'Darček bol uložený',
	'giftmanager-public' => 'verejný',
	'giftmanager-private' => 'súkromný',
	'giftmanager-view' => 'Zobraziť zoznam darčekov',
	'g-add-message' => 'Pridať správu',
	'g-back-edit-gift' => 'Späť na Upraviť tento darček',
	'g-back-gift-list' => 'Späť na Zoznam darčekov',
	'g-back-link' => '< Späť na stránku $1',
	'g-choose-file' => 'Vybrať súbor:',
	'g-cancel' => 'Zrušiť',
	'g-count' => '$1 má $2 {{PLURAL:$2|darček|darčeky|darčekov}}.',
	'g-create-gift' => 'Vytvoriť darček',
	'g-created-by' => 'vytvoril',
	'g-current-image' => 'Aktuálny obrázok',
	'g-delete-message' => 'Ste si istý, že chcete vymazať darček „$1“? Tým ho vymažete aj používateľom, ktorí ho dostali.',
	'g-description-title' => 'darček „$2“, vytvoril $1',
	'g-error-do-not-own' => 'Nevlastníte tento darček',
	'g-error-message-blocked' => 'Momentálne ste zablokovaný a nemôžete dávať darčeky',
	'g-error-message-invalid-link' => 'Odkaz, ktorý ste zadali je neplatný.',
	'g-error-message-login' => 'Musíte sa prihlásiť, aby ste mohli dávať darčeky.',
	'g-error-message-no-user' => 'Používateľ, ktorého sa snažíte zobraziť, neexistuje.',
	'g-error-message-to-yourself' => 'Nemôžete darovať darček sebe.',
	'g-error-title' => 'Ops, niečo ste spravili zle!',
	'g-file-instructions' => 'Váš obrázok musí byť jpeg, png alebo gif (nie animovaný gif) a musí mať veľkosť menšiu ako 100 kb.',
	'g-from' => 'od <a href="$1">$2</a>',
	'g-gift' => 'darček',
	'g-gift-name' => 'názov darčeka',
	'g-give-gift' => 'Dať darček',
	'g-give-all' => 'Chcete dať používateľovi $1 darček? Stačí kliknúť na jeden z darčekov dolu a kliknúť na „Poslať darček“. Je to také jednoduché.',
	'g-give-all-message-title' => 'Pridať správu',
	'g-give-all-title' => 'Dať darček používateľovi $1',
	'g-give-enter-friend-title' => 'Ak poznáte meno používateľa, napíšte ho dolu',
	'g-given' => 'Tento darček bol darovaný {{PLURAL:$1|jedenkrát|$1-krát}}',
	'g-give-list-friends-title' => 'Vybrať z vášho zoznamu priateľov',
	'g-give-list-select' => 'vybrať priateľa',
	'g-give-separator' => 'alebo',
	'g-give-no-user-message' => 'Darčeky a ocenenia sú skvelým spôsobom ako oceniť vašich priateľov!',
	'g-give-no-user-title' => 'Komu by ste chceli darovať darček?',
	'g-give-to-user-title' => 'Poslať darček „$1“ používateľovi $2',
	'g-give-to-user-message' => 'Chcete dať používateľovi $1 <a href="$2">iný darček?</a>.',
	'g-go-back' => 'Vrátiť sa späť',
	'g-imagesbelow' => 'Dolu sú vaše obrázky, ktoré sa použijú na stránke',
	'g-large' => 'Veľký',
	'g-list-title' => 'Zoznam darčekov používateľa $1',
	'g-main-page' => 'Hlavná stránka',
	'g-medium' => 'Stredný',
	'g-mediumlarge' => 'Stredne veľký',
	'g-new' => 'nový',
	'g-next' => 'Ďalší',
	'g-previous' => 'Predošlý',
	'g-remove' => 'Odstrániť',
	'g-remove-gift' => 'Odstrániť tento Darček',
	'g-remove-message' => 'Ste si istý, že chcete odstrániť darček „$1“?',
	'g-recent-recipients' => 'Iní, ktorí nedávno dostali tento darček',
	'g-remove-success-title' => 'Úspešne ste odstránili darček „$1“',
	'g-remove-success-message' => 'Na vašu žiadosť bol odstránený darček „$1“.',
	'g-remove-title' => 'Odstrániť „$1“?',
	'g-send-gift' => 'Poslať darček',
	'g-select-a-friend' => 'vybrať priateľa',
	'g-sent-title' => 'Poslali ste darček používateľovi $1',
	'g-sent-message' => 'Poslali ste nasledovný darček používateľovi $1.',
	'g-small' => 'Malý',
	'g-to-another' => 'Dať niekomu inému',
	'g-uploadsuccess' => 'Nahrávanie prebehlo úspešne',
	'g-viewgiftlist' => 'Zobraziť zoznam darčekov',
	'g-your-profile' => 'Váš profil',
	'gift_received_subject' => '$1 vám poslal darček $2 na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'gift_received_body' => 'Ahoj $1:

$1 vám práve poslal darček $3 na {{GRAMMAR:lokál|{{SITENAME}}}}

Chcete si prečítať komentár, ktorý vám $2 nechal a pozrieť si svoj darček? Kliknite na nasledovný odkaz:

$4

Dúfame, že sa vám bude páčiť!

Vďaka,


Tím {{GRAMMAR:genitív|{{SITENAME}}}}

---

Neželáte si od nás dostávať emaily?

Kliknite na $5
a zmeňte svoje nastavenia týkajúce sa upozornení emailom.',
	'right-giftadmin' => 'Vytvoriť nový alebo upraviť existujúce darčeky',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 * @author Smihael
 */
$messages['sl'] = array(
	'giftmanager' => 'Upravitelj daril',
	'giftmanager-addgift' => '+ Dodaj novo darilo',
	'giftmanager-access' => 'dostop do darila',
	'giftmanager-description' => 'opis darila',
	'giftmanager-giftimage' => 'slika darila',
	'giftmanager-image' => 'dodaj/zamenjaj sliko',
	'giftmanager-giftcreated' => 'Darilo je bilo ustvarjeno',
	'giftmanager-giftsaved' => 'Darilo je bilo shranjeno',
	'giftmanager-public' => 'javno',
	'giftmanager-private' => 'zasebno',
	'giftmanager-view' => 'Ogled seznama daril',
	'g-add-message' => 'Dodaj sporočilo',
	'g-back-edit-gift' => 'Nazaj na urejanje tega darila',
	'g-back-gift-list' => 'Nazaj na seznam daril',
	'g-back-link' => '< Nazaj na stran $1',
	'g-choose-file' => 'Izberite datoteko:',
	'g-cancel' => 'Prekliči',
	'g-count' => '$1 ima $2 {{PLURAL:$2|darilo|darili|darila|daril}}.',
	'g-create-gift' => 'Ustvari darilo',
	'g-created-by' => 'ustvaril',
	'g-current-image' => 'Trenutna slika',
	'g-delete-message' => 'Ali ste prepričani, da želite izbrisati darilo »$1«?
To ga bo odstranilo tudi od uporabnikov, ki so ga morda prejeli.',
	'g-description-title' => 'Darilo »$2« uporabnika $1',
	'g-error-do-not-own' => 'Ne lastite si tega darila.',
	'g-error-message-blocked' => 'Trenutno ste blokirani in ne morete podarjati daril',
	'g-error-message-invalid-link' => 'Povezava, ki ste jo vnesli, je neveljavna.',
	'g-error-message-login' => 'Za podarjanje daril se morate prijaviti',
	'g-error-message-no-user' => 'Uporabnik, ki si ga želite ogledati, ne obstaja.',
	'g-error-message-to-yourself' => 'Darila ne morete podariti sebi.',
	'g-error-title' => 'Ups, ubrali ste napačno smer!',
	'g-file-instructions' => 'Vaša slika mora biti jpeg, png ali gif (brez animiranih gifov) in v velikosti ne sme presegati 100kb.',
	'g-from' => 'od <a href="$1">$2</a>',
	'g-gift' => 'darilo',
	'g-gift-name' => 'ime darila',
	'g-give-gift' => 'Podari darilo',
	'g-give-all' => 'Želite $1 podariti darilo?
Samo izberite eno od spodnjih daril in kliknite »Pošlji darilo«.
Tako preprosto je.',
	'g-give-all-message-title' => 'Dodaj sporočilo',
	'g-give-all-title' => 'Podari darilo $1',
	'g-give-enter-friend-title' => 'Če veste ime uporabnika, ga vnesite spodaj',
	'g-given' => 'To darilo je bilo podarjeno {{PLURAL:$1-krat|$1-krat}}',
	'g-give-list-friends-title' => 'Izberite iz vašega seznama prijateljev',
	'g-give-list-select' => 'izberite prijatelja',
	'g-give-separator' => 'ali',
	'g-give-no-user-message' => 'Darila in nagrade so izvrstna pot, da priznate svoje prijatelje!',
	'g-give-no-user-title' => 'Komu želite podariti darilo?',
	'g-give-to-user-title' => 'Pošlji darilo »$1« uporabniku $2',
	'g-give-to-user-message' => 'Želite $1 podariti <a href="$2">drugo darilo</a>?',
	'g-go-back' => 'Pojdi nazaj',
	'g-imagesbelow' => 'Spodaj so vaše slike, ki bodo uporabljene na strani',
	'g-large' => 'Veliko',
	'g-list-title' => 'Seznam daril $1',
	'g-main-page' => 'Glavna stran',
	'g-medium' => 'Srednje',
	'g-mediumlarge' => 'Srednje veliko',
	'g-new' => 'novo',
	'g-next' => 'Naslednji',
	'g-previous' => 'Prejšnji',
	'g-remove' => 'Odstrani',
	'g-remove-gift' => 'Odstrani to darilo',
	'g-remove-message' => 'Ali ste prepričani, da želite odstraniti darilo »$1«?',
	'g-recent-recipients' => 'Drugi nedavni prejemniki tega darila',
	'g-remove-success-title' => 'Uspešno ste odstranili darilo »$1«',
	'g-remove-success-message' => 'Darilo »$1« je bilo odstranjeno.',
	'g-remove-title' => 'Odstranim »$1«?',
	'g-send-gift' => 'Pošlji darilo',
	'g-select-a-friend' => 'izberite prijatelja',
	'g-sent-title' => 'Darilo ste poslali $1',
	'g-sent-message' => 'Sledeče darilo ste poslali $1',
	'g-small' => 'Majhno',
	'g-to-another' => 'Podari nekomu drugemu',
	'g-uploadsuccess' => 'Nalaganje je bilo uspešno',
	'g-viewgiftlist' => 'Ogled seznama daril',
	'g-your-profile' => 'Vaš profil',
	'gift_received_subject' => '$1 vam je poslal darilo $2 na {{GRAMMAR:dative|{{SITENAME}}}}!',
	'gift_received_body' => '$1, pozdravljen(-a).

$2 vam je pravkar poslal(-a) darilo $3 na {{SITENAME}}.

Želite prebrati sporočilo, ki vam ga je pustil $2, in si ogledati darilo?   Kliknite spodnjo povezavo:

$4

Upamo, da vam je všeč!

Hvala,


Ekipa {{SITENAME}}

---

Hej, ne želiš več prejemati e-pošte od nas?

Klikni $5
in spremeni svoje nastavitve za onemogočitev e-poštnih obvestil.',
	'right-giftadmin' => 'Ustvarjanje novih in urejanje obstoječih daril',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'giftmanager' => 'Менаџер за поклоне',
	'giftmanager-addgift' => '+ Пошаљи нови поклон',
	'giftmanager-access' => 'приступ поклонима',
	'giftmanager-description' => 'опис поклона',
	'giftmanager-giftimage' => 'слика поклона',
	'giftmanager-image' => 'додај/замени слику',
	'giftmanager-giftcreated' => 'Поклон је направљен',
	'giftmanager-giftsaved' => 'Поклон је снимљен',
	'giftmanager-public' => 'јавно',
	'giftmanager-private' => 'приватно',
	'giftmanager-view' => 'Погледај списак поклона',
	'g-add-message' => 'Додај поруку',
	'g-back-edit-gift' => 'Повратак на измене овог поклона',
	'g-back-gift-list' => 'Повратак на списак поклона',
	'g-back-link' => '< Повратак на страну $1',
	'g-choose-file' => 'Изаберите фајл:',
	'g-cancel' => 'Откажи',
	'g-count' => '$1 има $2 {{PLURAL:$2|поклон|поклона}}.',
	'g-create-gift' => 'Направите поклон',
	'g-created-by' => 'направи',
	'g-current-image' => 'Тренутна слика',
	'g-delete-message' => 'Да ли сте сигурни да желите да обришете поклон "$1"?
Ово ће га такође обрисати од корисника којима сте га поклонили.',
	'g-description-title' => 'Поклон "$2", од $1',
	'g-error-do-not-own' => 'Ви не поседујете овај поклон.',
	'g-error-message-blocked' => 'Тренутно сте блокирани и не можете слати поклоне',
	'g-error-message-invalid-link' => 'Линк који сте навели је неисправан.',
	'g-error-message-login' => 'Морате да се улогујете да бисте слали поклоне',
	'g-error-message-no-user' => 'Корисник кога покушавате да видите не постоји.',
	'g-error-message-to-yourself' => 'Не можете слати поклоне себи.',
	'g-file-instructions' => 'Ваша слика мора бити у jpeg/jpg, png или gif (неанимираном) формату, и мора бити мања од 100kB.',
	'g-from' => 'од <a href="$1">$2</a>',
	'g-gift' => 'поклон',
	'g-gift-name' => 'име поклона',
	'g-give-gift' => 'Пошаљите поклон',
	'g-give-all' => 'Желите ли да пошаљете $1 поклон?
Само изаберите неки од поклона испод и кликните "Слање поклона".
И већ ће бити послат.',
	'g-give-all-message-title' => 'Додај поруку',
	'g-give-all-title' => 'Пошаљи поклон $1',
	'g-give-enter-friend-title' => 'Ако знате име корисника, откуцајте га испод',
	'g-given' => 'Овај поклон је био послат $1 {{PLURAL:$1|пут|пута}}',
	'g-give-list-friends-title' => 'Изаберите са Вашег списка пријатеља',
	'g-give-list-select' => 'изаберите пријатеља',
	'g-give-separator' => 'или',
	'g-give-no-user-title' => 'Коме бисте волели да пошаљете поклон?',
	'g-give-to-user-title' => 'Слање поклона "$1" кориснику $2',
	'g-give-to-user-message' => 'Да ли желите да кориснику $1 пошаљете <a href="$2">неки други поклон</a>?',
	'g-go-back' => 'Повратак',
	'g-imagesbelow' => 'Испод се налазе ваше слике које ће бити коришћене на сајту',
	'g-large' => 'Велико',
	'g-list-title' => 'списак поклона од $1',
	'g-main-page' => 'Главна страна',
	'g-medium' => 'Средње',
	'g-mediumlarge' => 'Средње – велико',
	'g-new' => 'ново',
	'g-next' => 'Следеће',
	'g-previous' => 'Претходно',
	'g-remove' => 'Обриши',
	'g-remove-gift' => 'Обриши овај поклон',
	'g-remove-message' => 'Да ли сте сигурни да желите да обришете поклон "$1"?',
	'g-recent-recipients' => 'Други примаоци овог поклона',
	'g-remove-success-title' => 'Успешно сте обрисали поклон "$1"',
	'g-remove-success-message' => 'Поклон "$1" је обрисан.',
	'g-remove-title' => 'Обрисати "$1"?',
	'g-send-gift' => 'Слање поклона',
	'g-select-a-friend' => 'изабери пријатеља',
	'g-sent-title' => 'Послали сте поклон кориснику $1',
	'g-sent-message' => 'Послали сте следећи поклон корисинку $1.',
	'g-small' => 'Мало',
	'g-to-another' => 'Пошаљите поклон неком другом',
	'g-uploadsuccess' => 'Слање успешно',
	'g-viewgiftlist' => 'Погледајте списак поклона',
	'g-your-profile' => 'Ваш профил',
	'gift_received_subject' => '$1 Вам је послао/ла поклон $2 на {{SITENAME}}!',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'giftmanager' => 'Menadžer za poklone',
	'giftmanager-addgift' => '+ Pošalji novi poklon',
	'giftmanager-access' => 'pristup poklonima',
	'giftmanager-description' => 'opis pokona',
	'giftmanager-giftimage' => 'slika poklona',
	'giftmanager-image' => 'dodaj/zameni sliku',
	'giftmanager-giftcreated' => 'Poklon je napravljen',
	'giftmanager-giftsaved' => 'Poklon je snimljen',
	'giftmanager-public' => 'javno',
	'giftmanager-private' => 'privatno',
	'giftmanager-view' => 'Pogledaj spisak poklona',
	'g-add-message' => 'Dodaj poruku',
	'g-back-edit-gift' => 'Povratak na izmene ovog poklona',
	'g-back-gift-list' => 'Povratak na spisak poklona',
	'g-back-link' => '< Povratak na stranu $1',
	'g-choose-file' => 'Izaberite fajl:',
	'g-cancel' => 'Otkaži',
	'g-count' => '$1 ima $2 {{PLURAL:$2|poklon|poklona}}.',
	'g-create-gift' => 'Napravite poklon',
	'g-created-by' => 'napravio/la',
	'g-current-image' => 'Trenutna slika',
	'g-delete-message' => 'Da li ste sigurni da želite da obrišete poklon "$1"?
Ovo će ga takođe obrisati od korisnika kojima ste ga poklonili.',
	'g-description-title' => 'Poklon "$2", od $1',
	'g-error-do-not-own' => 'Vi ne posedujete ovaj poklon.',
	'g-error-message-blocked' => 'Trenutno ste blokirani i ne možete slati poklone',
	'g-error-message-invalid-link' => 'Link koji ste naveli je neispravan.',
	'g-error-message-login' => 'Morate da se ulogujete da biste slali poklone',
	'g-error-message-no-user' => 'Korisnik koga pokušavate da vidite ne postoji.',
	'g-error-message-to-yourself' => 'Ne možete slati poklone sebi.',
	'g-file-instructions' => 'Vaša slika mora biti u jpeg/jpg, png ili gif (neanimiranom) formatu, i mora biti manja od 100kB.',
	'g-from' => 'od <a href="$1">$2</a>',
	'g-gift' => 'poklon',
	'g-gift-name' => 'ime poklona',
	'g-give-gift' => 'Pošaljite poklon',
	'g-give-all' => 'Želite li da pošaljete $1 poklon?
Samo izaberite neki od poklona ispod i kliknite "Slanje poklona".
I već će biti poslat.',
	'g-give-all-message-title' => 'Dodaj poruku',
	'g-give-all-title' => 'Pošalji poklon $1',
	'g-give-enter-friend-title' => 'Ako znate ime korisnika, otkucajte ga ispod',
	'g-given' => 'Ovaj poklon je bio poslat $1 {{PLURAL:$1|put|puta}}',
	'g-give-list-friends-title' => 'Izaberite sa Vašeg spiska prijatelja',
	'g-give-list-select' => 'izaberite prijatelja',
	'g-give-separator' => 'ili',
	'g-give-no-user-title' => 'Kome biste voleli da pošaljete poklon?',
	'g-give-to-user-title' => 'Slanje poklona "$1" korisniku $2',
	'g-give-to-user-message' => 'Da li želite da korisniku $1 pošaljete <a href="$2">neki drugi poklon</a>?',
	'g-go-back' => 'Povratak',
	'g-imagesbelow' => 'Ispod se nalaze vaše slike koje će biti korišćene na sajtu',
	'g-large' => 'Veliko',
	'g-list-title' => 'spisak poklona od $1',
	'g-main-page' => 'Glavna strana',
	'g-medium' => 'Srednje',
	'g-mediumlarge' => 'Srednje-veliko',
	'g-new' => 'novo',
	'g-next' => 'Sledeće',
	'g-previous' => 'Prethodno',
	'g-remove' => 'Obriši',
	'g-remove-gift' => 'Obriši ovaj poklon',
	'g-remove-message' => 'Da li ste sigurni da želite da obrišete poklon "$1"?',
	'g-recent-recipients' => 'Drugi primaoci ovog poklona',
	'g-remove-success-title' => 'Uspešno ste obrisali poklon "$1"',
	'g-remove-success-message' => 'Poklon "$1" je obrisan.',
	'g-remove-title' => 'Obrisati "$1"?',
	'g-send-gift' => 'Slanje poklona',
	'g-select-a-friend' => 'izaberi prijatelja',
	'g-sent-title' => 'Poslali ste poklon korisniku $1',
	'g-sent-message' => 'Poslali ste sledeći poklon korisinku $1.',
	'g-small' => 'Malo',
	'g-to-another' => 'Pošaljite poklon nekom drugom',
	'g-uploadsuccess' => 'Slanje uspešno',
	'g-viewgiftlist' => 'Pogledajte spisak poklona',
	'g-your-profile' => 'Vaš profil',
	'gift_received_subject' => '$1 Vam je poslao/la poklon $2 na {{SITENAME}}!',
);

/** Swedish (Svenska)
 * @author Dafer45
 * @author Per
 */
$messages['sv'] = array(
	'giftmanager' => 'Presenthanterare',
	'giftmanager-addgift' => '+ Lägg till en ny present',
	'giftmanager-access' => 'presenttillgång',
	'giftmanager-description' => 'presentbeskrivning',
	'giftmanager-giftimage' => 'presentbild',
	'giftmanager-image' => 'lägg till/ersätt bild',
	'giftmanager-giftcreated' => 'Presenten har skapats',
	'giftmanager-giftsaved' => 'Presenten har sparats',
	'giftmanager-public' => 'offentlig',
	'giftmanager-private' => 'privat',
	'giftmanager-view' => 'Se presentlista',
	'g-add-message' => 'Lägg till ett meddelande',
	'g-back-edit-gift' => 'Tillbaka för att ändra denna present',
	'g-back-gift-list' => 'Tillbaka till presentlista',
	'g-back-link' => '< Tillbaka till $1s sida',
	'g-choose-file' => 'Välj fil:',
	'g-cancel' => 'Avbryt',
	'g-count' => '$1 har $2 {{PLURAL:$2|present|presenter}}.',
	'g-create-gift' => 'Skapa present',
	'g-created-by' => 'skapad av',
	'g-current-image' => 'Nuvarande bild',
	'g-delete-message' => 'Är du säker på att du vill radera presenten "$1"?
Den kommer också att raderas från de användare som har fått den.',
	'g-description-title' => 'Presenten "$2" från $1',
	'g-error-do-not-own' => 'Du äger inte denna present.',
	'g-error-message-blocked' => 'Du är för tillfället blockerad och kan inte ta emot presenter',
	'g-error-message-invalid-link' => 'Länken du angav är ogiltig.',
	'g-error-message-login' => 'Du måste vara inloggad för att ge presenter',
	'g-error-message-no-user' => 'Användaren du försöker titta på finns inte.',
	'g-error-message-to-yourself' => 'Du kan inte ge en present till dig själv.',
	'g-error-title' => 'Oj, du har hamnat fel!',
	'g-from' => 'från <a href="$1">$2</a>',
	'g-gift' => 'present',
	'g-gift-name' => 'presentnamn',
	'g-give-gift' => 'Ge en present',
	'g-give-all' => 'Vill du ge $1 en present?
Klicka bara på en av presenterna nedan och sedan på "Skicka present"
Så enkelt är det.',
	'g-give-all-message-title' => 'Lägg till ett meddelande',
	'g-give-all-title' => 'Ge en present till $1',
	'g-give-enter-friend-title' => 'Om du vet namnet på användaren, skriv in det här nedanför',
	'g-given' => 'Denna present har delats ut $1 {{PLURAL:$1|gång|gånger}}',
	'g-give-list-friends-title' => 'Välj från listan med dina vänner',
	'g-give-list-select' => 'välj en vän',
	'g-give-separator' => 'eller',
	'g-give-no-user-message' => 'Presenter och utmärkelser är ett utmärkt sätt att ge dina vänner ett erkännande!',
	'g-give-no-user-title' => 'Vem vill du ge en present till?',
	'g-give-to-user-title' => 'Skicka presenten "$1" till $2',
	'g-give-to-user-message' => 'Vill du ge $1 en <a href="$2">annan present</a>?',
	'g-go-back' => 'Gå tillbaka',
	'g-large' => 'Stor',
	'g-list-title' => '$1s presentlista',
	'g-main-page' => 'Huvudsidan',
	'g-medium' => 'Medium',
	'g-new' => 'ny',
	'g-next' => 'Nästa',
	'g-previous' => 'Föregående',
	'g-remove' => 'Ta bort',
	'g-remove-gift' => 'Ta bort denna present',
	'g-remove-message' => 'Är du säker på att du vill ta bort presenten "$1"?',
	'g-recent-recipients' => 'Andra som nyligen fått denna present',
	'g-remove-success-title' => 'Du har framgångsrikt tagit bort presenten "$1"',
	'g-remove-success-message' => 'Presenten "$1" har tagits bort.',
	'g-remove-title' => 'Ta bort "$1"?',
	'g-send-gift' => 'Skicka present',
	'g-select-a-friend' => 'välj en vän',
	'g-sent-title' => 'Du har skickat en present till $1',
	'g-sent-message' => 'Du har skickat följande present till $1.',
	'g-small' => 'Liten',
	'g-to-another' => 'Ge till någon annan',
	'g-uploadsuccess' => 'Uppladdningen lyckades',
	'g-viewgiftlist' => 'Visa presentlista',
	'g-your-profile' => 'Din profil',
	'gift_received_subject' => '$1 har skickat presenten $2 till dig på {{SITENAME}}!',
	'right-giftadmin' => 'Skapa nya och ändra existerande presenter',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'giftmanager-description' => 'బహుమతి వివరణ',
	'giftmanager-giftimage' => 'బహుమతి చిత్రం',
	'giftmanager-public' => 'బహిరంగం',
	'giftmanager-private' => 'అంతరంగికం',
	'giftmanager-view' => 'బహుమతుల జాబితాని చూడండి',
	'g-add-message' => 'ఓ సందేశాన్ని చేర్చండి',
	'g-back-gift-list' => 'తిరిగి బహుమతుల జాబితాకి',
	'g-back-link' => '< తిరిగి $1 యొక్క పుటకి',
	'g-cancel' => 'రద్దు',
	'g-count' => '$1 కి $2 {{PLURAL:$2|బహుమతి ఉంది|బహుమతులు ఉన్నాయి}}.',
	'g-current-image' => 'ప్రస్తుత చిత్రం',
	'g-error-message-to-yourself' => 'మీకు మీరే బహుమతిని ఇచ్చుకోలేరు.',
	'g-from' => '<a href="$1">$2</a> నుండి',
	'g-gift' => 'బహుమతి',
	'g-gift-name' => 'బహుమతి పేరు',
	'g-given' => 'ఈ బహుమతిని {{PLURAL:$1|ఒకసారి|$1 సార్లు}} ఇచ్చారు',
	'g-give-separator' => 'లేదా',
	'g-give-no-user-title' => 'మీరు ఎవరికి బహుమతిని ఇవ్వాలనుకుంటున్నారు?',
	'g-go-back' => 'వెనక్కి వెళ్ళు',
	'g-main-page' => 'మొదటి పుట',
	'g-medium' => 'మధ్యస్థం',
	'g-new' => 'కొత్త',
	'g-next' => 'తర్వాతి',
	'g-previous' => 'గత',
	'g-remove' => 'తొలగించు',
	'g-remove-title' => '"$1"ని తొలగించాలా?',
	'g-uploadsuccess' => 'ఎక్కింపు విజయవంతం',
	'g-viewgiftlist' => 'బహుమతుల జాబితాని చూడండి',
	'g-your-profile' => 'మీ ప్రవర',
	'gift_received_subject' => '{{SITENAME}}లో $1 మీకు $2 బహుమతిని పంపించారు!',
);

/** Thai (ไทย)
 * @author Woraponboonkerd
 */
$messages['th'] = array(
	'giftmanager' => 'จัดการกับของขวัญ',
	'giftmanager-addgift' => '+ เพิ่มของขวัญใหม่',
	'giftmanager-access' => 'การเข้าถึงของขวัญ',
	'giftmanager-description' => 'รายละเอียดของขวัญ',
	'giftmanager-giftimage' => 'รูปภาพของขวัญ',
	'giftmanager-image' => 'เพิ่ม/แทนที่รูปภาพ',
	'giftmanager-giftcreated' => 'ของขวัญได้ถูกสร้างขึ้นแล้ว',
	'giftmanager-giftsaved' => 'ของขวัญได้ถูกบันทึกแล้ว',
	'giftmanager-public' => 'สาธารณะ',
	'giftmanager-private' => 'ส่วนตัว',
	'giftmanager-view' => 'ดูรายการของขวัญ',
	'g-add-message' => 'เพิ่มข้อความ',
	'g-back-edit-gift' => 'กลับไปแก้ไขของขวัญนี้',
	'g-back-gift-list' => 'กลับไปยังรายการของขวัญ',
	'g-back-link' => '< กลับไปยังหน้าของ $1',
	'g-choose-file' => 'เลือกไฟล์:',
	'g-cancel' => 'ยกเลิก',
	'g-count' => '$1 มีของขวัญ $2 {{PLURAL:$2|ชิ้น|ชิ้น}}',
	'g-create-gift' => 'สร้างของขวัญ',
	'g-created-by' => 'สร้างโดย',
	'g-current-image' => 'รูปภาพปัจจุบัน',
	'g-delete-message' => 'คุณแน่ใจหรือไม่ที่จะลบของขวัญ "$1" ออก?
<br />เพราะนี่จะเป็นการลบของขวัญนี้ออกจากผู้ใช้คนอื่นๆ ที่ได้รับของขวัญนี้ด้วย',
	'g-description-title' => '"$2" ของ $1',
	'g-error-do-not-own' => 'คุณไม่ได้เป็นเจ้าของของขวัญนี้',
	'g-error-message-blocked' => 'ขณะนี้คุณถูกห้ามและไม่สามารถให้ของขวัญได้',
	'g-error-message-invalid-link' => 'ลิงก์ที่คุณใส่ไม่ถูกต้อง',
	'g-error-message-login' => 'คุณต้องลงชื่อเข้าใช้เพื่อให้ของขวัญ',
	'g-error-message-no-user' => 'ไม่ปรากฎผู้ใช้ที่คุณกำลังพยายามดูอยู่',
	'g-error-message-to-yourself' => 'คุณไม่สามารถให้ของขวัญกับตัวคุณเองได้',
	'g-error-title' => 'อุ๊ย คุณมาผิดทางแล้ว!',
	'g-file-instructions' => 'รูปภาพของคุณต้องเป็นไฟล์ JPEG, PNG หรือ GIF (ไม่ใช่ไฟล์ GIF ที่เคลื่อนไหวได้) และต้องมีขนาดเล็กกว่า 100 กิโลไบต์',
	'g-from' => 'จาก <a href="$1">$2</a>',
	'g-gift' => 'ของขวัญ',
	'g-gift-name' => 'ชื่อของขวัญ',
	'g-give-gift' => 'ให้ของขวัญ',
	'g-give-all' => 'ต้องการที่จะให้ของขวัญกับ $1 ใช่ไหม?
<br />เพียงแค่คลิกของขวัญด้านล่างหนึ่งอันแล้วคลิก "ให้ของขวัญ"
<br />แค่นี้ง่ายนิดเดียว',
	'g-give-all-message-title' => 'เพิ่มข้อความ',
	'g-give-all-title' => 'ให้ของขวัญกับ $1',
	'g-give-enter-friend-title' => 'ถ้าคุณรู้ชื่อของผู้ใช้ พิมพ์ลงที่ด้านล่างนี้',
	'g-given' => 'มีผู้ที่ให้ของขวัญนี้จำนวน $1 {{PLURAL:$1|ครั้ง|ครั้ง}}',
	'g-give-list-friends-title' => 'เลือกจากรายการเพื่อนของคุณ',
	'g-give-list-select' => 'เลือกเพื่อน',
	'g-give-separator' => 'หรือ',
	'g-give-no-user-message' => 'ของขวัญและรางวัลเป็นหนทางที่ดีมากในการรับรองเพื่อนของคุณ',
	'g-give-no-user-title' => 'คุณต้องการที่จะให้ของขวัญกับใคร?',
	'g-give-to-user-title' => 'ให้ของขวัญ "$1" กับ $2',
	'g-give-to-user-message' => 'ต้องการที่จะให้<a href="$2">ของขวัญชิ้นอื่น</a>กับ $1 ใช่ไหม?',
	'g-go-back' => 'กลับไปที่เิดิม',
	'g-imagesbelow' => 'ด้านล่างนี้คือรูปภาพของคุณที่จะถูกใช้บนเว็บไซต์',
	'g-large' => 'ขนาดใหญ่',
	'g-list-title' => 'รายการของขวัญของ $1',
	'g-main-page' => 'หน้าหลัก',
	'g-medium' => 'ขนาดกลาง',
	'g-mediumlarge' => 'ขนาดกลาง - ขนาดใหญ่',
	'g-new' => 'ใหม่',
	'g-next' => 'ถัดไป',
	'g-previous' => 'ก่อนหน้า',
	'g-remove' => 'ลบทิ้ง',
	'g-remove-gift' => 'ลบของขวัญนี้ทิ้ง',
	'g-remove-message' => 'คุณแน่ใจหรือไม่ที่จะลบของขวัญ "$1" ทิ้ง?',
	'g-recent-recipients' => 'ผู้ใช้อื่นๆ ที่ได้รับของขวัญนี้',
	'g-remove-success-title' => 'คุณได้ลบของขวัญ "$1" ออกเป็นที่เรียบร้อยแล้ว',
	'g-remove-success-message' => 'ของขวัญ "$1" ได้ถูกลบออกแล้ว',
	'g-remove-title' => 'ลบ "$1"?',
	'g-send-gift' => 'ให้ของขวัญ',
	'g-select-a-friend' => 'เลือกเพื่อน',
	'g-sent-title' => 'คุณได้ให้ของขวัญกับ $1',
	'g-sent-message' => 'คุณได้ให้ของขวัญดังต่อไปนี้กับ $1',
	'g-small' => 'ขนาดเล็ก',
	'g-to-another' => 'ให้กับคนอื่น',
	'g-uploadsuccess' => 'อัปโหลดสำเร็จ',
	'g-viewgiftlist' => 'ดูรายการของขวัญ',
	'g-your-profile' => 'โปรไฟล์ของคุณ',
	'gift_received_subject' => '$1 ได้ให้ $2 กับคุณบนเว็บไซต์ {{SITENAME}}!',
	'gift_received_body' => 'สวัสดี $1.

$2 เพิ่งให้ของขวัญกับคุณเป็น $3 บนเว็บไซต์ {{SITENAME}}.

ต้องการอ่านข้อความที่ $2 ให้กับคุณและดูของขวัญของคุณหรือไม่?  คลิกที่ลิงก์ด้านล่างนี้:

$4

เราหวังว่าคุณคงชอบนะ!

ขอบคุณ,


ทีมงาน {{SITENAME}}

---

เฮ้, ต้องการที่จะงดรับอีเมลจากเราหรือไม่?

คลิก $5
<br />และเปลี่ยนแปลงการตั้งค่าของคุณเพื่องดรับการแจ้งเตือนทางอีเมล',
	'right-giftadmin' => 'สร้างของขวัญใหม่และแก้ไขของขวัญที่มีอยู่เดิม',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'giftmanager' => 'Tagapamahala ng mga Handog',
	'giftmanager-addgift' => '+ Magdagdag ng Bagong Handog',
	'giftmanager-access' => 'antas ng pagpunta sa handog',
	'giftmanager-description' => 'paglalarawan ng handog',
	'giftmanager-giftimage' => 'larawan ng handog',
	'giftmanager-image' => 'idagdag/palitan ang larawan',
	'giftmanager-giftcreated' => 'Nalikha na ang handog',
	'giftmanager-giftsaved' => 'Nasagip na ang handog',
	'giftmanager-public' => 'pangmadla',
	'giftmanager-private' => 'pansarili',
	'giftmanager-view' => 'Tingnan ang Talaan ng Handog',
	'g-add-message' => 'Magdagdag ng isang Mensahe',
	'g-back-edit-gift' => 'Bumalik sa Baguhin ang Handog na Ito',
	'g-back-gift-list' => 'Bumalik sa Talaan ng Handog',
	'g-back-link' => '< Bumalik sa Pahina ni $1',
	'g-choose-file' => 'Piliin ang Talaksan:',
	'g-cancel' => 'Huwag ituloy',
	'g-count' => 'Si $1 ay may $2 {{PLURAL:$2|handog|mga handog}}.',
	'g-create-gift' => 'Likhain ang handog',
	'g-created-by' => 'nilikha ni',
	'g-current-image' => 'Kasalukuyang Larawan',
	'g-delete-message' => 'Nakatitiyak ka bang nais mong burahin ang handog na "$1"? Mabubura rin ito mula sa mga tagagamit na maaaring nakatanggap nito.',
	'g-description-title' => 'Handog na "$2" ni $1',
	'g-error-do-not-own' => 'Hindi mo pag-aari ang handog na ito.',
	'g-error-message-blocked' => 'Pangkasalukuyan kang hinahadlangan at hindi makapagbibigay ng mga handog',
	'g-error-message-invalid-link' => 'Hindi tanggap ang ipinasok mong kawing.',
	'g-error-message-login' => 'Dapat kang lumagda muna upang makapagbigay ng mga handog',
	'g-error-message-no-user' => 'Hindi umiiral ang tagagamit na sinusubukan mong tingnan.',
	'g-error-message-to-yourself' => 'Hindi ka makapagbibigay ng handog sa sarili mo.',
	'g-error-title' => "Ay 'sus, nagkamali ka sa pagliko!",
	'g-file-instructions' => 'Dapat na jpeg, png o gif (walang gumagalaw na mga gif) ang larawan mo, at dapat na mas mababa kaysa 100 mga kb ang sukat.',
	'g-from' => 'mula sa <a href="$1">$2</a>',
	'g-gift' => 'handog',
	'g-gift-name' => 'pangalan ng handog',
	'g-give-gift' => 'Ibigay ang Handog',
	'g-give-all' => 'Nais mong bigyan si $1 ng isang handog? Pindutin lamang ang isa sa mga handog na nasa ibaba at pindutin ang "Ipadala ang Handog." Ganyan lang kadali.',
	'g-give-all-message-title' => 'Magdagdag ng isang Mensahe',
	'g-give-all-title' => 'Magbigay ng isang handog kay $1',
	'g-give-enter-friend-title' => 'Kung alam mo ang pangalan ng tagagamit, makinilyahin mo ito sa ibaba',
	'g-given' => 'Naipamigay na ng $1 {{PLURAL:$1|ulit|mga ulit}} ang handog na ito',
	'g-give-list-friends-title' => 'Pumili mula sa talaan ng mga kaibigan mo',
	'g-give-list-select' => 'pumili ng isang kaibigan',
	'g-give-separator' => 'o',
	'g-give-no-user-message' => 'Ang mga handog at mga gantimpala ay isang napakainam na paraan para kilalanin ang mga kaibigan mo!',
	'g-give-no-user-title' => 'Sino ba ang nais mong bigyan ng isang handog?',
	'g-give-to-user-title' => 'Ipadala ang handog na "$1" kay $2',
	'g-give-to-user-message' => 'Nais mo bang bigyan si $1 ng isang <a href="$2">ibang handog</a>?',
	'g-go-back' => 'Bumalik',
	'g-imagesbelow' => 'Nasa ibaba ang mga larawang gagamitin sa sityo',
	'g-large' => 'Malaki',
	'g-list-title' => 'Talaan ng Handog ni $1',
	'g-main-page' => 'Unang Pahina',
	'g-medium' => 'Gitnang Sukat',
	'g-mediumlarge' => 'Gitnans Sukat-Malaki',
	'g-new' => 'bago',
	'g-next' => 'Susunod',
	'g-previous' => 'Dati',
	'g-remove' => 'Tanggalin',
	'g-remove-gift' => 'Tanggalin ang Handog na Ito',
	'g-remove-message' => 'Nakatitiyak ka bang nais mong tanggalin ang handog na "$1"?',
	'g-recent-recipients' => 'Iba pang kamakailangang mga nakatanggap ng handog na ito',
	'g-remove-success-title' => 'Matagumpay mong natanggal ang handog na "$1"',
	'g-remove-success-message' => 'Natanggal na ang handog na "$1".',
	'g-remove-title' => 'Tatanggalin ba ang "$1"?',
	'g-send-gift' => 'Ipadala ang Handog',
	'g-select-a-friend' => 'pumili ng isang kaibigan',
	'g-sent-title' => 'Nagpadala ka ng isang handog kay $1',
	'g-sent-message' => 'Ipinadala mo ang sumusunod na handog kay $1.',
	'g-small' => 'Maliit',
	'g-to-another' => 'Ibigay sa Ibang Tao',
	'g-uploadsuccess' => 'Matagumpay ang Pagkarga',
	'g-viewgiftlist' => 'Tingnan ang Talaan ng Handog',
	'g-your-profile' => 'Talaan ng Katangian Mo',
	'gift_received_subject' => 'Ipinadala sa iyo ni $1 ang Handog na $2 sa {{SITENAME}}!',
	'gift_received_body' => 'Kumusta ka $1:

Kapapadala pa lang sa iyo ni $2 ng gantimpalang $3 sa {{SITENAME}}!

Nais mo bang basahin ang pagtatalang iniwan ni $2 at tingnan din ang handog niya para sa iyo?  Pindutin ang kawing na nasa ibaba:

$4

Sana ay magustuhan mo ito!

Salamat,


Ang Pangkat ng {{SITENAME}}

---

Hoy, nais mo bang huminto na ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $5
at baguhin ang mga pagtatakda mo upang huwag nang paganahin ang mga pagpapabatid sa pamamagitan ng e-liham.',
	'right-giftadmin' => 'Lumikha ng bago at baguhin ang umiiral na mga handog',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'giftmanager' => 'Hediye yöneticisi',
	'giftmanager-addgift' => '+ Yeni hediye ekle',
	'giftmanager-access' => 'hediye erişimi',
	'giftmanager-description' => 'hediye tanımı',
	'giftmanager-giftimage' => 'hediye resmi',
	'giftmanager-image' => 'resim ekle/değiştir',
	'giftmanager-giftcreated' => 'Hediye oluşturuldu',
	'giftmanager-giftsaved' => 'Hediye kaydedildi',
	'giftmanager-public' => 'herkese açık',
	'giftmanager-private' => 'özel',
	'giftmanager-view' => 'Hediye listesini gör',
	'g-add-message' => 'Bir mesaj ekle',
	'g-back-edit-gift' => 'Bu hediyeyi düzenlemeye geri dön',
	'g-back-gift-list' => 'Hediye listesine geri dön',
	'g-back-link' => '< $1 adlı kullanıcının sayfasına dön',
	'g-choose-file' => 'Dosya seç:',
	'g-cancel' => 'İptal',
	'g-count' => '$1, $2 {{PLURAL:$2|hediyeye|hediyeye}} sahip.',
	'g-create-gift' => 'Hediye oluştur',
	'g-created-by' => 'oluşturan:',
	'g-current-image' => 'Mevcut resim',
	'g-delete-message' => '"$1" hediyesini silmek istediğinizden emin misiniz?
Aynı zamanda bu ödülü almış olan kullanıcılardan da silinecek.',
	'g-description-title' => '$1 tarafından verilen "$2" hediyesi',
	'g-error-do-not-own' => 'Bu hediyeye sahip değilsiniz.',
	'g-error-message-blocked' => 'Şu an engellenmiş durumdasınız ve hediye vermeniz mümkün değil',
	'g-error-message-invalid-link' => 'Girdiğiniz bağlantı geçersiz.',
	'g-error-message-login' => 'Hediye vermek için oturum açmalısınız',
	'g-error-message-no-user' => 'Görüntülemeye çalıştığınız kullanıcı mevcut değil.',
	'g-error-message-to-yourself' => 'Kendinize hediye veremezsiniz.',
	'g-error-title' => 'Hay Allah, yanlış bir işlem yaptınız!',
	'g-file-instructions' => "Resminiz jpeg, png veya gif (animasyonlu gif dosyaları hariç) olmalı ve boyutu 100kb'ın altında olmalı.",
	'g-from' => '<a href="$1">$2</a> adlı kullanıcıdan',
	'g-gift' => 'hediye',
	'g-gift-name' => 'hediye adı',
	'g-give-gift' => 'Hediye ver',
	'g-give-all' => '$1 adlı kullanıcıya hediye vermek ister misiniz?
Sadece aşağıdaki hediyelerden birine tıklayın ve "Hediye gönder" seçeneğine tıklayın.
Bu kadar kolay.',
	'g-give-all-message-title' => 'Bir mesaj ekle',
	'g-give-all-title' => '$1 adlı kullanıcıya hediye ver',
	'g-give-enter-friend-title' => 'Kullanıcının adını biliyorsanız, aşağıya girin',
	'g-given' => 'Bu hediye $1 {{PLURAL:$1|kez|kez}} verildi',
	'g-give-list-friends-title' => 'Arkadaş listenizden seçin',
	'g-give-list-select' => 'bir arkadaş seç',
	'g-give-separator' => 'ya da',
	'g-give-no-user-message' => 'Hediye ve ödüller arkadaşlarınıza teşekkür etmek için harika bir yol!',
	'g-give-no-user-title' => 'Hediyeyi kime vermek istersiniz?',
	'g-give-to-user-title' => '$2 adlı kullanıcıya "$1" hediyesini gönder',
	'g-give-to-user-message' => '$1 adlı kullanıcıya <a href="$2">farklı bir hediye</a> vermek ister misiniz?',
	'g-go-back' => 'Geri git',
	'g-imagesbelow' => 'Sitede kullanılacak resimleriniz aşağıdadır',
	'g-large' => 'Büyük',
	'g-list-title' => '$1 adlı kullanıcının hediye listesi',
	'g-main-page' => 'Ana sayfa',
	'g-medium' => 'Orta',
	'g-mediumlarge' => 'Orta-büyük',
	'g-new' => 'yeni',
	'g-next' => 'Sonraki',
	'g-previous' => 'Önceki',
	'g-remove' => 'Kaldır',
	'g-remove-gift' => 'Bu hediyeyi kaldır',
	'g-remove-message' => '"$1" hediyesini kaldırmak istediğinizden emin misiniz?',
	'g-recent-recipients' => 'Bu hediyenin diğer yakın zamanlı alıcıları',
	'g-remove-success-title' => '"$1" hediyesini başarıyla kaldırdınız',
	'g-remove-success-message' => '"$1" hediyesi kaldırıldı.',
	'g-remove-title' => '"$1" hediyesini kaldırmak ister misiniz?',
	'g-send-gift' => 'Hediye gönder',
	'g-select-a-friend' => 'bir arkadaş seç',
	'g-sent-title' => '$1 adlı kullanıcıya bir hediye gönderdiniz',
	'g-sent-message' => 'Aşağıdaki hediyeyi $1 adlı kullanıcıya gönderdiniz.',
	'g-small' => 'Küçük',
	'g-to-another' => 'Başkasına ver',
	'g-uploadsuccess' => 'Yükleme başarılı',
	'g-viewgiftlist' => 'Hediye listesini gör',
	'g-your-profile' => 'Profiliniz',
	'gift_received_subject' => '$1 size {{SITENAME}} üzerinde $2 hediyesini gönderdi!',
	'gift_received_body' => 'Merhaba $1.

$2 size {{SITENAME}} üzerinde $3 hediyesini gönderdi.

$2 tarafından sizin için bırakılan notu okumak ve hediyenizi görmek ister misiniz? Aşağıdaki bağlantıya tıklayın:

$4

Umarım hoşunuza gider!

Teşekkürler,

{{SITENAME}} ekibi

---

Hey, bizden e-posta alımını durdurmak ister misiniz?

$5 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'right-giftadmin' => 'Yeni hediye oluşturur ve mevcut hediyeleri düzenler',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'g-main-page' => 'Баш бит',
	'g-medium' => 'Урта',
	'g-mediumlarge' => 'Уртача зур',
	'g-new' => 'яңа',
	'g-next' => 'Киләсе',
	'g-previous' => 'Алдагы',
	'g-remove' => 'Бетерү',
	'g-remove-gift' => 'Бу бүләкне бетерү',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'g-cancel' => 'Скасувати',
	'g-go-back' => 'Назад',
	'g-large' => 'Великий',
	'g-main-page' => 'Головна сторінка',
	'g-medium' => 'Середній',
	'g-new' => 'новий',
	'g-next' => 'Наступний',
	'g-previous' => 'Попередній',
	'g-small' => 'Малий',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'g-cancel' => 'منسوخ',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'g-gift' => 'lahj',
	'g-gift-name' => 'lahjan nimi',
	'g-give-gift' => 'Anda lahj',
	'g-give-separator' => 'vai',
	'g-large' => "Sur'",
	'g-list-title' => '$1-kävutajan lahjoiden nimikirjutez',
	'g-new' => "uz'",
	'g-next' => "Jäl'ghine",
	'g-previous' => 'Edeline',
	'g-small' => "Pen'",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'g-cancel' => 'Hủy bỏ',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'g-cancel' => '取消',
);

/** Kalmyk (Хальмг)
 * @author Huuchin
 */
$messages['xal'] = array(
	'g-main-page' => 'Нүр халх',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'giftmanager-private' => 'פריוואט',
	'g-choose-file' => 'קלויבט טעקע:',
	'g-cancel' => 'אַנולירן',
	'g-created-by' => 'געשאַפֿן דורך',
	'g-give-separator' => 'אדער',
	'g-large' => 'גרויס',
	'g-main-page' => 'הויפט בלאט',
	'g-new' => 'נײַ',
	'g-next' => 'נעקסט',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'giftmanager-access' => '礼品访问',
	'giftmanager-description' => '礼物说明',
	'giftmanager-giftimage' => '礼品图像',
	'giftmanager-image' => '加入／替换图片',
	'giftmanager-public' => '公共的',
	'giftmanager-view' => '检视礼物清单',
	'g-back-gift-list' => '回到礼物清单',
	'g-choose-file' => '选择档案：',
	'g-cancel' => '取消',
	'g-create-gift' => '创造礼物',
	'g-current-image' => '当前图像',
	'g-error-message-to-yourself' => '您不能送礼物给自己。',
	'g-gift' => '礼物',
	'g-gift-name' => '送礼物',
	'g-give-gift' => '礼物名称',
	'g-give-all-title' => '送礼物给$1',
	'g-give-list-friends-title' => '在您的朋友清单中选择',
	'g-give-list-select' => '选择一位朋友',
	'g-give-separator' => '或',
	'g-give-no-user-title' => '您想送礼物给哪人?',
	'g-go-back' => '后退',
	'g-large' => '大',
	'g-list-title' => '$1的礼物清单',
	'g-main-page' => '主页',
	'g-medium' => '中',
	'g-mediumlarge' => '中至大',
	'g-new' => '新',
	'g-next' => '下一个',
	'g-previous' => '前页',
	'g-remove' => '移除',
	'g-remove-gift' => '移除这份礼物',
	'g-remove-title' => '移除「$1」?',
	'g-send-gift' => '传送礼物',
	'g-select-a-friend' => '选择一位朋友',
	'g-sent-title' => '您已传送礼物给$1',
	'g-sent-message' => '您已传送以下礼物给$1。',
	'g-small' => '小',
	'g-uploadsuccess' => '上载成功',
	'g-viewgiftlist' => '检视礼物清单',
	'g-your-profile' => '您的个人资料',
	'right-giftadmin' => '创建新的和编辑现有的礼物',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'giftmanager-access' => '禮品訪問',
	'giftmanager-description' => '禮物說明',
	'giftmanager-giftimage' => '禮物圖片',
	'giftmanager-image' => '加入／替換圖片',
	'giftmanager-public' => '公共的',
	'giftmanager-view' => '檢視禮物清單',
	'g-back-gift-list' => '返回到禮物清單',
	'g-choose-file' => '選擇檔案：',
	'g-cancel' => '取消',
	'g-error-message-to-yourself' => '您不能送禮物給自己。',
	'g-gift' => '禮物',
	'g-gift-name' => '送禮物',
	'g-give-gift' => '禮物名稱',
	'g-give-all-title' => '送禮物給 $1',
	'g-give-list-friends-title' => '在您的朋友清單中選擇',
	'g-give-list-select' => '選擇一位朋友',
	'g-give-separator' => '或',
	'g-give-no-user-title' => '您想送禮物給哪人?',
	'g-go-back' => '返回',
	'g-large' => '大',
	'g-list-title' => '$1 的禮物清單',
	'g-main-page' => '首頁',
	'g-medium' => '中',
	'g-mediumlarge' => '中至大',
	'g-remove' => '移除',
	'g-remove-gift' => '移除這份禮物',
	'g-remove-title' => '移除「$1」?',
	'g-send-gift' => '傳送禮物',
	'g-select-a-friend' => '選擇一位朋友',
	'g-sent-title' => '您已傳送禮物給 $1',
	'g-sent-message' => '您已傳送以下禮物給 $1。',
	'g-small' => '小',
	'g-uploadsuccess' => '上傳成功',
	'g-viewgiftlist' => '檢視禮物清單',
	'g-your-profile' => '您的個人資料',
);

