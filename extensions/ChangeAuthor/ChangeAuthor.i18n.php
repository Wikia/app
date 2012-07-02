<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright © 2007 Roan Kattouw
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows changing the author of a revision
 * Written for the Bokt Wiki <http://www.bokt.nl/wiki/> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 */

$messages = array();

/** English
 * @author Roan Kattouw
 */
$messages['en'] = array(
	'changeauthor' => 'Change revision author',
	'changeauthor-desc' => "Allows changing a revision's author",
	'changeauthor-title' => 'Change the author of a revision',
	'changeauthor-search-box' => 'Search revisions',
	'changeauthor-pagename-or-revid' => 'Page name or revision ID:',
	'changeauthor-pagenameform-go' => 'Go',
	'changeauthor-comment' => 'Comment:',
	'changeauthor-changeauthors-multi' => 'Change {{PLURAL:$1|author|authors}}',
	'changeauthor-explanation-multi' => 'With this form you can change revision authors.
Simply change one or more usernames in the list below, add a comment (optional) and click the "Change author(s)" button.',
	'changeauthor-changeauthors-single' => 'Change author',
	'changeauthor-explanation-single' => 'With this form you can change a revision author.
Simply change the username below, add a comment (optional) and click the "Change author" button.',
	'changeauthor-invalid-username' => 'Invalid username "$1".',
	'changeauthor-nosuchuser' => 'No such user "$1".',
	'changeauthor-revview' => 'Revision #$1 of $2',
	'changeauthor-nosuchtitle' => 'There is no page called "$1".',
	'changeauthor-weirderror' => 'A very strange error occurred.
Please retry your request.
If this error keeps showing up, the database is probably broken.',
	'changeauthor-invalidform' => 'Please use the form provided by the [[Special:ChangeAuthor|special page]] rather than a custom form.',
	'changeauthor-success' => 'Your request has been processed successfully.',
	'changeauthor-logentry' => 'Changed author of $2 of $1 from $3 to $4',
	'changeauthor-logpagename' => 'Author change log',
	'changeauthor-logpagetext' => '',
	'changeauthor-rev' => 'r$1',
	'right-changeauthor' => 'Change the author of a revision',
);

/** Message documentation (Message documentation)
 * @author Aotake
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Meno25
 * @author Purodha
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'changeauthor' => 'Name of the special page on [[Special:SpecialPages]]',
	'changeauthor-desc' => '{{desc}}',
	'changeauthor-title' => 'Title of the [[Special:ChangeAuthor]] special page',
	'changeauthor-search-box' => 'Caption of the fieldset on the revision search form',
	'changeauthor-pagename-or-revid' => 'Caption of the input box on the revision search form',
	'changeauthor-pagenameform-go' => 'Caption of the submit button on the revision search form

{{Identical|Go}}',
	'changeauthor-comment' => 'Caption of the comment input box on the main form

{{Identical|Comment}}',
	'changeauthor-changeauthors-multi' => 'Caption of the submit button on the main form (for multiple revisions)',
	'changeauthor-explanation-multi' => 'Text above the comment box on the main form (for multiple revisions)',
	'changeauthor-changeauthors-single' => 'Caption of the submit button on the main form (for one revision)',
	'changeauthor-explanation-single' => 'Text above the comment box on the main form (for one revision)',
	'changeauthor-invalid-username' => 'Error message. $1 is the username that was entered.',
	'changeauthor-nosuchuser' => 'Error message. $1 is the username that was entered.',
	'changeauthor-revview' => 'Displayed instead of the page title if a revision ID was entered',
	'changeauthor-nosuchtitle' => 'Error message. $1 is the page title that was entered.',
	'changeauthor-weirderror' => 'Error message displayed only when very weird things happen.',
	'changeauthor-invalidform' => "Error message displayed when expected form values aren't found.",
	'changeauthor-success' => 'Displayed after a successful change.',
	'changeauthor-logentry' => 'The log message for author changes. $1 is the page title, $2 includes {{msg-mw|changeauthor-rev}} in the site language, $3 the old author and $4 the new one',
	'changeauthor-logpagename' => 'Displayed on top of Special:Log/changeauth and in the list of available logs.',
	'changeauthor-rev' => '{{optional}}',
	'right-changeauthor' => '{{doc-right|changeauthor}}',
);

/** Niuean (ko e vagahau Niuē)
 * @author Jose77
 */
