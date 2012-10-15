<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation, version 2
of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
*/

/**
 * A file for the WhiteList extension
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Paul Grinberg <gri6507@yahoo.com>
 * @author Mike Sullivan <ms-mediawiki@umich.edu>
 * @copyright Copyright © 2008, Paul Grinberg, Mike Sullivan
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$messages = array();

/** English
 * @author Paul Grinberg <gri6507@yahoo.com>
 * @author Mike Sullivan <ms-mediawiki@umich.edu>
 * @author Siebrand Mazeland
 */
$messages['en'] = array(
	'whitelist-desc' => 'Edit the access permissions of restricted users',
	'whitelistedit' => 'White list access editor',
	'whitelist' => 'White list pages',
	'mywhitelistpages' => 'My pages',
	'whitelistfor' => "<center>Current information for <b>$1</b></center>",
	'whitelisttablemodify' => 'Modify',
	'whitelisttablemodifyall' => 'All',
	'whitelisttablemodifynone' => 'None',
	'whitelisttablepage' => 'Wiki page',
	'whitelisttabletype' => 'Access type',
	'whitelisttableexpires' => 'Expires on',
	'whitelisttablemodby' => 'Last modified by',
	'whitelisttablemodon' => 'Last modified on',
	'whitelisttableedit' => 'Edit',
	'whitelisttableview' => 'View',
	'whitelisttablenewdate' => 'New date:',
	'whitelisttablechangedate' => 'Change expiry date',
	'whitelisttablesetedit' => 'Set to edit',
	'whitelisttablesetview' => 'Set to view',
	'whitelisttableremove' => 'Remove',
	'whitelistnewpagesfor' => "Add new pages to <b>$1's</b> white list<br />
Use either * or % as wildcard character",
	'whitelistnewtabledate' => 'Expiry date:',
	'whitelistnewtableedit' => 'Set to edit',
	'whitelistnewtableview' => 'Set to view',
	'whitelistnowhitelistedusers' => 'There are no users in the group "{{MediaWiki:Group-restricted}}".
You have to [[Special:UserRights|add users to the group]] before you can add pages to a user\'s white list.',
	'whitelistnewtableprocess' => 'Process',
	'whitelistnewtablereview' => 'Review',
	'whitelistselectrestricted' => '== Select restricted user name ==',
	'whitelistpagelist' => "{{SITENAME}} pages for $1",
	'whitelistnocalendar' => "<font color='red' size=3>It looks like [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], a prerequisite for this extension, was not installed properly!</font>",
	'whitelistoverview' => "== Overview of changes for $1 ==",
	'whitelistoverviewcd' => "* Changing date to '''$1''' for [[:$2|$2]]",
	'whitelistoverviewsa' => "* Setting access to '''$1''' for [[:$2|$2]]",
	'whitelistoverviewrm' => "* Removing access to [[:$1|$1]]",
	'whitelistoverviewna' => "* Adding [[:$1|$1]] to whitelist with access '''$2''' and '''$3''' expiry date",
	'whitelistrequest' => "Request access to more pages",
	'whitelistrequestmsg' => "$1 has requested access to the following {{PLURAL:$3|page|pages}}:

$2",
	'whitelistrequestconf' => "Request for new pages was sent to $1",
	'whitelistnonrestricted' => "User '''$1''' is not a restricted user.
This page is only applicable to restricted users",
	'whitelistnever' => 'never',
	'whitelistnummatches' => ' - {{PLURAL:$1|one match|$1 matches}}',

	# Right descriptions
	'right-editwhitelist' => 'Modify the white list for existing users',
	'right-restricttowhitelist' => 'Edit and view pages on the white list only',

	# Action descriptions
	'action-editwhitelist' => 'modify the white list for existing users',
	'action-restricttowhitelist' => 'edit and view pages on the whitelist only',

	# User groups and members
	'group-restricted' => 'Restricted users',
	'group-restricted-member' => 'Restricted user',
	'group-manager' => 'Managers',
	'group-manager-member' => 'Manager',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'whitelist-desc' => '{{desc}}',
	'mywhitelistpages' => '{{Identical|My pages}}',
	'whitelisttablemodifyall' => '{{Identical|All}}',
	'whitelisttablemodifynone' => '{{Identical|None}}',
	'whitelisttableexpires' => '{{Identical|Expires on}}
Used as a column header for a table',
	'whitelisttablemodby' => 'Used as a column header for a table',
	'whitelisttablemodon' => 'Used as a column header for a table',
	'whitelisttableedit' => '{{Identical|Edit}}',
	'whitelisttablesetedit' => '{{Identical|Set to edit}}',
	'whitelisttablesetview' => '{{Identical|Set to view}}',
	'whitelisttableremove' => '{{Identical|Remove}}',
	'whitelistnewtableedit' => '{{Identical|Set to edit}}',
	'whitelistnewtableview' => '{{Identical|Set to view}}',
	'whitelistnewtableprocess' => '{{Identical|Process}}',
	'whitelistnewtablereview' => '{{Identical|Review}}',
	'whitelistoverviewna' => '* $1 is a page name
* $2 is {{msg-mw|whitelisttablesetedit}} (when set edit) or {{msg-mw|whitelisttablesetview}} (other cases)
* $3 is {{msg-mw|whitelistnever}} (when never expires) or a time stamp (when expires)',
	'whitelistnever' => '{{Identical|Never}}',
	'right-editwhitelist' => '{{Doc-right|editwhitelist}}',
	'right-restricttowhitelist' => '{{Doc-right|restricttowhitelist}}',
	'action-editwhitelist' => '{{Doc-action|editwhitelist}}',
	'action-restricttowhitelist' => '{{Doc-action|restricttowhitelist}}',
	'group-restricted' => 'Name of the group',
	'group-restricted-member' => 'Name of a member of the group',
	'group-manager' => 'Name of the group',
	'group-manager-member' => 'Name of a member of the group',
);

/** Faeag Rotuma (Faeag Rotuma)
 * @author Jose77
 */
$messages['rtm'] = array(
	'whitelisttableedit' => "A'tū'ạki",
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'whitelisttableedit' => 'Fakahakohako',
);

/** Laz (Laz)
 * @author Bombola
 */
$messages['lzz'] = array(
	'mywhitelistpages' => 'Çkimi sayfape',
	'whitelisttableremove' => 'Jili',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'mywhitelistpages' => 'My bladsye',
	'whitelisttablemodify' => 'Wysig',
	'whitelisttablemodifyall' => 'Alle',
	'whitelisttablemodifynone' => 'Geen',
	'whitelisttableexpires' => 'Verval op',
	'whitelisttableedit' => 'Wysig',
	'whitelisttableview' => 'Wys',
	'whitelisttablenewdate' => 'Nuwe datum:',
	'whitelisttablechangedate' => 'Wysig vervaldatum',
	'whitelisttableremove' => 'Skrap',
	'whitelistnewtabledate' => 'Vervaldatum:',
	'whitelistnewtableprocess' => 'Verwerk',
	'whitelistnewtablereview' => 'Kontroleer',
	'whitelistrequest' => 'Versoek om toegang tot meer bladsye',
	'whitelistrequestconf' => 'Die versoek vir nuwe bladsye is aan $1 gestuur',
	'whitelistnever' => 'nooit',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|resultaat|resultate}}',
	'group-restricted' => 'Beperk gebruikers',
	'group-manager' => 'Bestuurders',
	'group-manager-member' => 'Bestuurder',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'whitelisttablemodifyall' => 'ሁሉ',
	'whitelisttableedit' => 'አርም',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'whitelisttableedit' => 'Editar',
	'whitelisttablenewdate' => 'Nueba calendata:',
	'whitelisttablechangedate' => 'Cambiar a calendata de zircunduzión',
	'whitelistnewtabledate' => 'Data de zircunduzión:',
	'whitelistoverviewna' => "* Adibindo [[:$1|$1]] t'a lista blanca con azeso '''$2''' y data de zircunduzión '''$3'''",
);

/** Arabic (العربية)
 * @author Alnokta
 * @author Meno25
 * @author OsamaK
 * @author Ouda
 */
$messages['ar'] = array(
	'whitelist-desc' => 'عدل سماحات الوصول للمستخدمين المحددين',
	'whitelistedit' => 'محرر وصول القائمة البيضاء',
	'whitelist' => 'صفحات القائمة البيضاء',
	'mywhitelistpages' => 'صفحاتي',
	'whitelistfor' => '<center>المعلومات الحالية ل<b>$1</b></center>',
	'whitelisttablemodify' => 'تعديل',
	'whitelisttablemodifyall' => 'الكل',
	'whitelisttablemodifynone' => 'لا شيء',
	'whitelisttablepage' => 'صفحة ويكي',
	'whitelisttabletype' => 'نوع الدخول',
	'whitelisttableexpires' => 'ينتهي في',
	'whitelisttablemodby' => 'آخر تعديل بواسطة',
	'whitelisttablemodon' => 'آخر تعديل في',
	'whitelisttableedit' => 'عدل',
	'whitelisttableview' => 'عرض',
	'whitelisttablenewdate' => 'تاريخ جديد:',
	'whitelisttablechangedate' => 'تغيير تاريخ الانتهاء',
	'whitelisttablesetedit' => 'ضبط للتعديل',
	'whitelisttablesetview' => 'ضبط للعرض',
	'whitelisttableremove' => 'إزالة',
	'whitelistnewpagesfor' => 'أضف صفحات جديدة إلى <b>$1</b القائمة البيضاء ل<br />
استخدم إما * أو % كحرف خاص',
	'whitelistnewtabledate' => 'تاريخ الانتهاء:',
	'whitelistnewtableedit' => 'ضبط للتعديل',
	'whitelistnewtableview' => 'ضبط للعرض',
	'whitelistnowhitelistedusers' => 'لا يوجد مستخدمون في المجموعة "{{ميدياويكي:مجموعة-محظورة}}" 

  [[Special:UserRights|  يجب أن تضيف مستخدمين إلى هذه المجموعة]] قبل ان تستطيع إضافة صفحات إلى قائمة المستخدم البيضاء',
	'whitelistnewtableprocess' => 'عملية',
	'whitelistnewtablereview' => 'مراجعة',
	'whitelistselectrestricted' => '== اختر اسم المستخدم المحدد ==',
	'whitelistpagelist' => 'صفحات {{SITENAME}} ل$1',
	'whitelistnocalendar' => "<font color='red' size=3>يبدو أن [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics]، متطلب لهذه الامتداد، لم يتم تركيبه بشكل صحيح!</font>",
	'whitelistoverview' => '== مراجعة التغييرات ل$1 ==',
	'whitelistoverviewcd' => "* تغيير التاريخ إلى '''$1''' ل[[:$2|$2]]",
	'whitelistoverviewsa' => "* ضبط الدخول إلى '''$1''' ل[[:$2|$2]]",
	'whitelistoverviewrm' => '* إزالة الوصول إلى [[:$1|$1]]',
	'whitelistoverviewna' => "* إضافة [[:$1|$1]] إلى القائمة البيضاء بوصول '''$2''' و '''$3''' تاريخ انتهاء",
	'whitelistrequest' => 'طلب السماح لمزيد من الصفحات',
	'whitelistrequestmsg' => '$1 طلب الوصول إلى {{PLURAL:$3||الصفحة التالية|الصفحتين التاليتين|الصفحات التالية}}:

$2',
	'whitelistrequestconf' => 'الطلب للصفحات الجديدة تم إرساله إلى $1',
	'whitelistnonrestricted' => "المستخدم '''$1''' ليس مستخدما محددا.
هذه الصفحة مطبقة فقط على المستخدمين المحددين",
	'whitelistnever' => 'أبدا',
	'whitelistnummatches' => ' - {{PLURAL:$1||مطابقة واحدة|مطابقتان|$1 مطابقات|$1 مطابقة}}',
	'right-editwhitelist' => 'عدل القائمة البيضاء للمستخدمون الموجودون',
	'right-restricttowhitelist' => 'تعديل وعرض الصفحات على القائمة البيضاء فقط',
	'action-editwhitelist' => 'عدل القائمة البيضاء لمستخدمين موجودين',
	'action-restricttowhitelist' => 'عدل وأعرض الصفحات على القائمة البيضاء فقط',
	'group-restricted' => 'مستخدمون محظورون',
	'group-restricted-member' => 'مستخدم محظور',
	'group-manager' => 'مديرون',
	'group-manager-member' => 'مدير',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'mywhitelistpages' => 'ܦܐܬܬ̈ܐ ܕܝܠܝ',
	'whitelisttablemodifyall' => 'ܟܠ',
	'whitelisttablemodifynone' => 'ܠܐ ܡܕܡ',
	'whitelisttablepage' => 'ܦܐܬܐ ܕܘܝܩܝ',
	'whitelisttableedit' => 'ܫܚܠܦ',
	'whitelisttableview' => 'ܚܙܝ',
	'whitelisttableremove' => 'ܠܚܝ',
	'whitelistnewtableprocess' => 'ܥܡܠܝܬܐ',
	'whitelistnewtablereview' => 'ܬܢܝܬܐ',
	'whitelistpagelist' => '{{SITENAME}} ܦܐܬܬ̈ܐ ܠ$1',
	'whitelistnever' => 'ܠܐ ܡܡܬܘܡ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'whitelist-desc' => 'عدل سماحات الوصول لليوزرز المحددين',
	'whitelistedit' => 'محرر وصول القائمة البيضاء',
	'whitelist' => 'صفحات القائمة البيضاء',
	'mywhitelistpages' => 'صفحاتي',
	'whitelistfor' => '<center>المعلومات الحالية ل<b>$1</b></center>',
	'whitelisttablemodify' => 'تعديل',
	'whitelisttablemodifyall' => 'الكل',
	'whitelisttablemodifynone' => 'لا شيء',
	'whitelisttablepage' => 'صفحة ويكي',
	'whitelisttabletype' => 'نوع الدخول',
	'whitelisttableexpires' => 'ينتهى في',
	'whitelisttablemodby' => 'آخر تعديل بواسطة',
	'whitelisttablemodon' => 'آخر تعديل في',
	'whitelisttableedit' => 'عدل',
	'whitelisttableview' => 'عرض',
	'whitelisttablenewdate' => 'تاريخ جديد:',
	'whitelisttablechangedate' => 'تغيير تاريخ الانتهاء',
	'whitelisttablesetedit' => 'ضبط للتعديل',
	'whitelisttablesetview' => 'ضبط للعرض',
	'whitelisttableremove' => 'إزالة',
	'whitelistnewpagesfor' => 'أضف صفحات جديدة إلى <b>$1</b القائمة البيضاء ل<br />
استخدم إما * أو % كحرف خاص',
	'whitelistnewtabledate' => 'تاريخ الانتهاء:',
	'whitelistnewtableedit' => 'ضبط للتعديل',
	'whitelistnewtableview' => 'ضبط للعرض',
	'whitelistnowhitelistedusers' => 'مافيش يوزرز فى الجروب دى "{{MediaWiki:Group-restricted}}".
لازم [[Special:UserRights|تضيف يوزرز للجروب]] قبل ما تقدر تضيف صفحات لـ الليستة البيضا بتاعة اى يوزر.',
	'whitelistnewtableprocess' => 'عملية',
	'whitelistnewtablereview' => 'مراجعة',
	'whitelistselectrestricted' => '== اختار اسم اليوزر المتحدد ==',
	'whitelistpagelist' => 'صفحات {{SITENAME}} ل$1',
	'whitelistnocalendar' => "<font color='red' size=3> الظاهر ان[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics]، المطلوب للامتداد دا،ما اتستبش صح!</font>",
	'whitelistoverview' => '== مراجعة التغييرات ل$1 ==',
	'whitelistoverviewcd' => "* تغيير التاريخ إلى '''$1''' ل[[:$2|$2]]",
	'whitelistoverviewsa' => "* ضبط الدخول إلى '''$1''' ل[[:$2|$2]]",
	'whitelistoverviewrm' => '* إزالة الوصول إلى [[:$1|$1]]',
	'whitelistoverviewna' => "* إضافة [[:$1|$1]] إلى القائمة البيضاء بوصول '''$2''' و '''$3''' تاريخ انتهاء",
	'whitelistrequest' => 'طلب السماح لمزيد من الصفحات',
	'whitelistrequestmsg' => '$1 قدم طلب للوصول {{PLURAL:$3|للصفحة|للصفحات}} دي:

$2',
	'whitelistrequestconf' => 'الطلب للصفحات الجديدة تم إرساله إلى $1',
	'whitelistnonrestricted' => "اليوزر '''$1''' مش يوزر محدد.
هذه الصفحة متطبقة بس على اليوزرز المحددين",
	'whitelistnever' => 'أبدا',
	'whitelistnummatches' => ' - {{PLURAL:$1|مطابقة واحده|$1 مطابقة}}',
	'right-editwhitelist' => 'عدل الليستة البيضا بتاعة اليوزرز الموجودين',
	'right-restricttowhitelist' => 'عدل و شوف الصفحات اللى فى الليستة البيضا بس.',
	'action-editwhitelist' => 'عدل الليستة البيضا بتاعة اليوزرز الموجودين',
	'action-restricttowhitelist' => 'عدل و شوف الصفحات اللى فى الليستة البيضا بس',
	'group-restricted' => 'اليوزرز المتحددين',
	'group-restricted-member' => 'يوزر متحدد',
	'group-manager' => 'مديرين',
	'group-manager-member' => 'مدير',
);

/** Aymara (Aymar aru)
 * @author Erebedhel
 */
$messages['ay'] = array(
	'mywhitelistpages' => 'Uñstawinakaja',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Александр Сигачёв
 */
$messages['be-tarask'] = array(
	'whitelist-desc' => 'Рэдагаваць правы доступу ўдзельнікаў з абмежаваньнямі',
	'whitelistedit' => 'Рэдактар сьпісу агульнадаступных старонак',
	'whitelist' => 'Агульнадаступныя старонкі',
	'mywhitelistpages' => 'Мае старонкі',
	'whitelistfor' => '<center>Цяперашняя інфармацыя для <b>$1</b></center>',
	'whitelisttablemodify' => 'Зьмяніць',
	'whitelisttablemodifyall' => 'Усе',
	'whitelisttablemodifynone' => 'Нічога',
	'whitelisttablepage' => 'Старонка вікі',
	'whitelisttabletype' => 'Тып доступу',
	'whitelisttableexpires' => 'Канчаецца',
	'whitelisttablemodby' => 'Апошні раз зьмененая',
	'whitelisttablemodon' => 'Дата апошняй зьмены',
	'whitelisttableedit' => 'Рэдагаваць',
	'whitelisttableview' => 'Прагляд',
	'whitelisttablenewdate' => 'Новая дата:',
	'whitelisttablechangedate' => 'Зьмяніць тэрмін дзеяньня',
	'whitelisttablesetedit' => 'Пазначыць для рэдагаваньня',
	'whitelisttablesetview' => 'Пазначыць для прагляду',
	'whitelisttableremove' => 'Выдаліць',
	'whitelistnewpagesfor' => 'Дадаць новую старонку да сьпісу агульнадаступных старонак <b>$1</b><br />
Карыстайцеся * ці % для стварэньня групавых сымбаляў',
	'whitelistnewtabledate' => 'Дата сканчэньня:',
	'whitelistnewtableedit' => 'Пазначыць для рэдагаваньня',
	'whitelistnewtableview' => 'Пазначыць для прагляду',
	'whitelistnowhitelistedusers' => 'У групе «{{MediaWiki:Group-restricted}}» няма ўдзельнікаў.
Вам неабходна [[Special:UserRights|дадаць удзельнікаў у групу]] перад тым, як Вам можна будзе дадаваць старонкі ў белы сьпіс удзельнікаў.',
	'whitelistnewtableprocess' => 'Пераўтварэньне',
	'whitelistnewtablereview' => 'Праглядзець',
	'whitelistselectrestricted' => '== Выберыце імя ўдзельніка ==',
	'whitelistpagelist' => 'Старонкі {{SITENAME}} для $1',
	'whitelistnocalendar' => "<font color='red' size=3>Верагодна пашырэньне [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], якое патрабуецца для працы гэтага пашырэньня, не было ўсталявана адпаведным чынам!</font>",
	'whitelistoverview' => '== Агляд зьменаў для $1 ==',
	'whitelistoverviewcd' => "* Зьмена даты на '''$1''' для [[:$2|$2]]",
	'whitelistoverviewsa' => "* Пазначэньне доступу да '''$1''' для [[:$2|$2]]",
	'whitelistoverviewrm' => '* Зьняцьце доступу да [[:$1|$1]]',
	'whitelistoverviewna' => "* Даданьне [[:$1|$1]] у белы сьпіс з доступам '''$2''' і датай сканчэньня '''$3'''",
	'whitelistrequest' => 'Запыт доступу для большай колькасьці старонак',
	'whitelistrequestmsg' => 'Удзельнік $1 запытаў доступ да {{PLURAL:$3|наступнай старонкі|наступных старонак}}:

$2',
	'whitelistrequestconf' => 'Запыт па новых старонках быў дасланы да $1',
	'whitelistnonrestricted' => "Удзельнік '''$1''' ня мае абмежаваньняў.
Гэтая старонка прызначаная толькі для ўдзельнікаў з абмежаваньнямі",
	'whitelistnever' => 'ніколі',
	'whitelistnummatches' => '  - $1 {{PLURAL:$1|супадзеньне|супадзеньні|супадзеньняў}}',
	'right-editwhitelist' => 'Зьмяняць белы сьпіс для існуючых удзельнікаў',
	'right-restricttowhitelist' => 'Рэдагаваць і праглядаць толькі старонкі зь белага сьпісу',
	'action-editwhitelist' => 'зьмяненьне белага сьпісу для існуючых удзельнікаў',
	'action-restricttowhitelist' => 'рэдагаваньне і прагляд толькі старонак зь белага сьпісу',
	'group-restricted' => 'Удзельнікі, абмежаваныя ў правах',
	'group-restricted-member' => 'удзельнік, абмежаваны ў правах',
	'group-manager' => 'Кіраўнікі',
	'group-manager-member' => 'кіраўнік',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'mywhitelistpages' => 'Моите страници',
	'whitelistfor' => '<center>Текуща информация за <b>$1</b></center>',
	'whitelisttablemodify' => 'Промяна',
	'whitelisttablemodifyall' => 'Всички',
	'whitelisttablemodifynone' => 'Няма',
	'whitelisttablepage' => 'Уики страница',
	'whitelisttabletype' => 'Вид достъп',
	'whitelisttableexpires' => 'Изтича на',
	'whitelisttablemodby' => 'Последна промяна от',
	'whitelisttablemodon' => 'Последна промяна на',
	'whitelisttableedit' => 'Редактиране',
	'whitelisttableview' => 'Преглед',
	'whitelisttablenewdate' => 'Нова дата:',
	'whitelisttablechangedate' => 'Промяна срока на валидност',
	'whitelisttableremove' => 'Премахване',
	'whitelistnewtabledate' => 'Дата на изтичане:',
	'whitelistpagelist' => 'Страници за $1 в {{SITENAME}}',
	'whitelistnocalendar' => "<font color='red' size=3>Изглежда разширението [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], което е необходимо, не е инсталирано както трябва!</font>",
	'whitelistoverviewcd' => "* Промяна на датата за [[:$2|$2]] на '''$1'''",
	'whitelistoverviewrm' => '* Премахване на достъпа до [[:$1|$1]]',
	'whitelistrequest' => 'Поискване на достъп до още страници',
	'whitelistrequestmsg' => '$1 пожела достъп до {{PLURAL:$3|следната страница|следните страници}}:

$2',
	'whitelistrequestconf' => 'Заявка за нови страници беше изпратена на $1',
	'whitelistnever' => 'никога',
	'whitelistnummatches' => ' - {{PLURAL:$1|едно съвпадение|$1 съвпадения}}',
	'group-restricted' => 'Ограничени потребители',
	'group-restricted-member' => 'Ограничен потребител',
	'group-manager' => 'Управители',
	'group-manager-member' => 'Управител',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'mywhitelistpages' => 'আমার পাতাসমূহ',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'whitelist-desc' => 'Kemmañ a ra aotreoù moned an implijerien ganto gwirioù bevennet',
	'whitelistedit' => 'Aozer roll gwenn ar moned',
	'whitelist' => 'Pajennoù rolloù gwenn',
	'mywhitelistpages' => 'Ma fajennoù',
	'whitelistfor' => '<center>Titouroù hegerz evit <b>$1</b></center>',
	'whitelisttablemodify' => 'Kemmañ',
	'whitelisttablemodifyall' => 'Pep tra',
	'whitelisttablemodifynone' => 'Hini ebet',
	'whitelisttablepage' => 'Pajenn wiki',
	'whitelisttabletype' => 'Mod moned',
	'whitelisttableexpires' => "Mont a ra d'e dermen d'an",
	'whitelisttablemodby' => 'Kemmet da ziwezhañ gant',
	'whitelisttablemodon' => "Kemmet da ziwezhañ d'an",
	'whitelisttableedit' => 'Kemmañ',
	'whitelisttableview' => 'Gwelet',
	'whitelisttablenewdate' => 'Deiziad nevez :',
	'whitelisttablechangedate' => 'Kemmañ an deiziad termen',
	'whitelisttablesetedit' => 'Gweredekaat kemmoù',
	'whitelisttablesetview' => 'Gweredekaat ar gweled',
	'whitelisttableremove' => 'Tennañ',
	'whitelistnewpagesfor' => 'Ouzhpennañ a ra pajennoù nevez da roll gwenn <b>$1</b><br />
Implijout an arouezennoù * pe %',
	'whitelistnewtabledate' => 'Deiziad termen :',
	'whitelistnewtableedit' => "Gweredekaat ar c'hemmañ",
	'whitelistnewtableview' => 'Gweredekaat an diskwel',
	'whitelistnowhitelistedusers' => "N'eus implijer ebet er strollad \"{{MediaWiki:Group-restricted}}\".
Ret eo deoc'h [[Special:UserRights|ouzhpennañ an implijer d'ar strollad]] a-raok gellout ouzhpennañ pajennoù da roll gwenn un implijer bennak.",
	'whitelistnewtableprocess' => 'Plediñ',
	'whitelistnewtablereview' => 'Adlenn',
	'whitelistselectrestricted' => '== Diuzañ anv un implijer bevennet e wirioù ==',
	'whitelistpagelist' => 'Pajennoù {{SITENAME}} evit $1',
	'whitelistnocalendar' => "<font color='red' size=3>Evit doare, n'eo ket bet staliet ent reizh ar vodulenn [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], anezhi un astenn rekis a-raok ar staliañ!</font>",
	'whitelistoverview' => "== Sell hollek war ar c'hemmoù evit $1 ==",
	'whitelistoverviewcd' => "* O kemmañ deiziad '''$1''' evit [[:$2|$2]]",
	'whitelistoverviewsa' => "* O kefluniañ ar moned da '''$1''' evit [[:$2|$2]]",
	'whitelistoverviewrm' => '* O lemel ar moned da [[:$1|$1]]',
	'whitelistoverviewna' => "* Oc'h ouzhpennañ [[:$1|$1]] d'ar roll gwenn gant gwirioù '''$2''' ha '''$3''' da zeiziad termen",
	'whitelistrequest' => "Goulenn ur gwir moned da vuioc'h a bajennoù",
	'whitelistrequestmsg' => "Goulennet ez eus bet gant $1 ur gwir moned {{PLURAL:$3|d'ar bajenn da-heul|d'ar pajennoù da-heul}} :

$2",
	'whitelistrequestconf' => 'Kaset ez eus bet ur goulenn moned evit pajennoù nevez da $1',
	'whitelistnonrestricted' => "N'eo ket bevennet gwirioù '''$1'''.
Ar bajenn-mañ ne dalvez nemet evit an implijerien zo bevennet o gwirioù.",
	'whitelistnever' => 'morse',
	'whitelistnummatches' => "  - {{PLURAL:$1|ur c'henglot|$1 kenglot}}",
	'right-editwhitelist' => 'Kemmañ ar roll gwenn evit an implijerien zo anezho',
	'right-restricttowhitelist' => 'Kemmañ ha gwelet ar pajennoù zo war ar roll gwenn hepken',
	'action-editwhitelist' => 'Kemmañ ar roll gwenn evit an implijerien zo anezho.',
	'action-restricttowhitelist' => 'kemmañ ha gwelet ar pajennoù zo war ar roll gwenn hepken',
	'group-restricted' => 'Implijerien bevennet',
	'group-restricted-member' => 'Implijer bevennet',
	'group-manager' => 'Merourien',
	'group-manager-member' => 'Merour',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Smooth O
 */
