<?php
/**
 * Internationalisation file for CheckUser extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'checkuser-summary'          => 'This tool scans recent changes to retrieve the IPs used by a user or show the edit/user data for an IP.
Users and edits by a client IP can be retrieved via XFF headers by appending the IP with "/xff". IPv4 (CIDR 16-32) and IPv6 (CIDR 64-128) are supported.
No more than 5000 edits will be returned for performance reasons.
Use this in accordance with policy.',
	'checkuser-desc'             => 'Grants users with the appropriate permission the ability to check user\'s IP addresses and other information',
	'checkuser-logcase'          => 'The log search is case sensitive.',
	'checkuser'                  => 'Check user',
	'group-checkuser'            => 'Check users',
	'group-checkuser-member'     => 'Check user',
	'right-checkuser'            => "Check user's IP addresses and other information",
	'right-checkuser-log'        => "View the checkuser log",
	'grouppage-checkuser'        => '{{ns:project}}:Check user',
	'checkuser-reason'           => 'Reason:',
	'checkuser-showlog'          => 'Show log',
	'checkuser-log'              => 'CheckUser log',
	'checkuser-query'            => 'Query recent changes',
	'checkuser-target'           => 'User or IP',
	'checkuser-users'            => 'Get users',
	'checkuser-edits'            => 'Get edits from IP',
	'checkuser-ips'              => 'Get IPs',
	'checkuser-account'          => 'Get account edits',
	'checkuser-search'           => 'Search',
	'checkuser-period'           => 'Duration:',
	'checkuser-week-1'           => 'last week',
	'checkuser-week-2'           => 'last two weeks',
	'checkuser-month'            => 'last 30 days',
	'checkuser-all'              => 'all',
	'checkuser-empty'            => 'The log contains no items.',
	'checkuser-nomatch'          => 'No matches found.',
	'checkuser-nomatch-edits'    => 'No matches found.
Last edit was on $1 at $2.',
	'checkuser-check'            => 'Check',
	'checkuser-log-fail'         => 'Unable to add log entry',
	'checkuser-nolog'            => 'No log file found.',
	'checkuser-blocked'          => 'Blocked',
	'checkuser-gblocked'         => 'Blocked globally',
	'checkuser-locked'           => 'Locked',
	'checkuser-wasblocked'       => 'Previously blocked',
	'checkuser-localonly'        => 'Not unified',
	'checkuser-massblock'        => 'Block selected users',
	'checkuser-massblock-text'   => 'Selected accounts will be blocked indefinitely, with autoblocking enabled and account creation disabled. 
	IP addresses will be blocked for 1 week for IP users only and with account creation disabled.',
	'checkuser-blocktag'         => 'Replace user pages with:',
	'checkuser-blocktag-talk'    => 'Replace talk pages with:',
	'checkuser-massblock-commit' => 'Block selected users',
	'checkuser-block-success'    => '\'\'\'The {{PLURAL:$2|user|users}} $1 {{PLURAL:$2|is|are}} now blocked.\'\'\'',
	'checkuser-block-failure'    => '\'\'\'No users blocked.\'\'\'',
	'checkuser-block-limit'      => 'Too many users selected.',
	'checkuser-block-noreason'   => 'You must give a reason for the blocks.',
	'checkuser-accounts'         => '$1 new {{PLURAL:$1|account|accounts}}',
	'checkuser-too-many'         => 'Too many results, please narrow down the CIDR.
Here are the IPs used (5000 max, sorted by address):',
	'checkuser-user-nonexistent' => 'The specified user does not exist.',
	'checkuser-search-form'      => 'Find log entries where the $1 is $2',
	'checkuser-search-submit'    => 'Search',
	'checkuser-search-initiator' => 'initiator',
	'checkuser-search-target'    => 'target',
	'checkuser-ipeditcount'      => '~$1 from all users',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Return to CheckUser main form',
	
	'checkuser-limited'          => '\'\'\'These results have been truncated for performance reasons.\'\'\'',

	'checkuser-log-userips'      => '$1 got IPs for $2',
	'checkuser-log-ipedits'      => '$1 got edits for $2',
	'checkuser-log-ipusers'      => '$1 got users for $2',
	'checkuser-log-ipedits-xff'  => '$1 got edits for XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 got users for XFF $2',
	'checkuser-log-useredits'    => '$1 got edits for $2',
	
	'checkuser-autocreate-action' => 'was automatically created',
	'checkuser-email-action'     => 'sent an email to user "$1"',
	'checkuser-reset-action'     => 'reset password for user "$1"',
	
	'checkuser-toollinks'        => '<span class="plainlinks">[[http://openrbl.org/query?$1 RDNS] ·
[http://www.robtex.com/rbls/$1.html RBLs] ·
[http://www.dnsstuff.com/tools/tracert.ch?ip=$1 Traceroute] ·
[http://www.ip2location.com/$1 Geolocate] ·
[http://toolserver.org/~krimpet/torcheck.php?ip=$1 Tor check] ·
[http://ws.arin.net/whois/?queryinput=$1 WHOIS]]</span>', # do not translate or duplicate this message to other languages
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 * @author Jon Harald Søby
 * @author Kwj2772
 * @author Lejonel
 * @author Meno25
 * @author Mormegil
 * @author Purodha
 * @author Siebrand
 * @author Slomox
 */
$messages['qqq'] = array(
	'checkuser-desc' => 'Short description of the CheckUser extension, shown on [[Special:Version]]',
	'checkuser' => 'Check user extension. The name of the special page where checkusers can check the IP addresses of users. The message is used in the list of special pages, and at the top of [[Special:Checkuser]].

{{Identical|Check user}}',
	'group-checkuser-member' => '{{Identical|Check user}}',
	'right-checkuser' => '{{doc-right}}',
	'right-checkuser-log' => '{{doc-right}}',
	'checkuser-reason' => '{{Identical|Reason}}',
	'checkuser-search' => '{{Identical|Search}}',
	'checkuser-all' => '{{Identical|All}}',
	'checkuser-nomatch-edits' => '* $1 = date
* $2 = time',
	'checkuser-massblock' => '{{Identical|Block selected users}}',
	'checkuser-massblock-commit' => '{{Identical|Block selected users}}',
	'checkuser-block-success' => '* $1 is a list of one or more usernames
* $2 is the number of usernames in $1.',
	'checkuser-search-submit' => '{{Identical|Search}}',
	'checkuser-search-initiator' => "This is shown on the log page of [[Special:CheckUser]]. Initiator means CheckUser who check someone's information.",
	'checkuser-ipeditcount' => "This information is shown on the result page of [[mw:Extension:CheckUser|Special:CheckUser]] (when doing the ''{{int:Checkuser-users}}'' check), next to the individual listed IPs. It shows an estimate of the total number of edits from the respective IP (i.e. the number of edits by all users, not only by the requested user). As the comment in the code says: ''If we get some results, it helps to know if the IP in general has a lot more edits, e.g. “tip of the iceberg”…''",
	'checkuser-limited' => 'A message shown above CheckUser results if the result list would be longer than the specified limit (5000 entries), and has been truncated.',
	'checkuser-log-userips' => 'This is an entry in the checkuser log when a checkuser checks from which IP addresses a user has edited.
* Parameter $1 is the user who did the check
* Parameter $2 is the user that was checked, with links to talk page, contributions, and block (like this: [[User:Username|Username]] ( [[User talk|Talk]] | [[Special:Contributions/Username|contribs]] | [[Special:Blockip|block]]) )',
	'checkuser-log-ipedits' => 'This is an entry in the checkuser log when a checkuser checks which edits have been done from an IP address.
* Parameter $1 is the user who did the check
* Parameter $2 is the IP address that was checked',
	'checkuser-log-ipusers' => 'This is an entry in the checkuser log when a checkuser checks which users have used an IP address.
*Parameter $1 is the user who did the check
*Parameter $2 is the IP address',
	'checkuser-log-ipedits-xff' => 'This is an entry in the checkuser log when a checkuser checks which edits have been done from an XFF IP address (XFF means X-Forwarded-For. Some providers use proxies to forward user requests. This effectively means anonymization of requests. To make the requesting user identifiable again, the original requesting IP is transmitted in a separate HTTP header, the XFF header.).
* Parameter $1 is the user who did the check
* Parameter $2 is the IP address that was checked',
	'checkuser-log-ipusers-xff' => 'This is an entry in the checkuser log when a checkuser checks which users have used an XFF IP address (XFF means X-Forwarded-For. Some providers use proxies to forward user requests. This effectively means anonymization of requests. To make the requesting user identifiable again, the original requesting IP is transmitted in a separate HTTP header, the XFF header.).
*Parameter $1 is the user who did the check
*Parameter $2 is the IP address',
	'checkuser-autocreate-action' => 'Text of the event displayed in the CheckUser results, corresponding to the automatic creation of a new user account (by CentralAuth).',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'checkuser-search' => 'Ečindy',
	'checkuser-search-submit' => 'Ečči',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'checkuser-reason' => 'Kakano',
	'checkuser-search' => 'Kumi',
	'checkuser-search-submit' => 'Kumi',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'checkuser-logcase' => 'Die logboek soek-funksie is kassensitief.',
	'checkuser' => 'Kontroleer gebruiker',
	'group-checkuser' => 'Kontroleer gebruikers',
	'group-checkuser-member' => 'Kontroleer gebruiker',
	'right-checkuser' => 'Besigtig gebruikers se IP-adresse en ander gegewens',
	'checkuser-reason' => 'Rede',
	'checkuser-showlog' => 'Wys logboek',
	'checkuser-target' => 'Gebruiker of IP',
	'checkuser-users' => 'Kry gebruikers',
	'checkuser-edits' => 'Kry wysigings vanaf IP',
	'checkuser-ips' => 'Kry IPs',
	'checkuser-search' => 'Soek',
	'checkuser-empty' => 'Die logboek het geen inskrywings nie.',
	'checkuser-nomatch' => 'Geen resultate gevind.',
	'checkuser-check' => 'Kontroleer',
	'checkuser-log-fail' => 'Kan nie logboek inskrywing byvoeg nie',
	'checkuser-nolog' => 'Logboek lêer nie gevind.',
	'checkuser-blocked' => 'Versper',
	'checkuser-search-submit' => 'Soek',
	'checkuser-search-target' => 'teiken',
	'checkuser-log-subpage' => 'Logboek',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'checkuser-reason' => 'ምክንያት:',
	'checkuser-search' => 'ፍለጋ',
	'checkuser-all' => 'ሁሉ',
	'checkuser-search-submit' => 'ፍለጋ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'checkuser-summary' => "Ista aina repasa os zaguers cambeos ta mirar as IPs usatas por un usuario u amostrar as edizions y datos d'usuario ta una adreza IP. Os usuarios y edizions feitos por un cliente IP pueden trobar-se por meyo de cabezeras XFF adibindo a IP con \"/xff\". Se da soporte á IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128).
No s'otendrán más de 5000 edizions por razons de prestazions. Faiga serbir ista aina d'alcuerdo con as politicas d'o procheuto.",
	'checkuser-desc' => "Conzede á os usuarios con o premiso adecuau a capazidat ta comprebar as adrezas IP d'os usuarios y atras informazions",
	'checkuser-logcase' => 'En mirar os rechistros se fa destinzión entre mayusclas y minusclas.',
	'checkuser' => "Comprebazión d'usuarios",
	'group-checkuser' => "Comprebadors d'usuarios",
	'group-checkuser-member' => "Comprebador d'usuarios",
	'right-checkuser' => "Comprebar as adrezas IP de l'usuario y atras informazions",
	'right-checkuser-log' => "Beyer o rechistro de comprebazión d'usuarios",
	'grouppage-checkuser' => "{{ns:project}}:comprebazión d'usuarios",
	'checkuser-reason' => 'Razón:',
	'checkuser-showlog' => 'Amostrar o rechistro',
	'checkuser-log' => "Rechistro de CheckUser (comprebazión d'usuarios)",
	'checkuser-query' => 'Mirar en os zaguers cambeos',
	'checkuser-target' => 'Usuario u adreza IP',
	'checkuser-users' => "Otener os nombres d'usuario",
	'checkuser-edits' => 'Otener as edizions dende una adreza IP',
	'checkuser-ips' => 'Otener as adrezas IP',
	'checkuser-search' => 'Mirar',
	'checkuser-empty' => 'No bi ha garra elemento en o rechistro.',
	'checkuser-nomatch' => "No s'ha trobato garra concordanzia",
	'checkuser-check' => 'Comprebar',
	'checkuser-log-fail' => "No s'ha puesto adibir ista dentrada ta o rechistro",
	'checkuser-nolog' => "No s'ha trobato garra archibo de rechistro.",
	'checkuser-blocked' => 'Bloqueyato',
	'checkuser-too-many' => 'Bi ha masiaus resultaus. Por fabor, faiga más estreito o CIDR. Aquí bi son as adrezas IP emplegatas (masimo 5000, ordenatas por  adreza):',
	'checkuser-user-nonexistent' => 'O usuario espezificato no esiste.',
	'checkuser-search-form' => "Trobar dentradas d'o rechistro an que o $1 sía $2",
	'checkuser-search-submit' => 'Mirar',
	'checkuser-search-initiator' => "o enzetador d'a consulta",
	'checkuser-search-target' => 'obchetibo',
	'checkuser-ipeditcount' => '~$1 de toz os usuarios',
	'checkuser-log-subpage' => 'Rechistro',
	'checkuser-log-return' => "Tornar ta o formulario prenzipal de CheckUser (Comprebazión d'usuarios)",
	'checkuser-log-userips' => '$1 ha consultato as adrezas IP de $2',
	'checkuser-log-ipedits' => '$1 ha consultato as edizions de $2',
	'checkuser-log-ipusers' => "$1 ha consultato os nombres d'usuario de $2",
	'checkuser-log-ipedits-xff' => "$1 ha consultato as edizions d'o XFF $2",
	'checkuser-log-ipusers-xff' => "$1 ha consultato os nombres d'usuario d'o XFF $2",
);

/** Old English (Anglo-Saxon) */
$messages['ang'] = array(
	'checkuser-reason' => 'Racu',
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author Mido
 */
$messages['ar'] = array(
	'checkuser-summary' => 'هذه الأداة تفحص أحدث التغييرات لاسترجاع الأيبيهات المستخدمة بواسطة مستخدم أو عرض بيانات التعديل/المستخدم لأيبي.
المستخدمون والتعديلات بواسطة أيبي عميل يمكن استرجاعها من خلال عناوين XFF عبر طرق الأيبي IP ب"/xff". IPv4 (CIDR 16-32) و IPv6 (CIDR 64-128) مدعومان.
	لا أكثر من 5000 تعديل سيتم عرضها لأسباب تتعلق بالأداء.
استخدم هذا بالتوافق مع السياسة.',
	'checkuser-desc' => 'يمنح المستخدمين بالسماح المطلوب القدرة على فحص عناوين الأيبي لمستخدم ما ومعلومات أخرى',
	'checkuser-logcase' => 'بحث السجل حساس لحالة الحروف.',
	'checkuser' => 'تدقيق مستخدم',
	'group-checkuser' => 'مدققو مستخدم',
	'group-checkuser-member' => 'مدقق مستخدم',
	'right-checkuser' => 'التحقق من عناوين الأيبي للمستخدمين ومعلومات أخرى',
	'right-checkuser-log' => 'رؤية سجل تدقيق المستخدم',
	'grouppage-checkuser' => '{{ns:project}}:تدقيق مستخدم',
	'checkuser-reason' => 'السبب:',
	'checkuser-showlog' => 'عرض السجل',
	'checkuser-log' => 'سجل تدقيق المستخدم',
	'checkuser-query' => 'فحص أحدث التغييرات',
	'checkuser-target' => 'مستخدم أو عنوان أيبي',
	'checkuser-users' => 'عرض المستخدمين',
	'checkuser-edits' => 'عرض التعديلات من الأيبي',
	'checkuser-ips' => 'عرض الأيبيهات',
	'checkuser-account' => 'الحصول على تعديلات الحساب',
	'checkuser-search' => 'بحث',
	'checkuser-period' => 'المدة:',
	'checkuser-week-1' => 'آخر أسبوع',
	'checkuser-week-2' => 'آخر أسبوعين',
	'checkuser-month' => 'آخر 30 يوم',
	'checkuser-all' => 'الكل',
	'checkuser-empty' => 'لا توجد مدخلات في السجل.',
	'checkuser-nomatch' => 'لم يتم العثور على مدخلات مطابقة.',
	'checkuser-nomatch-edits' => 'لا تطابق تم العثور عليه.
آخر تعديل كان في $1 الساعة $2.',
	'checkuser-check' => 'فحص',
	'checkuser-log-fail' => 'غير قادر على إضافة مدخلة للسجل',
	'checkuser-nolog' => 'لم يتم العثور على ملف سجل.',
	'checkuser-blocked' => 'ممنوع',
	'checkuser-gblocked' => 'ممنوع منعا عاما',
	'checkuser-locked' => 'مغلق',
	'checkuser-wasblocked' => 'تم منعه مسبقا',
	'checkuser-localonly' => 'غير موحد',
	'checkuser-massblock' => 'امنع المستخدمين المختارين',
	'checkuser-massblock-text' => 'الحسابات المختارة سيتم منعها لا نهائيا، مع تفعيل المنع التلقائي وتعطيل إنشاء الحسابات.
عناوين الأيبي سيتم منعها لمدة 1 أسبوع لمستخدمي الأيبي فقط ومع تعطيل إنشاء الحسابات.',
	'checkuser-blocktag' => 'استبدل صفحات المستخدمين ب:',
	'checkuser-blocktag-talk' => 'استبدل صفحات النقاش ب:',
	'checkuser-massblock-commit' => 'منع المستخدمين المختارين',
	'checkuser-block-success' => "'''{{PLURAL:$2|المستخدم|المستخدمون}} $1 الآن {{PLURAL:$2|ممنوع|ممنوعون}}.'''",
	'checkuser-block-failure' => "'''لا مستخدمون تم منعهم.'''",
	'checkuser-block-limit' => 'تم اختيار عدد كبير من المستخدمين.',
	'checkuser-block-noreason' => 'يجب أن تعطي سببا لعمليات المنع.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|حساب|حساب}} جديد',
	'checkuser-too-many' => 'نتائج كثيرة جدا، من فضلك قلل الCIDR.
هذه هي الأيبيهات المستخدمة (5000 كحد أقصى، مرتبة بالعنوان):',
	'checkuser-user-nonexistent' => 'المستخدم المحدد غير موجود.',
	'checkuser-search-form' => 'اعثر على مدخلات السجل حيث $1 هو $2',
	'checkuser-search-submit' => 'بحث',
	'checkuser-search-initiator' => 'بادىء',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 من كل المستخدمين',
	'checkuser-log-subpage' => 'سجل',
	'checkuser-log-return' => 'ارجع إلى استمارة تدقيق المستخدم الرئيسية',
	'checkuser-limited' => "'''هذه النتائج تم اختصارها لأسباب تتعلق بالأداء.'''",
	'checkuser-log-userips' => '$1 حصل على الأيبيهات ل $2',
	'checkuser-log-ipedits' => '$1 حصل على التعديلات ل $2',
	'checkuser-log-ipusers' => '$1 حصل على المستخدمين ل $2',
	'checkuser-log-ipedits-xff' => '$1 حصل على التعديلات للإكس إف إف $2',
	'checkuser-log-ipusers-xff' => '$1 حصل على المستخدمين للإكس إف إف $2',
	'checkuser-log-useredits' => '$1 حصل على التعديلات ل$2',
	'checkuser-autocreate-action' => 'تم إنشاؤه تلقائيا',
	'checkuser-email-action' => 'أرسل بريدا إلكترونيا إلى "$1"',
	'checkuser-reset-action' => 'أعد ضبط كلمة السر للمستخدم "$1"',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'checkuser-summary' => 'الوسيلة دى بتدور فى احدث التغييرات علشان ترجع الايبيهات اللى استعملها يوزر او علشان تعرض بيانات التعديل/اليوزر لعنوان الاى بي.
اليوزرز و التعديلات اللى اتعملت من أى بى عميل ممكن تترجع عن طريق عناوين XFF لو زودت على الاى بى "/xff". 
IPv4 (CIDR 16-32) و IPv6 (CIDR 64-128) مدعومين.
مش اكتر من 5000 تعديل ممكن تتعرض بسبب الاداء.
استخدم دا بطريقة موافقة للسياسة.',
	'checkuser-desc' => 'بيدى لليوزرز بعد الاذن المناسب القدرة على التشييك على  عنوان الاى بى بتاع اى يوزر و معلومات تانية',
	'checkuser-logcase' => 'التدوير فى السجل حساس لحالة الحروف',
	'checkuser' => 'التشييك على اليوزر',
	'group-checkuser' => 'التشييك على اليوزرز',
	'group-checkuser-member' => 'تشييك اليوزر',
	'right-checkuser' => 'التشييك على عناوين الاى بى لليوزرز و معلومات تانية',
	'right-checkuser-log' => 'اعرض السجل بتاع تشييك اليوزر',
	'grouppage-checkuser' => '{{ns:project}}:تشييك اليوزر',
	'checkuser-reason' => 'السبب:',
	'checkuser-showlog' => 'عرض السجل',
	'checkuser-log' => 'سجل تشييك اليوزر',
	'checkuser-query' => 'دور على احدث التغييرات',
	'checkuser-target' => 'يوزر او اى بي',
	'checkuser-users' => 'هات اليوزرز',
	'checkuser-edits' => 'هات التعديلات من الاى بي',
	'checkuser-ips' => 'هات الايبيهات',
	'checkuser-account' => 'هات تعديلات الحساب',
	'checkuser-search' => 'تدوير',
	'checkuser-period' => 'المدة:',
	'checkuser-week-1' => 'الاسبوع اللى فات',
	'checkuser-week-2' => 'الاسبوعين اللى فاتو',
	'checkuser-month' => 'الـ30 يوم اللى فاتو',
	'checkuser-all' => 'الكل',
	'checkuser-empty' => 'مافيش حاجة فى السجل.',
	'checkuser-nomatch' => 'مافيش اى حاجة متطابقة',
	'checkuser-nomatch-edits' => 'لا تطابق تم العثور عليه.
آخر تعديل كان فى $1 الساعة $2.',
	'checkuser-check' => 'فحص',
	'checkuser-log-fail' => 'مش قادر يضيف مدخلة للسجل',
	'checkuser-nolog' => 'سجل الملف ماتلقاش.',
	'checkuser-blocked' => 'ممنوع',
	'checkuser-gblocked' => 'ممنوع منعا عاما',
	'checkuser-locked' => 'مغلق',
	'checkuser-wasblocked' => 'اتمنع قبل كدا',
	'checkuser-localonly' => 'مش متوحد',
	'checkuser-massblock' => 'امنع اليوزرز اللى اخترتهم.',
	'checkuser-massblock-text' => 'الحسابات اللى انت اختارتها ح يتمنعو على طول،مش ح يقدرو يفتحو حسابات و ح يتمنعو اوتوماتيكي.
عناوين الاى بى ح تتمنع لمدة اسبوع واحد بالنسبة للى بيستعملو الاى بى و مش ح يقدرو يفتحو حسابات.',
	'checkuser-blocktag' => 'بدل صفحات اليوزرز بـ:',
	'checkuser-blocktag-talk' => 'بدل صفحة النقاش ب',
	'checkuser-massblock-commit' => 'امنع اليوزرز اللى اخترتهم',
	'checkuser-block-success' => "'''الـ {{PLURAL:$2|يوزر|يوزرز}} $1 {{PLURAL:$2|بقى ممنوع|بقو ممنوعين}} دلوقتي.'''",
	'checkuser-block-failure' => "'''مافيش يوزرز ممنوعين'''",
	'checkuser-block-limit' => 'انت اخترت يوزرز كتار جدا.',
	'checkuser-block-noreason' => 'لازم تدى سبب لعمليات المنع.',
	'checkuser-accounts' => '$1 جديد {{PLURAL:$1|حساب|حسابات}}',
	'checkuser-too-many' => 'فى نتايج كتيرة جدا, لو سمحت تقلل الـ CIDR.
دول الايبيهات المستعملة (5000 كحد اقصى, مترتبين بالعنوان):',
	'checkuser-user-nonexistent' => 'اليوزر المتحدد مش موجود',
	'checkuser-search-form' => 'لاقى مدخلات السجل لما يكون $1 هو $2',
	'checkuser-search-submit' => 'تدوير',
	'checkuser-search-initiator' => 'البادي',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 من كل اليوزرز',
	'checkuser-log-subpage' => 'سجل',
	'checkuser-log-return' => 'ارجع للاستمارة الرئيسية بتاعة تشييك اليوزرز',
	'checkuser-limited' => "''' النتايج دى اتعملها اختصار لأسباب متعلقة  بالأداء.'''",
	'checkuser-log-userips' => '$1 جاب الاى بى بتوع $2',
	'checkuser-log-ipedits' => '$1 جاب التعديلات بتاعة $2',
	'checkuser-log-ipusers' => '$1 جاب اليوزرز بتوع $2',
	'checkuser-log-ipedits-xff' => '$1 جاب التعديلات للإكس إف إف $2',
	'checkuser-log-ipusers-xff' => '$1 جاب اليوزرز  لل اكس اف اف بتوع $2',
	'checkuser-log-useredits' => '$1 جاب التعديلات بتاعة$2',
	'checkuser-autocreate-action' => 'ابتدا اوتوماتيكى',
	'checkuser-email-action' => 'ابعت ايميل لليوزر "$1"',
	'checkuser-reset-action' => 'اضبط من تانى الباسورد بتاعة اليوزر "$1"',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 */
$messages['as'] = array(
	'checkuser-search' => 'সন্ধান কৰক',
	'checkuser-search-submit' => 'সন্ধান কৰক',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'checkuser-summary' => "Esta ferramienta escanea los cambeos recientes pa obtener les IP usaes por un usuariu o p'amosar les ediciones o usuarios d'una IP.
	Los usuarios y ediciones correspondientes a una IP puen obtenese per aciu de les cabeceres XFF añadiendo depués de la IP \\\"/xff\\\". Puen usase los protocolos IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128).
	Por razones de rendimientu nun s'amosarán más de 5.000 ediciones. Emplega esta ferramienta  acordies cola política d'usu.",
	'checkuser-desc' => "Permite a los usuarios colos permisos afechiscos la posibilidá de comprobar les direiciones IP d'usuarios y otres informaciones",
	'checkuser-logcase' => 'La busca nel rexistru distingue ente mayúscules y minúscules.',
	'checkuser' => "Comprobador d'usuariu",
	'group-checkuser' => "Comprobadores d'usuariu",
	'group-checkuser-member' => "comprobador d'usuariu",
	'right-checkuser' => "Comprueba les direiciones IP d'un usuariu entre otres coses",
	'right-checkuser-log' => "Ver el rexistru de comprobación d'usuarios",
	'grouppage-checkuser' => "{{ns:project}}:Comprobador d'usuariu",
	'checkuser-reason' => 'Motivu:',
	'checkuser-showlog' => 'Amosar el rexistru',
	'checkuser-log' => "Rexistru de comprobadores d'usuariu",
	'checkuser-query' => 'Buscar nos cambeos recientes',
	'checkuser-target' => 'Usuariu o IP',
	'checkuser-users' => 'Obtener usuarios',
	'checkuser-edits' => 'Obtener les ediciones de la IP',
	'checkuser-ips' => 'Obtener les IP',
	'checkuser-account' => "Obtener les ediciones d'una cuenta",
	'checkuser-search' => 'Buscar',
	'checkuser-period' => 'Duración:',
	'checkuser-week-1' => 'cabera selmana',
	'checkuser-week-2' => 'caberes dos selmanes',
	'checkuser-month' => 'caberos 30 díes',
	'checkuser-all' => 'too',
	'checkuser-empty' => 'El rexistru nun tien nengún elementu.',
	'checkuser-nomatch' => "Nun s'atoparon coincidencies.",
	'checkuser-nomatch-edits' => "Nun s'atoparon coincidencies. La cabera edición foi en $1.",
	'checkuser-check' => 'Comprobar',
	'checkuser-log-fail' => 'Nun se pue añader la entrada nel rexistru',
	'checkuser-nolog' => "Nun s'atopó l'archivu del rexistru.",
	'checkuser-blocked' => 'Bloquiáu',
	'checkuser-gblocked' => 'Bloquiáu globalmente',
	'checkuser-locked' => 'Candáu',
	'checkuser-wasblocked' => 'Bloquiáu previamente',
	'checkuser-massblock' => 'Bloquias usuarios seleicionaos',
	'checkuser-massblock-text' => 'Les cuentes seleicionaes van se bloquiaes de forma indefinida, col autobloquéu activáu y la creación de cuentes desactivada.
Les direiciones IP van ser bloquiaes 1 selmana namái pa usuarios IP y cola creación de cuentes desactivada.',
	'checkuser-blocktag' => "Sustituyir páxines d'usuariu con:",
	'checkuser-massblock-commit' => 'Bloquiar usuarios seleicionaos',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'usuariu|Los usuarios}} $1 yá {{PLURAL:$2|ta bloquiáu.|tán bloquiaos.}}'''",
	'checkuser-block-failure' => "'''Nengún usuariu bloquiáu.'''",
	'checkuser-block-limit' => 'Demasiaos usuarios seleicionaos.',
	'checkuser-block-noreason' => 'Tienes que dar un motivu pa los bloqueos.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cuenta nueva|cuentes nueves}}',
	'checkuser-too-many' => 'Demasiaos resultaos, por favor mengua la CIDR. Estes son les IP usaes (5.000 como máximo, ordenaes por direición):',
	'checkuser-user-nonexistent' => "L'usuariu especificáu nun esiste.",
	'checkuser-search-form' => 'Atopar les entraes de rexistru onde $1 ye $2',
	'checkuser-search-submit' => 'Buscar',
	'checkuser-search-initiator' => 'aniciador',
	'checkuser-search-target' => 'oxetivu',
	'checkuser-ipeditcount' => '~$1 de tolos usuarios',
	'checkuser-log-subpage' => 'Rexistru',
	'checkuser-log-return' => "Volver al formulariu principal de comprobador d'usuariu",
	'checkuser-limited' => "'''Estos resultaos fueron truncaos por motivos de rendimientu.'''",
	'checkuser-log-userips' => '$1 obtuvo les IP pa $2',
	'checkuser-log-ipedits' => '$1 obtuvo les ediciones pa $2',
	'checkuser-log-ipusers' => '$1 obtuvo los usuarios pa $2',
	'checkuser-log-ipedits-xff' => '$1 obtuvo les ediciones pa XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obtuvo los usuarios pa XFF $2',
	'checkuser-log-useredits' => '$1 obtuvo les ediciones de $2',
	'checkuser-autocreate-action' => 'creóse automáticamente',
	'checkuser-email-action' => 'unvió un corréu electrónicu a "$1"',
	'checkuser-reset-action' => 'restableció la clave pal usuariu "$1"',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'checkuser' => 'Stujera va favesik',
	'group-checkuser' => 'Stujera va favesik',
	'group-checkuser-member' => 'Stujera va favesik',
	'grouppage-checkuser' => '{{ns:project}}:Stujera va favesik',
	'checkuser-reason' => 'Lazava',
	'checkuser-showlog' => 'Nedira va "log"',
	'checkuser-target' => 'Favesik ok IP mane',
	'checkuser-search' => 'Aneyara',
	'checkuser-empty' => '"Log" iyeltak tir vlardaf.',
	'checkuser-nomatch' => 'Nedoy trasiks',
	'checkuser-check' => 'Stujera',
	'checkuser-nolog' => 'Mek trasiyin "log" iyeltak.',
	'checkuser-blocked' => 'Elekan',
	'checkuser-search-submit' => 'Aneyara',
	'checkuser-search-target' => 'jala',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'checkuser-desc' => 'کاربرانء اجازت دن  گون مناسبین اجازت آدرسان آی پی یک کاربری و دگه اطلاعاتء کنترل بکنت',
	'checkuser-logcase' => 'گردگ ته آمار به الفبای هورد و مزنین حساسنت.',
	'checkuser' => 'کنترل کاربر',
	'group-checkuser' => 'کنترل کابران',
	'group-checkuser-member' => 'کنترل کاربر',
	'right-checkuser' => 'کنترل کن آی پی کاربران و دگه اطلاعاتء',
	'grouppage-checkuser' => '{{ns:project}}:کنترل کاربر',
	'checkuser-reason' => 'دلیل',
	'checkuser-showlog' => 'آمار پیش دار',
	'checkuser-log' => 'آمار کنترل کاربر',
	'checkuser-query' => 'درخواست نوکین تغییرات',
	'checkuser-target' => 'کاربر یا آی پی',
	'checkuser-users' => 'بگر کابرانء',
	'checkuser-edits' => 'چه آی پی آن اصلاح بگر',
	'checkuser-ips' => 'آی پی آن گر',
	'checkuser-search' => 'گردگ',
	'checkuser-empty' => 'آمار شمال هچ آیتمی نهنت.',
	'checkuser-nomatch' => 'هچ همدابی در نکپت',
	'checkuser-check' => 'کنترل',
	'checkuser-log-fail' => 'نه تونی ورودی آمار اضافه کنت',
	'checkuser-nolog' => 'فایل آماری در نه کپت',
	'checkuser-blocked' => 'محدود',
	'checkuser-too-many' => 'بازگین نتیجه, لطفا CIDR هورد تر کن.
ادان آی پی آنی هستند که استفاده کننت(5000 ماکسیمم، گون آدرس ردیف بوتگن):',
	'checkuser-user-nonexistent' => 'مشخص بوتگین کاربر موجود نهنت',
	'checkuser-search-form' => 'دیرگیز آمار ورودی جاهی که  $1 هست  $2',
	'checkuser-search-submit' => 'گردگ',
	'checkuser-search-initiator' => 'شروع کنوک',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 چه کلی کابران',
	'checkuser-log-subpage' => 'آمار',
	'checkuser-log-return' => 'په فرم اصلی کنترل کاربر تر',
	'checkuser-log-userips' => '$1 گریت آی پی په $2',
	'checkuser-log-ipedits' => '$1 گریت اصلاح په  $2',
	'checkuser-log-ipusers' => '$1 کابران گریت په $2',
	'checkuser-log-ipedits-xff' => '$1 اصلاح کنت په XFF $2',
	'checkuser-log-ipusers-xff' => '$1 گریت کابران په XFF $2',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'checkuser-reason' => 'Rasón',
	'checkuser-showlog' => 'Ipahiling an mga historial',
	'checkuser-target' => 'Parágamit o IP',
	'checkuser-users' => 'Kûanón',
	'checkuser-ips' => 'Kûanón an mga IP',
	'checkuser-search' => 'Hanápon',
	'checkuser-blocked' => 'Pigbágat',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'checkuser-summary' => 'Гэты інструмэнт праглядае апошнія зьмены для атрыманьня ІР-адрасоў удзельніка альбо паказвае рэдагаваньні/зьвесткі ўдзельніка па ІР-адрасе.
Удзельнікі і рэдагаваньні, якія рабіліся з ІР-адрасу, пазначаным ў загалоўках XFF, можна атрымаць, дадаўшы да ІР-адрасу «/xff». Падтрымліваюцца IPv4 (CIDR 16-32) і IPv6 (CIDR 64-128).
З прычыны прадукцыйнасьці будуць паказаны ня больш за 5000 рэдагаваньняў.
Карыстайцеся гэтым інструмэнтам толькі згодна з правіламі.',
	'checkuser-desc' => 'Даць магчымасьць удзельнікам з адпаведнымі правамі правяраць ІР-адрасы і іншую інфармацыю ўдзельнікаў',
	'checkuser-logcase' => 'Пошук у журнале залежыць ад велічыні літар.',
	'checkuser' => 'Праверыць удзельніка',
	'group-checkuser' => 'Правяраючыя ўдзельнікаў',
	'group-checkuser-member' => 'правяраючы ўдзельнікаў',
	'right-checkuser' => 'Праверка ІР-адрасоў і іншай інфармацыі ўдзельніка',
	'right-checkuser-log' => 'Прагляд журнала праверкі ўдзельнікаў',
	'grouppage-checkuser' => '{{ns:project}}:Праверка ўдзельнікаў',
	'checkuser-reason' => 'Прычына:',
	'checkuser-showlog' => 'Паказаць журнал',
	'checkuser-log' => 'Журнал праверак удзельнікаў',
	'checkuser-query' => 'Запытаць апошнія зьмены',
	'checkuser-target' => 'Рахунак удзельніка альбо IP-адрас',
	'checkuser-users' => 'Атрымаць рахункі ўдзельнікаў',
	'checkuser-edits' => 'Атрымаць рэдагаваньні, зробленыя з IP-адрасу',
	'checkuser-ips' => 'Атрымаць IP-адрасы',
	'checkuser-account' => 'Атрымаць рэдагаваньні з рахунку ўдзельніка',
	'checkuser-search' => 'Шукаць',
	'checkuser-period' => 'Працягласьць:',
	'checkuser-week-1' => 'апошні тыдзень',
	'checkuser-week-2' => 'апошнія два тыдні',
	'checkuser-month' => 'апошнія 30 дзён',
	'checkuser-all' => 'усе',
	'checkuser-empty' => 'Журнал ня ўтрымлівае запісаў.',
	'checkuser-nomatch' => 'Супадзеньні ня знойдзеныя.',
	'checkuser-nomatch-edits' => 'Супадзеньняў ня знойдзена.
Апошняе рэдагаваньне зроблена $1 у $2.',
	'checkuser-check' => 'Праверыць',
	'checkuser-log-fail' => 'Немагчыма дадаць запіс у журнал',
	'checkuser-nolog' => 'Ня знойдзены файл журнала.',
	'checkuser-blocked' => 'Заблякаваны',
	'checkuser-gblocked' => 'Заблякаваны глябальна',
	'checkuser-locked' => 'Заблякаваны',
	'checkuser-wasblocked' => 'Заблякаваны раней',
	'checkuser-localonly' => "Не аб'яднаны",
	'checkuser-massblock' => 'Заблякаваць выбраныя рахункі ўдзельнікаў',
	'checkuser-massblock-text' => 'Выбраныя рахункі будуць заблякаваны назаўсёды з аўтаматычным блякаваньнем і забаронай стварэньня новых рахункаў.
ІР-адрасы будуць заблякаваныя на 1 тыдзень для незарэгістраваных удзельнікаў з забаронай стварэньня новых рахункаў.',
	'checkuser-blocktag' => 'Замяніць старонкі ўдзельнікаў на:',
	'checkuser-blocktag-talk' => 'Замяніць старонкі гутарак удзельнікаў на:',
	'checkuser-massblock-commit' => 'Заблякаваць выбраныя рахункі ўдзельнікаў',
	'checkuser-block-success' => "'''Цяпер $2 {{PLURAL:$2|рахунак удзельніка|рахункі удзельнікаў|рахункаў удзельнікаў}} $1 {{PLURAL:$2|заблякаваны|заблякаваныя|заблякаваныя}}.'''",
	'checkuser-block-failure' => "'''Няма заблякаваных рахункаў удзельнікаў.'''",
	'checkuser-block-limit' => 'Выбрана зашмат рахункаў удзельнікаў.',
	'checkuser-block-noreason' => 'Вам неабходна пазначыць прычыну блякаваньня.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|новы рахунак|новыя рахункі|новых рахункаў}}',
	'checkuser-too-many' => 'Зашмат вынікаў, калі ласка, абмяжуйце CIDR.
Тут знаходзяцца ўжытыя ІР-адрасы (максымальна 5000, адсартаваныя па адрасе):',
	'checkuser-user-nonexistent' => 'Пазначанага рахунку ўдзельніка не існуе.',
	'checkuser-search-form' => 'Пошук запісаў у журнале, дзе $1 зьяўляецца $2',
	'checkuser-search-submit' => 'Шукаць',
	'checkuser-search-initiator' => 'ініцыятар',
	'checkuser-search-target' => 'мэта',
	'checkuser-ipeditcount' => '~$1 ад усіх удзельнікаў',
	'checkuser-log-subpage' => 'Журнал',
	'checkuser-log-return' => 'Вярнуцца да галоўнай формы праверкі ўдзельнікаў',
	'checkuser-limited' => "'''Гэты вынік быў скарочаны, з прычыны прадукцыйнасьці сыстэмы.'''",
	'checkuser-log-userips' => '$1 атрымаў IP-адрасы для $2',
	'checkuser-log-ipedits' => '$1 атрымаў рэдагаваньні для $2',
	'checkuser-log-ipusers' => '$1 атрымаў рахункі ўдзельнікаў для $2',
	'checkuser-log-ipedits-xff' => '$1 атрымаў рэдагаваньні для XFF $2',
	'checkuser-log-ipusers-xff' => '$1 атрымаў рахункі ўдзельнікаў для XFF $2',
	'checkuser-log-useredits' => '$1 атрымаў рэдагаваньні для $2',
	'checkuser-autocreate-action' => 'быў створаны аўтаматычна',
	'checkuser-email-action' => 'даслаць ліст удзельніку «$1»',
	'checkuser-reset-action' => 'скасаваў пароль для ўдзельніка «$1»',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'checkuser-summary' => 'Този инструмент сканира последните промени и извлича IP адресите, използвани от потребител или показва информацията за редакциите/потребителя за посоченото IP.
	Потребители и редакции по клиентско IP могат да бъдат извлечени чрез XFF headers като се добави IP с "/xff". Поддържат се IPv4 (CIDR 16-32) и IPv6 (CIDR 64-128).
	От съображения, свързани с производителността на уикито, ще бъдат показани не повече от 5000 редакции. Използвайте инструмента съобразно установената политика.',
	'checkuser-desc' => 'Предоставя на потребители с подходящите права възможност за проверка на потребителски IP адреси и друга информация',
	'checkuser-logcase' => 'Търсенето в дневника различава главни от малки букви.',
	'checkuser' => 'Проверяване на потребител',
	'group-checkuser' => 'Проверяващи',
	'group-checkuser-member' => 'Проверяващ',
	'right-checkuser' => 'проверяване на потребителски IP адреси и друга информация',
	'right-checkuser-log' => 'Преглеждане на дневника с проверки на потребители',
	'grouppage-checkuser' => '{{ns:project}}:Проверяващи',
	'checkuser-reason' => 'Причина',
	'checkuser-showlog' => 'Показване на дневника',
	'checkuser-log' => 'Дневник на проверяващите',
	'checkuser-query' => 'Заявка към последните промени',
	'checkuser-target' => 'Потребител или IP',
	'checkuser-users' => 'Извличане на потребители',
	'checkuser-edits' => 'Извличане на редакции от IP',
	'checkuser-ips' => 'Извличане на IP адреси',
	'checkuser-search' => 'Търсене',
	'checkuser-period' => 'Продължителност:',
	'checkuser-week-1' => 'последната седмица',
	'checkuser-week-2' => 'последните 2 седмици',
	'checkuser-month' => 'последните 30 дни',
	'checkuser-all' => 'всички',
	'checkuser-empty' => 'Дневникът не съдържа записи.',
	'checkuser-nomatch' => 'Няма открити съвпадения.',
	'checkuser-nomatch-edits' => 'Не бяха открити съвпадения.
Последната редакция е била на $1 в $2.',
	'checkuser-check' => 'Проверка',
	'checkuser-log-fail' => 'Беше невъзможно да се добави запис в дневника',
	'checkuser-nolog' => 'Не беше открит дневник.',
	'checkuser-blocked' => 'Блокиран',
	'checkuser-gblocked' => 'Глобално блокиран',
	'checkuser-massblock' => 'Блокиране на избраните потребители',
	'checkuser-blocktag' => 'Заместване на потребителските страници с:',
	'checkuser-blocktag-talk' => 'Заместване на беседите с:',
	'checkuser-massblock-commit' => 'Блокиране на избраните потребители',
	'checkuser-block-success' => "'''{{PLURAL:$2|Потребител|Потребители}} $1 {{PLURAL:$2|беше блокиран|бяха блокирани}}.'''",
	'checkuser-block-failure' => "'''Няма блокирани потребители.'''",
	'checkuser-block-limit' => 'Избрани са твърде много потребители.',
	'checkuser-block-noreason' => 'Трябва да се посочи причина за блокиранията.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|нова сметка|нови сметки}}',
	'checkuser-too-many' => 'Твърде много резултати. Показани са използваните IP адреси (най-много 5000, сортирани по адрес):',
	'checkuser-user-nonexistent' => 'Посоченият потребител не съществува.',
	'checkuser-search-form' => 'Намиране на записи от дневника, в които $1 е $2',
	'checkuser-search-submit' => 'Търсене',
	'checkuser-search-initiator' => 'инициатор',
	'checkuser-search-target' => 'цел',
	'checkuser-ipeditcount' => '~$1 от всички потребители',
	'checkuser-log-subpage' => 'Дневник',
	'checkuser-log-return' => 'Връщане към основния формуляр за проверка',
	'checkuser-log-userips' => '$1 е получил айпи адреси за $2',
	'checkuser-log-ipedits' => '$1 е получил редакции за $2',
	'checkuser-log-ipusers' => '$1 е получил потребители за $2',
	'checkuser-log-ipedits-xff' => '$1 е получил редакции за XFF $2',
	'checkuser-log-ipusers-xff' => '$1 е получил потребители за XFF $2',
	'checkuser-email-action' => 'изпрати е-писмо на потребител „$1“',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'checkuser-summary' => 'এই সরঞ্জামটি সাম্প্রতিক পরিবর্তনসমূহ বিশ্লেষণ করে কোন ব্যবহারকারীর ব্যবহৃত আইপিগুলি নিয়ে আসে কিংবা কোন একটি আইপির জন্য সম্পাদনা/ব্যবহারকারী উপাত্ত প্রদর্শন করে।
কোন ক্লায়েন্ট আইপি-র জন্য ব্যবহারকারী ও সম্পাদনা XFF হেডারসমূহের সাহায্যে নিয়ে আসা যায়; এজন্য আইপির সাথে "/xff" যোগ করতে হয়।
IPv4 (CIDR 16-32) এবং IPv6 (CIDR 64-128) এই সরঞ্জামে সমর্থিত।
দক্ষতাজনিত কারণে ৫০০০-এর বেশি সম্পাদনা নিয়ে আসা হবে না। নীতিমালা মেনে এটি ব্যবহার করুন।',
	'checkuser-desc' => 'যথাযথ অনুমোদনপ্রাপ্ত ব্যবহারকারীদেরকে অন্য ব্যবহারকারীদের আইপি ঠিকানা এবং অন্যান্য তথ্য পরীক্ষা করার ক্ষমতা দেয়',
	'checkuser-logcase' => 'লগ অনুসন্ধান বড়/ছোট হাতের অক্ষরের উপর নির্ভরশীল',
	'checkuser' => 'ব্যবহারকারী পরীক্ষণ',
	'group-checkuser' => 'ব্যবহারকারীসমূহ পরীক্ষণ',
	'group-checkuser-member' => 'ব্যবহারকারী পরীক্ষণ',
	'grouppage-checkuser' => '{{ns:project}}:ব্যবহারকারী পরীক্ষণ',
	'checkuser-reason' => 'কারণ',
	'checkuser-showlog' => 'লগ দেখাও',
	'checkuser-log' => 'CheckUser লগ',
	'checkuser-query' => 'সাম্প্রতিক পরিবর্তনসমূহ জানুন',
	'checkuser-target' => 'ব্যবহারকারী অথবা আইপি',
	'checkuser-users' => 'ব্যবহারকারী সমূহ পাওয়া যাবে',
	'checkuser-edits' => 'আইপি থেকে সম্পাদনাসমূহ পাওয়া যাবে',
	'checkuser-ips' => 'আইপি সমূহ পাওয়া যাবে',
	'checkuser-search' => 'অনুসন্ধান',
	'checkuser-empty' => 'এই লগে কিছুই নেই।',
	'checkuser-nomatch' => 'এর সাথে মিলে এমন কিছু পাওয়া যায়নি।',
	'checkuser-check' => 'পরীক্ষা করুন',
	'checkuser-log-fail' => 'লগ ভুক্তিতে যোগ করা সম্ভব হচ্ছে না',
	'checkuser-nolog' => 'কোন লগ ফাইল পাওয়া যায়নি।',
	'checkuser-blocked' => 'বাধা দেওয়া হয়েছে',
	'checkuser-too-many' => 'অত্যধিক সংখ্যক ফলাফল, অনুগ্রহ করে CIDR সীমিত করুন। নিচের আইপিগুলি ব্যবহৃত হয়েছে (সর্বোচ্চ ৫০০০, ঠিকানা অনুযায়ী বিন্যস্ত):',
	'checkuser-user-nonexistent' => 'এই নির্দিষ্ট ব্যবহারকারী নেই।',
	'checkuser-search-form' => 'এমনসব লগ ভুক্তি খুঁজে বের করুন যেখানে $1 হল $2',
	'checkuser-search-submit' => 'অনুসন্ধান',
	'checkuser-search-initiator' => 'আরম্ভকারী',
	'checkuser-search-target' => 'লক্ষ্য',
	'checkuser-ipeditcount' => '~$1 সমস্ত ব্যবহাকারী থেকে',
	'checkuser-log-subpage' => 'লগ',
	'checkuser-log-return' => 'CheckUser মূল ফর্মে ফেরত যান',
	'checkuser-log-userips' => '$2 এর জন্য $1 আইপি  সমূহ পেয়েছে',
	'checkuser-log-ipedits' => '$2 এর জন্য $1 সম্পাদনাসমূহ পেয়েছে',
	'checkuser-log-ipusers' => '$2 এর জন্য $1 ব্যবহারকারীসমূহ পেয়েছে',
	'checkuser-log-ipedits-xff' => '$2 এর জন্য XFF $1 সম্পাদনাসমূহ পেয়েছে',
	'checkuser-log-ipusers-xff' => '$2 এর জন্য XFF $1 ব্যবহারকারীসমূহ পেয়েছে',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'checkuser-summary' => "Furchal a ra an ostilh-mañ ar c'hemmoù diwezhañ a-benn klask ar chomlec'h IP implijet gant un implijer bennak, diskouez a ra holl degasadennoù ur chomlec'h IP (ha pa vefe bet enrollet), pe roll ar c'hontoù implijet gant ur chomlec'h IP. Gallout a ra ar c'hontoù hag ar c'hemmoù bezañ kavet gant un IP XFF mard echu gant \"/xff\". Posupl eo implijout ar protokoloù IPv4 (CIDR 16-32) hag IPv6 (CIDR 64-128). Bevennet eo an niver a gemmoù a c'haller lakaat war wel da {{formatnum:5000}} evit abegoù nerzh ar servijer. Grit gant an ostilh-mañ en ur zoujañ d'ar garta implijout.",
	'checkuser-desc' => "Reiñ a ra an tu d'an dud aotreet evit se da wiriañ chomlec'hioù IP an implijerien ha da gaout titouroù all",
	'checkuser-logcase' => "Kizidik eo ar c'hlask er marilh ouzh an direnneg (pennlizherennoù/lizherennoù munud)",
	'checkuser' => 'Gwiriañ an implijer',
	'group-checkuser' => 'Gwiriañ an implijerien',
	'group-checkuser-member' => 'Gwiriañ an implijer',
	'grouppage-checkuser' => '{{ns:project}}:Gwiriañ an implijer',
	'checkuser-reason' => 'Abeg',
	'checkuser-showlog' => 'Diskouez ar marilh',
	'checkuser-log' => 'Marilh kontrolliñ an implijerien',
	'checkuser-query' => "Klask dre ar c'hemmoù diwezhañ",
	'checkuser-target' => 'Implijer pe IP',
	'checkuser-users' => 'Kavout an implijerien',
	'checkuser-edits' => "Kavout degasadennoù ar chomlec'h IP",
	'checkuser-ips' => "Kavout ar chomlec'hioù IP",
	'checkuser-search' => 'Klask',
	'checkuser-empty' => "N'eus pennad ebet er marilh",
	'checkuser-nomatch' => "N'eus bet kavet netra.",
	'checkuser-check' => 'Gwiriañ',
	'checkuser-log-fail' => "Dibosupl ouzhpennañ ar moned d'ar marilh",
	'checkuser-nolog' => 'Restr ebet er marilh',
	'checkuser-blocked' => 'Stanket',
	'checkuser-too-many' => "Re a zisoc'hoù, strishaat ar CIDR mar plij.
Setu an IPoù implijet (5000 d'ar muiañ, urzhiet dre ar chomlec'h)",
	'checkuser-user-nonexistent' => "N'eus ket eus an implijer merket",
	'checkuser-search-form' => "Kavout marilh ar monedoù m'eo $1 evit $2",
	'checkuser-search-submit' => 'Klask',
	'checkuser-search-initiator' => 'deraouer',
	'checkuser-search-target' => 'pal',
	'checkuser-log-subpage' => 'Marilh',
	'checkuser-log-return' => "Distreiñ da furmskrid pennañ ar c'hontrolliñ implijerien",
	'checkuser-log-userips' => '$1 en deus kavet IPoù evit $2',
	'checkuser-log-ipedits' => '$1 en deus kavet kemmoù evit $2',
	'checkuser-log-ipusers' => '$1 en deus kavet implijerien evit $2',
	'checkuser-log-ipedits-xff' => '$1 en deus kavet kemmoù evit $2 dre XFF',
	'checkuser-log-ipusers-xff' => 'Kavet en deus $1 implijerien $2 dre XFF',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'checkuser-summary' => 'Ovaj alat skenira nedavne promjene te vraća IP adrese koje koriste korisnici ili prikazuje podatke o izmjenama i korisnicima za pojedinu IP adresu.
Korisnici i izmjene nekog IP klijenta mogu biti nađene preko XFF zaglavlja uz primjenu oznake "/xff" pored IP-a. Podržani su i IPv4 (CIDR 16-32) i IPv6 (CIDR 64-128).
Zbog boljih performansi, neće biti prikazano više od 5000 izmjena.
Koristite ovo u skladu s pravilima.',
	'checkuser-desc' => 'Omogućuje korisnicima sa adekvatnim dopuštenjima sposobnost da provjeravaju korisničke IP adrese i druge podatke',
	'checkuser-logcase' => 'Pretraga zapisa razlikuje velika i mala slova.',
	'checkuser' => 'Provjera korisnika',
	'group-checkuser' => 'Provjera korisnika',
	'group-checkuser-member' => 'Provjera korisnika',
	'right-checkuser' => 'Provjera korisničkih IP adresa i drugih informacija',
	'right-checkuser-log' => 'Pregledanje zapisa provjere korisnika',
	'grouppage-checkuser' => '{{ns:project}}:Provjera korisnika',
	'checkuser-reason' => 'Razlog:',
	'checkuser-showlog' => 'Prikaži zapis',
	'checkuser-log' => 'Zapis CheckUsera',
	'checkuser-query' => 'Pretraži nedavne izmjene',
	'checkuser-target' => 'Korisnik ili IP',
	'checkuser-users' => 'Nađi korisnike',
	'checkuser-edits' => 'Nađi izmjene sa IP adrese',
	'checkuser-ips' => 'Nađi IP adrese',
	'checkuser-account' => 'Nađi izmjene računa',
	'checkuser-search' => 'Traži',
	'checkuser-period' => 'Trajanje:',
	'checkuser-week-1' => 'zadnja sedmica',
	'checkuser-week-2' => 'zadnje dvije sedmice',
	'checkuser-month' => 'zadnjih 30 dana',
	'checkuser-all' => 'sve',
	'checkuser-empty' => 'Zapis ne sadrži stavke.',
	'checkuser-nomatch' => 'Nisu nađeni traženi rezultati.',
	'checkuser-nomatch-edits' => 'Nije pronađen traženi upit.
Zadnja izmjena je bila dana $1 u $2.',
	'checkuser-check' => 'Provjeri',
	'checkuser-log-fail' => 'Nije moguće dodati stavku zapisa',
	'checkuser-nolog' => 'Nije pronađena datoteka zapisa.',
	'checkuser-blocked' => 'Blokiran',
	'checkuser-gblocked' => 'Blokiran globalno',
	'checkuser-locked' => 'Zaključano',
	'checkuser-wasblocked' => 'Ranije blokiran',
	'checkuser-localonly' => 'Nije spojeno',
	'checkuser-massblock' => 'Blokiraj odabrane korisnike',
	'checkuser-massblock-text' => 'Odabrani računi će biti neograničeno blokirani, sa omogućenom automatskom blokadom i onemogućenim pravljenjem računa.
IP adrese će biti blokirane u periodu od jedne sedmice samo za IP korisnike i sa onemogućenim pravljenjem računa.',
	'checkuser-blocktag' => 'Mijenja korisničku stranicu sa:',
	'checkuser-blocktag-talk' => 'Mijenja sadržaj stranice za razgovor sa:',
	'checkuser-massblock-commit' => 'Blokiraj odabrane korisnike',
	'checkuser-block-success' => "'''{{PLURAL:$2|Korisnik|Korisnici}} $1 {{PLURAL:$2|je sad blokiran|su sada blokirani}}.'''",
	'checkuser-block-failure' => "'''Nijedan korisnik nije blokiran.'''",
	'checkuser-block-limit' => 'Previše korisnika odabrano.',
	'checkuser-block-noreason' => 'Morate navesti razlog za blokiranje.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novi korisnik|nova korisnika|novih korisnika}}',
	'checkuser-too-many' => 'Pronađeno previše rezultata, molimo da suzite CIDR.
Ovdje su prikazane korištene IP adrese (najviše 5000, poredano po adresi):',
	'checkuser-user-nonexistent' => 'Navedeni korisnik ne postoji.',
	'checkuser-search-form' => 'Nađi stavke zapisa gdje je $1 jednako $2',
	'checkuser-search-submit' => 'Traži',
	'checkuser-search-initiator' => 'pokretač',
	'checkuser-search-target' => 'cilj',
	'checkuser-ipeditcount' => '~$1 od svih korisnika',
	'checkuser-log-subpage' => 'Zapisnik',
	'checkuser-log-return' => 'Povratak na glavni obrazac provjere korisnika',
	'checkuser-limited' => "'''Ovi rezultati su skraćeni iz razloga bolje performanse.'''",
	'checkuser-log-userips' => 'Korisnik $1 je našao IP adrese za $2',
	'checkuser-log-ipedits' => 'Korisnik $1 je našao izmjene za $2',
	'checkuser-log-ipusers' => '$1 je našao korisnike na $2',
	'checkuser-log-ipedits-xff' => '$1 je našao izmjene za XFF $2',
	'checkuser-log-ipusers-xff' => 'Korisnik $1 je našao korisnike za XFF $2',
	'checkuser-log-useredits' => '$1 nađene izmjene za $2',
	'checkuser-autocreate-action' => 'je automatski napravljen',
	'checkuser-email-action' => 'slanje e-mail korisniku "$1"',
	'checkuser-reset-action' => 'poništi šifru za korisnika "$1"',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author Juanpabl
 * @author Paucabot
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'checkuser-summary' => "Aquest instrument efectua una cerca als canvis recents per a comprovar les adreces IP fetes servir per un usuari o per a mostrar les edicions d'una certa adreça IP.
Les edicions i usuaris d'un client IP es poden obtenir via capçaleres XFF afegint /xff al final de la IP. Tant les adreces IPv4 (CIDR 16-32) com les IPv6 (CIDR 64-128) són admeses.
Per raons d'efectivitat i de memòria no es retornen més de 5000 edicions. Recordeu que aquesta eina només es pot usar d'acord amb les polítiques corresponents i amb respecte a la legislació sobre privacitat.",
	'checkuser-desc' => "Permet als usuaris amb els permisos adients l'habilitat de comprovar les adreces IP que fan servir els usuaris enregistrats.",
	'checkuser-logcase' => 'Les majúscules es tracten de manera diferenciada en la cerca dins el registre.',
	'checkuser' => "Comprova l'usuari",
	'group-checkuser' => 'Checkusers',
	'group-checkuser-member' => 'CheckUser',
	'right-checkuser' => 'Comprovar les adreces IP i altra informació dels usuaris',
	'right-checkuser-log' => 'Vegeu el registre de checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Motiu:',
	'checkuser-showlog' => 'Mostra registre',
	'checkuser-log' => 'Registre de Checkuser',
	'checkuser-query' => 'Cerca als canvis recents',
	'checkuser-target' => 'Usuari o IP',
	'checkuser-users' => 'Retorna els usuaris',
	'checkuser-edits' => 'Retorna les edicions de la IP',
	'checkuser-ips' => 'Retorna adreces IP',
	'checkuser-search' => 'Cerca',
	'checkuser-period' => 'Durada:',
	'checkuser-week-1' => 'Darrera setmana',
	'checkuser-week-2' => 'Darreres dues setmanes',
	'checkuser-month' => 'Darrers 30 dies',
	'checkuser-empty' => 'El registre no conté entrades.',
	'checkuser-nomatch' => "No s'han trobat coincidències.",
	'checkuser-check' => 'Comprova',
	'checkuser-log-fail' => "No s'ha pogut afegir al registre",
	'checkuser-nolog' => "No s'ha trobat el fitxer del registre.",
	'checkuser-blocked' => 'Blocat',
	'checkuser-wasblocked' => 'Prèviament bloquejat',
	'checkuser-massblock' => 'Bloqueja els usuaris seleccionats',
	'checkuser-blocktag' => "Canvia les pàgines d'usuari per:",
	'checkuser-massblock-commit' => 'Bloqueja usuaris seleccionats',
	'checkuser-block-limit' => 'Massa usuaris seleccionats.',
	'checkuser-block-noreason' => "Heu d'indicar un motiu pels bloquejos.",
	'checkuser-accounts' => '$1 {{PLURAL:$1|nou compte|nous comptes}}',
	'checkuser-too-many' => 'Hi ha massa resultats, cal que useu un CIDR més petit. Aquí teniu les IP usades (màx. 5000 ordenades per adreça):',
	'checkuser-user-nonexistent' => "L'usuari especificat no existeix.",
	'checkuser-search-form' => 'Cerca entrades al registre on $1 és $2',
	'checkuser-search-submit' => 'Cerca',
	'checkuser-search-initiator' => "l'iniciador",
	'checkuser-search-target' => 'el consultat',
	'checkuser-ipeditcount' => '~$1 de tots els usuaris',
	'checkuser-log-subpage' => 'Registre',
	'checkuser-log-return' => 'Retorna al formulari de CheckUser',
	'checkuser-log-userips' => '$1 consulta les IP de $2',
	'checkuser-log-ipedits' => '$1 consulta les edicions de $2',
	'checkuser-log-ipusers' => '$1 consulta els usuaris de $2',
	'checkuser-log-ipedits-xff' => '$1 consulta les edicions del XFF $2',
	'checkuser-log-ipusers-xff' => '$1 consulta els usuaris del XFF $2',
	'checkuser-autocreate-action' => 'fou automàticament creat',
	'checkuser-email-action' => 'S\'ha enviat un correu electrònic a l\'usuari "$1"',
	'checkuser-reset-action' => "reinicia la contrasenya de l'usuari «$1»",
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄) */
$messages['cdo'] = array(
	'checkuser-search' => 'Sìng-tō̤',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'checkuser-target' => 'Юзер я IP-адрес',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'checkuser-search' => 'Aligao',
	'checkuser-search-submit' => 'Aligao',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'group-checkuser' => 'Controllori',
	'group-checkuser-member' => 'Controllore',
	'grouppage-checkuser' => '{{ns:project}}:Controllori',
);

/** Czech (Česky)
 * @author Beren
 * @author Danny B.
 * @author Li-sung
 * @author Mormegil
 */
$messages['cs'] = array(
	'checkuser-summary' => 'Tento nástroj zkoumá poslední změny a umožňuje získat IP adresy uživatelů nebo zobrazit editace a uživatele z dané IP adresy.
Uživatele a editace z klientské IP adresy lze získat z hlaviček XFF přidáním „/xff“ k IP. Je podporováno  IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128).
Z výkonnostních důvodů lze zobrazit maximálně 5000 editací. Používejte tento nástroj v souladu s pravidly.',
	'checkuser-desc' => 'Poskytuje uživatelům s příslušným oprávněním možnost zjišťovat IP adresy uživatelů a další související informace',
	'checkuser-logcase' => 'Hledání v záznamech rozlišuje velikosti písmen.',
	'checkuser' => 'Kontrola uživatele',
	'group-checkuser' => 'Revizoři',
	'group-checkuser-member' => 'Revizor',
	'right-checkuser' => 'Kontrolování uživatelské IP adresy a dalších informací',
	'right-checkuser-log' => 'Prohlížení protokolovacích záznamů revize uživatelů',
	'grouppage-checkuser' => '{{ns:project}}:Revize uživatele',
	'checkuser-reason' => 'Důvod:',
	'checkuser-showlog' => 'Zobrazit záznamy',
	'checkuser-log' => 'Kniha kontroly uživatelů',
	'checkuser-query' => 'Dotaz na poslední změny',
	'checkuser-target' => 'Uživatel nebo IP',
	'checkuser-users' => 'Najít uživatele',
	'checkuser-edits' => 'Najít editace z IP',
	'checkuser-ips' => 'Najít IP adresy',
	'checkuser-account' => 'Najít editace od uživatele',
	'checkuser-search' => 'Hledat',
	'checkuser-period' => 'Období:',
	'checkuser-week-1' => 'poslední týden',
	'checkuser-week-2' => 'poslední dva týdny',
	'checkuser-month' => 'posledních 30 dní',
	'checkuser-all' => 'všechno',
	'checkuser-empty' => 'Kniha neobsahuje žádné položky',
	'checkuser-nomatch' => 'Nic odpovídajícího nebylo nalezeno.',
	'checkuser-nomatch-edits' => 'Nic odpovídajícího nebylo nalezeno. Poslední editace proběhla $2, $1.',
	'checkuser-check' => 'Zkontrolovat',
	'checkuser-log-fail' => 'Nepodařilo se zapsat do záznamů',
	'checkuser-nolog' => 'Soubor záznamů nebyl nalezen.',
	'checkuser-blocked' => 'zablokováno',
	'checkuser-gblocked' => 'globálně zablokováno',
	'checkuser-locked' => 'zamčeno',
	'checkuser-wasblocked' => 'dříve blokováno',
	'checkuser-localonly' => 'Nesjednocený',
	'checkuser-massblock' => 'Zablokovat vybrané uživatele',
	'checkuser-massblock-text' => 'Vybrané účty budou zablokovány do odvolání, se zapnutým automatickým blokováním a zákazem tvorby nových účtů. IP adresy budou zablokovány na týden, pouze pro neregistrované uživatele a se zákazem tvorby nových účtů.',
	'checkuser-blocktag' => 'Nahradit obsah uživatelských stránek textem:',
	'checkuser-blocktag-talk' => 'Nahradit obsah uživatelských diskusí textem:',
	'checkuser-massblock-commit' => 'Zablokovat vybrané uživatele',
	'checkuser-block-success' => "'''{{PLURAL:$2|Uživatel|Uživatelé}} $1 {{PLURAL:$2|je zablokován|jsou zablokováni}}.'''",
	'checkuser-block-failure' => "'''Žádný uživatel nebyl zablokován.'''",
	'checkuser-block-limit' => 'Vybráno příliš mnoho uživatelů',
	'checkuser-block-noreason' => 'Musíte zadat důvod blokování',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nový účet|nové účty|nových účtů}}',
	'checkuser-too-many' => 'Příliš mnoho výsledků, zkuste omezit CIDR. Níže jsou použité IP adresy (nejvýše 500, seřazené abecedně):',
	'checkuser-user-nonexistent' => 'Zadaný uživatel neexistuje.',
	'checkuser-search-form' => 'Hledej záznamy, kde $1 je $2',
	'checkuser-search-submit' => 'Hledat',
	'checkuser-search-initiator' => 'kontrolující',
	'checkuser-search-target' => 'kontrolováno',
	'checkuser-ipeditcount' => 'asi $1 od všech uživatelů',
	'checkuser-log-subpage' => 'Záznamy',
	'checkuser-log-return' => 'Návrat na hlavní formulář Kontroly uživatele',
	'checkuser-limited' => "'''Výsledky byly z výkonnostních důvodů zkráceny.'''",
	'checkuser-log-userips' => '$1 zjišťuje IP adresy uživatele $2',
	'checkuser-log-ipedits' => '$1 zjišťuje editace z IP $2',
	'checkuser-log-ipusers' => '$1 zjišťuje uživatele z IP $2',
	'checkuser-log-ipedits-xff' => '$1 zjišťuje editace s XFF $2',
	'checkuser-log-ipusers-xff' => '$1 zjišťuje uživatele s XFF $2',
	'checkuser-log-useredits' => '$1 zjišťuje editace od $2',
	'checkuser-autocreate-action' => 'byl automaticky vytvořen',
	'checkuser-email-action' => 'odeslal e-mail uživateli „$1“',
	'checkuser-reset-action' => 'požádal o nové heslo pro uživatele „$1“',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'checkuser-search' => 'иска́ниѥ',
	'checkuser-search-submit' => 'ищи́',
);

/** Danish (Dansk)
 * @author Amjaabc
 * @author Fredelige
 * @author Morten LJ
 */
$messages['da'] = array(
	'checkuser-summary' => 'Dette værktøj scanner Seneste ændringer for at finde IP\'er brugt af en bestemt bruger, eller for at vise redigerings- eller brugerdata for en IP.
Bruger og redigeringer fra en klient IP kan hentes via XFF headers ved at tilføje "/xff" til IP\'en. Ipv4 (CIRD 16-32) og IPv6 (CIDR 64-128) er understøttet.
For at sikre programmelets ydeevne kan maksimalt 5000 redigeringer returneres. Brug kun dette værktøj i overensstemmelse med gældende politiker på {{SITENAME}}.',
	'checkuser-desc' => 'Giver brugere med den rette godkendelse muligheden for at checke brugeres IP-adresser og anden information',
	'checkuser-logcase' => 'Logsøgning er case sensitiv (der gøres forskel på store og små bogstaver)',
	'checkuser' => 'Checkbruger',
	'group-checkuser' => 'Checkbrugere',
	'group-checkuser-member' => 'Checkbruger',
	'grouppage-checkuser' => '{{ns:project}}:Checkbruger',
	'checkuser-reason' => 'Begrundelse',
	'checkuser-showlog' => 'Vis log',
	'checkuser-log' => 'Checkbrugerlog',
	'checkuser-query' => 'Søg i seneste ændringer',
	'checkuser-target' => 'Bruger eller IP',
	'checkuser-users' => 'Hent brugere',
	'checkuser-edits' => 'Hent redigeringer fra IP',
	'checkuser-ips' => "Hent IP'er",
	'checkuser-search' => 'Søg',
	'checkuser-week-1' => 'forrige uge',
	'checkuser-week-2' => 'sidste to uger',
	'checkuser-month' => 'sidste 30 dage',
	'checkuser-all' => 'alle',
	'checkuser-empty' => 'Loggen indeholder ingen poster.',
	'checkuser-nomatch' => 'Ingen matchende resultater blev fundet.',
	'checkuser-check' => 'Check',
	'checkuser-log-fail' => 'Kunne ikke tilføje log-post',
	'checkuser-nolog' => 'Logfilen blev ikke fundet.',
	'checkuser-blocked' => 'Blokeret',
	'checkuser-gblocked' => 'Blokeret globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidligere blokeret',
	'checkuser-too-many' => "For mange resultater, gør CIDR'en smallere. Her er de brugte IP'er (max 5000, sorteret efter adresse):",
	'checkuser-user-nonexistent' => 'Den anførte bruger eksisterer ikke.',
	'checkuser-search-form' => 'Find log-poster hvor $1 er $2',
	'checkuser-search-submit' => 'Søg',
	'checkuser-search-target' => 'mål',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Gå tilbage til hovedformularen for checkbruger',
	'checkuser-log-userips' => "$1 fik IP'er for $2",
	'checkuser-log-ipedits' => '$1 fik redigeringer for $2',
	'checkuser-log-ipusers' => '$1 fik brugere for $2',
	'checkuser-log-ipedits-xff' => '$1 fik redigeringer for XFF $2',
	'checkuser-log-ipusers-xff' => '$1 fik brugere for XFF $2',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Pill
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'checkuser-summary' => 'Dieses Werkzeug durchsucht die letzten Änderungen, um die IP-Adressen eines Benutzers bzw. die Bearbeitungen/Benutzernamen für eine IP-Adresse zu ermitteln. Benutzer und Bearbeitungen einer IP-Adresse können auch nach Informationen aus den XFF-Headern abgefragt werden, indem der IP-Adresse ein „/xff“ angehängt wird. IPv4 (CIDR 16-32) und IPv6 (CIDR 64-128) werden unterstützt.
Aus Performance-Gründen werden maximal 5000 Bearbeitungen ausgegeben. Benutze CheckUser ausschließlich in Übereinstimmung mit den Datenschutzrichtlinien.',
	'checkuser-desc' => 'Erlaubt Benutzern mit den entsprechenden Rechten die IP-Adressen sowie weitere Informationen von Benutzern zu prüfen',
	'checkuser-logcase' => 'Die Suche im Logbuch unterscheidet zwischen Groß- und Kleinschreibung.',
	'checkuser' => 'Checkuser',
	'group-checkuser' => 'Checkuser',
	'group-checkuser-member' => 'Checkuser-Berechtigter',
	'right-checkuser' => 'Prüfung von IP-Adressen sowie Verbindungen zwischen IPs und angemeldeten Benutzern',
	'right-checkuser-log' => 'Ansehen des Checkuser-Logbuches',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Grund:',
	'checkuser-showlog' => 'Logbuch anzeigen',
	'checkuser-log' => 'Checkuser-Logbuch',
	'checkuser-query' => 'Letzte Änderungen abfragen',
	'checkuser-target' => 'Benutzer oder IP-Adresse',
	'checkuser-users' => 'Hole Benutzer',
	'checkuser-edits' => 'Hole Bearbeitungen von IP-Adresse',
	'checkuser-ips' => 'Hole IP-Adressen',
	'checkuser-account' => 'Hole Bearbeitungen von Benutzerkonto',
	'checkuser-search' => 'Suchen',
	'checkuser-period' => 'Zeitraum:',
	'checkuser-week-1' => 'letzte 7 Tage',
	'checkuser-week-2' => 'letzte 14 Tage',
	'checkuser-month' => 'letzte 30 Tage',
	'checkuser-all' => 'alle',
	'checkuser-empty' => 'Das Logbuch enthält keine Einträge.',
	'checkuser-nomatch' => 'Keine Übereinstimmungen gefunden.',
	'checkuser-nomatch-edits' => 'Keine Übereinstimmungen gefunden. Letzte Bearbeitung hat am $1 um $2 stattgefunden.',
	'checkuser-check' => 'Ausführen',
	'checkuser-log-fail' => 'Logbuch-Eintrag kann nicht hinzugefügt werden.',
	'checkuser-nolog' => 'Keine Logbuchdatei vorhanden.',
	'checkuser-blocked' => 'gesperrt',
	'checkuser-gblocked' => 'global gesperrt',
	'checkuser-locked' => 'geschlossen',
	'checkuser-wasblocked' => 'ehemals gesperrt',
	'checkuser-localonly' => 'nicht zusammengeführt',
	'checkuser-massblock' => 'Sperre die ausgewählten Benutzer',
	'checkuser-massblock-text' => 'Die ausgewählten Benutzerkonten werden dauerhaft gesperrt (Autoblock ist aktiv und die Anlage neuer Benutzerkonten wird unterbunden).
IP-Adressen werden für eine Woche gesperrt (nur für anonyme Benutzer, die Anlage neuer Benutzerkonten wird unterbunden).',
	'checkuser-blocktag' => 'Inhalt der Benutzerseite ersetzen durch:',
	'checkuser-blocktag-talk' => 'Diskussionsseiten ersetzen durch:',
	'checkuser-massblock-commit' => 'Sperre die ausgewählten Benutzer',
	'checkuser-block-success' => "'''{{PLURAL:$2|Der Benutzer|Die Benutzer}} $1 {{PLURAL:$2|wurde|wurden}} gesperrt.'''",
	'checkuser-block-failure' => "'''Es wurden keine Benutzer gesperrt.'''",
	'checkuser-block-limit' => 'Es wurden zuviele Benutzer ausgewählt.',
	'checkuser-block-noreason' => 'Du musst einen Grund für die Sperre angeben.',
	'checkuser-accounts' => '{{PLURAL:$1|1 neues Benutzerkonto|$1 neue Benutzerkonten}}',
	'checkuser-too-many' => 'Die Ergebnisliste ist zu lang, bitte grenze den IP-Bereich weiter ein. Hier sind die benutzten IP-Adressen (maximal 5000, sortiert nach Adresse):',
	'checkuser-user-nonexistent' => 'Das angegebene Benutzerkonto ist nicht vorhanden.',
	'checkuser-search-form' => 'Suche Logbucheinträge, bei denen $1 $2 ist.',
	'checkuser-search-submit' => 'Suche',
	'checkuser-search-initiator' => 'CheckUser-Berechtigter',
	'checkuser-search-target' => 'Abfrageziel (Benutzerkonto/IP)',
	'checkuser-ipeditcount' => '~$1 von allen Benutzern',
	'checkuser-log-subpage' => 'Logbuch',
	'checkuser-log-return' => 'Zurück zum CheckUser-Hauptformular',
	'checkuser-limited' => "'''Die Ergebnisliste wurde aus Performancegründen gekürzt.'''",
	'checkuser-log-userips' => '$1 holte IP-Adressen für $2',
	'checkuser-log-ipedits' => '$1 holte Bearbeitungen für $2',
	'checkuser-log-ipusers' => '$1 holte Benutzer für $2',
	'checkuser-log-ipedits-xff' => '$1 holte Bearbeitungen für XFF $2',
	'checkuser-log-ipusers-xff' => '$1 holte Benutzer für XFF $2',
	'checkuser-log-useredits' => '$1 holte Bearbeitungen für $2',
	'checkuser-autocreate-action' => 'automatisch erstellt',
	'checkuser-email-action' => 'sendete E-Mail an „$1“',
	'checkuser-reset-action' => 'Anforderung eines neuen Passwortes für „Benutzer:$1“',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'checkuser-summary' => 'Toś ten rěd skanujo aktualne změny, aby wótwołał IP-adresy wužywarja abo pokazał změny/wužywarske daty za IP-adresu.
Wužywarje a změny IP-adresy daju se pśez głowowe smužki XFF wótwołaś, z tym až "/xff" pśidawa se IP-adresy. IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128) se pódpěratej.
Z pśicynow wugbałosći wróśijo se nic wěcej ako 5000 změnow. Wužyj CheckUser pó zasadach priwatnosći.',
	'checkuser-desc' => 'Dajo wužywarjam z wótpowědnym pšawom móžnosć IP-adrese a druge informacije wužywarja kontrolowaś',
	'checkuser-logcase' => 'Pytanje w protokolu rozeznawaju mjazy wjeliko- a małopisanjom.',
	'checkuser' => 'Kontrola wužywarjow',
	'group-checkuser' => 'Kontrolery wužywarjow',
	'group-checkuser-member' => 'Kontroler wužywarjow',
	'right-checkuser' => 'Wužywarske IP-adrese a druge informacije kontrolěrowaś',
	'right-checkuser-log' => 'Protokol kontrole wužywarjow se woglědaś',
	'grouppage-checkuser' => '{{ns:project}}:Kontroler wužywarjow',
	'checkuser-reason' => 'Pśicyna:',
	'checkuser-showlog' => 'Protokol pokazaś',
	'checkuser-log' => 'Protokol kontrole wužywarjow',
	'checkuser-query' => 'Aktualne změny wótpšašaś',
	'checkuser-target' => 'Wužywaŕ abo IP',
	'checkuser-users' => 'Wužywarjow wobstaraś',
	'checkuser-edits' => 'Změny z IP wobstaraś',
	'checkuser-ips' => 'IP-adrese wobstraś',
	'checkuser-account' => 'Kontowe změny wobstaraś',
	'checkuser-search' => 'Pytaś',
	'checkuser-period' => 'Cas:',
	'checkuser-week-1' => 'slědny tyźeń',
	'checkuser-week-2' => 'slědnej dwa tyźenja',
	'checkuser-month' => 'slědnych 30 dnjow',
	'checkuser-all' => 'wše',
	'checkuser-empty' => 'Protokol njewopśimujo žedne zapiski.',
	'checkuser-nomatch' => 'Žedne wótpowědniki namakane.',
	'checkuser-nomatch-edits' => 'Žedne wótpowědniki namakane.
Slědna změna jo $1 $2 była.',
	'checkuser-check' => 'Kontrolěrowaś',
	'checkuser-log-fail' => 'Protokolowy zapisk njedajo se pśidaś',
	'checkuser-nolog' => 'Žedna protokolowa dataja namakana.',
	'checkuser-blocked' => 'Blokěrowany',
	'checkuser-gblocked' => 'Globalnje blokěrowany',
	'checkuser-locked' => 'Zastajony',
	'checkuser-wasblocked' => 'Do togo blokěrowany',
	'checkuser-localonly' => 'Njezjadnośone',
	'checkuser-massblock' => 'Wubranych wužywarjow blokěrowaś',
	'checkuser-massblock-text' => 'Wubrane konta blokěruju se na njewěsty cas - awtomatiske blokěrowanje jo aktiwne a załoženje kontow jo znjemóžnjone.
IP-adrese budu se jano za IP-wužywarjow na 1 tyźeń blokěrowaś - załoženje kontow jo znjemóžnjone.',
	'checkuser-blocktag' => 'Wužywarske boki narownaś pśez:',
	'checkuser-blocktag-talk' => 'Diskusijne boki narownaś pśez:',
	'checkuser-massblock-commit' => 'Wubranych wužywarjow blokěrowaś',
	'checkuser-block-success' => "'''{{PLURAL:$2|Wužywaŕ|Wužywarja|Wužywarje|Wužywarje}} $1 {{PLURAL:$2|jo|stej|su|su}} něnto {{PLURAL:$2|blokěrowany|blokěrowanej|blokěrowane|blokěrowane}}.'''",
	'checkuser-block-failure' => "'''Žedne wužywarje blokěrowane.'''",
	'checkuser-block-limit' => 'Pśewjele wužywarjow wubrane.',
	'checkuser-block-noreason' => 'Musyš pśicynu za blokěrowanja pódaś.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nowe konto|nowej konśe|nowe konta|nowych kontow}}',
	'checkuser-too-many' => 'Pśewjele wuslědkow, pšosym wobgranicuj IP-wobcerk. How su wužywane IP-adrese (maks. 5000, pséwuběrane pó adresu):',
	'checkuser-user-nonexistent' => 'Pódany wužywaŕ njeeksistěrujo.',
	'checkuser-search-form' => 'Protokolowe zapiski namakaś, źož $1 jo $2',
	'checkuser-search-submit' => 'Pytaś',
	'checkuser-search-initiator' => 'iniciator',
	'checkuser-search-target' => 'cel',
	'checkuser-ipeditcount' => '~$1 ze wšych wužywarjow',
	'checkuser-log-subpage' => 'Protokol',
	'checkuser-log-return' => 'Slědk ku głownemu formularoju CheckUser',
	'checkuser-limited' => "'''Toś te wuslědki su se z pśicynow wugbałosći wobrězali.'''",
	'checkuser-log-userips' => '$1 jo IP-adrese za $2 wobstarał',
	'checkuser-log-ipedits' => '$1 jo změny za $2 wobstarał',
	'checkuser-log-ipusers' => '$1 jo wužywarjow za $2 wobstarał',
	'checkuser-log-ipedits-xff' => '$1 jo změny za XFF $2 wobstarał',
	'checkuser-log-ipusers-xff' => '$1 jo wužywarjow za XFF $2 wobstarał',
	'checkuser-log-useredits' => '$1 jo změny za $2 wobstarał',
	'checkuser-autocreate-action' => 'jo se awtomatiski załožyło',
	'checkuser-email-action' => 'jo e-mail na wužywarja "$1" pósłał',
	'checkuser-reset-action' => 'gronidło za wužywarja "$1" wótnowiś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'checkuser-search' => 'Dii',
	'checkuser-search-submit' => 'Dii',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'checkuser-summary' => 'Αυτό το εργαλείο σαρώνει τις πρόσφατες αλλαγές για να ανακτήσει τις IP διευθύνσεις που χρησιμοποιούνται από ένα χρήστη ή για να δείξει τα δεδομένα επεξεργασιών/χρηστών για μία IP.
Χρήστες και επεξεργασίες από μία σταθερή IP μπορούν να ανακτηθούν μέσω XFF επικεφαλίδων προσαρτώντας "/xff" στην IP. Το IPv4 (CIDR 16-32) και το IPv6 (CIDR 64-128) υποστηρίζονται.
Όχι περισσότερες από 5000 επεξεργασίες θα επιστραφούν για λόγους απόδοσης. 
Χρησιμοποιήστε αυτό σύμφωνα με την πολιτική.',
	'checkuser-desc' => 'Παρέχει στους χρήστες με την κατάλληλη άδεια την ικανότητα να ελέγχουν τη διεύθυνση IP ενός χρήστη καθώς και άλλες πληροφορίες',
	'checkuser-logcase' => 'Η αναζήτηση στο αρχείο καταγραφής διακρίνει πεζά από κεφαλαία.',
	'checkuser' => 'Ελεγκτής',
	'group-checkuser' => 'Ελεγκτές',
	'group-checkuser-member' => 'Ελεγκτής',
	'grouppage-checkuser' => '{{ns:project}}:Ελεγκτής',
	'checkuser-reason' => 'Λόγος',
	'checkuser-showlog' => 'Εμφάνιση αρχείου καταγραφής',
	'checkuser-log' => 'Αρχείο καταγραφής ελεγχών',
	'checkuser-query' => 'Αναζήτηση στις πρόσφατες αλλαγές',
	'checkuser-target' => 'Χρήστης ή IP',
	'checkuser-users' => 'Λήψη χρηστών',
	'checkuser-edits' => 'Λήψη επεξεργασιών από IP',
	'checkuser-ips' => 'Λήψη των IP',
	'checkuser-search' => 'Αναζήτηση',
	'checkuser-period' => 'Διάρκεια:',
	'checkuser-week-1' => 'τελευταία εβδομάδα',
	'checkuser-week-2' => 'τις τελευταίες δύο εβδομάδες',
	'checkuser-month' => 'τις τελευταίες 30 ημέρες',
	'checkuser-all' => 'όλα',
	'checkuser-empty' => 'Το αρχείο καταγραφής δεν περιέχει κανένα αντικείμενο.',
	'checkuser-nomatch' => 'Δεν βρέθηκαν σχετικές σελίδες.',
	'checkuser-check' => 'Έλεγχος',
	'checkuser-log-fail' => 'Δεν είναι δυνατή η προσθήκη εγγραφής στο αρχείο καταγραφών',
	'checkuser-nolog' => 'Δεν βρέθηκε κανένα αρχείο καταγραφής.',
	'checkuser-blocked' => 'Φραγμένος',
	'checkuser-locked' => 'Κλειδωμένο',
	'checkuser-blocktag' => 'Αντικατάσταση των σελίδων των χρηστών με:',
	'checkuser-too-many' => 'Πάρα πολλά αποτελέσματα, παρακαλούμε στενέψτε το CIDR. Παρακάτω είναι οι διευθύνσεις IP που χρησιμοποιούνται (με ανώτατο όριο τις 5000, ταξινομημένες κατά διεύθυνση):',
	'checkuser-user-nonexistent' => 'Ο συγκεκριμένος χρήστης δεν υπάρχει.',
	'checkuser-search-form' => 'Εύρεση εγγραφών του αρχείου καταγραφής στις οποίες ο $1 είναι $2',
	'checkuser-search-submit' => 'Αναζήτηση',
	'checkuser-search-initiator' => 'ελεγκτής',
	'checkuser-search-target' => 'στόχος',
	'checkuser-ipeditcount' => '~$1 από όλους τους χρήστες',
	'checkuser-log-subpage' => 'Αρχείο',
	'checkuser-log-return' => 'Επιστροφή στην κύρια φόρμα ελέγχου χρήστη',
	'checkuser-log-userips' => 'Ο $1 πήρε τις IP διευθύνσεις για τον $2',
	'checkuser-log-ipedits' => 'Ο $1 πήρε τις επεξεργασίες για το $2',
	'checkuser-log-ipusers' => 'Ο $1 πήρε τους χρήστες για το $2',
	'checkuser-log-ipedits-xff' => 'Ο $1 πήρε τις επεξεργασίες για το XFF $2',
	'checkuser-log-ipusers-xff' => 'Ο $1 πήρε τους χρήστες για το XFF $2',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'checkuser-summary' => 'Ĉi tiu ilo skanas lastajn ŝanĝojn por akiri la IP-adresojn uzatajn de uzanto aŭ montri la datenojn de redakto/uzanto por aparta IP-adreso.
Uzantoj kaj redaktoj de klienta IP-adreson eblas esti akirita de XFF-titolaro postaldonante "/xff".
IPv4 (CIDR 16-32) kaj IPv6 (CIDR 64-128) estas subtenata.
Neniom pli ol 5000 redaktoj estos montrita pro bona datumbaza funkciado.
Uzu ĉi tion laŭ regularo.',
	'checkuser-desc' => 'Rajtigas al uzantoj kun la taŭga permeso la kapableco kontroli la IP-adreson de uzanto kaj alia informo',
	'checkuser-logcase' => 'La protokola serĉo estas usklecodistinga.',
	'checkuser' => 'Kontrolanto de uzantoj',
	'group-checkuser' => 'Kontrolaj uzantoj',
	'group-checkuser-member' => 'Kontrola uzanto',
	'right-checkuser' => 'Kontroli la IP-adreson kaj alian informon de uzanto',
	'right-checkuser-log' => 'Vidi la protokolon pri kontrolado de uzantoj',
	'grouppage-checkuser' => '{{ns:project}}:Kontroli uzanton',
	'checkuser-reason' => 'Kialo:',
	'checkuser-showlog' => 'Montri protokolon',
	'checkuser-log' => 'Protokolo pri kontrolado de uzantoj',
	'checkuser-query' => 'Informomendu lastatempajn ŝanĝojn',
	'checkuser-target' => 'Uzanto aŭ IP-adreso',
	'checkuser-users' => 'Akiri uzantojn',
	'checkuser-edits' => 'Trovi redaktojn de IP-adreso',
	'checkuser-ips' => 'Preni IP-adresojn',
	'checkuser-account' => 'Teni kontajn redaktojn',
	'checkuser-search' => 'Serĉi',
	'checkuser-period' => 'Daŭro:',
	'checkuser-week-1' => 'lasta semajno',
	'checkuser-week-2' => 'lastaj du semajnoj',
	'checkuser-month' => 'lastaj 30 tagoj',
	'checkuser-all' => 'ĉiuj',
	'checkuser-empty' => 'La protokolo estas malplena.',
	'checkuser-nomatch' => 'Neniujn pafojn trovis.',
	'checkuser-nomatch-edits' => 'Neniuj trafoj troviĝis. Lasta redakto estis je $1, $2.',
	'checkuser-check' => 'Kontroli',
	'checkuser-log-fail' => 'Ne eblis aldoni protokoleron.',
	'checkuser-nolog' => 'Neniu protokolo estas trovita.',
	'checkuser-blocked' => 'Forbarita',
	'checkuser-gblocked' => 'Forbarita globale',
	'checkuser-locked' => 'Ŝlosita',
	'checkuser-wasblocked' => 'Antaŭe forbarita',
	'checkuser-localonly' => 'Nekunigita',
	'checkuser-massblock' => 'Forbari selektitajn uzantojn',
	'checkuser-massblock-text' => 'Selektitaj kontoj estos forbaritaj senlime, kun aŭtomata forbaro ŝaltita kaj kont-kreado malŝaltita.
IP-adresoj estos forbarita 1 semajnon por IP-uzantoj kun kont-kreado malpermesita.',
	'checkuser-blocktag' => 'Anstataŭigi uzanto-paĝojn kun:',
	'checkuser-blocktag-talk' => 'Anstataŭigi diskuto-paĝojn kun:',
	'checkuser-massblock-commit' => 'Forbari selektitajn uzantojn',
	'checkuser-block-success' => "'''La {{PLURAL:$2|uzanto|uzantoj}} $1 estas nun {{PLURAL:$2|forbarita|forbaritaj}}.'''",
	'checkuser-block-failure' => "'''Neniuj uzantoj forbariĝis.'''",
	'checkuser-block-limit' => 'Tro da uzantoj selektitaj.',
	'checkuser-block-noreason' => 'Vi devas doni kialon por la forbaroj.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nova konto|novaj kontoj}}',
	'checkuser-too-many' => 'Tro da rezultoj. Bonvolu malvastigi la CIDR. 
Jen la IP-adresoj uzitaj (maksimume 5000, ordigita laŭ adresoj):',
	'checkuser-user-nonexistent' => 'La donata uzanto ne ekzistas.',
	'checkuser-search-form' => 'Trovi protokolerojn en kiu la $1 estas $2',
	'checkuser-search-submit' => 'Serĉi',
	'checkuser-search-initiator' => 'inicianto',
	'checkuser-search-target' => 'celo',
	'checkuser-ipeditcount' => '~$1 de ĉiuj uzantoj',
	'checkuser-log-subpage' => 'Protokolo',
	'checkuser-log-return' => 'Reiru al ĉefa kamparo por kontroli uzantojn',
	'checkuser-limited' => "'''Ĉi tiuj rezultoj estis stumpigitaj pro laborecaj kialoj.",
	'checkuser-log-userips' => '$1 akiris IP-adresojn por $2',
	'checkuser-log-ipedits' => '$1 akiris redaktojn por $2',
	'checkuser-log-ipusers' => '$1 akiris uzantojn por $2',
	'checkuser-log-ipedits-xff' => '$1 akiris redaktojn por XFF $2',
	'checkuser-log-ipusers-xff' => '$1 akiris uzantojn por XFF $2',
	'checkuser-log-useredits' => '$1 tenis redaktojn por $2',
	'checkuser-autocreate-action' => 'estis aŭtomate kreita',
	'checkuser-email-action' => 'sendis retpoŝton al uzanto "$1"',
	'checkuser-reset-action' => 'restarigis pasvorton por uzanto "$1"',
);

/** Spanish (Español)
 * @author Aleator
 * @author Dmcdevit
 * @author Jatrobat
 * @author Lin linao
 * @author Muro de Aguas
 * @author Piolinfax
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 * @author Titoxd
 */
$messages['es'] = array(
	'checkuser-summary' => 'Esta herramienta explora los cambios recientes para obtener las IPs utilizadas por un usuario o para mostrar la información de ediciones/usuarios de una IP.
También se pueden obtener los usuarios y las ediciones de un cliente IP vía XFF añadiendo "/xff". IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128) funcionan.
No se muestran más de 5000 ediciones por motivos de rendimiento. Usa esta herramienta en acuerdo con la ley orgánica de protección de datos.',
	'checkuser-desc' => 'Permite a los usuarios que tienen permiso especial comprobar las IPs de los usuarios además de otra información.',
	'checkuser-logcase' => 'El buscador de registros distingue entre mayúsculas y minúsculas.',
	'checkuser' => 'Verificador de usuarios',
	'group-checkuser' => 'Verificadores de usuarios',
	'group-checkuser-member' => 'Verificador de usuarios',
	'right-checkuser' => 'Comprobar las IPs de los usuarios y obtener otra información relacionada',
	'right-checkuser-log' => 'Ver el registro de verificación de usuarios',
	'grouppage-checkuser' => '{{ns:project}}:verificador de usuarios',
	'checkuser-reason' => 'Motivo:',
	'checkuser-showlog' => 'Ver registro',
	'checkuser-log' => 'Registro de CheckUser',
	'checkuser-query' => 'Buscar en cambios recientes',
	'checkuser-target' => 'Usuario o IP',
	'checkuser-users' => 'Obtener usuarios',
	'checkuser-edits' => 'Obtener ediciones de IP',
	'checkuser-ips' => 'Obtener IPs',
	'checkuser-account' => 'Ver contribuciones de la cuenta',
	'checkuser-search' => 'Buscar',
	'checkuser-period' => 'Duración:',
	'checkuser-week-1' => 'la semana pasada',
	'checkuser-week-2' => 'últimas dos semanas',
	'checkuser-month' => 'últimos 30 días',
	'checkuser-all' => 'todos',
	'checkuser-empty' => 'No hay elementos en el registro.',
	'checkuser-nomatch' => 'No hay elementos en el registro con esas condiciones.',
	'checkuser-nomatch-edits' => 'No se encontraron coincidencias.
La última edición fue el $1 a las $2',
	'checkuser-check' => 'Examinar',
	'checkuser-log-fail' => 'No se puede añadir este elemento al registro.',
	'checkuser-nolog' => 'No se encuentra ningún archivo del registro',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Cerrado con llave',
	'checkuser-wasblocked' => 'Bloqueado anteriormente',
	'checkuser-localonly' => 'No unificado',
	'checkuser-massblock' => 'Bloquear usuarios seleccionados',
	'checkuser-massblock-text' => 'Las cuentas seleccionadas serán bloqueadas de forma indefinida, con el autobloqueo habilitado y la creación de cuentas deshabilitada.  
Las direcciones IP serán bloqueadas durante una semana con la creación de cuentas deshabilitada.',
	'checkuser-blocktag' => 'Reemplazar páginas del usuario con:',
	'checkuser-blocktag-talk' => 'Reemplazar las páginas de discusión con:',
	'checkuser-massblock-commit' => 'Bloquear usuarios seleccionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|El usuario|Los usuarios}} $1 {{PLURAL:$2|está bloqueado|están bloqueados}}.'''",
	'checkuser-block-failure' => "'''No hay usuarios bloqueados.'''",
	'checkuser-block-limit' => 'Demasiados usarios seleccionados.',
	'checkuser-block-noreason' => 'Debe dar una razón para los bloqueos.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cuenta nueva|cuentas nuevas}}',
	'checkuser-too-many' => 'Hay demasiados resultados. Por favor limita el CIDR. Aquí se ven las IPs usadas (máximo 5000, ordenadas según dirección):',
	'checkuser-user-nonexistent' => 'El usuario especificado no existe.',
	'checkuser-search-form' => 'Encontrar entradas de registros en las que el $1 es $2',
	'checkuser-search-submit' => 'Buscar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target' => 'meta',
	'checkuser-ipeditcount' => '~$1 de todos los usuarios',
	'checkuser-log-subpage' => 'Registro',
	'checkuser-log-return' => 'Volver al formulario principal de CheckUser',
	'checkuser-limited' => "'''Estos resultados han sido truncados a causa de motivos de rendimiento.'''",
	'checkuser-log-userips' => '$1 obtuvo las direcciones IP de $2',
	'checkuser-log-ipedits' => '$1 obtuvo las contribuciones de $2',
	'checkuser-log-ipusers' => '$1 obtuvo los usuarios de $2',
	'checkuser-log-ipedits-xff' => '$1 obtuvo las contribuciones de XFF de $2',
	'checkuser-log-ipusers-xff' => '$1 obtuvo los usuarios para XFF $2',
	'checkuser-log-useredits' => '$1 obtuvo las contribuciones de $2',
	'checkuser-autocreate-action' => 'fue creada automáticamente',
	'checkuser-email-action' => 'enviado correo electrónico al usuario «$1»',
	'checkuser-reset-action' => 'anular contraseña para el usuario «$1»',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author WikedKentaur
 */
$messages['et'] = array(
	'checkuser-search' => 'Otsi',
	'checkuser-period' => 'Ajavahemik:',
	'checkuser-week-1' => 'viimane nädal',
	'checkuser-week-2' => 'viimased kaks nädalat',
	'checkuser-month' => 'viimased 30 päeva',
	'checkuser-all' => 'kõik',
	'checkuser-nolog' => 'Logifaili ei leitud.',
	'checkuser-blocked' => 'Blokeeritud',
	'checkuser-gblocked' => 'Globaalselt blokeeritud',
	'checkuser-locked' => 'Lukustatud',
	'checkuser-wasblocked' => 'Eelnevalt blokeeritud',
	'checkuser-blocktag' => 'Asenda kasutajalehed:',
	'checkuser-blocktag-talk' => 'Asenda arutelulehed:',
	'checkuser-massblock-commit' => 'Blokeeri valitud kasutajad',
	'checkuser-block-failure' => "'''Ühtegi kasutajat ei blokeeritud.'''",
	'checkuser-block-limit' => 'Liiga palju kasutajaid valitud.',
	'checkuser-block-noreason' => 'Blokeeringule peab andma põhjenduse.',
	'checkuser-search-submit' => 'Otsi',
	'checkuser-search-initiator' => 'initsiaator',
	'checkuser-search-target' => 'sihtmärk',
	'checkuser-autocreate-action' => 'alustati automaatselt',
	'checkuser-email-action' => 'e-kiri kasutajale "$1" saadetud',
);

/** Basque (Euskara) */
$messages['eu'] = array(
	'checkuser' => 'Erabiltzailea egiaztatu',
	'group-checkuser' => 'Erabiltzaileak egiaztatu',
	'group-checkuser-member' => 'Erabiltzailea egiaztatu',
	'checkuser-reason' => 'Arrazoia',
	'checkuser-search' => 'Bilatu',
	'checkuser-nomatch' => 'Ez da bat datorren emaitzarik aurkitu.',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'checkuser-reason' => 'Razón',
	'checkuser-search' => 'Landeal',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'checkuser-summary' => 'این ابزار تغییرات اخیر را برای به دست آوردن نشانی‌های اینترنتی (IP) استفاده شده توسط یک کاربر و یا تعیین ویرایش‌های انجام شده از طریق یک نشانی اینترنتی جستجو می‌کند.
کاربرها و ویرایش‌های مرتبط با یک نشانی اینترنتی را می‌توان با توجه به اطلاعات سرآیند XFF (با افزودن «‏‎/xff» به انتهای نشانی IP) پیدا کرد.
هر دو پروتکل IPv4 (معادل CIDR 16-32) و IPv6 (معادل CIDR 64-128) توسط این ابزار پشتیبانی می‌شوند.',
	'checkuser-desc' => 'به کاربرها اختیارات لازم را برای بررسی نشانی اینترنتی کاربرها و اطلاعات دیگر می‌دهد',
	'checkuser-logcase' => 'جستجوی سیاهه به کوچک یا بزرگ بودن حروف حساس است.',
	'checkuser' => 'بازرسی کاربر',
	'group-checkuser' => 'بازرسان کاربر',
	'group-checkuser-member' => 'بازرس کاربر',
	'right-checkuser' => 'بررسی نشانی اینترنتی و دیگر اطلاعات کاربرها',
	'right-checkuser-log' => 'مشاهدهٔ سیاههٔ بازرسی کاربر',
	'grouppage-checkuser' => '{{ns:project}}:بازرسی کاربر',
	'checkuser-reason' => 'دلیل',
	'checkuser-showlog' => 'نمایش سیاهه',
	'checkuser-log' => 'سیاهه بازرسی کاربر',
	'checkuser-query' => 'جستجوی تغییرات اخیر',
	'checkuser-target' => 'کاربر یا نشانی اینترنتی',
	'checkuser-users' => 'فهرست کردن کاربرها',
	'checkuser-edits' => 'نمایش ویرایش‌های مربوط به این نشانی اینترنتی',
	'checkuser-ips' => 'فهرست کردن نشانی‌های اینترنتی',
	'checkuser-account' => 'دریافت ویرایش‌های حساب',
	'checkuser-search' => 'جستجو',
	'checkuser-period' => 'بازه زمانی:',
	'checkuser-week-1' => 'هفتهٔ گذشته',
	'checkuser-week-2' => 'دو هفتهٔ گذشته',
	'checkuser-month' => '۳۰ روز گذشته',
	'checkuser-all' => 'همه',
	'checkuser-empty' => 'سیاهه خالی است.',
	'checkuser-nomatch' => 'موردی که مطابقت داشته باشد پیدا نشد.',
	'checkuser-nomatch-edits' => 'مورد مطابق پیدا نشد.
آخرین ویرایش در $1 ساعت $2 بود.',
	'checkuser-check' => 'بررسی',
	'checkuser-log-fail' => 'امکان افزودن اطلاعات به سیاهه وجود ندارد',
	'checkuser-nolog' => 'پرونده سیاهه پیدا نشد.',
	'checkuser-blocked' => 'دسترسی قطع شد',
	'checkuser-gblocked' => 'بسته شده سرتاسری',
	'checkuser-locked' => 'قفل شده',
	'checkuser-wasblocked' => 'قبلاً بسته شده',
	'checkuser-localonly' => 'یکی نشده',
	'checkuser-massblock' => 'بستن کاربرهای انتخاب شده',
	'checkuser-massblock-text' => 'حساب‌های انتخاب شده برای همیشه بسته خواهند شد، قطع دسترسی خودکار هم فعال خواهد بود و از ایجاد حساب کاربری هم جلوگیری خواهد شد. نشانی‌های اینترنتی برای یک هفته فقط برای کاربران ناشناس بسته خواهند شد و از ایجاد حساب کاربری توسط آنان جلوگیری خواهد شد.',
	'checkuser-blocktag' => 'جایگزین کردن صفحهٔ کاربرها با:',
	'checkuser-blocktag-talk' => 'جایگزین کردن صفحه‌های بحث با:',
	'checkuser-massblock-commit' => 'بستن کاربرهای انتخاب شده',
	'checkuser-block-success' => "'''دسترسی {{PLURAL:$2|حساب|حساب‌های}} $1 اینک {{PLURAL:$2|بسته‌است|بسته‌است}}.'''",
	'checkuser-block-failure' => "'''هیچ کاربری بسته نشد.'''",
	'checkuser-block-limit' => 'تعداد بیش از اندازه‌ای از کاربران انتخاب شده‌اند.',
	'checkuser-block-noreason' => 'شما باید دلیلی برای قطع دسترسی‌ها ارائه کنید.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|حساب|حساب}} جدید',
	'checkuser-too-many' => 'تعداد نتایج بسیار زیاد است. لطفاً CIDR را باریک‌تر کنید. در زیر نشانی‌های اینترنتی استفاده شده را می‌بینید (حداثر ۵۰۰۰ مورد، به ترتیب نشانی):',
	'checkuser-user-nonexistent' => 'کاربر مورد نظر وجود ندارد.',
	'checkuser-search-form' => 'پیدا کردن مواردی در سیاهه‌ها که $1 همان $2 است',
	'checkuser-search-submit' => 'جستجو',
	'checkuser-search-initiator' => 'آغازگر',
	'checkuser-search-target' => 'هدف',
	'checkuser-ipeditcount' => '~$1 از همهٔ کاربران',
	'checkuser-log-subpage' => 'سیاهه',
	'checkuser-log-return' => 'بازگشت به فرم اصلی بازرسی کاربر',
	'checkuser-limited' => "'''این نتایج برای کارآیی سیستم کوتاه شده‌اند.'''",
	'checkuser-log-userips' => '$1 نشانی‌های اینترنتی $2 را گرفت',
	'checkuser-log-ipedits' => '$1 ویرایش‌های $2 را گرفت',
	'checkuser-log-ipusers' => '$1 کاربرهای مربوط به $2 را گرفت',
	'checkuser-log-ipedits-xff' => '$1 ویرایش‌های XFF $2 را گرفت',
	'checkuser-log-ipusers-xff' => '$1 کاربرهای مربوط به XFF $2 را گرفت',
	'checkuser-log-useredits' => '$1 ویرایش‌های $2 را گرفت',
	'checkuser-autocreate-action' => 'به طور خودکار ساخته شد',
	'checkuser-email-action' => 'نامه الکترونیکی به کاربر «$1» فرستاد',
	'checkuser-reset-action' => 'گذرواژه کاربر «$1» را از نو تنظیم کرد',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Cimon Avaro
 * @author Crt
 * @author Jaakonam
 * @author Jack Phoenix
 * @author Nike
 */
$messages['fi'] = array(
	'checkuser-summary' => 'Tämän työkalun avulla voidaan tutkia tuoreet muutokset ja paljastaa käyttäjien IP-osoitteet tai noutaa IP-osoitteiden muokkaukset ja käyttäjätiedot.
	Käyttäjät ja muokkaukset voidaan hakea myös uudelleenohjausosoitteen (X-Forwarded-For) takaa käyttämällä IP-osoitteen perässä <tt>/xff</tt> -merkintää. Työkalu tukee sekä IPv4 (CIDR 16–32) ja IPv6 (CIDR 64–128) -standardeja.',
	'checkuser-desc' => 'Antaa oikeutetuille käyttäjille mahdollisuuden tarkistaa käyttäjän IP-osoitteet ja muita tietoja.',
	'checkuser-logcase' => 'Haku lokista on kirjainkokoriippuvainen.',
	'checkuser' => 'Osoitepaljastin',
	'group-checkuser' => 'osoitepaljastimen käyttäjät',
	'group-checkuser-member' => 'osoitepaljastimen käyttäjä',
	'right-checkuser' => 'Tarkastaa käyttäjän käyttämät IP-osoitteet sekä muut tiedot',
	'right-checkuser-log' => 'Tarkastella osoitepaljastuslokia',
	'grouppage-checkuser' => '{{ns:project}}:Osoitepaljastin',
	'checkuser-reason' => 'Syy',
	'checkuser-showlog' => 'Näytä loki',
	'checkuser-log' => 'Osoitepaljastinloki',
	'checkuser-query' => 'Hae tuoreet muutokset',
	'checkuser-target' => 'Käyttäjä tai IP-osoite',
	'checkuser-users' => 'Hae käyttäjät',
	'checkuser-edits' => 'Hae IP-osoitteen muokkaukset',
	'checkuser-ips' => 'Hae IP-osoitteet',
	'checkuser-account' => 'Näytä tunnuksen muokkaukset',
	'checkuser-search' => 'Etsi',
	'checkuser-period' => 'Aikaväli:',
	'checkuser-week-1' => 'viimeisin viikko',
	'checkuser-week-2' => 'viimeiset kaksi viikkoa',
	'checkuser-month' => 'viimeiset 30 päivää',
	'checkuser-all' => 'kaikki',
	'checkuser-empty' => 'Ei lokitapahtumia.',
	'checkuser-nomatch' => 'Hakuehtoihin sopivia tuloksia ei löytynyt.',
	'checkuser-nomatch-edits' => 'Osumia ei löytynyt.
Viimeinen muokkaus on tehty $1 kello $2.',
	'checkuser-check' => 'Tarkasta',
	'checkuser-log-fail' => 'Lokitapahtuman lisäys epäonnistui',
	'checkuser-nolog' => 'Lokitiedostoa ei löytynyt.',
	'checkuser-blocked' => 'Estetty',
	'checkuser-gblocked' => 'Estetty globaalisti',
	'checkuser-locked' => 'Lukittu',
	'checkuser-wasblocked' => 'Aiemmin estetyt',
	'checkuser-localonly' => 'Ei yhdistettynä',
	'checkuser-massblock' => 'Estä valitut käyttäjät',
	'checkuser-massblock-text' => 'Valitut tunnukset estetään toistaiseksi ("autoblocking", "tunnusten luonti estetty").
Vain rekisteröimättömien käyttäjien IP-osoitteet estetään yhdeksi viikoksi (myös tunnusten luonti estetty).',
	'checkuser-blocktag' => 'Korvaa käyttäjäsivut sisällöllä:',
	'checkuser-blocktag-talk' => 'Korvaa keskustelusivut sisällöllä:',
	'checkuser-massblock-commit' => 'Estä valitut käyttäjät',
	'checkuser-block-success' => "'''{{PLURAL:$2|Käyttäjä|Käyttäjät}} $1 {{PLURAL:$2|on|ovat}} nyt estetty.'''",
	'checkuser-block-failure' => "'''Yhtään käyttäjää ei estetty.'''",
	'checkuser-block-limit' => 'Liian monta käyttäjää valittu.',
	'checkuser-block-noreason' => 'Estoille on annettava syy.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|uusi tunnus|uutta tunnusta}}',
	'checkuser-too-many' => 'Liian monta tulosta, rajoita IP-osoitetta:',
	'checkuser-user-nonexistent' => 'Määritettyä käyttäjää ei ole olemassa.',
	'checkuser-search-form' => 'Etsi lokimerkintöjä, joissa $1 on $2',
	'checkuser-search-submit' => 'Hae',
	'checkuser-search-initiator' => 'alullepanija',
	'checkuser-search-target' => 'kohde',
	'checkuser-ipeditcount' => 'noin $1 muokkausta kaikilta käyttäjiltä',
	'checkuser-log-subpage' => 'Loki',
	'checkuser-log-return' => 'Palaa osoitepaljastimen päälomakkeeseen',
	'checkuser-limited' => "'''Nämä tulokset on lyhennetty suorituskykysyistä.'''",
	'checkuser-log-userips' => '$1 haki käyttäjän $2 IP-osoitteet',
	'checkuser-log-ipedits' => '$1 haki käyttäjän $2 muokkaukset',
	'checkuser-log-ipusers' => '$1 haki osoitteen $2 käyttämät tunnukset',
	'checkuser-log-ipedits-xff' => '$1 haki muokkaukset XFF-osoitteesta $2',
	'checkuser-log-ipusers-xff' => '$1 haki käyttäjät XFF-osoitteesta $2',
	'checkuser-log-useredits' => '$1 haki käyttäjän $2 muokkaukset',
	'checkuser-autocreate-action' => 'luotiin automaattisesti',
	'checkuser-email-action' => 'käyttäjälle ”$1” lähetetty sähköpostiviesti',
	'checkuser-reset-action' => 'käyttäjän ”$1” salasana nollattu',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'checkuser' => 'Rannsakanar brúkari',
	'group-checkuser' => 'Rannsakanar brúkari',
	'group-checkuser-member' => 'Rannsakanar brúkarir',
	'grouppage-checkuser' => '{{ns:project}}:Rannsakanar brúkari',
	'checkuser-search' => 'Leita',
);

/** French (Français)
 * @author ChrisPtDe
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Zetud
 */
$messages['fr'] = array(
	'checkuser-summary' => 'Cet outil parcourt la liste des changements récents à la recherche de l’adresse IP employée par un utilisateur, affiche toutes les éditions d’une adresse IP (même enregistrée), ou liste les comptes utilisés par une adresse IP. Les comptes et les modifications peuvent être trouvés avec une IP XFF si elle finit avec « /xff ». Il est possible d’utiliser les protocoles IPv4 (CIDR 16-32) et IPv6 (CIDR 64-128). Le nombre d’éditions affichables est limité à {{formatnum:5000}} pour des questions de performance du serveur. Veuillez utiliser cet outil dans les limites de la charte d’utilisation.',
	'checkuser-desc' => 'Donne la possibilité aux personnes dûment autorisées de vérifier les adresses IP des utilisateurs ainsi que d’autres informations les concernant',
	'checkuser-logcase' => 'La recherche dans le journal est sensible à la casse.',
	'checkuser' => 'Vérificateur d’utilisateur',
	'group-checkuser' => 'Vérificateurs d’utilisateur',
	'group-checkuser-member' => 'Vérificateur d’utilisateur',
	'right-checkuser' => "Vérifier l'adresse IP des utilisateurs et autres informations",
	'right-checkuser-log' => 'Voir le journal de vérification d’adresse',
	'grouppage-checkuser' => '{{ns:project}}:Vérificateur d’utilisateur',
	'checkuser-reason' => 'Motif',
	'checkuser-showlog' => 'Afficher le journal',
	'checkuser-log' => 'Journal de vérificateur d’utilisateur',
	'checkuser-query' => 'Recherche par les changements récents',
	'checkuser-target' => "Nom d'utilisateur ou adresse IP",
	'checkuser-users' => 'Obtenir les utilisateurs',
	'checkuser-edits' => 'Obtenir les modifications de l’adresse IP',
	'checkuser-ips' => 'Obtenir les adresses IP',
	'checkuser-account' => 'Obtenir les modifications du compte',
	'checkuser-search' => 'Recherche',
	'checkuser-period' => 'Durée :',
	'checkuser-week-1' => 'dernière semaine',
	'checkuser-week-2' => 'les deux dernières semaines',
	'checkuser-month' => 'les trente derniers jours',
	'checkuser-all' => 'tout',
	'checkuser-empty' => 'Le journal ne contient aucun article',
	'checkuser-nomatch' => 'Recherches infructueuses.',
	'checkuser-nomatch-edits' => 'Aucune occurence trouvée. La dernière modification était le $1 à $2.',
	'checkuser-check' => 'Recherche',
	'checkuser-log-fail' => 'Impossible d’ajouter l’entrée du journal.',
	'checkuser-nolog' => 'Aucune entrée dans le journal',
	'checkuser-blocked' => 'Bloqué',
	'checkuser-gblocked' => 'Globalement bloqué',
	'checkuser-locked' => 'Verrouillé',
	'checkuser-wasblocked' => 'Bloqué précédemment',
	'checkuser-localonly' => 'Non unifié',
	'checkuser-massblock' => 'Utilisateurs de la plage sélectionnée',
	'checkuser-massblock-text' => 'Les comptes sélectionnés seront bloqués indéfiniment, avec le blocage automatique activé et la création de compte désactivée.
Les adresses IP seront bloquées pendant une semaine uniquement pour les utilisateurs sous IP et la création de compte désactivée.',
	'checkuser-blocktag' => 'Remplace les pages utilisateur par :',
	'checkuser-blocktag-talk' => 'Remplacer les pages de discussion avec :',
	'checkuser-massblock-commit' => 'Bloquer les utilisateurs sélectionnés',
	'checkuser-block-success' => "'''{{PLURAL:$2|L’utilisateur|Les utilisateurs}} $1 {{PLURAL:$2|est maintenant bloqué|sont maintenant bloqués}}.'''",
	'checkuser-block-failure' => "'''Aucun utilisateur de bloqué.'''",
	'checkuser-block-limit' => "Trop d'utilisateurs sélectionnées",
	'checkuser-block-noreason' => 'Vous devez donner une raison pour les blocages.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nouveau compte|nouveaux comptes}}',
	'checkuser-too-many' => 'Trop de résultats. Veuillez limiter la recherche sur les adresses IP :',
	'checkuser-user-nonexistent' => "L’utilisateur indiqué n'existe pas",
	'checkuser-search-form' => 'Chercher le journal des entrées où $1 est $2.',
	'checkuser-search-submit' => 'Rechercher',
	'checkuser-search-initiator' => 'l’initiateur',
	'checkuser-search-target' => 'la cible',
	'checkuser-ipeditcount' => '~$1 pour tous les utilisateurs',
	'checkuser-log-subpage' => 'Journal',
	'checkuser-log-return' => "Retourner au formulaire principal de la vérification d'utilisateur",
	'checkuser-limited' => "'''Ces résultats ont été tronqués pour des raisons liées à la performance.'''",
	'checkuser-log-userips' => '$1 a obtenu des IP pour $2',
	'checkuser-log-ipedits' => '$1 a obtenu des modifications pour $2',
	'checkuser-log-ipusers' => '$1 a obtenu des utilisateurs pour $2',
	'checkuser-log-ipedits-xff' => '$1 a obtenu des modifications pour XFF  $2',
	'checkuser-log-ipusers-xff' => '$1 a obtenu des utilisateurs pour XFF $2',
	'checkuser-log-useredits' => '$1 a obtenu les modifications pour $2',
	'checkuser-autocreate-action' => 'a été crée automatiquement',
	'checkuser-email-action' => 'a envoyé un courriel à « $1 »',
	'checkuser-reset-action' => 'réinitialise le mot de passe pour « $1 »',
);

/** Cajun French (Français cadien)
 * @author JeanVoisin
 */
$messages['frc'] = array(
	'checkuser-summary' => "Cet outil observe les derniers changements pour retirer le IP de l'useur ou pour montrer l'information de l'editeur/de l'useur pour cet IP. Les userus et les changements par le IP d'un client pouvont être reçus par les en-têtes XFF par additionner le IP avec \"/xff\". Ipv4 (CIDR 16-32) and IPv6 (CIDR 64-128) sont supportés. Cet outil retourne pas plus que 5000 changements par rapport à la qualité d'ouvrage.  Usez ça ici en accord avec les régluations.",
	'checkuser-logcase' => 'La charche des notes est sensible aux lettres basses ou hautes.',
	'checkuser' => "'Gardez-voir à l'useur encore",
	'group-checkuser' => "'Gardez-voir aux useurs encore",
	'group-checkuser-member' => "'Gardez-voir à l'useur encore",
	'grouppage-checkuser' => "{{ns:project}}:'Gardez-voir à l'useur encore",
	'checkuser-reason' => 'Raison',
	'checkuser-showlog' => 'Montrer les notes',
	'checkuser-log' => "Notes de la Garde d'useur",
	'checkuser-query' => 'Charchez les nouveaux changements',
	'checkuser-target' => "Nom de l'useur ou IP",
	'checkuser-users' => 'Obtenir les useurs',
	'checkuser-edits' => 'Obtenir les modifications du IP',
	'checkuser-ips' => 'Obtenir les adresses IP',
	'checkuser-search' => 'Charche',
	'checkuser-empty' => 'Les notes sont vides.',
	'checkuser-nomatch' => 'Rien pareil trouvé.',
	'checkuser-check' => 'Charche',
	'checkuser-log-fail' => "Pas capable d'additionner la note",
	'checkuser-nolog' => 'Rien trouvé dans les notes.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'checkuser-summary' => 'Ceti outil parcôrt la lista des dèrriérs changements a la rechèrche de l’adrèce IP empleyê per un utilisator, afiche totes les èdicions d’una adrèce IP (méma enregistrâ), ou ben liste los comptos utilisâs per una adrèce IP.
	Los comptos et les modificacions pôvont étre trovâs avouéc una IP XFF se sè chavone avouéc « /xff ». O est possiblo d’utilisar los protocolos IPv4 (CIDR 16-32) et IPv6 (CIDR 64-128).
	Lo nombro d’èdicions afichâbles est limitâ a {{formatnum:5000}} por des quèstions de pèrformence du sèrvior. Volyéd utilisar ceti outil dens les limites de la chârta d’usâjo.',
	'checkuser-desc' => 'Balye la possibilitât a les gens qu’ont la pèrmission que vat avouéc de controlar les adrèces IP des utilisators et pués d’ôtres enformacions los regardent.',
	'checkuser-logcase' => 'La rechèrche dens lo jornal est sensibla a la câssa.',
	'checkuser' => 'Controlor d’utilisator',
	'group-checkuser' => 'Controlors d’utilisator',
	'group-checkuser-member' => 'Controlor d’utilisator',
	'grouppage-checkuser' => '{{ns:project}}:Controlors d’utilisator',
	'checkuser-reason' => 'Rêson',
	'checkuser-showlog' => 'Afichiér lo jornal',
	'checkuser-log' => 'Jornal de controlor d’utilisator',
	'checkuser-query' => 'Rechèrche per los dèrriérs changements',
	'checkuser-target' => 'Nom d’utilisator ou adrèce IP',
	'checkuser-users' => 'Obtegnir los utilisators',
	'checkuser-edits' => 'Obtegnir les modificacions de l’adrèce IP',
	'checkuser-ips' => 'Obtegnir les adrèces IP',
	'checkuser-search' => 'Rechèrche',
	'checkuser-empty' => 'Lo jornal contint gins d’articllo.',
	'checkuser-nomatch' => 'Rechèrches que balyont ren.',
	'checkuser-check' => 'Rechèrche',
	'checkuser-log-fail' => 'Empossiblo d’apondre l’entrâ du jornal.',
	'checkuser-nolog' => 'Niona entrâ dens lo jornal.',
	'checkuser-blocked' => 'Blocâ',
	'checkuser-too-many' => 'Trop de rèsultats. Volyéd limitar la rechèrche sur les adrèces IP :',
	'checkuser-user-nonexistent' => 'L’utilisator endicâ ègziste pas.',
	'checkuser-search-form' => 'Chèrchiér lo jornal de les entrâs yô que $1 est $2.',
	'checkuser-search-submit' => 'Rechèrchiér',
	'checkuser-search-initiator' => 'l’iniciator',
	'checkuser-search-target' => 'la ciba',
	'checkuser-log-subpage' => 'Jornal',
	'checkuser-log-return' => 'Tornar u formulèro principâl du contrôlo d’utilisator',
	'checkuser-log-userips' => '$1 at obtegnu des IP por $2',
	'checkuser-log-ipedits' => '$1 at obtegnu des modificacions por $2',
	'checkuser-log-ipusers' => '$1 at obtegnu des utilisators por $2',
	'checkuser-log-ipedits-xff' => '$1 at obtegnu des modificacions por XFF $2',
	'checkuser-log-ipusers-xff' => '$1 at obtegnu des utilisators por XFF $2',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'checkuser-search' => 'Sykje',
	'checkuser-search-submit' => 'Sykje',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'checkuser-summary' => 'Scanann an uirlis seo na athruithe is déanaí chun na seolaidh IP úsáideoira a fháil ná taispeáin na sonraí eagarthóireachta/úsáideoira don seoladh IP.
Is féidir úsáideoirí agus eagarthóireachta mar IP cliant a fháil le ceanntáisc XFF mar an IP a iarcheangail le "/xff". IPv4 (CIDR 16-32) agus IPv6 (CIDR 64-128) atá tacaíocht.
Le fáth feidhmiúcháin, ní féidir níos mó ná 5000 eagarthóireachta a thabhairt ar ais ar an am cheana. Déan úsáid de réir polsaí.',
	'checkuser-logcase' => 'Tá na logaí seo cásíogair.',
	'checkuser' => 'Seic úsáideoir',
	'group-checkuser' => 'Seiceanna úsáideoir',
	'group-checkuser-member' => 'Seic úsáideoir',
	'right-checkuser-log' => 'Féach ar an log seic úsáideoir',
	'checkuser-reason' => 'Fáth:',
	'checkuser-showlog' => 'Taispeáin logaí',
	'checkuser-log' => 'Logaí checkuser',
	'checkuser-query' => 'Iarratais ar athruithe úrnua',
	'checkuser-target' => 'Úsáideoir ná seoladh IP',
	'checkuser-users' => 'Faigh úsáideoira',
	'checkuser-edits' => 'Faigh athruithe don seoladh IP seo',
	'checkuser-ips' => 'Faigh Seolaidh IP',
	'checkuser-search' => 'Cuardaigh',
	'checkuser-week-1' => 'an tseachtain seo caite',
	'checkuser-week-2' => 'dhá sheachtain seo caite',
	'checkuser-month' => '30 lae seo caite',
	'checkuser-all' => 'an t-iomlán',
	'checkuser-empty' => 'Níl aon míreanna sa log.',
	'checkuser-nomatch' => 'Ní faigheann aon comhoiriúnaigh.',
	'checkuser-check' => 'Iarratais',
	'checkuser-log-fail' => 'Ní féidir iontráil a cur sa log',
	'checkuser-nolog' => 'Ní bhfaigheann comhad loga.',
	'checkuser-blocked' => 'Cosanta',
	'checkuser-gblocked' => 'Cosanta domhandach',
	'checkuser-locked' => 'Glasáilte',
	'checkuser-massblock-commit' => 'Cur cosc ar na n-úsáideoirí roghnaithe',
	'checkuser-block-success' => "'''Tá {{PLURAL:$2|an úsáideoir|na n-úsáideoirí}} $1 coiscthe anois.'''",
	'checkuser-block-failure' => "'''Níl aon úsáideoirí coiscthe.'''",
	'checkuser-accounts' => '{{PLURAL:$1|Cuntas amháin|$1 cuntais}} nua',
	'checkuser-too-many' => "Tá le mórán torthaí, caolaigh an CIDR le d'thoil. Seo iad na seolaidh IP (5000 uasta, sórtáilte le seoladh):",
	'checkuser-search-submit' => 'Cuardaigh',
	'checkuser-search-initiator' => 'tionscnóir',
	'checkuser-search-target' => 'targaid',
	'checkuser-ipeditcount' => '~$1 as na n-úsáideoir go léir',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-userips' => 'Fuair $1 seolaidh IP le $2',
	'checkuser-log-ipedits' => 'Fuair $1 athruithe le $2',
	'checkuser-log-ipusers' => 'Fuair $1 úsáideoirí le $2',
	'checkuser-log-ipedits-xff' => 'Fuair $1 athruithe le XFF $2',
	'checkuser-log-ipusers-xff' => 'Fuair $1 úsáideoirí le XFF $2',
	'checkuser-log-useredits' => 'Fuair $1 athruithe le $2',
	'checkuser-autocreate-action' => 'a chruthú go huathoibríoch',
	'checkuser-email-action' => 'a chur riomhphoist do úsáideoir "$1"',
	'checkuser-reset-action' => 'a athshocrú pásfhocal le úsáideoir "$1"',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'checkuser-summary' => 'Esta ferramenta analiza os cambios recentes para recuperar os enderezos IPs utilizados por un usuario ou amosar as edicións / datos do usuario dun enderezo de IP.
Os usuarios e as edicións por un cliente IP poden ser recuperados a través das cabeceiras XFF engadindo o enderezo IP con "/ xff". IPv4 (CIDR 16-32) e o IPv6 (CIDR 64-128) están soportadas.',
	'checkuser-desc' => 'Garante que usuarios cos permisos apropiados poidan comprobar os enderezos IP dos usuarios e acceder a outra información',
	'checkuser-logcase' => 'O rexistro de búsqueda é sensíbel a maiúsculas e minúsculas.',
	'checkuser' => 'Verificador de usuarios',
	'group-checkuser' => 'Verificadores de usuarios',
	'group-checkuser-member' => 'Verificador de usuarios',
	'right-checkuser' => 'Comprobar os enderezos IP dos usuarios e outra información',
	'right-checkuser-log' => 'Ver o rexistro de comprobadores de usuarios',
	'grouppage-checkuser' => '{{ns:project}}:Verificador de usuarios',
	'checkuser-reason' => 'Razón:',
	'checkuser-showlog' => 'Amosar o rexistro',
	'checkuser-log' => 'Rexistro de comprobacións de usuarios',
	'checkuser-query' => 'Consulta de cambios recentes',
	'checkuser-target' => 'Usuario ou enderezo IP',
	'checkuser-users' => 'Obter os usuarios',
	'checkuser-edits' => 'Obter edicións de enderezos IP',
	'checkuser-ips' => 'Conseguir enderezos IPs',
	'checkuser-account' => 'Obter as edicións dunha conta',
	'checkuser-search' => 'Procurar',
	'checkuser-period' => 'Período:',
	'checkuser-week-1' => 'última semana',
	'checkuser-week-2' => 'últimas dúas semanas',
	'checkuser-month' => 'últimos 30 días',
	'checkuser-all' => 'todos',
	'checkuser-empty' => 'O rexistro non contén elementos.',
	'checkuser-nomatch' => 'Non se atoparon coincidencias.',
	'checkuser-nomatch-edits' => 'Non se atoparon coincidencias.
A última edición foi feita o $1 ás $2.',
	'checkuser-check' => 'Comprobar',
	'checkuser-log-fail' => 'Non é posíbel engadir unha entrada no rexistro',
	'checkuser-nolog' => 'Ningún arquivo de rexistro.',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Bloqueado',
	'checkuser-wasblocked' => 'Bloqueados anteriormente',
	'checkuser-localonly' => 'Sen unificar',
	'checkuser-massblock' => 'Bloquear os usuarios seleccionados',
	'checkuser-massblock-text' => 'As contas seleccionadas serán bloqueadas indefinidamente, co bloqueo automático permitido e a creación de contas deshabilitada.  
Os enderezos IP serán bloqueados cun tempo de duración dunha semana só para os usuarios con IP e coa creación de contas deshabilitada.',
	'checkuser-blocktag' => 'Substituír as páxinas de usuario por:',
	'checkuser-blocktag-talk' => 'Substituír as conversas con:',
	'checkuser-massblock-commit' => 'Bloquear os usuarios seleccionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|O usuario|Os usuarios}} $1 xa {{PLURAL:$2|está|están}} bloqueados.'''",
	'checkuser-block-failure' => "'''Non hai ningún usuario bloqueado.'''",
	'checkuser-block-limit' => 'Hai seleccionados demasiados usuarios.',
	'checkuser-block-noreason' => 'Debe dar unha razón para os bloqueos.',
	'checkuser-accounts' => '{{PLURAL:$1|Unha nova conta|$1 novas contas}}',
	'checkuser-too-many' => 'Hai demasiados resultados, restrinxa o enderezo IP:',
	'checkuser-user-nonexistent' => 'Non existe o usuario especificado.',
	'checkuser-search-form' => 'Atopar entradas do rexistro nas que $1 é $2',
	'checkuser-search-submit' => 'Procurar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target' => 'destino',
	'checkuser-ipeditcount' => '~$1 de todos os usuarios',
	'checkuser-log-subpage' => 'Rexistro',
	'checkuser-log-return' => 'Voltar ao formulario principal de verificador de usuarios',
	'checkuser-limited' => "'''Estes resultados foron truncados por motivos de rendemento.'''",
	'checkuser-log-userips' => '$1 obteu os enderezos IP de "$2"',
	'checkuser-log-ipedits' => '$1 obteu as edicións de "$2"',
	'checkuser-log-ipusers' => '$1 obteu os usuarios de "$2"',
	'checkuser-log-ipedits-xff' => '$1 obteu as edicións de XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteu os usuarios de XFF $2',
	'checkuser-log-useredits' => '"$1" obteu as edicións de "$2"',
	'checkuser-autocreate-action' => 'foi creada automaticamente',
	'checkuser-email-action' => 'envioulle un correo electrónico ao usuario "$1"',
	'checkuser-reset-action' => 'envioulle un novo contrasinal ao usuario "$1"',
);

/** Gothic (𐌲𐌿𐍄𐌹𐍃𐌺) */
$messages['got'] = array(
	'checkuser-reason' => 'Faírina',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 * @author SPQRobin
 */
$messages['grc'] = array(
	'grouppage-checkuser' => '{{ns:project}}:Ἔλεγχος χρωμένου',
	'checkuser-reason' => 'Αἰτία:',
	'checkuser-search' => 'Ζητεῖν',
	'checkuser-period' => 'Διάρκεια:',
	'checkuser-all' => 'ἅπασαι',
	'checkuser-wasblocked' => 'Προηγουμένως πεφραγμένος',
	'checkuser-search-submit' => 'Ζητεῖν',
	'checkuser-search-initiator' => 'ἐγκαινιαστής',
	'checkuser-search-target' => 'στόχος',
	'checkuser-log-subpage' => 'Κατάλογος',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 */
$messages['gu'] = array(
	'checkuser-reason' => 'કારણ:',
	'checkuser-search' => 'શોધો',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'checkuser-reason' => 'Fa',
	'checkuser-search' => 'Ronsaghey',
	'checkuser-search-submit' => 'Ronsaghey',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'checkuser-search' => 'Chhìm-cháu',
	'checkuser-search-submit' => 'Chhìm-cháu',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'checkuser-reason' => 'Kumu',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'checkuser-summary' => 'כלי זה סורק את השינויים האחרונים במטרה למצוא את כתובות ה־IP שהשתמש בהן משתמש מסוים או כדי להציג את כל המידע על המשתמשים שהשתמשו בכתובת IP ועל העריכות שבוצעו ממנה.
ניתן לקבל עריכות ומשתמשים מכתובות IP של הכותרת X-Forwarded-For באמצעות הוספת הטקסט "/xff" לסוף הכתובת. הן כתובות IPv4 (כלומר, CIDR 16-32) והן כתובות IPv6 (כלומר, CIDR 64-128) נתמכות.
לא יוחזרו יותר מ־5000 עריכות מסיבות של עומס על השרתים. אנא השתמשו בכלי זה בהתאם למדיניות.',
	'checkuser-desc' => 'מאפשר למשתמשים עם ההרשאות המתאימות לבדוק את כתובת ה־IP של משתמשים',
	'checkuser-logcase' => 'החיפוש ביומנים הוא תלוי־רישיות.',
	'checkuser' => 'בדיקת משתמש',
	'group-checkuser' => 'בודקים',
	'group-checkuser-member' => 'בודק',
	'right-checkuser' => 'מציאת כתובות IP של משתמשים ומידע נוסף',
	'right-checkuser-log' => 'צפייה ביומן הבדיקות',
	'grouppage-checkuser' => '{{ns:project}}:בודק',
	'checkuser-reason' => 'סיבה:',
	'checkuser-showlog' => 'הצגת יומן',
	'checkuser-log' => 'יומן בדיקות',
	'checkuser-query' => 'בדיקת שינויים אחרונים',
	'checkuser-target' => 'שם משתמש או כתובת IP',
	'checkuser-users' => 'הצגת משתמשים',
	'checkuser-edits' => 'הצגת עריכות מכתובת IP מסוימת',
	'checkuser-ips' => 'הצגת כתובות IP',
	'checkuser-account' => 'הצגת עריכות מחשבון המשתמש',
	'checkuser-search' => 'חיפוש',
	'checkuser-period' => 'פרק זמן:',
	'checkuser-week-1' => 'השבוע האחרון',
	'checkuser-week-2' => 'השבועיים האחרונים',
	'checkuser-month' => '30 הימים האחרונים',
	'checkuser-all' => 'הכול',
	'checkuser-empty' => 'אין פריטים ביומן.',
	'checkuser-nomatch' => 'לא נמצאו התאמות.',
	'checkuser-nomatch-edits' => 'לא נמצאו התאמות.
העריכה האחרונה בוצעה ב־$2, $1.',
	'checkuser-check' => 'בדיקה',
	'checkuser-log-fail' => 'לא ניתן היה להוסיף פריט ליומן',
	'checkuser-nolog' => 'לא נמצא קובץ יומן.',
	'checkuser-blocked' => 'חסום',
	'checkuser-gblocked' => 'חסום באופן גלובלי',
	'checkuser-locked' => 'נעול',
	'checkuser-wasblocked' => 'נחסם בעבר',
	'checkuser-localonly' => 'חשבון לא מאוחד',
	'checkuser-massblock' => 'חסימת המשתמשים שנבחרו',
	'checkuser-massblock-text' => 'חשבונות המשתמש שנבחרו ייחסמו לצמיתות, עם חסימה אוטומטית וחסימה של יצירת החשבונות.
כתובות IP ייחסמו לשבוע אחד, עבור משתמשים אנונימיים בלבד, ועם חסימה של יצירת החשבונות.',
	'checkuser-blocktag' => 'החלפת דפי המשתמש עם:',
	'checkuser-blocktag-talk' => 'החלפת דפי השיחה עם:',
	'checkuser-massblock-commit' => 'חסימת המשתמשים שנבחרו',
	'checkuser-block-success' => "'''The {{PLURAL:$2|המשתמש|המשתמשים}} $1 {{PLURAL:$2|חסום|חסומים}} כעת.'''",
	'checkuser-block-failure' => "'''לא נחסמו משתמשים.'''",
	'checkuser-block-limit' => 'נבחרו יותר מדי משתמשים.',
	'checkuser-block-noreason' => 'עליכם לתת סיבה לחסימות.',
	'checkuser-accounts' => '{{PLURAL:$1|חשבון חדש אחד|$1 חשבונות חדשים}}',
	'checkuser-too-many' => 'נמצאו תוצאות רבות מדי, אנא צמצו את טווח כתובות ה־IP. להלן כתובת ה־IP שנעשה בהן שימוש (מוצגות 5,000 לכל היותר, וממוינות):',
	'checkuser-user-nonexistent' => 'המשתמש לא נמצא.',
	'checkuser-search-form' => 'מציאת ערכים ביומן שבהם ה$1 הוא $2',
	'checkuser-search-submit' => 'חיפוש',
	'checkuser-search-initiator' => 'בודק',
	'checkuser-search-target' => 'נבדק',
	'checkuser-ipeditcount' => 'בערך $1 מכל המשתמשים',
	'checkuser-log-subpage' => 'יומן',
	'checkuser-log-return' => 'חזרה לטופס הבדיקה הכללי',
	'checkuser-limited' => "'''הדף נקטע כדי לחסוך במשאבים.'''",
	'checkuser-log-userips' => '$1 בדק את כתובות ה־IP של $2',
	'checkuser-log-ipedits' => '$1 בדק את העריכות של $2',
	'checkuser-log-ipusers' => '$1 בדק את המשתמשים של $2',
	'checkuser-log-ipedits-xff' => '$1 בדק את העריכות של כתובת ה־XFF $2',
	'checkuser-log-ipusers-xff' => '$1 בדק את המשתמשים של כתובת ה־XFF $2',
	'checkuser-log-useredits' => '$1 בדק את העריכות של $2',
	'checkuser-autocreate-action' => 'נוצר אוטומטית',
	'checkuser-email-action' => 'שלח דואר אלקטרוני למשתמש "$1"',
	'checkuser-reset-action' => 'איפס את הסיסמה של המשתמש "$1"',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'checkuser-summary' => 'यह उपकरण एक सदस्य द्वारा हाल में किये गए परिवर्तनों के लिए काम में ली गई सारी IPs को जांचता है, अथवा एक IP का उपयोग करने वाले सभी सदस्यों को जांचता है।
एक मुवक्किल IP द्वारा किया गए संपादन एवं प्रयोग में ले रहे सभी सदस्यों को "/xff" से IP को जोड़ते हुए XFF शीर्षक के माध्यम से पता लगता है। IPv4 (CIDR 16-32) और IPv6 (CIDR 64-128) द्वारा प्रमाणित है।
प्रदर्शन के कारण कि वजह से ५००० सम्पादानों से ज्यादा नहीं दिखा पायेगा।
इसे नीति के अनुसार प्रयोग करें।',
	'checkuser-desc' => 'सदस्यको अन्य सदस्योंके आईपी एड्रेस एवम्‌ अन्य ज़ानकारी देखने की अनुमति देता हैं।',
	'checkuser-logcase' => 'लॉगमें खोज लिपी पर आधारित (case sensitive) हैं।',
	'checkuser' => 'सदस्य जाँच',
	'group-checkuser' => 'सदस्य जाँचे',
	'group-checkuser-member' => 'सदस्य जाँच',
	'right-checkuser' => 'सदस्य का आइपी एड्रेस एवम्‌ अन्य ज़ानकारी जाँचें',
	'grouppage-checkuser' => '{{ns:project}}: सदस्य जाँच',
	'checkuser-reason' => 'कारण',
	'checkuser-showlog' => 'लॉग दिखायें',
	'checkuser-log' => 'सदस्यजाँच लॉग',
	'checkuser-query' => 'हाल में हुए बदलाव देखें',
	'checkuser-target' => 'सदस्य या आईपी',
	'checkuser-users' => 'सदस्य खोजें',
	'checkuser-edits' => 'आईपीसे हुए बदलाव खोजें',
	'checkuser-ips' => 'आईपी खोजें',
	'checkuser-search' => 'खोजें',
	'checkuser-empty' => 'इस लॉगमें एकभी आइटेम नहीं हैं।',
	'checkuser-nomatch' => 'मिलते जुलते लॉग मिले नहीं।',
	'checkuser-check' => 'जाँचें',
	'checkuser-log-fail' => 'लॉग एन्ट्री बढा नहीं पायें।',
	'checkuser-nolog' => 'लॉग फ़ाईल मिली नहीं।',
	'checkuser-blocked' => 'ब्लॉक किया हुआ हैं',
	'checkuser-too-many' => 'बहुत सारे रिज़ल्ट, कृपया CIDRमें बदलाव करें।
नीचे इस्तेमाल हुए आईपी की सूची हैं (ज्यादा से ज्यादा ५०००, अनुक्रममें):',
	'checkuser-user-nonexistent' => 'दिया हुआ सदस्यनाम अस्तित्वमें नहीं हैं।',
	'checkuser-search-form' => 'ऐसे लॉग खोजें जहां $1 यह $2 हैं',
	'checkuser-search-submit' => 'खोजें',
	'checkuser-search-initiator' => 'चालक',
	'checkuser-search-target' => 'लक्ष्य',
	'checkuser-ipeditcount' => '~$1 सभी सदस्योंसे',
	'checkuser-log-subpage' => 'लॉग',
	'checkuser-log-return' => 'सदस्यजाँच मुखपृष्ठपर वापस जायें',
	'checkuser-log-userips' => '$1 के पास $2 के लिये आईपी हैं',
	'checkuser-log-ipedits' => '$1 के पास $2 के लिये बदलाव हैं',
	'checkuser-log-ipusers' => '$1 के पास $2 के लिये सदस्य हैं',
	'checkuser-log-ipedits-xff' => '$1 के पास $2 के लिये XFF बदलाव हैं',
	'checkuser-log-ipusers-xff' => '$1 के पास $2 के लिये XFF सदस्य हैं',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'checkuser-reason' => 'Rason',
	'checkuser-search' => 'Pangita-a',
	'checkuser-search-submit' => 'Pangita-a',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 * @author Suradnik13
 */
$messages['hr'] = array(
	'checkuser-summary' => 'Ovaj alat pretražuje nedavne promjene i pronalazi IP adrese suradnika ili prikazuje uređivanja/ime suradnika ako je zadana IP adresa. Suradnici i uređivanja mogu biti dobiveni po XFF zaglavljima dodavanjem "/xff" na kraj IP adrese. Podržane su IPv4 (CIDR 16-32) i IPv6 (CIDR 64-128) adrese. Rezultat ima maksimalno 5.000 zapisa iz tehničkih razloga. Rabite ovaj alat u skladu s pravilima.',
	'checkuser-desc' => 'Daje suradniku pravo za provjeriti IP adrese suradnika i druge informacije',
	'checkuser-logcase' => 'Pretraživanje evidencije razlikuje velika i mala slova',
	'checkuser' => 'Provjeri suradnika',
	'group-checkuser' => 'Provjeritelji',
	'group-checkuser-member' => 'Provjeritelj',
	'right-checkuser' => 'Provjeravanje IP adrese suradnika i drugih informacija',
	'right-checkuser-log' => 'Gledanje evidencije provjere suradnika',
	'grouppage-checkuser' => '{{ns:project}}:Provjeritelji',
	'checkuser-reason' => 'Razlog:',
	'checkuser-showlog' => 'Pokaži evidenciju',
	'checkuser-log' => 'Evidencija provjere suradnika',
	'checkuser-query' => 'Provjeri nedavne promjene',
	'checkuser-target' => 'Suradnik ili IP',
	'checkuser-users' => 'Suradnička imena',
	'checkuser-edits' => 'Uređivanja IP-a',
	'checkuser-ips' => 'IP adrese',
	'checkuser-account' => 'Uređivanja suradnika',
	'checkuser-search' => 'Traži',
	'checkuser-period' => 'Vrijeme:',
	'checkuser-week-1' => 'zadnji tjedan',
	'checkuser-week-2' => 'zadnja dva tjedna',
	'checkuser-month' => 'zadnjih 30 dana',
	'checkuser-all' => 'sve',
	'checkuser-empty' => 'Evidencija je prazna.',
	'checkuser-nomatch' => 'Nema suradnika s tom IP adresom.',
	'checkuser-nomatch-edits' => 'Nema poklapanja.
Zadnja izmjena je bila $1 u $2.',
	'checkuser-check' => 'Provjeri',
	'checkuser-log-fail' => 'Ne mogu dodati zapis',
	'checkuser-nolog' => 'Evidencijska datoteka nije nađena',
	'checkuser-blocked' => 'Blokiran',
	'checkuser-gblocked' => 'Globalno blokiran',
	'checkuser-locked' => 'Zaključan',
	'checkuser-wasblocked' => 'Prethodno blokiran',
	'checkuser-localonly' => 'Nije sjedinjen',
	'checkuser-massblock' => 'Blokiraj odabrane suradnike',
	'checkuser-massblock-text' => 'Odabrani suradnički računi će biti blokirani na neograničeno, s uključenim autoblokiranjem i onemogućenim stvaranjem novih računa.
IP adrese će biti blokirane na 1 tjedan samo za IP suradnike s onemogućenim stvaranjem računa.',
	'checkuser-blocktag' => 'Zamijeni suradničke stranica sa:',
	'checkuser-blocktag-talk' => 'Zamijeni stranice za razgovor sa:',
	'checkuser-massblock-commit' => 'Blokiraj odabrane suradnike',
	'checkuser-block-success' => "'''{{PLURAL:$2|suradnik|suradnici}} $1 {{PLURAL:$2|je blokiran|su blokirani}}.'''",
	'checkuser-block-failure' => "'''Nema blokiranih suradnika.'''",
	'checkuser-block-limit' => 'Odabrano je previše suradnika.',
	'checkuser-block-noreason' => 'Morate upisati razlog za blokiranje.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novi račun|novih računa}}',
	'checkuser-too-many' => 'Previše rezultata, molimo suzite opseg (CIDR). Slijede rabljene IP adrese (najviše njih 5000, poredano abecedno):',
	'checkuser-user-nonexistent' => 'Traženi suradnik (suradničko ime) ne postoji.',
	'checkuser-search-form' => 'Nađi zapise u evidenciji gdje $1 je $2',
	'checkuser-search-submit' => 'Traži',
	'checkuser-search-initiator' => 'provjeritelj',
	'checkuser-search-target' => 'cilj (traženi pojam)',
	'checkuser-ipeditcount' => '~$1 od svih suradnika',
	'checkuser-log-subpage' => 'Evidencija',
	'checkuser-log-return' => 'Vrati se na stranicu za provjeru',
	'checkuser-limited' => "'''Ovi rezultati su skraćeni zbog veće učinkovitosti izvođenja.'''",
	'checkuser-log-userips' => '$1 tražio je IP adrese suradnika $2',
	'checkuser-log-ipedits' => '$1 tražio je uređivanja suradnika $2',
	'checkuser-log-ipusers' => '$1 tražio je suradnička imena za IP adresu $2',
	'checkuser-log-ipedits-xff' => '$1 tražio je uređivanja za XFF $2',
	'checkuser-log-ipusers-xff' => '$1 tražio je imena suradnika za XFF $2',
	'checkuser-log-useredits' => '$1 tražio je uređivanja za $2',
	'checkuser-autocreate-action' => 'je automatski stvoren',
	'checkuser-email-action' => 'poslan email za "$1"',
	'checkuser-reset-action' => 'ponovno postavi lozinku za suradnika "$1"',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'checkuser-summary' => 'Tutón nastroj přepytuje aktualne změny, zo by IP-adresy wužiwarja zwěsćił abo změny abo wužiwarske daty za IP pokazał.
Wužiwarjo a změny IP-adresy dadźa so přez XFF-hłowy wotwołać, připowěšo "/xff" na IP-adresu. IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128) so podpěrujetej.',
	'checkuser-desc' => 'Dawa wužiwarjam z trěbnym prawom móžnosć IP-adresy a druhe informacije wužiwarja kontrolować',
	'checkuser-logcase' => 'Pytanje w protokolu rozeznawa mjez wulko- a małopisanjom.',
	'checkuser' => 'Wužiwarja kontrolować',
	'group-checkuser' => 'Kontrolerojo',
	'group-checkuser-member' => 'Kontroler',
	'right-checkuser' => 'Pruwowanje IP-adresow a druhe informacije wužiwarjow',
	'right-checkuser-log' => 'Protokol wužiwarskeje kontrole wobhladać',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Přičina',
	'checkuser-showlog' => 'Protokol pokazać',
	'checkuser-log' => 'Protokol wužiwarskeje kontrole',
	'checkuser-query' => 'Poslednje změny wotprašeć',
	'checkuser-target' => 'Wužiwar abo IP-adresa',
	'checkuser-users' => 'Wužiwarjow pokazać',
	'checkuser-edits' => 'Změny z IP-adresy přinjesć',
	'checkuser-ips' => 'IP-adresy pokazać',
	'checkuser-account' => 'Kontowe změny wobstarać',
	'checkuser-search' => 'Pytać',
	'checkuser-period' => 'Traće:',
	'checkuser-week-1' => 'posledni tydźeń',
	'checkuser-week-2' => 'poslednjej dwě njedźeli',
	'checkuser-month' => 'poslednich 30 dnjow',
	'checkuser-all' => 'wšitcy',
	'checkuser-empty' => 'Protokol njewobsahuje zapiski.',
	'checkuser-nomatch' => 'Žane wotpowědniki namakane.',
	'checkuser-nomatch-edits' => 'Žane wotpowědowanja namakane.
Poslednja změna bě $1 $2.',
	'checkuser-check' => 'Pruwować',
	'checkuser-log-fail' => 'Njemóžno protokolowy zapisk přidać.',
	'checkuser-nolog' => 'Žadyn protokol namakany.',
	'checkuser-blocked' => 'Zablokowany',
	'checkuser-gblocked' => 'Globalnje zablokowany',
	'checkuser-locked' => 'Zawrjeny',
	'checkuser-wasblocked' => 'Prjedy zablokowany',
	'checkuser-localonly' => 'njezjednoćene',
	'checkuser-massblock' => 'Wubranych wužiwarjow blokować',
	'checkuser-massblock-text' => 'Wubrane konta budu so na přeco blokować, awtomatiske blokowanje je aktiwne a załoženje kontow je znjemóžnjene.
IP-adresy budu so na 1 tydźeń blokować (jenož za IP-wužiwarjow) a załoženje kontow je znjemóžnjene.',
	'checkuser-blocktag' => 'Wužiwarske strony narunać přez:',
	'checkuser-blocktag-talk' => 'Diskusijne strony narunać přez:',
	'checkuser-massblock-commit' => 'Wubranych wužiwarjow blokować',
	'checkuser-block-success' => "'''{{PLURAL:$2|Wužiwar|Wužiwarjej|Wužiwarjo|Wužiwarjo}} $1 {{PLURAL:$2|bu|buštaj|buchu|buchu}} nětko {{PLURAL:$2|zablokowany|zablokowanaj|zablokowani|zablokowani}}.'''",
	'checkuser-block-failure' => "'''Žane wužiwarjo zablokowani.'''",
	'checkuser-block-limit' => 'Přewjele wužiwarjow wubrane.',
	'checkuser-block-noreason' => 'Dyrbiš přičinu za zablokowanja podać.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nowe konto|nowej konće|nowe konta|nowych kontow}}',
	'checkuser-too-many' => 'Přewjele wuslědkow, prošu zamjezuj IP-adresu:',
	'checkuser-user-nonexistent' => 'Podaty wužiwar njeeksistuje.',
	'checkuser-search-form' => 'Protokolowe zapiski namakać, hdźež $1 je $2',
	'checkuser-search-submit' => 'Pytać',
	'checkuser-search-initiator' => 'iniciator',
	'checkuser-search-target' => 'cil',
	'checkuser-ipeditcount' => '~$1 wot wšěch wužiwarjow',
	'checkuser-log-subpage' => 'Protokol',
	'checkuser-log-return' => 'Wróćo k hłownemu formularej CheckUser',
	'checkuser-limited' => "'''Tute wuslědki buchu z wukonowych přičinow wobrězane.'''",
	'checkuser-log-userips' => '$1 dósta IP za $2',
	'checkuser-log-ipedits' => '$1 dósta změny za $2',
	'checkuser-log-ipusers' => '$1 dósta wužiwarjow za $2',
	'checkuser-log-ipedits-xff' => '$1 dósta změny za XFF $2',
	'checkuser-log-ipusers-xff' => '$1 dósta wužiwarjow za XFF $2',
	'checkuser-log-useredits' => '$1 je změny za $2 wobstarał',
	'checkuser-autocreate-action' => 'bu awtomatisce załožene',
	'checkuser-email-action' => 'pósła e-mejlku na wužiwarja "$1"',
	'checkuser-reset-action' => 'hesło za wužiwarja "$1" wobnowić',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Dorgan
 * @author Grin
 * @author KossuthRad
 * @author Terik
 * @author Tgr
 */
$messages['hu'] = array(
	'checkuser-summary' => 'Ez az eszköz végigvizsgálja a friss változásokat, hogy lekérje egy adott felhasználó IP-címeit vagy megjelenítse egy adott IP-címet használó szerkesztőket és az IP szerkesztéseit.
Egy kliens IP-cím által végzett szerkesztések és felhasználói XFF fejlécek segítségével kérhetőek le, az IP-cím utáni „/xff” parancssal. Az IPv4 (CIDR 16-32) és az IPv6 (CIDR 64-128) is támogatott.
Maximum 5000 szerkesztés fog megjelenni teljesítményi okok miatt. Az eszközt a szabályoknak megfelelően használd.',
	'checkuser-desc' => 'Lehetővé teszi olyan felhasználói jogok kiosztását, mely segítségével megtekinthetőek a felhasználók IP-címei és más adatok',
	'checkuser-logcase' => 'A kereső kis- és nagybetűérzékeny.',
	'checkuser' => 'IP-ellenőr',
	'group-checkuser' => 'IP-ellenőrök',
	'group-checkuser-member' => 'IP-ellenőr',
	'right-checkuser' => 'a felhasználók IP-címének és más adatainak ellenőrzése',
	'right-checkuser-log' => 'IP-ellenőri napló megtekintése',
	'grouppage-checkuser' => '{{ns:project}}:IP-ellenőrök',
	'checkuser-reason' => 'Ok:',
	'checkuser-showlog' => 'Napló megjelenítése',
	'checkuser-log' => 'IP-ellenőr-napló',
	'checkuser-query' => 'Kétséges aktuális változások',
	'checkuser-target' => 'Felhasználó vagy IP-cím',
	'checkuser-users' => 'Felhasználók keresése',
	'checkuser-edits' => 'Szerkesztések keresése IP-cím alapján',
	'checkuser-ips' => 'IP-címek keresése',
	'checkuser-account' => 'A fiókhoz tartozó szerkesztések',
	'checkuser-search' => 'Keresés',
	'checkuser-period' => 'Időtartam:',
	'checkuser-week-1' => 'előző hét',
	'checkuser-week-2' => 'előző két hét',
	'checkuser-month' => 'előző harminc nap',
	'checkuser-all' => 'összes',
	'checkuser-empty' => 'A napló nem tartalmaz elemeket.',
	'checkuser-nomatch' => 'A párja nem található.',
	'checkuser-nomatch-edits' => 'Nincs találat.
Az utolsó szerkesztés $1, $2-kor történt.',
	'checkuser-check' => 'Ellenőrzés',
	'checkuser-log-fail' => 'Nem sikerült az elem hozzáadása',
	'checkuser-nolog' => 'A naplófájl nem található.',
	'checkuser-blocked' => 'Blokkolva',
	'checkuser-gblocked' => 'Globálisan blokkolva',
	'checkuser-locked' => 'Zárva',
	'checkuser-wasblocked' => 'Korábban blokkolva',
	'checkuser-localonly' => 'Nincs egységesítve',
	'checkuser-massblock' => 'Kijelölt szerkesztők blokkolása',
	'checkuser-massblock-text' => 'A kiválasztott fiókok örökre blokkolva lesznek autoblokkal és letiltott fiókkészítéssel.
Az IP-címeknél csak a be nem jelentkezett felhasználók lesznek blokkolva 1 hétre, letiltott fiókkészítéssel.',
	'checkuser-blocktag' => 'Szerkesztői lapok cseréje erre:',
	'checkuser-blocktag-talk' => 'Vitalapok cseréje erre:',
	'checkuser-massblock-commit' => 'Kiválasztott szerkesztők blokkolása',
	'checkuser-block-success' => "'''A következő szerkesztők blokkolva lettek: $1.'''",
	'checkuser-block-failure' => "'''Nem lettek szerkesztők blokkolva.'''",
	'checkuser-block-limit' => 'Túl sok szerkesztőt választottál ki.',
	'checkuser-block-noreason' => 'Meg kell adnod a blokkolások okát.',
	'checkuser-accounts' => '{{PLURAL:$1|egy|$1}} új felhasználói fiók',
	'checkuser-too-many' => 'Túl sok eredmény, kérlek szűkítsd le a CIDR-t. Itt vannak a használt IP-címek (maximum 5000, cím alapján rendezve):',
	'checkuser-user-nonexistent' => 'A megadott szerkesztő nem létezik.',
	'checkuser-search-form' => 'Naplóbejegyzések keresése, ahol $1 $2',
	'checkuser-search-submit' => 'Keresés',
	'checkuser-search-initiator' => 'kezdeményező',
	'checkuser-search-target' => 'Cél',
	'checkuser-ipeditcount' => '~$1 az összes szerkesztő által',
	'checkuser-log-subpage' => 'Lista',
	'checkuser-log-return' => 'Vissza az IP-ellenőri oldalra',
	'checkuser-limited' => "'''Teljesítményi okok miatt nem az összes találat lett megjelenítve.'''",
	'checkuser-log-userips' => '$1 lekérte $2 IP-címeit',
	'checkuser-log-ipedits' => '$1 lekérte $2 szerkesztéseit',
	'checkuser-log-ipusers' => '$1 lekérte a(z) $2 IP-címhez tarzozó szerkesztőket',
	'checkuser-log-ipedits-xff' => '$1 lekérte XFF $2 szerkesztéseit',
	'checkuser-log-ipusers-xff' => '$1 lekérte XFF $2 szerkesztőit',
	'checkuser-autocreate-action' => 'automatikusan létrehozva',
	'checkuser-email-action' => 'e-mailt küldött „$1” szerkesztőnek',
	'checkuser-reset-action' => 'lecserélte „$1” jelszavát',
);

/** Armenian (Հայերեն)
 * @author Togaed
 */
$messages['hy'] = array(
	'checkuser-search' => 'Որոնել',
	'checkuser-search-submit' => 'Որոնել',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'checkuser-summary' => 'Iste instrumento analysa le modificationes recente pro recuperar le adresses IP usate per un usator o pro monstrar le datos de modificationes e de usatores pro un adresse IP.
Le usatores e modificationes facite desde un adresse IP de cliente pote esser recuperate via capites XFF per appender "/xff" al IP.
Es supportate le adresses IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
Non plus de 5000 modificationes essera retornate pro motivos de prestationes.
Tote uso de iste instrumento debe esser conforme al politicas in vigor.',
	'checkuser-desc' => 'Concede al usatores con le autorisation appropriate le capabilitate de verificar le adresses IP e altere informationes de usatores',
	'checkuser-logcase' => 'Le recerca del registros distingue inter majusculas e minusculas.',
	'checkuser' => 'Verificar usator',
	'group-checkuser' => 'Verificatores de usatores',
	'group-checkuser-member' => 'Verificator de usatores',
	'right-checkuser' => 'Verificar le adresses IP e altere informationes del usator',
	'right-checkuser-log' => 'Vider le registro de verification de usatores',
	'grouppage-checkuser' => '{{ns:project}}:Verificar usator',
	'checkuser-reason' => 'Motivo:',
	'checkuser-showlog' => 'Monstrar registro',
	'checkuser-log' => 'Registro de verification de usatores',
	'checkuser-query' => 'Consultar le modificationes recente',
	'checkuser-target' => 'Usator o IP',
	'checkuser-users' => 'Cercar usatores',
	'checkuser-edits' => 'Cercar modificationes desde IP',
	'checkuser-ips' => 'Cercar IPs',
	'checkuser-account' => 'Obtener modificationes del conto',
	'checkuser-search' => 'Cercar',
	'checkuser-period' => 'Durata:',
	'checkuser-week-1' => 'ultime septimana',
	'checkuser-week-2' => 'ultime duo septimanas',
	'checkuser-month' => 'ultime 30 dies',
	'checkuser-all' => 'totes',
	'checkuser-empty' => 'Le registro non contine entratas.',
	'checkuser-nomatch' => 'Nihil trovate.',
	'checkuser-nomatch-edits' => 'Nulle resultato trovate.
Le ultime modification esseva le $1 a $2.',
	'checkuser-check' => 'Verificar',
	'checkuser-log-fail' => 'Impossibile adder entrata al registro',
	'checkuser-nolog' => 'Nulle file de registro trovate.',
	'checkuser-blocked' => 'Blocate',
	'checkuser-gblocked' => 'Globalmente blocate',
	'checkuser-locked' => 'Serrate',
	'checkuser-wasblocked' => 'Anteriormente blocate',
	'checkuser-localonly' => 'Non unificate',
	'checkuser-massblock' => 'Blocar usatores seligite',
	'checkuser-massblock-text' => 'Le contos seligite essera blocate infinitemente, con le blocada automatic activate e le creation de contos disactivate.
Le adresses IP essera blocate durante 1 septimana pro usatores IP solmente e con le creation de contos disactivate.',
	'checkuser-blocktag' => 'Reimplaciar paginas de usatores con:',
	'checkuser-blocktag-talk' => 'Reimplaciar le paginas de discussion per:',
	'checkuser-massblock-commit' => 'Blocar usatores seligite',
	'checkuser-block-success' => "'''Le {{PLURAL:$2|usator|usatores}} $1 es ora blocate.'''",
	'checkuser-block-failure' => "'''Nulle usator blocate.'''",
	'checkuser-block-limit' => 'Troppo de usatores seligite.',
	'checkuser-block-noreason' => 'Tu debe indicar un motivo pro le blocadas.',
	'checkuser-accounts' => '$1 nove {{PLURAL:$1|conto|contos}}',
	'checkuser-too-many' => 'Troppo de resultatos. Per favor restringe le CIDR.
Ecce le IPs usate (5000 max, ordinate per adresse):',
	'checkuser-user-nonexistent' => 'Le usator specificate non existe.',
	'checkuser-search-form' => 'Cercar entratas in le registro ubi le $1 es $2',
	'checkuser-search-submit' => 'Cercar',
	'checkuser-search-initiator' => 'initiator',
	'checkuser-search-target' => 'objectivo',
	'checkuser-ipeditcount' => '~$1 de tote le usatores',
	'checkuser-log-subpage' => 'Registro',
	'checkuser-log-return' => 'Retornar al formulario principal del verification de usatores',
	'checkuser-limited' => "'''Iste resultatos ha essite truncate pro motivos de prestationes.'''",
	'checkuser-log-userips' => '$1 obteneva IPs pro $2',
	'checkuser-log-ipedits' => '$1 obteneva modificationes pro $2',
	'checkuser-log-ipusers' => '$1 obteneva usatores pro $2',
	'checkuser-log-ipedits-xff' => '$1 obteneva modificationes pro XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteneva usatores pro XFF $2',
	'checkuser-log-useredits' => '$1 obteneva modificationes de $2',
	'checkuser-autocreate-action' => 'ha essite create automaticamente',
	'checkuser-email-action' => 'inviava un e-mail al usator "$1"',
	'checkuser-reset-action' => 'redefiniva contrasigno pro usator "$1"',
);

/** Indonesian (Bahasa Indonesia)
 * @author Borgx
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'checkuser-summary' => 'Peralatan ini memindai perubahan terbaru untuk mendapatkan IP yang digunakan oleh seorang pengguna atau menunjukkan data suntingan/pengguna untuk suatu IP.
	Pengguna dan suntingan dapat diperoleh dari suatu IP XFF dengan menambahkan "/xff" pada suatu IP. IPv4 (CIDR 16-32) dan IPv6 (CIDR 64-128) dapat digunakan.
	Karena alasan kinerja, maksimum hanya 5000 suntingan yang dapat diambil. Harap gunakan peralatan ini sesuai dengan kebijakan yang ada.',
	'checkuser-desc' => 'Memberikan fasilitas bagi pengguna yang memiliki hak akses untuk memeriksa alamat IP dan informasi lain dari pengguna',
	'checkuser-logcase' => 'Log ini bersifat sensitif terhadap kapitalisasi.',
	'checkuser' => 'Pemeriksaan pengguna',
	'group-checkuser' => 'Pemeriksa',
	'group-checkuser-member' => 'Pemeriksa',
	'right-checkuser' => 'Periksa alamat IP pengguna dan informasi lainnya',
	'right-checkuser-log' => 'Tampilkan log pemeriksa',
	'grouppage-checkuser' => '{{ns:project}}:Pemeriksa',
	'checkuser-reason' => 'Alasan',
	'checkuser-showlog' => 'Tampilkan log',
	'checkuser-log' => 'Log pemeriksaan pengguna',
	'checkuser-query' => 'Kueri perubahan terbaru',
	'checkuser-target' => 'Pengguna atau IP',
	'checkuser-users' => 'Cari pengguna',
	'checkuser-edits' => 'Cari suntingan dari IP',
	'checkuser-ips' => 'Cari IP',
	'checkuser-account' => 'Lihat suntingan-suntingan akun',
	'checkuser-search' => 'Cari',
	'checkuser-period' => 'Jangka waktu:',
	'checkuser-week-1' => 'minggu lalu',
	'checkuser-week-2' => 'dua minggu terakhir',
	'checkuser-month' => '30 hari terakhir',
	'checkuser-all' => 'semua',
	'checkuser-empty' => 'Log kosong.',
	'checkuser-nomatch' => 'Data yang sesuai tidak ditemukan.',
	'checkuser-nomatch-edits' => 'Tidak ditemukan hasil sesuai kriteria yang diberikan. Suntingan terakhir dilakukan pada $2, $1.',
	'checkuser-check' => 'Periksa',
	'checkuser-log-fail' => 'Entri log tidak dapat ditambahkan',
	'checkuser-nolog' => 'Berkas log tidak ditemukan.',
	'checkuser-blocked' => 'Diblok',
	'checkuser-gblocked' => 'Diblokir secara global',
	'checkuser-locked' => 'Terkunci',
	'checkuser-wasblocked' => 'Telah diblokir sebelumnya',
	'checkuser-massblock' => 'Blokir pengguna yang dipilih',
	'checkuser-massblock-text' => 'Akun-akun yang dipilih akan diblokir selamanya, alamat-alamat IP terakhir yang digunakan otomatis diblokir dan tidak diperbolehkan membuat akun.
Alamat-alamat IP akan diblokir selama 1 minggu untuk pengguna anonim dan tidak diperbolehkan membuat akun.',
	'checkuser-blocktag' => 'Ganti halaman pengguna dengan:',
	'checkuser-massblock-commit' => 'Blokir pengguna yang dipilih',
	'checkuser-block-success' => "'''{{PLURAL:$2|Pengguna|Pengguna}} $1 berhasil diblokir.'''",
	'checkuser-block-failure' => "'''Tidak ada pengguna yang diblokir.'''",
	'checkuser-block-limit' => 'Jumlah pengguna yang dipilih terlalu banyak.',
	'checkuser-block-noreason' => 'Anda harus mengisi alasan pemblokiran.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|akun|akun-akun}} baru',
	'checkuser-too-many' => 'Terlalu banyak hasil pencarian, mohon persempit CIDR. Berikut adalah alamat-alamat IP yang digunakan (5000 maks, diurut berdasarkan alamat):',
	'checkuser-user-nonexistent' => 'Pengguna tidak eksis',
	'checkuser-search-form' => 'Cari catatan log dimana $1 adalah $2',
	'checkuser-search-submit' => 'Cari',
	'checkuser-search-initiator' => 'pemeriksa',
	'checkuser-search-target' => 'target',
	'checkuser-ipeditcount' => '~$1 dari seluruh pengguna',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Kembali ke halaman utama Pemeriksa',
	'checkuser-limited' => "'''Hasil berikut telah dipotong agar tidak menurunkan kinerja.'''",
	'checkuser-log-userips' => '$1 melihat IP dari $2',
	'checkuser-log-ipedits' => '$1 melihat suntingan dari $2',
	'checkuser-log-ipusers' => '$1 melihat nama pengguna dari $2',
	'checkuser-log-ipedits-xff' => '$1 melihat suntingan dari XFF $2',
	'checkuser-log-ipusers-xff' => '$1 melihat nama pengguna dari XFF $2',
	'checkuser-log-useredits' => '$1 memiliki suntingan-suntingan untuk $2',
	'checkuser-autocreate-action' => 'dibuat secara otomatis',
	'checkuser-email-action' => 'mengirimkan surat-e ke "$1"',
	'checkuser-reset-action' => 'Set ulang kata sandi pengguna "$1"',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'checkuser-reason' => 'Motivo',
	'checkuser-search-submit' => 'Serchar',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author Spacebirdy
 */
$messages['is'] = array(
	'checkuser' => 'Athuga notanda',
	'group-checkuser' => 'Athuga notendur',
	'group-checkuser-member' => 'Athuga notanda',
	'checkuser-reason' => 'Ástæða',
	'checkuser-showlog' => 'Sýna skrá',
	'checkuser-query' => 'Sækja nýlegar breytingar',
	'checkuser-target' => 'Notandi eða vistfang',
	'checkuser-users' => 'Sækja notendur',
	'checkuser-edits' => 'Sækja breytingar eftir vistang',
	'checkuser-ips' => 'Sækja vistföng',
	'checkuser-search' => 'Leita',
	'checkuser-nomatch' => 'Engin samsvörun fannst.',
	'checkuser-check' => 'Athuga',
	'checkuser-nolog' => 'Engin skrá fundin.',
	'checkuser-blocked' => 'Bannaður',
	'checkuser-search-submit' => 'Leita',
	'checkuser-log-subpage' => 'Skrá',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author BrokenArrow
 * @author Darth Kule
 * @author Gianfranco
 * @author Melos
 */
$messages['it'] = array(
	'checkuser-summary' => 'Questo strumento analizza le modifiche recenti per recuperare gli indirizzi IP utilizzati da un utente o mostrare contributi e dati di un IP. Utenti e contributi di un client IP possono essere rintracciati attraverso gli header XFF aggiungendo all\'IP il suffisso "/xff". Sono supportati IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). Non saranno restituite più di 5.000 modifiche, per ragioni di prestazioni. Usa questo strumento in stretta conformità alle policy.',
	'checkuser-desc' => 'Consente agli utenti con le opportune autorizzazioni di sottoporre a verifica gli indirizzi IP e altre informazioni relative agli utenti',
	'checkuser-logcase' => "La ricerca nei log è ''case sensitive'' (distingue fra maiuscole e minuscole).",
	'checkuser' => 'Controllo utenze',
	'group-checkuser' => 'Controllori',
	'group-checkuser-member' => 'Controllore',
	'right-checkuser' => "Visualizza gli indirizzi IP usati dall'utente e altre informazioni",
	'right-checkuser-log' => 'Visualizza il log dei checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Controllo utenze',
	'checkuser-reason' => 'Motivazione:',
	'checkuser-showlog' => 'Mostra il log',
	'checkuser-log' => 'Log dei checkuser',
	'checkuser-query' => 'Cerca nelle ultime modifiche',
	'checkuser-target' => 'Utente o IP',
	'checkuser-users' => 'Cerca utenti',
	'checkuser-edits' => 'Vedi i contributi degli IP',
	'checkuser-ips' => 'Cerca IP',
	'checkuser-account' => "Vedi i contributi dell'account",
	'checkuser-search' => 'Cerca',
	'checkuser-period' => 'Periodo:',
	'checkuser-week-1' => 'ultima settimana',
	'checkuser-week-2' => 'ultime due settimane',
	'checkuser-month' => 'ultimi 30 giorni',
	'checkuser-all' => 'tutti gli edit',
	'checkuser-empty' => 'Il log non contiene dati.',
	'checkuser-nomatch' => 'Nessun risultato trovato.',
	'checkuser-nomatch-edits' => 'Nessun risultato trovato.
Ultimo edit risalente alle $2 del $1.',
	'checkuser-check' => 'Controlla',
	'checkuser-log-fail' => 'Impossibile aggiungere la voce al log',
	'checkuser-nolog' => 'Non è stato trovato alcun file di log.',
	'checkuser-blocked' => 'Bloccato',
	'checkuser-gblocked' => 'Bloccato globalmente',
	'checkuser-wasblocked' => 'Bloccato precedentemente',
	'checkuser-massblock' => 'Blocca utenti selezionati',
	'checkuser-massblock-text' => 'Gli account selezionati saranno bloccati infinito, con il blocco automatico attivato e la creazione di nuovi account disattivata.
Gli indirizzi IP saranno bloccati per una settimana solo per gli utenti anonimi e con la creazione account disattivata.',
	'checkuser-blocktag' => 'Sostituisci pagine utente con:',
	'checkuser-blocktag-talk' => 'Sostituisci pagine di discussione con:',
	'checkuser-massblock-commit' => 'Blocca utenti selezionati',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utente|Gli utenti}} $1 {{PLURAL:$2|è adesso bloccato|sono adesso bloccati}}.'''",
	'checkuser-block-failure' => "'''Nessun utente bloccato.'''",
	'checkuser-block-limit' => 'Troppi utenti selezionati.',
	'checkuser-block-noreason' => 'È obbligatorio fornire una motivazione per i blocchi.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nuovo|nuovi}} account',
	'checkuser-too-many' => 'Il numero di risultati è eccessivo, usare un CIDR più ristretto. Di seguito sono indicati gli indirizzi IP utilizzati (fino a un massimo di 5000, ordinati per indirizzo):',
	'checkuser-user-nonexistent' => "L'utente indicato non esiste.",
	'checkuser-search-form' => 'Trova le voci del log per le quali $1 è $2',
	'checkuser-search-submit' => 'Ricerca',
	'checkuser-search-initiator' => 'iniziatore',
	'checkuser-search-target' => 'obiettivo',
	'checkuser-ipeditcount' => '~$1 complessivamente',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Torna al modulo principale di Controllo utenze',
	'checkuser-limited' => "'''I risultati sono stati troncati per motivi di prestazioni.'''",
	'checkuser-log-userips' => '$1 ha ottenuto gli indirizzi IP di $2',
	'checkuser-log-ipedits' => '$1 ha ottenuto le modifiche di $2',
	'checkuser-log-ipusers' => '$1 ha ottenuto le utenze di $2',
	'checkuser-log-ipedits-xff' => '$1 ha ottenuto le modifiche di $2 via XFF',
	'checkuser-log-ipusers-xff' => '$1 ha ottenuto le utenze di $2 via XFF',
	'checkuser-log-useredits' => '$1 ha ottenuto i contributi di $2',
	'checkuser-autocreate-action' => 'è stato creato automaticamente',
	'checkuser-email-action' => 'ha inviato una e-mail a "$1"',
	'checkuser-reset-action' => 'reimposta password per l\'utente "$1"',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Kahusi
 * @author Marine-Blue
 * @author Muttley
 * @author Suisui
 */
$messages['ja'] = array(
	'checkuser-summary' => 'このツールは最近の更新から行った調査を元に、ある利用者が使用したIPアドレスの検索、または、あるIPアドレスからなされた編集および利用者名の表示を行います。
IPアドレスと共に「/xff」オプションを指定すると、XFF（X-Forwarded-For）ヘッダを通じてクライアントIPアドレスを取得し、そこからなされた編集および利用者名の検索をすることが可能です。
IPv4（16から32ビットのCIDR表記）と IPv6（64から128ビットのCIDR表記）をサポートしています。
パフォーマンス上の理由により、5000件の編集しか返答出来ません。
「チェックユーザーの方針」に従って利用してください。',
	'checkuser-desc' => '特定の権限を付与された利用者に対して、利用者のIPアドレスなどの情報のチェックを可能にする',
	'checkuser-logcase' => 'ログの検索では大文字と小文字を区別します。',
	'checkuser' => 'チェックユーザー',
	'group-checkuser' => 'チェックユーザー',
	'group-checkuser-member' => 'チェックユーザー',
	'right-checkuser' => '利用者のIPアドレスやその他の情報を確認する',
	'right-checkuser-log' => 'チェックユーザー記録を見る',
	'grouppage-checkuser' => '{{ns:project}}:チェックユーザー',
	'checkuser-reason' => '理由:',
	'checkuser-showlog' => 'ログを閲覧',
	'checkuser-log' => 'チェックユーザー記録',
	'checkuser-query' => '最近の更新を照会',
	'checkuser-target' => '利用者名またはIPアドレス',
	'checkuser-users' => '利用者名を得る',
	'checkuser-edits' => 'IPアドレスからの編集を得る',
	'checkuser-ips' => 'IPアドレスを得る',
	'checkuser-account' => 'アカウントの投稿記録を取得する',
	'checkuser-search' => '検索',
	'checkuser-period' => '期間:',
	'checkuser-week-1' => '先週',
	'checkuser-week-2' => '前2週',
	'checkuser-month' => '前30日間',
	'checkuser-all' => 'すべて',
	'checkuser-empty' => 'ログ内にアイテムがありません。',
	'checkuser-nomatch' => '該当するものはありません。',
	'checkuser-nomatch-edits' => '該当するものはありません。
最終編集は $1 $2 です。',
	'checkuser-check' => '調査',
	'checkuser-log-fail' => 'ログに追加することができません',
	'checkuser-nolog' => 'ログファイルが見つかりません。',
	'checkuser-blocked' => 'ブロック済み',
	'checkuser-gblocked' => 'グローバルブロックされています',
	'checkuser-locked' => 'ロックされています',
	'checkuser-wasblocked' => 'ブロック経験あり',
	'checkuser-localonly' => '統一されません',
	'checkuser-massblock' => '選択した利用者をブロックする',
	'checkuser-massblock-text' => '選択した利用者は無期限ブロックされ、同時に自動ブロックが作動しアカウント作成も禁止されます。IPアドレスはIP利用者向けに1週間ブロックされ、アカウント作成が禁止されます。',
	'checkuser-blocktag' => '利用者ページを以下で置き換える:',
	'checkuser-blocktag-talk' => 'ノートページを置換:',
	'checkuser-massblock-commit' => '選択した利用者をブロックする',
	'checkuser-block-success' => "'''$2人の利用者 $1 が現在ブロックされています。'''",
	'checkuser-block-failure' => "'''ブロックされたユーザーはありません。'''",
	'checkuser-block-limit' => '利用者の選択数が多すぎます。',
	'checkuser-block-noreason' => 'ブロック理由の記入が必要です。',
	'checkuser-accounts' => '$1つの新しいアカウント',
	'checkuser-too-many' => '検索結果が多すぎます、CIDRの指定を小さく絞り込んでください。利用されたIPは以下の通りです（5000件を上限に、アドレス順でソートされています）:',
	'checkuser-user-nonexistent' => '指定されたユーザーは存在しません。',
	'checkuser-search-form' => 'ログ検索条件　$1 が $2',
	'checkuser-search-submit' => '検索',
	'checkuser-search-initiator' => 'チェック実行者',
	'checkuser-search-target' => 'チェック対象',
	'checkuser-ipeditcount' => '全利用者 -$1',
	'checkuser-log-subpage' => 'ログ',
	'checkuser-log-return' => 'チェックユーザーのメインフォームへ戻る',
	'checkuser-limited' => "'''パフォーマンスの都合から結果は省略されています。'''",
	'checkuser-log-userips' => '$1 は $2 が使用したIPアドレスを取得した',
	'checkuser-log-ipedits' => '$1 は $2 からなされた編集を取得した',
	'checkuser-log-ipusers' => '$1 は $2 からアクセスされた利用者名を取得した',
	'checkuser-log-ipedits-xff' => '$1 は XFF $2 からなされた編集を取得した',
	'checkuser-log-ipusers-xff' => '$1 は XFF $2 からアクセスされた利用者名を取得した',
	'checkuser-log-useredits' => '$1 は $2 への編集があります',
	'checkuser-autocreate-action' => '自動的に作成',
	'checkuser-email-action' => '利用者"$1"へメールを送る',
	'checkuser-reset-action' => '利用者"$1"のパスワードをリセット',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'checkuser-summary' => 'Dette værktøj scanner Seneste ændringer for at finde IP\'er brugt af en bestemt bruger, eller for at vise redigerings- eller brugerdata for en IP.
Bruger og redigeringer fra en klient IP kan hentes via XFF headers ved at tilføje "/xff" til IP\'en. Ipv4 (CIRD 16-32) og IPv6 (CIDR 64-128) er understøttet.
For at sikre programmelets ydeevne kan maksimalt 5000 redigeringer returneres. Brug kun dette værktøj i overensstemmelse med gældende politiker på {{SITENAME}}.',
	'checkuser-desc' => 'Giver brugere med den rette godkendelse muligheden for at checke brugeres IP-adresser og anden information',
	'checkuser-logcase' => 'Logsøgning er case sensitiv (der gøres forskel på store og små bogstaver)',
	'checkuser' => 'Check user',
	'group-checkuser' => 'Check users',
	'group-checkuser-member' => 'Check user',
	'grouppage-checkuser' => '{{ns:project}}:Check user',
	'checkuser-reason' => 'Begrundelse',
	'checkuser-showlog' => "Se'n log",
	'checkuser-log' => 'CheckUser log',
	'checkuser-query' => 'Søĝ i seneste ændrenger',
	'checkuser-target' => 'Bruger æller IP',
	'checkuser-users' => 'Gæt bruger!',
	'checkuser-edits' => 'Gæt redigærer IPs!',
	'checkuser-ips' => 'Gæt IP!',
	'checkuser-search' => 'Søĝ',
	'checkuser-empty' => 'Loggen indeholder ingen poster.',
	'checkuser-nomatch' => 'Ingen matchende resultater blev fundet.',
	'checkuser-check' => 'Check',
	'checkuser-log-fail' => 'Kunne ikke tilføje log-post',
	'checkuser-nolog' => 'Logfilen blev ikke fundet.',
	'checkuser-blocked' => 'Blokeret',
	'checkuser-too-many' => "For mange resultater, gør CIDR'en smallere. Her er de brugte IP'er (max 5000, sorteret efter adresse):",
	'checkuser-user-nonexistent' => 'Den anførte bruger eksisterer ikke.',
	'checkuser-search-form' => 'Find log-poster hvor $1 er $2',
	'checkuser-search-submit' => 'Søg',
	'checkuser-search-initiator' => 'initiatår',
	'checkuser-search-target' => 'mål',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Gå tilbage til hovedformularen for checkbruger',
	'checkuser-log-userips' => "$1 fik IP'er for $2",
	'checkuser-log-ipedits' => '$1 fik redigeringer for $2',
	'checkuser-log-ipusers' => '$1 fik brugere for $2',
	'checkuser-log-ipedits-xff' => '$1 fik redigeringer for XFF $2',
	'checkuser-log-ipusers-xff' => '$1 fik brugere for XFF $2',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'checkuser-summary' => 'Piranti iki nlusuri owah-owahan pungkasan kanggo golèk IP sing dienggo déning sawijining panganggo utawa nuduhaké data suntingan/panganggo kanggo sawijining IP.
Panganggo lan suntingan bisa dirunut saka sawijining IP XFF mawa nambahaké "/xff" ing sawijining IP. IPv4 (CIDR 16-32) IPv6 (CIDR 64-128) bisa dienggo.
Amerga déning alesan kinerja, ora luwih saka 5.000 suntingan sing bisa dijupuk. Mangga gunakna piranti iki miturut kawicaksanan sing wis ditetepaké.',
	'checkuser-desc' => 'Mènèhi panganggo fasilitas kanggo panganggo sing duwé idin kanggo mriksa alamat IP panganggo lan informasi liyané',
	'checkuser-logcase' => 'Log iki sènsitif marang panrapan aksara gedhé apa cilik',
	'checkuser' => 'Pamriksan panganggo',
	'group-checkuser' => 'Pamriksa panganggo',
	'group-checkuser-member' => 'Pamriksa panganggo',
	'right-checkuser' => 'Priksa alamat-alamat IP panganggo lan informasi liyané',
	'right-checkuser-log' => 'Pirsani log pamriksa',
	'grouppage-checkuser' => '{{ns:project}}:Pamriksa panganggo',
	'checkuser-reason' => 'Alesan:',
	'checkuser-showlog' => 'Tuduhna log',
	'checkuser-log' => 'Log pamriksan panganggo',
	'checkuser-query' => 'Pitakonan owah-owahan pungkasan',
	'checkuser-target' => 'Panganggo utawa IP',
	'checkuser-users' => 'Golèk panganggo',
	'checkuser-edits' => 'Golèk suntingan saka IP',
	'checkuser-ips' => 'Golèk IP',
	'checkuser-account' => 'Pirsani suntingan-suntingan akun',
	'checkuser-search' => 'Golèk',
	'checkuser-period' => 'Jangka wektu:',
	'checkuser-week-1' => 'minggu kapungkur',
	'checkuser-week-2' => 'rong minggu kapungkur',
	'checkuser-month' => '30 dina pungkasan',
	'checkuser-all' => 'kabèh',
	'checkuser-empty' => 'Log iki kosong.',
	'checkuser-nomatch' => 'Ora ana data sing cocog bisa ditemokaké.',
	'checkuser-nomatch-edits' => 'Ora ana sing cocog.
Suntingan pungkasan ing $2, $1.',
	'checkuser-check' => 'Priksa',
	'checkuser-log-fail' => 'Log èntri ora bisa ditambahaké',
	'checkuser-nolog' => 'Ora ditemokaké berkas log.',
	'checkuser-blocked' => 'Diblokir',
	'checkuser-gblocked' => 'Diblokir sacara global',
	'checkuser-locked' => 'Dikunci',
	'checkuser-wasblocked' => 'Wis diblokir sadurungé',
	'checkuser-massblock' => 'Blokir panganggo kapilih',
	'checkuser-massblock-text' => 'Akun-akun kapilih bakal diblokir salawasé, alamat-alamat IP pungkasan sing dipigunakaké otomatis diblokir lan ora bisa gawé akun.
Alamat-alamat IP bakal diblokir jroning 1 minggu tumrap panganggo anonim lan ora bisa gawé akun.',
	'checkuser-blocktag' => 'Ganti kaca panganggo dadi:',
	'checkuser-blocktag-talk' => 'Ganti kaca wicara nganggo:',
	'checkuser-massblock-commit' => 'Blokir panganggo kapilih',
	'checkuser-block-success' => "'''{{PLURAL:$2|Panganggo|panganggo}} $1 {{PLURAL:$2|wis|wis}} diblokir.'''",
	'checkuser-block-failure' => "'''Ora ana panganggo sing diblokir.'''",
	'checkuser-block-limit' => 'Cacahing panganggo sing dipilih kakèhan.',
	'checkuser-block-noreason' => 'Panjenengan kudu mènèhi alesan pamblokiran',
	'checkuser-accounts' => '$1 {{PLURAL:$1|akun|akun-akun}} anyar',
	'checkuser-too-many' => 'Kakèhan pituwas, tulung CIDR diciyutaké.
Ing ngisor iki kapacak alamat-alamat IP sing dienggo (maks. 5.000, diurutaké adhedhasar alamat):',
	'checkuser-user-nonexistent' => 'Panganggo iki ora ana.',
	'checkuser-search-form' => 'Temokna cathetan log ing ngendi $1 iku $2',
	'checkuser-search-submit' => 'Golèk',
	'checkuser-search-initiator' => 'pamriksa',
	'checkuser-search-target' => 'tujuan',
	'checkuser-ipeditcount' => '~$1 saka kabèh panganggo',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Bali menyang kaca utama pamriksa',
	'checkuser-limited' => "'''Kasil iki wis dicekak amarga alesan kinerja.'''",
	'checkuser-log-userips' => '$1 ndeleng IP saka $2',
	'checkuser-log-ipedits' => '$1 ndeleng suntingan saka $2',
	'checkuser-log-ipusers' => '$1 ndeleng jeneng panganggo saka $2',
	'checkuser-log-ipedits-xff' => '$1 ndeleng suntingan saka XFF $2',
	'checkuser-log-ipusers-xff' => '$1 ndeleng jeneng panganggo saka XFF $2',
	'checkuser-log-useredits' => '$1 nduwèni suntingan-suntingan kanggo $2',
	'checkuser-autocreate-action' => 'digawé sacara otomatis',
	'checkuser-email-action' => 'Wis ngirim layang-e menyang panganggo "$1"',
	'checkuser-reset-action' => 'Sèt ulang tembung sandi panganggo "$1"',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'checkuser-reason' => 'მიზეზი:',
	'checkuser-search' => 'ძიება',
	'checkuser-all' => 'ყველა',
	'checkuser-log-subpage' => 'ჟურნალი',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'checkuser-summary' => 'بۇل قۇرال پايدالانۋشى قولدانعان IP جايلار ٴۇشىن, نەمەسە IP جاي تۇزەتۋ/پايدالانۋشى دەرەكتەرىن كورسەتۋ ٴۇشىن جۋىقتاعى وزگەرىستەردى قاراپ شىعادى.
	پايدالانۋشىلاردى مەن تۇزەتۋلەردى XFF IP ارقىلى IP جايعا «/xff» دەگەندى قوسىپ كەلتىرۋگە بولادى. IPv4 (CIDR 16-32) جانە IPv6 (CIDR 64-128) ارقاۋلانادى.
	ورىنداۋشىلىق سەبەپتەرىمەن 5000 تۇزەتۋدەن ارتىق قايتارىلمايدى. بۇنى ەرەجەلەرگە سايكەس پايدالانىڭىز.',
	'checkuser-logcase' => 'جۋرنالدان ىزدەۋ ٴارىپ باس-كىشىلىگىن ايىرادى.',
	'checkuser' => 'قاتىسۋشىنى سىناۋ',
	'group-checkuser' => 'قاتىسۋشى سىناۋشىلار',
	'group-checkuser-member' => 'قاتىسۋشى سىناۋشى',
	'grouppage-checkuser' => '{{ns:project}}:قاتىسۋشىنى سىناۋ',
	'checkuser-reason' => 'سەبەبى',
	'checkuser-showlog' => 'جۋرنالدى كورسەت',
	'checkuser-log' => 'قاتىسۋشى سىناۋ جۋرنالى',
	'checkuser-query' => 'جۋىقتاعى وزگەرىستەردى سۇرانىمداۋ',
	'checkuser-target' => 'قاتىسۋشى اتى / IP جاي',
	'checkuser-users' => 'قاتىسۋشىلاردى كەلتىرۋ',
	'checkuser-edits' => 'IP جايدان جاسالعان تۇزەتۋلەردى كەلتىرۋ',
	'checkuser-ips' => 'IP جايلاردى كەلتىرۋ',
	'checkuser-search' => 'ىزدەۋ',
	'checkuser-empty' => 'جۋرنالدا ەش جازبا جوق.',
	'checkuser-nomatch' => 'سايكەس تابىلمادى.',
	'checkuser-check' => 'سىناۋ',
	'checkuser-log-fail' => 'جۋرنالعا جازبا ۇستەلىنبەدى',
	'checkuser-nolog' => 'جۋرنال فايلى تابىلمادى.',
	'checkuser-blocked' => 'بۇعاتتالعان',
	'checkuser-too-many' => 'تىم كوپ ناتىيجە كەلتىرىلدى, CIDR دەگەندى تارىلتىپ كورىڭىز. مىندا پايدالانىلعان IP جايلار كورسەتىلگەن (بارىنشا 5000, جايىمەن سۇرىپتالعان):',
	'checkuser-user-nonexistent' => 'ەنگىزىلگەن قاتىسۋشى جوق.',
	'checkuser-search-form' => 'جۋرنالداعى وقىيعالاردى تابۋ ($1 دەگەن $2 ەكەن جايىنداعى)',
	'checkuser-search-submit' => 'ىزدەۋ',
	'checkuser-search-initiator' => 'باستاماشى',
	'checkuser-search-target' => 'نىسانا',
	'checkuser-log-subpage' => 'جۋرنال',
	'checkuser-log-return' => 'CheckUser باسقى پىشىنىنە  ورالۋ',
	'checkuser-log-userips' => '$2 ٴۇشىن $1 IP جاي الىندى',
	'checkuser-log-ipedits' => '$2 ٴۇشىن $1 تۇزەتۋ الىندى',
	'checkuser-log-ipusers' => '$2 ٴۇشىن $1 IP قاتىسۋشى الىندى',
	'checkuser-log-ipedits-xff' => 'XFF $2 ٴۇشىن $1 تۇزەتۋ الىندى',
	'checkuser-log-ipusers-xff' => 'XFF $2 ٴۇشىن $1 قاتىسۋشى الىندى',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'checkuser-summary' => 'Бұл құрал пайдаланушы қолданған IP жайлар үшін, немесе IP жай түзету/пайдаланушы деректерін көрсету үшін жуықтағы өзгерістерді қарап шығады.
	Пайдаланушыларды мен түзетулерді XFF IP арқылы IP жайға «/xff» дегенді қосып келтіруге болады. IPv4 (CIDR 16-32) және IPv6 (CIDR 64-128) арқауланады.
	Орындаушылық себептерімен 5000 түзетуден артық қайтарылмайды. Бұны ережелерге сәйкес пайдаланыңыз.',
	'checkuser-logcase' => 'Журналдан іздеу әріп бас-кішілігін айырады.',
	'checkuser' => 'Қатысушыны сынау',
	'group-checkuser' => 'Қатысушы сынаушылар',
	'group-checkuser-member' => 'қатысушы сынаушы',
	'grouppage-checkuser' => '{{ns:project}}:Қатысушыны сынау',
	'checkuser-reason' => 'Себебі',
	'checkuser-showlog' => 'Журналды көрсет',
	'checkuser-log' => 'Қатысушы сынау журналы',
	'checkuser-query' => 'Жуықтағы өзгерістерді сұранымдау',
	'checkuser-target' => 'Қатысушы аты / IP жай',
	'checkuser-users' => 'Қатысушыларды келтіру',
	'checkuser-edits' => 'IP жайдан жасалған түзетулерді келтіру',
	'checkuser-ips' => 'IP жайларды келтіру',
	'checkuser-search' => 'Іздеу',
	'checkuser-empty' => 'Журналда еш жазба жоқ.',
	'checkuser-nomatch' => 'Сәйкес табылмады.',
	'checkuser-check' => 'Сынау',
	'checkuser-log-fail' => 'Журналға жазба үстелінбеді',
	'checkuser-nolog' => 'Журнал файлы табылмады.',
	'checkuser-blocked' => 'Бұғатталған',
	'checkuser-too-many' => 'Тым көп нәтиже келтірілді, CIDR дегенді тарылтып көріңіз. Мында пайдаланылған IP жайлар көрсетілген (барынша 5000, жайымен сұрыпталған):',
	'checkuser-user-nonexistent' => 'Енгізілген қатысушы жоқ.',
	'checkuser-search-form' => 'Журналдағы оқиғаларды табу ($1 деген $2 екен жайындағы)',
	'checkuser-search-submit' => 'Іздеу',
	'checkuser-search-initiator' => 'бастамашы',
	'checkuser-search-target' => 'нысана',
	'checkuser-log-subpage' => 'Журнал',
	'checkuser-log-return' => 'CheckUser басқы пішініне  оралу',
	'checkuser-log-userips' => '$2 үшін $1 IP жай алынды',
	'checkuser-log-ipedits' => '$2 үшін $1 түзету алынды',
	'checkuser-log-ipusers' => '$2 үшін $1 IP қатысушы алынды',
	'checkuser-log-ipedits-xff' => 'XFF $2 үшін $1 түзету алынды',
	'checkuser-log-ipusers-xff' => 'XFF $2 үшін $1 қатысушы алынды',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'checkuser-summary' => 'Bul qural paýdalanwşı qoldanğan IP jaýlar üşin, nemese IP jaý tüzetw/paýdalanwşı derekterin körsetw üşin jwıqtağı özgeristerdi qarap şığadı.
	Paýdalanwşılardı men tüzetwlerdi XFF IP arqılı IP jaýğa «/xff» degendi qosıp keltirwge boladı. IPv4 (CIDR 16-32) jäne IPv6 (CIDR 64-128) arqawlanadı.
	Orındawşılıq sebepterimen 5000 tüzetwden artıq qaýtarılmaýdı. Bunı erejelerge säýkes paýdalanıñız.',
	'checkuser-logcase' => 'Jwrnaldan izdew ärip bas-kişiligin aýıradı.',
	'checkuser' => 'Qatıswşını sınaw',
	'group-checkuser' => 'Qatıswşı sınawşılar',
	'group-checkuser-member' => 'qatıswşı sınawşı',
	'grouppage-checkuser' => '{{ns:project}}:Qatıswşını sınaw',
	'checkuser-reason' => 'Sebebi',
	'checkuser-showlog' => 'Jwrnaldı körset',
	'checkuser-log' => 'Qatıswşı sınaw jwrnalı',
	'checkuser-query' => 'Jwıqtağı özgeristerdi suranımdaw',
	'checkuser-target' => 'Qatıswşı atı / IP jaý',
	'checkuser-users' => 'Qatıswşılardı keltirw',
	'checkuser-edits' => 'IP jaýdan jasalğan tüzetwlerdi keltirw',
	'checkuser-ips' => 'IP jaýlardı keltirw',
	'checkuser-search' => 'İzdew',
	'checkuser-empty' => 'Jwrnalda eş jazba joq.',
	'checkuser-nomatch' => 'Säýkes tabılmadı.',
	'checkuser-check' => 'Sınaw',
	'checkuser-log-fail' => 'Jwrnalğa jazba üstelinbedi',
	'checkuser-nolog' => 'Jwrnal faýlı tabılmadı.',
	'checkuser-blocked' => 'Buğattalğan',
	'checkuser-too-many' => 'Tım köp nätïje keltirildi, CIDR degendi tarıltıp köriñiz. Mında paýdalanılğan IP jaýlar körsetilgen (barınşa 5000, jaýımen surıptalğan):',
	'checkuser-user-nonexistent' => 'Engizilgen qatıswşı joq.',
	'checkuser-search-form' => 'Jwrnaldağı oqïğalardı tabw ($1 degen $2 eken jaýındağı)',
	'checkuser-search-submit' => 'İzdew',
	'checkuser-search-initiator' => 'bastamaşı',
	'checkuser-search-target' => 'nısana',
	'checkuser-log-subpage' => 'Jwrnal',
	'checkuser-log-return' => 'CheckUser basqı pişinine  oralw',
	'checkuser-log-userips' => '$2 üşin $1 IP jaý alındı',
	'checkuser-log-ipedits' => '$2 üşin $1 tüzetw alındı',
	'checkuser-log-ipusers' => '$2 üşin $1 IP qatıswşı alındı',
	'checkuser-log-ipedits-xff' => 'XFF $2 üşin $1 tüzetw alındı',
	'checkuser-log-ipusers-xff' => 'XFF $2 üşin $1 qatıswşı alındı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'checkuser-desc' => 'ផ្ដល់ឱ្យអ្នកប្រើប្រាស់​នូវការអនុញ្ញាតសមគួរដើម្បី​ទទួលបាននូវ​សមត្ថភាព​ក្នុងការត្រួតពិនិត្យអាសយដ្ឋាន IP របស់អ្នកប្រើប្រាស់និង​ព័ត៌មានផ្សេងៗទៀត',
	'checkuser-logcase' => 'ការស្វែងរកកំណត់ហេតុដោយបែងចែកអក្សរធំ អក្សរតូច។',
	'checkuser' => 'ត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'group-checkuser' => 'អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'group-checkuser-member' => 'អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'right-checkuser' => 'អាសយដ្ឋានIPនិងព័ត៌មានដ៏ទៃទៀតនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'right-checkuser-log' => 'មើលកំណត់ហេតុនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'grouppage-checkuser' => '{{ns:project}}:អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-reason' => 'មូលហេតុ៖',
	'checkuser-showlog' => 'បង្ហាញកំណត់ហេតុ',
	'checkuser-log' => 'កំណត់ហេតុនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-target' => 'អ្នកប្រើប្រាស់ ឬ IP',
	'checkuser-users' => 'ទទួលអ្នកប្រើប្រាស់',
	'checkuser-edits' => 'ទទួលកំណែប្រែពីIP',
	'checkuser-ips' => 'ទទួលIP',
	'checkuser-account' => 'ទទួលកំណែប្រែនៃគណនី',
	'checkuser-search' => 'ស្វែងរក',
	'checkuser-period' => 'រយៈពេល៖',
	'checkuser-week-1' => 'សប្តាហ៍មុន',
	'checkuser-week-2' => '២សប្តាហ៍មុន',
	'checkuser-month' => '៣០ថ្ងៃមុន',
	'checkuser-all' => 'ទាំងអស់',
	'checkuser-empty' => 'មិនមានអ្វីនៅក្នុងកំណត់ហេតុនេះទេ។',
	'checkuser-check' => 'ត្រួតពិនិត្យ',
	'checkuser-nolog' => 'ឯកសារកំណត់ហេតុមិនត្រូវបានរកឃើញទេ។',
	'checkuser-blocked' => 'បានហាមឃាត់',
	'checkuser-locked' => 'បានចាក់សោ',
	'checkuser-wasblocked' => 'ត្រូវបានរាំងខ្ទប់មុននេះ',
	'checkuser-massblock' => 'រាំងខ្ទប់អ្នកប្រើប្រាស់ដែលត្រូវបានជ្រើសរើស',
	'checkuser-blocktag' => 'ជំនួសទំព័រអ្នកប្រើប្រាស់ដោយ៖',
	'checkuser-blocktag-talk' => 'ជំនួស​ទំព័រពិភាក្សា​ជាមួយ​៖',
	'checkuser-massblock-commit' => 'រាំងខ្ទប់អ្នកប្រើប្រាស់ដែលត្រូវបានជ្រើសរើស',
	'checkuser-block-success' => "'''{{PLURAL:$2|អ្នកប្រើប្រាស់|អ្នកប្រើប្រាស់}} $1 {{PLURAL:$2|ត្រូវ|ត្រូវ}}បានរាំងខ្ទប់ហើយ។'''",
	'checkuser-block-failure' => "'''គ្មានអ្នកប្រើប្រាស់ណាម្នាក់ត្រូវបានរាំងខ្ទប់ទេ។'''",
	'checkuser-block-limit' => 'មានអ្នកប្រើប្រាស់ច្រើនពេកហើយត្រូវបានជ្រើសរើស។',
	'checkuser-block-noreason' => 'អ្នកត្រូវតែផ្ដល់មូលហេតុសម្រាប់ការរាំងខ្ទប់។',
	'checkuser-accounts' => '{{PLURAL:$1|account|គណនី}} $1 ថ្មី',
	'checkuser-too-many' => 'ច្រើនលទ្ធផល​ពេក, សូមបង្រួម CIDR ។ នេះគឺ IP បានប្រើប្រាស់ (អតិបរមា ៥០០០, រៀបតាម​អាសយដ្ឋាន)​៖',
	'checkuser-user-nonexistent' => 'មិនមានអ្នកប្រើប្រាស់ដូចដែលបានបញ្ជាក់ទេ។',
	'checkuser-search-form' => 'ស្វែងរកការបញ្ចូលកំណត់ហេតុដែល $1 គឺជា $2',
	'checkuser-search-submit' => 'ស្វែងរក',
	'checkuser-search-initiator' => 'អ្នកផ្ដួចផ្ដើម',
	'checkuser-search-target' => 'គោលដៅ',
	'checkuser-ipeditcount' => '~$1 ពីគ្រប់អ្នកប្រើប្រាស់ទាំងអស់',
	'checkuser-log-subpage' => 'កំណត់ហេតុ',
	'checkuser-log-return' => 'ត្រឡប់ទៅកាន់បែបបទដើមនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-log-userips' => '$1បានទទួល IPs ដែល$2បានប្រើប្រាស់',
	'checkuser-log-ipedits' => '$1បានទទួលចំនួនកំណែប្រែពី$2',
	'checkuser-log-useredits' => '$1 បានទទួលកំណែប្រែពី $2',
	'checkuser-autocreate-action' => 'ត្រូវបានបង្កើតដោយស្វ័យប្រវត្តិ',
	'checkuser-email-action' => 'បានផ្ញើអ៊ីមែលទៅកាន់អ្នកប្រើប្រាស់ "$1"',
	'checkuser-reset-action' => 'កំណត់ឡើងវិញនូវពាក្យសម្ងាត់របស់អ្នកប្រើប្រាស់"$1"',
);

/** Kannada (ಕನ್ನಡ)
 * @author HPNadig
 */
$messages['kn'] = array(
	'checkuser' => 'ಸದಸ್ಯನನ್ನು ಚೆಕ್ ಮಾಡಿ',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'checkuser-desc' => '사용자의 IP 주소를 포함한 정보를 볼 수 있는 권한을 특정한 사용자에게 준다.',
	'checkuser' => '체크유저',
	'group-checkuser' => '체크유저',
	'group-checkuser-member' => '체크유저',
	'right-checkuser' => '사용자의 IP 주소와 다른 정보를 확인',
	'right-checkuser-log' => '체크유저 기록 보기',
	'grouppage-checkuser' => '{{ns:project}}:체크유저',
	'checkuser-reason' => '이유:',
	'checkuser-showlog' => '기록 보기',
	'checkuser-log' => '체크유저 기록',
	'checkuser-query' => '쿼리 최근 바뀜',
	'checkuser-target' => '사용자 혹은 IP',
	'checkuser-users' => '특정 IP를 사용한 사용자 확인',
	'checkuser-edits' => '특정 IP에서의 편집을 확인',
	'checkuser-ips' => 'IP 주소 확인',
	'checkuser-account' => '계정 편집을 열람',
	'checkuser-search' => '찾기',
	'checkuser-period' => '기간:',
	'checkuser-week-1' => '지난 1주일',
	'checkuser-week-2' => '지난 2주일',
	'checkuser-month' => '지난 30일',
	'checkuser-all' => '모두',
	'checkuser-empty' => '기록이 없습니다.',
	'checkuser-nomatch-edits' => '일치하는 결과가 없습니다.
마지막 편집은 $1 $2에 있었습니다.',
	'checkuser-check' => '확인',
	'checkuser-log-fail' => '기록을 남길 수 없습니다',
	'checkuser-blocked' => '차단됨',
	'checkuser-gblocked' => '전체 위키에서 차단됨',
	'checkuser-locked' => '잠김',
	'checkuser-wasblocked' => '이미 차단됨',
	'checkuser-localonly' => '계정이 통합되지 않음',
	'checkuser-massblock' => '선택한 사용자 차단',
	'checkuser-massblock-text' => '선택된 계정은 무기한 (자동 차단 활성화, 계정 생성 금지됨) 차단될 것입니다.
IP 주소는 1주일 (IP만 막음, 계정 생성 금지됨) 차단될 것입니다.',
	'checkuser-blocktag' => '사용자 문서를 다음 내용으로 바꾸기:',
	'checkuser-blocktag-talk' => '토론 문서를 다음 내용으로 바꾸기:',
	'checkuser-massblock-commit' => '선택한 사용자를 차단',
	'checkuser-block-success' => "'''다음 $2명의 사용자 ($1) 가 성공적으로 차단되었습니다.'''",
	'checkuser-block-failure' => "'''차단된 사용자가 없습니다.'''",
	'checkuser-block-limit' => '너무 많은 사용자를 선택하였습니다.',
	'checkuser-block-noreason' => '차단하는 이유를 반드시 입력해야 합니다.',
	'checkuser-accounts' => '$1개의 새 계정',
	'checkuser-user-nonexistent' => '해당 사용자가 존재하지 않습니다.',
	'checkuser-search-submit' => '찾기',
	'checkuser-search-initiator' => '체크유저',
	'checkuser-search-target' => '대상',
	'checkuser-ipeditcount' => '모든 사용자로부터 $1개의 편집',
	'checkuser-log-subpage' => '기록',
	'checkuser-log-return' => '체크유저 양식으로 돌아가기',
	'checkuser-log-userips' => '$1 은(는) $2 이(가) 사용한 IP 주소를 열람했습니다.',
	'checkuser-log-ipedits' => '$1 은(는) $2의 편집을 열람했습니다.',
	'checkuser-log-ipusers' => '$1이(가) $2 IP 주소를 사용한 사용자를 확인하였습니다.',
	'checkuser-log-ipedits-xff' => '$1이(가) XFF $2 IP 주소에서의 편집을 열람하였습니다.',
	'checkuser-log-ipusers-xff' => '$1이(가) XFF $2 IP 주소를 사용한 사용자의 목록을 열람하였습니다.',
	'checkuser-log-useredits' => '$1이(가) $2 IP에서의 편집을 열람하였습니다.',
	'checkuser-autocreate-action' => '계정이 자동으로 생성되었습니다.',
	'checkuser-email-action' => '사용자 "$1"에게 이메일을 보냄',
	'checkuser-reset-action' => '"$1"의 암호를 변경함',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'checkuser-search' => 'Luk foh am',
	'checkuser-search-submit' => 'Luk foh am',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'checkuser-search' => 'Sagap',
	'checkuser-search-submit' => 'Sagap',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'checkuser-summary' => 'Met däm Werkzeush he kam_mer de IP Addresse fun Metmaacher fenge, di en de {{int:Recentchanges}} shtonn, un mer kann de Metmaacher-Date un Änderonge fenge för en IP-Adress.

Metmaacher un ier Änderong för an IP-Address wäde övver <i lang="en">XFF-header</i> jezeich, wam_mer aan di IP-Address en „<code>/xff</code>“ aanhängk. Wobei wäde IPv4 (CIDR 16-32) un IPv6 (CIDR 64-128) ongershtöz. Leßte jon beß 5000 Änderonge, öm der ßööver nit zo doll ze beschäfteje.

Donn op de Räjelle för dat Werrkzeuch obacht jevve, un et nit bruche, wann De nit darrefs!',
	'checkuser-desc' => 'Metmaacher met däm Rääsch dozoh könne de IP-Adresse un annder Date fun de Metmaacher pröfe.',
	'checkuser-logcase' => 'Dat Söke em Logboch deit zwesche jruße un kleine Bochshtave ongerscheide.',
	'checkuser' => 'Metmaacher Pröfe',
	'group-checkuser' => 'Metmaacher-Pröfer',
	'group-checkuser-member' => 'Metmaacher-Pröfer',
	'right-checkuser' => 'IP-Adresse un ier Bezösch zo de aanjemeldte Metmaacher övverpröfe, un Metmacher ier Date aanlore',
	'right-checkuser-log' => 'En et Logboch lohre, fum Övverpröfe fun IP-Adresse un ier Bezösch zo de aanjemeldte Metmaacher, uew.',
	'grouppage-checkuser' => '{{ns:project}}:Metmaacher-Pröfer',
	'checkuser-reason' => 'Aanlass:',
	'checkuser-showlog' => 'et Logboch aanzeije',
	'checkuser-log' => 'Logboch fum Metmaacher-Pröfe',
	'checkuser-query' => 'En de {{LCFIRST:{{int:recentchanges}}}} frore',
	'checkuser-target' => 'Metmaacher-Name udder IP-Address',
	'checkuser-users' => 'Metmaacher holle!',
	'checkuser-edits' => 'Änderonge fun dä IP-Address holle!',
	'checkuser-ips' => 'IP-Addresse holle!',
	'checkuser-account' => 'Holl enem Metmaacher sing Änderunge',
	'checkuser-search' => 'Sööke',
	'checkuser-period' => 'Dor:',
	'checkuser-week-1' => 'letz Woch',
	'checkuser-week-2' => 'de letzte zwei Woche',
	'checkuser-month' => 'de letz drißich Daach',
	'checkuser-all' => 'all',
	'checkuser-empty' => 'En däm Logboch shteit nix dren.',
	'checkuser-nomatch' => 'Nix zopaß jefonge.',
	'checkuser-nomatch-edits' => 'Keine Treffer jefonge. De letzte Änderung wohr aam $1 öm $2 Uhr.',
	'checkuser-check' => 'Pröfe!',
	'checkuser-log-fail' => 'Kann nix em Logboch dobei schriive',
	'checkuser-nolog' => 'Kein Logboch jefonge.',
	'checkuser-blocked' => 'jesperrt',
	'checkuser-gblocked' => 'En alle Wikis jesperrt',
	'checkuser-locked' => 'Zohjemaat un afjeschloße',
	'checkuser-wasblocked' => 'Fröjer jesperrt',
	'checkuser-localonly' => 'Nit zusamme jelaat',
	'checkuser-massblock' => 'Don de usjesoohte Metmaacher sperre',
	'checkuser-massblock-text' => 'De ußjesoohte Metmaacher wäde för iewich jesperrt, met automattesch
wigger sperre ennjeschalldt un et Metmaacher-Neu-Aanlääje es verbodde.
De namelose Metmaacher un ier IP-Adresse wäde för en Woch jesperrt — enlogge fun do es ävver wigger müjjelesch — un et Metmaacher-Neu-Aanlääje
es doh och verbodde.',
	'checkuser-blocktag' => 'Der Metmaacher ier Sigge iere Ennhalt ußtuusche jäje:',
	'checkuser-blocktag-talk' => 'Donn de Klaafsigge övverschriive met:',
	'checkuser-massblock-commit' => 'Ußjesoohte Metmaacher sperre',
	'checkuser-block-success' => "'''{{PLURAL:$2|Dä|De|Keine}} Metmaacher $1 {{PLURAL:$2|es|sin|is}} jetz jesperrt.'''",
	'checkuser-block-failure' => "'''Keine Metmaacher jesperrt.'''",
	'checkuser-block-limit' => 'Zoo fill Metmaacher ußjesoht.',
	'checkuser-block-noreason' => 'Do moß ävver ene Jrund för et Sperre aanjevve.',
	'checkuser-accounts' => '{{PLURAL:$1|Eine|$1|Keine}} neue Metmaacher',
	'checkuser-too-many' => 'Zoo fill jefonge, beß esu joot un maach dä CIDR kleijner.
Hee sin de eetßte 5000 IP-Addresse, zoteeet:',
	'checkuser-user-nonexistent' => 'Dä Metmaacher jidd_et ja nit.',
	'checkuser-search-form' => 'Sök noh Enndräsch em Logboch, woh $1 $2 es.',
	'checkuser-search-submit' => 'Söök!',
	'checkuser-search-initiator' => 'Metmaacher-Pröfer',
	'checkuser-search-target' => 'Wat eß jefrooch? (Metmaacher-Name udder IP-Address)',
	'checkuser-ipeditcount' => '~$1 Änderonge fun alle Metmaacher',
	'checkuser-log-subpage' => 'Logboch',
	'checkuser-log-return' => 'Zerök zor Sigg „Metmaacher Pröfe“',
	'checkuser-limited' => "'''De Leß es affjeschnedde, öm nit der Server unnüdesch ze belaste.'''",
	'checkuser-log-userips' => '$1 hät IP-Adresse jehollt för $2',
	'checkuser-log-ipedits' => '$1 hät de Änderonge jehollt för $2',
	'checkuser-log-ipusers' => '$1 hät de Metmaacher jehollt för $2',
	'checkuser-log-ipedits-xff' => '$1 hät de Änderonge jehollt för XFF $2',
	'checkuser-log-ipusers-xff' => '$1 hät de Metmaacher jehollt för XFF $2',
	'checkuser-log-useredits' => 'dä Metmmacher „$1“ hät dem Metmaacher „$2“ sing Änderunge aanjeloort',
	'checkuser-autocreate-action' => 'wohd automattesch aanjelaat',
	'checkuser-email-action' => 'en e-mail aan „$1“ jescheck',
	'checkuser-reset-action' => 'Däm Metmaacher „$1“ sing Paßwoot automattesch neu setze',
);

/** Kurdish (Latin) (Kurdî / كوردی (Latin))
 * @author Bangin
 */
$messages['ku-latn'] = array(
	'checkuser-search' => 'Lêbigere',
	'checkuser-search-submit' => 'Lêbigere',
);

/** Latin (Latina)
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'checkuser-reason' => 'Causa:',
	'checkuser-search' => 'Quaerere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'checkuser-desc' => "Gëtt Benotzer mat den néidege Rechter d'Méiglechkeet d'IP-Adressen esou wéi aner Informatiounen iwwert d'Benotzer z'iwwerpréifen",
	'checkuser-logcase' => "D'Sich am Logbuch mecht en Ënnerscheed tëschent groussen a klenge Buchstawen.",
	'checkuser' => 'Benotzer-Check',
	'group-checkuser' => 'Benotzer Kontrolleren',
	'group-checkuser-member' => 'Benotzer Kontroller',
	'right-checkuser' => 'Iwwerpréif de Benotzer hir IP-Adressen an aner Informatiounen',
	'right-checkuser-log' => "D'Lëscht vun den ''checkuser''-Ufroe weisen",
	'grouppage-checkuser' => '{{ns:project}}:Benotzer-Kontroller',
	'checkuser-reason' => 'Grond:',
	'checkuser-showlog' => 'Logbuch weisen',
	'checkuser-log' => 'Lëscht vun de Benotzerkontrollen',
	'checkuser-query' => 'Rezent Ännerungen offroen',
	'checkuser-target' => 'Benotzer oder IP-Adress',
	'checkuser-users' => 'Benotzer kréien',
	'checkuser-edits' => "Weis d'Ännerunge vun der IP-Adress",
	'checkuser-ips' => 'IP-Adresse kréien/uweisen',
	'checkuser-account' => "d'Ännerunge vum Benotzerkont kréien",
	'checkuser-search' => 'Sichen',
	'checkuser-period' => 'Zäitraum:',
	'checkuser-week-1' => 'lescht Woch',
	'checkuser-week-2' => 'lescht 2 Wochen',
	'checkuser-month' => 'lescht 30 Deeg',
	'checkuser-all' => 'all',
	'checkuser-empty' => 'Dës Lëscht ass eidel.',
	'checkuser-nomatch' => 'Et goufe keng Iwwereneestëmmunge fonnt.',
	'checkuser-nomatch-edits' => 'Et gouf näischt esou fonnt.
Déi lescht Ännerung war de() $1 ëm $2.',
	'checkuser-check' => 'Kontrolléieren',
	'checkuser-log-fail' => "D'Aschreiwung an d'Logbuch konnt net gemaach ginn",
	'checkuser-nolog' => "D'Logbuch gouf net fonnt.",
	'checkuser-blocked' => 'Gespaart',
	'checkuser-gblocked' => 'global gespaart',
	'checkuser-locked' => 'Gespaart',
	'checkuser-wasblocked' => 'Virdru gespaart',
	'checkuser-localonly' => 'Net zesummegeluecht',
	'checkuser-massblock' => 'Ausgewielte Benotzer spären',
	'checkuser-blocktag' => 'Benotzersäiten duerch dëst ersetzen:',
	'checkuser-blocktag-talk' => 'Diskussiounssäiten ersetzen duerch:',
	'checkuser-massblock-commit' => 'Ausgewielte Benotzer spären',
	'checkuser-block-success' => "'''{{PLURAL:$2|De Benotzer|D'Benotzer}} $1 {{PLURAL:$2|ass|sinn}} elo gespaart.'''",
	'checkuser-block-failure' => "'''Et si keng Benotzer gespaart.'''",
	'checkuser-block-limit' => 'Zevill Benotzer ugewielt.',
	'checkuser-block-noreason' => "Dir musst e Grond fir d'Spären uginn.",
	'checkuser-accounts' => '$1 {{PLURAL:$1|neie Benotzerkont|nei Benotzerkonten}}',
	'checkuser-too-many' => 'Zevill Resultater, gitt w.e.g. méi e klenge Beräich vun Ip-adresen un.
Hei sinn déi benotzten IP-Adressen (max 5000, sortéiert no der Adress):',
	'checkuser-user-nonexistent' => 'De gesichte Benotzer gëtt et net.',
	'checkuser-search-form' => 'An de Lëschten fannen, wou den $1 den $2 ass',
	'checkuser-search-submit' => 'Sichen',
	'checkuser-search-initiator' => 'Initiator',
	'checkuser-search-target' => 'Zil',
	'checkuser-ipeditcount' => '~$1 vun alle Benotzer',
	'checkuser-log-subpage' => 'Lëscht',
	'checkuser-log-return' => 'Zréck op den Haaptformulaire vun der Benotzerkontroll',
	'checkuser-limited' => "'''Dës Lëscht gouf aus Grënn vun der performance vun de Servere gekierzt.'''",
	'checkuser-log-userips' => '$1 krut IPen fir $2',
	'checkuser-log-ipedits' => '$1 huet Ännerunge kritt fir $2',
	'checkuser-log-ipusers' => '$1 huet Benotzer kritt fir $2',
	'checkuser-log-ipedits-xff' => '$1 krut ännerunge fir XFF $2',
	'checkuser-log-ipusers-xff' => "$1 krut d'Benotzer fir XFF $2",
	'checkuser-log-useredits' => "$1 huet d'Ännerunge fir $2 kritt",
	'checkuser-autocreate-action' => 'gouf automatesch ugeluecht',
	'checkuser-email-action' => 'dem Benotzer "$1" eng E-Mail geschéckt',
	'checkuser-reset-action' => 'huet d\'Passwuert fir de Benotzer "$1" zréckgesat',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'checkuser-search' => 'Xerca',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'checkuser-summary' => "Dit hölpmiddel bekiek recènte verangeringe óm IP-adresse die 'ne gebroeker haet gebroek te achterhaole of toeantj de bewèrkings- en gebroekersgegaeves veur 'n IP-adres.
Gebroekers en bewèrkinge van 'n IP-adres van 'ne cliënt kinne achterhaoldj waere via XFF-headers door \"/xff\" achter 't IP-adres toe te voege. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) waere óngersteundj.
Óm prestatiereej waere neet mieë es 5.000 bewèrkinge getoeantj. Gebroek dit hölpmiddel volges 't vasgesteldje beleid.",
	'checkuser-desc' => 'Läöt geautproseerde gebroekers IP-adresse en angere informatie van gebroekers achterhaole',
	'checkuser-logcase' => "Zeuke in 't logbook is huidlèttergeveulig.",
	'checkuser' => 'Konterleer gebroeker',
	'group-checkuser' => 'Gebroekerkonterleerders',
	'group-checkuser-member' => 'Gebroekerkonterleerder',
	'right-checkuser' => 'IP-adrèsser en anger gegaeves van gebroekers naokieke',
	'grouppage-checkuser' => '{{ns:project}}:Gebroekerkonterleerder',
	'checkuser-reason' => 'Reej',
	'checkuser-showlog' => 'Toean logbook',
	'checkuser-log' => 'Logbook KonterleerGebroeker',
	'checkuser-query' => 'Bevraog recènte verangeringe',
	'checkuser-target' => 'Gebroeker of IP-adres',
	'checkuser-users' => 'Vraog gebroekers op',
	'checkuser-edits' => 'Vraog bewèrkinge van IP-adres op',
	'checkuser-ips' => 'Vraof IP-adresse op',
	'checkuser-search' => 'Zeuk',
	'checkuser-empty' => "'t Logbook bevat gein regels.",
	'checkuser-nomatch' => 'Gein euvereinkómste gevónje.',
	'checkuser-check' => 'Conterleer',
	'checkuser-log-fail' => 'Logbookregel toevoege neet meugelik',
	'checkuser-nolog' => 'Gein logbook gevónje.',
	'checkuser-blocked' => 'Geblokkeerdj',
	'checkuser-too-many' => 'Te väöl rezultaote. Maak de IP-reiks kleinder:',
	'checkuser-user-nonexistent' => 'De opgegaeve gebroeker besteit neet.',
	'checkuser-search-form' => 'Logbookregels zeuke wo de $1 $2 is',
	'checkuser-search-submit' => 'Zeuk',
	'checkuser-search-initiator' => 'aanvraoger',
	'checkuser-search-target' => 'óngerwèrp',
	'checkuser-ipeditcount' => '~$1 van alle gebroekers',
	'checkuser-log-subpage' => 'Logbook',
	'checkuser-log-return' => "Nao 't huidformeleer van KonterleerGebroeker trökgaon",
	'checkuser-log-userips' => '$1 haet IP-adresse veur $2',
	'checkuser-log-ipedits' => '$1 haet bewèrkinge veur $2',
	'checkuser-log-ipusers' => '$1 haet gebroekers veur $2',
	'checkuser-log-ipedits-xff' => '$1 haet bewèrkinge veur XFF $2',
	'checkuser-log-ipusers-xff' => '$1 haet gebrokers veur XFF $2',
);

/** Lao (ລາວ) */
$messages['lo'] = array(
	'checkuser' => 'ກວດຜູ້ໃຊ້',
	'checkuser-reason' => 'ເຫດຜົນ',
	'checkuser-showlog' => 'ສະແດງບັນທຶກ',
	'checkuser-log' => 'ບັນທຶກການກວດຜູ້ໃຊ້',
	'checkuser-target' => 'ຜູ້ໃຊ້ ຫຼື IP',
	'checkuser-edits' => 'ເອົາ ການດັດແກ້ ຈາກ ທີ່ຢູ່ IP',
	'checkuser-ips' => 'ເອົາ ທີ່ຢູ່ IP',
	'checkuser-search' => 'ຊອກຫາ',
	'checkuser-empty' => 'ບໍ່ມີເນື້ອໃນຖືກບັນທຶກ',
	'checkuser-nomatch' => 'ບໍ່ພົບສິ່ງທີ່ຊອກຫາ',
	'checkuser-check' => 'ກວດ',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'checkuser-reason' => 'Priežastis',
	'checkuser-showlog' => 'Rodyti sąrašą',
	'checkuser-target' => 'Naudotojas arba IP',
	'checkuser-users' => 'Gauti naudotojus',
	'checkuser-edits' => 'Gauti redagavimus iš IP',
	'checkuser-ips' => 'Gauti IP',
	'checkuser-search' => 'Ieškoti',
	'checkuser-check' => 'Tikrinti',
	'checkuser-blocked' => 'Užblokuotas',
	'checkuser-search-submit' => 'Ieškoti',
	'checkuser-log-subpage' => 'Sąrašas',
);

/** Latvian (Latviešu)
 * @author Xil
 * @author Yyy
 */
$messages['lv'] = array(
	'checkuser-desc' => 'Atļauj lietotājiem ar attiecīgām pilnvarām pārbaudīt lietotāja IP adresi un citu informāciju.',
	'checkuser' => 'Pārbaudīt lietotāju',
	'group-checkuser' => 'Pārbaudīt lietotājus',
	'checkuser-reason' => 'Iemesls:',
	'checkuser-target' => 'Lietotājs vai IP',
	'checkuser-search' => 'Meklēt',
	'checkuser-check' => 'Pārbaudīt',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'checkuser-reason' => 'Амал:',
	'checkuser-search' => 'Кычал',
	'checkuser-search-submit' => 'Кычал',
);

/** Macedonian (Македонски)
 * @author Misos
 */
$messages['mk'] = array(
	'checkuser' => 'Провери корисник',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'checkuser-desc' => 'ഉപയോക്താക്കള്‍ ഉപയോഗിച്ച ഐപി വിലാസവും മറ്റുവിവരങ്ങളും പരിശോധിക്കുവാനുള്ള അവകാശം കൊടുക്കാന്‍ പ്രാപ്തമാക്കുന്നു',
	'checkuser-logcase' => 'പ്രവര്‍ത്തന രേഖകള്‍ക്കു വേണ്ടിയുള്ള തിരച്ചില്‍ കേസ് സെന്‍സിറ്റീവ് ആണ്‌.',
	'checkuser' => 'ചെക്ക് യൂസര്‍',
	'group-checkuser' => 'ചെക്ക് യൂസര്‍മാര്‍',
	'group-checkuser-member' => 'ചെക്ക് യൂസര്‍',
	'right-checkuser' => 'ചെക്ക് യൂസറിന്റെ ഐപി വിലാസവും മറ്റു വിവരങ്ങളും',
	'grouppage-checkuser' => '{{ns:project}}:ചെക്ക് യൂസര്‍',
	'checkuser-reason' => 'കാരണം',
	'checkuser-showlog' => 'പ്രവര്‍ത്തനരേഖ കാട്ടുക',
	'checkuser-log' => 'ചെക്ക് യൂസര്‍ പ്രവര്‍ത്തനരേഖ',
	'checkuser-query' => 'പുതിയ മാറ്റങ്ങള്‍',
	'checkuser-target' => 'ഉപയോക്താവ് അല്ലെങ്കില്‍ ഐപി',
	'checkuser-users' => 'ഉപയോക്താക്കളെ കാട്ടുക',
	'checkuser-edits' => 'ഐപിയില്‍ നിന്നുള്ള തിരുത്തലുകള്‍ കാട്ടുക',
	'checkuser-ips' => 'ഐപികളെ കാട്ടുക',
	'checkuser-search' => 'തിരയൂ',
	'checkuser-empty' => 'പ്രവര്‍ത്തനരേഖയില്‍ ഇനങ്ങള്‍ ഒന്നുമില്ല',
	'checkuser-nomatch' => 'ചേര്‍ച്ചയുള്ളതൊന്നും കണ്ടില്ല',
	'checkuser-check' => 'പരിശോധിക്കുക',
	'checkuser-log-fail' => 'പ്രവര്‍ത്തനരേഖയില്‍ ഇനം ചേര്‍ക്കുന്നതിനു കഴിഞ്ഞില്ല',
	'checkuser-nolog' => 'പ്രവര്‍ത്തനരേഖ പ്രമാണം കണ്ടില്ല.',
	'checkuser-blocked' => 'തടയപ്പെട്ടിരിക്കുന്നു',
	'checkuser-too-many' => 'വളരെയധികം ഫലങ്ങള്‍. CIDR ചുരുക്കുക. 
ഉപയോഗിച്ച IPകള്‍ താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്നു (പരമാവധി 5000, വിലാസം അനുസരിച്ച് ക്രമീകരിച്ചത്):',
	'checkuser-user-nonexistent' => 'ഇങ്ങനൊരു ഉപയോക്താവ് വിക്കിയില്‍ നിലവിലില്ല.',
	'checkuser-search-form' => '$1, $2 ആയ പ്രവര്‍ത്തനരേഖാ ഇനങ്ങള്‍ കണ്ടെത്തുന്നു',
	'checkuser-search-submit' => 'തിരയൂ',
	'checkuser-search-initiator' => 'മുന്‍‌കൈ എടുക്കുന്ന ആള്‍',
	'checkuser-search-target' => 'ലക്ഷ്യം',
	'checkuser-ipeditcount' => '~$1എല്ലാ ഉപയോക്താക്കളില്‍ നിന്നും',
	'checkuser-log-subpage' => 'പ്രവര്‍ത്തനരേഖ',
	'checkuser-log-return' => 'ചെക്ക് യൂസറിന്റെ പ്രധാന ഫോമിലേക്ക് തിരിച്ചു പോവുക',
	'checkuser-log-userips' => '$1നു $2ല്‍ ഐപികള്‍ ഉണ്ട്',
	'checkuser-log-ipedits' => '$1നു $2ല്‍ തിരുത്തലുകള്‍ ഉണ്ട്',
	'checkuser-log-ipusers' => '$1നു $2ല്‍ ഉപയോക്താക്കള്‍ ഉണ്ട്',
	'checkuser-log-ipedits-xff' => '$1നു XFF $2ല്‍ തിരുത്തലുകള്‍ ഉണ്ട്',
	'checkuser-log-ipusers-xff' => '$1നു XFF $2ല്‍ ഉപയോക്താക്കള്‍ ഉണ്ട്',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'checkuser-summary' => 'हे उपकरण अलीकडील बदलांमधून एखाद्या सदस्याने वापरलेले अंकपत्ते किंवा एखाद्या अंकपत्त्याची संपादने/सदस्य दाखविते.
क्लायंट अंकपत्त्यावरील सदस्य अथवा संपादने पाहण्यासाठी अंकपत्त्यानंतर "/xff" द्यावे लागेल.
IPv4 (CIDR 16-32) आणि IPv6 (CIDR 64-128) वापरता येऊ शकेल.
एका वेळी ५००० पेक्षा जास्त संपादने दाखविली जाणार नाहीत. हे उपकरण पॉलिसीच्या नियमांना धरून वापरावे.',
	'checkuser-desc' => 'सदस्याला इतर सदस्यांचे आंतरजाल अंकपत्ते (आयपी) तपासण्याची तसेच इतर माहिती पाहण्याची परवानगी देतो.',
	'checkuser-logcase' => 'लॉगमधील शोध हा लिपीशी संबंधित (case-sensitive) आहे.',
	'checkuser' => 'सदस्य तपासा',
	'group-checkuser' => 'सदस्य तपासा',
	'group-checkuser-member' => 'सदस्य तपासा',
	'right-checkuser' => 'सदस्याचा आयपी अंकपत्ता व इतर माहिती तपासा',
	'grouppage-checkuser' => '{{ns:project}}:सदस्य तपासा',
	'checkuser-reason' => 'कारण',
	'checkuser-showlog' => 'लॉग दाखवा',
	'checkuser-log' => 'Checkuse लॉग',
	'checkuser-query' => 'अलीकडील बदल पृच्छा',
	'checkuser-target' => 'सदस्य किंवा अंकपत्ता',
	'checkuser-users' => 'सदस्य शोधा',
	'checkuser-edits' => 'अंकपत्त्याची संपादने शोधा',
	'checkuser-ips' => 'अंकपत्ते शोधा',
	'checkuser-search' => 'शोधा',
	'checkuser-empty' => 'लॉग मध्ये एकही नोंद नाही',
	'checkuser-nomatch' => 'नोंदी सापडल्या नाहीत',
	'checkuser-check' => 'पडताळा',
	'checkuser-log-fail' => 'लॉगमध्ये नोंद वाढविता आलेली नाही.',
	'checkuser-nolog' => 'लॉग संचिका सापडलेली नाही.',
	'checkuser-blocked' => 'ब्लॉक केलेले आहे',
	'checkuser-too-many' => 'खूप निकाल आलेले आहेत, कृपया शोधशब्दांमध्ये योग्य बदल करा. खाली वापरलेल्या अंकपत्त्यांची यादी आहे (जास्तीत जास्त ५०००, अनुक्रमे):',
	'checkuser-user-nonexistent' => 'हे सदस्यनाम अस्तित्त्वात नाही.',
	'checkuser-search-form' => 'अशा नोंदी शोधा जिथे $1 हा $2 आहे.',
	'checkuser-search-submit' => 'शोधा',
	'checkuser-search-initiator' => 'चालक (चालना देणारा)',
	'checkuser-search-target' => 'लक्ष्य',
	'checkuser-ipeditcount' => '~$1 सर्व सदस्यांकडून',
	'checkuser-log-subpage' => 'नोंदी',
	'checkuser-log-return' => 'CheckUser मुख्य अर्जाकडे परत जा',
	'checkuser-log-userips' => '$1 कडे $2 साठीचे अंकपत्ते आहेत',
	'checkuser-log-ipedits' => '$1 कडे $2 साठीची संपादने आहेत',
	'checkuser-log-ipusers' => '$1 कडे $2 साठीचे सदस्य आहेत',
	'checkuser-log-ipedits-xff' => '$1 कडे XFF $2 साठीची संपादने आहेत',
	'checkuser-log-ipusers-xff' => '$1 कडे XFF $2 साठीचे सदस्य आहेत',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'checkuser-summary' => 'Alat ini mengimbas senarai perubahan terkini untuk mendapatkan senarai IP yang digunakan oleh seseorang pengguna atau memaparkan data sunting/pengguna bagi sesebuah IP. Pengguna dan suntingan oleh sesebuah IP boleh didapatkan melalui pengatas XFF dengan menambah \\"/xff\\" selepas IP tersebut. Kedua-dua format IPv4 (CIDR 16-32) dan IPv6 (CIDR 64-128) disokong. Atas sebab-sebab prestasi, pulangan dihadkan kepada 5000 buah suntingan sahaja. Sila patuhi dasar yang telah ditetapkan.',
	'checkuser-desc' => 'Melantik pengguna dengan keizinan untuk membongkar alamat IP pengguna tertentu berserta maklumat-maklumat sulit lain',
	'checkuser-logcase' => 'Gelintar log ini mengambil kisah atur huruf.',
	'checkuser' => 'Periksa pengguna',
	'group-checkuser' => 'Pemeriksa',
	'group-checkuser-member' => 'Pemeriksa',
	'right-checkuser' => 'Memeriksa alamat IP dan maklumat-maklumat lain bagi pengguna',
	'right-checkuser-log' => 'Melihat log pemeriksa',
	'grouppage-checkuser' => '{{ns:project}}:Pemeriksa',
	'checkuser-reason' => 'Sebab:',
	'checkuser-showlog' => 'Tunjuk log',
	'checkuser-log' => 'Log pemeriksa',
	'checkuser-query' => 'Imbas perubahan terkini',
	'checkuser-target' => 'Pengguna atau IP',
	'checkuser-users' => 'Dapatkan senarai pengguna',
	'checkuser-edits' => 'Dapatkan senarai suntingan daripada IP',
	'checkuser-ips' => 'Dapatkan senarai IP',
	'checkuser-account' => 'Dapatkan suntingan akaun',
	'checkuser-search' => 'Cari',
	'checkuser-period' => 'Tempoh:',
	'checkuser-week-1' => 'minggu lepas',
	'checkuser-week-2' => 'dua minggu lepas',
	'checkuser-month' => '30 hari lepas',
	'checkuser-all' => 'semua',
	'checkuser-empty' => 'Log ini kosong.',
	'checkuser-nomatch' => 'Tiada padanan.',
	'checkuser-nomatch-edits' => 'Tiada padanan. Suntingan terakhir ialah pada $1, $2.',
	'checkuser-check' => 'Periksa',
	'checkuser-log-fail' => 'Daftar log tidak dapat ditambah',
	'checkuser-nolog' => 'Fail log tiada.',
	'checkuser-blocked' => 'Disekat',
	'checkuser-gblocked' => 'Disekat secara sejagat',
	'checkuser-locked' => 'Dikunci',
	'checkuser-wasblocked' => 'Pernah disekat',
	'checkuser-localonly' => 'Tidak digabungkan',
	'checkuser-massblock' => 'Sekat pengguna yang ditanda',
	'checkuser-massblock-text' => 'Akaun-akaun yang dinyatakan akan disekat tanpa had, dengan sekatan automatik diaktifkan dan penciptaan akaun baru dimatikan.
Bagi pengguna tanpa nama, alamat IP-nya akan disekat selama seminggu, dengan penciptaan akaun dimatikan.',
	'checkuser-blocktag' => 'Gantikan laman pengguna tersebut dengan:',
	'checkuser-blocktag-talk' => 'Gantikan laman perbincangan dengan:',
	'checkuser-massblock-commit' => 'Sekat pengguna yang ditanda',
	'checkuser-block-success' => "'''{{PLURAL:$2|Pengguna tersebut|$1 orang pengguna}} telah disekat.'''",
	'checkuser-block-failure' => "'''Tiada pengguna disekat.'''",
	'checkuser-block-limit' => 'Terlalu banyak pengguna dipilih.',
	'checkuser-block-noreason' => 'Anda hendaklah memberikan sebab sekatan.',
	'checkuser-accounts' => '$1 akaun baru',
	'checkuser-too-many' => 'Terlalu banyak keputusan; sila kecilkan CIDR. Yang berikut ialah senarai IP yang digunakan (had 5000, diisihkan mengikut alamat):',
	'checkuser-user-nonexistent' => 'Pengguna yang dinyatakan tidak wujud.',
	'checkuser-search-form' => 'Cari daftar-daftar log di mana $1 adalah $2',
	'checkuser-search-submit' => 'Cari',
	'checkuser-search-initiator' => 'pengasal',
	'checkuser-search-target' => 'sasaran',
	'checkuser-ipeditcount' => '~$1 daripada semua pengguna',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Kembali ke borang utama Pemeriksa',
	'checkuser-limited' => 'Hasil-hasil berikut telah dipendekkan atas sebab-sebab prestasi.',
	'checkuser-log-userips' => '$1 mendapatkan senarai IP bagi $2',
	'checkuser-log-ipedits' => '$1 mendapatkan senarai suntingan bagi $2',
	'checkuser-log-ipusers' => '$1 mendapatkan senarai pengguna bagi $2',
	'checkuser-log-ipedits-xff' => '$1 mendapatkan senarai suntingan bagi XFF $2',
	'checkuser-log-ipusers-xff' => '$1 mendapatkan senarai pengguna bagi XFF $2',
	'checkuser-log-useredits' => '$1 mendapatkan senarai suntingan bagi $2',
	'checkuser-autocreate-action' => 'dicipta secara automatik',
	'checkuser-email-action' => 'hantar e-mel kepada "$1"',
	'checkuser-reset-action' => 'set semula kata laluan "$1"',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 * @author Tupikovs
 */
$messages['myv'] = array(
	'checkuser-reason' => 'Тувталось:',
	'checkuser-target' => 'Совиця эли IP',
	'checkuser-search' => 'Вешнэмс',
	'checkuser-week-1' => 'меельсе тарго',
	'checkuser-week-2' => 'меельсе кавто таргт',
	'checkuser-month' => 'меельсе 30 чить',
	'checkuser-all' => 'весе',
	'checkuser-search-submit' => 'Вешнэмс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'checkuser-reason' => 'Īxtlamatiliztli:',
	'checkuser-search' => 'Tlatēmōz',
	'checkuser-search-submit' => 'Tlatēmōz',
);

/** Neapolitan (Nnapulitano) */
$messages['nap'] = array(
	'checkuser-search' => 'Truova',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'checkuser-logcase' => 'De Logbook-Söök maakt en Ünnerscheed twischen grote un lütte Bookstaven.',
	'checkuser' => 'Bruker nakieken',
	'group-checkuser' => 'Brukers nakieken',
	'group-checkuser-member' => 'Bruker nakieken',
	'right-checkuser' => 'IP-Adressen un annere Infos vun Brukers bekieken',
	'right-checkuser-log' => 'Checkuser-Logbook ankieken',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Grund:',
	'checkuser-showlog' => 'Logbook wiesen',
	'checkuser-log' => 'Checkuser-Logbook',
	'checkuser-query' => 'Toletzt ännert affragen',
	'checkuser-target' => 'Bruker oder IP',
	'checkuser-users' => 'Brukers kriegen',
	'checkuser-edits' => 'Ännern vun IP-Adress wiesen',
	'checkuser-ips' => 'IPs kriegen',
	'checkuser-account' => 'Ännern vun Bruker halen',
	'checkuser-search' => 'Söken',
	'checkuser-period' => 'Duur:',
	'checkuser-week-1' => 'leste Week',
	'checkuser-week-2' => 'leste twee Weken',
	'checkuser-month' => 'leste 30 Daag',
	'checkuser-all' => 'all',
	'checkuser-empty' => 'Dat Logbook is leddig.',
	'checkuser-nomatch' => 'Nix funnen, wat övereenstimmt.',
	'checkuser-nomatch-edits' => 'Nix funnen.
Lest Ännern weer an’n $1 üm $2.',
	'checkuser-check' => 'Los',
	'checkuser-log-fail' => 'Kunn keen Logbook-Indrag tofögen',
	'checkuser-nolog' => 'Keen Loogbook funnen.',
	'checkuser-blocked' => 'Sperrt',
	'checkuser-gblocked' => 'global sperrt',
	'checkuser-locked' => 'slaten',
	'checkuser-wasblocked' => 'ehrder al sperrt',
	'checkuser-localonly' => 'Nich tohoopföhrt',
	'checkuser-massblock' => 'Utwählt Brukers sperren',
	'checkuser-blocktag' => 'Brukersieden utwesseln gegen:',
	'checkuser-blocktag-talk' => 'Diskuschoonssieden utwesseln gegen:',
	'checkuser-massblock-commit' => 'Sperr de utwählten Brukers',
	'checkuser-block-success' => "'''De {{PLURAL:$2|Bruker|Brukers}} $1 {{PLURAL:$2|is|sünd}} nu sperrt.'''",
	'checkuser-block-failure' => "'''Kene Brukers sperrt.'''",
	'checkuser-block-limit' => 'Toveel Brukers utwählt.',
	'checkuser-block-noreason' => 'Du musst en Grund för de Sperr angeven.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nee Brukerkonto|ne’e Brukerkonten}}',
	'checkuser-too-many' => 'To veel funnen, grenz de IP-Reeg wieder in. Dit sünd de bruukten IP-Adressen (maximal 5000, sorteert na Adress):',
	'checkuser-user-nonexistent' => 'Den angevene Bruker gifft dat nich.',
	'checkuser-search-form' => 'Söök na Logbook-Indrääg, bi de $1 $2 is.',
	'checkuser-search-submit' => 'Söök',
	'checkuser-search-initiator' => 'Initiater',
	'checkuser-search-target' => 'Ziel',
	'checkuser-ipeditcount' => '~$1 vun all Brukers',
	'checkuser-log-subpage' => 'Logbook',
	'checkuser-log-return' => 'Trüch na dat CheckUser-Hööftformular',
	'checkuser-limited' => "'''De List mit Resultaten is to lang wesen un körter maakt worrn.'''",
	'checkuser-log-userips' => '$1 hett IP-Adressen för $2 rutsöcht',
	'checkuser-log-ipedits' => '$1 hett Ännern vun $2 rutsöcht',
	'checkuser-log-ipusers' => '$1 hett Brukers för $2 rutsöcht',
	'checkuser-log-ipedits-xff' => '$1 hett Ännern för de XFF-IP $2 rutsöcht',
	'checkuser-log-ipusers-xff' => '$1 hett Brukers för de XFF-IP $2 rutsöcht',
	'checkuser-log-useredits' => '$1 hett Ännern för $2 haalt',
	'checkuser-autocreate-action' => 'automaatsch opstellt',
	'checkuser-email-action' => 'hett Bruker „$1“ en E-Mail tostüürt',
	'checkuser-reset-action' => 'hett en nee Passwoord för Bruker „$1“ feddert',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'checkuser-summary' => 'Dit hulpmiddel scant de lieste mit de leste wiezigingen um de IP-adressen weerumme te haolen dee gebruuk bin deur een gebruker of een bewarking/gebrukersgegevens weergeven veur een IP-adres. Gebrukers en bewarkingen kunnen weerummehaold wonnen mit een XFF-IP deur "/xff" an \'t IP-adres toe te voegen. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) wonnen ondersteund. Neet meer as 5.000 bewarkingen wonnen eteund vanwegen prestasierejens. Gebruuk dit in overeenstemming mit \'t beleid.',
	'checkuser-query' => 'Zeukopdrachte leste wiezigingen',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Troefkaart
 */
$messages['nl'] = array(
	'checkuser-summary' => 'Dit hulpmiddel bekijkt recente wijzigingen om IP-adressen die een gebruiker heeft gebruikt te achterhalen of geeft de bewerkings- en gebruikersgegegevens weer voor een IP-adres.
Gebruikers en bewerkingen van een IP-adres van een client kunnen achterhaald worden via XFF-headers door "/xff" achter het IP-adres toe te voegen. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) worden ondersteund.
Om prestatieredenen worden niet meer dan 5.000 bewerkingen weergegeven.
Gebruik dit hulpmiddel volgens het vastgestelde beleid.',
	'checkuser-desc' => 'Laat bevoegde gebruikers IP-adressen en andere informatie van gebruikers achterhalen',
	'checkuser-logcase' => 'Zoeken in het logboek is hoofdlettergevoelig.',
	'checkuser' => 'Gebruiker controleren',
	'group-checkuser' => 'controlegebruikers',
	'group-checkuser-member' => 'controlegebruiker',
	'right-checkuser' => 'IP-adressen en andere gegevens van gebruikers bekijken',
	'right-checkuser-log' => 'Het Logboek controleren gebruikers bekijken',
	'grouppage-checkuser' => '{{ns:project}}:Controlegebruiker',
	'checkuser-reason' => 'Reden:',
	'checkuser-showlog' => 'Logboek weergeven',
	'checkuser-log' => 'Logboek controleren gebruikers',
	'checkuser-query' => 'Bevraag recente wijzigingen',
	'checkuser-target' => 'Gebruiker of IP-adres',
	'checkuser-users' => 'Gebruikers opvragen',
	'checkuser-edits' => 'Bewerkingen van IP-adres opvragen',
	'checkuser-ips' => 'IP-adressen opvragen',
	'checkuser-account' => 'Bewerkingen gebruiker ophalen',
	'checkuser-search' => 'Zoeken',
	'checkuser-period' => 'Duur:',
	'checkuser-week-1' => 'laatste week',
	'checkuser-week-2' => 'laatste twee weken',
	'checkuser-month' => 'laatste 30 dagen',
	'checkuser-all' => 'alle',
	'checkuser-empty' => 'Het logboek bevat geen regels.',
	'checkuser-nomatch' => 'Geen overeenkomsten gevonden.',
	'checkuser-nomatch-edits' => 'Niets gevonden.
De laatste bewerking was op $1 om $2.',
	'checkuser-check' => 'Controleren',
	'checkuser-log-fail' => 'Logboekregel toevoegen niet mogelijk',
	'checkuser-nolog' => 'Geen logboek gevonden.',
	'checkuser-blocked' => 'Geblokkeerd',
	'checkuser-gblocked' => 'Globaal geblokkeerd',
	'checkuser-locked' => 'Afgesloten',
	'checkuser-wasblocked' => 'Eerder geblokkeerd',
	'checkuser-localonly' => 'Niet samengevoegd',
	'checkuser-massblock' => 'Geselecteerde gebruikers blokkeren',
	'checkuser-massblock-text' => 'De geselecteerde gebruikers worden voor onbepaalde tijd geblokkeerd, met automatische IP-adresblokkade ingeschakeld en het aanmaken van nieuwe gebruikers ingeschakeld.
IP-adressen worden één week geblokkeerd voor anonieme gebruikers, met het aanmaken van nieuwe gebruikers uitgeschakeld.',
	'checkuser-blocktag' => "Gebruikerspagina's vervangen door:",
	'checkuser-blocktag-talk' => "Overlegpagina's vervangen door:",
	'checkuser-massblock-commit' => 'Geselecteerde gebruikers blokkeren',
	'checkuser-block-success' => "'''De {{PLURAL:$2|gebruiker|gebruikers}} $1 {{PLURAL:$2|is|zijn}} geblokkeerd.'''",
	'checkuser-block-failure' => "'''Geen gebruikers geblokkeerd.'''",
	'checkuser-block-limit' => 'Te veel gebruikers geselecteerd.',
	'checkuser-block-noreason' => 'U moet een reden opgeven voor de blokkades.',
	'checkuser-accounts' => '$1 nieuwe {{PLURAL:$1|gebruiker|gebruikers}}',
	'checkuser-too-many' => 'Te veel resultaten. Maak de IP-reeks kleiner:',
	'checkuser-user-nonexistent' => 'De opgegeven gebruiker bestaat niet.',
	'checkuser-search-form' => 'Logboekregels zoeken waar de $1 $2 is',
	'checkuser-search-submit' => 'Zoeken',
	'checkuser-search-initiator' => 'aanvrager',
	'checkuser-search-target' => 'onderwerp',
	'checkuser-ipeditcount' => '~$1 van alle gebruikers',
	'checkuser-log-subpage' => 'Logboek',
	'checkuser-log-return' => 'Naar het hoofdformulier van ControleGebruiker terugkeren',
	'checkuser-limited' => "'''Deze resultaten zijn niet volledig om prestatieredenen.'''",
	'checkuser-log-userips' => '$1 heeft IP-adressen voor $2',
	'checkuser-log-ipedits' => '$1 heeft bewerkingen voor $2',
	'checkuser-log-ipusers' => '$1 heeft gebruikers voor $2',
	'checkuser-log-ipedits-xff' => '$1 heeft bewerkingen voor XFF $2',
	'checkuser-log-ipusers-xff' => '$1 heeft gebruikers voor XFF $2',
	'checkuser-log-useredits' => '$1 heeft bewerkingen voor $2',
	'checkuser-autocreate-action' => 'is automatisch aangemaakt',
	'checkuser-email-action' => 'heeft een e-mail gestuurd aan "$1"',
	'checkuser-reset-action' => 'heeft het wachtwoord voor gebruiker "$1" opnieuw ingesteld',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'checkuser-summary' => 'Dette verktøyet går gjennom siste endringar for å henta IP-ane som er nytta av ein brukar, eller syner endrings- eller brukarinformasjon for ein IP.

Brukarar og endringar frå ein klient-IP kan verta henta gjennom XFF ved å leggja til «/xff» bak IP-en. IPv4 (CIDR 16-32) og IPv6 (CIDR 64-128) er støtta.

Av yteårsaker vert høgst 5000 endringar viste. 
Nytt dette verktøyet i samsvar med retningsliner.',
	'checkuser-desc' => 'Gjev brukarar med dei rette rettane moglegheita til å sjekka IP-adressene til og annan informasjon om brukarar.',
	'checkuser-logcase' => 'Loggsøket tek omsyn til små og store bokstavar.',
	'checkuser' => 'Brukarsjekk',
	'group-checkuser' => 'Brukarkontrollørar',
	'group-checkuser-member' => 'Brukarkontrollør',
	'right-checkuser' => 'Sjekka IP-adressene til brukarar i tillegg til annan informasjon.',
	'right-checkuser-log' => 'Sjå brukarkontroll-loggen',
	'grouppage-checkuser' => '{{ns:project}}: Brukarkontrollør',
	'checkuser-reason' => 'Årsak:',
	'checkuser-showlog' => 'Syn logg',
	'checkuser-log' => 'Logg over brukarkontrollering',
	'checkuser-query' => 'Søk i siste endringar',
	'checkuser-target' => 'Brukar eller IP',
	'checkuser-users' => 'Hent brukarar',
	'checkuser-edits' => 'Hent endringar frå IP',
	'checkuser-ips' => 'Hent IP-ar',
	'checkuser-account' => 'Hent endringar frå konto',
	'checkuser-search' => 'Søk',
	'checkuser-period' => 'Varigskap:',
	'checkuser-week-1' => 'førre veka',
	'checkuser-week-2' => 'siste to veker',
	'checkuser-month' => 'siste 30 dagar',
	'checkuser-all' => 'alle',
	'checkuser-empty' => 'Loggen inneheld ingen element.',
	'checkuser-nomatch' => 'Ingen treff.',
	'checkuser-nomatch-edits' => 'Ingen treff.
Siste endringar skjedde $1 $2.',
	'checkuser-check' => 'Sjekk',
	'checkuser-log-fail' => 'Kunne ikkje leggja til loggelement.',
	'checkuser-nolog' => 'Fann inga loggfil.',
	'checkuser-blocked' => 'Blokkert',
	'checkuser-gblocked' => 'Blokkert globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidlegare blokkert',
	'checkuser-localonly' => 'Ikkje samanslege',
	'checkuser-massblock' => 'Blokker valte brukarar',
	'checkuser-massblock-text' => 'Valte kontoar vil verta blokkerte endelaust, med autoblokkering slege på og kontooppretting slege av.
IP-adresser vil verta blokkerte for éi veka for uregistrerte, med kontooppretting slege av.',
	'checkuser-blocktag' => 'Erstatt brukarsider med:',
	'checkuser-blocktag-talk' => 'Erstatt diskusjonssider med:',
	'checkuser-massblock-commit' => 'Blokker valte brukarar',
	'checkuser-block-success' => "'''{{PLURAL:$2|Brukaren|Brukarane}} $1 er no {{PLURAL:$2|blokkert|blokkerte}}.'''",
	'checkuser-block-failure' => "'''Ingen brukarar blokkerte.'''",
	'checkuser-block-limit' => 'For mange brukarar er valte.',
	'checkuser-block-noreason' => 'Du må oppgje ei blokkeringsårsak.',
	'checkuser-accounts' => '{{PLURAL:$1|Éin ny konto|$1 nye kontoar}}',
	'checkuser-too-many' => 'For mange resultat, ver venleg og reduser CIDR.
Her er IP-ene nytta (høgst 5000, sorterte etter adressa):',
	'checkuser-user-nonexistent' => 'Brukarnamnet du oppgav finst ikkje.',
	'checkuser-search-form' => 'Finn loggelement der $1 er $2',
	'checkuser-search-submit' => 'Søk',
	'checkuser-search-initiator' => 'igangsetjar',
	'checkuser-search-target' => 'mål',
	'checkuser-ipeditcount' => '~$1 frå alle brukarar',
	'checkuser-log-subpage' => 'Logg',
	'checkuser-log-return' => 'Attende til hovudskjema for brukarsjekking',
	'checkuser-limited' => "'''Desse resultata har vortne avkorta av ytegrunnar.'''",
	'checkuser-log-userips' => '$1 fekk IP-adressene til $2',
	'checkuser-log-ipedits' => '$1 fekk endringar av $2',
	'checkuser-log-ipusers' => '$1 fekk brukarar av $2',
	'checkuser-log-ipedits-xff' => '$1 fekk endringar av XFF-en $2',
	'checkuser-log-ipusers-xff' => '$1 fekk brukarar av XFF-en $2',
	'checkuser-log-useredits' => '$1 henta endringar for $2',
	'checkuser-autocreate-action' => 'vart automatisk oppretta',
	'checkuser-email-action' => 'sendte e-post til «$1»',
	'checkuser-reset-action' => 'nullstilte passord for «$1»',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Finnrind
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'checkuser-summary' => 'Dette verktøyet går gjennom siste endringer for å hente IP-ene som er brukt av en bruker, eller viser redigerings- eller brukerinformasjonen for en IP.

Brukere og redigeringer kan hentes med en XFF-IP ved å legge til «/xff» bak IP-en. IPv4 (CIDR 16-32) og IPv6 (CIDR 64-128) støttes.

Av ytelsesgrunner vises maksimalt 5000 redigeringer. Bruk dette verktøyet i samsvar med retningslinjer.',
	'checkuser-desc' => 'Gir brukere med de tilhørende rettighetene muligheten til å sjekke brukeres IP-adresser og annen informasjon',
	'checkuser-logcase' => 'Loggsøket er sensitivt for store/små bokstaver.',
	'checkuser' => 'Brukersjekk',
	'group-checkuser' => 'IP-kontrollører',
	'group-checkuser-member' => 'IP-kontrollør',
	'right-checkuser' => 'Sjekke brukeres IP-adresser og annen informasjon',
	'right-checkuser-log' => 'Se IP-kontrolloggen',
	'grouppage-checkuser' => '{{ns:project}}:IP-kontrollør',
	'checkuser-reason' => 'Årsak:',
	'checkuser-showlog' => 'Vis logg',
	'checkuser-log' => 'Brukersjekkingslogg',
	'checkuser-query' => 'Søk i siste endringer',
	'checkuser-target' => 'Bruker eller IP',
	'checkuser-users' => 'Få brukere',
	'checkuser-edits' => 'Få redigeringer fra IP',
	'checkuser-ips' => 'Få IP-er',
	'checkuser-account' => 'Hent redigeringer fra konto',
	'checkuser-search' => 'Søk',
	'checkuser-period' => 'Varighet:',
	'checkuser-week-1' => 'forrige uke',
	'checkuser-week-2' => 'siste to uker',
	'checkuser-month' => 'siste måned',
	'checkuser-all' => 'alle',
	'checkuser-empty' => 'Loggen inneholder ingen elementer.',
	'checkuser-nomatch' => 'Ingen treff.',
	'checkuser-nomatch-edits' => 'Ingen treff.
Siste redigering var $2 $1.',
	'checkuser-check' => 'Sjekk',
	'checkuser-log-fail' => 'Kunne ikke legge til loggelement.',
	'checkuser-nolog' => 'Ingen loggfil funnet.',
	'checkuser-blocked' => 'Blokkert',
	'checkuser-gblocked' => 'Blokkert globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidligere blokkert',
	'checkuser-localonly' => 'Ikke sammenslått',
	'checkuser-massblock' => 'Blokker valgte brukere',
	'checkuser-massblock-text' => 'Valgte kontoer vil blokkeres på ubestemt tid, med autoblokkering slått på og kontooppretting slått av.
IP-adresser vil blokkeres i én uke for anonyme brukere, med kontooppretting slått av.',
	'checkuser-blocktag' => 'Erstatt brukersider med:',
	'checkuser-blocktag-talk' => 'Erstatt diskusjonssider med:',
	'checkuser-massblock-commit' => 'Blokker valgte brukere',
	'checkuser-block-success' => "'''{{PLURAL:$2|Brukeren|Brukerne}} $1 er nå blokkert.'''",
	'checkuser-block-failure' => "'''Ingen brukere blokkert.'''",
	'checkuser-block-limit' => 'For mange brukere valgt.',
	'checkuser-block-noreason' => 'Du må oppgi en blokkeringsgrunn.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|ny konto|nye kontoer}}',
	'checkuser-too-many' => 'For mange resultater, vennligst innskrenk CIDR. Her er de brukte IP-ene (maks 5000, sortert etter adresse):',
	'checkuser-user-nonexistent' => 'Det gitte brukernavnet finnes ikke.',
	'checkuser-search-form' => 'Finn loggelementer der $1 er $2',
	'checkuser-search-submit' => 'Søk',
	'checkuser-search-initiator' => 'IP-kontrolløren',
	'checkuser-search-target' => 'målet',
	'checkuser-ipeditcount' => '~$1 fra alle brukere',
	'checkuser-log-subpage' => 'Logg',
	'checkuser-log-return' => 'Tilbake til hovedskjema for brukersjekking',
	'checkuser-limited' => "'''Disse resultatene har blitt avkortet av ytelsesgrunner.'''",
	'checkuser-log-userips' => '$1 fikk IP-adressene til $2',
	'checkuser-log-ipedits' => '$1 fikk endringer av $2',
	'checkuser-log-ipusers' => '$1 fikk brukere av $2',
	'checkuser-log-ipedits-xff' => '$1 fikk endringer av XFF-en $2',
	'checkuser-log-ipusers-xff' => '$1 fikk brukere av XFF-en $2',
	'checkuser-log-useredits' => '$1 hentet redigeringer for $2',
	'checkuser-autocreate-action' => 'ble automatisk opprettet',
	'checkuser-email-action' => 'sendte e-post til «$1»',
	'checkuser-reset-action' => 'nullstilte passord for «$1»',
);

/** Novial (Novial)
 * @author MF-Warburg
 */
$messages['nov'] = array(
	'checkuser-search' => 'Sercha',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'checkuser-reason' => 'Lebaka',
	'checkuser-target' => 'Mošomiši goba IP',
	'checkuser-search' => 'Fetleka',
	'checkuser-week-1' => 'Beke yago feta',
	'checkuser-week-2' => 'Beke tše pedi tšago feta',
	'checkuser-blocked' => 'Thibilwe',
	'checkuser-search-submit' => 'Fetleka',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author IAlex
 */
$messages['oc'] = array(
	'checkuser-summary' => "Aqueste esplech passa en revista los cambiaments recents per recercar l'IPS emplegada per un utilizaire, mostrar totas las edicions fachas per una IP, o per enumerar los utilizaires qu'an emplegat las IPs. Los utilizaires e las modificacions pòdon èsser trobatss amb una IP XFF se s'acaba amb « /xff ». IPv4 (CIDR 16-32) e IPv6(CIDR 64-128) son suportats. Emplegatz aquò segon las cadenas de caractèrs.",
	'checkuser-desc' => 'Balha la possibilitat a las personas exprèssament autorizadas de verificar las adreças IP dels utilizaires e mai d’autras entresenhas los concernent',
	'checkuser-logcase' => 'La recèrca dins lo Jornal es sensibla a la cassa.',
	'checkuser' => 'Verificator d’utilizaire',
	'group-checkuser' => 'Verificators d’utilizaire',
	'group-checkuser-member' => 'Verificator d’utilizaire',
	'right-checkuser' => "Verificar l'adreça IP dels utilizaires e autras entresenhas",
	'right-checkuser-log' => 'Veire lo jornal de verificacion d’adreça',
	'grouppage-checkuser' => '{{ns:project}}:Verificator d’utilizaire',
	'checkuser-reason' => 'Motiu :',
	'checkuser-showlog' => 'Afichar lo jornal',
	'checkuser-log' => "Notacion de Verificator d'utilizaire",
	'checkuser-query' => 'Recèrca pels darrièrs cambiaments',
	'checkuser-target' => "Nom de l'utilizaire o IP",
	'checkuser-users' => 'Obténer los utilizaires',
	'checkuser-edits' => "Obténer las modificacions de l'IP",
	'checkuser-ips' => 'Obténer las adreças IP',
	'checkuser-account' => 'Obténer las modificacions del compte',
	'checkuser-search' => 'Recèrca',
	'checkuser-period' => 'Durada :',
	'checkuser-week-1' => 'darrièra setmana',
	'checkuser-week-2' => 'las doas darrièras setmanas',
	'checkuser-month' => 'los 30 darrièrs jorns',
	'checkuser-all' => 'tot',
	'checkuser-empty' => "Lo jornal conten pas cap d'article",
	'checkuser-nomatch' => 'Recèrcas infructuosas.',
	'checkuser-nomatch-edits' => "Cap d'ocurréncia pas trobada.
La darrièra modificacion èra lo $1 a $2.",
	'checkuser-check' => 'Recèrca',
	'checkuser-log-fail' => "Incapaç d'ajustar la dintrada del jornal.",
	'checkuser-nolog' => 'Cap de dintrada dins lo Jornal.',
	'checkuser-blocked' => 'Blocat',
	'checkuser-gblocked' => 'Globalament blocat',
	'checkuser-locked' => 'Varrolhat',
	'checkuser-wasblocked' => 'Blocat precedentament',
	'checkuser-localonly' => 'Pas unificat',
	'checkuser-massblock' => 'Utilizaires de la plaja seleccionada',
	'checkuser-massblock-text' => 'Los comptes seleccionats seràn blocats indefinidament, amb lo blocatge automatic activat e la creacion de compte desactivada.
Las adreças IP seràn blocadas pendent una setmana unicament pels utilizaires jos IP e la creacion de compte desactivada.',
	'checkuser-blocktag' => "Remplaça las paginas d'utilizaire per :",
	'checkuser-blocktag-talk' => 'Remplaçar las paginas de discussion amb :',
	'checkuser-massblock-commit' => 'Blocar los utilizaires seleccionats',
	'checkuser-block-success' => "'''{{PLURAL:$2|L’utilizaire|Los utilizaires}} $1 {{PLURAL:$2|ara es blocat|ara son blocats}}.'''",
	'checkuser-block-failure' => "'''Cap d'utilizaire pas blocat.'''",
	'checkuser-block-limit' => "Tròp d'utilizaires seleccionats.",
	'checkuser-block-noreason' => 'Vos cal especificar un motiu pels blocatges.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|compte novèl|comptes novèls}}',
	'checkuser-too-many' => 'Tròp de resultats. Limitatz la recèrca sus las adreças IP :',
	'checkuser-user-nonexistent' => 'L’utilizaire indicat existís pas',
	'checkuser-search-form' => 'Cercar lo jornal de las entradas ont $1 es $2.',
	'checkuser-search-submit' => 'Recercar',
	'checkuser-search-initiator' => 'l’iniciaire',
	'checkuser-search-target' => 'la cibla',
	'checkuser-ipeditcount' => '~$1 per totes los utilizaires',
	'checkuser-log-subpage' => 'Jornal',
	'checkuser-log-return' => "Tornar al formulari principal de la verificacion d'utilizaire",
	'checkuser-limited' => "'''Aquestes resultats son estats troncats per de rasons ligadas a la performància.'''",
	'checkuser-log-userips' => "$1 a obtengut d'IP per $2",
	'checkuser-log-ipedits' => '$1 a obtengut de modificacions per $2',
	'checkuser-log-ipusers' => "$1 a obtengut d'utilizaires per $2",
	'checkuser-log-ipedits-xff' => '$1 a obtengut de modificacions per XFF  $2',
	'checkuser-log-ipusers-xff' => "$1 a obtengut d'utilizaires per XFF $2",
	'checkuser-log-useredits' => '$1 a obtengut las modificacions per $2',
	'checkuser-autocreate-action' => 'es estat creat automaticament',
	'checkuser-email-action' => 'a mandat un corrièr electronic a « $1 »',
	'checkuser-reset-action' => 'torna inicializar lo senhal per « $1 »',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'checkuser-reason' => 'Аххос:',
);

/** Pangasinan (Pangasinan) */
$messages['pag'] = array(
	'checkuser-reason' => 'Katonongan',
	'checkuser-target' => 'Manag-usar odino IP',
	'checkuser-users' => 'Alaen so manag-usar',
	'checkuser-search' => 'Anapen',
);

/** Pampanga (Kapampangan) */
$messages['pam'] = array(
	'checkuser' => 'Surian ya ing gagamit',
	'checkuser-reason' => 'Sangkan',
	'checkuser-showlog' => 'Pakit ya ing log',
	'checkuser-search' => 'Manintun',
);

/** Polish (Polski)
 * @author Beau
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'checkuser-summary' => 'To narzędzie skanuje ostatnie zmiany by znaleźć adresy IP użyte przez użytkownika lub pokazać edycje/użytkowników dla adresu IP. Użytkownicy i edycje spod adresu IP mogą być pozyskani przez nagłówki XFF przez dodanie do IP „/xff”. Obsługiwane są adresy IPv4 (CIDR 16-32) I IPv6 (CIDR 64-128).
Ze względu na wydajność, zostanie zwróconych nie więcej niż 5000 edycji.
Używaj tej funkcji zgodnie z zasadami.',
	'checkuser-desc' => 'Umożliwia uprawnionym użytkownikom sprawdzenie adresów IP użytkowników oraz innych informacji',
	'checkuser-logcase' => 'Szukanie w rejestrze jest czułe na wielkość znaków.',
	'checkuser' => 'Sprawdzanie IP użytkownika',
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => 'checkuser',
	'right-checkuser' => 'Sprawdzanie adresów IP oraz innych informacji o użytkownikach',
	'right-checkuser-log' => 'Podgląd rejestru checkuser',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Powód:',
	'checkuser-showlog' => 'Pokaż rejestr',
	'checkuser-log' => 'Rejestr CheckUser',
	'checkuser-query' => 'Przeanalizuj ostatnie zmiany',
	'checkuser-target' => 'Użytkownik lub IP',
	'checkuser-users' => 'Znajdź użytkowników',
	'checkuser-edits' => 'Znajdź edycje z IP',
	'checkuser-ips' => 'Znajdź adresy IP',
	'checkuser-account' => 'Pokaż edycje z konta',
	'checkuser-search' => 'Szukaj',
	'checkuser-period' => 'Okres:',
	'checkuser-week-1' => 'ostatni tydzień',
	'checkuser-week-2' => 'ostatnie dwa tygodnie',
	'checkuser-month' => 'ostatnie 30 dni',
	'checkuser-all' => 'wszystkie',
	'checkuser-empty' => 'Rejestr nie zawiera żadnych wpisów.',
	'checkuser-nomatch' => 'Nie znaleziono niczego.',
	'checkuser-nomatch-edits' => 'Brak wskazań.
Ostatnia edycja była wykonana $1 o $2.',
	'checkuser-check' => 'Sprawdź',
	'checkuser-log-fail' => 'Nie udało się dodać wpisu do rejestru',
	'checkuser-nolog' => 'Nie znaleziono pliku rejestru.',
	'checkuser-blocked' => 'Zablokowany',
	'checkuser-gblocked' => 'Zablokowany globalnie',
	'checkuser-locked' => 'Zablokowany',
	'checkuser-wasblocked' => 'Poprzednie blokady',
	'checkuser-localonly' => 'Nie posiada konta uniwersalnego',
	'checkuser-massblock' => 'Blokowanie wybranych użytkowników',
	'checkuser-massblock-text' => 'Wybrane konta zostaną zablokowane na zawsze (z włączoną funkcją automatycznego blokowania adresów IP, spod których łączą się te konta oraz wyłączoną funkcją zapobiegania utworzenia konta).
Adresy IP anonimowych użytkowników będą blokowane na 1 tydzień z wyłączoną funkcją zapobiegania utworzenia konta.',
	'checkuser-blocktag' => 'Zamień strony użytkowników z:',
	'checkuser-blocktag-talk' => 'Zamień strony dyskusji z:',
	'checkuser-massblock-commit' => 'Zablokuj wybranych użytkowników',
	'checkuser-block-success' => "'''{{PLURAL:$2|Użytkownik|Użytkownicy}} $1 {{PLURAL:$2|jest|są}} obecnie {{PLURAL:$2|zablokowany|zablokowani}}.'''",
	'checkuser-block-failure' => "'''Brak zablokowanych użytkowników.'''",
	'checkuser-block-limit' => 'Wybrano zbyt wielu użytkowników.',
	'checkuser-block-noreason' => 'Należy podać powód blokad.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nowe konto|nowe konta|nowych kont}}',
	'checkuser-too-many' => 'Zbyt wiele wyników, ogranicz CIDR.
Użytych adresów IP jest (nie więcej niż 5000, posortowane według adresu):',
	'checkuser-user-nonexistent' => 'Taki użytkownik nie istnieje.',
	'checkuser-search-form' => 'Szukaj wpisów w rejestrze, dla których $1 jest $2',
	'checkuser-search-submit' => 'Szukaj',
	'checkuser-search-initiator' => 'inicjator',
	'checkuser-search-target' => 'cel',
	'checkuser-ipeditcount' => '~$1 od wszystkich użytkowników',
	'checkuser-log-subpage' => 'Rejestr',
	'checkuser-log-return' => 'Powrót do głównego formularza CheckUser',
	'checkuser-limited' => "'''Wyniki zostały skrócone ze względu na wydajność.'''",
	'checkuser-log-userips' => '$1 dostał adresy IP dla $2',
	'checkuser-log-ipedits' => '$1 dostał edycje dla $2',
	'checkuser-log-ipusers' => '$1 otrzymał listę użytkowników adresu IP $2',
	'checkuser-log-ipedits-xff' => '$1 otrzymał listę edycji dla XFF $2',
	'checkuser-log-ipusers-xff' => '$1 otrzymał listę użytkowników dla XFF $2',
	'checkuser-log-useredits' => '$1 dostał edycje dla $2',
	'checkuser-autocreate-action' => 'został automatycznie utworzony',
	'checkuser-email-action' => 'wysłał e-mail do użytkownika „$1”',
	'checkuser-reset-action' => 'reset hasła dla użytkownika „$1”',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'checkuser-summary' => "St'utiss-sì as passa j'ùltime modìfiche për tiré sù j'adrësse IP dovra da n'utent ò pura mostré lòn ch'as fa da n'adrëssa IP e che dat utent ch'a l'abia associà.
	J'utent ch'a dòvro n'adrëssa IP e le modìfiche faite d'ambelelì as peulo tiresse sù ën dovrand le testà XFF, për felo tache-ie dapress l'adrëssa e \"/xff\". A travaja tant con la forma IPv4 (CIDR 16-32) che con cola IPv6 (CIDR 64-128).
	Për na question ëd caria ëd travaj a tira nen sù pì che 5000 modìfiche. A va dovrà comforma a ij deuit për ël process ëd contròl.",
	'checkuser-logcase' => "L'arsërca ant ël registr a conta ëdcò maiùscole e minùscole.",
	'checkuser' => "Contròl dj'utent",
	'group-checkuser' => 'Controlor',
	'group-checkuser-member' => 'Controlor',
	'grouppage-checkuser' => "{{ns:project}}:Contròl dj'utent",
	'checkuser-reason' => 'Rason',
	'checkuser-showlog' => 'Smon ël registr',
	'checkuser-log' => "Registr dël contròl dj'utent",
	'checkuser-query' => "Anterogassion dj'ùltime modìfiche",
	'checkuser-target' => 'Stranòm ò adrëssa IP',
	'checkuser-users' => "Tira sù j'utent",
	'checkuser-edits' => 'Tiré sù le modìfiche faite da na midema adrëssa IP',
	'checkuser-ips' => "Tiré sù j'adrësse IP",
	'checkuser-search' => 'Sërca',
	'checkuser-empty' => "Ës registr-sì a l'é veujd.",
	'checkuser-nomatch' => 'A-i é pa gnun-a ròba parej.',
	'checkuser-check' => 'Contròl',
	'checkuser-log-fail' => 'I-i la fom nen a gionte-ie na riga ant sël registr',
	'checkuser-nolog' => "Pa gnun registr ch'a sia trovasse.",
	'checkuser-blocked' => 'Blocà',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'checkuser-reason' => 'سبب:',
	'checkuser-showlog' => 'يادښت کتل',
	'checkuser-target' => 'کارونکی يا IP پته',
	'checkuser-search' => 'پلټل',
	'checkuser-all' => 'ټول',
	'checkuser-search-submit' => 'پلټل',
	'checkuser-search-target' => 'موخه',
	'checkuser-log-subpage' => 'يادښت',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 * @author Waldir
 */
$messages['pt'] = array(
	'checkuser-summary' => 'Esta ferramenta varre as Mudanças recentes para obter os endereços de IP de um utilizador ou para exibir os dados de edições/utilizadores para um IP.
	Utilizadores edições podem ser obtidos por um IP XFF colocando-se "/xff" no final do endereço. São suportados endereços IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
	Não serão retornadas mais de 5000 edições por motivos de desempenho. O uso desta ferramenta deverá estar de acordo com as políticas.',
	'checkuser-desc' => 'Concede a utilizadores com a permissão apropriada a possibilidade de verificar os endereços IP de um utilizador e outra informação',
	'checkuser-logcase' => 'As buscas nos registos são sensíveis a letras maiúsculas ou minúsculas.',
	'checkuser' => 'Verificar utilizador',
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => 'CheckUser',
	'right-checkuser' => 'Verificar o endereço IP de um utilizador e outras informações',
	'right-checkuser-log' => 'Ver os registros das verificações',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Motivo',
	'checkuser-showlog' => 'Exibir registos',
	'checkuser-log' => 'Registos de verificação de utilizadores',
	'checkuser-query' => 'Examinar as Mudanças recentes',
	'checkuser-target' => 'Utilizador ou IP',
	'checkuser-users' => 'Obter utilizadores',
	'checkuser-edits' => 'Obter edições de IPs',
	'checkuser-ips' => 'Obter IPs',
	'checkuser-account' => 'Obter edições desta conta',
	'checkuser-search' => 'Pesquisar',
	'checkuser-period' => 'Duração:',
	'checkuser-week-1' => 'última semana',
	'checkuser-week-2' => 'últimas duas semanas',
	'checkuser-month' => 'últimos 30 dias',
	'checkuser-all' => 'todos',
	'checkuser-empty' => 'O registo não contém itens.',
	'checkuser-nomatch' => 'Não foram encontrados resultados.',
	'checkuser-nomatch-edits' => 'Nenhum resultado encontrado.
A última edição foi em $1 às $2.',
	'checkuser-check' => 'Verificar',
	'checkuser-log-fail' => 'Não foi possível adicionar entradas ao registo',
	'checkuser-nolog' => 'Não foi encontrado um arquivo de registos.',
	'checkuser-blocked' => 'Bloqueado',
	'checkuser-gblocked' => 'Bloqueado globalmente',
	'checkuser-locked' => 'Bloqueado',
	'checkuser-wasblocked' => 'Previamente bloqueado',
	'checkuser-localonly' => 'Não unificada',
	'checkuser-massblock' => 'Bloquear utilizadores seleccionados',
	'checkuser-massblock-text' => 'As contas selecionadas serão bloqueadas indefinidamente, com bloqueio automático ativado e criação de conta desabilitada.
Endereços IP serão bloqueados por 1 semana com criação de conta desabilitada.',
	'checkuser-blocktag' => 'Substituir páginas de utilizador com:',
	'checkuser-blocktag-talk' => 'Substituir páginas de discussão por:',
	'checkuser-massblock-commit' => 'Bloquear utilizadores seleccionados',
	'checkuser-block-success' => "'''{{PLURAL:$2|O utilizador|Os utilizadores}} $1 {{PLURAL:$2|está|estão}} agora {{PLURAL:$2|bloqueado|bloqueados}}.'''",
	'checkuser-block-failure' => "'''Nenhum utilizador bloqueado.'''",
	'checkuser-block-limit' => 'Demasiados utilizadores selecionados.',
	'checkuser-block-noreason' => 'Tem de especificar um motivo para os bloqueios.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nova conta|novas contas}}',
	'checkuser-too-many' => 'Demasiados resultados; por favor, restrinja o CIDR. Aqui estão os IPs usados (5000 no máx., ordenados por endereço):',
	'checkuser-user-nonexistent' => 'O utilizador especificado não existe.',
	'checkuser-search-form' => 'Procurar entradas no registo onde $1 seja $2',
	'checkuser-search-submit' => 'Procurar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target' => 'alvo',
	'checkuser-ipeditcount' => '~$1 de todos os utilizadores',
	'checkuser-log-subpage' => 'Registo',
	'checkuser-log-return' => 'Retornar ao formulário principal de CheckUser',
	'checkuser-limited' => "'''Estes resultados foram removidos por motivos de performance.'''",
	'checkuser-log-userips' => '$1 obteve IPs de $2',
	'checkuser-log-ipedits' => '$1 obteve edições de $2',
	'checkuser-log-ipusers' => '$1 obteve utilizadores de $2',
	'checkuser-log-ipedits-xff' => '$1 obteve edições para o XFF $2',
	'checkuser-log-ipusers-xff' => '$1 obteve utilizadores para o XFF $2',
	'checkuser-log-useredits' => '$1 obteve edições de $2',
	'checkuser-autocreate-action' => 'foi automaticamente criada',
	'checkuser-email-action' => 'Enviar email para o utilizador "$1"',
	'checkuser-reset-action' => 'suprimir a senha do utilizador "$1"',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'checkuser-summary' => "Kay llamk'anaqa ñaqha hukchasqakunapim maskaykun huk ruraqpa llamk'achisqan IP huchhakunata chaskinapaq icha huk IP huchhap llamk'apusqamanta/ruraqmanta willankunata rikuchinapaq.
Ruraqkunata icha mink'akuq IP huchhap rurasqankunatapas XFF uma siq'iwanmi chaskiyta atinki IP huchhata \"/xff\" nisqawan yapaspa. IPv4 (CIDR 16-32), IPv6 (CIDR 64-128) nisqakunam llamk'akun.
Pichqa waranqamanta aswan llamk'apusqakunaqa manam kutimunqachu, allin rikuchinarayku. Kay llamk'anataqa kawpayllakama rurachiy.",
	'checkuser-logcase' => "Hallch'a maskaqqa hatun sananchata uchuy sananchamantam sapaqchan.",
	'checkuser' => 'Ruraqta llanchiy',
	'group-checkuser' => 'Ruraqkunata llanchiy',
	'group-checkuser-member' => 'Ruraqta llanchiy',
	'grouppage-checkuser' => '{{ns:project}}:Ruraqta llanchiy',
	'checkuser-reason' => 'Imarayku',
	'checkuser-showlog' => "Hallch'ata rikuchiy",
	'checkuser-log' => "Ruraq llanchiy hallch'a",
	'checkuser-query' => 'Ñaqha hukchasqakunapi maskay',
	'checkuser-target' => 'Ruraqpa sutin icha IP huchha',
	'checkuser-users' => 'Ruraqkunata chaskiy',
	'checkuser-edits' => 'Ruraqkunap hukchasqankunata chaskiy',
	'checkuser-ips' => 'IP huchhakunata chaskiy',
	'checkuser-search' => 'Maskay',
	'checkuser-empty' => "Manam kanchu ima hallch'asqapas.",
	'checkuser-nomatch' => 'Manam imapas taripasqachu.',
	'checkuser-check' => 'Llanchiy',
	'checkuser-log-fail' => "Manam atinichu hallch'aman yapayta",
	'checkuser-nolog' => "Manam hallch'ayta tarinichu",
	'checkuser-blocked' => "Hark'asqa",
	'checkuser-too-many' => "Nisyum tarisqakuna, ama hina kaspa CIDR nisqata k'ichkichay. Kaymi llamk'achisqa IP huchhakuna (5000-kama, tiyay sutikama siq'inchasqa):",
	'checkuser-user-nonexistent' => 'Nisqayki ruraqqa manam kanchu.',
	'checkuser-search-submit' => 'Maskay',
	'checkuser-search-initiator' => 'qallarichiq',
	'checkuser-search-target' => 'taripana',
	'checkuser-log-subpage' => "Hallch'a",
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'checkuser-search' => 'Tarzzut',
	'checkuser-search-submit' => 'Tarzzut',
);

/** Rhaeto-Romance (Rumantsch) */
$messages['rm'] = array(
	'checkuser-reason' => 'Motiv',
	'checkuser-search' => 'Tschertgar',
);

/** Romanian (Română)
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'checkuser-summary' => 'Acestă unealtă scanează schimbările recente pentru a regăsi IP-urile folosite de un utilizator sau arată modificările/utilizator pentru un anumit IP.
Utilizatorii şi modificările efectuate de un client IP pot fi regăsite prin antetele XFF ataşând IP-ul prin intermediul "/xff". IPv4 (CIDR 16-32) şi IPv6 (CIDR 64-128) sunt suportate.
Nu mai mult de 5000 de editări vor fi întoarse din motive de performanţă.
Foloseşte unealta în concordanţă cu politica sitului.',
	'checkuser-desc' => 'Autorizează utilizatorii cu drepturile specifice să poată verifica adresele IP şi alte informaţii',
	'checkuser-logcase' => 'Căutarea în jurnal este sensibilă la majuscule - minuscule',
	'checkuser' => 'Verifică utilizatorul',
	'group-checkuser' => 'Checkuseri',
	'group-checkuser-member' => 'Checkuser',
	'right-checkuser' => 'Verifică adresele IP ale utilizatorilor şi alte informaţii',
	'right-checkuser-log' => 'Vezi jurnalul checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Checkuser',
	'checkuser-reason' => 'Motiv:',
	'checkuser-showlog' => 'Arată jurnal',
	'checkuser-log' => 'Jurnal verificare utilizator',
	'checkuser-query' => 'Interoghează schimbările recente',
	'checkuser-target' => 'Utilizator sau IP',
	'checkuser-users' => 'Arată utilizatorii',
	'checkuser-edits' => 'Arată editările IP-ului',
	'checkuser-ips' => 'Arată IP-urile',
	'checkuser-account' => 'Arată modificările utilizatorului',
	'checkuser-search' => 'Caută',
	'checkuser-period' => 'Durată:',
	'checkuser-week-1' => 'săptămâna trecută',
	'checkuser-week-2' => 'ultimele două săptămâni',
	'checkuser-month' => 'ultimele 30 de zile',
	'checkuser-all' => 'toate',
	'checkuser-empty' => 'Jurnalul nu conţine înregistrări.',
	'checkuser-nomatch' => 'Nu au fost găsite potriviri.',
	'checkuser-nomatch-edits' => 'Niciun rezultat.
Ultima modificare a fost pe $1 la ora $2.',
	'checkuser-check' => 'Verifică',
	'checkuser-log-fail' => 'Imposibil de adăugat intrări în jurnal',
	'checkuser-nolog' => 'Nu a fost găsit un jurnal.',
	'checkuser-blocked' => 'Blocat',
	'checkuser-gblocked' => 'Blocat global',
	'checkuser-locked' => 'Încuiat',
	'checkuser-wasblocked' => 'Blocări anterioare',
	'checkuser-localonly' => 'Neunificat',
	'checkuser-massblock' => 'Blochează utilizatorii aleşi',
	'checkuser-massblock-text' => 'Conturile alese vor fi blocate definitiv, cu blocarea automată activată şi crearea de conturi dezactivată. 
Adresele IP vor fi blocate timp de o săptămână şi crearea de conturi va fi dezactivată.',
	'checkuser-blocktag' => 'Înlocuieşte paginile de utilizator cu:',
	'checkuser-blocktag-talk' => 'Înlocuieşte paginile de discuţii cu:',
	'checkuser-massblock-commit' => 'Blochează utilizatorii aleşi',
	'checkuser-block-success' => "'''{{PLURAL:$2|Utilizatorul|Utilizatorii}} $1 {{PLURAL:$2|este blocat|sunt blocaţi}}.'''",
	'checkuser-block-failure' => "'''Niciun utilizator nu este blocat.'''",
	'checkuser-block-limit' => 'Prea mulţi utilizatori selectaţi.',
	'checkuser-block-noreason' => 'Trebuie să specificaţi un motiv pentru blocări.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|cont nou|conturi noi}}',
	'checkuser-too-many' => 'Prea multe rezultate, te rog îngustează CIDR.
Iată IP-urile folosite (maxim 5000, sortate dup adresă):',
	'checkuser-user-nonexistent' => 'Utilizatorul specificat nu există.',
	'checkuser-search-form' => 'Găseşte intrările în jurnal unde $1 este $2',
	'checkuser-search-submit' => 'Caută',
	'checkuser-search-initiator' => 'iniţiator',
	'checkuser-search-target' => 'destinaţie',
	'checkuser-ipeditcount' => '~$1 de la toţi utilizatorii',
	'checkuser-log-subpage' => 'Jurnal',
	'checkuser-log-return' => 'Revenire la formularul principal Verifică Utilizatorul',
	'checkuser-limited' => "'''Aceste rezultate au fost sortate din motive de performanţă.'''",
	'checkuser-log-userips' => '$1 a verificat IP-urile lui $2',
	'checkuser-log-ipedits' => '$1 a verificat modificările efectuate de $2',
	'checkuser-log-ipusers' => '$1 a verificat conturile lui $2',
	'checkuser-log-ipedits-xff' => '$1 a verificat modificările efectuate de la adresa XFF $2',
	'checkuser-log-ipusers-xff' => '$1 a verificat conturile lui XFF $2',
	'checkuser-log-useredits' => '$1 a verificat modificările efectuate de $2',
	'checkuser-autocreate-action' => 'a fost creat automat',
	'checkuser-email-action' => 'trimite email utilizatorului "$1"',
	'checkuser-reset-action' => 'schimbă parola pentru utilizatorul "$1"',
);

/** Aromanian (Armãneashce)
 * @author Hakka
 */
$messages['roa-rup'] = array(
	'checkuser-reason' => 'Itia',
	'checkuser-search' => 'Caftã',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'grouppage-checkuser' => '{{ns:project}}:Utende ca verifiche',
	'checkuser-reason' => 'Mutive:',
	'checkuser-target' => 'Utende o IP',
	'checkuser-users' => "Pigghje l'utende",
	'checkuser-edits' => "Pigghje le cangiaminde da l'IP",
	'checkuser-ips' => "Pigghje l'IP",
	'checkuser-account' => "Pigghje le cangiaminde d'u cunde utende",
	'checkuser-search' => 'Cirche',
	'checkuser-period' => 'Durete:',
	'checkuser-week-1' => 'urtema sumane',
	'checkuser-week-2' => 'urteme doje sumane',
	'checkuser-month' => 'urteme 30 giurne',
	'checkuser-all' => 'tutte',
	'checkuser-search-submit' => 'Cirche',
	'checkuser-log-userips' => '$1 ha pigghiete le IP pe $2',
	'checkuser-log-ipedits' => '$1 ha pigghiete le cangiaminde pe $2',
	'checkuser-log-ipusers' => '$1 ha pigghiete le utinde pe $2',
	'checkuser-log-ipedits-xff' => '$1 ha pigghiete le cangiaminde pe XFF $2',
	'checkuser-log-ipusers-xff' => '$1 ha pigghiete le utinde pe XFF $2',
	'checkuser-log-useredits' => '$1 ha pigghiete le cangiaminde pe $2',
	'checkuser-autocreate-action' => 'ha state ccrejete automaticamende',
);

/** Russian (Русский)
 * @author EugeneZelenko
 * @author Ferrer
 * @author Kaganer
 * @author Silence
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'checkuser-summary' => "Данный инструмент может быть использован, чтобы получить IP-адреса, использовавшиеся участником, либо чтобы показать правки/участников, работавших с IP-адреса.
	Правки и пользователи, которые правили с опрделеннного IP-адреса, указанного в X-Forwarded-For, можно получить, добавив префикс <code>/xff</code> к IP-адресу. Поддерживаемые версии IP: 4 (CIDR 16—32) и 6 (CIDR 64—128).
	Из соображений производительности будут показаны только первые 5000 правок. Используйте эту страницу '''только в соответствии с правилами'''.",
	'checkuser-desc' => 'Предоставляет возможность проверять IP-адреса и дополнительную информацию участников',
	'checkuser-logcase' => 'Поиск по журналу чувствителен к регистру.',
	'checkuser' => 'Проверить участника',
	'group-checkuser' => 'Проверяющие участников',
	'group-checkuser-member' => 'проверяющий участников',
	'right-checkuser' => 'проверка IP-адресов и другой информации участников',
	'right-checkuser-log' => 'просмотр журнала проверки участников',
	'grouppage-checkuser' => '{{ns:project}}:Проверка участников',
	'checkuser-reason' => 'Причина:',
	'checkuser-showlog' => 'Показать журнал',
	'checkuser-log' => 'Журнал проверки участников',
	'checkuser-query' => 'Запросить свежие правки',
	'checkuser-target' => 'Участник или IP-адрес',
	'checkuser-users' => 'Получить участников',
	'checkuser-edits' => 'Запросить правки, сделанные с IP-адреса',
	'checkuser-ips' => 'Запросить IP-адреса',
	'checkuser-account' => 'Правки учётной записи',
	'checkuser-search' => 'Найти',
	'checkuser-period' => 'Длительность:',
	'checkuser-week-1' => 'последняя неделя',
	'checkuser-week-2' => 'последние две недели',
	'checkuser-month' => 'последние 30 дней',
	'checkuser-all' => 'все',
	'checkuser-empty' => 'Журнал пуст.',
	'checkuser-nomatch' => 'Совпадений не найдено.',
	'checkuser-nomatch-edits' => 'Соответствий не найдено.
Последняя правка сделана $1 в $2.',
	'checkuser-check' => 'Проверить',
	'checkuser-log-fail' => 'Невозможно добавить запись в журнал',
	'checkuser-nolog' => 'Файл журнала не найден.',
	'checkuser-blocked' => 'Заблокирован',
	'checkuser-gblocked' => 'Заблокирован глобально',
	'checkuser-locked' => 'Лишён доп. возможностей',
	'checkuser-wasblocked' => 'Подвергался блокировке',
	'checkuser-localonly' => 'Не глобальная',
	'checkuser-massblock' => 'Заблокировать выбранных участников',
	'checkuser-massblock-text' => 'Выбранные учётные записи будут заблокированы бессрочно с автоблокировкой и запретом создания новых учётных записей.
IP-адреса будут заблокированы на 1 неделю для непредставившихся участников, будет включён запрет на создание учётных записей.',
	'checkuser-blocktag' => 'Заменить страницы участников на:',
	'checkuser-blocktag-talk' => 'Заменить страницы обсуждения на:',
	'checkuser-massblock-commit' => 'Заблокировать выбранных участников',
	'checkuser-block-success' => "'''Сейчас {{PLURAL:$2|заблокирован $1 участник|заблокированы $1 участника|заблокированы $1 участников}}.'''",
	'checkuser-block-failure' => "'''Нет заблокированных участников.'''",
	'checkuser-block-limit' => 'Выбрано слишком много участников.',
	'checkuser-block-noreason' => 'Вы должны указать причину блокировок.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|новая учётная запись|новых учётных записи|новых учётных записей}}',
	'checkuser-too-many' => 'Слишком много результатов, пожалуйста, сузьте CIDR. Использованные IP (максимум 5000, отсортировано по адресу):',
	'checkuser-user-nonexistent' => 'Указанного участника не существует',
	'checkuser-search-form' => 'Найти записи журнала, где $1 является $2',
	'checkuser-search-submit' => 'Найти',
	'checkuser-search-initiator' => 'инициатор',
	'checkuser-search-target' => 'цель',
	'checkuser-ipeditcount' => '~$1 от всех участников',
	'checkuser-log-subpage' => 'Журнал',
	'checkuser-log-return' => 'Возврат к странице проверки участников',
	'checkuser-limited' => "'''Результаты были усечены чтобы не создавать дополнительной нагрузки на сервер.'''",
	'checkuser-log-userips' => '$1 получил IP адреса для $2',
	'checkuser-log-ipedits' => '$1 получил правки для $2',
	'checkuser-log-ipusers' => '$1 получил учётные записи для $2',
	'checkuser-log-ipedits-xff' => '$1 получил правки для XFF $2',
	'checkuser-log-ipusers-xff' => '$1 получил учётные записи для XFF $2',
	'checkuser-log-useredits' => '$1 получил правки $2',
	'checkuser-autocreate-action' => 'был создан автоматически',
	'checkuser-email-action' => 'отправил письмо участнику «$1»',
	'checkuser-reset-action' => 'сбросил пароль для участника $1',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'checkuser-summary' => "Бу үстүрүмүөнү кыттааччы IP-ларын көрөргө, эбэтэр IP-аадырыһы туһаммыт хас да кыттааччы уларытыыларын көрөргө туттуохха сөп.
Биир IP-аадырыстан оҥоһуллубут көннөрүүлэри, эбэтэр ону туһаммыт X-Forwarded-For ыйыллыбыт кыттааччылары көрөргө, бу префиксы IP-га туруоран биэр: <code>/xff</code>. Поддерживаемые версии IP: 4 (CIDR 16—32) и 6 (CIDR 64—128).
Систиэмэни ноҕуруускалаамаары бастакы 5000 көннөрүү эрэ көрдөрүллүөҕэ. Бу сирэйи '''сиэрдээхтик''' тутун.",
	'checkuser-desc' => 'Кыттаачылар IP-ларын уонна кинилэр тустарынан атын сибидиэнньэлэри көрөр кыаҕы биэрии.',
	'checkuser-logcase' => 'Сурунаалга көрдөөһүн улахан/кыра буукубалары араарар.',
	'checkuser' => 'Кыттааччыны бэрэбиэркэлээ',
	'group-checkuser' => 'Кыттааччылары бэрэбиэркэлээччилэр',
	'group-checkuser-member' => 'Кыттааччылары бэрэбиэркэлээччи',
	'grouppage-checkuser' => '{{ns:project}}:Кыттааччылары бэрэбиэркэлээһин',
	'checkuser-reason' => 'Төрүөтэ:',
	'checkuser-showlog' => 'Сурунаалы көрдөр',
	'checkuser-log' => 'Кыттаачылары бэрэбиэркэлээһин сурунаала',
	'checkuser-query' => 'Саҥа көннөрүүлэри көрдөр',
	'checkuser-target' => 'Кыттааччы эбэтэр IP',
	'checkuser-users' => 'Кыттаачылары ыларга',
	'checkuser-edits' => 'Бу IP-тан оҥоһуллубут көннөрүүлэри көрөргө',
	'checkuser-ips' => 'IP-лары көрдөр',
	'checkuser-account' => 'Ааты уларытыы',
	'checkuser-search' => 'Көрдөө',
	'checkuser-period' => 'Уһуна:',
	'checkuser-week-1' => 'бүтэһик нэдиэлэ',
	'checkuser-week-2' => 'бүтэһик икки нэдиэлэ',
	'checkuser-month' => 'бүтэһик 30 хонук',
	'checkuser-all' => 'барыта',
	'checkuser-empty' => 'Сурунаал кураанах',
	'checkuser-nomatch' => 'Сөп түбэһиилэр көстүбэтилэр',
	'checkuser-check' => 'Бэрэбиэркэлээ',
	'checkuser-log-fail' => 'Сурунаалга сурук эбэр табыллыбат(а)',
	'checkuser-nolog' => 'Сурунаал билэтэ көстүбэтэ',
	'checkuser-blocked' => 'Тугу эмэ гынара бобуллубут',
	'checkuser-wasblocked' => 'Урут бобуллубут',
	'checkuser-massblock' => 'Талыллыбыт кыттааччылары боп',
	'checkuser-massblock-text' => 'Талыллыбыт ааттар болдьоҕо суох бобуллуохтара. Бу ааттар аптамаатынан бобуллуохтара, маннык ааты саҥаттан оҥоруу эмиэ бобуллуо. 
IP-аадырыстартан бэлиэтэммэккэ киирии уонна саҥа ааты оҥоруу 1 нэдиэлэҕэ бобуллуо.',
	'checkuser-blocktag' => 'Кыттааччылар сирэйдэрин манныкка уларыт:',
	'checkuser-massblock-commit' => 'Талыллыбыт кыттааччылары боп',
	'checkuser-block-success' => "'''Билигин {{PLURAL:$2|$1 кыттааччы бобуллубут|$1 кыттааччы бобуллубут}}.'''",
	'checkuser-block-failure' => "'''Бобуллубут кыттааччы суох.'''",
	'checkuser-block-limit' => 'Наһаа элбэх киһини талбыккын',
	'checkuser-block-noreason' => 'Бобуу төрүөтүн этиэхтээххин.',
	'checkuser-accounts' => '$1 саҥа {{PLURAL:$1|аат|ааттар}}',
	'checkuser-too-many' => 'Наһаа элбэх булулунна, бука диэн CIDR кыччатан биэр. Туһаныллыбыт IP (саамай элбэҕэ 5000, бу аадырыһынан наардаммыт):',
	'checkuser-user-nonexistent' => 'Маннык ааттаах кыттааччы суох',
	'checkuser-search-form' => '$1 сурунаалга $2 буоларын бул',
	'checkuser-search-submit' => 'Буларга',
	'checkuser-search-initiator' => 'саҕалааччы',
	'checkuser-search-target' => 'сыал-сорук',
	'checkuser-ipeditcount' => '~$1 бары кыттааччылартан',
	'checkuser-log-subpage' => 'Сурунаал',
	'checkuser-log-return' => 'Кытааччылары бэрэбиэркэлээһин сүрүн сирэйигэр төнүн',
	'checkuser-limited' => "'''Түмүк, сиэрбэри наһаа ноҕуруускалаамаары, сорҕото быһыллыбыт.'''",
	'checkuser-log-userips' => '$1 манна анаан $2 IP аадырыстаах',
	'checkuser-log-ipedits' => '$1 манна анаан $2 көннөрүүлэрдээх',
	'checkuser-log-ipusers' => '$1 манна анаан $2 ааттардаах (учётные записи)',
	'checkuser-log-ipedits-xff' => '$1 манна анаан XFF $2 көннөрүүлэрдээх',
	'checkuser-log-ipusers-xff' => '$1 кыттаачылары ылбыт (для XFF $2)',
	'checkuser-autocreate-action' => 'аптамаатынан оҥоһуллубут',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'checkuser-summary' => "Stu strumentu analizza li mudìfichi fatti di picca pi ricupirari li nnirizzi IP utilizzati di n'utenti o ammustrari cuntribbuti e dati di nu IP. Utenti e cuntribbuti di nu client IP ponnu èssiri rintracciati pi menzu dî header XFF juncennu a l'IP lu suffissu \"/xff\". Sunnu suppurtati IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). Non vènunu turnati chiossai di 5.000 mudifichi, pi mutivi di pristazzioni. Usa stu strumentu 'n stritta cunfurmità a li policy.",
	'checkuser-desc' => "Pirmetti a l'utenti cu li giusti autorizzazzioni du suttapuniri a virifica li nnirizzi IP e àutri nfurmazzioni di l'utenti stissi",
	'checkuser-logcase' => "La circata nnê log è ''case sensitive'' (diffirènzia ntra maiùsculi e minùsculi)",
	'checkuser' => 'Cuntrolli utenzi',
	'group-checkuser' => 'Cuntrullori',
	'group-checkuser-member' => 'Cuntrullori',
	'right-checkuser' => "Talìa li nnirizzi IP usati di l'utenti a àutri nfurmazzioni",
	'right-checkuser-log' => 'Talìa li log di li checkuser',
	'grouppage-checkuser' => '{{ns:project}}:Cuntrollu utenzi',
	'checkuser-reason' => 'Mutivazzioni',
	'checkuser-showlog' => 'Ammustra lu log',
	'checkuser-log' => 'Log di li checkuser',
	'checkuser-query' => "Cera nta l'ùrtimi mudìfichi",
	'checkuser-target' => 'Utenti o IP',
	'checkuser-users' => 'Cerca utenti',
	'checkuser-edits' => 'Talìa li cuntribbuti di li IP',
	'checkuser-ips' => 'Cerca IP',
	'checkuser-account' => "Talìa li cuntribbuti di l'account",
	'checkuser-search' => 'Cerca',
	'checkuser-period' => 'Pirìudu:',
	'checkuser-week-1' => 'ùrtima simana',
	'checkuser-week-2' => 'ùrtimi dui simani',
	'checkuser-month' => 'ùrtimi 30 jorna',
	'checkuser-all' => 'tutti li canciamenti',
	'checkuser-empty' => 'Lu log non havi dati.',
	'checkuser-nomatch' => 'Nuddu risurtatu attruvatu.',
	'checkuser-nomatch-edits' => 'Nuddu risurtatu attruvatu.
Ùrtimu canciamentu fattu a li $2 di lu $1.',
	'checkuser-check' => 'Cuntrolla',
	'checkuser-log-fail' => 'Mpussìbbili junciri la vuci a lu log',
	'checkuser-nolog' => 'Non vinni atruvatu nuddu file di log.',
	'checkuser-blocked' => 'Bluccatu',
	'checkuser-gblocked' => 'Bluccattu glubbarmenti',
	'checkuser-locked' => 'Chiuruti',
	'checkuser-wasblocked' => 'Bluccatu prima di ora',
	'checkuser-localonly' => 'No unificata',
	'checkuser-massblock' => "Blocca l'utenti silizziunati",
	'checkuser-massblock-text' => "L'account silizziunati vennu  bluccati pi sempri, cô bloccu autumàticu attivatu e la criazzioni di novi account disattivata.
Li nnirizzi IP vennu bluccati pi na simana sulu pi l'utenti anònimi e câ criazzioni account disattivata.",
	'checkuser-blocktag' => 'Scancia pàggini utenti cu:',
	'checkuser-blocktag-talk' => 'Scancia pàggini utenti di discussioni cu:',
	'checkuser-massblock-commit' => 'Blocca utenti silizziunati',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utenti|Li utenti}} $1 {{PLURAL:$2|è ora bluccatu|sunnu ora bluccati}}.'''",
	'checkuser-block-failure' => "'''Nuddu utenti bluccatu.'''",
	'checkuser-block-limit' => 'Troppi utenti silizziunati.',
	'checkuser-block-noreason' => 'È òbbricu dari na mutivazzioni pi li blocchi.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|novo|novi}} account',
	'checkuser-too-many' => "Li nùmmira dî risulrtati è troppu assai, usari nu CIDR cchiù nicu. Si sècutu sù nnicati li nnirizzi IP utilizzati (nzinu a non chiossai di 5000, misi 'n òrdini pi nnirizzu):",
	'checkuser-user-nonexistent' => "L'utenti nnicatu non esisti.",
	'checkuser-search-form' => 'Attrova li vuci di li log pi li quali $1 è $2',
	'checkuser-search-submit' => 'Circata',
	'checkuser-search-initiator' => 'Nizziaturi',
	'checkuser-search-target' => 'ubbiettivu',
	'checkuser-ipeditcount' => "~$1 pi tutti pari l'utenti",
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Torna ô mòdulu principali di Cuntrollu utenzi',
	'checkuser-limited' => "'''Li risurtati foru truncati pi mutivi di pristazzioni.'''",
	'checkuser-log-userips' => '$1 uttinìu li nnirizzi IP di $2',
	'checkuser-log-ipedits' => '$1 uttinìu li mudìfichi di $2',
	'checkuser-log-ipusers' => '$1 uttinìu li utenzi di $2',
	'checkuser-log-ipedits-xff' => '$1 uttinìu li mudìfichi di $2 pi XFF',
	'checkuser-log-ipusers-xff' => "$1 uttinìu l'utenzi di $2 pi XFF",
	'checkuser-log-useredits' => '$1 uttinìu li cuntribbuti di $2',
	'checkuser-autocreate-action' => 'fu criatu autumàticamenti',
	'checkuser-email-action' => 'inviau n\' e-mail a "$1"',
	'checkuser-reset-action' => 'mposta n\'àutra vota password pi l\'utenti "$1"',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'checkuser-reason' => 'හේතුව:',
	'checkuser-showlog' => 'ලඝු-සටහන පෙන්වන්න',
	'checkuser-search' => 'ගවේෂණය',
	'checkuser-period' => 'කාල සීමාව:',
	'checkuser-week-1' => 'පසුගිය සතිය',
	'checkuser-week-2' => 'පසුගිය සති දෙක',
	'checkuser-month' => 'පසුගිය දින 30',
	'checkuser-all' => 'සියල්ල',
	'checkuser-empty' => 'ලඝු-සටහනෙහි කිසිදු අයිතමයක් නොමැත.',
	'checkuser-nomatch' => 'කිසිදු ගැලපුමක් සමුනොවිනි.',
	'checkuser-nomatch-edits' => 'කිසිදු ගැලපුමක් සමුනොවිනි. අවසන් සංස්කරණය  $1 වෙත සිදුකොට තිබිණි.',
	'checkuser-check' => 'පරික්ෂා කරන්න',
	'checkuser-log-fail' => 'ලඝු-සටහනක් එකතු කිරීමට නොහැක',
	'checkuser-nolog' => 'ලඝු-සටහන් ගොනුවක් හමු නොවිණි.',
	'checkuser-log-userips' => 'සංස්කරණය සඳහා  $2 විසින් භාවිත කෙරුණු අන්තර්ජාල ලිපිනයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipedits' => '$2 අන්තර්ජාල ලිපිනය වෙතින් සිදු කෙරුණු සංස්කරණයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipusers' => '$2 අන්තර්ජාල ලිපිනය භාවිතා කල පරිශීලකයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipedits-xff' => '$2 XFF අන්තර්ජාල ලිපිනය මගින් සිදු කෙරුණු සංස්කරණයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-ipusers-xff' => '$2 XFF අන්තර්ජාල ලිපිනය භාවිතා කල පරිශීලකයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-log-useredits' => '$2 අන්තර්ජාල ලිපිනය වෙතින් සිදු කෙරුණු සංස්කරණයන් $1 විසින් පරික්‍ෂා කොට දැනගෙන ඇත',
	'checkuser-autocreate-action' => 'ස්වයංක්‍රීය ලෙස තැනිණි',
	'checkuser-email-action' => ' "$1" පරිශීලක වෙත විද්‍යුත්-ගැපෑලක් යැවිණි',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Martin Kozák
 */
$messages['sk'] = array(
	'checkuser-summary' => 'Tento nástroj kontroluje Posledné úpravy, aby získal IP adresy používané používateľom alebo zobrazil úpravy/používateľské dáta IP adresy.
	Používateľov a úpravy je možné získať s XFF IP pridaním „/xff“ k IP. Sú podporované IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128).
	Z dôvodov výkonnosti nebude vrátených viac ako 5000 úprav. Túto funkciu využívajte len v súlade s platnou politikou.',
	'checkuser-desc' => 'Dáva používateľom s príslušným oprávnením možnosť overovať IP adresu a iné informácie o používateľovi',
	'checkuser-logcase' => 'Vyhľadávanie v zázname zohľadňuje veľkosť písmen.',
	'checkuser' => 'Overiť používateľa',
	'group-checkuser' => 'Revízor',
	'group-checkuser-member' => 'Revízori',
	'right-checkuser' => 'Skontrolovať IP adresy a iné informácie používateľov',
	'right-checkuser-log' => 'Zobraziť záznam kontrol používateľov',
	'grouppage-checkuser' => '{{ns:project}}:Revízia používateľa',
	'checkuser-reason' => 'Dôvod:',
	'checkuser-showlog' => 'Zobraziť záznam',
	'checkuser-log' => 'Záznam kontroly používateľov',
	'checkuser-query' => 'Získať z posledných úprav',
	'checkuser-target' => 'Používateľ alebo IP',
	'checkuser-users' => 'Získať používateľov',
	'checkuser-edits' => 'Získať úpravy z IP',
	'checkuser-ips' => 'Získať IP adresy',
	'checkuser-account' => 'Zistiť úpravy používateľa',
	'checkuser-search' => 'Hľadať',
	'checkuser-period' => 'Trvanie:',
	'checkuser-week-1' => 'posledný týždeň',
	'checkuser-week-2' => 'posledné dva týždne',
	'checkuser-month' => 'posledných 30 dní',
	'checkuser-all' => 'všetky',
	'checkuser-empty' => 'Záznam neobsahuje žiadne položky.',
	'checkuser-nomatch' => 'Žiadny vyhovujúci záznam.',
	'checkuser-nomatch-edits' => 'Neboli nájdené zhody.
Posledná úprava bola $1 o $2.',
	'checkuser-check' => 'Skontrolovať',
	'checkuser-log-fail' => 'Nebolo možné pridať položku záznamu',
	'checkuser-nolog' => 'Nebol nájdený súbor záznamu.',
	'checkuser-blocked' => 'Zablokovaný',
	'checkuser-gblocked' => 'Globálne zablokovaný',
	'checkuser-locked' => 'Zamknutý',
	'checkuser-wasblocked' => 'už bol zablokovaný',
	'checkuser-localonly' => 'Nezjednotené',
	'checkuser-massblock' => 'Zablokovať vybraných používateľov',
	'checkuser-massblock-text' => 'Vybrané účty sa zablokujú na neurčito, automatické blokovanie bude zapnuté a vytváranie účtov vypnuté.
IP adresy sa zablokujú na 1 týždeň pri iba anonymných používateľoch a vytváranie účtov bude vypnuté.',
	'checkuser-blocktag' => 'Nahradiť používateľké stránky textom:',
	'checkuser-blocktag-talk' => 'nahradiť diskusné stránky čím:',
	'checkuser-massblock-commit' => 'Zablokovať vybraných používateľov',
	'checkuser-block-success' => "'''{{PLURAL:$2|Používateľ|Používatelia}} $1 {{PLURAL:$2|je|sú}} odteraz zablokovaní.'''",
	'checkuser-block-failure' => "'''Žiaden používateľ nebol zablokovaný.'''",
	'checkuser-block-limit' => 'Bolo zvolených príliš veľa používateľov.',
	'checkuser-block-noreason' => 'Musíte zadať dôvod blokovaní.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nový účet|nové účty|nových účtov}}',
	'checkuser-too-many' => 'Príliš veľa výsledkov, prosím zúžte CIDR. Tu sú použité IP (max. 5 000, zoradené podľa adresy):',
	'checkuser-user-nonexistent' => 'Uvedený používateľ neexistuje.',
	'checkuser-search-form' => 'Nájsť položky záznamu, kde $1 je $2',
	'checkuser-search-submit' => 'Hľadať',
	'checkuser-search-initiator' => 'začínajúci',
	'checkuser-search-target' => 'cieľ',
	'checkuser-ipeditcount' => 'asi $1 zo všetkých používateľov',
	'checkuser-log-subpage' => 'Záznam',
	'checkuser-log-return' => 'Vrátiť sa na hlavný formulár CheckUser',
	'checkuser-limited' => "'''Tieto výsledky boli z výkonnostných dôvodov skrátené.'''",
	'checkuser-log-userips' => '$1 má IP adresy $2',
	'checkuser-log-ipedits' => '$1 má úpravy $2',
	'checkuser-log-ipusers' => '$1 má používateľov $2',
	'checkuser-log-ipedits-xff' => '$1 má úpravy XFF $2',
	'checkuser-log-ipusers-xff' => '$1 má používateľov XFF $2',
	'checkuser-log-useredits' => '$1 má úpravy $2',
	'checkuser-autocreate-action' => 'bol automaticky vytvorený',
	'checkuser-email-action' => 'poslaný email používateľovi „$1”',
	'checkuser-reset-action' => 'vytvoriť nové heslo pre používateľa „$1”',
);

/** Albanian (Shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'checkuser' => 'Kontrollo përdoruesin',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Sasa Stefanovic
 * @author Јованвб
 */
$messages['sr-ec'] = array(
	'checkuser-desc' => 'Даје сарадницима са одговарајућим правима могућност да провере ИП адресе сарадника и друге информације.',
	'checkuser-logcase' => 'Претрага лога је осетљива на мала и велика слова.',
	'checkuser' => 'Чекјузер',
	'group-checkuser' => 'Чекјузери',
	'group-checkuser-member' => 'Чекјузер',
	'right-checkuser' => 'Проверава сарадничке ИП адресе и друге информације.',
	'right-checkuser-log' => 'Погледај чекјузер лог',
	'grouppage-checkuser' => '{{ns:project}}:Чекјузер',
	'checkuser-reason' => 'Резлог:',
	'checkuser-showlog' => 'Прикажи лог.',
	'checkuser-log' => 'Лог чекјузера.',
	'checkuser-query' => 'Упит на скорашње измене.',
	'checkuser-target' => 'Корисник или ИП',
	'checkuser-users' => 'Прикупљање сарадничких имена.',
	'checkuser-edits' => 'Прикупљање измена од стране ИП адресе.',
	'checkuser-ips' => 'Прикупља ИП адресе.',
	'checkuser-search' => 'Претрага',
	'checkuser-period' => 'Трајање:',
	'checkuser-week-1' => 'последња недеља',
	'checkuser-week-2' => 'последње две недеље',
	'checkuser-month' => 'последњих 30 дана',
	'checkuser-all' => 'све',
	'checkuser-empty' => 'Лог не садржи ништа.',
	'checkuser-nomatch' => 'Нема погодака.',
	'checkuser-check' => 'Провера',
	'checkuser-log-fail' => 'Није било могуће додати податак у лог.',
	'checkuser-nolog' => 'Ниједан фајл с логовима није пронађен.',
	'checkuser-blocked' => 'Блокиран',
	'checkuser-wasblocked' => 'Претходно блокиран',
	'checkuser-massblock' => 'Блокирај изабраног корисника',
	'checkuser-blocktag' => 'Замени корисничке странице са:',
	'checkuser-massblock-commit' => 'Блокирај изабраног корисника',
	'checkuser-block-limit' => 'Превише корисника је изабрано.',
	'checkuser-block-noreason' => 'Морате дати разлог за блок.',
	'checkuser-too-many' => 'Превише резултата; смањи CIDR. Ево списка коришћених ИП адреса (максимално 5000, сортирано по адреси):',
	'checkuser-user-nonexistent' => 'Тражени сарадник не постоји.',
	'checkuser-search-form' => 'Претрага лога где је $1 једнако $2.',
	'checkuser-search-submit' => 'Претрага',
	'checkuser-search-initiator' => 'покретач',
	'checkuser-search-target' => 'циљ',
	'checkuser-ipeditcount' => '~$1 од свих сарадника',
	'checkuser-log-subpage' => 'лог',
	'checkuser-log-return' => 'Повратак на основну форму чекјузера.',
	'checkuser-log-userips' => '$1 је добио ИП адресе за $2',
	'checkuser-log-ipedits' => '$1 је добио измене за $2',
	'checkuser-log-ipusers' => '$1 је добио сараднике за $2',
	'checkuser-log-ipedits-xff' => '$1 је добио измене за XFF $2',
	'checkuser-log-ipusers-xff' => '$1 је добио сараднике за XFF $2',
	'checkuser-autocreate-action' => 'је аутоматски направљен',
	'checkuser-email-action' => 'послат је мејл кориснику "$1"',
);

/** latinica (latinica) */
$messages['sr-el'] = array(
	'checkuser' => 'Čekjuzer',
	'group-checkuser' => 'Čekjuzeri',
	'group-checkuser-member' => 'Čekjuzer',
	'grouppage-checkuser' => '{{ns:project}}:Čekjuzer',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'checkuser-summary' => 'Disse Reewe truchsäkt do lääste Annerengen, uum ju IP-Adresse fon n Benutser
	blw. do Beoarbaidengen/Benutsernoomen foar ne IP-Adresse fäästtoustaalen. Benutsere un
Beoarbaidengen fon ne IP-Adresse konnen uk ätter Informatione uut do XFF-Headere
	oufräiged wäide, as an ju IP-Adresse n „/xff“ anhonged wäd. (CIDR 16-32) un IPv6 (CIDR 64-128) wäide unnerstutsed.
	Uut Perfomance-Gruunde wäide maximoal 5000 Beoarbaidengen uutroat. Benutsje CheckUser bloot in Uureenstämmenge mäd do Doatenschutsgjuchtlienjen.',
	'checkuser-desc' => 'Ferlööwet Benutsere mäd do äntspreekende Gjuchte do IP-Adressen as uk wiedere Informatione fon Benutsere tou wröigjen.',
	'checkuser-logcase' => 'Ju Säike in dät Logbouk unnerschat twiske Groot- un Littikschrieuwen.',
	'checkuser' => 'Checkuser',
	'group-checkuser' => 'Checkusers',
	'group-checkuser-member' => 'Checkuser-Begjuchtigde',
	'right-checkuser' => 'Wröigenge fon IP-Adressen as uk Ferbiendengen twiske IPs un ounmäldede Benutsere',
	'right-checkuser-log' => 'Bekiekjen fon dät Checkuser-Logbouk',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Gruund:',
	'checkuser-showlog' => 'Logbouk anwiese',
	'checkuser-log' => 'Checkuser-Logbouk',
	'checkuser-query' => 'Lääste Annerengen oufräigje',
	'checkuser-target' => 'Benutser of IP-Adresse',
	'checkuser-users' => 'Hoal Benutsere',
	'checkuser-edits' => 'Hoal Beoarbaidengen fon IP-Adresse',
	'checkuser-ips' => 'Hoal IP-Adressen',
	'checkuser-account' => 'Hoal Beoarbaidengen fon Benutserkonto',
	'checkuser-search' => 'Säike',
	'checkuser-period' => 'Tiedruumte:',
	'checkuser-week-1' => 'lääste 7 Deege',
	'checkuser-week-2' => 'lääste 14 Deege',
	'checkuser-month' => 'lääste 30 Deege',
	'checkuser-all' => 'aal',
	'checkuser-empty' => 'Dät Logbouk änthaalt neen Iendraage.',
	'checkuser-nomatch' => 'Neen Uureenstämmengen fuunen.',
	'checkuser-check' => 'Uutfiere',
	'checkuser-log-fail' => 'Logbouk-Iendraach kon nit bietouföiged wäide.',
	'checkuser-nolog' => 'Neen Logbouk fuunen.',
	'checkuser-blocked' => 'speerd',
	'checkuser-gblocked' => 'globoal speerd',
	'checkuser-locked' => 'sleeten',
	'checkuser-wasblocked' => 'fröier speerd',
	'checkuser-massblock' => 'Speer do uutwäälde Benutsere',
	'checkuser-massblock-text' => 'Do uutwäälde Benutserkonten wäide duurhaft speerd (Autoblock is aktiv un ju Anloage fon näie Benutserkonten wäd unnerbuunen).
IP-Adressen wäide foar een Wiek speerd (bloot foar anonyme Benutsere, ju Anloage fon näie Benutserkonten wäd unnerbuunen).',
	'checkuser-blocktag' => 'Inhoold fon ju Benutsersiede ärsätte truch:',
	'checkuser-massblock-commit' => 'Speer do uutwäälde Benutsere',
	'checkuser-block-success' => "'''{{PLURAL:$2|Die Benutser|Do Benutsere}} $1 {{PLURAL:$2|wuud|wuuden}} speerd.'''",
	'checkuser-block-failure' => "'''Der wuuden neen Benutsere speerd.'''",
	'checkuser-block-limit' => 'Der wuuden toufuul Benutsere uutwääld.',
	'checkuser-block-noreason' => 'Du moast n Gruund foar ju Speere anreeke.',
	'checkuser-accounts' => '{{PLURAL:$1|1 näi Benutserkonto|$1 näie Benutserkonten}}',
	'checkuser-too-many' => 'Ju Lieste fon Resultoate is tou loang, gränsje dän IP-Beräk fääre ien. Hier sunt do benutsede IP-Adressen (maximoal 5000, sortierd ätter Adresse):',
	'checkuser-user-nonexistent' => 'Die anroate Benutser bestoant nit.',
	'checkuser-search-form' => 'Säik Lochboukiendraage, wier $1 $2 is.',
	'checkuser-search-submit' => 'Säik',
	'checkuser-search-initiator' => 'Initiator',
	'checkuser-search-target' => 'Siel',
	'checkuser-ipeditcount' => '~$1 fon aal Benutsere',
	'checkuser-log-subpage' => 'Logbouk',
	'checkuser-log-return' => 'Tourääch ätter dät CheckUser-Haudformular',
	'checkuser-limited' => "'''Ju Resultoatelieste wuud uut Performancegruunden kuuted.'''",
	'checkuser-log-userips' => '$1 hoalde IP-Adressen foar $2',
	'checkuser-log-ipedits' => '$1 hoalde Beoarbaidengen foar $2',
	'checkuser-log-ipusers' => '$1 hoalde Benutsere foar $2',
	'checkuser-log-ipedits-xff' => '$1 hoalde Beoarbaidengen foar XFF $2',
	'checkuser-log-ipusers-xff' => '$1 hoalde Benutsere foar XFF $2',
	'checkuser-log-useredits' => '$1 hoalde Beoarbaidengen foar $2',
	'checkuser-autocreate-action' => 'automatisk moaked',
	'checkuser-email-action' => 'E-Mail an „$1“ soand',
	'checkuser-reset-action' => 'Anfoarderenge fon n näi Paaswoud foar „Benutser:$1“',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'checkuser-desc' => 'Leler kawenangan pikeun mariksa alamat IP jeung émbaran lianna ti hiji pamaké',
	'checkuser-logcase' => 'Panyungsi log ngabédakeun kapitalisasi.',
	'checkuser' => 'Pamaké pamariksa',
	'group-checkuser' => 'Pamaké pamariksa',
	'group-checkuser-member' => 'Pamaké pamariksa',
	'grouppage-checkuser' => '{{ns:project}}:Pamaké pamariksa',
	'checkuser-reason' => 'Alesan',
	'checkuser-showlog' => 'Témbongkeun log',
	'checkuser-log' => 'Log PamakéPamariksa',
	'checkuser-target' => 'Landihan atawa IP',
	'checkuser-users' => 'Sungsi pamaké',
	'checkuser-edits' => 'Sungsi éditan ti IP',
	'checkuser-ips' => 'Sungsi IP',
	'checkuser-search' => 'Sungsi',
	'checkuser-empty' => 'Logna kosong.',
	'checkuser-nomatch' => 'Euweuh nu cocog.',
	'checkuser-check' => 'Pariksa',
	'checkuser-log-fail' => 'Teu bisa nambahkeun kana log',
	'checkuser-nolog' => 'Koropak log teu kapanggih.',
	'checkuser-blocked' => 'Dipeungpeuk',
	'checkuser-too-many' => 'Hasilna loba teuing, heureutan CIDR-na.
Di handap ieu béréndélan IP nu dipaké (paling loba 5000, disusun dumasar alamat):',
	'checkuser-user-nonexistent' => 'Euweuh pamaké nu cocog jeung pamundut.',
	'checkuser-search-form' => 'Téang éntri log nu $1-na sarua jeung $2',
	'checkuser-search-submit' => 'Sungsi',
	'checkuser-search-initiator' => 'inisiator',
	'checkuser-search-target' => 'tujul',
	'checkuser-ipeditcount' => '~$1 ti sakumna pamaké',
	'checkuser-log-subpage' => 'Log',
	'checkuser-log-return' => 'Balik ka formulir utama PamakéPamariksa',
	'checkuser-log-userips' => '$1 manggih IP ti $2',
	'checkuser-log-ipedits' => '$1 manggih éditan ti $2',
	'checkuser-log-ipusers' => '$1 manggih pamaké ti $2',
	'checkuser-log-ipedits-xff' => '$1 manggih éditan ti XFF $2',
	'checkuser-log-ipusers-xff' => '$1 manggih pamaké ti XFF $2',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author Leo Johannes
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'checkuser-summary' => 'Det här verktyget söker igenom de senaste ändringarna för att hämta IP-adresser för en användare, eller redigeringar och användare för en IP-adress.
Användare och redigeringar kan visas med IP-adress från XFF genom att lägga till "/xff" efter IP-adressen. Verktyget stödjer IPv4 (CIDR 16-32) och IPv6 (CIDR 64-128).
På grund av prestandaskäl så visas inte mer än 5000 redigeringar. Använd verktyget i enlighet med policy.',
	'checkuser-desc' => 'Ger möjlighet för användare med speciell behörighet att kontrollera användares IP-adresser och viss annan information',
	'checkuser-logcase' => 'Loggsökning är skiftlägeskänslig.',
	'checkuser' => 'Kontrollera användare',
	'group-checkuser' => 'Användarkontrollanter',
	'group-checkuser-member' => 'användarkontrollant',
	'right-checkuser' => 'Kolla användares IP-adresser och annan information',
	'right-checkuser-log' => 'Se loggen över användarkontroller',
	'grouppage-checkuser' => '{{ns:project}}:Användarkontrollant',
	'checkuser-reason' => 'Anledning:',
	'checkuser-showlog' => 'Visa logg',
	'checkuser-log' => 'Logg över användarkontroller',
	'checkuser-query' => 'Sök de senaste ändringarna',
	'checkuser-target' => 'Användare eller IP',
	'checkuser-users' => 'Hämta användare',
	'checkuser-edits' => 'Hämta redigeringar från IP-adress',
	'checkuser-ips' => 'Hämta IP-adresser',
	'checkuser-account' => 'Hämta redigeringar från konto',
	'checkuser-search' => 'Sök',
	'checkuser-period' => 'Tidsperiod:',
	'checkuser-week-1' => 'senaste veckan',
	'checkuser-week-2' => 'senaste två veckorna',
	'checkuser-month' => 'senaste 30 dagarna',
	'checkuser-all' => 'alla',
	'checkuser-empty' => 'Loggen innehåller inga poster.',
	'checkuser-nomatch' => 'Inga träffar hittades.',
	'checkuser-nomatch-edits' => 'Fick ingen träff.
Senaste redigering var $1 kl $2.',
	'checkuser-check' => 'Kontrollera',
	'checkuser-log-fail' => 'Loggposten kunde inte läggas i loggfilen.',
	'checkuser-nolog' => 'Hittade ingen loggfil.',
	'checkuser-blocked' => 'Blockerad',
	'checkuser-gblocked' => 'Blockerad globalt',
	'checkuser-locked' => 'Låst',
	'checkuser-wasblocked' => 'Tidigare blockerad',
	'checkuser-localonly' => 'Inte sammanslaget',
	'checkuser-massblock' => 'Blockera valda användare',
	'checkuser-massblock-text' => 'Valda konton kommer blockeras på obestämd tid, med autoblockering aktiverad och kontoskapande avaktiverat.
IP-adresser kommer blockeras i en vecka för anonyma användare, med kontoskapande avaktiverat.',
	'checkuser-blocktag' => 'Ersätt användarsidor med:',
	'checkuser-blocktag-talk' => 'Ersätt diskussionssidor med:',
	'checkuser-massblock-commit' => 'Blockera valda användare',
	'checkuser-block-success' => "'''{{PLURAL:$2|Användaren|Användarna}} $1 är nu {{PLURAL:$2|blockerad|blockerade}}.'''",
	'checkuser-block-failure' => "'''Ingen användare blockerades.'''",
	'checkuser-block-limit' => 'För många användare valda.',
	'checkuser-block-noreason' => 'Du måste ange en anledning för blockeringarna.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|nytt konto|nya konton}}',
	'checkuser-too-many' => 'För många resultat, du bör söka i ett mindre CIDR-block. Här följer de IP-adresser som använts (högst 5000, sorterade efter adress):',
	'checkuser-user-nonexistent' => 'Användarnamnet som angavs finns inte.',
	'checkuser-search-form' => 'Sök efter poster där $1 är $2',
	'checkuser-search-submit' => 'Sök',
	'checkuser-search-initiator' => 'kontrollanten',
	'checkuser-search-target' => 'kontrollmålet',
	'checkuser-ipeditcount' => '~$1 från alla användare',
	'checkuser-log-subpage' => 'Logg',
	'checkuser-log-return' => 'Gå tillbaka till formuläret för användarkontroll',
	'checkuser-limited' => "'''Dessa resultat har av prestandaskäl blivit avkortade.'''",
	'checkuser-log-userips' => '$1 hämtade IP-adresser för $2',
	'checkuser-log-ipedits' => '$1 hämtade redigeringar från $2',
	'checkuser-log-ipusers' => '$1 hämtade användare från $2',
	'checkuser-log-ipedits-xff' => '$1 hämtade redigeringar från XFF $2',
	'checkuser-log-ipusers-xff' => '$1 hämtade användare från XFF $2',
	'checkuser-log-useredits' => '$1 hämtade redigeringar för $2',
	'checkuser-autocreate-action' => 'skapades automatiskt',
	'checkuser-email-action' => 'skickade ett mejl till användare "$1"',
	'checkuser-reset-action' => 'återställ lösenord för användare "$1"',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'checkuser-reason' => 'Čymu',
	'checkuser-search' => 'Šnupej',
	'checkuser-search-submit' => 'Šnupej',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'checkuser-search' => 'தேடுக',
	'checkuser-search-submit' => 'தேடுக',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Mpradeep
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'checkuser-summary' => 'ఈ పరికరం ఓ వాడుకరి వాడిన ఐపీలను, లేదా ఒక ఐపీకి చెందిన దిద్దుబాట్లు, వాడుకరుల డేటాను చూపిస్తుంది.
క్లయంటు ఐపీకి చెందిన వాడుకరులు, దిద్దుబాట్లను ఐపీకి /xff అని చేర్చి, XFF హెడర్ల ద్వారా వెలికితీయవచ్చు. IPv4 (CIDR 16-32) and IPv6 (CIDR 64-128) లు పనిచేస్తాయి.
పనితనపు కారణాల వలన 5000 దిద్దుబాట్లకు మించి చూపించము. విధానాల కనుగుణంగా దీన్ని వాడండి.',
	'checkuser-desc' => 'వాడుకరి ఐపీ అడ్రసు, ఇతర సమాచారాన్ని చూడగలిగే అనుమతులను వాడుకరులకు ఇస్తుంది',
	'checkuser-logcase' => 'లాగ్ అన్వేషణ కోసం ఇంగ్లీషు అన్వేషకం ఇస్తే.., అది కేస్ సెన్సిటివ్.',
	'checkuser' => 'సభ్యుల తనిఖీ',
	'group-checkuser' => 'సభ్యుల తనిఖీదార్లు',
	'group-checkuser-member' => 'సభ్యుల తనిఖీదారు',
	'right-checkuser' => 'వాడుకరి ఐపీ అడ్రసును, ఇతర సమాచారాన్ని చూడు',
	'grouppage-checkuser' => '{{ns:project}}:వాడుకరిని పరిశీలించు',
	'checkuser-reason' => 'కారణం:',
	'checkuser-showlog' => 'లాగ్ చూపించు',
	'checkuser-log' => 'వాడుకరిపరిశీలన లాగ్',
	'checkuser-query' => 'ఇటీవలి మార్పుల్లో చూడండి',
	'checkuser-target' => 'వాడుకరి లేదా ఐపీ',
	'checkuser-users' => 'వాడుకరులను తీసుకురా',
	'checkuser-edits' => 'ఈ ఐపీ అడ్రస్సు నుండి చేసిన మార్పులను చూపించు',
	'checkuser-ips' => 'ఐపీలను తీసుకురా',
	'checkuser-search' => 'వెతుకు',
	'checkuser-period' => 'నిడివి:',
	'checkuser-week-1' => 'గత వారం',
	'checkuser-week-2' => 'గత రెండు వారాలు',
	'checkuser-month' => 'గత 30 రోజులు',
	'checkuser-all' => 'అందరూ',
	'checkuser-empty' => 'లాగ్&zwnj;లో అంశాలేమీ లేవు.',
	'checkuser-nomatch' => 'సామీప్యాలు ఏమీ కనబడలేదు.',
	'checkuser-check' => 'తనిఖీ',
	'checkuser-log-fail' => 'లాగ్&zwnj;లో పద్దుని చేర్చలేకపోయాం',
	'checkuser-nolog' => 'ఏ లాగ్ ఫైలు కనపడలేదు',
	'checkuser-blocked' => 'నిరోధించాం',
	'checkuser-too-many' => 'మరీ ఎక్కువ ఫలితాలొచ్చాయి. CIDR ను మరింత కుదించండి. వాడిన ఐపీలివిగో (గరిష్ఠంగా 5000 -అడ్రసు వారీగా పేర్చి)',
	'checkuser-user-nonexistent' => 'ఆ వాడుకరి ఉనికిలో లేరు.',
	'checkuser-search-form' => '$1 అనేది $2గా ఉన్న లాగ్ పద్దులను కనుగొనండి',
	'checkuser-search-submit' => 'వెతుకు',
	'checkuser-search-initiator' => 'ఆరంభకుడు',
	'checkuser-search-target' => 'లక్ష్యం',
	'checkuser-ipeditcount' => 'వాడుకరులందరి నుండి ~$1',
	'checkuser-log-subpage' => 'లాగ్',
	'checkuser-log-return' => 'CheckUser ముఖ్య ఫారముకు వెళ్ళు',
	'checkuser-log-userips' => '$2 కోసం $1 ఐపీలను తెచ్చింది',
	'checkuser-log-ipedits' => '$2 కోసం $1 దిద్దుబాట్లను తెచ్చింది',
	'checkuser-log-ipusers' => '$2 కోసం $1 వాడుకరులను తెచ్చింది',
	'checkuser-log-ipedits-xff' => 'XFF $2 కోసం $1, దిద్దుబాట్లను తెచ్చింది',
	'checkuser-log-ipusers-xff' => 'XFF $2 కోసం $1, వాడుకరులను తెచ్చింది',
	'checkuser-email-action' => 'వాడుకరి "$1"కి ఈమెయిలు పంపించాం',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'group-checkuser' => 'CheckUser',
	'group-checkuser-member' => 'CheckUser',
	'grouppage-checkuser' => '{{ns:project}}:CheckUser',
	'checkuser-reason' => 'Motivu:',
	'checkuser-log' => 'Lista checkuser',
	'checkuser-target' => "Uza-na'in ka IP",
	'checkuser-users' => "Uza-na'in sira",
	'checkuser-edits' => 'Edita husi IP',
	'checkuser-ips' => 'IP sira',
	'checkuser-search' => 'Buka',
	'checkuser-all' => 'hotu',
	'checkuser-search-submit' => 'Buka',
);

/** Tajik (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg'] = array(
	'right-checkuser-log' => 'Мушоҳидаи гузоришҳои бозрасии корбарӣ',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'checkuser-summary' => 'Ин абзор тағйироти охирро барои ба даст овардани нишонаҳои интернетӣ IP  истифода шуда тавассути як корбар ё таъйини вироишҳои анчом шуда тариқи як нишонаи интернетӣ IP, ҷустуҷӯ мекунад.
Корбарон ва вироишҳои як нишонаи интернетии IP-ро метавон бо таваҷҷӯҳ ба иттилоот сар оянд тариқи XFF бо афзудан нишонаи интернетӣ IP бо "/xff" пайдо кард. Ҳар ду протокол IPv4 (CIDR 16-32) ва IPv6 (CIDR 64-128) тавассути ин абзор пуштибонӣ мешаванд.
На беш аз 5000 вироиш бо далелҳои зудкорӣ баргардонида хоҳанд шуд. Бо мувофиқи сиёсат ва қоидаҳо инро истода кунед.',
	'checkuser-desc' => 'Ба корбарон ихтиёроти лозимиро барои баррасии нишонаҳои интернетӣ IP корбарон ва иттилооти дигар, иҷозат медиҳад',
	'checkuser-logcase' => 'Ҷустуҷӯи гузориш ба хурд ё бузрг будани ҳарфҳо ҳасос аст.',
	'checkuser' => 'Бозрасии корбар',
	'group-checkuser' => 'Бозрасии корбарон',
	'group-checkuser-member' => 'Бозрасии корбар',
	'right-checkuser' => 'Барраси кардани нишонаи IP ва дигар иттилооти корбар',
	'grouppage-checkuser' => '{{ns:project}}:Бозрасии корбар',
	'checkuser-reason' => 'Сабаб:',
	'checkuser-showlog' => 'Намоиши гузориш',
	'checkuser-log' => 'БозрасиКорбар гузориш',
	'checkuser-query' => 'Ҷустуҷӯи тағйироти охир',
	'checkuser-target' => 'Корбар ё нишонаи IP',
	'checkuser-users' => 'Феҳрист кардани корбарон',
	'checkuser-edits' => 'Намоиши вироишҳои марбут ба ин нишонаи IP',
	'checkuser-ips' => 'Феҳрист кардани нишонаҳои IP',
	'checkuser-search' => 'Ҷустуҷӯ',
	'checkuser-period' => 'Тӯл:',
	'checkuser-week-1' => 'ҳафта гузашта',
	'checkuser-week-2' => 'ду ҳафтаи гузашта',
	'checkuser-month' => '30 рӯзи гузашта',
	'checkuser-all' => 'ҳама',
	'checkuser-empty' => 'Гузориш холӣ аст.',
	'checkuser-nomatch' => 'Мавриде ки мутобиқат дошта бошад пайдо нашуд',
	'checkuser-nomatch-edits' => 'Ҳеҷ мутобиқате ёфт нашуд.
Охирин вироиш дар $1 соати $2 буд.',
	'checkuser-check' => 'Барраси',
	'checkuser-log-fail' => 'Имкони афзудани иттилоот ба гузориш вуҷуд надорад',
	'checkuser-nolog' => 'Парвандаи гузориш пайдо нашуд.',
	'checkuser-blocked' => 'Дастрасӣ қатъ шуд',
	'checkuser-gblocked' => 'Басташуда сартосарӣ',
	'checkuser-wasblocked' => 'Қаблан баста шуда',
	'checkuser-localonly' => 'Якка нашуда',
	'checkuser-massblock' => 'Корбарони интихобшуда баста шаванд',
	'checkuser-blocktag' => 'Ҷойгузин кардани саҳифаҳои корбарон бо:',
	'checkuser-blocktag-talk' => 'Ҷойгузин кардани саҳифаҳои баҳс бо:',
	'checkuser-block-limit' => 'Теъдоди беш аз шумораи корбарон интихоб шудаанд.',
	'checkuser-too-many' => 'Теъдоди натоиҷ бисёр зиёд аст. Лутфан CIDRро бориктар кунед. Дар зер нишонаҳои IP-ро мебинед (5000 ҳадди аксар, аз рбатартиби нинона):',
	'checkuser-user-nonexistent' => 'Корбари мавриди назар вуҷуд надорад.',
	'checkuser-search-form' => 'Пайдо кардани маворид дар гузоришҳо, ки $1 дар он $2 аст',
	'checkuser-search-submit' => 'Ҷустуҷӯ',
	'checkuser-search-initiator' => 'оғозгар',
	'checkuser-search-target' => 'ҳадаф',
	'checkuser-log-subpage' => 'Гузориш',
	'checkuser-log-return' => 'Бозгашт ба форми аслии бозрасии корбар',
	'checkuser-log-userips' => '$1 нишонаҳои интернетии IP-ҳои $2ро гирифт',
	'checkuser-log-ipedits' => '$1 вироишҳои $2ро гирифт',
	'checkuser-log-ipusers' => '$1 корбарони марбут ба $2ро гирифт',
	'checkuser-log-ipedits-xff' => '$1 вироишҳои XFF $2ро гирифт',
	'checkuser-log-ipusers-xff' => '$1 корбарони марбут ба XFF $2ро гирифт',
	'checkuser-autocreate-action' => 'ба таври худкор эҷод шуда буд',
	'checkuser-email-action' => 'почтаи электронӣ ба корбар "$1" фиристода шуд',
);

/** Thai (ไทย)
 * @author Octahedron80
 */
$messages['th'] = array(
	'checkuser-search' => 'ค้นหา',
	'checkuser-period' => 'ระยะเวลา:',
	'checkuser-week-1' => 'สัปดาห์ที่แล้ว',
	'checkuser-week-2' => '2 สัปดาห์ที่แล้ว',
	'checkuser-month' => '30 วันที่แล้ว',
	'checkuser-all' => 'ทั้งหมด',
	'checkuser-search-submit' => 'ค้นหา',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'checkuser-summary' => 'Nagmamasid ng kamakailang mga pagbabago ang kasangkapang ito upang makuhang muli ang ginamit na mga IP ng tagagamit o ipakita ang dato ng pagbabago/tagagamit para sa isang IP.
Ang mga tagagamit at mga pagbabagong ginawa ng isang IP ng kliyente ay maaaring kuhaning muli sa pamamagitan ng paggamit ng mga paulong XFF sa pamamagitan ng pagkakabit ng "/xff" sa IP.
Sinusuportahan ang IPv4 (CIDR 16-32) at ang IPv6 (CIDR 64-128).
Walang mas mataas sa 5000 mga pagbabago ang ibabalik dahil sa mga kadahilanang pangpagsasagawa.
Gamitin ito ayon sa patakaran.',
	'checkuser-desc' => 'Nagbibigay sa mga tagagamit ng naaangkop na pahintulot ang kakayahang suriin ang mga adres ng IP ng tagagamit at iba pang kabatiran (impormasyon)',
	'checkuser-logcase' => 'May kaselanan sa pagmamakinilya ng panitik ang paghahanap ng talaan.',
	'checkuser' => 'Suriin ang tagagamit',
	'group-checkuser' => 'Suriin ang mga tagagamit',
	'group-checkuser-member' => 'Suriin ang tagagamit',
	'right-checkuser' => 'Suriin ang adres ng IP at iba pang mga kabatiran (impormasyon) ng tagagamit',
	'right-checkuser-log' => 'Tingnan ang talaan ng pagsuri sa tagagamit',
	'grouppage-checkuser' => '{{ns:project}}:Suriin ang tagagamit',
	'checkuser-reason' => 'Dahilan:',
	'checkuser-showlog' => 'Ipakita ang talaan',
	'checkuser-log' => 'Talaang SuriinTagagamit',
	'checkuser-query' => 'Magtanong hinggil sa kamakailang mga pagbabago',
	'checkuser-target' => 'Tagagamit o IP',
	'checkuser-users' => 'Kunin ang mga tagagamit',
	'checkuser-edits' => 'Kuhanin ang mga pagbabago mula sa IP',
	'checkuser-ips' => 'Kunin ang mga IP',
	'checkuser-account' => 'Kunin ang mga pagbabago sa kuwenta/akawnt',
	'checkuser-search' => 'Maghanap',
	'checkuser-period' => 'Tagal ng panahon:',
	'checkuser-week-1' => 'nakaraang linggo',
	'checkuser-week-2' => 'huling dalawang mga linggo',
	'checkuser-month' => 'huling 30 mga araw',
	'checkuser-all' => 'lahat',
	'checkuser-empty' => 'Walang lamang mga bagay ang talaan.',
	'checkuser-nomatch' => 'Walang natagpuang mga pagtutugma.',
	'checkuser-nomatch-edits' => 'Walang natagpuang mga pagtutugma.
Ang huling pagbabago ay noong $1 sa $2.',
	'checkuser-check' => 'Suriin',
	'checkuser-log-fail' => 'Hindi nagawang idagdag ang ipinasok sa talaan',
	'checkuser-nolog' => 'Walang natagpuang talaksan ng talaan.',
	'checkuser-blocked' => 'Hinadlangan',
	'checkuser-gblocked' => 'Hinadlangan na pandaigdigan',
	'checkuser-locked' => 'Ikinandado',
	'checkuser-wasblocked' => 'Hinadlangan dati',
	'checkuser-localonly' => 'Hindi pinag-isa',
	'checkuser-massblock' => 'Harangin ang napiling mga tagagamit',
	'checkuser-massblock-text' => 'Ang napiling mga kuwenta ay hahadlangan magpasawalang hanggan, na may pinagaganang kusang pagharang at hindi pinaaandar na paglikha ng akawnt.
Hahadlangan ang mga adres ng IP sa loob ng 1 linggo para sa mga tagagamit ng IP lamang at hindi pinagagana ang paglikha ng kuwenta.',
	'checkuser-blocktag' => 'Palitan ang mga pahina ng tagagamit ng:',
	'checkuser-blocktag-talk' => 'Palitan ang mga pahina ng usapan ng:',
	'checkuser-massblock-commit' => 'Hadlangan ang napiling mga tagagamit',
	'checkuser-block-success' => "'''Ang {{PLURAL:$2|tagagamit|mga tagagamit}} na si/sina $1 {{PLURAL:$2|ay|ay mga}} hinadlangan na ngayon.'''",
	'checkuser-block-failure' => "'''Walang nahadlangang mga tagagamit.'''",
	'checkuser-block-limit' => 'Napakaraming napiling mga tagagamit.',
	'checkuser-block-noreason' => 'Dapat kang magbigay ng isang dahilan para sa mga paghahadlang.',
	'checkuser-accounts' => '$1 bagong {{PLURAL:$1|kuwenta|mga kuwenta}}',
	'checkuser-too-many' => 'Napakaraming mga resulta, pakikiputan pababa ang CIDR.
Narito ang ginamit na mga IP (5000 pinakamarami, inayos ayon sa adres):',
	'checkuser-user-nonexistent' => 'Hindi umiiral ang tinukoy na tagagamit.',
	'checkuser-search-form' => 'Maghanap ng mga paglalagay sa talaan kung saan ang $1 ay $2',
	'checkuser-search-submit' => 'Hanapin',
	'checkuser-search-initiator' => 'tagapagsimula',
	'checkuser-search-target' => 'puntirya',
	'checkuser-ipeditcount' => '~$1 mula sa lahat ng mga tagagamit',
	'checkuser-log-subpage' => 'Itala',
	'checkuser-log-return' => 'Bumalik sa pangunahing pormularyong SuriinTagagamit<!--CheckUser-->',
	'checkuser-limited' => "'''Pinutol o pinungusan ang mga resulta dahil sa mga kadahilanang panggawain (pagsasagawa).'''",
	'checkuser-log-userips' => 'Nakakuha si $1 ng mga IP para kay $2',
	'checkuser-log-ipedits' => 'Nakakuha si $1 ng mga pagbabago para kay $2',
	'checkuser-log-ipusers' => 'Nakakuha si $1 ng mga tagagamit para sa $2',
	'checkuser-log-ipedits-xff' => 'Nakakuha si $1 ng mga pagbabago para sa XFF na $2',
	'checkuser-log-ipusers-xff' => 'Nakakuha si $1 ng mga tagagamit para sa XFF na $2',
	'checkuser-log-useredits' => 'Nakakuha si $1 ng mga pagbabago para sa $2',
	'checkuser-autocreate-action' => 'ay kusang nalikha',
	'checkuser-email-action' => 'nagpadala ng isang e-liham patungo kay tagagamit na "$1"',
	'checkuser-reset-action' => 'muling itakda ang hudyat para kay tagagamit na "$1"',
);

/** Tonga (faka-Tonga) */
$messages['to'] = array(
	'checkuser' => 'Siviʻi ʻa e ʻetita',
	'group-checkuser' => 'Siviʻi kau ʻetita',
	'group-checkuser-member' => 'Siviʻi ʻa e ʻetita',
);

/** Turkish (Türkçe)
 * @author Dbl2010
 * @author Erkan Yilmaz
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 */
$messages['tr'] = array(
	'checkuser' => 'IP denetçisi',
	'group-checkuser' => 'Denetçiler',
	'group-checkuser-member' => 'Denetçi',
	'grouppage-checkuser' => '{{ns:project}}:Denetçi',
	'checkuser-reason' => 'Gerekçe:',
	'checkuser-showlog' => 'Logu göster',
	'checkuser-log' => 'Denetçi kaydı',
	'checkuser-target' => 'Kullanıcı veya IP',
	'checkuser-users' => 'Kullanıcıları bulup getir',
	'checkuser-ips' => 'IPleri bulup getir',
	'checkuser-search' => 'Ara',
	'checkuser-week-1' => 'son hafta',
	'checkuser-week-2' => 'son iki hafta',
	'checkuser-month' => 'son 30 gün',
	'checkuser-all' => 'hepsi',
	'checkuser-check' => 'Kontrol et',
	'checkuser-blocked' => 'Engellendi',
	'checkuser-search-submit' => 'Ara',
	'checkuser-search-initiator' => 'Başlatan',
	'checkuser-search-target' => 'Hedef',
	'checkuser-log-subpage' => 'Kayıt',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'checkuser-summary' => 'Цей засіб переглядає нові редагування для отримання IP-адрес, які використовував певний користувач, або щоб знайти редагування/користувача за IP-адресою.
Редагування і користувачів, що редагували з певної IP-адреси, заначеної в X-Forwarded-For, можна отримати, додавши префікс <code>/xff</code> до IP-адреси. Підтримувані версії IP: 4 (CIDR 16—32) і 6 (CIDR 64—128).
З огляду на продуктивність буде показано не більше 5000 редагувань.
Використовуйте цей засіб тільки відповідно до правил.',
	'checkuser-desc' => 'Надання можливості перевіряти IP-адреси та іншу інформацію користувачів',
	'checkuser-logcase' => 'Пошук у журналі чутливий до регістру.',
	'checkuser' => 'Перевірити користувача',
	'group-checkuser' => "Чек'юзери",
	'group-checkuser-member' => "чек'юзер",
	'right-checkuser' => 'Перевірка IP-адрес та іншої інформації користувача',
	'right-checkuser-log' => 'Перегляд журналу перевірки користувачів',
	'grouppage-checkuser' => '{{ns:project}}:Перевірка користувачів',
	'checkuser-reason' => 'Причина:',
	'checkuser-showlog' => 'Показати журнал',
	'checkuser-log' => 'Журнал перевірки користувачів',
	'checkuser-query' => 'Запитати останні зміни',
	'checkuser-target' => 'Користувач або IP-адреса',
	'checkuser-users' => 'Отримати користувачів',
	'checkuser-edits' => 'Запитати редагування, зроблені з IP-адреси',
	'checkuser-ips' => 'Запитати IP-адреси',
	'checkuser-account' => 'Отримати редагування з облікового запису',
	'checkuser-search' => 'Знайти',
	'checkuser-period' => 'Тривалість:',
	'checkuser-week-1' => 'останній тиждень',
	'checkuser-week-2' => 'останні два тижні',
	'checkuser-month' => 'останні 30 днів',
	'checkuser-all' => 'усі',
	'checkuser-empty' => 'Журнал порожній.',
	'checkuser-nomatch' => 'Не знайдено співпадінь.',
	'checkuser-nomatch-edits' => 'Збіги не знайдені.
Останнє редагування зроблене $1 о $2.',
	'checkuser-check' => 'Перевірити',
	'checkuser-log-fail' => 'Не в змозі додати запис до журналу',
	'checkuser-nolog' => 'Файл журналу не знайдений.',
	'checkuser-blocked' => 'Заблокований',
	'checkuser-gblocked' => 'Заблокований глобально',
	'checkuser-locked' => 'Закритий',
	'checkuser-wasblocked' => 'Раніше заблокований',
	'checkuser-localonly' => "Не об'єднана",
	'checkuser-massblock' => 'Заблокувати вибраних користувачів',
	'checkuser-massblock-text' => 'Вибрані облікові записи будуть заблоковані безстроково з автоблокуванням і забороною створення нових облікових записів.
IP-адреси користувачів, які не увійшли до системи будуть заблоковані на 1 тиждень із забороною створення нових облікових записів.',
	'checkuser-blocktag' => 'Замінити сторінки користувачів на:',
	'checkuser-blocktag-talk' => 'Замінити сторінки обговорення на:',
	'checkuser-massblock-commit' => 'Заблокувати вибраних користувачів',
	'checkuser-block-success' => "'''Зараз {{PLURAL:$2|заблокований $1 користувач|заблоковані $1 користувачі|заблоковані $1 користувачів}}.'''",
	'checkuser-block-failure' => "'''Немає заблокованих користувачів.'''",
	'checkuser-block-limit' => 'Вибрано забагато користувачів.',
	'checkuser-block-noreason' => 'Ви повинні вказати причину блокувань.',
	'checkuser-accounts' => '$1 {{PLURAL:$1|новий обліковий запис|нові облікові записи|нових облікових записів}}',
	'checkuser-too-many' => 'Забагато результатів. Будь ласка, звузьте CIDR.
Використані IP (максимум 5000, відсортовано за адресою):',
	'checkuser-user-nonexistent' => 'Зазначений користувач не існує.',
	'checkuser-search-form' => 'Знайти записи журналу, де $1 є $2',
	'checkuser-search-submit' => 'Знайти',
	'checkuser-search-initiator' => 'ініціатор',
	'checkuser-search-target' => 'ціль',
	'checkuser-ipeditcount' => '~$1 від усіх користувачів',
	'checkuser-log-subpage' => 'Журнал',
	'checkuser-log-return' => 'Повернення до головної форми перевірки користувачів',
	'checkuser-limited' => "'''Результати урізано, щоб не обтяжувати сервер.'''",
	'checkuser-log-userips' => '$1 отримав IP-адреси для $2',
	'checkuser-log-ipedits' => '$1 отримав редагування для $2',
	'checkuser-log-ipusers' => '$1 отримав облікові записи для $2',
	'checkuser-log-ipedits-xff' => '$1 отримав редагування для XFF $2',
	'checkuser-log-ipusers-xff' => '$1 отримав облікові записи для XFF $2',
	'checkuser-log-useredits' => '$1 отримав редагування $2',
	'checkuser-autocreate-action' => 'створений автоматично',
	'checkuser-email-action' => 'надіслав листа користувачеві «$1»',
	'checkuser-reset-action' => 'скинув пароль для користувача $1',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'checkuser-summary' => 'Sto strumento qua l\'analiza le modifiche reçenti par recuperar i indirizi IP doparà da un utente o mostrar contributi e dati de un IP. Utenti e contributi de un client IP i se pol rintraciar atraverso i header XFF, zontàndoghe a l\'IP el suffisso "/xff". Xe suportà IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). No sarà restituìe piassè de 5.000 modifiche, par ragioni de prestazioni. Dòpara sto strumento in streta conformità a le policy.',
	'checkuser-desc' => 'Consente ai utenti co le oportune autorizazion de sotopor a verifica i indirizi IP e altre informazion relative ai utenti',
	'checkuser-logcase' => "La riçerca nei registri la xe ''case sensitive'' (cioè la distingue fra majuscole e minuscole).",
	'checkuser' => 'Controlo utenze',
	'group-checkuser' => 'Controlori',
	'group-checkuser-member' => 'Controlor',
	'right-checkuser' => "Controla i indirissi IP de l'utente e altre informassion",
	'right-checkuser-log' => 'Varda el registro del controlo utenti (checkuser)',
	'grouppage-checkuser' => '{{ns:project}}:Controlo utenze',
	'checkuser-reason' => 'Motivo:',
	'checkuser-showlog' => 'Mostra el registro',
	'checkuser-log' => 'Registro dei checkuser',
	'checkuser-query' => 'Çerca ne le ultime modifiche',
	'checkuser-target' => 'Utente o IP',
	'checkuser-users' => 'Çerca utenti',
	'checkuser-edits' => 'Varda i contributi dei IP',
	'checkuser-ips' => 'Çerca IP',
	'checkuser-account' => "Varda i contributi de l'utenza",
	'checkuser-search' => 'Çerca',
	'checkuser-period' => 'Par quanto:',
	'checkuser-week-1' => 'ultima stimana',
	'checkuser-week-2' => 'ultime do stimane',
	'checkuser-month' => 'ultimi 30 zorni',
	'checkuser-all' => 'tuti quanti',
	'checkuser-empty' => "El registro no'l contien dati.",
	'checkuser-nomatch' => 'Nissun risultato catà.',
	'checkuser-nomatch-edits' => "No xe stà catà nissun risultato.
L'ultima modìfega la xe stà a le ore $2 del $1.",
	'checkuser-check' => 'Controla',
	'checkuser-log-fail' => 'Inpossibile zontar la voçe al registro',
	'checkuser-nolog' => 'No xe stà catà nissun file de registro.',
	'checkuser-blocked' => 'Blocà',
	'checkuser-gblocked' => 'Blocà globalmente',
	'checkuser-locked' => 'Blocà',
	'checkuser-wasblocked' => 'Blocà zà in precedensa',
	'checkuser-localonly' => 'Mia unifegà',
	'checkuser-massblock' => 'Bloca i utenti selessionà',
	'checkuser-massblock-text' => "Le utense selezionà le vegnarà blocà par senpre, col bloco automatico inpizà e la creazion de utense nove disativà.
I indirissi IP i vegnarà blocà par na stimana solo par i utenti anonimi e co' la creazion de utense disativà.",
	'checkuser-blocktag' => 'Sostituìssi le pagine utente con:',
	'checkuser-blocktag-talk' => 'Rinpiazza le pàxene de discussion con:',
	'checkuser-massblock-commit' => 'Bloca i utenti selessionà',
	'checkuser-block-success' => "'''{{PLURAL:$2|L'utente|I utenti}} $1 {{PLURAL:$2|el|i}} xe stà blocà.'''",
	'checkuser-block-failure' => "'''Nissun utente blocà.'''",
	'checkuser-block-limit' => 'Ti gà selessionà massa utenti.',
	'checkuser-block-noreason' => 'Ti gà da dar na motivassion par i blochi.',
	'checkuser-accounts' => '$1 account {{PLURAL:$1|novo|novi}}',
	'checkuser-too-many' => 'Xe vegnù fora massa risultati, par piaser dòpara un CIDR piassè ristreto.
Sti qua i xe i IP doparà (fin a un massimo de 5000, ordinà par indirizo):',
	'checkuser-user-nonexistent' => "L'utente indicà no l'esiste mìa.",
	'checkuser-search-form' => 'Cata fora le voçi del registro par le quali $1 el xe $2',
	'checkuser-search-submit' => 'Riçerca',
	'checkuser-search-initiator' => 'iniziator',
	'checkuser-search-target' => 'obietivo',
	'checkuser-ipeditcount' => '~$1 par tuti i utenti',
	'checkuser-log-subpage' => 'Registro',
	'checkuser-log-return' => 'Torna al modulo prinçipal de Controlo utenze',
	'checkuser-limited' => "'''Sti risultati i xe stà tajà a metà par motivi de prestazion.'''",
	'checkuser-log-userips' => '$1 el gà otegnù i indirizi IP de $2',
	'checkuser-log-ipedits' => '$1 el gà otegnù le modifiche de $2',
	'checkuser-log-ipusers' => '$1 el gà otegnù le utenze de $2',
	'checkuser-log-ipedits-xff' => '$1 el gà otegnù le modifiche de $2 via XFF',
	'checkuser-log-ipusers-xff' => '$1 el gà otegnù le utenze de $2 via XFF',
	'checkuser-log-useredits' => '$1 gà otegnù i contributi de $2',
	'checkuser-autocreate-action' => 'xe stà creà automaticamente',
	'checkuser-email-action' => 'gà mandà na e-mail a "$1"',
	'checkuser-reset-action' => 'reinposta la password par l\'utente "$1"',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'checkuser-summary' => 'Công cụ này sẽ quét các thay đổi gần đây để lấy ra các IP được một thành viên sử dụng hoặc hiển thị dữ liệu sửa đổi/tài khoản của một IP. Các tài khoản và sửa đổi của một IP có thể được trích ra từ tiêu đề XFF bằng cách thêm vào IP “/xff”. IPv4 (CIDR 16-32) và IPv6 (CIDR 64-128) đều được hỗ trợ. Không quá 5000 sửa đổi sẽ được trả về vì lý do hiệu suất. Hãy dùng công cụ này theo đúng quy định.',
	'checkuser-desc' => 'Cung cấp cho những người đủ tiêu chuẩn khả năng kiểm tra địa chỉ IP và thông tin khác của người dùng khác',
	'checkuser-logcase' => 'Tìm kiếm nhật trình có phân biệt chữ hoa chữ thường',
	'checkuser' => 'Kiểm định viên',
	'group-checkuser' => 'Kiểm định viên',
	'group-checkuser-member' => 'Kiểm định viên',
	'right-checkuser' => 'Kiểm tra địa chỉ IP và các thông tin khác của thành viên',
	'right-checkuser-log' => 'Xem nhật trình CheckUser',
	'grouppage-checkuser' => '{{ns:project}}:Kiểm định viên',
	'checkuser-reason' => 'Lý do:',
	'checkuser-showlog' => 'Xem nhật trình',
	'checkuser-log' => 'Nhật trình CheckUser',
	'checkuser-query' => 'Truy vấn các thay đổi gần đây',
	'checkuser-target' => 'Thành viên hay IP',
	'checkuser-users' => 'Lấy ra thành viên',
	'checkuser-edits' => 'Lấy ra sửa đổi của IP',
	'checkuser-ips' => 'Lấy ra IP',
	'checkuser-account' => 'Xem các sửa đổi dùng tài khoản này',
	'checkuser-search' => 'Tìm kiếm',
	'checkuser-period' => 'Thời gian:',
	'checkuser-week-1' => 'tuần trước',
	'checkuser-week-2' => 'hai tuần trước',
	'checkuser-month' => '30 ngày trước',
	'checkuser-all' => 'tất cả',
	'checkuser-empty' => 'Nhật trình hiện chưa có gì.',
	'checkuser-nomatch' => 'Không tìm thấy kết quả.',
	'checkuser-nomatch-edits' => 'Không tìm thấy kết quả.
Lần sửa đổi cuối xảy ra $1 lúc $2.',
	'checkuser-check' => 'Kiểm tra',
	'checkuser-log-fail' => 'Không thể ghi vào nhật trình',
	'checkuser-nolog' => 'Không tìm thấy tập tin nhật trình',
	'checkuser-blocked' => 'Đã cấm',
	'checkuser-gblocked' => 'Cấm toàn cầu',
	'checkuser-locked' => 'Khóa',
	'checkuser-wasblocked' => 'Đã từng bị cấm',
	'checkuser-localonly' => 'Chưa thống nhất',
	'checkuser-massblock' => 'Cấm các người dùng được chọn',
	'checkuser-massblock-text' => 'Các tài khoản được chọn sẽ bị cấm vô hạn, cũng cấm mở tài khoản và tự động cấm các địa chỉ IP. Những người dùng những địa chỉ IP này sẽ bị cấm một tuần và không được mở tài khoản.',
	'checkuser-blocktag' => 'Thay thế các trang cá nhân bằng:',
	'checkuser-blocktag-talk' => 'Thay các trang thảo luận bằng:',
	'checkuser-massblock-commit' => 'Cấm những người dùng được chọn',
	'checkuser-block-success' => "'''{{PLURAL:$2|Người|Các người}} dùng $1 mới bị cấm.'''",
	'checkuser-block-failure' => "'''Không ai bị cấm.'''",
	'checkuser-block-limit' => 'Đã chọn nhiều người dùng quá.',
	'checkuser-block-noreason' => 'Phải đưa ra lý do cấm.',
	'checkuser-accounts' => '$1 tài khoản mới',
	'checkuser-too-many' => 'Có quá nhiều kết quả, xin hãy thu hẹp CIDR. Đây là các IP sử dụng (tối đa 5000, xếp theo địa chỉ):',
	'checkuser-user-nonexistent' => 'Thành viên chỉ định không tồn tại.',
	'checkuser-search-form' => 'Tìm thấy các mục nhật trình trong đó $1 là $2',
	'checkuser-search-submit' => 'Tìm kiếm',
	'checkuser-search-initiator' => 'người khởi đầu',
	'checkuser-search-target' => 'mục tiêu',
	'checkuser-ipeditcount' => '~$1 khỏi tất cả các thành viên',
	'checkuser-log-subpage' => 'Nhật trình',
	'checkuser-log-return' => 'Quay lại mẫu CheckUser chính',
	'checkuser-limited' => "'''Bỏ qua ba kết quả cuối cùng để thực hiện nhanh hơn.'''",
	'checkuser-log-userips' => '$1 lấy IP để $2',
	'checkuser-log-ipedits' => '$1 lấy sửa đổi cho $2',
	'checkuser-log-ipusers' => '$1 lấy thành viên cho $2',
	'checkuser-log-ipedits-xff' => '$1 lấy sửa đổi cho XFF $2',
	'checkuser-log-ipusers-xff' => '$1 lấy thành viên cho XFF $2',
	'checkuser-log-useredits' => '$1 xem các sửa đổi của $2',
	'checkuser-autocreate-action' => 'được tạo ra tự động',
	'checkuser-email-action' => 'gửi thư điện tử cho người dùng “$1”',
	'checkuser-reset-action' => 'mặc định lại mật khẩu của người dùng “$1”',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'checkuser-summary' => 'Stum at vestigon votükamis brefabüik ad dagetön ladetis-IP fa geban semik pagebölis, ud ad jonön redakama- u gebananünis tefü ladet-IP semik.
Gebans e redakams se dona-IP kanons pagetön de tiäds: XFF medä läükoy eli „/xff“ ladete-IP. Els IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128) kanons pagebön.
Redakams no plu 5000 pejonons sekü kods kaenavik. Gebolös stumi at bai nomem.',
	'checkuser-desc' => 'Gevon gebanes labü däl zesüdik fägi ad vestigön ladeti(s)-IP gebana äsi nünis votik',
	'checkuser-logcase' => 'Pö suk in registar mayuds e minuds padifükons.',
	'checkuser' => 'Vestigön gebani',
	'group-checkuser' => 'Vestigön gebanis',
	'group-checkuser-member' => 'Vestigön gebani',
	'right-checkuser' => 'Kontrolön ladetis-IP e nünis votik tefü geban',
	'right-checkuser-log' => 'Logön jenotalised gebanikontrolama',
	'grouppage-checkuser' => '{{ns:project}}:Vestigön gebani',
	'checkuser-reason' => 'Kod:',
	'checkuser-showlog' => 'Jonön jenotalisedi',
	'checkuser-log' => 'Vestigön gebani: jenotalised',
	'checkuser-query' => 'Vestigön votükamis brefabüik',
	'checkuser-target' => 'Geban u ladet-IP',
	'checkuser-users' => 'Tuvön gebanis',
	'checkuser-edits' => 'Tuvön redakamis ladeta-IP',
	'checkuser-ips' => 'Tuvön ladetis-IP',
	'checkuser-account' => 'Tuvön kaliredakamis',
	'checkuser-search' => 'Sukolöd',
	'checkuser-period' => 'Dul:',
	'checkuser-week-1' => 'vig lätik',
	'checkuser-week-2' => 'vigs lätik tel',
	'checkuser-month' => 'dels lätik 30',
	'checkuser-all' => 'valiks',
	'checkuser-empty' => 'Lised vagon.',
	'checkuser-nomatch' => 'Suk no eplöpon.',
	'checkuser-check' => 'Vestigön',
	'checkuser-log-fail' => 'No eplöpos ad laükön jenotalisede',
	'checkuser-nolog' => 'Ragiv jenotaliseda no petuvon.',
	'checkuser-blocked' => 'Peblokon',
	'checkuser-locked' => 'Pelökofärmükon',
	'checkuser-wasblocked' => 'Büo päbloköl',
	'checkuser-localonly' => 'No pebalöl',
	'checkuser-massblock' => 'Blokön gebanis pevälöl',
	'checkuser-blocktag' => 'Plaädön gebanapadis me:',
	'checkuser-blocktag-talk' => 'Plaädön bespikapadis me:',
	'checkuser-massblock-commit' => 'Blokön gebanis pevälöl',
	'checkuser-block-success' => "'''{{PLURAL:$2|Geban|Gebans}}: $1 {{PLURAL:$2|peblokon|peblokons}}.'''",
	'checkuser-block-failure' => "'''Gebans nonik peblokons.'''",
	'checkuser-block-limit' => 'Gebans tumödik pevälons.',
	'checkuser-block-noreason' => 'Mutol nunön kodi blokamas.',
	'checkuser-accounts' => '{{PLURAL:$1|kal|kals}} nulik $1',
	'checkuser-too-many' => 'Sukaseks te mödiks, nedol gebön eli CIDR smalikum. Is palisedons ladets-IP pegeböl (jü 5000, peleodüköls ma ladet):',
	'checkuser-user-nonexistent' => 'Geban at no dabinon.',
	'checkuser-search-form' => 'Tuvön lienis jenotaliseda, kö $1 binon $2',
	'checkuser-search-submit' => 'Suk',
	'checkuser-search-initiator' => 'flagan',
	'checkuser-search-target' => 'zeil',
	'checkuser-log-subpage' => 'Jenotalised',
	'checkuser-log-return' => 'Geikön lü cifafomet',
	'checkuser-log-userips' => '$1 labon ladetis-IP ela $2',
	'checkuser-log-ipedits' => '$1 labon redakamis ela $2',
	'checkuser-log-ipusers' => '$1 labon gebanis ela $2',
	'checkuser-log-ipedits-xff' => '$1 labon redakamis ela XFF $2',
	'checkuser-log-ipusers-xff' => '$1 labon gebanis ela XFF $2',
	'checkuser-log-useredits' => '$1 labon redakamis pro $2',
	'checkuser-autocreate-action' => 'pejafon itjäfidiko',
	'checkuser-email-action' => 'äsedon penedi leäktronik gebane: „$1“',
	'checkuser-reset-action' => 'votükön letavödi gebana: „$1“',
);

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'checkuser' => "Verifyî l' uzeu",
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'checkuser-target' => 'באניצער אדער IP אדרעס',
	'checkuser-search' => 'זוכן',
	'checkuser-month' => 'פֿאריגע 30 טעג',
	'checkuser-all' => 'אלע',
	'checkuser-search-submit' => 'זוכן',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'checkuser-summary' => '呢個工具會響最近更改度掃瞄對一位用戶用過嘅IP地址，或者係睇一個IP嘅用戶資料同埋佢嘅編輯記錄。
	響用戶同埋用戶端IP嘅編輯係可幾經由XFF頭，加上 "/xff" 就可以拎到。呢個工具係支援 IPv4 (CIDR 16-32) 同埋 IPv6 (CIDR 64-128)。
	由於為咗效能方面嘅原因，將唔會顯示多過5000次嘅編輯。請跟源政策去用呢個工具。',
	'checkuser-desc' => '畀合適去查用戶IP或其它嘢嘅能力畀用戶',
	'checkuser-logcase' => '搵呢個日誌係有分大細楷嘅。',
	'checkuser' => '核對用戶',
	'group-checkuser' => '稽查員',
	'group-checkuser-member' => '稽查員',
	'right-checkuser' => '核對用戶嘅IP地址同埋其它嘅資料',
	'grouppage-checkuser' => '{{ns:project}}:稽查員',
	'checkuser-reason' => '原因',
	'checkuser-showlog' => '顯示日誌',
	'checkuser-log' => '核對用戶日誌',
	'checkuser-query' => '查詢最近更改',
	'checkuser-target' => '用戶名或IP',
	'checkuser-users' => '拎用戶',
	'checkuser-edits' => '拎IP嘅編輯',
	'checkuser-ips' => '拎IP',
	'checkuser-search' => '搵',
	'checkuser-empty' => '呢個日誌無任何嘅項目。',
	'checkuser-nomatch' => '搵唔到符合嘅資訊。',
	'checkuser-check' => '查',
	'checkuser-log-fail' => '唔能夠加入日誌項目',
	'checkuser-nolog' => '搵唔到日誌檔。',
	'checkuser-blocked' => '已經封鎖',
	'checkuser-too-many' => '太多結果，請收窄個CIDR。
呢度係個用過嘅IP (最多5000個，按地址排):',
	'checkuser-user-nonexistent' => '指定嘅用戶唔存在。',
	'checkuser-search-form' => '搵當 $1 係 $2 嗰陣時嘅日誌',
	'checkuser-search-submit' => '搵',
	'checkuser-search-initiator' => '創始者',
	'checkuser-search-target' => '目標',
	'checkuser-ipeditcount' => '~響全部用戶度搵$1',
	'checkuser-log-subpage' => '日誌',
	'checkuser-log-return' => '返去核對用戶主要表格',
	'checkuser-log-userips' => '$1 拎到 $2 嘅 IP',
	'checkuser-log-ipedits' => '$1 拎到 $2 嘅編輯',
	'checkuser-log-ipusers' => '$1 拎到 $2 嘅用戶',
	'checkuser-log-ipedits-xff' => '$1 拎到 XFF $2 嘅編輯',
	'checkuser-log-ipusers-xff' => '$1 拎到 XFF $2 嘅用戶',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'checkuser-summary' => '本工具会从{{int:recentchanges}}中查询使用者使用过的IP位址，或是一个IP位址发送出来的任何编辑记录。本工具支持IPv4及IPv6的位址。由于技术上的限制，本工具只能查询最近5000笔的记录。请确定你的行为符合守则。',
	'checkuser-desc' => '让授权的用户检查用户的IP位址及其他资讯',
	'checkuser-logcase' => '搜寻时请注意大小写的区分',
	'checkuser' => '核对用户',
	'group-checkuser' => '账户核查',
	'group-checkuser-member' => '账户核查',
	'right-checkuser' => '查核用户的IP地址以及其它的资料',
	'grouppage-checkuser' => '{{ns:project}}:账户核查',
	'checkuser-reason' => '理由',
	'checkuser-showlog' => '显示日志',
	'checkuser-log' => '用户查核日志',
	'checkuser-query' => '查询最近更改',
	'checkuser-target' => '用户名称或IP位扯',
	'checkuser-users' => '查询用户名称',
	'checkuser-edits' => '从IP位址查询编辑日志',
	'checkuser-ips' => '查询IP位址',
	'checkuser-search' => '搜寻',
	'checkuser-empty' => '日志里没有资料。',
	'checkuser-nomatch' => '没有符合的资讯',
	'checkuser-check' => '查询',
	'checkuser-log-fail' => '无法更新日志。',
	'checkuser-nolog' => '找不到记录档',
	'checkuser-blocked' => '已经查封',
	'checkuser-locked' => '已锁定',
	'checkuser-too-many' => '太多结果，请收窄CIDR。
这是使用过?IP (最多5000个，按地址排列):',
	'checkuser-user-nonexistent' => '指定的使用者不存在。',
	'checkuser-search-form' => '搜寻当 $1 是 $2 时之日志',
	'checkuser-search-submit' => '搜寻',
	'checkuser-search-initiator' => '创始者',
	'checkuser-search-target' => '目标',
	'checkuser-ipeditcount' => '~在全部用户中$1',
	'checkuser-log-subpage' => '日志',
	'checkuser-log-return' => '回到查核主表单',
	'checkuser-log-userips' => '$1取得$2的IP信息',
	'checkuser-log-ipedits' => '$1取得$2的编辑记录',
	'checkuser-log-ipusers' => '$1取得$2的用户信息',
	'checkuser-log-ipedits-xff' => '$1取得 XFF $2的编辑记录',
	'checkuser-log-ipusers-xff' => '$1取得 XFF $2的用户信息',
	'checkuser-autocreate-action' => '已经自动建立',
	'checkuser-email-action' => '向用户“$1”发送电邮',
	'checkuser-reset-action' => '为用户“$1”重新设置密码',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'checkuser-summary' => '本工具會從{{int:recentchanges}}中查詢使用者使用過的IP位址，或是一個IP位址發送出來的任何編輯記錄。本工具支援IPv4及IPv6的位址。由於技術上的限制，本工具只能查詢最近5000筆的記錄。請確定您的行為符合守則。',
	'checkuser-desc' => '讓授權的使用者檢查使用者的IP位址及其他資訊',
	'checkuser-logcase' => '搜尋時請注意大小寫的區分',
	'checkuser' => '核對用戶',
	'group-checkuser' => '用戶查核',
	'group-checkuser-member' => '用戶查核',
	'right-checkuser' => '查核用戶的IP地址以及其它的資料',
	'grouppage-checkuser' => '{{ns:project}}:用戶查核',
	'checkuser-reason' => '理由',
	'checkuser-showlog' => '顯示記錄',
	'checkuser-log' => '用戶查核記錄',
	'checkuser-query' => '查詢最近更改',
	'checkuser-target' => '用戶名稱或IP位扯',
	'checkuser-users' => '查詢用戶名稱',
	'checkuser-edits' => '從IP位址查詢編輯記錄',
	'checkuser-ips' => '查詢IP位址',
	'checkuser-search' => '搜尋',
	'checkuser-empty' => '記錄裡沒有資料。',
	'checkuser-nomatch' => '沒有符合的資訊',
	'checkuser-check' => '查詢',
	'checkuser-log-fail' => '無法更新記錄。',
	'checkuser-nolog' => '找不到記錄檔',
	'checkuser-blocked' => '已經查封',
	'checkuser-locked' => '已鎖定',
	'checkuser-too-many' => '太多結果，請收窄CIDR。
這是使用過嘅IP (最多5000個，按地址排列):',
	'checkuser-user-nonexistent' => '指定的使用者不存在。',
	'checkuser-search-form' => '搜尋當 $1 是 $2 時之日誌',
	'checkuser-search-submit' => '{{int:Search}}',
	'checkuser-search-initiator' => '創始者',
	'checkuser-search-target' => '目標',
	'checkuser-ipeditcount' => '~在全部用戶中$1',
	'checkuser-log-subpage' => '日誌',
	'checkuser-log-return' => '回到主表單',
	'checkuser-log-userips' => '$1取得$2的IP訊息',
	'checkuser-log-ipedits' => '$1取得$2的編輯記錄',
	'checkuser-log-ipusers' => '$1取得$2的用戶訊息',
	'checkuser-log-ipedits-xff' => '$1取得 XFF $2的編輯記錄',
	'checkuser-log-ipusers-xff' => '$1取得 XFF $2的用戶訊息',
	'checkuser-autocreate-action' => '經已自動建立',
	'checkuser-email-action' => '向使用者「$1」發送電郵',
	'checkuser-reset-action' => '為使用者「$1」重設密碼',
);

