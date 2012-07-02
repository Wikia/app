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
	'ur-relationship-count-foes' => '$1 has $2 {{PLURAL:$2|foe|foes}}.
Want more foes?
<a href="$3">Invite them.</a>',
	'ur-relationship-count-friends' => '$1 has $2 {{PLURAL:$2|friend|friends}}.
Want more friends?
<a href="$3">Invite them.</a>',
	'ur-add-friends' => ' Want more friends?
<a href="$1">Invite them</a>',
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
	'friend_request_body' => 'Hi $1.

$2 has added you as a friend on {{SITENAME}}. We want to make sure that you two are actually friends.

Please click this link to confirm your friendship:
$3

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'foe_request_subject' => 'It\'s war! $1 has added you to as a foe on {{SITENAME}}!',
	'foe_request_body' => 'Hi $1.

$2 just listed you as a foe on {{SITENAME}}. We want to make sure that you two are actually mortal enemies or at least having an argument.

Please click this link to confirm the grudge match.

$3

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',

	'friend_accept_subject' => '$1 has accepted your friend request on {{SITENAME}}!',
	'friend_accept_body' => 'Hi $1.

$2 has accepted your friend request on {{SITENAME}}!

Check out $2\'s page at $3

Thanks,

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'foe_accept_subject' => 'It\'s on! $1 has accepted your foe request on {{SITENAME}}!',
	'foe_accept_body' => 'Hi $1.

$2 has accepted your foe request on {{SITENAME}}!

Check out $2\'s page at $3

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'friend_removed_subject' => 'Oh no! $1 has removed you as a friend on {{SITENAME}}!',
	'friend_removed_body' => 'Hi $1.

$2 has removed you as a friend on {{SITENAME}}!

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
	'foe_removed_subject' => 'Woohoo! $1 has removed you as a foe on {{SITENAME}}!',
	'foe_removed_body' => 'Hi $1.

	$2 has removed you as a foe on {{SITENAME}}!

Perhaps you two are on your way to becoming friends?

Thanks

---

Hey, want to stop getting e-mails from us?

Click $4
and change your settings to disable e-mail notifications.',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Siebrand
 */
