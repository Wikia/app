<?php
/**
 * TopLists extension message file
 */

$messages = array();

$messages['en'] = array(
	//info
	'toplists-desc' => 'Top 10 lists',

	//rights
	'right-toplists-create-edit-list' => 'Create and edit Top 10 list pages',
	'right-toplists-create-item' => 'Create and add items to a Top 10 list page',
	'right-toplists-edit-item' => 'Edit items in a Top 10 list page',
	'right-toplists-delete-item' => 'Delete items from a Top 10 list page',

	//special pages
	'createtoplist' => 'Create a new Top 10 list',
	'edittoplist' => 'Edit Top 10 list',

	//category
	'toplists-category' => 'Top 10 Lists',

	//errors
	'toplists-error-invalid-title' => 'The supplied text is not valid.',
	'toplists-error-invalid-picture' => 'The selected picture is not valid.',
	'toplists-error-title-exists' => 'This page already exists. You can go to <a href="$2" target="_blank">$1</a> or supply a different name.',
	'toplists-error-title-spam' => 'The supplied text contains some words recognized as spam.',
	'toplists-error-article-blocked' => 'You are not allowed to create a page with this name. Sorry.',
	'toplists-error-article-not-exists' => '"$1" does not exist. Do you want to <a href="$2" target="_blank">create it</a>?',
	'toplists-error-picture-not-exists' => '"$1" does not exist. Do you want to <a href="$2" target="_blank">upload it</a>?',
	'toplists-error-duplicated-entry' => 'You can\'t use the same name more than once.',
	'toplists-error-empty-item-name' => 'The name of an existing item can\'t be empty.',
	'toplists-item-cannot-delete' => 'Deletion of this item failed.',
	'toplists-error-image-already-exists' => 'An image with the same name already exists.',
	'toplists-error-add-item-anon' => 'Anonymous users are not allowed to add items to lists. Please <a class="ajaxLogin" id="login" href="$1">Log in</a> or <a href="$2">register a new account</a>.',
	'toplists-error-add-item-permission' => 'Permission error: Your account has not been granted the right to create new items.',
	'toplists-error-add-item-list-not-exists' => 'The "$1" Top 10 list does not exist.',
	'toplists-upload-error-unknown' => 'An error occurred while processing the upload request. Please try again.',
	'action-toplists-create-edit-list' => 'create and edit Top 10 list pages',

	//editor
	'toplists-editor-title-label' => 'List name',
	'toplists-editor-title-placeholder' => 'Enter a name for the list',
	'toplists-editor-related-article-label' => 'Related page <small>(optional, but selects an image)</small>',
	'toplists-editor-related-article-placeholder' => 'Enter an existing page name',
	'toplists-editor-description-label' => 'A short description of your Top 10 List',
	'toplists-editor-description-placeholder' => 'Enter a description',
	'toplists-editor-image-browser-tooltip' => 'Add a picture',
	'toplists-editor-remove-item-tooltip' => 'Remove item',
	'toplists-editor-drag-item-tooltip' => 'Drag to change order',
	'toplists-editor-add-item-label' => 'Add a new item',
	'toplists-editor-add-item-tooltip' => 'Add a new item to the list',
	'toplists-create-button' => 'Create list',
	'toplists-update-button' => 'Save list',
	'toplists-cancel-button' => 'Cancel',
	'toplists-items-removed' => '$1 {{PLURAL:$1|item|items}} removed',
	'toplists-items-created' => '$1 {{PLURAL:$1|item|items}} created',
	'toplists-items-updated' => '$1 {{PLURAL:$1|item|items}} updated',
	'toplists-items-nochange' => 'No items changed',

	//image browser/selector
	'toplits-image-browser-no-picture-selected' => 'No picture selected',
	'toplits-image-browser-clear-picture' => 'Clear picture',
	'toplits-image-browser-selected-picture' => 'Currently selected: $1',
	'toplists-image-browser-upload-btn' => 'Choose',
	'toplists-image-browser-upload-label' => 'Upload your own',

	//article edit summaries
	'toplists-list-creation-summary' => 'Creating a list, $1',
	'toplists-list-update-summary' => 'Updating a list, $1',
	'toplists-item-creation-summary' => 'Creating a list item',
	'toplists-item-update-summary' => 'Updating a list item',
	'toplists-item-remove-summary' => 'Item removed from list',
	'toplists-item-restored' => 'Item restored',

	//list view
	'toplists-list-related-to' => 'Related to:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />vote|$1<br />votes}}',
	'toplists-list-created-by' => 'by [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Vote up',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|vote|votes}} in $2',
	'toplists-list-add-item-label' => 'Add item',
	'toplists-list-add-item-name-label' => 'Keep the list going...',
	'toplists-list-item-voted' => 'Voted',

	//createpage dialog
	'toplists-createpage-dialog-label' => 'Top 10 list',

	//watchlist emails
	'toplists-email-subject' => 'A Top 10 list has been changed',
	'toplists-email-body' => "Hello from Wikia!

The list <a href=\"$1\">$2</a> on Wikia has been changed.

 $3

Head to Wikia to check out the changes! $1

- Wikia\n\nYou can <a href=\"$4\">unsubscribe</a> from changes to the list.",

	//time
	'toplists-seconds' => '$1 {{PLURAL:$1|second|seconds}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minute|minutes}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hour|hours}}',
	'toplists-days' => '$1 {{PLURAL:$1|day|days}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|week|weeks}}',

	//FB connect article vote message
	'toplists-msg-fb-OnRateArticle-link' => '$ARTICLENAME',
	'toplists-msg-fb-OnRateArticle-short' =>  'has voted on a Top 10 list on $WIKINAME!', // @todo FIXME: If possible add username as a variable here.
	'toplists-msg-fb-OnRateArticle' => '$TEXT',

	//Create list call to action
	'toplists-create-heading' => '<em>New!</em> Create Your Own Top Ten',
	'toplists-create-button-msg' => 'Create a list',

	'toplists-oasis-only' => 'Creating and editing Top 10 lists is not available in Monobook. If you would like to use this feature, please switch your preference to the Wikia skin.',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Shirayuki
 * @author Siebrand
 */
$messages['qqq'] = array(
	'toplists-desc' => '{{desc}}',
	'right-toplists-create-edit-list' => '{{doc-right|toplists-create-edit-list}}',
	'right-toplists-create-item' => '{{doc-right|toplists-create-item}}',
	'right-toplists-edit-item' => '{{doc-right|toplists-edit-item}}',
	'right-toplists-delete-item' => '{{doc-right|toplists-delete-item}}',
	'toplists-category' => 'The name for the category that lists all the Top 10 Lists on a wiki',
	'action-toplists-create-edit-list' => '{{doc-action|toplists-create-edit}}',
	'toplists-editor-remove-item-tooltip' => '{{Identical|Remove item}}',
	'toplists-create-button' => '{{Identical|Create list}}',
	'toplits-image-browser-selected-picture' => '$1 is the title of the image page.',
	'toplists-image-browser-upload-btn' => '{{Identical|Choose}}',
	'toplists-list-vote-up' => 'Keep this as short as possible. Everything exceeding allowed lenght will be cutted out!',
	'toplists-seconds' => '{{Identical|Second}}',
	'toplists-minutes' => '{{Identical|Minute}}',
	'toplists-create-button-msg' => '{{Identical|Create list}}',
	'toplists-oasis-only' => 'Displayed to users who try to edit or create Top 10 lists in a skin other than the Wikia skin.',
);

/** Arabic (العربية)
 * @author Achraf94
 * @author Imksa
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'toplists-desc' => 'قائمة أفضل 10',
	'right-toplists-create-edit-list' => 'إنشاء وتحرير صفحات قائمة أفضل 10',
	'right-toplists-create-item' => 'إنشاء وإضافة عناصر إلى صفحة قائمة أفضل 10',
	'right-toplists-edit-item' => 'تحرير العناصر الموجودة في صفحة قائمة أفضل 10',
	'right-toplists-delete-item' => 'حذف العناصر من صفحة قائمة أفضل 10',
	'createtoplist' => 'إنشاء قائمة جديدة  بأفضل 10',
	'edittoplist' => 'تحرير قائمة أفضل 10',
	'toplists-category' => 'قوائم أفضل 10',
	'toplists-error-invalid-title' => 'النص المعطى غير صحيح.',
	'toplists-error-invalid-picture' => 'الصورة المحددة غير صالحة.',
	'toplists-error-title-exists' => 'هذه الصفحة موجودة بالفعل. يمكنك الذهاب إلى <a href="<span class=" notranslate"="">$2 "الهدف =" _blank ">$1</a> أو قم بتوفير اسم مختلف.',
	'toplists-error-title-spam' => 'النص يحتوي على بعض الكلمات المعرفة كدعاية.',
	'toplists-error-article-blocked' => 'عذراً غير مسموح لك إنشاء صفحة بهذا الاسم.',
	'toplists-error-article-not-exists' => '"$1" غير موجودة. هل تريد a href="$2" target="_blank">إنشائها</a>؟',
	'toplists-error-picture-not-exists' => '"$1" غير موجودة. هل تريد <a href="$2" target="_blank">تحميلها</a>؟',
	'toplists-error-duplicated-entry' => 'لا يمكنك استخدام نفس الاسم أكثر من مرة.',
	'toplists-error-empty-item-name' => 'لا يمكن أن يكون اسم عنصر القائمة فارغة.',
	'toplists-item-cannot-delete' => 'فشل في حذف هذا البند.',
	'toplists-error-image-already-exists' => 'صورة مع نفس الاسم موجود مسبقا.',
	'toplists-error-add-item-anon' => 'لا يسمح للمستخدمين المجهولين إضافة عناصر  للقوائم. الرجاء <a class="ajaxLogin" id="login" href="<span class="notranslate">$1 ">تسجيل الدخول</a> أو <a class="ajaxLogin" id="signup" href="<span class="notranslate">$2 "> تسجيل حساب جديد</a> .',
	'toplists-error-add-item-permission' => 'خطأ في إذن الوصول: الحساب الخاص بك لم يتم منح الحق في إنشاء عناصر جديدة.',
	'toplists-error-add-item-list-not-exists' => '"$1" لا توجد في قائمة أفضل 10',
	'toplists-upload-error-unknown' => 'حدث خطأ أثناء معالجة طلب التحميل. يرجى المحاولة مرة أخرى.',
	'action-toplists-create-edit-list' => 'أنشئ و عدل صفحات قوائم أفضل 10',
	'toplists-editor-title-label' => 'اسم القائمة',
	'toplists-editor-title-placeholder' => 'أدخل اسما للقائمة',
	'toplists-editor-related-article-label' => 'الصفحة ذات الصلة <small>(اختياري، لكن حدد صورة)</small>',
	'toplists-editor-related-article-placeholder' => 'أدخل اسم الصفحة الحالية',
	'toplists-editor-description-label' => 'وصف قصير لقائمة أفضل 10',
	'toplists-editor-description-placeholder' => 'أدخل وصفاً',
	'toplists-editor-image-browser-tooltip' => 'أضف صورة',
	'toplists-editor-remove-item-tooltip' => 'أزل العنصر',
	'toplists-editor-drag-item-tooltip' => 'اسحب لتغيير الطلب',
	'toplists-editor-add-item-label' => 'أضف عنصرًا جديدًا',
	'toplists-editor-add-item-tooltip' => 'إضافة عنصر جديد إلى القائمة',
	'toplists-create-button' => 'أنشئ قائمة',
	'toplists-update-button' => 'احفظ القائمة',
	'toplists-cancel-button' => 'إلغاء',
	'toplists-items-removed' => 'تمت إزالة {{PLURAL:$1|عنصر واحد|$1 عناصر}}',
	'toplists-items-nochange' => 'لا يوجد تغيير في العناصر',
	'toplits-image-browser-no-picture-selected' => 'ليست هناك صورة مختارة',
	'toplits-image-browser-clear-picture' => 'صورة واضحة',
	'toplits-image-browser-selected-picture' => 'المحدد حاليا:$1',
	'toplists-image-browser-upload-btn' => 'اختر',
	'toplists-image-browser-upload-label' => 'تحميل الخاصة بك',
	'toplists-list-creation-summary' => 'إنشاء قائمة ، $1',
	'toplists-list-update-summary' => 'تحديث قائمة،$1',
	'toplists-item-creation-summary' => 'إنشاء قائمة عناصر',
	'toplists-item-update-summary' => 'تحديث قائمة عناصر',
	'toplists-item-remove-summary' => 'تمت إزالة البند من القائمة',
	'toplists-item-restored' => 'تم استعادة عنصر',
	'toplists-list-related-to' => 'المتعلقة بما يلي :',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />تصويت|$1<br />تصويتا}}',
	'toplists-list-created-by' => 'بواسطة [[User:$1|$1]]',
	'toplists-list-vote-up' => 'التصويت حتى',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|تصويت}} في $2',
	'toplists-list-add-item-label' => 'أضف عنصرًا',
	'toplists-list-add-item-name-label' => 'الحفاظ على القائمة مستمرة...',
	'toplists-list-item-voted' => 'صوت',
	'toplists-createpage-dialog-label' => 'قائمة أفضل 10',
	'toplists-email-subject' => 'لقد تم تغيير قائمة أفضل 10',
	'toplists-email-body' => 'مرحبا من ويكيا!

لقد تم تغيير قائمة <a href="$1>$2</a> في ويكيا.

$3

التوجه إلى ويكيا للتحقق من التغييرات! $1

-ويكيا

يمكنك  <a href="$4">إلغاء الإشتراك</a> من خلال التغييرات  للقائمة.',
	'toplists-msg-fb-OnRateArticle-short' => 'صوت على قائمة أفضل 10 في $WIKINAME!',
	'toplists-create-heading' => '<em>خاصية جديدة!</em> إنشاء قائمة أفضل عشرة خاصة بك',
	'toplists-create-button-msg' => 'إنشاء قائمة',
	'toplists-oasis-only' => 'إنشاء وتحرير قوائم أفضل 10 ليس متوفرا في مونوبوك. إذا كنت ترغب في استخدام هذه الميزة، يرجى تبديل تفضيلاتك لمظهر ويكيا.',
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'toplists-cancel-button' => 'Ləğv et',
	'toplists-list-created-by' => '[[User:$1|$1]] tərəfindən',
	'toplists-seconds' => '$1 {{PLURAL:$1|saniyə|saniyə}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|dəqiqə|dəqiqə}}',
	'toplists-hours' => '$1 {{PLURAL:$1|saat|saat}}',
	'toplists-days' => '$1 {{PLURAL:$1|gün|gün}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|həftə|həftə}}',
);

/** Bulgarian (български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'toplists-editor-title-label' => 'Име на списъка',
	'toplists-editor-title-placeholder' => 'Въвежда се името на списъка',
	'toplists-editor-image-browser-tooltip' => 'Добавяне на картинка',
	'toplists-create-button' => 'Създаване на списък',
	'toplists-update-button' => 'Съхраняване на списък',
	'toplists-cancel-button' => 'Отказване',
	'toplists-image-browser-upload-btn' => 'Избиране',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />глас|$1<br />гласа}}',
	'toplists-list-created-by' => 'от [[User:$1|$1]]',
	'toplists-seconds' => '$1 {{PLURAL:$1|секунда|секунди}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|минута|минути}}',
	'toplists-hours' => '$1 {{PLURAL:$1|час|часа}}',
	'toplists-days' => '$1 {{PLURAL:$1|ден|дни}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|седмица|седмици}}',
	'toplists-create-button-msg' => 'Създаване на списък',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'toplists-desc' => 'Roll Top 10',
	'right-toplists-create-edit-list' => 'Krouiñ pe kemmañ pajennoù eus ar roll Top 10',
	'right-toplists-create-item' => "Krouiñ pe ouzhpennañ elfennoù d'ur bajenn eus roll an Top 10",
	'createtoplist' => 'Krouiñ ur roll Top 10 nevez',
	'edittoplist' => 'Kemmañ ur roll Top 10',
	'toplists-category' => 'Rolloù Top 10',
	'toplists-error-invalid-title' => "N'eo ket reizh an destenn pourchaset",
	'toplists-error-invalid-picture' => "N'eo ket reizh ar skeudenn diuzet.",
	'toplists-error-title-exists' => 'N\'eus ket eus ar bajenn-se. Gellout a rit mont da <a href="$2" target="_blank">$1</a> pe reiñ un anv disheñvel.',
	'toplists-error-title-spam' => 'En destenn pourchaset ez eus un nebeut gerioù anavezet evel strobus.',
	'toplists-error-article-blocked' => "Ho tigarez. N'oc'h ket aotreet da grouiñ ur bajenn nevez dezhi an anv-mañ.",
	'toplists-error-article-not-exists' => 'N\'eus ket eus ar pennad "$1". Ha fellout a ra deoc\'h <a href="$2" target="_blank">e grouiñ</a> ?',
	'toplists-error-picture-not-exists' => 'N\'eus ket eus ar restr "$1". Ha fellout a ra deoc\'h <a href="$2" target="_blank">hec\'h enporzhiañ</a> ?',
	'toplists-error-duplicated-entry' => "N'hallit ket obet gant an hevelep anv ouzhpenn ur wezh.",
	'toplists-error-empty-item-name' => "N'hall ket anv un elfenn bzeañ goullo.",
	'toplists-item-cannot-delete' => "C'hwitet eo bet diverkadenn an elfenn-mañ",
	'toplists-error-image-already-exists' => "Ur skeudenn dezhi an hevelep anv zo c'hoazh.",
	'toplists-error-add-item-anon' => 'N\'eo ket aotreet an implijerien dizanv da ouzhpennañ elfennoù d\'ar rolloù. <a class="ajaxLogin" id="login" href="$1">Kevreit</a> pe <a href="$2">savit ur gont nevez</a>.',
	'toplists-error-add-item-permission' => "Fazi aotre : N'eo ket aotreet ho kont da grouiñ elfennoù nevez.",
	'toplists-error-add-item-list-not-exists' => 'N\'eus ket eus ar roll Top 10 "$1".',
	'toplists-editor-title-label' => 'Anv ar roll',
	'toplists-editor-title-placeholder' => 'Roit un anv evit ar roll',
	'toplists-editor-related-article-label' => 'Pajenn kar <small>(diret, met termeniñ a ra ur skeudenn)</small>',
	'toplists-editor-related-article-placeholder' => "Merkañ anv ur bajenn zo anezhi c'hoazh",
	'toplists-editor-description-placeholder' => 'Ebarzhiñ un deskrivadur',
	'toplists-editor-image-browser-tooltip' => 'Ouzhpennañ ur skeudenn',
	'toplists-editor-remove-item-tooltip' => 'Tennañ an elfenn',
	'toplists-editor-drag-item-tooltip' => 'Lakait da riklañ evit cheñch an urzh',
	'toplists-editor-add-item-label' => 'Ouzhpennañ un elfenn nevez',
	'toplists-editor-add-item-tooltip' => "Ouzhpennañ un objed nevez d'ar roll",
	'toplists-create-button' => 'Sevel ar roll',
	'toplists-update-button' => 'Enrollañ ar roll',
	'toplists-cancel-button' => 'Nullañ',
	'toplists-items-removed' => '$1 {{PLURAL:$1|objed|objed}} dilamet',
	'toplists-items-created' => '$1 {{PLURAL:$1|objed|objed}} krouet',
	'toplists-items-updated' => '$1 {{PLURAL:$1|objed|objed}} hizivaet',
	'toplists-items-nochange' => "N'eus bet cheñchet elfenn ebet",
	'toplits-image-browser-no-picture-selected' => "N'eus skeudenn diuzet ebet",
	'toplits-image-browser-clear-picture' => 'Diverkañ ar skeudenn',
	'toplits-image-browser-selected-picture' => 'Skeudenn diuzet evit ar mare : $1',
	'toplists-image-browser-upload-btn' => 'Dibab',
	'toplists-image-browser-upload-label' => 'Enporzhiañ ho hini',
	'toplists-list-creation-summary' => 'O krouiñ ur roll, $1',
	'toplists-list-update-summary' => "Oc'h enporzhiañ ur roll, $1",
	'toplists-item-creation-summary' => 'O krouiñ ur roll elfennoù',
	'toplists-item-update-summary' => 'O hizivaat ur roll elfennoù',
	'toplists-item-remove-summary' => 'Objed dilamet eus ar roll',
	'toplists-item-restored' => 'Elfenn assavet',
	'toplists-list-related-to' => 'Liammet ouzh :',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />mouezh|$1<br />mouezh}}',
	'toplists-list-created-by' => 'gant [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Votiñ a-du',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|vot|vot}} e $2',
	'toplists-list-add-item-label' => 'Ouzhpennañ un elfenn',
	'toplists-list-add-item-name-label' => 'Lezel ar roll da vont...',
	'toplists-list-item-voted' => 'Votet',
	'toplists-createpage-dialog-label' => 'Roll Top 10',
	'toplists-email-subject' => 'Kemmet ez eus bet ur roll Top 10',
	'toplists-email-body' => 'Demat a-berzh Wikia !

Kemmet eo bet ar roll <a href="$1">$2</a> war Wikia.

 $3

Emgav war Wikia evit gwiriekaat ar c\'hemmoù ! $1

- Wikia

Gellout a rit <a href="$4">paouez da resevout</a> kemmoù ar roll-mañ.',
	'toplists-seconds' => '$1 {{PLURAL:$1|eilenn|eilenn}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|munut|munut}}',
	'toplists-hours' => '$1 {{PLURAL:$1|eur|eur}}',
	'toplists-days' => '$1 {{PLURAL:$1|deiz|deiz}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|sizhun|sizhun}}',
	'toplists-msg-fb-OnRateArticle-short' => 'en deus votet war ur roll Top 10 list war $WIKINAME !',
	'toplists-create-heading' => "<em>Nevez!</em> Savit ho roll Top 10 deoc'h-c'hwi",
	'toplists-create-button-msg' => 'Sevel ur roll',
);

/** Catalan (català)
 * @author Light of Cosmos
 * @author Marcmpujol
 */
