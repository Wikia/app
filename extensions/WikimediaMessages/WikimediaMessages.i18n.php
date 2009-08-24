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
	'group-founder'               => 'Founders',
	'group-import'                => 'Importers',
	'group-ipblock-exempt'        => 'IP block exemptions',
	'group-rollbacker'            => 'Rollbackers',
	'group-transwiki'             => 'Transwiki importers',
	'group-uploader'              => 'Uploaders',
	'group-bigexport'             => 'Big exporters',
	'group-abusefilter'           => 'Abuse filter editors',

	'group-accountcreator-member' => 'account creator',
	'group-autopatroller-member'  => 'autopatroller',
	'group-founder-member'        => 'founder',
	'group-import-member'         => 'importer',
	'group-ipblock-exempt-member' => 'IP block exempt',
	'group-rollbacker-member'     => 'rollbacker',
	'group-transwiki-member'      => 'transwiki importer',
	'group-uploader-member'       => 'uploader',
	'group-bigexport-member'      => 'big exporter',
	'group-abusefilter-member'    => 'abuse filter editor',

	'grouppage-accountcreator' => '{{ns:project}}:Account creators',
	'grouppage-autopatroller'  => '{{ns:project}}:Autopatrollers',
	'grouppage-founder'        => '{{ns:project}}:Founders',
	'grouppage-import'         => '{{ns:project}}:Importers',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP block exemption',
	'grouppage-rollbacker'     => '{{ns:project}}:Rollbackers',
	'grouppage-transwiki'      => '{{ns:project}}:Transwiki importers',
	'grouppage-uploader'       => '{{ns:project}}:Uploaders',
	'grouppage-bigexport'      => '{{ns:project}}:Big exporters',
	'grouppage-abusefilter'    => '{{ns:project}}:Abuse filter editors',

	# Global Wikimedia specific usergroups (defined on http://meta.wikimedia.org/wiki/Special:GlobalGroupPermissions)

	'group-steward'         => 'Stewards',
	'group-sysadmin'        => 'System administrators',
	'group-Global_bot'      => 'Global bots',
	'group-Global_rollback' => 'Global rollbackers',
	'group-Ombudsmen'       => 'Ombudsmen',
	'group-Staff'           => 'Staffs',

	'group-steward-member'         => 'steward',
	'group-sysadmin-member'        => 'system administrator',
	'group-Global_bot-member'      => 'global bot',
	'group-Global_rollback-member' => 'global rollbacker',
	'group-Ombudsmen-member'       => 'ombudsman',
	'group-Staff-member'           => 'staff',

	'grouppage-steward'         => 'm:Stewards', # only translate this message to other languages if you have to change it
	'grouppage-sysadmin'        => 'm:System administrators', # only translate this message to other languages if you have to change it
	'grouppage-Global_bot'      => 'm:Global bot', # only translate this message to other languages if you have to change it
	'grouppage-Global_rollback' => 'm:Global rollback', # only translate this message to other languages if you have to change it
	'grouppage-Ombudsmen'       => 'm:Ombudsman commission', # only translate this message to other languages if you have to change it
	'grouppage-Staff'           => 'Foundation:Staff', # only translate this message to other languages if you have to change it

	# mediawiki.org specific user group

	'group-coder'        => 'Coders',
	'group-coder-member' => 'coder',
	'grouppage-coder'    => 'Project:Coder', # only translate this message to other languages if you have to change it
	
	# The name for the common shared repo 'shared'
	'shared-repo-name-shared' => 'Wikimedia Commons', # only translate this message to other languages if you have to change it
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Meno25
 * @author Purodha
 * @author SPQRobin
 * @author Siebrand
 * @author Sp5uhe
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
	'group-bigexport' => 'Big export user has a right to: {{int:right-override-export-depth}}',
	'group-accountcreator-member' => 'A member of the group {{msg|group-accountcreator}}.',
	'group-founder-member' => 'A member in the group {{msg|group-founder}} (used exclusively for [[wikipedia:User:Jimbo Wales|Jimbo Wales]]).',
	'group-rollbacker-member' => '{{Identical|Rollback}}',
	'group-bigexport-member' => 'Big export user has a right to: {{int:Right-override-export-depth}}',
	'grouppage-rollbacker' => '{{Identical|Rollback}}',
	'grouppage-bigexport' => 'To be used in wikitext inside double square brackets, that is, as a link to a descriptive page. Do not alter or translate "<code>{<nowiki />{ns:project}}:</code>".

Big export user has a right to: {{int:right-override-export-depth}}',
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

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'wikimediamessages-desc' => 'WikiMedial kävutadud specifižed tedotused',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Tehta_rahalahj',
	'sitesupport' => 'Rahalahjad',
	'tooltip-n-sitesupport' => 'Tugekat meid',
	'group-accountcreator' => 'Registrirujad',
	'group-autopatroller' => 'Avtomatižešti patruliruidud',
	'group-founder' => 'Alusenpanijad',
	'group-import' => 'Importörad',
	'group-ipblock-exempt' => 'Erindad IP-blokiruindoišpäi',
	'group-rollbacker' => 'Endištajad',
	'group-transwiki' => 'Importörad Transwikišpäi',
	'group-uploader' => 'Jügutoitajad',
	'group-accountcreator-member' => 'Registrirujad',
	'group-autopatroller-member' => 'Avtomatižešti patruliruidud',
	'group-founder-member' => 'alusenpanii',
	'group-import-member' => 'importör',
	'group-ipblock-exempt-member' => 'Erind IP-blokiruindoišpäi',
	'group-rollbacker-member' => 'endištai',
	'group-transwiki-member' => 'importör Transwikišpäi',
	'group-uploader-member' => 'jügutoitai',
	'group-bigexport-member' => 'järed eksportör',
	'grouppage-accountcreator' => '{{ns:project}}:Registrirujad',
	'grouppage-autopatroller' => '{{ns:project}}:Avtomatižešti patruliruidud',
	'grouppage-founder' => '{{ns:project}}:Alusenpanijad',
	'grouppage-import' => '{{ns:project}}:Importörad',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Erind IP-blokiruindoišpäi',
	'grouppage-rollbacker' => '{{ns:project}}:Endištajad',
	'grouppage-transwiki' => '{{ns:project}}:Importörad Transwikišpäi',
	'grouppage-uploader' => '{{ns:project}}:Jügutoitajad',
	'group-steward' => 'Stüardad',
	'group-sysadmin' => 'Sisteman administratorad',
	'group-Global_bot' => 'Globaližed botad',
	'group-Global_rollback' => 'Globaližed endištajad',
	'group-Ombudsmen' => 'Ombudsmenad',
	'group-Staff' => 'projektan radnikad',
	'group-steward-member' => 'stüard',
	'group-sysadmin-member' => 'sisteman administratorad',
	'group-Global_bot-member' => 'globaline bot',
	'group-Global_rollback-member' => 'globaline endištai',
	'group-Ombudsmen-member' => 'ombudsmen',
	'group-Staff-member' => 'projektan radnik',
	'group-coder' => 'Programmistad',
	'group-coder-member' => 'programmist',
);

/** Achinese (Acèh)
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
	'group-founder' => 'Grondleggers',
	'group-import' => 'Importeurders',
	'group-transwiki' => 'Transwiki-importeurs',
	'group-founder-member' => 'Grondlegger',
	'group-import-member' => 'Importeurder',
	'grouppage-founder' => '{{ns:project}}:Grondleggers',
	'grouppage-import' => '{{ns:project}}:Importeurders',
	'group-steward' => 'Waarde',
	'group-Global_bot' => 'Globale botte',
	'group-Ombudsmen' => 'Ombudsmanne',
	'group-Staff' => 'Personeel',
	'group-steward-member' => 'Waard',
	'group-sysadmin-member' => 'Stelseladministrateur',
	'group-Global_bot-member' => 'globale bot',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'Personeellid',
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
	'group-founder' => 'Fundadors',
	'group-import' => 'Importadors',
	'group-ipblock-exempt' => 'Exenzion de bloqueyo IP',
	'group-rollbacker' => 'Esfedors',
	'group-transwiki' => 'Importadors de transwiki',
	'group-uploader' => 'Cargadors',
	'group-accountcreator-member' => 'Creyador de cuenta',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'Exenzion de bloqueyo IP',
	'group-rollbacker-member' => 'Rebertidor',
	'group-transwiki-member' => 'Importador transwiki',
	'group-uploader-member' => 'cargador',
	'grouppage-accountcreator' => '{{ns:project}}:Creyadors de cuenta',
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
	'group-founder' => 'مؤسسون',
	'group-import' => 'مستوردون',
	'group-ipblock-exempt' => 'مستثنون من منع الأيبي',
	'group-rollbacker' => 'مسترجعون',
	'group-transwiki' => 'مستوردون عبر الويكي',
	'group-uploader' => 'رافعون',
	'group-bigexport' => 'مصدرون كبار',
	'group-abusefilter' => 'معدلو مرشحات الإساءة',
	'group-accountcreator-member' => 'منشئ حساب',
	'group-autopatroller-member' => 'مراجع تلقائي',
	'group-founder-member' => 'مؤسس',
	'group-import-member' => 'مستورد',
	'group-ipblock-exempt-member' => 'مستثنى من منع الأيبي',
	'group-rollbacker-member' => 'مسترجع',
	'group-transwiki-member' => 'مستورد عبر الويكي',
	'group-uploader-member' => 'رافع',
	'group-bigexport-member' => 'مصدر كبير',
	'group-abusefilter-member' => 'معدل مرشح الإساءة',
	'grouppage-accountcreator' => '{{ns:project}}:منشئو الحسابات',
	'grouppage-autopatroller' => '{{ns:project}}:مراجعون تلقائيون',
	'grouppage-founder' => '{{ns:project}}:مؤسسون',
	'grouppage-import' => '{{ns:project}}:مستوردون',
	'grouppage-ipblock-exempt' => '{{ns:project}}:استثناء من منع الأيبي',
	'grouppage-rollbacker' => '{{ns:project}}:مسترجعون',
	'grouppage-transwiki' => '{{ns:project}}:مستوردون عبر الويكي',
	'grouppage-uploader' => '{{ns:project}}:رافعون',
	'grouppage-bigexport' => '{{ns:project}}:مصدرون كبار',
	'grouppage-abusefilter' => '{{ns:project}}:معدلو مرشح الإساءة',
	'group-steward' => 'مضيفون',
	'group-sysadmin' => 'إداريو النظام',
	'group-Global_bot' => 'بوتات عامة',
	'group-Global_rollback' => 'مسترجعون عامون',
	'group-Ombudsmen' => 'أومبدسمين',
	'group-Staff' => 'مشرفون',
	'group-steward-member' => 'مضيف',
	'group-sysadmin-member' => 'إداري نظام',
	'group-Global_bot-member' => 'بوت عام',
	'group-Global_rollback-member' => 'مسترجع عام',
	'group-Ombudsmen-member' => 'أومبدسمان',
	'group-Staff-member' => 'عضو من المشرفين',
	'grouppage-steward' => 'm:Stewards/ar',
	'grouppage-Global_rollback' => 'm:Global rollback/ar',
	'grouppage-Staff' => 'Foundation:الطاقم',
	'group-coder' => 'مكودون',
	'group-coder-member' => 'مكود',
	'grouppage-coder' => 'Project:مكود',
	'shared-repo-name-shared' => 'ويكيميديا كومنز',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'sitesupport' => 'ܕܒܘܚ ܠܢ',
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
	'group-founder' => 'مؤسسين',
	'group-import' => 'مستوردين',
	'group-ipblock-exempt' => 'مستثنيين من منع الااى بى',
	'group-rollbacker' => 'مسترجعين',
	'group-transwiki' => 'مستوردين عبر الويكى',
	'group-uploader' => 'المحملين',
	'group-accountcreator-member' => 'مؤسس حساب',
	'group-autopatroller-member' => 'اوتوباترولار',
	'group-founder-member' => 'مؤسس',
	'group-import-member' => 'مستورد',
	'group-ipblock-exempt-member' => 'مستثنى من منع الاايبى',
	'group-rollbacker-member' => 'مسترجع',
	'group-transwiki-member' => 'مستورد عبر الويكى',
	'group-uploader-member' => 'المحمل',
	'grouppage-accountcreator' => '{{ns:project}}:منشئين الحسابات',
	'grouppage-autopatroller' => '{{ns:project}}:اوتوباترولارز',
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
	'group-Staff' => 'مشرفون',
	'group-steward-member' => 'مضيف',
	'group-sysadmin-member' => 'ادارى نظام',
	'group-Global_bot-member' => 'بوت عام',
	'group-Global_rollback-member' => 'مسترجع عام',
	'group-Ombudsmen-member' => 'اومبدادزمان',
	'group-Staff-member' => 'عضو من المشرفين',
	'grouppage-steward' => 'm:Stewards/ar',
	'grouppage-Global_rollback' => 'm:Global rollback/ar',
	'grouppage-Staff' => 'Foundation:الطاقم',
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
	'group-Staff' => 'কর্মীবৃন্দ',
	'group-Staff-member' => 'কর্মচাৰী',
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
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'Exenciones de bloqueos IP',
	'group-rollbacker' => 'Revertidores',
	'group-transwiki' => 'Importadores treswiki',
	'group-accountcreator-member' => 'creador de cuentes',
	'group-founder-member' => 'fundador',
	'group-import-member' => 'importador',
	'group-ipblock-exempt-member' => 'exentu de bloqueos IP',
	'group-rollbacker-member' => 'revertidor',
	'group-transwiki-member' => 'importador treswiki',
	'grouppage-accountcreator' => '{{ns:project}}:Creadores de cuentes',
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
	'group-Staff' => 'Personal',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'alministrador del sistema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'revertidor global',
	'group-Ombudsmen-member' => 'comisariu',
	'group-Staff-member' => 'Miembru del personal',
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
	'group-founder' => 'بنگیج کنوکان',
	'group-import' => 'وارد کنوکان',
	'group-ipblock-exempt' => 'معافیت محدودیت آی پی',
	'group-rollbacker' => 'عقب ترینوک',
	'group-transwiki' => 'واردکنوکان بین‌ویکی',
	'group-accountcreator-member' => 'حساب شرکنوک',
	'group-founder-member' => 'بنگیج کنوک',
	'group-import-member' => 'واردکنوک',
	'group-ipblock-exempt-member' => 'استثنای محدودیت آی پی',
	'group-rollbacker-member' => 'ترینوک',
	'group-transwiki-member' => 'واردکنوک بین‌ویکی',
	'grouppage-accountcreator' => '{{ns:project}}:حساب شرکنوکان',
	'grouppage-founder' => '{{ns:project}}:بنگیج کنوکان',
	'grouppage-import' => '{{ns:project}}:واردکنوکان',
	'grouppage-ipblock-exempt' => '{{ns:project}}:استثناء محدودیت آی پی',
	'grouppage-rollbacker' => '{{ns:project}}:واردکنوکان',
	'grouppage-transwiki' => '{{ns:project}}:واردکنوکان بین ویکی',
	'group-steward' => 'نگهبانان',
	'group-sysadmin' => 'مدیران سیستم',
	'group-Global_bot' => 'رباتان سراسری',
	'group-Global_rollback' => 'ترینوک سراسری',
	'group-Staff' => 'کارمند',
	'group-steward-member' => 'نگهبان',
	'group-sysadmin-member' => 'مدیر سیستم',
	'group-Global_bot-member' => 'ربات سراسری',
	'group-Global_rollback-member' => 'ترینوک سراسری',
	'group-Staff-member' => 'عضو کارمند',
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
	'group-autopatroller' => 'Аўтапатрулюемыя',
	'group-founder' => 'Фундатары',
	'group-import' => 'Імпартэры',
	'group-ipblock-exempt' => 'Выключэньні з блякаваньняў ІР-адрасоў',
	'group-rollbacker' => 'Адкатвальнікі',
	'group-transwiki' => 'Імпартэры зь іншых вікі',
	'group-uploader' => 'Загружальнікі',
	'group-bigexport' => 'Значныя экспарцёры',
	'group-abusefilter' => 'Рэдактары фільтру злоўжываньняў',
	'group-accountcreator-member' => 'стваральнік рахункаў',
	'group-autopatroller-member' => 'аўтапатрулюемыя',
	'group-founder-member' => 'фундатар',
	'group-import-member' => 'імпартэр',
	'group-ipblock-exempt-member' => 'выключэньне з блякаваньняў ІР-адрасоў',
	'group-rollbacker-member' => 'адкатвальнік',
	'group-transwiki-member' => 'імпартэр зь іншых вікі',
	'group-uploader-member' => 'загружальнік',
	'group-bigexport-member' => 'значныя экспарцёры',
	'group-abusefilter-member' => 'рэдактар фільтру злоўжываньняў',
	'grouppage-accountcreator' => '{{ns:project}}:Стваральнікі рахункаў',
	'grouppage-autopatroller' => '{{ns:project}}:Аўтапатрулюемыя',
	'grouppage-founder' => '{{ns:project}}:Фундатары',
	'grouppage-import' => '{{ns:project}}:Імпартэры',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Выключэньні з блякаваньняў ІР-адрасоў',
	'grouppage-rollbacker' => '{{ns:project}}:Адкатвальнікі',
	'grouppage-transwiki' => '{{ns:project}}:Імпартэры зь іншых вікі',
	'grouppage-uploader' => '{{ns:project}}:Загружальнікі',
	'grouppage-bigexport' => '{{ns:project}}:Значныя экспарцёры',
	'grouppage-abusefilter' => '{{ns:project}}:Рэдактары фільтру злоўжываньняў',
	'group-steward' => 'Сьцюарды',
	'group-sysadmin' => 'Сыстэмныя адміністратары',
	'group-Global_bot' => 'Глябальныя робаты',
	'group-Global_rollback' => 'Глябальныя адкатвальнікі',
	'group-Ombudsmen' => 'праваабаронцы',
	'group-Staff' => 'Супрацоўнікі',
	'group-steward-member' => 'сьцюард',
	'group-sysadmin-member' => 'сыстэмны адміністратар',
	'group-Global_bot-member' => 'глябальны робат',
	'group-Global_rollback-member' => 'глябальны адкатвальнік',
	'group-Ombudsmen-member' => 'праваабаронца',
	'group-Staff-member' => 'супрацоўнік',
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
	'group-founder' => 'Основатели',
	'group-founder-member' => 'Основател',
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
 * @author Abdullah Harun Jewel
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'wikimediamessages-desc' => 'উইকিমিডিয়া নির্ধারিত বার্তা',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'দান করুন',
	'tooltip-n-sitesupport' => 'আমাদের সহায়তা করুন',
	'group-accountcreator' => 'অ্যাকাউন্ট তৈরি করেন যারা',
	'group-autopatroller' => 'স্বয়ংক্রীয়-পর্যবেক্ষকবৃন্দ',
	'group-founder' => 'উদ্যোক্তা',
	'group-import' => 'আমদানীকারক',
	'group-ipblock-exempt' => 'আইপি নিষেধাজ্ঞা রহিতকরণ',
	'group-rollbacker' => 'রোলব্যাকারগণ',
	'group-transwiki' => 'ট্রান্সউইকি ইম্পোর্টারগণ',
	'group-uploader' => 'উত্তোলনকারীবৃন্দ
ওয়েব সার্ভারে ফাইল উত্তোলনকারী',
	'group-accountcreator-member' => 'অ্যাকাউন্ট তৈরি করেন যিনি',
	'group-autopatroller-member' => 'স্বয়ংক্রীয় পর্যবেক্ষক',
	'group-founder-member' => 'প্রতিষ্ঠাতা',
	'group-import-member' => 'ইম্পোর্টার',
	'group-ipblock-exempt-member' => 'আইপি নিষেধাজ্ঞা রহিত',
	'group-rollbacker-member' => 'রোলব্যাকার',
	'group-transwiki-member' => 'ট্রান্সউইকি ইম্পোর্টার',
	'group-uploader-member' => 'উত্তোলনকারী
<BR>যে সার্ভারে ফাইল উত্তোলন করে।',
	'grouppage-accountcreator' => '{{ns:প্রকল্প}}:হিসাব সৃষ্টিকারীগণ
<BR>যারা ব্যবহারকারী হিসাব তৈরী করে।',
	'grouppage-autopatroller' => '{{ns:প্রকল্প}}:স্বয়ংক্রীয় পর্যবেক্ষকগণ
<BR>যারা গোষ্ঠীসমূহের পৃষ্ঠাগুলো পর্যবেক্ষন করে।',
	'grouppage-founder' => '{{ns:project}}:প্রতিষ্ঠাতাগণ',
	'grouppage-import' => '{{ns:project}}:ইম্পোর্টারগণ',
	'grouppage-ipblock-exempt' => '{{ns:প্রকল্প}}:আইপি নিষেধাজ্ঞা রহিত',
	'grouppage-rollbacker' => '{{ns:project}}:রোলব্যাকার',
	'grouppage-transwiki' => '{{ns:প্রকল্প}}:ট্রান্সউইকি ইম্পোর্টারগণ',
	'grouppage-uploader' => '{{ns:প্রকল্প}}:উত্তোলনকারীগণ
<BR>যারা গোষ্ঠীর পৃষ্ঠাসমূহ সার্ভারে উত্তোলন করে।',
	'group-steward' => 'স্ট্যুয়ার্ডগণ',
	'group-sysadmin' => 'সিস্টেম প্রশাসকগণ',
	'group-Global_bot' => 'গ্লোবাল বটসমূহ',
	'group-Global_rollback' => 'গ্লোবাল রোলব্যাকারগণ',
	'group-Ombudsmen' => 'ন্যায়পাল',
	'group-steward-member' => 'স্টিউয়ার্ড',
	'group-sysadmin-member' => 'সিস্টেম প্রশাসক',
	'group-Global_bot-member' => 'গ্লোবাল বট',
	'group-Global_rollback-member' => 'গ্লোবাল রোলব্যাকার',
	'group-Ombudsmen-member' => 'ন্যায়পাল সদস্য',
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
	'group-founder' => 'Diazezourien',
	'group-import' => 'Enporzhier',
	'group-ipblock-exempt' => "Nemedennoù bloc'hadoù IP",
	'group-rollbacker' => 'Assaverien',
	'group-transwiki' => 'Enporzherien treuzwiki',
	'group-accountcreator-member' => 'Krouer kontoù',
	'group-founder-member' => 'Diazezer',
	'group-import-member' => 'Enporzhier',
	'group-ipblock-exempt-member' => "Nemedenn bloc'had IP",
	'group-rollbacker-member' => 'Assaver',
	'group-transwiki-member' => 'Enporzhier treuzwiki',
	'grouppage-accountcreator' => '{{ns:project}}: Krouerien kontoù',
	'grouppage-founder' => '{{ns:project}}:Diazezerien',
	'grouppage-import' => '{{ns:project}}:Enporzherien',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Nemedenn bloc'had IP",
	'grouppage-rollbacker' => '{{ns:project}}:Assaverien',
	'grouppage-transwiki' => '{{ns:project}}:Enporzherien treuzwiki',
	'group-sysadmin' => 'Merourien ar reizhiad',
	'group-Staff' => 'skipailh',
	'group-Staff-member' => 'Ezel eus ar skipailh',
	'group-coder' => 'Koderien',
	'group-coder-member' => 'koder',
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
	'group-founder' => 'Osnivači',
	'group-import' => 'Uvoznici',
	'group-ipblock-exempt' => 'Izuzeci IP blokada',
	'group-rollbacker' => 'Povratioci',
	'group-transwiki' => 'Transwiki uvoznici',
	'group-uploader' => 'Postavljači',
	'group-bigexport' => 'Veliki izvoznici',
	'group-abusefilter' => 'Uređivači filtera zloupotrebe',
	'group-accountcreator-member' => 'kreator računa',
	'group-autopatroller-member' => 'automatski patroler',
	'group-founder-member' => 'osnivač',
	'group-import-member' => 'uvoznik',
	'group-ipblock-exempt-member' => 'Izuzeci IP blokada',
	'group-rollbacker-member' => 'povratioc',
	'group-transwiki-member' => 'transwiki uvoznik',
	'group-uploader-member' => 'postavljač',
	'group-bigexport-member' => 'veliki izvoznik',
	'group-abusefilter-member' => 'uređivač filtera zloupotrebe',
	'grouppage-accountcreator' => '{{ns:project}}:Kreatori računa',
	'grouppage-autopatroller' => '{{ns:project}}:Automatski patroleri',
	'grouppage-founder' => '{{ns:project}}:Osnivači',
	'grouppage-import' => '{{ns:project}}:Uvoznici',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Izuzeci IP blokada',
	'grouppage-rollbacker' => '{{ns:project}}:Povratioci',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki uvoznici',
	'grouppage-uploader' => '{{ns:project}}:Postavljači',
	'grouppage-bigexport' => '{{ns:project}}:Veliki izvoznici',
	'grouppage-abusefilter' => '{{ns:project}}:Uređivači filtera zloupotrebe',
	'group-steward' => 'Stjuardi',
	'group-sysadmin' => 'Sistemski administratori',
	'group-Global_bot' => 'Globalni botovi',
	'group-Global_rollback' => 'Globalni povratioci',
	'group-Ombudsmen' => 'Ombudsmeni',
	'group-Staff' => 'Osoblje',
	'group-steward-member' => 'stujard',
	'group-sysadmin-member' => 'sistemski administrator',
	'group-Global_bot-member' => 'globalni bot',
	'group-Global_rollback-member' => 'globalni povratioc',
	'group-Ombudsmen-member' => 'ombudsmen',
	'group-Staff-member' => 'članovi osoblja',
	'grouppage-steward' => 'm:Stewards',
	'group-coder' => 'Koderi',
	'group-coder-member' => 'koder',
);

/** Catalan (Català)
 * @author Juanpabl
 * @author Martorell
 * @author Paucabot
 * @author SMP
 */
