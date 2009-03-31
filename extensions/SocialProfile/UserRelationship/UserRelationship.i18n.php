<?php
/**
 * Internationalisation file for UserRelationship extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author David Pean
 */
$messages['en'] = array(
	'viewrelationships' => 'View relationship',
	'viewrelationshiprequests' => 'View relationship requests',
	'ur-already-submitted' => 'Your request has been sent',
	'ur-error-page-title' => 'Woops!',
	'ur-error-title' => 'Whoops, you took a wrong turn!',
	'ur-error-message-no-user' => 'We cannot complete your request, because no user with this name exists.',
	'ur-main-page' => 'Main page',
	'ur-your-profile' => 'Your profile',
	'ur-backlink' => '&lt; Back to $1\'s profile',
	'ur-relationship-count-foes' => '$1 has $2 {{PLURAL:$2|foe|foes}}. Want more foes? <a href="$3">Invite them.</a>',
	'ur-relationship-count-friends' => '$1 has $2 {{PLURAL:$2|friend|friends}}. Want more friends? <a href="$3">Invite them.</a>',
	'ur-add-friends' => ' Want more friends? <a href="$1">Invite them</a>',
	'ur-add-friend' => 'Add as friend',
	'ur-add-foe' => 'Add as foe',
	'ur-add-no-user' => 'No user selected.
Please request friends/foes through the correct link.',
	'ur-add-personal-message' => 'Add a personal message',
	'ur-remove-relationship-friend' => 'Remove as friend',
	'ur-remove-relationship-foe' => 'Remove as foe',
	'ur-give-gift' => 'Give a gift',
	'ur-previous' => 'prev',
	'ur-next' => 'next',
	'ur-remove-relationship-title-foe' => 'Do you want to remove $1 as your foe?',
	'ur-remove-relationship-title-confirm-foe' => 'You have removed $1 as your foe',
	'ur-remove-relationship-title-friend' => 'Do you want to remove $1 as your friend?',
	'ur-remove-relationship-title-confirm-friend' => 'You have removed $1 as your friend',
	'ur-remove-relationship-message-foe' => 'You have requested to remove $1 as your foe, press "$2" to confirm.',
	'ur-remove-relationship-message-confirm-foe' => 'You have successfully removed $1 as your foe.',
	'ur-remove-relationship-message-friend' => 'You have requested to remove $1 as your friend, press "$2" to confirm.',
	'ur-remove-relationship-message-confirm-friend' => 'You have successfully removed $1 as your friend.',
	'ur-remove-error-message-no-relationship' => 'You do not have a relationship with $1.',
	'ur-remove-error-message-remove-yourself' => 'You cannot remove yourself.',
	'ur-remove-error-message-pending-foe-request' => 'You have a pending foe request with $1.',
	'ur-remove-error-message-pending-friend-request' => 'You have a pending friend request with $1.',
	'ur-remove-error-not-loggedin-foe' => 'You have to be logged in to remove a foe.',
	'ur-remove-error-not-loggedin-friend' => 'You have to be logged in to remove a friend.',
	'ur-remove' => 'Remove',
	'ur-cancel' => 'Cancel',
	'ur-login' => 'Login',
	'ur-add-title-foe' => 'Do you want to add $1 as your foe?',
	'ur-add-title-friend' => 'Do you want to add $1 as your friend?',
	'ur-add-message-foe' => 'You are about to add $1 as your foe.
We will notify $1 to confirm your grudge.',
	'ur-add-message-friend' => 'You are about to add $1 as your friend.
We will notify $1 to confirm your friendship.',
	'ur-add-button-foe' => 'Add as foe',
	'ur-add-button-friend' => 'Add as friend',
	'ur-add-sent-title-foe' => 'We have sent your foe request to $1!',
	'ur-add-sent-title-friend' => 'We have sent your friend request to $1!',
	'ur-add-sent-message-foe' => 'Your foe request has been sent to $1 for confirmation.
If $1 confirms your request, you will receive a follow-up e-mail',
	'ur-add-sent-message-friend' => 'Your friend request has been sent to $1 for confirmation.
If $1 confirms your request, you will receive a follow-up e-mail',
	'ur-add-error-message-no-user' => 'The user you are trying to add does not exist.',
	'ur-add-error-message-blocked' => 'You are currently blocked and cannot add friends or foes.',
	'ur-add-error-message-yourself' => 'You cannot add yourself as a friend or foe.',
	'ur-add-error-message-existing-relationship-foe' => 'You are already foes with $1.',
	'ur-add-error-message-existing-relationship-friend' => 'You are already friends with $1.',
	'ur-add-error-message-pending-request-title' => 'Patience!',
	'ur-add-error-message-pending-friend-request' => 'You have a pending friend request with $1.
We will notify you when $1 confirms your request.',
	'ur-add-error-message-pending-foe-request' => 'You have a pending foe request with $1.
We will notify you when $1 confirms your request.',
	'ur-add-error-message-not-loggedin-foe' => 'You must be logged in to add a foe',
	'ur-add-error-message-not-loggedin-friend' => 'You must be logged in to add a friend',
	'ur-requests-title' => 'Relationship requests',
	'ur-requests-message-foe' => '<a href="$1">$2</a> wants to be your foe.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> wants to be your friend.',
	'ur-accept' => 'Accept',
	'ur-reject' => 'Reject',
	'ur-no-requests-message' => 'You have no friend or foe requests.
If you want more friends, <a href="$1">invite them!</a>',
	'ur-requests-added-message-foe' => 'You have added $1 as your foe.',
	'ur-requests-added-message-friend' => 'You have added $1 as your friend.',
	'ur-requests-reject-message-friend' => 'You have rejected $1 as your friend.',
	'ur-requests-reject-message-foe' => 'You have rejected $1 as your foe.',
	'ur-title-foe' => "$1's foe list",
	'ur-title-friend' => "$1's friend list",
	'friend_request_subject' => '$1 has added you as a friend on {{SITENAME}}!',
	'friend_request_body' => 'Hi $1:

$2 has added you as a friend on {{SITENAME}}.  We want to make sure that you two are actually friends.

Please click this link to confirm your friendship:
$3

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'foe_request_subject' => 'It\'s war! $1 has added you to as a foe on {{SITENAME}}!',
	'foe_request_body' => 'Hi $1:

$2 just listed you as a foe on {{SITENAME}}.  We want to make sure that you two are actually mortal enemies or at least having an argument.

Please click this link to confirm the grudge match.

$3

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',

	'friend_accept_subject' => '$1 has accepted your friend request on {{SITENAME}}!',
	'friend_accept_body' => 'Hi $1:

$2 has accepted your friend request on {{SITENAME}}!

Check out $2\'s page at $3

Thanks,

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'foe_accept_subject' => 'It\'s on! $1 has accepted your foe request on {{SITENAME}}!',
	'foe_accept_body' => 'Hi $1:

$2 has accepted your foe request on {{SITENAME}}!

Check out $2\'s page at $3

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'friend_removed_subject' => 'Oh no! $1 has removed you as a friend on {{SITENAME}}!',
	'friend_removed_body' => 'Hi $1:

$2 has removed you as a friend on {{SITENAME}}!

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'foe_removed_subject' => 'Woohoo! $1 has removed you as a foe on {{SITENAME}}!',
	'foe_removed_body' => 'Hi $1:

	$2 has removed you as a foe on {{SITENAME}}!

Perhaps you two are on your way to becoming friends?

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'ur-main-page' => 'Pej Maha',
	'ur-cancel' => "Mao'ạki",
	'ur-login' => 'Surum',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'ur-main-page' => 'Piälehyt',
	'ur-cancel' => 'Keskevytä',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'ur-main-page' => 'Matapatu Lau',
	'ur-cancel' => 'Tiaki',
	'ur-login' => 'Hu ki loto',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'ur-main-page' => 'Tuisblad',
	'ur-previous' => 'vorige',
	'ur-next' => 'volgende',
	'ur-remove' => 'Skrap',
	'ur-cancel' => 'Kanselleer',
	'ur-login' => 'Inteken',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'ur-main-page' => 'ዋና ገጽ',
	'ur-friend' => 'ወዳጅ',
	'ur-foe' => 'ጠላት',
	'ur-add-friend' => 'እንደ ወዳጅ ለመጨምር',
	'ur-add-foe' => 'እንደ ጠላት ለመጨምር',
	'ur-next' => 'ቀጥሎ',
	'ur-add-button-friend' => 'እንደ ወዳጅ ለመጨምር',
	'ur-add-error-message-pending-request-title' => 'ትዕግሥት!',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'viewrelationships' => 'عرض العلاقة',
	'viewrelationshiprequests' => 'اعرض طلبات العلاقات',
	'ur-already-submitted' => 'طلبك تم إرساله',
	'ur-error-page-title' => 'آه!',
	'ur-error-title' => 'آه، أنت أخذت منحنيا خاطئا!',
	'ur-error-message-no-user' => 'لا يمكننا استكمال طلبك، لأنه لا يوجد مستخدم بهذا الاسم.',
	'ur-main-page' => 'الصفحة الرئيسية',
	'ur-your-profile' => 'ملفك',
	'ur-backlink' => '&lt; رجوع إلى ملف $1',
	'ur-friend' => 'صديق',
	'ur-foe' => 'عدو',
	'ur-relationship-count-foes' => '$1 لديه $2 {{PLURAL:$2|عدو|عدو}}. تريد المزيد من الأعداء؟ <a href="$3">ادعهم.</a>',
	'ur-relationship-count-friends' => '$1 لديه $2 {{PLURAL:$2|صديق|صديق}}. تريد المزيد من الأصدقاء؟ <a href="$3">ادعهم.</a>',
	'ur-add-friends' => '  تريد المزيد من الأصدقاء؟ <a href="$1">أدعهم</a>',
	'ur-add-friend' => 'أضف كصديق',
	'ur-add-foe' => 'أضف كعدو',
	'ur-add-no-user' => 'لا مستخدم تم اختياره.
من فضلك اطلب الأصدقاء/الأعداء من خلال الوصلة الصحيحة.',
	'ur-add-personal-message' => 'إضافة رسالة شخصية',
	'ur-remove-relationship-friend' => 'إزالة كصديق',
	'ur-remove-relationship-foe' => 'إزالة كعدو',
	'ur-give-gift' => 'أعط هدية',
	'ur-previous' => 'قبل',
	'ur-next' => 'بعد',
	'ur-remove-relationship-title-foe' => 'هل تريد إزالة $1 كعدوك؟',
	'ur-remove-relationship-title-confirm-foe' => 'أنت أزلت $1 كعدوك',
	'ur-remove-relationship-title-friend' => 'هل تريد إزالة $1 كصديقك؟',
	'ur-remove-relationship-title-confirm-friend' => 'أنت أزلت $1 كصديقك',
	'ur-remove-relationship-message-foe' => 'أنت طلبت إزالة $1 كعدوك، اضغط "$2" للتأكيد.',
	'ur-remove-relationship-message-confirm-foe' => 'أنت أزلت بنجاح $1 كعدوك.',
	'ur-remove-relationship-message-friend' => 'أنت طلبت إزالة $1 كصديقك، اضغط "$2" للتأكيد.',
	'ur-remove-relationship-message-confirm-friend' => 'أنت أزلت بنجاح $1 كصديقك.',
	'ur-remove-error-message-no-relationship' => 'لا تمتلك أي علاقة مع $1.',
	'ur-remove-error-message-remove-yourself' => 'لا يمكنك أن تزيل نفسك.',
	'ur-remove-error-message-pending-request' => 'لديك طلب $1 قيد الانتظار مع $2.',
	'ur-remove-error-message-pending-foe-request' => 'لديك طلب عداوة قيد الانتظار مع $1.',
	'ur-remove-error-message-pending-friend-request' => 'لديك طلب صداقة قيد الانتظار مع $1.',
	'ur-remove-error-not-loggedin' => 'أنت ينبغي أن تكون مسجل الدخول لإزالة $1.',
	'ur-remove-error-not-loggedin-foe' => 'يجب أن تكون مسجل الدخول لإزالة عدو.',
	'ur-remove-error-not-loggedin-friend' => 'يجب أن تكون مسجل الدخول لإزالة صديق.',
	'ur-remove' => 'أزل',
	'ur-cancel' => 'إلغاء',
	'ur-login' => 'دخول',
	'ur-add-title-foe' => 'هل تريد إضافة $1 كعدوك؟',
	'ur-add-title-friend' => 'هل تريد إضافة $1 كصديقك؟',
	'ur-add-message-foe' => 'أنت على وشك إضافة $1 كعدوك.
سنخطر $1 لتأكيد عداوتك.',
	'ur-add-message-friend' => 'أنت على وشك إضافة $1 كصديقك.
سنخطر $1 لتأكيد صداقتك.',
	'ur-friendship' => 'صداقة',
	'ur-grudge' => 'ضغينة',
	'ur-add-button' => 'أضف ك$1',
	'ur-add-button-foe' => 'إضافة كعدو',
	'ur-add-button-friend' => 'إضافة كصديق',
	'ur-add-sent-title-foe' => 'لقد أرسلنا طلب عداوتك إلى $1!',
	'ur-add-sent-title-friend' => 'لقد أرسلنا طلب صداقتك إلى $1!',
	'ur-add-sent-message-foe' => 'طلب عداوتك تم إرساله إلى $1 للتأكيد.
لو أن $1 أكد طلبك، ستتلقى بريد متابعة',
	'ur-add-sent-message-friend' => 'طلب صداقتك تم إرساله إلى $1 للتأكيد.
لو أن $1 أكد طلبك، ستتلقى بريد متابعة',
	'ur-add-error-message-no-user' => 'المستخدم الذي تحاول أن تضيفه غير موجود.',
	'ur-add-error-message-blocked' => 'أنت حاليا ممنوع ولا يمكنك إضافة أصدقاء أو أعداء.',
	'ur-add-error-message-yourself' => 'أنت لا يمكنك إضافة نفسك كصديق أو عدو.',
	'ur-add-error-message-existing-relationship' => 'أنت بالفعل $1 مع $2.',
	'ur-add-error-message-existing-relationship-foe' => 'أنت بالفعل عدو $1.',
	'ur-add-error-message-existing-relationship-friend' => 'أنت بالفعل صديق $1.',
	'ur-add-error-message-pending-request-title' => 'صبرا!',
	'ur-add-error-message-pending-friend-request' => 'لديك طلب صداقة قيد الانتظار مع $1.
سنخطرك عندما $1 يؤكد طلبك.',
	'ur-add-error-message-pending-foe-request' => 'لديك طلب عداوة قيد الانتظار مع $1.
سنخطرك عندما $1 يؤكد طلبك.',
	'ur-add-error-message-not-loggedin' => 'يجب أن تكون مسجلا دخولك لتضيف $1',
	'ur-add-error-message-not-loggedin-foe' => 'يجب أن تكون مسجل الدخول لإضافة عدو',
	'ur-add-error-message-not-loggedin-friend' => 'يجب أن تكون مسجل الدخول لإضافة صديق',
	'ur-requests-title' => 'طلبات العلاقات',
	'ur-requests-message-foe' => '<a href="$1">$2</a> يريد أن يكون عدوك.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> يريد أن يكون صديقك.',
	'ur-accept' => 'قبول',
	'ur-reject' => 'رفض',
	'ur-no-requests-message' => 'ليس لديك طلبات صداقة أو عداوة.
لو أنك تريد المزيد من الأصدقاء، <a href="$1">ادعوهم!</a>',
	'ur-requests-added-message-foe' => 'أنت أضفت $1 كعدوك.',
	'ur-requests-added-message-friend' => 'أنت أضفت $1 كصديقك.',
	'ur-requests-reject-message-friend' => 'أنت رفضت $1 كصديقك.',
	'ur-requests-reject-message-foe' => 'أنت رفضت $1 كعدوك.',
	'ur-title-foe' => 'قائمة أعداء $1',
	'ur-title-friend' => 'قائمة أصدقاء $1',
	'friend_request_subject' => '$1 أضافك كصديق في {{SITENAME}}!',
	'friend_request_body' => 'مرحبا $1:

$2 أضافك كصديق في {{SITENAME}}.  نريد التأكد من أنكما فعلا صديقان.

من فضلك اضغط هذه الوصلة لتأكيد صداقتك:
$3

شكرا

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'foe_request_subject' => 'إنها الحرب! $1 أضافك كعدو في {{SITENAME}}!',
	'foe_request_body' => 'مرحبا $1:

$2 أضافك حالا كعدو في {{SITENAME}}.  نريد التحقق من أنكما فعلا عدوان أو على الأقل بينكما خلاف.

من فضلك اضغط هذه الوصلة لتأكيد التطابق.

$3

شكرا

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'friend_accept_subject' => '$1 قبل طلب صداقتك في {{SITENAME}}!',
	'friend_accept_body' => 'مرحبا $1:

$2 قبل طلب صداقتك في {{SITENAME}}!

تحقق من صفحة $2 في $3

شكرا،

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'foe_accept_subject' => 'إنه يعمل! $1 قبل طلب عداوتك في {{SITENAME}}!',
	'foe_accept_body' => 'مرحبا $1:

$2 قبل طلب عداوتك في {{SITENAME}}!

تحقق من صفحة $2 في $3

شكرا

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإكتروني.',
	'friend_removed_subject' => 'كلا! أزالك $1 كصديق على {{SITENAME}}!',
	'friend_removed_body' => 'مرحبا $1:

$2 أزالك كصديق في {{SITENAME}}!

شكرا

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'foe_removed_subject' => 'هاه! $1 أزالك كعدو في {{SITENAME}}!',
	'foe_removed_body' => 'مرحبا $1:

$2 أزالك كعدو في {{SITENAME}}!

ربما أنتما الاثنان على الطريق لتكونا صديقين؟

شكرا

---

هل تريد التوقف عن تلقي رسائل بريد إلكتروني مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإكتروني.',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'viewrelationships' => 'عرض العلاقة',
	'viewrelationshiprequests' => 'اعرض طلبات العلاقات',
	'ur-already-submitted' => 'طلبك تم إرساله',
	'ur-error-page-title' => 'آه!',
	'ur-error-title' => 'آه، أنت أخذت منحنيا خاطئا!',
	'ur-error-message-no-user' => 'لا يمكننا استكمال طلبك، لأنه لا يوجد مستخدم بهذا الاسم.',
	'ur-main-page' => 'الصفحة الرئيسية',
	'ur-your-profile' => 'ملفك',
	'ur-backlink' => '&lt; رجوع إلى ملف $1',
	'ur-relationship-count-foes' => '$1 لديه $2 {{PLURAL:$2|عدو|عدو}}. تريد المزيد من الأعداء؟ <a href="$3">ادعهم.</a>',
	'ur-relationship-count-friends' => '$1 لديه $2 {{PLURAL:$2|صديق|صديق}}. تريد المزيد من الأصدقاء؟ <a href="$3">ادعهم.</a>',
	'ur-add-friends' => '  تريد المزيد من الأصدقاء؟ <a href="$1">أدعهم</a>',
	'ur-add-friend' => 'أضف كصديق',
	'ur-add-foe' => 'أضف كعدو',
	'ur-add-no-user' => 'لا مستخدم تم اختياره.
من فضلك اطلب الأصدقاء/الأعداء من خلال الوصلة الصحيحة.',
	'ur-add-personal-message' => 'إضافة رسالة شخصية',
	'ur-remove-relationship-friend' => 'إزالة كصديق',
	'ur-remove-relationship-foe' => 'إزالة كعدو',
	'ur-give-gift' => 'أعط هدية',
	'ur-previous' => 'قبل',
	'ur-next' => 'بعد',
	'ur-remove-relationship-title-foe' => 'هل تريد إزالة $1 كعدوك؟',
	'ur-remove-relationship-title-confirm-foe' => 'أنت أزلت $1 كعدوك',
	'ur-remove-relationship-title-friend' => 'هل تريد إزالة $1 كصديقك؟',
	'ur-remove-relationship-title-confirm-friend' => 'أنت أزلت $1 كصديقك',
	'ur-remove-relationship-message-foe' => 'أنت طلبت إزالة $1 كعدوك، اضغط "$2" للتأكيد.',
	'ur-remove-relationship-message-confirm-foe' => 'أنت أزلت بنجاح $1 كعدوك.',
	'ur-remove-relationship-message-friend' => 'أنت طلبت إزالة $1 كصديقك، اضغط "$2" للتأكيد.',
	'ur-remove-relationship-message-confirm-friend' => 'أنت أزلت بنجاح $1 كصديقك.',
	'ur-remove-error-message-no-relationship' => 'لا تمتلك أى علاقة مع $1.',
	'ur-remove-error-message-remove-yourself' => 'لا يمكنك أن تزيل نفسك.',
	'ur-remove-error-message-pending-foe-request' => 'لديك طلب عداوة قيد الانتظار مع $1.',
	'ur-remove-error-message-pending-friend-request' => 'لديك طلب صداقة قيد الانتظار مع $1.',
	'ur-remove-error-not-loggedin-foe' => 'يجب أن تكون مسجل الدخول لإزالة عدو.',
	'ur-remove-error-not-loggedin-friend' => 'يجب أن تكون مسجل الدخول لإزالة صديق.',
	'ur-remove' => 'أزل',
	'ur-cancel' => 'إلغاء',
	'ur-login' => 'دخول',
	'ur-add-title-foe' => 'هل تريد إضافة $1 كعدوك؟',
	'ur-add-title-friend' => 'هل تريد إضافة $1 كصديقك؟',
	'ur-add-message-foe' => 'أنت على وشك إضافة $1 كعدوك.
سنخطر $1 لتأكيد عداوتك.',
	'ur-add-message-friend' => 'أنت على وشك إضافة $1 كصديقك.
سنخطر $1 لتأكيد صداقتك.',
	'ur-add-button-foe' => 'إضافة كعدو',
	'ur-add-button-friend' => 'إضافة كصديق',
	'ur-add-sent-title-foe' => 'لقد أرسلنا طلب عداوتك إلى $1!',
	'ur-add-sent-title-friend' => 'لقد أرسلنا طلب صداقتك إلى $1!',
	'ur-add-sent-message-foe' => 'طلب عداوتك تم إرساله إلى $1 للتأكيد.
لو أن $1 أكد طلبك، ستتلقى بريد متابعة',
	'ur-add-sent-message-friend' => 'طلب صداقتك تم إرساله إلى $1 للتأكيد.
لو أن $1 أكد طلبك، ستتلقى بريد متابعة',
	'ur-add-error-message-no-user' => 'اليوزر اللى بتحاول تضيفه مش  موجود.',
	'ur-add-error-message-blocked' => 'أنت حاليا ممنوع ولا يمكنك إضافة أصدقاء أو أعداء.',
	'ur-add-error-message-yourself' => 'أنت لا يمكنك إضافة نفسك كصديق أو عدو.',
	'ur-add-error-message-existing-relationship-foe' => 'أنت بالفعل عدو $1.',
	'ur-add-error-message-existing-relationship-friend' => 'أنت بالفعل صديق $1.',
	'ur-add-error-message-pending-request-title' => 'صبرا!',
	'ur-add-error-message-pending-friend-request' => 'لديك طلب صداقة قيد الانتظار مع $1.
سنخطرك عندما $1 يؤكد طلبك.',
	'ur-add-error-message-pending-foe-request' => 'لديك طلب عداوة قيد الانتظار مع $1.
سنخطرك عندما $1 يؤكد طلبك.',
	'ur-add-error-message-not-loggedin-foe' => 'يجب أن تكون مسجل الدخول لإضافة عدو',
	'ur-add-error-message-not-loggedin-friend' => 'يجب أن تكون مسجل الدخول لإضافة صديق',
	'ur-requests-title' => 'طلبات العلاقات',
	'ur-requests-message-foe' => '<a href="$1">$2</a> يريد أن يكون عدوك.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> يريد أن يكون صديقك.',
	'ur-accept' => 'قبول',
	'ur-reject' => 'رفض',
	'ur-no-requests-message' => 'ليس لديك طلبات صداقة أو عداوة.
لو أنك تريد المزيد من الأصدقاء، <a href="$1">ادعوهم!</a>',
	'ur-requests-added-message-foe' => 'أنت أضفت $1 كعدوك.',
	'ur-requests-added-message-friend' => 'أنت أضفت $1 كصديقك.',
	'ur-requests-reject-message-friend' => 'أنت رفضت $1 كصديقك.',
	'ur-requests-reject-message-foe' => 'أنت رفضت $1 كعدوك.',
	'ur-title-foe' => 'قائمة أعداء $1',
	'ur-title-friend' => 'قائمة أصدقاء $1',
	'friend_request_subject' => '$1 أضافك كصديق فى {{SITENAME}}!',
	'friend_request_body' => 'مرحبا $1:

$2 أضافك كصديق فى {{SITENAME}}.  نريد التأكد من أنكما فعلا صديقان.

من فضلك اضغط هذه الوصلة لتأكيد صداقتك:
$3

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'foe_request_subject' => 'إنها الحرب! $1 أضافك كعدو فى {{SITENAME}}!',
	'foe_request_body' => 'مرحبا $1:

$2 أضافك حالا كعدو فى {{SITENAME}}.  نريد التحقق من أنكما فعلا عدوان أو على الأقل بينكما خلاف.

من فضلك اضغط هذه الوصلة لتأكيد التطابق.

$3

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'friend_accept_subject' => '$1 قبل طلب صداقتك فى {{SITENAME}}!',
	'friend_accept_body' => 'مرحبا $1:

$2 قبل طلب صداقتك فى {{SITENAME}}!

تحقق من صفحة $2 فى $3

شكرا،

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'foe_accept_subject' => 'إنه يعمل! $1 قبل طلب عداوتك فى {{SITENAME}}!',
	'foe_accept_body' => 'مرحبا $1:

$2 قبل طلب عداوتك فى {{SITENAME}}!

تحقق من صفحة $2 فى $3

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإكتروني.',
	'friend_removed_subject' => 'كلا! أزالك $1 كصديق على {{SITENAME}}!',
	'friend_removed_body' => 'مرحبا $1:

$2 أزالك كصديق فى {{SITENAME}}!

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكتروني.',
	'foe_removed_subject' => 'هاه! $1 أزالك كعدو فى {{SITENAME}}!',
	'foe_removed_body' => 'مرحبا $1:

$2 أزالك كعدو فى {{SITENAME}}!

ربما أنتما الاثنان على الطريق لتكونا صديقين؟

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإكتروني.',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'ur-remove' => 'Выдаліць',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'ur-already-submitted' => 'Вашата заявка беше изпратена',
	'ur-error-page-title' => 'Опа!',
	'ur-error-title' => 'Опа, грешен ход!',
	'ur-error-message-no-user' => 'Заявката не може да бъде изпълнена, тъй като не съществува потребител с това име.',
	'ur-main-page' => 'Начална страница',
	'ur-your-profile' => 'Моят профил',
	'ur-backlink' => '&lt; Обратно към профила на $1',
	'ur-friend' => 'приятел',
	'ur-foe' => 'неприятел',
	'ur-relationship-count-foes' => '$1 има $2 {{PLURAL:$2|неприятел|неприятели}}. Искате още? <a href="$3">Поканете ги.</a>',
	'ur-relationship-count-friends' => '$1 има $2 {{PLURAL:$2|приятел|приятели}}. Искате още? <a href="$3">Поканете ги.</a>',
	'ur-add-friends' => '  Искате повече приятели? <a href="$1">Поканете ги!</a>',
	'ur-add-friend' => 'Добавяне в приятели',
	'ur-add-foe' => 'Добавяне в неприятели',
	'ur-add-no-user' => 'Не е посочен потребител.
Заявките за приятелство/неприятелство се извършват чрез съответната препратка.',
	'ur-add-personal-message' => 'Добавяне на лично съобщение',
	'ur-remove-relationship-friend' => 'Премахване от приятели',
	'ur-remove-relationship-foe' => 'Премахване от неприятели',
	'ur-give-gift' => 'Подаряване на подарък',
	'ur-previous' => 'предишни',
	'ur-next' => 'следващи',
	'ur-remove-relationship-title-foe' => 'Желаете ли да премахнете $1 от списъка ви с неприятели?',
	'ur-remove-relationship-title-confirm-foe' => 'Премахнахте $1 от списъка ви с неприятели',
	'ur-remove-relationship-title-friend' => 'Желаете ли да премахнете $1 от списъка ви с приятели?',
	'ur-remove-relationship-title-confirm-friend' => 'Премахнахте $1 от списъка ви с приятели',
	'ur-remove-relationship-message-foe' => 'Направихте заявка да премахнете $1 от списъка ви с неприятели; написнете „$2“ за потвърждаване.',
	'ur-remove-relationship-message-confirm-foe' => 'Успешно премахнахте $1 от списъка ви с неприятели.',
	'ur-remove-relationship-message-friend' => 'Направихте заявка да премахнете $1 от списъка ви с приятели; написнете „$2“ за потвърждаване.',
	'ur-remove-relationship-message-confirm-friend' => 'Успешно премахнахте $1 от списъка ви с приятели.',
	'ur-remove-error-message-remove-yourself' => 'Не можете да премахнете себе си.',
	'ur-remove-error-message-pending-request' => 'Имате чакаща заявка за $1 с $2.',
	'ur-remove-error-message-pending-foe-request' => 'Имате чакаща заявка за неприятелство с $1.',
	'ur-remove-error-message-pending-friend-request' => 'Имате чакаща заявка за приятелство с $1.',
	'ur-remove-error-not-loggedin' => 'Необходимо е да влезете за да премахнете $1.',
	'ur-remove-error-not-loggedin-foe' => 'За да премахвате неприятели е необходимо да влезете в системата.',
	'ur-remove-error-not-loggedin-friend' => 'За да премахвате приятели е необходимо да влезете в системата.',
	'ur-remove' => 'Премахване',
	'ur-cancel' => 'Отказване',
	'ur-login' => 'Влизане',
	'ur-add-title-foe' => 'Желаете ли да добавите $1 като ваш неприятел?',
	'ur-add-title-friend' => 'Желаете ли да добавите $1 като ваш приятел?',
	'ur-add-message-foe' => 'На път сте да добавите $1 като свой неприятел.
Ще изпратим писмо на $1 да потвърди омразата ви.',
	'ur-add-message-friend' => 'На път сте да добавите $1 като свой приятел.
Ще изпратим писмо на $1 да потвърди приятелството ви.',
	'ur-friendship' => 'приятелство',
	'ur-grudge' => 'неприятелство',
	'ur-add-button' => 'Добавяне като $1',
	'ur-add-button-foe' => 'Добавяне като неприятел',
	'ur-add-button-friend' => 'Добавяне като приятел',
	'ur-add-sent-title-foe' => 'Заявката за неприятелство беше изпратена на $1!',
	'ur-add-sent-title-friend' => 'Заявката за приятелство беше изпратена на $1!',
	'ur-add-sent-message-foe' => 'Заявката ви за неприятелство беше изпратена на $1 за потвърждение.
Ако $1 потвърди, че сте неприятели, ще получите оповестително писмо',
	'ur-add-sent-message-friend' => 'Заявката ви за приятелство беше изпратена на $1 за потвърждение.
Ако $1 потвърди, че сте приятели, ще получите оповестително писмо.',
	'ur-add-error-message-no-user' => 'Потребителят, който се опитвате да добавите, не съществува.',
	'ur-add-error-message-blocked' => 'В момента потребителската ви сметка е блокирана и не можете да добавяте приятели или неприятели.',
	'ur-add-error-message-yourself' => 'Не е позволено да добавяте себе си като приятел или неприятел.',
	'ur-add-error-message-existing-relationship' => 'Вече сте $1 с $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Вече сте неприятели с $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Вече сте приятели с $1.',
	'ur-add-error-message-pending-friend-request' => 'Имате изчакваща заявка за приятелство с $1.
Ще ви оповестим когато $1 потвърди заявката.',
	'ur-add-error-message-pending-foe-request' => 'Имате изчакваща заявка за неприятелство с $1.
Ще ви оповестим когато $1 потвърди заявката.',
	'ur-add-error-message-not-loggedin' => 'Необходимо е влизане в системата за добавяне на $1',
	'ur-add-error-message-not-loggedin-foe' => 'За да добавяте неприятели е необходимо да влезете в системата.',
	'ur-add-error-message-not-loggedin-friend' => 'За да добавяте приятели е необходимо да влезете в системата.',
	'ur-requests-message-foe' => '<a href="$1">$2</a> иска да бъдете неприятели.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> иска да бъдете приятели.',
	'ur-accept' => 'Приемане',
	'ur-reject' => 'Отказване',
	'ur-no-requests-message' => 'Нямате заявки за приятелства или неприятелства.
Ако искате да имате повече приятели, можете да ги <a href="$1">поканите!</a>',
	'ur-requests-added-message-foe' => 'Добавихте $1 като свой неприятел.',
	'ur-requests-added-message-friend' => 'Добавихте $1 като свой приятел.',
	'ur-requests-reject-message-friend' => 'Отказахте на $1 да бъдете приятели.',
	'ur-requests-reject-message-foe' => 'Отказахте на $1 да бъдете неприятели.',
	'ur-title-foe' => 'Списък с неприятели на $1',
	'ur-title-friend' => 'Списък с приятели на $1',
	'friend_request_subject' => '$1 ви добави като свой приятел в {{SITENAME}}!',
	'friend_request_body' => 'Здравейте $1:

$2 ви добави в списъка си с приятели в {{SITENAME}}. Бихме искали да се уверим, 
че това наистина е така и вие двамата наистина сте приятели.

За потвърждаване на приятелството, щракнете върху долната препратка:
$3

Благодарим ви!

---

Ако не желаете да получавате повече писма от нас, натиснете $4
и променете настройките за оповестяване по е-поща.',
	'foe_request_subject' => 'Война! $1 ви добави в списъка си с неприятели в {{SITENAME}}!',
	'friend_accept_subject' => '$1 прие поканата ви за приятелство в {{SITENAME}}!',
	'friend_accept_body' => 'Здравейте $1:

$2 прие поканата за приятелство в {{SITENAME}}!

Можете да разгледате страницата на $2 на адрес $3

---

Искате да спрете да получавате писма от нас?

Щракнете $4
за промяна на настройките и изключване на възможността за оповестяване по е-поща.',
	'foe_accept_subject' => '$1 се съгласи с неприятелството ви в {{SITENAME}}!',
	'foe_accept_body' => 'Здравейте $1:

$2 прие поканата за неприятелство в {{SITENAME}}!

Можете да разгледате страницата на $2 на адрес $3

---

Искате да спрете да получавате писма от нас?

Щракнете $4
за промяна на настройките и изключване на възможността за оповестяване по е-поща.',
	'friend_removed_subject' => 'О, не! $1 ви премахна от списъка си с приятели в {{SITENAME}}!',
	'friend_removed_body' => 'Здравейте $1:

$2 ви премахна от списъка си с приятели в {{SITENAME}}!

---

Искате да спрете да получавате писма от нас?

Щракнете $4
за промяна на настройките и изключване на възможността за оповестяване по е-поща.',
	'foe_removed_subject' => 'Юху! $1 ви премахна от списъка си с неприятели в {{SITENAME}}!',
	'foe_removed_body' => 'Здравейте $1:

$2 ви премахна от списъка си с неприятели в {{SITENAME}}!

Може би двамата сте на път да станете приятели?

---

Искате да спрете да получавате писма от нас?

Щракнете $4
за промяна на настройките и изключване на възможността за оповестяване по е-поща.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'ur-main-page' => 'Početna stranica',
	'ur-your-profile' => 'Vaš profil',
	'ur-friend' => 'prijatelj',
	'ur-previous' => 'preth',
	'ur-next' => 'slijedeći',
	'ur-remove' => 'Ukloni',
	'ur-cancel' => 'Odustani',
	'ur-login' => 'Prijava',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'ur-main-page' => 'Fanhaluman',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'ur-main-page' => 'гла́вьна страни́ца',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'ur-main-page' => 'Forside',
	'ur-next' => 'næste',
	'ur-cancel' => 'Afbryd',
	'ur-login' => 'Log på',
);