$messages['ca'] = array(
	'toplists-desc' => 'Els 10 millors',
	'right-toplists-create-edit-list' => 'Crea i edita pàgines dels 10 millors',
	'right-toplists-create-item' => 'Crea y afegeix elements a una pàgina dels 10 millors',
	'toplists-editor-description-placeholder' => 'Introduïu una descripció',
	'toplists-editor-image-browser-tooltip' => 'Afegir una imatge',
	'toplists-editor-remove-item-tooltip' => 'Esborrar ítem',
	'toplists-create-button' => 'Crear llista',
	'toplists-update-button' => 'Desar llista',
	'toplists-cancel-button' => 'Cancel·la',
	'toplits-image-browser-clear-picture' => 'Imatge clara',
	'toplists-image-browser-upload-btn' => 'Escollir',
	'toplists-image-browser-upload-label' => 'Carrega el teu propi',
	'toplists-list-creation-summary' => 'Creant una llista, $1',
	'toplists-item-remove-summary' => 'Element esborrat de la llista',
	'toplists-item-restored' => 'Ítem restaurat',
	'toplists-list-related-to' => 'Relacionat amb:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />vot|$1<br />vots}}',
	'toplists-list-created-by' => 'per [[User:$1|$1]]',
);

/** Chechen (нохчийн)
 * @author Умар
 */
$messages['ce'] = array(
	'toplists-editor-related-article-placeholder' => 'ДӀаязъе йолуш йолу агӀона цӀе',
	'toplists-update-button' => 'МогӀам Ӏалашбар',
);

/** Czech (česky)
 * @author Chmee2
 * @author Darth Daron
 */
$messages['cs'] = array(
	'toplists-desc' => 'Top 10 seznamy',
	'right-toplists-create-edit-list' => 'Vytvořit a upravit stránky Top 10 seznamů',
	'right-toplists-create-item' => 'Vytvořit a přidat položky na stránku Top 10 seznamu',
	'right-toplists-edit-item' => 'Upravit položky na stránce Top 10 seznamu',
	'right-toplists-delete-item' => 'Odstranit položky ze stránky Top 10 seznamu',
	'createtoplist' => 'Vytvořit nový Top 10 seznam',
	'edittoplist' => 'Upravit Top 10 seznam',
	'toplists-category' => 'Top 10 seznamy',
	'toplists-error-invalid-title' => 'Zadaný text není platný.',
	'toplists-error-invalid-picture' => 'Vybraný obrázek je neplatný.',
	'toplists-error-title-exists' => 'Tato stránka již existuje. Můžete jít na <a href="$2" target="_blank">$1</a> nebo zadat jiný název.',
	'toplists-error-title-spam' => 'Zadaný text obsahuje některá slova rozpoznaná jako spam.',
	'toplists-error-article-blocked' => 'Omlouváme se, ale není dovoleno vytvořit stránku s tímto názvem.',
	'toplists-error-article-not-exists' => '" $1 " neexistuje. Chcete ho  <a href="$2" target="_blank">vytvořit</a>?',
	'toplists-error-picture-not-exists' => '" $1 " neexistuje. Chcete ho  <a href="$2" target="_blank">nahrát</a>?',
	'toplists-error-duplicated-entry' => 'Nelze použít stejný název více než jednou.',
	'toplists-error-empty-item-name' => 'Název existující položky nemůže být prázdný.',
	'toplists-item-cannot-delete' => 'Odstranění této položky se nezdařilo.',
	'toplists-error-image-already-exists' => 'Obrázek se stejným názvem již existuje.',
	'toplists-error-add-item-anon' => 'Anonymní uživatelé nemohou přidávat položky do seznamů. Prosíme <a class="ajaxLogin" id="login" href="$1">přihlašte se</a> nebo <a href="$2">se zaregistrujte</a>.',
	'toplists-error-add-item-permission' => 'Chyba oprávnění: Vašemu účetu nebylo uděleno právo k vytvoření nových položek.',
	'toplists-error-add-item-list-not-exists' => 'Top 10 seznam s názvem "$1" neexistuje.',
	'toplists-upload-error-unknown' => 'Došlo k chybě při nahrávání. Opakujte akci.',
	'action-toplists-create-edit-list' => 'vytvářet a upravovat stránky Top 10 seznamů',
	'toplists-editor-title-label' => 'Název seznamu',
	'toplists-editor-title-placeholder' => 'Zadejte název seznamu',
	'toplists-editor-related-article-label' => 'Související stránka <small>(nepovinné, ale vybere obrázek)</small>',
	'toplists-editor-related-article-placeholder' => 'Zadejte existující název stránky',
	'toplists-editor-description-label' => 'Krátký popis Vašeho Top 10 seznamu',
	'toplists-editor-description-placeholder' => 'Zadejte popis',
	'toplists-editor-image-browser-tooltip' => 'Přidat obrázek',
	'toplists-editor-remove-item-tooltip' => 'Odstranit položku',
	'toplists-editor-drag-item-tooltip' => 'Přetažením lze změnit pořadí',
	'toplists-editor-add-item-label' => 'Přidat novou položku',
	'toplists-editor-add-item-tooltip' => 'Přidat novou položku do seznamu',
	'toplists-create-button' => 'Vytvořit seznam',
	'toplists-update-button' => 'Uložit seznam',
	'toplists-cancel-button' => 'Zrušit',
	'toplists-items-removed' => '$1 {{PLURAL:$1|položka odstraněna|položky odstraněny|položek odstraněno}}',
	'toplists-items-created' => '$1 {{PLURAL:$1|položka vytvořena|položky vytvořeny|položek vytvořeno}}',
	'toplists-items-updated' => '$1 {{PLURAL:$1|položka aktualizována|položky aktualizovány|položek aktualizováno}}',
	'toplists-items-nochange' => 'Žádná položka nezměněna',
	'toplits-image-browser-no-picture-selected' => 'Žádný obrázek nebyl vybrán',
	'toplits-image-browser-clear-picture' => 'Vymazat obrázek',
	'toplits-image-browser-selected-picture' => 'Aktuálně vybrané:$1',
	'toplists-image-browser-upload-btn' => 'Zvolit',
	'toplists-image-browser-upload-label' => 'Nahrát své vlastní',
	'toplists-list-creation-summary' => 'Vytváření seznamu,$1',
	'toplists-list-update-summary' => 'Aktualizování seznamu,$1',
	'toplists-item-creation-summary' => 'Vytváření položky seznamu',
	'toplists-item-update-summary' => 'Aktualizování položky seznamu',
	'toplists-item-remove-summary' => 'Položka odstraněna ze seznamu',
	'toplists-item-restored' => 'Položka obnovena',
	'toplists-list-related-to' => 'Související s:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />hlas|$1<br />hlasy|$1<br />hlasů}}',
	'toplists-list-created-by' => 'od uživatele [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Zahlasovat',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|hlas|hlasy|hlasů}} v $2',
	'toplists-list-add-item-label' => 'Přidat položku',
	'toplists-list-add-item-name-label' => 'Udržet seznam v chodu ...',
	'toplists-list-item-voted' => 'Zahlasováno',
	'toplists-createpage-dialog-label' => 'Top 10 seznam',
	'toplists-email-subject' => 'Top 10 seznam byl změněn.',
	'toplists-email-body' => 'Wikia vás zdraví!
Seznam <a href="$1">$2</a> byl změněn.
$3
Navštivte Wikia a prohlédněte si změny! $1
- Wikia
Oznamování změn seznamu si můžete <a href="$4">odhlásit</a>.',
	'toplists-seconds' => '$1 {{PLURAL:$1|sekunda|sekundy|sekund}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuta|minuty|minut}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hodina|hodiny|hodin}}',
	'toplists-days' => '$1 {{PLURAL:$1|den|dny|dní}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|týden|týdny|týdnů}}',
	'toplists-msg-fb-OnRateArticle-short' => 'hlasoval na Top 10 seznamu na $WIKINAME!',
	'toplists-create-heading' => '<em>Novinka!</em> Vytvořte si vlastní Top 10 seznam',
	'toplists-create-button-msg' => 'Vytvořit seznam',
	'toplists-oasis-only' => 'Vytváření a úprava Top 10 seznamů není možná v Monobooku. Pokud chcete používat tuto funkcí, přepněte prosím v nastavení na Wikia skin.',
);

/** German (Deutsch)
 * @author Avatar
 * @author LWChris
 * @author Metalhead64
 * @author PtM
 */
$messages['de'] = array(
	'toplists-desc' => 'Top 10 Listen',
	'right-toplists-create-edit-list' => 'Erstelle und bearbeite Top-10-Listen',
	'right-toplists-create-item' => 'Erstelle und füge Einträge zu einer Top 10 Liste hinzu',
	'right-toplists-edit-item' => 'Elemente in einer Top 10 Liste bearbeiten',
	'right-toplists-delete-item' => 'Elemente aus einer Top 10 Liste löschen',
	'createtoplist' => 'Erstelle eine neue Top 10 Liste',
	'edittoplist' => 'Top 10 Liste bearbeiten',
	'toplists-category' => 'Top 10 Listen',
	'toplists-error-invalid-title' => 'Der angegebene Text ist nicht zulässig.',
	'toplists-error-invalid-picture' => 'Das gewählte Bild ist nicht zulässig.',
	'toplists-error-title-exists' => 'Diese Seite existiert bereits. Du kannst zu <a href="$2" target="_blank">$1</a> wechseln oder einen anderen Namen angeben.',
	'toplists-error-title-spam' => 'Der angegebene Text enthält Wörter, die als Spam erkannt wurden.',
	'toplists-error-article-blocked' => 'Du kannst keine Seite mit diesem Namen erzeugen, sorry.',
	'toplists-error-article-not-exists' => '"$1" existiert nicht. Möchtest du diesen <a href="$2" target="_blank">Eintrag erstellen</a>?',
	'toplists-error-picture-not-exists' => '"$1" existiert nicht. Möchtest du diese <a href="$2" target="_blank">Datei hochladen</a>?',
	'toplists-error-duplicated-entry' => 'Du kannst den gleichen Namen nicht mehr als einmal benutzen.',
	'toplists-error-empty-item-name' => 'Der Name eines existierenden Eintrags darf nicht leer sein.',
	'toplists-item-cannot-delete' => 'Die Löschung dieses Eintrags ist fehlgeschlagen.',
	'toplists-error-image-already-exists' => 'Es existiert bereits ein Bild mit diesem Namen.',
	'toplists-error-add-item-anon' => 'Nicht-angemeldete Benutzer dürfen keine Einträge zu Listen hinzufügen. Bitte <a class="ajaxLogin" id="login" href="$1">melde dich an</a> oder <a href="$2">erstelle ein neues Benutzerkonto</a>.',
	'toplists-error-add-item-permission' => 'Keine ausreichenden Rechte: Mit deinem Benutzerkonto kannst du keine neuen Einträge erstellen.',
	'toplists-error-add-item-list-not-exists' => 'Die Top 10 Liste "$1" existiert nicht.',
	'toplists-upload-error-unknown' => 'Beim Verarbeiten der Upload Anfrage ist ein Fehler aufgetreten. Bitte versuche es erneut.',
	'action-toplists-create-edit-list' => 'Erstelle und bearbeite Top-10-Listen',
	'toplists-editor-title-label' => 'Name der Liste',
	'toplists-editor-title-placeholder' => 'Gib der Liste einen Namen',
	'toplists-editor-related-article-label' => 'Verwandte Seite <small>(optional, aber wählt ein Bild)</small>',
	'toplists-editor-related-article-placeholder' => 'Gib den Namen einer bestehenden Seite an',
	'toplists-editor-description-label' => 'Eine kurze Beschreibung der Top-10-Liste',
	'toplists-editor-description-placeholder' => 'Gib eine Beschreibung ein',
	'toplists-editor-image-browser-tooltip' => 'Füge ein Bild hinzu',
	'toplists-editor-remove-item-tooltip' => 'Eintrag entfernen',
	'toplists-editor-drag-item-tooltip' => 'Klicken und ziehen um die Reihenfolge zu ändern',
	'toplists-editor-add-item-label' => 'Neuen Eintrag hinzufügen',
	'toplists-editor-add-item-tooltip' => 'Füge einen neuen Eintrag zur Liste hinzu',
	'toplists-create-button' => 'Liste erstellen',
	'toplists-update-button' => 'Liste speichern',
	'toplists-cancel-button' => 'Abbrechen',
	'toplists-items-removed' => '$1 {{PLURAL:$1|Eintrag|Einträge}} entfernt',
	'toplists-items-created' => '$1 {{PLURAL:$1|Eintrag|Einträge}} erstellt',
	'toplists-items-updated' => '$1 {{PLURAL:$1|Eintrag|Einträge}} aktualisiert',
	'toplists-items-nochange' => 'Keine Einträge geändert',
	'toplits-image-browser-no-picture-selected' => 'Kein Bild ausgewählt',
	'toplits-image-browser-clear-picture' => 'Bild entfernen',
	'toplits-image-browser-selected-picture' => 'Aktuell ausgewählt: $1',
	'toplists-image-browser-upload-btn' => 'Wähle',
	'toplists-image-browser-upload-label' => 'Eigenes Bild hochladen',
	'toplists-list-creation-summary' => 'Erstelle eine Liste, $1',
	'toplists-list-update-summary' => 'Aktualisiere eine Liste, $1',
	'toplists-item-creation-summary' => 'Erstelle einen Listen-Eintrag',
	'toplists-item-update-summary' => 'Aktualisiere einen Listen-Eintrag',
	'toplists-item-remove-summary' => 'Eintrag aus Liste entfernt',
	'toplists-item-restored' => 'Eintrag wiederhergestellt',
	'toplists-list-related-to' => 'Verwandt zu:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />Stimme|$1<br />Stimmen}}',
	'toplists-list-created-by' => 'von [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Zustimmen',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|Stimme|Stimmen}} in $2',
	'toplists-list-add-item-label' => 'Eintrag hinzufügen',
	'toplists-list-add-item-name-label' => 'Führe die Liste fort...',
	'toplists-list-item-voted' => 'Abgestimmt',
	'toplists-createpage-dialog-label' => 'Top 10 Liste',
	'toplists-email-subject' => 'Eine Top 10 Liste wurde geändert',
	'toplists-email-body' => 'Wikia sagt Hallo!

Die Liste <a href="$1">$2</a> in Wikia wurde geändert.

 $3

Besuche Wikia um dir die Änderungen anzusehen! $1

- Wikia

Du kannst die Änderungsbenachrichtigungen zu dieser Liste <a href="$4">abbestellen</a>.',
	'toplists-seconds' => '$1 {{PLURAL:$1|Sekunde|Sekunden}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|Minute|Minuten}}',
	'toplists-hours' => '$1 {{PLURAL:$1|Stunde|Stunden}}',
	'toplists-days' => '$1 {{PLURAL:$1|Tag|Tage}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|Woche|Wochen}}',
	'toplists-msg-fb-OnRateArticle-short' => 'hat bei einer Top 10 Liste abgestimmt ($WIKINAME)!',
	'toplists-create-heading' => '<em>Neu!</em> Erstelle deine eigene Top 10 Liste',
	'toplists-create-button-msg' => 'Liste erstellen',
	'toplists-oasis-only' => 'Das Erstellen und Bearbeiten von Top-10-Listen ist im Monobook-Skin nicht verfügbar. Wenn du diese Funktion nutzen willst, wechsele in deinen Einstellungen zum Wikia-Skin.',
);

/** Zazaki (Zazaki)
 * @author Erdemaslancan
 */
$messages['diq'] = array(
	'toplists-desc' => 'listey Tewr 10a',
	'createtoplist' => 'listey Tewr 10ano newe vırazê',
	'edittoplist' => 'listey Tewr 10a bıvurnê',
	'toplists-category' => 'listey Tewr 10a',
	'toplists-editor-title-label' => 'Namey lista',
	'toplists-editor-image-browser-tooltip' => 'Resim deke',
	'toplists-create-button' => 'Liste vırazê',
	'toplists-update-button' => 'Listi qeyd ke',
	'toplists-cancel-button' => 'Bıterkne',
	'toplists-items-removed' => '$1 {{PLURAL:$1|çi|çiy}} wedariyaya',
	'toplists-items-created' => '$1 {{PLURAL:$1|çi|çiy}} vıraziyay',
	'toplists-items-updated' => '$1 {{PLURAL:$1|çi|çiy}} rocneya',
	'toplists-image-browser-upload-btn' => 'Weçinayış',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />rey|$1<br />reyi}}',
	'toplists-list-created-by' => '[[User:$1|$1]]',
	'toplists-list-add-item-label' => 'Çi de ke',
	'toplists-list-item-voted' => 'Rey Bıdê',
	'toplists-seconds' => '$1 {{PLURAL:$1|saniye|saniyeyan}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|deqa|deqey}}',
	'toplists-hours' => '($1 {{PLURAL:$1|seate|seati}})',
	'toplists-days' => '($1 {{PLURAL:$1|roce|roci}})',
	'toplists-weeks' => '$1 {{PLURAL: $1|hefte|heftey}}',
	'toplists-create-button-msg' => 'Liste vırazê',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'toplists-error-title-spam' => 'The supplied text contains some words recognised as spam.',
);

/** Spanish (español)
 * @author Bola
 * @author Peter17
 * @author VegaDark
 */
$messages['es'] = array(
	'toplists-desc' => 'Los 10 mejores',
	'right-toplists-create-edit-list' => 'Crea y edita páginas de los 10 mejores',
	'right-toplists-create-item' => 'Crea y añade elementos a una página de los 10 mejores',
	'right-toplists-edit-item' => 'Editar elementos de una lista',
	'right-toplists-delete-item' => 'Borrar elementos de una lista',
	'createtoplist' => 'Crea una nueva lista de los 10 mejores',
	'edittoplist' => 'Editar los 10 mejores',
	'toplists-category' => 'Los 10 mejores',
	'toplists-error-invalid-title' => 'El texto especificado no es válido.',
	'toplists-error-invalid-picture' => 'La imagen seleccionada no es válida.',
	'toplists-error-title-exists' => 'La página ya existe. Puedes ir a <a href="$2" target="_blank">$1</a> o proporciona un nombre diferente.',
	'toplists-error-title-spam' => 'El texto especificado contiene algunas palabras identificadas como spam.',
	'toplists-error-article-blocked' => 'No estás autorizado para crear una página con este nombre. Lo sentimos.',
	'toplists-error-article-not-exists' => '"$1" no existe. ¿Quieres <a href="$2" target="_blank">crearla</a>?',
	'toplists-error-picture-not-exists' => '"$1" no existe. ¿Quieres <a href="$2" target="_blank">subirla</a>?',
	'toplists-error-duplicated-entry' => 'No puedes usar el mismo nombre más de una vez.',
	'toplists-error-empty-item-name' => 'El nombre de un elemento existente no puede estar vacío.',
	'toplists-item-cannot-delete' => 'Falló el borrado de este elemento.',
	'toplists-error-image-already-exists' => 'Ya existe una imagen con el mismo nombre.',
	'toplists-error-add-item-anon' => 'Los usuarios anónimos no están autorizados para añadir elementos a las listas. Por favor <a class="ajaxLogin" id="login" href="$1">inicia sesión</a> o <a href="$2">registra una cuenta nueva</a>.',
	'toplists-error-add-item-permission' => 'Error de permisos: No se ha concedido el derecho a tu cuenta para crear nuevos elementos.',
	'toplists-error-add-item-list-not-exists' => 'Los 10 mejores "$1" no existe.',
	'toplists-upload-error-unknown' => 'Ha ocurrido un error mientras procesábamos tu petición de subida. Por favor, inténtalo de nuevo.',
	'action-toplists-create-edit-list' => 'Crea y edita páginas Top 10',
	'toplists-editor-title-label' => 'Nombre de la lista',
	'toplists-editor-title-placeholder' => 'Introduce un nombre para la lista',
	'toplists-editor-related-article-label' => 'Página relacionada <small>(opcional, pero selecciona una imagen)</small>',
	'toplists-editor-related-article-placeholder' => 'Escribe el nombre de una página existente',
	'toplists-editor-description-label' => 'Añade una breve descripción de tu lista Top 10',
	'toplists-editor-description-placeholder' => 'Introduce una descripción',
	'toplists-editor-image-browser-tooltip' => 'Añade una imagen',
	'toplists-editor-remove-item-tooltip' => 'Eliminar el elemento',
	'toplists-editor-drag-item-tooltip' => 'Arrastra para cambiar el orden',
	'toplists-editor-add-item-label' => 'Añade un nuevo elemento',
	'toplists-editor-add-item-tooltip' => 'Añade un nuevo elemento a la lista',
	'toplists-create-button' => 'Crear una lista',
	'toplists-update-button' => 'Guardar lista',
	'toplists-cancel-button' => 'Cancelar',
	'toplists-items-removed' => '$1 {{PLURAL:$1|elemento borrado|elementos borrados}}',
	'toplists-items-created' => '$1 {{PLURAL:$1|elemento creado|elementos creados}}',
	'toplists-items-updated' => '$1 {{PLURAL:$1|elemento actualizado|elementos actualizados}}',
	'toplists-items-nochange' => 'No hay elementos modificados',
	'toplits-image-browser-no-picture-selected' => 'Ninguna imagen seleccionada',
	'toplits-image-browser-clear-picture' => 'Borrar imagen',
	'toplits-image-browser-selected-picture' => 'Actualmente seleccionado: $1',
	'toplists-image-browser-upload-btn' => 'Escoge',
	'toplists-image-browser-upload-label' => 'Sube tu propio',
	'toplists-list-creation-summary' => 'Creando una lista, $1',
	'toplists-list-update-summary' => 'Actualizando una lista, $1',
	'toplists-item-creation-summary' => 'Creando un elemento de una lista',
	'toplists-item-update-summary' => 'Actualizando un elemento de una lista',
	'toplists-item-remove-summary' => 'Elemento borrado de la lista',
	'toplists-item-restored' => 'Elemento restaurado',
	'toplists-list-related-to' => 'Relacionado con:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />voto|$1<br />votos}}',
	'toplists-list-created-by' => 'por el usuario [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Votar',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|voto|votos}} en $2',
	'toplists-list-add-item-label' => 'Añadir elemento',
	'toplists-list-add-item-name-label' => 'Mantener la lista en curso...',
	'toplists-list-item-voted' => 'Votado',
	'toplists-createpage-dialog-label' => 'Lista de los 10 mejores',
	'toplists-email-subject' => 'Una lista de los 10 mejores ha sido modificada',
	'toplists-email-body' => '¡Hola desde Wikia!