$messages['ca'] = array(
	'wikimediamessages-desc' => 'Missatges específics de Wikimedia',
	'sitesupport' => 'Donacions',
	'tooltip-n-sitesupport' => 'Ajudau-nos',
	'group-accountcreator' => 'Creadors de comptes',
	'group-founder' => 'Fundadors',
	'group-import' => 'Importadors',
	'group-ipblock-exempt' => "Exempts del bloqueig d'IP",
	'group-rollbacker' => 'Revertidors ràpids',
	'group-transwiki' => 'Importadors transwiki',
	'group-accountcreator-member' => 'Creador de comptes',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => "Exempt del bloqueig d'IP",
	'group-rollbacker-member' => 'Revertidor ràpid',
	'group-transwiki-member' => 'Importador transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Creadors de comptes',
	'grouppage-founder' => '{{ns:project}}:Fundadors',
	'grouppage-import' => '{{ns:project}}:Importadors',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Exempts del bloqueig d'IP",
	'grouppage-rollbacker' => '{{ns:project}}:Revertidors ràpids',
	'grouppage-transwiki' => '{{ns:project}}:Importadors transwiki',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradors del sistema',
	'group-Global_bot' => 'Bots globals',
	'group-Global_rollback' => 'Revertidors ràpids globals',
	'group-Ombudsmen' => 'Síndics de greuges',
	'group-Staff' => 'Personal',
	'group-steward-member' => 'Majordom',
	'group-sysadmin-member' => 'administrador del sistema',
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Revertidor ràpid global',
	'group-Ombudsmen-member' => 'síndic de greuges',
	'group-Staff-member' => 'Personal del wiki',
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
	'group-founder' => 'Zakladatelé',
	'group-import' => 'Importéři',
	'group-ipblock-exempt' => 'Nepodléhající blokování IP adres',
	'group-rollbacker' => 'Revertovatelé',
	'group-transwiki' => 'Transwiki importéři',
	'group-uploader' => 'Načítači souborů',
	'group-abusefilter' => 'Správci filtrů zneužívání',
	'group-accountcreator-member' => 'zakladatel účtů',
	'group-autopatroller-member' => 'strážce',
	'group-founder-member' => 'zakladatel',
	'group-import-member' => 'importér',
	'group-ipblock-exempt-member' => 'nepodléhající blokování IP adres',
	'group-rollbacker-member' => 'revertovatel',
	'group-transwiki-member' => 'transwiki importér',
	'group-uploader-member' => 'načítač souborů',
	'grouppage-accountcreator' => '{{ns:project}}:Zakladatelé účtů',
	'grouppage-autopatroller' => '{{ns:Project}}:Strážci',
	'grouppage-founder' => '{{ns:project}}:Zakladatelé',
	'grouppage-import' => '{{ns:project}}:Importéři',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Výjimky z blokování IP adres',
	'grouppage-rollbacker' => '{{ns:project}}:Revertovatelé',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importéři',
	'grouppage-uploader' => '{{ns:project}}:Načítači souborů',
	'grouppage-abusefilter' => '{{ns:Project}}:Správci filtrů zneužívání',
	'group-steward' => 'Stevardi',
	'group-sysadmin' => 'Správcové serveru',
	'group-Global_bot' => 'Globální boti',
	'group-Global_rollback' => 'Globální revertovatelé',
	'group-Ombudsmen' => 'Ombudsmani',
	'group-Staff' => 'Personál',
	'group-steward-member' => 'stevard',
	'group-sysadmin-member' => 'správce serveru',
	'group-Global_bot-member' => 'globální bot',
	'group-Global_rollback-member' => 'globální revertovatel',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'člen personálu',
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
	'wikimediamessages-desc' => 'Negeseuon neilltuol Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/cy',
	'sitesupport' => 'Rhoi arian',
	'tooltip-n-sitesupport' => "Ein cefnogi'n ariannol",
	'group-accountcreator' => 'Gwneuthurwyr cyfrifon',
	'group-founder' => 'Sefydlwyr',
	'group-import' => 'Mewnforwyr',
	'group-transwiki' => 'Mewnforwyr trawswici',
	'group-uploader' => 'Uwchlwythwyr',
	'group-accountcreator-member' => 'gwneuthurwr cyfrifon',
	'group-founder-member' => 'sefydlydd',
	'group-import-member' => 'mewnforwr',
	'group-transwiki-member' => 'mewnforwr trawswici',
	'group-uploader-member' => 'uwchlwythwr',
	'grouppage-accountcreator' => '{{ns:project}}:Gwneuthurwyr cyfrifon',
	'grouppage-founder' => '{{ns:project}}:Sefydlwyr',
	'grouppage-import' => '{{ns:project}}:Mewnforwyr',
	'grouppage-transwiki' => '{{ns:project}}:Mewnforwyr trawswici',
	'grouppage-uploader' => '{{ns:project}}:Uwchlwythwyr',
	'group-steward' => 'Stiwardiaid',
	'group-sysadmin' => 'Gweinyddwyr y system',
	'group-Global_bot' => 'Botiau wici-gyfan',
	'group-Ombudsmen' => 'Ombwdsmyn',
	'group-Staff' => "Aelodau o'r staff",
	'group-steward-member' => 'stiward',
	'group-sysadmin-member' => 'gweinyddwr y system',
	'group-Global_bot-member' => 'bot wici-gyfan',
	'group-Ombudsmen-member' => 'ombwdsmon',
	'group-Staff-member' => 'staff',
	'group-coder' => 'Codyddion',
	'group-coder-member' => 'codydd',
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
 * @author Umherirrender
 */
$messages['de'] = array(
	'wikimediamessages-desc' => 'Spezifische Systemnachrichten für Projekte der Wikimedia Foundation',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Spenden',
	'sitesupport' => 'Spenden',
	'tooltip-n-sitesupport' => 'Unterstütze uns',
	'group-accountcreator' => 'Benutzerkonten-Ersteller',
	'group-autopatroller' => 'Automatische Prüfer',
	'group-founder' => 'Gründer',
	'group-import' => 'Importeure',
	'group-ipblock-exempt' => 'IP-Sperre-Ausnahmen',
	'group-rollbacker' => 'Zurücksetzer',
	'group-transwiki' => 'Transwiki-Importeure',
	'group-uploader' => 'Hochlader',
	'group-bigexport' => 'Großexporteure',
	'group-abusefilter' => 'Missbrauchsfilter-Bearbeiter',
	'group-accountcreator-member' => 'Benutzerkonten-Ersteller',
	'group-autopatroller-member' => 'Automatischer Prüfer',
	'group-founder-member' => 'Gründer',
	'group-import-member' => 'Importeur',
	'group-ipblock-exempt-member' => 'IP-Sperre-Ausnahme',
	'group-rollbacker-member' => 'Zurücksetzer',
	'group-transwiki-member' => 'Transwiki-Importeur',
	'group-uploader-member' => 'Hochlader',
	'group-bigexport-member' => 'Großexporteur',
	'group-abusefilter-member' => 'Missbrauchsfilter-Bearbeiter',
	'grouppage-accountcreator' => '{{ns:project}}:Benutzerkonten-Ersteller',
	'grouppage-autopatroller' => '{{ns:project}}:Automatische Prüfer',
	'grouppage-founder' => '{{ns:project}}:Gründer',
	'grouppage-import' => '{{ns:project}}:Importeure',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Sperre-Ausnahme',
	'grouppage-rollbacker' => '{{ns:project}}:Zurücksetzer',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importeure',
	'grouppage-uploader' => '{{ns:project}}:Hochlader',
	'grouppage-bigexport' => '{{ns:project}}:Großexporteure',
	'grouppage-abusefilter' => '{{ns:project}}:Missbrauchsfilter-Bearbeiter',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Systemadministratoren',
	'group-Global_bot' => 'Globale Bots',
	'group-Global_rollback' => 'Globale Zurücksetzer',
	'group-Ombudsmen' => 'Ombudspersonen',
	'group-Staff' => 'Mitarbeiter',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Systemadministrator',
	'group-Global_bot-member' => 'Globaler Bot',
	'group-Global_rollback-member' => 'Globaler Zurücksetzer',
	'group-Ombudsmen-member' => 'Ombudsperson',
	'group-Staff-member' => 'Mitarbeiter',
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
	'group-Staff' => 'Emegdari',
	'group-Staff-member' => 'Emegdar',
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
	'group-founder' => 'Załožarje',
	'group-import' => 'Importery',
	'group-ipblock-exempt' => 'Wuwześe z blokěrowanja IP',
	'group-rollbacker' => 'Slědkstajarje',
	'group-transwiki' => 'Transwiki importery',
	'group-uploader' => 'Nagrawarje',
	'group-bigexport' => 'Wjelikoeksportery',
	'group-abusefilter' => 'Wobźěłarje znjewužywańskego filtra',
	'group-accountcreator-member' => 'kontowy załožaŕ',
	'group-autopatroller-member' => 'awtomatiski doglědowaŕ',
	'group-founder-member' => 'załožaŕ',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'Z blokěrowanja IP wuwzety',
	'group-rollbacker-member' => 'slědkstajaŕ',
	'group-transwiki-member' => 'transwiki importer',
	'group-uploader-member' => 'nagrawaŕ',
	'group-bigexport-member' => 'wjelikoeksporter',
	'group-abusefilter-member' => 'Wobźěłaŕ znjewužywańskego filtra',
	'grouppage-accountcreator' => '{{ns:project}}:Kontowe załožarje',
	'grouppage-autopatroller' => '{{ns:project}}:Automatiske doglědowarje',
	'grouppage-founder' => '{{ns:project}}:Załožarje',
	'grouppage-import' => '{{ns:project}}:Importery',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Wuwześe z blokěrowanja IP',
	'grouppage-rollbacker' => '{{ns:project}}:Slědkstajarje',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importery',
	'grouppage-uploader' => '{{ns:project}}:Nagrawarje',
	'grouppage-bigexport' => '{{ns:project}}:Wjelikoeksportery',
	'grouppage-abusefilter' => '{{ns:project}}:Wobźěłarje znjewužywańskego filtra',
	'group-steward' => 'Stewardy',
	'group-sysadmin' => 'Systemowe administratory',
	'group-Global_bot' => 'Globalne bośiki',
	'group-Global_rollback' => 'Globalne slědkstajarje',
	'group-Ombudsmen' => 'Ombudsniki',
	'group-Staff' => 'Sobuźěłaśerje',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemowy administrator',
	'group-Global_bot-member' => 'göobalny bośik',
	'group-Global_rollback-member' => 'globalny slědkstajaŕ',
	'group-Ombudsmen-member' => 'Ombudsnik',
	'group-Staff-member' => 'sobuźěłaśerje',
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
 * @author Dead3y3
 * @author Geraki
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'wikimediamessages-desc' => 'Μηνύματα ειδικά για το Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/el',
	'sitesupport' => 'Δωρεές',
	'tooltip-n-sitesupport' => 'Υποστηρίξτε μας',
	'group-accountcreator' => 'Δημιουργοί λογαριασμών',
	'group-autopatroller' => 'Αυτόματοι περίπολοι',
	'group-founder' => 'Ιδρυτές',
	'group-import' => 'Εισαγωγείς',
	'group-ipblock-exempt' => 'Απαλλαγές από φραγή IP',
	'group-rollbacker' => 'Αναιρέτες',
	'group-transwiki' => 'Εισαγωγείς Transwiki',
	'group-uploader' => 'Επιφορτωτές',
	'group-accountcreator-member' => 'δημιουργός λογαριασμού',
	'group-autopatroller-member' => 'αυτόματη περίπολος',
	'group-founder-member' => 'Ιδρυτής',
	'group-import-member' => 'εισαγωγέας',
	'group-ipblock-exempt-member' => 'απαλλαγή από φραγή IP',
	'group-rollbacker-member' => 'αναιρέτης',
	'group-transwiki-member' => 'εισαγωγέας transwiki',
	'group-uploader-member' => 'επιφορτωτής',
	'grouppage-accountcreator' => '{{ns:project}}:Δημιουργοί λογαριασμών',
	'grouppage-autopatroller' => '{{ns:project}}:Αυτόματοι περίπολοι',
	'grouppage-founder' => '{{ns:project}}:Ιδρυτές',
	'grouppage-import' => '{{ns:project}}:Εισαγωγείς',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Προνόμια αποκλεισμού των IP',
	'grouppage-rollbacker' => '{{ns:project}}:Αναιρέτες',
	'grouppage-transwiki' => '{{ns:project}}:Εισαγωγείς Transwiki',
	'grouppage-uploader' => '{{ns:project}}:Επιφορτωτές',
	'group-steward' => 'Επίτροποι',
	'group-sysadmin' => 'Διαχειριστές συστήματος',
	'group-Global_bot' => 'Καθολικά bots',
	'group-Global_rollback' => 'Καθολικοί rollbackers',
	'group-Ombudsmen' => 'Συνήγοροι του πολίτη',
	'group-Staff' => 'Προσωπικό',
	'group-steward-member' => 'επίτροπος',
	'group-sysadmin-member' => 'διαχειριστής συστήματος',
	'group-Global_bot-member' => 'καθολικό bot',
	'group-Global_rollback-member' => 'καθολικός rollbacker',
	'group-Ombudsmen-member' => 'συνήγορος του πολίτη',
	'group-Staff-member' => 'Μέλος προσωπικού',
	'group-coder' => 'Κωδικογράφοι',
	'group-coder-member' => 'κωδικογράφος',
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
	'group-founder' => 'Fondintoj',
	'group-import' => 'Importantoj',
	'group-ipblock-exempt' => 'Sendevigoj por IP-forbaroj',
	'group-rollbacker' => 'Restarigantoj',
	'group-transwiki' => 'Importintoj de Transvikio',
	'group-uploader' => 'Alŝutantoj',
	'group-bigexport' => 'Grandaj eksportantoj',
	'group-abusefilter' => 'Redaktantoj de misuzadaj filtriloj',
	'group-accountcreator-member' => 'Kreinto de konto',
	'group-autopatroller-member' => 'Aŭtomata patrolanto',
	'group-founder-member' => 'Fondinto',
	'group-import-member' => 'Importanto',
	'group-ipblock-exempt-member' => 'maldeviga de IP-forbaro',
	'group-rollbacker-member' => 'Restariganto',
	'group-transwiki-member' => 'Transvikia importanto',
	'group-uploader-member' => 'alŝutanto',
	'group-bigexport-member' => 'granda eksportanto',
	'group-abusefilter-member' => 'redaktanto de misuzadaj filtriloj',
	'grouppage-accountcreator' => '{{ns:project}}:Kreintoj de kontoj',
	'grouppage-autopatroller' => '{{ns:project}}:Aŭtomataj patrolantoj',
	'grouppage-founder' => '{{ns:project}}:Fondintoj',
	'grouppage-import' => '{{ns:project}}:Importantoj',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Sendevigo por IP-forbaro',
	'grouppage-rollbacker' => '{{ns:project}}:Restarigantoj',
	'grouppage-transwiki' => '{{ns:project}}:Transvikiaj importantoj',
	'grouppage-uploader' => '{{ns:project}}:Alŝutantoj',
	'grouppage-bigexport' => '{{ns:project}}:Grandaj eksportantoj',
	'grouppage-abusefilter' => '{{ns:project}}:Redaktantoj de misuzadaj filtriloj',
	'group-steward' => 'Stevardoj',
	'group-sysadmin' => 'Sistemaj administrantoj',
	'group-Global_bot' => 'Ĝeneralaj robotoj',
	'group-Global_rollback' => 'Transvikia restariganto',
	'group-Ombudsmen' => 'Arbitraciistoj',
	'group-Staff' => 'Dungitaro',
	'group-steward-member' => 'Stevardo',
	'group-sysadmin-member' => 'sistema administranto',
	'group-Global_bot-member' => 'Ĝenerala roboto',
	'group-Global_rollback-member' => 'transvikia restariganto',
	'group-Ombudsmen-member' => 'Arbitraciisto',
	'group-Staff-member' => 'dungito',
	'group-coder' => 'Programistoj',
	'group-coder-member' => 'programisto',
);

/** Spanish (Español)
 * @author Ascánder
 * @author Crazymadlover
 * @author Dferg
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
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'Dispensas de bloqueo IP',
	'group-rollbacker' => 'Reversores',
	'group-transwiki' => 'Importadores transwiki',
	'group-uploader' => 'Cargadores',
	'group-bigexport' => 'Grandes exportadores',
	'group-abusefilter' => 'Editores de filtro de abuso',
	'group-accountcreator-member' => 'creador de la cuenta',
	'group-autopatroller-member' => 'autopatrullero',
	'group-founder-member' => 'fundador',
	'group-import-member' => 'importador',
	'group-ipblock-exempt-member' => 'dispensa de bloqueo IP',
	'group-rollbacker-member' => 'Reversor',
	'group-transwiki-member' => 'Importador transwiki',
	'group-uploader-member' => 'cargador',
	'group-bigexport-member' => 'gran exportador',
	'group-abusefilter-member' => 'editor de filtro de abuso',
	'grouppage-accountcreator' => '{{ns:project}}:Creadores de cuentas',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrulleros',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Dispensa de bloqueo IP',
	'grouppage-rollbacker' => '{{ns:project}}:Reversores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargadores',
	'grouppage-bigexport' => '{{ns:project}}:Grandes exportadores',
	'grouppage-abusefilter' => '{{ns:project}}:Editores de filtro de abuso',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'administradores del sistema',
	'group-Global_bot' => 'bots globales',
	'group-Global_rollback' => 'Pueden deshacer globalmente',
	'group-Ombudsmen' => 'Defensores de la comunidad',
	'group-Staff' => 'Staff',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrador del sistema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'Puede deshacer globalmente',
	'group-Ombudsmen-member' => 'defensor de la comunidad',
	'group-Staff-member' => 'Miembro del staff',
	'group-coder' => 'Programadores',
	'group-coder-member' => 'programador',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author KalmerE.
 * @author WikedKentaur
 */
$messages['et'] = array(
	'wikimediamessages-desc' => 'Vikimeedia eri teadaanne',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Annetused',
	'sitesupport' => 'Annetused',
	'tooltip-n-sitesupport' => 'Toeta meid',
	'group-autopatroller' => 'Automaatsed patrullijad',
	'group-founder' => 'Asutajad',
	'group-import' => 'Importijad',
	'group-autopatroller-member' => 'automaatne patrullija',
	'group-founder-member' => 'asutaja',
	'group-import-member' => 'importija',
	'group-steward' => 'Stjuuardid',
	'group-sysadmin' => 'Süsteemiadministraatorid',
	'group-Global_bot' => 'Globaalsed robotid',
	'group-Staff' => 'Koosseis',
	'group-steward-member' => 'stjuuard',
	'group-sysadmin-member' => 'süsteemiadministraator',
	'group-Global_bot-member' => 'globaalne robot',
	'group-Staff-member' => 'koosseisu liige',
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
	'group-founder' => 'Fundatzaileak',
	'group-import' => 'Inportatzaileak',
	'group-ipblock-exempt' => 'IP blokeo salbuespenak',
	'group-rollbacker' => 'Desegin dezakete',
	'group-transwiki' => 'Transwiki inportatzaileak',
	'group-uploader' => 'Igo dezakete',
	'group-accountcreator-member' => 'kontu sortzaileak',
	'group-autopatroller-member' => 'autopatruilalaria',
	'group-founder-member' => 'fundatzailea',
	'group-import-member' => 'inportatzailea',
	'group-ipblock-exempt-member' => 'IP blokeo salbuespena',
	'group-rollbacker-member' => 'desegin dezake',
	'group-transwiki-member' => 'transwiki inportatzailea',
	'group-uploader-member' => 'igo dezake',
	'grouppage-accountcreator' => '{{ns:project}}:Kontu sortzaileak',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatruilariak',
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
	'group-Staff' => 'Langileak',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'sistemaren garatzaileak',
	'group-Global_bot-member' => 'bot globala',
	'group-Global_rollback-member' => 'globalki desegin dezakete',
	'group-Ombudsmen-member' => 'komunitatearen babeslea',
	'group-Staff-member' => 'langilea',
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
	'group-founder' => 'بنیان‌گذاران',
	'group-import' => 'واردکنندگان',
	'group-ipblock-exempt' => 'استثناهای قطع دسترسی نشانی اینترنتی',
	'group-rollbacker' => 'واگردانی‌کنندگان',
	'group-transwiki' => 'واردکنندگان تراویکی',
	'group-uploader' => 'بارگذارها',
	'group-accountcreator-member' => 'ایجادکنندهٔ حساب کاربری',
	'group-autopatroller-member' => 'گشت‌زن خودکار',
	'group-founder-member' => 'بنیان‌گذار',
	'group-import-member' => 'واردکننده',
	'group-ipblock-exempt-member' => 'استثنای قطع دسترسی نشانی اینترنتی',
	'group-rollbacker-member' => 'واگردانی‌کننده',
	'group-transwiki-member' => 'واردکنندهٔ تراویکی',
	'group-uploader-member' => 'بارگذار',
	'grouppage-accountcreator' => '{{ns:project}}:سازندگان حساب کاربری',
	'grouppage-autopatroller' => '{{ns:project}}:گشت‌زنان خودکار',
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
	'group-Staff' => 'پرسنل',
	'group-steward-member' => 'ویکیبد',
	'group-sysadmin-member' => 'مدیر سیستم',
	'group-Global_bot-member' => 'ربات سراسری',
	'group-Global_rollback-member' => 'واگردانی‌کنندهٔ سراسری',
	'group-Ombudsmen-member' => 'دادآور',
	'group-Staff-member' => 'عضو پرسنل',
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
	'group-founder' => 'perustajat',
	'group-import' => 'sivujen tuojat',
	'group-ipblock-exempt' => 'IP-estoista vapautetut',
	'group-rollbacker' => 'palauttajat',
	'group-transwiki' => 'toisesta wikistä sivujen tuojat',
	'group-uploader' => 'tiedostojen lähettäjät',
	'group-accountcreator-member' => 'käyttäjätunnusten luoja',
	'group-autopatroller-member' => 'automaattisesti tarkastava',
	'group-founder-member' => 'perustaja',
	'group-import-member' => 'sivujen tuoja',
	'group-ipblock-exempt-member' => 'IP-estosta vapautettu',
	'group-rollbacker-member' => 'palauttaja',
	'group-transwiki-member' => 'toisesta wikistä sivujen tuoja',
	'group-uploader-member' => 'tiedostojen lähettäjä',
	'grouppage-accountcreator' => '{{ns:project}}:Käyttäjätunnusten luojat',
	'grouppage-autopatroller' => '{{ns:project}}:Automaattisesti tarkastavat',
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
	'group-Staff' => 'projektin ylläpitäjät',
	'group-steward-member' => 'ylivalvoja',
	'group-sysadmin-member' => 'järjestelmän ylläpitäjä',
	'group-Global_bot-member' => 'globaalibotti',
	'group-Global_rollback-member' => 'globaalipalauttaja',
	'group-Ombudsmen-member' => 'edustaja',
	'group-Staff-member' => 'projektin ylläpitäjä',
	'grouppage-steward' => 'm:Stewards/fi',
	'group-coder' => 'ohjelmoijat',
	'group-coder-member' => 'ohjelmoija',
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
 * @author PieRRoMaN
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
	'group-founder' => 'Fondateurs',
	'group-import' => 'Importateurs',
	'group-ipblock-exempt' => 'Exemptions de blocs IP',
	'group-rollbacker' => 'Révocateurs',
	'group-transwiki' => 'Importateurs transwiki',
	'group-uploader' => 'Téléverseurs',
	'group-bigexport' => 'Grands exportateurs',
	'group-abusefilter' => 'Modificateurs de filtre antiabus',
	'group-accountcreator-member' => 'Créateur de comptes',
	'group-autopatroller-member' => 'Patrouilleur automatique',
	'group-founder-member' => 'Fondateur',
	'group-import-member' => 'Importateur',
	'group-ipblock-exempt-member' => "Exemption de blocage d'IP",
	'group-rollbacker-member' => 'Révocateur',
	'group-transwiki-member' => 'Importateur transwiki',
	'group-uploader-member' => 'Téléverseur',
	'group-bigexport-member' => 'grand exportateur',
	'group-abusefilter-member' => 'modificateur de filtre antiabus',
	'grouppage-accountcreator' => '{{ns:project}}:Créateurs de comptes',
	'grouppage-autopatroller' => '{{ns:project}}:Patrouilleurs automatiques',
	'grouppage-founder' => '{{ns:project}}:Fondateurs',
	'grouppage-import' => '{{ns:project}}:Importateurs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exemption de bloc IP',
	'grouppage-rollbacker' => '{{ns:project}}:Révocateurs',
	'grouppage-transwiki' => '{{ns:project}}:Importateurs transwiki',
	'grouppage-uploader' => '{{ns:project}}:Téléverseurs',
	'grouppage-bigexport' => '{{ns:project}}:Grands exportateurs',
	'grouppage-abusefilter' => '{{ns:project}}:Modificateurs de filtre antiabus',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administrateurs système',
	'group-Global_bot' => 'Bots globaux',
	'group-Global_rollback' => 'Révocateurs globaux',
	'group-Ombudsmen' => 'Médiateurs',
	'group-Staff' => 'Personnel',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Administrateur système',
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Révocateur global',
	'group-Ombudsmen-member' => 'Médiateur',
	'group-Staff-member' => 'Membre du personnel',
	'grouppage-steward' => 'm:Stewards/fr',
	'grouppage-Global_bot' => 'm:Bot policy/fr',
	'group-coder' => 'Codeurs',
	'group-coder-member' => 'Codeur',
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
	'group-founder' => 'Fondadôrs',
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
	'group-founder' => 'Bunaitheoirí',
	'group-import' => 'Iompórtálaithe',
	'group-ipblock-exempt' => 'Díolúintí coisc IP',
	'group-rollbacker' => 'Tar-rolltóirí',
	'group-transwiki' => 'Iompórtálaithe traisvicí',
	'group-uploader' => 'Uaslódóirí',
	'group-accountcreator-member' => 'cuntas cruthóir',
	'group-autopatroller-member' => 'uathphatrólóir',
	'group-founder-member' => 'bunaitheoir',
	'group-import-member' => 'iompórtálaí',
	'group-ipblock-exempt-member' => 'Díolúine coisc IP',
	'group-rollbacker-member' => 'tar-rolltóir',
	'group-transwiki-member' => 'iompórtálaí traisvicí',
	'group-uploader-member' => 'uaslódóir',
	'grouppage-accountcreator' => '{{ns:project}}:Cuntas cruthóirí',
	'grouppage-autopatroller' => '{{ns:project}}:Uathphatrólóirí',
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
	'group-Staff' => 'Foireann',
	'group-steward-member' => 'maor',
	'group-sysadmin-member' => 'riarthóir',
	'group-Global_bot-member' => 'róbó domhanda',
	'group-Global_rollback-member' => 'tar-rolltóir domhanda',
	'group-Ombudsmen-member' => 'Duine an Phobail',
	'group-Staff-member' => 'ball foirne',
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
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'Exención de bloqueo IP',
	'group-rollbacker' => 'Revertidores',
	'group-transwiki' => 'Importadores transwiki',
	'group-uploader' => 'Cargadores',
	'group-bigexport' => 'Grandes exportadores',
	'group-abusefilter' => 'Editores do filtro de abusos',
	'group-accountcreator-member' => 'Creador de contas',
	'group-autopatroller-member' => 'autopatrulla',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'Exento de bloqueo IP',
	'group-rollbacker-member' => 'Revertidor',
	'group-transwiki-member' => 'Importador transwiki',
	'group-uploader-member' => 'cargador',
	'group-bigexport-member' => 'gran exportador',
	'group-abusefilter-member' => 'editor do filtro de abusos',
	'grouppage-accountcreator' => '{{ns:project}}:Creadores de contas',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrullas',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exención de bloqueo IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revertidores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargadores',
	'grouppage-bigexport' => '{{ns:project}}:Grandes exportadores',
	'grouppage-abusefilter' => '{{ns:project}}:Editores do filtro de abusos',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradores do sistema',
	'group-Global_bot' => 'Bots globais',
	'group-Global_rollback' => 'Revertedores globais',
	'group-Ombudsmen' => 'Comisarios',
	'group-Staff' => 'Membros',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrador do sistema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'revertedor global',
	'group-Ombudsmen-member' => 'comisario',
	'group-Staff-member' => 'membro',
	'group-coder' => 'Codificadores',
	'group-coder-member' => 'codificador',
	'shared-repo-name-shared' => 'Wikimedia Commons',
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

/** Gothic (Gothic)
 * @author Jocke Pirat
 * @author LeighvsOptimvsMaximvs
 * @author Omnipaedista
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
	'group-founder' => 'Ἱδρυταί',
	'group-import' => 'Εἰσαγωγεῖς',
	'group-rollbacker' => 'Μεταστροφεῖς',
	'group-founder-member' => 'ἱδρυτής',
	'group-import-member' => 'εἰσαγωγεύς',
	'group-rollbacker-member' => 'μεταστροφεύς',
	'group-uploader-member' => 'ἐπιφορτιστής',
	'grouppage-autopatroller' => '{{ns:project}}:Αὐτόματοι περιποληταί',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Προνόμιον κλῄσεων IP',
	'grouppage-rollbacker' => '{{ns:project}}:Ἀπωθηταί',
	'grouppage-uploader' => '{{ns:project}}:Ἐπιφορτισταί',
	'group-steward' => 'Φροντισταί',
	'group-Global_bot' => 'Καθολικὰ αὐτόματα',
	'group-Global_rollback' => 'Καθολικοί μεταστροφεῖς',
	'group-Ombudsmen' => 'Δέκται διαμαρτυριῶν',
	'group-Staff' => 'Στελέχη',
	'group-steward-member' => 'φροντιστής',
	'group-sysadmin-member' => 'ἐπίτροπος συστήματος',
	'group-Global_bot-member' => 'καθολικὸν αὐτόματον',
	'group-Global_rollback-member' => 'καθολικὸς μεταστροφεύς',
	'group-Ombudsmen-member' => 'δέκτης διαμαρτυριῶν',
	'group-Staff-member' => 'στέλεχος',
	'group-coder' => 'Κωδικεύοντες',
	'group-coder-member' => 'κωδικεύς',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'wikimediamessages-desc' => 'Wikimediaspezifischi Syschtemnochrichte',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Spenden',
	'sitesupport' => 'Finanzielli Hilf',
	'tooltip-n-sitesupport' => 'Unterstitz is',
	'group-accountcreator' => 'Benutzerkonte-Aaleger',
	'group-autopatroller' => 'Automatischi Priefer',
	'group-founder' => 'Grinder',
	'group-import' => 'Importeur',
	'group-ipblock-exempt' => 'IP-Sperri-Usnahme',
	'group-rollbacker' => 'Zrucksetzer',
	'group-transwiki' => 'Transwiki-Importeur',
	'group-uploader' => 'Uffelader',
	'group-bigexport' => 'Großexporteur',
	'group-abusefilter' => 'Missbruuchsfilter-Bearbeiter',
	'group-accountcreator-member' => 'Benutzerkonte-Aaleger',
	'group-autopatroller-member' => 'Automatische Priefer',
	'group-founder-member' => 'Grinder',
	'group-import-member' => 'Importeur',
	'group-ipblock-exempt-member' => 'IP-Sperri-Usnahm',
	'group-rollbacker-member' => 'Zrucksetzer',
	'group-transwiki-member' => 'Transwiki-Importeur',
	'group-uploader-member' => 'Uffelader',
	'group-bigexport-member' => 'Großexporteur',
	'group-abusefilter-member' => 'Missbruuchsfilter-Bearbeiter',
	'grouppage-accountcreator' => '{{ns:project}}:Benutzerkonte-Aaleger',
	'grouppage-autopatroller' => '{{ns:project}}:Automatischi Priefer',
	'grouppage-founder' => '{{ns:project}}:Grinder',
	'grouppage-import' => '{{ns:project}}:Importeur',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Sperri-Usnahm',
	'grouppage-rollbacker' => '{{ns:project}}:Zrucksetzer',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importeur',
	'grouppage-uploader' => '{{ns:project}}:Uffelader',
	'grouppage-bigexport' => '{{ns:project}}:Großexporteur',
	'grouppage-abusefilter' => '{{ns:project}}:Missbruuchsfilter-Bearbeiter',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Syschtemadminischtratore',
	'group-Global_bot' => 'Wältwyti Bötli',
	'group-Global_rollback' => 'Wältwyti Zrucksetzer',
	'group-Ombudsmen' => 'Ombudsmanne',
	'group-Staff' => 'Mitarbeiter',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Syschtemadminischtrator',
	'group-Global_bot-member' => 'Wältwyt Bötli',
	'group-Global_rollback-member' => 'Wältwyte Zrucksetzer',
	'group-Ombudsmen-member' => 'Ombudsmann',
	'group-Staff-member' => 'Mitarbeiter',
	'group-coder' => 'Programmierer',
	'group-coder-member' => 'Programmierer',
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
	'group-Staff' => 'Fwirran',
	'group-Staff-member' => 'oltey fwirran',
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
	'group-founder' => 'מייסדים',
	'group-import' => 'מייבאים',
	'group-ipblock-exempt' => 'חסיני חסימות IP',
	'group-rollbacker' => 'משחזרים',
	'group-transwiki' => 'מייבאים בין־אתריים',
	'group-uploader' => 'מעלים',
	'group-bigexport' => 'מבצעי ייצוא גדול',
	'group-abusefilter' => 'עורכי מסנן ההשחתה',
	'group-accountcreator-member' => 'יוצר חשבונות',
	'group-autopatroller-member' => 'בודק עריכות אוטומטית',
	'group-founder-member' => 'מייסד',
	'group-import-member' => 'מייבא',
	'group-ipblock-exempt-member' => 'חסין חסימות IP',
	'group-rollbacker-member' => 'משחזר',
	'group-transwiki-member' => 'מייבא בין־אתרי',
	'group-uploader-member' => 'מעלה',
	'group-bigexport-member' => 'מבצע ייצוא גדול',
	'group-abusefilter-member' => 'עורך מסנן ההשחתה',
	'grouppage-accountcreator' => '{{ns:project}}:יוצר חשבונות',
	'grouppage-autopatroller' => '{{ns:project}}:בודק עריכות אוטומטית',
	'grouppage-founder' => '{{ns:project}}:מייסד',
	'grouppage-import' => '{{ns:project}}:מייבא',
	'grouppage-ipblock-exempt' => '{{ns:project}}:חסין חסימות IP',
	'grouppage-rollbacker' => '{{ns:project}}:משחזר',
	'grouppage-transwiki' => '{{ns:project}}:מייבא בין-אתרי',
	'grouppage-uploader' => '{{ns:project}}:מעלה',
	'grouppage-bigexport' => '{{ns:project}}:מבצע ייצוא גדול',
	'grouppage-abusefilter' => '{{ns:project}}:עורך מסנן ההשחתה',
	'group-steward' => 'דיילים',
	'group-sysadmin' => 'מנהלי מערכת',
	'group-Global_bot' => 'בוטים גלובליים',
	'group-Global_rollback' => 'משחזרים גלובליים',
	'group-Ombudsmen' => 'נציבי תלונות הציבור',
	'group-Staff' => 'אנשי צוות',
	'group-steward-member' => 'דייל',
	'group-sysadmin-member' => 'מנהל מערכת',
	'group-Global_bot-member' => 'בוט גלובלי',
	'group-Global_rollback-member' => 'משחזר גלובלי',
	'group-Ombudsmen-member' => 'נציב תלונות הציבור',
	'group-Staff-member' => 'איש צוות',
	'group-coder' => 'מתכנתים',
	'group-coder-member' => 'מתכנת',
	'shared-repo-name-shared' => 'ויקישיתוף',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author לערי ריינהארט
 */
$messages['hi'] = array(
	'sitesupport' => 'दान',
	'tooltip-n-sitesupport' => 'हमें सहायता दें',
	'group-Staff' => 'स्टाफ़',
	'group-Staff-member' => 'स्टाफ़ सदस्य',
);

/** Fiji Hindi (Latin) (Fiji Hindi (Latin))
 * @author Girmitya
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'wikimediamessages-desc' => 'Wikimedia specific sandes',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Daan',
	'tooltip-n-sitesupport' => 'Ham log ke sahara do',
	'group-accountcreator' => 'Account ke banae waala',
	'group-autopatroller' => 'Autopatrollers',
	'group-founder' => 'Founders',
	'group-import' => 'Importers',
	'group-ipblock-exempt' => 'IP block exemptions',
	'group-rollbacker' => 'Rollbackers',
	'group-transwiki' => 'Transwiki importers',
	'group-uploader' => 'Uploaders',
	'group-accountcreator-member' => 'account creator',
	'group-autopatroller-member' => 'autopatroller',
	'group-founder-member' => 'founder',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'IP block exempt',
	'group-rollbacker-member' => 'rollbacker',
	'group-transwiki-member' => 'transwiki importer',
	'group-uploader-member' => 'uploader',
	'grouppage-accountcreator' => '{{ns:project}}:Account creators',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-founder' => '{{ns:project}}:Founders',
	'grouppage-import' => '{{ns:project}}:Importers',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP block exemption',
	'grouppage-rollbacker' => '{{ns:project}}:Rollbackers',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importers',
	'grouppage-uploader' => '{{ns:project}}:Uploaders',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'System administrators',
	'group-Global_bot' => 'Global bots',
	'group-Global_rollback' => 'Global rollbackers',
	'group-Ombudsmen' => 'Ombudsmen',
	'group-Staff' => 'Message definition (Wikimedia Messages)Staffs',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'system administrator',
	'group-Global_bot-member' => 'global bot',
	'group-Global_rollback-member' => 'global rollbacker',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'staff',
	'group-coder' => 'Coders',
	'group-coder-member' => 'coder',
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
	'group-founder' => 'Osnivači',
	'group-import' => 'Unositelji',
	'group-ipblock-exempt' => 'IP blok iznimke',
	'group-rollbacker' => 'Uklonitelji',
	'group-transwiki' => 'Međuwiki unositelji',
	'group-uploader' => 'Postavljači',
	'group-accountcreator-member' => 'otvaratelj računa',
	'group-autopatroller-member' => 'Automatski patroliran',
	'group-founder-member' => 'osnivač',
	'group-import-member' => 'unositelj',
	'group-ipblock-exempt-member' => 'IP blok iznimka',
	'group-rollbacker-member' => 'uklonitelj',
	'group-transwiki-member' => 'međuwiki unositelj',
	'group-uploader-member' => 'postavljač',
	'grouppage-accountcreator' => '{{ns:project}}:Otvaratelji računa',
	'grouppage-autopatroller' => '{{ns:project}}:Automatski patrolirani',
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
	'group-Ombudsmen' => 'Ombudsman',
	'group-Staff' => 'Osoblje',
	'group-steward-member' => 'Stjuard',
	'group-sysadmin-member' => 'sistem administrator',
	'group-Global_bot-member' => 'globalni bot',
	'group-Global_rollback-member' => 'globalni uklonitelj',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'Član osoblja',
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
	'group-founder' => 'Załožerjo',
	'group-import' => 'Importerojo',
	'group-ipblock-exempt' => 'Wuwzaća z blokowanja IP',
	'group-rollbacker' => 'Wróćostajerjo',
	'group-transwiki' => 'Transwiki importerojo',
	'group-uploader' => 'Nahrawarjo',
	'group-bigexport' => 'Wulkowuwožowarjo',
	'group-abusefilter' => 'Wobdźěłarjo za znjewužiwanske filtry',
	'group-accountcreator-member' => 'Kontowe załožer',
	'group-autopatroller-member' => 'awtomatiski dohladowar',
	'group-founder-member' => 'załožer',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'Z blokowanja IP wuwzaty',
	'group-rollbacker-member' => 'wróćostajer',
	'group-transwiki-member' => 'transwiki importer',
	'group-uploader-member' => 'nahrawar',
	'group-bigexport-member' => 'wulkowuwožowar',
	'group-abusefilter-member' => 'wobdźěłar za znjewužiwanski filter',
	'grouppage-accountcreator' => '{{ns:project}}:Kontowi załožerjo',
	'grouppage-autopatroller' => '{{ns:project}}:Awtomatiscy dohladowarjo',
	'grouppage-founder' => '{{ns:project}}:Załožerjo',
	'grouppage-import' => '{{ns:project}}:Importerojo',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Wuwzaće z blokowanja IP',
	'grouppage-rollbacker' => '{{ns:project}}:Wróćostajerjo',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importerojo',
	'grouppage-uploader' => '{{ns:project}}:Nahrawarjo',
	'grouppage-bigexport' => '{{ns:project}}:Wulkowuwožowarjo',
	'grouppage-abusefilter' => '{{ns:project}}:Wobdźěłarjo za njewužiwanske filtry',
	'group-steward' => 'Stewardźa',
	'group-sysadmin' => 'Systemowi administratorojo',
	'group-Global_bot' => 'Globalne boćiki',
	'group-Global_rollback' => 'Globalni wróćostajerjo',
	'group-Ombudsmen' => 'Ombudsnicy',
	'group-Staff' => 'Sobudźěłaćerjo',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemowy administrator',
	'group-Global_bot-member' => 'globalny boćik',
	'group-Global_rollback-member' => 'globalny wróćostajer',
	'group-Ombudsmen-member' => 'ombudsnik',
	'group-Staff-member' => 'sobudźěłaćerjo',
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
 * @author Tgr
 */
$messages['hu'] = array(
	'wikimediamessages-desc' => 'Wikimedia-specifikus üzenetek',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/hu',
	'sitesupport' => 'Adományok',
	'tooltip-n-sitesupport' => 'Támogatás',
	'group-accountcreator' => 'fióklétrehozók',
	'group-autopatroller' => 'automatikus járőrök',
	'group-founder' => 'alapítók',
	'group-import' => 'importálók',
	'group-ipblock-exempt' => 'IP-blokkok alól mentesülők',
	'group-rollbacker' => 'visszaállítók',
	'group-transwiki' => 'wikiközi importálók',
	'group-uploader' => 'feltöltők',
	'group-accountcreator-member' => 'fióklétrehozó',
	'group-autopatroller-member' => 'automatikus járőr',
	'group-founder-member' => 'alapító',
	'group-import-member' => 'importáló',
	'group-ipblock-exempt-member' => 'IP-blokkok alól mentesülő',
	'group-rollbacker-member' => 'visszaállító',
	'group-transwiki-member' => 'wikiközi importáló',
	'group-uploader-member' => 'feltöltő',
	'grouppage-accountcreator' => '{{ns:project}}:Fióklétrehozók',
	'grouppage-autopatroller' => '{{ns:project}}:Automatikus járőrök',
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
	'group-Staff' => 'személyzet',
	'group-steward-member' => 'helytartó',
	'group-sysadmin-member' => 'rendszeradminisztrátor',
	'group-Global_bot-member' => 'globális bot',
	'group-Global_rollback-member' => 'globális visszaállító',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'személyzeti tag',
	'grouppage-steward' => '{{ns:project}}:Helytartók',
	'group-coder' => 'programozók',
	'group-coder-member' => 'programozó',
	'shared-repo-name-shared' => 'Wikimedia Commons',
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
	'group-founder' => 'Fundatores',
	'group-import' => 'Importatores',
	'group-ipblock-exempt' => 'Exemptiones de blocos IP',
	'group-rollbacker' => 'Revertitores',
	'group-transwiki' => 'Importatores transwiki',
	'group-uploader' => 'Cargatores',
	'group-bigexport' => 'Grande exportatores',
	'group-abusefilter' => 'Modificatores del filtros anti-abuso',
	'group-accountcreator-member' => 'Creator de contos',
	'group-autopatroller-member' => 'autopatruliator',
	'group-founder-member' => 'Fundator',
	'group-import-member' => 'Importator',
	'group-ipblock-exempt-member' => 'Exemption de bloco IP',
	'group-rollbacker-member' => 'Revertitor',
	'group-transwiki-member' => 'Importator transwiki',
	'group-uploader-member' => 'cargator',
	'group-bigexport-member' => 'grande exportator',
	'group-abusefilter-member' => 'modificator del filtros anti-abuso',
	'grouppage-accountcreator' => '{{ns:project}}:Creatores de contos',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatruliatores',
	'grouppage-founder' => '{{ns:project}}:Fundatores',
	'grouppage-import' => '{{ns:project}}:Importatores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exemption de blocos IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revertitores',
	'grouppage-transwiki' => '{{ns:project}}:Importatores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Cargatores',
	'grouppage-bigexport' => '{{ns:project}}:Grande exportatores',
	'grouppage-abusefilter' => '{{ns:project}}:Modificatores del filtros anti-abuso',
	'group-steward' => 'Stewardes',
	'group-sysadmin' => 'Administratores de systema',
	'group-Global_bot' => 'Bots global',
	'group-Global_rollback' => 'Revocatores global',
	'group-Ombudsmen' => 'Mediatores',
	'group-Staff' => 'Personal',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrator de systema',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'revocator global',
	'group-Ombudsmen-member' => 'mediator',
	'group-Staff-member' => 'Membro del personal',
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
	'group-founder' => 'Pendiri',
	'group-import' => 'Importir',
	'group-ipblock-exempt' => 'Pengecualian pemblokiran IP',
	'group-rollbacker' => 'Pengembali revisi',
	'group-transwiki' => 'Importir transwiki',
	'group-accountcreator-member' => 'Pembuat akun',
	'group-founder-member' => 'Pendiri',
	'group-import-member' => 'Importir',
	'group-ipblock-exempt-member' => 'Pengecualian pemblokiran IP',
	'group-rollbacker-member' => 'Pengembali revisi',
	'group-transwiki-member' => 'Importir transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Pembuat akun',
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
	'group-Staff' => 'Staf',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrator sistem',
	'group-Global_bot-member' => 'Bot global',
	'group-Global_rollback-member' => 'Pengembali revisi global',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-Staff-member' => 'Anggota staf',
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
	'group-accountcreator' => 'Konto-kreanti',
	'group-uploader' => 'Adkarganti',
	'group-uploader-member' => 'adkarganto',
	'grouppage-uploader' => '{{ns:project}}:Adkarganti',
	'group-sysadmin' => 'Sistemo-administranti',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 * @author לערי ריינהארט
 */
$messages['is'] = array(
	'sitesupport' => 'Fjárframlög',
	'tooltip-n-sitesupport' => 'Fjárframlagssíða',
	'group-Staff' => 'Starfsfólk',
	'group-Staff-member' => 'Starfsmaður',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Brownout
 * @author Darth Kule
 * @author Melos
 * @author Pietrodn
 */
$messages['it'] = array(
	'wikimediamessages-desc' => 'Messaggi specifici di Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donazioni',
	'sitesupport' => 'Donazioni',
	'tooltip-n-sitesupport' => 'Sostienici',
	'group-accountcreator' => 'Creatori di account',
	'group-autopatroller' => 'Autopatroller',
	'group-founder' => 'Fondatori',
	'group-import' => 'Importatori',
	'group-ipblock-exempt' => 'esente dal blocco IP',
	'group-rollbacker' => 'Rollbacker',
	'group-transwiki' => 'Importatori transwiki',
	'group-uploader' => 'Uploader',
	'group-bigexport' => 'Esportatori in blocco',
	'group-abusefilter' => 'Gestori filtri anti abusi',
	'group-accountcreator-member' => 'creatore di account',
	'group-autopatroller-member' => 'autopatroller',
	'group-founder-member' => 'fondatore',
	'group-import-member' => 'importatore',
	'group-ipblock-exempt-member' => 'esente dal blocco IP',
	'group-rollbacker-member' => 'rollbacker',
	'group-transwiki-member' => 'importatore transwiki',
	'group-uploader-member' => 'uploader',
	'group-bigexport-member' => 'esportatore in blocco',
	'group-abusefilter-member' => 'gestore filtri anti abusi',
	'grouppage-accountcreator' => '{{ns:project}}:Creatori di account',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatroller',
	'grouppage-founder' => '{{ns:project}}:Founders',
	'grouppage-import' => '{{ns:project}}:Importatori',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Esenti dal blocco IP',
	'grouppage-rollbacker' => '{{ns:project}}:Rollbackers',
	'grouppage-transwiki' => '{{ns:project}}:Importatori transwiki',
	'grouppage-uploader' => '{{ns:project}}:Uploader',
	'grouppage-bigexport' => '{{ns:project}}:Esportatori in blocco',
	'grouppage-abusefilter' => '{{ns:project}}:Gestori filtri anti abusi',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Amministratori di sistema',
	'group-Global_bot' => 'Bot globali',
	'group-Global_rollback' => 'Rollbacker globali',
	'group-Ombudsmen' => 'Ombudsmen',
	'group-Staff' => 'Staff',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'amministratore di sistema',
	'group-Global_bot-member' => 'bot globale',
	'group-Global_rollback-member' => 'rollbacker globale',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'Membro dello staff',
	'grouppage-steward' => 'm:Stewards/it',
	'grouppage-Global_rollback' => 'm:Global rollback/it',
	'group-coder' => 'Coder',
	'group-coder-member' => 'coder',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
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
	'group-founder' => '創設者',
	'group-import' => 'インポート権限保持者',
	'group-ipblock-exempt' => 'IPブロック適用除外',
	'group-rollbacker' => 'ロールバック権限保持者',
	'group-transwiki' => 'トランスウィキ・インポート権限保持者',
	'group-uploader' => 'アップロード権限保持者',
	'group-bigexport' => '大規模エクスポート権限保持者',
	'group-abusefilter' => '不正利用フィルター編集者',
	'group-accountcreator-member' => 'アカウント作成権限保持者',
	'group-autopatroller-member' => 'オートパトローラー',
	'group-founder-member' => '創設者',
	'group-import-member' => 'インポート権限保持者',
	'group-ipblock-exempt-member' => 'IPブロック適用除外',
	'group-rollbacker-member' => 'ロールバック権限保持者',
	'group-transwiki-member' => 'トランスウィキ・インポート権限保持者',
	'group-uploader-member' => 'アップロード権限保持者',
	'group-bigexport-member' => '大規模エクスポート権限保持者',
	'group-abusefilter-member' => '不正利用フィルター編集者',
	'grouppage-accountcreator' => '{{ns:project}}:アカウント作成権限保持者',
	'grouppage-autopatroller' => '{{ns:project}}:オートパトローラー',
	'grouppage-founder' => '{{ns:project}}:創設者',
	'grouppage-import' => '{{ns:project}}:インポート権限保持者',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IPブロック適用除外',
	'grouppage-rollbacker' => '{{ns:project}}:ロールバック権限保持者',
	'grouppage-transwiki' => '{{ns:project}}:トランスウィキ・インポート権限保持者',
	'grouppage-uploader' => '{{ns:project}}:アップロード権限保持者',
	'grouppage-bigexport' => '{{ns:project}}:大規模エクスポート権限保持者',
	'grouppage-abusefilter' => '{{ns:project}}:不正利用フィルター編集者',
	'group-steward' => 'スチュワード',
	'group-sysadmin' => 'システム管理者',
	'group-Global_bot' => 'グローバル・ボット',
	'group-Global_rollback' => 'グローバル・ロールバック権限保持者',
	'group-Ombudsmen' => 'オンブズマン',
	'group-Staff' => 'スタッフ',
	'group-steward-member' => '{{int:group-steward}}',
	'group-sysadmin-member' => 'システム管理者',
	'group-Global_bot-member' => 'グローバル・ボット',
	'group-Global_rollback-member' => 'グローバル・ロールバック権限保持者',
	'group-Ombudsmen-member' => 'オンブズマン',
	'group-Staff-member' => 'スタッフ',
	'grouppage-steward' => 'm:Stewards/ja',
	'group-coder' => 'コーダー',
	'group-coder-member' => 'コーダー',
	'shared-repo-name-shared' => 'ウィキメディア・コモンズ',
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
	'group-founder' => 'Pendhiri',
	'group-import' => 'Importir',
	'group-ipblock-exempt' => 'Pambébasan saka pamblokiran IP',
	'group-rollbacker' => 'Sing mbalèkaké révisi',
	'group-transwiki' => 'Importir transwiki',
	'group-uploader' => 'Pamunggah',
	'group-accountcreator-member' => 'Sing gawé akun',
	'group-founder-member' => 'Pandhiri',
	'group-import-member' => 'importir',
	'group-ipblock-exempt-member' => 'Pambébasan saka pamblokiran IP',
	'group-rollbacker-member' => 'Sing mbalèkaké révisi',
	'group-transwiki-member' => 'importir transwiki',
	'group-uploader-member' => 'pamunggah',
	'grouppage-accountcreator' => '{{ns:project}}:Sing gawé akun',
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
 * @author Malafaya
 * @author Sopho
 * @author Temuri rajavi
 * @author לערי ריינהארט
 */
$messages['ka'] = array(
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/ka',
	'sitesupport' => 'შეწირულობები',
	'tooltip-n-sitesupport' => 'მხარდაჭერა',
	'group-founder' => 'დამაარსებლები',
	'group-founder-member' => 'დამაარსებელი',
	'grouppage-founder' => '{{ns:project}}:დამაარსებლები',
	'group-steward' => 'სტიუარდები',
	'group-steward-member' => 'სტიუარდი',
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
 * @author Berkus Tiwal
 */
$messages['kab'] = array(
	'wikimediamessages-desc' => 'Iznan usligen n Wikimedia',
	'sitesupport' => 'Efk-aɣ idrimen',
	'tooltip-n-sitesupport' => 'Ellil-aɣ',
	'group-accountcreator' => 'Imeskaren n imiḍanen',
	'group-founder' => 'Imeskar imenza',
	'grouppage-founder' => '{{ns:project}}:Imeskar Imenza',
	'group-Staff-member' => 'Amaslad (membre) n terbaεt',
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
	'group-import' => 'Сырттан алушылар',
	'group-import-member' => 'сырттан алушы',
	'group-sysadmin' => 'Жүйе әкімшілері',
	'group-Staff' => 'Басқарма',
	'group-sysadmin-member' => 'жүйе әкімшісі',
	'group-Staff-member' => 'Басқарма мүшесі',
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
	'group-founder' => 'ស្ថាបនិក',
	'group-import' => 'អ្នកនាំចូល',
	'group-transwiki' => 'អ្នកនាំចូលអន្តរវិគី',
	'group-uploader' => 'អ្នក​ផ្ទុកឯកសារឡើង',
	'group-accountcreator-member' => 'អ្នកបង្កើតគណនី',
	'group-autopatroller-member' => 'អ្នកល្បាត​ស្វ័យប្រវត្តិ',
	'group-founder-member' => 'ស្ថាបនិក',
	'group-import-member' => 'អ្នកនាំចូល',
	'group-transwiki-member' => 'អ្នកនាំចូលអន្តរវិគី',
	'group-uploader-member' => 'អ្នក​ផ្ទុកឯកសារឡើង',
	'grouppage-accountcreator' => '{{ns:project}}:អ្នកបង្កើតគណនី',
	'grouppage-autopatroller' => '{{ns:project}}:អ្នកល្បាត​ស្វ័យប្រវត្តិ',
	'grouppage-founder' => '{{ns:project}}:ស្ថាបនិក',
	'grouppage-import' => '{{ns:project}}:អ្នកនាំចូល',
	'grouppage-transwiki' => '{{ns:project}}:អ្នកនាំចូលអន្តរវិគី',
	'grouppage-uploader' => '{{ns:project}}:អ្នក​ផ្ទុកឯកសារឡើង',
	'group-sysadmin' => 'អ្នកអភិបាលប្រព័ន្ឋ',
	'group-Global_bot' => 'រូបយន្ត​សកល',
	'group-Ombudsmen' => 'អមប៊ុដហ្ស៍ម៉ឹន',
	'group-Staff' => 'បុគ្គលិកបម្រើការ',
	'group-sysadmin-member' => 'អ្នកអភិបាលប្រព័ន្ឋ',
	'group-Global_bot-member' => 'រូបយន្ត​សកល',
	'group-Ombudsmen-member' => 'អមប៊ុដហ្ស៍ម៉ឹន',
	'group-Staff-member' => 'សមាជិកដែលជាបុគ្គលិកបម្រើការ',
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
 * @author Ilovesabbath
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'wikimediamessages-desc' => '위키미디어 전용 메시지',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/ko',
	'sitesupport' => '기부 안내',
	'tooltip-n-sitesupport' => '지원을 기다립니다',
	'group-accountcreator' => '계정 생성자',
	'group-autopatroller' => '자동순찰자',
	'group-founder' => '설립자',
	'group-ipblock-exempt' => 'IP 차단 면제자',
	'group-rollbacker' => '롤배커',
	'group-accountcreator-member' => '계정 생성자',
	'group-autopatroller-member' => '자동순찰자',
	'group-founder-member' => '설립자',
	'group-ipblock-exempt-member' => 'IP 차단 면제자',
	'grouppage-autopatroller' => '{{ns:project}}:자동순찰자',
	'grouppage-founder' => '{{ns:project}}:설립자',
	'group-steward' => '사무장',
	'group-sysadmin' => '시스템 관리자',
	'group-Global_bot' => '글로벌 봇',
	'group-Global_rollback' => '글로벌 롤배커',
	'group-Ombudsmen' => '옴부즈맨',
	'group-Staff' => '직원',
	'group-steward-member' => '사무장',
	'group-sysadmin-member' => '시스템 관리자',
	'group-Global_bot-member' => '글로벌 봇',
	'group-Global_rollback-member' => '글로벌 롤배커',
	'group-Ombudsmen-member' => '옴부즈맨',
	'group-Staff-member' => '임원',
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
	'group-founder' => 'Jröndere',
	'group-import' => 'Emportöre',
	'group-ipblock-exempt' => 'IP-Jruppe-Sperre-Ußnahme',
	'group-rollbacker' => 'Zeröcknemmere',
	'group-transwiki' => 'Transwiki-Emportöre',
	'group-uploader' => 'Huhlaader',
	'group-bigexport' => 'Jroß-Expotöre',
	'group-abusefilter' => 'Meßbruchsfelter-Baaß',
	'group-accountcreator-member' => 'Metmaacher-Maacher',
	'group-autopatroller-member' => 'Sellver-Nohloorer',
	'group-founder-member' => 'Jrönder',
	'group-import-member' => 'Emportör',
	'group-ipblock-exempt-member' => 'IP-Jruppe-Sperre-Ußnahm',
	'group-rollbacker-member' => 'Zeröcknemmer',
	'group-transwiki-member' => 'Transwiki-Emportör',
	'group-uploader-member' => 'Huhlaader',
	'group-bigexport-member' => 'Jroß-Expotör',
	'group-abusefilter-member' => 'Meßbruchsfelter-Baaß',
	'grouppage-accountcreator' => '{{ns:project}}:Metmaacher-Maacher',
	'grouppage-autopatroller' => '{{ns:project}}:Sellver-Nohloorer',
	'grouppage-founder' => '{{ns:project}}:Jrönder',
	'grouppage-import' => '{{ns:project}}:Emportör',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Jruppe-Sperre-Ußnahm',
	'grouppage-rollbacker' => '{{ns:project}}:Zeröcknemmer',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Emportör',
	'grouppage-uploader' => '{{ns:project}}:Huhlaader',
	'grouppage-bigexport' => '{{ns:project}}:Jroß-Expotöre',
	'grouppage-abusefilter' => '{{ns:project}}:Meßbruchsfelter-Baaß',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Wiki-Köbesse',
	'group-Global_bot' => 'Bots för all Wikis',
	'group-Global_rollback' => 'Zeröcknämmere för all Wikis',
	'group-Ombudsmen' => 'Vermeddeler',
	'group-Staff' => 'Päsonaal',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Wiki-Köbes',
	'group-Global_bot-member' => 'Bot för all Wikis',
	'group-Global_rollback-member' => 'Zeröcknämmer för all Wikis',
	'group-Ombudsmen-member' => 'Vermeddeler',
	'group-Staff-member' => 'Päsonaal',
	'group-coder' => 'Projrammierer',
	'group-coder-member' => 'Projrammierer',
	'grouppage-coder' => 'Project:Projrammierer',
	'shared-repo-name-shared' => '<i lang="en">Wikimedia Commons</i>',
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
	'group-rollbacker' => 'Revertores',
	'group-rollbacker-member' => 'revertor',
	'grouppage-rollbacker' => '{{ns:project}}:Revertores',
	'shared-repo-name-shared' => 'Vicimedia Communia',
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
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/lb',
	'sitesupport' => 'Donatiounen',
	'tooltip-n-sitesupport' => 'Ënnerstetzt eis',
	'group-accountcreator' => 'Benotzer déi Benotzerkonten uleeën däerfen',
	'group-founder' => 'Grënner',
	'group-import' => 'Importateuren',
	'group-ipblock-exempt' => 'Ausnahme vun IP-Spären',
	'group-rollbacker' => 'Zrécksetzer',
	'group-transwiki' => 'Transwiki-Importateuren',
	'group-uploader' => 'Eroplueder',
	'group-accountcreator-member' => 'Benotzer dee Benotzerkonten uleeën däerf',
	'group-founder-member' => 'Grënner',
	'group-import-member' => 'Importateur',
	'group-ipblock-exempt-member' => 'Ausnam vun der IP-Spär',
	'group-rollbacker-member' => 'Zrécksetzer',
	'group-transwiki-member' => 'Transwiki-Importateur',
	'group-uploader-member' => 'Eroplueder',
	'group-bigexport-member' => 'groussen Exportateur',
	'grouppage-accountcreator' => '{{ns:project}}:Benotzer déi Benotzerkonten uleeën däerfen',
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
	'group-Staff' => 'Mataarbechter',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Systemadministrateur',
	'group-Global_bot-member' => 'Globale Bot',
	'group-Global_rollback-member' => 'Globalen Zrécksetzer',
	'group-Ombudsmen-member' => 'Ombudsmann',
	'group-Staff-member' => 'Mataarbechter',
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
	'group-autopatroller' => 'autopatrollers',
	'group-founder' => 'Gróndlègkers',
	'group-import' => 'Importäörs',
	'group-ipblock-exempt' => 'Oetgezongerde van IP-adres blokkades',
	'group-rollbacker' => 'Trökdriejers',
	'group-transwiki' => 'Transwikiimportäörs',
	'group-uploader' => 'óplaajers',
	'group-bigexport' => 'groeate exportäörs',
	'group-abusefilter' => 'misbroekfilterredaktäörs',
	'group-accountcreator-member' => 'Gebroekeraanmaker',
	'group-autopatroller-member' => 'autopatroller',
	'group-founder-member' => 'Gróndlègker',
	'group-import-member' => 'Importäör',
	'group-ipblock-exempt-member' => 'Oetgenómmene van IP-adresblokkades',
	'group-rollbacker-member' => 'Trökdriejer',
	'group-transwiki-member' => 'Transwikiimportäör',
	'group-uploader-member' => 'óplaajer',
	'group-bigexport-member' => 'groeaten exportäör',
	'group-abusefilter-member' => 'misbroekfilterredaktäör',
	'grouppage-accountcreator' => '{{ns:project}}:Gebroekeraanmakers',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-founder' => '{{ns:project}}:Gróndlègkers',
	'grouppage-import' => '{{ns:project}}:Importäörs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Oetgezongerde van IP-adresblokkades',
	'grouppage-rollbacker' => '{{ns:project}}:Trökdriejers',
	'grouppage-transwiki' => '{{ns:project}}:Transwikiimportäörs',
	'grouppage-uploader' => '{{ns:project}}:Óplaajers',
	'grouppage-bigexport' => '{{ns:project}}:Groeate exportäör',
	'grouppage-abusefilter' => '{{ns:project}}:Misbroekfilterredaktäör',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'systeemwèrkers',
	'group-Global_bot' => 'Globaal bots',
	'group-Global_rollback' => 'Globaal trökdriejers',
	'group-Ombudsmen' => 'Ombudsmen',
	'group-Staff' => 'Li-jjing',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'systeemwèrker',
	'group-Global_bot-member' => 'Globale bot',
	'group-Global_rollback-member' => 'Globale trökdriejer',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-Staff-member' => 'Li-jjer',
	'grouppage-steward' => '{{ns:project}}:Stewards',
	'group-coder' => 'koeajers',
	'group-coder-member' => 'koeajer',
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
	'group-Staff' => 'ພະນັກງານ',
	'group-Staff-member' => 'ພະນັກງານ',
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
	'group-Staff' => 'Darbuotojai',
	'group-Staff-member' => 'Darbuotojas',
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

/** Literary Chinese (文言) */
$messages['lzh'] = array(
	'wikimediamessages-desc' => '維基媒體特集',
	'sitesupport' => '捐助集',
	'tooltip-n-sitesupport' => '濟資財、施續命、傳美皓',
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
	'group-Staff' => 'Персонал',
	'group-Staff-member' => 'Персоналста ломань',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'wikimediamessages-desc' => 'Afatra manokana ny Wikimedia',
	'sitesupport' => 'Fanomezana',
	'tooltip-n-sitesupport' => 'Ampio izahay',
	'group-accountcreator' => 'Mpanokatra kaonty',
	'group-autopatroller' => 'Rôbô mpijery',
	'group-founder' => 'Mpamorina',
	'group-import' => 'Mpanafatra',
	'group-rollbacker' => 'Mpamafa',
	'group-transwiki' => 'Mpanafatra transwiki',
	'group-uploader' => 'Mpampiditra',
	'group-accountcreator-member' => 'Mpamokatra kaonty',
	'group-founder-member' => 'Mpamorina',
	'group-import-member' => 'Mpanafatra',
	'group-rollbacker-member' => 'Mpamafa',
	'group-transwiki-member' => 'Mpanafatra transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Mpamokatra kaonty',
	'grouppage-autopatroller' => '{{ns:project}}:Rôbô Mpijery',
	'grouppage-founder' => '{{ns:project}}:Mpamorina',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Mpandrindra ny sistema',
	'group-sysadmin-member' => 'Mpandrindra ny Sistema',
	'group-coder' => 'Mpanakaody',
	'group-coder-member' => 'mpanakaody',
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
	'group-founder' => 'Основачи',
	'group-import' => 'Увезувачи',
	'group-ipblock-exempt' => 'IP блок исклучоци',
	'group-rollbacker' => 'Враќачи',
	'group-transwiki' => 'Трансвики увезувачи',
	'group-uploader' => 'Подигнувачи',
	'group-accountcreator-member' => 'создавач на сметка',
	'group-autopatroller-member' => 'автоматски патролирач',
	'group-founder-member' => 'основач',
	'group-import-member' => 'увозник',
	'group-ipblock-exempt-member' => 'IP блок исклучок',
	'group-rollbacker-member' => 'враќач',
	'group-transwiki-member' => 'трансвики увозник',
	'group-uploader-member' => 'подигнувач',
	'grouppage-accountcreator' => '{{ns:project}}:Создавачи на сметки',
	'grouppage-autopatroller' => '{{ns:project}}:Автоматски патролирачи',
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
	'group-Staff' => 'Персонал',
	'group-steward-member' => 'стјуард',
	'group-sysadmin-member' => 'систем администратор',
	'group-Global_bot-member' => 'глобален бот',
	'group-Global_rollback-member' => 'глобален враќач',
	'group-Ombudsmen-member' => 'омбудсман',
	'group-Staff-member' => 'член на персонал',
	'grouppage-steward' => 'm:Стјуарди',
	'grouppage-sysadmin' => 'm:Систем администратори',
	'grouppage-Global_bot' => 'm:Глобален бот',
	'grouppage-Global_rollback' => 'm:Глобално враќање',
	'grouppage-Ombudsmen' => 'm:Ombudsman commission',
	'group-coder' => 'Програмери',
	'group-coder-member' => 'програмер',
	'grouppage-coder' => 'Project:Програмер',
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
	'group-Staff' => 'स्टाफ',
	'group-Staff-member' => 'स्टाफ सदस्य',
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
	'group-founder' => 'Pengasas',
	'group-import' => 'Pengimport',
	'group-ipblock-exempt' => 'Pengecualian sekatan IP',
	'group-rollbacker' => 'Pengundur',
	'group-transwiki' => 'Pengimport rentas wiki',
	'group-uploader' => 'Pemuat naik',
	'group-accountcreator-member' => 'Pencipta akaun',
	'group-autopatroller-member' => 'autoperonda',
	'group-founder-member' => 'Pengasas',
	'group-import-member' => 'Pengimport',
	'group-ipblock-exempt-member' => 'Pengecualian sekatan IP',
	'group-rollbacker-member' => 'Pengundur',
	'group-transwiki-member' => 'Pengimport rentas wiki',
	'group-uploader-member' => 'pemuat naik',
	'grouppage-accountcreator' => '{{ns:project}}:Pencipta akaun',
	'grouppage-autopatroller' => '{{ns:project}}:Autoperonda',
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
	'group-Staff' => 'Kakitangan',
	'group-steward-member' => 'Pengelola',
	'group-sysadmin-member' => 'pentadbir sistem',
	'group-Global_bot-member' => 'Bot sejagat',
	'group-Global_rollback-member' => 'Pengundur suntingan sejagat',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-Staff-member' => 'kakitangan',
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
	'group-Staff' => 'Uffiċjal',
	'group-Staff-member' => 'Membru uffiċjal',
);

/** Mirandese (Mirandés)
 * @author Cecílio
 * @author MCruz
 */
$messages['mwl'] = array(
	'sitesupport' => 'Donaçones',
	'tooltip-n-sitesupport' => 'Ajuda-mos',
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
 * @author Sura
 */
$messages['myv'] = array(
	'sitesupport' => 'Лезксйармаконь максома',
	'tooltip-n-sitesupport' => 'Макста миненек нежедематарка',
	'group-founder' => 'Лувонь путыйть',
	'group-sysadmin' => 'Системань администраторт',
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
	'group-Staff' => 'Olōlli',
	'group-Staff-member' => 'Olōllācatl',
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
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Spennen',
	'tooltip-n-sitesupport' => 'Ünnerstütt uns',
	'group-accountcreator' => 'Brukerkonten-Opstellers',
	'group-autopatroller' => 'Autopatrollers',
	'group-founder' => 'Grünners',
	'group-import' => 'Importörs',
	'group-ipblock-exempt' => 'IP-Sperr-Utnahmen',
	'group-rollbacker' => 'Trüchsetters',
	'group-transwiki' => 'Transwiki-Importörs',
	'group-uploader' => 'Hoochladers',
	'group-bigexport' => 'Grootexportörs',
	'group-abusefilter' => 'Missbruukfilter-Autorn',
	'group-accountcreator-member' => 'Brukerkonten-Opsteller',
	'group-autopatroller-member' => 'Autopatroller',
	'group-founder-member' => 'Grünner',
	'group-import-member' => 'Importör',
	'group-ipblock-exempt-member' => 'IP-Sperr-Utnahm',
	'group-rollbacker-member' => 'Trüchsetter',
	'group-transwiki-member' => 'Transwiki-Importör',
	'group-uploader-member' => 'Hoochlader',
	'group-bigexport-member' => 'Grootexportör',
	'group-abusefilter-member' => 'Missbruukfilter-Autor',
	'grouppage-accountcreator' => '{{ns:project}}:Brukerkonten-Opstellers',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-founder' => '{{ns:project}}:Grünners',
	'grouppage-import' => '{{ns:project}}:Importörs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Sperr-Utnahm',
	'grouppage-rollbacker' => '{{ns:project}}:Trüchsetters',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importörs',
	'grouppage-uploader' => '{{ns:project}}:Hoochladers',
	'grouppage-bigexport' => '{{ns:project}}:Grootexportörs',
	'grouppage-abusefilter' => '{{ns:project}}:Missbruukfilter-Autorn',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'System-Administraters',
	'group-Global_bot' => 'Globale Bots',
	'group-Global_rollback' => 'Globale Trüchsetters',
	'group-Ombudsmen' => 'Ombudslüüd',
	'group-Staff' => 'Mitarbeiders',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'System-Administrater',
	'group-Global_bot-member' => 'Global Bot',
	'group-Global_rollback-member' => 'Global Trüchsetter',
	'group-Ombudsmen-member' => 'Ombudsmann',
	'group-Staff-member' => 'Mitarbeider',
	'group-coder' => 'Programmerers',
	'group-coder-member' => 'Programmerer',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 * @author לערי ריינהארט
 */
$messages['nds-nl'] = array(
	'wikimediamessages-desc' => 'Systeemteksen veur Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/Now/nds-nl',
	'sitesupport' => 'Financiële steun',
	'tooltip-n-sitesupport' => 'Gef oons geald',
	'group-accountcreator' => 'gebrukeranmakers',
	'group-autopatroller' => 'autopatrollers',
	'group-founder' => 'grondlegers',
	'group-import' => 'invoerders',
	'group-ipblock-exempt' => 'uutzunderingen van IP-adresblokkeringen',
	'group-rollbacker' => 'weerummedreiers',
	'group-transwiki' => 'transwiki-invoerders',
	'group-uploader' => 'bestanstoevoegers',
	'group-accountcreator-member' => 'gebrukeranmaker',
	'group-autopatroller-member' => 'autopatroller',
	'group-founder-member' => 'grondleger',
	'group-import-member' => 'invoerder',
	'group-ipblock-exempt-member' => 'uutzundering van IP-adresblokkeringen',
	'group-rollbacker-member' => 'weerummedreier',
	'group-transwiki-member' => 'transwiki-invoerder',
	'group-uploader-member' => 'bestanstoevoeger',
	'grouppage-accountcreator' => '{{ns:project}}:Gebrukeranmakers',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-founder' => '{{ns:project}}:Grondlegers',
	'grouppage-import' => '{{ns:project}}:Invoerders',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Uutzunderingen van IP-adresblokkeringen',
	'grouppage-rollbacker' => '{{ns:project}}:Weerummedreiers',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-invoerders',
	'grouppage-uploader' => '{{ns:project}}:Bestanstoevoegers',
	'group-steward' => 'rechenbeheerders',
	'group-sysadmin' => 'systeembeheerder',
	'group-Global_bot' => 'globale bots',
	'group-Global_rollback' => 'globale weerummedreiers',
	'group-Ombudsmen' => 'ombudsluui',
	'group-Staff' => 'staf',
	'group-steward-member' => 'rechenbeheerder',
	'group-sysadmin-member' => 'systeembeheerder',
	'group-Global_bot-member' => 'globale bot',
	'group-Global_rollback-member' => 'globale weerummedreier',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'staflid',
	'group-coder' => 'progremmeurs',
	'group-coder-member' => 'progremmeur',
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
	'group-founder' => 'grondleggers',
	'group-import' => 'importeurs',
	'group-ipblock-exempt' => 'uitgezonderden van IP-adresblokkades',
	'group-rollbacker' => 'terugdraaiers',
	'group-transwiki' => 'transwiki-importeurs',
	'group-uploader' => 'uploaders',
	'group-bigexport' => 'grote exporteurs',
	'group-abusefilter' => 'misbruikfilteredacteuren',
	'group-accountcreator-member' => 'gebruikersaanmaker',
	'group-autopatroller-member' => 'autopatroller',
	'group-founder-member' => 'grondlegger',
	'group-import-member' => 'importeur',
	'group-ipblock-exempt-member' => 'uitgezonderde van IP-adresblokkades',
	'group-rollbacker-member' => 'terugdraaier',
	'group-transwiki-member' => 'transwiki-importeur',
	'group-uploader-member' => 'uploader',
	'group-bigexport-member' => 'grote exporteur',
	'group-abusefilter-member' => 'misbruikfilteredacteur',
	'grouppage-accountcreator' => '{{ns:project}}:Gebruikersaanmakers',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrollers',
	'grouppage-founder' => '{{ns:project}}:Grondleggers',
	'grouppage-import' => '{{ns:project}}:Importeurs',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Uitgezonderden van IP-adresblokkades',
	'grouppage-rollbacker' => '{{ns:project}}:Terugdraaiers',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importeurs',
	'grouppage-uploader' => '{{ns:project}}:Uploaders',
	'grouppage-bigexport' => '{{ns:project}}:Grote exporteurs',
	'grouppage-abusefilter' => '{{ns:project}}:Misbruikfilteredacteuren',
	'group-steward' => 'stewards',
	'group-sysadmin' => 'systeembeheerders',
	'group-Global_bot' => 'globale bots',
	'group-Global_rollback' => 'globale terugdraaiers',
	'group-Ombudsmen' => 'ombudsmannen',
	'group-Staff' => 'staf',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systeembeheerder',
	'group-Global_bot-member' => 'globale bot',
	'group-Global_rollback-member' => 'globale terugdraaier',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'staflid',
	'grouppage-steward' => 'm:Stewards/nl',
	'grouppage-Global_rollback' => 'm:Global rollback/nl',
	'group-coder' => 'programmeurs',
	'group-coder-member' => 'programmeur',
	'grouppage-coder' => 'Project:Programmeur',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Gunnernett
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
	'group-founder' => 'Grunnleggarar',
	'group-import' => 'Importørar',
	'group-ipblock-exempt' => 'Unntak frå IP-blokkering',
	'group-rollbacker' => 'Attenderullarar',
	'group-transwiki' => 'Transwiki-importørar',
	'group-uploader' => 'Opplastarar',
	'group-bigexport' => 'Store eksportørar',
	'group-accountcreator-member' => 'Kontoopprettar',
	'group-autopatroller-member' => 'automatisk godkjende bidrag',
	'group-founder-member' => 'grunnleggar',
	'group-import-member' => 'importør',
	'group-ipblock-exempt-member' => 'Unteke frå IP-blokkering',
	'group-rollbacker-member' => 'attenderullar',
	'group-transwiki-member' => 'transwiki-importør',
	'group-uploader-member' => 'opplastar',
	'group-bigexport-member' => 'stor eksportør',
	'grouppage-accountcreator' => '{{ns:project}}:Kontoopprettarar',
	'grouppage-autopatroller' => '{{ns:project}}:Automatisk godkjende bidrag',
	'grouppage-founder' => '{{ns:project}}:Grunnleggarar',
	'grouppage-import' => '{{ns:project}}:Importørar',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Unnatekne frå IP-blokkering',
	'grouppage-rollbacker' => '{{ns:project}}:Attenderullarar',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importørar',
	'grouppage-uploader' => '{{ns:project}}:Opplastarar',
	'grouppage-bigexport' => '{{ns:project}}:Store eksportørar',
	'group-steward' => 'Stewardar',
	'group-sysadmin' => 'Systemadministratorar',
	'group-Global_bot' => 'Globale robotar',
	'group-Global_rollback' => 'Globale attenderullarar',
	'group-Ombudsmen' => 'Ombodsmenn',
	'group-Staff' => 'Personale',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemadministrator',
	'group-Global_bot-member' => 'global robot',
	'group-Global_rollback-member' => 'global attenderullar',
	'group-Ombudsmen-member' => 'ombodsmann',
	'group-Staff-member' => 'personal',
	'grouppage-steward' => 'm:Stewards/nb',
	'grouppage-sysadmin' => 'm:Systemadministratorar',
	'grouppage-Global_bot' => 'm:Global robot',
	'grouppage-Global_rollback' => 'm:Global rollback/nb',
	'group-coder' => 'Kodarar',
	'group-coder-member' => 'kodar',
	'grouppage-coder' => 'Project:Kodar',
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
	'group-founder' => 'Grunnleggere',
	'group-import' => 'Importører',
	'group-ipblock-exempt' => 'Untatte fra IP-blokkering',
	'group-rollbacker' => 'Tilbakestillere',
	'group-transwiki' => 'Transwiki-importører',
	'group-uploader' => 'Opplastere',
	'group-accountcreator-member' => 'Kontooppretter',
	'group-autopatroller-member' => 'automatisk godkjente bidrag',
	'group-founder-member' => 'Grunnlegger',
	'group-import-member' => 'Importør',
	'group-ipblock-exempt-member' => 'Unttatt fra IP-blokkering',
	'group-rollbacker-member' => 'Tilbakestiller',
	'group-transwiki-member' => 'Transwiki-importør',
	'group-uploader-member' => 'opplaster',
	'grouppage-accountcreator' => '{{ns:project}}:Kontoopprettere',
	'grouppage-autopatroller' => '{{ns:project}}:Patruljering',
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
	'group-Staff' => 'Ansatte',
	'group-steward-member' => 'forvalter',
	'group-sysadmin-member' => 'systemadministrator',
	'group-Global_bot-member' => 'global robot',
	'group-Global_rollback-member' => 'global tilbakestiller',
	'group-Ombudsmen-member' => 'ombudsmann',
	'group-Staff-member' => 'ansatt',
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
	'group-founder' => 'Fondators',
	'group-import' => 'Importaires',
	'group-ipblock-exempt' => 'Exempcions de blòts IP',
	'group-rollbacker' => 'Revocaires',
	'group-transwiki' => 'Importaires Transwiki',
	'group-uploader' => 'Telecargaires',
	'group-bigexport' => 'Grands exportaires',
	'group-abusefilter' => "Modificators dels filtres d'abuses",
	'group-accountcreator-member' => 'Creator de comptes',
	'group-autopatroller-member' => 'Patrolhador automatic',
	'group-founder-member' => 'Fondator',
	'group-import-member' => 'Importaire',
	'group-ipblock-exempt-member' => 'Exempcion de blòt IP',
	'group-rollbacker-member' => 'Revocaire',
	'group-transwiki-member' => 'Importaire Transwiki',
	'group-uploader-member' => 'Telecargaire',
	'group-bigexport-member' => 'grand exportaire',
	'group-abusefilter-member' => "modificator dels filtres d'abuses",
	'grouppage-accountcreator' => '{{ns:project}}:Creators de comptes',
	'grouppage-autopatroller' => '{{ns:project}}:Patrolhadors automatics',
	'grouppage-founder' => '{{ns:project}}:Fondators',
	'grouppage-import' => '{{ns:project}}:Importaires',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Exempcion de blòt IP',
	'grouppage-rollbacker' => '{{ns:project}}:Revocaires',
	'grouppage-transwiki' => '{{ns:project}}:Importaires Transwiki',
	'grouppage-uploader' => '{{ns:project}}:Telecargaires',
	'grouppage-bigexport' => '{{ns:project}}:Grands exportaires',
	'grouppage-abusefilter' => "{{ns:project}}:Modificators dels filtres d'abuses",
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administrators del sistèma',
	'group-Global_bot' => 'Bòts globals',
	'group-Global_rollback' => 'Revocaires globals',
	'group-Ombudsmen' => 'Comissaris',
	'group-Staff' => 'Personal',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrator del sistèma',
	'group-Global_bot-member' => 'Bòt global',
	'group-Global_rollback-member' => 'Revocaire global',
	'group-Ombudsmen-member' => 'Comissari',
	'group-Staff-member' => 'Membre del personal',
	'group-coder' => 'Encodaires',
	'group-coder-member' => 'encodaire',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Jose77
 */
$messages['or'] = array(
	'sitesupport' => 'ଦାନ',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'sitesupport' => 'Мысайнаг',
	'tooltip-n-sitesupport' => 'Баххуыс нын кæн',
	'group-founder' => 'Бындурæвæрджытæ',
	'group-founder-member' => 'бындурæвæрæг',
	'grouppage-founder' => '{{ns:project}}:Бындурæвæрджытæ',
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
	'group-founder' => 'Założyciele',
	'group-import' => 'Importerzy',
	'group-ipblock-exempt' => 'Uprawnieni do logowania się z zablokowanych adresów IP',
	'group-rollbacker' => 'Uprawnieni do wycofywania edycji',
	'group-transwiki' => 'Importerzy transwiki',
	'group-uploader' => 'Przesyłający pliki',
	'group-bigexport' => 'Masowi eksporterzy',
	'group-abusefilter' => 'Operatorzy filtru nadużyć',
	'group-accountcreator-member' => 'twórca kont',
	'group-autopatroller-member' => 'patrolujący automatycznie',
	'group-founder-member' => 'założyciel',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'uprawniony do zalogowania się z zablokowanego adresu IP',
	'group-rollbacker-member' => 'uprawniony do wycofania edycji',
	'group-transwiki-member' => 'importer transwiki',
	'group-uploader-member' => 'przesyłający pliki',
	'group-bigexport-member' => 'Masowy eksporter',
	'group-abusefilter-member' => 'operator filtru nadużyć',
	'grouppage-accountcreator' => '{{ns:project}}:Twórcy kont',
	'grouppage-autopatroller' => '{{ns:project}}:Patrolujący automatycznie',
	'grouppage-founder' => '{{ns:project}}:Założyciele',
	'grouppage-import' => '{{ns:project}}:Importerzy',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Uprawnieni do logowania się z zablokowanych adresów IP',
	'grouppage-rollbacker' => '{{ns:project}}:Uprawnieni do wycofywania edycji',
	'grouppage-transwiki' => '{{ns:project}}:Importerzy transwiki',
	'grouppage-uploader' => '{{ns:project}}:Przesyłający pliki',
	'grouppage-bigexport' => '{{ns:project}}:Masowi eksporterzy',
	'grouppage-abusefilter' => '{{ns:project}}:Operatorzy filtru nadużyć',
	'group-steward' => 'Stewardzi',
	'group-sysadmin' => 'Administratorzy systemu',
	'group-Global_bot' => 'Boty globalne',
	'group-Global_rollback' => 'Globalnie uprawnieni do wycofywania edycji',
	'group-Ombudsmen' => 'Rzecznicy praw',
	'group-Staff' => 'Pracownicy',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'administrator systemu',
	'group-Global_bot-member' => 'bot globalny',
	'group-Global_rollback-member' => 'globalnie uprawniony do wycofywania edycji',
	'group-Ombudsmen-member' => 'rzecznik praw',
	'group-Staff-member' => 'pracownik',
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
	'group-founder' => 'بنسټګران',
	'group-accountcreator-member' => 'کارن-حساب جوړونکی',
	'group-founder-member' => 'بنسټګر',
	'grouppage-accountcreator' => '{{ns:project}}:کارن-حساب جوړونکي',
	'group-sysadmin' => 'د غونډال پازوالان',
	'group-Staff' => 'امله',
	'group-sysadmin-member' => 'د غونډال پازوال',
	'group-Staff-member' => 'د املې غړی',
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
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'IPs não bloqueados',
	'group-rollbacker' => 'Revertedores',
	'group-transwiki' => 'Importadores Transwiki',
	'group-uploader' => 'Carregadores',
	'group-bigexport' => 'Grandes exportadores',
	'group-abusefilter' => 'Editores de filtros de abuso',
	'group-accountcreator-member' => 'Criador de contas',
	'group-autopatroller-member' => 'auto-patrulhador',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'IPs não bloqueados',
	'group-rollbacker-member' => 'Revertedor',
	'group-transwiki-member' => 'importador transwiki',
	'group-uploader-member' => 'carregador',
	'group-bigexport-member' => 'grande exportador',
	'group-abusefilter-member' => 'editores de filtros de abuso',
	'grouppage-accountcreator' => '{{ns:project}}:Criadores de contas',
	'grouppage-autopatroller' => '{{ns:project}}:Auto-patrulhadores',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP não bloqueado',
	'grouppage-rollbacker' => '{{ns:project}}:Revertedores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Carregadores',
	'grouppage-bigexport' => '{{ns:project}}:Grandes exportadores',
	'grouppage-abusefilter' => '{{ns:project}}:Editores de filtros de abuso',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradores de sistema',
	'group-Global_bot' => 'Robôs globais',
	'group-Global_rollback' => 'Revertedores globais',
	'group-Ombudsmen' => 'Mediadores',
	'group-Staff' => 'Pessoal',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrador de sistema',
	'group-Global_bot-member' => 'robô global',
	'group-Global_rollback-member' => 'revertedor global',
	'group-Ombudsmen-member' => 'mediador',
	'group-Staff-member' => 'membro do pessoal',
	'grouppage-steward' => 'm:Stewards/pt',
	'group-coder' => 'Codificadores',
	'group-coder-member' => 'codificador',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Carla404
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'wikimediamessages-desc' => 'Mensagens específicas da Wikimedia',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/pt',
	'sitesupport' => 'Doações',
	'tooltip-n-sitesupport' => 'Ajude-nos',
	'group-accountcreator' => 'Criadores de contas',
	'group-autopatroller' => 'Auto-patrulhadores',
	'group-founder' => 'Fundadores',
	'group-import' => 'Importadores',
	'group-ipblock-exempt' => 'IPs não bloqueados',
	'group-rollbacker' => 'Revertedores',
	'group-transwiki' => 'Importadores Transwiki',
	'group-uploader' => 'Carregadores',
	'group-bigexport' => 'Grandes exportadores',
	'group-abusefilter' => 'Editores de filtros de abuso',
	'group-accountcreator-member' => 'Criador de contas',
	'group-autopatroller-member' => 'auto-patrulhador',
	'group-founder-member' => 'Fundador',
	'group-import-member' => 'Importador',
	'group-ipblock-exempt-member' => 'IP não bloqueado',
	'group-rollbacker-member' => 'Revertedor',
	'group-transwiki-member' => 'importador transwiki',
	'group-uploader-member' => 'carregador',
	'group-bigexport-member' => 'grande exportador',
	'group-abusefilter-member' => 'editores de filtros de abuso',
	'grouppage-accountcreator' => '{{ns:project}}:Criadores de contas',
	'grouppage-autopatroller' => '{{ns:project}}:Auto-patrulhadores',
	'grouppage-founder' => '{{ns:project}}:Fundadores',
	'grouppage-import' => '{{ns:project}}:Importadores',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP não bloqueado',
	'grouppage-rollbacker' => '{{ns:project}}:Revertedores',
	'grouppage-transwiki' => '{{ns:project}}:Importadores transwiki',
	'grouppage-uploader' => '{{ns:project}}:Carregadores',
	'grouppage-bigexport' => '{{ns:project}}:Grandes exportadores',
	'grouppage-abusefilter' => '{{ns:project}}:Editores de filtros de abuso',
	'group-steward' => 'Stewards',
	'group-sysadmin' => 'Administradores de sistema',
	'group-Global_bot' => 'Robôs globais',
	'group-Global_rollback' => 'Revertedores globais',
	'group-Ombudsmen' => 'Mediadores',
	'group-Staff' => 'Equipe',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'administrador de sistema',
	'group-Global_bot-member' => 'robô global',
	'group-Global_rollback-member' => 'revertedor global',
	'group-Ombudsmen-member' => 'mediador',
	'group-Staff-member' => 'membro da equipe',
	'group-coder' => 'Codificadores',
	'group-coder-member' => 'codificador',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'wikimediamessages-desc' => 'Wikimedia sapaq willaykuna',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Qarana',
	'tooltip-n-sitesupport' => 'Yanapawayku',
	'group-accountcreator' => 'Rakiquna kamariqkuna',
	'group-autopatroller' => 'Kikinmanta patrullaqkuna',
	'group-founder' => 'Kamariqkuna',
	'group-import' => 'Hawamanta chaskiqkuna',
	'group-ipblock-exempt' => "IP hark'aymanta qispisqakuna",
	'group-rollbacker' => 'Kutichiqkuna',
	'group-transwiki' => 'Wikipura hawamanta chaskiqkuna',
	'group-uploader' => 'Churkuqkuna',
	'group-bigexport' => 'Hatun hawaman quqkuna',
	'group-abusefilter' => "Millay ruray suysuna llamk'apuqkuna",
	'group-accountcreator-member' => 'rakiquna kamariq',
	'group-autopatroller-member' => 'kikinmanta patrullaq',
	'group-founder-member' => 'kamariq',
	'group-import-member' => 'hawamanta chaskiq',
	'group-ipblock-exempt-member' => "IP hark'aymanta qispisqa",
	'group-rollbacker-member' => 'kutichiq',
	'group-transwiki-member' => 'wikipura hawamanta chaskiq',
	'group-uploader-member' => 'churkuq',
	'group-bigexport-member' => 'hatun hawaman quq',
	'group-abusefilter-member' => "millay ruray suysuna llamk'apuq",
	'grouppage-accountcreator' => '{{ns:project}}:Rakiquna kamariqkuna',
	'grouppage-autopatroller' => '{{ns:project}}:Kikinmanta patrullaqkuna',
	'grouppage-founder' => '{{ns:project}}:Kamariqkuna',
	'grouppage-import' => '{{ns:project}}:Hawamanta chaskiqkuna',
	'grouppage-ipblock-exempt' => "{{ns:project}}:IP hark'aymanta qispisqakuna",
	'grouppage-rollbacker' => '{{ns:project}}:Kutichiqkuna',
	'grouppage-transwiki' => '{{ns:project}}:Wikipura hawamanta chaskiqkuna',
	'grouppage-uploader' => '{{ns:project}}:Churkuqkuna',
	'grouppage-bigexport' => '{{ns:project}}:Hatun hawaman quqkuna',
	'grouppage-abusefilter' => "{{ns:project}}:Millay ruray suysuna llamk'apuqkuna",
	'group-steward' => 'Steward nisqakuna',
	'group-sysadmin' => 'Llika kamachiqkuna',
	'group-Global_bot' => 'Sapsi rurana antachakuna',
	'group-Global_rollback' => 'Sapsi kutichiqkuna',
	'group-Ombudsmen' => 'Ayllu amachaqkuna',
	'group-Staff' => "Llamk'aqninkuna",
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'llika kamachiq',
	'group-Global_bot-member' => 'sapsi rurana antacha',
	'group-Global_rollback-member' => 'sapsi kutichiq',
	'group-Ombudsmen-member' => 'ayllu amachaq',
	'group-Staff-member' => "llamk'aqninkuna",
	'group-coder' => 'Wakichi qillqaqkuna',
	'group-coder-member' => 'wakichi qillqaq',
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
	'group-founder' => 'Fondatori',
	'group-import' => 'Importatori',
	'group-transwiki' => 'Importatori între wiki',
	'group-accountcreator-member' => 'creator de conturi',
	'group-founder-member' => 'Fondator',
	'group-import-member' => 'importator',
	'group-transwiki-member' => 'importator între wiki',
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
	'wikimediamessages-desc' => 'Wikimedia specific messages',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Done',
	'tooltip-n-sitesupport' => 'Aiutene',
	'group-founder' => 'Fondature',
	'group-import' => "'Mbortature",
	'group-uploader' => 'Carecatore',
	'group-import-member' => "'mbortatore",
	'group-transwiki-member' => 'Importatore de transuicchi',
	'group-uploader-member' => 'carecatore',
	'grouppage-import' => "{{ns:project}}:'Mbortature",
	'grouppage-uploader' => '{{ns:project}}:Carecature',
	'group-steward' => 'Steward',
	'group-sysadmin' => "Amministrature d'u sisteme",
	'group-Global_bot' => 'Bot globele',
	'group-Staff' => "'U personele",
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'amministratore de sisteme',
	'group-Global_bot-member' => 'bot globele',
	'group-Staff-member' => "cristiàne d'u personele",
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
	'group-founder' => 'Основатели',
	'group-import' => 'Импортёры',
	'group-ipblock-exempt' => 'Исключения из IP-блокировок',
	'group-rollbacker' => 'Откатывающие',
	'group-transwiki' => 'Импортёры из Transwiki',
	'group-uploader' => 'Загружающие',
	'group-bigexport' => 'Крупные экспортёры',
	'group-abusefilter' => 'Редакторы фильтра злоупотреблений',
	'group-accountcreator-member' => 'создатель учётных записей',
	'group-autopatroller-member' => 'автопатрулируемый',
	'group-founder-member' => 'основатель',
	'group-import-member' => 'импортёр',
	'group-ipblock-exempt-member' => 'исключение из IP-блокировок',
	'group-rollbacker-member' => 'откатывающий',
	'group-transwiki-member' => 'импортёр из Transwiki',
	'group-uploader-member' => 'загружающий',
	'group-bigexport-member' => 'крупный экспортёр',
	'group-abusefilter-member' => 'редактор фильтра злоупотреблений',
	'grouppage-accountcreator' => '{{ns:project}}:Создатели учётных записей',
	'grouppage-autopatroller' => '{{ns:project}}:Автопатрулируемые',
	'grouppage-founder' => '{{ns:project}}:Основатели',
	'grouppage-import' => '{{ns:project}}:Импортёры',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Исключение из IP-блокировок',
	'grouppage-rollbacker' => '{{ns:project}}:Откатывающие',
	'grouppage-transwiki' => '{{ns:project}}:Импортёры из Transwiki',
	'grouppage-uploader' => '{{ns:project}}:Загружающие',
	'grouppage-bigexport' => '{{ns:project}}:Крупные экспортёры',
	'grouppage-abusefilter' => '{{ns:project}}:Редакторы фильтра злоупотреблений',
	'group-steward' => 'Стюарды',
	'group-sysadmin' => 'Системные администраторы',
	'group-Global_bot' => 'Глобальные боты',
	'group-Global_rollback' => 'Глобальные откатывающие',
	'group-Ombudsmen' => 'Омбудсмены',
	'group-Staff' => 'Сотрудники',
	'group-steward-member' => 'стюард',
	'group-sysadmin-member' => 'системный администратор',
	'group-Global_bot-member' => 'глобальный бот',
	'group-Global_rollback-member' => 'глобальный откатывающий',
	'group-Ombudsmen-member' => 'омбудсмен',
	'group-Staff-member' => 'сотрудник',
	'grouppage-steward' => 'm:Stewards/ru',
	'group-coder' => 'Программисты',
	'group-coder-member' => 'программист',
	'shared-repo-name-shared' => 'Викисклад',
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
	'group-autopatroller' => 'Аптамаатынан ботуруулланааччылар',
	'group-founder' => 'Тэрийээччилэр',
	'group-import' => 'Импортааччылар',
	'group-ipblock-exempt' => 'Хааччахтааһыҥҥа киирбэт IP-лаахтар',
	'group-rollbacker' => 'Төннөрөөччүлэр',
	'group-transwiki' => 'Transwiki`ттан импортааччылар',
	'group-uploader' => 'Киллэрээччилэр',
	'group-accountcreator-member' => 'Кыттаачылар ааттарын бигэргэтээччи/оҥорооччу',
	'group-autopatroller-member' => 'аптамаатынан ботуруулланааччы',
	'group-founder-member' => 'Тэрийээччи',
	'group-import-member' => 'Импортааччы',
	'group-ipblock-exempt-member' => 'IP-та хааччахтаммат кыттааччы',
	'group-rollbacker-member' => 'Төннөрөөччү',
	'group-transwiki-member' => 'transwiki`ттан импортааччы',
	'group-uploader-member' => 'киллэрээччи',
	'grouppage-accountcreator' => '{{ns:project}}:Кыттааччылар ааттарын бигэргэтээччилэр/айааччылар',
	'grouppage-autopatroller' => '{{ns:project}}:Аптамаатынан ботуруулланааччылар',
	'grouppage-founder' => '{{ns:project}}:Тэрийээччилэр',
	'grouppage-import' => '{{ns:project}}:Импортааччылар',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-лара хааччахтаммат кыттааччылар',
	'grouppage-rollbacker' => '{{ns:project}}:Төннөрөөччүлэр',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki`ттан көһөрөөччүлэр',
	'grouppage-uploader' => '{{ns:project}}:Киллэрээччилэр',
	'group-steward' => 'Үстүйээрдэр',
	'group-sysadmin' => 'Тиһик (систиэмэ) дьаһабыллара',
	'group-Global_bot' => 'Бырайыактар ыккардынааҕы руобаттар',
	'group-Global_rollback' => 'Бырайыактар ыккардынааҕы төннөрөөччүлэр',
	'group-Ombudsmen' => 'Омбудсменнар',
	'group-steward-member' => 'үстүйээрдэр',
	'group-sysadmin-member' => 'дьаһабыл',
	'group-Global_bot-member' => 'бырайыактар ыккардынааҕы руобаттар',
	'group-Global_rollback-member' => 'бырайыактар ыккардынааҕы төннөрөөччүлэр',
	'group-Ombudsmen-member' => 'омбудсман',
	'group-coder' => 'Программистар',
	'group-coder-member' => 'программист',
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
	'group-founder' => 'Funnatura',
	'group-import' => 'Mpurtatura',
	'group-ipblock-exempt' => 'Esenti dû bloccu IP',
	'group-rollbacker' => 'Ripristinatura',
	'group-transwiki' => 'Mpurtaturi transwiki',
	'group-accountcreator-member' => 'Criaturi di cuntu',
	'group-founder-member' => 'Funnaturi',
	'group-import-member' => 'Mpurtaturi',
	'group-ipblock-exempt-member' => 'Esenti dû bloccu IP',
	'group-rollbacker-member' => 'Ripristinaturi',
	'group-transwiki-member' => 'Mpurtaturi transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Criatura di cunti',
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
	'group-Staff' => 'Staff',
	'group-steward-member' => 'Stiùwart',
	'group-sysadmin-member' => 'amministraturi di sistema',
	'group-Global_bot-member' => 'bot glubbali',
	'group-Global_rollback-member' => 'ripristinaturi glubbali',
	'group-Ombudsmen-member' => 'difinsuri cìvicu',
	'group-Staff-member' => 'Cumpunenti dû staff',
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
	'group-founder' => 'ප්‍රාරම්භකයන්',
	'group-import' => 'ආයාතකරුවන්',
	'group-ipblock-exempt' => 'අන්තර්ජාල වාරණ විවර්ජනයන්',
	'group-rollbacker' => 'පසුපෙරළන්නන්',
	'group-transwiki' => 'අන්තර්විකී ආයාතකරුවන්',
	'group-accountcreator-member' => 'ගිණුම් තනන්නා',
	'group-founder-member' => 'ප්‍රාර්ම්භක',
	'group-import-member' => 'ආයාතකරු',
	'group-ipblock-exempt-member' => 'අන්තර්ජාල වාරණ විවර්ජනය',
	'group-rollbacker-member' => 'පසුපෙරළන්නා',
	'group-transwiki-member' => 'අන්තර්විකි ආයාතකරු',
	'grouppage-accountcreator' => '{{ns:project}}:ගිණුම් තනන්නන්',
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
	'group-Staff' => 'සේවක මඩුල්ල',
	'group-steward-member' => 'භාරකරු',
	'group-sysadmin-member' => 'පද්ධති පරිපාලකවරයා',
	'group-Global_bot-member' => 'ගෝලීය රොබෝවරයා',
	'group-Global_rollback-member' => 'ගෝලීය පසුපෙරළන්නා',
	'group-Ombudsmen-member' => 'දුග්ගන්නාරාළ',
	'group-Staff-member' => 'සේවක මණ්ඩල සාමාජිකයා',
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
	'group-founder' => 'Zakladatelia',
	'group-import' => 'Importéri',
	'group-ipblock-exempt' => 'Výnimky z blokovaní IP',
	'group-rollbacker' => 'S právom rollback',
	'group-transwiki' => 'Transwiki importéri',
	'group-uploader' => 'Nahrávajúci',
	'group-bigexport' => 'Hromadní exportéri',
	'group-abusefilter' => 'Redaktori filtrov zneužití',
	'group-accountcreator-member' => 'Tvorca účtu',
	'group-autopatroller-member' => 'strážca',
	'group-founder-member' => 'Zakladateľ',
	'group-import-member' => 'Importér',
	'group-ipblock-exempt-member' => 'Výnimka z blokovaní IP',
	'group-rollbacker-member' => 'S právom rollback',
	'group-transwiki-member' => 'Transwiki importér',
	'group-uploader-member' => 'nahrávajúci',
	'group-bigexport-member' => 'hromadní exportér',
	'group-abusefilter-member' => 'redaktor filtrov zneužití',
	'grouppage-accountcreator' => '{{ns:project}}:Tvorcovia účtov',
	'grouppage-autopatroller' => '{{ns:project}}:Strážcovia',
	'grouppage-founder' => '{{ns:project}}:Zakladatelia',
	'grouppage-import' => '{{ns:project}}:Importéri',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Výnimky z blokovaní IP',
	'grouppage-rollbacker' => '{{ns:project}}:S právom rollback',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki importéri',
	'grouppage-uploader' => '{{ns:project}}:Nahrávajúci',
	'grouppage-bigexport' => '{{ns:project}}:Hromadní exportéri',
	'grouppage-abusefilter' => '{{ns:project}}:Redaktori filtrov zneužití',
	'group-steward' => 'Stewardi',
	'group-sysadmin' => 'Správcovia systému',
	'group-Global_bot' => 'Globálni roboti',
	'group-Global_rollback' => 'Globálni rollbackeri',
	'group-Ombudsmen' => 'Ombudsmani',
	'group-Staff' => 'Zamestnanci',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'správca systému',
	'group-Global_bot-member' => 'Globálny robot',
	'group-Global_rollback-member' => 'Globálny rollbacker',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-Staff-member' => 'zamestnanec',
	'group-coder' => 'Kóderi',
	'group-coder-member' => 'kóder',
);

/** Slovenian (Slovenščina)
 * @author Smihael
 * @author Yerpo
 */
$messages['sl'] = array(
	'sitesupport' => 'Denarni prispevki',
	'group-Ombudsmen-member' => 'ombudsman',
	'shared-repo-name-shared' => 'Wikimedijine Zbirke',
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
 * @author Puntori
 */
$messages['sq'] = array(
	'sitesupport' => 'Dhurime',
	'tooltip-n-sitesupport' => 'Na përmbajë',
	'group-accountcreator' => 'Krijuesit e kontove',
	'group-founder' => 'Themeluesit',
	'group-import' => 'Importuesit',
	'group-founder-member' => 'themelues',
	'group-import-member' => 'importues',
	'group-uploader-member' => 'ngarkues',
	'group-steward' => 'Përgjegjës',
	'group-Staff' => 'Stafi',
	'group-steward-member' => 'Përgjegjës',
	'group-Staff-member' => 'anëtar i stafit',
	'group-coder' => 'Koduesit',
	'group-coder-member' => 'kodues',
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
	'group-founder' => 'оснивачи',
	'group-import' => 'уносници',
	'group-ipblock-exempt' => 'изузеци од ИП блокова',
	'group-rollbacker' => 'враћачи',
	'group-transwiki' => 'међувики уносници',
	'group-accountcreator-member' => 'стваралац налога',
	'group-founder-member' => 'оснивач',
	'group-import-member' => 'уносник',
	'group-ipblock-exempt-member' => 'изузетак од ИП блокова',
	'group-rollbacker-member' => 'враћач',
	'group-transwiki-member' => 'међувики уносник',
	'grouppage-accountcreator' => '{{ns:project}}:Стварачи налога',
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
	'group-autopatroller' => 'Automatiske Wröigere',
	'group-founder' => 'Gruundere',
	'group-import' => 'Importeur',
	'group-ipblock-exempt' => 'IP-Speere-Uutnoamen',
	'group-rollbacker' => 'Touräächsättere',
	'group-transwiki' => 'Transwiki-Importeure',
	'group-uploader' => 'Hoochleedere',
	'group-accountcreator-member' => 'Benutserkonten-Moaker',
	'group-autopatroller-member' => 'Automatisken Wröiger',
	'group-founder-member' => 'Gruunder',
	'group-import-member' => 'Importeur',
	'group-ipblock-exempt-member' => 'IP-Speere-Uutnoame',
	'group-rollbacker-member' => 'Touräächsätter',
	'group-transwiki-member' => 'Transwiki-Importeur',
	'group-uploader-member' => 'Hoochleeder',
	'grouppage-accountcreator' => '{{ns:project}}:Benutserkonten-Moakere',
	'grouppage-autopatroller' => '{{ns:project}}:Automatiske Wröigere',
	'grouppage-founder' => '{{ns:project}}:Gruundere',
	'grouppage-import' => '{{ns:project}}:Importeure',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP-Speere-Uutnoame',
	'grouppage-rollbacker' => '{{ns:project}}:Touräächsättere',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-Importeure',
	'grouppage-uploader' => '{{ns:project}}:Hoochleedere',
	'group-steward' => 'Stewarde',
	'group-sysadmin' => 'Systemadministratore',
	'group-Global_bot' => 'Globoale Bots',
	'group-Global_rollback' => 'Globoale Touräächsättere',
	'group-Ombudsmen' => 'Ombudsljuude',
	'group-Staff' => 'Mee-Oarbaidere',
	'group-steward-member' => 'Steward',
	'group-sysadmin-member' => 'Systemadministrator',
	'group-Global_bot-member' => 'Globoalen Bot',
	'group-Global_rollback-member' => 'Globoalen Touräächsätter',
	'group-Ombudsmen-member' => 'Ombudspersoon',
	'group-Staff-member' => 'Mee-Oarbaider',
	'grouppage-steward' => '{{ns:project}}:Stewards',
	'group-coder' => 'Programmierdere',
	'group-coder-member' => 'Programmierder',
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
	'group-founder' => 'Nu ngadegkeun',
	'group-import' => 'Importir',
	'group-ipblock-exempt' => 'Peungpeuk kajaba IP',
	'group-rollbacker' => 'Malikeun révisi',
	'group-transwiki' => 'Importir transwiki',
	'group-accountcreator-member' => 'nu nyieun rekening',
	'group-founder-member' => 'nu ngadegkeun',
	'group-import-member' => 'importir',
	'group-ipblock-exempt-member' => 'Peungpeuk kajaba IP',
	'group-rollbacker-member' => 'Malikeun révisi',
	'group-transwiki-member' => 'importir transwiki',
	'grouppage-accountcreator' => '{{ns:project}}:Nu nyieun rekening',
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
	'group-Staff' => 'Staf',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'kuncén sistem',
	'group-Global_bot-member' => 'bot global',
	'group-Global_rollback-member' => 'Malikeun révisi global',
	'group-Ombudsmen-member' => 'Ombudsman',
	'group-Staff-member' => 'Anggota staf',
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
	'group-founder' => 'Grundare',
	'group-import' => 'Importörer',
	'group-ipblock-exempt' => 'Undantagna från IP-blockering',
	'group-rollbacker' => 'Tillbakarullare',
	'group-transwiki' => 'Transwiki-importörer',
	'group-uploader' => 'Uppladdare',
	'group-bigexport' => 'Stora exporterare',
	'group-abusefilter' => 'Redigerare av missbruksfilter',
	'group-accountcreator-member' => 'kontoskapare',
	'group-autopatroller-member' => 'autopatrullerare',
	'group-founder-member' => 'grundare',
	'group-import-member' => 'importör',
	'group-ipblock-exempt-member' => 'undantagen från IP-blockering',
	'group-rollbacker-member' => 'tillbakarullare',
	'group-transwiki-member' => 'transwiki-importör',
	'group-uploader-member' => 'uppladdare',
	'group-bigexport-member' => 'stor exporterare',
	'group-abusefilter-member' => 'redigerare av missbruksfilter',
	'grouppage-accountcreator' => '{{ns:project}}:Kontoskapare',
	'grouppage-autopatroller' => '{{ns:project}}:Autopatrullerare',
	'grouppage-founder' => '{{ns:project}}:Grundare',
	'grouppage-import' => '{{ns:project}}:Importörer',
	'grouppage-ipblock-exempt' => '{{ns:project}}:Undantagna från IP-blockering',
	'grouppage-rollbacker' => '{{ns:project}}:Tillbakarullare',
	'grouppage-transwiki' => '{{ns:project}}:Transwiki-importörer',
	'grouppage-uploader' => '{{ns:project}}:Uppladdare',
	'grouppage-bigexport' => '{{ns:project}}:Stora exporterare',
	'grouppage-abusefilter' => '{{ns:project}}:Redigerare av missbruksfilter',
	'group-steward' => 'Stewarder',
	'group-sysadmin' => 'Systemadministratörer',
	'group-Global_bot' => 'Globala robotar',
	'group-Global_rollback' => 'Globala tillbakarullare',
	'group-Ombudsmen' => 'Ombudsmän',
	'group-Staff' => 'Personal',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'systemadministratör',
	'group-Global_bot-member' => 'global robot',
	'group-Global_rollback-member' => 'global tillbakarullare',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'personal',
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
	'group-founder' => 'Zołożyćele',
	'group-import' => 'Importery',
	'group-ipblock-exempt' => 'Uprowńyńi do logowańo śe s zawartych adresůw IP',
	'group-rollbacker' => 'Uprowńyńi do wycofywańo sprowjyń',
	'group-transwiki' => 'Importery transwiki',
	'group-uploader' => 'Wćepujůncy pliki',
	'group-accountcreator-member' => 'twůrca kůnt',
	'group-autopatroller-member' => 'patrolujůncy autůmatyczńy',
	'group-founder-member' => 'zołożyćel',
	'group-import-member' => 'importer',
	'group-ipblock-exempt-member' => 'uprowńůny do logowańo śe s zawartego adresa IP',
	'group-rollbacker-member' => 'uprowńůny do wycofywańo sprowjyń',
	'group-transwiki-member' => 'importer transwiki',
	'group-uploader-member' => 'wćepujůncy pliki',
	'grouppage-accountcreator' => '{{ns:project}}:Twůrcy kůnt',
	'grouppage-autopatroller' => '{{ns:project}}:Patrolujůncy autůmatyczńy',
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
	'group-import' => 'దిగుమతిదార్లు',
	'group-ipblock-exempt' => 'ఐపీ నిరోధపు మినహాయింపులు',
	'group-uploader' => 'ఎగుమతిదార్లు',
	'group-accountcreator-member' => 'ఖాతా సృష్టికర్త',
	'group-import-member' => 'దిగుమతిదారు',
	'group-ipblock-exempt-member' => 'ఐపీ నిరోధపు మినహాయింపు',
	'grouppage-accountcreator' => '{{ns:project}}:ఖాతా సృష్టికర్తలు',
	'grouppage-import' => '{{ns:project}}:దిగుమతిదార్లు',
	'grouppage-ipblock-exempt' => '{{ns:project}}:ఐపీ నిరోధపు మినహాయింపు',
	'grouppage-uploader' => '{{ns:project}}:ఎగుమతిదార్లు',
	'group-steward' => 'స్టీవార్డులు',
	'group-sysadmin' => 'వ్యవస్థ నిర్వాహకులు',
	'group-Staff' => 'సిబ్బంది',
	'group-steward-member' => 'స్టీవార్డు',
	'group-Staff-member' => 'సిబ్బంది',
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
	'group-founder' => 'Бунёдгузорон',
	'group-import' => 'Воридкунандагон',
	'group-ipblock-exempt' => 'Истиснои қатъи дастрасии нишонаи IP',
	'group-rollbacker' => 'Вогардоникунандагон',
	'group-transwiki' => 'Воридкунандагони трансвики',
	'group-uploader' => 'Боргузорон',
	'group-accountcreator-member' => 'эҷодкунандаи ҳисоб',
	'group-autopatroller-member' => 'гаштзани худкор',
	'group-founder-member' => 'асосгузор',
	'group-import-member' => 'воридкунанда',
	'group-ipblock-exempt-member' => 'Истиснои қатъи дастрасии нишонаи интернетӣ',
	'group-rollbacker-member' => 'вогардоникунанда',
	'group-transwiki-member' => 'воридкунандаи трансвики',
	'group-uploader-member' => 'боргузор',
	'grouppage-accountcreator' => '{{ns:project}}:Созандагони ҳисоби корбарӣ',
	'grouppage-autopatroller' => '{{ns:project}}:Гаштзанони худкор',
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
	'group-founder' => 'ผู้ก่อตั้ง',
	'group-founder-member' => 'ผู้ก่อตั้ง',
	'group-uploader-member' => 'ผู้อัปโหลด',
	'group-Staff' => 'ผู้แปล',
	'group-Staff-member' => 'ทีมงาน',
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
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate',
	'sitesupport' => 'Mag-ambag',
	'tooltip-n-sitesupport' => 'Tangkilikin kami',
	'group-accountcreator' => 'Mga tagapalikha ng kuwenta/akawnt',
	'group-autopatroller' => 'Mga kusa/awtomatikong tagapatrolya (awtopatrolyador)',
	'group-founder' => 'Mga tagapagtatag',
	'group-import' => 'Mga tagapagangkat',
	'group-ipblock-exempt' => 'Mga hindi kasali sa paghaharang/paghahadlang ng IP',
	'group-rollbacker' => 'Mga tagagpagpagulong pabalik sa dati',
	'group-transwiki' => 'Mga tagapagangkat na panglipat-wiki/transwiki',
	'group-uploader' => 'Mga tagapagkarga',
	'group-accountcreator-member' => 'tagapaglikha ng kuwenta/akawnt',
	'group-autopatroller-member' => 'kusang tagapatrolya/awtopatrolyador',
	'group-founder-member' => 'tagapagtatag',
	'group-import-member' => 'tagapagangkat',
	'group-ipblock-exempt-member' => 'Hindi kasali sa pagharang/paghadlang ng IP',
	'group-rollbacker-member' => 'tagapagpagulong pabalik sa dati',
	'group-transwiki-member' => 'tagapagangkat na pangtranswiki/lipat-wiki',
	'group-uploader-member' => 'tagapagkarga',
	'grouppage-accountcreator' => '{{ns:project}}:Mga tagapaglikha ng akawnt/kuwenta',
	'grouppage-autopatroller' => '{{ns:project}}:Mga awtopatrolyador',
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
	'group-Staff' => 'Mga tauhan',
	'group-steward-member' => 'bandahali',
	'group-sysadmin-member' => 'tagapangasiwa ng sistema',
	'group-Global_bot-member' => "pandaigdigang ''bot''",
	'group-Global_rollback-member' => 'pandaigdigang tagapagpagulong pabalik sa dati',
	'group-Ombudsmen-member' => 'tanod-bayan',
	'group-Staff-member' => 'kasaping tauhan',
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
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'wikimediamessages-desc' => 'Vikimedya özel mesajları',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/Donate/tr',
	'sitesupport' => 'Bağışlar',
	'tooltip-n-sitesupport' => 'Bizi destekleyin',
	'group-accountcreator' => 'Hesap oluşturucular',
	'group-autopatroller' => 'Oto-gözetmenler',
	'group-founder' => 'Kurucular',
	'group-import' => 'İçe aktarıcılar',
	'group-ipblock-exempt' => 'IP engelleme muafiyetleri',
	'group-rollbacker' => 'Geri döndürücüler',
	'group-transwiki' => 'Vikilerarası içe aktarıcılar',
	'group-uploader' => 'Yükleyiciler',
	'group-bigexport' => 'Büyük ihraççılar',
	'group-abusefilter' => 'Suistimal filtresi editörleri',
	'group-accountcreator-member' => 'hesap oluşturucu',
	'group-autopatroller-member' => 'oto-gözetmen',
	'group-founder-member' => 'kurucu',
	'group-import-member' => 'içe aktarıcı',
	'group-ipblock-exempt-member' => 'IP engelleme muafı',
	'group-rollbacker-member' => 'geri döndürücü',
	'group-transwiki-member' => 'vikilerarası içe aktarıcı',
	'group-uploader-member' => 'yükleyici',
	'group-bigexport-member' => 'büyük ihraççı',
	'group-abusefilter-member' => 'suistimal filtresi editörü',
	'grouppage-accountcreator' => '{{ns:project}}:Hesap oluşturucular',
	'grouppage-autopatroller' => '{{ns:project}}:Oto-gözetmenler',
	'grouppage-founder' => '{{ns:project}}:Kurucular',
	'grouppage-import' => '{{ns:project}}:İçe aktarıcılar',
	'grouppage-ipblock-exempt' => '{{ns:project}}:IP engelleme muafiyeti',
	'grouppage-rollbacker' => '{{ns:project}}:Geri döndürücüler',
	'grouppage-transwiki' => '{{ns:project}}:Vikilerarası içe aktarıcılar',
	'grouppage-uploader' => '{{ns:project}}:Yükleyiciler',
	'grouppage-bigexport' => '{{ns:project}}:Büyük ihraççılar',
	'grouppage-abusefilter' => '{{ns:project}}:Suistimal filtresi editörleri',
	'group-steward' => 'Stewardlar',
	'group-sysadmin' => 'Sistem yöneticileri',
	'group-Global_bot' => 'Küresel botlar',
	'group-Global_rollback' => 'Küresel geri döndürücüler',
	'group-Ombudsmen' => 'Bağımsız hakemler',
	'group-Staff' => 'Hizmetli',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'Sistem yöneticisi',
	'group-Global_bot-member' => 'küresel bot',
	'group-Global_rollback-member' => 'küresel geri döndürücü',
	'group-Ombudsmen-member' => 'bağımsız hakem',
	'group-Staff-member' => 'Hizmetli üye',
	'grouppage-steward' => '{{ns:project}}:Stewardlar',
	'grouppage-sysadmin' => 'm:Sistem yöneticileri',
	'grouppage-Global_bot' => 'm:Küresel bot',
	'group-coder' => 'Kodlayıcılar',
	'group-coder-member' => 'kodlayıcı',
	'shared-repo-name-shared' => 'Vikipedi Commons',
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
	'group-founder' => 'Засновники',
	'group-import' => 'Імпортери',
	'group-ipblock-exempt' => 'Виключення з IP-блокувань',
	'group-rollbacker' => 'Відкочувачі',
	'group-transwiki' => 'Transwiki-імпортери',
	'group-uploader' => 'Завантажувачі',
	'group-accountcreator-member' => 'створювач облікових записів',
	'group-autopatroller-member' => 'автопатрульний',
	'group-founder-member' => 'засновник',
	'group-import-member' => 'імпортер',
	'group-ipblock-exempt-member' => 'виключення з IP-блокування',
	'group-rollbacker-member' => 'відкочувач',
	'group-transwiki-member' => 'Transwiki-імпортер',
	'group-uploader-member' => 'завантажувач',
	'grouppage-accountcreator' => '{{ns:project}}:Створювачі облікових записів',
	'grouppage-autopatroller' => '{{ns:project}}:Автопатрульні',
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
	'group-Staff' => 'Співробітники',
	'group-steward-member' => 'стюард',
	'group-sysadmin-member' => 'системний адміністратор',
	'group-Global_bot-member' => 'глобальний бот',
	'group-Global_rollback-member' => 'глобальний відкочувач',
	'group-Ombudsmen-member' => 'омбудсмен',
	'group-Staff-member' => 'співробітник',
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
	'group-founder' => 'Fondatori',
	'group-import' => 'Inportadori',
	'group-ipblock-exempt' => "Esenzioni dal bloco de l'IP",
	'group-rollbacker' => 'Ripristinadori',
	'group-transwiki' => 'Inportadori transwiki',
	'group-uploader' => 'Caricadori',
	'group-bigexport' => 'Grando esportador',
	'group-accountcreator-member' => 'Creator de account',
	'group-autopatroller-member' => 'patujador automàtego',
	'group-founder-member' => 'Fondator',
	'group-import-member' => 'Inportador',
	'group-ipblock-exempt-member' => 'esente dal bloco IP',
	'group-rollbacker-member' => 'ripristinador',
	'group-transwiki-member' => 'Inportador transwiki',
	'group-uploader-member' => 'caricador',
	'group-bigexport-member' => 'grando esportador',
	'grouppage-accountcreator' => '{{ns:project}}:Creatori de account',
	'grouppage-autopatroller' => '{{ns:project}}:Patujadori automàteghi',
	'grouppage-founder' => '{{ns:project}}:Fondatori',
	'grouppage-import' => '{{ns:project}}:Inportadori',
	'grouppage-ipblock-exempt' => "{{ns:project}}:Esenzion dal bloco de l'IP",
	'grouppage-rollbacker' => '{{ns:project}}:Ripristinadori',
	'grouppage-transwiki' => '{{ns:project}}:Inportadori transwiki',
	'grouppage-uploader' => '{{ns:project}}:Caricadori',
	'grouppage-bigexport' => '{{ns:project}}:Grandi esportadori',
	'group-steward' => 'Steward',
	'group-sysadmin' => 'Aministradori de sistema',
	'group-Global_bot' => 'Bot globali',
	'group-Global_rollback' => 'Ripristinadori globali',
	'group-Ombudsmen' => 'Ombudsman',
	'group-Staff' => 'Staff',
	'group-steward-member' => 'steward',
	'group-sysadmin-member' => 'aministrador de sistema',
	'group-Global_bot-member' => 'bot globale',
	'group-Global_rollback-member' => 'ripristinador globale',
	'group-Ombudsmen-member' => 'ombudsman',
	'group-Staff-member' => 'Menbro del staff',
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
	'group-founder' => 'Nhà sáng lập',
	'group-import' => 'Người nhập trang',
	'group-ipblock-exempt' => 'Người được miễn cấm IP',
	'group-rollbacker' => 'Người lùi sửa',
	'group-transwiki' => 'Người nhập trang giữa wiki',
	'group-uploader' => 'Người tải lên',
	'group-accountcreator-member' => 'Người mở tài khoản',
	'group-autopatroller-member' => 'tuần tra viên tự động',
	'group-founder-member' => 'Nhà sáng lập',
	'group-import-member' => 'Người nhập trang',
	'group-ipblock-exempt-member' => 'Người được miễn cấm IP',
	'group-rollbacker-member' => 'Người lùi sửa',
	'group-transwiki-member' => 'Người nhập trang giữa wiki',
	'group-uploader-member' => 'người tải lên',
	'grouppage-accountcreator' => '{{ns:project}}:Người mở tài khoản',
	'grouppage-autopatroller' => '{{ns:project}}:Tuần tra viên tự động',
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
	'group-Staff' => 'Nhân viên',
	'group-steward-member' => 'Tiếp viên',
	'group-sysadmin-member' => 'người quản lý hệ thống',
	'group-Global_bot-member' => 'robot toàn cầu',
	'group-Global_rollback-member' => 'người lùi sửa toàn cầu',
	'group-Ombudsmen-member' => 'thanh tra viên',
	'group-Staff-member' => 'Nhân viên',
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
	'group-transwiki-member' => 'nüveigan vüvükik',
	'group-uploader-member' => 'löpükan',
	'grouppage-accountcreator' => '{{ns:project}}:Kalijafans',
	'grouppage-founder' => '{{ns:project}}:Fünans',
	'grouppage-import' => '{{ns:project}}:Nüveigans',
	'grouppage-rollbacker' => '{{ns:project}}:Sädunans',
	'grouppage-uploader' => '{{ns:project}}:Löpükans',
	'group-sysadmin' => 'Sitiguvans',
	'group-sysadmin-member' => 'sitiguvan',
	'group-Global_bot-member' => 'bot valöpik',
	'group-coder' => 'Kotans',
	'group-coder-member' => 'kotan',
);

/** Võro (Võro)
 * @author Võrok
 */
$messages['vro'] = array(
	'sitesupport' => 'Tugõminõ',
	'tooltip-n-sitesupport' => 'Tukõq mi tüüd',
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
 * @author פוילישער
 */
$messages['yi'] = array(
	'sitesupport' => 'ביישטייערונגן',
	'tooltip-n-sitesupport' => 'שטיצט אונז',
	'group-import' => 'אימפארטירערס',
	'group-import-member' => 'אימפארטירער',
	'group-steward' => 'סטואַרדן',
	'group-steward-member' => 'סטואַרד',
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
	'group-founder' => '創辦人',
	'group-import' => '匯入者',
	'group-ipblock-exempt' => 'IP封鎖例外者',
	'group-rollbacker' => '反轉者',
	'group-transwiki' => 'Transwiki匯入者',
	'group-accountcreator-member' => '開戶專員',
	'group-founder-member' => '創辦人',
	'group-import-member' => '匯入者',
	'group-ipblock-exempt-member' => 'IP封鎖例外',
	'group-rollbacker-member' => '反轉者',
	'group-transwiki-member' => 'Transwiki匯入者',
	'grouppage-accountcreator' => '{{ns:project}}:開戶專員',
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

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'wikimediamessages-desc' => '维基媒体特定信息',
	'sitesupport-url' => 'http://wikimediafoundation.org/wiki/{{urlencode:赞助}}',
	'sitesupport' => '资助',
	'tooltip-n-sitesupport' => '资助我们',
	'group-accountcreator' => '账户创建员',
	'group-autopatroller' => '自动巡视员',
	'group-founder' => '创办人',
	'group-import' => '导入者',
	'group-ipblock-exempt' => 'IP查封例外者',
	'group-rollbacker' => '回退员',
	'group-transwiki' => '跨维基导入者',
	'group-uploader' => '上传文件用户',
	'group-accountcreator-member' => '账户创建员',
	'group-autopatroller-member' => '自动巡视员',
	'group-founder-member' => '创办人',
	'group-import-member' => '导入者',
	'group-ipblock-exempt-member' => 'IP查封例外',
	'group-rollbacker-member' => '回退员',
	'group-transwiki-member' => '跨维基导入者',
	'group-uploader-member' => '上传文件用户',
	'grouppage-accountcreator' => '{{ns:project}}:账户创建员',
	'grouppage-autopatroller' => '{{ns:project}}:自动巡视员',
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
	'group-Staff' => '成员',
	'group-steward-member' => '监管员',
	'group-sysadmin-member' => '系统管理员',
	'group-Global_bot-member' => '全域机器人',
	'group-Global_rollback-member' => '全域反转者',
	'group-Ombudsmen-member' => '申诉专员',
	'group-Staff-member' => '成员',
	'group-coder' => '编程人员',
	'group-coder-member' => '编程人员',
	'shared-repo-name-shared' => '维基共享资源',
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
	'group-founder' => '創辦人',
	'group-import' => '匯入者',
	'group-ipblock-exempt' => 'IP查封例外者',
	'group-rollbacker' => '回退員',
	'group-transwiki' => '跨維基匯入者',
	'group-uploader' => '上載者',
	'group-accountcreator-member' => '賬戶創建員',
	'group-founder-member' => '創辦人',
	'group-import-member' => '匯入者',
	'group-ipblock-exempt-member' => 'IP查封例外',
	'group-rollbacker-member' => '回退員',
	'group-transwiki-member' => '跨維基匯入者',
	'grouppage-accountcreator' => '{{ns:project}}:賬戶創建員',
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
	'group-Staff-member' => '成員',
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