$messages['qqq'] = array(
	'ur-main-page' => '{{Identical|Main page}}',
	'ur-add-friend' => '{{Identical|Add as friend}}',
	'ur-add-foe' => '{{Identical|Add as foe}}',
	'ur-previous' => '{{Identical|Prev}}',
	'ur-next' => '{{Identical|Next}}',
	'ur-remove' => '{{Identical|Remove}}',
	'ur-cancel' => '{{Identical|Cancel}}',
	'ur-login' => '{{Identical|Log in}}',
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
	'ur-add-friend' => 'As vriend byvoeg',
	'ur-add-foe' => 'Voeg by as teenstander',
	'ur-previous' => 'vorige',
	'ur-next' => 'volgende',
	'ur-remove' => 'Skrap',
	'ur-cancel' => 'Kanselleer',
	'ur-login' => 'Inteken',
	'ur-accept' => 'Aanvaar',
	'ur-reject' => 'Verwerp',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'ur-add-button-friend' => 'Shto si mik',
	'ur-add-sent-title-foe' => 'Ne kemi dërguar kërkesën tuaj armik tek $1!',
	'ur-add-sent-title-friend' => 'Ne kemi dërguar kërkesën tuaj mik tek $1!',
	'ur-add-sent-message-foe' => 'armik Kërkesa juaj u dërgua tek $1 për konfirmim. Në qoftë se $1 e konfirmon kërkesën tuaj, ju do të merrni një vazhdimësi e-mail',
	'ur-add-sent-message-friend' => 'Miku Kërkesa juaj u dërgua tek $1 për konfirmim. Në qoftë se $1  e konfirmon kërkesën tuaj, ju do të merrni një vazhdimësi e-mail',
	'ur-add-error-message-no-user' => 'Perdoruesi jeni duke u përpjekur për të shtuar nuk ekziston.',
	'ur-add-error-message-blocked' => 'Ju jeni bllokuar për momentin dhe nuk mund të shtoni miqtë apo armiqtë.',
	'ur-add-error-message-yourself' => 'Ju nuk mund të shtoni veten si një mik apo armik.',
	'ur-add-error-message-existing-relationship-foe' => 'Ju jeni tashmë kundërshtarët me $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Ju jeni tashmë miq me $1.',
	'ur-add-error-message-pending-request-title' => 'Durimi!',
	'ur-add-error-message-pending-friend-request' => "Ju keni një mik kërkesën në pritje me $1. Ne do t'ju njoftojë kur $1  konfirmon kërkesën tuaj.",
	'ur-add-error-message-pending-foe-request' => "Ju keni një armik kërkesën në pritje me $1. Ne do t'ju njoftojë kur $1  konfirmon kërkesën tuaj.",
	'ur-add-error-message-not-loggedin-foe' => 'Ju duhet të keni hyrë brenda për të shtuar një armik',
	'ur-add-error-message-not-loggedin-friend' => 'Ju duhet të keni hyrë brenda për të shtuar një mik',
	'ur-requests-title' => 'kërkesat Lidhja',
	'ur-requests-message-foe' => '<a href="$1">$2</a> do të jetë armik tuaj.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> do të jetë miku juaj.',
	'ur-accept' => 'Pranoj',
	'ur-reject' => 'Refuzoj',
	'ur-no-requests-message' => 'Ju nuk keni mik apo armik kërkesa. Nëse ju doni më shumë miq, <a href="$1">të ftuar ata!</a>',
	'ur-requests-added-message-foe' => 'Ju keni shtuar $1 si armik tuaj.',
	'ur-requests-added-message-friend' => 'Ju keni shtuar $1 si miku juaj.',
	'ur-requests-reject-message-friend' => 'Ju keni hedhur poshtë $1 si miku juaj.',
	'ur-requests-reject-message-foe' => 'Ju keni hedhur poshtë $1 si armik tuaj.',
	'ur-title-foe' => 'Lista e $1 është armik',
	'ur-title-friend' => 'listë e $1 mik',
	'friend_request_subject' => '$1 ka shtuar ju si një mik në {{SITENAME}}!',
	'friend_request_body' => 'Hi $1. $2 ka shtuar ju si një mik në {{SITENAME}}. Ne duam të sigurohemi që ju të dy të vërtetë janë miq. Ju lutemi të klikoni këtë link për të konfirmuar miqësinë tuaj: $3 Thanks --- Hej, dua të ndaluar marrjen e e-mail nga ne? Kliko $4 dhe për të ndryshuar parametrat tuaj të çaktivizoni e-mail njoftime .',
	'foe_request_subject' => 'Është e luftës! $1 ka shtuar ju si një armik në {{SITENAME}}!',
	'foe_request_body' => 'Hi $1. $2 shënuar vetëm ju si një armik në {{SITENAME}}. Ne duam të sigurohemi që ju të dy të vërtetë janë armiq, ose së paku njeri që ka një argument. Ju lutemi të klikoni këtë link për të konfirmuar ndeshjen e armiqësi.

$3

FLM

 --- Hej, dua të ndaluar marrjen e e-mail nga ne? Kliko $4 dhe ndryshim parametrat tuaj të çaktivizoni e-mail njoftime.',
	'friend_accept_subject' => '$1 ka pranuar kërkesën tuaj mik në {{SITENAME}}!',
	'friend_accept_body' => 'Tung $1.

$2 e ka pranuar mik kërkesën tuaj në {{SITENAME}}! Check out 2 e faqe në $3 Thanks $, --- Hej, dua të ndaluar marrjen e e-mail nga ne? Kliko $4 dhe ndryshoni parametrat tuaj të çaktivizoni e e-mail njoftime.',
	'foe_accept_subject' => 'Është më! $1 ka pranuar kërkesën tuaj armik në {{SITENAME}}!',
	'foe_accept_body' => 'Hi $1. $2 e ka pranuar armik kërkesën tuaj në {{SITENAME}}! Shiko $2 për faqen në $3

Thanks --- Hej, dua të ndaluar marrjen e e-mail nga ne? Kliko $4 dhe ndryshoni parametrat tuaj të çaktivizoni e- njoftime mail.',
	'friend_removed_subject' => 'Oh jo! $1 ka hequr ju si një mik në {{SITENAME}}!',
	'friend_removed_body' => 'Hi $1. $2 ka hequr ju si një mik në {{SITENAME}}! Faleminderit --- Hej, dua të ndaluar marrjen e e-mail nga ne? Kliko $4 dhe ndryshoni parametrat tuaj të çaktivizoni e-mail njoftime.',
	'foe_removed_subject' => 'Woohoo! $1 ka hequr ju si një armik në {{SITENAME}}!',
	'foe_removed_body' => "Hi $1. $2 ka hequr ju si një armik në {{SITENAME}}! Ndoshta ju dy jeni në rrugën tuaj për t'u bërë miq? Thanks --- Hej, dua të ndaluar marrjen e e-mail nga ne? Kliko $4 dhe ndryshoni parametrat tuaj të çaktivizoni e-mail njoftime.",
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'ur-main-page' => 'ዋና ገጽ',
	'ur-add-friend' => 'እንደ ወዳጅ ለመጨምር',
	'ur-add-foe' => 'እንደ ጠላት ለመጨምር',
	'ur-next' => 'ቀጥሎ',
	'ur-add-button-friend' => 'እንደ ወዳጅ ለመጨምር',
	'ur-add-error-message-pending-request-title' => 'ትዕግሥት!',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'ur-cancel' => 'Cancelar',
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
	'ur-relationship-count-foes' => '{{PLURAL:$2|ليس ل$1 أي أعداء|ل$1 عدو واحد|ل$1 عدوان|ل$1 $2 أعداء|ل$1 $2 عدوًا|ل$1 $2 عدو}}.
أتريد المزيد من الأعداء؟
<a href="$3">ادعهم.</a>',
	'ur-relationship-count-friends' => '{{PLURAL:$2|ليس ل$1 أي أصدقاء|ل$1 صديق واحد|ل$1 صديقان|ل$1 $2 أصدقاء|ل$1 $2 صديقًا|ل$1 $2 عدو}}.
أتريد المزيد من الأصدقاء؟
<a href="$3">ادعهم.</a>',
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
	'ur-remove-error-message-pending-foe-request' => 'لديك طلب عداوة قيد الانتظار مع $1.',
	'ur-remove-error-message-pending-friend-request' => 'لديك طلب صداقة قيد الانتظار مع $1.',
	'ur-remove-error-not-loggedin-foe' => 'يجب أن تكون مسجل الدخول لإزالة عدو.',
	'ur-remove-error-not-loggedin-friend' => 'يجب أن تكون مسجل الدخول لإزالة صديق.',
	'ur-remove' => 'أزل',
	'ur-cancel' => 'ألغِ',
	'ur-login' => 'لُج',
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
	'ur-add-error-message-no-user' => 'المستخدم الذي تحاول أن تضيفه غير موجود.',
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

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'ur-error-page-title' => 'ܐܘܝ!',
	'ur-main-page' => 'ܦܐܬܐ ܪܫܝܬܐ',
	'ur-your-profile' => 'ܦܘܓܪܦܐ ܕܝܠܟ',
	'ur-add-friend' => 'ܐܘܣܦ ܐܝܟ ܚܒܪܐ',
	'ur-add-foe' => 'ܐܘܣܦ ܐܝܟ ܒܥܠܕܒܒܐ',
	'ur-remove-relationship-friend' => 'ܠܚܝ ܐܝܟ ܚܒܪܐ',
	'ur-remove-relationship-foe' => 'ܠܚܝ ܐܝܟ ܒܥܠܕܒܒܐ',
	'ur-remove-relationship-title-confirm-foe' => 'ܠܚܐ ܐܢܬ  $1 ܐܝܟ ܒܥܠܕܒܒܟ',
	'ur-remove-relationship-title-confirm-friend' => 'ܠܚܐ ܐܢܬ  $1 ܐܝܟ ܚܒܪܟ',
	'ur-remove-error-message-remove-yourself' => 'ܠܐ ܡܨܐ ܐܢܬ ܠܠܚܝܐ ܕܢܦܫܟ',
	'ur-remove' => 'ܠܚܝ',
	'ur-cancel' => 'ܒܛܘܠ',
	'ur-login' => 'ܥܘܠ',
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
	'ur-error-message-no-user' => 'لا يمكننا استكمال طلبك، علشان مافيش يوزر بالاسم ده.',
	'ur-main-page' => 'الصفحة الرئيسية',
	'ur-your-profile' => 'ملفك',
	'ur-backlink' => '&lt; رجوع إلى ملف $1',
	'ur-relationship-count-foes' => '$1 لديه $2 {{PLURAL:$2|عدو|عدو}}. تريد المزيد من الأعداء؟ <a href="$3">ادعهم.</a>',
	'ur-relationship-count-friends' => '$1 لديه $2 {{PLURAL:$2|صديق|صديق}}. تريد المزيد من الأصدقاء؟ <a href="$3">ادعهم.</a>',
	'ur-add-friends' => '  تريد المزيد من الأصدقاء؟ <a href="$1">أدعهم</a>',
	'ur-add-friend' => 'أضف كصديق',
	'ur-add-foe' => 'أضف كعدو',
	'ur-add-no-user' => 'و لا يوزر تم اختياره.
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
وغير إعداداتك لتعطيل إخطارات البريد الإلكترونى.',
	'foe_request_subject' => 'إنها الحرب! $1 أضافك كعدو فى {{SITENAME}}!',
	'foe_request_body' => 'مرحبا $1:

$2 أضافك حالا كعدو فى {{SITENAME}}.  نريد التحقق من أنكما فعلا عدوان أو على الأقل بينكما خلاف.

من فضلك اضغط هذه الوصلة لتأكيد التطابق.

$3

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكترونى.',
	'friend_accept_subject' => '$1 قبل طلب صداقتك فى {{SITENAME}}!',
	'friend_accept_body' => 'مرحبا $1:

$2 قبل طلب صداقتك فى {{SITENAME}}!

تحقق من صفحة $2 فى $3

شكرا،

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكترونى.',
	'foe_accept_subject' => 'إنه يعمل! $1 قبل طلب عداوتك فى {{SITENAME}}!',
	'foe_accept_body' => 'مرحبا $1:

$2 قبل طلب عداوتك فى {{SITENAME}}!

تحقق من صفحة $2 فى $3

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإكترونى.',
	'friend_removed_subject' => 'كلا! أزالك $1 كصديق على {{SITENAME}}!',
	'friend_removed_body' => 'مرحبا $1:

$2 أزالك كصديق فى {{SITENAME}}!

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإلكترونى.',
	'foe_removed_subject' => 'هاه! $1 أزالك كعدو فى {{SITENAME}}!',
	'foe_removed_body' => 'مرحبا $1:

$2 أزالك كعدو فى {{SITENAME}}!

ربما أنتما الاثنان على الطريق لتكونا صديقين؟

شكرا

---

هل تريد التوقف عن تلقى رسائل بريد إلكترونى مننا؟

اضغط $4
وغير إعداداتك لتعطيل إخطارات البريد الإكترونى.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'ur-next' => 'növbəti',
	'ur-cancel' => 'İmtina',
	'ur-login' => 'Loqin',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'viewrelationships' => 'Паказаць адносіны',
	'viewrelationshiprequests' => 'Паказаць запыты аб сяброўстве',
	'ur-already-submitted' => 'Ваш запыт быў дасланы',
	'ur-error-page-title' => 'Ой!',
	'ur-error-title' => 'Ой, памылка!',
	'ur-error-message-no-user' => 'Мы ня можам выканаць Ваш запыт, таму што ўдзельнік з такім імем не існуе.',
	'ur-main-page' => 'Галоўная старонка',
	'ur-your-profile' => 'Ваш профіль',
	'ur-backlink' => '&lt; Вярнуцца да профілю $1',
	'ur-relationship-count-foes' => '$1 мае $2 {{PLURAL:$2|ворага|ворагі|ворагаў}}. Калі жадаеце мець болей ворагаў, <a href="$3">запрасіце іх.</a>',
	'ur-relationship-count-friends' => '$1 мае $2 {{PLURAL:$2|сябра|сябры|сяброў}}. Калі жадаеце мець болей сяброў, <a href="$3">запрасіце іх.</a>',
	'ur-add-friends' => '  Жадаеце мець болей сяброў? <a href="$1">Запрасіце іх</a>',
	'ur-add-friend' => 'Дадаць як сябра',
	'ur-add-foe' => 'Дадаць як ворага',
	'ur-add-no-user' => 'Удзельнік ня выбраны.
Калі ласка, запрасіце сяброў альбо ворагаў праз слушную спасылку.',
	'ur-add-personal-message' => 'Дадаць асабістае паведамленьне',
	'ur-remove-relationship-friend' => 'Выдаліць зь сяброў',
	'ur-remove-relationship-foe' => 'Выдаліць з ворагаў',
	'ur-give-gift' => 'Зрабіць падарунак',
	'ur-previous' => 'папярэдні',
	'ur-next' => 'наступны',
	'ur-remove-relationship-title-foe' => 'Вы жадаеце выдаліць $1 са сьпісу ворагаў?',
	'ur-remove-relationship-title-confirm-foe' => 'Вы выдалілі $1 са сьпісу ворагаў',
	'ur-remove-relationship-title-friend' => 'Вы жадаеце выдаліць $1 са сьпісу сяброў?',
	'ur-remove-relationship-title-confirm-friend' => 'Вы выдалілі $1 са сьпісу сяброў',
	'ur-remove-relationship-message-foe' => 'Вы падалі запыт на выдаленьне $1 са сьпісу ворагаў, націсьніце «$2», каб пацьвердзіць.',
	'ur-remove-relationship-message-confirm-foe' => 'Вы пасьпяхова выдалілі $1 са сьпісу ворагаў.',
	'ur-remove-relationship-message-friend' => 'Вы падалі запыт на выдаленьне $1 са сьпісу сяброў, націсьніце «$2», каб пацьвердзіць.',
	'ur-remove-relationship-message-confirm-friend' => 'Вы пасьпяхова выдалілі $1 са сьпісу сяброў.',
	'ur-remove-error-message-no-relationship' => 'Вы ня маеце ніякіх адносінаў з $1.',
	'ur-remove-error-message-remove-yourself' => 'Вы ня можаце выдаліць самі сябе.',
	'ur-remove-error-message-pending-foe-request' => 'У Вас ёсьць запыт на даданьне $1 у сьпіс ворагаў, які чакае рашэньня.',
	'ur-remove-error-message-pending-friend-request' => 'У Вас ёсьць запыт на даданьне $1 у сьпіс сяброў, які чакае рашэньня.',
	'ur-remove-error-not-loggedin-foe' => 'Вам трэба ўвайсьці ў сыстэму, каб выдаляць удзельнікаў са сьпісу ворагаў.',
	'ur-remove-error-not-loggedin-friend' => 'Вам трэба ўвайсьці ў сыстэму, каб выдаляць удзельнікаў са сьпісу сяброў.',
	'ur-remove' => 'Выдаліць',
	'ur-cancel' => 'Скасаваць',
	'ur-login' => 'Увайсьці ў сыстэму',
	'ur-add-title-foe' => 'Вы жадаеце дадаць $1 у сьпіс ворагаў?',
	'ur-add-title-friend' => 'Вы жадаеце дадаць $1 у сьпіс сяброў?',
	'ur-add-message-foe' => 'Зараз Вы дададзіце $1 у сьпіс ворагаў.
Мы паведамім $1, каб пацьвердзіць Вашую варожасьць.',
	'ur-add-message-friend' => 'Зараз Вы дададзіце $1 у сьпіс сяброў.
Мы паведамім $1, каб пацьвердзіць Вашае сяброўства.',
	'ur-add-button-foe' => 'Дадаць у ворагі',
	'ur-add-button-friend' => 'Дадаць у сябры',
	'ur-add-sent-title-foe' => 'Вы даслалі запыт аб варожасьці да $1!',
	'ur-add-sent-title-friend' => 'Вы даслалі запыт аб сяброўстве да $1!',
	'ur-add-sent-message-foe' => 'Ваш запыт аб варожасьці быў дасланы $1 для пацьверджаньня.
Калі $1 пацьвердзіць Ваш запыт, Вы атрымаеце ліст па электроннай пошце',
	'ur-add-sent-message-friend' => 'Ваш запыт аб сяброўстве быў дасланы $1 для пацьверджаньня.
Калі $1 пацьвердзіць Ваш запыт, Вы атрымаеце ліст па электроннай пошце',
	'ur-add-error-message-no-user' => 'Удзельніка, якога Вы спрабуеце дадаць, не існуе.',
	'ur-add-error-message-blocked' => 'Вы заблякаваныя і ня можаце дадаваць новых сяброў і ворагаў.',
	'ur-add-error-message-yourself' => 'Вы ня можаце дадаць самі сябе.',
	'ur-add-error-message-existing-relationship-foe' => '$1 ужо зьяўляецца Вашым ворагам.',
	'ur-add-error-message-existing-relationship-friend' => '$1 ужо зьяўляецца Вашым сябрам.',
	'ur-add-error-message-pending-request-title' => 'Цярплівасьць!',
	'ur-add-error-message-pending-friend-request' => 'Ваш запыт аб сяброўстве з $1 чакае пацьверджаньня.
Мы паведамім Вам, калі $1 пацьвердзіць Ваш запыт.',
	'ur-add-error-message-pending-foe-request' => 'Ваш запыт аб варожасьці з $1 чакае пацьверджаньня.
Мы паведамім Вам, калі $1 пацьвердзіць Ваш запыт.',
	'ur-add-error-message-not-loggedin-foe' => 'Вам неабходна ўвайсьці ў сыстэму, каб дадаць ворага',
	'ur-add-error-message-not-loggedin-friend' => 'Вам неабходна ўвайсьці ў сыстэму, каб дадаць сябра',
	'ur-requests-title' => 'Запыты аб узаемаадносінах',
	'ur-requests-message-foe' => '<a href=«$1»>$2</a> жадае быць Вашым ворагам.',
	'ur-requests-message-friend' => '<a href=«$1»>$2</a> жадае быць Вашым сябрам.',
	'ur-accept' => 'Згадзіцца',
	'ur-reject' => 'Адмовіць',
	'ur-no-requests-message' => 'Ня маеце запытаў на сяброўства альбо варожасьць.
Калі Вы жадаеце мець болей сяброў, <a href="$1">запрасіце іх!</a>',
	'ur-requests-added-message-foe' => 'Вы дадалі $1 як ворага.',
	'ur-requests-added-message-friend' => 'Вы дадалі $1 як сябра.',
	'ur-requests-reject-message-friend' => 'Вы адмовілі $1 у сяброўстве.',
	'ur-requests-reject-message-foe' => 'Вы адмовілі $1 у варожасьці.',
	'ur-title-foe' => 'Сьпіс ворагаў $1',
	'ur-title-friend' => 'Сьпіс сяброў $1',
	'friend_request_subject' => '$1 дадаў Вас да сваіх сяброў ў {{GRAMMAR:месны|{{SITENAME}}}}',
	'friend_request_body' => 'Прывітаньне, $1!

$2 дадаў Вас да сваіх сяброў у {{GRAMMAR:месны|{{SITENAME}}}}. Мы жадалі б упэўніцца, што Вы сапраўды сябры.

Калі ласка, перайдзіце па гэтай спасылцы, каб пацьвердзіць Вашае сяброўства:
$3

Дзякуй

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4
і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
	'foe_request_subject' => 'Гэта вайна! $1 дадаў Вас да ворагаў у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'foe_request_body' => 'Прывітаньне, $1!

$2 дадаў Вас да сваіх ворагаў у {{GRAMMAR:месны|{{SITENAME}}}}. Мы жадалі б упэўніцца, што Вы сапраўды сьмяротныя ворагі альбо спрачаецеся.

Калі ласка, перайдзіце па гэтай спасылцы, каб пацьвердзіць узаемную варожасьць:
$3

Дзякуй

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4
і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
	'friend_accept_subject' => '$1 пацьвердзіў Ваш запыт аб сяброўстве ў {{GRAMMAR:месны|{{SITENAME}}}}!',
	'friend_accept_body' => 'Прывітаньне, $1!

$2 прыняў Ваш запыт аб сяброўстве ў {{GRAMMAR:месны|{{SITENAME}}}}!

Наведайце старонку $2 на $3

Дзякуй

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4 і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
	'foe_accept_subject' => 'Гэта праўда! $1 пацьвердзіў узаемную варожасьць у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'foe_accept_body' => 'Прывітаньне, $1!

$2 пацьвердзіў Вашу варожасьць у {{GRAMMAR:месны|{{SITENAME}}}}!

Наведайце старонку $2 на $3

Дзякуй

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4 і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
	'friend_removed_subject' => 'О не! $1 выдаліў Вас са сьпісу сяброў у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'friend_removed_body' => 'Прывітаньне, $1!

$2 выдаліў Вас са сьпісу сяброў у {{GRAMMAR:месны|{{SITENAME}}}}!

Дзякуй

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4 і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
	'foe_removed_subject' => 'Выдатна! $1 выдаліў Вас са сьпісу ворагаў у {{GRAMMAR:месны|{{SITENAME}}}}!',
	'foe_removed_body' => 'Прывітаньне, $1!

$2 выдаліў Вас са сьпісу ворагаў у {{GRAMMAR:месны|{{SITENAME}}}}!

Верагодна, цяпер Вы можаце стаць сябрамі?

Дзякуй

---

Вы болей не жадаеце атрымліваць лісты па электроннай пошце ад нас?

Націсьніце $4 і зьмяніце Вашыя налады, каб адключыць адпраўку Вам паведамленьняў па электроннай пошце.',
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
	'ur-remove-error-message-pending-foe-request' => 'Имате чакаща заявка за неприятелство с $1.',
	'ur-remove-error-message-pending-friend-request' => 'Имате чакаща заявка за приятелство с $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Вече сте неприятели с $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Вече сте приятели с $1.',
	'ur-add-error-message-pending-friend-request' => 'Имате изчакваща заявка за приятелство с $1.
Ще ви оповестим когато $1 потвърди заявката.',
	'ur-add-error-message-pending-foe-request' => 'Имате изчакваща заявка за неприятелство с $1.
Ще ви оповестим когато $1 потвърди заявката.',
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

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'viewrelationships' => 'সম্পর্ক দেখাও',
	'viewrelationshiprequests' => 'সম্পর্কের অনুরোধ দেখাও',
	'ur-main-page' => 'প্রধান পাতা',
	'ur-your-profile' => 'আপনার বৃত্তান্ত',
	'ur-add-friend' => 'বন্ধু হিসেবে যোগ করুন',
	'ur-add-foe' => 'শত্রু হিসেবে যোগ করুন',
	'ur-remove-relationship-friend' => 'বন্ধুকে ত্যাগ করুন',
	'ur-remove-relationship-foe' => 'শত্রুকে ত্যাগ করুন',
	'ur-give-gift' => 'উপহার দিন',
	'ur-previous' => 'পূর্ববর্তী',
	'ur-next' => 'পরবর্তী',
	'ur-remove' => 'অপসারণ',
	'ur-cancel' => 'বাতিল',
	'ur-login' => 'প্রবেশ',
	'ur-add-button-foe' => 'শত্রু হিসেবে যোগ করুন',
	'ur-add-button-friend' => 'বন্ধু হিসেবে যোগ করুন',
	'ur-accept' => 'গ্রহণ',
	'ur-reject' => 'প্রত্যাখান',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 */
$messages['br'] = array(
	'viewrelationships' => 'Gwelet an darempred',
	'viewrelationshiprequests' => 'Gwelet ar goulennoù daremprediñ',
	'ur-already-submitted' => 'Kaset eo bet ho koulenn',
	'ur-error-page-title' => 'Hopala !',
	'ur-error-title' => "Hopala, kemeret hoc'h eus un hent fall !",
	'ur-error-message-no-user' => "Ne c'hallomp ket respont d'ho koulenn rak n'eus implijer ebet en anv-mañ.",
	'ur-main-page' => 'Pajenn degemer',
	'ur-your-profile' => 'Ho profil',
	'ur-backlink' => '&lt; Distreiñ da brofil $1',
	'ur-relationship-count-foes' => '$1 en deus $2 {{PLURAL:$2|enebour|enebour}}.
C\'hoant hoc\'h eus da gaout muioc\'h a enebourien ?
<a href="$3">Pedit anezho.</a>',
	'ur-relationship-count-friends' => '$1 en deus $2 {{PLURAL:$2|mignon|mignon}}.
C\'hoant hoc\'h eus da gaout muioc\'h a vignoned ?
<a href="$3">Pedit anezho.</a>',
	'ur-add-friends' => 'Muioc\'h a vignoned ho po ?
<a href="$1">Pedit anezho</a>',
	'ur-add-friend' => 'Ouzhpennañ evel mignon',
	'ur-add-foe' => 'Ouzhpennañ evel enebour',
	'ur-add-no-user' => "N'eus implijer diuzet ebet.
Goulennit mignoned pe enebourien dre al liamm reizh, mar plij.",
	'ur-add-personal-message' => 'Ouzhpennañ ur gemennadenn bersonel',
	'ur-remove-relationship-friend' => 'Lemel evel mignon',
	'ur-remove-relationship-foe' => 'Lemel evel enebour',
	'ur-give-gift' => 'Reiñ ur prof',
	'ur-previous' => 'kent',
	'ur-next' => 'da-heul',
	'ur-remove-relationship-title-foe' => "Ha c'hoant hoc'h eus da lemel $1 eus hoc'h enebourien ?",
	'ur-remove-relationship-title-confirm-foe' => "Lamet hoc'h eus $1 eus hoc'h enebourien",
	'ur-remove-relationship-title-friend' => "Ha c'hoant hoc'h eus da lemel $1 eus ho mignoned ?",
	'ur-remove-relationship-title-confirm-friend' => "Lamet hoc'h eus $1 eus ho mignoned",
	'ur-remove-relationship-message-foe' => "Goulennet hoc'h eus lemel $1 eus hoc'h enebourien, pouezit war « $2 » evit kadarnaat.",
	'ur-remove-relationship-message-confirm-foe' => "Lamet hoc'h eus $1 eus hoc'h enebourien.",
	'ur-remove-relationship-message-friend' => "Goulennet hoc'h eus lemel $1 eus ho mignoned, pouezit war « $2 » evit kadarnaat.",
	'ur-remove-relationship-message-confirm-friend' => "Lamet hoc'h eus $1 eus ho mignoned.",
	'ur-remove-error-message-no-relationship' => "N'hoc'h eus darempred ebet gant $1.",
	'ur-remove-error-message-remove-yourself' => "Ne c'hallit ket ho lemel hoc'h-unan.",
	'ur-remove-error-message-pending-foe-request' => "Bez' hoc'h eus ur goulenn enebouriezh war c'hortoz gant $1.",
	'ur-remove-error-message-pending-friend-request' => "Bez hoc'h eus ur goulenn mignoniezh war c'hortoz gant $1.",
	'ur-remove-error-not-loggedin-foe' => "Ret eo deoc'h bezañ kevreet evit lemel un enebour.",
	'ur-remove-error-not-loggedin-friend' => "Ret eo deoc'h bezañ kevreet evit lemel ur mignon.",
	'ur-remove' => 'Lemel',
	'ur-cancel' => 'Nullañ',
	'ur-login' => 'Kevreañ',
	'ur-add-title-foe' => "Ha c'hoant hoc'h eus da ouzhpennañ $1 d'hoc'h enebourien ?",
	'ur-add-title-friend' => "Ha c'hoant hoc'h eus da ouzhpennañ $1 d'ho mignoned ?",
	'ur-add-message-foe' => "Emaoc'h war-nes ouzhpennañ $1 d'hoc'h enebourien.
Kemenn a raimp $1 evit kadarnaat ho troukrañs.",
	'ur-add-message-friend' => "Emaoc'h war-nes ouzhpennañ $1 d'ho mignoned.
Kemenn a raimp $1 evit kadarnaat ho mignoniezh.",
	'ur-add-button-foe' => 'Ouzhpennañ evel enebour',
	'ur-add-button-friend' => 'Ouzhpennañ evel mignon',
	'ur-add-sent-title-foe' => 'Kaset hon eus ho koulenn enebouriezh da $1 !',
	'ur-add-sent-title-friend' => 'Kaset hon eus ho koulenn mignoniezh da $1 !',
	'ur-add-sent-message-foe' => 'Kaset eo bet ho koulenn enebouriezh da $1 evit bezañ kadarnaet.
Ma kadarna $1 ho koulenn e resevot ur postel heuliañ',
	'ur-add-sent-message-friend' => 'Kaset eo bet ho koulenn mignoniezh da $1 evit bezañ kadarnaet.
Ma kadarna $1 ho koulenn e resevot ur postel heuliañ',
	'ur-add-error-message-no-user' => "N'eus ket eus an implijer a glaskit ouzhpennañ.",
	'ur-add-error-message-blocked' => "Stanket oc'h evit bremañ ha ne c'hallit ket ouzhpennañ mignoned pe enebourien.",
	'ur-add-error-message-yourself' => "Ne c'hallit ket hoc'h ouzhpennañ hoc'h-unan evel mignon pe enebour.",
	'ur-add-error-message-existing-relationship-foe' => "Enebour oc'h da $1 dija.",
	'ur-add-error-message-existing-relationship-friend' => "Mignon oc'h gant $1 dija.",
	'ur-add-error-message-pending-request-title' => 'Ho pezet pasianted !',
	'ur-add-error-message-pending-friend-request' => "Bez' ho c'h eus ur goulenn mignoniezh war c'hortoz gant $1.
Ho kemenn a raimp pa vo kadarnaet ho koulenn gant $1.",
	'ur-add-error-message-pending-foe-request' => "Bez' ho c'h eus ur goulenn enebouriezh war c'hortoz gant $1.
Ho kemenn a raimp pa vo kadarnaet ho koulenn gant $1.",
	'ur-add-error-message-not-loggedin-foe' => "Ret eo deoc'h bezañ kevreet evit ouzhpennañ un enebour",
	'ur-add-error-message-not-loggedin-friend' => "Ret eo deoc'h bezañ kevreet evit ouzhpennañ ur mignon",
	'ur-requests-title' => 'Goulennoù daremprediñ',
	'ur-requests-message-foe' => '<a href="$1">$2</a> a fell dezhañ bezañ hoc\'h enebour.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> a fell dezhañ bezañ ho mignon.',
	'ur-accept' => 'Asantiñ',
	'ur-reject' => 'Disteurel',
	'ur-no-requests-message' => "N'hoc'h eus ket goulennoù mignoniezh pe enebouriezh.
Ma fell deoc'h kaout muioc'h a vignoned, <a href=\"\$1\">pedit anezho !</a>",
	'ur-requests-added-message-foe' => "Ouzhpennet hoc'h eus $1 evel enebour.",
	'ur-requests-added-message-friend' => "Ouzhpennet hoc'h eus $1 evel mignon.",
	'ur-requests-reject-message-friend' => "Distaolet hoc'h eus $1 evel mignon.",
	'ur-requests-reject-message-foe' => "Distaolet hoc'h eus $1 evel enebour.",
	'ur-title-foe' => 'Roll enebourien $1',
	'ur-title-friend' => 'Roll mignoned $1',
	'friend_request_subject' => "$1 en deus hoc'h ouzhpennet evel mignon war {{SITENAME}} !",
	'friend_request_body' => "Salud deoc'h, $1 :

$2 en deus ho lakaet da vignon war {{SITENAME}}. C'hoant hon eus da vezañ sur ez oc'h mignoned ho-taou.

Klikit war al liamm-mañ evit kadarnaat ho mignoniezh, mar plij :
$3

Trugarez deoc'h.

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
	'foe_request_subject' => "Digor eo ar brezel ! $1 en deus hoc'h ouzhpennet d'e enebourien war {{SITENAME}}!",
	'foe_request_body' => "Salud deoc'h, $1.

Emañ $2 o paouez ho lakaat da enebour war {{SITENAME}}. C'hoant hon eus da vezañ sur ez oc'h enebourien touet.

Klikit war al liamm-mañ, mar plij, evit kadarnaat hoc'h enebouriezh.

$3

Trugarez deoc'h

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
	'friend_accept_subject' => "$1 en deus asantet d'ho koulenn mignoniezh war {{SITENAME}} !",
	'friend_accept_body' => "Salud deoc'h, $1.

$2 en deus asantet d'ho koulenn mignoniezh war  {{SITENAME}} !

Kit da welet pajenn $2 e $3

Trugarez deoc'h,

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
	'foe_accept_subject' => "Graet eo ! $1 en deus asantet d'ho koulenn enebouriezh war {{SITENAME}} !",
	'foe_accept_body' => "Salud deoc'h, $1.

$2 en deus asantet d'ho koulenn enebouriezh war  {{SITENAME}} !

Kit da welet pajenn $2 e $3

Trugarez deoc'h,

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
	'friend_removed_subject' => 'Satordallik ! $1 en deus ho lmaet eus e vignoned war {{SITENAME}} !',
	'friend_removed_body' => "Salud deoc'h, $1.

$2 en deus ho lamet eus e vignoned war  {{SITENAME}} !

Trugarez deoc'h,

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
	'foe_removed_subject' => 'You ! $1 en deus ho lamet eus e enebourien war {{SITENAME}} !',
	'foe_removed_body' => "Salud deoc'h, $1.

$2 en deus ho lamet eus e enebourien war {{SITENAME}}!

Marteze e teuot da vezañ mignoned ?

Trugarez deoc'h

---

C'hoant hoc'h eus da baouez da resev posteloù diganimp ?

Klikit war $4
ha cheñchit hoc'h arventennoù evit diweredekaat ar c'hemenn dre bostel.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'viewrelationships' => 'Pogledaj vezu',
	'viewrelationshiprequests' => 'Pogledaj zahtjeve za vezu',
	'ur-already-submitted' => 'Vaš zahtjev je poslan',
	'ur-error-page-title' => 'Ups!',
	'ur-error-title' => 'Ups, odavde ne možete dalje!',
	'ur-error-message-no-user' => 'Ne možemo završiti Vaš zahtjev, jer ne postoji nijedan korisnik s ovim imenom.',
	'ur-main-page' => 'Početna stranica',
	'ur-your-profile' => 'Vaš profil',
	'ur-backlink' => '&lt; Nazad na profil korisnika $1',
	'ur-relationship-count-foes' => '$1 ima $2 {{PLURAL:$2|neprijatelja|neprijatelja}}.
Želite više neprijatelja?
<a href="$3">Pozovite ih.</a>',
	'ur-relationship-count-friends' => '$1 ima $2 {{PLURAL:$2|prijatelja|prijatelja}}.
Želite više prijatelja?
<a href="$3">Pozovite ih.</a>',
	'ur-add-friends' => '  Želite još prijatelja?
<a href="$1">Pozovite ih</a>',
	'ur-add-friend' => 'Dodaj kao prijatelja',
	'ur-add-foe' => 'Dodaj kao neprijatelja',
	'ur-add-no-user' => 'Nije odabran korisnik.
Molimo zahtjevajte prijatelje/neprijatelje preko ispravnog linka.',
	'ur-add-personal-message' => 'Dodaj ličnu poruku',
	'ur-remove-relationship-friend' => 'Ukloni kao prijatelja',
	'ur-remove-relationship-foe' => 'Ukloni kao neprijatelja',
	'ur-give-gift' => 'Pošalji poklon',
	'ur-previous' => 'preth',
	'ur-next' => 'slijedeći',
	'ur-remove-relationship-title-foe' => 'Da li želite ukloniti $1 kao Vašeg neprijatelja?',
	'ur-remove-relationship-title-confirm-foe' => 'Ukonili ste $1 kao neprijatelja',
	'ur-remove-relationship-title-friend' => 'Da li želite ukloniti $1 kao Vašeg prijatelja?',
	'ur-remove-relationship-title-confirm-friend' => 'Uklonili ste $1 kao prijatelja',
	'ur-remove-relationship-message-foe' => 'Tražili ste da uklonite $1 kao vašeg neprijatelja, kliknite "$2" da potvrdite.',
	'ur-remove-relationship-message-confirm-foe' => 'Uspješno ste uklonili $1 kao Vašeg neprijatelja.',
	'ur-remove-relationship-message-friend' => 'Zahtijevali ste da uklonite $1 kao vašeg prijatelja, kliknite "$2" da potvrdite.',
	'ur-remove-relationship-message-confirm-friend' => 'Uspješno ste uklonili $1 kao Vašeg prijatelja.',
	'ur-remove-error-message-no-relationship' => 'Nemate vezu sa $1.',
	'ur-remove-error-message-remove-yourself' => 'Ne možete ukloniti samog sebe.',
	'ur-remove-error-message-pending-foe-request' => 'Imate na čekanju zahtjev za neprijateljstvo sa $1.',
	'ur-remove-error-message-pending-friend-request' => 'Imate na čekanju zahtjev za prijateljstvo sa $1.',
	'ur-remove-error-not-loggedin-foe' => 'Morate biti prijavljeni da biste uklonili neprijatelja.',
	'ur-remove-error-not-loggedin-friend' => 'Morate biti prijavljeni da biste uklonili prijatelja.',
	'ur-remove' => 'Ukloni',
	'ur-cancel' => 'Odustani',
	'ur-login' => 'Prijava',
	'ur-add-title-foe' => 'Da li želite dodati $1 kao Vašeg neprijatelja?',
	'ur-add-title-friend' => 'Da li želite dodati $1 kao svog prijatelja?',
	'ur-add-message-foe' => 'Dodat ćete $1 kao vašeg neprijatelja.
Mi ćemo obavijestiti $1 da potvrdi vašu mržnju.',
	'ur-add-message-friend' => 'Dodat ćete $1 kao vašeg prijatelja.
Mi ćemo obavijestiti $1 da potvrdi vaše prijateljstvo.',
	'ur-add-button-foe' => 'Dodaj kao neprijatelja',
	'ur-add-button-friend' => 'Dodaj kao prijatelja',
	'ur-add-error-message-yourself' => 'Ne možete dodati sebe ni kao prijatelja ni kao neprijatelja.',
	'ur-add-error-message-existing-relationship-foe' => 'Već ste neprijatelj sa $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Već ste prijatelj sa $1.',
	'ur-add-error-message-pending-request-title' => 'Strpljenja!',
	'ur-add-error-message-not-loggedin-foe' => 'Morate biti prijavljeni da biste dodali neprijatelja',
	'ur-add-error-message-not-loggedin-friend' => 'Morate biti prijavljeni da biste dodali prijatelja',
	'ur-requests-title' => 'Zahtjevi za vezu',
	'ur-requests-message-foe' => '<a href="$1">$2</a> želi da bude Vaš neprijatelj.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> želi da bude Vaš prijatelj.',
	'ur-accept' => 'Prihvati',
	'ur-reject' => 'Odbij',
	'ur-requests-reject-message-friend' => 'Odbili ste $1 kao Vašeg prijatelja.',
	'ur-requests-reject-message-foe' => 'Odbili ste $1 kao Vašeg neprijatelja.',
	'ur-title-foe' => 'Spisak neprijatelja korisnika $1',
	'ur-title-friend' => 'Spisak prijatelja korisnika $1',
	'friend_request_body' => 'Zdravo $1.

$2 je vas dodao kao vašeg prijatelja na {{SITENAME}}. Želimo da zaista utvrdimo da li ste vi prijatelji.

Molimo kliknite na ovaj link da potvrdite vaše prijateljstvo:
$3

Hvala

---

Hej, da li želite da prestanete dobijati e-mailove od nas?

Kliknite $4
i promijeniti vaše postavke da onemogućite e-mail obavještenja.',
	'foe_request_subject' => 'Rat je! $1 je dodao Vas kao neprijatelja na {{SITENAME}}!',
	'friend_removed_subject' => 'O ne! $1 je uklonio Vas kao prijatelja na {{SITENAME}}!',
	'foe_removed_subject' => 'Super! $1 je uklonio Vas kao neprijatelja na {{SITENAME}}!',
);

/** Буряад (Буряад)
 * @author ОйЛ
 */
$messages['bxr'] = array(
	'ur-main-page' => 'Нюур хуудаһан',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'ur-main-page' => 'Pàgina principal',
	'ur-your-profile' => 'El vostre perfil',
	'ur-add-friend' => 'Afegeix com a amic',
	'ur-previous' => 'ant',
	'ur-next' => 'seg',
	'ur-remove' => 'Elimina',
	'ur-cancel' => 'Canceŀla',
	'ur-accept' => 'Accepta',
	'ur-reject' => 'Rebutja',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'ur-main-page' => 'Fanhaluman',
);

/** Sorani (کوردی)
 * @author Marmzok
 */
$messages['ckb'] = array(
	'viewrelationships' => 'دیتنی پەیوەندی',
	'viewrelationshiprequests' => 'دیتنی داخوازیەکانی پەیوەندی',
	'ur-already-submitted' => 'داخوازیەکەت ناردرا',
	'ur-main-page' => 'لاپەڕەی سەرەکی',
	'ur-previous' => 'پێشوو',
	'ur-next' => 'دواتر',
	'ur-remove' => 'لابردن',
	'ur-cancel' => 'هەڵوەشاندنەوە',
	'ur-login' => 'چوونەژوورەوە',
	'ur-accept' => 'پەسەند کردن',
	'ur-reject' => 'پەسەند نەکردن',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'ur-previous' => 'předchozí',
	'ur-next' => 'další',
	'ur-remove' => 'Odstranit',
	'ur-cancel' => 'Storno',
	'ur-login' => 'Přihlásit',
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
 * @author Als-Holder
 * @author Imre
 * @author Melancholie
 * @author Revolus
 * @author The Evil IP address
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
	'ur-backlink' => '&lt; Zurück zum Profil von $1',
	'ur-relationship-count-foes' => '$1 hat {{PLURAL:$2|einen Feind|$2 Feinde}}. Du möchtest mehr Feinde? <a href="$3">Lade sie ein.</a>',
	'ur-relationship-count-friends' => '$1 hat {{PLURAL:$2|einen Freund|$2 Freunde}}. Du möchtest mehr Freunde? <a href="$3">Lade sie ein.</a>',
	'ur-add-friends' => ' Du möchtest mehr Freunde haben? <a href="$1">Lade sie ein …</a>',
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
	'ur-remove-relationship-title-foe' => 'Du möchtest $1 aus deiner Feindesliste entfernen?',
	'ur-remove-relationship-title-confirm-foe' => 'Du hast $1 aus deiner Feindesliste entfernt',
	'ur-remove-relationship-title-friend' => 'Du möchtest $1 aus deiner Freundesliste entfernen?',
	'ur-remove-relationship-title-confirm-friend' => 'Du hast $1 aus deiner Freundesliste entfernt',
	'ur-remove-relationship-message-foe' => 'Du willst $1 aus deiner Feindesliste entfernen? Drücke „$2“ zum Bestätigen.',
	'ur-remove-relationship-message-confirm-foe' => 'Du hast erfolgreich $1 aus deiner Feindesliste entfernt.',
	'ur-remove-relationship-message-friend' => 'Du willst $1 aus deiner Freundesliste entfernen? Drücke „$2“ zum Bestätigen.',
	'ur-remove-relationship-message-confirm-friend' => 'Du hast $1 erfolgreich aus deiner Freundesliste entfernt.',
	'ur-remove-error-message-no-relationship' => '$1 steht in keiner Beziehung zu dir.',
	'ur-remove-error-message-remove-yourself' => 'Du kannst dich nicht selbst entfernen.',
	'ur-remove-error-message-pending-foe-request' => 'Du hast eine ausstehende Feindschaftsanfrage von $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du hast eine ausstehende Freundschaftsanfrage von $1.',
	'ur-remove-error-not-loggedin-foe' => 'Du musst angemeldet sein, um einen Feind zu entfernen.',
	'ur-remove-error-not-loggedin-friend' => 'Du musst angemeldet sein, um einen Freund zu entfernen.',
	'ur-remove' => 'Entfernen',
	'ur-cancel' => 'Abbrechen',
	'ur-login' => 'Anmelden',
	'ur-add-title-foe' => 'Du willst $1 zu deiner Feindesliste hinzufügen?',
	'ur-add-title-friend' => 'Du willst $1 zu deiner Freundesliste hinzufügen?',
	'ur-add-message-foe' => 'Du bist im Begriff, $1 zu deiner Feindesliste hinzuzufügen.
Wir werden $1 von deinem Groll berichten.',
	'ur-add-message-friend' => 'Du bist im Begriff, $1 zu deiner Freundesliste hinzuzufügen.
Wir werden eine Bestätigungen von $1 einholen.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Du bist bereits mit $1 befeindet.',
	'ur-add-error-message-existing-relationship-friend' => 'Du bist bereits mit $1 befreundet.',
	'ur-add-error-message-pending-request-title' => 'Geduld!',
	'ur-add-error-message-pending-friend-request' => 'Du hast eine ausstehende Freundschaftsanfrage von $1.
Wir werden $1 davon informieren, wenn du seine Anfrage bestätigst.',
	'ur-add-error-message-pending-foe-request' => 'Du hast eine ausstehende Feindschaftsanfrage von $1.
Wir werden $1 davon informieren, wenn du seine Anfrage bestätigst.',
	'ur-add-error-message-not-loggedin-foe' => 'Du musst angemeldet sein, um einen Feind hinzuzufügen',
	'ur-add-error-message-not-loggedin-friend' => 'Du musst angemeldet sein, um einen Freund hinzuzufügen',
	'ur-requests-title' => 'Beziehungsanfragen',
	'ur-requests-message-foe' => '<a href="$1">$2</a> möchte dein Feind sein.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> möchte dein Freund sein.',
	'ur-accept' => 'Annehmen',
	'ur-reject' => 'Ablehnen',
	'ur-no-requests-message' => 'Du hast keine Freund- oder Feind-Anfrage. Wenn du mehr Freunde haben möchtest, <a href="$1">Lade sie ein …</a>',
	'ur-requests-added-message-foe' => 'Du hast $1 zu deiner Feindesliste hinzugefügt.',
	'ur-requests-added-message-friend' => 'Du hast $1 zu deiner Freundesliste hinzugefügt.',
	'ur-requests-reject-message-friend' => 'Du hast $1 als deinen Freund abgelehnt.',
	'ur-requests-reject-message-foe' => 'Du hast $1 als deinen Feind abgelehnt.',
	'ur-title-foe' => 'Feindesliste von $1',
	'ur-title-friend' => 'Freundesliste von $1',
	'friend_request_subject' => '[{{SITENAME}}] $1 hat dich als Freund hinzugefügt!',
	'friend_request_body' => 'Hi $1:

$2 hat dich in {{SITENAME}} als Freund hinzugefügt. Wir wollen sicher gehen, dass ihr zwei wirklich Freunde seit.

Bitte klicke den folgenden Link um eure Freundschaft zu bestätigen:
$3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_request_subject' => '[{{SITENAME}}] Kriegserklärung! $1 hat dich als Feind hinzugefügt!',
	'foe_request_body' => 'Hi $1:

$2 hat dich in {{SITENAME}} als Feind hinzugefügt. Wir wollen sicher gehen, dass ihr zwei wirklich tödliche Feinde seid oder euch wenigstens ein wenig streitet.

Bitte klicke den folgenden Link um eure Feindschaft zu bestätigen:

$3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'friend_accept_subject' => '[{{SITENAME}}] $1 hat deine Freundschaftsanfrage bestätigt!',
	'friend_accept_body' => 'Hi $1:

$2 hat deine Freundschaftsanfrage in {{SITENAME}} bestätigt!

Siehe $2s Seite hier: $3

Danke

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_accept_subject' => '[{{SITENAME}}] $1 hat deine Feind-Anfrage bestätigt!',
	'foe_accept_body' => 'Hi $1:

$2 hat deine Feind-Anfrage in {{SITENAME}} bestätigt!

Siehe $2s Seite hier: $3

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'friend_removed_subject' => '[{{SITENAME}}] Oh nein! $1 hat seine Freundschaft zu dir beendet!',
	'friend_removed_body' => 'Hi $1:

$2 hat seine Freundschaft zu dir in {{SITENAME}} beendet!

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_removed_subject' => '[{{SITENAME}}] Hey! $1 hat seine Feindschaft zu dir beendet!',
	'foe_removed_body' => 'Hi $1:

$2 hat seine Feindschaft zu dir in {{SITENAME}} beendet!

Vielleicht werdet ihr beide ja sogar mal Freunde?

---

Hm, du willst keine E-Mails mehr von uns bekommen?

Klicke $4
und ändere deine Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'ur-already-submitted' => 'Ihre Anfrage wurde gesendet',
	'ur-your-profile' => 'Ihr Profil',
	'ur-relationship-count-foes' => '$1 hat {{PLURAL:$2|einen Feind|$2 Feinde}}. Sie möchten mehr Feinde? <a href="$3">Laden Sie sie ein.</a>',
	'ur-relationship-count-friends' => '$1 hat {{PLURAL:$2|einen Freund|$2 Freunde}}. Sie möchten mehr Freunde? <a href="$3">Laden Sie sie ein.</a>',
	'ur-add-friends' => '  Sie möchten mehr Freunde haben? 
<a href="$1">Laden Sie sie ein …</a>',
	'ur-add-no-user' => 'Kein Benutzer ausgewählt.
Bitte wählen Sie die Freunde/Feinde durch den richtigen Link.',
	'ur-remove-relationship-title-foe' => 'Sie möchten $1 aus Ihrer Feindesliste löschen?',
	'ur-remove-relationship-title-confirm-foe' => 'Sie haben $1 aus Ihrer Feindesliste entfernt',
	'ur-remove-relationship-title-friend' => 'Sie möchten $1 aus Ihrer Freundesliste entfernen?',
	'ur-remove-relationship-title-confirm-friend' => 'Sie haben $1 aus Ihrer Freundesliste entfernt',
	'ur-remove-relationship-message-foe' => 'Sie wollen $1 aus Ihrer Feindesliste entfernen? Drücken Sie „$2“ zum Bestätigen.',
	'ur-remove-relationship-message-confirm-foe' => 'Sie haben erfolgreich $1 aus Ihrer Feindesliste entfernt.',
	'ur-remove-relationship-message-friend' => 'Sie wollen $1 aus Ihrer Freundesliste entfernen? Drücken Sie „$2“ zum Bestätigen.',
	'ur-remove-relationship-message-confirm-friend' => 'Sie haben $1 erfolgreich aus Ihrer Freundesliste entfernt.',
	'ur-remove-error-message-no-relationship' => '$1 steht in keiner Beziehung zu Ihnen.',
	'ur-remove-error-message-remove-yourself' => 'Sie können sich nicht selbst entfernen.',
	'ur-remove-error-message-pending-foe-request' => 'Sie haben eine ausstehende Feindschaftsanfrage von $1.',
	'ur-remove-error-message-pending-friend-request' => 'Sie haben eine ausstehende Freundschaftsanfrage von $1.',
	'ur-remove-error-not-loggedin-foe' => 'Sie müssen angemeldet sein, um einen Feind zu entfernen.',
	'ur-remove-error-not-loggedin-friend' => 'Sie müssen angemeldet sein, um einen Freund zu entfernen.',
	'ur-add-title-foe' => 'Sie wollen $1 zu Ihrer Feindesliste hinzufügen?',
	'ur-add-title-friend' => 'Sie wollen $1 zu Ihrer Freundesliste hinzufügen?',
	'ur-add-message-foe' => 'Sie sind im Begriff, $1 zu Ihrer Feindesliste hinzuzufügen.
Wir werden $1 von Ihrem Groll berichten.',
	'ur-add-message-friend' => 'Sie sind im Begriff, $1 zu Ihrer Freundesliste hinzuzufügen.
Wir werden eine Bestätigungen von $1 einholen.',
	'ur-add-sent-title-foe' => 'Wir haben Ihre Feindschaftsanfrage an $1 gesendet!',
	'ur-add-sent-title-friend' => 'Wir haben Ihre Freundschaftsanfrage an $1 gesendet!',
	'ur-add-sent-message-foe' => 'Ihre Feindschaftsanfrage wurde an $1 zum Bestätigen weitergereicht.
Sie werden eine E-Mail bekommen, sobald $1 Ihre Anfrage bestätigt.',
	'ur-add-sent-message-friend' => 'Ihre Freundschaftsanfrage wurde an $1 zum Bestätigen weitergereicht.
Sie werden eine E-Mail bekommen, sobald $1 Ihre Anfrage bestätigt.',
	'ur-add-error-message-no-user' => 'Der Benutzer, den Sie hinzufügen möchten, existiert nicht.',
	'ur-add-error-message-blocked' => 'Sie sind momentan gesperrt und können keine Freunde oder Feinde hinzufügen.',
	'ur-add-error-message-yourself' => 'Sie können sich nicht selbst als Freund oder Feind hinzufügen.',
	'ur-add-error-message-existing-relationship-foe' => 'Sie sind bereits mit $1 befeindet.',
	'ur-add-error-message-existing-relationship-friend' => 'Sie sind bereits mit $1 befreundet.',
	'ur-add-error-message-pending-friend-request' => 'Sie haben eine ausstehende Freundschaftsanfrage von $1.
Wir werden $1 davon informieren, wenn Sie seine Anfrage bestätigen.',
	'ur-add-error-message-pending-foe-request' => 'Sie haben eine ausstehende Feindschaftsanfrage von $1.
Wir werden $1 davon informieren, wenn Sie seine Anfrage bestätigen.',
	'ur-add-error-message-not-loggedin-foe' => 'Sie müssen angemeldet sein, um einen Feind hinzuzufügen',
	'ur-add-error-message-not-loggedin-friend' => 'Sie müssen angemeldet sein, um einen Freund hinzuzufügen',
	'ur-requests-message-foe' => '<a href="$1">$2</a> möchte Ihr Feind sein.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> möchte Ihr Freund sein.',
	'ur-no-requests-message' => 'Sie haben keine Freund- oder Feindschaftsanfragen. Wenn Sie mehr Freunde haben möchten, <a href="$1">laden Sie sie ein!</a>',
	'ur-requests-added-message-foe' => 'Sie haben $1 zu Ihrer Feindesliste hinzugefügt.',
	'ur-requests-added-message-friend' => 'Sie haben $1 zu Ihrer Freundesliste hinzugefügt.',
	'ur-requests-reject-message-friend' => 'Sie haben $1 als Ihren Freund abgelehnt.',
	'ur-requests-reject-message-foe' => 'Sie haben $1 als Ihren Feind abgelehnt.',
	'friend_request_subject' => '[{{SITENAME}}] $1 hat Sie als Freund hinzugefügt!',
	'friend_request_body' => 'Hi $1:

$2 hat Sie in {{SITENAME}} als Freund hinzugefügt. Wir wollen sicher gehen, dass Sie beide wirklich Freunde sind.

Bitte klicken Sie den folgenden Link um Ihre Freundschaft zu bestätigen:
$3

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_request_subject' => '[{{SITENAME}}] Kriegserklärung! $1 hat Sie als Feind hinzugefügt!',
	'foe_request_body' => 'Hi $1:

$2 hat Sie in {{SITENAME}} als Feind hinzugefügt. Wir wollen sicher gehen, dass Sie beide wirklich tödliche Feinde sind oder sich wenigstens ein wenig streiten.

Bitte klicken Sie den folgenden Link um Ihre Feindschaft zu bestätigen:

$3

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'friend_accept_subject' => '[{{SITENAME}}] $1 hat Ihre Freundschaftsanfrage bestätigt!',
	'friend_accept_body' => 'Hi $1:

$2 hat Ihre Freundschaftsanfrage in {{SITENAME}} bestätigt!

Siehe $2s Seite hier: $3

Danke

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_accept_subject' => '[{{SITENAME}}] $1 hat Ihre Feind-Anfrage bestätigt!',
	'foe_accept_body' => 'Hi $1:

$2 hat Ihre Feind-Anfrage in {{SITENAME}} bestätigt!

Siehe $2s Seite hier: $3

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen, um E-Mail-Benachrichtigungen auszuschalten.',
	'friend_removed_subject' => '[{{SITENAME}}] Oh nein! $1 hat seine Freundschaft zu Ihnen beendet!',
	'friend_removed_body' => 'Hi $1:

$2 hat seine Freundschaft zu Ihnen in {{SITENAME}} beendet!

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
	'foe_removed_subject' => '[{{SITENAME}}] Hey! $1 hat seine Feindschaft zu Ihnen beendet!',
	'foe_removed_body' => 'Hi $1:

$2 hat seine Feindschaft zu Ihnen in {{SITENAME}} beendet!

Vielleicht werden Sie beide ja sogar mal Freunde?

---

Hm, Sie wollen keine E-Mails mehr von uns bekommen?

Klicken Sie $4
und ändern Sie Ihre Einstellungen um E-Mail-Benachrichtigungen auszuschalten.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'viewrelationships' => 'Póśěgi se woglědaś',
	'viewrelationshiprequests' => 'Póśěgowe napšašowanja se woglědaś',
	'ur-already-submitted' => 'Twójo napšašowanje jo se pósłało',
	'ur-error-page-title' => 'Hopla!',
	'ur-error-title' => 'Hopla, sy cynił něco wopaki!',
	'ur-error-message-no-user' => 'Njamóžomy twójo napšašowanje wuwjasć, dokulaž wužywaŕ z toś tym mjenim njeeksistěrujo.',
	'ur-main-page' => 'Głowny bok',
	'ur-your-profile' => 'Twój profil',
	'ur-backlink' => '&lt; Slědk k profiloju wužywarja $1',
	'ur-relationship-count-foes' => '$1 ma $2 {{PLURAL:$2|njepśijaśela|njepśijaśelowu|njepśijaśelow|njepśijaśelow}}.
Coš dalšnych njepśijaśelow?
<a href="$3">Pśepšos jich.</a>',
	'ur-relationship-count-friends' => '$1 ma $2 {{PLURAL:$2|pśijaśela|pśijaśelowu|pśijaśelow|pśijaśelow}}.
Coš dalšnych pśijaśelow?
<a href="$3">Pśepšos jich.</a>',
	'ur-add-friends' => 'Coš dalšnych pśijaśelow?
<a href="$1">Pśepšos jich</a>',
	'ur-add-friend' => 'Ako pśijaśela pśidaś',
	'ur-add-foe' => 'Ako njepśijaśela pśidaś',
	'ur-add-no-user' => 'Žeden wužywaŕ wubrany.
Pšosym wubjeŕ pśijaśelow/njepśijaśelow pśez pšawy wótkaz.',
	'ur-add-personal-message' => 'Wósobinsku powěsć pśidaś',
	'ur-remove-relationship-friend' => 'Ako pśijaśela wótpóraś',
	'ur-remove-relationship-foe' => 'Ako njepśijaśela wótpóraś',
	'ur-give-gift' => 'Dariś',
	'ur-previous' => 'pjerwjejšny',
	'ur-next' => 'pśiducy',
	'ur-remove-relationship-title-foe' => 'Coš $1 ako swójogo njepśijaśela wótpóraś?',
	'ur-remove-relationship-title-confirm-foe' => 'Sy wótpórał $1 ako swójogo njepśijaśela',
	'ur-remove-relationship-title-friend' => 'Coš $1 ako swójogo pśijaśela wótpóraś?',
	'ur-remove-relationship-title-confirm-friend' => 'Sy wótpórał $1 ako swójogo pśijaśela',
	'ur-remove-relationship-message-foe' => 'Sy pominał $1 ako swójogo njepśijaśela wótpóraś, tłoc "$2", aby wobkšuśił.',
	'ur-remove-relationship-message-confirm-foe' => 'Sy wuspěšnje wótpórał $1 ako swójogo njepśijaśela.',
	'ur-remove-relationship-message-friend' => 'Sy pominał $1 ako swójogo pśijaśela wótpóraś, tłoc "$2", aby wobkšuśił.',
	'ur-remove-relationship-message-confirm-friend' => 'Sy wuspěšnje wótpórał $1 ako swójogo pśijaśela.',
	'ur-remove-error-message-no-relationship' => 'Njamaš žaden póśěg k $1.',
	'ur-remove-error-message-remove-yourself' => 'Njamóžoš sebje wótpóraś.',
	'ur-remove-error-message-pending-foe-request' => 'Maš njedocynjone njepśijaśelske napšašowanje z $1.',
	'ur-remove-error-message-pending-friend-request' => 'Maš njedocynjone pśijaśelske napšašowanje z $1.',
	'ur-remove-error-not-loggedin-foe' => 'Musyš pśizjawjony byś, aby wótpórał njepśijaśela.',
	'ur-remove-error-not-loggedin-friend' => 'Musyš pśizjawjony byś, aby wótpórał pśijaśela.',
	'ur-remove' => 'Wótpóraś',
	'ur-cancel' => 'Pśetergnuś',
	'ur-login' => 'Pśizjawjenje',
	'ur-add-title-foe' => 'Coš $1 ako swójogo njepśijaśela pśidaś?',
	'ur-add-title-friend' => 'Coš $1 ako swójogo pśijaśela pśidaś?',
	'ur-add-message-foe' => 'Coš rowno $1 ako swójogo njepśijaśela pśidaś.
Buźomy $1 informěrowaś, aby wobkšuśili twój gniw.',
	'ur-add-message-friend' => 'Coš rowno $1 ako swójogo pśijaśela pśidaś.
Buźomy $1 informěrowaś, aby wobkšuśili twójo pśijaśelstwo.',
	'ur-add-button-foe' => 'Ako njepśijaśela pśidaś',
	'ur-add-button-friend' => 'Ako pśijaśela pśidaś',
	'ur-add-sent-title-foe' => 'Smy pósłali wužywarjeju $1 twójo njepśijaśelske napšašowanje!',
	'ur-add-sent-title-friend' => 'Sym pósłali wužywarjeju $1 twójo pśijaśelske napšašowanje!',
	'ur-add-sent-message-foe' => 'Twójo njepśijaśelske napšašowanje jo se pósłało wužywarjeju $1 za wobkšuśenje.
Jolic $1 wobkšuśijo twójo napšašowanje, dostanjoš wótegronjeńsku e-mail',
	'ur-add-sent-message-friend' => 'Twójo pśijaśelske napšašowanje jo se pósłało wužywarjeju $1 za wobkšuśenje.
Jolic $1 wobkšuśijo twójo napšašowanje, dostanjoš wótegronjeńsku e-mail',
	'ur-add-error-message-no-user' => 'Wužywaŕ, kótaregož wopytujoš pśidaś, njeeksistěrujo.',
	'ur-add-error-message-blocked' => 'Sy tuchylu blokěerowany a njamóžoš pśijaśelow abo njepśijaśelow pśidaś.',
	'ur-add-error-message-yourself' => 'Njamóžoš sebje ako pśijaśela abo njepśijaśela pśidaś.',
	'ur-add-error-message-existing-relationship-foe' => '$1 jo južo twój njepśijaśel.',
	'ur-add-error-message-existing-relationship-friend' => '$1 jo južo twój pśijaśel.',
	'ur-add-error-message-pending-request-title' => 'Sćerpnosć!',
	'ur-add-error-message-pending-friend-request' => 'Maš njedocynjone pśijaśelske napšašowanje z $1.
Buźomy śi informěrowaś, gaž $1 wobkšuśijo twójo napšašowanje.',
	'ur-add-error-message-pending-foe-request' => 'Maš njedocynjone njepśijaśelske napšašowanje z $1.
Buźomy śi informěrowaś, gaž $1 wobkšuśijo twójo napšašowanje.',
	'ur-add-error-message-not-loggedin-foe' => 'Musyš pśizjawjony byś, aby pśidał njepśijaśela',
	'ur-add-error-message-not-loggedin-friend' => 'Musyš pśizjawjony byś, aby pśidał pśijaśela',
	'ur-requests-title' => 'Póśěgowe napšašowanja',
	'ur-requests-message-foe' => '<a href="$1">$2</a> co twójogo njepśijaśela byś.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> co twój pśijaśel byś.',
	'ur-accept' => 'Akceptěrowaś',
	'ur-reject' => 'Wótpokazaś',
	'ur-no-requests-message' => 'Njamaš žedne pśijaśelske abo njepśijaśelske napšašowanja.
Jolic coš wěcej pśijaśelow, <a href="$1">pśepros jich!</a>',
	'ur-requests-added-message-foe' => 'Sy pśidał $1 ako swójogo njepśijaśela.',
	'ur-requests-added-message-friend' => 'Sy pśidał $1 ako swójogo pśijaśela.',
	'ur-requests-reject-message-friend' => 'Sy wótpokazał $1 ako swójogo pśijaśela.',
	'ur-requests-reject-message-foe' => 'Sy wótpokazał $1 ako swójogo njepśijaśela.',
	'ur-title-foe' => 'Lisćina njepśijaśelow wužywarja $1',
	'ur-title-friend' => 'Lisćina pśijaśelow wužywarja $1',
	'friend_request_subject' => '$1 jo śi pśidał ako pśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}',
	'friend_request_body' => 'Witaj $1.

$2 jo śi pśidał ako pśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}. Comy zawěsćiś, až wej wobej stej napšawdu pśijaśela.

Pšosym klikni na toś ten wótkaz, aby wobkšuśił waju pśijaśelstwo:
$3

Źěkujomy se

---

Hej, južo njocoš žedne e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'foe_request_subject' => 'Wójna! $1 jo śi pśidał ako njepśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'foe_request_body' => 'Witaj $1.

$2 jo śi rowno nalicył ako njepśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}. Comy zawěsćiś, až wej wobej stej napšawdu nejžgóršej njepśijaśela abo matej nanejmjenjej argument za to.