La lista <a href="$1">$2</a> en Wikia ha sido modificada.

 $3

¡Dirígete a Wikia para ver los cambios!

- Wikia

Puedes <a href="$4">cancelar</a>  tu subscripción de los cambios a la lista.',
	'toplists-seconds' => '$1 {{PLURAL:$1|segundo|segundos}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuto|minutos}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hora|horas}}',
	'toplists-days' => '$1 {{PLURAL:$1|dia|dias}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|semana|semanas}}',
	'toplists-msg-fb-OnRateArticle-short' => 'ha votado en una lista en $WIKINAME!',
	'toplists-create-heading' => '<em>¡Nuevo!</em> Crea tus 10 mejores',
	'toplists-create-button-msg' => 'Crear una lista',
	'toplists-oasis-only' => 'La creación y edición de las listas "Top 10" no está disponible en Monobook. Si deseas utilizar esta función, cambia tus preferencias a la piel Wikia.',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'toplists-editor-title-label' => 'نام فهرست',
	'toplists-editor-remove-item-tooltip' => 'حذف مورد',
	'toplists-create-button' => 'ایجاد فهرست',
	'toplists-update-button' => 'ذخیره فهرست',
	'toplists-cancel-button' => 'لغو',
	'toplists-image-browser-upload-btn' => 'انتخاب',
);

/** Finnish (suomi)
 * @author Centerlink
 * @author Ilkea
 * @author Nike
 */
$messages['fi'] = array(
	'toplists-desc' => 'Top 10 -luettelot',
	'right-toplists-create-edit-list' => 'Luo ja muokkaa Top 10 -luettelosivuja',
	'right-toplists-create-item' => 'Luo ja lisää kohteita Top 10 -luettelosivulle',
	'right-toplists-edit-item' => 'Muokkaa kohtia top-10 lista sivulla',
	'right-toplists-delete-item' => 'Poista kohdat top-10 lista sivulta',
	'createtoplist' => 'Luo uusi Top 10 -luettelo',
	'edittoplist' => 'Muokkaa Top 10 -luetteloa',
	'toplists-category' => 'Top 10 -luettelot',
	'toplists-error-invalid-title' => 'Teksti ei kelpaa.',
	'toplists-error-invalid-picture' => 'Valittu kuva ei kelpaa.',
	'toplists-error-title-exists' => 'Tämä sivu on jo olemassa. Voit siirtyä kohteeseen <a href="$2" target="_blank">$1</a> tai tarjota eri nimen.',
	'toplists-error-title-spam' => 'Teksti sisältää ilmaisuja, jotka luokitellaan roskapostiksi.',
	'toplists-error-article-blocked' => 'Et voi valitettavasti luoda tämän nimistä sivu.',
	'toplists-error-article-not-exists' => 'Sivua ”$1” ei ole olemassa. Haluatko <a href="$2" target="_blank">luoda sen</a>?',
	'toplists-error-picture-not-exists' => 'Kuvaa ”$1” ei ole olemassa. Haluatko <a href="$2" target="_blank">tallentaa sellaisen</a>?',
	'toplists-error-duplicated-entry' => 'Voit käyttää samaa nimeä vain kerran.',
	'toplists-error-empty-item-name' => 'Olemassaolevan kohteen nimi ei voi olla tyhjä.',
	'toplists-item-cannot-delete' => 'Tämän kohteen poistaminen epäonnistui.',
	'toplists-error-image-already-exists' => 'Samanniminen kuva on jo olemassa.',
	'toplists-error-add-item-anon' => 'Anonyymit käyttäjät eivät voi lisätä kohteita luetteloihin. Ole hyvä ja <a class="ajaxLogin" id="login" href="$1">kirjaudu sisään</a> tai <a href="$2">rekisteröi uusi tunnus</a>.',
	'toplists-error-add-item-permission' => 'Käyttöoikeusvirhe: Tilille ei ole myönnetty oikeutta luoda uusia kohteita.',
	'toplists-error-add-item-list-not-exists' => 'Top10-listaa $1 ei ole olemassa.',
	'toplists-upload-error-unknown' => 'Tapahtui virhe lataus prosessissa. Yritä uudestaan.',
	'toplists-editor-title-label' => 'Luettelonimi',
	'toplists-editor-title-placeholder' => 'Kirjoita luettelon nimi',
	'toplists-editor-related-article-label' => 'Liittyvä sivu <small>(valinnainen, mutta valitsee kuvan)</small>',
	'toplists-editor-related-article-placeholder' => 'Anna olemassa olevan sivun nimi',
	'toplists-editor-image-browser-tooltip' => 'Lisää kuva',
	'toplists-editor-remove-item-tooltip' => 'Poista kohde',
	'toplists-editor-drag-item-tooltip' => 'Voit muuttaa järjestystä vetämällä',
	'toplists-editor-add-item-label' => 'Lisää uusi kohde',
	'toplists-editor-add-item-tooltip' => 'Lisää uusi kohde luetteloon',
	'toplists-create-button' => 'Luo luettelo',
	'toplists-update-button' => 'Tallenna luettelo',
	'toplists-cancel-button' => 'Peruuta',
	'toplists-items-removed' => '$1 {{PLURAL:$1|kohde|kohdetta}} poistettu',
	'toplists-items-created' => '$1 {{PLURAL:$1|kohde|kohdetta}} luotu',
	'toplists-items-updated' => '$1 {{PLURAL:$1|kohde|kohdetta}} päivitetty',
	'toplists-items-nochange' => 'Ei muuttuneita kohteita',
	'toplits-image-browser-no-picture-selected' => 'Ei kuvaa valittuna',
	'toplits-image-browser-clear-picture' => 'Tyhjennä kuva',
	'toplits-image-browser-selected-picture' => 'Tällä hetkellä valittuna: $1',
	'toplists-image-browser-upload-btn' => 'Valitse',
	'toplists-image-browser-upload-label' => 'Lähetä oma',
	'toplists-list-creation-summary' => 'Luodaan luetteloa, $1',
	'toplists-list-update-summary' => 'Päivitetään luetteloa, $1',
	'toplists-item-creation-summary' => 'Luodaan luettelokohde',
	'toplists-item-update-summary' => 'Päivitetään luettelokohde',
	'toplists-item-remove-summary' => 'Kohde poistettu luettelosta',
	'toplists-item-restored' => 'Kohde palautettu',
	'toplists-list-related-to' => 'Liittyy kohteeseen:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />ääni|$1<br />ääntä}}',
	'toplists-list-created-by' => ': [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Kannatusääni',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|ääni|ääntä}} kohteessa $2',
	'toplists-list-add-item-label' => 'Lisää kohde',
	'toplists-list-add-item-name-label' => 'Pidä luettelo käynnissä...',
	'toplists-list-item-voted' => 'Äänestetty',
	'toplists-createpage-dialog-label' => 'Top10-lista',
	'toplists-email-subject' => 'Top10-lista on muuttunut',
	'toplists-email-body' => 'Hei Wikiasta!

Luettelo <a href="$1">$2</a> Wikiassa on muuttunut.

 $3

Suuntaa Wikiaan muutosten tarkistamiseksi! $1

- Wikia

Voit <a href="$4">perua päivitykset</a> luettelon muutoksista.',
	'toplists-seconds' => '$1 {{PLURAL:$1|sekunti|sekuntia}} sitten',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuutti|minuuttia}} sitten',
	'toplists-hours' => '$1 {{PLURAL:$1|tunti|tuntia}} sitten',
	'toplists-days' => '$1 {{PLURAL:$1|päivä|päivää}} sitten',
	'toplists-weeks' => '$1 {{PLURAL:$1|viikko|viikkoa}} sitten',
	'toplists-msg-fb-OnRateArticle-short' => 'on äänestänyt Top10-listaa wikissä $WIKINAME!',
	'toplists-create-heading' => '<em>Uutta!</em> Luo oma top-10',
	'toplists-create-button-msg' => 'Luo lista',
);

/** French (français)
 * @author Boniface
 * @author Gomoko
 * @author Jean-Frédéric
 * @author McDutchie
 * @author Peter17
 * @author Verdy p
 * @author Wyz
 */
$messages['fr'] = array(
	'toplists-desc' => 'Listes de top 10',
	'right-toplists-create-edit-list' => 'Créer et modifier des pages de liste de top 10',
	'right-toplists-create-item' => 'Créer et ajouter des éléments à une page de liste de top 10',
	'right-toplists-edit-item' => 'Modifier les éléments dans une page de liste de top 10',
	'right-toplists-delete-item' => 'Supprimer les éléments dans une page de liste de top 10',
	'createtoplist' => 'Créer une nouvelle liste de top 10',
	'edittoplist' => 'Modifier une liste de top 10',
	'toplists-category' => 'Listes de top 10',
	'toplists-error-invalid-title' => 'Le texte fourni n’est pas valide.',
	'toplists-error-invalid-picture' => 'L’image sélectionnée n’est pas valide.',
	'toplists-error-title-exists' => 'Cette page existe déjà. Vous pouvez aller à <a href="$2" target="_blank">$1</a> ou fournir un nom différent.',
	'toplists-error-title-spam' => 'Le texte fourni contient quelques mots reconnus comme indésirables.',
	'toplists-error-article-blocked' => 'Vous n’êtes pas autorisé à créer une page avec ce nom. Désolé.',
	'toplists-error-article-not-exists' => 'L’article « $1 » n’existe pas. Voulez-vous <a href="$2" target="_blank">le créer</a> ?',
	'toplists-error-picture-not-exists' => 'Le fichier « $1 » n’existe pas. Voulez-vous <a href="$2" target="_blank">le téléverser</a> ?',
	'toplists-error-duplicated-entry' => 'Vous ne pouvez pas utiliser le même nom plus d’une fois.',
	'toplists-error-empty-item-name' => 'Le nom d’un élément existant ne peut pas être vide.',
	'toplists-item-cannot-delete' => 'La suppression de cet élément a échoué.',
	'toplists-error-image-already-exists' => 'Une image existe déjà avec le même nom.',
	'toplists-error-add-item-anon' => 'Les utilisateurs anonymes ne sont pas autorisés à ajouter des éléments aux listes. Veuillez <a class="ajaxLogin" id="login" href="$1">vous connecter</a> ou <a href="$2">vous inscrire avec un nouveau compte</a> .',
	'toplists-error-add-item-permission' => 'Erreur de permission : Votre compte n’a pas les droits pour créer de nouveaux éléments.',
	'toplists-error-add-item-list-not-exists' => 'La liste de top 10 « $1 » n’existe pas.',
	'toplists-upload-error-unknown' => 'Une erreur s’est produite lors du traitement de la demande d’import. Veuillez réessayer.',
	'action-toplists-create-edit-list' => 'créer et modifier des pages de liste de top 10',
	'toplists-editor-title-label' => 'Nom de la liste',
	'toplists-editor-title-placeholder' => 'Saisissez un nom pour la liste',
	'toplists-editor-related-article-label' => 'Page connexe <small>(optionnel, mais définit une image)</small>',
	'toplists-editor-related-article-placeholder' => 'Saisissez un nom de page existante',
	'toplists-editor-description-label' => 'Une courte description de votre liste de Top 10',
	'toplists-editor-description-placeholder' => 'Entrez une description',
	'toplists-editor-image-browser-tooltip' => 'Ajouter une image',
	'toplists-editor-remove-item-tooltip' => 'Retirer l’élément',
	'toplists-editor-drag-item-tooltip' => 'Faites glisser pour changer l’ordre',
	'toplists-editor-add-item-label' => 'Ajouter un nouvel élément',
	'toplists-editor-add-item-tooltip' => 'Ajouter un nouvel élément à la liste',
	'toplists-create-button' => 'Créer une liste',
	'toplists-update-button' => 'Enregistrer la liste',
	'toplists-cancel-button' => 'Annuler',
	'toplists-items-removed' => '{{PLURAL:$1|Un élément supprimé|$1 éléments supprimés}}',
	'toplists-items-created' => '{{PLURAL:$1|Un élément créé|$1 éléments créés}}',
	'toplists-items-updated' => '{{PLURAL:$1|Un élément|$1 éléments}} mis à jour',
	'toplists-items-nochange' => 'Aucun élément modifié',
	'toplits-image-browser-no-picture-selected' => 'Aucune image sélectionnée',
	'toplits-image-browser-clear-picture' => 'Effacer l’image',
	'toplits-image-browser-selected-picture' => 'Image actuellement sélectionnée : $1',
	'toplists-image-browser-upload-btn' => 'Choisir',
	'toplists-image-browser-upload-label' => 'Téléversez la vôtre',
	'toplists-list-creation-summary' => 'Création d’une liste, $1',
	'toplists-list-update-summary' => 'Mise à jour d’une liste, $1',
	'toplists-item-creation-summary' => 'Création d’un élément de liste',
	'toplists-item-update-summary' => 'Mise à jour d’un élément de liste',
	'toplists-item-remove-summary' => 'Élément retiré de la liste',
	'toplists-item-restored' => 'Élément restauré',
	'toplists-list-related-to' => 'Relatif à :',
	'toplists-list-votes-num' => '{{PLURAL:$1|un<br />vote|$1<br />votes}}',
	'toplists-list-created-by' => 'par [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Voter pour',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|vote|votes}} en $2',
	'toplists-list-add-item-label' => 'Ajouter un élément',
	'toplists-list-add-item-name-label' => 'Continuer la liste...',
	'toplists-list-item-voted' => 'Voté',
	'toplists-createpage-dialog-label' => 'Liste de top 10',
	'toplists-email-subject' => 'Une liste de top 10 a été modifiée',
	'toplists-email-body' => 'Bonjour de Wikia !

La liste <a href="$1">$2</a> sur Wikia a été modifiée.

 $3

Rendez-vous sur Wikia pour vérifier les modifications ! $1

- Wikia

Vous pouvez <a href="$4">vous désinscrire</a> des modifications de cette liste.',
	'toplists-seconds' => '$1 seconde{{PLURAL:$1||s}}',
	'toplists-minutes' => '$1 minute{{PLURAL:$1||s}}',
	'toplists-hours' => '$1 heure{{PLURAL:$1||s}}',
	'toplists-days' => '$1 jour{{PLURAL:$1||s}}',
	'toplists-weeks' => '$1 semaine{{PLURAL:$1||s}}',
	'toplists-msg-fb-OnRateArticle-short' => 'a voté sur une liste de top 10 sur $WIKINAME !',
	'toplists-create-heading' => '<em>Nouveau !</em> Créez votre propre top dix',
	'toplists-create-button-msg' => 'Créer une liste',
	'toplists-oasis-only' => "Créer et modifier les listes Top 10 n'est pas possible dans Monobook. Si vous désirez utiliser cette fonctionnalité, changez plutôt votre préférence pour l'apparence Wikia.",
);

/** Galician (galego)
 * @author Toliño
 * @author Xanocebreiro
 */
$messages['gl'] = array(
	'toplists-desc' => 'Os 10 mellores',
	'right-toplists-create-edit-list' => 'Crear e editar as páxinas dos 10 mellores',
	'right-toplists-create-item' => 'Crear e engadir elementos nas páxinas dos 10 mellores',
	'right-toplists-edit-item' => 'Editar os elementos dunha páxina dos 10 mellores',
	'right-toplists-delete-item' => 'Borrar os elementos dunha páxina dos 10 mellores',
	'createtoplist' => 'Crear unha nova lista dos 10 mellores',
	'edittoplist' => 'Editar os 10 mellores',
	'toplists-category' => 'Os 10 mellores',
	'toplists-error-invalid-title' => 'O texto especificado non é válido.',
	'toplists-error-invalid-picture' => 'A imaxe seleccionada non é válida.',
	'toplists-error-title-exists' => 'Esta páxina xa existe. Pode ir a <a href="$2" target="_blank">$1</a> ou proporcionar un nome diferente.',
	'toplists-error-title-spam' => 'O texto especificado contén algunhas palabras identificadas como spam.',
	'toplists-error-article-blocked' => 'Non ten permiso para crear unha páxina con ese nome. Sentímolo.',
	'toplists-error-article-not-exists' => '"$1" non existe. Quere <a href="$2" target="_blank">crealo</a>?',
	'toplists-error-picture-not-exists' => '"$1" non existe. Quere <a href="$2" target="_blank">cargala</a>?',
	'toplists-error-duplicated-entry' => 'Non pode usar o mesmo nome máis dunha vez.',
	'toplists-error-empty-item-name' => 'O nome dun elemento existente non pode estar baleiro.',
	'toplists-item-cannot-delete' => 'Houbo un erro ao borrar este elemento.',
	'toplists-error-image-already-exists' => 'Xa existe unha imaxe co mesmo nome.',
	'toplists-error-add-item-anon' => 'Aos usuarios anónimos non se lles permite engadir elementos ás listas. <a class="ajaxLogin" id="login" href="$1">Acceda ao sistema</a> ou <a href="$2">rexistre unha nova conta</a>.',
	'toplists-error-add-item-permission' => 'Erro de permisos: A súa conta non ten os dereitos necesarios para crear novos elementos.',
	'toplists-error-add-item-list-not-exists' => 'A lista dos 10 mellores "$1" non existe.',
	'toplists-upload-error-unknown' => 'Houbo un erro ao procesar a petición de subida. Inténteo de novo.',
	'action-toplists-create-edit-list' => 'crear e editar as páxinas dos 10 mellores',
	'toplists-editor-title-label' => 'Nome da lista',
	'toplists-editor-title-placeholder' => 'Escriba un nome para a lista',
	'toplists-editor-related-article-label' => 'Páxina relacionada <small>(opcional, pero selecciona unha imaxe)</small>',
	'toplists-editor-related-article-placeholder' => 'Introduza un nome de páxina existente',
	'toplists-editor-description-label' => 'Unha breve descrición da súa lista dos 10 mellores',
	'toplists-editor-description-placeholder' => 'Escriba unha descrición',
	'toplists-editor-image-browser-tooltip' => 'Engadir unha imaxe',
	'toplists-editor-remove-item-tooltip' => 'Eliminar o elemento',
	'toplists-editor-drag-item-tooltip' => 'Arrastre para cambiar a orde',
	'toplists-editor-add-item-label' => 'Engadir un elemento novo',
	'toplists-editor-add-item-tooltip' => 'Engadir un elemento novo á lista',
	'toplists-create-button' => 'Crear unha lista',
	'toplists-update-button' => 'Gardar a lista',
	'toplists-cancel-button' => 'Cancelar',
	'toplists-items-removed' => '$1 {{PLURAL:$1|elemento eliminado|elementos eliminados}}',
	'toplists-items-created' => '$1 {{PLURAL:$1|elemento creado|elementos creados}}',
	'toplists-items-updated' => '$1 {{PLURAL:$1|elemento actualizado|elementos actualizados}}',
	'toplists-items-nochange' => 'Non se cambiou ningún elemento',
	'toplits-image-browser-no-picture-selected' => 'Non se seleccionou ningunha imaxe',
	'toplits-image-browser-clear-picture' => 'Borrar a imaxe',
	'toplits-image-browser-selected-picture' => 'Selección actual: $1',
	'toplists-image-browser-upload-btn' => 'Elixir',
	'toplists-image-browser-upload-label' => 'Cargar a súa',
	'toplists-list-creation-summary' => 'Creando unha lista, $1',
	'toplists-list-update-summary' => 'Actualizando unha lista, $1',
	'toplists-item-creation-summary' => 'Creando un elemento da lista',
	'toplists-item-update-summary' => 'Actualizando un elemento da lista',
	'toplists-item-remove-summary' => 'Elemento eliminado da lista',
	'toplists-item-restored' => 'Elemento restaurado',
	'toplists-list-related-to' => 'Relacionado con:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />voto|$1<br />votos}}',
	'toplists-list-created-by' => 'por [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Votar positivamente',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|voto|votos}} en $2',
	'toplists-list-add-item-label' => 'Engadir un elemento',
	'toplists-list-add-item-name-label' => 'Continuar a lista...',
	'toplists-list-item-voted' => 'Votado',
	'toplists-createpage-dialog-label' => 'Os 10 mellores',
	'toplists-email-subject' => 'Cambiouse unha lista dos 10 mellores',
	'toplists-email-body' => 'Ola de parte de Wikia!

