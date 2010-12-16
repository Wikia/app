<?php
/**
 * SpecialForm.i18n.php -- I18N for form-based interface to start new pages
 * Copyright 2007 Vinismo, Inc. (http://vinismo.com/)
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Evan Prodromou <evan@vinismo.com>
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Evan Prodromou <evan@vinismo.com>
 */
$messages['en'] = array(
	'form-desc'                    => 'A [[Special:Form|form interface]] to start new pages',
	'form'                         => 'Form',
	'formnoname'                   => 'No form name',
	'formnonametext'               => 'You must provide a form name, like "Special:Form/Nameofform".',
	'formbadname'                  => 'Bad form name',
	'formbadnametext'              => 'There is no form by that name.',
	'formpattern'                  => '$1-form',
	'formtemplatepattern'          => '$1', # Do not translate this message
	'formtitlepattern'             => 'Add new $1',
	'formsave'                     => 'Save',
	'formindexmismatch-title'      => 'Name pattern and template mismatch',
	'formindexmismatch'            => 'This form has mismatched name patterns and templates starting at index $1.',
	'formarticleexists'            => 'Page exists',
	'formarticleexiststext'        => 'The page [[$1]] already exists.',
	'formbadpagename'              => 'Bad page name',
    'formbadrecaptcha'             => 'Incorrect values for reCaptcha. Try again.',
	'formbadpagenametext'          => 'The form data you entered makes a bad page name, "$1".',
	'formrequiredfielderror'       => 'The {{PLURAL:$2|field $1 is|fields $1 are}} required for this form.
Please fill {{PLURAL:$2|it|them}} in.',
	'formsavesummary'              => 'New page using [[Special:Form/$1|form $1]]',
	'formsaveerror'                => 'Error saving form',
	'formsaveerrortext'            => 'There was an unknown error saving page \'$1\'.',
);

/** Message documentation (Message documentation)
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'form-desc' => 'Short description of the Form extension, shown on [[Special:Version]]. Do not translate or change links.',
	'formpattern' => 'The pattern of page names of form definitions. $1 is a given name for a form definition.',
	'formsave' => '{{Identical|Save}}',
	'formrequiredfielderror' => '* $1 is a comma separated list of missing fields
* $2 is the number of missing fields',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 */
$messages['af'] = array(
	'formsave' => 'Stoor',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'formsave' => 'Alzar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'form-desc' => '[[Special:Form|واجهة استمارة]] لبدء الصفحات الجديدة',
	'form' => 'استمارة',
	'formnoname' => 'لا اسم استمارة',
	'formnonametext' => 'يجب أن توفر اسم استمارة، مثل "Special:Form/Nameofform".',
	'formbadname' => 'اسم استمارة سيء',
	'formbadnametext' => 'لا توجد استمارة بهذا الاسم.',
	'formpattern' => '$1-استمارة',
	'formtitlepattern' => 'أضف $1 جديدا',
	'formsave' => 'احفظ',
	'formindexmismatch-title' => 'نمط الاسم والقالب لا يتطابقان',
	'formindexmismatch' => 'هذه الاستمارة بها أنماط أسماء وقوالب غير متطابقة بدءا عند الفهرس $1.',
	'formarticleexists' => 'الصفحة موجودة',
	'formarticleexiststext' => 'الصفحة [[$1]] موجودة بالفعل.',
	'formbadpagename' => 'اسم صفحة سيء',
	'formbadrecaptcha' => 'قيم غير صحيحة لreCaptcha. حاول مرة ثانية.',
	'formbadpagenametext' => 'بيانات الاستمارة التي أدخلتها تصنع اسم صفحة سيئا، "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2||الحقل $1 مطلوب|الحقلان $1 مطلوبان|الحقول $1 مطلوبة}} لهذه الاستمارة.
من فضلك {{PLURAL:$2||املأه|املأهما|املأها}}.',
	'formsavesummary' => 'صفحة جديدة باستخدام [[Special:Form/$1|الاستمارة $1]]',
	'formsaveerror' => 'خطأ في حفظ الاستمارة',
	'formsaveerrortext' => "حدث خطأ غير معروف أثناء حفظ الاستمارة '$1'.",
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'form-desc' => '[[Special:Form|واجهة استمارة]] لبدء الصفحات الجديدة',
	'form' => 'استمارة',
	'formnoname' => 'لا اسم استمارة',
	'formnonametext' => 'يجب أن توفر اسم استمارة، مثل "Special:Form/Nameofform".',
	'formbadname' => 'اسم استمارة سيء',
	'formbadnametext' => 'لا توجد استمارة بهذا الاسم.',
	'formpattern' => '$1-استمارة',
	'formtitlepattern' => 'أضف $1 جديدا',
	'formsave' => 'حفظ',
	'formindexmismatch-title' => 'نمط الاسم والقالب لا يتطابقان',
	'formindexmismatch' => 'هذه الاستمارة بها أنماط أسماء وقوالب غير متطابقة بدءا عند الفهرس $1.',
	'formarticleexists' => 'الصفحة موجودة',
	'formarticleexiststext' => 'الصفحة [[$1]] موجودة بالفعل.',
	'formbadpagename' => 'اسم صفحة سيء',
	'formbadrecaptcha' => 'قيم غير صحيحة لreCaptcha. حاول مرة ثانية.',
	'formbadpagenametext' => 'بيانات الاستمارة التى أدخلتها تصنع اسم صفحة سيئا، "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|الحقل $1 مطلوب|الحقول $1 مطلوبة}} لهذه الإستمارة.
من فضلك {{PLURAL:$2|املأه|املأها}}.',
	'formsavesummary' => 'صفحة جديدة باستخدام [[Special:Form/$1|الاستمارة $1]]',
	'formsaveerror' => 'خطأ فى حفظ الاستمارة',
	'formsaveerrortext' => "حدث خطأ غير معروف أثناء حفظ الاستمارة '$1'.",
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'formtitlepattern' => 'Magdugang nin Bâgong $1',
	'formsave' => 'Itagama',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'form-desc' => '[[Special:Form|Форма інтэрфэйсу]] для стварэньня новых старонак',
	'form' => 'Форма',
	'formnoname' => 'Няма назвы формы',
	'formnonametext' => 'Вам трэба падаць назву формы, напрыклад, «Special:Form/Назва_формы».',
	'formbadname' => 'Няслушная назва формы',
	'formbadnametext' => 'Няма формы з такой назвай.',
	'formpattern' => 'форма $1',
	'formtitlepattern' => 'Дадаць новую $1',
	'formsave' => 'Захаваць',
	'formindexmismatch-title' => 'Узор назвы і шаблён не спалучаюцца',
	'formindexmismatch' => 'Гэтая форма ўтрымлівае ўзоры назваў і шаблёнаў, якія не спалучаюцца, пачынаючы зь індэксу $1.',
	'formarticleexists' => 'Старонка існуе',
	'formarticleexiststext' => 'Старонка [[$1]] ужо існуе.',
	'formbadpagename' => 'Няслушная назва старонкі',
	'formbadrecaptcha' => 'Памылковыя значэньні reCaptcha. Паспрабуйце ізноў.',
	'formbadpagenametext' => 'Зьвесткі, якія Вы ўвялі ў форме, робяць назву старонкі няслушнай, «$1».',
	'formrequiredfielderror' => 'У гэтай форме {{PLURAL:$2|патрабуецца поле|патрабуюцца палі}} $1.
Калі ласка, запоўніце {{PLURAL:$2|яго|іх}}.',
	'formsavesummary' => 'Новая старонка створаная з дапамогай [[Special:Form/$1|формы $1]]',
	'formsaveerror' => 'Памылка захаваньня формы',
	'formsaveerrortext' => "Адбылася невядомая памылка пад час захаваньня старонкі '$1'.",
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'form-desc' => '[[Special:Form|Формуляр]] за започване на нови страници',
	'form' => 'Формуляр',
	'formnoname' => 'Липсва име на формуляра',
	'formnonametext' => 'Необходимо е да се посочи име на формуляр, напр. „Special:Form/ИмеНаФормуляр“',
	'formbadname' => 'Грешно име на формуляр',
	'formbadnametext' => 'Не съществува формуляр с това име.',
	'formsave' => 'Съхранение',
	'formarticleexists' => 'Страницата съществува',
	'formarticleexiststext' => 'Страницата [[$1]] вече съществува.',
	'formbadpagename' => 'Грешно име на страница',
	'formbadrecaptcha' => 'Неправилни стойности за reCaptcha. Опитайте отново.',
	'formrequiredfielderror' => 'Този формуляр изисква {{PLURAL:$2|полето $1 да бъде попълнено|полетата $1 да бъдат попълнени}}.
Необходимо е да {{PLURAL:$2|го попълните|ги попълните}}.',
	'formsaveerror' => 'Грешка при съхранение на формуляра',
	'formsaveerrortext' => "Възникна непозната грешка при опит да се съхрани страницата '$1'.",
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'form-desc' => 'নতুন পাতা শুরু করতে [[Special:Form|ফরম ইন্টারফেস]]',
	'form' => 'ফরম',
	'formnoname' => 'কোনো ফরম নাম নাই',
	'formbadname' => 'মন্দ ফরম নাম',
	'formbadnametext' => 'এই নামে কোনো ফরম নাই।',
	'formpattern' => '$1-ফরম',
	'formtitlepattern' => 'নতুন $1 যোগ',
	'formsave' => 'সংরক্ষণ',
	'formarticleexists' => 'পাতা রয়েছে',
	'formbadpagename' => 'পাতার মন্দ নাম',
	'formsaveerror' => 'ফরম সংরক্ষণে ত্রুটি',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'form-desc' => 'Un [[Special:Form|etrefas furmskrid]] evit kregiñ gant pajennoù nevez',
	'form' => 'Furmskrid',
	'formnoname' => 'Anv ebet',
	'formnonametext' => 'Roit anv ar furmskrid, gant ar stumm "Ispisial:Furmskrid/AnvArFurmskrid".',
	'formbadname' => 'Anv furmskrid fall',
	'formbadnametext' => "N'eus furmskrid ebet gant an anv-se.",
	'formpattern' => 'furmskrid-$1',
	'formtitlepattern' => 'Ouzhpennañ un $1 nevez',
	'formsave' => 'Enrollañ',
	'formindexmismatch-title' => 'Ne glot ket livaoueg an anvioù gant ar patrom',
	'formindexmismatch' => 'Ar furm skrid-mañ en deus patromoù ne glotont ket adalek $1.',
	'formarticleexists' => 'Ar bajenn zo anezhi dija',
	'formarticleexiststext' => 'Ar bajenn [[$1]] zo anezhi dija.',
	'formbadpagename' => 'Anv fall evit ar bajenn',
	'formbadrecaptcha' => 'Talvoudoù fall evit reCaptcha. Klaskit adarre.',
	'formbadpagenametext' => 'Ar roadennoù o peus lakaet a grou un anv fall evit ar bajenn,  "$1".',
	'formrequiredfielderror' => "Ezhomm 'zo eus ar maezienn{{PLURAL:$2||où}} $1 er furmskrid.
Mar plij leunit {{PLURAL:$2|anezhañ|anezho}}.",
	'formsavesummary' => "Pajenn nevez oc'h implijout  [[Special:Form/$1|ar furmskrid $1]]",
	'formsaveerror' => 'Fazi en ur enrollañ ar furmskrid',
	'formsaveerrortext' => 'Ur fazi a ro bet pa veze enrollet ar bajenn "$1".',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'form-desc' => '[[Special:Form|Interfejs obrazac]] za započinjanje novih stranica',
	'form' => 'Obrazac',
	'formnoname' => 'Nema imena obrasca',
	'formnonametext' => 'Morate navesti naziv obrasca, poput "Special:Form/Nameofform".',
	'formbadname' => 'Loš naziv obrasca',
	'formbadnametext' => 'Ne postoji obrazac s takvim imenom.',
	'formpattern' => '$1-obrazac',
	'formtitlepattern' => 'Dodaj novi $1',
	'formsave' => 'Sačuvaj',
	'formindexmismatch-title' => 'Naslov šeme i šablona se ne podudaraju',
	'formindexmismatch' => 'Ovaj obrazac ne odgovara šemi imena i šablona koja započinje indeksom $1.',
	'formarticleexists' => 'Stranica postoji',
	'formarticleexiststext' => 'Stranica [[$1]] već postoji.',
	'formbadpagename' => 'Loš naziv stranice',
	'formbadrecaptcha' => 'Netačne vrijednosti za reCaptcha. Pokušajte ponovno.',
	'formbadpagenametext' => 'Podaci iz obrasca koje ste unijeli su napravili pogrešno ime stranice, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Polje $1 je neophodno|Polja $1 su neophodna}} za ovaj obrazac.
Molimo popunite {{PLURAL:$2|ga|ih}}.',
	'formsavesummary' => 'Nova stranica koristeći [[Special:Form/$1|obrazac $1]]',
	'formsaveerror' => 'Greška pri spremanju obrasca',
	'formsaveerrortext' => "Desila se nepoznata greška pri spremanju stranice '$1'.",
);

