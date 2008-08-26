<?php
/**
 * Internationalisation file for extension GlobalBlocking.
 *
 * @addtogroup Extensions
 */

$messages = array();

/** English
 * @author Andrew Garrett
 */
$messages['en'] = array(
	'globalblocking-desc' => '[[Special:GlobalBlock|Allows]] IP addresses to be [[Special:GlobalBlockList|blocked across multiple wikis]]',
	'globalblocking-block' => 'Globally block an IP address',
	'globalblocking-expiry-options' => '-',
	'globalblocking-block-intro' => 'You can use this page to block an IP address on all wikis.',
	'globalblocking-block-reason' => 'Reason for this block:',
	'globalblocking-block-expiry' => 'Block expiry:',
	'globalblocking-block-expiry-other' => 'Other expiry time',
	'globalblocking-block-expiry-otherfield' => 'Other time:',
	'globalblocking-block-legend' => 'Block a user globally',
	'globalblocking-block-options' => 'Options',
	'globalblocking-block-errors' => "The block was unsuccessful, because: \n$1",
	'globalblocking-block-ipinvalid' => 'The IP address ($1) you entered is invalid.
Please note that you cannot enter a user name!',
	'globalblocking-block-expiryinvalid' => 'The expiry you entered ($1) is invalid.',
	'globalblocking-block-submit' => 'Block this IP address globally',
	'globalblocking-block-success' => 'The IP address $1 has been successfully blocked on all Wikimedia projects.
You may wish to consult the [[Special:Globalblocklist|list of global blocks]].',
	'globalblocking-block-successsub' => 'Global block successful',
	'globalblocking-block-alreadyblocked' => 'The IP address $1 is already blocked globally. You can view the existing block on the [[Special:Globalblocklist|list of global blocks]].',
	'globalblocking-block-bigrange' => 'The range you specified ($1) is too big to block. You may block, at most, 65,536 addresses (/16 ranges)',
	
	'globalblocking-list' => 'List of globally blocked IP addresses',
	'globalblocking-search-legend' => 'Search for a global block',
	'globalblocking-search-ip' => 'IP address:',
	'globalblocking-search-submit' => 'Search for blocks',
	'globalblocking-list-ipinvalid' => 'The IP address you searched for ($1) is invalid.
Please enter a valid IP address.',
	'globalblocking-search-errors' => "Your search was unsuccessful, because:\n\$1",
	'globalblocking-list-blockitem' => "$1: '''$2''' (''$3'') globally blocked '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry' => 'expiry $1',
	'globalblocking-list-anononly' => 'anon-only',
	'globalblocking-list-unblock' => 'remove',
	'globalblocking-list-whitelisted' => 'locally disabled by $1: $2',
	'globalblocking-list-whitelist' => 'local status',

	'globalblocking-unblock-ipinvalid' => 'The IP address ($1) you entered is invalid.
Please note that you cannot enter a user name!',
	'globalblocking-unblock-legend' => 'Remove a global block',
	'globalblocking-unblock-submit' => 'Remove global block',
	'globalblocking-unblock-reason' => 'Reason:',
	'globalblocking-unblock-notblocked' => 'The IP address ($1) you entered is not globally blocked.',
	'globalblocking-unblock-unblocked' => "You have successfully removed the global block #$2 on the IP address '''$1'''",
	'globalblocking-unblock-errors' => "You cannot remove a global block for that IP address, because:\n\$1",
	'globalblocking-unblock-successsub' => 'Global block successfully removed',
	'globalblocking-unblock-subtitle' => 'Removing global block',
	
	'globalblocking-whitelist-subtitle' => 'Editing the local status of a global block',
	'globalblocking-whitelist-legend' => 'Change local status',
	'globalblocking-whitelist-reason' => 'Reason for change:',
	'globalblocking-whitelist-status' => 'Local status:',
	'globalblocking-whitelist-statuslabel' => 'Disable this global block on {{SITENAME}}',
	'globalblocking-whitelist-submit' => 'Change local status',
	'globalblocking-whitelist-whitelisted' => "You have successfully disabled the global block #$2 on the IP address '''$1''' on {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "You have successfully re-enabled the global block #$2 on the IP address '''$1''' on {{SITENAME}}.",
	'globalblocking-whitelist-successsub' => 'Local status successfully changed',

	'globalblocking-blocked' => "Your IP address has been blocked on all Wikimedia wikis by '''$1''' (''$2'').
The reason given was ''\"$3\"''. The block's expiry is ''$4''.",

	'globalblocking-logpage' => 'Global block log',
	'globalblocking-block-logentry' => 'globally blocked [[$1]] with an expiry time of $2 ($3)',
	'globalblocking-unblock-logentry' => 'removed global block on [[$1]]',
	'globalblocking-whitelist-logentry' => 'disabled the global block on [[$1]] locally',
	'globalblocking-dewhitelist-logentry' => 're-enabled the global block on [[$1]] locally',

	'globalblocklist' => 'List of globally blocked IP addresses',
	'globalblock' => 'Globally block an IP address',
	
	// User rights
	'right-globalblock' => 'Make global blocks',
	'right-globalunblock' => 'Remove global blocks',
	'right-globalblock-whitelist' => 'Disable global blocks locally',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 */
$messages['af'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Bewillig]] dat IP adresse [[Special:GlobalBlockList|oor veelvoudige wikis versper]] word',
	'globalblocking-block'                   => "Versper 'n IP adres globaal",
	'globalblocking-block-intro'             => "U kan hierdie bladsy gebruik om 'n IP adres op alle wikis te versper.",
	'globalblocking-block-reason'            => 'Rede vir hierdie versperring:',
	'globalblocking-block-expiry'            => 'Verstryk van versperring:',
	'globalblocking-block-expiry-other'      => 'Ander verstryktyd',
	'globalblocking-block-expiry-otherfield' => 'Ander tyd:',
	'globalblocking-block-legend'            => "Versper 'n gebruiker globaal",
	'globalblocking-block-options'           => 'Opsies',
	'globalblocking-block-errors'            => 'Die versperring was nie suksesvol nie, as gevolg van:
$1',
	'globalblocking-block-ipinvalid'         => "Die IP adres ($1) wat U ingevoer het is ongeldig.
Let asseblief dat U nie 'n gebruikersnaam kan invoer nie!",
	'globalblocking-block-expiryinvalid'     => 'Die verstryking ($1) wat U ingevoer het is ongeldig.',
	'globalblocking-block-submit'            => 'Versper hierdie IP adres globaal',
	'globalblocking-block-success'           => 'Die IP adres $1 is suksesvol versper op alle Wikimedia projekte.
U mag dalk die [[Special:Globalblocklist|lys van globale versperrings]] wil konsulteer.',
	'globalblocking-block-successsub'        => 'Globale versperring suksesvol',
	'globalblocking-block-alreadyblocked'    => 'Die IP adres $1 is alreeds globaal versper. U kan die bestaande versperring op die [[Special:Globalblocklist|lys van globale versperrings]] bekyk.',
	'globalblocking-list'                    => 'Lys van globale versperde IP adresse',
	'globalblocking-search-legend'           => "Soek vir 'n globale versperring",
	'globalblocking-search-ip'               => 'IP adres:',
	'globalblocking-search-submit'           => 'Soek vir versperrings',
	'globalblocking-list-ipinvalid'          => "Die IP adres wat U na gesoek het ($1) is ongeldig.
Voer asseblief 'n geldige IP adres in.",
	'globalblocking-search-errors'           => 'U soektog was nie suksesvol nie, as gevolg van:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') het '''[[Special:Contributions/$4|$4]]''' globaal versper, met ''($5)''",
	'globalblocking-list-expiry'             => 'verstryking $1',
	'globalblocking-list-anononly'           => 'anoniem-alleen',
	'globalblocking-list-unblock'            => 'deurlaat',
	'globalblocking-list-whitelisted'        => 'lokaal afgeskakel deur $1: $2',
	'globalblocking-list-whitelist'          => 'lokale status',
	'globalblocking-unblock-ipinvalid'       => "Die IP adres ($1) wat U ingevoer het is ongeldig.
Let asseblief dat U nie 'n gebruikersnaam kan invoer nie!",
	'globalblocking-unblock-legend'          => "Verwyder 'n globale versperring",
	'globalblocking-unblock-submit'          => 'Verwyder globale versperring',
	'globalblocking-unblock-reason'          => 'Rede:',
	'globalblocking-unblock-notblocked'      => 'Die IP adres ($1) wat U ingevoer het is nie globaal versper nie.',
	'globalblocking-unblock-unblocked'       => "U het suksesvol die globale versperring #$2 op die IP adres '''$1''' verwyder",
	'globalblocking-unblock-errors'          => 'U kan nie die globale versperring vir daardie IP adres verwyder nie, as gevolg van:
$1',
	'globalblocking-unblock-successsub'      => 'Globale versperring suksesvol verwyder',
	'globalblocking-whitelist-subtitle'      => "Besig om die lokale status van 'n globale versperring te wysig",
	'globalblocking-whitelist-legend'        => 'Wysig lokale status',
	'globalblocking-whitelist-reason'        => 'Rede vir wysiging:',
	'globalblocking-whitelist-status'        => 'Lokale status:',
	'globalblocking-whitelist-statuslabel'   => 'Skakel hierdie globale versperring op {{SITENAME}} af',
	'globalblocking-whitelist-submit'        => 'Wysig lokale status',
	'globalblocking-whitelist-whitelisted'   => "U het suksesvol die globale versperring #$2 op die IP adres '''$1''' op {{SITENAME}} afgeskakel.",
	'globalblocking-whitelist-dewhitelisted' => "U het suksesvol die globale versperring #$2 op die IP adres '''$1''' op {{SITENAME}} heraangeskakel.",
	'globalblocking-whitelist-successsub'    => 'Lokale status suksesvol gewysig',
	'globalblocking-blocked'                 => "U IP adres is versper op alle Wikimedia wikis deur '''\$1''' (''\$2'').
Die rede gegee is ''\"\$3\"''. Die versperring verstryk is ''\$4''.",
	'globalblocking-logpage'                 => 'Globale versperring boekstaaf',
	'globalblocking-block-logentry'          => "[[$1]] is globaal versper met 'n verstryktyd van $2 ($3)",
	'globalblocking-unblock-logentry'        => 'verwyder globale versperring op [[$1]]',
	'globalblocking-whitelist-logentry'      => 'die globale versperring op [[$1]] is lokaal afgeskakel',
	'globalblocking-dewhitelist-logentry'    => 'die globale versperring op [[$1]] is heraangeskakel',
	'globalblocklist'                        => 'Lys van globaal versperde IP adresse',
	'globalblock'                            => "Versper 'n IP adres globaal",
	'right-globalblock'                      => 'Rig globale versperrings op',
	'right-globalunblock'                    => 'Verwyder globale versperrings',
	'right-globalblock-whitelist'            => 'Skakel globale versperrings lokaal af',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'globalblocking-unblock-reason' => 'Razón:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Alnokta
 * @author OsamaK
 */
$messages['ar'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|يسمح]] بمنع عناوين الأيبي [[Special:GlobalBlockList|عبر ويكيات متعددة]]',
	'globalblocking-block'                   => 'منع عام لعنوان أيبي',
	'globalblocking-block-intro'             => 'أنت يمكنك استخدام هذه الصفحة لمنع عنوان أيبي في كل الويكيات.',
	'globalblocking-block-reason'            => 'السبب لهذا المنع:',
	'globalblocking-block-expiry'            => 'انتهاء المنع:',
	'globalblocking-block-expiry-other'      => 'وقت انتهاء آخر',
	'globalblocking-block-expiry-otherfield' => 'وقت آخر:',
	'globalblocking-block-legend'            => 'امنع مستخدم عالميًا',
	'globalblocking-block-options'           => 'خيارات',
	'globalblocking-block-errors'            => 'لقد فشل المنع بسبب:
$1',
	'globalblocking-block-ipinvalid'         => 'عنوان الأيبي ($1) الذي أدخلته غير صحيح.
من فضلك لاحظ أنه لا يمكنك إدخال اسم مستخدم!',
	'globalblocking-block-expiryinvalid'     => 'تاريخ الانتهاء الذي أدخلته ($1) غير صحيح.',
	'globalblocking-block-submit'            => 'امنع عنوان ب.إ هذا عالميًا',
	'globalblocking-block-success'           => 'عنوان الأيبي $1 تم منعه بنجاح في كل مشاريع ويكيميديا.
ربما ترغب في رؤية [[Special:Globalblocklist|قائمة عمليات المنع العامة]].',
	'globalblocking-block-successsub'        => 'نجح المنع العالمي',
	'globalblocking-block-alreadyblocked'    => 'عنوان الأيبي $1 ممنوع منعا عامل بالفعل. يمكنك رؤية المنع الموجود في [[Special:Globalblocklist|قائمة عمليات المنع العامة]].',
	'globalblocking-block-bigrange'          => 'النطاق الذي حددته ($1) كبير جدا للمنع. يمكنك منع، كحد أقصى، 65,536 عنوان (نطاقات /16)',
	'globalblocking-list'                    => 'قائمة عناوين الأيبي الممنوعة منعا عاما',
	'globalblocking-search-legend'           => 'بحث عن منع عام',
	'globalblocking-search-ip'               => 'عنوان آي بي:',
	'globalblocking-search-submit'           => 'ابحث عن منوعات',
	'globalblocking-list-ipinvalid'          => 'عنوان الأيبي الذي بحثت عنه ($1) غير صحيح.
من فضلك أدخل عنوان أيبي صحيح.',
	'globalblocking-search-errors'           => 'بحثك كان غير ناجح، بسبب:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') منع بشكل عام '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'الانتهاء $1',
	'globalblocking-list-anononly'           => 'المجهولون فقط',
	'globalblocking-list-unblock'            => 'إزالة',
	'globalblocking-list-whitelisted'        => 'تم تعطيله محليا بواسطة $1: $2',
	'globalblocking-list-whitelist'          => 'الحالة المحلية',
	'globalblocking-unblock-ipinvalid'       => 'عنوان الأيبي ($1) الذي أدخلته غير صحيح.
من فضلك لاحظ أنه لا يمكنك إدخال اسم مستخدم!',
	'globalblocking-unblock-legend'          => 'إزالة منع عام',
	'globalblocking-unblock-submit'          => 'إزالة المنع العام',
	'globalblocking-unblock-reason'          => 'السبب:',
	'globalblocking-unblock-notblocked'      => 'عنوان الأيبي ($1) الذي أدخلته ليس ممنوعا منعا عاما.',
	'globalblocking-unblock-unblocked'       => "أنت أزلت بنجاح المنع العام #$2 على عنوان الأيبي '''$1'''",
	'globalblocking-unblock-errors'          => 'أنت لا يمكنك إزالة منع عام لعنوان الأيبي هذا، بسبب:
$1',
	'globalblocking-unblock-successsub'      => 'المنع العام تمت إزالته بنجاح',
	'globalblocking-unblock-subtitle'        => 'إزالة المنع العام',
	'globalblocking-whitelist-subtitle'      => 'تعديل الحالة المحلية لمنع عام',
	'globalblocking-whitelist-legend'        => 'تغيير الحالة المحلية',
	'globalblocking-whitelist-reason'        => 'السبب للتغيير:',
	'globalblocking-whitelist-status'        => 'الحالة المحلية:',
	'globalblocking-whitelist-statuslabel'   => 'تعطيل هذا المنع العام في {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'تغيير الحالة المحلية',
	'globalblocking-whitelist-whitelisted'   => "أنت عطلت بنجاح المنع العام #$2 على عنوان الأيبي '''$1''' في {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "أنت أعدت تفعيل بنجاح المنع العام #$2 على عنوان الأيبي '''$1''' في {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'الحالة المحلية تم تغييرها بنجاح',
	'globalblocking-logpage'                 => 'سجل المنع العام',
	'globalblocking-block-logentry'          => 'منع بشكل عام [[$1]] لمدة $2 ($3)',
	'globalblocking-unblock-logentry'        => 'أزال المنع العام على [[$1]]',
	'globalblocking-whitelist-logentry'      => 'عطل المنع العام على [[$1]] محليا',
	'globalblocking-dewhitelist-logentry'    => 'أعاد تفعيل المنع العام على [[$1]] محليا',
	'globalblocklist'                        => 'قائمة عناوين الأيبي الممنوعة منعا عاما',
	'globalblock'                            => 'منع عام لعنوان أيبي',
	'right-globalblock'                      => 'عمل عمليات منع عامة',
	'right-globalunblock'                    => 'إزالة عمليات المنع العامة',
	'right-globalblock-whitelist'            => 'تعطيل عمليات المنع العامة محليا',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'globalblocking-block-reason'            => 'Прычына блякаваньня:',
	'globalblocking-block-expiry-otherfield' => 'Іншы тэрмін:',
	'globalblocking-block-successsub'        => 'Глябальнае блякаваньне пасьпяховае',
	'globalblocking-search-ip'               => 'IP-адрас:',
	'globalblocking-list-anononly'           => 'толькі ананімаў',
	'globalblocking-list-unblock'            => 'разблякаваць',
	'globalblocking-unblock-reason'          => 'Прычына:',
	'globalblocking-whitelist-reason'        => 'Прычына зьмены:',
	'globalblocking-logpage'                 => 'Журнал глябальных блякаваньняў',
	'globalblocklist'                        => 'Сьпіс глябальна заблякаваных IP-адрасоў',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Позволява]] IP-адреси да се [[Special:GlobalBlockList|блокират едновременно в множество уикита]]',
	'globalblocking-block'                   => 'Глобално блокиране на IP-адрес',
	'globalblocking-block-intro'             => 'Чрез тази страница може да се блокира IP-адрес едновременно във всички уикита.',
	'globalblocking-block-reason'            => 'Причина за блокирането:',
	'globalblocking-block-expiry-other'      => 'Друг срок за изтичане',
	'globalblocking-block-expiry-otherfield' => 'Друг срок:',
	'globalblocking-block-legend'            => 'Глобално блокиране на потребител',
	'globalblocking-block-options'           => 'Настройки',
	'globalblocking-block-errors'            => 'Блокирането беше неуспешно, защото:
$1',
	'globalblocking-block-ipinvalid'         => 'Въведеният IP-адрес ($1) е невалиден.
Имайте предвид, че не можете да въвеждате потребителско име!',
	'globalblocking-block-expiryinvalid'     => 'Въведеният краен срок ($1) е невалиден.',
	'globalblocking-block-submit'            => 'Блокиране на този IP адрес глобално',
	'globalblocking-block-success'           => 'IP-адресът $1 беше успешно блокиран във всички проекти на Уикимедия.
Прегледайте [[Special:Globalblocklist|списъка на глобалните блокирания]].',
	'globalblocking-block-successsub'        => 'Глобалното блокиране беше успешно',
	'globalblocking-block-alreadyblocked'    => 'IP адресът $1 е вече блокиран глобално. Можете да прегледате съществуващите блокирания в [[Special:Globalblocklist|списъка с глобални блокирания]].',
	'globalblocking-list'                    => 'Списък на глобално блокирани IP адреси',
	'globalblocking-search-legend'           => 'Търсене на глобално блокиране',
	'globalblocking-search-ip'               => 'IP адрес:',
	'globalblocking-search-submit'           => 'Търсене на блокирания',
	'globalblocking-list-ipinvalid'          => 'Потърсеният от нас IP-адрес ($1) е невалиден.
Въведете валиден IP-адрес.',
	'globalblocking-search-errors'           => 'Търсенето беше неуспешно. Причина:
$1',
	'globalblocking-list-expiry'             => 'срок на изтичане $1',
	'globalblocking-list-anononly'           => 'само анонимни',
	'globalblocking-list-unblock'            => 'отблокиране',
	'globalblocking-list-whitelisted'        => 'локално изключен от $1: $2',
	'globalblocking-list-whitelist'          => 'локален статут',
	'globalblocking-unblock-ipinvalid'       => 'Въведеният IP адрес ($1) е невалиден.
Имайте предвид, че не можете да въвеждате потребителско име!',
	'globalblocking-unblock-legend'          => 'Премахване на глобално блокиране',
	'globalblocking-unblock-submit'          => 'Премахване на глобално блокиране',
	'globalblocking-unblock-reason'          => 'Причина:',
	'globalblocking-unblock-notblocked'      => 'Въведеният IP адрес ($1) не е блокиран глобално.',
	'globalblocking-unblock-unblocked'       => "Успешно премахнахте глобалното блокиране #$2 на IP адрес '''$1'''",
	'globalblocking-unblock-errors'          => 'Не можете да премахнете глобалното блокиране на този IP адрес поради следната причина:
$1',
	'globalblocking-unblock-successsub'      => 'Глобалното блокиране беше премахнато успешно',
	'globalblocking-unblock-subtitle'        => 'Премахване на глобално блокиране',
	'globalblocking-whitelist-subtitle'      => 'Редактиране на локалния статут на глобално блокиране',
	'globalblocking-whitelist-legend'        => 'Промяна на локалния статут',
	'globalblocking-whitelist-reason'        => 'Причина за промяната:',
	'globalblocking-whitelist-status'        => 'Локален статут:',
	'globalblocking-whitelist-statuslabel'   => 'Изключване на това глобално блокиране за {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Промяна на локалния статут',
	'globalblocking-whitelist-whitelisted'   => "Успешно изключихте глобално блокиране #$2 на IP адрес '''$1''' в {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Успешно активирахте глобално блокиране #$2 на IP адрес '''$1''' в {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Локалният статут беше променен успешно',
	'globalblocking-blocked'                 => "Вашият IP адрес беше блокиран във всички уикита на Уикимедия от '''$1''' (''$2'').
Посочената причина е ''„$3“''. Срокът на изтичане на блокирането е ''$4''.",
	'globalblocking-logpage'                 => 'Дневник на глобалните блокирания',
	'globalblocking-block-logentry'          => 'глобално блокиране на [[$1]] със срок на изтичане $2 ($3)',
	'globalblocklist'                        => 'Списък на глобално блокираните IP адреси',
	'globalblock'                            => 'Глобално блокиране на IP адрес',
	'right-globalblock'                      => 'Създаване на глобални блокирания',
	'right-globalunblock'                    => 'Премахване на глобални блокирания',
	'right-globalblock-whitelist'            => 'Локално спиране на глобалните блокирания',
);