A lista <a href="$1">$2</a> de Wikia sufriu modificacións.

 $3

Diríxase a Wikia para ollar os cambios! $1

- Wikia

Pode <a href="$4">cancelar a subscrición</a> dos cambios feitos na lista.',
	'toplists-seconds' => '$1 {{PLURAL:$1|segundo|segundos}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuto|minutos}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hora|horas}}',
	'toplists-days' => '$1 {{PLURAL:$1|día|días}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|semana|semanas}}',
	'toplists-msg-fb-OnRateArticle-short' => 'votou nunha lista dos 10 mellores en $WIKINAME!',
	'toplists-create-heading' => '<em>Novo!</em> Cree a súa propia lista dos 10 mellores',
	'toplists-create-button-msg' => 'Crear unha lista',
	'toplists-oasis-only' => 'A creación e edición das listas dos 10 mellores non está dispoñible en Monobook. Se quere facer uso desta característica, cambie á aparencia de Wikia nas preferencias.',
);

/** Hungarian (magyar)
 * @author TK-999
 */
$messages['hu'] = array(
	'toplists-desc' => 'Top 10-es lista',
	'right-toplists-create-edit-list' => 'Top 10-es lista létrehozása és szerkesztése',
	'right-toplists-create-item' => 'Top 10-es lista létrehozása és elemek hozzáadása',
	'right-toplists-edit-item' => 'Top 10-es lista elemeinek szerkesztése',
	'right-toplists-delete-item' => 'Top 10-es lista elemeinek törlése',
	'createtoplist' => 'Új Top 10-es lista létrehozása',
	'edittoplist' => 'Top 10-es lista szerkesztése',
	'toplists-category' => 'Top 10-es listák',
	'toplists-error-invalid-title' => 'A megadott szöveg érvénytelen.',
	'toplists-error-invalid-picture' => 'A megadott kép érvénytelen.',
	'toplists-error-title-exists' => 'Ez a lap már létezik. Ugrás a <a href="$2" target="_blank">$1</a> vagy adj meg másik nevet.',
	'toplists-error-title-spam' => 'A megadott szöveg spam szavakat tartalmaz.',
	'toplists-error-article-blocked' => 'Ilyen nevű lapot nem hozhat létre. Bocsánat.',
	'toplists-error-article-not-exists' => '"$ 1" nem létezik. <a href="$2" target="_blank">Létre kívánja hozni</a>?',
	'toplists-error-picture-not-exists' => '"$ 1" nem létezik. Szeretné <a href="$2" target="_blank">feltölteni</a>?',
	'toplists-error-duplicated-entry' => 'Többször nem használhatja ugyanazt a nevet.',
	'toplists-error-empty-item-name' => 'Egy létező elem neve nem lehet üres.',
	'toplists-item-cannot-delete' => 'A törlés sikertelen.',
	'toplists-error-image-already-exists' => 'Már létezik kép ezzel a névvel.',
	'toplists-error-add-item-anon' => 'Névtelen felhasználók nem jogosultak elemek hozzáadásához a listákhoz. Kérjük, <a class="ajaxLogin" id="login" href="$1">jelentkezzen be,</a> vagy <a href="$2">regisztráljon</a>.',
	'toplists-error-add-item-permission' => 'Jogosultsági hiba: a felhasználói fiók nem rendelkezik engedéllyel új elemek létrehozásához.',
	'toplists-error-add-item-list-not-exists' => 'A "$ 1" Top 10-es lista nem létezik.',
	'toplists-upload-error-unknown' => 'Hiba történt a feltöltési kérés feldolgozása közben. Kérlek, próbáld újra.',
	'toplists-editor-title-label' => 'A lista neve',
	'toplists-editor-title-placeholder' => 'Írja be a lista nevét',
	'toplists-editor-related-article-label' => 'Kapcsolódó oldal <small>(nem kötelező, de kiválaszt egy képet)</small>',
	'toplists-editor-related-article-placeholder' => 'Adja meg egy létező lap nevét',
	'toplists-editor-description-label' => 'A Top 10-es listád rövid leírása',
	'toplists-editor-description-placeholder' => 'Adj meg egy leírást',
	'toplists-editor-image-browser-tooltip' => 'Kép hozzáadása',
	'toplists-editor-remove-item-tooltip' => 'Az elem törlése',
	'toplists-editor-drag-item-tooltip' => 'A sorrend módosításához húzza át az elemet',
	'toplists-editor-add-item-label' => 'Új elem hozzáadása',
	'toplists-editor-add-item-tooltip' => 'Új elem hozzáadása a listához',
	'toplists-create-button' => 'Lista létrehozása',
	'toplists-update-button' => 'Lista mentése',
	'toplists-cancel-button' => 'Mégse',
	'toplists-items-removed' => '$1 {{PLURAL:$1|elem|elem}} eltávolítva',
	'toplists-items-created' => '$1 {{PLURAL:$1|elem|elem}} létrehozva',
	'toplists-items-updated' => '$1 {{PLURAL:$1|elem|elem}} frissítve',
	'toplists-items-nochange' => 'Az elemek nem módosultak.',
	'toplits-image-browser-no-picture-selected' => 'Nincs kiválasztott kép',
	'toplits-image-browser-clear-picture' => 'Kép eltávolítása',
	'toplits-image-browser-selected-picture' => 'Kijelölve: $1',
	'toplists-image-browser-upload-btn' => 'Válasszon',
	'toplists-image-browser-upload-label' => 'Saját feltöltése',
	'toplists-list-creation-summary' => 'Lista létrehozása, $1',
	'toplists-list-update-summary' => 'Lista frissítése, $1',
	'toplists-item-creation-summary' => 'Listaelem létrehozása',
	'toplists-item-update-summary' => 'Listaelem frissítése',
	'toplists-item-remove-summary' => 'Elem eltávolítva a listáról',
	'toplists-item-restored' => 'Elem visszaállítása',
	'toplists-list-related-to' => 'Kapcsolódik a következő(k)höz:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />szavazat|$1<br />szavazatok}}',
	'toplists-list-created-by' => '[[Felhasználó:$1|$1]] által',
	'toplists-list-vote-up' => 'Szavazás',
	'toplists-list-hotitem-count' => '$1 szavazat a(z) $2-ben',
	'toplists-list-add-item-label' => 'Elem hozzáadása',
	'toplists-list-add-item-name-label' => 'Folytasd a listát&hellip;',
	'toplists-list-item-voted' => 'Szavazat elküldve',
	'toplists-createpage-dialog-label' => 'Top 10-es lista',
	'toplists-email-subject' => 'A Top 10-es lista megváltozott',
	'toplists-seconds' => '$1 másodperc',
	'toplists-minutes' => '$1 perc',
	'toplists-hours' => '$1 óra',
	'toplists-days' => '$1 nap',
	'toplists-weeks' => '$1 hét',
	'toplists-msg-fb-OnRateArticle-short' => 'szavazott egy Top 10-es listán a $WIKINAME-n!',
	'toplists-create-heading' => '<em>Új!</em> Saját Top 10 létrehozása',
	'toplists-create-button-msg' => 'Lista létrehozása',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'toplists-desc' => 'Listas Top 10',
	'right-toplists-create-edit-list' => 'Crear e modificar paginas de lista Top 10',
	'right-toplists-create-item' => 'Crear e adder elementos a un pagina de lista Top 10',
	'right-toplists-edit-item' => 'Modificar elementos in un pagina con lista Top 10',
	'right-toplists-delete-item' => 'Deler elementos de un pagina con lista Top 10',
	'createtoplist' => 'Crear un nove lista Top 10',
	'edittoplist' => 'Modificar lista Top 10',
	'toplists-category' => 'Listas Top 10',
	'toplists-error-invalid-title' => 'Le texto fornite non es valide.',
	'toplists-error-invalid-picture' => 'Le imagine seligite non es valide.',
	'toplists-error-title-exists' => 'Iste pagina existe jam. Tu pote vader a <a href="$2" target="_blank">$1</a> o fornir un altere nomine.',
	'toplists-error-title-spam' => 'Le texto fornite contine alcun parolas recognoscite como spam.',
	'toplists-error-article-blocked' => 'Regrettabilemente, il non es permittite crear un pagina con iste nomine.',
	'toplists-error-article-not-exists' => '"$1" non existe. Vole tu <a href="$2" target="_blank">crear lo</a>?',
	'toplists-error-picture-not-exists' => '"$1" non existe. Vole tu <a href="$2" target="_blank">incargar lo</a>?',
	'toplists-error-duplicated-entry' => 'Tu non pote usar le mesme nomine plus de un vice.',
	'toplists-error-empty-item-name' => 'Le nomine de un elemento existente non pote esser vacue.',
	'toplists-item-cannot-delete' => 'Le deletion de iste elemento ha fallite.',
	'toplists-error-image-already-exists' => 'Un imagine con le mesme nomine jam existe.',
	'toplists-error-add-item-anon' => 'Usatores anonyme non ha le permission de adder elementos a listas. Per favor <a class="ajaxLogin" id="login" href="$1">aperi session</a> o <a href="$2">crea un nove conto</a>.',
	'toplists-error-add-item-permission' => 'Error de permission: Tu conto non ha le derecto de crear nove elementos.',
	'toplists-error-add-item-list-not-exists' => 'Le lista Top 10 "$1" non existe.',
	'toplists-upload-error-unknown' => 'Un error occurreva durante le tractamento del requesta de incargamento, per favor reproba.',
	'action-toplists-create-edit-list' => 'crear e modificar paginas de lista Top 10',
	'toplists-editor-title-label' => 'Nomine del lista',
	'toplists-editor-title-placeholder' => 'Entra un nomine pro le lista',
	'toplists-editor-related-article-label' => 'Pagina connexe <small>(optional, ma selige un imagine)</small>',
	'toplists-editor-related-article-placeholder' => 'Entra le nomine de un pagina existente',
	'toplists-editor-description-label' => 'Un curte description de tu lista Top 10',
	'toplists-editor-description-placeholder' => 'Entra un description',
	'toplists-editor-image-browser-tooltip' => 'Adder un imagine',
	'toplists-editor-remove-item-tooltip' => 'Remover elemento',
	'toplists-editor-drag-item-tooltip' => 'Trahe pro cambiar le ordine',
	'toplists-editor-add-item-label' => 'Adder un nove elemento',
	'toplists-editor-add-item-tooltip' => 'Adder un nove elemento al lista',
	'toplists-create-button' => 'Crear lista',
	'toplists-update-button' => 'Salveguardar lista',
	'toplists-cancel-button' => 'Cancellar',
	'toplists-items-removed' => '$1 {{PLURAL:$1|elemento|elementos}} removite',
	'toplists-items-created' => '$1 {{PLURAL:$1|elemento|elementos}} create',
	'toplists-items-updated' => '$1 {{PLURAL:$1|elemento|elementos}} actualisate',
	'toplists-items-nochange' => 'Nulle elemento cambiate',
	'toplits-image-browser-no-picture-selected' => 'Nulle imagine seligite',
	'toplits-image-browser-clear-picture' => 'Rader imagine',
	'toplits-image-browser-selected-picture' => 'Actualmente seligite: $1',
	'toplists-image-browser-upload-btn' => 'Seliger',
	'toplists-image-browser-upload-label' => 'Incargar un proprie',
	'toplists-list-creation-summary' => 'Crea un lista, $1',
	'toplists-list-update-summary' => 'Actualisa un lista, $1',
	'toplists-item-creation-summary' => 'Crea un elemento de lista',
	'toplists-item-update-summary' => 'Actualisa un elemento de lista',
	'toplists-item-remove-summary' => 'Elemento removite del lista',
	'toplists-item-restored' => 'Elemento restaurate',
	'toplists-list-related-to' => 'Connexe a:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />voto|$1<br />votos}}',
	'toplists-list-created-by' => 'per [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Votar positivemente',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|voto|votos}} in $2',
	'toplists-list-add-item-label' => 'Adder elemento',
	'toplists-list-add-item-name-label' => 'Mantener le lista in marcha...',
	'toplists-list-item-voted' => 'Votate',
	'toplists-createpage-dialog-label' => 'Lista Top 10',
	'toplists-email-subject' => 'Un lista Top 10 ha essite cambiate',
	'toplists-email-body' => 'Salute de Wikia!

Le lista <a href="$1">$2</a> in Wikia ha cambiate.

 $3

Veni a Wikia pro examinar le cambios! $1

- Wikia

Tu pote <a href="$4">cancellar le subscription</a> al cambios in iste lista.',
	'toplists-seconds' => '$1 {{PLURAL:$1|secunda|secundas}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuta|minutas}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hora|horas}}',
	'toplists-days' => '$1 {{PLURAL:$1|die|dies}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|septimana|septimanas}}',
	'toplists-msg-fb-OnRateArticle-short' => 'ha votate in un lista Top 10 in $WIKINAME!',
	'toplists-create-heading' => '<em>Nove!</em> Crea tu proprie top dece',
	'toplists-create-button-msg' => 'Crear un lista',
);

/** Italian (italiano)
 * @author Minerva Titani
 */
$messages['it'] = array(
	'toplists-create-button-msg' => 'Crea una lista',
);

/** Japanese (日本語)
 * @author Tommy6
 */
$messages['ja'] = array(
	'toplists-desc' => '投票リスト',
	'right-toplists-create-edit-list' => '投票リストページの作成および編集',
	'right-toplists-create-item' => '投票リストページでの項目の作成および追加',
	'right-toplists-edit-item' => '投票リストページで項目を編集する',
	'right-toplists-delete-item' => '投票リストページから項目を削除する',
	'createtoplist' => '新しい投票リストを作成する',
	'edittoplist' => '投票リストを編集する',
	'toplists-category' => '投票リスト',
	'toplists-error-invalid-title' => '入力されたテキストが適切ではありません。',
	'toplists-error-invalid-picture' => '選択した画像が適切ではありません。',
	'toplists-error-title-exists' => 'このページは既に存在します。<a href="$2" target="_blank">$1</a> を編集するか、他の名称を入力してください。',
	'toplists-error-title-spam' => 'スパムの可能性があると判断されたテキストが含まれています。',
	'toplists-error-article-blocked' => 'この名称のページは作成できません。',
	'toplists-error-article-not-exists' => '「$1」は存在しません。<a href="$2" target="_blank">作成</a>しますか？',
	'toplists-error-picture-not-exists' => '「$1」は存在しません。<a href="$2" target="_blank">アップロード</a>しますか？',
	'toplists-error-duplicated-entry' => '名称を重複させることはできません。',
	'toplists-error-empty-item-name' => '項目名は空欄にできません。',
	'toplists-item-cannot-delete' => '項目の削除に失敗しました。',
	'toplists-error-image-already-exists' => '同名の画像が既にあります。',
	'toplists-error-add-item-anon' => '未登録利用者はリストへ項目を追加できません。<a class="ajaxLogin" id="login" href="$1">ログイン</a>するか<a href="$2">アカウントを作成</a>してください。',
	'toplists-error-add-item-permission' => '権限エラー: 新しい項目を作成する権限がありません。',
	'toplists-error-add-item-list-not-exists' => '投票リスト「$1」は存在しません。',
	'toplists-upload-error-unknown' => 'アップロード処理中にエラーが発生しました。もう一度お試しください。',
	'toplists-editor-title-label' => 'リスト名',
	'toplists-editor-title-placeholder' => 'リスト名を入力',
	'toplists-editor-related-article-label' => '関連ページ<small>（オプション）</small>',
	'toplists-editor-related-article-placeholder' => '既にあるページの名称を入力',
	'toplists-editor-description-label' => '投票リストに関する短い解説',
	'toplists-editor-description-placeholder' => '解説を入力',
	'toplists-editor-image-browser-tooltip' => '画像を追加',
	'toplists-editor-remove-item-tooltip' => '項目を削除',
	'toplists-editor-drag-item-tooltip' => 'ドラッグして順番を変更',
	'toplists-editor-add-item-label' => '新しい項目を追加',
	'toplists-editor-add-item-tooltip' => '新しい項目をリストに追加',
	'toplists-create-button' => 'リストを作成',
	'toplists-update-button' => 'リストを保存',
	'toplists-cancel-button' => '中止',
	'toplists-items-removed' => '$1項目を削除',
	'toplists-items-created' => '$1項目を作成',
	'toplists-items-updated' => '$1項目を編集',
	'toplists-items-nochange' => '項目への変更無し',
	'toplits-image-browser-no-picture-selected' => '画像は選択されていません',
	'toplits-image-browser-clear-picture' => '画像を外す',
	'toplits-image-browser-selected-picture' => '現在選択している画像: $1',
	'toplists-image-browser-upload-btn' => '選択',
	'toplists-image-browser-upload-label' => '画像をアップロード',
	'toplists-list-creation-summary' => 'リストを作成「$1」',
	'toplists-list-update-summary' => 'リストを編集「$1」',
	'toplists-item-creation-summary' => 'リストの項目を作成',
	'toplists-item-update-summary' => 'リストの項目を編集',
	'toplists-item-remove-summary' => 'リストから項目を復帰',
	'toplists-item-restored' => '項目を復帰',
	'toplists-list-related-to' => '関連ページ:',
	'toplists-list-votes-num' => '$1<br />票',
	'toplists-list-created-by' => 'by [[User:$1|$1]]',
	'toplists-list-vote-up' => '投票する',
	'toplists-list-hotitem-count' => '$2 票中 $1 票',
	'toplists-list-add-item-label' => '項目を追加',
	'toplists-list-add-item-name-label' => '項目名を入力',
	'toplists-list-item-voted' => '投票済',
	'toplists-createpage-dialog-label' => '投票リスト',
	'toplists-email-subject' => '投票リストが変更されました',
	'toplists-email-body' => 'リスト「<a href="$1">$2</a>」が変更されました。

 $3

以下で変更点を確認できます。

$1

- Wikia

通知についての設定の変更は <a href="$4">$4</a> で行えます。',
	'toplists-seconds' => '$1秒',
	'toplists-minutes' => '$1分',
	'toplists-hours' => '$1時間',
	'toplists-days' => '$1日',
	'toplists-weeks' => '$1週間',
	'toplists-msg-fb-OnRateArticle-short' => 'さんが $WIKINAME の投票リストで投票しました。',
	'toplists-create-heading' => '新しいリストを作成する',
	'toplists-create-button-msg' => 'リストを作成',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'toplists-desc' => 'Leßte met de bövverste Zehn.',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'toplists-editor-title-label' => 'Navê lîstê',
	'toplists-cancel-button' => 'Betal bike',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'toplists-editor-title-label' => 'Numm vun der Lëscht',
	'toplists-seconds' => '$1 {{PLURAL:$1|Sekonn|Sekonnen}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|Minutt|Minutten}}',
	'toplists-hours' => '$1 {{PLURAL:$1|Stonn|Stonnen}}',
	'toplists-days' => '$1 {{PLURAL:$1|Dag|Deeg}}',
	'toplists-weeks' => '$1 {{PLURAL: $1|Woch|Wochen}}',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'toplists-desc' => 'Списоци на 10 предводници',
	'right-toplists-create-edit-list' => 'Создајте или уредете страници списокот на 10 предводници',
	'right-toplists-create-item' => 'Создавајте и додавајте ставки на списокот на 10 предводници',
	'right-toplists-edit-item' => 'Уреди ставки на страницата „10 најкотирани“',
	'right-toplists-delete-item' => 'Избриши ставки на страницата „10 најкотирани“',
	'createtoplist' => 'Создај нов список на 10 предводници',
	'edittoplist' => 'Уреди список на 10 предводници',
	'toplists-category' => 'Списоци на 10 предводници',
	'toplists-error-invalid-title' => 'Дадениот текст е неважечки',
	'toplists-error-invalid-picture' => 'Одбраната слика не е важечка',
	'toplists-error-title-exists' => 'Статијава веќе постои. Можете да појдете на <a href="$2" target="_blank">$1</a> или да дадете друго име',
	'toplists-error-title-spam' => 'Дадениот текст содржи извесни зборови што се сметаат за спам',
	'toplists-error-article-blocked' => 'Нажалост, не ви е дозволено да создадете статија со ова име',
	'toplists-error-article-not-exists' => '„$1“ не постои., Дали сакате да ја <a href="$2" target="_blank">создадете</a>?',
	'toplists-error-picture-not-exists' => '„$1“ не постои. Дали сакате да ја <a href="$2" target="_blank">подигнете</a>?',
	'toplists-error-duplicated-entry' => 'Истото име не може да се користи повеќе од еднаш',
	'toplists-error-empty-item-name' => 'Името на постоечка ставка не може да стои празно',
	'toplists-item-cannot-delete' => 'Бришењето на ставката не успеа',
	'toplists-error-image-already-exists' => 'ВБеќе постои слика со истото име',
	'toplists-error-add-item-anon' => 'Анонимните корисници не можат да додаваат ставки на списокот. <a class="ajaxLogin" id="login" href="$1">Најавете се</a> или <a href="$2">регистрирајте сметка</a>.',
	'toplists-error-add-item-permission' => 'Грешка во дозволите. Вашата сметка нема добиено право за создавање на нови ставки.',
	'toplists-error-add-item-list-not-exists' => 'Не постои список на 10 предводници со наслов „$1“.',
	'toplists-upload-error-unknown' => 'Се појави грешка при обработката на барањето за подигање. Обидете се повторно.',
	'action-toplists-create-edit-list' => 'создајте или уредете страници списокот на 10 предводници',
	'toplists-editor-title-label' => 'Презиме',
	'toplists-editor-title-placeholder' => 'Внесете име на списокот',
	'toplists-editor-related-article-label' => 'Поврзана страница <small>(по избор, но одбира слика)</small>',
	'toplists-editor-related-article-placeholder' => 'Внесете име на постоечка статија',
	'toplists-editor-description-label' => 'Краток опис на вашиот Список на 10 предводници',
	'toplists-editor-description-placeholder' => 'Внесете опис',
	'toplists-editor-image-browser-tooltip' => 'Додај слика',
	'toplists-editor-remove-item-tooltip' => 'Отстрани ставка',
	'toplists-editor-drag-item-tooltip' => 'Влечете за промена на редоследот',
	'toplists-editor-add-item-label' => 'Додај нова ставка',
	'toplists-editor-add-item-tooltip' => 'Додај нова ставка во списокот',
	'toplists-create-button' => 'Создај список',
	'toplists-update-button' => 'Зачувај список',
	'toplists-cancel-button' => 'Откажи',
	'toplists-items-removed' => '{{PLURAL:$1|Отстранета е $1 ставка|Отстранети се $1 ставки}}',
	'toplists-items-created' => '{{PLURAL:$1|Создадена е $1 ставка|Создадени се $1 ставки}}',
	'toplists-items-updated' => '{{PLURAL:$1|Подновена е $1 ставка|Подновени се $1 ставки}}',
	'toplists-items-nochange' => 'Нема изменети ставки',
	'toplits-image-browser-no-picture-selected' => 'Нема одбрано слика',
	'toplits-image-browser-clear-picture' => 'Исчисти слика',
	'toplits-image-browser-selected-picture' => 'Моментално одбрана: $1',
	'toplists-image-browser-upload-btn' => 'Одбери',
	'toplists-image-browser-upload-label' => 'Подигнете своја',
	'toplists-list-creation-summary' => 'Создавање на спиок, $1',
	'toplists-list-update-summary' => 'Поднова на список, $1',
	'toplists-item-creation-summary' => 'Создавање на ставка во список',
	'toplists-item-update-summary' => 'Поднова на ставка во список',
	'toplists-item-remove-summary' => 'Отстранета ставка од список',
	'toplists-item-restored' => 'Ставката е повратена',
	'toplists-list-related-to' => 'Поврзано со:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br/ >глас|$1<br/ >гласа}}',
	'toplists-list-created-by' => 'од [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Гласај „за“',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|глас|гласа}} in $2',
	'toplists-list-add-item-label' => 'Додај ставка',
	'toplists-list-add-item-name-label' => 'Продолжете го списокот...',
	'toplists-list-item-voted' => 'Гласано',
	'toplists-createpage-dialog-label' => 'Список на 10 предводници',
	'toplists-email-subject' => 'Списокот на 10 најкотирани е изменет',
	'toplists-email-body' => 'Здраво од Викија!