/** German (Deutsch)
 * @author Melancholie
 * @author Revolus
 * @author Tim 'Avatar' Bartel
 * @author Umherirrender
 */
$messages['de'] = array(
	'viewrelationships' => 'Zeige Beziehungen',
	'viewrelationshiprequests' => 'Zeige Beziehungsanfragen',
	'ur-already-submitted' => 'Deine Anfrage wurde gesendet',
	'ur-error-page-title' => 'Hoppla!',
	'ur-error-title' => 'Uuups, hier gehts nicht weiter!',
	'ur-error-message-no-user' => 'Wir können die Anfrage nicht ausführen, da kein Benutzer dieses Namens existiert.',
	'ur-main-page' => 'Hauptseite',
	'ur-your-profile' => 'Dein Profil',
	'ur-backlink' => '&lt; Zurück zu $1s Profil',
	'ur-friend' => 'Freund',
	'ur-foe' => 'Feind',
	'ur-relationship-count-foes' => '$1 hat {{PLURAL:$2|einen Feind|$2 Feinde}}. Du möchtest mehr Feinde? <a href="$3">Lade sie ein.</a>',
	'ur-relationship-count-friends' => '$1 hat {{PLURAL:$2|einen Freund|$2 Freunde}}. Du willst mehr Freunde? <a href="$3">Lade sie ein.</a>',
	'ur-add-friends' => ' Du möchtest mehr Freunde haben? <a href="$1">Lad\' sie ein …</a>',
	'ur-add-friend' => 'Als Freund hinzufügen',
	'ur-add-foe' => 'Als Feind hinzufügen',
	'ur-add-no-user' => 'Kein Benutzer ausgewählt.
Bitte wähle die Freunde/Feinde durch den richtigen Link.',
	'ur-add-personal-message' => 'Eine persönliche Nachricht hinzufügen',
	'ur-remove-relationship-friend' => 'Aus Freundesliste entfernen',
	'ur-remove-relationship-foe' => 'Aus Feindesliste entfernen',
	'ur-give-gift' => 'Geschenk senden',
	'ur-previous' => 'vorherige',
	'ur-next' => 'nächste',
	'ur-remove-relationship-title-foe' => 'Du möchtest $1 aus deiner Feindesliste löschen?',
	'ur-remove-relationship-title-confirm-foe' => 'Du hast $1 aus deiner Feindesliste gelöscht',
	'ur-remove-relationship-title-friend' => 'Du möchtest $1 aus deiner Freundesliste entfernen?',
	'ur-remove-relationship-title-confirm-friend' => 'Du hast $1 aus deiner Freundesliste gelöscht',
	'ur-remove-relationship-message-foe' => 'Du willst $1 aus deiner Feindesliste entfernen? Drücke „$2“ zum Bestätigen.',
	'ur-remove-relationship-message-confirm-foe' => 'Du hast erfolgreich $1 aus deiner Feindesliste gelöscht.',
	'ur-remove-relationship-message-friend' => 'Du willst $1 aus deiner Freundesliste entfernen? Drücke „$2“ zum Bestätigen.',
	'ur-remove-relationship-message-confirm-friend' => 'Du hast $1 erfolgreich aus deiner Freundesliste entfernt.',
	'ur-remove-error-message-no-relationship' => '$1 steht in keiner Beziehung zu dir.',
	'ur-remove-error-message-remove-yourself' => 'Du kannst dich nicht selbst enfernen.',
	'ur-remove-error-message-pending-request' => 'Du hast eine offene $1-Anfrage mit $2.',
	'ur-remove-error-message-pending-foe-request' => 'Du hast eine ausstehende Feindschaftsanfrage von $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du hast eine ausstehende Freundschaftsanfrage von $1.',
	'ur-remove-error-not-loggedin' => 'Du musst angemeldet sein um einen $1 zu entfernen.',
	'ur-remove-error-not-loggedin-foe' => 'Du musst eingeloggt sein, um einen Feind zu entfernen.',
	'ur-remove-error-not-loggedin-friend' => 'Du musst eingeloggt sein, um einen Freund zu entfernen.',
	'ur-remove' => 'Entfernen',
	'ur-cancel' => 'Abbrechen',
	'ur-login' => 'Anmelden',
	'ur-add-title-foe' => 'Du willst $1 zu deiner Feindesliste hinzufügen?',
	'ur-add-title-friend' => 'Du willst $1 zu deiner Freundesliste hinzufügen?',
	'ur-add-message-foe' => 'Du bit im Begriff, $1 zu deiner Feindesliste hinzuzufügen.
Wir werden $1 von deinem Groll berichten.',
	'ur-add-message-friend' => 'Du bist im Begriff, $1 zu deiner Freundesliste hinzuzufügen.
Wir werden eine Bestätigungen von $1 einholen.',
	'ur-friendship' => 'Freundschaft',
	'ur-grudge' => 'Feindschaft',
	'ur-add-button' => 'Als $1 hinzufügen',
	'ur-add-button-foe' => 'Als Feind hinzufügen',
	'ur-add-button-friend' => 'Als Freund hinzufügen',
	'ur-add-sent-title-foe' => 'Wir haben deine Feindschaftsanfrage an $1 gesendet!',
	'ur-add-sent-title-friend' => 'Wir haben deine Freundschaftsanfrage an $1 gesendet!',
	'ur-add-sent-message-foe' => 'Deine Feindschaftsanfrage wurde an $1 zum Bestätigen weitergereicht.
Du wirst eine E-Mail bekommen, sobald $1 deine Anfrage bestätigt.',
	'ur-add-sent-message-friend' => 'Deine Freundschaftsanfrage wurde an $1 zum Bestätigen weitergereicht.
Du wirst eine E-Mail bekommen, sobald $1 deine Anfrage bestätigt.',
	'ur-add-error-message-no-user' => 'Der Benutzer, den du hinzufügen möchtest, existiert nicht.',
	'ur-add-error-message-blocked' => 'Du bist momentan gesperrt und kannst keine Freunde oder Feinde hinzufügen.',
	'ur-add-error-message-yourself' => 'Du kannst dich nicht selbst als Freund oder Feind hinzufügen.',
	'ur-add-error-message-existing-relationship' => 'Du bist bereits $1 mit $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Du bist bereits mit $1 befeindet.',
	'ur-add-error-message-existing-relationship-friend' => 'Du bist bereits mit $1 befreundet.',
	'ur-add-error-message-pending-request-title' => 'Geduld!',
	'ur-add-error-message-pending-friend-request' => 'Du hast eine ausstehende Freundschaftsanfrage von $1.
Wir werden $1 davon informieren, wenn du seine Anfrage bestätigst.',
	'ur-add-error-message-pending-foe-request' => 'Du hast eine ausstehende Feindschaftsanfrage von $1.
Wir werden $1 davon informieren, wenn du seine Anfrage bestätigst.',
	'ur-add-error-message-not-loggedin' => 'Du musst angemeldet sein um einen $1 hinzuzufügen',
	'ur-add-error-message-not-loggedin-foe' => 'Du musst eingeloggt sein, um einen Feind hinzuzufügen',
	'ur-add-error-message-not-loggedin-friend' => 'Du musst eingeloggt sein, um einen Freund hinzuzufügen',
	'ur-requests-title' => 'Beziehungsanfrage',
	'ur-requests-message-foe' => '<a href="$1">$2</a> möchte dein Feind sein.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> möchte dein Freund sein.',
	'ur-accept' => 'Annehmen',
	'ur-reject' => 'Ablehnen',
	'ur-no-requests-message' => 'Du hast keine Freund- oder Feind-Anfrage. Wenn du mehr Freunde haben möchtest, <a href="$1">Lad\' sie ein…</a>',
	'ur-requests-added-message-foe' => 'Du hast $1 zu deiner Feindesliste hinzugefügt.',
	'ur-requests-added-message-friend' => 'Du hast $1 zu deiner Freundesliste hinzugefügt.',
	'ur-requests-reject-message-friend' => 'Du hast $1 als deinen Freund zurückgewiesen.',
	'ur-requests-reject-message-foe' => 'Du hast $1 als deinen Feind zurückgewiesen.',
	'ur-title-foe' => 'Feindesliste von $1',
	'ur-title-friend' => 'Freundesliste von $1',
	'friend_request_subject' => '{{SITENAME}}: $1 hat dich als Freund hinzugefügt!',
	'friend_request_body' => 'Hi $1:

$2 hat dich in {{SITENAME}} als Freund hinzugefügt. Wir wollen sicher gehen, dass ihr zwei wirklich Freunde seit.

Bitte klicke den folgenden Link um eure Freundschaft zu bestätigen:
$3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_request_subject' => '{{SITENAME}}: Kriegserklärung! $1 hat dich als Feind hinzugefügt!',
	'foe_request_body' => 'Hi $1:

$2 hat dich in {{SITENAME}} als Feind hinzugefügt. Wir wollen sicher gehen, dsas ihr zwei wirklich tödliche Feinde seid oder euch wenigstens ein wenig streitet.

Bitte klicke den folgenden Link um eure Feindschaft zu bestätigen:

$3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'friend_accept_subject' => '{{SITENAME}}: $1 hat deine Freundschaftsanfrage bestätigt!',
	'friend_accept_body' => 'Hi $1:

$2 hat deine Freundschaftsanfrage in {{SITENAME}} bestätigt!

Siehe $2s Seite hier: $3

Danke

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_accept_subject' => '{{SITENAME}}: $1 hat deine Feind-Anfrage bestätigt!',
	'foe_accept_body' => 'Hi $1:

$2 hat deine Feind-Anfrage in {{SITENAME}} bestätigt!

Siehe $2s Seite hier: $3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'friend_removed_subject' => '{{SITENAME}}: Oh nein! $1 hat seine Freundschaft zu dir beendet!',
	'friend_removed_body' => 'Hi $1:

$2 hat seine Freundschaft zu dir in {{SITENAME}} beendet!

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_removed_subject' => '{{SITENAME}}: Hey! $1 hat seine Feindschaft zu dir beendet!',
	'foe_removed_body' => 'Hi $1:

$2 hat seine Feindschaft zu dir in {{SITENAME}} beendet!

Vielleicht werdet ihr beide ja sogar mal Freunde?

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'ur-main-page' => 'Κύρια σελίδα',
	'ur-friend' => 'φίλος',
	'ur-give-gift' => 'Δώστε ένα Δώρο',
	'ur-friendship' => 'φιλία',
	'ur-add-error-message-pending-request-title' => 'Υπομονή!',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'viewrelationships' => 'Rigardi rilatecon',
	'ur-already-submitted' => 'Via peto estis sendita',
	'ur-error-page-title' => 'Ho ve!',
	'ur-error-title' => 'Ho ve, vi eraris!',
	'ur-main-page' => 'Ĉefpaĝo',
	'ur-your-profile' => 'Via profilo',
	'ur-backlink' => '&lt; Reiri al profilo de $1',
	'ur-friend' => 'amiko',
	'ur-foe' => 'malamiko',
	'ur-relationship-count-foes' => '$1 havas $2 {{PLURAL:$2|malamikon|malamikojn}}. Ĉu vi volas pli multaj malamikojn? <a href="$3">Inviti ilin.</a>',
	'ur-add-friends' => ' Ĉu vi volas pli multajn amikojn? <a href="$1">Inviti ilin</a>',
	'ur-add-friend' => 'Amiko',
	'ur-add-foe' => 'Aldoni kiel malamikon',
	'ur-add-personal-message' => 'Aldoni personan mesaĝon',
	'ur-remove-relationship-friend' => 'Forigi kiel amikon',
	'ur-remove-relationship-foe' => 'Forigi kiel malamikon',
	'ur-give-gift' => 'Doni donacon',
	'ur-previous' => 'antaŭ',
	'ur-next' => 'sekv',
	'ur-remove-relationship-title-foe' => 'Ĉu vi volas forigi $1 kiel vian malamikon?',
	'ur-remove-relationship-title-confirm-foe' => 'Vi sukcese forigis $1 kiel vian malamikon',
	'ur-remove-relationship-title-friend' => 'Ĉu vi volas forigi $1 kiel vian amikon?',
	'ur-remove-relationship-title-confirm-friend' => 'Vi forigis $1 kiel vian amikon',
	'ur-remove-relationship-message-confirm-foe' => 'Vi sukcese forigis $1 kiel vian malamikon.',
	'ur-remove-relationship-message-confirm-friend' => 'Vi sukcese forigis $1 kiel vian amikon.',
	'ur-remove-error-message-no-relationship' => 'Vi ne havas rilaton kun $1.',
	'ur-remove-error-message-remove-yourself' => 'Vi ne povas forigi vin mem.',
	'ur-remove-error-not-loggedin' => 'Vi devas ensaluti por forigi $1n.',
	'ur-remove-error-not-loggedin-foe' => 'Vi devas ensaluti por forigi malamikon.',
	'ur-remove-error-not-loggedin-friend' => 'Vi devas ensaluti por forigi amikon.',
	'ur-remove' => 'Forigi',
	'ur-cancel' => 'Nuligi',
	'ur-login' => 'Ensaluti',
	'ur-add-title-foe' => 'Ĉu vi volas aldoni $1 kiel vian malamikon?',
	'ur-add-title-friend' => 'Ĉu vi volas aldoni $1 kiel vian amikon?',
	'ur-add-message-foe' => 'Vi baldaŭ aldonos $1 kiel vian malamikon.
Ni informos $1 por konfirmi vian malamikecon.',
	'ur-add-message-friend' => 'Vi baldaŭ aldonos $1 kiel vian amikon.
Ni informos $1 por konfirmi vian amikecon.',
	'ur-friendship' => 'amikeco',
	'ur-grudge' => 'venĝemo',
	'ur-add-button' => 'Aldonu kiel $1',
	'ur-add-button-foe' => 'Aldoni kiel malamikon',
	'ur-add-button-friend' => 'Aldoni kiel amikon',
	'ur-add-sent-title-foe' => 'Ni sendis vian peton por malamikeco al $1!',
	'ur-add-sent-title-friend' => 'Ni sendis vian peton por amikeco al $1!',
	'ur-add-sent-message-foe' => 'Via peto por malamikeco estis sendita al $1 por konfirmado.
Se $1 konfirmus vian peton, vi ricevus pluan retpoŝton.',
	'ur-add-sent-message-friend' => 'Via peto por amikeco estis sendita al $1 por konfirmado.
Se $1 konfirmus vian peton, vi ricevus pluan retpoŝton.',
	'ur-add-error-message-no-user' => 'La uzanto kiun vi provas aldoni ne ekzistas.',
	'ur-add-error-message-blocked' => 'Vi estas nune forbarita kaj ne povas aldoni amikojn aŭ malamikojn.',
	'ur-add-error-message-yourself' => 'Vi ne povas aldoni vin mem kiel amikon aŭ malamikon.',
	'ur-add-error-message-existing-relationship' => 'Vi jam estas $1 kun $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Vi jam estas malamiko kun $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Vi jam estas amiko kun $1.',
	'ur-add-error-message-pending-request-title' => 'Pacienciĝu!',
	'ur-add-error-message-not-loggedin' => 'Vi devas ensaluti por aldoni $1n.',
	'ur-add-error-message-not-loggedin-foe' => 'Vi devas ensaluti por aldoni malamikon.',
	'ur-add-error-message-not-loggedin-friend' => 'Vi devas ensaluti por aldoni amikon.',
	'ur-requests-title' => 'Rilataj petoj',
	'ur-requests-message-foe' => '<a href="$1">$2</a> volas esti via malamiko.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> volas esti via amiko.',
	'ur-accept' => 'Akceptu',
	'ur-reject' => 'Malakceptu',
	'ur-no-requests-message' => 'Vi havas neniujn petojn de amikeco aŭ malamikeco
Se vi volas pliajn amikojn, <a href="$1">invitu ilin!</a>',
	'ur-requests-added-message-foe' => 'Vi aldonis $1 kiel vian malamikon.',
	'ur-requests-added-message-friend' => 'Vi aldonis $1 kiel vian amikon.',
	'ur-requests-reject-message-friend' => 'Vi malakceptis $1 kiel vian amikon.',
	'ur-requests-reject-message-foe' => 'Vi malakceptis $1 kiel vian malamikon.',
	'ur-title-foe' => 'Listo de malamikoj de $1',
	'ur-title-friend' => 'Listo de amikoj de $1',
	'friend_request_subject' => '$1 aldonis vin kiel amikon en {{SITENAME}}!',
	'foe_request_subject' => 'Estas milito! $1 aldonis vin kiel malamikon en {{SITENAME}}!',
	'friend_accept_subject' => '$1 akceptis vian amiko-peton en {{SITENAME}}!',
);

/** Spanish (Español)
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'ur-main-page' => 'Página principal',
	'ur-friend' => 'amigo',
	'ur-cancel' => 'Cancelar',
	'ur-login' => 'Entrar',
	'ur-friendship' => 'amistad',
	'ur-accept' => 'Aceptar',
	'ur-reject' => 'Rechazar',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'ur-already-submitted' => 'Zure eskaera bidali da',
	'ur-error-message-no-user' => 'Ezin dugu zure eskaera bete, ez dago izen hori duen erabiltzailerik.',
	'ur-main-page' => 'Azala',
	'ur-your-profile' => 'Zure perfila',
	'ur-add-friends' => 'Lagun gehiago nahi? <a href="$1">Gonbida itzazu</a>',
	'ur-add-friend' => 'Lagun bezala gehitu',
	'ur-add-foe' => 'Etsai bezala gehitu',
	'ur-add-personal-message' => 'Mezu pertsonala bidali',
	'ur-remove-relationship-friend' => 'Lagun bezala kendu',
	'ur-remove-relationship-foe' => 'Etsai bezala kendu',
	'ur-give-gift' => 'Oparia eman',
	'ur-previous' => 'aurreko',
	'ur-next' => 'hurrengo',
	'ur-remove' => 'Kendu',
	'ur-cancel' => 'Utzi',
	'ur-login' => 'Saioa hasi',
	'ur-add-button-foe' => 'Etsai bezala gehitu',
	'ur-add-button-friend' => 'Lagun bezala gehitu',
	'ur-add-error-message-pending-request-title' => 'Pazientzia!',
	'ur-add-error-message-not-loggedin-friend' => 'Lagun bat gehitzeko saioa hasi behar duzu',
	'ur-accept' => 'Onartu',
	'ur-reject' => 'Deuseztu',
	'ur-title-friend' => '$1-(r)en lagun zerrenda',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'viewrelationships' => 'Ystävä- ja vihollislista',
	'viewrelationshiprequests' => 'Katso ystävä- ja vihollispyyntöjä',
	'ur-already-submitted' => 'Pyyntösi on lähetetty',
	'ur-error-page-title' => 'Hups!',
	'ur-error-title' => 'Hups, astuit harhaan!',
	'ur-error-message-no-user' => 'Emme voi suorittaa pyyntöäsi loppuun, koska tämännimistä käyttäjää ei ole olemassa.',
	'ur-main-page' => 'Etusivu',
	'ur-your-profile' => 'Profiilisi',
	'ur-backlink' => '&lt; Takaisin käyttäjän $1 profiiliin',
	'ur-relationship-count-foes' => 'Käyttäjällä $1 on $2 {{PLURAL:$2|vihollinen|vihollista}}. Haluatko lisää vihollisia? <a href="$3">Kutsu heidät.</a>',
	'ur-relationship-count-friends' => 'Käyttäjällä $1 on $2 {{PLURAL:$2|ystävä|ystävää}}. Haluatko lisää ystäviä? <a href="$3">Kutsu heidät.</a>',
	'ur-add-friends' => ' Haluatko lisää ystäviä? <a href="$1">Kutsu heidät</a>',
	'ur-add-friend' => 'Lisää ystäväksi',
	'ur-add-foe' => 'Lisää viholliseksi',
	'ur-add-no-user' => 'Käyttäjää ei valittu. Teethän ystävyys-/vihollisuuspyynnöt oikean linkin kautta.',
	'ur-add-personal-message' => 'Lisää henkilökohtainen viesti',
	'ur-remove-relationship-friend' => 'Poista ystävistä',
	'ur-remove-relationship-foe' => 'Poista vihollisista',
	'ur-give-gift' => 'Anna lahja',
	'ur-previous' => 'edell.',
	'ur-next' => 'seur.',
	'ur-remove-relationship-title-foe' => 'Haluatko poistaa käyttäjän $1 vihollisistasi?',
	'ur-remove-relationship-title-confirm-foe' => 'Olet poistanut käyttäjän $1 vihollisistasi',
	'ur-remove-relationship-title-friend' => 'Haluatko poistaa käyttäjän $1 ystävistäsi?',
	'ur-remove-relationship-title-confirm-friend' => 'Olet poistanut käyttäjän $1 ystävistäsi',
	'ur-remove-relationship-message-foe' => 'Olet pyytänyt poistaa käyttäjän $1 vihollisistasi, paina "$2" vahvistaaksesi.',
	'ur-remove-relationship-message-confirm-foe' => 'Olet onnistuneesti poistanut käyttäjän $1 vihollisistasi.',
	'ur-remove-relationship-message-friend' => 'Olet pyytänyt poistaa käyttäjän $1 ystävistäsi, paina "$2" vahvistaaksesi.',
	'ur-remove-relationship-message-confirm-friend' => 'Olet onnistuneesti poistanut käyttäjän $1 ystävistäsi.',
	'ur-remove-error-message-no-relationship' => 'Sinulla ei ole minkäänlaista suhdetta käyttäjään $1.',
	'ur-remove-error-message-remove-yourself' => 'Et voi poistaa itseäsi.',
	'ur-remove-error-message-pending-foe-request' => 'Sinulla on odottava vihollisuuspyyntö käyttäjän $1 kanssa.',
	'ur-remove-error-message-pending-friend-request' => 'Sinulla on odottava ystävyyspyyntö käyttäjän $1 kanssa.',
	'ur-remove-error-not-loggedin-foe' => 'Sinun tulee olla kirjautunut sisään poistaaksesi vihollisen.',
	'ur-remove-error-not-loggedin-friend' => 'Sinun tulee olla kirjautunut sisään poistaaksesi ystävän.',
	'ur-remove' => 'Poista',
	'ur-cancel' => 'Peruuta',
	'ur-login' => 'Kirjaudu sisään',
	'ur-add-title-foe' => 'Haluatko lisätä käyttäjän $1 viholliseksesi?',
	'ur-add-title-friend' => 'Haluatko lisätä käyttäjän $1 ystäväksesi?',
	'ur-add-message-foe' => 'Olet aikeissa lisätä käyttäjän $1 viholliseksesi.
Ilmoitamme käyttäjälle $1 asiasta, jotta hän voi vahvistaa kaunanne.',
	'ur-add-message-friend' => 'Olet aikeissa lisätä käyttäjän $1 ystäväksesi.
Ilmoitamme käyttäjälle $1 asiasta, jotta hän voi vahvistaa ystävyytenne.',
	'ur-add-button-foe' => 'Lisää viholliseksi',
	'ur-add-button-friend' => 'Lisää ystäväksi',
	'ur-add-sent-title-foe' => 'Olemme lähettäneet vihollisuuspyyntösi käyttäjälle $1!',
	'ur-add-sent-title-friend' => 'Olemme lähettäneet ystävyyspyyntösi käyttäjälle $1!',
	'ur-add-sent-message-foe' => 'Vihollisuuspyyntösi on lähetetty käyttäjälle $1 vahvistusta varten.
Jos $1 vahvistaa pyyntösi, saat sähköpostia aiheesta',
	'ur-add-sent-message-friend' => 'Ystävyyspyyntösi on lähetetty käyttäjälle $1 vahvistusta varten.
Jos $1 vahvistaa pyyntösi, saat sähköpostia aiheesta',
	'ur-add-error-message-no-user' => 'Käyttäjää, jota koitat lisätä ei ole olemassa.',
	'ur-add-error-message-blocked' => 'Olet muokkauseston alaisena etkä voi lisätä ystäviä tai vihollisia.',
	'ur-add-error-message-yourself' => 'Et voi lisätä itseäsi ystäväksesi tai viholliseksesi.',
	'ur-add-error-message-existing-relationship-foe' => 'Olet jo vihollsia käyttäjän $1 kanssa.',
	'ur-add-error-message-existing-relationship-friend' => 'Olet jo ystäviä käyttäjän $1 kanssa.',
	'ur-add-error-message-pending-request-title' => 'Kärsivällisyyttä!',
	'ur-add-error-message-pending-friend-request' => 'Sinulla on odottava ystävyyspyyntö käyttäjän $1 kanssa.
Ilmoitamme sinulle, kun $1 vahvistaa pyyntösi.',
	'ur-add-error-message-pending-foe-request' => 'Sinulla on odottava vihollisuuspyyntö käyttäjän $1 kanssa.
Ilmoitamme sinulle, kun $1 vahvistaa pyyntösi.',
	'ur-add-error-message-not-loggedin-foe' => 'Sinun tulee olla kirjautunut sisään lisätäksesi vihollisen',
	'ur-add-error-message-not-loggedin-friend' => 'Sinun tulee olla kirjautunut sisään lisätäksesi ystävän',
	'ur-requests-title' => 'Ystävä- ja vihollispyynnöt',
	'ur-requests-message-foe' => '<a href="$1">$2</a> haluaa olla vihollisesi.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> haluaa olla ystäväsi.',
	'ur-accept' => 'Hyväksy',
	'ur-reject' => 'Hylkää',
	'ur-no-requests-message' => 'Sinulla ei ole ystävä- tai vihollispyyntöjä. Jos haluat lisää ystäviä, <a href="$1">kutsu heidät!</a>',
	'ur-requests-added-message-foe' => 'Olet lisännyt käyttäjän $1 viholliseksesi.',
	'ur-requests-added-message-friend' => 'Olet lisännyt käyttäjän $1 ystäväksesi.',
	'ur-requests-reject-message-friend' => 'Olet hylännyt käyttäjän $1 ystävähakemuksen.',
	'ur-requests-reject-message-foe' => 'Olet hylännyt käyttäjän $1 vihollishakemuksen.',
	'ur-title-foe' => 'Käyttäjän $1 vihollislista',
	'ur-title-friend' => 'Käyttäjän $1 ystävälista',
	'friend_request_subject' => '$1 on lisännyt sinut ystäväksesi {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'friend_request_body' => 'Hei $1:

$2 on lisännyt sinut ystäväksesi {{GRAMMAR:inessive|{{SITENAME}}}}.  Haluamme varmistua siitä, että te olette oikeasti ystäviä.

Napsauta allaolevaa linkkiä vahvistaaksesi ystävyytenne:
$3

Kiitos

---

Hei, etkö enää halua saada sähköpostia meiltä?

Napsauta $4
ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
	'foe_request_subject' => 'Sotaa! $1 on lisännyt sinut vihollisekseen {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'foe_request_body' => 'Hei $1:

$2 juuri listasi sinut vihollisekseen {{GRAMMAR:inessive|{{SITENAME}}}}.  Haluamme varmistua siitä, että te olette oikeasti perivihollisia tai että teillä ainakin on pientä kinaa.

Napsauta allaolevaa linkkiä vahvistaaksesi kaunanne.

$3

Kiitos

---

Hei, etkö enää halua saada sähköpostia meiltä? 

Napsauta $4 ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
	'friend_accept_subject' => '$1 on hyväksynyt ystävyyspyyntösi {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'friend_accept_body' => 'Hei $1:

$2 on hyväksynyt ystävyyspyyntösi {{GRAMMAR:inessive|{{SITENAME}}}}!

Katso $2:n sivu osoitteessa $3

Kiitos

---

Hei, etkö enää halua saada sähköpostia meiltä? 

Napsauta $4
ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
	'foe_accept_subject' => 'Sotaa! $1 on hyväksynyt vihollisuuspyyntösi {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'foe_accept_body' => 'Hei $1:

$2 on hyväksynyt vihollisuuspyyntösi {{GRAMMAR:inessive|{{SITENAME}}}}!

Katso $2:n sivu osoitteessa $3

Kiitos

---

Hei, etkö enää halua saada sähköpostia meiltä? 

Napsauta $4
ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
	'friend_removed_subject' => 'Voi ei! $1 on poistanut sinut ystävälistaltaan {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'friend_removed_body' => 'Hei $1:

$2 on poistanut sinut ystävälistaltaan {{GRAMMAR:inessive|{{SITENAME}}}}!

Kiitos

---

Hei, etkö enää halua saada sähköpostia meiltä? 

Napsauta $4
ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
	'foe_removed_subject' => 'Jippii! $1 on poistanut sinut vihollislistaltaan {{GRAMMAR:inessive|{{SITENAME}}}}!',
	'foe_removed_body' => 'Hei $1:

$2 on poistanut sinut vihollislistaltaan {{GRAMMAR:inessive|{{SITENAME}}}}!

Ehkäpä teistä tulee vielä ystävät?

Kiitos

---

Hei, etkö enää halua saada sähköpostia meiltä? 

Napsauta $4
ja muuta asetuksiasi poistaaksesi sähköposti-ilmoitukset käytöstä.',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Zetud
 */
