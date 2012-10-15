<?php
/**
 * Internationalisation file for extension CrosswikiBlock.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	# Special page
	'crosswikiblock-desc'       => 'Allows to block users on other wikis using a [[Special:Crosswikiblock|special page]]',
	'crosswikiblock'            => 'Block user on other wiki',
	'crosswikiblock-header'     => 'This page allows to block user on other wiki.
Please check if you are allowed to act on this wiki and your actions match all policies.',
	'crosswikiblock-target'     => 'IP address or username and destination wiki:',
	'crosswikiblock-expiry'     => 'Expiry:',
	'crosswikiblock-reason'     => 'Reason:',
	'crosswikiblock-submit'     => 'Block this user',
	'crosswikiblock-anononly'   => 'Block anonymous users only',
	'crosswikiblock-nocreate'   => 'Prevent account creation',
	'crosswikiblock-autoblock'  => 'Automatically block the last IP address used by this user, and any subsequent IP addresses they try to edit from',
	'crosswikiblock-noemail'    => 'Prevent user from sending e-mail',

	# Special:Unblock
	'crosswikiunblock'              => 'Unblock user on other wiki',
	'crosswikiunblock-header'       => 'This page allows to unblock user on other wiki.
Please check if you are allowed to act on this wiki and your actions match all policies.',
	'crosswikiunblock-user'         => 'Username, IP address or block ID and destination wiki:',
	'crosswikiunblock-reason'       => 'Reason:',
	'crosswikiunblock-submit'       => 'Unblock this user',
	'crosswikiunblock-success'      => "User '''$1''' unblocked successfully.

Return to:
* [[Special:CrosswikiBlock|Block form]]
* [[$2]]",

	# Errors and success message
	'crosswikiblock-nousername'     => 'No username was given',
	'crosswikiblock-local'          => 'Local blocks are not supported via this interface. Use [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound'     => 'Database $1 does not exist',
	'crosswikiblock-noname'         => '"$1" is not a valid username.',
	'crosswikiblock-nouser'         => 'User "$3" is not found.',
	'crosswikiblock-noexpiry'       => 'Invalid expiry: $1.',
	'crosswikiblock-noreason'       => 'No reason specified.',
	'crosswikiblock-notoken'        => 'Invalid edit token.',
	'crosswikiblock-alreadyblocked' => 'User $3 is already blocked.',
	'crosswikiblock-noblock'        => 'This user is not blocked.',
	'crosswikiblock-success'        => "User '''$3''' blocked successfully.

Return to:
* [[Special:CrosswikiBlock|Block form]]
* [[$4]]",
	'crosswikiunblock-local'          => 'Local unblocks are not supported via this interface. Use [[Special:IPBlockList|{{int:ipblocklist}}]]',

	# Rights
	'right-crosswikiblock' => 'Block and unblock users on other wikis',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 */