/** Catalan (Català)
 * @author Paucabot
 */
$messages['ca'] = array(
	'form' => 'Formulari',
	'formbadname' => 'Nom del formulari incorrecte',
	'formtitlepattern' => 'Afegeix un nou $1',
	'formsave' => 'Desa',
	'formsaveerror' => 'Error desant el formulari',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'form' => 'Formulář',
	'formnoname' => 'Nebyl zadán název formuláře',
	'formnonametext' => 'Musíte zadat název formuláře ve tavru „Special:Form/Názevformuláře“',
	'formbadname' => 'Špatný název formuláře',
	'formbadnametext' => 'Formulář se zadaným názvem neexistuje',
	'formpattern' => 'formulář-$1',
	'formtitlepattern' => 'Přidat nový $1',
	'formsave' => 'Uložit',
	'formarticleexists' => 'Stránka existuje',
	'formarticleexiststext' => 'Stránka [[$1]] už existuje',
	'formbadpagename' => 'Špatný název stránky',
	'formbadpagenametext' => "Údaj formuláře, který jste zadali tvoří chybný název stránky - ''$1''.",
	'formrequiredfielderror' => 'Pole $1 {{plural:$2|je v tomto formuláři vyžadováno|jsou v tomto formuláři vyžadována}}.
Prosíme, vyplňte {{plural:$2|jej|je}}.',
	'formsavesummary' => 'Nová stránka pomocí [[Special:Form/$1|formuláře $1]]',
	'formsaveerror' => 'Chyba při ukládání formuláře',
	'formsaveerrortext' => "Při ukládání formuláře se vyskytla neznámá chyba: ''$1''.",
);

/** German (Deutsch)
 * @author Als-Holder
 * @author Melancholie
 * @author Umherirrender
 */