Списокот <a href="$1">$2</a> на Викија е променет.

 $3

Појдете на Викија за да видите што се изменило! $1

- Викија

Можете да се <a href="$4">отпишете</a> од ваквите известувања за промени на списокот.',
	'toplists-seconds' => '$1 {{PLURAL:$1|секунда|секунди}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|минута|минути}}',
	'toplists-hours' => '$1 {{PLURAL:$1|час|часа}}',
	'toplists-days' => '$1 {{PLURAL:$1|ден|дена}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|недела|недели}}',
	'toplists-msg-fb-OnRateArticle-short' => 'гласаше на списокот на 10 најкотирани на $WIKINAME!',
	'toplists-create-heading' => '<em>Ново!</em> Создајте свои „10 најкотирани“',
	'toplists-create-button-msg' => 'Создај список',
	'toplists-oasis-only' => 'Создавањето на списоци на 10 предводници не е достапно во рувото „Монобук“. Оваа функција работи само со рувото „Викија“.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'toplists-desc' => 'Senarai 10 teratas',
	'right-toplists-create-edit-list' => 'Cipta dan sunting laman senarai 10 Teratas',
	'right-toplists-create-item' => 'Cipta dan tambahkan item dalam laman senarai 10 Teratas',
	'right-toplists-edit-item' => 'Sunting item dalam laman senarai 10 Teratas',
	'right-toplists-delete-item' => 'Hapuskan item dalam laman senarai 10 Teratas',
	'createtoplist' => 'Cipta senarai 10 Teratas yang baru',
	'edittoplist' => 'Sunting senarai 10 Teratas',
	'toplists-category' => 'Senarai 10 Teratas',
	'toplists-error-invalid-title' => 'Teks yang dibekalkan itu tidak sah.',
	'toplists-error-invalid-picture' => 'Gambar yang dipilih itu tidak sah.',
	'toplists-error-title-exists' => 'Laman ini sudah wujud. Anda boleh pergi ke <a href="$2" target="_blank">$1</a> atau berikan nama yang lain.',
	'toplists-error-title-spam' => 'Teks yang diberikan itu mengandungi kata-kata yang dicam sebagai spam.',
	'toplists-error-article-blocked' => 'Anda tidak dibenarkan mencipta laman dengan nama ini. Harap maaf.',
	'toplists-error-article-not-exists' => '"$1" tidak wujud. Adakah anda ingin <a href="$2" target="_blank">menciptanya</a>?',
	'toplists-error-picture-not-exists' => '"$1" tidak wujud. Adakah anda ingin <a href="$2" target="_blank">memuat naiknya</a>?',
	'toplists-error-duplicated-entry' => 'Anda tidak boleh menggunakan nama yang sama lebih sekali.',
	'toplists-error-empty-item-name' => 'Nama item yang wujud tidak boleh kosong.',
	'toplists-item-cannot-delete' => 'Item ini tidak dapat dihapuskan.',
	'toplists-error-image-already-exists' => 'Sudah wujud gambar yang sama namanya.',
	'toplists-error-add-item-anon' => 'Pengguna tanpa nama tidak dibenarkan menambahkan item ke dalam senarai. Sila <a class="ajaxLogin" id="login" href="$1">Log masuk</a> atau <a href="$2">buka akaun baru</a>.',
	'toplists-error-add-item-permission' => 'Perhatian: Akaun anda tidak diberikan kebenaran untuk mencipta item baru.',
	'toplists-error-add-item-list-not-exists' => 'Senarai 10 Teratas "$1" tidak wujud.',
	'toplists-upload-error-unknown' => 'Ralat terjadi ketika permohonan muat naik sedang diproses. Sila cuba lagi.',
	'action-toplists-create-edit-list' => 'cipta dan sunting laman senarai 10 Teratas',
	'toplists-editor-title-label' => 'Nama senarai',
	'toplists-editor-title-placeholder' => 'Isikan nama untuk senarai',
	'toplists-editor-related-article-label' => 'Laman berkaitan <small>(tidak wajib, tetapi memilih gambar)</small>',
	'toplists-editor-related-article-placeholder' => 'Isikan nama laman yang wujud',
	'toplists-editor-description-label' => 'Keterangan ringkas tentang Senarai 10 Teratas anda',
	'toplists-editor-description-placeholder' => 'Isikan keterangan',
	'toplists-editor-image-browser-tooltip' => 'Tambahkan satu gambar',
	'toplists-editor-remove-item-tooltip' => 'Gugurkan item',
	'toplists-editor-drag-item-tooltip' => 'Seret untuk mengubah susunan',
	'toplists-editor-add-item-label' => 'Tambahkan item baru',
	'toplists-editor-add-item-tooltip' => 'Tambahkan item baru ke dalam senarai',
	'toplists-create-button' => 'Cipta senarai',
	'toplists-update-button' => 'Simpan senarai',
	'toplists-cancel-button' => 'Batalkan',
	'toplists-items-removed' => '$1 item digugurkan',
	'toplists-items-created' => '$1 item dicipta',
	'toplists-items-updated' => '$1 item dikemaskini',
	'toplists-items-nochange' => 'Tiada item yang diubah',
	'toplits-image-browser-no-picture-selected' => 'Tiada gambar yang dipilih',
	'toplits-image-browser-clear-picture' => 'Padamkan gambar',
	'toplits-image-browser-selected-picture' => 'Kini dipilih: $1',
	'toplists-image-browser-upload-btn' => 'Pilih',
	'toplists-image-browser-upload-label' => 'Muat naik gambar sendiri',
	'toplists-list-creation-summary' => 'Mencipta senarai, $1',
	'toplists-list-update-summary' => 'Mengemaskini senarai, $1',
	'toplists-item-creation-summary' => 'Mencipta item senarai',
	'toplists-item-update-summary' => 'Mengemaskini item senarai',
	'toplists-item-remove-summary' => 'Item digugurkan daripada senarai',
	'toplists-item-restored' => 'Item dipulihkan',
	'toplists-list-related-to' => 'Berkaitan dengan:',
	'toplists-list-votes-num' => '$1<br />undian',
	'toplists-list-created-by' => 'oleh [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Undi',
	'toplists-list-hotitem-count' => '$1 undian dalam $2',
	'toplists-list-add-item-label' => 'Tambahkan item',
	'toplists-list-add-item-name-label' => 'Teruskan senarai...',
	'toplists-list-item-voted' => 'Diundi',
	'toplists-createpage-dialog-label' => 'Senarai 10 Teratas',
	'toplists-email-subject' => 'Satu senarai 10 Teratas telah diubah',
	'toplists-email-body' => 'Salam mesra dari Wikia!

Senarai <a href="$1">$2</a> di Wikia telah diubah.

 $3

Datanglah ke Wikia untuk melihat perubahannya! $1

- Wikia

Anda boleh <a href="$4">berhenti melanggan</a> perubahan dalam senarai.',
	'toplists-seconds' => '$1 saat',
	'toplists-minutes' => '$1 minit',
	'toplists-hours' => '$1 jam',
	'toplists-days' => '$1 hari',
	'toplists-weeks' => '$1 minggu',
	'toplists-msg-fb-OnRateArticle-short' => 'telah mengundi pada senarai 10 Teratas di $WIKINAME!',
	'toplists-create-heading' => '<em>Baru!</em> Buatlah Sepuluh Teratas Anda Sendiri',
	'toplists-create-button-msg' => 'Cipta senarai',
	'toplists-oasis-only' => 'Kulit Monobook tidak boleh dipakai untuk membuat dan menyunting senarai 10 Teratas. Jika anda ingin menggunakan ciri ini, sila tukar kepada kulit Wikia.',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'toplists-editor-remove-item-tooltip' => 'ဖယ်ရှားရန်',
	'toplists-editor-add-item-label' => 'အသစ် ထည့်ရန်',
	'toplists-cancel-button' => 'မလုပ်တော့ပါ',
	'toplists-list-item-voted' => 'ဆန္ဒမဲ',
	'toplists-days' => '$1 {{PLURAL:$1|ရက်|ရက်}}',
);

/** Norwegian Bokmål (norsk bokmål)
 * @author Audun
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'toplists-desc' => 'Topp 10-lister',
	'right-toplists-create-edit-list' => 'Opprett og rediger Topp 10-listesider.',
	'right-toplists-create-item' => 'Opprett og legg elementer til en Topp 10-listeside',
	'right-toplists-edit-item' => 'Rediger elementer i en Topp 10-listeside',
	'right-toplists-delete-item' => 'Slett elementer fra en Topp 10-listeside',
	'createtoplist' => 'Opprett en ny Topp 10-liste',
	'edittoplist' => 'Rediger Topp 10-liste',
	'toplists-category' => 'Topp 10-lister',
	'toplists-error-invalid-title' => 'Den oppgitte teksten er ikke gyldig.',
	'toplists-error-invalid-picture' => 'Det valgte bildet er ikke gyldig.',
	'toplists-error-title-exists' => 'Denne siden eksisterer allerede. Du kan gå til <a href="$2" target="_blank">$1</a> eller oppgi et annet navn.',
	'toplists-error-title-spam' => 'Den oppgitte teksten inneholder noen ord som gjenkjennes som spam.',
	'toplists-error-article-blocked' => 'Du har ikke tillatelse til å opprette en side med dette navnet. Beklager.',
	'toplists-error-article-not-exists' => '«$1» eksisterer ikke. Vil du <a href="$2" target="_blank">opprette den</a>?',
	'toplists-error-picture-not-exists' => '«$1» eksisterer ikke. Vil du <a href="$2" target="_blank">laste det opp</a>?',
	'toplists-error-duplicated-entry' => 'Du kan ikke bruke det samme navnet mer enn én gang.',
	'toplists-error-empty-item-name' => 'Navnet på et eksisterende element kan ikke være blankt.',
	'toplists-item-cannot-delete' => 'Sletting av dette elementet mislyktes.',
	'toplists-error-image-already-exists' => 'Et bilde med det samme navnet eksisterer allerede.',
	'toplists-error-add-item-anon' => 'Anonyme bukrere er ikke tillatt å legge til objekter i listene. Vennligst <a class="ajaxLogin" id="login" href="$1">Logg inn</a> eller <a href="$2">registrer en ny konto</a>.',
	'toplists-error-add-item-permission' => 'Tillatelsesfeil: Kontoen din har ikke blitt gitt rettighetene til å opprette nye elementer.',
	'toplists-error-add-item-list-not-exists' => 'Topp 10-listen «$1» eksisterer ikke.',
	'toplists-upload-error-unknown' => 'En feil har oppstått under behandlingen av opplastningsforespørselen, vennligst prøv igjen.',
	'action-toplists-create-edit-list' => 'opprett og rediger Topp 10-listesider',
	'toplists-editor-title-label' => 'Listenavn',
	'toplists-editor-title-placeholder' => 'Oppgi et navn til listen',
	'toplists-editor-related-article-label' => 'Relatert side <small>(valgfritt, men velger et bilde)</small>',
	'toplists-editor-related-article-placeholder' => 'Oppgi et navn på en eksisterende side',
	'toplists-editor-description-label' => 'En kort beskrivelse av topp 10-listen din',
	'toplists-editor-description-placeholder' => 'Oppgi en beskrivelse',
	'toplists-editor-image-browser-tooltip' => 'Legg til et bilde',
	'toplists-editor-remove-item-tooltip' => 'Fjern element',
	'toplists-editor-drag-item-tooltip' => 'Dra for å endre rekkefølgen',
	'toplists-editor-add-item-label' => 'Legg til et nytt element',
	'toplists-editor-add-item-tooltip' => 'Legg et nytt element til listen',
	'toplists-create-button' => 'Opprett liste',
	'toplists-update-button' => 'Lagre liste',
	'toplists-cancel-button' => 'Avbryt',
	'toplists-items-removed' => '$1 {{PLURAL:$1|element|elementer}} fjernet',
	'toplists-items-created' => '$1 {{PLURAL:$1|element|elementer}} opprettet',
	'toplists-items-updated' => '$1 {{PLURAL:$1|element|elementer}} oppdatert',
	'toplists-items-nochange' => 'Ingen elementer endret',
	'toplits-image-browser-no-picture-selected' => 'Ikke noe bilde valgt',
	'toplits-image-browser-clear-picture' => 'Fjern bilde',
	'toplits-image-browser-selected-picture' => 'For øyeblikket valgte: $1',
	'toplists-image-browser-upload-btn' => 'Velg',
	'toplists-image-browser-upload-label' => 'Last opp ditt eget',
	'toplists-list-creation-summary' => 'Oppretter en liste, $1',
	'toplists-list-update-summary' => 'Oppdaterer en liste, $1',
	'toplists-item-creation-summary' => 'Oppretter et listeelement',
	'toplists-item-update-summary' => 'Oppdaterer et listeelement',
	'toplists-item-remove-summary' => 'Element fjernet fra listen',
	'toplists-item-restored' => 'Element gjenopprettet',
	'toplists-list-related-to' => 'Relatert til:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br/>stemme|$1<br/>stemmer}}',
	'toplists-list-created-by' => 'av [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Stem oppover',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|stemme|stemmer}} i $2',
	'toplists-list-add-item-label' => 'Legg til element',
	'toplists-list-add-item-name-label' => 'La listen fortsette...',
	'toplists-list-item-voted' => 'Stemt',
	'toplists-createpage-dialog-label' => 'Topp 10-liste',
	'toplists-email-subject' => 'En topp 10-liste har blitt endret',
	'toplists-email-body' => 'Wikia sier hei!

Listen <a href="$1">$2</a> på Wikia har blitt endret.

 $3

Gå til Wikia for å sjekke endringene. $1

- Wikia

Du kan <a href="$4">slette abbonementet</a> på endringer i listen.',
	'toplists-seconds' => '{{PLURAL:$1|ett sekund|$1 sekund}}',
	'toplists-minutes' => '{{PLURAL:$1|ett minutt|$1 minutt}}',
	'toplists-hours' => '{{PLURAL:$1|én time|$1 timer}}',
	'toplists-days' => '{{PLURAL:$1|én dag|$1 dager}}',
	'toplists-weeks' => '{{PLURAL:$1|én uke|$1 uker}}',
	'toplists-msg-fb-OnRateArticle-short' => 'har stemt på en Topp 10-liste på $WIKINAME!',
	'toplists-create-heading' => '<em>Nyhet!</em> Lag din egen Topp ti',
	'toplists-create-button-msg' => 'Opprett en liste',
	'toplists-oasis-only' => 'Oppretting og redigering av topp 10-lister er ikke tilgjengelig for Monobook. Hvis du ønsker å benytte deg av denne funksjonen, vennligst bytt over til Wikia-utseendet i innstillingene dine.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'toplists-desc' => 'Top 10-lijsten',
	'right-toplists-create-edit-list' => 'Top 10 lijsten aanmaken en bewerken',
	'right-toplists-create-item' => 'Items aanmaken en toevoegen aan Top 10 lijsten',
	'right-toplists-edit-item' => 'Items in een Top 10-lijstpagina bewerken',
	'right-toplists-delete-item' => 'Items uit een Top 10-lijstpagina verwijderen',
	'createtoplist' => 'Nieuwe Top 10 lijst aanmaken',
	'edittoplist' => 'Top 10-lijst bewerken',
	'toplists-category' => 'Top 10-lijsten',
	'toplists-error-invalid-title' => 'De opgegeven tekst wordt niet opgeslagen.',
	'toplists-error-invalid-picture' => 'De geselecteerde afbeelding is niet geldig.',
	'toplists-error-title-exists' => 'Deze pagina bestaat al. U kunt naar <a href="$2" target="_blank">$1</a> gaan of een andere naam opgeven.',
	'toplists-error-title-spam' => 'De opgegeven tekst bevat woorden die zijn herkend als spam.',
	'toplists-error-article-blocked' => 'Een pagina aanmaken met deze naam is helaas niet toegestaan.',
	'toplists-error-article-not-exists' => '"$1" bestaat niet. Wilt u deze <a href="$2" target="_blank">aanmaken</a>?',
	'toplists-error-picture-not-exists' => '"$1" bestaat niet. Wilt u het bestand <a href="$2" target="_blank">uploaden</a>?',
	'toplists-error-duplicated-entry' => 'U kunt dezelfde naam niet opnieuw gebruiken.',
	'toplists-error-empty-item-name' => 'De naam van een bestaand item kan niet leeg zijn.',
	'toplists-item-cannot-delete' => 'Het verwijderen van dit item is mislukt.',
	'toplists-error-image-already-exists' => 'Er bestaat al een afbeelding met die naam.',
	'toplists-error-add-item-anon' => 'Anonieme gebruikers mogen geen items toevoegen aan lijsten. <a class="ajaxLogin" id="login" href="$1">Meld u aan</a> of <a href="$2">registreer een nieuwe gebruiker</a>.',
	'toplists-error-add-item-permission' => 'Rechtenprobleem: uw gebruiker heeft geen rechten om nieuwe items aan te maken.',
	'toplists-error-add-item-list-not-exists' => 'De Top 10 lijst "$1" bestaat niet.',
	'toplists-upload-error-unknown' => 'Er is een fout opgetreden bij het verwerken van de uploadverzoek. Probeer het nog een keer.',
	'action-toplists-create-edit-list' => 'Top-10 lijsten aan te maken en te bewerken',
	'toplists-editor-title-label' => 'Lijstnaam',
	'toplists-editor-title-placeholder' => 'Voer een naam in voor de lijst',
	'toplists-editor-related-article-label' => 'Gerelateerde pagina <small>(optioneel, maar selecteert een afbeelding)</small>',
	'toplists-editor-related-article-placeholder' => 'Voer een bestaande paginanaam in',
	'toplists-editor-description-label' => 'Een korte beschrijving van uw Top 10-lijst',
	'toplists-editor-description-placeholder' => 'Geef een beschrijving op',
	'toplists-editor-image-browser-tooltip' => 'Afbeelding toevoegen',
	'toplists-editor-remove-item-tooltip' => 'Item verwijderen',
	'toplists-editor-drag-item-tooltip' => 'Sleep om de volgorde te wijzigen',
	'toplists-editor-add-item-label' => 'Nieuw item toevoegen',
	'toplists-editor-add-item-tooltip' => 'Nieuw item aan de lijst toevoegen',
	'toplists-create-button' => 'Lijst aanmaken',
	'toplists-update-button' => 'Lijst opslaan',
	'toplists-cancel-button' => 'Annuleren',
	'toplists-items-removed' => '$1 {{PLURAL:$1|item|items}} verwijderd',
	'toplists-items-created' => '$1 {{PLURAL:$1|item|items}} aangemaakt',
	'toplists-items-updated' => '$1 {{PLURAL:$1|item|items}} bijgewerkt',
	'toplists-items-nochange' => 'Geen items gewijzigd',
	'toplits-image-browser-no-picture-selected' => 'Geen afbeelding geselecteerd',
	'toplits-image-browser-clear-picture' => 'Afbeelding wissen',
	'toplits-image-browser-selected-picture' => 'Geselecteerd: $1',
	'toplists-image-browser-upload-btn' => 'Kiezen',
	'toplists-image-browser-upload-label' => 'Zelf uploaden',
	'toplists-list-creation-summary' => 'Lijst $1 aangemaakt',
	'toplists-list-update-summary' => 'Lijst $1 bijgewerkt',
	'toplists-item-creation-summary' => 'Lijstitem aangemaakt',
	'toplists-item-update-summary' => 'Lijstitem bijgewerkt',
	'toplists-item-remove-summary' => 'Lijstitem verwijderd',
	'toplists-item-restored' => 'Item teruggeplaatst',
	'toplists-list-related-to' => 'Gerelateerd aan:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />stem|$1<br />stemmen}}',
	'toplists-list-created-by' => 'door [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Positief beoordelen',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|stem|stemmen}} in $2',
	'toplists-list-add-item-label' => 'Item toevoegen',
	'toplists-list-add-item-name-label' => 'Houd de lijst gaande...',
	'toplists-list-item-voted' => 'Gestemd',
	'toplists-createpage-dialog-label' => 'Top 10-lijst',
	'toplists-email-subject' => 'Er is een Top 10 lijst gewijzigd',
	'toplists-email-body' => 'De hartelijke groeten van Wikia!

De lijst <a href="$1">$2</a> op Wikia is gewijzigd.

 $3

Ga naar Wikia om de wijzigingen te bekijken! $1

- Wikia

U kunt <a href="$4">uitschrijven</a> van wijzigingen op deze lijst.',
	'toplists-seconds' => '$1 {{PLURAL:$1|seconde|seconden}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuut|minuten}}',
	'toplists-hours' => '$1 {{PLURAL:$1|uur|uren}}',
	'toplists-days' => '$1 {{PLURAL:$1|dag|dagen}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|week|weken}}',
	'toplists-msg-fb-OnRateArticle-short' => 'heeft gestemd op een Top 10 lijst op $WIKINAME!',
	'toplists-create-heading' => '<em>Nieuw!</em> Maak uw eigen Top 10 aan',
	'toplists-create-button-msg' => 'Lijst aanmaken',
	'toplists-oasis-only' => 'Het aanmaken en bewerken van Top 10-lijsten is niet mogelijk in deze vormgeving. Als u deze optie wilt gebruiken, kan dat alleen in de vormgeving "Wikia", die u kunt instelling in uw voorkeuren.',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'toplists-error-title-exists' => 'Deze pagina bestaat al. Je kunt naar <a href="$2" target="_blank">$1</a> gaan of een andere naam opgeven.',
	'toplists-error-article-not-exists' => '"$1" bestaat niet. Wil je deze <a href="$2" target="_blank">aanmaken</a>?',
	'toplists-error-picture-not-exists' => '"$1" bestaat niet. Wil je het bestand <a href="$2" target="_blank">uploaden</a>?',
	'toplists-error-duplicated-entry' => 'Je kunt dezelfde naam niet opnieuw gebruiken.',
	'toplists-error-add-item-permission' => 'Rechtenprobleem: je gebruiker heeft geen rechten om nieuwe items aan te maken.',
	'toplists-email-body' => 'De hartelijke groeten van Wikia!

De lijst <a href="$1">$2</a> op Wikia is gewijzigd.

 $3

Ga naar Wikia om de wijzigingen te bekijken! $1

- Wikia

Je kunt <a href="$4">uitschrijven</a> van wijzigingen op deze lijst.',
	'toplists-create-heading' => '<em>Nieuw!</em> Maak je eigen Top 10 aan',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Sovq
 */