$messages['fr'] = array(
	'viewrelationships' => 'Voir les relations',
	'viewrelationshiprequests' => 'Voir les requêtes des relations',
	'ur-already-submitted' => 'Votre demande a été envoyée',
	'ur-error-page-title' => 'Oups !',
	'ur-error-title' => 'Houla, vous avez pris un mauvais virage !',
	'ur-error-message-no-user' => 'Nous ne pouvons compléter votre requête, car aucun utilisateur ne porte ce nom.',
	'ur-main-page' => 'Accueil',
	'ur-your-profile' => 'Votre profile',
	'ur-backlink' => '&lt; retour vers le profil de $1',
	'ur-friend' => 'ami',
	'ur-foe' => 'ennemi',
	'ur-relationship-count-foes' => '$1 a $2 {{PLURAL:$2|ennemi|ennemis}}. En vouloir encore plus ? <a href="$3">Inviter les.</a>',
	'ur-relationship-count-friends' => '$1 a $2 {{PLURAL:$2|ami|amis}}. En vouloir encore plus ? <a href="$3">Inviter les.</a>',
	'ur-add-friends' => 'Vouloir plus d’amis ? <a href="$1">Inviter les</a>.',
	'ur-add-friend' => 'Ajouter comme ami',
	'ur-add-foe' => 'Ajouter comme ennemi',
	'ur-add-no-user' => 'Aucun utilisateur sélectionné. Veuillez requérir des amis ou des ennemis au travers du lien correct.',
	'ur-add-personal-message' => 'Ajouter un message personnel',
	'ur-remove-relationship-friend' => 'Enlever comme ami',
	'ur-remove-relationship-foe' => 'Enlever comme ennemi',
	'ur-give-gift' => 'Envoyer un cadeau',
	'ur-previous' => 'préc.',
	'ur-next' => 'suiv.',
	'ur-remove-relationship-title-foe' => 'Voulez-vouz enlever $1 comme votre ennemi ?',
	'ur-remove-relationship-title-confirm-foe' => 'Vous avez enlevé $1 de vos ennemis',
	'ur-remove-relationship-title-friend' => 'Voulez-vous enlever $1 comme votre ami ?',
	'ur-remove-relationship-title-confirm-friend' => 'Vous avez enlevé $1 de vos amis.',
	'ur-remove-relationship-message-foe' => 'vous avez requis la suppression de $1 en tant qu’ennemi, appuyez sur « $2 » pour confirmer.',
	'ur-remove-relationship-message-confirm-foe' => 'Vous avez enlevé $1 avec succès de vos ennemis.',
	'ur-remove-relationship-message-friend' => 'Vous avez requis la suppression de $1 de vos amis, appuyer sur « $2 » pour confirmer.',
	'ur-remove-relationship-message-confirm-friend' => 'Vous enlevé $1 avec succès de vos amis.',
	'ur-remove-error-message-no-relationship' => "Vous n'avez aucune relation avec $1.",
	'ur-remove-error-message-remove-yourself' => 'Vous ne pouvez pas vous supprimer vous-même.',
	'ur-remove-error-message-pending-request' => 'Vous avez une requête de $1 en cours avec $2.',
	'ur-remove-error-message-pending-foe-request' => 'Vous avez, en cours, une requête d’un ennemi avec $1.',
	'ur-remove-error-message-pending-friend-request' => 'Vous avez, en cours, une requête d’un ami avec $1.',
	'ur-remove-error-not-loggedin' => 'Vous devez être en session pour supprimer un $1.',
	'ur-remove-error-not-loggedin-foe' => 'Vous devez être connecté pour enlever un ennemi.',
	'ur-remove-error-not-loggedin-friend' => 'Vous devez être connecté pour enlever un ami.',
	'ur-remove' => 'Enlever',
	'ur-cancel' => 'Annuler',
	'ur-login' => 'Connexion',
	'ur-add-title-foe' => 'Voulez-vous ajouter $1 parmi vos ennemis ?',
	'ur-add-title-friend' => 'Voulez-vous ajouter $1 parmi vos amis ?',
	'ur-add-message-foe' => 'Vous êtes sur le point d’ajouter $1 parmi vos ennemis.
Nous informerons $1 pour confirmer votre rancune.',
	'ur-add-message-friend' => 'Vous êtes sur le point d’ajouter $1 parmi vos amis.
Nous informerons $1 pour confirmer votre amitié.',
	'ur-friendship' => 'amitié',
	'ur-grudge' => 'rancœur',
	'ur-add-button' => 'Ajouter comme $1',
	'ur-add-button-foe' => 'Ajouter comme ennemi',
	'ur-add-button-friend' => 'Ajouter comme ami',
	'ur-add-sent-title-foe' => 'Vous avez envoyé déclaration d’hostilité à $1 !',
	'ur-add-sent-title-friend' => 'Vous avez envoyé déclaration d’amitié à $1 !',
	'ur-add-sent-message-foe' => 'Votre requête en hostilité a été envoyée à $1 pour confirmation.
Si $1 confirme votre demande, vous recevrez le suivi par courriel.',
	'ur-add-sent-message-friend' => 'Votre requête en amitié a été envoyée à $1 pour confirmation.
Si $1 confirme votre demande, vous recevrez le suivi par courriel.',
	'ur-add-error-message-no-user' => 'L’utilisateur que vous être en train d’ajouter n’existe pas.',
	'ur-add-error-message-blocked' => 'Vous êtes actuellement bloqué et vous ne pouvez donc ajouter ni amis ni ennemis.',
	'ur-add-error-message-yourself' => 'Vous ne pouvez vous-même vous ajouter comme ennemi ou ami.',
	'ur-add-error-message-existing-relationship' => 'Vous êtes déjà $1 avec $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Vous êtes déjà l’ennemi de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'vous êtes déjà l’ami de $1.',
	'ur-add-error-message-pending-request-title' => 'Patience !',
	'ur-add-error-message-pending-friend-request' => 'Vous avez une demande d’amitié en cours avec $1.
Nous vous notifierons si $1 confirme votre requête.',
	'ur-add-error-message-pending-foe-request' => 'Vous avez une déclaration d’hostilité en cours avec $1.
Nous vous notifierons si $1 confirme votre requête.',
	'ur-add-error-message-not-loggedin' => 'Vous devez être connecté pour ajouter un $1.',
	'ur-add-error-message-not-loggedin-foe' => 'Vous devez être connecté pour ajouter un ennemi',
	'ur-add-error-message-not-loggedin-friend' => 'Vous devez être connecté pour ajouter un ami',
	'ur-requests-title' => 'Demandes de relations.',
	'ur-requests-message-foe' => '<a href="$1">$2</a> veut être votre ennemi.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> veut être votre ami.',
	'ur-accept' => 'Accepter',
	'ur-reject' => 'Rejeter',
	'ur-no-requests-message' => 'Vous n’avez aucune requête en ami ou ennemi. Si vous désirez plus d\'amis, <a href="$1">invitez les !</a>',
	'ur-requests-added-message-foe' => 'Vous avez ajouté $1 en tant qu’ennemi.',
	'ur-requests-added-message-friend' => 'Vous avez ajouté $1 en tant qu’ami.',
	'ur-requests-reject-message-friend' => 'Vous avez refusé $1 en tant qu’ami.',
	'ur-requests-reject-message-foe' => 'Vous avez refusé $1 en tant qu’ennemi.',
	'ur-title-foe' => 'Liste des ennemis de $1',
	'ur-title-friend' => 'Liste des amis de $1',
	'friend_request_subject' => '$1 vous a ajouté comme un ami sur {{SITENAME}} !',
	'friend_request_body' => 'Salut $1 :

$2 vous a ajouté comme un ami sur {{SITENAME}}. Nous voulons nous assurer que vous êtes tous deux actuellement amis.

Veuillez cliquer sur ce lien pour confirmer votre amitié :
$3

Merci.

---

Hé ! Voulez-vous vous arrêter de recevoir des courriels de notre part ?

Cliquez $4
et modifiez vos préférences pour désactiver les notifications par courriel.',
	'foe_request_subject' => "C'est la guerre ! $1 vous a ajouté comme ennemi sur {{SITENAME}} !",
	'foe_request_body' => 'Salut $1 :

$2 vient juste de vous répertorier comme un ennemi sur {{SITENAME}}. Nous voulons nous assurer que vous êtes vraiement des emmenis mortel ou avoir au moins des griefs l’un envers l’autre/

Veuillez cliquer sur ce lien, pour accepter, à contrecœur, cet état de fait.

$3

Merci

---

Hé ! Voulez-vous vous arrêter de recevoir des courriels de notre part ?

Cliquez $4 et modifiez vos préférences pour désactiver les notifications par courriel.',
	'friend_accept_subject' => '$1 a accepté votre requête en amitié sur {{SITENAME}} !',
	'friend_accept_body' => 'Salut $1 : 

$2 a accepté votre requête en amitié sur {{SITENAME}} !

Allez sur la page de $2 sur $3

Merci.

---

Hé ! Voulez-vous vous arrêter de recevoir des courriels de notre part ?

Cliquez $4
et modifiez vos préférences pour désactiver les notifications par courriel.',
	'foe_accept_subject' => "C'est fait ! $1 a accepté votre déclaration de guerre sur  {{SITENAME}} !",
	'foe_accept_body' => 'Salut $1 : 

$2 a accepté votre déclaration de guerre sur  {{SITENAME}} !

Visitez la page de $2 sur $3.

Merci

---

Hé ! Voulez-vous vous arrêter de recevoir des courriels de notre part ?

Cliquez $4 et modifiez vos préférences pour désactiver les notifications par courriel.',
	'friend_removed_subject' => 'Saperlipopette ! $1 vous a retiré de la liste de ses amis sur {{SITENAME}} !',
	'friend_removed_body' => 'Salut $1 :

$2 vous a retiré de la liste de ses amis sur {{SITENAME}} !

Merci

---

Hé ! Voulez-vous vous arrêter de recevoir des courriels de notre part ?

Cliquez $4 et modifiez vos préférences pour désactiver les notifications par courriel.',
	'foe_removed_subject' => 'Par Jupiter ! $1 vous a retiré de la liste de ses ennemis {{SITENAME}} !',
	'foe_removed_body' => 'Salut $1 :

$2 vous a retiré de la liste de ses ennemis sur {{SITENAME}} !

Ne seriez-vous pas, peut-être, sur le chemin pour devenir amis ?

Merci

---

Hé ! Voulez-vous vous arrêter de recevoir des courriels de notre part ?

Cliquez $4
et modifiez vos préférences pour désactiver les notifications par courriel.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'ur-main-page' => 'Haadside',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'viewrelationships' => 'Ver relación',
	'viewrelationshiprequests' => 'Ver solcitudes de relación',
	'ur-already-submitted' => 'A súa solicitude foi enviada',
	'ur-error-page-title' => 'Vaites!',
	'ur-error-title' => 'Ups, tomou un xiro erróneo!',
	'ur-error-message-no-user' => 'Non podemos completar a súa petición porque non existe ningún usuario con ese nome.',
	'ur-main-page' => 'Portada',
	'ur-your-profile' => 'O seu perfil',
	'ur-backlink' => '&lt; Voltar ao perfil de $1',
	'ur-friend' => 'amigo',
	'ur-foe' => 'inimigo',
	'ur-relationship-count-foes' => '$1 ten $2 {{PLURAL:$2|inimigo|inimigos}}. Quere máis inimigos? <a href="$3">Invíteos.</a>',
	'ur-relationship-count-friends' => '$1 ten $2 {{PLURAL:$2|amigo|amigos}}. Quere máis amigos? <a href="$3">Invíteos.</a>',
	'ur-add-friends' => '  Quere máis amigos? <a href="$1">Invíteos</a>',
	'ur-add-friend' => 'Engadir como amigo',
	'ur-add-foe' => 'Engadir como inimigo',
	'ur-add-no-user' => 'Non foi seleccionado ningún usuario.
Por favor, solicite amigos/inimigos a través da ligazón correcta.',
	'ur-add-personal-message' => 'Engadir unha mensaxe persoal',
	'ur-remove-relationship-friend' => 'Eliminar como amigo',
	'ur-remove-relationship-foe' => 'Eliminar como inimigo',
	'ur-give-gift' => 'Dar un agasallo',
	'ur-previous' => 'anterior',
	'ur-next' => 'seguinte',
	'ur-remove-relationship-title-foe' => 'Quere eliminar a $1 dos seus inimigos?',
	'ur-remove-relationship-title-confirm-foe' => 'Eliminou a $1 dos seus inimigos',
	'ur-remove-relationship-title-friend' => 'Quere eliminar a $1 dos seus amigos?',
	'ur-remove-relationship-title-confirm-friend' => 'Eliminou a $1 dos seus amigos',
	'ur-remove-relationship-message-foe' => 'Solicitou eliminar a $1 dos seus inimigos, prema en "$2" para confirmalo.',
	'ur-remove-relationship-message-confirm-foe' => 'Eliminou con éxito a $1 dos seus inimigos.',
	'ur-remove-relationship-message-friend' => 'Solicitou eliminar a $1 dos seus amigos, prema en "$2" para confirmalo.',
	'ur-remove-relationship-message-confirm-friend' => 'Eliminou con éxito a $1 dos seus amigos.',
	'ur-remove-error-message-no-relationship' => 'Non ten relación con $1.',
	'ur-remove-error-message-remove-yourself' => 'Non pode eliminarse a si mesmo.',
	'ur-remove-error-message-pending-request' => 'Ten pendientes $1 solicitudes con $2.',
	'ur-remove-error-message-pending-foe-request' => 'Ten unha solicitude de inimizade pendente con $1.',
	'ur-remove-error-message-pending-friend-request' => 'Ten unha solicitude de amizade pendente con $1.',
	'ur-remove-error-not-loggedin' => 'Ten que acceder ao sistema para eliminar a $1.',
	'ur-remove-error-not-loggedin-foe' => 'Ten que acceder ao sistema para eliminar un inimigo.',
	'ur-remove-error-not-loggedin-friend' => 'Ten que acceder ao sistema para eliminar un amigo.',
	'ur-remove' => 'Eliminar',
	'ur-cancel' => 'Cancelar',
	'ur-login' => 'Rexistro',
	'ur-add-title-foe' => 'Quere engadir a $1 como o seu inimigo?',
	'ur-add-title-friend' => 'Quere engadir a $1 como o seu amigo?',
	'ur-add-message-foe' => 'Pode engadir a $1 como o seu inimigo.
Notificaremos a $1 para confirmar o seu rancor.',
	'ur-add-message-friend' => 'Pode engadir a $1 como o seu amigo.
Notificaremos a $1 para confirmar a súa amizade.',
	'ur-friendship' => 'amizade',
	'ur-grudge' => 'rancor',
	'ur-add-button' => 'Engadir aos seus $1',
	'ur-add-button-foe' => 'Engadir como inimigo',
	'ur-add-button-friend' => 'Engadir como amigo',
	'ur-add-sent-title-foe' => 'Xa lle enviamos a súa solicitude de inimizade a $1!',
	'ur-add-sent-title-friend' => 'Xa lle enviamos a súa solicitude de amizade a $1!',
	'ur-add-sent-message-foe' => 'A súa solicitude de inimizade foille enviada a $1 para que a confirme.
Se $1 a confirma, recibirá un correo electrónico notificándollo',
	'ur-add-sent-message-friend' => 'A súa solicitude de amizade foille enviada a $1 para que a confirme.
Se $1 a confirma, recibirá un correo electrónico notificándollo',
	'ur-add-error-message-no-user' => 'O usuario que está tentando engadir non existe.',
	'ur-add-error-message-blocked' => 'Actualmente está bloqueado e non pode engadir amigos nin inimigos.',
	'ur-add-error-message-yourself' => 'Non pode engadirse a si mesmo como amigo ou inimigo.',
	'ur-add-error-message-existing-relationship' => 'Xa é $1 con $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Xa é inimigo de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Xa é amigo de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciencia!',
	'ur-add-error-message-pending-friend-request' => 'Ten unha solicutude de amizade pendente con $1.
Notificarémoslle cando $1 a confirme.',
	'ur-add-error-message-pending-foe-request' => 'Ten unha solicutude de inimizade pendente con $1.
Notificarémoslle cando $1 a confirme.',
	'ur-add-error-message-not-loggedin' => 'Ten que acceder ao sistema para engadir un $1',
	'ur-add-error-message-not-loggedin-foe' => 'Debe acceder ao sistema para engadir un inimigo',
	'ur-add-error-message-not-loggedin-friend' => 'Debe acceder ao sistema para engadir un amigo',
	'ur-requests-title' => 'Solicitudes de relación',
	'ur-requests-message-foe' => '<a href="$1">$2</a> quere ser o seu inimigo.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> quere ser o seu amigo.',
	'ur-accept' => 'Aceptar',
	'ur-reject' => 'Rexeitar',
	'ur-no-requests-message' => 'Non ten solicitudes de amigo ou inimigo.  Se quere máis amigos, <a href=$1">invíteos!</a>',
	'ur-requests-added-message-foe' => 'Engadiu a $1 como o seu inimigo.',
	'ur-requests-added-message-friend' => 'Engadiu a $1 como o seu amigo.',
	'ur-requests-reject-message-friend' => 'Rexeitou a $1 como o seu amigo.',
	'ur-requests-reject-message-foe' => 'Rexeitou a $1 como o seu inimigo.',
	'ur-title-foe' => 'Listaxe de inimigos de $1',
	'ur-title-friend' => 'Listaxe de amigos de $1',
	'friend_request_subject' => '$1 engadiuno como amigo en {{SITENAME}}!',
	'friend_request_body' => 'Ola $1:

$2 engdiuno como amigo seu en {{SITENAME}}.  Queremos estar seguros de que vostedes dous son amigos actualmente.

Por favor, faga clic nesta ligazón para confirmar a súa amizade:
$3

Grazas

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
	'foe_request_subject' => 'É a guerra! $1 engadiuno como inimigo seu en {{SITENAME}}!',
	'foe_request_body' => 'Ola $1:

$2 engdiuno como inimigo seu en {{SITENAME}}.  Queremos estar seguros de que vostedes dous son inimigos mortais actualmente ou que teñen, polo menos, un argumento.

Por favor, faga clic nesta ligazón para confirmar a súa inimizade:
$3

Grazas

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
	'friend_accept_subject' => '$1 aceptou a súa solicitude de amizade en {{SITENAME}}!',
	'friend_accept_body' => 'Ola $1:

$2 aceptou a súa solicitude de amizade en {{SITENAME}}!

Comprobe a páxina de $2 en $3

Grazas

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
	'foe_accept_subject' => 'A cousa está que arde! $1 aceptou a súa solicitude de inimizade en {{SITENAME}}!',
	'foe_accept_body' => 'Ola $1:

$2 aceptou a súa solicitude de inimizade en {{SITENAME}}!

Comprobe a páxina de $2 en $3

Grazas

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
	'friend_removed_subject' => 'Non! $1 eliminouno dos seus amigos en {{SITENAME}}!',
	'friend_removed_body' => 'Ola $1:

$2 eliminouno dos seus amigos en {{SITENAME}}!

Grazas

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
	'foe_removed_subject' => 'Ben! $1 eliminouno dos seus inimigos en {{SITENAME}}!',
	'foe_removed_body' => 'Ola $1:

$2 eliminouno dos seus inimigos en {{SITENAME}}!

Talvez estades no bo camiño para convertirvos en amigos?

Grazas

---

Quere deixar de recibir correos electrónicos nosos?

Faga clic $4
e troque as súas configuracións para deshabilitar as notificacións por correo electrónico.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author AndreasJS
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'ur-main-page' => 'Κυρία Δέλτος',
	'ur-next' => 'Ἑπομέναι',
	'ur-remove' => 'Άφαιρεῖν',
	'ur-cancel' => 'Ἀκυροῦν',
	'ur-login' => 'Συνδεῖσθαι',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'ur-main-page' => 'Thèu-chông',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'ur-remove' => 'Kāpae',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'viewrelationships' => 'צפייה בקשרים',
	'viewrelationshiprequests' => 'צפייה בבקשות לקשר',
	'ur-already-submitted' => 'בקשתכם נשלחה',
	'ur-error-page-title' => 'אופס!',
	'ur-error-title' => 'אופס, זאת לא הפנייה הנכונה!',
	'ur-error-message-no-user' => 'לא נוכל להשלים את בקשתכם, כיוון שלא קיים משתמש בשם זה.',
	'ur-main-page' => 'עמוד ראשי',
	'ur-your-profile' => 'הפרופיל שלכם',
	'ur-backlink' => '&lt; חזרה לפרופיל של $1',
	'ur-friend' => 'חבר',
	'ur-foe' => 'יריב',
	'ur-relationship-count-foes' => 'ל־$1 יש {{PLURAL:$2|יריב אחד|$2 יריבים}}. מעוניינים ביריבים נוספים? <a href="$3">הזמינו אותם.</a>',
	'ur-relationship-count-friends' => 'ל־$1 יש {{PLURAL:$2|חבר אחד|$2 חברים}}. מעוניינים בחברים נוספים? <a href="$3">הזמינו אותם.</a>',
	'ur-add-friends' => '  מעוניינים בחברים נוספים? <a href="$1">הזמינו אותם</a>',
	'ur-add-friend' => 'הוספה כחבר',
	'ur-add-foe' => 'הוספה כיריב',
	'ur-add-no-user' => 'לא נבחרו משתמשים.
אנא בקשו חברות/יריבות דרך הקישור הנכון.',
	'ur-add-personal-message' => 'הוספת הודעה אישית',
	'ur-remove-relationship-friend' => 'הסרת חברות',
	'ur-remove-relationship-foe' => 'הסרה כיריב',
	'ur-give-gift' => 'הענקת מתנה',
	'ur-previous' => 'הקודם',
	'ur-next' => 'הבא',
	'ur-remove-relationship-title-foe' => 'האם ברצונכם להסיר את $1 כיריבכם?',
	'ur-remove-relationship-title-confirm-foe' => 'הסרתם את $1 כיריבכם',
	'ur-remove-relationship-title-friend' => 'האם ברצונכם להסיר את $1 כחברכם?',
	'ur-remove-relationship-title-confirm-friend' => 'הסרתם את $1 כחברכם',
	'ur-remove-relationship-message-foe' => 'ביקשתם להסיר את $1 כיריבכם, לחצו על "$2" לאישור.',
	'ur-remove-relationship-message-confirm-foe' => 'הסרתם בהצלחה את $1 כיריבכם.',
	'ur-remove-relationship-message-friend' => 'ביקשתם להסיר את $1 כחברכם, לחצו על "$2" לאישור.',
	'ur-remove-relationship-message-confirm-friend' => 'הסרתם את $1 כחברכם בהצלחה.',
	'ur-remove-error-message-no-relationship' => 'אין לכם כל יחסים עם $1.',
	'ur-remove-error-message-remove-yourself' => 'לא תוכלו להסיר את עצמכם.',
	'ur-remove-error-message-pending-request' => 'יש לכם $1 בקשות ממתינות עם $2.',
	'ur-remove-error-message-pending-foe-request' => 'יש לכם בקשת יריבות אחת עם $1.',
	'ur-remove-error-message-pending-friend-request' => 'יש לכם בקשת חברות ממתינה עם $1.',
	'ur-remove-error-not-loggedin' => 'עליכם להיכנס לחשבון כדי להסיר את $1.',
	'ur-remove-error-not-loggedin-foe' => 'עליכם להיכנס לחשבון כדי להסיר יריב.',
	'ur-remove-error-not-loggedin-friend' => 'עליכם להיכנס לחשבון כדי להסיר חבר.',
	'ur-remove' => 'הסרה',
	'ur-cancel' => 'ביטול',
	'ur-login' => 'כניסה לחשבון',
	'ur-add-title-foe' => 'האם ברצונכם להוסיף את $1 כיריבכם?',
	'ur-add-title-friend' => 'האם ברצונכם להוסיף את $1 כחברכם?',
	'ur-add-message-foe' => 'אתם עומדים להוסיף את $1 כיריבכם.
אנו נודיע ל־$1 כדי לאשר את איבתכם.',
	'ur-add-message-friend' => 'אתם עומדי להוסיף את $1 כחברכם.
אנו נודיע ל־$1 כדי לאשר את חברותכם.',
	'ur-friendship' => 'חברות',
	'ur-grudge' => 'איבה',
	'ur-add-button' => 'הוספה כ$1',
	'ur-add-button-foe' => 'הוספה כיריב',
	'ur-add-button-friend' => 'הוספה כחבר',
	'ur-add-sent-title-foe' => 'שלחנו את בקשת היריבות שלך אל $1!',
	'ur-add-sent-title-friend' => 'שלחנו את בקשת החברות שלך אל $1!',
	'ur-add-sent-message-foe' => 'בקשת היריבות שלכם נשלחה אל $1 לאישור.
אם $1 יאשר את בקשתכם, תקבלו הודעה נוספת בדוא"ל.',
	'ur-add-sent-message-friend' => 'בקשת החברות שלכם נשלחה אל $1 לאישור.
אם $1 יאשר את בקשתכם, תקבלו הודעה נוספת בדוא"ל.',
	'ur-add-error-message-no-user' => 'המשתמש אותו אתם מנסים להוסיף אינו קיים.',
	'ur-add-error-message-blocked' => 'הינכם חסומים ואינכם יכולים להוסיף חברים או יריבים.',
	'ur-add-error-message-yourself' => 'לא תוכלו להוסיף את עצמכם כחבר או כיריב.',
	'ur-add-error-message-existing-relationship' => 'הינכם כבר $1 של $2.',
	'ur-add-error-message-existing-relationship-foe' => 'אתם ו־$1 כבר יריבים.',
	'ur-add-error-message-existing-relationship-friend' => 'אתם ו־$1 כבר חברים.',
	'ur-add-error-message-pending-request-title' => 'סבלנות!',
	'ur-add-error-message-pending-friend-request' => 'יש לכם בקשת חברות ממתינה עם $1.
אתם תקבלו הודעה כש־$1 יאשר את בקשתכם.',
	'ur-add-error-message-pending-foe-request' => 'יש לכם בקשת יריבות ממתינה עם $1.
אתם תקבלו הודעה כש־$1 יאשר את בקשתכם.',
	'ur-add-error-message-not-loggedin' => 'עליכם להיכנס לחשבון כדי להוסיף $1',
	'ur-add-error-message-not-loggedin-foe' => 'עליכם להיכנס לחשבון כדי להוסיף יריב',
	'ur-add-error-message-not-loggedin-friend' => 'עליכם להיכנס לחשבון כדי להוסיף חבר',
	'ur-requests-title' => 'בקשות חברות',
	'ur-requests-message-foe' => '<a href="$1">$2</a> מעונין להיות יריבכם.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> מעונין להיות חברכם.',
	'ur-accept' => 'אישור',
	'ur-reject' => 'דחייה',
	'ur-no-requests-message' => 'אין לכם בקשות חברות או יריבות.
אם ברצונכם בחברים נוספים, <a href="$1">הזמינו אותם!</a>',
	'ur-requests-added-message-foe' => 'הוספתם את $1 כיריבכם.',
	'ur-requests-added-message-friend' => 'הוספתם את $1 כחברכם.',
	'ur-requests-reject-message-friend' => 'דחיתם את בקשת $1 להיות חברכם.',
	'ur-requests-reject-message-foe' => 'דחיתם את בקשת $1 להיות יריבכם.',
	'ur-title-foe' => 'רשימת היריבים של $1',
	'ur-title-friend' => 'רשימת החברים של $1',
	'friend_request_subject' => '$1 הוסיף אתכם כחבר ב{{grammar:תחילית|{{SITENAME}}}}!',
	'friend_request_body' => 'היי $1:

$2 הוסיף אתכם כחבר ב{{grammar:תחילית|{{SITENAME}}}}.  רצינו לוודא ששניכם אכן חברים.

אנא לחצו על קישור זה כדי לאשר שאתם חברים:
$3

תודה

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'foe_request_subject' => 'זוהי מלחמה! $1 הוסיף אתכם כיריב ב{{grammar:תחילית|{{SITENAME}}}}!',
	'foe_request_body' => 'היי $1:

$2 הוסיף אתכם כיריב ב{{grammar:תחילית|{{SITENAME}}}}. רצינו רק לוודא ששניכם אכן אויבים עד המוות או לפחות נמצאים בוויכוח.

אנא לחצו על קישור זה כדי לאמת את שידוך האיבה.

$3

תודה

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'friend_accept_subject' => '$1 קיבל את בקשת החברות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!',
	'friend_accept_body' => 'היי $1:

$2 קיבל את בקשת החברות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!

עיינו בדף של $2 ב־$3

תודה

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'foe_accept_subject' => 'המלחמה החלה! $1 קיבל את בקשת היריבות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!',
	'foe_accept_body' => 'היי $1:

$2 קיבל את בקשת היריבות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!

עיינו בדף של $2 ב־$3

תודה

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'friend_removed_subject' => 'אבוי! $1 הסיר אתכם כחברו ב{{grammar:תחילית|{{SITENAME}}}}!',
	'friend_removed_body' => 'היי $1:

$2 הסיר את החברות ביניכם ב{{grammar:תחילית|{{SITENAME}}}}!

תודה

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'foe_removed_subject' => 'ישששש! $1 הסיר אתכם כיריבו ב{{grammar:תחילית|{{SITENAME}}}}!',
	'foe_removed_body' => 'היי $1:

$2 הסיר אתכם כיריבו ב{{grammar:תחילית|{{SITENAME}}}}!

האם שניכם בדרך להפוך לחברים?

תודה

---

היי, מעוניינים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'ur-main-page' => 'मुखपृष्ठ',
	'ur-remove' => 'हटायें',
	'ur-cancel' => 'रद्द करें',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'ur-main-page' => 'Mayor nga Panid',
	'ur-cancel' => 'Kanselahon',
	'ur-login' => 'Mag sulod',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'ur-remove' => 'Ukloni',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 */
$messages['hu'] = array(
	'ur-error-page-title' => 'Upsz!',
	'ur-main-page' => 'Kezdőlap',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'viewrelationships' => 'Vider relation',
	'viewrelationshiprequests' => 'Vider requestas de relation',
	'ur-already-submitted' => 'Tu requesta ha essite inviate',
	'ur-error-page-title' => 'Uuups!',
	'ur-error-title' => 'Hola, tu prendeva un cammino errate!',
	'ur-error-message-no-user' => 'Nos non pote completar tu requesta, proque nulle usator con iste nomine existe.',
	'ur-main-page' => 'Pagina principal',
	'ur-your-profile' => 'Tu profilo',
	'ur-backlink' => '&lt; Retornar al profilo de $1',
	'ur-friend' => 'amico',
	'ur-foe' => 'inimico',
	'ur-relationship-count-foes' => '$1 ha $2 {{PLURAL:$2|inimico|inimicos}}. Vole plus inimicos? <a href="$3">Invita les.</a>',
	'ur-relationship-count-friends' => '$1 ha $2 {{PLURAL:$2|amico|amicos}}. Vole plus amicos? <a href="$3">Invita les.</a>',
	'ur-add-friends' => ' Vole plus amicos? <a href="$1">Invita les</a>',
	'ur-add-friend' => 'Adder como amico',
	'ur-add-foe' => 'Adder como inimico',
	'ur-add-no-user' => 'Nulle usator seligite.
Per favor requesta amicos/inimicos via le ligamine correcte.',
	'ur-add-personal-message' => 'Adder un message personal',
	'ur-remove-relationship-friend' => 'Remover como amico',
	'ur-remove-relationship-foe' => 'Remover como inimico',
	'ur-give-gift' => 'Dar un dono',
	'ur-previous' => 'prec',
	'ur-next' => 'seq',
	'ur-remove-relationship-title-foe' => 'Vole tu remover $1 como tu inimico?',
	'ur-remove-relationship-title-confirm-foe' => 'Tu ha removite $1 como tu inimico',
	'ur-remove-relationship-title-friend' => 'Vole tu remover $1 como tu amico?',
	'ur-remove-relationship-title-confirm-friend' => 'Tu ha removite $1 como tu amico',
	'ur-remove-relationship-message-foe' => 'Tu ha requestate le remotion de $1 como tu inimico, preme "$2" pro confirmar.',
	'ur-remove-relationship-message-confirm-foe' => 'Tu ha removite $1 como tu inimico con successo.',
	'ur-remove-relationship-message-friend' => 'Tu ha requestate le remotion de $1 como tu amico, preme "$2" pro confirmar.',
	'ur-remove-relationship-message-confirm-friend' => 'Tu ha removite $1 como tu amico con successo.',
	'ur-remove-error-message-no-relationship' => 'Tu non ha un relation con $1.',
	'ur-remove-error-message-remove-yourself' => 'Tu non pote remover te mesme.',
	'ur-remove-error-message-pending-request' => 'Tu ha un requesta pendente de $1 con $2.',
	'ur-remove-error-message-pending-foe-request' => 'Tu ha un requesta pendente de inimico con $1.',
	'ur-remove-error-message-pending-friend-request' => 'Tu ha un requesta pendente de amico con $1.',
	'ur-remove-error-not-loggedin' => 'Tu debe aperir un session pro poter remover un $1.',
	'ur-remove-error-not-loggedin-foe' => 'Tu debe aperir un session pro poter remover un inimico.',
	'ur-remove-error-not-loggedin-friend' => 'Tu debe aperir un session pro poter remover un amico.',
	'ur-remove' => 'Remover',
	'ur-cancel' => 'Cancellar',
	'ur-login' => 'Aperir un session',
	'ur-add-title-foe' => 'Vole tu adder $1 como tu inimico?',
	'ur-add-title-friend' => 'Vole tu adder $1 como tu amico?',
	'ur-add-message-foe' => 'Tu es super le puncto de adder $1 como tu inimico.
Nos notificara $1 pro confirmar tu rancor.',
	'ur-add-message-friend' => 'Tu es super le puncto de adder $1 como tu amico.
Nos notificara $1 pro confirmar tu amicitate.',
	'ur-friendship' => 'amicitate',
	'ur-grudge' => 'rancor',
	'ur-add-button' => 'Adder como $1',
	'ur-add-button-foe' => 'Adder como inimico',
	'ur-add-button-friend' => 'Adder como amico',
	'ur-add-sent-title-foe' => 'Nos ha inviate tu requesta de inimico a $1!',
	'ur-add-sent-title-friend' => 'Nos ha inviate tu requesta de amico a $1!',
	'ur-add-sent-message-foe' => 'Tu requesta de inimico ha essite inviate a $1 pro confirmation.
Si $1 confirma tu requesta, tu essera informate de isto in e-mail.',
	'ur-add-sent-message-friend' => 'Tu requesta de amico ha essite inviate a $1 pro confirmation.
Si $1 confirma tu requesta, tu essera informate de isto in e-mail.',
	'ur-add-error-message-no-user' => 'Le usator que tu vole adder non existe.',
	'ur-add-error-message-blocked' => 'Tu es actualmente blocate e non pote adder amicos o inimicos.',
	'ur-add-error-message-yourself' => 'Tu non pote adder te mesme como amico o inimico.',
	'ur-add-error-message-existing-relationship' => 'Tu e $1 es ja $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Tu e $1 es ja inimicos.',
	'ur-add-error-message-existing-relationship-friend' => 'Tu e $1 es ja amicos.',
	'ur-add-error-message-pending-request-title' => 'Patientia!',
	'ur-add-error-message-pending-friend-request' => 'Tu ha un requesta pendente de amico con $1.
Nos te notificara quando $1 confirma tu requesta.',
	'ur-add-error-message-pending-foe-request' => 'Tu ha un requesta pendente de inimico con $1.
Nos te notificara quando $1 confirma tu requesta.',
	'ur-add-error-message-not-loggedin' => 'Tu debe aperir un session pro poter adder un $1.',
	'ur-add-error-message-not-loggedin-foe' => 'Tu debe aperir un session pro poter adder un inimico.',
	'ur-add-error-message-not-loggedin-friend' => 'Tu debe aperir un session pro poter adder un amico.',
	'ur-requests-title' => 'Requestas de relation',
	'ur-requests-message-foe' => '<a href="$1">$2</a> vole esser tu inimico.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> vole esser tu amico.',
	'ur-accept' => 'Acceptar',
	'ur-reject' => 'Rejectar',
	'ur-no-requests-message' => 'Tu non ha requestas de amico o inimico.
Si tu vole plus amicos, <a href="$1">invita les!</a>',
	'ur-requests-added-message-foe' => 'Tu ha addite $1 como inimico.',
	'ur-requests-added-message-friend' => 'Tu ha addite $1 como amico.',
	'ur-requests-reject-message-friend' => 'Tu ha rejectate $1 como amico.',
	'ur-requests-reject-message-foe' => 'Tu ha rejectate $1 como inimico.',
	'ur-title-foe' => 'Lista de inimicos de $1',
	'ur-title-friend' => 'Lista de amicos de $1',
	'friend_request_subject' => '$1 te ha addite como amico in {{SITENAME}}!',
	'friend_request_body' => 'Salute $1,

$2 te ha addite como amico in {{SITENAME}}. Nos vole assecurar que le duo de vos es de facto amicos.

Per favor clicca super iste ligamine pro confirmar vostre amicitate:
$3

Gratias.

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
	'foe_request_subject' => 'Il face guerra! $1 te ha addite como inimico in {{SITENAME}}!',
	'foe_request_body' => 'Salute $1,

$2 justo te listava como inimico in {{SITENAME}}. Nos vole assecurar que le duo de vos es de facto inimicos mortal, o al minus ha un conflicto.

Per favor clicca super iste ligamine pro confirmar vostre rancor mutual:

$3

Gratias.

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
	'friend_accept_subject' => '$1 ha acceptate tu requesta de amico in {{SITENAME}}!',
	'friend_accept_body' => 'Salute $1,

$2 ha acceptate tu requesta de amico in {{SITENAME}}!

Sia secur de vider le pagina de $2 a $3

Gratias.

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
	'foe_accept_subject' => 'Alea iacta est! $1 ha acceptate tu requesta de inimico in {{SITENAME}}!',
	'foe_accept_body' => 'Salute $1,

$2 ha acceptate tu requesta de inimico in {{SITENAME}}!

Sia secur de scrutinar le pagina de $2 a $3

Gratias.

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
	'friend_removed_subject' => 'Oh no! $1 te ha removite como amico in {{SITENAME}}!',
	'friend_removed_body' => 'Salute $1,

$2 te ha removite como amico in {{SITENAME}}!

Gratias

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
	'foe_removed_subject' => 'Victoria! $1 te ha removite como inimico in {{SITENAME}}!',
	'foe_removed_body' => 'Salute $1,

$2 te ha removite como inimico in {{SITENAME}}!

Pote esser que le duo de vos es in via de devenir amicos?

Gratias

---

Tu non vole reciper plus e-mail de nos?

Clicca $4
e disactiva in tu preferentias le notificationes per e-mail.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'ur-cancel' => 'Batalkan',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'ur-main-page' => 'Pagina principale',
);

/** Japanese (日本語)
 * @author Aotake
 */
$messages['ja'] = array(
	'viewrelationships' => '関係を表示',
	'viewrelationshiprequests' => '関係申請を表示',
	'ur-already-submitted' => '申請を送信しました',
	'ur-error-page-title' => 'おっと！',
	'ur-error-message-no-user' => 'その名前の利用者は存在しないため申請を完了できません。',
	'ur-main-page' => 'メインページ',
	'ur-your-profile' => 'あなたのプロファイル',
	'ur-backlink' => '&lt; $1のプロファイルに戻る',
	'ur-relationship-count-foes' => '$1には$2人の敵がいます。敵を増やしますか？<a href="$3">招待する。</a>',
	'ur-relationship-count-friends' => '$1には$2人の友人がいます。友人を増やしますか？<a href="$3">招待する。</a>',
	'ur-add-friends' => '友人を増やしますか？<a href="$1">招待する。</a>',
	'ur-add-friend' => '友人として追加',
	'ur-add-foe' => '敵として追加',
	'ur-add-no-user' => '利用者が選択されていません。正しいリンクを使って友人/敵申請を行ってください。',
	'ur-add-personal-message' => '私的なメッセージを追加',
	'ur-remove-relationship-friend' => '友人から除去',
	'ur-remove-relationship-foe' => '敵から除去',
	'ur-give-gift' => 'プレゼントを贈る',
	'ur-previous' => '前',
	'ur-next' => '次',
	'ur-remove-relationship-title-foe' => '$1をあなたの敵から除去しますか？',
	'ur-remove-relationship-title-confirm-foe' => '$1を敵から除去しました',
	'ur-remove-relationship-title-friend' => '$1を友人から除去しますか？',
	'ur-remove-relationship-title-confirm-friend' => '$1を友人から除去しました',
	'ur-remove-relationship-message-foe' => '$1を敵から除去することを選択しました。操作を完了するには "$2" を押してください。',
	'ur-remove-relationship-message-confirm-foe' => '$1を敵から除去しました。',
	'ur-remove-relationship-message-friend' => '$1を友人から除去することを選択しました。操作を完了するには "$2" を押してください。',
	'ur-remove-relationship-message-confirm-friend' => '$1を友人から除去しました。',
	'ur-remove-error-message-no-relationship' => '$1との関係は設定されていません。',
	'ur-remove-error-message-remove-yourself' => '自分自身を除去することはできません。',
	'ur-remove-error-message-pending-foe-request' => '$1に対する敵申請が保留中です。',
	'ur-remove-error-message-pending-friend-request' => '$1に対する友人申請が保留中です。',
	'ur-remove-error-not-loggedin-foe' => '敵を除去するためにはログインしている必要があります。',
	'ur-remove-error-not-loggedin-friend' => '友人を除去するためにはログインしている必要があります。',
	'ur-remove' => '除去',
	'ur-cancel' => 'キャンセル',
	'ur-login' => 'ログイン',
	'ur-add-title-foe' => '$1 を敵に追加しますか？',
	'ur-add-title-friend' => '$1 を友人に追加しますか？',
	'ur-add-message-foe' => '$1 をあなたの敵にしようとしています。$1 には私たちからあなたが敵意を抱いていることを伝えます。',
	'ur-add-message-friend' => '$1 をあなたの友人にしようとしています。$1 には私たちからあなたが親愛の情を抱いていることを伝えます。',
	'ur-add-button-foe' => '敵に追加',
	'ur-add-button-friend' => '友人に追加',
	'ur-add-sent-title-foe' => '$1に敵申請を送信しました！',
	'ur-add-sent-title-friend' => '$1に友人申請を送信しました！',
	'ur-add-sent-message-foe' => '$1に敵申請の確認が送信されました。$1があなたの申請を承認すると、確認の電子メールが届きます。',
	'ur-add-sent-message-friend' => '$1に友人申請の確認が送信されました。$1があなたの申請を承認すると、確認の電子メールが届きます。',
	'ur-add-error-message-no-user' => '追加しようとしている名前の利用者は存在しません。',
	'ur-add-error-message-blocked' => '現在ブロックされているため友人や敵を追加できません。',
	'ur-add-error-message-yourself' => '自分自身を友人や敵に追加することはできません。',
	'ur-add-error-message-existing-relationship-foe' => '$1とはすでに敵関係です。',
	'ur-add-error-message-existing-relationship-friend' => '$1とはすでに友人関係です。',
	'ur-add-error-message-pending-friend-request' => '$1との友人申請は保留中です。$1があなたの申請を承認したら連絡します。',
	'ur-add-error-message-pending-foe-request' => '$1との敵申請は保留中です。$1があなたの申請を承認したら連絡します。',
	'ur-add-error-message-not-loggedin-foe' => '敵を追加するにはログインしている必要があります。',
	'ur-add-error-message-not-loggedin-friend' => '友人を追加するにはログインしている必要があります。',
	'ur-requests-title' => '関係申請',
	'ur-requests-message-foe' => '<a href="$1">$2</a> があなたの敵になりたがっています。',
	'ur-requests-message-friend' => '<a href="$1">$2</a> があなたの友人になりたがっています。',
	'ur-accept' => '承認',
	'ur-reject' => '却下',
	'ur-no-requests-message' => '申請中の敵や友人はありません。友人を増やしたければ<a href="$1">招待してください！</a>',
	'ur-requests-added-message-foe' => '$1を敵に追加しました。',
	'ur-requests-added-message-friend' => '$1を友人に追加しました。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'ur-already-submitted' => 'Panyuwunan panjenengan wis dikirim',
	'ur-error-title' => 'Adhuh, panjenengan salah ménggok!',
	'ur-main-page' => 'Kaca utama',
	'ur-your-profile' => 'Profil panjenengan',
	'ur-friend' => 'kanca',
	'ur-foe' => 'mungsuh',
	'ur-give-gift' => 'Mènèhi bebungah',
	'ur-previous' => 'sadurungé',
	'ur-next' => 'sabanjuré',
	'ur-remove' => 'Busak',
	'ur-cancel' => 'Batal',
	'ur-login' => 'Log mlebu',
	'ur-friendship' => 'kekancan',
	'ur-add-button' => 'Tambah minangka $1',
	'ur-add-error-message-existing-relationship' => 'Panjenengan wis $1 karo $2.',
	'ur-add-error-message-pending-request-title' => 'Tulung sabar sadélok.',
	'ur-add-error-message-not-loggedin' => 'Panjenengan kudu log mlebu kanggo nambahaké $1',
	'ur-accept' => 'Tampa',
	'ur-reject' => 'Tulak',
	'ur-no-requests-message' => 'Panjenengan ora duwé panyuwunan kanca utawa mungsuh.
Yèn panjenengan péngin kanca luwih akèh, <a href="$1">ayo padha diundhang!</a>',
	'foe_request_subject' => 'Saiki perang! $1 wis nambahaké panjenengan minangka mungsuh ing {{SITENAME}}!',
	'friend_removed_subject' => 'Adhuh! $1 njabel status panjenengan minangka kanca ing {{SITENAME}}!',
	'foe_removed_subject' => 'Horé! $1 wis njabel status panjenengan minangka mungsuh ing {{SITENAME}}!',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'viewrelationships' => 'មើល​ទំនាក់ទំនង',
	'viewrelationshiprequests' => 'មើល​សំណើ​ទំនាក់ទំនង',
	'ur-already-submitted' => 'សំណើ​របស់​អ្នក​ត្រូវ​បាន​ផ្ញើ​ហើយ',
	'ur-error-page-title' => 'Woops!',
	'ur-error-message-no-user' => 'យើង​មិន​អាច​បំពេញ​តាម​សំណើ​របស់​អ្នក​បានទេ ព្រោះ​មិនមាន​អ្នកប្រើប្រាស់​មាន​ឈ្មោះ​ដូចនេះ​ទេ​។',
	'ur-main-page' => 'ទំព័រដើម',
	'ur-your-profile' => 'ព័ត៌មានផ្ទាល់ខ្លួនរបស់អ្នក',
	'ur-backlink' => '&lt; ត្រឡប់​ទៅ ព័ត៌មានផ្ទាល់ខ្លួន របស់ $1',
	'ur-friend' => 'មិត្តភ័ក្ដិ',
	'ur-foe' => 'បច្ចាមិត្ត',
	'ur-relationship-count-foes' => '$1 មាន $2 {{PLURAL:$2|បច្ចាមិត្ត|បច្ចាមិត្ត}}​។ ត្រូវការ​បច្ចាមិត្ត​បន្ថែម​ឬ​? <a href="$3">អញ្ជើញ​ពួកគេ​។</a>',
	'ur-relationship-count-friends' => '$1 មាន $2 {{PLURAL:$2|មិត្តភ័ក្ដិ|មិត្តភ័ក្ដិ}}​។ ត្រូវការ​មិត្តភ័ក្ដិ​បន្ថែម​ឬ​? <a href="$3">អញ្ជើញ​ពួកគេ​។</a>',
	'ur-add-friends' => 'ត្រូវការ​មិត្តភ័ក្ដិ​បន្ថែម​ឬ? <a href="$1">អញ្ជើញ​ពួកគេ</a>',
	'ur-add-friend' => 'បន្ថែម​ជា​មិត្តភ័ក្ដិ',
	'ur-add-foe' => 'បន្ថែម​ជា​បច្ចាមិត្ត',
	'ur-add-no-user' => 'គ្មាន​អ្នកប្រើប្រាស់​ត្រូវ​បាន​ជ្រើស​ទេ​។

សូម​ដាក់ស្នើ​នូវ មិត្តភ័ក្ដិ/បច្ចាមិត្ត ដែល​មាន​តំណភ្ជាប់​ត្រឹមត្រូវ​។',
	'ur-add-personal-message' => 'បន្ថែម​សារ​ផ្ទាល់ខ្លួន​មួយ',
	'ur-remove-relationship-friend' => 'ដកចេញ​ពី​មិត្តភ័ក្ដិ',
	'ur-remove-relationship-foe' => 'ដកចេញ​ពី​បច្ចាមិត្ត',
	'ur-give-gift' => 'ជូនអំណោយ',
	'ur-previous' => 'មុន',
	'ur-next' => 'បន្ទាប់',
	'ur-remove-relationship-title-foe' => 'តើ​អ្នក​ពិតជា​ចង់​ដក $1 ចេញ​ពី​បច្ចាមិត្ត​របស់​អ្នក​ឬ​?',
	'ur-remove-relationship-title-confirm-foe' => 'អ្នក​បាន​ដក $1 ចេញ​ពី​បច្ចាមិត្ត​របស់​អ្នក​ហើយ',
	'ur-remove-relationship-title-friend' => 'តើ​អ្នក​ពិតជា​ចង់​ដក $1 ចេញ​ពី​មិត្តភ័ក្ដិ​របស់​អ្នក​ឬ​?',
	'ur-remove-relationship-title-confirm-friend' => 'អ្នក​បាន​ដក $1 ចេញ​ពី​មិត្តភ័ក្ដិ​របស់​អ្នក​ហើយ',
	'ur-remove-relationship-message-foe' => 'អ្នក​បាន​ស្នើ​ឱ្យ​ដក $1 ចេញ​ពី​បច្ចាមិត្ត​របស់​អ្នក​ហើយ, ចូរ​សង្កត់ "$2" ដើម្បី​បញ្ជាក់អះអាង​។',
	'ur-remove-relationship-message-confirm-foe' => 'អ្នក​បាន​ដក $1 ចេញ​ពី​បច្ចាមិត្ត​របស់​អ្នក ដោយ​ជោគជ័យ​ហើយ​។',
	'ur-remove-relationship-message-friend' => 'អ្នក​បាន​ស្នើ​ឱ្យ​ដក $1 ចេញ​ពី​មិត្តភ័ក្ដិ​របស់​អ្នក​ហើយ, ចូរ​សង្កត់ "$2" ដើម្បី​បញ្ជាក់អះអាង​។',
	'ur-remove-relationship-message-confirm-friend' => 'អ្នក​បាន​ដក $1 ចេញ​ពី​មិត្តភ័ក្ដិ​របស់​អ្នក ដោយ​ជោគជ័យ​ហើយ​។',
	'ur-remove-error-message-no-relationship' => 'អ្នក​មិនមាន​ទំនាក់ទំនង​ជាមួយ $1 ទេ​។',
	'ur-remove-error-message-remove-yourself' => 'អ្នក​មិន​អាច​ដកចេញ​ដោយ​ខ្លួនឯង​បាន​ទេ​?',
	'ur-remove-error-not-loggedin' => 'អ្នកត្រូវតែ ពិនិត្យចូល ដើម្បី ដកចេញ $1 ។',
	'ur-remove-error-not-loggedin-foe' => 'អ្នក​ត្រូវតែ​ឡុកអ៊ីនចូល​សិន ដើម្បី​ដក​បច្ចាមិត្ត​ចេញ​។',
	'ur-remove-error-not-loggedin-friend' => 'អ្នក​ត្រូវតែ​ឡុកអ៊ីនចូល​សិន ដើម្បី​ដក​មិត្តភ័ក្ដិ​ចេញ​។',
	'ur-remove' => 'ដកចេញ',
	'ur-cancel' => 'បោះបង់',
	'ur-login' => 'ចូល',
	'ur-add-title-foe' => 'តើ​អ្នក​ពិតជា​ចង់​បន្ថែម $1 ជា​បច្ចាមិត្ត​របស់​អ្នក​ឬ​?',
	'ur-add-title-friend' => 'តើ​អ្នក​ពិតជា​ចង់​បន្ថែម $1 ជា​មិត្តភ័ក្ដិ​របស់​អ្នក​ឬ​?',
	'ur-add-message-foe' => 'អ្នក​ប្រហែល​ជា​បន្ថែម $1 ជា​បច្ចាមិត្ត​របស់​អ្នក​។

អ្នក​នឹង​ជូនដំណឹង $1 ដើម្បី​បញ្ជាក់អះអាង​នូវវិវាទ​របស់​អ្នក​។',
	'ur-add-message-friend' => 'អ្នក​ប្រហែល​ជា​បន្ថែម $1 ជា​មិត្តភ័ក្ដិ​របស់​អ្នក​។

អ្នក​នឹង​ជូនដំណឹង $1 ដើម្បី​បញ្ជាក់អះអាង​នូវមិត្តភាព​របស់​អ្នក​។',
	'ur-friendship' => 'មិត្តភាព',
	'ur-grudge' => 'វិវាទ',
	'ur-add-button' => 'បន្ថែម​ជា $1',
	'ur-add-button-foe' => 'បន្ថែម​ជា​បច្ចាមិត្ត',
	'ur-add-button-friend' => 'បន្ថែម​ជា​មិត្តភ័ក្ដិ',
	'ur-add-sent-title-foe' => 'អ្នក​បាន​ផ្ញើ​សំណើ​បច្ចាមិត្ត​របស់​អ្នក​ទៅ $1 ហើយ​!',
	'ur-add-sent-title-friend' => 'អ្នក​បាន​ផ្ញើ​សំណើ​មិត្តភ័ក្ដិ​របស់​អ្នក​ទៅ $1 ហើយ​!',
	'ur-add-error-message-no-user' => 'អ្នកប្រើប្រាស់ ដែល​អ្នក​កំពុង​ព្យាយាម​បន្ថែម​នេះ​មិនទាន់មាន​ទេ​។',
	'ur-add-error-message-blocked' => 'ឥឡូវនេះ អ្នក​ត្រូវ​បាន​រាំងខ្ទប់ ហើយ​មិន​អាច​បន្ថែម​មិត្តភ័ក្ដិ ឬ បច្ចាមិត្ត​បាន​ឡើយ​។',
	'ur-add-error-message-yourself' => 'អ្នក​មិន​អាច​បន្ថែម​ជា​មិត្តភក្ដិ ឬ បច្ចាមិត្ត​ដោយ​ខ្លួនឯង​បាន​ឡើយ​។',
	'ur-add-error-message-existing-relationship' => 'អ្នក​មាន $1 រួចហើយ ជាមួយ $2​។',
	'ur-add-error-message-existing-relationship-foe' => 'អ្នក​ជា​បច្ចាមិត្ត​រួចហើយ​ជាមួយ $1 ។',
	'ur-add-error-message-existing-relationship-friend' => 'អ្នក​ជា​មិត្តភ័ក្ដិ​រួចហើយ​ជាមួយ $1 ។',
	'ur-add-error-message-pending-request-title' => 'ខន្តី អត់ធ្មត់ !',
	'ur-add-error-message-not-loggedin' => 'អ្នកត្រូវតែ​បានឡុកអ៊ីនចូល ដើម្បី​បន្ថែម $1',
	'ur-add-error-message-not-loggedin-foe' => 'អ្នកត្រូវតែ​បានឡុកអ៊ីនចូល ដើម្បី​បន្ថែម​បច្ចាមិត្ត',
	'ur-add-error-message-not-loggedin-friend' => 'អ្នកត្រូវតែ​បានឡុកអ៊ីនចូល ដើម្បី​បន្ថែម​មិត្តភ័ក្ដិ',
	'ur-requests-title' => 'សំណើ​សុំ​ការ​ទំនាក់ទំនង',
	'ur-requests-message-foe' => '<a href="$1">$2</a> ចង់​ក្លាយជា​បច្ចាមិត្ត​របស់​អ្នក​។',
	'ur-requests-message-friend' => '<a href="$1">$2</a> ចង់​ក្លាយជា​មិត្តភ័ក្ដិ​របស់​អ្នក​។',
	'ur-accept' => 'ព្រមទទួល',
	'ur-reject' => 'ច្រានចោល',
	'ur-no-requests-message' => 'អ្នក​មិនមាន​សំណើសុំ​ជា​មិត្តភ័ក្ដិ ឬ បច្ចាមិត្ត​ទេ​។ 

ប្រសិនបើ អ្នក​ត្រូវការ​មិត្តភ័ក្ដិ​បន្ថែម​ទៀត, <a href="$1">ចូរ​អញ្ជើញ​ពួកគេ!</a>',
	'ur-requests-added-message-foe' => 'អ្នក​បាន​បន្ថែម $1 ជា​បច្ចាមិត្ត​របស់​អ្នក​ហើយ​។',
	'ur-requests-added-message-friend' => 'អ្នក​បាន​បន្ថែម $1 ជា​មិត្តភ័ក្ដិ​របស់​អ្នក​ហើយ​។',
	'ur-requests-reject-message-friend' => 'អ្នក​បាន​ច្រានចោល $1 ជា​មិត្តភ័ក្ដិ​របស់​អ្នក​ហើយ​។',
	'ur-requests-reject-message-foe' => 'អ្នក​បាន​ច្រានចោល $1 ជា​បច្ចមិត្ត​របស់​អ្នក​ហើយ​។',
	'ur-title-foe' => 'បញ្ជី​បច្ចាមិត្ត​របស់ $1',
	'ur-title-friend' => 'បញ្ជី​មិត្តភ័ក្ដិ​របស់ $1',
	'friend_request_subject' => '$1 បានបន្ថែមអ្នក ជា មិត្តភក្តិ លើ {{SITENAME}}!',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'ur-main-page' => 'Men Pej',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'ur-main-page' => 'Pono nga Pahina',
	'ur-cancel' => 'Kanselar',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'viewrelationships' => 'Bezösch beloore',
	'viewrelationshiprequests' => 'Don de Aanfroore noh Frünnschaff un Feinschaff un es beloore',
	'ur-already-submitted' => 'Dinge Wonsch es övvermeddelt woode',
	'ur-error-page-title' => 'Hoppela!',
	'ur-error-title' => 'Hoppala, doh es jet scheif jeloufe!',
	'ur-error-message-no-user' => 'Mer künne Ding Opdraach nit ußföhre, ene Metmaacher met dämm Name jit et jaa nit.',
	'ur-main-page' => 'Houpsigg',
	'ur-your-profile' => 'Ding Profil',
	'ur-backlink' => '← zerök op däm $1 sing Profil',
	'ur-friend' => 'Frünnd',
	'ur-foe' => 'Feind',
	'ur-relationship-count-foes' => 'Dä Metmaacher „$1“ hät {{PLURAL:$2|eine Feind|$2 Feinde|keine Feind}}.
Wells mieh Feinde?
<a href="$3">Donn se ennlade!.</a>',
	'ur-relationship-count-friends' => 'Dä Metmaacher „$1“ hät {{PLURAL:$2|eine Frünnd|$2 Frünnde|keine Frünnd}}.
Wells mieh Frünnde?
<a href="$3">Donn se ennlade!.</a>',
	'ur-add-friends' => ' De wells mieh Frünnde han?
<a href="$1">Don se enlade!</a>',
	'ur-add-friend' => 'Als Dinge Frünnd endraare',
	'ur-add-foe' => 'Als Dinge Feind endraare',
	'ur-add-no-user' => 'Keine Metmaacher usjesoht.
Bes esu joot, un donn Der Ding Frünnde un Feinde övver der reschtijje Link enndraare.',
	'ur-add-personal-message' => 'Donn en persönlesch Metdeilung dobei',
	'ur-remove-relationship-friend' => 'Uß de Frünndschaffs-Leß nämme',
	'ur-remove-relationship-foe' => 'Uß de Feindschaffs-Leß nämme',
	'ur-give-gift' => 'e Jeschengk jevve',
	'ur-previous' => 'förrije',
	'ur-next' => 'näx',
	'ur-remove-relationship-title-foe' => 'Do wells dä Metmaacher „$1“ uß Dinge Feindschaffs-Leß nämme?',
	'ur-remove-relationship-title-confirm-foe' => 'Do häß dä Metmaacher „$1“ uß Dinge Feindschaffs-Leß jenumme',
	'ur-remove-relationship-title-friend' => 'Do wells dä Metmaacher „$1“ uß Dinge Frünndschaffs-Leß nämme?',
	'ur-remove-relationship-title-confirm-friend' => 'Do häß dä Metmaacher „$1“ uß Dinge Frünndschaffs-Leß jenumme',
	'ur-remove-relationship-message-foe' => 'Do wells dä Metmaacher „$1“ uß Dinge Feindschaffs-Leß fott jenumme hann, kleck op „$2“, öm dat ze bestätijje.',
	'ur-remove-relationship-message-confirm-foe' => 'Do häs dä Metmaacher „$1“ jetz loß als Dinge Feind.',
	'ur-remove-relationship-message-friend' => 'Do wells dä Metmaacher „$1“ uß Dinge Frünndschaffs-Leß fot jenumme hann, kleck op „$2“, öm dat ze bestätijje.',
	'ur-remove-relationship-message-confirm-friend' => 'Do häs dä Metmaacher „$1“ jetz loß als Dinge Frünnd.',
	'ur-remove-error-message-no-relationship' => 'Do häß keine Bezoch zom Metmaacher „$1“.',
	'ur-remove-error-message-remove-yourself' => 'Mi Leevje, dat es Stuß: Do kanns Desch nit sellver eruß schmiiße.',
	'ur-remove-error-message-pending-request' => 'Do häß ene unbeäbeit $1-Aanfrooch met däm Metmaacher „$2“ aam Loufe.',
	'ur-remove-error-message-pending-foe-request' => 'Do häß ene unbeäbeit Feinschaffs-Aanfrooch met däm Metmaacher „$1“ aam Loufe.',
	'ur-remove-error-message-pending-friend-request' => 'Do häß ene unbeäbeit Frünndschaffs-Aanfrooch met däm Metmaacher „$1“ aam Loufe.',
	'ur-remove-error-not-loggedin' => 'Do moß ennjelogg sinn, öm ene $1 affzemelde.',
	'ur-remove-error-not-loggedin-foe' => 'Do moß ennjelogg sinn, öm ene Feind affzemelde.',
	'ur-remove-error-not-loggedin-friend' => 'Do moß ennjelogg sinn, öm ene Frünnd affzemelde.',
	'ur-remove' => 'Fott domet!',
	'ur-cancel' => 'Draanjevve',
	'ur-login' => 'Enlogge',
	'ur-add-title-foe' => 'Do wells dä Metmaacher „$1“ als ene Feind endraare?',
	'ur-add-title-friend' => 'Do wells dä Metmaacher „$1“ als ene Frünnd endraare?',
	'ur-add-message-foe' => 'Do bes dobei, dä Metmaacher „$1“ als ene Feind enzedraare.
Dä kritt jetz Bescheid övver Ding Feinschaff.',
	'ur-add-message-friend' => 'Do bes dobei, dä Metmaacher „$1“ als ene Frünnd enzedraare.
Dä kritt jetz Bescheid övver Ding Frünndschaff.',
	'ur-friendship' => 'Frünndschaff',
	'ur-grudge' => 'Ärjer un Feinschaff',
	'ur-add-button' => 'Als $1 bei donn',
	'ur-add-button-foe' => 'Als Feind dobei donn',
	'ur-add-button-friend' => 'Als Frünnd dobei donn',
	'ur-add-sent-title-foe' => 'Ding Feindschaffs-Aanjebott es aan $1 jescheck!',
	'ur-add-sent-title-friend' => 'Ding Frünnndschaffs-Aanjebott es aan $1 jescheck!',
	'ur-add-sent-message-foe' => 'Ding Feindschaffs-Aanjebott es aan $1 jescheck woode, zom Beshtätijje.
Wann di Beshtätijung och kütt, kriß De en e-mail jescheck.',
	'ur-add-sent-message-friend' => 'Dinge Frünndschaffs-Aanjebott es aan $1 jescheck woode, zom Beshtätijje.
Wann di Beshtätijung och kütt, kriß De en e-mail jescheck.',
	'ur-add-error-message-no-user' => 'Dä Metmaacher jitt et janit, dä De dobei donn wells.',
	'ur-add-error-message-blocked' => 'Do bes jrad jesperrt, un kanns kein Frünnde udder Feinde enndraare.',
	'ur-add-error-message-yourself' => 'Mi Leevje, dat es doch Stuß: Do kann nit Frünnd udder Feind fun Der sellver wääde.',
	'ur-add-error-message-existing-relationship' => 'Do bes ald $1 met däm $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Dä Metmaacher „$1“ un Do, Ühr sitt alld Feinde meddenein.',
	'ur-add-error-message-existing-relationship-friend' => 'Do beß alld Frünnd met dämm „$1“.',
	'ur-add-error-message-pending-request-title' => 'Jedold!',
	'ur-add-error-message-pending-friend-request' => 'Do häß norr_en onbeschtätesch Frünndschaffß-Aanfroch aan dä Metmaacher „$1“.
Do kreß Bescheid, wann hä udder it se bestätesch.',
	'ur-add-error-message-pending-foe-request' => 'Do häß norr_en onbeschtätesch Feinschaffs-Aanfroch aan dä Metmaacher „$1“.
Do kreß Bescheid, wann hä udder it se bestätesch.',
	'ur-add-error-message-not-loggedin' => 'Do moß enjelogg sinn, öm ene $1 enzedraare',
	'ur-add-error-message-not-loggedin-foe' => 'För Ding Feinschaffte ze flääje, moß de ald enjelogg sinn',
	'ur-add-error-message-not-loggedin-friend' => 'För Ding Frünndschaffte ze flääje, moß de ald enjelogg sinn',
	'ur-requests-title' => 'Aanfrooch noh Frünndschaff udder Feinschaff',
	'ur-requests-message-foe' => 'Dä Metmaacher <a href="$1">$2</a> well Dinge Feind sinn.',
	'ur-requests-message-friend' => 'Dä Metmaacher <a href="$1">$2</a> well Dinge Fründ sinn.',
	'ur-accept' => 'Aannemme',
	'ur-reject' => 'Afflehne',
	'ur-no-requests-message' => 'Do häß kein Frunndschaffs- udder Feintschaffts-Aanfrore.
Wann de mieh dofun hann wells, <a href="$1">donn se einlade!</a>',
	'ur-requests-added-message-foe' => 'Do has dä Metmaacher „$1“ als Dinge Feind.',
	'ur-requests-added-message-friend' => 'Do has dä Metmaacher „$1“ als Dinge Frünnd.',
	'ur-requests-reject-message-friend' => 'Do has dä Metmaacher „$1“ als Dinge Frünnd affjelehnt.',
	'ur-requests-reject-message-foe' => 'Do has dä Metmaacher „$1“ als Dinge Feind affjelehnt.',
	'ur-title-foe' => 'Dem „$1“ sing Feindesleß',
	'ur-title-friend' => 'Dem „$1“ sing Frünndschaffßleß',
	'friend_request_subject' => 'Metmaacher „$1“ fun de {{SITENAME}} hät Desch als ene Frünnd opjenomme.',
	'friend_request_body' => 'Hallo $1,

Dä Metmaacher $2 hät Desch als ene Frünnd enjedrare op de
{{SITENAME}}.
Mer wolle jeweß sin, dat Ühr zwei en der Tat Üsch jröhn
un Frünnde sitt un Üsch winnischstens ligge künnt.

Donn op dä Link klicke, öm dat ze bestätije.

$3

Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'foe_request_subject' => 'Kreesch op de {{SITENAME}} — dä Metmaacher „$1“ hät Desch als ene Feind ennjedraare.',
	'foe_request_body' => 'Hallo $1,

Dä Metmaacher $2 hät Desch als ene Feind enjedrare op de
{{SITENAME}}.
Mer wolle jeweß sin, dat Ühr zwei en der Tat Üsch net jröhn
un Dutfeinde sitt udder winnischstens aam Strigge.

Donn op dä Link klicke, öm dat ze bestätije.

$3

Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'friend_accept_subject' => 'Dä Metmaacher „$1“ hät Ding Frünndschaffs-Aanfrooch op de {{SITENAME}} beschtätesch.',
	'friend_accept_body' => 'Hallo $1,

Dä Metmaacher $2 hät Desch als ene Fründ bestätesch op de
{{SITENAME}}.
Do kann däm sing Metmaacher-Sigg fenge unger däm URL
$3

Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'foe_accept_subject' => 'Dä Metmaacher „$1“ hät Ding Feindschaffs-Aanfrooch op de {{SITENAME}} beschtätesch.',
	'foe_accept_body' => 'Hallo $1,

Dä Metmaacher $2 hät Desch als ene Feind bestätesch op de
{{SITENAME}}.
Do kann däm sing Metmaacher-Sigg fenge unger däm URL
$3

Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'friend_removed_subject' => 'Dä Metmaacher „$1“ hät de Frünndschaff met Dir op de {{SITENAME}} jekündesch.',
	'friend_removed_body' => 'Hallo $1,

Dä Metmaacher $2 hät Der de Frünndschaff jekündesch,
un Desch och uß singe Fründesleß ußjedraare, op de
{{SITENAME}}.


Dä, jetz weiß De dat. 
Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'foe_removed_subject' => 'Dä Metmaacher „$1“ hät de Feindschaff met Dir op de {{SITENAME}} jekündesch.',
	'foe_removed_body' => 'Hallo $1,

Dä Metmaacher $2 hät Der de Feindschaff jekündesch,
un Desch och uß singe Feindesleß ußjedraare, op de
{{SITENAME}}.

Dä, jetz weiß De dat. 
Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'viewrelationships' => 'Relatioun weisen',
	'viewrelationshiprequests' => 'Ufroe fir Relatioune weisen',
	'ur-already-submitted' => 'Är Ufro gouf fortgeschéckt',
	'ur-error-page-title' => 'ups!',
	'ur-error-title' => 'Ups, hei geet et net weider!',
	'ur-error-message-no-user' => 'Mir kënnen Är Ufro net ausféieren, well et kee Benotzer mat dem Numm gëtt.',
	'ur-main-page' => 'Haaptsäit',
	'ur-your-profile' => 'Äre Profil',
	'ur-backlink' => '&lt; Zréck op de Profil vum $1',
	'ur-relationship-count-foes' => '$1 huet $2 {{PLURAL:$2|Géigner|Géigner}}. Wëllt Dir méi Géigner? a href="$3">Invitéiert se.</a>',
	'ur-relationship-count-friends' => '$1 huet $2 {{PLURAL:$2|Frënd|Frënn}}. Wëllt Dir méi Frënn? <a href="$3">Invitéiert se.</a>',
	'ur-add-friends' => ' Wëllt Dir méi Frënn? <a href="$1">Invitéiert se</a>',
	'ur-add-friend' => 'Als Frënd derbäisetzen',
	'ur-add-foe' => 'Als Géigner derbäisetzen',
	'ur-add-no-user' => 'Kee Benotzer ausgewielt.
Maacht Ufroe fir Frënn/Géigner mat dem richtege Link.',
	'ur-add-personal-message' => 'Eng perséinlech Noriicht derbäisetzen',
	'ur-remove-relationship-friend' => 'Als Frënd ewechhuelen',
	'ur-remove-relationship-foe' => 'Als Géigner ewechhuelen',
	'ur-give-gift' => 'Cadeau schécken',
	'ur-previous' => 'vireg',
	'ur-next' => 'nächst',
	'ur-remove-relationship-title-foe' => 'Wëllt Dir de Benotzer $1 als Äre Géigner ewechhuelen?',
	'ur-remove-relationship-title-confirm-foe' => 'Dir hutt de Benotzer $1 als Äre Géigner ewechgeholl',
	'ur-remove-relationship-title-friend' => 'Wëllt dir de Benotzer $1 als Äre Frënd ewechhuelen?',
	'ur-remove-relationship-title-confirm-friend' => 'Dir hutt de Benotzer $1 als Äre Frënd ewechgeholl',
	'ur-remove-relationship-message-foe' => 'Dir hutt ugefrot fir de Benotzer $1 als Äre Géigner ewechzehuelen, dréckt "$2" fir ze confirméieren.',
	'ur-remove-relationship-message-confirm-foe' => 'Dir hutt de Benotzer $1 als Äre Géigner ewechgeholl.',
	'ur-remove-relationship-message-friend' => 'Dir hutt ugefrot fir de Benotzer $1 als Äre Frënd ewechzehuelen, dréckt "$2" fir ze confirméieren.',
	'ur-remove-relationship-message-confirm-friend' => 'Dir hutt de Benotzer $1 als Äre Frënd ewechgeholl.',
	'ur-remove-error-message-no-relationship' => 'Dir hutt keng Relatioun mam $1',
	'ur-remove-error-message-remove-yourself' => 'Dir kënnt iech net selwer ewechhuelen.',
	'ur-remove-error-message-pending-foe-request' => 'Dir hutt eng oppe Géigner-Ufro mam Benotzer $1.',
	'ur-remove-error-message-pending-friend-request' => 'Dir hutt eng oppe Frënd-Ufro mam Benozer $1.',
	'ur-remove-error-not-loggedin-foe' => 'Dir musst ageloggt si fir e Géigner ewechzehuelen.',
	'ur-remove-error-not-loggedin-friend' => 'Dir musst ageloggt si fir e Frënd ewechzehuelen.',
	'ur-remove' => 'Ewechhuelen',
	'ur-cancel' => 'Annulléieren',
	'ur-login' => 'Umellen',
	'ur-add-title-foe' => 'Wëllt Dir de Benotzer $1 als Äre Géigner derbäisetzen?',
	'ur-add-title-friend' => 'Wëllt dir de Benotzer $1 als Äre Frënd derbäisetzen?',
	'ur-add-message-foe' => 'Dir sidd am Gaang de Benotzer $1 als Géigner derbäizesetzen.
Mir wäerten de Benotzer $1 informéieren fir ären Ierger ze confirméieren.',
	'ur-add-message-friend' => 'Dir sidd amgaang de Benotzer $1 als Äre Frënd derbäizesetzen.
Mir wäerten de Benotzer $1 informéieren fir Är Frëndschaft ze confirméieren.',
	'ur-add-button-foe' => 'Als Géigner derbäisetzen',
	'ur-add-button-friend' => 'Als Frënd derbäisetzen',
	'ur-add-sent-title-foe' => 'Mir hunn Är Géigner-Ufro un de Benotzer $1 geschéckt!',
	'ur-add-sent-title-friend' => 'Mir hunn Är Frëndschafts-Ufro un de Benotzer $1 geschéckt!',
	'ur-add-sent-message-foe' => 'Är Ufro als Géigner gouf un de Benotzer $1 fir Confirmatioun geschéckt.
Wann de Benotzer $1 Är Ufro confirméiert, kritt Dir eng Mail.',
	'ur-add-sent-message-friend' => 'Är Ufro als Frënd gouf un de Benotzer $1 fir Confirmatioun geschéckt.
Wann de Benotzer $1 Är Ufro confirméiert, kritt Dir eng Mail.',
	'ur-add-error-message-no-user' => 'De Benotzer den Dir versicht derbäizesetzen gëtt et net.',
	'ur-add-error-message-blocked' => 'Dir sidd elo gespaart a kënnt dofir keng Frënn oder Géigner derbäisetzen.',
	'ur-add-error-message-yourself' => 'Dir kënnt Iech net selwer als Feind oder Frënd derbäisetzen.',
	'ur-add-error-message-existing-relationship-foe' => 'Dir sidd schonn de Géigner vum $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Dir sidd schonn de Frënd vum $1',
	'ur-add-error-message-pending-request-title' => 'Gedold!',
	'ur-add-error-message-pending-friend-request' => 'Dir hutt eng oppen Ufro als Frënd vum Benotzer.
Mir informéieren Iech datt mir Iech informéiere wann de Benotzer $1 Är Ufro confirméiert.',
	'ur-add-error-message-pending-foe-request' => 'Dir hutt eng oppen Ufro als Géigner vum Benotzer.
Mir informéieren Iech datt mir Iech informéiere wann de Benotzer $1 Är Ufro confirméiert.',
	'ur-add-error-message-not-loggedin-foe' => 'Dir musst ageloggt si fir e Géigner derbäizesetzen',
	'ur-add-error-message-not-loggedin-friend' => 'Dir musst ageloggt si fir a Frënd derbäizesetzen',
	'ur-requests-title' => 'Ufroe fir eng Relatioun',
	'ur-requests-message-foe' => '<a href="$1">$2</a> wëllt Äre Géigner sinn.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> wëllt Äre Frënd sinn.',
	'ur-accept' => 'Akzeptéieren',
	'ur-reject' => 'Refuséieren',
	'ur-no-requests-message' => 'Dir hutt keng Ufroen fir Frënn oder Géigner.
Wann Dir méi Frënn wellt <a href="$1">invitéiert se!</a>',
	'ur-requests-added-message-foe' => 'Dir hutt de Benotzer $1 als Äre Géigner derbäigesat.',
	'ur-requests-added-message-friend' => 'Dir hutt de Benotzer $1 als Frënd derbäigesat.',
	'ur-requests-reject-message-friend' => 'Dir hutt de Benotzer $1 als Äre Frënd refuséiert.',
	'ur-requests-reject-message-foe' => 'Dir hutt de Benotzer $1 als Äre Géigner refuséiert.',
	'ur-title-foe' => 'Lëscht vun de Géigner vum $1',
	'ur-title-friend' => 'Lëscht vun de Frënn vum $1',
	'friend_request_subject' => '$1 huet iech als Frënd op {{SITENAME}} derbäigesat!',
	'foe_request_subject' => 'Et ass Krich! $1 huet iech als Géigner op {{SITENAME}} derbàigesat!',
	'friend_accept_subject' => '$1 huet är Ufro als Frënd op {{SITENAME}} ugeholl!',
	'foe_accept_subject' => 'Et geet lass! $1 huet Iech als Géigner op {{SITENAME}} akzeptéiert!',
	'friend_removed_subject' => 'Oh nee! $1 huet Iech als Frënd op {{SITENAME}} ewechgeholl!',
	'foe_removed_subject' => 'Hey! $1 huet Iech als Géigner op {{SITENAME}} ewechgeholl!',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'ur-main-page' => 'Тӱҥ лаштык',
	'ur-cancel' => 'Чараш',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'ur-main-page' => 'പ്രധാന താള്‍',
	'ur-friend' => 'സുഹൃത്ത്',
	'ur-add-friends' => 'കൂടുതല്‍ സുഹൃത്തുക്കളെ വേണോ? <a href="$1">ക്ഷണിക്കുക</a>',
	'ur-add-friend' => 'സുഹൃത്തായി ചേര്‍ക്കുക',
	'ur-previous' => 'മുന്‍പുള്ളത്',
	'ur-next' => 'അടുത്തത്',
	'ur-remove-error-message-no-relationship' => 'താങ്കള്‍ക്ക് $1മായി ബന്ധം സ്ഥാപിച്ചിട്ടില്ല.',
	'ur-remove-error-message-remove-yourself' => 'താങ്കള്‍ക്ക് താങ്കളെത്തന്നെ ഒഴിവാക്കാന്‍ പറ്റില്ല.',
	'ur-remove-error-not-loggedin' => '$1നെ ഒഴിവാക്കണമെങ്കില്‍ താങ്കള്‍ ലോഗിന്‍ ചെയ്തിരിക്കണം.',
	'ur-remove' => 'നീക്കം ചെയ്യുക',
	'ur-cancel' => 'റദ്ദാക്കുക',
	'ur-login' => 'ലോഗിന്‍',
	'ur-friendship' => 'സുഹൃത്ബന്ധം',
	'ur-add-button' => '$1 ആയി ചേര്‍ക്കാം',
	'ur-add-error-message-no-user' => 'താങ്കള്‍ ചേര്‍ക്കുവാന്‍ ശ്രമിക്കുന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'ur-add-error-message-pending-request-title' => 'കാത്തിരിക്കൂ!',
	'ur-accept' => 'സ്വീകരിക്കുക',
	'ur-reject' => 'നിരാകരിക്കുക',
	'ur-title-friend' => '$1ന്റെ സുഹൃത്തുക്കളുടെ പട്ടിക',
	'friend_request_subject' => '$1 താങ്കളെ {{SITENAME}} സം‌രംഭത്തില്‍ സുഹൃത്തായി ചേര്‍ത്തിരിക്കുന്നു!',
	'friend_accept_subject' => '{{SITENAME}} സം‌രംഭത്തിലുള്ള താങ്കളുടെ സൗഹൃദ അഭ്യര്‍ത്ഥന $1 സ്വീകരിച്ചു!',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'viewrelationships' => 'नाते पहा',
	'viewrelationshiprequests' => 'नाते मागण्या पहा',
	'ur-already-submitted' => 'तुमची मागणी पाठविलेली आहे',
	'ur-error-title' => 'बापरे, तुम्ही चुकीच्या ठिकाणी आलात!',
	'ur-error-message-no-user' => 'तुमची मागणी पूर्ण करता येत नाही, कारण या नावाचा सदस्य अस्तित्वात नाही.',
	'ur-main-page' => 'मुखपृष्ठ',
	'ur-your-profile' => 'तुमचे प्रोफाइल',
	'ur-backlink' => '&lt; $1च्या प्रोफाइलकडे परत',
	'ur-friend' => 'मित्र',
	'ur-foe' => 'शत्रू',
	'ur-add-friends' => 'अजून मित्र पाहिजेत? <a href="$1">त्यांना बोलवा</a>',
	'ur-add-friend' => 'मित्र म्हणून वाढवा',
	'ur-add-foe' => 'शत्रू म्हणून वाढवा',
	'ur-add-no-user' => 'सदस्य निवडलेला नाही.
योग्य दुव्यावरून मित्र/शत्रू मागवा.',
	'ur-add-personal-message' => 'एक वैयक्तिक संदेश लिहा',
	'ur-give-gift' => 'एक भेट द्या',
	'ur-previous' => 'मागचा',
	'ur-next' => 'पुढील',
	'ur-remove-error-message-no-relationship' => 'तुमचे $1शी नाते नाही.',
	'ur-remove-error-message-remove-yourself' => 'तुम्ही स्वत:लाच काढू शकत नाही.',
	'ur-remove-error-message-pending-request' => 'तुमची एक मागणी $1, $2 कडे प्रलंबित आहे.',
	'ur-remove-error-not-loggedin' => '$1 ला काढण्यासाठी तुम्ही प्रवेश केलेला असणे आवश्यक आहे.',
	'ur-remove' => 'काढा',
	'ur-cancel' => 'रद्द करा',
	'ur-login' => 'प्रवेश',
	'ur-friendship' => 'मैत्री',
	'ur-grudge' => 'ग्रज (grudge)',
	'ur-add-button' => '$1 म्हणून वाढवा',
	'ur-add-error-message-no-user' => 'तुम्ही वाढवू इच्छित असलेला सदस्य अस्तित्वात नाही.',
	'ur-add-error-message-blocked' => 'तुम्हाला सध्या ब्लॉक करण्यात आलेले आहे व तुम्ही मित्र किंवा शत्रू वाढवू शकत नाही.',
	'ur-add-error-message-yourself' => 'तुम्ही स्वत:लाच मित्र किंवा शत्रू म्हणून वाढवू शकत नाही.',
	'ur-add-error-message-existing-relationship' => 'तुम्ही $2 बरोबर अगोदरच $1 आहात.',
	'ur-add-error-message-pending-request-title' => 'वाटपहा!',
	'ur-add-error-message-not-loggedin' => '$1ला वाढविण्यासाठी तुम्ही प्रवेश केलेला असणे आवश्यक आहे',
	'ur-requests-title' => 'नाते मागण्या',
	'ur-accept' => 'स्विकारा',
	'ur-reject' => 'अव्हेर',
	'ur-no-requests-message' => 'तुम्हाला एकही शत्रू अथवा मित्र मागणी आलेली नाही.
जर तुम्हाला अजून मित्र हवे असतील, तर <a href="$1">त्यांना बोलवा!</a>',
	'ur-title-foe' => '$1ची शत्रू यादी',
	'ur-title-friend' => '$1ची मित्र यादी',
	'friend_request_subject' => '$1 ने {{SITENAME}} वर तुम्हाला मित्र म्हणून वाढविलेले आहे!',
	'friend_request_body' => 'नमस्कार $1:

$2 ने तुम्हांला {{SITENAME}} वर मित्र म्हणून वाढविलेले आहे. आम्ही खात्री करू इच्छितो की तुम्ही खरोखरच मित्र आहात.

कृपया मैत्रीची निश्चिती करण्यासाठी खालील दुव्यावर टिचकी मारा:
$3

धन्यवाद

---

आमच्या कडून इमेल यायला नको आहे?

इथे टिचकी द्या $4
व इमेल सूचनांच्या तुमच्या पसंती बदला.',
	'foe_request_subject' => 'हे युद्ध आहे! $1ने तुम्हाला {{SITENAME}} वर शत्रू म्हणून वाढविलेले आहे!',
	'foe_request_body' => 'नमस्कार $1:

$2 ने तुम्हांला {{SITENAME}} वर शत्रू म्हणून वाढविलेले आहे. आम्ही खात्री करू इच्छितो की तुम्ही खरोखरच शत्रू आहात किंवा तुमच्यामध्ये मतभेद आहेत.

कृपया शत्रूत्वाची निश्चिती करण्यासाठी खालील दुव्यावर टिचकी मारा:
$3

धन्यवाद

---

आमच्या कडून इमेल यायला नको आहे?

इथे टिचकी द्या $4
व इमेल सूचनांच्या तुमच्या पसंती बदला.',
	'friend_accept_subject' => '$1ने तुमची {{SITENAME}} वरची मित्रत्वाची मागणी स्वीकारलेली आहे!',
	'friend_accept_body' => 'नमस्कार $1:

$2 ने तुम्हांला {{SITENAME}} वर मित्र म्हणून स्वीकारलेले आहे!

$2चे पान $3 इथे पहा.

धन्यवाद

---

आमच्या कडून इमेल यायला नको आहे?

इथे टिचकी द्या $4
व इमेल सूचनांच्या तुमच्या पसंती बदला.',
	'foe_accept_subject' => 'युद्ध सुरू!$1ने तुमची {{SITENAME}} वरची मित्रत्वाची मागणी स्वीकारलेली आहे!',
	'foe_accept_body' => 'नमस्कार $1:

$2 ने तुम्हांला {{SITENAME}} वर शत्रू म्हणून स्वीकारलेले आहे!

$2चे पान $3 इथे पहा.

धन्यवाद

---

आमच्या कडून इमेल यायला नको आहे?

इथे टिचकी द्या $4
व इमेल सूचनांच्या तुमच्या पसंती बदला.',
	'friend_removed_subject' => 'बापरे! $1 ने {{SITENAME}} वर तुम्हाला मित्र म्हणून काढलेले आहे!',
	'friend_removed_body' => 'नमस्कार $1:

$2 ने तुम्हांला {{SITENAME}} वर मित्र म्हणून काढलेले आहे!

धन्यवाद

---

आमच्या कडून इमेल यायला नको आहे?

इथे टिचकी द्या $4
व इमेल सूचनांच्या तुमच्या पसंती बदला.',
	'foe_removed_subject' => 'अरे वा! $1ने तुम्हाला {{SITENAME}} वर शत्रू म्हणून काढलेले आहे!',
	'foe_removed_body' => 'नमस्कार $1:

	$2 ने तुम्हांला {{SITENAME}} वर शत्रू म्हणून काढलेले आहे!

तुम्ही दोघे मित्रत्वाच्या मार्गावर निघालेले आहात का?

धन्यवाद

---

आमच्या कडून इमेल यायला नको आहे?

इथे टिचकी द्या $4
व इमेल सूचनांच्या तुमच्या पसंती बदला.',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'ur-cancel' => 'Annulla',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'ur-friend' => 'оя',
	'ur-foe' => 'душман',
	'ur-remove' => 'Нардык',
	'ur-friendship' => 'ояксчи',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'ur-main-page' => 'Calīxatl',
	'ur-friend' => 'icnīuhtli',
	'ur-add-friend' => 'Ticcēntilīz quemeh mocnīuh',
	'ur-next' => 'niman',
	'ur-cancel' => 'Ticcuepāz',
	'ur-login' => 'Timocalaquīz',
	'ur-friendship' => 'icnīuhcāyōtl',
	'ur-add-button' => 'Ticcēntilīz quemeh $1',
	'ur-add-button-friend' => 'Ticcēntilīz quemeh mocnīuh',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'ur-main-page' => 'Hööftsiet',
	'ur-friend' => 'Fründ',
	'ur-foe' => 'Feend',
	'ur-add-friend' => 'As Fründ tofögen',
	'ur-add-foe' => 'As Feend tofögen',
	'ur-give-gift' => 'Geschenk maken',
	'ur-cancel' => 'Afbreken',
	'ur-friendship' => 'Fründschop',
	'ur-add-button' => 'As $1 tofögen',
	'ur-add-error-message-pending-request-title' => 'Geduld!',
	'ur-accept' => 'Annehmen',
	'ur-reject' => 'Afwiesen',
	'ur-title-foe' => '$1 sien Feendenlist',
	'ur-title-friend' => '$1 sien Frünnlist',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'viewrelationships' => 'Connecties bekijken',
	'viewrelationshiprequests' => 'Connectieverzoeken bekijken',
	'ur-already-submitted' => 'Uw verzoek is verzonden',
	'ur-error-page-title' => 'Oeps!',
	'ur-error-title' => 'U hebt een verkeerde afslag genomen.',
	'ur-error-message-no-user' => 'We kunnen uw verzoek niet afhandelen omdat de gebruiker niet bestaat.',
	'ur-main-page' => 'Hoofdpagina',
	'ur-your-profile' => 'Uw profiel',
	'ur-backlink' => "&lt; Terug naar $1's profiel",
	'ur-friend' => 'vriend',
	'ur-foe' => 'tegenstander',
	'ur-relationship-count-foes' => '$1 heeft $2 {{PLURAL:$2|tegenstander|tegenstanders}}.
Behoefte aan meer tegenstanders?
<a href="$3">Nodig ze uit</a>.',
	'ur-relationship-count-friends' => '$1 heeft $2 {{PLURAL:$2|vriend|vrienden}}.
Behoefte aan meer vrienden?
<a href="$3">Nodig ze uit</a>.',
	'ur-add-friends' => 'Wilt u meer vrienden? <a href="$1">Nodig ze uit</a>',
	'ur-add-friend' => 'Als vriend toevoegen',
	'ur-add-foe' => 'Als tegenstander toevoegen',
	'ur-add-no-user' => 'Er is geen gebruiker geselecteerd.
Maak verzoeken voor vrienden/tegenstanders alstublieft via de daarvoor bedoelde link.',
	'ur-add-personal-message' => 'Persoonlijk bericht toevoegen',
	'ur-remove-relationship-friend' => 'Als vriend verwijderen',
	'ur-remove-relationship-foe' => 'Als tegenstander verwijderen',
	'ur-give-gift' => 'Presentje geven',
	'ur-previous' => 'vorige',
	'ur-next' => 'volgende',
	'ur-remove-relationship-title-foe' => 'Wilt u $1 verwijderen als uw tegenstander?',
	'ur-remove-relationship-title-confirm-foe' => 'U hebt $1 verwijderd als uw tegenstander',
	'ur-remove-relationship-title-friend' => 'Wilt u $1 verwijderen als uw vriend?',
	'ur-remove-relationship-title-confirm-friend' => 'U hebt $1 verwijderd als uw vriend',
	'ur-remove-relationship-message-foe' => 'U wilt $1 verwijderen als uw tegenstander.
Klik op "$2" om dit te bevestigen.',
	'ur-remove-relationship-message-confirm-foe' => 'U hebt $1 als tegenstander verwijderd.',
	'ur-remove-relationship-message-friend' => 'U wilt $1 verwijderen als uw vriend.
Klik op "$2" om dit te bevestigen.',
	'ur-remove-relationship-message-confirm-friend' => 'U hebt $1 als tegenstander vriend.',
	'ur-remove-error-message-no-relationship' => 'U hebt geen connectie met $1.',
	'ur-remove-error-message-remove-yourself' => 'U kunt uzelf niet verwijderen.',
	'ur-remove-error-message-pending-request' => 'U hebt een openstaand connectieverzoek als $1 bij $2.',
	'ur-remove-error-message-pending-foe-request' => 'U hebt een openstaand tegenstandersverzoek van $1.',
	'ur-remove-error-message-pending-friend-request' => 'U hebt een openstaand vriendschapsverzoek van $1.',
	'ur-remove-error-not-loggedin' => 'U moet aangemeld zijn om een $1 te kunnen verwijderen.',
	'ur-remove-error-not-loggedin-foe' => 'U moet aangemeld zijn om een tegenstander te verwijderen.',
	'ur-remove-error-not-loggedin-friend' => 'U moet aangemeld zijn om een vriend te verwijderen.',
	'ur-remove' => 'Verwijderen',
	'ur-cancel' => 'Annuleren',
	'ur-login' => 'Aanmelden',
	'ur-add-title-foe' => 'Wilt u $1 toevoegen als tegenstander?',
	'ur-add-title-friend' => 'Wilt u $1 toevoegen als vriend?',
	'ur-add-message-foe' => 'U wilt $1 toevoegen als tegenstander.
$1 wordt hiervan op de hoogte gesteld.',
	'ur-add-message-friend' => 'U wilt $1 toevoegen als vriend.
$1 wordt hiervan op de hoogte gesteld.',
	'ur-friendship' => 'vriendschap',
	'ur-grudge' => 'wrok',
	'ur-add-button' => 'Als $1 toevoegen',
	'ur-add-button-foe' => 'Als tegenstander toevoegen',
	'ur-add-button-friend' => 'Als vriend toevoegen',
	'ur-add-sent-title-foe' => 'Uw tegenstandersverzoek is verstuurd aan $1.',
	'ur-add-sent-title-friend' => 'Uw vriendschapsverzoek is verstuurd aan $1.',
	'ur-add-sent-message-foe' => 'Uw tegenstandersverzoek is ter bevestiging verstuurd aan $1.
Als $1 uw verzoek bevestigt, ontvangt u daar een e-mail over.',
	'ur-add-sent-message-friend' => 'Uw vriendschapsverzoek is ter bevestiging verstuurd aan $1.
Als $1 uw verzoek bevestigt, ontvangt u daar een e-mail over.',
	'ur-add-error-message-no-user' => 'De gebruiker die u probeert toe te voegen bestaat niet.',
	'ur-add-error-message-blocked' => 'U bent geblokkeerd en kunt geen vrienden of tegenstanders toevoegen.',
	'ur-add-error-message-yourself' => 'U kunt uzelf niet als vriend of tegenstander toevoegen.',
	'ur-add-error-message-existing-relationship' => 'U bent al $1 bij $2.',
	'ur-add-error-message-existing-relationship-foe' => 'U bent al bevriend met $1.',
	'ur-add-error-message-existing-relationship-friend' => '$1 is al uw tegenstander.',
	'ur-add-error-message-pending-request-title' => 'Even geduld alstublieft.',
	'ur-add-error-message-pending-friend-request' => 'U hebt een openstaand vriendschapsverzoek bij $1.
U wordt op de hoogte gesteld als $1 uw verzoek bevestigt.',
	'ur-add-error-message-pending-foe-request' => 'U hebt een openstaand tegenstandersverzoek bij $1.
U wordt op de hoogte gesteld als $1 uw verzoek bevestigt.',
	'ur-add-error-message-not-loggedin' => 'U moet aangemeld zijn om een $1 toe te voegen',
	'ur-add-error-message-not-loggedin-foe' => 'U moet aangemeld zijn om een tegenstander toe te kunnen voegen',
	'ur-add-error-message-not-loggedin-friend' => 'U moet aangemeld zijn om een vriend toe te kunnen voegen',
	'ur-requests-title' => 'Connectieverzoeken',
	'ur-requests-message-foe' => '<a href="$1">$2</a> wil uw tegenstander zijn.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> wil uw vriend zijn.',
	'ur-accept' => 'Aanvaarden',
	'ur-reject' => 'Weigeren',
	'ur-no-requests-message' => 'U hebt geen uitstaande verzoeken voor vrienden of tegenstanders. Als u meer vrienden wilt, <a href="$1">nodig ze dan uit!</a>',
	'ur-requests-added-message-foe' => 'U hebt $1 toegevoegd als tegenstander.',
	'ur-requests-added-message-friend' => 'U hebt $1 toegevoegd als uw vriend.',
	'ur-requests-reject-message-friend' => 'U hebt $1 geweigerd als vriend.',
	'ur-requests-reject-message-foe' => 'U hebt $1 geweigerd als tegenstander.',
	'ur-title-foe' => 'Tegenstanderslijst van $1',
	'ur-title-friend' => 'Vriendenlijst van $1',
	'friend_request_subject' => '$1 heeft u als vriend toegevoegd op {{SITENAME}}.',
	'friend_request_body' => 'Hallo $1.

$2 heeft u als vriend toegevoegd op {{SITENAME}}. We willen graag bevestiging dat u echt bevriend bent.

Klik op de onderstaande link om uw vriendschap te bevestigen:
$3

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.',
	'foe_request_subject' => '$1 heeft u toegevoegd als tegenstander op {{SITENAME}}!',
	'foe_request_body' => 'Hallo $1.

$2 heeft u als tegenstander toegevoegd op {{SITENAME}}. We willen graag bevestiging dat u echt tegenstanders bent of in ieder geval gebrouilleerd bent.

Klik op de onderstaande link om uw animositeit te bevestigen:
$3

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.',
	'friend_accept_subject' => '$1 heeft uw verzoek om vrienden te worden op {{SITENAME}} aanvaard.',
	'friend_accept_body' => "Hallo $1.

$2 heeft u als vriend geaccepteerd op {{SITENAME}}.

U kunt $2's pagina bekijken op $3

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.",
	'foe_accept_subject' => '$1 heeft u als tegenstander aanvaard op {{SITENAME}}.',
	'foe_accept_body' => "Hallo $1.

$2 heeft u als tegenstander bevestigd op {{SITENAME}}.

U kunt $2's pagina bekijken op $3

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.",
	'friend_removed_subject' => '$1 heeft u helaas verwijderd als vriend op {{SITENAME}}!',
	'friend_removed_body' => 'Hallo $1.

$2 heeft u als vriend verwijderd op {{SITENAME}}.

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.',
	'foe_removed_subject' => '$1 heeft u verwijderd als tegenstander op {{SITENAME}}!',
	'foe_removed_body' => 'Hallo $1.

$2 heeft u als tegenstander verwijderd op {{SITENAME}}.

Wellicht bent u op weg om vrienden te worden?

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'viewrelationships' => 'Syn forhold',
	'viewrelationshiprequests' => 'Syn førespurnader om forhold',
	'ur-already-submitted' => 'Førespurnaden din har blitt sendt',
	'ur-error-page-title' => 'Ops!',
	'ur-error-title' => 'Ops, du svingte feil!',
	'ur-error-message-no-user' => 'Me kan ikkje fullføra førespurnaden din etter di det ikkje finst ein brukar med namnet du oppgav.',
	'ur-main-page' => 'Hovudside',
	'ur-your-profile' => 'Profilen din',
	'ur-backlink' => '&lt; Attende til profilen til $1',
	'ur-friend' => 'venn',
	'ur-foe' => 'fiende',
	'ur-relationship-count-foes' => '$1 har $2 {{PLURAL:$2|fiende|fiendar}}. Ynskjer du fleire fiendar? <a href="$3">Inviter dei.</a>',
	'ur-relationship-count-friends' => '$1 har $2 {{PLURAL:$2|venn|venner}}. Ynskjer du fleire venner? <a href="$3">Inviter dei.</a>',
	'ur-add-friends' => ' Ynskjer du fleire venner? <a href="$1">Inviter dei</a>',
	'ur-add-friend' => 'Legg til som venn',
	'ur-add-foe' => 'Legg til som fiende',
	'ur-add-no-user' => 'Ingen brukar valt.
Legg til venner eller fiendar gjennom den rette lekkja.',
	'ur-add-personal-message' => 'Legg til ei personleg melding',
	'ur-remove-relationship-friend' => 'Fjern frå vennene',
	'ur-remove-relationship-foe' => 'Fjern frå fiendane',
	'ur-give-gift' => 'Gje gåva',
	'ur-previous' => 'førre',
	'ur-next' => 'neste',
	'ur-remove-relationship-title-foe' => 'Vil du fjerna $1 frå fiendane?',
	'ur-remove-relationship-title-confirm-foe' => '$1 er ikkje lenger ein fiende',
	'ur-remove-relationship-title-friend' => 'Vil du fjerna $1 frå vennene?',
	'ur-remove-relationship-title-confirm-friend' => '$1 er ikkje lenger ein vennen',
	'ur-remove-relationship-message-foe' => 'Du har spurt om å fjerna $1 frå fiendane, trykk «$2» for å stadfesta.',
	'ur-remove-relationship-message-confirm-foe' => 'Du har fjerna $1 frå fiendane.',
	'ur-remove-relationship-message-friend' => 'Du har spurt om å fjerna $1 frå vennene, trykk «$2» for å stadfesta.',
	'ur-remove-relationship-message-confirm-friend' => 'Du har fjerna $1 frå vennene.',
	'ur-remove-error-message-no-relationship' => 'Du har ikkje noko forhold til $1.',
	'ur-remove-error-message-remove-yourself' => 'Du kan ikkje fjerna deg sjølv.',
	'ur-remove-error-message-pending-request' => 'Du har ein uteståande førespurnad om å bli $1 med $2.',
	'ur-remove-error-message-pending-foe-request' => 'Du har ein uteståande førespurnad om fiendskap frå $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du har ein uteståande førespurnad om vennskap frå $1.',
	'ur-remove-error-not-loggedin' => 'Du må logga inn for å fjerna ein $1.',
	'ur-remove-error-not-loggedin-foe' => 'Du må logga inn for å fjerna ein fiende.',
	'ur-remove-error-not-loggedin-friend' => 'Du må logga inn for å fjerna ein fiende.',
	'ur-remove' => 'Fjern',
	'ur-cancel' => 'Avbryt',
	'ur-login' => 'Logg inn',
	'ur-add-title-foe' => 'Vil du leggja til $1 som fiende?',
	'ur-add-title-friend' => 'Vil du leggja til $1 som venn?',
	'ur-add-message-foe' => 'Du er i ferd med å leggja til $1 som fiende.
Me vil senda ei melding til $1 for å beda han om å stadfesta fiendskapet.',
	'ur-add-message-friend' => 'Du er i ferd med å leggja til $1 som venn.
Me vil senda ei melding til $1 for å beda han om å stadfesta fiendskapet.',
	'ur-friendship' => 'vennskap',
	'ur-grudge' => 'fiendskap',
	'ur-add-button' => 'Legg til som $1',
	'ur-add-button-foe' => 'Legg til som fiende',
	'ur-add-button-friend' => 'Legg til som venn',
	'ur-add-sent-title-foe' => 'Me har sendt førespurnaden din om fiendskap til $1.',
	'ur-add-sent-title-friend' => 'Me har sendt førespurnaden din om vennskap til $1.',
	'ur-add-sent-message-foe' => 'Førespurnaden din om fiendskap har blitt sendt til $1 for stadfesting.
Om $1 stadfestar førespurnaden din vil du motta ein e-post.',
	'ur-add-sent-message-friend' => 'Førespurnaden din om vennskap har blitt sendt til $1 for stadfesting.
Om $1 stadfestar førespurnaden din vil du motta ein e-post.',
	'ur-add-error-message-no-user' => 'Brukaren du freistar å leggja til, finst ikkje.',
	'ur-add-error-message-blocked' => 'Du er blokkert, og kan korkje leggja til venner eller fiendar.',
	'ur-add-error-message-yourself' => 'Du kan ikkje leggja til deg sjølv som fiende.',
	'ur-add-error-message-existing-relationship' => 'Du er allereie $1 med $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Du er allereie fiende med $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du er allereie venn med $1.',
	'ur-add-error-message-pending-request-title' => 'Tolmod!',
	'ur-add-error-message-pending-friend-request' => 'Du har ein uteståande førespurnad om vennskap med $1.
Me vil gje deg ei melding når $1 stadfestar førespurnaden din.',
	'ur-add-error-message-pending-foe-request' => 'Du har ein uteståande førespurnad om fiendskap med $1.
Me vil gje deg ei melding når $1 stadfestar førespurnaden din.',
	'ur-add-error-message-not-loggedin' => 'Du må logga inn for å leggja til ein $1',
	'ur-add-error-message-not-loggedin-foe' => 'Du må logga inn for å leggja til ein fiende',
	'ur-add-error-message-not-loggedin-friend' => 'Du må logga inn for å leggja til ein venn',
	'ur-requests-title' => 'Førespurnader om samband',
	'ur-requests-message-foe' => '<a href="$1">$2</a> ynskjer å bli fienden din.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> ynskjer å bli venn med deg.',
	'ur-accept' => 'Godta',
	'ur-reject' => 'Avslå',
	'ur-no-requests-message' => 'Du har ingen førespurnader om korkje vennskap eller fiendskap.
Om du vil ha fleire venner, <a href="$1">inviter dei</a>!',
	'ur-requests-added-message-foe' => 'Du har lagt til $1 som fiende.',
	'ur-requests-added-message-friend' => 'Du har lagt til $1 som venn.',
	'ur-requests-reject-message-friend' => 'Du avslo førespurnaden om vennskap frå $1.',
	'ur-requests-reject-message-foe' => 'Du avslo førespurnaden om fiendskap frå $1.',
	'ur-title-foe' => 'Fiendelista til $1',
	'ur-title-friend' => 'Vennelista til $1',
	'friend_request_subject' => '$1 har lagt deg til som venn på {{SITENAME}}!',
	'friend_request_body' => 'Hei, $1.

$2 har lagt deg til som venn på {{SITENAME}}. Me vil vera sikre på at de faktisk er venner.

Følg denne lekkja for å stadfesta vennskapet dykkar:
$3

Takk

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
	'foe_request_subject' => 'Det er krig! $1 har lagt deg til som fiende på {{SITENAME}}!',
	'foe_request_body' => 'Hei, $1.

$2 har lagt deg til som fiende på {{SITENAME}}. Me vil gjera oss visse på at de faktisk er svorne fiendar &ndash; eller i alle fall kranglar.

Følg lekkja nedanfor for å stadfesta fiendeskapet.

$3

Takk

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
	'friend_accept_subject' => '$1 har godteke førespurnaden din om vennskap på {{SITENAME}}.',
	'friend_accept_body' => 'Hei, $1.

$2 har godteke førespurnaden din om vennskap på {{SITENAME}}.

Sjekk ut sida til $2 på $3.

Takk.

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
	'foe_accept_subject' => '$1 har godteke førespurnaden din om fiendskap på {{SITENAME}}.',
	'foe_accept_body' => 'Hei, $1.

$2 har godteke førespurnaden din om fiendskap på {{SITENAME}}.

Sjekk ut sida til $2 på $3

Takk

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
	'friend_removed_subject' => 'Å nei! $1 har fjerna deg frå vennelista si på {{SITENAME}}!',
	'friend_removed_body' => 'Hei, $1

$2 har fjerna deg frå vennelista si på {{SITENAME}}!

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
	'foe_removed_subject' => 'Jippi! $1 har fjerna deg frå fiendelista si på {{SITENAME}}!',
	'foe_removed_body' => 'Hei, $1.

$2 har fjerna deg frå fiendelista si på {{SITENAME}}.

Kanskje de er på veg til å bli venner?

---

Vil du ikkje motta fleire e-postar frå oss?

Trykk $4 og endra innstillingane dine for å slå av meldingar gjennom e-post.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'viewrelationships' => 'Vis forbindelse',
	'viewrelationshiprequests' => 'Vis forespørsler om forbindelse',
	'ur-already-submitted' => 'Forespørselen din har blitt sendt',
	'ur-error-page-title' => 'Ops!',
	'ur-error-title' => 'Ops, du svingte feil.',
	'ur-error-message-no-user' => 'Vi kan ikke fullføre forespørselen din fordi det ikke finnes noen brukere ved dette navnet.',
	'ur-main-page' => 'Hovedside',
	'ur-your-profile' => 'Profilen din',
	'ur-backlink' => '&lt; Tilbake til profilen til $1',
	'ur-friend' => 'venn',
	'ur-foe' => 'fiende',
	'ur-relationship-count-foes' => '$1 har $2 {{PLURAL:$2|fiende|fiender}}. Flere fiender? <a href="$3">Inviter dem.</a>',
	'ur-relationship-count-friends' => '$1 har $2 {{PLURAL:$2|venn|venner}}. Flere venner? <a href="$3">Inviter dem.</a>',
	'ur-add-friends' => 'Vil du ha flere venner? <a href="$1">Inviter dem</a>',
	'ur-add-friend' => 'Legg til som venn',
	'ur-add-foe' => 'Legg til som fiende',
	'ur-add-no-user' => 'Ingen bruker valgt. Vennligst legg til venner eller fiender med den korrekte lenken.',
	'ur-add-personal-message' => 'Legg til en personlig beskjed',
	'ur-remove-relationship-friend' => 'Fjern fra venner',
	'ur-remove-relationship-foe' => 'Fjern fra fiender',
	'ur-give-gift' => 'Gi gave',
	'ur-previous' => 'forrige',
	'ur-next' => 'neste',
	'ur-remove-relationship-title-foe' => 'Vil du fjerne $1 fra fiender?',
	'ur-remove-relationship-title-confirm-foe' => 'Du har fjernet $1 fra fiender',
	'ur-remove-relationship-title-friend' => 'Vil du fjerne $1 fra venner?',
	'ur-remove-relationship-title-confirm-friend' => 'Du har fjernet $1 fra venner',
	'ur-remove-relationship-message-foe' => 'Du har spurt om å fjerne $1 fra fiender, trykk «$2» for å bekrefte.',
	'ur-remove-relationship-message-confirm-foe' => 'Du har fjernet $1 fra fiender.',
	'ur-remove-relationship-message-friend' => 'Du har spurt om å fjerne $1 fra venner, trykk «$2» for å bekrefte.',
	'ur-remove-relationship-message-confirm-friend' => 'Du har fjernet $1 fra venner.',
	'ur-remove-error-message-no-relationship' => 'Du har ingen forbindelse med $1.',
	'ur-remove-error-message-remove-yourself' => 'Du kan ikke fjerne deg selv.',
	'ur-remove-error-message-pending-request' => 'Du har en ventende forespørsel om å bli $1 med $2 hos $2.',
	'ur-remove-error-message-pending-foe-request' => 'Du har en ventende fiendeforespørsel hos $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du har en ventende venneforespørsel hos $1.',
	'ur-remove-error-not-loggedin' => 'Du må logge inn for å fjerne en $1.',
	'ur-remove-error-not-loggedin-foe' => 'Du må være logget inn for å fjerne en fiende.',
	'ur-remove-error-not-loggedin-friend' => 'Du må være logget inn for å fjerne en venn.',
	'ur-remove' => 'Fjern',
	'ur-cancel' => 'Avbryt',
	'ur-login' => 'Logg inn',
	'ur-add-title-foe' => 'Vil du legge til $1 som fiende?',
	'ur-add-title-friend' => 'Vil du legge til $1 som venn?',
	'ur-add-message-foe' => 'Du er i ferd med å legge til $1 som fiende.
Vi vil sende $1 en melding for å bekrefte fiendeskapet.',
	'ur-add-message-friend' => 'Du er i ferd med å legge til $1 som venn.
Vi vil sende $1 en melding for å bekrefte vennskapet.',
	'ur-friendship' => 'vennskap',
	'ur-grudge' => 'fiendskap',
	'ur-add-button' => 'Legg til som $1',
	'ur-add-button-foe' => 'Legg til som fiende',
	'ur-add-button-friend' => 'Legg til som venn',
	'ur-add-sent-title-foe' => 'Vi har sendt fiendeforespørselen din til $1.',
	'ur-add-sent-title-friend' => 'Vi har sendt venneforespørselen din til $1.',
	'ur-add-sent-message-foe' => 'Fiendeforespørselen din har blitt sendt til $1 for bekreftelse.
Om $1 bekrefter forespørselen din vil du motta en oppfølgingsmelding.',
	'ur-add-sent-message-friend' => 'Venneforespørselen din har blitt sendt til $1 for bekreftelse.
Om $1 bekrefter forespørselen din vil du motta en oppfølgingsmelding.',
	'ur-add-error-message-no-user' => 'Brukeren du prøvde å legge til finnes ikke.',
	'ur-add-error-message-blocked' => 'Du er blokkert, og kan ikke legge til venner eller fiender.',
	'ur-add-error-message-yourself' => 'Du kan ikke legge til deg selv som venn eller fiende.',
	'ur-add-error-message-existing-relationship' => 'Du er allerede $1 med $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Du er allerede fiende med $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du er allerede venn med $1.',
	'ur-add-error-message-pending-request-title' => 'Tålmodighet ...',
	'ur-add-error-message-pending-friend-request' => 'Du har en ventende venneforespørsel hos $1.
Vi vil gi deg en melding når $1 bekrefter forespørselen din.',
	'ur-add-error-message-pending-foe-request' => 'Du har en ventende fiendeforespørsel hos $1.
Vi vil gi deg en melding når $1 bekrefter forespørselen din.',
	'ur-add-error-message-not-loggedin' => 'Du må være logget inn for å legge til en $1',
	'ur-add-error-message-not-loggedin-foe' => 'Du må være logget inn for å legge til en fiende',
	'ur-add-error-message-not-loggedin-friend' => 'Du må være logget inn for å legge til en venn',
	'ur-requests-title' => 'Forbindelsesforespørsler',
	'ur-requests-message-foe' => '<a href="$1">$2</a> ønsker å bli fienden din.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> ønsker å bli venn med deg.',
	'ur-accept' => 'Godta',
	'ur-reject' => 'Avvis',
	'ur-no-requests-message' => 'Du har ingen venne- eller fiendeforespørsler. Om du vil ha flere venner, <a href="$1">inviter dem</a>!',
	'ur-requests-added-message-foe' => 'Du har lagt til $1 som fiende.',
	'ur-requests-added-message-friend' => 'Du har lagt til $1 som venn.',
	'ur-requests-reject-message-friend' => 'Du har avvist venneforespørselen fra $1.',
	'ur-requests-reject-message-foe' => 'Du har avvist fiendeforespørselen til $1.',
	'ur-title-foe' => '$1s fiendeliste',
	'ur-title-friend' => '$1s venneliste',
	'friend_request_subject' => '$1 har lagt deg til som venn på {{SITENAME}}!',
	'friend_request_body' => 'Hei, $1.

$2 har lagt deg til som venn på {{SITENAME}}. Vi vil være sikre på at dere faktisk er venner.

Følg denne lenken for å bekrefte vennskapet deres:
$3

Takk

---

Vil du ikke motta flere e-poster fra oss?

Klikk $4 og endre innstillingene dine for å slå av e-postbeskjeder.',
	'foe_request_subject' => 'Det er krig! $1 har lagt deg til som fiende på {{SITENAME}}!',
	'foe_request_body' => 'Hei, $1.

$2 har lagt deg til som fiende på {{SITENAME}}. Vi vil forsikre oss om at dere faktisk er svorne fiender &ndash; eller i hvert fall krangler.

Følg lenken nedenunder for å bekrefte fiendeskapet.

$3

Takk

---

Vil du ikke motta flere e-poster fra oss?

Klikk $4
og endre innstillingene dine for ikke å motta flere slike e-poster.',
	'friend_accept_subject' => '$1 har godtatt din venneforespørsel på {{SITENAME}}.',
	'friend_accept_body' => 'Hei, $1.

$2 har godtatt din venneforespørsel på {{SITENAME}}.

Sjekk ut siden til $2 på $3.

Takk.

---

Vil du ikke motta flere e-poster fra oss??

Klikk $4 og endre innstillingene dine for å slå av e-postbeskjeder.',
	'foe_accept_subject' => '$1 har godtatt din fiendeforespørsel på {{SITENAME}}.',
	'foe_accept_body' => 'Hei, $1.

$2 har godtatt din fiendeforespørsel på {{SITENAME}}.

Sjekk ut siden til $2 på $3

Takk

---

Vil du ikke motta flere e-poster fra oss?

Klikk $4 og endre innstillingene dine for å slå av e-postmeldinger.',
	'friend_removed_subject' => 'Å nei! $1 har fjernet deg som venn på {{SITENAME}}.',
	'friend_removed_body' => 'Hei, $1

$2 har fjernet deg som venn på {{SITENAME}}.

---

Vil du ikke motta flere e-poster fra oss?

Klikk $4 og endre innstillingene dine for å slå av e-postbeskjeder.',
	'foe_removed_subject' => 'Jippi! $1 har fjernet deg som fiende på {{SITENAME}}.',
	'foe_removed_body' => 'Hei, $1.

$2 har fjernet deg som fiende på {{SITENAME}}.

Kanskje dere er på vei til å bli venner?

---

Vil du ikke motta flere e-poster fra oss?

Klikk $4 og endre innstillingene dine for å slå av e-postbeskjeder.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'viewrelationships' => 'Veire las relacions',
	'viewrelationshiprequests' => 'Veire las requèstas de las relacions',
	'ur-already-submitted' => 'Vòstra demanda es estada mandada',
	'ur-error-page-title' => 'Ops !',
	'ur-error-title' => 'Op, avètz pres un marrida virada !',
	'ur-error-message-no-user' => "Podèm pas completar vòstre requèsta, perque cap d'utilizaire pòrta pas aqueste nom.",
	'ur-main-page' => 'Acuèlh',
	'ur-your-profile' => 'Vòstre perfil',
	'ur-backlink' => '&lt; retorn cap al perfil de $1',
	'ur-friend' => 'amic',
	'ur-foe' => 'enemic',
	'ur-relationship-count-foes' => '$1 a $2 {{PLURAL:$2|enemic|enemics}}. Ne volètz encara mai ? <a href="$3">Convidatz-los.</a>',
	'ur-relationship-count-friends' => '$1 a $2 {{PLURAL:$2|amic|amics}}. Ne volètz encara mai ? <a href="$3">Convidatz-los.</a>',
	'ur-add-friends' => 'Volètz mai d’amics ? <a href="$1">Invitatz-los !</a>.',
	'ur-add-friend' => 'Apondre coma amic',
	'ur-add-foe' => 'Apondre coma enemic',
	'ur-add-no-user' => "Cap d'utilizaire pas seleccionat. Requerissètz d'amics o d'enemics a travèrs del ligam corrècte.",
	'ur-add-personal-message' => 'Apondre un messatge personal',
	'ur-remove-relationship-friend' => 'Levar coma amic',
	'ur-remove-relationship-foe' => 'Levar coma enemic',
	'ur-give-gift' => 'Mandar un present',
	'ur-previous' => 'precedent',
	'ur-next' => 'seguent',
	'ur-remove-relationship-title-foe' => 'Volètz levar $1 de la lista de vòstres enemics ?',
	'ur-remove-relationship-title-confirm-foe' => 'Avètz levat $1 de la lista de vòstres enemics',
	'ur-remove-relationship-title-friend' => 'Volètz levar $1 de la lista de vòstres amics ?',
	'ur-remove-relationship-title-confirm-friend' => 'Avètz levat $1 de la lista de vòstres amics',
	'ur-remove-relationship-message-foe' => 'Avètz demandat la supression de $1 de la lista de vòstres enemics, quichatz sus « $2 » per confirmar.',
	'ur-remove-relationship-message-confirm-foe' => 'Avètz levat $1 amb succès de la lista de vòstres enemics.',
	'ur-remove-relationship-message-friend' => 'Avètz demandat la supression de $1 de la lista de vòstres amics, quichatz sus « $2 » per confirmar.',
	'ur-remove-relationship-message-confirm-friend' => 'Avètz levat $1 amb succès de la lista de vòstres amics.',
	'ur-remove-error-message-no-relationship' => 'Avètz pas cap de relacion amb $1.',
	'ur-remove-error-message-remove-yourself' => 'Vos podètz pas suprimir vos meteis.',
	'ur-remove-error-message-pending-request' => 'Avètz una requèsta de $1 en cors amb $2.',
	'ur-remove-error-message-pending-foe-request' => 'Avètz una requèsta en cors d’un enemic amb $1.',
	'ur-remove-error-message-pending-friend-request' => 'Avètz una requèsta en cors d’un amic amb $1.',
	'ur-remove-error-not-loggedin' => 'Vos cal èsser en sesilha per suprimir un $1.',
	'ur-remove-error-not-loggedin-foe' => 'Vos cal èsser connectat per levar un enemic.',
	'ur-remove-error-not-loggedin-friend' => 'Vos cal èsser connectat per levar un amic.',
	'ur-remove' => 'Levar',
	'ur-cancel' => 'Anullar',
	'ur-login' => 'Senhal',
	'ur-add-title-foe' => 'Volètz apondre $1 a la lista de vòstres enemics ?',
	'ur-add-title-friend' => 'Volètz apondre $1 a la lista de vòstres amics ?',
	'ur-add-message-foe' => 'Sètz a mand d’apondre $1 a la lista de vòstres enemics.
Assabentarem $1 per confirmar vòstra rancòr.',
	'ur-add-message-friend' => 'Sètz a mand d’apondre $1 a la lista de vòstres amics.
Assabentarem $1 per confirmar vòstra amistat.',
	'ur-friendship' => 'amistat',
	'ur-grudge' => 'rancòr',
	'ur-add-button' => 'Apondre coma $1',
	'ur-add-button-foe' => 'Apondre coma enemic',
	'ur-add-button-friend' => 'Apondre coma amic',
	'ur-add-sent-title-foe' => 'Avètz mandat una declaracion d’ostilitat a $1 !',
	'ur-add-sent-title-friend' => 'Avètz mandat una declaracion d’amistat a $1 !',
	'ur-add-sent-message-foe' => 'Vòstra requèsta en ostilitat es estada mandada a $1 per confirmacion.
Se $1 confirma vòstra demanda, recebretz lo seguit per corrièr electronic.',
	'ur-add-sent-message-friend' => 'Vòstra requèsta en amistat es estada mandada a $1 per confirmacion.
Se $1 confirma vòstra demanda, recebretz lo seguit per corrièr electronic.',
	'ur-add-error-message-no-user' => 'L’utilizaire que sètz a apondre existís pas.',
	'ur-add-error-message-blocked' => "Actualament, sètz blocat e doncas podètz pas apondre ni d'amics ni d'enemics.",
	'ur-add-error-message-yourself' => 'Vos podètz pas apondre vos meteis coma enemic o amic.',
	'ur-add-error-message-existing-relationship' => 'Ja sètz $1 amb $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Ja sètz enemic de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Ja sètz amic de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciéncia!',
	'ur-add-error-message-pending-friend-request' => 'Avètz una demanda d’amistat en cors amb $1.
Vos notificarem se $1 confirma vòstra requèsta.',
	'ur-add-error-message-pending-foe-request' => 'Avètz una demanda d’ostilitat en cors amb $1.
Vos notificarem se $1 confirma vòstra requèsta.',
	'ur-add-error-message-not-loggedin' => 'Vos cal èsser connectat(ada) per apondre un $1.',
	'ur-add-error-message-not-loggedin-foe' => 'Vos cal èsser connectat per apondre un enemic',
	'ur-add-error-message-not-loggedin-friend' => 'Vos cal èsser connectat per apondre un amic',
	'ur-requests-title' => 'Demandas de relacions.',
	'ur-requests-message-foe' => '<a href="$1">$2</a> vòl èsser vòstre enemic.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> vòl èsser vòstre amic.',
	'ur-accept' => 'Acceptar',
	'ur-reject' => 'Regetar',
	'ur-no-requests-message' => 'Avètz pas cap de requèsta en amic o enemic. Se desiratz mai d\'amics, <a href="$1">invitatz-los !</a>',
	'ur-requests-added-message-foe' => 'Avètz apondut $1 a la lista de vòstres enemics.',
	'ur-requests-added-message-friend' => 'Avètz apondut $1 a la lista de vòstres amics.',
	'ur-requests-reject-message-friend' => 'Avètz refusat $1 en tant qu’amic.',
	'ur-requests-reject-message-foe' => 'Avètz refusat $1 en tant qu’enemic.',
	'ur-title-foe' => 'Tièra dels enemics de $1',
	'ur-title-friend' => 'Tièra dels amics de $1',
	'friend_request_subject' => '$1 vos a apondut coma un amic sus {{SITENAME}} !',
	'friend_request_body' => 'Adiu $1 :

$2 vos a apondut coma amic sus {{SITENAME}}. Nos volèm assegurar que sètz totes dos actualament amics.

Clicatz sus aqueste ligam per confirmar vòstra amistat :
$3

Mercés.

---

E ! Vos volètz arrestar de recebre de corrièrs de nòstra part ?

Clicatz $4
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.',
	'foe_request_subject' => 'Es la guèrra ! $1 vos a apondut coma enemic sus {{SITENAME}} !',
	'foe_request_body' => "Adiu $1 :

$2 vos ven just de repertoriar coma un enemic sus {{SITENAME}}. Nos volèm assegurar que sètz vertadièrament d'enemics mortals o qu'almens avètz de grèuges un envèrs l’autre/

Clicatz sus aqueste ligam, per acceptar, a contracòr, aqueste estat de fach.

$3

Mercés

---

E ! Volètz arrestar de recebre de corrièrs de nòstra part ?

Clicatz $4 e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.",
	'friend_accept_subject' => '$1 a acceptat vòstra requèsta en amistat sus {{SITENAME}} !',
	'friend_accept_body' => 'Adiu $1 : 

$2 a acceptat vòstra requèsta en amistat sus {{SITENAME}} !

Anatz sus la pagina de $2 sus $3

Mercés.

---

E ! Volètz vos arrestar de recebre de corrièrs de nòstra part ?

Clicatz $4
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.',
	'foe_accept_subject' => 'Es fach ! $1 a acceptat vòstra declaracion de guèrra sus  {{SITENAME}} !',
	'foe_accept_body' => 'Adiu $1 : 

$2 a acceptat vòstra declaracion de guèrra sus  {{SITENAME}} !

Visitatz la pagina de $2 sus $3.

Mercés

---

E ! Volètz vos arrestar de recebre de corrièrs de nòstra part ?

Clicatz $4
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.',
	'friend_removed_subject' => 'Me damne ! $1 vos a levat de la lista de sos amics sus {{SITENAME}} !',
	'friend_removed_body' => 'Adiu $1 :

$2 vos a levat de la lista de sos amics sus {{SITENAME}} !

Mercés

---

E ! Volètz vos arrestar de recebre de corrièrs de nòstra part ?

Clicatz $4
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.',
	'foe_removed_subject' => 'Òsca ! $1 vos a levat de la lista de sos enemics {{SITENAME}} !',
	'foe_removed_body' => 'Adiu $1 :

$2 vos a levat de la lista de sos enemics sus {{SITENAME}} !

Seriatz pas, benlèu, sul camin per venir amics ?

Mercés

---

E ! Volètz vos arrestar de recebre de corrièrs de nòstra part ?

Clicatz $4
e modificatz vòstras preferéncias per desactivar las notificacions per corrièr electronic.',
);

/** Polish (Polski)
 * @author Airwolf
 * @author Derbeth
 * @author Jwitos
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'viewrelationships' => 'Zobacz znajomych',
	'viewrelationshiprequests' => 'Zobacz zaproszenia do znajomości',
	'ur-already-submitted' => 'Twoje zaproszenie zostało wysłane',
	'ur-error-page-title' => 'Ups!',
	'ur-error-title' => 'Błąd',
	'ur-error-message-no-user' => 'Nie można zrealizować Twojego zaproszenia, ponieważ nie istnieje użytkownik o takiej nazwie.',
	'ur-main-page' => 'Strona główna',
	'ur-your-profile' => 'Twój profil',
	'ur-backlink' => '&lt; Powrót do profilu $1',
	'ur-add-friends' => '  Chcesz mieć więcej przyjaciół? <a href="$1">Zaproś ich</a>',
	'ur-add-friend' => 'Dodaj do przyjaciół',
	'ur-add-foe' => 'Dodaj do wrogów',
	'ur-add-no-user' => 'Nie wybrano żadnego użytkownika.
Wybierz znajomych/wrogów poprzez poprawny link.',
	'ur-add-personal-message' => 'Dodaj wiadomość osobistą',
	'ur-remove-relationship-friend' => 'Usuń z przyjaciół',
	'ur-remove-relationship-foe' => 'Usuń z wrogów',
	'ur-give-gift' => 'Daj prezent',
	'ur-previous' => 'poprz.',
	'ur-next' => 'nast.',
	'ur-remove-relationship-title-foe' => 'Czy chcesz usunąć $1 z listy wrogów?',
	'ur-remove-relationship-title-confirm-foe' => 'Usunąłeś $1 z listy wrogów',
	'ur-remove-relationship-title-friend' => 'Czy chcesz usunąć $1 z listy przyjaciół?',
	'ur-remove-relationship-title-confirm-friend' => 'Usunąłeś $1 z listy przyjaciół',
	'ur-remove-relationship-message-foe' => 'Zażądałeś usunięcia $1 ze swojej listy wrogów, wciśnij „$2” aby potwierdzić.',
	'ur-remove-relationship-message-confirm-foe' => 'Usunąłeś $1 z listy wrogów.',
	'ur-remove-relationship-message-friend' => 'Zażądałeś usunięcia $1 ze swojej listy przyjaciół, wciśnij „$2” aby potwierdzić.',
	'ur-remove-relationship-message-confirm-friend' => 'Usunąłeś $1 z listy przyjaciół.',
	'ur-remove-error-message-no-relationship' => 'Nie masz żadnych związków z $1.',
	'ur-remove-error-message-remove-yourself' => 'Nie możesz usunąć sam siebie.',
	'ur-remove' => 'Usuń',
	'ur-cancel' => 'Anuluj',
	'ur-login' => 'Zaloguj się',
	'ur-add-title-foe' => 'Czy chcesz dodać $1 do listy wrogów?',
	'ur-add-title-friend' => 'Czy chcesz dodać $1 do listy przyjaciół?',
	'ur-add-button-foe' => 'Oznacz jako wroga',
	'ur-add-button-friend' => 'Oznacz jako przyjaciela',
	'ur-add-error-message-no-user' => 'Użytkownik, którego próbujesz dodać, nie istnieje.',
	'ur-add-error-message-blocked' => 'Jesteś zablokowany i nie możesz dodawać nowych znajomych i wrogów.',
	'ur-add-error-message-yourself' => 'Nie możesz dodać samego siebie.',
	'ur-add-error-message-pending-request-title' => 'Cierpliwości!',
	'ur-requests-title' => 'Nawiązanie znajomości',
	'ur-accept' => 'Zaakceptuj',
	'ur-reject' => 'Odrzuć',
	'ur-no-requests-message' => 'Nie masz zaproszeń do przyjaźni oraz zgłoszeń od wrogów.
Jeśli chcesz mieć więcej przyjaciół <a href="$1">zaproś ich!</a>',
	'ur-title-foe' => 'Lista wrogów $1',
	'ur-title-friend' => 'Lista przyjaciół $1',
	'friend_request_subject' => '$1 dodał Ciebie do swoich przyjaciół na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'friend_removed_subject' => 'Och nie! $1 usunął Cię z listy przyjaciół na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'viewrelationships' => 'اړيکې کتل',
	'viewrelationshiprequests' => 'د اړيکو غوښتنې کتل',
	'ur-already-submitted' => 'ستاسو غوښتنه ولېږل شوه',
	'ur-main-page' => 'لومړی مخ',
	'ur-your-profile' => 'ستاسو پېژنليک',
	'ur-friend' => 'ملګری',
	'ur-add-friend' => 'خپل په ملګرو کې ورګډول',
	'ur-previous' => 'پخوانی',
	'ur-next' => 'راتلونکي',
	'ur-remove' => 'غورځول',
	'ur-login' => 'ننوتل',
	'ur-friendship' => 'ملګرتيا',
	'ur-requests-title' => 'د اړيکو غوښتنې',
	'ur-accept' => 'منل',
	'ur-reject' => 'ردول',
);

/** Portuguese (Português)
 * @author 555
 * @author Lijealso
 * @author Malafaya
 * @author Vanessa Sabino
 */
$messages['pt'] = array(
	'viewrelationships' => 'Ver relacionamentos',
	'viewrelationshiprequests' => 'Ver pedidos de relacionamentos',
	'ur-already-submitted' => 'Seu pedido foi enviado',
	'ur-error-page-title' => 'Ops!',
	'ur-error-title' => 'Ooops, você pegou um caminho errado!',
	'ur-error-message-no-user' => 'Não podemos completar a sua requisição, não existe um usuário com este nome.',
	'ur-main-page' => 'Página principal',
	'ur-your-profile' => 'Seu perfil',
	'ur-backlink' => '&lt; Voltar ao perfil de $1',
	'ur-friend' => 'amigo',
	'ur-foe' => 'inimigo',
	'ur-relationship-count-foes' => '$1 tem $2 {{PLURAL:$2|inimigo|inimigos}}. Quer mais inimigos? <a href="$3">Convide-os.</a>',
	'ur-relationship-count-friends' => '$1 tem $2 {{PLURAL:$2|amigo|amigos}}. Quer mais amigos? <a href="$3">Convide-os.</a>',
	'ur-add-friends' => ' Quer mais amigos? <a href="$1">Convide-os</a>',
	'ur-add-friend' => 'Adicionar como amigo',
	'ur-add-foe' => 'Adicionar como inimigo',
	'ur-add-no-user' => 'Nenhum usuário selecionado.
Por favor peça amigos/inimigos através do link correto.',
	'ur-add-personal-message' => 'Adicionar uma mensagem pessoal',
	'ur-remove-relationship-friend' => 'Remover como amigo',
	'ur-remove-relationship-foe' => 'Remover como inimigo',
	'ur-give-gift' => 'Dar um presente',
	'ur-previous' => 'ant',
	'ur-next' => 'prox',
	'ur-remove-relationship-title-foe' => 'Você quer remover $1 como seu inimigo?',
	'ur-remove-relationship-title-confirm-foe' => 'Você removeu $1 como seu inimigo',
	'ur-remove-relationship-title-friend' => 'Você quer remover $1 como seu amigo?',
	'ur-remove-relationship-title-confirm-friend' => 'Você removeu $1 como seu amigo',
	'ur-remove-relationship-message-foe' => 'Você pediu para remover $1 como seu inimigo, pressione "$2" para confirmar.',
	'ur-remove-relationship-message-confirm-foe' => 'Você removeu $1 como seu inimigo com sucesso.',
	'ur-remove-relationship-message-friend' => 'Você pediu para remover $1 como seu amigo, pressione "$2" para confirmar.',
	'ur-remove-relationship-message-confirm-friend' => 'Você removeu $1 como seu amigo com sucesso.',
	'ur-remove-error-message-no-relationship' => 'Você não possui um relacionamento com $1.',
	'ur-remove-error-message-remove-yourself' => 'Você não pode remover a si mesmo.',
	'ur-remove-error-message-pending-request' => 'Você tem um pedido de $1 com $2 pendente.',
	'ur-remove-error-message-pending-foe-request' => 'Você tem um pedido de inimizade pendente com $1.',
	'ur-remove-error-message-pending-friend-request' => 'Você tem um pedido de amizade pendente com $1.',
	'ur-remove-error-not-loggedin' => 'Tem que estar logado para remover um $1.',
	'ur-remove-error-not-loggedin-foe' => 'Você tem que estar logado para remover um inimigo.',
	'ur-remove-error-not-loggedin-friend' => 'Você tem que estar logado para remover um amigo.',
	'ur-remove' => 'Remover',
	'ur-cancel' => 'Cancelar',
	'ur-login' => 'Entrar',
	'ur-add-title-foe' => 'Você quer adicionar $1 como seu inimigo?',
	'ur-add-title-friend' => 'Você quer adicionar $1 como seu amigo?',
	'ur-add-message-foe' => 'Você está prestes a adicionar $1 como seu inimigo.
Nós iremos notificar $1 para confirmar seu rancor.',
	'ur-add-message-friend' => 'Você está prestes a adicionar $1 como seu amigo.
Nós iremos notificar $1 para confirmar sua amizade.',
	'ur-friendship' => 'amizade',
	'ur-grudge' => 'rancor',
	'ur-add-button' => 'Adicionar como $1',
	'ur-add-button-foe' => 'Adicionar como inimigo',
	'ur-add-button-friend' => 'Adicionar como amigo',
	'ur-add-sent-title-foe' => 'Nós enviamos seu pedido de inimizade para $1!',
	'ur-add-sent-title-friend' => 'Nós enviamos seu pedido de amizade para $1!',
	'ur-add-sent-message-foe' => 'Seu pedido de inimizade foi enviado para $1 para confirmação.
Se $1 confirmar seu pedido, você irá receber um e-mail',
	'ur-add-sent-message-friend' => 'Seu pedido de amizade foi enviado para $1 para confirmação.
Se $1 confirmar seu pedido, você irá receber um e-mail',
	'ur-add-error-message-no-user' => 'O usuário que pretende adicionar não existe.',
	'ur-add-error-message-blocked' => 'Você está bloqueado atualmente e não pode adicionar amigos ou inimigos.',
	'ur-add-error-message-yourself' => 'Você não pode adicionar a si mesmo como amigo ou inimigo.',
	'ur-add-error-message-existing-relationship' => 'Você já é $1 de $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Você já é inimigo de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Você já é amigo de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciência!',
	'ur-add-error-message-pending-friend-request' => 'Você tem um pedido de amizade pendente com $1.
Nós iremos notificar você quando $1 confirmar seu pedido.',
	'ur-add-error-message-pending-foe-request' => 'Você tem um pedido de inimizade pendente com $1.
Nós iremos notificar você quando $1 confirmar seu pedido.',
	'ur-add-error-message-not-loggedin' => 'Necessário estar logado para adicionar $1',
	'ur-add-error-message-not-loggedin-foe' => 'Você precisa estar logado para adicionar um inimigo',
	'ur-add-error-message-not-loggedin-friend' => 'Você precisa estar logado para adicionar um amigo',
	'ur-requests-title' => 'Pedidos de relacionamento',
	'ur-requests-message-foe' => '<a href="$1">$2</a> quer ser seu inimigo.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> quer ser seu amigo.',
	'ur-accept' => 'Aceitar',
	'ur-reject' => 'Rejeitar',
	'ur-no-requests-message' => 'Você não ter pedidos de amizade ou inimizade.
Se você quer mais amigos, <a href="$1">convide-os!</a>',
	'ur-requests-added-message-foe' => 'Você adicionou $1 como seu inimigo.',
	'ur-requests-added-message-friend' => 'Você adicionou $1 como seu amigo.',
	'ur-requests-reject-message-friend' => 'Você rejeitou $1 como seu amigo.',
	'ur-requests-reject-message-foe' => 'Você rejeitou $1 como seu inimigo.',
	'ur-title-foe' => 'lista de inimigos de $1',
	'ur-title-friend' => 'lista de amigos de $1',
	'friend_request_subject' => '$1 adicionou você como amigo em {{SITENAME}}!',
	'friend_request_body' => 'Oi $1:

$2 adicionou você como amigo em {{SITENAME}}. Queremos ter certeza de que vocês são realmente amigos.

Por favor clique neste link para confirmar sua amizade:
$3

Obrigado

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferências para desabilitar e-mails de notificação.',
	'foe_request_subject' => 'É guerra! $1 adicionou você como inimigo em {{SITENAME}}!',
	'foe_request_body' => 'Hi $1:

$2 acabou de listá-lo como inimigo em {{SITENAME}}. Queremos ter certeza de que vocês realmente são inimigos mortais ou pelo menos estão tendo uma discussão.

Por favor clique neste link para confirmar o rancor.

$3

Obrigado

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferências para desabilitar e-mails de notificação.',
	'friend_accept_subject' => '$1 aceitou você como amigo em {{SITENAME}}!',
	'friend_accept_body' => 'Oi $1:

$2 aceitou você como amigo em {{SITENAME}}!

Veja a página de $2 em $3

Obrigado,

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferências para desabilitar e-mails de notificação.',
	'foe_accept_subject' => '$1 aceitou você como inimigo em {{SITENAME}}!',
	'foe_accept_body' => 'Oi $1:

$2 aceitou você como inimigo em {{SITENAME}}!

Veja a página de $2 em $3

Obrigado,

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferências para desabilitar e-mails de notificação',
	'friend_removed_subject' => 'Ah não! $1 removeu você como amigo em {{SITENAME}}!',
	'friend_removed_body' => 'Oi $1:

$2 removeu você como amigo em {{SITENAME}}!

Obrigado,

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferências para desabilitar e-mails de notificação',
	'foe_removed_subject' => 'Eba! $1 removeu você como inimigo em {{SITENAME}}!',
	'foe_removed_body' => 'Oi $1:

	$2 removeu você como inimigo em {{SITENAME}}!

Talvez vocês estejam no caminho de tornarem-se amigos?

Obrigado,

---

Ei, quer parar de receber e-mails de nós?

Clique $4
e altere suas preferências para desabilitar e-mails de notificação',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'ur-main-page' => 'Tasbtirt Tamzwarut',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'ur-main-page' => 'Pagina principală',
	'ur-friend' => 'prieten',
	'ur-remove' => 'Elimină',
	'ur-cancel' => 'Anulează',
	'ur-login' => 'Autentificare',
	'ur-friendship' => 'prietenie',
	'ur-add-error-message-pending-request-title' => 'Răbdare!',
	'ur-requests-title' => 'Cereri de relaţii',
	'ur-title-friend' => 'Lista de prieteni ai lui $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ur-main-page' => 'Pàgene Prengepàle',
	'ur-your-profile' => "'U profile tue",
	'ur-give-gift' => "Fa 'nu riele",
	'ur-previous' => 'prec',
	'ur-next' => 'succ',
	'ur-remove' => 'Scangille',
	'ur-cancel' => 'Scangille',
	'ur-login' => 'Trase',
	'ur-add-button-friend' => 'Aggiugne cumme amiche',
	'ur-requests-message-friend' => '<a href="$1">$2</a> vvò ccu devende amiche tue.',
	'ur-accept' => 'Accitte',
	'ur-reject' => 'Scitte',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Flrn
 * @author Innv
 * @author Rubin
 */
$messages['ru'] = array(
	'ur-already-submitted' => 'Ваш запрос был отправлен',
	'ur-main-page' => 'Заглавная страница',
	'ur-your-profile' => 'Ваш профиль',
	'ur-friend' => 'друг',
	'ur-remove' => 'Удалить',
	'ur-cancel' => 'Отмена',
	'ur-add-error-message-pending-request-title' => 'Терпение!',
	'ur-accept' => 'Принять',
);

/** Tachelhit (Tašlḥiyt)
 * @author Zanatos
 */
$messages['shi'] = array(
	'ur-accept' => 'qbl',
	'ur-reject' => 'adur-tqblt',
	'friend_request_body' => 'Azul $1:

$2 iskr gik zod amdakl ns ɣ {{SITENAME}}.  nra annisan isnit tgam imdukal nsaḥt.

ad o-zday ad bach atsḥut tidukla nk:
$3

Tanmirte

---

yak ortrit azakn soul ur-nsifid tibratin?
ad $4
sbddlt reglage nk bach aktnin soul ur-nsifid.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'viewrelationships' => 'Zobraziť vzťah',
	'viewrelationshiprequests' => 'Zobraziť žiadosti o vzťah',
	'ur-already-submitted' => 'Vaša požiadavka bola odoslaná',
	'ur-error-page-title' => 'Ops!',
	'ur-error-title' => 'Ops, niečo ste spravili zle!',
	'ur-error-message-no-user' => 'Nebolo možné dokončiť vašu požiadavku, pretože používateľ s daným menom neexistuje.',
	'ur-main-page' => 'Hlavná stránka',
	'ur-your-profile' => 'Váš profil',
	'ur-backlink' => '&lt; Späť na profil $1',
	'ur-friend' => 'priateľ',
	'ur-foe' => 'nepriateľ',
	'ur-relationship-count-foes' => '$1 má $2 {{PLURAL:$2|nepriateľa|nepriateľov}}. Chcete viac nepriateľov? <a href="$3">Pozvite ich.</a>',
	'ur-relationship-count-friends' => '$1 má $2 {{PLURAL:$2|priateľa|priateľov}}. Chcete viac priateľov? <a href="$3">Pozvite ich.</a>',
	'ur-add-friends' => 'Chcete viac priateľov? <a href="$1">Pozvite ich</a>',
	'ur-add-friend' => 'Pridať ako priateľa',
	'ur-add-foe' => 'Pridať ako nepriateľa',
	'ur-add-no-user' => 'Nebol vybraný žiadny používateľ. Prosím, žiadajte o priateľov/nepriateľov použitím správneho odkazu.',
	'ur-add-personal-message' => 'Pridať osobnú správu',
	'ur-remove-relationship-friend' => 'Odstrániť priateľa',
	'ur-remove-relationship-foe' => 'Odstrániť nepriateľa',
	'ur-give-gift' => 'Darovať darček',
	'ur-previous' => 'predch',
	'ur-next' => 'nasled',
	'ur-remove-relationship-title-foe' => 'Chcete odstrániť $1 zo zoznamu svojich nepriateľov?',
	'ur-remove-relationship-title-confirm-foe' => 'Odstránili ste $1 zo zoznamu svojich nepriateľov',
	'ur-remove-relationship-title-friend' => 'Chcete odstrániť $1 zo zoznamu svojich priateľov?',
	'ur-remove-relationship-title-confirm-friend' => 'Odstránili ste $1 zo zoznamu svojich priateľov',
	'ur-remove-relationship-message-foe' => 'Požiadali ste o odstránenie $1 zo zoznamu svojich nepriateľov. Potvrďte to stlačením „$2”.',
	'ur-remove-relationship-message-confirm-foe' => 'Úspešne ste odstránili $1 zo zoznamu svojich nepriateľov.',
	'ur-remove-relationship-message-friend' => 'Požiadali ste o odstránenie $1 zo zoznamu svojich priateľov. Potvrďte to stlačením „$2”.',
	'ur-remove-relationship-message-confirm-friend' => 'Úspešne ste odstránili $1 zo zoznamu svojich priateľov.',
	'ur-remove-error-message-no-relationship' => 'Nemáte žiaden vzťah s $1.',
	'ur-remove-error-message-remove-yourself' => 'Nemôžete odstrániť seba.',
	'ur-remove-error-message-pending-request' => 'Máte nevybavenú žiadosť o $1 u $2.',
	'ur-remove-error-message-pending-foe-request' => 'Máte čakajúcu požiadavku na nepriateľstvo s $1.',
	'ur-remove-error-message-pending-friend-request' => 'Máte čakajúcu požiadavku na priateľstvo s $1.',
	'ur-remove-error-not-loggedin' => 'Aby ste mohli odstrániť $1, musíte byť prihlásený.',
	'ur-remove-error-not-loggedin-foe' => 'Aby ste mohli odstrániť nepriateľa, musíte sa prihlásiť.',
	'ur-remove-error-not-loggedin-friend' => 'Aby ste mohli odstrániť priateľa, musíte sa prihlásiť.',
	'ur-remove' => 'Odstrániť',
	'ur-cancel' => 'Zrušiť',
	'ur-login' => 'Prihlásiť sa',
	'ur-add-title-foe' => 'Želáte si pridať $1 medzi svojich nepriateľov?',
	'ur-add-title-friend' => 'Želáte si pridať $1 medzi svojich priateľov?',
	'ur-add-message-foe' => 'Chystáte sa pridať $1 medzi svojich nepriateľov.
Upozorníme $1, aby potvrdil váš spor.',
	'ur-add-message-friend' => 'Chystáte sa pridať $1 medzi svojich priateľov.
Upozorníme $1, aby potvrdil vaše priateľstvo.',
	'ur-friendship' => 'priateľstvo',
	'ur-grudge' => 'nepriateľstvo',
	'ur-add-button' => 'Pridať ako $1',
	'ur-add-button-foe' => 'Pridať medzi nepriateľov',
	'ur-add-button-friend' => 'Pridať medzi priateľov',
	'ur-add-sent-title-foe' => 'Vaša požiadavka na nepriateľstvo s $1 bola odoslaná!',
	'ur-add-sent-title-friend' => 'Vaša požiadavka na uzatvorenie priateľstva s $1 bola odoslaná!',
	'ur-add-sent-message-foe' => 'Vaša požiadavka na nepriateľstvo bola odoslaná, aby ju $1 potrvrdil.
Ak ju $1 potvrdí, dostanete o tom upozornenie emailom.',
	'ur-add-sent-message-friend' => 'Vaša požiadavka na uzatvorenie priateľstva bola odoslaná, aby ju $1 potrvrdil.
Ak ju $1 potvrdí, dostanete o tom upozornenie emailom.',
	'ur-add-error-message-no-user' => 'Používateľ, ktorého sa pokúšate pridať, neexistuje.',
	'ur-add-error-message-blocked' => 'Momentálne ste zablokovaný a nemôžete pridávať priadteľov alebo nepriateľov.',
	'ur-add-error-message-yourself' => 'Nemôžete pridať sám seba ako priateľa alebo nepriateľa.',
	'ur-add-error-message-existing-relationship' => 'S $2 už ste $1.',
	'ur-add-error-message-existing-relationship-foe' => 'Už ste nepriateľ s $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Už ste priateľ s $1.',
	'ur-add-error-message-pending-request-title' => 'Trpezlivosť!',
	'ur-add-error-message-pending-friend-request' => 'Máte žiadosť o uzatvorenie priateľstva s $1, ktorá čaká na potvrdenie.
Upozorníme vás, keď $1 potvrdí vašu žiadosť.',
	'ur-add-error-message-pending-foe-request' => 'Máte žiadosť o nepriateľstvo s $1, ktorá čaká na potvrdenie.
Upozorníme vás, keď $1 potvrdí vašu žiadosť.',
	'ur-add-error-message-not-loggedin' => 'Aby ste mohli pridať $1, musíte sa prihlásiť.',
	'ur-add-error-message-not-loggedin-foe' => 'Aby ste mohli pridať nepriateľa, musíte sa prihlásiť',
	'ur-add-error-message-not-loggedin-friend' => 'Aby ste mohli pridať priateľa, musíte sa prihlásiť',
	'ur-requests-title' => 'Žiadosti o vzťah',
	'ur-requests-message-foe' => '<a href="$1">$2</a> chce byť váš nepriateľ.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> chce byť váš priateľ.',
	'ur-accept' => 'Prijať',
	'ur-reject' => 'Odmietnuť',
	'ur-no-requests-message' => 'Nemáte žiadosti o vytvorenie vzťahu priateľ či nepriateľ.
Ak chcete viac priateľov, <a href="$1">pozvite ich!</a>',
	'ur-requests-added-message-foe' => 'Pridali ste $1 medzi svojich nepriateľov.',
	'ur-requests-added-message-friend' => 'Pridali ste $1 medzi svojich priateľov.',
	'ur-requests-reject-message-friend' => 'Odmietli ste pridať $1 medzi svojich priateľov.',
	'ur-requests-reject-message-foe' => 'Odmietli ste pridať $1 medzi svojich nepriateľov.',
	'ur-title-foe' => 'Zoznam nepriateľov používateľa $1',
	'ur-title-friend' => 'Zoznam priateľov používateľa $1',
	'friend_request_subject' => '$1 si vás pridal ako priateľa na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'friend_request_body' => 'Ahoj $1:

$2 si vás pridal ako priateľa na {{GRAMMAR:lokál|{{SITENAME}}}}. Chceme sa uistiť, že ste skutočne priatelia.

Svoje priateľstvo potvrdíte kliknutím na nasledovný odkaz:

$3

Vďaka

---

Nechcete viac od nás dostávať email?

Kliknite na $4
a vypnite upozornenia emailov vo svojich nastaveniach.',
	'foe_request_subject' => 'Je vojna! $1 si vás pridal ako nepriateľa na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'foe_request_body' => 'Ahoj $1:

$2 si vás pridal ako nepriateľa na {{GRAMMAR:lokál|{{SITENAME}}}}. Chceme sa uistiť, že ste skutočne nepriatelia na smrť alebo ste sa aspoň pohádali.

Svoje nepriateľstvo potvrdíte kliknutím na nasledovný odkaz:

$3

Vďaka

---

Nechcete viac od nás dostávať email?

Kliknite na $4
a vypnite upozornenia emailov vo svojich nastaveniach.',
	'friend_accept_subject' => '$1 prijal vašu požiadavku na uzavretie priateľstva na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'friend_accept_body' => 'Ahoj $1:

$1 prijal vašu požiadavku na uzavretie priateľstva na {{GRAMMAR:lokál|{{SITENAME}}}}!

Pozrite si stránku $2 na $3

Vďaka

---

Nechcete viac od nás dostávať email?

Kliknite na $4
a vypnite upozornenia emailov vo svojich nastaveniach.',
	'foe_accept_subject' => 'Je to tu! $1 prijal vašu požiadavku na vyhlásenie nepriateľstva na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'foe_accept_body' => 'Ahoj $1:

$1 prijal vašu požiadavku na vyhlásenie nepriateľstva na {{GRAMMAR:lokál|{{SITENAME}}}}!

Pozrite si stránku $2 na $3

Vďaka

---

Nechcete viac od nás dostávať email?

Kliknite na $4
a vypnite upozornenia emailov vo svojich nastaveniach.',
	'friend_removed_subject' => 'Ó. nie! $1 si vás odstránil ako priateľa na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'friend_removed_body' => 'Ahoj $1:

$2 si vás odstránil ako priateľa na {{GRAMMAR:lokál|{{SITENAME}}}}!

Vďaka

---

Nechcete viac od nás dostávať email?

Kliknite na $4
a vypnite upozornenia emailov vo svojich nastaveniach.',
	'foe_removed_subject' => 'Hej! $1 si vás odstránil ako nepriateľa na {{GRAMMAR:lokál|{{SITENAME}}}}!',
	'foe_removed_body' => 'Ahoj $1:

$2 si vás odstránil ako nepriateľa na {{GRAMMAR:lokál|{{SITENAME}}}}!

Že by ste sa začínali spriateľovať?

Vďaka

---

Nechcete viac od nás dostávať email?

Kliknite na $4
a vypnite upozornenia emailov vo svojich nastaveniach.',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'ur-remove' => 'Уклони',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'ur-main-page' => 'Likhasi lelikhulu',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'viewrelationships' => 'Visa relationer',
	'viewrelationshiprequests' => 'Visa efterfrågningar om relationer',
	'ur-already-submitted' => 'Din efterfrågning har skickats',
	'ur-error-page-title' => 'Oops!',
	'ur-error-title' => 'Oops, du hamnade fel!',
	'ur-error-message-no-user' => 'Vi kan inte fullfölja din efterfrågning, för att det inte finns någon användare med detta namn.',
	'ur-main-page' => 'Huvudsida',
	'ur-your-profile' => 'Din profil',
	'ur-backlink' => '&lt; Tillbaka till $1s profil',
	'ur-friend' => 'vän',
	'ur-foe' => 'fiende',
	'ur-relationship-count-foes' => '$1 har $2 {{PLURAL:$2|fiende|fiender}}. Vill du ha fler fiender? <a href="$3">Bjud in dem.</a>',
	'ur-relationship-count-friends' => '$1 har $2 {{PLURAL:$2|vän|vänner}}. Vill du ha flera vänner? <a href="$3">Bjud in dem.</a>',
	'ur-add-friends' => 'Vill du ha mer vänner? <a href="$1">Bjud in dom</a>',
	'ur-add-friend' => 'Lägg till som vän',
	'ur-add-foe' => 'Lägg till som fiende',
	'ur-add-no-user' => 'Ingen användare väljd. Var god lägg till vänner eller fiender med den korrekta länken.',
	'ur-add-personal-message' => 'Lägg till ett personligt meddelande',
	'ur-remove-relationship-friend' => 'Ta bort som vän',
	'ur-remove-relationship-foe' => 'Ta bort som fiende',
	'ur-give-gift' => 'Ge en present',
	'ur-previous' => 'föregående',
	'ur-next' => 'nästa',
	'ur-remove-relationship-title-foe' => 'Vill du ta bort $1 som din fiende?',
	'ur-remove-relationship-title-confirm-foe' => 'Du har tagit bort $1 som din fiende',
	'ur-remove-relationship-title-friend' => 'Vill du ta bort $1 som din vän?',
	'ur-remove-relationship-title-confirm-friend' => 'Du har tagit bort $1 som din vän',
	'ur-remove-relationship-message-foe' => 'Du har begärt om att ta bort $1 som din fiende, tryck "$2" för att bekräfta.',
	'ur-remove-relationship-message-confirm-foe' => 'Du har tagit bort $1 som din fiende.',
	'ur-remove-relationship-message-friend' => 'Du har begärt att ta bort $1 som din vän, tryck "$2" för att bekräfta.',
	'ur-remove-relationship-message-confirm-friend' => 'Du har tagit bort $1 som din vän.',
	'ur-remove-error-message-no-relationship' => 'Du har ingen relation med $1.',
	'ur-remove-error-message-remove-yourself' => 'Du kan inte ta bort dig själv.',
	'ur-remove-error-message-pending-request' => 'Du har en väntande efterfrågning om att bli $1 med $2 hos $2.',
	'ur-remove-error-message-pending-foe-request' => 'Du har en väntande fiendebegäran hos $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du har en väntande vänbegäran hos $1.',
	'ur-remove-error-not-loggedin' => 'Du måste logga in för att ta bort en $1.',
	'ur-remove-error-not-loggedin-foe' => 'Du måste vara inloggad för att ta bort en fiende.',
	'ur-remove-error-not-loggedin-friend' => 'Du måste vara inloggad för att ta bort en vän.',
	'ur-remove' => 'Ta bort',
	'ur-cancel' => 'Avbryt',
	'ur-login' => 'Logga in',
	'ur-add-title-foe' => 'Vill du lägga till $1 som din fiende?',
	'ur-add-title-friend' => 'Vill du lägga till $1 som din vän?',
	'ur-add-message-foe' => 'Du är i färd med att lägga till $1 som din fiende.
Vi kommer skicka $1 ett meddelande för att bekräfta fiendeskapet.',
	'ur-add-message-friend' => 'Du är i färd med att lägga till $1 som din vän.
Vi kommer skicka $1 ett meddelande för att bekräfta vänskapet.',
	'ur-friendship' => 'vänskap',
	'ur-grudge' => 'fiendeskap',
	'ur-add-button' => 'Lägg till som $1',
	'ur-add-button-foe' => 'Lägg till som fiende',
	'ur-add-button-friend' => 'Lägg till som vän',
	'ur-add-error-message-no-user' => 'Användaren du prövade att lägga till finns inte.',
	'ur-add-error-message-blocked' => 'Du är blockerad, och kan inte lägga till vänner eller fiender.',
	'ur-add-error-message-yourself' => 'Du kan inte lägga till dig själv som vän eller fiende.',
	'ur-add-error-message-existing-relationship' => 'Du är redan $1 med $2.',
	'ur-add-error-message-existing-relationship-foe' => 'Du är redan fiende med $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du är redan vän med $1.',
	'ur-add-error-message-pending-request-title' => 'Var tålmodig...',
	'ur-add-error-message-not-loggedin' => 'Du måste vara inloggad för att lägga till en $1',
	'ur-add-error-message-not-loggedin-foe' => 'Du måste vara inloggad för att lägga till en fiende',
	'ur-add-error-message-not-loggedin-friend' => 'Du måste vara inloggad för att lägga till en vän',
	'ur-requests-title' => 'Relationsefterfrågningar',
	'ur-requests-message-foe' => '<a href="$1">$2</a> vill bli din fiende.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> vill bli din vän.',
	'ur-accept' => 'Acceptera',
	'ur-reject' => 'Avslå',
	'ur-no-requests-message' => 'Du har inga vän- eller fiendeefterfrågningar. Om du vill ha mer vänner, <a href="$1">bjud in dom</a>!',
	'ur-requests-added-message-foe' => 'Du har lagt till $1 som din fiende.',
	'ur-requests-added-message-friend' => 'Du har lagt till $1 som din vän.',
	'ur-requests-reject-message-friend' => 'Du har avvisat $1 som din vän.',
	'ur-requests-reject-message-foe' => 'Du har avvisat $1 som din fiende.',
	'ur-title-foe' => '$1s lista över fiender',
	'ur-title-friend' => '$1s lista över vänner',
	'friend_request_subject' => '$1 har laggt till dig som vän på {{SITENAME}}!',
	'friend_request_body' => 'Hej, $1!

$2 har lagt till dig som en vän på {{SITENAME}}.  Vi vill vara säkra på att ni två verkligen är vänner.

Var god klicka på den här länken för att bekräfta eran vänskap:
$3

Tack

---

Vill du inte ha mer mejl från oss?

Klicka $4
och ändra dina inställningar att inte tillåta e-postmeddelanden.',
	'foe_request_subject' => 'Det är krig! $1 har lagt till dig som fiende på {{SITENAME}}!',
	'foe_request_body' => 'Hej, $1!

$2 har lagt till dig som fiende på {{SITENAME}}.  Vi vill vara säkra på att ni två är fiender  eller i varje fall bråkar.

Var god klicka på den här länken för att bekräfta eran fiendeskap.

$3

Tack

---

Vill du inte ha mer mejl från oss?

Klicka $4
och ändra dina inställningar att inte tillåta e-postmeddelanden.',
	'friend_accept_subject' => '$1 har accepterat din vänskapsefterfrågning på {{SITENAME}}!',
	'friend_accept_body' => 'Hej, $1!

$2 har accepterat din efterfrågning om att bli vän med $2 på {{SITENAME}}!

Kolla på $2s sida på $3

Tack

---

Vill du inte ha mer mejl från oss?

Klicka $4
och ändra dina inställningar att inte tillåta e-postmeddelanden.',
	'foe_accept_subject' => '$1 har accepterat din fiendeskapsefterfrågning på {{SITENAME}}!',
	'foe_accept_body' => 'Hej, $1!

$2 har accepterat din efterfrågning om fiendeskap med $2 på {{SITENAME}}!

Kolla på $2s sida på $3

Tack

---

Vill du inte ha mer mejl från oss?

Klicka $4
och ändra dina inställningar att inte tillåta e-postmeddelanden.',
	'friend_removed_subject' => 'Å Nej! $1 har tagit bort dig som vän på {{SITENAME}}!',
	'friend_removed_body' => 'Hej, $1

$2 har tagit bort dig som vän på {{SITENAME}}.

---

Vill du inte mottaga mer e-post från oss?

Klicka $4 och ändra dina inställningar för att stänga av e-postmeddelanden.',
	'foe_removed_subject' => 'Hurra! $1 har tagit bort dig som fiende på {{SITENAME}}!',
	'foe_removed_body' => 'Hej, $1.

$2 har tagit bort dig som fiende på {{SITENAME}}.

Kanske ni två är på väg att bli vänner?

---

Vill du inte motta mer e-post från oss?

Klicka $4 och ändra dina inställningarna för att slå av e-postmeddelanden.',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'ur-main-page' => 'Přodńo zajta',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'viewrelationships' => 'బంధాన్ని చూడండి',
	'ur-already-submitted' => 'మీ అభ్యర్థనని పంపించాం',
	'ur-error-message-no-user' => 'మీ అభ్యర్థనని మన్నింపలేము, ఎందుకంటే ఈ పేరుతో వాడుకరులెవరూ లేరు.',
	'ur-main-page' => 'మొదటి పేజీ',
	'ur-your-profile' => 'మీ ప్రొఫైలు',
	'ur-friend' => 'స్నేహితులు',
	'ur-foe' => 'శత్రువు',
	'ur-add-friends' => ' మరింత మంది మిత్రులు కావాలా? <a href="$1">ఆహ్వానించండి</a>',
	'ur-add-friend' => 'స్నేహితునిగా చేర్చు',
	'ur-add-foe' => 'శత్రువుగా చేర్చు',
	'ur-add-personal-message' => 'ఒక వ్యక్తిగత సందేశాన్ని చేర్చండి',
	'ur-give-gift' => 'ఒక బహుమతి ఇవ్వండి',
	'ur-previous' => 'క్రితం',
	'ur-next' => 'తర్వాతి',
	'ur-remove-relationship-title-confirm-foe' => '$1ని మీ శతృవుగా తొలగించుకున్నారు.',
	'ur-remove-relationship-title-friend' => '$1 ని మీ మిత్రునిగా తొలగించమంటారా?',
	'ur-remove-relationship-title-confirm-friend' => '$1ని మీ మిత్రునిగా తొలగించుకున్నారు',
	'ur-remove-error-message-remove-yourself' => 'మిమ్మల్ని మీరే తొలగించుకోలేరు.',
	'ur-remove-error-not-loggedin' => '$1ని తొలగించడానికి మీరు లోనికి ప్రవేశించి ఉండాలి.',
	'ur-remove' => 'తొలగించు',
	'ur-cancel' => 'రద్దు',
	'ur-login' => 'ప్రవేశించండి',
	'ur-add-title-foe' => '$1ని మీ శతృవుగా చేర్చమంటారా?',
	'ur-add-title-friend' => '$1ని మీ మిత్రునిగా చేర్చమంటారా?',
	'ur-friendship' => 'స్నేహం',
	'ur-grudge' => 'పగ',
	'ur-add-button' => '$1గా చేర్చు',
	'ur-add-button-foe' => 'శతృవుగా చేర్చు',
	'ur-add-button-friend' => 'మిత్రునిగా చేర్చు',
	'ur-add-error-message-no-user' => 'మీరు చేర్చాలని ప్రయత్నిస్తున్న వాడుకరి లేనే లేరు.',
	'ur-add-error-message-yourself' => 'మిమ్మల్ని మీరే స్నేహితునిగానో లేదా శత్రువుగానో చేర్చుకోలేరు.',
	'ur-add-error-message-existing-relationship-foe' => 'మీరు ఇప్పటికే $1కి శతృవులు.',
	'ur-add-error-message-existing-relationship-friend' => 'మీరు ఇప్పటికే $1కి మిత్రులు.',
	'ur-add-error-message-pending-request-title' => 'ఓపిక!',
	'ur-add-error-message-not-loggedin' => '$1ని చేర్చడానికి మీరు లోనికి ప్రవేశించి ఉండాలి.',
	'ur-requests-title' => 'సంబంధ అభ్యర్థనలు',
	'ur-accept' => 'అంగీకరించు',
	'ur-reject' => 'తిరస్కరించు',
	'ur-no-requests-message' => 'మీకు మిత్రుత్వ లేదా శత్రుత్వ అభ్యర్థనలు లేవు. మీకు మరింత మంది స్నేహితులు కావాలంటే, <a href="$1">వారిని ఆహ్వానించండి!</a>',
	'ur-title-foe' => '$1 యొక్క శతృవుల జాబితా',
	'ur-title-friend' => '$1 యొక్క మిత్రుల జాబితా',
	'friend_request_subject' => '{{SITENAME}}లో $1 మిమ్మల్ని స్నేహితునిగా చేర్చుకున్నారు!',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'ur-main-page' => 'Pájina Mahuluk',
	'ur-next' => 'oinmai',
	'ur-cancel' => 'Para',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'ur-main-page' => 'Саҳифаи Аслӣ',
	'ur-your-profile' => 'Намояи шумо',
	'ur-friend' => 'дӯст',
	'ur-foe' => 'душман',
	'ur-add-friends' => ' Бештар дӯстон мехоҳед? <a href="$1">Онҳоро даъват кунед</a>',
	'ur-add-friend' => 'Чун дӯст илова кунед',
	'ur-add-foe' => 'Чун ҳариф илова кунед',
	'ur-give-gift' => 'Ҳадя диҳед',
	'ur-previous' => 'қаблӣ',
	'ur-next' => 'баъдӣ',
	'ur-remove-error-message-no-relationship' => 'Шумо муносибате бо $1 надоред.',
	'ur-remove-error-message-remove-yourself' => 'Шумо худро наметавонед пок кунед.',
	'ur-remove-error-not-loggedin' => 'Барои пок кардани $1 шумо бояд вуруд шавед.',
	'ur-remove' => 'Ҳазф',
	'ur-cancel' => 'Лағв',
	'ur-login' => 'Вуруд кунед',
	'ur-friendship' => 'дӯстӣ',
	'ur-add-error-message-no-user' => 'Корбари шумо кӯшиши илова кардани ҳастед вуҷуд надорад.',
	'ur-add-error-message-yourself' => 'Шумо худро наметавонед чун дӯст ё ҳариф илова кунед.',
	'ur-add-error-message-existing-relationship' => 'Шумо аллакай $1 бо $2 мебошед.',
	'ur-add-error-message-pending-request-title' => 'Сабр!',
	'ur-add-error-message-not-loggedin' => 'Шумо барои илова кардани $1 бояд вуруд кунед.',
	'ur-requests-title' => 'Дархостҳои иртибот',
	'ur-accept' => 'Пазируфтан',
	'ur-reject' => 'Рад кардан',
	'friend_request_subject' => '$1 шуморо чун дӯсташ дар {{SITENAME}} илова кард!',
	'friend_request_body' => 'Салом $1:

$2 шуморо ҳамчун дӯст дар {{SITENAME}} илова кард.  Мо мехоҳем мутмаин бошем, ки шумо дар ҳақиқат дӯстон ҳастед.

Лутфан ин пайвандро бо тасдиқ кардани дӯстии худ пахш кунед:
$3

Ташаккур

---

Ҳой, оё шумо мехоҳед ба дарёфт кардани номаҳои электронӣ аз мо хотима бидиҳед?

$4-ро клик кунед
ва тарҷиҳоти худро бо ғайрифаъол кардани огоҳсозии тариқи почтаи электронӣ тағйир диҳед.',
	'foe_request_subject' => 'Ин низоъ аст! $1 шуморо ҳамчун душмани худ дар {{SITENAME}} илова кард!',
	'foe_request_body' => 'Салом $1:

$2 шуморо ҳамчун душмани худ дар {{SITENAME}} илова кард. Мо мехоҳем мутмаин бошем, ки шумо дар ҳақиқат душманони ашадӣ ҳастед ё ҳадди ақал мунозира доред.

Лутфан ин пайвандро бо тасдиқ кардани рост наомадани муносибати дӯстонаатон пахш кунед: $3

$3

Ташаккур

---

Ҳой, оё шумо мехоҳед ба дарёфт кардани номаҳои электронӣ аз мо хотима бидиҳед?

$4-ро клик кунед ва тарҷиҳоти худро бо ғайрифаъол кардани огоҳсозии тариқи почтаи электронӣ тағйир диҳед.',
	'friend_accept_subject' => '$1 дархости дӯстии шуморо дар {{SITENAME}} қабул кард!',
	'friend_accept_body' => 'Салом $1:

$2 дархости дӯстшавии шуморо дар {{SITENAME}} қабул кард!

Саҳифаи $2-ро дар $3 нигаред

Ташаккур,

---

Ҳой, оё шумо мехоҳед ба дарёфт кардани номаҳои электронӣ аз мо хотима бидиҳед?

$4-ро клик кунед
ва тарҷиҳоти худро бо ғайрифаъол кардани огоҳсозии тариқи почтаи электронӣ тағйир диҳед.',
	'foe_accept_subject' => 'Ана тамом! $1 дархости ҳарифии шуморо дар {{SITENAME}} қабул кард!',
	'foe_accept_body' => 'Салом $1:

$2 дархости душмании шуморо дар {{SITENAME}} қабул кард!

Саҳифаи $2-ро дар $3 нигаред

Ташаккур,

---

Ҳой, оё шумо мехоҳед ба дарёфт кардани номаҳои электронӣ аз мо хотима бидиҳед?

$4-ро клик кунед
ва тарҷиҳоти худро бо ғайрифаъол кардани огоҳсозии тариқи почтаи электронӣ тағйир диҳед.',
	'friend_removed_subject' => 'Ваҳ! $1 шуморо ҳамчун дӯст дар {{SITENAME}} пок кард!',
	'friend_removed_body' => 'Салом $1:

$2 шуморо ҳамчун дӯст дар {{SITENAME}} пок кард!

Ташаккур

---

Ҳой, оё шумо мехоҳед ба дарёфт кардани номаҳои электронӣ аз мо хотима бидиҳед?

$4-ро клик кунед
ва тарҷиҳоти худро бо ғайрифаъол кардани огоҳсозии тариқи почтаи электронӣ тағйир диҳед.',
	'foe_removed_subject' => 'Уҳу! $1 шуморо ҳамчун душмани худ дар {{SITENAME}} пок кард!',
	'foe_removed_body' => 'Салом $1:

$2 шуморо ҳамчун душмани худ дар  {{SITENAME}} пок кард!

Шояд шумо ҳарду дар роҳи дӯст шудан бошед?

Ташаккур

---


Ҳой, оё шумо мехоҳед ба дарёфт кардани номаҳои электронӣ аз мо хотима бидиҳед?

$4-ро клик кунед
ва тарҷиҳоти худро бо ғайрифаъол кардани огоҳсозии тариқи почтаи электронӣ тағйир диҳед.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'viewrelationships' => 'Tanawin ang pagkakaugnayan',
	'viewrelationshiprequests' => 'Tingnan ang mga kahilingan sa pagkakaugnayan',
	'ur-already-submitted' => 'Ipinadala na ang kahilingan mo',
	'ur-error-page-title' => "Ay 'sus!",
	'ur-error-title' => 'Ay naku, nagkamali ka sa pagliko!',
	'ur-error-message-no-user' => 'Hindi namin mabubuo ang kahilingan mo, dahil walang tagagamit na may ganitong pangalan.',
	'ur-main-page' => 'Pangunahing pahina',
	'ur-your-profile' => 'Talaang pangkatangian ng sarili mo',
	'ur-backlink' => '&lt; Magbalik sa talaang pangkatangian ni $1',
	'ur-relationship-count-foes' => 'Si $1 ay mayroong $2 {{PLURAL:$2|katunggali|mga katunggali}}. Nais mo ba magkaroon ng mas marami pang mga katunggali? <a href="$3">Anyayahan sila.</a>',
	'ur-relationship-count-friends' => 'Si $1 ay mayroong $2 {{PLURAL:$2|kaibigan|mga kaibigan}}. Nais mo bang magkaroon ng mas marami pang mga kaibigan? <a href="$3">Anyayahan sila.</a>',
	'ur-add-friends' => '  Nais mo bang magkaroon ng mas marami pang mga kaibigan? <a href="$1">Anyayahan sila</a>',
	'ur-add-friend' => 'Idagdag bilang kaibigan',
	'ur-add-foe' => 'Idagdag bilang katunggali',
	'ur-add-no-user' => 'Walang napiling tagagamit.
Humiling lamang ng mga kaibigan/mga katunggali sa pamamagitan ng tamang kawing.',
	'ur-add-personal-message' => 'Magdagdag ng isang mensaheng pansarili',
	'ur-remove-relationship-friend' => 'Tanggalin bilang kaibigan',
	'ur-remove-relationship-foe' => 'Tanggalin bilang katunggali',
	'ur-give-gift' => 'Magbigay ng isang handog',
	'ur-previous' => 'sinundan',
	'ur-next' => 'susunod',
	'ur-remove-relationship-title-foe' => 'Nais mo bang tanggalin si $1 bilang katunggali mo?',
	'ur-remove-relationship-title-confirm-foe' => 'Tinanggal mo si $1 bilang katunggali mo',
	'ur-remove-relationship-title-friend' => 'Nais mo bang tanggalin si $1 bilang kaibigan mo?',
	'ur-remove-relationship-title-confirm-friend' => 'Tinanggal mo si $1 bilang kaibigan mo',
	'ur-remove-relationship-message-foe' => 'Hiniling mong tanggalin si $1 bilang katunggali mo, pindutin ang "$2" upang tiyakin.',
	'ur-remove-relationship-message-confirm-foe' => 'Matagumpay mong natanggal si $1 bilang katunggali mo.',
	'ur-remove-relationship-message-friend' => 'Hiniling mong tanggalin si $1 bilang kaibigan mo, pindutin ang "$2" upang tiyakin.',
	'ur-remove-relationship-message-confirm-friend' => 'Matagumpay mong natanggal si $1 bilang kaibigan mo.',
	'ur-remove-error-message-no-relationship' => 'Wala kang isang pakikipagugnayan kay $1.',
	'ur-remove-error-message-remove-yourself' => 'Hindi mo matatanggal ang sarili mo.',
	'ur-remove-error-message-pending-foe-request' => 'Mayroon kang isang naghihintay na kahilingang pangkatunggali kay $1.',
	'ur-remove-error-message-pending-friend-request' => 'Mayroon kang isang naghihintay na kahilingang pangpagkakaibigan kay $1.',
	'ur-remove-error-not-loggedin-foe' => 'Kinakailangan mong lumagda muna upang makapagtanggal ng isang katunggali.',
	'ur-remove-error-not-loggedin-friend' => 'Kinakailangan mong lumagda muna upang makapagtanggal ng isang kaibigan.',
	'ur-remove' => 'Tanggalin',
	'ur-cancel' => 'Huwag ituloy',
	'ur-login' => 'Lumagda',
	'ur-add-title-foe' => 'Nais mo bang idagdag si $1 bilang katunggali mo?',
	'ur-add-title-friend' => 'Nais mo bang idagdag si $1 bilang kaibigan mo?',
	'ur-add-message-foe' => 'Idaragdag mo na si $1 bilang katunggali mo.
Magpapadala kami ng pabatid kay $1 upang matiyak ang pagtatampo/hinanakit mo.',
	'ur-add-message-friend' => 'Idaragdag mo na si $1 bilang kaibigan. Magpapadala kami ng pabatid kay $1 upang matiyak ang pagkakaibigan (pagiging magkaibigan) ninyo.',
	'ur-add-button-foe' => 'Idagdag bilang katunggali',
	'ur-add-button-friend' => 'Idagdag bilang kaibigan',
	'ur-add-sent-title-foe' => 'Ipinadala na namin kay $1 ang kahilingan mong pangpagtutunggali!',
	'ur-add-sent-title-friend' => 'Ipinadala na namin kay $1 ang kahilingan mong pangpagkakaibigan!',
	'ur-add-sent-message-foe' => 'Ipinadala na kay $1 ang kahilangan mong pangkatunggali upang matiyak.
Kapag tiniyak na ni $1 ang kahilingan mo, makakatanggap ka ng isang patugaygay/pasunod na e-liham.',
	'ur-add-sent-message-friend' => 'Ipinadala na kay $1 ang kahilangan mong pangpagkakaibigan upang matiyak.
Kapag tiniyak na ni $1 ang kahilingan mo, makakatanggap ka ng isang patugaygay/pasunod na e-liham.',
	'ur-add-error-message-no-user' => 'Hindi umiiral ang tagagamit na sinusubok mong idagdag.',
	'ur-add-error-message-blocked' => 'Pangkasalukuyan kang hinahadlangan at hindi makapagdaragdag ng mga kaibigan o mga katunggali.',
	'ur-add-error-message-yourself' => 'Hindi mo maidaragdag ang iyong sarili bilang isang kaibigan o katunggali.',
	'ur-add-error-message-existing-relationship-foe' => 'Katunggali mo na si $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Kaibigan mo na si $1.',
	'ur-add-error-message-pending-request-title' => 'Magtiyaga!',
	'ur-add-error-message-pending-friend-request' => 'Mayroon kang isang naghihintay na kahilingan ng pakikipagkaibigan kay $1.
Padadalhan ka namin ng pabatid kapat tiniyak na ni $1 ang kahilingan mo.',
	'ur-add-error-message-pending-foe-request' => 'Mayroon kang isang naghihintay na kahilingan ng pagiging katunggali ni $1.
Padadalhan ka namin ng pabatid kapat tiniyak na ni $1 ang kahilingan mo.',
	'ur-add-error-message-not-loggedin-foe' => 'Kinakailangan mong lumagda muna upang makapagdagdag ng isang katunggali',
	'ur-add-error-message-not-loggedin-friend' => 'Kinakailangan mong lumagda muna upang makapagdagdag ng isang kaibigan',
	'ur-requests-title' => 'Mga kahilingan sa pakikipagkaugnayan',
	'ur-requests-message-foe' => 'Nais ni <a href="$1">$2</a> na maing katunggali mo.',
	'ur-requests-message-friend' => 'Nais ni <a href="$1">$2</a> na maging kaibigan mo.',
	'ur-accept' => 'Tanggapin',
	'ur-reject' => 'Tanggihan',
	'ur-no-requests-message' => 'Wala kang mga kahilingang pangpakikipagkaibigan at pangpakikipagkatunggali/
Kung nais mong magkaroon ng mas marami pang mga kaibigan, <a href="$1">anyayahan sila!</a>',
	'ur-requests-added-message-foe' => 'Idinagdag mo si $1 bilang kaibigan mo.',
	'ur-requests-added-message-friend' => 'Idinagdag mo si $1 bilang kaibigan mo.',
	'ur-requests-reject-message-friend' => 'Tinanggihan mo si $1 bilang kaibigan mo.',
	'ur-requests-reject-message-foe' => 'Tinanggihan mo si $1 bilang katunggali mo.',
	'ur-title-foe' => 'Talaan ng mga katunggali ni $1',
	'ur-title-friend' => 'Talaan ng mga kaibigan ni $1',
	'friend_request_subject' => 'Idinagdag ka ni $1 bilang isang kaibigan sa {{SITENAME}}!',
	'friend_request_body' => 'Kumusta ka $1:

Idinagdag ka ni $2 bilang isang kaibigan sa {{SITENAME}}.  Ibig naming matiyak kung talagang magkaibigan kayong dalawa.

Pakipindot ang kawing na ito upang mapatotohanan ang inyong pagiging magkaibigan:
$3

Salamat

---

Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan mo upang huwag gumana/umandar ang mga pagpapabatid na pang-e-liham.',
	'foe_request_subject' => 'Digmaan na! Idinagdag ka na ni $1 bilang isang katunggali sa {{SITENAME}}!',
	'foe_request_body' => 'Kumusta ka $1:

Katatala lamang sa iyo ni $2 bilang isang katunggali sa {{SITENAME}}.  Ibig naming matiyak kung  talagang mahigpit na magkatunggali nga kayong dalawa o nagkakaroon lamang ng isang pagtatalo.

Pakipindot ang kawing na ito upang mapatotohanan ang tagisang pangtampuhan:
$3

Salamat

---

Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan mo upang huwag gumana/umandar ang mga pagpapabatid na pang-e-liham.',
	'friend_accept_subject' => 'Tinanggap na ni $1 ang kahilingan mong maging kaibigan sa {{SITENAME}}!',
	'friend_accept_body' => 'Kumusta ka $1:

Tinanggap ka na ni $2 ang kahilingan mong pangkaibigan sa {{SITENAME}}!  

Tanawin ang pahina ni $2 sa $3

Salamat

---

Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan mo upang huwag gumana/umandar ang mga pagpapabatid na pang-e-liham.',
	'foe_accept_subject' => 'Naganap na! Tinanggap na ni $1 ang kahilingan mong maging katunggali sa {{SITENAME}}!',
	'foe_accept_body' => 'Kumusta ka $1:

Tinanggap ka na ni $2 ang kahilingan mong pangkatunggali sa {{SITENAME}}!  

Tanawin ang pahina ni $2 sa $3

Salamat

---

Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan mo upang huwag gumana/umandar ang mga pagpapabatid na pang-e-liham.',
	'friend_removed_subject' => 'Naku po! Tinanggal ka na ni $1 bilang isang kaibigan sa {{SITENAME}}!',
	'friend_removed_body' => 'Kumusta ka $1:

Tinanggal ka ni $2 bilang isang kaibigan sa {{SITENAME}}!  

Salamat

---

Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan mo upang huwag gumana/umandar ang mga pagpapabatid na pang-e-liham.',
	'foe_removed_subject' => 'Hay salamat! Tinanggal ka na ni $1 bilang isang katunggali sa {{SITENAME}}!',
	'foe_removed_body' => 'Kumusta ka $1:

Tinanggal ka na ni $2 bilang isang katunggali sa {{SITENAME}}!  

Maaaring kayong dalawa ay nagiging magkaibigan na?

Salamat

---

Hoy, nais mo bang matigil ang pagtanggap ng mga e-liham mula sa amin?

Pindutin ang $4
at baguhin ang mga katakdaan mo upang huwag gumana/umandar ang mga pagpapabatid na pang-e-liham.',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'ur-remove' => 'Kaldır',
	'ur-cancel' => 'İptal',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'ur-main-page' => 'Trang Chính',
	'ur-add-friend' => 'Thêm người bạn',
	'ur-add-foe' => 'Thêm kẻ thù',
	'ur-remove' => 'Dời',
	'ur-cancel' => 'Bãi bỏ',
	'ur-login' => 'Đăng nhập',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'ur-add-friends' => '   Vilol-li flenis pluik? <a href="$1">Vüdolös onis</a>',
	'ur-add-friend' => 'Läükön as flen',
	'ur-add-foe' => 'Läükön as neflen',
	'ur-remove-relationship-friend' => 'Moükön as flen',
	'ur-remove-relationship-foe' => 'Moükön as neflen',
	'ur-give-gift' => 'Givön legivoti',
	'ur-previous' => 'büik',
	'ur-next' => 'sököl',
	'ur-remove-relationship-title-foe' => 'Vilol-li moükön gebani: $1 as neflen olik?',
	'ur-remove-relationship-title-confirm-foe' => 'Emoükol gebani: $1 as neflen olik',
	'ur-remove-relationship-title-friend' => 'Vilol-li moükön gebani: $1 as flen olik?',
	'ur-remove-relationship-title-confirm-friend' => 'Emoükol gebani: $1 as flen olik',
	'ur-remove-relationship-message-confirm-friend' => 'Eplöpol ad möukön gebani $1: as flen olik.',
	'ur-remove-error-message-remove-yourself' => 'No kanol moükön oli it.',
	'ur-remove-error-not-loggedin-foe' => 'Mutol nunädön oli ad moükön nefleni.',
	'ur-remove-error-not-loggedin-friend' => 'Mutol nunädön oli ad moükön fleni.',
	'ur-remove' => 'Moükön',
	'ur-add-title-foe' => 'Vilol-li läükön gebani: $1 as neflen olik?',
	'ur-add-title-friend' => 'Vilol-li läükön gebani: $1 as flen olik?',
	'ur-add-button-foe' => 'Läükön as neflen',
	'ur-add-button-friend' => 'Läükön as flen',
	'ur-add-error-message-no-user' => 'Geban, keli vilol läükön, no dabinon.',
	'ur-add-error-message-blocked' => 'No dalol läükön flenis u neflenis bi peblokol.',
	'ur-add-error-message-yourself' => 'No kanol läükön oli it as flen ud as neflen.',
	'ur-add-error-message-not-loggedin-foe' => 'Mutol nunädön oli ad läükön nefleni',
	'ur-add-error-message-not-loggedin-friend' => 'Mutol nunädön oli ad läükön fleni',
	'ur-requests-added-message-foe' => 'Eläükol gebani: $1 as neflen olik.',
	'ur-requests-added-message-friend' => 'Eläükol gebani: $1 as flen olik.',
	'friend_request_subject' => 'Geban: $1 eläükon oli as flen in {{SITENAME}}!',
	'foe_request_subject' => 'Krigö! Geban: $1 eläükon oli as neflen in {{SITENAME}}!',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'ur-cancel' => '取消',
	'ur-login' => '登录',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'ur-cancel' => '取消',
	'ur-login' => '登入',
);