$messages['bs'] = array(
	'whitelist-desc' => 'Uređivanje dopuštenja pristupa za ograničene korisnike',
	'whitelistedit' => 'Uređivač pristupa dopuštenom spisku',
	'whitelist' => 'Spisak bijelih stranica',
	'mywhitelistpages' => 'Moje stranice',
	'whitelistfor' => '<center>Trenutne informacije za <b>$1</b></center>',
	'whitelisttablemodify' => 'Izmijeni',
	'whitelisttablemodifyall' => 'Sve',
	'whitelisttablemodifynone' => 'Ništa',
	'whitelisttablepage' => 'Wiki stranica',
	'whitelisttabletype' => 'Tip pristupa',
	'whitelisttableexpires' => 'Ističe dana',
	'whitelisttablemodby' => 'Zadnji put izmijenjeno od strane',
	'whitelisttablemodon' => 'Zadnji put promijenjeno dana',
	'whitelisttableedit' => 'Uredi',
	'whitelisttableview' => 'Pregled',
	'whitelisttablenewdate' => 'Novi datum:',
	'whitelisttablechangedate' => 'Promijeni datum isteka',
	'whitelisttablesetedit' => 'Postavi za uređivanje',
	'whitelisttablesetview' => 'Postavi za pregled',
	'whitelisttableremove' => 'Ukloni',
	'whitelistnewpagesfor' => 'Dodaj nove stranice na dopušteni spisak korisnika <b>$1</b><br />
Koristite * ili % kao zamjenski znak',
	'whitelistnewtabledate' => 'Datum isteka:',
	'whitelistnewtableedit' => 'Postavi za uređivanje',
	'whitelistnewtableview' => 'Postavi za pregled',
	'whitelistnowhitelistedusers' => 'Nema korisnika u grupi "{{MediaWiki:Group-restricted}}".
Morate da [[Special:UserRights|dodate korisnike u grupu]] prije nego što mognete dodavati stranice na dopušteni spisak korisnika.',
	'whitelistnewtableprocess' => 'Proces',
	'whitelistnewtablereview' => 'Pregled',
	'whitelistselectrestricted' => '== Odaberi ograničeno korisničko ime ==',
	'whitelistpagelist' => '{{SITENAME}} stranice za $1',
	'whitelistnocalendar' => "<font color='red' size=3>Izgleda da [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Ekstenzija:Statisike korištenja], koja je neophodna za ovo proširenje, nije pravilno instalisana!</font>",
	'whitelistoverview' => '== Pregled promjena za $1 ==',
	'whitelistoverviewcd' => "* Mijenjam datum na '''$1''' za [[:$2|$2]]",
	'whitelistoverviewsa' => "* Postavljanje pristupa na '''$1''' za [[:$2|$2]]",
	'whitelistoverviewrm' => '* Uklanjam pristup na [[:$1|$1]]',
	'whitelistoverviewna' => "* Dodaje [[:$1|$1]] na dozvoljeni spisak sa pristupom '''$2''' i '''$3''' datumom isteka",
	'whitelistrequest' => 'Traži pristup za više stranica',
	'whitelistrequestmsg' => '$1 je zahtijevao pristup {{PLURAL:$3|slijedećoj stranici|slijedećim stranicama}}:

$2',
	'whitelistrequestconf' => 'Zahtjev za nove stranice je poslan na $1',
	'whitelistnonrestricted' => "Korisnik '''$1''' nije ograničeni korisnik.
Ova stranica se može primijeniti samo na ograničene korisnike",
	'whitelistnever' => 'nikad',
	'whitelistnummatches' => '- {{PLURAL:$1|$1 pogodak|$1 pogotka|$1 pogodaka}}',
	'right-editwhitelist' => 'Prilagođavanje dopuštenog spiska za postojeće korisnike',
	'right-restricttowhitelist' => 'Uređivanje i pregled stranica samo sa dopuštenog spiska',
	'action-editwhitelist' => 'promijenite dopušteni spisak za postojeće korisnike',
	'action-restricttowhitelist' => 'uredi i pregledaj stranice samo na dopuštenom spisku',
	'group-restricted' => 'Ograničeni korisnici',
	'group-restricted-member' => 'Ograničeni korisnik',
	'group-manager' => 'Upravljači',
	'group-manager-member' => 'Upravljač',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author Loupeter
 * @author SMP
 * @author Solde
 * @author Ssola
 */
$messages['ca'] = array(
	'whitelisttablemodify' => 'Modifica',
	'whitelisttablemodifyall' => 'Tot',
	'whitelisttablemodifynone' => 'Cap',
	'whitelisttablepage' => 'Pàgina wiki',
	'whitelisttableedit' => 'Modifica',
	'whitelisttablenewdate' => 'Nova data:',
	'whitelisttablechangedate' => 'Canviar data de venciment',
	'whitelisttableremove' => 'Elimina',
	'whitelistnewtabledate' => 'Data de venciment:',
	'whitelistoverviewna' => "* Afegint [[:$1|$1]] a la llista blanca amb accés '''$2''' i '''$3''' data de venciment",
	'whitelistnever' => 'mai',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'whitelisttableedit' => 'Tulaika',
);

/** Sorani (Arabic script) (‫کوردی (عەرەبی)‬)
 * @author Marmzok
 * @author رزگار
 */
$messages['ckb-arab'] = array(
	'whitelist-desc' => 'دەستکاری‌کردنی ڕێگەدان بۆ دەست‌پێ‌گەیشتنی بەکارهێنەرانی سنووردار کراو',
	'mywhitelistpages' => 'پەڕەکانی من',
	'whitelisttablemodify' => 'پێداچوونەوە',
	'whitelisttablemodifyall' => 'ھەموو',
	'whitelisttablepage' => 'لاپەڕەی ویکی',
	'whitelisttabletype' => 'جۆری دەست‌پێگەیشتن',
	'whitelisttableexpires' => 'بەسەرهاتنی کات لە',
	'whitelisttablemodby' => 'دوایین پێداچوونەوە لە لایەن',
	'whitelisttablemodon' => 'دوایین پێداچوونەوە لە',
	'whitelisttableedit' => 'دەستکاری',
	'whitelisttableview' => 'پیشان‌دان',
	'whitelisttablenewdate' => 'ڕێکەوتی نوێ:',
	'whitelisttablechangedate' => 'گۆڕانی ڕێکەوتی بەسەرهاتنی کات',
	'whitelisttableremove' => 'لابردن',
	'whitelistnewtabledate' => 'ڕێکەوتی بەسەرهاتنی کات:',
	'whitelistnewtableprocess' => 'پرۆسە',
	'whitelistnewtablereview' => 'پێداچوونەوە',
	'whitelistselectrestricted' => '== دیاری‌کردنی ناوی بەکارهێنەری سنووردارکراو ==',
	'whitelistrequest' => 'داوای دەستپێگەیشتنی لاپەڕەی زیاتر',
	'whitelistrequestconf' => 'داخوازی بۆ لاپەڕە نوێکان بۆ $1 ناردرا',
	'whitelistnever' => 'هیچ‌کات',
	'group-restricted' => 'بەکارهێنەرانی سنووردارکراو',
	'group-restricted-member' => 'بەکارهێنەری سنووردارکراو',
	'group-manager' => 'جێبە‌جێکەران',
	'group-manager-member' => 'جێبەجێکەر',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'whitelist-desc' => 'Upravit oprávnění přístupu uživatelů',
	'whitelistedit' => 'Editor bílé listiny přístupu',
	'whitelist' => 'Dát stránky na bílou listinu',
	'mywhitelistpages' => 'Moje stránky',
	'whitelistfor' => '<center>Aktuální informace pro <b>$1<b></center>',
	'whitelisttablemodify' => 'Změnit',
	'whitelisttablemodifyall' => 'Všechny',
	'whitelisttablemodifynone' => 'Žádné',
	'whitelisttablepage' => 'Wiki stránka',
	'whitelisttabletype' => 'Typ přístupu',
	'whitelisttableexpires' => 'Vyprší',
	'whitelisttablemodby' => 'Naposledy změnil',
	'whitelisttablemodon' => 'Naposledy změněno',
	'whitelisttableedit' => 'Upravit',
	'whitelisttableview' => 'Zobrazit',
	'whitelisttablenewdate' => 'Nové datum:',
	'whitelisttablechangedate' => 'Změnit datum vypršení',
	'whitelisttablesetedit' => 'Nastavit na upravení',
	'whitelisttablesetview' => 'Nastavit na zobrazení',
	'whitelisttableremove' => 'Odstranit',
	'whitelistnewpagesfor' => 'Přidat nové stránky na bílou listinu<b>$1</b><br />
Jako zástupný znak použijte buď * nebo %',
	'whitelistnewtabledate' => 'Datum vypršení:',
	'whitelistnewtableedit' => 'Nastavit na upravení',
	'whitelistnewtableview' => 'Nastavit na zobrazení',
	'whitelistnowhitelistedusers' => 'Ve skupině „{{MediaWiki:Group-restricted}}“ se nenachází žadní uživatelé.
Musíte [[Special:UserRights|do této skupiny přidat uživatel]] předtím, než budete moci přidávat stránky na bílou listinu uživatele.',
	'whitelistnewtableprocess' => 'Zpracovat',
	'whitelistnewtablereview' => 'Zkontrolovat',
	'whitelistselectrestricted' => '== Vyberte jméno uživatele ==',
	'whitelistpagelist' => 'stránky {{GRAMMAR:2sg|{{SITENAME}}}} pro $1',
	'whitelistnocalendar' => "<font color='red' size=3>Zdá sa, že není správně nainstalované rozšíření [http://www.mediawiki.org/wiki/Extension:Usage_Statistics UsageStatistics], které toto rozšíření vyžaduje.</font>",
	'whitelistoverview' => '== Přehled změn $1 ==',
	'whitelistoverviewcd' => "* Změna data [[:$2|$2]] na '''$1'''",
	'whitelistoverviewsa' => "* Nastavení přístupu [[:$2|$2]] na '''$1'''",
	'whitelistoverviewrm' => '* Odstranění přístupu na [[:$1|$1]]',
	'whitelistoverviewna' => "* Přidání přístupu [[:$1|$1]] na bílou listinu s přístupem '''$2''' a vypršením '''$3'''",
	'whitelistrequest' => 'Požádat o přístup k více stránkám',
	'whitelistrequestmsg' => '$1 požádal o přístup k {{PLURAL:$3|následující stránce|následujícím stránkám}}:

$2',
	'whitelistrequestconf' => 'Žádost o nové stránky byla odeslána $1',
	'whitelistnonrestricted' => "Uživatel '''$1''' není omezený uživatel.
Tato stránka se týká jen omezených uživatelů.",
	'whitelistnever' => 'nikdy',
	'whitelistnummatches' => '  - $ {{PLURAL:$1|výsledek|výsledky|výsledků}}',
	'right-editwhitelist' => 'Změnit bílou listinu existujícíh uživatelů',
	'right-restricttowhitelist' => 'Upravit a zobrazit jen stránky z bílé listiny',
	'action-editwhitelist' => 'změnit bílou listinu uživatelů',
	'action-restricttowhitelist' => 'upravit a zobrazit jen stránky z bílé listiny',
	'group-restricted' => 'Omezení uživatelé',
	'group-restricted-member' => 'Omezený uživatel',
	'group-manager' => 'Správcové',
	'group-manager-member' => 'Správce',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'whitelisttablemodifyall' => 'Oll',
	'whitelisttableedit' => 'Golygu',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'whitelisttablemodifynone' => 'Ingen',
	'whitelisttableedit' => 'Redigér',
	'whitelistnever' => 'aldrig',
	'action-editwhitelist' => 'ændre hvidlisten for eksisterende brugere',
	'action-restricttowhitelist' => 'redigere og se sider som kun er på hvidlisten',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author ChrisiPK
 * @author Liam Rosen
 * @author Melancholie
 * @author Pill
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'whitelist-desc' => 'Zugriffsrechte von beschränkten Benutzern bearbeiten',
	'whitelistedit' => 'Whitelist-Zugriff-Editor',
	'whitelist' => 'Whitelist-Seiten',
	'mywhitelistpages' => 'Meine Seiten',
	'whitelistfor' => '<center>Aktuelle Information für <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifizieren',
	'whitelisttablemodifyall' => 'Alles modifizieren',
	'whitelisttablemodifynone' => 'Nichts modifizieren',
	'whitelisttablepage' => 'Seite',
	'whitelisttabletype' => 'Zugriffstyp',
	'whitelisttableexpires' => 'Ablauf am',
	'whitelisttablemodby' => 'Zuletzt modifiziert von',
	'whitelisttablemodon' => 'Zuletzt modifiziert am',
	'whitelisttableedit' => 'Bearbeiten',
	'whitelisttableview' => 'Anschauen',
	'whitelisttablenewdate' => 'Neues Datum:',
	'whitelisttablechangedate' => 'Ablaufsdatum ändern',
	'whitelisttablesetedit' => 'Bearbeiten',
	'whitelisttablesetview' => 'Anschauen',
	'whitelisttableremove' => 'Entfernen',
	'whitelistnewpagesfor' => "Neue Seiten zu <b>$1's</b> Whitelist hinzufügen<br />
Entweder * oder % als Maskenzeichen benutzen",
	'whitelistnewtabledate' => 'Ablaufdatum:',
	'whitelistnewtableedit' => 'Bearbeiten',
	'whitelistnewtableview' => 'Anschauen',
	'whitelistnowhitelistedusers' => 'Es gibt keine Benutzer, die der Gruppe „{{MediaWiki:Group-restricted}}“ angehören.
Du musst [[Special:UserRights|Benutzer zu der Gruppe hinzufügen]] bevor du Seiten auf die Beobachtungsliste eines Benutzers setzen kannst.',
	'whitelistnewtableprocess' => 'Bearbeiten',
	'whitelistnewtablereview' => 'Überprüfen',
	'whitelistselectrestricted' => '== Beschränkten Benutzer auswählen ==',
	'whitelistpagelist' => '{{SITENAME}} Seiten für $1',
	'whitelistnocalendar' => "<font color='red' size=3>[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Die Extension:UsageStatistics], eine Vorraussetzung für dieses Extension, wurde nicht installiert oder kann nicht gefunden werden!</font>",
	'whitelistoverview' => '== Änderungsübersicht für $1 ==',
	'whitelistoverviewcd' => "* Datum '''($1)''' für [[:$2|$2]] wird geändert",
	'whitelistoverviewsa' => "* Zugriff '''$1''' für [[:$2|$2]] wird angewendet",
	'whitelistoverviewrm' => '* Zugriff auf [[:$1|$1]] wird entfernt',
	'whitelistoverviewna' => "* [[:$1|$1]] wird zur Whitelist hinzugefügt. (Zugriff: '''$2''', Ablaufdatum: '''$3''')",
	'whitelistrequest' => 'Weiteren Zugriff beantragen',
	'whitelistrequestmsg' => '$1 hat Zugriff auf die {{PLURAL:$3|folgende Seite|folgenden Seiten}} beantragt:

$2',
	'whitelistrequestconf' => 'Beantragung an $1 geschickt',
	'whitelistnonrestricted' => "'''$1''' ist kein beschränkter Benutzer.
Diese Seite gilt nur für beschränkte Bentzer.",
	'whitelistnever' => 'niemals',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|Übereinstimmung|Übereinstimmungen}}',
	'right-editwhitelist' => 'Weiße Liste für existierende Benutzer bearbeiten',
	'right-restricttowhitelist' => 'Seiten ansehen und bearbeiten, die in der Positivliste enthalten sind',
	'action-editwhitelist' => 'modifiziere die Positivliste für existierende Benutzer',
	'action-restricttowhitelist' => 'bearbeite und betrachte nur Seiten die in der Positivliste enthalten sind',
	'group-restricted' => 'Eingeschränkte Benutzer',
	'group-restricted-member' => 'Eingeschränkter Benutzer',
	'group-manager' => 'Verwalter',
	'group-manager-member' => 'Verwalter',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 */
$messages['de-formal'] = array(
	'whitelistnowhitelistedusers' => 'Es gibt keine Benutzer, die der Gruppe „{{MediaWiki:Group-restricted}}“ angehören.
Sie müssen [[Special:UserRights|Benutzer zu der Gruppe hinzufügen]] bevor Sie Seiten auf die Beobachtungsliste eines Benutzers setzen können.',
);

/** Zazaki (Zazaki)
 * @author Belekvor
 */
$messages['diq'] = array(
	'whitelisttablemodifynone' => 'çino',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'whitelist-desc' => 'Pśistupne pšawa wobgranicowanych wužywarjow wobźěłaś',
	'whitelistedit' => 'Editor zapśimka pśez běłu lisćinu',
	'whitelist' => 'Boki běłeje lisćiny',
	'mywhitelistpages' => 'Móje boki',
	'whitelistfor' => '<center>Aktualne informacije za <b>$1</b></center>',
	'whitelisttablemodify' => 'Změniś',
	'whitelisttablemodifyall' => 'Wšykno',
	'whitelisttablemodifynone' => 'Žeden',
	'whitelisttablepage' => 'Wikijowy bok',
	'whitelisttabletype' => 'Typ zapśimka',
	'whitelisttableexpires' => 'Pśepadnjo',
	'whitelisttablemodby' => 'Slědny raz změnjony wót',
	'whitelisttablemodon' => 'Slědny raz změnjony',
	'whitelisttableedit' => 'Wobźěłaś',
	'whitelisttableview' => 'Woglědaś se',
	'whitelisttablenewdate' => 'Nowy datum:',
	'whitelisttablechangedate' => 'Datum pśepadnjenja změniś',
	'whitelisttablesetedit' => 'Wobźěłaś',
	'whitelisttablesetview' => 'Woglědaś se',
	'whitelisttableremove' => 'Wótpóraś',
	'whitelistnewpagesfor' => 'Pśidaj nowe boki běłej lisćinje <b>$1</b><br />
Wužyj pak * abo % ako zastupne znamuško',
	'whitelistnewtabledate' => 'Datum pśepadnjenja:',
	'whitelistnewtableedit' => 'Wobźěłaś',
	'whitelistnewtableview' => 'Woglědaś se',
	'whitelistnowhitelistedusers' => 'W kupce "{{MediaWiki:Group-restricted}}" wužywarje njejsu.
Musyš [[Special:UserRights|kupce wužywarjow pśidaś]], pjerwjej až móžoš boki běłej lisćinje wužywarja pśidaś.',
	'whitelistnewtableprocess' => 'Pśeźěłaś',
	'whitelistnewtablereview' => 'Pśeglědaś',
	'whitelistselectrestricted' => '== Mě wobgranicowanego wužywarja wubraś ==',
	'whitelistpagelist' => 'Boki {{GRAMMAR:genitiw|{{SITENAME}}}} za $1',
	'whitelistnocalendar' => "<font color='red' size=3>Zda se, až [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], wuměnjenje za toś to rozšyrjenje, njejo se pórědnje instalěrowalo!</font>",
	'whitelistoverview' => '== Pśeglěd změnow za $1 ==',
	'whitelistoverviewcd' => "* Datum za [[:$2|$2]] změnja se do '''$1'''",
	'whitelistoverviewsa' => "* Zapśimk za [[:$2|$2]] staja se do '''$1'''",
	'whitelistoverviewrm' => '* Zapśimk wótwónoźujo se do [[:$1|$1]]',
	'whitelistoverviewna' => "* [[:$1|$1]] pśidawa se běłej lisćinje ze zapśimkom '''$2''' a z datumom pśepadnjenja '''$3'''",
	'whitelistrequest' => 'Póžedanje na dalšne boki stajiś',
	'whitelistrequestmsg' => '$1 jo pšosył wó zapśimk na {{PLURAL:$3|slědujucy bok|slědujucej boka|slědujuce boki|slědujuce boki}}:

$2',
	'whitelistrequestconf' => 'Póžedanje na nowe boki jo se pósłało do $1',
	'whitelistnonrestricted' => "Wužywaŕ '''$1''' njejo wobgranicowany wužywar.
Toś ten bok dajo se jano na wobgranicowanych wužywarjow nałožyś.",
	'whitelistnever' => 'nigda',
	'whitelistnummatches' => '- {{PLURAL:$1|jaden wótpowědnik|$1 wótpowědnika|$1 wótpowědniki|$1 wótpowědnikow}}',
	'right-editwhitelist' => 'Běłu lisćinu za eksistujucych wužywarjow změniś',
	'right-restricttowhitelist' => 'Jano boki z běłeje lisćiny wobźěłaś a se woglědaś',
	'action-editwhitelist' => 'Běłu liscínu za eksistujucych wužywarjow změniś',
	'action-restricttowhitelist' => 'Jano boki z běłeje lisćiny wobźěłaś a se woglědaś',
	'group-restricted' => 'Wobgranicowane wužywarje',
	'group-restricted-member' => 'Wobgranicowany wužywaŕ',
	'group-manager' => 'Zastojniki',
	'group-manager-member' => 'Zastojnik',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'whitelistnever' => 'gbeɖe',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'whitelist-desc' => 'Αλλαγή των αδειών πρόσβασης των περιορισμένων χρηστών',
	'whitelistedit' => 'Επεξεργαστής πρόσβασης της άσπρης λίστας',
	'whitelist' => 'Σελίδες άσπρης λίστας',
	'mywhitelistpages' => 'Οι Σελίδες μου',
	'whitelistfor' => '<center>Τωρινές πληροφορίες για το <b>$1</b></center>',
	'whitelisttablemodify' => 'Τροποποίηση',
	'whitelisttablemodifyall' => 'Ὀλα',
	'whitelisttablemodifynone' => 'Κανένα',
	'whitelisttablepage' => 'Σελίδα βίκι',
	'whitelisttabletype' => 'Τύπος πρόσβασης',
	'whitelisttableexpires' => 'Λήγει στις',
	'whitelisttablemodby' => 'Τελευταία επεξεργασία από τον',
	'whitelisttablemodon' => 'Τελευταία επεξεργασία στις',
	'whitelisttableedit' => 'Επεξεργασία',
	'whitelisttableview' => 'Προβολή',
	'whitelisttablenewdate' => 'Νέα ημερομηνία:',
	'whitelisttablechangedate' => 'Αλλαγή ημερομηνίας λήξης',
	'whitelisttablesetedit' => 'Έτοιμο για επεξεργασία',
	'whitelisttablesetview' => 'Έτοιμο για εμφάνιση',
	'whitelisttableremove' => 'Αφαίρεση',
	'whitelistnewpagesfor' => 'Προσθέτει νέεςς σελίδες στην άσπρη λίστα του <b>$1</b><br />
Χρησιμοποιήστε είτε * ή % ως χαρακτήρα μπαλαντέρ',
	'whitelistnewtabledate' => 'Ημερομηνία λήξης:',
	'whitelistnewtableedit' => 'Έτοιμο για επεξεργασία',
	'whitelistnewtableview' => 'Έτοιμο για εμφάνιση',
	'whitelistnowhitelistedusers' => 'Δεν υπάρχουν χρήστες στην ομάδα "{{MediaWiki:Group-restricted}}".
Πρέπει να [[Special:UserRights|προσθέσετε χρήστες στην ομάδα]] πριν προσθέσετε σελίδες σε μια άσπρη λίστα ενός χρήστη.',
	'whitelistnewtableprocess' => 'Πρόοδος',
	'whitelistnewtablereview' => 'Επιθεώρηση',
	'whitelistselectrestricted' => '== Επιλογή περιορισμένου ονόματος χρήστη ==',
	'whitelistpagelist' => 'Σελίδες στο {{SITENAME}} για το $1',
	'whitelistnocalendar' => "<font color='red' size=3>Φαίνεται ότι το [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], προαπαιτούμενο για αυτή την επέκταση, δεν έχει εγκατασταθεί σωστά!</font>",
	'whitelistoverview' => '== Επισκόπηση αλλαγών του $1 ==',
	'whitelistoverviewcd' => "* Αλλαγή της ημερομηνίας στο '''$1''' για το [[:$2|$2]]",
	'whitelistoverviewsa' => "* Ρυθμίση της πρόσβασης στο '''$1''' για το [[:$2|$2]]",
	'whitelistoverviewrm' => '* Αφαίρεση της πρόσβασης στο [[:$1|$1]]',
	'whitelistoverviewna' => "* Προσθήκη του [[:$1|$1]] στην άσπρη λίστα με πρόσβαση '''$2''' και ημερομηνία λήξης στις '''$3'''",
	'whitelistrequest' => 'Ζήτηση πρόσβασης για περισσότερες σελίδες',
	'whitelistrequestmsg' => 'Ο/Η $1 έχει άδεια που ζητήθηκε {{PLURAL:$3|στην σελίδα|στις σελίδες}}:

$2',
	'whitelistrequestconf' => 'Η πρόταση για νέες σελίδες στάλθηκε σε $1',
	'whitelistnonrestricted' => "Ο χρήστης '''$1''' δεν είναι ένας περιορισμένος χρήστης.
Αυτή η σελίδα είναι κατάλληλη μόνο για τους περιορισμένους χρήστες",
	'whitelistnever' => 'ποτέ',
	'whitelistnummatches' => '  - {{PLURAL:$1|ένα αποτέλεσμα|$1 αποτελέσματα}}',
	'right-editwhitelist' => 'Τροποποίηση της άσπρης λίστας για τωρινούς χρήστες',
	'right-restricttowhitelist' => 'Επεξεργασία και προβολή σελίδων στην άσπρη λίστα μόνο',
	'action-editwhitelist' => 'τροποποίηση της άσπρης λίστας για τους υπάρχοντες χρήστες',
	'action-restricttowhitelist' => 'επεξεργασία και προβολή σελίδων στην άσπρη λίστα μόνο',
	'group-restricted' => 'Περιορισμένοι χρήστες',
	'group-restricted-member' => 'Περιορισμένος χρήστης',
	'group-manager' => 'Διαχειριστές',
	'group-manager-member' => 'Διαχειριστής',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'whitelist-desc' => 'Redakti la atingo-permesojn de limigitaj uzantoj',
	'whitelistedit' => 'Redaktilo por atingo per blankalisto',
	'whitelist' => 'Blanklisto Paĝoj',
	'mywhitelistpages' => 'Miaj Paĝoj',
	'whitelistfor' => '<center>Nuna informo por <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifi',
	'whitelisttablemodifyall' => 'Ĉiuj',
	'whitelisttablemodifynone' => 'Neniu',
	'whitelisttablepage' => 'Vikia Paĝo',
	'whitelisttabletype' => 'Atinga tipo',
	'whitelisttableexpires' => 'Finas je',
	'whitelisttablemodby' => 'Laste modifita de',
	'whitelisttablemodon' => 'Laste modifita je',
	'whitelisttableedit' => 'Redakti',
	'whitelisttableview' => 'Rigardu',
	'whitelisttablenewdate' => 'Nova Dato:',
	'whitelisttablechangedate' => 'Ŝanĝu Findaton',
	'whitelisttableremove' => 'Forigi',
	'whitelistnewtabledate' => 'Findato:',
	'whitelistnewtableedit' => 'Prete redakti',
	'whitelistnewtableview' => 'Prete vidi',
	'whitelistnewtableprocess' => 'Procezi',
	'whitelistnewtablereview' => 'Kontrolu',
	'whitelistselectrestricted' => '== Selektu Limigitan Salutnomon ==',
	'whitelistpagelist' => '{{SITENAME}} paĝoj por $1',
	'whitelistoverview' => '== Resumo de ŝanĝoj por $1 ==',
	'whitelistoverviewcd' => "* Ŝanĝante daton al '''$1''' por [[:$2|$2]]",
	'whitelistrequest' => 'Petu atingon por pliaj paĝoj',
	'whitelistrequestmsg' => '$1 petis atingon al la {{PLURAL:$3|jena paĝo|jenaj paĝoj}}:

$2',
	'whitelistrequestconf' => 'Peto por novaj paĝoj estis sendita al $1',
	'whitelistnever' => 'neniam',
	'whitelistnummatches' => ' - {{PLURAL:$1|unu trafo|$1 trafoj}}',
	'right-editwhitelist' => 'Modifi la blankalisto por ekzistantaj uzantoj',
	'right-restricttowhitelist' => 'Redakti kaj vidi paĝojn nur en la blankalisto',
	'action-editwhitelist' => 'nur modifi la blankalisto por ekzistantaj uzantoj',
	'action-restricttowhitelist' => 'redakti kaj vidi paĝojn nur en la blankalisto',
	'group-restricted' => 'Limigitaj uzantoj',
	'group-restricted-member' => 'Limigita uzanto',
	'group-manager' => 'Kondukantoj',
	'group-manager-member' => 'Kondukanto',
);

/** Spanish (Español)
 * @author Antur
 * @author Imre
 * @author Piolinfax
 * @author Sanbec
 */
