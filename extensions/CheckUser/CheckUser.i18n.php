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
	'grouppage-checkuser'        => '{{ns:project}}:Check user',
	'checkuser-reason'           => 'Reason',
	'checkuser-showlog'          => 'Show log',
	'checkuser-log'              => 'CheckUser log',
	'checkuser-query'            => 'Query recent changes',
	'checkuser-target'           => 'User or IP',
	'checkuser-users'            => 'Get users',
	'checkuser-edits'            => 'Get edits from IP',
	'checkuser-ips'              => 'Get IPs',
	'checkuser-search'           => 'Search',
	'checkuser-empty'            => 'The log contains no items.',
	'checkuser-nomatch'          => 'No matches found.',
	'checkuser-check'            => 'Check',
	'checkuser-log-fail'         => 'Unable to add log entry',
	'checkuser-nolog'            => 'No log file found.',
	'checkuser-blocked'          => 'Blocked',
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

	'checkuser-log-userips'      => '$1 got IPs for $2',
	'checkuser-log-ipedits'      => '$1 got edits for $2',
	'checkuser-log-ipusers'      => '$1 got users for $2',
	'checkuser-log-ipedits-xff'  => '$1 got edits for XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 got users for XFF $2',
);

/** Karelian (Karjala)
 * @author Flrn
 */