$messages['niu'] = array(
	'changeauthor-pagenameform-go' => 'Fano',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 */
$messages['af'] = array(
	'changeauthor-search-box' => 'Soek hersienings',
	'changeauthor-pagename-or-revid' => 'Bladsynaam of weergawenommer:',
	'changeauthor-pagenameform-go' => 'Laat waai',
	'changeauthor-comment' => 'Opmerking:',
	'changeauthor-changeauthors-multi' => 'Wysig {{PLURAL:$1|outeur|outeurs}}',
	'changeauthor-changeauthors-single' => 'Wysig outeur',
	'changeauthor-invalid-username' => 'Ongeldige gebruikersnaam "$1".',
	'changeauthor-nosuchuser' => 'Geen gebruiker "$1".',
	'changeauthor-revview' => 'Hersiening #$1 van $2',
	'changeauthor-nosuchtitle' => 'Daar is geen bladsy genaamd "$1" nie.',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 * @author MicroBoy
 */
$messages['aln'] = array(
	'changeauthor-title' => 'Ndryshimi autor i një rishikim',
	'changeauthor-search-box' => 'Kërko shqyrtime',
	'changeauthor-pagename-or-revid' => 'Emri i faqes ose rishikim ID:',
	'changeauthor-pagenameform-go' => 'Shkoj',
	'changeauthor-comment' => 'Koment:',
	'changeauthor-changeauthors-multi' => 'Ndryshimi {{PLURAL:$1|autor|autorëve}}',
	'changeauthor-explanation-multi' => 'Me këtë formë mund të ndryshoni autorëve rishikim. Thjesht ndryshojnë një ose më shumë përdoruesve në listën e mëposhtme, të shtoni një koment (optional) dhe kliko "Ndryshimi autorit (s)" button.',
	'changeauthor-changeauthors-single' => 'Autori Ndryshimi',
	'changeauthor-explanation-single' => 'Me këtë formë ju mund të ndryshojë një autor rishikim. Thjesht ndryshuar emrin më poshtë, shtoni një koment (optional) dhe kliko "autori Ndrysho" button.',
	'changeauthor-invalid-username' => 'Invalid username "$1".',
	'changeauthor-nosuchuser' => 'Asnjë përdorues të tillë "$1".',
	'changeauthor-revview' => 'Revision #$1 prej $2',
	'changeauthor-nosuchtitle' => 'Nuk ka asnjë faqe të quajtur "$1".',
	'changeauthor-weirderror' => 'Një gabim shumë e çuditshme ka ndodhur. Ju lutemi të rigjykuar kërkesën tuaj. Nëse ky gabim mban treguar deri, baza e të dhënave është prishur ndoshta.',
	'changeauthor-invalidform' => 'Ju lutem përdorni formularin e dhënë nga [[Special:ChangeAuthor|faqe speciale]] në vend të një forme me porosi.',
	'changeauthor-success' => 'Kërkesa juaj ka qenë i proceduar me sukses.',
	'changeauthor-logentry' => 'Changed autor i $2 e $1 nga $3 deri 4$',
	'changeauthor-logpagename' => 'ndryshim Author log',
	'right-changeauthor' => 'Ndryshimi autor i një rishikim',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'changeauthor-comment' => 'ማጠቃለያ፦',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'changeauthor' => "Cambiar l'autor d'a edición",
	'changeauthor-title' => "Cambiar l'autor d'una edición",
	'changeauthor-search-box' => 'Mirar edicions',
	'changeauthor-pagename-or-revid' => "Nombre d'a pachina u ID d'a versión:",
	'changeauthor-pagenameform-go' => 'Ir-ie',
	'changeauthor-comment' => 'Comentario:',
	'changeauthor-changeauthors-multi' => "Cambiar d'{{PLURAL:$1|autor|autors}}",
	'changeauthor-explanation-multi' => "Con iste formulario puede cambiar os autors d'a edición. Nomás ha de cambiar uno u más nombres d'usuarios en lista que s'amuestra contino, adhibir-ie un comentario (opcional) y punchar en o botón de 'Cambiar autor(s)'",
	'changeauthor-changeauthors-single' => 'Cambiar autor',
	'changeauthor-explanation-single' => "Con iste formulario puede cambiar l'autor una edición. Nomás ha de cambiar o nombre d'usuario que s'amuestra contino, adhibir-ie un comentario (opcional) y punchar en o botón 'Cambiar autor'.",
	'changeauthor-invalid-username' => 'Nombre d\'usuario "$1" no conforme.',
	'changeauthor-nosuchuser' => 'No existe l\'usuario "$1"',
	'changeauthor-revview' => 'Edición #$1 de $2',
	'changeauthor-nosuchtitle' => 'No bi ha garra pachina tetulata "$1".',
	'changeauthor-weirderror' => 'Ha escaicito una error a saber que estrania. Por favor, torne a fer a demanda. Si ista error contina amaneixendo, talment a base de datos sía estricallata.',
	'changeauthor-invalidform' => 'Por favor, faiga servir o formulario furnito en a [[Special:ChangeAuthor|pachina especial]] millor que no atro presonalizato.',
	'changeauthor-success' => "A suya demanda s'ha procesato correutament.",
	'changeauthor-logentry' => "S'ha cambiato l'autor d'a edición $2 de $1 de $3 a $4",
	'changeauthor-logpagename' => "Rechistro de cambeos d'autor",
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'changeauthor' => 'تغيير مؤلف المراجعة',
	'changeauthor-desc' => 'يسمح بتغيير مؤلف مراجعة',
	'changeauthor-title' => 'تغيير مؤلف مراجعة',
	'changeauthor-search-box' => 'بحث في المراجعات',
	'changeauthor-pagename-or-revid' => 'اسم الصفحة أو رقم المراجعة:',
	'changeauthor-pagenameform-go' => 'اذهب',
	'changeauthor-comment' => 'تعليق:',
	'changeauthor-changeauthors-multi' => 'تغيير {{PLURAL:$1|المؤلف|المؤلفين}}',
	'changeauthor-explanation-multi' => "باستخدام هذه الاستمارة يمكنك تغيير مؤلفي المراجعات.
ببساطة غير واحدا أو أكثر من أسماء المستخدمين في القائمة بالأسفل ، أضف تعليقا (اختياري) واضغط على زر 'تغيير المؤلف(ين)'.",
	'changeauthor-changeauthors-single' => 'تغيير المؤلف',
	'changeauthor-explanation-single' => "باستخدام هذه الاستمارة يمكنك تغيير مؤلف مراجعة.
ببساطة غير اسم اسم المستخدم بالأسفل، أضف تعليقا (اختياري) واضغط على زر 'تغيير المؤلف'.",
	'changeauthor-invalid-username' => 'اسم مستخدم غير صحيح "$1".',
	'changeauthor-nosuchuser' => 'لا يوجد مستخدم بالاسم "$1".',
	'changeauthor-revview' => 'المراجعة #$1 من $2',
	'changeauthor-nosuchtitle' => 'لا توجد صفحة بالاسم "$1".',
	'changeauthor-weirderror' => 'حدث خطأ غريب جدا.
من فضلك حاول القيام بطلبك مرة ثانية.
لو استمر هذا الخطأ، إذا فقاعدة البيانات على الأرجح مكسورة.',
	'changeauthor-invalidform' => 'من فضلك استخدم الاستمارة الموفرة بواسطة [[Special:ChangeAuthor|الصفحة الخاصة]] بدلا من استمارة معدلة.',
	'changeauthor-success' => 'طلبك تمت معالجته بنجاح.',
	'changeauthor-logentry' => 'غير مؤلف $2 ل$1 من $3 إلى $4',
	'changeauthor-logpagename' => 'سجل تغيير المؤلفين',
	'changeauthor-rev' => 'ن$1',
	'right-changeauthor' => 'تغيير مؤلف مراجعة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'changeauthor-pagename-or-revid' => 'ܫܡܐ ܕܦܐܬܐ ܐܘ ܗܝܝܘܬܐ ܕܬܢܝܬܐ:',
	'changeauthor-pagenameform-go' => 'ܙܠ',
	'changeauthor-changeauthors-multi' => 'ܫܚܠܦ {{PLURAL:$1|ܣܝܘܡܐ|ܣܝܘܡ̈ܐ}}',
	'changeauthor-changeauthors-single' => 'ܫܚܠܦ ܣܝܘܡܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 */
$messages['arz'] = array(
	'changeauthor' => 'تغيير مؤلف المراجعة',
	'changeauthor-desc' => 'يسمح بتغيير مؤلف مراجعة',
	'changeauthor-title' => 'تغيير مؤلف مراجعة',
	'changeauthor-search-box' => 'بحث فى المراجعات',
	'changeauthor-pagename-or-revid' => 'اسم الصفحة أو رقم المراجعة:',
	'changeauthor-pagenameform-go' => 'اذهب',
	'changeauthor-comment' => 'تعليق:',
	'changeauthor-changeauthors-multi' => 'تغيير {{PLURAL:$1|المؤلف|المؤلفين}}',
	'changeauthor-explanation-multi' => "باستخدام هذه الاستمارة يمكنك تغيير مؤلفى المراجعات.
ببساطة غير واحدا أو أكثر من أسماء المستخدمين فى القائمة بالأسفل ، أضف تعليقا (اختياري) واضغط على زر 'تغيير المؤلف(ين)'.",
	'changeauthor-changeauthors-single' => 'تغيير المؤلف',
	'changeauthor-explanation-single' => "باستخدام الاستمارة دى ممكن تغير مؤلف مراجعة.
ببساطة غير اسم اليوزر تحت، ضيف تعليق (اختيارى) واضغط على زر 'تغيير المؤلف'.",
	'changeauthor-invalid-username' => 'اسم يوزر مش صحيح "$1".',
	'changeauthor-nosuchuser' => 'مافيش يوزر بالاسم "$1".',
	'changeauthor-revview' => 'المراجعة #$1 من $2',
	'changeauthor-nosuchtitle' => 'لا توجد صفحة بالاسم "$1".',
	'changeauthor-weirderror' => 'حدث خطأ غريب جدا.
من فضلك حاول القيام بطلبك مرة ثانية.
لو استمر هذا الخطأ، إذا فقاعدة البيانات على الأرجح مكسورة.',
	'changeauthor-invalidform' => 'من فضلك استخدم الاستمارة الموفرة بواسطة [[Special:ChangeAuthor|الصفحة الخاصة]] بدلا من استمارة معدلة.',
	'changeauthor-success' => 'طلبك تمت معالجته بنجاح.',
	'changeauthor-logentry' => 'غير مؤلف $2 ل$1 من $3 إلى $4',
	'changeauthor-logpagename' => 'سجل تغيير المؤلفين',
	'changeauthor-rev' => 'ن$1',
	'right-changeauthor' => 'غير مؤلف مراجعة',
);

/** Azerbaijani (Azərbaycanca)
 * @author Vago
 */
$messages['az'] = array(
	'changeauthor-pagenameform-go' => 'Keç',
	'changeauthor-comment' => 'Şərh:',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'changeauthor' => 'Өлгөнөң авторын үҙгәртеү',
	'changeauthor-desc' => 'Өлгөнөң авторын үҙгәртеү мөмкинлеген бирә',
	'changeauthor-title' => 'Өлгөнөң авторын үҙгәртеү',
	'changeauthor-search-box' => 'Өлгөләрҙе эҙләү',
	'changeauthor-pagename-or-revid' => 'Мәҡәләнең исеме йәки өлгөнөң идентификаторы:',
	'changeauthor-pagenameform-go' => 'Үтәргә',
	'changeauthor-comment' => 'Иҫкәрмә:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Авторҙы|Авторҙарҙы}} үҙгәртергә',
	'changeauthor-explanation-multi' => 'Был форма ярҙамында һеҙ өлгөләрҙең авторҙарын үҙәртә алаһығыҙ.
Түбәндәге исемлектә бер йәки бер нисә ҡатнашыусы исемен үҙгәртегеҙ, иҫкәрмә өҫтәгеҙ (мотлаҡ түгел) һәм "Авторҙы(ҙарҙы) үҙгәртергә" төймәһенә баҫығыҙ.',
	'changeauthor-changeauthors-single' => 'Авторҙы үҙгәртергә',
	'changeauthor-explanation-single' => 'Был форма ярҙамында һеҙ өлгөнөң авторын үҙәртә алаһығыҙ.
Түбәндә ҡатнашыусы исемен үҙгәртегеҙ, иҫкәрмә өҫтәгеҙ (мотлаҡ түгел) һәм "Авторҙы үҙгәртергә" төймәһенә баҫығыҙ.',
	'changeauthor-invalid-username' => '"$1" ҡатнашыусы исеме дөрөҫ түгел.',
	'changeauthor-nosuchuser' => '"$1" исемле ҡатнашыусы юҡ.',
	'changeauthor-revview' => '$2 өлгөнән №$1 өлгөһө',
	'changeauthor-nosuchtitle' => '"$1" исемле бит юҡ.',
	'changeauthor-weirderror' => 'Бик сәйер хата килеп сыҡты.
Зинһар, яңынан ҡабалтағыҙ.
Әгәр хата тағы килеп сыҡһа, мәғлүмәттәр базаһы боҙолған булыуы мөмкин.',
	'changeauthor-invalidform' => 'Зинһар, башҡа форманы түгел, [[Special:ChangeAuthor|махсус биттәге]] форманы ҡулланығыҙ.',
	'changeauthor-success' => 'Һеҙҙең һорауығыҙ уңышлы башҡарылды.',
	'changeauthor-logentry' => '$1 битенең $2 өлгөһөнөң авторын үҙгәрткән. Элекке авторы: $3,  яңы авторы: $4',
	'changeauthor-logpagename' => 'Автор үҙгәртеү яҙмалары журналы',
	'right-changeauthor' => 'Өлгөнөң авторын үҙгәртеү',
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'changeauthor' => 'Autor vu ana Veasion ändan',
	'changeauthor-desc' => "Ealaubt s'Ändan vum Autor vu ana Version",
	'changeauthor-title' => 'Autor vu ana Veasion ändan',
	'changeauthor-search-box' => 'Veasion suacha',
	'changeauthor-pagename-or-revid' => 'Seitnnãm oda Veasionsnumma:',
	'changeauthor-pagenameform-go' => 'Suach',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => "{{PLURAL:$1|In Autor|D'Autoan}} ändan",
	'changeauthor-explanation-multi' => "Mit dem Formular kãnnst d'Autoan vu da Veasion ändan. Ända oafåch an oda mearare Autornnãmen in da Listn, eagänz an Kommentar (opzional) und klick auf d'„Autor ändan“-Schåitflächn.",
	'changeauthor-changeauthors-single' => 'Autor ändan',
	'changeauthor-explanation-single' => "Mit dem Formular kãnnst in Autoa vu da Veasion ändan. Ända oafåch in Autornnãmen in da Listn, eagänz an Kommentar (opzional) und klick auf d'„Autor ändan“-Schåitflächn.",
	'changeauthor-invalid-username' => 'Ungüitiga Benutzanãm „$1“.',
	'changeauthor-nosuchuser' => 'Es gibt kan Benutza „$1“ ned.',
	'changeauthor-revview' => 'Veasion #$1 vu $2',
	'changeauthor-nosuchtitle' => 'Es gibt ka Seitn „$1“ ned.',
	'changeauthor-weirderror' => "Då is iatst a söitsãma Fehla passiad. Sei so guad und probia's nu amåi. Wãnn's nu amåi zu dem Fehla kimmd, håd de Datnbank wåascheinli a grebas Problem.",
	'changeauthor-invalidform' => "Sei so guad und nimm s'Foamular auf da [[Special:ChangeAuthor|Spezialseitn]].",
	'changeauthor-success' => 'Dei Ändarung is eafoigreich duachgfüahd woan.',
	'changeauthor-logentry' => 'håd in Autoannãmen vu $2 vu $1 vu $3 auf $4 gändat',
	'changeauthor-logpagename' => 'Autoanändarungs-Logbiachl',
	'right-changeauthor' => 'In Autoan vu ana Veasion ändan',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'changeauthor' => 'Зьмена аўтарства вэрсіі',
	'changeauthor-desc' => 'Дазваляе зьмяняць аўтарства вэрсіі',
	'changeauthor-title' => 'Зьмена аўтарства вэрсіі',
	'changeauthor-search-box' => 'Пошук вэрсіяў',
	'changeauthor-pagename-or-revid' => 'Назва старонкі альбо ідэнтыфікатар вэрсіі:',
	'changeauthor-pagenameform-go' => 'Далей',
	'changeauthor-comment' => 'Камэнтар:',
	'changeauthor-changeauthors-multi' => 'Зьмена {{PLURAL:$1|аўтара|аўтараў}}',
	'changeauthor-explanation-multi' => 'З дапамогай гэтай формы Вы можаце зьмяніць аўтара вэрсіі рэдагаваньняў.
Проста зьмяніце ніжэй адно ці некалькі імёнаў удзельнікаў, дадайце камэнтар (неабавязковы) і націсьніце кнопку «Зьмяніць аўтара(аў)».',
	'changeauthor-changeauthors-single' => 'Зьмена аўтара',
	'changeauthor-explanation-single' => 'З дапамогай гэтай формы можна зьмяніць аўтарства рэдагаваньня. Проста зьмяніце ніжэй імя ўдзельніка, дадайце камэнтар (неабавязковы) і націсьніце кнопку «Зьмяніць аўтара».',
	'changeauthor-invalid-username' => 'Няслушнае імя ўдзельніка «$1».',
	'changeauthor-nosuchuser' => 'Няма такога ўдзельніка «$1».',
	'changeauthor-revview' => 'Вэрсія #$1 з $2',
	'changeauthor-nosuchtitle' => 'Няма старонкі з назвай «$1».',
	'changeauthor-weirderror' => 'Адбылася дзіўная памылка.
Калі ласка, паўтарыце Ваш запыт.
Калі памылка зноў узьнікне, гэта азначае, што база зьвестак пашкоджана.',
	'changeauthor-invalidform' => 'Калі ласка, выкарыстоўвайце форму на [[Special:ChangeAuthor|спэцыяльнай старонцы]], а не якую-небудзь іншую.',
	'changeauthor-success' => 'Ваш запыт быў пасьпяхова выкананы.',
	'changeauthor-logentry' => 'зьмененае аўтарства $2 $1 з $3 на $4',
	'changeauthor-logpagename' => 'Журнал зьменаў аўтарства',
	'right-changeauthor' => 'зьмена аўтарства вэрсіі',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 */
$messages['bg'] = array(
	'changeauthor' => 'Промяна на автора на редакция',
	'changeauthor-desc' => 'Позволява промяна на автора на редакцията',
	'changeauthor-title' => 'Промяна на автора на редакция',
	'changeauthor-search-box' => 'Търсене на редакция',
	'changeauthor-pagename-or-revid' => 'Име на страница или номер на редакция:',
	'changeauthor-pagenameform-go' => 'Отваряне',
	'changeauthor-comment' => 'Коментар:',
	'changeauthor-changeauthors-multi' => 'Промяна на {{PLURAL:$1|автора|авторите}}',
	'changeauthor-explanation-multi' => "Формулярът по-долу служи за промяна на авторите на отделни редакции. Необходимо е да се промени едно или повече потребителско име от списъка по-долу, да се въведе коментар (незадължително) и натисне бутона 'Промяна на автор(ите)'.",
	'changeauthor-changeauthors-single' => 'Промяна на автора',
	'changeauthor-explanation-single' => "Формулярът по-долу се използва за промяна на автора на редакция. Необходимо е да се промени потребителското име, да се въведе коментар (незадължително) и да се натисне бутона 'Промяна на автор(ите)'.",
	'changeauthor-invalid-username' => 'Невалидно потребителско име "$1".',
	'changeauthor-nosuchuser' => 'Не съществува потребител "$1".',
	'changeauthor-revview' => 'Редакция #$1 от $2',
	'changeauthor-nosuchtitle' => 'Не съществува страница "$1".',
	'changeauthor-weirderror' => 'Възникна странна грешка. Опитайте отново; ако грешката се повтори, вероятно базата данни е повредена.',
	'changeauthor-invalidform' => 'Необходимо е използването на формуляра от [[Special:ChangeAuthor|специалната страница]].',
	'changeauthor-success' => 'Заявката беше изпълнена успешно.',
	'changeauthor-rev' => 'р$1',
);

/** Bengali (বাংলা)
 * @author Zaheen
 */
$messages['bn'] = array(
	'changeauthor' => 'সংশোধন লেখক পরিবর্তন',
	'changeauthor-desc' => 'কোন সংশোধনের লেখক পরিবর্তন করার সুযোগ দেয়',
	'changeauthor-title' => 'কোন সংশোধনের লেখক পরিবর্তন করুন',
	'changeauthor-search-box' => 'সংশোধনগুলিতে অনুসন্ধান',
	'changeauthor-pagename-or-revid' => 'পাতার নাম বা সংশোধন আইডি:',
	'changeauthor-pagenameform-go' => 'চলো',
	'changeauthor-comment' => 'মন্তব্য:',
	'changeauthor-changeauthors-multi' => 'লেখক(দের) পরিবর্তন করুন',
	'changeauthor-explanation-multi' => "এই ফর্মটির সাহায্যে আপনি সংশোধনের লেখকদের পরিবর্তন করতে পারবেন। নিচের তালিকার এক বা একাধিক ব্যবহারকারী নাম পরিবর্তন করুন, একটি মন্তব্য যোগ করুন (ঐচ্ছিক) এবং 'লেখক(গণ) পরিবর্তন করা হোক' বোতামটিতে ক্লিক করুন।",
	'changeauthor-changeauthors-single' => 'লেখক পরিবর্তন',
	'changeauthor-explanation-single' => "এই ফর্মটির সাহায্যে আপনি একটি সংশোধনের লেখক পরিবর্তন করতে পারবেন। নিচের ব্যবহারকারী নামটি পরিবর্তন করুন, একটি মন্তব্য যোগ করুন (ঐচ্ছিক) এবং 'লেখক পরিবর্তন করা হোক' বোতামটিতে ক্লিক করুন।",
	'changeauthor-invalid-username' => '"$1" ব্যবহারকারী নামটি অবৈধ।',
	'changeauthor-nosuchuser' => '"$1" নামে কোন ব্যবহারকারী নেই।',
	'changeauthor-revview' => '$2-এর সংশোধন নং $1',
	'changeauthor-nosuchtitle' => '"$1" শিরোনামের কোন পাতা নেই।',
	'changeauthor-weirderror' => 'একটি খুবই অদ্ভুত ত্রুটি ঘটেছে। দয়া করে আপনার অনুরোধটি দিয়ে আবার চেষ্টে করুন। এই ত্রুটিটি যদি বারবার দেখাতে থাকে, তবে সম্ভবত ডাটাবেজ কাজ করছে না।',
	'changeauthor-invalidform' => 'কাস্টম ফর্মের পরিবর্তে অনুগ্রহ করে Special:ChangeAuthor-এর দেয়া ফর্মটি ব্যবহার করুন।',
	'changeauthor-success' => 'আপনার অনুরোধটি সফলভাবে প্রক্রিয়া করা হয়েছে।',
	'changeauthor-logentry' => '$3 থেকে $1-এর $2-এর লেখক পরিবর্তন করে $4 করা হয়েছে',
	'changeauthor-logpagename' => 'লেখক পরিবর্তন লগ',
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'changeauthor' => 'Kemmañ aozer an adweladennoù',
	'changeauthor-desc' => "Aotren a ra cheñch anv aozer ur c'hemm pe kemmoù",
	'changeauthor-title' => 'Kemmañ aozer un adweladenn',
	'changeauthor-search-box' => 'Klask adweladennoù',
	'changeauthor-pagename-or-revid' => 'Anv ar bajenn pe niverenn an adweladenn :',
	'changeauthor-pagenameform-go' => 'Mont',
	'changeauthor-comment' => 'Notenn :',
	'changeauthor-changeauthors-multi' => 'Kemmañ {{PLURAL:$1|an aozer|an aozerien}}',
	'changeauthor-explanation-multi' => 'Gant ar furmskrid-mañ e c\'hallit cheñch aozerien un adweladenn.
Trawalc\'h eo cheñch un anv pe meur a hini er roll amañ dindan, merkañ un evezhiadenn (diret) ha klikañ war ar bouton "Cheñch an aozer(ien)".',
	'changeauthor-changeauthors-single' => 'Cheñch aozer',
	'changeauthor-explanation-single' => 'Gant ar furmskrid-mañ e c\'hallit cheñch aozer un adweladenn.
Trawalc\'h eo cheñch an anv amañ dindan, merkañ un evezhiadenn (diret) ha klikañ war ar bouton "Cheñch an aozer".',
	'changeauthor-invalid-username' => 'Anv implijer "$1" fall.',
	'changeauthor-nosuchuser' => 'Implijer "$1" ebet.',
	'changeauthor-revview' => 'Adweladenn #$1 eus $2',
	'changeauthor-nosuchtitle' => 'N\'eus pajenn ebet anvet "$1".',
	'changeauthor-weirderror' => "Ur fazi souezhus-tre zo c'hoarvezet.
Adkasit ho reked mar plij.
Ma talc'h ar fazi-se da c'hoarvezout e talvez eo torret an diaz roadennoù, sur a-walc'h.",
	'changeauthor-invalidform' => "Grit gant ar furmskrid pourchaset gant ar [[Special:ChangeAuthor|bajenn dibar]], kentoc'h eget gant ur furmskrid personelaet",
	'changeauthor-success' => 'Kaset eo bet ho reked da benn vat.',
	'changeauthor-logentry' => 'Kemmoù an aozer $2 da $1 eus $3 davet $4',
	'changeauthor-logpagename' => "Marilh ar c'hemmoù graet gant an aozer",
	'right-changeauthor' => 'Kemmañ aozer un adweladenn',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'changeauthor' => 'Promjena autora revizije',
	'changeauthor-desc' => 'Omogućuje promjenu autora revizije',
	'changeauthor-title' => 'Promjena autora revizije',
	'changeauthor-search-box' => 'Traži revizije',
	'changeauthor-pagename-or-revid' => 'Naziv stranice ili ID revizije:',
	'changeauthor-pagenameform-go' => 'Idi',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => 'Promijeni {{PLURAL:$1|autora|autore}}',
	'changeauthor-explanation-multi' => "Sa ovim obrascem možete promijeniti autora revizije.
Jednostavno promijenite jedno ili više korisničkih imena na spisku ispod, dodajte komentar (neobavezno) i kliknite na dugme 'Promijeni autora(e)'.",
	'changeauthor-changeauthors-single' => 'Promijeni autora',
	'changeauthor-explanation-single' => "S ovim obrascem možete promijeniti autora revizije.
Jednostavno promijenite korisničko ime ispod, dodajte komentar (neobavezno) i kliknite na dugme 'Promijeni autora'.",
	'changeauthor-invalid-username' => 'Nevaljano korisničko ime "$1".',
	'changeauthor-nosuchuser' => 'Nema takvog korisnika "$1".',
	'changeauthor-revview' => 'Revizija #$1 od $2',
	'changeauthor-nosuchtitle' => 'Nema stranice s nazivom "$1".',
	'changeauthor-weirderror' => 'Desila se nepredviđena greška.
Molimo ponovite Vaš upit.
Ako se ova greška nastavi ponavljati, vjerovatno je baza podataka u kvaru.',
	'changeauthor-invalidform' => 'Molimo koristite obrazac koji je postavljen na [[Special:ChangeAuthor|posebnoj stranici]] a ne ručno postavljeni.',
	'changeauthor-success' => 'Vaš zahtjev je uspješno obrađen.',
	'changeauthor-logentry' => 'Promijenjen autor revizije $2 stranice $1 sa $3 na $4',
	'changeauthor-logpagename' => 'Zapisnik promjene autora',
	'right-changeauthor' => 'Promjena autora revizije',
);

/** Catalan (Català)
 * @author Aleator
 * @author Jordi Roqué
 * @author SMP
 * @author Ssola
 */
$messages['ca'] = array(
	'changeauthor' => 'Canviar autor de revisions',
	'changeauthor-desc' => "Permet canviar l'autor d'una revisió",
	'changeauthor-title' => "Canviar l'autor d'una revisió",
	'changeauthor-search-box' => 'Cercar revisions',
	'changeauthor-pagename-or-revid' => 'Nom de la pàgina o referència de la revisió:',
	'changeauthor-pagenameform-go' => 'Vés-hi',
	'changeauthor-comment' => 'Comentari:',
	'changeauthor-changeauthors-multi' => "Canvi d'{{PLURAL:$1|autor|autors}}",
	'changeauthor-explanation-multi' => "Amb aquest formulari es poden canviar autors de revisions.<br />
Només cal que canvieu un o més noms d'usuaris de la llista, afegiu un comentari (opcional) i pitgeu el botó 'Canvi d'autor(s)'.",
	'changeauthor-changeauthors-single' => "Canvi d'autor",
	'changeauthor-explanation-single' => "Amb aquest formulari podeu canviar l'autor d'una revisió.<br />
Només cal que canvieu el nom de l'usuari, afegiu un comentari (opcional) i pitgeu el botó 'Canvi d'autor'.",
	'changeauthor-invalid-username' => 'Nom d\'usuari "$1" invàlid.',
	'changeauthor-nosuchuser' => 'L\'usuari "$1" no existeix.',
	'changeauthor-revview' => 'Revisió número $1 de $2',
	'changeauthor-nosuchtitle' => 'No hi ha cap pàgina anomenada "$1".',
	'changeauthor-weirderror' => "Ha ocorregut un error poc comú.
Si us plau, intenteu-ho de nou.
Si l'error persisteix, és probable que la base de dades estigui avariada.",
	'changeauthor-invalidform' => 'Useu el formulari de la [[Special:ChangeAuthor|pàgina especial]] adient.',
	'changeauthor-success' => 'La vostra petició ha estat processada satisfactòriament.',
	'changeauthor-logentry' => "S'ha canviat l'autor, de $3 a $4, per a $2 de $1",
	'changeauthor-logpagename' => "Registre de canvis d'autor",
	'right-changeauthor' => "Canviar l'autoria d'una modificació",
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'changeauthor-search-box' => 'Нисдинарш лахар',
);

/** Chamorro (Chamoru)
 * @author Jatrobat
 */
$messages['ch'] = array(
	'changeauthor-pagenameform-go' => 'Hånao',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'changeauthor-pagenameform-go' => 'بڕۆ',
);

/** Czech (Česky)
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Reaperman
 */
$messages['cs'] = array(
	'changeauthor' => 'Změnit autora revize',
	'changeauthor-desc' => 'Umožňuje změnit autora revize',
	'changeauthor-title' => 'Změnit autora revize',
	'changeauthor-search-box' => 'Hledat revize',
	'changeauthor-pagename-or-revid' => 'Název stránky nebo ID revize:',
	'changeauthor-pagenameform-go' => 'Vykonat',
	'changeauthor-comment' => 'Komentář:',
	'changeauthor-changeauthors-multi' => 'Změnit {{plural:$1|autora|autory}}',
	'changeauthor-explanation-multi' => 'Pomocí tohoto formuláře můžete změnit autora revize stránky. Jednoduše změňte jedno nebo více uživatelských jmen v seznamu níže, přidejte komentář (nepovinné) a klikněte na tlačítko „Změnit autora“.',
	'changeauthor-changeauthors-single' => 'Změnit autora',
	'changeauthor-explanation-single' => 'Pomocí tohoto formuláře můžete změnit autora revize stránky. Jednoduše změňte jméno uživatele v seznamu níže, přidejte komentář (nepovinné) a klikněte na tlačítko „Změnit autora“.',
	'changeauthor-invalid-username' => 'Neplatné uživatelské jméno: „$1“.',
	'changeauthor-nosuchuser' => 'Uživatel „$1“ neexistuje.',
	'changeauthor-revview' => 'Revize #$1 {{PLURAL:$2|z|ze|z}} $2',
	'changeauthor-nosuchtitle' => 'Stránka s názvem „$1“ neexistuje.',
	'changeauthor-weirderror' => 'Vyskytla se velmi zvláštní chyba. Prosím, opakujte váš požadavek. Pokud se tato chyba bude vyskytovat i nadále, databáze je poškozená.',
	'changeauthor-invalidform' => 'Prosím, použijte formulář na [[Special:ChangeAuthor|speciální stránce]] spíše než vlastní formulář.',
	'changeauthor-success' => 'Vaše požadavky byly úspěšně zpracovány.',
	'changeauthor-logentry' => 'Autor $2 z $1 byl změněn z $3 na $4',
	'changeauthor-logpagename' => 'Záznam změn autorů',
	'right-changeauthor' => 'Měnit autora revize',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'changeauthor-pagenameform-go' => 'прѣиди́',
);

/** Danish (Dansk)
 * @author Sarrus
 */
$messages['da'] = array(
	'changeauthor' => 'Skift versionens forfatter',
	'changeauthor-desc' => 'Tillader ændringer af en versions forfatter',
	'changeauthor-title' => 'Skift en versions forfatter',
	'changeauthor-search-box' => 'Søg versioner',
	'changeauthor-pagename-or-revid' => 'Sidenavnets eller versionens ID:',
	'changeauthor-pagenameform-go' => 'Gå',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => 'Skift {{PLURAL:$1| Forfatter |forfattere}}',
	'changeauthor-explanation-multi' => 'Med denne formular kan du ændre en versions forfatter.
Du skal blot ændre et eller flere brugernavne i oversigten herunder, evt. skrive en begrundelse og derefter klikke på "Skift forfatter(e)"-knappen.',
	'changeauthor-changeauthors-single' => 'Skift forfatter',
);

/** German (Deutsch)
 * @author Als-Holder
 * @author DaSch
 * @author Imre
 * @author Raimond Spekking
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'changeauthor' => 'Autor einer Version ändern',
	'changeauthor-desc' => 'Erlaubt es den Autor einer Version zu ändern',
	'changeauthor-title' => 'Autor einer Version ändern',
	'changeauthor-search-box' => 'Version suchen',
	'changeauthor-pagename-or-revid' => 'Seitenname oder Versionsnummer:',
	'changeauthor-pagenameform-go' => 'Suche',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => 'Ändere {{PLURAL:$1|Autor|Autoren}}',
	'changeauthor-explanation-multi' => 'Mit diesem Formular kannst du die Autoren der Versionen ändern. Ändere einfach einen oder mehrerer Autorenname in der Liste, ergänze einen Kommentar (optional) und klicke auf die „Autor ändern“-Schaltfläche.',
	'changeauthor-changeauthors-single' => 'Autor ändern',
	'changeauthor-explanation-single' => 'Mit diesem Formular kannst du den Autoren einer Version ändern. Ändere einfach den Autorenname in der Liste, ergänze einen Kommentar (optional) und klicke auf die „Autor ändern“-Schaltfläche.',
	'changeauthor-invalid-username' => 'Ungültiger Benutzername „$1“.',
	'changeauthor-nosuchuser' => 'Es gibt keinen Benutzer „$1“.',
	'changeauthor-revview' => 'Version $1 von $2',
	'changeauthor-nosuchtitle' => 'Es gibt keine Seite „$1“.',
	'changeauthor-weirderror' => 'Ein sehr seltener Fehler ist aufgetreten. Bitte wiederhole deine Änderung. Wenn dieser Fehler erneut auftritt, ist vermutlich die Datenbank fehlerhaft.',
	'changeauthor-invalidform' => 'Bitte benutze das Formular auf der [[Special:ChangeAuthor|Spezialseite]].',
	'changeauthor-success' => 'Deine Änderung wurde erfolgreich durchgeführt.',
	'changeauthor-logentry' => 'änderte Autorenname der $2 von $1 von $3 auf $4',
	'changeauthor-logpagename' => 'Autorenänderungs-Logbuch',
	'changeauthor-rev' => 'Version $1',
	'right-changeauthor' => 'Autor einer Version ändern',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Imre
 */
$messages['de-formal'] = array(
	'changeauthor-explanation-multi' => 'Mit diesem Formular können Sie die Autoren der Versionen ändern. Ändern Sie einfach einen oder mehrere Autorennamen in der Liste, ergänzen Sie einen Kommentar (optional) und klicken Sie auf die „Autor ändern“-Schaltfläche.',
	'changeauthor-explanation-single' => 'Mit diesem Formular können Sie den Autoren einer Version ändern. Ändern Sie einfach den Autorennamen in der Liste, ergänzen Sie einen Kommentar (optional) und klicken Sie auf die „Autor ändern“-Schaltfläche.',
	'changeauthor-weirderror' => 'Ein sehr seltener Fehler ist aufgetreten. Bitte wiederholen Sie Ihre Änderung. Wenn dieser Fehler erneut auftritt, ist vermutlich die Datenbank fehlerhaft.',
	'changeauthor-invalidform' => 'Bitte benutzen Sie das Formular auf der [[Special:ChangeAuthor|Spezialseite]].',
	'changeauthor-success' => 'Ihre Änderung wurde erfolgreich durchgeführt.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'changeauthor' => 'Awtora wersije změniś',
	'changeauthor-desc' => 'Dowólujo změnjenje awtora wersije',
	'changeauthor-title' => 'Awtora wersije změniś',
	'changeauthor-search-box' => 'Wersije pytaś',
	'changeauthor-pagename-or-revid' => 'Mě boka abo ID wersije:',
	'changeauthor-pagenameform-go' => 'Pytaś',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Awtora|Awtorowu|Awtorow|Awtorow}} změniś',
	'changeauthor-explanation-multi' => 'Z toś tym formularom móžoš awtorow wersijow změniś.
Změń jadnorje jadno wužywarske mě abo někotare wužywarske mjenja ze slědujuceje lisćiny, pśidaj komentar (opcionalny) a klikni na tłocašk  "Awtorow změniś".',
	'changeauthor-changeauthors-single' => 'Awtora změniś',
	'changeauthor-explanation-single' => 'Z toś tym formularom móžoš awtora wersije změniś.
Změń jadnorje jadno wužywarske mě ze slědujuceje lisćiny, pśidaj komentar (opcionalny) a klikni na tłocašk "Awtora změniś".',
	'changeauthor-invalid-username' => 'Njepłaśiwe wužywarske mě "$1".',
	'changeauthor-nosuchuser' => 'Njejo wužywaŕ "$1".',
	'changeauthor-revview' => 'Wersija #$1 z $2',
	'changeauthor-nosuchtitle' => 'Njejo bok z mjenim "$1".',
	'changeauthor-weirderror' => 'Wjelgin źiwna zmólka jo wustupiła.
Wóspjetuj pšosym swóju změnu.
Jolic toś ta zmólka dalej wustupujo, jo nejskerjej datowa banka wobškóźona.',
	'changeauthor-invalidform' => 'Wužyj pšosym formular ze [[Special:ChangeAuthor|specialnego boka]] a nic swójski formular.',
	'changeauthor-success' => 'Twójo změnjenje jo se wuspěšnje pśewjadło.',
	'changeauthor-logentry' => 'Awtora za $2 $1 wót $3 do $4 změnjony',
	'changeauthor-logpagename' => 'Protokol změnow awtorow',
	'right-changeauthor' => 'Awtora wersije změniś',
);

/** Ewe (Eʋegbe) */
$messages['ee'] = array(
	'changeauthor-pagenameform-go' => 'Yi',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['el'] = array(
	'changeauthor-search-box' => 'Αναζήτηση αναθεωρήσεων',
	'changeauthor-pagenameform-go' => 'Πηγαίνετε',
	'changeauthor-comment' => 'Σχόλιο:',
	'changeauthor-changeauthors-single' => 'Αλλαγή δημιουργού',
	'changeauthor-invalid-username' => 'Άκυρο όνομα-χρήστη  "$1".',
	'changeauthor-nosuchuser' => 'Κανένας χρήστης ονόματι "$1".',
	'changeauthor-logpagename' => 'Ημερολόγιο αλλαγών ανά χρήστη',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'changeauthor' => 'Ŝanĝu aŭtoron de revizio',
	'changeauthor-desc' => 'Permesas la ŝanĝadon de aŭtoro de revizio',
	'changeauthor-title' => 'Ŝanĝi la aŭtoron de revizio',
	'changeauthor-search-box' => 'Serĉu reviziojn',
	'changeauthor-pagename-or-revid' => 'Paĝnomo aŭ revizia identigo:',
	'changeauthor-pagenameform-go' => 'Ek!',
	'changeauthor-comment' => 'Komento:',
	'changeauthor-changeauthors-multi' => 'Ŝanĝi {{PLURAL:$1|aŭtoron|aŭtorojn}}',
	'changeauthor-explanation-multi' => "Kun ĉi tiu paĝo vi povas ŝanĝi aŭtorojn de revizioj.
Simple ŝanĝu unu aŭ pliajn salutnomojn en la jena listo, aldonu komenton (nedeviga) kaj klaku la butonon 'Ŝanĝi aŭtoro(j)n'.",
	'changeauthor-changeauthors-single' => 'Ŝanĝi aŭtoron',
	'changeauthor-invalid-username' => 'Nevalida salutnomo "$1".',
	'changeauthor-nosuchuser' => 'Neniu uzanto "$1".',
	'changeauthor-revview' => 'Revizio #$1 de $2',
	'changeauthor-nosuchtitle' => 'Estas neniu pagxo titolata "$1".',
	'changeauthor-weirderror' => 'Tre stranga eraro okazis.
Bonvolu reprovi vian peton.
Se ĉi tiu eraro daŭras okazi, tiel la datumbazo verŝajne estas rompita.',
	'changeauthor-success' => 'Via peto estis traktita sukcese.',
	'changeauthor-logentry' => 'Ŝanĝis aŭtoron de $2 de $1 de $3 al $4',
	'changeauthor-logpagename' => 'Protokolo pri ŝanĝoj de aŭtoroj',
	'right-changeauthor' => 'Ŝanĝi la aŭtoro de revizio',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Jatrobat
 */
$messages['es'] = array(
	'changeauthor' => 'Cambiar autor de revisión',
	'changeauthor-desc' => 'Permite el cambio del autor de una revisión',
	'changeauthor-title' => 'Cambiar el autor de una revisión',
	'changeauthor-search-box' => 'Buscar revisiones',
	'changeauthor-pagename-or-revid' => 'Nombre de página o ID de revisión:',
	'changeauthor-pagenameform-go' => 'Ir',
	'changeauthor-comment' => 'Comentario:',
	'changeauthor-changeauthors-multi' => 'Cambie {{PLURAL:$1|autor|autores}}',
	'changeauthor-explanation-multi' => "Con este formulario puedes cambiar los autores de la revisión.
Simplemente cambie uno o más nombres de usuarios en la lista de abajo, agrega un comentario (opcional) y haz click en el botón de 'cambio del autor'.",
	'changeauthor-changeauthors-single' => 'Cambiar autor',
	'changeauthor-explanation-single' => "Con este formulario puedes cambiar un autor de la revisión.
Simplemente cambie el nombre de usuario abajo, agrega un comentario (opcional) y haz click en el botón de 'cambio del autor'.",
	'changeauthor-invalid-username' => 'Nombre de usuario inválido "$1".',
	'changeauthor-nosuchuser' => 'No tal usuario "$1".',
	'changeauthor-revview' => 'Revisión #$1 de $2',
	'changeauthor-nosuchtitle' => 'No hay página llamada "$1".',
	'changeauthor-weirderror' => 'Un error muy extraño ocurrió.
Por favor reintente su solicitud.
Si este error sigue apareciendo, la base de datos está problablemente averiada.',
	'changeauthor-invalidform' => 'Por favor usar el formulario proveído por la [[Special:ChangeAuthor|página especial]] en lugar de un formulario personalizado.',
	'changeauthor-success' => 'Su solicitud ha sido procesada exitosamente.',
	'changeauthor-logentry' => 'Cambiado autor de $2 de $1 de $3 a $4',
	'changeauthor-logpagename' => 'Registro de cambio de autor',
	'right-changeauthor' => 'Cambiar el autor de una revisión',
);

/** Estonian (Eesti)
 * @author Avjoska
 */
$messages['et'] = array(
	'changeauthor' => 'Muuda redigeerimise autorit',
	'changeauthor-desc' => 'Lubab muuta redigeerimise autorit',
	'changeauthor-title' => 'Redigeerimise autori muutmine',
	'changeauthor-search-box' => 'Otsi redigeerimisi',
	'changeauthor-pagename-or-revid' => 'Lehekülg või redigeerimise ID:',
	'changeauthor-pagenameform-go' => 'Mine',
	'changeauthor-comment' => 'Kommentaar:',
	'changeauthor-changeauthors-single' => 'Muuda autorit',
	'changeauthor-invalid-username' => 'Kehtetu kasutajanimi "$1".',
	'changeauthor-nosuchuser' => 'Ei ole sellist kasutajat nagu "$1".',
	'changeauthor-weirderror' => 'Väga veider viga ilmnes.

Palun ürita uuesti.

Kui see viga kordub, on ilmselt viga andmebaasis.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'changeauthor-pagenameform-go' => 'Joan',
	'changeauthor-comment' => 'Iruzkina:',
	'changeauthor-changeauthors-single' => 'Egilea aldatu',
	'changeauthor-nosuchtitle' => 'Ez dago "$1" izenburua duen orrialderik.',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'changeauthor-pagenameform-go' => 'برو',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nike
 * @author Silvonen
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'changeauthor' => 'Muuta muokkausversion tekijä',
	'changeauthor-desc' => 'Mahdollistaa tekijän vaihtamisen sivuhistoriassa jälkikäteen.',
	'changeauthor-title' => 'Muuta muokkausversion tekijä',
	'changeauthor-search-box' => 'Hae muokkausversioita',
	'changeauthor-pagename-or-revid' => 'Sivun nimi tai version tunnus:',
	'changeauthor-pagenameform-go' => 'Siirry',
	'changeauthor-comment' => 'Kommentti',
	'changeauthor-changeauthors-multi' => 'Muuta {{PLURAL:$1|tekijää|tekijöitä}}',
	'changeauthor-explanation-multi' => 'Voit muuttaa tällä lomakkeella version tekijöitä.
Muutat vain yhtä tai useampaa käyttäjänimeä alla olevassa listassa, lisäät kommentin (valinnainen) ja napsautat ”Muuta tekijöitä”-painiketta.',
	'changeauthor-changeauthors-single' => 'Muuta tekijä',
	'changeauthor-explanation-single' => 'Tällä lomakkeella voit muuttaa version tekijän.
Muuta käyttäjätunnus, lisää kommentti (valinnainen) ja napsauta ”Muuta tekijä” -painiketta.',
	'changeauthor-invalid-username' => 'Virheellinen käyttäjätunnus ”$1”.',
	'changeauthor-nosuchuser' => 'Käyttäjää ”$1” ei ole olemassa.',
	'changeauthor-revview' => 'Versio #$1/$2',
	'changeauthor-nosuchtitle' => 'Sivua nimeltä ”$1” ei ole.',
	'changeauthor-weirderror' => 'Tapahtui hyvin outo virhe.
Yritä uudestaan.
Jos tämä virhe toistuu, tietokanta on luultavasti rikki.',
	'changeauthor-invalidform' => 'Käytä [[Special:ChangeAuthor|toimintosivun lomaketta]] oman lomakkeen sijasta.',
	'changeauthor-success' => 'Pyyntö on suoritettu onnistuneesti.',
	'changeauthor-logentry' => 'Muutti sivun $2 version $1 tekijän $3 tekijäksi $4',
	'changeauthor-logpagename' => 'Tekijämuutosloki',
	'changeauthor-rev' => '$1',
	'right-changeauthor' => 'Vaihtaa version tekijätietoa',
);

/** French (Français)
 * @author Dereckson
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'changeauthor' => "Changer l'auteur des révisions",
	'changeauthor-desc' => 'Permet de changer le nom de l’auteur d’une ou plusieurs modifications',
	'changeauthor-title' => "Changer l'auteur d'une révision",
	'changeauthor-search-box' => 'Rechercher des révisions',
	'changeauthor-pagename-or-revid' => 'Titre de la page ou numéro de la révision :',
	'changeauthor-pagenameform-go' => 'Aller',
	'changeauthor-comment' => 'Commentaire :',
	'changeauthor-changeauthors-multi' => "Changer {{PLURAL:$1|l'auteur|les auteurs}}",
	'changeauthor-explanation-multi' => "Avec ce formulaire, vous pouvez changer les auteurs des révisions. Modifiez un ou plusieurs noms d'usager dans la liste, ajoutez un commentaire (facultatif) et cliquez le bouton ''Changer auteur(s)''.",
	'changeauthor-changeauthors-single' => "Changer l'auteur",
	'changeauthor-explanation-single' => "Avec ce formulaire, vous pouvez changer l'auteur d'une révision. Changez le nom d'auteur ci-dessous, ajoutez un commentaire (facultatif) et cliquez sur le bouton ''Changer l'auteur''.",
	'changeauthor-invalid-username' => "Nom d'utilisateur « $1 » invalide",
	'changeauthor-nosuchuser' => 'Aucun utilisateur « $1 »',
	'changeauthor-revview' => 'Révision #$1 de $2',
	'changeauthor-nosuchtitle' => "Il n'existe aucune page intitulée « $1 »",
	'changeauthor-weirderror' => "Une erreur s'est produite. Prière d'essayer à nouveau. Si cette erreur est apparue à plusieurs reprises, la base de données est probablement corrompue.",
	'changeauthor-invalidform' => "Prière d'utiliser le formulaire généré par la [[Special:ChangeAuthor|page spéciale]] plutôt qu'un formulaire personnel",
	'changeauthor-success' => 'Votre requête a été traitée avec succès.',
	'changeauthor-logentry' => "Modification de l'auteur de $2 de $1 depuis $3 vers $4",
	'changeauthor-logpagename' => "Journal des changements faits par l'auteur",
	'changeauthor-rev' => 'r$1',
	'right-changeauthor' => "Modifier l'auteur d'une révision",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'changeauthor' => 'Changiér l’ôtor de les vèrsions',
	'changeauthor-desc' => 'Pèrmèt de changiér lo nom a l’ôtor de yon ou ben un mouél de changements.',
	'changeauthor-title' => 'Changiér l’ôtor d’una vèrsion',
	'changeauthor-search-box' => 'Rechèrchiér des vèrsions',
	'changeauthor-pagename-or-revid' => 'Titro de la pâge ou numerô de la vèrsion :',
	'changeauthor-pagenameform-go' => 'Alar',
	'changeauthor-comment' => 'Comentèro :',
	'changeauthor-changeauthors-multi' => 'Changiér {{PLURAL:$1|l’ôtor|los ôtors}}',
	'changeauthor-changeauthors-single' => 'Changiér l’ôtor',
	'changeauthor-invalid-username' => 'Nom d’utilisator « $1 » envalido.',
	'changeauthor-nosuchuser' => 'Gins d’utilisator « $1 ».',
	'changeauthor-revview' => 'Vèrsion #$1 de $2',
	'changeauthor-nosuchtitle' => 'Ègziste gins d’articllo avouéc lo titro « $1 ».',
	'changeauthor-success' => 'Voutra requéta at étâ trètâ avouéc reusséta.',
	'changeauthor-logentry' => 'Changement a l’ôtor de $2 de $1 dês $3 de vers $4',
	'changeauthor-logpagename' => 'Jornal des changements fêts per l’ôtor',
	'changeauthor-rev' => 'v$1',
	'right-changeauthor' => 'Changiér l’ôtor d’una vèrsion',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'changeauthor-comment' => 'Oanmerking:',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'changeauthor-comment' => 'Nóta tráchta:',
	'changeauthor-invalid-username' => 'Ainm úsáideoir "$1" neamhbhailí.',
	'changeauthor-nosuchuser' => 'Níl úsáideoir "$1".',
	'changeauthor-revview' => 'Leagan #$1 as $2',
	'changeauthor-nosuchtitle' => 'Níl aon leathanach ab ainm "$1".',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'changeauthor' => 'Mudar a revisión do autor',
	'changeauthor-desc' => 'Permite cambiar o autor dunha revisión',
	'changeauthor-title' => 'Cambiar ao autor da revisión',
	'changeauthor-search-box' => 'Procurar revisións',
	'changeauthor-pagename-or-revid' => 'Nome da páxina ou ID da revisión:',
	'changeauthor-pagenameform-go' => 'Adiante',
	'changeauthor-comment' => 'Comentario:',
	'changeauthor-changeauthors-multi' => 'Mudar {{PLURAL:$1|o autor|os autores}}',
	'changeauthor-explanation-multi' => 'Con este formulario pode cambiar as revisións dos autores.
Simplemente cambie un ou máis dos nomes dos usuarios na lista de embaixo, engada un comentario (é opcional) e prema no botón "Mudar os autor(es)"',
	'changeauthor-changeauthors-single' => 'Cambiar o autor',
	'changeauthor-explanation-single' => "Con este formulario pode cambiar a revisión do autor. Simplemente mude o nome do usuario embaixo, engada un comentario (opcional) e prema o botón de 'Mudar autor'",
	'changeauthor-invalid-username' => 'Nome de usuario non válido "$1".',
	'changeauthor-nosuchuser' => 'Non hai tal usuario "$1".',
	'changeauthor-revview' => 'Revisión nº$1 de $2',
	'changeauthor-nosuchtitle' => 'Non hai ningunha páxina que se chame "$1".',
	'changeauthor-weirderror' => 'Produciuse un erro moi estraño. Realice outra vez a consulta. Se este erro sigue aparecendo, probabelmente a base de datos está mal.',
	'changeauthor-invalidform' => 'Por favor, utilice o formulario fornecido pola [[Special:ChangeAuthor|páxina especial]] no canto dun formulario personalizado.',
	'changeauthor-success' => 'A súa petición foi procesada con éxito.',
	'changeauthor-logentry' => 'Cambie autor de $2 de $1 a $3 de $4',
	'changeauthor-logpagename' => 'Rexistro dos cambios do autor',
	'changeauthor-rev' => 'r$1',
	'right-changeauthor' => 'Cambiar o autor dunha revisión',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'changeauthor-pagenameform-go' => 'Ἱέναι',
	'changeauthor-comment' => 'Σχόλιον:',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'changeauthor' => 'Autor vun ere Version ändere',
	'changeauthor-desc' => 'Erlaubt s dr Autor vun ere Version z ändere',
	'changeauthor-title' => 'Autor vun ere Version ändere',
	'changeauthor-search-box' => 'Version sueche',
	'changeauthor-pagename-or-revid' => 'Sytename oder Versionsnummere:',
	'changeauthor-pagenameform-go' => 'Sueche',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Autor|Autore}} ändere',
	'changeauthor-explanation-multi' => 'Mit däm Formular chasch Du d Autore vu dr Versione ändere. Ändere eifach ein oder mehreri Autorenäme in dr Lischt, ergänz e Kommentar (optional) un druck uf d „Autor ändere“-Schaltflächi.',
	'changeauthor-changeauthors-single' => 'Autor ändere',
	'changeauthor-explanation-single' => 'Mit däm Formular chasch Du dr Autor vun ere Versione ändere. Ändere eifach dr Autorename in dr Lischt, ergänz e Kommentar (optional) un druck uf d „Autor ändere“-Schaltflächi.',
	'changeauthor-invalid-username' => 'Nit giltige Benutzername „$1“.',
	'changeauthor-nosuchuser' => 'S git kei Benutzer „$1“.',
	'changeauthor-revview' => 'Version #$1 vu $2',
	'changeauthor-nosuchtitle' => 'S git kei Syte „$1“.',
	'changeauthor-weirderror' => 'E seli sältene Fähler isch ufträtte. Bitte widerhol Dyyni Änderig. Wänn dää Fähler nomol uftritt, isch wahrschyns d Datebank hii.',
	'changeauthor-invalidform' => 'Bitte bruuch s Formular uf dr [[Special:ChangeAuthor|Spezialsyte]].',
	'changeauthor-success' => 'Dyyni Änderig isch erfolgryych durgfiert wore.',
	'changeauthor-logentry' => 'het dr Autorename vu dr $2 vu $1 vu $3 uf $4 gänderet',
	'changeauthor-logpagename' => 'Autorename-Änderigslogbuech',
	'right-changeauthor' => 'Dr Autor vun ere Version ändere',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'changeauthor-pagenameform-go' => 'Gow',
	'changeauthor-comment' => 'Cohaggloo:',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'changeauthor-comment' => 'Bahasi:',
);

/** Hebrew (עברית)
 * @author Agbad
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'changeauthor' => 'שינוי כותב של גרסה',
	'changeauthor-desc' => 'אפשרות לשינוי כותב של גרסה',
	'changeauthor-title' => 'שינוי הכותב של גרסה',
	'changeauthor-search-box' => 'חיפוש גרסאות',
	'changeauthor-pagename-or-revid' => 'שם דף או מספר גרסה:',
	'changeauthor-pagenameform-go' => 'הצגה',
	'changeauthor-comment' => 'הערה:',
	'changeauthor-changeauthors-multi' => 'שינוי {{PLURAL:$1|כותב|כותבים}}',
	'changeauthor-explanation-multi' => 'באמצעות טופס זה תוכלו לשנות כותבים של גרסאות.
פשוט שנו שם משתמש אחד או יותר ברשימה שלהלן, הוסיפו הערה (אופציונאלי) ולחצו על הכפתור "שינוי כותב(ים)".',
	'changeauthor-changeauthors-single' => 'שינוי כותב',
	'changeauthor-explanation-single' => 'בעזרת טופס זה תוכלו לשנות כותב של גרסה.
פשוט שנו את שם המשתמש שלהלן, הוסיפו הערה (אופציונאלי) ולחצו על הכפתור "שינוי כותב".',
	'changeauthor-invalid-username' => 'שם משתמש שגוי "$1".',
	'changeauthor-nosuchuser' => 'אין משתמש בשם "$1".',
	'changeauthor-revview' => 'גרסה #$1 של $2',
	'changeauthor-nosuchtitle' => 'אין דף בשם "$1".',
	'changeauthor-weirderror' => 'אירעה שגיאה מוזרה ביותר.
אנא נסו שנית לשלוח את הבקשה.
אם שגיאה זו ממשיכה להופיע, כנראה שמסד הנתונים פגום.',
	'changeauthor-invalidform' => 'אנא השתמשו בטופס הנמצא ב[[Special:ChangeAuthor|דף המיוחד]] ולא בטופס מותאם אישית.',
	'changeauthor-success' => 'בקשתכם עובדה בהצלחה.',
	'changeauthor-logentry' => 'שינה את הכותב של $2 של $1 מ$3 ל$4',
	'changeauthor-logpagename' => 'יומן שינויי כותבים',
	'changeauthor-rev' => 'גרסה $1',
	'right-changeauthor' => 'שינוי מחבר של גרסה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'changeauthor' => 'अवतरण का लेखक बदलें',
	'changeauthor-desc' => 'अवतरण का लेखक बदलने की अनुमति देता हैं',
	'changeauthor-title' => 'अवतरण का लेखक बदलें',
	'changeauthor-search-box' => 'अवतरण खोजें',
	'changeauthor-pagename-or-revid' => 'पन्ने का नाम या अवतरण क्रमांक:',
	'changeauthor-pagenameform-go' => 'जायें',
	'changeauthor-comment' => 'टिप्पणी:',
	'changeauthor-changeauthors-multi' => 'लेखक बदलें',
	'changeauthor-explanation-multi' => "नीचे दिया हुआ फार्म इस्तेमाल कर आप अवतरणोंके लेखक बदल सकतें हैं।
नीचे दी हुई सूची से एक या अनेक सदस्य बदलें, टिप्पणी दें (आवश्यक नहीं) और 'लेखक बदलें' बटन पर क्लिक करें।",
	'changeauthor-changeauthors-single' => 'लेखक बदलें',
	'changeauthor-explanation-single' => "नीचे दिया हुआ फार्म इस्तेमाल कर आप अवतरण का लेखक बदल सकतें हैं। नीचे दी हुई सूची से एक सदस्य बदलें, टिप्पणी दें (आवश्यक नहीं) और 'लेखक बदलें' बटन पर क्लिक करें।",
	'changeauthor-invalid-username' => 'अवैध सदस्यनाम "$1"।',
	'changeauthor-nosuchuser' => '"$1" नामसे कोई भी सदस्य नहीं हैं।',
	'changeauthor-revview' => '$2 का #$1 अवतरण',
	'changeauthor-nosuchtitle' => '"$1" नामसे कोई भी लेख अस्तित्वमें नहीं हैं।',
	'changeauthor-weirderror' => 'एक अलगही गलती मिली हैं।
कॄपया पुन: यत्न करें।
अगर यह गलती फिर से आती हैं, तो इसका मतलब डाटाबेसमें बडी समस्या हो सकता हैं।',
	'changeauthor-invalidform' => 'खुद तैयार किया फार्म इस्तेमाल करने के बजाय Special:ChangeAuthor का इस्तेमाल करें',
	'changeauthor-success' => 'आपकी रिक्वेस्टको प्रोसेस कर दिया हैं।',
	'changeauthor-logentry' => '$1 के $2 अवतरणका लेखक $3 से $4 को बदल दिया हैं',
	'changeauthor-logpagename' => 'लेखक बदलाव सूची',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'changeauthor-pagenameform-go' => 'Lakat',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'changeauthor' => 'Promijenite autora inačice',
	'changeauthor-desc' => 'Omogućava promjenu autora određene izmjene',
	'changeauthor-title' => 'Promijeni autora inačice',
	'changeauthor-search-box' => 'Pretraži inačice',
	'changeauthor-pagename-or-revid' => 'Ime članka ili oznaka (ID) inačice:',
	'changeauthor-pagenameform-go' => 'Kreni',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => 'Promijeni {{PLURAL:$1|autora|autora}}',
	'changeauthor-explanation-multi' => "Ovaj obrazac omogućava promjenu autora inačica. Jednostavno promijenite jedno iii više korisničkih imena u donjem popisu, dodajte neobaveznu napomenu i pritisnite tipku 'Promijeni autora(e)'.",
	'changeauthor-changeauthors-single' => 'Promijeni autora',
	'changeauthor-explanation-single' => "Ovaj obrazac omogućava promjenu autora inačice. Jednostavno korisničko ime, dodajte neobaveznu napomenu i pritisnite tipku 'Promijeni autora'.",
	'changeauthor-invalid-username' => 'Pogrešno ime suradnika "$1".',
	'changeauthor-nosuchuser' => 'Ne postoji suradnik "$1".',
	'changeauthor-revview' => 'Inačica $1 str. $2',
	'changeauthor-nosuchtitle' => 'Nema članka koji se zove "$1".',
	'changeauthor-weirderror' => 'Dogodila se vrlo čudna greška. Molimo, ponovite zahtjev. Ako se greška ponovi, baza podataka je vjerojatno oštećena.',
	'changeauthor-invalidform' => 'Molimo koristite obrazac na [[Special:ChangeAuthor|posebnoj stranici]] umjesto vlastitog obrasca.',
	'changeauthor-success' => 'Vaš zahtjev je uspješno obrađen.',
	'changeauthor-logentry' => 'Promijenjen autor $2 stranice $1 iz $3 u $4',
	'changeauthor-logpagename' => 'Evidencija promijena autora',
	'right-changeauthor' => 'Izmjeni autora inačice',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'changeauthor' => 'Wersijoweho awtora změnić',
	'changeauthor-desc' => 'Dowola awtora wersije změnić',
	'changeauthor-title' => 'Awtora wersije změnić',
	'changeauthor-search-box' => 'Wersije pytać',
	'changeauthor-pagename-or-revid' => 'Mjeno strony abo ID wersije:',
	'changeauthor-pagenameform-go' => 'Dźi',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|awtora|awtorow|awtorow|awtorow}} změnić',
	'changeauthor-explanation-multi' => "Z tutym formularom móžeš awtorow wersijow změnić. Změń prosće jedne wužiwarske mjeno abo wjacore wužiwarske mjena w lisćinje deleka, přidaj komentar (opcionalny) a klikń na tłóčatko 'Awtorow zmenić'.",
	'changeauthor-changeauthors-single' => 'Awtora změnić',
	'changeauthor-explanation-single' => "Z tutym formularom móžeš awtora wersije změnić. Změń prosće wužiwarske mjeno deleka, přidaj komentar (opcionalny) a klikń na tłóčatko 'Awtora změnić'.",
	'changeauthor-invalid-username' => 'Njepłaćiwe wužiwarske mjeno "$1".',
	'changeauthor-nosuchuser' => 'Wužiwar "$1" njeje.',
	'changeauthor-revview' => 'Wersija #$1 wot $2',
	'changeauthor-nosuchtitle' => 'Strona z mjenom "$1" njeeksistuje.',
	'changeauthor-weirderror' => 'Jara dźiwny zmylk je wustupił. Prošu spytaj swoje požadanje znowa. Jeli so tutón zmylk zaso a zaso jewi, je najskerje datowa banka poškodźena.',
	'changeauthor-invalidform' => 'Prošu wužij radšo formular z [[Special:ChangeAuthor|specialneje strony]] hač swójski formular.',
	'changeauthor-success' => 'Waše požadanje je so wuspěšnje wobdźěłało.',
	'changeauthor-logentry' => 'Změni so awtor wot $2 wot $1 z $3 do $4',
	'changeauthor-logpagename' => 'Protokol wo změnach awtorow',
	'right-changeauthor' => 'Awtora wersije změnić',
);

/** Hungarian (Magyar)
 * @author Adam78
 * @author Dani
 * @author Dorgan
 */
$messages['hu'] = array(
	'changeauthor' => 'Változat szerzőjének megváltoztatása',
	'changeauthor-desc' => 'Lehetővé teszi egy változat szerzőjének megváltoztatását',
	'changeauthor-title' => 'Adott változat szerzőjének megváltoztatása',
	'changeauthor-search-box' => 'Változatok keresése',
	'changeauthor-pagename-or-revid' => 'Oldalnév vagy változat-azonosító',
	'changeauthor-pagenameform-go' => 'Menj',
	'changeauthor-comment' => 'Megjegyzés:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Szerző|Szerzők}} megváltoztatása',
	'changeauthor-explanation-multi' => "Ezen a lapon megváltoztathatod adott változatok szerzőjét. Egyszerűen írd át a kívánt felhasználói neveket a lenti listában, írj megjegyzést (nem kötelező), majd kattints a 'Szerző(k) megváltoztatása' gombra.",
	'changeauthor-changeauthors-single' => 'Szerző megváltoztatása',
	'changeauthor-explanation-single' => "Ezen a lapon megváltoztathatod a változat szerzőjét. Egyszerűen írd át a lenti felhasználói nevet, írj megjegyzést (nem kötelező), majd kattints a 'Szerző(k) megváltoztatása' gombra.",
	'changeauthor-invalid-username' => 'A(z) "$1" egy érvénytelen felhasználónév.',
	'changeauthor-nosuchuser' => 'Nincs „$1” nevű felhasználó',
	'changeauthor-revview' => '$2 #$1 azonosítójú változata',
	'changeauthor-nosuchtitle' => 'Nem létezik „$1” nevű oldal.',
	'changeauthor-weirderror' => 'Egy nagyon furcsa hiba lépett fel. Próbáld újra a kérést. Ha a hiba továbbra is fennáll, az adatbázis valószínűleg hibás.',
	'changeauthor-invalidform' => 'Kérlek saját űrlap helyett használd a [[Special:ChangeAuthor|speciális lapon]] található változatot.',
	'changeauthor-success' => 'A kérésedet sikeresen végrehajtottam.',
	'changeauthor-logentry' => '$1 $2 azonosítójú változatának szerzőjét $3 felhasználóról $4 felhasználóra cserélte',
	'changeauthor-logpagename' => 'Szerzőváltoztatási napló',
	'right-changeauthor' => 'A változat szerzőjének megváltoztatása',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'changeauthor' => 'Cambiar le autor del version',
	'changeauthor-desc' => 'Permitte cambiar le autor de un version',
	'changeauthor-title' => 'Cambiar le autor de un version',
	'changeauthor-search-box' => 'Cercar versiones',
	'changeauthor-pagename-or-revid' => 'Nomine del pagina o ID del version:',
	'changeauthor-pagenameform-go' => 'Va',
	'changeauthor-comment' => 'Commento:',
	'changeauthor-changeauthors-multi' => 'Cambiar {{PLURAL:$1|autor|autores}}',
	'changeauthor-explanation-multi' => "Con iste formulario tu pote cambiar le autores de versiones.
Simplemente modifica un o plus nomines de usator in le lista infra, adde un commento (optional) e clicca le button 'Cambiar autor(es)'.",
	'changeauthor-changeauthors-single' => 'Cambiar autor',
	'changeauthor-explanation-single' => "Con iste formulario tu pote cambiar le autor de un version.
Simplemente modifica le nomine de usator infra, adde un commento (optional) e clicca le button 'Cambiar autor'.",
	'changeauthor-invalid-username' => 'Nomine de usator "$1" invalide.',
	'changeauthor-nosuchuser' => 'Usator "$1" non existe.',
	'changeauthor-revview' => 'Version #$1 de $2',
	'changeauthor-nosuchtitle' => 'Non existe un pagina con titulo "$1".',
	'changeauthor-weirderror' => 'Un error multo estranie ha occurrite.
Per favor reproba tu requesta.
Si iste error persiste, le base de datos es probabilemente defectuose.',
	'changeauthor-invalidform' => 'Per favor usa le formulario providite per le [[Special:ChangeAuthor|pagina special]] e non un formulario personalisate.',
	'changeauthor-success' => 'Tu requesta ha essite processate con successo.',
	'changeauthor-logentry' => 'Cambiava le autor del version $2 del pagina $1 de $3 a $4',
	'changeauthor-logpagename' => 'Registro de cambiamentos de autores',
	'changeauthor-rev' => 'v$1',
	'right-changeauthor' => 'Cambiar le autor de un version',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'changeauthor' => 'Mengganti penulis revisi',
	'changeauthor-desc' => 'Mengizinkan pengubahan penulis revisi',
	'changeauthor-title' => 'Mengganti penulis suatu revisi',
	'changeauthor-search-box' => 'Mencari revisi',
	'changeauthor-pagename-or-revid' => 'Nama halaman atau kode revisi:',
	'changeauthor-pagenameform-go' => 'Tuju ke',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => 'Ganti {{PLURAL:$1|penulis|penulis}}',
	'changeauthor-explanation-multi' => 'Dalam formulir ini Anda dapat mengubah penulis suatu revisi.
Anda hanya perlu mengubah satu nama pengguna atau lebih pada daftar di bawah ini, menambahkan komentar (opsional) dan klik tombol "Ganti penulis".',
	'changeauthor-changeauthors-single' => 'Ganti penulis',
	'changeauthor-explanation-single' => 'Dalam formulir ini Anda dapat mengubah penulis suatu revisi.
Anda hanya perlu mengubah nama pengguna di bawah ini, menambahkan komentar (opsional) dan klik tombol "Ganti penulis"',
	'changeauthor-invalid-username' => 'Nama pengguna tidak sah "$1".',
	'changeauthor-nosuchuser' => 'Tidak ada pengguna dengan nama "$1".',
	'changeauthor-revview' => 'Revisi #$1 dari $2',
	'changeauthor-nosuchtitle' => 'Tidak ada halaman dengan judul "$1".',
	'changeauthor-weirderror' => 'Terjadi kesalahan yang sangat tidak biasa.
Harap coba mengulang permintaan Anda.
Jika kesalahan ini tetap terulang, kemungkinan terjadi kerusakan di basis data.',
	'changeauthor-invalidform' => 'Harap gunakan formulir yang disediakan di [[Special:ChangeAuthor|halaman istimewa]] dan bukan formulir kustom.',
	'changeauthor-success' => 'Permintaan Anda telah berhasil diproses.',
	'changeauthor-logentry' => 'Mengubah penulis revisi $2 halaman $1 dari $3 menjadi $4',
	'changeauthor-logpagename' => 'Log perubahan penulis',
	'right-changeauthor' => 'Mengubah penulis suatu revisi',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'changeauthor-comment' => 'Komento:',
	'changeauthor-changeauthors-multi' => 'Chanjez {{PLURAL:$1|autoro|autori}}',
	'changeauthor-changeauthors-single' => 'Chanjez autoro',
	'changeauthor-invalid-username' => 'Ne-valida uzantonomo "$1".',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'changeauthor-pagenameform-go' => 'Áfram',
	'changeauthor-comment' => 'Athugasemd:',
	'changeauthor-invalid-username' => 'Rangt notandanafn „$1“.',
	'changeauthor-nosuchuser' => 'Notandi ekki til „$1“.',
	'changeauthor-nosuchtitle' => 'Engin síða er nefnd „$1“.',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 */
$messages['it'] = array(
	'changeauthor' => 'Cambia autore revisione',
	'changeauthor-desc' => "Permette di modificare l'autore di una revisione",
	'changeauthor-title' => "Modifica l'autore di una revisione",
	'changeauthor-search-box' => 'Ricerca revisioni',
	'changeauthor-pagename-or-revid' => 'Nome pagina o ID revisione:',
	'changeauthor-pagenameform-go' => 'Vai',
	'changeauthor-comment' => 'Commento:',
	'changeauthor-changeauthors-multi' => 'Modifica {{PLURAL:$1|autore|autori}}',
	'changeauthor-explanation-multi' => "Con questo semplice modulo puoi modificare gli autori di revisioni.
Basta cambiare uno o più nomi utente nell'elenco seguente, aggiungere un commento (se lo ritieni opportuno) e fare clic sul pulsante 'Modifica autore/i'.",
	'changeauthor-changeauthors-single' => 'Modifica autore',
	'changeauthor-explanation-single' => "Con questo semplice modulo puoi modificare l'autore di una revisione.
Basta cambiare il nome utente seguente, aggiungere un commento (se lo ritieni opportuno) e fare clic sul pulsante 'Modifica autore'.",
	'changeauthor-invalid-username' => 'Nome utente non valido "$1".',
	'changeauthor-nosuchuser' => 'Nessun utente "$1".',
	'changeauthor-revview' => 'Revisione #$1 di $2',
	'changeauthor-nosuchtitle' => 'Non c\'è alcuna pagina chiamata "$1".',
	'changeauthor-weirderror' => "Si è verificato un errore molto strano.
Prova a ripetere la richiesta.
Se l'errore dovesse persistere, il database è probabilmente rotto.",
	'changeauthor-invalidform' => 'Utilizza il modulo presente nella [[Special:ChangeAuthor|pagina speciale]] piuttosto che un modulo personalizzato.',
	'changeauthor-success' => 'La tua richiesta è stata eseguita con successo.',
	'changeauthor-logentry' => "Modificato l'autore di $2 di $1 da $3 a $4",
	'changeauthor-logpagename' => 'Log delle modifiche autori',
	'right-changeauthor' => "Modifica l'autore di una revisione",
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author JtFuruhata
 * @author Whym
 */
$messages['ja'] = array(
	'changeauthor' => '特定版投稿者の変更',
	'changeauthor-desc' => '版の投稿者の変更を可能にする',
	'changeauthor-title' => '特定版の投稿者を変更',
	'changeauthor-search-box' => '特定版の検索',
	'changeauthor-pagename-or-revid' => 'ページ名または特定版ID:',
	'changeauthor-pagenameform-go' => '検索',
	'changeauthor-comment' => '変更理由:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|著者}}を変更',
	'changeauthor-explanation-multi' => 'このフォームから各版の著者を変更することができます。下に記載されている一人または複数の利用者名を変更し、コメントを付記し (省略可能)、変更ボタンを押してください。',
	'changeauthor-changeauthors-single' => '変更',
	'changeauthor-explanation-single' => 'このフォームから版の著者を変更することができます。下記の利用者名を変更し、コメントを付記し (省略可能)、変更ボタンを押してください。',
	'changeauthor-invalid-username' => '"$1" は不正な利用者名です。',
	'changeauthor-nosuchuser' => '"$1" という利用者は存在しません。',
	'changeauthor-revview' => '$2 の特定版 #$1',
	'changeauthor-nosuchtitle' => '"$1" という名前のページはありません。',
	'changeauthor-weirderror' => '予測不能なエラーが発生しました。もう一度操作してください。それでもエラーが発生する場合は、恐らくデータベースが破壊されています。',
	'changeauthor-invalidform' => '独自のフォームではなく、[[Special:ChangeAuthor|特別ページ]]が提供するフォームを利用してください。',
	'changeauthor-success' => '要求された処理が完了しました。',
	'changeauthor-logentry' => '$1 の$2 の著者を $3 から $4 へ変更しました',
	'changeauthor-logpagename' => '投稿者変更記録',
	'changeauthor-rev' => '第$1版',
	'right-changeauthor' => '版の投稿者を変更する',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'changeauthor' => 'Ngganti révisi pangripta',
	'changeauthor-title' => 'Ganti pangripta sawijining révisi',
	'changeauthor-search-box' => 'Golèk révisi',
	'changeauthor-pagename-or-revid' => 'ID jeneng kaca utawa révisi:',
	'changeauthor-pagenameform-go' => 'Tumuju',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => 'Ganti {{PLURAL:$1|penulis|penulis}}',
	'changeauthor-changeauthors-single' => 'Ganti pangripta',
	'changeauthor-invalid-username' => 'Jeneng panganggo "$1" ora absah.',
	'changeauthor-nosuchuser' => 'Ora ana panganggo "$1".',
	'changeauthor-revview' => 'Révisi #$1 saka $2',
	'changeauthor-nosuchtitle' => 'Ora ana kaca sing diarani "$1".',
	'changeauthor-weirderror' => 'Ana kaluputan anèh sing dumadi.
Mangga diulang manèh panyuwunan panjenengan.
Yèn kaluputan iki tetep dumadi manèh, tegesé basis data iki mbok-menawa rusak.',
	'changeauthor-success' => 'Panyuwunan panjenengan wis kasil diprosès.',
	'changeauthor-logpagename' => 'Log owah-owahan pangripta',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'changeauthor-search-box' => 'ស្វែងរកកំណែប្រែ​',
	'changeauthor-pagename-or-revid' => 'ឈ្មោះ​ទំព័រ​ឬ​លេខ ID កំណែ​៖',
	'changeauthor-pagenameform-go' => 'ទៅ',
	'changeauthor-comment' => 'យោបល់៖',
	'changeauthor-changeauthors-multi' => 'ផ្លាស់ប្តូរ{{PLURAL:$1|author|អ្នកនិពន្ធ}}',
	'changeauthor-changeauthors-single' => 'ផ្លាស់ប្តូរ អ្នកនិពន្ធ',
	'changeauthor-invalid-username' => 'ឈ្មោះ​អ្នកប្រើប្រាស់ "$1" គ្មានសុពលភាព។',
	'changeauthor-nosuchuser' => 'មិនមានអ្នកប្រើប្រាស់ឈ្មោះ "$1" ទេ។',
	'changeauthor-revview' => 'កំណែ #$1 របស់ $2',
	'changeauthor-nosuchtitle' => 'គ្មានទំព័រ​ដែលមាន​ឈ្មោះ "$1" ទេ។',
	'changeauthor-weirderror' => 'បញ្ហា​ដ៏ចម្លែកមួយ​បានកើតឡើង។ សូម​ព្យាយាម​ស្នើសុំ​ម្ដងទៀត។ បើសិនជា​នៅតែមាន​បញ្ហា នោះមូលដ្ឋានទិន្នន័យ​ប្រហែលជាខូចហើយ។',
	'changeauthor-invalidform' => 'សូមប្រើប្រាស់សំនុំបែបបទ​ដែលផ្ដល់ដោយ[[Special:ChangeAuthor|ទំព័រពិសេស]] ជាជាងសំនុំបែបបទបង្កើតដោយខ្លួនអ្នក។',
	'changeauthor-success' => 'ការ​ស្នើសុំរបស់​អ្នក​បានឆ្លងកាត់​ដោយជោគជ័យ។',
	'changeauthor-logentry' => 'បានប្ដូរអ្នកនិពន្ធរបស់ $2 របស់ $1 ពី $3 ទៅជា $4 ហើយ',
	'changeauthor-logpagename' => 'កំណត់ហេតុនៃការផ្លាស់ប្តូរអ្នកនិពន្ធ',
	'right-changeauthor' => 'ផ្លាស់ប្ដូរអ្នកនិពន្ធរបស់កំណែមួយ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'changeauthor-pagenameform-go' => 'ಹೋಗು',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Yknok29
 */
$messages['ko'] = array(
	'changeauthor' => '판의 저자 변경',
	'changeauthor-desc' => '특정 판의 저자를 변경할 수 있는 기능',
	'changeauthor-title' => '특정 판의 저자 변경',
	'changeauthor-search-box' => '판 검색',
	'changeauthor-pagename-or-revid' => '문서 이름 혹은 특정 판 ID:',
	'changeauthor-pagenameform-go' => '가기',
	'changeauthor-comment' => '이유:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1}}저자 변경',
	'changeauthor-explanation-multi' => "아래의 양식을 이용해 특정 판의 저자를 변경할 수 있습니다.
아래 목록에서 변경하려는 부분의 저자를 편집한 다음에, 이유를 입력하고 '저자 변경'을 클릭해 주세요.",
	'changeauthor-changeauthors-single' => '저자 변경',
	'changeauthor-explanation-single' => "아래의 양식을 이용해 특정 판의 저자를 변경할 수 있습니다. 저자를 변경한 다음, 이유를 입력하고 '저자 변경'을 클릭해 주세요.",
	'changeauthor-invalid-username' => '‘$1’은(는) 잘못된 사용자 이름입니다.',
	'changeauthor-nosuchuser' => '‘$1’ 사용자가 존재하지 않습니다.',
	'changeauthor-revview' => '$2의 $1 판',
	'changeauthor-nosuchtitle' => '‘$1’ 문서가 존재하지 않습니다.',
	'changeauthor-weirderror' => '알 수 없는 오류가 발생했습니다. 다시 시도해주세요. 계속 오류가 나오는 경우 데이터베이스에 문제가 있을 수 있습니다.',
	'changeauthor-invalidform' => '별개 양식을 사용하지 말고, [[Special:ChangeAuthor|여기]]의 양식을 사용해주세요.',
	'changeauthor-success' => '변경이 완료되었습니다.',
	'changeauthor-logentry' => '$1 문서의 $2를 $3 사용자에서 $4 사용자로 변경',
	'changeauthor-logpagename' => '저자 변경 기록',
	'right-changeauthor' => '특정 판의 작성자 이름을 변경하기',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'changeauthor-pagenameform-go' => 'Go to am',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'changeauthor-pagenameform-go' => 'Agto',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'changeauthor' => 'Donn do Schriiver fun ene Version ändere',
	'changeauthor-desc' => 'Määt et müjjelesch, dä Schriiver fun ene Version fun ene Sigg ze ändere.',
	'changeauthor-title' => 'Donn dä Schriiver vun ene Version vun ene Sigg ußtuusche',
	'changeauthor-search-box' => 'Versione söke',
	'changeauthor-pagename-or-revid' => 'Name fun ene Sigg udder Nommer fun ene Version:',
	'changeauthor-pagenameform-go' => 'Lohß Jonn!',
	'changeauthor-comment' => 'Kommäntaa:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Eine|$1|Keine}} Schriiver ändere',
	'changeauthor-explanation-multi' => 'Met dämm Fommulaa kanns De dä Schriiver fun eine Änderung aan en Sigg ußtuusche.
Donn eijfach eine odder mieh fun dä Metmaacher-Name en dä Leß he drunger ändere, jiff ene Kommäntaa en, wann De wells, un dann dröck op dä „{{int:changeauthor-pagenameform-go}}“ Knopp.',
	'changeauthor-changeauthors-single' => 'Schriiver Tuusche',
	'changeauthor-explanation-single' => 'Met dämm Fommulaa kanns De dä Schriiver fun eine Änderung aan en Sigg ußtuusche.
Donn eijfach dä Metmaacher-Name he drunger ändere, jiff ene Kommäntaa en, wann De wells, un dann dröck op dä „{{int:changeauthor-pagenameform-go}}“ Knopp.',
	'changeauthor-invalid-username' => 'Dä Name „$1“ för ene Metmaacher es nit jöltesch.',
	'changeauthor-nosuchuser' => 'Mer han keine Metmaacher, dä „$1“ heejsch.',
	'changeauthor-revview' => 'De Väsjohn Nommer $1 fun $2',
	'changeauthor-nosuchtitle' => 'Et jit kei Sigg met dämm Tittel „$1“.',
	'changeauthor-weirderror' => 'Enne janz seltsame Fäähler es opjetrodde.
Donn dat norr_esnß versöke.
Wann dat esu wigger jeiht,
un dä Fähler kütt widder,
dann künnt de Datebangk kapott sin.',
	'changeauthor-invalidform' => 'Donn dat Fommolaa op dä [[Special:ChangeAuthor|Söndersigg]] nämme,
un kei eije Fommolaa.',
	'changeauthor-success' => 'Ding Änderung es jemaat.',
	'changeauthor-logentry' => 'hät dä Schriiver fun dä Version $2 fun dä Sigg „$1“ jeändert, et wohr dä Metmaacher $3 un es jetz dä Metmaacher $4.',
	'changeauthor-logpagename' => 'Logbooch fum Schriiver Ußtuusche',
	'changeauthor-rev' => '$1',
	'right-changeauthor' => 'Dä Metmaacher ußwääßelle, dä en Version jemaat hät',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'changeauthor-pagenameform-go' => 'Here',
	'changeauthor-comment' => 'Şîrove:',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'changeauthor' => 'Auteur vun enger Versioun änneren',
	'changeauthor-desc' => "Erlaabt et den Auteur vun enger oder méi Versiounen z'änneren",
	'changeauthor-title' => 'Auteur vun enger Versioun änneren',
	'changeauthor-search-box' => 'Versioune sichen',
	'changeauthor-pagename-or-revid' => 'Säitenumm oder Versiounsnummer:',
	'changeauthor-pagenameform-go' => 'Lass',
	'changeauthor-comment' => 'Bemierkung:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Auteur|Auteuren}} änneren',
	'changeauthor-explanation-multi' => "Mat dësem Formulaire kënnt Dir d'Auteure vun de Versiounen äneren.
Ännert einfach een oder méi Benotzernimm an der Lëscht ënnendrënner, setzt eng Bemierkung derbäi (fakultativ) a klickt op de Knäppchen 'Auteur änneren'.",
	'changeauthor-changeauthors-single' => 'Auteur änneren',
	'changeauthor-explanation-single' => "Mat dësem Formulaire kënnt Dir den Auteur vun enger Versioun änneren.
Ännert de Benotzernumm hei ënnendrënner einfach, setzt eng Bemierkung derbäi (fakultativ) a klickt op de Knäppchen 'Auteur änneren'.",
	'changeauthor-invalid-username' => 'Benotzernumm „$1“ ass net gëlteg!',
	'changeauthor-nosuchuser' => 'Et gëtt kee Benotzer "$1".',
	'changeauthor-revview' => 'Versioun #$1 vun $2',
	'changeauthor-nosuchtitle' => 'Et gëtt keng Säit mam Numm "$1".',
	'changeauthor-weirderror' => "E seelene Feeler ass geschitt.
Probéiert w.e.g. nach eng Kéier.
Wann dëse Feeler sech widderhëlt dann ass d'Datebank waarscheinlech futti.",
	'changeauthor-invalidform' => 'Benotzt w.e.g. de Formulaire op der Säit [[Special:ChangeAuthor|Spezialsäit]] (éischter wéi een anere Formulaire).',
	'changeauthor-success' => 'Är Ufro gouf duerchgefouert.',
	'changeauthor-logentry' => 'Den Auteur gouf vun $2 op $1 vum $3 op den $4 geännert',
	'changeauthor-logpagename' => 'Lëscht vun den Ännerunge vun dësem Auteur',
	'changeauthor-rev' => 'Versioun $1',
	'right-changeauthor' => 'Den auteur vun enger Versioun änneren',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'changeauthor-comment' => 'Comenta:',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'changeauthor' => 'Outäör versie aanpasse',
	'changeauthor-desc' => "Maak 't mäögelik de outäör van 'n versie aan te passe",
	'changeauthor-title' => "De outäör van 'n bewirkingsversie aanpasse",
	'changeauthor-search-box' => 'Versies zeuke',
	'changeauthor-pagename-or-revid' => 'Paginanaam of versienómmer:',
	'changeauthor-pagenameform-go' => 'Gank',
	'changeauthor-comment' => 'Opmirking:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Outäör|Outäörs}} aanpasse',
	'changeauthor-explanation-multi' => "Mit dit formeleer kans doe de outäör van 'n bewirkingsversie aanpasse. Pas sumpeleweg ein of mier gebroekersname in de lies hie-onger aan, veug 'n opmirking toe (neet verplich) en klik op de knop 'Outäör(s) aanpasse'.",
	'changeauthor-changeauthors-single' => 'Outäör aanpasse',
	'changeauthor-explanation-single' => "Mit dit formeleer kans doe de outäör van 'n bewirkingsversie aanpasse. Pas sumpeleweg ein gebroekersname in de lies hie-onger aan, veug 'n opmirking toe (neet verplich) en klik op de knop 'Outäör aanpasse'.",
	'changeauthor-invalid-username' => 'Ongeljige gebroekersnaam "$1".',
	'changeauthor-nosuchuser' => 'Gebroeker "$1" besjteit neet.',
	'changeauthor-revview' => 'Bewirkingsnómmer $1 van $2',
	'changeauthor-nosuchtitle' => 'D\'r is gein pagina "$1".',
	'changeauthor-weirderror' => "D'r is 'n erg vraemde fout opgetraoje.
Perbeer 't nog 'ns.
Es doe dees foutmeljing jedere kier weer zuus, is de database allezelaeve kepot.",
	'changeauthor-invalidform' => "Gebroek 't formeleer van de [[Special:ChangeAuthor|speciaal pagina]], in plaats van 'n aangepas formeleer.",
	'changeauthor-success' => 'Diene aanvraog is verwirk.',
	'changeauthor-logentry' => 'Outäör van $2 van $1 aangepas van $3 nao $4',
	'changeauthor-logpagename' => 'Outäörsaanpassingelogbook',
	'right-changeauthor' => "De outäör van 'n bewirking aanpasse",
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 */
$messages['lt'] = array(
	'changeauthor-pagenameform-go' => 'Pirmyn',
	'changeauthor-comment' => 'Komentaras:',
	'changeauthor-changeauthors-single' => 'Keisti autorių',
	'changeauthor-nosuchtitle' => 'Nėra puslapio pavadinimu " $1 ".',
);

/** Latvian (Latviešu)
 * @author Papuass
 */
$messages['lv'] = array(
	'changeauthor-changeauthors-single' => 'Mainīt autoru',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'changeauthor' => 'Промена на авторот на ревизијата',
	'changeauthor-desc' => 'Овозможува да се смени авторот на некоја ревизија',
	'changeauthor-title' => 'Менување автор на ревизија',
	'changeauthor-search-box' => 'Пребарај ревизии',
	'changeauthor-pagename-or-revid' => 'Име на страницата или ID на ревизијата:',
	'changeauthor-pagenameform-go' => 'Оди',
	'changeauthor-comment' => 'Коментар:',
	'changeauthor-changeauthors-multi' => 'Смени {{PLURAL:$1|автор|автори}}',
	'changeauthor-explanation-multi' => 'Со овој образец можете да ги менувате авторите на ревизии.
Едноставно сменете едно или повеќе кориснички имиња на списокот подолу, додајте коментар (незадолжително) и кликнете на копчето „Смени автор(и)“.',
	'changeauthor-changeauthors-single' => 'Смени автор',
	'changeauthor-explanation-single' => 'Со овој образец можете да ги смените авторот на една ревизија.
Едноставно сменете го корисничкото име подолу, додајте коментар (незадолжително) и кликнете на копчето „Смени автор“.',
	'changeauthor-invalid-username' => 'Неважечко корисничко име „$1“.',
	'changeauthor-nosuchuser' => 'Нема корисник по име „$1“.',
	'changeauthor-revview' => 'Ревизија #$1 од $2',
	'changeauthor-nosuchtitle' => 'Нема страница наречена „$1“',
	'changeauthor-weirderror' => 'Се појави многу чудна грешка.
Повторете го барањето.
Ако оваа грешка продолжи да се јавува, тоа веројатно значи дека базата на податоци е оштетена.',
	'changeauthor-invalidform' => 'Користете го образецот на [[Special:ChangeAuthor|специјалната страница]], а не некој друг.',
	'changeauthor-success' => 'Вашето барање е успешно обработено.',
	'changeauthor-logentry' => 'Променет авторот на $2 на $1 од $3 на $4',
	'changeauthor-logpagename' => 'Дневник на менувања на автори',
	'changeauthor-rev' => 'рев. $1',
	'right-changeauthor' => 'Менување на авторот на ревизија',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'changeauthor' => 'പതിപ്പിന്റെ ലേഖകനെ മാറ്റുക',
	'changeauthor-desc' => 'ഒരു പതിപ്പിന്റെ ലേഖകനെ മാറ്റുവാൻ സാധിക്കുന്നു',
	'changeauthor-title' => 'ഒരു പതിപ്പിന്റെ ലേഖകനെ മാറ്റുക',
	'changeauthor-search-box' => 'പതിപ്പുകൾ തിരയുക',
	'changeauthor-pagename-or-revid' => 'താളിന്റെ പേര്‌ അല്ലെങ്കിൽ പതിപ്പിന്റെ ഐ.ഡി.:',
	'changeauthor-pagenameform-go' => 'പോകൂ',
	'changeauthor-comment' => 'അഭിപ്രായം:',
	'changeauthor-changeauthors-multi' => '{PLURAL:$1|രചയിതാവിനെ|രചയിതാക്കളെ}} മാറ്റുക',
	'changeauthor-explanation-multi' => "ഈ താൾ ഉപയോഗിച്ച് താങ്കൾക്ക് ഒരു പതിപ്പിന്റെ ലേഖകനെ മാറ്റാവുന്നതാണ്‌.
താഴെയുള്ള പട്ടികയിൽ ഒന്നോ അതിലധികമോ ഉപയോക്തൃനാമങ്ങൾ മാറ്റിയിട്ട്, അഭിപ്രായം രേഖപ്പെടുത്തിയതിനു ശേഷം (നിർബന്ധമില്ല), 'ലേഖകരെ മാറ്റുക' എന്ന ബട്ടൺ ഞെക്കുക.",
	'changeauthor-changeauthors-single' => 'ലേഖകനെ മാറ്റുക',
	'changeauthor-explanation-single' => "ഈ ഫോം ഉപയോഗിച്ച് ഒരു പതിപ്പിന്റെ ലേഖകനെ താങ്കൾക്ക് മാറ്റാവുന്നതാണ്‌. താഴെയുള്ള ഫോമിൽ ഉപയോക്തൃനാമം മാറ്റി, ലേഖകനെ മാറ്റാനുള്ള കാരണവും രേഖപ്പെടുത്തി (നിർബന്ധമില്ല), 'ലേഖകനെ മാറ്റുക' എന്ന ബട്ടൺ ഞെക്കുക.",
	'changeauthor-invalid-username' => '"$1" എന്നത് അസാധുവായ ഉപയോക്തൃനാമമാണ്‌.',
	'changeauthor-nosuchuser' => '"$1" എന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'changeauthor-revview' => '$2ന്റെ #$1 എന്ന പതിപ്പ്',
	'changeauthor-nosuchtitle' => '"$1" എന്ന താൾ നിലവിലില്ല.',
	'changeauthor-weirderror' => 'വളരെ അപരിചിതമായ പിഴവ് ഉണ്ടായിരിക്കുന്നു.
ദയവായി താങ്കളുടെ ആവശ്യം വീണ്ടും ശ്രമിക്കുക.
ഈ പിഴവ് വീണ്ടും വീണ്ടും വരുന്നുവെങ്കിൽ, ഡേറ്റാബേസിലെന്തോ പിഴവുണ്ട്.',
	'changeauthor-invalidform' => 'ദയവായി ഐച്ഛിക ഫോമിനു പകരം [[Special:ChangeAuthor|പ്രത്യേക താളിൽ]] വരുന്ന ഫോം ഉപയോഗിക്കുക.',
	'changeauthor-success' => 'താങ്കളുടെ അഭ്യർത്ഥനയുടെ നടപടിക്രമങ്ങൾ വിജയകരമായി പൂർത്തിയാക്കിയിരിക്കുന്നു.',
	'changeauthor-logentry' => '$1എന്ന താളിന്റെ $2പതിപ്പിന്റെ ലേഖകനെ $3ൽ നിന്നു $4ലേക്കു മാറ്റിയിരിക്കുന്നു',
	'changeauthor-logpagename' => 'ലേഖകരെ മാറ്റിയതിന്റെ പ്രവർത്തനരേഖ',
	'right-changeauthor' => 'ഒരു നാൾപ്പതിപ്പിന്റെ ലേഖകനെ മാറ്റുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'changeauthor-pagenameform-go' => 'Явах',
	'changeauthor-comment' => 'Тайлбар:',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'changeauthor' => 'आवृत्तीचा लेखक बदला',
	'changeauthor-desc' => 'एखाद्या आवृत्तीचा लेखक बदलण्याची परवानगी देतो',
	'changeauthor-title' => 'एखाद्या आवृत्तीचा लेखक बदला',
	'changeauthor-search-box' => 'आवृत्त्या शोधा',
	'changeauthor-pagename-or-revid' => 'पानाचे नाव किंवा आवृत्ती क्रमांक:',
	'changeauthor-pagenameform-go' => 'चला',
	'changeauthor-comment' => 'प्रतिक्रीया:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|लेखक|लेखक}} बदला',
	'changeauthor-explanation-multi' => "खालील अर्ज वापरुन तुम्ही आवृत्त्यांचे लेखक बदलू शकता. खालील यादीतील एक किंवा अनेक सदस्यनावे बदला, शेरा लिहा (वैकल्पिक) व 'लेखक बदला' या कळीवर टिचकी द्या.",
	'changeauthor-changeauthors-single' => 'लेखक बदला',
	'changeauthor-explanation-single' => "हा अर्ज वापरून तुम्ही एका आवृत्तीचा लेखक बदलू शकता. फक्त खाली सदस्यनाव बदला, शेरा लिहा (वैकल्पिक) व 'लेखक बदला' कळीवर टिचकी द्या.",
	'changeauthor-invalid-username' => 'चुकीचे सदस्यनाव "$1".',
	'changeauthor-nosuchuser' => '"$1" नावाचा सदस्य अस्तित्वात नाही.',
	'changeauthor-revview' => '$2 ची #$1 आवृत्ती',
	'changeauthor-nosuchtitle' => '"$1" यानावाचा लेख अस्तित्वात नाही.',
	'changeauthor-weirderror' => 'एक अतिशय अनोळखी त्रुटी आढळलेली आहे. कृपया क्रिया पुन्हा करा. जर ही त्रुटी दिसत राहिली, तर डाटाबेसमध्ये मोठा बिघाड झालेला असण्याची शक्यता आहे.',
	'changeauthor-invalidform' => 'स्वत: तयार केलेला अर्ज वापरण्याऐवजी Special:ChangeAuthor वरील अर्ज वापरा.',
	'changeauthor-success' => 'तुमची मागणी व्यवस्थितरीत्या पूर्ण झालेली आहे.',
	'changeauthor-logentry' => '$1 च्या $2 आवृत्तीचा लेखक $3 पासून $4 ला बदललेला आहे',
	'changeauthor-logpagename' => 'लेखक बदल सूची',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'changeauthor' => 'Ubah pengarang semakan',
	'changeauthor-desc' => 'Membolehkan pengubahan pengarang semakan',
	'changeauthor-title' => 'Ubah pengarang semakan',
	'changeauthor-search-box' => 'Cari semakan',
	'changeauthor-pagename-or-revid' => 'Nama laman atau ID semakan:',
	'changeauthor-pagenameform-go' => 'Pergi',
	'changeauthor-comment' => 'Komen:',
	'changeauthor-changeauthors-multi' => 'Tukar {{PLURAL:$1|pengarang|pengarang}}',
	'changeauthor-explanation-multi' => 'Dengan borang ini, anda boleh mengubah pengarang semakan.
Anda cuba perlu mengubah satu atau lebih nama pengguna dalam senarai di bawah, berikan komen (tidak wajib) dan klik butang "Tukar pengarang".',
	'changeauthor-changeauthors-single' => 'Tukar pengarang',
	'changeauthor-explanation-single' => 'Dengan borang ini, anda boleh mengubah pengarang semakan.
Anda cuba perlu mengubah nama pengguna di bawah, berikan komen (tidak wajib) dan klik butang "Tukar pengarang".',
	'changeauthor-invalid-username' => 'Nama pengguna "$1" tidak sah.',
	'changeauthor-nosuchuser' => 'Pengguna "$1" tidak wujud.',
	'changeauthor-revview' => 'Semakan #$1 daripada $2',
	'changeauthor-nosuchtitle' => 'Laman "$1" tidak wujud.',
	'changeauthor-weirderror' => 'Ralat yang amat pelik terjadi
Sila cuba lagi permohonan anda.
Jika ralat ini masih tidak reda, mungkin pangkalan data rosak.',
	'changeauthor-invalidform' => 'Sila gunakan borang yang disediakan oleh [[Special:ChangeAuthor|laman khas ini]] daripada sebarang borang tersuai.',
	'changeauthor-success' => 'Permohonan anda berjaya diproses.',
	'changeauthor-logentry' => 'Pengarang $2 dalam $1 diubah daripada $3 kepada $4',
	'changeauthor-logpagename' => 'Log perubahan pengarang',
	'changeauthor-rev' => 'r$1',
	'right-changeauthor' => 'Mengubah pengarang semakan',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'changeauthor-pagenameform-go' => 'Mur',
	'changeauthor-comment' => 'Kumment:',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'changeauthor-pagenameform-go' => 'Адя',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'changeauthor-pagenameform-go' => 'Yāuh',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author EivindJ
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'changeauthor' => 'Endre revisjonens opphavsperson',
	'changeauthor-desc' => 'Gjør det mulig å endre opphavsperson for sideversjoner',
	'changeauthor-title' => 'Endre en revisjons opphavsmann',
	'changeauthor-search-box' => 'Søk i revisjoner',
	'changeauthor-pagename-or-revid' => 'Sidenavn eller revisjons-ID:',
	'changeauthor-pagenameform-go' => 'Gå',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => 'Endre {{PLURAL:$1|forfatter|forfattere}}',
	'changeauthor-explanation-multi' => 'Med dette skjemaet kan du endre hvem som angis som opphavspersoner til revisjoner. Bare endre ett eller flere av brukernavnene i listen nedenfor, legg til en (valgfri) kommentar, og klikk knappen «Endre opphavsperson(er)».',
	'changeauthor-changeauthors-single' => 'Endre opphavsperson',
	'changeauthor-explanation-single' => 'Med dette skjemaet kan du endre på hvem som angis som opphavspersonen til en revisjon. Bare endre brukernavnet nedenfor, legg til en (valgfri) kommentar, og klikk knappen «Endre opphavsperson».',
	'changeauthor-invalid-username' => 'Ugyldig brukernavn «$1».',
	'changeauthor-nosuchuser' => 'Ingen bruker ved navnet «$1».',
	'changeauthor-revview' => 'Revisjon #$1 av $2',
	'changeauthor-nosuchtitle' => 'Det er ingen side ved navn «$1».',
	'changeauthor-weirderror' => 'En merkelig feil oppsto. Vennligst prøv igjen. Om denne feilen vedvarer er det trolig noe galt med databasen.',
	'changeauthor-invalidform' => 'Bruk skjemaet på [[Special:ChangeAuthor|spesialsiden]] i stedet for å bruke et egendefinert skjema.',
	'changeauthor-success' => 'Forespørselen har blitt utført.',
	'changeauthor-logentry' => 'Endret opphavsperson til $2 av $1 fra $3 til $4',
	'changeauthor-logpagename' => 'Logg for opphavspersonsendringer',
	'right-changeauthor' => 'Endre forfatteren av en versjon',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'changeauthor-pagenameform-go' => 'Los',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-nosuchuser' => 'Gifft keen Bruker „$1“.',
	'changeauthor-revview' => 'Version #$1 vun $2',
);

/** Nepali (नेपाली)
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'changeauthor-pagenameform-go' => 'जाउ',
	'changeauthor-comment' => 'टिप्पणी :',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'changeauthor' => 'Auteur versie wijzigen',
	'changeauthor-desc' => 'Maakt het mogelijk de auteur van een versie te wijzigen',
	'changeauthor-title' => 'De auteur van een bewerkingsversie wijzigen',
	'changeauthor-search-box' => 'Versies zoeken',
	'changeauthor-pagename-or-revid' => 'Paginanaam of versienummer:',
	'changeauthor-pagenameform-go' => 'OK',
	'changeauthor-comment' => 'Opmerking:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Auteur|Auteurs}} wijzigen',
	'changeauthor-explanation-multi' => "Met dit formulier kunt u de auteur van een bewerkingsversie wijzigen. Wijzig simpelweg één of meer gebruikersnamen in de lijst hieronder, voeg een toelichting toe (niet verplicht) en klik op de knop 'Auteur(s) wijzigen'.",
	'changeauthor-changeauthors-single' => 'Auteur wijzigen',
	'changeauthor-explanation-single' => "Met dit formulier kunt u de auteur van een bewerkingsversie wijzigen. Wijzig simpelweg de gebruikersnaam in het tekstvak hieronder, voeg een toelichting toe (niet verplicht) en klik op de knop 'Auteur wijzigen'.",
	'changeauthor-invalid-username' => 'Ongeldige gebruikersnaam "$1".',
	'changeauthor-nosuchuser' => 'Gebruiker "$1" bestaat niet.',
	'changeauthor-revview' => 'Bewerkingsnummer $1 van $2',
	'changeauthor-nosuchtitle' => 'Er is geen pagina "$1".',
	'changeauthor-weirderror' => 'Er is een erg vreemde fout opgetreden.
Probeer het nogmaals.
Als u deze foutmelding elke keer weer ziet, is er waarschijnlijk iets mis met de database.',
	'changeauthor-invalidform' => 'Gebruik het formulier van de [[Special:ChangeAuthor|speciale pagina]], in plaats van een aangepast formulier.',
	'changeauthor-success' => 'Uw verzoek is verwerkt.',
	'changeauthor-logentry' => 'Auteur van $2 van $1 gewijzigd van $3 naar $4',
	'changeauthor-logpagename' => 'Auteurswijzigingenlogboek',
	'right-changeauthor' => 'De auteur van een bewerking wijzigen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'changeauthor' => 'Endra versjonsforfattar',
	'changeauthor-desc' => 'Gjer det mogleg å endra forfattar for sideversjonar',
	'changeauthor-title' => 'Endra forfattar til sideversjon',
	'changeauthor-search-box' => 'Søk i versjonar',
	'changeauthor-pagename-or-revid' => 'Sidenamn eller versjons-ID:',
	'changeauthor-pagenameform-go' => 'Gå',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => 'Endra {{PLURAL:$1|forfattar|forfattarar}}',
	'changeauthor-explanation-multi' => 'Med dette skjemaet kan du endra kven som blir oppgjeve som forfattar til versjonar.
Endra eitt eller fleire av brukarnamna i lista nedanfor, legg til ein (valfri) kommentar og trykk knappen «Endra forfattar(ar)».',
	'changeauthor-changeauthors-single' => 'Endra forfattar',
	'changeauthor-explanation-single' => 'Med dette skjemaet kan du endra på kven som blir oppgjeve som forfattaren til ein versjon. Endra brukarnamnet nedanfor, legg til ein (valfri) kommentar, og trykk på knappen «Endra forfattar».',
	'changeauthor-invalid-username' => 'Brukarnamnet «$1» er ugyldig.',
	'changeauthor-nosuchuser' => 'Ingen brukar med namnet «$1».',
	'changeauthor-revview' => 'Versjon #$1 av $2',
	'changeauthor-nosuchtitle' => 'Det finst ikkje noka sida med namnet «$1».',
	'changeauthor-weirderror' => 'Ein merkeleg feil oppstod.
Prøv om att.
Om denne feilen held fram med å dukka opp, kan det vera noko gale med databasen.',
	'changeauthor-invalidform' => 'Nytt skjemaet på [[Special:ChangeAuthor|spesialsida]] og ikkje eit eigendefinert skjema.',
	'changeauthor-success' => 'Førespurnaden har blitt utført.',
	'changeauthor-logentry' => 'Endra forfattaren av $2 av $1 frå $3 til $4',
	'changeauthor-logpagename' => 'Logg for endring av forfattar',
	'right-changeauthor' => 'Endra forfattaren av ein versjon',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'changeauthor' => 'Fetola  poeletšo ya mongwadi',
	'changeauthor-title' => 'Fetola mongwadi wa poeletšo',
	'changeauthor-search-box' => 'Fetleka dipoeletšo',
	'changeauthor-pagename-or-revid' => 'Leina la letlaka goba ID ya poeletšo:',
	'changeauthor-pagenameform-go' => 'Sepela',
	'changeauthor-comment' => 'Ahlaahla:',
	'changeauthor-revview' => 'Poeletšo #$1 ya $2',
	'changeauthor-nosuchtitle' => 'Gago letlakala lago bitšwa  "$1".',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'changeauthor' => "Cambiar l'autor de las revisions",
	'changeauthor-desc' => 'Permet de cambiar lo nom de l’autor d’una o mantuna modificacions',
	'changeauthor-title' => "Cambiar l'autor d'una revision",
	'changeauthor-search-box' => 'Recercar de revisions',
	'changeauthor-pagename-or-revid' => "Títol de l'article o ID de revision :",
	'changeauthor-pagenameform-go' => 'Anar',
	'changeauthor-comment' => 'Comentari :',
	'changeauthor-changeauthors-multi' => 'Cambiar {{PLURAL:$1|autor|autors}}',
	'changeauthor-explanation-multi' => "Amb aqueste formulari, podètz cambiar los autors de las revisions. Modificat un o mantun nom d'utilizaire dins la lista, apondètz un comentari (facultatiu) e clicatz sul boton ''Cambiar autor(s)''.",
	'changeauthor-changeauthors-single' => "Cambiar l'autor",
	'changeauthor-explanation-single' => "Amb aqueste formulari, podètz cambiar l'autor d'una revision. Cambiatz lo nom d'autor çaijós, apondètz un comentari (facultatiu) e clicatz sul boton ''Cambiar l'autor''.",
	'changeauthor-invalid-username' => "Nom d'utilizaire « $1 » invalid.",
	'changeauthor-nosuchuser' => "Pas d'utilizaire « $1 »",
	'changeauthor-revview' => 'Revision #$1 de $2',
	'changeauthor-nosuchtitle' => 'Pas d\'article intitolat "$1"',
	'changeauthor-weirderror' => "Una error s'es producha. Ensajatz tornamai. Se aquesta error es apareguda mantun còp, la banca de donadas es probablament corrompuda.",
	'changeauthor-invalidform' => "Utilizatz lo formulari generit per [[Special:ChangeAuthor|la pagina especiala]] puslèu qu'un formulari personal",
	'changeauthor-success' => 'Vòstra requèsta es estada tractada amb succès.',
	'changeauthor-logentry' => "Modificacion de l'autor de $2 de $1 dempuèi $3 cap a $4",
	'changeauthor-logpagename' => "Jornal dels cambiaments faches per l'autor",
	'right-changeauthor' => "Modificar l'autor d'una revision",
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 */
$messages['or'] = array(
	'changeauthor-pagenameform-go' => 'ଯିବା',
	'changeauthor-comment' => 'ମତାମତ:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'changeauthor-pagenameform-go' => 'Guck uff',
	'changeauthor-comment' => 'Aamaericking:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author Leinad
 * @author Matma Rex
 * @author McMonster
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'changeauthor' => 'Zmień autora wersji',
	'changeauthor-desc' => 'Pozwala na zmianę autora wersji',
	'changeauthor-title' => 'Zmiana autora wersji artykułu',
	'changeauthor-search-box' => 'Szukaj wersji',
	'changeauthor-pagename-or-revid' => 'Nazwa strony lub ID wersji:',
	'changeauthor-pagenameform-go' => 'Dalej',
	'changeauthor-comment' => 'Powód zmiany autora:',
	'changeauthor-changeauthors-multi' => 'Zmień {{PLURAL:$1|autora|autorów}}',
	'changeauthor-explanation-multi' => "Tutaj możesz zmienić autora wersji artykułu.
Zmień jedną lub wiele nazw użytkowników na poniższej liście, dodaj komentarz (opcjonalny) i wciśnij przycisk 'Zmień autorów'.",
	'changeauthor-changeauthors-single' => 'Zmień autora',
	'changeauthor-explanation-single' => "Tutaj możesz zmienić autora wersji artykułu.
Zmień nazwę użytkownika na poniższej liście, dodaj komentarz (opcjonalny) i wciśnij przycisk 'Zmień autora'.",
	'changeauthor-invalid-username' => 'Niepoprawna nazwa użytkownika „$1”.',
	'changeauthor-nosuchuser' => 'Brak użytkownika „$1”.',
	'changeauthor-revview' => 'Wersja #$1 z $2',
	'changeauthor-nosuchtitle' => 'Brak strony „$1”.',
	'changeauthor-weirderror' => 'Wystąpił nieznany błąd.
Spróbuj powtórzyć polecenie.
Jeśli błąd wystąpi ponownie, prawdopodobnie uszkodzona jest baza danych.',
	'changeauthor-invalidform' => 'Zamiast tej strony co zazwyczaj użyj [[Special:ChangeAuthor|strony specjalnej]].',
	'changeauthor-success' => 'Twoje polecenie zostało wykonane z powodzeniem.',
	'changeauthor-logentry' => 'zmienił autora wersji $2 strony $1 z $3 na $4',
	'changeauthor-logpagename' => 'Rejestr zmiany autora',
	'right-changeauthor' => 'Zmiana autora wersji',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'changeauthor' => 'Cambia autor ëd la revision',
	'changeauthor-desc' => "A përmett ëd cambié l'autor ëd na revision",
	'changeauthor-title' => "Cambia l'autor ëd la revision",
	'changeauthor-search-box' => 'Serca revision',
	'changeauthor-pagename-or-revid' => 'Nòm pàgina o ID revision:',
	'changeauthor-pagenameform-go' => 'Va',
	'changeauthor-comment' => 'Coment:',
	'changeauthor-changeauthors-multi' => 'Cambia {{PLURAL:$1|autor|autor}}',
	'changeauthor-explanation-multi' => 'Con sta forma-sì it peule cambié j\'autor ëd la revision.
Cambia un o pì nòm utent ant la lista sota, gionta un coment (opsional) e sgnaca ël boton "Cambia autor".',
	'changeauthor-changeauthors-single' => 'Cambia autor',
	'changeauthor-explanation-single' => 'Con sta forma-sì it peule cambié l\'autor ëd na revision.
Cambia ël nòm utent sota, gionta un coment (opsional) e sgnaca ël boton "Cambia autor".',
	'changeauthor-invalid-username' => 'Stranòm "$1" pa bon.',
	'changeauthor-nosuchuser' => 'Pa gnun utent "$1".',
	'changeauthor-revview' => 'Revision #$1 ëd $2',
	'changeauthor-nosuchtitle' => 'A-i é pa gnun-e pàgine ciamà "$1".',
	'changeauthor-weirderror' => "A l'é capitaje n'eror motobin dròlo.
Për piasì arpet toa arcesta.
Se sto eror-sì a continua a ess-ie, a peul esse che ël database a sia rompù.",
	'changeauthor-invalidform' => "Për piasì, ch'a deuvra la forma dàita da la [[Special:ChangeAuthor|pàgina special]] nopà che na forma përsonalisà.",
	'changeauthor-success' => "Toa arcesta a l'é stàita tratà da bin.",
	'changeauthor-logentry' => 'Cambi autor ëd $2 ëd $1 da $3 a $4',
	'changeauthor-logpagename' => "Registr dij cangiament fàit da l'autor",
	'right-changeauthor' => "Cambia l'autor ëd na revision",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'changeauthor-pagenameform-go' => 'ورځه',
	'changeauthor-comment' => 'تبصره:',
	'changeauthor-changeauthors-single' => 'ليکوال بدلول',
	'changeauthor-nosuchtitle' => 'داسې هېڅ کوم مخ نشته چې نوم يې "$1" وي.',
	'changeauthor-success' => 'ستاسو غوښتنه په برياليتوب سره پلي شوه.',
);

/** Portuguese (Português)
 * @author 555
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'changeauthor' => 'Alterar autor de revisão',
	'changeauthor-desc' => 'Permite alterar o autor de uma revisão',
	'changeauthor-title' => 'Alterar o autor de uma revisão',
	'changeauthor-search-box' => 'Pesquisar revisões',
	'changeauthor-pagename-or-revid' => 'Nome da página ou ID da revisão:',
	'changeauthor-pagenameform-go' => 'Ir',
	'changeauthor-comment' => 'Comentário:',
	'changeauthor-changeauthors-multi' => 'Alterar {{PLURAL:$1|autor|autores}}',
	'changeauthor-explanation-multi' => "Através deste formulário, pode alterar os autores de revisões. Simplesmente mude um ou mais nomes de utilizador na lista abaixo, adicione um comentário (opcional) e clique no botão 'Alterar autor(es)'.",
	'changeauthor-changeauthors-single' => 'Alterar autor',
	'changeauthor-explanation-single' => "Através deste formulário, pode alterar o autor de uma revisão. Simplesmente mude o nome de utilizador abaixo, adicione um comentário (opcional) e clique no botão 'Alterar autor'.",
	'changeauthor-invalid-username' => 'Nome de utilizador "$1" inválido.',
	'changeauthor-nosuchuser' => 'O utilizador "$1" não existe.',
	'changeauthor-revview' => 'Revisão #$1 de $2',
	'changeauthor-nosuchtitle' => 'Não existe nenhuma página chamada "$1".',
	'changeauthor-weirderror' => 'Ocorreu um erro muito estranho. Por favor, tente o seu pedido de novo. Se este erro persistir, provavelmente a base de dados não está em boas condições.',
	'changeauthor-invalidform' => 'Por favor, utilize o formulário fornecido pela [[Special:ChangeAuthor|página especial]] em vez de um formulário personalizado.',
	'changeauthor-success' => 'O seu pedido foi processado com sucesso.',
	'changeauthor-logentry' => 'Alterado autor de $2 de $1, de $3 para $4',
	'changeauthor-logpagename' => 'Registo de alterações de autor',
	'right-changeauthor' => 'Alterar o autor de uma revisão',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'changeauthor' => 'Alterar autor de revisão',
	'changeauthor-desc' => 'Permite alterar o autor de uma revisão',
	'changeauthor-title' => 'Alterar o autor de uma revisão',
	'changeauthor-search-box' => 'Pesquisar revisões',
	'changeauthor-pagename-or-revid' => 'Nome da página ou ID da revisão:',
	'changeauthor-pagenameform-go' => 'Ir',
	'changeauthor-comment' => 'Comentário:',
	'changeauthor-changeauthors-multi' => 'Alterar {{PLURAL:$1|autor|autores}}',
	'changeauthor-explanation-multi' => "Através deste formulário, pode alterar os autores de revisões. Simplesmente mude um ou mais nomes de utilizador na lista abaixo, adicione um comentário (opcional) e clique no botão 'Alterar autor(es)'.",
	'changeauthor-changeauthors-single' => 'Alterar autor',
	'changeauthor-explanation-single' => "Através deste formulário, pode alterar o autor de uma revisão. Simplesmente mude o nome de utilizador abaixo, adicione um comentário (opcional) e clique no botão 'Alterar autor'.",
	'changeauthor-invalid-username' => 'Nome de utilizador "$1" inválido.',
	'changeauthor-nosuchuser' => 'Utilizador "$1" não existe.',
	'changeauthor-revview' => 'Revisão #$1 de $2',
	'changeauthor-nosuchtitle' => 'Não existe nenhuma página chamada "$1".',
	'changeauthor-weirderror' => 'Ocorreu um erro muito estranho.
Por favor, tente o seu pedido de novo.
Se este erro persistir, provavelmente a base de dados não está em boas condições.',
	'changeauthor-invalidform' => 'Por favor, utilize o formulário fornecido pela [[Special:ChangeAuthor|página especial]] em vez de um formulário personalizado.',
	'changeauthor-success' => 'O seu pedido foi processado com sucesso.',
	'changeauthor-logentry' => 'Alterado autor de $2 de $1, de $3 para $4',
	'changeauthor-logpagename' => 'Registro de alterações de autor',
	'right-changeauthor' => 'Alterar o autor de uma revisão',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'changeauthor' => "Llamk'apuqpa sutinta hukchay",
	'changeauthor-desc' => "Kaywanqa llamk'apuqpa sutinta hukchaytam atinki",
	'changeauthor-title' => "Llamk'apuqpa sutinta hukchay",
	'changeauthor-search-box' => 'Musuqchasqakunata maskay',
	'changeauthor-pagename-or-revid' => "P'anqap sutin icha musuqchasqap kikin huchhan:",
	'changeauthor-pagenameform-go' => 'Riy',
	'changeauthor-comment' => "Llamk'apuqpa nisqan pisichayta hukchay",
	'changeauthor-changeauthors-multi' => "{{PLURAL:$1|Llamk'apuqpa|Llamk'apuqkunap}} sutinta hukchay",
	'changeauthor-explanation-multi' => "Kay hunt'ana p'anqawanqa llamk'apuqkunap sutinkunata hukchaytam atinki.
Kay qatiq sutisuyupi ruraqkunap sutinkunata hukchaspa pisichay willaytachá yapaspa 'Llamk'apuqpa sutinta hukchay' nisqapi ñit'illay.",
	'changeauthor-changeauthors-single' => "Llamk'apuqpa sutinta hukchay",
	'changeauthor-explanation-single' => "Kay hunt'ana p'anqawanqa llamk'apuqpa sutinta hukchaytam atinki.
Kay qatiq ruraqpa sutinta hukchaspa pisichay willaytachá yapaspa 'Llamk'apuqpa sutinta hukchay' nisqapi ñit'illay.",
	'changeauthor-invalid-username' => '"$1" nisqa ruraqpa sutinqa manam allinchu.',
	'changeauthor-nosuchuser' => '"$1" sutiyuq ruraqqa manam kanchu.',
	'changeauthor-revview' => '$2-manta #$1 kaq musuqchasqa',
	'changeauthor-nosuchtitle' => '"$1" sutiyuq p\'anqaqa manam kanchu.',
	'changeauthor-weirderror' => 'Ancha wamaq pantasqam tukurqan.
Ama hina kaspa, musuqmanta mañaykachay.
Kay pantasqa musuqmanta kanqaptinqa, willañiqintin waqllisqachá.',
	'changeauthor-invalidform' => "Ama hina kaspa, [[Special:ChangeAuthor|sapaq p'anqa]] nisqap hunt'ana p'anqanta llamk'achiy, amataq sapsi p'anqatachu.",
	'changeauthor-success' => 'Mañakusqaykiqa aypalla rurapusqañam.',
	'changeauthor-logentry' => "$2-manta $1-pa llamk'apuqninpa sutinta $3-manta $4-man hukchasqa",
	'changeauthor-logpagename' => "Llamk'apuq suti hukchay hallch'asqa",
	'right-changeauthor' => "Llamk'apuqpa sutinta hukchay",
);

/** Tarifit (Tarifit)
 * @author Jose77
 */
$messages['rif'] = array(
	'changeauthor-pagenameform-go' => 'Raḥ ɣa',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'changeauthor' => 'Schimbă autorul reviziei',
	'changeauthor-title' => 'Schimbă autorul unei revizii',
	'changeauthor-search-box' => 'Caută revizii',
	'changeauthor-pagename-or-revid' => 'Numele paginii sau ID-ul reviziei:',
	'changeauthor-pagenameform-go' => 'Du-te',
	'changeauthor-comment' => 'Comentariu:',
	'changeauthor-changeauthors-multi' => 'Schimbă {{PLURAL:$1|autorul|autorii}}',
	'changeauthor-changeauthors-single' => 'Schimbă autorul',
	'changeauthor-invalid-username' => 'Nume de utilizator incorect "$1".',
	'changeauthor-nosuchuser' => 'Nu există utilizatorul "$1".',
	'changeauthor-revview' => 'Versiunea #$1 din $2',
	'changeauthor-nosuchtitle' => 'Nu există o pagină numită "$1".',
	'changeauthor-success' => 'Cererea ta a fost procesată cu succes.',
	'right-changeauthor' => 'Schimbă autorul unei revizii',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'changeauthor-pagenameform-go' => 'Veje',
	'changeauthor-comment' => 'Commende:',
	'changeauthor-changeauthors-single' => 'Cange autore',
	'changeauthor-nosuchtitle' => 'Non g\'esiste \'na pàgene chiamete "$1".',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'changeauthor' => 'Изменение автора правки',
	'changeauthor-desc' => 'Позволяет изменять автора правки',
	'changeauthor-title' => 'Изменение автора правки',
	'changeauthor-search-box' => 'Поиск правок',
	'changeauthor-pagename-or-revid' => 'Название статьи или идентификатор правки:',
	'changeauthor-pagenameform-go' => 'Поехали',
	'changeauthor-comment' => 'Примечание:',
	'changeauthor-changeauthors-multi' => 'Изменение {{PLURAL:$1|автора|авторов}}',
	'changeauthor-explanation-multi' => 'С помощью данной формы можно изменить авторов правок. Просто измените ниже одно или несколько имён участников, укажите пояснение (необязательно) и нажмите кнопку «Изменить автора(ов)».',
	'changeauthor-changeauthors-single' => 'Изменение автора',
	'changeauthor-explanation-single' => 'С помощью данной формы можно изменить автора правки. Просто измените ниже имя участника, укажите пояснение (необязательно) и нажмите кнопку «Изменить автора».',
	'changeauthor-invalid-username' => 'Недопустимое имя участника: $1',
	'changeauthor-nosuchuser' => 'Отсутствует участник $1.',
	'changeauthor-revview' => 'Версия #$1 из $2',
	'changeauthor-nosuchtitle' => 'Не существует статьи с названием «$1».',
	'changeauthor-weirderror' => 'Произошла очень странная ошибка. Пожалуйста, повторите свой запрос. Если ошибка снова возникнет, то вероятно это означает, что база данных испорчена.',
	'changeauthor-invalidform' => 'Пожалуйста, используйте форму на [[Special:ChangeAuthor|служебной странице]], а не какую-либо другую.',
	'changeauthor-success' => 'Запрос успешно обработан.',
	'changeauthor-logentry' => 'изменил автора $2 $1 с $3 на $4',
	'changeauthor-logpagename' => 'Журнал изменения авторов',
	'right-changeauthor' => 'изменение автора правки',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'changeauthor-pagenameform-go' => 'Выконати',
	'changeauthor-comment' => 'Коментарь:',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'changeauthor' => 'Көннөрүү ааптарын уларытыы',
	'changeauthor-desc' => 'Көннөрүү аапатарын уларытары хааччыйар',
	'changeauthor-title' => 'Көннөрүү ааптарын уларытыы',
	'changeauthor-search-box' => 'Барыллары көрдөөһүн',
	'changeauthor-pagename-or-revid' => 'Ыстатыйа аата эбэтэр көннөрүү нүөмэрэ:',
	'changeauthor-pagenameform-go' => 'Бардыбыт',
	'changeauthor-comment' => 'Комментарий:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Ааптары|Ааптардары}} уларытыы',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'changeauthor-pagenameform-go' => "Va'",
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'changeauthor' => 'Zmeniť autora revízie',
	'changeauthor-desc' => 'Umožňuje zmeniť autora revízie',
	'changeauthor-title' => 'Zmeniť autora revízie',
	'changeauthor-search-box' => 'Hľadať revízie',
	'changeauthor-pagename-or-revid' => 'Názov stránky alebo ID revízie:',
	'changeauthor-pagenameform-go' => 'Vykonať',
	'changeauthor-comment' => 'Komentár:',
	'changeauthor-changeauthors-multi' => 'Zmeniť {{PLURAL:$1|autora|autorov}}',
	'changeauthor-explanation-multi' => 'Pomocou tohto formulára môžete zmeniť autora revízie stránky. Jednoducho zmeňte jedno alebo viac mien používateľov v zozname nižšie, pridajte komentár (nepovinné) a kliknite na tlačidlo „Zmeniť autora“.',
	'changeauthor-changeauthors-single' => 'Zmeniť autora',
	'changeauthor-explanation-single' => 'Pomocou tohto formulára môžete zmeniť autora revízie stránky. Jednoducho zmeňte meno používateľa v zozname nižšie, pridajte komentár (nepovinné) a kliknite na tlačidlo „Zmeniť autora“.',
	'changeauthor-invalid-username' => 'Neplatné meno používateľa: „$1“.',
	'changeauthor-nosuchuser' => 'Taký používateľ neexistuje: „$1“.',
	'changeauthor-revview' => 'Revízia #$1 z $2',
	'changeauthor-nosuchtitle' => 'Stránka s názvom „$1“ neexistuje.',
	'changeauthor-weirderror' => 'Vyskytla sa veľmi zvláštna chyba. Prosím, skúste vašu požiadavku znova. Ak sa táto chyba bude vyskytovať opakovane, databáza je zrejme poškodená.',
	'changeauthor-invalidform' => 'Prosím, použite formulár na [[Special:ChangeAuthor|špeciálnej stránke]] radšej ako vlastný formulár.',
	'changeauthor-success' => 'Vaša požiadavka bola úspešne spracovaná.',
	'changeauthor-logentry' => 'Autor $2 z $1 bol zmenený z $3 na $4',
	'changeauthor-logpagename' => 'Záznam zmien autorov',
	'right-changeauthor' => 'Zmeniť autora revízie',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'changeauthor' => 'Spremeni avtorja redakcije',
	'changeauthor-desc' => 'Omogoča spreminjanje avtorja redakcije',
	'changeauthor-title' => 'Spreminjanje avtorja redakcije',
	'changeauthor-search-box' => 'Iskanje redakcij',
	'changeauthor-pagename-or-revid' => 'Ime strani ali ID redakcije:',
	'changeauthor-pagenameform-go' => 'Pojdi',
	'changeauthor-comment' => 'Pripomba:',
	'changeauthor-changeauthors-multi' => 'Spremeni {{PLURAL:$1|avtorja|avtorje}}',
	'changeauthor-explanation-multi' => 'S tem obrazcem lahko spremenite avtorje redakcije.
Na spodnjem seznamu preprosto spremenite eno ali več uporabniških imen, dodajte pripombo (po želji) in kliknite gumb »Spremeni avtorje«.',
	'changeauthor-changeauthors-single' => 'Spremeni avtorja',
	'changeauthor-explanation-single' => 'S tem obrazcem lahko spremenite avtorja redakcije.
Spodaj preprosto spremenite uporabniško ime, dodajte pripombo (po želji) in kliknite gumb »Spremeni avtorja«.',
	'changeauthor-invalid-username' => 'Neveljavno uporabniško ime »$1«.',
	'changeauthor-nosuchuser' => 'Uporabnik »$1« ne obstaja.',
	'changeauthor-revview' => 'Redakcija #$1 $2',
	'changeauthor-nosuchtitle' => 'Stran z imenom »$1« ne obstaja.',
	'changeauthor-weirderror' => 'Prišlo je do zelo nenavadne napake.
Prosimo, ponovite svojo zahtevo.
Če se ta napaka ne preneha pojavljati, je zbirka podatkov verjetno poškodovana.',
	'changeauthor-invalidform' => 'Namesto obrazca po meri, prosimo, uporabite obrazec na [[Special:ChangeAuthor|posebni strani]].',
	'changeauthor-success' => 'Vaša zahteva je bila uspešno obdelana.',
	'changeauthor-logentry' => 'je spremenil(-a) avtorja $2 strani $1 iz $3 v $4',
	'changeauthor-logpagename' => 'Dnevnik sprememb avtorjev',
	'right-changeauthor' => 'Spreminjanje avtorjev redakcij',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'changeauthor' => 'Промени аутора ревизије',
	'changeauthor-desc' => 'Омогући промене аутора ревизија',
	'changeauthor-title' => 'Промени аутора неке ревизије',
	'changeauthor-search-box' => 'Претражи измене',
	'changeauthor-pagename-or-revid' => 'Име странице или ИД ревизије:',
	'changeauthor-pagenameform-go' => 'Иди',
	'changeauthor-comment' => 'Коментар:',
	'changeauthor-changeauthors-multi' => 'Промени {{PLURAL:$1|аутора|ауторе}}',
	'changeauthor-changeauthors-single' => 'Промени аутора',
	'changeauthor-invalid-username' => 'Погрешно корисничко име "$1".',
	'changeauthor-nosuchuser' => 'Нема корисника "$1".',
	'changeauthor-revview' => 'Измена $1 од $2',
	'changeauthor-nosuchtitle' => 'Не постоји страница под називом "$1".',
	'changeauthor-success' => 'Баш захтев је био успешно обрађен.',
	'changeauthor-logentry' => 'Промењен аутор $2 на $1, са $3 на $4',
	'changeauthor-logpagename' => 'Историја промене аутора',
	'changeauthor-rev' => 'изм. $1',
	'right-changeauthor' => 'Промени аутора ревизије',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'changeauthor' => 'Promeni autora revizije',
	'changeauthor-desc' => 'Omogući promene autora revizija',
	'changeauthor-title' => 'Promeni autora neke revizije',
	'changeauthor-search-box' => 'Pretraži izmene',
	'changeauthor-pagename-or-revid' => 'Ime stranice ili ID revizije:',
	'changeauthor-pagenameform-go' => 'Idi',
	'changeauthor-comment' => 'Komentar:',
	'changeauthor-changeauthors-multi' => 'Promeni {{PLURAL:$1|autora|autore}}',
	'changeauthor-changeauthors-single' => 'Promeni autora',
	'changeauthor-invalid-username' => 'Pogrešno korisničko ime "$1".',
	'changeauthor-nosuchuser' => 'Nema korisnika "$1".',
	'changeauthor-revview' => 'Izmena $1 od $2',
	'changeauthor-nosuchtitle' => 'Ne postoji stranica pod nazivom "$1".',
	'changeauthor-success' => 'Baš zahtev je bio uspešno obrađen.',
	'changeauthor-logentry' => 'Promenjen autor $2 na $1, sa $3 na $4',
	'changeauthor-logpagename' => 'Istorija promene autora',
	'changeauthor-rev' => 'izm. $1',
	'right-changeauthor' => 'Promeni autora revizije',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'changeauthor' => 'Autor fon ne Version annerje',
	'changeauthor-desc' => 'Ferlööwet dän Autor, ne Version tou annerjen',
	'changeauthor-title' => 'Autor fon ne Revision annerje',
	'changeauthor-search-box' => 'Version säike',
	'changeauthor-pagename-or-revid' => 'Siedennoome of Versionsnummer',
	'changeauthor-pagenameform-go' => 'Säik',
	'changeauthor-comment' => 'Kommentoar:',
	'changeauthor-changeauthors-multi' => 'Uur {{PLURAL:$1|Autor|Autore}}',
	'changeauthor-explanation-multi' => 'Mäd dit Formular koast du do Autore fon do Versione annerje. Annere eenfach aan of moor Autorennoomen in ju Lieste, moak n Kommentoar (optionoal) un klik ap dän „Autor annerje“-Knoop.',
	'changeauthor-changeauthors-single' => 'Autor annerje',
	'changeauthor-explanation-single' => 'Mäd dit Formular koast du do Autoren fon ne Version annerje. Annerje eenfach dän Autorennoome in ju Lieste, beoarbaidje n Kommentoar (optionoal) un klik ap dän „Autor annerje“-Knoop.',
	'changeauthor-invalid-username' => 'Uungultige Benutsernoome „$1“.',
	'changeauthor-nosuchuser' => 'Dät rakt naan Benutser „$1“.',
	'changeauthor-revview' => 'Version #$1 fon $2',
	'changeauthor-nosuchtitle' => 'Dät rakt neen Siede „$1“.',
	'changeauthor-weirderror' => 'N gjucht säildenen Failer is aptreeden. Wierhoal dien Annerenge. Wan dissen Failer fonnäien apträt, is fermoudelk ju Doatenboank fernäild.',
	'changeauthor-invalidform' => 'Benutsje dät Formular ap ju [[Special:ChangeAuthor|Spezioalsiede]].',
	'changeauthor-success' => 'Dian Annerenge wuude mäd Ärfoulch truchfierd.',
	'changeauthor-logentry' => 'annerde Autorennoome fon ju $2 fon $1 fon $3 ap $4',
	'changeauthor-logpagename' => 'Autorennoome-Annerengslogbouk',
	'changeauthor-rev' => 'Version $1',
	'right-changeauthor' => 'Annerje dän Autor fon ne Revision',
);

/** Sundanese (Basa Sunda)
 * @author Kandar
 */
$messages['su'] = array(
	'changeauthor' => 'Robah panyusun révisi',
	'changeauthor-desc' => 'Pikeun ngarobah panyusun révisi',
	'changeauthor-title' => 'Robah panyusun révisi',
	'changeauthor-search-box' => 'Sungsi révisi',
	'changeauthor-pagename-or-revid' => 'Ngaran kaca atawa ID révisi:',
	'changeauthor-pagenameform-go' => 'Jung',
	'changeauthor-comment' => 'Pamanggih:',
	'changeauthor-changeauthors-multi' => 'Ganti {{PLURAL:$1|panulis|panulis}}',
	'changeauthor-explanation-multi' => "Ieu formulir dipaké pikeun ngarobah panyusun révisi.
Robah baé hiji atawa sababaraha landihan di handap ieu, tuliskeun pamanggih atawa alesan anjeun (teu wajib), lajeng klik tombol 'Robah panyusun'.",
	'changeauthor-changeauthors-single' => 'Robah panyusun',
	'changeauthor-explanation-single' => "Ieu formulir dipaké pikeun ngarobah panyusun révisi.
Robah baé landihan di handap, béré pamanggih atawa alesan anjeun (teu wajib), lajeng klik tombol 'Robah panyusun'.",
	'changeauthor-invalid-username' => 'Landihan "$1" teu sah.',
	'changeauthor-nosuchuser' => 'Euweuh pamaké "$1".',
	'changeauthor-revview' => 'Révisi #$1 ti $2',
	'changeauthor-nosuchtitle' => 'Euweuh kaca nu ngaranna "$1".',
	'changeauthor-weirderror' => 'Aya éror anu ahéng.
Coba ulang pamundut anjeun.
Mun tetep éror, meureun pangkalan datana ruksak.',
	'changeauthor-invalidform' => 'Paké formulir anu disadiakeun dina [[Special:ChangeAuthor|kaca husus]] batan maké formulir biasa.',
	'changeauthor-success' => 'Pamundut anjeun geus anggeus diolah.',
	'changeauthor-logentry' => 'Panyusun $2 geus robah dina $1, ti $3 jadi $4',
	'changeauthor-logpagename' => 'Log robahan panyusun',
	'right-changeauthor' => 'Ngaganti panulis hiji révisi',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'changeauthor' => 'Ändra upphovsman för sidversion',
	'changeauthor-desc' => 'Gör det möjligt att ändra upphovsman för sidversioner',
	'changeauthor-title' => 'Ändra upphovsman för en sidversion',
	'changeauthor-search-box' => 'Välj sidversion eller sida',
	'changeauthor-pagename-or-revid' => 'Sidnamn eller versions-ID:',
	'changeauthor-pagenameform-go' => 'Gå',
	'changeauthor-comment' => 'Kommentar:',
	'changeauthor-changeauthors-multi' => 'Ändra {{PLURAL:$1|författare|författare}}',
	'changeauthor-explanation-multi' => 'Med hjälp av det här formuläret kan du ändra upphovsmännen för sidversioner. Byt ut ett eller flera av användarnamnen i listan härunder, skriv (om du vill) en kommentar och tryck sedan på knappen "Ändra".',
	'changeauthor-changeauthors-single' => 'Ändra',
	'changeauthor-explanation-single' => 'Med hjälp av det här formuläret kan du ändra upphovsmannen för en sidversion. Byt ut användarnamnet härunder, skriv (om du vill) en kommentar och tryck sedan på knappen "Ändra".',
	'changeauthor-invalid-username' => 'Användarnamnet "$1" är ogiltigt.',
	'changeauthor-nosuchuser' => 'Det finns ingen användare med namnet "$1".',
	'changeauthor-revview' => 'Version #$1 av $2',
	'changeauthor-nosuchtitle' => 'Det finns ingen sida med namnet "$1".',
	'changeauthor-weirderror' => 'Ett mycket konstigt fel inträffade. Försök en gång till. Om samma fel upprepas så är databasen förmodligen trasig.',
	'changeauthor-invalidform' => 'Var vänlig använd formuläret som finns på [[Special:ChangeAuthor|specialsidan]], istället för ett formulär som någon annan skapat.',
	'changeauthor-success' => 'Upphovsmansändringen är genomförd.',
	'changeauthor-logentry' => 'ändrade upphovsman för $2 av $1 från $3 till $4',
	'changeauthor-logpagename' => 'Upphovsmansändringslogg',
	'right-changeauthor' => 'Ändra författaren för en version',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'changeauthor-search-box' => 'திருத்தங்களைத் தேடு',
	'changeauthor-pagename-or-revid' => 'பக்கத்தின் பெயர் அல்லது திருத்தத்தின் அடையாள எண்:',
	'changeauthor-pagenameform-go' => 'செல்',
	'changeauthor-comment' => 'கருத்து:',
	'changeauthor-changeauthors-single' => 'ஆசிரியரை மாற்றவும்',
	'changeauthor-nosuchuser' => '"$1" என்று ஒரு பயனர் இல்லை.',
	'changeauthor-nosuchtitle' => '"$1" என்று ஒரு பக்கம் இல்லை.',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Veeven
 * @author వైజాసత్య
 */
$messages['te'] = array(
	'changeauthor' => 'కూర్పు యొక్క రచయితని మార్చండి',
	'changeauthor-desc' => 'కూర్పు యొక్క రచయితని మార్చే వీలుకల్పిస్తుంది',
	'changeauthor-title' => 'కూర్పు రచయితని మార్చండి',
	'changeauthor-search-box' => 'కూర్పులను వెతకండి',
	'changeauthor-pagename-or-revid' => 'పేజీ పేరు లేదా కూర్పు ఐడీ:',
	'changeauthor-pagenameform-go' => 'వెళ్ళు',
	'changeauthor-comment' => 'వ్యాఖ్య:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|రచయితని|రచయితలను}} మార్చు',
	'changeauthor-explanation-multi' => 'ఈ ఫారము ద్వారా కూర్పు కర్తలను మార్చవచ్చు.
కింది జాబితాలోని వాడుకరిపేర్లను మార్చి, ఓ వ్యాఖ్య రాసి (ఐచ్ఛికం), "కర్త(ల)ను మార్చు" బొత్తాన్ని నొక్కండి.',
	'changeauthor-changeauthors-single' => 'రచయితను మార్చు',
	'changeauthor-explanation-single' => 'ఈ ఫారము ద్వారా ఏదైనా కూర్పు యొక్క కర్తను మార్చవచ్చు.
కింది జాబితాలోని వాడుకరిపేరును మార్చి, ఓ వ్యాఖ్య రాసి (ఐచ్ఛికం), "కర్తను మార్చు" బొత్తాన్ని నొక్కండి.',
	'changeauthor-invalid-username' => '"$1" అనేది తప్పుడు వాడుకరి పేరు.',
	'changeauthor-nosuchuser' => '"$1" అనే పేరుతో సభ్యులెవరూ లేరు.',
	'changeauthor-revview' => '$2 యొక్క #$1వ కూర్పు',
	'changeauthor-nosuchtitle' => '"$1" అనే పేరుతో పేజీ లేదు.',
	'changeauthor-weirderror' => 'చాలా చిత్రమైన లోపం దొర్లింది.
మీ అభ్యర్ధనను మళ్ళీ ప్రయత్నించండి.
ఈ లోపం మళ్ళీ మళ్ళీ ఎదురైతే, దానర్థం డేటాబేసు కుప్పకూలినట్లే.',
	'changeauthor-invalidform' => 'కస్టము ఫారం కాకుండా  [[Special:ChangeAuthor|ప్రత్యేక పేజీ]] అందించే ఫారము వాడండి.',
	'changeauthor-success' => 'మీ అభ్యర్థనని విజయవంతంగా పూర్తిచేసాం.',
	'changeauthor-logentry' => '$1 యొక్క $2 కి కర్తను $3 నుండి $4 కు మార్చాం',
	'changeauthor-logpagename' => 'రచయిత మార్పుల చిట్టా',
	'right-changeauthor' => 'కూర్పు యొక్క కర్తను మార్చు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'changeauthor-pagenameform-go' => 'Bá',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'changeauthor' => 'Тағйири муаллифи нусха',
	'changeauthor-desc' => 'Барои тағйир додани муаллифи нусха иҷозат медиҳад',
	'changeauthor-title' => 'Тағйир додани муаллифи нусха',
	'changeauthor-search-box' => 'Ҷустуҷӯи нусхаҳо',
	'changeauthor-pagename-or-revid' => 'Номи саҳифа ё нишонаи нусха:',
	'changeauthor-pagenameform-go' => 'Бирав',
	'changeauthor-comment' => 'Тавзеҳ:',
	'changeauthor-changeauthors-multi' => 'Тағйири муаллиф(он)',
	'changeauthor-explanation-multi' => "Бо ин форм шумо метавонед муаллифони нусхаро тағйир диҳед.
Басоддагӣ як ё якчанд номҳои корбариро дар феҳристи зер тағйир диҳед, тавзеҳотеро илова кунед (ихтиёрӣ) ва тугмаи 'Тағйири муаллиф(он)'-ро пахш кунед.",
	'changeauthor-changeauthors-single' => 'Тағйири муаллиф',
	'changeauthor-explanation-single' => "Бо ин форм шумо метавонед муаллифи нусхаеро тағйир диҳед. Басоддагӣ номи корбарии зерро тағйир диҳед, тавзеҳотеро илова кунед (ихтиёрӣ) ва тугмаи 'Тағйири муаллиф'-ро пахш кунед.",
	'changeauthor-invalid-username' => 'Номи корбарии номӯътабар "$1".',
	'changeauthor-nosuchuser' => 'Чунин корбар нест "$1".',
	'changeauthor-revview' => 'Нусхаи #$1 аз $2',
	'changeauthor-nosuchtitle' => 'Саҳифае бо унвони "$1" нест.',
	'changeauthor-weirderror' => 'Хатои хеле ғайриоддӣ рух дод.
Лутфан дубора дархости худро такрор кунед.
Агар ин хато такроран намоиш шавад, эҳтимолан пойгоҳи дода шикаста аст.',
	'changeauthor-invalidform' => 'Лутфан аз форми тавассути Special:ChangeAuthor истифода кунед, нисбат аз форми оддӣ.',
	'changeauthor-success' => 'Дархости шумо бо муваффақият пардозиш шуд.',
	'changeauthor-logentry' => 'Муаллифи $2 аз нусхаи $1 аз $3 ба $4 иваз шуд',
	'changeauthor-logpagename' => 'Гузориши тағйири муаллиф',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'changeauthor' => 'Taƣjiri muallifi nusxa',
	'changeauthor-desc' => 'Baroi taƣjir dodani muallifi nusxa içozat medihad',
	'changeauthor-title' => 'Taƣjir dodani muallifi nusxa',
	'changeauthor-search-box' => 'Çustuçūi nusxaho',
	'changeauthor-pagename-or-revid' => 'Nomi sahifa jo nişonai nusxa:',
	'changeauthor-pagenameform-go' => 'Birav',
	'changeauthor-comment' => 'Tavzeh:',
	'changeauthor-explanation-multi' => "Bo in form şumo metavoned muallifoni nusxaro taƣjir dihed.
Basoddagī jak jo jakcand nomhoi korbariro dar fehristi zer taƣjir dihed, tavzehotero ilova kuned (ixtijorī) va tugmai 'Taƣjiri muallif(on)'-ro paxş kuned.",
	'changeauthor-changeauthors-single' => 'Taƣjiri muallif',
	'changeauthor-explanation-single' => "Bo in form şumo metavoned muallifi nusxaero taƣjir dihed. Basoddagī nomi korbariji zerro taƣjir dihed, tavzehotero ilova kuned (ixtijorī) va tugmai 'Taƣjiri muallif'-ro paxş kuned.",
	'changeauthor-invalid-username' => 'Nomi korbariji nomū\'tabar "$1".',
	'changeauthor-nosuchuser' => 'Cunin korbar nest "$1".',
	'changeauthor-revview' => 'Nusxai #$1 az $2',
	'changeauthor-nosuchtitle' => 'Sahifae bo unvoni "$1" nest.',
	'changeauthor-weirderror' => 'Xatoi xele ƣajrioddī rux dod.
Lutfan dubora darxosti xudro takror kuned.
Agar in xato takroran namoiş şavad, ehtimolan pojgohi doda şikasta ast.',
	'changeauthor-success' => 'Darxosti şumo bo muvaffaqijat pardoziş şud.',
	'changeauthor-logentry' => 'Muallifi $2 az nusxai $1 az $3 ba $4 ivaz şud',
	'changeauthor-logpagename' => 'Guzorişi taƣjiri muallif',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'changeauthor-pagenameform-go' => 'Git',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'changeauthor' => 'May-akda ng pagbabago sa rebisyon',
	'changeauthor-desc' => 'Nagpapahintulot sa pagbago ng may-akda ng isang rebisyon',
	'changeauthor-title' => 'Baguhin ang may-akda ng isang rebisyon',
	'changeauthor-search-box' => 'Maghanap ng mga rebisyon',
	'changeauthor-pagename-or-revid' => 'Pangalan ng pahina o ID ng rebisyon:',
	'changeauthor-pagenameform-go' => 'Gawin na',
	'changeauthor-comment' => 'Puna:',
	'changeauthor-changeauthors-multi' => 'Nabagong {{PLURAL:$1|may-akda|mga may-akda}}',
	'changeauthor-explanation-multi' => "Sa pamamagitan ng pormularyong ito, mababago mo ang mga may-akda ng rebisyon.
Payak na baguhin lamang ang isa o higit pang mga pangalan ng tagagamit na nasa loob ng talaang nasa ibaba, magdagdag ng isang puna (maaaring wala nito) at pindutin ang pindutang 'Baguhin ang (mga) may-akda'.",
	'changeauthor-changeauthors-single' => 'Baguhin ang may-akda',
	'changeauthor-explanation-single' => "Sa pamamagitan ng pormularyong ito, mababago mo ang mga may-akda ng rebisyon.
Payak na baguhin lamang ang pangalan ng tagagamit na nasa ibaba, magdagdag ng isang puna (maaaring wala nito) at pindutin ang pindutang 'Baguhin ang may-akda'.",
	'changeauthor-invalid-username' => 'Hindi tanggap ang pangalan ng tagagamit na "$1".',
	'changeauthor-nosuchuser' => 'Walang ganyang tagagamit na "$1".',
	'changeauthor-revview' => 'Pagbabagong #$1 ng $2',
	'changeauthor-nosuchtitle' => 'Walang pahinang tinatawag na "$1".',
	'changeauthor-weirderror' => 'Naganap ang isang napakapambihirang kamalian.
Pakisubok muli ang iyong paghiling.
Kapag nagpatuloy sa paglitaw ang ganitong kamalian, may sira marahil ang kalipunan ng dato.',
	'changeauthor-invalidform' => 'Pakigamit ang pormularyong ibinigay ng [[Special:ChangeAuthor|natatanging pahina]] sa halip na ang isang pinasadyang pormularyo.',
	'changeauthor-success' => 'Matagumpay na naisagawa ang kahilingan mo.',
	'changeauthor-logentry' => 'Binago ang may-akda ng $2 na may $1 mula sa $3 na naging $4',
	'changeauthor-logpagename' => 'Talaan ng pagbago sa may-akda',
	'right-changeauthor' => 'Baguhin ang may-akda ng isang pagbabago',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 */
$messages['tr'] = array(
	'changeauthor' => 'Revizyon yazarını değiştir',
	'changeauthor-desc' => 'Bir revizyonun yazarını değiştirmeye izin verir',
	'changeauthor-title' => 'Bir revizyonun yazarını değiştir',
	'changeauthor-search-box' => 'Revizyonları ara',
	'changeauthor-pagename-or-revid' => 'Sayfa adı ya da revizyon IDsi:',
	'changeauthor-pagenameform-go' => 'Git',
	'changeauthor-comment' => 'Yorum:',
	'changeauthor-changeauthors-multi' => '{{PLURAL:$1|Yazarı|Yazarları}} değiştir',
	'changeauthor-explanation-multi' => "Bu form ile revizyon yazarlarını değiştirebilirsiniz.
Sadece, aşağıdaki listedeki bir ya da daha fazla kullanıcı adını değiştirin, bir yorum ekleyin (isteğe bağlı) ve 'Yazar(lar)ı değiştir' düğmesine tıklayın.",
	'changeauthor-changeauthors-single' => 'Yazarı değiştir',
	'changeauthor-explanation-single' => "Bu form ile revizyon yazarını değiştirebilirsiniz.
Sadece, aşağıdaki kullanıcı adını değiştirin, bir yorum ekleyin (isteğe bağlı) ve 'Yazarı değiştir' düğmesine tıklayın.",
	'changeauthor-invalid-username' => '"$1" geçersiz kullanıcı.',
	'changeauthor-nosuchuser' => 'Böyle bir kullanıcı yok "$1".',
	'changeauthor-revview' => '$2 sayfasının #$1 revizyonu',
	'changeauthor-nosuchtitle' => '"$1" isminde bir sayfa yok.',
	'changeauthor-weirderror' => 'Çok garip bir hata oluştu.
Lütfen isteğinizi tekrar deneyin.
Eğer bu hata görünmeye devam ederse, muhtemelen veritabanı bozulmuştur.',
	'changeauthor-invalidform' => 'Lütfen özel bir form yerine [[Special:ChangeAuthor|özel sayfa]] tarafından sağlanan formu kullanın.',
	'changeauthor-success' => 'İsteğiniz başarıyla işlendi.',
	'changeauthor-logentry' => '$1 sayfasının $2 revizyonu yazarı $3 iken $4 olarak değiştirildi',
	'changeauthor-logpagename' => 'Yazar değişim günlüğü',
	'right-changeauthor' => 'Bir revizyonun yazarını değiştir',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'changeauthor-pagenameform-go' => 'كۆچۈش',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'changeauthor-pagenameform-go' => 'Köchüsh',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'changeauthor' => 'Зміна автора редагування',
	'changeauthor-desc' => 'Дозволяє змінювати автора редагування',
	'changeauthor-title' => 'Зміна автора редагування',
	'changeauthor-search-box' => 'Пошук редагувань',
	'changeauthor-pagename-or-revid' => 'Назва статті або ідентифікатор редагування:',
	'changeauthor-pagenameform-go' => 'Уперед',
	'changeauthor-comment' => 'Коментар:',
	'changeauthor-changeauthors-multi' => 'Змінити {{PLURAL:$1|автора|авторів}}',
	'changeauthor-explanation-multi' => "За допомогою цієї форми можна змінити авторів редагувань.
Просто змініть нижче одне або кілька імен користувачів, зазначте пояснення (необов'язково) і натисніть кнопку «Змінити автора(ів)».",
	'changeauthor-changeauthors-single' => 'Змінити автора',
	'changeauthor-explanation-single' => "За допомогою цієї форми можна змінити автора редагування. просто змініть ім'я користувача, зазначте пояснення (необов'язково) і натисніть кнопку «Змінити автора».",
	'changeauthor-invalid-username' => "Недопустиме ім'я користувача: «$1».",
	'changeauthor-nosuchuser' => 'Нема користувача $1.',
	'changeauthor-revview' => 'Версія #$1 з $2',
	'changeauthor-nosuchtitle' => 'Нема сторінки з назвою «$1».',
	'changeauthor-weirderror' => 'Відбулася дуже дивна помилка.
Будь ласка, повторіть ваш запит.
Якщо помилка виникне знову, то це означає, що база даних імовірно зіпсована',
	'changeauthor-invalidform' => 'Будь ласка, використовуйте форму на [[Special:ChangeAuthor|спеціальній сторінці]], а не якусь іншу.',
	'changeauthor-success' => 'Ваш запити успішно оброблений.',
	'changeauthor-logentry' => 'Змінено автора $2 $1 з $3 на $4',
	'changeauthor-logpagename' => 'Журнал змін авторів',
	'right-changeauthor' => 'Зміна автора редагування',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'changeauthor-desc' => "Permete de canbiar l'autor de na version",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'changeauthor-pagenameform-go' => 'Tehta',
	'changeauthor-comment' => 'Kommentarii:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'changeauthor' => 'Đổi tác giả của phiên bản',
	'changeauthor-desc' => 'Cho phép thay đổi tác giả của một phiên bản',
	'changeauthor-title' => 'Đổi tác giả của một phiên bản',
	'changeauthor-search-box' => 'Tìm kiếm phiên bản',
	'changeauthor-pagename-or-revid' => 'Tên trang hay số phiên bản:',
	'changeauthor-pagenameform-go' => 'Tìm kiếm',
	'changeauthor-comment' => 'Lý do:',
	'changeauthor-changeauthors-multi' => 'Đổi {{PLURAL:$1||}}tác giả',
	'changeauthor-explanation-multi' => "Với mẫu này bạn có thể thay đổi tác giả phiên bản.
Chỉ cần thay đổi một hoặc nhiều tên người dùng trong danh sách phía dưới, thêm một lời chú thích (tùy chọn) và nhấn nút 'Đổi tác giả'.",
	'changeauthor-changeauthors-single' => 'Đổi tác giả',
	'changeauthor-explanation-single' => "Với mẫu này bạn có thể thay đổi tác giả phiên bản,
Chỉ cần thay đổi tên người dùng ở dưới, thêm một chú thích (tùy chọn) và nhấn vào nút 'Đổi tác giả'.",
	'changeauthor-invalid-username' => 'Tên người dùng “$1” không hợp lệ.',
	'changeauthor-nosuchuser' => 'Không có người dùng nào với tên “$1”.',
	'changeauthor-revview' => 'Phiên bản số $1 của $2',
	'changeauthor-nosuchtitle' => 'Không có trang nào với tên “$1”.',
	'changeauthor-weirderror' => 'Có lỗi lạ xuất hiện.
Xin hãy thử yêu cầu lại.
Nếu lỗi này tiếp tục hiện ra, có lẽ cơ sở dữ liệu đã bị tổn hại.',
	'changeauthor-invalidform' => 'Xin hãy dùng mẫu tại [[Special:ChangeAuthor|trang đặc biệt]] chứ đừng dùng mẫu tự tạo.',
	'changeauthor-success' => 'Yêu cầu của bạn đã được thực hiện xong.',
	'changeauthor-logentry' => 'Đã đổi tác giả của phiên bản $2 của trang $1 từ $3 thành $4',
	'changeauthor-logpagename' => 'Nhật trình thay đổi tác giả',
	'right-changeauthor' => 'Đổi tác giả của phiên bản',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'changeauthor' => 'Votükön lautani revida',
	'changeauthor-desc' => 'Dälon votükami revidalautana',
	'changeauthor-title' => 'Votükön revidalautani',
	'changeauthor-search-box' => 'Sukön revidis',
	'changeauthor-pagename-or-revid' => 'Padanem u revidanüm:',
	'changeauthor-pagenameform-go' => 'Ledunolöd',
	'changeauthor-comment' => 'Küpet:',
	'changeauthor-changeauthors-multi' => 'Votükön {{PLURAL:$1|lautani|lautanis}}',
	'changeauthor-explanation-multi' => 'Me fomet at kanol votükön revidalautanis.
Mutol te votükön gebananemi bal u plu bali pö lised dono, penön küpeti (if vilol) e välön knopi: „Votükön lautani(s)“.',
	'changeauthor-changeauthors-single' => 'Votükön lautani',
	'changeauthor-explanation-single' => 'Me fomet at kanol votükön revidalautani.
Mutol te votükön gebananemi dono, penön küpeti (if vilol) e välön knopi: „Votükön lautani“.',
	'changeauthor-invalid-username' => 'Gebananem no lonöföl: „$1“.',
	'changeauthor-nosuchuser' => 'Geban: „$1“ no dabinon.',
	'changeauthor-revview' => 'Revid #$1 se $2',
	'changeauthor-nosuchtitle' => 'No dabinon pad tiädü „$1“.',
	'changeauthor-weirderror' => 'Pöl vemo bisarik ejenon.
Steifülolös dönu.
If pöl at dönu ojenon, nünodem ba edädikon.',
	'changeauthor-invalidform' => 'Gebolös fometi su [[Special:ChangeAuthor|pad patik]], no votiki.',
	'changeauthor-success' => 'Beg olik peledunon benosekiko.',
	'changeauthor-logentry' => 'Lautan revida: $2 pada: $1 pevotükön de: $3 ad: $4.',
	'changeauthor-logpagename' => 'Jenotalised lautanivotükamas',
	'right-changeauthor' => 'Votükön revidalautani',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'changeauthor-pagenameform-go' => 'גיין',
);

/** Cantonese (粵語)
 * @author Shinjiman
 */
$messages['yue'] = array(
	'changeauthor' => '改修訂嘅作者',
	'changeauthor-desc' => '容許去改修訂嘅作者',
	'changeauthor-title' => '改一個修訂嘅作者',
	'changeauthor-search-box' => '搵修訂',
	'changeauthor-pagename-or-revid' => '頁名或修訂 ID:',
	'changeauthor-pagenameform-go' => '去',
	'changeauthor-comment' => '註解:',
	'changeauthor-changeauthors-multi' => '改作者',
	'changeauthor-explanation-multi' => '用嘅個表你可以去改修訂嘅作者。
只需要響下面個表度改一位或多位嘅用戶名，加入註解（選擇性）再撳個「改作者」掣。',
	'changeauthor-changeauthors-single' => '改作者',
	'changeauthor-explanation-single' => '用呢個表格你可以去改一次修訂嘅作者。
只需要響下面改一位用戶名，加入註解（選擇性）再撳個「改作者」掣。',
	'changeauthor-invalid-username' => '唔正確嘅用戶名 "$1".',
	'changeauthor-nosuchuser' => '無呢位用戶 "$1".',
	'changeauthor-revview' => '$2 嘅修訂 #$1',
	'changeauthor-nosuchtitle' => '呢度係無一版係叫 "$1".',
	'changeauthor-weirderror' => '一個好奇怪嘅錯誤發生咗。
請重試你嘅請求。
如果個錯誤係不斷出現嘅，個資料庫可能係壞咗。',
	'changeauthor-invalidform' => '請用 Special:ChangeAuthor 畀嘅表格，唔好用自定表格。',
	'changeauthor-success' => '你嘅請求已經成功噉處理好。',
	'changeauthor-logentry' => '改咗 $1 嘅 $2 由 $3 到 $4',
	'changeauthor-logpagename' => '作者更動日誌',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Chenxiaoqino
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'changeauthor' => '更改修订版本作者',
	'changeauthor-desc' => '更改指定修订版本的作者',
	'changeauthor-title' => '更换特定修订版本作者',
	'changeauthor-search-box' => '寻找修定版本',
	'changeauthor-pagename-or-revid' => '页面名称或修定版本号码：',
	'changeauthor-pagenameform-go' => '提交',
	'changeauthor-comment' => '理由：',
	'changeauthor-changeauthors-multi' => '变更{{PLURAL:$1|作者|作者们}}',
	'changeauthor-explanation-multi' => '您可以在这个表单中更改任一修订版本的作者。
更改完成后请输入更改理由并按下“{{int:changeauthor-changeauthors-single}}”以完成更改。',
	'changeauthor-changeauthors-single' => '更改作者',
	'changeauthor-explanation-single' => '您可以在这个表单中更改修订版本的作者。
更改完成后请输入更改理由并按下“{{int:changeauthor-changeauthors-single}}”以完成更改。',
	'changeauthor-invalid-username' => '错误的用户名："$1"。',
	'changeauthor-nosuchuser' => '用户“$1”不存在。',
	'changeauthor-revview' => '页面“$2”的修订版本#$1',
	'changeauthor-nosuchtitle' => '页面“$1”不存在。',
	'changeauthor-weirderror' => '发生错误，请重试。如果错误仍持读发生，数据库可能遭到损坏。',
	'changeauthor-invalidform' => '请使用[[Special:ChangeAuthor]]的表单处理，谢谢。',
	'changeauthor-success' => '处理完成',
	'changeauthor-logentry' => '更改[[$1]]修订版本$2的作者从 $3 到 $4',
	'changeauthor-logpagename' => '作者更改日志',
	'right-changeauthor' => '更换特定修订版本作者',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Alex S.H. Lin
 * @author Horacewai2
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'changeauthor' => '更改修訂版本作者',
	'changeauthor-desc' => '更改指定修訂版本的作者',
	'changeauthor-title' => '更換特定修訂版本作者',
	'changeauthor-search-box' => '尋找修定版本',
	'changeauthor-pagename-or-revid' => '頁面名稱或修定版本號碼：',
	'changeauthor-pagenameform-go' => '尋找',
	'changeauthor-comment' => '理由：',
	'changeauthor-changeauthors-multi' => '更改{{PLURAL:$1|作者|作者}}',
	'changeauthor-explanation-multi' => '您可以在這個表單中更改任一修訂版本的作者。
更改完成後請輸入更改理由並按下「{{int:changeauthor-changeauthors-single}}」以完成更改。',
	'changeauthor-changeauthors-single' => '更改作者',
	'changeauthor-explanation-single' => '您可以在這個表單中更改修訂版本的作者。
更改完成後請輸入更改理由並按下「{{int:changeauthor-changeauthors-single}}」以完成更改。',
	'changeauthor-invalid-username' => '錯誤的使用者名稱："$1"。',
	'changeauthor-nosuchuser' => '使用者名稱「$1」不存在。',
	'changeauthor-revview' => '頁面「$2」的修訂版本#$1',
	'changeauthor-nosuchtitle' => '頁面「$1」不存在。',
	'changeauthor-weirderror' => '發生錯誤，請重試。如果錯誤仍持讀發生，資料庫可能遭到損壞。',
	'changeauthor-invalidform' => '請使用[[Special:ChangeAuthor]]的表單處理，謝謝。',
	'changeauthor-success' => '處理完成',
	'changeauthor-logentry' => '更改[[$1]]修訂版本$2的作者從 $3 到 $4',
	'changeauthor-logpagename' => '作者更改日誌',
	'right-changeauthor' => '更換特定修訂版本作者',
);