$messages['es'] = array(
	'whitelist-desc' => 'Editar los permisos de acceso de usuarios restringidos',
	'whitelistedit' => 'Editor de acceso de la lista blanca',
	'whitelist' => 'Páginas de la lista blanca',
	'mywhitelistpages' => 'Mis páginas',
	'whitelistfor' => '<center>Informacion actual para <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifica',
	'whitelisttablemodifyall' => 'Todos',
	'whitelisttablemodifynone' => 'Ninguno',
	'whitelisttablepage' => 'Página wiki',
	'whitelisttabletype' => 'Tipo de acceso',
	'whitelisttableexpires' => 'Expira el',
	'whitelisttablemodby' => 'Última modificación realizada por',
	'whitelisttablemodon' => 'Última modificación realizada el',
	'whitelisttableedit' => 'Editar',
	'whitelisttableview' => 'Ver',
	'whitelisttablenewdate' => 'Nueva fecha:',
	'whitelisttablechangedate' => 'Cambiar la fecha de caducidad',
	'whitelisttablesetedit' => 'Activar modificación',
	'whitelisttablesetview' => 'Activar visualización',
	'whitelisttableremove' => 'Borrar',
	'whitelistnewpagesfor' => 'Añadir páginas a la lista blanca de <b>$1</b> <br />
Usa * o % como comodines.',
	'whitelistnewtabledate' => 'Fecha de caducidad:',
	'whitelistnewtableedit' => 'Activar modificación',
	'whitelistnewtableview' => 'Activar visualización',
	'whitelistnowhitelistedusers' => 'No hay usuarios en el grupo «{{MediaWiki:Group-restricted}}».
Tienes que [[Special:UserRights|añadir usuarios al grupo]] antes de poder añadir páginas a una lista blanca de usuario.',
	'whitelistnewtableprocess' => 'Proceso',
	'whitelistnewtablereview' => 'Revisión',
	'whitelistselectrestricted' => '== Selecciona un nombre de usuario restringido ==',
	'whitelistpagelist' => 'Páginas de {{SITENAME}} para $1',
	'whitelistnocalendar' => "<font color='red' size=3>Aparentemente la [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], requisito necesario para esta extensión, no ha sido instalada correctamente!</font>",
	'whitelistoverview' => '== Resumen de cambios para $1 ==',
	'whitelistoverviewcd' => "* Cambiando la fecha a '''$1''' para [[:$2|$2]]",
	'whitelistoverviewsa' => "* Estableciendo acceso a '''$1''' para [[:$2|$2]]",
	'whitelistoverviewrm' => '* Quitando acceso a [[:$1|$1]]',
	'whitelistoverviewna' => "* Agregando [[:$1|$1]] a la lista con acceso '''$2''' y fecha de expiración '''$3'''",
	'whitelistrequest' => 'Solicitar acceso a más páginas',
	'whitelistrequestmsg' => '$1 solicitó acceso a {{PLURAL:$3|la siguiente página|las siguientes $3 páginas}}:

$2',
	'whitelistrequestconf' => 'La solicitud de nuevas páginas fue enviada a $1',
	'whitelistnonrestricted' => "El usuario '''$1''' no está restringido.
Está página sólo es aplicable a usuarios restringidos",
	'whitelistnever' => 'nunca',
	'whitelistnummatches' => ' - {{PLURAL:$1|una coincidencia|$1 coincidencias}}.',
	'right-editwhitelist' => 'Modificar la lista blanca para usuarios existentes',
	'right-restricttowhitelist' => 'Editar y ver sólo las páginas de la lista blanca',
	'action-editwhitelist' => 'modificar la lista blanca para usuarios existentes',
	'action-restricttowhitelist' => 'editar y ver sólo las páginas de la lista blanca',
	'group-restricted' => 'Usuarios limitados',
	'group-restricted-member' => 'Usuario limitado',
	'group-manager' => 'Gestores',
	'group-manager-member' => 'Gestor',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'whitelisttablemodifyall' => 'Kõik',
	'whitelisttablemodifynone' => 'Ei midagi',
	'whitelisttableexpires' => 'Aegub',
	'whitelisttableedit' => 'Redigeeri',
	'whitelisttableview' => 'Vaata',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'mywhitelistpages' => 'Nire orriak',
	'whitelisttablemodify' => 'Aldatu',
	'whitelisttablemodifyall' => 'Denak',
	'whitelisttablemodifynone' => 'Bat ere ez',
	'whitelisttablepage' => 'Wiki orrialdea',
	'whitelisttabletype' => 'Sarrera mota',
	'whitelisttableexpires' => 'Iraungitzen du:',
	'whitelisttablemodby' => 'Azken aldaketare egilea',
	'whitelisttablemodon' => 'Azken aldaketa egin zen',
	'whitelisttableedit' => 'Aldatu',
	'whitelisttableview' => 'Ikusi',
	'whitelisttablenewdate' => 'Data berria:',
	'whitelisttablechangedate' => 'Iraungitzen data aldatu',
	'whitelisttablesetedit' => 'Aldatzeko jarri',
	'whitelisttablesetview' => 'Ikusteko aldatu',
	'whitelisttableremove' => 'Ezabatu',
	'whitelistnewtabledate' => 'Iraungitze data:',
	'whitelistnewtableedit' => 'Aldatzeko jarri',
	'whitelistnewtableview' => 'Aldatzeko jarri',
	'whitelistnewtableprocess' => 'Prozesatu',
	'whitelistnewtablereview' => 'Berrikusi',
	'whitelistselectrestricted' => '== Hauta ezazu mugatutako lankide izena ==',
	'whitelistnever' => 'inoiz',
	'group-restricted' => 'Mugatutako lankideak',
	'group-restricted-member' => 'Mugatutako lankidea',
	'group-manager' => 'Administratzaileak',
	'group-manager-member' => 'Administratzaile',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'whitelist-desc' => 'Muokkaa rajoituksenalaisten käyttäjien käyttöoikeuksia',
	'whitelist' => 'Sallitut sivut',
	'mywhitelistpages' => 'Omat sivu',
	'whitelisttablemodify' => 'Muokkaa',
	'whitelisttablemodifyall' => 'Kaikki',
	'whitelisttablemodifynone' => 'Ei mitään',
	'whitelisttablepage' => 'Wikisivu',
	'whitelisttableexpires' => 'Vanhentuu',
	'whitelisttablemodby' => 'Viimeisin muokkaaja',
	'whitelisttablemodon' => 'Viimeksi muokattu',
	'whitelisttableedit' => 'Muokkaa',
	'whitelisttableview' => 'Näytä',
	'whitelisttablenewdate' => 'Uusi päivämäärä:',
	'whitelisttablechangedate' => 'Muuta vanhentumispäivämäärää',
	'whitelisttableremove' => 'Poista',
	'whitelistnewtabledate' => 'Vanhentumispäivämäärä',
	'whitelistnewtableprocess' => 'Käsittele',
	'whitelistnewtablereview' => 'Tarkasta',
	'whitelistselectrestricted' => '== Valitse rajattu käyttäjätunnus ==',
	'whitelistpagelist' => '{{SITENAME}}-sivut kohteelle $1',
	'whitelistoverview' => '== Yleiskatsaus muutoksista kohteeseen $1 ==',
	'whitelistoverviewcd' => "* Muutetaan päiväys arvoon '''$1''' kohteelle [[:$2|$2]]",
	'whitelistoverviewsa' => "* Asetetaan oikeudet '''$1''' kohteelle [[:$2|$2]]",
	'whitelistrequest' => 'Pyydä pääsyä useammille sivuille',
	'whitelistrequestmsg' => '$1 on pyytänyt pääsyä {{PLURAL:$3|seuraavalle sivulle|seuraaville sivuille}}:

$2',
	'whitelistrequestconf' => 'Lähetettiin kohteeseen $1 pyyntö uusista sivuista',
	'whitelistnonrestricted' => "Käyttäjä '''$1''' ei ole rajoituksenalainen käyttäjä.
Tätä sivua sovelletaan ainoastaan rajoituksenalaisiin käyttäjiin",
	'whitelistnever' => 'ei koskaan',
	'whitelistnummatches' => '  - {{PLURAL:$1|yksi osuma|$1 osumaa}}',
	'group-restricted' => 'rajoitetut käyttäjät',
	'group-restricted-member' => 'rajoitettu käyttäjä',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author McDutchie
 * @author PieRRoMaN
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'whitelist-desc' => 'Modifie les permissions d’accès des utilisateurs à pouvoirs restreints',
	'whitelistedit' => 'Modificateur de la liste blanche des accès',
	'whitelist' => 'Pages de listes blanches',
	'mywhitelistpages' => 'Mes pages',
	'whitelistfor' => '<center>Informations actuelles pour <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifier',
	'whitelisttablemodifyall' => 'Tout',
	'whitelisttablemodifynone' => 'Néant',
	'whitelisttablepage' => 'Page wiki',
	'whitelisttabletype' => 'Mode d’accès',
	'whitelisttableexpires' => 'Expire le',
	'whitelisttablemodby' => 'Modifié en dernier par',
	'whitelisttablemodon' => 'Modifié en dernier le',
	'whitelisttableedit' => 'Modifier',
	'whitelisttableview' => 'Afficher',
	'whitelisttablenewdate' => 'Nouvelle date :',
	'whitelisttablechangedate' => 'Changer la date d’expiration',
	'whitelisttablesetedit' => 'Activer modification',
	'whitelisttablesetview' => 'Activer visualisation',
	'whitelisttableremove' => 'Retirer',
	'whitelistnewpagesfor' => 'Ajoute de nouvelles pages à la liste blanche de <b>$1</b><br />
Utiliser soit le caractère * soit %',
	'whitelistnewtabledate' => 'Date d’expiration :',
	'whitelistnewtableedit' => 'Activer modification',
	'whitelistnewtableview' => 'Activer visualisation',
	'whitelistnowhitelistedusers' => 'Il n’y a aucun utilisateur dans le groupe « {{MediaWiki:Group-restricted}} ».
Vous devez [[Special:UserRights|ajouter l’utilisateur au groupe]] avant que vous puissiez ajouter des pages à la liste blanche d’un utilisateur.',
	'whitelistnewtableprocess' => 'Traiter',
	'whitelistnewtablereview' => 'Relire',
	'whitelistselectrestricted' => '== Sélectionner un nom d’utilisateur à accès restreint ==',
	'whitelistpagelist' => 'Pages de {{SITENAME}} pour $1',
	'whitelistnocalendar' => "<font color='red' size=3>Il semble que le module [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], une extension prérequise, n’ait pas été installée convenablement !</font>",
	'whitelistoverview' => '== Vue générale des changements pour $1 ==',
	'whitelistoverviewcd' => "* Modification de la date de '''$1''' pour [[:$2|$2]]",
	'whitelistoverviewsa' => "* Configuration de l’accès à '''$1''' pour [[:$2|$2]]",
	'whitelistoverviewrm' => '* Retrait de l’accès à [[:$1|$1]]',
	'whitelistoverviewna' => "* Ajout de [[:$1|$1]] à la liste blanche avec les droits de '''$2''' et comme date d’expiration le '''$3'''",
	'whitelistrequest' => 'Demander un accès à plus de pages',
	'whitelistrequestmsg' => '$1 a demandé l’accès {{PLURAL:$3|à la page suivante|aux pages suivantes}} :

$2',
	'whitelistrequestconf' => 'Une demande d’accès pour de nouvelles pages a été envoyée à $1',
	'whitelistnonrestricted' => "L’utilisateur '''$1''' n’a pas des droits restreints.
Cette page ne s’applique qu’aux utilisateurs disposant de droits restreints.",
	'whitelistnever' => 'jamais',
	'whitelistnummatches' => ' - {{PLURAL:$1|une occurrence|$1 occurrences}}',
	'right-editwhitelist' => 'Modifier la liste blanche pour les utilisateurs existants',
	'right-restricttowhitelist' => 'Modifier et visionner les pages figurant uniquement sur la liste blanche',
	'action-editwhitelist' => 'modifier la liste blanche pour les utilisateurs existants',
	'action-restricttowhitelist' => 'modifier et visionner les pages figurant uniquement sur la liste blanche',
	'group-restricted' => 'Utilisateurs restreints',
	'group-restricted-member' => 'Utilisateur restreint',
	'group-manager' => 'Gestionnaires',
	'group-manager-member' => 'Gestionnaire',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'mywhitelistpages' => 'Mes pâges',
	'whitelisttablemodify' => 'Changiér',
	'whitelisttablemodifyall' => 'Tot',
	'whitelisttablemodifynone' => 'Ren',
	'whitelisttableedit' => 'Changiér',
	'whitelisttableview' => 'Fâre vêre',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'whitelisttablemodifyall' => 'Alle',
	'whitelisttablemodifynone' => 'Gjin',
	'whitelisttableedit' => 'Wizigje',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'whitelisttablemodifyall' => 'An t-iomlán',
	'whitelisttablemodifynone' => 'Tada',
	'whitelisttablepage' => 'Leathanach vicí',
	'whitelisttablenewdate' => 'Dáta nua:',
	'whitelistoverviewcd' => "* Ag athrú an dáta ó '''$1''' le [[:$2|$2]]",
	'whitelistoverviewsa' => "* Ag socrú rochtain do '''$1''' le [[:$2|$2]]",
	'group-manager' => 'Bainisteóir',
	'group-manager-member' => 'Bainisteór',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'whitelist-desc' => 'Editar os permisos de acceso dos usuarios restrinxidos',
	'whitelistedit' => 'Editor de acceso da lista branca (whitelist)',
	'whitelist' => 'Páxinas da lista branca',
	'mywhitelistpages' => 'As miñas páxinas',
	'whitelistfor' => '<center>Información actual para <b>$1</b></center>',
	'whitelisttablemodify' => 'Modificar',
	'whitelisttablemodifyall' => 'Todo',
	'whitelisttablemodifynone' => 'Ningún',
	'whitelisttablepage' => 'Páxina do wiki',
	'whitelisttabletype' => 'Tipo de acceso',
	'whitelisttableexpires' => 'Expira o',
	'whitelisttablemodby' => 'Modificado por última vez por',
	'whitelisttablemodon' => 'Modificado por última o',
	'whitelisttableedit' => 'Editar',
	'whitelisttableview' => 'Ver',
	'whitelisttablenewdate' => 'Nova data:',
	'whitelisttablechangedate' => 'Cambiar a data de remate',
	'whitelisttablesetedit' => 'Preparar para editar',
	'whitelisttablesetview' => 'Preparar para ver',
	'whitelisttableremove' => 'Eliminar',
	'whitelistnewpagesfor' => 'Engada novas páxinas á lista branca de <b>$1</b><br />
Pode usar * ou %, como tamén o carácter "comodín"',
	'whitelistnewtabledate' => 'Data de caducidade:',
	'whitelistnewtableedit' => 'Preparar para editar',
	'whitelistnewtableview' => 'Preparar para ver',
	'whitelistnowhitelistedusers' => 'Non hai usuarios no grupo "{{MediaWiki:Group-restricted}}".
Ten que [[Special:UserRights|engadir usuarios ao grupo]] antes de poder engadir páxinas á lista branca dun usuario.',
	'whitelistnewtableprocess' => 'Proceso',
	'whitelistnewtablereview' => 'Revisar',
	'whitelistselectrestricted' => '== Seleccionar un nome de usuario restrinxido ==',
	'whitelistpagelist' => 'Páxinas de {{SITENAME}} para $1',
	'whitelistnocalendar' => "<font color='red' size=3>Parece que [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], un requirimento previo para esta extensión, non foi instalada adecuadamente!</font>",
	'whitelistoverview' => '== Visión xeral dos cambios para $1 ==',
	'whitelistoverviewcd' => "* Cambiando a data a '''$1''' para [[:$2|$2]]",
	'whitelistoverviewsa' => "* Configurando o acceso a '''$1''' para [[:$2|$2]]",
	'whitelistoverviewrm' => '* Eliminando o acceso a [[:$1|$1]]',
	'whitelistoverviewna' => "* Engadindo [[:$1|$1]] á lista branca (whitelist) con acceso a '''$2''' e data de remate '''$3'''",
	'whitelistrequest' => 'Solicitar acceso a máis páxinas',
	'whitelistrequestmsg' => '$1 solicitou ter acceso {{PLURAL:$3|á seguinte páxina|ás seguintes páxinas}}:

$2',
	'whitelistrequestconf' => 'A solicitude para páxinas novas foi enviada a $1',
	'whitelistnonrestricted' => "O usuario '''$1''' non é un usuario limitado.
Esta páxina só é aplicable aos usuarios limitados",
	'whitelistnever' => 'nunca',
	'whitelistnummatches' => ' - {{PLURAL:$1|unha coincidencia|$1 coincidencias}}',
	'right-editwhitelist' => 'Modificar a lista branca dos usuarios existentes',
	'right-restricttowhitelist' => 'Editar e ver só as páxinas da lista branca',
	'action-editwhitelist' => 'modificar a lista branca dos usuarios existentes',
	'action-restricttowhitelist' => 'editar e ver só as páxinas da lista branca',
	'group-restricted' => 'Usuarios restrinxidos',
	'group-restricted-member' => 'Usuario restrinxido',
	'group-manager' => 'Xestores',
	'group-manager-member' => 'Xestor',
);

/** Gothic (Gothic)
 * @author Crazymadlover
 * @author Jocke Pirat
 * @author Omnipaedista
 */
