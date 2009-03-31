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
 * @author Jon Harald Søby
 * @author Purodha
 * @author Siebrand
 */
$messages['qqq'] = array(
	'whitelist-desc' => 'Short description of the White List extension, shown on [[Special:Version]].{{doc-important|Do not translate or change links.}}',
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

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 */
$messages['af'] = array(
	'whitelisttablemodifyall' => 'Alle',
	'whitelisttablemodifynone' => 'Geen',
	'whitelisttableedit' => 'Wysig',
	'whitelisttableremove' => 'Skrap',
	'whitelistnever' => 'nooit',
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
	'whitelistbadtitle' => 'عنوان سيء -',
	'whitelistoverview' => '== مراجعة التغييرات ل$1 ==',
	'whitelistoverviewcd' => "* تغيير التاريخ إلى '''$1''' ل[[:$2|$2]]",
	'whitelistoverviewsa' => "* ضبط الدخول إلى '''$1''' ل[[:$2|$2]]",
	'whitelistoverviewrm' => '* إزالة الوصول إلى [[:$1|$1]]',
	'whitelistoverviewna' => "* إضافة [[:$1|$1]] إلى القائمة البيضاء بوصول '''$2''' و '''$3''' تاريخ انتهاء",
	'whitelistrequest' => 'طلب السماح لمزيد من الصفحات',
	'whitelistrequestmsg' => '$1 طلب الوصول إلى {{PLURAL:$3|الصفحة|الصفحات}} التالية:

$2',
	'whitelistrequestconf' => 'الطلب للصفحات الجديدة تم إرساله إلى $1',
	'whitelistnonrestricted' => "المستخدم '''$1''' ليس مستخدما محددا.
هذه الصفحة مطبقة فقط على المستخدمين المحددين",
	'whitelistnever' => 'أبدا',
	'whitelistnummatches' => ' - {{PLURAL:$1|مطابقة واحدة|$1 مطابقة}}',
	'right-editwhitelist' => 'عدل القائمة البيضاء للمستخدمون الموجودون',
	'right-restricttowhitelist' => 'تعديل وعرض الصفحات على القائمة البيضاء فقط',
	'action-editwhitelist' => 'عدل القائمة البيضاء لمستخدمين موجودين',
	'action-restricttowhitelist' => 'عدل وأعرض الصفحات على القائمة البيضاء فقط',
	'group-restricted' => 'مستخدمون محظورون',
	'group-restricted-member' => 'مستخدم محظور',
	'group-manager' => 'مديرون',
	'group-manager-member' => 'مدير',
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
	'whitelistnowhitelistedusers' => 'مافيش يوزرز في الجروب دي "{{MediaWiki:Group-restricted}}".
لازم [[Special:UserRights|تضيف يوزرز للجروب]] قبل ما تقدر تضيف صفحات لـ الليستة البيضا بتاعة اي يوزر.',
	'whitelistnewtableprocess' => 'عملية',
	'whitelistnewtablereview' => 'مراجعة',
	'whitelistselectrestricted' => '== اختار اسم اليوزر المتحدد ==',
	'whitelistpagelist' => 'صفحات {{SITENAME}} ل$1',
	'whitelistnocalendar' => "<font color='red' size=3> الظاهر ان[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics]، المطلوب للامتداد دا،ما اتستبش صح!</font>",
	'whitelistbadtitle' => 'عنوان بايظ -',
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
	'right-restricttowhitelist' => 'عدل و شوف الصفحات اللي في الليستة البيضا بس.',
	'action-editwhitelist' => 'عدل الليستة البيضا بتاعة اليوزرز الموجودين',
	'action-restricttowhitelist' => 'عدل و شوف الصفحات اللي في الليستة البيضا بس',
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
 */
$messages['be-tarask'] = array(
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
	'whitelisttablechangedate' => 'Зьмяніць тэрміну дзеяньня',
	'whitelisttablesetedit' => 'Усталяваць для рэдагаваньня',
	'whitelisttablesetview' => 'Усталяваць для прагляду',
	'whitelisttableremove' => 'Выдаліць',
	'whitelistnever' => 'ніколі',
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
	'whitelistbadtitle' => 'Грешно заглавие -',
	'whitelistoverviewcd' => "* Промяна на датата за [[:$2|$2]] на '''$1'''",
	'whitelistoverviewrm' => '* Премахване на достъпа до [[:$1|$1]]',
	'whitelistrequest' => 'Поискване на достъп до още страници',
	'whitelistrequestmsg' => '$1 пожела достъп до {{PLURAL:$3|следната страница|следните страници}}:

$2',
	'whitelistrequestconf' => 'Заявка за нови страници беше изпратена на $1',
	'whitelistnever' => 'никога',
	'whitelistnummatches' => ' - {{PLURAL:$1|едно съвпадение|$1 съвпадения}}',
	'group-manager' => 'Управители',
	'group-manager-member' => 'Управител',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'mywhitelistpages' => 'Ma fajennoù',
	'whitelisttablemodifyall' => 'Pep tra',
	'whitelisttablemodifynone' => 'Hini ebet',
	'whitelisttablepage' => 'Pajenn wiki',
	'whitelisttableedit' => 'Kemmañ',
	'whitelisttableview' => 'Gwelet',
	'whitelisttablenewdate' => 'Deiziad nevez :',
	'whitelisttableremove' => 'Tennañ',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Smooth O
 */
$messages['bs'] = array(
	'whitelist-desc' => 'Uređivanje dopuštenja pristupa za ograničene korisnike',
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
	'whitelisttablesetview' => 'Postavi za pregled',
	'whitelisttableremove' => 'Ukloni',
	'whitelistnewtabledate' => 'Datum isteka:',
	'whitelistnewtableview' => 'Postavi za pregled',
	'whitelistnewtableprocess' => 'Proces',
	'whitelistoverview' => '== Pregled promjena za $1 ==',
	'whitelistoverviewcd' => "* Mijenjam datum na '''$1''' za [[:$2|$2]]",
	'whitelistoverviewrm' => '* Uklanjam pristup na [[:$1|$1]]',
	'whitelistrequest' => 'Traži pristup za više stranica',
	'whitelistrequestmsg' => '$1 je zahtijevao pristup {{PLURAL:$3|slijedećoj stranici|slijedećim stranicama}}:

$2',
	'whitelistrequestconf' => 'Zahtjev za nove stranice je poslan na $1',
	'whitelistnever' => 'nikad',
	'whitelistnummatches' => '- {{PLURAL:$1|$1 pogodak|$1 pogotka|$1 pogodaka}}',
	'right-editwhitelist' => 'Prilagođavanje dopuštenog spiska za postojeće korisnike',
	'right-restricttowhitelist' => 'Uređivanje i pregled stranica samo sa dopuštenog spiska',
	'action-editwhitelist' => 'promijenite dopušteni spisak za postojeće korisnike',
	'action-restricttowhitelist' => 'uredi i pregledaj stranice samo na dopuštenom spisku',
	'group-manager' => 'Upravljači',
	'group-manager-member' => 'Upravljač',
);

/** Catalan (Català)
 * @author Jordi Roqué
 * @author SMP
 */
$messages['ca'] = array(
	'whitelisttablemodifynone' => 'Cap',
	'whitelisttableedit' => 'Edita',
	'whitelistnever' => 'mai',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'whitelisttableedit' => 'Tulaika',
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
	'whitelistbadtitle' => 'Chybný název -',
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
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'whitelisttablemodifynone' => 'Ingen',
	'whitelisttableedit' => 'Redigér',
	'whitelistnever' => 'aldrig',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Liam Rosen
 * @author Melancholie
 * @author Pill
 * @author Revolus
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
	'whitelisttablemodby' => 'Zuletz modifiziert von',
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
	'whitelistbadtitle' => 'Titel inkompatibel -',
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
	'right-restricttowhitelist' => 'Bearbeite und betrachte nur Seiten die in der Positivliste enthalten sind',
	'action-editwhitelist' => 'modifiziere die Positivliste für existierende Benutzer',
	'action-restricttowhitelist' => 'bearbeite und betrachte nur Seiten die in der Positivliste enthalten sind',
	'group-restricted' => 'Eingeschränkte Benutzer',
	'group-restricted-member' => 'Eingeschränkter Benutzer',
	'group-manager' => 'Verwalter',
	'group-manager-member' => 'Verwalter',
);

/** Zazaki (Zazaki)
 * @author Belekvor
 */
$messages['diq'] = array(
	'whitelisttablemodifynone' => 'çino',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'whitelistnever' => 'gbeɖe',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'mywhitelistpages' => 'Οι Σελίδες μου',
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
	'whitelistbadtitle' => 'Título erróneo -',
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

/** Basque (Euskara)
 * @author An13sa
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
	'whitelistnever' => 'inoiz',
	'group-restricted' => 'Mugatutako lankideak',
	'group-restricted-member' => 'Mugatutako lankidea',
	'group-manager' => 'Administratzaileak',
	'group-manager-member' => 'Administratzaile',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
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
	'whitelistrequest' => 'Pyydä pääsyä useammille sivuille',
	'whitelistrequestmsg' => '$1 on pyytänyt pääsyä {{PLURAL:$3|seuraavalle sivulle|seuraaville sivuille}}:

$2',
	'whitelistnever' => 'ei koskaan',
	'whitelistnummatches' => '  - {{PLURAL:$1|yksi osuma|$1 osumaa}}',
	'group-restricted' => 'rajoitetut käyttäjät',
	'group-restricted-member' => 'rajoitettu käyttäjä',
);

/** French (Français)
 * @author Grondin
 * @author McDutchie
 * @author Zetud
 */
$messages['fr'] = array(
	'whitelist-desc' => 'Modifie les permissions d’accès des utilisateurs à pouvoirs restreints',
	'whitelistedit' => 'Éditeur de la liste blanche des accès',
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
	'whitelistnewtablereview' => 'Réviser',
	'whitelistselectrestricted' => '== Sélectionner un nom d’utilisateur à accès restreint ==',
	'whitelistpagelist' => 'Pages de {{SITENAME}} pour $1',
	'whitelistnocalendar' => "<font color='red' size=3>Il semble que le module [http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], une extension prérequise, n’ait pas été installée convenablement !</font>",
	'whitelistbadtitle' => 'Titre incorrect ‑',
	'whitelistoverview' => '== Vue générale des changements pour $1 ==',
	'whitelistoverviewcd' => "Modification de la date de '''$1''' pour [[:$2|$2]]",
	'whitelistoverviewsa' => "* configurer l'accès de '''$1''' pour [[:$2|$2]]",
	'whitelistoverviewrm' => '* Retrait de l’accès à [[:$1|$1]]',
	'whitelistoverviewna' => "* Ajoute [[:$1|$1]] à la liste blanche avec les droits de '''$2''' avec pour date d’expiration le '''$3'''",
	'whitelistrequest' => 'Demande d’accès à plus de pages',
	'whitelistrequestmsg' => '$1 a demandé l’accès {{PLURAL:$3|à la page suivante|aux pages suivantes}} :

$2',
	'whitelistrequestconf' => 'Une demande d’accès pour de nouvelles pages a été envoyée à $1',
	'whitelistnonrestricted' => "L'utilisateur '''$1''' n’est pas avec des droits restreints.
Cette page ne s’applique qu’aux utilisateurs disposant de droits restreints.",
	'whitelistnever' => 'jamais',
	'whitelistnummatches' => ' - {{PLURAL:$1|une occurence|$1 occurences}}',
	'right-editwhitelist' => 'Modifier la liste blanche pour les utilisateurs existants',
	'right-restricttowhitelist' => 'Modifier et visionner les pages figurant uniquement sur la liste blanche',
	'action-editwhitelist' => 'modifier la liste blanche pour les utilisateurs existants',
	'action-restricttowhitelist' => 'modifier et visionner les pages figurant uniquement sur la liste blanche',
	'group-restricted' => 'Utilisateurs restreints',
	'group-restricted-member' => 'Utilisateur restreint',
	'group-manager' => 'Gestionnaires',
	'group-manager-member' => 'Gestionnaire',
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
	'whitelistedit' => 'Editor de acceso da listaxe branca (whitelist)',
	'whitelist' => 'Páxinas da listaxe branca',
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
	'whitelistnewpagesfor' => 'Engada novas páxinas á listaxe branca de <b>$1</b><br />
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
	'whitelistbadtitle' => 'Título incorrecto -',
	'whitelistoverview' => '== Visión xeral dos cambios para $1 ==',
	'whitelistoverviewcd' => "* Cambiando a data a '''$1''' para [[:$2|$2]]",
	'whitelistoverviewsa' => "* Configurando o acceso a '''$1''' para [[:$2|$2]]",
	'whitelistoverviewrm' => '* Eliminando o acceso a [[:$1|$1]]',
	'whitelistoverviewna' => "* Engadindo [[:$1|$1]] á listaxe branca (whitelist) con acceso a '''$2''' e data de remate '''$3'''",
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

/** Gothic
 * @author Jocke Pirat
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
	'whitelisttablemodifyall' => 'Ἅπασαι',
	'whitelisttablemodifynone' => 'Οὐδέν',
	'whitelisttableedit' => 'Μεταγράφειν',
	'whitelisttableremove' => 'Άφαιρεῖν',
	'whitelistbadtitle' => 'Κακὸν τὸ ἐπώνυμον -',
	'whitelistnever' => 'οὔποτε',
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
	'whitelisttableedit' => 'E ho‘opololei',
	'whitelisttableremove' => 'Kāpae',
	'whitelistbadtitle' => 'Inoa ‘ino -',
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
	'whitelistbadtitle' => 'כותרת בלתי תקינה -',
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
 */
$messages['hu'] = array(
	'whitelisttablemodifynone' => 'Nincs',
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
	'whitelistbadtitle' => 'Titulo incorrecte -',
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
 * @author Rex
 */
$messages['id'] = array(
	'whitelisttablemodifyall' => 'Semua',
	'whitelisttablemodifynone' => 'Tidak ada',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'whitelistbadtitle' => 'Slæmur titill -',
	'whitelistnever' => 'aldrei',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'whitelisttableedit' => 'Modifica',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'whitelisttablemodifyall' => 'すべて',
	'whitelisttablemodifynone' => 'なし',
	'whitelisttablepage' => 'ウィキページ',
	'whitelisttabletype' => 'アクセスタイプ',
	'whitelisttableedit' => '編集',
	'whitelisttableremove' => '削除',
	'whitelistnewtableprocess' => 'プロセス',
	'whitelistnewtablereview' => 'レビュー',
	'whitelistnever' => '無期限',
	'group-restricted' => '制限付ユーザー',
	'group-restricted-member' => '制限付ユーザー',
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
	'whitelistbadtitle' => 'Judhul ala -',
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
	'whitelistnewtableprocess' => 'Verschaffen',
	'whitelistnewtablereview' => 'Nokucken',
	'whitelistselectrestricted' => '== Limitéierte Benotzernumm wielen ==',
	'whitelistpagelist' => 'Säite vu(n) {{SITENAME}} fir $1',
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
 * @author Brest
 */
$messages['mk'] = array(
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
);

/** Malayalam (മലയാളം)
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
	'whitelistbadtitle' => 'അസാധുവായ തലക്കെട്ട്',
	'whitelistnever' => 'ഒരിക്കലും അരുത്:',
	'whitelistnummatches' => ' - $1 യോജിച്ച ഫലങ്ങള്‍',
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
	'whitelistbadtitle' => 'चुकीचे शीर्षक -',
	'whitelistrequest' => 'अधिक पानांकरिता उपलब्धता सुसाध्य करून मागा',
	'whitelistrequestmsg' => '$1ने निम्ननिर्देशित पानांकरिता सुलभमार्ग सुसाध्य करून मागितला आहे:

$2',
	'whitelistrequestconf' => 'नवीन पानांची मागणी $1 ला पाठविलेली आहे',
	'whitelistnonrestricted' => "सदस्य '''$1''' हा प्रतिबंधित सदस्य नाही.
हे पान फक्त प्रतिबंधित सदस्यांसाठीच आहे",
	'whitelistnever' => 'कधीही नाही',
	'whitelistnummatches' => ' - $1 जुळण्या',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'whitelisttablemodifyall' => 'Весе',
	'whitelisttableremove' => 'Нардык',
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
	'whitelistbadtitle' => 'Ahcualli tōcāitl -',
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
	'whitelisttableexpires' => 'Verloopt op',
	'whitelisttablemodby' => 'Laatste bewerking door',
	'whitelisttablemodon' => 'Laatste wijziging op',
	'whitelisttableedit' => 'Bewerken',
	'whitelisttableview' => 'Bekijken',
	'whitelisttablenewdate' => 'Nieuwe datum:',
	'whitelisttablechangedate' => 'Verloopdatum bewerken',
	'whitelisttablesetedit' => 'Op bewerken instellen',
	'whitelisttablesetview' => 'Op bekijken instellen',
	'whitelisttableremove' => 'Verwijderen',
	'whitelistnewpagesfor' => "Nieuwe pagina's aan de witte lijst voor <b>$1</b> toevoegen<br />
Gebruik * of % als wildcard",
	'whitelistnewtabledate' => 'Verloopdatum:',
	'whitelistnewtableedit' => 'Op bewerken instellen',
	'whitelistnewtableview' => 'Op bekijken instellen',
	'whitelistnowhitelistedusers' => 'Er zijn geen gebruikers die lid zijn van de groep "{{MediaWiki:Group-restricted}}".
U moet [[Special:UserRights|gebruikers aan de groep toevoegen]] voordat u pagina\'s kunt toevoegen aan de witte lijst voor een gebruiker.',
	'whitelistnewtableprocess' => 'Bewerken',
	'whitelistnewtablereview' => 'Controleren',
	'whitelistselectrestricted' => '== Gebruiker met beperkingen selecteren ==',
	'whitelistpagelist' => "{{SITENAME}} pagina's voor $1",
	'whitelistnocalendar' => "<font color='red' size=3>[http://www.mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], een voorwaarde voor deze uitbreiding, lijkt niet juist geïnstalleerd!</font>",
	'whitelistbadtitle' => 'Onjuiste naam -',
	'whitelistoverview' => '== Overzicht van wijzigingen voor $1 ==',
	'whitelistoverviewcd' => "* verloopdatum gewijzigd naar '''$1''' voor [[:$2|$2]]",
	'whitelistoverviewsa' => "* toegangstype '''$1''' ingesteld voor [[:$2|$2]]",
	'whitelistoverviewrm' => '* toegang voor [[:$1|$1]] wordt verwijderd',
	'whitelistoverviewna' => "* [[:$1|$1]] wordt toegevoegd aan de witte lijst met toegangstype '''$2''' en verloopdatum '''$3'''",
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
	'whitelisttableexpires' => 'Utgår',
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
	'whitelistbadtitle' => 'Ugyldig tittel -',
	'whitelistoverview' => '== Oversikt over endringar for $1 ==',
	'whitelistoverviewcd' => "* Endrar dato for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewsa' => "* Set tilgang for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewrm' => '* Fjernar tilgang til [[:$1|$1]]',
	'whitelistoverviewna' => "* Legg til [[:$1|$1]] til kviteliste med tilgang '''$2''' og utløpsdato '''$3'''.",
	'whitelistrequest' => 'Spør etter tilgang til fleire sider',
	'whitelistrequestmsg' => '$1 har etterspurt tilgang til følgjande sider:

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
 * @author Jon Harald Søby
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
	'whitelistnewtableprocess' => 'Prosess',
	'whitelistnewtablereview' => 'Gå gjennom',
	'whitelistselectrestricted' => '== ANgi navn på begrenset bruker ==',
	'whitelistpagelist' => '{{SITENAME}}-sider for $1',
	'whitelistnocalendar' => '<font color="red" size="3">Det virker som om [http://mediawiki.org/wiki/Extension:Usage_Statistics Extension:UsageStatistics], en forutsetning for denne utvidelsen, ikke har blitt installert ordentlig.</font>',
	'whitelistbadtitle' => 'Ugyldig tittel -',
	'whitelistoverview' => '== Oversikt over endringer for $1 ==',
	'whitelistoverviewcd' => "* Endrer dato for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewsa' => "* Setter tilgang for [[:$2|$2]] til '''$1'''",
	'whitelistoverviewrm' => '* Fjerner tilgang til [[:$1|$1]]',
	'whitelistoverviewna' => "* Legger til [[:$1|$1]] til hviteliste med tilgang '''$2''' og utløpsdato '''$3'''.",
	'whitelistrequest' => 'Etterspør tilgang til flere sider',
	'whitelistrequestmsg' => '$1 har etterspurt tilgang til følgende sider:

$2',
	'whitelistrequestconf' => 'Etterspørsel om nye sider har blitt sendt til $1',
	'whitelistnonrestricted' => "'''$1''' er ikke en begrenset bruker.
Denne siden kan kun brukes på begrensede brukere.",
	'whitelistnever' => 'aldri',
	'whitelistnummatches' => ' - $1 {{PLURAL:$1|treff}}',
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
	'whitelistbadtitle' => 'Títol incorrècte ‑',
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
	'whitelistbadtitle' => 'Æнæмбæлон сæргонд —',
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
	'whitelistnowhitelistedusers' => 'Nie ma żadnych użytkowników w grupie „{{MediaWiki:Group-restricted}}”.
Musisz [[Special:UserRights|dodać użytkowników do tej grupy]] zanim będziesz mógł dodawać strony do whitelisty użytkownika.',
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
	'right-editwhitelist' => 'Zmień whitelistę dla istniejących użytkowników',
	'right-restricttowhitelist' => 'Edytowanie i przeglądanie strony wyłącznie z białej listy',
	'action-editwhitelist' => 'modyfikowania białej listy dla istniejących użytkowników',
	'action-restricttowhitelist' => 'edytowania i przeglądania wyłącznie białej listy',
	'group-restricted' => 'Ograniczenie użytkownicy',
	'group-restricted-member' => 'Ograniczony użytkownik',
	'group-manager' => 'Zarządzający',
	'group-manager-member' => 'Zarządzający',
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
	'whitelisttableview' => 'کتل',
	'whitelisttablenewdate' => 'نوې نېټه:',
	'whitelisttableremove' => 'غورځول',
	'whitelistnewtabledate' => 'د پای نېټه:',
	'whitelistnewtablereview' => 'مخکتنه',
	'whitelistbadtitle' => 'ناسم سرليک -',
	'whitelistrequestconf' => '$1 ته د نوي مخونو غوښتنه ولېږل شوه',
	'whitelistnever' => 'هېڅکله',
);

/** Portuguese (Português)
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'whitelist' => 'Páginas na lista branca',
	'mywhitelistpages' => 'Minhas Páginas',
	'whitelistfor' => '<center>Informação actual para <b>$1</b></center>',
	'whitelisttablemodify' => 'Modificar',
	'whitelisttablepage' => 'página wiki',
	'whitelisttabletype' => 'Tipo de acesso',
	'whitelisttableexpires' => 'Expira a',
	'whitelisttablemodby' => 'Última modificação por',
	'whitelisttablemodon' => 'Última modificação a',
	'whitelisttableedit' => 'Editar',
	'whitelisttableview' => 'Ver',
	'whitelisttablenewdate' => 'Nova Data:',
	'whitelisttableremove' => 'Remover',
	'whitelistnewpagesfor' => 'Adicione novas páginas à lista branca de <b>$1</b><br />
Use * ou % como carácter polivalente',
	'whitelistpagelist' => 'Página de {{SITENAME}} para $1',
	'whitelistrequest' => 'Requisitar acesso a mais páginas',
	'whitelistrequestmsg' => '$1 requisitou acesso {{PLURAL:$3|à seguinte página|às seguintes páginas}}:

$2',
	'whitelistrequestconf' => 'A requisição para novas páginas foi enviada para $1',
	'whitelistnonrestricted' => "O utilizador '''$1''' não é um utilizador restrito.
Esta página só se aplica a utilizadores restritos.",
	'whitelistnever' => 'nunca',
	'whitelistnummatches' => ' - {{PLURAL:$1|um resultado|$1 resultados}}',
	'group-restricted' => 'Utilizadores restritos',
	'group-restricted-member' => 'Utilizador restrito',
	'group-manager' => 'Gestores',
	'group-manager-member' => 'Gestor',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Heldergeovane
 */
$messages['pt-br'] = array(
	'whitelist-desc' => 'Edita as permissões de acesso de usuários restritos',
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
	'whitelisttableremove' => 'Remover',
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'whitelisttablemodifyall' => 'Maṛṛa',
	'whitelisttableedit' => 'Arri',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'mywhitelistpages' => 'Paginile mele',
	'whitelisttablemodify' => 'Modifică',
	'whitelisttablemodifynone' => 'Nimic',
	'whitelisttablepage' => 'Pagină wiki',
	'whitelisttabletype' => 'Tip de acces',
	'whitelisttableexpires' => 'Expiră la',
	'whitelisttablemodby' => 'Ultima dată modificat de',
	'whitelisttablemodon' => 'Ultima dată modificat la',
	'whitelisttableedit' => 'Modifică',
	'whitelisttablenewdate' => 'Dată nouă:',
	'whitelisttableremove' => 'Elimină',
	'whitelistbadtitle' => 'Titlu incorect -',
	'whitelistrequestmsg' => '$1 a cerut acces la {{PLURAL:$3|următoarea pagină|următoarele pagini}}:

$2',
	'whitelistrequestconf' => 'Cererea pentru pagini noi a fost trimisă la $1',
	'whitelistnonrestricted' => "Utilizatorul '''$1''' nu este un utilizator restricţionat.
Această pagină este aplicabilă doar utilizatorilor restricţionaţi",
	'whitelistnever' => 'niciodată',
	'group-restricted' => 'Utilizatori restricţionaţi',
	'group-restricted-member' => 'Utilizator restricţionat',
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
	'whitelisttableedit' => 'Править',
	'whitelisttableview' => 'Просмотр',
	'whitelisttablenewdate' => 'Новая дата:',
	'whitelisttablechangedate' => 'Изменение срока действия',
	'whitelisttablesetedit' => 'Установить для правки',
	'whitelisttablesetview' => 'Установить для просмотра',
	'whitelisttableremove' => 'Удалить',
	'whitelistnewtabledate' => 'Дата окончания:',
	'whitelistnewtableedit' => 'Установить для редактирования',
	'whitelistnewtableview' => 'Установить для просмотра',
	'whitelistnowhitelistedusers' => 'В группе «{{MediaWiki:Group-restricted}}» нет участников.
Вы должны [[Special:UserRights|добавить пользователей в группу]], прежде чем вы сможете добавить страницы участников в белый список.',
	'whitelistnewtableprocess' => 'Процесс',
	'whitelistnewtablereview' => 'Обзор',
	'whitelistselectrestricted' => '== Выберите имя участника ==',
	'whitelistpagelist' => 'Страницы {{SITENAME}} для $1',
	'whitelistoverview' => '== Обзор изменений для $1 ==',
	'whitelistoverviewcd' => "* Изменение даты на '''$1''' для [[:$2|$2]]",
	'whitelistoverviewsa' => "* Установить доступ '''$1''' для [[:$2|$2]]",
	'whitelistoverviewrm' => '* Снять права [[:$1|$1]]',
	'whitelistoverviewna' => "* Добавление [[:$1|$1]] в белый список с доступом '''$2''' и датой истечения срока '''$3'''",
	'whitelistrequest' => 'Запрос доступа к большему количеству страниц',
	'whitelistrequestmsg' => '$1 запросил доступ к {{PLURAL:$3|следующей странице|следующим страницам}}:

$2',
	'whitelistrequestconf' => 'Запрос по новым страницам был отправлен $1',
	'whitelistnever' => 'никогда',
	'whitelistnummatches' => '  - $1 {{PLURAL:$1|совпадение|совпадения|совпадений}}',
	'right-editwhitelist' => 'Изменить белый список для существующих участников',
	'right-restricttowhitelist' => 'Редактировать и просматривать только страницы из белого списка',
	'action-editwhitelist' => 'изменить белый список для существующих участников',
	'action-restricttowhitelist' => 'редактировать и просматривать страницы только из белого списка',
	'group-manager' => 'Управляющие',
	'group-manager-member' => 'управляющий',
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
	'whitelistbadtitle' => 'Chybný názov -',
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

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'whitelisttablemodifynone' => 'Нема',
	'whitelisttableedit' => 'Уреди',
	'whitelisttableremove' => 'Уклони',
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
	'whitelistbadtitle' => 'Dålig titel -',
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
	'whitelistbadtitle' => 'Zuy titel',
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
 * @author Veeven
 */
$messages['te'] = array(
	'mywhitelistpages' => 'నా పేజీలు',
	'whitelistfor' => '<center><b>$1</b> కొరకు ప్రస్తుత సమాచారం</center>',
	'whitelisttablemodifyall' => 'అన్నీ',
	'whitelisttablepage' => 'వికీ పేజీ',
	'whitelisttableexpires' => 'కాలంచెల్లు తేదీ',
	'whitelisttablemodby' => 'చివరగా మార్చినది',
	'whitelisttablemodon' => 'చివరి మార్పు తేదీ',
	'whitelisttableedit' => 'మార్చు',
	'whitelisttableview' => 'చూడండి',
	'whitelisttablenewdate' => 'కొత్త తేదీ:',
	'whitelisttableremove' => 'తొలగించు',
	'whitelistnewtabledate' => 'కాల పరిమితి:',
	'whitelistnewtablereview' => 'సమీక్షించు',
	'whitelistpagelist' => '$1 కై {{SITENAME}} పేజీలు',
	'whitelistbadtitle' => 'తప్పు శీర్షిక -',
	'whitelistrequest' => 'మరిన్ని పేజీలకు అనుమతిని అభ్యర్థించండి',
	'whitelistrequestmsg' => 'ఈ క్రింది {{PLURAL:$3|పేజీకి|పేజీలకు}} $1 అనుమతిని అడిగారు:

$2',
	'whitelistrequestconf' => 'కొత్త పేజీలకై అభ్యర్థనని $1 కి పంపించాం',
	'whitelistnummatches' => ' - {{PLURAL:$1|ఒక పోలిక|$1 పోలికలు}}',
	'group-restricted' => 'నియంత్రిత వాడుకరులు',
	'group-restricted-member' => 'నియంత్రిత వాడుకరి',
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
	'whitelistbadtitle' => 'Унвони номуносиб -',
	'whitelistrequest' => 'Ба саҳифаҳои бештар дастрасиро дархост кунед',
	'whitelistrequestmsg' => '$1 дастрасиро барои саҳифаҳои зерин дархост кард:

$2',
	'whitelistrequestconf' => 'Дархост барои саҳифаҳои ҷадид ба $1 фиристода шуд',
	'whitelistnever' => 'ҳеҷгоҳ',
	'whitelistnummatches' => ' - $1 мутобиқат мекунад',
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
	'whitelistbadtitle' => 'Masamang pamagat -',
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
 */
$messages['tr'] = array(
	'mywhitelistpages' => 'Sayfalarım',
	'whitelisttablemodifyall' => 'Hepsi',
	'whitelisttablemodifynone' => 'Hiçbiri',
	'whitelisttableedit' => 'Değiştir',
	'whitelisttableremove' => 'Kaldır',
	'whitelistbadtitle' => 'Geçersiz başlık -',
	'whitelistnever' => 'asla',
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

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'whitelisttablemodifyall' => 'Tất cả',
	'whitelisttablemodifynone' => 'Không có',
	'whitelisttableedit' => 'Sửa',
	'whitelisttablenewdate' => 'Ngày tháng mới:',
	'whitelisttablechangedate' => 'Thay đổi ngày hạn',
	'whitelisttableremove' => 'Dời',
	'whitelistnewtabledate' => 'Ngày hạn:',
	'whitelistbadtitle' => 'Tựa trang sai –',
	'whitelistoverviewna' => "* Thêm [[:$1|$1]] vào danh sách trắng với quyền truy cập '''$2''' và ngày hạn '''$3'''",
	'whitelistnever' => 'không bao giờ',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'mywhitelistpages' => 'Pads obik',
	'whitelisttablemodify' => 'Votükön',
	'whitelisttablemodifynone' => 'Nonik',
	'whitelisttableedit' => 'Votükön',
	'whitelisttableview' => 'Logön',
	'whitelisttablenewdate' => 'Dät nulik:',
	'whitelisttableremove' => 'Moükön',
	'whitelistoverview' => '== Lovelogam votükamas ela $1 ==',
	'whitelistoverviewcd' => "* Votükam däta ad '''$1''' pro [[:$2|$2]]",
	'whitelistrequestconf' => 'Beg padas nulik pesedon ele $1',
	'whitelistnever' => 'neai',
	'right-restricttowhitelist' => 'Votükön e logön te padis liseda vietik',
	'action-restricttowhitelist' => 'votükön e logön te padis liseda vietik',
	'group-manager' => 'Guverans',
	'group-manager-member' => 'Guveran',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
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

