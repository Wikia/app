<?php
/**
 * Internationalisation file for extension Wikimedia Messages
 *
 * @addtogroup Extensions
 * @comment TODO:
 * @comment + Remove current events and community portal from the default sidebar
 * @comment + and add those messages to here
 * @comment + Make the help links on non-Wikimedia sites point to mediawiki.org?
 */

$messages = array();

$messages['en'] = array(
	'wikimediamessages-desc' => 'Wikimedia specific messages',
	'sitesupport-url'        => 'http://wikimediafoundation.org/wiki/Donate', # do not translate this URL to other languages until a donation page, approved by Wikimedia Foundation, exists
	'sitesupport'            => 'Donate',
	'tooltip-n-sitesupport'  => 'Support us',
	'sidebar'                =>  '* navigation
** mainpage|mainpage-description
** portal-url|portal
** currentevents-url|currentevents
** recentchanges-url|recentchanges
** randompage-url|randompage
** helppage|help
** sitesupport-url|sitesupport', # do not translate or duplicate this message to other languages

	# Per http://lists.wikimedia.org/pipermail/wikitech-l/2008-September/039454.html
	'robots.txt'  => '# Lines here will be added to the global robots.txt', # do not translate or duplicate this message to other languages

	# Wikimedia specific usergroups
	'group-accountcreator'        => 'Account creators',
	'group-autopatroller'         => 'Autopatrollers',
	'group-developer'             => 'Developers',
	'group-founder'               => 'Founders',
	'group-import'                => 'Importers',
	'group-ipblock-exempt'        => 'IP block exemptions',
	'group-rollbacker'            => 'Rollbackers',
	'group-transwiki'             => 'Transwiki importers',
	'group-uploader'              => 'Uploaders',

	'group-accountcreator-member' => 'account creator',
	'group-autopatroller-member'  => 'autopatroller',
	'group-developer-member'      => 'developer',
	'group-founder-member'        => 'founder',
	'group-import-member'         => 'importer',
	'group-ipblock-exempt-member' => 'IP block exempt',
	'group-rollbacker-member'     => 'rollbacker',
	'group-transwiki-member'      => 'transwiki importer',
	'group-uploader-member'       => 'uploader',

	'grouppage-accountcreator' => '{{ns:project}}:Account creators',
	'grouppage-autopatroller'  => '{{ns:project}}:Autopatrollers',
	'grouppage-developer'      => '{{ns:project}}:Developers',
	'grouppage-founder'        => '{{ns:project}}:Founders',
	'grouppage-import'         => '{{ns:project}}:Importers',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP block exemption',
	'grouppage-rollbacker'     => '{{ns:project}}:Rollbackers',
	'grouppage-transwiki'      => '{{ns:project}}:Transwiki importers',
	'grouppage-uploader'       => '{{ns:project}}:Uploaders',

	# Global Wikimedia specific usergroups (defined on http://meta.wikimedia.org/wiki/Special:GlobalGroupPermissions)

	'group-steward'         => 'Stewards',
	'group-sysadmin'        => 'System administrators',
	'group-Global_bot'      => 'Global bots',
	'group-Global_rollback' => 'Global rollbackers',
	'group-Ombudsmen'       => 'Ombudsmen',

	'group-steward-member'         => 'steward',
	'group-sysadmin-member'        => 'system administrator',
	'group-Global_bot-member'      => 'global bot',
	'group-Global_rollback-member' => 'global rollbacker',
	'group-Ombudsmen-member'       => 'ombudsman',

	'grouppage-steward'         => 'm:Stewards', # only translate this message to other languages if you have to change it
	'grouppage-sysadmin'        => 'm:System administrators', # only translate this message to other languages if you have to change it
	'grouppage-Global_bot'      => 'm:Global bot', # only translate this message to other languages if you have to change it
	'grouppage-Global_rollback' => 'm:Global rollback', # only translate this message to other languages if you have to change it
	'grouppage-Ombudsmen'       => 'm:Ombudsman commission', # only translate this message to other languages if you have to change it

	# mediawiki.org specific user group

	'group-coder'        => 'Coders',
	'group-coder-member' => 'coder',
	'grouppage-coder'    => 'Project:Coder', # only translate this message to other languages if you have to change it
	
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Jon Harald Søby
 * @author Meno25
 * @author Purodha
 * @author SPQRobin
 * @author Siebrand
 */
$messages['qqq'] = array(
	'wikimediamessages-desc' => 'Short description of the Wikimediamessages extension, shown in [[Special:Version]].{{doc-important|Do not translate or change links.}}',
	'sitesupport-url' => 'Wikimedia-specific message used in the sidebar.
{{doc-important|Only change the link if it has a translation!|([http://wikimediafoundation.org/wiki/Special:Prefixindex/Donate/ check])}}',
	'sitesupport' => "Display name for the 'Donations' page, shown in the sidebar menu of all pages. The target page is meant to be the page where users can see how they can contribute financially to the wiki site.",
	'tooltip-n-sitesupport' => 'The tooltip when hovering over the {{msg|sitesupport}} link in the sidebar.',
	'group-accountcreator' => 'A specific group of the English Wikipedia; see [[wikipedia:Special:ListUsers/accountcreator]]. See also {{msg|group-accountcreator-member}}.',
	'group-founder' => 'A specific group of the English Wikipedia; see [[wikipedia:Special:ListUsers/founder]] (used exclusively for [[wikipedia:User:Jimbo Wales|Jimbo Wales]]). See also {{msg|group-founder-member}}.',
	'group-rollbacker' => '{{Identical|Rollback}}',
	'group-accountcreator-member' => 'A member of the group {{msg|group-accountcreator}}.',
	'group-founder-member' => 'A member in the group {{msg|group-founder}} (used exclusively for [[wikipedia:User:Jimbo Wales|Jimbo Wales]]).',
	'group-rollbacker-member' => '{{Identical|Rollback}}',
	'grouppage-rollbacker' => '{{Identical|Rollback}}',
	'group-Global_rollback' => '{{Identical|Rollback}}',
	'group-Global_rollback-member' => '{{Identical|Rollback}}',
	'grouppage-steward' => '{{Global grouppage}}',
	'grouppage-Global_bot' => '{{Global grouppage}}',
	'grouppage-Global_rollback' => '{{Global grouppage}}',
	'grouppage-Ombudsmen' => '{{Global grouppage}}',
);

/** Säggssch (Säggssch)
 * @author Thogo
 */
$messages['sxu'] = array(
	'sitesupport' => 'Schbändn',
	'group-steward' => 'Schdewards',
	'group-steward-member' => 'Schdeward',
	'grouppage-steward' => '{{ns:project}}:Schdewards',
);

/** Dalecarlian (Övdalską) */
$messages['dlc'] = array(
	'sitesupport' => 'Stjaintja',
	'tooltip-n-sitesupport' => 'Styða {{SITENAME}}',
);

/** Behase Mentawei (Behase Mentawei)
 * @author Päge bintën
 */
$messages['mwv'] = array(
	'tooltip-n-sitesupport' => 'Dukung kami',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'sitesupport' => 'Tupe fakalofa mo e lagomatai',
);

/** Achinese (Achèh)
 * @author Andri.h
 */
$messages['ace'] = array(
	'tooltip-n-sitesupport' => 'Dukông kamoë',
);

/** Afrikaans (Afrikaans)
 * @author Meno25
 * @author Naudefj
 * @author SPQRobin
 * @author Spacebirdy
 */
$messages['af'] = array(
	'wikimediamessages-desc' => 'Wikimedia spesifieke boodskappe',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/af',
	'sitesupport' => 'Skenkings',
	'tooltip-n-sitesupport' => 'Ondersteun ons',
	'group-developer' => 'Ontwikkelaars',
	'group-founder' => 'Grondleggers',
	'group-import' => 'Importeurders',
	'group-transwiki' => 'Transwiki-importeurs',
	'group-developer-member' => 'Ontwikkelaar',
	'group-founder-member' => 'Grondlegger',
	'group-import-member' => 'Importeurder',
	'grouppage-developer' => '{{ns:project}}:Ontwikkelaars',
	'grouppage-founder' => '{{ns:project}}:Grondleggers',
	'grouppage-import' => '{{ns:project}}:Importeurders',
	'group-steward' => 'Waarde',
	'group-Global_bot' => 'Globale botte',
	'group-Ombudsmen' => 'Ombudsmanne',
	'group-steward-member' => 'Waard',
	'group-sysadmin-member' => 'Stelseladministrateur',
	'group-Global_bot-member' => 'globale bot',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => '{{ns:project}}:Waarde',
);

/** Gheg Albanian (Gegë)
 * @author Cradel
 */
$messages['aln'] = array(
	'sitesupport' => 'Dhurime',
	'tooltip-n-sitesupport' => 'Përkraheni projektin',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'sitesupport' => 'መዋጮ ለመስጠት',
	'tooltip-n-sitesupport' => 'የገንዘብ ስጦታ ለዊኪሜድያ ይስጡ',
	'group-founder' => 'መስራች',
	'group-founder-member' => 'መስራች',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'wikimediamessages-desc' => 'Mensaches espezificos de Wikimedia',
	'sitesupport-url' => 'Project:Donazions',
	'sitesupport' => 'Donazions',
	'tooltip-n-sitesupport' => 'Refirme o procheuto',
	'group-accountcreator' => 'Creyadors de cuentas',
	'group-developer' => 'Desembolicadors',
	'group-founder' => 'Fundadors',
	'group-import' => 'Importadors',
	'group-ipblock-exempt' => 'Exenzion de bloqueyo IP',
	'group-rollbacker' => 'Esfedors',
	'group-transwiki' => 'Importadors de transwiki',
	'group-uploader' => 'Cargadors',
	'group-accountcreator-member' => 'Creyador de cuenta',
	'group-developer-member' => 'Desembolicador',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'Exenzion de bloqueyo IP',
	'group-rollbacker-member' => 'Rebertidor',
	'group-transwiki-member' => 'Importador transwiki',
	'group-uploader-member' => 'cargador',
	'grouppage-accountcreator' => '{{ns:project}}:Creyadors de cuenta',
	'grouppage-developer' => '{{ns:project}}:Desembolicadors',
	'grouppage-founder' => '{{ns:project}}:Fundadors',
	'grouppage-import' => '{{ns:project}}:Importadors',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Exenzión d'o bloqueyo d'IP",
	'grouppage-rollbacker' => '{{ns:project}}:Esfedors',
	'grouppage-transwiki' => '{{ns:project}}:Importardors transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargadors',
	'group-steward' => 'Stewards',
	'group-sysadmin' => "Almenistradors d'o sistemas",
	'group-Global_bot' => 'Bots globals',
	'group-Global_rollback' => 'Esfedors globals',
	'group-Ombudsmen' => 'Chustizias',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => "almenistrador d'o sistema",
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Esfedor global',
	'group-Ombudsmen-member' => 'Chustizia',
	'group-coder' => 'Codificadors',
	'group-coder-member' => 'codificador',
);

/** Old English (Anglo-Saxon) */
$messages['ang'] = array(
	'sitesupport' => 'Gieldgiefa',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'wikimediamessages-desc' => 'رسائل خاصة بويكيميديا',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/%D8%AC%D9%85%D8%B9_%D8%AA%D8%A8%D8%B1%D8%B9%D8%A7%D8%AA',
	'sitesupport' => 'تبرع',
	'tooltip-n-sitesupport' => 'ادعمنا',
	'group-accountcreator' => 'منشئو الحسابات',
	'group-autopatroller' => 'مراجعون تلقائيون',
	'group-developer' => 'مطورون',
	'group-founder' => 'مؤسسون',
	'group-import' => 'مستوردون',
	'group-ipblock-exempt' => 'مستثنون من منع الأيبي',
	'group-rollbacker' => 'مسترجعون',
	'group-transwiki' => 'مستوردون عبر الويكي',
	'group-uploader' => 'رافعون',
	'group-accountcreator-member' => 'منشئ حساب',
	'group-autopatroller-member' => 'مراجع تلقائي',
	'group-developer-member' => 'مطور',
	'group-founder-member' => 'مؤسس',
	'group-import-member' => 'مستورد',
	'group-ipblock-exempt-member' => 'مستثنى من منع الأيبي',
	'group-rollbacker-member' => 'مسترجع',
	'group-transwiki-member' => 'مستورد عبر الويكي',
	'group-uploader-member' => 'رافع',
	'grouppage-accountcreator' => '{{ns:project}}:منشئو الحسابات',
	'grouppage-autopatroller' => '{{ns:project}}:مراجعون تلقائيون',
	'grouppage-developer' => '{{ns:project}}:مطورون',
	'grouppage-founder' => '{{ns:project}}:مؤسسون',
	'grouppage-import' => '{{ns:project}}:مستوردون',
	'grouppage-ipblock-exempt' => '{{ns:project}}:استثناء من منع الأيبي',
	'grouppage-rollbacker' => '{{ns:project}}:مسترجعون',
	'grouppage-transwiki' => '{{ns:project}}:مستوردون عبر الويكي',
	'grouppage-uploader' => '{{ns:project}}:رافعون',
	'group-steward' => 'مضيفون',
	'group-sysadmin' => 'إداريو النظام',
	'group-Global_bot' => 'بوتات عامة',
	'group-Global_rollback' => 'مسترجعون عامون',
	'group-Ombudsmen' => 'أومبدسمين',
	'group-steward-member' => 'مضيف',
	'group-sysadmin-member' => 'إداري نظام',
	'group-Global_bot-member' => 'بوت عام',
	'group-Global_rollback-member' => 'مسترجع عام',
	'group-Ombudsmen-member' => 'أومبدسمان',
	'grouppage-steward' => 'm:Stewards/ar',
	'grouppage-Global_rollback' => 'm:Global rollback/ar',
	'group-coder' => 'مكودون',
	'group-coder-member' => 'مكود',
	'grouppage-coder' => 'Project:مكود',
);

/** Aramaic (ܐܪܡܝܐ) */
$messages['arc'] = array(
	'sitesupport' => 'ܕܚܘܝܬܐ',
);

/** Araucanian (Mapudungun)
 * @author Lin linao
 */
$messages['arn'] = array(
	'sitesupport' => 'Elungechi',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'wikimediamessages-desc' => 'رسايل خاصه بويكيميديا',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/%D8%AC%D9%85%D8%B9_%D8%AA%D8%A8%D8%B1%D8%B9%D8%A7%D8%AA',
	'sitesupport' => 'التبرعات',
	'tooltip-n-sitesupport' => 'ساندنا',
	'group-accountcreator' => 'مؤسسين الحسابات',
	'group-autopatroller' => 'اوتوباترولارز',
	'group-developer' => 'مطورين',
	'group-founder' => 'مؤسسين',
	'group-import' => 'مستوردين',
	'group-ipblock-exempt' => 'مستثنيين من منع الااى بى',
	'group-rollbacker' => 'مسترجعين',
	'group-transwiki' => 'مستوردين عبر الويكى',
	'group-uploader' => 'المحملين',
	'group-accountcreator-member' => 'مؤسس حساب',
	'group-autopatroller-member' => 'اوتوباترولار',
	'group-developer-member' => 'مطور',
	'group-founder-member' => 'مؤسس',
	'group-import-member' => 'مستورد',
	'group-ipblock-exempt-member' => 'مستثنى من منع الاايبى',
	'group-rollbacker-member' => 'مسترجع',
	'group-transwiki-member' => 'مستورد عبر الويكى',
	'group-uploader-member' => 'المحمل',
	'grouppage-accountcreator' => '{{ns:project}}:منشئين الحسابات',
	'grouppage-autopatroller' => '{{ns:project}}:اوتوباترولارز',
	'grouppage-developer' => '{{ns:project}}:مطورين',
	'grouppage-founder' => '{{ns:project}}:مؤسسين',
	'grouppage-import' => '{{ns:project}}:مستوردين',
	'grouppage-ipblock-exempt' => '{{ns:project}}:استثناء من منع الااى بى',
	'grouppage-rollbacker' => '{{ns:project}}:مسترجعين',
	'grouppage-transwiki' => '{{ns:project}}:مستوردين عبر الويكى',
	'grouppage-uploader' => '{{ns:project}}:المحملين',
	'group-steward' => 'مضيفين',
	'group-sysadmin' => 'اداريين النظام',
	'group-Global_bot' => 'بوتات عامه',
	'group-Global_rollback' => 'مسترجعين عامين',
	'group-Ombudsmen' => 'اومبادزمين',
	'group-steward-member' => 'مضيف',
	'group-sysadmin-member' => 'ادارى نظام',
	'group-Global_bot-member' => 'بوت عام',
	'group-Global_rollback-member' => 'مسترجع عام',
	'group-Ombudsmen-member' => 'اومبدادزمان',
	'grouppage-steward' => 'm:Stewards/ar',
	'grouppage-Global_rollback' => 'm:Global rollback/ar',
	'group-coder' => 'مكودون',
	'group-coder-member' => 'مكود',
	'grouppage-coder' => 'Project:مكود',
);

/** Assamese (অসমীয়া)
 * @author Psneog
 * @author Rajuonline
 */
$messages['as'] = array(
	'sitesupport' => 'দান-বৰঙনি',
	'tooltip-n-sitesupport' => 'আমাক সহায় কৰক!',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'wikimediamessages-desc' => 'Mensaxes específicos de Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donativos',
	'sitesupport' => 'Donativos',
	'tooltip-n-sitesupport' => 'Sofítanos',
	'group-accountcreator' => 'Creadores de cuentes',
	'group-developer' => 'Desenrolladores',
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'Exenciones de bloqueos IP',
	'group-rollbacker' => 'Revertidores',
	'group-transwiki' => 'Importadores treswiki',
	'group-accountcreator-member' => 'creador de cuentes',
	'group-developer-member' => 'desenrollador',
	'group-founder-member' => 'fundador',
	'group-import-member' => 'importador',
	'group-ipblock-exempt-member' => 'exentu de bloqueos IP',
	'group-rollbacker-member' => 'revertidor',
	'group-transwiki-member' => 'importador treswiki',
	'grouppage-accountcreator' => '{{ns:project}}:Creadores de cuentes',
	'grouppage-developer' => '{{ns:project}}:Desenrolladores',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:exención de bloqueos IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revertidores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores treswiki',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Alministradores del sistema',
	'group-Global_bot' => 'Bots globales',
	'group-Global_rollback' => 'Revertidores globales',
	'group-Ombudsmen' => 'Comisarios',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'alministrador del sistema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'revertidor global',
	'group-Ombudsmen-member' => 'comisariu',
	'grouppage-steward' => '{{ns:project}}:Stewards',
	'group-coder' => 'Codificadores',
	'group-coder-member' => 'codificador',
);

/** Avaric (Авар) */
$messages['av'] = array(
	'sitesupport' => 'Садакъа',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'sitesupport' => 'Zobera',
	'tooltip-n-sitesupport' => 'Va cin zobel !',
);

/** Aymara (Aymar aru) */
$messages['ay'] = array(
	'sitesupport' => 'Ramañanaka',
);

/** Azerbaijani (Azərbaycan) */
$messages['az'] = array(
	'sitesupport' => 'Bağışlar',
);

/** Bashkir (Башҡорт) */
$messages['ba'] = array(
	'sitesupport' => 'Ярҙам итеү',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 * @author Zordsdavini
 */
$messages['bat-smg'] = array(
	'sitesupport' => 'Pagelba',
	'group-steward' => 'Gaspaduorē',
	'group-sysadmin' => 'Sėstėmas admėnėstratuorē',
	'group-Global_bot' => 'Gluobalūs buotā',
	'group-Global_bot-member' => 'gluobalus buots',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'wikimediamessages-desc' => 'کوله یان مخصوص ویکی‌مدیا',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'مدتان',
	'tooltip-n-sitesupport' => 'ما را حمایت کنیت',
	'group-accountcreator' => 'حساب شرکنوکان',
	'group-developer' => 'پیشبروکان',
	'group-founder' => 'بنگیج کنوکان',
	'group-import' => 'وارد کنوکان',
	'group-ipblock-exempt' => 'معافیت محدودیت آی پی',
	'group-rollbacker' => 'عقب ترینوک',
	'group-transwiki' => 'واردکنوکان بین‌ویکی',
	'group-accountcreator-member' => 'حساب شرکنوک',
	'group-developer-member' => 'پیشبروک',
	'group-founder-member' => 'بنگیج کنوک',
	'group-import-member' => 'واردکنوک',
	'group-ipblock-exempt-member' => 'استثنای محدودیت آی پی',
	'group-rollbacker-member' => 'ترینوک',
	'group-transwiki-member' => 'واردکنوک بین‌ویکی',
	'grouppage-accountcreator' => '{{ns:project}}:حساب شرکنوکان',
	'grouppage-developer' => '{{ns:project}}:پیشبروکان',
	'grouppage-founder' => '{{ns:project}}:بنگیج کنوکان',
	'grouppage-import' => '{{ns:project}}:واردکنوکان',
	'grouppage-ipblock-exempt' => '{{ns:project}}:استثناء محدودیت آی پی',
	'grouppage-rollbacker' => '{{ns:project}}:واردکنوکان',
	'grouppage-transwiki' => '{{ns:project}}:واردکنوکان بین ویکی',
	'group-steward' => 'نگهبانان',
	'group-sysadmin' => 'مدیران سیستم',
	'group-Global_bot' => 'رباتان سراسری',
	'group-Global_rollback' => 'ترینوک سراسری',
	'group-steward-member' => 'نگهبان',
	'group-sysadmin-member' => 'مدیر سیستم',
	'group-Global_bot-member' => 'ربات سراسری',
	'group-Global_rollback-member' => 'ترینوک سراسری',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'sitesupport' => 'Mga donasyon',
	'tooltip-n-sitesupport' => 'Suportaran kami',
);

/** Belarusian (Беларуская)
 * @author Yury Tarasievich
 */
$messages['be'] = array(
	'sitesupport' => 'Ахвяраванні',
	'tooltip-n-sitesupport' => 'Падтрымайце нас',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author Cesco
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'wikimediamessages-desc' => 'Спэцыфічныя паведамленьні фундацыі «Вікімэдыя»',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Ахвяраваньні',
	'tooltip-n-sitesupport' => 'Падтрымайце нас',
	'group-accountcreator' => 'Стваральнікі рахункаў',
	'group-autopatroller' => 'Аўтапатруліруючыя',
	'group-developer' => 'Распрацоўшчыкі',
	'group-founder' => 'Фундатары',
	'group-import' => 'Імпартэры',
	'group-ipblock-exempt' => 'Выключэньні з блякаваньняў ІР-адрасоў',
	'group-rollbacker' => 'Адкатвальнікі',
	'group-transwiki' => 'Імпартэры зь іншых вікі',
	'group-uploader' => 'Загружаючыя',
	'group-accountcreator-member' => 'стваральнік рахункаў',
	'group-autopatroller-member' => 'аўтапатруліруючыя',
	'group-developer-member' => 'распрацоўшчык',
	'group-founder-member' => 'фундатар',
	'group-import-member' => 'імпартэр',
	'group-ipblock-exempt-member' => 'выключэньне з блякаваньняў ІР-адрасоў',
	'group-rollbacker-member' => 'адкатвальнік',
	'group-transwiki-member' => 'імпартэр зь іншых вікі',
	'group-uploader-member' => 'загружаючы файлы',
	'grouppage-accountcreator' => '{{ns:project}}:Стваральнікі рахункаў',
	'grouppage-autopatroller' => '{{ns:project}}:Аўтапатрулюемыя',
	'grouppage-developer' => '{{ns:project}}:Распрацоўшчыкі',
	'grouppage-founder' => '{{ns:project}}:Фундатары',
	'grouppage-import' => '{{ns:project}}:Імпартэры',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Выключэньні з блякаваньняў ІР-адрасоў',
	'grouppage-rollbacker' => '{{ns:project}}:Адкатвальнікі',
	'grouppage-transwiki' => '{{ns:project}}:Імпартэры зь іншых вікі',
	'grouppage-uploader' => '{{ns:project}}:Загружаючыя',
	'group-steward' => 'Сьцюарды',
	'group-sysadmin' => 'Сыстэмныя адміністратары',
	'group-Global_bot' => 'Глябальныя робаты',
	'group-Global_rollback' => 'Глябальныя адкатвальнікі',
	'group-Ombudsmen' => 'праваабаронцы',
	'group-steward-member' => 'сьцюард',
	'group-sysadmin-member' => 'сыстэмны адміністратар',
	'group-Global_bot-member' => 'глябальны робат',
	'group-Global_rollback-member' => 'глябальны адкатывальнік',
	'group-Ombudsmen-member' => 'праваабаронца',
	'group-coder' => 'Праграмісты',
	'group-coder-member' => 'праграміст',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author DCLXVI
 * @author Meno25
 * @author Spiritia
 */
$messages['bg'] = array(
	'wikimediamessages-desc' => 'Съобщения, специфични за Уикимедия',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/bg',
	'sitesupport' => 'Дарения',
	'tooltip-n-sitesupport' => 'Подкрепете ни',
	'group-developer' => 'Разработчици',
	'group-founder' => 'Основатели',
	'group-developer-member' => 'Разработчик',
	'group-founder-member' => 'Основател',
	'grouppage-developer' => '{{ns:project}}:Разработчици',
	'grouppage-founder' => '{{ns:project}}:Основатели',
	'group-steward' => 'Стюарди',
	'group-sysadmin' => 'Системни администратори',
	'group-Global_bot' => 'Глобални ботове',
	'group-Ombudsmen' => 'Омбудсмани',
	'group-steward-member' => 'Стюард',
	'group-sysadmin-member' => 'системен администратор',
	'group-Global_bot-member' => 'глобален бот',
	'group-Ombudsmen-member' => 'омбудсман',
	'grouppage-steward' => '{{ns:project}}:Стюарди',
	'group-coder' => 'Програмисти',
	'group-coder-member' => 'програмист',
);

/** Bambara (Bamanankan) */
$messages['bm'] = array(
	'sitesupport' => 'Banumanke',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'wikimediamessages-desc' => 'উইকিমিডিয়া নির্ধারিত বার্তা',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'দান করুন',
	'tooltip-n-sitesupport' => 'আমাদের সহায়তা করুন',
	'group-accountcreator' => 'অ্যাকাউন্ট তৈরি করেন যারা',
	'group-developer' => 'ডেভেলোপারগণ',
	'group-founder' => 'উদ্যোক্তা',
	'group-import' => 'আমদানীকারক',
	'group-rollbacker' => 'রোলব্যাকারগণ',
	'group-transwiki' => 'ট্রান্সউইকি ইম্পোর্টারগণ',
	'group-accountcreator-member' => 'অ্যাকাউন্ট তৈরি করেন যিনি',
	'group-developer-member' => 'ডেভেলোপার',
	'group-founder-member' => 'উদ্যোক্তা',
	'group-import-member' => 'ইম্পোর্টার',
	'group-rollbacker-member' => 'রোলব্যাকার',
	'group-transwiki-member' => 'ট্রান্সউইকি ইম্পোর্টার',
	'grouppage-developer' => '{{ns:project}}:ডেভেলোপার',
	'grouppage-founder' => '{{ns:project}}:প্রতিষ্ঠাতা',
	'grouppage-import' => '{{ns:project}}:ইম্পোর্টার',
	'grouppage-rollbacker' => '{{ns:project}}:রোলব্যাকার',
	'grouppage-transwiki' => '{{ns:project}}:ট্রান্সউইকি ইম্পোর্টার',
	'group-steward' => 'স্টিউয়ার্ডগণ',
	'group-sysadmin' => 'সিস্টেম প্রশাসকগণ',
	'group-Global_bot' => 'গ্লোবাল বটসমূহ',
	'group-Global_rollback' => 'গ্লোবাল রোলব্যাকারগণ',
	'group-steward-member' => 'স্টিউয়ার্ড',
	'group-sysadmin-member' => 'সিস্টেম প্রশাসক',
	'group-Global_bot-member' => 'গ্লোবাল বট',
	'group-Global_rollback-member' => 'গ্লোবাল রোলব্যাকার',
);

/** Tibetan (བོད་ཡིག) */
$messages['bo'] = array(
	'sitesupport' => 'ཞལ་འདེབས།',
);

/** Bishnupria Manipuri (ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী) */
$messages['bpy'] = array(
	'sitesupport' => 'দান দেনা',
);

/** Bakhtiari (بختياري)
 * @author Behdarvandyani
 */
$messages['bqi'] = array(
	'wikimediamessages-desc' => 'پیام‌های مخصوص ویکی‌مدیا',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/bqi',
	'sitesupport' => 'کمک مالی',
	'tooltip-n-sitesupport' => 'حمایت زه ایما',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author לערי ריינהארט
 */
$messages['br'] = array(
	'wikimediamessages-desc' => 'Kemennoù dibar Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Roadoù',
	'tooltip-n-sitesupport' => "Harpit ac'hanomp",
	'group-accountcreator' => 'Krouerien kontoù',
	'group-developer' => 'Diorroer',
	'group-founder' => 'Diazezourien',
	'group-import' => 'Enporzhier',
	'group-ipblock-exempt' => "Nemedennoù bloc'hadoù IP",
	'group-rollbacker' => 'Assaverien',
	'group-transwiki' => 'Enporzherien treuzwiki',
	'group-accountcreator-member' => 'Krouer kontoù',
	'group-developer-member' => 'Diorroer',
	'group-founder-member' => 'Diazezer',
	'group-import-member' => 'Enporzhier',
	'group-ipblock-exempt-member' => "Nemedenn bloc'had IP",
	'group-rollbacker-member' => 'Assaver',
	'group-transwiki-member' => 'Enporzhier treuzwiki',
	'grouppage-accountcreator' => '{{ns:project}}: Krouerien kontoù',
	'grouppage-developer' => '{{ns:project}}:Diorroerien',
	'grouppage-founder' => '{{ns:project}}:Diazezerien',
	'grouppage-import' => '{{ns:project}}:Enporzherien',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Nemedenn bloc'had IP",
	'grouppage-rollbacker' => '{{ns:project}}:Assaverien',
	'grouppage-transwiki' => '{{ns:project}}:Enporzherien treuzwiki',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Demicx
 * @author Kal-El
 * @author לערי ריינהארט
 */
$messages['bs'] = array(
	'wikimediamessages-desc' => 'Posebne poruke Wikimedije',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/bs',
	'sitesupport' => 'Donacije',
	'tooltip-n-sitesupport' => 'Podržite nas',
	'group-accountcreator' => 'Kreatori računa',
	'group-autopatroller' => 'Automatski nadzornici',
	'group-developer' => 'Razvojni programeri',
	'group-founder' => 'Osnivači',
	'group-import' => 'Uvoznici',
	'group-ipblock-exempt' => 'Izuzeci IP blokada',
	'group-rollbacker' => 'Povratioci',
	'group-transwiki' => 'Transwiki uvoznici',
	'group-uploader' => 'Postavljači',
	'group-accountcreator-member' => 'kreator računa',
	'group-autopatroller-member' => 'automatski patroler',
	'group-developer-member' => 'razvojni programer',
	'group-founder-member' => 'osnivač',
	'group-import-member' => 'uvoznik',
	'group-ipblock-exempt-member' => 'Izuzeci IP blokada',
	'group-rollbacker-member' => 'povratioc',
	'group-transwiki-member' => 'transwiki uvoznik',
	'group-uploader-member' => 'postavljač',
	'grouppage-accountcreator' => '{{ns:project}}:Kreatori računa',
	'grouppage-autopatroller' => '{{ns:project}}:Automatski patroleri',
	'grouppage-developer' => '{{ns:project}}:Razvojni programeri',
	'grouppage-founder' => '{{ns:project}}:Osnivači',
	'grouppage-import' => '{{ns:project}}:Uvoznici',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Izuzeci IP blokada',
	'grouppage-rollbacker' => '{{ns:project}}:Povratioci',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki uvoznici',
	'grouppage-uploader' => '{{ns:project}}:Postavljači',
	'group-steward' => 'Stjuardi',
	'group-sysadmin' => 'Sistemski administratori',
	'group-Global_bot' => 'Globalni botovi',
	'group-Global_rollback' => 'Globalni povratioci',
	'group-Ombudsmen' => 'Ombudsmeni',
	'group-steward-member' => 'stujard',
	'group-sysadmin-member' => 'sistemski administrator',
	'group-Global_bot-member' => 'globalni bot',
	'group-Global_rollback-member' => 'globalni povratioc',
	'group-Ombudsmen-member' => 'ombudsmen',
	'grouppage-steward' => 'm:Stewards',
	'group-coder' => 'Koderi',
	'group-coder-member' => 'koder',
);

/** Catalan (Català)
 * @author Juanpabl
 * @author Martorell
 * @author Paucabot
 */
$messages['ca'] = array(
	'wikimediamessages-desc' => 'Missatges específics de Wikimedia',
	'sitesupport' => 'Donacions',
	'tooltip-n-sitesupport' => 'Ajudau-nos',
	'group-accountcreator' => 'Creadors de comptes',
	'group-developer' => 'Desenvolupadors',
	'group-founder' => 'Fundadors',
	'group-import' => 'Importadors',
	'group-ipblock-exempt' => "Exempts del bloqueig d'IP",
	'group-rollbacker' => 'Revertidors ràpids',
	'group-transwiki' => 'Importadors transwiki',
	'group-accountcreator-member' => 'Creador de comptes',
	'group-developer-member' => 'Desenvolupador',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => "Exempt del bloqueig d'IP",
	'group-rollbacker-member' => 'Revertidor ràpid',
	'group-transwiki-member' => 'Importador transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Creadors de comptes',
	'grouppage-developer' => '{{ns:project}}:Desenvolupadors',
	'grouppage-founder' => '{{ns:project}}:Fundadors',
	'grouppage-import' => '{{ns:project}}:Importadors',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Exempts del bloqueig d'IP",
	'grouppage-rollbacker' => '{{ns:project}}:Revertidors ràpids',
	'grouppage-transwiki' => '{{ns:project}}:Importadors transwiki',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradors del sistema',
	'group-Global_bot' => 'Bots globals',
	'group-Global_rollback' => 'Revertidors ràpids globals',
	'group-Ombudsmen' => 'Defensors del poble',
	'group-steward-member' => 'Majordom',
	'group-sysadmin-member' => 'administrador del sistema',
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Revertidor ràpid global',
	'group-Ombudsmen-member' => 'Defensor del poble',
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄) */
$messages['cdo'] = array(
	'sitesupport' => 'Dà̤-giŏng',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'sitesupport' => 'Сайтан сагIа',
);

/** Cebuano (Cebuano)
 * @author Abastillas
 */
$messages['ceb'] = array(
	'sitesupport' => 'Mga donasyon',
	'tooltip-n-sitesupport' => 'Tabangi kami',
);

/** Chamorro (Chamoru)
 * @author Gadao01
 */
$messages['ch'] = array(
	'sitesupport' => "Nina'i siha",
	'tooltip-n-sitesupport' => 'Supotta ham',
);

/** Cherokee (ᏣᎳᎩ) */
$messages['chr'] = array(
	'sitesupport' => 'ᎠᎵᏍᎪᎸᏙᏗ',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'sitesupport' => 'Dunazione',
	'group-steward' => 'Steward',
	'grouppage-steward' => '{{ns:project}}:Steward',
);

/** Crimean Turkish (Latin) (Qırımtatarca (Latin)) */
$messages['crh-latn'] = array(
	'sitesupport' => 'Bağışlar',
);

/** Crimean Turkish (Cyrillic) (Qırımtatarca (Cyrillic)) */
$messages['crh-cyrl'] = array(
	'sitesupport' => 'Багъышлар',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'wikimediamessages-desc' => 'Hlášení specifická pro projekty nadace Wikimedia Foundation',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Sponzorstv%C3%AD',
	'sitesupport' => 'Podpořte nás',
	'tooltip-n-sitesupport' => 'Podpořte nás',
	'group-accountcreator' => 'Zakladatelé účtů',
	'group-autopatroller' => 'Strážci',
	'group-developer' => 'Vývojáři',
	'group-founder' => 'Zakladatelé',
	'group-import' => 'Importéři',
	'group-ipblock-exempt' => 'Nepodléhající blokování IP adres',
	'group-rollbacker' => 'Revertovatelé',
	'group-transwiki' => 'Transwiki importéři',
	'group-uploader' => 'Načítači souborů',
	'group-accountcreator-member' => 'zakladatel účtů',
	'group-autopatroller-member' => 'strážce',
	'group-developer-member' => 'vývojář',
	'group-founder-member' => 'zakladatel',
	'group-import-member' => 'importér',
	'group-ipblock-exempt-member' => 'nepodléhající blokování IP adres',
	'group-rollbacker-member' => 'revertovatel',
	'group-transwiki-member' => 'transwiki importér',
	'group-uploader-member' => 'načítač souborů',
	'grouppage-accountcreator' => '{{ns:project}}:Zakladatelé účtů',
	'grouppage-autopatroller' => '{{ns:Project}}:Strážci',
	'grouppage-developer' => '{{ns:project}}:Vývojáři',
	'grouppage-founder' => '{{ns:project}}:Zakladatelé',
	'grouppage-import' => '{{ns:project}}:Importéři',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Výjimky z blokování IP adres',
	'grouppage-rollbacker' => '{{ns:project}}:Revertovatelé',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importéři',
	'grouppage-uploader' => '{{ns:project}}:Načítači souborů',
	'group-steward' => 'Stevardi',
	'group-sysadmin' => 'Správcové serveru',
	'group-Global_bot' => 'Globální boti',
	'group-Global_rollback' => 'Globální revertovatelé',
	'group-Ombudsmen' => 'Ombudsmani',
	'group-steward-member' => 'stevard',
	'group-sysadmin-member' => 'správce serveru',
	'group-Global_bot-member' => 'globální bot',
	'group-Global_rollback-member' => 'globální revertovatel',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-coder' => 'Programátoři',
	'group-coder-member' => 'programátor',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'sitesupport' => 'даꙗ́ниꙗ',
);

/** Chuvash (Чăвашла)
 * @author PCode
 */
$messages['cv'] = array(
	'sitesupport' => 'Пожертвованисем',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'sitesupport' => 'Rhoi arian',
	'tooltip-n-sitesupport' => "Ein cefnogi'n ariannol",
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'sitesupport' => 'Støt siden',
	'grouppage-steward' => 'm:Stewards/nb',
	'grouppage-Global_rollback' => 'm:Global rollback/nb',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Pill
 * @author Raimond Spekking
 */
$messages['de'] = array(
	'wikimediamessages-desc' => 'Wikimediaspezifische Systemnachrichten',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Spenden',
	'sitesupport' => 'Spenden',
	'tooltip-n-sitesupport' => 'Unterstütze uns',
	'group-accountcreator' => 'Benutzerkonten-Ersteller',
	'group-autopatroller' => 'Automatische Prüfer',
	'group-developer' => 'Systemadministratoren',
	'group-founder' => 'Gründer',
	'group-import' => 'Importeure',
	'group-ipblock-exempt' => 'IP-Sperre-Ausnahmen',
	'group-rollbacker' => 'Zurücksetzer',
	'group-transwiki' => 'Transwiki-Importeure',
	'group-uploader' => 'Hochlader',
	'group-accountcreator-member' => 'Benutzerkonten-Ersteller',
	'group-autopatroller-member' => 'Automatischer Prüfer',
	'group-developer-member' => 'Systemadministrator',
	'group-founder-member' => 'Gründer',
	'group-import-member' => 'Importeur',
	'group-ipblock-exempt-member' => 'IP-Sperre-Ausnahme',
	'group-rollbacker-member' => 'Zurücksetzer',
	'group-transwiki-member' => 'Transwiki-Importeur',
	'group-uploader-member' => 'Hochlader',
	'grouppage-accountcreator' => '{{ns:project}}:Benutzerkonten-Ersteller',
	'grouppage-autopatroller' => '{{ns:project}}:Automatische Prüfer',
	'grouppage-developer' => '{{ns:project}}:Systemadministratoren',
	'grouppage-founder' => '{{ns:project}}:Gründer',
	'grouppage-import' => '{{ns:project}}:Importeure',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Sperre-Ausnahme',
	'grouppage-rollbacker' => '{{ns:project}}:Zurücksetzer',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importeure',
	'grouppage-uploader' => '{{ns:project}}:Hochlader',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Systemadministratoren',
	'group-Global_bot' => 'Globale Bots',
	'group-Global_rollback' => 'Globale Zurücksetzer',
	'group-Ombudsmen' => 'Ombudspersonen',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Systemadministrator',
	'group-Global_bot-member' => 'Globaler Bot',
	'group-Global_rollback-member' => 'Globaler Zurücksetzer',
	'group-Ombudsmen-member' => 'Ombudsperson',
	'grouppage-steward' => 'm:Stewards/de',
	'group-coder' => 'Programmierer',
	'group-coder-member' => 'Programmierer',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Raimond Spekking
 */
$messages['de-formal'] = array(
	'tooltip-n-sitesupport' => 'Unterstützen Sie uns',
);

/** Zazaki (Zazaki)
 * @author Mirzali
 */
$messages['diq'] = array(
	'sitesupport' => 'Beğş',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 * @author Pe7er
 * @author Qualia
 */
$messages['dsb'] = array(
	'wikimediamessages-desc' => 'Zdźělenja specifiske za Wikimediju',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/dsb',
	'sitesupport' => 'Dary',
	'tooltip-n-sitesupport' => 'Pódpěraj nas',
	'group-accountcreator' => 'Kontowe załožarje',
	'group-autopatroller' => 'Awtomatiske doglědowarje',
	'group-developer' => 'Wuwiwarje',
	'group-founder' => 'Załožarje',
	'group-import' => 'Importery',
	'group-ipblock-exempt' => 'Wuwześe z blokěrowanja IP',
	'group-rollbacker' => 'Slědkstajarje',
	'group-transwiki' => 'Transwiki importery',
	'group-uploader' => 'Nagrawarje',
	'group-accountcreator-member' => 'kontowy załožaŕ',
	'group-autopatroller-member' => 'awtomatiski doglědowaŕ',
	'group-developer-member' => 'wuwiwaŕ',
	'group-founder-member' => 'załožaŕ',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'Z blokěrowanja IP wuwzety',
	'group-rollbacker-member' => 'slědkstajaŕ',
	'group-transwiki-member' => 'transwiki importer',
	'group-uploader-member' => 'nagrawaŕ',
	'grouppage-accountcreator' => '{{ns:project}}:Kontowe załožarje',
	'grouppage-autopatroller' => '{{ns:project}}:Automatiske doglědowarje',
	'grouppage-developer' => '{{ns:project}}:Wuwiwarje',
	'grouppage-founder' => '{{ns:project}}:Załožarje',
	'grouppage-import' => '{{ns:project}}:Importery',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Wuwześe z blokěrowanja IP',
	'grouppage-rollbacker' => '{{ns:project}}:Slědkstajarje',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importery',
	'grouppage-uploader' => '{{ns:project}}:Nagrawarje',
	'group-steward' => 'Stewardy',
	'group-sysadmin' => 'Systemowe administratory',
	'group-Global_bot' => 'Globalne bośiki',
	'group-Global_rollback' => 'Globalne slědkstajarje',
	'group-Ombudsmen' => 'Ombudsniki',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemowy administrator',
	'group-Global_bot-member' => 'göobalny bośik',
	'group-Global_rollback-member' => 'globalny slědkstajaŕ',
	'group-Ombudsmen-member' => 'Ombudsnik',
	'group-coder' => 'Programěrarje',
	'group-coder-member' => 'programěraŕ',
);

/** Divehi (ދިވެހިބަސް) */
$messages['dv'] = array(
	'sitesupport' => 'ޚައިރާތުތައް',
);

/** Dzongkha (ཇོང་ཁ)
 * @author Tenzin
 */
$messages['dz'] = array(
	'sitesupport' => 'ཕན་འདེབས།',
	'tooltip-n-sitesupport' => 'ང་བཅས་ལུ་རྒྱབ་སྐྱོར་འབད།',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'sitesupport' => 'Wɔ nunana',
	'tooltip-n-sitesupport' => 'Kpe ɖe mía ŋu',
	'group-accountcreator' => 'Ŋkɔ ŋlɔlawo',
	'group-accountcreator-member' => 'ŋkɔ ŋlɔla',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/el',
	'sitesupport' => 'Δωρεές',
	'tooltip-n-sitesupport' => 'Υποστηρίξτε μας',
	'group-founder' => 'Ιδρυτές',
	'group-founder-member' => 'Ιδρυτής',
	'grouppage-autopatroller' => '{{ns:project}}:Αυτόματοι περίπολοι',
	'grouppage-founder' => '{{ns:project}}:Ιδρυτές',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Προνόμια αποκλεισμού των IP',
	'group-sysadmin-member' => 'διαχειριστής συστήματος',
);

/** Emiliano-Romagnolo (Emiliàn e rumagnòl) */
$messages['eml'] = array(
	'sitesupport' => 'Donaziòun',
);

/** Esperanto (Esperanto)
 * @author Tlustulimu
 * @author Yekrats
 */
$messages['eo'] = array(
	'wikimediamessages-desc' => 'Specifaj mesaĝoj de Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Monkolektado',
	'sitesupport' => 'Donaci',
	'tooltip-n-sitesupport' => 'Subteni nin per mono',
	'group-accountcreator' => 'Kreintoj de kontoj',
	'group-autopatroller' => 'Aŭtomataj patrolantoj',
	'group-developer' => 'Programistoj',
	'group-founder' => 'Fondintoj',
	'group-import' => 'Importantoj',
	'group-ipblock-exempt' => 'Sendevigoj por IP-forbaroj',
	'group-rollbacker' => 'Restarigantoj',
	'group-transwiki' => 'Importintoj de Transvikio',
	'group-uploader' => 'Alŝutantoj',
	'group-accountcreator-member' => 'Kreinto de konto',
	'group-autopatroller-member' => 'Aŭtomata patrolanto',
	'group-developer-member' => 'Programisto',
	'group-founder-member' => 'Fondinto',
	'group-import-member' => 'Importanto',
	'group-ipblock-exempt-member' => 'maldeviga de IP-forbaro',
	'group-rollbacker-member' => 'Restariganto',
	'group-transwiki-member' => 'Transvikia importanto',
	'group-uploader-member' => 'alŝutanto',
	'grouppage-accountcreator' => '{{ns:project}}:Kreintoj de kontoj',
	'grouppage-autopatroller' => '{{ns:project}}:Aŭtomataj patrolantoj',
	'grouppage-developer' => '{{ns:project}}:Programistoj',
	'grouppage-founder' => '{{ns:project}}:Fondintoj',
	'grouppage-import' => '{{ns:project}}:Importantoj',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Sendevigo por IP-forbaro',
	'grouppage-rollbacker' => '{{ns:project}}:Restarigantoj',
	'grouppage-transwiki' => '{{ns:project}}:Transvikiaj importantoj',
	'grouppage-uploader' => '{{ns:project}}:Alŝutantoj',
	'group-steward' => 'Stevardoj',
	'group-sysadmin' => 'Sistemaj administrantoj',
	'group-Global_bot' => 'Ĝeneralaj robotoj',
	'group-Global_rollback' => 'Transvikia restariganto',
	'group-Ombudsmen' => 'Arbitraciistoj',
	'group-steward-member' => 'Stevardo',
	'group-sysadmin-member' => 'sistema administranto',
	'group-Global_bot-member' => 'Ĝenerala roboto',
	'group-Global_rollback-member' => 'transvikia restariganto',
	'group-Ombudsmen-member' => 'Arbitraciisto',
	'group-coder' => 'Programistoj',
	'group-coder-member' => 'programisto',
);

/** Spanish (Español)
 * @author Ascánder
 * @author Platonides
 * @author Sanbec
 */
$messages['es'] = array(
	'wikimediamessages-desc' => 'Mensajes específicos de Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donaciones',
	'sitesupport' => 'Donaciones',
	'tooltip-n-sitesupport' => 'Apóyenos',
	'group-accountcreator' => 'Creadores de cuentas',
	'group-autopatroller' => 'Autopatrulleros',
	'group-developer' => 'Desarrolladores',
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'Dispensas de bloqueo IP',
	'group-rollbacker' => 'Pueden deshacer',
	'group-transwiki' => 'Importadores transwiki',
	'group-uploader' => 'Cargadores',
	'group-accountcreator-member' => 'creador de la cuenta',
	'group-autopatroller-member' => 'autopatrullero',
	'group-developer-member' => 'desarrollador',
	'group-founder-member' => 'fundador',
	'group-import-member' => 'importador',
	'group-ipblock-exempt-member' => 'dispensa de bloqueo IP',
	'group-rollbacker-member' => 'puede deshacer',
	'group-transwiki-member' => 'Importador transwiki',
	'group-uploader-member' => 'cargador',
	'grouppage-accountcreator' => '{{ns:project}}:Creadores de cuentas',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrulleros',
	'grouppage-developer' => '{{ns:project}}:Desarrolladores',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Dispensa de bloqueo IP',
	'grouppage-rollbacker' => '{{ns:project}}:Reversores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargadores',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'administradores del sistema',
	'group-Global_bot' => 'bots globales',
	'group-Global_rollback' => 'Pueden deshacer globalmente',
	'group-Ombudsmen' => 'Defensores de la comunidad',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrador del sistema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'Puede deshacer globalmente',
	'group-Ombudsmen-member' => 'defensor de la comunidad',
	'group-coder' => 'Programadores',
	'group-coder-member' => 'programador',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author WikedKentaur
 */
$messages['et'] = array(
	'sitesupport' => 'Annetused',
	'tooltip-n-sitesupport' => 'Toeta meid',
	'group-autopatroller' => 'Automaatsed patrullijad',
	'group-developer' => 'Arendajad',
	'group-founder' => 'Asutajad',
	'group-import' => 'Importijad',
	'group-autopatroller-member' => 'automaatne patrullija',
	'group-developer-member' => 'arendaja',
	'group-founder-member' => 'asutaja',
	'group-import-member' => 'importija',
	'group-steward' => 'Stjuuardid',
	'group-sysadmin' => 'Süsteemiadministraatorid',
	'group-Global_bot' => 'Globaalsed robotid',
	'group-steward-member' => 'stjuuard',
	'group-sysadmin-member' => 'süsteemiadministraator',
	'group-Global_bot-member' => 'globaalne robot',
);

/** Basque (Euskara)
 * @author Theklan
 */
$messages['eu'] = array(
	'wikimediamessages-desc' => 'Wikimediaren mezu espezifikoak',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Dohaintzak',
	'sitesupport' => 'Dohaintzak',
	'tooltip-n-sitesupport' => 'Lagundu gaitzazu',
	'group-accountcreator' => 'Kontu sortzailea',
	'group-autopatroller' => 'Autopatruilariak',
	'group-developer' => 'Garatzaileak',
	'group-founder' => 'Fundatzaileak',
	'group-import' => 'Inportatzaileak',
	'group-ipblock-exempt' => 'IP blokeo salbuespenak',
	'group-rollbacker' => 'Desegin dezakete',
	'group-transwiki' => 'Transwiki inportatzaileak',
	'group-uploader' => 'Igo dezakete',
	'group-accountcreator-member' => 'kontu sortzaileak',
	'group-autopatroller-member' => 'autopatruilalaria',
	'group-developer-member' => 'garatzailea',
	'group-founder-member' => 'fundatzailea',
	'group-import-member' => 'inportatzailea',
	'group-ipblock-exempt-member' => 'IP blokeo salbuespena',
	'group-rollbacker-member' => 'desegin dezake',
	'group-transwiki-member' => 'transwiki inportatzailea',
	'group-uploader-member' => 'igo dezake',
	'grouppage-accountcreator' => '{{ns:project}}:Kontu sortzaileak',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatruilariak',
	'grouppage-developer' => '{{ns:project}}:Garatzaileak',
	'grouppage-founder' => '{{ns:project}}:Fundatzaileak',
	'grouppage-import' => '{{ns:project}}:Inportatzaileak',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP blokeo salbuespenak',
	'grouppage-rollbacker' => '{{ns:project}}:Desegin dezakete',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki inportatzaileak',
	'grouppage-uploader' => '{{ns:project}}:Igo dezakete',
	'group-steward' => 'Stewardak',
	'group-sysadmin' => 'Sistemaren kudeatzaileak',
	'group-Global_bot' => 'Bot globalak',
	'group-Global_rollback' => 'Globalki desegin dezakete',
	'group-Ombudsmen' => 'Komunitatearen babesleak',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'sistemaren garatzaileak',
	'group-Global_bot-member' => 'bot globala',
	'group-Global_rollback-member' => 'globalki desegin dezakete',
	'group-Ombudsmen-member' => 'komunitatearen babeslea',
	'grouppage-steward' => 'm:Stewards',
	'group-coder' => 'Kode egileak',
	'group-coder-member' => 'code garatzailea',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'sitesupport' => 'Donacionis',
	'tooltip-n-sitesupport' => 'Ayúamus',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'wikimediamessages-desc' => 'پیغام‌های مخصوص ویکی‌مدیا',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/fa',
	'sitesupport' => 'کمک مالی',
	'tooltip-n-sitesupport' => 'حمایت از ما',
	'group-accountcreator' => 'سازندگان حساب کاربری',
	'group-autopatroller' => 'گشت‌زنان خودکار',
	'group-developer' => 'توسعه‌دهندگان',
	'group-founder' => 'بنیان‌گذاران',
	'group-import' => 'واردکنندگان',
	'group-ipblock-exempt' => 'استثناهای قطع دسترسی نشانی اینترنتی',
	'group-rollbacker' => 'واگردانی‌کنندگان',
	'group-transwiki' => 'واردکنندگان تراویکی',
	'group-uploader' => 'بارگذارها',
	'group-accountcreator-member' => 'ایجادکنندهٔ حساب کاربری',
	'group-autopatroller-member' => 'گشت‌زن خودکار',
	'group-developer-member' => 'توسعه‌دهنده',
	'group-founder-member' => 'بنیان‌گذار',
	'group-import-member' => 'واردکننده',
	'group-ipblock-exempt-member' => 'استثنای قطع دسترسی نشانی اینترنتی',
	'group-rollbacker-member' => 'واگردانی‌کننده',
	'group-transwiki-member' => 'واردکنندهٔ تراویکی',
	'group-uploader-member' => 'بارگذار',
	'grouppage-accountcreator' => '{{ns:project}}:سازندگان حساب کاربری',
	'grouppage-autopatroller' => '{{ns:project}}:گشت‌زنان خودکار',
	'grouppage-developer' => '{{ns:project}}:توسعه‌دهندگان',
	'grouppage-founder' => '{{ns:project}}:بنیان‌گذاران',
	'grouppage-import' => '{{ns:project}}:واردکنندگان',
	'grouppage-ipblock-exempt' => '{{ns:project}}:استثنای قطع دسترسی نشانی اینترنتی',
	'grouppage-rollbacker' => '{{ns:project}}:واگردانی‌کنندگان',
	'grouppage-transwiki' => '{{ns:project}}:واردکنندگان تراویکی',
	'grouppage-uploader' => '{{ns:project}}:بارگذارها',
	'group-steward' => 'ویکیبدان',
	'group-sysadmin' => 'مدیران سیستم',
	'group-Global_bot' => 'ربات‌های سراسری',
	'group-Global_rollback' => 'واگردانی‌کنندگان سراسری',
	'group-Ombudsmen' => 'دادآوران',
	'group-steward-member' => 'ویکیبد',
	'group-sysadmin-member' => 'مدیر سیستم',
	'group-Global_bot-member' => 'ربات سراسری',
	'group-Global_rollback-member' => 'واگردانی‌کنندهٔ سراسری',
	'group-Ombudsmen-member' => 'دادآور',
	'group-coder' => 'برنامه‌نویسان',
	'group-coder-member' => 'برنامه‌نویس',
);

/** Fulah (Fulfulde) */
$messages['ff'] = array(
	'sitesupport' => 'Dokkal',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Crt
 * @author Jaakonam
 * @author Nike
 * @author Tarmo
 */
$messages['fi'] = array(
	'wikimediamessages-desc' => 'Wikimedian käyttämiä järjestelmäviestejä.',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/fi',
	'sitesupport' => 'Lahjoitukset',
	'tooltip-n-sitesupport' => 'Tue meitä',
	'group-accountcreator' => 'käyttäjätunnusten luojat',
	'group-autopatroller' => 'automaattisesti tarkastavat',
	'group-developer' => 'ohjelmistokehittäjät',
	'group-founder' => 'perustajat',
	'group-import' => 'sivujen tuojat',
	'group-ipblock-exempt' => 'IP-estoista vapautetut',
	'group-rollbacker' => 'palauttajat',
	'group-transwiki' => 'toisesta wikistä sivujen tuojat',
	'group-uploader' => 'tiedostojen lähettäjät',
	'group-accountcreator-member' => 'käyttäjätunnusten luoja',
	'group-autopatroller-member' => 'automaattisesti tarkastava',
	'group-developer-member' => 'ohjelmistokehittäjä',
	'group-founder-member' => 'perustaja',
	'group-import-member' => 'sivujen tuoja',
	'group-ipblock-exempt-member' => 'IP-estosta vapautettu',
	'group-rollbacker-member' => 'palauttaja',
	'group-transwiki-member' => 'toisesta wikistä sivujen tuoja',
	'group-uploader-member' => 'tiedostojen lähettäjä',
	'grouppage-accountcreator' => '{{ns:project}}:Käyttäjätunnusten luojat',
	'grouppage-autopatroller' => '{{ns:project}}:Automaattisesti tarkastavat',
	'grouppage-developer' => '{{ns:project}}:Ohjelmistokehittäjät',
	'grouppage-founder' => '{{ns:project}}:Perustajat',
	'grouppage-import' => '{{ns:project}}:Sivujen tuojat',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-estoista vapautetut',
	'grouppage-rollbacker' => '{{ns:project}}:Palauttajat',
	'grouppage-transwiki' => '{{ns:project}}:Toisista wikeistä sivujen tuojat',
	'grouppage-uploader' => '{{ns:project}}:Tiedostojen lähettäjät',
	'group-steward' => 'ylivalvojat',
	'group-sysadmin' => 'järjestelmän ylläpitäjät',
	'group-Global_bot' => 'globaalit botit',
	'group-Global_rollback' => 'globaalit palauttajat',
	'group-Ombudsmen' => 'edustajat',
	'group-steward-member' => 'ylivalvoja',
	'group-sysadmin-member' => 'järjestelmän ylläpitäjä',
	'group-Global_bot-member' => 'globaalibotti',
	'group-Global_rollback-member' => 'globaalipalauttaja',
	'group-Ombudsmen-member' => 'edustaja',
	'grouppage-steward' => 'm:Stewards/fi',
	'group-coder' => 'ohjelmoijat',
	'group-coder-member' => 'ohjelmoija',
);

/** Võro (Võro)
 * @author Võrok
 */
$messages['fiu-vro'] = array(
	'sitesupport' => 'Tugõminõ',
	'tooltip-n-sitesupport' => 'Tukõq mi tüüd',
);

/** Fijian (Na Vosa Vakaviti) */
$messages['fj'] = array(
	'sitesupport' => 'Soli',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'tooltip-n-sitesupport' => 'Stuðla okkum',
	'group-steward' => 'Ternur',
	'group-steward-member' => 'Terna',
	'grouppage-steward' => '{{ns:project}}:Ternur',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Meno25
 * @author Sherbrooke
 * @author Verdy p
 * @author Yekrats
 * @author Zetud
 * @author לערי ריינהארט
 */
$messages['fr'] = array(
	'wikimediamessages-desc' => 'Messages spécifiques de Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/fr',
	'sitesupport' => 'Faire un don',
	'tooltip-n-sitesupport' => 'Aidez-nous',
	'group-accountcreator' => 'Créateurs de comptes',
	'group-autopatroller' => 'Patrouilleurs automatiques',
	'group-developer' => 'Développeurs',
	'group-founder' => 'Fondateurs',
	'group-import' => 'Importateurs',
	'group-ipblock-exempt' => 'Exemptions de blocs IP',
	'group-rollbacker' => 'Réverteurs',
	'group-transwiki' => 'Importateurs transwiki',
	'group-uploader' => 'Téléverseurs',
	'group-accountcreator-member' => 'Créateur de comptes',
	'group-autopatroller-member' => 'Patrouilleur automatique',
	'group-developer-member' => 'Développeur',
	'group-founder-member' => 'Fondateur',
	'group-import-member' => 'Importateur',
	'group-ipblock-exempt-member' => 'Exemption de bloc IP',
	'group-rollbacker-member' => 'Réverteur',
	'group-transwiki-member' => 'Importateur Transwiki',
	'group-uploader-member' => 'téléverseur',
	'grouppage-accountcreator' => '{{ns:project}}:Créateurs de comptes',
	'grouppage-autopatroller' => '{{ns:project}}:Patrouilleurs automatiques',
	'grouppage-developer' => '{{ns:project}}:Développeurs',
	'grouppage-founder' => '{{ns:project}}:Fondateurs',
	'grouppage-import' => '{{ns:project}}:Importateurs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exemption de bloc IP',
	'grouppage-rollbacker' => '{{ns:project}}:Réverteurs',
	'grouppage-transwiki' => '{{ns:project}}:Importateurs Transwiki',
	'grouppage-uploader' => '{{ns:project}}:Téléverseurs',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administrateurs système',
	'group-Global_bot' => 'Bots globaux',
	'group-Global_rollback' => 'Reverteurs globaux',
	'group-Ombudsmen' => 'Commissaires',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrateur système',
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Reverteur global',
	'group-Ombudsmen-member' => 'Commissaire',
	'grouppage-steward' => 'm:Stewards/fr',
	'grouppage-Global_bot' => 'm:Bot policy/fr',
	'group-coder' => 'Codeurs',
	'group-coder-member' => 'codeur',
);

/** Cajun French (Français cadien)
 * @author JeanVoisin
 */
$messages['frc'] = array(
	'sitesupport' => "Donner de l'argent",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'sitesupport' => 'Balyér',
	'tooltip-n-sitesupport' => 'Sotegnéd lo projèt.',
	'group-steward' => 'Stevârds',
	'group-steward-member' => 'Stevârd',
	'grouppage-steward' => '{{ns:project}}:Stevârds',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'sitesupport' => 'Doninus',
	'tooltip-n-sitesupport' => 'Judinus',
	'group-developer' => 'Disvilupadôrs',
	'group-founder' => 'Fondadôrs',
	'group-developer-member' => 'Disvilupadôr',
	'group-founder-member' => 'Fondadôr',
);

/** Western Frisian (Frysk)
 * @author Pyt
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'sitesupport' => 'Donaasjes',
	'tooltip-n-sitesupport' => 'Stypje ús',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'wikimediamessages-desc' => 'Teachtaireachtaí sainiúil an Viciméid',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/ga',
	'sitesupport' => 'Síntiúis',
	'tooltip-n-sitesupport' => 'Tacaigh linn',
	'group-accountcreator' => 'Cuntas cruthóirí',
	'group-autopatroller' => 'Uathphatrólóirí',
	'group-developer' => 'Forbróirí',
	'group-founder' => 'Bunaitheoirí',
	'group-import' => 'Iompórtálaithe',
	'group-ipblock-exempt' => 'Díolúintí coisc IP',
	'group-rollbacker' => 'Tar-rolltóirí',
	'group-transwiki' => 'Iompórtálaithe traisvicí',
	'group-uploader' => 'Uaslódóirí',
	'group-accountcreator-member' => 'cuntas cruthóir',
	'group-autopatroller-member' => 'uathphatrólóir',
	'group-developer-member' => 'forbróir',
	'group-founder-member' => 'bunaitheoir',
	'group-import-member' => 'iompórtálaí',
	'group-ipblock-exempt-member' => 'Díolúine coisc IP',
	'group-rollbacker-member' => 'tar-rolltóir',
	'group-transwiki-member' => 'iompórtálaí traisvicí',
	'group-uploader-member' => 'uaslódóir',
	'grouppage-accountcreator' => '{{ns:project}}:Cuntas cruthóirí',
	'grouppage-autopatroller' => '{{ns:project}}:Uathphatrólóirí',
	'grouppage-developer' => '{{ns:project}}:Forbróirí',
	'grouppage-founder' => '{{ns:project}}:Bunaitheoirí',
	'grouppage-import' => '{{ns:project}}:Iompórtálaithe',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Díolúine coisc IP',
	'grouppage-rollbacker' => '{{ns:project}}:Tar-rolltóirí',
	'grouppage-transwiki' => '{{ns:project}}:Iompórtálaithe traisvicí',
	'grouppage-uploader' => '{{ns:project}}:Uaslódóirí',
	'group-steward' => 'Maoir',
	'group-sysadmin' => 'Riarthóirí',
	'group-Global_bot' => 'Róbónna domhanda',
	'group-Global_rollback' => 'Tar-rolltóirí domhanda',
	'group-Ombudsmen' => 'Daoine an Phobail',
	'group-steward-member' => 'maor',
	'group-sysadmin-member' => 'riarthóir',
	'group-Global_bot-member' => 'róbó domhanda',
	'group-Global_rollback-member' => 'tar-rolltóir domhanda',
	'group-Ombudsmen-member' => 'Duine an Phobail',
	'group-coder' => 'Códóirí',
	'group-coder-member' => 'códóir',
);

/** Gagauz (Gagauz)
 * @author Cuman
 */
$messages['gag'] = array(
	'sitesupport' => 'Baaşişlär',
	'tooltip-n-sitesupport' => 'Material destek',
);

/** Gan (贛語)
 * @author Symane
 */
$messages['gan'] = array(
	'sitesupport' => '贊助',
	'tooltip-n-sitesupport' => '資援偶嗰俚',
);

/** Scottish Gaelic (Gàidhlig) */
$messages['gd'] = array(
	'sitesupport' => 'Tabhartasan',
);

/** Galician (Galego)
 * @author Alma
 * @author Meno25
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'wikimediamessages-desc' => 'Mensaxes específicas da Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/gl',
	'sitesupport' => 'Doazóns',
	'tooltip-n-sitesupport' => 'Apóienos',
	'group-accountcreator' => 'Creadores de contas',
	'group-autopatroller' => 'Autopatrullas',
	'group-developer' => 'Desenvolvedores',
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'Exención de bloqueo IP',
	'group-rollbacker' => 'Revertidores',
	'group-transwiki' => 'Importadores transwiki',
	'group-uploader' => 'Cargadores',
	'group-accountcreator-member' => 'Creador de contas',
	'group-autopatroller-member' => 'autopatrulla',
	'group-developer-member' => 'Desenvolvedor',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'Exento de bloqueo IP',
	'group-rollbacker-member' => 'Revertidor',
	'group-transwiki-member' => 'Importador transwiki',
	'group-uploader-member' => 'cargador',
	'grouppage-accountcreator' => '{{ns:project}}:Creadores de contas',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrullas',
	'grouppage-developer' => '{{ns:project}}:Desenvolvedores',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exención de bloqueo IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revertidores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargadores',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradores do sistema',
	'group-Global_bot' => 'Bots globais',
	'group-Global_rollback' => 'Revertedores globais',
	'group-Ombudsmen' => 'Comisarios',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrador do sistema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'revertedor global',
	'group-Ombudsmen-member' => 'comisario',
	'group-coder' => 'Codificadores',
	'group-coder-member' => 'codificador',
);

/** Gilaki (گیلکی)
 * @author AminSanaei
 */
$messages['glk'] = array(
	'sitesupport' => 'بال زئن',
);

/** Guarani (Avañe'ẽ) */
$messages['gn'] = array(
	'sitesupport' => "Me'ẽ rei",
);

/** Gothic
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'sitesupport' => 'Hairtiþaskatts',
	'tooltip-n-sitesupport' => 'Hairtiþ uns',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author LeighvsOptimvsMaximvs
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'sitesupport' => 'Δῶρα',
	'tooltip-n-sitesupport' => 'Τρέφειν ἡμᾶς',
	'group-accountcreator' => 'Ποιητὲς λογισμῶν',
	'group-developer' => 'Ἐμφανισταί',
	'group-founder' => 'Ἱδρυταί',
	'group-import' => 'Εἰσαγωγεῖς',
	'group-rollbacker' => 'Μεταστροφεῖς',
	'group-developer-member' => 'ἀναπτύκτης',
	'group-uploader-member' => 'ἐπιφορτιστής',
	'grouppage-autopatroller' => '{{ns:project}}:Αὐτόματοι περιποληταί',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Προνόμιον κλῄσεων IP',
	'grouppage-rollbacker' => '{{ns:project}}:Ἀπωθηταί',
	'grouppage-uploader' => '{{ns:project}}:Ἐπιφορτισταί',
	'group-steward' => 'Φροντισταί',
	'group-Ombudsmen' => 'Δέκται διαμαρτυριῶν',
	'group-steward-member' => 'φροντιστής',
	'group-Global_bot-member' => 'καθολικὸν αὐτόματον',
	'group-Global_rollback-member' => 'καθολικὸς μεταστροφεύς',
	'group-Ombudsmen-member' => 'δέκτης διαμαρτυριῶν',
	'group-coder' => 'Κωδικεύοντες',
	'group-coder-member' => 'κωδικεύς',
);

/** Swiss German (Alemannisch) */
$messages['gsw'] = array(
	'sitesupport' => 'Finanzielli Hilf',
);

/** Gujarati (ગુજરાતી)
 * @author Aksi great
 * @author Dsvyas
 * @author לערי ריינהארט
 */
$messages['gu'] = array(
	'sitesupport' => 'દાન',
	'tooltip-n-sitesupport' => 'અમારું સમર્થન કરો',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'sitesupport' => 'Toyrtysyn',
	'tooltip-n-sitesupport' => 'Cooin lhien',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'sitesupport' => 'Chan-chhu',
	'tooltip-n-sitesupport' => 'Chṳ̂-chhu',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'sitesupport' => 'E lūlū mai',
	'tooltip-n-sitesupport' => 'Kāko‘o mai',
	'group-steward' => 'Nā kuene',
	'group-steward-member' => 'Kuene',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 */
$messages['he'] = array(
	'wikimediamessages-desc' => 'הודעות המיוחדות לוויקימדיה',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/תרומות',
	'sitesupport' => 'תרומות',
	'tooltip-n-sitesupport' => 'תרומה',
	'group-accountcreator' => 'יוצרי חשבונות',
	'group-autopatroller' => 'בודקי עריכות אוטומטית',
	'group-developer' => 'מפתחים',
	'group-founder' => 'מייסדים',
	'group-import' => 'מייבאים',
	'group-ipblock-exempt' => 'חסיני חסימות IP',
	'group-rollbacker' => 'משחזרים',
	'group-transwiki' => 'מייבאים בין־אתריים',
	'group-uploader' => 'מעלים',
	'group-accountcreator-member' => 'יוצר חשבונות',
	'group-autopatroller-member' => 'בודק עריכות אוטומטית',
	'group-developer-member' => 'מפתח',
	'group-founder-member' => 'מייסד',
	'group-import-member' => 'מייבא',
	'group-ipblock-exempt-member' => 'חסין חסימות IP',
	'group-rollbacker-member' => 'משחזר',
	'group-transwiki-member' => 'מייבא בין־אתרי',
	'group-uploader-member' => 'מעלה',
	'grouppage-accountcreator' => '{{ns:project}}:יוצר חשבונות',
	'grouppage-autopatroller' => '{{ns:project}}:בודק עריכות אוטומטית',
	'grouppage-developer' => '{{ns:project}}:מפתח',
	'grouppage-founder' => '{{ns:project}}:מייסד',
	'grouppage-import' => '{{ns:project}}:מייבא',
	'grouppage-ipblock-exempt' => '{{ns:project}}:חסין חסימות IP',
	'grouppage-rollbacker' => '{{ns:project}}:משחזר',
	'grouppage-transwiki' => '{{ns:project}}:מייבא בין-אתרי',
	'grouppage-uploader' => '{{ns:project}}:מעלה',
	'group-steward' => 'דיילים',
	'group-sysadmin' => 'מנהלי מערכת',
	'group-Global_bot' => 'בוטים גלובליים',
	'group-Global_rollback' => 'משחזרים גלובליים',
	'group-Ombudsmen' => 'נציבי תלונות הציבור',
	'group-steward-member' => 'דייל',
	'group-sysadmin-member' => 'מנהל מערכת',
	'group-Global_bot-member' => 'בוט גלובלי',
	'group-Global_rollback-member' => 'משחזר גלובלי',
	'group-Ombudsmen-member' => 'נציב תלונות הציבור',
	'group-coder' => 'מתכנתים',
	'group-coder-member' => 'מתכנת',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author לערי ריינהארט
 */
$messages['hi'] = array(
	'sitesupport' => 'दान',
	'tooltip-n-sitesupport' => 'हमें सहायता दें',
);

/** Fiji Hindi (Latin) (Fiji Hindi (Latin))
 * @author Girmitya
 */
$messages['hif-latn'] = array(
	'sitesupport' => 'Daan',
	'tooltip-n-sitesupport' => 'Ham log ke sahara do',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 * @author Kguirnela
 */
$messages['hil'] = array(
	'sitesupport' => 'Donasyon',
	'tooltip-n-sitesupport' => 'Sakdaga kami',
);

/** Croatian (Hrvatski)
 * @author CERminator
 * @author Dalibor Bosits
 * @author SpeedyGonsales
 * @author Suradnik13
 */
$messages['hr'] = array(
	'wikimediamessages-desc' => 'Posebne poruke Wikimedije',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donacije',
	'sitesupport' => 'Novčani prilozi',
	'tooltip-n-sitesupport' => 'Podržite nas',
	'group-accountcreator' => 'Otvaratelji računa',
	'group-autopatroller' => 'Automatski patrolirani',
	'group-developer' => 'Sistem administratori',
	'group-founder' => 'Osnivači',
	'group-import' => 'Unositelji',
	'group-ipblock-exempt' => 'IP blok iznimke',
	'group-rollbacker' => 'Uklonitelji',
	'group-transwiki' => 'Međuwiki unositelji',
	'group-uploader' => 'Postavljači',
	'group-accountcreator-member' => 'otvaratelj računa',
	'group-autopatroller-member' => 'Automatski patroliran',
	'group-developer-member' => 'sistem administrator',
	'group-founder-member' => 'osnivač',
	'group-import-member' => 'unositelj',
	'group-ipblock-exempt-member' => 'IP blok iznimka',
	'group-rollbacker-member' => 'uklonitelj',
	'group-transwiki-member' => 'međuwiki unositelj',
	'group-uploader-member' => 'postavljač',
	'grouppage-accountcreator' => '{{ns:project}}:Otvaratelji računa',
	'grouppage-autopatroller' => '{{ns:project}}:Automatski patrolirani',
	'grouppage-developer' => '{{ns:project}}:Sistem administratori',
	'grouppage-founder' => '{{ns:project}}:Osnivači',
	'grouppage-import' => '{{ns:project}}:Unositelji',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP blok iznimka',
	'grouppage-rollbacker' => '{{ns:project}}:Uklonitelji',
	'grouppage-transwiki' => '{{ns:project}}:Međuwiki unositelji',
	'grouppage-uploader' => '{{ns:project}}:Postavljači',
	'group-steward' => 'Stjuardi',
	'group-sysadmin' => 'Sistem administratori',
	'group-Global_bot' => 'Globalni bot',
	'group-Global_rollback' => 'Globalni uklonitelji',
	'group-Ombudsmen' => 'Ombudsmen',
	'group-steward-member' => 'Stjuard',
	'group-sysadmin-member' => 'sistem administrator',
	'group-Global_bot-member' => 'globalni bot',
	'group-Global_rollback-member' => 'globalni uklonitelj',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => '{{ns:project}}:Stjuardi',
	'group-coder' => 'Programeri',
	'group-coder-member' => 'programer',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'wikimediamessages-desc' => 'Specifiske zdźělenki Wikimedije',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/hsb',
	'sitesupport' => 'Dary',
	'tooltip-n-sitesupport' => 'Podpěrajće nas',
	'group-accountcreator' => 'Kontowi załožerjo',
	'group-autopatroller' => 'Awtomatiscy dohladowarjo',
	'group-developer' => 'Wuwiwarjo',
	'group-founder' => 'Załožerjo',
	'group-import' => 'Importerojo',
	'group-ipblock-exempt' => 'Wuwzaća z blokowanja IP',
	'group-rollbacker' => 'Wróćostajerjo',
	'group-transwiki' => 'Transwiki importerojo',
	'group-uploader' => 'Nahrawarjo',
	'group-accountcreator-member' => 'Kontowe załožer',
	'group-autopatroller-member' => 'awtomatiski dohladowar',
	'group-developer-member' => 'wuwiwar',
	'group-founder-member' => 'załožer',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'Z blokowanja IP wuwzaty',
	'group-rollbacker-member' => 'wróćostajer',
	'group-transwiki-member' => 'transwiki importer',
	'group-uploader-member' => 'nahrawar',
	'grouppage-accountcreator' => '{{ns:project}}:Kontowi załožerjo',
	'grouppage-autopatroller' => '{{ns:project}}:Awtomatiscy dohladowarjo',
	'grouppage-developer' => '{{ns:project}}:Wuwiwarjo',
	'grouppage-founder' => '{{ns:project}}:Załožerjo',
	'grouppage-import' => '{{ns:project}}:Importerojo',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Wuwzaće z blokowanja IP',
	'grouppage-rollbacker' => '{{ns:project}}:Wróćostajerjo',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importerojo',
	'grouppage-uploader' => '{{ns:project}}:Nahrawarjo',
	'group-steward' => 'Stewardźa',
	'group-sysadmin' => 'Systemowi administratorojo',
	'group-Global_bot' => 'Globalne boćiki',
	'group-Global_rollback' => 'Globalni wróćostajerjo',
	'group-Ombudsmen' => 'Ombudsnicy',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemowy administrator',
	'group-Global_bot-member' => 'globalny boćik',
	'group-Global_rollback-member' => 'globalny wróćostajer',
	'group-Ombudsmen-member' => 'ombudsnik',
	'group-coder' => 'Programowarjo',
	'group-coder-member' => 'programowar',
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Fè yon don',
	'tooltip-n-sitesupport' => 'Soutni pwojè a',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'wikimediamessages-desc' => 'Wikimedia-specifikus üzenetek',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Adományok',
	'tooltip-n-sitesupport' => 'Támogatás',
	'group-accountcreator' => 'fióklétrehozók',
	'group-autopatroller' => 'automatikus járőrök',
	'group-developer' => 'fejlesztők',
	'group-founder' => 'alapítók',
	'group-import' => 'importálók',
	'group-ipblock-exempt' => 'IP-blokkok alól mentesülők',
	'group-rollbacker' => 'visszaállítók',
	'group-transwiki' => 'wikiközi importálók',
	'group-uploader' => 'feltöltők',
	'group-accountcreator-member' => 'fióklétrehozó',
	'group-autopatroller-member' => 'automatikus járőr',
	'group-developer-member' => 'fejlesztő',
	'group-founder-member' => 'alapító',
	'group-import-member' => 'importáló',
	'group-ipblock-exempt-member' => 'IP-blokkok alól mentesülő',
	'group-rollbacker-member' => 'visszaállító',
	'group-transwiki-member' => 'wikiközi importáló',
	'group-uploader-member' => 'feltöltő',
	'grouppage-accountcreator' => '{{ns:project}}:Fióklétrehozók',
	'grouppage-autopatroller' => '{{ns:project}}:Automatikus járőrök',
	'grouppage-developer' => '{{ns:project}}:Fejlesztők',
	'grouppage-founder' => '{{ns:project}}:Alapítók',
	'grouppage-import' => '{{ns:project}}:Importálók',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Mentesülés az IP-blokkok alól',
	'grouppage-rollbacker' => '{{ns:project}}:Visszaállítók',
	'grouppage-transwiki' => '{{ns:project}}:Wikiközi importálók',
	'grouppage-uploader' => '{{ns:project}}:Feltöltők',
	'group-steward' => 'helytartók',
	'group-sysadmin' => 'rendszeradminisztrátorok',
	'group-Global_bot' => 'globális botok',
	'group-Global_rollback' => 'globális visszaállítók',
	'group-Ombudsmen' => 'ombudsmanok',
	'group-steward-member' => 'helytartó',
	'group-sysadmin-member' => 'rendszeradminisztrátor',
	'group-Global_bot-member' => 'globális bot',
	'group-Global_rollback-member' => 'globális visszaállító',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => '{{ns:project}}:Helytartók',
	'group-coder' => 'programozók',
	'group-coder-member' => 'programozó',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'sitesupport' => 'Դրամական նվիրատվություն',
);

/** Interlingua (Interlingua)
 * @author Malafaya
 * @author McDutchie
 */
$messages['ia'] = array(
	'wikimediamessages-desc' => 'Messages specific de Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Donationes',
	'tooltip-n-sitesupport' => 'Sustene nos',
	'group-accountcreator' => 'Creatores de contos',
	'group-autopatroller' => 'Autopatruliatores',
	'group-developer' => 'Disveloppatores',
	'group-founder' => 'Fundatores',
	'group-import' => 'Importatores',
	'group-ipblock-exempt' => 'Exemptiones de blocos IP',
	'group-rollbacker' => 'Revertitores',
	'group-transwiki' => 'Importatores transwiki',
	'group-uploader' => 'Cargatores',
	'group-accountcreator-member' => 'Creator de contos',
	'group-autopatroller-member' => 'autopatruliator',
	'group-developer-member' => 'Disveloppator',
	'group-founder-member' => 'Fundator',
	'group-import-member' => 'Importator',
	'group-ipblock-exempt-member' => 'Exemption de bloco IP',
	'group-rollbacker-member' => 'Revertitor',
	'group-transwiki-member' => 'Importator transwiki',
	'group-uploader-member' => 'cargator',
	'grouppage-accountcreator' => '{{ns:project}}:Creatores de contos',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatruliatores',
	'grouppage-developer' => '{{ns:project}}:Disveloppatores',
	'grouppage-founder' => '{{ns:project}}:Fundatores',
	'grouppage-import' => '{{ns:project}}:Importatores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exemption de blocos IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revertitores',
	'grouppage-transwiki' => '{{ns:project}}:Importatores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargatores',
	'group-steward' => 'Stewardes',
	'group-sysadmin' => 'Administratores de systema',
	'group-Global_bot' => 'Bots global',
	'group-Global_rollback' => 'Revocatores global',
	'group-Ombudsmen' => 'Mediatores',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrator de systema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'revocator global',
	'group-Ombudsmen-member' => 'mediator',
	'group-coder' => 'Programmatores',
	'group-coder-member' => 'programmator',
	'grouppage-coder' => 'Project:Programmator',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'wikimediamessages-desc' => 'Pesan-pesan spesifik Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Penggalangan_dana',
	'sitesupport' => 'Menyumbang',
	'tooltip-n-sitesupport' => 'Dukung kami',
	'group-accountcreator' => 'Pembuat akun',
	'group-developer' => 'Developer',
	'group-founder' => 'Pendiri',
	'group-import' => 'Importir',
	'group-ipblock-exempt' => 'Pengecualian pemblokiran IP',
	'group-rollbacker' => 'Pengembali revisi',
	'group-transwiki' => 'Importir transwiki',
	'group-accountcreator-member' => 'Pembuat akun',
	'group-developer-member' => 'Developer',
	'group-founder-member' => 'Pendiri',
	'group-import-member' => 'Importir',
	'group-ipblock-exempt-member' => 'Pengecualian pemblokiran IP',
	'group-rollbacker-member' => 'Pengembali revisi',
	'group-transwiki-member' => 'Importir transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Pembuat akun',
	'grouppage-developer' => '{{ns:project}}:Developer',
	'grouppage-founder' => '{{ns:project}}:Pendiri',
	'grouppage-import' => '{{ns:project}}:Importir',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Pengecualian pemblokiran IP',
	'grouppage-rollbacker' => '{{ns:project}}:Pengembali revisi',
	'grouppage-transwiki' => '{{ns:project}}:Importir transwiki',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Administrator sistem',
	'group-Global_bot' => 'Bot global',
	'group-Global_rollback' => 'Pengembali revisi global',
	'group-Ombudsmen' => 'Ombudsman',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrator sistem',
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Pengembali revisi global',
	'group-Ombudsmen-member' => 'Ombudsman',
	'grouppage-steward' => 'm:Stewards/id',
	'group-coder' => 'Programer',
	'group-coder-member' => 'programer',
);

/** Interlingue (Interlingue)
 * @author Malafaya
 */
$messages['ie'] = array(
	'sitesupport' => 'Donationes',
);

/** Eastern Canadian (Unified Canadian Aboriginal Syllabics) (ᐃᓄᒃᑎᑐᑦ) */
$messages['ike-cans'] = array(
	'sitesupport' => 'ᑐᓐᓂᖅᑯᓯᐊᑦ ᑮᓇᐅᔭᐃᑦ',
);

/** Iloko (Ilokano)
 * @author Saluyot
 * @author לערי ריינהארט
 */
$messages['ilo'] = array(
	'sitesupport' => 'Donasion',
	'tooltip-n-sitesupport' => 'Suportarandakami',
);

/** Ingush (ГІалгІай Ğalğaj)
 * @author Tagir
 */
$messages['inh'] = array(
	'sitesupport' => 'СагIа',
);

/** Ido (Ido)
 * @author Malafaya
 * @author לערי ריינהארט
 */
$messages['io'] = array(
	'sitesupport' => 'Donacaji',
	'tooltip-n-sitesupport' => 'Suportez ni',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author לערי ריינהארט
 */
$messages['is'] = array(
	'sitesupport' => 'Fjárframlög',
	'tooltip-n-sitesupport' => 'Fjárframlagssíða',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Brownout
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'wikimediamessages-desc' => 'Messaggi specifici di Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donazioni',
	'sitesupport' => 'Donazioni',
	'tooltip-n-sitesupport' => 'Sostienici',
	'group-accountcreator' => 'Creatori di account',
	'group-developer' => 'Sviluppatori',
	'group-founder' => 'Fondatori',
	'group-import' => 'Importatori',
	'group-ipblock-exempt' => 'esente dal blocco IP',
	'group-rollbacker' => 'Rollbacker',
	'group-transwiki' => 'Importatori transwiki',
	'group-accountcreator-member' => 'creatore di account',
	'group-developer-member' => 'sviluppatore',
	'group-founder-member' => 'fondatore',
	'group-import-member' => 'importatore',
	'group-ipblock-exempt-member' => 'esente dal blocco IP',
	'group-rollbacker-member' => 'rollbacker',
	'group-transwiki-member' => 'importatore transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Creatori di account',
	'grouppage-developer' => '{{ns:project}}:Sviluppatori',
	'grouppage-founder' => '{{ns:project}}:Founders',
	'grouppage-import' => '{{ns:project}}:Importatori',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Esenti dal blocco IP',
	'grouppage-rollbacker' => '{{ns:project}}:Rollbackers',
	'grouppage-transwiki' => '{{ns:project}}:Importatori transwiki',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Amministratori di sistema',
	'group-Global_bot' => 'Bot globali',
	'group-Global_rollback' => 'Rollbacker globali',
	'group-Ombudsmen' => 'Ombudsmen',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'amministratore di sistema',
	'group-Global_bot-member' => 'bot globale',
	'group-Global_rollback-member' => 'rollbacker globale',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => 'm:Stewards/it',
	'grouppage-Global_rollback' => 'm:Global rollback/it',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Hosiryuhosi
 * @author JtFuruhata
 * @author Meno25
 * @author Suisui
 */
$messages['ja'] = array(
	'wikimediamessages-desc' => 'ウィキメディア固有のメッセージ',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/ja',
	'sitesupport' => '寄付',
	'tooltip-n-sitesupport' => 'ご支援ください',
	'group-accountcreator' => 'アカウント作成権限保持者',
	'group-autopatroller' => '自動パトロール権限保持者',
	'group-developer' => '開発者',
	'group-founder' => '創立者',
	'group-import' => 'インポート権限保持者',
	'group-ipblock-exempt' => 'IPブロック適用除外',
	'group-rollbacker' => 'ロールバック権限保持者',
	'group-transwiki' => 'トランスウィキ・インポート権限保持者',
	'group-uploader' => 'アップロード権限保持者',
	'group-accountcreator-member' => 'アカウント作成権限保持者',
	'group-autopatroller-member' => 'オートパトローラー',
	'group-developer-member' => '開発者',
	'group-founder-member' => '創立者',
	'group-import-member' => 'インポート権限保持者',
	'group-ipblock-exempt-member' => 'IPブロック適用除外',
	'group-rollbacker-member' => 'ロールバック権限保持者',
	'group-transwiki-member' => 'トランスウィキ・インポート権限保持者',
	'group-uploader-member' => 'アップロード権限保持者',
	'grouppage-accountcreator' => '{{ns:project}}:アカウント作成権限保持者',
	'grouppage-autopatroller' => '{{ns:project}}:オートパトローラー',
	'grouppage-developer' => '{{ns:project}}:開発者',
	'grouppage-founder' => '{{ns:project}}:創立者',
	'grouppage-import' => '{{ns:project}}:インポート権限保持者',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IPブロック適用除外',
	'grouppage-rollbacker' => '{{ns:project}}:ロールバック権限保持者',
	'grouppage-transwiki' => '{{ns:project}}:トランスウィキ・インポート権限保持者',
	'grouppage-uploader' => '{{ns:project}}:アップロード権限保持者',
	'group-steward' => 'スチュワード',
	'group-sysadmin' => 'システム管理者',
	'group-Global_bot' => 'グローバル・ボット',
	'group-Global_rollback' => 'グローバル・ロールバック権限保持者',
	'group-Ombudsmen' => 'オンブズマン',
	'group-steward-member' => '{{int:group-steward}}',
	'group-sysadmin-member' => 'システム管理者',
	'group-Global_bot-member' => 'グローバル・ボット',
	'group-Global_rollback-member' => 'グローバル・ロールバック権限保持者',
	'group-Ombudsmen-member' => 'オンブズマン',
	'grouppage-steward' => 'm:Stewards/ja',
	'group-coder' => 'コーダー',
	'group-coder-member' => 'コーダー',
);

/** Lojban (Lojban)
 * @author OldakQuill
 */
$messages['jbo'] = array(
	'sitesupport' => 'jdini sidju',
);

/** Jutish (Jysk)
 * @author Ælsån
 */
$messages['jut'] = array(
	'sitesupport' => 'Støtside',
	'tooltip-n-sitesupport' => 'Støt os',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'wikimediamessages-desc' => 'Pesen-pesen spesifik Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Panggalangan_dana',
	'sitesupport' => 'Nyumbang dana',
	'tooltip-n-sitesupport' => 'Sokongen kita',
	'group-accountcreator' => 'Sing gawé akun',
	'group-developer' => 'Developer',
	'group-founder' => 'Pendhiri',
	'group-import' => 'Importir',
	'group-ipblock-exempt' => 'Pambébasan saka pamblokiran IP',
	'group-rollbacker' => 'Sing mbalèkaké révisi',
	'group-transwiki' => 'Importir transwiki',
	'group-uploader' => 'Pamunggah',
	'group-accountcreator-member' => 'Sing gawé akun',
	'group-developer-member' => 'Developer',
	'group-founder-member' => 'Pandhiri',
	'group-import-member' => 'importir',
	'group-ipblock-exempt-member' => 'Pambébasan saka pamblokiran IP',
	'group-rollbacker-member' => 'Sing mbalèkaké révisi',
	'group-transwiki-member' => 'importir transwiki',
	'group-uploader-member' => 'pamunggah',
	'grouppage-accountcreator' => '{{ns:project}}:Sing gawé akun',
	'grouppage-developer' => '{{ns:project}}:Developer',
	'grouppage-founder' => '{{ns:project}}:Pandhiri',
	'grouppage-import' => '{{ns:project}}:Importir',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Pambébasan saka pamblokiran IP',
	'grouppage-rollbacker' => '{{ns:project}}:Sing mbalèkaké révisi',
	'grouppage-transwiki' => '{{ns:project}}:Importir transwiki',
	'grouppage-uploader' => '{{ns:project}}:Pamunggah',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Administrator sistem',
	'group-Global_bot' => 'Bot global',
	'group-Global_rollback' => 'Sing mbalèkaké révisi global',
	'group-Ombudsmen' => 'Ombudsman',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrator sistem',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'Sing mbalèkaké révisi global',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => 'm:Stewards',
	'grouppage-sysadmin' => 'm:System administrators',
	'grouppage-Global_bot' => 'm:Global bot',
	'grouppage-Global_rollback' => 'm:Global rollback',
	'grouppage-Ombudsmen' => 'm:Ombudsman commission',
	'group-coder' => 'Programer',
	'group-coder-member' => 'programer',
	'grouppage-coder' => 'Project:Programer',
);

/** Georgian (ქართული)
 * @author Alsandro
 * @author לערי ריינהארט
 */
$messages['ka'] = array(
	'sitesupport' => 'შეწირულობები',
	'tooltip-n-sitesupport' => 'მხარდაჭერა',
);

/** Kara-Kalpak (Qaraqalpaqsha)
 * @author AlefZet
 */
$messages['kaa'] = array(
	'sitesupport' => "Ja'rdem berıw",
	'tooltip-n-sitesupport' => "Bizge ja'rdem berin'",
);

/** Kabyle (Taqbaylit)
 * @author Agurzil
 */
$messages['kab'] = array(
	'sitesupport' => 'Efk-aɣ idrimen',
	'tooltip-n-sitesupport' => 'Ellil-aɣ',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'sitesupport' => 'دەمەۋشىلىك',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic))
 * @author AlefZet
 * @author GaiJin
 */
$messages['kk-cyrl'] = array(
	'sitesupport' => 'Демеушілік',
	'group-developer' => 'Дамытушылар',
	'group-import' => 'Сырттан алушылар',
	'group-developer-member' => 'дамытушы',
	'group-import-member' => 'сырттан алушы',
	'group-sysadmin' => 'Жүйе әкімшілері',
	'group-sysadmin-member' => 'жүйе әкімшісі',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'sitesupport' => 'Demewşilik',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Kiensvay
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'wikimediamessages-desc' => 'សារយថាប្រភេទរបស់វិគីមេឌា',
	'sitesupport-url' => 'Project:ទំព័រគាំទ្រ',
	'sitesupport' => 'វិភាគទាន',
	'tooltip-n-sitesupport' => 'គាំទ្រ​យើងខ្ញុំ',
	'group-accountcreator' => 'អ្នកបង្កើតគណនី',
	'group-autopatroller' => 'អ្នកល្បាត​ស្វ័យប្រវត្តិ',
	'group-developer' => 'អ្នកអភិវឌ្ឍ',
	'group-founder' => 'ស្ថាបនិក',
	'group-import' => 'អ្នកនាំចូល',
	'group-transwiki' => 'អ្នកនាំចូលអន្តរវិគី',
	'group-uploader' => 'អ្នក​ផ្ទុកឯកសារឡើង',
	'group-accountcreator-member' => 'អ្នកបង្កើតគណនី',
	'group-autopatroller-member' => 'អ្នកល្បាត​ស្វ័យប្រវត្តិ',
	'group-developer-member' => 'អ្នកអភិវឌ្ឍ',
	'group-founder-member' => 'ស្ថាបនិក',
	'group-import-member' => 'អ្នកនាំចូល',
	'group-transwiki-member' => 'អ្នកនាំចូលអន្តរវិគី',
	'group-uploader-member' => 'អ្នក​ផ្ទុកឯកសារឡើង',
	'grouppage-accountcreator' => '{{ns:project}}:អ្នកបង្កើតគណនី',
	'grouppage-autopatroller' => '{{ns:project}}:អ្នកល្បាត​ស្វ័យប្រវត្តិ',
	'grouppage-developer' => '{{ns:project}}:អ្នកអភិវឌ្ឍ',
	'grouppage-founder' => '{{ns:project}}:ស្ថាបនិក',
	'grouppage-import' => '{{ns:project}}:អ្នកនាំចូល',
	'grouppage-transwiki' => '{{ns:project}}:អ្នកនាំចូលអន្តរវិគី',
	'grouppage-uploader' => '{{ns:project}}:អ្នក​ផ្ទុកឯកសារឡើង',
	'group-sysadmin' => 'អ្នកអភិបាលប្រព័ន្ឋ',
	'group-Global_bot' => 'រូបយន្ត​សកល',
	'group-Ombudsmen' => 'អមប៊ុដហ្ស៍ម៉ឹន',
	'group-sysadmin-member' => 'អ្នកអភិបាលប្រព័ន្ឋ',
	'group-Global_bot-member' => 'រូបយន្ត​សកល',
	'group-Ombudsmen-member' => 'អមប៊ុដហ្ស៍ម៉ឹន',
	'group-coder' => 'អ្នកសរសេរកូដ',
	'group-coder-member' => 'អ្នកសរសេរកូដ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Shushruth
 * @author לערי ריינהארט
 */
$messages['kn'] = array(
	'sitesupport' => 'ದೇಣಿಗೆ',
	'tooltip-n-sitesupport' => 'ನಮ್ಮನ್ನು ಬೆಂಬಲಿಸಿ',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'wikimediamessages-desc' => '위키미디어 전용 메시지',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/ko',
	'sitesupport' => '기부 안내',
	'tooltip-n-sitesupport' => '지원을 기다립니다',
	'group-developer' => '개발자',
	'group-founder' => '설립자',
	'group-developer-member' => '개발자',
	'group-founder-member' => '설립자',
	'grouppage-developer' => '{{ns:project}}:개발자',
	'group-steward' => '사무장',
	'group-sysadmin' => '시스템 관리자',
	'group-Global_bot' => '글로벌 봇',
	'group-steward-member' => '사무장',
	'group-sysadmin-member' => '시스템 관리자',
	'group-Global_bot-member' => '글로벌 봇',
	'grouppage-steward' => 'm:Stewards/ko',
	'group-coder' => '코더',
	'group-coder-member' => '코더',
);

/** Kinaray-a (Kinaray-a)
 * @author RonaldPanaligan
 */
$messages['krj'] = array(
	'sitesupport' => 'Donasyon',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'wikimediamessages-desc' => 'Systemnohrechte un Tex för de Wikimedia Shtefftung ier Wikis.',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Spende',
	'sitesupport' => 'Spende',
	'tooltip-n-sitesupport' => 'Donn uns Ungerstötze!',
	'group-accountcreator' => 'Metmaacher-Maachere',
	'group-autopatroller' => 'Sellver-Nohloorer',
	'group-developer' => 'Entwecklere',
	'group-founder' => 'Jröndere',
	'group-import' => 'Emportöre',
	'group-ipblock-exempt' => 'IP-Jruppe-Sperre-Ußnahme',
	'group-rollbacker' => 'Zeröcknemmere',
	'group-transwiki' => 'Transwiki-Emportöre',
	'group-uploader' => 'Huhlaader',
	'group-accountcreator-member' => 'Metmaacher-Maacher',
	'group-autopatroller-member' => 'Sellver-Nohloorer',
	'group-developer-member' => 'Entweckler',
	'group-founder-member' => 'Jrönder',
	'group-import-member' => 'Emportör',
	'group-ipblock-exempt-member' => 'IP-Jruppe-Sperre-Ußnahm',
	'group-rollbacker-member' => 'Zeröcknemmer',
	'group-transwiki-member' => 'Transwiki-Emportör',
	'group-uploader-member' => 'Huhlaader',
	'grouppage-accountcreator' => '{{ns:project}}:Metmaacher-Maacher',
	'grouppage-autopatroller' => '{{ns:project}}:Sellver-Nohloorer',
	'grouppage-developer' => '{{ns:project}}:Entweckler',
	'grouppage-founder' => '{{ns:project}}:Jrönder',
	'grouppage-import' => '{{ns:project}}:Emportör',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Jruppe-Sperre-Ußnahm',
	'grouppage-rollbacker' => '{{ns:project}}:Zeröcknemmer',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Emportör',
	'grouppage-uploader' => '{{ns:project}}:Huhlaader',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Wiki-Köbesse',
	'group-Global_bot' => 'Bots för all Wikis',
	'group-Global_rollback' => 'Zeröcknämmere för all Wikis',
	'group-Ombudsmen' => 'Vermeddeler',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Wiki-Köbes',
	'group-Global_bot-member' => 'Bot för all Wikis',
	'group-Global_rollback-member' => 'Zeröcknämmer för all Wikis',
	'group-Ombudsmen-member' => 'Vermeddeler',
	'group-coder' => 'Projrammierer',
	'group-coder-member' => 'Projrammierer',
	'grouppage-coder' => 'project:Projrammierer',
);

/** Kurdish (Latin) (Kurdî / كوردی (Latin)) */
$messages['ku-latn'] = array(
	'sitesupport' => 'Ji bo Weqfa Wikimedia Beş',
);

/** Cornish (Kernewek)
 * @author Malafaya
 */
$messages['kw'] = array(
	'sitesupport' => 'Riansow',
);

/** Kirghiz (Кыргызча) */
$messages['ky'] = array(
	'sitesupport' => 'Демөөр',
);

/** Latin (Latina)
 * @author UV
 * @author לערי ריינהארט
 */
$messages['la'] = array(
	'sitesupport' => 'Donationes',
	'group-rollbacker-member' => 'revertor',
);

/** Ladino (Ladino)
 * @author לערי ריינהארט
 */
$messages['lad'] = array(
	'sitesupport' => 'Donasiones',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Kaffi
 * @author Robby
 * @author לערי ריינהארט
 */
$messages['lb'] = array(
	'wikimediamessages-desc' => 'Spezifesch Systemmessage fir Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Donatiounen',
	'tooltip-n-sitesupport' => 'Ënnerstetzt eis',
	'group-accountcreator' => 'Benotzer déi Benotzerkonten uleeën däerfen',
	'group-developer' => 'System-Entwéckler',
	'group-founder' => 'Grënner',
	'group-import' => 'Importateuren',
	'group-ipblock-exempt' => 'Ausnahme vun IP-Spären',
	'group-rollbacker' => 'Zrécksetzer',
	'group-transwiki' => 'Transwiki-Importateuren',
	'group-uploader' => 'Eroplueder',
	'group-accountcreator-member' => 'Benotzer dee Benotzerkonten uleeën däerf',
	'group-developer-member' => 'System-Entwéckler',
	'group-founder-member' => 'Grënner',
	'group-import-member' => 'Importateur',
	'group-ipblock-exempt-member' => 'Ausnam vun der IP-Spär',
	'group-rollbacker-member' => 'Zrécksetzer',
	'group-transwiki-member' => 'Transwiki-Importateur',
	'group-uploader-member' => 'Eroplueder',
	'grouppage-accountcreator' => '{{ns:project}}:Benotzer déi Benotzerkonten uleeën däerfen',
	'grouppage-developer' => '{{ns:project}}:System-Entwéckler',
	'grouppage-founder' => '{{ns:project}}:Grënner',
	'grouppage-import' => '{{ns:project}}:Importateuren',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Ausnahm vun der IP-Spär',
	'grouppage-rollbacker' => '{{ns:project}}:Zrécksetzer',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importateuren',
	'grouppage-uploader' => '{{ns:project}}:Eroplueder',
	'group-steward' => 'Stewarden',
	'group-sysadmin' => 'Systemadministrateuren',
	'group-Global_bot' => 'Global Botten',
	'group-Global_rollback' => 'Global Zrécksetzer',
	'group-Ombudsmen' => 'Ombudsmänner',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Systemadministrateur',
	'group-Global_bot-member' => 'Globale Bot',
	'group-Global_rollback-member' => 'Globalen Zrécksetzer',
	'group-Ombudsmen-member' => 'Ombudsmann',
	'grouppage-steward' => '{{ns:project}}:Stewarden',
	'grouppage-sysadmin' => 'm:System Administrateuren',
	'grouppage-Global_bot' => 'm:Global bot',
	'group-coder' => 'Programméierer',
	'group-coder-member' => 'Programméierer',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Cgboeree
 */
$messages['lfn'] = array(
	'sitesupport' => 'Donas',
	'tooltip-n-sitesupport' => 'suporta nos',
);

/** Ganda (Luganda)
 * @author Kizito
 */
$messages['lg'] = array(
	'sitesupport' => 'Okutonera wiki',
	'tooltip-n-sitesupport' => "Nyiga wano ob'oyagala wiki okugiwa obuyambi obw'ensimbi",
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Pahles
 * @author לערי ריינהארט
 */
$messages['li'] = array(
	'wikimediamessages-desc' => 'Wikimedia specifieke berichte',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Donaties',
	'tooltip-n-sitesupport' => 'Ongersteun os financieel',
	'group-accountcreator' => 'Gebroekeraanmakers',
	'group-developer' => 'Ontwikkeleers',
	'group-founder' => 'Gróndlègkers',
	'group-import' => 'Importäörs',
	'group-ipblock-exempt' => 'Oetgezongerde van IP-adres blokkades',
	'group-rollbacker' => 'Trökdriejers',
	'group-transwiki' => 'Transwikiimportäörs',
	'group-accountcreator-member' => 'Gebroekeraanmaker',
	'group-developer-member' => 'Ontwikkeleer',
	'group-founder-member' => 'Gróndlègker',
	'group-import-member' => 'Importäör',
	'group-ipblock-exempt-member' => 'Oetgenómmene van IP-adresblokkades',
	'group-rollbacker-member' => 'Trökdriejer',
	'group-transwiki-member' => 'Transwikiimportäör',
	'grouppage-accountcreator' => '{{ns:project}}:Gebroekeraanmakers',
	'grouppage-developer' => '{{ns:project}}:Ontwikkeleers',
	'grouppage-founder' => '{{ns:project}}:Gróndlègkers',
	'grouppage-import' => '{{ns:project}}:Importäörs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Oetgezongerde van IP-adresblokkades',
	'grouppage-rollbacker' => '{{ns:project}}:Trökdriejers',
	'grouppage-transwiki' => '{{ns:project}}:Transwikiimportäörs',
	'group-steward' => 'Stewards',
	'group-Global_bot' => 'Globaal bots',
	'group-Global_rollback' => 'Globaal trökdriejers',
	'group-Ombudsmen' => 'Ombudsmen',
	'group-steward-member' => 'Steward',
	'group-Global_bot-member' => 'Globale bot',
	'group-Global_rollback-member' => 'Globale trökdriejer',
	'group-Ombudsmen-member' => 'Ombudsman',
	'grouppage-steward' => '{{ns:project}}:Stewards',
);

/** Líguru (Líguru)
 * @author ZeneizeForesto
 */
$messages['lij'] = array(
	'sitesupport' => 'Donasioin',
	'tooltip-n-sitesupport' => 'Agiûttine',
);

/** Lumbaart (Lumbaart) */
$messages['lmo'] = array(
	'sitesupport' => 'Dunazziun',
);

/** Lingala (Lingála) */
$messages['ln'] = array(
	'sitesupport' => 'Kofutela',
);

/** Lao (ລາວ)
 * @author Tuinui
 */
$messages['lo'] = array(
	'wikimediamessages-desc' => 'ຂໍ້ຄວາມສະເພາະ ວິກິພີເດຍ',
	'sitesupport' => 'ບໍລິຈາກ',
	'tooltip-n-sitesupport' => 'ສະໜັບສະໜຸນພວກເຮົາ',
);

/** Lozi (Silozi)
 * @author Ooswesthoesbes
 * @author SF-Language
 */
$messages['loz'] = array(
	'sitesupport' => 'Adonetarina',
	'tooltip-n-sitesupport' => 'Sepotisize',
);

/** Lithuanian (Lietuvių)
 * @author Hugo.arg
 */
$messages['lt'] = array(
	'sitesupport' => 'Parama',
	'group-steward' => 'Ūkvedžiai',
	'group-sysadmin' => 'Sistemos administratoriai',
	'group-Global_bot' => 'Globalūs botai',
);

/** Latvian (Latviešu)
 * @author Xil
 * @author Yyy
 */
$messages['lv'] = array(
	'wikimediamessages-desc' => 'Wikimedia raksturīgi paziņojumi',
	'sitesupport' => 'Ziedojumi',
	'tooltip-n-sitesupport' => 'Atbalsti mūs',
);

/** Maithili (मैथिली)
 * @author Ggajendra
 */
$messages['mai'] = array(
	'tooltip-n-sitesupport' => 'हमरा सभकेँ सहयोग करू',
);

/** Basa Banyumasan (Basa Banyumasan)
 * @author לערי ריינהארט
 */
$messages['map-bms'] = array(
	'sitesupport' => 'Sumbang dana',
);

/** Moksha (Мокшень)
 * @author Kranch
 * @author Numulunj pilgae
 */
$messages['mdf'] = array(
	'sitesupport' => 'Лезкс максома',
	'tooltip-n-sitesupport' => 'Макст тейнек лезкс',
);

/** Malagasy (Malagasy) */
$messages['mg'] = array(
	'sitesupport' => 'Fanomezana',
);

/** Maori (Māori) */
$messages['mi'] = array(
	'sitesupport' => 'Koha',
);

/** Macedonian (Македонски)
 * @author Brest
 * @author Misos
 */
$messages['mk'] = array(
	'wikimediamessages-desc' => 'Викимедија специфични пораки',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Донации',
	'tooltip-n-sitesupport' => 'Подржете не',
	'group-accountcreator' => 'Креирачи на сметки',
	'group-autopatroller' => 'Автоматски патролирани',
	'group-developer' => 'Развивачи',
	'group-founder' => 'Основачи',
	'group-import' => 'Увезувачи',
	'group-ipblock-exempt' => 'IP блок исклучоци',
	'group-rollbacker' => 'Враќачи',
	'group-transwiki' => 'Трансвики увезувачи',
	'group-uploader' => 'Подигнувачи',
	'group-accountcreator-member' => 'создавач на сметка',
	'group-autopatroller-member' => 'автоматски патролирач',
	'group-developer-member' => 'развивач',
	'group-founder-member' => 'основач',
	'group-import-member' => 'увозник',
	'group-ipblock-exempt-member' => 'IP блок исклучок',
	'group-rollbacker-member' => 'враќач',
	'group-transwiki-member' => 'трансвики увозник',
	'group-uploader-member' => 'подигнувач',
	'grouppage-accountcreator' => '{{ns:project}}:Создавачи на сметки',
	'grouppage-autopatroller' => '{{ns:project}}:Автоматски патролирачи',
	'grouppage-developer' => '{{ns:project}}:Развивачи',
	'grouppage-founder' => '{{ns:project}}:Основачи',
	'grouppage-import' => '{{ns:project}}:Увезувачи',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP блок исклучок',
	'grouppage-rollbacker' => '{{ns:project}}:Враќачи',
	'grouppage-transwiki' => '{{ns:project}}:Трансвики увезувачи',
	'grouppage-uploader' => '{{ns:project}}:Подигнувачи',
	'group-steward' => 'Стјуарди',
	'group-sysadmin' => 'Систем администратори',
	'group-Global_bot' => 'Глобални ботови',
	'group-Global_rollback' => 'Глобални враќачи',
	'group-Ombudsmen' => 'Омбудсман',
	'group-steward-member' => 'стјуард',
	'group-sysadmin-member' => 'систем администратор',
	'group-Global_bot-member' => 'глобален бот',
	'group-Global_rollback-member' => 'глобален враќач',
	'group-Ombudsmen-member' => 'омбудсман',
	'grouppage-steward' => 'm:Стјуарди',
	'grouppage-sysadmin' => 'm:Систем администратори',
	'grouppage-Global_bot' => 'm:Глобален бот',
	'grouppage-Global_rollback' => 'm:Глобално враќање',
	'grouppage-Ombudsmen' => 'm:Ombudsman commission',
	'group-coder' => 'Програмери',
	'group-coder-member' => 'програмер',
	'grouppage-coder' => 'Проект:Програмер',
);

/** Malayalam (മലയാളം)
 * @author Meno25
 * @author Shijualex
 * @author לערי ריינהארט
 */
$messages['ml'] = array(
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/ml',
	'sitesupport' => 'സംഭാവന',
	'tooltip-n-sitesupport' => 'ഞങ്ങളെ പിന്തുണക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 * @author לערי ריינהארט
 */
$messages['mn'] = array(
	'sitesupport' => 'Хандив',
	'tooltip-n-sitesupport' => 'Биднийг дэмжээрэй',
);

/** Moldavian (Молдовеняскэ)
 * @author Node ue
 */
$messages['mo'] = array(
	'tooltip-n-sitesupport' => 'Сприжиниць-не',
);

/** Marathi (मराठी)
 * @author Mahitgar
 */
$messages['mr'] = array(
	'sitesupport' => 'दान',
);

/** Malay (Bahasa Melayu)
 * @author Aviator
 * @author Kurniasan
 */
$messages['ms'] = array(
	'wikimediamessages-desc' => 'Pesanan-pesanan Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Derma',
	'tooltip-n-sitesupport' => 'Derma',
	'group-accountcreator' => 'Pencipta akaun',
	'group-autopatroller' => 'Autoperonda',
	'group-developer' => 'Pembangun',
	'group-founder' => 'Pengasas',
	'group-import' => 'Pengimport',
	'group-ipblock-exempt' => 'Pengecualian sekatan IP',
	'group-rollbacker' => 'Pengundur',
	'group-transwiki' => 'Pengimport rentas wiki',
	'group-uploader' => 'Pemuat naik',
	'group-accountcreator-member' => 'Pencipta akaun',
	'group-autopatroller-member' => 'autoperonda',
	'group-developer-member' => 'Pembangun',
	'group-founder-member' => 'Pengasas',
	'group-import-member' => 'Pengimport',
	'group-ipblock-exempt-member' => 'Pengecualian sekatan IP',
	'group-rollbacker-member' => 'Pengundur',
	'group-transwiki-member' => 'Pengimport rentas wiki',
	'group-uploader-member' => 'pemuat naik',
	'grouppage-accountcreator' => '{{ns:project}}:Pencipta akaun',
	'grouppage-autopatroller' => '{{ns:project}}:Autoperonda',
	'grouppage-developer' => '{{ns:project}}:Pembangun',
	'grouppage-founder' => '{{ns:project}}:Pengasas',
	'grouppage-import' => '{{ns:project}}:Pengimport',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Pengecualian sekatan IP',
	'grouppage-rollbacker' => '{{ns:project}}:Pengundur suntingan',
	'grouppage-transwiki' => '{{ns:project}}:Pengimport rentas wiki',
	'grouppage-uploader' => '{{ns:project}}:Pemuat naik',
	'group-steward' => 'Pengelola',
	'group-sysadmin' => 'Pentadbir sistem',
	'group-Global_bot' => 'Bot sejagat',
	'group-Global_rollback' => 'Pengundur suntingan sejagat',
	'group-Ombudsmen' => 'Ombudsman',
	'group-steward-member' => 'Pengelola',
	'group-sysadmin-member' => 'pentadbir sistem',
	'group-Global_bot-member' => 'Bot sejagat',
	'group-Global_rollback-member' => 'Pengundur suntingan sejagat',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-coder' => 'Pengekod',
	'group-coder-member' => 'pengekod',
);

/** Maltese (Malti)
 * @author Giangian15
 */
$messages['mt'] = array(
	'wikimediamessages-desc' => "Messaġġi speċifiki ta' Wikimedija",
	'sitesupport' => 'Donazzjonijiet',
	'tooltip-n-sitesupport' => 'Appoġġjana',
);

/** Mirandese (Mirandés)
 * @author MCruz
 */
$messages['mwl'] = array(
	'sitesupport' => 'Donativos',
	'tooltip-n-sitesupport' => 'Ayude-nos',
);

/** Burmese (Myanmasa)
 * @author Hakka
 * @author Hintha
 */
$messages['my'] = array(
	'sitesupport' => 'လှု​ဒါန်း​မှု​',
	'tooltip-n-sitesupport' => 'အားပေးပါ',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'sitesupport' => 'Лезксйармаконь максома',
	'tooltip-n-sitesupport' => 'Макста миненек нежедематарка',
);

/** Mazanderani (مَزِروني)
 * @author Spacebirdy
 */
$messages['mzn'] = array(
	'sitesupport' => 'پیلی کایر',
);

/** Nauru (Dorerin Naoero) */
$messages['na'] = array(
	'sitesupport' => 'Eadu a me',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'sitesupport' => 'Tēyocatiliztli',
	'tooltip-n-sitesupport' => 'Xitēchtēpalēhuia',
	'group-uploader' => 'Tlaquetzalōnih',
	'group-founder-member' => 'Chīhualōni',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'sitesupport' => 'Kià-hù',
);

/** Neapolitan (Nnapulitano)
 * @author Cryptex
 */
$messages['nap'] = array(
	'sitesupport' => 'Donazzione',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 * @author לערי ריינהארט
 */
$messages['nds'] = array(
	'wikimediamessages-desc' => 'Systemnarichten för Wikimedia',
	'sitesupport' => 'Spennen',
	'tooltip-n-sitesupport' => 'Ünnerstütt uns',
	'group-accountcreator' => 'Brukerkonten-Opstellers',
	'group-autopatroller' => 'Autopatrollers',
	'group-developer' => 'Utwicklers',
	'group-founder' => 'Grünners',
	'group-import' => 'Importörs',
	'group-ipblock-exempt' => 'IP-Sperr-Utnahmen',
	'group-rollbacker' => 'Trüchsetters',
	'group-transwiki' => 'Transwiki-Importörs',
	'group-uploader' => 'Hoochladers',
	'group-accountcreator-member' => 'Brukerkonten-Opsteller',
	'group-autopatroller-member' => 'Autopatroller',
	'group-developer-member' => 'Utwickler',
	'group-founder-member' => 'Grünner',
	'group-import-member' => 'Importör',
	'group-ipblock-exempt-member' => 'IP-Sperr-Utnahm',
	'group-rollbacker-member' => 'Trüchsetter',
	'group-transwiki-member' => 'Transwiki-Importör',
	'group-uploader-member' => 'Hoochlader',
	'grouppage-accountcreator' => '{{ns:project}}:Brukerkonten-Opstellers',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-developer' => '{{ns:project}}:Utwicklers',
	'grouppage-founder' => '{{ns:project}}:Grünners',
	'grouppage-import' => '{{ns:project}}:Importörs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Sperr-Utnahm',
	'grouppage-rollbacker' => '{{ns:project}}:Trüchsetters',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importörs',
	'grouppage-uploader' => '{{ns:project}}:Hoochladers',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'System-Administraters',
	'group-Global_bot' => 'Globale Bots',
	'group-Global_rollback' => 'Globale Trüchsetters',
	'group-Ombudsmen' => 'Ombudslüüd',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'System-Administrater',
	'group-Global_bot-member' => 'Global Bot',
	'group-Global_rollback-member' => 'Global Trüchsetter',
	'group-Ombudsmen-member' => 'Ombudsmann',
	'group-coder' => 'Programmerers',
	'group-coder-member' => 'Programmerer',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 * @author לערי ריינהארט
 */
$messages['nds-nl'] = array(
	'sitesupport' => 'Financiële steun',
	'tooltip-n-sitesupport' => 'Gef oons geald',
);

/** Nepali (नेपाली) */
$messages['ne'] = array(
	'sitesupport' => 'चन्दा',
);

/** Newari (नेपाल भाषा)
 * @author Eukesh
 */
$messages['new'] = array(
	'sitesupport' => 'दान',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Troefkaart
 * @author Tvdm
 */
$messages['nl'] = array(
	'wikimediamessages-desc' => 'Berichten voor Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Giften',
	'sitesupport' => 'Donaties',
	'tooltip-n-sitesupport' => 'Ondersteun ons financieel',
	'group-accountcreator' => 'gebruikersaanmakers',
	'group-autopatroller' => 'autopatrollers',
	'group-developer' => 'ontwikkelaars',
	'group-founder' => 'grondleggers',
	'group-import' => 'importeurs',
	'group-ipblock-exempt' => 'uitgezonderden van IP-adresblokkades',
	'group-rollbacker' => 'terugdraaiers',
	'group-transwiki' => 'Transwiki-importeurs',
	'group-uploader' => 'uploaders',
	'group-accountcreator-member' => 'gebruikersaanmaker',
	'group-autopatroller-member' => 'autopatroller',
	'group-developer-member' => 'ontwikkelaar',
	'group-founder-member' => 'grondlegger',
	'group-import-member' => 'importeur',
	'group-ipblock-exempt-member' => 'uitgezonderde van IP-adresblokkades',
	'group-rollbacker-member' => 'terugdraaier',
	'group-transwiki-member' => 'transwiki-importeur',
	'group-uploader-member' => 'uploader',
	'grouppage-accountcreator' => '{{ns:project}}:Gebruikersaanmakers',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-developer' => '{{ns:project}}:Ontwikkelaars',
	'grouppage-founder' => '{{ns:project}}:Grondleggers',
	'grouppage-import' => '{{ns:project}}:Importeurs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Uitgezonderden van IP-adresblokkades',
	'grouppage-rollbacker' => '{{ns:project}}:Terugdraaiers',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importeurs',
	'grouppage-uploader' => '{{ns:project}}:Uploaders',
	'group-steward' => 'stewards',
	'group-sysadmin' => 'systeembeheerders',
	'group-Global_bot' => 'globale bots',
	'group-Global_rollback' => 'globale terugdraaiers',
	'group-Ombudsmen' => 'ombudsmannen',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systeembeheerder',
	'group-Global_bot-member' => 'globale bot',
	'group-Global_rollback-member' => 'globale terugdraaier',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => 'm:Stewards/nl',
	'grouppage-Global_rollback' => 'm:Global rollback/nl',
	'group-coder' => 'programmeurs',
	'group-coder-member' => 'programmeur',
	'grouppage-coder' => 'Project:Programmeur',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'wikimediamessages-desc' => 'Wikimedia-spesifikke meldingar',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/nn',
	'sitesupport' => 'Gåver',
	'tooltip-n-sitesupport' => 'Støtt oss',
	'group-accountcreator' => 'Kontoopprettarar',
	'group-autopatroller' => 'Automatisk godkjende bidrag',
	'group-developer' => 'Utviklarar',
	'group-founder' => 'Grunnleggarar',
	'group-import' => 'Importørar',
	'group-ipblock-exempt' => 'Unntak frå IP-blokkering',
	'group-rollbacker' => 'Attenderullarar',
	'group-transwiki' => 'Transwiki-importørar',
	'group-uploader' => 'Opplastarar',
	'group-accountcreator-member' => 'Kontoopprettar',
	'group-autopatroller-member' => 'automatisk godkjende bidrag',
	'group-developer-member' => 'utviklar',
	'group-founder-member' => 'grunnleggar',
	'group-import-member' => 'importør',
	'group-ipblock-exempt-member' => 'Unteke frå IP-blokkering',
	'group-rollbacker-member' => 'attenderullar',
	'group-transwiki-member' => 'transwiki-importør',
	'group-uploader-member' => 'opplastar',
	'grouppage-accountcreator' => '{{ns:project}}:Kontoopprettarar',
	'grouppage-autopatroller' => '{{ns:project}}:Automatisk godkjende bidrag',
	'grouppage-developer' => '{{ns:project}}:Utviklarar',
	'grouppage-founder' => '{{ns:project}}:Grunnleggarar',
	'grouppage-import' => '{{ns:project}}:Importørar',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Unnatekne frå IP-blokkering',
	'grouppage-rollbacker' => '{{ns:project}}:Attenderullarar',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importørar',
	'grouppage-uploader' => '{{ns:project}}:Opplastarar',
	'group-steward' => 'Stewardar',
	'group-sysadmin' => 'Systemadministratorar',
	'group-Global_bot' => 'Globale robotar',
	'group-Global_rollback' => 'Globale attenderullarar',
	'group-Ombudsmen' => 'Ombodsmenn',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemadministrator',
	'group-Global_bot-member' => 'global robot',
	'group-Global_rollback-member' => 'global attenderullar',
	'group-Ombudsmen-member' => 'ombodsmann',
	'grouppage-steward' => 'm:Stewards/nb',
	'grouppage-sysadmin' => 'm:Systemadministratorar',
	'grouppage-Global_bot' => 'm:Global robot',
	'grouppage-Global_rollback' => 'm:Global rollback/nb',
	'group-coder' => 'Kodarar',
	'group-coder-member' => 'kodar',
	'grouppage-coder' => 'Prosjekt:Kodar',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Laaknor
 */
$messages['no'] = array(
	'wikimediamessages-desc' => 'Wikimedia-spesifikke beskjeder',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/nb',
	'sitesupport' => 'Donasjoner',
	'tooltip-n-sitesupport' => 'Støtt oss',
	'group-accountcreator' => 'Kontoopprettere',
	'group-autopatroller' => 'Automatisk godkjente bidrag',
	'group-developer' => 'Utviklere',
	'group-founder' => 'Grunnleggere',
	'group-import' => 'Importører',
	'group-ipblock-exempt' => 'Untatte fra IP-blokkering',
	'group-rollbacker' => 'Tilbakestillere',
	'group-transwiki' => 'Transwiki-importører',
	'group-uploader' => 'Opplastere',
	'group-accountcreator-member' => 'Kontooppretter',
	'group-autopatroller-member' => 'automatisk godkjente bidrag',
	'group-developer-member' => 'Utvikler',
	'group-founder-member' => 'Grunnlegger',
	'group-import-member' => 'Importør',
	'group-ipblock-exempt-member' => 'Unttatt fra IP-blokkering',
	'group-rollbacker-member' => 'Tilbakestiller',
	'group-transwiki-member' => 'Transwiki-importør',
	'group-uploader-member' => 'opplaster',
	'grouppage-accountcreator' => '{{ns:project}}:Kontoopprettere',
	'grouppage-autopatroller' => '{{ns:project}}:Patruljering',
	'grouppage-developer' => '{{ns:project}}:Utviklere',
	'grouppage-founder' => '{{ns:project}}:Grunnleggere',
	'grouppage-import' => '{{ns:project}}:Importører',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Unntatte fra IP-blokkering',
	'grouppage-rollbacker' => '{{ns:project}}:Tilbakestillere',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importører',
	'grouppage-uploader' => '{{ns:project}}:Opplastere',
	'group-steward' => 'Forvaltere',
	'group-sysadmin' => 'Systemadministratorer',
	'group-Global_bot' => 'Globale roboter',
	'group-Global_rollback' => 'Globale tilbakestillere',
	'group-Ombudsmen' => 'Ombudsmenn',
	'group-steward-member' => 'forvalter',
	'group-sysadmin-member' => 'systemadministrator',
	'group-Global_bot-member' => 'global robot',
	'group-Global_rollback-member' => 'global tilbakestiller',
	'group-Ombudsmen-member' => 'ombudsmann',
	'grouppage-steward' => 'm:Stewards/nb',
	'grouppage-Global_rollback' => 'm:Global rollback/nb',
	'group-coder' => 'Kodere',
	'group-coder-member' => 'koder',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'sitesupport' => 'Donationes',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'sitesupport' => 'Dineelo',
	'tooltip-n-sitesupport' => 'Re thekge',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'wikimediamessages-desc' => 'Messatges especifics de Wikimèdia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/oc',
	'sitesupport' => 'Far un don',
	'tooltip-n-sitesupport' => 'Sostenètz lo projècte',
	'group-accountcreator' => 'Creators de comptes',
	'group-autopatroller' => 'Patrolhadors automatics',
	'group-developer' => 'Desvolopaires',
	'group-founder' => 'Fondators',
	'group-import' => 'Importaires',
	'group-ipblock-exempt' => 'Exempcions de blòts IP',
	'group-rollbacker' => 'Revocaires',
	'group-transwiki' => 'Importaires Transwiki',
	'group-uploader' => 'Telecargaires',
	'group-accountcreator-member' => 'Creator de comptes',
	'group-autopatroller-member' => 'Patrolhador automatic',
	'group-developer-member' => 'Desvolopaire',
	'group-founder-member' => 'Fondator',
	'group-import-member' => 'Importaire',
	'group-ipblock-exempt-member' => 'Exempcion de blòt IP',
	'group-rollbacker-member' => 'Revocaire',
	'group-transwiki-member' => 'Importaire Transwiki',
	'group-uploader-member' => 'Telecargaire',
	'grouppage-accountcreator' => '{{ns:project}}:Creators de comptes',
	'grouppage-autopatroller' => '{{ns:project}}:Patrolhadors automatics',
	'grouppage-developer' => '{{ns:project}}:Desvolopaires',
	'grouppage-founder' => '{{ns:project}}:Fondators',
	'grouppage-import' => '{{ns:project}}:Importaires',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exempcion de blòt IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revocaires',
	'grouppage-transwiki' => '{{ns:project}}:Importaires Transwiki',
	'grouppage-uploader' => '{{ns:project}}:Telecargaires',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administrators del sistèma',
	'group-Global_bot' => 'Bòts globals',
	'group-Global_rollback' => 'Revocaires globals',
	'group-Ombudsmen' => 'Comissaris',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrator del sistèma',
	'group-Global_bot-member' => 'Bòt global',
	'group-Global_rollback-member' => 'Revocaire global',
	'group-Ombudsmen-member' => 'Comissari',
	'group-coder' => 'Encodaires',
	'group-coder-member' => 'encodaire',
);

/** Punjabi (ਪੰਜਾਬੀ) */
$messages['pa'] = array(
	'sitesupport' => 'ਦਾਨ',
);

/** Pangasinan (Pangasinan) */
$messages['pag'] = array(
	'sitesupport' => 'Donasyon',
);

/** Pampanga (Kapampangan)
 * @author Katimawan2005
 */
$messages['pam'] = array(
	'sitesupport' => 'Donasiun',
	'tooltip-n-sitesupport' => 'Saupan yu kami',
);

/** Plautdietsch (Plautdietsch)
 * @author Slomox
 */
$messages['pdt'] = array(
	'sitesupport' => 'Gowe',
	'tooltip-n-sitesupport' => 'Unjastett onns',
);

/** Pfälzisch (Pfälzisch)
 * @author SPS
 */
$messages['pfl'] = array(
	'sitesupport' => 'Spende',
	'group-steward' => 'Stewards',
	'group-steward-member' => 'Steward',
	'grouppage-steward' => '{{ns:project}}:Steward',
);

/** Norfuk / Pitkern (Norfuk / Pitkern) */
$messages['pih'] = array(
	'sitesupport' => 'Doenaiishun',
);

/** Polish (Polski)
 * @author Beau
 * @author Derbeth
 * @author Leinad
 * @author Meno25
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'wikimediamessages-desc' => 'Komunikaty unikalne dla projektów Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/pl',
	'sitesupport' => 'Darowizny',
	'tooltip-n-sitesupport' => 'Pomóż nam',
	'group-accountcreator' => 'Tworzący konta',
	'group-autopatroller' => 'Patrolujący automatycznie',
	'group-developer' => 'Deweloperzy',
	'group-founder' => 'Założyciele',
	'group-import' => 'Importerzy',
	'group-ipblock-exempt' => 'Uprawnieni do logowania się z zablokowanych adresów IP',
	'group-rollbacker' => 'Uprawnieni do wycofywania edycji',
	'group-transwiki' => 'Importerzy transwiki',
	'group-uploader' => 'Ładujący pliki',
	'group-accountcreator-member' => 'twórca kont',
	'group-autopatroller-member' => 'patrolujący automatycznie',
	'group-developer-member' => 'deweloper',
	'group-founder-member' => 'założyciel',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'uprawniony do zalogowania się z zablokowanego adresu IP',
	'group-rollbacker-member' => 'uprawniony do wycofania edycji',
	'group-transwiki-member' => 'importer transwiki',
	'group-uploader-member' => 'ładujący pliki',
	'grouppage-accountcreator' => '{{ns:project}}:Twórcy kont',
	'grouppage-autopatroller' => '{{ns:project}}:Patrolujący automatycznie',
	'grouppage-developer' => '{{ns:project}}:Deweloperzy',
	'grouppage-founder' => '{{ns:project}}:Założyciele',
	'grouppage-import' => '{{ns:project}}:Importerzy',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Uprawnieni do logowania się z zablokowanych adresów IP',
	'grouppage-rollbacker' => '{{ns:project}}:Uprawnieni do wycofywania edycji',
	'grouppage-transwiki' => '{{ns:project}}:Importerzy transwiki',
	'grouppage-uploader' => '{{ns:project}}:Ładujący pliki',
	'group-steward' => 'Stewardzi',
	'group-sysadmin' => 'Administratorzy systemu',
	'group-Global_bot' => 'Boty globalne',
	'group-Global_rollback' => 'Globalnie uprawnieni do wycofywania edycji',
	'group-Ombudsmen' => 'Rzecznicy praw',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrator systemu',
	'group-Global_bot-member' => 'bot globalny',
	'group-Global_rollback-member' => 'globalnie uprawniony do wycofywania edycji',
	'group-Ombudsmen-member' => 'rzecznik praw',
	'grouppage-steward' => 'm:Stewards/pl',
	'group-coder' => 'Programiści',
	'group-coder-member' => 'programista',
);

/** Piedmontese (Piemontèis) */
$messages['pms'] = array(
	'sitesupport' => 'Oferte',
);

/** Pontic (Ποντιακά)
 * @author Sinopeus
 */
$messages['pnt'] = array(
	'sitesupport' => 'Δωρεάς',
	'tooltip-n-sitesupport' => 'Βοηθέστεν το έργον.',
	'group-sysadmin' => 'Διαχειριστάδες συστηματί',
	'group-sysadmin-member' => 'διαχειριστάς συστηματί',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'wikimediamessages-desc' => 'د ويکيمېډيا ځانګړي پيغامونه',
	'sitesupport' => 'بسپنې',
	'tooltip-n-sitesupport' => 'زموږ ملاتړ وکړی',
	'group-accountcreator' => 'کارن-حساب جوړونکي',
	'group-developer' => 'پرمخبوونکي',
	'group-founder' => 'بنسټګران',
	'group-accountcreator-member' => 'کارن-حساب جوړونکی',
	'group-founder-member' => 'بنسټګر',
	'grouppage-accountcreator' => '{{ns:project}}:کارن-حساب جوړونکي',
	'grouppage-developer' => '{{ns:project}}:پرمخبوونکي',
	'group-sysadmin' => 'د غونډال پازوالان',
	'group-sysadmin-member' => 'د غونډال پازوال',
);

/** Portuguese (Português)
 * @author 555
 * @author Malafaya
 * @author Sir Lestaty de Lioncourt
 */
$messages['pt'] = array(
	'wikimediamessages-desc' => 'Mensagens específicas à Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/pt',
	'sitesupport' => 'Doações',
	'tooltip-n-sitesupport' => 'Ajude-nos',
	'group-accountcreator' => 'Criadores de contas',
	'group-autopatroller' => 'Auto-patrulhadores',
	'group-developer' => 'Desenvolvedores',
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'IPs não bloqueados',
	'group-rollbacker' => 'Revertedores',
	'group-transwiki' => 'Importadores Transwiki',
	'group-uploader' => 'Carregadores',
	'group-accountcreator-member' => 'Criador de contas',
	'group-autopatroller-member' => 'auto-patrulhador',
	'group-developer-member' => 'Desenvolvedor',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'IPs não bloqueados',
	'group-rollbacker-member' => 'Revertedor',
	'group-transwiki-member' => 'importador transwiki',
	'group-uploader-member' => 'carregador',
	'grouppage-accountcreator' => '{{ns:project}}:Criadores de contas',
	'grouppage-autopatroller' => '{{ns:project}}:Auto-patrulhadores',
	'grouppage-developer' => '{{ns:project}}:Desenvolvedores',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP não bloqueado',
	'grouppage-rollbacker' => '{{ns:project}}:Revertedores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Carregadores',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradores de sistema',
	'group-Global_bot' => 'Robôs globais',
	'group-Global_rollback' => 'Revertedores globais',
	'group-Ombudsmen' => 'Mediadores',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrador de sistema',
	'group-Global_bot-member' => 'robô global',
	'group-Global_rollback-member' => 'revertedor global',
	'group-Ombudsmen-member' => 'mediador',
	'grouppage-steward' => 'm:Stewards/pt',
	'group-coder' => 'Codificadores',
	'group-coder-member' => 'codificador',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Carla404
 */
$messages['pt-br'] = array(
	'sitesupport' => 'Doações',
	'tooltip-n-sitesupport' => 'Ajude-nos',
	'group-developer' => 'Desenvolvedores',
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'sitesupport' => 'Qarana',
	'tooltip-n-sitesupport' => 'Yanapawayku',
);

/** Tarifit (Tarifit)
 * @author Agzennay
 */
$messages['rif'] = array(
	'tooltip-n-sitesupport' => 'Ɛawn-anɣ',
);

/** Rhaeto-Romance (Rumantsch) */
$messages['rm'] = array(
	'sitesupport' => 'Donaziuns',
);

/** Romani (Romani)
 * @author Desiphral
 * @author לערי ריינהארט
 */
$messages['rmy'] = array(
	'sitesupport' => 'Denimata',
	'group-steward' => 'Stewardurya',
	'group-steward-member' => 'Stewardo',
	'grouppage-steward' => '{{ns:project}}:Stewardurya',
);

/** Romanian (Română)
 * @author Emily
 * @author KlaudiuMihaila
 * @author Laurap
 * @author Mihai
 */
$messages['ro'] = array(
	'wikimediamessages-desc' => 'Mesaje specifice Wikimedia',
	'sitesupport' => 'Donaţii',
	'tooltip-n-sitesupport' => 'Sprijină-ne',
	'group-accountcreator' => 'Creator de conturi',
	'group-developer' => 'Dezvoltatori',
	'group-founder' => 'Fondatori',
	'group-import' => 'Importatori',
	'group-transwiki' => 'Importatori între wiki',
	'group-accountcreator-member' => 'creator de conturi',
	'group-developer-member' => 'dezvoltator',
	'group-founder-member' => 'Fondator',
	'group-import-member' => 'importator',
	'group-transwiki-member' => 'importator între wiki',
	'grouppage-developer' => '{{ns:project}}:Dezvoltatori',
	'grouppage-founder' => '{{ns:project}}:Fondatori',
	'grouppage-import' => '{{ns:project}}:Importatori',
	'grouppage-transwiki' => '{{ns:project}}:Importatori între wiki',
	'group-steward' => 'Stewarzi',
	'group-sysadmin' => 'Administratori de sistem',
	'group-Global_bot' => 'Roboţi globali',
	'group-Ombudsmen' => 'Mijlocitor independent',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrator de sistem',
	'group-Global_bot-member' => 'robot global',
	'group-Ombudsmen-member' => 'mijlocitor independent',
);

/** Aromanian (Armãneashce)
 * @author Hakka
 */
$messages['roa-rup'] = array(
	'sitesupport' => 'Donatsiur',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Done',
	'tooltip-n-sitesupport' => 'Aiutene',
	'group-developer' => 'Sviluppature',
	'group-import' => "'Mbortature",
	'group-uploader' => 'Carecatore',
	'group-developer-member' => 'sviluppatore',
	'group-import-member' => "'mbortatore",
	'group-transwiki-member' => 'Importatore de transuicchi',
	'group-uploader-member' => 'carecatore',
	'grouppage-developer' => '{{ns:project}}:Sviluppature',
	'grouppage-uploader' => '{{ns:project}}:Carecature',
	'group-sysadmin' => "Amministrature d'u sisteme",
	'group-sysadmin-member' => 'amministratore de sisteme',
	'group-Global_bot-member' => 'bot globele',
);

/** Russian (Русский)
 * @author Ahonc
 * @author Aleksandrit
 * @author AlexSm
 * @author Flrn
 * @author HalanTul
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'wikimediamessages-desc' => 'Сообщения, специфичные для Викимедиа',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Сделать_пожертвование',
	'sitesupport' => 'Пожертвования',
	'tooltip-n-sitesupport' => 'Поддержите нас',
	'group-accountcreator' => 'Создатели учётных записей',
	'group-autopatroller' => 'Автопатрулируемые',
	'group-developer' => 'Разработчики',
	'group-founder' => 'Основатели',
	'group-import' => 'Импортёры',
	'group-ipblock-exempt' => 'Исключения из IP-блокировок',
	'group-rollbacker' => 'Откатывающие',
	'group-transwiki' => 'Импортёры из Transwiki',
	'group-uploader' => 'Загружающие',
	'group-accountcreator-member' => 'создатель учётных записей',
	'group-autopatroller-member' => 'автопатрулируемый',
	'group-developer-member' => 'разработчик',
	'group-founder-member' => 'основатель',
	'group-import-member' => 'импортёр',
	'group-ipblock-exempt-member' => 'исключение из IP-блокировок',
	'group-rollbacker-member' => 'откатывающий',
	'group-transwiki-member' => 'импортёр из Transwiki',
	'group-uploader-member' => 'загружающий',
	'grouppage-accountcreator' => '{{ns:project}}:Создатели учётных записей',
	'grouppage-autopatroller' => '{{ns:project}}:Автопатрулируемые',
	'grouppage-developer' => '{{ns:project}}:Разработчики',
	'grouppage-founder' => '{{ns:project}}:Основатели',
	'grouppage-import' => '{{ns:project}}:Импортёры',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Исключение из IP-блокировок',
	'grouppage-rollbacker' => '{{ns:project}}:Откатывающие',
	'grouppage-transwiki' => '{{ns:project}}:Импортёры из Transwiki',
	'grouppage-uploader' => '{{ns:project}}:Загружающие',
	'group-steward' => 'Стюарды',
	'group-sysadmin' => 'Системные администраторы',
	'group-Global_bot' => 'Глобальные боты',
	'group-Global_rollback' => 'Глобальные откатывающие',
	'group-Ombudsmen' => 'Омбудсмены',
	'group-steward-member' => 'стюард',
	'group-sysadmin-member' => 'системный администратор',
	'group-Global_bot-member' => 'глобальный бот',
	'group-Global_rollback-member' => 'глобальный откатывающий',
	'group-Ombudsmen-member' => 'омбудсмен',
	'grouppage-steward' => 'm:Stewards/ru',
	'group-coder' => 'Программисты',
	'group-coder-member' => 'программист',
);

/** Megleno-Romanian (Cyrillic) (Vlăheşte (Cyrillic))
 * @author Кумулај Маркус
 * @author Макѕе
 */
$messages['ruq-cyrl'] = array(
	'sitesupport' => 'Донационс',
	'tooltip-n-sitesupport' => 'Супора-ностре',
);

/** Megleno-Romanian (Latin) (Vlăheşte (Latin))
 * @author Кумулај Маркус
 * @author Макѕе
 */
$messages['ruq-latn'] = array(
	'sitesupport' => 'Donacions',
	'tooltip-n-sitesupport' => 'Supora-nostre',
);

/** Yakut (Саха тыла)
 * @author Bert Jickty
 * @author HalanTul
 */
$messages['sah'] = array(
	'wikimediamessages-desc' => 'Викимедиаҕа эрэ сыһыаннаах этиилэр',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Харчынан_көмө',
	'sitesupport' => 'Бу сири өйөө',
	'tooltip-n-sitesupport' => 'Өйөбүл',
	'group-accountcreator' => 'Кыттааччылар ааттарын айааччылар/бигэргэтээччилэр',
	'group-developer' => 'Оҥорооччулар',
	'group-founder' => 'Тэрийээччилэр',
	'group-import' => 'Импортааччылар',
	'group-ipblock-exempt' => 'Хааччахтааһыҥҥа киирбэт IP-лаахтар',
	'group-rollbacker' => 'Төннөрөөччүлэр',
	'group-transwiki' => 'Transwiki`ттан импортааччылар',
	'group-accountcreator-member' => 'Кыттаачылар ааттарын бигэргэтээччи/оҥорооччу',
	'group-developer-member' => 'Оҥорооччу',
	'group-founder-member' => 'Тэрийээччи',
	'group-import-member' => 'Импортааччы',
	'group-ipblock-exempt-member' => 'IP-та хааччахтаммат кыттааччы',
	'group-rollbacker-member' => 'Төннөрөөччү',
	'group-transwiki-member' => 'transwiki`ттан импортааччы',
	'grouppage-accountcreator' => '{{ns:project}}:Кыттааччылар ааттарын бигэргэтээччилэр/айааччылар',
	'grouppage-developer' => '{{ns:project}}:Оҥорооччулар',
	'grouppage-founder' => '{{ns:project}}:Тэрийээччилэр',
	'grouppage-import' => '{{ns:project}}:Импортааччылар',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-лара хааччахтаммат кыттааччылар',
	'grouppage-rollbacker' => '{{ns:project}}:Төннөрөөччүлэр',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki`ттан көһөрөөччүлэр',
	'group-steward' => 'Үстүйээрдэр',
	'group-sysadmin' => 'Тиһик (систиэмэ) дьаһабыллара',
	'group-sysadmin-member' => 'дьаһабыл',
);

/** Sicilian (Sicilianu)
 * @author Gmelfi
 * @author Santu
 * @author לערי ריינהארט
 */
$messages['scn'] = array(
	'wikimediamessages-desc' => 'Missaggi spicifici di Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/Now/scn',
	'sitesupport' => 'Dunazzioni',
	'tooltip-n-sitesupport' => 'Sustinìticci',
	'group-accountcreator' => 'Criatura di cunti',
	'group-developer' => 'Sviluppatura',
	'group-founder' => 'Funnatura',
	'group-import' => 'Mpurtatura',
	'group-ipblock-exempt' => 'Esenti dû bloccu IP',
	'group-rollbacker' => 'Ripristinatura',
	'group-transwiki' => 'Mpurtaturi transwiki',
	'group-accountcreator-member' => 'Criaturi di cuntu',
	'group-developer-member' => 'Sviluppaturi',
	'group-founder-member' => 'Funnaturi',
	'group-import-member' => 'Mpurtaturi',
	'group-ipblock-exempt-member' => 'Esenti dû bloccu IP',
	'group-rollbacker-member' => 'Ripristinaturi',
	'group-transwiki-member' => 'Mpurtaturi transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Criatura di cunti',
	'grouppage-developer' => '{{ns:project}}:Sviluppatura',
	'grouppage-founder' => '{{ns:project}}:Funnatura',
	'grouppage-import' => '{{ns:project}}:Mpurtatura',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Esenti dû bloccu IP',
	'grouppage-rollbacker' => '{{ns:project}}:Ripristinatura',
	'grouppage-transwiki' => '{{ns:project}}:Mpurtatura transwiki',
	'group-steward' => 'Stiùwart',
	'group-sysadmin' => 'Amministratura di sistema',
	'group-Global_bot' => 'Bot glubbali',
	'group-Global_rollback' => 'Ripristinatura glubbali',
	'group-Ombudsmen' => 'Difinsura civici',
	'group-steward-member' => 'Stiùwart',
	'group-sysadmin-member' => 'amministraturi di sistema',
	'group-Global_bot-member' => 'bot glubbali',
	'group-Global_rollback-member' => 'ripristinaturi glubbali',
	'group-Ombudsmen-member' => 'difinsuri cìvicu',
	'grouppage-steward' => 'm:Stewards',
	'grouppage-sysadmin' => 'm:System administrators',
);

/** Scots (Scots)
 * @author OchAyeTheNoo
 */
$messages['sco'] = array(
	'sitesupport' => 'Propines',
);

/** Sindhi (سنڌي)
 * @author Aursani
 */
$messages['sd'] = array(
	'sitesupport' => 'مالي امداد',
	'tooltip-n-sitesupport' => 'اسان جي مدد ڪريو',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'sitesupport' => 'Dunazioni',
	'tooltip-n-sitesupport' => 'Supporthazi',
);

/** Northern Sami (Sámegiella)
 * @author Skuolfi
 */
$messages['se'] = array(
	'sitesupport' => 'Skeaŋkkat',
	'tooltip-n-sitesupport' => 'Doarrjo siidduid doaimma',
);

/** Cmique Itom (Cmique Itom)
 * @author SeriCtam
 */
$messages['sei'] = array(
	'sitesupport' => 'Donación',
	'tooltip-n-sitesupport' => 'Donacíonhuíiitl',
);

/** Tachelhit (Tašlḥiyt)
 * @author Zanatos
 */
$messages['shi'] = array(
	'tooltip-n-sitesupport' => 'ɛawn anɣ',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'wikimediamessages-desc' => 'විකිමාධ්‍ය විශේෂී පණිවුඩයන්',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'පරිත්‍යාග',
	'tooltip-n-sitesupport' => 'අප හට අනුග්‍රහ සපයන්න',
	'group-accountcreator' => 'ගිණුම් තතනන්නන්',
	'group-developer' => 'විකාශකයන්',
	'group-founder' => 'ප්‍රාරම්භකයන්',
	'group-import' => 'ආයාතකරුවන්',
	'group-ipblock-exempt' => 'අන්තර්ජාල වාරණ විවර්ජනයන්',
	'group-rollbacker' => 'පසුපෙරළන්නන්',
	'group-transwiki' => 'අන්තර්විකී ආයාතකරුවන්',
	'group-accountcreator-member' => 'ගිණුම් තනන්නා',
	'group-developer-member' => 'විකාශකයා',
	'group-founder-member' => 'ප්‍රාර්ම්භක',
	'group-import-member' => 'ආයාතකරු',
	'group-ipblock-exempt-member' => 'අන්තර්ජාල වාරණ විවර්ජනය',
	'group-rollbacker-member' => 'පසුපෙරළන්නා',
	'group-transwiki-member' => 'අන්තර්විකි ආයාතකරු',
	'grouppage-accountcreator' => '{{ns:project}}:ගිණුම් තනන්නන්',
	'grouppage-developer' => '{{ns:project}}:විකාශකයන්',
	'grouppage-founder' => '{{ns:project}}:ප්‍රාරම්භකයන්',
	'grouppage-import' => '{{ns:project}}:ආයාත කරුවන්',
	'grouppage-ipblock-exempt' => '{{ns:project}}:අන්තර්ජාල වාරණ විවර්ජනය',
	'grouppage-rollbacker' => '{{ns:project}}:පසුපෙරළන්නන්',
	'grouppage-transwiki' => '{{ns:project}}:අන්තර්විකි ආයාතකරුවන්',
	'group-steward' => 'භාරකරුවන්',
	'group-sysadmin' => 'පද්ධති පරිපාලකයන්',
	'group-Global_bot' => 'ගෝලීය රොබෝවරුන්',
	'group-Global_rollback' => 'ගෝලීය පසුපෙරළන්නන්',
	'group-Ombudsmen' => 'දුග්ගන්නාරාළවරුන්',
	'group-steward-member' => 'භාරකරු',
	'group-sysadmin-member' => 'පද්ධති පරිපාලකවරයා',
	'group-Global_bot-member' => 'ගෝලීය රොබෝවරයා',
	'group-Global_rollback-member' => 'ගෝලීය පසුපෙරළන්නා',
	'group-Ombudsmen-member' => 'දුග්ගන්නාරාළ',
	'grouppage-steward' => 'm:භාරකරුවන්',
	'grouppage-sysadmin' => 'm:පද්ධති පරිපාලකවරුන්',
	'grouppage-Global_bot' => 'm:ගෝලීය රොබෝවරයා',
	'grouppage-Global_rollback' => 'm:ගෝලීය පසුපෙරළීම',
	'grouppage-Ombudsmen' => 'm:දුග්ගන්නාරාළ කොමිසම',
	'group-coder' => 'කේතකරුවන්',
	'group-coder-member' => 'කේතකරු',
	'grouppage-coder' => 'Project:කේතකරු',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'wikimediamessages-desc' => 'Správy špecifické pre Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Zbieranie_príspevkov',
	'sitesupport' => 'Podpora',
	'tooltip-n-sitesupport' => 'Podporte nás',
	'group-accountcreator' => 'Tvorcovia účtov',
	'group-autopatroller' => 'Strážcovia',
	'group-developer' => 'Vývojári',
	'group-founder' => 'Zakladatelia',
	'group-import' => 'Importéri',
	'group-ipblock-exempt' => 'Výnimky z blokovaní IP',
	'group-rollbacker' => 'S právom rollback',
	'group-transwiki' => 'Transwiki importéri',
	'group-uploader' => 'Nahrávajúci',
	'group-accountcreator-member' => 'Tvorca účtu',
	'group-autopatroller-member' => 'strážca',
	'group-developer-member' => 'Vývojár',
	'group-founder-member' => 'Zakladateľ',
	'group-import-member' => 'Importér',
	'group-ipblock-exempt-member' => 'Výnimka z blokovaní IP',
	'group-rollbacker-member' => 'S právom rollback',
	'group-transwiki-member' => 'Transwiki importér',
	'group-uploader-member' => 'nahrávajúci',
	'grouppage-accountcreator' => '{{ns:project}}:Tvorcovia účtov',
	'grouppage-autopatroller' => '{{ns:project}}:Strážcovia',
	'grouppage-developer' => '{{ns:project}}:Vývojári',
	'grouppage-founder' => '{{ns:project}}:Zakladatelia',
	'grouppage-import' => '{{ns:project}}:Importéri',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Výnimky z blokovaní IP',
	'grouppage-rollbacker' => '{{ns:project}}:S právom rollback',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importéri',
	'grouppage-uploader' => '{{ns:project}}:Nahrávajúci',
	'group-steward' => 'Stewardi',
	'group-sysadmin' => 'Správcovia systému',
	'group-Global_bot' => 'Globálni roboti',
	'group-Global_rollback' => 'Globálni rollbackeri',
	'group-Ombudsmen' => 'Ombudsmani',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'správca systému',
	'group-Global_bot-member' => 'Globálny robot',
	'group-Global_rollback-member' => 'Globálny rollbacker',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-coder' => 'Kóderi',
	'group-coder-member' => 'kóder',
);

/** Slovenian (Slovenščina) */
$messages['sl'] = array(
	'sitesupport' => 'Denarni prispevki',
);

/** Samoan (Gagana Samoa) */
$messages['sm'] = array(
	'sitesupport' => 'Meaalofa tupe',
);

/** Southern Sami (Åarjelsaemien)
 * @author M.M.S.
 */
$messages['sma'] = array(
	'sitesupport' => 'Vedtedh beetnegh',
	'tooltip-n-sitesupport' => '{{SITENAME}} dåarjedidh',
);

/** Shona (chiShona)
 * @author Hakka
 */
$messages['sn'] = array(
	'sitesupport' => 'Zvipo',
);

/** Somali (Soomaaliga)
 * @author Mimursal
 */
$messages['so'] = array(
	'sitesupport' => 'Tabarucid',
	'tooltip-n-sitesupport' => 'Nacaawi',
);

/** Albanian (Shqip)
 * @author Dori
 */
$messages['sq'] = array(
	'sitesupport' => 'Dhurime',
	'group-steward' => 'Përgjegjës',
	'group-steward-member' => 'Përgjegjës',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Red Baron
 */
$messages['sr-ec'] = array(
	'wikimediamessages-desc' => 'Поруке специфичне за Викимедију.',
	'sitesupport' => 'Донације',
	'tooltip-n-sitesupport' => 'подржи нас',
	'group-accountcreator' => 'ствараоци налога',
	'group-developer' => 'развијачи софтвера',
	'group-founder' => 'оснивачи',
	'group-import' => 'уносници',
	'group-ipblock-exempt' => 'изузеци од ИП блокова',
	'group-rollbacker' => 'враћачи',
	'group-transwiki' => 'међувики уносници',
	'group-accountcreator-member' => 'стваралац налога',
	'group-developer-member' => 'развијач софтвера',
	'group-founder-member' => 'оснивач',
	'group-import-member' => 'уносник',
	'group-ipblock-exempt-member' => 'изузетак од ИП блокова',
	'group-rollbacker-member' => 'враћач',
	'group-transwiki-member' => 'међувики уносник',
	'grouppage-accountcreator' => '{{ns:project}}:Стварачи налога',
	'grouppage-developer' => '{{ns:project}}:Развијачи софтвера',
	'grouppage-founder' => '{{ns:project}}:Оснивачи',
	'grouppage-import' => '{{ns:project}}:Уносници',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Изузетак од ИП блокова',
	'grouppage-rollbacker' => '{{ns:project}}:Враћачи',
	'grouppage-transwiki' => '{{ns:project}}:Међувики уносници',
	'group-steward' => 'Стјуарди',
	'group-steward-member' => 'Стјуард',
);

/** latinica (latinica) */
$messages['sr-el'] = array(
	'sitesupport' => 'Donacije',
	'group-steward' => 'Stjuardi',
	'group-steward-member' => 'Stjuard',
);

/** Sranan Tongo (Sranantongo)
 * @author Adfokati
 */
$messages['srn'] = array(
	'sitesupport' => 'Yibi a finansi',
	'tooltip-n-sitesupport' => 'Gi wi wan finansi',
);

/** Southern Sotho (Sesotho) */
$messages['st'] = array(
	'sitesupport' => 'Dimpho',
);

/** Seeltersk (Seeltersk)
 * @author Maartenvdbent
 * @author Pyt
 */
$messages['stq'] = array(
	'wikimediamessages-desc' => 'Wikimediaspezifiske Systemättergjuchten',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Spändje',
	'sitesupport' => 'Spenden',
	'tooltip-n-sitesupport' => 'Unnerstutse uus',
	'group-accountcreator' => 'Benutserkonten-Moakere',
	'group-developer' => 'Systemadministrator',
	'group-founder' => 'Gruundere',
	'group-import' => 'Importeur',
	'group-ipblock-exempt' => 'IP-Speere-Uutnoamen',
	'group-rollbacker' => 'Touräächsättere',
	'group-transwiki' => 'Transwiki-Importeure',
	'group-accountcreator-member' => 'Benutserkonten-Moaker',
	'group-developer-member' => 'Systemadministrator',
	'group-founder-member' => 'Gruunder',
	'group-import-member' => 'Importeur',
	'group-ipblock-exempt-member' => 'IP-Speere-Uutnoame',
	'group-rollbacker-member' => 'Touräächsätter',
	'group-transwiki-member' => 'Transwiki-Importeur',
	'grouppage-accountcreator' => '{{ns:project}}:Benutserkonten-Moakere',
	'grouppage-developer' => '{{ns:project}}:Systemadministratore',
	'grouppage-founder' => '{{ns:project}}:Gruundere',
	'grouppage-import' => '{{ns:project}}:Importeure',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Speere-Uutnoame',
	'grouppage-rollbacker' => '{{ns:project}}:Touräächsättere',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importeure',
	'group-steward' => 'Stewarde',
	'group-sysadmin' => 'Systemadministratore',
	'group-Global_bot' => 'Globoale Bots',
	'group-Global_rollback' => 'Globoale Touräächsättere',
	'group-Ombudsmen' => 'Ombudsljuude',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Systemadministrator',
	'group-Global_bot-member' => 'Globoalen Bot',
	'group-Global_rollback-member' => 'Globoalen Touräächsätter',
	'group-Ombudsmen-member' => 'Ombudspersoon',
	'grouppage-steward' => '{{ns:project}}:Stewards',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'wikimediamessages-desc' => 'Talatah-talatah spesifik Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Penggalangan_dana',
	'sitesupport' => 'Sumbangan',
	'tooltip-n-sitesupport' => 'Bobotohan',
	'group-accountcreator' => 'Nu nyieun rekening',
	'group-developer' => 'Developer',
	'group-founder' => 'Nu ngadegkeun',
	'group-import' => 'Importir',
	'group-ipblock-exempt' => 'Peungpeuk kajaba IP',
	'group-rollbacker' => 'Malikeun révisi',
	'group-transwiki' => 'Importir transwiki',
	'group-accountcreator-member' => 'nu nyieun rekening',
	'group-developer-member' => 'developer',
	'group-founder-member' => 'nu ngadegkeun',
	'group-import-member' => 'importir',
	'group-ipblock-exempt-member' => 'Peungpeuk kajaba IP',
	'group-rollbacker-member' => 'Malikeun révisi',
	'group-transwiki-member' => 'importir transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Nu nyieun rekening',
	'grouppage-developer' => '{{ns:project}}:Developer',
	'grouppage-founder' => '{{ns:project}}:Nu ngadegkeun',
	'grouppage-import' => '{{ns:project}}:Importir',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Peungpeuk kajaba IP',
	'grouppage-rollbacker' => '{{ns:project}}:Malikeun révisi',
	'grouppage-transwiki' => '{{ns:project}}:Importir transwiki',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Kuncén sistem',
	'group-Global_bot' => 'Bot global',
	'group-Global_rollback' => 'Malikeun révisi global',
	'group-Ombudsmen' => 'Ombudsman',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'kuncén sistem',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'Malikeun révisi global',
	'group-Ombudsmen-member' => 'Ombudsman',
	'grouppage-steward' => '{{ns:project}}:Steward',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Sannab
 */
$messages['sv'] = array(
	'wikimediamessages-desc' => 'Wikimedia-specifika meddelanden',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/sv',
	'sitesupport' => 'Donationer',
	'tooltip-n-sitesupport' => 'Stöd oss',
	'group-accountcreator' => 'Kontoskapare',
	'group-autopatroller' => 'Autopatrullerare',
	'group-developer' => 'Utvecklare',
	'group-founder' => 'Grundare',
	'group-import' => 'Importörer',
	'group-ipblock-exempt' => 'Undantagna från IP-blockering',
	'group-rollbacker' => 'Tillbakarullare',
	'group-transwiki' => 'Transwiki-importörer',
	'group-uploader' => 'Uppladdare',
	'group-accountcreator-member' => 'kontoskapare',
	'group-autopatroller-member' => 'autopatrullerare',
	'group-developer-member' => 'utvecklare',
	'group-founder-member' => 'grundare',
	'group-import-member' => 'importör',
	'group-ipblock-exempt-member' => 'undantagen från IP-blockering',
	'group-rollbacker-member' => 'tillbakarullare',
	'group-transwiki-member' => 'transwiki-importör',
	'group-uploader-member' => 'uppladdare',
	'grouppage-accountcreator' => '{{ns:project}}:Kontoskapare',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrullerare',
	'grouppage-developer' => '{{ns:project}}:Utvecklare',
	'grouppage-founder' => '{{ns:project}}:Grundare',
	'grouppage-import' => '{{ns:project}}:Importörer',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Undantagna från IP-blockering',
	'grouppage-rollbacker' => '{{ns:project}}:Tillbakarullare',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importörer',
	'grouppage-uploader' => '{{ns:project}}:Uppladdare',
	'group-steward' => 'Stewarder',
	'group-sysadmin' => 'Systemadministratörer',
	'group-Global_bot' => 'Globala robotar',
	'group-Global_rollback' => 'Globala tillbakarullare',
	'group-Ombudsmen' => 'Ombudsmän',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemadministratör',
	'group-Global_bot-member' => 'global robot',
	'group-Global_rollback-member' => 'global tillbakarullare',
	'group-Ombudsmen-member' => 'ombudsman',
	'grouppage-steward' => 'm:Stewards/nb',
	'grouppage-Global_rollback' => 'm:Global rollback/nb',
	'group-coder' => 'Kodare',
	'group-coder-member' => 'kodare',
);

/** Swahili (Kiswahili)
 * @author Malangali
 * @author לערי ריינהארט
 */
$messages['sw'] = array(
	'sitesupport' => 'Michango',
	'tooltip-n-sitesupport' => 'Tuunge mkono',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 * @author Lajsikonik
 */
$messages['szl'] = array(
	'wikimediamessages-desc' => 'Kůmůńikaty ůńikalne lů projektůw Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/pl',
	'sitesupport' => 'Śćepa',
	'tooltip-n-sitesupport' => 'Wspůmůž nas',
	'group-accountcreator' => 'Tworzůncy kůnta',
	'group-autopatroller' => 'Patrolujůncy autůmatyczńy',
	'group-developer' => 'Dewelopery',
	'group-founder' => 'Zołożyćele',
	'group-import' => 'Importery',
	'group-ipblock-exempt' => 'Uprowńyńi do logowańo śe s zawartych adresůw IP',
	'group-rollbacker' => 'Uprowńyńi do wycofywańo sprowjyń',
	'group-transwiki' => 'Importery transwiki',
	'group-uploader' => 'Wćepujůncy pliki',
	'group-accountcreator-member' => 'twůrca kůnt',
	'group-autopatroller-member' => 'patrolujůncy autůmatyczńy',
	'group-developer-member' => 'deweloper',
	'group-founder-member' => 'zołożyćel',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'uprowńůny do logowańo śe s zawartego adresa IP',
	'group-rollbacker-member' => 'uprowńůny do wycofywańo sprowjyń',
	'group-transwiki-member' => 'importer transwiki',
	'group-uploader-member' => 'wćepujůncy pliki',
	'grouppage-accountcreator' => '{{ns:project}}:Twůrcy kůnt',
	'grouppage-autopatroller' => '{{ns:project}}:Patrolujůncy autůmatyczńy',
	'grouppage-developer' => '{{ns:project}}:Dewelopery',
	'grouppage-founder' => '{{ns:project}}:Zołożyćele',
	'grouppage-import' => '{{ns:project}}:Importery',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Uprowńyńi do logowańo śe s zawartych adresůw IP',
	'grouppage-rollbacker' => '{{ns:project}}:Uprowńyńi do wycofywańo sprowjyń',
	'grouppage-transwiki' => '{{ns:project}}:Importery transwiki',
	'grouppage-uploader' => '{{ns:project}}:Wćepujůncy pliki',
	'group-steward' => 'Stewardy',
	'group-sysadmin' => 'Admińistratory systymu',
	'group-Global_bot' => 'Boty globalne',
	'group-Global_rollback' => 'Globalńy uprowńyńi do wycofywańo sprowjyń',
	'group-Ombudsmen' => 'Rzeczńiki prow',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'admińistrator systyma',
	'group-Global_bot-member' => 'bot globalny',
	'group-Global_rollback-member' => 'globalńy uprowńony do wycofywańo sprowjyń',
	'group-Ombudsmen-member' => 'rzeczńik prow',
	'group-coder' => 'Programisty',
	'group-coder-member' => 'programista',
);

/** Tamil (தமிழ்)
 * @author Mayooranathan
 * @author Trengarasu
 */
$messages['ta'] = array(
	'sitesupport' => 'நன்கொடை',
	'tooltip-n-sitesupport' => 'நன்கொடைகளை வழங்குங்கள்',
);

/** Telugu (తెలుగు)
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'wikimediamessages-desc' => 'వికీమీడియా సంబంధిత సందేశాలు',
	'sitesupport' => 'విరాళములు',
	'tooltip-n-sitesupport' => 'మాకు తోడ్పడండి',
	'group-accountcreator' => 'ఖాతా తయారీదార్లు',
	'group-developer' => 'వికాసకులు',
	'group-import' => 'దిగుమతిదార్లు',
	'group-ipblock-exempt' => 'ఐపీ నిరోధపు మినహాయింపులు',
	'group-uploader' => 'ఎగుమతిదార్లు',
	'group-accountcreator-member' => 'ఖాతా సృష్టికర్త',
	'group-developer-member' => 'వికాసకుడు',
	'group-import-member' => 'దిగుమతిదారు',
	'group-ipblock-exempt-member' => 'ఐపీ నిరోధపు మినహాయింపు',
	'grouppage-accountcreator' => '{{ns:project}}:ఖాతా సృష్టికర్తలు',
	'grouppage-developer' => '{{ns:project}}:వికాసకులు',
	'grouppage-import' => '{{ns:project}}:దిగుమతిదార్లు',
	'grouppage-ipblock-exempt' => '{{ns:project}}:ఐపీ నిరోధపు మినహాయింపు',
	'grouppage-uploader' => '{{ns:project}}:ఎగుమతిదార్లు',
	'group-steward' => 'స్టీవార్డులు',
	'group-sysadmin' => 'వ్యవస్థ నిర్వాహకులు',
	'group-steward-member' => 'స్టీవార్డు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'sitesupport' => 'Fó donativu ida',
	'tooltip-n-sitesupport' => 'Tulun ami',
	'group-steward' => 'Steward sira',
	'group-steward-member' => 'Steward',
	'grouppage-steward' => '{{ns:project}}:Steward sira',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 * @author לערי ריינהארט
 */
$messages['tg-cyrl'] = array(
	'wikimediamessages-desc' => 'Пайғомҳои махсуси Викимедиа',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Кӯмаки молӣ',
	'tooltip-n-sitesupport' => 'Моро дастгири намоед',
	'group-accountcreator' => 'Эҷодгарони ҳисоб',
	'group-autopatroller' => 'Гаштзанони худкор',
	'group-developer' => 'Тавсиядиҳандагон',
	'group-founder' => 'Бунёдгузорон',
	'group-import' => 'Воридкунандагон',
	'group-ipblock-exempt' => 'Истиснои қатъи дастрасии нишонаи IP',
	'group-rollbacker' => 'Вогардоникунандагон',
	'group-transwiki' => 'Воридкунандагони трансвики',
	'group-uploader' => 'Боргузорон',
	'group-accountcreator-member' => 'эҷодкунандаи ҳисоб',
	'group-autopatroller-member' => 'гаштзани худкор',
	'group-developer-member' => 'тавсиядиҳанда',
	'group-founder-member' => 'асосгузор',
	'group-import-member' => 'воридкунанда',
	'group-ipblock-exempt-member' => 'Истиснои қатъи дастрасии нишонаи интернетӣ',
	'group-rollbacker-member' => 'вогардоникунанда',
	'group-transwiki-member' => 'воридкунандаи трансвики',
	'group-uploader-member' => 'боргузор',
	'grouppage-accountcreator' => '{{ns:project}}:Созандагони ҳисоби корбарӣ',
	'grouppage-autopatroller' => '{{ns:project}}:Гаштзанони худкор',
	'grouppage-developer' => '{{ns:project}}:Таъвсиядиҳандагон',
	'grouppage-founder' => '{{ns:project}}:Асосгузорон',
	'grouppage-import' => '{{ns:project}}:Воридкунандагон',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Истиснои қатъи дастрасии нишонаи IP',
	'grouppage-rollbacker' => '{{ns:project}}:Вогардоникунандагон',
	'grouppage-transwiki' => '{{ns:project}}:Воридкунандагони трансвики',
	'grouppage-uploader' => '{{ns:project}}:Боргузорон',
	'group-steward' => 'Википедон',
	'group-sysadmin' => 'Мудирони систем',
	'group-Global_bot' => 'Ботҳои саросарӣ',
	'group-Global_rollback' => 'Вогардоникунандагони саросарӣ',
	'group-Ombudsmen' => 'Додоварон',
	'group-steward-member' => 'википед',
	'group-sysadmin-member' => 'мудири систем',
	'group-Global_bot-member' => 'боти саросарӣ',
	'group-Global_rollback-member' => 'вогардоникунандаи саросарӣ',
	'group-Ombudsmen-member' => 'додовар',
	'group-coder' => 'барноманависон',
	'group-coder-member' => 'барноманавис',
);

/** Thai (ไทย)
 * @author Manop
 */
$messages['th'] = array(
	'wikimediamessages-desc' => 'ข้อความเฉพาะของวิกิมีเดีย',
	'sitesupport' => 'สนับสนุน',
	'tooltip-n-sitesupport' => 'สนับสนุนเรา',
	'group-developer' => 'ผู้พัฒนา',
	'group-founder' => 'ผู้ก่อตั้ง',
	'group-founder-member' => 'ผู้ก่อตั้ง',
	'group-uploader-member' => 'ผู้อัปโหลด',
);

/** Turkmen (Türkmen)
 * @author Runningfridgesrule
 */
$messages['tk'] = array(
	'sitesupport' => 'Haýyr-sawahatlar',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 * @author לערי ריינהארט
 */
$messages['tl'] = array(
	'wikimediamessages-desc' => 'Tiyak na mga mensahe ng Wikimedia',
	'sitesupport-url' => 'as is',
	'sitesupport' => 'Mag-ambag',
	'tooltip-n-sitesupport' => 'Tangkilikin kami',
	'group-accountcreator' => 'Mga tagapalikha ng kuwenta/akawnt',
	'group-autopatroller' => 'Mga kusa/awtomatikong tagapatrolya (awtopatrolyador)',
	'group-developer' => 'Mga tagapagpaunlad',
	'group-founder' => 'Mga tagapagtatag',
	'group-import' => 'Mga tagapagangkat',
	'group-ipblock-exempt' => 'Mga hindi kasali sa paghaharang/paghahadlang ng IP',
	'group-rollbacker' => 'Mga tagagpagpagulong pabalik sa dati',
	'group-transwiki' => 'Mga tagapagangkat na panglipat-wiki/transwiki',
	'group-uploader' => 'Mga tagapagkarga',
	'group-accountcreator-member' => 'tagapaglikha ng kuwenta/akawnt',
	'group-autopatroller-member' => 'kusang tagapatrolya/awtopatrolyador',
	'group-developer-member' => 'tagapagpaunlad',
	'group-founder-member' => 'tagapagtatag',
	'group-import-member' => 'tagapagangkat',
	'group-ipblock-exempt-member' => 'Hindi kasali sa pagharang/paghadlang ng IP',
	'group-rollbacker-member' => 'tagapagpagulong pabalik sa dati',
	'group-transwiki-member' => 'tagapagangkat na pangtranswiki/lipat-wiki',
	'group-uploader-member' => 'tagapagkarga',
	'grouppage-accountcreator' => '{{ns:project}}:Mga tagapaglikha ng akawnt/kuwenta',
	'grouppage-autopatroller' => '{{ns:project}}:Mga awtopatrolyador',
	'grouppage-developer' => '{{ns:project}}:Mga tagapagpaunlad',
	'grouppage-founder' => '{{ns:project}}:Mga tagapagtatag',
	'grouppage-import' => '{{ns:project}}:Mga tagapagangkat',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Hind kasali sa paghadlang na pang-IP',
	'grouppage-rollbacker' => '{{ns:project}}:Mga tagapagpagulong pabalik sa dati',
	'grouppage-transwiki' => '{{ns:project}}:Mga tagapagangkat na pangtranswiki/panglipat-wiki',
	'grouppage-uploader' => '{{ns:project}}:Mga tagapagkarga',
	'group-steward' => 'Mga bandahali',
	'group-sysadmin' => 'Mga tagapangasiwa ng sistema',
	'group-Global_bot' => "Pandaigdigang mga ''bot''",
	'group-Global_rollback' => 'Pandaigdigang mga tagapagpagulong pabalik sa dati',
	'group-Ombudsmen' => 'Mga tanod-bayan',
	'group-steward-member' => 'bandahali',
	'group-sysadmin-member' => 'tagapangasiwa ng sistema',
	'group-Global_bot-member' => "pandaigdigang ''bot''",
	'group-Global_rollback-member' => 'pandaigdigang tagapagpagulong pabalik sa dati',
	'group-Ombudsmen-member' => 'tanod-bayan',
	'grouppage-steward' => 'm:Mga bandahali',
	'grouppage-sysadmin' => 'm:Mga tagapangasiwa ng sistema',
	'grouppage-Global_bot' => 'm:Pandaigdigang bot',
	'grouppage-Global_rollback' => 'm:Pandaigdigang pagpapagulong-pabalik sa dati',
	'grouppage-Ombudsmen' => 'm:Komisyon ng tanod-bayan',
	'group-coder' => 'Mga tagapagkodigo',
	'group-coder-member' => 'tagapagkodigo',
	'grouppage-coder' => 'Project:Tagapagkodigo',
);

/** Tswana (Setswana)
 * @author Hakka
 */
$messages['tn'] = array(
	'sitesupport' => 'Dimpho',
);

/** Tonga (faka-Tonga) */
$messages['to'] = array(
	'sitesupport' => 'Ngaahi meʻa ʻofa',
	'group-steward' => 'Kau setuate',
	'group-steward-member' => 'Setuate',
);

/** Toki Pona (Toki Pona) */
$messages['tokipona'] = array(
	'sitesupport' => 'o pana e mani',
);

/** Tok Pisin (Tok Pisin)
 * @author לערי ריינהארט
 */
$messages['tpi'] = array(
	'sitesupport' => 'Givim moni',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'wikimediamessages-desc' => 'Vikimedya özel mesajları',
	'sitesupport' => 'Bağışlar',
	'group-steward' => 'Stewardlar',
	'group-sysadmin' => 'Sistem yöneticileri',
	'group-sysadmin-member' => 'Sistem yöneticisi',
	'grouppage-steward' => '{{ns:project}}:Stewardlar',
);

/** Tsonga (Xitsonga)
 * @author Thuvack
 */
$messages['ts'] = array(
	'sitesupport' => 'Nyikela mali',
	'tooltip-n-sitesupport' => 'Hi seketeli',
);

/** Tatar (Cyrillic) (Tatarça/Татарча (Cyrillic))
 * @author Ерней
 */
$messages['tt-cyrl'] = array(
	'sitesupport' => 'Иганә',
	'tooltip-n-sitesupport' => 'Безгә ярдәм итегез',
);

/** Tatar (Latin) (Tatarça/Татарча (Latin)) */
$messages['tt-latn'] = array(
	'sitesupport' => 'Ximäyäçegä',
);

/** Tahitian (Reo Mā`ohi) */
$messages['ty'] = array(
	'sitesupport' => 'Pūpū i te ō',
);

/** Tuvinian (Тыва дыл) */
$messages['tyv'] = array(
	'sitesupport' => 'Белектер',
);

/** Udmurt (Удмурт)
 * @author ОйЛ
 */
$messages['udm'] = array(
	'sitesupport' => 'Проектлы юрттон',
);

/** Uighur (Uyghurche‎ / ئۇيغۇرچە) */
$messages['ug'] = array(
	'sitesupport' => 'Iana Toplash',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 */
$messages['uk'] = array(
	'wikimediamessages-desc' => 'Повідомлення, характерні для Вікімедіа',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Пожертвування',
	'tooltip-n-sitesupport' => 'Підтримайте проект',
	'group-accountcreator' => 'Створювачі облікових записів',
	'group-autopatroller' => 'Автопатрульні',
	'group-developer' => 'Розробники',
	'group-founder' => 'Засновники',
	'group-import' => 'Імпортери',
	'group-ipblock-exempt' => 'Виключення з IP-блокувань',
	'group-rollbacker' => 'Відкочувачі',
	'group-transwiki' => 'Transwiki-імпортери',
	'group-uploader' => 'Завантажувачі',
	'group-accountcreator-member' => 'створювач облікових записів',
	'group-autopatroller-member' => 'автопатрульний',
	'group-developer-member' => 'розробник',
	'group-founder-member' => 'засновник',
	'group-import-member' => 'імпортер',
	'group-ipblock-exempt-member' => 'виключення з IP-блокування',
	'group-rollbacker-member' => 'відкочувач',
	'group-transwiki-member' => 'Transwiki-імпортер',
	'group-uploader-member' => 'завантажувач',
	'grouppage-accountcreator' => '{{ns:project}}:Створювачі облікових записів',
	'grouppage-autopatroller' => '{{ns:project}}:Автопатрульні',
	'grouppage-developer' => '{{ns:project}}:Розробники',
	'grouppage-founder' => '{{ns:project}}:Засновники',
	'grouppage-import' => '{{ns:project}}:Імпортери',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Виключення з IP-блокування',
	'grouppage-rollbacker' => '{{ns:project}}:Відкочувачі',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-імпортери',
	'grouppage-uploader' => '{{ns:project}}:Завантажувачі',
	'group-steward' => 'Стюарди',
	'group-sysadmin' => 'Системні адміністратори',
	'group-Global_bot' => 'Глобальні боти',
	'group-Global_rollback' => 'Глобальні відкочувачі',
	'group-Ombudsmen' => 'Омбудсмени',
	'group-steward-member' => 'стюард',
	'group-sysadmin-member' => 'системний адміністратор',
	'group-Global_bot-member' => 'глобальний бот',
	'group-Global_rollback-member' => 'глобальний відкочувач',
	'group-Ombudsmen-member' => 'омбудсмен',
	'grouppage-steward' => '{{ns:project}}:Стюарди',
	'group-coder' => 'Програмісти',
	'group-coder-member' => 'програміст',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'sitesupport' => 'رابطہ',
);

/** Uzbek (O'zbek) */
$messages['uz'] = array(
	'sitesupport' => "Loyihaga ko'mak",
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'wikimediamessages-desc' => 'Messagi specifici de Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/vec',
	'sitesupport' => 'Donassioni',
	'tooltip-n-sitesupport' => 'Jùtane',
	'group-accountcreator' => 'Creatori de account',
	'group-autopatroller' => 'Patujadori automàteghi',
	'group-developer' => 'Svilupadori',
	'group-founder' => 'Fondatori',
	'group-import' => 'Inportadori',
	'group-ipblock-exempt' => "Esenzioni dal bloco de l'IP",
	'group-rollbacker' => 'Ripristinadori',
	'group-transwiki' => 'Inportadori transwiki',
	'group-uploader' => 'Caricadori',
	'group-accountcreator-member' => 'Creator de account',
	'group-autopatroller-member' => 'patujador automàtego',
	'group-developer-member' => 'Svilupador',
	'group-founder-member' => 'Fondator',
	'group-import-member' => 'Inportador',
	'group-ipblock-exempt-member' => 'esente dal bloco IP',
	'group-rollbacker-member' => 'ripristinador',
	'group-transwiki-member' => 'Inportador transwiki',
	'group-uploader-member' => 'caricador',
	'grouppage-accountcreator' => '{{ns:project}}:Creatori de account',
	'grouppage-autopatroller' => '{{ns:project}}:Patujadori automàteghi',
	'grouppage-developer' => '{{ns:project}}:Svilupadori',
	'grouppage-founder' => '{{ns:project}}:Fondatori',
	'grouppage-import' => '{{ns:project}}:Inportadori',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Esenzion dal bloco de l'IP",
	'grouppage-rollbacker' => '{{ns:project}}:Ripristinadori',
	'grouppage-transwiki' => '{{ns:project}}:Inportadori transwiki',
	'grouppage-uploader' => '{{ns:project}}:Caricadori',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Aministradori de sistema',
	'group-Global_bot' => 'Bot globali',
	'group-Global_rollback' => 'Ripristinadori globali',
	'group-Ombudsmen' => 'Ombudsman',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'aministrador de sistema',
	'group-Global_bot-member' => 'bot globale',
	'group-Global_rollback-member' => 'ripristinador globale',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-coder' => 'Programatori',
	'group-coder-member' => 'programator',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 * @author לערי ריינהארט
 */
$messages['vi'] = array(
	'wikimediamessages-desc' => 'Các thông báo đặc trưng cho Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Quy%C3%AAn_g%C3%B3p',
	'sitesupport' => 'Quyên góp',
	'tooltip-n-sitesupport' => 'Hãy hỗ trợ chúng tôi',
	'group-accountcreator' => 'Người mở tài khoản',
	'group-autopatroller' => 'Tuần tra viên tự động',
	'group-developer' => 'Người phát triển',
	'group-founder' => 'Nhà sáng lập',
	'group-import' => 'Người nhập trang',
	'group-ipblock-exempt' => 'Người được miễn cấm IP',
	'group-rollbacker' => 'Người lùi sửa',
	'group-transwiki' => 'Người nhập trang giữa wiki',
	'group-uploader' => 'Người tải lên',
	'group-accountcreator-member' => 'Người mở tài khoản',
	'group-autopatroller-member' => 'tuần tra viên tự động',
	'group-developer-member' => 'Người phát triển',
	'group-founder-member' => 'Nhà sáng lập',
	'group-import-member' => 'Người nhập trang',
	'group-ipblock-exempt-member' => 'Người được miễn cấm IP',
	'group-rollbacker-member' => 'Người lùi sửa',
	'group-transwiki-member' => 'Người nhập trang giữa wiki',
	'group-uploader-member' => 'người tải lên',
	'grouppage-accountcreator' => '{{ns:project}}:Người mở tài khoản',
	'grouppage-autopatroller' => '{{ns:project}}:Tuần tra viên tự động',
	'grouppage-developer' => '{{ns:project}}:Người phát triển',
	'grouppage-founder' => '{{ns:project}}:Nhà sáng lập',
	'grouppage-import' => '{{ns:project}}:Người nhập trang',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Người được miễn cấm IP',
	'grouppage-rollbacker' => '{{ns:project}}:Người lùi sửa',
	'grouppage-transwiki' => '{{ns:project}}:Người nhập trang giữa wiki',
	'grouppage-uploader' => '{{ns:project}}:Người tải lên',
	'group-steward' => 'Tiếp viên',
	'group-sysadmin' => 'Người quản lý hệ thống',
	'group-Global_bot' => 'Robot toàn cầu',
	'group-Global_rollback' => 'Thành viên lùi sửa toàn cầu',
	'group-Ombudsmen' => 'Thanh tra viên',
	'group-steward-member' => 'Tiếp viên',
	'group-sysadmin-member' => 'người quản lý hệ thống',
	'group-Global_bot-member' => 'robot toàn cầu',
	'group-Global_rollback-member' => 'người lùi sửa toàn cầu',
	'group-Ombudsmen-member' => 'thanh tra viên',
	'group-coder' => 'Lập trình viên',
	'group-coder-member' => 'lập trình viên',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'sitesupport' => 'Födagivots',
	'tooltip-n-sitesupport' => 'Stütolös obsi',
	'group-accountcreator' => 'Kalijafans',
	'group-founder' => 'Fünans',
	'group-import' => 'Nüveigans',
	'group-rollbacker' => 'Sädunans',
	'group-uploader' => 'Löpükans',
	'group-accountcreator-member' => 'kalijafan',
	'group-founder-member' => 'fünan',
	'group-import-member' => 'nüveigan',
	'group-rollbacker-member' => 'sädunan',
	'group-uploader-member' => 'löpükan',
	'grouppage-accountcreator' => '{{ns:project}}:Kalijafans',
	'grouppage-founder' => '{{ns:project}}:Fünans',
	'grouppage-import' => '{{ns:project}}:Nüveigans',
	'grouppage-rollbacker' => '{{ns:project}}:Sädunans',
	'grouppage-uploader' => '{{ns:project}}:Löpükans',
	'group-sysadmin' => 'Sitiguvans',
	'group-sysadmin-member' => 'sitiguvan',
	'group-coder' => 'Kotans',
	'group-coder-member' => 'kotan',
);

/** Walloon (Walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'sitesupport' => 'Ecwårlaedje',
	'group-steward' => 'Mwaisse-manaedjeus tot avå',
	'group-steward-member' => 'mwaisse-manaedjeu tot avå',
);

/** Waray (Winaray)
 * @author לערי ריינהארט
 */
$messages['war'] = array(
	'sitesupport' => 'Mga Donasyon',
);

/** Wolof (Wolof)
 * @author Ibou
 */
$messages['wo'] = array(
	'sitesupport' => 'Joxe ag ndimbal',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'sitesupport' => '捐款',
);

/** Xhosa (isiXhosa) */
$messages['xh'] = array(
	'sitesupport' => 'Amalizo',
);

/** Mingrelian (მარგალური)
 * @author Alsandro
 * @author Dato deutschland
 */
$messages['xmf'] = array(
	'sitesupport' => 'აზარა',
	'tooltip-n-sitesupport' => 'ხუჯ დომკინით',
);

/** Yiddish (ייִדיש)
 * @author Yidel
 */
$messages['yi'] = array(
	'sitesupport' => 'ביישטייערונגן',
	'tooltip-n-sitesupport' => 'שטיצט אונז',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'sitesupport' => 'Se ẹ̀bùn owó',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'wikimediamessages-desc' => 'Wikimedia特定訊息',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/{{urlencode:捐贈}}',
	'sitesupport' => '慷慨解囊',
	'tooltip-n-sitesupport' => '資持我哋',
	'group-accountcreator' => '開戶專員',
	'group-developer' => '技術員',
	'group-founder' => '創辦人',
	'group-import' => '匯入者',
	'group-ipblock-exempt' => 'IP封鎖例外者',
	'group-rollbacker' => '反轉者',
	'group-transwiki' => 'Transwiki匯入者',
	'group-accountcreator-member' => '開戶專員',
	'group-developer-member' => '技術員',
	'group-founder-member' => '創辦人',
	'group-import-member' => '匯入者',
	'group-ipblock-exempt-member' => 'IP封鎖例外',
	'group-rollbacker-member' => '反轉者',
	'group-transwiki-member' => 'Transwiki匯入者',
	'grouppage-accountcreator' => '{{ns:project}}:開戶專員',
	'grouppage-developer' => '{{ns:project}}:技術員',
	'grouppage-founder' => '{{ns:project}}:創辦人',
	'grouppage-import' => '{{ns:project}}:匯入者',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP封鎖例外',
	'grouppage-rollbacker' => '{{ns:project}}:反轉者',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki匯入者',
	'group-steward' => '執行員',
	'group-sysadmin' => '系統管理員',
	'group-Global_bot' => '全域機械人',
	'group-Global_rollback' => '全域反轉者',
	'group-Ombudsmen' => '申訴專員',
	'group-steward-member' => '執行員',
	'group-sysadmin-member' => '系統管理員',
	'group-Global_bot-member' => '全域機械人',
	'group-Global_rollback-member' => '全域反轉者',
	'group-Ombudsmen-member' => '申訴專員',
);

/** Zeeuws (Zeêuws)
 * @author NJ
 */
$messages['zea'] = array(
	'sitesupport' => 'Donaoties',
);

/** Classical Chinese (文言) */
$messages['zh-classical'] = array(
	'wikimediamessages-desc' => '維基媒體特集',
	'sitesupport' => '捐助集',
	'tooltip-n-sitesupport' => '濟資財、施續命、傳美皓',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 */
$messages['zh-hans'] = array(
	'wikimediamessages-desc' => '维基媒体特定信息',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/{{urlencode:赞助}}',
	'sitesupport' => '资助',
	'tooltip-n-sitesupport' => '资助我们',
	'group-accountcreator' => '账户创建员',
	'group-autopatroller' => '自动巡视员',
	'group-developer' => '开发员',
	'group-founder' => '创办人',
	'group-import' => '导入者',
	'group-ipblock-exempt' => 'IP查封例外者',
	'group-rollbacker' => '回退员',
	'group-transwiki' => '跨维基导入者',
	'group-uploader' => '上传文件用户',
	'group-accountcreator-member' => '账户创建员',
	'group-autopatroller-member' => '自动巡视员',
	'group-developer-member' => '开发员',
	'group-founder-member' => '创办人',
	'group-import-member' => '导入者',
	'group-ipblock-exempt-member' => 'IP查封例外',
	'group-rollbacker-member' => '回退员',
	'group-transwiki-member' => '跨维基导入者',
	'group-uploader-member' => '上传文件用户',
	'grouppage-accountcreator' => '{{ns:project}}:账户创建员',
	'grouppage-autopatroller' => '{{ns:project}}:自动巡视员',
	'grouppage-developer' => '{{ns:project}}:开发员',
	'grouppage-founder' => '{{ns:project}}:创办人',
	'grouppage-import' => '{{ns:project}}:回退员',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP查封例外',
	'grouppage-rollbacker' => '{{ns:project}}:反转者',
	'grouppage-transwiki' => '{{ns:project}}:跨维基导入者',
	'grouppage-uploader' => '{{ns:project}}:上传文件用户',
	'group-steward' => '监管员',
	'group-sysadmin' => '系统管理员',
	'group-Global_bot' => '全域机器人',
	'group-Global_rollback' => '全域反转者',
	'group-Ombudsmen' => '申诉专员',
	'group-steward-member' => '监管员',
	'group-sysadmin-member' => '系统管理员',
	'group-Global_bot-member' => '全域机器人',
	'group-Global_rollback-member' => '全域反转者',
	'group-Ombudsmen-member' => '申诉专员',
	'group-coder' => '编程人员',
	'group-coder-member' => '编程人员',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'wikimediamessages-desc' => '維基媒體特定信息',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/{{urlencode:資助}}',
	'sitesupport' => '贊助',
	'tooltip-n-sitesupport' => '資助我們',
	'group-accountcreator' => '賬戶創建員',
	'group-developer' => '開發員',
	'group-founder' => '創辦人',
	'group-import' => '匯入者',
	'group-ipblock-exempt' => 'IP查封例外者',
	'group-rollbacker' => '回退員',
	'group-transwiki' => '跨維基匯入者',
	'group-uploader' => '上載者',
	'group-accountcreator-member' => '賬戶創建員',
	'group-developer-member' => '開發員',
	'group-founder-member' => '創辦人',
	'group-import-member' => '匯入者',
	'group-ipblock-exempt-member' => 'IP查封例外',
	'group-rollbacker-member' => '回退員',
	'group-transwiki-member' => '跨維基匯入者',
	'grouppage-accountcreator' => '{{ns:project}}:賬戶創建員',
	'grouppage-developer' => '{{ns:project}}:開發員',
	'grouppage-founder' => '{{ns:project}}:創辦人',
	'grouppage-import' => '{{ns:project}}:回退員',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP查封例外',
	'grouppage-rollbacker' => '{{ns:project}}:反轉者',
	'grouppage-transwiki' => '{{ns:project}}:跨維基匯入者',
	'group-steward' => '監管員',
	'group-sysadmin' => '系統管理員',
	'group-Global_bot' => '全域機器人',
	'group-Global_rollback' => '全域反轉者',
	'group-Ombudsmen' => '申訴專員',
	'group-steward-member' => '監管員',
	'group-sysadmin-member' => '系統管理員',
	'group-Global_bot-member' => '全域機器人',
	'group-Global_rollback-member' => '全域反轉者',
	'group-Ombudsmen-member' => '申訴專員',
);

/** Chinese (Hong Kong) (‪中文(香港)‬) */
$messages['zh-hk'] = array(
	'group-Global_bot' => '全域機械人',
	'group-Global_bot-member' => '全域機械人',
);

/** Zulu (isiZulu)
 * @author לערי ריינהארט
 */
$messages['zu'] = array(
	'sitesupport' => 'Izipho',
);