$messages['got'] = array(
	'whitelisttableedit' => 'Máidjan',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'mywhitelistpages' => 'Αἱ δέλτοι μου',
	'whitelisttablemodify' => 'Τροποποιεῖν',
	'whitelisttablemodifyall' => 'Ἅπασαι',
	'whitelisttablemodifynone' => 'Οὐδέν',
	'whitelisttableedit' => 'Μεταγράφειν',
	'whitelisttableview' => 'Ὁρᾶν',
	'whitelisttableremove' => 'Άφαιρεῖν',
	'whitelistnewtablereview' => 'Ἐπισκόπησις',
	'whitelistnever' => 'οὔποτε',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'whitelist-desc' => 'Zuegriffsrächt vu bschränkte Benutzer bearbeite',
	'whitelistedit' => 'Wyssi Lischt-Zuegriff-Editor',
	'whitelist' => 'Wyssi Lischt-Syte',
	'mywhitelistpages' => 'Myy Syte',
	'whitelistfor' => '<center>Aktuälli Information fir <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifiziere',
	'whitelisttablemodifyall' => 'Alles modifiziere',
	'whitelisttablemodifynone' => 'Nyt modifiziere',
	'whitelisttablepage' => 'Syte',
	'whitelisttabletype' => 'Zuegriffstyp',
	'whitelisttableexpires' => 'Lauft ab am',
	'whitelisttablemodby' => 'Zletscht modifiziert vu',
	'whitelisttablemodon' => 'Zletscht modifiziert am',
	'whitelisttableedit' => 'Bearbeite',
	'whitelisttableview' => 'Bschaue',
	'whitelisttablenewdate' => 'Nej Datum:',
	'whitelisttablechangedate' => 'Ablaufsdatum ändere',
	'whitelisttablesetedit' => 'Bearbeite',
	'whitelisttablesetview' => 'Bschaue',
	'whitelisttableremove' => 'Useneh',
	'whitelistnewpagesfor' => "Neiji Syte zue dr <b>$1's</b> Wysse Lischt zuefiege<br />
Entweder * oder % as Maskezeiche verwände",
	'whitelistnewtabledate' => 'Ablaufdatum:',
	'whitelistnewtableedit' => 'Bearbeite',
	'whitelistnewtableview' => 'Aaluege',
	'whitelistnowhitelistedusers' => 'S git kei Benutzer, wu zue dr Gruppe „{{MediaWiki:Group-restricted}}“ ghere.
Du muesch [[Special:UserRights|Benutzer zue dr Gruppe zuefiege]], voreb du Syte uf d Beobachtigslischt vun eme Benutzer chasch setze.',
	'whitelistnewtableprocess' => 'Bearbeite',
	'whitelistnewtablereview' => 'Iberpriefe',
	'whitelistselectrestricted' => '== Bschränkte Benutzer uuswähle ==',
	'whitelistpagelist' => '{{SITENAME}} Syte fir $1',
	'whitelistnocalendar' => "<font color='red' size=3>[http://www.mediawiki.org/wiki/Extension:Usage_Statistics D Extension:UsageStatistics], e Vorruussetzig fir die Extension, isch nit installiert wore oder cha nit gfunde wäre!</font>",
	'whitelistoverview' => '== Änderigsibersicht fir $1 ==',
	'whitelistoverviewcd' => "* Datum '''($1)''' fir [[:$2|$2]] wird gänderet",
	'whitelistoverviewsa' => "* Zuegriff '''$1''' fir [[:$2|$2]] wird aagwändet",
	'whitelistoverviewrm' => '* Zuegriff uf [[:$1|$1]] wird usegnuh',
	'whitelistoverviewna' => "* [[:$1|$1]] wird zue dr Wysse Lischt zuegfiegt. (Zuegriff: '''$2''', Ablaufdatum: '''$3''')",
	'whitelistrequest' => 'E Aatrag stelle uf Zuegriff uf meh Syte',
	'whitelistrequestmsg' => '$1 het e Aatrag gstellt uf Zuegriff uf {{PLURAL:$3|die Syte|die Syte}}:

$2',
	'whitelistrequestconf' => 'Aatrag isch an $1 gschickt wore',
	'whitelistnonrestricted' => "'''$1''' isch kei bschränkter Benutzer.
Die Syte giltet nume fir bschränkti Bentzer.",
	'whitelistnever' => 'nie',
	'whitelistnummatches' => '  - $1 {{PLURAL:$1|Ibereinstimmig|Ibereinstimmige}}',
	'right-editwhitelist' => 'Wyssi Lischt fir Benutzer bearbeite, wu s git',
	'right-restricttowhitelist' => 'Bearbeite un bschau nume Syte, wu in dr Wysse Lischt din sin',
	'action-editwhitelist' => 'modifizier di Wyss Lischt fir Benutzer, wu s git',
	'action-restricttowhitelist' => 'bearbeit un bschau nume Syte, wu in dr Wysse Lischt din sin',
	'group-restricted' => 'Yygschränkti Benutzer',
	'group-restricted-member' => 'Yygschränkter Benutzer',
	'group-manager' => 'Verwalter',
	'group-manager-member' => 'Verwalter',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'whitelisttableedit' => 'Phiên-chho',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'mywhitelistpages' => 'Ka‘u mau ‘ao‘ao',
	'whitelisttablemodifyall' => 'Apau',
	'whitelisttableedit' => 'E hoʻololi',
	'whitelisttableremove' => 'Kāpae',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'whitelist-desc' => 'עריכת הרשאות הגישה של משתמשים מוגבלים',
	'whitelistedit' => 'עורך הגישה לרשימה הלבנה',
	'whitelist' => 'דפי הרשימה הלבנה',
	'mywhitelistpages' => 'הדפים שלי',
	'whitelistfor' => '<center>המידע הנוכחי אודות <b>$1</b></center>',
	'whitelisttablemodify' => 'שינוי',
	'whitelisttablemodifyall' => 'הכול',
	'whitelisttablemodifynone' => 'כלום',
	'whitelisttablepage' => 'דף ויקי',
	'whitelisttabletype' => 'סוג הגישה',
	'whitelisttableexpires' => 'תאריך פקיעה',
	'whitelisttablemodby' => 'שונה לאחרונה בידי',
	'whitelisttablemodon' => 'שונה לאחרונה בתאריך',
	'whitelisttableedit' => 'עריכה',
	'whitelisttableview' => 'תצוגה',
	'whitelisttablenewdate' => 'תאריך חדש:',
	'whitelisttablechangedate' => 'שינוי תאריך הפקיעה',
	'whitelisttablesetedit' => 'הגדרה לעריכה',
	'whitelisttablesetview' => 'הגדרה לתצוגה',
	'whitelisttableremove' => 'הסרה',
	'whitelistnewpagesfor' => 'הוסp, דפים חדשים לרשימה הלבנה של <b>$1</b><br />
ניתן להשתמש ב־* או ב־% כתווים כלליים',
	'whitelistnewtabledate' => 'תאריך הפקיעה:',
	'whitelistnewtableedit' => 'הגדרה לעריכה',
	'whitelistnewtableview' => 'הגדרה לתצוגה',
	'whitelistnowhitelistedusers' => 'אין משתמשים בקבוצה "{{MediaWiki:Group-restricted}}".
יהיה עליכם [[Special:UserRights|להוסיף משתמשים לקבוצה]] לפני שתוכלו להוסיף דפים לרשימה הלבנה של המשתמש.',
	'whitelistnewtableprocess' => 'עיבוד',
	'whitelistnewtablereview' => 'סקירה',
	'whitelistselectrestricted' => '== בחירת שם המשתמש המוגבל ==',
	'whitelistpagelist' => 'דפי {{SITENAME}} עבור $1',
	'whitelistnocalendar' => "<font color='red' size=3>נראה ש־[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], דרישת קדם להרחבה זו, לא הותקנה כראוי!</font>",
	'whitelistoverview' => '== סקירת השינויים עבור $1 ==',
	'whitelistoverviewcd' => "* שינוי התאריך ל־'''$1''' עבור [[:$2|$2]]",
	'whitelistoverviewsa' => "* הגדרת הגישה אל '''$1''' עבור [[:$2|$2]]",
	'whitelistoverviewrm' => '* הסרת הגישה אל [[:$1|$1]]',
	'whitelistoverviewna' => "* הוספת [[:$1|$1]] לרשימה הלבנה עם הגישה '''$2''' ותאריך הפקיעה '''$3'''",
	'whitelistrequest' => 'בקשת גישה לדפים נוספים',
	'whitelistrequestmsg' => '$1 ביקש גישה ל{{PLURAL:$3|דף הבא|דפים הבאים}}:

$2',
	'whitelistrequestconf' => 'הבקשה לדפים חדשים נשלחה אל $1',
	'whitelistnonrestricted' => "המשתמש '''$1''' אינו משתמש מוגבל.
ניתן להשתמש בדף זה עבור משתמשים מוגבלים בלבד",
	'whitelistnever' => 'לעולם לא',
	'whitelistnummatches' => ' - {{PLURAL:$1|תוצאה אחת|$1 תוצאות}}',
	'right-editwhitelist' => 'שינוי הרשימה הלבנה למשתמשים קיימים',
	'right-restricttowhitelist' => 'עריכה והצגה של דפים מהרשימה הלבנה בלבד',
	'action-editwhitelist' => 'לשנות את הרשימה הלבנה למשתמשים קיימים',
	'action-restricttowhitelist' => 'לערוך ולהציג דפים מהרשימה הלבנה בלבד',
	'group-restricted' => 'משתמשים מוגבלים',
	'group-restricted-member' => 'משתמש מוגבל',
	'group-manager' => 'מנהלים',
	'group-manager-member' => 'מנהל',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'whitelisttablemodifyall' => 'सभी',
	'whitelisttablemodifynone' => 'बिल्कुल नहीं',
	'whitelisttableexpires' => 'समाप्ती',
	'whitelisttableedit' => 'संपादन',
	'whitelisttableremove' => 'हटायें',
	'whitelistnewtableprocess' => 'कार्य',
	'whitelistnewtablereview' => 'अवलोकन',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'whitelisttableedit' => 'Ilisan',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'whitelisttablemodifyall' => 'Sve',
	'whitelisttableremove' => 'Ukloni',
	'whitelistnever' => 'nikad',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'whitelist-desc' => 'Přistupne prawa wobmjezowanych wužiwarjow wobdźěłać',
	'whitelistedit' => 'Přistupny editor běłeje lisćiny',
	'whitelist' => 'Strony běłeje lisćiny',
	'mywhitelistpages' => 'Moje strony',
	'whitelistfor' => '<center>Aktualne informacije za <b>$1</b></center>',
	'whitelisttablemodify' => 'Změnić',
	'whitelisttablemodifyall' => 'Wšě',
	'whitelisttablemodifynone' => 'Žadyn',
	'whitelisttablepage' => 'Wikijowa strona',
	'whitelisttabletype' => 'Přistupny typ',
	'whitelisttableexpires' => 'Spadnje',
	'whitelisttablemodby' => 'Posledni raz změnjeny wot',
	'whitelisttablemodon' => 'Posledni raz změnjeny dnja',
	'whitelisttableedit' => 'Wobdźěłać',
	'whitelisttableview' => 'Wobhladać',
	'whitelisttablenewdate' => 'Nowy datum:',
	'whitelisttablechangedate' => 'Datum spadnjenja změnić',
	'whitelisttablesetedit' => 'Wobdźěłać',
	'whitelisttablesetview' => 'Wobhladać',
	'whitelisttableremove' => 'Wotstronić',
	'whitelistnewpagesfor' => 'Nowy strony k běłej lisćinje wužiwarja <b>$1</b> přidać<br />
Wužij pak * pak % jako zastupne znamješko',
	'whitelistnewtabledate' => 'Datum spadnjenja:',
	'whitelistnewtableedit' => 'Wobdźěłać',
	'whitelistnewtableview' => 'Wobhladać',
	'whitelistnowhitelistedusers' => 'Njejsu wužiwarjo w skupinje "{{MediaWiki:Group-restricted}}".
Dyrbiš [[Special:UserRights|wužiwarjow skupinje přidać]], prjedy hač móžeš strony běłej lisćinje wužiwarja přidać.',
	'whitelistnewtableprocess' => 'Předźěłać',
	'whitelistnewtablereview' => 'Přepruwować',
	'whitelistselectrestricted' => '== Wobmjezowane wužiwarske mjeno wubrać ==',
	'whitelistpagelist' => 'Strony {{GRAMMAR:genitiw|{{SITENAME}}}} za $1',
	'whitelistnocalendar' => "<font color='red' size=3>Zda so, zo [http://www.mediawiki.org/wiki/Extension:Usage_Statistics rozšěrjenje:UsageStatistics], předpokład za tute rozšěrjenje, njeje so porjadnje instalował!</font>",
	'whitelistoverview' => '== Přehlad změnow za $1 ==',
	'whitelistoverviewcd' => "* Datum za [[:$2|$2]] so do '''$1''' měnja",
	'whitelistoverviewsa' => "* Přistup za [[:$2|$2]] so do '''$1''' staja",
	'whitelistoverviewrm' => '* Přistup na [[:$1|$1]] so wotstronja',
	'whitelistoverviewna' => "* [[:$1|$1]] so do běłeje lisćiny z přistupom '''$2''' a datumom spadnjenja '''$3''' přidawa",
	'whitelistrequest' => 'Přistup za dalše strony požadać',
	'whitelistrequestmsg' => '$1 je přistup za {{PLURAL:$3|slědowacu stronu|slědowacej stronje|slědowace strony|slědowace strony}} požadał:

$2',
	'whitelistrequestconf' => 'Požadanje za nowe strony je so do $1 pósłało',
	'whitelistnonrestricted' => "Wužiwar '''$1''' wobmjezowany wužiwar njeje.
Tuta strona je jenož na wobmjezowanych wužiwarjow nałožujomna.",
	'whitelistnever' => 'ženje',
	'whitelistnummatches' => '- {{PLURAL:$1|jedyn wotpowědnik|$1 wotpowědnikaj|$1 wotpowědniki|$1 wotpowědnikow}}',
	'right-editwhitelist' => 'Běłu lisćinu za eksistowacych wužiwarjow změnić',
	'right-restricttowhitelist' => 'Jenož strony z běłeje lisćiny wobdźěłać a sej wobhladać',
	'action-editwhitelist' => 'Běłu lisćinu za eksistowacych wužiwarjow změnić',
	'action-restricttowhitelist' => 'Jenož strony z běłeje lisćiny wobdźěłać a sej wobhladać',
	'group-restricted' => 'Wobmjezowani wužiwarjo',
	'group-restricted-member' => 'Wobmjezowany wužiwar',
	'group-manager' => 'Zarjadnicy',
	'group-manager-member' => 'Zarjadnik',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'whitelist-desc' => 'Korlátozott felhasználók hozzáférési jogosultságainak szerkesztése',
	'whitelistedit' => 'Engedélylista-hozzáférés szerkesztő',
	'whitelist' => 'Engedélylista-lapok',
	'mywhitelistpages' => 'Lapjaim',
	'whitelistfor' => '<center>Aktuális információk ehhez: <b>$1</b></center>',
	'whitelisttablemodify' => 'Módosítás',
	'whitelisttablemodifyall' => 'Mind',
	'whitelisttablemodifynone' => 'Nincs',
	'whitelisttablepage' => 'Wiki lap',
	'whitelisttabletype' => 'Hozzáférés típusa',
	'whitelisttableexpires' => 'Lejárat',
	'whitelisttablemodby' => 'Utoljára módosította:',
	'whitelisttablemodon' => 'Utolsó módosítás dátuma:',
	'whitelisttableedit' => 'Szerkesztés',
	'whitelisttableview' => 'Megjelenítés',
	'whitelisttablenewdate' => 'Új dátum:',
	'whitelisttablechangedate' => 'Lejárat dátumának megváltoztatása',
	'whitelisttablesetedit' => 'Beállítás szerkesztésre',
	'whitelisttablesetview' => 'Beállítás megtekintésre',
	'whitelisttableremove' => 'Eltávolítás',
	'whitelistnewpagesfor' => 'Új lapok hozzáadása <b>$1</b> fehérlistájához<br />
Használd a * vagy % jeleket joker karakterként',
	'whitelistnewtabledate' => 'Lejárat dátuma:',
	'whitelistnewtableedit' => 'Beállítás szerkesztésre',
	'whitelistnewtableview' => 'Beállítás megtekintésre',
	'whitelistnowhitelistedusers' => 'Nincsenek felhasználók a(z) „{{MediaWiki:Group-restricted}}” csoportban.
[[Special:UserRights|Felhasználókat kell adnod a csoporthoz]], mielőtt lapokat adhatnál a felhasználó engedélylistájához.',
	'whitelistnewtableprocess' => 'Folyamat',
	'whitelistnewtablereview' => 'Ellenőrzés',
	'whitelistselectrestricted' => '== Korlátozott felhasználó nevének kiválasztása ==',
	'whitelistpagelist' => '$1 {{SITENAME}}-lapjai',
	'whitelistnocalendar' => "<font color='red' size=3>Úgy tűnik, hogy a [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics] – ami ennek a kiterjesztésnek előfeltétele – nincs megfelelően telepítve!</font>",
	'whitelistoverview' => '== A(z) $1 lappal kapcsolatos változtatások áttekintése ==',
	'whitelistoverviewcd' => "* Dátum megváltoztatása '''$1''' értékre a(z) [[:$2|$2]] laphoz",
	'whitelistoverviewsa' => "* Hozzáférés beállítása '''$1''' értékre a(z) [[:$2|$2]] laphoz",
	'whitelistoverviewrm' => '* Hozzáférés eltávolítása a(z) [[:$1|$1]] laptól',
	'whitelistoverviewna' => "* [[:$1|$1]] hozzáadása az engedélylistához '''$2''' engedéllyel és '''$3''' lejárati dátummal",
	'whitelistrequest' => 'Hozzáférés kérése több laphoz',
	'whitelistrequestmsg' => '$1 hozzáférést kért a következő {{PLURAL:$3|laphoz|lapokhoz}}:

$2',
	'whitelistrequestconf' => 'A kérelem az új lapok iránt el lett küldve $1 részére',
	'whitelistnonrestricted' => "'''$1''' nem korlátozott felhasználó.
Ez a lap csak korlátozott felhasználókra vonatkozik",
	'whitelistnever' => 'soha',
	'whitelistnummatches' => '  – {{PLURAL:$1|egy|$1}} találat',
	'right-editwhitelist' => 'létező felhasználók engedélylistájának módosítása',
	'right-restricttowhitelist' => 'csak a fehérlistán szereplő lapok megtekintése és szerkesztése',
	'action-editwhitelist' => 'létező felhasználók engedélylistájának módosítása',
	'action-restricttowhitelist' => 'csak az engedélylistán szereplő lapok megjelenítése és szerkesztése',
	'group-restricted' => 'Korlátozott felhasználók',
	'group-restricted-member' => 'Korlátozott felhasználó',
	'group-manager' => 'kezelők',
	'group-manager-member' => 'kezelő',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'whitelist-desc' => 'Modificar le permissiones de accesso de usatores restringite',
	'whitelistedit' => 'Editor de accesso al lista blanc',
	'whitelist' => 'Adder paginas al lista blanc',
	'mywhitelistpages' => 'Mi paginas',
	'whitelistfor' => '<center>Informationes actual pro <b>$1</b></center>',
	'whitelisttablemodify' => 'Modificar',
	'whitelisttablemodifyall' => 'Totes',
	'whitelisttablemodifynone' => 'Nulle',
	'whitelisttablepage' => 'Pagina wiki',
	'whitelisttabletype' => 'Typo de accesso',
	'whitelisttableexpires' => 'Expira le',
	'whitelisttablemodby' => 'Ultime modification per',
	'whitelisttablemodon' => 'Ultime modification le',
	'whitelisttableedit' => 'Modificar',
	'whitelisttableview' => 'Vider',
	'whitelisttablenewdate' => 'Nove data:',
	'whitelisttablechangedate' => 'Cambiar le data de expiration',
	'whitelisttablesetedit' => 'Activar modification',
	'whitelisttablesetview' => 'Activar visualisation',
	'whitelisttableremove' => 'Remover',
	'whitelistnewpagesfor' => 'Adde nove paginas al lista blanc de <b>$1</b><br />
Usa * o % como metacharacter',
	'whitelistnewtabledate' => 'Data de expiration:',
	'whitelistnewtableedit' => 'Activar modification',
	'whitelistnewtableview' => 'Activar visualisation',
	'whitelistnowhitelistedusers' => 'Il non ha alcun usator in le gruppo "{{MediaWiki:Group-restricted}}".
Tu debe [[Special:UserRights|adder usatores al gruppo]] ante que tu pote adder paginas al lista blanc de un usator.',
	'whitelistnewtableprocess' => 'Processar',
	'whitelistnewtablereview' => 'Revider',
	'whitelistselectrestricted' => '== Seliger nomine de usator restringite ==',
	'whitelistpagelist' => 'Paginas de {{SITENAME}} pro $1',
	'whitelistnocalendar' => "<font color='red' size=3>Pare que [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], un prerequisito pro iste extension, non ha essite installate correctemente!</font>",
	'whitelistoverview' => '== Summario de cambiamentos pro $1 ==',
	'whitelistoverviewcd' => "* Modifica le data a '''$1''' pro [[:$2|$2]]",
	'whitelistoverviewsa' => "* Configura le accesso a '''$1''' pro [[:$2|$2]]",
	'whitelistoverviewrm' => '* Retira le accesso a [[:$1|$1]]',
	'whitelistoverviewna' => "* Adde [[:$1|$1]] al lista blanc con accesso '''$2''' e data de expiration '''$3'''",
	'whitelistrequest' => 'Requestar accesso a plus paginas',
	'whitelistrequestmsg' => '$1 ha requestate accesso al sequente {{PLURAL:$3|pagina|paginas}}:

$2',
	'whitelistrequestconf' => 'Le requesta de nove paginas esseva inviate a $1',
	'whitelistnonrestricted' => "Le usator '''$1''' non es un usator restringite.
Iste pagina es solmente applicabile al usatores restringite",
	'whitelistnever' => 'nunquam',
	'whitelistnummatches' => ' - {{PLURAL:$1|un occurrentia|$1 occurrentias}}',
	'right-editwhitelist' => 'Modificar le lista blanc pro usatores existente',
	'right-restricttowhitelist' => 'Modificar e vider paginas figurante solmente in le lista blanc',
	'action-editwhitelist' => 'modificar le lista blanc pro usatores existente',
	'action-restricttowhitelist' => 'modificar e vider paginas figurante solmente in le lista blanc',
	'group-restricted' => 'Usatores restringite',
	'group-restricted-member' => 'Usator restringite',
	'group-manager' => 'Gerentes',
	'group-manager-member' => 'Gerente',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Kandar
 * @author Rex
 */
$messages['id'] = array(
	'whitelist-desc' => 'Sunting hak akses untuk pengguna terbatas',
	'whitelistedit' => 'Penyunting hak akses daftar putih',
	'whitelist' => 'Halaman daftar putih',
	'mywhitelistpages' => 'Halaman saya',
	'whitelistfor' => '<center>Informasi terkini untuk <b>$1</b></center>',
	'whitelisttablemodify' => 'Ubah',
	'whitelisttablemodifyall' => 'Semua',
	'whitelisttablemodifynone' => 'Tidak ada',
	'whitelisttablepage' => 'Halaman wiki',
	'whitelisttabletype' => 'Tipe akses',
	'whitelisttableexpires' => 'Kadaluwarsa pada',
	'whitelisttablemodby' => 'Terakhir diubah oleh',
	'whitelisttablemodon' => 'Terakhir diubah pada',
	'whitelisttableedit' => 'Sunting',
	'whitelisttableview' => 'Lihat',
	'whitelisttablenewdate' => 'Tanggal baru:',
	'whitelisttablechangedate' => 'Ubah tanggal kadaluarsa',
	'whitelisttablesetedit' => 'Set ke sunting',
	'whitelisttablesetview' => 'Set ke lihat',
	'whitelisttableremove' => 'Hapus',
	'whitelistnewpagesfor' => 'Tambahkan halaman baru untuk daftar putih <b>$1</b><br />
Gunakan karakter kartu liar * atau %',
	'whitelistnewtabledate' => 'Tanggal kadaluarsa:',
	'whitelistnewtableedit' => 'Set ke sunting',
	'whitelistnewtableview' => 'Set ke lihat',
	'whitelistnowhitelistedusers' => 'Tidak ada pengguna dalam kelompok "{{MediaWiki:Group-restricted}}".
Anda harus [[Special:UserRights|menambahkan pengguna dalam kelompok itu]] sebelum Anda dapat menambahkan halaman ke daftar putih seorang pengguna.',
	'whitelistnewtableprocess' => 'Proses',
	'whitelistnewtablereview' => 'Tinjau',
	'whitelistselectrestricted' => '== Pilih nama pengguna yang dibatasi ==',
	'whitelistpagelist' => 'Halaman {{SITENAME}} untuk $1',
	'whitelistnocalendar' => "<font color='red' size=3>Tampaknya [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], prasyarat bagi ekstensi ini tidak terinstal dengan benar!</font>",
	'whitelistoverview' => '== Tinjauan perubahan untuk $1 ==',
	'whitelistoverviewcd' => "* Perubahan tanggal ke '''$1''' untuk [[:$2|$2]]",
	'whitelistoverviewsa' => "* Mengatur akses terhadap '''$1''' untuk [[:$2|$2]]",
	'whitelistoverviewrm' => '* Menghapus akses terhadap [[:$1|$1]]',
	'whitelistoverviewna' => "* Menambahkan [[:$1|$1]] ke daftar putih dengan akses '''$2''' dan '''$3'''",
	'whitelistrequest' => 'Minta akses ke lebih banyak halaman',
	'whitelistrequestmsg' => '$1 telah meminta akses ke {{PLURAL:$3|halaman|halaman}} berikut:

$2',
	'whitelistrequestconf' => 'Permintaan halaman baru telah dikirim ke $1',
	'whitelistnonrestricted' => "Pengguna '''$1''' bukanlah pengguna yang dibatasi.
Halaman ini hanya dapat diterapkan pada pengguna yang dibatasi",
	'whitelistnever' => 'tidak pernah',
	'whitelistnummatches' => '- {{PLURAL:$1|yang cocok|yang cocok}}',
	'right-editwhitelist' => 'Ubah daftar putih untuk pengguna yang ada',
	'right-restricttowhitelist' => 'Menyunting dan menampilkan halaman pada daftar putih saja',
	'action-editwhitelist' => 'mengubah daftar putih untuk pengguna yang ada',
	'action-restricttowhitelist' => 'menyunting dan menampilkan halaman pada daftar putih saja',
	'group-restricted' => 'Kelompok pengguna terbatas',
	'group-restricted-member' => 'Pengguna terbatas',
	'group-manager' => 'Kelompok manajer',
	'group-manager-member' => 'Manajer',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'whitelistnever' => 'aldrei',
);

/** Italian (Italiano)
 * @author Darth Kule
 * @author Marco 27
 * @author Melos
 */
$messages['it'] = array(
	'whitelistedit' => 'Editor della whitelist di accesso',
	'whitelistfor' => '<center>Informazioni correnti per <b>$1</b> </center>',
	'whitelisttablemodify' => 'Modifica',
	'whitelisttablemodifyall' => 'Tutti',
	'whitelisttablemodifynone' => 'Nessuno',
	'whitelisttablepage' => 'Pagina',
	'whitelisttabletype' => 'Livello di accesso',
	'whitelisttableexpires' => 'Scade il',
	'whitelisttablemodby' => 'Ultima modifica di',
	'whitelisttablemodon' => 'Ultima modifica il',
	'whitelisttableedit' => 'Modifica',
	'whitelisttableview' => 'Visualizzazione',
	'whitelisttablenewdate' => 'Nuova data:',
	'whitelisttablechangedate' => 'Cambia data di scadenza',
	'whitelisttablesetedit' => 'Imposta per la modifica',
	'whitelisttablesetview' => 'Imposta per la visualizzazione',
	'whitelisttableremove' => 'Rimuovi',
	'whitelistnewpagesfor' => 'Aggiungi nuove pagine alla whitelist di <b>$1</b><br />
Utilizza * o % come carattere jolly',
	'whitelistnewtabledate' => 'Data di scadenza:',
	'whitelistnewtableedit' => 'Imposta per la modifica',
	'whitelistnewtableview' => 'Imposta per la visualizzazione',
	'whitelistnowhitelistedusers' => 'Non ci sono utenti nel gruppo "{{MediaWiki:Group-restricted}}".
Devi [[Special:UserRights|aggiungere utenti al gruppo]] prima di poter aggiungere pagine alla whitelist di un utente.',
	'whitelistnewtablereview' => 'Cambia',
	'whitelistoverview' => '== Descrizione delle modifiche per $1 ==',
	'whitelistoverviewcd' => "* Modificata la data di scadenza a '''$1''' per [[:$2|$2]]",
	'whitelistoverviewsa' => "* Impostato l'accesso a '''$1''' per [[:$2|$2]]",
	'whitelistoverviewrm' => "* Rimosso l'accesso a [[:$1|$1]]",
	'whitelistoverviewna' => "* Aggiunta la pagina [[:$1|$1]] con livello di accesso '''$2''' e data di scadenza '''$3''' alla whitelist",
	'whitelistrequest' => "Richiedi l'accesso ad altre pagine",
	'whitelistrequestmsg' => "$1 ha richiesto l'accesso {{PLURAL:$3|alla seguente pagina|alle seguenti pagine}}:

$2",
	'whitelistrequestconf' => 'La richiesta di accesso a nuove pagine è stata inviata a $1',
	'whitelistnever' => 'mai',
	'whitelistnummatches' => '  - {{PLURAL:$1|una corrispondenza|$1 corrispondenze}}',
	'right-editwhitelist' => 'Modifica la whitelist per gli utenti esistenti',
	'right-restricttowhitelist' => 'Modifica e visualizza solo le pagine presenti nella whitelist',
	'action-editwhitelist' => 'modificare la whitelist per gli utenti esistenti',
	'action-restricttowhitelist' => 'modificare e visualizzare solo le pagine presenti nella whitelist',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'whitelist-desc' => '制限付利用者のアクセス権限を編集する',
	'whitelistedit' => 'ホワイトリストの編集',
	'whitelist' => 'ホワイトリスト掲載ページ',
	'mywhitelistpages' => '自分のページ',
	'whitelistfor' => '<center>現在の <b>$1</b> の情報</center>',
	'whitelisttablemodify' => '変更',
	'whitelisttablemodifyall' => 'すべて',
	'whitelisttablemodifynone' => 'なし',
	'whitelisttablepage' => 'ウィキページ',
	'whitelisttabletype' => 'アクセス種別',
	'whitelisttableexpires' => '期限',
	'whitelisttablemodby' => '最終変更者',
	'whitelisttablemodon' => '最終変更日',
	'whitelisttableedit' => '編集',
	'whitelisttableview' => '表示',
	'whitelisttablenewdate' => '新しい日付:',
	'whitelisttablechangedate' => '有効期限を変更',
	'whitelisttablesetedit' => '編集に設定',
	'whitelisttablesetview' => '表示に設定',
	'whitelisttableremove' => '削除',
	'whitelistnewpagesfor' => '新しいページを <b>$1</b> のホワイトリストに加える<br />
ワイルドカードとして * または % 記号を使います',
	'whitelistnewtabledate' => '有効期限:',
	'whitelistnewtableedit' => '編集に設定',
	'whitelistnewtableview' => '表示に設定',
	'whitelistnowhitelistedusers' => '「{{MediaWiki:Group-restricted}}」グループの利用者はいません。利用者のホワイトリストにページを追加できるようにするには、先に[[Special:UserRights|このグループに利用者を追加]]する必要があります。',
	'whitelistnewtableprocess' => '処理',
	'whitelistnewtablereview' => '検討',
	'whitelistselectrestricted' => '== 制限付利用者名の選択 ==',
	'whitelistpagelist' => '{{SITENAME}} の $1 用ページ',
	'whitelistnocalendar' => "<font color='red' size=3>本拡張機能の前提条件である、[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics] のインストールが正しく行われていないようです。</font>",
	'whitelistoverview' => '== $1 の変更の概要 ==',
	'whitelistoverviewcd' => "* [[:$2|$2]] の日付を'''$1'''に変更",
	'whitelistoverviewsa' => "* [[:$2|$2]] に '''$1''' へのアクセスを設定",
	'whitelistoverviewrm' => '* [[:$1|$1]] へのアクセスを除去',
	'whitelistoverviewna' => "* アクセス権限を'''$2'''し、期限切れを '''$3''' として、[[:$1|$1]]をホワイトリストに追加",
	'whitelistrequest' => 'ページへのアクセス追加を要望',
	'whitelistrequestmsg' => '$1 は次の{{PLURAL:$3|ページ}}へのアクセスを求めました:

$2',
	'whitelistrequestconf' => '新しいページの要望は $1 に送られました',
	'whitelistnonrestricted' => "利用者 '''$1''' は制限付利用者ではありません。このページは制限付利用者にのみ適用可能です",
	'whitelistnever' => '無期限',
	'whitelistnummatches' => ' - $1{{PLURAL:$1|件}}の一致',
	'right-editwhitelist' => '既存利用者用のホワイトリストを変更する',
	'right-restricttowhitelist' => 'ホワイトリストにあるページのみを編集および閲覧する',
	'action-editwhitelist' => '既存利用者用ホワイトリストの変更',
	'action-restricttowhitelist' => 'ホワイトリストにあるページのみの編集および閲覧',
	'group-restricted' => '制限付利用者',
	'group-restricted-member' => '制限付利用者',
	'group-manager' => 'マネージャー',
	'group-manager-member' => 'マネージャー',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'whitelist-desc' => "Sunting idin aksès saka panganggo kawates (''restricted'')",
	'whitelistedit' => 'Editor Aksès Daftar Putih',
	'whitelist' => 'Kaca-kaca Daftar Putih',
	'mywhitelistpages' => 'Kaca-kacaku',
	'whitelistfor' => '<center>Informasi saiki kanggo <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifikasi',
	'whitelisttablemodifyall' => 'Kabèh',
	'whitelisttablemodifynone' => 'Ora ana',
	'whitelisttablepage' => 'Kaca Wiki',
	'whitelisttabletype' => 'Jenis Aksès',
	'whitelisttableexpires' => 'Kadaluwarsa Ing',
	'whitelisttablemodby' => 'Pungkasan dimodifikasi déning',
	'whitelisttablemodon' => 'Pungkasan dimodifikasi ing',
	'whitelisttableedit' => 'Sunting',
	'whitelisttableview' => 'Ndeleng',
	'whitelisttablenewdate' => 'Tanggal Anyar:',
	'whitelisttablechangedate' => 'Ganti Tanggal Kadaluwarsa',
	'whitelisttablesetedit' => 'Sèt kanggo Nyunting',
	'whitelisttablesetview' => 'Sèt kanggo Ndeleng',
	'whitelisttableremove' => 'Busak',
	'whitelistnewpagesfor' => "Tambah kaca anyar menyang <b>$1's</b> white list<br />
Pigunakaké * apa % minangka karakter ''wildcard''",
	'whitelistnewtabledate' => 'Tanggal kadaluwarsa:',
	'whitelistnewtableedit' => 'Set kanggo Nyunting',
	'whitelistnewtableview' => 'Set kanggo Ndeleng',
	'whitelistnowhitelistedusers' => 'Ora ana panganggo ing klompok "{{MediaWiki:Group-restricted}}".
Panjenengan kudu [[Special:UserRights|nambahaké panganggo jroning klompok]] sadurungé bisa nambah kaca ing dhaptar-putih panganggo.',
	'whitelistnewtableprocess' => 'Prosès',
	'whitelistnewtablereview' => 'Priksa',
	'whitelistselectrestricted' => '== Sèlèksi Jeneng Panganggo Sing Diwatesi ==',
	'whitelistpagelist' => 'Kaca-kaca {{SITENAME}} kanggo $1',
	'whitelistnocalendar' => "<font color='red' size=3>Kaya-kaya [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], prasyarat kanggo èkstènsi iki, ora dipasang kanthi bener!</font>",
	'whitelistoverview' => '== Paninjoan amba owah-owahan kanggo $1 ==',
	'whitelistoverviewcd' => "* Ngowahi tanggal menyang '''$1''' kanggo [[:$2|$2]]",
	'whitelistoverviewsa' => "* Ngesèt aksès menyang '''$1''' kanggo [[:$2|$2]]",
	'whitelistoverviewrm' => '* Ngilangi aksès kanggo [[:$1|$1]]',
	'whitelistoverviewna' => "* Nambah [[:$1|$1]] jroning dhaptar-putih kanthi aksès '''$2''' lan '''$3''' tanggal daluwarsa",
	'whitelistrequest' => 'Nyuwun aksès ing luwih akèh kaca',
	'whitelistrequestmsg' => '$1 nyuwun aksès ing {{PLURAL:$3|kaca|kaca-kaca}} iki:

$2',
	'whitelistrequestconf' => 'Panyuwunan kaca-kaca anyar dikirimaké menyang $1',
	'whitelistnonrestricted' => "Panganggo '''$1''' dudu panganggo kawates.
Kaca iki mung kanggo panganggo kawates",
	'whitelistnever' => 'ora tau',
	'whitelistnummatches' => ' - {{PLURAL:$1|siji cocog|$1 cocog}}',
	'right-editwhitelist' => 'Owahi dhaptar-putih kanggo panganggo sing ana',
	'right-restricttowhitelist' => 'Sunting lan pirsani kaca mung ing dhaptar-putih waé',
	'action-editwhitelist' => 'owahi dhaptar-putih kanggo panganggo sing ana',
	'action-restricttowhitelist' => 'sunting lan pirsani kaca mung ing dhaptar-putih waé',
	'group-restricted' => 'Panganggo-panganggo kawates',
	'group-restricted-member' => 'Panganggo kawates',
	'group-manager' => 'Para manajer',
	'group-manager-member' => 'Manager',
);

/** Georgian (ქართული)
 * @author Temuri rajavi
 */
$messages['ka'] = array(
	'whitelisttableedit' => 'რედაქტირება',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'whitelist-desc' => 'កែប្រែ​សិទ្ធិចូលដំណើរការ​នៃ​អ្នកប្រើប្រាស់​ដែល​ត្រូវ​បាន​កម្រិត​។',
	'whitelist' => 'ទំព័រ​បញ្ជី​ស',
	'mywhitelistpages' => 'ទំព័ររបស់ខ្ញុំ',
	'whitelistfor' => '<center>ព័ត៌មាន​បច្ចុប្បន្ន​សម្រាប់ <b>$1</b></center>',
	'whitelisttablemodify' => 'កែសម្រួល',
	'whitelisttablemodifyall' => 'ទាំងអស់',
	'whitelisttablemodifynone' => 'ទទេ',
	'whitelisttablepage' => 'ទំព័រវិគី',
	'whitelisttableexpires' => 'ផុតកំណត់នៅថ្ងៃទី',
	'whitelisttablemodby' => 'កែសំរួលចុងក្រោយដោយ',
	'whitelisttablemodon' => 'កែសម្រួលចុងក្រោយនៅ',
	'whitelisttableedit' => 'កែប្រែ',
	'whitelisttableview' => 'មើល',
	'whitelisttablenewdate' => 'កាលបរិច្ឆេទថ្មី៖',
	'whitelisttablechangedate' => 'ផ្លាស់ប្តូរកាលបរិច្ឆេទផុតកំណត់',
	'whitelisttablesetedit' => 'កំណត់​ដើម្បី​កែប្រែ',
	'whitelisttablesetview' => 'កំណត់​ដើម្បី​មើល',
	'whitelisttableremove' => 'ដកចេញ',
	'whitelistnewpagesfor' => 'ចូរ​បន្ថែម​ទំព័រ​ថ្មី​ទៅ​ក្នុង​បញ្ជី​ស​នៃ <b>$1</b><br />
ចូរ​ប្រើប្រាស់​មួយណា​ក៏បាន * ឬ % ជា​តួអក្សរជំនួស',
	'whitelistnewtabledate' => 'កាលបរិច្ឆេទផុតកំណត់៖',
	'whitelistnewtableedit' => 'កំណត់​ដើម្បី​កែប្រែ',
	'whitelistnewtableview' => 'កំណត់​ដើម្បី​មើល',
	'whitelistnowhitelistedusers' => 'មិនមាន​អ្នកប្រើប្រាស់​នៅ​ក្នុង​ក្រុម "{{MediaWiki:Group-restricted}}" ទេ​។
អ្នក​ត្រូវតែ​[[Special:UserRights|បន្ថែម​អ្នកប្រើប្រាស់​ទៅ​ក្នុង​ក្រុម]] មុនពេលដែល​អ្នក​អាច​បន្ថែម​ទំព័រ​នានា ចូល​ទៅ​ក្នុង​បញ្ជី​ស​របស់​អ្នកប្រើប្រាស់​ណាម្នាក់​។',
	'whitelistnewtableprocess' => 'ដំណើរការ',
	'whitelistnewtablereview' => 'ពិនិត្យឡើងវិញ',
	'whitelistselectrestricted' => '== ជ្រើសយក​ឈ្មោះ​អ្នកប្រើប្រាស់​ដែល​ត្រូវ​បាន​កម្រិត ==',
	'whitelistpagelist' => 'ទំព័រ{{SITENAME}}សម្រាប់ $1',
	'whitelistoverview' => '== ទិដ្ឋភាពទូទៅ​នៃ​បំលាស់ប្ដូរ​សម្រាប់ $1 ==',
	'whitelistoverviewcd' => "* ប្ដូរ​កាលបរិច្ឆេទ​ទៅ '''$1''' សម្រាប់ [[:$2|$2]]",
	'whitelistoverviewsa' => "* កំណត់​ការចូលដំណើរការ​ចំពោះ '''$1''' សម្រាប់ [[:$2|$2]]",
	'whitelistoverviewrm' => '* ដកចេញ​ការចូលដំណើការ​ចំពោះ [[:$1|$1]]',
	'whitelistoverviewna' => "* បន្ថែម [[:$1|$1]] ចូលទៅក្នុង​បញ្ជីស​ជាមួយ​ការចូលដំណើរការ '''$2''' និង '''$3''' កាលបរិច្ឆេទ​ដែលផុតកំណត់",
	'whitelistrequest' => 'ស្នើ​ឱ្យ​ចូលដំណើរការ​ចំពោះ​ទំព័រ​បន្ថែមទៀត',
	'whitelistrequestmsg' => '$1 ត្រូវ​បាន​ស្នើ​ឱ្យ​ចូលដំណើរការ​ចំពោះ {{PLURAL:$3|ទំព័រ|ទំព័រ}}​ដូចតទៅ:

$2',
	'whitelistrequestconf' => 'សំណើ​សម្រាប់​ទំព័រ​ថ្មីៗ​ត្រូវ​បាន​ផ្ញើទៅ $1 ហើយ',
	'whitelistnonrestricted' => "អ្នកប្រើប្រាស់ '''$1'' ពុំមែន​ជា​អ្នកប្រើប្រាស់​ដែលត្រូវបានកម្រិត​ទេ​។
ទំព័រ​នេះ​អាច​អនុវត្ត​បាន​សម្រាប់​តែ​អ្នកប្រើប្រាស់​ដែលត្រូវបានកម្រិត​ប៉ុណ្ណោះ​។",
	'whitelistnever' => 'មិនដែល',
	'right-editwhitelist' => 'កែប្រែ​បញ្ជីស​សម្រាប់​អ្នកប្រើប្រាស់​ដែល​មាន​ស្រាប់',
	'right-restricttowhitelist' => 'កែប្រែ និង​បង្ហាញ​ទំព័រ​នានា​នៅ​លើ​បញ្ជីស​ប៉ុណ្ណោះ',
	'action-editwhitelist' => 'កែប្រែ​បញ្ជីស​សម្រាប់​អ្នកប្រើប្រាស់​ដែល​មាន​ស្រាប់',
	'action-restricttowhitelist' => 'កែប្រែ និង​បង្ហាញ​ទំព័រ​នានា​នៅ​លើ​បញ្ជីស​ប៉ុណ្ណោះ',
	'group-restricted' => 'អ្នកប្រើប្រាស់​ដែលត្រូវបានកម្រិត​នានា',
	'group-restricted-member' => 'អ្នកប្រើប្រាស់​ដែលត្រូវបានកម្រិត',
	'group-manager' => 'អ្នកគ្រប់គ្រង​នានា',
	'group-manager-member' => 'អ្នកគ្រប់គ្រង',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'whitelisttableedit' => 'Chenj',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'whitelisttableedit' => 'Iislan',
	'whitelistnever' => 'Indi gid',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'whitelist-desc' => 'De Zohjangs-Rääschte fun beschrängkte Metmaachere Ändere.',
	'whitelistedit' => '<i lang="en">whitelist</i> Zohjang Ändere',
	'whitelist' => '<i lang="en">whitelist</i> Sigge',
	'mywhitelistpages' => 'Ming Sigge',
	'whitelistfor' => '<center>Aktoelle Enfomazjuhne för <b>$1</b></center>',
	'whitelisttablemodify' => 'Ändere',
	'whitelisttablemodifyall' => 'All Ändere',
	'whitelisttablemodifynone' => 'Nix Ändere',
	'whitelisttablepage' => 'Sigg em Wiki',
	'whitelisttabletype' => 'Zohjangs-Aat',
	'whitelisttableexpires' => 'Läuf us am',
	'whitelisttablemodby' => 'Zoletz jändert fum',
	'whitelisttablemodon' => 'Zoletz jändert aam',
	'whitelisttableedit' => 'Ändere',
	'whitelisttableview' => 'Aanloore',
	'whitelisttablenewdate' => 'Neu Dattum:',
	'whitelisttablechangedate' => 'Ußlouf-Dattum ändere',
	'whitelisttablesetedit' => 'Beärrbeide',
	'whitelisttablesetview' => 'Aanlore',
	'whitelisttableremove' => 'Fottnämme',
	'whitelistnewpagesfor' => 'Neu Sigge en däm „<b>$1</b>“ sing <i lang="en">whitelist</i> erin don<br />
Donn entweder <b>*</b> udder <b>%</b> als en Platzhallder nämme för „<i>mer weße nit wi fill, un mer weße nit, wat för Zeiche</i>“',
	'whitelistnewtabledate' => 'Ußloufdattum:',
	'whitelistnewtableedit' => 'Beärbeide',
	'whitelistnewtableview' => 'Aanloore',
	'whitelistnowhitelistedusers' => 'En dä Jrupp „{{MediaWiki:Group-restricted}}“ sen kei Metmaacher dren.
Dö moß [[Special:UserRights|Metmaacher en de Jrupp donn]], ih dat De
Sigge en de Oppaßleß fun esu enem Metmaacher don kanns.',
	'whitelistnewtableprocess' => 'Beärbeide',
	'whitelistnewtablereview' => 'Övverpröfe',
	'whitelistselectrestricted' => '== Enjeschränkte Metmaacher-Name ußsöke ==',
	'whitelistpagelist' => '{{SITENAME}} Sigge för $1',
	'whitelistnocalendar' => '<font color=\'red\' size=3>Dä [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Zosatz <i lang="en">UsageStatistics</i>], weed för der [http://www.mediawiki.org/wiki/Extension:WhiteList Zosatz  <i lang="en">WhiteList</i>] jebruch, eß ävver nit enstalleett, udder wood nit jefonge!</font>',
	'whitelistoverview' => '== Änderunge — Övverseech för $1 ==',
	'whitelistoverviewcd' => "* Änder dat Dattum för [[:$2|$2]] op '''$1'''",
	'whitelistoverviewsa' => "* Änder der Zojreff för [[:$2|$2]] op '''$1'''",
	'whitelistoverviewrm' => '* Dä Zojreff för [[:$1|$1]] flüch eruß',
	'whitelistoverviewna' => "* Donn [[:\$1|\$1]] en de <i lang=\"en\">whitelist</i> met Zojreff '''\$2''' un Ußlouf-Dattum '''\$3'''",
	'whitelistrequest' => 'Noh em Zojreff op mieh Sigge froore',
	'whitelistrequestmsg' => 'Dä Metmaacher $1 hät noh em Zohjang jefrooch för {{PLURAL:$3|de Sigg|de Sigge|kei Sigg}}:

$2',
	'whitelistrequestconf' => 'De Aanfroch fun wäje dä neu Sigge wood aan dä $1 jescheck',
	'whitelistnonrestricted' => "Dä Metmaacher '''$1''' es nit beschränk.
Di Sigg hee is nor för beschränkte Metmaacher ze bruche.",
	'whitelistnever' => 'nimohls',
	'whitelistnummatches' => ' - {{PLURAL:$1|ein zopaß Sigg|$1 zopaß Sigge|keine zopaß Sigg}}',
	'right-editwhitelist' => 'De <i lang="en">whitelist</i> för de vörhande Metmaacher ändere',
	'right-restricttowhitelist' => 'Nur Sigge en de <i lang="en">whitelist</i> aanloore un ändere',
	'action-editwhitelist' => 'de <i lang="en">whitelist</i> för de vörhande Metmaacher ändere',
	'action-restricttowhitelist' => 'nur Sigge en de <i lang="en">whitelist</i> aanloore un ändere',
	'group-restricted' => 'beschrängkte Metmaachere',
	'group-restricted-member' => 'beschrängkte Metmaacher',
	'group-manager' => 'Verwalldere',
	'group-manager-member' => 'Verwallder',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'whitelist-desc' => "Ännert d'Rechter vu Benotzer mat limitéierte Rechter",
	'whitelist' => "''Whiteliste''-Säiten",
	'mywhitelistpages' => 'Meng Säiten',
	'whitelistfor' => '<center>Aktuell Informatioun fir <b>$1</b></center>',
	'whitelisttablemodify' => 'Änneren',
	'whitelisttablemodifyall' => 'All',
	'whitelisttablemodifynone' => 'Näischt',
	'whitelisttablepage' => 'Wiki Säit',
	'whitelisttableexpires' => 'bis den',
	'whitelisttablemodby' => "Fir d'läscht geännert vum",
	'whitelisttablemodon' => "Fir d'läscht geännert de(n)",
	'whitelisttableedit' => 'Änneren',
	'whitelisttableview' => 'Weisen',
	'whitelisttablenewdate' => 'Neien Datum:',
	'whitelisttablechangedate' => 'Oflafdatum änneren',
	'whitelisttablesetedit' => 'Ännerungsparameter',
	'whitelisttablesetview' => 'Weisen aschalten',
	'whitelisttableremove' => 'Zréckzéien',
	'whitelistnewtabledate' => 'Oflafdatum:',
	'whitelistnewtableedit' => 'Ännerungsparameter',
	'whitelistnewtableview' => 'Weisen aschalten',
	'whitelistnowhitelistedusers' => 'Et gëtt keng Benotzer am Grupp "{{MediaWiki:Group-restricted}}".
Dir musst [[Special:UserRights|Benotzer an de Grupp derbäisetzen]] ier Dir Säiten anengem Benotzer seng white list derbäisetze kënnt.',
	'whitelistnewtableprocess' => 'Verschaffen',
	'whitelistnewtablereview' => 'Nokucken',
	'whitelistselectrestricted' => '== Limitéierte Benotzernumm wielen ==',
	'whitelistpagelist' => 'Säite vu(n) {{SITENAME}} fir $1',
	'whitelistnocalendar' => "<font color='red' size=3>Et gesäit aus wéi wann d'[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Erweiderung:Benotzerstatistiken], eng Viraussetzung fir dës Erweiderung, net richteg instqaléiert ass!</font>",
	'whitelistoverview' => '== Iwwersiicht vun den Ännerunge vun $1 ==',
	'whitelistoverviewcd' => "* Datum vun '''$1''' ännere fir [[:$2|$2]]",
	'whitelistoverviewsa' => "* Autorisatioun vum '''$1''' op [[:$2|$2]] astellen",
	'whitelistoverviewrm' => '* Autorisatioun fir [[:$1|$1]] gët ewechgeholl',
	'whitelistrequest' => 'Zougang zu méi Säite froen',
	'whitelistrequestmsg' => '$1 huet Zougrëff op dës {{PLURAL:$3|Säit|Säite}} gfrot:

$2',
	'whitelistrequestconf' => "D'Ufro fir nei Säite gouf geschéckt un $1",
	'whitelistnonrestricted' => "De Benotzer '''$1''' ass kee limitéierte Benotzer.
Dës Säit ass nëmme valabel fir limitéiert Benotzer.",
	'whitelistnever' => 'nie',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|Resultat|Resultater}}',
	'right-restricttowhitelist' => 'Nëmme Säiten déi op der wäisser Lëscht stinn kucken an änneren',
	'action-restricttowhitelist' => 'Nëmme Säiten déi op der wäisser Lëscht sti kucken an änneren',
	'group-restricted' => 'Limitéiert Benotzer',
	'group-restricted-member' => 'Limitéierte Benotzer',
	'group-manager' => 'Manager',
	'group-manager-member' => 'Manager',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'mywhitelistpages' => 'Мыйын лаштык-влак',
	'whitelistnever' => 'нигунам',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'whitelist-desc' => 'Менување на дозволите за пристап на ограничени корисници',
	'whitelistedit' => 'Уредник на пристап на белата листа',
	'whitelist' => 'Страници на белата листа',
	'mywhitelistpages' => 'Мои страници',
	'whitelistfor' => '<center>Моментални информации за <b>$1</b></center>',
	'whitelisttablemodify' => 'Измени',
	'whitelisttablemodifyall' => 'Сите',
	'whitelisttablemodifynone' => 'Никој',
	'whitelisttablepage' => 'Вики страница',
	'whitelisttabletype' => 'Тип на пристап',
	'whitelisttableexpires' => 'Истекува на',
	'whitelisttablemodby' => 'Последен пат изменето од',
	'whitelisttablemodon' => 'Последен пат изменето на',
	'whitelisttableedit' => 'Уреди',
	'whitelisttableview' => 'Преглед',
	'whitelisttablenewdate' => 'Нов датум:',
	'whitelisttablechangedate' => 'Промени датум на истекување',
	'whitelisttablesetedit' => 'Постави за уредување',
	'whitelisttablesetview' => 'Постави за преглед',
	'whitelisttableremove' => 'Отстрани',
	'whitelistnewpagesfor' => "Додај нови страници во белата листа<b>$1's</b><br />