Pšosym klikni na toś ten wótkaz, aby wobkšuśił mjazsobnu gramotu.

$3

Źěkujomy se

---

Hej, južo njocoš žedne e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'friend_accept_subject' => '$1 jo akceptěrował twójo pśijaśelske napšašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'friend_accept_body' => 'Witaj $1.

$2 jo akceptěrował twójo pśijaśelske napšašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Poglědaj na bok wužywarja $2 na $3

Źěkujomy se

---

Hej, južo njocoš žedne e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'foe_accept_subject' => 'Jo tak daloko! $1 jo akceptěrował twójo njepśijaśelske napšašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'foe_accept_body' => 'Witaj $1.

$2 jo akceptěrował twójo njepśijaśelske napšašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Póglědaj na bok wužywarja $2 na $3

Źěkujomy se

---

Hej, južo njocoš žedne e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'friend_removed_subject' => 'Ow ně! $1 jo śi wótpórał ako pśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'friend_removed_body' => 'Witaj $1.

$2 jo śi wótpórał ako pśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Źěkujomy se

---

Hej, južo njocoš žedne e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
	'foe_removed_subject' => 'Juhu! $1 jo śi wótpórał ako njepśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}!',
	'foe_removed_body' => 'Witaj $1.

$2 jo śi wótpórał ako njepśijaśela na {{GRAMMAR:lokatiw|{{SITENAME}}}}!

Snaź stej wej wobej na nejlěpšej droze, aby se spśijaśeliłej?

Źěkujomy se

---

Hej, južo njocoš žedne e-maile wót nas dostaś?

Klikni na $4
a změń swóje nastajenja, aby znjemóžnił e-mailowe zdźělenja.',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Evropi
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'viewrelationships' => 'Εμφάνιση σχέσης',
	'viewrelationshiprequests' => 'Εμφάνιση των προτάσεων για σχέση',
	'ur-already-submitted' => 'Η πρόταση σας έχει αποσταλλεί',
	'ur-error-page-title' => 'Ωχ!',
	'ur-error-title' => 'Ουπς, πήρες μια λάθος στροφή!',
	'ur-error-message-no-user' => 'Δεν μπορούμε να συμπληρώσουμε την πρόταση σας, γιατί δεν υπάρχει χρήστης με αυτό το όνομα.',
	'ur-main-page' => 'Κύρια σελίδα',
	'ur-your-profile' => 'Το προφίλ σας',
	'ur-backlink' => '&lt; Πίσω στο προφίλ του $1',
	'ur-relationship-count-foes' => 'Ο $1 έχει $2 εχθρ{{PLURAL:$2|ό|ούς}}.
Θέλετε περισσότερους εχθρούς;
<a href="$3">Προσκαλέστε τους</a>',
	'ur-relationship-count-friends' => 'Ο $1 έχει $2 φίλ{{PLURAL:$2|ο|ους}}.
Θέλετε περισσότερους φίλους;
<a href="$3">Προσκαλέστε τους</a>',
	'ur-add-friends' => 'Θέλετε περισσότερους φίλους;
<a href="$1">Προσκαλέστε τους</a>',
	'ur-add-friend' => 'Προσθήκη σαν φίλο',
	'ur-add-foe' => 'Προσθήκη σαν εχθρό',
	'ur-add-no-user' => 'Κανένας χρήστης δεν έχει επιλεχθεί.
Παρακαλώ κάντε αίτηση για εχθρούς/φίλους μέσω του σωστού συνδέσμου.',
	'ur-add-personal-message' => 'Προσθήκη ενός προσωπικού μηνύματος',
	'ur-remove-relationship-friend' => 'Αφαίρεση ως φίλου',
	'ur-remove-relationship-foe' => 'Αφαίρεση ως εχθρού',
	'ur-give-gift' => 'Δώστε ένα Δώρο',
	'ur-previous' => 'προηγ',
	'ur-next' => 'επομ',
	'ur-remove-relationship-title-foe' => 'Θες να αφαιρέσεις τον $1 ως εχθρό σου;',
	'ur-remove-relationship-title-confirm-foe' => 'Αφαίρεσες τον $1 ως εχθρό σου',
	'ur-remove-relationship-title-friend' => 'Θες να αφαιρέσεις τον $1 ως φίλο σου;',
	'ur-remove-relationship-title-confirm-friend' => 'Αφαίρεσες τον $1 ως φίλο σου',
	'ur-remove-relationship-message-confirm-foe' => 'Έχετε επιτυχώς αφαιρέσει τον $1 ως εχθρό σας.',
	'ur-remove-relationship-message-confirm-friend' => 'Έχετε επιτυχώς αφαιρέσει τον $1 ως φίλο σας.',
	'ur-remove-error-message-no-relationship' => 'Δεν έχεις σχέση με τον $1.',
	'ur-remove-error-message-remove-yourself' => 'Δεν μπορείς να αφαιρέσεις τον εαυτό σου',
	'ur-remove-error-message-pending-foe-request' => 'Έχετε μια εκκρεμή αίτηση εχθρού με τον $1.',
	'ur-remove-error-message-pending-friend-request' => 'Έχετε μια εκκρεμή αίτηση φίλου με τον $1.',
	'ur-remove-error-not-loggedin-foe' => 'Πρέπει να είσαι συνδεδεμένος για να αφαιρέσεις έναν εχθρό.',
	'ur-remove-error-not-loggedin-friend' => 'Πρέπει να είσαι συνδεδεμένος για να αφαιρέσεις έναν φίλο.',
	'ur-remove' => 'Αφαίρεση',
	'ur-cancel' => 'Ακύρωση',
	'ur-login' => 'Είσοδος',
	'ur-add-title-foe' => 'Θες να προσθέσεις τον $1 ως εχθρό σου;',
	'ur-add-title-friend' => 'Θέλετε να προσθέσετε τον $1 ως φίλο σας;',
	'ur-add-message-foe' => 'Πρόκειται να προσθέσετε τον $1 ως εχθρό.
Θα ειδοποιήσουμε τον $1 για να επιβεβαιώσει την έχθρα σας.',
	'ur-add-message-friend' => 'Πρόκειται να προσθέσετε τον $1 ως φίλο. 
Θα ειδοποιήσουμε τον $1 για να επιβεβαιώσει την φιλία σας.',
	'ur-add-button-foe' => 'Προσθήκη ως εχθρού',
	'ur-add-button-friend' => 'Προσθήκη ως φίλου',
	'ur-add-sent-title-foe' => 'Στείλαμε την πρόταση εχθρού σας στον $1!',
	'ur-add-sent-title-friend' => 'Στείλαμε την πρόταση φίλου σας στον $1!',
	'ur-add-error-message-no-user' => 'Αυτός ο χρήστης που προσπαθείτε να προσθέσετε δεν υπάρχει.',
	'ur-add-error-message-blocked' => 'Τώρα είσαι φραγμένος και δεν μπορείς να προσθέσεις φίλους ή εχθρούς.',
	'ur-add-error-message-yourself' => 'Δεν μπορείς να προσθέσεις τον εαυτό σου ως ένα φίλο ή εχθρό.',
	'ur-add-error-message-existing-relationship-foe' => 'Είσαι ήδη εχθρός με τον $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Είσαι ήδη φίλος με τον $1.',
	'ur-add-error-message-pending-request-title' => 'Υπομονή!',
	'ur-add-error-message-not-loggedin-foe' => 'Πρέπει να είσαι συνδεδεμένος για να προσθέσεις έναν εχθρό',
	'ur-add-error-message-not-loggedin-friend' => 'Πρέπει να είσαι συνδεδεμένος για να προσθέσεις έναν φίλο',
	'ur-requests-title' => 'Προτάσεις σχέσης',
	'ur-requests-message-foe' => 'Ο <a href="$1">$2</a> θέλει να γίνει εχθρός σου.',
	'ur-requests-message-friend' => 'Ο <a href="$1">$2</a> θέλει να γίνει φίλος σου.',
	'ur-accept' => 'Αποδοχή',
	'ur-reject' => 'Απόρριψη',
	'ur-no-requests-message' => 'Δεν έχετε καμία αίτηση για προσθήκη φίλου ή εχθρού. 
Αν θέλετε περισσότερους φίλους, <a href="$1">προσκαλέστε τους!</a>',
	'ur-requests-added-message-foe' => 'Δέχτηκες τον $1 σαν εχθρό σου.',
	'ur-requests-added-message-friend' => 'Δέχτηκες τον $1 σαν φίλο σου.',
	'ur-requests-reject-message-friend' => 'Αρνήθηκες τον $1 σαν φίλο σου.',
	'ur-requests-reject-message-foe' => 'Αρνήθηκες τον $1 σαν εχθρό σου.',
	'ur-title-foe' => 'Η λίστα εχθρών του $1',
	'ur-title-friend' => 'Η λίστα φίλων του $1',
	'friend_request_subject' => 'Ο $1 σας έχει προσθέσει σαν φίλο στο {{SITENAME}}!',
	'friend_request_body' => 'Γεια $1.

Ο $2 σας πρόσθεσε σαν φίλο στο {{SITENAME}}. Θέλουμε να σιγουρευτούμε ότι είστε πράγματι φίλοι.

Κάνετε κλικ στον παρακάτω σύνδεσμο για να επιβεβαιώσετε την φιλία σας:
$3

Ευχαριστούμε

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξτε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'foe_request_subject' => 'Είναι πόλεμος! Ο $1 σας πρόσθεσε ως εχθρό του στο {{SITENAME}}!',
	'foe_request_body' => 'Γεια $1.

Ο $2 σας πρόσθεσε ως εχθρό στο {{SITENAME}}. Θέλουμε να σιγουρευτούμε ότι εσείς οι δύο είστε πράγματι θανάσιμοι εχθροί ή ότι τουλάχιστον έχετε κάποια διαφωνία. 

Κάντε κλικ παρακάτω για να επιβεβαιώσετε τον κακεντρεχή ανταγωνισμό.

$3

Ευχαριστούμε

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξτε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'friend_accept_subject' => 'Ο $1 αποδέχθηκε το αίτημα φιλίας σας στο {{SITENAME}}!',
	'friend_accept_body' => 'Γεια $1.

Ο $2 δέχτηκε την αίτηση φιλίας στο {{SITENAME}}.

Τσεκάρετε την σελίδα του $2 στο $3

Ευχαριστούμε,

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξετε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'foe_accept_subject' => 'Έγινε! Ο $1 αποδέχθηκε το αίτημα εχθρού σας στο {{SITENAME}}!',
	'foe_accept_body' => 'Γεια $1.

Ο $2 δέχτηκε την αίτηση έχθρας στο {{SITENAME}}.

Τσεκάρετε την σελίδα του $2 στο $3

Ευχαριστούμε,

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξετε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'friend_removed_subject' => 'Ω όχι! Ο $1 σας αφαίρεσε ως φίλο από το {{SITENAME}}!',
	'friend_removed_body' => 'Γεια $1.

Ο $2 σας αφαίρεσε από φίλο στο {{SITENAME}}!

Ευχαριστούμε

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξτε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
	'foe_removed_subject' => 'Γούχου! Ο $1 σας αφαίρεσε ως εχθρό από το {{SITENAME}}!',
	'foe_removed_body' => 'Γεια $1.

Ο $2 σας αφαίρεσε από εχθρό στο {{SITENAME}}!

Ίσως εσείς οι δύο είστε στην πορεία του να γίνετε φίλοι;

Ευχαριστούμε

---

Θέλετε να σταματήσετε να λαμβάνετε μηνύματα από εμάς;

Κάντε κλικ στο $4
και αλλάξτε τις ρυθμίσεις σας έτσι ώστε να απενεργοποιήσετε τις ειδοποιήσεις που λαμβάνετε μέσω ηλεκτρονικού ταχυδρομείου.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Vi jam estas malamiko kun $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Vi jam estas amiko kun $1.',
	'ur-add-error-message-pending-request-title' => 'Pacienciĝu!',
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
	'friend_removed_subject' => 'Ho ve! $1 forigis vin kiel amikon en {{SITENAME}}!',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author DoveBirkoff
 * @author Feten7
 * @author Fitoschido
 * @author Imre
 * @author Mor
 * @author Sanbec
 */
$messages['es'] = array(
	'viewrelationships' => 'Ver relación',
	'viewrelationshiprequests' => 'Ver solicitudes de relaciones',
	'ur-already-submitted' => 'Su solicitud ha sido enviada',
	'ur-error-page-title' => 'Woops!',
	'ur-error-title' => 'Whoops, usted tomó un turno equivocado!',
	'ur-error-message-no-user' => 'No podemos completar su solicitud, porque ningun usuario con este nombre existe.',
	'ur-main-page' => 'Página principal',
	'ur-your-profile' => 'Su perfil',
	'ur-backlink' => "&lt; Regresar a $1's perfil",
	'ur-relationship-count-foes' => '$1 tiene $2 {{PLURAL:$2|enemigo|enemigos}}.
Desea más enemigos?
<a href="$3">Invítelos.</a>',
	'ur-relationship-count-friends' => '$1 tiene $2 {{PLURAL:$2|amigo|amigos}}.
Desea más amigos?
<a href="$3">Invítelos.</a>',
	'ur-add-friends' => '  Desea más amigos? <a href="$1">Invítelos</a>',
	'ur-add-friend' => 'Agregar como amigo',
	'ur-add-foe' => 'Agregar como enemigo',
	'ur-add-no-user' => 'Ningún usuario seleccionado.
Por favor solicite amigos/enemigos a través del enlace correcto.',
	'ur-add-personal-message' => 'Agregar un mensaje personal',
	'ur-remove-relationship-friend' => 'Quitar como amigo',
	'ur-remove-relationship-foe' => 'Quitar como enemigo',
	'ur-give-gift' => 'Dar un regalo',
	'ur-previous' => 'anterior',
	'ur-next' => 'próximo',
	'ur-remove-relationship-title-foe' => '¿Desea quitar a $1 como su enemigo?',
	'ur-remove-relationship-title-confirm-foe' => 'Ha removido $1 como su enemigo',
	'ur-remove-relationship-title-friend' => '¿Desea quitar a $1 como su amigo?',
	'ur-remove-relationship-title-confirm-friend' => 'Ha removido $1 como su amigo',
	'ur-remove-relationship-message-foe' => 'Usted ha solicitado remover $1 como su enemigo, presione "$2" para confirmar.',
	'ur-remove-relationship-message-confirm-foe' => 'Ha removido exitosamente $1 como su enemigo.',
	'ur-remove-relationship-message-friend' => 'Usted ha solicitado remover $1 como su amigo, presione "$2" para confirmar.',
	'ur-remove-relationship-message-confirm-friend' => 'Ha eliminadoo exitosamente $1 como su amigo.',
	'ur-remove-error-message-no-relationship' => 'No tiene una relación con $1.',
	'ur-remove-error-message-remove-yourself' => 'No puede removerse a sí mismo.',
	'ur-remove-error-message-pending-foe-request' => 'Usted tiene pendiente una solicitud de enemigo con $1.',
	'ur-remove-error-message-pending-friend-request' => 'Usted tiene pendiente una solicitud de amigo con $1.',
	'ur-remove-error-not-loggedin-foe' => 'Debes haber iniciado sesión para eliminar un enemigo.',
	'ur-remove-error-not-loggedin-friend' => 'Debes haber iniciado sesión para quitar un amigo.',
	'ur-remove' => 'Eliminar',
	'ur-cancel' => 'Cancelar',
	'ur-login' => 'Iniciar sesión',
	'ur-add-title-foe' => 'Desea agregar $1 como su enemigo?',
	'ur-add-title-friend' => '¿Deseas agregar a $1 como amigo tuyo?',
	'ur-add-message-foe' => 'Estás a punto de añadir $1 como tu enemigo
Notificaremos $1 para confirmar tu rencilla.',
	'ur-add-message-friend' => 'Estás a punto de añadir $1 como tu amigo.
Notificaremos $1 para confirmar tu amistad.',
	'ur-add-button-foe' => 'Agregar como enemigo',
	'ur-add-button-friend' => 'Agregar como amigo',
	'ur-add-sent-title-foe' => 'Hemos enviado su solicitud de enemigo a $1!',
	'ur-add-sent-title-friend' => 'Hemos enviado su solicitud de amigo a $1!',
	'ur-add-sent-message-foe' => 'Tu solicitud de enemigo ha sido enviada a $1 para ser confirmada.
Si $1 confirma tu solicitud, recibirás un segundo e-mail',
	'ur-add-sent-message-friend' => 'Tu solicitud de amigo ha sido enviada a $1 para ser confirmada.
Si $1 confirma tu solicitud, recibirás un segundo e-mail',
	'ur-add-error-message-no-user' => 'El usuario que está tratando de agregar no existe.',
	'ur-add-error-message-blocked' => 'Usted está actualmente bloqueado y no puede agregar amigos o enemigos.',
	'ur-add-error-message-yourself' => 'No puede agregarse a sí mismo como amigo o enemigo.',
	'ur-add-error-message-existing-relationship-foe' => 'Ustedes ya son enemigos con $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Ustedes ya son amigos con $1.',
	'ur-add-error-message-pending-request-title' => '¡Paciencia!',
	'ur-add-error-message-pending-friend-request' => 'Usted tiene una solucitud de amigo pendiente con $1.
Le notificaremos cuando $1 confirme su solicitud.',
	'ur-add-error-message-pending-foe-request' => 'Usted tiene una solucitud de enemigo pendiente con $1.
Le notificaremos cuando $1 confirme su solicitud.',
	'ur-add-error-message-not-loggedin-foe' => 'Debes haber iniciado sesión para añadir un enemigo',
	'ur-add-error-message-not-loggedin-friend' => 'Debes haber iniciado sesión para añadir un amigo',
	'ur-requests-title' => 'Solicitudes de relación',
	'ur-requests-message-foe' => '<a href="$1">$2</a> desea ser su enemigo.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> desea ser su amigo.',
	'ur-accept' => 'Aceptar',
	'ur-reject' => 'Rechazar',
	'ur-no-requests-message' => 'No tiene solicitudes de amigo o enemigo.
Si usted desea más amigos, <a href="$1">invítelos!</a>',
	'ur-requests-added-message-foe' => 'Usted ha agregado a $1 como su enemigo.',
	'ur-requests-added-message-friend' => 'Usted ha agregado a $1 como su amigo.',
	'ur-requests-reject-message-friend' => 'Usted ha rechazado a $1 como su amigo.',
	'ur-requests-reject-message-foe' => 'Usted ha rechazado a $1 como su enemigo.',
	'ur-title-foe' => 'lista de enemigos de $1',
	'ur-title-friend' => 'lista de amigos de $1',
	'friend_request_subject' => '$1 lo ha agragado como amigo en {{SITENAME}}!',
	'friend_request_body' => 'Hola $1.

$2 te ha agregado como un amigo en {{SITENAME}}. Queremos estar seguros que ustedes dos son realmente amigos.

Por favor haga click en este vínculo para confirmar su amistad:
$3

Gracias

---

Hey, Desea no recibir correos electrónicos de nosotros?

Haga click en $4
y cambie sus configuraciones para deshabilitar notificaciones por correo electrónico.',
	'foe_request_subject' => 'Esto es guerra! $1 lo ha agregado como un enemigo en {{SITENAME}}!',
	'foe_request_body' => 'Hola $1.

$2 acaba de listarte como un enemigo en {{SITENAME}}. Queremos estar seguros que ustedes dos son mortales enemigos o al menos que tiene un pleito.

Por favor haga click en este vínculo para confirmar la hostilidad:

$3

Gracias

---

Hey, Desea no recibir correos electrónicos de nosotros?

Haga click en $4
y cambie sus configuraciones para deshabilitar notificaciones por correo electrónico.',
	'friend_accept_subject' => '$1 ha aceptado su solicitud de amigo en {{SITENAME}}!',
	'friend_accept_body' => 'Hola $1.

$2 ha aceptado su solicitud de amigo en {{SITENAME}}!

verifique la página de $2 en $3

Gracias

---

Hey, Desea no recibir correos electrónicos de nosotros?

Haga click en $4
y cambie sus configuraciones para deshabilitar notificaciones por correo electrónico.',
	'foe_accept_subject' => 'Listo! $1 ha aceptado su solicitud de enemigo en {{SITENAME}}!',
	'foe_accept_body' => 'Hola $1.

$2 ha aceptado su solicitud de enemigo en {{SITENAME}}!

verifique la página de $2 en $3

Gracias

---

Hey, Desea no recibir correos electrónicos de nosotros?

Haga click en $4
y cambie sus configuraciones para deshabilitar notificaciones por correo electrónico.',
	'friend_removed_subject' => '¡Oh, no! ¡$1 le ha quitado como amigo en {{SITENAME}}!',
	'friend_removed_body' => 'Hola $1.

¡$2 te ha quitado como amigo en {{SITENAME}}!

Gracias

---

Hey, ¿deseas dejar de recibir mensajes de correo electrónico nuestros?

Haz click en $4
y cambia tus configuraciones para deshabilitar las notificaciones por correo electrónico.',
	'foe_removed_subject' => '¡Yuju! ¡$1 lo ha eliminado como enemigo en {{SITENAME}}!',
	'foe_removed_body' => 'Hola $1.

¡$2 te ha quitado como enemigo en {{SITENAME}}!

¿Tal vez estais en camino de convertiros en amigos?

Gracias

---

Hey, ¿deseas dejar de recibir correos electrónicos nuestros?

Haz click en $4
y cambia tus configuraciones para deshabilitar notificaciones por correo electrónico.',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Hendrik
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'ur-already-submitted' => 'Sinu taotlus on saadetud',
	'ur-error-page-title' => 'Ups!',
	'ur-main-page' => 'Esileht',
	'ur-your-profile' => 'Sinu profiil',
	'ur-add-friend' => 'Lisa sõbraks',
	'ur-add-foe' => 'Lisa vaenlaseks',
	'ur-add-personal-message' => 'Lisa isiklik teade',
	'ur-remove-relationship-friend' => 'Kustuta sõprade hulgast',
	'ur-remove-relationship-foe' => 'Kustuta vaenlaste hulgast',
	'ur-give-gift' => 'Anna kingitus',
	'ur-previous' => 'eel',
	'ur-next' => 'järg',
	'ur-remove-relationship-title-foe' => 'Kas soovid eemaldada kasutaja $1 oma vaenlaste hulgast?',
	'ur-remove-relationship-title-confirm-foe' => 'Oled eemaldanud kasutaja $1 oma vaenlaste hulgast',
	'ur-remove-relationship-title-friend' => 'Kas soovid eemaldada kasutaja $1 oma sõprade hulgast?',
	'ur-remove-relationship-title-confirm-friend' => 'Oled eemaldanud kasutaja $1 oma sõprade hulgast',
	'ur-remove-relationship-message-confirm-foe' => 'Oled edukalt eemaldanud kasutaja $1 oma vaenlaste hulgast.',
	'ur-remove-relationship-message-confirm-friend' => 'Oled edukalt eemaldanud kasutaja $1 oma sõprade hulgast.',
	'ur-remove-error-message-remove-yourself' => 'Ennast ei saa eemaldada.',
	'ur-remove' => 'Eemalda',
	'ur-cancel' => 'Loobu',
	'ur-login' => 'Logi sisse',
	'ur-add-title-foe' => 'Kas soovid lisada kasutaja $1 oma vaenlaseks?',
	'ur-add-title-friend' => 'Kas soovid lisada kasutaja $1 oma sõbraks?',
	'ur-add-button-foe' => 'Lisa vaenlaseks',
	'ur-add-button-friend' => 'Lisa sõbraks',
	'ur-add-error-message-existing-relationship-friend' => 'Sa oled kasutajaga $1 juba sõber.',
	'ur-add-error-message-pending-request-title' => 'Kannatust!',
	'ur-add-error-message-not-loggedin-friend' => 'Sõbra lisamiseks pead olema sisse logitud',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'ur-already-submitted' => 'Zure eskaera bidali da',
	'ur-error-page-title' => 'Iepa!',
	'ur-error-message-no-user' => 'Ezin dugu zure eskaera bete, ez dago izen hori duen erabiltzailerik.',
	'ur-main-page' => 'Azala',
	'ur-your-profile' => 'Zure perfila',
	'ur-backlink' => '&lt; $1(r)en profilera itzuli',
	'ur-relationship-count-foes' => '$1(e)k {{PLURAL:$2|etsai $2 du|$2 etsai ditu}}.
Etsai gehiagorik nahi?
<a href="$3">Gonbida itzazu.</a>',
	'ur-relationship-count-friends' => '$1(e)k {{PLURAL:$2|lagun $2 du|$2 lagun ditu}}.
Lagun gehiagorik nahi?
<a href="$3">Gonbida itzazu.</a>',
	'ur-add-friends' => 'Lagun gehiago nahi? <a href="$1">Gonbida itzazu</a>',
	'ur-add-friend' => 'Lagun bezala gehitu',
	'ur-add-foe' => 'Etsai bezala gehitu',
	'ur-add-personal-message' => 'Mezu pertsonala bidali',
	'ur-remove-relationship-friend' => 'Lagun bezala kendu',
	'ur-remove-relationship-foe' => 'Etsai bezala kendu',
	'ur-give-gift' => 'Oparia eman',
	'ur-previous' => 'aurreko',
	'ur-next' => 'hurrengo',
	'ur-remove-error-not-loggedin-foe' => 'Etsai bat zerrendatik kentzeko saioa hasi behar duzu.',
	'ur-remove-error-not-loggedin-friend' => 'Lagun bat zerrendatik kentzeko saioa hasi behar duzu.',
	'ur-remove' => 'Kendu',
	'ur-cancel' => 'Utzi',
	'ur-login' => 'Saioa hasi',
	'ur-add-title-foe' => '$1 zure etsaia bezala gehitu nahi al duzu?',
	'ur-add-title-friend' => '$1 zure laguna bezala gehitu nahi al duzu?',
	'ur-add-button-foe' => 'Etsai bezala gehitu',
	'ur-add-button-friend' => 'Lagun bezala gehitu',
	'ur-add-sent-title-foe' => '$1 lankideari zure etsaia izateko eskaera bidali diogu!',
	'ur-add-sent-title-friend' => '$1 lankideari zure laguna izateko eskaera bidali diogu!',
	'ur-add-error-message-existing-relationship-foe' => 'Jada $1 lankidearen etsaia zara.',
	'ur-add-error-message-existing-relationship-friend' => 'Jada $1 lankidearen laguna zara.',
	'ur-add-error-message-pending-request-title' => 'Pazientzia!',
	'ur-add-error-message-not-loggedin-friend' => 'Lagun bat gehitzeko saioa hasi behar duzu',
	'ur-requests-message-foe' => '<a href="$1">$2(e)k</a> zure etsaia izan nahi du.',
	'ur-requests-message-friend' => '<a href="$1">$2(e)k</a> zure laguna izan nahi du.',
	'ur-accept' => 'Onartu',
	'ur-reject' => 'Deuseztu',
	'ur-no-requests-message' => 'Ez duzu ez lagun ez etsai eskaerarik. Lagun gehiago izan nahi badituzu, <a href="$1">gonbida itzazu!</a>',
	'ur-requests-added-message-foe' => '$1 zure etsai bezala gehitu duzu.',
	'ur-requests-added-message-friend' => '$1 zure lagun bezala gehitu duzu.',
	'ur-title-foe' => '$1(r)en etsai zerrenda',
	'ur-title-friend' => '$1-(r)en lagun zerrenda',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'ur-main-page' => 'صفحهٔ اصلی',
	'ur-previous' => 'قبلی',
	'ur-next' => 'بعدی',
	'ur-remove' => 'حذف',
	'ur-cancel' => 'انصراف',
	'ur-login' => 'ورود',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
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
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Verdy p
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
	'ur-relationship-count-foes' => '$1 a $2 ennemi{{PLURAL:$2||s}}.
En vouloir encore plus ?
<a href="$3">Inviter les.</a>',
	'ur-relationship-count-friends' => '$1 a $2 ami{{PLURAL:$2||s}}.
En vouloir encore plus ?
<a href="$3">Inviter les.</a>',
	'ur-add-friends' => 'Vouloir plus d’amis ? <a href="$1">Inviter les</a>.',
	'ur-add-friend' => 'Ajouter comme ami',
	'ur-add-foe' => 'Ajouter comme ennemi',
	'ur-add-no-user' => 'Aucun utilisateur sélectionné. Veuillez requérir des amis ou des ennemis au travers du lien correct.',
	'ur-add-personal-message' => 'Ajouter un message personnel',
	'ur-remove-relationship-friend' => 'Enlever comme ami',
	'ur-remove-relationship-foe' => 'Enlever comme ennemi',
	'ur-give-gift' => 'Envoyer un cadeau',
	'ur-previous' => 'préc.',
	'ur-next' => 'suivant',
	'ur-remove-relationship-title-foe' => 'Voulez-vouz enlever $1 comme votre ennemi ?',
	'ur-remove-relationship-title-confirm-foe' => 'Vous avez enlevé $1 de vos ennemis',
	'ur-remove-relationship-title-friend' => 'Voulez-vous enlever $1 comme votre ami ?',
	'ur-remove-relationship-title-confirm-friend' => 'Vous avez enlevé $1 de vos amis.',
	'ur-remove-relationship-message-foe' => 'vous avez requis la suppression de $1 en tant qu’ennemi, appuyez sur « $2 » pour confirmer.',
	'ur-remove-relationship-message-confirm-foe' => 'Vous avez enlevé $1 avec succès de vos ennemis.',
	'ur-remove-relationship-message-friend' => 'Vous avez requis la suppression de $1 de vos amis, appuyer sur « $2 » pour confirmer.',
	'ur-remove-relationship-message-confirm-friend' => 'Vous enlevé $1 avec succès de vos amis.',
	'ur-remove-error-message-no-relationship' => 'Vous n’avez aucune relation avec $1.',
	'ur-remove-error-message-remove-yourself' => 'Vous ne pouvez pas vous supprimer vous-même.',
	'ur-remove-error-message-pending-foe-request' => 'Vous avez, en cours, une requête d’un ennemi avec $1.',
	'ur-remove-error-message-pending-friend-request' => 'Vous avez, en cours, une requête d’un ami avec $1.',
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
	'ur-add-button-foe' => 'Ajouter comme ennemi',
	'ur-add-button-friend' => 'Ajouter comme ami',
	'ur-add-sent-title-foe' => 'Vous avez envoyé déclaration d’hostilité à $1 !',
	'ur-add-sent-title-friend' => 'Vous avez envoyé déclaration d’amitié à $1 !',
	'ur-add-sent-message-foe' => 'Votre requête en hostilité a été envoyée à $1 pour confirmation.
Si $1 confirme votre demande, vous recevrez le suivi par courriel.',
	'ur-add-sent-message-friend' => 'Votre requête en amitié a été envoyée à $1 pour confirmation.
Si $1 confirme votre demande, vous recevrez le suivi par courriel.',
	'ur-add-error-message-no-user' => 'L’utilisateur que vous être en train d’ajouter n’existe pas.',
	'ur-add-error-message-blocked' => 'Vous êtes actuellement bloqué{{GENDER:||e|(e)}} et vous ne pouvez donc ajouter ni amis ni ennemis.',
	'ur-add-error-message-yourself' => 'Vous ne pouvez vous-même vous ajouter comme ennemi ou ami.',
	'ur-add-error-message-existing-relationship-foe' => 'Vous êtes déjà l’ennemi de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'vous êtes déjà l’ami de $1.',
	'ur-add-error-message-pending-request-title' => 'Patience !',
	'ur-add-error-message-pending-friend-request' => 'Vous avez une demande d’amitié en cours avec $1.
Nous vous notifierons si $1 confirme votre requête.',
	'ur-add-error-message-pending-foe-request' => 'Vous avez une déclaration d’hostilité en cours avec $1.
Nous vous notifierons si $1 confirme votre requête.',
	'ur-add-error-message-not-loggedin-foe' => 'Vous devez être connecté pour ajouter un ennemi',
	'ur-add-error-message-not-loggedin-friend' => 'Vous devez être connecté pour ajouter un ami',
	'ur-requests-title' => 'Demandes de relations.',
	'ur-requests-message-foe' => '<a href="$1">$2</a> veut être votre ennemi.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> veut être votre ami.',
	'ur-accept' => 'Accepter',
	'ur-reject' => 'Rejeter',
	'ur-no-requests-message' => 'Vous n’avez aucune requête en ami ou ennemi. Si vous désirez plus d’amis, <a href="$1">invitez les !</a>',
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
	'foe_request_subject' => 'C’est la guerre ! $1 vous a ajouté comme ennemi sur {{SITENAME}} !',
	'foe_request_body' => 'Salut $1 :

$2 vient juste de vous répertorier comme un ennemi sur {{SITENAME}}. Nous voulons nous assurer que vous êtes vraiment des ennemis mortel ou avoir au moins des griefs l’un envers l’autre.

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
	'foe_accept_subject' => 'C’est fait ! $1 a accepté votre déclaration de guerre sur  {{SITENAME}} !',
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

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'viewrelationships' => 'Vêre les relacions',
	'viewrelationshiprequests' => 'Vêre les requétes de les relacions',
	'ur-already-submitted' => 'Voutra requéta at étâ mandâ',
	'ur-error-page-title' => 'Chancro !',
	'ur-main-page' => 'Reçua',
	'ur-your-profile' => 'Voutron profil',
	'ur-backlink' => '&lt; Retôrn de vers les enformacions de $1',
	'ur-relationship-count-foes' => '$1 at $2 ènemi{{PLURAL:$2||s}}.
Nen voléd-vos adés més ?
<a href="$3">Envitâd-los !</a>',
	'ur-relationship-count-friends' => '$1 at $2 ami{{PLURAL:$2||s}}.
Nen voléd-vos adés més ?
<a href="$3">Envitâd-los !</a>',
	'ur-add-friends' => 'Voléd-vos més d’amis ?
<a href="$1">Envitâd-los !</a>',
	'ur-add-friend' => 'Apondre coment ami',
	'ur-add-foe' => 'Apondre coment ènemi',
	'ur-add-personal-message' => 'Apondre un mèssâjo a sè',
	'ur-remove-relationship-friend' => 'Enlevar coment ami',
	'ur-remove-relationship-foe' => 'Enlevar coment ènemi',
	'ur-give-gift' => 'Balyér un present',
	'ur-previous' => 'devant',
	'ur-next' => 'aprés',
	'ur-remove' => 'Enlevar',
	'ur-cancel' => 'Anular',
	'ur-login' => 'Branchement',
	'ur-add-button-foe' => 'Apondre coment ènemi',
	'ur-add-button-friend' => 'Apondre coment ami',
	'ur-add-error-message-pending-request-title' => 'Pacience !',
	'ur-requests-title' => 'Requétes de relacions',
	'ur-requests-message-foe' => '<a href="$1">$2</a> vôt étre voutron ènemi.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> vôt étre voutron ami.',
	'ur-accept' => 'Accèptar',
	'ur-reject' => 'Refusar',
	'ur-requests-added-message-foe' => 'Vos éd apondu $1 coment voutron ènemi.',
	'ur-requests-added-message-friend' => 'Vos éd apondu $1 coment voutron ami.',
	'ur-requests-reject-message-friend' => 'Vos éd refusâ $1 coment voutron ami.',
	'ur-requests-reject-message-foe' => 'Vos éd refusâ $1 coment voutron ènemi.',
	'ur-title-foe' => 'Lista ux ènemis a $1',
	'ur-title-friend' => 'Lista ux amis a $1',
	'friend_request_subject' => '$1 vos at apondu coment un ami dessus {{SITENAME}} !',
	'foe_request_subject' => 'O est la guèrra ! $1 vos at apondu coment un ènemi dessus {{SITENAME}} !',
	'friend_accept_subject' => '$1 at accèptâ voutra requéta en amitiêt dessus {{SITENAME}} !',
	'foe_accept_subject' => 'O est fêt ! $1 at accèptâ voutra dècllaracion de guèrra dessus {{SITENAME}} !',
	'friend_removed_subject' => 'Chancro ! $1 vos at enlevâ de la lista a sos amis dessus {{SITENAME}} !',
	'foe_removed_subject' => 'Crenom ! $1 vos at enlevâ de la lista a sos ènemis dessus {{SITENAME}} !',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'ur-main-page' => 'Haadside',
	'ur-cancel' => 'Ofbrekke',
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
	'ur-backlink' => '&lt; Volver ao perfil de $1',
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
	'ur-remove-error-message-pending-foe-request' => 'Ten unha solicitude de inimizade pendente con $1.',
	'ur-remove-error-message-pending-friend-request' => 'Ten unha solicitude de amizade pendente con $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Xa é inimigo de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Xa é amigo de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciencia!',
	'ur-add-error-message-pending-friend-request' => 'Ten unha solicutude de amizade pendente con $1.
Notificarémoslle cando $1 a confirme.',
	'ur-add-error-message-pending-foe-request' => 'Ten unha solicutude de inimizade pendente con $1.
Notificarémoslle cando $1 a confirme.',
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
	'ur-title-foe' => 'Lista de inimigos de $1',
	'ur-title-friend' => 'Lista de amigos de $1',
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
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'ur-main-page' => 'Κυρία Δέλτος',
	'ur-next' => 'ἑπόμεναι',
	'ur-remove' => 'Άφαιρεῖν',
	'ur-cancel' => 'Ἀκυροῦν',
	'ur-login' => 'Συνδεῖσθαι',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'viewrelationships' => 'Zeig Beziejige',
	'viewrelationshiprequests' => 'Zeig Beziejigsaafroge',
	'ur-already-submitted' => 'Dyy Aafrog isch abschickt wore',
	'ur-error-page-title' => 'Hoppla!',
	'ur-error-title' => 'Hoppla, do goht s nit wyter!',
	'ur-error-message-no-user' => 'Mir chenne d Aafrog nit uusfiere, wel s kei Benutzer mit däm Name git.',
	'ur-main-page' => 'Hauptsyte',
	'ur-your-profile' => 'Dyy Profil',
	'ur-backlink' => '&lt; Zrugg zum Profil vu $1',
	'ur-relationship-count-foes' => '$1 het {{PLURAL:$2|ei Fynd|$2 Fynd}}. Witt meh Fynd? <a href="$3">Lad si yy.</a>',
	'ur-relationship-count-friends' => '$1 het {{PLURAL:$2|ei Frynd|$2 Frynde}}. Witt meh Frynd? <a href="$3">Lad si yy.</a>',
	'ur-add-friends' => 'Witt meh Frynd? <a href="$1">Lad si yy.</a>',
	'ur-add-friend' => 'As Frynd zuefiege',
	'ur-add-foe' => 'As Fynd zuefiege',
	'ur-add-no-user' => 'Kei Benutzer uusgwehlt.
Bitte wehl d Frynd/Fynd dur s rächt Gleich.',
	'ur-add-personal-message' => 'E persenligi Nochricht zuefiege',
	'ur-remove-relationship-friend' => 'Us dr Fryndlischt useneh',
	'ur-remove-relationship-foe' => 'Us dr Fyndlischt useneh',
	'ur-give-gift' => 'Gschänk schicke',
	'ur-previous' => 'vorigi',
	'ur-next' => 'negschti',
	'ur-remove-relationship-title-foe' => 'Witt $1 us Dyynere Fyndlischt lesche?',
	'ur-remove-relationship-title-confirm-foe' => 'Du hesch $1 us Dyynere Fyndlischt glescht.',
	'ur-remove-relationship-title-friend' => 'Witt $1 us Dyynere Fryndlischt lesche',
	'ur-remove-relationship-title-confirm-friend' => 'Du hesch $1 us Dyynere Fryndlischt glescht.',
	'ur-remove-relationship-message-foe' => 'Witt $1 us Dyynere Fyndlischt lesche? Druck „$2“ fir zum bstätige.',
	'ur-remove-relationship-message-confirm-foe' => 'Du hesch $1 erfolgryych us Dyynere Fyndlischt glescht.',
	'ur-remove-relationship-message-friend' => 'Witt $1 us Dyynere Fryndlischt lesche? Druck „$2“ fir zum bstätige.',
	'ur-remove-relationship-message-confirm-friend' => 'Du hesch $1 erfolgryych us Dyynere Fryndlischt usegnuh.',
	'ur-remove-error-message-no-relationship' => 'S git kei Beziejig zwische $1 un Dir.',
	'ur-remove-error-message-remove-yourself' => 'Du chasch Di nit sälber useneh.',
	'ur-remove-error-message-pending-foe-request' => 'Du hesch no ne ufigi Fyndschaftaafrog vu $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du hesch no ne ufigi Fryndschaftsaafrog vu $1.',
	'ur-remove-error-not-loggedin-foe' => 'Du muesch aagmäldet syy go ne Fynd lesche.',
	'ur-remove-error-not-loggedin-friend' => 'Du muesch aagmäldet syy go ne Frynd lesche.',
	'ur-remove' => 'Lesche',
	'ur-cancel' => 'Abbräche',
	'ur-login' => 'Aamälde',
	'ur-add-title-foe' => 'Witt $1 in Dyyni Fyndlischt yyneneh?',
	'ur-add-title-friend' => 'Witt $1 in Dyyni Fryndlischt yyneneh?',
	'ur-add-message-foe' => 'Du bisch grad am $1 in Dyyni Fyndlischt yyneneh.
Mir leen $1 Dyyni Wuet zuechu.',
	'ur-add-message-friend' => 'Du bisch grad am $1 in Dyyni Fryndlischt yyneneh.
Mir leen is des vu $1 bstätige.',
	'ur-add-button-foe' => 'As Fynd zuefiege',
	'ur-add-button-friend' => 'As Frynd zuefiege',
	'ur-add-sent-title-foe' => 'Mir hän Dyyni Fyndschaftsaafrog an $1 gschickt!',
	'ur-add-sent-title-friend' => 'Mir hän Dyyni Fryndschaftsaafrog an $1 gschickt!',
	'ur-add-sent-message-foe' => 'Dyyni Fyndschaftsaafrog isch an $1 zum Bstätige gschickt wore.
Du chunnsch e E-Mail iber, wänn $1 Dyyni Aafrog bstätigt.',
	'ur-add-sent-message-friend' => 'Dyyni Fyyndschaftsaafrog isch an $1 zum Bstätige gschickt wore.
Du chunnsch e E-Mail iber, wänn $1 Dyyni Aafrog bstätigt.',
	'ur-add-error-message-no-user' => 'Dä Benutzer, wu Du witt dezueneh, git s nit.',
	'ur-add-error-message-blocked' => 'Du bisch im Momänt gsperrt un chasch kei Frynd oder Fynd dezueneh.',
	'ur-add-error-message-yourself' => 'Du chasch Di nit sälber as Frynd oder Fynd dezueneh.',
	'ur-add-error-message-existing-relationship-foe' => 'Du bisch scho Fynd mit $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du bisch scho Frynd mit $1.',
	'ur-add-error-message-pending-request-title' => 'Nume nit huttle!',
	'ur-add-error-message-pending-friend-request' => 'Du hesch no ne ufigi Fryndschaftsaafrog vu $1.
Mir informiere $1, wänn Du syyni Aafrog bstätigsch.',
	'ur-add-error-message-pending-foe-request' => 'Du hesch no ne ufigi Fyndschaftsaafrog vu $1.
Mir informiere $1, wänn Du syyni Aafrog bstätigsch.',
	'ur-add-error-message-not-loggedin-foe' => 'Du muesch aagmäldet syy go ne Fynd dezueneh.',
	'ur-add-error-message-not-loggedin-friend' => 'Du muesch aagmäldet syy go ne Frynd dezueneh.',
	'ur-requests-title' => 'Beziejigsaafrog',
	'ur-requests-message-foe' => '<a href="$1">$2</a> wet Dyy Fynd syy.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> wet Dyy Frynd syy.',
	'ur-accept' => 'Aaneh',
	'ur-reject' => 'Ablähne',
	'ur-no-requests-message' => 'Du hesch kei Frynd- oder Fynd-Aafrog. Wänn Du meh Frynd witt haa, <a href="$1">Lad si yy!</a>',
	'ur-requests-added-message-foe' => 'Du hesch $1 in Dyyni Fyndlischt yygnuh.',
	'ur-requests-added-message-friend' => 'Du hesch $1 in Dyyni Fryndlischt yynegnuh.',
	'ur-requests-reject-message-friend' => 'Du hesch $1 as Frynd zrugg gwise.',
	'ur-requests-reject-message-foe' => 'Du hesch $1 as Fynd zrugg gwise.',
	'ur-title-foe' => 'Fyndlischt vu $1',
	'ur-title-friend' => 'Fryndlischt $1',
	'friend_request_subject' => '{{SITENAME}}: $1 het Di as Frynd dezuegnuh!',
	'friend_request_body' => 'Sali $1:

$2 het Di uf {{SITENAME}} as Frynd dezuegnuh. Mir wän aber sicher goh, ass Ihr zwei wirkli Frynd sin.

Bitte druck des Gleich go Ejri Fryndschaft bstätige:
$3

---

Ha, Du witt gar kei E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abschalte.',
	'foe_request_subject' => 'S isch Chrieg! $1 het Di as Fynd yynegnuh uf {{SITENAME}}!',
	'foe_request_body' => 'Sali $1:

$2 het Di uf {{SITENAME}} as Fynd dezuegnuh. Mir wän aber sicher goh, ass Ihr zwei wirkli grusigi Fynd sin.

Bitte druck des Gleich go Ejri Fyndschaft bstätige:

$3

---

Ha, Du witt gar kei E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abschalte.',
	'friend_accept_subject' => '$1 het Dyyni Fryndschaftsaaffrog aagnuh uf {{SITENAME}}!',
	'friend_accept_body' => 'Sali $1:

$2 het Dyyni Fryndschaftsaafrog uf {{SITENAME}} bstätigt!

Lueg d Syte vu $2: $3

Dankschen!

---

Ha, Du witt gar kei E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abschalte.',
	'foe_accept_subject' => '{{SITENAME}}: $1 het Dyyni Fyndschaftsaafrog bstätigt!',
	'foe_accept_body' => 'Sali $1:

$2 het Dyyni Fyndschaftsaafrog uf {{SITENAME}} bstätigt!

Lueg d Syte vu $2: $3

Dankschen!

---

Ha, Du witt gar kei E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abschalte.',
	'friend_removed_subject' => '{{SITENAME}}: He nei! $1 isch nimmi Dyy Frynd!',
	'friend_removed_body' => 'Sali $1:

$2 het ufghert mit syynere Fryndschaft mit Dir uf {{SITENAME}}!

---

Ha, Du witt gar kei E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abschalte.',
	'foe_removed_subject' => '{{SITENAME}}: Hoi! $1 het ufghert mit syynere Fyndschaft zue Dir!',
	'foe_removed_body' => 'Sali $1:

$2 het ufghert mit syynere Fyndschaft mit Dir uf {{SITENAME}}!

Villicht gän Ihr jo sogar emol Frynd?

---

Ha, Du witt gar kei E-Mail meh vun is iberchu?

Druck $4
un ändere Dyyni Yystellige go d E-Mail-Benochrichtigunge abschalte.',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'ur-cancel' => 'Soke',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'ur-main-page' => 'Thèu-chông',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'ur-remove' => 'Kāpae',
	'ur-login' => 'ʻEʻe',
);