$messages['qqq'] = array(
	'crosswikiblock-desc' => 'Extension description displayed on [[Special:Version]].',
	'crosswikiblock-expiry' => '{{Identical|Expiry}}',
	'crosswikiblock-reason' => '{{Identical|Reason}}',
	'crosswikiblock-submit' => '{{Identical|Block this user}}',
	'crosswikiblock-anononly' => '{{Identical|Block anonymous users only}}',
	'crosswikiblock-nocreate' => '{{Identical|Prevent account creation}}',
	'crosswikiblock-autoblock' => '{{Identical|Automatically block ...}}',
	'crosswikiblock-noemail' => '{{Identical|Prevent user from sending e-mail}}',
	'crosswikiunblock-reason' => '{{Identical|Reason}}',
	'crosswikiblock-notoken' => '{{Identical|Invalid edit token}}',
	'crosswikiblock-alreadyblocked' => '{{Identical|$1 is already blocked}}',
	'right-crosswikiblock' => '{{doc-right|crosswikiblock}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'crosswikiunblock-reason' => 'Kakano:',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'crosswikiblock-desc' => "Laat toe om gebruikers op ander wiki's te blokkeer via 'n [[Special:Crosswikiblock|spesiale bladsy]]",
	'crosswikiblock' => "Blokkeer gebruiker op 'n ander wiki",
	'crosswikiblock-target' => 'IP-adres of gebruikersnaam en bestemmingswiki:',
	'crosswikiblock-expiry' => 'Duur:',
	'crosswikiblock-reason' => 'Rede:',
	'crosswikiblock-submit' => 'Versper die gebruiker',
	'crosswikiblock-anononly' => 'Blokkeer slegs anonieme gebruikers',
	'crosswikiblock-nocreate' => 'Blokkeer registrasie van gebruikers',
	'crosswikiblock-noemail' => 'Verbied gebruiker om e-pos te stuur',
	'crosswikiunblock' => "Deblokkeer gebruiker op 'n ander wiki",
	'crosswikiunblock-user' => 'Gebruiker, IP-adres of blokkadenommer en bestemmingswiki:',
	'crosswikiunblock-reason' => 'Rede:',
	'crosswikiunblock-submit' => 'Deblokkeer die gebruiker',
	'crosswikiunblock-success' => "Gebruiker '''$1''' is suksesvol gedeblokkeer.

Gaan terug na:
* Die [[Special:CrosswikiBlock|blokkadevorm]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Geen gebruikersnaam is verskaf nie',
	'crosswikiblock-local' => 'Plaaslike blokkades word nie deur hierdie vorm ondersteun nie.
Gebruik [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'Databasis $1 bestaan nie',
	'crosswikiblock-noname' => '"$1" is nie \'n geldige gebruikersnaam nie.',
	'crosswikiblock-nouser' => 'Gebruiker "$3" is nie gevind nie.',
	'crosswikiblock-noexpiry' => 'Ongeldige vervaldatum: $1.',
	'crosswikiblock-noreason' => 'Geen rede verskaf nie.',
	'crosswikiblock-notoken' => 'Ongeldige wysigingsteken ("edit token")',
	'crosswikiblock-alreadyblocked' => 'Gebruiker $3 is reeds geblok.',
	'crosswikiblock-noblock' => 'Hierdie gebruiker is nie geblokkeer nie.',
	'crosswikiblock-success' => "Gebruiker '''$3''' is suksesvol geblokkeer.

Terug na:
* Die [[Special:CrosswikiBlock|blokkeervorm]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokale deblokkerings word nie via hierdie koppelvlak ondersteun nie.
Gebruik die [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => "Blokkeer en deblokkeer gebruikers op ander wiki's",
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'crosswikiblock-desc' => 'Lejon të bllokojnë përdorues në wikis tjerë duke përdorur një [[Special:Crosswikiblock|faqe veçantë]]',
	'crosswikiblock' => 'Blloko përdorues në wiki të tjera',
	'crosswikiblock-header' => 'Kjo faqe lejon të bllokojnë përdorues në wiki të tjera. Ju lutemi të kontrolloni nëse ju keni të drejtë të veprojë në këtë wiki dhe veprimet tuaja ndeshje të gjitha politikat.',
	'crosswikiblock-target' => 'Adresa IP ose emër përdoruesi dhe wiki destinacion:',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'crosswikiblock-reason' => 'ምክንያት:',
	'crosswikiunblock-reason' => 'ምክንያት:',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'crosswikiblock-reason' => 'Razón:',
	'crosswikiblock-anononly' => 'Bloqueyar nomás os usuarios anonimos',
	'crosswikiunblock-reason' => 'Razón:',
	'crosswikiblock-alreadyblocked' => "L'usuario $3 ya yera bloqueyato.",
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'crosswikiblock-desc' => 'يسمح بمنع المستخدمين في ويكيات أخرى باستخدام [[Special:Crosswikiblock|صفحة خاصة]]',
	'crosswikiblock' => 'منع مستخدم في ويكي آخر',
	'crosswikiblock-header' => 'هذه الصفحة تسمح بمنع المستخدمين في ويكي آخر.
من فضلك تحقق لو كان مسموحا لك بالعمل في هذه الويكي وأفعالك تطابق كل السياسات.',
	'crosswikiblock-target' => 'عنوان الأيبي أو اسم المستخدم والويكي المستهدف:',
	'crosswikiblock-expiry' => 'الانتهاء:',
	'crosswikiblock-reason' => 'السبب:',
	'crosswikiblock-submit' => 'امنع هذا المستخدم',
	'crosswikiblock-anononly' => 'امنع المستخدمين المجهولين فقط',
	'crosswikiblock-nocreate' => 'امنع إنشاء الحسابات',
	'crosswikiblock-autoblock' => 'تلقائيا امنع آخر عنوان أيبي تم استخدامه بواسطة هذا المستخدم، وأي أيبيهات لاحقة يحاول التعديل منها',
	'crosswikiblock-noemail' => 'امنع المستخدم من إرسال بريد إلكتروني',
	'crosswikiunblock' => 'رفع المنع عن مستخدم في ويكي أخرى',
	'crosswikiunblock-header' => 'هذه الصفحة تسمح برفع المنع عن مستخدم في ويكي أخرى.
من فضلك تحقق من أنه مسموح لك بالعمل على هذه الويكي وأن أفعالك تطابق كل السياسات.',
	'crosswikiunblock-user' => 'اسم المستخدم، عنوان الأيبي أو رقم المنع والويكي المستهدفة:',
	'crosswikiunblock-reason' => 'السبب:',
	'crosswikiunblock-submit' => 'ارفع المنع عن هذا المستخدم',
	'crosswikiunblock-success' => "المستخدم '''$1''' تم رفع المنع عنه بنجاح.

ارجع إلى:
* [[Special:CrosswikiBlock|استمارة المنع]]
* [[$2]]",
	'crosswikiblock-nousername' => 'لا اسم مستخدم تم إدخاله',
	'crosswikiblock-local' => 'عمليات المنع المحلية غير مدعومة من خلال هذه الواجهة. استخدم [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'قاعدة البيانات $1 غير موجودة',
	'crosswikiblock-noname' => '"$1" ليس اسم مستخدم صحيحا.',
	'crosswikiblock-nouser' => 'المستخدم "$3" غير موجود.',
	'crosswikiblock-noexpiry' => 'تاريخ انتهاء غير صحيح: $1.',
	'crosswikiblock-noreason' => 'لا سبب تم تحديده.',
	'crosswikiblock-notoken' => 'نص تعديل غير صحيح.',
	'crosswikiblock-alreadyblocked' => 'المستخدم $3 ممنوع بالفعل.',
	'crosswikiblock-noblock' => 'هذا المستخدم ليس ممنوعا.',
	'crosswikiblock-success' => "المستخدم '''$3''' تم منعه بنجاح.

ارجع إلى:
* [[Special:CrosswikiBlock|استمارة المنع]]
* [[$4]]",
	'crosswikiunblock-local' => 'عمليات المنع المحلية غير مدعومة بواسطة هذه الواجهة. استخدم [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'منع ورفع المنع عن المستخدمين في الويكيات الأخرى',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'crosswikiblock-reason' => 'ܥܠܬܐ:',
	'crosswikiunblock-reason' => 'ܥܠܬܐ:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'crosswikiblock-desc' => 'يسمح بمنع المستخدمين فى ويكيات أخرى باستخدام [[Special:Crosswikiblock|صفحة خاصة]]',
	'crosswikiblock' => 'منع مستخدم فى ويكى آخر',
	'crosswikiblock-header' => 'هذه الصفحة تسمح بمنع المستخدمين فى ويكى آخر.
من فضلك تحقق لو كان مسموحا لك بالعمل فى هذه الويكى وأفعالك تطابق كل السياسات.',
	'crosswikiblock-target' => 'عنوان الأيبى أو اسم المستخدم والويكى المستهدف:',
	'crosswikiblock-expiry' => 'الانتهاء:',
	'crosswikiblock-reason' => 'السبب:',
	'crosswikiblock-submit' => 'منع هذا المستخدم',
	'crosswikiblock-anononly' => 'امنع المستخدمين المجهولين فقط',
	'crosswikiblock-nocreate' => 'امنع إنشاء الحسابات',
	'crosswikiblock-autoblock' => 'تلقائيا امنع آخر عنوان أيبى تم استخدامه بواسطة هذا المستخدم، وأى أيبيهات لاحقة يحاول التعديل منها',
	'crosswikiblock-noemail' => 'امنع المستخدم من إرسال بريد إلكتروني',
	'crosswikiunblock' => 'رفع المنع عن مستخدم فى ويكى أخرى',
	'crosswikiunblock-header' => 'هذه الصفحة تسمح برفع المنع عن مستخدم فى ويكى أخرى.
من فضلك تحقق من أنه مسموح لك بالعمل على هذه الويكى وأن أفعالك تطابق كل السياسات.',
	'crosswikiunblock-user' => 'اسم المستخدم، عنوان الأيبى أو رقم المنع والويكى المستهدفة:',
	'crosswikiunblock-reason' => 'السبب:',
	'crosswikiunblock-submit' => 'رفع المنع عن هذا المستخدم',
	'crosswikiunblock-success' => "المستخدم '''$1''' تم رفع المنع عنه بنجاح.

ارجع إلى:
* [[Special:CrosswikiBlock|استمارة المنع]]
* [[$2]]",
	'crosswikiblock-nousername' => 'لا اسم مستخدم تم إدخاله',
	'crosswikiblock-local' => 'عمليات المنع المحلية غير مدعومة من خلال هذه الواجهة. استخدم [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'قاعدة البيانات $1 غير موجودة',
	'crosswikiblock-noname' => '"$1" ليس اسم مستخدم صحيحا.',
	'crosswikiblock-nouser' => 'المستخدم "$3" غير موجود.',
	'crosswikiblock-noexpiry' => 'تاريخ انتهاء غير صحيح: $1.',
	'crosswikiblock-noreason' => 'لا سبب تم تحديده.',
	'crosswikiblock-notoken' => 'نص تعديل غير صحيح.',
	'crosswikiblock-alreadyblocked' => 'المستخدم $3 ممنوع بالفعل.',
	'crosswikiblock-noblock' => 'هذا المستخدم ليس ممنوعا.',
	'crosswikiblock-success' => "المستخدم '''$3''' تم منعه بنجاح.

ارجع إلى:
* [[Special:CrosswikiBlock|استمارة المنع]]
* [[$4]]",
	'crosswikiunblock-local' => 'عمليات المنع المحلية غير مدعومة بواسطة هذه الواجهة. استخدم [[Special:IPBlockList|{{int:ipblocklist}}]]',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'crosswikiblock-reason' => 'Səbəb:',
	'crosswikiunblock-reason' => 'Səbəb:',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'crosswikiblock-reason' => 'Прычына:',
	'crosswikiunblock-reason' => 'Прычына:',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'crosswikiblock-desc' => 'Дазваляе блякаваць удзельнікаў у іншых вікі з дапамогай [[Special:Crosswikiblock|спэцыяльнай старонкі]]',
	'crosswikiblock' => 'Блякаваць удзельнікаў на іншых вікі',
	'crosswikiblock-header' => 'Гэтая старонка дазваляе блякаваць удзельніка ў іншай вікі.
Калі ласка, упэўніцеся, што Вам дазволена гэта дзеяньне на гэтай вікі і Вашы дзеяньні адпавядаюць правілам.',
	'crosswikiblock-target' => 'IP-адрас альбо імя ўдзельніка і мэтавая вікі:',
	'crosswikiblock-expiry' => 'Тэрмін:',
	'crosswikiblock-reason' => 'Прычына:',
	'crosswikiblock-submit' => 'Заблякаваць гэтага ўдзельніка',
	'crosswikiblock-anononly' => 'Блякаваць толькі ананімаў',
	'crosswikiblock-nocreate' => 'Забараніць стварэньне рахункаў',
	'crosswikiblock-autoblock' => 'Аўтаматычна блякаваць апошнія IP-адрасы, якімі карыстаўся гэты ўдзельнік, і любыя іншыя IP-адрасы зь якіх вядзецца спроба рэдагаваньня',
	'crosswikiblock-noemail' => 'Забараніць удзельніку дасылаць лісты па электроннай пошце',
	'crosswikiunblock' => 'Разблякаваць удзельніка ў іншай вікі',
	'crosswikiunblock-header' => 'Гэтая старонка дазваляе разблякаваць удзельніка у іншай вікі.
Калі ласка, упэўніцеся, што Вам дазволена гэта дзеяньне на гэтай вікі і Вашы дзеяньні адпавядаюць правілам.',
	'crosswikiunblock-user' => 'Імя ўдзельніка, IP-адрас альбо ідэнтыфікатар блякаваньня і мэтавая вікі:',
	'crosswikiunblock-reason' => 'Прычына:',
	'crosswikiunblock-submit' => 'Разблякаваць гэтага ўдзельніка',
	'crosswikiunblock-success' => "{{GENDER:$1|Удзельнік '''$1''' пасьпяхова разблякаваны|Удзельніца '''$1''' пасьпяхова разблякаваная}}.

Вярнуцца да:
* [[Special:CrosswikiBlock|Формы блякаваньня]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Імя ўдзельніка не пададзенае',
	'crosswikiblock-local' => 'Лякальныя блякаваньні не падтрымліваюцца праз гэты інтэрфэйс. Выкарыстоўвайце [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'База зьвестак $1 не існуе',
	'crosswikiblock-noname' => '«$1» не зьяўляецца слушным іменем удзельніка.',
	'crosswikiblock-nouser' => '{{GENDER:$3|Удзельнік «$3» ня знойдзены|Удзельніца «$3» ня знойдзеная}}.',
	'crosswikiblock-noexpiry' => 'Няслушны тэрмін: $1.',
	'crosswikiblock-noreason' => 'Прычына не пазначаная.',
	'crosswikiblock-notoken' => 'Няслушны маркер рэдагаваньня.',
	'crosswikiblock-alreadyblocked' => '{{GENDER:$3|Удзельнік $3 ужо заблякаваны|Удзельніца $3 ужо заблякаваная}}.',
	'crosswikiblock-noblock' => 'Гэты ўдзельнік не заблякаваны.',
	'crosswikiblock-success' => "{{GENDER:$3|Удзельнік '''$3''' пасьпяхова заблякаваны|Удзельніца '''$3''' пасьпяхова заблякаваная}}.

Вярнуцца да:
* [[Special:CrosswikiBlock|Формы блякаваньня]]
* [[$4]]",
	'crosswikiunblock-local' => 'Лякальныя разблякаваньні не падтрымліваюцца праз гэты інтэрфэйс. Выкарыстоўвайце [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'блякаваньне і разблякаваньне ўдзельнікаў ў іншых вікі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'crosswikiblock-desc' => 'Позволява блокирането на потребители в други уикита чрез [[Special:Crosswikiblock|специална страница]]',
	'crosswikiblock' => 'Блокиране на потребител в друго уики',
	'crosswikiblock-header' => 'Тази страница позволява блокирането на потребители в други уикита.
Необходимо е да проверите дали имате права да изпълните действието на това уики и дали не е в разрез с действащите политики.',
	'crosswikiblock-target' => 'IP адрес или потребителско име и целево уики:',
	'crosswikiblock-expiry' => 'Изтича на:',
	'crosswikiblock-reason' => 'Причина:',
	'crosswikiblock-submit' => 'Блокиране на този потребител',
	'crosswikiblock-anononly' => 'Блокиране само на нерегистрирани потребители',
	'crosswikiblock-nocreate' => 'Без създаване на сметки',
	'crosswikiblock-autoblock' => 'Автоматично блокиране на посления използван от потребителя IP адрес и всички адреси, от които направи опит за редактиране',
	'crosswikiblock-noemail' => 'Без възможност за изпращане на е-поща',
	'crosswikiunblock' => 'Отблокиране на потребител на друго уики',
	'crosswikiunblock-header' => 'Тази страница позволява отблокирането на потребители на други уикита.
Убедете се, че имате необходимите права за извършване на действието и че действието не е в разрез с текущата политика.',
	'crosswikiunblock-user' => 'Потребителско име, IP адрес или номер на блокирането и целево уики:',
	'crosswikiunblock-reason' => 'Причина:',
	'crosswikiunblock-submit' => 'Отблокиране на потребителя',
	'crosswikiunblock-success' => "Потребител '''$1''' беше успешно отблокиран.

Връщане към:
* [[Special:CrosswikiBlock|Формуляра за блокиране]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Не беше въведено потребителско име',
	'crosswikiblock-local' => 'Локалните блокирания не се поддържат от този интерфейс. Използва се [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Не съществува база данни $1',
	'crosswikiblock-noname' => '„$1“ не е валидно потребителско име.',
	'crosswikiblock-nouser' => 'Не беше намерен потребител „$3“',
	'crosswikiblock-noexpiry' => 'Невалиден срок за изтичане: $1.',
	'crosswikiblock-noreason' => 'Не е посочена причина.',
	'crosswikiblock-alreadyblocked' => 'Потребител $3 е вече блокиран.',
	'crosswikiblock-noblock' => 'Този потребител не е блокиран.',
	'crosswikiblock-success' => "Потребител '''$3''' беше блокиран успешно.

Връщане към:
* [[Special:CrosswikiBlock|Формуляра за блокиране]]
* [[$4]]",
	'crosswikiunblock-local' => 'Локалните отблокирания не се поддържат от този интерфейс. Използва се [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Блокиране и отблокиране на потребители в други уикита',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'crosswikiblock' => 'অন্য উইকিতে ব্যবহারকারী বাধা দিন',
	'crosswikiblock-target' => 'আইপি ঠিকানা বা ব্যবহারকারী নাম, এবং নির্ধারিত উইকি:',
	'crosswikiblock-expiry' => 'যখন মেয়াদোত্তীর্ণ হবে:',
	'crosswikiblock-reason' => 'কারণ:',
	'crosswikiblock-submit' => 'এই ব্যবহারকারীকে বাধা দেয়া হোক',
	'crosswikiblock-anononly' => 'কেবল বেনামী ব্যবহারকারীদের বাধা দেওয়া হোক',
	'crosswikiblock-nocreate' => 'অ্যাকাউন্ট সৃষ্টিতে বাধা দেওয়া হোক',
	'crosswikiblock-autoblock' => 'এই ব্যবহারকারীর ব্যবহার করা সর্বশেষ আইপি ঠিকানা, এবং পরবর্তী যেসব আইপি ঠিকানা থেকে সম্পাদনার চেষ্টা করা হবে, সেগুলিকেও স্বয়ংক্রিয়ভাবে বাধা দেয়া হোক।',
	'crosswikiblock-noemail' => 'ব্যবহারকারীকে ই-মেইল পাঠাতে বাধা দেওয়া হোক',
	'crosswikiunblock' => 'অন্য উইকিতে ব্যবহারকারী বাধা দিন',
	'crosswikiunblock-user' => 'ব্যবহারকারী নাম, আইপি ঠিকানা বা বাধা দানের আইডি, এবং নির্ধারিত উইকি:',
	'crosswikiunblock-reason' => 'কারণ:',
	'crosswikiunblock-submit' => 'এই ব্যবহারকারী থেকে বাধা তুলে নেওয়া হোক',
	'crosswikiblock-nousername' => 'কোনো ব্যবহারকারী নাম দেওয়া হয়নি',
	'crosswikiblock-dbnotfound' => '$1 নামে কোনো ডেটাবেজ নেই',
	'crosswikiblock-noname' => '"$1" কোনো গ্রহণযোগ্য ব্যবহারকারী নাম নয়।',
	'crosswikiblock-nouser' => 'ব্যবহারকারী "$3" খুঁজে পাওয়া যায়নি।',
	'crosswikiblock-noexpiry' => 'অগ্রহণযোগ্য মেয়াদ উত্তীর্ণের তারিখ: $1',
	'crosswikiblock-noreason' => 'কোনো কারণ প্রদান করা হয়নি।',
	'crosswikiblock-notoken' => 'অবৈধ সম্পাদনা টোকেন।',
	'crosswikiblock-alreadyblocked' => 'ব্যবহারকারী $3-এর ওপর ইতিমধ্যেই বাধা বলবৎ রয়েছে।',
	'crosswikiblock-noblock' => 'এই ব্যবহারকারীর ওপর কোনো বাধা নেই।',
	'right-crosswikiblock' => 'অন্য উইকিতে ব্যবহারকারীদের বাধা দাও ও বাধা তুলে নাও',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'crosswikiblock-desc' => 'Aotreañ a ra da stankañ implijerien war ur wiki all en ur implijout ur [[Special:Crosswikiblock|bajenn ispisial]]',
	'crosswikiblock' => 'Stankañ an implijer war ur wiki all',
	'crosswikiblock-header' => "Ar bajenn-mañ a aotre stankañ un implijer war ur wiki all.
Gwiriekait ez oc'h aotreet oberañ war ar wiki-se hag e touj ho oberoù gant an holl reolennoù.",
	'crosswikiblock-target' => "Chomlec'h IP pe anv an implijer hag ar wiki a fell deoc'h tizhout :",
	'crosswikiblock-expiry' => 'Termen :',
	'crosswikiblock-reason' => 'Abeg :',
	'crosswikiblock-submit' => 'Stankañ an implijer-mañ',
	'crosswikiblock-anononly' => 'Stankañ an implijerien dizanv hepken',
	'crosswikiblock-nocreate' => "Nac'hañ a ra krouidigezh ur gont",
	'crosswikiblock-autoblock' => "Stankañ war-eeun ar chomlec'h IP diwezhañ implijet gant an den-mañ hag an holl chomlec'hioù en deus klasket degas kemmoù drezo war-lerc'h",
	'crosswikiblock-noemail' => "Nac'hañ d'an implijer kas posteloù",
	'crosswikiunblock' => 'Distankañ un implijer war ur wiki all',
	'crosswikiunblock-header' => "Ar bajenn-mañ a aotre da zistankañ un implijer war wikioù all.
Gwiriekait ez oc'h aotreet oberañ war ar wiki-se hag e touj ho oberoù ouzh an holl reolennoù.",
	'crosswikiunblock-user' => "Anv an implijer, chomlec'h IP pe an ID da stankañ hag ar wiki hoc'h eus c'hoant da dizhout :",
	'crosswikiunblock-reason' => 'Abeg :',
	'crosswikiunblock-submit' => 'Distankañ an implijer-mañ',
	'crosswikiunblock-success' => "Distanket eo bet an implijer '''$1'''.

Distreiñ da:
* [[Special:CrosswikiBlock|furmskrid ar stankadennoù]]
* [[$2]]",
	'crosswikiblock-nousername' => "N'eus bet roet anv implijer ebet",
	'crosswikiblock-local' => "Ne vez ket degemeret gant an etrefas-mañ an distankadennoù lec'hel. Implijit [[Special:BlockIP|{{int:blockip}}]].",
	'crosswikiblock-dbnotfound' => "N'eus ket eus an diaz roadennoù $1",
	'crosswikiblock-noname' => '« $1 » n’eo ket un anv implijer reizh.',
	'crosswikiblock-nouser' => 'N\'eo ket bet kavet an implijer "$3".',
	'crosswikiblock-noexpiry' => 'Termen fall : $1.',
	'crosswikiblock-noreason' => "N'eus bet diferet abeg ebet.",
	'crosswikiblock-notoken' => "N'eo ket mat ar jedouer kemm.",
	'crosswikiblock-alreadyblocked' => 'Stanket eo an implijer $3 dija.',
	'crosswikiblock-noblock' => "N'eo ket stanket an implijer-mañ.",
	'crosswikiblock-success' => "Stanket eo bet an implijer '''$3'''.

Distreiñ da:
* [[Special:CrosswikiBlock|furmskrid ar stankadennoù]]
* [[$4]]",
	'crosswikiunblock-local' => "Ne vez ket degemeret gant an etrefas-mañ an distankadennoù lec'hel. Implijit [[Special:IPBlockList|{{int:ipblocklist}}]]",
	'right-crosswikiblock' => 'Stankañ ha distankañ implijerien war wikioù all',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'crosswikiblock-desc' => 'Omogućuje blokiranje korisnika na drugim wikijima koristeći [[Special:Crosswikiblock|posebnu stranicu]]',
	'crosswikiblock' => 'Blokiranje korisnika na drugim wikijima',
	'crosswikiblock-header' => 'Ova stranica omogućuje blokiranje korisnika na drugoj wiki.
Molimo provjerite da li Vam je dopušteno da izvršite akcije na ovoj wiki i da li Vaše akcije odgovaraju svim pravilima.',
	'crosswikiblock-target' => 'IP adresa ili korisničko ime i odredišna wiki:',
	'crosswikiblock-expiry' => 'Ističe:',
	'crosswikiblock-reason' => 'Razlog:',
	'crosswikiblock-submit' => 'Blokiraj ovog korisnika',
	'crosswikiblock-anononly' => 'Blokiraj samo anonimne korisnike',
	'crosswikiblock-nocreate' => 'Onemogući pravljenje računa',
	'crosswikiblock-autoblock' => 'Automatski blokiraj zadnju IP adresu koju je koristio ovaj korisnik i sve druge IP adrese s kojih je on pokušao uređivati',
	'crosswikiblock-noemail' => 'Onemogući korisnika da šalje e-mail',
	'crosswikiunblock' => 'Deblokiranje korisnika na drugim wikijima',
	'crosswikiunblock-header' => 'Ova stranica omogućava da se deblokira korisnik na drugoj wiki.
Molimo provjerite da li Vam je dopušteno da djelujete na ovoj wiki i da li Vaše akcije odgovaraju svim pravilima.',
	'crosswikiunblock-user' => 'Korisničko ime, IP adresa ili ID blokade i odredišni wiki:',
	'crosswikiunblock-reason' => 'Razlog:',
	'crosswikiunblock-submit' => 'Deblokiraj ovog korisnika',
	'crosswikiunblock-success' => "Korisnik '''$1''' je uspješno deblokiran.

Nazad na:
* [[Special:CrosswikiBlock|Obrazac za blokiranje]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nije navedeno korisničko ime',
	'crosswikiblock-local' => 'Lokalne blokade nisu podržane putem ovog interfejsa. Koristite [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Baza podataka $1 ne postoji',
	'crosswikiblock-noname' => '"$1" nije valjano korisničko ime.',
	'crosswikiblock-nouser' => 'Korisnik "$3" nije pronađen.',
	'crosswikiblock-noexpiry' => 'Nevaljan rok isteka: $1.',
	'crosswikiblock-noreason' => 'Nije naveden razlog.',
	'crosswikiblock-notoken' => 'Nevaljan token izmjene.',
	'crosswikiblock-alreadyblocked' => 'Korisnik $3 je već blokiran.',
	'crosswikiblock-noblock' => 'Ovaj korisnik nije blokiran.',
	'crosswikiblock-success' => "Korisnik '''$3''' je uspješno blokiran.

Nazad na:
* [[Special:CrosswikiBlock|Obrazac za blokiranje]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokalne deblokade nisu podržane putem ovog interfejsa. Koristite [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blokiranje i deblokiranje korisnika na drugim wikijima',
);

/** Catalan (Català)
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'crosswikiblock-expiry' => 'Venç:',
	'crosswikiblock-reason' => 'Motiu:',
	'crosswikiblock-submit' => 'Bloqueja aquest usuari',
	'crosswikiblock-anononly' => 'Bloqueja només usuaris anònims',
	'crosswikiunblock-reason' => 'Motiu:',
	'crosswikiblock-nousername' => "No heu especificat cap nom d'usuari",
	'crosswikiblock-dbnotfound' => 'La base de dades $1 no existeix',
	'crosswikiblock-noname' => '"$1" no és un nom vàlid d\'usuari.',
	'crosswikiblock-nouser' => 'No s\'ha trobat l\'usuari "$3".',
	'crosswikiblock-noreason' => "No s'ha especificat cap motiu.",
	'crosswikiblock-alreadyblocked' => "L'usuari $3 ja està blocat.",
	'right-crosswikiblock' => 'Blocar i desblocar usuaris en altres wikis',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'crosswikiblock-reason' => 'Бахьан:',
	'crosswikiunblock-reason' => 'Бахьан:',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'crosswikiblock-reason' => 'هۆکار:',
	'crosswikiunblock-reason' => 'هۆکار:',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'crosswikiblock-desc' => 'Umožňuje blokování uživatelů na jiných wiki pomocí [[Special:Crosswikiblock|speciální stránky]]',
	'crosswikiblock' => 'Zablokovat uživatele na jiné wiki',
	'crosswikiblock-header' => 'Tato stránka umožňuje zablokovat uživatele na jiné wiki.
Prosím, ověřte si, že můžete na dané wiki provádět takové akce a že vaše konání odpovídá všem pravidlům.',
	'crosswikiblock-target' => 'IP adresa nebo uživatelské jméno a cílová wiki:',
	'crosswikiblock-expiry' => 'Čas vypršení:',
	'crosswikiblock-reason' => 'Důvod:',
	'crosswikiblock-submit' => 'Zablokovat tohoto uživatele',
	'crosswikiblock-anononly' => 'Zablokovat pouze anonymní uživatele',
	'crosswikiblock-nocreate' => 'Zabránit tvorbě účtů',
	'crosswikiblock-autoblock' => 'Automaticky blokovat poslední IP adresu, kterou tento uživatel použil a jakékoli další adresy, z kterých se pokusí editovat.',
	'crosswikiblock-noemail' => 'Zabránit uživateli odesílat e-mail',
	'crosswikiunblock' => 'Odblokovat uživatele na jiné wiki',
	'crosswikiunblock-header' => 'Tato stránka umožňuje odblokovat uživatele na jiných wiki.
Prosím, zkontrolujte, že můžete na této wiki provádět takovéto akce a že vaše konání odpovídá všem pravidlům.',
	'crosswikiunblock-user' => 'Uživatelské jméno, IP adresa nebo ID bloku a cílová wiki:',
	'crosswikiunblock-reason' => 'Důvod:',
	'crosswikiunblock-submit' => 'Odblokovat tohoto uživatele',
	'crosswikiunblock-success' => "Uživatel '''$1''' byl úspěšně odblokován.

Vrátit se na:
* [[Special:CrosswikiBlock|Blokovací formulář]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nebylo zadáno uživatelské jméno.',
	'crosswikiblock-local' => 'Toto rozhraní nepodporuje místní blokování. Použijte [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'Databáze $1 neexistuje',
	'crosswikiblock-noname' => '„$1“ není platné uživatelské jméno.',
	'crosswikiblock-nouser' => 'Uživatel „$3“ nebyl nalezen.',
	'crosswikiblock-noexpiry' => 'Neplatné vypršení: $1.',
	'crosswikiblock-noreason' => 'Nebyl uveden důvod.',
	'crosswikiblock-notoken' => 'Neplatný editační token.',
	'crosswikiblock-alreadyblocked' => 'Uživatel $3 je již zablokován.',
	'crosswikiblock-noblock' => 'Tento uživatel není zablokován.',
	'crosswikiblock-success' => "Uživatel '''$3''' byl úspěšně zablokován.

Vrátit se na:
* [[Special:CrosswikiBlock|Blokovací formulář]]
* [[$4]]",
	'crosswikiunblock-local' => 'Toto rozhraní nepodporuje místní odblokování. Použije [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blokování a odblokovávání uživatelů na jiných wiki',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'crosswikiblock-reason' => 'Begrundelse:',
	'crosswikiblock-submit' => 'Bloker denne bruger',
	'crosswikiblock-nocreate' => 'Forhindr oprettelse af brugerkontoer',
	'crosswikiblock-autoblock' => 'Spærre den IP-adresse, der bruges af denne bruger samt automatisk alle følgende, hvorfra han foretager ændringer eller forsøger at anlægge brugerkonti',
	'crosswikiblock-noemail' => 'Spær brugerens adgang til at sende e-mail',
	'crosswikiunblock-reason' => 'Begrundelse:',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'crosswikiblock-desc' => 'Erlaubt die Sperre von Benutzern in anderen Wikis über eine [[Special:Crosswikiblock|Spezialseite]]',
	'crosswikiblock' => 'Sperre Benutzer in einem anderen Wiki',
	'crosswikiblock-header' => 'Diese Spezialseite erlaubt die Sperre eines Benutzers in einem anderen Wiki.
Bitte prüfe, ob du die Befugnis hast, in diesem anderen Wiki zu sperren und ob deine Aktion deren Richtlinien entspricht.',
	'crosswikiblock-target' => 'IP-Adresse oder Benutzername und Zielwiki:',
	'crosswikiblock-expiry' => 'Sperrdauer:',
	'crosswikiblock-reason' => 'Grund:',
	'crosswikiblock-submit' => 'IP-Adresse/Benutzer sperren',
	'crosswikiblock-anononly' => 'Sperre nur unangemeldete Benutzer (angemeldete Benutzer mit dieser IP-Adresse werden nicht gesperrt). In vielen Fällen empfehlenswert.',
	'crosswikiblock-nocreate' => 'Erstellung von Benutzerkonten verhindern',
	'crosswikiblock-autoblock' => 'Sperre die aktuell von diesem Benutzer genutzte IP-Adresse sowie automatisch alle folgenden, von denen aus er Bearbeitungen oder das Anlegen von Benutzeraccounts versucht.',
	'crosswikiblock-noemail' => 'E-Mail-Versand sperren',
	'crosswikiunblock' => 'Entsperre Benutzer in einem anderen Wiki',
	'crosswikiunblock-header' => 'Diese Spezialseite erlaubt die Aufhebung einer Benutzersperre in einem anderen Wiki.
Bitte prüfe, ob du die Befugnis hast, in diesem anderen Wiki zu sperren und ob deine Aktion deren Richtlinien entspricht.',
	'crosswikiunblock-user' => 'IP-Adresse, Benutzername oder Sperr-ID und Zielwiki:',
	'crosswikiunblock-reason' => 'Grund:',
	'crosswikiunblock-submit' => 'Sperre für IP-Adresse/Benutzer aufheben',
	'crosswikiunblock-success' => "Benutzer '''„$1“''' erfolgreich entsperrt.

Zurück zu:
* [[Special:CrosswikiBlock|Sperrformular]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Es wurde kein Benutzername eingegeben',
	'crosswikiblock-local' => 'Lokale Sperren werden durch dieses Interface nicht unterstützt. Benutze [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Datenbank $1 ist nicht vorhanden',
	'crosswikiblock-noname' => '„$1“ ist kein gültiger Benutzername.',
	'crosswikiblock-nouser' => 'Benutzer „$3“ nicht gefunden.',
	'crosswikiblock-noexpiry' => 'Ungültige Sperrdauer: $1.',
	'crosswikiblock-noreason' => 'Begründung fehlt.',
	'crosswikiblock-notoken' => 'Ungültiges Bearbeitungstoken',
	'crosswikiblock-alreadyblocked' => 'Benutzer „$3“ ist bereits gesperrt.',
	'crosswikiblock-noblock' => 'Dieser Benutzer ist nicht gesperrt.',
	'crosswikiblock-success' => "Benutzer '''„$3“''' erfolgreich gesperrt.

Zurück zu:
* [[Special:CrosswikiBlock|Sperrformular]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokale Sperren werden über dieses Formular nicht unterstützt. Bitte benutze [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => 'Benutzer auf anderen Wikis sperren oder entsperren',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'crosswikiblock-header' => 'Diese Spezialseite erlaubt die Sperre eines Benutzers in einem anderen Wiki.
Bitte prüfen Sie, ob Sie die Befugnis haben, in diesem anderen Wiki zu sperren und ob Ihre Aktion deren Richtlinien entspricht.',
	'crosswikiunblock-header' => 'Diese Spezialseite erlaubt die Aufhebung einer Benutzersperre in einem anderen Wiki.
Bitte prüfen Sie, ob Sie die Befugnis haben, in diesem anderen Wiki zu sperren und ob Ihre Aktion deren Richtlinien entspricht.',
	'crosswikiblock-local' => 'Lokale Sperren werden durch dieses Interface nicht unterstützt. Benutzen Sie [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiunblock-local' => 'Lokale Sperren werden über dieses Formular nicht unterstützt. Bitte benutzen Sie [[Special:IPBlockList|{{int:ipblocklist}}]].',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'crosswikiblock-desc' => 'Dowólujo wužywarjow w drugich wikijach z pomocu [[Special:Crosswikiblock|specialnego boka]] blokěrowaś',
	'crosswikiblock' => 'Wužywarja na drugem wikiju blokěrowaś',
	'crosswikiblock-header' => 'Toś ten bok dowólujo wužywarja na drugem wikiju blokěrowaś.
Kontrolěruj pšosym, lěc smějoš na toś tom wikiju aktiwny byś a twóje akcije směrnicam wótpowěduju.',
	'crosswikiblock-target' => 'IP-adresa abo wužywarske mě a celowy wiki:',
	'crosswikiblock-expiry' => 'Pśepadnjenje:',
	'crosswikiblock-reason' => 'Pśicyna:',
	'crosswikiblock-submit' => 'Toś togo wužywarja blokěrowaś',
	'crosswikiblock-anononly' => 'Jano anonymnych wužywarjow blokěrowaś',
	'crosswikiblock-nocreate' => 'Napóranjeju kontow zajźowaś',
	'crosswikiblock-autoblock' => 'IP-adresu, kótaruž wužywaŕ jo ako slědnu wužył a wše slědujuce IP-adresy, z kótarychž wopytujo wobźěłaś, awtomatiski blokěrowaś',
	'crosswikiblock-noemail' => 'Wužiwarjeju pósłanje e-mailow zawóboraś',
	'crosswikiunblock' => 'Blokěrowanje wužywarja na drugem wikiju wótpóraś',
	'crosswikiunblock-header' => 'Toś ten bok dowólujo wótpóranje blokěrowanja wužywarja na drugem wikiju.
Kontrolěruj pšosym, lěc smějoš na toś tom wikiju aktiwny byś a twóje akcije wšym směrnicam wótpowěduju.',
	'crosswikiunblock-user' => 'Wužywarske mě, IP-adresa abo ID blokěrowanja a celowy wiki:',
	'crosswikiunblock-reason' => 'Pśicyna:',
	'crosswikiunblock-submit' => 'Blokěrowanje za toś togo wužywarja wótpóraś',
	'crosswikiunblock-success' => "Blokěrowanje za wužywarja '''$1''' wuspěšnje wótpórane.

Slědk k:
* [[Special:CrosswikiBlock|Blokěrowański formular]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Žedno wužywarske mě zapódane',
	'crosswikiblock-local' => 'Lokalne blokěrowanja njepódpěraju se pśez toś ten interfejs. Wužyj [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Datowa banka $1 njeeksistěrujo',
	'crosswikiblock-noname' => '"$1" njejo płaśiwe wužywarske mě.',
	'crosswikiblock-nouser' => 'Wužywaŕ "$3" njejo se namakał.',
	'crosswikiblock-noexpiry' => 'Njepłaśiwe pśepadnjenje: $1.',
	'crosswikiblock-noreason' => 'Žedna pśicyna pódana.',
	'crosswikiblock-notoken' => 'Njepłaśiwy wobźěłański token.',
	'crosswikiblock-alreadyblocked' => 'Wužywaŕ $3 jo južo blokěrowany.',
	'crosswikiblock-noblock' => 'Toś ten wužywaŕ njejo blokěrowany.',
	'crosswikiblock-success' => "Wužywaŕ '''$3''' wuspěšnje blokěrowany.

Slědk k:
* [[Special:CrosswikiBlock|Blokěrowański formular]]
* [[$4]]",
	'crosswikiunblock-local' => 'Wótpóranja lokalnych blokěrowanjow njepódpěraju se pśez toś ten interfejs. Wužyj [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Wužywarjow na drugich wikijach blokěrowaś a dowóliś',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'crosswikiblock-expiry' => 'Nuwuwu:',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 */
$messages['el'] = array(
	'crosswikiblock-expiry' => 'Λήξη:',
	'crosswikiblock-reason' => 'Λόγος:',
	'crosswikiblock-submit' => 'Φραγή αυτού του χρήστη',
	'crosswikiblock-nocreate' => 'Παρεμπόδιση δημιουργίας λογαριασμού',
	'crosswikiunblock-reason' => 'Λόγος:',
	'crosswikiunblock-submit' => 'Άρση φραγής αυτού του χρήστη',
	'crosswikiblock-noexpiry' => 'Μη έγκυρη λήξη: $1.',
	'crosswikiblock-noreason' => 'Δεν δόθηκε κάποιος λόγος.',
	'crosswikiblock-notoken' => 'Μη έγκυρο δείγμα επεξεργασίας',
	'right-crosswikiblock' => 'Φραγή και απόφραξη χρηστών σε άλλα βίκι',
);

/** Esperanto (Esperanto)
 * @author Castelobranco
 * @author LyzTyphone
 * @author Yekrats
 */
$messages['eo'] = array(
	'crosswikiblock-desc' => 'Permesas forbari uzantojn ĉe aliaj vikioj uzante [[Special:Crosswikiblock|specialan paĝon]]',
	'crosswikiblock' => 'Forbari uzanton ĉe alia vikio',
	'crosswikiblock-header' => 'Ĉi paĝo permesas forbari uzanton ĉe alia vikio.
Bonvolu verigi se vi rajtas agi en ĉi vikio kaj viaj agoj sekvas ĉiujn kondutmanierojn.',
	'crosswikiblock-target' => 'IP-adreso aŭ uzanto-nomo kaj cela vikio:',
	'crosswikiblock-expiry' => 'Findato:',
	'crosswikiblock-reason' => 'Kialo:',
	'crosswikiblock-submit' => 'Bloki la uzanton',
	'crosswikiblock-anononly' => 'Forbari nur anonimajn uzantojn',
	'crosswikiblock-nocreate' => 'Preventi kreadon de kontoj',
	'crosswikiblock-autoblock' => 'Aŭtomate forbaru la lastan IP-adreson uzatan de ĉi uzanto, kaj iujn ajn postajn el kiujn ili provas redakti.',
	'crosswikiblock-noemail' => 'Preventu de uzanto sendi retpoŝton',
	'crosswikiunblock' => 'Restarigi uzanton ĉe alia vikio',
	'crosswikiunblock-header' => 'Ĉi tiu paĝo permesas malforbari uzanton ĉe alia vikio.
Bonvolu verigi se vi rajtas agi en ĉi vikio kaj viaj agoj sekvas ĉiujn kondutmanierojn.',
	'crosswikiunblock-user' => 'Uzanto-nomo, IP-adreso, aŭ forbaro-identigo kaj cela vikio:',
	'crosswikiunblock-reason' => 'Kialo:',
	'crosswikiunblock-submit' => 'Restarigi ĉi tiun uzanton',
	'crosswikiunblock-success' => "Uzanto '''$1''' malforbarita sukcese.

Reen:
* [[Special:CrosswikiBlock|Forbarpaĝo]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Neniu uzanto-nomo estis entajpita',
	'crosswikiblock-local' => 'Lokaj forbaroj ne estas subtenataj per ĉi interfaco. Uzu [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Datumbazo $1 ne ekzistas.',
	'crosswikiblock-noname' => '"$1" ne estas valida uzanto-nomo.',
	'crosswikiblock-nouser' => 'Uzanto "$3" ne estas trovita.',
	'crosswikiblock-noexpiry' => 'Nevalida findato: $1.',
	'crosswikiblock-noreason' => 'Nenia kialo donata.',
	'crosswikiblock-notoken' => 'Nevalida redakta ĵetono.',
	'crosswikiblock-alreadyblocked' => 'Uzanto $3 jam estas forbarita.',
	'crosswikiblock-noblock' => 'Ĉi tiu uzanto ne estas forbarita.',
	'crosswikiblock-success' => "Uzanto '''$3''' sukcese forbarita.

Reen:
* [[Special:CrosswikiBlock|Forbarpaĝo]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokaj malforbaroj ne estas subtenataj per ĉi interfaco. Uzu [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Bloki kaj malbloki uzantojn en aliaj vikioj.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author Fitoschido
 * @author Imre
 * @author Locos epraix
 */
$messages['es'] = array(
	'crosswikiblock-desc' => 'Permite bloquear a usuarios en otros wikis usando una [[Special:Crosswikiblock|página especial]]',
	'crosswikiblock' => 'Bloquear al usuario en otro wiki',
	'crosswikiblock-header' => 'Esta página permite bloquear a un usuario en otro wiki.
Por favor, comprueba si estás autorizado a actuar en ese wiki y que tus acciones siguen las políticas.',
	'crosswikiblock-target' => 'Dirección IP o nombre de usuario y wiki de destino:',
	'crosswikiblock-expiry' => 'Duración:',
	'crosswikiblock-reason' => 'Motivo:',
	'crosswikiblock-submit' => 'Bloquear a este usuario',
	'crosswikiblock-anononly' => 'Bloquear solo usuarios anónimos',
	'crosswikiblock-nocreate' => 'Prevenir la creación de cuenta de usuario',
	'crosswikiblock-autoblock' => 'Bloquear automáticamente la dirección IP usada por este usuario, y cualquier IP posterior desde la cual intente editar',
	'crosswikiblock-noemail' => 'Prevenir el envío de correo electrónico',
	'crosswikiunblock' => 'Desbloquear al usuario en otro wiki',
	'crosswikiunblock-header' => 'Esta página permite desbloquear a un usuario en otro wiki.
Por favor, comprueba si estás autorizado a actuar en ese wiki y que tus acciones siguen las políticas.',
	'crosswikiunblock-user' => 'Nombre de usuario, dirección IP o bloquear ID y wiki de destino:',
	'crosswikiunblock-reason' => 'Motivo:',
	'crosswikiunblock-submit' => 'Desbloquear este usuario',
	'crosswikiunblock-success' => "Usuario '''$1''' desbloqueado exitosamente.

Regresar a:
* [[Special:CrosswikiBlock|Formulario de bloqueo]]
* [[$2]]",
	'crosswikiblock-nousername' => 'No se proporcionó ningún nombre de usuario',
	'crosswikiblock-local' => 'Bloqueos locales no están soportados a través de esta interface. Usar [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'La base de datos $1 no existe',
	'crosswikiblock-noname' => '«$1» no es un nombre de usuario válido.',
	'crosswikiblock-nouser' => 'No se encontró al usuario «$3».',
	'crosswikiblock-noexpiry' => 'Caducidad no válida: $1.',
	'crosswikiblock-noreason' => 'No se especificó ningún motivo.',
	'crosswikiblock-notoken' => 'Token de edición no válido.',
	'crosswikiblock-alreadyblocked' => 'El usuario «$3» ya está bloqueado.',
	'crosswikiblock-noblock' => 'Este usuario no está bloqueado.',
	'crosswikiblock-success' => "El usuario '''$3''' fue bloqueado correctamente.

Volver a:
* [[Special:CrosswikiBlock|Formulario de bloqueo]]
* [[$4]]",
	'crosswikiunblock-local' => 'Los desbloqueos locales no están soportados a través de esta interfaz. Usa [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Bloquear o desbloquear usuarios en otros wikis',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 * @author Silvar
 */
$messages['et'] = array(
	'crosswikiblock' => 'Blokeeri kasutaja teises wikis',
	'crosswikiblock-expiry' => 'Aegub:',
	'crosswikiblock-reason' => 'Põhjus:',
	'crosswikiblock-submit' => 'Blokeeri see kasutaja',
	'crosswikiblock-anononly' => 'Blokeeri ainult anonüümseid kasutajaid',
	'crosswikiblock-nocreate' => 'Takista konto loomist',
	'crosswikiblock-autoblock' => 'Blokeeri automaatselt viimane IP-aadress, mida see kasutaja kasutas, ja ka järgnevad, mille alt ta võib proovida kaastööd teha',
	'crosswikiblock-noemail' => 'Takista kasutajal e-kirjade saatmine',
	'crosswikiunblock-reason' => 'Põhjus:',
	'crosswikiunblock-submit' => 'Lõpeta kasutaja blokeering',
	'crosswikiblock-nousername' => 'Ühtegi kasutajanime ei antud',
	'crosswikiblock-noname' => '"$1" ei ole õige kasutajanimi.',
	'crosswikiblock-nouser' => 'Kasutajat "$3" ei leitud.',
	'crosswikiblock-noreason' => 'Põhjust ei ole märgitud.',
	'crosswikiblock-alreadyblocked' => 'Kasutaja $3 on juba blokeeritud.',
	'crosswikiblock-noblock' => 'See kasutaja ei ole blokeeritud.',
);

/** Basque (Euskara)
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'crosswikiblock' => 'Erabiltzailea blokeatu beste wiki batean',
	'crosswikiblock-reason' => 'Arrazoia:',
	'crosswikiblock-submit' => 'Erabiltzaile hau blokeatu',
	'crosswikiblock-nocreate' => 'Kontuen sorrera eragotzi',
	'crosswikiblock-noemail' => 'Erabiltzaileak e-mailak bidal ditzan ekidin',
	'crosswikiunblock' => 'Erabiltzailea desblokeatu beste wiki batean',
	'crosswikiunblock-reason' => 'Arrazoia:',
	'crosswikiunblock-submit' => 'Erabiltzaile hau desblokeatu',
	'crosswikiblock-nousername' => 'Ez da erabiltzaile izenik zehaztu',
	'crosswikiblock-dbnotfound' => '$1 datu-basea ez da existitzen',
	'crosswikiblock-noname' => '"$1" ez da baliozko erabiltzaile izena.',
	'crosswikiblock-nouser' => 'Ez da "$3" erabiltzailea aurkitu.',
	'crosswikiblock-noreason' => 'Ez da arrazoirik zehaztu.',
	'crosswikiblock-noblock' => 'Erabiltzaile hau ez dago blokeaturik.',
	'right-crosswikiblock' => 'Erabiltzaileak beste wikietan blokeatu eta desblokeatu',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'crosswikiblock-reason' => 'دلیل:',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'crosswikiblock' => 'Estä käyttäjä toisessa wikissä',
	'crosswikiblock-header' => 'Tämä sivu mahdollistaa käyttäjien estämisen toisessa wikissä.
Tarkista, saatko toimia tässä wikissä ja että toimesi ovat käytäntöjen mukaisia.',
	'crosswikiblock-target' => 'IP-osoite tai käyttäjänimi kohdewikissä',
	'crosswikiblock-expiry' => 'Kesto',
	'crosswikiblock-reason' => 'Syy',
	'crosswikiblock-submit' => 'Estä tämä käyttäjä',
	'crosswikiblock-anononly' => 'Estä vain kirjautumattomat käyttäjät',
	'crosswikiblock-nocreate' => 'Estä tunnusten luonti',
	'crosswikiblock-autoblock' => 'Estä viimeisin IP-osoite, josta käyttäjä on muokannut, sekä ne osoitteet, joista hän jatkossa yrittää muokata.',
	'crosswikiblock-noemail' => 'Estä käyttäjää lähettämästä sähköpostia',
	'crosswikiunblock' => 'Poista käyttäjän muokkausesto toisesta wikistä',
	'crosswikiunblock-header' => 'Tämä sivu mahdollistaa käyttäjien muokkauseston poistamisen toisesta wikistä.
Tarkista, saatko toimia tässä wikissä ja että toimesi ovat käytäntöjen mukaisia.',
	'crosswikiunblock-user' => 'Käyttäjänimi, IP-osoite tai eston ID ja kohdewiki',
	'crosswikiunblock-reason' => 'Syy',
	'crosswikiunblock-submit' => 'Poista tämän käyttäjän muokkausesto',
	'crosswikiunblock-success' => "Käyttäjän '''$1''' esto poistettiin.

Palaa takaisin:
* [[Special:CrosswikiBlock|estosivulle]]
* [[$2]].",
	'crosswikiblock-nousername' => 'Käyttäjätunnusta ei annettu',
	'crosswikiblock-dbnotfound' => 'Tietokantaa $1 ei ole',
	'crosswikiblock-noname' => '”$1” ei ole kelvollinen käyttäjätunnus.',
	'crosswikiblock-nouser' => 'Käyttäjää ”$3” ei löydy.',
	'crosswikiblock-noexpiry' => 'Virheellinen vanhenemisaika $1.',
	'crosswikiblock-noreason' => 'Syytä ei eritelty.',
	'crosswikiblock-alreadyblocked' => 'Käyttäjä $3 on jo estetty.',
	'crosswikiblock-noblock' => 'Käyttäjää ei ole estetty.',
	'crosswikiblock-success' => "Käyttäjä '''$3''' estettiin.

Palaa:
* [[Special:CrosswikiBlock|estosivulle]]
* [[$4]]",
	'right-crosswikiblock' => 'Estää ja poistaa estoja muissa wikeissä',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Meithal
 * @author PieRRoMaN
 * @author Urhixidur
 */
$messages['fr'] = array(
	'crosswikiblock-desc' => "Permet de bloquer des utilisateurs sur d'autres wikis en utilisant [[Special:Crosswikiblock|une page spéciale]]",
	'crosswikiblock' => 'Bloquer un utilisateur sur un autre wiki',
	'crosswikiblock-header' => 'Cette page permet de bloquer un utilisateur sur un autre wiki.
Vérifiez si vous êtes habilité{{GENDER:||e|(e)}} pour agir sur ce wiki et que vos actions respectent toutes les règles.',
	'crosswikiblock-target' => "Adresse IP ou nom d'utilisateur et wiki de destination :",
	'crosswikiblock-expiry' => 'Expiration :',
	'crosswikiblock-reason' => 'Motif :',
	'crosswikiblock-submit' => 'Bloquer cet utilisateur',
	'crosswikiblock-anononly' => 'Bloquer uniquement les utilisateurs anonymes',
	'crosswikiblock-nocreate' => 'Interdire la création de compte',
	'crosswikiblock-autoblock' => "Bloque automatiquement la dernière adresse IP utilisée par cet utilisateur, et toutes les IP subséquentes qui essaient d'éditer",
	'crosswikiblock-noemail' => "Interdire à l'utilisateur d'envoyer un courriel",
	'crosswikiunblock' => "Débloquer en écriture un utilisateur d'un autre wiki",
	'crosswikiunblock-header' => "Cette page permet de débloquer en écriture un utilisateur d'un autre wiki.
Veuillez vous assurer que vous possédez les droits et respectez les règles en vigueur sur ce wiki.",
	'crosswikiunblock-user' => "Nom d'utilisateur, adresse IP ou l'id de blocage et le wiki ciblé :",
	'crosswikiunblock-reason' => 'Motif :',
	'crosswikiunblock-submit' => 'Débloquer en écriture cet utilisateur',
	'crosswikiunblock-success' => "L'utilisateur '''$1''' a été débloqué en écriture avec succès.

Revenir à :
* [[Special:CrosswikiBlock|Formulaire de blocage]]
* [[$2]]",
	'crosswikiblock-nousername' => "Aucun nom d'utilisateur n'a été indiqué",
	'crosswikiblock-local' => 'Les blocages locaux ne sont pas supportés au travers de cette interface. Utilisez [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'La base de données « $1 » n’existe pas',
	'crosswikiblock-noname' => '« $1 » n’est pas un nom d’utilisateur valide.',
	'crosswikiblock-nouser' => 'L’utilisateur « $3 » est introuvable.',
	'crosswikiblock-noexpiry' => 'Date ou durée d’expiration incorrecte : $1.',
	'crosswikiblock-noreason' => 'Aucun motif indiqué.',
	'crosswikiblock-notoken' => 'Jeton de modification invalide.',
	'crosswikiblock-alreadyblocked' => 'L’utilisateur « $3 » est déjà bloqué.',
	'crosswikiblock-noblock' => "Cet utilisateur n'est pas bloqué en écriture.",
	'crosswikiblock-success' => "L’utilisateur '''$3''' a été bloqué avec succès.

Revenir vers :
* [[Special:CrosswikiBlock|Le formulaire de blocage]] ;
* [[$4]].",
	'crosswikiunblock-local' => 'Les blocages en écriture locaux ne sont pas supportés via cette interface. Utilisez [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => "Bloquer et débloquer des utilisateurs sur d'autres wikis",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'crosswikiblock' => 'Blocar un usanciér sur un ôtro vouiqui',
	'crosswikiblock-target' => 'Adrèce IP ou ben nom d’utilisator et vouiqui de dèstinacion :',
	'crosswikiblock-expiry' => 'Èxpiracion :',
	'crosswikiblock-reason' => 'Rêson :',
	'crosswikiblock-submit' => 'Blocar ceti usanciér',
	'crosswikiblock-anononly' => 'Blocar ren que los utilisators pas encartâs',
	'crosswikiblock-nocreate' => 'Empachiér la crèacion de compto',
	'crosswikiblock-noemail' => 'Empachiér l’utilisator de mandar des mèssâjos',
	'crosswikiunblock' => 'Dèblocar un usanciér sur un ôtro vouiqui',
	'crosswikiunblock-user' => 'Nom d’utilisator, adrèce IP ou ben numerô de blocâjo et vouiqui de dèstinacion :',
	'crosswikiunblock-reason' => 'Rêson :',
	'crosswikiunblock-submit' => 'Dèblocar ceti usanciér',
	'crosswikiblock-nousername' => 'Nion nom d’utilisator at étâ balyê',
	'crosswikiblock-dbnotfound' => 'La bâsa de balyês $1 ègziste pas',
	'crosswikiblock-noname' => '« $1 » est pas un nom d’utilisator valido.',
	'crosswikiblock-nouser' => 'L’utilisator « $3 » est entrovâblo.',
	'crosswikiblock-noexpiry' => 'Temps d’èxpiracion fôx : $1.',
	'crosswikiblock-noreason' => 'Niona rêson at étâ spècefiâ.',
	'crosswikiblock-notoken' => 'Jeton de changement envalido.',
	'crosswikiblock-alreadyblocked' => 'L’utilisator $3 est ja blocâ.',
	'crosswikiblock-noblock' => 'Ceti usanciér est pas blocâ.',
	'right-crosswikiblock' => 'Blocar et dèblocar des utilisators sur d’ôtros vouiquis',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'crosswikiblock-expiry' => 'Ferrint nei:',
	'crosswikiblock-anononly' => 'Slút allinich anonyme meidoggers út',
	'crosswikiblock-autoblock' => "Automatysk de lêste IP adressen útslute dy't troch dizze meidogger brûkt binne.",
	'crosswikiblock-alreadyblocked' => 'Meidogger $3 is al útsluten.',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'crosswikiblock-desc' => 'Permite bloquear usuarios doutros wikis mediante unha [[Special:Crosswikiblock|páxina especial]]',
	'crosswikiblock' => 'Usuario bloqueado noutro wiki',
	'crosswikiblock-header' => 'Esta páxina permítelle bloquear un usuario noutro wiki.
Por favor, comprobe se ten permiso para actuar neste wiki que se as súas accións coinciden coas políticas.',
	'crosswikiblock-target' => 'Enderezo IP ou nome de usuario e wiki de destino:',
	'crosswikiblock-expiry' => 'Remate:',
	'crosswikiblock-reason' => 'Motivo:',
	'crosswikiblock-submit' => 'Bloquear este usuario',
	'crosswikiblock-anononly' => 'Bloquear só os usuarios anónimos',
	'crosswikiblock-nocreate' => 'Previr a creación de contas',
	'crosswikiblock-autoblock' => 'Bloquear automaticamente o último enderezo IP utilizado por este usuario, e calquera outro enderezo desde o que intente editar',
	'crosswikiblock-noemail' => 'Advertir ao usuario do envío de correo electrónico',
	'crosswikiunblock' => 'Desbloquear este usuario noutro wiki',
	'crosswikiunblock-header' => 'Esta páxina permitiralle desbloquear un usuario noutro wiki.
Por favor, comprobe se lle está permitido actuar neste wiki e se os seus actos coinciden coas políticas.',
	'crosswikiunblock-user' => 'Nome de usuario, enderezo IP ou ID de bloqueo e wiki de destino:',
	'crosswikiunblock-reason' => 'Motivo:',
	'crosswikiunblock-submit' => 'Desbloquear este usuario',
	'crosswikiunblock-success' => "O usuario '''$1''' foi desbloqueado con éxito.

Volver a:
* [[Special:CrosswikiBlock|Formulario de bloqueo]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Non foi inserido ningún alcume',
	'crosswikiblock-local' => 'Os bloqueos locais non están soportados mediante esta interface. Use [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'A base de datos $1 non existe',
	'crosswikiblock-noname' => '"$1" non é un nome de usuario válido.',
	'crosswikiblock-nouser' => 'Non se atopa o usuario "$3".',
	'crosswikiblock-noexpiry' => 'Caducidade non válida: $1.',
	'crosswikiblock-noreason' => 'Ningunha razón especificada.',
	'crosswikiblock-notoken' => 'Sinal de edición non válido.',
	'crosswikiblock-alreadyblocked' => 'O usuario $3 xa está bloqueado.',
	'crosswikiblock-noblock' => 'Este usuario non está bloqueado.',
	'crosswikiblock-success' => "O usuario '''$3''' foi bloqueado con éxito.

Volver a:
* [[Special:CrosswikiBlock|Formulario de bloqueo]]
* [[$4]]",
	'crosswikiunblock-local' => 'Os desbloqueos locais non están soportados mediante esta interface. Use [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Bloquear e desbloquear usuarios noutros wikis',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'crosswikiblock-reason' => '𐍆𐌰𐌹𐍂𐌹𐌽𐌰:',
	'crosswikiunblock-reason' => '𐍆𐌰𐌹𐍂𐌹𐌽𐌰:',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'crosswikiblock-reason' => 'Αἰτία:',
	'crosswikiunblock-reason' => 'Αἰτία:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'crosswikiblock-desc' => 'Erlaubt d Sperri vu Benutzer in andere Wiki iber e [[Special:Crosswikiblock|Spezialsyte]]',
	'crosswikiblock' => 'Benutzer in eme andere Wiki sperre',
	'crosswikiblock-header' => 'Die Spezialsyte erlaubt d Sperri vun eme Benutzer in eme andere Wiki.
Bitte prief, eb Du s Rächt hesch, in däm andere Wiki z sperre un eb Dyy Aktion dr Richtlinie vu sälem Wiki entspricht.',
	'crosswikiblock-target' => 'IP-Adräss oder Benutzername un Ziilwiki:',
	'crosswikiblock-expiry' => 'Sperrduur:',
	'crosswikiblock-reason' => 'Grund:',
	'crosswikiblock-submit' => 'IP-Adräss/Benutzer sperre',
	'crosswikiblock-anononly' => 'Nume anonyme Benutzer sperre',
	'crosswikiblock-nocreate' => 'Aalege vu Benutzerkonte verhindere',
	'crosswikiblock-autoblock' => 'Di aktuäll vu däm Benutzer bruucht IP-Adräss sperre, dezue automatisch  alli wytere, wun er dervu uus versuecht Bearbeitige z mache oder e Benutzerkonto aazlege.',
	'crosswikiblock-noemail' => 'Eme Benutzer s Verschicke vu E-Mail sperre',
	'crosswikiunblock' => 'D Sperri vun eme Benutzer in eme andere Wiki ufhebe',
	'crosswikiunblock-header' => 'Die Spezialsyte erlaubt s Ufhebe vun ere Benutzersperri in eme andere Wiki.
Bitte prief, eb Du s Rächt hesch, in däm andere Wiki z sperren un eb Dyy Aktion dr Richtlinie vu sälem Wiki entspricht.',
	'crosswikiunblock-user' => 'IP-Adräss, Benutzername oder Sperr-ID und Ziilwiki:',
	'crosswikiunblock-reason' => 'Grund:',
	'crosswikiunblock-submit' => 'Sperri fir IP-Adräss/Benutzer ufhebe',
	'crosswikiunblock-success' => "D Sperri vum Benutzer '''„$1“''' erfolgryych ufghobe.

Zrugg zue:
* [[Special:CrosswikiBlock|Sperrformular]]
* [[$2]]",
	'crosswikiblock-nousername' => 'S isch kei Benutzername aagee wore',
	'crosswikiblock-local' => 'Lokali Sperrine wäre dur des Interface nit unterstitzt. Verwänd [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Datebank $1 git s nit',
	'crosswikiblock-noname' => '„$1“ isch kei giltige Benutzername.',
	'crosswikiblock-nouser' => 'Benutzer „$3“ nit gfunde.',
	'crosswikiblock-noexpiry' => 'Nit giltigi Sperrduur: $1.',
	'crosswikiblock-noreason' => 'Kei Grund aagee.',
	'crosswikiblock-notoken' => 'Nit giltig Bearbeitigs-Token.',
	'crosswikiblock-alreadyblocked' => 'Benutzer „$3“ ish scho gsperrt.',
	'crosswikiblock-noblock' => 'Dää Benutzer isch nit gsperrt.',
	'crosswikiblock-success' => "Benutzer '''„$3“''' erfolgryych gsperrt.

Zrugg zue:
* [[Special:CrosswikiBlock|Sperrformular]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokali Sperrine wäre iber des Interface nit unterstitzt. Bitte verwänd [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => 'Benutzer uf andere Wikis sperre oder d Sperri ufhebe',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'crosswikiblock-reason' => 'Fa:',
	'crosswikiunblock-reason' => 'Fa:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'crosswikiblock-reason' => 'Dalili:',
	'crosswikiunblock-reason' => 'Dalili:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'crosswikiblock-reason' => 'Kumu:',
	'crosswikiunblock-reason' => 'Kumu:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'crosswikiblock-desc' => 'אפשרות לחסימת משתמשים באתרי ויקי אחרים באמצעות [[Special:Crosswikiblock|דף מיוחד]]',
	'crosswikiblock' => 'חסימת משתמש בוויקי אחר',
	'crosswikiblock-header' => 'דף זה מאפשר חסימת משתמש בוויקי אחר.
אנא ודאו שאתם מורשים לפעול בוויקי זה ושפעולותיכם תואמות את כל דפי המדיניות.',
	'crosswikiblock-target' => 'כתובת ה־IP או שם המשתמש ווויקי היעד:',
	'crosswikiblock-expiry' => 'זמן פקיעה:',
	'crosswikiblock-reason' => 'סיבה:',
	'crosswikiblock-submit' => 'חסימת משתמש זה',
	'crosswikiblock-anononly' => 'חסימה של משתמשים אנונימיים בלבד',
	'crosswikiblock-nocreate' => 'חסימה של יצירת חשבונות',
	'crosswikiblock-autoblock' => 'חסימה גם של כתובת ה־IP שלו וכל כתובת IP אחרת שישתמש בה',
	'crosswikiblock-noemail' => 'חסימה של שליחת דואר אלקטרוני',
	'crosswikiunblock' => 'שחרור חסימת משתמש בוויקי אחר',
	'crosswikiunblock-header' => 'דף זה מאפשר לכם לשחרר חסימה של משתמש באתר ויקי אחרים.
אנא ודאו שאתם מורשים לפעול בוויקי זה ושפעולותיכם תואמות את כל דפי המדיניות.',
	'crosswikiunblock-user' => 'שם משתמש, כתובת IP או מספר חסימה ווויקי היעד:',
	'crosswikiunblock-reason' => 'סיבה:',
	'crosswikiunblock-submit' => 'שחרור חסימת משתמש זה',
	'crosswikiunblock-success' => "שחרור חסימת המשתמש '''$1''' בוצע בהצלחה.

חזרה ל:
* [[Special:CrosswikiBlock|טופס החסימה]]
* [[$2]]",
	'crosswikiblock-nousername' => 'לא הוזן שם משתמש',
	'crosswikiblock-local' => 'חסימות מקומיות אינן נתמכות בממשק זה. השתמשו ב[[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'מסד הנתונים $1 אינו קיים',
	'crosswikiblock-noname' => '"$1" אינו שם משתמש תקין.',
	'crosswikiblock-nouser' => 'המשתמש "$3" לא נמצא.',
	'crosswikiblock-noexpiry' => 'זמן פקיעה בלתי תקין: $1.',
	'crosswikiblock-noreason' => 'לא צוינה סיבה.',
	'crosswikiblock-notoken' => 'אסימון עריכה שגוי.',
	'crosswikiblock-alreadyblocked' => 'המשתמש $3 כבר נחסם.',
	'crosswikiblock-noblock' => 'משתמש זה לא נחסם.',
	'crosswikiblock-success' => "המשתמש '''$3''' נחסם בהצלחה.

חזרה ל:
* [[Special:CrosswikiBlock|טופס החסימה]]
* [[$4]]",
	'crosswikiunblock-local' => 'שחרור חסימות מקומיות אינו נתמך דרך ממשק זה. השתמשו ב[[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'חסימה ושחרור משתמשים באתרי ויקי אחרים',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'crosswikiblock-desc' => 'अन्य विकियोंपर [[Special:Crosswikiblock|विशेष पृष्ठ]] का इस्तेमाल करके सदस्य ब्लॉक करने की अनुमति देता हैं।',
	'crosswikiblock' => 'अन्य विकिपर सदस्यको ब्लॉक करें',
	'crosswikiblock-header' => 'यह पन्ना अन्य विकियोंपर सदस्य को ब्लॉक करने की अनुमति देता हैं।
कृपया यह क्रिया करनेके लिये पर्याप्त अधिकार आपको हैं और यह क्रिया नीती के अनुसार ही हैं यह जाँच लें।',
	'crosswikiblock-target' => 'आईपी एड्रेस या सदस्यनाम तथा लक्ष्य विकि:',
	'crosswikiblock-expiry' => 'समाप्ती:',
	'crosswikiblock-reason' => 'कारण:',
	'crosswikiblock-submit' => 'इस सदस्य को ब्लॉक करें',
	'crosswikiblock-anononly' => 'सिर्फ अनामक सदस्योंको ब्लॉक करें',
	'crosswikiblock-nocreate' => 'खाता खोलने पर प्रतिबंध लगायें',
	'crosswikiblock-noemail' => 'इ-मेल भेजने पर प्रतिबंध लगायें',
	'crosswikiunblock' => 'अन्य विकियोंपर सदस्यको अनब्लॉक करें',
	'crosswikiunblock-user' => 'सदस्य नाम, आईपी एड्रेस या ब्लॉक क्रमांक तथा लक्ष्य विकि:',
	'crosswikiunblock-reason' => 'कारण:',
	'crosswikiunblock-submit' => 'इस सदस्य को अनब्लॉक करें',
	'crosswikiblock-nousername' => 'सदस्यनाम दिया नहीं',
	'crosswikiblock-local' => 'स्थानिक ब्लॉक यहां पर बदले नहीं जा सकतें। [[Special:BlockIP|{{int:blockip}}]] का इस्तेमाल करें',
	'crosswikiblock-dbnotfound' => 'डाटाबेस $1 उपलब्ध नहीं हैं',
	'crosswikiblock-noname' => '"$1" यह वैध सदस्यनाम नहीं हैं।',
	'crosswikiblock-nouser' => 'सदस्य "$3" मिला नहीं।',
	'crosswikiblock-noexpiry' => 'गलत समाप्ती: $1।',
	'crosswikiblock-noreason' => 'कारण दिया नहीं।',
	'crosswikiblock-notoken' => 'गलत एडिट टोकन',
	'crosswikiblock-alreadyblocked' => 'सदस्य $3 को पहलेसे ब्लॉक किया हुआ हैं।',
	'crosswikiblock-noblock' => 'इस सदस्यको ब्लॉक नहीं किया हैं।',
	'crosswikiunblock-local' => 'स्थानिक अनब्लॉक यहां पर बदले नहीं जा सकतें। [[Special:IPBlockList|{{int:ipblocklist}}]] का इस्तेमाल करें',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'crosswikiblock-reason' => 'Rason:',
	'crosswikiunblock-reason' => 'Rason:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'crosswikiblock-desc' => 'Dowola wužiwarjow na druhich wikijach z pomocu [[Special:Crosswikiblock|specialneje strony]] blokować',
	'crosswikiblock' => 'Wužiwarja na druhim wikiju blokować',
	'crosswikiblock-header' => 'Tuta strona dowola wužiwarja na druhim wikiju blokować.
Prošu pruwuj, hač maš dowolnosć na tym wikiju skutkować a swoje akcije wšěm prawidłam wotpowěduja.',
	'crosswikiblock-target' => 'IP-adresa abo wužiwarske mjeno a cilowy wiki:',
	'crosswikiblock-expiry' => 'Spadnjenje:',
	'crosswikiblock-reason' => 'Přičina:',
	'crosswikiblock-submit' => 'Tutoho wužiwarja blokować',
	'crosswikiblock-anononly' => 'Jenož anonymnych wužiwarjow blokować',
	'crosswikiblock-nocreate' => 'Wutworjenju konta zadźěwać',
	'crosswikiblock-autoblock' => 'Awtomatisce poslednju IPa-dresu wužitu wot tutoho wužiwarja blokować, inkluziwnje naslědnych IP-adresow, z kotrychž pospytuje wobdźěłać',
	'crosswikiblock-noemail' => 'Słanju e-mejlkow wot wužiwarja zadźěwać',
	'crosswikiunblock' => 'Wužiwarja na druhim wikiju wotblokować',
	'crosswikiunblock-header' => 'Tuta strona zmóžnja wužiwarja na druhim wikiju wotblokować.
Přepruwuj prošu, hač směš na tutym wikiju skutkować a hač twoje akcije wšěm prawidłam wotpowěduja.',
	'crosswikiunblock-user' => 'Wužiwarske mjeno, IP-adresa abo ID blokowanja a cilowy wiki:',
	'crosswikiunblock-reason' => 'Přičina:',
	'crosswikiunblock-submit' => 'Tutoho wužiwarja wotblokować',
	'crosswikiunblock-success' => "Wužiwar '''$1''' bu wuspěšnje wotblokowany.

Wróćo k:
* [[Special:CrosswikiBlock|Formular blokowanjow]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Njebu wužiwarske mjeno zapodate',
	'crosswikiblock-local' => 'Lokalne blokowanja so přez tutón interfejs njepodpěruja. Wužij [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Datowa banka $1 njeeksistuje',
	'crosswikiblock-noname' => '"$1" płaćiwe wužiwarske mjeno njeje.',
	'crosswikiblock-nouser' => 'Wužiwar "$3" njebu namakany.',
	'crosswikiblock-noexpiry' => 'Njepłaćiwe spadnjenje: $1.',
	'crosswikiblock-noreason' => 'Žana přičina podata.',
	'crosswikiblock-notoken' => 'Njepłaćiwy wobdźełanski token.',
	'crosswikiblock-alreadyblocked' => 'Wužiwar $3 je hižo zablokowany.',
	'crosswikiblock-noblock' => 'Tutón wužiwar njeje zablokowany.',
	'crosswikiblock-success' => "Wužiwar '''$3''' wuspěšnje zablokowany.

Wróćo k:
* [[Special:CrosswikiBlock|Blokowanski formular]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokalne blokowanja so přez tutón interfejs njepodpěruja. Wužij [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Wužiwarjow na druhich wikijach blokować a dowolić',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'crosswikiblock-desc' => '[[Special:Crosswikiblock|Speciális lap]], mely segítségével szerkesztőket lehet blokkolni más wikiken',
	'crosswikiblock' => 'Szerkesztő blokkolása más wikin',
	'crosswikiblock-header' => 'Ezen a lapon tudsz szerkesztőt blokkolni más wikin.
Légyszíves ellenőrizd, hogy megteheted-e ezt a másik wikin, és megfelel-e minden vonatkozó irányelvnek.',
	'crosswikiblock-target' => 'IP-cím vagy szerkesztői név és cél wiki:',
	'crosswikiblock-expiry' => 'Lejárat:',
	'crosswikiblock-reason' => 'Indoklás:',
	'crosswikiblock-submit' => 'Szerkesztő blokkolása',
	'crosswikiblock-anononly' => 'Csak anonim felhasználók blokkolása',
	'crosswikiblock-nocreate' => 'Új regisztráció megakadályozása',
	'crosswikiblock-autoblock' => 'A szerkesztő utolsó IP-címének automatikus blokkolása, és minden további IP-címé amelyről szerkeszteni próbál',
	'crosswikiblock-noemail' => 'E-mail küldés tiltása a szerkesztőnél',
	'crosswikiunblock' => 'Felhasználó blokkjának feloldása másik wikin',
	'crosswikiunblock-header' => 'Ennek a lapnak a segítségével feloldhatod egy felhasználó blokkját másik wikin.
Kérlek ellenőrizd, hogy szabad-e ezt tenned azon a wikin, és a blokk feloldása összhangban van az összes vonatkozó irányelvvel.',
	'crosswikiunblock-user' => 'Felhasználónév, IP-cím vagy blokk-azonosító és cél wiki:',
	'crosswikiunblock-reason' => 'Indoklás:',
	'crosswikiunblock-submit' => 'Felhasználó blokkjának feloldása',
	'crosswikiunblock-success' => "'''$1''' felhasználó blokkja sikeresen feloldva.

Visszalépés ide:
* [[Special:CrosswikiBlock|Blokkolás űrlap]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nincs szerkesztői név megadva',
	'crosswikiblock-local' => 'A helyi blokkok nem támogatottak ezen a lapon. Használd a [[Special:BlockIP|{{int:blockip}}]] speciális lapot',
	'crosswikiblock-dbnotfound' => 'A(z) $1 adatbázis nem létezik',
	'crosswikiblock-noname' => 'A(z) „$1” nem érvényes felhasználónév.',
	'crosswikiblock-nouser' => '„$3” felhasználó nem található.',
	'crosswikiblock-noexpiry' => 'Érvénytelen lejárat: $1.',
	'crosswikiblock-noreason' => 'Nincs indoklás megadva.',
	'crosswikiblock-notoken' => 'Érvénytelen szerkesztési token.',
	'crosswikiblock-alreadyblocked' => '$3 már blokkolva van.',
	'crosswikiblock-noblock' => 'Ez a szerkesztő nincs blokkolva.',
	'crosswikiblock-success' => "'''$3''' felhasználó sikeresen blokkolva.

Visszalépés ide:
* [[Special:CrosswikiBlock|Blokkolás űrlap]]
* [[$4]]",
	'crosswikiunblock-local' => 'A helyi blokk-feloldások nem támogatottak ezen a felületen. Használd a [[Special:IPBlockList|{{int:ipblocklist}}]]-t',
	'right-crosswikiblock' => 'szerkesztők blokkolása és a blokkok feloldása más wikiken',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'crosswikiblock-desc' => 'Permitte blocar usatores in altere wikis con un [[Special:Crosswikiblock|pagina special]]',
	'crosswikiblock' => 'Blocar usator in altere wiki',
	'crosswikiblock-header' => 'Iste pagina permitte blocar un usator in un altere wiki.
Per favor verifica que tu ha le permission de ager in iste wiki e que tu actiones sia conforme a tote le politicas.',
	'crosswikiblock-target' => 'Adresse IP o nomine de usator e wiki de destination:',
	'crosswikiblock-expiry' => 'Expiration:',
	'crosswikiblock-reason' => 'Motivo:',
	'crosswikiblock-submit' => 'Blocar iste usator',
	'crosswikiblock-anononly' => 'Blocar solmente usatores anonyme',
	'crosswikiblock-nocreate' => 'Impedir creation de contos',
	'crosswikiblock-autoblock' => 'Blocar automaticamente le adresse IP usate le plus recentemente per iste usator, e omne IPs successive desde le quales ille/-a prova facer modificationes',
	'crosswikiblock-noemail' => 'Impedir que le usator invia e-mail',
	'crosswikiunblock' => 'Disblocar usator in altere wiki',
	'crosswikiunblock-header' => 'Iste pagina permitte disblocar un usator in un altere wiki.
Per favor verifica que tu ha le permission de ager in iste wiki e que tu actiones sia conforme a tote le politicas.',
	'crosswikiunblock-user' => 'Nomine de usator, adresse IP o ID del blocada e wiki de destination:',
	'crosswikiunblock-reason' => 'Motivo:',
	'crosswikiunblock-submit' => 'Disblocar iste usator',
	'crosswikiunblock-success' => "Le usator '''$1''' ha essite disblocate con successo.

Retornar a:
* [[Special:CrosswikiBlock|Formulario de blocada]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nulle nomine de usator esseva indicate',
	'crosswikiblock-local' => 'Le blocadas local non es supportate via iste interfacie. Usa [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Le base de datos $1 non existe',
	'crosswikiblock-noname' => '"$1" non es un nomine de usator valide.',
	'crosswikiblock-nouser' => 'Le usator "$3" non es trovate.',
	'crosswikiblock-noexpiry' => 'Expiration invalide: $1.',
	'crosswikiblock-noreason' => 'Nulle motivo specificate.',
	'crosswikiblock-notoken' => 'Indicio de modification invalide.',
	'crosswikiblock-alreadyblocked' => 'Le usator $3 es ja blocate.',
	'crosswikiblock-noblock' => 'Iste usator non es blocate.',
	'crosswikiblock-success' => "Le usator '''$3''' ha essite blocate con successo.

Retornar a:
* [[Special:CrosswikiBlock|Formulario de blocada]]
* [[$4]]",
	'crosswikiunblock-local' => 'Le disblocadas local non es supportate via iste interfacie. Usa [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blocar e disblocar usatores in altere wikis',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 * @author Rex
 */
$messages['id'] = array(
	'crosswikiblock-desc' => 'Memungkinkan untuk memblokir pengguna di wiki lainnya menggunakan [[Special:Crosswikiblock|halaman istimewa]]',
	'crosswikiblock' => 'Blokir pengguna di wiki lain',
	'crosswikiblock-header' => 'Halaman ini memungkinkan untuk memblokir pengguna di wiki lain. 
Silakan periksa jika Anda diperbolehkan untuk bertindak pada wiki ini dan tindakan Anda sesuai dengan semua kebijakan.',
	'crosswikiblock-target' => 'Alamat IP atau pengguna dan wiki tujuan:',
	'crosswikiblock-expiry' => 'Waktu berakhir:',
	'crosswikiblock-reason' => 'Alasan:',
	'crosswikiblock-submit' => 'Blokir pengguna ini',
	'crosswikiblock-anononly' => 'Hanya blokir pengguna anonim',
	'crosswikiblock-nocreate' => 'Cegah pembuatan akun',
	'crosswikiblock-autoblock' => 'Blokir alamat IP terakhir yang digunakan pengguna ini secara otomatis, dan semua alamat berikutnya yang mereka coba gunakan untuk menyunting.',
	'crosswikiblock-noemail' => 'Cegah pengguna mengirimkan surel',
	'crosswikiunblock' => 'Hilangkan blokir pengguna di wiki lain',
	'crosswikiunblock-header' => 'Halaman ini membolehkan untuk blokir pengguna di wiki lain.
Silakan periksa jika Anda diperbolehkan untuk bertindak di wiki ini dan aksi Anda sesuai dengan semua kebijakan.',
	'crosswikiunblock-user' => 'Nama pengguna, alamat IP atau blok ID dan wiki tujuan:',
	'crosswikiunblock-reason' => 'Alasan:',
	'crosswikiunblock-submit' => 'Hilangkan blokir pengguna ini',
	'crosswikiunblock-success' => "Pengguna '''$1''' berhasil di buka blokirnya.

Kembali ke:
* [[Special:CrosswikiBlock|formulir blokir]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nama pengguna tida diberikan',
	'crosswikiblock-local' => 'Blokir lokal tidak di dukung melalui antarmuka ini. Gunakan [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Basis data $1 tidak ada',
	'crosswikiblock-noname' => 'Nama pengguna "$1" tidak sah.',
	'crosswikiblock-nouser' => 'Pengguna "$3" tidak ditemukan.',
	'crosswikiblock-noexpiry' => 'Kedaluwarsa tidak sah: $1.',
	'crosswikiblock-noreason' => 'Tak ada penjelasan.',
	'crosswikiblock-notoken' => 'Token penyuntingan tidak sah.',
	'crosswikiblock-alreadyblocked' => 'Pengguna $3 telah diblokir.',
	'crosswikiblock-noblock' => 'Pengguna ini tidak diblok.',
	'crosswikiblock-success' => "Pengguna '''$3''' blokir berhasil.

Kembali ke:
* [[Special:CrosswikiBlock|Formulir blokir]]
* [[$4]]",
	'crosswikiunblock-local' => 'Buka blokir lokal tidak didukung melalui antarmuka ini. Gunakan [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blokir dan buka blokir pengguna di wiki lain',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'crosswikiblock-reason' => 'Mgbághapụtà:',
	'crosswikiunblock-reason' => 'Mgbághapụtà:',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'crosswikiblock-expiry' => 'Expiro:',
	'crosswikiblock-anononly' => 'Blokusez nur anonimala uzanti',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'crosswikiblock-reason' => 'Ástæða:',
	'crosswikiunblock-reason' => 'Ástæða:',
	'crosswikiblock-alreadyblocked' => 'Notandi „$3“ er nú þegar í banni.',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Nemo bis
 * @author Pietrodn
 */
$messages['it'] = array(
	'crosswikiblock-desc' => 'Permette di bloccare utenti su altre wiki usando una [[Special:Crosswikiblock|pagina speciale]]',
	'crosswikiblock' => "Blocca utente su un'altra wiki",
	'crosswikiblock-header' => "Questa pagina permette di bloccare un utente su un'altra wiki.
Per favore, controlla che tu sia autorizzato a farlo su questa wiki e che l'azione sia conforme a tutte le policy.",
	'crosswikiblock-target' => 'Indirizzo IP o nome utente e wiki di destinazione:',
	'crosswikiblock-expiry' => 'Scadenza del blocco:',
	'crosswikiblock-reason' => 'Motivo:',
	'crosswikiblock-submit' => "Blocca l'utente",
	'crosswikiblock-anononly' => 'Blocca solo utenti anonimi (gli utenti registrati che condividono lo stesso IP non vengono bloccati)',
	'crosswikiblock-nocreate' => 'Impedisci la creazione di altri account',
	'crosswikiblock-autoblock' => "Blocca automaticamente l'ultimo indirizzo IP usato dall'utente e i successivi con cui vengono  tentate modifiche",
	'crosswikiblock-noemail' => "Impedisci all'utente l'invio di e-mail",
	'crosswikiunblock' => "Sblocca utente su un'altra wiki",
	'crosswikiunblock-header' => "Questa pagina permette di sbloccare un utente su un'altra wiki.
Per favore, controlla che tu sia autorizzato a farlo su questa wiki e che l'azione sia conforme a tutte le policy.",
	'crosswikiunblock-user' => 'Nome utente, indirizzo IP o ID di blocco e wiki di destinazione',
	'crosswikiunblock-reason' => 'Motivo:',
	'crosswikiunblock-submit' => "Sblocca l'utente",
	'crosswikiunblock-success' => "L'utente '''$1''' è stato sbloccato con successo.

Torna a:
* [[Special:CrosswikiBlock|Modulo di blocco]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Non è stato inserito nessun nome utente',
	'crosswikiblock-local' => 'I blocchi locali non sono supportati da questa interfaccia. Usare [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Il database $1 non esiste',
	'crosswikiblock-noname' => '"$1" non è un nome utente valido.',
	'crosswikiblock-nouser' => 'L\'utente "$3" non è stato trovato.',
	'crosswikiblock-noexpiry' => 'Scadenza del blocco errata: $1.',
	'crosswikiblock-noreason' => 'Nessun motivo specificato.',
	'crosswikiblock-notoken' => 'Edit token non valido.',
	'crosswikiblock-alreadyblocked' => 'L\'utente "$3" è stato già bloccato.',
	'crosswikiblock-noblock' => 'Questo utente non è bloccato.',
	'crosswikiblock-success' => "L'utente '''$3''' è stato sbloccato con successo.

Torna a:
* [[Special:CrosswikiBlock|Modulo di blocco]]
* [[$4]]",
	'crosswikiunblock-local' => 'Gli sblocchi locali non sono supportati da questa interfaccia. Usare [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blocca e sblocca utenti su altri siti wiki',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author JtFuruhata
 * @author 青子守歌
 */
$messages['ja'] = array(
	'crosswikiblock-desc' => '他ウィキの利用者の[[Special:Crosswikiblock|{{int:specialpage}}]]を使用したブロックを可能にする',
	'crosswikiblock' => '他ウィキの利用者をブロック',
	'crosswikiblock-header' => 'このページでは他ウィキの利用者をブロックすることができます。
あなたのその行動は、影響を与えるウィキ全ての方針で適切かどうか、注意深く考えてください。',
	'crosswikiblock-target' => 'IPアドレスか利用者名、および対象となるウィキ:',
	'crosswikiblock-expiry' => '有効期限：',
	'crosswikiblock-reason' => '理由：',
	'crosswikiblock-submit' => 'この利用者をブロック',
	'crosswikiblock-anononly' => '匿名利用者のみブロック',
	'crosswikiblock-nocreate' => 'アカウント作成を防止',
	'crosswikiblock-autoblock' => 'この利用者が最後に使用したIPアドレスおよびブロック後に使用するIPアドレスを自動的にブロック',
	'crosswikiblock-noemail' => 'メール送信をブロック',
	'crosswikiunblock' => '他ウィキの利用者をブロック解除',
	'crosswikiunblock-header' => 'このページでは他ウィキの利用者をブロック解除することができます。
あなたのその行動は、影響を与えるウィキ全ての方針で適切かどうか、注意深く考えてください。',
	'crosswikiunblock-user' => '利用者名かIPアドレスまたはブロックID、および対象となるウィキ:',
	'crosswikiunblock-reason' => '理由：',
	'crosswikiunblock-submit' => 'この利用者のブロックを解除',
	'crosswikiunblock-success' => "利用者 '''$1''' のブロックを解除しました。

元のページへ戻る:
* [[Special:CrosswikiBlock|他ウィキの利用者をブロック]]
* [[$2]]",
	'crosswikiblock-nousername' => '利用者名が入力されていません',
	'crosswikiblock-local' => 'このウィキ自身における利用者ブロックを、このページでは行えません。[[Special:BlockIP|{{int:blockip}}]]を利用してください。',
	'crosswikiblock-dbnotfound' => 'データベース $1 が存在しません',
	'crosswikiblock-noname' => '"$1" は、不正な利用者名です。',
	'crosswikiblock-nouser' => '利用者 "$3" が見つかりません。',
	'crosswikiblock-noexpiry' => '不正な期限指定です: $1',
	'crosswikiblock-noreason' => '理由が記入されていません。',
	'crosswikiblock-notoken' => '編集トークンが不正です。',
	'crosswikiblock-alreadyblocked' => '利用者 $3 は既にブロックされています。',
	'crosswikiblock-noblock' => 'この利用者は、ブロックされていません。',
	'crosswikiblock-success' => "利用者 '''$3''' をブロックしました。

戻る:
* [[Special:CrosswikiBlock|ブロックフォーム]]
* [[$4]]",
	'crosswikiunblock-local' => 'このウィキ限定に限定した、利用者のブロック解除はこのページでは行えません。[[Special:IPBlockList|{{int:ipblocklist}}]]を利用してください。',
	'right-crosswikiblock' => '他のウィキの利用者をブロックおよびブロック解除する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'crosswikiblock' => 'Blokir panganggo ing wiki liya',
	'crosswikiblock-expiry' => 'Kadaluwarsa:',
	'crosswikiblock-reason' => 'Alesan:',
	'crosswikiblock-submit' => 'Blokir panganggo iki',
	'crosswikiblock-anononly' => 'Blokir para panganggo anonim waé',
	'crosswikiblock-nocreate' => 'Menggak panggawéyan rékening',
	'crosswikiblock-noemail' => 'Panganggo dipenggak ora olèh ngirim e-mail',
	'crosswikiunblock-reason' => 'Alesan:',
	'crosswikiunblock-submit' => 'Batalna blokade panganggo iki',
	'crosswikiblock-dbnotfound' => 'Basis data $1 ora ana',
	'crosswikiblock-noexpiry' => 'Kadaluwarsa ora absah: $1.',
	'crosswikiblock-noreason' => 'Ora ana alesan sing dispésifikasi.',
	'crosswikiblock-alreadyblocked' => 'Panganggo $3 wis diblokir.',
	'crosswikiblock-noblock' => 'Panganggo iki ora diblokir.',
	'crosswikiblock-success' => "Panganggo '''$3''' bisa sacara suksès diblokir.

Bali menyang:
* [[Special:CrosswikiBlock|Formulir pamblokiran]]
* [[$4]]",
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'crosswikiblock-reason' => 'მიზეზი:',
	'crosswikiunblock-reason' => 'მიზეზი:',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'crosswikiblock-desc' => 'អនុញ្ញាត​ឱ្យរាំងខ្ទប់​អ្នកប្រើប្រាស់​លើ​​វិគីផ្សេង​ដែលប្រើប្រាស់ [[Special:Crosswikiblock|ទំព័រពិសេស]]',
	'crosswikiblock' => 'រាំងខ្ទប់​អ្នកប្រើប្រាស់​លើ​វិគីផ្សេង',
	'crosswikiblock-target' => 'អាសយដ្ឋាន IP ឬ អត្តនាម និង វិគីគោលដៅ ៖',
	'crosswikiblock-expiry' => 'ផុតកំណត់ ៖',
	'crosswikiblock-reason' => 'មូលហេតុ៖',
	'crosswikiblock-submit' => 'រាំងខ្ទប់​អ្នកប្រើប្រាស់​នេះ',
	'crosswikiblock-anononly' => 'រាំងខ្ទប់​តែ​អ្នកប្រើប្រាស់​អនាមិក',
	'crosswikiblock-nocreate' => 'បង្ការ​ការបង្កើត​គណនី',
	'crosswikiblock-noemail' => 'បង្ការ​អ្នកប្រើប្រាស់​ពី​ការផ្ញើ​អ៊ីមែល',
	'crosswikiunblock' => 'លែងរាំងខ្ទប់​អ្នកប្រើប្រាស់​លើ​វិគី​ផ្សេង',
	'crosswikiunblock-header' => 'ទំព័រនេះអនុញ្ញាតឱ្យហាមឃាត់អ្នកប្រើប្រាស់នៅលើវិគីដ៏ទៃផ្សេងទៀត។

សូមត្រួតពិនិត្យមើលថាតើអ្នកត្រូវអនុញ្ញាតឱ្យធ្វើសកម្មភាពនៅលើវិគីនេះ និងសកម្មភាពរបស់អ្នកគោរពតាមរាល់គោលការណ៍។',
	'crosswikiunblock-user' => 'អត្តនាម, អាសយដ្ឋាន IP ឬ រាំងខ្ទប់ ID និង វិគី គោលដៅ ៖',
	'crosswikiunblock-reason' => 'មូលហេតុ៖',
	'crosswikiunblock-submit' => 'លែងរាំងខ្ទប់ អ្នកប្រើប្រាស់ នេះ',
	'crosswikiunblock-success' => "អ្នកប្រើប្រាស់ '''$1''' បានឈប់ហាមឃាត់ដោយជោគជ័យហើយ។


ត្រឡប់ទៅកាន់:
* [[Special:CrosswikiBlock|ទម្រង់បែបបទសម្រាប់ការហាមឃាត់]]
* [[$2]]",
	'crosswikiblock-nousername' => 'គ្មានអត្តនាមបានត្រូវបញ្ចូល',
	'crosswikiblock-dbnotfound' => 'មូលដ្ឋានទិន្នន័យ $1 មិនមាន',
	'crosswikiblock-noname' => 'អត្តនាម "$1" គ្មានសុពលភាព ។',
	'crosswikiblock-nouser' => 'រកមិនឃើញ អ្នកប្រើប្រាស់ "$3" ។',
	'crosswikiblock-noexpiry' => 'កាលបរិច្ចេទផុតកំណត់គ្មានប្រសិទ្ធភាព៖ $1 ។',
	'crosswikiblock-noreason' => 'គ្មានហេតុផល ត្រូវបានសំដៅ ។',
	'crosswikiblock-alreadyblocked' => 'អ្នកប្រើប្រាស់ $3 ត្រូវបាន រាំងខ្ទប់ ហើយ ។',
	'crosswikiblock-noblock' => 'អ្នកប្រើប្រាស់នេះ មិនត្រូវបាន​ រាំងខ្ទប់ ។',
	'crosswikiblock-success' => "អ្នកប្រើប្រាស់ '''$3''' បានហាមឃាត់ដោយជោគជ័យ។


ត្រឡប់ទៅកាន់:
* [[Special:CrosswikiBlock|ទម្រង់បែបបទសម្រាប់ការហាមឃាត់]]
* [[$4]]",
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'crosswikiblock-reason' => 'ಕಾರಣ:',
	'crosswikiunblock-reason' => 'ಕಾರಣ:',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'crosswikiblock' => '다른 위키의 사용자 차단',
	'crosswikiblock-expiry' => '기한:',
	'crosswikiblock-reason' => '이유:',
	'crosswikiblock-anononly' => '익명 사용자만 막기',
	'crosswikiblock-nocreate' => '계정 생성을 막기',
	'crosswikiblock-noemail' => '이메일을 보내지 못하도록 막기',
	'crosswikiunblock' => '다른 위키의 사용자 차단 해제',
	'crosswikiunblock-reason' => '이유:',
	'crosswikiblock-nousername' => '사용자 이름이 입력되지 않았습니다.',
	'crosswikiblock-dbnotfound' => '데이터베이스 $1가 존재하지 않습니다.',
	'crosswikiblock-alreadyblocked' => '사용자 $3은 이미 차단되었습니다.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'crosswikiblock-desc' => 'Määt et müjjelesch, Metmaacher op ander Wikis ze sperre övver en  [[Special:Crosswikiblock|Söndersigg]].',
	'crosswikiblock' => 'Ene Metmaacher en enem andere Wiki sperre',
	'crosswikiblock-header' => 'Hee di Söndersigg määt et müjjelesch, ene Metmaacher en enem ander Wiki ze sperre.
Bes esu joot un donn prööfe, ov De dat en dämm andere Wiki och darrefs,
un ov et met all dä Räjelle doh zosamme jeiht.',
	'crosswikiblock-target' => 'De IP Adreß odder dä Name fun däm Metmaacher un dat Wiki:',
	'crosswikiblock-expiry' => 'Leuf uß:',
	'crosswikiblock-reason' => 'Aanlass:',
	'crosswikiblock-submit' => 'IP-Adreß odder Metmaacher sperre',
	'crosswikiblock-anononly' => 'Nur de Namelose sperre',
	'crosswikiblock-nocreate' => 'Neu Metmaacher aanmelde verbeede',
	'crosswikiblock-autoblock' => 'Donn automattesch de letzte IP Adreß fun dämm Metmaacher un alle IP Adresse, vun wo dä Metmaacher Sigge ändere well.',
	'crosswikiblock-noemail' => 'Et <i lang="en">e-mail</i> Schecke verbeede',
	'crosswikiunblock' => 'Jif ene Metmaacher en enem ander Wiki widder frei',
	'crosswikiunblock-header' => 'Di Söndersigg hee määt et müjjelesch, ene jesperrte Metmaacher en enem ander Wiki widder freizejevve.
Bes secher, dat De dat en däm ander Wiki och donn darrefs, un dat dat doh och met alle Räjelle zosamme jeiht.',
	'crosswikiunblock-user' => 'Metmaacher name, IP Adreß, odder dä Sperr ier Kennzeiche, un dat Wiki:',
	'crosswikiunblock-reason' => 'Aanlass:',
	'crosswikiunblock-submit' => 'Metmaacher odder IP Adreß freijävve',
	'crosswikiunblock-success' => "Metmaacher '''$1''' frei jejovve.

Jangk retuur noh:
* [[Special:CrosswikiBlock|dämm Fommulaa zom Sperre]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Däm Metmaacher singe Name fählt',
	'crosswikiblock-local' => 'Sperre em eije Wiki künne mer hee nit beärbeide.
Doför jangk noh [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'De Datenbank $1 es nit do.',
	'crosswikiblock-noname' => '„$1“ es keine jöltije Metmaachername.',
	'crosswikiblock-nouser' => 'Dä Metmaacher „$3“ es nit ze fenge.',
	'crosswikiblock-noexpiry' => 'Dat es en onjöltijje Door: $1.',
	'crosswikiblock-noreason' => 'Keine Jrond enjejovve.',
	'crosswikiblock-notoken' => 'Onjöltesch Kennzeiche för et Ändere. Probeer et noch ens.',
	'crosswikiblock-alreadyblocked' => 'Dä Metmaacher $3 es ald jesperrt.',
	'crosswikiblock-noblock' => 'Dä Metmaacher es nit jesperrt.',
	'crosswikiblock-success' => "Dä Metmaacher '''„$3“''' es jetz jesperrt.

Jangk retuur noh:
* [[Special:CrosswikiBlock|däm Fommulaa för et Sperre]]
* [[$4]]",
	'crosswikiunblock-local' => 'Em eije Wiki künne mer hee nix frei jävve.
Doför jangk noh [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => 'Metmaacher op ander Wikis sperre un widder frei jävve',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'crosswikiblock-desc' => "Erlaabt d'Späre vu Benotzer op anere Wikien iwwer eng [[Special:Crosswikiblock|Spezialsäit]]",
	'crosswikiblock' => 'E Benotzer op enger anerer Wiki spären',
	'crosswikiblock-header' => 'Dës Spezialsäit erlaabt et e Benotzer op enger anerer Wiki ze spären.

Vergewëssert Iech w.e.g. ob dir déi néideg Rechter op där anerer Wiki dofir hutt an ob Är Aktioun de Regelen vun där Wiki entsprécht.',
	'crosswikiblock-target' => 'IP-Adress oder Benotzernumm an Zil-Wiki:',
	'crosswikiblock-expiry' => 'Dauer vun der Spär:',
	'crosswikiblock-reason' => 'Grond:',
	'crosswikiblock-submit' => 'Dëse Benotzer spären',
	'crosswikiblock-anononly' => 'Nëmmen anonym Benotzer spären',
	'crosswikiblock-nocreate' => 'Opmaache vun engem Benotzerkont verhënneren',
	'crosswikiblock-autoblock' => 'Automatesch déi lescht IP-Adress spären déi vun dësem Benotzer benotzt gouf, an all IP-Adressen vun denen dëse Benotzer versicht Ännerunge virzehuelen',
	'crosswikiblock-noemail' => 'Verhënneren datt de Benotzer E-Maile verschéckt',
	'crosswikiunblock' => "D'Spär vum Benotzer op enger anerer Wiki ophiewen",
	'crosswikiunblock-header' => "Dës Säit erlaabt et d'spär vu Benotzer op enger anerer Wiki opzehiewen.
Kukct w.e.g. no ob Dir berechtegt sidd fir dat op där Wiki ze maachen an ob är Aktiounen mat alle Richtlinnen iwwereneestëmmen.",
	'crosswikiunblock-user' => 'Benotzernumm, IP-Adress oder Nummer vun der Spär an Zilwiki:',
	'crosswikiunblock-reason' => 'Grond:',
	'crosswikiunblock-submit' => 'Spär fir dëse Benotzer ophiewen',
	'crosswikiunblock-success' => "D'spär vum Benotzer '''$1''' gouf opgehuewen.

Zréck op:
* [[Special:CrosswikiBlock|Spärformulaire]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Dir hutt kee Benotzernumm aginn',
	'crosswikiblock-local' => 'Op dëser Säit kënne keng lokal Spären ageriicht ginn. Benotzt w.e.g. [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => "D'Datebank $1 gëtt et net.",
	'crosswikiblock-noname' => '"$1" ass kee gültege Benotzernumm.',
	'crosswikiblock-nouser' => 'De Benotzer "$3" gouf net fonnt.',
	'crosswikiblock-noexpiry' => 'Ongëlteg Dauer vun der Spär: $1',
	'crosswikiblock-noreason' => 'Kee Grond uginn.',
	'crosswikiblock-notoken' => 'Ännerungs-Jeton net valabel',
	'crosswikiblock-alreadyblocked' => 'De Benotzer $3 ass scho gespaart.',
	'crosswikiblock-noblock' => 'Dëse Benotzer ass net gespaart.',
	'crosswikiblock-success' => "De Benotzer '''$3''' ass gespaart.

Zréck op:
* [[Special:CrosswikiBlock|Spär-Formulaire]]
* [[$4]]",
	'crosswikiunblock-local' => 'Op dëser Säit kënne lokal Spären net opgehuewe ginn. Benotzt w.e.g. [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => "Benotzer op anere Wikie spären resp. d'Spär ophiewen",
);

/** Lithuanian (Lietuvių)
 * @author Homo
 */
$messages['lt'] = array(
	'crosswikiblock-reason' => 'Priežastis:',
	'crosswikiblock-submit' => 'Blokuoti šį naudotoją',
	'crosswikiblock-anononly' => 'Blokuoti tik anoniminius naudotojus',
	'crosswikiblock-autoblock' => 'Automatiškai blokuoti paskutinį naudotojo naudotą IP adresą, ir visus kitus adresus, iš kurių mėgins redaguoti',
	'crosswikiunblock-reason' => 'Priežastis:',
	'crosswikiunblock-submit' => 'Atblokuoti šį naudotoją',
	'crosswikiunblock-success' => "Naudotojas '''$1''' sėkmingai atblokuotas.

Grįžti į:
* [[Special:CrosswikiBlock|Blokavimo forma]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nenurodytas joks naudotojo vardas',
	'crosswikiblock-nouser' => 'Naudotojas "$3" nerastas.',
	'crosswikiblock-noreason' => 'Nenurodyta priežastis.',
	'crosswikiblock-success' => "Naudotojas '''$3''' sėkmingai užblokuotas.

Grįžti į:
* [[Special:CrosswikiBlock|Blokavimo forma]]
* [[$4]]",
);

/** Moksha (Мокшень)
 * @author Khazar II
 */
$messages['mdf'] = array(
	'crosswikiblock-alreadyblocked' => '"$3" сёлкфоль ни',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'crosswikiblock-reason' => 'Амал:',
	'crosswikiunblock-reason' => 'Амал:',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'crosswikiblock-desc' => 'Овозможува блокирање на корисници на други викија со помош на [[Special:Crosswikiblock|специјална страница]]',
	'crosswikiblock' => 'Блокирај корисник на друго вики',
	'crosswikiblock-header' => 'Оваа страница овозможува блокирање на корисници на други викија.
Проверете дали ви се дозволени такви постапки на ова вики, и дали вашите постапки се во согласност со сите правила.',
	'crosswikiblock-target' => 'IP-адреса или корисничко име и целно вики:',
	'crosswikiblock-expiry' => 'Истекува:',
	'crosswikiblock-reason' => 'Причина:',
	'crosswikiblock-submit' => 'Блокирај го корисников',
	'crosswikiblock-anononly' => 'Блокирај само анонимни корисници',
	'crosswikiblock-nocreate' => 'Оневозможи создавање сметки',
	'crosswikiblock-autoblock' => 'Автоматски блокирај ја последната IP-адреса употребена од овој корисник, и сите подоцнежни IP-адреси од кои ќе се обиде да уредува',
	'crosswikiblock-noemail' => 'Оневозможи му на корисникот да испраќа е-пошта',
	'crosswikiunblock' => 'Одблокирај корисник на друго вики',
	'crosswikiunblock-header' => 'Оваа страница овозможува одблокирање на корисници на други викија.
Проверете дали ви се дозволени такви постапки на ова вики, и дали вашите постапки се во согласност со сите правила.',
	'crosswikiunblock-user' => 'Корисничко име, IP-адреса или ид. бр. на блокот и целното вики:',
	'crosswikiunblock-reason' => 'Причина:',
	'crosswikiunblock-submit' => 'Одблокирај го корисников',
	'crosswikiunblock-success' => "Корисникот '''$1''' е успешно одблокиран.

Назад кон:
* [[Special:CrosswikiBlock|Образецот за блокирање]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Нема наведено корисничко име',
	'crosswikiblock-local' => 'Локалните блокирања не се поддржани преку овој посредник. Користете [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Базата на податоци $1 не постои',
	'crosswikiblock-noname' => '„$1“ не е важечко корисничко име.',
	'crosswikiblock-nouser' => 'Корисникот „$3“ не е пронајден.',
	'crosswikiblock-noexpiry' => 'Неважечки рок на истекување: $1.',
	'crosswikiblock-noreason' => 'Нема наведено причина.',
	'crosswikiblock-notoken' => 'Неважечки жетон за уредувањето.',
	'crosswikiblock-alreadyblocked' => 'Корисникот $3 е веќе блокиран.',
	'crosswikiblock-noblock' => 'Овој корисник не е блокиран.',
	'crosswikiblock-success' => "Корисникот '''$3''' е успешно блокиран.

Назад кон:
* [[Special:CrosswikiBlock|Образецот за блокирање]]
* [[$4]]",
	'crosswikiunblock-local' => 'Локалните одблокирања не се поддржани преку овој посредник. Користете [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Блокирање и одблокирање на корисници на други викија',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'crosswikiblock-desc' => 'ഒരു [[Special:Crosswikiblock|പ്രത്യേക താൾ]] ഉപയോഗിച്ച് ഉപയോക്താക്കളെ മറ്റ് വിക്കികളിൽ തടയാൻ സാധിക്കുന്നു.',
	'crosswikiblock' => 'ഉപയോക്താവിനെ മറ്റ് വിക്കികളിൽ തടയുക',
	'crosswikiblock-header' => 'ഈ താൾ മറ്റു വിക്കികളിൽ ഉപയോക്താക്കളെ തടയാൻ സഹായിക്കുന്നു.
പ്രസ്തുത വിക്കിയിൽ പ്രവർത്തിക്കുവാൻ താങ്കൾക്ക് അനുമതിയുണ്ട് എന്നും, താങ്കളുടെ പ്രവൃത്തി വിക്കിയുടെ നയങ്ങൾക്ക് അനുസരിച്ചാണെന്നും ദയവായി ഉറപ്പാക്കുക.',
	'crosswikiblock-target' => 'ഐ.പി. വിലാസം അല്ലെങ്കിൽ ഉപയോക്തൃനാമവും ലക്ഷ്യവിക്കിയും:',
	'crosswikiblock-expiry' => 'കാലാവധി:',
	'crosswikiblock-reason' => 'കാരണം:',
	'crosswikiblock-submit' => 'ഈ ഉപയോക്താവിനെ തടയുക',
	'crosswikiblock-anononly' => 'അജ്ഞാത ഉപയോക്താക്കളെ മാത്രം തടയുക',
	'crosswikiblock-nocreate' => 'അംഗത്വം സൃഷ്ടിക്കുന്നത് തടയുക',
	'crosswikiblock-autoblock' => 'ഈ ഉപയോക്താവ് അവസാനം ഉപയോഗിച്ച ഐ.പി.യും തുടർന്ന് ഉപയോഗിക്കാൻ സാദ്ധ്യതയുള്ള ഐ.പി.കളും യാന്ത്രികമായി തടയുക',
	'crosswikiblock-noemail' => 'ഇമെയിൽ അയക്കുന്നതിൽ നിന്നു ഉപയോക്താവിനെ തടയുക',
	'crosswikiunblock' => 'ഉപയോക്താവിനെ മറ്റൊരു വിക്കിയിൽ സ്വതന്ത്രമാക്കുക',
	'crosswikiunblock-header' => 'ഈ താൾ മറ്റു വിക്കികളിൽ ഉപയോക്താക്കളെ സ്വതന്ത്രമാക്കാൻ സഹായിക്കുന്നു.
പ്രസ്തുത വിക്കിയിൽ പ്രവർത്തിക്കുവാൻ താങ്കൾക്ക് അനുമതിയുണ്ട് എന്നും, താങ്കളുടെ പ്രവൃത്തി വിക്കിയുടെ നയങ്ങൾക്ക് അനുസരിച്ചാണെന്നും ദയവായി ഉറപ്പാക്കുക.',
	'crosswikiunblock-user' => 'ഉപയോക്തൃനാമം, ഐ.പി. വിലാസം അല്ലെങ്കിൽ തടയൽ ഐ.ഡി. ഇവയിലൊന്നും ലക്ഷ്യ വിക്കിയും:',
	'crosswikiunblock-reason' => 'കാരണം:',
	'crosswikiunblock-submit' => 'ഈ ഉപയോക്താവിന്റെ തടയൽ നീക്കുക',
	'crosswikiunblock-success' => "'''$1''' എന്ന ഉപയോക്താവിനെ വിജയകരമായി സ്വതന്ത്രമാക്കിയിരിക്കുന്നു.

താഴെ കൊടുത്തിരിക്കുന്ന താളുകളിലൊന്നിലേക്കു തിരിച്ചു പോവുക:
* [[Special:CrosswikiBlock|തടയൽ ഫോം]]
* [[$2]]",
	'crosswikiblock-nousername' => 'ഉപയോക്തൃനാമം ചേർത്തില്ല',
	'crosswikiblock-local' => 'ഈ സമ്പർക്കമുഖം വഴി പ്രാദേശിക തടയൽ സാധിക്കില്ല. [[Special:BlockIP|{{int:blockip}}]] ഉപയോഗിക്കുക.',
	'crosswikiblock-dbnotfound' => '$1 എന്ന ഡാറ്റബേസ് നിലവിലില്ല',
	'crosswikiblock-noname' => '"$1" എന്നതു സാധുവായ ഉപയോക്തൃനാമമല്ല.',
	'crosswikiblock-nouser' => '"$3" എന്ന ഉപയോക്താവിനെ കണ്ടില്ല.',
	'crosswikiblock-noexpiry' => 'അസാധുവായ കാലാവധി: $1.',
	'crosswikiblock-noreason' => 'കാരണമൊന്നും സൂചിപ്പിച്ചിട്ടില്ല.',
	'crosswikiblock-notoken' => 'അസാധുവായ തിരുത്തൽ ചീട്ട്.',
	'crosswikiblock-alreadyblocked' => '$3 എന്ന ഉപയോക്താവ് ഇതിനകം തന്നെ തടയപ്പെട്ടിരിക്കുന്നു.',
	'crosswikiblock-noblock' => 'ഈ ഉപയോക്താവിനെ തടഞ്ഞിട്ടില്ല.',
	'crosswikiblock-success' => "'''$3''' എന്ന ഉപയോക്താവിനെ വിജയകരമായി തടഞ്ഞിരിക്കുന്നു

താഴെ കൊടുത്തിരിക്കുന്ന താളുകളിലൊന്നിലേക്കു തിരിച്ചു പോവുക:
* [[Special:CrosswikiBlock|തടയൽ ഫോം]]
* [[$4]]",
	'crosswikiunblock-local' => 'ഈ സമ്പർക്കമുഖം വഴി പ്രാദേശിക തടയൽ നീക്കാൻ സാധിക്കില്ല. [[Special:IPBlockList|{{int:ipblocklist}}]] ഉപയോഗിക്കുക',
	'right-crosswikiblock' => 'മറ്റ് വിക്കികളെ തടയുകയും തടയൽ മാറ്റുകയും ചെയ്യുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'crosswikiblock-reason' => 'Шалтгаан:',
	'crosswikiunblock-reason' => 'Шалтгаан:',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 */
$messages['mr'] = array(
	'crosswikiblock-desc' => 'इतर विकिंवर [[Special:Crosswikiblock|विशेष पान]] वापरून सदस्य ब्लॉक करायची परवानगी देते',
	'crosswikiblock' => 'इतर विकिवर सदस्याला ब्लॉक करा',
	'crosswikiblock-header' => 'हे पान इतर विकिवर सदस्याला ब्लॉक करायची परवानगी देते.
कृपया ही क्रिया करण्याची तुम्हाला परवानगी आहे तसेच तुम्ही करीत असलेली क्रिया नीतीला धरुन आहे याची खात्री करा.',
	'crosswikiblock-target' => 'आयपी अंकपत्ता किंवा सदस्यनाव तसेच कुठल्या विकिवर करायचे तो विकि:',
	'crosswikiblock-expiry' => 'रद्दीकरण:',
	'crosswikiblock-reason' => 'कारण:',
	'crosswikiblock-submit' => 'या सदस्याला ब्लॉक करा',
	'crosswikiblock-anononly' => 'फक्त अनामिक सदस्यांना ब्लॉक करा',
	'crosswikiblock-nocreate' => 'खाते उघडणी बंद करा',
	'crosswikiblock-autoblock' => 'या सदस्याचा आपोआप शेवटचा आयपी अंकपत्ता ब्लॉक करा, तसेच यानंतरच्या कुठल्याही आयपी वरुन संपादने करण्याचा प्रयत्न केल्यास ते अंकपत्ते सुद्धा ब्लॉक करा',
	'crosswikiblock-noemail' => 'सदस्याला इमेल पाठविण्यापासून रोखा',
	'crosswikiunblock' => 'इतर विकिंवर सदस्याचा ब्लॉक काढा',
	'crosswikiunblock-header' => 'हे पान इतर विकिंवर सदस्याचा ब्लॉक काढण्यासाठी वापरण्यात येते.
कृपया या विकिवर ही क्रिया करण्याचे अधिकार तुम्हाला आहेत तसेच तुम्ही करीत असलेली क्रिया नीतीला धरुन आहे याची खात्री करा.',
	'crosswikiunblock-user' => 'सदस्यनाव, आयपी अंकपत्ता किंवा ब्लॉक क्रमांक तसेच कुठल्या विकिवर ब्लॉक काढायचा आहे:',
	'crosswikiunblock-reason' => 'कारण:',
	'crosswikiunblock-submit' => 'या सदस्याचा ब्लॉक काढा',
	'crosswikiunblock-success' => "'''$1''' चा ब्लॉक यशस्वीरित्या काढलेला आहे.

परत जा:
* [[Special:CrosswikiBlock|ब्लॉक अर्ज]]
* [[$2]]",
	'crosswikiblock-nousername' => 'सदस्यनाव दिलेले नाही',
	'crosswikiblock-local' => 'स्थानिक ब्लॉक या ठिकाणी बदलता येत नाहीत. [[Special:BlockIP|{{int:blockip}}]] चा वापर करा',
	'crosswikiblock-dbnotfound' => 'डाटाबेस $1 उपलब्ध नाही',
	'crosswikiblock-noname' => '"$1" हे योग्य सदस्यनाव नाही.',
	'crosswikiblock-nouser' => '"$3" नावाचा सदस्य सापडला नाही.',
	'crosswikiblock-noexpiry' => 'चुकीचे रद्दीकरण: $1.',
	'crosswikiblock-noreason' => 'कारण दिलेले नाही',
	'crosswikiblock-notoken' => 'चुकीची संपादन चावी.',
	'crosswikiblock-alreadyblocked' => 'सदस्य $3 ला अगोदरच ब्लॉक केलेले आहे.',
	'crosswikiblock-noblock' => 'ह्या सदस्याला ब्लॉक केलेले नाही.',
	'crosswikiblock-success' => "सदस्य '''$3''' ला ब्लॉक केलेले आहे.

परत जा:
* [[Special:CrosswikiBlock|ब्लॉक अर्ज]]
* [[$4]]",
	'crosswikiunblock-local' => 'स्थानिक अनब्लॉक इथे बदलता येत नाहीत. [[Special:IPBlockList|{{int:ipblocklist}}]] चा उपयोग करा',
	'right-crosswikiblock' => 'इतर विकींवरील सदस्यांना प्रतिबंधित व अप्रतिबंधित करा',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 */
$messages['ms'] = array(
	'crosswikiblock-expiry' => 'Tamat:',
	'crosswikiblock-reason' => 'Sebab:',
	'crosswikiunblock-reason' => 'Sebab:',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'crosswikiblock-anononly' => 'Imblokka biss l-utenti anonimi',
	'crosswikiblock-alreadyblocked' => 'L-utent "$3" diġà bblokkjat',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'crosswikiblock-expiry' => 'Таштомома шказо:',
	'crosswikiblock-reason' => 'Тувталось:',
	'crosswikiunblock-reason' => 'Тувталось:',
	'crosswikiblock-alreadyblocked' => 'Теиця "$3" уш саймас саезь.',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'crosswikiblock-expiry' => 'Motlamia:',
	'crosswikiblock-reason' => 'Īxtlamatiliztli:',
	'crosswikiunblock-reason' => 'Īxtlamatiliztli:',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'crosswikiblock-desc' => 'Gjør det mulig å blokkere brukere på andre wikier ved hjelp av en [[Special:Crosswikiblock|spesialside]]',
	'crosswikiblock' => 'Blokker brukere på andre wikier',
	'crosswikiblock-header' => 'Denne siden gjør at man kan blokkere brukere på andre wikier. Sjekk om du har tillatelse til å gjøre det på denne wikien, og at du følger alle retningslinjene.',
	'crosswikiblock-target' => 'IP-adresse eller brukernavn og målwiki:',
	'crosswikiblock-expiry' => 'Varighet:',
	'crosswikiblock-reason' => 'Årsak:',
	'crosswikiblock-submit' => 'Blokker denne brukeren',
	'crosswikiblock-anononly' => 'Blokker kun anonyme brukere',
	'crosswikiblock-nocreate' => 'Hindre kontoopprettelse',
	'crosswikiblock-autoblock' => 'Blokker forrige IP-adresse brukt av denne brukeren automatisk, samt alle IP-adresser brukeren forsøker å redigere med i framtiden',
	'crosswikiblock-noemail' => 'Forhindre brukeren fra å sende e-post',
	'crosswikiunblock' => 'Avblokker brukeren på andre wikier',
	'crosswikiunblock-header' => 'Denne siden lar deg avblokkere brukere på andre wikier. Sjekk om du har lov til å gjøre dette på den lokale wikien i henhold til deres retningslinjer.',
	'crosswikiunblock-user' => 'Brukernavn, IP-adresse eller blokkerings-ID og målwiki:',
	'crosswikiunblock-reason' => 'Årsak:',
	'crosswikiunblock-submit' => 'Avblokker brukeren',
	'crosswikiunblock-success' => "Brukeren '''$1''' ble avblokkert.

Tilbake til:
* [[Special:CrosswikiBlock|Blokkeringsskjema]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Ingen brukernavn ble skrevet inn',
	'crosswikiblock-local' => 'Lokale blokkeringer støttes ikke av dette grensesnittet. Bruk [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Databasen $1 finnes ikke',
	'crosswikiblock-noname' => '«$1» er ikke et gyldig brukernavn.',
	'crosswikiblock-nouser' => 'Brukeren «$3» ble ikke funnet.',
	'crosswikiblock-noexpiry' => 'Ugyldig utløpstid: $1.',
	'crosswikiblock-noreason' => 'Ingen begrunnelse gitt.',
	'crosswikiblock-notoken' => 'Ugyldig redigeringstegn.',
	'crosswikiblock-alreadyblocked' => '«$3» er allerede blokkert.',
	'crosswikiblock-noblock' => 'Denne brukeren er ikke blokkert.',
	'crosswikiblock-success' => "'''$3''' er blokkert.

Tilbake til:
* [[Special:CrosswikiBlock|Blokkeringsskjemaet]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokale blokkeringer støttes ikke via dette grensesnittet. Bruk [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => 'Blokker og avblokker brukere på andre wikier',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'crosswikiblock-reason' => 'Grund:',
	'crosswikiblock-submit' => 'Dissen Bruker sperren',
	'crosswikiunblock-reason' => 'Grund:',
	'crosswikiblock-nousername' => 'Is keen Brukernaam ingeven worrn',
	'crosswikiblock-dbnotfound' => 'Datenbank $1 gifft dat nich',
	'crosswikiblock-nouser' => 'Bruker „$3“ nich funnen.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'crosswikiblock-desc' => 'Laat toe om gebruikers op andere wikis te blokkeren via een [[Special:Crosswikiblock|speciale pagina]]',
	'crosswikiblock' => 'Gebruiker blokkeren op een andere wiki',
	'crosswikiblock-header' => 'Deze pagina laat toe om gebruikers te blokkeren op een andere wiki.
Gelieve te controleren of u de juiste rechten hebt op deze wiki en of uw acties het beleid volgt.',
	'crosswikiblock-target' => 'IP-adres of gebruikersnaam en bestemmingswiki:',
	'crosswikiblock-expiry' => 'Vervalt:',
	'crosswikiblock-reason' => 'Reden:',
	'crosswikiblock-submit' => 'Deze gebruiker blokkeren',
	'crosswikiblock-anononly' => 'Alleen anonieme gebruikers blokkeren',
	'crosswikiblock-nocreate' => 'Gebruiker aanmaken voorkomen',
	'crosswikiblock-autoblock' => "Automatisch het laatste IP-adres gebruikt door deze gebruiker blokkeren, en elke volgende IP's waarmee ze proberen te bewerken",
	'crosswikiblock-noemail' => 'Het verzenden van e-mails door deze gebruiker voorkomen',
	'crosswikiunblock' => 'Gebruiker op een andere wiki deblokkeren',
	'crosswikiunblock-header' => 'Via deze pagina kunt u een gebruiker op een andere wiki deblokkeren.
Controleer of u dit op die wiki mag doen en of u in overeenstemming met het beleid handelt.',
	'crosswikiunblock-user' => 'Gebruiker, IP-adres of blokkadenummer en bestemmingswiki:',
	'crosswikiunblock-reason' => 'Reden:',
	'crosswikiunblock-submit' => 'Gebruiker deblokkeren',
	'crosswikiunblock-success' => "Gebruiker '''$1''' is gedeblokkeerd.

Ga terug naar:
* [[Special:CrosswikiBlock|Blokkadeformulier]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Er werd geen gebruikersnaam opgegeven',
	'crosswikiblock-local' => 'Plaatselijke blokkades worden niet ondersteund door dit formulier. Gebruik daarvoor [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'Database $1 bestaat niet',
	'crosswikiblock-noname' => '"$1" is geen geldige gebruikersnaam.',
	'crosswikiblock-nouser' => 'Gebruiker "$3" is niet gevonden.',
	'crosswikiblock-noexpiry' => 'Ongeldige duur: $1.',
	'crosswikiblock-noreason' => 'Geen reden opgegeven.',
	'crosswikiblock-notoken' => 'Onjuist bewerkingstoken.',
	'crosswikiblock-alreadyblocked' => 'Gebruiker $3 is al geblokkeerd.',
	'crosswikiblock-noblock' => 'Deze gebruiker is niet geblokkeerd',
	'crosswikiblock-success' => "Gebruiker '''$3''' is geblokkeerd.

Teruggaan naar:
* [[Special:CrosswikiBlock|Blokkeerformulier]]
* [[$4]]",
	'crosswikiunblock-local' => 'Plaatselijke deblokkades worden niet ondersteund door dit formulier. Gebruik daarvoor [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => "Blokkeren en deblokkeren van van de gebruikers op andere wiki's",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'crosswikiblock-desc' => 'Gjer det mogleg å blokkera brukarar på andre wikiar ved å nytta ei [[Special:Crosswikiblock|spesialsida]]',
	'crosswikiblock' => 'Blokker brukar på annan wiki',
	'crosswikiblock-header' => 'Denne sida gjer at ein kan blokkera brukarar på andre wikiar. 
Sjekk at du har løyve til gjera det på denne wikien, og at du følgjer alle retningslinene.',
	'crosswikiblock-target' => 'IP-adressa eller brukarnamn og målwiki:',
	'crosswikiblock-expiry' => 'Opphøyrstid:',
	'crosswikiblock-reason' => 'Årsak:',
	'crosswikiblock-submit' => 'Blokker denne brukaren',
	'crosswikiblock-anononly' => 'Blokker berre anonyme brukarar',
	'crosswikiblock-nocreate' => 'Hindre kontooppretting',
	'crosswikiblock-autoblock' => 'Blokker den førre IP-adressa som vart brukt av denne brukaren automatisk, og alle andre IP-adresser brukaren prøver å endre sider med i framtida',
	'crosswikiblock-noemail' => 'Hindre sending av e-post til andre brukarar',
	'crosswikiunblock' => 'Avblokker brukaren på andre wikiar',
	'crosswikiunblock-header' => 'Denne sida lèt deg avblokkera brukarar på andre wikiar.
Sjekk at du har løyve til gjera det på denne wikien, og at du følgjer alle retningslinene.',
	'crosswikiunblock-user' => 'Brukarnamn, IP-adressa eller blokkerings-ID og målwiki:',
	'crosswikiunblock-reason' => 'Årsak:',
	'crosswikiunblock-submit' => 'Avblokker brukaren',
	'crosswikiunblock-success' => "Brukaren '''$1''' vart avblokkert.

Attende til:
* [[Special:CrosswikiBlock|Blokkeringsskjema]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Ikkje noko brukarnamn vart oppgjeve',
	'crosswikiblock-local' => 'Lokale blokkeringar er ikkje støtta av dette grensesnittet. Nytt [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Databasen $1 finst ikkje',
	'crosswikiblock-noname' => '«$1» er ikkje eit gyldig brukarnamn.',
	'crosswikiblock-nouser' => 'Brukaren «$3» vart ikkje funnen.',
	'crosswikiblock-noexpiry' => 'Ugydlig opphøyrstid: $1.',
	'crosswikiblock-noreason' => 'Ingen årsak vart oppgjeve.',
	'crosswikiblock-notoken' => 'Ugyldig redigeringsteikn.',
	'crosswikiblock-alreadyblocked' => '«$3» er allereie blokkert.',
	'crosswikiblock-noblock' => 'Denne brukaren er ikkje blokkert.',
	'crosswikiblock-success' => "'''$3''' er blokkert.

Attende til:
* [[Special:CrosswikiBlock|Blokkeringsskjemaet]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokale avblokkeringar er ikkje støtta av dette grensesnittet. Nytt [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blokker og avblokker brukarar på andre wikiar',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'crosswikiblock-reason' => 'Resone:',
	'crosswikiunblock-reason' => 'Resone:',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'crosswikiblock-desc' => "Permet de blocar d'utilizaires sus d'autres wikis en utilizant [[Special:Crosswikiblock|una pagina especiala]]",
	'crosswikiblock' => 'Blocar un utilizaire sus un autre wiki',
	'crosswikiblock-header' => 'Aquesta pagina permet de blocar un utilizaire sus un autre wiki.

Verificatz se sètz abilitat per agir sus aqueste wiki e que vòstras accions respèctan totas las règlas.',
	'crosswikiblock-target' => "Adreça IP o nom d'utilizaire e wiki de destinacion :",
	'crosswikiblock-expiry' => 'Expiracion :',
	'crosswikiblock-reason' => 'Motiu :',
	'crosswikiblock-submit' => 'Blocar aqueste utilizaire',
	'crosswikiblock-anononly' => 'Blocar unicament los utilizaires anonims',
	'crosswikiblock-nocreate' => 'Interdire la creacion de compte',
	'crosswikiblock-autoblock' => "Bloca automaticament la darrièra adreça IP utilizada per aqueste utilizaire, e totas las IP subsequentas que ensajan d'editar",
	'crosswikiblock-noemail' => "Interdire a l'utilizaire de mandar un corrièr electronic",
	'crosswikiunblock' => "Deblocar en escritura un utilizaire d'un autre wiki",
	'crosswikiunblock-header' => "Aquesta pagina permet de deblocar en escritura un utilizaire d'un autre wiki.
Asseguratz-vos qu'avètz los dreches e respectatz las règlas en vigor sus aqueste wiki.",
	'crosswikiunblock-user' => "Nom d'utilizaire, adreça IP o l'id de blocatge e lo wiki ciblat :",
	'crosswikiunblock-reason' => 'Motiu :',
	'crosswikiunblock-submit' => 'Deblocar en escritura aqueste utilizaire',
	'crosswikiunblock-success' => "L'utilizaire '''$1''' es estat desblocat en escritura amb succès.

Tornar a :
* [[Special:CrosswikiBlock|Formulari de blocatge]]
* [[$2]]",
	'crosswikiblock-nousername' => "Cap de nom d'utilizaire es pas estat indicat",
	'crosswikiblock-local' => 'Los blocatges locals son pas suportats a travèrs aquesta interfàcia. Utilizatz [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'La banca de donadas « $1 » existís pas',
	'crosswikiblock-noname' => '« $1 » es pas un nom d’utilizaire valid.',
	'crosswikiblock-nouser' => 'L’utilizaire « $3 » es introbable.',
	'crosswikiblock-noexpiry' => 'Data o durada d’expiracion incorrècta : $1.',
	'crosswikiblock-noreason' => 'Cap de motiu indicat.',
	'crosswikiblock-notoken' => 'Geton d’edicion invalida.',
	'crosswikiblock-alreadyblocked' => 'L’utilizaire « $3 » ja es blocat.',
	'crosswikiblock-noblock' => 'Aqueste utilizaire es pas blocat en escritura.',
	'crosswikiblock-success' => "L’utilizaire '''$3''' es estat blocat amb succès.

Tornar cap a :
* [[Special:CrosswikiBlock|Lo formulari de blocatge]] ;
* [[$4]].",
	'crosswikiunblock-local' => 'Los blocatges en escritura locals son pas suportats via aquesta interfàcia. Utilizatz [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => "Blocar e desblocar d'utilizaires sus d'autres wikis",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 */
$messages['or'] = array(
	'crosswikiblock-reason' => 'କାରଣ:',
	'crosswikiunblock-reason' => 'କାରଣ:',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'crosswikiblock-reason' => 'Аххос:',
	'crosswikiunblock-reason' => 'Аххос:',
	'crosswikiblock-dbnotfound' => 'Бæрæггæнæнты $1 базæ нæй',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'crosswikiblock-reason' => 'Grund:',
	'crosswikiunblock-reason' => 'Grund:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author Masti
 * @author McMonster
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'crosswikiblock-desc' => 'Umożliwia blokowanie użytkowników na innych wiki za pomocą [[Special:Crosswikiblock|strony specjalnej]]',
	'crosswikiblock' => 'Zablokuj użytkownika na innych wiki',
	'crosswikiblock-header' => 'Ta strona pozawala zablokować użytkownika na innych wiki.
Upewnij się czy masz prawo to zrobić i czy to co robisz jest w zgodzie z zasadami.',
	'crosswikiblock-target' => 'Adres IP lub nazwa użytkownika i docelowa wiki:',
	'crosswikiblock-expiry' => 'Czas blokady:',
	'crosswikiblock-reason' => 'Powód',
	'crosswikiblock-submit' => 'Zablokuj użytkownika',
	'crosswikiblock-anononly' => 'Zablokuj tylko anonimowych użytkowników',
	'crosswikiblock-nocreate' => 'Zablokuj tworzenie konta',
	'crosswikiblock-autoblock' => 'Zablokuj ostatni adres IP tego użytkownika i automatycznie wszystkie kolejne, z których będzie próbował edytować',
	'crosswikiblock-noemail' => 'Zablokuj możliwość wysyłania e‐maili',
	'crosswikiunblock' => 'Odblokuj użytkownika na innych wiki',
	'crosswikiunblock-header' => 'Ta strona pozwala na odblokowanie użytkownika na innych wiki.
Upewnij się czy masz prawo to zrobić i czy to co robisz jest w zgodzie z zasadami.',
	'crosswikiunblock-user' => 'Nazwa użytkownika, adres IP lub ID blokady i docelowa wiki:',
	'crosswikiunblock-reason' => 'Powód',
	'crosswikiunblock-submit' => 'Odblokuj użytkownika',
	'crosswikiunblock-success' => "Użytkownik '''$1''' został odblokowany.

Wróć do:
* [[Special:CrosswikiBlock|Strona blokowania]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nie wprowadzono nazwy użytkownika',
	'crosswikiblock-local' => 'Lokalne blokowanie nie jest możliwe przy pomocy tego interfejsu. Użyj strony [[Special:BlockIP|blokowania adresów IP]].',
	'crosswikiblock-dbnotfound' => 'Baza $1 nie istnieje',
	'crosswikiblock-noname' => '„$1” nie jest poprawną nazwą użytkownika.',
	'crosswikiblock-nouser' => 'Nie odnaleziono użytkownika „$3”.',
	'crosswikiblock-noexpiry' => 'Nieprawidłowy czas blokady: $1.',
	'crosswikiblock-noreason' => 'Nie podano powodu.',
	'crosswikiblock-notoken' => 'Nieprawidłowy żeton edycji.',
	'crosswikiblock-alreadyblocked' => 'Użytkownik $3 jest już zablokowany.',
	'crosswikiblock-noblock' => 'Ten użytkownik nie jest zablokowany.',
	'crosswikiblock-success' => "Pomyślnie zablokowano użytkownika '''$3'''.

Powrót do:
* [[Special:CrosswikiBlock|Formularz blokowania]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokalne odblokowywanie nie jest obsługiwane w tym interfejsie. Użyj [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Blokowanie i odblokowywanie użytkowników na innych wiki',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'crosswikiblock-desc' => "A përmet ëd bloché utent dzora a d'àutre wiki an dovrand na [[Special:Crosswikiblock|pàgina special]]",
	'crosswikiblock' => "Blòca utent dzora a d'àutre wiki",
	'crosswikiblock-header' => "Sta pàgina-sì a përmet ëd bloché utent dzora a d'àutre wiki.
Për piasì contròla s'it peule travajé su sta wiki-sì e se toe assion a rispeto tute le règole.",
	'crosswikiblock-target' => 'Adrëssa IP o nòm utent e wiki ëd destinassion:',
	'crosswikiblock-expiry' => 'Fin:',
	'crosswikiblock-reason' => 'Rason:',
	'crosswikiblock-submit' => "Blòca st'utent-sì",
	'crosswikiblock-anononly' => "Blòca mach j'utent anònim",
	'crosswikiblock-nocreate' => 'Blòca la creassion ëd cont',
	'crosswikiblock-autoblock' => "Blòca automaticament l'ùltima adrëssa IP dovrà da st'utent-sì, e minca adrëssa IP da andova a preuva a modifiché peui",
	'crosswikiblock-noemail' => "Vieta a l'utent ëd mandé e-mail",
	'crosswikiunblock' => "Sblòca l'utent dzora a àutre wiki",
	'crosswikiunblock-header' => "Sta pàgina-sì a përmet ëd dësbloché utent dzora a d'àutre wiki.
Për piasì contròla s'it peule travajé su sta wiki-sì e se toe assion a rispeto tute le régole.",
	'crosswikiunblock-user' => 'Nòm utent, adrëssa IP o ID ëd blocagi e wiki ëd destinassion:',
	'crosswikiunblock-reason' => 'Rason:',
	'crosswikiunblock-submit' => "Sblòca st'utent-sì",
	'crosswikiunblock-success' => "Utent '''$1''' sblocà da bin.

Artorna a:
* [[Special:CrosswikiBlock|Forma ëd blòch]]
* [[$2]]",
	'crosswikiblock-nousername' => "Gnun ëstranòm d'utent a l'é stàit dàit",
	'crosswikiblock-local' => 'Ij blocagi locaj a son pa resù da costa antërfacia. Deuvra [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'La base ëd dàit $1 a esist pa',
	'crosswikiblock-noname' => '"$1" a l\'é pa un nòm utent bon.',
	'crosswikiblock-nouser' => 'Pa trovà l\'utent "$3".',
	'crosswikiblock-noexpiry' => 'Fin pa bon-a: $1.',
	'crosswikiblock-noreason' => 'Gnun-e rason spessificà.',
	'crosswikiblock-notoken' => 'Geton ëd modìfica pa bon.',
	'crosswikiblock-alreadyblocked' => "L'utent $3 a l'é già blocà.",
	'crosswikiblock-noblock' => "St'utent-sì a l'é pa blocà.",
	'crosswikiblock-success' => "Utent '''$3''' blocà da bin.

Artorna a:
* [[Special:CrosswikiBlock|Forma ëd blòch]]
* [[$4]]",
	'crosswikiunblock-local' => 'Ij dësblocagi locaj a son pa resù da costa antërfacia. Deuvra [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => "Blòca e sblòca utent dzora a d'àutre wiki",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'crosswikiblock-expiry' => 'د پای نېټه:',
	'crosswikiblock-reason' => 'سبب:',
	'crosswikiblock-submit' => 'په دې کارن بنديز لګول',
	'crosswikiblock-nocreate' => 'د ګڼون جوړولو مخنيول',
	'crosswikiunblock' => 'په نورو ويکي ګانو کې له کارن نه بنديز ليرې کول',
	'crosswikiunblock-reason' => 'سبب:',
	'crosswikiunblock-submit' => 'له دې کارن بنديز ليري کول',
	'crosswikiblock-nousername' => 'کارن-نوم مو نه دی ورکړی',
	'crosswikiblock-nouser' => 'د "$3" کارن و نه موندل شو.',
	'crosswikiblock-noreason' => 'هېڅ سبب نه دی ځانګړی شوی.',
	'crosswikiblock-alreadyblocked' => 'د $3 پر کارن د پخوا نه بنديز لګېدلی.',
	'crosswikiblock-noblock' => 'په دې کارن بنديز نه دی لګېدلی.',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'crosswikiblock-desc' => '[[Special:Crosswikiblock|Página especial]] que permite bloquear utilizadores noutras wikis',
	'crosswikiblock' => 'Bloquear utilizador noutra wiki',
	'crosswikiblock-header' => 'Esta página permite bloquear um utilizador noutra wiki.
Por favor, verifique se tem permissão para agir sobre essa wiki e se as suas acções respeitam todas as normas.',
	'crosswikiblock-target' => 'Endereço IP ou nome de utilizador e wiki destino:',
	'crosswikiblock-expiry' => 'Expiração:',
	'crosswikiblock-reason' => 'Motivo:',
	'crosswikiblock-submit' => 'Bloquear este utilizador',
	'crosswikiblock-anononly' => 'Bloquear apenas utilizadores anónimos',
	'crosswikiblock-nocreate' => 'Impedir criação de contas de utilizador',
	'crosswikiblock-autoblock' => 'Bloquear automaticamente o último endereço IP usado por este utilizador, e qualquer endereço IP subsequente a partir do qual ele tente editar',
	'crosswikiblock-noemail' => 'Impedir utilizador de enviar correio electrónico',
	'crosswikiunblock' => 'Desbloquear utilizador noutra wiki',
	'crosswikiunblock-header' => 'Esta página permite desbloquear um utilizador noutra wiki.
Por favor, verifique se tem permissão para agir sobre essa wiki e se as suas acções respeitam todas as normas.',
	'crosswikiunblock-user' => 'Nome de utilizador, endereço IP ou ID de bloqueio e wiki destino:',
	'crosswikiunblock-reason' => 'Motivo:',
	'crosswikiunblock-submit' => 'Desbloquear este utilizador',
	'crosswikiunblock-success' => "Utilizador '''$1''' desbloqueado com sucesso.

Regressar a:
* [[Special:CrosswikiBlock|Formulário de bloqueio]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nenhum nome de utilizador foi introduzido',
	'crosswikiblock-local' => 'Bloqueios locais não podem ser efectuados a partir deste interface. Use [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'A base de dados $1 não existe',
	'crosswikiblock-noname' => '"$1" não é um nome de utilizador válido.',
	'crosswikiblock-nouser' => 'O utilizador "$3" não foi encontrado.',
	'crosswikiblock-noexpiry' => 'Expiração inválida: $1.',
	'crosswikiblock-noreason' => 'Nenhum motivo especificado.',
	'crosswikiblock-notoken' => 'Identificador de edição inválido.',
	'crosswikiblock-alreadyblocked' => 'O utilizador $3 já está bloqueado.',
	'crosswikiblock-noblock' => 'Este utilizador não está bloqueado.',
	'crosswikiblock-success' => "Utilizador '''$3''' bloqueado com sucesso.

Voltar para:
* [[Special:CrosswikiBlock|Formulário de bloqueio]]
* [[$4]]",
	'crosswikiunblock-local' => 'Desbloqueios locais são podem ser efectuados a partir deste interface. Use [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Bloquear e desbloquear utilizadores noutras wikis',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'crosswikiblock-desc' => 'Permite bloquear utilizadores em outros wikis usando uma [[Special:Crosswikiblock|página especial]]',
	'crosswikiblock' => 'Bloquear utilizador em outro wiki',
	'crosswikiblock-header' => 'Esta página permite bloquear um utilizador em outro wiki.
Por favor, verifique se tem permissão para agir neste wiki e se as suas ações respeitam todas as políticas.',
	'crosswikiblock-target' => 'Endereço IP ou nome de utilizador e wiki destino:',
	'crosswikiblock-expiry' => 'Expiração:',
	'crosswikiblock-reason' => 'Motivo:',
	'crosswikiblock-submit' => 'Bloquear este utilizador',
	'crosswikiblock-anononly' => 'Bloquear apenas utilizadores anônimos',
	'crosswikiblock-nocreate' => 'Impedir criação de conta',
	'crosswikiblock-autoblock' => 'Bloquear automaticamente o último endereço IP usado por este utilizador, e qualquer endereço IP subsequente a partir do qual ele tente editar',
	'crosswikiblock-noemail' => 'Impedir utilizador de enviar email',
	'crosswikiunblock' => 'Desbloquear utilizador em outro wiki',
	'crosswikiunblock-header' => 'Esta página permite desbloquear um utilizador em outro wiki.
Por favor, verifique se tem permissão para agir neste wiki e se as suas ações respeitam todas as políticas.',
	'crosswikiunblock-user' => 'Nome de utilizador, endereço IP ou ID de bloqueio e wiki destino:',
	'crosswikiunblock-reason' => 'Motivo:',
	'crosswikiunblock-submit' => 'Desbloquear este utilizador',
	'crosswikiunblock-success' => "Utilizador '''$1''' desbloqueado com sucesso.

Regressar a:
* [[Special:CrosswikiBlock|Formulário de bloqueio]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nenhum nome de utilizador foi introduzido',
	'crosswikiblock-local' => 'Bloqueios locais não podem ser efetuados a partir deste interface. Use [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'A base de dados $1 não existe',
	'crosswikiblock-noname' => '"$1" não é um nome de utilizador válido.',
	'crosswikiblock-nouser' => 'O utilizador "$3" não foi encontrado.',
	'crosswikiblock-noexpiry' => 'Expiração inválida: $1.',
	'crosswikiblock-noreason' => 'Nenhum motivo especificado.',
	'crosswikiblock-notoken' => 'Identificador de edição inválido.',
	'crosswikiblock-alreadyblocked' => 'O utilizador $3 já está bloqueado.',
	'crosswikiblock-noblock' => 'Este utilizador não está bloqueado.',
	'crosswikiblock-success' => "Utilizador '''$3''' bloqueado com sucesso.

Voltar para:
* [[Special:CrosswikiBlock|Formulário de bloqueio]]
* [[$4]]",
	'crosswikiunblock-local' => 'Desbloqueios locais são podem ser efetuados a partir deste interface. Use [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Bloquear e desbloquear utilizadores em outros wikis',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'crosswikiblock' => 'Blochează utilizator pe alt wiki',
	'crosswikiblock-target' => 'Adresa IP sau numele de utilizator şi destinaţia wiki:',
	'crosswikiblock-reason' => 'Motiv:',
	'crosswikiblock-submit' => 'Blochează acest utilizator',
	'crosswikiblock-anononly' => 'Blochează doar utilizatorii anonimi',
	'crosswikiblock-nocreate' => 'Nu permite crearea de conturi',
	'crosswikiblock-noemail' => 'Nu permite utilizatorului să trimită e-mail',
	'crosswikiunblock' => 'Deblochează utilizator pe alt wiki',
	'crosswikiunblock-header' => 'Această pagină permite deblocarea utilizatorilor de pe alte wiki.
Vă rugăm să verificați dacă vi se permite să acționați pe acest wiki și că respectați toate politicile.',
	'crosswikiunblock-reason' => 'Motiv:',
	'crosswikiunblock-submit' => 'Deblochează acest utilizator',
	'crosswikiblock-nousername' => 'Nu a fost introdus nici un nume de utilizator',
	'crosswikiblock-dbnotfound' => 'Baza de date $1 nu există',
	'crosswikiblock-noname' => '"$1" nu este un nume de utilizator valid.',
	'crosswikiblock-nouser' => 'Utilizatorul "$3" nu este găsit.',
	'crosswikiblock-noreason' => 'Nici un motiv specificat.',
	'crosswikiblock-alreadyblocked' => 'Utilizatorul $3 este deja blocat.',
	'crosswikiblock-noblock' => 'Acest utilizator nu este blocat.',
	'crosswikiblock-success' => "Utilizatorul '''$3''' a fost blocat cu succes.

Întoarce-te la:
* [[Special:CrosswikiBlock|Block form]]
* [[$4]]",
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'crosswikiblock' => "Blocche l'utende sus a 'n'otra Uicchi",
	'crosswikiblock-expiry' => 'Scadenze:',
	'crosswikiblock-reason' => 'Mutive:',
	'crosswikiblock-submit' => "Blocche st'utende",
	'crosswikiunblock-reason' => 'Mutive:',
	'crosswikiunblock-submit' => "Sblocche st'utende",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'crosswikiblock-desc' => 'Позволяет блокировать участников на других вики с помощью [[Special:Crosswikiblock|служебной страницы]]',
	'crosswikiblock' => 'Блокировка участников на других вики',
	'crosswikiblock-header' => 'Эта страница позволяет блокировать участников в других вики.
Пожалуйста, убедитесь, что вам разрешено производить подобные действия в этой вики, и что вы следуете всем правилам.',
	'crosswikiblock-target' => 'IP-адрес или имя участника и целевая вики:',
	'crosswikiblock-expiry' => 'Истекает:',
	'crosswikiblock-reason' => 'Причина:',
	'crosswikiblock-submit' => 'Заблокировать этого участника',
	'crosswikiblock-anononly' => 'Заблокировать только анонимных участников',
	'crosswikiblock-nocreate' => 'Запретить создание учётных записей',
	'crosswikiblock-autoblock' => 'Автоматически заблокировать последний использованный этим участником IP-адрес и любые последующие IP-адреса с которых производятся попытки редактирования',
	'crosswikiblock-noemail' => 'Запретить участнику отправку электронной почты',
	'crosswikiunblock' => 'Разблокировать участника в этой вики',
	'crosswikiunblock-header' => 'Эта страница позволяет разблокировать участников в других вики.
Пожалуйста, убедитесь что вам разрешены подобные действия и что что они соответствуют всем правилам.',
	'crosswikiunblock-user' => 'Имя участника, IP-адрес или идентификатор блокировки на целевой вики:',
	'crosswikiunblock-reason' => 'Причина:',
	'crosswikiunblock-submit' => 'Разблокировать участника',
	'crosswikiunblock-success' => "Участник '''$1''' успешно разблокирован.

Вернуться к:
* [[Special:CrosswikiBlock|Форма блокировки]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Не введено имя участника',
	'crosswikiblock-local' => 'Локальные блокировки не поддерживаются через этот интерфейс. Используйте [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'База данных $1 не существует',
	'crosswikiblock-noname' => '«$1» не является допустимым именем участника.',
	'crosswikiblock-nouser' => 'Участник «$3» не найден.',
	'crosswikiblock-noexpiry' => 'Ошибочный срок окончания: $1.',
	'crosswikiblock-noreason' => 'Не указана причина.',
	'crosswikiblock-notoken' => 'Ошибочный маркер правки.',
	'crosswikiblock-alreadyblocked' => 'Участник $3 уже заблокирован.',
	'crosswikiblock-noblock' => 'Этот участник не был заблокирован.',
	'crosswikiblock-success' => "Участник '''$3''' успешно заблокирован.

Вернуться к:
* [[Special:CrosswikiBlock|форма блокировки]]
* [[$4]]",
	'crosswikiunblock-local' => 'Локальные блокировки не поддерживаются с помощью этого интерфейса. Используйте [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'блокировка и разблокировка участников в других вики',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'crosswikiblock-expiry' => 'Кінчіть:',
	'crosswikiblock-reason' => 'Причіна:',
	'crosswikiblock-submit' => 'Заблоковати того хоснователя',
	'crosswikiunblock-reason' => 'Причіна:',
);

/** Sicilian (Sicilianu)
 * @author Melos
 */
$messages['scn'] = array(
	'crosswikiblock-desc' => 'Pirmetti di bluccari utenti supra autri wiki usannu na [[Special:Crosswikiblock|pàggina spiciali]]',
	'crosswikiblock' => "Blocca utenti supra n'autra wiki",
	'crosswikiblock-expiry' => 'Scadenza:',
	'crosswikiblock-reason' => 'Mutivu:',
	'crosswikiblock-submit' => "Blocca l'utenti",
	'crosswikiblock-anononly' => "Blocca sulu l'utenti anònimi (l'utenti riggistrati ca cundivìdinu lu stissu IP nun vèninu bluccati)",
	'crosswikiblock-nocreate' => 'Mpidisci la criazzioni di àutri account',
	'crosswikiunblock-user' => 'Nomu utenti, ndirizzu IP o ID dô bloccu e wiki di distinazioni:',
	'crosswikiunblock-reason' => 'Mutivu:',
	'crosswikiunblock-submit' => "Sblocca l'utenti",
	'crosswikiblock-nousername' => 'Nun fu nseritu nu nomu utenti',
	'crosswikiblock-dbnotfound' => 'Lu database $1 nun esisti',
	'crosswikiblock-noname' => '"$1" nun è nu validu nomu utenti.',
	'crosswikiblock-nouser' => 'L\'utenti "$3" nun fu truvatu.',
	'crosswikiblock-noexpiry' => 'Scadenza nun valida: $1.',
	'crosswikiblock-noreason' => 'Nudda motivazioni spicificata.',
	'crosswikiblock-notoken' => 'Edit token nun validu.',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'crosswikiblock-alreadyblocked' => "L'utenti $3 è già broccaddu.",
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'crosswikiblock-desc' => 'Umožňuje blokovanie používateľov na iných wiki pomocou [[Special:Crosswikiblock|špeciálnej stránky]]',
	'crosswikiblock' => 'Zablokovať používateľa na inej wiki',
	'crosswikiblock-header' => 'Táto stránka umožňuje zablokovať používateľa na inej wiki.
Prosím, overte si, či máte povolené na danej wiki konať a vaše konanie je v súlade so všetkými pravidlami.',
	'crosswikiblock-target' => 'IP adresa alebo používateľské meno a cieľová wiki:',
	'crosswikiblock-expiry' => 'Expirácia:',
	'crosswikiblock-reason' => 'Dôvod:',
	'crosswikiblock-submit' => 'Zablokovať tohto používateľa',
	'crosswikiblock-anononly' => 'Zablokovať iba anonymných používateľov',
	'crosswikiblock-nocreate' => 'Zabrániť tvorbe účtov',
	'crosswikiblock-autoblock' => 'Automaticky blokovať poslednú IP adresu, ktorú tento používateľ použil a akékoľvek ďalšie adresy, z ktorých sa pokúsia upravovať.',
	'crosswikiblock-noemail' => 'Zabrániť používateľovi odosielať email',
	'crosswikiunblock' => 'Odblokovať používateľa na inej wiki',
	'crosswikiunblock-header' => 'Táto stránka umožňuje odblokovanie používateľa na inej wiki.
Prosím, uistite sa, že máte povolenie konať na tejto wiki a vaše konanie je v súlade so všetkými pravidlami.',
	'crosswikiunblock-user' => 'Používateľské meno, IP adresa alebo ID blokovania a cieľová wiki:',
	'crosswikiunblock-reason' => 'Dôvod:',
	'crosswikiunblock-submit' => 'Odblokovať tohto používateľa',
	'crosswikiunblock-success' => "Používateľ '''$1''' bol úspešne odblokovaný.

Vrátiť sa na:
* [[Special:CrosswikiBlock|Formulár blokovania]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Nebolo zadané používateľské meno',
	'crosswikiblock-local' => 'Toto rozhranie nepodporuje lokálne blokovanie. Použite [[Special:BlockIP|{{int:blockip}}]].',
	'crosswikiblock-dbnotfound' => 'Databáza $1 neexistuje',
	'crosswikiblock-noname' => '„$1“ nie je platné používateľské meno.',
	'crosswikiblock-nouser' => 'Používateľ „$3“ nebol nájdený.',
	'crosswikiblock-noexpiry' => 'Neplatná expirácia: $1.',
	'crosswikiblock-noreason' => 'Nebol uvedený dôvod.',
	'crosswikiblock-notoken' => 'Neplatný upravovací token.',
	'crosswikiblock-alreadyblocked' => 'Používateľ $3 je už zablokovaný.',
	'crosswikiblock-noblock' => 'Tento používateľ nie je zablokovaný.',
	'crosswikiblock-success' => "Používateľ '''$3''' bol úspešne zablokovaný.

Vrátiť sa na:
* [[Special:CrosswikiBlock|Blokovací formulár]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokálne blokovania nie sú týmto rozhraním podporované. Použite [[Special:IPBlockList|{{int:ipblocklist}}]].',
	'right-crosswikiblock' => 'Blokovať a odblokovať používateľov na iných wiki',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'crosswikiblock-reason' => 'Razlog:',
	'crosswikiunblock-reason' => 'Razlog:',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'crosswikiblock-expiry' => 'Истек:',
	'crosswikiblock-reason' => 'Разлог:',
	'crosswikiblock-submit' => 'Блокирај овог корисника',
	'crosswikiunblock-reason' => 'Разлог:',
	'crosswikiblock-nousername' => 'Није дато корисничко име',
	'crosswikiblock-dbnotfound' => 'База података $1 не постоји',
	'crosswikiblock-noname' => '"$1" није исправно корисничко име.',
	'crosswikiblock-noreason' => 'Није наведен разлог.',
	'crosswikiblock-alreadyblocked' => 'Корисник $3 је већ блокиран.',
	'crosswikiblock-noblock' => 'Овај корисник није блокиран.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 */
$messages['sr-el'] = array(
	'crosswikiblock-expiry' => 'Istek:',
	'crosswikiblock-reason' => 'Razlog:',
	'crosswikiblock-submit' => 'Blokiraj ovog korisnika',
	'crosswikiunblock-reason' => 'Razlog:',
	'crosswikiblock-nousername' => 'Nije dato korisničko ime',
	'crosswikiblock-dbnotfound' => 'Baza podataka $1 ne postoji',
	'crosswikiblock-noname' => '"$1" nije ispravno korisničko ime.',
	'crosswikiblock-noreason' => 'Nije naveden razlog.',
	'crosswikiblock-alreadyblocked' => 'Korisnik $3 je već blokiran.',
	'crosswikiblock-noblock' => 'Ovaj korisnik nije blokiran.',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'crosswikiblock-desc' => "Ferlööwet ju Speere fon Benutsere in uur Wiki's uur ne [[Special:Crosswikiblock|Spezioalsiede]]",
	'crosswikiblock' => 'Speer Benutser in n uur Wiki',
	'crosswikiblock-header' => 'Disse Spezioalsiede ferlööwet ju Speere fon n Benutser in n uur Wiki.
Wröich, of du ju Beföichnis hääst, in dissen uur Wiki tou speeren un of dien Aktion do Gjuchtlienjen fon do äntspräkt.',
	'crosswikiblock-target' => 'IP-Adresse of Benutsernoome un Sielwiki:',
	'crosswikiblock-expiry' => 'Speerduur:',
	'crosswikiblock-reason' => 'Begruundenge:',
	'crosswikiblock-submit' => 'IP-Adresse/Benutser speere',
	'crosswikiblock-anononly' => 'Speer bloot anonyme Benutsere (anmäldede Benutsere mäd disse IP-Adresse wäide nit speerd). In fuul Falle is dät beeter.',
	'crosswikiblock-nocreate' => 'Dät Moakjen fon Benutserkonten ferhinnerje',
	'crosswikiblock-autoblock' => 'Speer ju aktuell fon dissen Benutser bruukte IP-Adresse as uk automatisk aal do foulgjende, fon do uut hie Beoarbaidengen of dät Anlääsen fon Benutserkonten fersäkt.',
	'crosswikiblock-noemail' => 'E-Mail-Ferseenden speere',
	'crosswikiunblock' => 'Äntspeer Benutser in n uur Wiki',
	'crosswikiunblock-header' => 'Disse Spezioalsiede ferlööwet ju Aphieuwenge fon ne Benutserspeere in n uur Wiki.
Wröich, of du ju Beföichnis hääst, in dissen uur Wiki tou speeren un of dien Aktion hiere Gjuchlienjen äntspräkt.',
	'crosswikiunblock-user' => 'IP-Adresse of Benutsernoome un Sielwiki:',
	'crosswikiunblock-reason' => 'Begruundenge:',
	'crosswikiunblock-submit' => 'Speere foar IP-Adresse/Benutser aphieuwje',
	'crosswikiunblock-success' => "Benutser '''„$1“''' mäd Ärfoulch äntspeerd.

Tourääch tou:
* [[Special:CrosswikiBlock|Speerformular]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Der wuude naan Benutsernoome ienroat',
	'crosswikiblock-local' => 'Lokoale Speeren wäide truch disse Interface nit unnerstutsed. Benutsje [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Doatenboank $1 is nit deer',
	'crosswikiblock-noname' => '„$1“ is naan gultigen Benutsernoome.',
	'crosswikiblock-nouser' => 'Benutser "$3" nit fuunen.',
	'crosswikiblock-noexpiry' => 'Uungultige Speerduur: $1.',
	'crosswikiblock-noreason' => 'Begruundenge failt.',
	'crosswikiblock-notoken' => 'Uungultich Beoarbaidengs-Token.',
	'crosswikiblock-alreadyblocked' => 'Benutser "$3" is al speerd.',
	'crosswikiblock-noblock' => 'Dissen Benutser is nit speerd.',
	'crosswikiblock-success' => "Benutser '''„$3“''' mäd Ärfoulch speerd.

Tourääch tou:
* [[Special:CrosswikiBlock|Speerformular]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokoale Speeren wäide uur dit Interface nit unnerstutsed.
Benutsje [[Special:IPBlockList|{{int:ipblocklist}}]]',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'crosswikiblock-reason' => 'Alesan:',
	'crosswikiblock-noemail' => 'Henteu kaci pamaké ngirimkeun surélék',
	'crosswikiunblock-reason' => 'Alesan:',
	'crosswikiblock-alreadyblocked' => 'Pamaké $3 geus dipeungpeuk.',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'crosswikiblock-desc' => 'Gör det möjligt att blockera användare på andra wikier med hjälp av en [[Special:Crosswikiblock|specialsida]]',
	'crosswikiblock' => 'Blockera användare på en annan wiki',
	'crosswikiblock-header' => 'Den här sidan används för att blockera användare på andra wikier.
Kontrollera att du har tillåtelse att utföra åtgärder på den andra wikin, och att du följer alla policyer.',
	'crosswikiblock-target' => 'IP-adress eller användarnamn och målwiki:',
	'crosswikiblock-expiry' => 'Varaktighet:',
	'crosswikiblock-reason' => 'Anledning:',
	'crosswikiblock-submit' => 'Blockera användaren',
	'crosswikiblock-anononly' => 'Blockera bara oinloggade användare',
	'crosswikiblock-nocreate' => 'Förhindra registrering av användarkonton',
	'crosswikiblock-autoblock' => 'Blockera automatiskt den IP-adress som användaren använde senast, samt alla adresser som användaren försöker redigera ifrån',
	'crosswikiblock-noemail' => 'Hindra användaren från att skicka e-post',
	'crosswikiunblock' => 'Ta bort blockering av användare på en annan wiki',
	'crosswikiunblock-header' => 'Den här sidan används för att ta bort blockeringar av användare på andra wikier.
Kontrollera att du har tillåtelse att utföra åtgärder på den andra wikin, och att du följer alla policyer.',
	'crosswikiunblock-user' => 'Användarnamn, IP-adress eller blockerings-ID och målwiki:',
	'crosswikiunblock-reason' => 'Anledning:',
	'crosswikiunblock-submit' => 'Ta bort blockeringen',
	'crosswikiunblock-success' => "Blockeringen av '''$1''' har tagits bort.

Gå tillbaka till:
* [[Special:CrosswikiBlock|Blockeringsformuläret]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Inget användarnamn angavs',
	'crosswikiblock-local' => 'Lokala blockeringar kan inte göras från den här sidan. Använd [[Special:BlockIP|{{int:blockip}}]] istället.',
	'crosswikiblock-dbnotfound' => 'Databasen "$1" existerar inte',
	'crosswikiblock-noname' => '"$1" är inte ett giltigt användarnamn.',
	'crosswikiblock-nouser' => 'Användaren "$3" hittades inte.',
	'crosswikiblock-noexpiry' => 'Ogiltig varaktighet: $1.',
	'crosswikiblock-noreason' => 'Ingen anledning angavs.',
	'crosswikiblock-notoken' => 'Ogiltigt redigerings-token.',
	'crosswikiblock-alreadyblocked' => 'Användaren $3 är redan blockerad.',
	'crosswikiblock-noblock' => 'Användaren är inte blockerad.',
	'crosswikiblock-success' => "Blockeringen av användaren '''$3''' lyckades.

Gå tillbaka till:
* [[Special:CrosswikiBlock|Blockeringsformuläret]]
* [[$4]]",
	'crosswikiunblock-local' => 'Lokala blockeringar kan inte tas bort via det här formuläret. Använd [[Special:IPBlockList|{{int:ipblocklist}}]] istället.',
	'right-crosswikiblock' => 'Blockera och avblockera användare på andra wikier',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'crosswikiblock-expiry' => 'Wygaso:',
	'crosswikiblock-reason' => 'Čymu:',
	'crosswikiunblock-reason' => 'Čymu:',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'crosswikiblock-reason' => 'காரணம்:',
	'crosswikiunblock-reason' => 'காரணம்:',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 */
$messages['te'] = array(
	'crosswikiblock-desc' => '[[Special:Crosswikiblock|ప్రత్యేక పేజీ]] ద్వారా వాడుకర్లని ఇతర వికీల్లో కూడా నిరోధించే వీలుకల్పిస్తుంది',
	'crosswikiblock' => 'ఇతర వికీలో వాడుకరిని నిరోధించండి',
	'crosswikiblock-header' => 'ఇతర వికీలో వాడుకరిని నిరోధించేందుకు ఈ పేజీ వీలు కలిగిస్తుంది.
ఈ వికీలో మీరలా చేసేందుకు అనుమతి ఉందో లేదో, మీ చర్యలు అన్ని విధానాలను అనుసరించి ఉన్నాయో లేదో చూసుకోండి.',
	'crosswikiblock-target' => 'IP చిరునామా లేదా వాడుకరిపేరు మరియు గమ్యస్థానపు వికీ:',
	'crosswikiblock-expiry' => 'కాలపరిమితి:',
	'crosswikiblock-reason' => 'కారణం:',
	'crosswikiblock-submit' => 'ఈ వాడుకరిని నిరోధించండి',
	'crosswikiblock-anononly' => 'అనామక వాడుకరులను మాత్రమే నిరోధించు',
	'crosswikiblock-nocreate' => 'ఖాతా సృష్టింపుని నివారించు',
	'crosswikiblock-autoblock' => '
ఈ వాడుకరి వాడిన చివరి ఐపీఅడ్రసును ఆటోమాటిగ్గా నిరోధించు. అలాగే ఇకపై వాళ్ళు వాడబోయే ఐపీ అడ్రసులన్నిటినీ కూడా నిరోధించు',
	'crosswikiblock-noemail' => 'వాడుకరి ఈ-మెయిల్ పంపించడం నియంత్రించండి',
	'crosswikiunblock-user' => 'వాడుకరిపేరు, ఐపీ చిరునామా లేదా నిరోధపు ID మరియు లక్ష్యిత వికీ:',
	'crosswikiunblock-reason' => 'కారణం:',
	'crosswikiunblock-submit' => 'ఈ వాడుకరిపై నిరోధం ఎత్తివేయండి',
	'crosswikiunblock-success' => "'''$1''' అనే వాడుకరిపై నిరోధాన్ని విజయవంతంగా ఎత్తివేసాం.

తిరిగి:
* [[Special:CrosswikiBlock|నిరోధపు ఫారం]]
* [[$2]]",
	'crosswikiblock-nousername' => 'వాడుకరిపేరు ఇవ్వలేదు',
	'crosswikiblock-dbnotfound' => '$1 అనే డాటాబేసు లేదు',
	'crosswikiblock-noname' => '"$1" అన్నది సరైన వాడుకరిపేరు కాదు.',
	'crosswikiblock-nouser' => '"$3" అనే వాడుకరి కనబడలేదు.',
	'crosswikiblock-noexpiry' => 'తప్పుడు కాలపరిమితి: $1.',
	'crosswikiblock-noreason' => 'కారణం తెలుపలేదు.',
	'crosswikiblock-alreadyblocked' => '$3 అనే వాడుకరిని ఇదివరకే నిరోధించాం.',
	'crosswikiblock-noblock' => 'ఈ వాడుకరిని నిరోధించలేదు.',
	'crosswikiblock-success' => "'''$3''' అనే వాడుకరిని విజయవంతంగా నిరోధించాం.

తిరిగి:
* [[Special:CrosswikiBlock|నిరోధపు ఫారం]]
* [[$4]]",
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'crosswikiblock-reason' => 'Motivu:',
	'crosswikiblock-submit' => "Blokeiu uza-na'in ne'e",
	'crosswikiunblock-reason' => 'Motivu:',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'crosswikiblock-target' => 'Нишонаи IP ё номи корбарӣ ва викии мақсад:',
	'crosswikiblock-reason' => 'Далел:',
	'crosswikiblock-submit' => 'Бастани ин корбар',
	'crosswikiblock-anononly' => 'Фақат бастани корбарони гумном',
	'crosswikiblock-nocreate' => 'Ҷилавгирӣ аз эҷоди ҳисоб',
	'crosswikiblock-noemail' => 'Ҷилавгирии корбар аз фиристодани почтаи электронӣ',
	'crosswikiunblock' => 'Аз бастан озод кардани корбар дар дигар вики',
	'crosswikiunblock-user' => 'Номи корбарӣ, нишонаи IP  ё нишонаи бастан ва викии мақсад:',
	'crosswikiunblock-reason' => 'Сабаб:',
	'crosswikiunblock-submit' => 'Боз кардани ин корбар',
	'crosswikiunblock-success' => "Корбар '''$1''' бо муваффақият боз шуд.

Баргардед ба:
* [[Special:CrosswikiBlock|Форми бастан]]
* [[$2]]",
	'crosswikiblock-dbnotfound' => 'Пойгоҳи додаи $1 вуҷуд надорад',
	'crosswikiblock-noname' => '"$1" номи корбарии номӯътабар аст.',
	'crosswikiblock-nouser' => 'Корбар "$3" ёфт нашуд.',
	'crosswikiblock-noreason' => 'Сабабе мушаххас нашудааст.',
	'crosswikiblock-alreadyblocked' => 'Корбар $3 аллакай баста шудааст.',
	'crosswikiblock-noblock' => 'Ин корбар баста нашудааст.',
	'crosswikiblock-success' => "Корбар '''$3''' бо муваффақият баста шуд.

Баргардед ба:
* [[Special:CrosswikiBlock|Форми бастан]]
* [[$4]]",
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'crosswikiblock-target' => 'Nişonai IP jo nomi korbarī va vikiji maqsad:',
	'crosswikiblock-reason' => 'Dalel:',
	'crosswikiblock-submit' => 'Bastani in korbar',
	'crosswikiblock-anononly' => 'Faqat bastani korbaroni gumnom',
	'crosswikiblock-nocreate' => 'Çilavgirī az eçodi hisob',
	'crosswikiblock-noemail' => 'Çilavgiriji korbar az firistodani poctai elektronī',
	'crosswikiunblock' => 'Az bastan ozod kardani korbar dar digar viki',
	'crosswikiunblock-user' => 'Nomi korbarī, nişonai IP  jo nişonai bastan va vikiji maqsad:',
	'crosswikiunblock-reason' => 'Sabab:',
	'crosswikiunblock-submit' => 'Boz kardani in korbar',
	'crosswikiunblock-success' => "Korbar '''$1''' bo muvaffaqijat boz şud.

Bargarded ba:
* [[Special:CrosswikiBlock|Formi bastan]]
* [[$2]]",
	'crosswikiblock-dbnotfound' => 'Pojgohi dodai $1 vuçud nadorad',
	'crosswikiblock-noname' => '"$1" nomi korbariji nomū\'tabar ast.',
	'crosswikiblock-nouser' => 'Korbar "$3" joft naşud.',
	'crosswikiblock-noreason' => 'Sababe muşaxxas naşudaast.',
	'crosswikiblock-alreadyblocked' => 'Korbar $3 allakaj basta şudaast.',
	'crosswikiblock-noblock' => 'In korbar basta naşudaast.',
	'crosswikiblock-success' => "Korbar '''$3''' bo muvaffaqijat basta şud.

Bargarded ba:
* [[Special:CrosswikiBlock|Formi bastan]]
* [[$4]]",
);

/** Thai (ไทย)
 * @author Harley Hartwell
 * @author Mopza
 * @author Octahedron80
 */
$messages['th'] = array(
	'crosswikiblock-desc' => 'อนุญาตให้บล็อกผู้ใช้บนวิกิอื่น ผ่านทาง[[Special:Crosswikiblock|หน้าพิเศษ]]',
	'crosswikiblock' => 'บล็อกผู้ใช้บนวิกิอื่น',
	'crosswikiblock-header' => 'หน้านี้อนุญาตให้คุณบล็อกผู้ใช้บนวิกิอื่นได้ กรุณาตรวจสอบให้แน่ใจว่าคุณสามารถบล็อกผู้ใช้บนวิกินี้ได้ และการบล็อกดังกล่าวเป็นไปตามนโยบายของวิกินั้น ๆ',
	'crosswikiblock-target' => 'ไอพีแอดเดรสหรือชื่อผู้ใช้ และวิกิที่ต้องการบล็อกไอพีหรือผู้ใช้ดังกล่าว:',
	'crosswikiblock-expiry' => 'หมดอายุ:',
	'crosswikiblock-reason' => 'เหตุผล:',
	'crosswikiblock-submit' => 'บล็อกผู้ใช้รายนี้',
	'crosswikiblock-anononly' => 'บล็อกผู้ใช้นิรนามเท่านั้น',
	'crosswikiblock-nocreate' => 'ห้ามสร้างบัญชีผู้ใช้',
	'crosswikiblock-autoblock' => 'บล็อกไอพีล่าสุดที่ใช้โดยผู้ใช้คนนี้ และไอพีแอดเดรสอื่น ๆ ที่ผู้ใช้พยายามใช้เพื่อแก้ไข',
	'crosswikiblock-noemail' => 'บล็อกการส่งอีเมล',
	'crosswikiunblock' => 'เลิกบล็อกผู้ใช้บนวิกิอื่น',
	'crosswikiunblock-header' => 'หน้านี้อนุญาตให้คุณเลิกบล็อกผู้ใช้บนวิกิอื่นได้ กรุณาตรวจสอบให้แน่ใจว่าคุณสามารถเลิกบล็อกผู้ใช้บนวิกินี้ได้ และการเลิกบล็อกดังกล่าวเป็นไปตามนโยบายของวิกินั้น ๆ',
	'crosswikiunblock-user' => 'ชื่อผู้ใช้ ไอพีแอดเดรสหรือรหัสการบล็อก (Block ID) และวิกิที่ต้องการเลิกบล็อกไอพีหรือผู้ใช้ดังกล่าว:',
	'crosswikiunblock-reason' => 'เหตุผล:',
	'crosswikiunblock-submit' => 'เลิกบล็อกผู้ใช้รายนี้',
	'crosswikiunblock-success' => "เลิกบล็อกผู้ใช้ '''$1''' แล้ว

กลับไปยัง:
* [[Special:CrosswikiBlock|ฟอร์มการบล็อก]]
* [[$2]]",
	'crosswikiblock-nousername' => 'ไม่ได้ใส่ชื่อผู้ใช้',
	'crosswikiblock-local' => 'หน้านี้ไม่สามารถใช้บล็อกผู้ใช้ในวิกินี้ได้ กรุณาใช้ [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'ไม่พบฐานข้อมูล $1',
	'crosswikiblock-noname' => '"$1" ไม่ใช่ชื่อผู้ใช้ที่ถูกต้อง',
	'crosswikiblock-nouser' => 'ไม่พบผู้ใช้ "$3"',
	'crosswikiblock-noexpiry' => 'เวลาหมดอายุไม่ถูกต้อง: $1',
	'crosswikiblock-noreason' => 'ไม่ได้ระบุเหตุผล',
	'crosswikiblock-notoken' => 'Edit Token ไม่ถูกต้อง',
	'crosswikiblock-alreadyblocked' => 'ผู้ใช้ $3 ถูกบล็อกอยู่ก่อนแล้ว',
	'crosswikiblock-noblock' => 'ผู้ใช้นี้ไม่ได้ถูกบล็อก',
	'crosswikiblock-success' => "ผู้ใช้ '''$3''' ได้ถูกบล็อกแล้ว

กลับไปยัง:
* [[Special:CrosswikiBlock|ฟอร์มการบล็อก]]
* [[$4]]",
	'crosswikiunblock-local' => 'หน้านี้ไม่สามารถใช้เลิกบล็อกผู้ใช้ในวิกินี้ได้ กรุณาใช้ [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'บล็อกและเลิกบล็อกผู้ใช้บนวิกิอื่น',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'crosswikiblock-nocreate' => 'Hasap açmagyny bökde',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'crosswikiblock-desc' => 'Nagpapahintulot na mahadlangan ang mga tagagamit sa ibang mga wiki na ginagamitan ng isang [[Special:Crosswikiblock|natatanging pahina]]',
	'crosswikiblock' => 'Hadlangan ang tagagamit sa ibang wiki',
	'crosswikiblock-header' => 'Nagpapahintulot ang pahinang ito na hadlangan ang tagagamit sa ibang wiki.
Pakisuri kung may pahintulot kang kumilos sa wiking ito at kung tumutugma ang mga kilos mo sa lahat ng mga patakaran.',
	'crosswikiblock-target' => 'Adres ng IP o pangalan ng tagagamit at kapupuntahang wiki:',
	'crosswikiblock-expiry' => 'Katapusan:',
	'crosswikiblock-reason' => 'Dahilan:',
	'crosswikiblock-submit' => 'Hadlangan ang tagagamit na ito',
	'crosswikiblock-anononly' => 'Hadlangan lamang ang hindi nakikilalang mga tagagamit',
	'crosswikiblock-nocreate' => 'Pigilan ang paglikha ng akawnt',
	'crosswikiblock-autoblock' => 'Kusang hadlangan ang huling adres ng IP na ginamit ng tagagamit na ito, at alin mang susunod na mga adres na IP na susubukin nilang panggalingan upang makapamatnugot',
	'crosswikiblock-noemail' => 'Pigilang makapagpadala ng e-liham ang tagagamit',
	'crosswikiunblock' => 'Huwag hadlangan ang tagagamit sa ibang wiki',
	'crosswikiunblock-header' => 'Nagpapahintulot ang pahinang ito na tanggalin ang pagkakahadlang ng tagagamit sa ibang wiki.
Pakisuri kung may pahintulot kang kumilos sa wiking ito at ang tumutugma ang kilos mo sa lahat ng mga patakaran.',
	'crosswikiunblock-user' => 'Pangalan ng tagagamit, adres ng IP o ID ng paghadlang at kapupuntahang wiki:',
	'crosswikiunblock-reason' => 'Dahilan:',
	'crosswikiunblock-submit' => 'Huwag hadlangan ang tagagamit na ito',
	'crosswikiunblock-success' => "Matagumpay na tinanggal ang hadlang ng tagagamit na si '''$1'''.

Magbalik sa:
* [[Special:CrosswikiBlock|Pormularyo ng paghadlang]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Walang ibinigay na pangalan ng tagagamit',
	'crosswikiblock-local' => 'Hindi sinusuportahan ang pampook na mga paghahadlang sa pamamagitan ng ugnayang hangganang ito. Gamitin ang [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Hindi umiiral ang kalipunan ng datong $1',
	'crosswikiblock-noname' => 'Ang "$1" ay isang hindi tanggap na pangalan ng tagagamit.',
	'crosswikiblock-nouser' => 'Hindi natagpuan ang tagagamit na si "$3".',
	'crosswikiblock-noexpiry' => 'Hindi tanggap na wakas ng bisa: $1.',
	'crosswikiblock-noreason' => 'Walang tinukoy na dahilan.',
	'crosswikiblock-notoken' => 'Hindi tanggap na tanda ng pagbago.',
	'crosswikiblock-alreadyblocked' => 'Hinahadlangan na ang tagagamit na si $3.',
	'crosswikiblock-noblock' => 'Hindi hinahadlangan ang tagagamit na ito.',
	'crosswikiblock-success' => "Matagumpay na nahadlangan ang tagagamit na si '''$3'''.

Magbalik sa:
* [[Special:CrosswikiBlock|Pormularyo ng paghadlang]]
* [[$4]]",
	'crosswikiunblock-local' => 'Hindi tinatangkilik ang pampook na mga paghahadlang sa pamamagitan ng ugnayang-hangganang ito. Gamitin ang [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Hadlangan at huwag hadlangang ang mga tagagamit na nasa iba pang mga wiki',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Mach
 * @author Srhat
 * @author Suelnur
 */
$messages['tr'] = array(
	'crosswikiblock-desc' => '[[Special:Crosswikiblock|Özel bir sayfa]] kullanarak diğer vikilerdeki kullanıcıları engellemeye izin verir',
	'crosswikiblock' => 'Diğer vikide kullanıcıyı engelle',
	'crosswikiblock-header' => 'Bu sayfa diğer vikide kullanıcı engellemeye izin verir.
Lütfen bunu gerçekleştirmeye izninizin olduğunu ve eylemlerinizin tüm ilkelerle uyuştuğunu kontrol edin.',
	'crosswikiblock-target' => 'IP adresi veya kullanıcı adı ve hedef viki:',
	'crosswikiblock-expiry' => 'Bitiş:',
	'crosswikiblock-reason' => 'Gerekçe:',
	'crosswikiblock-submit' => 'Bu kullanıcıyı engelle',
	'crosswikiblock-anononly' => 'Sadece anonim kullanıcıları engelle',
	'crosswikiblock-nocreate' => 'Hesap oluşturmayı önle',
	'crosswikiblock-autoblock' => 'Bu kullanıcı tarafından kullanılan son IP adresini, ve değişiklik yapmaya çalıştıkları mütakip her IP adresini otomatik olarak engelle',
	'crosswikiblock-noemail' => 'Kullanıcının e-posta göndermesini önle',
	'crosswikiunblock' => 'Diğer vikide kullanıcının engellemesini kaldır',
	'crosswikiunblock-header' => 'Bu sayfa diğer vikide kullanıcının engellemesinin kaldırılmasına izin verir.
Lütfen bunu gerçekleştirmeye izninizin olduğunu ve eylemlerinizin tüm ilkelerle uyuştuğunu kontrol edin.',
	'crosswikiunblock-user' => 'Kullanıcı adı, IP adresi veya engelleme IDsi ve hedef viki:',
	'crosswikiunblock-reason' => 'Neden:',
	'crosswikiunblock-submit' => 'Bu kullanıcının engellemesini kaldır',
	'crosswikiunblock-success' => "'''$1''' kullanıcısı başarıyla engellemesi kaldırıldı.

Geri dön:
* [[Special:CrosswikiBlock|Engelleme formu]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Herhangi bir kullanıcı adı verilmedi',
	'crosswikiblock-local' => 'Yerel engellemeler bu arayüz ile desteklenmez. [[Special:BlockIP|{{int:blockip}}]] kullanın',
	'crosswikiblock-dbnotfound' => 'Veritabanı $1 mevcut değil',
	'crosswikiblock-noname' => '"$1" geçerli bir kullanıcı adı değil.',
	'crosswikiblock-nouser' => '"$3" kullanıcısı bulunamadı.',
	'crosswikiblock-noexpiry' => 'Geçersiz bitiş: $1.',
	'crosswikiblock-noreason' => 'Neden belirtilmedi.',
	'crosswikiblock-notoken' => 'Geçersiz değişiklik dizgeciği',
	'crosswikiblock-alreadyblocked' => '$3 kullanıcısı zaten engellendi.',
	'crosswikiblock-noblock' => 'Bu kullanıcı engellenmemiş.',
	'crosswikiblock-success' => "'''$3''' kullanıcısı başarıyla engellendi.

Geri dön:
* [[Special:CrosswikiBlock|Engelleme formu]]
* [[$4]]",
	'crosswikiunblock-local' => 'Yerel engelleme kaldırmaları bu arayüz ile desteklenmez. [[Special:IPBlockList|{{int:ipblocklist}}]] kullanın',
	'right-crosswikiblock' => 'Diğer vikilerdeki kullanıcıları engelleyin veya kullanıcıların engellemelerini kaldırın',
);

/** Ukrainian (Українська)
 * @author Alex Khimich
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'crosswikiblock-desc' => 'Дозволяє блокувати користувачів в інших вікі за допомогою [[Special:Crosswikiblock|спеціальної сторінки]]',
	'crosswikiblock' => 'Блокування користувача на інших вікі',
	'crosswikiblock-header' => 'Ця сторінка дозволяє блокувати користувачів на інших вікі. 
Будь ласка, перевірте, чи ви маєте право так чинити у цій вікі, і що ваші дії відповідають всім політикам.',
	'crosswikiblock-target' => "IP-адреса або ім'я користувача та цільова вікі:",
	'crosswikiblock-expiry' => 'Закінчення:',
	'crosswikiblock-reason' => 'Причина:',
	'crosswikiblock-submit' => 'Заблокувати цього користувача',
	'crosswikiblock-anononly' => 'Блокувати тільки анонімних користувачів',
	'crosswikiblock-nocreate' => 'Запобігання створення облікового запису',
	'crosswikiblock-autoblock' => 'Автоматично блокувати останню IP адресу, використовувану цим користувачем, і будь-які подальші IP-адреси з яких вони намагаються вносити зміни',
	'crosswikiblock-noemail' => 'Забороняти можливість для учасників відправляти електронну пошту.',
	'crosswikiunblock' => 'Розблокувати користувача на інших вікі',
	'crosswikiunblock-header' => 'Ця сторінка дозволяє розблокувати користувача на інших вікі. 
Будь ласка, перевірте, чи ви маєте право діяти від цієї вікі і ваші дії відповідають всім політикам.',
	'crosswikiunblock-user' => "Ім'я користувача, IP-адреса або блокування ID в призначенній вікі:",
	'crosswikiunblock-reason' => 'Причина:',
	'crosswikiunblock-submit' => 'Розблокувати цього користувача',
	'crosswikiunblock-success' => "Користувача '''$1''' успішно розблоковано.

Повернутись до:
* [[Special:CrosswikiBlock|Форми блокування]]
* [[$2]]",
	'crosswikiblock-nousername' => "Не недано ім'я користувача",
	'crosswikiblock-local' => 'Локальні блокування не підтримується через цей інтерфейс. Використовуйте [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'База даних $1 не існує',
	'crosswikiblock-noname' => '"$1" не є чинним ім\'ям користувача.',
	'crosswikiblock-nouser' => 'Користувача "$3" не знайдено.',
	'crosswikiblock-noexpiry' => 'Помилковий строк закінчення: $1.',
	'crosswikiblock-noreason' => 'Не зазначено причину',
	'crosswikiblock-notoken' => 'Неприпустимий маркер редагування',
	'crosswikiblock-alreadyblocked' => 'Користувач $3 вже заблокований.',
	'crosswikiblock-noblock' => 'Цей користувач не заблокований.',
	'crosswikiblock-success' => "Користувача '''$3''' успішно заблоковано.

Повернутись до:
* [[Special:CrosswikiBlock|Форми блокування]]
* [[$4]]",
	'crosswikiunblock-local' => 'Локальні розблокування не підтримується через цей інтерфейс. Використовуйте [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Блокування та розблокування користувачів в інших вікі',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'crosswikiblock-reason' => 'وجہ:',
	'crosswikiunblock-reason' => 'وجہ:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'crosswikiblock-desc' => 'Permete de blocar utenti de altre wiki doparando na [[Special:Crosswikiblock|pagina special]]',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'crosswikiblock-desc' => 'Cho phép cấm thành viên tại các wiki khác qua một [[Special:Crosswikiblock|trang đặc biệt]]',
	'crosswikiblock' => 'Cấm thành viên tại wiki khác',
	'crosswikiblock-header' => 'Trang này cho phép cấm thành viên tại wiki khác.
Xin hãy kiểm tra xem bạn có được phép thực hiện điều này tại wiki này hay không và hành động của bạn có theo đúng tất cả các quy định hay không.',
	'crosswikiblock-target' => 'Địa chỉ IP hoặc tên người dùng và wiki đích:',
	'crosswikiblock-expiry' => 'Hết hạn:',
	'crosswikiblock-reason' => 'Lý do:',
	'crosswikiblock-submit' => 'Cấm',
	'crosswikiblock-anononly' => 'Chỉ cấm người dùng vô danh',
	'crosswikiblock-nocreate' => 'Không cho tạo tài khoản',
	'crosswikiblock-autoblock' => 'Tự động cấm các địa chỉ IP mà thành viên này sử dụng',
	'crosswikiblock-noemail' => 'Không cho gửi thư điện tử',
	'crosswikiunblock' => 'Bỏ cấm thành viên tại wiki khác',
	'crosswikiunblock-header' => 'Trang này cho phép bỏ cấm thành viên tại wiki khác.
Xin hãy kiểm tra xem bạn có được phép thực hiện điều này tại wiki này hay không và hành động của bạn có theo đúng tất cả các quy định hay không.',
	'crosswikiunblock-user' => 'Tên người dùng, địa chỉ IP hoặc mã số cấm và wiki đích:',
	'crosswikiunblock-reason' => 'Lý do:',
	'crosswikiunblock-submit' => 'Bỏ cấm thành viên này',
	'crosswikiunblock-success' => "Thành viên '''$1''' đã được bỏ cấm.

Quay trở lại:
* [[Special:CrosswikiBlock|Mẫu cấm]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Chưa nhập tên người dùng',
	'crosswikiblock-local' => 'Giao diện này không hỗ trợ cấm tại wiki này. Hãy dùng [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Cơ sở dữ liệu $1 không tồn tại',
	'crosswikiblock-noname' => '“$1” không phải là tên hợp lệ.',
	'crosswikiblock-nouser' => 'Không tìm thấy thành viên “$3”.',
	'crosswikiblock-noexpiry' => 'Thời hạn cấm không hợp lệ: $1.',
	'crosswikiblock-noreason' => 'Chưa đưa ra lý do.',
	'crosswikiblock-notoken' => 'Bằng chứng sửa đổi không hợp lệ.',
	'crosswikiblock-alreadyblocked' => 'Thành viên “$3” đã bị cấm rồi.',
	'crosswikiblock-noblock' => 'Thành viên này không bị cấm.',
	'crosswikiblock-success' => "Thành viên '''$3''' đã bị cấm.

Quay trở về:
* [[Special:CrosswikiBlock|Mẫu cấm]]
* [[$4]]",
	'crosswikiunblock-local' => 'Giao diện này không hỗ trợ bỏ cấm tại wiki này. Hãy dùng [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => 'Cấm và bỏ cấm người dùng tại wiki khác',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'crosswikiblock-desc' => 'Dälon ad neletön gebanis su vüks votik ad gebön [[Special:Crosswikiblock|padi patik]]',
	'crosswikiblock' => 'Blokön gebani su vük votik',
	'crosswikiblock-header' => 'Pad at mögükon blokami gebanas su vüks votik.
Fümedolös, das dalol dunön osi su vük at, e das lobedol dunamods valik.',
	'crosswikiblock-target' => 'Ladet-IP u gebananem e zeilavük:',
	'crosswikiblock-expiry' => 'Dul jü:',
	'crosswikiblock-reason' => 'Kod:',
	'crosswikiblock-submit' => 'Blokön gebani at',
	'crosswikiblock-anononly' => 'Blokön te gebanis nennemik',
	'crosswikiblock-nocreate' => 'Nemögükön kalijafi',
	'crosswikiblock-autoblock' => 'Blokön itjäfidiko ladeti-IP lätik fa geban at pägeböli äsi ladetis-IP alseimik fa on pogebölis ad redakön',
	'crosswikiblock-noemail' => 'Neletön gebani ad sedön penedis leäktronik',
	'crosswikiunblock' => 'Säblokön gebani su vük votik',
	'crosswikiunblock-header' => 'Pad at dälon säblokami gebana su vük votik.
Fümedolös büo, das dalol dunön osi su vük at, e das lobedol dunamodis valik.',
	'crosswikiunblock-user' => 'Gebananem, ladet-IP u blokamanüm e zeilavük:',
	'crosswikiunblock-reason' => 'Kod:',
	'crosswikiunblock-submit' => 'Säblokön gebani at',
	'crosswikiunblock-success' => "Geban: '''$1''' pesäblokon benosekiko.

Geikön lü:
* [[Special:CrosswikiBlock|Blokamafomet]]
* [[$2]]",
	'crosswikiblock-nousername' => 'Gebananem no pegivon',
	'crosswikiblock-local' => 'Blokams su vük at no kanons paledunön medü pad at. Gebolös padi: [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => 'Nünodem: $1 no dabinon',
	'crosswikiblock-noname' => '„$1“ no binon gebananem lonöföl.',
	'crosswikiblock-nouser' => 'Geban: „$3“ no petuvon.',
	'crosswikiblock-noexpiry' => 'Dul no lonöfol: $1.',
	'crosswikiblock-noreason' => 'Kod nonik pegivon.',
	'crosswikiblock-notoken' => 'Redakam no lonöfon.',
	'crosswikiblock-alreadyblocked' => 'Geban: $3 ya peblokon.',
	'crosswikiblock-noblock' => 'Geban at no peblokon.',
	'crosswikiblock-success' => "Geban: '''$3''' peblokon benosekiko.

Geikön lü:
* [[Special:CrosswikiBlock|Blokamafomet]]
* [[$4]]",
	'crosswikiunblock-local' => 'Säblokams su vük at no kanons paledunön medü pad at. Gebolös padi: [[Special:IPBlockList|{{int:ipblocklist}}]]',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'crosswikiblock-reason' => '理由：',
	'crosswikiunblock-reason' => '理由：',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'crosswikiblock-expiry' => 'אויסגיין:',
	'crosswikiblock-reason' => 'אורזאַך:',
	'crosswikiunblock-reason' => 'אורזאַך:',
	'crosswikiblock-nousername' => 'קיין באַניצער־נאָמען נישט אַרײַנגעגעבן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'crosswikiblock-desc' => '可以阻止用户对其他维基使用 [[Special:Crosswikiblock|特别页]]',
	'crosswikiblock' => '防止用户对其他维基',
	'crosswikiblock-header' => '此页允许其他维基的块用户。
请检查，如果允许您对此维基和你的行为相匹配的所有政策。',
	'crosswikiblock-target' => 'IP 地址或用户名和目标维基：',
	'crosswikiblock-expiry' => '期限：',
	'crosswikiblock-reason' => '原因：',
	'crosswikiblock-submit' => '阻止此用户',
	'crosswikiblock-anononly' => '仅阻止匿名用户',
	'crosswikiblock-nocreate' => '防止创建帐户',
	'crosswikiblock-autoblock' => '自动阻止此的用户使用的最后一个 IP 地址和任何后续的 IP 地址，他们尝试从编辑',
	'crosswikiblock-noemail' => '阻止用户发送电子邮件',
	'crosswikiunblock' => '取消阻止其他维基上的用户',
	'crosswikiunblock-header' => '此页允许取消阻止其他维基上的用户。
请检查，如果允许您对此维基和你的行为相匹配的所有政策。',
	'crosswikiunblock-user' => '用户名、 IP 地址或阻止 ID 和目标的维基：',
	'crosswikiunblock-reason' => '原因：',
	'crosswikiunblock-submit' => '取消阻止此用户',
	'crosswikiunblock-success' => "用户 ''$1 '' 成功解除。

返回到：
* [[Special:CrosswikiBlock|阻止表单]]
* [[$2]]",
	'crosswikiblock-nousername' => '有没有用户名',
	'crosswikiblock-local' => '通过此接口不支持本地块。使用 [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => '数据库 $1 不存在',
	'crosswikiblock-noname' => '"$1" 不是有效的用户名。',
	'crosswikiblock-nouser' => '找不到用户 "$3"。',
	'crosswikiblock-noexpiry' => '无效的过期： $1。',
	'crosswikiblock-noreason' => '指定没有理由。',
	'crosswikiblock-notoken' => '无效的编辑标记。',
	'crosswikiblock-alreadyblocked' => '用户 $3 已经封锁。',
	'crosswikiblock-noblock' => '此用户不会被阻止。',
	'crosswikiblock-success' => "用户 '''$3''' 阻止成功。

返回到：
* [[Special:CrosswikiBlock|阻止表单]]
* [[$4]]",
	'crosswikiunblock-local' => '本地可取消阻止不支持通过此接口。使用 [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => '阻止和取消阻止其他维基上的用户',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 */
$messages['zh-hant'] = array(
	'crosswikiblock-desc' => '可以阻止用戶對其他維基使用 [[Special:Crosswikiblock|特別頁]]',
	'crosswikiblock' => '防止用戶對其他維基',
	'crosswikiblock-header' => '此頁允許其他維基的塊用戶。
請檢查，如果允許您對此維基和你的行為相匹配的所有政策。',
	'crosswikiblock-target' => 'IP 地址或用戶名和目標維基：',
	'crosswikiblock-expiry' => '期限：',
	'crosswikiblock-reason' => '原因：',
	'crosswikiblock-submit' => '阻止此用戶',
	'crosswikiblock-anononly' => '僅阻止匿名用戶',
	'crosswikiblock-nocreate' => '防止創建帳戶',
	'crosswikiblock-autoblock' => '自動阻止此的用戶使用的最後一個 IP 地址和任何後續的 IP 地址，他們嘗試從編輯',
	'crosswikiblock-noemail' => '阻止用戶發送電子郵件',
	'crosswikiunblock' => '取消阻止其他維基上的用戶',
	'crosswikiunblock-header' => '此頁允許取消阻止其他維基上的用戶。
請檢查，如果允許您對此維基和你的行為相匹配的所有政策。',
	'crosswikiunblock-user' => '用戶名、 IP 地址或阻止 ID 和目標的維基：',
	'crosswikiunblock-reason' => '原因：',
	'crosswikiunblock-submit' => '取消阻止此用戶',
	'crosswikiunblock-success' => "用戶 ''$1 '' 成功解除。

返回到：
* [[Special:CrosswikiBlock|阻止表單]]
* [[$2]]",
	'crosswikiblock-nousername' => '有沒有用戶名',
	'crosswikiblock-local' => '通過此接口不支持本地塊。使用 [[Special:BlockIP|{{int:blockip}}]]',
	'crosswikiblock-dbnotfound' => '數據庫 $1 不存在',
	'crosswikiblock-noname' => '"$1" 不是有效的用戶名。',
	'crosswikiblock-nouser' => '找不到用戶 "$3"。',
	'crosswikiblock-noexpiry' => '無效的過期： $1。',
	'crosswikiblock-noreason' => '指定沒有理由。',
	'crosswikiblock-notoken' => '無效的編輯標記。',
	'crosswikiblock-alreadyblocked' => '用戶 $3 已經封鎖。',
	'crosswikiblock-noblock' => '此用戶不會被阻止。',
	'crosswikiblock-success' => "用戶 '''$3''' 阻止成功。

返回到：
* [[Special:CrosswikiBlock|阻止表單]]
* [[$4]]",
	'crosswikiunblock-local' => '本地可取消阻止不支持通過此接口。使用 [[Special:IPBlockList|{{int:ipblocklist}}]]',
	'right-crosswikiblock' => '阻止和取消阻止其他維基上的用戶',
);