Користете  * или % како џокер",
	'whitelistnewtabledate' => 'Истекува:',
	'whitelistnewtableedit' => 'Постави за уредување',
	'whitelistnewtableview' => 'Постави за преглед',
	'whitelistnowhitelistedusers' => 'Нема корисници во групата „{{MediaWiki:Group-restricted}}“.
Пред да можете да додавате страници кон белата листа на корисникот ќе морате да [[Special:UserRights|додадете корисници во групата]].',
	'whitelistnewtableprocess' => 'Процес',
	'whitelistnewtablereview' => 'Проверка',
	'whitelistselectrestricted' => '== Одберете корисничко име ==',
	'whitelistpagelist' => 'Страници за $1 на {{SITENAME}}',
	'whitelistnocalendar' => "<font color='red' size=3>Изгледа дека [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics] не е инсталирано како што треба, а од него зависи проширувањето.</font>",
	'whitelistoverview' => '== Преглед на промени за $1 ==',
	'whitelistoverviewcd' => "* Промена на датум на '''$1''' за [[:$2|$2]]",
	'whitelistoverviewsa' => "* Додели пристап на '''$1''' за [[:$2|$2]]",
	'whitelistoverviewrm' => '* Одземи пристап на [[:$1|$1]]',
	'whitelistoverviewna' => "* Го додавам корисникот [[:$1|$1]] на белста листа со пристап '''$2''' и датум на истекување '''$3'''",
	'whitelistrequest' => 'Побарај пристап до повеќе страници',
	'whitelistrequestmsg' => '$1 побара пристап до {{PLURAL:$3|следнава страница|следниве страници}}:

$2',
	'whitelistrequestconf' => 'Барањето за нови страници е испратено на $1',
	'whitelistnonrestricted' => "Корисникот '''$1''' не е ограничен корисник.
Оваа страница важи само за ограничени корисници",
	'whitelistnever' => 'никогаш',
	'whitelistnummatches' => '- {{PLURAL:$1|едно совпаѓање|$1 совпаѓања}}',
	'right-editwhitelist' => 'Менување на белата листа за постоечки корисници',
	'right-restricttowhitelist' => 'Уредување и прегледување страници само на белата листа',
	'action-editwhitelist' => 'менување на белата листа за постоечки корисници',
	'action-restricttowhitelist' => 'уредувај и прегледувај само страници на белата листа',
	'group-restricted' => 'Ограничени корисници',
	'group-restricted-member' => 'Ограничен корисник',
	'group-manager' => 'Раководители',
	'group-manager-member' => 'Раководител',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'mywhitelistpages' => 'എന്റെ താളുകള്‍',
	'whitelisttablemodify' => 'തിരുത്തുക',
	'whitelisttablemodifyall' => 'എല്ലാം',
	'whitelisttablemodifynone' => 'ഒന്നുമില്ല',
	'whitelisttablepage' => 'വിക്കി താള്‍',
	'whitelisttableexpires' => 'കാലാവധി തീരുന്നത്',
	'whitelisttablemodby' => 'അവസാനമായി മാറ്റങ്ങള്‍ വരുത്തിയത്',
	'whitelisttablemodon' => 'അവസാനമായി മാറ്റങ്ങള്‍ വരുത്തിയ സമയം',
	'whitelisttableedit' => 'തിരുത്തുക',
	'whitelisttableview' => 'കാണുക',
	'whitelisttablenewdate' => 'പുതിയ തീയ്യതി:',
	'whitelisttablechangedate' => 'കാലാവധിയില്‍ മാറ്റം വരുത്തുക',
	'whitelisttablesetedit' => 'തിരുത്താനായി സജ്ജീകരിക്കുക',
	'whitelisttablesetview' => 'കാണാനായി സജ്ജീകരിക്കുക',
	'whitelisttableremove' => 'നീക്കം ചെയ്യുക',
	'whitelistnewtabledate' => 'കാലാവധി തീരുന്ന തീയ്യതി:',
	'whitelistnewtableedit' => 'തിരുത്താനായി സജ്ജീകരിക്കുക',
	'whitelistnewtableview' => 'കാണാനായി സജ്ജീകരിക്കുക',
	'whitelistnewtableprocess' => 'പ്രക്രിയ',
	'whitelistnewtablereview' => 'സം‌ശോധനം',
	'whitelistpagelist' => '{{SITENAME}} സം‌രംഭത്തില്‍ $1ന്റെ താളുകള്‍',
	'whitelistnever' => 'ഒരിക്കലും അരുത്:',
	'whitelistnummatches' => '- {{PLURAL:$1|ഒരു പൊരുത്തം|$1 പൊരുത്തങ്ങൾ}}',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'mywhitelistpages' => 'माझी पाने',
	'whitelistfor' => '<center><b>$1</b>बद्दलची सध्याची माहिती</center>',
	'whitelisttablemodify' => 'बदला',
	'whitelisttablemodifyall' => 'सर्व',
	'whitelisttablemodifynone' => 'काहीही नाही',
	'whitelisttablepage' => 'विकि पान',
	'whitelisttabletype' => 'ऍक्सेस प्रकार',
	'whitelisttableexpires' => 'समाप्ती',
	'whitelisttableedit' => 'संपादन',
	'whitelisttableview' => 'पहा',
	'whitelisttablenewdate' => 'नवीन तारीख:',
	'whitelisttablechangedate' => 'समाप्तीची तारीख बदला',
	'whitelisttableremove' => 'काढा',
	'whitelistnewtabledate' => 'समाप्तीची तारीख:',
	'whitelistnewtableprocess' => 'कार्य',
	'whitelistnewtablereview' => 'समीक्षण',
	'whitelistpagelist' => '{{SITENAME}} पाने $1 साठीची',
	'whitelistrequest' => 'अधिक पानांकरिता उपलब्धता सुसाध्य करून मागा',
	'whitelistrequestmsg' => '$1ने निम्ननिर्देशित पानांकरिता सुलभमार्ग सुसाध्य करून मागितला आहे:

$2',
	'whitelistrequestconf' => 'नवीन पानांची मागणी $1 ला पाठविलेली आहे',
	'whitelistnonrestricted' => "सदस्य '''$1''' हा प्रतिबंधित सदस्य नाही.
हे पान फक्त प्रतिबंधित सदस्यांसाठीच आहे",
	'whitelistnever' => 'कधीही नाही',
	'whitelistnummatches' => ' - $1 जुळण्या',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'mywhitelistpages' => 'Il-paġni tiegħi',
	'whitelisttablemodifyall' => 'Kollha',
	'whitelisttablepage' => 'Paġna wiki',
	'whitelisttablenewdate' => 'Data ġdida:',
	'whitelistnewtableprocess' => 'Proċess',
	'whitelistnever' => 'qatt',
	'group-restricted' => 'Utenti ristretti',
	'group-restricted-member' => 'Utent ristrett',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'mywhitelistpages' => 'Монь лопан',
	'whitelisttablemodifyall' => 'Весе',
	'whitelisttablepage' => 'Вики лопа',
	'whitelisttableremove' => 'Нардык',
	'whitelistnever' => 'зярдояк',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'whitelist' => 'Mochi iztāc zāzanilli',
	'mywhitelistpages' => 'Nozāzanil',
	'whitelisttablemodify' => 'Ticpatlāz',
	'whitelisttablemodifyall' => 'Mochīntīn',
	'whitelisttablemodifynone' => 'Ahtlein',
	'whitelisttablepage' => 'Huiqui zāzanilli',
	'whitelisttableexpires' => 'Motlamīz īpan',
	'whitelisttableedit' => 'Ticpatlāz',
	'whitelisttableview' => 'Tiquittāz',
	'whitelistnewtabledate' => 'Motlamīz īpan:',
	'whitelistnewtablereview' => 'Ticceppahuīz',
	'whitelistnever' => 'aīcmah',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'whitelisttablemodify' => 'Ännern',
	'whitelisttablemodifyall' => 'All',
	'whitelisttablemodifynone' => 'Keen',
	'whitelisttablepage' => 'Wikisied',
	'whitelisttableedit' => 'Ännern',
	'whitelistnever' => 'nie',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'whitelisttableedit' => 'Bewark',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'whitelist-desc' => 'Toegangsrechten voor gebruikers met beperkte rechten bewerken',
	'whitelistedit' => 'Toegang via witte lijst',
	'whitelist' => "Pagina's op de witte lijst",
	'mywhitelistpages' => "Mijn pagina's",
	'whitelistfor' => '<center>Huidige informatie voor <b>$1<b></center>',
	'whitelisttablemodify' => 'Bewerken',
	'whitelisttablemodifyall' => 'Alle',
	'whitelisttablemodifynone' => 'Geen',
	'whitelisttablepage' => 'Wikipagina',
	'whitelisttabletype' => 'Toegangstype',
	'whitelisttableexpires' => 'Vervalt op',
	'whitelisttablemodby' => 'Laatste bewerking door',
	'whitelisttablemodon' => 'Laatste wijziging op',
	'whitelisttableedit' => 'Bewerken',
	'whitelisttableview' => 'Bekijken',
	'whitelisttablenewdate' => 'Nieuwe datum:',
	'whitelisttablechangedate' => 'Vervaldatum bewerken',
	'whitelisttablesetedit' => 'Op bewerken instellen',
	'whitelisttablesetview' => 'Op bekijken instellen',
	'whitelisttableremove' => 'Verwijderen',
	'whitelistnewpagesfor' => "Nieuwe pagina's aan de witte lijst voor <b>$1</b> toevoegen<br />
Gebruik * of % als wildcard",
	'whitelistnewtabledate' => 'Vervaldatum:',
	'whitelistnewtableedit' => 'Op bewerken instellen',
	'whitelistnewtableview' => 'Op bekijken instellen',
	'whitelistnowhitelistedusers' => 'Er zijn geen gebruikers die lid zijn van de groep "{{MediaWiki:Group-restricted}}".
U moet [[Special:UserRights|gebruikers aan de groep toevoegen]] voordat u pagina\'s kunt toevoegen aan de witte lijst voor een gebruiker.',
	'whitelistnewtableprocess' => 'Bewerken',
	'whitelistnewtablereview' => 'Controleren',
	'whitelistselectrestricted' => '== Gebruiker met beperkingen selecteren ==',
	'whitelistpagelist' => "{{SITENAME}} pagina's voor $1",
	'whitelistnocalendar' => "<font color='red' size=3>[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], een voorwaarde voor deze uitbreiding, lijkt niet juist geïnstalleerd!</font>",
	'whitelistoverview' => '== Overzicht van wijzigingen voor $1 ==',
	'whitelistoverviewcd' => "* vervaldatum gewijzigd naar '''$1''' voor [[:$2|$2]]",
	'whitelistoverviewsa' => "* toegangstype '''$1''' ingesteld voor [[:$2|$2]]",
	'whitelistoverviewrm' => '* toegang voor [[:$1|$1]] wordt verwijderd',
	'whitelistoverviewna' => "* [[:$1|$1]] wordt toegevoegd aan de witte lijst met toegangstype '''$2''' en vervaldatum '''$3'''",
	'whitelistrequest' => "Toegang tot meer pagina's vragen",
	'whitelistrequestmsg' => "$1 heeft toegang gevraagd tot de volgende {{PLURAL:$3|pagina|pagina's}}:

$2",
	'whitelistrequestconf' => "Het verzoek voor nieuwe pagina's is verzonden naar $1",
	'whitelistnonrestricted' => "Gebruiker '''$1''' is geen gebruiker met beperkte rechten.
Deze pagina is alleen van toepassing op gebruikers met beperkte rechten.",
	'whitelistnever' => 'nooit',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|resultaat|resultaten}}',
	'right-editwhitelist' => 'De witte lijst voor bestaande gebruikers aanpassen',
	'right-restricttowhitelist' => "Alleen pagina's bekijken en bewerken die op de witte lijst staan",
	'action-editwhitelist' => 'de witte lijst voor bestaande gebruikers aan te passen',
	'action-restricttowhitelist' => "alleen pagina's te bekijken en te bewerken die op de witte lijst staan",
	'group-restricted' => 'beperkte gebruikers',
	'group-restricted-member' => 'beperkte gebruiker',
	'group-manager' => 'managers',
	'group-manager-member' => 'gebruiker',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'whitelist-desc' => 'Endring tilgangsrettar for avgrensa brukarar',
	'whitelistedit' => 'Endring av rettar for kvitliste',
	'whitelist' => 'Kvitelista sider',
	'mywhitelistpages' => 'Mine sider',
	'whitelistfor' => '<center>Noverande informasjon for <b>$1</b></center>',
	'whitelisttablemodify' => 'Endre',
	'whitelisttablemodifyall' => 'Alle',
	'whitelisttablemodifynone' => 'Ingen',
	'whitelisttablepage' => 'Wikiside',
	'whitelisttabletype' => 'Tilgangstype',
	'whitelisttableexpires' => 'Endar',
	'whitelisttablemodby' => 'Sist endra av',
	'whitelisttablemodon' => 'Sist endra',
	'whitelisttableedit' => 'Endre',
	'whitelisttableview' => 'Vis',
	'whitelisttablenewdate' => 'Ny dato:',
	'whitelisttablechangedate' => 'Endre utgangsdato',
	'whitelisttablesetedit' => 'Sett til redigering',
	'whitelisttablesetview' => 'Sett til vising',
	'whitelisttableremove' => 'Fjern',
	'whitelistnewpagesfor' => 'Legg til nye sider på kvitelista til <b>$1</b><br />Bruk anten * eller % som jokerteikn',
	'whitelistnewtabledate' => 'Utgangsdato:',
	'whitelistnewtableedit' => 'Sett til redigering',
	'whitelistnewtableview' => 'Sett til vising',
	'whitelistnowhitelistedusers' => 'Det finst ingen brukarar i gruppa «{{MediaWiki:Group-restricted}}».