$messages['pl'] = array(
	'toplists-desc' => 'Listy Top 10',
	'right-toplists-create-edit-list' => 'Ttwórz i edytuj listy Top 10',
	'right-toplists-create-item' => 'Dodawaj elementy do list Top 10',
	'right-toplists-edit-item' => 'Edytuj elementy na listach Top 10',
	'right-toplists-delete-item' => 'Usuwaj elementy z listy Top 10',
	'createtoplist' => 'Utwórz nową listę Top 10',
	'edittoplist' => 'Edytuj listę Top 10',
	'toplists-category' => 'Listy Top 10',
	'toplists-error-invalid-title' => 'Podany tekst jest nieprawidłowy.',
	'toplists-error-invalid-picture' => 'Wybrany obraz jest nieprawidłowy.',
	'toplists-error-title-exists' => 'Ta strona już istnieje. Możesz przejść do <a href="$2" target="_blank">$1</a> lub podać inną nazwę.',
	'toplists-error-title-spam' => 'Podany tekst zawiera pewne wyrazy rozpoznane jako spam.',
	'toplists-error-article-blocked' => 'Nie masz uprawnień do utworzenia strony o takiej nazwie. Przepraszamy.',
	'toplists-error-article-not-exists' => '"$1" nie istnieje. Czy chcesz <a href="$2" target="_blank">ją utworzyć</a>?',
	'toplists-error-picture-not-exists' => '"$1" nie istnieje. Czy chcesz <a href="$2" target="_blank">go przesłać</a>?',
	'toplists-error-duplicated-entry' => 'Nie możesz użyć tej samej nazwy więcej niż jeden raz.',
	'toplists-error-empty-item-name' => 'Nazwa istniejącego elementu nie może być pusta.',
	'toplists-item-cannot-delete' => 'Usunięcie tego elementu nie powiodło się.',
	'toplists-error-image-already-exists' => 'Obraz o tej samej nazwie już istnieje.',
	'toplists-error-add-item-anon' => 'Anonimowi użytkownicy nie mogą dodawać elementów do listy. Prosimy <a class="ajaxLogin" id="login" href="$1"> zaloguj się</a> lub <a href="$2">zarejestruj konto</a>.',
	'toplists-error-add-item-permission' => 'Błąd uprawnień: twoje konto nie posiada praw do tworzenia nowych elementów.',
	'toplists-error-add-item-list-not-exists' => 'Lista Top 10 "$1" nie istnieje.',
	'toplists-upload-error-unknown' => 'Wystąpił błąd podczas przetwarzania żądania przesłania. Spróbuj ponownie.',
	'action-toplists-create-edit-list' => 'utwórz i edytuj listy Top 10',
	'toplists-editor-title-label' => 'Nazwa listy',
	'toplists-editor-title-placeholder' => 'Wprowadź nazwę listy',
	'toplists-editor-related-article-label' => 'Strona powiązana<small>(opcjonalne, ale wybiera obraz)</small>',
	'toplists-editor-related-article-placeholder' => 'Wprowadź nazwę istniejącej strony',
	'toplists-editor-description-label' => 'Krótki opis Twojej listy Top 10',
	'toplists-editor-description-placeholder' => 'Wprowadź opis',
	'toplists-editor-image-browser-tooltip' => 'Dodaj obraz',
	'toplists-editor-remove-item-tooltip' => 'Usuń element',
	'toplists-editor-drag-item-tooltip' => 'Przeciągnij, aby zmienić kolejność',
	'toplists-editor-add-item-label' => 'Dodaj nowy element',
	'toplists-editor-add-item-tooltip' => 'Dodaj nowy element do listy',
	'toplists-create-button' => 'Utwórz listę',
	'toplists-update-button' => 'Zapisz listę',
	'toplists-cancel-button' => 'Anuluj',
	'toplists-items-removed' => 'Usunięto $1 {{PLURAL:$1|element|elementy|elementów}}',
	'toplists-items-created' => 'Utworzono $1 {{PLURAL:$1|element|elementy|elementów}}',
	'toplists-items-updated' => 'Zmieniono $1 {{PLURAL:$1|element|elementy|elementów}}',
	'toplists-items-nochange' => 'Nie zmieniono elementów',
	'toplits-image-browser-no-picture-selected' => 'Nie wybrano obrazka',
	'toplits-image-browser-clear-picture' => 'Wyczyść obrazek',
	'toplits-image-browser-selected-picture' => 'Aktualnie wybrano: $1',
	'toplists-image-browser-upload-btn' => 'Wybierz',
	'toplists-image-browser-upload-label' => 'Prześlij własne',
	'toplists-list-creation-summary' => 'Tworzenie listy, $1',
	'toplists-list-update-summary' => 'Aktualizacja listy, $1',
	'toplists-item-creation-summary' => 'Tworzenie elementu listy',
	'toplists-item-update-summary' => 'Aktualizacja elementu listy',
	'toplists-item-remove-summary' => 'Element usunięty z listy',
	'toplists-item-restored' => 'Przywrócono element',
	'toplists-list-related-to' => 'Związane z:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />głos|$1<br />głosy|$1<br />głosów}}',
	'toplists-list-created-by' => 'przez [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Zagłosuj',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|głos|głosy|głosów}} w $2',
	'toplists-list-add-item-label' => 'Dodaj element',
	'toplists-list-add-item-name-label' => 'Przechowanie stanów listy...',
	'toplists-list-item-voted' => 'Głosowało',
	'toplists-createpage-dialog-label' => 'Lista Top 10',
	'toplists-email-subject' => 'Zmieniono listę Top 10',
	'toplists-email-body' => 'Witaj!

Lista <a href="$1">$2</a> na Wikii została zmieniona.

 $3

Przejdź na Wikię by sprawdzić zmiany! $1

- Wikia

Możesz <a href="$4">anulować subskrypcję</a> zmian na liście.',
	'toplists-seconds' => '$1 {{PLURAL:$1|sekunda|sekundy|sekund}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuta|minuty|minut}}',
	'toplists-hours' => '$1 {{PLURAL:$1|godzina|godziny|godzin}}',
	'toplists-days' => '$1 {{PLURAL:$1|dzień|dni}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|tydzień|tygodnie|tygodni}}',
	'toplists-msg-fb-OnRateArticle-short' => 'zagłosował(a) na liście Top 10 na $WIKINAME!',
	'toplists-create-heading' => '<em>Nowość!</em> Utwórz własną Listę Top 10',
	'toplists-create-button-msg' => 'Utwórz listę',
	'toplists-oasis-only' => 'Tworzenie i edytowanie list Top 10 nie jest dostępne w Monobooku. Jeśli chcesz korzystać z tej funkcjonalności, zmień skórkę na Wikia w swoich preferencjach.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'toplists-desc' => 'Liste dij prim 10',
	'right-toplists-create-edit-list' => 'Crea e modìfica le pàgine dle liste dij Prim 10',
	'right-toplists-create-item' => "Creé e gionta dj'element a na pàgina ëd lista dij Prim 10",
	'right-toplists-edit-item' => "Modifiché j'element ant la pàgina ëd la lista dij Prim 10",
	'right-toplists-delete-item' => "Scancelé j'element da na pàgina ëd lista dij Prim 10",
	'createtoplist' => 'Crea na lista neuva dij Prim 10',
	'edittoplist' => 'Modìfica dij Prim 10',
	'toplists-category' => 'Liste dij prim 10',
	'toplists-error-invalid-title' => 'Ël test dàit a va nen bin.',
	'toplists-error-invalid-picture' => "La figura selessionà a l'é pa bon-a.",
	'toplists-error-title-exists' => 'Sta pàgina a esist già. It peule andé a <a href="$2" target="_blank">$1</a> o dé un nòm diferent.',
	'toplists-error-title-spam' => 'Ël test dàit a conten quàiche paròle arconossùe com rumenta.',
	'toplists-error-article-blocked' => 'A peul pa creé na pàgina con sto nòm-sì. An dëspias.',
	'toplists-error-article-not-exists' => '"$1" a esist pa. Veus-to <a href="$2" target="_blank">creelo</a>?',
	'toplists-error-picture-not-exists' => '"$1" a esist pa. Veus-to <a href="$2" target="_blank">carielo</a>?',
	'toplists-error-duplicated-entry' => 'A peul pa dovré ël midem nòm pi che na vira.',
	'toplists-error-empty-item-name' => "Ël nòm ëd n'element esistent a peul pa esse veuid.",
	'toplists-item-cannot-delete' => "La scancelassion ëd s'element a l'é falìa.",
	'toplists-error-image-already-exists' => 'Na figura con ël midem nòm a esist già.',
	'toplists-error-add-item-anon' => 'J\'utent anònim a peulo pa gionté d\'element a la lista. Për piasì <a class="ajaxLogin" id="login" href="$1">ch\'a intra ant ël sistema</a> o <a href="$2">ch\'a registra un cont neuv</a>.',
	'toplists-error-add-item-permission' => "Eror ëd përmess: Sò cont a l'ha pa ël drit ëd creé d'element neuv.",
	'toplists-error-add-item-list-not-exists' => 'La lista "$1" dij Prim 10 a esist pa.',
	'toplists-upload-error-unknown' => "N'eror a l'é capità antramente ch'as tratava l'arcesta d'amportassion. Për piasì, ch'a preuva torna.",
	'action-toplists-create-edit-list' => 'crea e modìfica le pàgine dle liste dij Prim 10',
	'toplists-editor-title-label' => 'Nòm ëd lista',
	'toplists-editor-title-placeholder' => 'Buté un nòm për la lista',
	'toplists-editor-related-article-label' => 'Pàgina corelà <small>(opsional, ma selession-a na figura)</small>',
	'toplists-editor-related-article-placeholder' => 'Buté un nòm ëd na pàgina esistenta',
	'toplists-editor-description-label' => 'Na curta descrission ëd toa Lista dij Prim 10',
	'toplists-editor-description-placeholder' => 'Anseriss na descrission',
	'toplists-editor-image-browser-tooltip' => 'Gionta na figura',
	'toplists-editor-remove-item-tooltip' => "Gavé l'element",
	'toplists-editor-drag-item-tooltip' => "Fé sghijé për cangé l'órdin",
	'toplists-editor-add-item-label' => "Gionta n'element neuv",
	'toplists-editor-add-item-tooltip' => "Gionta n'element neuv a la lista",
	'toplists-create-button' => 'Creé na lista',
	'toplists-update-button' => 'Salvé la lista',
	'toplists-cancel-button' => 'Scancela',
	'toplists-items-removed' => '$1 {{PLURAL:$1|element|element}} gavà',
	'toplists-items-created' => '$1 {{PLURAL:$1|element|element}} creà',
	'toplists-items-updated' => '$1 {{PLURAL:$1|element|element}} agiornà',
	'toplists-items-nochange' => 'Pa gnun element cangià',
	'toplits-image-browser-no-picture-selected' => 'Pa gnun-e figure selessionà',
	'toplits-image-browser-clear-picture' => 'Scancelé la figura',
	'toplits-image-browser-selected-picture' => 'Selessionà al moment: $1',
	'toplists-image-browser-upload-btn' => 'Sern',
	'toplists-image-browser-upload-label' => "Ch'a caria la soa",
	'toplists-list-creation-summary' => 'Creé na lista, $1',
	'toplists-list-update-summary' => 'Agiorné na lista, $1',
	'toplists-item-creation-summary' => "Creé n'element ëd na lista",
	'toplists-item-update-summary' => "Agiorné n'element ëd na lista",
	'toplists-item-remove-summary' => 'Element gavà da na lista',
	'toplists-item-restored' => 'Element ripristinà',
	'toplists-list-related-to' => 'Corelà a:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />vot|$1<br />vot}}',
	'toplists-list-created-by' => 'da [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Voté a pro',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|vot|vot}} an $2',
	'toplists-list-add-item-label' => "Gionté n'element",
	'toplists-list-add-item-name-label' => 'Lassé core la lista...',
	'toplists-list-item-voted' => 'Votà',
	'toplists-createpage-dialog-label' => 'Lista dij prim 10',
	'toplists-email-subject' => "Na lista dij Prim 10 a l'é stàita cangià",
	'toplists-email-body' => 'Cerea da Wikia!

La lista <a href="$1">$2</a> su Wikia a l\'é stàita cangià.

 $3

Và su Wikia për controlé ij cambi! $1

- Wikia

It peule <a href="$4">disiscrivte</a> dai cambi a la lista.',
	'toplists-seconds' => '$1 {{PLURAL:$1|second|second}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuta|minute}}',
	'toplists-hours' => '$1 {{PLURAL:$1|ora|ore}}',
	'toplists-days' => '$1 {{PLURAL:$1|di|di}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|sman-a|sman-e}}',
	'toplists-msg-fb-OnRateArticle-short' => 'a l\'ha votà su na lista dij Prim 10 su $WIKINAME!',
	'toplists-create-heading' => '<em>Neuv!</em> Crea Toa Lista dij Prim Des',
	'toplists-create-button-msg' => 'Crea na lista',
	'toplists-oasis-only' => "Creé e modifiché le liste dij Prim 10 as peul pa dzora a Monobook. S'a veul dovré sta funsion, për piasì ch'a modìfica ij sò gust an sl'aspet ëd Wikia.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'toplists-desc' => 'د سر 10 لړليکونه',
	'right-toplists-create-edit-list' => 'د سر 10 لړليکونو مخونه جوړول او سمول',
	'createtoplist' => 'د سر 10 لړليکونو يو نوی لړليک جوړول',
	'edittoplist' => 'د سر 10 لړليکونه سمول',
	'toplists-category' => 'د سر 10 لړليکونه',
	'toplists-editor-title-label' => 'د لړليک نوم',
	'toplists-editor-related-article-label' => 'اړونده مخ <small>(د کارن په خوښه، خو يو انځور بايد وټاکل شي)</small>',
	'toplists-editor-image-browser-tooltip' => 'يو انځور ورگډول',
	'toplists-editor-add-item-label' => 'يو نوی توکی ورگډول',
	'toplists-create-button' => 'لړليک جوړول',
	'toplists-update-button' => 'لړليک خوندي کول',
	'toplists-cancel-button' => 'ناگارل',
	'toplists-image-browser-upload-btn' => 'ټاکل',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />رايه|$1<br />رايې}}',
	'toplists-list-created-by' => 'د [[User:$1|$1]] لخوا',
	'toplists-list-add-item-label' => 'توکی ورگډول',
	'toplists-createpage-dialog-label' => 'د سر 10 لړليکونه',
	'toplists-seconds' => '$1 {{PLURAL:$1|ثانيه|ثانيې}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|دقيقه|دقيقې}}',
	'toplists-hours' => '$1 {{PLURAL:$1|ساعت|ساعتونه}}',
	'toplists-days' => '$1 {{PLURAL:$1|ورځ|ورځې}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|اونۍ|اونۍ}}',
	'toplists-create-button-msg' => 'يو لړليک جوړول',
);

/** Portuguese (português)
 * @author GTNS
 * @author Hamilton Abreu
 * @author Luckas
 * @author SandroHc
 * @author Waldir
 */