$messages['krl'] = array(
	'checkuser-search'        => 'Ečindy',
	'checkuser-search-submit' => 'Ečči',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'checkuser-search'        => 'Кычал',
	'checkuser-search-submit' => 'Кычал',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'checkuser-reason'        => 'Kakano',
	'checkuser-search'        => 'Kumi',
	'checkuser-search-submit' => 'Kumi',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author SPQRobin
 * @author Naudefj
 */
$messages['af'] = array(
	'checkuser'               => 'Kontroleer gebruiker',
	'group-checkuser'         => 'Kontroleer gebruikers',
	'group-checkuser-member'  => 'Kontroleer gebruiker',
	'checkuser-reason'        => 'Rede',
	'checkuser-showlog'       => 'Wys logboek',
	'checkuser-target'        => 'Gebruiker of IP',
	'checkuser-users'         => 'Kry gebruikers',
	'checkuser-edits'         => 'Kry wysigings vanaf IP',
	'checkuser-ips'           => 'Kry IPs',
	'checkuser-search'        => 'Soek',
	'checkuser-empty'         => 'Die logboek het geen inskrywings nie.',
	'checkuser-nomatch'       => 'Geen resultate gevind.',
	'checkuser-check'         => 'Kontroleer',
	'checkuser-nolog'         => 'Logboek lêer nie gevind.',
	'checkuser-blocked'       => 'Versper',
	'checkuser-search-submit' => 'Soek',
	'checkuser-search-target' => 'teiken',
	'checkuser-log-subpage'   => 'Logboek',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'checkuser-summary'          => "Ista aina repasa os zaguers cambeos ta mirar as IPs usatas por un usuario u amostrar as edizions y datos d'usuario ta una adreza IP. Os usuarios y edizions feitos por un cliente IP pueden trobar-se por meyo de cabezeras XFF adibindo a IP con \"/xff\". Se da soporte á IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128).
No s'otendrán más de 5000 edizions por razons de prestazions. Faiga serbir ista aina d'alcuerdo con as politicas d'o procheuto.",
	'checkuser-desc'             => "Conzede á os usuarios con o premiso adecuau a capazidat ta comprebar as adrezas IP d'os usuarios y atras informazions",
	'checkuser-logcase'          => 'En mirar os rechistros se fa destinzión entre mayusclas y minusclas.',
	'checkuser'                  => "Comprebazión d'usuarios",
	'group-checkuser'            => "Comprebadors d'usuarios",
	'group-checkuser-member'     => "Comprebador d'usuarios",
	'right-checkuser'            => "Comprebar as adrezas IP de l'usuario y atras informazions",
	'grouppage-checkuser'        => "{{ns:project}}:comprebazión d'usuarios",
	'checkuser-reason'           => 'Razón',
	'checkuser-showlog'          => 'Amostrar o rechistro',
	'checkuser-log'              => "Rechistro de CheckUser (comprebazión d'usuarios)",
	'checkuser-query'            => 'Mirar en os zaguers cambeos',
	'checkuser-target'           => 'Usuario u adreza IP',
	'checkuser-users'            => "Otener os nombres d'usuario",
	'checkuser-edits'            => 'Otener as edizions dende una adreza IP',
	'checkuser-ips'              => 'Otener as adrezas IP',
	'checkuser-search'           => 'Mirar',
	'checkuser-empty'            => 'No bi ha garra elemento en o rechistro.',
	'checkuser-nomatch'          => "No s'ha trobato garra concordanzia",
	'checkuser-check'            => 'Comprebar',
	'checkuser-log-fail'         => "No s'ha puesto adibir ista dentrada ta o rechistro",
	'checkuser-nolog'            => "No s'ha trobato garra archibo de rechistro.",
	'checkuser-blocked'          => 'Bloqueyato',
	'checkuser-too-many'         => 'Bi ha masiaus resultaus. Por fabor, faiga más estreito o CIDR. Aquí bi son as adrezas IP emplegatas (masimo 5000, ordenatas por  adreza):',
	'checkuser-user-nonexistent' => 'O usuario espezificato no esiste.',
	'checkuser-search-form'      => "Trobar dentradas d'o rechistro an que o $1 sía $2",
	'checkuser-search-submit'    => 'Mirar',
	'checkuser-search-initiator' => "o enzetador d'a consulta",
	'checkuser-search-target'    => 'obchetibo',
	'checkuser-ipeditcount'      => '~$1 de toz os usuarios',
	'checkuser-log-subpage'      => 'Rechistro',
	'checkuser-log-return'       => "Tornar ta o formulario prenzipal de CheckUser (Comprebazión d'usuarios)",
	'checkuser-log-userips'      => '$1 ha consultato as adrezas IP de $2',
	'checkuser-log-ipedits'      => '$1 ha consultato as edizions de $2',
	'checkuser-log-ipusers'      => "$1 ha consultato os nombres d'usuario de $2",
	'checkuser-log-ipedits-xff'  => "$1 ha consultato as edizions d'o XFF $2",
	'checkuser-log-ipusers-xff'  => "$1 ha consultato os nombres d'usuario d'o XFF $2",
);

/** Old English (Anglo-Saxon)
 * @author SPQRobin
 */
$messages['ang'] = array(
	'checkuser-reason' => 'Racu',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Alnokta
 * @author Mido
 */
$messages['ar'] = array(
	'checkuser-summary'          => 'هذه الأداة تفحص أحدث التغييرات لاسترجاع الأيبيهات المستخدمة بواسطة مستخدم أو عرض بيانات التعديل/المستخدم لأيبي.
	المستخدمون والتعديلات بواسطة أيبي عميل يمكن استرجاعها من خلال عناوين XFF عبر طرق الأيبي IP ب"/xff". IPv4 (CIDR 16-32) و IPv6 (CIDR 64-128) مدعومان.
	لا أكثر من 5000 تعديل سيتم عرضها لأسباب تتعلق بالأداء. استخدم هذا بالتوافق مع السياسة.',
	'checkuser-desc'             => 'يمنح المستخدمين بالسماح المطلوب القدرة على فحص عناوين الأيبي لمستخدم ما ومعلومات أخرى',
	'checkuser-logcase'          => 'بحث السجل حساس لحالة الحروف.',
	'checkuser'                  => 'تدقيق مستخدم',
	'group-checkuser'            => 'مدققو مستخدم',
	'group-checkuser-member'     => 'مدقق مستخدم',
	'right-checkuser'            => 'التحقق من عناوين الأيبي للمستخدمين ومعلومات أخرى',
	'grouppage-checkuser'        => '{{ns:project}}:تدقيق مستخدم',
	'checkuser-reason'           => 'السبب',
	'checkuser-showlog'          => 'اعرض السجل',
	'checkuser-log'              => 'سجل تدقيق المستخدم',
	'checkuser-query'            => 'فحص أحدث التغييرات',
	'checkuser-target'           => 'مستخدم أو عنوان أيبي',
	'checkuser-users'            => 'اعرض المستخدمين',
	'checkuser-edits'            => 'اعرض التعديلات من الأيبي',
	'checkuser-ips'              => 'اعرض الأيبيهات',
	'checkuser-search'           => 'بحث',
	'checkuser-empty'            => 'لا توجد مدخلات في السجل.',
	'checkuser-nomatch'          => 'لم يتم العثور على مدخلات مطابقة.',
	'checkuser-check'            => 'فحص',
	'checkuser-log-fail'         => 'غير قادر على إضافة مدخلة للسجل',
	'checkuser-nolog'            => 'لم يتم العثور على ملف سجل.',
	'checkuser-blocked'          => 'ممنوع',
	'checkuser-too-many'         => 'نتائج كثيرة جدا، من فضلك قلل الCIDR.
هذه هي الأيبيهات المستخدمة (5000 كحد أقصى، مرتبة بالعنوان):',
	'checkuser-user-nonexistent' => 'المستخدم المحدد غير موجود.',
	'checkuser-search-form'      => 'اعثر على مدخلات السجل حيث $1 هو $2',
	'checkuser-search-submit'    => 'بحث',
	'checkuser-search-initiator' => 'بادىء',
	'checkuser-search-target'    => 'هدف',
	'checkuser-ipeditcount'      => '~$1 من كل المستخدمين',
	'checkuser-log-subpage'      => 'سجل',
	'checkuser-log-return'       => 'ارجع إلى استمارة تدقيق المستخدم الرئيسية',
	'checkuser-log-userips'      => '$1 حصل على الأيبيهات ل $2',
	'checkuser-log-ipedits'      => '$1 حصل على التعديلات ل $2',
	'checkuser-log-ipusers'      => '$1 حصل على المستخدمين ل $2',
	'checkuser-log-ipedits-xff'  => '$1 حصل على التعديلات للإكس إف إف $2',
	'checkuser-log-ipusers-xff'  => '$1 حصل على المستخدمين للإكس إف إف $2',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author SPQRobin
 */
$messages['ast'] = array(
	'checkuser-summary'          => "Esta ferramienta escanea los cambeos recientes pa obtener les IP usaes por un usuariu o p'amosar les ediciones o usuarios d'una IP.
	Los usuarios y ediciones correspondientes a una IP puen obtenese per aciu de les cabeceres XFF añadiendo depués de la IP \\\"/xff\\\". Puen usase los protocolos IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128).
	Por razones de rendimientu nun s'amosarán más de 5.000 ediciones. Emplega esta ferramienta  acordies cola política d'usu.",
	'checkuser-desc'             => "Permite a los usuarios colos permisos afechiscos la posibilidá de comprobar les direiciones IP d'usuarios y otres informaciones",
	'checkuser-logcase'          => 'La busca nel rexistru distingue ente mayúscules y minúscules.',
	'checkuser'                  => "Comprobador d'usuariu",
	'group-checkuser'            => "Comprobadores d'usuariu",
	'group-checkuser-member'     => "Comprobador d'usuariu",
	'grouppage-checkuser'        => "{{ns:project}}:Comprobador d'usuariu",
	'checkuser-reason'           => 'Razón',
	'checkuser-showlog'          => 'Amosar el rexistru',
	'checkuser-log'              => "Rexistru de comprobadores d'usuariu",
	'checkuser-query'            => 'Buscar nos cambeos recientes',
	'checkuser-target'           => 'Usuariu o IP',
	'checkuser-users'            => 'Obtener usuarios',
	'checkuser-edits'            => 'Obtener les ediciones de la IP',
	'checkuser-ips'              => 'Obtener les IP',
	'checkuser-search'           => 'Buscar',
	'checkuser-empty'            => 'El rexistru nun tien nengún elementu.',
	'checkuser-nomatch'          => "Nun s'atoparon coincidencies.",
	'checkuser-check'            => 'Comprobar',
	'checkuser-log-fail'         => 'Nun se pue añader la entrada nel rexistru',
	'checkuser-nolog'            => "Nun s'atopó l'archivu del rexistru.",
	'checkuser-blocked'          => 'Bloquiáu',
	'checkuser-too-many'         => 'Demasiaos resultaos, por favor mengua la CIDR. Estes son les IP usaes (5.000 como máximo, ordenaes por direición):',
	'checkuser-user-nonexistent' => "L'usuariu especificáu nun esiste.",
	'checkuser-search-form'      => 'Atopar les entraes de rexistru onde $1 ye $2',
	'checkuser-search-submit'    => 'Buscar',
	'checkuser-search-initiator' => 'aniciador',
	'checkuser-search-target'    => 'oxetivu',
	'checkuser-log-subpage'      => 'Rexistru',
	'checkuser-log-return'       => "Volver al formulariu principal de comprobador d'usuariu",
	'checkuser-log-userips'      => '$1 obtuvo les IP pa $2',
	'checkuser-log-ipedits'      => '$1 obtuvo les ediciones pa $2',
	'checkuser-log-ipusers'      => '$1 obtuvo los usuarios pa $2',
	'checkuser-log-ipedits-xff'  => '$1 obtuvo les ediciones pa XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 obtuvo los usuarios pa XFF $2',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'checkuser'               => 'Stujera va favesik',
	'group-checkuser'         => 'Stujera va favesik',
	'group-checkuser-member'  => 'Stujera va favesik',
	'grouppage-checkuser'     => '{{ns:project}}:Stujera va favesik',
	'checkuser-reason'        => 'Lazava',
	'checkuser-showlog'       => 'Nedira va "log"',
	'checkuser-target'        => 'Favesik ok IP mane',
	'checkuser-search'        => 'Aneyara',
	'checkuser-empty'         => '"Log" iyeltak tir vlardaf.',
	'checkuser-nomatch'       => 'Nedoy trasiks',
	'checkuser-check'         => 'Stujera',
	'checkuser-nolog'         => 'Mek trasiyin "log" iyeltak.',
	'checkuser-blocked'       => 'Elekan',
	'checkuser-search-submit' => 'Aneyara',
	'checkuser-search-target' => 'jala',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'checkuser-desc'             => 'کاربرانء اجازت دن  گون مناسبین اجازت آدرسان آی پی یک کاربری و دگه اطلاعاتء کنترل بکنت',
	'checkuser-logcase'          => 'گردگ ته آمار به الفبای هورد و مزنین حساسنت.',
	'checkuser'                  => 'کنترل کاربر',
	'group-checkuser'            => 'کنترل کابران',
	'group-checkuser-member'     => 'کنترل کاربر',
	'right-checkuser'            => 'کنترل کن آی پی کاربران و دگه اطلاعاتء',
	'grouppage-checkuser'        => '{{ns:project}}:کنترل کاربر',
	'checkuser-reason'           => 'دلیل',
	'checkuser-showlog'          => 'آمار پیش دار',
	'checkuser-log'              => 'آمار کنترل کاربر',
	'checkuser-query'            => 'درخواست نوکین تغییرات',
	'checkuser-target'           => 'کاربر یا آی پی',
	'checkuser-users'            => 'بگر کابرانء',
	'checkuser-edits'            => 'چه آی پی آن اصلاح بگر',
	'checkuser-ips'              => 'آی پی آن گر',
	'checkuser-search'           => 'گردگ',
	'checkuser-empty'            => 'آمار شمال هچ آیتمی نهنت.',
	'checkuser-nomatch'          => 'هچ همدابی در نکپت',
	'checkuser-check'            => 'کنترل',
	'checkuser-log-fail'         => 'نه تونی ورودی آمار اضافه کنت',
	'checkuser-nolog'            => 'فایل آماری در نه کپت',
	'checkuser-blocked'          => 'محدود',
	'checkuser-too-many'         => 'بازگین نتیجه, لطفا CIDR هورد تر کن.
ادان آی پی آنی هستند که استفاده کننت(5000 ماکسیمم، گون آدرس ردیف بوتگن):',
	'checkuser-user-nonexistent' => 'مشخص بوتگین کاربر موجود نهنت',
	'checkuser-search-form'      => 'دیرگیز آمار ورودی جاهی که  $1 هست  $2',
	'checkuser-search-submit'    => 'گردگ',
	'checkuser-search-initiator' => 'شروع کنوک',
	'checkuser-search-target'    => 'هدف',
	'checkuser-ipeditcount'      => '~$1 چه کلی کابران',
	'checkuser-log-subpage'      => 'آمار',
	'checkuser-log-return'       => 'په فرم اصلی کنترل کاربر تر',
	'checkuser-log-userips'      => '$1 گریت آی پی په $2',
	'checkuser-log-ipedits'      => '$1 گریت اصلاح په  $2',
	'checkuser-log-ipusers'      => '$1 کابران گریت په $2',
	'checkuser-log-ipedits-xff'  => '$1 اصلاح کنت په XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 گریت کابران په XFF $2',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'checkuser-reason'  => 'Rasón',
	'checkuser-showlog' => 'Ipahiling an mga historial',
	'checkuser-target'  => 'Parágamit o IP',
	'checkuser-users'   => 'Kûanón',
	'checkuser-ips'     => 'Kûanón an mga IP',
	'checkuser-search'  => 'Hanápon',
	'checkuser-blocked' => 'Pigbágat',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'group-checkuser'            => 'Правяраючыя ўдзельнікаў',
	'group-checkuser-member'     => 'Правяраючы ўдзельнікаў',
	'checkuser-reason'           => 'Прычына',
	'checkuser-showlog'          => 'Паказаць журнал',
	'checkuser-log'              => 'Журнал праверак удзельнікаў',
	'checkuser-target'           => 'Рахунак удзельніка альбо IP-адрас',
	'checkuser-users'            => 'Атрымаць рахункі ўдзельнікаў',
	'checkuser-edits'            => 'Атрымаць рэдагаваньні, зробленыя з IP-адрасу',
	'checkuser-ips'              => 'Атрымаць IP-адрасы',
	'checkuser-empty'            => 'Журнал ня ўтрымлівае запісаў.',
	'checkuser-nomatch'          => 'Супадзеньні ня знойдзеныя.',
	'checkuser-check'            => 'Праверыць',
	'checkuser-log-fail'         => 'Немагчыма дадаць запіс у журнал',
	'checkuser-nolog'            => 'Ня знойдзены файл журнала.',
	'checkuser-blocked'          => 'Заблякаваны',
	'checkuser-search-submit'    => 'Шукаць',
	'checkuser-search-initiator' => 'ініцыятар',
	'checkuser-log-subpage'      => 'Журнал',
	'checkuser-log-userips'      => '$1 атрымаў IP-адрасы для $2',
	'checkuser-log-ipedits'      => '$1 атрымаў рэдагаваньні для $2',
	'checkuser-log-ipusers'      => '$1 атрымаў рахункі ўдзельнікаў для $2',
	'checkuser-log-ipedits-xff'  => '$1 атрымаў рэдагаваньні для XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 атрымаў рахункі ўдзельнікаў для XFF $2',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Borislav
 */
$messages['bg'] = array(
	'checkuser-summary'          => 'Този инструмент сканира последните промени и извлича IP адресите, използвани от потребител или показва информацията за редакциите/потребителя за посоченото IP.
	Потребители и редакции по клиентско IP могат да бъдат извлечени чрез XFF headers като се добави IP с "/xff". Поддържат се IPv4 (CIDR 16-32) и IPv6 (CIDR 64-128).
	От съображения, свързани с производителността на уикито, ще бъдат показани не повече от 5000 редакции. Използвайте инструмента съобразно установената политика.',
	'checkuser-desc'             => 'Предоставя на потребители с подходящите права възможност за проверка на потребителски IP адреси и друга информация',
	'checkuser-logcase'          => 'Търсенето в дневника различава главни от малки букви.',
	'checkuser'                  => 'Проверяване на потребител',
	'group-checkuser'            => 'Проверяващи',
	'group-checkuser-member'     => 'Проверяващ',
	'right-checkuser'            => 'проверяване на потребителски IP адреси и друга информация',
	'grouppage-checkuser'        => '{{ns:project}}:Проверяващи',
	'checkuser-reason'           => 'Причина',
	'checkuser-showlog'          => 'Показване на дневника',
	'checkuser-log'              => 'Дневник на проверяващите',
	'checkuser-query'            => 'Заявка към последните промени',
	'checkuser-target'           => 'Потребител или IP',
	'checkuser-users'            => 'Извличане на потребители',
	'checkuser-edits'            => 'Извличане на редакции от IP',
	'checkuser-ips'              => 'Извличане на IP адреси',
	'checkuser-search'           => 'Търсене',
	'checkuser-empty'            => 'Дневникът не съдържа записи.',
	'checkuser-nomatch'          => 'Няма открити съвпадения.',
	'checkuser-check'            => 'Проверка',
	'checkuser-log-fail'         => 'Беше невъзможно да се добави запис в дневника',
	'checkuser-nolog'            => 'Не беше открит дневник.',
	'checkuser-blocked'          => 'Блокиран',
	'checkuser-too-many'         => 'Твърде много резултати. Показани са използваните IP адреси (най-много 5000, сортирани по адрес):',
	'checkuser-user-nonexistent' => 'Посоченият потребител не съществува.',
	'checkuser-search-form'      => 'Намиране на записи от дневника, в които $1 е $2',
	'checkuser-search-submit'    => 'Търсене',
	'checkuser-search-initiator' => 'инициатор',
	'checkuser-search-target'    => 'цел',
	'checkuser-ipeditcount'      => '~$1 от всички потребители',
	'checkuser-log-subpage'      => 'Дневник',
	'checkuser-log-return'       => 'Връщане към основния формуляр за проверка',
	'checkuser-log-userips'      => '$1 е получил айпи адреси за $2',
	'checkuser-log-ipedits'      => '$1 е получил редакции за $2',
	'checkuser-log-ipusers'      => '$1 е получил потребители за $2',
	'checkuser-log-ipedits-xff'  => '$1 е получил редакции за XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 е получил потребители за XFF $2',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'checkuser-summary'          => 'এই সরঞ্জামটি সাম্প্রতিক পরিবর্তনসমূহ বিশ্লেষণ করে কোন ব্যবহারকারীর ব্যবহৃত আইপিগুলি নিয়ে আসে কিংবা কোন একটি আইপির জন্য সম্পাদনা/ব্যবহারকারী উপাত্ত প্রদর্শন করে।
কোন ক্লায়েন্ট আইপি-র জন্য ব্যবহারকারী ও সম্পাদনা XFF হেডারসমূহের সাহায্যে নিয়ে আসা যায়; এজন্য আইপির সাথে "/xff" যোগ করতে হয়।
IPv4 (CIDR 16-32) এবং IPv6 (CIDR 64-128) এই সরঞ্জামে সমর্থিত।
দক্ষতাজনিত কারণে ৫০০০-এর বেশি সম্পাদনা নিয়ে আসা হবে না। নীতিমালা মেনে এটি ব্যবহার করুন।',
	'checkuser-desc'             => 'যথাযথ অনুমোদনপ্রাপ্ত ব্যবহারকারীদেরকে অন্য ব্যবহারকারীদের আইপি ঠিকানা এবং অন্যান্য তথ্য পরীক্ষা করার ক্ষমতা দেয়',
	'checkuser-logcase'          => 'লগ অনুসন্ধান বড়/ছোট হাতের অক্ষরের উপর নির্ভরশীল',
	'checkuser'                  => 'ব্যবহারকারী পরীক্ষণ',
	'group-checkuser'            => 'ব্যবহারকারীসমূহ পরীক্ষণ',
	'group-checkuser-member'     => 'ব্যবহারকারী পরীক্ষণ',
	'grouppage-checkuser'        => '{{ns:project}}:ব্যবহারকারী পরীক্ষণ',
	'checkuser-reason'           => 'কারণ',
	'checkuser-showlog'          => 'লগ দেখাও',
	'checkuser-log'              => 'CheckUser লগ',
	'checkuser-query'            => 'সাম্প্রতিক পরিবর্তনসমূহ জানুন',
	'checkuser-target'           => 'ব্যবহারকারী অথবা আইপি',
	'checkuser-users'            => 'ব্যবহারকারী সমূহ পাওয়া যাবে',
	'checkuser-edits'            => 'আইপি থেকে সম্পাদনাসমূহ পাওয়া যাবে',
	'checkuser-ips'              => 'আইপি সমূহ পাওয়া যাবে',
	'checkuser-search'           => 'অনুসন্ধান',
	'checkuser-empty'            => 'এই লগে কিছুই নেই।',
	'checkuser-nomatch'          => 'এর সাথে মিলে এমন কিছু পাওয়া যায়নি।',
	'checkuser-check'            => 'পরীক্ষা করুন',
	'checkuser-log-fail'         => 'লগ ভুক্তিতে যোগ করা সম্ভব হচ্ছে না',
	'checkuser-nolog'            => 'কোন লগ ফাইল পাওয়া যায়নি।',
	'checkuser-blocked'          => 'বাধা দেওয়া হয়েছে',
	'checkuser-too-many'         => 'অত্যধিক সংখ্যক ফলাফল, অনুগ্রহ করে CIDR সীমিত করুন। নিচের আইপিগুলি ব্যবহৃত হয়েছে (সর্বোচ্চ ৫০০০, ঠিকানা অনুযায়ী বিন্যস্ত):',
	'checkuser-user-nonexistent' => 'এই নির্দিষ্ট ব্যবহারকারী নেই।',
	'checkuser-search-form'      => 'এমনসব লগ ভুক্তি খুঁজে বের করুন যেখানে $1 হল $2',
	'checkuser-search-submit'    => 'অনুসন্ধান',
	'checkuser-search-initiator' => 'আরম্ভকারী',
	'checkuser-search-target'    => 'লক্ষ্য',
	'checkuser-ipeditcount'      => '~$1 সমস্ত ব্যবহাকারী থেকে',
	'checkuser-log-subpage'      => 'লগ',
	'checkuser-log-return'       => 'CheckUser মূল ফর্মে ফেরত যান',
	'checkuser-log-userips'      => '$2 এর জন্য $1 আইপি  সমূহ পেয়েছে',
	'checkuser-log-ipedits'      => '$2 এর জন্য $1 সম্পাদনাসমূহ পেয়েছে',
	'checkuser-log-ipusers'      => '$2 এর জন্য $1 ব্যবহারকারীসমূহ পেয়েছে',
	'checkuser-log-ipedits-xff'  => '$2 এর জন্য XFF $1 সম্পাদনাসমূহ পেয়েছে',
	'checkuser-log-ipusers-xff'  => '$2 এর জন্য XFF $1 ব্যবহারকারীসমূহ পেয়েছে',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'checkuser-summary'          => "Furchal a ra an ostilh-mañ ar c'hemmoù diwezhañ a-benn klask ar chomlec'h IP implijet gant un implijer bennak, diskouez a ra holl degasadennoù ur chomlec'h IP (ha pa vefe bet enrollet), pe roll ar c'hontoù implijet gant ur chomlec'h IP. Gallout a ra ar c'hontoù hag ar c'hemmoù bezañ kavet gant un IP XFF mard echu gant \"/xff\". Posupl eo implijout ar protokoloù IPv4 (CIDR 16-32) hag IPv6 (CIDR 64-128). Bevennet eo an niver a gemmoù a c'haller lakaat war wel da {{formatnum:5000}} evit abegoù nerzh ar servijer. Grit gant an ostilh-mañ en ur zoujañ d'ar garta implijout.",
	'checkuser-desc'             => "Reiñ a ra an tu d'an dud aotreet evit se da wiriañ chomlec'hioù IP an implijerien ha da gaout titouroù all",
	'checkuser-logcase'          => "Kizidik eo ar c'hlask er marilh ouzh an direnneg (pennlizherennoù/lizherennoù munud)",
	'checkuser'                  => 'Gwiriañ an implijer',
	'group-checkuser'            => 'Gwiriañ an implijerien',
	'group-checkuser-member'     => 'Gwiriañ an implijer',
	'grouppage-checkuser'        => '{{ns:project}}:Gwiriañ an implijer',
	'checkuser-reason'           => 'Abeg',
	'checkuser-showlog'          => 'Diskouez ar marilh',
	'checkuser-log'              => 'Marilh kontrolliñ an implijerien',
	'checkuser-query'            => "Klask dre ar c'hemmoù diwezhañ",
	'checkuser-target'           => 'Implijer pe IP',
	'checkuser-users'            => 'Kavout an implijerien',
	'checkuser-edits'            => "Kavout degasadennoù ar chomlec'h IP",
	'checkuser-ips'              => "Kavout ar chomlec'hioù IP",
	'checkuser-search'           => 'Klask',
	'checkuser-empty'            => "N'eus pennad ebet er marilh",
	'checkuser-nomatch'          => "N'eus bet kavet netra.",
	'checkuser-check'            => 'Gwiriañ',
	'checkuser-log-fail'         => "Dibosupl ouzhpennañ ar moned d'ar marilh",
	'checkuser-nolog'            => 'Restr ebet er marilh',
	'checkuser-blocked'          => 'Stanket',
	'checkuser-too-many'         => "Re a zisoc'hoù, strishaat ar CIDR mar plij.
Setu an IPoù implijet (5000 d'ar muiañ, urzhiet dre ar chomlec'h)",
	'checkuser-user-nonexistent' => "N'eus ket eus an implijer merket",
	'checkuser-search-form'      => "Kavout marilh ar monedoù m'eo $1 evit $2",
	'checkuser-search-submit'    => 'Klask',
	'checkuser-search-initiator' => 'deraouer',
	'checkuser-search-target'    => 'pal',
	'checkuser-log-subpage'      => 'Marilh',
	'checkuser-log-return'       => "Distreiñ da furmskrid pennañ ar c'hontrolliñ implijerien",
	'checkuser-log-userips'      => '$1 en deus kavet IPoù evit $2',
	'checkuser-log-ipedits'      => '$1 en deus kavet kemmoù evit $2',
	'checkuser-log-ipusers'      => '$1 en deus kavet implijerien evit $2',
	'checkuser-log-ipedits-xff'  => '$1 en deus kavet kemmoù evit $2 dre XFF',
	'checkuser-log-ipusers-xff'  => 'Kavet en deus $1 implijerien $2 dre XFF',
);

/** Catalan (Català)
 * @author SMP
 * @author Juanpabl
 * @author Jordi Roqué
 * @author Toniher
 */
$messages['ca'] = array(
	'checkuser-summary'          => "Aquest instrument efectua una cerca als canvis recents per a comprovar les adreces IP fetes servir per un usuari o per a mostrar les edicions d'una certa adreça IP.
Les edicions i usuaris d'un client IP es poden obtenir via capçaleres XFF afegint /xff al final de la IP. Tant les adreces IPv4 (CIDR 16-32) com les IPv6 (CIDR 64-128) són admeses.
Per raons d'efectivitat i de memòria no es retornen més de 5000 edicions. Recordeu que aquesta eina només es pot usar d'acord amb les polítiques corresponents i amb respecte a la legislació sobre privacitat.",
	'checkuser-desc'             => "Permet als usuaris amb els permisos adients l'habilitat de comprovar les adreces IP que fan servir els usuaris enregistrats.",
	'checkuser-logcase'          => 'Les majúscules es tracten de manera diferenciada en la cerca dins el registre.',
	'checkuser'                  => "Comprova l'usuari",
	'group-checkuser'            => 'Checkusers',
	'group-checkuser-member'     => 'CheckUser',
	'right-checkuser'            => 'Comprovar les adreces IP i altra informació dels usuaris',
	'grouppage-checkuser'        => '{{ns:project}}:Checkuser',
	'checkuser-reason'           => 'Motiu',
	'checkuser-showlog'          => 'Mostra registre',
	'checkuser-log'              => 'Registre de Checkuser',
	'checkuser-query'            => 'Cerca als canvis recents',
	'checkuser-target'           => 'Usuari o IP',
	'checkuser-users'            => 'Retorna els usuaris',
	'checkuser-edits'            => 'Retorna les edicions de la IP',
	'checkuser-ips'              => 'Retorna adreces IP',
	'checkuser-search'           => 'Cerca',
	'checkuser-empty'            => 'El registre no conté entrades.',
	'checkuser-nomatch'          => "No s'han trobat coincidències.",
	'checkuser-check'            => 'Comprova',
	'checkuser-log-fail'         => "No s'ha pogut afegir al registre",
	'checkuser-nolog'            => "No s'ha trobat el fitxer del registre.",
	'checkuser-blocked'          => 'Blocat',
	'checkuser-too-many'         => 'Hi ha massa resultats, cal que useu un CIDR més petit. Aquí teniu les IP usades (màx. 5000 ordenades per adreça):',
	'checkuser-user-nonexistent' => "L'usuari especificat no existeix.",
	'checkuser-search-form'      => 'Cerca entrades al registre on $1 és $2',
	'checkuser-search-submit'    => 'Cerca',
	'checkuser-search-initiator' => "l'iniciador",
	'checkuser-search-target'    => 'el consultat',
	'checkuser-ipeditcount'      => '~$1 de tots els usuaris',
	'checkuser-log-subpage'      => 'Registre',
	'checkuser-log-return'       => 'Retorna al formulari de CheckUser',
	'checkuser-log-userips'      => '$1 consulta les IP de $2',
	'checkuser-log-ipedits'      => '$1 consulta les edicions de $2',
	'checkuser-log-ipusers'      => '$1 consulta els usuaris de $2',
	'checkuser-log-ipedits-xff'  => '$1 consulta les edicions del XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 consulta els usuaris del XFF $2',
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄) */
$messages['cdo'] = array(
	'checkuser-search' => 'Sìng-tō̤',
);

/** Chechen (Нохчийн)
 * @author SPQRobin
 */
$messages['ce'] = array(
	'checkuser-target' => 'Юзер я IP-адрес',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'checkuser-search'        => 'Aligao',
	'checkuser-search-submit' => 'Aligao',
);

/** Corsican (Corsu)
 * @author SPQRobin
 */
$messages['co'] = array(
	'group-checkuser'        => 'Controllori',
	'group-checkuser-member' => 'Controllore',
	'grouppage-checkuser'    => '{{ns:project}}:Controllori',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Danny B.
 * @author Beren
 * @author Mormegil
 */
$messages['cs'] = array(
	'checkuser-summary'          => 'Tento nástroj zkoumá poslední změny a umožňuje získat IP adresy uživatelů nebo zobrazit editace a uživatele z dané IP adresy.
Uživatele a editace z klientské IP adresy lze získat z hlaviček XFF přidáním „/xff“ k IP. Je podporováno  IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128).
Z výkonnostních důvodů lze zobrazit maximálně 5000 editací. Používejte tento nástroj v souladu s pravidly.',
	'checkuser-desc'             => 'Poskytuje uživatelům s příslušným oprávněním možnost zjišťovat IP adresy uživatelů a další související informace',
	'checkuser-logcase'          => 'Hledání v záznamech rozlišuje velikosti písmen.',
	'checkuser'                  => 'Kontrola uživatele',
	'group-checkuser'            => 'Revizoři',
	'group-checkuser-member'     => 'Revizor',
	'right-checkuser'            => 'Kontrolování uživatelské IP adresy a dalších informací',
	'grouppage-checkuser'        => '{{ns:project}}:Revize uživatele',
	'checkuser-reason'           => 'Důvod',
	'checkuser-showlog'          => 'Zobrazit záznamy',
	'checkuser-log'              => 'Kniha kontroly uživatelů',
	'checkuser-query'            => 'Dotaz na poslední změny',
	'checkuser-target'           => 'Uživatel nebo IP',
	'checkuser-users'            => 'Najít uživatele',
	'checkuser-edits'            => 'Najít editace z IP',
	'checkuser-ips'              => 'Najít IP adresy',
	'checkuser-search'           => 'Hledat',
	'checkuser-empty'            => 'Kniha neobsahuje žádné položky',
	'checkuser-nomatch'          => 'Nic odpovídajícího nebylo nalezeno.',
	'checkuser-check'            => 'Zkontrolovat',
	'checkuser-log-fail'         => 'Nepodařilo se zapsat do záznamů',
	'checkuser-nolog'            => 'Soubor záznamů nebyl nalezen.',
	'checkuser-blocked'          => 'zablokováno',
	'checkuser-too-many'         => 'Příliš mnoho výsledků, zkuste omezit CIDR. Níže jsou použité IP adresy (nejvýše 500, seřazené abecedně):',
	'checkuser-user-nonexistent' => 'Zadaný uživatel neexistuje.',
	'checkuser-search-form'      => 'Hledej záznamy, kde $1 je $2',
	'checkuser-search-submit'    => 'Hledat',
	'checkuser-search-initiator' => 'kontrolující',
	'checkuser-search-target'    => 'kontrolováno',
	'checkuser-ipeditcount'      => 'asi $1 od všech uživatelů',
	'checkuser-log-subpage'      => 'Záznamy',
	'checkuser-log-return'       => 'Návrat na hlavní formulář Kontroly uživatele',
	'checkuser-log-userips'      => '$1 zjišťuje IP adresy uživatele $2',
	'checkuser-log-ipedits'      => '$1 zjišťuje editace z IP $2',
	'checkuser-log-ipusers'      => '$1 zjišťuje uživatele z IP $2',
	'checkuser-log-ipedits-xff'  => '$1 zjišťuje editace s XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 zjišťuje uživatele s XFF $2',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'checkuser-search'        => 'иска́ниѥ',
	'checkuser-search-submit' => 'ищи́',
);

/** Danish (Dansk)
 * @author Morten
 * @author M.M.S.
 */
$messages['da'] = array(
	'checkuser-summary'          => 'Dette værktøj scanner Seneste ændringer for at finde IP\'er brugt af en bestemt bruger, eller for at vise redigerings- eller brugerdata for en IP.
Bruger og redigeringer fra en klient IP kan hentes via XFF headers ved at tilføje "/xff" til IP\'en. Ipv4 (CIRD 16-32) og IPv6 (CIDR 64-128) er understøttet.
For at sikre programmelets ydeevne kan maksimalt 5000 redigeringer returneres. Brug kun dette værktøj i overensstemmelse med gældende politiker på {{SITENAME}}.',
	'checkuser-desc'             => 'Giver brugere med den rette godkendelse muligheden for at checke brugeres IP-adresser og anden information',
	'checkuser-logcase'          => 'Logsøgning er case sensitiv (der gøres forskel på store og små bogstaver)',
	'checkuser'                  => 'Checkbruger',
	'group-checkuser'            => 'Checkbrugere',
	'group-checkuser-member'     => 'Checkbruger',
	'grouppage-checkuser'        => '{{ns:project}}:Checkbruger',
	'checkuser-reason'           => 'Begrundelse',
	'checkuser-showlog'          => 'Vis log',
	'checkuser-log'              => 'Checkbrugerlog',
	'checkuser-query'            => 'Søg i seneste ændringer',
	'checkuser-target'           => 'Bruger eller IP',
	'checkuser-users'            => 'Hent brugere',
	'checkuser-edits'            => 'Hent redigeringer fra IP',
	'checkuser-ips'              => "Hent IP'er",
	'checkuser-search'           => 'Søg',
	'checkuser-empty'            => 'Loggen indeholder ingen poster.',
	'checkuser-nomatch'          => 'Ingen matchende resultater blev fundet.',
	'checkuser-check'            => 'Check',
	'checkuser-log-fail'         => 'Kunne ikke tilføje log-post',
	'checkuser-nolog'            => 'Logfilen blev ikke fundet.',
	'checkuser-blocked'          => 'Blokeret',
	'checkuser-too-many'         => "For mange resultater, gør CIDR'en smallere. Her er de brugte IP'er (max 5000, sorteret efter adresse):",
	'checkuser-user-nonexistent' => 'Den anførte bruger eksisterer ikke.',
	'checkuser-search-form'      => 'Find log-poster hvor $1 er $2',
	'checkuser-search-submit'    => 'Søg',
	'checkuser-search-target'    => 'mål',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Gå tilbage til hovedformularen for checkbruger',
	'checkuser-log-userips'      => "$1 fik IP'er for $2",
	'checkuser-log-ipedits'      => '$1 fik redigeringer for $2',
	'checkuser-log-ipusers'      => '$1 fik brugere for $2',
	'checkuser-log-ipedits-xff'  => '$1 fik redigeringer for XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 fik brugere for XFF $2',
);

/** German (Deutsch)
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'checkuser-summary'          => 'Dieses Werkzeug durchsucht die letzten Änderungen, um die IP-Adressen eines Benutzers
	bzw. die Bearbeitungen/Benutzernamen für eine IP-Adresse zu ermitteln. Benutzer und Bearbeitungen einer IP-Adresse können auch nach Informationen aus den XFF-Headern
	abgefragt werden, indem der IP-Adresse ein „/xff“ angehängt wird. IPv4 (CIDR 16-32) und IPv6 (CIDR 64-128) werden unterstützt.
	Aus Performance-Gründen werden maximal 5000 Bearbeitungen ausgegeben. Benutze CheckUser ausschließlich in Übereinstimmung mit den Datenschutzrichtlinien.',
	'checkuser-desc'             => 'Erlaubt Benutzern mit den entsprechenden Rechten die IP-Adressen sowie weitere Informationen von Benutzern zu prüfen',
	'checkuser-logcase'          => 'Die Suche im Logbuch unterscheidet zwischen Groß- und Kleinschreibung.',
	'checkuser'                  => 'Checkuser',
	'group-checkuser'            => 'Checkusers',
	'group-checkuser-member'     => 'Checkuser-Berechtigter',
	'right-checkuser'            => 'Prüfung von IP-Adressen sowie Verbindungen zwischen IPs und angemeldeten Benutzern',
	'grouppage-checkuser'        => '{{ns:project}}:CheckUser',
	'checkuser-reason'           => 'Grund',
	'checkuser-showlog'          => 'Logbuch anzeigen',
	'checkuser-log'              => 'Checkuser-Logbuch',
	'checkuser-query'            => 'Letzte Änderungen abfragen',
	'checkuser-target'           => 'Benutzer oder IP-Adresse',
	'checkuser-users'            => 'Hole Benutzer',
	'checkuser-edits'            => 'Hole Bearbeitungen von IP-Adresse',
	'checkuser-ips'              => 'Hole IP-Adressen',
	'checkuser-search'           => 'Suchen',
	'checkuser-empty'            => 'Das Logbuch enthält keine Einträge.',
	'checkuser-nomatch'          => 'Keine Übereinstimmungen gefunden.',
	'checkuser-check'            => 'Ausführen',
	'checkuser-log-fail'         => 'Logbuch-Eintrag kann nicht hinzugefügt werden.',
	'checkuser-nolog'            => 'Kein Logbuch vorhanden.',
	'checkuser-blocked'          => 'gesperrt',
	'checkuser-too-many'         => 'Die Ergebnisliste ist zu lang, bitte grenze den IP-Bereich weiter ein. Hier sind die benutzten IP-Adressen (maximal 5000, sortiert nach Adresse):',
	'checkuser-user-nonexistent' => 'Das angegebene Benutzerkonto ist nicht vorhanden.',
	'checkuser-search-form'      => 'Suche Logbucheinträge, bei denen $1 $2 ist.',
	'checkuser-search-submit'    => 'Suche',
	'checkuser-search-initiator' => 'CheckUser-Berechtigter',
	'checkuser-search-target'    => 'Abfrageziel (Benutzerkonto/IP)',
	'checkuser-ipeditcount'      => '~$1 von allen Benutzern',
	'checkuser-log-subpage'      => 'Logbuch',
	'checkuser-log-return'       => 'Zurück zum CheckUser-Hauptformular',
	'checkuser-log-userips'      => '$1 holte IP-Adressen für $2',
	'checkuser-log-ipedits'      => '$1 holte Bearbeitungen für $2',
	'checkuser-log-ipusers'      => '$1 holte Benutzer für $2',
	'checkuser-log-ipedits-xff'  => '$1 holte Bearbeitungen für XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 holte Benutzer für XFF $2',
);

/** Ewe (Eʋegbe)
 * @author M.M.S.
 */
$messages['ee'] = array(
	'checkuser-search'        => 'Dii',
	'checkuser-search-submit' => 'Dii',
);

/** Greek (Ελληνικά)
 * @author Απεργός
 * @author ZaDiak
 * @author Consta
 */
$messages['el'] = array(
	'checkuser-summary'          => 'Αυτό το εργαλείο σαρώνει τις πρόσφατες αλλαγές για να ανακτήσει τις IP διευθύνσεις που χρησιμοποιούνται από ένα χρήστη ή για να δείξει τα δεδομένα επεξεργασιών/χρηστών για μία IP.
Χρήστες και επεξεργασίες από μία σταθερή IP μπορούν να ανακτηθούν μέσω XFF επικεφαλίδων προσαρτώντας "/xff" στην IP. Το IPv4 (CIDR 16-32) και το IPv6 (CIDR 64-128) υποστηρίζονται.
Όχι περισσότερες από 5000 επεξεργασίες θα επιστραφούν για λόγους απόδοσης. 
Χρησιμοποιήστε αυτό σύμφωνα με την πολιτική.',
	'checkuser-desc'             => 'Παρέχει στους χρήστες με την κατάλληλη άδεια την ικανότητα να ελέγχουν τη διεύθυνση IP ενός χρήστη καθώς και άλλες πληροφορίες',
	'checkuser-logcase'          => 'Η αναζήτηση στο αρχείο καταγραφής διακρίνει πεζά από κεφαλαία.',
	'checkuser'                  => 'Ελεγκτής',
	'group-checkuser'            => 'Ελεγκτές',
	'group-checkuser-member'     => 'Ελεγκτής',
	'grouppage-checkuser'        => '{{ns:project}}:Ελεγκτής',
	'checkuser-reason'           => 'Λόγος',
	'checkuser-showlog'          => 'Εμφάνιση αρχείου καταγραφής',
	'checkuser-log'              => 'Αρχείο καταγραφής ελεγχών',
	'checkuser-query'            => 'Αναζήτηση στις πρόσφατες αλλαγές',
	'checkuser-target'           => 'Χρήστης ή IP',
	'checkuser-users'            => 'Λήψη χρηστών',
	'checkuser-edits'            => 'Λήψη επεξεργασιών από IP',
	'checkuser-ips'              => 'Λήψη των IP',
	'checkuser-search'           => 'Αναζήτηση',
	'checkuser-empty'            => 'Το αρχείο καταγραφής δεν περιέχει κανένα αντικείμενο.',
	'checkuser-nomatch'          => 'Δεν βρέθηκαν σχετικές σελίδες.',
	'checkuser-check'            => 'Έλεγχος',
	'checkuser-log-fail'         => 'Δεν είναι δυνατή η προσθήκη εγγραφής στο αρχείο καταγραφών',
	'checkuser-nolog'            => 'Δεν βρέθηκε κανένα αρχείο καταγραφής.',
	'checkuser-blocked'          => 'Φραγμένος',
	'checkuser-too-many'         => 'Πάρα πολλά αποτελέσματα, παρακαλούμε στενέψτε το CIDR. Παρακάτω είναι οι διευθύνσεις IP που χρησιμοποιούνται (με ανώτατο όριο τις 5000, ταξινομημένες κατά διεύθυνση):',
	'checkuser-user-nonexistent' => 'Ο συγκεκριμένος χρήστης δεν υπάρχει.',
	'checkuser-search-form'      => 'Εύρεση εγγραφών του αρχείου καταγραφής στις οποίες ο $1 είναι $2',
	'checkuser-search-submit'    => 'Αναζήτηση',
	'checkuser-search-initiator' => 'ελεγκτής',
	'checkuser-search-target'    => 'στόχος',
	'checkuser-ipeditcount'      => '~$1 από όλους τους χρήστες',
	'checkuser-log-subpage'      => 'Αρχείο',
	'checkuser-log-return'       => 'Επιστροφή στην κύρια φόρμα ελέγχου χρήστη',
	'checkuser-log-userips'      => 'Ο $1 πήρε τις IP διευθύνσεις για τον $2',
	'checkuser-log-ipedits'      => 'Ο $1 πήρε τις επεξεργασίες για το $2',
	'checkuser-log-ipusers'      => 'Ο $1 πήρε τους χρήστες για το $2',
	'checkuser-log-ipedits-xff'  => 'Ο $1 πήρε τις επεξεργασίες για το XFF $2',
	'checkuser-log-ipusers-xff'  => 'Ο $1 πήρε τους χρήστες για το XFF $2',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'checkuser-summary'          => 'Ĉi tiu ilo skanas lastajn ŝanĝojn por akiri la IP-adresojn uzatajn de uzanto aŭ montri la datenojn de redakto/uzanto por aparta IP-adreso.
Uzantoj kaj redaktoj de klienta IP-adreson eblas esti akirita de XFF-titolaro postaldonante "/xff".
IPv4 (CIDR 16-32) kaj IPv6 (CIDR 64-128) estas subtenata.
Neniom pli ol 5000 redaktoj estos montrita pro bona datumbaza funkciado.
Uzu ĉi tion laŭ regularo.',
	'checkuser-desc'             => 'Rajtigas al uzantoj kun la taŭga permeso la kapableco kontroli la IP-adreson de uzanto kaj alia informo',
	'checkuser-logcase'          => 'La protokola serĉo estas usklecodistinga.',
	'checkuser'                  => 'Kontroli uzanton',
	'group-checkuser'            => 'Kontroli uzantojn',
	'group-checkuser-member'     => 'Kontroli uzanton',
	'right-checkuser'            => 'Kontroli la IP-adreson kaj alian informon de uzanto',
	'grouppage-checkuser'        => '{{ns:project}}:Kontroli uzanton',
	'checkuser-reason'           => 'Kialo',
	'checkuser-showlog'          => 'Montri protokolon',
	'checkuser-log'              => 'Protokolo pri kontrolado de uzantoj',
	'checkuser-query'            => 'Informomendu lastatempajn ŝanĝojn',
	'checkuser-target'           => 'Uzanto aŭ IP-adreso',
	'checkuser-users'            => 'Akiri uzantojn',
	'checkuser-edits'            => 'Akiri redaktojn de IP-adreso',
	'checkuser-ips'              => 'Prenu IP-adresojn',
	'checkuser-search'           => 'Serĉi',
	'checkuser-empty'            => 'La protokolo estas malplena.',
	'checkuser-nomatch'          => 'Neniujn pafojn trovis.',
	'checkuser-check'            => 'Kontroli',
	'checkuser-log-fail'         => 'Ne eblis aldoni protokoleron.',
	'checkuser-nolog'            => 'Neniu protokolo estas trovita.',
	'checkuser-blocked'          => 'Forbarita',
	'checkuser-too-many'         => 'Tro da rezultoj. Bonvolu malvastigi la CIDR. 
Jen la IP-adresoj uzitaj (maksimume 5000, ordigita laŭ adresoj):',
	'checkuser-user-nonexistent' => 'La donata uzanto ne ekzistas.',
	'checkuser-search-form'      => 'Trovi protokolerojn en kiu la $1 estas $2',
	'checkuser-search-submit'    => 'Serĉi',
	'checkuser-search-initiator' => 'inicianto',
	'checkuser-search-target'    => 'celo',
	'checkuser-ipeditcount'      => '~$1 de ĉiuj uzantoj',
	'checkuser-log-subpage'      => 'Protokolo',
	'checkuser-log-return'       => 'Reiru al ĉefa kamparo por kontroli uzantojn',
	'checkuser-log-userips'      => '$1 akiris IP-adresojn por $2',
	'checkuser-log-ipedits'      => '$1 akiris redaktojn por $2',
	'checkuser-log-ipusers'      => '$1 akiris uzantojn por $2',
	'checkuser-log-ipedits-xff'  => '$1 akiris redaktojn por XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 akiris uzantojn por XFF $2',
);

/** Spanish (Español)
 * @author Dmcdevit
 * @author Spacebirdy
 * @author Jatrobat
 * @author Lin linao
 * @author Piolinfax
 * @author Titoxd
 */
$messages['es'] = array(
	'checkuser-summary'          => 'Esta herramienta explora los cambios recientes para obtener las IPs utilizadas por un usuario o para mostrar la información de ediciones/usuarios de una IP.
También se pueden obtener los usuarios y las ediciones de un cliente IP vía XFF añadiendo "/xff". IPv4 (CIDR 16-32) y IPv6 (CIDR 64-128) funcionan.
No se muestran más de 5000 ediciones por motivos de rendimiento. Usa esta herramienta en acuerdo con la ley orgánica de protección de datos.',
	'checkuser-logcase'          => 'El buscador de registros distingue entre mayúsculas y minúsculas.',
	'checkuser'                  => 'Verificador de usuarios',
	'group-checkuser'            => 'Verificadores de usuarios',
	'group-checkuser-member'     => 'Verificador de usuarios',
	'right-checkuser'            => 'Comprobar las IPs de los usuarios y obtener otra información relacionada',
	'grouppage-checkuser'        => '{{ns:project}}:verificador de usuarios',
	'checkuser-reason'           => 'Motivo',
	'checkuser-showlog'          => 'Ver registro',
	'checkuser-log'              => 'Registro de CheckUser',
	'checkuser-query'            => 'Buscar en cambios recientes',
	'checkuser-target'           => 'Usuario o IP',
	'checkuser-users'            => 'Obtener usuarios',
	'checkuser-edits'            => 'Obtener ediciones de IP',
	'checkuser-ips'              => 'Obtener IPs',
	'checkuser-search'           => 'Buscar',
	'checkuser-empty'            => 'No hay elementos en el registro.',
	'checkuser-nomatch'          => 'No hay elementos en el registro con esas condiciones.',
	'checkuser-check'            => 'Examinar',
	'checkuser-log-fail'         => 'No se puede añadir este elemento al registro.',
	'checkuser-nolog'            => 'No se encuentra ningún archivo del registro',
	'checkuser-blocked'          => 'Bloqueado',
	'checkuser-too-many'         => 'Hay demasiados resultados. Por favor limita el CIDR. Aquí se ven las IPs usadas (máximo 5000, ordenadas según dirección):',
	'checkuser-user-nonexistent' => 'El usuario especificado no existe.',
	'checkuser-search-submit'    => 'Buscar',
);

/** Estonian (Eesti)
 * @author WikedKentaur
 */
$messages['et'] = array(
	'checkuser-blocked' => 'Blokeeritud',
);

/** Basque (Euskara)
 * @author SPQRobin
 */
$messages['eu'] = array(
	'checkuser'              => 'Erabiltzailea egiaztatu',
	'group-checkuser'        => 'Erabiltzaileak egiaztatu',
	'group-checkuser-member' => 'Erabiltzailea egiaztatu',
	'checkuser-reason'       => 'Arrazoia',
	'checkuser-search'       => 'Bilatu',
	'checkuser-nomatch'      => 'Ez da bat datorren emaitzarik aurkitu.',
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
	'checkuser-summary'          => 'این ابزار تغییرات اخیر را برای به دست آوردن نشانی‌های اینترنتی (IP) استفاده شده توسط یک کاربر و یا تعیین ویرایش‌های انجام شده از طریق یک نشانی اینترنتی جستجو می‌کند.
کاربرها و ویرایش‌های مرتبط با یک نشانی اینترنتی را می‌توان با توجه به اطلاعات سرآیند XFF (با افزودن «‏‎/xff» به انتهای نشانی IP) پیدا کرد.
هر دو پروتکل IPv4 (معادل CIDR 16-32) و IPv6 (معادل CIDR 64-128) توسط این ابزار پشتیبانی می‌شوند.',
	'checkuser-desc'             => 'به کاربرها اختیارات لازم را برای بررسی نشانی اینترنتی کاربرها و اطلاعات دیگر می‌دهد',
	'checkuser-logcase'          => 'جستجوی سیاهه به کوچک یا بزرگ بودن حروف حساس است.',
	'checkuser'                  => 'بازرسی کاربر',
	'group-checkuser'            => 'بازرسان کاربر',
	'group-checkuser-member'     => 'بازرس کاربر',
	'right-checkuser'            => 'بررسی نشانی اینترنتی و دیگر اطلاعات کاربرها',
	'grouppage-checkuser'        => '{{ns:project}}:بازرسی کاربر',
	'checkuser-reason'           => 'دلیل',
	'checkuser-showlog'          => 'نمایش سیاهه',
	'checkuser-log'              => 'سیاهه بازرسی کاربر',
	'checkuser-query'            => 'جستجوی تغییرات اخیر',
	'checkuser-target'           => 'کاربر یا نشانی اینترنتی',
	'checkuser-users'            => 'فهرست کردن کاربرها',
	'checkuser-edits'            => 'نمایش ویرایش‌های مربوط به این نشانی اینترنتی',
	'checkuser-ips'              => 'فهرست کردن نشانی‌های اینترنتی',
	'checkuser-search'           => 'جستجو',
	'checkuser-empty'            => 'سیاهه خالی است.',
	'checkuser-nomatch'          => 'موردی که مطابقت داشته باشد پیدا نشد.',
	'checkuser-check'            => 'بررسی',
	'checkuser-log-fail'         => 'امکان افزودن اطلاعات به سیاهه وجود ندارد',
	'checkuser-nolog'            => 'پرونده سیاهه پیدا نشد.',
	'checkuser-blocked'          => 'دسترسی قطع شد',
	'checkuser-too-many'         => 'تعداد نتایج بسیار زیاد است. لطفاً CIDR را باریک‌تر کنید. در زیر نشانی‌های اینترنتی استفاده شده را می‌بینید (حداثر ۵۰۰۰ مورد، به ترتیب نشانی):',
	'checkuser-user-nonexistent' => 'کاربر مورد نظر وجود ندارد.',
	'checkuser-search-form'      => 'پیدا کردن مواردی در سیاهه‌ها که $1 همان $2 است',
	'checkuser-search-submit'    => 'جستجو',
	'checkuser-search-initiator' => 'آغازگر',
	'checkuser-search-target'    => 'هدف',
	'checkuser-ipeditcount'      => '~$1 از همهٔ کاربران',
	'checkuser-log-subpage'      => 'سیاهه',
	'checkuser-log-return'       => 'بازگشت به فرم اصلی بازرسی کاربر',
	'checkuser-log-userips'      => '$1 نشانی‌های اینترنتی $2 را گرفت',
	'checkuser-log-ipedits'      => '$1 ویرایش‌های $2 را گرفت',
	'checkuser-log-ipusers'      => '$1 کاربرهای مربوط به $2 را گرفت',
	'checkuser-log-ipedits-xff'  => '$1 ویرایش‌های XFF $2 را گرفت',
	'checkuser-log-ipusers-xff'  => '$1 کاربرهای مربوط به XFF $2 را گرفت',
);

/** Finnish (Suomi)
 * @author Nike
 * @author Crt
 * @author Jack Phoenix
 * @author Cimon Avaro
 */
$messages['fi'] = array(
	'checkuser-summary'          => 'Tämän työkalun avulla voidaan tutkia tuoreet muutokset ja paljastaa käyttäjien IP-osoitteet tai noutaa IP-osoitteiden muokkaukset ja käyttäjätiedot.
	Käyttäjät ja muokkaukset voidaan hakea myös uudelleenohjausosoitteen (X-Forwarded-For) takaa käyttämällä IP-osoitteen perässä <tt>/xff</tt> -merkintää. Työkalu tukee sekä IPv4 (CIDR 16–32) ja IPv6 (CIDR 64–128) -standardeja.',
	'checkuser-desc'             => 'Antaa oikeutetuille käyttäjille mahdollisuuden tarkistaa käyttäjän IP-osoitteet ja muita tietoja.',
	'checkuser-logcase'          => 'Haku lokista on kirjainkokoriippuvainen.',
	'checkuser'                  => 'Osoitepaljastin',
	'group-checkuser'            => 'osoitepaljastimen käyttäjät',
	'group-checkuser-member'     => 'osoitepaljastimen käyttäjä',
	'grouppage-checkuser'        => '{{ns:project}}:Osoitepaljastin',
	'checkuser-reason'           => 'Syy',
	'checkuser-showlog'          => 'Näytä loki',
	'checkuser-log'              => 'Osoitepaljastinloki',
	'checkuser-query'            => 'Hae tuoreet muutokset',
	'checkuser-target'           => 'Käyttäjä tai IP-osoite',
	'checkuser-users'            => 'Hae käyttäjät',
	'checkuser-edits'            => 'Hae IP-osoitteen muokkaukset',
	'checkuser-ips'              => 'Hae IP-osoitteet',
	'checkuser-search'           => 'Etsi',
	'checkuser-empty'            => 'Ei lokitapahtumia.',
	'checkuser-nomatch'          => 'Hakuehtoihin sopivia tuloksia ei löytynyt.',
	'checkuser-check'            => 'Tarkasta',
	'checkuser-log-fail'         => 'Lokitapahtuman lisäys epäonnistui',
	'checkuser-nolog'            => 'Lokitiedostoa ei löytynyt.',
	'checkuser-blocked'          => 'Estetty',
	'checkuser-too-many'         => 'Liian monta tulosta, rajoita IP-osoitetta:',
	'checkuser-user-nonexistent' => 'Määritettyä käyttäjää ei ole olemassa.',
	'checkuser-search-form'      => 'Etsi lokimerkintöjä, joissa $1 on $2',
	'checkuser-search-submit'    => 'Hae',
	'checkuser-search-initiator' => 'alullepanija',
	'checkuser-search-target'    => 'kohde',
	'checkuser-log-subpage'      => 'Loki',
	'checkuser-log-return'       => 'Palaa osoitepaljastimen päälomakkeeseen',
	'checkuser-log-userips'      => '$1 haki käyttäjän $2 IP-osoitteet',
	'checkuser-log-ipedits'      => '$1 haki käyttäjän $2 muokkaukset',
	'checkuser-log-ipusers'      => '$1 haki osoitteen $2 käyttämät tunnukset',
	'checkuser-log-ipedits-xff'  => '$1 haki muokkaukset XFF-osoitteesta $2',
	'checkuser-log-ipusers-xff'  => '$1 haki käyttäjät XFF-osoitteesta $2',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'checkuser'              => 'Rannsakanar brúkari',
	'group-checkuser'        => 'Rannsakanar brúkari',
	'group-checkuser-member' => 'Rannsakanar brúkarir',
	'grouppage-checkuser'    => '{{ns:project}}:Rannsakanar brúkari',
	'checkuser-search'       => 'Leita',
);

/** French (Français)
 * @author Grondin
 * @author Sherbrooke
 * @author ChrisPtDe
 * @author IAlex
 */
$messages['fr'] = array(
	'checkuser-summary'          => 'Cet outil parcourt la liste des changements récents à la recherche de l’adresse IP employée par un utilisateur, affiche toutes les éditions d’une adresse IP (même enregistrée), ou liste les comptes utilisés par une adresse IP. Les comptes et les modifications peuvent être trouvés avec une IP XFF si elle finit avec « /xff ». Il est possible d’utiliser les protocoles IPv4 (CIDR 16-32) et IPv6 (CIDR 64-128). Le nombre d’éditions affichables est limité à {{formatnum:5000}} pour des questions de performance du serveur. Veuillez utiliser cet outil dans les limites de la charte d’utilisation.',
	'checkuser-desc'             => 'Donne la possibilité aux personnes dûment autorisées de vérifier les adresses IP des utilisateurs ainsi que d’autres informations les concernant',
	'checkuser-logcase'          => 'La recherche dans le journal est sensible à la casse.',
	'checkuser'                  => 'Vérificateur d’utilisateur',
	'group-checkuser'            => 'Vérificateurs d’utilisateur',
	'group-checkuser-member'     => 'Vérificateur d’utilisateur',
	'right-checkuser'            => "Vérifier l'adresse IP des utilisateurs et autres informations",
	'grouppage-checkuser'        => '{{ns:project}}:Vérificateur d’utilisateur',
	'checkuser-reason'           => 'Motif',
	'checkuser-showlog'          => 'Afficher le journal',
	'checkuser-log'              => 'Journal de vérificateur d’utilisateur',
	'checkuser-query'            => 'Recherche par les changements récents',
	'checkuser-target'           => "Nom d'utilisateur ou adresse IP",
	'checkuser-users'            => 'Obtenir les utilisateurs',
	'checkuser-edits'            => 'Obtenir les modifications de l’adresse IP',
	'checkuser-ips'              => 'Obtenir les adresses IP',
	'checkuser-search'           => 'Recherche',
	'checkuser-empty'            => 'Le journal ne contient aucun article',
	'checkuser-nomatch'          => 'Recherches infructueuses.',
	'checkuser-check'            => 'Recherche',
	'checkuser-log-fail'         => 'Impossible d’ajouter l’entrée du journal.',
	'checkuser-nolog'            => 'Aucune entrée dans le journal',
	'checkuser-blocked'          => 'Bloqué',
	'checkuser-too-many'         => 'Trop de résultats. Veuillez limiter la recherche sur les adresses IP :',
	'checkuser-user-nonexistent' => "L’utilisateur indiqué n'existe pas",
	'checkuser-search-form'      => 'Chercher le journal des entrées où $1 est $2.',
	'checkuser-search-submit'    => 'Rechercher',
	'checkuser-search-initiator' => 'l’initiateur',
	'checkuser-search-target'    => 'la cible',
	'checkuser-ipeditcount'      => '~$1 pour tous les utilisateurs',
	'checkuser-log-subpage'      => 'Journal',
	'checkuser-log-return'       => "Retourner au formulaire principal de la vérification d'utilisateur",
	'checkuser-log-userips'      => '$1 a obtenu des IP pour $2',
	'checkuser-log-ipedits'      => '$1 a obtenu des modifications pour $2',
	'checkuser-log-ipusers'      => '$1 a obtenu des utilisateurs pour $2',
	'checkuser-log-ipedits-xff'  => '$1 a obtenu des modifications pour XFF  $2',
	'checkuser-log-ipusers-xff'  => '$1 a obtenu des utilisateurs pour XFF $2',
);

/** Cajun French (Français cadien)
 * @author JeanVoisin
 */
$messages['frc'] = array(
	'checkuser-summary'      => "Cet outil observe les derniers changements pour retirer le IP de l'useur ou pour montrer l'information de l'editeur/de l'useur pour cet IP. Les userus et les changements par le IP d'un client pouvont être reçus par les en-têtes XFF par additionner le IP avec \"/xff\". Ipv4 (CIDR 16-32) and IPv6 (CIDR 64-128) sont supportés. Cet outil retourne pas plus que 5000 changements par rapport à la qualité d'ouvrage.  Usez ça ici en accord avec les régluations.",
	'checkuser-logcase'      => 'La charche des notes est sensible aux lettres basses ou hautes.',
	'checkuser'              => "'Gardez-voir à l'useur encore",
	'group-checkuser'        => "'Gardez-voir aux useurs encore",
	'group-checkuser-member' => "'Gardez-voir à l'useur encore",
	'grouppage-checkuser'    => "{{ns:project}}:'Gardez-voir à l'useur encore",
	'checkuser-reason'       => 'Raison',
	'checkuser-showlog'      => 'Montrer les notes',
	'checkuser-log'          => "Notes de la Garde d'useur",
	'checkuser-query'        => 'Charchez les nouveaux changements',
	'checkuser-target'       => "Nom de l'useur ou IP",
	'checkuser-users'        => 'Obtenir les useurs',
	'checkuser-edits'        => 'Obtenir les modifications du IP',
	'checkuser-ips'          => 'Obtenir les adresses IP',
	'checkuser-search'       => 'Charche',
	'checkuser-empty'        => 'Les notes sont vides.',
	'checkuser-nomatch'      => 'Rien pareil trouvé.',
	'checkuser-check'        => 'Charche',
	'checkuser-log-fail'     => "Pas capable d'additionner la note",
	'checkuser-nolog'        => 'Rien trouvé dans les notes.',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'checkuser-summary'          => 'Ceti outil parcôrt la lista des dèrriérs changements a la rechèrche de l’adrèce IP empleyê per un utilisator, afiche totes les èdicions d’una adrèce IP (méma enregistrâ), ou ben liste los comptos utilisâs per una adrèce IP.
	Los comptos et les modificacions pôvont étre trovâs avouéc una IP XFF se sè chavone avouéc « /xff ». O est possiblo d’utilisar los protocolos IPv4 (CIDR 16-32) et IPv6 (CIDR 64-128).
	Lo nombro d’èdicions afichâbles est limitâ a {{formatnum:5000}} por des quèstions de pèrformence du sèrvior. Volyéd utilisar ceti outil dens les limites de la chârta d’usâjo.',
	'checkuser-desc'             => 'Balye la possibilitât a les gens qu’ont la pèrmission que vat avouéc de controlar les adrèces IP des utilisators et pués d’ôtres enformacions los regardent.',
	'checkuser-logcase'          => 'La rechèrche dens lo jornal est sensibla a la câssa.',
	'checkuser'                  => 'Controlor d’utilisator',
	'group-checkuser'            => 'Controlors d’utilisator',
	'group-checkuser-member'     => 'Controlor d’utilisator',
	'grouppage-checkuser'        => '{{ns:project}}:Controlors d’utilisator',
	'checkuser-reason'           => 'Rêson',
	'checkuser-showlog'          => 'Afichiér lo jornal',
	'checkuser-log'              => 'Jornal de controlor d’utilisator',
	'checkuser-query'            => 'Rechèrche per los dèrriérs changements',
	'checkuser-target'           => 'Nom d’utilisator ou adrèce IP',
	'checkuser-users'            => 'Obtegnir los utilisators',
	'checkuser-edits'            => 'Obtegnir les modificacions de l’adrèce IP',
	'checkuser-ips'              => 'Obtegnir les adrèces IP',
	'checkuser-search'           => 'Rechèrche',
	'checkuser-empty'            => 'Lo jornal contint gins d’articllo.',
	'checkuser-nomatch'          => 'Rechèrches que balyont ren.',
	'checkuser-check'            => 'Rechèrche',
	'checkuser-log-fail'         => 'Empossiblo d’apondre l’entrâ du jornal.',
	'checkuser-nolog'            => 'Niona entrâ dens lo jornal.',
	'checkuser-blocked'          => 'Blocâ',
	'checkuser-too-many'         => 'Trop de rèsultats. Volyéd limitar la rechèrche sur les adrèces IP :',
	'checkuser-user-nonexistent' => 'L’utilisator endicâ ègziste pas.',
	'checkuser-search-form'      => 'Chèrchiér lo jornal de les entrâs yô que $1 est $2.',
	'checkuser-search-submit'    => 'Rechèrchiér',
	'checkuser-search-initiator' => 'l’iniciator',
	'checkuser-search-target'    => 'la ciba',
	'checkuser-log-subpage'      => 'Jornal',
	'checkuser-log-return'       => 'Tornar u formulèro principâl du contrôlo d’utilisator',
	'checkuser-log-userips'      => '$1 at obtegnu des IP por $2',
	'checkuser-log-ipedits'      => '$1 at obtegnu des modificacions por $2',
	'checkuser-log-ipusers'      => '$1 at obtegnu des utilisators por $2',
	'checkuser-log-ipedits-xff'  => '$1 at obtegnu des modificacions por XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 at obtegnu des utilisators por XFF $2',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'checkuser-summary'  => 'Scanann an uirlis seo na athruithe is déanaí chun na seolaidh IP úsáideoira a fháil ná taispeáin na sonraí eagarthóireachta/úsáideoira don seoladh IP.
Is féidir úsáideoirí agus eagarthóireachta mar IP cliant a fháil le ceanntáisc XFF mar an IP a iarcheangail le "/xff". IPv4 (CIDR 16-32) agus IPv6 (CIDR 64-128) atá tacaíocht.
Le fáth feidhmiúcháin, ní féidir níos mó ná 5000 eagarthóireachta a thabhairt ar ais ar an am cheana. Déan úsáid de réir polsaí.',
	'checkuser-logcase'  => 'Tá na logaí seo cásíogair.',
	'checkuser-reason'   => 'Fáth',
	'checkuser-showlog'  => 'Taispeáin logaí',
	'checkuser-log'      => 'Logaí checkuser',
	'checkuser-query'    => 'Iarratais ar athrú úrnua',
	'checkuser-target'   => 'Úsáideoir ná seoladh IP',
	'checkuser-users'    => 'Faigh úsáideoira',
	'checkuser-edits'    => 'Faigh athraigh don seoladh IP seo',
	'checkuser-ips'      => 'Faigh Seolaidh IP',
	'checkuser-search'   => 'Cuardaigh',
	'checkuser-empty'    => 'Níl aon míreanna sa log.',
	'checkuser-nomatch'  => 'Ní faigheann aon comhoiriúnaigh.',
	'checkuser-check'    => 'Iarratais',
	'checkuser-log-fail' => 'Ní féidir iontráil a cur sa log',
	'checkuser-nolog'    => 'Ní bhfaigheann comhad loga.',
	'checkuser-blocked'  => 'Cosanta',
	'checkuser-too-many' => "Tá le mórán torthaí, caolaigh an CIDR le d'thoil. Seo iad na seolaidh IP (5000 uasta, sórtáilte le seoladh):",
);

/** Galician (Galego)
 * @author Alma
 * @author Xosé
 * @author Toliño
 */
$messages['gl'] = array(
	'checkuser-summary'          => 'Esta ferramenta analiza os cambios recentes para recuperar os enderezos IPs utilizados por un usuario ou amosar as edicións / datos do usuario dun enderezo de IP.
Os usuarios e as edicións por un cliente IP poden ser recuperados a través das cabeceiras XFF engadindo o enderezo IP con "/ xff". IPv4 (CIDR 16-32) e o IPv6 (CIDR 64-128) están soportadas.',
	'checkuser-desc'             => 'Garante que usuarios cos permisos apropiados poidan comprobar os enderezos IP dos usuarios e acceder a outra información',
	'checkuser-logcase'          => 'O rexistro de búsqueda é sensíbel a maiúsculas e minúsculas.',
	'checkuser'                  => 'Verificador de usuarios',
	'group-checkuser'            => 'Verificadores de usuarios',
	'group-checkuser-member'     => 'Verificador usuarios',
	'right-checkuser'            => 'Comprobar os enderezos IP dos usuarios e outra información',
	'grouppage-checkuser'        => '{{ns:project}}:Verificador de usuarios',
	'checkuser-reason'           => 'Razón',
	'checkuser-showlog'          => 'Amosar rexistro',
	'checkuser-log'              => 'Rexistro de verificador de usuarios',
	'checkuser-query'            => 'Consulta de cambios recentes',
	'checkuser-target'           => 'Usuario ou enderezo IP',
	'checkuser-users'            => 'Obter usuarios',
	'checkuser-edits'            => 'Obter edicións de enderezos IP',
	'checkuser-ips'              => 'Conseguir enderezos IPs',
	'checkuser-search'           => 'Procurar',
	'checkuser-empty'            => 'O rexistro non contén artigos.',
	'checkuser-nomatch'          => 'Non se atoparon coincidencias.',
	'checkuser-check'            => 'Comprobar',
	'checkuser-log-fail'         => 'Non é posíbel engadir unha entrada no rexistro',
	'checkuser-nolog'            => 'Ningún arquivo de rexistro.',
	'checkuser-blocked'          => 'Bloqueado',
	'checkuser-too-many'         => 'Hai demasiados resultados, restrinxa o enderezo IP:',
	'checkuser-user-nonexistent' => 'Non existe o usuario especificado.',
	'checkuser-search-form'      => 'Atopar entradas do rexistro nas que $1 é $2',
	'checkuser-search-submit'    => 'Procurar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target'    => 'destino',
	'checkuser-ipeditcount'      => '~$1 de todos os usuarios',
	'checkuser-log-subpage'      => 'Rexistro',
	'checkuser-log-return'       => 'Voltar ao formulario principal de verificador de usuarios',
	'checkuser-log-userips'      => '$1 obteu os enderezos IP de "$2"',
	'checkuser-log-ipedits'      => '$1 obteu as edicións de "$2"',
	'checkuser-log-ipusers'      => '$1 obteu os usuarios de "$2"',
	'checkuser-log-ipedits-xff'  => '$1 obteu as edicións de XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 obteu os usuarios de XFF $2',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author SPQRobin
 */
$messages['grc'] = array(
	'checkuser-search' => 'Ζητεῖν',
);

/** Gujarati (ગુજરાતી)
 * @author SPQRobin
 */
$messages['gu'] = array(
	'checkuser-reason' => 'કારણ',
	'checkuser-search' => 'શોધો',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'checkuser-reason'        => 'Fa',
	'checkuser-search'        => 'Ronsaghey',
	'checkuser-search-submit' => 'Ronsaghey',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'checkuser-search'        => 'Chhìm-cháu',
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
 * @author Siebrand
 */
$messages['he'] = array(
	'checkuser-summary'          => 'כלי זה סורק את השינויים האחרונים במטרה למצוא את כתובות ה־IP שהשתמש בהן משתמש מסוים או כדי להציג את כל המידע על המשתמשים שהשתמשו בכתובת IP ועל העריכות שבוצעו ממנה.
ניתן לקבל עריכות ומשתמשים מכתובות IP של הכותרת X-Forwarded-For באמצעות הוספת הטקסט "/xff" לסוף הכתובת. הן כתובות IPv4 (כלומר, CIDR 16-32) והן כתובות IPv6 (כלומר, CIDR 64-128) נתמכות.
לא יוחזרו יותר מ־5000 עריכות מסיבות של עומס על השרתים. אנא השתמשו בכלי זה בהתאם למדיניות.',
	'checkuser-desc'             => 'מאפשר למשתמשים עם ההרשאות המתאימות לבדוק את כתובת ה־IP של משתמשים',
	'checkuser-logcase'          => 'החיפוש ביומנים הוא תלוי־רישיות.',
	'checkuser'                  => 'בדיקת משתמש',
	'group-checkuser'            => 'בודקים',
	'group-checkuser-member'     => 'בודק',
	'right-checkuser'            => 'מציאת כתובות IP של משתמשים ומידע נוסף',
	'grouppage-checkuser'        => '{{ns:project}}:בודק',
	'checkuser-reason'           => 'סיבה',
	'checkuser-showlog'          => 'הצגת יומן',
	'checkuser-log'              => 'יומן בדיקות',
	'checkuser-query'            => 'בדיקת שינויים אחרונים',
	'checkuser-target'           => 'שם משתמש או כתובת IP',
	'checkuser-users'            => 'הצגת משתמשים',
	'checkuser-edits'            => 'הצגת עריכות מכתובת IP מסוימת',
	'checkuser-ips'              => 'הצגת כתובות IP',
	'checkuser-search'           => 'חיפוש',
	'checkuser-empty'            => 'אין פריטים ביומן.',
	'checkuser-nomatch'          => 'לא נמצאו התאמות.',
	'checkuser-check'            => 'בדיקה',
	'checkuser-log-fail'         => 'לא ניתן היה להוסיף פריט ליומן',
	'checkuser-nolog'            => 'לא נמצא קובץ יומן.',
	'checkuser-blocked'          => 'חסום',
	'checkuser-too-many'         => 'נמצאו תוצאות רבות מדי, אנא צמצו את טווח כתובות ה־IP. להלן כתובת ה־IP שנעשה בהן שימוש (מוצגות 5,000 לכל היותר, וממוינות):',
	'checkuser-user-nonexistent' => 'המשתמש לא נמצא.',
	'checkuser-search-form'      => 'מציאת ערכים ביומן שבהם ה$1 הוא $2',
	'checkuser-search-submit'    => 'חיפוש',
	'checkuser-search-initiator' => 'בודק',
	'checkuser-search-target'    => 'נבדק',
	'checkuser-ipeditcount'      => 'בערך $1 מכל המשתמשים',
	'checkuser-log-subpage'      => 'יומן',
	'checkuser-log-return'       => 'חזרה לטופס הבדיקה הכללי',
	'checkuser-log-userips'      => '$1 בדק את כתובות ה־IP של $2',
	'checkuser-log-ipedits'      => '$1 בדק את העריכות של $2',
	'checkuser-log-ipusers'      => '$1 בדק את המשתמשים של $2',
	'checkuser-log-ipedits-xff'  => '$1 בדק את העריכות של כתובת ה־XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 בדק את המשתמשים של כתובת ה־XFF $2',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'checkuser-summary'          => 'यह उपकरण एक सदस्य द्वारा हाल में किये गए परिवर्तनों के लिए काम में ली गई सारी IPs को जांचता है, अथवा एक IP का उपयोग करने वाले सभी सदस्यों को जांचता है।
एक मुवक्किल IP द्वारा किया गए संपादन एवं प्रयोग में ले रहे सभी सदस्यों को "/xff" से IP को जोड़ते हुए XFF शीर्षक के माध्यम से पता लगता है। IPv4 (CIDR 16-32) और IPv6 (CIDR 64-128) द्वारा प्रमाणित है।
प्रदर्शन के कारण कि वजह से ५००० सम्पादानों से ज्यादा नहीं दिखा पायेगा।
इसे नीति के अनुसार प्रयोग करें।',
	'checkuser-desc'             => 'सदस्यको अन्य सदस्योंके आईपी एड्रेस एवम्‌ अन्य ज़ानकारी देखने की अनुमति देता हैं।',
	'checkuser-logcase'          => 'लॉगमें खोज लिपी पर आधारित (case sensitive) हैं।',
	'checkuser'                  => 'सदस्य जाँच',
	'group-checkuser'            => 'सदस्य जाँचे',
	'group-checkuser-member'     => 'सदस्य जाँच',
	'right-checkuser'            => 'सदस्य का आइपी एड्रेस एवम्‌ अन्य ज़ानकारी जाँचें',
	'grouppage-checkuser'        => '{{ns:project}}: सदस्य जाँच',
	'checkuser-reason'           => 'कारण',
	'checkuser-showlog'          => 'लॉग दिखायें',
	'checkuser-log'              => 'सदस्यजाँच लॉग',
	'checkuser-query'            => 'हाल में हुए बदलाव देखें',
	'checkuser-target'           => 'सदस्य या आईपी',
	'checkuser-users'            => 'सदस्य खोजें',
	'checkuser-edits'            => 'आईपीसे हुए बदलाव खोजें',
	'checkuser-ips'              => 'आईपी खोजें',
	'checkuser-search'           => 'खोजें',
	'checkuser-empty'            => 'इस लॉगमें एकभी आइटेम नहीं हैं।',
	'checkuser-nomatch'          => 'मिलते जुलते लॉग मिले नहीं।',
	'checkuser-check'            => 'जाँचें',
	'checkuser-log-fail'         => 'लॉग एन्ट्री बढा नहीं पायें।',
	'checkuser-nolog'            => 'लॉग फ़ाईल मिली नहीं।',
	'checkuser-blocked'          => 'ब्लॉक किया हुआ हैं',
	'checkuser-too-many'         => 'बहुत सारे रिज़ल्ट, कृपया CIDRमें बदलाव करें।
नीचे इस्तेमाल हुए आईपी की सूची हैं (ज्यादा से ज्यादा ५०००, अनुक्रममें):',
	'checkuser-user-nonexistent' => 'दिया हुआ सदस्यनाम अस्तित्वमें नहीं हैं।',
	'checkuser-search-form'      => 'ऐसे लॉग खोजें जहां $1 यह $2 हैं',
	'checkuser-search-submit'    => 'खोजें',
	'checkuser-search-initiator' => 'चालक',
	'checkuser-search-target'    => 'लक्ष्य',
	'checkuser-ipeditcount'      => '~$1 सभी सदस्योंसे',
	'checkuser-log-subpage'      => 'लॉग',
	'checkuser-log-return'       => 'सदस्यजाँच मुखपृष्ठपर वापस जायें',
	'checkuser-log-userips'      => '$1 के पास $2 के लिये आईपी हैं',
	'checkuser-log-ipedits'      => '$1 के पास $2 के लिये बदलाव हैं',
	'checkuser-log-ipusers'      => '$1 के पास $2 के लिये सदस्य हैं',
	'checkuser-log-ipedits-xff'  => '$1 के पास $2 के लिये XFF बदलाव हैं',
	'checkuser-log-ipusers-xff'  => '$1 के पास $2 के लिये XFF सदस्य हैं',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'checkuser-reason'        => 'Rason',
	'checkuser-search'        => 'Pangita-a',
	'checkuser-search-submit' => 'Pangita-a',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'checkuser-summary'          => 'Ovaj alat pretražuje nedavne promjene i pronalazi IP adrese suradnika ili prikazuje uređivanja/ime suradnika ako je zadana IP adresa. Suradnici i uređivanja mogu biti dobiveni po XFF zaglavljima dodavanjem "/xff" na kraj IP adrese. Podržane su IPv4 (CIDR 16-32) i IPv6 (CIDR 64-128) adrese. Rezultat ima maksimalno 5.000 zapisa iz tehničkih razloga. Rabite ovaj alat u skladu s pravilima.',
	'checkuser-desc'             => 'Daje suradniku pravo za provjeriti IP adrese suradnika i druge informacije',
	'checkuser-logcase'          => 'Provjera evidencije razlikuje velika i mala slova',
	'checkuser'                  => 'Provjeri suradnika',
	'group-checkuser'            => 'Check users',
	'group-checkuser-member'     => 'Check user',
	'right-checkuser'            => 'Provjeravanje IP adrese suradnika i drugih informacija',
	'grouppage-checkuser'        => '{{ns:project}}:Checkuser',
	'checkuser-reason'           => 'Razlog',
	'checkuser-showlog'          => 'Pokaži evidenciju',
	'checkuser-log'              => 'Checkuser evidencija',
	'checkuser-query'            => 'Provjeri nedavne promjene',
	'checkuser-target'           => 'Suradnik ili IP',
	'checkuser-users'            => 'suradničko ime',
	'checkuser-edits'            => 'uređivanja tog IP-a',
	'checkuser-ips'              => 'Nađi IP adrese',
	'checkuser-search'           => 'Traži',
	'checkuser-empty'            => 'Evidencija je prazna.',
	'checkuser-nomatch'          => 'Nema suradnika s tom IP adresom.',
	'checkuser-check'            => 'Provjeri',
	'checkuser-log-fail'         => 'Ne mogu dodati zapis',
	'checkuser-nolog'            => 'Evidencijska datoteka nije nađena',
	'checkuser-blocked'          => 'Blokiran',
	'checkuser-too-many'         => 'Previše rezultata, molimo suzite opseg (CIDR). Slijede rabljene IP adrese (najviše njih 5000, poredano abecedno):',
	'checkuser-user-nonexistent' => 'Traženi suradnik (suradničko ime) ne postoji.',
	'checkuser-search-form'      => 'Nađi zapise u evidenciji gdje $1 je $2',
	'checkuser-search-submit'    => 'Traži',
	'checkuser-search-initiator' => 'pokretač',
	'checkuser-search-target'    => 'cilj (traženi pojam)',
	'checkuser-ipeditcount'      => '~$1 od svih suradnika',
	'checkuser-log-subpage'      => 'Evidencija',
	'checkuser-log-return'       => 'Vrati se na glavnu formu za provjeru',
	'checkuser-log-userips'      => '$1 tražio je IP adrese suradnika $2',
	'checkuser-log-ipedits'      => '$1 tražio je uređivanja suradnika $2',
	'checkuser-log-ipusers'      => '$1 tražio je suradnička imena za IP adresu $2',
	'checkuser-log-ipedits-xff'  => '$1 tražio je uređivanja za XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 tražio je imena suradnika za XFF $2',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'checkuser-summary'          => 'Tutón nastroj přepytuje aktualne změny, zo by IP-adresy wužiwarja zwěsćił abo změny abo wužiwarske daty za IP pokazał.
Wužiwarjo a změny IP-adresy dadźa so přez XFF-hłowy wotwołać, připowěšo "/xff" na IP-adresu. IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128) so podpěrujetej.',
	'checkuser-desc'             => 'Dawa wužiwarjam z trěbnym prawom móžnosć IP-adresy a druhe informacije wužiwarja kontrolować',
	'checkuser-logcase'          => 'Pytanje w protokolu rozeznawa mjez wulko- a małopisanjom.',
	'checkuser'                  => 'Wužiwarja kontrolować',
	'group-checkuser'            => 'Kontrolerojo',
	'group-checkuser-member'     => 'Kontroler',
	'right-checkuser'            => 'Pruwowanje IP-adresow a druhe informacije wužiwarjow',
	'grouppage-checkuser'        => '{{ns:project}}:Checkuser',
	'checkuser-reason'           => 'Přičina',
	'checkuser-showlog'          => 'Protokol pokazać',
	'checkuser-log'              => 'Protokol wužiwarskeje kontrole',
	'checkuser-query'            => 'Poslednje změny wotprašeć',
	'checkuser-target'           => 'Wužiwar abo IP-adresa',
	'checkuser-users'            => 'Wužiwarjow pokazać',
	'checkuser-edits'            => 'Změny z IP-adresy přinjesć',
	'checkuser-ips'              => 'IP-adresy pokazać',
	'checkuser-search'           => 'Pytać',
	'checkuser-empty'            => 'Protokol njewobsahuje zapiski.',
	'checkuser-nomatch'          => 'Žane wotpowědniki namakane.',
	'checkuser-check'            => 'Pruwować',
	'checkuser-log-fail'         => 'Njemóžno protokolowy zapisk přidać.',
	'checkuser-nolog'            => 'Žadyn protokol namakany.',
	'checkuser-blocked'          => 'Zablokowany',
	'checkuser-too-many'         => 'Přewjele wuslědkow, prošu zamjezuj IP-adresu:',
	'checkuser-user-nonexistent' => 'Podaty wužiwar njeeksistuje.',
	'checkuser-search-form'      => 'Protokolowe zapiski namakać, hdźež $1 je $2',
	'checkuser-search-submit'    => 'Pytać',
	'checkuser-search-initiator' => 'iniciator',
	'checkuser-search-target'    => 'cil',
	'checkuser-ipeditcount'      => '~$1 wot wšěch wužiwarjow',
	'checkuser-log-subpage'      => 'Protokol',
	'checkuser-log-return'       => 'Wróćo k hłownemu formularej CheckUser',
	'checkuser-log-userips'      => '$1 dósta IP za $2',
	'checkuser-log-ipedits'      => '$1 dósta změny za $2',
	'checkuser-log-ipusers'      => '$1 dósta wužiwarjow za $2',
	'checkuser-log-ipedits-xff'  => '$1 dósta změny za XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 dósta wužiwarjow za XFF $2',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 * @author Dorgan
 * @author Tgr
 * @author Grin
 */
$messages['hu'] = array(
	'checkuser-summary'          => 'Ez az eszköz végigvizsgálja a friss változásokat, hogy lekérje egy adott felhasználó IP-címeit vagy megjelenítse egy adott IP-címet használó szerkesztőket és az IP szerkesztéseit.
Egy kliens IP-cím által végzett szerkesztések és felhasználói XFF fejlécek segítségével kérhetőek le, az IP-cím utáni „/xff” parancssal. Az IPv4 (CIDR 16-32) és az IPv6 (CIDR 64-128) is támogatott.
Maximum 5000 szerkesztés fog megjelenni teljesítményi okok miatt. Az eszközt a szabályoknak megfelelően használd.',
	'checkuser-desc'             => 'Lehetővé teszi olyan felhasználói jogok kiosztását, mely segítségével megtekinthetőek a felhasználók IP-címei és más adatok',
	'checkuser-logcase'          => 'A kereső kis- és nagybetűérzékeny.',
	'checkuser'                  => 'IP-ellenőr',
	'group-checkuser'            => 'IP-ellenőrök',
	'group-checkuser-member'     => 'IP-ellenőr',
	'right-checkuser'            => 'a felhasználók IP-címének és más adatainak ellenőrzése',
	'grouppage-checkuser'        => '{{ns:project}}:IP-ellenőrök',
	'checkuser-reason'           => 'Ok',
	'checkuser-showlog'          => 'Napló megjelenítése',
	'checkuser-log'              => 'IP-ellenőr-napló',
	'checkuser-query'            => 'Kétséges aktuális változások',
	'checkuser-target'           => 'Felhasználó vagy IP-cím',
	'checkuser-users'            => 'Felhasználók keresése',
	'checkuser-edits'            => 'Szerkesztések keresése IP-cím alapján',
	'checkuser-ips'              => 'IP-címek keresése',
	'checkuser-search'           => 'Keresés',
	'checkuser-empty'            => 'A napló nem tartalmaz elemeket.',
	'checkuser-nomatch'          => 'A párja nem található.',
	'checkuser-check'            => 'Ellenőrzés',
	'checkuser-log-fail'         => 'Nem sikerült az elem hozzáadása',
	'checkuser-nolog'            => 'A naplófájl nem található.',
	'checkuser-blocked'          => 'Blokkolva',
	'checkuser-too-many'         => 'Túl sok eredmény, kérlek szűkítsd le a CIDR-t. Itt vannak a használt IP-címek (maximum 5000, cím alapján rendezve):',
	'checkuser-user-nonexistent' => 'A megadott szerkesztő nem létezik.',
	'checkuser-search-form'      => 'Naplóbejegyzések keresése, ahol $1 $2',
	'checkuser-search-submit'    => 'Keresés',
	'checkuser-search-initiator' => 'kezdeményező',
	'checkuser-search-target'    => 'Cél',
	'checkuser-ipeditcount'      => '~$1 az összes szerkesztő által',
	'checkuser-log-subpage'      => 'Lista',
	'checkuser-log-return'       => 'Vissza az IP-ellenőri oldalra',
	'checkuser-log-userips'      => '$1 lekérte $2 IP-címeit',
	'checkuser-log-ipedits'      => '$1 lekérte $2 szerkesztéseit',
	'checkuser-log-ipusers'      => '$1 lekérte a(z) $2 IP-címhez tarzozó szerkesztőket',
	'checkuser-log-ipedits-xff'  => '$1 lekérte XFF $2 szerkesztéseit',
	'checkuser-log-ipusers-xff'  => '$1 lekérte XFF $2 szerkesztőit',
);

/** Armenian (Հայերեն)
 * @author Togaed
 */
$messages['hy'] = array(
	'checkuser-search'        => 'Որոնել',
	'checkuser-search-submit' => 'Որոնել',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'checkuser-summary'          => 'Iste instrumento analysa le modificationes recente pro recuperar le adresses IP usate per un usator o pro monstrar le datos de modificationes e de usatores pro un adresse IP.
Le usatores e modificationes facite desde un adresse IP de cliente pote esser recuperate via capites XFF per appender "/xff" al IP.
Es supportate le adresses IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
Non plus de 5000 modificationes essera retornate pro motivos de prestationes.
Tote uso de iste instrumento debe esser conforme al politicas in vigor.',
	'checkuser-desc'             => 'Concede al usatores con le autorisation appropriate le capabilitate de verificar le adresses IP e altere informationes de usatores',
	'checkuser-logcase'          => 'Le recerca del registros distingue inter majusculas e minusculas.',
	'checkuser'                  => 'Verificar usator',
	'group-checkuser'            => 'Verificar usatores',
	'group-checkuser-member'     => 'Verificar usator',
	'right-checkuser'            => 'Verificar le adresses IP e altere informationes del usator',
	'grouppage-checkuser'        => '{{ns:project}}:Verificar usator',
	'checkuser-reason'           => 'Motivo',
	'checkuser-showlog'          => 'Monstrar registro',
	'checkuser-log'              => 'Registro de verification de usatores',
	'checkuser-query'            => 'Consultar le modificationes recente',
	'checkuser-target'           => 'Usator o IP',
	'checkuser-users'            => 'Cercar usatores',
	'checkuser-edits'            => 'Cercar modificationes desde IP',
	'checkuser-ips'              => 'Cercar IPs',
	'checkuser-search'           => 'Cercar',
	'checkuser-empty'            => 'Le registro non contine entratas.',
	'checkuser-nomatch'          => 'Nihil trovate.',
	'checkuser-check'            => 'Verificar',
	'checkuser-log-fail'         => 'Impossibile adder entrata al registro',
	'checkuser-nolog'            => 'Nulle file de registro trovate.',
	'checkuser-blocked'          => 'Blocate',
	'checkuser-too-many'         => 'Troppo de resultatos. Per favor restringe le CIDR.
Ecce le IPs usate (5000 max, ordinate per adresse):',
	'checkuser-user-nonexistent' => 'Le usator specificate non existe.',
	'checkuser-search-form'      => 'Cercar entratas in le registro ubi le $1 es $2',
	'checkuser-search-submit'    => 'Cercar',
	'checkuser-search-initiator' => 'initiator',
	'checkuser-search-target'    => 'objectivo',
	'checkuser-ipeditcount'      => '~$1 de tote le usatores',
	'checkuser-log-subpage'      => 'Registro',
	'checkuser-log-return'       => 'Retornar al formulario principal del verification de usatores',
	'checkuser-log-userips'      => '$1 obteneva IPs pro $2',
	'checkuser-log-ipedits'      => '$1 obteneva modificationes pro $2',
	'checkuser-log-ipusers'      => '$1 obteneva usatores pro $2',
	'checkuser-log-ipedits-xff'  => '$1 obteneva modificationes pro XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 obteneva usatores pro XFF $2',
);

/** Indonesian (Bahasa Indonesia)
 * @author Borgx
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'checkuser-summary'          => 'Peralatan ini memindai perubahan terbaru untuk mendapatkan IP yang digunakan oleh seorang pengguna atau menunjukkan data suntingan/pengguna untuk suatu IP.
	Pengguna dan suntingan dapat diperoleh dari suatu IP XFF dengan menambahkan "/xff" pada suatu IP. IPv4 (CIDR 16-32) dan IPv6 (CIDR 64-128) dapat digunakan.
	Karena alasan kinerja, maksimum hanya 5000 suntingan yang dapat diambil. Harap gunakan peralatan ini sesuai dengan kebijakan yang ada.',
	'checkuser-desc'             => 'Memberikan fasilitas bagi pengguna yang memiliki hak akses untuk memeriksa alamat IP dan informasi lain dari pengguna',
	'checkuser-logcase'          => 'Log ini bersifat sensitif terhadap kapitalisasi.',
	'checkuser'                  => 'Pemeriksaan pengguna',
	'group-checkuser'            => 'Pemeriksa',
	'group-checkuser-member'     => 'Pemeriksa',
	'right-checkuser'            => 'Periksa alamat IP pengguna dan informasi lainnya',
	'grouppage-checkuser'        => '{{ns:project}}:Pemeriksa',
	'checkuser-reason'           => 'Alasan',
	'checkuser-showlog'          => 'Tampilkan log',
	'checkuser-log'              => 'Log pemeriksaan pengguna',
	'checkuser-query'            => 'Kueri perubahan terbaru',
	'checkuser-target'           => 'Pengguna atau IP',
	'checkuser-users'            => 'Cari pengguna',
	'checkuser-edits'            => 'Cari suntingan dari IP',
	'checkuser-ips'              => 'Cari IP',
	'checkuser-search'           => 'Cari',
	'checkuser-empty'            => 'Log kosong.',
	'checkuser-nomatch'          => 'Data yang sesuai tidak ditemukan.',
	'checkuser-check'            => 'Periksa',
	'checkuser-log-fail'         => 'Entri log tidak dapat ditambahkan',
	'checkuser-nolog'            => 'Berkas log tidak ditemukan.',
	'checkuser-blocked'          => 'Diblok',
	'checkuser-too-many'         => 'Terlalu banyak hasil pencarian, mohon persempit CIDR. Berikut adalah alamat-alamat IP yang digunakan (5000 maks, diurut berdasarkan alamat):',
	'checkuser-user-nonexistent' => 'Pengguna tidak eksis',
	'checkuser-search-form'      => 'Cari catatan log dimana $1 adalah $2',
	'checkuser-search-submit'    => 'Cari',
	'checkuser-search-initiator' => 'pemeriksa',
	'checkuser-search-target'    => 'target',
	'checkuser-ipeditcount'      => '~$1 dari seluruh pengguna',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Kembali ke halaman utama Pemeriksa',
	'checkuser-log-userips'      => '$1 melihat IP dari $2',
	'checkuser-log-ipedits'      => '$1 melihat suntingan dari $2',
	'checkuser-log-ipusers'      => '$1 melihat nama pengguna dari $2',
	'checkuser-log-ipedits-xff'  => '$1 melihat suntingan dari XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 melihat nama pengguna dari XFF $2',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'checkuser-reason'        => 'Motivo',
	'checkuser-search-submit' => 'Serchar',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author SPQRobin
 * @author Spacebirdy
 */
$messages['is'] = array(
	'checkuser'               => 'Athuga notanda',
	'group-checkuser'         => 'Athuga notendur',
	'group-checkuser-member'  => 'Athuga notanda',
	'checkuser-reason'        => 'Ástæða',
	'checkuser-showlog'       => 'Sýna skrá',
	'checkuser-query'         => 'Sækja nýlegar breytingar',
	'checkuser-target'        => 'Notandi eða vistfang',
	'checkuser-users'         => 'Sækja notendur',
	'checkuser-edits'         => 'Sækja breytingar eftir vistang',
	'checkuser-ips'           => 'Sækja vistföng',
	'checkuser-search'        => 'Leita',
	'checkuser-nomatch'       => 'Engin samsvörun fannst.',
	'checkuser-check'         => 'Athuga',
	'checkuser-nolog'         => 'Engin skrá fundin.',
	'checkuser-blocked'       => 'Bannaður',
	'checkuser-search-submit' => 'Leita',
	'checkuser-log-subpage'   => 'Skrá',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Gianfranco
 * @author .anaconda
 * @author Melos
 */
$messages['it'] = array(
	'checkuser-summary'          => 'Questo strumento analizza le modifiche recenti per recuperare gli indirizzi IP utilizzati da un utente o mostrare contributi e dati di un IP. Utenti e contributi di un client IP possono essere rintracciati attraverso gli header XFF aggiungendo all\'IP il suffisso "/xff". Sono supportati IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). Non saranno restituite più di 5.000 modifiche, per ragioni di prestazioni. Usa questo strumento in stretta conformità alle policy.',
	'checkuser-desc'             => 'Consente agli utenti con le opportune autorizzazioni di sottoporre a verifica gli indirizzi IP e altre informazioni relative agli utenti',
	'checkuser-logcase'          => "La ricerca nei log è ''case sensitive'' (distingue fra maiuscole e minuscole).",
	'checkuser'                  => 'Controllo utenze',
	'group-checkuser'            => 'Controllori',
	'group-checkuser-member'     => 'Controllore',
	'right-checkuser'            => "Visualizza gli indirizzi IP usati dall'utente e altre informazioni",
	'grouppage-checkuser'        => '{{ns:project}}:Controllo utenze',
	'checkuser-reason'           => 'Motivazione',
	'checkuser-showlog'          => 'Mostra il log',
	'checkuser-log'              => 'Log dei checkuser',
	'checkuser-query'            => 'Cerca nelle ultime modifiche',
	'checkuser-target'           => 'Utente o IP',
	'checkuser-users'            => 'Cerca utenti',
	'checkuser-edits'            => 'Vedi i contributi degli IP',
	'checkuser-ips'              => 'Cerca IP',
	'checkuser-search'           => 'Cerca',
	'checkuser-empty'            => 'Il log non contiene dati.',
	'checkuser-nomatch'          => 'Nessun risultato trovato.',
	'checkuser-check'            => 'Controlla',
	'checkuser-log-fail'         => 'Impossibile aggiungere la voce al log',
	'checkuser-nolog'            => 'Non è stato trovato alcun file di log.',
	'checkuser-blocked'          => 'Bloccato',
	'checkuser-too-many'         => 'Il numero di risultati è eccessivo, usare un CIDR più ristretto. Di seguito sono indicati gli indirizzi IP utilizzati (fino a un massimo di 5000, ordinati per indirizzo):',
	'checkuser-user-nonexistent' => "L'utente indicato non esiste.",
	'checkuser-search-form'      => 'Trova le voci del log per le quali $1 è $2',
	'checkuser-search-submit'    => 'Ricerca',
	'checkuser-search-initiator' => 'iniziatore',
	'checkuser-search-target'    => 'obiettivo',
	'checkuser-ipeditcount'      => '~$1 complessivamente',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Torna al modulo principale di Controllo utenze',
	'checkuser-log-userips'      => '$1 ha ottenuto gli indirizzi IP di $2',
	'checkuser-log-ipedits'      => '$1 ha ottenuto le modifiche di $2',
	'checkuser-log-ipusers'      => '$1 ha ottenuto le utenze di $2',
	'checkuser-log-ipedits-xff'  => '$1 ha ottenuto le modifiche di $2 via XFF',
	'checkuser-log-ipusers-xff'  => '$1 ha ottenuto le utenze di $2 via XFF',
);

/** Japanese (日本語)
 * @author JtFuruhata
 * @author Kahusi
 * @author Suisui
 * @author Marine-Blue
 */
$messages['ja'] = array(
	'checkuser-summary'          => 'このツールは最近の更新から行った調査を元に、ある利用者が使用したIPアドレスの検索、または、あるIPアドレスからなされた編集および利用者名の表示を行います。
IPアドレスと共に「/xff」オプションを指定すると、XFF（X-Forwarded-For）ヘッダを通じてクライアントIPアドレスを取得し、そこからなされた編集および利用者名の検索をすることが可能です。
IPv4（16から32ビットのCIDR表記）と IPv6（64から128ビットのCIDR表記）をサポートしています。
パフォーマンス上の理由により、5000件の編集しか返答出来ません。
「チェックユーザーの方針」に従って利用してください。',
	'checkuser-desc'             => '利用者のIPアドレスやその他の情報をチェックする権限をユーザーに付与する',
	'checkuser-logcase'          => 'ログの検索では大文字と小文字を区別します。',
	'checkuser'                  => 'チェックユーザー',
	'group-checkuser'            => 'チェックユーザー',
	'group-checkuser-member'     => 'チェックユーザー',
	'right-checkuser'            => '利用者のIPアドレスやその他の情報を確認する',
	'grouppage-checkuser'        => '{{ns:project}}:チェックユーザー',
	'checkuser-reason'           => '理由',
	'checkuser-showlog'          => 'ログを閲覧',
	'checkuser-log'              => 'チェックユーザー・ログ',
	'checkuser-query'            => '最近の更新を照会',
	'checkuser-target'           => '利用者名又はIPアドレス',
	'checkuser-users'            => '利用者名を得る',
	'checkuser-edits'            => 'IPアドレスからの編集を得る',
	'checkuser-ips'              => 'IPアドレスを得る',
	'checkuser-search'           => '検索',
	'checkuser-empty'            => 'ログ内にアイテムがありません。',
	'checkuser-nomatch'          => '該当するものはありません。',
	'checkuser-check'            => '調査',
	'checkuser-log-fail'         => 'ログに追加することができません',
	'checkuser-nolog'            => 'ログファイルが見つかりません。',
	'checkuser-blocked'          => 'ブロック済み',
	'checkuser-too-many'         => '検索結果が多すぎます、CIDRの指定を小さく絞り込んでください。利用されたIPは以下の通りです（5000件を上限に、アドレス順でソートされています）:',
	'checkuser-user-nonexistent' => '指定されたユーザーは存在しません。',
	'checkuser-search-form'      => 'ログ検索条件　$1 が $2',
	'checkuser-search-submit'    => '検索',
	'checkuser-search-initiator' => 'チェック者',
	'checkuser-search-target'    => 'チェック対象',
	'checkuser-log-subpage'      => 'ログ',
	'checkuser-log-return'       => 'チェックユーザーのメインフォームへ戻る',
	'checkuser-log-userips'      => '$1 は $2 が使用したIPアドレスを取得した',
	'checkuser-log-ipedits'      => '$1 は $2 からなされた編集を取得した',
	'checkuser-log-ipusers'      => '$1 は $2 からアクセスされた利用者名を取得した',
	'checkuser-log-ipedits-xff'  => '$1 は XFF $2 からなされた編集を取得した',
	'checkuser-log-ipusers-xff'  => '$1 は XFF $2 からアクセスされた利用者名を取得した',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'checkuser-summary'          => 'Dette værktøj scanner Seneste ændringer for at finde IP\'er brugt af en bestemt bruger, eller for at vise redigerings- eller brugerdata for en IP.
Bruger og redigeringer fra en klient IP kan hentes via XFF headers ved at tilføje "/xff" til IP\'en. Ipv4 (CIRD 16-32) og IPv6 (CIDR 64-128) er understøttet.
For at sikre programmelets ydeevne kan maksimalt 5000 redigeringer returneres. Brug kun dette værktøj i overensstemmelse med gældende politiker på {{SITENAME}}.',
	'checkuser-desc'             => 'Giver brugere med den rette godkendelse muligheden for at checke brugeres IP-adresser og anden information',
	'checkuser-logcase'          => 'Logsøgning er case sensitiv (der gøres forskel på store og små bogstaver)',
	'checkuser'                  => 'Check user',
	'group-checkuser'            => 'Check users',
	'group-checkuser-member'     => 'Check user',
	'grouppage-checkuser'        => '{{ns:project}}:Check user',
	'checkuser-reason'           => 'Begrundelse',
	'checkuser-showlog'          => "Se'n log",
	'checkuser-log'              => 'CheckUser log',
	'checkuser-query'            => 'Søĝ i seneste ændrenger',
	'checkuser-target'           => 'Bruger æller IP',
	'checkuser-users'            => 'Gæt bruger!',
	'checkuser-edits'            => 'Gæt redigærer IPs!',
	'checkuser-ips'              => 'Gæt IP!',
	'checkuser-search'           => 'Søĝ',
	'checkuser-empty'            => 'Loggen indeholder ingen poster.',
	'checkuser-nomatch'          => 'Ingen matchende resultater blev fundet.',
	'checkuser-check'            => 'Check',
	'checkuser-log-fail'         => 'Kunne ikke tilføje log-post',
	'checkuser-nolog'            => 'Logfilen blev ikke fundet.',
	'checkuser-blocked'          => 'Blokeret',
	'checkuser-too-many'         => "For mange resultater, gør CIDR'en smallere. Her er de brugte IP'er (max 5000, sorteret efter adresse):",
	'checkuser-user-nonexistent' => 'Den anførte bruger eksisterer ikke.',
	'checkuser-search-form'      => 'Find log-poster hvor $1 er $2',
	'checkuser-search-submit'    => 'Søg',
	'checkuser-search-initiator' => 'initiatår',
	'checkuser-search-target'    => 'mål',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Gå tilbage til hovedformularen for checkbruger',
	'checkuser-log-userips'      => "$1 fik IP'er for $2",
	'checkuser-log-ipedits'      => '$1 fik redigeringer for $2',
	'checkuser-log-ipusers'      => '$1 fik brugere for $2',
	'checkuser-log-ipedits-xff'  => '$1 fik redigeringer for XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 fik brugere for XFF $2',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'checkuser-summary'          => 'Piranti iki nlusuri owah-owahan pungkasan kanggo golèk IP sing dienggo déning sawijining panganggo utawa nuduhaké data suntingan/panganggo kanggo sawijining IP.
Panganggo lan suntingan bisa dirunut saka sawijining IP XFF mawa nambahaké "/xff" ing sawijining IP. IPv4 (CIDR 16-32) IPv6 (CIDR 64-128) bisa dienggo.
Amerga déning alesan kinerja, ora luwih saka 5.000 suntingan sing bisa dijupuk. Mangga gunakna piranti iki miturut kawicaksanan sing wis ditetepaké.',
	'checkuser-desc'             => 'Mènèhi panganggo fasilitas kanggo panganggo sing duwé idin kanggo mriksa alamat IP panganggo lan informasi liyané',
	'checkuser-logcase'          => 'Log iki sènsitif marang panrapan aksara gedhé apa cilik',
	'checkuser'                  => 'Pamriksan panganggo',
	'group-checkuser'            => 'Pamriksa panganggo',
	'group-checkuser-member'     => 'Pamriksa panganggo',
	'right-checkuser'            => 'Priksa alamat-alamat IP panganggo lan informasi liyané',
	'grouppage-checkuser'        => '{{ns:project}}:Pamriksa panganggo',
	'checkuser-reason'           => 'Alesan',
	'checkuser-showlog'          => 'Tuduhna log',
	'checkuser-log'              => 'Log pamriksan panganggo',
	'checkuser-query'            => 'Pitakonan owah-owahan pungkasan',
	'checkuser-target'           => 'Panganggo utawa IP',
	'checkuser-users'            => 'Golèk panganggo',
	'checkuser-edits'            => 'Golèk suntingan saka IP',
	'checkuser-ips'              => 'Golèk IP',
	'checkuser-search'           => 'Golèk',
	'checkuser-empty'            => 'Log iki kosong.',
	'checkuser-nomatch'          => 'Ora ana data sing cocog bisa ditemokaké.',
	'checkuser-check'            => 'Priksa',
	'checkuser-log-fail'         => 'Log èntri ora bisa ditambahaké',
	'checkuser-nolog'            => 'Ora ditemokaké berkas log.',
	'checkuser-blocked'          => 'Diblokir',
	'checkuser-too-many'         => 'Kakèhan pituwas, tulung CIDR diciyutaké.
Ing ngisor iki kapacak alamat-alamat IP sing dienggo (maks. 5.000, diurutaké adhedhasar alamat):',
	'checkuser-user-nonexistent' => 'Panganggo iki ora ana.',
	'checkuser-search-form'      => 'Temokna cathetan log ing ngendi $1 iku $2',
	'checkuser-search-submit'    => 'Golèk',
	'checkuser-search-initiator' => 'pamriksa',
	'checkuser-search-target'    => 'tujuan',
	'checkuser-ipeditcount'      => '~$1 saka kabèh panganggo',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Bali menyang kaca utama pamriksa',
	'checkuser-log-userips'      => '$1 ndeleng IP saka $2',
	'checkuser-log-ipedits'      => '$1 ndeleng suntingan saka $2',
	'checkuser-log-ipusers'      => '$1 ndeleng jeneng panganggo saka $2',
	'checkuser-log-ipedits-xff'  => '$1 ndeleng suntingan saka XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 ndeleng jeneng panganggo saka XFF $2',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'checkuser-reason' => 'მიზეზი',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'checkuser-summary'          => 'بۇل قۇرال پايدالانۋشى قولدانعان IP جايلار ٴۇشىن, نەمەسە IP جاي تۇزەتۋ/پايدالانۋشى دەرەكتەرىن كورسەتۋ ٴۇشىن جۋىقتاعى وزگەرىستەردى قاراپ شىعادى.
	پايدالانۋشىلاردى مەن تۇزەتۋلەردى XFF IP ارقىلى IP جايعا «/xff» دەگەندى قوسىپ كەلتىرۋگە بولادى. IPv4 (CIDR 16-32) جانە IPv6 (CIDR 64-128) ارقاۋلانادى.
	ورىنداۋشىلىق سەبەپتەرىمەن 5000 تۇزەتۋدەن ارتىق قايتارىلمايدى. بۇنى ەرەجەلەرگە سايكەس پايدالانىڭىز.',
	'checkuser-logcase'          => 'جۋرنالدان ىزدەۋ ٴارىپ باس-كىشىلىگىن ايىرادى.',
	'checkuser'                  => 'قاتىسۋشىنى سىناۋ',
	'group-checkuser'            => 'قاتىسۋشى سىناۋشىلار',
	'group-checkuser-member'     => 'قاتىسۋشى سىناۋشى',
	'grouppage-checkuser'        => '{{ns:project}}:قاتىسۋشىنى سىناۋ',
	'checkuser-reason'           => 'سەبەبى',
	'checkuser-showlog'          => 'جۋرنالدى كورسەت',
	'checkuser-log'              => 'قاتىسۋشى سىناۋ جۋرنالى',
	'checkuser-query'            => 'جۋىقتاعى وزگەرىستەردى سۇرانىمداۋ',
	'checkuser-target'           => 'قاتىسۋشى اتى / IP جاي',
	'checkuser-users'            => 'قاتىسۋشىلاردى كەلتىرۋ',
	'checkuser-edits'            => 'IP جايدان جاسالعان تۇزەتۋلەردى كەلتىرۋ',
	'checkuser-ips'              => 'IP جايلاردى كەلتىرۋ',
	'checkuser-search'           => 'ىزدەۋ',
	'checkuser-empty'            => 'جۋرنالدا ەش جازبا جوق.',
	'checkuser-nomatch'          => 'سايكەس تابىلمادى.',
	'checkuser-check'            => 'سىناۋ',
	'checkuser-log-fail'         => 'جۋرنالعا جازبا ۇستەلىنبەدى',
	'checkuser-nolog'            => 'جۋرنال فايلى تابىلمادى.',
	'checkuser-blocked'          => 'بۇعاتتالعان',
	'checkuser-too-many'         => 'تىم كوپ ناتىيجە كەلتىرىلدى, CIDR دەگەندى تارىلتىپ كورىڭىز. مىندا پايدالانىلعان IP جايلار كورسەتىلگەن (بارىنشا 5000, جايىمەن سۇرىپتالعان):',
	'checkuser-user-nonexistent' => 'ەنگىزىلگەن قاتىسۋشى جوق.',
	'checkuser-search-form'      => 'جۋرنالداعى وقىيعالاردى تابۋ ($1 دەگەن $2 ەكەن جايىنداعى)',
	'checkuser-search-submit'    => 'ىزدەۋ',
	'checkuser-search-initiator' => 'باستاماشى',
	'checkuser-search-target'    => 'نىسانا',
	'checkuser-log-subpage'      => 'جۋرنال',
	'checkuser-log-return'       => 'CheckUser باسقى پىشىنىنە  ورالۋ',
	'checkuser-log-userips'      => '$2 ٴۇشىن $1 IP جاي الىندى',
	'checkuser-log-ipedits'      => '$2 ٴۇشىن $1 تۇزەتۋ الىندى',
	'checkuser-log-ipusers'      => '$2 ٴۇشىن $1 IP قاتىسۋشى الىندى',
	'checkuser-log-ipedits-xff'  => 'XFF $2 ٴۇشىن $1 تۇزەتۋ الىندى',
	'checkuser-log-ipusers-xff'  => 'XFF $2 ٴۇشىن $1 قاتىسۋشى الىندى',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'checkuser-summary'          => 'Бұл құрал пайдаланушы қолданған IP жайлар үшін, немесе IP жай түзету/пайдаланушы деректерін көрсету үшін жуықтағы өзгерістерді қарап шығады.
	Пайдаланушыларды мен түзетулерді XFF IP арқылы IP жайға «/xff» дегенді қосып келтіруге болады. IPv4 (CIDR 16-32) және IPv6 (CIDR 64-128) арқауланады.
	Орындаушылық себептерімен 5000 түзетуден артық қайтарылмайды. Бұны ережелерге сәйкес пайдаланыңыз.',
	'checkuser-logcase'          => 'Журналдан іздеу әріп бас-кішілігін айырады.',
	'checkuser'                  => 'Қатысушыны сынау',
	'group-checkuser'            => 'Қатысушы сынаушылар',
	'group-checkuser-member'     => 'қатысушы сынаушы',
	'grouppage-checkuser'        => '{{ns:project}}:Қатысушыны сынау',
	'checkuser-reason'           => 'Себебі',
	'checkuser-showlog'          => 'Журналды көрсет',
	'checkuser-log'              => 'Қатысушы сынау журналы',
	'checkuser-query'            => 'Жуықтағы өзгерістерді сұранымдау',
	'checkuser-target'           => 'Қатысушы аты / IP жай',
	'checkuser-users'            => 'Қатысушыларды келтіру',
	'checkuser-edits'            => 'IP жайдан жасалған түзетулерді келтіру',
	'checkuser-ips'              => 'IP жайларды келтіру',
	'checkuser-search'           => 'Іздеу',
	'checkuser-empty'            => 'Журналда еш жазба жоқ.',
	'checkuser-nomatch'          => 'Сәйкес табылмады.',
	'checkuser-check'            => 'Сынау',
	'checkuser-log-fail'         => 'Журналға жазба үстелінбеді',
	'checkuser-nolog'            => 'Журнал файлы табылмады.',
	'checkuser-blocked'          => 'Бұғатталған',
	'checkuser-too-many'         => 'Тым көп нәтиже келтірілді, CIDR дегенді тарылтып көріңіз. Мында пайдаланылған IP жайлар көрсетілген (барынша 5000, жайымен сұрыпталған):',
	'checkuser-user-nonexistent' => 'Енгізілген қатысушы жоқ.',
	'checkuser-search-form'      => 'Журналдағы оқиғаларды табу ($1 деген $2 екен жайындағы)',
	'checkuser-search-submit'    => 'Іздеу',
	'checkuser-search-initiator' => 'бастамашы',
	'checkuser-search-target'    => 'нысана',
	'checkuser-log-subpage'      => 'Журнал',
	'checkuser-log-return'       => 'CheckUser басқы пішініне  оралу',
	'checkuser-log-userips'      => '$2 үшін $1 IP жай алынды',
	'checkuser-log-ipedits'      => '$2 үшін $1 түзету алынды',
	'checkuser-log-ipusers'      => '$2 үшін $1 IP қатысушы алынды',
	'checkuser-log-ipedits-xff'  => 'XFF $2 үшін $1 түзету алынды',
	'checkuser-log-ipusers-xff'  => 'XFF $2 үшін $1 қатысушы алынды',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'checkuser-summary'          => 'Bul qural paýdalanwşı qoldanğan IP jaýlar üşin, nemese IP jaý tüzetw/paýdalanwşı derekterin körsetw üşin jwıqtağı özgeristerdi qarap şığadı.
	Paýdalanwşılardı men tüzetwlerdi XFF IP arqılı IP jaýğa «/xff» degendi qosıp keltirwge boladı. IPv4 (CIDR 16-32) jäne IPv6 (CIDR 64-128) arqawlanadı.
	Orındawşılıq sebepterimen 5000 tüzetwden artıq qaýtarılmaýdı. Bunı erejelerge säýkes paýdalanıñız.',
	'checkuser-logcase'          => 'Jwrnaldan izdew ärip bas-kişiligin aýıradı.',
	'checkuser'                  => 'Qatıswşını sınaw',
	'group-checkuser'            => 'Qatıswşı sınawşılar',
	'group-checkuser-member'     => 'qatıswşı sınawşı',
	'grouppage-checkuser'        => '{{ns:project}}:Qatıswşını sınaw',
	'checkuser-reason'           => 'Sebebi',
	'checkuser-showlog'          => 'Jwrnaldı körset',
	'checkuser-log'              => 'Qatıswşı sınaw jwrnalı',
	'checkuser-query'            => 'Jwıqtağı özgeristerdi suranımdaw',
	'checkuser-target'           => 'Qatıswşı atı / IP jaý',
	'checkuser-users'            => 'Qatıswşılardı keltirw',
	'checkuser-edits'            => 'IP jaýdan jasalğan tüzetwlerdi keltirw',
	'checkuser-ips'              => 'IP jaýlardı keltirw',
	'checkuser-search'           => 'İzdew',
	'checkuser-empty'            => 'Jwrnalda eş jazba joq.',
	'checkuser-nomatch'          => 'Säýkes tabılmadı.',
	'checkuser-check'            => 'Sınaw',
	'checkuser-log-fail'         => 'Jwrnalğa jazba üstelinbedi',
	'checkuser-nolog'            => 'Jwrnal faýlı tabılmadı.',
	'checkuser-blocked'          => 'Buğattalğan',
	'checkuser-too-many'         => 'Tım köp nätïje keltirildi, CIDR degendi tarıltıp köriñiz. Mında paýdalanılğan IP jaýlar körsetilgen (barınşa 5000, jaýımen surıptalğan):',
	'checkuser-user-nonexistent' => 'Engizilgen qatıswşı joq.',
	'checkuser-search-form'      => 'Jwrnaldağı oqïğalardı tabw ($1 degen $2 eken jaýındağı)',
	'checkuser-search-submit'    => 'İzdew',
	'checkuser-search-initiator' => 'bastamaşı',
	'checkuser-search-target'    => 'nısana',
	'checkuser-log-subpage'      => 'Jwrnal',
	'checkuser-log-return'       => 'CheckUser basqı pişinine  oralw',
	'checkuser-log-userips'      => '$2 üşin $1 IP jaý alındı',
	'checkuser-log-ipedits'      => '$2 üşin $1 tüzetw alındı',
	'checkuser-log-ipusers'      => '$2 üşin $1 IP qatıswşı alındı',
	'checkuser-log-ipedits-xff'  => 'XFF $2 üşin $1 tüzetw alındı',
	'checkuser-log-ipusers-xff'  => 'XFF $2 üşin $1 qatıswşı alındı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Chhorran
 */
$messages['km'] = array(
	'checkuser-logcase'          => 'ការស្វែងរកកំណត់ហេតុដោយបែងចែកអក្សរធំ អក្សរតូច។',
	'checkuser'                  => 'ត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'group-checkuser'            => 'អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'group-checkuser-member'     => 'អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'right-checkuser'            => 'អាសយដ្ឋានIPនិងពត៌មានដ៏ទៃទៀតនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'grouppage-checkuser'        => '{{ns:project}}:អ្នកត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-reason'           => 'មូលហេតុ',
	'checkuser-showlog'          => 'បង្ហាញកំណត់ហេតុ',
	'checkuser-log'              => 'កំនត់ហេតុនៃការត្រួតពិនិត្យអ្នកប្រើប្រាស់',
	'checkuser-target'           => 'អ្នកប្រើប្រាស់ ឬ IP',
	'checkuser-users'            => 'ទទួលអ្នកប្រើប្រាស់',
	'checkuser-edits'            => 'ទទួលកំនែប្រែពីIP',
	'checkuser-ips'              => 'ទទួលIP',
	'checkuser-search'           => 'ស្វែងរក',
	'checkuser-empty'            => 'មិនមានអ្វីនៅក្នុងកំណត់ហេតុនេះទេ។',
	'checkuser-check'            => 'ត្រួតពិនិត្យ',
	'checkuser-nolog'            => 'ឯកសារកំណត់ហេតុមិនត្រូវបានរកឃើញទេ។',
	'checkuser-blocked'          => 'បានហាមឃាត់',
	'checkuser-too-many'         => 'ច្រើនលទ្ធផល ពេក, សូមបង្រួម CIDR ។ នេះគឺ IP បានប្រើប្រាស់ (អតិបរិមា ៥០០០, រៀបតាម អាស័យដ្ឋាន) ៖',
	'checkuser-user-nonexistent' => 'មិនមានអ្នកប្រើប្រាស់ដូចដែលបានបញ្ជាក់ទេ។',
	'checkuser-search-submit'    => 'ស្វែងរក',
	'checkuser-search-target'    => 'គោលដៅ',
	'checkuser-log-subpage'      => 'កំណត់ហេតុ',
	'checkuser-log-userips'      => '$1បានទទួល IPs ដែល$2បានប្រើប្រាស់',
	'checkuser-log-ipedits'      => '$1បានទទួលចំនួនកំនែប្រែពី$2',
);

/** Kannada (ಕನ್ನಡ)
 * @author HPNadig
 */
$messages['kn'] = array(
	'checkuser' => 'ಸದಸ್ಯನನ್ನು ಚೆಕ್ ಮಾಡಿ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author ToePeu
 */
$messages['ko'] = array(
	'checkuser'               => '체크유저',
	'group-checkuser'         => '체크유저',
	'group-checkuser-member'  => '체크유저',
	'grouppage-checkuser'     => '{{ns:project}}:체크유저',
	'checkuser-reason'        => '이유',
	'checkuser-showlog'       => '기록 보기',
	'checkuser-search'        => '찾기',
	'checkuser-search-submit' => '찾기',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'checkuser-search'        => 'Sagap',
	'checkuser-search-submit' => 'Sagap',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'checkuser-reason'        => 'Aanlass',
	'checkuser-search'        => 'Sööke',
	'checkuser-search-submit' => 'Sööke',
);

/** Kurdish (Latin) (Kurdî / كوردی (Latin))
 * @author Bangin
 * @author Siebrand
 */
$messages['ku-latn'] = array(
	'checkuser-search'        => 'Lêbigere',
	'checkuser-search-submit' => 'Lêbigere',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'checkuser-reason' => 'Causa',
	'checkuser-search' => 'Quaerere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'checkuser-desc'             => "Gëtt Benotzer mat den néidege Rechter d'Méiglechkeet d'IP-Adressen esou wéi aner Informatiounen iwwert d'Benotzer z'iwwerpréifen",
	'checkuser-logcase'          => "D'Sich am Logbuch mecht en Ënnerscheed tëschent groussen a klenge Buchstawen.",
	'checkuser'                  => 'Benotzer-Check',
	'group-checkuser'            => 'Benotzer Kontrolleren',
	'group-checkuser-member'     => 'Benotzer Kontroller',
	'right-checkuser'            => 'Iwwerpréif de Benotzer hir IP-Adressen an aner Informatiounen',
	'grouppage-checkuser'        => '{{ns:project}}:Benotzer-Kontroller',
	'checkuser-reason'           => 'Grond',
	'checkuser-showlog'          => 'Logbuch weisen',
	'checkuser-log'              => 'Lëscht vun de Benotzerkontrollen',
	'checkuser-query'            => 'Rezent Ännerungen offroen',
	'checkuser-target'           => 'Benotzer oder IP-Adress',
	'checkuser-users'            => 'Benotzer kréien',
	'checkuser-edits'            => "Weis d'Ännerungen vun der IP-Adress",
	'checkuser-ips'              => 'IP-Adresse kréien/uweisen',
	'checkuser-search'           => 'Sichen',
	'checkuser-empty'            => 'Dës Lëscht ass eidel.',
	'checkuser-nomatch'          => 'Et goufe keng Iwwereneestëmmunge fonnt.',
	'checkuser-check'            => 'Kontrolléieren',
	'checkuser-log-fail'         => "D'Aschreiwung an d'Logbuch konnt net gemaach ginn",
	'checkuser-nolog'            => "D'Logbuch gouf net fonnt.",
	'checkuser-blocked'          => 'Gespaart',
	'checkuser-too-many'         => 'Zevill Resultater, gitt w.e.g. méi e klenge Beräich vun Ip-adresen un.
Hei sinn déi benotzten IP-Adressen (max 5000, sortéiert no der Adress):',
	'checkuser-user-nonexistent' => 'De gesichte Benotzer gëtt et net.',
	'checkuser-search-form'      => 'An de Lëschten fannen, wou den $1 den $2 ass',
	'checkuser-search-submit'    => 'Sichen',
	'checkuser-search-initiator' => 'Initiator',
	'checkuser-search-target'    => 'Zil',
	'checkuser-ipeditcount'      => '~$1 vun alle Benotzer',
	'checkuser-log-subpage'      => 'Lëscht',
	'checkuser-log-return'       => 'Zréck op den Haaptformulair vun der Benotzer Kontroll',
	'checkuser-log-userips'      => '$1 krut IPen fir $2',
	'checkuser-log-ipedits'      => '$1 huet Ännerunge kritt fir $2',
	'checkuser-log-ipusers'      => '$1 huet Benotzer kritt fir $2',
	'checkuser-log-ipedits-xff'  => '$1 krut ännerunge fir XFF $2',
	'checkuser-log-ipusers-xff'  => "$1 krut d'Benotzer fir XFF $2",
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'checkuser-search' => 'Xerca',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'checkuser-summary'          => "Dit hölpmiddel bekiek recènte verangeringe óm IP-adresse die 'ne gebroeker haet gebroek te achterhaole of toeantj de bewèrkings- en gebroekersgegaeves veur 'n IP-adres.
Gebroekers en bewèrkinge van 'n IP-adres van 'ne cliënt kinne achterhaoldj waere via XFF-headers door \"/xff\" achter 't IP-adres toe te voege. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) waere óngersteundj.
Óm prestatiereej waere neet mieë es 5.000 bewèrkinge getoeantj. Gebroek dit hölpmiddel volges 't vasgesteldje beleid.",
	'checkuser-desc'             => 'Läöt geautproseerde gebroekers IP-adresse en angere informatie van gebroekers achterhaole',
	'checkuser-logcase'          => "Zeuke in 't logbook is huidlèttergeveulig.",
	'checkuser'                  => 'Konterleer gebroeker',
	'group-checkuser'            => 'Gebroekerkonterleerders',
	'group-checkuser-member'     => 'Gebroekerkonterleerder',
	'right-checkuser'            => 'IP-adrèsser en anger gegaeves van gebroekers naokieke',
	'grouppage-checkuser'        => '{{ns:project}}:Gebroekerkonterleerder',
	'checkuser-reason'           => 'Reej',
	'checkuser-showlog'          => 'Toean logbook',
	'checkuser-log'              => 'Logbook KonterleerGebroeker',
	'checkuser-query'            => 'Bevraog recènte verangeringe',
	'checkuser-target'           => 'Gebroeker of IP-adres',
	'checkuser-users'            => 'Vraog gebroekers op',
	'checkuser-edits'            => 'Vraog bewèrkinge van IP-adres op',
	'checkuser-ips'              => 'Vraof IP-adresse op',
	'checkuser-search'           => 'Zeuk',
	'checkuser-empty'            => "'t Logbook bevat gein regels.",
	'checkuser-nomatch'          => 'Gein euvereinkómste gevónje.',
	'checkuser-check'            => 'Conterleer',
	'checkuser-log-fail'         => 'Logbookregel toevoege neet meugelik',
	'checkuser-nolog'            => 'Gein logbook gevónje.',
	'checkuser-blocked'          => 'Geblokkeerdj',
	'checkuser-too-many'         => 'Te väöl rezultaote. Maak de IP-reiks kleinder:',
	'checkuser-user-nonexistent' => 'De opgegaeve gebroeker besteit neet.',
	'checkuser-search-form'      => 'Logbookregels zeuke wo de $1 $2 is',
	'checkuser-search-submit'    => 'Zeuk',
	'checkuser-search-initiator' => 'aanvraoger',
	'checkuser-search-target'    => 'óngerwèrp',
	'checkuser-log-subpage'      => 'Logbook',
	'checkuser-log-return'       => "Nao 't huidformeleer van KonterleerGebroeker trökgaon",
	'checkuser-log-userips'      => '$1 haet IP-adresse veur $2',
	'checkuser-log-ipedits'      => '$1 haet bewèrkinge veur $2',
	'checkuser-log-ipusers'      => '$1 haet gebroekers veur $2',
	'checkuser-log-ipedits-xff'  => '$1 haet bewèrkinge veur XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 haet gebrokers veur XFF $2',
);

/** Lao (ລາວ) */
$messages['lo'] = array(
	'checkuser'         => 'ກວດຜູ້ໃຊ້',
	'checkuser-reason'  => 'ເຫດຜົນ',
	'checkuser-showlog' => 'ສະແດງບັນທຶກ',
	'checkuser-log'     => 'ບັນທຶກການກວດຜູ້ໃຊ້',
	'checkuser-target'  => 'ຜູ້ໃຊ້ ຫຼື IP',
	'checkuser-edits'   => 'ເອົາ ການດັດແກ້ ຈາກ ທີ່ຢູ່ IP',
	'checkuser-ips'     => 'ເອົາ ທີ່ຢູ່ IP',
	'checkuser-search'  => 'ຊອກຫາ',
	'checkuser-empty'   => 'ບໍ່ມີເນື້ອໃນຖືກບັນທຶກ',
	'checkuser-nomatch' => 'ບໍ່ພົບສິ່ງທີ່ຊອກຫາ',
	'checkuser-check'   => 'ກວດ',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'checkuser-reason'        => 'Priežastis',
	'checkuser-showlog'       => 'Rodyti sąrašą',
	'checkuser-target'        => 'Naudotojas arba IP',
	'checkuser-users'         => 'Gauti naudotojus',
	'checkuser-edits'         => 'Gauti redagavimus iš IP',
	'checkuser-ips'           => 'Gauti IP',
	'checkuser-search'        => 'Ieškoti',
	'checkuser-check'         => 'Tikrinti',
	'checkuser-blocked'       => 'Užblokuotas',
	'checkuser-search-submit' => 'Ieškoti',
	'checkuser-log-subpage'   => 'Sąrašas',
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
	'checkuser-desc'             => 'ഉപയോക്താക്കള്‍ ഉപയോഗിച്ച ഐപി വിലാസവും മറ്റുവിവരങ്ങളും പരിശോധിക്കുവാനുള്ള അവകാശം കൊടുക്കാന്‍ പ്രാപ്തമാക്കുന്നു',
	'checkuser-logcase'          => 'പ്രവര്‍ത്തന രേഖകള്‍ക്കു വേണ്ടിയുള്ള തിരച്ചില്‍ കേസ് സെന്‍സിറ്റീവ് ആണ്‌.',
	'checkuser'                  => 'ചെക്ക് യൂസര്‍',
	'group-checkuser'            => 'ചെക്ക് യൂസര്‍മാര്‍',
	'group-checkuser-member'     => 'ചെക്ക് യൂസര്‍',
	'right-checkuser'            => 'ചെക്ക് യൂസറിന്റെ ഐപി വിലാസവും മറ്റു വിവരങ്ങളും',
	'grouppage-checkuser'        => '{{ns:project}}:ചെക്ക് യൂസര്‍',
	'checkuser-reason'           => 'കാരണം',
	'checkuser-showlog'          => 'പ്രവര്‍ത്തനരേഖ കാട്ടുക',
	'checkuser-log'              => 'ചെക്ക് യൂസര്‍ പ്രവര്‍ത്തനരേഖ',
	'checkuser-query'            => 'പുതിയ മാറ്റങ്ങള്‍',
	'checkuser-target'           => 'ഉപയോക്താവ് അല്ലെങ്കില്‍ ഐപി',
	'checkuser-users'            => 'ഉപയോക്താക്കളെ കാട്ടുക',
	'checkuser-edits'            => 'ഐപിയില്‍ നിന്നുള്ള തിരുത്തലുകള്‍ കാട്ടുക',
	'checkuser-ips'              => 'ഐപികളെ കാട്ടുക',
	'checkuser-search'           => 'തിരയൂ',
	'checkuser-empty'            => 'പ്രവര്‍ത്തനരേഖയില്‍ ഇനങ്ങള്‍ ഒന്നുമില്ല',
	'checkuser-nomatch'          => 'ചേര്‍ച്ചയുള്ളതൊന്നും കണ്ടില്ല',
	'checkuser-check'            => 'പരിശോധിക്കുക',
	'checkuser-log-fail'         => 'പ്രവര്‍ത്തനരേഖയില്‍ ഇനം ചേര്‍ക്കുന്നതിനു കഴിഞ്ഞില്ല',
	'checkuser-nolog'            => 'പ്രവര്‍ത്തനരേഖ പ്രമാണം കണ്ടില്ല.',
	'checkuser-blocked'          => 'തടയപ്പെട്ടിരിക്കുന്നു',
	'checkuser-too-many'         => 'വളരെയധികം ഫലങ്ങള്‍. CIDR ചുരുക്കുക. 
ഉപയോഗിച്ച IPകള്‍ താഴെ പ്രദര്‍ശിപ്പിച്ചിരിക്കുന്നു (പരമാവധി 5000, വിലാസം അനുസരിച്ച് ക്രമീകരിച്ചത്):',
	'checkuser-user-nonexistent' => 'ഇങ്ങനൊരു ഉപയോക്താവ് വിക്കിയില്‍ നിലവിലില്ല.',
	'checkuser-search-form'      => '$1, $2 ആയ പ്രവര്‍ത്തനരേഖാ ഇനങ്ങള്‍ കണ്ടെത്തുന്നു',
	'checkuser-search-submit'    => 'തിരയൂ',
	'checkuser-search-initiator' => 'മുന്‍‌കൈ എടുക്കുന്ന ആള്‍',
	'checkuser-search-target'    => 'ലക്ഷ്യം',
	'checkuser-ipeditcount'      => '~$1എല്ലാ ഉപയോക്താക്കളില്‍ നിന്നും',
	'checkuser-log-subpage'      => 'പ്രവര്‍ത്തനരേഖ',
	'checkuser-log-return'       => 'ചെക്ക് യൂസറിന്റെ പ്രധാന ഫോമിലേക്ക് തിരിച്ചു പോവുക',
	'checkuser-log-userips'      => '$1നു $2ല്‍ ഐപികള്‍ ഉണ്ട്',
	'checkuser-log-ipedits'      => '$1നു $2ല്‍ തിരുത്തലുകള്‍ ഉണ്ട്',
	'checkuser-log-ipusers'      => '$1നു $2ല്‍ ഉപയോക്താക്കള്‍ ഉണ്ട്',
	'checkuser-log-ipedits-xff'  => '$1നു XFF $2ല്‍ തിരുത്തലുകള്‍ ഉണ്ട്',
	'checkuser-log-ipusers-xff'  => '$1നു XFF $2ല്‍ ഉപയോക്താക്കള്‍ ഉണ്ട്',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'checkuser-summary'          => 'हे उपकरण अलीकडील बदलांमधून एखाद्या सदस्याने वापरलेले अंकपत्ते किंवा एखाद्या अंकपत्त्याची संपादने/सदस्य दाखविते.
क्लायंट अंकपत्त्यावरील सदस्य अथवा संपादने पाहण्यासाठी अंकपत्त्यानंतर "/xff" द्यावे लागेल.
IPv4 (CIDR 16-32) आणि IPv6 (CIDR 64-128) वापरता येऊ शकेल.
एका वेळी ५००० पेक्षा जास्त संपादने दाखविली जाणार नाहीत. हे उपकरण पॉलिसीच्या नियमांना धरून वापरावे.',
	'checkuser-desc'             => 'सदस्याला इतर सदस्यांचे आंतरजाल अंकपत्ते (आयपी) तपासण्याची तसेच इतर माहिती पाहण्याची परवानगी देतो.',
	'checkuser-logcase'          => 'लॉगमधील शोध हा लिपीशी संबंधित (case-sensitive) आहे.',
	'checkuser'                  => 'सदस्य तपासा',
	'group-checkuser'            => 'सदस्य तपासा',
	'group-checkuser-member'     => 'सदस्य तपासा',
	'right-checkuser'            => 'सदस्याचा आयपी अंकपत्ता व इतर माहिती तपासा',
	'grouppage-checkuser'        => '{{ns:project}}:सदस्य तपासा',
	'checkuser-reason'           => 'कारण',
	'checkuser-showlog'          => 'लॉग दाखवा',
	'checkuser-log'              => 'Checkuse लॉग',
	'checkuser-query'            => 'अलीकडील बदल पृच्छा',
	'checkuser-target'           => 'सदस्य किंवा अंकपत्ता',
	'checkuser-users'            => 'सदस्य शोधा',
	'checkuser-edits'            => 'अंकपत्त्याची संपादने शोधा',
	'checkuser-ips'              => 'अंकपत्ते शोधा',
	'checkuser-search'           => 'शोधा',
	'checkuser-empty'            => 'लॉग मध्ये एकही नोंद नाही',
	'checkuser-nomatch'          => 'नोंदी सापडल्या नाहीत',
	'checkuser-check'            => 'पडताळा',
	'checkuser-log-fail'         => 'लॉगमध्ये नोंद वाढविता आलेली नाही.',
	'checkuser-nolog'            => 'लॉग संचिका सापडलेली नाही.',
	'checkuser-blocked'          => 'ब्लॉक केलेले आहे',
	'checkuser-too-many'         => 'खूप निकाल आलेले आहेत, कृपया शोधशब्दांमध्ये योग्य बदल करा. खाली वापरलेल्या अंकपत्त्यांची यादी आहे (जास्तीत जास्त ५०००, अनुक्रमे):',
	'checkuser-user-nonexistent' => 'हे सदस्यनाम अस्तित्त्वात नाही.',
	'checkuser-search-form'      => 'अशा नोंदी शोधा जिथे $1 हा $2 आहे.',
	'checkuser-search-submit'    => 'शोधा',
	'checkuser-search-initiator' => 'चालक (चालना देणारा)',
	'checkuser-search-target'    => 'लक्ष्य',
	'checkuser-ipeditcount'      => '~$1 सर्व सदस्यांकडून',
	'checkuser-log-subpage'      => 'नोंदी',
	'checkuser-log-return'       => 'CheckUser मुख्य अर्जाकडे परत जा',
	'checkuser-log-userips'      => '$1 कडे $2 साठीचे अंकपत्ते आहेत',
	'checkuser-log-ipedits'      => '$1 कडे $2 साठीची संपादने आहेत',
	'checkuser-log-ipusers'      => '$1 कडे $2 साठीचे सदस्य आहेत',
	'checkuser-log-ipedits-xff'  => '$1 कडे XFF $2 साठीची संपादने आहेत',
	'checkuser-log-ipusers-xff'  => '$1 कडे XFF $2 साठीचे सदस्य आहेत',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 */
$messages['ms'] = array(
	'checkuser-summary'          => 'Alat ini mengimbas senarai perubahan terkini untuk mendapatkan senarai IP yang digunakan oleh seseorang pengguna atau memaparkan data sunting/pengguna bagi sesebuah IP. Pengguna dan suntingan oleh sesebuah IP boleh didapatkan melalui pengatas XFF dengan menambah \\"/xff\\" selepas IP tersebut. Kedua-dua format IPv4 (CIDR 16-32) dan IPv6 (CIDR 64-128) disokong. Atas sebab-sebab prestasi, pulangan dihadkan kepada 5000 buah suntingan sahaja. Sila patuhi dasar yang telah ditetapkan.',
	'checkuser-desc'             => 'Melantik pengguna dengan keizinan untuk membongkar alamat IP pengguna tertentu berserta maklumat-maklumat sulit lain',
	'checkuser-logcase'          => 'Enjin gelintar log ini sensitif huruf.',
	'checkuser'                  => 'Risik pengguna',
	'group-checkuser'            => 'Perisik',
	'group-checkuser-member'     => 'Perisik',
	'right-checkuser'            => 'Membongkar alamat IP dan maklumat-maklumat sulit lain bagi pengguna tertentu',
	'grouppage-checkuser'        => '{{ns:project}}:Perisik',
	'checkuser-reason'           => 'Sebab',
	'checkuser-showlog'          => 'Papar log',
	'checkuser-log'              => 'Log perisikan',
	'checkuser-query'            => 'Imbas perubahan terkini',
	'checkuser-target'           => 'Pengguna atau IP',
	'checkuser-users'            => 'Dapatkan senarai pengguna',
	'checkuser-edits'            => 'Dapatkan senarai suntingan daripada IP',
	'checkuser-ips'              => 'Dapatkan senarai IP',
	'checkuser-search'           => 'Cari',
	'checkuser-empty'            => 'Log ini kosong.',
	'checkuser-nomatch'          => 'Tiada padanan.',
	'checkuser-check'            => 'Bongkar',
	'checkuser-log-fail'         => 'Entri log tidak dapat ditambah',
	'checkuser-nolog'            => 'Fail log tiada.',
	'checkuser-blocked'          => 'Disekat',
	'checkuser-too-many'         => 'Keputusan terlalu besar; sila kecilkan CIDR. Berikut ialah senarai IP yang digunakan (had 5000, mengikut tertib alamat):',
	'checkuser-user-nonexistent' => 'Pengguna yang dinyatakan tidak wujud.',
	'checkuser-search-form'      => 'Cari entri yang mana $1 adalah $2',
	'checkuser-search-submit'    => 'Cari',
	'checkuser-search-initiator' => 'pengasal',
	'checkuser-search-target'    => 'sasaran',
	'checkuser-ipeditcount'      => '~$1 daripada semua pengguna',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Kembali ke borang utama Perisik',
	'checkuser-log-userips'      => '$1 mendapatkan senarai IP bagi $2',
	'checkuser-log-ipedits'      => '$1 mendapatkan senarai suntingan bagi $2',
	'checkuser-log-ipusers'      => '$1 mendapatkan senarai pengguna bagi $2',
	'checkuser-log-ipedits-xff'  => '$1 mendapatkan senarai suntingan bagi XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 mendapatkan senarai pengguna bagi XFF $2',
);

/** Erzya (Эрзянь)
 * @author Tupikovs
 * @author Amdf
 */
$messages['myv'] = array(
	'checkuser-target' => 'Совиця эли IP',
	'checkuser-search' => 'Вешнемс',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'checkuser-search'        => 'Tlatēmoāz',
	'checkuser-search-submit' => 'Tlatēmoāz',
);

/** Neapolitan (Nnapulitano)
 * @author SPQRobin
 */
$messages['nap'] = array(
	'checkuser-search' => 'Truova',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'checkuser'                  => 'Bruker nakieken',
	'group-checkuser'            => 'Brukers nakieken',
	'group-checkuser-member'     => 'Bruker nakieken',
	'grouppage-checkuser'        => '{{ns:project}}:Checkuser',
	'checkuser-reason'           => 'Grund',
	'checkuser-showlog'          => 'Logbook wiesen',
	'checkuser-log'              => 'Checkuser-Logbook',
	'checkuser-target'           => 'Bruker oder IP',
	'checkuser-users'            => 'Brukers kriegen',
	'checkuser-edits'            => 'Ännern vun IP-Adress wiesen',
	'checkuser-ips'              => 'IPs kriegen',
	'checkuser-search'           => 'Söken',
	'checkuser-empty'            => 'Dat Logbook is leddig.',
	'checkuser-nomatch'          => 'Nix funnen, wat övereenstimmt.',
	'checkuser-check'            => 'Los',
	'checkuser-log-fail'         => 'Kunn keen Logbook-Indrag tofögen',
	'checkuser-nolog'            => 'Keen Loogbook funnen.',
	'checkuser-blocked'          => 'Sperrt',
	'checkuser-too-many'         => 'To veel funnen, grenz de IP-Reeg wieder in. Dit sünd de bruukten IP-Adressen (maximal 5000, sorteert na Adress):',
	'checkuser-user-nonexistent' => 'Den angevene Bruker gifft dat nich.',
	'checkuser-search-form'      => 'Söök na Logbook-Indrääg, bi de $1 $2 is.',
	'checkuser-search-submit'    => 'Söök',
	'checkuser-search-initiator' => 'Initiater',
	'checkuser-search-target'    => 'Ziel',
	'checkuser-ipeditcount'      => '~$1 vun all Brukers',
	'checkuser-log-subpage'      => 'Logbook',
	'checkuser-log-return'       => 'Trüch na dat CheckUser-Hööftformular',
	'checkuser-log-userips'      => '$1 hett IP-Adressen för $2 rutsöcht',
	'checkuser-log-ipedits'      => '$1 hett Ännern vun $2 rutsöcht',
	'checkuser-log-ipusers'      => '$1 hett Brukers för $2 rutsöcht',
	'checkuser-log-ipedits-xff'  => '$1 hett Ännern för de XFF-IP $2 rutsöcht',
	'checkuser-log-ipusers-xff'  => '$1 hett Brukers för de XFF-IP $2 rutsöcht',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'checkuser-summary' => 'Dit hulpmiddel scant de lieste mit de leste wiezigingen um de IP-adressen weerumme te haolen dee gebruuk bin deur een gebruker of een bewarking/gebrukersgegevens weergeven veur een IP-adres. Gebrukers en bewarkingen kunnen weerummehaold wonnen mit een XFF-IP deur "/xff" an \'t IP-adres toe te voegen. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) wonnen ondersteund. Neet meer as 5.000 bewarkingen wonnen eteund vanwegen prestasierejens. Gebruuk dit in overeenstemming mit \'t beleid.',
	'checkuser-query'   => 'Zeukopdrachte leste wiezigingen',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author SPQRobin
 * @author Troefkaart
 */
$messages['nl'] = array(
	'checkuser-summary'          => 'Dit hulpmiddel bekijkt recente wijzigingen om IP-adressen die een gebruiker heeft gebruikt te achterhalen of geeft de bewerkings- en gebruikersgegegevens weer voor een IP-adres.
Gebruikers en bewerkingen van een IP-adres van een client kunnen achterhaald worden via XFF-headers door "/xff" achter het IP-adres toe te voegen. IPv4 (CIDR 16-32) en IPv6 (CIDR 64-128) worden ondersteund.
Om prestatieredenen worden niet meer dan 5.000 bewerkingen weergegeven.
Gebruik dit hulpmiddel volgens het vastgestelde beleid.',
	'checkuser-desc'             => 'Laat bevoegde gebruikers IP-adressen en andere informatie van gebruikers achterhalen',
	'checkuser-logcase'          => 'Zoeken in het logboek is hoofdlettergevoelig.',
	'checkuser'                  => 'Gebruiker controleren',
	'group-checkuser'            => 'Controlegebruikers',
	'group-checkuser-member'     => 'Controlegebruiker',
	'right-checkuser'            => 'IP-adressen en andere gegevens van gebruikers nakijken',
	'grouppage-checkuser'        => '{{ns:project}}:Controlegebruiker',
	'checkuser-reason'           => 'Reden',
	'checkuser-showlog'          => 'Logboek weergeven',
	'checkuser-log'              => 'Logboek controleren gebruikers',
	'checkuser-query'            => 'Bevraag recente wijzigingen',
	'checkuser-target'           => 'Gebruiker of IP-adres',
	'checkuser-users'            => 'Gebruikers opvragen',
	'checkuser-edits'            => 'Bewerkingen van IP-adres opvragen',
	'checkuser-ips'              => 'IP-adressen opvragen',
	'checkuser-search'           => 'Zoeken',
	'checkuser-empty'            => 'Het logboek bevat geen regels.',
	'checkuser-nomatch'          => 'Geen overeenkomsten gevonden.',
	'checkuser-check'            => 'Controleren',
	'checkuser-log-fail'         => 'Logboekregel toevoegen niet mogelijk',
	'checkuser-nolog'            => 'Geen logboek gevonden.',
	'checkuser-blocked'          => 'Geblokkeerd',
	'checkuser-too-many'         => 'Te veel resultaten. Maak de IP-reeks kleiner:',
	'checkuser-user-nonexistent' => 'De opgegeven gebruiker bestaat niet.',
	'checkuser-search-form'      => 'Logboekregels zoeken waar de $1 $2 is',
	'checkuser-search-submit'    => 'Zoeken',
	'checkuser-search-initiator' => 'aanvrager',
	'checkuser-search-target'    => 'onderwerp',
	'checkuser-ipeditcount'      => '~$1 van alle gebruikers',
	'checkuser-log-subpage'      => 'Logboek',
	'checkuser-log-return'       => 'Naar het hoofdformulier van ControleGebruiker terugkeren',
	'checkuser-log-userips'      => '$1 heeft IP-adressen voor $2',
	'checkuser-log-ipedits'      => '$1 heeft bewerkingen voor $2',
	'checkuser-log-ipusers'      => '$1 heeft gebruikers voor $2',
	'checkuser-log-ipedits-xff'  => '$1 heeft bewerkingen voor XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 heeft gebruikers voor XFF $2',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'checkuser-reason'        => 'Årsak',
	'checkuser-search'        => 'Søk',
	'checkuser-search-submit' => 'Søk',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'checkuser-summary'          => 'Dette verktøyet går gjennom siste endringer for å hente IP-ene som er brukt av en bruker, eller viser redigerings- eller brukerinformasjonen for en IP.

Brukere og redigeringer kan hentes med en XFF-IP ved å legge til «/xff» bak IP-en. IPv4 (CIDR 16-32) og IPv6 (CIDR 64-128) støttes.

Av ytelsesgrunner vises maksimalt 5000 redigeringer. Bruk dette verktøyet i samsvar med retningslinjer.',
	'checkuser-desc'             => 'Gir brukere med de tilhørende rettighetene muligheten til å sjekke brukeres IP-adresser og annen informasjon',
	'checkuser-logcase'          => 'Loggsøket er sensitivt for store/små bokstaver.',
	'checkuser'                  => 'Brukersjekk',
	'group-checkuser'            => 'IP-kontrollører',
	'group-checkuser-member'     => 'IP-kontrollør',
	'right-checkuser'            => 'Sjekke brukeres IP-adresser og annen informasjon',
	'grouppage-checkuser'        => '{{ns:project}}:IP-kontrollør',
	'checkuser-reason'           => 'Årsak',
	'checkuser-showlog'          => 'Vis logg',
	'checkuser-log'              => 'Brukersjekkingslogg',
	'checkuser-query'            => 'Søk i siste endringer',
	'checkuser-target'           => 'Bruker eller IP',
	'checkuser-users'            => 'Få brukere',
	'checkuser-edits'            => 'Få redigeringer fra IP',
	'checkuser-ips'              => 'Få IP-er',
	'checkuser-search'           => 'Søk',
	'checkuser-empty'            => 'Loggen inneholder ingen elementer.',
	'checkuser-nomatch'          => 'Ingen treff.',
	'checkuser-check'            => 'Sjekk',
	'checkuser-log-fail'         => 'Kunne ikke legge til loggelement.',
	'checkuser-nolog'            => 'Ingen loggfil funnet.',
	'checkuser-blocked'          => 'Blokkert',
	'checkuser-too-many'         => 'For mange resultater, vennligst innskrenk CIDR. Her er de brukte IP-ene (maks 5000, sortert etter adresse):',
	'checkuser-user-nonexistent' => 'Det gitte brukernavnet finnes ikke.',
	'checkuser-search-form'      => 'Finn loggelementer der $1 er $2',
	'checkuser-search-submit'    => 'Søk',
	'checkuser-search-initiator' => 'IP-kontrolløren',
	'checkuser-search-target'    => 'målet',
	'checkuser-ipeditcount'      => '~$1 fra alle brukere',
	'checkuser-log-subpage'      => 'Logg',
	'checkuser-log-return'       => 'Tilbake til hovedskjema for brukersjekking',
	'checkuser-log-userips'      => '$1 fikk IP-adressene til $2',
	'checkuser-log-ipedits'      => '$1 fikk endringer av $2',
	'checkuser-log-ipusers'      => '$1 fikk brukere av $2',
	'checkuser-log-ipedits-xff'  => '$1 fikk endringer av XFF-en $2',
	'checkuser-log-ipusers-xff'  => '$1 fikk brukere av XFF-en $2',
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
	'checkuser-reason'        => 'Lebaka',
	'checkuser-target'        => 'Mošomiši goba IP',
	'checkuser-search'        => 'Fetleka',
	'checkuser-blocked'       => 'Thibilwe',
	'checkuser-search-submit' => 'Fetleka',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'checkuser-summary'          => "Aqueste esplech passa en revista los cambiaments recents per recercar l'IPS emplegada per un utilizaire, mostrar totas las edicions fachas per una IP, o per enumerar los utilizaires qu'an emplegat las IPs. Los utilizaires e las modificacions pòdon èsser trobatss amb una IP XFF se s'acaba amb « /xff ». IPv4 (CIDR 16-32) e IPv6(CIDR 64-128) son suportats. Emplegatz aquò segon las cadenas de caractèrs.",
	'checkuser-desc'             => 'Balha la possibilitat a las personas exprèssament autorizadas de verificar las adreças IP dels utilizaires e mai d’autras entresenhas los concernent',
	'checkuser-logcase'          => 'La recèrca dins lo Jornal es sensibla a la cassa.',
	'checkuser'                  => 'Verificator d’utilizaire',
	'group-checkuser'            => 'Verificators d’utilizaire',
	'group-checkuser-member'     => 'Verificator d’utilizaire',
	'right-checkuser'            => "Verificar l'adreça IP dels utilizaires e autras entresenhas",
	'grouppage-checkuser'        => '{{ns:project}}:Verificator d’utilizaire',
	'checkuser-reason'           => 'Motiu :',
	'checkuser-showlog'          => 'Afichar lo jornal',
	'checkuser-log'              => "Notacion de Verificator d'utilizaire",
	'checkuser-query'            => 'Recèrca pels darrièrs cambiaments',
	'checkuser-target'           => "Nom de l'utilizaire o IP",
	'checkuser-users'            => 'Obténer los utilizaires',
	'checkuser-edits'            => "Obténer las modificacions de l'IP",
	'checkuser-ips'              => 'Obténer las adreças IP',
	'checkuser-search'           => 'Recèrca',
	'checkuser-empty'            => "Lo jornal conten pas cap d'article",
	'checkuser-nomatch'          => 'Recèrcas infructuosas.',
	'checkuser-check'            => 'Recèrca',
	'checkuser-log-fail'         => "Incapaç d'ajustar la dintrada del jornal.",
	'checkuser-nolog'            => 'Cap de dintrada dins lo Jornal.',
	'checkuser-blocked'          => 'Blocat',
	'checkuser-too-many'         => 'Tròp de resultats. Limitatz la recèrca sus las adreças IP :',
	'checkuser-user-nonexistent' => 'L’utilizaire indicat existís pas',
	'checkuser-search-form'      => 'Cercar lo jornal de las entradas ont $1 es $2.',
	'checkuser-search-submit'    => 'Recercar',
	'checkuser-search-initiator' => 'l’iniciaire',
	'checkuser-search-target'    => 'la cibla',
	'checkuser-ipeditcount'      => '~$1 per totes los utilizaires',
	'checkuser-log-subpage'      => 'Jornal',
	'checkuser-log-return'       => "Tornar al formulari principal de la verificacion d'utilizaire",
	'checkuser-log-userips'      => "$1 a obtengut d'IP per $2",
	'checkuser-log-ipedits'      => '$1 a obtengut de modificacions per $2',
	'checkuser-log-ipusers'      => "$1 a obtengut d'utilizaires per $2",
	'checkuser-log-ipedits-xff'  => '$1 a obtengut de modificacions per XFF  $2',
	'checkuser-log-ipusers-xff'  => "$1 a obtengut d'utilizaires per XFF $2",
);

/** Pangasinan (Pangasinan)
 * @author SPQRobin
 */
$messages['pag'] = array(
	'checkuser-reason' => 'Katonongan',
	'checkuser-target' => 'Manag-usar odino IP',
	'checkuser-users'  => 'Alaen so manag-usar',
	'checkuser-search' => 'Anapen',
);

/** Pampanga (Kapampangan)
 * @author SPQRobin
 */
$messages['pam'] = array(
	'checkuser'         => 'Surian ya ing gagamit',
	'checkuser-reason'  => 'Sangkan',
	'checkuser-showlog' => 'Pakit ya ing log',
	'checkuser-search'  => 'Manintun',
);

/** Polish (Polski)
 * @author Sp5uhe
 * @author Derbeth
 */
$messages['pl'] = array(
	'checkuser-summary'          => 'To narzędzie skanuje ostatnie zmiany by znaleźć adresy IP użyte przez użytkownika lub pokazać edycje/użytkowników dla adresu IP. Użytkownicy i edycje spod adresu IP mogą być pozyskani przez nagłówki XFF przez dodanie do IP „/xff”. Obsługiwane są adresy IPv4 (CIDR 16-32) I IPv6 (CIDR 64-128).
Ze względu na wydajność, zostanie zwróconych nie więcej niż 5000 edycji.
Używaj tej funkcji zgodnie z zasadami.',
	'checkuser-desc'             => 'Umożliwia uprawnionym użytkownikom sprawdzenie adresów IP użytkowników oraz innych informacji',
	'checkuser-logcase'          => 'Szukanie w logu jest czułe na wielkość znaków',
	'checkuser'                  => 'Sprawdzanie IP użytkownika',
	'group-checkuser'            => 'CheckUser',
	'group-checkuser-member'     => 'CheckUser',
	'right-checkuser'            => 'Sprawdzanie adresów IP oraz innych informacji o użytkownikach',
	'grouppage-checkuser'        => '{{ns:project}}:CheckUser',
	'checkuser-reason'           => 'Powód',
	'checkuser-showlog'          => 'Pokaż log',
	'checkuser-log'              => 'Rejestr CheckUser',
	'checkuser-query'            => 'Przeanalizuj ostatnie zmiany',
	'checkuser-target'           => 'Użytkownik lub IP',
	'checkuser-users'            => 'Znajdź użytkowników',
	'checkuser-edits'            => 'Znajdź edycje z IP',
	'checkuser-ips'              => 'Znajdź adresy IP',
	'checkuser-search'           => 'Szukaj',
	'checkuser-empty'            => 'Log nie zawiera żadnych wpisów.',
	'checkuser-nomatch'          => 'Nie znaleziono niczego.',
	'checkuser-check'            => 'Log nie zawiera żadnych wpisów.',
	'checkuser-log-fail'         => 'Nie udało się dodać wpisu do logu.',
	'checkuser-nolog'            => 'Nie znaleziono pliku logu.',
	'checkuser-blocked'          => 'Zablokowany',
	'checkuser-too-many'         => 'Zbyt wiele wyników, ogranicz CIDR.
Użytych adresów IP jest (nie więcej niż 5000, posortowane według adresu):',
	'checkuser-user-nonexistent' => 'Taki użytkownik nie istnieje.',
	'checkuser-search-form'      => 'Szukaj wpisów w logu, dla których $1 jest $2',
	'checkuser-search-submit'    => 'Szukaj',
	'checkuser-search-initiator' => 'inicjator',
	'checkuser-search-target'    => 'cel',
	'checkuser-ipeditcount'      => '~$1 od wszystkich użytkowników',
	'checkuser-log-subpage'      => 'Rejestr',
	'checkuser-log-return'       => 'Powrót do głównego formularza CheckUser',
	'checkuser-log-userips'      => '$1 dostał adresy IP dla $2',
	'checkuser-log-ipedits'      => '$1 dostał edycje dla $2',
	'checkuser-log-ipusers'      => '$1 otrzymał listę użytkowników adresu IP $2',
	'checkuser-log-ipedits-xff'  => '$1 otrzymał listę edycji dla XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 otrzymał listę użytkowników dla XFF $2',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'checkuser-summary'      => "St'utiss-sì as passa j'ùltime modìfiche për tiré sù j'adrësse IP dovra da n'utent ò pura mostré lòn ch'as fa da n'adrëssa IP e che dat utent ch'a l'abia associà.
	J'utent ch'a dòvro n'adrëssa IP e le modìfiche faite d'ambelelì as peulo tiresse sù ën dovrand le testà XFF, për felo tache-ie dapress l'adrëssa e \"/xff\". A travaja tant con la forma IPv4 (CIDR 16-32) che con cola IPv6 (CIDR 64-128).
	Për na question ëd caria ëd travaj a tira nen sù pì che 5000 modìfiche. A va dovrà comforma a ij deuit për ël process ëd contròl.",
	'checkuser-logcase'      => "L'arsërca ant ël registr a conta ëdcò maiùscole e minùscole.",
	'checkuser'              => "Contròl dj'utent",
	'group-checkuser'        => 'Controlor',
	'group-checkuser-member' => 'Controlor',
	'grouppage-checkuser'    => "{{ns:project}}:Contròl dj'utent",
	'checkuser-reason'       => 'Rason',
	'checkuser-showlog'      => 'Smon ël registr',
	'checkuser-log'          => "Registr dël contròl dj'utent",
	'checkuser-query'        => "Anterogassion dj'ùltime modìfiche",
	'checkuser-target'       => 'Stranòm ò adrëssa IP',
	'checkuser-users'        => "Tira sù j'utent",
	'checkuser-edits'        => 'Tiré sù le modìfiche faite da na midema adrëssa IP',
	'checkuser-ips'          => "Tiré sù j'adrësse IP",
	'checkuser-search'       => 'Sërca',
	'checkuser-empty'        => "Ës registr-sì a l'é veujd.",
	'checkuser-nomatch'      => 'A-i é pa gnun-a ròba parej.',
	'checkuser-check'        => 'Contròl',
	'checkuser-log-fail'     => 'I-i la fom nen a gionte-ie na riga ant sël registr',
	'checkuser-nolog'        => "Pa gnun registr ch'a sia trovasse.",
	'checkuser-blocked'      => 'Blocà',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'checkuser-reason'        => 'سبب',
	'checkuser-showlog'       => 'يادښت کتل',
	'checkuser-target'        => 'کارونکی يا IP پته',
	'checkuser-search'        => 'پلټل',
	'checkuser-search-submit' => 'پلټل',
	'checkuser-search-target' => 'موخه',
	'checkuser-log-subpage'   => 'يادښت',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 */
$messages['pt'] = array(
	'checkuser-summary'          => 'Esta ferramenta varre as Mudanças recentes para obter os endereços de IP de um utilizador ou para exibir os dados de edições/utilizadores para um IP.
	Utilizadores edições podem ser obtidos por um IP XFF colocando-se "/xff" no final do endereço. São suportados endereços IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128).
	Não serão retornadas mais de 5000 edições por motivos de desempenho. O uso desta ferramenta deverá estar de acordo com as políticas.',
	'checkuser-desc'             => 'Concede a utilizadores com a permissão apropriada a possibilidade de verificar os endereços IP de um utilizador e outra informação',
	'checkuser-logcase'          => 'As buscas nos registos são sensíveis a letras maiúsculas ou minúsculas.',
	'checkuser'                  => 'Verificar utilizador',
	'group-checkuser'            => 'CheckUser',
	'group-checkuser-member'     => 'CheckUser',
	'right-checkuser'            => 'Verificar o endereço IP de um utilizador e outras informações',
	'grouppage-checkuser'        => '{{ns:project}}:CheckUser',
	'checkuser-reason'           => 'Motivo',
	'checkuser-showlog'          => 'Exibir registos',
	'checkuser-log'              => 'Registos de verificação de utilizadores',
	'checkuser-query'            => 'Examinar as Mudanças recentes',
	'checkuser-target'           => 'Utilizador ou IP',
	'checkuser-users'            => 'Obter utilizadores',
	'checkuser-edits'            => 'Obter edições de IPs',
	'checkuser-ips'              => 'Obter IPs',
	'checkuser-search'           => 'Pesquisar',
	'checkuser-empty'            => 'O registo não contém itens.',
	'checkuser-nomatch'          => 'Não foram encontrados resultados.',
	'checkuser-check'            => 'Verificar',
	'checkuser-log-fail'         => 'Não foi possível adicionar entradas ao registo',
	'checkuser-nolog'            => 'Não foi encontrado um arquivo de registos.',
	'checkuser-blocked'          => 'Bloqueado',
	'checkuser-too-many'         => 'Demasiados resultados; por favor, restrinja o CIDR. Aqui estão os IPs usados (5000 no máx., ordenados por endereço):',
	'checkuser-user-nonexistent' => 'O utilizador especificado não existe.',
	'checkuser-search-form'      => 'Procurar entradas no registo onde $1 seja $2',
	'checkuser-search-submit'    => 'Procurar',
	'checkuser-search-initiator' => 'iniciador',
	'checkuser-search-target'    => 'alvo',
	'checkuser-ipeditcount'      => '~$1 de todos os utilizadores',
	'checkuser-log-subpage'      => 'Registo',
	'checkuser-log-return'       => 'Retornar ao formulário principal de CheckUser',
	'checkuser-log-userips'      => '$1 obteve IPs de $2',
	'checkuser-log-ipedits'      => '$1 obteve edições de $2',
	'checkuser-log-ipusers'      => '$1 obteve utilizadores de $2',
	'checkuser-log-ipedits-xff'  => '$1 obteve edições para o XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 obteve utilizadores para o XFF $2',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'checkuser-summary'          => "Kay llamk'anaqa ñaqha hukchasqakunapim maskaykun huk ruraqpa llamk'achisqan IP huchhakunata chaskinapaq icha huk IP huchhap llamk'apusqamanta/ruraqmanta willankunata rikuchinapaq.
Ruraqkunata icha mink'akuq IP huchhap rurasqankunatapas XFF uma siq'iwanmi chaskiyta atinki IP huchhata \"/xff\" nisqawan yapaspa. IPv4 (CIDR 16-32), IPv6 (CIDR 64-128) nisqakunam llamk'akun.
Pichqa waranqamanta aswan llamk'apusqakunaqa manam kutimunqachu, allin rikuchinarayku. Kay llamk'anataqa kawpayllakama rurachiy.",
	'checkuser-logcase'          => "Hallch'a maskaqqa hatun sananchata uchuy sananchamantam sapaqchan.",
	'checkuser'                  => 'Ruraqta llanchiy',
	'group-checkuser'            => 'Ruraqkunata llanchiy',
	'group-checkuser-member'     => 'Ruraqta llanchiy',
	'grouppage-checkuser'        => '{{ns:project}}:Ruraqta llanchiy',
	'checkuser-reason'           => 'Imarayku',
	'checkuser-showlog'          => "Hallch'ata rikuchiy",
	'checkuser-log'              => "Ruraq llanchiy hallch'a",
	'checkuser-query'            => 'Ñaqha hukchasqakunapi maskay',
	'checkuser-target'           => 'Ruraqpa sutin icha IP huchha',
	'checkuser-users'            => 'Ruraqkunata chaskiy',
	'checkuser-edits'            => 'Ruraqkunap hukchasqankunata chaskiy',
	'checkuser-ips'              => 'IP huchhakunata chaskiy',
	'checkuser-search'           => 'Maskay',
	'checkuser-empty'            => "Manam kanchu ima hallch'asqapas.",
	'checkuser-nomatch'          => 'Manam imapas taripasqachu.',
	'checkuser-check'            => 'Llanchiy',
	'checkuser-log-fail'         => "Manam atinichu hallch'aman yapayta",
	'checkuser-nolog'            => "Manam hallch'ayta tarinichu",
	'checkuser-blocked'          => "Hark'asqa",
	'checkuser-too-many'         => "Nisyum tarisqakuna, ama hina kaspa CIDR nisqata k'ichkichay. Kaymi llamk'achisqa IP huchhakuna (5000-kama, tiyay sutikama siq'inchasqa):",
	'checkuser-user-nonexistent' => 'Nisqayki ruraqqa manam kanchu.',
	'checkuser-search-submit'    => 'Maskay',
	'checkuser-search-initiator' => 'qallarichiq',
	'checkuser-search-target'    => 'taripana',
	'checkuser-log-subpage'      => "Hallch'a",
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'checkuser-search'        => 'Tarzzut',
	'checkuser-search-submit' => 'Tarzzut',
);

/** Rhaeto-Romance (Rumantsch)
 * @author SPQRobin
 */
$messages['rm'] = array(
	'checkuser-reason' => 'Motiv',
	'checkuser-search' => 'Tschertgar',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Emily
 */
$messages['ro'] = array(
	'checkuser'               => 'Verifică utilizatorul',
	'group-checkuser'         => 'Checkuseri',
	'group-checkuser-member'  => 'Checkuser',
	'grouppage-checkuser'     => '{{ns:project}}:Checkuser',
	'checkuser-reason'        => 'Motiv',
	'checkuser-showlog'       => 'Arată jurnal',
	'checkuser-target'        => 'Utilizator sau IP',
	'checkuser-search'        => 'Caută',
	'checkuser-blocked'       => 'Blocat',
	'checkuser-search-submit' => 'Caută',
	'checkuser-log-subpage'   => 'Jurnal',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'checkuser-summary'          => "Данный инструмент может быть использован, чтобы получить IP-адреса, использовавшиеся участником, либо чтобы показать правки/участников, работавших с IP-адреса.
	Правки и пользователи, которые правили с опрделеннного IP-адреса, указанного в X-Forwarded-For, можно получить, добавив префикс <code>/xff</code> к IP-адресу. Поддерживаемые версии IP: 4 (CIDR 16—32) и 6 (CIDR 64—128).
	Из соображений производительности будут показаны только первые 5000 правок. Используйте эту страницу '''только в соответствии с правилами'''.",
	'checkuser-desc'             => 'Предоставление возможности проверять IP-адреса и другую информацию участников',
	'checkuser-logcase'          => 'Поиск по журналу чувствителен к регистру.',
	'checkuser'                  => 'Проверить участника',
	'group-checkuser'            => 'Проверяющие участников',
	'group-checkuser-member'     => 'проверяющий участников',
	'right-checkuser'            => 'проверка IP-адресов участников и другой информации',
	'grouppage-checkuser'        => '{{ns:project}}:Проверка участников',
	'checkuser-reason'           => 'Причина',
	'checkuser-showlog'          => 'Показать журнал',
	'checkuser-log'              => 'Журнал проверки участников',
	'checkuser-query'            => 'Запросить свежие правки',
	'checkuser-target'           => 'Пользователь или IP-адрес',
	'checkuser-users'            => 'Получить пользователей',
	'checkuser-edits'            => 'Запросить правки, сделанные с IP-адреса',
	'checkuser-ips'              => 'Запросить IP-адреса',
	'checkuser-search'           => 'Найти',
	'checkuser-empty'            => 'Журнал пуст.',
	'checkuser-nomatch'          => 'Совпадений не найдено.',
	'checkuser-check'            => 'Проверить',
	'checkuser-log-fail'         => 'Невозможно добавить запись в журнал',
	'checkuser-nolog'            => 'Файл журнала не найден.',
	'checkuser-blocked'          => 'Заблокирован',
	'checkuser-too-many'         => 'Слишком много результатов, пожалуйста, сузьте CIDR. Использованные IP (максимум 5000, отсортировано по адресу):',
	'checkuser-user-nonexistent' => 'Указанного участника не существует',
	'checkuser-search-form'      => 'Найти записи журнала, где $1 является $2',
	'checkuser-search-submit'    => 'Найти',
	'checkuser-search-initiator' => 'инициатор',
	'checkuser-search-target'    => 'цель',
	'checkuser-ipeditcount'      => '~$1 от всех участников',
	'checkuser-log-subpage'      => 'Журнал',
	'checkuser-log-return'       => 'Возврат к главной форме проверки участников',
	'checkuser-log-userips'      => '$1 получил IP адреса для $2',
	'checkuser-log-ipedits'      => '$1 получил правки для $2',
	'checkuser-log-ipusers'      => '$1 получил учётные записи для $2',
	'checkuser-log-ipedits-xff'  => '$1 получил правки для XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 получил учётные записи для XFF $2',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'checkuser-summary'          => "Бу үстүрүмүөнү кыттааччы IP-ларын көрөргө, эбэтэр IP-аадырыһы туһаммыт хас да кыттааччы уларытыыларын көрөргө туттуохха сөп.
Биир IP-аадырыстан оҥоһуллубут көннөрүүлэри, эбэтэр ону туһаммыт X-Forwarded-For ыйыллыбыт кыттааччылары көрөргө, бу префиксы IP-га туруоран биэр: <code>/xff</code>. Поддерживаемые версии IP: 4 (CIDR 16—32) и 6 (CIDR 64—128).
Систиэмэни ноҕуруускалаамаары бастакы 5000 көннөрүү эрэ көрдөрүллүөҕэ. Бу сирэйи '''сиэрдээхтик''' тутун.",
	'checkuser-desc'             => 'Кыттаачылар IP-ларын уонна кинилэр тустарынан атын сибидиэнньэлэри көрөр кыаҕы биэрии.',
	'checkuser-logcase'          => 'Сурунаалга көрдөөһүн улахан/кыра буукубалары араарар.',
	'checkuser'                  => 'Кыттааччыны бэрэбиэркэлээ',
	'group-checkuser'            => 'Кыттааччылары бэрэбиэркэлээччилэр',
	'group-checkuser-member'     => 'Кыттааччылары бэрэбиэркэлээччи',
	'grouppage-checkuser'        => '{{ns:project}}:Кыттааччылары бэрэбиэркэлээһин',
	'checkuser-reason'           => 'Төрүөтэ',
	'checkuser-showlog'          => 'Сурунаалы көрдөр',
	'checkuser-log'              => 'Кыттаачылары бэрэбиэркэлээһин сурунаала',
	'checkuser-query'            => 'Саҥа көннөрүүлэри көрдөр',
	'checkuser-target'           => 'Кыттааччы эбэтэр IP',
	'checkuser-users'            => 'Кыттаачылары ыларга',
	'checkuser-edits'            => 'Бу IP-тан оҥоһуллубут көннөрүүлэри көрөргө',
	'checkuser-ips'              => 'IP-лары көрдөр',
	'checkuser-search'           => 'Көрдөө',
	'checkuser-empty'            => 'Сурунаал кураанах',
	'checkuser-nomatch'          => 'Сөп түбэһиилэр көстүбэтилэр',
	'checkuser-check'            => 'Бэрэбиэркэлээ',
	'checkuser-log-fail'         => 'Сурунаалга сурук эбэр табыллыбат(а)',
	'checkuser-nolog'            => 'Сурунаал билэтэ көстүбэтэ',
	'checkuser-blocked'          => 'Тугу эмэ гынара бобуллубут',
	'checkuser-too-many'         => 'Наһаа элбэх булулунна, бука диэн CIDR кыччатан биэр. Туһаныллыбыт IP (саамай элбэҕэ 5000, бу аадырыһынан наардаммыт):',
	'checkuser-user-nonexistent' => 'Маннык ааттаах кыттааччы суох',
	'checkuser-search-form'      => '$1 сурунаалга $2 буоларын бул',
	'checkuser-search-submit'    => 'Буларга',
	'checkuser-search-initiator' => 'саҕалааччы',
	'checkuser-search-target'    => 'сыал-сорук',
	'checkuser-log-subpage'      => 'Сурунаал',
	'checkuser-log-return'       => 'Кытааччылары бэрэбиэркэлээһин сүрүн сирэйигэр төнүн',
	'checkuser-log-userips'      => '$1 манна анаан $2 IP аадырыстаах',
	'checkuser-log-ipedits'      => '$1 манна анаан $2 көннөрүүлэрдээх',
	'checkuser-log-ipusers'      => '$1 манна анаан $2 ааттардаах (учётные записи)',
	'checkuser-log-ipedits-xff'  => '$1 манна анаан XFF $2 көннөрүүлэрдээх',
	'checkuser-log-ipusers-xff'  => '$1 кыттаачылары ылбыт (для XFF $2)',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Martin Kozák
 */
$messages['sk'] = array(
	'checkuser-summary'          => 'Tento nástroj kontroluje Posledné úpravy, aby získal IP adresy používané používateľom alebo zobrazil úpravy/používateľské dáta IP adresy.
	Používateľov a úpravy je možné získať s XFF IP pridaním „/xff“ k IP. Sú podporované IPv4 (CIDR 16-32) a IPv6 (CIDR 64-128).
	Z dôvodov výkonnosti nebude vrátených viac ako 5000 úprav. Túto funkciu využívajte len v súlade s platnou politikou.',
	'checkuser-desc'             => 'Dáva používateľom s príslušným oprávnením možnosť overovať IP adresu a iné informácie o používateľovi',
	'checkuser-logcase'          => 'Vyhľadávanie v zázname zohľadňuje veľkosť písmen.',
	'checkuser'                  => 'Overiť používateľa',
	'group-checkuser'            => 'Revízor',
	'group-checkuser-member'     => 'Revízori',
	'right-checkuser'            => 'Skontrolovať IP adresy a iné informácie používateľov',
	'grouppage-checkuser'        => '{{ns:project}}:Revízia používateľa',
	'checkuser-reason'           => 'Dôvod',
	'checkuser-showlog'          => 'Zobraziť záznam',
	'checkuser-log'              => 'Záznam kontroly používateľov',
	'checkuser-query'            => 'Získať z posledných úprav',
	'checkuser-target'           => 'Používateľ alebo IP',
	'checkuser-users'            => 'Získať používateľov',
	'checkuser-edits'            => 'Získať úpravy z IP',
	'checkuser-ips'              => 'Získať IP adresy',
	'checkuser-search'           => 'Hľadať',
	'checkuser-empty'            => 'Záznam neobsahuje žiadne položky.',
	'checkuser-nomatch'          => 'Žiadny vyhovujúci záznam.',
	'checkuser-check'            => 'Skontrolovať',
	'checkuser-log-fail'         => 'Nebolo možné pridať položku záznamu',
	'checkuser-nolog'            => 'Nebol nájdený súbor záznamu.',
	'checkuser-blocked'          => 'Zablokovaný',
	'checkuser-too-many'         => 'Príliš veľa výsledkov, prosím zúžte CIDR. Tu sú použité IP (max. 5 000, zoradené podľa adresy):',
	'checkuser-user-nonexistent' => 'Uvedený používateľ neexistuje.',
	'checkuser-search-form'      => 'Nájsť položky záznamu, kde $1 je $2',
	'checkuser-search-submit'    => 'Hľadať',
	'checkuser-search-initiator' => 'začínajúci',
	'checkuser-search-target'    => 'cieľ',
	'checkuser-ipeditcount'      => 'asi $1 zo všetkých používateľov',
	'checkuser-log-subpage'      => 'Záznam',
	'checkuser-log-return'       => 'Vrátiť sa na hlavný formulár CheckUser',
	'checkuser-log-userips'      => '$1 má IP adresy $2',
	'checkuser-log-ipedits'      => '$1 má úpravy $2',
	'checkuser-log-ipusers'      => '$1 má používateľov $2',
	'checkuser-log-ipedits-xff'  => '$1 má úpravy XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 má používateľov XFF $2',
);

/** Albanian (Shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'checkuser' => 'Kontrollo përdoruesin',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 * @author Millosh
 */
$messages['sr-ec'] = array(
	'checkuser-desc'             => 'Даје сарадницима са одговарајућим правима могућност да провере ИП адресе сарадника и друге информације.',
	'checkuser-logcase'          => 'Претрага лога је осетљива на мала и велика слова.',
	'checkuser'                  => 'Чекјузер',
	'group-checkuser'            => 'Чекјузери',
	'group-checkuser-member'     => 'Чекјузер',
	'right-checkuser'            => 'Проверава сарадничке ИП адресе и друге информације.',
	'grouppage-checkuser'        => '{{ns:project}}:Чекјузер',
	'checkuser-reason'           => 'Резлог',
	'checkuser-showlog'          => 'Прикажи лог.',
	'checkuser-log'              => 'Лог чекјузера.',
	'checkuser-query'            => 'Упит на скорашње измене.',
	'checkuser-target'           => 'Корисник или ИП',
	'checkuser-users'            => 'Прикупљање сарадничких имена.',
	'checkuser-edits'            => 'Прикупљање измена од стране ИП адресе.',
	'checkuser-ips'              => 'Прикупља ИП адресе.',
	'checkuser-search'           => 'Претрага',
	'checkuser-empty'            => 'Лог не садржи ништа.',
	'checkuser-nomatch'          => 'Нема погодака.',
	'checkuser-check'            => 'Провера',
	'checkuser-log-fail'         => 'Није било могуће додати податак у лог.',
	'checkuser-nolog'            => 'Ниједан фајл с логовима није пронађен.',
	'checkuser-blocked'          => 'Блокиран',
	'checkuser-too-many'         => 'Превише резултата; смањи CIDR. Ево списка коришћених ИП адреса (максимално 5000, сортирано по адреси):',
	'checkuser-user-nonexistent' => 'Тражени сарадник не постоји.',
	'checkuser-search-form'      => 'Претрага лога где је $1 једнако $2.',
	'checkuser-search-submit'    => 'Претрага',
	'checkuser-search-initiator' => 'покретач',
);

/** latinica (latinica) */
$messages['sr-el'] = array(
	'checkuser'              => 'Čekjuzer',
	'group-checkuser'        => 'Čekjuzeri',
	'group-checkuser-member' => 'Čekjuzer',
	'grouppage-checkuser'    => '{{ns:project}}:Čekjuzer',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'checkuser-summary'          => 'Disse Reewe truchsäkt do lääste Annerengen, uum ju IP-Adresse fon n Benutser
	blw. do Beoarbaidengen/Benutsernoomen foar ne IP-Adresse fäästtoustaalen. Benutsere un
Beoarbaidengen fon ne IP-Adresse konnen uk ätter Informatione uut do XFF-Headere
	oufräiged wäide, as an ju IP-Adresse n „/xff“ anhonged wäd. (CIDR 16-32) un IPv6 (CIDR 64-128) wäide unnerstutsed.
	Uut Perfomance-Gruunde wäide maximoal 5000 Beoarbaidengen uutroat. Benutsje CheckUser bloot in Uureenstämmenge mäd do Doatenschutsgjuchtlienjen.',
	'checkuser-desc'             => 'Ferlööwet Benutsere mäd do äntspreekende Gjuchte do IP-Adressen as uk wiedere Informatione fon Benutsere tou wröigjen.',
	'checkuser-logcase'          => 'Ju Säike in dät Logbouk unnerschat twiske Groot- un Littikschrieuwen.',
	'checkuser'                  => 'Checkuser',
	'group-checkuser'            => 'Checkusers',
	'group-checkuser-member'     => 'Checkuser-Begjuchtigde',
	'grouppage-checkuser'        => '{{ns:project}}:CheckUser',
	'checkuser-reason'           => 'Gruund',
	'checkuser-showlog'          => 'Logbouk anwiese',
	'checkuser-log'              => 'Checkuser-Logbouk',
	'checkuser-query'            => 'Lääste Annerengen oufräigje',
	'checkuser-target'           => 'Benutser of IP-Adresse',
	'checkuser-users'            => 'Hoal Benutsere',
	'checkuser-edits'            => 'Hoal Beoarbaidengen fon IP-Adresse',
	'checkuser-ips'              => 'Hoal IP-Adressen',
	'checkuser-search'           => 'Säike',
	'checkuser-empty'            => 'Dät Logbouk änthaalt neen Iendraage.',
	'checkuser-nomatch'          => 'Neen Uureenstämmengen fuunen.',
	'checkuser-check'            => 'Uutfiere',
	'checkuser-log-fail'         => 'Logbouk-Iendraach kon nit bietouföiged wäide.',
	'checkuser-nolog'            => 'Neen Logbouk fuunen.',
	'checkuser-blocked'          => 'speerd',
	'checkuser-too-many'         => 'Ju Lieste fon Resultoate is tou loang, gränsje dän IP-Beräk fääre ien. Hier sunt do benutsede IP-Adressen (maximoal 5000, sortierd ätter Adresse):',
	'checkuser-user-nonexistent' => 'Die anroate Benutser bestoant nit.',
	'checkuser-search-form'      => 'Säik Lochboukiendraage, wier $1 $2 is.',
	'checkuser-search-submit'    => 'Säik',
	'checkuser-search-initiator' => 'Initiator',
	'checkuser-search-target'    => 'Siel',
	'checkuser-log-subpage'      => 'Logbouk',
	'checkuser-log-return'       => 'Tourääch ätter dät CheckUser-Haudformular',
	'checkuser-log-userips'      => '$1 hoalde IP-Adressen foar $2',
	'checkuser-log-ipedits'      => '$1 hoalde Beoarbaidengen foar $2',
	'checkuser-log-ipusers'      => '$1 hoalde Benutsere foar $2',
	'checkuser-log-ipedits-xff'  => '$1 hoalde Beoarbaidengen foar XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 hoalde Benutsere foar XFF $2',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 * @author Irwangatot
 */
$messages['su'] = array(
	'checkuser-desc'             => 'Leler kawenangan pikeun mariksa alamat IP jeung émbaran lianna ti hiji pamaké',
	'checkuser-logcase'          => 'Panyungsi log ngabédakeun kapitalisasi.',
	'checkuser'                  => 'Pamaké pamariksa',
	'group-checkuser'            => 'Pamaké pamariksa',
	'group-checkuser-member'     => 'Pamaké pamariksa',
	'grouppage-checkuser'        => '{{ns:project}}:Pamaké pamariksa',
	'checkuser-reason'           => 'Alesan',
	'checkuser-showlog'          => 'Témbongkeun log',
	'checkuser-log'              => 'Log PamakéPamariksa',
	'checkuser-target'           => 'Landihan atawa IP',
	'checkuser-users'            => 'Sungsi pamaké',
	'checkuser-edits'            => 'Sungsi éditan ti IP',
	'checkuser-ips'              => 'Sungsi IP',
	'checkuser-search'           => 'Sungsi',
	'checkuser-empty'            => 'Logna kosong.',
	'checkuser-nomatch'          => 'Euweuh nu cocog.',
	'checkuser-check'            => 'Pariksa',
	'checkuser-log-fail'         => 'Teu bisa nambahkeun kana log',
	'checkuser-nolog'            => 'Koropak log teu kapanggih.',
	'checkuser-blocked'          => 'Dipeungpeuk',
	'checkuser-too-many'         => 'Hasilna loba teuing, heureutan CIDR-na.
Di handap ieu béréndélan IP nu dipaké (paling loba 5000, disusun dumasar alamat):',
	'checkuser-user-nonexistent' => 'Euweuh pamaké nu cocog jeung pamundut.',
	'checkuser-search-form'      => 'Téang éntri log nu $1-na sarua jeung $2',
	'checkuser-search-submit'    => 'Sungsi',
	'checkuser-search-initiator' => 'inisiator',
	'checkuser-search-target'    => 'tujul',
	'checkuser-ipeditcount'      => '~$1 ti sakumna pamaké',
	'checkuser-log-subpage'      => 'Log',
	'checkuser-log-return'       => 'Balik ka formulir utama PamakéPamariksa',
	'checkuser-log-userips'      => '$1 manggih IP ti $2',
	'checkuser-log-ipedits'      => '$! manggih éditan ti $2',
	'checkuser-log-ipusers'      => '$1 manggih pamaké ti $2',
	'checkuser-log-ipedits-xff'  => '$1 manggih éditan ti XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 manggih pamaké ti XFF $2',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'checkuser-summary'          => 'Det här verktyget söker igenom de senaste ändringarna för att hämta IP-adresser för en användare, eller redigeringar och användare för en IP-adress.
Användare och redigeringar kan visas med IP-adress från XFF genom att lägga till "/xff" efter IP-adressen. Verktyget stödjer IPv4 (CIDR 16-32) och IPv6 (CIDR 64-128).
På grund av prestandaskäl så visas inte mer än 5000 redigeringar. Använd verktyget i enlighet med policy.',
	'checkuser-desc'             => 'Ger möjlighet för användare med speciell behörighet att kontrollera användares IP-adresser och viss annan information',
	'checkuser-logcase'          => 'Loggsökning är skiftlägeskänslig.',
	'checkuser'                  => 'Kontrollera användare',
	'group-checkuser'            => 'Användarkontrollanter',
	'group-checkuser-member'     => 'Användarkontrollant',
	'right-checkuser'            => 'Kolla användares IP-adresser och annan information',
	'grouppage-checkuser'        => '{{ns:project}}:Användarkontrollant',
	'checkuser-reason'           => 'Anledning',
	'checkuser-showlog'          => 'Visa logg',
	'checkuser-log'              => 'Logg över användarkontroller',
	'checkuser-query'            => 'Sök de senaste ändringarna',
	'checkuser-target'           => 'Användare eller IP',
	'checkuser-users'            => 'Hämta användare',
	'checkuser-edits'            => 'Hämta redigeringar från IP-adress',
	'checkuser-ips'              => 'Hämta IP-adresser',
	'checkuser-search'           => 'Sök',
	'checkuser-empty'            => 'Loggen innehåller inga poster.',
	'checkuser-nomatch'          => 'Inga träffar hittades.',
	'checkuser-check'            => 'Kontrollera',
	'checkuser-log-fail'         => 'Loggposten kunde inte läggas i loggfilen.',
	'checkuser-nolog'            => 'Hittade ingen loggfil.',
	'checkuser-blocked'          => 'Blockerad',
	'checkuser-too-many'         => 'För många resultat, du bör söka i ett mindre CIDR-block. Här följer de använda IP-adresserna (högst 5000, sorterade efter adress):',
	'checkuser-user-nonexistent' => 'Användarnamnet som angavs finns inte.',
	'checkuser-search-form'      => 'Sök  efter poster där $1 är $2',
	'checkuser-search-submit'    => 'Sök',
	'checkuser-search-initiator' => 'kontrollanten',
	'checkuser-search-target'    => 'kontrollmålet',
	'checkuser-ipeditcount'      => '~$1 från alla användare',
	'checkuser-log-subpage'      => 'Logg',
	'checkuser-log-return'       => 'Gå tillbaka till formuläret för användarkontroll',
	'checkuser-log-userips'      => '$1 hämtade IP-adresser för $2',
	'checkuser-log-ipedits'      => '$1 hämtade redigeringar från $2',
	'checkuser-log-ipusers'      => '$1 hämtade användare från $2',
	'checkuser-log-ipedits-xff'  => '$1 hämtade redigeringar från XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 hämtade användare från XFF $2',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'checkuser-reason'        => 'Čymu',
	'checkuser-search'        => 'Šnupej',
	'checkuser-search-submit' => 'Šnupej',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'checkuser-search'        => 'தேடுக',
	'checkuser-search-submit' => 'தேடுக',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 * @author వైజాసత్య
 * @author Mpradeep
 */
$messages['te'] = array(
	'checkuser-summary'          => 'ఈ పరికరం ఓ వాడుకరి వాడిన ఐపీలను, లేదా ఒక ఐపీకి చెందిన దిద్దుబాట్లు, వాడుకరుల డేటాను చూపిస్తుంది.
క్లయంటు ఐపీకి చెందిన వాడుకరులు, దిద్దుబాట్లను ఐపీకి /xff అని చేర్చి, XFF హెడర్ల ద్వారా వెలికితీయవచ్చు. IPv4 (CIDR 16-32) and IPv6 (CIDR 64-128) లు పనిచేస్తాయి.
పనితనపు కారణాల వలన 5000 దిద్దుబాట్లకు మించి చూపించము. విధానాల కనుగుణంగా దీన్ని వాడండి.',
	'checkuser-desc'             => 'వాడుకరి ఐపీ అడ్రసు, ఇతర సమాచారాన్ని చూడగలిగే అనుమతులను వాడుకరులకు ఇస్తుంది',
	'checkuser-logcase'          => 'లాగ్ అన్వేషణ కోసం ఇంగ్లీషు అన్వేషకం ఇస్తే.., అది కేస్ సెన్సిటివ్.',
	'checkuser'                  => 'సభ్యుల తనిఖీ',
	'group-checkuser'            => 'సభ్యుల తనిఖీదార్లు',
	'group-checkuser-member'     => 'సభ్యుల తనిఖీదారు',
	'right-checkuser'            => 'వాడుకరి ఐపీ అడ్రసును, ఇతర సమాచారాన్ని చూడు',
	'grouppage-checkuser'        => '{{ns:project}}:వాడుకరిని పరిశీలించు',
	'checkuser-reason'           => 'కారణం',
	'checkuser-showlog'          => 'లాగ్ చూపించు',
	'checkuser-log'              => 'వాడుకరిపరిశీలన లాగ్',
	'checkuser-query'            => 'ఇటీవలి మార్పుల్లో చూడండి',
	'checkuser-target'           => 'వాడుకరి లేదా ఐపీ',
	'checkuser-users'            => 'వాడుకరులను తీసుకురా',
	'checkuser-edits'            => 'ఈ ఐపీ అడ్రస్సు నుండి చేసిన మార్పులను చూపించు',
	'checkuser-ips'              => 'ఐపీలను తీసుకురా',
	'checkuser-search'           => 'వెతుకు',
	'checkuser-empty'            => 'లాగ్&zwnj;లో అంశాలేమీ లేవు.',
	'checkuser-nomatch'          => 'సామీప్యాలు ఏమీ కనబడలేదు.',
	'checkuser-check'            => 'తనిఖీ',
	'checkuser-log-fail'         => 'లాగ్&zwnj;లో పద్దుని చేర్చలేకపోయాం',
	'checkuser-nolog'            => 'ఏ లాగ్ ఫైలు కనపడలేదు',
	'checkuser-blocked'          => 'నిరోధించాం',
	'checkuser-too-many'         => 'మరీ ఎక్కువ ఫలితాలొచ్చాయి. CIDR ను మరింత కుదించండి. వాడిన ఐపీలివిగో (గరిష్ఠంగా 5000 -అడ్రసు వారీగా పేర్చి)',
	'checkuser-user-nonexistent' => 'ఆ వాడుకరి ఉనికిలో లేరు.',
	'checkuser-search-form'      => '$1 అనేది $2గా ఉన్న లాగ్ పద్దులను కనుగొనండి',
	'checkuser-search-submit'    => 'వెతుకు',
	'checkuser-search-initiator' => 'ఆరంభకుడు',
	'checkuser-search-target'    => 'లక్ష్యం',
	'checkuser-ipeditcount'      => 'వాడుకరులందరి నుండి ~$1',
	'checkuser-log-subpage'      => 'లాగ్',
	'checkuser-log-return'       => 'CheckUser ముఖ్య ఫారముకు వెళ్ళు',
	'checkuser-log-userips'      => '$2 కోసం $1 ఐపీలను తెచ్చింది',
	'checkuser-log-ipedits'      => '$2 కోసం $1 దిద్దుబాట్లను తెచ్చింది',
	'checkuser-log-ipusers'      => '$2 కోసం $1 వాడుకరులను తెచ్చింది',
	'checkuser-log-ipedits-xff'  => 'XFF $2 కోసం $1, దిద్దుబాట్లను తెచ్చింది',
	'checkuser-log-ipusers-xff'  => 'XFF $2 కోసం $1, వాడుకరులను తెచ్చింది',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'checkuser-log'           => 'Lista checkuser',
	'checkuser-target'        => "Uza-na'in ka IP",
	'checkuser-users'         => "Uza-na'in sira",
	'checkuser-edits'         => 'Edita husi IP',
	'checkuser-ips'           => 'IP sira',
	'checkuser-search'        => 'Buka',
	'checkuser-search-submit' => 'Buka',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'checkuser-summary'          => 'Ин абзор тағйироти охирро барои ба даст овардани нишонаҳои интернетӣ IP  истифода шуда тавассути як корбар ё таъйини вироишҳои анчом шуда тариқи як нишонаи интернетӣ IP, ҷустуҷӯ мекунад.
Корбарон ва вироишҳои як нишонаи интернетии IP-ро метавон бо таваҷҷӯҳ ба иттилоот сар оянд тариқи XFF бо афзудан нишонаи интернетӣ IP бо "/xff" пайдо кард. Ҳар ду протокол IPv4 (CIDR 16-32) ва IPv6 (CIDR 64-128) тавассути ин абзор пуштибонӣ мешаванд.
На беш аз 5000 вироиш бо далелҳои зудкорӣ баргардонида хоҳанд шуд. Бо мувофиқи сиёсат ва қоидаҳо инро истода кунед.',
	'checkuser-desc'             => 'Ба корбарон ихтиёроти лозимиро барои баррасии нишонаҳои интернетӣ IP корбарон ва иттилооти дигар, иҷозат медиҳад',
	'checkuser-logcase'          => 'Ҷустуҷӯи гузориш ба хурд ё бузрг будани ҳарфҳо ҳасос аст.',
	'checkuser'                  => 'Бозрасии корбар',
	'group-checkuser'            => 'Бозрасии корбарон',
	'group-checkuser-member'     => 'Бозрасии корбар',
	'right-checkuser'            => 'Барраси кардани нишонаи IP ва дигар иттилооти корбар',
	'grouppage-checkuser'        => '{{ns:project}}:Бозрасии корбар',
	'checkuser-reason'           => 'Далел',
	'checkuser-showlog'          => 'Намоиши гузориш',
	'checkuser-log'              => 'БозрасиКорбар гузориш',
	'checkuser-query'            => 'Ҷустуҷӯи тағйироти охир',
	'checkuser-target'           => 'Корбар ё нишонаи IP',
	'checkuser-users'            => 'Феҳрист кардани корбарон',
	'checkuser-edits'            => 'Намоиши вироишҳои марбут ба ин нишонаи IP',
	'checkuser-ips'              => 'Феҳрист кардани нишонаҳои IP',
	'checkuser-search'           => 'Ҷустуҷӯ',
	'checkuser-empty'            => 'Гузориш холӣ аст.',
	'checkuser-nomatch'          => 'Мавриде ки мутобиқат дошта бошад пайдо нашуд',
	'checkuser-check'            => 'Барраси',
	'checkuser-log-fail'         => 'Имкони афзудани иттилоот ба гузориш вуҷуд надорад',
	'checkuser-nolog'            => 'Парвандаи гузориш пайдо нашуд.',
	'checkuser-blocked'          => 'Дастрасӣ қатъ шуд',
	'checkuser-too-many'         => 'Теъдоди натоиҷ бисёр зиёд аст. Лутфан CIDRро бориктар кунед. Дар зер нишонаҳои IP-ро мебинед (5000 ҳадди аксар, аз рбатартиби нинона):',
	'checkuser-user-nonexistent' => 'Корбари мавриди назар вуҷуд надорад.',
	'checkuser-search-form'      => 'Пайдо кардани маворид дар гузоришҳо, ки $1 дар он $2 аст',
	'checkuser-search-submit'    => 'Ҷустуҷӯ',
	'checkuser-search-initiator' => 'оғозгар',
	'checkuser-search-target'    => 'ҳадаф',
	'checkuser-log-subpage'      => 'Гузориш',
	'checkuser-log-return'       => 'Бозгашт ба форми аслии бозрасии корбар',
	'checkuser-log-userips'      => '$1 нишонаҳои интернетии IP-ҳои $2ро гирифт',
	'checkuser-log-ipedits'      => '$1 вироишҳои $2ро гирифт',
	'checkuser-log-ipusers'      => '$1 корбарони марбут ба $2ро гирифт',
	'checkuser-log-ipedits-xff'  => '$1 вироишҳои XFF $2ро гирифт',
	'checkuser-log-ipusers-xff'  => '$1 корбарони марбут ба XFF $2ро гирифт',
);

/** Tonga (faka-Tonga)
 * @author SPQRobin
 */
$messages['to'] = array(
	'checkuser'              => 'Siviʻi ʻa e ʻetita',
	'group-checkuser'        => 'Siviʻi kau ʻetita',
	'group-checkuser-member' => 'Siviʻi ʻa e ʻetita',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author SPQRobin
 * @author Karduelis
 * @author Mach
 * @author Suelnur
 * @author Dbl2010
 */
$messages['tr'] = array(
	'checkuser'                  => 'IP denetçisi',
	'group-checkuser'            => 'Denetçiler',
	'group-checkuser-member'     => 'Denetçi',
	'grouppage-checkuser'        => '{{ns:project}}:Denetçi',
	'checkuser-reason'           => 'Neden',
	'checkuser-showlog'          => 'Logu göster',
	'checkuser-log'              => 'Denetçi kaydı',
	'checkuser-target'           => 'Kullanıcı veya IP',
	'checkuser-users'            => 'Kullanıcıları bulup getir',
	'checkuser-ips'              => 'IPleri bulup getir',
	'checkuser-search'           => 'Ara',
	'checkuser-check'            => 'Kontrol et',
	'checkuser-blocked'          => 'Engellendi',
	'checkuser-search-submit'    => 'Ara',
	'checkuser-search-initiator' => 'Başlatan',
	'checkuser-search-target'    => 'Hedef',
	'checkuser-log-subpage'      => 'Kayıt',
);

/** Ukrainian (Українська)
 * @author Ahonc
 * @author AS
 */
$messages['uk'] = array(
	'checkuser-summary'          => 'Цей засіб переглядає нові редагування для отримання IP-адрес, які використовував певний користувач, або щоб знайти редагування/користувача за IP-адресою.
Редагування і користувачів, що редагували з певної IP-адреси, заначеної в X-Forwarded-For, можна отримати, додавши префікс <code>/xff</code> до IP-адреси. Підтримувані версії IP: 4 (CIDR 16—32) і 6 (CIDR 64—128).
З огляду на продуктивність буде показано не більше 5000 редагувань.
Використовуйте цей засіб тільки відповідно до правил.',
	'checkuser-desc'             => 'Надання можливості перевіряти IP-адреси та іншу інформацію користувачів',
	'checkuser-logcase'          => 'Пошук у журналі чутливий до регістру.',
	'checkuser'                  => 'Перевірити користувача',
	'group-checkuser'            => "Чек'юзери",
	'group-checkuser-member'     => "чек'юзер",
	'right-checkuser'            => 'Перевірка IP-адрес та іншої інформації користувача',
	'grouppage-checkuser'        => '{{ns:project}}:Перевірка користувачів',
	'checkuser-reason'           => 'Причина',
	'checkuser-showlog'          => 'Показати журнал',
	'checkuser-log'              => 'Журнал перевірки користувачів',
	'checkuser-query'            => 'Запитати останні зміни',
	'checkuser-target'           => 'Користувач або IP-адреса',
	'checkuser-users'            => 'Отримати користувачів',
	'checkuser-edits'            => 'Запитати редагування, зроблені з IP-адреси',
	'checkuser-ips'              => 'Запитати IP-адреси',
	'checkuser-search'           => 'Знайти',
	'checkuser-empty'            => 'Журнал порожній.',
	'checkuser-nomatch'          => 'Не знайдено співпадінь.',
	'checkuser-check'            => 'Перевірити',
	'checkuser-log-fail'         => 'Не в змозі додати запис до журналу',
	'checkuser-nolog'            => 'Файл журналу не знайдений.',
	'checkuser-blocked'          => 'Заблокований',
	'checkuser-too-many'         => 'Забагато результатів. Будь ласка, звузьте CIDR.
Використані IP (максимум 5000, відсортовано за адресою):',
	'checkuser-user-nonexistent' => 'Зазначений користувач не існує.',
	'checkuser-search-form'      => 'Знайти записи журналу, де $1 є $2',
	'checkuser-search-submit'    => 'Знайти',
	'checkuser-search-initiator' => 'ініціатор',
	'checkuser-search-target'    => 'ціль',
	'checkuser-ipeditcount'      => '~$1 від усіх користувачів',
	'checkuser-log-subpage'      => 'Журнал',
	'checkuser-log-return'       => 'Повернення до головної форми перевірки користувачів',
	'checkuser-log-userips'      => '$1 отримав IP-адреси для $2',
	'checkuser-log-ipedits'      => '$1 отримав редагування для $2',
	'checkuser-log-ipusers'      => '$1 отримав облікові записи для $2',
	'checkuser-log-ipedits-xff'  => '$1 отримав редагування для XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 отримав облікові записи для XFF $2',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'checkuser-summary'          => 'Sto strumento qua l\'analiza le modifiche reçenti par recuperar i indirizi IP doparà da un utente o mostrar contributi e dati de un IP. Utenti e contributi de un client IP i se pol rintraciar atraverso i header XFF, zontàndoghe a l\'IP el suffisso "/xff". Xe suportà IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128). No sarà restituìe piassè de 5.000 modifiche, par ragioni de prestazioni. Dòpara sto strumento in streta conformità a le policy.',
	'checkuser-desc'             => 'Consente ai utenti co le oportune autorizazion de sotopor a verifica i indirizi IP e altre informazion relative ai utenti',
	'checkuser-logcase'          => "La riçerca nei registri la xe ''case sensitive'' (cioè la distingue fra majuscole e minuscole).",
	'checkuser'                  => 'Controlo utenze',
	'group-checkuser'            => 'Controlori',
	'group-checkuser-member'     => 'Controlor',
	'right-checkuser'            => "Controla i indirissi IP de l'utente e altre informassion",
	'grouppage-checkuser'        => '{{ns:project}}:Controlo utenze',
	'checkuser-reason'           => 'Motivo',
	'checkuser-showlog'          => 'Mostra el registro',
	'checkuser-log'              => 'Registro dei checkuser',
	'checkuser-query'            => 'Çerca ne le ultime modifiche',
	'checkuser-target'           => 'Utente o IP',
	'checkuser-users'            => 'Çerca utenti',
	'checkuser-edits'            => 'Varda i contributi dei IP',
	'checkuser-ips'              => 'Çerca IP',
	'checkuser-search'           => 'Çerca',
	'checkuser-empty'            => "El registro no'l contien dati.",
	'checkuser-nomatch'          => 'Nissun risultato catà.',
	'checkuser-check'            => 'Controla',
	'checkuser-log-fail'         => 'Inpossibile zontar la voçe al registro',
	'checkuser-nolog'            => 'No xe stà catà nissun file de registro.',
	'checkuser-blocked'          => 'Blocà',
	'checkuser-too-many'         => 'Xe vegnù fora massa risultati, par piaser dòpara un CIDR piassè ristreto.
Sti qua i xe i IP doparà (fin a un massimo de 5000, ordinà par indirizo):',
	'checkuser-user-nonexistent' => "L'utente indicà no l'esiste mìa.",
	'checkuser-search-form'      => 'Cata fora le voçi del registro par le quali $1 el xe $2',
	'checkuser-search-submit'    => 'Riçerca',
	'checkuser-search-initiator' => 'iniziator',
	'checkuser-search-target'    => 'obietivo',
	'checkuser-ipeditcount'      => '~$1 par tuti i utenti',
	'checkuser-log-subpage'      => 'Registro',
	'checkuser-log-return'       => 'Torna al modulo prinçipal de Controlo utenze',
	'checkuser-log-userips'      => '$1 el gà otegnù i indirizi IP de $2',
	'checkuser-log-ipedits'      => '$1 el gà otegnù le modifiche de $2',
	'checkuser-log-ipusers'      => '$1 el gà otegnù le utenze de $2',
	'checkuser-log-ipedits-xff'  => '$1 el gà otegnù le modifiche de $2 via XFF',
	'checkuser-log-ipusers-xff'  => '$1 el gà otegnù le utenze de $2 via XFF',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'checkuser-summary'          => 'Công cụ này sẽ quét các thay đổi gần đây để lấy ra các IP được một thành viên sử dụng hoặc hiển thị dữ liệu sửa đổi/tài khoản của một IP. Các tài khoản và sửa đổi của một IP có thể được trích ra từ tiêu đề XFF bằng cách thêm vào IP “/xff”. IPv4 (CIDR 16-32) và IPv6 (CIDR 64-128) đều được hỗ trợ. Không quá 5000 sửa đổi sẽ được trả về vì lý do hiệu suất. Hãy dùng công cụ này theo đúng quy định.',
	'checkuser-desc'             => 'Cung cấp cho những người đủ tiêu chuẩn khả năng kiểm tra địa chỉ IP và thông tin khác của người dùng khác',
	'checkuser-logcase'          => 'Tìm kiếm nhật trình có phân biệt chữ hoa chữ thường',
	'checkuser'                  => 'Kiểm định viên',
	'group-checkuser'            => 'Kiểm định viên',
	'group-checkuser-member'     => 'Kiểm định viên',
	'right-checkuser'            => 'Kiểm tra địa chỉ IP và các thông tin khác của thành viên',
	'grouppage-checkuser'        => '{{ns:project}}:Kiểm định viên',
	'checkuser-reason'           => 'Lý do',
	'checkuser-showlog'          => 'Xem nhật trình',
	'checkuser-log'              => 'Nhật trình CheckUser',
	'checkuser-query'            => 'Truy vấn các thay đổi gần đây',
	'checkuser-target'           => 'Thành viên hay IP',
	'checkuser-users'            => 'Lấy ra thành viên',
	'checkuser-edits'            => 'Lấy ra sửa đổi của IP',
	'checkuser-ips'              => 'Lấy ra IP',
	'checkuser-search'           => 'Tìm kiếm',
	'checkuser-empty'            => 'Nhật trình hiện chưa có gì.',
	'checkuser-nomatch'          => 'Không tìm thấy kết quả.',
	'checkuser-check'            => 'Kiểm tra',
	'checkuser-log-fail'         => 'Không thể ghi vào nhật trình',
	'checkuser-nolog'            => 'Không tìm thấy tập tin nhật trình',
	'checkuser-blocked'          => 'Đã cấm',
	'checkuser-too-many'         => 'Có quá nhiều kết quả, xin hãy thu hẹp CIDR. Đây là các IP sử dụng (tối đa 5000, xếp theo địa chỉ):',
	'checkuser-user-nonexistent' => 'Thành viên chỉ định không tồn tại.',
	'checkuser-search-form'      => 'Tìm thấy các mục nhật trình trong đó $1 là $2',
	'checkuser-search-submit'    => 'Tìm kiếm',
	'checkuser-search-initiator' => 'người khởi đầu',
	'checkuser-search-target'    => 'mục tiêu',
	'checkuser-ipeditcount'      => '~$1 khỏi tất cả các thành viên',
	'checkuser-log-subpage'      => 'Nhật trình',
	'checkuser-log-return'       => 'Quay lại mẫu CheckUser chính',
	'checkuser-log-userips'      => '$1 lấy IP để $2',
	'checkuser-log-ipedits'      => '$1 lấy sửa đổi cho $2',
	'checkuser-log-ipusers'      => '$1 lấy thành viên cho $2',
	'checkuser-log-ipedits-xff'  => '$1 lấy sửa đổi cho XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 lấy thành viên cho XFF $2',
);

/** Volapük (Volapük)
 * @author Smeira
 * @author Malafaya
 */
$messages['vo'] = array(
	'checkuser-summary'          => 'Stum at vestigon votükamis brefabüik ad dagetön ladetis-IP fa geban semik pagebölis, ud ad jonön redakama- u gebananünis tefü ladet-IP semik.
Gebans e redakams se dona-IP kanons pagetön de tiäds: XFF medä läükoy eli „/xff“ ladete-IP. Els IPv4 (CIDR 16-32) e IPv6 (CIDR 64-128) kanons pagebön.
Redakams no plu 5000 pejonons sekü kods kaenavik. Gebolös stumi at bai nomem.',
	'checkuser-desc'             => 'Gevon gebanes labü däl zesüdik fägi ad vestigön ladeti(s)-IP gebana äsi nünis votik',
	'checkuser-logcase'          => 'Pö suk in registar mayuds e minuds padifükons.',
	'checkuser'                  => 'Vestigön gebani',
	'group-checkuser'            => 'Vestigön gebanis',
	'group-checkuser-member'     => 'Vestigön gebani',
	'grouppage-checkuser'        => '{{ns:project}}:Vestigön gebani',
	'checkuser-reason'           => 'Kod',
	'checkuser-showlog'          => 'Jonön jenotalisedi',
	'checkuser-log'              => 'Vestigön gebani: jenotalised',
	'checkuser-query'            => 'Vestigön votükamis brefabüik',
	'checkuser-target'           => 'Geban u ladet-IP',
	'checkuser-users'            => 'Tuvön gebanis',
	'checkuser-edits'            => 'Tuvön redakamis ladeta-IP',
	'checkuser-ips'              => 'Tuvön ladetis-IP',
	'checkuser-search'           => 'Sukolöd',
	'checkuser-empty'            => 'Lised vagon.',
	'checkuser-nomatch'          => 'Suk no eplöpon.',
	'checkuser-check'            => 'Vestigön',
	'checkuser-log-fail'         => 'No eplöpos ad laükön jenotalisede',
	'checkuser-nolog'            => 'Ragiv jenotaliseda no petuvon.',
	'checkuser-blocked'          => 'Peblokon',
	'checkuser-too-many'         => 'Sukaseks te mödiks, nedol gebön eli CIDR smalikum. Is palisedons ladets-IP pegeböl (jü 5000, peleodüköls ma ladet):',
	'checkuser-user-nonexistent' => 'Geban at no dabinon.',
	'checkuser-search-form'      => 'Tuvön lienis jenotaliseda, kö $1 binon $2',
	'checkuser-search-submit'    => 'Suk',
	'checkuser-search-initiator' => 'flagan',
	'checkuser-search-target'    => 'zeil',
	'checkuser-log-subpage'      => 'Jenotalised',
	'checkuser-log-return'       => 'Geikön lü cifafomet',
	'checkuser-log-userips'      => '$1 labon ladetis-IP ela $2',
	'checkuser-log-ipedits'      => '$1 labon redakamis ela $2',
	'checkuser-log-ipusers'      => '$1 labon gebanis ela $2',
	'checkuser-log-ipedits-xff'  => '$1 labon redakamis ela XFF $2',
	'checkuser-log-ipusers-xff'  => '$1 labon gebanis ela XFF $2',
);

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'checkuser' => "Verifyî l' uzeu",
);

/** Yue (粵語) */
$messages['yue'] = array(
	'checkuser-summary'          => '呢個工具會響最近更改度掃瞄對一位用戶用過嘅IP地址，或者係睇一個IP嘅用戶資料同埋佢嘅編輯記錄。
	響用戶同埋用戶端IP嘅編輯係可幾經由XFF頭，加上 "/xff" 就可以拎到。呢個工具係支援 IPv4 (CIDR 16-32) 同埋 IPv6 (CIDR 64-128)。
	由於為咗效能方面嘅原因，將唔會顯示多過5000次嘅編輯。請跟源政策去用呢個工具。',
	'checkuser-desc'             => '畀合適去查用戶IP或其它嘢嘅能力畀用戶',
	'checkuser-logcase'          => '搵呢個日誌係有分大細楷嘅。',
	'checkuser'                  => '核對用戶',
	'group-checkuser'            => '稽查員',
	'group-checkuser-member'     => '稽查員',
	'right-checkuser'            => '核對用戶嘅IP地址同埋其它嘅資料',
	'grouppage-checkuser'        => '{{ns:project}}:稽查員',
	'checkuser-reason'           => '原因',
	'checkuser-showlog'          => '顯示日誌',
	'checkuser-log'              => '核對用戶日誌',
	'checkuser-query'            => '查詢最近更改',
	'checkuser-target'           => '用戶名或IP',
	'checkuser-users'            => '拎用戶',
	'checkuser-edits'            => '拎IP嘅編輯',
	'checkuser-ips'              => '拎IP',
	'checkuser-search'           => '搵',
	'checkuser-empty'            => '呢個日誌無任何嘅項目。',
	'checkuser-nomatch'          => '搵唔到符合嘅資訊。',
	'checkuser-check'            => '查',
	'checkuser-log-fail'         => '唔能夠加入日誌項目',
	'checkuser-nolog'            => '搵唔到日誌檔。',
	'checkuser-blocked'          => '已經封鎖',
	'checkuser-too-many'         => '太多結果，請收窄個CIDR。
呢度係個用過嘅IP (最多5000個，按地址排):',
	'checkuser-user-nonexistent' => '指定嘅用戶唔存在。',
	'checkuser-search-form'      => '搵當 $1 係 $2 嗰陣時嘅日誌',
	'checkuser-search-submit'    => '搵',
	'checkuser-search-initiator' => '創始者',
	'checkuser-search-target'    => '目標',
	'checkuser-ipeditcount'      => '~響全部用戶度搵$1',
	'checkuser-log-subpage'      => '日誌',
	'checkuser-log-return'       => '返去核對用戶主要表格',
	'checkuser-log-userips'      => '$1 拎到 $2 嘅 IP',
	'checkuser-log-ipedits'      => '$1 拎到 $2 嘅編輯',
	'checkuser-log-ipusers'      => '$1 拎到 $2 嘅用戶',
	'checkuser-log-ipedits-xff'  => '$1 拎到 XFF $2 嘅編輯',
	'checkuser-log-ipusers-xff'  => '$1 拎到 XFF $2 嘅用戶',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'checkuser-summary'          => '本工具会从{{int:recentchanges}}中查询使用者使用过的IP位址，或是一个IP位址发送出来的任何编辑记录。本工具支持IPv4及IPv6的位址。由于技术上的限制，本工具只能查询最近5000笔的记录。请确定你的行为符合守则。',
	'checkuser-desc'             => '让授权的用户检查用户的IP位址及其他资讯',
	'checkuser-logcase'          => '搜寻时请注意大小写的区分',
	'checkuser'                  => '核对用户',
	'group-checkuser'            => '账户核查',
	'group-checkuser-member'     => '账户核查',
	'right-checkuser'            => '查核用户的IP地址以及其它的资料',
	'grouppage-checkuser'        => '{{ns:project}}:账户核查',
	'checkuser-reason'           => '理由',
	'checkuser-showlog'          => '显示日志',
	'checkuser-log'              => '用户查核日志',
	'checkuser-query'            => '查询最近更改',
	'checkuser-target'           => '用户名称或IP位扯',
	'checkuser-users'            => '查询用户名称',
	'checkuser-edits'            => '从IP位址查询编辑日志',
	'checkuser-ips'              => '查询IP位址',
	'checkuser-search'           => '搜寻',
	'checkuser-empty'            => '日志里没有资料。',
	'checkuser-nomatch'          => '没有符合的资讯',
	'checkuser-check'            => '查询',
	'checkuser-log-fail'         => '无法更新日志。',
	'checkuser-nolog'            => '找不到记录档',
	'checkuser-blocked'          => '已经查封',
	'checkuser-too-many'         => '太多结果，请收窄CIDR。
这是使用过?IP (最多5000个，按地址排列):',
	'checkuser-user-nonexistent' => '指定的使用者不存在。',
	'checkuser-search-form'      => '搜寻当 $1 是 $2 时之日志',
	'checkuser-search-submit'    => '搜寻',
	'checkuser-search-initiator' => '创始者',
	'checkuser-search-target'    => '目标',
	'checkuser-ipeditcount'      => '~在全部用户中$1',
	'checkuser-log-subpage'      => '日志',
	'checkuser-log-return'       => '回到查核主表单',
	'checkuser-log-userips'      => '$1取得$2的IP信息',
	'checkuser-log-ipedits'      => '$1取得$2的编辑记录',
	'checkuser-log-ipusers'      => '$1取得$2的用户信息',
	'checkuser-log-ipedits-xff'  => '$1取得 XFF $2的编辑记录',
	'checkuser-log-ipusers-xff'  => '$1取得 XFF $2的用户信息',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 */
$messages['zh-hant'] = array(
	'checkuser-summary'          => '本工具會從{{int:recentchanges}}中查詢使用者使用過的IP位址，或是一個IP位址發送出來的任何編輯記錄。本工具支援IPv4及IPv6的位址。由於技術上的限制，本工具只能查詢最近5000筆的記錄。請確定您的行為符合守則。',
	'checkuser-desc'             => '讓授權的使用者檢查使用者的IP位址及其他資訊',
	'checkuser-logcase'          => '搜尋時請注意大小寫的區分',
	'checkuser'                  => '核對用戶',
	'group-checkuser'            => '用戶查核',
	'group-checkuser-member'     => '用戶查核',
	'right-checkuser'            => '查核用戶的IP地址以及其它的資料',
	'grouppage-checkuser'        => '{{ns:project}}:用戶查核',
	'checkuser-reason'           => '理由',
	'checkuser-showlog'          => '顯示記錄',
	'checkuser-log'              => '用戶查核記錄',
	'checkuser-query'            => '查詢最近更改',
	'checkuser-target'           => '用戶名稱或IP位扯',
	'checkuser-users'            => '查詢用戶名稱',
	'checkuser-edits'            => '從IP位址查詢編輯記錄',
	'checkuser-ips'              => '查詢IP位址',
	'checkuser-search'           => '搜尋',
	'checkuser-empty'            => '記錄裡沒有資料。',
	'checkuser-nomatch'          => '沒有符合的資訊',
	'checkuser-check'            => '查詢',
	'checkuser-log-fail'         => '無法更新記錄。',
	'checkuser-nolog'            => '找不到記錄檔',
	'checkuser-blocked'          => '已經查封',
	'checkuser-too-many'         => '太多結果，請收窄CIDR。
這是使用過嘅IP (最多5000個，按地址排列):',
	'checkuser-user-nonexistent' => '指定的使用者不存在。',
	'checkuser-search-form'      => '搜尋當 $1 是 $2 時之日誌',
	'checkuser-search-submit'    => '{{int:Search}}',
	'checkuser-search-initiator' => '創始者',
	'checkuser-search-target'    => '目標',
	'checkuser-ipeditcount'      => '~在全部用戶中$1',
	'checkuser-log-subpage'      => '日誌',
	'checkuser-log-return'       => '回到主表單',
	'checkuser-log-userips'      => '$1取得$2的IP訊息',
	'checkuser-log-ipedits'      => '$1取得$2的編輯記錄',
	'checkuser-log-ipusers'      => '$1取得$2的用戶訊息',
	'checkuser-log-ipedits-xff'  => '$1取得 XFF $2的編輯記錄',
	'checkuser-log-ipusers-xff'  => '$1取得 XFF $2的用戶訊息',
);