Du må [[Special:UserRights|legge brukarar til gruppa]] før du kan legge sider til ein brukar si kviteliste.',
	'whitelistnewtableprocess' => 'Handsam',
	'whitelistnewtablereview' => 'Gå gjennom',
	'whitelistselectrestricted' => '== Gje namn på avgrensa brukar ==',
	'whitelistpagelist' => '{{SITENAME}}-sider for $1',
	'whitelistnocalendar' => '<font color="red" size="3">Det virkar som om [http://mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], ein føresetnad for denne utvidinga, ikkje har vorte installert skikkeleg.</font>',
	'whitelistoverview' => '== Oversikt over endringar for $1 ==',
	'whitelistoverviewcd' => "* Endrar dato for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewsa' => "* Set tilgang for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewrm' => '* Fjernar tilgang til [[:$1|$1]]',
	'whitelistoverviewna' => "* Legg til [[:$1|$1]] til kviteliste med tilgang '''$2''' og utløpsdato '''$3'''.",
	'whitelistrequest' => 'Spør etter tilgang til fleire sider',
	'whitelistrequestmsg' => '$1 har etterspurt tilgang til følgjande {{PLURAL:$3|sida|sider}}:

$2',
	'whitelistrequestconf' => 'Etterspurnad om nye sider vart sendt til $1',
	'whitelistnonrestricted' => "'''$1''' er ikkje ein avgrensa brukar.
Denne sida kan berre nyttast på avgrensa brukarar.",
	'whitelistnever' => 'aldri',
	'whitelistnummatches' => '  - $1 {{PLURAL:$1|treff}}',
	'right-editwhitelist' => 'Endre kvitelista for eksisterande brukarar',
	'right-restricttowhitelist' => 'Endre og sjå sider som berre er på kvitelista',
	'action-editwhitelist' => 'endre kvitelista for eksisterande brukarar',
	'action-restricttowhitelist' => 'endre og sjå sider som berre er på kvitelista',
	'group-restricted' => 'Avgrensa brukarar',
	'group-restricted-member' => 'Avgrensa brukar',
	'group-manager' => 'Handsamarar',
	'group-manager-member' => 'Handsamar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Audun
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'whitelist-desc' => 'Redigering av tilgangsrettigheter for begrensede brukere',
	'whitelistedit' => 'Rettighetsredigering for hvitliste',
	'whitelist' => 'Hvitelistede sider',
	'mywhitelistpages' => 'Mine sider',
	'whitelistfor' => '<center>Nåværende informasjon for <b>$1</b></center>',
	'whitelisttablemodify' => 'Endre',
	'whitelisttablemodifyall' => 'Alle',
	'whitelisttablemodifynone' => 'Ingen',
	'whitelisttablepage' => 'Wikiside',
	'whitelisttabletype' => 'Tilgangstype',
	'whitelisttableexpires' => 'Utgår',
	'whitelisttablemodby' => 'Sist endret av',
	'whitelisttablemodon' => 'Sist endret',
	'whitelisttableedit' => 'Rediger',
	'whitelisttableview' => 'Vis',
	'whitelisttablenewdate' => 'Ny dato:',
	'whitelisttablechangedate' => 'Endre utgangsdato',
	'whitelisttablesetedit' => 'Sett til redigering',
	'whitelisttablesetview' => 'Sett til visning',
	'whitelisttableremove' => 'Fjern',
	'whitelistnewpagesfor' => 'Legg til nye sider på hvitelisten til <b>$1</b><br />Bruk enten * eller % som jokertegn',
	'whitelistnewtabledate' => 'Utgangsdato:',
	'whitelistnewtableedit' => 'Sett til redigering',
	'whitelistnewtableview' => 'Sett til visning',
	'whitelistnowhitelistedusers' => 'Det finnes ingen brukere i gruppen «{{MediaWiki:Group-restricted}}».
Du må [[Special:UserRights|legge brukere til gruppen]] før du kan legge til sider til en brukers hvitliste.',
	'whitelistnewtableprocess' => 'Prosess',
	'whitelistnewtablereview' => 'Gå gjennom',
	'whitelistselectrestricted' => '== ANgi navn på begrenset bruker ==',
	'whitelistpagelist' => '{{SITENAME}}-sider for $1',
	'whitelistnocalendar' => '<font color="red" size="3">Det virker som om [http://mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], en forutsetning for denne utvidelsen, ikke har blitt installert ordentlig.</font>',
	'whitelistoverview' => '== Oversikt over endringer for $1 ==',
	'whitelistoverviewcd' => "* Endrer dato for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewsa' => "* Setter tilgang for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewrm' => '* Fjerner tilgang til [[:$1|$1]]',
	'whitelistoverviewna' => "* Legger til [[:$1|$1]] til hviteliste med tilgang '''$2''' og utløpsdato '''$3'''.",
	'whitelistrequest' => 'Etterspør tilgang til flere sider',
	'whitelistrequestmsg' => '$1 har etterspurt tilgang til følgende {{PLURAL:$3|side|sider}}:

$2',
	'whitelistrequestconf' => 'Etterspørsel om nye sider har blitt sendt til $1',
	'whitelistnonrestricted' => "'''$1''' er ikke en begrenset bruker.
Denne siden kan kun brukes på begrensede brukere.",
	'whitelistnever' => 'aldri',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|treff}}',
	'right-editwhitelist' => 'Endre hvitlisten for eksisterende brukere',
	'right-restricttowhitelist' => 'Endre og vis sider som bare er på hvitlisten',
	'action-editwhitelist' => 'endre hvitlisten for eksisterende brukere',
	'action-restricttowhitelist' => 'endre og vis sider som bare er på hvitlisten',
	'group-restricted' => 'Begrensede brukere',
	'group-restricted-member' => 'Begrenset bruker',
	'group-manager' => 'Håndterere',
	'group-manager-member' => 'Håndterer',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'whitelist-desc' => 'Modifica las permissions d’accès dels utilizaires de poders restrenches',
	'whitelistedit' => 'Editor de la lista blanca dels accèsses',
	'whitelist' => 'Paginas de listas blancas',
	'mywhitelistpages' => 'Mas paginas',
	'whitelistfor' => '<center>Entresenhas actualas per <b>$1</b></center>',
	'whitelisttablemodify' => 'Modificar',
	'whitelisttablemodifyall' => 'Tot',
	'whitelisttablemodifynone' => 'Nonrés',
	'whitelisttablepage' => 'Pagina wiki',
	'whitelisttabletype' => 'Mòde d’accès',
	'whitelisttableexpires' => 'Expira lo',
	'whitelisttablemodby' => 'Modificat en darrièr per',
	'whitelisttablemodon' => 'Modificat en darrièr lo',
	'whitelisttableedit' => 'Modificar',
	'whitelisttableview' => 'Afichar',
	'whitelisttablenewdate' => 'Data novèla :',
	'whitelisttablechangedate' => 'Cambiar la data d’expiracion',
	'whitelisttablesetedit' => 'Paramètres per l’edicion',
	'whitelisttablesetview' => 'Paramètres per visionar',
	'whitelisttableremove' => 'Levar',
	'whitelistnewpagesfor' => 'Apond de paginas novèlas a la lista blanca de <b>$1</b><br />
Utilizatz siá lo caractèr * siá %',
	'whitelistnewtabledate' => 'Data d’expiracion :',
	'whitelistnewtableedit' => "Paramètres d'edicion",
	'whitelistnewtableview' => 'Paramètres per visionar',
	'whitelistnowhitelistedusers' => "I a pas cap d'utilizaire dins lo grop « {{MediaWiki:Group-restricted}} ».
Vos cal [[Special:UserRights|apondre l’utilizaire al grop]] abans que posquèssetz apondre de paginas a la lista blanca d’un utilizaire.",
	'whitelistnewtableprocess' => 'Tractar',
	'whitelistnewtablereview' => 'Revisar',
	'whitelistselectrestricted' => "== Seleccionatz un nom d’utilizaire d'accès restrench ==",
	'whitelistpagelist' => 'Paginas de {{SITENAME}} per $1',
	'whitelistnocalendar' => "<font color='red' size=3>Sembla que lo modul [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], una extension prerequesa, siá pas estada installada coma caliá !</font>",
	'whitelistoverview' => '== Vista generala dels cambiaments per $1 ==',
	'whitelistoverviewcd' => "Modificacion de la data de '''$1''' per [[:$2|$2]]",
	'whitelistoverviewsa' => "* configurar l'accès de '''$1''' per [[:$2|$2]]",
	'whitelistoverviewrm' => '* Retirament de l’accès a [[:$1|$1]]',
	'whitelistoverviewna' => "* Apond [[:$1|$1]] a la lista blanca amb los dreches de '''$2''' amb per data d’expiracion lo '''$3'''",
	'whitelistrequest' => 'Demanda d’accès a mai de paginas',
	'whitelistrequestmsg' => '$1 a demandat l’accès a {{PLURAL:$3|la pagina seguenta|a las paginas seguentas}} :

$2',
	'whitelistrequestconf' => 'Una demanda d’accès per de paginas novèlas es estada mandada a $1',
	'whitelistnonrestricted' => "L'utilizaire '''$1''' es pas amb de dreches restrenches.
Aquesta pagina s’aplica pas qu’als utilizaires disposant de dreches restrenches.",
	'whitelistnever' => 'jamai',
	'whitelistnummatches' => ' - {{PLURAL:$1|una ocuréncia|$1 ocuréncias}}',
	'right-editwhitelist' => 'Modificar la lista blanca pels utilizaires existents',
	'right-restricttowhitelist' => 'Modificar e visionar las paginas que figura unicament sus la lista blanca',
	'action-editwhitelist' => 'modificar la lista blanca pels utilizaires existents',
	'action-restricttowhitelist' => 'modificar e visionar las paginas que figuran unicament sus la lista blanca',
	'group-restricted' => 'Utilizaires restrenches',
	'group-restricted-member' => 'Utilizaire restrench',
	'group-manager' => 'Gestionaris',
	'group-manager-member' => 'Gestionari',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'whitelist' => 'Урс номхыгъды фæрстæ',
	'mywhitelistpages' => 'Мæ фæрстæ',
	'whitelisttablemodify' => 'Баив',
	'whitelisttablemodifyall' => 'Æппæт',
	'whitelisttablemodifynone' => 'Нæй',
	'whitelisttableedit' => 'Баив æй',
	'whitelistnever' => 'никуы',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'whitelisttablemodifyall' => 'ਸਭ',
	'whitelisttableedit' => 'ਬਦਲੋ',
	'whitelisttableview' => 'ਵੇਖੋ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'whitelisttablemodify' => 'Tscheensche',
	'whitelisttablemodifyall' => 'All',
	'whitelisttablemodifynone' => 'Nix tscheensche',
	'whitelisttablepage' => 'Blatt',
	'whitelisttableedit' => 'Ennere',
	'whitelistnever' => 'nie net',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'whitelist-desc' => 'Umożliwianie dostępu użytkownikom z ograniczeniami',
	'whitelistedit' => 'Edytor listy stron ogólnie dostępnych',
	'whitelist' => 'Strony z listy ogólnie dostępnych',
	'mywhitelistpages' => 'Strony użytkownika',
	'whitelistfor' => '<center>Aktualne informacje na temat <b>$1<b></center>',
	'whitelisttablemodify' => 'Zmodyfikuj',
	'whitelisttablemodifyall' => 'Wszystkie',
	'whitelisttablemodifynone' => 'Żadna',
	'whitelisttablepage' => 'Strona wiki:',
	'whitelisttabletype' => 'Typ dostępu:',
	'whitelisttableexpires' => 'Wygasa:',
	'whitelisttablemodby' => 'Ostatnio zmodyfikowany przez:',
	'whitelisttablemodon' => 'Data ostatniej modyfikacji:',
	'whitelisttableedit' => 'Edytuj',
	'whitelisttableview' => 'Podgląd',
	'whitelisttablenewdate' => 'Nowa data:',
	'whitelisttablechangedate' => 'Zmień datę wygaśnięcia:',
	'whitelisttablesetedit' => 'Przełącz na edycję',
	'whitelisttablesetview' => 'Przełącz na podgląd',
	'whitelisttableremove' => 'Usuń',
	'whitelistnewpagesfor' => 'Dodaj nowe strony do listy stron ogólnie dostępnych <b>$1</b><br />
Można stosować symbole wieloznaczne * i %',
	'whitelistnewtabledate' => 'Wygasa:',
	'whitelistnewtableedit' => 'Przełącz na edycję',
	'whitelistnewtableview' => 'Przełącz na podgląd',
	'whitelistnowhitelistedusers' => 'Brak użytkowników w grupie „{{MediaWiki:Group-restricted}}”.
Musisz [[Special:UserRights|dodać użytkowników do tej grupy]] zanim będziesz mógł dodawać uprawnienia do stron użytkownikom.',
	'whitelistnewtableprocess' => 'Przetwórz',
	'whitelistnewtablereview' => 'Przejrzyj',
	'whitelistselectrestricted' => '== Wybierz nazwę użytkownika z ograniczeniami ==',
	'whitelistpagelist' => 'Strony $1 w serwisie {{SITENAME}}',
	'whitelistnocalendar' => "<font color='red' size=3>Prawdopodobnie, wymagane do pracy tego modułu rozszerzenie [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics] nie zostało poprawnie zainstalowane.</font>",
	'whitelistoverview' => '== Przegląd zmian dla elementu $1 ==',
	'whitelistoverviewcd' => "* Zmiana daty ograniczenia na '''$1''' w odniesieniu do elementu [[:$2|$2]]",
	'whitelistoverviewsa' => "* Ustalanie dostępu dla elementu '''$1''' do elementu [[:$2|$2]]",
	'whitelistoverviewrm' => '* Usuwanie dostępu do [[:$1|$1]]',
	'whitelistoverviewna' => "* Dodawanie elementu [[:$1|$1]] do listy dostępu – dostęp dla '''$2''', data wygaśnięcia '''$3'''",
	'whitelistrequest' => 'Zażądaj dostępu do większej liczby stron',
	'whitelistrequestmsg' => 'Użytkownik $1 zażądał dostępu do {{PLURAL:$3|następującej strony|następujących stron}}:

$2',
	'whitelistrequestconf' => 'Żądanie utworzenia nowych stron zostało przesłane do $1',
	'whitelistnonrestricted' => "Na użytkownika '''$1''' nie nałożono ograniczeń.
Ta strona ma zastosowanie tylko do użytkowników na których zostały narzucone ograniczenia.",
	'whitelistnever' => 'nigdy',
	'whitelistnummatches' => ' - {{PLURAL:$1|1 wynik|$1 wyniki|$1 wyników}}',
	'right-editwhitelist' => 'Zmiana białej listy dla istniejących użytkowników',
	'right-restricttowhitelist' => 'Edytowanie i przeglądanie stron wyłącznie z białej listy',
	'action-editwhitelist' => 'modyfikowania białej listy dla istniejących użytkowników',
	'action-restricttowhitelist' => 'edytowania i przeglądania wyłącznie białej listy',
	'group-restricted' => 'Ograniczenie użytkownicy',
	'group-restricted-member' => 'Ograniczony użytkownik',
	'group-manager' => 'Zarządcy',
	'group-manager-member' => 'Zarządca',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'whitelist-desc' => "Modìfica ij përmess d'intrada dj'utent a fonsionalità limità",
	'whitelistedit' => "Modificator dla lista bianca dj'intrade",
	'whitelist' => 'Pàgine dle liste bianche',
	'mywhitelistpages' => 'Mie pàgine',
	'whitelistfor' => '<center>Anformassion corente për <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifiché',
	'whitelisttablemodifyall' => 'Tut',
	'whitelisttablemodifynone' => 'Gnun',
	'whitelisttablepage' => 'Pàgina wiki',
	'whitelisttabletype' => "Tipo d'intrada",
	'whitelisttableexpires' => 'A finiss ai',
	'whitelisttablemodby' => "Modificà l'ùltima vira da",
	'whitelisttablemodon' => "Modificà l'ùltima vira ai",
	'whitelisttableedit' => 'Modifiché',
	'whitelisttableview' => 'Vëdde',
	'whitelisttablenewdate' => 'Neuva dàita:',
	'whitelisttablechangedate' => 'Cangé la dàita dë scadensa',
	'whitelisttablesetedit' => 'Ativé la modificassion',
	'whitelisttablesetview' => 'Ativé la visualisassion',
	'whitelisttableremove' => 'Gavé',
	'whitelistnewpagesfor' => "Gionta ëd neuve pàgine a la lista bianca ëd <b>$1</b><br />
Dovré o bin ël caràter * opura % tanme caràter d'indefinission (wildcard)",
	'whitelistnewtabledate' => 'Dàita dë scadensa:',
	'whitelistnewtableedit' => 'Ativé la modìfica',
	'whitelistnewtableview' => 'Ativé la visualisassion',
	'whitelistnowhitelistedusers' => "A-i é gnun utent ant la partìa « {{MediaWiki:Group-restricted}} ».