$messages['pt'] = array(
	'toplists-desc' => 'Listas Top 10',
	'right-toplists-create-edit-list' => 'Criar e editar páginas de listas Top 10',
	'right-toplists-create-item' => 'Criar e adicionar elementos à página de uma lista Top 10',
	'right-toplists-edit-item' => 'Editar itens na página de uma lista Top 10',
	'right-toplists-delete-item' => 'Eliminar itens da página de uma lista Top 10',
	'createtoplist' => 'Criar uma lista Top 10',
	'edittoplist' => 'Editar lista Top 10',
	'toplists-category' => 'Listas Top 10',
	'toplists-error-invalid-title' => 'O texto fornecido não é válido.',
	'toplists-error-invalid-picture' => 'A imagem selecionada não é válida.',
	'toplists-error-title-exists' => 'Esta página já existe. Pode ir para <a href="$2" target="_blank">$1</a> ou fornecer um nome diferente.',
	'toplists-error-title-spam' => 'O texto introduzido contém algumas palavras identificadas como spam.',
	'toplists-error-article-blocked' => 'Não pode criar uma página com este nome. Desculpe.',
	'toplists-error-article-not-exists' => '"$1" não existe. Deseja <a href="$2" target="_blank">criá-lo</a> ?',
	'toplists-error-picture-not-exists' => '"$1" não existe. Deseja <a href="$2" target="_blank">enviá-lo</a> ?',
	'toplists-error-duplicated-entry' => 'Não pode usar o mesmo nome mais de uma vez.',
	'toplists-error-empty-item-name' => 'O nome de um elemento existente não pode ser vazio.',
	'toplists-item-cannot-delete' => 'A eliminação deste elemento falhou.',
	'toplists-error-image-already-exists' => 'Já existe uma imagem com o mesmo nome.',
	'toplists-error-add-item-anon' => 'Utilizadores anónimos não têm permissão para adicionar elementos a listas. Por favor <a class="ajaxLogin" id="login" href="$1">autentique-se</a> ou <a href="$2">crie uma conta</a>.',
	'toplists-error-add-item-permission' => 'Erro de permissões: Não foi concedida à sua conta a capacidade de criar elementos.',
	'toplists-error-add-item-list-not-exists' => 'A lista Top 10 "$1" não existe.',
	'toplists-upload-error-unknown' => 'Ocorreu um erro ao processar o pedido de upload. Tente novamente, por favor.',
	'toplists-editor-title-label' => 'Nome da lista',
	'toplists-editor-title-placeholder' => 'Introduza um nome para a lista',
	'toplists-editor-related-article-label' => 'Página relacionada <small>(opcional, mas selecciona uma imagem)</small>',
	'toplists-editor-related-article-placeholder' => 'Introduza o nome de uma página existente',
	'toplists-editor-description-placeholder' => 'Introduza uma descrição',
	'toplists-editor-image-browser-tooltip' => 'Adicionar uma imagem',
	'toplists-editor-remove-item-tooltip' => 'Remover o elemento',
	'toplists-editor-drag-item-tooltip' => 'Arraste para alterar a ordem',
	'toplists-editor-add-item-label' => 'Acrescentar um elemento',
	'toplists-editor-add-item-tooltip' => 'Adicionar um elemento à lista',
	'toplists-create-button' => 'Criar lista',
	'toplists-update-button' => 'Gravar lista',
	'toplists-cancel-button' => 'Cancelar',
	'toplists-items-removed' => '$1 {{PLURAL:$1|elemento removido|elementos removidos}}',
	'toplists-items-created' => '$1 {{PLURAL:$1|elemento criado|elementos criados}}',
	'toplists-items-updated' => '$1 {{PLURAL:$1|elemento atualizado|elementos atualizados}}',
	'toplists-items-nochange' => 'Não foi alterado nenhum elemento',
	'toplits-image-browser-no-picture-selected' => 'Não foi selecionada nenhuma imagem',
	'toplits-image-browser-clear-picture' => 'Limpar imagem',
	'toplits-image-browser-selected-picture' => 'Selecionada neste momento: $1',
	'toplists-image-browser-upload-btn' => 'Escolher',
	'toplists-image-browser-upload-label' => 'Faça o upload de uma',
	'toplists-list-creation-summary' => 'A criar uma lista, $1',
	'toplists-list-update-summary' => 'A actualizar uma lista, $1',
	'toplists-item-creation-summary' => 'A criar um elemento de uma lista',
	'toplists-item-update-summary' => 'A actualizar um elemento de uma lista',
	'toplists-item-remove-summary' => 'Elemento removido da lista',
	'toplists-item-restored' => 'Elemento restaurado',
	'toplists-list-related-to' => 'Relacionado a:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />voto|$1<br />votos}}',
	'toplists-list-created-by' => 'por [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Voto positivo',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|voto|votos}} em $2',
	'toplists-list-add-item-label' => 'Adicionar elemento',
	'toplists-list-add-item-name-label' => 'Continuar a lista...',
	'toplists-list-item-voted' => 'Votado',
	'toplists-createpage-dialog-label' => 'Lista Top 10',
	'toplists-email-subject' => 'Uma lista Top 10 foi alterada',
	'toplists-email-body' => 'Olá da Wikia!

A lista <a href="$1">$2</a> na Wikia foi alterada.

 $3

Vá a Wikia verificar as mudanças! $1

- Wikia

Pode <a href="$4">cancelar a subscrição</a> de alterações à lista.',
	'toplists-seconds' => '$1 {{PLURAL:$1|segundo|segundos}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuto|minutos}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hora|horas}}',
	'toplists-days' => '$1 {{PLURAL:$1|dia|dias}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|semana|semanas}}',
	'toplists-msg-fb-OnRateArticle-short' => 'votou numa lista Top 10 na $WIKINAME!',
	'toplists-create-heading' => '<em>Novo!</em> Crie o Seu Próprio Top 10',
	'toplists-create-button-msg' => 'Criar uma lista',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Luckas
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'toplists-create-button' => 'Criar lista',
	'toplists-update-button' => 'Salvar lista',
	'toplists-cancel-button' => 'Cancelar',
	'toplists-image-browser-upload-btn' => 'Escolher',
	'toplists-list-creation-summary' => 'Criando uma lista, $1',
	'toplists-list-update-summary' => 'Atualizando uma lista, $1',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />voto|$1<br />votos}}',
	'toplists-list-created-by' => 'por [[User:$1|$1]]',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|voto|votos}} em $2',
	'toplists-list-add-item-label' => 'Adicionar elemento',
	'toplists-list-item-voted' => 'Votado',
	'toplists-seconds' => '$1 {{PLURAL:$1|segundo|segundos}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuto|minutos}}',
	'toplists-hours' => '$1 {{PLURAL:$1|hora|horas}}',
	'toplists-days' => '$1 {{PLURAL:$1|dia|dias}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|semana|semanas}}',
	'toplists-create-button-msg' => 'Criar uma lista',
);

/** Romanian (română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'toplists-editor-image-browser-tooltip' => 'Adaugă o imagine',
	'toplists-create-button' => 'Crează lista',
	'toplists-update-button' => 'Salvează lista',
	'toplists-cancel-button' => 'Renunţă',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'toplists-desc' => 'Le megghie 10',
	'right-toplists-create-edit-list' => "Ccreje e cange l'elenghe de le megghie 10 pàggene",
	'edittoplist' => 'Cange le megghie 10',
	'toplists-category' => 'Le megghie 10',
	'toplists-error-invalid-title' => "'U teste scritte non g'è valide.",
	'toplists-error-invalid-picture' => "'A fote scacchiate non g'è valide.",
	'toplists-create-button' => "ccreje 'n'elenghe",
	'toplists-update-button' => "Reggìstre l'elenghe",
	'toplists-cancel-button' => 'Annulle',
	'toplists-items-removed' => '$1 {{PLURAL:$1|vôsce}} luate',
	'toplists-items-created' => '$1 {{PLURAL:$1|vôsce}} ccrejate',
	'toplists-items-updated' => '$1 {{PLURAL:$1|vôsce}} aggiornate',
	'toplists-items-nochange' => 'Nisciuna vôsce cangiate',
	'toplits-image-browser-no-picture-selected' => 'Nisciuna fote scacchiate',
	'toplits-image-browser-clear-picture' => "Pulizze 'a fote",
	'toplits-image-browser-selected-picture' => 'Scacchiate pe mò: $1',
	'toplists-image-browser-upload-btn' => 'Scacchie',
	'toplists-image-browser-upload-label' => "Careche 'u tune",
	'toplists-list-creation-summary' => "Stoche a ccreje 'n'elenghe, $1",
	'toplists-list-update-summary' => "Stoche aggiorne 'n'elenghe, $1",
	'toplists-item-creation-summary' => "Stoche a ccreje 'n'elenghe de vôsce",
	'toplists-item-update-summary' => "Stoche aggiorne 'n'elenghe de vôsce",
	'toplists-item-remove-summary' => "Vôsce luate da l'elenghe",
	'toplists-item-restored' => 'Vôsce repristinate',
	'toplists-list-related-to' => 'Riferite a:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />vote}}',
	'toplists-list-created-by' => 'da [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Vote',
	'toplists-list-hotitem-count' => "$1 {{PLURAL:$1|vote}} jndr'à $2",
	'toplists-list-add-item-label' => "Aggiunge 'na vôsce",
	'toplists-list-item-voted' => 'Vutate',
	'toplists-createpage-dialog-label' => 'Le megghie 10',
	'toplists-seconds' => '$1 {{PLURAL:$1|seconde}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minute}}',
	'toplists-hours' => '$1 {{PLURAL:$1|ore}}',
	'toplists-days' => '$1 {{PLURAL:$1|sciurne}}',
	'toplists-weeks' => '$1 {{PLURAL: $1|sumàne}}',
	'toplists-create-button-msg' => "Ccreje 'n'elenghe",
);

/** Russian (русский)
 * @author DCamer
 * @author Eleferen
 * @author Kuzura
 */
$messages['ru'] = array(
	'toplists-desc' => 'Список Топ 10',
	'right-toplists-create-edit-list' => 'Создание и редактирование страниц списка топ-10',
	'right-toplists-create-item' => 'Создание и добавление элементов на страницу списка топ-10',
	'right-toplists-edit-item' => 'Изменение элементов на странице списка топ-10',
	'right-toplists-delete-item' => 'Удаление элементов из списка на странице списка топ-10',
	'createtoplist' => 'Создание нового списка топ-10',
	'edittoplist' => 'Изменить список топ-10',
	'toplists-category' => 'Списки топ-10',
	'toplists-error-invalid-title' => 'Прилагаемый текст является недопустимым.',
	'toplists-error-invalid-picture' => 'Выбранное изображение является недопустимым.',
	'toplists-error-title-exists' => 'Эта страница уже существует. Вы можете перейти к <a href="$2" target="_blank">$1</a> или введите другое имя.',
	'toplists-error-title-spam' => 'Прилагаемый текст содержит несколько слов, признанных спамом.',
	'toplists-error-article-blocked' => 'Вы не можете создать страницу с таким названием. Извините.',
	'toplists-error-article-not-exists' => '"$1" не существует. Вы хотите <a href="$2" target="_blank">создать его</a>?',
	'toplists-error-picture-not-exists' => '"$1" не существует. Вы хотите <a href="$2" target="_blank">загрузить его</a>?',
	'toplists-error-duplicated-entry' => 'Вы не можете использовать такое же название несколько раз.',
	'toplists-error-empty-item-name' => 'Имя существующего элемента не может быть пустым.',
	'toplists-item-cannot-delete' => 'Ошибка при удалении этого элемента.',
	'toplists-error-image-already-exists' => 'Изображение с таким название уже существует.',
	'toplists-error-add-item-anon' => 'Анонимные пользователи не могут добавлять элементы в списки. Пожалуйста, <a class="ajaxLogin" id="login" href="$1">представьтесь</a> или <a href="$2">зарегистрируйтесь</a>.',
	'toplists-error-add-item-permission' => 'Ошибка прав: Вашей учетной записи не было предоставлено право на создание новых элементов.',
	'toplists-error-add-item-list-not-exists' => 'Список топ-10 с названием "$1" не существует.',
	'toplists-upload-error-unknown' => 'Произошла ошибка при обработке запроса загрузки. Пожалуйста, попробуйте еще раз.',
	'action-toplists-create-edit-list' => 'создать и отредактировать страницы списков Топ 10',
	'toplists-editor-title-label' => 'Название списка',
	'toplists-editor-title-placeholder' => 'Введите имя списка',
	'toplists-editor-related-article-label' => 'Связанные страницы <small>(необязательно, но выбирает изображение)</small>',
	'toplists-editor-related-article-placeholder' => 'Введите название существующей страницы',
	'toplists-editor-description-label' => 'Краткое описание вашего списка Топ 10',
	'toplists-editor-description-placeholder' => 'Введите описание',
	'toplists-editor-image-browser-tooltip' => 'Добавить изображение',
	'toplists-editor-remove-item-tooltip' => 'Удалить пункт',
	'toplists-editor-drag-item-tooltip' => 'Перетащите, чтобы изменить порядок',
	'toplists-editor-add-item-label' => 'Добавить новый пункт',
	'toplists-editor-add-item-tooltip' => 'Добавить новый элемент в список',
	'toplists-create-button' => 'Создать список',
	'toplists-update-button' => 'Сохранить список',
	'toplists-cancel-button' => 'Отмена',
	'toplists-items-removed' => 'Удалено: $1 {{PLURAL:$1|элемент|элемента|элементов}}',
	'toplists-items-created' => 'Создано: $1 {{PLURAL:$1|элемент|элемента|элементов}}',
	'toplists-items-updated' => 'Обновлено: $1 {{PLURAL:$1|элемент|элемента|элементов}}',
	'toplists-items-nochange' => 'Изменённых элементов нет',
	'toplits-image-browser-no-picture-selected' => 'Не выбрано изображение',
	'toplits-image-browser-clear-picture' => 'Очистить изображение',
	'toplits-image-browser-selected-picture' => 'Сейчас выбраны: $1',
	'toplists-image-browser-upload-btn' => 'Выбрать',
	'toplists-image-browser-upload-label' => 'Загрузить своё',
	'toplists-list-creation-summary' => 'Создание списка, $1',
	'toplists-list-update-summary' => 'Обновление списка, $1',
	'toplists-item-creation-summary' => 'Создание элемента списка',
	'toplists-item-update-summary' => 'Обновление элемента списка',
	'toplists-item-remove-summary' => 'Элемент удален из списка',
	'toplists-item-restored' => 'Элемент восстановлен',
	'toplists-list-related-to' => 'Связан с:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />голос|$1<br />голоса|$1<br />голосов}}',
	'toplists-list-created-by' => 'автор: [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Голосовать за',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|голос|голоса|голосов}} за $2',
	'toplists-list-add-item-label' => 'Добавить элемент',
	'toplists-list-add-item-name-label' => 'Список собирается...',
	'toplists-list-item-voted' => 'Проголосовало',
	'toplists-createpage-dialog-label' => 'Список топ-10',
	'toplists-email-subject' => 'Был изменен список топ-10',
	'toplists-email-body' => 'Привет из Викии!

Список <a href="$1">$2</a> на Викии был изменён.

 $3

Бегом в Викию, и проверьте изменения! $1

- Wikia

Вы можете <a href="$4">отписаться</a> от изменений в списке.',
	'toplists-seconds' => '$1 {{PLURAL:$1|секунда|секунды|секунд}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|минута|минуты|минут}}',
	'toplists-hours' => '$1 {{PLURAL:$1|час|часа|часов}}',
	'toplists-days' => '$1 {{PLURAL:$1|день|дня|дней}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|неделя|недели|недель}}',
	'toplists-msg-fb-OnRateArticle-short' => 'проголосовал в списке топ-10 на $WIKINAME!',
	'toplists-create-heading' => '<em>Новинка!</em> Создайте свой ​​собственный топ-10',
	'toplists-create-button-msg' => 'Создать список',
	'toplists-oasis-only' => 'Создание и редактирование списков Топ 10 не доступно в Monobook. Если вы хотите использовать эту функцию, переключите ваш скин на Викия.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'edittoplist' => 'Уреди топ 10 листу',
	'toplists-category' => 'Топ 10 листе',
	'toplists-error-invalid-title' => 'Наведени текст није исправан.',
	'toplists-error-invalid-picture' => 'Наведена слика није исправна.',
	'toplists-error-empty-item-name' => 'Назив ставке не сме остати празан.',
	'toplists-item-cannot-delete' => 'Брисање ставке није успело.',
	'toplists-error-image-already-exists' => 'Слика с истим називом већ постоји.',
	'toplists-error-add-item-list-not-exists' => '„$1“ топ 10 листа не постоји.',
	'toplists-editor-title-label' => 'Назив списка',
	'toplists-editor-title-placeholder' => 'Унесите назив списка',
	'toplists-editor-related-article-label' => 'Сродна страница <small>(необавезно)</small>',
	'toplists-editor-related-article-placeholder' => 'Унесите назив странице',
	'toplists-editor-image-browser-tooltip' => 'Додајте слику',
	'toplists-editor-remove-item-tooltip' => 'Уклоните ставку',
	'toplists-create-button' => 'Направи списак',
	'toplists-update-button' => 'Сачувај списак',
	'toplists-cancel-button' => 'Откажи',
	'toplists-items-removed' => '$1 {{PLURAL:$1|ставка је уклоњена|ставке су уклоњене|ставки је уклоњено}}',
	'toplists-items-created' => '$1 {{PLURAL:$1|ставка је направљена|ставке су направљене|ставки је направљено}}',
	'toplists-items-updated' => '$1 {{PLURAL:$1|ставка је ажурирана|ставке су ажуриране|ставки је ажурирано}}',
	'toplists-items-nochange' => 'Нема измењених ставки',
	'toplits-image-browser-no-picture-selected' => 'Нема изабраних слика',
	'toplits-image-browser-clear-picture' => 'Очисти слику',
	'toplits-image-browser-selected-picture' => 'Изабрано: $1',
	'toplists-image-browser-upload-btn' => 'Изабери',
	'toplists-image-browser-upload-label' => 'Отпремање',
	'toplists-list-creation-summary' => 'Прављење списка, $1',
	'toplists-item-creation-summary' => 'Прављење списка ставки',
	'toplists-item-update-summary' => 'Ажурирање списка ставки',
	'toplists-item-remove-summary' => 'Ставка је уклоњена са списка',
	'toplists-item-restored' => 'Ставка је враћена',
	'toplists-list-related-to' => 'Повезано са:',
	'toplists-list-created-by' => 'од члана [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Гласај',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|глас|гласа|гласова}} у $2',
	'toplists-list-add-item-label' => 'Додај ставку',
	'toplists-list-add-item-name-label' => 'Настави са списком...',
	'toplists-list-item-voted' => 'Гласано',
	'toplists-createpage-dialog-label' => 'Топ 10 листа',
	'toplists-email-subject' => 'Топ 10 листа је промењена',
	'toplists-seconds' => '$1 {{PLURAL:$1|секунда|секунде|секунди}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|минут|минута|минута}}',
	'toplists-hours' => '$1 {{PLURAL:$1|сат|сата|сати}}',
	'toplists-days' => '$1 {{PLURAL:$1|дан|дана|дана}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|недеља|недеље|недеља}}',
	'toplists-create-heading' => '<em>Ново!</em> Направите топ 10',
	'toplists-create-button-msg' => 'Направи списак',
);