/** Hebrew (עברית)
 * @author Amire80
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
	'ur-remove-error-message-pending-foe-request' => 'יש לכם בקשת יריבות אחת עם $1.',
	'ur-remove-error-message-pending-friend-request' => 'יש לכם בקשת חברות ממתינה עם $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'אתם ו־$1 כבר יריבים.',
	'ur-add-error-message-existing-relationship-friend' => 'אתם ו־$1 כבר חברים.',
	'ur-add-error-message-pending-request-title' => 'סבלנות!',
	'ur-add-error-message-pending-friend-request' => 'יש לכם בקשת חברות ממתינה עם $1.
אתם תקבלו הודעה כש־$1 יאשר את בקשתכם.',
	'ur-add-error-message-pending-foe-request' => 'יש לכם בקשת יריבות ממתינה עם $1.
אתם תקבלו הודעה כש־$1 יאשר את בקשתכם.',
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
	'friend_request_body' => 'שלום $1:

$2 הוסיף אתכם כחבר ב{{grammar:תחילית|{{SITENAME}}}}.  רצינו לוודא ששניכם אכן חברים.

אנא לחצו על קישור זה כדי לאשר שאתם חברים:
$3

תודה

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'foe_request_subject' => 'זוהי מלחמה! $1 הוסיף אתכם כיריב ב{{grammar:תחילית|{{SITENAME}}}}!',
	'foe_request_body' => 'שלום $1:

$2 הוסיף אתכם כיריב ב{{grammar:תחילית|{{SITENAME}}}}. רצינו רק לוודא ששניכם אכן יריבים עד המוות או לפחות נמצאים בוויכוח.

אנא לחצו על קישור זה כדי לאמת את שידוך האיבה.

$3

תודה

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'friend_accept_subject' => '$1 קיבל את בקשת החברות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!',
	'friend_accept_body' => 'שלום $1:

$2 קיבל את בקשת החברות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!

עיינו בדף של $2 ב־$3

תודה

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'foe_accept_subject' => 'המלחמה החלה! $1 קיבל את בקשת היריבות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!',
	'foe_accept_body' => 'שלום $1:

$2 קיבל את בקשת היריבות שלכם ב{{grammar:תחילית|{{SITENAME}}}}!

עיינו בדף של $2 ב־$3

תודה

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'friend_removed_subject' => 'אבוי! $1 הסיר אתכם כחברו ב{{grammar:תחילית|{{SITENAME}}}}!',
	'friend_removed_body' => 'שלום $1:

$2 הסיר את החברות ביניכם ב{{grammar:תחילית|{{SITENAME}}}}!

תודה

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

לחצו $4
ושנו את ההגדרות שלכם כדי לבטל התרעות בדוא"ל.',
	'foe_removed_subject' => 'ישששש! $1 הסיר אתכם כיריבו ב{{grammar:תחילית|{{SITENAME}}}}!',
	'foe_removed_body' => 'שלום $1:

$2 הסיר אתכם כיריבו ב{{grammar:תחילית|{{SITENAME}}}}!

האם שניכם בדרך להפוך לחברים?

תודה

---

רוצים להפסיק לקבל מאיתנו הודעות דוא"ל?

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

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'viewrelationships' => 'Poćah sej wobhladać',
	'viewrelationshiprequests' => 'Poćahowe naprašowanja sej wobhladać',
	'ur-already-submitted' => 'Twoje naprašowanje bu wotposłane',
	'ur-error-page-title' => 'Hopla!',
	'ur-error-title' => 'Hopla, sy něšto wopak činił!',
	'ur-error-message-no-user' => 'Njemóžemy twoje naprašowanje wuwjesć, dokelž wužiwar z tutym mjenom njeeksistuje.',
	'ur-main-page' => 'Hłowna strona',
	'ur-your-profile' => 'Twój profil',
	'ur-backlink' => '&lt; Wróćo k profilej wužiwarja $1',
	'ur-relationship-count-foes' => '$1 ma $2 {{PLURAL:$2|njepřećela|njepřećelow|njepřećelow|njepřećelow}}.
Chceš dalšich njepřećelow?
<a href="$3">Přeproš jich.</a>',
	'ur-relationship-count-friends' => '$1 ma $2 {{PLURAL:$2|přećela|přećelow|přećelow|přećelow}}.
Coš dalšich přećelow?
<a href="$3">Přeproš jich.</a>',
	'ur-add-friends' => 'Coš dalšich přećelow?
<a href="$1">Přeproš jich</a>',
	'ur-add-friend' => 'Jako přećela přidać',
	'ur-add-foe' => 'Jako njepřećela přidać',
	'ur-add-no-user' => 'Žadyn wužiwar wubrany.
Prošu wubjer přećelow/njepřećelow přez prawy wotkaz.',
	'ur-add-personal-message' => 'Wosobinsku powěsć přidać',
	'ur-remove-relationship-friend' => 'Jako přećela wotstronić',
	'ur-remove-relationship-foe' => 'Jako njepřećela wotstronić',
	'ur-give-gift' => 'Darić',
	'ur-previous' => 'předchadny',
	'ur-next' => 'přichodny',
	'ur-remove-relationship-title-foe' => 'Chceš $1 jako swojeho njepřećela wotstronić?',
	'ur-remove-relationship-title-confirm-foe' => 'Sy $1 jako swojeho njepřećela wotstronił',
	'ur-remove-relationship-title-friend' => 'Chceš $1 jako swojeho přećela wotstronić?',
	'ur-remove-relationship-title-confirm-friend' => 'Sy $1 jako swojeho přećela wotstronił',
	'ur-remove-relationship-message-foe' => 'Sy požadał $1 jako swojeho njepřećela wotstronić, tłóč na "$2", zo by wobkrućił.',
	'ur-remove-relationship-message-confirm-foe' => 'Sy $1 wuspěšnje jako swojeho njepřećela wotstronił.',
	'ur-remove-relationship-message-friend' => 'Sy požadał $1 jako swojeho přećela wotstronić, tłóč "$2", zo by wobkrućił.',
	'ur-remove-relationship-message-confirm-friend' => 'Sy $1 wuspěšnje jako swojeho přećela wotstronił.',
	'ur-remove-error-message-no-relationship' => 'Nimaš poćah k $1.',
	'ur-remove-error-message-remove-yourself' => 'Njemóžeš sebje wotstronić.',
	'ur-remove-error-message-pending-foe-request' => 'Maš njesčinjene naprašowanje na njepřećelstwo z $1.',
	'ur-remove-error-message-pending-friend-request' => 'Maš njesčinjene naprašowanje na přećelstwo z $1.',
	'ur-remove-error-not-loggedin-foe' => 'Dyrbiš přizjewjeny być, zo by njepřećela wotstronił.',
	'ur-remove-error-not-loggedin-friend' => 'Dyrbiš přizjewjeny być, zo by přećela wotstronił.',
	'ur-remove' => 'Wotstronić',
	'ur-cancel' => 'Přetorhnyć',
	'ur-login' => 'Přizjewjenje',
	'ur-add-title-foe' => 'Chceš $1 jako swojeho njepřećela přidać?',
	'ur-add-title-friend' => 'Chceš $1 jako swojeho přećela přidać?',
	'ur-add-message-foe' => 'Chceš runje $1 jako swojeho njepřećela přidać.
Budźemy $1 informować, zo bychmy twój hněw wobkrućili.',
	'ur-add-message-friend' => 'Chceš runje $1 jako swojeho přećela přidać.
Budźemy $1 informować, zo bychmy twoje přećelstwo wobkrućili.',
	'ur-add-button-foe' => 'Jako njepřećela přidać',
	'ur-add-button-friend' => 'Jako přećela přidać',
	'ur-add-sent-title-foe' => 'Smy wužiwarjej $1 twoje njepřećelske naprašowanje pósłali!',
	'ur-add-sent-title-friend' => 'Smy wužiwarjej $1 twoje přećelske naprašowanje pósłali!',
	'ur-add-sent-message-foe' => 'Twoje njepřećelske naprašowanje bu wužiwarjej $1 za wobkrućenje pósłane.
Jeli $1 twoje naprašowanje wobkruća, dóstanješ wotmołwnu e-mejl.',
	'ur-add-sent-message-friend' => 'Twoje přećelske naprašowanje bu wužiwarjej $1 za wobkrućenje pósłane.
Jeli $1 twoje naprašowanje wobkruća, dóstanješ wotmołwnu e-mejl.',
	'ur-add-error-message-no-user' => 'Wužiwar, kotrehož pospytuješ přidać, njeeksistuje.',
	'ur-add-error-message-blocked' => 'Sy tuchwilu zablokowany a njemóžeš přećelow abo njepřećelow přidać.',
	'ur-add-error-message-yourself' => 'Njemóžeš sebje jako přećela abo njepřećela přidać.',
	'ur-add-error-message-existing-relationship-foe' => '$1 je hižo twój njepřećel.',
	'ur-add-error-message-existing-relationship-friend' => '$1 je hižo twój přećel.',
	'ur-add-error-message-pending-request-title' => 'Sćerpliwosć!',
	'ur-add-error-message-pending-friend-request' => 'Maš njesčinjene přećelske naprašowanje z $1.
Budźemy će informować, hdyž $1 twoje naprašowanje wobkruća.',
	'ur-add-error-message-pending-foe-request' => 'Maš njesčinjene njepřećelske naprašowanje z $1.
Budźemy će informować, hdyž $1 twoje naprašowanje wobkruća.',
	'ur-add-error-message-not-loggedin-foe' => 'Dyrbiš přizjewjeny być, zo by njepřećela přidał',
	'ur-add-error-message-not-loggedin-friend' => 'Dyrbiš přizjewjeny być, zo by přećela přidał',
	'ur-requests-title' => 'Poćahowe naprašowanja',
	'ur-requests-message-foe' => '<a href="$1">$2</a> chce twój njepřećel być.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> chce twój přećel być.',
	'ur-accept' => 'Akceptować',
	'ur-reject' => 'Wotpokazać',
	'ur-no-requests-message' => 'Nimaš žane přećelske abo njepřećelske naprašowanja.
Jeli chceš wjace přećelow, <a href="$1">přeproš jich!</a>',
	'ur-requests-added-message-foe' => 'Sy $1 jako swojeho njepřećela přidał.',
	'ur-requests-added-message-friend' => 'Sy $1 jako swojeho přećela přidał.',
	'ur-requests-reject-message-friend' => 'Sy $1 jako swojeho přećela wotpokazał.',
	'ur-requests-reject-message-foe' => 'Sy $1 jako swojeho njepřećela wotpokazał.',
	'ur-title-foe' => 'Lisćina njepřećelow wužiwarja $1',
	'ur-title-friend' => 'Lisćina přećelow wužiwarja $1',
	'friend_request_subject' => '$1 je će jako přećela na {{GRAMMAR:lokatiw|{{SITENAME}}}} přidał',
	'friend_request_body' => 'Witaj $1.

$2 je će na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako přećela přidał. Chcemy zawěsćić, zo wój wobaj staj woprawdźe přećelej.

Prošu klikń na tutón wotkaz, zo by waju přećelstwo wobkrućił:
$3

Dźakujemy so

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóřnił.',
	'foe_request_subject' => 'Wójna! $1 je će na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako njepřećela přidał!',
	'foe_request_body' => 'Witaj $1.

$2 je će runje na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako njepřećela nalistował. Chcemy zawěsćić, zo wój wobaj woprawdźe staj smjertnaj přećeli abo znajmjeńša mataj argument za to.

Prošu klikń na tutón wotkaz, zo by waju wzajomnu hidu wobkrućił.

$3

Dźakujemy so

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'friend_accept_subject' => '$1 je twoje přećelske naprašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}} akceptował!',
	'friend_accept_body' => 'Witaj $1.

$2 je twoje přećelske naprašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}} akceptował!

Pohladaj na stronu wužiwarja $2 na $3

Dźakujemy so,

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'foe_accept_subject' => 'Je tak daloko! $1 je twoje njepřećelske naprašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}} akceptował!',
	'foe_accept_body' => 'Witaj $1.

$2 je twoje njepřećelske naprašowanje na {{GRAMMAR:lokatiw|{{SITENAME}}}} akceptował!

Pohladaj na stronu wužiwarja $2 na $3

Dźakujemy so,

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'friend_removed_subject' => 'Owej! $1 je će na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako přećela wotstronił!',
	'friend_removed_body' => 'Witaj $1.

$2 je će na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako přećela wotstronił!

Dźakujemy so

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
	'foe_removed_subject' => 'Juhu! $1 je će na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako njepřećela wotstronił!',
	'foe_removed_body' => 'Witaj $1.

$2 je će na {{GRAMMAR:lokatiw|{{SITENAME}}}} jako njepřećela wotstronił!

Snano staj wój wobaj na najlěpšim puću, zo byštaj so spřećeliłoj?

Dźakujemy so

---

Hej, hižo nochceš žane e-mejle wot nas dóstać?

Klikń na $4
a změń swoje nastajenja, zo by e-mejlowe zdźělenja znjemóžnił.',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'viewrelationships' => 'Kapcsolat megtekintése',
	'viewrelationshiprequests' => 'Jelölések megtekintése',
	'ur-already-submitted' => 'A kérelmed el lett küldve',
	'ur-error-page-title' => 'Upsz!',
	'ur-error-title' => 'Hupsz, eltévedtél!',
	'ur-error-message-no-user' => 'Nem tudjuk teljesíteni a kérésed, mert nem létezik ilyen nevű felhasználó.',
	'ur-main-page' => 'Kezdőlap',
	'ur-your-profile' => 'A profilod',
	'ur-backlink' => '&lt; vissza $1 profiljára',
	'ur-relationship-count-foes' => '$1 felhasználónak {{PLURAL:$2|egy|$2}} ellensége van.
Szeretnél több ellenséget?
<a href="$3">Hívd meg őket.</a>',
	'ur-relationship-count-friends' => '$1 felhasználónak {{PLURAL:$2|egy|$2}} barátja van.
Szeretnél több barátot?
<a href="$3">Hívd meg őket.</a>',
	'ur-add-friends' => '  Szeretnél több barátot?
<a href="$1">Hívd meg őket</a>',
	'ur-add-friend' => 'Hozzáadás barátként',
	'ur-add-foe' => 'Hozzáadás ellenségként',
	'ur-add-no-user' => 'Nincs felhasználó kiválasztva.
Légyszíves a helyes hivatkozást használva jelölj barátokat/ellenségeket.',
	'ur-add-personal-message' => 'Személyes üzenet hozzáadása',
	'ur-remove-relationship-friend' => 'Eltávolítás a barátok közül',
	'ur-remove-relationship-foe' => 'Eltávolítás az ellenségek közül',
	'ur-give-gift' => 'Ajándék küldése',
	'ur-previous' => 'előző',
	'ur-next' => 'következő',
	'ur-remove-relationship-title-foe' => 'Valóban el szeretnéd távolítani $1 felhasználót az ellenségeid közül?',
	'ur-remove-relationship-title-confirm-foe' => 'Eltávolítottad $1 felhasználót az ellenségeid közül',
	'ur-remove-relationship-title-friend' => 'Valóban el szeretnéd távolítani $1 felhasználót a barátaid közül?',
	'ur-remove-relationship-title-confirm-friend' => 'Eltávolítottad $1 felhasználót a barátaid közül',
	'ur-remove-relationship-message-foe' => 'Ha biztosan el szeretnéd $1 felhasználót távolítani az ellenségeid közül, kattints a(z) „$2” gombra a megerősítéshez.',
	'ur-remove-relationship-message-confirm-foe' => 'Sikeresen eltávolítottad $1 felhasználót az ellenségeid listájáról.',
	'ur-remove-relationship-message-friend' => 'Ha biztosan el szeretnéd $1 felhasználót távolítani a barátaid közül, kattints a(z) „$2” gombra a megerősítéshez.',
	'ur-remove-relationship-message-confirm-friend' => 'Sikeresen eltávolítottad $1 felhasználót a barátaid listájáról.',
	'ur-remove-error-message-no-relationship' => 'Nincs kapcsolatod $1 felhasználóval.',
	'ur-remove-error-message-remove-yourself' => 'Saját magadat nem tudod eltávolítani.',
	'ur-remove-error-message-pending-foe-request' => 'Függőben lévő ellenségnek jelölésed van $1 felhasználóval.',
	'ur-remove-error-message-pending-friend-request' => 'Függőben lévő barátnak jelölésed van $1 felhasználóval.',
	'ur-remove-error-not-loggedin-foe' => 'Be kell jelentkezned ellenség eltávolításához a listáról.',
	'ur-remove-error-not-loggedin-friend' => 'Be kell jelentkezned barát eltávolításához a listáról.',
	'ur-remove' => 'Eltávolítás',
	'ur-cancel' => 'Mégse',
	'ur-login' => 'Bejelentkezés',
	'ur-add-title-foe' => 'Fel szeretnéd venni $1 felhasználót az ellenségeid listájára?',
	'ur-add-title-friend' => 'Fel szeretnéd venni $1 felhasználót a barátaid listájára?',
	'ur-add-message-foe' => '$1 felhasználót ellenségednek szeretnéd jelölni.
Értesíteni fogjuk őt az ellenszenvedről.',
	'ur-add-message-friend' => '$1 felhasználót barátodnak szeretnéd jelölni.
Értesíteni fogjuk őt a barátságodról.',
	'ur-add-button-foe' => 'Hozzáadás ellenségként',
	'ur-add-button-friend' => 'Hozzáadás barátként',
	'ur-add-sent-title-foe' => 'Elküldtük az ellenségnek jelölésedet $1 részére!',
	'ur-add-sent-title-friend' => 'Elküldtük a barátkérődet $1 részére!',
	'ur-add-sent-message-foe' => 'Értesítettük $1 felhasználót, hogy ellenségének jelölted.
Ha $1 megerősíti a jelölést, értesítünk téged e-mailben.',
	'ur-add-sent-message-friend' => 'Értesítettük $1 felhasználót, hogy barátodnak jelölted.
Ha $1 megerősíti a jelölést, értesítünk téged e-mailben.',
	'ur-add-error-message-no-user' => 'A felhasználó, akit hozzá akartál adni, nem létezik.',
	'ur-add-error-message-blocked' => 'Jelenleg blokkolva vagy, így nem vehetsz fel barátokat vagy ellenségeket.',
	'ur-add-error-message-yourself' => 'Nem lehetsz saját magad ellensége vagy barátja.',
	'ur-add-error-message-existing-relationship-foe' => 'Már ellenségek vagytok $1 felhasználóval.',
	'ur-add-error-message-existing-relationship-friend' => 'Már barátok vagytok $1 felhasználóval.',
	'ur-add-error-message-pending-request-title' => 'Türelem!',
	'ur-add-error-message-pending-friend-request' => '$1 barátodnak jelölt, amit még nem erősítettél meg.
Értesítjük őt, amint megerősítetted a jelölést.',
	'ur-add-error-message-pending-foe-request' => '$1 ellenségének jelölt, amit még nem erősítettél meg.
Értesítjük őt, amint megerősítetted a jelölést.',
	'ur-add-error-message-not-loggedin-foe' => 'Be kell jelentkezned ellenség hozzáadásához',
	'ur-add-error-message-not-loggedin-friend' => 'Be kell jelentkezned barát hozzáadásához',
	'ur-requests-title' => 'Függő kapcsolatok',
	'ur-requests-message-foe' => '<a href="$1">$2</a> az ellenséged akar lenni.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> a barátod szeretne lenni.',
	'ur-accept' => 'Elfogadás',
	'ur-reject' => 'Visszautasítás',
	'ur-no-requests-message' => 'Nincsenek függő jelöléseid.
Ha több barátot szeretnél, <a href="$1">hívd meg őket!</a>',
	'ur-requests-added-message-foe' => '$1 felvéve az ellenségeid közé.',
	'ur-requests-added-message-friend' => '$1 felhasználót hozzáadtad a barátaidhoz.',
	'ur-requests-reject-message-friend' => 'Elutasítottad $1 felhasználó felvételét a barátaid közé.',
	'ur-requests-reject-message-foe' => 'Elutasítottad $1 felhasználó felvételét az ellenségeid közé.',
	'ur-title-foe' => '$1 ellenségeinek listája',
	'ur-title-friend' => '$1 barátainak listája',
	'friend_request_subject' => '$1 barátjának jelölt a(z) {{SITENAME}} wikin!',
	'friend_request_body' => 'Szia, $1!

$2 felvett barátjának a(z) {{SITENAME}} wikin. Szeretnénk biztosan tudni, hogy tényleg barátok vagytok.

Kattints a következő hivatkozásra a barátság megerősítéséhez:
$3

Köszönjük

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $4
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
	'foe_request_subject' => 'Háború! $1 ellenségnek jelölt a(z) {{SITENAME}} wikin!',
	'foe_request_body' => 'Szia, $1!

$2 felvett az ellenségei közé a(z) {{SITENAME}} wikin. Szeretnénk biztosan tudni, hogy tényleg halálos ellenségek vagytok, vagy legalább valami nézeteltérésetek van.

Kattints a következő hivatkozásra az ellenszenv megerősítéséhez:
$3

Köszönjük

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $4
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
	'friend_accept_subject' => '$1 elfogadta a barátkérődet a(z) {{SITENAME}} wikin!',
	'friend_accept_body' => 'Szia, $1!

$2 elfogadta a barátnak jelölésedet a(z) {{SITENAME}} wikin!

$2 lapját itt tekintheted meg: $3

Köszönjük

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $4
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
	'foe_accept_subject' => '$1 elfogadta, hogy ellensége vagy a(z) {{SITENAME}} wikin!',
	'foe_accept_body' => 'Szia, $1!

$2 elfogadta az ellenségnek jelölésedet a(z) {{SITENAME}} wikin!

$2 lapját itt tekintheted meg: $3

Köszönjük

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $4
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
	'friend_removed_subject' => 'Jaj, ne! $1 eltávolított a barátjai közül a(z) {{SITENAME}} wikin!',
	'friend_removed_body' => 'Szia, $1!

$2 eltávolított a barátai közül a(z) {{SITENAME}} wikin!

Köszönjük

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $4
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
	'foe_removed_subject' => 'Hurrá! $1 eltávolított az ellenségei közül a(z) {{SITENAME}} wikin!',
	'foe_removed_body' => 'Szia, $1!

$2 eltávolított az ellenségei közül a(z) {{SITENAME}} wikin!

Köszönjük

---
Szeretnéd, ha nem zaklatnánk több e-maillel?

Kattints a következő hivatkozásra: $4
és tiltsd le az e-mailes értesítéseket a beállításaidban.',
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
	'ur-remove-error-message-pending-foe-request' => 'Tu ha un requesta pendente de inimico con $1.',
	'ur-remove-error-message-pending-friend-request' => 'Tu ha un requesta pendente de amico con $1.',
	'ur-remove-error-not-loggedin-foe' => 'Tu debe aperir un session pro poter remover un inimico.',
	'ur-remove-error-not-loggedin-friend' => 'Tu debe aperir un session pro poter remover un amico.',
	'ur-remove' => 'Remover',
	'ur-cancel' => 'Cancellar',
	'ur-login' => 'Aperir session',
	'ur-add-title-foe' => 'Vole tu adder $1 como tu inimico?',
	'ur-add-title-friend' => 'Vole tu adder $1 como tu amico?',
	'ur-add-message-foe' => 'Tu es super le puncto de adder $1 como tu inimico.
Nos notificara $1 pro confirmar tu rancor.',
	'ur-add-message-friend' => 'Tu es super le puncto de adder $1 como tu amico.
Nos notificara $1 pro confirmar tu amicitate.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Tu e $1 es ja inimicos.',
	'ur-add-error-message-existing-relationship-friend' => 'Tu e $1 es ja amicos.',
	'ur-add-error-message-pending-request-title' => 'Patientia!',
	'ur-add-error-message-pending-friend-request' => 'Tu ha un requesta pendente de amico con $1.
Nos te notificara quando $1 confirma tu requesta.',
	'ur-add-error-message-pending-foe-request' => 'Tu ha un requesta pendente de inimico con $1.
Nos te notificara quando $1 confirma tu requesta.',
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
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 */
$messages['id'] = array(
	'viewrelationships' => 'Lihat hubungan',
	'viewrelationshiprequests' => 'Lihat permintaan hubungan',
	'ur-already-submitted' => 'Permintaan Anda telah dikirim',
	'ur-error-page-title' => 'Ups!',
	'ur-error-title' => 'Ups, Anda mengambil jalan yang salah!',
	'ur-error-message-no-user' => 'Kami tak bisa memenuhi permintaan Anda, karena tidak ada pengguna dengan nama ini.',
	'ur-main-page' => 'Halaman utama',
	'ur-your-profile' => 'Profil Anda',
	'ur-backlink' => '&lt; Kembali ke profile $1',
	'ur-relationship-count-foes' => '$1 memiliki $2 {{PLURAL:$2|musuh|musuh}}.
Ingin lebih banyak musuh?
<a href="$3">Undang mereka.</a>',
	'ur-relationship-count-friends' => '$1 memiliki $2 {{PLURAL:$2|teman|teman}}.
Ingin lebih banyak teman?
<a href="$3">Undang mereka.</a>',
	'ur-add-friends' => '  Ingin lebih banyak teman?
<a href="$1">Undang mereka</a>',
	'ur-add-friend' => 'Tambahkan teman',
	'ur-add-foe' => 'Tambahkan musuh',
	'ur-add-no-user' => 'Tidak ada pengguna yang dipilih.
Minta permintaan pertemanan/permusuhan melalui pranala yang benar.',
	'ur-add-personal-message' => 'Tambahkan pesan pribadi',
	'ur-remove-relationship-friend' => 'Hapus sebagai teman',
	'ur-remove-relationship-foe' => 'Hapus sebagai musuh',
	'ur-give-gift' => 'Beri hadiah',
	'ur-previous' => 'sebelumnya',
	'ur-next' => 'selanjutnya',
	'ur-remove-relationship-title-foe' => 'Apakah Anda ingin menghapus $1 sebagai musuh Anda?',
	'ur-remove-relationship-title-confirm-foe' => 'Anda telah menghapus $1 sebagai musuh Anda',
	'ur-remove-relationship-title-friend' => 'Apakah Anda ingin menghapus $1 sebagai teman Anda?',
	'ur-remove-relationship-title-confirm-friend' => 'Anda telah menghapus $1 sebagai teman Anda',
	'ur-remove-relationship-message-foe' => 'Anda telah meminta menghapus $1 sebagai musuh Anda, tekan "$2" untuk mengkonfirmasi.',
	'ur-remove-relationship-message-confirm-foe' => 'Anda berhasil menghapus $1 sebagai musuh Anda.',
	'ur-remove-relationship-message-friend' => 'Anda telah meminta menghapus $1 sebagai teman Anda, tekan "$2" untuk mengkonfirmasi.',
	'ur-remove-relationship-message-confirm-friend' => 'Anda berhasil menghapus $1 sebagai teman Anda.',
	'ur-remove-error-message-no-relationship' => 'Anda tak memiliki hubungan dengan $1.',
	'ur-remove-error-message-remove-yourself' => 'Anda tak dapat menghapus diri sendiri.',
	'ur-remove-error-message-pending-foe-request' => 'Anda memiliki permintaan permusuhan tertunda dengan $1.',
	'ur-remove-error-message-pending-friend-request' => 'Anda memiliki permintaan pertemanan tertunda dengan $1.',
	'ur-remove-error-not-loggedin-foe' => 'Anda harus masuk log untuk menghapus musuh.',
	'ur-remove-error-not-loggedin-friend' => 'Anda harus masuk log untuk menghapus teman.',
	'ur-remove' => 'Hapus',
	'ur-cancel' => 'Batalkan',
	'ur-login' => 'Masuk log',
	'ur-add-title-foe' => 'Apakah Anda ingin menambahkan $1 sebagai musuh Anda?',
	'ur-add-title-friend' => 'Apakah Anda ingin menambahkan $1 sebagai teman Anda?',
	'ur-add-message-foe' => 'Anda akan menambahkan $1 sebagai musuh Anda.
Kami akan memberitahu $1 untuk mengkonfirmasi permusuhan Anda.',
	'ur-add-message-friend' => 'Anda akan menambahkan $1 sebagai teman Anda.
Kami akan memberitahu $1 untuk mengkonfirmasi pertemanan Anda.',
	'ur-add-button-foe' => 'Tambahkan sebagai musuh',
	'ur-add-button-friend' => 'Tambahkan sebagai teman',
	'ur-add-sent-title-foe' => 'Kami telah mengirimkan permintaan permusuhan Anda ke $1!',
	'ur-add-sent-title-friend' => 'Kami telah mengirimkan permintaan pertemanan Anda ke $1!',
	'ur-add-sent-message-foe' => 'Permintaan permusuhan Anda telah dikirim ke $1 untuk konfirmasi.
Apabila $1 mengkonfirmasi permintaan Anda, Anda akan menerima surel pemberitahuan.',
	'ur-add-sent-message-friend' => 'Permintaan pertemanan Anda telah dikirim ke $1 untuk konfirmasi.
Apabila $1 mengkonfirmasi permintaan Anda, Anda akan menerima surel pemberitahuan.',
	'ur-add-error-message-no-user' => 'Pengguna yang Anda tambahkan tidak ada.',
	'ur-add-error-message-blocked' => 'Anda sedang diblokir dan tak dapat menambahkan teman atau musuh.',
	'ur-add-error-message-yourself' => 'Anda tak dapat menambahkan diri sendiri sebagai teman atau musuh.',
	'ur-add-error-message-existing-relationship-foe' => 'Anda telah bermusuhan dengan $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Anda telah berteman dengan $1.',
	'ur-add-error-message-pending-request-title' => 'Bersabarlah!',
	'ur-add-error-message-pending-friend-request' => 'Anda memiliki permintaan pertemanan tertunda dengan $1.
Kami akan memberitahu Anda apabila $1 mengkonfirmasi permintaan Anda.',
	'ur-add-error-message-pending-foe-request' => 'Anda memiliki permintaan permusuhan tertunda dengan $1.
Kami akan memberitahu Anda apabila $1 mengkonfirmasi permintaan Anda.',
	'ur-add-error-message-not-loggedin-foe' => 'Anda harus masuk log untuk menambahkan musuh',
	'ur-add-error-message-not-loggedin-friend' => 'Anda harus masuk log untuk menambahkan teman',
	'ur-requests-title' => 'Permintaan hubungan',
	'ur-requests-message-foe' => '<a href="$1">$2</a> ingin menjadi musuh Anda.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> ingin menjadi teman Anda.',
	'ur-accept' => 'Terima',
	'ur-reject' => 'Tolak',
	'ur-no-requests-message' => 'Anda tidak memiliki permintaan pertemanan atau permusuhan.
Apabila Anda ingin lebih banyak teman, <a href="$1">undang mereka!</a>',
	'ur-requests-added-message-foe' => 'Anda telah menambahkan $1 sebagai musuh Anda.',
	'ur-requests-added-message-friend' => 'Anda telah menambahkan $1 sebagai teman Anda.',
	'ur-requests-reject-message-friend' => 'Anda telah menolak $1 sebagai teman Anda.',
	'ur-requests-reject-message-foe' => 'Anda telah menolak $1 sebagai musuh Anda.',
	'ur-title-foe' => 'Daftar musuh $1',
	'ur-title-friend' => 'Daftar teman $1',
	'friend_request_subject' => '$1 telah menambahkan Anda sebagai teman di {{SITENAME}}!',
	'friend_request_body' => 'Hai $1.

$2 telah menambahkan Anda sebagai teman di {{SITENAME}}. Kami ingin meyakinkan bahwa kalian berteman.

Klik pranala berikut untuk mengkonfirmasi pertemanan Anda:
$3

Terima kasih

---

Hei, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah pengaturan Anda untuk menghentikan pemberitahuan surel.',
	'foe_request_subject' => 'Ada perang! $1 telah menambahkan Anda sebagai teman di {{SITENAME}}!',
	'foe_request_body' => 'Hai $1.

$2 telah menerima Anda sebagai musuh di {{SITENAME}}. Kami ini memastikan bahwa kalian bermusuhan.

Klik pranala berikut untuk mengkonfirmasi permusuhan.

$3

Terima kasih

---

Hei, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah pengaturan Anda untuk menghentikan pemberitahuan surel.',
	'friend_accept_subject' => '$1 telah menerima permintaan pertemanan Anda di {{SITENAME}}!',
	'friend_accept_body' => 'Hai $1.

$2 telah menerima permintaan pertemanan Anda di {{SITENAME}}!

Lihat halaman $2 di $3

Terima kasih,

---

Hei, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah pengaturan Anda untuk menghentikan pemberitahuan surel.',
	'foe_accept_subject' => 'Sudah dimulai! $1 telah menerima permintaan permusuhan Anda di {{SITENAME}}!',
	'foe_accept_body' => 'Hai $1.

$2 telah menerima permintaan permusuhan Anda di {{SITENAME}}!

Lihat halaman $2 di $3

Terima kasih

---

Hei, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah pengaturan Anda untuk menghentikan pemberitahuan surel.',
	'friend_removed_subject' => 'Oh tidak! $1 telah menghapus Anda sebagai teman di {{SITENAME}}!',
	'friend_removed_body' => 'Hai $1.

$2 telah menghapus Anda sebagai teman di {{SITENAME}}!

Terima kasih

---

Hei, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah pengaturan Anda untuk menghentikan pemberitahuan surel.',
	'foe_removed_subject' => 'Akhirnya! $1 telah menghapus Anda sebagai musuh di {{SITENAME}}!',
	'foe_removed_body' => 'Hai $1.

$2 telah menghapus Anda sebagai musuh di {{SITENAME}}!

Mungkin kalian berdua akan segera berteman?

Terima kasih

---

Hei, ingin berhenti menerima surel dari kami?

Klik $4
dan ubah pengaturan Anda untuk menghentikan pemberitahuan surel.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'ur-error-page-title' => 'Ewóo!',
	'ur-cancel' => 'Kàchá',
	'ur-login' => 'Banyé',
	'foe_removed_subject' => 'O ho! $1 wefuru gi ka onye iro na {{SITENAME}}!',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'ur-previous' => 'antea',
	'ur-next' => 'sequanta',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'ur-main-page' => 'Pagina principale',
	'ur-remove' => 'Rimuovi',
	'ur-cancel' => 'Annulla',
	'ur-login' => 'Esegui il login',
	'ur-accept' => 'Accetta',
	'ur-reject' => 'Rifiuta',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'viewrelationships' => '関係の表示',
	'viewrelationshiprequests' => '関係申請の表示',
	'ur-already-submitted' => '申請を送信しました',
	'ur-error-page-title' => 'おっと！',
	'ur-error-title' => 'おっと、操作を間違えましたよ！',
	'ur-error-message-no-user' => 'その名前の利用者は存在しないため申請を完了できません。',
	'ur-main-page' => 'メインページ',
	'ur-your-profile' => 'あなたのプロファイル',
	'ur-backlink' => '&lt; $1のプロファイルに戻る',
	'ur-relationship-count-foes' => '$1には$2人の{{PLURAL:$2|敵}}がいます。敵を増やしますか？<a href="$3">招待する。</a>',
	'ur-relationship-count-friends' => '$1には$2人の{{PLURAL:$2|友人}}がいます。友人を増やしますか？<a href="$3">招待する。</a>',
	'ur-add-friends' => '友人を増やしますか？<a href="$1">招待する。</a>',
	'ur-add-friend' => '友人として追加',
	'ur-add-foe' => '敵として追加',
	'ur-add-no-user' => '利用者が選択されていません。正しいリンクを使って友人/敵申請を行ってください。',
	'ur-add-personal-message' => '私的なメッセージを追加',
	'ur-remove-relationship-friend' => '友人から除去',
	'ur-remove-relationship-foe' => '敵から除去',
	'ur-give-gift' => '贈り物を贈る',
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
	'ur-cancel' => '中止',
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
	'ur-add-error-message-pending-request-title' => 'しばらくお待ちを！',
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
	'ur-requests-reject-message-friend' => '$1の友人申請を却下しました。',
	'ur-requests-reject-message-foe' => '$1の敵申請を却下しました。',
	'ur-title-foe' => '$1の敵一覧',
	'ur-title-friend' => '$1の友人一覧',
	'friend_request_subject' => '$1があなたを{{SITENAME}}での友人に追加しました！',
	'friend_request_body' => '$1さん、こんにちは。

$2さんがあなたを {{SITENAME}} での友人に追加しました。このメールはお二人がほんとうに友人であるかを確認するものです。

友人であることを確認するには次のリンクをクリックしてください。
$3

ご協力ありがとうございます。

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
	'foe_request_subject' => '戦争です！$1があなたを {{SITENAME}} での敵に追加しました！',
	'foe_request_body' => '$1さん、こんにちは。

$2さんがあなたを {{SITENAME}} での敵に追加しました。このメールは$2さんがほんとうにあなたにとって生かしておけない敵であるとか、あるいはちょっとしたけんか中であるとかいった状態であるかを確認するものです。

戦闘状態を確認するには次のリンクをクリックしてください。

$3

ご協力ありがとうございます。

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
	'friend_accept_subject' => '$1があなたからの {{SITENAME}} での友人申請を承認しました！',
	'friend_accept_body' => '$1さん、こんにちは。

$2さんがあなたからの {{SITENAME}} での友人申請を承認しました！

$3 をクリックして$2さんのページをご確認ください。

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
	'foe_accept_subject' => '続行中です！$1があなたからの {{SITENAME}} での敵申請を承認しました！',
	'foe_accept_body' => '$1さん、こんにちは。

$2さんがあなたからの {{SITENAME}} での敵申請を承認しました！

$3 をクリックして$2さんのページをご確認ください。

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
	'friend_removed_subject' => 'たいへんです！$1があなたを {{SITENAME}} での友人から外しました！',
	'friend_removed_body' => '$1さん、こんにちは。

$2 さんがあなたを {{SITENAME}} での友人から除去しました！

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
	'foe_removed_subject' => 'やった！$1があなたを {{SITENAME}} での敵から外しました！',
	'foe_removed_body' => '$1さん、こんにちは。

$2さんがあなたを {{SITENAME}} での敵から除去しました！

お二人の関係が改善に向かっているものと期待します。

---
メール受信を停止したい場合は、
$4
をクリックして、メール通知を無効にするよう設定変更してください。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'ur-already-submitted' => 'Panyuwunan panjenengan wis dikirim',
	'ur-error-title' => 'Adhuh, panjenengan salah ménggok!',
	'ur-main-page' => 'Kaca utama',
	'ur-your-profile' => 'Profil panjenengan',
	'ur-give-gift' => 'Mènèhi bebungah',
	'ur-previous' => 'sadurungé',
	'ur-next' => 'sabanjuré',
	'ur-remove' => 'Busak',
	'ur-cancel' => 'Batal',
	'ur-login' => 'Log mlebu',
	'ur-add-error-message-pending-request-title' => 'Tulung sabar sadélok.',
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
 * @author គីមស៊្រុន
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
	'ur-remove-error-not-loggedin-foe' => 'អ្នក​ត្រូវតែ​កត់ឈ្មោះចូល​សិន ដើម្បី​ដក​បច្ចាមិត្ត​ចេញ​។',
	'ur-remove-error-not-loggedin-friend' => 'អ្នក​ត្រូវតែ​កត់ឈ្មោះចូល​សិន ដើម្បី​ដក​មិត្តភ័ក្ដិ​ចេញ​។',
	'ur-remove' => 'ដកចេញ',
	'ur-cancel' => 'បោះបង់',
	'ur-login' => 'ចូល',
	'ur-add-title-foe' => 'តើ​អ្នក​ពិតជា​ចង់​បន្ថែម $1 ជា​បច្ចាមិត្ត​របស់​អ្នក​ឬ​?',
	'ur-add-title-friend' => 'តើ​អ្នក​ពិតជា​ចង់​បន្ថែម $1 ជា​មិត្តភ័ក្ដិ​របស់​អ្នក​ឬ​?',
	'ur-add-message-foe' => 'អ្នក​ប្រហែល​ជា​បន្ថែម $1 ជា​បច្ចាមិត្ត​របស់​អ្នក​។

អ្នក​នឹង​ជូនដំណឹង $1 ដើម្បី​បញ្ជាក់អះអាង​នូវវិវាទ​របស់​អ្នក​។',
	'ur-add-message-friend' => 'អ្នក​ប្រហែល​ជា​បន្ថែម $1 ជា​មិត្តភ័ក្ដិ​របស់​អ្នក​។

អ្នក​នឹង​ជូនដំណឹង $1 ដើម្បី​បញ្ជាក់អះអាង​នូវមិត្តភាព​របស់​អ្នក​។',
	'ur-add-button-foe' => 'បន្ថែម​ជា​បច្ចាមិត្ត',
	'ur-add-button-friend' => 'បន្ថែម​ជា​មិត្តភ័ក្ដិ',
	'ur-add-sent-title-foe' => 'អ្នក​បាន​ផ្ញើ​សំណើ​បច្ចាមិត្ត​របស់​អ្នក​ទៅ $1 ហើយ​!',
	'ur-add-sent-title-friend' => 'អ្នក​បាន​ផ្ញើ​សំណើ​មិត្តភ័ក្ដិ​របស់​អ្នក​ទៅ $1 ហើយ​!',
	'ur-add-error-message-no-user' => 'អ្នកប្រើប្រាស់ ដែល​អ្នក​កំពុង​ព្យាយាម​បន្ថែម​នេះ​មិនទាន់មាន​ទេ​។',
	'ur-add-error-message-blocked' => 'ឥឡូវនេះ អ្នក​ត្រូវ​បាន​រាំងខ្ទប់ ហើយ​មិន​អាច​បន្ថែម​មិត្តភ័ក្ដិ ឬ បច្ចាមិត្ត​បាន​ឡើយ​។',
	'ur-add-error-message-yourself' => 'អ្នក​មិន​អាច​បន្ថែម​ជា​មិត្តភក្ដិ ឬ បច្ចាមិត្ត​ដោយ​ខ្លួនឯង​បាន​ឡើយ​។',
	'ur-add-error-message-existing-relationship-foe' => 'អ្នក​ជា​បច្ចាមិត្ត​រួចហើយ​ជាមួយ $1 ។',
	'ur-add-error-message-existing-relationship-friend' => 'អ្នក​ជា​មិត្តភ័ក្ដិ​រួចហើយ​ជាមួយ $1 ។',
	'ur-add-error-message-pending-request-title' => 'ខន្តី អត់ធ្មត់ !',
	'ur-add-error-message-not-loggedin-foe' => 'អ្នកត្រូវតែ​បានកត់ឈ្មោះចូល ដើម្បី​បន្ថែម​បច្ចាមិត្ត',
	'ur-add-error-message-not-loggedin-friend' => 'អ្នកត្រូវតែ​បានកត់ឈ្មោះចូល ដើម្បី​បន្ថែម​មិត្តភ័ក្ដិ',
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

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'ur-main-page' => 'ಮುಖ್ಯ ಪುಟ',
	'ur-cancel' => 'ರದ್ದು ಮಾಡು',
	'ur-login' => 'ಲಾಗ್ ಇನ್',
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

/** Colognian (Ripoarisch)
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
	'ur-remove-error-message-pending-foe-request' => 'Do häß ene unbeäbeit Feinschaffs-Aanfrooch met däm Metmaacher „$1“ aam Loufe.',
	'ur-remove-error-message-pending-friend-request' => 'Do häß ene unbeäbeit Frünndschaffs-Aanfrooch met däm Metmaacher „$1“ aam Loufe.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Dä Metmaacher „$1“ un Do, Ühr sitt alld Feinde meddenein.',
	'ur-add-error-message-existing-relationship-friend' => 'Do beß alld Frünnd met dämm „$1“.',
	'ur-add-error-message-pending-request-title' => 'Jedold!',
	'ur-add-error-message-pending-friend-request' => 'Do häß norr_en onbeschtätesch Frünndschaffß-Aanfroch aan dä Metmaacher „$1“.
Do kreß Bescheid, wann hä udder it se bestätesch.',
	'ur-add-error-message-pending-foe-request' => 'Do häß norr_en onbeschtätesch Feinschaffs-Aanfroch aan dä Metmaacher „$1“.
Do kreß Bescheid, wann hä udder it se bestätesch.',
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
	'friend_request_subject' => 'Metmaacher „$1“ {{GRAMMAR:em|{{SITENAME}}}} hät Desch als ene Frünnd opjenomme.',
	'friend_request_body' => 'Hallo $1,

Dä Metmaacher $2 {{GRAMMAR:em|{{SITENAME}}}}
hät Desch als ene Frünnd enjedrare op de.
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
	'foe_request_subject' => 'Kreesch {{GRAMMAR:em|{{SITENAME}}}} — dä Metmaacher „$1“ hät Desch als ene Feind ennjedraare.',
	'foe_request_body' => 'Hallo $1,

Dä Metmaacher $2 {{GRAMMAR:em|{{SITENAME}}}} 
hät Desch als ene Feind enjedrare.
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
	'friend_accept_subject' => 'Dä Metmaacher „$1“ {{GRAMMAR:em|{{SITENAME}}}} hät Ding Frünndschaffs-Aanfrooch beschtätesch.',
	'friend_accept_body' => 'Hallo $1,

Dä Metmaacher $2 {{GRAMMAR:em|{{SITENAME}}}}
hät Desch als ene Fründ bestätesch.
Do kann däm sing Metmaacher-Sigg fenge unger däm URL
$3

Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'foe_accept_subject' => 'Dä Metmaacher „$1“ hät Ding Feindschaffs-Aanfrooch {{GRAMMAR:em|{{SITENAME}}}} beschtätesch.',
	'foe_accept_body' => 'Hallo $1,

Dä Metmaacher $2 {{GRAMMAR:em|{{SITENAME}}}}
hät Desch als ene Feind bestätesch op de.
Do kann däm sing Metmaacher-Sigg fenge unger däm URL
$3

Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'friend_removed_subject' => 'Dä Metmaacher „$1“ {{GRAMMAR:em|{{SITENAME}}}} hät de Frünndschaff met Dir jekündesch.',
	'friend_removed_body' => 'Hallo $1,

Dä Metmaacher $2 hät Der de Frünndschaff jekündesch,
un Desch och uß singe Fründesleß {{GRAMMAR:em|{{SITENAME}}}}
ußjedraare.


Dä, jetz weiß De dat.
Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
	'foe_removed_subject' => 'Dä Metmaacher „$1“ {{GRAMMAR:em|{{SITENAME}}}} hät de Feindschaff met Dir jekündesch.',
	'foe_removed_body' => 'Hallo $1,

Dä Metmaacher $2 hät Der de Feindschaff jekündesch,
un Desch och uß singe Feindesleß {{GRAMMAR:em|{{SITENAME}}}}
ußjedraare.

Dä, jetz weiß De dat.
Dankeschön.

---

Wells De kein e-mail fun uns han? Dann kleck
$4
un donn en Dinge Ennstellunge affschallde, dat
De e-mail jescheck kriß.',
);

/** Kurdish (Latin) (Kurdî (Latin))
 * @author Welathêja
 */
$messages['ku-latn'] = array(
	'ur-main-page' => 'Destpêk',
	'ur-cancel' => 'Betal bike',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'ur-main-page' => 'Folen dre',
	'ur-cancel' => 'Hedhy',
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
	'ur-remove-error-message-remove-yourself' => 'Dir kënnt Iech net selwer ewechhuelen.',
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
	'friend_request_body' => "Salut $1.

De Benotzer $2 huet Iech als Frënd op {{SITENAME}} derbäigesat. Mir wëlle sécher sinn datt Dir och wierklech Frënn sidd.

Klickt w.e.g. op dëse Link fir Är Frëndschaft ze confirméieren:
$3

Merci

---

Wëllt dir keng Maile méi vun eis kréien?

Da klickt $4
an ännert Är Astellunge fir d'E-Mail-Notificatioun auszeschalten.",
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

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'viewrelationships' => 'Види однос',
	'viewrelationshiprequests' => 'Види барања за однос',
	'ur-already-submitted' => 'Барањето ви е испратено',
	'ur-error-page-title' => 'Упс!',
	'ur-error-title' => 'Упс! Свртевте на погрешно место!',
	'ur-error-message-no-user' => 'Не можеме да го извршиме вашето барање бидејќи не постои корисник со тоа име.',
	'ur-main-page' => 'Главна страница',
	'ur-your-profile' => 'Вашиот профил',
	'ur-backlink' => '&lt; Назад кон профилот на $1',
	'ur-relationship-count-foes' => '$1 има $2 {{PLURAL:$2|непријател|непријатели}}.
Сакате уште непријатели?
<a href="$3">Поканете ги.</a>',
	'ur-relationship-count-friends' => '$1 има $2 {{PLURAL:$2|пријател|пријатели}}.
Сакате уште пријатели?
<a href="$3">Поканете ги.</a>',
	'ur-add-friends' => '  Сакате уште пријатели?
<a href="$1">Поканете ги</a>',
	'ur-add-friend' => 'Додај во пријатели',
	'ur-add-foe' => 'Додај во непријатели',
	'ur-add-no-user' => 'Нема избрано корисник.
Побарувајте пријателства/непријателства преку правилната врска.',
	'ur-add-personal-message' => 'Додај лична порака',
	'ur-remove-relationship-friend' => 'Отстрани од пријатели',
	'ur-remove-relationship-foe' => 'Отстрани од непријатели',
	'ur-give-gift' => 'Подари подарок',
	'ur-previous' => 'претходни',
	'ur-next' => 'следни',
	'ur-remove-relationship-title-foe' => 'Дали сакате да го отстраните $1 од списокот на непријатели?',
	'ur-remove-relationship-title-confirm-foe' => 'Го отстранивте $1 од списокот на непријатели',
	'ur-remove-relationship-title-friend' => 'Дали сакате да го отстраните $1 од списокот на пријатели?',
	'ur-remove-relationship-title-confirm-friend' => 'Го отстранивте $1 од списокот на пријатели',
	'ur-remove-relationship-message-foe' => 'Побаравте отстранување на $1 од списокот на ваши непријатели; притиснете на „$2“ за да потврдите.',
	'ur-remove-relationship-message-confirm-foe' => 'Успешно го отстранивте $1 од списокот на непријатели.',
	'ur-remove-relationship-message-friend' => 'Побаравте отстранување на $1 од списокот на ваши пријатели; притиснете на „$2“ за да потврдите.',
	'ur-remove-relationship-message-confirm-friend' => 'Успешно го отстранивте $1 од списокот на пријатели.',
	'ur-remove-error-message-no-relationship' => 'Немате воспоставено однос со $1.',
	'ur-remove-error-message-remove-yourself' => 'Не можете да се отстраните себеси',
	'ur-remove-error-message-pending-foe-request' => 'Имате барање за непријателство со $1 во исчекување.',
	'ur-remove-error-message-pending-friend-request' => 'Имате барање за пријателство со $1 во исчекување.',
	'ur-remove-error-not-loggedin-foe' => 'Морате да сте најавени за да отстраните непријател.',
	'ur-remove-error-not-loggedin-friend' => 'Морате да сте најавени за да отстраните пријател.',
	'ur-remove' => 'Отстрани',
	'ur-cancel' => 'Откажи',
	'ur-login' => 'Најава',
	'ur-add-title-foe' => 'Дали сакате да го додадете $1 како ваш непријател?',
	'ur-add-title-friend' => 'Дали сакате да го додадете $1 како ваш пријател?',
	'ur-add-message-foe' => 'Го додавате $1 како непријател.
Ќе го известиме $1 за да ја потврди вашата омраза.',
	'ur-add-message-friend' => 'Го додавате $1 како пријател.
Ќе го известиме $1 за да го потврди вашето пријателство.',
	'ur-add-button-foe' => 'Додај како непријател',
	'ur-add-button-friend' => 'Додај во приајтели',
	'ur-add-sent-title-foe' => 'Го испративме вашето барање за непријателство на $1!',
	'ur-add-sent-title-friend' => 'Го испративме вашето барање за пријателство на $1',
	'ur-add-sent-message-foe' => 'Вашето барање за непријателство е испратено на $1 за да го потврди.
Ако $1 потврди дека сте непријатели, ќе добиете известување по е-пошта.',
	'ur-add-sent-message-friend' => 'Вашето барање за пријателство е испратено на $1 за да го потврди.
Ако $1 потврди дека сте пријатели, ќе добиете известување по е-пошта.',
	'ur-add-error-message-no-user' => 'Корисникот што сакате да го додадете не постои.',
	'ur-add-error-message-blocked' => 'Моментално сте блокирани и не можете да додавате пријатели и непријатели.',
	'ur-add-error-message-yourself' => 'Не можете да се додадете себеси како пријател или непријател.',
	'ur-add-error-message-existing-relationship-foe' => 'Веќе сте непријатели со $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Веќе сте пријатели со $1.',
	'ur-add-error-message-pending-request-title' => 'Трпение!',
	'ur-add-error-message-pending-friend-request' => 'Имате барање за пријателство со $1 во исчекување.
Ќе ве известиме кога $1 ќе го потрврди барањето.',
	'ur-add-error-message-pending-foe-request' => 'Имате барање за непријателство со $1 во исчекување.
Ќе ве известиме кога $1 ќе го потрврди барањето.',
	'ur-add-error-message-not-loggedin-foe' => 'Мора да сте најавени за да додавате непријатели',
	'ur-add-error-message-not-loggedin-friend' => 'Мора да сте најавени за да додавате пријатели',
	'ur-requests-title' => 'Барања за однос',
	'ur-requests-message-foe' => '<a href="$1">$2</a> сака да бидете непријатели.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> сака да бидете пријатели.',
	'ur-accept' => 'Прифати',
	'ur-reject' => 'Одбиј',
	'ur-no-requests-message' => 'Немате барања за пријателство или непријателство.
Ако сакате уште пријатели, <a href="$1">поканете ги!</a>',
	'ur-requests-added-message-foe' => 'Го додадовте $1 како непријател.',
	'ur-requests-added-message-friend' => 'Го додадовте $1 како пријател.',
	'ur-requests-reject-message-friend' => 'Одбивте да бидете пријатели со $1.',
	'ur-requests-reject-message-foe' => 'Одбивте да бидете непријатели со $1.',
	'ur-title-foe' => 'Список на непријатели на $1',
	'ur-title-friend' => 'Список на пријатели на $1',
	'friend_request_subject' => '$1 ве додаде како пријател на {{SITENAME}}!',
	'friend_request_body' => 'Здраво $1.

$2 во додаде во својот список на пријатели на {{SITENAME}}. Сакаме да потврдиме дека вие двајца сте навистина пријатели.

Кликнете на врската за да го потврдите пријателството:
$3

Благодариме

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
	'foe_request_subject' => 'Ова е војна! $1 ве додаде во непријатели на {{SITENAME}}!',
	'foe_request_body' => 'Здраво $1.

$2 штотуку ве додаде во својот список на непријатели на {{SITENAME}}. Сакаме да ни потврдите дека навистина сте смртни непријатели, или барем дека сте скарани.

Кликнете на врската за да го потврдите непријателството.

$3

Благодариме

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
	'friend_accept_subject' => '$1 го прифати вашето барање за пријателство на {{SITENAME}}!',
	'friend_accept_body' => 'Здраво $1.

$2 прифати да ви биде пријател на {{SITENAME}}!

Погледајте ја страницата на $2 на $3

Благодариме,

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
	'foe_accept_subject' => 'Ете така! $1 го прифати вашето барање за непријателство на {{SITENAME}}!',
	'foe_accept_body' => 'Здраво $1.

$2 прифати да ви биде непријател на {{SITENAME}}!

Погледајте ја страницата на $2 на $3

Благодариме

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
	'friend_removed_subject' => 'Ах, не! $1 ве отстрани од списокот на пријатели на {{SITENAME}}!',
	'friend_removed_body' => 'Здраво $1.

$2 ве отстрани од списокот на пријатели на {{SITENAME}}!

Благодариме

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
	'foe_removed_subject' => 'Ура! $1 ве отстрани од непријатели на {{SITENAME}}!',
	'foe_removed_body' => 'Здраво $1.

$2 ве отстрани од списокот на непријатели на {{SITENAME}}!

Можеби вие сте на пат да станете пријатели?

Благодариме

---

Сакате повеќе да не добивате известувања од нас?

Кликнете на $4
и во нагодувањата оневозможете добивање на известувања по е-пошта.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'ur-main-page' => 'പ്രധാന താൾ',
	'ur-add-friends' => 'കൂടുതൽ സുഹൃത്തുക്കളെ വേണോ? <a href="$1">ക്ഷണിക്കുക</a>',
	'ur-add-friend' => 'സുഹൃത്തായി ചേർക്കുക',
	'ur-previous' => 'മുൻപുള്ളത്',
	'ur-next' => 'അടുത്തത്',
	'ur-remove-error-message-no-relationship' => 'താങ്കൾക്ക് $1മായി ബന്ധം സ്ഥാപിച്ചിട്ടില്ല.',
	'ur-remove-error-message-remove-yourself' => 'താങ്കൾക്ക് താങ്കളെത്തന്നെ ഒഴിവാക്കാൻ പറ്റില്ല.',
	'ur-remove' => 'നീക്കം ചെയ്യുക',
	'ur-cancel' => 'റദ്ദാക്കുക',
	'ur-login' => 'പ്രവേശിക്കുക',
	'ur-add-error-message-no-user' => 'താങ്കൾ ചേർക്കുവാൻ ശ്രമിക്കുന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'ur-add-error-message-pending-request-title' => 'കാത്തിരിക്കൂ!',
	'ur-accept' => 'സ്വീകരിക്കുക',
	'ur-reject' => 'നിരസിക്കുക',
	'ur-title-friend' => '$1ന്റെ സുഹൃത്തുക്കളുടെ പട്ടിക',
	'friend_request_subject' => '$1 താങ്കളെ {{SITENAME}} സം‌രംഭത്തിൽ സുഹൃത്തായി ചേർത്തിരിക്കുന്നു!',
	'friend_accept_subject' => '{{SITENAME}} സം‌രംഭത്തിലുള്ള താങ്കളുടെ സൗഹൃദ അഭ്യർത്ഥന $1 സ്വീകരിച്ചു!',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'ur-main-page' => 'Нүүр хуудас',
	'ur-cancel' => 'Цуцлах',
	'ur-login' => 'Нэвтрэх',
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
	'ur-remove' => 'काढा',
	'ur-cancel' => 'रद्द करा',
	'ur-login' => 'प्रवेश',
	'ur-add-error-message-no-user' => 'तुम्ही वाढवू इच्छित असलेला सदस्य अस्तित्वात नाही.',
	'ur-add-error-message-blocked' => 'तुम्हाला सध्या ब्लॉक करण्यात आलेले आहे व तुम्ही मित्र किंवा शत्रू वाढवू शकत नाही.',
	'ur-add-error-message-yourself' => 'तुम्ही स्वत:लाच मित्र किंवा शत्रू म्हणून वाढवू शकत नाही.',
	'ur-add-error-message-pending-request-title' => 'वाटपहा!',
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

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'ur-previous' => 'sebelumnya',
	'ur-next' => 'berikutnya',
	'ur-remove' => 'Buang',
	'ur-cancel' => 'Batalkan',
	'ur-login' => 'Log masuk',
);

/** Maltese (Malti)
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'ur-cancel' => 'Annulla',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'ur-main-page' => 'Páigina percipal',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'ur-remove' => 'Нардык',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'ur-main-page' => 'Calīxatl',
	'ur-add-friend' => 'Ticcēntilīz quemeh mocnīuh',
	'ur-next' => 'niman',
	'ur-cancel' => 'Ticcuepāz',
	'ur-login' => 'Timocalaquīz',
	'ur-add-button-friend' => 'Ticcēntilīz quemeh mocnīuh',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'ur-main-page' => 'Hööftsiet',
	'ur-add-friend' => 'As Fründ tofögen',
	'ur-add-foe' => 'As Feend tofögen',
	'ur-give-gift' => 'Geschenk maken',
	'ur-cancel' => 'Afbreken',
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
Maak verzoeken voor vrienden/tegenstanders alstublieft via de daarvoor bedoelde verwijzing.',
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
	'ur-remove-error-message-pending-foe-request' => 'U hebt een openstaand tegenstandersverzoek van $1.',
	'ur-remove-error-message-pending-friend-request' => 'U hebt een openstaand vriendschapsverzoek van $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'U bent al bevriend met $1.',
	'ur-add-error-message-existing-relationship-friend' => '$1 is al uw tegenstander.',
	'ur-add-error-message-pending-request-title' => 'Even geduld alstublieft.',
	'ur-add-error-message-pending-friend-request' => 'U hebt een openstaand vriendschapsverzoek bij $1.
U wordt op de hoogte gesteld als $1 uw verzoek bevestigt.',
	'ur-add-error-message-pending-foe-request' => 'U hebt een openstaand tegenstandersverzoek bij $1.
U wordt op de hoogte gesteld als $1 uw verzoek bevestigt.',
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

Klik op de onderstaande verwijzing om uw vriendschap te bevestigen:
$3

Bedankt.
---

Wilt u niet langer e-mails van ons ontvangen?

Klik $4
en wijzig uw instellingen om e-mailberichten uit te schakelen.',
	'foe_request_subject' => '$1 heeft u toegevoegd als tegenstander op {{SITENAME}}!',
	'foe_request_body' => 'Hallo $1.

$2 heeft u als tegenstander toegevoegd op {{SITENAME}}. We willen graag bevestiging dat u echt tegenstanders bent of in ieder geval gebrouilleerd bent.

Klik op de onderstaande verwijzing om uw animositeit te bevestigen:
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
	'ur-remove-error-message-pending-foe-request' => 'Du har ein uteståande førespurnad om fiendskap frå $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du har ein uteståande førespurnad om vennskap frå $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Du er allereie fiende med $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du er allereie venn med $1.',
	'ur-add-error-message-pending-request-title' => 'Tolmod!',
	'ur-add-error-message-pending-friend-request' => 'Du har ein uteståande førespurnad om vennskap med $1.
Me vil gje deg ei melding når $1 stadfestar førespurnaden din.',
	'ur-add-error-message-pending-foe-request' => 'Du har ein uteståande førespurnad om fiendskap med $1.
Me vil gje deg ei melding når $1 stadfestar førespurnaden din.',
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
$messages['nb'] = array(
	'viewrelationships' => 'Vis forbindelse',
	'viewrelationshiprequests' => 'Vis forespørsler om forbindelse',
	'ur-already-submitted' => 'Forespørselen din har blitt sendt',
	'ur-error-page-title' => 'Ops!',
	'ur-error-title' => 'Ops, du svingte feil.',
	'ur-error-message-no-user' => 'Vi kan ikke fullføre forespørselen din fordi det ikke finnes noen brukere ved dette navnet.',
	'ur-main-page' => 'Hovedside',
	'ur-your-profile' => 'Profilen din',
	'ur-backlink' => '&lt; Tilbake til profilen til $1',
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
	'ur-remove-error-message-pending-foe-request' => 'Du har en ventende fiendeforespørsel hos $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du har en ventende venneforespørsel hos $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Du er allerede fiende med $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du er allerede venn med $1.',
	'ur-add-error-message-pending-request-title' => 'Tålmodighet ...',
	'ur-add-error-message-pending-friend-request' => 'Du har en ventende venneforespørsel hos $1.
Vi vil gi deg en melding når $1 bekrefter forespørselen din.',
	'ur-add-error-message-pending-foe-request' => 'Du har en ventende fiendeforespørsel hos $1.
Vi vil gi deg en melding når $1 bekrefter forespørselen din.',
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
	'ur-remove-error-message-pending-foe-request' => 'Avètz una requèsta en cors d’un enemic amb $1.',
	'ur-remove-error-message-pending-friend-request' => 'Avètz una requèsta en cors d’un amic amb $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Ja sètz enemic de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Ja sètz amic de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciéncia!',
	'ur-add-error-message-pending-friend-request' => 'Avètz una demanda d’amistat en cors amb $1.
Vos notificarem se $1 confirma vòstra requèsta.',
	'ur-add-error-message-pending-foe-request' => 'Avètz una demanda d’ostilitat en cors amb $1.
Vos notificarem se $1 confirma vòstra requèsta.',
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

/** Oriya (ଓଡ଼ିଆ)
 * @author Jose77
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'ur-main-page' => 'ପ୍ରଧାନ ପୃଷ୍ଠା',
	'ur-previous' => 'ଆଗ',
	'ur-next' => 'ପର',
	'ur-cancel' => 'ନାକଚ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'ur-cancel' => 'Нæ бæззы',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'ur-main-page' => 'Haaptblatt',
	'ur-next' => 'neegschte',
	'ur-login' => 'Kumm nei',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'ur-next' => 'negschte',
);

/** Polish (Polski)
 * @author Airwolf
 * @author Derbeth
 * @author Jwitos
 * @author Maikking
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'viewrelationships' => 'Zobacz nawiązane stosunki',
	'viewrelationshiprequests' => 'Zobacz zaproszenia do nawiązania stosunków',
	'ur-already-submitted' => 'Zaproszenie zostało wysłane',
	'ur-error-page-title' => 'Ojej!',
	'ur-error-title' => 'Ojej! Zrobiłeś coś źle!',
	'ur-error-message-no-user' => 'Nie można zrealizować zaproszenia, ponieważ nie istnieje użytkownik o takiej nazwie.',
	'ur-main-page' => 'Strona główna',
	'ur-your-profile' => 'Twój profil',
	'ur-backlink' => '&lt; Powrót do profilu $1',
	'ur-relationship-count-foes' => '$1 ma $2 {{PLURAL:$2|wroga|wrogów}}.
Chcesz mieć więcej wrogów?
<a href="$3">Zaproś ich.</a>',
	'ur-relationship-count-friends' => '$1 ma $2 {{PLURAL:$2|znajomego|znajomych}}.
Chcesz mieć więcej znajomych?
<a href="$3">Zaproś ich.</a>',
	'ur-add-friends' => '  Chcesz mieć więcej przyjaciół? <a href="$1">Zaproś ich</a>',
	'ur-add-friend' => 'Dodaj do przyjaciół',
	'ur-add-foe' => 'Dodaj do wrogów',
	'ur-add-no-user' => 'Nie wybrano żadnego użytkownika.
Wybierz znajomych lub wrogów poprzez poprawny link.',
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
	'ur-remove-error-message-no-relationship' => 'Nie masz żadnej relacji z $1.',
	'ur-remove-error-message-remove-yourself' => 'Nie możesz usunąć sam siebie.',
	'ur-remove-error-message-pending-foe-request' => 'Wysłałeś już informację, że chcesz być wrogiem dla $1.',
	'ur-remove-error-message-pending-friend-request' => 'Wysłałeś już informację, że chcesz być znajomym dla $1.',
	'ur-remove-error-not-loggedin-foe' => 'Musisz się zalogować, aby przestać uznawać kogoś za wroga.',
	'ur-remove-error-not-loggedin-friend' => 'Musisz się zalogować, aby zakończyć znajomość.',
	'ur-remove' => 'Usuń',
	'ur-cancel' => 'Anuluj',
	'ur-login' => 'Zaloguj się',
	'ur-add-title-foe' => 'Czy chcesz dodać $1 do listy wrogów?',
	'ur-add-title-friend' => 'Czy chcesz dodać $1 do listy przyjaciół?',
	'ur-add-message-foe' => 'Zamierzasz uznać $1 za swojego wroga.
Poprosimy $1 o potwierdzenie nieprzyjaznego stosunku.',
	'ur-add-message-friend' => 'Zamierzasz uznać $1 za swojego znajomego.
Poprosimy $1 o potwierdzenie nawiązania znajomości.',
	'ur-add-button-foe' => 'Oznacz jako wroga',
	'ur-add-button-friend' => 'Oznacz jako przyjaciela',
	'ur-add-sent-title-foe' => 'Wysłano informację, że chcesz być wrogiem dla $1!',
	'ur-add-sent-title-friend' => 'Wysłano informację, że chcesz być znajomym dla $1!',
	'ur-add-sent-message-foe' => 'Prośba o ustalenie statusu wroga została wysłana do $1.
Jeśli $1 ją potwierdzi, otrzymasz powiadomienie e‐mail',
	'ur-add-sent-message-friend' => 'Prośba o ustalenie statusu znajomego została wysłana do $1.
Jeśli $1 ją potwierdzi, otrzymasz powiadomienie e‐mail',
	'ur-add-error-message-no-user' => 'Użytkownik, którego próbujesz dodać, nie istnieje.',
	'ur-add-error-message-blocked' => 'Jesteś zablokowany i nie możesz dodawać nowych znajomych i wrogów.',
	'ur-add-error-message-yourself' => 'Nie możesz dodać samego siebie jako przyjaciela lub wroga.',
	'ur-add-error-message-existing-relationship-foe' => 'Jesteście już wrogami z $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Jesteście już przyjaciółmi z $1.',
	'ur-add-error-message-pending-request-title' => 'Cierpliwości!',
	'ur-add-error-message-pending-friend-request' => 'Wysłałeś prośbę o nawiązanie znajomości z $1.
Powiadomimy Cię, jeśli $1 wyrazi zgodę.',
	'ur-add-error-message-pending-foe-request' => 'Wysłałeś prośbę o ustalenie statusu wroga z $1.
Powiadomimy Cię, jeśli $1 potwierdzi prośbę.',
	'ur-add-error-message-not-loggedin-foe' => 'Żeby dodać wroga musisz być zalogowany',
	'ur-add-error-message-not-loggedin-friend' => 'Żeby dodać przyjaciela musisz być zalogowany',
	'ur-requests-title' => 'Nawiązanie znajomości',
	'ur-requests-message-foe' => '<a href="$1">$2</a> chce być Twoim wrogiem.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> chce zostać Twoim znajomym.',
	'ur-accept' => 'Zaakceptuj',
	'ur-reject' => 'Odrzuć',
	'ur-no-requests-message' => 'Nie masz zaproszeń do przyjaźni oraz zgłoszeń od wrogów.
Jeśli chcesz mieć więcej przyjaciół <a href="$1">zaproś ich!</a>',
	'ur-requests-added-message-foe' => 'Dodałeś $1 jako swojego wroga.',
	'ur-requests-added-message-friend' => 'Dodałeś $1 jako swojego przyjaciela.',
	'ur-requests-reject-message-friend' => 'Odrzuciłeś $1 jako swojego przyjaciela.',
	'ur-requests-reject-message-foe' => 'Odrzuciłeś $1 jako swojego wroga.',
	'ur-title-foe' => 'Lista wrogów $1',
	'ur-title-friend' => 'Lista przyjaciół $1',
	'friend_request_subject' => '$1 dodał Ciebie do swoich przyjaciół na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'friend_request_body' => 'Cześć $1.

$2 chce nawiązać z Tobą znajomość na {{GRAMMAR:MS.lp|{{SITENAME}}}}. Chcemy się upewnić, czy rzeczywiście jesteście znajomymi.

Proszę kliknąć poniżej, żeby potwierdzić znajomość:
$3

Dziękujemy

---

Nie chcesz już od nas maili?

Kliknij $4
i zmień swoje ustawienia, wyłączając powiadomienia e‐mail.',
	'foe_request_subject' => 'Wojna! $1 dodał Cię do wrogów na {{GRAMMAR:MS.lp|{{sitename}}}}!',
	'foe_request_body' => 'Witaj $1.

$2 oznaczył Cię jako swojego wroga na {{GRAMMAR:MS.lp|{{SITENAME}}}}. Chcemy się upewnić, czy rzeczywiście jesteście śmiertelnymi wrogami lub przynajmniej skłóceni.

Proszę kliknąć poniżej, aby potwierdzić.

$3

Dziękujemy

---

Nie chcesz już od nas maili?

Kliknij $4
i zmień swoje ustawienia, wyłączając powiadomienia e‐mail.',
	'friend_accept_subject' => '$1 zaakceptował Twoją prośbę o nawiązanie znajomości na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'friend_accept_body' => 'Witaj $1.

$2 zaakceptował Twoją prośbę o nawiązanie znajomości na {{GRAMMAR:MS.lp|{{SITENAME}}}}!

Zobacz stronę $2 na $3

Dziękujemy,

---

Nie chcesz otrzymywać od nas maili?

Kliknij $4
i zmień ustawienia, wyłączając powiadomienia e‐mail.',
	'foe_accept_subject' => '$1 zaakceptował Twoją prośbę o status wroga na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'foe_accept_body' => 'Witaj $1.

$2 zaakceptował Twoją prośbę o status wroga na {{GRAMMAR:MS.lp|{{SITENAME}}}}!

Zobacz stronę $2 na $3

Dziękujemy

---

Nie chcesz otrzymywać od nas maili?

Kliknij $4
i zmień ustawienia, wyłączając powiadomienia e‐mail.',
	'friend_removed_subject' => 'Och nie! $1 usunął Cię z listy przyjaciół na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'friend_removed_body' => 'Witaj $1.

$2 usunął Cię z listy znajomych na {{GRAMMAR:MS.lp|{{SITENAME}}}}!

Dziękujemy

---

Nie chcesz otrzymywać od nas maili?

Kliknij $4
i zmień ustawienia, wyłączając powiadomienia e‐mail.',
	'foe_removed_subject' => 'Hej! $1 usunął Cię z listy wrogów na {{GRAMMAR:MS.lp|{{SITENAME}}}}!',
	'foe_removed_body' => 'Witaj $1.

$2 usunął Cię z listy wrogów na {{GRAMMAR:MS.lp|{{SITENAME}}}}!

Może zostaniecie przyjaciółmi?

Dziękujemy

---

Nie chcesz otrzymywać od nas maili?

Kliknij $4
i zmień ustawienia, wyłączając powiadomienia e‐mail.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'viewrelationships' => 'Visualisa relassion',
	'viewrelationshiprequests' => 'Visualisa arceste ëd relassion',
	'ur-already-submitted' => "Toa arcesta a l'é stàita mandà",
	'ur-error-page-title' => 'Contacc!',
	'ur-error-title' => "Contacc, a l'é andaje mal!",
	'ur-error-message-no-user' => 'I podoma pa completé soa arcesta, përchè a-i é gnun utent con sto nòm-sì.',
	'ur-main-page' => 'Intrada',
	'ur-your-profile' => 'Tò profil',
	'ur-backlink' => '&lt; André al profil ëd $1',
	'ur-relationship-count-foes' => '$1 a l\'ha $2 {{PLURAL:$2|nemis|nemis}}.
Ancor ëd pì?
<a href="$3">Anviteje.</a>',
	'ur-relationship-count-friends' => '$1 a l\'ha $2 {{PLURAL:$2|amis|amis}}.
Ancor pì d\'amis?
<a href="$3">Anviteje.</a>',
	'ur-add-friends' => 'Veul-lo pi d\'amis?
<a href="$1">Anviteje</a>',
	'ur-add-friend' => "Gionta n'amis",
	'ur-add-foe' => 'Gionta un nemis',
	'ur-add-no-user' => "Gnun utent selessionà.
Për piasì ch'a ciama amis/nemis con ël colegament giust.",
	'ur-add-personal-message' => 'Gionté un mëssagi përsonal',
	'ur-remove-relationship-friend' => "Gava n'amis",
	'ur-remove-relationship-foe' => 'Gava un nemis',
	'ur-give-gift' => 'Fé un cadò',
	'ur-previous' => 'prima',
	'ur-next' => 'dapress',
	'ur-remove-relationship-title-foe' => 'Veus-lo gavé $1 da sò nemis?',
	'ur-remove-relationship-title-confirm-foe' => "It l'has gavà $1 da tò nemis",
	'ur-remove-relationship-title-friend' => 'Veul-lo gavé $1 da sò amis?',
	'ur-remove-relationship-title-confirm-friend' => "It l'has gavà $1 da tò amis",
	'ur-remove-relationship-message-foe' => 'A l\'ha ciamà ëd gavé $1 da sò nemis, ch\'a sgnaca "$2" për confirmé.',
	'ur-remove-relationship-message-confirm-foe' => "It l'has gavà da bin $1 da tò nemis.",
	'ur-remove-relationship-message-friend' => 'A l\'ha ciamà ëd gavé $1 da sò amis, ch\'a sgnaca "$2" për confirmé.',
	'ur-remove-relationship-message-confirm-friend' => "It l'has gavà $1 da bin da tò amis.",
	'ur-remove-error-message-no-relationship' => "It l'has pa relassion con $1.",
	'ur-remove-error-message-remove-yourself' => 'It peule pa gavé ti midem.',
	'ur-remove-error-message-pending-foe-request' => "A l'has n'arcesta ëd nemis an cors con $1.",
	'ur-remove-error-message-pending-friend-request' => "It l'has n'arcesta pendenta d'amis con $1.",
	'ur-remove-error-not-loggedin-foe' => 'A deuv intré ant ël sistema për gavé un nemis.',
	'ur-remove-error-not-loggedin-friend' => "A deuv esse intrà ant ël sistema për gavé n'amis.",
	'ur-remove' => 'Gava',
	'ur-cancel' => 'Scancela',
	'ur-login' => 'Intra',
	'ur-add-title-foe' => 'Veul-lo gionté $1 com sò nemis?',
	'ur-add-title-friend' => 'Veul-lo gionté $1 com sò amis?',
	'ur-add-message-foe' => "A l'é an sël pont ëd gionté $1 com sò nemis.
I notifichëroma a $1 për confirmé vòstra rusa.",
	'ur-add-message-friend' => "A l'é an sël pont ëd gionté $1 com sò amis.
I notifichëroma a $1 për confirmé vòsta amicissia.",
	'ur-add-button-foe' => 'Gionta com nemis',
	'ur-add-button-friend' => 'Gionta com amis',
	'ur-add-sent-title-foe' => "I l'oma mandà toa arcesta ëd nemis a $1!",
	'ur-add-sent-title-friend' => "I l'oma mandà toa arcesta d'amis a $1!",
	'ur-add-sent-message-foe' => "Soa arcesta ëd nemis a l'é stàita mandà a $1 për conferma.
Se $1 a conferma soa arcesta, chiel a arseivrà na conferma për pòsta eletrònica.",
	'ur-add-sent-message-friend' => "Soa arcesta d'amis a l'é stàita mandà a $1 për conferma.
Se $1 a confirmrà soa arcesta, chiel a arseivrà la comunicassion an pòsta eletrònica",
	'ur-add-error-message-no-user' => "L'utent ch'it preuve a gionté a esist pa.",
	'ur-add-error-message-blocked' => 'It ses blocà al moment e it peule pa gionté amis o nemis.',
	'ur-add-error-message-yourself' => 'It peule pa gionté ti midem com amis o nemis.',
	'ur-add-error-message-existing-relationship-foe' => 'It ses già nemis con $1.',
	'ur-add-error-message-existing-relationship-friend' => 'It ses già amis con $1.',
	'ur-add-error-message-pending-request-title' => 'Passiensa!',
	'ur-add-error-message-pending-friend-request' => "A l'ha n'arcesta d'amis an cors con $1.
I-j notifichëroma quand $1 a conferma soa arcesta.",
	'ur-add-error-message-pending-foe-request' => "A l'ha n'arcesta ëd nemis an cors con $1.
I-j notifichëroma quand $1 a conferma soa arcesta.",
	'ur-add-error-message-not-loggedin-foe' => 'A deuv esse intrà ant ël sistema për gionté un nemis',
	'ur-add-error-message-not-loggedin-friend' => "A deuv esse intrà ant ël sistema për gionté n'amis",
	'ur-requests-title' => 'Arceste ëd relassion',
	'ur-requests-message-foe' => '<a href="$1">$2</a> a veul esse tò nemis.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> a veul esse tò amis.',
	'ur-accept' => 'Aceté',
	'ur-reject' => 'Arfuda',
	'ur-no-requests-message' => "A l'ha gnun-e arceste d'amis o ëd nemis.
S'a veul pi d'amis, <a href=\"\$1\">ch'a j'anvita!</a>",
	'ur-requests-added-message-foe' => "It l'has giontà $1 com tò nemis.",
	'ur-requests-added-message-friend' => "It l'has giontà $1 com tò amis.",
	'ur-requests-reject-message-friend' => "It l'has arfudà $1 com tò amis.",
	'ur-requests-reject-message-foe' => "It l'has arfudà $1 com tò nemis.",
	'ur-title-foe' => 'Lista dij nemis ëd $1',
	'ur-title-friend' => "Lista dj'amis ëd $1",
	'friend_request_subject' => "$1 a l'ha giontalo tanme amis dzora a {{SITENAME}}!",
	'friend_request_body' => "Cerea $1.

$2 a l'ha giontalo com amis dzora a {{SITENAME}}. I voroma esse sigur che adess voi doi i seve amis.

Për piasì ch'a sgnaca st'anliura-sì për confirmé vòsta amicissia:
$3

Mersì

---

Ch'a scota, veul-lo pa pi arsèive ëd mëssagi da noi?

Ch'a sgnaca $4
e ch'a cambia soe ampostassion për disabilité le notìfiche për pòsta eletrònica.",
	'foe_request_subject' => "A l'é la guèra! $1 a l'ha giontalo com nemis ansima a {{SITENAME}}!",
	'foe_request_body' => "Cerea $1.

$2 a l'ha pen-a butalo com nemis dzora a {{SITENAME}}. I voroma esse sigur che adess voi doi i seve nemis mortaj o almanch i l'eve na rusa.

Për piasì ch'a sgnaca st'anliura-sì për confirmé vòsta rusa:
$3

Mersì

---

Ch'a scota, veul-lo pa pi arsèive ëd mëssagi da noi?

Ch'a sgnaca $4
e ch'a cambia soe ampostassion për disabilité le notìfiche an pòsta eletrònica.",
	'friend_accept_subject' => "$1 a l'ha acetà soa arcesta d'amis dzora a {{SITENAME}}!",
	'friend_accept_body' => "Cerea $1.

$2 a l'ha acetà soa arcesta d'amis dzora {{SITENAME}}!

Ch'a contròla la pàgina ëd $2 a $3

Mersì

---

Ch'a scota, veul-lo pa pi arsèive ëd mëssagi da noi?

Ch'a sgnaca $4
e ch'a cambia soe ampostassion për disabilité le notìfiche për pòsta eletrònica.",
	'foe_accept_subject' => "Bele fàit! $1 a l'ha acetà soa arcesta ëd nemis dzora a {{SITENAME}}!",
	'foe_accept_body' => "Cerea $1.

$2 a l'ha acetà soa arcesta ëd nemis dzora a {{SITENAME}}!

Ch'a contròla la pàgina ëd $2 a $3

Mersì

---

Ch'a scota, veul-lo pa pi arsèive ëd mëssagi da noi?

Ch'a sgnaca $4
e ch'a cambia soe ampostassion për disabilité le notìfiche për pòsta eletrònica.",
	'friend_removed_subject' => "Oh nò! $1 a l'ha gavalo da amis dzora a {{SITENAME}}!",
	'friend_removed_body' => "Cerea $1.

$2 a l'ha gavalo da amis dzora a {{SITENAME}}.

Mersì

---

Ch'a scota, veul-lo pa pi arsèive ëd mëssagi da noi?

Ch'a sgnaca $4
e ch'a cambia soe ampostassion për disabilité le notìfiche për pòsta eletrònica.",
	'foe_removed_subject' => "Contacc! $1 a l'ha gavalo da nemis dzora a {{SITENAME}}!",
	'foe_removed_body' => "Cerea $1.

$2 a l'ha gavalo da nemis dzora a {{SITENAME}}.

Miraco voi doi i seve an sla stra dë vnì amis?

Mersì

---

Ch'a scota, veul-lo pa pi arsèive e-mail da noi?

Ch'a sgnaca $4
e ch'a cambia toe ampostassion për disabilité le notìfiche an pòsta eletrònica.",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'viewrelationships' => 'اړيکې کتل',
	'viewrelationshiprequests' => 'د اړيکو غوښتنې کتل',
	'ur-already-submitted' => 'ستاسې غوښتنه ولېږل شوه',
	'ur-main-page' => 'لومړی مخ',
	'ur-your-profile' => 'ستاسې پېژنليک',
	'ur-add-friend' => 'خپل په ملګرو کې ورګډول',
	'ur-add-foe' => 'د سيال په توګه ورګډول',
	'ur-add-personal-message' => 'يو شخصي پيغام ورليکل',
	'ur-remove-relationship-friend' => 'د ملګرتوب نه ليري کول',
	'ur-remove-relationship-foe' => 'د سيالۍ نه ليري کول',
	'ur-give-gift' => 'يوه ډالۍ ورکول',
	'ur-previous' => 'پخوانی',
	'ur-next' => 'راتلونکي',
	'ur-remove-relationship-title-foe' => 'آيا تاسې غواړۍ چې $1 د خپلې سيالۍ نه ليرې کړۍ؟',
	'ur-remove-relationship-title-friend' => 'آيا تاسې غواړۍ چې $1 د خپل ملګرتوب نه ليرې کړۍ؟',
	'ur-remove-error-message-remove-yourself' => 'تاسې خپل ځان نه شی ليري کولای.',
	'ur-remove' => 'غورځول',
	'ur-cancel' => 'ناګارل',
	'ur-login' => 'ننوتل',
	'ur-add-title-foe' => 'آيا تاسې $1 د يوه سيال په توګه د ځان سره ګډول غواړۍ؟',
	'ur-add-title-friend' => 'آيا تاسې $1 د يوه ملګري په توګه د ځان سره ګډول غواړۍ؟',
	'ur-add-button-foe' => 'د سيال په توګه ورګډول',
	'ur-add-button-friend' => 'د ملګري په توګه ورګډول',
	'ur-add-error-message-existing-relationship-friend' => 'تاسې د پخوا نه د $1 سره ملګری ياست.',
	'ur-add-error-message-pending-request-title' => 'صبر وکړۍ!',
	'ur-requests-title' => 'د اړيکو غوښتنې',
	'ur-accept' => 'منل',
	'ur-reject' => 'ردول',
	'ur-requests-added-message-foe' => '$1 مو د يوه سيال په توګه د ځان سره ګډ کړ.',
	'ur-title-foe' => 'د $1 د سيالانو لړليک',
	'ur-title-friend' => 'د $1 ملګرو لړليک',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Lijealso
 * @author Malafaya
 * @author Vanessa Sabino
 * @author Waldir
 */
$messages['pt'] = array(
	'viewrelationships' => 'Ver relacionamentos',
	'viewrelationshiprequests' => 'Ver pedidos de relacionamento',
	'ur-already-submitted' => 'O seu pedido foi enviado',
	'ur-error-page-title' => 'Ui!',
	'ur-error-title' => 'Ui, enganou-se no caminho!',
	'ur-error-message-no-user' => 'Não podemos processar o seu pedido, porque não existe um utilizador com esse nome.',
	'ur-main-page' => 'Página principal',
	'ur-your-profile' => 'O seu perfil',
	'ur-backlink' => '&lt; Voltar ao perfil de $1',
	'ur-relationship-count-foes' => '$1 tem $2 {{PLURAL:$2|inimigo|inimigos}}. Quer mais inimigos? <a href="$3">Convide-os.</a>',
	'ur-relationship-count-friends' => '$1 tem $2 {{PLURAL:$2|amigo|amigos}}. Quer mais amigos? <a href="$3">Convide-os.</a>',
	'ur-add-friends' => ' Quer mais amigos? <a href="$1">Convide-os</a>',
	'ur-add-friend' => 'Adicionar aos amigos',
	'ur-add-foe' => 'Adicionar aos inimigos',
	'ur-add-no-user' => 'Nenhum utilizador foi seleccionado.
Por favor peça amigos/inimigos através do link correcto.',
	'ur-add-personal-message' => 'Adicionar uma mensagem pessoal',
	'ur-remove-relationship-friend' => 'Remover dos amigos',
	'ur-remove-relationship-foe' => 'Remover dos inimigos',
	'ur-give-gift' => 'Dar uma prenda',
	'ur-previous' => 'ant',
	'ur-next' => 'prox',
	'ur-remove-relationship-title-foe' => 'Quer remover $1 dos seus inimigos?',
	'ur-remove-relationship-title-confirm-foe' => 'Removeu $1 dos seus inimigos',
	'ur-remove-relationship-title-friend' => 'Quer remover $1 dos seus amigos?',
	'ur-remove-relationship-title-confirm-friend' => 'Removeu $1 dos seus amigos',
	'ur-remove-relationship-message-foe' => 'Pediu para remover $1 dos seus inimigos, pressione "$2" para confirmar.',
	'ur-remove-relationship-message-confirm-foe' => 'Removeu com sucesso $1 dos seus inimigos.',
	'ur-remove-relationship-message-friend' => 'Pediu para remover $1 dos seus amigos, pressione "$2" para confirmar.',
	'ur-remove-relationship-message-confirm-friend' => 'Removeu com sucesso $1 dos seus amigos.',
	'ur-remove-error-message-no-relationship' => 'Não possui um relacionamento com $1.',
	'ur-remove-error-message-remove-yourself' => 'Não se pode remover a si mesmo.',
	'ur-remove-error-message-pending-foe-request' => 'Tem um pedido de inimizade pendente de $1.',
	'ur-remove-error-message-pending-friend-request' => 'Tem um pedido de amizade pendente de $1.',
	'ur-remove-error-not-loggedin-foe' => 'Tem de estar autenticado para remover um inimigo.',
	'ur-remove-error-not-loggedin-friend' => 'Tem de estar autenticado para remover um amigo.',
	'ur-remove' => 'Remover',
	'ur-cancel' => 'Cancelar',
	'ur-login' => 'Autenticar-se',
	'ur-add-title-foe' => 'Quer adicionar $1 aos seus inimigos?',
	'ur-add-title-friend' => 'Quer adicionar $1 aos seus amigos?',
	'ur-add-message-foe' => 'Está prestes a adicionar $1 aos seus inimigos.
Vamos notificar $1 para confirmar o seu rancor.',
	'ur-add-message-friend' => 'Está prestes a adicionar $1 aos seus amigos.
Vamos notificar $1 para confirmar a sua amizade.',
	'ur-add-button-foe' => 'Adicionar aos inimigos',
	'ur-add-button-friend' => 'Adicionar aos amigos',
	'ur-add-sent-title-foe' => 'Enviamos o seu pedido de inimizade para $1!',
	'ur-add-sent-title-friend' => 'Enviamos o seu pedido de amizade para $1!',
	'ur-add-sent-message-foe' => 'O seu pedido de inimizade foi enviado para $1 para confirmação.
Se $1 confirmar o pedido, receberá uma notificação por correio electrónico',
	'ur-add-sent-message-friend' => 'O seu pedido de amizade foi enviado para $1 para confirmação.
Se $1 confirmar o pedido, receberá uma notificação por correio electrónico',
	'ur-add-error-message-no-user' => 'O utilizador que pretende adicionar não existe.',
	'ur-add-error-message-blocked' => 'Neste momento está bloqueado e não pode adicionar amigos nem inimigos.',
	'ur-add-error-message-yourself' => 'Não pode adicionar-se aos amigos ou inimigos.',
	'ur-add-error-message-existing-relationship-foe' => 'Já é inimigo de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Já é amigo de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciência!',
	'ur-add-error-message-pending-friend-request' => 'Tem um pedido de amizade pendente com $1.
Vamos notificá-lo quando $1 confirmar o seu pedido.',
	'ur-add-error-message-pending-foe-request' => 'Tem um pedido de inimizade pendente com $1.
Vamos notificá-lo quando $1 confirmar o seu pedido.',
	'ur-add-error-message-not-loggedin-foe' => 'É preciso ter-se autenticado para adicionar um inimigo',
	'ur-add-error-message-not-loggedin-friend' => 'É preciso ter-se autenticado para adicionar um amigo',
	'ur-requests-title' => 'Pedidos de relacionamento',
	'ur-requests-message-foe' => '<a href="$1">$2</a> quer ser seu inimigo.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> quer ser seu amigo.',
	'ur-accept' => 'Aceitar',
	'ur-reject' => 'Rejeitar',
	'ur-no-requests-message' => 'Não tem pedidos de amizade ou inimizade.
Se quer ter mais amigos, <a href="$1">convide-os!</a>',
	'ur-requests-added-message-foe' => 'Adicionou $1 aos inimigos.',
	'ur-requests-added-message-friend' => 'Adicionou $1 aos amigos.',
	'ur-requests-reject-message-friend' => 'Rejeitou $1 como amigo.',
	'ur-requests-reject-message-foe' => 'Rejeitou $1 como inimigo.',
	'ur-title-foe' => 'lista de inimigos de $1',
	'ur-title-friend' => 'lista de amigos de $1',
	'friend_request_subject' => '$1 adicionou-o aos amigos na {{SITENAME}}!',
	'friend_request_body' => 'Olá $1,

$2 adicionou-o aos amigos na {{SITENAME}}. Queremos ter a certeza de que são realmente amigos.

Por favor, clique neste link para confirmar a vossa amizade:
$3

Obrigado

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'foe_request_subject' => 'É a guerra! $1 adicionou-o aos inimigos na {{SITENAME}}!',
	'foe_request_body' => 'Olá $1,

$2 acabou de listá-lo como inimigo na {{SITENAME}}. Queremos ter certeza de que são realmente inimigos mortais ou pelo menos que tiveram um desentendimento.

Por favor, clique neste link para confirmar o rancor.

$3

Obrigado

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'friend_accept_subject' => '$1 aceitou o seu pedido de amizade na {{SITENAME}}!',
	'friend_accept_body' => 'Olá $1,

$2 aceitou-o como amigo na {{SITENAME}}!

Veja a página de $2 em $3

Obrigado,

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'foe_accept_subject' => '$1 aceitou o seu pedido de inimizade na {{SITENAME}}!',
	'foe_accept_body' => 'Olá $1,

$2 aceitou-o como inimigo na {{SITENAME}}!

Veja a página de $2 em $3

Obrigado,

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'friend_removed_subject' => 'Oh não! $1 removeu-o dos amigos na {{SITENAME}}!',
	'friend_removed_body' => 'Olá $1,

$2 removeu-o dos amigos na {{SITENAME}}!

Obrigado,

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
	'foe_removed_subject' => 'É pá! $1 removeu-o dos amigos na {{SITENAME}}!',
	'foe_removed_body' => 'Olá $1,

$2 remove-o dos inimigos na {{SITENAME}}!

Será que estão a caminho de tornar-se amigos?

Obrigado,

---

Olhe, quer parar de receber as nossas mensagens?

Clique $4
e altere as suas preferências para desactivar as notificações por correio electrónico.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Helder.wiki
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'viewrelationships' => 'Ver relacionamentos',
	'viewrelationshiprequests' => 'Ver pedidos de relacionamentos',
	'ur-already-submitted' => 'Seu pedido foi enviado',
	'ur-error-page-title' => 'Ops!',
	'ur-error-title' => 'Ooops, você pegou um caminho errado!',
	'ur-error-message-no-user' => 'Não podemos completar a sua requisição, não existe um utilizador com este nome.',
	'ur-main-page' => 'Página principal',
	'ur-your-profile' => 'Seu perfil',
	'ur-backlink' => '&lt; Voltar ao perfil de $1',
	'ur-relationship-count-foes' => '$1 tem $2 {{PLURAL:$2|inimigo|inimigos}}. Quer mais inimigos? <a href="$3">Convide-os.</a>',
	'ur-relationship-count-friends' => '$1 tem $2 {{PLURAL:$2|amigo|amigos}}. Quer mais amigos? <a href="$3">Convide-os.</a>',
	'ur-add-friends' => '  Quer mais amigos? <a href="$1">Convide-os</a>',
	'ur-add-friend' => 'Adicionar como amigo',
	'ur-add-foe' => 'Adicionar como inimigo',
	'ur-add-no-user' => 'Nenhum utilizador selecionado.
Por favor peça amigos/inimigos através da ligação correta.',
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
	'ur-remove-error-message-pending-foe-request' => 'Você tem um pedido de inimizade pendente com $1.',
	'ur-remove-error-message-pending-friend-request' => 'Você tem um pedido de amizade pendente com $1.',
	'ur-remove-error-not-loggedin-foe' => 'Você tem que estar logado para remover um inimigo.',
	'ur-remove-error-not-loggedin-friend' => 'Você tem que estar logado para remover um amigo.',
	'ur-remove' => 'Remover',
	'ur-cancel' => 'Cancelar',
	'ur-login' => 'Autenticar-se',
	'ur-add-title-foe' => 'Você quer adicionar $1 como seu inimigo?',
	'ur-add-title-friend' => 'Você quer adicionar $1 como seu amigo?',
	'ur-add-message-foe' => 'Você está prestes a adicionar $1 como seu inimigo.
Nós iremos notificar $1 para confirmar seu rancor.',
	'ur-add-message-friend' => 'Você está prestes a adicionar $1 como seu amigo.
Nós iremos notificar $1 para confirmar sua amizade.',
	'ur-add-button-foe' => 'Adicionar como inimigo',
	'ur-add-button-friend' => 'Adicionar como amigo',
	'ur-add-sent-title-foe' => 'Nós enviamos seu pedido de inimizade para $1!',
	'ur-add-sent-title-friend' => 'Nós enviamos seu pedido de amizade para $1!',
	'ur-add-sent-message-foe' => 'Seu pedido de inimizade foi enviado para $1 para confirmação.
Se $1 confirmar seu pedido, você irá receber um e-mail',
	'ur-add-sent-message-friend' => 'Seu pedido de amizade foi enviado para $1 para confirmação.
Se $1 confirmar seu pedido, você irá receber um e-mail',
	'ur-add-error-message-no-user' => 'O utilizador que pretende adicionar não existe.',
	'ur-add-error-message-blocked' => 'Você está bloqueado atualmente e não pode adicionar amigos ou inimigos.',
	'ur-add-error-message-yourself' => 'Você não pode adicionar a si mesmo como amigo ou inimigo.',
	'ur-add-error-message-existing-relationship-foe' => 'Você já é inimigo de $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Você já é amigo de $1.',
	'ur-add-error-message-pending-request-title' => 'Paciência!',
	'ur-add-error-message-pending-friend-request' => 'Você tem um pedido de amizade pendente com $1.
Nós iremos notificar você quando $1 confirmar seu pedido.',
	'ur-add-error-message-pending-foe-request' => 'Você tem um pedido de inimizade pendente com $1.
Nós iremos notificar você quando $1 confirmar seu pedido.',
	'ur-add-error-message-not-loggedin-foe' => 'Você precisa estar autenticado para adicionar um inimigo',
	'ur-add-error-message-not-loggedin-friend' => 'Você precisa estar autenticado para adicionar um amigo',
	'ur-requests-title' => 'Pedidos de relacionamento',
	'ur-requests-message-foe' => '<a href="$1">$2</a> quer ser seu inimigo.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> quer ser seu amigo.',
	'ur-accept' => 'Aceitar',
	'ur-reject' => 'Rejeitar',
	'ur-no-requests-message' => 'Você não tem pedidos de amizade ou inimizade.
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
	'foe_request_body' => 'Oi $1:

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
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'ur-error-page-title' => 'Ups!',
	'ur-error-title' => 'Ups, ați greșit pagina!',
	'ur-main-page' => 'Pagina principală',
	'ur-your-profile' => 'Profilul dvs.',
	'ur-backlink' => '&lt; Înapoi la profilul lui $1',
	'ur-add-friend' => 'Adăugați ca prieten',
	'ur-add-foe' => 'Adauga ca inamic',
	'ur-add-personal-message' => 'Adăugați un mesaj personal',
	'ur-remove-relationship-friend' => 'Eliminați ca prieten',
	'ur-remove-relationship-foe' => 'Eliminați ca inamic',
	'ur-give-gift' => 'Dați un cadou',
	'ur-previous' => 'prec',
	'ur-next' => 'următoarea',
	'ur-remove' => 'Elimină',
	'ur-cancel' => 'Anulează',
	'ur-login' => 'Autentificare',
	'ur-add-button-foe' => 'Adaugă ca dușman',
	'ur-add-button-friend' => 'Adaugă ca prieten',
	'ur-add-error-message-pending-request-title' => 'Răbdare!',
	'ur-requests-title' => 'Cereri de relații',
	'ur-accept' => 'Acceptare',
	'ur-reject' => 'Revocare',
	'ur-title-friend' => 'Lista de prieteni ai lui $1',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'ur-error-page-title' => 'Cè cumbenate!',
	'ur-main-page' => 'Pàgene Prengepàle',
	'ur-your-profile' => "'U profile tue",
	'ur-give-gift' => "Fa 'nu riele",
	'ur-previous' => 'prec',
	'ur-next' => 'succ',
	'ur-remove' => 'Scangille',
	'ur-cancel' => 'Scangille',
	'ur-login' => 'Trase',
	'ur-add-button-friend' => 'Aggiugne cumme amiche',
	'ur-add-error-message-pending-request-title' => 'Pascenze!',
	'ur-requests-message-friend' => '<a href="$1">$2</a> vvò ccu devende amiche tue.',
	'ur-accept' => 'Accitte',
	'ur-reject' => 'Scitte',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Flrn
 * @author Innv
 * @author Lockal
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'viewrelationships' => 'Посмотреть отношения',
	'viewrelationshiprequests' => 'Посмотреть запросы отношений',
	'ur-already-submitted' => 'Ваш запрос был отправлен',
	'ur-error-page-title' => 'Опа!',
	'ur-error-title' => 'Оп, дела приняли неправильный поворот!',
	'ur-error-message-no-user' => 'Мы не можем выполнить ваш запрос, так как участника с таким именем не существует.',
	'ur-main-page' => 'Заглавная страница',
	'ur-your-profile' => 'Ваш профиль',
	'ur-backlink' => '&lt; Вернуться к профилю $1',
	'ur-relationship-count-foes' => '$1 имеет $2 {{PLURAL:$2|недруга|недругов|недругов}}.
Недостаточно?
<a href="$3">Пригласите их.</a>',
	'ur-relationship-count-friends' => '$1 имеет $2 {{PLURAL:$2|друга|друга|друзей}}.
Хотите больше друзей?
<a href="$3">Пригласите их.</a>',
	'ur-add-friends' => '  Хотите больше друзей?
<a href="$1">Пригласите их</a>',
	'ur-add-friend' => 'Добавить в друзья',
	'ur-add-foe' => 'Добавить в недруги',
	'ur-add-no-user' => 'Участник не выбран.
Пожалуйста, подавайте запрос на добавление в друзья/недруги через исправную ссылку.',
	'ur-add-personal-message' => 'Добавить личное сообщение',
	'ur-remove-relationship-friend' => 'Убрать из друзей',
	'ur-remove-relationship-foe' => 'Убрать из недругов',
	'ur-give-gift' => 'Подарить подарок',
	'ur-previous' => 'предыдущий',
	'ur-next' => 'следующий',
	'ur-remove-relationship-title-foe' => 'Вы хотите удалить $1 из списка ваших недругов?',
	'ur-remove-relationship-title-confirm-foe' => 'Вы удалили $1 из списка ваших недругов',
	'ur-remove-relationship-title-friend' => 'Вы хотите удалить $1 из списка ваших друзей?',
	'ur-remove-relationship-title-confirm-friend' => 'Вы удалили $1 из списка ваших друзей',
	'ur-remove-relationship-message-foe' => 'Вы запросили удаление $1 из списка ваших недругов, нажмите «$2» для подтверждения.',
	'ur-remove-relationship-message-confirm-foe' => 'Вы успешно удалили $1 из списка ваших недругов.',
	'ur-remove-relationship-message-friend' => 'Вы запросили удаление $1 из списка ваших друзей, нажмите «$2» для подтверждения.',
	'ur-remove-relationship-message-confirm-friend' => 'Вы успешно удалили $1 из списка ваших друзей.',
	'ur-remove-error-message-no-relationship' => 'У вас не установлено отношений с $1.',
	'ur-remove-error-message-remove-yourself' => 'Вы не можете удалить себя.',
	'ur-remove-error-message-pending-foe-request' => 'У вас не закрыт запрос на добавление $1 в список недругов.',
	'ur-remove-error-message-pending-friend-request' => 'У вас не закрыт запрос на добавление $1 в список друзей.',
	'ur-remove-error-not-loggedin-foe' => 'Вы должны войти в систему, чтобы удалять участников из списка недругов.',
	'ur-remove-error-not-loggedin-friend' => 'Вы должны войти в систему, чтобы удалять участников из списка друзей.',
	'ur-remove' => 'Удалить',
	'ur-cancel' => 'Отмена',
	'ur-login' => 'Логин',
	'ur-add-title-foe' => 'Вы желаете добавить $1 в список ваших недругов?',
	'ur-add-title-friend' => 'Вы желаете добавить $1 в список ваших друзей?',
	'ur-add-message-foe' => 'Вы собираетесь добавить $1 в список ваших недругов.
Мы запросим у $1 подтверждение вашей неприязни.',
	'ur-add-message-friend' => 'Вы собираетесь добавить $1 в список ваших друзей.
Мы запросим у $1 подтверждение ваших дружеских отношений.',
	'ur-add-button-foe' => 'Добавить в недруги',
	'ur-add-button-friend' => 'Добавить в друзья',
	'ur-add-sent-title-foe' => 'Мы запросили у $1 подтверждение вашего статуса недруга!',
	'ur-add-sent-title-friend' => 'Мы запросили у $1 подтверждение вашего статуса друга!',
	'ur-add-sent-message-foe' => 'Ваш запрос на добавление в список недругов отправлен $1 для утверждения.
Если $1 подтвердит ваш запрос, то вы получите уведомление по электронной почте.',
	'ur-add-sent-message-friend' => 'Ваш запрос на добавление в список друзей отправлен $1 для утверждения.
Если $1 подтвердит ваш запрос, то вы получите уведомление по электронной почте.',
	'ur-add-error-message-no-user' => 'Участника, которого вы пытаетесь добавить, не существует.',
	'ur-add-error-message-blocked' => 'В настоящее время вы заблокированы и не можете добавлять участников в список друзей или врагов.',
	'ur-add-error-message-yourself' => 'Вы не можете добавлять себя в свой собственный список друзей или недругов.',
	'ur-add-error-message-existing-relationship-foe' => 'У вас уже установлены враждебные отношения с $1.',
	'ur-add-error-message-existing-relationship-friend' => 'У вас уже установлены дружеские отношения с $1.',
	'ur-add-error-message-pending-request-title' => 'Терпение!',
	'ur-add-error-message-pending-friend-request' => 'Вы ожидаете запрос друзей с $1.
Вы будете оповещены, если $1 подтверит ваш запрос.',
	'ur-add-error-message-pending-foe-request' => 'Вы ожидаете запрос недругов с $1.
Вы будете оповещены, если $1 подтверит ваш запрос.',
	'ur-add-error-message-not-loggedin-foe' => 'Вы должны представиться системе для добавления в недруги',
	'ur-add-error-message-not-loggedin-friend' => 'Вы должны представиться системе для добавления в друзья',
	'ur-requests-title' => 'Связанные запросы',
	'ur-requests-message-foe' => '<a href="$1">$2</a> хочет быть вашим недругом.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> хочет быть вашим другом.',
	'ur-accept' => 'Принять',
	'ur-reject' => 'Отклонить',
	'ur-no-requests-message' => 'Вы не имеете запросов друзей или недругов.
Если вы ищете ещё друзей, <a href="$1">приглашайте их!</a>',
	'ur-requests-added-message-foe' => 'Вы добавили $1 как вашего недруга.',
	'ur-requests-added-message-friend' => 'Вы добавили $1 как вашего друга.',
	'ur-requests-reject-message-friend' => 'Вы отклонили $1 как вашего друга.',
	'ur-requests-reject-message-foe' => 'Вы отклонили $1 как вашего недруга.',
	'ur-title-foe' => 'Список недругов $1',
	'ur-title-friend' => 'Список друзей $1',
	'friend_request_subject' => '$1 добавил вас как друга на {{SITENAME}}!',
	'friend_request_body' => 'Здравствуйте, $1.

$2 добавил вас в список друзей на {{SITENAME}}. Мы хотим подтвердить, что вы действительно являетесь друзьями.

Пожалуйста, перейдите по этой ссылке для подтверждения:
$3

Спасибо

---

Хотите остановить отправку вам электронной почты?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'foe_request_subject' => 'Это война! $1 добавил вас в недруги на {{SITENAME}}!',
	'foe_request_body' => 'Здравствуйте, $1.

$2 добавил вас в список недругов на {{SITENAME}}. Мы хотим подтвердить, что вы действительно являетесь недругами.

Пожалуйста, перейдите по этой ссылке для подтверждения:
$3

Спасибо

---

Хотите остановить отправку вам электронной почты?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'friend_accept_subject' => '$1 принял ваш запрос на добавление в список друзей на {{SITENAME}}!',
	'friend_accept_body' => 'Здравствуйте, $1.

$2 принял ваш запрос на добавление в друзья на {{SITENAME}}!

Проверьте страницу $2 на $3

Спасибо,

---

Хотите остановить отправку вам электронной почты?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'foe_accept_subject' => 'Это так! $1 принял ваш запрос на добавление в список недругов на {{SITENAME}}!',
	'foe_accept_body' => 'Здравствуйте, $1.

$2 принял ваш запрос на добавление в список недругов на {{SITENAME}}!

Проверьте страницу $2 на $3

Спасибо,

---

Хотите остановить отправку вам электронной почты?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'friend_removed_subject' => 'О нет! $1 удалил вас из списка друзей на {{SITENAME}}!',
	'friend_removed_body' => 'Здравствуйте, $1.

$2 удалил вас из списка друзей на {{SITENAME}}!

Спасибо

---

Хотите остановить отправку вам электронной почты?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
	'foe_removed_subject' => 'Ура! $1 удалил вас из списка недругов на {{SITENAME}}!',
	'foe_removed_body' => 'Здравствуйте, $1.

$2 удалил вас из списка недругов на {{SITENAME}}!

Возможно, вы находитесь на пути, стать друзьями?

Спасибо

---

Хотите остановить отправку вам электронной почты?

Нажмите $4
и измените ваши настройки, отключив отправку уведомлений по электронной почте.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'ur-main-page' => 'Головна сторінка',
	'ur-add-friend' => 'Придати як приятеля',
	'ur-previous' => 'попереднїй',
	'ur-next' => 'далшый',
	'ur-cancel' => 'Зрушыти',
	'ur-add-button-friend' => 'Придати як приятеля',
	'ur-accept' => 'Підтвердити',
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
	'ur-remove-error-message-pending-foe-request' => 'Máte čakajúcu požiadavku na nepriateľstvo s $1.',
	'ur-remove-error-message-pending-friend-request' => 'Máte čakajúcu požiadavku na priateľstvo s $1.',
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
	'ur-add-error-message-existing-relationship-foe' => 'Už ste nepriateľ s $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Už ste priateľ s $1.',
	'ur-add-error-message-pending-request-title' => 'Trpezlivosť!',
	'ur-add-error-message-pending-friend-request' => 'Máte žiadosť o uzatvorenie priateľstva s $1, ktorá čaká na potvrdenie.
Upozorníme vás, keď $1 potvrdí vašu žiadosť.',
	'ur-add-error-message-pending-foe-request' => 'Máte žiadosť o nepriateľstvo s $1, ktorá čaká na potvrdenie.
Upozorníme vás, keď $1 potvrdí vašu žiadosť.',
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

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'ur-error-page-title' => 'Upsala!',
	'ur-main-page' => 'Glavna stran',
	'ur-your-profile' => 'Vaš profil',
	'ur-give-gift' => 'Podari darilo',
	'ur-previous' => 'prejšnji',
	'ur-next' => 'naslednji',
	'ur-remove' => 'Odstrani',
	'ur-cancel' => 'Prekliči',
	'ur-login' => 'Prijava',
);

/** Serbian Cyrillic ekavian (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'ur-already-submitted' => 'Ваш захтев је послат',
	'ur-error-page-title' => 'Упс!',
	'ur-main-page' => 'Главна страна',
	'ur-your-profile' => 'Ваш профил',
	'ur-add-friend' => 'Додај као пријатеља',
	'ur-add-foe' => 'Додај као непријатеља',
	'ur-add-personal-message' => 'Додај личну поруку',
	'ur-remove-relationship-friend' => 'Обриши као пријатеља',
	'ur-remove-relationship-foe' => 'Обриши као непријатеља',
	'ur-give-gift' => 'Пошаљи поклон',
	'ur-previous' => 'претходни',
	'ur-next' => 'следећи',
	'ur-remove-relationship-title-foe' => 'Да ли желите да обришете $1 са Вашег списка непријатеља?',
	'ur-remove-relationship-title-confirm-foe' => 'Обрисали сте $1 са Вашег списка непријатеља',
	'ur-remove-relationship-title-friend' => 'Да ли желите да обришете $1 са Вашег списка пријатеља?',
	'ur-remove-relationship-title-confirm-friend' => 'Обрисали сте $1 са Вашег списка пријатеља',
	'ur-remove-relationship-message-foe' => 'Затражили сте да се $1 обрише са Вашег списка непријатеља, притисните "$2" да бисте то потврдили.',
	'ur-remove-relationship-message-confirm-foe' => 'Успешно сте обрисали $1 са Вашег списка непријатеља.',
	'ur-remove-relationship-message-friend' => 'Затражили сте да се $1 обрише са Вашег списка пријатеља, притисните "$2" да бисте то потврдили.',
	'ur-remove-relationship-message-confirm-friend' => 'Успешно сте обрисали $1 са Вашег списка пријатеља.',
	'ur-remove-error-message-no-relationship' => 'Нисте ни у каквом односу са $1.',
	'ur-remove-error-message-remove-yourself' => 'Не можете да обришете себе.',
	'ur-remove-error-message-pending-foe-request' => 'На чекању имате захтев за непријатељство са $1.',
	'ur-remove-error-message-pending-friend-request' => 'На чекању имате захтев за пријтељство са $1.',
	'ur-remove-error-not-loggedin-foe' => 'Морате бити улоговани да бисте уклонили некога са Вашег списка непријатеља.',
	'ur-remove-error-not-loggedin-friend' => 'Морате бити улоговани да бисте некога обрисали са списка пријатеља.',
	'ur-remove' => 'Уклони',
	'ur-cancel' => 'Откажи',
	'ur-login' => 'Пријава',
	'ur-add-title-foe' => 'Да ли желите да означите $1 као Вашег непријатеља?',
	'ur-add-title-friend' => 'Да ли желите да означите $1 као Вашег пријатеља?',
	'ur-add-button-foe' => 'Означи као непријатеља',
	'ur-add-button-friend' => 'Означи као пријатеља',
	'ur-add-error-message-no-user' => 'Корисник кога покушавате да означите не постоји.',
	'ur-add-error-message-blocked' => 'Тренутно сте блокирани и не можете да додајете пријатеље и непријатеље.',
	'ur-add-error-message-yourself' => 'Не можете да означите себе као свог пријатеља или непријатеља.',
	'ur-add-error-message-existing-relationship-foe' => '$1 је већ означен као Ваш непријатељ.',
	'ur-add-error-message-existing-relationship-friend' => '$1 је већ означен као Ваш пријатељ.',
	'ur-add-error-message-pending-request-title' => 'Стрпљења!',
	'ur-add-error-message-not-loggedin-foe' => 'Морате бити пријављени да бисте некога означили као непријатеља',
	'ur-add-error-message-not-loggedin-friend' => 'Морате бити пријављени да бисте некога означили као пријатеља',
	'ur-requests-message-foe' => '<a href="$1">$2</a> жели да буде Ваш непријатељ.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> жели да буде Ваш пријатељ.',
	'ur-accept' => 'Прихвати',
	'ur-reject' => 'Одбаци',
	'ur-requests-added-message-foe' => '$1 је означен као Ваш непријатељ.',
	'ur-requests-added-message-friend' => '$1 је означен као Ваш пријатељ.',
	'ur-requests-reject-message-friend' => 'Нисте прихватили $1 као пријатеља.',
	'ur-requests-reject-message-foe' => 'Нисте прихватили $1 као непријатеља.',
	'ur-title-foe' => 'Списак непријатеља за $1',
	'ur-title-friend' => 'Списак пријатеља за $1',
);

/** Serbian Latin ekavian (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'ur-already-submitted' => 'Vaš zahtev je poslat',
	'ur-error-page-title' => 'Ups!',
	'ur-main-page' => 'Glavna strana',
	'ur-your-profile' => 'Vaš profil',
	'ur-add-friend' => 'Dodaj kao prijatelja',
	'ur-add-foe' => 'Dodaj kao neprijatelja',
	'ur-add-personal-message' => 'Dodaj ličnu poruku',
	'ur-remove-relationship-friend' => 'Obriši kao prijatelja',
	'ur-remove-relationship-foe' => 'Obriši kao neprijatelja',
	'ur-give-gift' => 'Pošalji poklon',
	'ur-previous' => 'prethodni',
	'ur-next' => 'sledeći',
	'ur-remove-relationship-title-foe' => 'Da li želite da obrišete $1 sa Vašeg spiska neprijatelja?',
	'ur-remove-relationship-title-confirm-foe' => 'Obrisali ste $1 sa Vašeg spiska neprijatelja',
	'ur-remove-relationship-title-friend' => 'Da li želite da obrišete $1 sa Vašeg spiska prijatelja?',
	'ur-remove-relationship-title-confirm-friend' => 'Obrisali ste $1 sa Vašeg spiska prijatelja',
	'ur-remove-relationship-message-foe' => 'Zatražili ste da se $1 obriše sa Vašeg spiska neprijatelja, pritisnite "$2" da biste to potvrdili.',
	'ur-remove-relationship-message-confirm-foe' => 'Uspešno ste obrisali $1 sa Vašeg spiska neprijatelja.',
	'ur-remove-relationship-message-friend' => 'Zatražili ste da se $1 obriše sa Vašeg spiska prijatelja, pritisnite "$2" da biste to potvrdili.',
	'ur-remove-relationship-message-confirm-friend' => 'Uspešno ste obrisali $1 sa Vašeg spiska prijatelja.',
	'ur-remove-error-message-no-relationship' => 'Niste ni u kakvom odnosu sa $1.',
	'ur-remove-error-message-remove-yourself' => 'Ne možete da obrišete sebe.',
	'ur-remove-error-message-pending-foe-request' => 'Na čekanju imate zahtev za neprijateljstvo sa $1.',
	'ur-remove-error-message-pending-friend-request' => 'Na čekanju imate zahtev za prijteljstvo sa $1.',
	'ur-remove-error-not-loggedin-foe' => 'Morate biti ulogovani da biste uklonili nekoga sa Vašeg spiska neprijatelja.',
	'ur-remove-error-not-loggedin-friend' => 'Morate biti ulogovani da biste nekoga obrisali sa spiska prijatelja.',
	'ur-remove' => 'Ukloni',
	'ur-cancel' => 'Otkaži',
	'ur-login' => 'Prijava',
	'ur-add-title-foe' => 'Da li želite da označite $1 kao Vašeg neprijatelja?',
	'ur-add-title-friend' => 'Da li želite da označite $1 kao Vašeg prijatelja?',
	'ur-add-button-foe' => 'Označi kao neprijatelja',
	'ur-add-button-friend' => 'Označi kao prijatelja',
	'ur-add-error-message-no-user' => 'Korisnik koga pokušavate da označite ne postoji.',
	'ur-add-error-message-blocked' => 'Trenutno ste blokirani i ne možete da dodajete prijatelje i neprijatelje.',
	'ur-add-error-message-yourself' => 'Ne možete da označite sebe kao svog prijatelja ili neprijatelja.',
	'ur-add-error-message-existing-relationship-foe' => '$1 je već označen kao Vaš neprijatelj.',
	'ur-add-error-message-existing-relationship-friend' => '$1 je već označen kao Vaš prijatelj.',
	'ur-add-error-message-pending-request-title' => 'Strpljenja!',
	'ur-add-error-message-not-loggedin-foe' => 'Morate biti ulogovani da biste nekoga označili kao neprijatelja',
	'ur-add-error-message-not-loggedin-friend' => 'Morate biti ulogovani da biste nekoga označili kao prijatelja',
	'ur-requests-message-foe' => '<a href="$1">$2</a> želi da bude Vaš neprijatelj.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> želi da bude Vaš prijatelj.',
	'ur-accept' => 'Prihvati',
	'ur-reject' => 'Odbaci',
	'ur-requests-added-message-foe' => '$1 je označen kao Vaš neprijatelj.',
	'ur-requests-added-message-friend' => '$1 je označen kao Vaš prijatelj.',
	'ur-requests-reject-message-friend' => 'Niste prihvatili $1 kao prijatelja.',
	'ur-requests-reject-message-foe' => 'Niste prihvatili $1 kao neprijatelja.',
	'ur-title-foe' => 'Spisak neprijatelja za $1',
	'ur-title-friend' => 'Spisak prijatelja za $1',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'ur-main-page' => 'Likhasi lelikhulu',
);

/** Swedish (Svenska)
 * @author Gabbe.g
 * @author M.M.S.
 * @author Najami
 * @author Per
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
	'ur-remove-error-message-pending-foe-request' => 'Du har en väntande fiendebegäran hos $1.',
	'ur-remove-error-message-pending-friend-request' => 'Du har en väntande vänbegäran hos $1.',
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
	'ur-add-button-foe' => 'Lägg till som fiende',
	'ur-add-button-friend' => 'Lägg till som vän',
	'ur-add-sent-title-foe' => 'Vi har skickat din fiendeförfrågan till $1!',
	'ur-add-sent-title-friend' => 'Vi har skickat din vänskapsförfrågning till $1!',
	'ur-add-sent-message-foe' => 'Din fiendeförfrågan har skickats till $1 för bekräftelse.
Om $1 bekräftar din förfrågan kommer du att få ett e-post meddelande',
	'ur-add-sent-message-friend' => 'Din vänskaps begäran har skickats till $1 för godkännande.
Om $1 godkänner din begäran kommer du få ett uppföljningsmeddelande',
	'ur-add-error-message-no-user' => 'Användaren du prövade att lägga till finns inte.',
	'ur-add-error-message-blocked' => 'Du är blockerad, och kan inte lägga till vänner eller fiender.',
	'ur-add-error-message-yourself' => 'Du kan inte lägga till dig själv som vän eller fiende.',
	'ur-add-error-message-existing-relationship-foe' => 'Du är redan fiende med $1.',
	'ur-add-error-message-existing-relationship-friend' => 'Du är redan vän med $1.',
	'ur-add-error-message-pending-request-title' => 'Var tålmodig...',
	'ur-add-error-message-pending-friend-request' => 'Du har en väntande vänförfrågan hos $1.
Vi kommer ge dig ett besked när $1 bekräftar din begäran.',
	'ur-add-error-message-pending-foe-request' => 'Du har en väntande fiendeförfrågan hos $1.
Vi kommer ge dig besked när $1 bekräftar din begäran.',
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

/** Tamil (தமிழ்)
 * @author TRYPPN
 * @author செல்வா
 */
$messages['ta'] = array(
	'ur-previous' => 'முந்தைய',
	'ur-next' => 'அடுத்தது',
	'ur-remove' => 'நீக்குக',
	'ur-cancel' => 'செய்யாமல் விடுக',
	'ur-login' => 'புகுபதிகை',
	'ur-accept' => 'ஒத்துக்கொள்',
	'ur-reject' => 'ஒதுக்கித் தள்ளு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'viewrelationships' => 'బంధాన్ని చూడండి',
	'ur-already-submitted' => 'మీ అభ్యర్థనని పంపించాం',
	'ur-error-message-no-user' => 'మీ అభ్యర్థనని మన్నింపలేము, ఎందుకంటే ఈ పేరుతో వాడుకరులెవరూ లేరు.',
	'ur-main-page' => 'మొదటి పుట',
	'ur-your-profile' => 'మీ ప్రొఫైలు',
	'ur-add-friends' => ' మరింత మంది మిత్రులు కావాలా? <a href="$1">ఆహ్వానించండి</a>',
	'ur-add-friend' => 'స్నేహితునిగా చేర్చు',
	'ur-add-foe' => 'శత్రువుగా చేర్చు',
	'ur-add-personal-message' => 'ఒక వ్యక్తిగత సందేశాన్ని చేర్చండి',
	'ur-remove-relationship-friend' => 'స్నేహితునిగా తొలగించు',
	'ur-remove-relationship-foe' => 'శతృవుగా తొలగించు',
	'ur-give-gift' => 'ఒక బహుమతి ఇవ్వండి',
	'ur-previous' => 'క్రితం',
	'ur-next' => 'తర్వాతి',
	'ur-remove-relationship-title-confirm-foe' => '$1ని మీ శతృవుగా తొలగించుకున్నారు.',
	'ur-remove-relationship-title-friend' => '$1 ని మీ మిత్రునిగా తొలగించమంటారా?',
	'ur-remove-relationship-title-confirm-friend' => '$1ని మీ మిత్రునిగా తొలగించుకున్నారు',
	'ur-remove-error-message-remove-yourself' => 'మిమ్మల్ని మీరే తొలగించుకోలేరు.',
	'ur-remove' => 'తొలగించు',
	'ur-cancel' => 'రద్దు',
	'ur-login' => 'ప్రవేశించండి',
	'ur-add-title-foe' => '$1ని మీ శతృవుగా చేర్చమంటారా?',
	'ur-add-title-friend' => '$1ని మీ మిత్రునిగా చేర్చమంటారా?',
	'ur-add-button-foe' => 'శతృవుగా చేర్చు',
	'ur-add-button-friend' => 'మిత్రునిగా చేర్చు',
	'ur-add-error-message-no-user' => 'మీరు చేర్చాలని ప్రయత్నిస్తున్న వాడుకరి లేనే లేరు.',
	'ur-add-error-message-yourself' => 'మిమ్మల్ని మీరే స్నేహితునిగానో లేదా శత్రువుగానో చేర్చుకోలేరు.',
	'ur-add-error-message-existing-relationship-foe' => 'మీరు ఇప్పటికే $1కి శతృవులు.',
	'ur-add-error-message-existing-relationship-friend' => 'మీరు ఇప్పటికే $1కి మిత్రులు.',
	'ur-add-error-message-pending-request-title' => 'ఓపిక!',
	'ur-requests-title' => 'సంబంధ అభ్యర్థనలు',
	'ur-accept' => 'అంగీకరించు',
	'ur-reject' => 'తిరస్కరించు',
	'ur-no-requests-message' => 'మీకు మిత్రుత్వ లేదా శత్రుత్వ అభ్యర్థనలు లేవు. మీకు మరింత మంది స్నేహితులు కావాలంటే, <a href="$1">వారిని ఆహ్వానించండి!</a>',
	'ur-requests-reject-message-friend' => 'మీరు $1ని మీ స్నేహితునిగా తిరస్కరించారు.',
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
	'ur-remove' => 'Hasai',
	'ur-cancel' => 'Para',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'ur-main-page' => 'Саҳифаи Аслӣ',
	'ur-your-profile' => 'Намояи шумо',
	'ur-add-friends' => ' Бештар дӯстон мехоҳед? <a href="$1">Онҳоро даъват кунед</a>',
	'ur-add-friend' => 'Чун дӯст илова кунед',
	'ur-add-foe' => 'Чун ҳариф илова кунед',
	'ur-give-gift' => 'Ҳадя диҳед',
	'ur-previous' => 'қаблӣ',
	'ur-next' => 'баъдӣ',
	'ur-remove-error-message-no-relationship' => 'Шумо муносибате бо $1 надоред.',
	'ur-remove-error-message-remove-yourself' => 'Шумо худро наметавонед пок кунед.',
	'ur-remove' => 'Ҳазф',
	'ur-cancel' => 'Лағв',
	'ur-login' => 'Вуруд кунед',
	'ur-add-error-message-no-user' => 'Корбари шумо кӯшиши илова кардани ҳастед вуҷуд надорад.',
	'ur-add-error-message-yourself' => 'Шумо худро наметавонед чун дӯст ё ҳариф илова кунед.',
	'ur-add-error-message-pending-request-title' => 'Сабр!',
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

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'ur-main-page' => 'Sahifai Aslī',
	'ur-your-profile' => 'Namojai şumo',
	'ur-add-friends' => ' Beştar dūston mexohed? <a href="$1">Onhoro da\'vat kuned</a>',
	'ur-add-friend' => 'Cun dūst ilova kuned',
	'ur-add-foe' => 'Cun harif ilova kuned',
	'ur-give-gift' => 'Hadja dihed',
	'ur-previous' => 'qablī',
	'ur-next' => "ba'dī",
	'ur-remove-error-message-no-relationship' => 'Şumo munosibate bo $1 nadored.',
	'ur-remove-error-message-remove-yourself' => 'Şumo xudro nametavoned pok kuned.',
	'ur-remove' => 'Hazf',
	'ur-cancel' => 'Laƣv',
	'ur-login' => 'Vurud kuned',
	'ur-add-error-message-no-user' => 'Korbari şumo kūşişi ilova kardani hasted vuçud nadorad.',
	'ur-add-error-message-yourself' => 'Şumo xudro nametavoned cun dūst jo harif ilova kuned.',
	'ur-add-error-message-pending-request-title' => 'Sabr!',
	'ur-requests-title' => 'Darxosthoi irtibot',
	'ur-accept' => 'Paziruftan',
	'ur-reject' => 'Rad kardan',
	'friend_request_subject' => '$1 şumoro cun dūstaş dar {{SITENAME}} ilova kard!',
	'friend_request_body' => "Salom $1:

$2 şumoro hamcun dūst dar {{SITENAME}} ilova kard.  Mo mexohem mutmain boşem, ki şumo dar haqiqat dūston hasted.

Lutfan in pajvandro bo tasdiq kardani dūstiji xud paxş kuned:
$3

Taşakkur

---

Hoj, ojo şumo mexohed ba darjoft kardani nomahoi elektronī az mo xotima bidihed?

$4-ro klik kuned
va tarçihoti xudro bo ƣajrifa'ol kardani ogohsoziji tariqi poctai elektronī taƣjir dihed.",
	'foe_request_subject' => "In nizo' ast! $1 şumoro hamcun duşmani xud dar {{SITENAME}} ilova kard!",
	'foe_request_body' => "Salom $1:

$2 şumoro hamcun duşmani xud dar {{SITENAME}} ilova kard. Mo mexohem mutmain boşem, ki şumo dar haqiqat duşmanoni aşadī hasted jo haddi aqal munozira dored.

Lutfan in pajvandro bo tasdiq kardani rost naomadani munosibati dūstonaaton paxş kuned: $3

$3

Taşakkur

---

Hoj, ojo şumo mexohed ba darjoft kardani nomahoi elektronī az mo xotima bidihed?

$4-ro klik kuned va tarçihoti xudro bo ƣajrifa'ol kardani ogohsoziji tariqi poctai elektronī taƣjir dihed.",
	'friend_accept_subject' => '$1 darxosti dūstiji şumoro dar {{SITENAME}} qabul kard!',
	'friend_accept_body' => "Salom $1:

$2 darxosti dūstşaviji şumoro dar {{SITENAME}} qabul kard!

Sahifai $2-ro dar $3 nigared

Taşakkur,

---

Hoj, ojo şumo mexohed ba darjoft kardani nomahoi elektronī az mo xotima bidihed?

$4-ro klik kuned
va tarçihoti xudro bo ƣajrifa'ol kardani ogohsoziji tariqi poctai elektronī taƣjir dihed.",
	'foe_accept_subject' => 'Ana tamom! $1 darxosti harifiji şumoro dar {{SITENAME}} qabul kard!',
	'foe_accept_body' => "Salom $1:

$2 darxosti duşmaniji şumoro dar {{SITENAME}} qabul kard!

Sahifai $2-ro dar $3 nigared

Taşakkur,

---

Hoj, ojo şumo mexohed ba darjoft kardani nomahoi elektronī az mo xotima bidihed?

$4-ro klik kuned
va tarçihoti xudro bo ƣajrifa'ol kardani ogohsoziji tariqi poctai elektronī taƣjir dihed.",
	'friend_removed_subject' => 'Vah! $1 şumoro hamcun dūst dar {{SITENAME}} pok kard!',
	'friend_removed_body' => "Salom $1:

$2 şumoro hamcun dūst dar {{SITENAME}} pok kard!

Taşakkur

---

Hoj, ojo şumo mexohed ba darjoft kardani nomahoi elektronī az mo xotima bidihed?

$4-ro klik kuned
va tarçihoti xudro bo ƣajrifa'ol kardani ogohsoziji tariqi poctai elektronī taƣjir dihed.",
	'foe_removed_subject' => 'Uhu! $1 şumoro hamcun duşmani xud dar {{SITENAME}} pok kard!',
	'foe_removed_body' => "Salom $1:

$2 şumoro hamcun duşmani xud dar  {{SITENAME}} pok kard!

Şojad şumo hardu dar rohi dūst şudan boşed?

Taşakkur

---


Hoj, ojo şumo mexohed ba darjoft kardani nomahoi elektronī az mo xotima bidihed?

$4-ro klik kuned
va tarçihoti xudro bo ƣajrifa'ol kardani ogohsoziji tariqi poctai elektronī taƣjir dihed.",
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'ur-remove' => 'Aýyr',
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
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'viewrelationships' => 'İlişkiyi gör',
	'viewrelationshiprequests' => 'İlişki isteklerini gör',
	'ur-already-submitted' => 'İsteğiniz gönderildi',
	'ur-error-page-title' => 'Hay Allah!',
	'ur-error-title' => 'Hay Allah, yanlış yaptınız!',
	'ur-error-message-no-user' => 'İsteğinizi tamamlayamıyoruz, zira bu isimde bir kullanıcı mevcut değil.',
	'ur-main-page' => 'Ana sayfa',
	'ur-your-profile' => 'Profiliniz',
	'ur-backlink' => '&lt; $1 adlı kullanıcının profiline dönüş',
	'ur-relationship-count-foes' => '$1, $2 {{PLURAL:$2|düşmana|düşmana}} sahip.
Daha fazla düşman ister misiniz?
<a href="$3"<Davet edin.</a>',
	'ur-relationship-count-friends' => '$1, $2 {{PLURAL:$2|arkadaşa|arkadaşa}} sahip.
Daha fazla arkadaş ister misiniz?
<a href="$3"<Davet edin.</a>',
	'ur-add-friends' => '  Daha fazla arkadaş ister misiniz?
<a href="$1"<Davet edin.</a>',
	'ur-add-friend' => 'Arkadaş olarak ekle',
	'ur-add-foe' => 'Düşman olarak ekle',
	'ur-add-no-user' => 'Hiçbir kullanıcı seçilmedi.
Lütfen doğru bağlantı ile arkadaş/düşman talep edin.',
	'ur-add-personal-message' => 'Kişisel bir mesaj ekle',
	'ur-remove-relationship-friend' => 'Arkadaşlıktan çıkar',
	'ur-remove-relationship-foe' => 'Düşmanlıktan çıkar',
	'ur-give-gift' => 'Bir hediye ver',
	'ur-previous' => 'önceki',
	'ur-next' => 'sonraki',
	'ur-remove-relationship-title-foe' => '$1 adlı kullanıcıyı düşmanlığınızdan çıkarmak istiyor musunuz?',
	'ur-remove-relationship-title-confirm-foe' => '$1 adlı kullanıcıyı düşmanlığınızdan çıkardınız',
	'ur-remove-relationship-title-friend' => '$1 adlı kullanıcıyı arkadaşlığınızdan çıkarmak istiyor musunuz?',
	'ur-remove-relationship-title-confirm-friend' => '$1 adlı kullanıcıyı arkadaşlığınızdan çıkardınız',
	'ur-remove-relationship-message-foe' => '$1 adlı kullanıcıyı düşmanlıktan çıkarma isteğinde bulundunuz, onaylamak için "$2" düğmesine basın.',
	'ur-remove-relationship-message-confirm-foe' => '$1 adlı kullanıcıyı başarıyla düşmanlarınızdan çıkardınız.',
	'ur-remove-relationship-message-friend' => '$1 adlı kullanıcıyı arkadaşlığınızdan çıkarma isteğinde bulundunuz, onaylamak için "$2" düğmesine basın.',
	'ur-remove-relationship-message-confirm-friend' => '$1 adlı kullanıcıyı başarıyla arkadaşlıktan çıkardınız.',
	'ur-remove-error-message-no-relationship' => '$1 ile bir ilişkiniz yok.',
	'ur-remove-error-message-remove-yourself' => 'Kendinizi kaldıramazsınız.',
	'ur-remove-error-message-pending-foe-request' => '$1 için bekleyen bir düşmanlık isteğiniz var.',
	'ur-remove-error-message-pending-friend-request' => '$1 için bekleyen bir arkadaşlık isteğiniz var.',
	'ur-remove-error-not-loggedin-foe' => 'Düşmanı kaldırmak için oturum açmış olmasınız.',
	'ur-remove-error-not-loggedin-friend' => 'Arkadaşı kaldırmak için oturum açmış olmalısınız.',
	'ur-remove' => 'Kaldır',
	'ur-cancel' => 'İptal',
	'ur-login' => 'Oturum aç',
	'ur-add-title-foe' => '$1 adlı kullanıcıyı düşmanınız olarak eklemek ister misiniz?',
	'ur-add-title-friend' => '$1 adlı kullanıcıyı arkadaşınız olarak eklemek ister misiniz?',
	'ur-add-message-foe' => '$1 adlı kullanıcıyı düşmanınız olarak eklemek üzeresiniz.
$1 adlı kullanıcıyı garezinizi doğrulaması için bilgilendireceğiz.',
	'ur-add-message-friend' => '$1 adlı kullanıcıyı arkadaşınız olarak eklemek üzeresiniz.
$1 adlı kullanıcıyı arkadaşlığınızı doğrulaması için bilgilendireceğiz.',
	'ur-add-button-foe' => 'Düşman olarak ekle',
	'ur-add-button-friend' => 'Arkadaş olarak ekle',
	'ur-add-sent-title-foe' => '$1 adlı kullanıcıya düşmanlık isteğinizi gönderdik!',
	'ur-add-sent-title-friend' => '$1 adlı kullanıcıya arkadaşlık isteğinizi gönderdik!',
	'ur-add-sent-message-foe' => 'Düşmanlık isteğiniz, onay için $1 adlı kullanıcıya gönderildi.
$1 adlı kullanıcının isteğinizi onaylaması halinde bir takip e-postası alacaksınız',
	'ur-add-sent-message-friend' => 'Arkadaşlık isteğiniz, onay için $1 adlı kullanıcıya gönderildi.
$1 adlı kullanıcının isteğinizi onaylaması halinde bir takip e-postası alacaksınız',
	'ur-add-error-message-no-user' => 'Eklemeye çalıştığınız kullanıcı mevcut değil.',
	'ur-add-error-message-blocked' => 'Halihazırda engellenmiş durumdasınız ve arkadaş veya düşman ekleyemezsiniz.',
	'ur-add-error-message-yourself' => 'Kendinizi arkadaş ya da düşman olarak ekleyemezsiniz.',
	'ur-add-error-message-existing-relationship-foe' => '$1 ile zaten düşmansınız.',
	'ur-add-error-message-existing-relationship-friend' => '$1 ile zaten arkadaşsınız.',
	'ur-add-error-message-pending-request-title' => 'Sabır!',
	'ur-add-error-message-pending-friend-request' => '$1 için bekleyen bir arkadaşlık isteğiniz var.
$1 isteğinizi doğruladığında sizi bilgilendireceğiz.',
	'ur-add-error-message-pending-foe-request' => '$1 için bekleyen bir düşmanlık isteğiniz var.
$1 isteğinizi doğruladığında sizi bilgilendireceğiz.',
	'ur-add-error-message-not-loggedin-foe' => 'Düşman eklemek için oturum açmış olmasınız',
	'ur-add-error-message-not-loggedin-friend' => 'Arkadaş eklemek için oturum açmış olmasınız',
	'ur-requests-title' => 'İlişki istekleri',
	'ur-requests-message-foe' => '<a href="$1">$2</a> düşmanınız olmak istiyor.',
	'ur-requests-message-friend' => '<a href="$1">$2</a> arkadaşınız olmak istiyor.',
	'ur-accept' => 'Onayla',
	'ur-reject' => 'Reddet',
	'ur-no-requests-message' => 'Arkadaşlık ya da düşmanlık isteğiniz yok.
Daha fazla arkadaş istiyorsanız, <a href="$1">davet edin!</a>',
	'ur-requests-added-message-foe' => '$1 adlı kullanıcıyı düşmanınız olarak eklediniz.',
	'ur-requests-added-message-friend' => '$1 adlı kullanıcıyı arkadaşınız olarak eklediniz.',
	'ur-requests-reject-message-friend' => '$1 adlı kullanıcının arkadaşlık isteğini reddettiniz.',
	'ur-requests-reject-message-foe' => '$1 adlı kullanıcının düşmanlık isteğini reddettiniz.',
	'ur-title-foe' => '$1 adlı kullanıcının düşman listesi',
	'ur-title-friend' => '$1 adlı kullanıcının arkadaş listesi',
	'friend_request_subject' => '$1 adlı kullanıcı {{SITENAME}} üzerinde sizi arkadaş olarak ekledi!',
	'friend_request_body' => 'Merhaba $1.

$2 sizi {{SITENAME}} üzerinde arkadaş olarak ekledi. Gerçekten arkadaş olduğunuzdan emin olmak istiyoruz.

Lütfen arkadaşlığınızı onaylamak için bu bağlantıya tıklayın:
$3

Teşekkürler

----

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'foe_request_subject' => 'Bu savaş demek! $1 sizi {{SITENAME}} üzerinde düşman olarak ekledi!',
	'foe_request_body' => 'Merhaba $1.

$2 sizi {{SITENAME}} üzerinde düşman olarak ekledi. Gerçekten ölümüne düşman olduğunuzdan ya da en azından bir tartışma yaşadığınızdan emin olmak istiyoruz.

Lütfen bu garezi onaylamak için bu bağlantıya tıklayın:
$3

Teşekkürler

----

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'friend_accept_subject' => '$1, {{SITENAME}} üzerinden gönderdiğiniz arkadaşlık isteğinizi kabul etti!',
	'friend_accept_body' => 'Merhaba $1.

$2 {{SITENAME}} arkadaşlık isteğinizi kabul etti!

$2 adlı kullanıcının sayfasını ziyaret edin: $3

Teşekkürler,

----

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'foe_accept_subject' => 'Haydi bakalım! $1 {{SITENAME}} üzerinde düşmanlık isteğinizi kabul etti!',
	'foe_accept_body' => 'Merhaba $1.

$2 {{SITENAME}} düşmanlık isteğinizi kabul etti!

$2 adlı kullanıcının sayfasını ziyaret edin: $3

Teşekkürler,

----

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'friend_removed_subject' => 'Ah hayır! $1 {{SITENAME}} üzerinde sizi arkadaşlıktan çıkardı!',
	'friend_removed_body' => 'Merhaba $1.

$2 {{SITENAME}} üzerinde sizi arkadaşlıktan çıkardı!

Teşekkürler

----

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
	'foe_removed_subject' => 'Yaşasın! $1 {{SITENAME}} üzerinde sizi düşmanlıktan çıkardı!',
	'foe_removed_body' => 'Merhaba $1.

$2 {{SITENAME}} üzerinde sizi düşmanlıktan çıkardı!

İkiniz belki de arkadaş olma yolundasınızdır?

Teşekkürler

----

Hey, bizden e-posta alımını durdurmak ister misiniz?

$4 bağlantısına tıklayın
ve e-posta bildirimlerini devre dışı bırakmak için ayarlarınızı değiştirin.',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'ur-main-page' => 'Баш бит',
	'ur-your-profile' => 'Сезнең профиль',
);

/** Uighur (Latin) (ئۇيغۇرچە / Uyghurche‎ (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'ur-login' => 'Kirish',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'ur-main-page' => 'Головна сторінка',
	'ur-previous' => 'попередній',
	'ur-next' => 'наступний',
	'ur-remove' => 'Вилучити',
	'ur-cancel' => 'Скасувати',
	'ur-login' => 'Увійти',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'ur-cancel' => 'منسوخ',
);

/** Veps (Vepsan kel')
 * @author Triple-ADHD-AS
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'ur-main-page' => 'Pälehtpol’',
	'ur-add-friend' => 'Ližata sebranikan',
	'ur-add-personal-message' => 'Ližata personaline tedotuz',
	'ur-previous' => 'edel.',
	'ur-next' => "jäl'gh.",
	'ur-remove' => 'Čuta poiš',
	'ur-cancel' => 'Heitta pätand',
	'ur-login' => 'Kirjutadas sistemha',
	'ur-add-error-message-pending-request-title' => 'Tirpand!',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'ur-error-page-title' => 'Oái!',
	'ur-main-page' => 'Trang Chính',
	'ur-add-friend' => 'Thêm người bạn',
	'ur-add-foe' => 'Thêm kẻ thù',
	'ur-give-gift' => 'Tặng món quà',
	'ur-previous' => 'trước',
	'ur-next' => 'sau',
	'ur-remove' => 'Dời',
	'ur-cancel' => 'Hủy bỏ',
	'ur-login' => 'Đăng nhập',
	'ur-add-error-message-pending-request-title' => 'Chịu khó nhé!',
	'ur-accept' => 'Chấp nhận',
	'ur-reject' => 'Từ chối',
	'ur-title-friend' => 'Danh sách người bạn của $1',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'ur-error-message-no-user' => 'No kanobs ledunön begi olik, bi no dabinon gebani labü nem at.',
	'ur-main-page' => 'Cifapad',
	'ur-your-profile' => 'Profül olik',
	'ur-relationship-count-foes' => 'Geban: $1 labon {{PLURAL:$2|nefleni|neflenis}} $2. Vilol-li neflenis mödikum? <a href="$3">Vüdolös onis.</a>',
	'ur-relationship-count-friends' => 'Geban: $1 labon {{PLURAL:$2|fleni|flenis}} $2. Vilol-mi flenis mödikum? <a href="$3">Vüdolös onis.</a>',
	'ur-add-friends' => '   Vilol-li flenis pluik? <a href="$1">Vüdolös onis</a>',
	'ur-add-friend' => 'Läükön as flen',
	'ur-add-foe' => 'Läükön as neflen',
	'ur-add-no-user' => 'Geban nonik pevälon.
Begolös stadi flena/neflena medü yüm verätik.',
	'ur-add-personal-message' => 'Läükön nuni pösodik',
	'ur-remove-relationship-friend' => 'Moükön as flen',
	'ur-remove-relationship-foe' => 'Moükön as neflen',
	'ur-give-gift' => 'Givön legivoti',
	'ur-previous' => 'büik',
	'ur-next' => 'sököl',
	'ur-remove-relationship-title-foe' => 'Vilol-li moükön gebani: $1 as neflen olik?',
	'ur-remove-relationship-title-confirm-foe' => 'Emoükol gebani: $1 as neflen olik',
	'ur-remove-relationship-title-friend' => 'Vilol-li moükön gebani: $1 as flen olik?',
	'ur-remove-relationship-title-confirm-friend' => 'Emoükol gebani: $1 as flen olik',
	'ur-remove-relationship-message-foe' => 'Ebegol moükami gebana: $1 as neflen olik, fümedolös me klav: „$2“.',
	'ur-remove-relationship-message-confirm-foe' => 'Emoükol benosekiko gebani: $1 as neflen olik.',
	'ur-remove-relationship-message-friend' => 'Ebegol moükami gebana: $1 as flen olik, fümedolös me klav: „$2“.',
	'ur-remove-relationship-message-confirm-friend' => 'Eplöpol ad möukön gebani $1: as flen olik.',
	'ur-remove-error-message-remove-yourself' => 'No kanol moükön oli it.',
	'ur-remove-error-not-loggedin-foe' => 'Mutol nunädön oli ad moükön nefleni.',
	'ur-remove-error-not-loggedin-friend' => 'Mutol nunädön oli ad moükön fleni.',
	'ur-remove' => 'Moükön',
	'ur-login' => 'Nunädön oki',
	'ur-add-title-foe' => 'Vilol-li läükön gebani: $1 as neflen olik?',
	'ur-add-title-friend' => 'Vilol-li läükön gebani: $1 as flen olik?',
	'ur-add-button-foe' => 'Läükön as neflen',
	'ur-add-button-friend' => 'Läükön as flen',
	'ur-add-error-message-no-user' => 'Geban, keli vilol läükön, no dabinon.',
	'ur-add-error-message-blocked' => 'No dalol läükön flenis u neflenis bi peblokol.',
	'ur-add-error-message-yourself' => 'No kanol läükön oli it as flen ud as neflen.',
	'ur-add-error-message-existing-relationship-foe' => 'Geban: $1 ya binon neflen olik.',
	'ur-add-error-message-existing-relationship-friend' => 'Geban: $1 ya binon flen olik.',
	'ur-add-error-message-not-loggedin-foe' => 'Mutol nunädön oli ad läükön nefleni',
	'ur-add-error-message-not-loggedin-friend' => 'Mutol nunädön oli ad läükön fleni',
	'ur-requests-added-message-foe' => 'Eläükol gebani: $1 as neflen olik.',
	'ur-requests-added-message-friend' => 'Eläükol gebani: $1 as flen olik.',
	'ur-title-foe' => 'Lised neflenas gebana: $1',
	'ur-title-friend' => 'Lised flenas gebana: $1',
	'friend_request_subject' => 'Geban: $1 eläükon oli as flen in {{SITENAME}}!',
	'foe_request_subject' => 'Krigö! Geban: $1 eläükon oli as neflen in {{SITENAME}}!',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'ur-cancel' => '取消',
);

/** Kalmyk (Хальмг)
 * @author Huuchin
 */
$messages['xal'] = array(
	'ur-main-page' => 'Нүр халх',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'ur-main-page' => 'הויפּט בלאַט',
	'ur-cancel' => 'אַנולירן',
	'ur-login' => 'אַרײַנלאגירן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author PhiLiP
 * @author Wrightbus
 */
$messages['zh-hans'] = array(
	'ur-already-submitted' => '您的请求经已传送',
	'ur-main-page' => '主页',
	'ur-your-profile' => '您的个人资料',
	'ur-backlink' => '&lt; 回到$1的个人资料',
	'ur-relationship-count-foes' => '$1已经有$2位仇敌了。
想要多些仇敌吗?
<a href="$3">邀请他们。</a>',
	'ur-relationship-count-friends' => '$1已经有$2位朋友了。
想要多些朋友吗?
<a href="$3">邀请他们。</a>',
	'ur-add-friend' => '加入成为朋友',
	'ur-add-foe' => '加入成为仇敌',
	'ur-remove-relationship-friend' => '从朋友清单移除',
	'ur-remove-relationship-foe' => '从仇敌清单移除',
	'ur-give-gift' => '送礼物',
	'ur-previous' => '先前',
	'ur-next' => '后继',
	'ur-remove-relationship-title-foe' => '您要把$1从仇敌清单中移除吗?',
	'ur-remove-relationship-title-confirm-foe' => '您已把$1从仇敌清单中移除',
	'ur-remove-relationship-title-friend' => '您要把$1从朋友清单中移除吗?',
	'ur-remove-relationship-title-confirm-friend' => '您已把$1从朋友清单中移除',
	'ur-remove-error-message-remove-yourself' => '您不能移除自己。',
	'ur-remove' => '移除',
	'ur-cancel' => '取消',
	'ur-login' => '登录',
	'ur-add-title-foe' => '您要把$1加入成为仇敌吗?',
	'ur-add-title-friend' => '您要把$1加入成为朋友吗?',
	'ur-add-button-foe' => '加入成为仇敌',
	'ur-add-button-friend' => '加入成为朋友',
	'ur-accept' => '接受',
	'ur-reject' => '拒绝',
	'ur-title-foe' => '$1的仇敌清单',
	'ur-title-friend' => '$1的朋友清单',
	'friend_request_subject' => '$1已在{{SITENAME}}把您加入成为朋友！',
	'friend_removed_subject' => '哎唷！$1已在{{SITENAME}}把您从朋友清单移除了!',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'ur-already-submitted' => '您的請求已傳送',
	'ur-main-page' => '首頁',
	'ur-your-profile' => '您的個人檔案',
	'ur-backlink' => '&lt; 返回到 $1 的個人檔案',
	'ur-relationship-count-foes' => '$1 已經有 $2 位仇人了。
想要多些仇人嗎?
<a href=「$3」>邀請他們。</a>',
	'ur-relationship-count-friends' => '$1 已經有 $2 位朋友了。
想要多些朋友嗎?
<a href=「$3」>邀請他們。</a>',
	'ur-add-friends' => '希望更多的朋友？ 
 <a href=「$1」>邀請他們</a>',
	'ur-add-friend' => '加入成為朋友',
	'ur-add-foe' => '新增為仇人',
	'ur-remove-relationship-friend' => '從朋友名單中移除',
	'ur-remove-relationship-foe' => '從仇人名單中移除',
	'ur-give-gift' => '送禮物',
	'ur-remove-relationship-title-foe' => '您要把 $1 從仇人名單中移除嗎？',
	'ur-remove-relationship-title-confirm-foe' => '您已把 $1 從仇人名單中移除',
	'ur-remove-relationship-title-friend' => '您要把 $1 從朋友名單中移除嗎？',
	'ur-remove-relationship-title-confirm-friend' => '您已把 $1 從朋友名單中移除',
	'ur-remove-error-message-remove-yourself' => '您不能移除自己。',
	'ur-remove' => '移除',
	'ur-cancel' => '取消',
	'ur-login' => '登入',
	'ur-add-title-foe' => '您要把 $1 作為你的仇人嗎?',
	'ur-add-title-friend' => '您要把 $1 作為你的朋友嗎?',
	'ur-add-button-foe' => '新增為仇人',
	'ur-add-button-friend' => '新增為朋友',
	'ur-accept' => '接受',
	'ur-reject' => '拒絕',
	'ur-title-foe' => '$1 的仇敵名單',
	'ur-title-friend' => '$1 的朋友名單',
	'friend_request_subject' => '$1 已在 {{SITENAME}} 把您加入成為朋友！',
	'friend_removed_subject' => '哦，不！$1 已在 {{SITENAME}} 把您從朋友名單中移除了!',
	'foe_removed_subject' => '哦，不！$1 已在 {{SITENAME}} 把您從仇人名單中移除了!',
);