A dev [[Special:UserRights|gionté j'utent ant la partìa]] prima ch'a peula gionté dle pàgine a la lista bianca ëd n'utent.",
	'whitelistnewtableprocess' => 'Traté',
	'whitelistnewtablereview' => 'Lese torna',
	'whitelistselectrestricted' => "== Selessioné un nòm d'utent a acess limità ==",
	'whitelistpagelist' => 'Pàgine ëd {{SITENAME}} për $1',
	'whitelistnocalendar' => "<font color='red' size=3>A smija che [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], un prerequisì për costa estension, a sia pa stàit anstalà për da bin!</font>",
	'whitelistoverview' => '== Descrission general dle modìfiche për $1 ==',
	'whitelistoverviewcd' => "* Modìfica dla dàita a '''$1''' për [[:$2|$2]]",
	'whitelistoverviewsa' => "* Configurassion ëd l'acess a '''$1''' për [[:$2|$2]]",
	'whitelistoverviewrm' => "* Gaveje l'acess a [[:$1|$1]]",
	'whitelistoverviewna' => "* Gionta ëd [[:$1|$1]] a la lista bianca con ij drit ëd '''$2''' e dàita dë scadensa '''$3'''",
	'whitelistrequest' => "Ciamé l'intrada a d'àutre pàgine",
	'whitelistrequestmsg' => "$1 a l'ha ciamà l'acess a {{PLURAL:$3|la pàgina|le pàgine}} sì-dapress:

$2",
	'whitelistrequestconf' => "N'arcesta për na pàgina neuva a va mandà a $1",
	'whitelistnonrestricted' => "L'utent '''$1''' a l'é pa n'utent selessionà.
Sta pàginà-sì a l'é mach disponìbil a utent selessionà.",
	'whitelistnever' => 'mai',
	'whitelistnummatches' => '- {{PLURAL:$1|un-a ocorensa|$1 ocorense}}',
	'right-editwhitelist' => "Modìfica la lista bianca për j'utent esistent",
	'right-restricttowhitelist' => 'Modìfica e varda mach pàgine an sla lista bianca',
	'action-editwhitelist' => 'modìfica la lista bianca për utent esistent',
	'action-restricttowhitelist' => 'modìfica e varda pàgine an sla lista bianca',
	'group-restricted' => 'Utent selessionà',
	'group-restricted-member' => 'Utent selessionà',
	'group-manager' => 'Mansé',
	'group-manager-member' => 'Mansé',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'mywhitelistpages' => 'زما پاڼې',
	'whitelisttablemodifyall' => 'ټول',
	'whitelisttablemodifynone' => 'هېڅ',
	'whitelisttablepage' => 'ويکي مخ',
	'whitelisttabletype' => 'د لاسرسۍ ډول',
	'whitelisttableedit' => 'سمون',
	'whitelisttableview' => 'کتل',
	'whitelisttablenewdate' => 'نوې نېټه:',
	'whitelisttableremove' => 'غورځول',
	'whitelistnewtabledate' => 'د پای نېټه:',
	'whitelistnewtablereview' => 'مخکتنه',
	'whitelistrequestconf' => '$1 ته د نوي مخونو غوښتنه ولېږل شوه',
	'whitelistnever' => 'هېڅکله',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'whitelist-desc' => 'Edite as permissões de acesso de utilizadores restritos',
	'whitelistedit' => 'Editor de acessos da lista branca',
	'whitelist' => 'Páginas na lista branca',
	'mywhitelistpages' => 'Minhas Páginas',
	'whitelistfor' => '<center>Informação actual para <b>$1</b></center>',
	'whitelisttablemodify' => 'Modificar',
	'whitelisttablemodifyall' => 'Todas',
	'whitelisttablemodifynone' => 'Nenhuma',
	'whitelisttablepage' => 'página wiki',
	'whitelisttabletype' => 'Tipo de acesso',
	'whitelisttableexpires' => 'Expira a',
	'whitelisttablemodby' => 'Última modificação por',
	'whitelisttablemodon' => 'Última modificação a',
	'whitelisttableedit' => 'Editar',
	'whitelisttableview' => 'Ver',
	'whitelisttablenewdate' => 'Nova Data:',
	'whitelisttablechangedate' => 'Alterar validade',
	'whitelisttablesetedit' => 'Activar edição',
	'whitelisttablesetview' => 'Activar visualização',
	'whitelisttableremove' => 'Remover',
	'whitelistnewpagesfor' => 'Adicione novas páginas à lista branca de <b>$1</b><br />
Use * ou % como caracteres de substituição',
	'whitelistnewtabledate' => 'Validade:',
	'whitelistnewtableedit' => 'Activar edição',
	'whitelistnewtableview' => 'Activar visualização',
	'whitelistnowhitelistedusers' => 'Não há utilizadores no grupo "{{MediaWiki:Group-restricted}}".
Tem de [[Special:UserRights|adicionar utilizadores ao grupo]] antes de poder adicionar páginas à lista branca de um utilizador.',
	'whitelistnewtableprocess' => 'Processar',
	'whitelistnewtablereview' => 'Rever',
	'whitelistselectrestricted' => '== Selecionar nome de utilizador restrito ==',
	'whitelistpagelist' => 'Páginas da {{SITENAME}} para $1',
	'whitelistnocalendar' => "<font color='red' size=3>Parece que [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], um pré-requisito para esta extensão, não foi instalada devidamente!</font>",
	'whitelistoverview' => '== Resumo das alterações a $1 ==',
	'whitelistoverviewcd' => "* A alterar data de [[:$2|$2]] para '''$1'''",
	'whitelistoverviewsa' => "* A modificar o acesso de [[:$2|$2]] para '''$1'''",
	'whitelistoverviewrm' => '* A remover acesso a [[:$1|$1]]',
	'whitelistoverviewna' => "* A adicionar [[:$1|$1]] à lista branca com acesso '''$2''' e validade '''$3'''",
	'whitelistrequest' => 'Requisitar acesso a mais páginas',
	'whitelistrequestmsg' => '$1 requisitou acesso {{PLURAL:$3|à seguinte página|às seguintes páginas}}:

$2',
	'whitelistrequestconf' => 'A requisição para novas páginas foi enviada para $1',
	'whitelistnonrestricted' => "O utilizador '''$1''' não é um utilizador restrito.
Esta página só se aplica a utilizadores restritos.",
	'whitelistnever' => 'nunca',
	'whitelistnummatches' => ' - {{PLURAL:$1|um resultado|$1 resultados}}',
	'right-editwhitelist' => 'Modificar a lista branca para utilizadores existentes',
	'right-restricttowhitelist' => 'Editar e ver apenas páginas na lista branca',
	'action-editwhitelist' => 'modificar a lista branca para utilizadores existentes',
	'action-restricttowhitelist' => 'editar e ver apenas páginas na lista branca',
	'group-restricted' => 'Utilizadores restritos',
	'group-restricted-member' => 'Utilizador restrito',
	'group-manager' => 'Gestores',
	'group-manager-member' => 'Gestor',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'whitelist-desc' => 'Edita as permissões de acesso de usuários restritos',
	'whitelistedit' => 'Editor de acessos da lista branca',
	'whitelist' => 'Páginas na lista branca',
	'mywhitelistpages' => 'Minhas páginas',
	'whitelistfor' => '<center>Informação atual para <b>$1</b></center>',
	'whitelisttablemodify' => 'Modificar',
	'whitelisttablemodifyall' => 'Todos',
	'whitelisttablemodifynone' => 'Nenhum',
	'whitelisttablepage' => 'Página wiki',
	'whitelisttabletype' => 'Tipo de acesso',
	'whitelisttableexpires' => 'Expira em',
	'whitelisttablemodby' => 'Última modificação por',
	'whitelisttablemodon' => 'Última modificação em',
	'whitelisttableedit' => 'Editar',
	'whitelisttableview' => 'Ver',
	'whitelisttablenewdate' => 'Nova data:',
	'whitelisttablechangedate' => 'Alterar data em que expira',
	'whitelisttablesetedit' => 'Ativar edição',
	'whitelisttablesetview' => 'Ativar visualização',
	'whitelisttableremove' => 'Remover',
	'whitelistnewpagesfor' => 'Adicione novas páginas à lista branca de <b>$1</b><br />
Use * ou % como caractere curinga',
	'whitelistnewtabledate' => 'Validade:',
	'whitelistnewtableedit' => 'Ativar edição',
	'whitelistnewtableview' => 'Ativar visualização',
	'whitelistnowhitelistedusers' => 'Não há utilizadores no grupo "{{MediaWiki:Group-restricted}}".
Você tem que [[Special:UserRights|adicionar utilizadores ao grupo]] antes de poder adicionar páginas à lista branca de um utilizador.',
	'whitelistnewtableprocess' => 'Processar',
	'whitelistnewtablereview' => 'Rever',
	'whitelistselectrestricted' => '== Selecionar nome de utilizador restrito ==',
	'whitelistpagelist' => 'Páginas de {{SITENAME}} para $1',
	'whitelistnocalendar' => "<font color='red' size=3>Parece que [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], um pré-requisito para esta extensão, não foi instalada devidamente!</font>",
	'whitelistoverview' => '== Resumo das alterações a $1 ==',
	'whitelistoverviewcd' => "* Alterando data de [[:$2|$2]] para '''$1'''",
	'whitelistoverviewsa' => "* Modificar o acesso de [[:$2|$2]] para '''$1'''",
	'whitelistoverviewrm' => '* Removendo acesso a [[:$1|$1]]',
	'whitelistoverviewna' => "* Adicionando [[:$1|$1]] à lista branca com acesso '''$2''' e validade '''$3'''",
	'whitelistrequest' => 'Requisitar acesso a mais páginas',
	'whitelistrequestmsg' => '$1 requisitou acesso {{PLURAL:$3|à seguinte página|às seguintes páginas}}:

$2',
	'whitelistrequestconf' => 'A requisição para novas páginas foi enviada para $1',
	'whitelistnonrestricted' => "O utilizador '''$1''' não é um utilizador restrito.
Esta página só se aplica a utilizadores restritos.",
	'whitelistnever' => 'nunca',
	'whitelistnummatches' => ' - {{PLURAL:$1|um resultado|$1 resultados}}',
	'right-editwhitelist' => 'Modificar a lista branca para utilizadores existentes',
	'right-restricttowhitelist' => 'Editar e ver apenas páginas na lista branca',
	'action-editwhitelist' => 'modificar a lista branca para utilizadores existentes',
	'action-restricttowhitelist' => 'editar e ver apenas páginas na lista branca',
	'group-restricted' => 'Utilizadores restritos',
	'group-restricted-member' => 'Utilizador restrito',
	'group-manager' => 'Gerenciadores',
	'group-manager-member' => 'Gerenciador',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'whitelisttablemodifyall' => 'Maṛṛa',
	'whitelisttableedit' => 'Arri',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'mywhitelistpages' => 'Paginile mele',
	'whitelisttablemodify' => 'Modifică',
	'whitelisttablemodifyall' => 'Tot',
	'whitelisttablemodifynone' => 'Nimic',
	'whitelisttablepage' => 'Pagină wiki',
	'whitelisttabletype' => 'Tip de acces',
	'whitelisttableexpires' => 'Expiră la',
	'whitelisttablemodby' => 'Ultima dată modificat de',
	'whitelisttablemodon' => 'Ultima dată modificat la',
	'whitelisttableedit' => 'Modifică',
	'whitelisttableview' => 'Afişează',
	'whitelisttablenewdate' => 'Dată nouă:',
	'whitelisttablechangedate' => 'Schimbare dată de expirare',
	'whitelisttablesetedit' => 'Activare modificare',
	'whitelisttablesetview' => 'Activare vizualizare',
	'whitelisttableremove' => 'Elimină',
	'whitelistnewtabledate' => 'Data de expirare:',
	'whitelistnewtableedit' => 'Activare modificare',
	'whitelistnewtableview' => 'Activare vizualizare',
	'whitelistnewtableprocess' => 'Proces',
	'whitelistnewtablereview' => 'Recenzie',
	'whitelistpagelist' => 'Pagini {{SITENAME}} pentru $1',
	'whitelistrequestmsg' => '$1 a cerut acces la {{PLURAL:$3|următoarea pagină|următoarele pagini}}:

$2',
	'whitelistrequestconf' => 'Cererea pentru pagini noi a fost trimisă la $1',
	'whitelistnonrestricted' => "Utilizatorul '''$1''' nu este un utilizator restricţionat.
Această pagină este aplicabilă doar utilizatorilor restricţionaţi",
	'whitelistnever' => 'niciodată',
	'group-restricted' => 'Utilizatori restricţionaţi',
	'group-restricted-member' => 'Utilizator restricţionat',
	'group-manager' => 'Manageri',
	'group-manager-member' => 'Manager',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'mywhitelistpages' => 'Le pàggene mie',
	'whitelisttablemodify' => 'Cange',
	'whitelisttablemodifyall' => 'Tutte',
	'whitelisttablemodifynone' => 'Ninde',
	'whitelisttablepage' => 'Pàgene de Uicchi',
	'whitelisttabletype' => "Tipe d'accesse",
	'whitelisttableexpires' => "More 'u",
	'whitelisttablemodby' => "L'urteme cangiamende da",
	'whitelisttablemodon' => "L'urteme cangiamende 'u",
	'whitelisttableedit' => 'Cange',
	'whitelisttableview' => 'Vide',
	'whitelisttablenewdate' => 'Date nove:',
	'whitelisttablechangedate' => "Cange 'a date de scadenze",
	'whitelisttablesetedit' => "Configure 'u cangiamende",
	'whitelisttablesetview' => 'Configure pe vedè',
	'whitelisttableremove' => 'Scangille',
	'whitelistnewtableedit' => "'Mboste pe cangià",
	'whitelistnewtableview' => "'Mboste pe vedè",
);

/** Russian (Русский)
 * @author Aleksandrit
 * @author Ferrer
 * @author Innv
 * @author Kaganer
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'whitelist-desc' => 'Редактировать права доступа участников',
	'whitelistedit' => 'Редактор доступа белого списка',
	'whitelist' => 'Страницы белого списка',
	'mywhitelistpages' => 'Мои страницы',
	'whitelistfor' => '<center>Актуальная информация для <b>$1</b></center>',
	'whitelisttablemodify' => 'Модифицировать',
	'whitelisttablemodifyall' => 'Все',
	'whitelisttablemodifynone' => 'Ничего',
	'whitelisttablepage' => 'Страница вики',
	'whitelisttabletype' => 'Тип доступа',
	'whitelisttableexpires' => 'Истекает',
	'whitelisttablemodby' => 'Последний раз изменено',
	'whitelisttablemodon' => 'Последнее изменение',
	'whitelisttableedit' => 'Править',
	'whitelisttableview' => 'Просмотр',
	'whitelisttablenewdate' => 'Новая дата:',
	'whitelisttablechangedate' => 'Изменение срока действия',
	'whitelisttablesetedit' => 'Установить для правки',
	'whitelisttablesetview' => 'Установить для просмотра',
	'whitelisttableremove' => 'Удалить',
	'whitelistnewpagesfor' => 'Добавление новых страниц в белый список <b>$1</b><br />
Возможно использовать подстановочные символы * и %',
	'whitelistnewtabledate' => 'Дата окончания:',
	'whitelistnewtableedit' => 'Установить для редактирования',
	'whitelistnewtableview' => 'Установить для просмотра',
	'whitelistnowhitelistedusers' => 'В группе «{{MediaWiki:Group-restricted}}» нет участников.
Прежде чем вы сможете добавить страницы участников в белый список, вы должны [[Special:UserRights|добавить участников в эту группу]].',
	'whitelistnewtableprocess' => 'Процесс',
	'whitelistnewtablereview' => 'Обзор',
	'whitelistselectrestricted' => '== Выберите имя участника ==',
	'whitelistpagelist' => 'Страницы {{SITENAME}} для $1',
	'whitelistnocalendar' => "<font color='red' size=3>По всей видимости, не было установлено расширение [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], от которого зависит данное расширение.</font>",
	'whitelistoverview' => '== Обзор изменений для $1 ==',
	'whitelistoverviewcd' => "* Изменение даты на '''$1''' для [[:$2|$2]]",
	'whitelistoverviewsa' => "* Установить доступ '''$1''' для [[:$2|$2]]",
	'whitelistoverviewrm' => '* Снять права [[:$1|$1]]',
	'whitelistoverviewna' => "* Добавление [[:$1|$1]] в белый список с доступом '''$2''' и датой истечения срока '''$3'''",
	'whitelistrequest' => 'Запрос доступа к большему количеству страниц',
	'whitelistrequestmsg' => '$1 запросил доступ к {{PLURAL:$3|следующей странице|следующим страницам}}:

$2',
	'whitelistrequestconf' => 'Запрос по новым страницам был отправлен $1',
	'whitelistnonrestricted' => "У участника '''$1''' нет ограничений.
Данная страницы предназначена только для участников, ограниченных в правах.",
	'whitelistnever' => 'никогда',
	'whitelistnummatches' => '  - $1 {{PLURAL:$1|совпадение|совпадения|совпадений}}',
	'right-editwhitelist' => 'Изменить белый список для существующих участников',
	'right-restricttowhitelist' => 'Редактировать и просматривать только страницы из белого списка',
	'action-editwhitelist' => 'изменить белый список для существующих участников',
	'action-restricttowhitelist' => 'редактировать и просматривать страницы только из белого списка',
	'group-restricted' => 'Участники, ограниченные в правах',
	'group-restricted-member' => 'Участник, ограниченный в правах',
	'group-manager' => 'Управляющие',
	'group-manager-member' => 'управляющий',
);

/** Sinhala (සිංහල)
 * @author Calcey
 */
$messages['si'] = array(
	'whitelist-desc' => 'සීමා කරනු ලැබ ඇති පරිශීලකයන්ගේ ප්‍රවේශ අවසරය සංස්කරණය කරන්න',
	'whitelistedit' => 'ධවල ලැයිස්තු ප්‍රවේශ සංස්කාරක',
	'whitelist' => 'ධවල ලැයිස්තු පිටු',
	'mywhitelistpages' => 'මගේ පිටු',
	'whitelistfor' => '<center>දැනට <b>$1</b></center>සඳහා පවතින තොරතුරු',
	'whitelisttablemodify' => 'විකරණය',
	'whitelisttablemodifyall' => 'සියල්ලම',
	'whitelisttablemodifynone' => 'කිසිවක් නැත',
	'whitelisttablepage' => 'විකි පිටුව',
	'whitelisttabletype' => 'ප්‍රවේශ වර්ගය',
	'whitelisttableexpires' => 'කල් ඉකුත් වන්නේ',
	'whitelisttablemodby' => 'අවසන් වරට විකරණය කරන ලද්දේ',
	'whitelisttablemodon' => 'අවසන් වරට විකරණය කරනු ලැබුවේ',
	'whitelisttableedit' => 'සංස්කරණය',
	'whitelisttableview' => 'දර්ශනය',
	'whitelisttablenewdate' => 'නව දිනය:',
	'whitelisttablechangedate' => 'කල් ඉකුත්වීමේ දිනය වෙනස් කරන්න',
	'whitelisttablesetedit' => 'සංස්කරණය කිරීමට සකස් කරන්න',
	'whitelisttablesetview' => 'දර්ශනය කිරීමට සකසන්න',
	'whitelisttableremove' => 'ඉවත් කරන්න',
	'whitelistnewpagesfor' => " <b>$1's</b>ධවල ලැයිස්තුව<br />ට නව පිටු එකතු කරන්න
 * හෝ % ආදේශක ලකුණ ලෙස භාවිතා කරන්න",
	'whitelistnewtabledate' => 'කල් ඉකුත්වීමේ දිනය:',
	'whitelistnewtableedit' => 'සංස්කරණය කිරීමට සකසන්න',
	'whitelistnewtableview' => 'දර්ශනය කිරීමට සකසන්න',
	'whitelistnowhitelistedusers' => ' "{{MediaWiki:Group-restricted}}" හි පරිශීලකයන් නොමැත.
ඔබ පරිශීලකයෙකුගේ ධවල ලැයිස්තුවට පිටු එකතු කිරීමට පෙර [[Special:UserRights|කණ්ඩායමට පරිශීලකයන් එකතු කිරීම]] ට ඔබට සිදුවේ.',
	'whitelistnewtableprocess' => 'ක්‍රියාවලිය',
	'whitelistnewtablereview' => 'විවරණය',
	'whitelistselectrestricted' => '== සීමා කරනු ලැබූ පරිශීලක නාම තෝරන්න ==',
	'whitelistpagelist' => '$1 සඳහා {{SITENAME}}පිටු',
	'whitelistnocalendar' => "<font color='red' size=3>මෙම දිඟුවට පූර්ව අවශ්‍යතාවයක් වූ  [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], නිවැරදිව පිහිටුවා නැති ලෙසින් පෙනේ!</font>",
	'whitelistoverview' => '==  $1 සඳහා කළ වෙනස් කිරීම්වල දළ විශපල්ෂණය==',
	'whitelistoverviewcd' => "*   [[:$2|$2]] සඳහා දිනය '''$1'''ට මාරු කිරීම",
	'whitelistoverviewsa' => "*  [[:$2|$2]] සඳහා '''$1''' ට ප්‍රවේශය සිටුවීම",
	'whitelistoverviewrm' => '*  [[:$1|$1]]ට ප්‍රවේශය ඉවත් කිරීම',
	'whitelistoverviewna' => "*    '''$2''' සහ  '''$3''' කල් ඉකුත්වීමේ දිනය   [[:$1|$1]] ප්‍රවේශය සමඟ ධවල ලැයිස්තුවට එකතු කිරීම",
	'whitelistrequest' => 'වැඩි පිටු ගණනකට ප්‍ර‍වේශය ඉල්ලීම',
	'whitelistrequestmsg' => 'පහත  {{PLURAL:$3|පිටුව|පිටු}} සඳහා ප්‍රවේශවීමට $1 ක් ඉල්ලුම් කර ඇත:

$2',
	'whitelistrequestconf' => 'නව පිටු සඳහා වූ ඉල්ලීම $1 වෙත යවන ලදී',
	'whitelistnonrestricted' => "'''$1'''  සීමා කරනු ලැබූ පරිශීලකයෙකු නොවේ.
මෙම පිටුව අදාළ වන්නේ සීමා කරනු ලැබූ පරිශීලකයින්ට පමණි.",
	'whitelistnever' => 'කවදාවත් නෑ',
	'whitelistnummatches' => '  - {{PLURAL:$1|ගැළපීම් එකයි|$1 ගැළපීම්}}',
	'right-editwhitelist' => 'පවතින පරිශීලකයන් සඳහා ධවල ලැයිස්තුව විකරණය',
	'right-restricttowhitelist' => 'ධවල ලැයිස්තුවේ ඇති පිටු පමණක් පෙන්වීම හා සංස්කරණය',
	'action-editwhitelist' => 'සිටින පරිශීලකයන් සඳහා ධවල ලැයිස්තුව විකරණය කරන්න',
	'action-restricttowhitelist' => 'ධවල ලැයිස්තුවේ ඇති පිටු පමණක් පෙන්වීම හා සංස්කරණය',
	'group-restricted' => 'සීමා කරනු ලැබූ පරිශීලකයින්',
	'group-restricted-member' => 'සීමා කරනු ලැබූ පරිශීලකයින්',
	'group-manager' => 'කළමනාකරුවන්',
	'group-manager-member' => 'කළමනාකරු',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'whitelist-desc' => 'Upraviť oprávnenia prístupu používateľov',
	'whitelistedit' => 'Editor bielej listiny prístupu',
	'whitelist' => 'Dať stránky na bielu listinu',
	'mywhitelistpages' => 'Moje stránky',
	'whitelistfor' => '<center>Aktuálne informácie pre <b>$1<b></center>',
	'whitelisttablemodify' => 'Zmeniť',
	'whitelisttablemodifyall' => 'Všetky',
	'whitelisttablemodifynone' => 'Žiadne',
	'whitelisttablepage' => 'Wiki stránka',
	'whitelisttabletype' => 'Typ prístupu',
	'whitelisttableexpires' => 'Vyprší',
	'whitelisttablemodby' => 'Naspoledy zmenil',
	'whitelisttablemodon' => 'Naposledy zmenené',
	'whitelisttableedit' => 'Upraviť',
	'whitelisttableview' => 'Zobraziť',
	'whitelisttablenewdate' => 'Nový dátum:',
	'whitelisttablechangedate' => 'Zmeniť dátum vypršania',
	'whitelisttablesetedit' => 'Nastaviť na Upraviť',
	'whitelisttablesetview' => 'Nastaviť na Zobrazenie',
	'whitelisttableremove' => 'Odstrániť',
	'whitelistnewpagesfor' => 'Pridať nové stránky na bielu listinu <b>$1</b><br />
Ako zástupný znak použite buď * alebo %',
	'whitelistnewtabledate' => 'Dátum vypršania:',
	'whitelistnewtableedit' => 'Nastaviť na Upraviť',
	'whitelistnewtableview' => 'Nastaviť na Zobraziť',
	'whitelistnowhitelistedusers' => 'V skupine „{{MediaWiki:Group-restricted}}“ sa nenachádzajú žiadni používatelia.
Musíte [[Special:UserRights|pridať používateľov do tejto skupiny]] predtým, než budete môcť pridávať stránky na bielu listinu používateľa.',
	'whitelistnewtableprocess' => 'Spracovať',
	'whitelistnewtablereview' => 'Skontrolovať',
	'whitelistselectrestricted' => '== Vyberte meno používateľa ==',
	'whitelistpagelist' => 'stránky {{GRAMMAR:genitív|{{SITENAME}}}} pre $1',
	'whitelistnocalendar' => "<font color='red' size=3>Zdá sa, že nie je správne nainštalované rozšírenie [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], ktoré toto rozšírenie vyžaduje.</font>",
	'whitelistoverview' => '== Prehľad zmien $1 ==',
	'whitelistoverviewcd' => "* Zmena dátumu [[:$2|$2]] na '''$1'''",
	'whitelistoverviewsa' => "* Nastavenie prístupu [[:$2|$2]] na '''$1'''",
	'whitelistoverviewrm' => '* Odstránenie prístupu na [[:$1|$1]]',
	'whitelistoverviewna' => "* Pridanie prístupu [[:$1|$1]] na bielu listinu s prístupom '''$2''' a vypršaním '''$3'''",
	'whitelistrequest' => 'Požiadať o prístup k viacerým stránkam',
	'whitelistrequestmsg' => '$1 požiadal o prístup k {{PLURAL:$3|nasledovnej stránke|nasledovným stránkam}}:

$2',
	'whitelistrequestconf' => 'Žiadosť o nové stránky bola odoslaná $1',
	'whitelistnonrestricted' => "Používateľ '''$1''' nie je obmedzený používateľ.
Táto stránka sa týka iba obmedzneých používateľov.",
	'whitelistnever' => 'nikdy',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|výsledok|výsledky|výsledkov}}',
	'right-editwhitelist' => 'Zmeniť bielu listinu existujúcich používateľov',
	'right-restricttowhitelist' => 'Upravovať a prezerať iba stránky z bielej listiny',
	'action-editwhitelist' => 'zmeniť bielu listinu existujúcich používateľov',
	'action-restricttowhitelist' => 'upravovať a prezerať iba stránky z bielej listiny',
	'group-restricted' => 'Obmedzení používatelia',
	'group-restricted-member' => 'Obmedzený používateľ',
	'group-manager' => 'Správcovia',
	'group-manager-member' => 'Správca',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'mywhitelistpages' => 'Моје стране',
	'whitelisttablemodifyall' => 'Све',
	'whitelisttablemodifynone' => 'Нема',
	'whitelisttablepage' => 'Вики чланак',
	'whitelisttabletype' => 'Тип приступа',
	'whitelisttableexpires' => 'Истиче на',
	'whitelisttablemodby' => 'Последњу измену направио',
	'whitelisttablemodon' => 'Последња измена на',
	'whitelisttableedit' => 'Уреди',
	'whitelisttableview' => 'Преглед',
	'whitelisttablenewdate' => 'Нови датум:',
	'whitelisttablechangedate' => 'Промени датум истека',
	'whitelisttableremove' => 'Уклони',
	'whitelistnewtabledate' => 'Датум истека:',
	'whitelistoverview' => '== Преглед измена за $1 ==',
	'whitelistoverviewcd' => "* Мењање датума на '''$1''' за [[:$2|$2]]",
	'whitelistoverviewsa' => "* Постављање приступа на '''$1''' за [:$2|$2]]",
	'whitelistoverviewrm' => '* Уклањање приступа за [[:$1|$1]]',
	'whitelistrequest' => 'Захтевање приступа за више страна',
	'whitelistrequestmsg' => '$1 је захтевао приступ {{PLURAL:$3|следећој страни|следећим странама}}:

$2',
	'whitelistrequestconf' => 'Захтев за новим странама је послат $1',
	'whitelistnever' => 'никад',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'mywhitelistpages' => 'Moje strane',
	'whitelisttablemodifyall' => 'Sve',
	'whitelisttablemodifynone' => 'Nema',
	'whitelisttablepage' => 'Viki članak',
	'whitelisttabletype' => 'Tip pristupa',
	'whitelisttableexpires' => 'Ističe na',
	'whitelisttablemodby' => 'Poslednju izmenu napravio',
	'whitelisttablemodon' => 'Poslednja izmena na',
	'whitelisttableedit' => 'Uredi',
	'whitelisttableview' => 'Pregled',
	'whitelisttablenewdate' => 'Novi datum:',
	'whitelisttablechangedate' => 'Promeni datum isteka',
	'whitelisttableremove' => 'Ukloni',
	'whitelistnewtabledate' => 'Datum isteka:',
	'whitelistoverview' => '== Pregled izmena za $1 ==',
	'whitelistoverviewcd' => "* Menjanje datuma na '''$1''' za [[:$2|$2]]",
	'whitelistoverviewsa' => "* Postavljanje pristupa na '''$1''' za [:$2|$2]]",
	'whitelistoverviewrm' => '* Uklanjanje pristupa za [[:$1|$1]]',
	'whitelistrequest' => 'Zahtevanje pristupa za više strana',
	'whitelistrequestmsg' => '$1 je zahtevao pristup {{PLURAL:$3|sledećoj strani|sledećim stranama}}:

$2',
	'whitelistrequestconf' => 'Zahtev za novim stranama je poslat $1',
	'whitelistnever' => 'nikad',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'whitelist-desc' => 'Tougriepsgjuchte fon betuunde Benutsere beoarbaidje',
	'whitelistedit' => 'Whitelist-Tougriep-Editor',
	'whitelist' => 'Whitelist-Sieden',
	'mywhitelistpages' => 'Mien Sieden',
	'whitelistfor' => '<center>Aktuelle Information foar <b>$1</b></center>',
	'whitelisttablemodify' => 'Modifizierje',
	'whitelisttablemodifyall' => 'Aal modifizierje',
	'whitelisttablemodifynone' => 'Niks modifizierje',
	'whitelisttablepage' => 'Siede',
	'whitelisttabletype' => 'Tougriepstyp',
	'whitelisttableexpires' => 'Ouloop an n',
	'whitelisttablemodby' => 'Toulääst modifizierd fon',
	'whitelisttablemodon' => 'Toulääst modifizierd an n',
	'whitelisttableedit' => 'Beoarbaidje',
	'whitelisttableview' => 'Bekiekje',
	'whitelisttablenewdate' => 'Näi Doatum:',
	'whitelisttablechangedate' => 'Ouloopsdoatum annerje',
	'whitelisttablesetedit' => 'Beoarbaidje',
	'whitelisttablesetview' => 'Bekiekje',
	'whitelisttableremove' => 'Wächhoalje',
	'whitelistnewpagesfor' => "Näie Sieden tou <b>$1's</b> Whitelist bietouföigje<br />
Äntweeder * of % as Maskenteeken benutsje",
	'whitelistnewtabledate' => 'Ouloopdoatum:',
	'whitelistnewtableedit' => 'Beoarbaidje',
	'whitelistnewtableview' => 'Bekiekje',
	'whitelistnowhitelistedusers' => 'Dät rakt neen Benutsere, do ju Gruppe „{{MediaWiki:Group-restricted}}“ anheere.
Du moast [[Special:UserRights|Benutsere tou ju Gruppe bietouföigje]] eer du Sieden ap ju Beooboachtengslieste fon n Benutser sätte koast.',
	'whitelistnewtableprocess' => 'Beoarbaidje',
	'whitelistnewtablereview' => 'Wröigje',
	'whitelistselectrestricted' => '== Betuunden Benutser uutwääle ==',
	'whitelistpagelist' => '{{SITENAME}} Sieden foar $1',
	'whitelistnocalendar' => "<font color='red' size=3>[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Ju Extension:UsageStatistics], ne Bedingenge foar disse Extension, wuud nit installierd of kon nit fuunen wäide!</font>",
	'whitelistoverview' => '== Annerengsuursicht foar $1 ==',
	'whitelistoverviewcd' => "* Doatum '''($1)''' foar [[:$2|$2]] wäd annerd",
	'whitelistoverviewsa' => "* Tougriep '''$1''' foar [[:$2|$2]] wäd anwoand",
	'whitelistoverviewrm' => '* Tougriep ap [[:$1|$1]] wäd wächhoald',
	'whitelistoverviewna' => "* [[:$1|$1]] wäd tou ju Whitelist bietouföiged. (Tougriep: '''$2''', Ouloopdoatum: '''$3''')",
	'whitelistrequest' => 'Wiederen Tougriep fräigje',
	'whitelistrequestmsg' => '$1 häd Tougriep ap {{PLURAL:$3|ju foulgjende Siede|do foulgjende Sieden}} fräiged:

$2',
	'whitelistrequestconf' => 'Anfroage foar näie Sieden an $1 soand',
	'whitelistnonrestricted' => "'''$1''' is naan betuunden Benutser.
Disse Siede jält bloot foar betuunde Benutsere.",
	'whitelistnever' => 'sieläärge nit',
	'whitelistnummatches' => '- $1 {{PLURAL:$1|Uureenstimmenge|Uureenstimmengen}}',
	'right-editwhitelist' => 'Wiete Lieste foar existierjende Benutsere beoarbaidje',
	'right-restricttowhitelist' => 'Beoarbaidje un bekiekje bloot Sieden do der in ju Positivlieste apnuumen sunt.',
	'action-editwhitelist' => 'modifizier ju Positivlieste foar existierjende Benutsere',
	'action-restricttowhitelist' => 'beoarbaidje un betrachtje bloot Sieden do in ju Positivlieste apnuumen sunt',
	'group-restricted' => 'Ientuunde Benutsere',
	'group-restricted-member' => 'Ientuunden Benutser',
	'group-manager' => 'Ferwaltere',
	'group-manager-member' => 'Ferwalter',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'whitelisttableedit' => 'Édit',
);

/** Swedish (Svenska)
 * @author M.M.S.
 * @author Najami
 * @author Sannab
 */