/** German (Deutsch)
 * @author MF-Warburg
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Sperrt]] IP-Adressen auf [[Special:GlobalBlockList|allen Wikis]]',
	'globalblocking-block'                   => 'Eine IP-Adresse global sperren',
	'globalblocking-block-intro'             => 'Auf dieser Seite kannst du IP-Adressen für alle Wikis sperren.',
	'globalblocking-block-reason'            => 'Grund für die Sperre:',
	'globalblocking-block-expiry'            => 'Sperrdauer:',
	'globalblocking-block-expiry-other'      => 'Andere Dauer',
	'globalblocking-block-expiry-otherfield' => 'Andere Dauer (englisch):',
	'globalblocking-block-legend'            => 'Einen Benutzer global sperren',
	'globalblocking-block-options'           => 'Optionen',
	'globalblocking-block-errors'            => 'Die Sperre war nicht erfolgreich. Grund:
$1',
	'globalblocking-block-ipinvalid'         => 'Du hast eine ungültige IP-Adresse ($1) eingegeben.
Beachte, dass du keinen Benutzernamen eingeben darfst!',
	'globalblocking-block-expiryinvalid'     => 'Die Sperrdauer ($1) ist ungültig.',
	'globalblocking-block-submit'            => 'Diese IP-Adresse global sperren',
	'globalblocking-block-success'           => 'Die IP-Adresse $1 wurde erfolgreich auf allen Wikimedia-Projekten gesperrt.
Die globale Sperrliste befindet sich [[Special:Globalblocklist|hier]].',
	'globalblocking-block-successsub'        => 'Erfolgreich global gesperrt',
	'globalblocking-block-alreadyblocked'    => 'Die IP-Adresse $1 wurde schon global gesperrt. Du kannst die bestehende Sperre in der [[Special:Globalblocklist|globalen Sperrliste]] einsehen.',
	'globalblocking-block-bigrange'          => 'Der Adressbereich, den du angegeben hast ($1) ist zu groß. Du kannst höchstens 65.536 IPs sperren (/16-Adressbereiche)',
	'globalblocking-list'                    => 'Liste global gesperrter IP-Adressen',
	'globalblocking-search-legend'           => 'Eine globale Sperre suchen',
	'globalblocking-search-ip'               => 'IP-Adresse:',
	'globalblocking-search-submit'           => 'Sperren suchen',
	'globalblocking-list-ipinvalid'          => 'Du hast eine ungültige IP-Adresse ($1) eingegeben.
Bitte gib eine gültige IP-Adresse ein.',
	'globalblocking-search-errors'           => 'Die Suche war nicht erfolgreich. Grund:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (auf ''$3'') sperrte '''[[Special:Contributions/$4|$4]]''' global ''($5)''",
	'globalblocking-list-expiry'             => 'Sperrdauer $1',
	'globalblocking-list-anononly'           => 'nur Anonyme',
	'globalblocking-list-unblock'            => 'entsperren',
	'globalblocking-list-whitelisted'        => 'lokal abgeschaltet von $1: $2',
	'globalblocking-list-whitelist'          => 'lokaler Status',
	'globalblocking-unblock-ipinvalid'       => 'Du hast eine ungültige IP-Adresse ($1) eingegeben.
Beachte, dass du keinen Benutzernamen eingeben darfst!',
	'globalblocking-unblock-legend'          => 'Global entsperren',
	'globalblocking-unblock-submit'          => 'Global entsperren',
	'globalblocking-unblock-reason'          => 'Grund:',
	'globalblocking-unblock-notblocked'      => 'Die IP-Adresse ($1), die du eingegeben hast, ist nicht global gesperrt.',
	'globalblocking-unblock-unblocked'       => "Die hast erfolgreich die IP-Adresse '''$1''' (Sperr-ID $2) entsperrt",
	'globalblocking-unblock-errors'          => 'Du kannst diese IP nicht global entsperren. Grund:
$1',
	'globalblocking-unblock-successsub'      => 'Erfolgreich global entsperrt',
	'globalblocking-unblock-subtitle'        => 'Globale Sperre entfernen',
	'globalblocking-whitelist-subtitle'      => 'Lokalen Status einer globalen Sperre bearbeiten',
	'globalblocking-whitelist-legend'        => 'Lokalen Status bearbeiten',
	'globalblocking-whitelist-reason'        => 'Grund der Änderung:',
	'globalblocking-whitelist-status'        => 'Lokaler Status:',
	'globalblocking-whitelist-statuslabel'   => 'Diese globale Sperre auf {{SITENAME}} aufheben',
	'globalblocking-whitelist-submit'        => 'Lokalen Status ändern',
	'globalblocking-whitelist-whitelisted'   => "Du hast erfolgreich die globale Sperre #$2 der IP-Adresse '''$1''' auf {{SITENAME}} aufgehoben.",
	'globalblocking-whitelist-dewhitelisted' => "Du hast erfolgreich die globale Sperre #$2 der IP-Adresse '''$1''' auf {{SITENAME}} wieder eingeschaltet.",
	'globalblocking-whitelist-successsub'    => 'Lokaler Status erfolgreich geändert',
	'globalblocking-blocked'                 => "Deine IP-Adresse wurde von '''\$1''' (''\$2'') für alle Wikimedia-Wikis gesperrt.
Als Begründung wurde ''\"\$3\"'' angegeben. Die Sperre dauert ''\$4''.",
	'globalblocking-logpage'                 => 'Globales Sperrlogbuch',
	'globalblocking-block-logentry'          => 'sperrte [[$1]] global für einen Zeitraum von $2 ($3)',
	'globalblocking-unblock-logentry'        => 'entsperrte [[$1]] global',
	'globalblocking-whitelist-logentry'      => 'schaltete die globale Sperre von „[[$1]]“ lokal ab',
	'globalblocking-dewhitelist-logentry'    => 'schaltete die globale Sperre von „[[$1]]“ lokal wieder ein',
	'globalblocklist'                        => 'Liste global gesperrter IP-Adressen',
	'globalblock'                            => 'Eine IP-Adresse global sperren',
	'right-globalblock'                      => 'Globale Sperren einrichten',
	'right-globalunblock'                    => 'Globale Sperren aufheben',
	'right-globalblock-whitelist'            => 'Globale Sperren lokal abschalten',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Permesas]] IP-adreso esti [[Special:GlobalBlockList|forbarita trans multaj vikioj]].',
	'globalblocking-block'                   => 'Ĝenerale forbaru IP-adreson',
	'globalblocking-block-intro'             => 'Vi povas uzi ĉi tiun paĝon por forbari IP-adreson en ĉiuj vikioj.',
	'globalblocking-block-reason'            => 'Kialo por ĉi tiu forbaro:',
	'globalblocking-block-expiry'            => 'Findato de forbaro:',
	'globalblocking-block-expiry-other'      => 'Alia findato',
	'globalblocking-block-expiry-otherfield' => 'Alia daŭro:',
	'globalblocking-block-legend'            => 'Forbaru uzanto ĝenerale',
	'globalblocking-block-options'           => 'Preferoj',
	'globalblocking-block-errors'            => 'La forbaro malsukcesis, ĉar:
$1',
	'globalblocking-block-ipinvalid'         => 'La IP-adreso ($1) kiun vi enigis estas nevalida.
Bonvolu noti ke vi ne povas enigi salutnomo!',
	'globalblocking-block-expiryinvalid'     => 'La findaton kiun vi enigis ($1) estas nevalida.',
	'globalblocking-block-submit'            => 'Forbaru ĉi tiun IP-adreson ĝenerale',
	'globalblocking-block-success'           => 'La IP-adreso $1 estis sukcese forbarita por ĉiuj projektoj de Wikimedia.
Vi eble volas konsulti la [[Special:Globalblocklist|liston de ĝeneralaj forbaroj]].',
	'globalblocking-block-successsub'        => 'Ĝenerala forbaro estis sukcesa',
	'globalblocking-block-alreadyblocked'    => 'La IP-adreso $1 estas jam forbarita ĝenerale. Vi povas rigardi la ekzistanta forbaro en la [[Special:Globalblocklist|Listo de ĝeneralaj forbaroj]].',
	'globalblocking-list'                    => 'Listo de ĝenerale forbaritaj IP-adresoj',
	'globalblocking-search-legend'           => 'Serĉu ĝeneralan forbaron',
	'globalblocking-search-ip'               => 'IP-adreso:',
	'globalblocking-search-submit'           => 'Serĉi forbarojn',
	'globalblocking-list-ipinvalid'          => 'La serĉita IP-adreso ($1) estas nevalida.
Bonvolu enigi validan IP-adreson.',
	'globalblocking-search-errors'           => 'Via serĉo estis malsukcesa, ĉar:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') ĝenerale forbaris uzanton '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'findato $1',
	'globalblocking-list-anononly'           => 'nur anonimuloj',
	'globalblocking-list-unblock'            => 'malforbari',
	'globalblocking-list-whitelisted'        => 'loke malebligita de $1: $2',
	'globalblocking-list-whitelist'          => 'loka statuso',
	'globalblocking-unblock-ipinvalid'       => 'La IP-adreso ($1) kiun vi enigis estas nevalida.
Bonvolu noti ke vi ne povas enigi salutnomo!',
	'globalblocking-unblock-legend'          => 'Forigu ĝeneralan forbaron',
	'globalblocking-unblock-submit'          => 'Forigu ĝeneralan forbaron',
	'globalblocking-unblock-reason'          => 'Kialo:',
	'globalblocking-unblock-notblocked'      => 'La IP-adreso ($1) kiun vi enigis ne estas ĝenerale forbarita.',
	'globalblocking-unblock-unblocked'       => "Vi sukcese forigis la ĝeneralan forbaron #$2 por la IP-adreso '''$1'''",
	'globalblocking-unblock-errors'          => 'Vi ne povas forigi ĝeneralan forbaron por tiu IP-adreso, ĉar:
$1',
	'globalblocking-unblock-successsub'      => 'Ĝenerala forbaro estis sukcese forigita',
	'globalblocking-unblock-subtitle'        => 'Forigante ĝeneralan forbaron',
	'globalblocking-whitelist-subtitle'      => 'Redaktante la lokan statuson de ĝeneralan forbaron',
	'globalblocking-whitelist-legend'        => 'Ŝanĝi lokan statuson',
	'globalblocking-whitelist-reason'        => 'Kialo por ŝanĝo:',
	'globalblocking-whitelist-status'        => 'Loka statuso:',
	'globalblocking-whitelist-statuslabel'   => 'Malebligu ĉi tiun ĝeneralan forbaron por {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Ŝanĝi lokan statuson',
	'globalblocking-whitelist-whitelisted'   => "Vi sukcese malebligis la ĝeneralan forbaron #$2 por la IP-adreso '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Vi sukcese reebligis la ĝeneralan forbaron #$2 por la IP-adreso '''$1''' en {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Loka statuso sukcese ŝanĝiĝis.',
	'globalblocking-blocked'                 => "Via IP-adreso estis forbarita en ĉiuj Wikimedia-retejoj de '''\$1''' (''\$2'').
La kialo donata estis ''\"\$3\"''. La findato de la forbaro estas ''\$4''.",
	'globalblocking-logpage'                 => 'Protokolo de ĝeneralaj forbaroj',
	'globalblocking-block-logentry'          => 'ĝenerale forbaris [[$1]] kun findato de $2 ($3)',
	'globalblocking-unblock-logentry'        => 'forigis ĝeneralajn forbarojn por [[$1]]',
	'globalblocking-whitelist-logentry'      => 'malebligis la ĝeneralan forbaron por [[$1]] loke',
	'globalblocking-dewhitelist-logentry'    => 'reebligis la ĝeneralan forbaron por [[$1]] loke',
	'globalblocklist'                        => 'Listo de ĝenerale forbaritaj IP-adresoj',
	'globalblock'                            => 'Ĝenerale forbari IP-adreson',
	'right-globalblock'                      => 'Faru ĝeneralajn forbarojn',
	'right-globalunblock'                    => 'Forigu ĝeneralajn forbarojn',
	'right-globalblock-whitelist'            => 'Malebligu ĝeneralajn forbarojn loke',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Verdy p
 */
$messages['fr'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Permet]] le blocage des adresses IP [[Special:GlobalBlockList|à travers plusieurs wikis]]',
	'globalblocking-block'                   => 'Bloquer globalement une adresse IP',
	'globalblocking-block-intro'             => 'Vous pouvez utiliser cette page pour bloquer une adresse IP sur l’ensemble des wikis.',
	'globalblocking-block-reason'            => 'Motifs de ce blocage :',
	'globalblocking-block-expiry'            => 'Plage d’expiration :',
	'globalblocking-block-expiry-other'      => 'Autre durée d’expiration',
	'globalblocking-block-expiry-otherfield' => 'Autre durée :',
	'globalblocking-block-legend'            => 'Bloquer globalement un utilisateur',
	'globalblocking-block-options'           => 'Options',
	'globalblocking-block-errors'            => 'Le blocage n’a pas réussi, parce que : $1',
	'globalblocking-block-ipinvalid'         => 'L’adresse IP ($1) que vous avez entrée est incorrecte.
Veuillez noter que vous ne pouvez pas inscrire un nom d’utilisateur !',
	'globalblocking-block-expiryinvalid'     => 'L’expiration que vous avez entrée ($1) est incorrecte.',
	'globalblocking-block-submit'            => 'Bloquer globalement cette adresse IP',
	'globalblocking-block-success'           => 'L’adresse IP $1 a été bloquée avec succès sur l’ensemble des projets Wikimedia.
Vous pouvez consultez la liste des [[Special:Globalblocklist|comptes bloqués globalement]].',
	'globalblocking-block-successsub'        => 'Blocage global réussi',
	'globalblocking-block-alreadyblocked'    => 'L’adresse IP $1 est déjà bloquée globalement. Vous pouvez afficher les blocages existants sur la liste [[Special:Globalblocklist|des blocages globaux]].',
	'globalblocking-block-bigrange'          => 'La plage que vous avez spécifiée ($1) est trop grande pour être bloquée. Vous ne pouvez pas bloquer plus de 65&nbsp;536 adresses (plages en /16).',
	'globalblocking-list'                    => 'Liste des adresses IP bloquées globalement',
	'globalblocking-search-legend'           => 'Recherche d’un blocage global',
	'globalblocking-search-ip'               => 'Adresse IP :',
	'globalblocking-search-submit'           => 'Recherche des blocages',
	'globalblocking-list-ipinvalid'          => 'L’adresse IP que vous recherchez pour ($1) est incorrecte.
Veuillez entrez une adresse IP correcte.',
	'globalblocking-search-errors'           => 'Votre recherche a été infructueuse, parce que :
$1',
	'globalblocking-list-blockitem'          => "* $1 : '''$2''' (''$3'') bloqué globalement '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'expiration $1',
	'globalblocking-list-anononly'           => 'uniquement anonyme',
	'globalblocking-list-unblock'            => 'débloquer',
	'globalblocking-list-whitelisted'        => 'désactivé localement par $1 : $2',
	'globalblocking-list-whitelist'          => 'statut local',
	'globalblocking-unblock-ipinvalid'       => 'L’adresse IP que vous avez indiquée ($1) est incorrecte.
Veuillez noter que que vous ne pouvez pas entrer un nom d’utilisateur !',
	'globalblocking-unblock-legend'          => 'Enlever un blocage global',
	'globalblocking-unblock-submit'          => 'Enlever le blocage global',
	'globalblocking-unblock-reason'          => 'Motifs :',
	'globalblocking-unblock-notblocked'      => 'L’adresse IP ($1) que vous avez indiquée ne fait l’objet d’aucun blocage global.',
	'globalblocking-unblock-unblocked'       => "Vous avez réussi à retirer le blocage global n° $2 correspondant à l’adresse IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Vous ne pouvez pas enlever un blocage global pour cette adresse IP, parce que :
$1',
	'globalblocking-unblock-successsub'      => 'Blocage global retiré avec succès',
	'globalblocking-unblock-subtitle'        => 'Suppression du blocage global',
	'globalblocking-whitelist-subtitle'      => "Modification du statut local d'un blocage global",
	'globalblocking-whitelist-legend'        => 'Changer le statut local',
	'globalblocking-whitelist-reason'        => 'Raison de la modification :',
	'globalblocking-whitelist-status'        => 'Statut local :',
	'globalblocking-whitelist-statuslabel'   => 'Désactiver ce blocage global sur {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Changer le statut local',
	'globalblocking-whitelist-whitelisted'   => "Vous avez désactivé avec succès le blocage global n° $2 sur l'adresse IP '''$1''' sur {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Vous avez réactivé avec succès le blocage global n° $2 sur l'adresse IP '''$1''' sur {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Statut local changé avec succès',
	'globalblocking-blocked'                 => "Votre adresse IP a été bloquée sur l’ensemble des wiki par '''$1''' (''$2'').
Le motif indiqué a été « $3 ». L’expiration du blocage est pour le ''$4''.",
	'globalblocking-logpage'                 => 'Journal des blocages globaux',
	'globalblocking-block-logentry'          => '[[$1]] bloqué globalement avec une durée d’expiration de $2 ($3)',
	'globalblocking-unblock-logentry'        => 'blocage global retiré sur [[$1]]',
	'globalblocking-whitelist-logentry'      => 'a désactivé localement le blocage global de [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'a réactivé localement le blocage global de [[$1]]',
	'globalblocklist'                        => 'Liste des adresses IP bloquées globalement',
	'globalblock'                            => 'Bloquer globalement une adresse IP',
	'right-globalblock'                      => 'Bloquer des utilisateurs globalement',
	'right-globalunblock'                    => 'Débloquer des utilisateurs bloqués globalement',
	'right-globalblock-whitelist'            => 'Désactiver localement les blocages globaux',
);

/** Galician (Galego)
 * @author Toliño
 * @author Prevert
 */
$messages['gl'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Permite]] que os enderezos IP sexan [[Special:GlobalBlockList|bloqueados en múltiples wikis]]',
	'globalblocking-block'                   => 'Bloqueo global dun enderezo IP',
	'globalblocking-block-intro'             => 'Pode usar esta páxina para bloquear un enderezo IP en todos os wikis.',
	'globalblocking-block-reason'            => 'Razón para o bloqueo:',
	'globalblocking-block-expiry'            => 'Expiración do bloqueo:',
	'globalblocking-block-expiry-other'      => 'Outro período de tempo de expiración',
	'globalblocking-block-expiry-otherfield' => 'Outro período de tempo:',
	'globalblocking-block-legend'            => 'Bloquear un usuario globalmente',
	'globalblocking-block-options'           => 'Opcións',
	'globalblocking-block-errors'            => 'O bloqueo non se puido levar a cabo porque: $1',
	'globalblocking-block-ipinvalid'         => 'O enderezo IP ($1) que tecleou é inválido.
Por favor, decátese de que non pode teclear un nome de usuario!',
	'globalblocking-block-expiryinvalid'     => 'O período de expiración que tecleou ($1) é inválido.',
	'globalblocking-block-submit'            => 'Bloquear este enderezo IP globalmente',
	'globalblocking-block-success'           => 'O enderezo IP $1 foi bloqueado con éxito en todos os proxectos Wikimedia.
Quizais desexa consultar a [[Special:Globalblocklist|listaxe de bloqueos globais]].',
	'globalblocking-block-successsub'        => 'Bloqueo global exitoso',
	'globalblocking-block-alreadyblocked'    => 'O enderezo IP "$1" xa está globalmente bloqueado. Pode ver os bloqueos vixentes na [[Special:Globalblocklist|listaxe de bloqueos globais]].',
	'globalblocking-block-bigrange'          => 'O rango especificado ($1) é demasiado grande para bloquealo. Pode bloquear, como máximo, 65.536 enderezos (/16 rangos)',
	'globalblocking-list'                    => 'Listaxe dos bloqueos globais a enderezos IP',
	'globalblocking-search-legend'           => 'Procurar bloqueos globais',
	'globalblocking-search-ip'               => 'Enderezo IP:',
	'globalblocking-search-submit'           => 'Procurar bloqueos',
	'globalblocking-list-ipinvalid'          => 'O enderezo IP que procurou ($1) é inválido.
Por favor, teclee un enderezo IP válido.',
	'globalblocking-search-errors'           => 'A súa procura non foi exitosa porque:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') bloqueou globalmente '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'expira $1',
	'globalblocking-list-anononly'           => 'só anón.',
	'globalblocking-list-unblock'            => 'desbloquear',
	'globalblocking-list-whitelisted'        => 'deshabilitado localmente por $1: $2',
	'globalblocking-list-whitelist'          => 'status local',
	'globalblocking-unblock-ipinvalid'       => 'O enderezo IP ($1) que tecleou é inválido.
Por favor, decátese de que non pode teclear un nome de usuario!',
	'globalblocking-unblock-legend'          => 'Retirar un bloqueo global',
	'globalblocking-unblock-submit'          => 'Retirar bloqueo global',
	'globalblocking-unblock-reason'          => 'Razón:',
	'globalblocking-unblock-notblocked'      => 'O enderezo IP ($1) que tecleou non está bloqueado globalmente.',
	'globalblocking-unblock-unblocked'       => "Retirou con éxito o bloqueo global #$2 que tiña o enderezo IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Non pode retirar o bloqueo global dese enderezo IP porque:
