<?php
/**
 * Internationalisation file for Interwiki extension.
 *
 * @file
 * @ingroup Extensions
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @author Stephanie Amanda Stevens <phroziac@gmail.com>
 * @author SPQRobin <robin_1273@hotmail.com>
 * @copyright Copyright (C) 2005-2007 Stephanie Amanda Stevens
 * @copyright Copyright (C) 2007 SPQRobin
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$messages = array();

/** English (English)
 * @author Stephanie Amanda Stevens
 * @author SPQRobin
 * @author Purodha
 */
$messages['en'] = array(
	# general messages
	'interwiki' => 'View and edit interwiki data',
	'interwiki-title-norights' => 'View interwiki data',
	'interwiki-desc' => 'Adds a [[Special:Interwiki|special page]] to view and edit the interwiki table',
	'interwiki_intro' => 'This is an overview of the interwiki table. Meanings of the data in the columns:',
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix:',
	'interwiki_prefix_intro' => 'Interwiki prefix to be used in <code>[<nowiki />[prefix:<i>pagename</i>]]</code> wikitext syntax.',
	'interwiki_url' => 'URL', # only translate this message if you have to change it
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Template for URLs. The placeholder $1 will be replaced by the <i>pagename</i> of the wikitext, when the abovementioned wikitext syntax is used.',
	'interwiki_local' => 'Forward',
	'interwiki-local-label' => 'Forward:',
	'interwiki_local_intro' => 'An HTTP request to the local wiki with this interwiki prefix in the URL is:',
	'interwiki_local_0_intro' => 'not honored, usually blocked by "page not found",',
	'interwiki_local_1_intro' => 'redirected to the target URL given in the interwiki link definitions (i.e. treated like references in local pages)',
	'interwiki_trans' => 'Transclude',
	'interwiki-trans-label' => 'Transclude:',
	'interwiki_trans_intro' => 'If wikitext syntax <code>{<nowiki />{prefix:<i>pagename</i>}}</code> is used, then:',
	'interwiki_trans_1_intro' => 'allow transclusion from the foreign wiki, if interwiki transclusions are generally permitted in this wiki,',
	'interwiki_trans_0_intro' => 'do not allow it, rather look for a page in the template namespace.',
	'interwiki_intro_footer' => 'See [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] for more information about the interwiki table.
There is a [[Special:Log/interwiki|log of changes]] to the interwiki table.',
	'interwiki_1' => 'yes',
	'interwiki_0' => 'no',
	'interwiki_error' => 'Error: The interwiki table is empty, or something else went wrong.',

	# modifying permitted
	'interwiki_edit' => 'Edit',
	'interwiki_reasonfield' => 'Reason:',

	# deleting a prefix
	'interwiki_delquestion' => 'Deleting "$1"',
	'interwiki_deleting' => 'You are deleting prefix "$1".',
	'interwiki_deleted' => 'Prefix "$1" was successfully removed from the interwiki table.',
	'interwiki_delfailed' => 'Prefix "$1" could not be removed from the interwiki table.',

	# adding a prefix
	'interwiki_addtext' => 'Add an interwiki prefix',
	'interwiki_addintro' => 'You are adding a new interwiki prefix.
Remember that it cannot contain spaces ( ), colons (:), ampersands (&), or equal signs (=).',
	'interwiki_addbutton' => 'Add',
	'interwiki_added' => 'Prefix "$1" was successfully added to the interwiki table.',
	'interwiki_addfailed' => 'Prefix "$1" could not be added to the interwiki table.
Possibly it already exists in the interwiki table.',
	'interwiki_defaulturl' => 'http://www.example.com/$1', # do not translate or duplicate this message to other languages

	# editing a prefix
	'interwiki_edittext' => 'Editing an interwiki prefix',
	'interwiki_editintro' => 'You are editing an interwiki prefix.
Remember that this can break existing links.',
	'interwiki_edited' => 'Prefix "$1" was successfully modified in the interwiki table.',
	'interwiki_editerror' => 'Prefix "$1" can not be modified in the interwiki table.
Possibly it does not exist.',
	'interwiki-badprefix' => 'Specified interwiki prefix "$1" contains invalid characters',

	# interwiki log
	'interwiki_logpagename' => 'Interwiki table log',
	'interwiki_log_added' => 'added prefix "$2" ($3) (trans: $4) (local: $5) to the interwiki table',
	'interwiki_log_edited' => 'modified prefix "$2" : ($3) (trans: $4) (local: $5) in the interwiki table',
	'interwiki_log_deleted' => 'removed prefix "$2" from the interwiki table',
	'interwiki_logpagetext' => 'This is a log of changes to the [[Special:Interwiki|interwiki table]].',
	'interwiki_logentry' => '', # do not translate this message

	# rights
	'right-interwiki' => 'Edit interwiki data',
	'action-interwiki' => 'change this interwiki entry',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Meno25
 * @author Mormegil
 * @author Purodha
 * @author SPQRobin
 * @author Siebrand
 */
$messages['qqq'] = array(
	'interwiki' => 'This message is the title of the special page [[Special:Interwiki]].',
	'interwiki-title-norights' => 'Part of the interwiki extension. This message is the title of the special page [[Special:Interwiki]] when the user has no right to edit the interwiki data, so can only view them.',
	'interwiki-desc' => '{{desc}}',
	'interwiki_intro' => 'Part of the interwiki extension. Shown as introductory text on [[Special:Interwiki]].',
	'interwiki_prefix' => 'Used on [[Special:Interwiki]] as a column header of the table.',
	'interwiki-prefix-label' => 'Used on [[Special:Interwiki]] as a field label in a form.',
	'interwiki_prefix_intro' => 'Used on [[Special:Interwiki]] so as to explain the data in the {{msg-mw|interwiki_prefix}} column of the table.
Do translate both words inside the square brackets as placeholders, where "prefix" should be identical to, or clearly linked to, the column header.',
	'interwiki_url' => 'Used on [[Special:Interwiki]] as a column header of the table.',
	'interwiki-url-label' => 'Used on [[Special:Interwiki]] as a field label in a form.',
	'interwiki_url_intro' => 'Used on [[Special:Interwiki]] so as to explain the data in the {{msg-mw|interwiki_url}} column of the table.

$1 is being rendered verbatim. It rerfers to the syntax of the values listed in de "prefix" column, and does not mark a substitutible variable of this message.',
	'interwiki_local' => 'Used on [[Special:Interwiki]] as a column header.

{{Identical|Forward}}',
	'interwiki_local_intro' => 'Used on [[Special:Interwiki]] so as to explain the data in the {{msg-mw|interwiki_local}} column of the table.',
	'interwiki_local_0_intro' => 'Used on [[Special:Interwiki]] so as to descripe the meaning of the value 0 in the {{msg-mw|interwiki_local}} column of the table.',
	'interwiki_local_1_intro' => 'Used on [[Special:Interwiki]] so as to descripe the meaning of the value 1 in the {{msg-mw|interwiki_local}} column of the table.',
	'interwiki_trans' => 'Used on [[Special:Interwiki]] as table column header.',
	'interwiki-trans-label' => 'Used on [[Special:Interwiki]] as a field label in a form.',
	'interwiki_trans_intro' => 'Used on [[Special:Interwiki]] so as to explain the data in the {{msg-mw|interwiki_trans}} column of the table.',
	'interwiki_trans_1_intro' => 'Used on [[Special:Interwiki]] so as to descripe the meaning of the value 1 in the {{msg-mw|interwiki_trans}} column of the table.',
	'interwiki_trans_0_intro' => 'Used on [[Special:Interwiki]] so as to describe the meaning of the value 0 in the {{msg-mw|interwiki_trans}} column of the table.',
	'interwiki_intro_footer' => 'Part of the interwiki extension.
Shown as last pice of the introductory text on [[Special:Interwiki]].
Parameter $1 contains the following (a link): [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org]',
	'interwiki_1' => "'''Yes'''-value to be inserted into the columns headed by {{msg-mw|interwiki_local}} and {{msg-mw|interwiki_trans}}.

{{Identical|Yes}}",
	'interwiki_0' => "'''No'''-value to be inserted into the columns headed by {{msg-mw|interwiki_local}} and {{msg-mw|interwiki_trans}}.

{{Identical|No}}",
	'interwiki_error' => 'This error message is shown when the Special:Interwiki page is empty.',
	'interwiki_edit' => 'For users allowed to edit the interwiki table via [[Special:Interwiki]], this text is shown as the column header above the edit buttons.

{{Identical|Edit}}',
	'interwiki_reasonfield' => '{{Identical|Reason}}',
	'interwiki_delquestion' => 'Parameter $1 is the interwiki prefix you are deleting.',
	'interwiki_deleting' => '-',
	'interwiki_deleted' => '',
	'interwiki_addbutton' => 'This message is the text of the button to submit the interwiki prefix you are adding.

{{Identical|Add}}',
	'interwiki_editerror' => 'Error message when modifying a prefix has failed.',
	'interwiki_logpagename' => 'Part of the interwiki extension. This message is shown as page title on Special:Log/interwiki.',
	'interwiki_log_added' => 'Shows up in "Special:Log/interwiki" when someone has added a prefix. Leave parameters and text between brackets exactly as it is.',
	'interwiki_log_edited' => 'Shows up in "Special:Log/interwiki" when someone has modified a prefix. Leave parameters and text between brackets exactly as it is.',
	'interwiki_log_deleted' => 'Shows up in "Special:Log/interwiki" when someone removed a prefix.',
	'interwiki_logpagetext' => 'Part of the interwiki extension. Summary shown on Special:Log/interwiki.',
	'right-interwiki' => '{{doc-right}}',
	'action-interwiki' => '{{doc-action}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'interwiki_reasonfield' => 'Kakano',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'interwiki' => 'Bekyk en wysig interwiki data',
	'interwiki-title-norights' => 'Bekyk interwiki data',
	'interwiki-desc' => "Voeg 'n [[Special:Interwiki|spesiale bladsy]] by om die interwiki tabel te bekyk en wysig",
	'interwiki_intro' => "Hier volg 'n oorsig van die interwiki-tabel.
Betekenis van die inligting en kolomme:",
	'interwiki_prefix' => 'Voorvoegsel',
	'interwiki-prefix-label' => 'Voorvoegsel:',
	'interwiki_prefix_intro' => 'Interwiki-voorvoegsel wat gebruik moet word in die wikiteks-sintaks <code>[<nowiki />[voorvoegsel:<i>bladsynaam</i>]]</code>.',
	'interwiki_url_intro' => "'n Sjabloon vir URL's. Die plekhouer $1 word met die <i>bladsynaam</i> van die wikiteks vervang as die bovermelde wikiteks-sintaks gebruik word.",
	'interwiki_local' => 'Aanstuur',
	'interwiki-local-label' => 'Aanstuur:',
	'interwiki_local_intro' => "'n HTTP-aanvraag na die lokale wiki met hierdie interwiki-voorvoegsel in die URL is:",
	'interwiki_local_0_intro' => 'word nie verwerk nie. Meestal geblokkeer deur \'n  "bladsy nie gevind"-fout.',
	'interwiki_local_1_intro' => 'aanstuur na die doel-URL verskaf in die definisies van die interwiki-skakels (hierdie word hanteer as verwysings in lokale bladsye)',
	'interwiki_trans' => 'Transkludeer',
	'interwiki_trans_intro' => 'Indien die wikiteks-sintaks <code>{<nowiki />{voorvoegsel:<i>bladsynaam</i>}}</code> gebruik word, dan:',
	'interwiki_trans_1_intro' => "laat transklusie van ander wiki's toe as interwiki-transklusies wel in hierdie wiki toegelaat word.",
	'interwiki_trans_0_intro' => "nie toegelaat nie, soek eerder na 'n bladsy in die sjabloonnaamruimte.",
	'interwiki_intro_footer' => "Sien [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] vir meer inligting oor die interwiki-tabel.
Daar is 'n [[Special:Log/interwiki|logboek van veranderings]] vir die interwiki-tabel.",
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nee',
	'interwiki_error' => 'Fout: Die interwiki-tabel is leeg, of iets anders is verkeerd.',
	'interwiki_edit' => 'Wysig',
	'interwiki_reasonfield' => 'Rede:',
	'interwiki_delquestion' => 'Besig om "$1" te verwyder',
	'interwiki_deleting' => 'U is besig om voorvoegsel "$1" te verwyder.',
	'interwiki_deleted' => 'Voorvoegsel "$1" is suksesvol uit die interwiki-tabel verwyder.',
	'interwiki_delfailed' => 'Voorvoegsel "$1" kon nie van die interwiki-tabel verwyder word nie.',
	'interwiki_addtext' => "Voeg 'n interwiki-voorvoegsel by",
	'interwiki_addintro' => "U is besig om 'n nuwe interwiki-voorvoegsel by te voeg. Let op dat dit geen spasies ( ), dubbelpunte (:), ampersands (&), of gelykheidstekens (=) mag bevat nie.",
	'interwiki_addbutton' => 'Voeg by',
	'interwiki_added' => 'Voorvoegsel "$1" is suksesvol by die interwiki-tabel bygevoeg.',
	'interwiki_addfailed' => 'Voorvoegsel "$1" kon nie by die interwiki-tabel gevoeg word nie. Moontlik bestaan dit al reeds in die interwiki-tabel.',
	'interwiki_edittext' => "Wysig 'n interwiki-voorvoegsel",
	'interwiki_editintro' => "U is besig om 'n interwiki-voorvoegsel te wysig.
Let op dat dit moontlik bestaande skakels kan breek.",
	'interwiki_edited' => 'Voorvoegsel "$1" is suksesvol in die interwiki-tabel gewysig.',
	'interwiki_editerror' => 'Voorvoegsel "$1" kon nie in die interwiki-tabel opgedateer word nie.
Moontlik bestaan dit nie.',
	'interwiki-badprefix' => 'Die interwiki-voorvoegsel "$1" bevat ongeldige karakters',
	'interwiki_logpagename' => 'Interwiki tabel staaf',
	'interwiki_log_added' => 'voorvoegsel "$2" ($3) (trans: $4) (plaaslik: $5) is by die interwiki-tabel bygevoeg',
	'interwiki_log_edited' => 'voorvoegsel "$2": ($3) (trans: $4) (plaaslik: $5) in de interwiki-tabel gewysig',
	'interwiki_log_deleted' => 'voorvoegsel "$2" is van die interwiki-tabel verwyder',
	'interwiki_logpagetext' => "Die is 'n logboek van veranderinge aan die [[Special:Interwiki|interwiki-tabel]].",
	'right-interwiki' => 'Wysig interwiki-inligting',
	'action-interwiki' => 'verander hierdie interwiki-item',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'interwiki_reasonfield' => 'ምክንያት',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'interwiki_reasonfield' => 'Razón',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'interwiki' => 'عرض وتعديل بيانات الإنترويكي',
	'interwiki-title-norights' => 'عرض بيانات الإنترويكي',
	'interwiki-desc' => 'يضيف [[Special:Interwiki|صفحة خاصة]] لرؤية وتعديل جدول الإنترويكي',
	'interwiki_intro' => 'هذا عرض عام لجدول الإنترويكي. معاني البيانات في العواميد:',
	'interwiki_prefix' => 'بادئة',
	'interwiki-prefix-label' => 'البادئة:',
	'interwiki_prefix_intro' => 'بادئة الإنترويكي ليتم استخدامها في صياغة نص الويكي <code>[<nowiki />[prefix:<i>pagename</i>]]</code>.',
	'interwiki_url' => 'مسار',
	'interwiki-url-label' => 'مسار:',
	'interwiki_url_intro' => 'قالب للمسارات. حامل المكان $1 سيتم استبداله بواسطة <i>pagename</i> لنص الويكي، عندما يتم استخدام صياغة نص الويكي المذكورة بالأعلى.',
	'interwiki_local' => 'إرسال',
	'interwiki-local-label' => 'إرسال:',
	'interwiki_local_intro' => 'طلب http للويكي المحلي ببادئة الإنترويكي هذه في URl هو:',
	'interwiki_local_0_intro' => 'لا يتم أخذها في الاعتبار، عادة يتم المنع بواسطة "page not found"،',
	'interwiki_local_1_intro' => 'يتم التحويل للمسار الهدف المعطى في تعريفات وصلة الإنترويكي (أي تتم معاملتها مثل المراجع في الصفحات المحلية)',
	'interwiki_trans' => 'تضمين',
	'interwiki-trans-label' => 'تضمين:',
	'interwiki_trans_intro' => 'لو أن صياغة نص الويكي <code>{<nowiki />{prefix:<i>pagename</i>}}</code> تم استخدامها، إذا:',
	'interwiki_trans_1_intro' => 'يسمح بالتضمين من الويكي الأجنبي، لو أن تضمينات الإنترويكي مسموح بها عموما في هذا الويكي،',
	'interwiki_trans_0_intro' => 'لا تسمح به، ولكن ابحث عن صفحة في نطاق القوالب.',
	'interwiki_intro_footer' => 'انظر [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] للمزيد من المعلومات حول جدول الإنترويكي.
هناك [[Special:Log/interwiki|سجل بالتغييرات]] لجدول الإنترويكي.',
	'interwiki_1' => 'نعم',
	'interwiki_0' => 'لا',
	'interwiki_error' => 'خطأ: جدول الإنترويكي فارغ، أو حدث خطأ آخر.',
	'interwiki_edit' => 'عدل',
	'interwiki_reasonfield' => 'السبب:',
	'interwiki_delquestion' => 'حذف "$1"',
	'interwiki_deleting' => 'أنت تحذف البادئة "$1".',
	'interwiki_deleted' => 'البادئة "$1" تمت إزالتها بنجاح من جدول الإنترويكي.',
	'interwiki_delfailed' => 'البادئة "$1" لم يمكن إزالتها من جدول الإنترويكي.',
	'interwiki_addtext' => 'أضف بادئة إنترويكي',
	'interwiki_addintro' => 'أنت تضيف بادئة إنترويكي جديدة.
تذكر أنها لا يمكن أن تحتوي على مسافات ( )، نقطتين فوق بعض (:)، علامة و (&)، أو علامة يساوي (=).',
	'interwiki_addbutton' => 'أضف',
	'interwiki_added' => 'البادئة "$1" تمت إضافتها بنجاح إلى جدول الإنترويكي.',
	'interwiki_addfailed' => 'البادئة "$1" لم يمكن إضافتها إلى جدول الإنترويكي.
على الأرجح هي موجودة بالفعل في جدول الإنترويكي.',
	'interwiki_edittext' => 'تعديل بادئة إنترويكي',
	'interwiki_editintro' => 'أنت تعدل بادئة إنترويكي موجودة.
تذكر أن هذا يمكن أن يكسر الوصلات الحالية.',
	'interwiki_edited' => 'البادئة "$1" تم تعديلها بنجاح في جدول الإنترويكي..',
	'interwiki_editerror' => 'البادئة "$1" لم يمكن تعديلها في جدول الإنترويكي.
من المحتمل أنها غير موجودة.',
	'interwiki-badprefix' => 'بادئة إنترويكي محددة "$1" تحتوي أحرفا غير صحيحة',
	'interwiki_logpagename' => 'سجل جدول الإنترويكي',
	'interwiki_log_added' => 'أضاف "$2" ($3) (نقل: $4) (محلي: $5) إلى جدول الإنترويكي',
	'interwiki_log_edited' => 'عدل البادئة "$2" : ($3) (عابر: $4) (محلي: $5) في جدول الإنترويكي',
	'interwiki_log_deleted' => 'أزال البادئة "$2" من جدول الإنترويكي',
	'interwiki_logpagetext' => 'هذا سجل بالتغييرات في [[Special:Interwiki|جدول الإنترويكي]].',
	'right-interwiki' => 'تعديل بيانات الإنترويكي',
	'action-interwiki' => 'تغيير مدخلة الإنترويكي هذه',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'interwiki' => 'عرض وتعديل بيانات الإنترويكي',
	'interwiki-title-norights' => 'عرض بيانات الإنترويكي',
	'interwiki-desc' => 'يضيف [[Special:Interwiki|صفحة خاصة]] لرؤية وتعديل جدول الإنترويكي',
	'interwiki_intro' => 'هذا عرض عام لجدول الإنترويكى. معانى البيانات فى العواميد:',
	'interwiki_prefix' => 'بادئة',
	'interwiki-prefix-label' => 'بادئة:',
	'interwiki_prefix_intro' => 'بادئة الإنترويكى ليتم استخدامها فى صياغة نص الويكى <code>[<nowiki />[prefix:<i>pagename</i>]]</code>.',
	'interwiki_url_intro' => 'قالب للمسارات. حامل المكان $1 سيتم استبداله بواسطة <i>pagename</i> لنص الويكى، عندما يتم استخدام صياغة نص الويكى المذكورة بالأعلى.',
	'interwiki_local' => 'إرسال',
	'interwiki-local-label' => 'إرسال:',
	'interwiki_local_intro' => 'طلب http للويكى المحلى ببادئة الإنترويكى هذه فى URl هو:',
	'interwiki_local_0_intro' => 'لا يتم أخذها فى الاعتبار، عادة يتم المنع بواسطة "page not found"،',
	'interwiki_local_1_intro' => 'يتم التحويل للمسار الهدف المعطى فى تعريفات وصلة الإنترويكى (أى تتم معاملتها مثل المراجع فى الصفحات المحلية)',
	'interwiki_trans' => 'تضمين',
	'interwiki-trans-label' => 'تضمين:',
	'interwiki_trans_intro' => 'لو أن صياغة نص الويكى <code>{<nowiki />{prefix:<i>pagename</i>}}</code> تم استخدامها، إذا:',
	'interwiki_trans_1_intro' => 'يسمح بالتضمين من الويكى الأجنبى، لو أن تضمينات الإنترويكى مسموح بها عموما فى هذا الويكى،',
	'interwiki_trans_0_intro' => 'لا تسمح به، ولكن ابحث عن صفحة فى نطاق القوالب.',
	'interwiki_intro_footer' => 'انظر [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] للمزيد من المعلومات حول جدول الإنترويكى.
هناك [[Special:Log/interwiki|سجل بالتغييرات]] لجدول الإنترويكى.',
	'interwiki_1' => 'نعم',
	'interwiki_0' => 'لا',
	'interwiki_error' => 'خطأ: جدول الإنترويكى فارغ، أو حدث خطأ آخر.',
	'interwiki_edit' => 'عدل',
	'interwiki_reasonfield' => 'سبب:',
	'interwiki_delquestion' => 'حذف "$1"',
	'interwiki_deleting' => 'أنت تحذف البادئة "$1".',
	'interwiki_deleted' => 'البادئة "$1" تمت إزالتها بنجاح من جدول الإنترويكى.',
	'interwiki_delfailed' => 'البادئة "$1" لم يمكن إزالتها من جدول الإنترويكى.',
	'interwiki_addtext' => 'أضف بادئة إنترويكي',
	'interwiki_addintro' => 'أنت تضيف بادئة إنترويكى جديدة.
تذكر أنها لا يمكن أن تحتوى على مسافات ( )، نقطتين فوق بعض (:)، علامة و (&)، أو علامة يساوى (=).',
	'interwiki_addbutton' => 'إضافة',
	'interwiki_added' => 'البادئة "$1" تمت إضافتها بنجاح إلى جدول الإنترويكى.',
	'interwiki_addfailed' => 'البادئة "$1" لم يمكن إضافتها إلى جدول الإنترويكى.
على الأرجح هى موجودة بالفعل فى جدول الإنترويكى.',
	'interwiki_edittext' => 'تعديل بادئة إنترويكي',
	'interwiki_editintro' => 'أنت تعدل بادئة إنترويكى موجودة.
تذكر أن هذا يمكن أن يكسر الوصلات الحالية.',
	'interwiki_edited' => 'البادئة "$1" تم تعديلها بنجاح فى جدول الإنترويكى..',
	'interwiki_editerror' => 'البادئة "$1" لم يمكن تعديلها فى جدول الإنترويكى.
من المحتمل أنها غير موجودة.',
	'interwiki-badprefix' => 'بادئة إنترويكى محددة "$1" فيها حروف مش صحيحة',
	'interwiki_logpagename' => 'سجل جدول الإنترويكي',
	'interwiki_log_added' => 'أضاف "$2" ($3) (نقل: $4) (محلي: $5) إلى جدول الإنترويكي',
	'interwiki_log_edited' => 'عدل البادئة "$2" : ($3) (عابر: $4) (محلي: $5) فى جدول الإنترويكي',
	'interwiki_log_deleted' => 'أزال البادئة "$2" من جدول الإنترويكي',
	'interwiki_logpagetext' => 'هذا سجل بالتغييرات فى [[Special:Interwiki|جدول الإنترويكي]].',
	'right-interwiki' => 'تعديل بيانات الإنترويكي',
	'action-interwiki' => 'تغيير مدخلة الإنترويكى هذه',
);

/** Kotava (Kotava)
 * @author Wikimistusik
 */
$messages['avk'] = array(
	'interwiki' => "Wira va 'interwiki' orig isu betara",
	'interwiki-title-norights' => "Wira va 'interwiki' orig",
	'interwiki-desc' => "Batcoba, ta wira va 'interwiki' origak isu betara, va [[Special:Interwiki|aptafu bu]] loplekur",
	'interwiki_intro' => "Ta lo giva icde 'interwiki' origak va [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] wil !
Batcoba tir [[Special:Log/interwiki|'log' dem betaks]] va 'interwiki' origak.",
	'interwiki_prefix' => 'Abdueosta',
	'interwiki-prefix-label' => 'Abdueosta:',
	'interwiki_error' => "ROKLA : 'Interwiki' origak tir vlardaf oke rotaca al sokir.",
	'interwiki_reasonfield' => 'Lazava',
	'interwiki_delquestion' => 'Sulara va "$1"',
	'interwiki_deleting' => 'Rin va "$1" abdueosta dun sulal.',
	'interwiki_deleted' => '"$1" abdueosta div \'interwiki\' origak al zo tioltenher.',
	'interwiki_delfailed' => '"$1" abdueosta div \'interwiki\' origak me zo rotiolter.',
	'interwiki_addtext' => "Loplekura va 'interwiki' abdueosta",
	'interwiki_addintro' => "Rin va warzafa 'interwiki' abdueosta dun loplekul.
Me vulkul da bata va darka ( ) ik briva (:) ik 'ampersand' (&) ik miltastaa (=) me roruldar.",
	'interwiki_addbutton' => 'Loplekura',
	'interwiki_added' => '"$1" abdueosta ko \'interwiki\' origak al zo loplekunhur.',
	'interwiki_addfailed' => '"$1" abdueosta ko \'interwiki\' origak me zo roloplekur.
Rotir koeon ixam tir.',
	'interwiki_edittext' => "Betara va 'interwiki' abdueosta",
	'interwiki_editintro' => "Rin va 'interwiki' abdueosta dun betal.
Me vulkul da batcoba va kruldesi gluyasiki rotempar !",
	'interwiki_edited' => '"$1" abdueosta koe \'interwiki\' origak al zo betanhar.',
	'interwiki_editerror' => '"$1" abdueosta koe \'interwiki\' origak me zo robetar.
Rotir koeon me krulder.',
	'interwiki_logpagename' => "'Interwiki' origak 'log'",
	'interwiki_log_added' => '"$2" abdueosta ($3) (trans: $4) (local: $5) loplekuyuna ko \'interwiki\' origak',
	'interwiki_log_edited' => '"$2" abdueosta ($3) (trans: $4) (local: $5) betayana koe \'interwiki\' origak',
	'interwiki_log_deleted' => '"$2" abdueosta plekuyuna div \'interwiki\' origak',
	'interwiki_logpagetext' => "Batcoba tir 'log' dem betaks va [[Special:Interwiki|'interwiki' origak]].",
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'interwiki' => 'Прагляд і рэдагаваньне зьвестак пра інтэрвікі',
	'interwiki-title-norights' => 'Прагляд зьвестак пра інтэрвікі',
	'interwiki-desc' => 'Дадае [[Special:Interwiki|службовую старонку]] для прагляду і рэдагаваньня табліцы інтэрвікі.',
	'interwiki_intro' => 'Гэта апісаньне табліцы інтэрвікі. Сэнс зьвестак у слупках:',
	'interwiki_prefix' => 'Прэфікс',
	'interwiki-prefix-label' => 'Прэфікс:',
	'interwiki_prefix_intro' => 'Прэфікс інтэрвікі, які будзе выкарыстоўвацца ў сынтаксісе <code>[<nowiki />[prefix:<i>назва старонкі</i>]]</code>.',
	'interwiki_url_intro' => 'Шаблён для URL-адрасоў. Сымбаль $1 будзе заменены <i>назвай старонкі</i> вікі-тэксту, калі будзе ўжывацца вышэйпазначаны сынтаксіс вікі-тэксту.',
	'interwiki_local' => 'Так/Не',
	'interwiki-local-label' => 'Перасылка:',
	'interwiki_local_intro' => 'HTTP-запыт да лякальнай вікі з гэтым прэфіксам інтэрвікі ў URL-адрасе:',
	'interwiki_local_0_intro' => 'ігнаруюцца, звычайна блякуюцца з дапамогай «старонка ня знойдзена»,',
	'interwiki_local_1_intro' => 'перанакіраваньне на мэтавую URL-спасылку пададзенае ў вызначэньнях інтэрвікі-спасылак (разглядаецца як спасылкі ў лякальных старонках)',
	'interwiki_trans' => 'Трансклюзія',
	'interwiki-trans-label' => 'Трансклюзія:',
	'interwiki_trans_intro' => 'Калі выкарыстоўваецца сынтаксіс вікі-тэксту <code>{<nowiki />{prefix:<i>назва старонкі</i>}}</code>, тады:',
	'interwiki_trans_1_intro' => 'дазваляе трансклюзію зь іншай вікі, калі трансклюзія інтэрвікі дазволена ў гэтай вікі,',
	'interwiki_trans_0_intro' => 'не дазваляе гэта, замест шукаць старонку ў прасторы назваў шаблёнаў.',
	'interwiki_intro_footer' => 'Для дадатковай інфармацыі пра табліцу інтэрвікі глядзіце [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org].
Тут знаходзіцца [[Special:Log/interwiki|журнал зьменаў]] табліцы інтэрвікі.',
	'interwiki_1' => 'так',
	'interwiki_0' => 'не',
	'interwiki_error' => 'Памылка: табліца інтэрвікі пустая альбо ўзьніклі іншыя праблемы.',
	'interwiki_edit' => 'Рэдагаваць',
	'interwiki_reasonfield' => 'Прычына:',
	'interwiki_delquestion' => 'Выдаленьне «$1»',
	'interwiki_deleting' => 'Вы выдаляеце прэфікс «$1».',
	'interwiki_deleted' => 'Прэфікс «$1» быў пасьпяхова выдалены з табліцы інтэрвікі.',
	'interwiki_delfailed' => 'Прэфікс «$1» ня можа быць выдалены з табліцы інтэрвікі.',
	'interwiki_addtext' => 'Дадаць прэфікс інтэрвікі',
	'interwiki_addintro' => "Вы дадаеце новы прэфікс інтэрвікі.
Памятайце, што ён ня можа ўтрымліваць прабелы ( ), двукроп'і (:), ампэрсанды (&), ці знакі роўнасьці (=).",
	'interwiki_addbutton' => 'Дадаць',
	'interwiki_added' => 'Прэфікс «$1» быў пасьпяхова дададзены да табліцы інтэрвікі.',
	'interwiki_addfailed' => 'Прэфікс «$1» ня можа быць дададзены да табліцы інтэрвікі.
Верагодна ён ужо ёсьць у табліцы інтэрвікі.',
	'interwiki_edittext' => 'Рэдагаваньне прэфікса інтэрвікі',
	'interwiki_editintro' => 'Вы рэдагуеце прэфікс інтэрвікі.
Памятайце, гэта можа сапсаваць існуючыя спасылкі.',
	'interwiki_edited' => 'Прэфікс «$1» быў пасьпяхова зьменены ў табліцы інтэрвікі.',
	'interwiki_editerror' => 'Прэфікс «$1» ня можа быць зьменены ў табліцы інтэрвікі.
Верагодна ён не існуе.',
	'interwiki-badprefix' => 'Пазначаны прэфікс інтэрвікі «$1» утрымлівае няслушныя сымбалі',
	'interwiki_logpagename' => 'Журнал зьменаў табліцы інтэрвікі',
	'interwiki_log_added' => 'прэфікс «$2» ($3) (trans: $4) (local: $5) дададзены ў табліцу інтэрвікі',
	'interwiki_log_edited' => 'зьменены прэфікс «$2» : ($3) (trans: $4) (local: $5) у табліцы інтэрвікі',
	'interwiki_log_deleted' => 'прэфікс «$2» выдалены з табліцы інтэрвікі',
	'interwiki_logpagetext' => 'Гэта журнал зьменаў [[Special:Interwiki|табліцы інтэрвікі]].',
	'right-interwiki' => 'Рэдагаваньне зьвестак інтэрвікі',
	'action-interwiki' => 'зьмяніць гэты элемэнт інтэрвікі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'interwiki' => 'Преглед и управление на междууикитата',
	'interwiki-title-norights' => 'Преглед на данните за междууикита',
	'interwiki-desc' => 'Добавя [[Special:Interwiki|специална страница]] за преглед и управление на таблицата с междууикита',
	'interwiki_intro' => 'Вижте [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] за повече информация относно таблицата с междууикита. Съществува [[Special:Log/interwiki|дневник на промените]] в таблицата с междууикита.',
	'interwiki_prefix' => 'Представка:',
	'interwiki-prefix-label' => 'Представка::',
	'interwiki_local' => 'Локално',
	'interwiki-local-label' => 'Локално:',
	'interwiki_1' => 'да',
	'interwiki_0' => 'не',
	'interwiki_error' => 'ГРЕШКА: Таблицата с междууикита е празна или е възникнала друга грешка.',
	'interwiki_edit' => 'Редактиране',
	'interwiki_reasonfield' => 'Причина',
	'interwiki_delquestion' => 'Изтриване на "$1"',
	'interwiki_deleting' => 'Изтриване на представката „$1“.',
	'interwiki_deleted' => '„$1“ беше успешно премахнато от таблицата с междууикита.',
	'interwiki_delfailed' => '„$1“ не може да бъде премахнато от таблицата с междууикита.',
	'interwiki_addtext' => 'Добавяне на ново междууики',
	'interwiki_addintro' => "''Забележка:'' Междууикитата не могат да съдържат интервали ( ), двуеточия (:), амперсанд (&) или знак за равенство (=).",
	'interwiki_addbutton' => 'Добавяне',
	'interwiki_added' => '„$1“ беше успешно добавено в таблицата с междууикита.',
	'interwiki_addfailed' => '„$1“ не може да бъде добавено в таблицата с междууикита. Възможно е вече да е било добавено там.',
	'interwiki_edittext' => 'Редактиране на междууики представка',
	'interwiki_edited' => 'Представката „$1“ беше успешно променена в таблицата с междууикита.',
	'interwiki_logpagename' => 'Дневник на междууикитата',
	'interwiki_log_added' => 'добави „$2“ ($3) (trans: $4) (локално: $5) в таблицата с междууикита',
	'interwiki_log_deleted' => 'Премахна представката „$2“ от таблицата с междууикитата',
	'interwiki_logpagetext' => 'Тази страница съдържа дневник на промените в [[Special:Interwiki|таблицата с междууикита]].',
	'right-interwiki' => 'Редактиране на междууикитата',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'interwiki' => 'Gwelet hag aozañ ar roadennoù interwiki',
	'interwiki-title-norights' => 'Gwelet ar roadennoù interwiki',
	'interwiki_prefix' => 'Rakger',
	'interwiki-prefix-label' => 'Rakger :',
	'interwiki_local' => 'Treuzkas',
	'interwiki-local-label' => 'Treuzkas :',
	'interwiki_trans' => 'Ebarzhiñ',
	'interwiki-trans-label' => 'Treuzkludañ :',
	'interwiki_1' => 'ya',
	'interwiki_0' => 'ket',
	'interwiki_error' => 'Fazi : goullo eo an daolenn interwiki, pe un dra bennak all zo aet a-dreuz.',
	'interwiki_edit' => 'Aozañ',
	'interwiki_reasonfield' => 'Abeg :',
	'interwiki_delquestion' => 'O tilemel « $1 »',
	'interwiki_deleting' => "Emaoc'h o tilemel ar rakger « $1 ».",
	'interwiki_deleted' => 'Lamet eo bet ar rakger « $1 » eus an daolenn interwiki.',
	'interwiki_addtext' => 'Ouzhpennañ ur rakger interwiki',
	'interwiki_addbutton' => 'Ouzhpennañ',
	'interwiki_edittext' => "Oc'h aozañ ur rakger interwiki",
	'interwiki_editintro' => "Emaoc'h oc'h aozañ ur rakger interwiki.
Ho pezet soñj e c'hall an dra-se terriñ liammoù zo anezho dija.",
	'interwiki_edited' => 'Ar rakger « $1 » zo bet kemmet en daolenn interwiki.',
	'interwiki_editerror' => "Ar rakger « $1 » ne c'hall ket bezañ kemmet en daolenn interwiki.
Marteze n'eus ket anezhañ.",
	'interwiki-badprefix' => 'Arouezennoù direizh zo er rakger interwiki « $1 »',
	'interwiki_logpagename' => 'Deizlevr an daolenn interwiki',
	'interwiki_log_deleted' => 'en deus lamet ar rakger « $2 » eus an daolenn interwiki',
	'right-interwiki' => 'Aozañ ar roadennoù interwiki',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Kal-El
 */
$messages['bs'] = array(
	'interwiki' => 'Vidi i uredi međuwiki podatke',
	'interwiki-title-norights' => 'Pregled interwiki podataka',
	'interwiki-desc' => 'Dodaje [[Special:Interwiki|posebnu stranicu]] za pregled i uređivanje interwiki tabele',
	'interwiki_intro' => 'Ovo je pregled interwiki tabele. Značenja podataka u kolonama:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_prefix_intro' => 'Međuwiki prefiks koji se koristi u <code>[<nowiki />[prefix:<i>pagename</i>]]</code> wikitekst sintaksi.',
	'interwiki_url' => 'URL',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Šablon za URLove. Šablon $1 će biti zamijenjen sa <i>pagename</i> wikiteksta, ako je gore spomenuta sintaksa wikiteksta korištena.',
	'interwiki_local' => 'naprijed',
	'interwiki-local-label' => 'Naprijed:',
	'interwiki_local_intro' => 'Http zahtjev na lokalnu wiki sa ovim interwiki prefiksom u URl je:',
	'interwiki_local_0_intro' => 'nije privilegovano, obično blokirano putem "stranica nije nađena",',
	'interwiki_local_1_intro' => 'preusmjeravanje na ciljnu URL koja je navedena putem interwiki definicije (tj. tretira se poput referenci na lokalnim stranicama)',
	'interwiki_trans' => 'Uključenja',
	'interwiki-trans-label' => 'Uključenja:',
	'interwiki_trans_intro' => 'Ako se koristi wikitekst sintaksa <code>{<nowiki />{prefix:<i>pagename</i>}}</code>, onda:',
	'interwiki_trans_1_intro' => 'dopuštena uključenja iz inostrane wiki, ako su međuwiki uključenja općenito dopuštena u ovoj wiki,',
	'interwiki_trans_0_intro' => 'nisu dopuštena, radije treba tražiti stranice u imenskom prostoru šablona.',
	'interwiki_intro_footer' => 'Pogledaje [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] za više informacija o interwiki tabeli.
Postoji [[Special:Log/interwiki|zapisnik izmjena]] na interwiki tabeli.',
	'interwiki_1' => 'da',
	'interwiki_0' => 'ne',
	'interwiki_error' => 'Greška: interwiki tabela je prazna ili je nešto drugo pogrešno.',
	'interwiki_edit' => 'Uredi',
	'interwiki_reasonfield' => 'Razlog:',
	'interwiki_delquestion' => 'Briše se "$1"',
	'interwiki_deleting' => 'Brišete prefiks "$1".',
	'interwiki_deleted' => 'Prefiks "$1" je uspješno uklonjen iz interwiki tabele.',
	'interwiki_delfailed' => 'Prefiks "$1" nije bilo moguće ukloniti iz interwiki tabele.',
	'interwiki_addtext' => 'Dodaj interwiki prefiks',
	'interwiki_addintro' => 'Dodajete novi interwiki prefiks.
Zapamtite da ne može sadržavati razmake ( ), dvotačke (:), znak and (&), ili znakove jednakosti (=).',
	'interwiki_addbutton' => 'Dodaj',
	'interwiki_added' => 'Prefiks "$1" je uspješno dodat u interwiki tabelu.',
	'interwiki_addfailed' => 'Prefiks "$1" nije bilo moguće dodati u interwiki tabelu.
Moguće je da već postoji u interwiki tabeli.',
	'interwiki_edittext' => 'Uređivanje interwiki prefiksa',
	'interwiki_editintro' => 'Uređujete interwiki prefiks.
Zapamtite da ovo može poremetiti postojeće linkove.',
	'interwiki_edited' => 'Prefiks "$1" je uspješno izmijenjen u interwiki tabeli.',
	'interwiki_editerror' => 'Prefiks "$1" ne može biti izmijenjen u interwiki tabeli.
Moguće je da uopće ne postoji.',
	'interwiki-badprefix' => 'Navedeni interwiki prefiks "$1" sadrži nevaljane znakove',
	'interwiki_logpagename' => 'Zapisnik tabele interwikija',
	'interwiki_log_added' => 'dodat prefiks "$2" ($3) (trans: $4) (local: $5) u interwiki tabelu',
	'interwiki_log_edited' => 'izmijenjen prefiks "$2" : ($3) (trans: $4) (local: $5) u interwiki tabeli',
	'interwiki_log_deleted' => 'uklonjen prefiks "$2" iz interwiki tabele',
	'interwiki_logpagetext' => 'Ovo je zapisnik izmjena na [[Special:Interwiki|interwiki tabeli]].',
	'right-interwiki' => 'Uređivanje interwiki podataka',
	'action-interwiki' => 'mijenjate ovu stavku interwikija',
);

/** Catalan (Català)
 * @author SMP
 * @author Solde
 * @author Ssola
 */
$messages['ca'] = array(
	'interwiki_1' => 'sí',
	'interwiki_0' => 'no',
	'interwiki_edit' => 'Modifica',
	'interwiki_reasonfield' => 'Motiu',
	'interwiki_delquestion' => "S'està eliminant «$1»",
);

/** Czech (Česky)
 * @author Danny B.
 * @author Mormegil
 */
$messages['cs'] = array(
	'interwiki' => 'Zobrazit a upravovat interwiki',
	'interwiki-title-norights' => 'Zobrazit interwiki',
	'interwiki-desc' => 'Přidává [[Special:Interwiki|speciální stránku]], na které lze prohlížet a editovat tabulku interwiki',
	'interwiki_intro' => 'Toto je přehled tabulky interwiki odkazů. Významy dat ve sloupcích:',
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix:',
	'interwiki_prefix_intro' => 'Interwiki prefix používaný v syntaxi wikitextu <code>[<nowiki />[prefix:<i>stránka</i>]]</code>.',
	'interwiki_url_intro' => 'Vzor pro URL. Místo $1 se vloží <i>stránka</i> z wikitextu uvedeného v příkladu výše.',
	'interwiki_local' => 'Přesměrovat',
	'interwiki-local-label' => 'Přesměrovat:',
	'interwiki_local_intro' => 'HTTP požadavek na tuto wiki s tímto interwiki prefixem v URL je:',
	'interwiki_local_0_intro' => 'odmítnut, zpravidla s výsledkem „stránka nenalezena“,',
	'interwiki_local_1_intro' => 'přesměrován na cílové URL podle definice v tabulce interwiki odkazů (tj. chová se jako odkazy v lokálních stránkách)',
	'interwiki_trans' => 'Transkluze',
	'interwiki-trans-label' => 'Transkluze:',
	'interwiki_trans_intro' => 'Při použití syntaxe wikitextu <code>{<nowiki />{prefix:<i>stránka</i>}}</code>:',
	'interwiki_trans_1_intro' => 'umožnit vložení z druhé wiki, pokud je interwiki transkluze na této wiki obecně povolena,',
	'interwiki_trans_0_intro' => 'to nedovolit, místo toho použít stránku ve jmenném prostoru šablon.',
	'interwiki_intro_footer' => 'Více informací o tabulce interwiki najdete na [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org].
Existuje také [[Special:Log/interwiki|protokol změn]] tabulky interwiki.',
	'interwiki_1' => 'ano',
	'interwiki_0' => 'ne',
	'interwiki_error' => 'CHYBA: Interwiki tabulka je prázdná anebo se pokazilo něco jiného.',
	'interwiki_edit' => 'Editovat',
	'interwiki_reasonfield' => 'Důvod:',
	'interwiki_delquestion' => 'Mazání „$1“',
	'interwiki_deleting' => 'Mažete prefix „$1“.',
	'interwiki_deleted' => 'Prefix „$1“ byl úspěšně odstraněn z tabulky interwiki.',
	'interwiki_delfailed' => 'Prefix „$1“ nebylo možné odstranit z tabulky interwiki.',
	'interwiki_addtext' => 'Přidat interwiki prefix',
	'interwiki_addintro' => 'Přidáváte nový interwiki prefix.
Mějte na vědomí, že nemůže obsahovat mezery ( ), dvojtečky (:), ampersandy (&), ani rovnítka (=).',
	'interwiki_addbutton' => 'Přidat',
	'interwiki_added' => 'Prefix „$1“ byl úspěšně přidán do tabulky interwiki.',
	'interwiki_addfailed' => 'Prefix „$1“ nemohl být přidán do tabulky interwiki.
Pravděpodobně tam již existuje.',
	'interwiki_edittext' => 'Editace interwiki prefixu',
	'interwiki_editintro' => 'Editujete interwiki prefix.
Mějte na vědomí, že to může znefunkčnit existující odkazy.',
	'interwiki_edited' => 'Prefix „$1“ v tabulce interwiki byl úspěšně modifikován.',
	'interwiki_editerror' => 'Prefix „$1“ v tabulce interwiki nemohl být modifikován.
Pravděpodobně neexistuje.',
	'interwiki-badprefix' => 'Uvedený interwiki prefix „$1“ obsahuje nepovolený znak',
	'interwiki_logpagename' => 'Kniha změn tabulky interwiki',
	'interwiki_log_added' => 'přidal prefix „$2“ ($3) (trans: $4) (local: $5) do tabulky interwiki',
	'interwiki_log_edited' => 'změnil prefix „$2“ : ($3) (trans: $4) (local: $5) v tabulce interwiki',
	'interwiki_log_deleted' => 'odstranil prefix „$2“ z tabulky interwiki',
	'interwiki_logpagetext' => 'Toto je seznam změn [[Special:Interwiki|tabulky interwiki]].',
	'right-interwiki' => 'Editování interwiki záznamů',
	'action-interwiki' => 'změnit tento záznam interwiki',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'interwiki' => 'Gweld a golygu data rhyngwici',
	'interwiki-title-norights' => 'Gweld y data rhyngwici',
	'interwiki_prefix' => 'Rhagddodiad',
	'interwiki-prefix-label' => 'Rhagddodiad:',
	'interwiki_local' => 'Anfon ymlaen',
	'interwiki-local-label' => 'Anfon ymlaen:',
	'interwiki_trans' => 'Trawsgynnwys',
	'interwiki-trans-label' => 'Trawsgynnwys:',
	'interwiki_intro_footer' => "Cewch ragor o wybodaeth am y tabl rhyngwici ar [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org].
Cofnodir newidiadau i'r tabl rhyngwici ar y [[Special:Log/interwiki|lòg newidiadau]].",
	'interwiki_1' => 'gellir',
	'interwiki_0' => 'ni ellir',
	'interwiki_edit' => 'Golygu',
	'interwiki_reasonfield' => 'Rheswm:',
	'interwiki_addtext' => 'Ychwanegu rhagddodiad rhyngwici',
	'interwiki_addintro' => 'Rydych yn ychwanegu rhagddodiad rhyngwici newydd.
Cofiwch na all gynnwys bwlch ( ), gorwahannod (:), ampersand (&), na hafalnod (=).',
	'interwiki_addbutton' => 'Ychwaneger',
	'interwiki_added' => 'Llwyddwyd i ychwanegu\'r rhagddodiad "$1" at y tabl rhyngwici.',
	'interwiki_addfailed' => 'Methwyd ychwanegu\'r rhagddodiad "$1" at y tabl rhyngwici.
Efallai ei fod eisoes yn y tabl rhyngwici.',
	'right-interwiki' => 'Golygu data rhyngwici',
	'action-interwiki' => 'newid yr eitem rhyngwici hwn',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 * @author Purodha
 */
$messages['da'] = array(
	'interwiki_local' => '(local)',
	'interwiki-local-label' => '(local):',
	'interwiki_trans' => '(trans)',
	'interwiki-trans-label' => '(trans):',
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nej',
	'interwiki_reasonfield' => 'Begrundelse:',
	'action-interwiki' => 'ændre dette interwiki-element',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Church of emacs
 * @author MF-Warburg
 * @author Metalhead64
 * @author Purodha
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'interwiki' => 'Interwiki-Daten betrachten und bearbeiten',
	'interwiki-title-norights' => 'Interwiki-Daten betrachten',
	'interwiki-desc' => '[[Special:Interwiki|Spezialseite]] zur Pflege der Interwiki-Tabelle',
	'interwiki_intro' => 'Dies ist ein Überblick des Inhalts der Interwiki-Tabelle.
Die Daten in den einzelnen Spalten haben die folgende Bedeutung:',
	'interwiki_prefix' => 'Präfix',
	'interwiki-prefix-label' => 'Präfix:',
	'interwiki_prefix_intro' => 'Interwiki-Präfix zur Verwendung in der Form <code>[<nowiki />[präfix:<i>Seitenname</i>]]</code> im Wikitext.',
	'interwiki_url_intro' => 'Muster für URLs. Der Platzhalter $1 wird bei der Verwendung durch <i>Seitenname</i> aus der oben genannten Syntax im Wikitext ersetzt.',
	'interwiki_local' => 'Als lokales Wiki definiert',
	'interwiki-local-label' => 'Als lokales Wiki definiert:',
	'interwiki_local_intro' => 'Eine HTTP-Anfrage an das lokale Wiki mit diesem Interwiki-Präfix in der URL wird:',
	'interwiki_local_0_intro' => 'nicht erfüllt, sondern normalerweise mit „Seite nicht gefunden“ blockiert',
	'interwiki_local_1_intro' => 'automatisch auf die Ziel-URL in der Interwikilink-Definitionen weitergeleitet (d. h. behandelt wie ein Interwikilink innerhalb einer lokalen Seite)',
	'interwiki_trans' => 'Interwiki-Einbindung',
	'interwiki-trans-label' => 'Interwiki-Einbindung:',
	'interwiki_trans_intro' => 'Wenn Vorlagensyntax <code>{<nowiki />{präfix:<i>Seitenname</i>}}</code> verwendet wird, dann:',
	'interwiki_trans_1_intro' => 'erlaube Einbindung von anderen Wikis, wenn Interwiki-Einbindungen in diesem Wiki allgemein zulässig sind,',
	'interwiki_trans_0_intro' => 'erlaube es nicht, und nimm eine Seite aus dem Vorlagennamensraum.',
	'interwiki_intro_footer' => 'Siehe [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org], um weitere Informationen über die Interwiki-Tabelle zu erhalten. Das [[Special:Log/interwiki|Logbuch]] zeigt ein Protokoll aller Änderungen an der Interwiki-Tabelle.',
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nein',
	'interwiki_error' => 'Fehler: Die Interwiki-Tabelle ist leer.',
	'interwiki_edit' => 'Bearbeiten',
	'interwiki_reasonfield' => 'Grund:',
	'interwiki_delquestion' => 'Löscht „$1“',
	'interwiki_deleting' => 'Du bist dabei das Präfix „$1“ zu löschen.',
	'interwiki_deleted' => '„$1“ wurde erfolgreich aus der Interwiki-Tabelle entfernt.',
	'interwiki_delfailed' => '„$1“ konnte nicht aus der Interwiki-Tabelle gelöscht werden.',
	'interwiki_addtext' => 'Interwiki-Präfix hinzufügen',
	'interwiki_addintro' => 'Du fügst ein neues Interwiki-Präfix hinzu. Beachte, dass es kein Leerzeichen ( ), Kaufmännisches Und (&), Gleichheitszeichen (=) und keinen Doppelpunkt (:) enthalten darf.',
	'interwiki_addbutton' => 'Hinzufügen',
	'interwiki_added' => '„$1“ wurde erfolgreich der Interwiki-Tabelle hinzugefügt.',
	'interwiki_addfailed' => '„$1“ konnte nicht der Interwiki-Tabelle hinzugefügt werden.',
	'interwiki_edittext' => 'Interwiki-Präfix bearbeiten',
	'interwiki_editintro' => 'Du bist dabei ein Präfix zu ändern.
Beachte, dass dies bereits vorhandene Links ungültig machen kann.',
	'interwiki_edited' => 'Das Präfix „$1“ wurde erfolgreich in der Interwiki-Tabelle geändert.',
	'interwiki_editerror' => 'Das Präfix „$1“ kann in der Interwiki-Tabelle nicht geändert werden.
Möglicherweise existiert es nicht.',
	'interwiki-badprefix' => 'Festgelegtes Interwikipräfix „$1“ beinhaltet ungültige Zeichen',
	'interwiki_logpagename' => 'Interwikitabelle-Logbuch',
	'interwiki_log_added' => 'hat „$2“ ($3) (trans: $4) (lokal: $5) der Interwiki-Tabelle hinzugefügt',
	'interwiki_log_edited' => 'veränderte Präfix „$2“: ($3) (trans: $4) (lokal: $5) in der Interwiki-Tabelle',
	'interwiki_log_deleted' => 'hat „$2“ aus der Interwiki-Tabelle entfernt',
	'interwiki_logpagetext' => 'In diesem Logbuch werden Änderungen an der [[Special:Interwiki|Interwiki-Tabelle]] protokolliert.',
	'right-interwiki' => 'Interwiki-Tabelle bearbeiten',
	'action-interwiki' => 'Diesen Interwiki-Eintrag ändern',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author MichaelFrey
 */
$messages['de-formal'] = array(
	'interwiki_deleting' => 'Sie sind dabei das Präfix „$1“ zu löschen.',
	'interwiki_addintro' => 'Sie fügen ein neues Interwiki-Präfix hinzu. Beachten Sie, dass es kein Leerzeichen ( ), Kaufmännisches Und (&), Gleichheitszeichen (=) und keinen Doppelpunkt (:) enthalten darf.',
	'interwiki_editintro' => 'Sie sind dabei ein Präfix zu ändern.
Beachten Sie, dass dies bereits vorhandene Links ungültig machen kann.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'interwiki' => 'Daty interwiki se wobglědaś a wobźěłaś',
	'interwiki-title-norights' => 'Daty interwiki se wobglědaś',
	'interwiki-desc' => 'Pśidawa [[Special:Interwiki|specialny bok]] za woglědowanje a wobźěłowanje tabele interwiki',
	'interwiki_intro' => 'Toś to jo pśeglěd tabele interwiki. Wóznamy datow w słupach:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_prefix_intro' => 'Prefiks interwiki, kótaryž ma se we wikitekstowej syntaksy <code>[<nowiki />[prefix:<i>pagename</i>]]</code> wužywaś.',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Pśedłoga za URL. Zastupne znamješko $1 wuměnijo se pśez <i>mě boka</i> wikijowego teksta, gaž se wušej naspomnjona wikitekstowa syntaksa wužywa.',
	'interwiki_local' => 'Doprědka',
	'interwiki-local-label' => 'Doprědka:',
	'interwiki_local_intro' => 'Napšašowanje http do lokalnego wikija z toś tym prefiksom interwiki w URL jo:',
	'interwiki_local_0_intro' => 'njepśipóznaty, zwětšego wót "bok njenamakany" blokěrowany,',
	'interwiki_local_1_intro' => 'k celowemu URL w definicijach wótkaza interwiki dalej pósrědnjony (t.j. wobchada se z tym, ako z referencami w lokalnych bokach)',
	'interwiki_trans' => 'Transkluděrowaś',
	'interwiki-trans-label' => 'Transkluděrowaś:',
	'interwiki_trans_intro' => 'Jolic se wikitekstowa syntaksa <code>{<nowiki />{prefix:<i>pagename</i>}}</code> wužywa, ga:',
	'interwiki_trans_1_intro' => 'zapśěgnjenje z cuzego wikija dowóliś, jolic zapśěgnjenja interwiki su powšyknje w toś tom wikiju dopušćone,',
	'interwiki_trans_0_intro' => 'jo njedowóliś, lubjej wuwoglěduj se za bokom w mjenjowem rumje Pśedłoga',
	'interwiki_intro_footer' => 'Glědaj [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] za dalšne informacije wó tabeli interwikijow.
Jo [[Special:Log/interwiki|protokol změnow]] tabele interwikijow.',
	'interwiki_1' => 'jo',
	'interwiki_0' => 'ně',
	'interwiki_error' => 'Zmólka: Tabela interwiki jo prozna abo něco druge jo wopak.',
	'interwiki_edit' => 'Wobźěłaś',
	'interwiki_reasonfield' => 'Pśicyna:',
	'interwiki_delquestion' => '"$1" se lašujo',
	'interwiki_deleting' => 'Lašujoš prefiks "$1".',
	'interwiki_deleted' => 'Prefiks "$1" jo se wuspěšnje z tabele interwiki wupórał.',
	'interwiki_delfailed' => 'Prefiks "$1" njejo se dał z tabele interwiki wupóraś.',
	'interwiki_addtext' => 'Prefiks interwiki pśidaś',
	'interwiki_addintro' => 'Pśidawaš nowy prefiks interwiki.
Źiwaj na to, až njesmějo wopśimjeś prozne znamjenja ( ), dwójodypki (:), pśekupny A (&) abo znamuška rownosći (=).',
	'interwiki_addbutton' => 'Pśidaś',
	'interwiki_added' => 'Prefiks "$1" jo se wuspěšnje tabeli interwiki pśidał.',
	'interwiki_addfailed' => 'Prefiks "$1" njejo se dał tabeli interwiki pśidaś.
Snaź eksistěrujo južo w tabeli interwiki.',
	'interwiki_edittext' => 'Prefiks interwiki wobźěłaś',
	'interwiki_editintro' => 'Wobźěłujoš prefiks interwiki.
Źiwaj na to, až to móžo eksistěrujuce wótkaze skóńcowaś',
	'interwiki_edited' => 'Prefiks "$1" jo se wuspěšnje w tabeli interwiki změnił.',
	'interwiki_editerror' => 'Prefiks "$1" njedajo se w tabeli interwiki změniś.
Snaź njeeksistěrujo.',
	'interwiki-badprefix' => 'Podaty prefiks interwiki "$1" wopśimujo njepłaśiwe znamuška',
	'interwiki_logpagename' => 'Protokol tabele interwiki',
	'interwiki_log_added' => 'jo pśidał prefiks "$2" ($3) (trans: $4) (lokalny: $5) tabeli interwiki',
	'interwiki_log_edited' => 'jo změnił prefiks "$2": ($3) (trans: $4) (lokalny: $5) w tabeli interwiki',
	'interwiki_log_deleted' => 'jo wupórał prefiks "$2" z tabele interwiki',
	'interwiki_logpagetext' => 'To jo protokol změnow k [[Special:Interwiki|tabeli interwiki]].',
	'right-interwiki' => 'Daty interwiki wobźěłaś',
	'action-interwiki' => 'toś ten zapisk interwiki změniś',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Dead3y3
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'interwiki' => 'Εμφάνιση και επεξεργασία των δεδομένων ιντερβίκι',
	'interwiki-title-norights' => 'Εμφάνιση δεδομένων ιντερβίκι',
	'interwiki_prefix' => 'Πρόθεμα',
	'interwiki-prefix-label' => 'Πρόθεμα:',
	'interwiki_local' => 'Προώθηση',
	'interwiki-local-label' => 'Προώθηση:',
	'interwiki_trans' => 'Ενσωμάτωση',
	'interwiki-trans-label' => 'Ενσωμάτωση:',
	'interwiki_1' => 'ναι',
	'interwiki_0' => 'όχι',
	'interwiki_error' => 'Σφάλμα: Ο πίνακας ιντερβίκι είναι άδειος, ή κάτι άλλο έχει πάει στραβά.',
	'interwiki_edit' => 'Επεξεργασία',
	'interwiki_reasonfield' => 'Λόγος:',
	'interwiki_delquestion' => 'Διαγραφή του "$1"',
	'interwiki_deleting' => 'Διαγράφεις το πρόθεμα "$1".',
	'interwiki_deleted' => 'Το πρόθεμα "$1" αφαιρέθηκε με επιτυχία από τον πίνακα των interwiki.',
	'interwiki_addtext' => 'Προσθήκη ενός προθέματος interwiki',
	'interwiki_addbutton' => 'Προσθήκη',
	'interwiki_edittext' => 'Επεξεργασία ενός ιντερβίκι προθέματος',
	'interwiki_editerror' => 'Το πρόθεμα "$1" δεν μπορεί να τροποποιηθεί στον πίνακα interwiki.
Πιθανώς να μην υπάρχει.',
	'interwiki-badprefix' => 'Το καθορισμένο πρόθεμα interwiki "$1" περιέχει μη έγκυρους χαρακτήρες',
	'interwiki_logpagename' => 'Αρχείο του πίνακα ιντερβίκι',
	'interwiki_logpagetext' => 'Αυτό είναι ένα ημερολόγιο αλλαγών στον [[Special:Interwiki|πίνακα ιντερβίκι]].',
	'right-interwiki' => 'Επεξεργασία των δεδομένων ιντερβίκι',
	'action-interwiki' => 'αλλαγή αυτής της καταχώρισης ιντερβίκι',
);

/** Esperanto (Esperanto)
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'interwiki' => 'Rigardi kaj redakti intervikiajn datenojn',
	'interwiki-title-norights' => 'Rigardi intervikiajn datenojn',
	'interwiki-desc' => 'Aldonas [[Special:Interwiki|specialan paĝon]] por rigardi kaj redakti la intervikian tabelon',
	'interwiki_intro' => 'Tio estas superrigardo de la intervikia tabelo. Signifoj de la datumoj en la kolumnoj:',
	'interwiki_prefix' => 'Prefikso',
	'interwiki-prefix-label' => 'Prefikso:',
	'interwiki_local' => 'Plu',
	'interwiki-local-label' => 'Plu:',
	'interwiki_trans' => 'Transinkluzivi',
	'interwiki-trans-label' => 'Transinkluzivi:',
	'interwiki_1' => 'jes',
	'interwiki_0' => 'ne',
	'interwiki_error' => 'ERARO: La intervikia tabelo estas malplena, aŭ iel misfunkciis.',
	'interwiki_edit' => 'Redakti',
	'interwiki_reasonfield' => 'Kialo:',
	'interwiki_delquestion' => 'Forigante "$1"',
	'interwiki_deleting' => 'Vi forigas prefikson "$1".',
	'interwiki_deleted' => 'Prefikso "$1" estis sukcese forigita de la intervikia tabelo.',
	'interwiki_delfailed' => 'Prefikso "$1" ne eblis esti forigita el la intervikia tabelo.',
	'interwiki_addtext' => 'Aldonu intervikian prefikson',
	'interwiki_addintro' => 'Vi aldonas novan intervikian prefikson.
Memoru ke ĝi ne povas enhavi spacetojn ( ), kolojn (:), kajsignojn (&), aŭ egalsignojn (=).',
	'interwiki_addbutton' => 'Aldoni',
	'interwiki_added' => 'Prefikso "$1" estis sukcese aldonita al la intervikia tabelo.',
	'interwiki_addfailed' => 'Prefikso "$1" ne eblis esti aldonita al la intervikia tabelo.
Eble ĝi jam ekzistas en la intervikia tabelo.',
	'interwiki_edittext' => 'Redaktante intervikian prefikson',
	'interwiki_editintro' => 'Vi redaktas intervikian prefikson.
Notu ke ĉi tiu ago povas rompi ekzistantajn ligilojn.',
	'interwiki_edited' => 'Prefikso "$1" estis sukcese modifita en la intervikian tabelon.',
	'interwiki_editerror' => 'Prefikso "$1" ne eblis esti modifita en la intervikia tabelo.
Verŝajne ĝi ne ekzistas.',
	'interwiki-badprefix' => 'Specifita intervika prefikso "$1" enhavas nevalidajn signojn',
	'interwiki_logpagename' => 'Loglibro pri la intervikia tabelo',
	'interwiki_log_added' => 'Aldonis prefikson "$2" ($3) (transvikie: $4) (loke: $5) al la intervikia tabelo',
	'interwiki_log_edited' => 'modifis prefikson "$2" : ($3) (transvikie: $4) (loke: $5) en la intervikia tabelo',
	'interwiki_log_deleted' => 'Forigita prefikso "$2" de la intervikia tabelo',
	'interwiki_logpagetext' => 'Jen loglibro de ŝanĝoj al la [[Special:Interwiki|intervikia tabelo]].',
	'right-interwiki' => 'Redakti intervikiajn datenojn',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Locos epraix
 * @author Piolinfax
 * @author Sanbec
 * @author Translationista
 */
$messages['es'] = array(
	'interwiki' => 'Ver y editar la tabla de interwikis',
	'interwiki-title-norights' => 'Ver datos de interwikis',
	'interwiki-desc' => 'Añade una [[Special:Interwiki|página especial]] para ver y editar la tabla de interwikis',
	'interwiki_intro' => 'Esta es una visión general de la tabla intewiki. Los significados de los datos en las columnas:',
	'interwiki_prefix' => 'Prefijo',
	'interwiki-prefix-label' => 'Prefijo:',
	'interwiki_url_intro' => 'Plantilla para URLs. El marcador $1 será reemplazado por el <i>nombre de página</i> del wikitexto cuando se use la sintaxis de wikitexto arriba mostrada.',
	'interwiki_local' => 'Adelante',
	'interwiki-local-label' => 'Adelante:',
	'interwiki_local_intro' => 'Una solicitud HTTP a la wiki local con este prefijo interwiki en la URL es:',
	'interwiki_trans' => 'transcluir',
	'interwiki-trans-label' => 'Transcluir:',
	'interwiki_trans_0_intro' => 'no permitirlo. En su lugar, buscar una página en el espacio de nombre de la plantilla.',
	'interwiki_1' => 'Sí',
	'interwiki_0' => 'no',
	'interwiki_error' => 'Error: La tabla de interwikis está vacía, u otra cosa salió mal.',
	'interwiki_edit' => 'Editar',
	'interwiki_reasonfield' => 'Motivo:',
	'interwiki_delquestion' => 'Borrando «$1»',
	'interwiki_deleting' => 'Estás borrando el prefijo «$1».',
	'interwiki_deleted' => 'El prefijo «$1» ha sido borrado correctamente de la tabla de interwikis.',
	'interwiki_delfailed' => 'El prefijo «$1» no puede ser borrado de la tabla de interwikis.',
	'interwiki_addtext' => 'Añadir un prefijo interwiki',
	'interwiki_addintro' => "Estás añadiendo un nuevo prefijo interwiki.
Recuerda que no puede contener espacios ( ), dos puntos (:), ni los signos ''et'' (&), o ''igual'' (=).",
	'interwiki_addbutton' => 'Agregar',
	'interwiki_added' => 'El prefijo «$1» ha sido añadido correctamente a la tabla de interwikis.',
	'interwiki_addfailed' => 'El prefijo «$1» no se puede añadir a la tabla de interwikis.
Posiblemente ya exista.',
	'interwiki_edittext' => 'Editando un prefijo interwiki',
	'interwiki_editintro' => 'Estás editando un prefijo interwiki.
Recuerda que esto puede romper enlaces existentes.',
	'interwiki_edited' => 'El prefijo «$1» ha sido modificado correctamente en la tabla de interwikis.',
	'interwiki_editerror' => 'El prefijo «$1» no puede ser modificado en la tabla de interwikis.
Posiblemente no exista.',
	'interwiki-badprefix' => 'El prefijo interwiki especificado «$1» contiene caracteres no válidos',
	'interwiki_logpagename' => 'Tabla de registro de interwiki',
	'interwiki_log_added' => 'añadido el prefijo «$2» ($3) (trans: $4) (local: $5) a la tabla de interwikis',
	'interwiki_log_edited' => 'modificado el prefijo «$2» : ($3) (trans: $4) (local: $5) en la tabla de interwikis',
	'interwiki_log_deleted' => 'eliminado el prefijo «$2» de la tabla de interwikis',
	'interwiki_logpagetext' => 'Este es un registro de los cambios hechos a la [[Special:Interwiki|tabla interwiki]].',
	'right-interwiki' => 'Editar datos de interwiki',
	'action-interwiki' => 'cambiar esta entrada interwiki',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'interwiki_1' => 'jah',
	'interwiki_0' => 'ei',
	'interwiki_edit' => 'Redigeeri',
	'interwiki_reasonfield' => 'Põhjus',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'interwiki_prefix' => 'Aurrizkia',
	'interwiki-prefix-label' => 'Aurrizkia:',
	'interwiki_1' => 'bai',
	'interwiki_0' => 'ez',
	'interwiki_edit' => 'Aldatu',
	'interwiki_reasonfield' => 'Arrazoia:',
	'interwiki_delquestion' => '"$1" ezabatzen',
	'interwiki_deleting' => '"$1" aurrizkia ezabatzen ari zara.',
	'interwiki_addbutton' => 'Erantsi',
	'interwiki_edittext' => 'Interwiki aurrizkia editatzen',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'interwiki' => 'نمایش و ویرایش اطلاعات میان‌ویکی',
	'interwiki-title-norights' => 'مشاهدهٔ اطلاعات میان‌ویکی',
	'interwiki_intro' => 'برای اطلاعات بیشتر در مورد جدول میان‌ویکی [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] را ببینید.
[[Special:Log/interwiki|سیاهه‌ای از تغییرات]] جدول میان‌ویکی نیز وجود دارد.',
	'interwiki_prefix' => 'پیشوند',
	'interwiki-prefix-label' => 'پیشوند:',
	'interwiki_local' => 'مشخص کردن به عنوان یک ویکی محلی',
	'interwiki-local-label' => 'مشخص کردن به عنوان یک ویکی محلی:',
	'interwiki_trans' => 'اجازهٔ گنجاندن میان‌ویکی را بده',
	'interwiki-trans-label' => 'اجازهٔ گنجاندن میان‌ویکی را بده:',
	'interwiki_error' => 'خطا: جدول میان‌ویکی خالی است، یا چیز دیگری مشکل دارد.',
	'interwiki_reasonfield' => 'دلایل',
	'interwiki_delquestion' => 'حذف «$1»',
	'interwiki_deleting' => 'شما در حال حذف کردن پیشوند «$1» هستید.',
	'interwiki_deleted' => 'پیشوند «$1» با موفقیت از جدول میان‌ویکی حذف شد.',
	'interwiki_delfailed' => 'پیشوند «$1» را نمی‌توان از جدول میان‌ویکی حذف کرد.',
	'interwiki_addtext' => 'افزودن یک پیشوند میان‌ویکی',
	'interwiki_addintro' => 'شما در حال ویرایش یک پیشوند میان‌ویکی هستید.
توجه داشته باشید که این پیشوند نمی‌تواند شامل فاصله ( )، دو نقطه (:)، علامت آمپرساند (&) یا علامت مساوی (=) باشد.',
	'interwiki_addbutton' => 'افزودن',
	'interwiki_added' => 'پیشوند «$1» با موفقیت به جدول میان‌ویکی افزوده شد.',
	'interwiki_addfailed' => 'پیشوند «$1» را نمی‌توان به جدول میان‌ویکی افزود.
احتمالاً این پیشوند از قبل در جدول میان‌ویکی وجود دارد.',
	'interwiki_edittext' => 'ویرایش یک پیشوند میان‌ویکی',
	'interwiki_editintro' => 'شما در حال ویرایش یک پیشوند میان‌ویکی هستید.
توجه داشته باشید که این کار می‌تواند پیوندهای موجود را خراب کند.',
	'interwiki_edited' => 'پیشوند «$1» با موفقیت در جدول میان‌ویکی تغییر داده شد.',
	'interwiki_editerror' => 'پیشوند «$1» را نمی‌توان در جدول میان‌ویکی تغییر داد.
احتمالاً این پیشوند وجود ندارد.',
	'interwiki-badprefix' => 'پیشوند میان‌ویکی «$1» حاوی نویسه‌های غیر مجاز است',
	'interwiki_log_added' => 'پیشوند «$2» ($3) (میانی: $4) (محلی: $5) را به جدول میان‌ویکی افزود',
	'interwiki_log_edited' => 'پیشوند «$2» : ($3) (میانی: $4) (محلی: $5) را در جدول میان‌ویکی تغییر داد',
	'interwiki_log_deleted' => 'پیشوند «$2» را از جدول میان‌ویکی حذف کرد',
	'right-interwiki' => 'ویرایش اطلاعات میان‌ویکی',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Jack Phoenix
 * @author Mobe
 * @author Nike
 */
$messages['fi'] = array(
	'interwiki' => 'Wikienväliset linkit',
	'interwiki-title-norights' => 'Selaa interwiki-tietueita',
	'interwiki-desc' => 'Lisää [[Special:Interwiki|toimintosivun]], jonka avulla voi katsoa ja muokata interwiki-taulua.',
	'interwiki_intro' => 'Tämä on yleiskatsaus interwiki-taulusta. Tietojen merkitykset sarakkeissa:',
	'interwiki_prefix' => 'Etuliite',
	'interwiki-prefix-label' => 'Etuliite:',
	'interwiki_local' => 'Välitä',
	'interwiki-local-label' => 'Välitä:',
	'interwiki_trans' => 'Sisällytä',
	'interwiki-trans-label' => 'Sisällytä:',
	'interwiki_1' => 'kyllä',
	'interwiki_0' => 'ei',
	'interwiki_error' => 'Virhe: Interwiki-taulu on tyhjä tai jokin muu meni pieleen.',
	'interwiki_edit' => 'Muokkaa',
	'interwiki_reasonfield' => 'Syy',
	'interwiki_delquestion' => 'Poistetaan ”$1”',
	'interwiki_deleting' => 'Olet poistamassa etuliitettä ”$1”.',
	'interwiki_deleted' => 'Etuliite ”$1” poistettiin onnistuneesti interwiki-taulusta.',
	'interwiki_delfailed' => 'Etuliitteen ”$1” poistaminen interwiki-taulusta epäonnistui.',
	'interwiki_addtext' => 'Lisää wikienvälinen etuliite',
	'interwiki_addintro' => 'Olet lisäämässä uutta wikienvälistä etuliitettä. Se ei voi sisältää välilyöntejä ( ), kaksoispisteitä (:), et-merkkejä (&), tai yhtäsuuruusmerkkejä (=).',
	'interwiki_addbutton' => 'Lisää',
	'interwiki_added' => 'Etuliite ”$1” lisättiin onnistuneesti interwiki-tauluun.',
	'interwiki_addfailed' => 'Etuliitteen ”$1” lisääminen interwiki-tauluun epäonnistui. Kyseinen etuliite saattaa jo olla interwiki-taulussa.',
	'interwiki_edittext' => 'Muokataan interwiki-etuliitettä',
	'interwiki_editintro' => 'Muokkaat interwiki-etuliitettä. Muista, että tämä voi rikkoa olemassa olevia linkkejä.',
	'interwiki_edited' => 'Etuliitettä ”$1” muokattiin onnistuneesti interwiki-taulukossa.',
	'interwiki_editerror' => 'Etuliitettä ”$1” ei voi muokata interwiki-taulukossa. Sitä ei mahdollisesti ole olemassa.',
	'interwiki-badprefix' => 'Annettu interwiki-etuliite <code>$1</code> sisältää virheellisiä merkkejä',
	'interwiki_logpagename' => 'Interwikitaululoki',
	'interwiki_log_added' => 'lisäsi uuden etuliitteen ”$2” ($3) (trans: $4) (paikallinen: $5) interwiki-tauluun',
	'interwiki_log_edited' => 'muokkasi etuliitettä ”$2”: ($3) (trans: $4) (paikallinen: $5) interwiki-taulussa',
	'interwiki_log_deleted' => 'poisti etuliitteen ”$2” interwiki-taulusta',
	'interwiki_logpagetext' => 'Tämä on loki muutoksista [[Special:Interwiki|interwiki-tauluun]].',
	'right-interwiki' => 'Muokata interwiki-dataa',
	'action-interwiki' => 'muokata tätä interwiki-merkintää',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Jean-Frédéric
 * @author Louperivois
 * @author Purodha
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'interwiki' => 'Voir et manipuler les données interwiki',
	'interwiki-title-norights' => 'Voir les données interwiki',
	'interwiki-desc' => 'Ajoute une [[Special:Interwiki|page spéciale]] pour voir et modifier la table interwiki',
	'interwiki_intro' => 'Ceci est aperçu de la table interwiki. Voici les significations des données de colonnes :',
	'interwiki_prefix' => 'Préfixe',
	'interwiki-prefix-label' => 'Préfixe :',
	'interwiki_prefix_intro' => 'Préfixe interwiki à utiliser dans <code>[<nowiki />[préfixe:<i>nom de la page</i>]]</code> de la syntaxe wiki.',
	'interwiki-url-label' => 'URL :',
	'interwiki_url_intro' => 'Modèle pour les URLs. $1 sera remplacé par le <i>nom de la page</i> du wikitexte, quand la syntaxe ci-dessus est utilisée.',
	'interwiki_local' => 'Faire suivre',
	'interwiki-local-label' => 'Faire suivre :',
	'interwiki_local_intro' => "Une requête HTTP sur ce wiki avec ce préfixe interwiki dans l'URL sera :",
	'interwiki_local_0_intro' => 'rejeté, bloqué généralement par « Mauvais titre »,',
	'interwiki_local_1_intro' => "redirigé vers l'URL cible en fonction de la définition du préfixe interwiki (c'est-à-dire traité comme un lien dans une page du wiki)",
	'interwiki_trans' => 'Inclure',
	'interwiki-trans-label' => 'Inclure :',
	'interwiki_trans_intro' => 'Si la syntaxe <code>{<nowiki />{préfixe:<i>nom de la page</i>}}</code> est utilisée, alors :',
	'interwiki_trans_1_intro' => "l'inclusion à partir du wiki sera autorisée, si les inclusion interwiki sont autorisées dans ce wiki,",
	'interwiki_trans_0_intro' => "l'inclusion sera rejetée, et la page correspondante sera recherchée dans l'espace de noms « Modèle ».",
	'interwiki_intro_footer' => "Voyez [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] pour obtenir plus d'informations en ce qui concerne la table interwiki.
Il existe un [[Special:Log/interwiki|journal des modifications]] de la table interwiki.",
	'interwiki_1' => 'oui',
	'interwiki_0' => 'non',
	'interwiki_error' => "Erreur : la table des interwikis est vide ou un processus s'est mal déroulé.",
	'interwiki_edit' => 'Modifier',
	'interwiki_reasonfield' => 'Motif :',
	'interwiki_delquestion' => 'Suppression de « $1 »',
	'interwiki_deleting' => 'Vous effacez présentement le préfixe « $1 ».',
	'interwiki_deleted' => '« $1 » a été enlevé avec succès de la table interwiki.',
	'interwiki_delfailed' => "« $1 » n'a pas pu être enlevé de la table interwiki.",
	'interwiki_addtext' => 'Ajouter un préfixe interwiki',
	'interwiki_addintro' => "Vous êtes en train d'ajouter un préfixe interwiki. Rappelez-vous qu'il ne peut pas contenir d'espaces ( ), de deux-points (:), d'esperluettes (&) ou de signes égal (=).",
	'interwiki_addbutton' => 'Ajouter',
	'interwiki_added' => '« $1 » a été ajouté avec succès dans la table interwiki.',
	'interwiki_addfailed' => "« $1 » n'a pas pu être ajouté à la table interwiki.",
	'interwiki_edittext' => 'Modifier un préfixe interwiki',
	'interwiki_editintro' => 'Vous modifiez un préfixe interwiki. Rappelez-vous que cela peut casser des liens existants.',
	'interwiki_edited' => 'Le préfixe « $1 » a été modifié avec succès dans la table interwiki.',
	'interwiki_editerror' => "Le préfixe « $1 » ne peut pas être modifié. Il se peut qu'il n'existe pas.",
	'interwiki-badprefix' => 'Le préfixe interwiki spécifié « $1 » contient des caractères invalides',
	'interwiki_logpagename' => 'Journal de la table interwiki',
	'interwiki_log_added' => 'a ajouté « $2 » ($3) (trans: $4) (local: $5) dans la table interwiki',
	'interwiki_log_edited' => 'a modifié le préfixe « $2 » : ($3) (trans: $4) (local: $5) dans la table interwiki',
	'interwiki_log_deleted' => 'a supprimé le préfixe « $2 » de la table interwiki',
	'interwiki_logpagetext' => 'Ceci est le journal des changements dans la [[Special:Interwiki|table interwiki]].',
	'right-interwiki' => 'Modifier les données interwiki',
	'action-interwiki' => 'modifier cette entrée interwiki',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'interwiki_1' => 'ouè',
	'interwiki_0' => 'nan',
	'interwiki_edit' => 'Changiér',
	'interwiki_reasonfield' => 'Rêson',
	'interwiki_addbutton' => 'Apondre',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'interwiki_addbutton' => 'Tafoegje',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'interwiki' => 'Ver e manipular datos interwiki',
	'interwiki-title-norights' => 'Ver os datos do interwiki',
	'interwiki-desc' => 'Engade unha [[Special:Interwiki|páxina especial]] para ver e editar a táboa interwiki',
	'interwiki_intro' => 'Esta é unha vista xeral da táboa interwiki. Os significados dos datos aparecen nas columnas:',
	'interwiki_prefix' => 'Prefixo',
	'interwiki-prefix-label' => 'Prefixo:',
	'interwiki_prefix_intro' => 'Prefixo interwiki a ser usado coa sintaxe do texto wiki <code>[<nowiki />[prefixo:<i>nome da páxina</i>]]</code>.',
	'interwiki_url' => 'URL',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Modelo para os enderezos URL. O espazo reservado $1 será substituído polo <i>nome da páxina</i> do texto wiki, cando a sintaxe do devantito texto wiki é usada.',
	'interwiki_local' => 'Cara adiante',
	'interwiki-local-label' => 'Cara adiante:',
	'interwiki_local_intro' => 'Unha solicitude HTTP ao wiki local con este prefixo interwiki no URL é:',
	'interwiki_local_0_intro' => 'ignoradas, normalmente bloqueadas, dando unha mensaxe de "a páxina non foi atopada",',
	'interwiki_local_1_intro' => 'redirixidas cara ao enderezo URL de destino indicado na ligazón interwiki das definicións (ou sexa, serán tratadas como referencias nas páxinas)',
	'interwiki_trans' => 'Transcluír',
	'interwiki-trans-label' => 'Transcluír:',
	'interwiki_trans_intro' => 'Se a sintaxe do texto wiki <code>{<nowiki />{prefixo:<i>nome da páxina</i>}}</code> é usado, entón:',
	'interwiki_trans_1_intro' => 'permitir as transclusións a partir do wiki estranxeiro, se estas transclusións interwiki están xeralmente permitidas neste wiki,',
	'interwiki_trans_0_intro' => 'non permitilas, e procurar a páxina no espazo de nomes Modelo.',
	'interwiki_intro_footer' => 'Consulte [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] para obter máis información acerca da táboa interwiki.
Ademais, existe un [[Special:Log/interwiki|rexistro dos cambios]] realizados á táboa interwiki.',
	'interwiki_1' => 'si',
	'interwiki_0' => 'non',
	'interwiki_error' => 'ERRO: A táboa interwiki está baleira, ou algo máis saíu mal.',
	'interwiki_edit' => 'Editar',
	'interwiki_reasonfield' => 'Motivo:',
	'interwiki_delquestion' => 'Eliminando "$1"',
	'interwiki_deleting' => 'Vai eliminar o prefixo "$1".',
	'interwiki_deleted' => 'Eliminouse sen problemas o prefixo "$1" da táboa interwiki.',
	'interwiki_delfailed' => 'Non se puido eliminar o prefixo "$1" da táboa interwiki.',
	'interwiki_addtext' => 'Engadir un prefixo interwiki',
	'interwiki_addintro' => 'Vostede está engadindo un novo prefixo interwiki. Recorde que non pode conter espazos ( ), dous puntos (:), o símbolo de unión (&), ou signos de igual (=).',
	'interwiki_addbutton' => 'Engadir',
	'interwiki_added' => 'Engadiuse sen problemas o prefixo "$1" á táboa interwiki.',
	'interwiki_addfailed' => 'Non se puido engadir o prefixo "$1" á táboa interwiki. Posibelmente xa existe na táboa interwiki.',
	'interwiki_edittext' => 'Editando un prefixo interwiki',
	'interwiki_editintro' => 'Está editando un prefixo interwiki. Lembre que isto pode quebrar ligazóns existentes.',
	'interwiki_edited' => 'O prefixo "$1" foi modificado con éxito na táboa do interwiki.',
	'interwiki_editerror' => 'O prefixo "$1" non pode ser modificado na táboa do interwiki. Posiblemente non existe.',
	'interwiki-badprefix' => 'O prefixo interwiki especificado "$1" contén caracteres inválidos',
	'interwiki_logpagename' => 'Rexistro de táboas interwiki',
	'interwiki_log_added' => 'engadiu o prefixo "$2" ($3) (trans: $4) (local: $5) á táboa interwiki',
	'interwiki_log_edited' => 'modificou o prefixo "$2": ($3) (trans: $4) (local: $5) na táboa do interwiki',
	'interwiki_log_deleted' => 'eliminou o prefixo "$2" da táboa interwiki',
	'interwiki_logpagetext' => 'Este é un rexistro dos cambios feitos á [[Special:Interwiki|táboa interwiki]].',
	'right-interwiki' => 'Editar os datos do interwiki',
	'action-interwiki' => 'cambiar esta entrada de interwiki',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 * @author Omnipaedista
 */
$messages['got'] = array(
	'interwiki_reasonfield' => 'Faírina',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'interwiki' => 'Ὁρᾶν καὶ μεταγράφειν διαβικι-δεδομένα',
	'interwiki-title-norights' => 'Ὁρᾶν διαβικι-δεδομένα',
	'interwiki_prefix' => 'Πρόθεμα',
	'interwiki-prefix-label' => 'Πρόθεμα:',
	'interwiki_local' => 'Ἀκολούθησις',
	'interwiki-local-label' => 'Ἀκολούθησις:',
	'interwiki_trans' => 'Ὑπερδιαποκλῄειν',
	'interwiki-trans-label' => 'Ὑπερδιαποκλῄειν:',
	'interwiki_1' => 'ναί',
	'interwiki_0' => 'οὐ',
	'interwiki_error' => 'Σφάλμα: Ὁ διαβικι-πίναξ κενός ἐστίν, ἢ ἑτέρα ἐσφαλμένη ἐνέργειά τι συνέβη.',
	'interwiki_edit' => 'Μεταγράφειν',
	'interwiki_reasonfield' => 'Αἰτία:',
	'interwiki_delquestion' => 'Διαγράφειν τὴν "$1"',
	'interwiki_deleting' => 'Διαγράφεις τὸ πρόθεμα "$1".',
	'interwiki_deleted' => 'Τὸ πρόθεμα "$1" ἀφῃρημένον ἐπιτυχῶς ἐστὶ ἐκ τοῦ διαβικι-πίνακος.',
	'interwiki_delfailed' => 'Τὸ πρόθεμα "$1" μὴ ἀφαιρέσιμον ἐκ τοῦ διαβικι-πίνακος ἦν.',
	'interwiki_addtext' => 'Προστιθέναι διαβικι-πρόθεμά τι',
	'interwiki_addintro' => 'Προσθέτεις νέον διαβικι-πρόθεμά τι.
Οὐκ ἔξεστί σοι χρῆσαι κενά ( ), κόλα (:), σύμβολα τοῦ σύν (&), ἢ σύμβολα τοῦ ἴσον (=).',
	'interwiki_addbutton' => 'Προστιθέναι',
	'interwiki_added' => 'Τὸ πρόθεμα "$1" ἐπιτυχῶς προσετέθη τῷ διαβικι-πίνακι.',
	'interwiki_addfailed' => 'Τὸ πρόθεμα "$1" οὐ προσετέθη τῷ διαβικι-πίνακι.
Πιθανῶς ἤδη ὑπάρχει ἐν τῷ διαβικι-πίνακι.',
	'interwiki_edittext' => 'Μεταγράφειν διαβικι-πρόθεμά τι',
	'interwiki_editintro' => 'Μεταγράφεις διαβικι-πρόθεμά τι.
Μέμνησο τὴν πιθανότητα καταστροφῆς τῶν ὑπαρχόντων συνδέσμων.',
	'interwiki_edited' => 'Τὸ πρόθεμα "$1" ἐπιτυχῶς ἐτράπη ἐν τῷ διαβικι-πίνακι.',
	'interwiki_editerror' => 'Τὸ πρόθεμα "$1" μὴ μετατρέψιμον ἐστὶ ἐν τῷ διαβικι-πίνακι.
Πιθανῶς οὐκ ἔστι.',
	'interwiki-badprefix' => 'Τὸ καθωρισμένον διαβικι-πρόθεμά  "$1" περιέχει ἀκύρους χαρακτῆρας',
	'right-interwiki' => 'Μεταγράφειν διαβίκι-δεδομένα',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'interwiki' => 'Interwiki-Date aaluege un bearbeite',
	'interwiki-title-norights' => 'Interwiki-Date aaluege',
	'interwiki-desc' => '[[Special:Interwiki|Spezialsyte]] zum Interwiki-Tabälle pfläge',
	'interwiki_intro' => 'Des isch e Iberblick iber d Interwiki-Tabälle. D Date in dr einzelne Spalte hän die Bedytig:',
	'interwiki_prefix' => 'Präfix',
	'interwiki-prefix-label' => 'Präfix:',
	'interwiki_prefix_intro' => 'Interwiki-Präfix, wu in dr Form <code>[<nowiki />[präfix:<i>Sytename</i>]]</code> im Wikitext cha bruucht wäre.',
	'interwiki_url_intro' => 'Muschter für URL. Dr Platzhalter $1 wird dur <i>Sytename</i> us dr Syntax im Wikitäxt ersetzt, wu oben gnännt wird.',
	'interwiki_local' => 'Wyter',
	'interwiki-local-label' => 'Wyter:',
	'interwiki_local_intro' => 'E HTTP-Aafrog an s lokal Wiki mit däm Interwiki-Präfix in dr URL wird:',
	'interwiki_local_0_intro' => 'nit gmacht, sundere normalerwyys mit „Syte nit gfunde“ blockiert',
	'interwiki_local_1_intro' => 'automatisch uf d Ziil-URL in dr Interwikigleich-Definitione wytergleitet (d. h. behandlet wie Wikigleicher uf lokali Syte)',
	'interwiki_trans' => 'Quer vernetze',
	'interwiki-trans-label' => 'Quer vernetze:',
	'interwiki_trans_intro' => 'Wänn Vorlagesyntax <code>{<nowiki />{präfix:<i>Sytename</i>}}</code> bruucht wird, derno:',
	'interwiki_trans_1_intro' => 'erlaub Yybindige vu andere Wiki, wänn Interwiki-Yybindigen in däm Wiki allgmein zuelässig sin,',
	'interwiki_trans_0_intro' => 'erlaub s nit, un nimm e Syte us em Vorlagenamensruum.',
	'interwiki_intro_footer' => 'Lueg [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] fir meh Informationen iber d Interwiki-Tabälle. S [[Special:Log/interwiki|Logbuech]] zeigt e Protokoll vu allene Änderigen an dr Interwiki-Tabälle.',
	'interwiki_1' => 'jo',
	'interwiki_0' => 'nei',
	'interwiki_error' => 'Fähler: D Interwiki-Tabälle isch läär.',
	'interwiki_edit' => 'Bearbeite',
	'interwiki_reasonfield' => 'Grund:',
	'interwiki_delquestion' => 'Lescht „$1“',
	'interwiki_deleting' => 'Du bisch am Lesche vum Präfix „$1“.',
	'interwiki_deleted' => '„$1“ isch mit Erfolg us dr Interwiki-Tabälle usegnuh wore.',
	'interwiki_delfailed' => '„$1“ het nit chenne us dr Interwiki-Tabälle glescht wäre.',
	'interwiki_addtext' => 'E Interwiki-Präfix zuefiege',
	'interwiki_addintro' => 'Du fiegsch e nej Interwiki-Präfix zue. Gib Acht, ass es kei Läärzeiche ( ), Chaufmännisch Un (&), Glyychzeiche (=) un kei Doppelpunkt (:) derf enthalte.',
	'interwiki_addbutton' => 'Zuefiege',
	'interwiki_added' => '„$1“ isch mit Erfolg dr Interwiki-Tabälle zuegfiegt wore.',
	'interwiki_addfailed' => '„$1“ het nit chenne dr Interwiki-Tabälle zuegfiegt wäre.',
	'interwiki_edittext' => 'Interwiki-Präfix bearbeite',
	'interwiki_editintro' => 'Du bisch am Ändere vun eme Präfix.
Gib Acht, ass des Gleicher cha uugiltig mache, wu s scho git.',
	'interwiki_edited' => 'S Präfix „$1“ isch mit Erfolg in dr Interwiki-Tabälle gänderet wore.',
	'interwiki_editerror' => 'S Präfix „$1“ cha in dr Interwiki-Tabälle nit gänderet wäre.
Villicht git s es nit.',
	'interwiki-badprefix' => 'Im feschtgleite Interwikipräfix „$1“ het s nit giltigi Zeiche din',
	'interwiki_logpagename' => 'Interwikitabälle-Logbuech',
	'interwiki_log_added' => 'het „$2“ ($3) (trans: $4) (lokal: $5) dr Interwiki-Tabälle zuegfiegt',
	'interwiki_log_edited' => 'gändereti Präfix „$2“: ($3) (trans: $4) (lokal: $5) in dr Interwiki-Tabälle',
	'interwiki_log_deleted' => 'het „$2“ us dr Interwiki-Tabälle usegnuh',
	'interwiki_logpagetext' => 'In däm Logbuech wäre Änderige an dr [[Special:Interwiki|Interwiki-Tabälle]] protokolliert.',
	'right-interwiki' => 'Interwiki-Tabälle bearbeite',
	'action-interwiki' => 'Där Interwiki-Yytrag ändere',
);

/** Gujarati (ગુજરાતી)
 * @author Dineshjk
 */
$messages['gu'] = array(
	'interwiki_reasonfield' => 'કારણ',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'interwiki_reasonfield' => 'Fa',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'interwiki_edit' => 'E hoʻololi',
	'interwiki_reasonfield' => 'Kumu',
	'interwiki_addbutton' => 'Ho‘ohui',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 * @author YaronSh
 * @author דניאל ב.
 */
$messages['he'] = array(
	'interwiki' => 'הצגת ועריכת מידע הבינוויקי',
	'interwiki-title-norights' => 'הצגת מידע הבינוויקי',
	'interwiki-desc' => 'הוספת [[Special:Interwiki|דף מיוחד]] להצגת ולעריכת טבלת הבינוויקי',
	'interwiki_intro' => 'זוהי סקירה של טבלת הבינוויקי. משמעויות הנתונים שבעמודות:',
	'interwiki_prefix' => 'קידומת',
	'interwiki-prefix-label' => 'קידומת:',
	'interwiki_prefix_intro' => 'קידומת הבינוויקי שתשמש בתחביר <code>[<nowiki />[prefix:<i>שם_הדף</i>]]</code>',
	'interwiki_url_intro' => 'תבנית עבור כתובות. ממלא המקום $1 יוחלף על ידי <i>שם_הדף</i>, כאשר נעשה שימוש בתחביר שהוזכר לעיל.',
	'interwiki_local' => 'העברה',
	'interwiki-local-label' => 'העברה:',
	'interwiki_local_intro' => 'בקשת HTTP לאתר הוויקי המקומי עם קידומת בינוויקי זו בכתובת:',
	'interwiki_local_0_intro' => 'לא מכובדת, לרוב נחסמת עם הודעת "הדף לא נמצא",',
	'interwiki_local_1_intro' => 'מופנית אל כתובת היעד שניתנה בהגדרות קישור הבינוויקי (כלומר מטופלת כמו הפניה בדפים מקומיים)',
	'interwiki_trans' => 'הכללת מקטעים חיצוניים',
	'interwiki-trans-label' => 'הכללת מקטעים חיצוניים:',
	'interwiki_trans_intro' => 'אם נעשה שימוש בתחביר <code>{<nowiki />{prefix:<i>שם_הדף</i>}}</code>,אז:',
	'interwiki_trans_1_intro' => 'תינתן האפשרות להכללת מקטעים חיצוניים מאתר ויקי זר, במידה שהכללות מקטעי ויקי חיצוניים מורשים באופן כללי באתר ויקי זה,',
	'interwiki_trans_0_intro' => 'אין לאפשר זאת, במקום זאת יש לחפש דף במרחב השם תבנית.',
	'interwiki_intro_footer' => 'עיינו ב־[http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] למידע נוסף אודות טבלת הבינוויקי.
ישנו [[Special:Log/interwiki|יומן שינויים]] לטבלת הבינוויקי.',
	'interwiki_1' => 'כן',
	'interwiki_0' => 'לא',
	'interwiki_error' => 'שגיאה: טבלת הבינוויקי ריקה, או שיש שגיאה אחרת.',
	'interwiki_edit' => 'עריכה',
	'interwiki_reasonfield' => 'סיבה:',
	'interwiki_delquestion' => 'מחיקת "$1"',
	'interwiki_deleting' => 'הנכם מוחקים את הקידומת "$1".',
	'interwiki_deleted' => 'הקידומת "$1" הוסרה בהצלחה מטבלת הבינוויקי.',
	'interwiki_delfailed' => 'לא ניתן להסיר את הקידומת "$1" מטבלת הבינוויקי.',
	'interwiki_addtext' => 'הוספת קידומת בינוויקי',
	'interwiki_addintro' => 'הנכם עורכים קידומת בינוויקי.
זכרו שלא ניתן לכלול רווחים ( ), נקודותיים (:), אמפרסנד (&) או הסימן שווה (=).',
	'interwiki_addbutton' => 'הוספה',
	'interwiki_added' => 'הקידומת "$1" נוספה בהצלחה לטבלת הבינוויקי.',
	'interwiki_addfailed' => 'לא ניתן להוסיף את הקידומת "$1" לטבלת הבינוויקי.
ייתכן שהיא כבר קיימת בטבלה.',
	'interwiki_edittext' => 'עריכת קידומת בינוויקי',
	'interwiki_editintro' => 'הנכם עורכים קידומת בינוויקי.
זכרו שפעולה זו עלולה לשבור קישורים קיימים.',
	'interwiki_edited' => 'הקידומת "$1" שונתה בהצלחה בטבלת הבינוויקי.',
	'interwiki_editerror' => 'לא ניתן לשנות את הקידומת "$1" בטבלת הבינוויקי.
ייתכן שהיא אינה קיימת.',
	'interwiki-badprefix' => 'קידומת הבינוויקי שצוינה, "$1", כוללת תווים בלתי תקינים',
	'interwiki_logpagename' => 'יומן טבלת הבינוויקי',
	'interwiki_log_added' => 'הקידומת "$2" ($3) (הכללה: $4) (מקומית: $5) נוספה לטבלת הבינוויקי',
	'interwiki_log_edited' => 'הקידומת "$2" : ($3) (הכללה: $4) (מקומית: $5) שונתה בטבלת הבינוויקי',
	'interwiki_log_deleted' => 'הסיר את הקידומת "$2" מטבלת הבינוויקי',
	'interwiki_logpagetext' => 'זהו יומן השינויים שנערכו ב[[Special:Interwiki|טבלת הבינוויקי]].',
	'right-interwiki' => 'עריכת נתוני הבינוויקי',
	'action-interwiki' => 'לשנות את רשומת הבינוויקי הזו',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'interwiki' => 'आंतरविकि डाटा देखें एवं बदलें',
	'interwiki-title-norights' => 'आंतरविकि डाटा देखें',
	'interwiki-desc' => 'आंतरविकि तालिका देखनेके लिये और बदलने के लिये एक [[Special:Interwiki|विशेष पॄष्ठ]]',
	'interwiki_intro' => 'आंतरविकि तालिका के बारें में अधिक ज़ानकारी के लिये [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] देखें। यहां आंतरविकि तालिका में हुए [[Special:Log/interwiki|बदलावों की सूची]] हैं।',
	'interwiki_prefix' => 'उपपद',
	'interwiki-prefix-label' => 'उपपद:',
	'interwiki_error' => 'गलती: आंतरविकि तालिका खाली हैं, या और कुछ गलत हैं।',
	'interwiki_reasonfield' => 'कारण',
	'interwiki_delquestion' => '$1 को हटा रहें हैं',
	'interwiki_deleting' => 'आप "$1" उपपद हटा रहें हैं।',
	'interwiki_deleted' => '"$1" उपपद आंतरविकि तालिकासे हटा दिया गया हैं।',
	'interwiki_delfailed' => '"$1" उपपद आंतरविकि तालिकासे हटा नहीं पा रहें हैं।',
	'interwiki_addtext' => 'एक आंतरविकि उपपद दें',
	'interwiki_addintro' => 'आप एक नया आंतरविकि उपपद बढा रहें हैं। कृपया ध्यान रहें की इसमें स्पेस ( ), विसर्ग (:), और (&), या बराबर का चिन्ह (=) नहीम दे सकतें हैं।',
	'interwiki_addbutton' => 'बढायें',
	'interwiki_added' => '$1" उपपद आंतरविकि तालिका में बढाया गया हैं।',
	'interwiki_addfailed' => '"$1" उपपद आंतरविकि तालिका में बढा नहीं पायें।
शायद वह पहले से अस्तित्वमें हैं।',
	'interwiki_edittext' => 'एक आंतरविकि उपपद बदल रहें हैं',
	'interwiki_editintro' => 'आप एक आंतरविकि उपपद बदल रहें हैं। ध्यान रखें ये पहले दी हुई कड़ीयों को तोड सकता हैं।',
	'interwiki_edited' => '"$1" उपपद आंतरविकि तालिका में बदला गया।',
	'interwiki_editerror' => '"$1" उपपद आंतरविकि तालिका में बदल नहीं पायें। शायद वह अस्तित्वमें नहीं हैं।',
	'interwiki_logpagename' => 'आंतरविकि तालिका सूची',
	'interwiki_log_added' => 'आंतरविकि तालिकामें उपपद "$2" ($3) (trans: $4) (local: $5) बढाया',
	'interwiki_log_edited' => 'आंतरविकि तालिकामें उपपद "$2" : ($3) (trans: $4) (local: $5) को बदला',
	'interwiki_log_deleted' => '"$2" उपपद आंतरविकि तालिकासे हटाया',
	'interwiki_logpagetext' => '[[Special:Interwiki|आंतरविकि तालिकामें]] हुए बदलावोंकी यह सूची है।',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'interwiki_reasonfield' => 'Rason',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'interwiki' => 'Vidi i uredi međuwiki podatke',
	'interwiki-title-norights' => 'Gledanje interwiki tablice',
	'interwiki-desc' => 'Dodaje [[Special:Interwiki|posebnu stranicu]] za gledanje i uređivanje interwiki tablice',
	'interwiki_intro' => 'Ovo je pregled međuwiki tablice. Značenja podataka u stupcima:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_local' => 'Proslijedi',
	'interwiki-local-label' => 'Proslijedi:',
	'interwiki_trans' => 'Transkludiraj',
	'interwiki-trans-label' => 'Transkludiraj:',
	'interwiki_error' => 'GREŠKA: Interwiki tablica je prazna, ili je nešto drugo neispravno.',
	'interwiki_reasonfield' => 'Razlog',
	'interwiki_delquestion' => 'Brišem "$1"',
	'interwiki_deleting' => 'Brišete prefiks "$1".',
	'interwiki_deleted' => 'Prefiks "$1" je uspješno uklonjen iz interwiki tablice.',
	'interwiki_delfailed' => 'Prefiks "$1" nije mogao biti uklonjen iz interwiki tablice.',
	'interwiki_addtext' => 'Dodaj međuwiki prefiks',
	'interwiki_addintro' => 'Uređujete novi interwiki prefiks. Upamtite, prefiks ne može sadržavati prazno mjesto ( ), dvotočku (:), znak za i (&), ili znakove jednakosti (=).',
	'interwiki_addbutton' => 'Dodaj',
	'interwiki_added' => 'Prefiks "$1" je uspješno dodan u interwiki tablicu.',
	'interwiki_addfailed' => 'Prefiks "$1" nije mogao biti dodan u interwiki tablicu. Vjerojatno već postoji u interwiki tablici.',
	'interwiki_edittext' => 'Uređivanje interwiki prefiksa',
	'interwiki_editintro' => 'Uređujete interwiki prefiks. Ovo može oštetiti postojeće poveznice.',
	'interwiki_edited' => 'Prefiks "$1" je uspješno promijenjen u interwiki tablici.',
	'interwiki_editerror' => 'Prefiks "$1" ne može biti promijenjen u interwiki tablici. Vjerojatno ne postoji.',
	'interwiki-badprefix' => 'Određeni međuwiki prefiks "$1" sadrži nedozvoljene znakove',
	'interwiki_logpagename' => 'Evidencije interwiki tablice',
	'interwiki_log_added' => 'dodan prefiks "$2" ($3) (trans: $4) (lokalno: $5) u interwiki tablicu',
	'interwiki_log_edited' => 'promijenjen prefiks "$2" : ($3) (trans: $4) (lokalno: $5) u interwiki tablici',
	'interwiki_log_deleted' => 'uklonjen prefiks "$2" iz interwiki tablice',
	'interwiki_logpagetext' => 'Ovo su evidencije promjena na [[Special:Interwiki|interwiki tablici]].',
	'right-interwiki' => 'Uređivanje interwiki podataka',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'interwiki' => 'Interwiki-daty wobhladać a změnić',
	'interwiki-title-norights' => 'Daty interwiki wobhladać',
	'interwiki-desc' => 'Přidawa [[Special:Interwiki|specialnu stronu]] za wobhladowanje a wobdźěłowanje interwiki-tabele',
	'interwiki_intro' => 'Tutón je přehlad tabele interwiki. Woznamy datow w stołpach:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_prefix_intro' => 'Prefiks interwiki, kotryž ma so we wikitekstowej syntaksy <code>[<nowiki />[prefix:<i>pagename</i>]]</code> wužiwać.',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Předłoha za URL. Zastupne znamjěsko $1 naruna so přez <i>mjeno strony</i> wikijoweho teksta, hdyž so horjeka naspomnjena wikitekstowa syntaksa wužiwa.',
	'interwiki_local' => 'Doprědka',
	'interwiki-local-label' => 'Doprědka:',
	'interwiki_local_intro' => 'Naprašowanje http do lokalneho wiki z tutym prefiksom interwiki w URL je:',
	'interwiki_local_0_intro' => 'njepřipóznaty, zwjetša přez "strona njenamakana" zablokowany',
	'interwiki_local_1_intro' => 'K cilowemu URL w definicijach wotkaza interwiki dale sposrědkowany (t. j. wobchadźa so z tym kaž z referencami w lokalnych stronach)',
	'interwiki_trans' => 'Transkludować',
	'interwiki-trans-label' => 'Transkludować:',
	'interwiki_trans_intro' => 'Jeli je so wikijowa syntaksa <code>{<nowiki />{prefix:<i>pagename</i>}}</code> wužiwa, to:',
	'interwiki_trans_1_intro' => 'Zapřijeće z cuzeho wikija dowolić, jeli zapřijeća interwiki so powšitkownje w tutym wikiju dopušćeja,',
	'interwiki_trans_0_intro' => 'je njedowolić, pohladaj skerje za stronu w mjenowym rumje Předłoha',
	'interwiki_intro_footer' => 'Hlej [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] za dalše informacije wo tabeli interwikijow.
Je [[Special:Log/interwiki|protokol změnow]] tabele interwikijow.',
	'interwiki_1' => 'haj',
	'interwiki_0' => 'ně',
	'interwiki_error' => 'ZMYLK: Interwiki-tabela je prózdna abo něšto je wopak.',
	'interwiki_edit' => 'Wobdźěłać',
	'interwiki_reasonfield' => 'Přičina:',
	'interwiki_delquestion' => 'Wušmórnja so "$1"',
	'interwiki_deleting' => 'Wušmórnješ prefiks "$1".',
	'interwiki_deleted' => 'Prefiks "$1" je so wuspěšnje z interwiki-tabele wotstronił.',
	'interwiki_delfailed' => 'Prefiks "$1" njeda so z interwiki-tabele wotstronić.',
	'interwiki_addtext' => 'Interwiki-prefiks přidać',
	'interwiki_addintro' => 'Přidawaš nowy prefiks interwiki. Wobkedźbuj, zo njesmě mjezery ( ), dwudypki (.), et-znamješka (&) abo znaki runosće (=) wobsahować.',
	'interwiki_addbutton' => 'Přidać',
	'interwiki_added' => 'Prefiks "$1" je so wuspěšnje interwiki-tabeli přidał.',
	'interwiki_addfailed' => 'Prefiks "$1" njeda so interwiki-tabeli přidać. Snano eksistuje hižo w interwiki-tabeli.',
	'interwiki_edittext' => 'Prefiks interwiki wobdźěłać',
	'interwiki_editintro' => 'Wobdźěłuješ prefiks interwiki.
Wobkedźbuj, zo to móže eksistowace wotkazy skóncować.',
	'interwiki_edited' => 'Prefiks "$1" je so wuspěšnje w tabeli interwiki změnil.',
	'interwiki_editerror' => 'Prefiks "$1" njeda so w tabeli interwiki změnić.
Snano njeeksistuje.',
	'interwiki-badprefix' => 'Podaty prefiks interwiki "$1" wobsahuje njepłaćiwe znamješka',
	'interwiki_logpagename' => 'Protokol interwiki-tabele',
	'interwiki_log_added' => 'Je "$2" ($3) (trans: $4) (lokalny: $5) interwiki-tabeli přidał',
	'interwiki_log_edited' => 'změni prefiks "$2": ($3) (trans: $4) (lokalny: $5) w tabeli interwiki',
	'interwiki_log_deleted' => 'je prefiks "$2" z interwiki-tabele wotstronił',
	'interwiki_logpagetext' => 'To je protokol změnow na [[Special:Interwiki|interwiki-tabeli]].',
	'right-interwiki' => 'Daty interwiki wobdźěłać',
	'action-interwiki' => 'tutón zapisk interwiki změnić',
);

/** Haitian (Kreyòl ayisyen)
 * @author Jvm
 * @author Masterches
 */
$messages['ht'] = array(
	'interwiki' => 'Wè epi edite enfòmasyon entèwiki yo',
	'interwiki-title-norights' => 'Wè enfòmasyon interwiki',
	'interwiki-desc' => 'Ajoute yon [[Special:Interwiki|paj espesial]] pou wè ak edite tab interwiki-a',
	'interwiki_intro' => 'Wè [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] pou plis enfòmasyon sou tab interwiki-a.
Geyen yon [[Special:Log/interwiki|jounal pou chanjman yo]] nan tab interwiki-a.',
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix:',
	'interwiki_error' => 'ERÈ:  Tab interwiki-a vid, oubien yon lòt bagay mal mache.',
	'interwiki_reasonfield' => 'Rezon',
	'interwiki_delquestion' => 'Delete "$1"',
	'interwiki_deleting' => 'W’ap delete prefix "$1".',
	'interwiki_deleted' => 'Prefix "$1" te retire nan tab interwiki-a avèk siksès.',
	'interwiki_delfailed' => 'Prefix "$1" pa t\' kapab sòti nan tab interwiki-a.',
	'interwiki_addtext' => 'Mete yon prefix interwiki',
	'interwiki_addintro' => 'W’ap mete yon nouvo prefix interwiki.
Sonje ke li pa ka genyen ladan li espace ( ), de pwen (:), anmpèsand (&), ou sign egalite (=).',
	'interwiki_addbutton' => 'Ajoute',
	'interwiki_added' => 'Prefix "$1" te ajoute sou tab interwiki-a avèk siksès.',
	'interwiki_addfailed' => 'Prefix "$1" pa t’ kapab ajoute sou tab interwiki-a.
Posibleman paske li deja ekziste nan tab interwiki-a.',
	'interwiki_edittext' => 'Edite yon prefix interwiki',
	'interwiki_editintro' => 'W’ap edite yon prefix interwiki.
Sonje ke sa ka kase chèn ki deja ekziste.',
	'interwiki_edited' => 'Prefix "$1" te modifye nan tab interwiki-a avèk siksès.',
	'interwiki_editerror' => 'Prefix "$1" pa ka modifye nan tab interwiki-a.
Posibleman li pa ekziste.',
	'interwiki_logpagename' => 'Jounal tab interwiki-a',
	'interwiki_log_added' => 'te ajoute prefix "$2" ($3) (trans: $4) (local: $5) nan tab interwiki-a',
	'interwiki_log_edited' => 'prefix ki te modifye "$2" : ($3) (trans: $4) (local: $5) nan tab interwiki-a',
	'interwiki_log_deleted' => 'prefix ki te retire "$2" nan tab interwiki-a',
	'interwiki_logpagetext' => 'Sa se yon jounal chanjman nan [[Special:Interwiki|tab interwiki-a]].',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author Gondnok
 */
$messages['hu'] = array(
	'interwiki' => 'Wikiközi hivatkozások adatainak megtekintése és szerkesztése',
	'interwiki-title-norights' => 'Wikiközi hivatkozások adatainak megtekintése',
	'interwiki-desc' => '[[Special:Interwiki|Speciális lap]], ahol megtekinthető és szerkeszthető a wikiközi hivatkozások táblája',
	'interwiki_intro' => 'Ez egy áttekintés a wikiközi hivatkozások táblájáról. Az adatok jelentése az oszlopokban:',
	'interwiki_prefix' => 'Előtag',
	'interwiki-prefix-label' => 'Előtag:',
	'interwiki_prefix_intro' => 'Wikiközi előtag az <code>[<nowiki />[előtag:<i>lapnév</i>]]</code> wikiszöveg szintaxisban való használatra.',
	'interwiki_url_intro' => 'Sablon az URL-eknek. A(z) $1 helyfoglalót le fogja cserélni a wikiszöveg <i>lapneve</i>, a fent említett wikiszöveg használata esetén.',
	'interwiki_local' => 'Továbbítás',
	'interwiki-local-label' => 'Továbbítás:',
	'interwiki_local_intro' => 'Egy HTTP kérés a helyi wikihez ezzel a wikiközi előtaggal az URL-ben:',
	'interwiki_local_0_intro' => 'nem teljesül, általában blokkolja a „lap nem található”,',
	'interwiki_local_1_intro' => 'átirányítva a wikiközi hivatkozások definícióiban megadott cél URL-re  (azaz olyan, mint a hivatkozások a helyi lapokon)',
	'interwiki_trans' => 'Wikiközi beillesztés',
	'interwiki-trans-label' => 'Wikiközi beillesztés:',
	'interwiki_trans_intro' => 'Ha az <code>{<nowiki />{előtag:<i>lapnév</i>}}</code> wikiszöveg szintaxist használjuk, akkor:',
	'interwiki_trans_1_intro' => 'engedd a beillesztést az idegen wikiről, ha a wikiközi beillesztések általában megengedettek ezen a wikin,',
	'interwiki_trans_0_intro' => 'ne engedd, inkább keress egy lapot a sablon névtérben.',
	'interwiki_intro_footer' => 'Az interwiki táblázattal kapcsolatos további információkért lásd a [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org]-on.
A táblázat változásait [[Special:Log/interwiki|a naplóban megnézheted]].',
	'interwiki_1' => 'igen',
	'interwiki_0' => 'nem',
	'interwiki_error' => 'Hiba: A wikiközi hivatkozások táblája üres, vagy valami más romlott el.',
	'interwiki_edit' => 'Szerkesztés',
	'interwiki_reasonfield' => 'Indoklás:',
	'interwiki_delquestion' => '„$1” törlése',
	'interwiki_deleting' => 'A(z) „$1” előtag törlésére készülsz.',
	'interwiki_deleted' => 'A(z) „$1” előtagot sikeresen eltávolítottam a wikiközi hivatkozások táblájából.',
	'interwiki_delfailed' => 'A(z) „$1” előtagot nem sikerült eltávolítanom a wikiközi hivatkozások táblájából.',
	'interwiki_addtext' => 'Wikiközi hivatkozás előtag hozzáadása',
	'interwiki_addintro' => 'Új wikiközi hivatkozás előtag hozzáadására készülsz. Ügyelj arra, hogy ne tartalmazzon szóközt ( ), kettőspontot (:), és- (&), vagy egyenlő (=) jeleket.',
	'interwiki_addbutton' => 'Hozzáadás',
	'interwiki_added' => 'A(z) „$1” előtagot sikeresen hozzáadtam az wikiközi hivatkozások táblájához.',
	'interwiki_addfailed' => 'A(z) „$1” előtagot nem tudtam hozzáadni a wikiközi hivatkozások táblájához. Valószínűleg már létezik.',
	'interwiki_edittext' => 'Wikiközi hivatkozás előtagjának módosítása',
	'interwiki_editintro' => 'Egy wikiközi hivatkozás előtagját akarod módosítani.
Ne feledd, hogy ez működésképtelenné teheti a már létező hivatkozásokat!',
	'interwiki_edited' => 'A „$1” előtagot sikeresen módosítottad a wikiközi hivatkozások táblájában.',
	'interwiki_editerror' => 'A(z) „$1” előtagot nem lehet módosítani a wikiközi hivatkozások táblájában.
Valószínűleg nem létezik ilyen előtag.',
	'interwiki-badprefix' => 'A wikiközi hivatkozásnak megadott „$1” előtag érvénytelen karaktereket tartalmaz',
	'interwiki_logpagename' => 'Interwiki tábla-napló',
	'interwiki_log_added' => 'hozzáadta a(z) „$2” előtagot ($3) (trans: $4) (local: $5) a wikiközi hivatkozások táblájához',
	'interwiki_log_edited' => 'módosította a(z) „$2” előtagot : ($3) (trans: $4) (local: $5) a wikiközi hivatkozások táblájában',
	'interwiki_log_deleted' => 'eltávolította a(z) „$2” előtagot a wikiközi hivatkozások táblájából',
	'interwiki_logpagetext' => 'Ez az [[Special:Interwiki|interwiki táblában]] történt változások naplója.',
	'right-interwiki' => 'wikiközi hivatkozások módosítása',
	'action-interwiki' => 'eme wikiközi bejegyzés megváltoztatása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'interwiki' => 'Vider e modificar datos interwiki',
	'interwiki-title-norights' => 'Vider datos interwiki',
	'interwiki-desc' => 'Adde un [[Special:Interwiki|pagina special]] pro vider e modificar le tabella interwiki',
	'interwiki_intro' => 'Isto es un summario del tabella interwiki. Significatos del datos in le columnas:',
	'interwiki_prefix' => 'Prefixo',
	'interwiki-prefix-label' => 'Prefixo:',
	'interwiki_prefix_intro' => 'Prefixo interwiki pro usar in le syntaxe de wikitexto <code>[<nowiki />[prefixo:<i>nomine de pagina</i>]]</code>.',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Patrono pro adresses URL. Le marcator $1 essera reimplaciate per le <i>nomine de pagina</i> del wikitexto, quando le syntaxe de wikitexto supra mentionate es usate.',
	'interwiki_local' => 'Facer sequer',
	'interwiki-local-label' => 'Facer sequer:',
	'interwiki_local_intro' => 'Un requesta HTTP al wiki local con iste prefixo interwiki in le adresse URL es:',
	'interwiki_local_0_intro' => 'refusate, normalmente blocate con "pagina non trovate",',
	'interwiki_local_1_intro' => 'redirigite verso le adresse URL de destination specificate in le definitiones de ligamines interwiki (i.e. tractate como referentias in paginas local)',
	'interwiki_trans' => 'Transcluder',
	'interwiki-trans-label' => 'Transcluder:',
	'interwiki_trans_intro' => 'Si le syntaxe de wikitexto <code>{<nowiki />{prefixo:<i>nomine de pagina</i>}}</code> es usate, alora:',
	'interwiki_trans_1_intro' => 'permitte le transclusion ab le wiki externe, si le transclusiones interwiki es generalmente permittite in iste wiki,',
	'interwiki_trans_0_intro' => 'non permitte lo, ma cerca un pagina in le spatio de nomines "Patrono".',
	'interwiki_intro_footer' => 'Vide [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] pro plus informationes super le tabella interwiki.
Existe un [[Special:Log/interwiki|registro de modificationes]] al tabella interwiki.',
	'interwiki_1' => 'si',
	'interwiki_0' => 'no',
	'interwiki_error' => 'Error: Le tabella interwiki es vacue, o un altere cosa faceva falta.',
	'interwiki_edit' => 'Modificar',
	'interwiki_reasonfield' => 'Motivo:',
	'interwiki_delquestion' => 'Deletion de "$1"',
	'interwiki_deleting' => 'Tu sta super le puncto de deler le prefixo "$1".',
	'interwiki_deleted' => 'Le prefixo "$1" ha essite removite del tabella interwiki con successo.',
	'interwiki_delfailed' => 'Le prefixo "$1" non poteva esser removite del tabella interwiki.',
	'interwiki_addtext' => 'Adder un prefixo interwiki',
	'interwiki_addintro' => 'Tu sta super le puncto de adder un nove prefixo interwiki.
Memora que illo non pote continer spatios (&nbsp;), duo punctos (:), signos et (&), o signos equal (=).',
	'interwiki_addbutton' => 'Adder',
	'interwiki_added' => 'Le prefixo "$1" ha essite addite al tabella interwiki con successo.',
	'interwiki_addfailed' => 'Le prefixo "$1" non poteva esser addite al tabella interwiki.
Es possibile que illo ja existe in le tabella interwiki.',
	'interwiki_edittext' => 'Modificar un prefixo interwiki',
	'interwiki_editintro' => 'Tu modifica un prefixo interwiki.
Memora que isto pote rumper ligamines existente.',
	'interwiki_edited' => 'Le prefixo "$1" ha essite modificate in le tabella interwiki con successo.',
	'interwiki_editerror' => 'Le prefixo "$1" non pote esser modificate in le tabella interwiki.
Es possibile que illo non existe.',
	'interwiki-badprefix' => 'Le prefixo interwiki specificate "$1" contine characteres invalide',
	'interwiki_logpagename' => 'Registro del tabella interwiki',
	'interwiki_log_added' => 'addeva le prefixo "$2" ($3) (trans: $4) (local: $5) al tabella interwiki',
	'interwiki_log_edited' => 'modificava le prefixo "$2" : ($3) (trans: $4) (local: $5) in le tabella interwiki',
	'interwiki_log_deleted' => 'removeva le prefixo "$2" del tabella interwiki',
	'interwiki_logpagetext' => 'Isto es un registro de modificationes in le [[Special:Interwiki|tabella interwiki]].',
	'right-interwiki' => 'Modificar datos interwiki',
	'action-interwiki' => 'alterar iste entrata interwiki',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'interwiki' => 'Lihat dan sunting data interwiki',
	'interwiki-title-norights' => 'Lihat data interwiki',
	'interwiki-desc' => 'Menambahkan sebuah [[Special:Interwiki|halaman istimewa]] untuk menampilkan dan menyunting tabel interwiki',
	'interwiki_intro' => 'Ini adalah sebuah laporan mengenai tabel interwiki. Arti dari data di kolom:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_prefix_intro' => 'Interwiki prefix akan digunakan dalam  <code>[<nowiki />[prefix:<i>pagename</i>]]</code> sintak teksWiki',
	'interwiki_url_intro' => 'Template untuk URL. Tempat $1 akan digantikan oleh <i>judul</i> dari teksWiki, ketika  sintaks teksWiki tersebut di atas digunakan.',
	'interwiki_local' => 'Meneruskan',
	'interwiki-local-label' => 'Meneruskan:',
	'interwiki_local_intro' => 'Diperlukan HTTP untuk wiki lokal dengan prefix interwiki ini dalam URL:',
	'interwiki_local_0_intro' => 'tidak dihormati, biasanya diblokir oleh "halaman tidak ditemukan",',
	'interwiki_local_1_intro' => 'pengalihan ke URL target akan meberikan definis pranala interwiki (contoh. seperti referensi di halaman lokal)',
	'interwiki_trans' => 'Transclude',
	'interwiki-trans-label' => 'Mentransklusikan:',
	'interwiki_trans_intro' => 'Jika sintak tekswiki <code>{<nowiki />{prefix:<i>pagename</i>}}</code> digunakan, maka:',
	'interwiki_trans_1_intro' => 'memperbolehkan transklusi dari wiki lain, jika transklusi interwiki diizinkan di wiki ini,',
	'interwiki_trans_0_intro' => 'tidak mengizinkan hal itu, lebih baik mencari halaman pada ruang nama templat.',
	'interwiki_intro_footer' => 'Lihat [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] untuk informasi lebih lanjut tentang tabel interwiki.
Ada [[Special:Log/interwiki|log perubahan]] ke tabel interwiki.',
	'interwiki_1' => 'ya',
	'interwiki_0' => 'tidak',
	'interwiki_error' => 'KESALAHAN: Tabel interwiki kosong, atau terjadi kesalahan lain.',
	'interwiki_edit' => 'Sunting',
	'interwiki_reasonfield' => 'Alasan:',
	'interwiki_delquestion' => 'Menghapus "$1"',
	'interwiki_deleting' => 'Anda menghapus prefiks "$1".',
	'interwiki_deleted' => 'Prefiks "$1" berhasil dihapus dari tabel interwiki.',
	'interwiki_delfailed' => 'Prefiks "$1" tidak dapat dihapuskan dari tabel interwiki.',
	'interwiki_addtext' => 'Menambahkan sebuah prefiks interwiki',
	'interwiki_addintro' => 'Anda akan menambahkan sebuah prefiks interwiki.
Ingat bahwa prefiks tidak boleh mengandung tanda spasi ( ), titik dua (:), lambang dan (&), atau tanda sama dengan (=).',
	'interwiki_addbutton' => 'Tambahkan',
	'interwiki_added' => 'Prefiks "$1" berhasil ditambahkan ke tabel interwiki.',
	'interwiki_addfailed' => 'Prefiks "$1" tidak dapat ditambahkan ke tabel interwiki. Kemungkinan dikarenakan prefiks ini telah ada di tabel interwiki.',
	'interwiki_edittext' => 'Menyunting sebuah prefiks interwiki',
	'interwiki_editintro' => 'Anda sedang menyunting sebuah prefiks interwiki.
Ingat bahwa tindakan ini dapat mempengaruhi pranala yang telah eksis.',
	'interwiki_edited' => 'Prefiks "$1" berhasil diubah di tabel interwiki.',
	'interwiki_editerror' => 'Prefiks "$1" tidak dapat diubah di tabel interwiki.
Kemungkinan karena prefiks ini tidak ada.',
	'interwiki-badprefix' => 'Ditentukan interwiki awalan "$1" mengandung karakter yang tidak sah',
	'interwiki_logpagename' => 'Log tabel interwiki',
	'interwiki_log_added' => 'menambahkan prefiks "$2" ($3) (trans: $4) (lokal: $5) ke tabel interwiki',
	'interwiki_log_edited' => 'mengubah prefiks "$2" : ($3) (trans: $4) (lokal: $5) di tabel interwiki',
	'interwiki_log_deleted' => 'menghapus prefiks "$2" dari tabel interwiki',
	'interwiki_logpagetext' => 'Ini adalah log perubahan [[Special:Interwiki|tabel interwiki]].',
	'right-interwiki' => 'Menyunting data interwiki',
	'action-interwiki' => 'Ubah masukan untuk interwiki ini',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'interwiki_1' => 'yes',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'interwiki_reasonfield' => 'Ástæða',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Cruccone
 * @author Darth Kule
 * @author Pietrodn
 */
$messages['it'] = array(
	'interwiki' => 'Visualizza e modifica i dati interwiki',
	'interwiki-title-norights' => 'Visualizza i dati interwiki',
	'interwiki-desc' => 'Aggiunge una [[Special:Interwiki|pagina speciale]] per visualizzare e modificare la tabella degli interwiki',
	'interwiki_intro' => 'Questa è una panoramica della tabella degli interwiki. Il significato dei dati nelle colonne:',
	'interwiki_prefix' => 'Prefisso',
	'interwiki-prefix-label' => 'Prefisso:',
	'interwiki_prefix_intro' => 'Prefisso interwiki da utilizzare nella sintassi <code>[<nowiki />[prefisso:<i>nomepagina</i>]]</code>.',
	'interwiki_url_intro' => 'Modello per gli URL. $1 sarà sostituito dal <i>nomepagina</i> del testo, quando la suddetta sintassi viene utilizzata.',
	'interwiki_local_intro' => "Una richiesta HTTP al sito locale con questo prefisso interwiki nell'URL è:",
	'interwiki_local_0_intro' => 'non eseguita, di solito bloccata da "pagina non trovata",',
	'interwiki_local_1_intro' => "reindirizzata all'URL di destinazione indicato nella definizione del link interwiki (cioè trattati come riferimenti nelle pagine locali)",
	'interwiki_trans' => 'Inclusione',
	'interwiki-trans-label' => 'Inclusione:',
	'interwiki_trans_intro' => 'Se la sintassi <code>{<nowiki />{prefisso:<i>nomepagina</i>}}</code> è usata, allora:',
	'interwiki_trans_1_intro' => "permette l'inclusione da siti esterni, se le inclusioni interwiki sono generalmente permesse in questo sito,",
	'interwiki_trans_0_intro' => 'non la permette, invece cerca una pagina nel namespace template.',
	'interwiki_intro_footer' => 'Consultare [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] per maggiori informazioni sulle tabelle degli interwiki. Esiste un [[Special:Log/interwiki|registro delle modifiche]] alla tabella degli interwiki.',
	'interwiki_1' => 'si',
	'interwiki_0' => 'no',
	'interwiki_error' => "ERRORE: La tabella degli interwiki è vuota, o c'è qualche altro errore.",
	'interwiki_edit' => 'Modifica',
	'interwiki_reasonfield' => 'Motivo:',
	'interwiki_delquestion' => 'Cancello "$1"',
	'interwiki_deleting' => 'Stai cancellando il prefisso "$1"',
	'interwiki_deleted' => 'Il prefisso "$1" è stato cancellato con successo dalla tabella degli interwiki.',
	'interwiki_delfailed' => 'Rimozione del prefisso "$1" dalla tabella degli interwiki fallita.',
	'interwiki_addtext' => 'Aggiungi un prefisso interwiki',
	'interwiki_addintro' => 'Sta per essere aggiunto un nuovo prefisso interwiki.
Non sono ammessi i caratteri: spazio ( ), due punti (:), e commerciale (&), simbolo di uguale (=).',
	'interwiki_addbutton' => 'Aggiungi',
	'interwiki_added' => 'Il prefisso "$1" è stato aggiunto alla tabella degli interwiki.',
	'interwiki_addfailed' => 'Impossibile aggiungere il prefisso "$1" alla tabella degli interwiki.
Il prefisso potrebbe essere già presente in tabella.',
	'interwiki_edittext' => 'Modifica di un prefisso interwiki',
	'interwiki_editintro' => 'Si sta modificando un prefisso interwiki.
Ciò può rendere non funzionanti dei collegamenti esistenti.',
	'interwiki_edited' => 'Il prefisso "$1" è stato modificato nella tabella degli interwiki.',
	'interwiki_editerror' => 'Impossibile modificare il prefisso "$1" nella tabella degli interwiki.
Il prefisso potrebbe essere inesistente.',
	'interwiki-badprefix' => 'Il prefisso interwiki "$1" specificato contiene caratteri non validi',
	'interwiki_logpagename' => 'Registro tabella interwiki',
	'interwiki_log_added' => 'ha aggiunto il prefisso "$2" ($3) (trans: $4) (locale: $5) alla tabella degli interwiki',
	'interwiki_log_edited' => 'ha modificato il prefisso "$2" : ($3) (trans: $4) (locale: $5) nella tabella degli interwiki',
	'interwiki_log_deleted' => 'ha rimosso il prefisso "$2" dalla tabella degli interwiki',
	'interwiki_logpagetext' => 'Registro dei cambiamenti apportati alla [[Special:Interwiki|tabella degli interwiki]].',
	'right-interwiki' => 'Modifica i dati interwiki',
	'action-interwiki' => 'modificare questo interwiki',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Mzm5zbC3
 */
$messages['ja'] = array(
	'interwiki' => 'インターウィキデータの閲覧と編集',
	'interwiki-title-norights' => 'インターウィキデータの一覧',
	'interwiki-desc' => 'インターウィキテーブルの表示と編集を行う[[Special:Interwiki|特別ページ]]を追加する',
	'interwiki_intro' => '以下はインターウィキの一覧表です。各欄のデータの意味は次の通りです:',
	'interwiki_prefix' => '接頭辞',
	'interwiki-prefix-label' => '接頭辞:',
	'interwiki_prefix_intro' => '<code>[<nowiki />[接頭辞:<i>ページ名</i>]]</code> というウィキテキストの構文で使われる、インターウィキ接頭辞。',
	'interwiki_url_intro' => 'URLの雛型。$1 というプレースホルダーは、上で述べた構文における「<i>ページ名</i>」で置換されます。',
	'interwiki_local' => '転送',
	'interwiki-local-label' => '転送:',
	'interwiki_local_intro' => 'URLにこの接頭辞をもつ、ローカルウィキへのHTTP要求は、',
	'interwiki_local_0_intro' => '無効です。「ページは存在しません」などと表示されます。',
	'interwiki_local_1_intro' => 'インターウィキウィキリンクの定義で指定された対象URLに転送されます。言い換えると、同一ウィキ内のページへのリンクのように扱います。',
	'interwiki_trans' => 'トランスクルージョン',
	'interwiki-trans-label' => 'トランスクルージョン:',
	'interwiki_trans_intro' => '<code>{<nowiki />{接頭辞:<i>ページ名</i>}}</code> というウィキテキストの構文が使われた場合、',
	'interwiki_trans_1_intro' => 'ウィキ間トランスクルージョンがこのウィキで（一般的に）許可されているならば、この外部ウィキからのトランスクルージョンを許可します。',
	'interwiki_trans_0_intro' => '許可せず、テンプレート名前空間でページを探します。',
	'interwiki_intro_footer' => 'インターウィキテーブルについて、より詳しくは [http://www.mediawiki.org/wiki/Interwiki_table/ja MediaWiki.org] を参照してください。また、インターウィキテーブルの[[Special:Log/interwiki|変更記録]]があります。',
	'interwiki_1' => 'はい',
	'interwiki_0' => 'いいえ',
	'interwiki_error' => 'エラー: インターウィキテーブルが空か、他の理由でうまくいきませんでした。',
	'interwiki_edit' => '編集',
	'interwiki_reasonfield' => '理由:',
	'interwiki_delquestion' => '"$1"を削除',
	'interwiki_deleting' => 'あなたは接頭辞 "$1" を削除しようとしています。',
	'interwiki_deleted' => '接頭辞 "$1" はインターウィキテーブルから正常に削除されました。',
	'interwiki_delfailed' => '接頭辞 "$1" をインターウィキテーブルから削除できませんでした。',
	'interwiki_addtext' => 'インターウィキの接頭辞を追加する',
	'interwiki_addintro' => 'あなたはインターウィキの新しい接頭辞を追加しようとしています。その中にスペース ( )、コロン (:)、アンパーサンド (&)、等号 (=) といった記号を含むことができないことに注意してください。',
	'interwiki_addbutton' => '追加',
	'interwiki_added' => '接頭辞 "$1" はインターウィキテーブルに正常に追加されました。',
	'interwiki_addfailed' => '接頭辞 "$1" をインターウィキテーブルに追加することができませんでした。すでに同じものが、インターウィキテーブルの中に存在している可能性があります。',
	'interwiki_edittext' => 'インターウィキ用接頭辞の編集',
	'interwiki_editintro' => 'あなたはインターウィキ用接頭辞を編集しようとしています。この作業によりすでに存在しているリンクを破壊する可能性があります。',
	'interwiki_edited' => '接頭辞 "$1" はインターウィキテーブル内で正常に変更されました。',
	'interwiki_editerror' => 'インターウィキテーブル内で接頭辞 "$1" を変更できませんでした。存在していない可能性があります。',
	'interwiki-badprefix' => '指定されたインターウィキ接頭辞 "$1" は無効な文字を含んでいます',
	'interwiki_logpagename' => 'インターウィキ編集記録',
	'interwiki_log_added' => 'インターウィキテーブルに接頭辞 "$2" ($3) (trans: $4) (local: $5) を追加しました',
	'interwiki_log_edited' => 'インターウィキテーブル内の接頭辞 "$2" を ($3) (trans: $4) (local: $5) に変更しました',
	'interwiki_log_deleted' => 'インターウィキテーブルから接頭辞 "$2" を削除しました',
	'interwiki_logpagetext' => 'これは[[Special:Interwiki|インターウィキテーブル]]の変更記録です。',
	'right-interwiki' => 'インターウィキデータの編集',
	'action-interwiki' => 'このインターウィキ項目の変更',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'interwiki' => 'Ndeleng lan nyunting data interwiki',
	'interwiki-title-norights' => 'Ndeleng data interwiki',
	'interwiki-desc' => 'Nambahaké sawijining [[Special:Interwiki|kaca astaméwa]] kanggo ndeleng lan nyunting tabèl interwiki',
	'interwiki_intro' => 'Iki sawijining gambaran saka tabel interwiki. Makna data sing ana ing kolom:',
	'interwiki_prefix' => 'Préfiks (sisipan awal)',
	'interwiki-prefix-label' => 'Préfiks (sisipan awal):',
	'interwiki_error' => 'KALUPUTAN: Tabèl interwikiné kosong, utawa ana masalah liya.',
	'interwiki_reasonfield' => 'Alesan',
	'interwiki_delquestion' => 'Mbusak "$1"',
	'interwiki_deleting' => 'Panjenengan mbusak préfiks utawa sisipan awal "$1".',
	'interwiki_deleted' => 'Préfisk "$1" bisa kasil dibusak saka tabèl interwiki.',
	'interwiki_delfailed' => 'Préfiks "$1" ora bisa diilangi saka tabèl interwiki.',
	'interwiki_addtext' => 'Nambah préfiks interwiki',
	'interwiki_addintro' => 'Panjenengan nambah préfiks utawa sisipan awal interwiki anyar.
Élinga yèn iku ora bisa ngandhut spasi ( ), pada pangkat (:), ampersands (&), utawa tandha padha (=).',
	'interwiki_addbutton' => 'Nambah',
	'interwiki_added' => 'Préfiks utawa sisipan awal "$1" bisa kasil ditambahaké ing tabèl interwiki.',
	'interwiki_addfailed' => 'Préfiks "$1" ora bisa ditambahaké ing tabèl interwiki.
Mbok-menawa iki pancèn wis ana ing tabèl interwiki.',
	'interwiki_edittext' => 'Nyunting sawijining préfiks interwiki',
	'interwiki_editintro' => 'Panjenengan nyunting préfiks interwiki.
Élinga yèn iki ora bisa nugel pranala-pranala sing wis ana.',
	'interwiki_edited' => 'Préfiks "$1" bisa suksès dimodifikasi ing tabèl interwiki.',
	'interwiki_editerror' => 'Préfiks utawa sisipan awal "$1" ora bisa dimodifikasi ing tabèl interwiki.
Mbok-menawa iki ora ana.',
	'interwiki_logpagename' => 'Log tabèl interwiki',
	'interwiki_log_added' => 'nambahaké préfiks (sisipan awal) "$2" ($3) (trans: $4) (local: $5) ing tabèl interwiki',
	'interwiki_log_edited' => 'modifikasi préfiks (sisipan awal) "$2" : ($3) (trans: $4) (local: $5) ing tabèl interwiki',
	'interwiki_log_deleted' => 'ngilangi sisipan awal (préfiks) "$2" saka tabèl interwiki',
	'interwiki_logpagetext' => 'Kaca iki log owah-owahan kanggo [[Special:Interwiki|tabèl interwiki]].',
);

/** Georgian (ქართული)
 * @author Malafaya
 */
$messages['ka'] = array(
	'interwiki_reasonfield' => 'მიზეზი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'interwiki' => 'មើលនិងកែប្រែទិន្នន័យអន្តរវិគី',
	'interwiki-title-norights' => 'មើលទិន្នន័យអន្តរវិគី',
	'interwiki-desc' => 'បន្ថែម[[Special:Interwiki|ទំព័រពិសេស]]ដើម្បីមើលនិងកែប្រែតារាងអន្តរវិគី',
	'interwiki_intro' => 'នេះ​គឺជា​ទិដ្ឋភាពទូទៅ​នៃ​តារាង​អន្តរវិគី​។ ដែល​ជា​អត្ថន័យ​នៃ​ទិន្នន័យ​នៅ​ក្នុង​ជួរឈរ:',
	'interwiki_prefix' => 'បុព្វបទ',
	'interwiki-prefix-label' => 'បុព្វបទ:',
	'interwiki_error' => 'កំហុស:តារាងអន្តរវិគីគឺទទេ ឬក៏មានអ្វីផ្សេងទៀតមានបញ្ហា។',
	'interwiki_edit' => 'កែប្រែ​',
	'interwiki_reasonfield' => 'មូលហេតុ',
	'interwiki_delquestion' => 'ការលុបចេញ "$1"',
	'interwiki_deleting' => 'លោកអ្នកកំពុងលុបបុព្វបទ "$1"។',
	'interwiki_deleted' => 'បុព្វបទ"$1"បានដកចេញពីតារាងអន្តរវិគីដោយជោគជ័យហើយ។',
	'interwiki_delfailed' => 'បុព្វបទ"$1"មិនអាចដកចេញពីតារាងអន្តរវិគីបានទេ។',
	'interwiki_addtext' => 'បន្ថែមបុព្វបទអន្តរវិគី',
	'interwiki_addintro' => 'អ្នកកំពុងបន្ថែមបុព្វបទអន្តរវិគីថ្មីមួយ។

សូមចងចាំថាវាមិនអាចមាន ដកឃ្លា( ) ចុច២(:) សញ្ញានិង(&) ឬសញ្ញាស្មើ(=)បានទេ។',
	'interwiki_addbutton' => 'បន្ថែម',
	'interwiki_added' => 'បុព្វបទ "$1" ត្រូវបានបន្ថែមទៅក្នុងតារាងអន្តរវិគីដោយជោគជ័យ។',
	'interwiki_addfailed' => 'បុព្វបទ "$1" មិនអាចបន្ថែមទៅក្នុងតារាងអន្តរវិគីបានទេ។

ប្រហែលជាវាមានរួចហើយនៅក្នុងតារាងអន្តរវិគី។',
	'interwiki_edittext' => 'ការកែប្រែបុព្វបទអន្តរវិគី',
	'interwiki_editintro' => 'អ្នកកំពុងកែប្រែបុព្វបទអន្តរវិគី។

ចូរចងចាំថាវាអាចនាំឱ្យខូចតំណភ្ជាប់ដែលមានស្រេច។',
	'interwiki_edited' => 'បុព្វបទ"$1"ត្រូវបានកែសម្រួលក្នុងតារាងអន្តរវិគីដោយជោគជ័យហើយ។',
	'interwiki_editerror' => 'បុព្វបទ "$1" មិនអាចកែសម្រួលនៅក្នុងតារាងអន្តរវិគីបានទេ។

ប្រហែលជាវាមិនមានអត្ថិភាពទេ។',
	'interwiki_logpagename' => 'កំណត់ហេតុតារាងអន្តរវិគី',
	'interwiki_log_added' => 'បានបន្ថែម "$2" ($3) (trans: $4) (local: $5) ក្នុងតារាងអន្តរវិគី ៖',
	'interwiki_log_edited' => 'កែសម្រួលបុព្វបទ "$2" : ($3) (trans: $4) (local: $5) នៅក្នុងតារាងអន្តរវិគី',
	'interwiki_log_deleted' => 'បានដកបុព្វបទ"$2"ចេញពីតារាងអន្តរវិគី',
	'interwiki_logpagetext' => 'នេះជាកំណត់ហេតុនៃបំលាស់ប្តូរក្នុង[[Special:Interwiki|តារាងអន្តរវិគី]]។',
	'right-interwiki' => 'កែប្រែទិន្នន័យអន្តរវិគី',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'interwiki_1' => 'ಹೌದು',
	'interwiki_0' => 'ಇಲ್ಲ',
	'interwiki_reasonfield' => 'ಕಾರಣ:',
);

/** Korean (한국어)
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'interwiki' => '인터위키 목록 보기/고치기',
	'interwiki-title-norights' => '인터위키 보기',
	'interwiki-desc' => '인터위키 표를 보거나 고칠 수 있는 [[Special:Interwiki|특수문서]]를 추가',
	'interwiki_intro' => '이 페이지는 인터위키 표에 대한 둘러보기 표입니다. 각 단의 데이터는 다음을 의미합니다:',
	'interwiki_prefix' => '접두어',
	'interwiki-prefix-label' => '접두어:',
	'interwiki_local' => '이것을 로컬 위키로 정의',
	'interwiki-local-label' => '이것을 로컬 위키로 정의:',
	'interwiki_trans' => '인터위키 포함',
	'interwiki-trans-label' => '인터위키 포함:',
	'interwiki_1' => '예',
	'interwiki_0' => '아니오',
	'interwiki_error' => '오류: 인터위키 표가 비어 있거나 다른 무엇인가가 잘못되었습니다.',
	'interwiki_reasonfield' => '이유',
	'interwiki_delquestion' => '"$1" 지우기',
	'interwiki_deleting' => '접두어 "$1"을(를) 지웁니다.',
	'interwiki_deleted' => '접두어 "$1"을(를) 지웠습니다.',
	'interwiki_delfailed' => '접두어 "$1"을(를) 지울 수 없습니다.',
	'interwiki_addtext' => '접두어 더하기',
	'interwiki_addintro' => '새 인터위키 접두어를 만듭니다. 공백( ), 쌍점(:), &기호(&), 등호(=)는 포함할 수 없습니다.',
	'interwiki_addbutton' => '더하기',
	'interwiki_added' => '접두어 "$1"을(를) 더했습니다.',
	'interwiki_addfailed' => '접두어 "$1"을(를) 더할 수 없습니다. 이미 표에 있을 수 있습니다.',
	'interwiki_edittext' => '접두어 고치기',
	'interwiki_editintro' => '인터위키 접두어를 고칩니다. 이미 만들어진 인터위키를 망가뜨릴 수 있으니 주의해 주세요.',
	'interwiki_edited' => '접두어 "$1"을(를) 고쳤습니다.',
	'interwiki_editerror' => '접두어 "$1"을(를) 고칠 수 없습니다. 목록에 없는 접두어일 수 있습니다.',
	'interwiki-badprefix' => '당신이 입력한 인터위키 접두어 "$1"은(는) 잘못된 문자를 포함하고 있습니다.',
	'interwiki_logpagename' => '인터위키 수정 기록',
	'interwiki_log_added' => '접두어 "$2" ($3) (trans: $4) (local: $5) 을(를) 인터위키 목록에 더했습니다.',
	'interwiki_log_edited' => '접두어 "$2" ($3) (trans: $4) (local: $5) 을(를) 인터위키 목록에서 고쳤습니다.',
	'interwiki_log_deleted' => '접두어 "$2"을(를) 인터위키 목록에서 지웠습니다.',
	'interwiki_logpagetext' => '[[Special:Interwiki|인터위키]] 목록의 바뀐 내역입니다.',
	'right-interwiki' => '인터위키 목록을 편집',
	'action-interwiki' => '이 인터위키 접두어를 수정',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'interwiki' => 'Engerwiki Date beloere un änndere',
	'interwiki-title-norights' => 'Engerwiki Date beloore',
	'interwiki-desc' => 'Brengk de Sondersigg [[Special:Interwiki]], öm Engerwiki Date ze beloore un ze ändere.',
	'interwiki_intro' => 'Hee is ene Övverbleck övver de Engerwiki-Tabäll.
De Daate en de einzel Shpallde bedügge:',
	'interwiki_prefix' => 'Försaz',
	'interwiki-prefix-label' => 'Försaz:',
	'interwiki_prefix_intro' => 'Dä Fösatz för Engewiki Lengks wie hä em Wikitex en Sigge jebruch weed, wam_mer <code>[<nowiki />[<i>{{lc:{{int:Interwiki_prefix}}}}</i>:<i>Siggename</i>]]</code> schrieve deijt.',
	'interwiki_url' => 'URL',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'E Muster för en URL. Dä Plazhallder „$1“ do dren weet ußjetuusch, wann dat Denge jebruch weet — wann di Syntax vun bovve em Wikitext op en Sigg aanjezeish weed, dann kütt dä <code><i">Siggenam</i></code> aan dä Plaz vun däm $1.',
	'interwiki_local' => 'Wiggerjevve?',
	'interwiki-local-label' => 'Wiggerjevve?:',
	'interwiki_local_intro' => 'Wann övver et Internet ene Sigge-Oproof aan dat Wiki hee jescheck weed, un dä Försatz es em Sigge-Tittel dren, dann:',
	'interwiki_local_0_intro' => 'donn dä nit als ene Vöratz behandelle, un sök noh su en Sigg hee em Wiki — dat jeiht fö jewööhnlesch uß met: „esu en Sigg hann mir nit“,',
	'interwiki_local_1_intro' => 'dä Oproof weed wiggerjejovve aan dä Wiki, esu wi et hee unger URL enjedraaren es, well heiße, dä weed jenou esu behandelt, wi ene Oproof ennerhallf vun en Sigg hee em Wiki.',
	'interwiki_trans' => 'Ennfööje?',
	'interwiki-trans-label' => 'Ennfööje?:',
	'interwiki_trans_intro' => 'Wann em Wikitex en ener Sigg de Syntax <code>{<nowiki />{<i>{{lc:{{int:Interwiki_prefix}}}}</i>:<i>Siggename</i>}}</code> jebruch weed, dann:',
	'interwiki_trans_1_intro' => 'lohß et zoh — wann dat en hee dämm Wiki övverhoup zohjelohße es — dat en Sigg uß däm andere Wiki hee enjeföösh weed,',
	'interwiki_trans_0_intro' => 'dunn dat nit, un sök hee em Wiki noh ene {{ns:template}} met dämm komplätte Name.',
	'interwiki_intro_footer' => 'Op dä Sigg [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] fingk mer mieh do dröver, wat et met dä Tabäll met de Engerwiki Date op sich hät.
Et [[Special:Log/interwiki|{{int:interwiki_logpagename}}]] zeichnet all de Änderunge aan de Engerwiki Date op.',
	'interwiki_1' => 'Jo',
	'interwiki_0' => 'Nä',
	'interwiki_error' => "'''Fähler:''' de Tabäll met de Engerwiki Date is leddisch.",
	'interwiki_edit' => 'Beärbeide',
	'interwiki_reasonfield' => 'Aanlass:',
	'interwiki_delquestion' => '„$1“ weed fottjeschmeße',
	'interwiki_deleting' => 'Do wells dä Engerwiki Försaz „$1“ fott schmiiße.',
	'interwiki_deleted' => 'Dä Försaz „$1“ es jäz uß dä Engerwiki Date erusjeschmesse.',
	'interwiki_delfailed' => 'Dä Försaz „$1“ konnt nit uß dä Engerwiki Date jenomme wääde.',
	'interwiki_addtext' => 'Ene Engerwiki Försaz dobei donn',
	'interwiki_addintro' => 'Do bes ennem Engerwiki Försaz dobei aam donn.
Denk draan, et dörfe kei Zweschräum ( ), Koufmanns-Un (&amp;), Jlisch-Zeiche (=), un kein Dubbelpünkscher (:) do dren sin.',
	'interwiki_addbutton' => 'Dobei donn',
	'interwiki_added' => 'Dä Försaz „$1“ es jäz bei de Engerwiki Date dobei jekomme.',
	'interwiki_addfailed' => 'Dä Försaz „$1“ konnt nit bei de Engerwiki Date dobeijedonn wäde.
Maach sin, dat dä en de Engerwiki Tabäll ald dren wor un es.',
	'interwiki_edittext' => 'Enne Engerwiki Fürsaz Ändere',
	'interwiki_editintro' => 'Do bes an ennem Engerwiki Fösaz am ändere.
Denk draan, domet könnts De Links em Wiki kapott maache, die velleich do drop opboue.',
	'interwiki_edited' => 'Föz dä Försaz „$1“ sen de Engerwiki Date jäz jetuusch.',
	'interwiki_editerror' => 'Dä Försaz „$1“ konnt en de Engerwiki Date nit beärrbeidt wäde.
Maach sin, dat et inn nit jitt.',
	'interwiki-badprefix' => 'Dä aanjejovve Engerwiki-Försatz „$1“ änthäld onjöltijje Zeiche',
	'interwiki_logpagename' => 'Logboch fun de Engerwiki Tabäll',
	'interwiki_log_added' => 'hät dä Försaz „$2“ ($3) (Trans: $4) (Lokal: $5) en de Engerwiki Date eren jedonn',
	'interwiki_log_edited' => 'hät dä Försaz „$2“ ($3) (Trans: $4) (Lokal: $5) en de Engerwiki Date ömjemodelt',
	'interwiki_log_deleted' => 'hät dä Försaz „$2“ es us de Engerwiki Date eruß jeworfe',
	'interwiki_logpagetext' => 'Hee is dat Logboch met de Änderonge aan de [[Special:Interwiki|Engerwiki Date]].',
	'right-interwiki' => 'Engerwiki Date ändere',
	'action-interwiki' => 'Donn hee dä Engerwiki Enndraach ändere',
);

/** Latin (Latina)
 * @author Omnipaedista
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'interwiki' => 'Videre et recensere data intervica',
	'interwiki-title-norights' => 'Videre data intervica',
	'interwiki_intro' => 'De tabula intervicia. Sunt hae columnae:',
	'interwiki_prefix' => 'Praefixum',
	'interwiki-prefix-label' => 'Praefixum:',
	'interwiki_error' => 'ERROR: Tabula intervica est vacua, aut aerumna alia occurrit.',
	'interwiki_reasonfield' => 'Causa:',
	'interwiki_delquestion' => 'Removens "$1"',
	'interwiki_deleting' => 'Delens praefixum "$1".',
	'interwiki_deleted' => 'Praefixum "$1" prospere remotum est ex tabula intervica.',
	'interwiki_delfailed' => 'Praefixum "$1" ex tabula intervica removeri non potuit.',
	'interwiki_addtext' => 'Addere praefixum intervicum',
	'interwiki_addbutton' => 'Addere',
	'interwiki_added' => 'Praefixum "$1" prospere in tabulam intervicam additum est.',
	'interwiki_addfailed' => 'Praefixum "$1" in tabulam intervicam addi non potuit. Fortasse iam est in tabula intervica.',
	'interwiki_edittext' => 'Recensere praefixum intervicum',
	'interwiki_editintro' => 'Recenses praefixum intervicum.
Memento hoc nexus frangere posse.',
	'interwiki_edited' => 'Praefixum "$1" prospere modificata est in tabula intervica.',
	'interwiki_editerror' => 'Praefixum "$1" in tabula intervica modificari non potuit.
Fortasse nondum est in tabula intervica.',
	'interwiki_logpagename' => 'Index tabulae intervicae',
	'interwiki_log_added' => 'addidit praefixum "$2" ($3) (trans: $4) (local: $5) in tabulam intervicam',
	'interwiki_log_edited' => 'modificavit praefixum "$2" : ($3) (trans: $4) (local: $5) in tabula intervica',
	'interwiki_log_deleted' => 'removit praefixum "$2" ex tabula intervica',
	'interwiki_logpagetext' => 'Hic est index mutationum [[Special:Interwiki|tabulae intervicae]].',
	'right-interwiki' => 'Data intervica recensere',
	'action-interwiki' => 'data intervica recensere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Purodha
 * @author Robby
 */
$messages['lb'] = array(
	'interwiki' => 'Interwiki-Date kucken a veränneren',
	'interwiki-title-norights' => 'Interwiki-Date kucken',
	'interwiki-desc' => "Setzt eng [[Special:Interwiki|Spezialsäit]] derbäi fir d'Interwiki-Tabell ze gesin an z'änneren",
	'interwiki_intro' => "Dëst ass en Iwwerbléck iwwert d'Interwiki-Tabell.
D'Bedeitung vun den Informatiounen an de Kolonnen:",
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix:',
	'interwiki_prefix_intro' => 'Interwiki-Prefix fir an der Form <code>[<nowiki />[prefix:<i>Säitennumm</i>]]</code> am Wikitext gebraucht ze ginn.',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Schabloun fir URLen. $1 gëtt duerch <i>Säitennumm</i> aus der uewe genannter Syntax am Wikitext ersat.',
	'interwiki_local' => 'Viruleeden',
	'interwiki-local-label' => 'Viruleeden:',
	'interwiki_local_intro' => 'Eng HTTP-Ufro un déi lokal Wiki mat dësem Interwiki-Prefix an der URL gëtt:',
	'interwiki_local_0_intro' => 'net erfëllt, gëtt normalerweis mat „Säit net fonnt“ blockéiert',
	'interwiki_local_1_intro' => "automatesch op d'Zil-URL virugeleed déi an den Interwikilink-Definitiounen uginn ass (d. h. gëtt wéi en Interwikilink op enger lokaler Säit behandelt)",
	'interwiki_trans' => 'Interwiki-Abannungen',
	'interwiki-trans-label' => 'Abannen:',
	'interwiki_trans_intro' => "Wann d'Wiki-Syntax <code>{<nowiki />{prefix:<i>Numm vun der Säit</i>}}</code> benotzt gëtt, dann:",
	'interwiki_trans_1_intro' => "erlaabt Abannunge vun anere Wikien, wann d'Interwiki-Abannungen an dëser Wiki allgemeng zoulässeg sinn,",
	'interwiki_trans_0_intro' => 'erlaabt et net, an huelt éischter eng Säit aus dem Nummraum:Schabloun.',
	'interwiki_intro_footer' => "Kuckt [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org], fir weider Informatiounen iwwer d'Interwiki-Tabell ze kréien. D'[[Special:Log/interwiki|Logbuch]] weist e Protokoll vun allen Ännerungen an der Interwiki-Tabell.",
	'interwiki_1' => 'jo',
	'interwiki_0' => 'neen',
	'interwiki_error' => "Feeler: D'Interwiki-Tabell ass eidel.",
	'interwiki_edit' => 'Änneren',
	'interwiki_reasonfield' => 'Grond:',
	'interwiki_delquestion' => 'Läscht "$1"',
	'interwiki_deleting' => 'Dir läscht de Prefix "$1".',
	'interwiki_deleted' => 'De Prefix "$1" gouf aus der Interwiki-Tabell erausgeholl.',
	'interwiki_delfailed' => 'Prefix "$1" konnt net aus der Interwiki-Tabell erausgeholl ginn.',
	'interwiki_addtext' => 'En Interwiki-prefix derbäisetzen',
	'interwiki_addintro' => 'Dir setzt en neien Interwiki-Prefix derbäi.
Denkt drunn datt keng Espacen ( ), Et-commerciale (&), Gläichzeechen (=) a keng Doppelpunkten (:) däerfen dra sinn.',
	'interwiki_addbutton' => 'Derbäisetzen',
	'interwiki_added' => 'De Prefix "$1" gou an d\'Interwiki-Tabell derbäigesat.',
	'interwiki_addfailed' => 'De Prefix "$1" konnt net an d\'Interwiki-Tabell derbäigesat ginn.
Méiglecherweis gëtt et e schn an der Interwiki-Tabell.',
	'interwiki_edittext' => 'En interwiki Prefix änneren',
	'interwiki_editintro' => 'Dir ännert en Interwiki Prefix.
Denkt drun, datt dëst kann dozou féieren datt Linen déi et scho gëtt net méi fonctionnieren.',
	'interwiki_edited' => 'De Prefix "$1" gouf an der Interwiki-Tabell geännert.',
	'interwiki_editerror' => 'De Prefix "$1" kann an der Interwiki-Tabell net geännert ginn.
Méiglecherweis gëtt et en net.',
	'interwiki-badprefix' => 'Den Interwiki-Prefix "$1" huet net valabel Buchstawen',
	'interwiki_logpagename' => 'Lëscht mat der Interwikitabell',
	'interwiki_log_added' => 'huet de Prefix "$2" ($3) (trans: $4) (lokal: $5) an d\'Interwiki-Tabell derbäigesat',
	'interwiki_log_edited' => 'huet de Prefix "$2": ($3) (trans: $4) (lokal: $5) an der Interwiki-Tabell geännert',
	'interwiki_log_deleted' => 'huet de Prefix "$2" aus der Interwiki-Tabell erausgeholl',
	'interwiki_logpagetext' => 'Dëst ass eng Lëscht mat den Ännerunge vun der [[Special:Interwiki|Interwikitabell]].',
	'right-interwiki' => 'Interwiki-Daten änneren',
	'action-interwiki' => "dës Interwiki-Informatioun z'änneren",
);

/** Lithuanian (Lietuvių)
 * @author Homo
 */
$messages['lt'] = array(
	'interwiki' => 'Žiūrėti ir redaguoti interwiki duomenis',
	'interwiki-title-norights' => 'Žiūrėti interwiki duomenis',
	'interwiki-desc' => 'Prideda [[Special:Interwiki|specialųjį puslapį]] interwiki lentelei peržiūrėti ir redaguoti',
	'interwiki_local' => 'Persiųsti',
	'interwiki-local-label' => 'Persiųsti:',
	'interwiki_addbutton' => 'Pridėti',
	'interwiki_logpagetext' => 'Tai pakeitimų [[Special:Interwiki|interwiki lentelėje]] sąrašas',
	'right-interwiki' => 'Redaguoti interwiki duomenis',
);

/** Literary Chinese (文言) */
$messages['lzh'] = array(
	'interwiki' => '察與修跨維表',
	'interwiki-title-norights' => '察跨維',
	'interwiki_intro' => '閱[http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org]之。
有跨維之[[Special:Log/interwiki|誌]]。',
	'interwiki_prefix' => '前',
	'interwiki-prefix-label' => '前:',
	'interwiki_local' => '定為本維',
	'interwiki-local-label' => '定為本維:',
	'interwiki_trans' => '許跨維之含',
	'interwiki-trans-label' => '許跨維之含:',
	'interwiki_error' => '錯：跨維為空，或它錯發生。',
	'interwiki_reasonfield' => '因',
	'interwiki_delquestion' => '現刪「$1」',
	'interwiki_deleting' => '爾正刪「$1」。',
	'interwiki_deleted' => '已刪「$1」。',
	'interwiki_delfailed' => '無刪「$1」。',
	'interwiki_addtext' => '加跨維',
	'interwiki_addintro' => '爾正加新之跨。
記無含空（ ）、冒（:）、連（&），或等（=）。',
	'interwiki_addbutton' => '加',
	'interwiki_added' => '「$1」加至跨維也。',
	'interwiki_addfailed' => '「$1」無加跨維也。
或已存在之。',
	'interwiki_edittext' => '改跨維',
	'interwiki_editintro' => '爾正改跨維。
記此能斷現連。',
	'interwiki_edited' => '「$1」已改之。',
	'interwiki_editerror' => '「$1」無改之。
無存。',
	'interwiki-badprefix' => '定之跨維前「$1」含有無效之字也',
	'interwiki_log_added' => '加「$2」（$3）（含：$4）（本：$5）至跨維表',
	'interwiki_log_edited' => '改「$2」：（$3）（含：$4）（本：$5）自跨維表',
	'interwiki_log_deleted' => '刪跨維表自「$2」',
	'right-interwiki' => '改跨維',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'right-interwiki' => 'Manova ny data interwiki',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'interwiki_reasonfield' => 'Амал',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'interwiki' => 'Преглед и уредување на интервики податоци',
	'interwiki-title-norights' => 'Види интервики податоци',
	'interwiki-desc' => 'Додава [[Special:Interwiki|специјална страница]] за преглед и уредување на интервики-табелата',
	'interwiki_intro' => 'Ова е преглед на интервики-табелата. Значења на податоците во колоните:',
	'interwiki_prefix' => 'Префикс',
	'interwiki-prefix-label' => 'Префикс:',
	'interwiki_prefix_intro' => 'Интервики префикс за користење во викитекст-синтаксата <code>[<nowiki />[префикс:<i>име на страница</i>]]</code>.',
	'interwiki_url_intro' => 'Шаблон за URL-адреси. Наместо $1 ќе биде поставено <i>име на страницата</i> на викитекстот, кога се користи гореспоменатата виктекст-синтакса.',
	'interwiki_local' => 'Препратка',
	'interwiki-local-label' => 'Препратка:',
	'interwiki_local_intro' => 'HTTP-барање до локалното вики со овој интервики префикс во URL-адресата:',
	'interwiki_local_0_intro' => 'не се почитува, туку обично се блокира со пораката „страницата не е пронајдена“,',
	'interwiki_local_1_intro' => 'се пренасочува кон целната URL-адреса посочена во дефинициите на интервики-врските (т.е. се третира како референтните врски на локалните страници)',
	'interwiki_trans' => 'Вклучување',
	'interwiki-trans-label' => 'Вклучување:',
	'interwiki_trans_intro' => 'Ако се користи викитекст-синтаксата <code>{<nowiki />{префикс:<i>име на страница</i>}}</code>, тогаш:',
	'interwiki_trans_1_intro' => 'дозволи вклучување од други викија, ако тоа е начелно дозволено на ова вики,',
	'interwiki_trans_0_intro' => 'не дозволувак, туку барај страница во шаблонскиот именски простор.',
	'interwiki_intro_footer' => 'Погледајте ја страницата [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] за повеќе информации за интервики-табелата.
Постои [[Special:Log/interwiki|дневник на промени]] во интервики-табелата.',
	'interwiki_1' => 'да',
	'interwiki_0' => 'не',
	'interwiki_error' => 'Грешка: Интервики-табелата е празна, или нешто друго не е во ред.',
	'interwiki_edit' => 'Уреди',
	'interwiki_reasonfield' => 'Причина:',
	'interwiki_delquestion' => 'Бришење на „$1“',
	'interwiki_deleting' => 'Го бришете префиксот „$1“.',
	'interwiki_deleted' => 'Префиксот „$1“ е успешно отстранет од интервики-табелата.',
	'interwiki_delfailed' => 'Префиксот „$1“ не можеше да се отстрани од интервики-табелата.',
	'interwiki_addtext' => 'Додај интервики префикс',
	'interwiki_addintro' => 'Запомнете дека не смее да содржи празни простори ( ), две точки (:), амперсанди (&) и знаци на равенство (=).',
	'interwiki_addbutton' => 'Додај',
	'interwiki_added' => 'Префиксот „$1“ е успешно додаден кон интервики-табелата',
	'interwiki_addfailed' => 'Префиксот „$1“ не можеше да се додаде во интервики-табелата.
Веројатно таму веќе постои.',
	'interwiki_edittext' => 'Уредување на интервики префикс',
	'interwiki_editintro' => 'Уредувате интервики префикс.
Запомнете дека ова може да ги раскине постоечките врски.',
	'interwiki_edited' => 'Префиксот „$1“ е успешно изменет во интервики-табелата.',
	'interwiki_editerror' => 'Префиксот „$1“ не може да се менува во интервики-табелата.
Можеби тој не постои.',
	'interwiki-badprefix' => 'Назначениот интервики префикс „$1“ содржи неважечки знаци',
	'interwiki_logpagename' => 'Дневник на измени во интервики-табелата',
	'interwiki_log_added' => 'го додаде префиксот „$2“ ($3) (меѓ: $4) (лок: $5) во интервики-табелата',
	'interwiki_log_edited' => 'го измени префиксот „$2“ : ($3) (меѓ: $4) (лок: $5) во интервики-табелата',
	'interwiki_log_deleted' => 'го додаде префиксот „$2“ во интервики-табелата',
	'interwiki_logpagetext' => 'Ова е дневник на промени во [[Special:Interwiki|интервики-табелата]].',
	'right-interwiki' => 'Уреди интервики',
	'action-interwiki' => 'менување на овој интервики-запис',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'interwiki' => 'ഇന്റര്‍ വിക്കി ഡാറ്റ കാണുകയും തിരുത്തുകയും ചെയ്യുക',
	'interwiki-title-norights' => 'ഇന്റര്‍‌വിക്കി ഡാറ്റ കാണുക',
	'interwiki_reasonfield' => 'കാരണം',
	'interwiki_delquestion' => '"$1" മായ്ച്ചുകൊണ്ടിരിക്കുന്നു',
	'interwiki_addbutton' => 'ചേര്‍ക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'interwiki_1' => 'тийм',
);

/** Marathi (मराठी)
 * @author Kaustubh
 */
$messages['mr'] = array(
	'interwiki' => 'आंतरविकि डाटा पहा व संपादा',
	'interwiki-title-norights' => 'अंतरविकि डाटा पहा',
	'interwiki-desc' => 'आंतरविकि सारणी पाहण्यासाठी व संपादन्यासाठी एक [[Special:Interwiki|विशेष पान]] वाढविते',
	'interwiki_intro' => 'आंतरविकि सारणी बद्दल अधिक माहीतीसाठी [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] पहा. इथे आंतरविकि सारणीत करण्यात आलेल्या [[Special:Log/interwiki|बदलांची यादी]] आहे.',
	'interwiki_prefix' => 'उपपद (पूर्वप्रत्यय)',
	'interwiki-prefix-label' => 'उपपद (पूर्वप्रत्यय):',
	'interwiki_error' => 'त्रुटी: आंतरविकि सारणी रिकामी आहे, किंवा इतर काहीतरी चुकलेले आहे.',
	'interwiki_reasonfield' => 'कारण',
	'interwiki_delquestion' => '"$1" वगळत आहे',
	'interwiki_deleting' => 'तुम्ही "$1" उपपद वगळत आहात.',
	'interwiki_deleted' => '"$1" उपपद आंतरविकि सारणीमधून वगळण्यात आलेले आहे.',
	'interwiki_delfailed' => '"$1" उपपद आंतरविकि सारणीतून वगळता आलेले नाही.',
	'interwiki_addtext' => 'एक आंतरविकि उपपद वाढवा',
	'interwiki_addintro' => 'तुम्ही एक नवीन आंतरविकि उपपद वाढवित आहात. कृपया लक्षात घ्या की त्यामध्ये स्पेस ( ), विसर्ग (:), आणिचिन्ह (&), किंवा बरोबरची खूण (=) असू शकत नाही.',
	'interwiki_addbutton' => 'वाढवा',
	'interwiki_added' => '"$1" उपपद आंतरविकि सारणी मध्ये वाढविण्यात आलेले आहे.',
	'interwiki_addfailed' => '"$1" उपपद आंतरविकि सारणी मध्ये वाढवू शकलेलो नाही. कदाचित ते अगोदरच अस्तित्वात असण्याची शक्यता आहे.',
	'interwiki_edittext' => 'एक अंतरविकि उपपद संपादित आहे',
	'interwiki_editintro' => 'तुम्ही एक अंतरविकि उपपद संपादित आहात.
लक्षात ठेवा की यामुळे अगोदर दिलेले दुवे तुटू शकतात.',
	'interwiki_edited' => 'अंतरविकि सारणीमध्ये "$1" उपपद यशस्वीरित्या बदलण्यात आलेले आहे.',
	'interwiki_editerror' => 'अंतरविकि सारणीमध्ये "$1" उपपद बदलू शकत नाही.
कदाचित ते अस्तित्वात नसेल.',
	'interwiki_logpagename' => 'आंतरविकि सारणी नोंद',
	'interwiki_log_added' => 'आंतरविकि सारणी मध्ये "$2" ($3) (trans: $4) (local: $5) वाढविले',
	'interwiki_log_edited' => 'अंतरविकि सारणीमध्ये उपपद "$2" : ($3) (trans: $4) (local: $5) बदलले',
	'interwiki_log_deleted' => '"$2" उपपद आंतरविकिसारणी मधून वगळले',
	'interwiki_logpagetext' => '[[Special:Interwiki|आंतरविकि सारणीत]] झालेल्या बदलांची ही सूची आहे.',
	'right-interwiki' => 'आंतरविकि डाटा बदला',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 * @author Aviator
 * @author Diagramma Della Verita
 */
$messages['ms'] = array(
	'interwiki' => 'Lihat dan ubah data interwiki',
	'interwiki-title-norights' => 'Lihat data interwiki',
	'interwiki_intro' => 'Lihat [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] untuk maklumat lanjut mengenai jadual interwiki. Terdapat sebuah [[Special:Log/interwiki|log untuk perubahan-perubahan]] pada jadual interwiki.',
	'interwiki_prefix' => 'Awalan',
	'interwiki-prefix-label' => 'Awalan:',
	'interwiki_local' => 'Kiriman',
	'interwiki-local-label' => 'Kiriman:',
	'interwiki_trans' => 'Benarkan penyertaan interwiki',
	'interwiki-trans-label' => 'Benarkan penyertaan interwiki:',
	'interwiki_1' => 'ya',
	'interwiki_0' => 'tidak',
	'interwiki_error' => 'Ralat: Jadual interwiki kosong atau sesuatu yang tidak kena berlaku.',
	'interwiki_edit' => 'Sunting',
	'interwiki_reasonfield' => 'Sebab',
	'interwiki_delquestion' => 'Menghapuskan "$1"',
	'interwiki_deleting' => 'Anda sedang menghapuskan awalan "$1".',
	'interwiki_deleted' => 'Awalan "$1" telah dibuang daripada jadual interwiki.',
	'interwiki_delfailed' => 'Awalan "$1" tidak dapat dibuang daripada jadual interwiki.',
	'interwiki_addtext' => 'Tambah awalan interwiki',
	'interwiki_addintro' => 'Anda sedang menambah awalan interwiki baru. Sila ingat bahawa awalan interwiki tidak boleh mangandungi jarak ( ), noktah bertindih (:), ampersan (&), atau tanda sama (=).',
	'interwiki_addbutton' => 'Tambah',
	'interwiki_added' => 'Awalan "$1" telah ditambah ke dalam jadual interwiki.',
	'interwiki_addfailed' => 'Awalan "$1" tidak dapat ditambah ke dalam jadual interwiki. Barangkali awalan ini telah pun wujud dalam jadual interwiki.',
	'interwiki_edittext' => 'Mengubah awalan interwiki',
	'interwiki_editintro' => 'Anda sedang mengubah suatu awalan interwiki. Sila ingat bahawa perbuatan ini boleh merosakkan pautan-pautan yang sudah ada.',
	'interwiki_edited' => 'Awalan "$1" telah diubah dalam jadual interwiki.',
	'interwiki_editerror' => 'Awalan "$1" tidak boleh diubah dalam jadual interwiki. Barangkali awalan ini tidak wujud.',
	'interwiki_logpagename' => 'Log maklumat Interwiki',
	'interwiki_log_added' => 'menampah awalan "$2" ($3) (penyertaan: $4) (tempatan: $5) ke dalam jadual interwiki',
	'interwiki_log_edited' => 'mengubah awalan "$2" : ($3) (penyertaan: $4) (tempatan: $5) in the interwiki table',
	'interwiki_log_deleted' => 'membuang awalan "$2" daripada jadual interwiki',
	'right-interwiki' => 'Ubah data interwiki',
	'action-interwiki' => 'tukar data interwiki berikut',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'interwiki_edit' => 'Editja',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'interwiki_reasonfield' => 'Тувтал',
	'interwiki_addbutton' => 'Поладомс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'interwiki_reasonfield' => 'Īxtlamatiliztli',
	'interwiki_delquestion' => 'Mopolocah "$1"',
	'interwiki_addbutton' => 'Ticcētilīz',
);

/** Low German (Plattdüütsch)
 * @author Purodha
 * @author Slomox
 */
$messages['nds'] = array(
	'interwiki_intro' => 'Disse Sied gifft en Överblick över de Interwiki-Tabell. De Indrääg in de enkelten Spalten bedüüdt:',
	'interwiki_prefix' => 'Präfix',
	'interwiki-prefix-label' => 'Präfix:',
	'interwiki_local' => 'Wiederleiden to en anner Wiki',
	'interwiki-local-label' => 'Wiederleiden to en anner Wiki:',
	'interwiki_trans' => 'Inbinnen över Interwiki verlöven',
	'interwiki-trans-label' => 'Inbinnen över Interwiki verlöven:',
	'interwiki_1' => 'jo',
	'interwiki_0' => 'nee',
	'interwiki_error' => 'De Interwiki-Tabell is leddig, oder wat anners is verkehrt lopen.',
	'interwiki_edit' => 'Ännern',
	'interwiki_reasonfield' => 'Grund:',
	'interwiki_delquestion' => '„$1“ warrt rutsmeten',
	'interwiki_addtext' => 'Interwiki-Präfix tofögen',
	'interwiki_addbutton' => 'Tofögen',
	'right-interwiki' => 'Interwiki-Tabell ännern',
	'action-interwiki' => 'dissen Indrag in de Interwiki-Tabell ännern',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'interwiki_addbutton' => 'Toevoegen',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'interwiki' => 'Interwikigegevens bekijken en wijzigen',
	'interwiki-title-norights' => 'Interwikigegevens bekijken',
	'interwiki-desc' => 'Voegt een [[Special:Interwiki|speciale pagina]] toe om de interwikitabel te bekijken en bewerken',
	'interwiki_intro' => 'Dit is een overzicht van de interwikitabel.
Betekenis van de gegevens en kolommen:',
	'interwiki_prefix' => 'Voorvoegsel',
	'interwiki-prefix-label' => 'Voorvoegsel:',
	'interwiki_prefix_intro' => 'Interwikivoorvoegsel dat gebruikt moet worden in de wikitekstsyntaxis <code>[<nowiki />[voorvoegsel:<i>paginanaam</i>]]</code>.',
	'interwiki_url_intro' => "Een sjabloon voor URL's. De plaatshouder $1 wordt vervangen door de <i>paginanaam</i> van de wikitekst als de bovenvermelde wikitekstsyntaxis gebruikt wordt.",
	'interwiki_local' => 'Doorverwijzen',
	'interwiki-local-label' => 'Doorverwijzen:',
	'interwiki_local_intro' => 'Een HTTP-aanvraag naar de lokale wiki met dit interwikivoorvoegsel in de URL is:',
	'interwiki_local_0_intro' => 'wordt niet verwerkt. Meestal geblokkeerd door een "pagina niet gevonden"-foutmelding.',
	'interwiki_local_1_intro' => "doorverwezen naar de doel-URL die opgegeven is in de definities van de interwikiverwijzingen (deze worden behandeld als bronnen in lokale pagina's)",
	'interwiki_trans' => 'Transcluderen',
	'interwiki-trans-label' => 'Transcluderen:',
	'interwiki_trans_intro' => 'Indien de wikitextsyntaxis <code>{<nowiki />{voorvoegsel:<i>paginanaam</i>}}</code> gebruikt wordt, dan:',
	'interwiki_trans_1_intro' => 'transclusie toestaan van de andere wiki indien interwikitransclusies toegestaan zijn in deze wiki.',
	'interwiki_trans_0_intro' => 'niet toestaan, zoeken naar een pagina in de sjabloonnaamruimte.',
	'interwiki_intro_footer' => 'Zie [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] voor meer informatie over de interwikitabel.
Er is een [[Special:Log/interwiki|veranderingslogboek]] voor de interwikitabel.',
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nee',
	'interwiki_error' => 'Fout: De interwikitabel is leeg, of iets anders ging verkeerd.',
	'interwiki_edit' => 'Bewerken',
	'interwiki_reasonfield' => 'Reden:',
	'interwiki_delquestion' => '"$1" aan het verwijderen',
	'interwiki_deleting' => 'U bent voorvoegsel "$1" aan het verwijderen.',
	'interwiki_deleted' => 'Voorvoegsel "$1" is verwijderd uit de interwikitabel.',
	'interwiki_delfailed' => 'Voorvoegsel "$1" kon niet worden verwijderd van de interwikitabel.',
	'interwiki_addtext' => 'Een interwikivoorvoegsel toevoegen',
	'interwiki_addintro' => 'U bent een nieuw interwikivoorvoegsel aan het toevoegen. Let op dat dit geen spaties ( ), dubbelepunt (:), ampersands (&), of gelijkheidstekens (=) mag bevatten.',
	'interwiki_addbutton' => 'Toevoegen',
	'interwiki_added' => 'Voorvoegsel "$1" is toegevoegd aan de interwikitabel.',
	'interwiki_addfailed' => 'Voorvoegsel "$1" kon niet worden toegevoegd aan de interwikitabel. Mogelijk bestaat hij al in de interwikitabel.',
	'interwiki_edittext' => 'Een interwikivoorvoegsel bewerken',
	'interwiki_editintro' => 'U bent een interwikivoorvoegsel aan het bewerken. Let op dat dit bestaande verwijzingen kan breken.',
	'interwiki_edited' => 'Voorvoegsel "$1" is gewijzigd in de interwikitabel.',
	'interwiki_editerror' => 'Voorvoegsel "$1" kan niet worden gewijzigd in de interwikitabel. Mogelijk bestaat hij niet.',
	'interwiki-badprefix' => 'Het interwikivoorvoegsel "$1" bevat ongeldige karakters',
	'interwiki_logpagename' => 'Logboek interwikitabel',
	'interwiki_log_added' => 'Voegde "$2" ($3) (trans: $4) (local: $5) toe aan de interwikitabel',
	'interwiki_log_edited' => 'wijzigde voorvoegsel "$2": ($3) (trans: $4) (local: $5) in de interwikitabel',
	'interwiki_log_deleted' => 'Verwijderde voorvoegsel "$2" van de interwikitabel',
	'interwiki_logpagetext' => 'Dit is een logboek van wijzigingen aan de [[Special:Interwiki|interwikitabel]].',
	'right-interwiki' => 'Interwikigegevens bewerken',
	'action-interwiki' => 'deze interwikiverwijzing te wijzigen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Gunnernett
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'interwiki' => 'Vis og endre interwikidata',
	'interwiki-title-norights' => 'Vis interwikidata',
	'interwiki-desc' => 'Legg til ei [[Special:Interwiki|spesialsida]] som gjer at ein kan syna og endra interwikitabellen.',
	'interwiki_intro' => 'Dette er eit oversyn over interwikitabellen. Meiningane til dataa i kolonnane:',
	'interwiki_prefix' => 'Forstaving',
	'interwiki-prefix-label' => 'Forstaving:',
	'interwiki_prefix_intro' => 'Interwikiforstaving som skal verta nytta i <code>[<nowiki />[forstaving:<i>sidenamn</i>]]</code>-wikisyntaks.',
	'interwiki_url_intro' => 'Mal for adresser. Variabelen $1 vil verta bytt ut med <i>sidenamn</i> i wikiteksten når wikisyntakset ovanfor vert nytta.',
	'interwiki_local' => 'Send vidare',
	'interwiki-local-label' => 'Send vidare:',
	'interwiki_local_intro' => 'Ein http-førespurnad til den lokale wikien med denne interwikiforstavinga i adressa, er:',
	'interwiki_local_0_intro' => 'ikkje æra, vanlegvis blokkert med «finn ikkje websida»,',
	'interwiki_local_1_intro' => 'omdirigert til måladressa oppgjeven i interwikilenkjedefinisjonane (med andre ord handsama som refereransar på lokale sider)',
	'interwiki_trans' => 'Inkluder',
	'interwiki-trans-label' => 'Inkluder:',
	'interwiki_trans_intro' => 'Om wikitekstsyntakset <code>{<nowiki />{prefix:<i>pagename</i>}}</code> er nytta, so:',
	'interwiki_trans_1_intro' => 'tillat inkludering frå ein framand wiki, om interwikiinkluderingar generelt sett er tillatne på denne wikien,',
	'interwiki_trans_0_intro' => 'ikkje tillat det, sjå heller etter ei sida i malnamnerommet.',
	'interwiki_intro_footer' => 'Sjå [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] for meir informasjon om interwikitabellen.
Det finst ein [[Special:Log/interwiki|logg over endringar]] i interwikitabellen.',
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nei',
	'interwiki_error' => 'Feil: Interwikitabellen er tom, eller noko anna gjekk gale.',
	'interwiki_edit' => 'Endra',
	'interwiki_reasonfield' => 'Årsak',
	'interwiki_delquestion' => 'Slettar «$1»',
	'interwiki_deleting' => 'Du slettar prefikset «$1».',
	'interwiki_deleted' => 'Prefikset «$1» blei fjerna frå interwikitabellen.',
	'interwiki_delfailed' => 'Prefikset «$1» kunne ikkje bli fjerna frå interwikitabellen.',
	'interwiki_addtext' => 'Legg til eit interwikiprefiks',
	'interwiki_addintro' => 'Du legg til eit nytt interwikiprefiks.
Hugs at det ikkje kan innehalda mellomrom ( ), kolon (:), et (&) eller likskapsteikn (=).',
	'interwiki_addbutton' => 'Legg til',
	'interwiki_added' => 'Prefikset «$1» blei lagt til i interwikitabellen.',
	'interwiki_addfailed' => 'Prefikset «$1» kunne ikkje bli lagt til i interwikitabellen.
Kanskje er det i bruk frå før.',
	'interwiki_edittext' => 'Endrar eit interwikiprefiks',
	'interwiki_editintro' => 'Du endrar eit interwikiprefiks.
Hugs at dette kan øydeleggja lenkjer som finst frå før.',
	'interwiki_edited' => 'Prefikset «$1» blei endra i interwikitabellen.',
	'interwiki_editerror' => 'Prefikset «$1» kan ikkje bli endra i interwikitabellen.
Kanskje finst det ikkje.',
	'interwiki-badprefix' => 'Det oppgjevne interwikiprefikset «$1» inneheld ugyldige teikn.',
	'interwiki_logpagename' => 'Logg for interwikitabell',
	'interwiki_log_added' => 'la til «$2» ($3) (trans: $4) (lokal: $5) til interwikitabellen',
	'interwiki_log_edited' => 'endra prefikset «$2»: ($3) (trans: $4) (lokal: $5) i interwikitabellen',
	'interwiki_log_deleted' => 'fjerna prefikset «$2» frå interwikitabellen',
	'interwiki_logpagetext' => 'Dette er ein logg over endringar i [[Special:Interwiki|interwikitabellen]].',
	'right-interwiki' => 'Endra interwikidata',
	'action-interwiki' => 'endra dette interwikielementet',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 * @author Purodha
 */
$messages['no'] = array(
	'interwiki' => 'Vis og manipuler interwikidata',
	'interwiki-title-norights' => 'Vis interwikidata',
	'interwiki-desc' => 'Legger til en [[Special:Interwiki|spesialside]] som gjør at man kan se og redigere interwiki-tabellen.',
	'interwiki_intro' => 'Dette er en oversikt over interwikitabellen. Betydningene til dataene i kolonnene:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_prefix_intro' => 'Interwikiprefiks som skal brukes i <code>[<nowiki />[prefiks:<i>sidenavn</i>]]</code>-wikisyntaks.',
	'interwiki_url_intro' => 'Mal for internettadresser. Variabelen $1 vil bli erstattet av <i>sidenavnet</i> i wikiteksten når wikisyntaksen ovenfor blir brukt.',
	'interwiki_local' => 'Videresend',
	'interwiki-local-label' => 'Videresend:',
	'interwiki_local_intro' => 'En HTTP-forespørsel til den lokale wikien med dette interwikiprefikset i internettadressen er:',
	'interwiki_local_0_intro' => 'ikke fulgt, vanligvis blokkert av «siden ble ikke funnet»,',
	'interwiki_local_1_intro' => 'omdirigert til målnettadressen gitt i interwikilenkedefinisjonene (med andre ord behandlet som referanser på lokale sider)',
	'interwiki_trans' => 'Transkluder',
	'interwiki-trans-label' => 'Transkluder:',
	'interwiki_trans_intro' => 'Dersom wikisyntaksen <code>{<nowiki />{prefiks:<i>sidenavn</i>}}</code> blir brukt, så:',
	'interwiki_trans_1_intro' => 'tillat transklusjon fra en fremmed wiki, om interwikitranskluderinger generellt er tillatt på denne wikien,',
	'interwiki_trans_0_intro' => 'ikke tillat det, se heller etter en side i malnavnerommet.',
	'interwiki_intro_footer' => 'Se [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] for mer informasjon om interwikitabellen.
Det finnes en [[Special:Log/interwiki|endringslogg]] for interwikitabellen.',
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nei',
	'interwiki_error' => 'FEIL: Interwikitabellen er tom, eller noe gikk gærent.',
	'interwiki_edit' => 'Rediger',
	'interwiki_reasonfield' => 'Årsak:',
	'interwiki_delquestion' => 'Sletter «$1»',
	'interwiki_deleting' => 'Du sletter prefikset «$1».',
	'interwiki_deleted' => 'Prefikset «$1» ble fjernet fra interwikitabellen.',
	'interwiki_delfailed' => 'Prefikset «$1» kunne ikke fjernes fra interwikitabellen.',
	'interwiki_addtext' => 'Legg til et interwikiprefiks.',
	'interwiki_addintro' => 'Du legger til et nytt interwikiprefiks. Husk at det ikke kan inneholde mellomrom ( ), kolon (:), &-tegn eller likhetstegn (=).',
	'interwiki_addbutton' => 'Legg til',
	'interwiki_added' => 'Prefikset «$1» ble lagt til i interwikitabellen.',
	'interwiki_addfailed' => 'Prefikset «$1» kunne ikke legges til i interwikitabellen. Det er kanskje brukt der fra før.',
	'interwiki_edittext' => 'Redigerer et interwikiprefiks',
	'interwiki_editintro' => 'Du redigerer et interwikiprefiks. Merk at dette kan ødelegge eksisterende lenker.',
	'interwiki_edited' => 'Prefikset «$1» ble endret i interwikitabellen.',
	'interwiki_editerror' => 'Prefikset «$1» kan ikke endres i interwikitabellen. Det finnes muligens ikke.',
	'interwiki-badprefix' => 'Det oppgitte interwikiprefikset «$1» innholder ugyldige tegn',
	'interwiki_logpagename' => 'Interwikitabellogg',
	'interwiki_log_added' => 'La til «$2» ($3) (trans: $4) (lokal: $5) til interwikitabellen',
	'interwiki_log_edited' => 'endret prefikset «$2»: ($3) (trans: $4) (lokal: $5) i interwikitabellen',
	'interwiki_log_deleted' => 'Fjernet prefikset «$2» fra interwikitabellen',
	'interwiki_logpagetext' => 'Dette er en logg over endringer i [[Special:Interwiki|interwikitabellen]].',
	'right-interwiki' => 'Redigere interwikidata',
	'action-interwiki' => 'endre dette interwikielementet',
);

/** Novial (Novial)
 * @author Malafaya
 */
$messages['nov'] = array(
	'interwiki_reasonfield' => 'Resone',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'interwiki_reasonfield' => 'Lebaka',
	'interwiki_delquestion' => 'Phumula "$1"',
	'interwiki_addbutton' => 'Lokela',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'interwiki' => 'Veire e editar las donadas interwiki',
	'interwiki-title-norights' => 'Veire las donadas interwiki',
	'interwiki-desc' => 'Apond una [[Special:Interwiki|pagina especiala]] per veire e editar la taula interwiki',
	'interwiki_intro' => 'Aquò es un apercebut de la taula interwiki. Vaquí las significacions de las donadas de colomnas :',
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix :',
	'interwiki_prefix_intro' => "Prefix interwiki d'utilizar dins <code>[<nowiki />[prefix :<i>nom de la pagina</i>]]</code> de la sintaxi wiki.",
	'interwiki_url_intro' => 'Modèl per las URLs. $1 serà remplaçat pel <i>nom de la pagina</i> del wikitèxt, quora la sintaxi çaisús es utilizada.',
	'interwiki_local' => 'Far seguir',
	'interwiki-local-label' => 'Far seguir :',
	'interwiki_local_intro' => "Una requèsta HTTP sus aqueste wiki amb aqueste prefix interwiki dins l'URL serà :",
	'interwiki_local_0_intro' => 'regetat, blocat generalament per « Marrit títol »,',
	'interwiki_local_1_intro' => "redirigit cap a l'URL cibla en foncion de la definicion del prefix interwiki (es a dire tractat coma un ligam dins una pagina del wiki)",
	'interwiki_trans' => 'Enclure',
	'interwiki-trans-label' => 'Enclure :',
	'interwiki_trans_intro' => 'Se la sintaxi <code>{<nowiki />{prefix :<i>nom de la pagina</i>}}</code> es utilizada, alara :',
	'interwiki_trans_1_intro' => "l'inclusion a partir del wiki serà autorizada, se las inclusions interwiki son autorizadas dins aqueste wiki,",
	'interwiki_trans_0_intro' => "l'inclusion serà regetada, e la pagina correspondenta serà recercada dins l'espaci de noms « Modèl ».",
	'interwiki_intro_footer' => "Vejatz [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] per obténer mai d'entresenhas a prepaus de la taula interwiki.
Existís un [[Special:Log/interwiki|jornal de las modificacions]] de la taula interwiki.",
	'interwiki_1' => 'òc',
	'interwiki_0' => 'non',
	'interwiki_error' => "Error : la taula dels interwikis es voida o un processús s'es mal desenrotlat.",
	'interwiki_edit' => 'Modificar',
	'interwiki_reasonfield' => 'Motiu :',
	'interwiki_delquestion' => 'Supression "$1"',
	'interwiki_deleting' => 'Escafatz presentament lo prefix « $1 ».',
	'interwiki_deleted' => '$1 es estada levada amb succès de la taula interwiki.',
	'interwiki_delfailed' => '$1 a pas pogut èsser levat de la taula interwiki.',
	'interwiki_addtext' => 'Apond un prefix interwiki',
	'interwiki_addintro' => "Sètz a apondre un prefix interwiki. Rapelatz-vos que pòt pas conténer d'espacis ( ), de punts dobles (:), d'eperluetas (&) o de signes egal (=)",
	'interwiki_addbutton' => 'Apondre',
	'interwiki_added' => '$1 es estat apondut amb succès dins la taula interwiki.',
	'interwiki_addfailed' => '$1 a pas pogut èsser apondut a la taula interwiki.
Benlèu i existís ja.',
	'interwiki_edittext' => 'Modificar un prefix interwiki',
	'interwiki_editintro' => "Modificatz un prefix interwiki. Rapelatz-vos qu'aquò pòt rompre de ligams existents.",
	'interwiki_edited' => 'Lo prefix « $1 » es estat modificat amb succès dins la taula interwiki.',
	'interwiki_editerror' => "Lo prefix « $1 » pòt pas èsser modificat. Es possible qu'exista pas.",
	'interwiki-badprefix' => 'Lo prefix interwiki especificat « $1 » conten de caractèrs invalids',
	'interwiki_logpagename' => 'Jornal de la taula interwiki',
	'interwiki_log_added' => 'Ajustat « $2 » ($3) (trans: $4) (local: $5) dins la taula interwiki',
	'interwiki_log_edited' => 'a modificat lo prefix « $2 » : ($3) (trans: $4) (local: $5) dins la taula interwiki',
	'interwiki_log_deleted' => 'Prefix « $2 » suprimit de la taula interwiki',
	'interwiki_logpagetext' => 'Aquò es lo jornal dels cambiaments dins la [[Special:Interwiki|taula interwiki]].',
	'right-interwiki' => 'Modificar las donadas interwiki',
	'action-interwiki' => 'modificar aquesta entrada interwiki',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'interwiki_reasonfield' => 'Аххос',
);

/** Deitsch (Deitsch)
 * @author Purodha
 * @author Xqt
 */
$messages['pdc'] = array(
	'interwiki_1' => 'ya',
	'interwiki_0' => 'nee',
	'interwiki_edit' => 'Ennere',
	'interwiki_reasonfield' => 'Grund:',
	'interwiki_addbutton' => 'Dezu duh',
);

/** Polish (Polski)
 * @author Leinad
 * @author McMonster
 * @author Sp5uhe
 * @author Yarl
 */
$messages['pl'] = array(
	'interwiki' => 'Podgląd i edycja danych interwiki',
	'interwiki-title-norights' => 'Zobacz dane interwiki',
	'interwiki-desc' => 'Dodaje [[Special:Interwiki|stronę specjalną]] służącą do przeglądania i redakcji tablicy interwiki.',
	'interwiki_intro' => 'Przegląd tabeli interwiki. W kolumnach tabeli umieszczono następujące informacje:',
	'interwiki_prefix' => 'Przedrostek',
	'interwiki-prefix-label' => 'Przedrostek:',
	'interwiki_prefix_intro' => 'Przedrostek interwiki do użycia zgodnie ze składnią wiki <code>[<nowiki />[prefiks:<i>nazwa strony</i>]]</code>.',
	'interwiki_url_intro' => 'Szablon dla adresów URL. Symbol $1 zostanie zastąpiony przez <i>nazwę strony</i> wiki, gdzie wyżej wspomniana składnia wiki jest użyta.',
	'interwiki_local' => 'Link działa',
	'interwiki-local-label' => 'Link działa:',
	'interwiki_trans' => 'Transkluzja',
	'interwiki-trans-label' => 'Transkluzja:',
	'interwiki_1' => 'tak',
	'interwiki_0' => 'nie',
	'interwiki_error' => 'BŁĄD: Tabela interwiki jest pusta lub wystąpił jakiś inny problem.',
	'interwiki_edit' => 'Edytuj',
	'interwiki_reasonfield' => 'Powód:',
	'interwiki_delquestion' => 'Czy usunąć „$1”',
	'interwiki_deleting' => 'Usuwasz prefiks „$1”.',
	'interwiki_deleted' => 'Prefiks „$1” został z powodzeniem usunięty z tabeli interwiki.',
	'interwiki_delfailed' => 'Prefiks „$1” nie może zostać usunięty z tabeli interwiki.',
	'interwiki_addtext' => 'Dodaj przedrostek interwiki',
	'interwiki_addintro' => 'Edytujesz przedrostek interwiki.
Pamiętaj, że nie może on zawierać znaku odstępu ( ), dwukropka (:), ampersandu (&) oraz znaku równości (=).',
	'interwiki_addbutton' => 'Dodaj',
	'interwiki_added' => 'Prefiks „$1” został z powodzeniem dodany do tabeli interwiki.',
	'interwiki_addfailed' => 'Prefiks „$1” nie może zostać dodany do tabeli interwiki.
Prawdopodobnie ten prefiks już jest w tableli.',
	'interwiki_edittext' => 'Edycja przedrostka interwiki',
	'interwiki_editintro' => 'Edytujesz przedrostek interwiki. Pamiętaj, że może to zerwać istniejące powiązania między projektami językowymi.',
	'interwiki_edited' => 'Prefiks „$1” został z powodzeniem poprawiony w tableli interwiki.',
	'interwiki_editerror' => 'Prefiks „$1” nie może zostać poprawiony w tabeli interwiki. Prawdopodobnie nie ma go w tabeli.',
	'interwiki-badprefix' => 'Podany przedrostek interwiki „$1” zawiera nieprawidłowe znaki',
	'interwiki_logpagename' => 'Rejestr tablicy interwiki',
	'interwiki_log_added' => 'dodał przedrostek „$2” ($3) (trans: $4) (local: $5) do tabeli interwiki',
	'interwiki_log_edited' => 'zmienił przedrostek „$2” : ($3) (trans: $4) (local: $5) w tabeli interwiki',
	'interwiki_log_deleted' => 'usunął przedrostek „$2” z tabeli interwiki',
	'interwiki_logpagetext' => 'Poniżej znajduje się rejestr zmian wykonanych w [[Special:Interwiki|tablicy interwiki]].',
	'right-interwiki' => 'Edytowanie tabeli interwiki',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'interwiki' => 'Varda e modìfica dat antërwiki',
	'interwiki-title-norights' => 'Varda dat antërwiki',
	'interwiki-desc' => 'A gionta na [[Special:Interwiki|pàgina special]] për vëdde e modifiché la tàula antërwiki',
	'interwiki_intro' => "Costa-sì a l'é na previsualisassion dla tàula antërwiki. Significà dij dat ant le colòne:",
	'interwiki_prefix' => 'Prefiss',
	'interwiki-prefix-label' => 'Prefiss:',
	'interwiki_prefix_intro' => 'Prefiss antërwiki da dovré ant la sintassi dël test wiki <code>[<nowiki />[prefix:<i>nòm pàgina</i>]]</code>',
	'interwiki_url_intro' => "Stamp për anliure. Ël marca-pòst $1 a sarà rimpiassà dal <i>nòm pàgina</i> dël test wiki, quand la sintassi dël test wiki dzor-dit a l'é dovrà.",
	'interwiki_local' => 'Anans',
	'interwiki-local-label' => 'Anans:',
	'interwiki_local_intro' => "N'arcesta HTTP a la wiki local con sto prefiss antërwiki-sì ant l'anliura a l'é:",
	'interwiki_local_0_intro' => 'pa fàit, normalment blocà da "pàgina pa trovà"',
	'interwiki_local_1_intro' => "ridiressionà a l'anliura ëd destinassion dàita ant la definission dël colegament antërwiki (visadì tratà com arferiment ant le pàgine locaj)",
	'interwiki_trans' => 'Anseriment',
	'interwiki-trans-label' => 'Anseriment:',
	'interwiki_trans_intro' => "Se la sintassi wikitest <code>{<nowiki />{prefix:<i>nòmpàgina</i>}}</code> a l'é dovrà, antlora:",
	'interwiki_trans_1_intro' => "a përmet anseriment da la wiki strangera, se j'anseriment antërwiki a son generalment përmëttù an sta wiki-sì,",
	'interwiki_trans_0_intro' => 'a përmet pa lòn, nopà a sërca na pàgina ant lë spassi nominal dlë stamp.',
	'interwiki_intro_footer' => 'Varda [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] për savèjne ëd pi an sla tàula antërwiki.
A-i é un [[Special:Log/interwiki|registr dij cambi]] për la tàula antërwiki.',
	'interwiki_1' => 'é!',
	'interwiki_0' => 'nò',
	'interwiki_error' => "Eror: La tàula antërwiki a l'é veuida, o cheicòs d'àutr a l'é andàit mal.",
	'interwiki_edit' => 'Modìfica',
	'interwiki_reasonfield' => 'Rason:',
	'interwiki_delquestion' => 'Scancelassion ëd "$1"',
	'interwiki_deleting' => 'It ses an camin a scancelé ël prefiss "$1".',
	'interwiki_deleted' => 'Ël prefiss "$1" a l\'é stàit gavà da bin da la tàula antërwiki.',
	'interwiki_delfailed' => 'Ël prefiss "$1" a peul pa esse gavà da la tàula antërwiki.',
	'interwiki_addtext' => 'Gionta un prefiss antërwiki',
	'interwiki_addintro' => "A l'é an camin ch'a gionta un neuv prefiss antërwiki.
Ch'as visa che a peul pa conten-e spassi ( ), doi pont (:), e comersial (&), o l'ugual (=).",
	'interwiki_addbutton' => 'Gionta',
	'interwiki_added' => 'Ël prefiss "$1" a l\'é stàit giontà da bin a la tàula antërwiki.',
	'interwiki_addfailed' => 'Ël prefiss "$1" a peul pa esse giontà a la tàula antërwiki.
A peul esse ch\'a esista già ant la tàula antërwiki.',
	'interwiki_edittext' => 'Modifiché un prefiss antërwiki',
	'interwiki_editintro' => "A l'é an camin ch'a modìfica un prefiss antërwiki.
Ch'as visa che sòn a peul rompe un colegament esistent.",
	'interwiki_edited' => 'Ël prefiss "$1" a l\'é stàit modificà da bin ant la tàula antërwiki.',
	'interwiki_editerror' => 'Ël prefiss "$1" a peul pa esse modificà ant la tàula antërwiki.
A peul esse che a esista pa.',
	'interwiki-badprefix' => 'Ël prefiss antërwiki specificà "$1" a conten caràter pa bon.',
	'interwiki_logpagename' => 'Registr tàula antërwiki',
	'interwiki_log_added' => 'giontà ël prefiss "$2" ($3) (trans: $4) (local: $5) a la tàula antërwiki',
	'interwiki_log_edited' => 'modificà ël prefiss "$2" : ($3) (trans: $4) (local: $5) ant la tàula antërwiki',
	'interwiki_log_deleted' => 'gavà ël prefiss "$2" da la tàula antërwiki',
	'interwiki_logpagetext' => "Cost-sì a l'é un registr dij cambi a la [[Special:Interwiki|tàula antërwiki]].",
	'right-interwiki' => 'Modìfica dat antërwiki',
	'action-interwiki' => 'cambia sto dat antërwiki-sì',
);

/** Pontic (Ποντιακά)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['pnt'] = array(
	'interwiki_prefix' => 'Πρόθεμαν',
	'interwiki-prefix-label' => 'Πρόθεμαν:',
	'interwiki_trans' => 'Υπερκλεισμοί',
	'interwiki-trans-label' => 'Υπερκλεισμοί:',
	'interwiki_1' => 'ναι',
	'interwiki_0' => 'όχι',
	'interwiki_edit' => 'Ἀλλαγμαν',
	'interwiki_delquestion' => 'Διαγραφήν του "$1"',
	'right-interwiki' => 'Άλλαξον τα δογμενία ιντερβίκι',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'interwiki_prefix' => 'مختاړی',
	'interwiki-prefix-label' => 'مختاړی:',
	'interwiki_edit' => 'سمون',
	'interwiki_reasonfield' => 'سبب',
	'interwiki_delquestion' => '"$1" د ړنګولو په حال کې دی...',
	'interwiki_deleting' => 'تاسو د "$1" مختاړی ړنګوی.',
	'interwiki_addbutton' => 'ورګډول',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'interwiki' => 'Ver e manipular dados de interwikis',
	'interwiki-title-norights' => 'Ver dados interwiki',
	'interwiki-desc' => '[[Special:Interwiki|Página especial]] para visualizar e editar a tabela de interwikis',
	'interwiki_intro' => 'Isto é um resumo da tabela de interwikis. Significado dos dados nas colunas:',
	'interwiki_prefix' => 'Prefixo',
	'interwiki-prefix-label' => 'Prefixo:',
	'interwiki_prefix_intro' => 'Prefixo de interwiki a ser usado na sintaxe de wikitexto <code>[<nowiki />[prefix:<i>nome_página</i>]]</code>.',
	'interwiki_url_intro' => 'Modelo para URL. O marcador $1 será substituído pelo <i>nome_página</i> do wikitexto, quando a sintaxe de wikitexto acima mencionada for usada.',
	'interwiki_local' => 'Encaminhar',
	'interwiki-local-label' => 'Encaminhar:',
	'interwiki_local_intro' => 'Um pedido http para a wiki local, com este prefixo de interwiki na URL, é:',
	'interwiki_local_0_intro' => 'ignorado, geralmente bloqueado por "página não encontrada",',
	'interwiki_local_1_intro' => 'redirecionado para a URL alvo dada nas definições de ligação interwiki (p. ex. tratado como referências em páginas locais)',
	'interwiki_trans' => 'Transcluir',
	'interwiki-trans-label' => 'Transcluir:',
	'interwiki_trans_intro' => 'Se a sintaxe de wikitexto <code>{<nowiki />{prefix:<i>nome_página</i>}}</code> for usada, então:',
	'interwiki_trans_1_intro' => 'permite transclusão da wiki externa, se transclusões interwiki forem permitidas de forma geral nesta wiki,',
	'interwiki_trans_0_intro' => 'não o permite; ao invés, procura uma página no espaço nominal de predefinições.',
	'interwiki_intro_footer' => 'Veja [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] para mais informações sobre a tabela de interwikis.
Existe um [[Special:Log/interwiki|registo de modificações]] à tabela de interwikis.',
	'interwiki_1' => 'sim',
	'interwiki_0' => 'não',
	'interwiki_error' => 'ERRO: A tabela de interwikis está vazia, ou alguma outra coisa não correu bem.',
	'interwiki_edit' => 'Editar',
	'interwiki_reasonfield' => 'Motivo:',
	'interwiki_delquestion' => 'A apagar "$1"',
	'interwiki_deleting' => 'Está a apagar o prefixo "$1".',
	'interwiki_deleted' => 'O prefixo "$1" foi removido da tabela de interwikis com sucesso.',
	'interwiki_delfailed' => 'O prefixo "$1" não pôde ser removido da tabela de interwikis.',
	'interwiki_addtext' => 'Adicionar um prefixo de interwikis',
	'interwiki_addintro' => 'Está prestes a adicionar um novo prefixo interwiki.
Lembre-se que este não pode conter espaços ( ), dois-pontos (:), conjunções (&) ou sinais de igualdade (=).',
	'interwiki_addbutton' => 'Adicionar',
	'interwiki_added' => 'O prefixo "$1" foi adicionado à tabela de interwikis com sucesso.',
	'interwiki_addfailed' => 'O prefixo "$1" não pôde ser adicionado à tabela de interwikis. Possivelmente já existe nessa tabela.',
	'interwiki_edittext' => 'Editando um prefixo interwiki',
	'interwiki_editintro' => 'Está a editar um prefixo interwiki. Lembre-se de que isto pode quebrar ligações existentes.',
	'interwiki_edited' => 'O prefixo "$1" foi modificado na tabela de interwikis com sucesso.',
	'interwiki_editerror' => 'O prefixo "$1" não pode ser modificado na tabela de interwikis. Possivelmente, não existe.',
	'interwiki-badprefix' => 'O prefixo interwiki "$1" contém caracteres inválidos',
	'interwiki_logpagename' => 'Registo da tabela de interwikis',
	'interwiki_log_added' => 'adicionado "$2" ($3) (trans: $4) (local: $5) à tabela de interwikis',
	'interwiki_log_edited' => 'modificado o prefixo "$2": ($3) (trans: $4) (local: $5) na tabela de interwikis',
	'interwiki_log_deleted' => 'removido o prefixo "$2" da tabela de interwikis',
	'interwiki_logpagetext' => 'Este é um registo das alterações à [[Special:Interwiki|tabela de interwikis]].',
	'right-interwiki' => 'Editar dados de interwiki',
	'action-interwiki' => 'alterar esta entrada interwiki',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'interwiki' => 'Ver e editar dados de interwikis',
	'interwiki-title-norights' => 'Ver dados interwiki',
	'interwiki-desc' => 'Adiciona uma [[Special:Interwiki|página especial]] para visualizar e editar a tabela de interwikis',
	'interwiki_intro' => 'Isto é um resumo da tabela de interwikis. Significado dos dados nas colunas:',
	'interwiki_prefix' => 'Prefixo',
	'interwiki-prefix-label' => 'Prefixo:',
	'interwiki_prefix_intro' => 'Prefixo de interwiki a ser usado na sintaxe de wikitexto <code>[<nowiki />[prefix:<i>nome_página</i>]]</code>.',
	'interwiki_url_intro' => 'Modelo para URL. O marcador $1 será substituído pelo <i>nome_página</i> do wikitexto, quando a sintaxe de wikitexto acima mencionada for usada.',
	'interwiki_local' => 'Encaminhar',
	'interwiki-local-label' => 'Encaminhar:',
	'interwiki_local_intro' => 'Um pedido http para o wiki local com este prefixo de interwiki na URL é:',
	'interwiki_local_0_intro' => 'ignorado, geralmente bloqueado por "página não encontrada",',
	'interwiki_local_1_intro' => 'redirecionado para a URL alvo dada nas definições de ligação interwiki (p. ex. tratado como referências em páginas locais)',
	'interwiki_trans' => 'Transcluir',
	'interwiki-trans-label' => 'Transcluir:',
	'interwiki_trans_intro' => 'Se a sintaxe de wikitexto <code>{<nowiki />{prefix:<i>nome_página</i>}}</code> for usada, então:',
	'interwiki_trans_1_intro' => 'permite transclusão do wiki externo, se transclusões interwiki forem permitidas de forma geral neste wiki,',
	'interwiki_trans_0_intro' => 'não o permite; ao invés, procura uma página no espaço nominal de predefinições.',
	'interwiki_intro_footer' => 'Veja [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] para mais informações sobre a tabela de interwikis.
Existe um [[Special:Log/interwiki|registro de modificações]] à tabela de interwikis.',
	'interwiki_1' => 'sim',
	'interwiki_0' => 'não',
	'interwiki_error' => 'ERRO: A tabela de interwikis está vazia, ou alguma outra coisa não correu bem.',
	'interwiki_edit' => 'Editar',
	'interwiki_reasonfield' => 'Motivo:',
	'interwiki_delquestion' => 'Apagando "$1"',
	'interwiki_deleting' => 'Você está apagando o prefixo "$1".',
	'interwiki_deleted' => 'O prefixo "$1" foi removido da tabelas de interwikis com sucesso.',
	'interwiki_delfailed' => 'O prefixo "$1" não pôde ser removido da tabela de interwikis.',
	'interwiki_addtext' => 'Adicionar um prefixo de interwikis',
	'interwiki_addintro' => 'Você se encontra prestes a adicionar um novo prefixo de interwiki. Lembre-se de que ele não pode conter espaços ( ), dois-pontos (:), conjunções (&) ou sinais de igualdade (=).',
	'interwiki_addbutton' => 'Adicionar',
	'interwiki_added' => 'O prefixo "$1" foi adicionado à tabela de interwikis com sucesso.',
	'interwiki_addfailed' => 'O prefixo "$1" não pôde ser adicionado à tabela de interwikis. Possivelmente já existe nessa tabela.',
	'interwiki_edittext' => 'Editando um prefixo interwiki',
	'interwiki_editintro' => 'Você está editando um prefixo interwiki. Lembre-se de que isto pode quebrar ligações existentes.',
	'interwiki_edited' => 'O prefixo "$1" foi modificado na tabela de interwikis com sucesso.',
	'interwiki_editerror' => 'O prefixo "$1" não pode ser modificado na tabela de interwikis. Possivelmente, não existe.',
	'interwiki-badprefix' => 'O prefixo interwiki "$1" contém caracteres inválidos',
	'interwiki_logpagename' => 'Registro da tabela de interwikis',
	'interwiki_log_added' => 'adicionado "$2" ($3) (trans: $4) (local: $5) à tabela de interwikis',
	'interwiki_log_edited' => 'modificado o prefixo "$2": ($3) (trans: $4) (local: $5) na tabela de interwikis',
	'interwiki_log_deleted' => 'removido o prefixo "$2" da tabela de interwikis',
	'interwiki_logpagetext' => 'Este é um registro das alterações à [[Special:Interwiki|tabela de interwikis]].',
	'right-interwiki' => 'Editar dados de interwiki',
	'action-interwiki' => 'alterar esta entrada interwiki',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix:',
	'interwiki_1' => 'da',
	'interwiki_0' => 'nu',
	'interwiki_edit' => 'Modificare',
	'interwiki_reasonfield' => 'Motiv',
	'interwiki_delquestion' => 'Ştergere "$1"',
	'interwiki_addbutton' => 'Adaugă',
	'action-interwiki' => 'modificaţi această legătură interwiki',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'interwiki_prefix' => 'Prefisse',
	'interwiki-prefix-label' => 'Prefisse:',
	'interwiki_local' => 'Inoltre',
	'interwiki-local-label' => 'Inoltre:',
	'interwiki_1' => 'sine',
	'interwiki_0' => 'none',
	'interwiki_edit' => 'Cange',
	'interwiki_reasonfield' => 'Mutive:',
	'interwiki_delquestion' => 'Scangellamende de "$1"',
	'interwiki_deleting' => 'Tu ste scangille \'u prefisse "$1".',
	'interwiki_addbutton' => 'Aggiunge',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Illusion
 * @author Innv
 * @author Lockal
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'interwiki' => 'Просмотр и изменение настроек интервики',
	'interwiki-title-norights' => 'Просмотреть данные об интервики',
	'interwiki-desc' => 'Добавляет [[Special:Interwiki|служебную страницу]] для просмотра и редактирования таблицы префиксов интервики.',
	'interwiki_intro' => 'Это обзор таблицы интервики. Значения данных в колонках:',
	'interwiki_prefix' => 'Приставка',
	'interwiki-prefix-label' => 'Приставка:',
	'interwiki_prefix_intro' => 'Приставка интервики для использования в синтаксисе вики-текста: <code>[<nowiki />[приставка:<i>название страницы</i>]]</code>.',
	'interwiki_url_intro' => 'Шаблон для URL. Вместо $1 будет подставлено <i>название страницы</i>, указанное при использовании указанного выше синтаксиса.',
	'interwiki_local' => 'Пересылка',
	'interwiki-local-label' => 'Пересылка:',
	'interwiki_local_intro' => 'HTTP-запрос в местную вики с интервики-приставкой в URL:',
	'interwiki_local_0_intro' => 'не допускается, обычно блокируется сообщением «страница не найдена»,',
	'interwiki_local_1_intro' => 'перенаправляет на целевой URL, указанный в определении интервики-ссылки (т. е. обрабатывается подобно ссылке с локальной страницы)',
	'interwiki_trans' => 'Включение',
	'interwiki-trans-label' => 'Включение:',
	'interwiki_trans_intro' => 'Если используется синтаксис вики-текста вида <code>{<nowiki />{приставка:<i>название страницы</i>}}</code>:',
	'interwiki_trans_1_intro' => 'позволяет включения из других вики, если интервики-включения разрешены в этой вики,',
	'interwiki_trans_0_intro' => 'включения не разрешены, ищется страница в пространстве имён шаблонов.',
	'interwiki_intro_footer' => 'Более подробную информацию о таблице интервики можно найти на [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org].
Существует [[Special:Log/interwiki|журнал изменений]] таблицы интервики.',
	'interwiki_1' => 'да',
	'interwiki_0' => 'нет',
	'interwiki_error' => 'ОШИБКА: таблица интервики пуста или что-то другое работает ошибочно.',
	'interwiki_edit' => 'Править',
	'interwiki_reasonfield' => 'Причина:',
	'interwiki_delquestion' => 'Удаление «$1»',
	'interwiki_deleting' => 'Вы удаляете приставку «$1».',
	'interwiki_deleted' => 'Приставка «$1» успешно удалена из таблицы интервики.',
	'interwiki_delfailed' => 'Приставка «$1» не может быть удалена из таблицы интервики.',
	'interwiki_addtext' => 'Добавить новую интервики-приставку',
	'interwiki_addintro' => 'Вы собираетесь добавить новую интервики-приставку. Помните, что она не может содержать пробелы ( ), двоеточия (:), амперсанды (&) и знаки равенства (=).',
	'interwiki_addbutton' => 'Добавить',
	'interwiki_added' => 'Приставка «$1» успешно добавлена в таблицу интервики.',
	'interwiki_addfailed' => 'Приставка «$1» не может быть добавлена в таблицу интервики. Возможно, она уже присутствует в таблице интервики.',
	'interwiki_edittext' => 'Редактирование интервики-приставок',
	'interwiki_editintro' => 'Вы редактируете интервики-приставку. Помните, что это может сломать существующие ссылки.',
	'interwiki_edited' => 'Приставка «$1» успешно изменена в интервики-таблице.',
	'interwiki_editerror' => 'Приставка «$1» не может быть изменена в интервики-таблице. Возможно, она не существует.',
	'interwiki-badprefix' => 'Указанная интервики-приставка «$1» содержит недопустимые символы',
	'interwiki_logpagename' => 'Журнал изменений таблицы интервики',
	'interwiki_log_added' => 'Приставка «$2» ($3) (trans: $4) (local: $5) добавлена в таблицу интервики',
	'interwiki_log_edited' => 'изменил приставку «$2»: ($3) (меж.: $4) (лок.: $5) в интервики-таблице',
	'interwiki_log_deleted' => 'Приставка «$2» удалена из таблицы интервики',
	'interwiki_logpagetext' => 'Это журнал изменений [[Special:Interwiki|таблицы интервики]].',
	'right-interwiki' => 'правка интервики',
	'action-interwiki' => 'изменение записи интервики',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'interwiki' => 'Интервики туруорууларын көрүү уонна уларытыы',
	'interwiki-title-norights' => 'Интервики туһунан',
	'interwiki_intro' => 'Бу интервики табылыыссата. Колонкаларга:',
	'interwiki_prefix' => 'Префикс (эбиискэ)',
	'interwiki-prefix-label' => 'Префикс (эбиискэ):',
	'interwiki_error' => 'Алҕас: Интервики табылыыссата кураанах эбэтэр туга эрэ сатамматах.',
	'interwiki_reasonfield' => 'Төрүөтэ',
	'interwiki_delquestion' => '"$1" сотуу',
	'interwiki_deleting' => '"$1" префиксы сотон эрэҕин.',
	'interwiki_deleted' => '"$1" префикс интервики табылыыссатыттан сотулунна.',
	'interwiki_delfailed' => '"$1" префикс интервики табылыыссатыттан сотуллар кыаҕа суох.',
	'interwiki_addtext' => 'Саҥа интервики префиксы эбии',
	'interwiki_addintro' => 'Эн саҥа интервики префиксын эбээри гынныҥ. Онтуҥ пробела ( ), икки туочуката (:), амперсанда (&) уонна тэҥнэһии бэлиэтэ (=) суох буолуохтаах.',
	'interwiki_addbutton' => 'Эбэргэ',
	'interwiki_added' => '"$1" префикс интервики табылыыссатыгар эбилиннэ.',
	'interwiki_addfailed' => '"$1" префикс интервики табылыысатыгар кыайан эбиллибэтэ.
Баҕар номнуо онно баара буолуо.',
	'interwiki_edittext' => 'Интервики префикстары уларытыы',
	'interwiki_editintro' => 'Интервики префиксы уларытан эрэҕин.
Баар сигэлэри алдьатыан сөбүн өйдөө.',
	'interwiki_edited' => '"$1" префикс интервики табылыыссатыгар сөпкө уларытылынна.',
	'interwiki_editerror' => '"$1" префикс уларыйар кыаҕа суох.
Баҕар отой да суох буолуон сөп.',
	'interwiki-badprefix' => 'Интервики префикса "$1" туттуллуо суохтаах бэлиэлэрдээх',
	'interwiki_log_added' => '«$2» ($3) префикс (trans: $4) (local: $5) интервики табылыыссатыгар эбилиннэ',
	'interwiki_log_edited' => 'интервики табылыыссаҕа «$2» префиксы уларытта: ($3) (trans: $4) (лок.: $5)',
	'interwiki_log_deleted' => '"$2" префикс интервики табылыыссатыттан сотулунна',
	'right-interwiki' => 'Интервикины уларытыы',
);

/** Sicilian (Sicilianu)
 * @author Santu
 */
$messages['scn'] = array(
	'interwiki' => 'Talìa e mudìfica li dati interwiki',
	'interwiki-title-norights' => 'Talìa li dati interwiki',
	'interwiki-desc' => 'Junci na [[Special:Interwiki|pàggina spiciali]] pi taliari e mudificari la tabedda di li interwiki',
	'interwiki_intro' => "Talìa [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] pi chiossai nfurmazzioni supr'a tabedda di li interwiki.
C'è nu [[Special:Log/interwiki|riggistru di li canciamenti]] a la tabedda di li interwiki.",
	'interwiki_prefix' => 'Prifissu',
	'interwiki-prefix-label' => 'Prifissu:',
	'interwiki_url' => 'URL',
	'interwiki-url-label' => 'URL:',
	'interwiki_local' => 'Qualificari chistu comu a nu wiki lucali',
	'interwiki-local-label' => 'Qualificari chistu comu a nu wiki lucali:',
	'interwiki_trans' => 'Cunzenti interwiki transclusions',
	'interwiki-trans-label' => 'Cunzenti interwiki transclusions:',
	'interwiki_error' => "SBÀGGHIU: La tabedda di li interwiki è vacanti, o c'è qualchi àutru sbàgghiu.",
	'interwiki_reasonfield' => 'Mutivu',
	'interwiki_delquestion' => 'Scancellu "$1"',
	'interwiki_deleting' => 'Stai pi scancillari lu prufissu "$1"',
	'interwiki_deleted' => 'Lu prifissu "$1" vinni scancillatu cu successu dâ tabedda di li interwiki.',
	'interwiki_delfailed' => 'Rimuzzioni dû prifissi "$1" dâ tabedda di li interwiki non arinisciuta.',
	'interwiki_addtext' => 'Jùncicci nu prifissu interwiki',
	'interwiki_addintro' => 'Ora veni iunciutu nu novu prifissu interwiki.
Non sunnu ammittuti li caràttiri: spàzziu ( ), dui punti (:), e cummirciali (&), sìmmulu di uguali (=).',
	'interwiki_addbutton' => 'Iunci',
	'interwiki_added' => 'Lu prifissi "$1" vinni iunciutu a la tabedda di li interwiki.',
	'interwiki_addfailed' => 'Mpussìbbili iunciri lu prufissu "$1" a la tabedda di li interwiki.
Lu prifissi putissi èssiri già prisenti ntâ tabedda.',
	'interwiki_edittext' => 'Mudìfica di nu prifissu interwiki',
	'interwiki_editintro' => 'Si sta pi mudificari nu prifissu interwiki.
Chistu pò non fari funziunari arcuni lijami ca ci sù.',
	'interwiki_edited' => 'Lu prifissi "$1" vinni canciatu nnâ tabedda di li interwiki.',
	'interwiki_editerror' => 'Mpussìbbili mudificari lu prifissi "$1" nnâ tabedda di li interwiki.
Lu prifissu putissi èssiri ca non c\'è.',
	'interwiki-badprefix' => 'Lu prifissu interwiki "$1" cunteni caràttiri non vàlidi',
	'interwiki_log_added' => 'juncìu lu prifissu "$2" ($3) (trans: $4) (lucali: $5) a la tabedda di li interwiki',
	'interwiki_log_edited' => 'mudificau lu prifissu "$2" : ($3) (trans: $4) (lucali: $5) nnâ tabedda di li interwiki',
	'interwiki_log_deleted' => 'rimuvìu lu prifissu "$2" dâ tabedda di li interwiki',
	'right-interwiki' => 'Mudìfica li dati interwiki',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'interwiki' => 'Vidè e mudìfiggà li dati interwiki',
	'interwiki_prefix' => 'Prefissu',
	'interwiki-prefix-label' => 'Prefissu:',
	'interwiki_reasonfield' => 'Rasgioni',
	'interwiki_delquestion' => 'Canzillendi "$1"',
	'interwiki_deleting' => 'Sei canzillendi lu prefissu "$1".',
	'interwiki_addtext' => 'Aggiungi un prefissu interwiki',
	'interwiki_addbutton' => 'Aggiungi',
	'interwiki_logpagename' => 'Rigisthru di la table interwiki',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'interwiki' => 'Zobraziť a upravovať údaje interwiki',
	'interwiki-title-norights' => 'Zobraziť údaje interwiki',
	'interwiki-desc' => 'Pridáva [[Special:Interwiki|špeciálnu stránku]] na zobrazovanie a upravovanie tabuľky interwiki',
	'interwiki_intro' => 'Toto je prehľad tabuľky interwiki. Význam údajov v stĺpcoch:',
	'interwiki_prefix' => 'Predpona',
	'interwiki-prefix-label' => 'Predpona:',
	'interwiki_prefix_intro' => 'Predpona interwiki, ktorá sa má použiť v syntaxi wikitextu <code>[<nowiki />[predpona:<i>názov_stránky</i>]]</code>.',
	'interwiki_url_intro' => 'Šablóna URL. Vyhradené miesto $1 sa nahradí <i>názvom_stránky</i> wikitextu pri použití vyššie uvedenej syntaxi wikitextu.',
	'interwiki_local' => 'Presmerovať',
	'interwiki-local-label' => 'Presmerovať:',
	'interwiki_local_intro' => 'HTTP požiadavka na lokálnu wiki s touto predponou interwiki v URL je:',
	'interwiki_local_0_intro' => 'nezohľadňuje sa, zvyčajne sa blokuje ako „stránka nenájdená“,',
	'interwiki_local_1_intro' => 'presmerovaná na cieľové URL zadané v definícii interwiki odkazu (t.j. berie sa ako odkazy v rámci lokálnej stránky)',
	'interwiki_trans' => 'Transklúzia',
	'interwiki-trans-label' => 'Transklúzia:',
	'interwiki_trans_intro' => 'Ak je použitá syntax wikitextu <code>{<nowiki />{predpona:<i>názov_stránky</i>}}</code>,',
	'interwiki_trans_1_intro' => 'povoliť transklúzie z cudzej wiki ak sú na tejto wiki všeobecne povolené transklúzie interwiki,',
	'interwiki_trans_0_intro' => 'nepovoliť ju, namiesto toho hľadať stránku v mennom priestore šablón.',
	'interwiki_intro_footer' => 'Ďalšie informácie o tabuľke interwiki nájdete na [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org].
Obsahuje [[Special:Log/interwiki|záznam zmien]] tabuľky interwiki.',
	'interwiki_1' => 'áno',
	'interwiki_0' => 'nie',
	'interwiki_error' => 'CHYBA: Tabuľka interwiki je prázdna alebo sa pokazilo niečo iné.',
	'interwiki_edit' => 'Upraviť',
	'interwiki_reasonfield' => 'Dôvod',
	'interwiki_delquestion' => 'Maže sa „$1“',
	'interwiki_deleting' => 'Mažete predponu „$1“.',
	'interwiki_deleted' => 'Predpona „$1“ bola úspešne odstránená z tabuľky interwiki.',
	'interwiki_delfailed' => 'Predponu „$1“ nebola možné odstrániť z tabuľky interwiki.',
	'interwiki_addtext' => 'Pridať predponu interwiki',
	'interwiki_addintro' => 'Pridávate novú predponu interwiki. Pamätajte, že nemôže obsahovať medzery „ “, dvojbodky „:“, ampersand „&“ ani znak rovnosti „=“.',
	'interwiki_addbutton' => 'Pridať',
	'interwiki_added' => 'Predpona „$1“ bola úspešne pridaná do tabuľky interwiki.',
	'interwiki_addfailed' => 'Predponu „$1“ nebola možné pridať do tabuľky interwiki. Je možné, že už v tabuľke interwiki existuje.',
	'interwiki_edittext' => 'Upravuje sa predpona interwiki',
	'interwiki_editintro' => 'Upravujete predponu interwiki. Pamätajte na to, že týmto môžete pokaziť existujúce odkazy.',
	'interwiki_edited' => 'Predpona „$1“ bola úspešne zmenená v tabuľke interwiki.',
	'interwiki_editerror' => 'Predponu „$1“ nebolo možné zmeniť v tabuľke interwiki. Je možné, že neexistuje.',
	'interwiki-badprefix' => 'Uvedená predpona interwiki „$1“ obsahuje neplatné znaky',
	'interwiki_logpagename' => 'Záznam zmien tabuľky interwiki',
	'interwiki_log_added' => 'Pridané „$2“ ($3) (trans: $4) (local: $5) do tabuľky interwiki',
	'interwiki_log_edited' => 'zmenená predpona „$2“ : ($3) (trans: $4) (lokálna: $5) v tabuľke interwiki',
	'interwiki_log_deleted' => 'Odstránené „$2“ z tabuľky interwiki',
	'interwiki_logpagetext' => 'Toto je záznam zmien [[Special:Interwiki|tabuľky interwiki]].',
	'right-interwiki' => 'Upraviť interwiki údaje',
	'action-interwiki' => 'zmeniť tento záznam interwiki',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'interwiki' => 'Прегледај и измени податке о међувикију',
	'interwiki-title-norights' => 'Прегледај податке о међувикију',
	'interwiki-desc' => 'Додаје [[Special:Interwiki|специјалну страну]] за преглед и измену табеле међувикија',
	'interwiki_intro' => 'Ово је преглед табеле међувикија. Значења података у колонама:',
	'interwiki_prefix' => 'Префикс',
	'interwiki-prefix-label' => 'Префикс:',
	'interwiki_prefix_intro' => 'Међувики префикс који ће бити коришћен у <code>[<nowiki />[prefix:<i>pagename</i>]]</code> викитекст синтакси.',
	'interwiki_local' => 'Напред',
	'interwiki-local-label' => 'Напред:',
	'interwiki_trans_intro' => 'Ако је коришћена викитекст синтакса <code>{<nowiki />{prefix:<i>pagename</i>}}</code>, онда:',
	'interwiki_1' => 'да',
	'interwiki_0' => 'не',
	'interwiki_error' => 'Грешка: табела међувикија је празна, или нешто друго није у реду.',
	'interwiki_edit' => 'Измени',
	'interwiki_reasonfield' => 'Разлог',
	'interwiki_delquestion' => 'Бришем „$1”',
	'interwiki_deleting' => 'Ви бришете префикс "$1".',
	'interwiki_deleted' => 'Префикс "$1" је успешно обрисан из табеле међувикија.',
	'interwiki_delfailed' => 'Префикс "$1" није могао бити обрисан из табеле међувикија.',
	'interwiki_addtext' => 'Додај интервики префикс',
	'interwiki_addintro' => 'Ви додајете један интервики префикс.
Имајте на уму да он не може да садржи размаке ( ), двотачку (:), амерсанд (&), или знак једнакости (=).',
	'interwiki_addbutton' => 'Додај',
	'interwiki_added' => 'Префикс "$1" је успешно додат у табелу међувикија.',
	'interwiki_addfailed' => 'Префикс "$1" није могао бити додат у табелу међувикија.
Вероватно већ постоји у њој.',
	'interwiki_edittext' => 'Мењање међувики префикса',
	'interwiki_editintro' => 'Ви менате један међувики префикс.
Имајте на уму да ти може да оштети постојеће међувики везе.',
	'interwiki_edited' => 'Префикс "$1" је успешно измењен у табели међувикија.',
	'interwiki_editerror' => 'Префикс "$1" не може бити измењен у табели међувикија.
Вероватно затшо што не постоји.',
	'interwiki-badprefix' => 'Задати међувики префикс "$1" садржи недозвољене знакове',
	'interwiki_logpagename' => 'Историја табеле међувикија',
	'interwiki_log_added' => 'додат префикс "$2" ($3) (транс: $4) (локално: $5) табели међувикија',
	'interwiki_log_edited' => 'измењен је префикс "$2" : ($3) (транс: $4) (локално: %5) у табели међувикија',
	'interwiki_log_deleted' => 'префикс "$2" је избрисан из табеле међувикија',
	'interwiki_logpagetext' => 'Ово је историја измена [[Special:Interwiki|табеле међувикија]].',
	'right-interwiki' => 'Измени међувики',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'interwiki' => 'Pregledaj i izmeni podatke o međuvikiju',
	'interwiki-title-norights' => 'Pregledaj podatke o međuvikiju',
	'interwiki-desc' => 'Dodaje [[Special:Interwiki|specijalnu stranu]] za pregled i izmenu tabele međuvikija',
	'interwiki_intro' => 'Ovo je pregled tabele međuvikija. Značenja podataka u kolonama:',
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_prefix_intro' => 'Međuviki prefiks koji će biti korišćen u <code>[<nowiki />[prefix:<i>pagename</i>]]</code> vikitekst sintaksi.',
	'interwiki_local' => 'Napred',
	'interwiki-local-label' => 'Napred:',
	'interwiki_trans_intro' => 'Ako je korišćena vikitekst sintaksa <code>{<nowiki />{prefix:<i>pagename</i>}}</code>, onda:',
	'interwiki_1' => 'da',
	'interwiki_0' => 'ne',
	'interwiki_error' => 'Greška: tabela međuvikija je prazna, ili nešto drugo nije u redu.',
	'interwiki_edit' => 'Izmeni',
	'interwiki_reasonfield' => 'Razlog',
	'interwiki_delquestion' => 'Brišem „$1”',
	'interwiki_deleting' => 'Vi brišete prefiks "$1".',
	'interwiki_deleted' => 'Prefiks "$1" je uspešno obrisan iz tabele međuvikija.',
	'interwiki_delfailed' => 'Prefiks "$1" nije mogao biti obrisan iz tabele međuvikija.',
	'interwiki_addtext' => 'Dodaj interviki prefiks',
	'interwiki_addintro' => 'Vi dodajete jedan interviki prefiks.
Imajte na umu da on ne može da sadrži razmake ( ), dvotačku (:), amersand (&), ili znak jednakosti (=).',
	'interwiki_addbutton' => 'Dodaj',
	'interwiki_added' => 'Prefiks "$1" je uspešno dodat u tabelu međuvikija.',
	'interwiki_addfailed' => 'Prefiks "$1" nije mogao biti dodat u tabelu međuvikija.
Verovatno već postoji u njoj.',
	'interwiki_edittext' => 'Menjanje međuviki prefiksa',
	'interwiki_editintro' => 'Vi menate jedan međuviki prefiks.
Imajte na umu da ti može da ošteti postojeće međuviki veze.',
	'interwiki_edited' => 'Prefiks "$1" je uspešno izmenjen u tabeli međuvikija.',
	'interwiki_editerror' => 'Prefiks "$1" ne može biti izmenjen u tabeli međuvikija.
Verovatno zatšo što ne postoji.',
	'interwiki-badprefix' => 'Zadati međuviki prefiks "$1" sadrži nedozvoljene znakove',
	'interwiki_logpagename' => 'Istorija tabele međuvikija',
	'interwiki_log_added' => 'dodat prefiks "$2" ($3) (trans: $4) (lokalno: $5) tabeli međuvikija',
	'interwiki_log_edited' => 'izmenjen je prefiks "$2" : ($3) (trans: $4) (lokalno: %5) u tabeli međuvikija',
	'interwiki_log_deleted' => 'prefiks "$2" je izbrisan iz tabele međuvikija',
	'interwiki_logpagetext' => 'Ovo je istorija izmena [[Special:Interwiki|tabele međuvikija]].',
	'right-interwiki' => 'Izmeni međuviki',
);

/** Seeltersk (Seeltersk)
 * @author Purodha
 * @author Pyt
 */
$messages['stq'] = array(
	'interwiki' => 'Interwiki-Doaten bekiekje un beoarbaidje',
	'interwiki_intro' => 'Dit is n Uursicht fon dän Inhoold fon ju Interwiki-Tabelle.
Do Doaten in do eenpelde Spalten hääbe ju foulgjende Betjuudenge:',
	'interwiki_prefix' => 'Präfix',
	'interwiki-prefix-label' => 'Präfix:',
	'interwiki_error' => 'Failer: Ju Interwiki-Tabelle is loos.',
	'interwiki_reasonfield' => 'Gruund:',
	'interwiki_delquestion' => 'Läsket „$1“',
	'interwiki_deleting' => 'Du hoalst Prefix "$1" wäch.',
	'interwiki_deleted' => '„$1“ wuude mäd Ärfoulch uut ju Interwiki-Tabelle wächhoald.',
	'interwiki_delfailed' => '„$1“ kuude nit uut ju Interwiki-Tabelle läsked wäide.',
	'interwiki_addtext' => 'N Interwiki-Präfix bietouföigje',
	'interwiki_addintro' => 'Du föigest n näi Interwiki-Präfix bietou. Beoachte, dät et neen Loosteeken ( ), Koopmons-Un (&), Gliekhaidsteeken (=) un naan Dubbelpunkt (:) änthoolde duur.',
	'interwiki_addbutton' => 'Bietouföigje',
	'interwiki_added' => '„$1“ wuude mäd Ärfoulch ju Interwiki-Tabelle bietouföiged.',
	'interwiki_addfailed' => '„$1“ kuude nit ju Interwiki-Tabelle bietouföiged wäide.',
	'interwiki_logpagename' => 'Interwiki-Tabellenlogbouk',
	'interwiki_log_added' => 'häd „$2“ ($3) (trans: $4) (lokal: $5) ju Interwiki-Tabelle bietouföiged',
	'interwiki_log_deleted' => 'häd „$2“ uut ju Interwiki-Tabelle wächhoald',
	'interwiki_logpagetext' => 'In dit Logbouk wäide Annerengen an ju [[Special:Interwiki|Interwiki-Tabelle]] protokollierd.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 */
$messages['su'] = array(
	'interwiki_reasonfield' => 'Alesan',
	'interwiki_delquestion' => 'Ngahapus "$1"',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Fluff
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 * @author Per
 * @author Purodha
 */
$messages['sv'] = array(
	'interwiki' => 'Visa och redigera interwiki-data',
	'interwiki-title-norights' => 'Visa interwiki-data',
	'interwiki-desc' => 'Lägger till en [[Special:Interwiki|specialsida]] för att visa och ändra interwikitabellen',
	'interwiki_intro' => 'Se [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] för mer information om interwikitabellen.
Det finns en [[Special:Log/interwiki|logg]] över ändringar av interwikitabellen.',
	'interwiki_prefix' => 'Prefix',
	'interwiki-prefix-label' => 'Prefix:',
	'interwiki_prefix_intro' => 'Interwiki-prefix avsedda att användas i <code>[<nowiki />[prefix:<i>pagename</i>]]</code>-wikisyntax.',
	'interwiki_local' => 'Vidarebefordra',
	'interwiki-local-label' => 'Vidarebefordra:',
	'interwiki_local_intro' => 'En HTTP-förfrågan till den lokala wikin med denna interwiki-prefix i webbadressen är:',
	'interwiki_trans' => 'Transkludera',
	'interwiki-trans-label' => 'Transkludera:',
	'interwiki_intro_footer' => 'Se [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] för mer information om interwikitabellen.
Det finns en [[Special:Log/interwiki|logg över ändringar]] i interwikitabellen.',
	'interwiki_1' => 'ja',
	'interwiki_0' => 'nej',
	'interwiki_error' => 'FEL: Interwikitabellen är tom, eller så gick något fel.',
	'interwiki_edit' => 'Redigera',
	'interwiki_reasonfield' => 'Anledning:',
	'interwiki_delquestion' => 'Ta bort "$1"',
	'interwiki_deleting' => 'Du håller på att ta bort prefixet "$1".',
	'interwiki_deleted' => 'Prefixet "$1 har raderats från interwikitabellen.',
	'interwiki_delfailed' => 'Prefixet "$1" kunde inte raderas från interwikitabellen.',
	'interwiki_addtext' => 'Lägg till ett interwikiprefix',
	'interwiki_addintro' => 'Du håller på att lägga till ett nytt interwikiprefix.
Kom ihåg att det inte kan innehålla mellanslag ( ), kolon (:), &-tecken eller likhetstecken (=).',
	'interwiki_addbutton' => 'Lägg till',
	'interwiki_added' => 'Prefixet "$1" har lagts till i interwikitabellen.',
	'interwiki_addfailed' => 'Prefixet "$1" kunde inte läggas till i interwikitabellen.
Det är möjligt att prefixet redan finns i tabellen.',
	'interwiki_edittext' => 'Redigera ett interwikiprefix',
	'interwiki_editintro' => 'Du redigerar ett interwikiprefix. Notera att detta kan förstöra existerande länkar.',
	'interwiki_edited' => 'Prefixet "$1" har ändrats i interwikitabellen.',
	'interwiki_editerror' => 'Prefixet "$1" kan inte ändras i interwikitabellen. Det är möjligt att det inte finns.',
	'interwiki-badprefix' => 'Specificerat interwikiprefix "$1" innehåller ogiltiga tecken',
	'interwiki_logpagename' => 'Interwikitabellogg',
	'interwiki_log_added' => 'lade till prefixet "$2" ($3) (trans: $4) (lokal: $5) i interwikitabellen',
	'interwiki_log_edited' => 'ändrade prefixet "$2" ($3) (trans: $4) (lokal: $5) i interwikitabellen',
	'interwiki_log_deleted' => 'tog bort prefixet "$2" från interwikitabellen',
	'interwiki_logpagetext' => 'Detta är en logg över ändringar i [[Special:Interwiki|interwikitabellen]].',
	'right-interwiki' => 'Redigera interwikidata',
	'action-interwiki' => 'ändra det här interwikielementet',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'interwiki_reasonfield' => 'Čymu',
	'interwiki_addbutton' => 'Dodej',
);

/** Telugu (తెలుగు)
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'interwiki' => 'అంతర్వికీ భోగట్టాని చూడండి మరియు మార్చండి',
	'interwiki-title-norights' => 'అంతర్వికీ భోగట్టా చూడండి',
	'interwiki_intro' => 'అంతర్వికీ పట్టిక యొక్క సమీక్ష. పట్టికలోని కాలమ్న్స్ సమాచారము అర్ధము:',
	'interwiki_prefix' => 'ఉపసర్గ',
	'interwiki-prefix-label' => 'ఉపసర్గ:',
	'interwiki_local' => 'ముందుకు',
	'interwiki-local-label' => 'ముందుకు:',
	'interwiki_1' => 'అవును',
	'interwiki_0' => 'కాదు',
	'interwiki_error' => 'పొరపాటు: అంతర్వికీ పట్టిక ఖాళీగా ఉంది, లేదా ఏదో తప్పు జరిగింది.',
	'interwiki_edit' => 'మార్చు',
	'interwiki_reasonfield' => 'కారణం:',
	'interwiki_delquestion' => '"$1"ని తొలగిస్తున్నారు',
	'interwiki_deleting' => 'మీరు "$1" అనే ఉపసర్గని తొలగించబోతున్నారు.',
	'interwiki_deleted' => 'అంతర్వికీ పట్టిక నుండి "$1" అనే ఉపసర్గని విజయవంతంగా తొలగించాం.',
	'interwiki_delfailed' => 'అంతర్వికీ పట్టిక నుండి "$1" అనే ఉపసర్గని తొలగించలేకపోయాం.',
	'interwiki_addtext' => 'ఓ అంతర్వికీ ఉపసర్గని చేర్చండి',
	'interwiki_addbutton' => 'చేర్చు',
	'interwiki_logpagename' => 'అంతర్వికీ పట్టిక చిట్టా',
	'interwiki_logpagetext' => 'ఇది [[Special:Interwiki|అంతర్వికీ పట్టిక]]కి జరిగిన మార్పుల చిట్టా.',
	'right-interwiki' => 'అంతర్వికీ సమాచారము మార్చు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'interwiki_reasonfield' => 'Motivu:',
	'interwiki_delquestion' => 'Halakon $1',
	'interwiki_addbutton' => 'Tau tan',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'interwiki_reasonfield' => 'Сабаб',
	'interwiki_delquestion' => 'Дар ҳоли ҳазфи "$1"',
	'interwiki_addbutton' => 'Илова',
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'interwiki_delquestion' => 'Dar holi hazfi "$1"',
	'interwiki_addbutton' => 'Ilova',
);

/** Thai (ไทย)
 * @author Manop
 * @author Passawuth
 */
$messages['th'] = array(
	'interwiki' => 'ดูและแก้ไขข้อมูลอินเตอร์วิกิ',
	'interwiki-title-norights' => 'ดูข้อมูลอินเตอร์วิกิ',
	'interwiki_prefix' => 'คำนำหน้า',
	'interwiki-prefix-label' => 'คำนำหน้า:',
	'interwiki_reasonfield' => 'เหตุผล',
	'interwiki_delquestion' => 'ลบ "$1"',
	'interwiki_addbutton' => 'เพิ่ม',
	'interwiki_edittext' => 'แก้ไขคำนำหน้าอินเตอร์วิกิ',
	'right-interwiki' => 'แก้ไขข้อมูลอินเตอร์วิกิ',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'interwiki_edit' => 'Redaktirle',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'interwiki' => "Tingnan at baguhin ang datong pangugnayang-wiki (''interwiki'')",
	'interwiki-title-norights' => "Tingnan ang datong pangugnayang-wiki (''interwiki'')",
	'interwiki-desc' => 'Nagdaragdag ng isang [[Special:Interwiki|natatanging pahina]] upang matingnan at mabago ang tablang pang-ugnayang wiki',
	'interwiki_intro' => "Isa itong paglalarawan ng tabla ng ugnayang-wiki (''interwiki''). Nasa loob ng pababang mga hanay ang mga kahulugan ng dato:",
	'interwiki_prefix' => 'Unlapi',
	'interwiki-prefix-label' => 'Unlapi:',
	'interwiki_prefix_intro' => 'Unlapi ng ugnayang-wiki na gagamitin sa loob ng palaugnayang <code>[<nowiki />[prefix:<i>pagename</i>]]</code> ng teksto ng wiki.',
	'interwiki_url' => 'URL',
	'interwiki-url-label' => 'URL:',
	'interwiki_url_intro' => 'Suleras para sa mga URL. Ang tagpaghawak ng pook na $1 ay mapapalitan ng <i>pagename</i> ng teksto ng wiki, kapag ginamit ang nabanggit sa itaas na palaugnayang teksto ng wiki.',
	'interwiki_local' => 'Isulong',
	'interwiki-local-label' => 'Isulong:',
	'interwiki_local_intro' => 'Ang isang kahilingang http sa pampook na wiki na may ganitong unlapi ng ugnayang-wiki na nasa loob ng URL ay:',
	'interwiki_local_0_intro' => 'huwag tanggapin, karaniwang hinahadlangan ng "hindi natagpuan ang pahina",',
	'interwiki_local_1_intro' => 'itinuro papunta sa pinupukol na ibinigay na URL sa loob ng mga kahulugan ng kawing ng ugnayang-wiki (iyong mga itinuturing na katulad ng mga sanggunian sa pampook na mga pahina)',
	'interwiki_trans' => 'Paglilipat-sama (transklusyon)',
	'interwiki-trans-label' => 'Paglilipat-sama (transklusyon):',
	'interwiki_trans_intro' => 'Kapag ginamit ang palaugnayang <code>{<nowiki />{prefix:<i>pagename</i>}}</code> ng teksto ng wiki, kung gayon:',
	'interwiki_trans_1_intro' => 'pahintulutan ang paglilipat-sama mula sa dayuhang wiki, kung pangkalahatang pinapayagan sa wiking ito ang paglilipat-sama',
	'interwiki_trans_0_intro' => 'huwag itong pahintulutan, sa halip maghanap ng isang pahinang nasa loob ng espasyo ng pangalan ng suleras.',
	'interwiki_intro_footer' => 'Tingnan ang [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] para sa mas marami pang mga kabatiran hinggil sa tabla ng ugnayang-wiki.
Mayroong isang [[Special:Log/interwiki|talaan ng mga pagbabago]] sa tabla ng ugnayang-wiki.',
	'interwiki_1' => 'oo',
	'interwiki_0' => 'hindi',
	'interwiki_error' => "Kamalian: Walang laman ang tablang pangugnayang-wiki (''interwiki''), o may iba pang bagay na nagkaroon ng kamalian/suliranin.",
	'interwiki_edit' => 'Baguhin',
	'interwiki_reasonfield' => 'Dahilan',
	'interwiki_delquestion' => 'Binubura ang "$1"',
	'interwiki_deleting' => 'Binubura mo ang unlaping "$1".',
	'interwiki_deleted' => "Matagumpay na natanggal ang unlaping \"\$1\" mula sa tablang pangugnayang-wiki (''interwiki'').",
	'interwiki_delfailed' => "Hindi matanggal ang unlaping \"\$1\" mula sa tablang pangugnayang-wiki (''interwiki'').",
	'interwiki_addtext' => "Magdagdag ng isang unlaping pangugnayang-wiki (''interwiki'')",
	'interwiki_addintro' => "Nagdaragdag ng isang bagong unlaping pangugnayang-wiki (''interwiki'').
Tandaan lamang na hindi ito maaaring maglaman ng mga puwang ( ), mga tutuldok (:), bantas para sa \"at\" (&), o mga bantas na pangkatumbas (=).",
	'interwiki_addbutton' => 'Idagdag',
	'interwiki_added' => "Matagumpay na naidagdag ang unlaping \"\$1\" sa tablang pangugnayang-wiki (''interwiki'').",
	'interwiki_addfailed' => "Hindi maidagdag ang unlaping \"\$1\" sa tablang pangugnayang-wiki (''interwiki'').
Maaaring umiiral na ito sa loob ng tablang pangugnayang-wiki.",
	'interwiki_edittext' => "Binabago ang isang unlaping pangugnayang-wiki (''interwiki'')",
	'interwiki_editintro' => "Binabago mo ang unlaping pangugnayang-wiki (''interwiki'').
Tandaan na maaaring maputol nito ang umiiral na mga kawing.",
	'interwiki_edited' => "Matagumpay na nabago ang unlaping \"\$1\" sa loob ng tablang pangugnayang-wiki (''interwiki'').",
	'interwiki_editerror' => "Hindi mabago ang unlaping \"\$1\" sa loob ng tablang pangugnayang-wiki (''interwiki'').
Maaaring hindi pa ito umiiral.",
	'interwiki-badprefix' => "Naglalaman ang tinukoy na pangpaguugnayan ng wiking (''interwiki'') unlaping \"\$1\" ng hindi tanggap na mga panitik",
	'interwiki_logpagename' => 'Talaan ng tablang pang-ugnayang wiki',
	'interwiki_log_added' => 'idinagdag ang unlaping "$2" ($3) (trans: $4) (lokal: $5) sa tablang pangugnayang-wiki (\'\'interwiki\'\')',
	'interwiki_log_edited' => 'binago ang unlaping "$2" : ($3) (trans: $4) (lokal: $5) sa loob ng tablang pangugnayang-wiki (\'\'interwiki\'\')',
	'interwiki_log_deleted' => "tinanggal ang unlaping \"\$2\" mula tablang pangugnayang-wiki (''interwiki'')",
	'interwiki_logpagetext' => 'Isa itong talaan ng mga pagbabago sa [[Special:Interwiki|tablang pang-ugnayang wiki]].',
	'right-interwiki' => "Baguhin ang datong pangugnayang-wiki (''interwiki'')",
	'action-interwiki' => "baguhin ang ipinasok/entradang ito na pang-ugnayang wiki (''interwiki'')",
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Suelnur
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'interwiki' => 'Vikilerarası veriyi gör ve değiştir',
	'interwiki-title-norights' => 'Vikilerarası veriyi gör',
	'interwiki-desc' => 'Vikilerarası tabloyu görmek ve değiştirmek için [[Special:Interwiki|özel bir sayfa]] ekler',
	'interwiki_intro' => 'Bu vikilerarası tabloya genel bir bakıştır. Sütunlardaki verinin anlamları:',
	'interwiki_prefix' => 'Önek',
	'interwiki-prefix-label' => 'Önek:',
	'interwiki_local' => 'Yönlendir',
	'interwiki-local-label' => 'Yönlendir:',
	'interwiki_trans' => 'Görüntüle',
	'interwiki-trans-label' => 'Görüntüle:',
	'interwiki_1' => 'evet',
	'interwiki_0' => 'hayır',
	'interwiki_error' => 'Hata: İnterviki tablosu boş ya da başka bir şeyde sorun çıktı.',
	'interwiki_edit' => 'Değiştir',
	'interwiki_reasonfield' => 'Neden:',
	'interwiki_addtext' => 'Bir interviki öneki ekler',
	'interwiki_addbutton' => 'Ekle',
	'right-interwiki' => 'İnterviki verilerini düzenler',
	'action-interwiki' => 'bu interviki girdisini değiştir',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'interwiki_prefix' => 'Префікс',
	'interwiki-prefix-label' => 'Префікс:',
	'interwiki_0' => 'ні',
	'interwiki_edit' => 'Редагувати',
	'interwiki_reasonfield' => 'Причина:',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'interwiki' => 'Varda e modìfega i dati interwiki',
	'interwiki-title-norights' => 'Varda i dati interwiki',
	'interwiki_intro' => 'Sta qua la xe na panoramica de la tabèla dei interwiki. El significato dei dati in te le colòne xe:',
	'interwiki_prefix' => 'Prefisso',
	'interwiki-prefix-label' => 'Prefisso:',
	'interwiki_local' => 'Avanti',
	'interwiki-local-label' => 'Avanti:',
	'interwiki_trans' => 'Transcludi',
	'interwiki-trans-label' => 'Transcludi:',
	'interwiki_1' => 'sì',
	'interwiki_0' => 'no',
	'interwiki_error' => 'ERÓR: La tabèla dei interwiki la xe voda, o ghe xe qualche altro erór.',
	'interwiki_edit' => 'Modìfega',
	'interwiki_reasonfield' => 'Motivassion:',
	'interwiki_delquestion' => 'Scancelassion de "$1"',
	'interwiki_deleting' => 'Te sì drio scancelar el prefisso "$1"',
	'interwiki_deleted' => 'El prefisso "$1" el xe stà scancelà da la tabèla dei interwiki.',
	'interwiki_delfailed' => 'No s\'à podesto cavar el prefisso "$1" da la tabèla dei interwiki.',
	'interwiki_addtext' => 'Zonta un prefisso interwiki',
	'interwiki_addintro' => 'Te sì drio zontar un prefisso interwiki novo.
No xe mia parmessi i caràteri: spassio ( ), do ponti (:), e comerçial (&), sìnbolo de uguale (=).',
	'interwiki_addbutton' => 'Zonta',
	'interwiki_added' => 'El prefisso "$1" el xe stà zontà a la tabèla dei interwiki.',
	'interwiki_addfailed' => 'No se riesse a zontar el prefisso "$1" a la tabèla dei interwiki.
El prefisso el podarìa èssar xà presente in tabèla.',
	'interwiki_edittext' => 'Modìfega de un prefisso interwiki',
	'interwiki_editintro' => 'Te sì drio modificar un prefisso interwiki.
Ocio a no desfar i colegamenti esistenti.',
	'interwiki_edited' => 'El prefisso "$1" el xe stà canbià in te la tabèla dei interwiki.',
	'interwiki_editerror' => 'No se riesse a canbiar el prefisso "$1" in te la tabèla dei interwiki.
Sto prefisso el podarìa èssar inesistente.',
	'interwiki-badprefix' => 'El prefisso interwiki speçificà ("$1") el contien caràteri mia validi',
	'interwiki_logpagename' => 'Registro de la tabèla interwiki',
	'interwiki_log_added' => 'gà zontà el prefisso "$2" ($3) (trans: $4) (locale: $5) a la tabèla dei interwiki',
	'interwiki_log_edited' => 'gà canbià el prefisso "$2" : ($3) (trans: $4) (locale: $5) in te la tabèla dei interwiki',
	'interwiki_log_deleted' => 'gà cavà el prefisso "$2" da la tabèla dei interwiki',
	'interwiki_logpagetext' => 'Registro dei canbiamenti fati a la [[Special:Interwiki|tabèla dei interwiki]].',
	'right-interwiki' => 'Cànbia i dati interwiki',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'interwiki_prefix' => 'Prefiks',
	'interwiki-prefix-label' => 'Prefiks:',
	'interwiki_1' => 'ka',
	'interwiki_0' => 'ei',
	'interwiki_edit' => 'Redaktiruida',
	'interwiki_reasonfield' => 'Sü',
	'interwiki_addbutton' => 'Ližata',
	'interwiki_edittext' => 'Interwiki-prefiksoiden redaktiruind',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'interwiki' => 'Xem và sửa đổi dữ liệu về liên kết liên wiki',
	'interwiki-title-norights' => 'Xem dữ liệu liên wiki',
	'interwiki-desc' => 'Thêm một [[Special:Interwiki|trang đặc biệt]] để xem sửa đổi bảng liên wiki',
	'interwiki_intro' => 'Chú giải các cột trong bảng liên wiki:',
	'interwiki_prefix' => 'Tiền tố',
	'interwiki-prefix-label' => 'Tiền tố:',
	'interwiki_prefix_intro' => 'Tiền tố liên wiki dùng trong cú pháp wiki <code>[<nowiki />[tiền tố:<i>tên trang</i>]]</code>.',
	'interwiki_url_intro' => 'Mẫu địa chỉ URL. Dấu hiệu $1 được thay bằng <i>tiền tố</i> khi nào sử dụng cú pháp ở trên.',
	'interwiki_local' => 'Chuyển tiếp',
	'interwiki-local-label' => 'Chuyển tiếp:',
	'interwiki_local_intro' => 'Khi nào truy cập wiki địa phương dùng tiền tố liên wiki trong URL, yêu cầu HTTP được:',
	'interwiki_local_0_intro' => 'bác bỏ, thường bị chặn với kết quả “không tìm thấy trang”,',
	'interwiki_local_1_intro' => 'đổi hướng tới URL đích trong định nghĩa liên kết liên wiki, nó coi như là URL dẫn đến trang địa phương',
	'interwiki_trans' => 'Nhúng bản mẫu',
	'interwiki-trans-label' => 'Nhúng bản mẫu:',
	'interwiki_trans_intro' => 'Khi nào sử dụng cú pháp wiki <code>{<nowiki />{tiền tố:<i>tên trang</i>}}</code>:',
	'interwiki_trans_1_intro' => 'cho phép nhúng trang từ wiki bên ngoài, nếu wiki này cho phép nhúng trang liên wiki nói chung',
	'interwiki_trans_0_intro' => 'thay vì cho phép nhúng liên wiki, tìm kiếm trang trong không gian tên bản mẫu địa phương.',
	'interwiki_intro_footer' => 'Xem [http://www.mediawiki.org/wiki/Interwiki_table?uselang=vi MediaWiki.org] để biết thêm thông tin về bảng liên wiki.
Có [[Special:Log/interwiki|nhật trình các thay đổi]] tại bảng liên wiki.',
	'interwiki_1' => 'có',
	'interwiki_0' => 'không',
	'interwiki_error' => 'LỖi: Bảng liên wiki hiện đang trống, hoặc có vấn đề gì đó đã xảy ra.',
	'interwiki_edit' => 'Sửa đổi',
	'interwiki_reasonfield' => 'Lý do:',
	'interwiki_delquestion' => 'Xóa “$1”',
	'interwiki_deleting' => 'Bạn đang xóa tiền tố “$1”.',
	'interwiki_deleted' => 'Tiền tố “$1” đã được xóa khỏi bảng liên wiki.',
	'interwiki_delfailed' => 'Tiền tố “$1” không thể xóa khỏi bảng liên wiki.',
	'interwiki_addtext' => 'Thêm tiền tố liên kết liên wiki',
	'interwiki_addintro' => 'Bạn đang thêm một tiền tố liên wiki mới.
Hãy nhớ rằng nó không chứa được khoảng trắng ( ), dấu hai chấm (:), dấu và (&), hay dấu bằng (=).',
	'interwiki_addbutton' => 'Thêm',
	'interwiki_added' => 'Tiền tố “$1” đã được thêm vào bảng liên wiki.',
	'interwiki_addfailed' => 'Tiền tố “$1” không thể thêm vào bảng liên wiki.
Có thể nó đã tồn tại trong bảng liên wiki rồi.',
	'interwiki_edittext' => 'Sửa đổi tiền tố liên wiki',
	'interwiki_editintro' => 'Bạn đang sửa đổi một tiền tố liên wiki. Hãy nhớ rằng việc làm này có thể phá hỏng các liên hết đã có.',
	'interwiki_edited' => 'Tiền tố “$1” đã thay đổi xong trong bảng liên wiki.',
	'interwiki_editerror' => 'Tiền tố “$1” không thể thay đổi trong bảng liên wiki. Có thể nó không tồn tại.',
	'interwiki-badprefix' => 'Tiền tố liên wiki “$1” có chứa ký tự không hợp lệ',
	'interwiki_logpagename' => 'Nhật trình bảng liên wiki',
	'interwiki_log_added' => 'đã thêm tiền tố “$2” ($3) (ngoài: $4) (trong:$5) vào bảng liên wiki',
	'interwiki_log_edited' => 'đã thay đổi tiền tố “$2” : ($3) (ngoài: $4) (trong: $5) trong bảng liên wiki',
	'interwiki_log_deleted' => 'đã xóa tiền tố “$2” khỏi bảng liên wiki',
	'interwiki_logpagetext' => 'Đây là nhật trình các thay đổi trong [[Special:Interwiki|bảng liên wiki]].',
	'right-interwiki' => 'Sửa dữ liệu liên wiki',
	'action-interwiki' => 'thay đổi khoản mục liên wiki này',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'interwiki' => 'Logön e bevobön nünodis vüvükik',
	'interwiki-title-norights' => 'Logön nünodis vüvükik',
	'interwiki-desc' => 'Läükön [[Special:Interwiki|padi patik]] ad logön e bevobön taibi vüvükik',
	'interwiki_intro' => 'Logön eli [http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org] ad tuvön nünis pluik tefü taib vüvükik.
Dabinon [[Special:Log/interwiki|jenotalised votükamas]] taiba vüvükik.',
	'interwiki_prefix' => 'Foyümot',
	'interwiki-prefix-label' => 'Foyümot:',
	'interwiki_error' => 'Pöl: Taib vüvükik vagon, u ba pöl votik ejenon.',
	'interwiki_reasonfield' => 'Kod',
	'interwiki_delquestion' => 'El „$1“ pamoükon',
	'interwiki_deleting' => 'Moükol foyümoti: „$1“.',
	'interwiki_deleted' => 'Foyümot: „$1“ pemoükon benosekiko se taib vüvükik.',
	'interwiki_delfailed' => 'No eplöpos ad moükön foyümot: „$1“ se taib vüvükik.',
	'interwiki_addtext' => 'Läükön foyümoti vüvükik',
	'interwiki_addintro' => 'Läükol foyümoti vüvükik nulik.
Demolös, das foyümot no dalon ninädon spadis ( ), telpünis (:), (&), u (=).',
	'interwiki_addbutton' => 'Läükön',
	'interwiki_added' => 'Foyümot: „$1“ peläükon benosekiko taibe vüvükik.',
	'interwiki_addfailed' => 'No eplöpos ad läükön foyümoti: „$1“ taibe vüvükik.
Ba ya dabinon in taib vüvükik.',
	'interwiki_edittext' => 'Votükam foyümota vüvükik',
	'interwiki_editintro' => 'Bevobol foyümoti vüvükik.
Demolös, das atos kanon breikön yümis dabinöl.',
	'interwiki_edited' => 'Foyümot: „$1“ pevotükon benosekiko in taib vüvükik.',
	'interwiki_editerror' => 'No eplöpos ad votükön foyümoti: „$1“ in taib vüvükik.
Ba no dabinon.',
	'interwiki-badprefix' => 'Foyümot vüvükik pavilöl: „$1“ ninädon malatis no lonöfölis',
	'interwiki_logpagename' => 'Jenotalised taiba vüvükik',
	'interwiki_log_added' => 'eläükön foyümoti: „$2“ ($3) (trans: $4) (local: $5) taibe vüvükik.',
	'interwiki_log_edited' => 'evotükon foyümoti: „$2“ : ($3) (trans: $4) (local: $5) in taib vüvükik',
	'interwiki_log_deleted' => 'emoükon foyümoti: „$2“ se taib vüvükik',
	'interwiki_logpagetext' => 'Is palisedons votükams [[Special:Interwiki|taiba vüvükik]].',
	'right-interwiki' => 'Bevobön nünis vüvükik',
	'action-interwiki' => 'votükön pati vüvükik at',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'interwiki_edit' => 'רעדאַקטירן',
	'interwiki_addbutton' => 'צולייגן',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'interwiki' => '去睇同編輯跨維基資料',
	'interwiki-title-norights' => '去睇跨維基資料',
	'interwiki_intro' => '睇吓[http://www.mediawiki.org/wiki/Interwiki_table MediaWiki.org]有關跨維基表嘅更多資料。
嗰度有一個對跨維基表嘅[[Special:Log/interwiki|修改日誌]]。',
	'interwiki_prefix' => '前綴',
	'interwiki-prefix-label' => '前綴:',
	'interwiki_local' => '定義呢個做一個本地wiki',
	'interwiki-local-label' => '定義呢個做一個本地wiki:',
	'interwiki_trans' => '容許跨維基包含',
	'interwiki-trans-label' => '容許跨維基包含:',
	'interwiki_error' => '錯誤: 跨維基表係空、又或者有其它嘢出錯。',
	'interwiki_reasonfield' => '原因',
	'interwiki_delquestion' => '刪緊 "$1"',
	'interwiki_deleting' => '你而家拎走緊前綴 "$1"。',
	'interwiki_deleted' => '前綴 "$1" 已經成功噉響個跨維基表度拎走咗。',
	'interwiki_delfailed' => '前綴 "$1" 唔能夠響個跨維基表度拎走。',
	'interwiki_addtext' => '加入一個跨維基前綴',
	'interwiki_addintro' => '你而家加緊一個新嘅跨維基前綴。
要記住佢係唔可以包含住空格 ( )、冒號 (:)、連字號 (&)，或者係等號 (=)。',
	'interwiki_addbutton' => '加',
	'interwiki_added' => '前綴 "$1" 已經成功噉加入到跨維基表。',
	'interwiki_addfailed' => '前綴 "$1" 唔能夠加入到跨維基表。
可能已經響個跨維基表度存在。',
	'interwiki_edittext' => '改緊一個跨維基前綴',
	'interwiki_editintro' => '你而家改緊跨維基前綴。
記住呢個可以整斷現有嘅連結。',
	'interwiki_edited' => '前綴 "$1" 已經響個跨維基表度改咗。',
	'interwiki_editerror' => '前綴 "$1" 唔能夠響個跨維基表度改。
可能佢並唔存在。',
	'interwiki-badprefix' => '所指定嘅跨維基前綴 "$1" 含有無效嘅字母',
	'interwiki_log_added' => '加咗前綴 "$2" ($3) (含: $4) (本: $5) 到個跨維基表',
	'interwiki_log_edited' => '響跨維基表度改咗前綴 "$2" : ($3) (含: $4) (本: $5)',
	'interwiki_log_deleted' => '響個跨維基表度拎走咗前綴 "$2"',
	'right-interwiki' => '編輯跨維基資料',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gaoxuewei
 * @author Liangent
 * @author PhiLiP
 * @author Vina
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'interwiki' => '查看并编辑跨维基连结表',
	'interwiki-title-norights' => '查看跨维基资料',
	'interwiki-desc' => '新增[[Special:Interwiki|特殊页面]]以查看或编辑跨语言链接表',
	'interwiki_intro' => '这是跨维基链接表的概览。列中的数据的含义：',
	'interwiki_prefix' => '前缀',
	'interwiki-prefix-label' => '前缀:',
	'interwiki_local' => '转发',
	'interwiki-local-label' => '转发:',
	'interwiki_trans' => '包含',
	'interwiki-trans-label' => '包含:',
	'interwiki_1' => '是',
	'interwiki_0' => '否',
	'interwiki_error' => '错误: 跨维基连结表为空，或是发生其它错误。',
	'interwiki_edit' => '编辑',
	'interwiki_reasonfield' => '原因：',
	'interwiki_delquestion' => '正在删除"$1"',
	'interwiki_deleting' => '您正在删除前缀"$1"。',
	'interwiki_deleted' => '已成功地从连结表中删除前缀"$1"。',
	'interwiki_delfailed' => '无法从连结表删除前缀"$1"。',
	'interwiki_addtext' => '新增一个跨维基前缀',
	'interwiki_addintro' => '您现在加入一个新的跨维基连结前缀。
要记住它不可以包含空格 （ ）、冒号 （:）、连字号 （&），或者是等号 （=）。',
	'interwiki_addbutton' => '加入',
	'interwiki_added' => '前缀 "$1" 已经成功地加入到跨维基连结表。',
	'interwiki_addfailed' => '前缀 "$1" 不能加入到跨维基连结表。
可能已经在跨维基连结表中存在。',
	'interwiki_edittext' => '修改一个跨维基连结前缀',
	'interwiki_editintro' => '您现正修改跨维基连结前缀。
记住这动作可以中断现有的连结。',
	'interwiki_edited' => '前缀 "$1" 已经在跨维基连结表中修改。',
	'interwiki_editerror' => '前缀 "$1" 不能在跨维基连结表中修改。
可能它并不存在。',
	'interwiki-badprefix' => '所指定的跨维基前缀 "$1" 含有无效的字母',
	'interwiki_log_added' => '加入了连结前缀 "$2" （$3） （含: $4） （本: $5） 到跨维基连结表中',
	'interwiki_log_edited' => '在跨维基连结表中修改了连结前缀 "$2" : （$3） （含: $4） （本: $5）',
	'interwiki_log_deleted' => '在跨维基连结表中已删除 "$2"',
	'right-interwiki' => '修改跨维基资料',
	'action-interwiki' => '修正这个跨语言链接',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alexsh
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'interwiki' => '檢視並編輯跨維基連結表',
	'interwiki-title-norights' => '檢視跨維基資料',
	'interwiki-desc' => '新增[[Special:Interwiki|特殊頁面]]以檢視或編輯跨語言連結表',
	'interwiki_intro' => '這是跨維基連結表的概覽。列中的數據的含義：',
	'interwiki_prefix' => '前綴',
	'interwiki-prefix-label' => '前綴:',
	'interwiki_local' => '轉發',
	'interwiki-local-label' => '定義這個為一個本地wiki:',
	'interwiki_trans' => '包含',
	'interwiki-trans-label' => '容許跨維基包含:',
	'interwiki_1' => '是',
	'interwiki_0' => '否',
	'interwiki_error' => '錯誤: 跨維基連結表為空，或是發生其它錯誤。',
	'interwiki_reasonfield' => '原因：',
	'interwiki_delquestion' => '正在刪除"$1"',
	'interwiki_deleting' => '您正在刪除前綴"$1"。',
	'interwiki_deleted' => '已成功地從連結表中刪除前綴"$1"。',
	'interwiki_delfailed' => '無法從連結表刪除前綴"$1"。',
	'interwiki_addtext' => '新增一個跨維基前綴',
	'interwiki_addintro' => '您現在加入一個新的跨維基連結前綴。
要記住它不可以包含空格 （ ）、冒號 （:）、連字號 （&），或者是等號 （=）。',
	'interwiki_addbutton' => '加入',
	'interwiki_added' => '前綴 "$1" 已經成功地加入到跨維基連結表。',
	'interwiki_addfailed' => '前綴 "$1" 不能加入到跨維基連結表。
可能已經在跨維基連結表中存在。',
	'interwiki_edittext' => '修改一個跨維基連結前綴',
	'interwiki_editintro' => '您現正修改跨維基連結前綴。
記住這動作可以中斷現有的連結。',
	'interwiki_edited' => '前綴 "$1" 已經在跨維基連結表中修改。',
	'interwiki_editerror' => '前綴 "$1" 不能在跨維基連結表中修改。
可能它並不存在。',
	'interwiki-badprefix' => '所指定的跨維基前綴 "$1" 含有無效的字母',
	'interwiki_log_added' => '加入了連結前綴 "$2" （$3） （含: $4） （本: $5） 到跨維基連結表中',
	'interwiki_log_edited' => '在跨維基連結表中修改了連結前綴 "$2" : （$3） （含: $4） （本: $5）',
	'interwiki_log_deleted' => '在跨維基連結表中已刪除 "$2"',
	'right-interwiki' => '修改跨維基資料',
);