$messages['sv'] = array(
	'whitelist-desc' => 'Redigera åtkomsträttigheter för begränsade användare',
	'whitelistedit' => 'Rättighetsredigerare för vitlista',
	'whitelist' => 'Vitlistade sidor',
	'mywhitelistpages' => 'Mina sidor',
	'whitelistfor' => '<center>Nuvarande information för <b>$1<b></center>',
	'whitelisttablemodify' => 'Ändra',
	'whitelisttablemodifyall' => 'Alla',
	'whitelisttablemodifynone' => 'Ingen',
	'whitelisttablepage' => 'Wikisida',
	'whitelisttabletype' => 'Åtkomsttyp',
	'whitelisttableexpires' => 'Utgår',
	'whitelisttablemodby' => 'Senast ändrad av',
	'whitelisttablemodon' => 'Senast ändrad på',
	'whitelisttableedit' => 'Redigera',
	'whitelisttableview' => 'Visa',
	'whitelisttablenewdate' => 'Nytt datum:',
	'whitelisttablechangedate' => 'Ändra utgångsdatum',
	'whitelisttablesetedit' => 'Ange att redigera',
	'whitelisttablesetview' => 'Ange att visa',
	'whitelisttableremove' => 'Radera',
	'whitelistnewpagesfor' => 'Lägg till nya sidor till <b>$1s</b> vitlista<br />
Använd hellre * eller % som jokertecken',
	'whitelistnewtabledate' => 'Utgångsdatum:',
	'whitelistnewtableedit' => 'Ange att redigera',
	'whitelistnewtableview' => 'Ange att visa',
	'whitelistnowhitelistedusers' => 'Det finns inga användare i gruppen "{{MediaWiki:Group-restricted}}".
Du måste [[Special:UserRights|lägga till användare till gruppen]] innan du kan lägga till sidor till en användares vitlista.',
	'whitelistnewtableprocess' => 'Behandla',
	'whitelistnewtablereview' => 'Granska',
	'whitelistselectrestricted' => '== Ange begränsad användares namn ==',
	'whitelistpagelist' => '{{SITENAME}} sidor för $1',
	'whitelistnocalendar' => "<font color='red' size=3>Det verkar som [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], en förutsättning för detta programtillägg, inte har installerats ordentligt!</font>",
	'whitelistoverview' => '== Översikt av ändringar för $1 ==',
	'whitelistoverviewcd' => "* Ändrar datum till '''$1''' för [[:$2|$2]]",
	'whitelistoverviewsa' => "* Anger åtkomst till '''$1''' för [[:$2|$2]]",
	'whitelistoverviewrm' => '* Raderar åtkomst till [[:$1|$1]]',
	'whitelistoverviewna' => "* Lägger till [[:$1|$1]] till vitlista med åtkomst '''$2''' och '''$3''' utgångsdatum",
	'whitelistrequest' => 'Efterfråga åtkomst till mer sidor',
	'whitelistrequestmsg' => '$1 har efterfrågat åtkomst till följande {{PLURAL:$3|sida|sidor}}:

$2',
	'whitelistrequestconf' => 'Efterfrågan för nya sidor har sänts till $1',
	'whitelistnonrestricted' => "Användare '''$1''' är inte en begränsad användare.
Denna sida är endast tillämpbar på begränsade användare",
	'whitelistnever' => 'aldrig',
	'whitelistnummatches' => ' - {{PLURAL:$1|en träff|$1 träffar}}',
	'right-editwhitelist' => 'Ändra vitlistan för existerande användare',
	'right-restricttowhitelist' => 'Redigera och visa sidor som endast är på vitlistan',
	'action-editwhitelist' => 'ändra vitlistan för existerande användare',
	'action-restricttowhitelist' => 'redigera och visa sidor som endast är på vitlistan',
	'group-restricted' => 'Begränsade användare',
	'group-restricted-member' => 'Begränsad användare',
	'group-manager' => 'Hanterare',
	'group-manager-member' => 'Hanterare',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 * @author Lajsikonik
 * @author Pimke
 */
$messages['szl'] = array(
	'whitelist-desc' => 'Dozwalańy na dostymp użytkowńikům s uograńiczyńami',
	'whitelistedit' => 'Edytor listy zajtůw uogůlńy dostympnych',
	'whitelist' => 'Zajty s listy uogůlńy dostympnych',
	'mywhitelistpages' => 'Zajty użytkowńika',
	'whitelistfor' => '<center>Aktualne informacyje na tymat <b>$1</b></center>',
	'whitelisttablemodify' => 'Zmjyń',
	'whitelisttablemodifyall' => 'Wszyjstke',
	'whitelisttablemodifynone' => 'Żodno',
	'whitelisttablepage' => 'Zajta wiki:',
	'whitelisttabletype' => 'Typ dostympu:',
	'whitelisttableexpires' => 'Wygaso:',
	'whitelisttablemodby' => 'Uostatńo zmjyńůny bes:',
	'whitelisttablemodon' => 'Data uostatńygo půmjyńyńa:',
	'whitelisttableedit' => 'Sprowjéj',
	'whitelisttableview' => 'Podglůnd',
	'whitelisttablenewdate' => 'Nowo data:',
	'whitelisttablechangedate' => 'Zmjyń data wygaśńyńćo:',
	'whitelisttablesetedit' => 'Przełůncz na sprowjańe',
	'whitelisttablesetview' => 'Przełůncz na podglůnd',
	'whitelisttableremove' => 'Wyćep',
	'whitelistnewpagesfor' => 'Dodej nowe zajty do listy zajtůw kere sům uogůlńy dostympne<b>$1</b><br />
Idźe używać symbolůw wjeloznacznych * a %',
	'whitelistnewtabledate' => 'Wygaso:',
	'whitelistnewtableedit' => 'Przełůncz na sprowjańy',
	'whitelistnewtableview' => 'Przełůncz na podglůnd',
	'whitelistnowhitelistedusers' => 'Ńy ma żodnych użytkowńikůw we grupje „{{MediaWiki:Group-restricted}}”.
Muśisz [[Special:UserRights|dodać użytkowńikůw do tyj grupy]] ńim bydźesz můg dodować zajty do whitelisty użytkowńika.',
	'whitelistnewtableprocess' => 'Przetwůrz',
	'whitelistnewtablereview' => 'Przejrzyj',
	'whitelistselectrestricted' => '== Wybjer mjano użytkowńika s uograńiczeńůma ==',
	'whitelistpagelist' => 'Zajty $1 we serwiśe {{SITENAME}}',
	'whitelistnocalendar' => "<font color='red' size=3>Prawdopodobńy, wymogane do pracy tygo moduła rozszerzyńy [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics] ńy zostało poprowńy zainsztalowane.</font>",
	'whitelistoverview' => '== Przeglůnd půmjyńań lů ylymtnya $1 ==',
	'whitelistoverviewcd' => "* Zmjana daty uograńiczyńo na '''$1''' we uodńyśyńu do ylymyntu [[:$2|$2]]",
	'whitelistoverviewsa' => "* Nasztalowańy dostympu lů ylymyntu '''$1''' ki ylymyntowi [[:$2|$2]]",
	'whitelistoverviewrm' => '* Zawarće dostympu ku [[:$1|$1]]',
	'whitelistoverviewna' => "* Doćepańy ylymynta [[:$1|$1]] do listy dostympu - dostymp lů '''$2''', data wygaśńyńćo '''$3'''",
	'whitelistrequest' => 'Zażůndej dostympa do wjynkszyj liczby zajtůw',
	'whitelistrequestmsg' => 'Użytkowńik $1 zażůndoł dostympa do {{PLURAL:$3|nostympujůncyj zajty|nastmpujůncych zajtůw}}:

$2',
	'whitelistrequestconf' => 'Żůndańy utworzyńo nowych zajtůw zostało przesłane ku $1',
	'whitelistnonrestricted' => "Na użytkowńika '''$1''' ńy nołożůno uograńiczyń.
Ta zajta mo zastosowańy yno lů użytkowńikůw na kerych nałożůno uograńiczyńa.",
	'whitelistnever' => 'ńigdy',
	'whitelistnummatches' => '- {{PLURAL:$1|1 wyńik|$1 wyńiki|$1 wyńikůw}}',
	'right-editwhitelist' => 'Zmjyń whitelista lů istńijůncych użytkowńikůw',
	'right-restricttowhitelist' => 'Sprowjej a pokazuj zajty yno s whitelist',
	'action-editwhitelist' => 'Zmjyńej whitelista lů istńijůncych użytkowńikůw',
	'action-restricttowhitelist' => 'Sprowjej a pokazuj zajty yno s whitelisty',
	'group-restricted' => 'Użytkowńiki s uograńiczeńůma',
	'group-restricted-member' => 'Użytkowńik s uograńiczeńůma',
	'group-manager' => 'Zarzůndzajůncy',
	'group-manager-member' => 'Zarzůndzajůncy',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 */
$messages['ta'] = array(
	'whitelisttablemodifyall' => 'அனைத்து',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'whitelist-desc' => 'నియంత్రిత వాడుకరుల అందుబాటు అనుమతులను మార్చండి',
	'mywhitelistpages' => 'నా పేజీలు',
	'whitelistfor' => '<center><b>$1</b> కొరకు ప్రస్తుత సమాచారం</center>',
	'whitelisttablemodify' => 'మార్చు',
	'whitelisttablemodifyall' => 'అన్నీ',
	'whitelisttablemodifynone' => 'ఏదీకాదు',
	'whitelisttablepage' => 'వికీ పేజీ',
	'whitelisttabletype' => 'అనుమతి రకం',
	'whitelisttableexpires' => 'కాలంచెల్లు తేదీ',
	'whitelisttablemodby' => 'చివరగా మార్చినది',
	'whitelisttablemodon' => 'చివరి మార్పు తేదీ',
	'whitelisttableedit' => 'మార్చు',
	'whitelisttableview' => 'చూడండి',
	'whitelisttablenewdate' => 'కొత్త తేదీ:',
	'whitelisttablechangedate' => 'కాలపరిమితి తేదీని మార్చు',
	'whitelisttableremove' => 'తొలగించు',
	'whitelistnewtabledate' => 'కాల పరిమితి:',
	'whitelistnewtablereview' => 'సమీక్షించు',
	'whitelistpagelist' => '$1 కై {{SITENAME}} పేజీలు',
	'whitelistrequest' => 'మరిన్ని పేజీలకు అనుమతిని అభ్యర్థించండి',
	'whitelistrequestmsg' => 'ఈ క్రింది {{PLURAL:$3|పేజీకి|పేజీలకు}} $1 అనుమతిని అడిగారు:

$2',
	'whitelistrequestconf' => 'కొత్త పేజీలకై అభ్యర్థనని $1 కి పంపించాం',
	'whitelistnonrestricted' => "వాడుకరి '''$1''' నియంత్రిత వాడుకరి కాదు.
ఈ పేజీ నియంత్రిత వాడుకరులకు మాత్రమే వర్తిస్తుంది",
	'whitelistnummatches' => ' - {{PLURAL:$1|ఒక పోలిక|$1 పోలికలు}}',
	'group-restricted' => 'నియంత్రిత వాడుకరులు',
	'group-restricted-member' => 'నియంత్రిత వాడుకరి',
	'group-manager' => 'మేనేజర్లు',
	'group-manager-member' => 'మేనేజరు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'mywhitelistpages' => "Ha'u-nia pájina sira",
	'whitelisttablemodifyall' => 'Hotu',
	'whitelisttableedit' => 'Edita',
	'whitelistnever' => 'nunka',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'whitelist-desc' => 'Иҷозаҳои дастрасии корбарони маҳдудшударо вироиш кунед',
	'whitelist' => 'Саҳифаҳои Феҳристи сафед',
	'mywhitelistpages' => 'Саҳифаҳои Ман',
	'whitelistfor' => '<center>Иттилооти кунунӣ барои <b>$1</b></center>',
	'whitelisttablemodify' => 'Пиростан',
	'whitelisttablemodifyall' => 'Ҳама',
	'whitelisttablemodifynone' => 'Ҳеҷ',
	'whitelisttablepage' => 'Саҳифаи Вики',
	'whitelisttabletype' => 'Навъи Дастрасӣ',
	'whitelisttableexpires' => 'Сипарӣ мешавад дар',
	'whitelisttablemodby' => 'Охирин маротиба пироста шуда буд тавассути',
	'whitelisttablemodon' => 'Охирин маротиба пироста шуда буд дар',
	'whitelisttableedit' => 'Вироиш',
	'whitelisttableview' => 'Дидан',
	'whitelisttablenewdate' => 'Таърихи Нав:',
	'whitelisttablechangedate' => 'Тағйири Таърихи Баинтиҳорасӣ',
	'whitelisttableremove' => 'Ҳазф',
	'whitelistnewtabledate' => 'Таърихи Баинтиҳорасӣ:',
	'whitelistnewtableprocess' => 'Раванд',
	'whitelistnewtablereview' => 'Пешнамоиш',
	'whitelistrequest' => 'Ба саҳифаҳои бештар дастрасиро дархост кунед',
	'whitelistrequestmsg' => '$1 дастрасиро барои саҳифаҳои зерин дархост кард:

$2',
	'whitelistrequestconf' => 'Дархост барои саҳифаҳои ҷадид ба $1 фиристода шуд',
	'whitelistnever' => 'ҳеҷгоҳ',
	'whitelistnummatches' => ' - $1 мутобиқат мекунад',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'whitelist-desc' => 'Içozahoi dastrasiji korbaroni mahdudşudaro viroiş kuned',
	'whitelist' => 'Sahifahoi Fehristi safed',
	'mywhitelistpages' => 'Sahifahoi Man',
	'whitelistfor' => '<center>Ittilooti kununī baroi <b>$1</b></center>',
	'whitelisttablemodify' => 'Pirostan',
	'whitelisttablemodifyall' => 'Hama',
	'whitelisttablemodifynone' => 'Heç',
	'whitelisttablepage' => 'Sahifai Viki',
	'whitelisttabletype' => "Nav'i Dastrasī",
	'whitelisttableexpires' => 'Siparī meşavad dar',
	'whitelisttablemodby' => 'Oxirin marotiba pirosta şuda bud tavassuti',
	'whitelisttablemodon' => 'Oxirin marotiba pirosta şuda bud dar',
	'whitelisttableedit' => 'Viroiş',
	'whitelisttableview' => 'Didan',
	'whitelisttablenewdate' => "Ta'rixi Nav:",
	'whitelisttablechangedate' => "Taƣjiri Ta'rixi Baintihorasī",
	'whitelisttableremove' => 'Hazf',
	'whitelistnewtabledate' => "Ta'rixi Baintihorasī:",
	'whitelistnewtableprocess' => 'Ravand',
	'whitelistnewtablereview' => 'Peşnamoiş',
	'whitelistrequest' => 'Ba sahifahoi beştar dastrasiro darxost kuned',
	'whitelistrequestconf' => 'Darxost baroi sahifahoi çadid ba $1 firistoda şud',
	'whitelistnever' => 'heçgoh',
);

/** Thai (ไทย)
 * @author Manop
 * @author Octahedron80
 */
$messages['th'] = array(
	'whitelisttablemodify' => 'ปรับปรุง',
	'whitelisttablemodifyall' => 'ทั้งหมด',
	'whitelisttablemodifynone' => 'ไม่มีค่า',
	'whitelisttablepage' => 'หน้าวิกิ',
	'whitelisttableedit' => 'แก้ไข',
	'whitelisttableview' => 'ดู',
	'whitelisttablenewdate' => 'วันที่ใหม่:',
	'whitelistnewtabledate' => 'วันที่หมดอายุ:',
	'whitelistnewtablereview' => 'ตรวจสอบ',
	'whitelistpagelist' => 'หน้า {{SITENAME}} สำหรับ $1',
	'group-manager' => 'ผู้จัดการ',
	'group-manager-member' => 'ผู้จัดการ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'whitelisttablemodify' => 'Üýtget',
	'whitelisttablemodifyall' => 'Ählisi',
	'whitelisttablemodifynone' => 'Hiç',
	'whitelisttablepage' => 'Wiki sahypasy',
	'whitelisttabletype' => 'Barma tipi',
	'whitelisttableexpires' => 'Gutarýar',
	'whitelisttablemodby' => 'Soňky üýtgedileni',
	'whitelisttablemodon' => 'Soňky üýtgedileni',
	'whitelisttableedit' => 'Redaktirle',
	'whitelisttableview' => 'Görkez',
	'whitelisttablenewdate' => 'Täze sene',
	'whitelisttablechangedate' => 'Gutarýan wagtyny ýtget',
	'whitelisttablesetedit' => 'Redaktirlemä sazla',
	'whitelisttablesetview' => 'Görkezmä sazla',
	'whitelisttableremove' => 'Aýyr',
	'whitelistnewtableprocess' => 'Proses',
	'whitelistnewtablereview' => 'Gözden geçir',
	'group-restricted' => 'Çäklendirilen ulanyjylar',
	'group-restricted-member' => 'Çäklendirilen ulanyjy',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'whitelist-desc' => 'Baguhin ang mga pahintulot na pangakseso ng pinagbabawalang mga tagagamit',
	'whitelistedit' => 'Patnugot na may akseso sa "puting talaan"',
	'whitelist' => 'Mga pahina ng "puting talaan"',
	'mywhitelistpages' => 'Mga pahina ko',
	'whitelistfor' => '<center>Pangkasalukuyang kabatiran para sa/kay <b>$1</b></center>',
	'whitelisttablemodify' => 'Baguhin',
	'whitelisttablemodifyall' => 'Lahat',
	'whitelisttablemodifynone' => 'Wala',
	'whitelisttablepage' => 'Pahina ng Wiki',
	'whitelisttabletype' => 'Uri ng akseso',
	'whitelisttableexpires' => 'Magwawakas sa',
	'whitelisttablemodby' => 'Huling binago ni',
	'whitelisttablemodon' => 'Huling nabago noong',
	'whitelisttableedit' => 'Baguhin',
	'whitelisttableview' => 'Tingnan',
	'whitelisttablenewdate' => 'Bagong petsa:',
	'whitelisttablechangedate' => 'Baguhin ang petsa ng pagwawakas:',
	'whitelisttablesetedit' => 'Itakda sa makapagbabago',
	'whitelisttablesetview' => 'Itakda bilang matitingnan',
	'whitelisttableremove' => 'Tanggalin',
	'whitelistnewpagesfor' => 'Magdagdag ng bagong mga pahina sa "puting talaan" ni <b>$1</b><br />
Gumamit ng * o kaya % bilang panitik (karakter) na "barahang pamalit"',
	'whitelistnewtabledate' => 'Petsa ng pagwawakas:',
	'whitelistnewtableedit' => 'Itakda sa makapagbabago',
	'whitelistnewtableview' => 'Itakda bilang matatanaw',
	'whitelistnowhitelistedusers' => 'Walang mga tagagamit sa pangkat na "{{MediaWiki:Pinagbawalang-Pangkat}}".
Kailangan mong [[Special:UserRights|magdagdag ng mga tagagamit sa pangkat]] bago ka makapagdag ng mga pahina sa "puting talaan" ng isang tagagamit.',
	'whitelistnewtableprocess' => 'Isagawa',
	'whitelistnewtablereview' => 'Suriing muli',
	'whitelistselectrestricted' => '== Piliin ang pangalan ng pinagbabawalang tagagamit ==',
	'whitelistpagelist' => 'Mga pahina sa {{SITENAME}} para kay $1',
	'whitelistnocalendar' => "<font color='red' size=3>Tila hindi nainstala/nailuklok ng tama ang [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Karugtong:PaggamitEstadistika], na isang pangangailangan para sa karugtong (ekstensyon) na ito!</font>",
	'whitelistoverview' => '== Pagtunghay ng mga pagbabago para sa/kay $1 ==',
	'whitelistoverviewcd' => "* Pinapalitan ang petsa patungong '''$1''' para kay [[:$2|$2]]",
	'whitelistoverviewsa' => "* Itinatakda ang akseso sa '''$1''' para kay [[:$2|$2]]",
	'whitelistoverviewrm' => '* Tinatanggal ang akseso sa [[:$1|$1]]',
	'whitelistoverviewna' => "* Idinaragdag ang [[:\$1|\$1]] sa \"puting talaan\" na may aksesong '''\$2''' at katapusang petsang '''\$3'''",
	'whitelistrequest' => 'Humiling ng akseso para sa mas marami pang mga pahina',
	'whitelistrequestmsg' => 'Humihiling si $1 ng akseso patungo sa sumusunod na {{PLURAL:$3|pahina|mga pahina}}:

$2',
	'whitelistrequestconf' => 'Ipinadala kay $1 ang kahilingan para sa bagong mga pahina',
	'whitelistnonrestricted' => "Hindi isang pinagbabawalang tagagamit si '''$1'''.
Nararapat lamang para sa pinagbabawalang mga tagagamit ang pahinang ito",
	'whitelistnever' => 'hindi kailanman',
	'whitelistnummatches' => '  - {{PLURAL:$1|isang katugma|$1 mga katugma}}',
	'right-editwhitelist' => 'Baguhin ang "puting talaan" para sa umiiral na mga tagagamit',
	'right-restricttowhitelist' => 'Baguhin at tingnan ang mga pahinang nasa "puting talaan" lamang',
	'action-editwhitelist' => 'baguhin ang "puting talaan" para sa umiiral na mga tagagamit',
	'action-restricttowhitelist' => 'Magbago ang tingnan ang mga pahinang nasa "puting talaan" lamang',
	'group-restricted' => 'Pinagbawalang mga tagagamit',
	'group-restricted-member' => 'Pinagbawalang tagagamit',
	'group-manager' => 'Mga tagapamahala',
	'group-manager-member' => 'Tagapamahala',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'whitelistedit' => 'Beyaz liste erişim editörü',
	'whitelist' => 'Beyaz liste sayfaları',
	'mywhitelistpages' => 'Sayfalarım',
	'whitelistfor' => '<center><b>$1</b> için mevcut bilgiler</center>',
	'whitelisttablemodify' => 'Değiştir',
	'whitelisttablemodifyall' => 'Hepsi',
	'whitelisttablemodifynone' => 'Hiçbiri',
	'whitelisttablepage' => 'Viki sayfası',
	'whitelisttabletype' => 'Erişim türü',
	'whitelisttablemodby' => 'Son değişikliği yapan:',
	'whitelisttablemodon' => 'Son değişiklik tarihi:',
	'whitelisttableedit' => 'Değiştir',
	'whitelisttablenewdate' => 'Yeni tarih:',
	'whitelisttablechangedate' => 'Bitiş tarihini değiştir',
	'whitelisttableremove' => 'Kaldır',
	'whitelistnewtableprocess' => 'İşlem',
	'whitelistnewtablereview' => 'İncele',
	'whitelistselectrestricted' => '== Kısıtlanmış kullanıcı adını seç ==',
	'whitelistrequest' => 'Daha fazla sayfaya erişim isteyin',
	'whitelistnever' => 'asla',
	'right-restricttowhitelist' => 'Sadece beyaz listedeki sayfaları değiştirir ve görür',
	'group-restricted' => 'Kısıtlanmış kullanıcılar',
	'group-restricted-member' => 'Kısıtlanmış kullanıcı',
	'group-manager' => 'Yöneticiler',
	'group-manager-member' => 'Yönetici',
);

/** Ukrainian (Українська)
 * @author Ahonc
 */
$messages['uk'] = array(
	'whitelist-desc' => 'Редагування прав доступу користувачів',
	'whitelistedit' => 'Редактор доступу до білого списку',
	'whitelist' => 'Сторінки білого списку',
	'mywhitelistpages' => 'Мої сторінки',
	'whitelistfor' => '<center>Актуальна інформація для <b>$1</b></center>',
	'whitelisttablemodify' => 'Змінити',
	'whitelisttablemodifyall' => 'Усі',
	'whitelisttablemodifynone' => 'Жодного',
	'whitelisttablepage' => 'Вікі-сторінка',
	'whitelisttabletype' => 'Тип доступу',
	'whitelisttableexpires' => 'Закінчується',
	'whitelisttablemodby' => 'Востаннє змінена користувачем',
	'whitelisttablemodon' => 'Востаннє змінена о',
	'whitelisttableedit' => 'Редагувати',
	'whitelisttableview' => 'Переглянути',
	'whitelisttablenewdate' => 'Нова дата:',
	'whitelisttablechangedate' => 'Змінити дату закінчення',
	'whitelisttablesetedit' => 'Установити для редагування',
	'whitelisttablesetview' => 'Установити для перегляду',
	'whitelisttableremove' => 'Вилучити',
	'whitelistnewtabledate' => 'Дата закінчення:',
	'whitelistnewtableedit' => 'Установити для редагування',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'whitelistedit' => 'Vauktan nimikirjutesennoks pästtud ristitud',
	'whitelist' => 'Vauktan nimikirjutesen lehtpoled',
	'mywhitelistpages' => 'Minun lehtpoled',
	'whitelistfor' => '<center>Aktualine informacii <b>$1</b>-kävutajan täht</center>',
	'whitelisttablemodify' => 'Modificiruida',
	'whitelisttablemodifyall' => 'Kaik',
	'whitelisttablemodifynone' => 'Nimidä',
	'whitelisttablepage' => "Wikin lehtpol'",
	'whitelisttableedit' => 'Redaktiruida',
	'whitelisttableview' => 'Nähta',
	'whitelisttablenewdate' => "Uz' dat:",
	'whitelisttablechangedate' => 'Lopstrokun datan vajehtuz',
	'whitelisttableremove' => 'Čuta poiš',
	'whitelistnewtableprocess' => 'Process',
	'whitelistnever' => 'nikonz',
	'group-restricted' => 'Kaidetud kävutajad',
	'group-restricted-member' => 'Kaidetud kävutai',
	'group-manager' => 'Menadžerad',
	'group-manager-member' => 'Menadžer',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'whitelist' => 'Trang trong danh sách trắng',
	'mywhitelistpages' => 'Trang cá nhân',
	'whitelisttablemodify' => 'Sửa đổi',
	'whitelisttablemodifyall' => 'Tất cả',
	'whitelisttablemodifynone' => 'Không có',
	'whitelisttablepage' => 'Trang wiki',
	'whitelisttabletype' => 'Kiểu truy cập',
	'whitelisttableexpires' => 'Hết hạn vào',
	'whitelisttablemodby' => 'Sửa đổi lần cuối bởi',
	'whitelisttablemodon' => 'Sửa đổi lần cuối vào',
	'whitelisttableedit' => 'Sửa',
	'whitelisttableview' => 'Xem',
	'whitelisttablenewdate' => 'Ngày tháng mới:',
	'whitelisttablechangedate' => 'Thay đổi ngày hạn',
	'whitelisttableremove' => 'Dời',
	'whitelistnewtabledate' => 'Ngày hạn:',
	'whitelistnewtablereview' => 'Duyệt',
	'whitelistoverviewna' => "* Thêm [[:$1|$1]] vào danh sách trắng với quyền truy cập '''$2''' và ngày hạn '''$3'''",
	'whitelistnever' => 'không bao giờ',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'whitelist' => 'Pads vietaliseda',
	'mywhitelistpages' => 'Pads obik',
	'whitelisttablemodify' => 'Votükön',
	'whitelisttablemodifyall' => 'Valiks',
	'whitelisttablemodifynone' => 'Nonik',
	'whitelisttablepage' => 'Vükapad',
	'whitelisttableedit' => 'Votükön',
	'whitelisttableview' => 'Logön',
	'whitelisttablenewdate' => 'Dät nulik:',
	'whitelisttableremove' => 'Moükön',
	'whitelistpagelist' => 'Pads ela {{SITENAME}} pro $1',
	'whitelistoverview' => '== Lovelogam votükamas ela $1 ==',
	'whitelistoverviewcd' => "* Votükam däta ad '''$1''' pro [[:$2|$2]]",
	'whitelistrequestconf' => 'Beg padas nulik pesedon ele $1',
	'whitelistnever' => 'neai',
	'right-editwhitelist' => 'Bevobön vietalisedi pro gebans dabinöl',
	'right-restricttowhitelist' => 'Votükön e logön te padis liseda vietik',
	'action-editwhitelist' => 'bevobön vietalisedi pro gebans dabinöl',
	'action-restricttowhitelist' => 'votükön e logön te padis liseda vietik',
	'group-manager' => 'Guverans',
	'group-manager-member' => 'Guveran',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'mywhitelistpages' => 'מײַנע בלעטער',
	'whitelisttablemodifyall' => 'אַלע',
	'whitelisttablemodifynone' => 'גארנישט',
	'whitelisttablepage' => 'וויקי בלאַט',
	'whitelisttableedit' => 'רעדאַקטירן',
	'whitelistnever' => 'קיינמאָל',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Liangent
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'whitelisttablemodify' => '修改',
	'whitelisttablemodifyall' => '全选',
	'whitelisttablemodifynone' => '全不选',
	'whitelisttablepage' => '维基页面',
	'whitelisttableexpires' => '失效日期',
	'whitelisttablemodby' => '最后修改者',
	'whitelisttablemodon' => '最后修改于',
	'whitelisttableedit' => '编辑',
	'whitelisttableview' => '查看',
	'whitelisttablenewdate' => '新日期：',
	'whitelisttablechangedate' => '修改失效日期',
	'whitelisttableremove' => '移除',
	'whitelistnewtabledate' => '结束日期：',
	'whitelistnowhitelistedusers' => '"{{MediaWiki:Group-restricted}}"组中没有用户。
您必须[[Special:UserRights|将用户添加到组]]后，才能将页面添加到一个用户的白名单中。',
	'whitelistnewtableprocess' => '处理',
	'whitelistnewtablereview' => '评论',
	'whitelistselectrestricted' => '== 选择受限制的用户名 ==',
	'whitelistpagelist' => '$1 的{{SITENAME}}页面',
	'whitelistoverview' => '== 查看 $1 的更改 ==',
	'whitelistoverviewcd' => "* [[:$2|$2]]，修改日期为 '''$1'''",
	'whitelistrequestmsg' => '$1请求访问以下页面：

$2',
	'whitelistrequestconf' => '新页面请求已发送到$1',
	'whitelistnonrestricted' => "用户'''$1'''不是一个受限制的用户。
这个页面只适用于受限制的用户",
	'whitelistnever' => '从不',
	'whitelistnummatches' => '  - {{PLURAL:$1|1个匹配|$1 个匹配}}',
	'right-editwhitelist' => '修改现有用户的白名单',
	'right-restricttowhitelist' => '编辑、查看白名单上的页面',
	'action-editwhitelist' => '修改现有用户的白名单',
	'action-restricttowhitelist' => '编辑、查看白名单上的页面',
	'group-restricted' => '受限用户',
	'group-restricted-member' => '受限用户',
	'group-manager' => '管理员',
	'group-manager-member' => '管理员',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'whitelisttablemodify' => '修改',
	'whitelisttablemodifyall' => '全選',
	'whitelisttablemodifynone' => '全不選',
	'whitelisttablepage' => '維基頁面',
	'whitelisttableexpires' => '失效日期',
	'whitelisttablemodby' => '最後修改者',
	'whitelisttablemodon' => '最後修改於',
	'whitelisttableedit' => '編輯',
	'whitelisttableview' => '檢視',
	'whitelisttablenewdate' => '新日期：',
	'whitelisttablechangedate' => '修改失效日期',
	'whitelisttableremove' => '移除',
	'whitelistnewtabledate' => '結束日期：',
	'whitelistnowhitelistedusers' => '"{{MediaWiki:Group-restricted}}"組中沒有用戶。
您必須[[Special:UserRights|將用戶添加到組]]后，才能將頁面添加到一個用戶的白名單中。',
	'whitelistnewtableprocess' => '處理',
	'whitelistnewtablereview' => '評論',
	'whitelistselectrestricted' => '== 選擇受限制的用戶名 ==',
	'whitelistpagelist' => '$1 的{{SITENAME}}頁面',
	'whitelistoverview' => '== 查看 $1 的更改 ==',
	'whitelistoverviewcd' => "* [[:$2|$2]]，修改日期為 '''$1'''",
	'whitelistrequestmsg' => '$1請求訪問以下頁面：

$2',
	'whitelistrequestconf' => '新頁面請求已發送到$1',
	'whitelistnonrestricted' => "用戶'''$1'''不是一個受限制的用戶。
這個頁面只適用於受限制的用戶",
	'whitelistnever' => '從不',
	'whitelistnummatches' => '  - {{PLURAL:$1|1個匹配|$1 個匹配}}',
	'right-editwhitelist' => '修改現有用戶的白名單',
	'right-restricttowhitelist' => '編輯、查看白名單上的頁面',
	'action-editwhitelist' => '修改現有用戶的白名單',
	'action-restricttowhitelist' => '編輯、查看白名單上的頁面',
	'group-restricted' => '受限用戶',
	'group-restricted-member' => '受限用戶',
	'group-manager' => '管理員',
	'group-manager-member' => '管理員',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Roc michael
 */
$messages['zh-tw'] = array(
	'whitelist-desc' => '設定受限制用戶的存取權',
	'whitelistedit' => '授權名單內的編輯用戶',
	'whitelist' => '授權清單頁面',
	'mywhitelistpages' => '我的頁面',
	'whitelistfor' => '<center><b>$1</b>的當今訊息</center>',
	'whitelisttablemodify' => '修訂',
	'whitelisttablemodifyall' => '全部',
	'whitelisttablemodifynone' => '無',
	'whitelisttablepage' => 'wiki頁面',
	'whitelisttabletype' => '存取型態',
	'whitelisttableexpires' => '到期日',
	'whitelisttablemodby' => '最後編輯者',
	'whitelisttablemodon' => '最後編輯時間',
	'whitelisttableedit' => '編輯',
	'whitelisttableview' => '查看',
	'whitelisttablenewdate' => '新日期：',
	'whitelisttablechangedate' => '更改到期日',
	'whitelisttablesetedit' => '設為可編輯',
	'whitelisttablesetview' => '設為可查看',
	'whitelisttableremove' => '刪除',
	'whitelistnewpagesfor' => '增加頁面於<b>$1</b>的編輯清單<br />
請用* 或 % 做為萬用字元。',
	'whitelistnewtabledate' => '到期日：',
	'whitelistnewtableedit' => '設為可編輯',
	'whitelistnewtableview' => '設為可查看',
	'whitelistselectrestricted' => '== 選取受限制用戶姓名 ==',
	'whitelistnummatches' => '-$1筆相符',
);