$1',
	'globalblocking-unblock-successsub'      => 'A retirada do bloqueo global foi un éxito',
	'globalblocking-unblock-subtitle'        => 'Eliminando o bloqueo global',
	'globalblocking-whitelist-subtitle'      => 'Editando o status local dun bloqueo global',
	'globalblocking-whitelist-legend'        => 'Cambiar o status local',
	'globalblocking-whitelist-reason'        => 'Motivo para o cambio:',
	'globalblocking-whitelist-status'        => 'Status local:',
	'globalblocking-whitelist-statuslabel'   => 'Deshabilitar este bloqueo global en {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Cambiar o status local',
	'globalblocking-whitelist-whitelisted'   => "Deshabilitou con éxito en {{SITENAME}} o bloqueo global #$2 do enderezo IP '''$1'''.",
	'globalblocking-whitelist-dewhitelisted' => "Volveu habilitar con éxito en {{SITENAME}} o bloqueo global #$2 do enderezo IP '''$1'''.",
	'globalblocking-whitelist-successsub'    => 'O status local foi trocado con éxito',
	'globalblocking-blocked'                 => "O seu enderezo IP foi bloqueado en todos os wikis Wikimedia por '''\$1''' (''\$2'').
A razón que deu foi ''\"\$3\"''. A expiración do bloqueo será ''\$4''.",
	'globalblocking-logpage'                 => 'Rexistro de bloqueos globais',
	'globalblocking-block-logentry'          => 'bloqueou globalmente a "[[$1]]" cun período de expiración de $2 ($3)',
	'globalblocking-unblock-logentry'        => 'retirado o bloqueo global en [[$1]]',
	'globalblocking-whitelist-logentry'      => 'deshabilitou localmente o bloqueo global en [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'volveu habilitar localmente o bloqueo global en [[$1]]',
	'globalblocklist'                        => 'Listaxe dos bloqueos globais a enderezos IP',
	'globalblock'                            => 'Bloquear globalmente un enderezo IP',
	'right-globalblock'                      => 'Realizar bloqueos globais',
	'right-globalunblock'                    => 'Eliminar bloqueos globais',
	'right-globalblock-whitelist'            => 'Deshabilitar bloqueos globais localmente',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'globalblocking-block-expiry-otherfield' => 'Am elley:',
	'globalblocking-block-options'           => 'Reihghyn',
	'globalblocking-search-ip'               => 'Enmys IP:',
	'globalblocking-unblock-reason'          => 'Fa:',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'globalblocking-unblock-reason' => 'Kumu:',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 */
$messages['he'] = array(
	'globalblocking-block-intro'  => 'באפשרותכם להשתמש בדף זה כדי לחסום כתובת IP בכל אתרי הוויקי.',
	'globalblocking-block-reason' => 'סיבה לחסימה זו:',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'globalblocking-desc'                    => 'आइपी एड्रेस को [[Special:GlobalBlockList|एक से ज्यादा विकियोंपर ब्लॉक]] करने की [[Special:GlobalBlock|अनुमति]] देता हैं।',
	'globalblocking-block'                   => 'एक आइपी एड्रेस को ग्लोबलि ब्लॉक करें',
	'globalblocking-block-intro'             => 'आप इस पन्ने का इस्तेमाल करके सभी विकियोंपर एक आईपी एड्रेस ब्लॉक कर सकतें हैं।',
	'globalblocking-block-reason'            => 'इस ब्लॉक का कारण:',
	'globalblocking-block-expiry'            => 'ब्लॉक समाप्ति:',
	'globalblocking-block-expiry-other'      => 'अन्य समाप्ती समय',
	'globalblocking-block-expiry-otherfield' => 'अन्य समय:',
	'globalblocking-block-legend'            => 'एक सदस्य को ग्लोबली ब्लॉक करें',
	'globalblocking-block-options'           => 'विकल्प',
	'globalblocking-block-errors'            => 'ब्लॉक अयशस्वी हुआ, कारण:
$1',
	'globalblocking-block-ipinvalid'         => 'आपने दिया हुआ आईपी एड्रेस ($1) अवैध हैं।
कृपया ध्यान दें आप सदस्यनाम नहीं दे सकतें!',
	'globalblocking-block-expiryinvalid'     => 'आपने दिया हुआ समाप्ती समय ($1) अवैध हैं।',
	'globalblocking-block-submit'            => 'इस आईपी को ग्लोबली ब्लॉक करें',
	'globalblocking-block-success'           => '$1 इस आयपी एड्रेसको सभी विकिंयोंपर ब्लॉक कर दिया गया हैं।
आप शायद [[Special:Globalblocklist|वैश्विक ब्लॉक सूची]] देखना चाहते हैं।',
	'globalblocking-block-successsub'        => 'ग्लोबल ब्लॉक यशस्वी हुआ',
	'globalblocking-block-alreadyblocked'    => '$1 इस आइपी एड्रेसको पहलेसे ब्लॉक किया हुआ हैं। आप अस्तित्वमें होनेवाले ब्लॉक [[Special:Globalblocklist|वैश्विक ब्लॉक सूचीमें]] देख सकतें हैं।',
	'globalblocking-list'                    => 'ग्लोबल ब्लॉक किये हुए आईपी एड्रेसोंकी सूची',
	'globalblocking-search-legend'           => 'ग्लोबल ब्लॉक खोजें',
	'globalblocking-search-ip'               => 'आइपी एड्रेस:',
	'globalblocking-search-submit'           => 'ब्लॉक खोजें',
	'globalblocking-list-ipinvalid'          => 'आपने खोजने के लिये दिया हुआ आइपी एड्रेस ($1) अवैध हैं।
कृपया वैध आइपी एड्रेस दें।',
	'globalblocking-search-errors'           => 'आपकी खोज़ अयशस्वी हुई हैं, कारण:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') ग्लोबली ब्लॉक किया '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'समाप्ती $1',
	'globalblocking-list-anononly'           => 'सिर्फ-अनामक',
	'globalblocking-list-unblock'            => 'अनब्लॉक',
	'globalblocking-list-whitelisted'        => '$1 ने स्थानिक स्तरपर रद्द किया: $2',
	'globalblocking-list-whitelist'          => 'स्थानिक स्थिती',
	'globalblocking-unblock-ipinvalid'       => 'आपने दिया हुआ आईपी एड्रेस ($1) अवैध हैं।
कृपया ध्यान दें आप सदस्यनाम नहीं दे सकतें!',
	'globalblocking-unblock-legend'          => 'ग्लोबल ब्लॉक हटायें',
	'globalblocking-unblock-submit'          => 'ग्लोबल ब्लॉक हटायें',
	'globalblocking-unblock-reason'          => 'कारण:',
	'globalblocking-unblock-notblocked'      => 'आपने दिया हुआ आईपी एड्रेस ($1) पर ग्लोबल ब्लॉक नहीं हैं।',
	'globalblocking-unblock-unblocked'       => "आपने '''$1''' इस आइपी एड्रेस पर होने वाला ग्लोबल ब्लॉक #$2 हटा दिया हैं",
	'globalblocking-unblock-errors'          => 'आप इस आईपी एड्रेस का ग्लोबल ब्लॉक हटा नहीं सकतें, कारण:
$1',
	'globalblocking-unblock-successsub'      => 'ग्लोबल ब्लॉक हटा दिया गया हैं',
	'globalblocking-whitelist-subtitle'      => 'एक वैश्विक ब्लॉककी स्थानिक स्थिती बदल रहें हैं',
	'globalblocking-whitelist-legend'        => 'स्थानिक स्थिती बदलें',
	'globalblocking-whitelist-reason'        => 'बदलाव के कारण:',
	'globalblocking-whitelist-status'        => 'स्थानिक स्थिती:',
	'globalblocking-whitelist-statuslabel'   => '{{SITENAME}} पर से यह वैश्विक ब्लॉक हटायें',
	'globalblocking-whitelist-submit'        => 'स्थानिक स्थिती बदलें',
	'globalblocking-whitelist-whitelisted'   => "आपने '''$1''' इस एड्रेसपर दिया हुआ वैश्विक ब्लॉक #$2, {{SITENAME}} पर रद्द कर दिया हैं।",
	'globalblocking-whitelist-dewhitelisted' => "आपने '''$1''' इस आइपी एड्रेसपर दिया हुआ वैश्विक ब्लॉक #$2, {{SITENAME}} पर फिरसे दिया हैं।",
	'globalblocking-whitelist-successsub'    => 'स्थानिक स्थिती बदल दी गई हैं',
	'globalblocking-blocked'                 => "आपके आइपी एड्रेसको सभी विकिमीडिया विकिंवर '''\$1''' (''\$2'') ने ब्लॉक किया हुआ हैं।
इसके लिये ''\"\$3\"'' यह कारण दिया हुआ हैं। इस ब्लॉक की समाप्ति ''\$4'' हैं।",
	'globalblocking-logpage'                 => 'ग्लोबल ब्लॉक सूची',
	'globalblocking-block-logentry'          => '[[$1]] को ग्लोबली ब्लॉक किया समाप्ति समय $2 ($3)',
	'globalblocking-unblock-logentry'        => '[[$1]] का ग्लोबल ब्लॉक निकाल दिया',
	'globalblocking-whitelist-logentry'      => '[[$1]] पर दिया हुआ वैश्विक ब्लॉक स्थानिक स्तरपर रद्द कर दिया',
	'globalblocking-dewhitelist-logentry'    => '[[$1]] पर दिया हुआ वैश्विक ब्लॉक स्थानिक स्तरपर फिरसे दिया',
	'globalblocklist'                        => 'ग्लोबल ब्लॉक होनेवाले आइपी एड्रेसकी सूची',
	'globalblock'                            => 'एक आइपी एड्रेसको ग्लोबल ब्लॉक करें',
	'right-globalblock'                      => 'वैश्विक ब्लॉक तैयार करें',
	'right-globalunblock'                    => 'वैश्विक ब्लॉक हटा दें',
	'right-globalblock-whitelist'            => 'वैश्विक ब्लॉक स्थानिक स्तरपर रद्द करें',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'globalblocking-unblock-reason' => 'Rason:',
);

/** Croatian (Hrvatski)
 * @author Suradnik13
 */
$messages['hr'] = array(
	'globalblocking-desc'               => '[[Special:GlobalBlock|Omogućuje]] da IP adrese budu  [[Special:GlobalBlockList|blokirane na više wikija]]',
	'globalblocking-block'              => 'Globalno blokiraj IP adresu',
	'globalblocking-block-intro'        => 'Možete koristiti ovu stranicu kako biste blokirali IP adresu na svim wikijima.',
	'globalblocking-block-reason'       => 'Razlog za ovo blokiranje:',
	'globalblocking-block-expiry'       => 'Blokada istječe:',
	'globalblocking-block-expiry-other' => 'Drugo vrijeme isteka',
	'globalblocking-block-legend'       => 'Blokiraj suradnika globalno',
	'globalblocking-block-successsub'   => 'Globalno blokiranje je uspješno',
	'globalblocking-list'               => 'Popis globalno blokiranih IP adresa',
	'globalblocking-search-ip'          => 'IP Adresa:',
	'globalblocking-logpage'            => 'Evidencija globalne blokade',
	'right-globalunblock'               => 'Ukloni globalne blokade',
	'right-globalblock-whitelist'       => 'Onemogući globalno blokiranje lokalno',
);

/** Haitian (Kreyòl ayisyen)
 * @author Jvm
 */
$messages['ht'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Pemèt]] Pou vin adrès IP yo [[Special:GlobalBlockList|bloke atravè plizyè wiki]]',
	'globalblocking-block'                   => 'Bloke yon adrès IP globalman',
	'globalblocking-block-intro'             => 'Ou kapab itilize paj sa pou bloke yon adrès IP nan tou wiki yo.',
	'globalblocking-block-reason'            => 'Rezon pou blokaj sa:',
	'globalblocking-block-expiry'            => 'Blokaj expirasyon:',
	'globalblocking-block-expiry-other'      => 'Lòt tan tèminasyon',
	'globalblocking-block-expiry-otherfield' => 'Lòt tan:',
	'globalblocking-block-legend'            => 'Bloke yon itilizatè globalman',
	'globalblocking-block-options'           => 'Opsyon yo',
	'globalblocking-block-errors'            => 'Blokaj sa pa reyisi, paske:  
$1',
	'globalblocking-block-ipinvalid'         => 'Adrès IP sa ($1) ou te antre a envalid.
Souple note ke ou pa kapab antre yon non itlizatè!',
	'globalblocking-block-expiryinvalid'     => 'Expirasyon ($1) ou te antre a envalid.',
	'globalblocking-block-submit'            => 'Bloke adrès IP sa globalman',
	'globalblocking-block-success'           => 'Adrès IP sa $1 te bloke avèk siksès nan tout projè Wikimedia yo.
Ou ka desire pou konsilte [[Special:LisBlokajGlobal|lis blokaj global yo]].',
	'globalblocking-block-successsub'        => 'Blokaj global reyisi',
	'globalblocking-block-alreadyblocked'    => 'Adrès IP sa $1 deja bloke globalman. Ou ka wè blokaj ki deja ekziste a nan [[Special:Globalblocklist|lis blokaj global yo]].',
	'globalblocking-list'                    => 'Lis adrès IP ki bloke globalman yo',
	'globalblocking-search-legend'           => 'Chache pou yon blokaj global',
	'globalblocking-search-ip'               => 'Adrès IP:',
	'globalblocking-search-submit'           => 'Chache pou blokaj yo',
	'globalblocking-list-ipinvalid'          => "Adrès IP ou t'ap chache a ($1) envalid.