$messages['de'] = array(
	'form-desc' => 'Eine [[Special:Form|Eingabemaske]] für das Erzeugen von neuen Seiten',
	'form' => 'Formular',
	'formnoname' => 'Kein Formularname',
	'formnonametext' => 'Du musst einen Formularnamen angeben, z. B. „{{#special:Form}}/Formularname“.',
	'formbadname' => 'Falscher Formularname',
	'formbadnametext' => 'Es gibt kein Formular mit diesem Namen.',
	'formpattern' => '$1-Formular',
	'formtitlepattern' => 'Füge neue $1 hinzu',
	'formsave' => 'Speichern',
	'formindexmismatch-title' => 'Ungleichgewicht zwischen Namensmustern und Vorlagen',
	'formindexmismatch' => 'Dieses Formular hat ein Ungleichgewicht zwischen Namensmustern und Vorlagen, beginnend bei Index $1.',
	'formarticleexists' => 'Seite bereits vorhanden',
	'formarticleexiststext' => 'Die Seite „[[$1]]“ ist bereits vorhanden.',
	'formbadpagename' => 'Unzulässiger Seitenname',
	'formbadrecaptcha' => 'Ungültige Werte für reCaptcha. Versuche es nochmals.',
	'formbadpagenametext' => 'Die eingegebenen Formulardaten erzeugen einen unzulässigen Seitennamen: „$1“.',
	'formrequiredfielderror' => '{{PLURAL:$2|Das Feld $1 ist ein Pfichtfeld|Die Felder $1 sind Pfichtfelder}}.
Bitte fülle {{PLURAL:$2|es|sie}} aus.',
	'formsavesummary' => 'Neue Seite, die auf dem [[Special:Form/$1|Formular $1]] basiert',
	'formsaveerror' => 'Fehler beim Speichern des Formulares',
	'formsaveerrortext' => 'Es gab einen unbekannten Fehler beim Speichern der Seite „$1“.',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Imre
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'formnonametext' => 'Sie müssen einen Formularnamen angeben, z. B. „{{#special:Form}}/Formularname“.',
	'formrequiredfielderror' => '{{PLURAL:$2|Das Feld $1 ist ein Pfichtfeld|Die Felder $1 sind Pfichtfelder}}.
Bitte füllen Sie {{PLURAL:$2|es|sie}} aus.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'form-desc' => '[[Special:Form|Formular]] za napóranje nowych bokow',
	'form' => 'Formular',
	'formnoname' => 'Žedne formularowe mě',
	'formnonametext' => 'Musyš formularowe mě pódaś, na pś. "Special:Form/Měformulara".',
	'formbadname' => 'Wopacne formularowe mě',
	'formbadnametext' => 'Njejo formular z tym mjenim.',
	'formpattern' => '$1-formular',
	'formtitlepattern' => 'Nowy $1 pśidaś',
	'formsave' => 'Składowaś',
	'formindexmismatch-title' => 'Mjenjowy muster a pśedłog se njewótpowědujotej',
	'formindexmismatch' => 'Toś ten formular ma njejadnake mjenjowe mustry a pśedłogi, zachopinajucy se wót indeksa $1.',
	'formarticleexists' => 'Bok eksistěrujo',
	'formarticleexiststext' => 'bok [[$1]] južo eksistěrujo.',
	'formbadpagename' => 'Wopacne mě boka',
	'formbadrecaptcha' => 'Njepłaśiwe gódnoty za reCaptcha. Wopytaj hyšći raz.',
	'formbadpagenametext' => 'Formularne daty, kótarež sy zapódał, napóraju njepłaśiwe mě boka, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Pólo $1 jo trěbne|Póli $1 stej trěbnej|Póla $1 su trěbne|Póla $1 su trěbne}} za toś ten fromular.
Pšosym wupołń {{PLURAL:$2|jo|jej|je|je}}.',
	'formsavesummary' => 'Nowy bok z pomocu [[Special:Form/$1|formulara $1]]',
	'formsaveerror' => 'Zmólka pśi składowanju formulara',
	'formsaveerrortext' => "Njeznata zmólka jo nastała pśi składowanju boka '$1'.",
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'form-desc' => 'Μια [[Special:Form|φόρμα επιφάνειας]] για έναρξη νέων σελίδων',
	'form' => 'Φόρμα',
	'formnoname' => 'Κανένα όνομα φόρμας',
	'formbadname' => 'Κακό όνομα φόρμας',
	'formbadnametext' => 'Δεν υπάρχει καμιά φόρμα με αυτό το όνομα.',
	'formpattern' => '$1-φόρμα',
	'formtitlepattern' => 'Προσθήκη νέου $1',
	'formsave' => 'Αποθηκεύστε',
	'formindexmismatch-title' => 'Αναντιστοιχία μεταξύ μοτίβου ονόματος και προτύπου',
	'formindexmismatch' => 'Αυτή η φόρμα παρουσιάζει αναντιστοιχία μεταξύ μοτίβου ονόματος και προτύπου στον δείκτη $1.',
	'formarticleexists' => 'Η σελίδα υπάρχει',
	'formarticleexiststext' => 'Η σελίδα [[$1]] υπάρχει ήδη.',
	'formbadpagename' => 'Κακό όνομα σελίδας',
	'formsavesummary' => 'Νέα σελίδα που χρησιμοποιεί τη [[Special:Form/$1|φόρμα $1]]',
	'formsaveerror' => 'Σφάλμα στην αποθήκευση της φόρμας',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Michawiki
 * @author Yekrats
 */
$messages['eo'] = array(
	'form' => 'Formulario',
	'formnoname' => 'Neniu nomo de kamparo',
	'formnonametext' => 'Vi devas provizi formularan nomon, ekzemple "Special:Form/NomoDeFormularo".',
	'formbadname' => 'Malbona nomo de formularo',
	'formbadnametext' => 'Ne estas formularo kun tiu nomo.',
	'formpattern' => '$1-formularo',
	'formtitlepattern' => 'Aldoni nova $1',
	'formsave' => 'Konservi',
	'formarticleexists' => 'Paĝo ekzistas',
	'formarticleexiststext' => 'La paĝo [[$1]] jam ekzistas.',
	'formbadpagename' => 'Fuŝa paĝnomo',
	'formbadrecaptcha' => 'Malkorektaj valoroj por reCaptcha. Reprovu.',
	'formrequiredfielderror' => 'La {{PLURAL:$2|kampo $1 estas deviga|kampoj $1 estas devigaj}} por ĉi tiu formulario.
Bonvolu plenigi {{PLURAL:$2|ĝin|ilin}}.',
	'formsaveerror' => 'Eraro konservante formularon',
	'formsaveerrortext' => "Estis nekonata eraro konservante paĝon '$1'.",
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'form-desc' => 'Una [[Special:Form|interface de formulario]] para comenzar nuevas páginas',
	'form' => 'Formulario',
	'formnoname' => 'Formulario sin nombre',
	'formnonametext' => 'Debes proveer un nombre de formulario, como "Special:Form/Nameofform".',
	'formbadname' => 'Mal nombre de formulario',
	'formbadnametext' => 'No har formulario para ese nombre',
	'formpattern' => 'Formulario de $1',
	'formtitlepattern' => 'Agregar nuevo $1',
	'formsave' => 'Guardar',
	'formindexmismatch-title' => 'No se corresponde el nombre del modelo y la plantilla',
	'formindexmismatch' => 'Este formulario tiene nombres de patrones y plantillas que no coinciden, comenzando por $1.',
	'formarticleexists' => 'La página existe',
	'formarticleexiststext' => 'La página [[$1]] ya existe.',
	'formbadpagename' => 'Mal nombre de página',
	'formbadrecaptcha' => 'Valores incorrectos para reCaptcha. Intente nuevamente.',
	'formbadpagenametext' => 'Los datos de formulario que ingresó hacen un mal nombre de página, "$1".',
	'formrequiredfielderror' => 'Los {{PLURAL:$2|campo $1 es|campos $1 son}} requeridos para este formulario.
Por favor {{PLURAL:$2|rellénelo|rellénelos}}.',
	'formsavesummary' => 'Nueva página usando [[Special:Form/$1|formulario $1]]',
	'formsaveerror' => 'Error grabando formulario',
	'formsaveerrortext' => "Hubo un error desconocido grabando la página '$1'.",
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'form' => 'Formularioa',
	'formsave' => 'Gorde',
	'formarticleexists' => 'Orrialdea existitzen da',
);

/** Finnish (Suomi)
 * @author Centerlink
 * @author Cimon Avaro
 * @author Crt
 * @author Jack Phoenix
 * @author ZeiP
 */
$messages['fi'] = array(
	'form-desc' => '[[Special:Form|Lomake]] uusien sivujen luomiseen',
	'form' => 'Lomake',
	'formnoname' => 'Ei lomakkeen nimeä',
	'formnonametext' => 'Sinun tulee antaa lomakkeen nimi, kuten "Special:Form/Lomakkeennimi".',
	'formbadname' => 'Huono lomakkeen nimi',
	'formbadnametext' => 'Haluamallasi nimellä ei ole lomaketta.',
	'formpattern' => '$1-lomake',
	'formtitlepattern' => 'Lisää uusi $1',
	'formsave' => 'Tallenna',
	'formindexmismatch-title' => 'Nimimalli- ja mallinnetäsmäämättömyys',
	'formindexmismatch' => 'Tällä lomakkeella on yhteensopimattomat nimi- ja mallinekaavat alkaen riviltä $1.',
	'formarticleexists' => 'Sivu on jo olemassa',
	'formarticleexiststext' => 'Sivu [[$1]] on jo olemassa.',
	'formbadpagename' => 'Huono sivun nimi',
	'formbadrecaptcha' => 'Väärät vastausarvot reCaptcha-varmistukselle. Yritä uudestaan.',
	'formbadpagenametext' => 'Antamasi lomakkeen tiedot tekevät huonon sivun nimen, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Kenttä $1 on|Kentät $1 ovat}} pakollisia tässä lomakkeessa.
Ole hyvä ja täytä {{PLURAL:$2|se|ne}}.',
	'formsavesummary' => 'Uusi sivu käyttäen [[Special:Form/$1]]',
	'formsaveerror' => 'Virhe lomaketta tallennettaessa',
	'formsaveerrortext' => "Tuntematon virhe tapahtui sivua '$1' tallennettaessa.",
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Omnipaedista
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'form-desc' => 'Une [[Special:Form|interface de formulaire]] pour commencer des nouvelles pages',
	'form' => 'Formulaire',
	'formnoname' => 'Aucun nom',
	'formnonametext' => 'Veuillez spécifier le nom du formulaire, sous la forme « Special:Formulaire/NomDuFormulaire ».',
	'formbadname' => 'Nom incorrect',
	'formbadnametext' => 'Le nom choisi pour le formulaire est incorrect. Aucun formulaire n’existe sous ce nom.',
	'formpattern' => 'formulaire-$1',
	'formtitlepattern' => 'Ajouter un(e) $1',
	'formsave' => 'Sauvegarder',
	'formindexmismatch-title' => 'Inadéquation entre la palette de nom et le modèle',
	'formindexmismatch' => 'Ce formulaire a des patrons et des modèles qui ne correspondent pas à partir de $1.',
	'formarticleexists' => 'La page existe déjà.',
	'formarticleexiststext' => 'La page nommée [[$1]] existe déjà.',
	'formbadpagename' => 'Mauvais nom de page',
	'formbadrecaptcha' => 'Valeur incorrecte pour reCaptcha. Essayez à nouveau',
	'formbadpagenametext' => 'Les données saisies forment un mauvais nom de page, « $1 ».',
	'formrequiredfielderror' => '{{PLURAL:$2|Le champ $1 est|Les champs $1 sont}} requis dans ce formulaire.
Vous devez le{{PLURAL:$2||s}} remplir.',
	'formsavesummary' => 'Nouvelle page utilisant [[Special:Form/$1|le formulaire $1]]',
	'formsaveerror' => 'Une erreur s’est produite pendant la sauvegarde.',
	'formsaveerrortext' => "Une erreur inconnue s’est produite pendant la sauvegarde de ''$1''.",
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 */
$messages['frp'] = array(
	'formsave' => 'Sôvar',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'formsave' => 'Fêstlizze',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'form-desc' => 'Un [[Special:Form|formulario como interface]] para comezar páxinas novas',
	'form' => 'Formulario',
	'formnoname' => 'Formulario sen Nome',
	'formnonametext' => 'Tenlle que dar un nome ao formulario, como "Special:Form/Nomedoformulario".',
	'formbadname' => 'Formulario con Nome incorrecto',
	'formbadnametext' => 'Non hai ningún formulario con ese nome.',
	'formpattern' => 'formulario-$1',
	'formtitlepattern' => 'Engadir Novo $1',
	'formsave' => 'Gardar',
	'formindexmismatch-title' => 'O nome do patrón e o modelo son incompatibles',
	'formindexmismatch' => 'Este formulario ten nomes de patróns e modelos que non coinciden, comezando por $1.',
	'formarticleexists' => 'A páxina Existe',
	'formarticleexiststext' => 'A páxina [[$1]] xa existe.',
	'formbadpagename' => 'Nome de Páxina incorrecto',
	'formbadrecaptcha' => 'Valores incorrectos na reCaptcha. Inténteo de novo.',
	'formbadpagenametext' => 'O formulario de datos que vostede introduciu fixo un nome de páxina incorrecto, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|O campo $1 é requirido|Os campos $1 son requiridos}} para este formulario. Por favor, {{PLURAL:$2|énchao|énchaos}}.',
	'formsavesummary' => 'Nova páxina usando [[Special:Form/$1|o formulario $1]]',
	'formsaveerror' => 'Erro ao gardar o formulario',
	'formsaveerrortext' => "Houbo un erro descoñecido ao gardar a páxina '$1'.",
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'formsave' => 'Γράφειν',
	'formbadpagename' => 'Κακὸν ὄνομα δέλτου',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'form-desc' => 'E [[Special:Form|Yygabmaschke]] zum Aalege vu neje Syte',
	'form' => 'Formular',
	'formnoname' => 'Kei Formularname',
	'formnonametext' => 'Du muesch e Formularnamen aagee, z. B. „{{ns:Special}}:Form/Formularname“.',
	'formbadname' => 'Falscher Formularname',
	'formbadnametext' => 'S git kei Formular mit däm Name.',
	'formpattern' => '$1-Formular',
	'formtitlepattern' => 'Fieg neji $1 zue',
	'formsave' => 'Spychere',
	'formindexmismatch-title' => 'Uuglyychgwicht zwische Namemuschter un Vorlage',
	'formindexmismatch' => 'Des Formular het e Uuglyychgwicht zwische Namemuschter un Vorlagen, wu aafangt bim Index $1.',
	'formarticleexists' => 'Syt git s scho',
	'formarticleexiststext' => 'D Syte „[[$1]]“ git s scho.',
	'formbadpagename' => 'Nit zuelässige Sytename',
	'formbadrecaptcha' => 'Nit giltigi Wärt fir reCaptcha. Versuech s nomol.',
	'formbadpagenametext' => 'D Formulardate, wu yygee wore sin, gän e nit zuelässige Sytename: „$1“.',
	'formrequiredfielderror' => '{{PLURAL:$2|S Fäld $1 isch e Pfichtfäld|D Fälder $1 sin Pfichtfälder}}.
Bitte fill {{PLURAL:$2|s|si}} uus.',
	'formsavesummary' => 'Neji Syte, wu uf em [[Special:Form/$1|Formular $1]] basiert',
	'formsaveerror' => 'Fähler bim Spychere vum Formular',
	'formsaveerrortext' => 'S het e nit bekannte Fähler gee bim Spychere vu dr Syte „$1“.',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'form-desc' => '[[Special:Form|ממשק טופס]] ליצירת דפים חדשים',
	'form' => 'טופס',
	'formnoname' => 'אין שם לטופס',
	'formnonametext' => 'עליכם לספק שם לטופס, כגון "Special:Form/Nameofform".',
	'formbadname' => 'שם הטופס אינו תקין',
	'formbadnametext' => 'אין טופס בשם זה.',
	'formpattern' => 'טופס־$1',
	'formtitlepattern' => 'הוספת $1 חדש',
	'formsave' => 'שמירה',
	'formindexmismatch-title' => 'מבנה השם והתבנית אינם תואמים',
	'formindexmismatch' => 'טופס זה אינו תואם את מבנה השם ואת התבניות המתחילות באינדקס $1.',
	'formarticleexists' => 'הדף קיים',
	'formarticleexiststext' => 'הדף [[$1]] כבר קיים.',
	'formbadpagename' => 'שם הדף אינו תקין',
	'formbadrecaptcha' => 'הערכים שהוזנו ל־reCaptcha שגויים. נסו שוב.',
	'formbadpagenametext' => 'נתוני הטופס ששלחתם יוצרים דף בעל שם בלתי תקין, "$1".',
	'formrequiredfielderror' => 'מילוי {{PLURAL:$2|השדה $1|השדות $1}} נדרש להשלמת טופס זה.
אנא מלאו {{PLURAL:$2|אותו|אותם}}.',
	'formsavesummary' => 'דף חדש באמצעות [[Special:Form/$1|טופס $1]]',
	'formsaveerror' => 'שגיאה בשמירת הטופס',
	'formsaveerrortext' => "אירעה שגיאה בלתי ידועה בעת שמירת הדף '$1'.",
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'formsave' => 'Spremi',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'form-desc' => '[[Special:Form|Formularny interfejs]] za wutworjenje nowych stronow',
	'form' => 'Formular',
	'formnoname' => 'Žane formularne mjeno',
	'formnonametext' => 'Dyrbiš formularne mjeno podać, na př. „{{ns:Special}}:Form/Formularnemjeno“.',
	'formbadname' => 'Wopačne formularne mjeno',
	'formbadnametext' => 'Njeje formular z tutym mjenom',
	'formpattern' => '$1 formular',
	'formtitlepattern' => 'Nowe $1 přidać',
	'formsave' => 'Składować',
	'formindexmismatch-title' => 'Mjenowy muster a předłoha so njewotpowědujetej',
	'formindexmismatch' => 'Tutón formular ma njejenake mjenowe mustry a předłohi wot indeksa $1.',
	'formarticleexists' => 'Nastawk hižo eksistuje',
	'formarticleexiststext' => 'Nastawk [[$1]] hižo eksistuje.',
	'formbadpagename' => 'Njedowolene mjeno strony',
	'formbadrecaptcha' => 'Njekorektne hódnoty za reCaptcha. Spytaj hišće raz.',
	'formbadpagenametext' => 'Zapodate formularne daty tworja njedowolene mjeno strony: "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Polo $1 je trěbne|Poli $1 stej trěbnej|Pola $1 su trěbne|Pola $1 su trěbne}} za tutón formular. Prošu wupjelń {{PLURAL:$2|jo|jej|je|je}}.',
	'formsavesummary' => 'Nowa strona, kotraž [[Special:Form/$1|formular $1]] wužiwa.',
	'formsaveerror' => 'Zmylk při składowanju formulara',
	'formsaveerrortext' => 'Bě njeznaty zmylk při składowanju nastawka "$1".',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'form-desc' => '[[Special:Form|Űrlap interfész]] új lapok létrehozásához',
	'form' => 'Űrlap',
	'formnoname' => 'Nincs űrlapnév',
	'formnonametext' => 'Meg kell adnod egy űrlapnevet, mint például „{{#special:Form}}/Űrlapneve”',
	'formbadname' => 'Hibás űrlapnév',
	'formbadnametext' => 'Nincs ilyen nevű űrlap.',
	'formpattern' => '$1 űrlap',
	'formtitlepattern' => 'Új $1 hozzáadása',
	'formsave' => 'Mentés',
	'formindexmismatch-title' => 'A név minta és a sablon nem egyezik',
	'formindexmismatch' => 'Ez az űrlap nem egyező névmintákat és sablonokat tartalmaz, a $1 indextől kezdve.',
	'formarticleexists' => 'A lap már létezik',
	'formarticleexiststext' => 'A(z) [[$1]] lap már létezik.',
	'formbadpagename' => 'Hibás lapnév',
	'formbadrecaptcha' => 'Helytelen értékek a reCaptchához. Próbáld újra.',
	'formbadpagenametext' => 'A beírt űrlapadat hibás lapcímet generál: „$1”.',
	'formrequiredfielderror' => 'A {{PLURAL:$2|$1 mező|$1 mezők}} kitöltése kötelező ennél az űrlapnál.
Kérlek {{PLURAL:$2|töltsd ki|töltsd ki őket}}.',
	'formsavesummary' => 'Új lap a(z) [[Special:Form/$1|$1 űrlap]] használatával',
	'formsaveerror' => 'Hiba az űrlap mentésekor',
	'formsaveerrortext' => 'A(z) „$1” lap mentésekor ismeretlen hiba történt.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'form-desc' => 'Un [[Special:Form|interfacie de formulario]] pro initiar nove paginas',
	'form' => 'Formulario',
	'formnoname' => 'Nulle nomine del formulario',
	'formnonametext' => 'Tu debe fornir un nomine pro le formulario, como "Special:Formulario/NomineDelFormulario".',
	'formbadname' => 'Nomine de formulario invalide',
	'formbadnametext' => 'Non existe un formulario con iste nomine.',
	'formpattern' => 'formulario-$1',
	'formtitlepattern' => 'Adder nove $1',
	'formsave' => 'Immagazinar',
	'formindexmismatch-title' => 'Non-correspondentia inter forma de nomine e patrono',
	'formindexmismatch' => 'Iste formulario ha formas de nomine e patronos non correspondente a partir del indice $1.',
	'formarticleexists' => 'Pagina existe',
	'formarticleexiststext' => 'Le pagina [[$1]] existe ja.',
	'formbadpagename' => 'Nomine de pagina invalide',
	'formbadrecaptcha' => 'Valores incorrecte pro reCaptcha. Reproba.',
	'formbadpagenametext' => 'Le datos de formulario que tu entrava resulta in un nomine de pagina invalide, "$1".',
	'formrequiredfielderror' => 'Le {{PLURAL:$2|campo|campos}} $1 es requirite pro iste formulario.
Per favor completa {{PLURAL:$2|lo|los}}.',
	'formsavesummary' => 'Nove pagina con [[Special:Form/$1|le formulario $1]]',
	'formsaveerror' => 'Error durante le immagazinage del formulario',
	'formsaveerrortext' => "Il occurreva un error incognite durante le immagazinage del pagina '$1'.",
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'form-desc' => 'Suatu [[Special:Form|antarmuka formulir]] untuk membuat halaman baru',
	'form' => 'Formulir',
	'formnoname' => 'Nama formulir kosong',
	'formnonametext' => 'Anda harus memasukkan nama formulir seperti "Special:Form/Namaformulir".',
	'formbadname' => 'Nama formulir salah',
	'formbadnametext' => 'Tidak ada formulir dengan nama itu.',
	'formpattern' => '$1-form',
	'formtitlepattern' => 'Tambah $1 baru',
	'formsave' => 'Simpan',
	'formindexmismatch-title' => 'Pola nama dan templat tidak cocok',
	'formindexmismatch' => 'Formulir ini tidak cocok dengan pola nama dan templat dimulai dari indeks $1.',
	'formarticleexists' => 'Halaman telah ada',
	'formarticleexiststext' => 'Halaman [[$1]] telah ada.',
	'formbadpagename' => 'Nama halaman salah',
	'formbadrecaptcha' => 'Nilai reCaptcha salah. Coba lagi.',
	'formbadpagenametext' => 'Data formulir yang Anda masukkan mengandung nama halaman yang salah, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Isian $1|Isian $1}} diperlukan oleh formulir ini.
Silakan masukkan {{PLURAL:$2|isian|isian}} itu.',
	'formsavesummary' => 'Halaman baru menggunakan [[Special:Form/$1|formulir $1]]',
	'formsaveerror' => 'Kesalahan penyimpanan formulir',
	'formsaveerrortext' => "Terjadi kesalahan yang tak dikenal sewaktu menyimpan halaman '$1'.",
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'formsave' => 'Registragar',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'formsave' => 'Vista',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'form-desc' => "Un'[[Special:Form|interfaccia di modulo]] per iniziare nuove pagine",
	'form' => 'Modulo',
	'formnoname' => 'Nessun nome per il modulo',
	'formnonametext' => 'È necessario fornire un nome per il modulo, come "Special:Form/Nomedelmodulo"',
	'formbadname' => 'Nome modulo errato',
	'formbadnametext' => 'Non ci sono moduli con quel nome.',
	'formpattern' => '$1-modulo',
	'formtitlepattern' => 'Aggiungere un nuovo $1',
	'formsave' => 'Salva',
	'formindexmismatch-title' => 'Modello del nome e template non corrispondono',
	'formindexmismatch' => "Questo modulo ha modelli di nome e template che non corrispondono a partire dall'indice $1.",
	'formarticleexists' => 'La pagina esiste',
	'formarticleexiststext' => 'La pagina [[$1]] esiste già.',
	'formbadpagename' => 'Nome pagina errato',
	'formbadrecaptcha' => 'Valori errati per reCaptcha. Provare di nuovo.',
	'formbadpagenametext' => 'I dati inseriti nel modulo generano un nome pagina errato, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Il campo $1 è richiesto|I campi $1 sono richiesti}} per questo modulo.
{{PLURAL:$2|Compilarlo|Compilarli}}.',
	'formsavesummary' => 'Nuova pagina utilizzando il [[Special:Form/$1|modulo $1]]',
	'formsaveerror' => 'Errore durante il salvataggio del modulo',
	'formsaveerrortext' => "Si è verificato un errore sconosciuto durante il salvataggio della pagina '$1'.",
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'form-desc' => 'ページを作成する[[Special:Form|フォーム形式のインタフェース]]',
	'form' => 'フォーム',
	'formnoname' => 'フォーム名がありません',
	'formnonametext' => 'フォームの名前を決めなければなりません。(例: Special:Form/Nameofform)',
	'formbadname' => '不正なフォーム名',
	'formbadnametext' => 'その名前のフォームはありません。',
	'formpattern' => '$1-form',
	'formtitlepattern' => '新規$1を追加',
	'formsave' => '保存',
	'formindexmismatch-title' => '名前パターンとテンプレートの不整合',
	'formindexmismatch' => 'このフォームには、インデックス $1 で始まる名前パターンとテンプレートの不整合があります。',
	'formarticleexists' => 'ページが存在します',
	'formarticleexiststext' => 'そのページ [[$1]] は既に存在します。',
	'formbadpagename' => '不正なページ名',
	'formbadrecaptcha' => 'reCAPTCHA 用の値が不正です。再度試してください。',
	'formbadpagenametext' => 'あなたが入力したフォームのデータは不正なページ名「$1」を作ります。',
	'formrequiredfielderror' => '{{PLURAL:$2|欄 $1}}はこのフォームで必須です。{{PLURAL:$2|入力}}してください。',
	'formsavesummary' => '[[Special:Form/$1|$1フォーム]]を使ってページ作成',
	'formsaveerror' => 'フォーム保存時のエラー',
	'formsaveerrortext' => 'ページ「$1」の保存時に不明なエラーがありました。',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author Pras
 */
$messages['jv'] = array(
	'form-desc' => 'Sawijining [[Special:Form|antarmuka formulir]] kanggo miwiti kaca-kaca anyar',
	'form' => 'Formulir',
	'formnoname' => 'Ora ana jeneng formulir',
	'formnonametext' => 'Panjenengan kudu maringi jeneng formulir, kaya "Special:Form/Nameofform".',
	'formbadname' => 'Jeneng formulir ala',
	'formbadnametext' => 'Ora ana formulir mawa jeneng iku.',
	'formpattern' => 'Formulir-$1',
	'formtitlepattern' => 'Tambah $1 anyar',
	'formsave' => 'Simpen',
	'formindexmismatch-title' => 'Pola jeneng lan cithakan ora cocog',
	'formindexmismatch' => 'Ing formulir iki ora cocog antara pola jeneng lan cithakan miwiti ing indèks $1.',
	'formarticleexists' => 'Kacané ana',
	'formarticleexiststext' => 'Kaca [[$1]] wis ana.',
	'formbadpagename' => 'Jeneng kaca ala',
	'formrequiredfielderror' => '{{PLURAL:$2|Field $1 |Fields $1 }} diperlokaké kanggo formulir iki.
Mangga diisi {{PLURAL:$2|iki|iki}}.',
	'formsavesummary' => 'Kaca anyar nganggo [[Special:Form/$1|formulir $1]]',
	'formsaveerror' => 'Ana kaluputan nalika nyimpen formulir',
	'formsaveerrortext' => "Ana kaluputan sing ora dimangertèni nalika nyimpen kaca '$1'.",
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'form-desc' => '[[Special:Form|ទម្រង់​អន្តរមុខ]]មួយ​ដើម្បី​ចាប់ផ្ដើម​ទំព័រ​ថ្មីនានា',
	'form' => 'សំណុំបែបបទ',
	'formnoname' => 'គ្មានឈ្មោះសំណុំបែបបទ',
	'formnonametext' => 'អ្នក​ត្រូវតែ​ផ្ដល់​សំណុំបែបបទ ដូចជា "Special:Form/សំណុំបែបបទ"​។',
	'formbadname' => 'ឈ្មោះសំណុំបែបបទមិនល្អ',
	'formbadnametext' => 'គ្មានឈ្មោះបែបបទ នោះទេ ។',
	'formpattern' => '$1-សំណុំបែបបទ',
	'formtitlepattern' => 'បន្ថែម $1 ថ្មី',
	'formsave' => 'រក្សាទុក',
	'formarticleexists' => 'ទំព័រ​មានរួចហើយ',
	'formarticleexiststext' => 'ទំព័រ [[$1]] មានរួចហើយ។',
	'formbadpagename' => 'ឈ្មោះទំព័រមិនល្អ',
	'formsavesummary' => 'ទំព័រ​ប្រើប្រាស់​ថ្មី [[Special:Form/$1|ទម្រង់ $1]]',
	'formsaveerror' => 'កំហុសរក្សាទុកសំណុំបែបបទ',
	'formsaveerrortext' => "មានកំហុសមិនស្គាល់មួយក្នុងការរក្សាទុកទំព័រ '$1'។",
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'form-desc' => 'En [[Special:Form|Schnettstell met Fommulaare]] fö neu Sigge aanzefange.',
	'form' => 'Fommulaa',
	'formnoname' => 'Keine Name för en Fommulaa',
	'formnonametext' => 'Do moß ene Name för dat Fommulaa aanjevve, en dä Aat wi „{{ns:Special}}:Form/Fommulaaname“.',
	'formbadname' => 'Ene verkeehte Name fö dat Fommulaa',
	'formbadnametext' => 'Mer han kei Fommulaa met dämm Name.',
	'formpattern' => '$1-Fommulaa',
	'formtitlepattern' => 'Donn neu $1 dobei',
	'formsave' => 'Afspeichere',
	'formindexmismatch-title' => 'Et Moster för dä Name un de Schablon passe nit zosamme',
	'formindexmismatch' => 'Dat Fommulaa hee hät unejaal fill Namens-Muster un Schablone, aff dä Nommer $1.',
	'formarticleexists' => 'Die Sigg jitt et ald',
	'formarticleexiststext' => 'Di Sigg „[[$1]]“ es ald doh.',
	'formbadpagename' => 'Dat es keine Name för en Sigg',
	'formbadrecaptcha' => 'Ferkeehte Wäät för e widderhollt Kaptache. Moß De norr_ens versöke.',
	'formbadpagenametext' => 'Di enjejovve Date fun dämm Fommulaa jevve „[[$1]]“ — dat es enne kapodde Name för en Sigg.',
	'formrequiredfielderror' => '{{PLURAL:$2|Dat Feld|De Felder|Nix}} $1 {{PLURAL:$2|moß|mösse|moß}} aanjejovve wäde. Donn {{PLURAL:$2|et|se|nix}} ußfölle.',
	'formsavesummary' => 'En neu Sigg, di op dämm [[Special:Form/$1|Fommulaa $1]] opbout.',
	'formsaveerror' => 'Fäähler beim Fommulaa afspeichere',
	'formsaveerrortext' => 'Mer hatte ene Fähler — de Aat es onbikannt — beim Afspeichere fun de Sigg „$1“.',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'formsave' => 'Servare',
	'formarticleexiststext' => 'Pagina [[$1]] iam existit.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'form-desc' => 'E [[Special:Form|Formulaire]] fir nei Säiten unzefänken',
	'form' => 'Formulaire',
	'formnoname' => 'Keen Numm vum Formulaire',
	'formnonametext' => 'Dir musst en Numm vum Formulaire uginn, zum Beispill "Special:Form/NummvumFormulaire".',
	'formbadname' => 'Falschen Numm vum Formulaire',
	'formbadnametext' => 'Et gëtt kee Formulaire mat dem Numm.',
	'formpattern' => '$1-Formulaire',
	'formtitlepattern' => 'Nei $1 derbäisetzen',
	'formsave' => 'Späicheren',
	'formindexmismatch-title' => 'Duercherneen tëschent dem Numm an der Schabloun',
	'formindexmismatch' => "Dëse Formulaire ass net richteg configuréiert wat d'Schablounen an d'Modeller vun den Donnéeën. De Feeler fänkt beim Index $1 un.",
	'formarticleexists' => "D'Säit gëtt et schonn.",
	'formarticleexiststext' => "D'Säit [[$1]] gëtt et schonn.",
	'formbadpagename' => 'Falsche Säitennumm',
	'formbadrecaptcha' => 'Falsche Wert fir reCaptcha. Probéiert nach emol.',
	'formbadpagenametext' => 'Déi Donnéeën déi Dir an de Formulaire aginn hutt erginn e Säitennumm, den net ka gespäichert ginn: "$1".',
	'formrequiredfielderror' => "D'{{PLURAL:$2|Feld $1 muss|Felder $1 mussen}} an dësem Formulaire ausgefëllt ginn.
Fëllt {{PLURAL:$2|et|se}} w.e.g. aus.",
	'formsavesummary' => 'Nei Säit, déi de [[Special:Form/$1|Formulaire $1]] benotzt',
	'formsaveerror' => 'Feeler beim Späichere vum Formulaire',
	'formsaveerrortext' => "Et gouf een onbekannte Feeler beim späichere vun der Säit '$1'.",
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'formsave' => 'Аралаш',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'form-desc' => '[[Special:Form|Интерфејс]] за започнување нови страници',
	'form' => 'Образец',
	'formnoname' => 'Нема име на образецот',
	'formnonametext' => 'Мора да наведете име на образецот, како да речеме „Special:Form/ИмеНаОбразец“',
	'formbadname' => 'Лошо име на образецот',
	'formbadnametext' => 'Нема образец со тоа име.',
	'formpattern' => '$1-образец',
	'formtitlepattern' => 'Додај нов $1',
	'formsave' => 'Зачувај',
	'formindexmismatch-title' => 'Несоодветно име и шаблон',
	'formindexmismatch' => 'Овој образец има несоодветни имиња и шаблони во позиција $1.',
	'formarticleexists' => 'Страницата постои',
	'formarticleexiststext' => 'Страницата [[$1]] веќе постои.',
	'formbadpagename' => 'Лошо име на страницата',
	'formbadrecaptcha' => 'Неточни вредности за reCaptcha. Обидете се повторно.',
	'formbadpagenametext' => 'Внесените податоци во образецот доведуваат до погрешен назив на страницата, „$1“.',
	'formrequiredfielderror' => '{{PLURAL:$2|Полето $1 е задолжително во овој образец|Полињата $1 се задолжителни во овој образец}}.
Пополнете {{PLURAL:$2|го|ги}}.',
	'formsavesummary' => 'Нова страница, користејќи го [[Special:Form/$1|образецот $1]]',
	'formsaveerror' => 'Грешка при зачувување на образецот',
	'formsaveerrortext' => 'Се појави непозната грешка при зачувувањето на страницата „$1“.',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'form' => 'ഫോം',
	'formnoname' => 'ഫോമിനു പേരില്ല',
	'formnonametext' => 'ഫോമിനു ഒരു പേരു നിര്‍ബന്ധമായും കൊടുക്കണം, ഉദാ: "Special:Form/Nameofform".',
	'formbadname' => 'അസാധുവായ ഫോം നാമം',
	'formbadnametext' => 'ആ പേരില്‍ ഒരു ഫോമില്ല.',
	'formpattern' => '$1-ഫോം',
	'formtitlepattern' => 'പുതിയ $1 ചേര്‍ക്കുക',
	'formsave' => 'സേവ് ചെയ്യുക',
	'formarticleexists' => 'താള്‍ നിലവിലുണ്ട്',
	'formarticleexiststext' => '[[$1]] എന്ന താള്‍ നിലവിലുണ്ട്.',
	'formbadpagename' => 'അസാധുവായ താള്‍ നാമം',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'form' => 'अर्ज',
	'formnoname' => 'अर्ज नाव नाही',
	'formnonametext' => 'तुम्ही एक अर्ज नाव देणे आवश्यक आहे, उदा "Special:Form/अर्जनाव".',
	'formbadname' => 'चुकीचे अर्ज नाव',
	'formbadnametext' => 'या नावाचा अर्ज अस्तित्वात नाही.',
	'formpattern' => '$1-अर्ज',
	'formtitlepattern' => 'नवीन वाढवा $1',
	'formsave' => 'जतन करा',
	'formindexmismatch' => 'या अर्जामध्ये चुकीचे नाव रकाने तसेच साचे जे $1 पासून सुरु होतात, आहेत.',
	'formarticleexists' => 'पान अस्तित्वात आहे',
	'formarticleexiststext' => '[[$1]] हे पान अगोदरच अस्तित्वात आहे',
	'formbadpagename' => 'चुकीचे पान नाव',
	'formbadpagenametext' => 'तुम्ही दिलेल्या अर्ज माहितीमुळे चुकीचे पृष्ठ नाव तयार होत आहे, "$1".',
	'formrequiredfielderror' => '$1 रकाना या अर्जाकरिता आवश्यक आहेत.
कृपया ते भरा.',
	'formsavesummary' => '[[Special:Form/$1]] वापरुन नवीन पान',
	'formsaveerror' => 'अर्ज जतन करण्यात त्रुटी',
	'formsaveerrortext' => "'$1' पान जतन करण्यामध्ये अनोळखी त्रुटी आलेली आहे.",
);

/** Malay (Bahasa Melayu)
 * @author Izzudin
 */
$messages['ms'] = array(
	'form-desc' => 'Sebuah [[Special:Form|antara muka borang]] untuk mulakan halaman baru',
	'form' => 'Borang',
	'formnoname' => 'Borang tanpa nama',
	'formnonametext' => 'Anda perlu meletakkan nama borang, seperti "Special:Form/Namaborang".',
	'formbadname' => 'Nama borang tidak sesuai',
	'formbadnametext' => 'Tiada borang dengan nama itu.',
	'formpattern' => 'borang $1',
	'formtitlepattern' => 'Tambahkan $1 baru',
	'formsave' => 'Simpan',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'formsave' => 'Ванстомс',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'formtitlepattern' => 'Ticcēntilīz yancuīc $1',
	'formsave' => 'Ticpiyāz',
	'formarticleexists' => 'Zāzanilli ia',
	'formarticleexiststext' => 'Zāzanilli [[$1]] ye ia.',
	'formbadpagename' => 'Ahcualli zāzaniltōcāitl',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'form' => 'Formular',
	'formsave' => 'Spiekern',
	'formarticleexists' => 'Sied gifft dat al',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'form-desc' => "Een [[Special:Form|formulierinterface]] om nieuwe pagina's te starten",
	'form' => 'Formulier',
	'formnoname' => 'Geen formuliernaam',
	'formnonametext' => 'Geef een formuliernaam op, bijvoorbeeld "Special:Form/Formuliernaam".',
	'formbadname' => 'Ongeldige formuliernaam',
	'formbadnametext' => 'Er bestaat geen formulier met die naam.',
	'formpattern' => '$1-formulier',
	'formtitlepattern' => 'Voeg nieuw $1 toe',
	'formsave' => 'Opslaan',
	'formindexmismatch-title' => 'Naampatroon- en sjabloonmismatch',
	'formindexmismatch' => 'Dit formulier heeft ongekoppelde naampatronen en sjablonen vanaf index $1.',
	'formarticleexists' => 'Pagina bestaat al',
	'formarticleexiststext' => 'De pagina [[$1]] bestaat al.',
	'formbadpagename' => 'Onjuiste paginanaam',
	'formbadrecaptcha' => 'Incorrecte waarden voor reCaptcha.
Probeer het opnieuw.',
	'formbadpagenametext' => 'De formuliergegevens die u hebt opgegeven zorgen voor een onjuiste pagina, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Het veld $1 is|De velden $1 zijn}} benodigd voor dit formulier.
Vul {{PLURAL:$2|dit|deze}} alstublieft in.',
	'formsavesummary' => 'Nieuwe pagina via [[Special:Form/$1|formulier $1]]',
	'formsaveerror' => 'Fout bij opslaan formulier',
	'formsaveerrortext' => "Er is een onbekende fout opgetreden bij het opslaan van pagina '$1'.",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'form-desc' => 'Eit [[Special:Form|skjema]] for å opprette nye sider',
	'form' => 'Skjema',
	'formnoname' => 'Skjemanamn finst ikkje',
	'formnonametext' => 'Du må gje eit skjemanamn, som «Special:Form/Skjemanamn».',
	'formbadname' => 'Ugyldig skjemanamn',
	'formbadnametext' => 'Det finst ingen skjema med det namnet.',
	'formpattern' => '$1-skjema',
	'formtitlepattern' => 'Legg til nytt $1',
	'formsave' => 'Lagre',
	'formindexmismatch-title' => 'Namnemønster- og malfeil',
	'formindexmismatch' => 'Dette skjemaet har upassande namnemønster og malar som startar på indeks $1.',
	'formarticleexists' => 'Sida eksisterer',
	'formarticleexiststext' => 'Sida [[$1]] eksisterer alt.',
	'formbadpagename' => 'Ugyldig sidenamn',
	'formbadrecaptcha' => 'Gale verdiar frå reCaptcha. Prøv igjen.',
	'formbadpagenametext' => 'Skjemadataa du skreiv inn utgjevr eit ugyldig sidenamn, «$1».',
	'formrequiredfielderror' => '{{PLURAL:$2|Feltet $1 er påkravd |Felta $1 er påkravde}} for dette skjemaet. Ver venleg og fyll {{PLURAL:$2|det|dei}} inn.',
	'formsavesummary' => 'Ny side vha. [[Special:Form/$1|skjemaet $1]]',
	'formsaveerror' => 'Feil under skjemalagring',
	'formsaveerrortext' => 'Det var ein ukjend feil under lagring av sida ‘$1’.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'form-desc' => 'Et [[Special:Form|skjema]] for å opprette nye sider',
	'form' => 'Skjema',
	'formnoname' => 'Intet skjemanavn',
	'formnonametext' => 'Du må angi et skjemanavn, som «Special:Form/Skjemanavn».',
	'formbadname' => 'Ugyldig skjemanavn',
	'formbadnametext' => 'Det er ingen skjema ved det navnet.',
	'formpattern' => '$1-skjema',
	'formtitlepattern' => 'Legger til nytt $1',
	'formsave' => 'Lagre',
	'formindexmismatch-title' => 'Navnemønster og malfeil',
	'formindexmismatch' => 'Dette skjemaet har upassende navnemønstre og maler som starter på indeks $1.',
	'formarticleexists' => 'Siden eksisterer',
	'formarticleexiststext' => 'Siden [[$1]] eksisterer allerede.',
	'formbadpagename' => 'Ugyldig sidenavn',
	'formbadrecaptcha' => 'Gale verdier fro reCaptcha. Prøv igjen.',
	'formbadpagenametext' => 'Skjemadataene du skrev inn utgjør et ugyldig sidenavn, «$1».',
	'formrequiredfielderror' => '{{PLURAL:$2|Feltet $1 er obligatorisk|Feltene $1 er obligatoriske}} for dette skjemaet. Vær vennlig og fyll {{PLURAL:$2|det|dem}} ut.',
	'formsavesummary' => 'Ny side vha. [[Special:Form/$1|skjemaet $1]]',
	'formsaveerror' => 'Feil under skjemalagring',
	'formsaveerrortext' => 'Det var en ukjent feil under lagring av siden ‘$1’.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'form-desc' => 'Un [[Special:Form|formulari d’interfàcia]] per començar de paginas novèlas',
	'form' => 'Formulari',
	'formnoname' => 'Cap de nom',
	'formnonametext' => 'Especificatz lo nom del formulari, jos la forma "Special:Formulari/NomDelFormulari".',
	'formbadname' => 'Nom incorrècte',
	'formbadnametext' => 'Lo nom causit pel formulari es incorrècte. Cap de formulari existís jos aqueste nom.',
	'formpattern' => 'formulari-$1',
	'formtitlepattern' => 'Apondre un(a) $1',
	'formsave' => 'Salvar',
	'formindexmismatch-title' => 'Paleta de nom e error de modèl',
	'formindexmismatch' => 'Aqueste formulari a de patrons e de modèls que correspòndon pas a partir de $1.',
	'formarticleexists' => "L'article existís ja.",
	'formarticleexiststext' => "L'article nomenat [[$1]] existís ja.",
	'formbadpagename' => 'Marrit nom de pagina',
	'formbadrecaptcha' => 'Valor incorrècta per reCaptcha. Ensajatz tornamai',
	'formbadpagenametext' => 'Las donadas picadas fòrman un marrit nom de pagina, « $1 ».',
	'formrequiredfielderror' => '{{PLURAL:$2|Lo camp $1 es|Los camps $1 son}} requesits dins aqueste formulari.
Vos {{PLURAL:$2|lo|los}} cal emplenar.',
	'formsavesummary' => "Crear un article novèl amb l'ajuda de [[Special:Form/$1|formulari $1]]",
	'formsaveerror' => "Una error s'es producha pendent lo salvament.",
	'formsaveerrortext' => "Una error desconeguda s'es producha pendent lo salvament de ''$1''.",
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'formsave' => 'Афтæ уæд',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 * @author Wpedzich
 */
$messages['pl'] = array(
	'form-desc' => '[[Special:Form|Formularz interfejsu]] do rozpoczynania nowych stron',
	'form' => 'Formularz',
	'formnoname' => 'Brak nazwy formularza',
	'formnonametext' => 'Musisz podać nazwę formularza, np. „{{ns:special}}:Formularz/Nazwaformularza”.',
	'formbadname' => 'Zła nazwa formularza',
	'formbadnametext' => 'Brak formularza o takiej nazwie.',
	'formpattern' => 'formularz $1',
	'formtitlepattern' => 'Dodaj nowy $1',
	'formsave' => 'Zapisz',
	'formindexmismatch-title' => 'Wzorzec nazwy i szablon nie pasują',
	'formindexmismatch' => 'W poniższym zestawieniu znajdują się niepasujące wzorce nazw i szablony, rozpoczynając od indeksu $1.',
	'formarticleexists' => 'Strona istnieje',
	'formarticleexiststext' => 'Strona [[$1]] już istnieje.',
	'formbadpagename' => 'Zła nazwa strony',
	'formbadrecaptcha' => 'Niepoprawne wartości reCaptcha. Spróbuj ponownie.',
	'formbadpagenametext' => 'Dane wpisane do formularza tworzą niepoprawną nazwę strony, „$1”.',
	'formrequiredfielderror' => '{{PLURAL:$2|Pole $1 jest|Pola $2 są}} wymagane w tym formularzu. Wypełnij je.',
	'formsavesummary' => 'Nowa strona za pomocą [[Special:Form/$1|formularza $1]]',
	'formsaveerror' => 'Błąd przy zapisywaniu formularza',
	'formsaveerrortext' => "Wystąpił nieznany błąd przy zapisywaniu strony '$1'.",
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'form-desc' => "N'[[Special:Form|antëfacia ëd forma]] për fé parte neuve pàgine",
	'form' => 'Domanda',
	'formnoname' => 'Domanda sensa tìtol',
	'formnonametext' => 'A venta deje un tìtol al mòdulo ëd domanda, coma "Special:Form/nòm_dla_domanda".',
	'formbadname' => 'Nòm dla domanda nen bon',
	'formbadnametext' => "A-i é pa gnun mòdulo ëd domanda ch'as ciama parej.",
	'formpattern' => '$1-domanda',
	'formtitlepattern' => 'Gionté $1 neuv',
	'formsave' => 'Salvé',
	'formindexmismatch-title' => 'Model dël nòm e stamp a corispondo pa',
	'formindexmismatch' => "Ës mòdulo-sì a l'ha në schema ëd nòm e stamp malcobià a parte da 'nt l'ìndess $1.",
	'formarticleexists' => 'La pàgina a-i é',
	'formarticleexiststext' => 'La pàgina [[$1]] a-i é già',
	'formbadpagename' => 'Nòm ëd pàgina pa bon',
	'formbadrecaptcha' => 'Valor pa giust për reCaptcha. Prova torna.',
	'formbadpagenametext' => 'Ij dat ant sël mòdulo ëd domanda ch\'a l\'ha butà a dan un nòm ëd pàgina nen bon, "$1".',
	'formrequiredfielderror' => "{{PLURAL:$2|Ël camp $1 a l'é|Ij camp $1 a son}} obligatòri për ës mòdulo ëd domanda-sì. 
Për piasì, {{PLURAL:$2|ch'a lo|ch'a-j}} compila.",
	'formsavesummary' => "Neuva pàgina ch'a dòvra [[Special:Form/$1|mòdul $1]]",
	'formsaveerror' => 'Eror ën salvand ël mòdulo ëd domanda',
	'formsaveerrortext' => "A-i é sta-ie n'eror amprevist ën salvand la pàgina '$1'.",
);

/** Portuguese (Português)
 * @author 555
 * @author Lijealso
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'form-desc' => 'Uma [[Special:Form|interface em formulário]] para criar novas páginas',
	'form' => 'Formulário',
	'formnoname' => 'Sem nome de formulário',
	'formnonametext' => 'Tem de fornecer um nome para o formulário, tal como "Special:Form/Nomedoformulario".',
	'formbadname' => 'Nome de formulário incorreto',
	'formbadnametext' => 'Não existe nenhum formulário com esse nome.',
	'formpattern' => 'formulário $1',
	'formtitlepattern' => 'Adicionar Novo $1',
	'formsave' => 'Gravar',
	'formindexmismatch-title' => 'Padrão do nome e predefinição não correspondem',
	'formindexmismatch' => 'Este formulário tem padrões de nome e predefinições não correspondentes a partir do índice $1.',
	'formarticleexists' => 'A página existe',
	'formarticleexiststext' => 'A página [[$1]] já existe.',
	'formbadpagename' => 'Nome de página incorreto',
	'formbadrecaptcha' => 'Valores de reCaptha incorretos. Tente novamente.',
	'formbadpagenametext' => 'Os dados que introduziu no formulário formam um nome de página incorreto, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|O campo $1 é obrigatório|Os campos $1 são obrigatórios}} neste formulário.
Por favor, {{PLURAL:$2|preencha-o|preencha-os}}.',
	'formsavesummary' => 'Nova página usando [[Special:Form/$1|formulário $1]]',
	'formsaveerror' => 'Erro ao gravar formulário',
	'formsaveerrortext' => "Houve um erro desconhecido ao gravar a página '$1'.",
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Malafaya
 */
$messages['pt-br'] = array(
	'form-desc' => 'Uma [[Special:Form|interface em formulário]] para criar novas páginas',
	'form' => 'Formulário',
	'formnoname' => 'Sem nome de formulário',
	'formnonametext' => 'Tem de fornecer um nome para o formulário, tal como "Special:Form/Nomedoformulario".',
	'formbadname' => 'Nome de formulário incorreto',
	'formbadnametext' => 'Não existe nenhum formulário com esse nome.',
	'formpattern' => 'formulário $1',
	'formtitlepattern' => 'Adicionar Novo $1',
	'formsave' => 'Salvar',
	'formindexmismatch-title' => 'Padrão do nome e predefinição não correspondem',
	'formindexmismatch' => 'Este formulário tem padrões de nome e predefinições não correspondentes a partir do índice $1.',
	'formarticleexists' => 'A página existe',
	'formarticleexiststext' => 'A página [[$1]] já existe.',
	'formbadpagename' => 'Nome de página incorreto',
	'formbadrecaptcha' => 'Valores de reCaptha incorretos. Tente novamente.',
	'formbadpagenametext' => 'Os dados que introduziu no formulário formam um nome de página incorreto, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|O campo $1 é obrigatório|Os campos $1 são obrigatórios}} neste formulário.
Por favor, {{PLURAL:$2|preencha-o|preencha-os}}.',
	'formsavesummary' => 'Nova página usando [[Special:Form/$1|formulário $1]]',
	'formsaveerror' => 'Erro ao gravar formulário',
	'formsaveerrortext' => "Houve um erro desconhecido ao salvar a página '$1'.",
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'form' => 'Formular',
	'formnoname' => 'Niciun nume pentru formular',
	'formbadname' => 'Nume incorect',
	'formtitlepattern' => 'Adaugă nou $1',
	'formsave' => 'Salvează',
	'formarticleexists' => 'Pagina există',
	'formarticleexiststext' => 'Pagina [[$1]] deja există.',
	'formsaveerror' => 'Eroare la salvarea formularului',
	'formsaveerrortext' => "A intervenit o eroare necunoscută la salvarea paginii '$1'.",
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'formsave' => 'Reggistre',
);

/** Russian (Русский)
 * @author Innv
 * @author Rubin
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'form-desc' => '[[Special:Form|Интерфейс]] (в виде формы) для создания новых страниц',
	'form' => 'Форма',
	'formnoname' => 'Нет имени формы',
	'formnonametext' => 'Вы должны указать имя формы, в виде как «Special:Form/Имяформы».',
	'formbadname' => 'Плохое имя формы',
	'formbadnametext' => 'Нет формы с таким именем.',
	'formpattern' => '$1-форма',
	'formtitlepattern' => 'Добавить новый $1',
	'formsave' => 'Сохранить',
	'formindexmismatch-title' => 'Несоответствие образца и шаблона',
	'formindexmismatch' => 'В этой форме есть несоответствие имени и шаблона в позиции $1.',
	'formarticleexists' => 'Страница существует',
	'formarticleexiststext' => 'Страница [[$1]] уже существует.',
	'formbadpagename' => 'Плохое имя страницы',
	'formbadrecaptcha' => 'Неправильное значение reCaptcha. Попробуйте ещё раз.',
	'formbadpagenametext' => 'Введённые вами данные формы, приводят к ошибочному имени страницы, «$1».',
	'formrequiredfielderror' => 'В этой форме требуется заполнить {{PLURAL:$2|$2 поле|$2 поля|$2 полей}}: $1.
Пожалуйста дозаполните {{PLURAL:$2|это поле|эти поля}}.',
	'formsavesummary' => 'Новая страница, с помощью [[Special:Form/$1|формы $1]]',
	'formsaveerror' => 'Ошибка при сохранении формы',
	'formsaveerrortext' => 'При сохранении страницы «$1» возникла неизвестная ошибка.',
);

/** Sinhala (සිංහල)
 * @author චතුනි අලහප්පෙරුම
 */
$messages['si'] = array(
	'formarticleexists' => 'පිටුව පවතියි',
	'formarticleexiststext' => '[[$1]] පිටුව දැනටමත් පවතියි.',
	'formbadpagename' => 'නොමනා පිටු නාමය',
	'formbadrecaptcha' => 'reCaptcha වෙනුවෙන් සාවද්‍යය අගයන් සැපයුමකි. යළි උත්සාහ කරන්න.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'form-desc' => '[[Special:Form|Formulárové rozhranie]] na zakladanie nových stránok',
	'form' => 'Formulár',
	'formnoname' => 'Nezadali ste názov formulára',
	'formnonametext' => 'Musíte zadať názov formulára v tvare „Special:Form/Názovformulára“',
	'formbadname' => 'Chybný názov formulára',
	'formbadnametext' => 'Formulár s takým názvom neexistuje.',
	'formpattern' => 'formulár-$1',
	'formtitlepattern' => 'Pridať nový $1',
	'formsave' => 'Uložiť',
	'formindexmismatch-title' => 'Vzor názvu a šablóna si nezodpovedajú.',
	'formindexmismatch' => 'Vzory názvu tohto formulára sa nezhodujú a šablóny začínajú od indexu $1.',
	'formarticleexists' => 'Stránka existuje',
	'formarticleexiststext' => 'Stránka [[$1]] už existuje.',
	'formbadpagename' => 'Chybný názov stránky',
	'formbadrecaptcha' => 'Neplatné hodnoty reCaptcha. Skúste to znova.',
	'formbadpagenametext' => 'Údaje formulára, ktoré ste zadali tvoria chybný názov stránky - „$1“.',
	'formrequiredfielderror' => 'Tento formulár vyžaduje vyplnenie {{PLURAL:$2|poľa $1|polí $1}}. Prosím, vyplňte {{PLURAL:$2|ho|ich}}.',
	'formsavesummary' => 'Nová stránka pomocou [[Special:Form/$1|formulára $1]]',
	'formsaveerror' => 'Chyba pri ukladaní formulára',
	'formsaveerrortext' => 'Pri ukladaní formulára sa vyskytla neznáma chyba „$1“.',
);

/** Somali (Soomaaliga)
 * @author Yariiska
 */
$messages['so'] = array(
	'formsave' => 'Kaydi',
);

/** Serbian Cyrillic ekavian (Српски (ћирилица))
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'formsave' => 'Сачувај',
	'formarticleexists' => 'Страна постоји',
);

/** Serbian Latin ekavian (Srpski (latinica))
 * @author Michaello
 */
$messages['sr-el'] = array(
	'formsave' => 'Sačuvaj',
	'formarticleexists' => 'Strana postoji',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'form' => 'Formular',
	'formnoname' => 'Naan Formularnoome',
	'formnonametext' => 'Du moast n Formularnoome ounreeke, t.B. „{{ns:Special}}:Form/Formularnoome“.',
	'formbadname' => 'Falsken Formularnoome',
	'formbadnametext' => 'Dät rakt neen Formular mäd dissen Noome',
	'formpattern' => '$1-Formular',
	'formtitlepattern' => 'Föigje näie $1 bietou',
	'formsave' => 'Spiekerje',
	'formindexmismatch' => 'Dit Formular häd n Uungliekgewicht twiske Noomensmustere un Foarloagen, ounfangend bie Index $1.',
	'formarticleexists' => 'Siede is al deer',
	'formarticleexiststext' => 'Ju Siede „[[$1]]“ is al deer.',
	'formbadpagename' => 'Ferkierde Siedennoome',
	'formbadpagenametext' => 'Do ienroate Formulardoaten moakje n ferkierden Siedennoome: „$1“.',
	'formrequiredfielderror' => 'Dät Fäild $1 is n Plichtfäild. Jädden uutfälle.',
	'formsavesummary' => 'Näie Siede, ju der ap [[{{ns:Special}}:Form/$1]] basiert',
	'formsaveerror' => 'Failer bie dät Spiekerjen fon dät Formular',
	'formsaveerrortext' => 'Dät roate n uunbekoanden Failer bie dät Spiekerjen fon ju Siede „$1“.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'form' => 'Formulir',
	'formnoname' => 'Formulir can dingaranan',
	'formnonametext' => 'Formulir anjeun kudu boga ngaran, misalna waé "Husus:Formulir/Ngaranformulir".',
	'formbadname' => 'Ngaran formulirna teu payus.',
	'formbadnametext' => 'Euweuh formulir nu ngaranna kitu.',
	'formpattern' => 'Formulir-$1',
	'formtitlepattern' => 'Tambahan $1 Anyar',
	'formsave' => 'Simpen',
	'formindexmismatch' => 'Ieu formulir mibanda pola jeung citakan ngaran nu pasalia ti indéks $1 ka handap.',
	'formarticleexists' => 'Kaca Aya',
	'formarticleexiststext' => 'Kaca [[$1]] geus aya.',
	'formbadpagename' => 'Ngaran judul goréng',
	'formbadpagenametext' => 'Data formulir nu diasupkeun ngahasilkeun ngaran kaca nu teu payus, "$1".',
	'formsaveerrortext' => "Aya éror nu teu kanyahoan nalika nyimpen kaca '$1'.",
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
 * @author Najami
 */
$messages['sv'] = array(
	'form-desc' => 'Ett [[Special:Form|formulär]] för att börja på nya sidor',
	'form' => 'Formulär',
	'formnoname' => 'Formulärnamn saknas',
	'formnonametext' => 'Du måste ange ett formulärnamn på formen "Special:Form/Formulärnamn".',
	'formbadname' => 'Felaktigt formulärnamn',
	'formbadnametext' => 'Det finns inget formulär med det namnet.',
	'formpattern' => '$1-formulär',
	'formtitlepattern' => 'Lägg till ny $1',
	'formsave' => 'Spara',
	'formindexmismatch-title' => 'Namnmönster och mallfel',
	'formindexmismatch' => 'Det här formuläret har opassande namnmönster och mallar som startar på index $1.',
	'formarticleexists' => 'Sidan existerar',
	'formarticleexiststext' => 'Sidan [[$1]] finns redan.',
	'formbadpagename' => 'Dåligt sidnamn',
	'formbadrecaptcha' => 'Ogiltiga värden från reCaptcha. Pröva igen.',
	'formbadpagenametext' => 'Formulärdatan du skrev in utgör ett ogiltigt sidnamn, "$1".',
	'formrequiredfielderror' => '{{PLURAL:$2|Fältet $1|Fälten $1}} behövs för det här formuläret.
Var god fyll i {{PLURAL:$1|det|dem}}.',
	'formsavesummary' => 'Ny sida använder [[Special:Form/$1|formuläret $1]]',
	'formsaveerror' => 'Fel under sparning av formuläret',
	'formsaveerrortext' => 'Det uppstod ett okänt fel under sparning av sidan "$1".',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'formsave' => 'Hifadhi',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'form-desc' => 'కొత్త పేజీలను మొదలుపెట్టడానికి ఒక [[Special:Form|ఫారం]]',
	'form' => 'ఫారం',
	'formnoname' => 'ఫారం పేరు లేదు',
	'formnonametext' => 'మీరు తప్పనిసరిగా ఫారానికి ఓ పేరు, "Special:Form/Nameofform" వంటిది ఇవ్వాలి.',
	'formbadname' => 'తప్పుడు ఫారం పేరు',
	'formbadnametext' => 'అటువంటి పేరుతో ఫారం లేదు.',
	'formsave' => 'భద్రపరచు',
	'formarticleexists' => 'పేజీ ఉంది',
	'formarticleexiststext' => '[[$1]] అనే పేజీ ఇప్పటికే ఉంది.',
	'formbadpagename' => 'తప్పుడు పేజీ పేరు',
	'formbadrecaptcha' => 'రీకాప్చాకి తప్పుడు విలువలు. మళ్ళీ ప్రయత్నించండి.',
	'formsavesummary' => '[[Special:Form/$1|$1 ఫారాన్ని]] వాడి కొత్త పేజీ',
	'formsaveerror' => 'ఫారాన్ని భద్రపరచడంలో పొరపాటు',
	'formsaveerrortext' => "'$1' పేజీని భద్రపరచడంలో ఏదో తెలియని పొరపాటు జరిగింది.",
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'formnonametext' => 'Шумо бояд номи формро, ба монанди "Special:Form/Nameofform" пешниҳод кунед.',
	'formbadname' => 'Номи форми номуносиб',
	'formbadnametext' => 'Ҳеҷ форме бо он ном нест.',
	'formtitlepattern' => 'Илова $1и нав',
	'formsave' => 'Захира кардан',
	'formarticleexists' => 'Саҳифа вуҷуд дорад',
	'formarticleexiststext' => 'Саҳифа [[$1]] аллакай вуҷуд дорад.',
	'formbadpagename' => 'Номи саҳифа номуносиб',
	'formbadpagenametext' => 'Додаи форме, ки шумо ворид кардаед номи номуносибе ба саҳифа, "$1" мекунад.',
	'formsaveerror' => 'Хато дар ҳоли захираи форм',
	'formsaveerrortext' => "Дар ҳоли захираи саҳифаи '$1' хатои ношиносе буд.",
);

/** Tajik (Latin) (Тоҷикӣ (Latin))
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'formnonametext' => 'Şumo bojad nomi formro, ba monandi "Special:Form/Nameofform" peşnihod kuned.',
	'formbadname' => 'Nomi formi nomunosib',
	'formbadnametext' => 'Heç forme bo on nom nest.',
	'formtitlepattern' => 'Ilova $1i nav',
	'formsave' => 'Zaxira kardan',
	'formarticleexists' => 'Sahifa vuçud dorad',
	'formarticleexiststext' => 'Sahifa [[$1]] allakaj vuçud dorad.',
	'formbadpagename' => 'Nomi sahifa nomunosib',
	'formbadpagenametext' => 'Dodai forme, ki şumo vorid kardaed nomi nomunosibe ba sahifa, "$1" mekunad.',
	'formsaveerror' => 'Xato dar holi zaxirai form',
	'formsaveerrortext' => "Dar holi zaxirai sahifai '$1' xatoi noşinose bud.",
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'formsave' => 'บันทึก',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'formsave' => 'Ýazdyr',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'form-desc' => 'Isang [[Special:Form|ugnayang-hangganan ng pormularyo]] upang makapagsimula ng bagong mga pahina',
	'form' => 'Pormularyo',
	'formnoname' => 'Walang pangalan ng pormularyo',
	'formnonametext' => 'Dapat kang magbigay ng isang pangalan ng pormularyo, katulad ng "Special:Form/Pangalanngpormularyo".',
	'formbadname' => 'Masamang pangalan ng pormularyo',
	'formbadnametext' => 'Walang pormularyong may ganyang pangalan.',
	'formpattern' => 'Pormularyong $1',
	'formtitlepattern' => 'Magdagdag ng bagong $1',
	'formsave' => 'Sagipin',
	'formindexmismatch-title' => 'Maling pagtutugma ng kabuoan ng pangalan at suleras',
	'formindexmismatch' => 'Ang pormularyong ito ay mayroong hindi magkakatugmang mga kabuoan ng pangalan at mga suleras na nagsisimula sa paksaan/indeks na $1.',
	'formarticleexists' => 'Umiiral na ang pahina',
	'formarticleexiststext' => 'Umiiral na ang pahinang [[$1]].',
	'formbadpagename' => 'Masamang pangalan ng pahina',
	'formbadrecaptcha' => "Hindi tamang mga halaga para sa muling pag-Captcha (''reCaptcha'').  Subuking muli.",
	'formbadpagenametext' => 'Ang ipinasok mong dato sa pormularyo ay gumagawa ng isang masamang pangalan ng pahina, "$1".',
	'formrequiredfielderror' => 'Ang {{PLURAL:$2|hanay na $1 ay|mga hanay na $1 ay}} kailangan para sa pormularyong ito.
Pakipunuan {{PLURAL:$2|ito|sila}} ng laman.',
	'formsavesummary' => 'Bagong pahinang gumagamit ng [[Special:Form/$1|pormularyong $1]]',
	'formsaveerror' => 'Kamalian sa pagsagip ng pormularyo',
	'formsaveerrortext' => "Nagkaroon ng isang hindi nalalamang kamalian habang sinasagip ang pahinang '$1'.",
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'form' => 'Form',
	'formnoname' => 'Form adı yok',
	'formbadnametext' => 'Bu isimde bir form yok.',
	'formtitlepattern' => 'Yeni $1 ekle',
	'formsave' => 'Kaydet',
	'formarticleexists' => 'Sayfa mevcut',
	'formbadpagename' => 'Kötü madde adı',
	'formsaveerror' => 'Formu kaydetmede hata',
);

/** Tatar (Cyrillic) (Татарча/Tatarça (Cyrillic))
 * @author Timming
 */
$messages['tt-cyrl'] = array(
	'formsavesummary' => 'Яңа бит, [[Special:Form/$1|$1 формасы]] ярдәмендә',
);

/** Ukrainian (Українська)
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'formsave' => 'Зберегти',
	'formarticleexists' => 'Сторінка існує',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'form' => 'Form',
	'formnoname' => 'Ei ole forman nimed',
	'formbadname' => 'Hond forman nimi',
	'formpattern' => '$1-form',
	'formsave' => 'Panda muštho',
	'formbadpagename' => 'Vär lehtpolen nimi',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'form' => 'Biểu mẫu',
	'formnoname' => 'Biểu mẫu không có tên',
	'formtitlepattern' => 'Thêm $1 mới',
	'formsave' => 'Lưu',
	'formarticleexists' => 'Trang đã tồn tại',
	'formarticleexiststext' => 'Trang [[$1]] đã tồn tại.',
	'formsavesummary' => 'Trang mới theo [[Special:Form/$1|biểu mẫu $1]]',
	'formsaveerror' => 'Lỗi lưu biểu mẫu',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'form-desc' => '[[Special:Form|Fomet]] ad primön padis nulik',
	'form' => 'Fomet',
	'formnoname' => 'Fometanem nonik',
	'formnonametext' => 'Mutol penön fometanemi, a.s. „Special:Form/Fometanem“.',
	'formbadname' => 'Fometanem no lonöföl',
	'formbadnametext' => 'No dabinon fomet labü nem at.',
	'formpattern' => 'fomet-$1',
	'formtitlepattern' => 'Läükön $1i nulik',
	'formsave' => 'Dakipön',
	'formarticleexists' => 'Pad dabinon',
	'formarticleexiststext' => 'Pad at: [[$1]] ya dabinon.',
	'formbadpagename' => 'Padanem no lonöföl',
	'formbadpagenametext' => 'Fometanünods fa ol pepenöls jafons padanemi no lonöföl: „$1“.',
	'formrequiredfielderror' => 'Fel: $1 paflagon in fomet at.
Fulükolös oni.',
	'formsavesummary' => 'Pad nulik me [[Special:Form/$1|fomet: $1]]',
	'formsaveerror' => 'Pöl pö dakip fometa',
	'formsaveerrortext' => 'Pöl nesevädik ejenon dü dakip pada: „$1“.',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'formsave' => 'אויפֿהיטן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Liangent
 */
$messages['zh-hans'] = array(
	'form' => '表单',
	'formnoname' => '没有表单名',
	'formnonametext' => '你必须提供一个表单名，如“Special:Form/表单名”。',
	'formbadname' => '错误的表单名',
	'formbadnametext' => '没有这个名字的表单。',
	'formpattern' => '$1-表单',
	'formtitlepattern' => '添加新的$1',
	'formsave' => '保存',
	'formarticleexists' => '页面存在',
	'formbadpagename' => '错误的表单名',
	'formsaveerror' => '储存表格时发生错误',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'form' => '表格',
	'formnoname' => '未有表格名稱',
	'formnonametext' => '你必須提供一個表單名，如“Special:Form/表單名”。',
	'formbadname' => '錯誤的表單名',
	'formbadnametext' => '沒有這個名字的表單。',
	'formpattern' => '$1-表單',
	'formtitlepattern' => '添加新的$1',
	'formsave' => '儲存',
	'formarticleexists' => '頁面存在',
	'formbadpagename' => '錯誤的表單名',
	'formsaveerror' => '儲存表格時發生錯誤',
);