/** Swedish (svenska)
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'toplists-desc' => 'Topp 10-listor',
	'right-toplists-create-edit-list' => 'Skapa och redigera Topp 10-listsidor',
	'right-toplists-create-item' => 'Skapa och lägga till objekt till en Topp 10-listsida',
	'right-toplists-edit-item' => 'Redigera objekt i en Topp 10-listsida',
	'right-toplists-delete-item' => 'Ta bort objekt från en Topp 10-listsida',
	'createtoplist' => 'Skapa en ny Topp 10-lista',
	'edittoplist' => 'Redigera Topp 10-lista',
	'toplists-category' => 'Topp 10-listor',
	'toplists-error-invalid-title' => 'Den medföljande texten är inte giltig.',
	'toplists-error-invalid-picture' => 'Den valda bilden är inte giltig.',
	'toplists-error-title-exists' => 'Den här sidan finns redan. Du kan gå till <a href="$2" target="_blank">$1</a> eller ge den ett annat namn.',
	'toplists-error-title-spam' => 'Den medföljande texten innehåller en del ord som räknas som spam.',
	'toplists-error-article-blocked' => 'Du har inte tillåtelse att skapa en sida med detta namn. Tyvärr.',
	'toplists-error-article-not-exists' => '"$1" existerar inte. Vill du <a href="$2" target="_blank">skapa den</a>?',
	'toplists-error-picture-not-exists' => '"$1" existerar inte. Vill du <a href="$2" target="_blank">ladda upp den</a>?',
	'toplists-error-duplicated-entry' => 'Du kan inte använda samma namn mer än en gång.',
	'toplists-error-empty-item-name' => 'Namnet på ett befintligt objekt kan inte vara tomt.',
	'toplists-item-cannot-delete' => 'Borttagning av detta objektet misslyckades.',
	'toplists-error-image-already-exists' => 'En bild med samma namn finns redan.',
	'toplists-error-add-item-anon' => 'Anonyma användare är inte tillåtna att lägga till objekt i listor. Vänligen <a class="ajaxLogin" id="login" href="$1">logga in</a> eller <a href="$2">registrera ett konto</a>.',
	'toplists-error-add-item-permission' => 'Tillståndsfel: Ditt konto har inte beviljats rätten att skapa nya objekt.',
	'toplists-error-add-item-list-not-exists' => 'Topp 10-listan "$1" finns inte.',
	'toplists-upload-error-unknown' => 'Ett fel uppstod vid bearbetningen av uppladdningen. Försök igen.',
	'action-toplists-create-edit-list' => 'skapa och redigera Topp 10-listsidor',
	'toplists-editor-title-label' => 'Listnamn',
	'toplists-editor-title-placeholder' => 'Ange ett namn för listan',
	'toplists-editor-related-article-label' => 'Relaterad sida <small>(valfritt, men väljer en bild)</small>',
	'toplists-editor-related-article-placeholder' => 'Ange ett befintligt namn för en sida',
	'toplists-editor-description-label' => 'En kort beskrivning av din Topp 10-lista',
	'toplists-editor-description-placeholder' => 'Ange en beskrivning',
	'toplists-editor-image-browser-tooltip' => 'Lägg till en bild',
	'toplists-editor-remove-item-tooltip' => 'Ta bort objekt',
	'toplists-editor-drag-item-tooltip' => 'Dra för att ändra ordning',
	'toplists-editor-add-item-label' => 'Lägg till ett nytt objekt',
	'toplists-editor-add-item-tooltip' => 'Lägg till ett nytt objekt i listan',
	'toplists-create-button' => 'Skapa lista',
	'toplists-update-button' => 'Spara listan',
	'toplists-cancel-button' => 'Avbryt',
	'toplists-items-removed' => '$1 {{PLURAL:$1|objekt|objekt}} borttagna',
	'toplists-items-created' => '$1 {{PLURAL:$1|objekt|objekt}} skapade',
	'toplists-items-updated' => '$1 {{PLURAL:$1|objekt|objekt}} uppdaterade',
	'toplists-items-nochange' => 'Inga objekt ändrades',
	'toplits-image-browser-no-picture-selected' => 'Ingen bild markerad',
	'toplits-image-browser-clear-picture' => 'Rensa bild',
	'toplits-image-browser-selected-picture' => 'Markerade: $1',
	'toplists-image-browser-upload-btn' => 'Välj',
	'toplists-image-browser-upload-label' => 'Ladda upp dina egna',
	'toplists-list-creation-summary' => 'Skapar en lista, $1',
	'toplists-list-update-summary' => 'Uppdaterar en lista, $1',
	'toplists-item-creation-summary' => 'Skapar ett listobjekt',
	'toplists-item-update-summary' => 'Uppdaterar ett listobjekt',
	'toplists-item-remove-summary' => 'Objekt raderat från listan',
	'toplists-item-restored' => 'Objekt återställt',
	'toplists-list-related-to' => 'Relaterat till:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />röst|$1<br />röster}}',
	'toplists-list-created-by' => 'av [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Rösta upp',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|röst|röster}} i $2',
	'toplists-list-add-item-label' => 'Lägg till objekt',
	'toplists-list-add-item-name-label' => 'Håll igång listan...',
	'toplists-list-item-voted' => 'Röstat',
	'toplists-createpage-dialog-label' => 'Topp 10-lista',
	'toplists-email-subject' => 'En Topp 10-lista har ändrats',
	'toplists-email-body' => 'Ett hej från Wikia!

Listan <a href="$1">$2</a> på Wikia har blivit ändrad.

 $3

Besök Wikia för att kolla förändringarna! $1

- Wikia

Du kan <a href="$4">avbryta prenumerationen</a> från förändringslistan när du vill.',
	'toplists-seconds' => '$1 {{PLURAL:$1|sekund|sekunder}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minut|minuter}}',
	'toplists-hours' => '$1 {{PLURAL:$1|timme|timmar}}',
	'toplists-days' => '$1 {{PLURAL:$1|dag|dagar}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|vecka|veckor}}',
	'toplists-msg-fb-OnRateArticle-short' => 'har röstat på Topp 10 listan på $WIKINAME!',
	'toplists-create-heading' => '<em>Nyhet!</em> Skapa Din Egen Topp Tio',
	'toplists-create-button-msg' => 'Skapa en lista',
	'toplists-oasis-only' => 'Skapa och redigera Topp 10-listor är inte tillgängligt i Monobook. Om du vill använda denna funktion, var god byt till Wikia-skalet i dina inställningar.',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'toplists-cancel-button' => 'రద్దుచేయి',
	'toplists-seconds' => '$1 {{PLURAL:$1|క్షణం|క్షణాలు}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|నిమిషం|నిమిషాలు}}',
	'toplists-hours' => '$1 {{PLURAL:$1|గంట|గంటలు}}',
	'toplists-days' => '$1 {{PLURAL:$1|రోజు|రోజులు}}',
	'toplists-weeks' => '$1 {{PLURAL: $1|వారం|వారాలు}}',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 * @author TheSleepyhollow02
 */
$messages['tl'] = array(
	'toplists-desc' => 'Mga talaan ng pinakamatataas na 10',
	'right-toplists-create-edit-list' => 'Likhain at baguhin ang mga pahina ng talaan ng Nangungunang 10',
	'right-toplists-create-item' => 'Lumikha at idagdag ang mga bagay sa isang pahina ng talaan ng Pinakamataas na 10',
	'right-toplists-edit-item' => 'Baguhin ang mga bagay na nasa loob ng isang pahina ng talaan ng Nangungunang 10',
	'right-toplists-delete-item' => 'Magbura ng mga bagay na nasa loob ng isang pahina ng talaan ng Nangungunang 10',
	'createtoplist' => 'Lumikha ng isang bagong talaan ng Pinakamataas na 10',
	'edittoplist' => 'Baguhin ang talaan ng Pinakamataas na 10',
	'toplists-category' => 'Mga Talaan ng Pinakamatataas na 10',
	'toplists-error-invalid-title' => 'Hindi tanggap ang ibinigay na teksto.',
	'toplists-error-invalid-picture' => 'Hindi tanggap ang napiling larawan.',
	'toplists-error-title-exists' => 'Umiiral na ang pahinang ito. Makakapunta ka sa <a href="$2" target="_blank">$1</a> o magbigay ng isang ibang pangalan.',
	'toplists-error-title-spam' => 'Ang ibinigay na teksto ay naglalaman ng ilang mga salitang kinikilala bilang mga liham na manlulusob.',
	'toplists-error-article-blocked' => 'Hindi ka pinapayagang lumikha ng isang pahinang may ganitong pangalan. Paumanhin.',
	'toplists-error-article-not-exists' => 'Hindi umiiral ang "$1".  Nais mo bang <a href="$2" target="_blank">likhain ito</a>?',
	'toplists-error-picture-not-exists' => 'Hindi umiiral ang "$1".  Nais mo bang <a href="$2" target="_blank">ikargang papaitaas ito</a>?',
	'toplists-error-duplicated-entry' => 'Hindi mo magagamit ang katulad na pangalan nang mahigit sa isa.',
	'toplists-error-empty-item-name' => 'Ang pangalan ng isang umiiral na bagay ay hindi maaaring walang laman.',
	'toplists-item-cannot-delete' => 'Nabigo ang pagbubura ng bagay na ito.',
	'toplists-error-image-already-exists' => 'Umiiral na ang isang larawan na may katulad na pangalan.',
	'toplists-error-add-item-anon' => 'Ang hindi nakikilalang mga tagagamit ay hindi pinapayagang magdagdag ng mga bagay sa mga talaan. Mangyaring <a class="ajaxLogin" id="login" href="$1">Lumagdang papasok</a> o <a href="$2">magpatala ng isang bagong akawnt</a>.',
	'toplists-error-add-item-permission' => 'Kamalian sa pahintulot: Ang akawnt mo ay hindi nabigyan ng karapatan upang lumikha ng bagong mga bagay.',
	'toplists-error-add-item-list-not-exists' => 'Hindi umiiral ang talaan ng Pinakamataas na 10 ng "$1".',
	'toplists-upload-error-unknown' => 'Naganap ang isang kamalian habang isinasagawa ang hiling ng pagkakargang papaitaas. Mangyaring subukan muli.',
	'action-toplists-create-edit-list' => 'likhain at baguhin ang mga pahina ng talaan ng Nangungunang 10',
	'toplists-editor-title-label' => 'Pangalan ng talaan',
	'toplists-editor-title-placeholder' => 'Magpasok ng isang pangalan para sa talaan',
	'toplists-editor-related-article-label' => 'Kaugnay na pahina <small>(maaaring wala, subalit pumipili ng isang larawan)</small>',
	'toplists-editor-related-article-placeholder' => 'Magpasok ng isang umiiral na pangalan ng pahina',
	'toplists-editor-description-label' => 'Isang maiksing paglalarawan ng iyong Listahan ng Nangungunang 10',
	'toplists-editor-description-placeholder' => 'Magpasok ng isang paglalarawan',
	'toplists-editor-image-browser-tooltip' => 'Magdagdag ng isang larawan',
	'toplists-editor-remove-item-tooltip' => 'Tanggalin ang bagay',
	'toplists-editor-drag-item-tooltip' => 'Kaladkarin upang baguhin ang pagkakasunud-sunod',
	'toplists-editor-add-item-label' => 'Magdagdag ng isang bagong bagay',
	'toplists-editor-add-item-tooltip' => 'Magdagdag ng isang bagong bagay sa talaan',
	'toplists-create-button' => 'Likhain ang talaan',
	'toplists-update-button' => 'Sagipin ang talaan',
	'toplists-cancel-button' => 'Huwag ituloy',
	'toplists-items-removed' => '$1 {{PLURAL:$1|bagay|mga bagay}} ang natanggal',
	'toplists-items-created' => '$1 {{PLURAL:$1|bagay|mga bagay}} ang nalikha',
	'toplists-items-updated' => '$1 {{PLURAL:$1|bagay|mga bagay}} ang naisapanahon',
	'toplists-items-nochange' => 'Walang nabagong mga bagay',
	'toplits-image-browser-no-picture-selected' => 'Walang napiling larawan',
	'toplits-image-browser-clear-picture' => 'Hawiin ang larawan',
	'toplits-image-browser-selected-picture' => 'Kasalukuyang napili: $1',
	'toplists-image-browser-upload-btn' => 'Pumili',
	'toplists-image-browser-upload-label' => 'Ikargang paitaas ang mula sa sarili mo',
	'toplists-list-creation-summary' => 'Lumilikha ng isang talaan, $1',
	'toplists-list-update-summary' => 'Nagsasapanahon ng isang talaan, $1',
	'toplists-item-creation-summary' => 'Lumilikha ng isang bagay sa talaan',
	'toplists-item-update-summary' => 'Nagsasapanahon ng isang bagay sa talaan',
	'toplists-item-remove-summary' => 'Tinanggal ang bagay mula sa talaan',
	'toplists-item-restored' => 'Naipanumbalik ang bagay',
	'toplists-list-related-to' => 'Kaugnay ng:',
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />boto|$1<br />mga boto}}',
	'toplists-list-created-by' => 'ni [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Bumotong paitaas',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|boto|mga boto}} sa $2',
	'toplists-list-add-item-label' => 'Idagdag ang bagay',
	'toplists-list-add-item-name-label' => 'Panatilihing nagpapatuloy ang talaan...',
	'toplists-list-item-voted' => 'Nakaboto na',
	'toplists-createpage-dialog-label' => 'Talaan ng Pinakamataas na 10',
	'toplists-email-subject' => 'Binago ang isang talaan ng Pinakamataas na 10',
	'toplists-email-body' => 'Kumusta mula sa Wikia! 

Ang talaang <a href="$1">$2</a> sa Wikia ay nabago. 

 $3 

Tumungo sa Wikia upang suriin ang mga pagbabago! $1 

 - Wikia 

 Maaari kang <a href="$4">huwag tumanggap</a> ng mga pagbabago sa talaan.',
	'toplists-seconds' => '$1 {{PLURAL:$1|segundo|mga segundo}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|minuto|mga minuto}}',
	'toplists-hours' => '$1 {{PLURAL:$1|oras|mga oras}}',
	'toplists-days' => '$1 {{PLURAL:$1|araw|mga araw}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|linggo|mga linggo}}',
	'toplists-msg-fb-OnRateArticle-short' => 'ay bumoto sa isang talaan ng Pinakamataas na 10 sa $WIKINAME!',
	'toplists-create-heading' => '<em>Bago!</em> Lumikha Ng Sarili Mong Nangungunang Sampu',
	'toplists-create-button-msg' => 'Lumikha ng isang talaan',
	'toplists-oasis-only' => 'Ang paggawa at pagmamatnugot ng nangungunang 10 listahan ay hindi maari sa Monobook. Kung gusto mo na magamit ang katangian na ito, manyaring ilipat ang iyong mga nais sa pabalat ng Wikia.',
);

/** Turkish (Türkçe)
 * @author Emperyan
 */
$messages['tr'] = array(
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />oy|$1<br />oy}}',
);

/** Ukrainian (українська)
 * @author Andriykopanytsia
 * @author Pig1995z
 * @author Steve.rusyn
 * @author SteveR
 */
$messages['uk'] = array(
	'toplists-desc' => 'Список Топ 10',
	'right-toplists-create-edit-list' => 'Створення і редагування сторінок списку топ-10',
	'right-toplists-create-item' => 'Створення і додавання елементів на сторінку списку топ-10',
	'right-toplists-edit-item' => 'Редагувати елементи на сторінці списку 10 найпопулярніших',
	'right-toplists-delete-item' => 'Вилучити елементи зі сторінки списку 10 найпопулярніших',
	'createtoplist' => 'Створити новий список 10 найпопулярніших',
	'edittoplist' => 'Редагувати список 10 найпопулярніших',
	'toplists-category' => 'Списки 10 найпопулярніших',
	'toplists-error-invalid-title' => 'Прикладений текст є неприпустимим.',
	'toplists-error-invalid-picture' => 'Обране зображення є неприпустимим.',
	'toplists-error-title-exists' => 'Ця сторінка вже існує. Ви можете перейти до <a href="$2" target="_blank">$1</a> або вказати інше ім\'я.',
	'toplists-error-title-spam' => 'Прикладений текст містить кілька слів, розпізнаних як спам.',
	'toplists-error-article-blocked' => 'Вам не дозволено створити сторінку з таким іменем. Вибачте.',
	'toplists-error-article-not-exists' => '"$1" не існує. Ви хочете <a href="$2" target="_blank"> створити його</a>?',
	'toplists-error-picture-not-exists' => '"$1" не існує. Ви хочете <a href="$2" target="_blank">завантажити його</a>?',
	'toplists-error-duplicated-entry' => "Не можна використовувати однакове ім'я більше одного разу.",
	'toplists-error-empty-item-name' => "Ім'я існуючого елемента не може бути порожнім.",
	'toplists-item-cannot-delete' => 'Не вдалося видалити цей елемент.',
	'toplists-error-image-already-exists' => 'Зображення з такою назвою вже існує.',
	'toplists-error-add-item-anon' => 'Анонімні користувачі не зможуть додавати елементи в списки. Будь ласка, <a class="ajaxLogin" id="login" href="$1">увійдіть</a> або <a href="$2">зареєструйте новий обліковий запис</a>.',
	'toplists-error-add-item-permission' => 'Помилка дозволів: обліковому запису не надано право на створення нових елементів.',
	'toplists-error-add-item-list-not-exists' => 'Список 10 популярних з назвою "$1" не існує.',
	'toplists-upload-error-unknown' => 'Сталася помилка під час обробки запиту. Будь ласка, спробуйте ще раз.',
	'action-toplists-create-edit-list' => 'створити та редагувати список 10 популярних сторінок',
	'toplists-editor-title-label' => "Ім'я списку",
	'toplists-editor-title-placeholder' => "Введіть ім'я списку",
	'toplists-editor-related-article-label' => "Пов'язані сторінки <small>(необов'язково, але вибирає зображення)</small>",
	'toplists-editor-related-article-placeholder' => 'Введіть існуючу назву сторінки',
	'toplists-editor-description-label' => 'Короткий опис списку 10 популярних',
	'toplists-editor-description-placeholder' => 'Введіть опис',
	'toplists-editor-image-browser-tooltip' => 'Додати зображення',
	'toplists-editor-remove-item-tooltip' => 'Видалити елемент',
	'toplists-editor-drag-item-tooltip' => 'Перетягніть, щоб змінити порядок',
	'toplists-editor-add-item-label' => 'Додати новий елемент',
	'toplists-editor-add-item-tooltip' => 'Додати новий елемент до списку',
	'toplists-create-button' => 'Створити список',
	'toplists-update-button' => 'Зберегти список',
	'toplists-cancel-button' => 'Скасувати',
	'toplists-items-removed' => 'Вилучено $1 {{PLURAL:$1|елемент|елементи|елементів}}',
	'toplists-items-created' => 'Створено: $1 {{PLURAL:$1|елемент|елементи|елементів}}',
	'toplists-items-updated' => 'Оновлено: $1 {{PLURAL:$1|елемент|елементи|елементів}}',
	'toplists-items-nochange' => 'Немає змінених елементів',
	'toplits-image-browser-no-picture-selected' => 'Немає вибраних зображень',
	'toplits-image-browser-clear-picture' => 'Очистити зображення',
	'toplits-image-browser-selected-picture' => 'Зараз вибрано: $1',
	'toplists-image-browser-upload-btn' => 'Вибрати',
	'toplists-image-browser-upload-label' => 'Завантажити своє власне',
	'toplists-list-creation-summary' => 'Створення списку, $1',
	'toplists-list-update-summary' => 'Оновлення списку, $1',
	'toplists-item-creation-summary' => 'Створення елемента списку',
	'toplists-item-update-summary' => 'Оновлення елемента списку',
	'toplists-item-remove-summary' => 'Елемент видалено зі списку',
	'toplists-item-restored' => 'Відновлено елемент',
	'toplists-list-related-to' => "Пов'язано з:",
	'toplists-list-votes-num' => '{{PLURAL:$1|1<br />голос|$1<br />голоси|$1<br />голосів}}',
	'toplists-list-created-by' => 'від [[User:$1|$1]]',
	'toplists-list-vote-up' => 'Голосувати за',
	'toplists-list-hotitem-count' => '$1 {{PLURAL:$1|голос|голоси|голосів}} за $2',
	'toplists-list-add-item-label' => 'Додати елемент',
	'toplists-list-add-item-name-label' => 'Список збирається...',
	'toplists-list-item-voted' => 'Проголосували',
	'toplists-createpage-dialog-label' => 'Список 10 найпопулярніших',
	'toplists-email-subject' => 'Список 10 популярних був змінений',
	'toplists-email-body' => 'Вітання із Вікії!

Список <a href="$1">$2</a> на Вікії вже змінено.

 $3

Перейдіть на Вікія для перевірки змін! $1

- Вікія

Ви можете <a href="$4">відписатися</a> від змін у списку.',
	'toplists-seconds' => '$1 {{PLURAL:$1|секунда|секунди|секунд}}',
	'toplists-minutes' => '$1 {{PLURAL:$1|хвилина|хвилини|хвилин}}',
	'toplists-hours' => '$1 {{PLURAL:$1|година|години|годин}}',
	'toplists-days' => '$1 {{PLURAL:$1|день|дні|днів}}',
	'toplists-weeks' => '$1 {{PLURAL:$1|тиждень|тижня|тижнів}}',
	'toplists-msg-fb-OnRateArticle-short' => 'проголосував(ла) за список 10 популярних на $WIKINAME!',
	'toplists-create-heading' => '<em>Новинка!</em> Створіть свою власну першу десятку популярних',
	'toplists-create-button-msg' => 'Створити список',
	'toplists-oasis-only' => 'Створення та редагування списків 10 популярних недоступне в Monobook. Якщо ви хотіли б скористатися цією функцією, то, будь ласка, перемкніть ваші налаштування на оболонку Вікія.',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Dimension
 * @author Hydra
 * @author Hzy980512
 */
$messages['zh-hans'] = array(
	'toplists-error-duplicated-entry' => '该名称不可重复使用。',
	'toplists-editor-title-label' => '列表名称',
	'toplists-editor-title-placeholder' => '为列表命名',
	'toplists-editor-description-placeholder' => '输入描述',
	'toplists-editor-image-browser-tooltip' => '添加图片',
	'toplists-editor-remove-item-tooltip' => '移除项目',
	'toplists-editor-drag-item-tooltip' => '拖拽以改变顺序',
	'toplists-editor-add-item-label' => '添加新项目',
	'toplists-editor-add-item-tooltip' => '往列表中添加新项目',
	'toplists-create-button' => '创建列表',
	'toplists-update-button' => '保存列表',
	'toplists-cancel-button' => '取消',
	'toplists-items-removed' => '移除了$1个项目',
	'toplists-items-created' => '创建了$1个项目',
	'toplists-items-updated' => '更新了$1个项目',
	'toplists-items-nochange' => '没有修改项目',
	'toplits-image-browser-no-picture-selected' => '没有图片被选中',
	'toplists-image-browser-upload-btn' => '选择',
	'toplists-image-browser-upload-label' => '上载您自己的',
	'toplists-item-creation-summary' => '创建新的列表项',
	'toplists-list-add-item-label' => '添加东西',
	'toplists-list-item-voted' => '投票了',
	'toplists-email-body' => '来自Wikia的问候！

该列表<a href="$1">$2</a>在Wikia上已被修改。

 $3

前往Wikia去查看改变吧！$1

- Wikia

您可以<a href="$4">退订</a>本列表的变动。',
	'toplists-create-button-msg' => '创建列表',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Ffaarr
 */
$messages['zh-hant'] = array(
	'toplists-list-item-voted' => '投票了',
);