Souple antre yon adrès IP ki valid.",
	'globalblocking-search-errors'           => 'Bouskay ou a pa t’ reyisi, paske:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') bloke globalman '''[[Espesyal:Kontribisyon yo/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'expirasyon $1',
	'globalblocking-list-anononly'           => 'Anonim sèlman',
	'globalblocking-list-unblock'            => 'Debloke',
	'globalblocking-list-whitelisted'        => 'Te lokalman deaktive pa $1: $2',
	'globalblocking-list-whitelist'          => 'estati lokal',
	'globalblocking-unblock-ipinvalid'       => 'Adrès IP ($1) ou te antre a envalid.
Silvouplè note ke ou pa kapab antre yon non itilizatè!',
	'globalblocking-unblock-legend'          => 'Retire yon blokaj global',
	'globalblocking-unblock-submit'          => 'Retire blokaj global',
	'globalblocking-unblock-reason'          => 'Rezon:',
	'globalblocking-unblock-notblocked'      => 'Adrès IP ($1) ou te antre a pa bloke globalman.',
	'globalblocking-unblock-unblocked'       => "Ou reyisi nan retire blokaj global #$2 sa sou adrès IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Ou pa kabap retire yon blokaj global pou adrès IP sa, paske:
$1',
	'globalblocking-unblock-successsub'      => 'Blokaj global te retire avèk siksès.',
	'globalblocking-whitelist-subtitle'      => 'Edite estati lokal yon blokaj global',
	'globalblocking-whitelist-legend'        => 'Chanje estati local',
	'globalblocking-whitelist-reason'        => 'Rezon pou chanjman:',
	'globalblocking-whitelist-status'        => 'Estati lokal:',
	'globalblocking-whitelist-statuslabel'   => 'Dezame blokaj global sa nan {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Chanje estati lokal',
	'globalblocking-whitelist-whitelisted'   => "Ou te dezame avèk siksès blokaj global sa #$2 pou adrès IP '''$1''' nan {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Ou te re-pemèt blokaj global la #$2 sou adrès IP '''$1''' nan {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Estati lokal te chanje avèk siksès',
	'globalblocking-blocked'                 => "Adrès IP w la te bloke nan tout Wikimedia wikis pa '''\$1''' (''\$2'').
Rezon ki te bay la se ''\"\$3\"''. Tan expirasyon blòkaj la se ''\$4''.",
	'globalblocking-logpage'                 => 'Lòg blokaj global',
	'globalblocking-block-logentry'          => 'globalman bloke [[$1]] avèk yon tan expirasyon $2 ($3)',
	'globalblocking-unblock-logentry'        => 'retire blokaj global la sou [[$1]]',
	'globalblocking-whitelist-logentry'      => 'dezame blokaj global la sou [[$1]] lokalman',
	'globalblocking-dewhitelist-logentry'    => 're-mete blokaj global sou [[$1]] lokalman',
	'globalblocklist'                        => 'Lis Adrès IP bloke globalman yo',
	'globalblock'                            => 'Bloke yon adrès IP globalman',
	'right-globalblock'                      => 'Fè blokaj global',
	'right-globalunblock'                    => 'Retire blokaj global yo',
	'right-globalblock-whitelist'            => 'Dezame blokaj global yo lokalman',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'globalblocking-list-expiry'    => 'lejárat: $1',
	'globalblocking-unblock-reason' => 'Ok:',
	'globalblock'                   => 'IP-cím globális blokkolása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'globalblocking-block-expiry-otherfield' => 'Altere duration:',
	'globalblocking-list-anononly'           => 'anon-solmente',
	'globalblocking-unblock-reason'          => 'Motivo:',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 * @author Irwangatot
 */
$messages['id'] = array(
	'globalblocking-block-options'  => 'Pilihan',
	'globalblocking-unblock-reason' => 'Alasan:',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'globalblocking-unblock-reason' => 'Ástæða:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'globalblocking-search-ip' => 'Indirizzo IP:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Marengaké]] alamat-alamat IP [[Special:GlobalBlockList|diblokir sacara lintas wiki]]',
	'globalblocking-block'                   => 'Blokir alamat IP sacara global',
	'globalblocking-block-intro'             => 'Panjenengan bisa nganggo kaca iki kanggo mblokir sawijining alamat IP ing kabèh wiki.',
	'globalblocking-block-reason'            => 'Alesan pamblokiran iki:',
	'globalblocking-block-expiry'            => 'Kadaluwarsa pamblokiran:',
	'globalblocking-block-expiry-other'      => 'Wektu kadaluwarsa liya',
	'globalblocking-block-expiry-otherfield' => 'Wektu liya:',
	'globalblocking-block-legend'            => 'Blokir sawijining panganggo sacara global',
	'globalblocking-block-options'           => 'Opsi-opsi',
	'globalblocking-block-errors'            => 'Blokadené ora suksès, amerga:
$1',
	'globalblocking-block-ipinvalid'         => 'AlamatIP sing dilebokaké ($1) iku ora absah.
Tulung digatèkaké yèn panjenengan ora bisa nglebokaké jeneng panganggo!',
	'globalblocking-block-expiryinvalid'     => 'Wektu kadaluwarsa sing dilebokaké ($1) ora absah.',
	'globalblocking-block-submit'            => 'Blokir alamat IP iki sacara global',
	'globalblocking-block-success'           => 'Alamat IP $1 bisa diblokir sacara suksès ing kabèh proyèk Wikimedia.
Panjenengan mbok-menawa kersa mirsani [[Special:Globalblocklist|daftar blokade global]].',
	'globalblocking-block-successsub'        => 'Pamblokiran global bisa kasil suksès',
	'globalblocking-block-alreadyblocked'    => 'Alamat IP $1 wis diblokir sacara global. Panjenengan bisa ndeleng blokade sing ana ing kaca [[Special:Globalblocklist|daftar blokade global]].',
	'globalblocking-list'                    => 'Daftar alamat-alamat IP sing diblokir sacara global',
	'globalblocking-search-legend'           => 'Nggolèki blokade global',
	'globalblocking-search-ip'               => 'Alamat IP:',
	'globalblocking-search-submit'           => 'Nggolèki blokade',
	'globalblocking-list-ipinvalid'          => 'Alamat IP sing digolèki ($1) iku ora absah.
Tulung lebokna alamat IP sing absah.',
	'globalblocking-search-errors'           => 'Panggolèkan panjenengan ora ana kasilé, amarga:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') sacara global mblokir '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'kadaluwarsa $1',
	'globalblocking-list-anononly'           => 'anon-waé',
	'globalblocking-list-unblock'            => 'batal blokir',
	'globalblocking-list-whitelisted'        => 'dijabel sacara lokal déning $1: $2',
	'globalblocking-list-whitelist'          => 'status lokal',
	'globalblocking-unblock-ipinvalid'       => 'AlamatIP sing dilebokaké ($1) iku ora absah.
Tulung digatèkaké yèn panjenengan ora bisa nglebokaké jeneng panganggo!',
	'globalblocking-unblock-legend'          => 'Ilangana sawijining pamblokiran global',
	'globalblocking-unblock-submit'          => 'Ilangana pamblokiran global',
	'globalblocking-unblock-reason'          => 'Alesan:',
	'globalblocking-unblock-notblocked'      => 'Alamat IP sing dilebokaké ($1) ora diblokir sacara global.',
	'globalblocking-unblock-unblocked'       => "Panjenengan sacara suksès ngilangi blokade global #$2 ing alamat IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Panjenengan ora bisa ngilangi blokade global kanggo alamat IP iku, amerga:
$1',
	'globalblocking-unblock-successsub'      => 'Blokade global bisa dibatalaké',
	'globalblocking-whitelist-subtitle'      => 'Sunting status lokal sawijining pamblokiran global',
	'globalblocking-whitelist-legend'        => 'Ganti status lokal',
	'globalblocking-whitelist-reason'        => 'Alesané diganti:',
	'globalblocking-whitelist-status'        => 'Status lokal:',
	'globalblocking-whitelist-statuslabel'   => 'Batalna pamblokiran global iki ing {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Ngganti status lokal',
	'globalblocking-whitelist-whitelisted'   => "Panjenengan sacara suksès njabel blokade global #$2 ing alamat IP '''$1''' ing {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Panjenengan sacara suksès blokade global #$2 ing alamat IP '''$1''' ing {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Status lokal kasil diganti',
	'globalblocking-blocked'                 => "Alamat IP panjenengan diblokir ing kabèh wiki Wikimedia déning '''\$1''' (''\$2'').
Alesan sing diwènèhaké yaiku ''\"\$3\"''. Blokade iki bakal kadaluwarsa ing ''\$4''.",
	'globalblocking-logpage'                 => 'Log pamblokiran global',
	'globalblocking-block-logentry'          => 'diblokir sacara global [[$1]] mawa wektu kadaluwarsa $2 ($3)',
	'globalblocking-unblock-logentry'        => 'jabelen blokade global ing [[$1]]',
	'globalblocking-whitelist-logentry'      => 'njabel blokade global ing [[$1]] sacara lokal',
	'globalblocking-dewhitelist-logentry'    => 'trapna ulang blokade global ing [[$1]] sacara lokal',
	'globalblocklist'                        => 'Tuduhna daftar alamat-alamat IP sing diblokir sacara global',
	'globalblock'                            => 'Mblokir alamat IP sacara global',
	'right-globalblock'                      => 'Nggawé pamblokiran global',
	'right-globalunblock'                    => 'Ilangana pamblokiran global',
	'right-globalblock-whitelist'            => 'Jabel blokade global sacara lokal',
);

/** Khmer (ភាសាខ្មែរ)
 * @author គីមស៊្រុន
 * @author Lovekhmer
 */
$messages['km'] = array(
	'globalblocking-block-intro'      => 'អ្នកអាចប្រើប្រាស់ទំព័រនេះដើម្បីហាមឃាត់អាសយដ្ឋាន IP នៅគ្រប់វិគីទាំងអស់។',
	'globalblocking-block-reason'     => 'មូលហេតុនៃការហាមឃាត់នេះ:',
	'globalblocking-block-expiry'     => 'ពេលផុតកំនត់នៃការហាមឃាត់:',
	'globalblocking-block-options'    => 'ជំរើសនានា',
	'globalblocking-search-ip'        => 'អាសយដ្ឋានIP:',
	'globalblocking-search-submit'    => 'ស្វែងរកចំពោះការហាមឃាត់',
	'globalblocking-list-expiry'      => 'ផុតកំនត់ $1',
	'globalblocking-list-anononly'    => 'អនាមិកជនប៉ុណ្ណោះ',
	'globalblocking-list-unblock'     => 'ដកហូត',
	'globalblocking-unblock-reason'   => 'មូលហេតុ៖',
	'globalblocking-whitelist-reason' => 'មូលហេតុផ្លាស់ប្តូរ:',
	'globalblocking-logpage'          => 'កំនត់ហេតុនៃការហាមឃាត់ជាសាកល',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'globalblocking-block-success'  => 'Di IP adress „$1“ eß jetz en alle Wikimedia Wikis jesperrt.
Loor Der de [[Special:Globalblocklist|Leß med jlobale Sperre]] aan, wann de mieh esu en Sperre fenge wells.',
	'globalblocking-list-anononly'  => 'nor namelose',
	'globalblocking-unblock-reason' => 'Aanlass:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Erlaabt et]] IP-Adressen op [[Special:GlobalBlockList|méi Wikien mateneen ze spären]]',
	'globalblocking-block'                   => 'Eng IP-Adress global spären',
	'globalblocking-block-intro'             => 'Dir kënnt dës Säit benotzen fir eng IP-Adress op alle Wikien ze spären.',
	'globalblocking-block-reason'            => 'Grond fir dës Spär:',
	'globalblocking-block-expiry'            => 'Dauer vun der Spär:',
	'globalblocking-block-expiry-other'      => 'Aner Dauer vun der Spär',
	'globalblocking-block-expiry-otherfield' => 'Aner Dauer:',
	'globalblocking-block-legend'            => 'E Benotzer global spären',
	'globalblocking-block-options'           => 'Optiounen',
	'globalblocking-block-errors'            => "D'Spär huet net fonctionnéiert, well:
$1",
	'globalblocking-block-ipinvalid'         => 'Dir hutt eng ongëlteg IP-Adress ($1) aginn.
Denkt w.e.g. drun datt Dir och e Benotzernumm agi kënnt!',
	'globalblocking-block-submit'            => 'Dës IP-Adress global spären',
	'globalblocking-block-success'           => "D'IP-Adress $1 gouf op alle Wikimedia-Projeten gespaart.
D'Lëscht vun de globale Späre fannt Dir [[Special:Globalblocklist|hei]].",
	'globalblocking-block-successsub'        => 'Global gespaart',
	'globalblocking-block-alreadyblocked'    => "D'IP-Adress $1 ass scho global gespaart. Dir kënnt d'Spären op der [[Special:Globalblocklist|Lëscht vun de globale Späre]] kucken.",
	'globalblocking-list'                    => 'Lëscht vun de global gespaarten IP-Adressen',
	'globalblocking-search-legend'           => 'Sich no enger globaler Spär',
	'globalblocking-search-ip'               => 'IP-Adress:',
	'globalblocking-search-submit'           => 'Späre sichen',
	'globalblocking-list-ipinvalid'          => "D'IP-adress no däer Dir Gesicht hutt ($1) ass net korrekt.
Gitt w.e.g eng korrekt IP-Adress an.",
	'globalblocking-search-errors'           => 'Bäi ärer Sich gouf näischt fonnt, well:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (vu(n) ''$3'') huet'''[[Special:Contributions/$4|$4]]''' global gespaart ''($5)''",
	'globalblocking-list-expiry'             => 'Dauer vun der Spär $1',
	'globalblocking-list-anononly'           => 'nëmmen anonym Benotzer',
	'globalblocking-list-unblock'            => 'Spär ophiewen',
	'globalblocking-list-whitelisted'        => 'lokal ausgeschalt vum $1: $2',
	'globalblocking-list-whitelist'          => 'lokale Status',
	'globalblocking-unblock-ipinvalid'       => 'Dir hutt eng ongëlteg IP-Adress ($1) aginn.
Denkt w.e.g. drun datt Dir och e Benotzernumm agi kënnt!',
	'globalblocking-unblock-legend'          => 'Eng global Spär ophiewen',
	'globalblocking-unblock-submit'          => 'Global Spär ophiewen',
	'globalblocking-unblock-reason'          => 'Grond:',
	'globalblocking-unblock-notblocked'      => "D'IP-Adress ($1) déi dir aginn hutt ass net global gespaart.",
	'globalblocking-unblock-unblocked'       => "Dir hutt d'global Spär #$2 vun der IP-Adress '''$1''' opgehuewen",
	'globalblocking-unblock-errors'          => "Dir kënnt d'global Spär fir déi IP-Adress net ophiewen. Grond:
$1",
	'globalblocking-unblock-successsub'      => 'Global Spär ass opgehuewen',
	'globalblocking-unblock-subtitle'        => 'Global Spär gëtt opgehuewen',
	'globalblocking-whitelist-subtitle'      => 'De lokale Status vun enger globaler Spär änneren',
	'globalblocking-whitelist-legend'        => 'De lokale Status änneren',
	'globalblocking-whitelist-reason'        => 'Grond vun der Ännerung:',
	'globalblocking-whitelist-status'        => 'Lokale Status:',
	'globalblocking-whitelist-statuslabel'   => 'Dës global Spär op {{SITENAME}} ophiewen',
	'globalblocking-whitelist-submit'        => 'De globale Status änneren',
	'globalblocking-whitelist-whitelisted'   => "Dir hutt d'global Spär #$2 vun der IP-Adress '''$1''' op {{SITENAME}} opgehiuewen.",
	'globalblocking-whitelist-dewhitelisted' => "Dir hutt d'global Spär #$2 vun der IP-Adress '''$1''' op {{SITENAME}} nees aktivéiert.",
	'globalblocking-whitelist-successsub'    => 'De lokale Status gouf geännert',
	'globalblocking-blocked'                 => "Är IP-adress gouf op alle wikimedia Wikie vum '''\$1''' (''\$2'') gespaart.
De Grond den ugi gouf war ''\"\$3\"''. D'spär dauert ''\$4''.",
	'globalblocking-logpage'                 => 'Lëscht vun de globale Spären',
	'globalblocking-block-logentry'          => '[[$1]] gouf global gespaart fir $2 ($3)',
	'globalblocking-unblock-logentry'        => 'global Spär vum [[$1]] opgehuewen',
	'globalblocking-whitelist-logentry'      => 'huet déi global Spär vum [[$1]] lokal ausgeschalt',
	'globalblocking-dewhitelist-logentry'    => 'huet déi global Spär vun [[$1]] lokal nees aktivéiert',
	'globalblocklist'                        => 'Lëscht vun de global gespaarten IP-Adressen',
	'globalblock'                            => 'Eng IP-Adress global spären',
	'right-globalblock'                      => 'Benotzer global spären',
	'right-globalunblock'                    => 'Global Spären ophiewen',
	'right-globalblock-whitelist'            => 'Global Späre lokal ausschalten',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'globalblocking-block'                   => 'ഒരു ഐപി വിലാസത്തെ ആഗോളമായി തടയുക',
	'globalblocking-block-intro'             => 'ഒരു ഐപി വിലാസത്തെ എല്ലാ വിക്കികളിലും നിരോധിക്കുവാന്‍ താങ്കള്‍ക്കു ഈ താള്‍ ഉപയോഗിക്കാം.',
	'globalblocking-block-reason'            => 'ഐപി വിലാസം തടയുവാനുള്ള കാരണം:',
	'globalblocking-block-expiry'            => 'തടയലിന്റെ കാലാവധി:',
	'globalblocking-block-expiry-other'      => 'മറ്റ് കാലാവധി',
	'globalblocking-block-expiry-otherfield' => 'മറ്റ് കാലാവധി:',
	'globalblocking-block-legend'            => 'ഒരു ഉപയോക്താവിനെ ആഗോളമായി തടയുക',
	'globalblocking-block-errors'            => 'തടയല്‍ പരാജയപ്പെട്ടു, കാരണം: 
$1',
	'globalblocking-block-ipinvalid'         => 'താങ്കള്‍ കൊടുത്ത ഐപി വിലാസം ($1) അസാധുവാണ്‌. 
താങ്കള്‍ക്കു ഇവിടെ ഒരു ഉപയോക്തൃനാമം കൊടുക്കുവാന്‍ പറ്റില്ല എന്നതു പ്രത്യേകം ശ്രദ്ധിക്കുക.',
	'globalblocking-block-expiryinvalid'     => 'താങ്കള്‍ കൊടുത്ത കാലാവധി ($1) അസാധുവാണ്‌.',
	'globalblocking-block-submit'            => 'ഈ ഐപിവിലാസത്തെ ആഗോളമായി തടയുക',
	'globalblocking-block-successsub'        => 'ആഗോള തടയല്‍ വിജയകരം',
	'globalblocking-list'                    => 'ആഗോളമായി തടയപ്പെട്ട ഐപി വിലാസങ്ങള്‍',
	'globalblocking-search-legend'           => 'ആഗോള തടയലിന്റെ വിവരത്തിനായി തിരയുക',
	'globalblocking-search-ip'               => 'ഐപി വിലാസം:',
	'globalblocking-search-submit'           => 'തടയലിന്റെ വിവരങ്ങള്‍ തിരയുക',
	'globalblocking-list-expiry'             => 'കാലാവധി $1',
	'globalblocking-list-anononly'           => 'അജ്ഞാത ഉപയോക്താക്കളെ മാത്രം',
	'globalblocking-list-unblock'            => 'സ്വതന്ത്രമാക്കുക',
	'globalblocking-list-whitelisted'        => '$1 ഇതിനെ പ്രാദേശികമായി നിര്‍‌വീര്യമാക്കിയിക്കുന്നു: $2',
	'globalblocking-list-whitelist'          => 'പ്രാദേശിക സ്ഥിതി',
	'globalblocking-unblock-ipinvalid'       => 'താങ്കള്‍ കൊടുത്ത ഐപി വിലാസം ($1) അസാധുവാണ്‌. 
താങ്കള്‍ക്കു ഇവിടെ ഒരു ഉപയോക്തൃനാമം കൊടുക്കുവാന്‍ പറ്റില്ല എന്നതു പ്രത്യേകം ശ്രദ്ധിക്കുക.',
	'globalblocking-unblock-legend'          => 'ആഗോള ബ്ലോക്ക് മാറ്റുക',
	'globalblocking-unblock-submit'          => 'ആഗോള ബ്ലോക്ക് മാറ്റുക',
	'globalblocking-unblock-reason'          => 'കാരണം:',
	'globalblocking-unblock-notblocked'      => 'താങ്കള്‍ ചേര്‍ത്ത ഐപി വിലാസം ($1) ആഗോളമായി തടയപ്പെട്ടിട്ടില്ല.',
	'globalblocking-unblock-unblocked'       => "'''$1''' എന്ന ഐപി വിലാസത്തിന്മേലുള്ള #$2 എന്ന ആഗോള ബ്ലോക്ക് താങ്കള്‍ വിജയകരമായി ഒഴിവാക്കിയിരിക്കുന്നു",
	'globalblocking-unblock-errors'          => 'ഈ ഐപി വിലാസത്തിന്മേലുള്ള ആഗോള ബ്ലോക്ക് ഒഴിവാക്കാന്‍ താങ്കള്‍ക്ക് പറ്റില്ല, അതിന്റെ കാരണം: $1',
	'globalblocking-unblock-successsub'      => 'ആഗോള ബ്ലോക്ക് വിജയകരമായി നീക്കിയിരിക്കുന്നു',
	'globalblocking-whitelist-subtitle'      => 'ആഗോള ബ്ലോക്കിന്റെ പ്രാദേശിക സ്ഥിതി പരിശോധിക്കുക',
	'globalblocking-whitelist-legend'        => 'പ്രാദേശിക സ്ഥിതി മാറ്റുക',
	'globalblocking-whitelist-reason'        => 'മാറ്റം വരുത്താനുള്ള കാരണം:',
	'globalblocking-whitelist-status'        => 'പ്രാദേശിക സ്ഥിതി:',
	'globalblocking-whitelist-statuslabel'   => '{{SITENAME}} സം‌രംഭത്തില്‍ ആഗോളബ്ലോക്ക് ഡിസേബിള്‍ ചെയ്യുക',
	'globalblocking-whitelist-submit'        => 'പ്രാദേശിക സ്ഥിതി മാറ്റുക',
	'globalblocking-whitelist-whitelisted'   => "'''$1''' എന്ന ഐപി വിലാസത്തിന്റെ #$2 എന്ന ആഗോളബ്ലോക്ക് {{SITENAME}} സം‌രംഭത്തില്‍ വിജയകരമായി പ്രവര്‍ത്തനരഹിതമാക്കിയിരിക്കുന്നു",
	'globalblocking-whitelist-dewhitelisted' => "'''$1''' എന്ന ഐപി വിലാസത്തിന്റെ #$2 എന്ന ആഗോളബ്ലോക്ക് {{SITENAME}} സം‌രംഭത്തില്‍ വിജയകരമായി പ്രവര്‍ത്തനയോഗ്യമാക്കിയിരിക്കുന്നു.",
	'globalblocking-whitelist-successsub'    => 'പ്രാദേശിക സ്ഥിതി വിജയകരമായി മാറ്റിയിരിക്കുന്നു',
	'globalblocking-blocked'                 => "താങ്കളുടെ ഐപി വിലാസം എല്ലാ വിക്കിമീഡിയ സം‌രംഭങ്ങളിലും '''\$1''' (''\$2'') തടഞ്ഞിരിക്കുന്നു. അതിനു സൂചിപ്പിച്ച കാരണം ''\"\$3\"'' ആണ്‌. ബ്ലോക്കിന്റെ കാലാവധി തീരുന്നത് ''\$4''.",
	'globalblocking-logpage'                 => 'ആഗോള തടയലിന്റെ പ്രവര്‍ത്തനരേഖ',
	'globalblocking-block-logentry'          => '[[$1]]നെ $2 ($3) കാലവധിയോടെ ആഗോള ബ്ലോക്ക് ചെയ്തിരിക്കുന്നു.',
	'globalblocking-unblock-logentry'        => '[[$1]]നു മേലുള്ള ആഗോള ബ്ലോക്ക് ഒഴിവാക്കിയിരിക്കുന്നു',
	'globalblocking-whitelist-logentry'      => '[[$1]] നു മേലുള്ള ആഗോള ബ്ലോക്ക് പ്രാദേശികമായി ഒഴിവാക്കിയിരിക്കുന്നു',
	'globalblocklist'                        => 'ആഗോളമായി തടയപ്പെട്ട ഐപിവിലാസങ്ങള്‍ പ്രദര്‍ശിപ്പിക്കുക',
	'globalblock'                            => 'ഒരു ഐപി വിലാസത്തെ ആഗോളമായി തടയുക',
	'right-globalblock'                      => 'ആഗോള തടയല്‍ നടത്തുക',
	'right-globalunblock'                    => 'ആഗോള ബ്ലോക്ക് മാറ്റുക',
	'right-globalblock-whitelist'            => 'ആഗോള തടയലിനെ പ്രാദേശികമായി നിര്‍‌വീര്യമാക്കുക',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'globalblocking-desc'                    => 'आइपी अंकपत्त्याला [[Special:GlobalBlockList|अनेक विकिंवर ब्लॉक]] करण्याची [[Special:GlobalBlock|परवानगी]] देतो.',
	'globalblocking-block'                   => 'आयपी अंकपत्ता वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-block-intro'             => 'तुम्ही हे पान वापरून एखाद्या आयपी अंकपत्त्याला सर्व विकिंवर ब्लॉक करू शकता.',
	'globalblocking-block-reason'            => 'या ब्लॉक करीता कारण:',
	'globalblocking-block-expiry'            => 'ब्लॉक समाप्ती:',
	'globalblocking-block-expiry-other'      => 'इतर समाप्ती वेळ',
	'globalblocking-block-expiry-otherfield' => 'इतर वेळ:',
	'globalblocking-block-legend'            => 'एक सदस्य वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-block-options'           => 'विकल्प',
	'globalblocking-block-errors'            => 'ब्लॉक अयशस्वी झालेला आहे, कारण:
$1',
	'globalblocking-block-ipinvalid'         => 'तुम्ही दिलेला आयपी अंकपत्ता ($1) अयोग्य आहे.
कृपया नोंद घ्या की तुम्ही सदस्य नाव देऊ शकत नाही!',
	'globalblocking-block-expiryinvalid'     => 'तुम्ही दिलेली समाप्तीची वेळ ($1) अयोग्य आहे.',
	'globalblocking-block-submit'            => 'ह्या आयपी अंकपत्त्याला वैश्विक पातळीवर ब्लॉक करा',
	'globalblocking-block-success'           => '$1 या आयपी अंकपत्त्याला सर्व विकिंवर यशस्वीरित्या ब्लॉक करण्यात आलेले आहे.
तुम्ही कदाचित [[Special:Globalblocklist|वैश्विक ब्लॉक्सची यादी]] पाहू इच्छिता.',
	'globalblocking-block-successsub'        => 'वैश्विक ब्लॉक यशस्वी',
	'globalblocking-block-alreadyblocked'    => '$1 हा आयपी अंकपत्ता अगोदरच ब्लॉक केलेला आहे. तुम्ही अस्तित्वात असलेले ब्लॉक [[Special:Globalblocklist|वैश्विक ब्लॉकच्या यादीत]] पाहू शकता.',
	'globalblocking-block-bigrange'          => 'तुम्ही दिलेली रेंज ($1) ही ब्लॉक करण्यासाठी खूप मोठी आहे. तुम्ही एकावेळी जास्तीत जास्त ६५,५३६ पत्ते ब्लॉक करू शकता (/१६ रेंज)',
	'globalblocking-list'                    => 'वैश्विक पातळीवर ब्लॉक केलेले आयपी अंकपत्ते',
	'globalblocking-search-legend'           => 'एखाद्या वैश्विक ब्लॉक ला शोधा',
	'globalblocking-search-ip'               => 'आयपी अंकपत्ता:',
	'globalblocking-search-submit'           => 'ब्लॉक साठी शोध',
	'globalblocking-list-ipinvalid'          => 'तुम्ही शोधायला दिलेला आयपी अंकपत्ता ($1) अयोग्य आहे.
कृपया योग्य आयपी अंकपत्ता द्या.',
	'globalblocking-search-errors'           => 'तुमचा शोध अयशस्वी झालेला आहे, कारण:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') वैश्विक पातळीवर ब्लॉक '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'समाप्ती $1',
	'globalblocking-list-anononly'           => 'फक्त-अनामिक',
	'globalblocking-list-unblock'            => 'अनब्लॉक',
	'globalblocking-list-whitelisted'        => '$1 ने स्थानिक पातळीवर रद्द केले: $2',
	'globalblocking-list-whitelist'          => 'स्थानिक स्थिती',
	'globalblocking-unblock-ipinvalid'       => 'तुम्ही दिलेला आयपी अंकपत्ता ($1) अयोग्य आहे.
कृपया नोंद घ्या की तुम्ही सदस्य नाव वापरू शकत नाही!',
	'globalblocking-unblock-legend'          => 'एक वैश्विक ब्लॉक काढा',
	'globalblocking-unblock-submit'          => 'वैश्विक ब्लॉक काढा',
	'globalblocking-unblock-reason'          => 'कारण:',
	'globalblocking-unblock-notblocked'      => 'तुम्ही दिलेला आयपी अंकपत्ता ($1) वैश्विक पातळीवर ब्लॉक केलेला नाही.',
	'globalblocking-unblock-unblocked'       => "तुम्ही आयपी अंकपत्ता '''$1''' वर असणारा वैश्विक ब्लॉक #$2 यशस्वीरित्या काढलेला आहे",
	'globalblocking-unblock-errors'          => 'तुम्ही या आयपी अंकपत्त्यावरील वैश्विक ब्लॉक काढू शकत नाही, कारण:
$1',
	'globalblocking-unblock-successsub'      => 'वैश्विक ब्लॉक काढलेला आहे',
	'globalblocking-unblock-subtitle'        => 'वैश्विक ब्लॉक काढत आहे',
	'globalblocking-whitelist-subtitle'      => 'एका वैश्विक ब्लॉकची स्थानिक स्थिती संपादत आहे',
	'globalblocking-whitelist-legend'        => 'स्थानिक स्थिती बदला',
	'globalblocking-whitelist-reason'        => 'बदलांसाठीचे कारण:',
	'globalblocking-whitelist-status'        => 'स्थानिक स्थिती:',
	'globalblocking-whitelist-statuslabel'   => '{{SITENAME}} वर हा वैश्विक ब्लॉक रद्द करा',
	'globalblocking-whitelist-submit'        => 'स्थानिक स्थिती बदला',
	'globalblocking-whitelist-whitelisted'   => "तुम्ही '''$1''' या अंकपत्त्याचा वैश्विक ब्लॉक #$2 {{SITENAME}} वर रद्द केलेला आहे.",
	'globalblocking-whitelist-dewhitelisted' => "तुम्ही '''$1''' या अंकपत्त्याचा वैश्विक ब्लॉक #$2 {{SITENAME}} वर पुन्हा दिलेला आहे.",
	'globalblocking-whitelist-successsub'    => 'स्थानिक स्थिती बदलली',
	'globalblocking-blocked'                 => "तुमचा आयपी अंकपत्ता सर्व विकिमीडिया विकिंवर '''\$1''' (''\$2'') ने ब्लॉक केलेला आहे.
यासाठी ''\"\$3\"'' हे कारण दिलेले आहे. या ब्लॉक ची समाप्ती ''\$4'' आहे.",
	'globalblocking-logpage'                 => 'वैश्विक ब्लॉक सूची',
	'globalblocking-block-logentry'          => '$2 ($3) हा समाप्ती कालावधी देऊन [[$1]] ला वैश्विक पातळीवर ब्लॉक केले',
	'globalblocking-unblock-logentry'        => '[[$1]] वरील वैश्विक ब्लॉक काढला',
	'globalblocking-whitelist-logentry'      => '[[$1]] वरचा वैश्विक ब्लॉक स्थानिक पातळीवर रद्द केला',
	'globalblocking-dewhitelist-logentry'    => '[[$1]] वरचा वैश्विक ब्लॉक स्थानिक पातळीवर पुन्हा दिला',
	'globalblocklist'                        => 'वैश्विक पातळीवर ब्लॉक केलेल्या आयपी अंकपत्त्यांची यादी',
	'globalblock'                            => 'आयपी अंकपत्त्याला वैश्विक पातळीवर ब्लॉक करा',
	'right-globalblock'                      => 'वैश्विक ब्लॉक तयार करा',
	'right-globalunblock'                    => 'वैश्विक ब्लॉक काढून टाका',
	'right-globalblock-whitelist'            => 'वैश्विक ब्लॉक स्थानिक पातळीवर रद्द करा',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'globalblocking-list-anononly' => 'zan ahtōcā',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'globalblocking-desc'                    => "[[Special:GlobalBlock|Maakt het mogelijk]] IP-addressen [[Special:GlobalBlockList|in meerdere wiki's tegelijk]] te blokkeren",
	'globalblocking-block'                   => 'Een IP-adres globaal blokkeren',
	'globalblocking-block-intro'             => "U kunt deze pagina gebruiken om een IP-adres op alle wiki's te blokkeren.",
	'globalblocking-block-reason'            => 'Reden voor deze blokkade:',
	'globalblocking-block-expiry'            => 'Verloopdatum blokkade:',
	'globalblocking-block-expiry-other'      => 'Andere verlooptermijn',
	'globalblocking-block-expiry-otherfield' => 'Andere tijd:',
	'globalblocking-block-legend'            => 'Een gebruiker globaal blokkeren',
	'globalblocking-block-options'           => 'Opties',
	'globalblocking-block-errors'            => 'De blokkade is niet geslaagd omdat: $1',
	'globalblocking-block-ipinvalid'         => 'Het IP-adres ($1) dat u hebt opgegeven is onjuist.
Let op: u kunt geen gebruikersnaam opgeven!',
	'globalblocking-block-expiryinvalid'     => 'De verloopdatum/tijd die u hebt opgegeven is ongeldig ($1).',
	'globalblocking-block-submit'            => 'Dit IP-adres globaal blokkeren',
	'globalblocking-block-success'           => 'De blokkade van het IP-adres $1 voor alle projecten van Wikimedia is geslaagd.
U kunt een [[Special:Globalblocklist|lijst van alle globale blokkades]] bekijken.',
	'globalblocking-block-successsub'        => 'Globale blokkade geslaagd',
	'globalblocking-block-alreadyblocked'    => 'Het IP-adres $1 is al globaal geblokkeerd. U kunt de bestaande blokkade bekijken in de [[Special:Globalblocklist|lijst met globale blokkades]].',
	'globalblocking-block-bigrange'          => 'De reeks die u hebt opgegeven ($1) is te groot om te blokkeren. U mag ten hoogste 65.536 adressen blokkeren (/16-reeksen)',
	'globalblocking-list'                    => 'Lijst met globaal geblokeerde IP-adressen',
	'globalblocking-search-legend'           => 'Naar een globale blokkade zoeken',
	'globalblocking-search-ip'               => 'IP-adres:',
	'globalblocking-search-submit'           => 'Naar blokkades zoeken',
	'globalblocking-list-ipinvalid'          => 'Het IP-adres waar u naar zocht is onjuist ($1).
Voer alstublieft een correct IP-adres in.',
	'globalblocking-search-errors'           => 'Uw zoekopdracht is niet geslaagd, omdat:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') heeft '''[[Special:Contributions/$4|$4]]''' globaal geblokkeerd ''($5)''",
	'globalblocking-list-expiry'             => 'verloopt $1',
	'globalblocking-list-anononly'           => 'alleen anoniemen',
	'globalblocking-list-unblock'            => 'blokkade opheffen',
	'globalblocking-list-whitelisted'        => 'lokaal genegeerd door $1: $2',
	'globalblocking-list-whitelist'          => 'lokale status',
	'globalblocking-unblock-ipinvalid'       => 'Het IP-adres ($1) dat u hebt ingegeven is onjuist.
Let op: u kunt geen gebruikersnaam ingeven!',
	'globalblocking-unblock-legend'          => 'Een globale blokkade verwijderen',
	'globalblocking-unblock-submit'          => 'Globale blokkade verwijderen',
	'globalblocking-unblock-reason'          => 'Reden:',
	'globalblocking-unblock-notblocked'      => 'Het IP-adres ($1) dat u hebt ingegeven is niet globaal geblokkeerd.',
	'globalblocking-unblock-unblocked'       => "U hebt de globale blokkade met nummer $2 voor het IP-adres '''$1''' verwijderd",
	'globalblocking-unblock-errors'          => 'U kunt de globale blokkade voor dat IP-adres niet verwijderen omdat:
$1',
	'globalblocking-unblock-successsub'      => 'De globale blokkade is verwijderd',
	'globalblocking-unblock-subtitle'        => 'Globale blokkade aan het verwijderen',
	'globalblocking-whitelist-subtitle'      => 'Bezig met het bewerken van de lokale status van een globale blokkade',
	'globalblocking-whitelist-legend'        => 'Lokale status wijzigen',
	'globalblocking-whitelist-reason'        => 'Reden:',
	'globalblocking-whitelist-status'        => 'Lokale status:',
	'globalblocking-whitelist-statuslabel'   => 'Deze globale blokkade op {{SITENAME}} uitschakelen',
	'globalblocking-whitelist-submit'        => 'Lokale status wijzigen',
	'globalblocking-whitelist-whitelisted'   => "U hebt de globale blokkade #$2 met het IP-adres '''$1''' op {{SITENAME}} opgeheven.",
	'globalblocking-whitelist-dewhitelisted' => "U hebt de globale blokkade #$2 met het IP-adres '''$1''' op {{SITENAME}} opnieuw actief gemaakt.",
	'globalblocking-whitelist-successsub'    => 'De lokale status is gewijzigd',
	'globalblocking-blocked'                 => "Uw IP-adres is door '''\$1''' (''\$2'') geblokkeerd op alle wiki's van Wikimedia.
De reden is ''\"\$3\"''. De blokkade verloopt op ''\$4''.",
	'globalblocking-logpage'                 => 'Globaal blokkeerlogboek',
	'globalblocking-block-logentry'          => 'heeft [[$1]] globaal geblokkeerd met een verlooptijd van $2 ($3)',
	'globalblocking-unblock-logentry'        => 'heeft de globale blokkade voor [[$1]] verwijderd',
	'globalblocking-whitelist-logentry'      => 'heeft de globale blokkade van [[$1]] lokaal opgeheven',
	'globalblocking-dewhitelist-logentry'    => 'heeft de globale blokkade van [[$1]] lokaal opnieuw ingesteld',
	'globalblocklist'                        => 'Lijst van globaal geblokkeerde IP-adressen',
	'globalblock'                            => 'Een IP-adres globaal blokkeren',
	'right-globalblock'                      => 'Globale blokkades instellen',
	'right-globalunblock'                    => 'Globale blokkades verwijderen',
	'right-globalblock-whitelist'            => 'Globale blokkades lokaal negeren',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jorunn
 * @author Eirik
 * @author Siebrand
 */
$messages['nn'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Gjer det råd]] å blokkera IP-adresser [[Special:GlobalBlockList|krosswiki]]',
	'globalblocking-block'                   => 'Blokker ei IP-adresse krosswiki',
	'globalblocking-block-intro'             => 'Du kan nytte denne sida til å blokkere ei IP-adresse krosswiki.',
	'globalblocking-block-reason'            => 'Grunngjeving for blokkeringa:',
	'globalblocking-block-expiry'            => 'Blokkeringa varer til:',
	'globalblocking-block-expiry-other'      => 'Anna varigheit',
	'globalblocking-block-expiry-otherfield' => 'Anna tid:',
	'globalblocking-block-legend'            => 'Blokker ein brukar krosswiki',
	'globalblocking-block-options'           => 'Alternativ',
	'globalblocking-block-errors'            => 'Blokkeringa tok ikkje, grunna:',
	'globalblocking-block-ipinvalid'         => 'IP-adressa du skreiv inn ($1) er ugyldig.
Merk at du ikkje kan skrive inn brukarnamn.',
	'globalblocking-block-expiryinvalid'     => 'Varigheita du skreiv inn ($1) er ikkje gyldig.',
	'globalblocking-block-submit'            => 'Blokker denne IP-adressa krosswiki',
	'globalblocking-block-success'           => 'IP-adressa $1 har vorte blokkert på alle Wikimedia-prosjekta.
Sjå òg [[Special:Globalblocklist|lista over krosswikiblokkeringar]].',
	'globalblocking-block-successsub'        => 'Krosswikiblokkeringa vart utførd',
	'globalblocking-block-alreadyblocked'    => 'IP-adressa $1 er allereide krosswikiblokkert.
Du kan sjå blokkeringa på [[Special:Globalblocklist|lista over krosswikiblokkeringar]].',
	'globalblocking-list'                    => 'Liste over krosswikiblokkertet IP-adresser',
	'globalblocking-search-legend'           => 'Søk etter ei krosswikiblokkering',
	'globalblocking-search-ip'               => 'IP-adresse:',
	'globalblocking-search-submit'           => 'Søk etter blokkeringar',
	'globalblocking-list-ipinvalid'          => 'IP-adressa du skreiv inn ($1) er ikkje gyldig.
Skriv inn ei gyldig IP-adresse.',
	'globalblocking-search-errors'           => 'Søket ditt lukkast ikkje fordi:
$1',
	'globalblocking-list-blockitem'          => "$1 '''$2''' ('''$3''') blokkerte '''[[Special:Contributions/$4|$4]]''' krosswiki ''($5)''",
	'globalblocking-list-expiry'             => 'varigheit $1',
	'globalblocking-list-anononly'           => 'berre uregistrerte',
	'globalblocking-list-unblock'            => 'fjern blokkeringa',
	'globalblocking-unblock-ipinvalid'       => 'IP-adressa du skreiv inn ($1) er ugyldig.
Merk at du ikkje kan skrive inn brukarnamn.',
	'globalblocking-unblock-legend'          => 'Fjern ei krosswikiblokkering',
	'globalblocking-unblock-submit'          => 'Fjern krosswikiblokkering',
	'globalblocking-unblock-reason'          => 'Grunngjeving:',
	'globalblocking-unblock-notblocked'      => 'IP-adressa du skreiv inn ($1) er ikkje krosswikiblokkert.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Gjør det mulig]] å blokkere IP-adresser på [[Special:GlobalBlockList|alle wikier]]',
	'globalblocking-block'                   => 'Blokker en IP-adresse globalt',
	'globalblocking-block-intro'             => 'Du kan bruke denne siden for å blokkere en IP-adresse på alle wikier.',
	'globalblocking-block-reason'            => 'Blokkeringsårsak:',
	'globalblocking-block-expiry'            => 'Varighet:',
	'globalblocking-block-expiry-other'      => 'Annen varighet',
	'globalblocking-block-expiry-otherfield' => 'Annen tid:',
	'globalblocking-block-legend'            => 'Blokker en bruker globalt',
	'globalblocking-block-options'           => 'Alternativer',
	'globalblocking-block-errors'            => 'Blokkeringen mislyktes på grunn av: $1',
	'globalblocking-block-ipinvalid'         => 'IP-adressen du skrev inn ($1) er ugyldig.
Merk at du ikke kan skrive inn brukernavn.',
	'globalblocking-block-expiryinvalid'     => 'Varigheten du skrev inn ($1) er ugyldig.',
	'globalblocking-block-submit'            => 'Blokker denne IP-adressen globalt',
	'globalblocking-block-success'           => 'IP-adressen $1 har blitt blokkert på alle Wikimedia-prosjekter.
Du ønsker kanskje å se [[Special:Globalblocklist|listen over globale blokkeringer]].',
	'globalblocking-block-successsub'        => 'Global blokkering lyktes',
	'globalblocking-block-alreadyblocked'    => 'IP-adressen $1 er blokkkert globalt fra før. Du kan se eksisterende blokkeringer på [[Special:Globalblocklist|listen over globale blokkeringer]].',
	'globalblocking-block-bigrange'          => 'IP-området du oppga ($1) er for stort til å blokkeres. Du kan blokkere maks 65&nbsp;536 adresser (/16-områder)',
	'globalblocking-list'                    => 'Liste over globalt blokkerte IP-adresser',
	'globalblocking-search-legend'           => 'Søk etter en global blokkering',
	'globalblocking-search-ip'               => 'IP-adresse:',
	'globalblocking-search-submit'           => 'Søk etter blokkeringer',
	'globalblocking-list-ipinvalid'          => 'IP-adressen du skrev inn ($1) er ugyldig.
Skriv inn en gyldig IP-adresse.',
	'globalblocking-search-errors'           => 'Søket ditt mislyktes på grunn av:
$1',
	'globalblocking-list-blockitem'          => "$1 '''$2''' ('''$3''') blokkerte '''[[Special:Contributions/$4|$4]]''' globalt ''($5)''",
	'globalblocking-list-expiry'             => 'varighet $1',
	'globalblocking-list-anononly'           => 'kun uregistrerte',
	'globalblocking-list-unblock'            => 'avblokker',
	'globalblocking-list-whitelisted'        => 'slått av lokalt av $1: $2',
	'globalblocking-list-whitelist'          => 'lokal status',
	'globalblocking-unblock-ipinvalid'       => 'IP-adressen du skrev inn ($1) er ugyldig.
Merk at du ikke kan skrive inn brukernavn.',
	'globalblocking-unblock-legend'          => 'Fjern en global blokkering',
	'globalblocking-unblock-submit'          => 'Fjern global blokkering',
	'globalblocking-unblock-reason'          => 'Årsak:',
	'globalblocking-unblock-notblocked'      => 'IP-adressen du skrev inn ($1) er ikke blokkert globalt.',
	'globalblocking-unblock-unblocked'       => "Du har fjernet den globale blokkeringen (#$2) på IP-adressen '''$1'''",
	'globalblocking-unblock-errors'          => 'Du kan ikke fjerne en global blokkering på den IP-adressen fordi:
$1',
	'globalblocking-unblock-successsub'      => 'Global blokkering fjernet',
	'globalblocking-unblock-subtitle'        => 'Fjerner global blokkering',
	'globalblocking-whitelist-subtitle'      => 'Redigerer lokal status for en global blokkering',
	'globalblocking-whitelist-legend'        => 'Endre lokal status',
	'globalblocking-whitelist-reason'        => 'Endringsårsak:',
	'globalblocking-whitelist-status'        => 'Lokal status:',
	'globalblocking-whitelist-statuslabel'   => 'Slå av denne globale blokkeringen på {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Endre lokal status',
	'globalblocking-whitelist-whitelisted'   => "Du har slått av global blokkering nr. $2 på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Du har slått på igjen global blokkering nr. $2 på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Lokal status endret',
	'globalblocking-blocked'                 => "IP-adressen din har blitt blokkert på alle Wikimedia-wikier av '''$1''' (''$2'').
Årsaken som ble oppgitt var '''$3'''. Blokkeringen utgår ''$4''.",
	'globalblocking-logpage'                 => 'Global blokkeringslogg',
	'globalblocking-block-logentry'          => 'blokkerte [[$1]] globalt med en varighet på $2 ($3)',
	'globalblocking-unblock-logentry'        => 'fjernet global blokkering på [[$1]]',
	'globalblocking-whitelist-logentry'      => 'slo av global blokkering av [[$1]] lokalt',
	'globalblocking-dewhitelist-logentry'    => 'slo på igjen global blokkering av [[$1]] lokalt',
	'globalblocklist'                        => 'Liste over globalt blokkerte IP-adresser',
	'globalblock'                            => 'Blokker en IP-adresse globalt',
	'right-globalblock'                      => 'Blokkere IP-er globalt',
	'right-globalunblock'                    => 'Fjerne globale blokkeringer',
	'right-globalblock-whitelist'            => 'Slå av globale blokkeringer lokalt',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Permet]] lo blocatge de las adreças IP [[Special:GlobalBlockList|a travèrs maites wikis]]',
	'globalblocking-block'                   => 'Blocar globalament una adreça IP',
	'globalblocking-block-intro'             => 'Podètz utilizar aquesta pagina per blocar una adreça IP sus l’ensemble dels wikis.',
	'globalblocking-block-reason'            => "Motius d'aqueste blocatge :",
	'globalblocking-block-expiry'            => 'Plaja d’expiracion :',
	'globalblocking-block-expiry-other'      => 'Autra durada d’expiracion',
	'globalblocking-block-expiry-otherfield' => 'Autra durada :',
	'globalblocking-block-legend'            => 'Blocar globalament un utilizaire',
	'globalblocking-block-options'           => 'Opcions',
	'globalblocking-block-errors'            => 'Lo blocatge a pas capitat, perque :
$1',
	'globalblocking-block-ipinvalid'         => "L’adreça IP ($1) qu'avètz picada es incorrècta.
Notatz que podètz pas inscriure un nom d’utilizaire !",
	'globalblocking-block-expiryinvalid'     => "L’expiracion qu'avètz picada ($1) es incorrècta.",
	'globalblocking-block-submit'            => 'Blocar globalament aquesta adreça IP',
	'globalblocking-block-success'           => 'L’adreça IP $1 es estada blocada amb succès sus l’ensemble dels projèctes Wikimèdia.
Podètz consultaz la tièra dels [[Special:Globalblocklist|comptes blocats globalament]].',
	'globalblocking-block-successsub'        => 'Blocatge global capitat',
	'globalblocking-block-alreadyblocked'    => "L’adreça IP ja es blocada globalament. Podètz afichar los blocatges qu'existisson sus la tièra [[Special:Globalblocklist|dels blocatges globals]].",
	'globalblocking-block-bigrange'          => "La plaja qu'avètz especificada ($1) es tròp granda per èsser blocada. Podètz pas blocar mai de 65'536 adreças (plajas en /16).",
	'globalblocking-list'                    => 'Tièra de las adreças IP blocadas globalament',
	'globalblocking-search-legend'           => 'Recèrca d’un blocatge global',
	'globalblocking-search-ip'               => 'Adreça IP :',
	'globalblocking-search-submit'           => 'Recèrca dels blocatges',
	'globalblocking-list-ipinvalid'          => 'L’adreça IP que recercatz per ($1) es incorrècta.
Picatz una adreça IP corrècta.',
	'globalblocking-search-errors'           => 'Vòstra recèrca es estada infructuosa, perque :
$1',
	'globalblocking-list-blockitem'          => "$1 : '''$2''' (''$3'') blocat globalament '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'expiracion $1',
	'globalblocking-list-anononly'           => 'utilizaire non enregistrat unicament',
	'globalblocking-list-unblock'            => 'desblocar',
	'globalblocking-list-whitelisted'        => 'desactivat localament per $1 : $2',
	'globalblocking-list-whitelist'          => 'estatut local',
	'globalblocking-unblock-ipinvalid'       => "L’adreça IP ($1) qu'avètz picada es incorrècta.
Notatz que podètz pas inscriure un nom d’utilizaire !",
	'globalblocking-unblock-legend'          => 'Levar un blocatge global',
	'globalblocking-unblock-submit'          => 'Levar lo blocatge global',
	'globalblocking-unblock-reason'          => 'Motiu :',
	'globalblocking-unblock-notblocked'      => "L’adreça IP ($1) qu'avètz indicada fa pas l’objècte de cap de blocatge global.",
	'globalblocking-unblock-unblocked'       => "Avètz capitat de levar lo blocatge global n° $2 correspondent a l’adreça IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Podètz pas levar un blocatge global per aquesta adreça IP, perque :
$1',
	'globalblocking-unblock-successsub'      => 'Blocatge global levat amb succès',
	'globalblocking-unblock-subtitle'        => 'Supression del blocatge global',
	'globalblocking-whitelist-subtitle'      => "Cambiament de l'estatut local d'un blocatge global",
	'globalblocking-whitelist-legend'        => "Cambiar l'estatut local",
	'globalblocking-whitelist-reason'        => 'Rason del cambiament :',
	'globalblocking-whitelist-status'        => 'Estatut local :',
	'globalblocking-whitelist-statuslabel'   => 'Desactivar aqueste blocatge global sus {{SITENAME}}',
	'globalblocking-whitelist-submit'        => "Cambiar l'estatut local",
	'globalblocking-whitelist-whitelisted'   => "Avètz desactivat amb succès lo blocatge global n° $2 sus l'adreça IP '''$1''' sus {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Avètz reactivat amb succès lo blocatge global n° $2 sus l'adreça IP '''$1''' sus {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Estatut local cambiat amb succès',
	'globalblocking-blocked'                 => "Vòstra adreça IP es estada blocada sus l’ensemble dels wiki per '''$1''' (''$2'').
Lo motiu indicat es estat ''« $3 »''. L’expiracion del blocatge es pel ''$4''.",
	'globalblocking-logpage'                 => 'Jornal dels blocatges globals',
	'globalblocking-block-logentry'          => '[[$1]] blocat globalament amb una durada d’expiracion de $2 ($3)',
	'globalblocking-unblock-logentry'        => 'blocatge global levat sus [[$1]]',
	'globalblocking-whitelist-logentry'      => 'a desactivat localament lo blocatge global de [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'a tornat activar localament lo blocatge global de [[$1]]',
	'globalblocklist'                        => 'Tièra de las adreças IP blocadas globalament',
	'globalblock'                            => 'Blocar globalament una adreça IP',
	'right-globalblock'                      => "Blocar d'utilizaires globalament",
	'right-globalunblock'                    => "Desblocar d'utilizaires blocats globalament",
	'right-globalblock-whitelist'            => 'Desactivar localament los blocatges globals',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Umożliwia]] równoczesne [[Special:GlobalBlockList|blokowanie]] adresów IP na wielu wiki',
	'globalblocking-block'                   => 'Zablokuj globalnie adres IP',
	'globalblocking-block-intro'             => 'Na tej stronie możesz blokować adresy IP na wszystkich wiki.',
	'globalblocking-block-reason'            => 'Powód zablokowania',
	'globalblocking-block-expiry'            => 'Czas blokady',
	'globalblocking-block-expiry-other'      => 'Inny czas blokady',
	'globalblocking-block-expiry-otherfield' => 'Inny czas blokady',
	'globalblocking-block-legend'            => 'Zablokuj użytkownika globalnie',
	'globalblocking-block-options'           => 'Opcje',
	'globalblocking-block-errors'            => 'Zablokowanie nie powiodło się, ponieważ:
$1',
	'globalblocking-block-ipinvalid'         => 'Wprowadzony przez Ciebie adres IP ($1) jest nieprawidłowy.
Zwróć uwagę na to, że nie możesz wprowadzić nazwy użytkownika!',
	'globalblocking-block-expiryinvalid'     => 'Czas obowiązywania blokady ($1) jest nieprawidłowy.',
	'globalblocking-block-submit'            => 'Zablokuj ten adres IP globalnie',
	'globalblocking-block-success'           => 'Adres IP $1 został zablokowany na wszystkich projektach Wikimedia.
Możesz to sprawdzić w [[Special:Globalblocklist|spisie globalnych blokad]].',
	'globalblocking-block-successsub'        => 'Globalna blokada założona',
	'globalblocking-block-alreadyblocked'    => 'Adres IP $1 jest obecnie globalnie zablokowany. Możesz zobaczyć aktualnie obowiązujące blokady w [[Special:Globalblocklist|spisie globalnych blokad]].',
	'globalblocking-list'                    => 'Spis globalnie zablokowanych adresów IP',
	'globalblocking-search-legend'           => 'Szukaj globalnej blokady',
	'globalblocking-search-ip'               => 'Adres IP',
	'globalblocking-search-submit'           => 'Szukaj blokad',
	'globalblocking-list-ipinvalid'          => 'Adres IP którego szukasz ($1) jest nieprawidłowy.
Wprowadź poprawny adres.',
	'globalblocking-search-errors'           => 'Wyszukanie nie powiodło się, ponieważ:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') globalnie zablokował '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'wygaśnie $1',
	'globalblocking-list-anononly'           => 'tylko niezalogowani',
	'globalblocking-list-unblock'            => 'odblokowanie',
	'globalblocking-list-whitelisted'        => 'lokalnie zniesiona przez $1: $2',
	'globalblocking-list-whitelist'          => 'status lokalny',
	'globalblocking-unblock-ipinvalid'       => 'Wprowadzony przez Ciebie adres IP ($1) jest nieprawidłowy.
Zwróć uwagę na to, że nie możesz wprowadzić nazwy użytkownika!',
	'globalblocking-unblock-legend'          => 'Zdejmowanie globalnej blokady',
	'globalblocking-unblock-submit'          => 'Zdejmij globalną blokadę',
	'globalblocking-unblock-reason'          => 'Powód',
	'globalblocking-unblock-notblocked'      => 'Adres IP ($1), który wprowadziłeś nie jest globalnie zablokowany.',
	'globalblocking-unblock-unblocked'       => "Zdjąłeś globalną blokadę $2 dla adresu IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Nie możesz zdjąć globalnej blokady dla tego adresu IP, ponieważ:
$1',
	'globalblocking-unblock-successsub'      => 'Globalna blokada została zdjęta',
	'globalblocking-whitelist-subtitle'      => 'Edycja lokalnego statusu globalnej blokady',
	'globalblocking-whitelist-legend'        => 'Zmień lokalny status',
	'globalblocking-whitelist-reason'        => 'Powód zmiany',
	'globalblocking-whitelist-status'        => 'Lokalny status:',
	'globalblocking-whitelist-statuslabel'   => 'Znieś na {{GRAMMAR:MS.lp|{{SITENAME}}}} tą globalną blokadę',
	'globalblocking-whitelist-submit'        => 'Zmień lokalny status',
	'globalblocking-whitelist-whitelisted'   => "Wyłączyłeś na {{GRAMMAR:MS.lp|{{SITENAME}}}} stosowanie globalnej blokady $2 dla adresu IP '''$1'''.",
	'globalblocking-whitelist-dewhitelisted' => "Uruchomiłeś ponownie na {{GRAMMAR:MS.lp|{{SITENAME}}}} globalną blokadę $2 dla adresu IP '''$1'''.",
	'globalblocking-whitelist-successsub'    => 'Status lokalny blokady został zmieniony',
	'globalblocking-blocked'                 => "Twój adres IP został zablokowany na wszystkich wiki należących do Wikimedia przez '''$1''' (''$2'').
Przyczyna blokady: ''„$3”''. Blokada wygaśnie ''$4''.",
	'globalblocking-logpage'                 => 'Rejestr globalnych blokad',
	'globalblocking-block-logentry'          => 'zablokował globalnie [[$1]], czas blokady $2 ($3)',
	'globalblocking-unblock-logentry'        => 'zdjął globalną blokadę z [[$1]]',
	'globalblocking-whitelist-logentry'      => 'wyłączył lokalne stosowanie globalnej blokady dla [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'ponownie uaktywnił lokalnie globalną blokadę dla [[$1]]',
	'globalblocklist'                        => 'Spis globalnie zablokowanych adresów IP',
	'globalblock'                            => 'Zablokuj globalnie adres IP',
	'right-globalblock'                      => 'Twórz globalne blokady',
	'right-globalunblock'                    => 'Zdejmij globalne blokady',
	'right-globalblock-whitelist'            => 'Lokalnie nie stosuj globalnych blokad',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'globalblocking-block-expiry-otherfield' => 'بل وخت:',
	'globalblocking-search-ip'               => 'IP پته:',
	'globalblocking-list-whitelist'          => 'سيمه ايز دريځ',
	'globalblocking-unblock-reason'          => 'سبب:',
	'globalblocking-whitelist-reason'        => 'د بدلون سبب:',
	'globalblocking-whitelist-status'        => 'سيمه ايز دريځ:',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Lijealso
 */
$messages['pt'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Permite]] que endereços IP sejam [[Special:GlobalBlockList|bloqueados através de múltiplos wikis]]',
	'globalblocking-block'                   => 'Bloquear globalmente um endereço IP',
	'globalblocking-block-intro'             => 'Você pode usar esta página para bloquear um endereço IP em todos os wikis.',
	'globalblocking-block-reason'            => 'Motivo para este bloqueio:',
	'globalblocking-block-expiry'            => 'Validade do bloqueio:',
	'globalblocking-block-expiry-other'      => 'Outro tempo de validade',
	'globalblocking-block-expiry-otherfield' => 'Outra duração:',
	'globalblocking-block-legend'            => 'Bloquear um utilizador globalmente',
	'globalblocking-block-options'           => 'Opções',
	'globalblocking-block-errors'            => 'O bloqueio não teve sucesso, porque:
$1',
	'globalblocking-block-ipinvalid'         => 'O endereço IP ($1) que introduziu é inválido.
Por favor, note que não pode introduzir um nome de utilizador!',
	'globalblocking-block-expiryinvalid'     => 'A expiração que introduziu ($1) é inválida.',
	'globalblocking-block-submit'            => 'Bloquear globalmente este endereço IP',
	'globalblocking-block-success'           => 'O endereço IP $1 foi bloqueado com sucesso em todos os projectos Wikimedia.
Se desejar, poderá consultar a [[Special:Globalblocklist|lista de bloqueios globais]].',
	'globalblocking-block-successsub'        => 'Bloqueio global com sucesso',
	'globalblocking-block-alreadyblocked'    => 'O endereço IP $1 já está bloqueado globalmente.
Você pode ver o bloqueio existente na [[Special:Globalblocklist|lista de bloqueios globais]].',
	'globalblocking-list'                    => 'Lista de endereços IP bloqueados globalmente',
	'globalblocking-search-legend'           => 'Pesquisar bloqueio global',
	'globalblocking-search-ip'               => 'Endereço IP:',
	'globalblocking-search-submit'           => 'Pesquisar bloqueios',
	'globalblocking-list-ipinvalid'          => 'O endereço IP que procurou ($1) é inválido.
Por favor, introduza um endereço IP válido.',
	'globalblocking-search-errors'           => 'A sua busca não teve sucesso, porque:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') bloqueou globalmente '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'expira $1',
	'globalblocking-list-anononly'           => 'só anónimos',
	'globalblocking-list-unblock'            => 'desbloquear',
	'globalblocking-list-whitelisted'        => 'localmente desactivado por $1: $2',
	'globalblocking-list-whitelist'          => 'estado local',
	'globalblocking-unblock-ipinvalid'       => 'O endereço IP ($1) que introduziu é inválido.
Por favor, note que não pode introduzir um nome de utilizador!',
	'globalblocking-unblock-legend'          => 'Remover um bloqueio global',
	'globalblocking-unblock-submit'          => 'Remover bloqueio global',
	'globalblocking-unblock-reason'          => 'Motivo:',
	'globalblocking-unblock-notblocked'      => 'O endereço IP ($1) que introduziu não está bloqueado globalmente.',
	'globalblocking-unblock-unblocked'       => "Você removeu o bloqueio global #$2 sobre o endereço IP '''$1''' com sucesso",
	'globalblocking-unblock-errors'          => 'Você não pode remover o bloqueio global para esse endereço IP, porque:
$1',
	'globalblocking-unblock-successsub'      => 'Bloqueio global removido com sucesso',
	'globalblocking-whitelist-subtitle'      => 'Editando o estado local de um bloqueio global',
	'globalblocking-whitelist-legend'        => 'Alterar estado local',
	'globalblocking-whitelist-reason'        => 'Motivo da alteração:',
	'globalblocking-whitelist-status'        => 'Estado local:',
	'globalblocking-whitelist-statuslabel'   => 'Desactivar este bloqueio global em {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Alterar estado local',
	'globalblocking-whitelist-whitelisted'   => "Você desactivou com sucesso o bloqueio global #$2 sobre o endereço IP '''$1''' em {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Você reactivou com sucesso o bloqueio global #$2 sobre o endereço IP '''$1''' em {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Estado local alterado com sucesso',
	'globalblocking-blocked'                 => "O seu endereço IP foi bloqueado em todos os wikis Wikimedia por '''\$1''' (''\$2'').
O motivo dado foi ''\"\$3\"''. O bloqueio expira em ''\$4''.",
	'globalblocking-logpage'                 => 'Registo de bloqueios globais',
	'globalblocking-block-logentry'          => 'bloqueou globalmente [[$1]] com um tempo de expiração de $2 ($3)',
	'globalblocking-unblock-logentry'        => 'Removido bloqueio global de [[$1]]',
	'globalblocking-whitelist-logentry'      => 'desactivou o bloqueio global sobre [[$1]] localmente',
	'globalblocking-dewhitelist-logentry'    => 'reactivou o bloqueio global sobre [[$1]] localmente',
	'globalblocklist'                        => 'Lista de endereços IP bloqueados globalmente',
	'globalblock'                            => 'Bloquear um endereço IP globalmente',
	'right-globalblock'                      => 'Fazer bloqueios globais',
	'right-globalunblock'                    => 'Remover bloqueios globais',
	'right-globalblock-whitelist'            => 'Desactivar bloqueios globais localmente',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Brunoy Anastasiya Seryozhenko
 */
$messages['pt-br'] = array(
	'globalblocking-desc'  => '[[{{ns:Special}}:GlobalBlock|Permite]] que endereços IP sejam [[{{ns:Special}}:GlobalBlockList|bloqueados através de múltiplos wikis]]',
	'globalblocking-block' => 'Bloquear globalmente um endereço IP',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'globalblocking-block'                 => 'Blochează global o adresă IP',
	'globalblocking-block-intro'           => 'Această pagină permite blocarea unei adrese IP pe toate proiectele wiki.',
	'globalblocking-block-reason'          => 'Motiv pentru această blocare:',
	'globalblocking-block-legend'          => 'Blochează global un utilizator',
	'globalblocking-block-options'         => 'Opţiuni',
	'globalblocking-block-errors'          => 'Blocarea nu a avut succes, din cauză că:
$1',
	'globalblocking-block-submit'          => 'Blochează global această adresă IP',
	'globalblocking-block-successsub'      => 'Blocare globală cu succes',
	'globalblocking-list'                  => 'Listă de adrese IP blocate global',
	'globalblocking-search-legend'         => 'Caută blocare globală',
	'globalblocking-search-ip'             => 'Adresă IP:',
	'globalblocking-search-submit'         => 'Caută blocări',
	'globalblocking-search-errors'         => 'Căutarea dumneavoastră nu a avut succes, din cauză că:
$1',
	'globalblocking-list-blockitem'        => "$1: '''$2''' (''$3'') a blocat global '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-whitelisted'      => 'dezactivat local de $1: $2',
	'globalblocking-list-whitelist'        => 'statut local',
	'globalblocking-unblock-legend'        => 'Elimină o blocare globală',
	'globalblocking-unblock-submit'        => 'Elimină blocare globală',
	'globalblocking-unblock-reason'        => 'Motiv:',
	'globalblocking-unblock-notblocked'    => 'Adresa IP $1 nu este blocată global.',
	'globalblocking-unblock-errors'        => 'Nu puteţi elimina blocarea globală pentru acea adresă IP, din cauză că:
$1',
	'globalblocking-unblock-successsub'    => 'Blocare globală eliminată cu succes',
	'globalblocking-unblock-subtitle'      => 'Eliminare blocare globală',
	'globalblocking-whitelist-subtitle'    => 'Modificare statut local al unei blocări globale',
	'globalblocking-whitelist-legend'      => 'Schimbă statut local',
	'globalblocking-whitelist-reason'      => 'Motiv pentru schimbare:',
	'globalblocking-whitelist-status'      => 'Statut local:',
	'globalblocking-whitelist-statuslabel' => 'Dezactivează această blocare gloablă pe {{SITENAME}}',
	'globalblocking-whitelist-submit'      => 'Schimbă statut local',
	'globalblocking-whitelist-successsub'  => 'Statut global schimbat cu succes',
	'globalblocking-logpage'               => 'Jurnal blocări globale',
	'globalblocking-unblock-logentry'      => 'eliminat blocare globală pentru [[$1]]',
	'globalblocklist'                      => 'Listă de adrese IP blocate global',
	'globalblock'                          => 'Blochează global o adresă IP',
	'right-globalblock'                    => 'Efectuează blocări globale',
	'right-globalunblock'                  => 'Elimină blocări globale',
	'right-globalblock-whitelist'          => 'Dezactivează local blocările globale',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Разрешает]] блокировку IP-адресов [[Special:GlobalBlockList|на нескольких вики]]',
	'globalblocking-block'                   => 'Глобальная блокировка IP-адреса',
	'globalblocking-block-intro'             => 'Вы можете использовать эту страницу чтобы заблокировать IP-адрес на всех вики.',
	'globalblocking-block-reason'            => 'Причина блокировки:',
	'globalblocking-block-expiry'            => 'Закончится через:',
	'globalblocking-block-expiry-other'      => 'другое время окончания',
	'globalblocking-block-expiry-otherfield' => 'Другое время:',
	'globalblocking-block-legend'            => 'Глобальное блокирование участника',
	'globalblocking-block-options'           => 'Настройки',
	'globalblocking-block-errors'            => 'Блокировка неудачна. Причина:
$1',
	'globalblocking-block-ipinvalid'         => 'Введённый вами IP-адрес ($1) ошибочен.
Пожалуйста, обратите внимание, вы не можете вводить имя участника!',
	'globalblocking-block-expiryinvalid'     => 'Введённый срок окончания ($1) ошибочен.',
	'globalblocking-block-submit'            => 'Заблокировать этот IP-адрес глобально',
	'globalblocking-block-success'           => 'IP-адрес $1 был успешно заблокирован во всех проектах Викимедиа.
Вы можете обратиться к [[Special:Globalblocklist|списку глобальных блокировок]].',
	'globalblocking-block-successsub'        => 'Глобальная блокировка выполнена успешно',
	'globalblocking-block-alreadyblocked'    => 'IP-адрес $1 уже был заблокирован глобально. Вы можете просмотреть существующие блокировки в [[Special:Globalblocklist|списке глобальных блокировок]].',
	'globalblocking-list'                    => 'Список глобально заблокированных IP-адресов',
	'globalblocking-search-legend'           => 'Поиск глобальной блокировки',
	'globalblocking-search-ip'               => 'IP-адрес:',
	'globalblocking-search-submit'           => 'Найти блокировки',
	'globalblocking-list-ipinvalid'          => 'Вы ищете ошибочный IP-адрес ($1).
Пожалуйста введите корректный IP-адрес.',
	'globalblocking-search-errors'           => 'Ваш поиск не был успешен. Причина:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') заблокирован глобально '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'истекает $1',
	'globalblocking-list-anononly'           => 'только анонимов',
	'globalblocking-list-unblock'            => 'разблокировать',
	'globalblocking-list-whitelisted'        => 'локально отключил $1: $2',
	'globalblocking-list-whitelist'          => 'локальное состояние',
	'globalblocking-unblock-ipinvalid'       => 'Введённый вами IP-адрес ($1) ошибочен.
Пожалуйста, обратите внимание, вы не можете вводить имя участника!',
	'globalblocking-unblock-legend'          => 'Снятие глобальной блокировки',
	'globalblocking-unblock-submit'          => 'Снять глобальную блокировку',
	'globalblocking-unblock-reason'          => 'Причина:',
	'globalblocking-unblock-notblocked'      => 'Введённый вами IP-адрес ($1) не заблокирован глобально.',
	'globalblocking-unblock-unblocked'       => "Вы успешно сняли глобальную блокировку #$2 с IP-адреса '''$1'''",
	'globalblocking-unblock-errors'          => 'Вы не можете снять глобальную блокировку с этого IP-адреса. Причина:
$1',
	'globalblocking-unblock-successsub'      => 'Глобальная блокировка успешно снята',
	'globalblocking-whitelist-subtitle'      => 'Изменение локального состояния глобальной блокировки',
	'globalblocking-whitelist-legend'        => 'Изменение локального состояния',
	'globalblocking-whitelist-reason'        => 'Причина изменения:',
	'globalblocking-whitelist-status'        => 'Локальное состояние:',
	'globalblocking-whitelist-statuslabel'   => 'Отключить эту глобальную блокировку в {{grammar:genitive|{{SITENAME}}}}',
	'globalblocking-whitelist-submit'        => 'Изменить локальное состояние',
	'globalblocking-whitelist-whitelisted'   => "Вы успешно отключили глобальную блокировку #$2 IP-адреса '''$1''' в {{grammar:genitive|{{SITENAME}}}}",
	'globalblocking-whitelist-dewhitelisted' => "Вы успешно восстановили глобальную блокировку #$2 IP-адреса '''$1''' в {{grammar:genitive|{{SITENAME}}}}",
	'globalblocking-whitelist-successsub'    => 'Локальное состояние успешно измененно',
	'globalblocking-blocked'                 => "Ваш IP-адрес был заблокирован во всех проектах Викимедиа участником '''$1''' (''$2'').
Была указана причина: ''«$3»''. Срок блокировки: ''$4''.",
	'globalblocking-logpage'                 => 'Журнал глобальных блокировок',
	'globalblocking-block-logentry'          => 'заблокировал глобально [[$1]] со сроком блокировки $2 ($3)',
	'globalblocking-unblock-logentry'        => 'снял глобальную блокировку с [[$1]]',
	'globalblocking-whitelist-logentry'      => 'локально отключена глобальная блокировка [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'локально восстановлена глобальная блокировка [[$1]]',
	'globalblocklist'                        => 'Список заблокированных глобально IP-адресов',
	'globalblock'                            => 'Глобальная блокировка IP-адреса',
	'right-globalblock'                      => 'наложение глобальных блокировок',
	'right-globalunblock'                    => 'снятие глобальных блокировок',
	'right-globalblock-whitelist'            => 'Локальное отключение глобальных блокировок',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Umožňuje]] zablokovať IP adresy [[Special:GlobalBlockList|na viacerých wiki]]',
	'globalblocking-block'                   => 'Globálne zablokovať IP adresu',
	'globalblocking-block-intro'             => 'Táto stránka slúži na zablokovanie IP adresy na všetkých wiki.',
	'globalblocking-block-reason'            => 'Dôvod blokovania:',
	'globalblocking-block-expiry'            => 'Vypršanie blokovania:',
	'globalblocking-block-expiry-other'      => 'Iný čas vypršania',
	'globalblocking-block-expiry-otherfield' => 'Iný čas:',
	'globalblocking-block-legend'            => 'Globálne zablokovať používateľa',
	'globalblocking-block-options'           => 'Voľby',
	'globalblocking-block-errors'            => 'Blokovanie bolo neúspešné z nasledovného dôvodu:  
$1',
	'globalblocking-block-ipinvalid'         => 'IP adresa ($1), ktorú ste zadali nie je platná.
Majte na pamäti, že nemôžete zadať meno používateľa!',
	'globalblocking-block-expiryinvalid'     => 'Čas vypršania, ktorý ste zadali ($1) je neplatný.',
	'globalblocking-block-submit'            => 'Globálne zablokovať túto IP adresu',
	'globalblocking-block-success'           => 'IP adresa $1 bola úspešne zablokovaná na všetkých projektoch Wikimedia.
Možno budete chcieť skontrolovať [[Special:Globalblocklist|Zoznam globálnych blokovaní]].',
	'globalblocking-block-successsub'        => 'Globálne blokovanie úspešné',
	'globalblocking-block-alreadyblocked'    => 'IP adresa $1 je už globálne zablokovaná. Existujúce blokovanie si môžete pozrieť v [[Special:Globalblocklist|Zozname globálnych blokovaní]].',
	'globalblocking-block-bigrange'          => 'Rozsah, ktorý ste uviedli ($1) nemožno zablokovať, pretože je príliš veľký. Najviac môžete zablokovať 65&nbsp;536 adries (CIDR zápis: /16).',
	'globalblocking-list'                    => 'Zoznam globálne zablokovaných IP adries',
	'globalblocking-search-legend'           => 'Hľadať globálne blokovanie',
	'globalblocking-search-ip'               => 'IP adresa:',
	'globalblocking-search-submit'           => 'Hľadať blokovania',
	'globalblocking-list-ipinvalid'          => 'IP adresa, ktorú ste hľadali ($1) je neplatná.
Prosím, zadajte platnú IP adresu.',
	'globalblocking-search-errors'           => 'Vaše hľadanie bolo neúspešné z nasledovného dôvodu:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') globálne zablokoval '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'vyprší $1',
	'globalblocking-list-anononly'           => 'iba anonym',
	'globalblocking-list-unblock'            => 'odblokovať',
	'globalblocking-list-whitelisted'        => 'lokálne vypol $1: $2',
	'globalblocking-list-whitelist'          => 'lokálny stav',
	'globalblocking-unblock-ipinvalid'       => 'IP adresa ($1), ktorú ste zadali, je neplatná.
Majte na pamäti, že nemôžete zadať používateľské meno!',
	'globalblocking-unblock-legend'          => 'Odstrániť globálne blokovanie',
	'globalblocking-unblock-submit'          => 'Odstrániť globálne blokovanie',
	'globalblocking-unblock-reason'          => 'Dôvod:',
	'globalblocking-unblock-notblocked'      => 'IP adresa ($1), ktorú ste zadali, nie je globálne zablokovaná.',
	'globalblocking-unblock-unblocked'       => "Úspešne ste odstránili globálne blokovanie #$2 IP adresy '''$1'''",
	'globalblocking-unblock-errors'          => 'Nemôžete odstrániť globálne blokovanie tejto IP adresy z nasledovného dôvodu:
$1',
	'globalblocking-unblock-successsub'      => 'Globálne blokovanie bolo úspešne odstránené',
	'globalblocking-unblock-subtitle'        => 'Odstraňuje sa globálne blokovanie',
	'globalblocking-whitelist-subtitle'      => 'Upravuje sa lokálny stav globálneho blokovania',
	'globalblocking-whitelist-legend'        => 'Zmeniť lokálny stav',
	'globalblocking-whitelist-reason'        => 'Dôvod zmeny:',
	'globalblocking-whitelist-status'        => 'Lokálny stav:',
	'globalblocking-whitelist-statuslabel'   => 'Vypnúť toto globálne blokovanie na {{GRAMMAR:lokál|{{SITENAME}}}}',
	'globalblocking-whitelist-submit'        => 'Zmeniť lokálny stav',
	'globalblocking-whitelist-whitelisted'   => "Úspešne ste vypli globálne blokovanie #$2 IP adresy '''$1''' na {{GRAMMAR:lokál|{{SITENAME}}}}.",
	'globalblocking-whitelist-dewhitelisted' => "Úspešne ste znova zapli globálne blokovanie #$2 IP adresy '''$1''' na {{GRAMMAR:lokál|{{SITENAME}}}}.",
	'globalblocking-whitelist-successsub'    => 'Lokálny stav bol úspešne zmenený',
	'globalblocking-blocked'                 => "Vašu IP adresu zablokoval na všetkých wiki nadácie Wikimedia '''$1''' (''$2'').
Ako dôvod udáva ''„$3“''. Blokovanie vyprší ''$4''.",
	'globalblocking-logpage'                 => 'Záznam globálnych blokovaní',
	'globalblocking-block-logentry'          => 'globálne zablokoval [[$1]] s časom vypršania $2 ($3)',
	'globalblocking-unblock-logentry'        => 'odstránil globálne blokovanie [[$1]]',
	'globalblocking-whitelist-logentry'      => 'lokálne vypol globálne blokovanie [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'lokálne znovu zapol globálne blokovanie [[$1]]',
	'globalblocklist'                        => 'Zoznam globálne zablokovaných IP adries',
	'globalblock'                            => 'Globálne zablokovať IP adresu',
	'right-globalblock'                      => 'Robiť globálne blokovania',
	'right-globalunblock'                    => 'Odstraňovať globálne blokovania',
	'right-globalblock-whitelist'            => 'Lokálne vypnúť globálne blokovania',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Омогућује]] [[Special:GlobalBlockList|глобално блокирање]] ИП адреса на више викија',
	'globalblocking-block'                   => 'Глобално блокирајте ИП адресу',
	'globalblocking-block-intro'             => 'Можете користити ову страницу да блокирате ИП адресу на свим викијима.',
	'globalblocking-block-reason'            => 'Разлог блока:',
	'globalblocking-block-expiry'            => 'Блок истиче:',
	'globalblocking-block-expiry-other'      => 'Друго време истека',
	'globalblocking-block-expiry-otherfield' => 'Друго време:',
	'globalblocking-block-legend'            => 'Блокирајте корисника глобално',
	'globalblocking-block-options'           => 'Опције',
	'globalblocking-block-errors'            => 'Блок није успешан због:
$1',
	'globalblocking-block-ipinvalid'         => 'ИП адреса ($1) коју сте унели није добра.
Запамтите да не можете унети корисничко име!',
	'globalblocking-block-expiryinvalid'     => 'Време истека блока које сте унели ($1) није исправно.',
	'globalblocking-block-submit'            => 'Блокирајте ову ИП адресу глобално',
	'globalblocking-block-success'           => 'Ип адреса $1 је успешно блокирана на свим Викимедијиним пројектима.
Погледајте [[Special:Globalblocklist|списак глобалних блокова]].',
	'globalblocking-block-successsub'        => 'Успешан глобални блок',
	'globalblocking-block-alreadyblocked'    => 'ИП адреса $1 је већ блокирана глобално. Можете погледати списак постојећих [[Special:Globalblocklist|глобалних блокова]].',
	'globalblocking-list'                    => 'Списак глобално блокираних ИП адреса',
	'globalblocking-search-legend'           => 'Претражите глобалне блокове',
	'globalblocking-search-ip'               => 'ИП адреса:',
	'globalblocking-search-submit'           => 'Претражите блокове',
	'globalblocking-list-ipinvalid'          => 'ИП адреса коју тражите ($1) није исправна.
Молимо Вас унесите исправну ИП адресу.',
	'globalblocking-search-errors'           => 'Ваша претрага није успешна због:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') глобално блокирао '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'истиче $1',
	'globalblocking-list-anononly'           => 'само анонимне',
	'globalblocking-list-unblock'            => 'одблокирај',
	'globalblocking-unblock-ipinvalid'       => 'ИП адреса ($1) коју сте унели није исправна.
Запамтите да не можете уносити корисничка имена!',
	'globalblocking-unblock-legend'          => 'Уклоните глобални блок',
	'globalblocking-unblock-submit'          => 'Уклоните глобални блок',
	'globalblocking-unblock-reason'          => 'Разлог:',
	'globalblocking-unblock-notblocked'      => 'ИП адреса ($1) коју сте унели није глобално блокирана.',
	'globalblocking-unblock-unblocked'       => "Успешно сте уклонили глобални блок #$2 за ИП адресу '''$1'''.",
	'globalblocking-unblock-errors'          => 'Не можете уклонити глобални блок за ту ИП адресу због:
$1',
	'globalblocking-unblock-successsub'      => 'Глобални блок успешно уклоњен',
	'globalblocking-blocked'                 => "Ваша ИП адреса је блокирана на свим Викимедијиним викијима. Корисник који је блокирао '''$1''' (''$2'').
Разлог за блокаду је „''$3''”. Блок истиче ''$4''.",
	'globalblocking-logpage'                 => 'Историја глобалних блокова',
	'globalblocking-block-logentry'          => 'глобално блокирао [[$1]] са временом истицања од $2 ($3)',
	'globalblocking-unblock-logentry'        => 'уклонио глобални блок за [[$1]]',
	'globalblocklist'                        => 'Списак глобално блокираних ИП адреса',
	'globalblock'                            => 'Глобално блокирајте ИП адресу',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'globalblocking-unblock-reason'   => 'Alesan:',
	'globalblocking-whitelist-reason' => 'Alesan parobahan:',
);

/** Swedish (Svenska)
 * @author M.M.S.
 */
$messages['sv'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Tillåter]] IP-adresser att bli [[Special:GlobalBlockList|blockerade tvärs över mångfaldiga wikier]]',
	'globalblocking-block'                   => 'Blockerar en IP-adress globalt',
	'globalblocking-block-intro'             => 'Du kan använda denna sida för att blockera en IP-adress på alla wikier.',
	'globalblocking-block-reason'            => 'Blockeringsorsak:',
	'globalblocking-block-expiry'            => 'Varighet:',
	'globalblocking-block-expiry-other'      => 'Annan varighet',
	'globalblocking-block-expiry-otherfield' => 'Annan tid:',
	'globalblocking-block-legend'            => 'Blockerar en användare globalt',
	'globalblocking-block-options'           => 'Alternativ',
	'globalblocking-block-errors'            => 'Blockeringen misslyckades på grund av: $1',
	'globalblocking-block-ipinvalid'         => 'IP-adressen du skrev in ($1) är ogiltig.
Notera att du inte kan skriva in användarnamn.',
	'globalblocking-block-expiryinvalid'     => 'Varigheten du skrev in ($1) är ogiltig.',
	'globalblocking-block-submit'            => 'Blockera denna IP-adress globalt',
	'globalblocking-block-success'           => 'IP-adressen $1 har blivit blockerad på alla Wikimedia-projekt.
Du vill kanske att se [[Special:Globalblocklist|listan över globala blockeringar]].',
	'globalblocking-block-successsub'        => 'Global blockering lyckades',
	'globalblocking-block-alreadyblocked'    => 'IP-adressen $1 är redan blockerad globalt. Du kan visa den existerande blockeringen på [[Special:Globalblocklist|listan över globala blockeringar]].',
	'globalblocking-block-bigrange'          => 'IP-området du angav ($1) är för stort att blockeras. Du kan blockera högst 65&nbsp;536 adresser (/16-områden)',
	'globalblocking-list'                    => 'Lista över globalt blockerade IP-adresser',
	'globalblocking-search-legend'           => 'Sök efter en global blockering',
	'globalblocking-search-ip'               => 'IP-adress:',
	'globalblocking-search-submit'           => 'Sök efter blockeringar',
	'globalblocking-list-ipinvalid'          => 'IP-adressen du skrev in ($1) är ogiltig.
Skriv in en giltig IP-adress.',
	'globalblocking-search-errors'           => 'Din sökning misslyckades på grund av:
$1',
	'globalblocking-list-blockitem'          => "$1 '''$2''' ('''$3''') blockerade '''[[Special:Contributions/$4|$4]]''' globalt ''($5)''",
	'globalblocking-list-expiry'             => 'varighet $1',
	'globalblocking-list-anononly'           => 'endast oregistrerade',
	'globalblocking-list-unblock'            => 'avblockera',
	'globalblocking-list-whitelisted'        => 'lokalt avslagen av $1: $2',
	'globalblocking-list-whitelist'          => 'lokal status',
	'globalblocking-unblock-ipinvalid'       => 'IP-adressen du skrev in ($1) är ogiltig.
Notera att du inte kan skriva in användarnamn!',
	'globalblocking-unblock-legend'          => 'Ta bort en global blockering',
	'globalblocking-unblock-submit'          => 'Ta bort global blockering',
	'globalblocking-unblock-reason'          => 'Anledning:',
	'globalblocking-unblock-notblocked'      => 'IP-adressen du skrev in ($1) är inte globalt blockerad.',
	'globalblocking-unblock-unblocked'       => "Du har tagit bort den globala blockeringen (#$2) på IP-adressen '''$1'''",
	'globalblocking-unblock-errors'          => 'Du kan inte ta bort en global blockering på den IP-adressen för att:
$1',
	'globalblocking-unblock-successsub'      => 'Global blockering borttagen',
	'globalblocking-unblock-subtitle'        => 'Tar bort global blockering',
	'globalblocking-whitelist-subtitle'      => 'Redigerar den lokala statusen för en global blockering',
	'globalblocking-whitelist-legend'        => 'Ändra lokal status',
	'globalblocking-whitelist-reason'        => 'Anledning för ändring:',
	'globalblocking-whitelist-status'        => 'Lokal status:',
	'globalblocking-whitelist-statuslabel'   => 'Slå av den här globala blockeringen på {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Ändra lokal status',
	'globalblocking-whitelist-whitelisted'   => "Du har slagit av global blockering nr. $2 på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Du har slagit på global blockering nr. $2 igen på IP-adressen '''$1''' på {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Lokal status ändrad',
	'globalblocking-blocked'                 => "Din IP-adress har blivit blockerad på alla Wikimedia-wikier av '''$1''' (''$2'').
Anledningar var '''$3'''. Blockeringen utgår ''$4''.",
	'globalblocking-logpage'                 => 'Logg för globala blockeringar',
	'globalblocking-block-logentry'          => 'blockerade [[$1]] globalt med en varighet på $2 ($3)',
	'globalblocking-unblock-logentry'        => 'tog bort global blockering på [[$1]]',
	'globalblocking-whitelist-logentry'      => 'slog av global blockering av [[$1]] lokalt',
	'globalblocking-dewhitelist-logentry'    => 'slog på global blockering igen av [[$1]] lokalt',
	'globalblocklist'                        => 'Lista över globalt blockerade IP-adresser',
	'globalblock'                            => 'Blockera en IP-adress globalt',
	'right-globalblock'                      => 'Göra globala blockeringar',
	'right-globalunblock'                    => 'Ta bort globala blockeringar',
	'right-globalblock-whitelist'            => 'Slå av globala blockeringar lokalt',
);

/** Telugu (తెలుగు)
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'globalblocking-block-reason'            => 'ఈ నిరోధానికి కారణం:',
	'globalblocking-block-expiry-otherfield' => 'ఇతర సమయం:',
	'globalblocking-block-options'           => 'ఎంపికలు',
	'globalblocking-search-ip'               => 'IP చిరునామా:',
	'globalblocking-list-whitelist'          => 'స్థానిక స్థితి',
	'globalblocking-unblock-reason'          => 'కారణం:',
	'globalblocking-whitelist-legend'        => 'స్థానిక స్థితి మార్పు',
	'globalblocking-whitelist-reason'        => 'మార్చడానికి కారణం:',
	'globalblocking-whitelist-status'        => 'స్థానిక స్థితి:',
	'globalblocking-whitelist-submit'        => 'స్థానిక స్థితిని మార్చండి',
	'globalblock'                            => 'సర్వత్రా ఈ ఐపీ చిరునామాను నిరోధించు',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'globalblocking-whitelist-reason' => 'Сабаби тағйир:',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'globalblocking-desc'         => '[[Special:GlobalBlock|อนุญาต]]ให้คุณสามารถบล็อกผู้ใช้ที่เป็น ไอพี [[Special:GlobalBlockList|ในหลาย ๆ วิกิ]]ในครั้งเดียวได้',
	'globalblocking-block-reason' => 'เหตุผลสำหรับการบล็อก:',
	'globalblocking-block-expiry' => 'หมดอายุ:',
	'globalblocking-block-errors' => 'การบล็อกครั้งนี้ไม่สำเร็จ เนื่องจาก :
$1',
	'globalblocking-search-ip'    => 'หมายเลขไอพี:',
);

/** Turkish (Türkçe)
 * @author Suelnur
 */
$messages['tr'] = array(
	'globalblocking-unblock-reason' => 'Neden:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Consentir]] el bloco de un indirisso IP su [[Special:GlobalBlockList|tante wiki]]',
	'globalblocking-block'                   => 'Bloca globalmente un indirisso IP',
	'globalblocking-block-intro'             => 'Ti pol doparar sta pagina par blocar un indirisso IP su tute le wiki.',
	'globalblocking-block-reason'            => 'Motivassion del bloco:',
	'globalblocking-block-expiry'            => 'Scadensa del bloco:',
	'globalblocking-block-expiry-other'      => 'Altra scadensa',
	'globalblocking-block-expiry-otherfield' => 'Altro tenpo:',
	'globalblocking-block-legend'            => 'Bloca un utente globalmente',
	'globalblocking-block-options'           => 'Opzioni',
	'globalblocking-block-errors'            => "El bloco no'l ga vu sucesso, parché:
$1",
	'globalblocking-block-ipinvalid'         => "L'indirisso IP ($1) che te gh'è scrito no'l xe valido.
Par piaser tien conto che no ti pol inserir un nome utente!",
	'globalblocking-block-expiryinvalid'     => 'La scadensa che ti ga inserìo ($1) no la xe valida.',
	'globalblocking-block-submit'            => 'Bloca sto indirisso IP globalmente',
	'globalblocking-block-success'           => "L'indirisso IP $1 el xe stà blocà con sucesso su tuti i progeti Wikimedia.
Se ti vol, ti pol vardar la  [[Special:Globalblocklist|lista dei blochi globali]].",
	'globalblocking-block-successsub'        => 'Bloco global efetuà',
	'globalblocking-block-alreadyblocked'    => "L'indirisso IP $1 el xe de zà blocà globalmente. Ti pol védar el bloco esistente su la [[Special:Globalblocklist|lista dei blochi globali]].",
	'globalblocking-list'                    => 'Lista de indirissi IP blocà globalmente',
	'globalblocking-search-legend'           => 'Serca un bloco global',
	'globalblocking-search-ip'               => 'Indirisso IP:',
	'globalblocking-search-submit'           => 'Serca un bloco',
	'globalblocking-list-ipinvalid'          => "L'indirisso IP che ti gà sercà ($1) no'l xe mìa valido.
Par piaser, inserissi un indirisso IP valido.",
	'globalblocking-search-errors'           => 'La to riserca no la gà catà gnente, parché:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') gà blocà globalmente '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => 'scadensa $1',
	'globalblocking-list-anononly'           => 'solo anonimi',
	'globalblocking-list-unblock'            => 'desbloca',
	'globalblocking-list-whitelisted'        => 'localmente disabilità da $1: $2',
	'globalblocking-list-whitelist'          => 'stato local',
	'globalblocking-unblock-ipinvalid'       => "L'indirisso IP che ti gà inserìo ($1) no'l xe mìa valido.
Par piaser tien presente che no ti pol inserir un nome utente!",
	'globalblocking-unblock-legend'          => 'Cava un bloco global',
	'globalblocking-unblock-submit'          => 'Cava el bloco global',
	'globalblocking-unblock-reason'          => 'Motivassion:',
	'globalblocking-unblock-notblocked'      => "L'indirisso IP che ti gà inserìo ($1) no'l xe mìa blocà globalmente.",
	'globalblocking-unblock-unblocked'       => "Ti gà cavà con sucesso el bloco global #$2 su l'indirisso IP '''$1'''",
	'globalblocking-unblock-errors'          => 'No ti pol cavar un bloco global par sto indirisso IP, parché:
$1',
	'globalblocking-unblock-successsub'      => 'El bloco global el xe stà cava',
	'globalblocking-whitelist-subtitle'      => 'Modifica el stato local de un bloco global',
	'globalblocking-whitelist-legend'        => 'Canbia el stato local',
	'globalblocking-whitelist-reason'        => 'Motivassion del canbiamento:',
	'globalblocking-whitelist-status'        => 'Stato local:',
	'globalblocking-whitelist-statuslabel'   => 'Disabilita sto bloco global su {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Canbia stato local',
	'globalblocking-whitelist-whitelisted'   => "Ti ga disabilità el bloco global #$2 su l'indirisso IP '''$1''' su {{SITENAME}}",
	'globalblocking-whitelist-dewhitelisted' => "Ti gà ri-ativà el bloco global #$2 su l'indirisso IP '''$1''' su {{SITENAME}}",
	'globalblocking-whitelist-successsub'    => 'Stato local canbià',
	'globalblocking-blocked'                 => "El to indirisso IP el xe stà blocà su tuti i progeti Wikimedia da '''\$1''' (''\$2'').
La motivassion fornìa la xe ''\"\$3\"''. La scadensa del bloco la xe '\$4''.",
	'globalblocking-logpage'                 => 'Registro dei blochi globali',
	'globalblocking-block-logentry'          => '[[$1]] xe stà blocà globalmente con scadensa: $2 ($3)',
	'globalblocking-unblock-logentry'        => 'cavà el bloco global su [[$1]]',
	'globalblocking-whitelist-logentry'      => 'disabilità localmente el bloco global su [[$1]]',
	'globalblocking-dewhitelist-logentry'    => 'ri-abilità localmente el bloco global su [[$1]]',
	'globalblocklist'                        => 'Lista dei indirissi IP blocà globalmente',
	'globalblock'                            => 'Bloca globalmente un indirisso IP',
	'right-globalblock'                      => 'Bloca dei utenti globalmente',
	'right-globalunblock'                    => 'Cava blochi globali',
	'right-globalblock-whitelist'            => 'Disabilita localmente blochi globali',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|Cho phép]] [[Special:GlobalBlockList|cấm địa chỉ IP trên nhiều wiki]]',
	'globalblocking-block'                   => 'Cấm một địa chỉ IP trên toàn hệ thống',
	'globalblocking-block-intro'             => 'Bạn có thể sử dụng trang này để cấm một địa chỉ IP trên tất cả các wiki.',
	'globalblocking-block-reason'            => 'Lý do cấm:',
	'globalblocking-block-expiry'            => 'Hết hạn cấm:',
	'globalblocking-block-expiry-other'      => 'Thời gian hết hạn khác',
	'globalblocking-block-expiry-otherfield' => 'Thời hạn khác:',
	'globalblocking-block-legend'            => 'Cấm một thành viên trên toàn hệ thống',
	'globalblocking-block-options'           => 'Tùy chọn',
	'globalblocking-block-errors'            => 'Cấm không thành công, lý do:
$1',
	'globalblocking-block-ipinvalid'         => 'Bạn đã nhập địa chỉ IP ($1) không hợp lệ.
Xin chú ý rằng không thể nhập một tên người dùng!',
	'globalblocking-block-expiryinvalid'     => 'Thời hạn bạn nhập ($1) không hợp lệ.',
	'globalblocking-block-submit'            => 'Cấm địa chỉ IP này trên toàn hệ thống',
	'globalblocking-block-success'           => 'Đã cấm thành công địa chỉ IP $1 trên tất cả các dự án Wikimedia.
Có thể bạn cần xem lại [[Special:Globalblocklist|danh sách các lần cấm toàn hệ thống]].',
	'globalblocking-block-successsub'        => 'Cấm thành công trên toàn hệ thống',
	'globalblocking-block-alreadyblocked'    => 'Địa chỉ IP $1 đã bị cấm trên toàn hệ thống rồi. Bạn có thể xem những IP đang bị cấm tại [[Special:Globalblocklist|danh sách các lần cấm toàn hệ thống]].',
	'globalblocking-block-bigrange'          => 'Tầm địa chỉ mà bạn chỉ định ($1) quá lớn nên không thể cấm. Bạn chỉ có thể cấm nhiều nhất là 65.536 địa chỉ (tầm vực /16)',
	'globalblocking-list'                    => 'Danh sách các địa chỉ IP bị cấm trên toàn hệ thống',
	'globalblocking-search-legend'           => 'Tìm một lần cấm toàn hệ thống',
	'globalblocking-search-ip'               => 'Địa chỉ IP:',
	'globalblocking-search-submit'           => 'Tìm lần cấm',
	'globalblocking-list-ipinvalid'          => 'Địa chỉ IP bạn muốn tìm ($1) không hợp lệ.
Xin hãy nhập một địa IP hợp lệ.',
	'globalblocking-search-errors'           => 'Tìm kiếm không thành công, lý do:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') đã cấm '''[[Special:Contributions/$4|$4]]''' trên toàn hệ thống ''($5)''",
	'globalblocking-list-expiry'             => 'hết hạn $1',
	'globalblocking-list-anononly'           => 'chỉ cấm vô danh',
	'globalblocking-list-unblock'            => 'bỏ cấm',
	'globalblocking-list-whitelisted'        => 'bị tắt cục bộ bởi $1: $2',
	'globalblocking-list-whitelist'          => 'tình trạng cục bộ',
	'globalblocking-unblock-ipinvalid'       => 'Bạn đã nhập địa chỉ IP ($1) không hợp lệ.
Xin chú ý rằng không thể nhập một tên người dùng!',
	'globalblocking-unblock-legend'          => 'Xóa bỏ một lần cấm toàn hệ thống',
	'globalblocking-unblock-submit'          => 'Bỏ cấm hệ thống',
	'globalblocking-unblock-reason'          => 'Lý do:',
	'globalblocking-unblock-notblocked'      => 'Địa chỉ IP ($1) bạn đã nhập không bị cấm trên toàn hệ thống.',
	'globalblocking-unblock-unblocked'       => "Bạn đã bỏ thành công lần cấm #$2 đối với địa chỉ IP '''$1'''",
	'globalblocking-unblock-errors'          => 'Bạn không thể bỏ cấm cho địa chỉ IP này, lý do:
$1',
	'globalblocking-unblock-successsub'      => 'Đã bỏ cấm trên toàn hệ thống thành công',
	'globalblocking-unblock-subtitle'        => 'Bỏ cấm toàn bộ',
	'globalblocking-whitelist-subtitle'      => 'Sửa đổi tình trạng cục bộ của tác vụ cấm toàn cục',
	'globalblocking-whitelist-legend'        => 'Thay đổi tình trạng cục bộ',
	'globalblocking-whitelist-reason'        => 'Lý do thay đổi:',
	'globalblocking-whitelist-status'        => 'Tình trạng cục bộ:',
	'globalblocking-whitelist-statuslabel'   => 'Tắt tác vụ cấm toàn cục này tại {{SITENAME}}',
	'globalblocking-whitelist-submit'        => 'Thay đổi tình trạng cục bộ',
	'globalblocking-whitelist-whitelisted'   => "Bạn đã tắt tác vụ cấm địa chỉ IP '''$1''' toàn cục (#$2) tại {{SITENAME}}.",
	'globalblocking-whitelist-dewhitelisted' => "Bạn đã bật lên tác vụ cấm địa chỉ IP '''$1''' toàn cục (#$2) tại {{SITENAME}}.",
	'globalblocking-whitelist-successsub'    => 'Thay đổi tình trạng cục bộ thành công',
	'globalblocking-blocked'                 => "Địa chỉ IP của bạn đã bị '''\$1''' (''\$2'') cấm trên tất cả các wiki của Wikimedia.
Lý do được đưa ra là ''\"\$3\"''. Thời gian hết hạn cấm là ''\$4''.",
	'globalblocking-logpage'                 => 'Nhật trình cấm trên toàn hệ thống',
	'globalblocking-block-logentry'          => 'đã cấm [[$1]] trên toàn hệ thống với thời gian hết hạn của $2 ($3)',
	'globalblocking-unblock-logentry'        => 'đã bỏ cấm trên toàn hệ thống vào [[$1]]',
	'globalblocking-whitelist-logentry'      => 'đã tắt tác vụ cấm [[$1]] cục bộ',
	'globalblocking-dewhitelist-logentry'    => 'đã bật lên tác vụ cấm [[$1]] cục bộ',
	'globalblocklist'                        => 'Danh sách các địa chỉ IP bị cấm trên toàn hệ thống',
	'globalblock'                            => 'Cấm một địa chỉ IP trên toàn hệ thống',
	'right-globalblock'                      => 'Cấm toàn cục',
	'right-globalunblock'                    => 'Bỏ cấm toàn cục',
	'right-globalblock-whitelist'            => 'Tắt tác vụ cấm toàn cục',
);

/** Yue (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|容許]]IP地址可以[[Special:GlobalBlockList|響多個wiki度封鎖]]',
	'globalblocking-block'                   => '全域封鎖一個IP地址',
	'globalblocking-block-intro'             => '你可以用呢版去封鎖全部wiki嘅一個IP地址。',
	'globalblocking-block-reason'            => '封鎖嘅原因:',
	'globalblocking-block-expiry'            => '封鎖到期:',
	'globalblocking-block-expiry-other'      => '其它嘅到期時間',
	'globalblocking-block-expiry-otherfield' => '其它時間:',
	'globalblocking-block-legend'            => '全域封鎖一位用戶',
	'globalblocking-block-options'           => '選項',
	'globalblocking-block-errors'            => '個封鎖唔成功，因為:
$1',
	'globalblocking-block-ipinvalid'         => '你所輸入嘅IP地址 ($1) 係無效嘅。
請留意嘅係你唔可以輸入一個用戶名！',
	'globalblocking-block-expiryinvalid'     => '你所輸入嘅到期 ($1) 係無效嘅。',
	'globalblocking-block-submit'            => '全域封鎖呢個IP地址',
	'globalblocking-block-success'           => '個IP地址 $1 已經響所有Wikimedia計劃度成功噉封鎖咗。
你亦都可以睇吓個[[Special:Globalblocklist|全域封鎖一覽]]。',
	'globalblocking-block-successsub'        => '全域封鎖成功',
	'globalblocking-block-alreadyblocked'    => '個IP地址 $1 已經全域封鎖緊。你可以響[[Special:Globalblocklist|全域封鎖一覽]]度睇吓現時嘅封鎖。',
	'globalblocking-list'                    => '全域封鎖IP地址一覽',
	'globalblocking-search-legend'           => '搵一個全域封鎖',
	'globalblocking-search-ip'               => 'IP地址:',
	'globalblocking-search-submit'           => '搵封鎖',
	'globalblocking-list-ipinvalid'          => '你所搵嘅IP地址 ($1) 係無效嘅。
請輸入一個有效嘅IP地址。',
	'globalblocking-search-errors'           => '你之前搵過嘅嘢唔成功，因為:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') 全域封鎖咗 '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => '於$1到期',
	'globalblocking-list-anononly'           => '限匿名',
	'globalblocking-list-unblock'            => '解封',
	'globalblocking-list-whitelisted'        => '由$1於本地封鎖: $2',
	'globalblocking-list-whitelist'          => '本地狀態',
	'globalblocking-unblock-ipinvalid'       => '你輸入嘅IP地址 ($1) 係無效嘅。
請留意嘅係你唔可以輸入一個用戶名！',
	'globalblocking-unblock-legend'          => '拎走一個全域封鎖',
	'globalblocking-unblock-submit'          => '拎走全域封鎖',
	'globalblocking-unblock-reason'          => '原因:',
	'globalblocking-unblock-notblocked'      => '你所輸入嘅IP地址 ($1) 無被全域封鎖。',
	'globalblocking-unblock-unblocked'       => "你己經成功噉拎走咗響IP地址 '''$1''' 嘅全域封鎖 #$2 ",
	'globalblocking-unblock-errors'          => '你唔可以拎走嗰個IP地址嘅全域封鎖，因為:
$1',
	'globalblocking-unblock-successsub'      => '全域封鎖已經成功噉拎走咗',
	'globalblocking-whitelist-subtitle'      => '編輯一個全域封鎖嘅本地狀態',
	'globalblocking-whitelist-legend'        => '改本地狀態',
	'globalblocking-whitelist-reason'        => '改嘅原因:',
	'globalblocking-whitelist-status'        => '本地狀態:',
	'globalblocking-whitelist-statuslabel'   => '停用響{{SITENAME}}嘅全域封鎖',
	'globalblocking-whitelist-submit'        => '改本地狀態',
	'globalblocking-whitelist-whitelisted'   => "你已經成功噉響{{SITENAME}}嘅IP地址 '''$1''' 度停用咗全域封鎖 #$2。",
	'globalblocking-whitelist-dewhitelisted' => "你已經成功噉響{{SITENAME}}嘅IP地址 '''$1''' 度再次啟用咗全域封鎖 #$2。",
	'globalblocking-whitelist-successsub'    => '本地狀態已經成功噉改咗',
	'globalblocking-blocked'                 => "你嘅IP地址已經由'''\$1''' (''\$2'') 響所有嘅Wikimedia wiki 度全部封鎖晒。
個原因係 ''\"\$3\"''。個封鎖會響''\$4''到期。",
	'globalblocking-logpage'                 => '全域封鎖日誌',
	'globalblocking-block-logentry'          => '全域封鎖咗[[$1]]於 $2 ($3) 到期',
	'globalblocking-unblock-logentry'        => '拎走咗[[$1]]嘅全域封鎖',
	'globalblocking-whitelist-logentry'      => '停用咗[[$1]]響本地嘅全域封鎖',
	'globalblocking-dewhitelist-logentry'    => '再開[[$1]]響本地嘅全域封鎖',
	'globalblocklist'                        => '全域封鎖IP地址一覽',
	'globalblock'                            => '全域封鎖一個IP地址',
	'right-globalblock'                      => '整一個全域封鎖',
	'right-globalunblock'                    => '拎走全域封鎖',
	'right-globalblock-whitelist'            => '響本地停用全域封鎖',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Shinjiman
 */
$messages['zh-hans'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|容许]]IP地址可以[[Special:GlobalBlockList|在多个wiki中封锁]]',
	'globalblocking-block'                   => '全域封锁一个IP地址',
	'globalblocking-block-intro'             => '您可以用这个页面去封锁全部wiki中的一个IP地址。',
	'globalblocking-block-reason'            => '封锁的理由:',
	'globalblocking-block-expiry'            => '封锁到期:',
	'globalblocking-block-expiry-other'      => '其它的到期时间',
	'globalblocking-block-expiry-otherfield' => '其它时间:',
	'globalblocking-block-legend'            => '全域封锁一位用户',
	'globalblocking-block-options'           => '选项',
	'globalblocking-block-errors'            => '该封锁不唔成功，因为:
$1',
	'globalblocking-block-ipinvalid'         => '您所输入的IP地址 ($1) 是无效的。
请留意的是您不可以输入一个用户名！',
	'globalblocking-block-expiryinvalid'     => '您所输入的到期 ($1) 是无效的。',
	'globalblocking-block-submit'            => '全域封锁这个IP地址',
	'globalblocking-block-success'           => '该IP地址 $1 已经在所有Wikimedia计划中成功地封锁。
您亦都可以参看[[Special:Globalblocklist|全域封锁名单]]。',
	'globalblocking-block-successsub'        => '全域封锁成功',
	'globalblocking-block-alreadyblocked'    => '该IP地址 $1 已经全域封锁中。您可以在[[Special:Globalblocklist|全域封锁名单]]中参看现时的封锁。',
	'globalblocking-list'                    => '全域封锁IP地址名单',
	'globalblocking-search-legend'           => '搜寻一个全域封锁',
	'globalblocking-search-ip'               => 'IP地址:',
	'globalblocking-search-submit'           => '搜寻封锁',
	'globalblocking-list-ipinvalid'          => '您所搜自导引IP地址 ($1) 是无效的。
请输入一个有效的IP地址。',
	'globalblocking-search-errors'           => '您先前搜寻过的项目不成功，因为:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') 全域封锁了 '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => '于$1到期',
	'globalblocking-list-anononly'           => '只限匿名',
	'globalblocking-list-unblock'            => '解除封锁',
	'globalblocking-list-whitelisted'        => '由$1于本地封锁: $2',
	'globalblocking-list-whitelist'          => '本地状态',
	'globalblocking-unblock-ipinvalid'       => '您所输入的IP地址 ($1) 是无效的。
请留意的是您不可以输入一个用户名！',
	'globalblocking-unblock-legend'          => '移除一个全域封锁',
	'globalblocking-unblock-submit'          => '移除全域封锁',
	'globalblocking-unblock-reason'          => '原因:',
	'globalblocking-unblock-notblocked'      => '您所输入的IP地址 ($1) 没有被全域封锁。',
	'globalblocking-unblock-unblocked'       => "您己经成功地移除了在IP地址 '''$1''' 上的全域封锁 #$2 ",
	'globalblocking-unblock-errors'          => '您不可以移除该IP地址的全域封锁，因为:
$1',
	'globalblocking-unblock-successsub'      => '全域封锁已经成功地移除',
	'globalblocking-whitelist-subtitle'      => '编辑一个全域封锁的本地状态',
	'globalblocking-whitelist-legend'        => '更改本地状态',
	'globalblocking-whitelist-reason'        => '改?原因:',
	'globalblocking-whitelist-status'        => '本地状态:',
	'globalblocking-whitelist-statuslabel'   => '停用在{{SITENAME}}上的全域封锁',
	'globalblocking-whitelist-submit'        => '更改本地状态',
	'globalblocking-whitelist-whitelisted'   => "您已经成功地在{{SITENAME}}上的IP地址 '''$1''' 中停用了全域封锁 #$2。",
	'globalblocking-whitelist-dewhitelisted' => "您已经成功地在{{SITENAME}}上的IP地址 '''$1''' 中再次启用了全域封锁 #$2。",
	'globalblocking-whitelist-successsub'    => '本地状态已经成功地更改?',
	'globalblocking-blocked'                 => "您的IP地址已经由'''\$1''' (''\$2'') 在所有的Wikimedia wiki 中全部封锁。
而理由是 ''\"\$3\"''。该封锁将会在''\$4''到期。",
	'globalblocking-logpage'                 => '全域封锁日志',
	'globalblocking-block-logentry'          => '全域封锁了[[$1]]于 $2 ($3) 到期',
	'globalblocking-unblock-logentry'        => '移除了[[$1]]的全域封锁',
	'globalblocking-whitelist-logentry'      => '停用了[[$1]]于本地的全域封锁',
	'globalblocking-dewhitelist-logentry'    => '再次启用[[$1]]于本地的全域封锁',
	'globalblocklist'                        => '全域封锁IP地址名单',
	'globalblock'                            => '全域封锁一个IP地址',
	'right-globalblock'                      => '弄一个全域封锁',
	'right-globalunblock'                    => '移除全域封锁',
	'right-globalblock-whitelist'            => '在本地停用全域封锁',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Shinjiman
 */
$messages['zh-hant'] = array(
	'globalblocking-desc'                    => '[[Special:GlobalBlock|容許]]IP地址可以[[Special:GlobalBlockList|在多個wiki中封鎖]]',
	'globalblocking-block'                   => '全域封鎖一個IP地址',
	'globalblocking-block-intro'             => '您可以用這個頁面去封鎖全部wiki中的一個IP地址。',
	'globalblocking-block-reason'            => '封鎖的理由:',
	'globalblocking-block-expiry'            => '封鎖到期:',
	'globalblocking-block-expiry-other'      => '其它的到期時間',
	'globalblocking-block-expiry-otherfield' => '其它時間:',
	'globalblocking-block-legend'            => '全域封鎖一位用戶',
	'globalblocking-block-options'           => '選項',
	'globalblocking-block-errors'            => '該封鎖不唔成功，因為:
$1',
	'globalblocking-block-ipinvalid'         => '您所輸入的IP地址 ($1) 是無效的。
請留意的是您不可以輸入一個用戶名！',
	'globalblocking-block-expiryinvalid'     => '您所輸入的到期 ($1) 是無效的。',
	'globalblocking-block-submit'            => '全域封鎖這個IP地址',
	'globalblocking-block-success'           => '該IP地址 $1 已經在所有Wikimedia計劃中成功地封鎖。
您亦都可以參看[[Special:Globalblocklist|全域封鎖名單]]。',
	'globalblocking-block-successsub'        => '全域封鎖成功',
	'globalblocking-block-alreadyblocked'    => '該IP地址 $1 已經全域封鎖中。您可以在[[Special:Globalblocklist|全域封鎖名單]]中參看現時的封鎖。',
	'globalblocking-list'                    => '全域封鎖IP地址名單',
	'globalblocking-search-legend'           => '搜尋一個全域封鎖',
	'globalblocking-search-ip'               => 'IP地址:',
	'globalblocking-search-submit'           => '搜尋封鎖',
	'globalblocking-list-ipinvalid'          => '您所搜尋的IP地址 ($1) 是無效的。
請輸入一個有效的IP地址。',
	'globalblocking-search-errors'           => '您先前搜尋過的項目不成功，因為:
$1',
	'globalblocking-list-blockitem'          => "$1: '''$2''' (''$3'') 全域封鎖了 '''[[Special:Contributions/$4|$4]]''' ''($5)''",
	'globalblocking-list-expiry'             => '於$1到期',
	'globalblocking-list-anononly'           => '只限匿名',
	'globalblocking-list-unblock'            => '解除封鎖',
	'globalblocking-list-whitelisted'        => '由$1於本地封鎖: $2',
	'globalblocking-list-whitelist'          => '本地狀態',
	'globalblocking-unblock-ipinvalid'       => '您所輸入的IP地址 ($1) 是無效的。
請留意的是您不可以輸入一個用戶名！',
	'globalblocking-unblock-legend'          => '移除一個全域封鎖',
	'globalblocking-unblock-submit'          => '移除全域封鎖',
	'globalblocking-unblock-reason'          => '原因:',
	'globalblocking-unblock-notblocked'      => '您所輸入的IP地址 ($1) 沒有被全域封鎖。',
	'globalblocking-unblock-unblocked'       => "您己經成功地移除了在IP地址 '''$1''' 上的全域封鎖 #$2 ",
	'globalblocking-unblock-errors'          => '您不可以移除該IP地址的全域封鎖，因為:
$1',
	'globalblocking-unblock-successsub'      => '全域封鎖已經成功地移除',
	'globalblocking-whitelist-subtitle'      => '編輯一個全域封鎖的本地狀態',
	'globalblocking-whitelist-legend'        => '更改本地狀態',
	'globalblocking-whitelist-reason'        => '改嘅原因:',
	'globalblocking-whitelist-status'        => '本地狀態:',
	'globalblocking-whitelist-statuslabel'   => '停用在{{SITENAME}}上的全域封鎖',
	'globalblocking-whitelist-submit'        => '更改本地狀態',
	'globalblocking-whitelist-whitelisted'   => "您已經成功地在{{SITENAME}}上的IP地址 '''$1''' 中停用了全域封鎖 #$2。",
	'globalblocking-whitelist-dewhitelisted' => "您已經成功地在{{SITENAME}}上的IP地址 '''$1''' 中再次啟用了全域封鎖 #$2。",
	'globalblocking-whitelist-successsub'    => '本地狀態已經成功地更改咗',
	'globalblocking-blocked'                 => "您的IP地址已經由'''\$1''' (''\$2'') 在所有的Wikimedia wiki 中全部封鎖。
而理由是 ''\"\$3\"''。該封鎖將會在''\$4''到期。",
	'globalblocking-logpage'                 => '全域封鎖日誌',
	'globalblocking-block-logentry'          => '全域封鎖了[[$1]]於 $2 ($3) 到期',
	'globalblocking-unblock-logentry'        => '移除了[[$1]]的全域封鎖',
	'globalblocking-whitelist-logentry'      => '停用了[[$1]]於本地的全域封鎖',
	'globalblocking-dewhitelist-logentry'    => '再次啟用[[$1]]於本地的全域封鎖',
	'globalblocklist'                        => '全域封鎖IP地址名單',
	'globalblock'                            => '全域封鎖一個IP地址',
	'right-globalblock'                      => '弄一個全域封鎖',
	'right-globalunblock'                    => '移除全域封鎖',
	'right-globalblock-whitelist'            => '在本地停用全域封鎖',
);

