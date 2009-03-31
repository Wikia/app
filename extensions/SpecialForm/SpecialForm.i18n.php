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
	'formrequiredfieldpluralerror' => 'The fields $1 are required for this form.
Please fill them in.',
	'formrequiredfielderror'       => 'The field $1 is required for this form.
Please fill it in.',
	'formsavesummary'              => 'New page using [[Special:Form/$1|form $1]]',
	'formsaveerror'                => 'Error saving form',
	'formsaveerrortext'            => 'There was an unknown error saving page \'$1\'.',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Purodha
 */
$messages['qqq'] = array(
	'form-desc' => 'Short description of the Form extension, shown on [[Special:Version]]. Do not translate or change links.',
	'formsave' => '{{Identical|Save}}',
);

/** Afrikaans (Afrikaans)
 * @author SPQRobin
 */
$messages['af'] = array(
	'formsave' => 'Stoor',
);

/** Arabic (العربية)
 * @author Meno25
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
	'formsave' => 'حفظ',
	'formindexmismatch-title' => 'نمط الاسم والقالب لا يتطابقان',
	'formindexmismatch' => 'هذه الاستمارة بها أنماط أسماء وقوالب غير متطابقة بدءا عند الفهرس $1.',
	'formarticleexists' => 'الصفحة موجودة',
	'formarticleexiststext' => 'الصفحة [[$1]] موجودة بالفعل.',
	'formbadpagename' => 'اسم صفحة سيء',
	'formbadrecaptcha' => 'قيم غير صحيحة لreCaptcha. حاول مرة ثانية.',
	'formbadpagenametext' => 'بيانات الاستمارة التي أدخلتها تصنع اسم صفحة سيئا، "$1".',
	'formrequiredfieldpluralerror' => 'الحقول $1 مطلوبة لهذه الاستمارة.
من فضلك املأها.',
	'formrequiredfielderror' => 'الحقل $1 مطلوب لهذه الاستمارة.
من فضلك املأه.',
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
	'formrequiredfieldpluralerror' => 'الحقول $1 مطلوبة لهذه الاستمارة.
من فضلك املأها.',
	'formrequiredfielderror' => 'الحقل $1 مطلوب لهذه الاستمارة.
من فضلك املأه.',
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
 */
$messages['be-tarask'] = array(
	'formsave' => 'Захаваць',
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
	'formrequiredfieldpluralerror' => 'Този формуляр изисква полетата $1 да бъдат попълнени.',
	'formrequiredfielderror' => 'Този формуляр изисква полето $1 да бъде попълнено.',
	'formsaveerror' => 'Грешка при съхранение на формуляра',
	'formsaveerrortext' => "Възникна непозната грешка при опит да се съхрани страницата '$1'.",
);

/** Czech (Česky)
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
	'formrequiredfieldpluralerror' => 'Tento formulář vyžaduje vyplnění polí $1. Prosím, vyplňte je.',
	'formrequiredfielderror' => 'Tento formulář vyžaduje vyplnění pole $1. Prosím, vyplňte ho.',
	'formsavesummary' => 'Nová stránka pomocí [[Special:Form/$1|formuláře $1]]',
	'formsaveerror' => 'Chyba při ukládání formuláře',
	'formsaveerrortext' => "Při ukládání formuláře se vyskytla neznámá chyba: ''$1''.",
);

/** German (Deutsch)
 * @author Melancholie
 * @author Umherirrender
 */
$messages['de'] = array(
	'form-desc' => 'Eine [[Special:Form|Eingabemaske]] für das Erzeugen von neuen Seiten',
	'form' => 'Formular',
	'formnoname' => 'Kein Formularname',
	'formnonametext' => 'Du musst einen Formularnamen angeben, z.B. „{{ns:Special}}:Form/Formularname“.',
	'formbadname' => 'Falscher Formularname',
	'formbadnametext' => 'Es gibt kein Formular mit diesem Namen',
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
	'formrequiredfieldpluralerror' => 'Die Felder $1 sind Pflichtfelder. Bitte fülle sie aus.',
	'formrequiredfielderror' => 'Das Feld $1 ist ein Pfichtfeld. Bitte fülle es aus.',
	'formsavesummary' => 'Neue Seite, die auf dem [[Special:Form/$1|Formular $1]] basiert',
	'formsaveerror' => 'Fehler beim Speichern des Formulares',
	'formsaveerrortext' => 'Es gab einen unbekannten Fehler beim Speichern der Seite „$1“.',
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
	'formrequiredfieldpluralerror' => 'Póla $1 su trěbne za toś ten formulary.
Wupołń je pšosym.',
	'formrequiredfielderror' => 'Pólo $1 jo trěbne za ten fromular.
Wupołń jo pšosym.',
	'formsavesummary' => 'Nowy bok na zakłaźe [[Special:Form/formulara $1]]',
	'formsaveerror' => 'Zmólka pśi składowanju formulara',
	'formsaveerrortext' => "Njeznata zmólka jo nastała pśi składowanju boka '$1'.",
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'formsave' => 'Αποθηκεύστε',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'form' => 'Formulario',
	'formnoname' => 'Neniu nomo de kamparo',
	'formpattern' => '$1-formularo',
	'formtitlepattern' => 'Aldoni nova $1',
	'formsave' => 'Konservi',
	'formarticleexists' => 'Paĝo ekzistas',
	'formarticleexiststext' => 'La paĝo [[$1]] jam ekzistas.',
	'formbadpagename' => 'Fuŝa paĝnomo',
	'formrequiredfieldpluralerror' => 'La kampoj $1 estas devigaj por ĉi tiu kamparo.
Bonvolu plenumi ilin.',
	'formrequiredfielderror' => 'La kampo $1 estas deviga por ĉi tiu kamparo.
Bonvolu plenumi ĝin.',
	'formsaveerrortext' => "Estis nekonata eraro konservante paĝon '$1'.",
);

/** Spanish (Español)
 * @author Imre
 * @author Sanbec
 */
$messages['es'] = array(
	'form' => 'Formulario',
	'formpattern' => 'Formulario de $1',
	'formsave' => 'Guardar',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'form' => 'Formularioa',
	'formsave' => 'Gorde',
);

/** Finnish (Suomi)
 * @author Jack Phoenix
 */
$messages['fi'] = array(
	'form' => 'Lomake',
	'formnoname' => 'Ei lomakkeen nimeä',
	'formnonametext' => 'Sinun tulee antaa lomakkeen nimi, kuten "Special:Form/Lomakkeennimi".',
	'formbadname' => 'Huono lomakkeen nimi',
	'formbadnametext' => 'Haluamallasi nimellä ei ole lomaketta.',
	'formpattern' => '$1-lomake',
	'formtitlepattern' => 'Lisää uusi $1',
	'formsave' => 'Tallenna',
	'formindexmismatch' => 'Tällä lomakkeella on yhteensopimattomat nimi- ja mallinekaavat alkaen riviltä $1.',
	'formarticleexists' => 'Sivu on jo olemassa',
	'formarticleexiststext' => 'Sivu [[$1]] on jo olemassa.',
	'formbadpagename' => 'Huono sivun nimi',
	'formbadpagenametext' => 'Antamasi lomakkeen tiedot tekevät huonon sivun nimen, "$1".',
	'formrequiredfieldpluralerror' => 'Kentät $1 ovat pakollisia tälle lomakkeelle. Ole hyvä ja täytä ne.',
	'formrequiredfielderror' => 'Kenttä $1 on pakollinen tälle lomakkeelle. Ole hyvä ja täytä se.',
	'formsavesummary' => 'Uusi sivu käyttäen [[Special:Form/$1]]',
	'formsaveerror' => 'Virhe lomaketta tallennettaessa',
	'formsaveerrortext' => "Tuntematon virhe tapahtui sivua '$1' tallennettaessa.",
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author McDutchie
 * @author Sherbrooke
 */
$messages['fr'] = array(
	'form-desc' => 'Une [[Special:Form|interface de formulaire]] pour commencer des nouvelles pages',
	'form' => 'Formulaire',
	'formnoname' => 'Aucun nom',
	'formnonametext' => 'Veuillez spécifier le nom du formulaire, sous la forme « Special:Formulaire/NomDuFormulaire ».',
	'formbadname' => 'Nom incorrect',
	'formbadnametext' => "Le nom choisi pour le formulaire est incorrect. Aucun formulaire n'existe sous ce nom.",
	'formpattern' => 'formulaire-$1',
	'formtitlepattern' => 'Ajouter un(e) $1',
	'formsave' => 'Sauvegarder',
	'formindexmismatch-title' => 'Palette de nom et erreur de modèle',
	'formindexmismatch' => 'Ce formulaire a des patrons et des modèles qui ne correspondent pas à partir de $1.',
	'formarticleexists' => 'La page existe déjà.',
	'formarticleexiststext' => 'La page nommée [[$1]] existe déjà.',
	'formbadpagename' => 'Mauvais nom de page',
	'formbadrecaptcha' => 'Valeur incorrecte pour reCaptcha. Essayez à nouveau',
	'formbadpagenametext' => 'Les données saisies forment un mauvais nom de page, « $1 ».',
	'formrequiredfieldpluralerror' => 'Les champs $1 sont requis dans ce formulaire.',
	'formrequiredfielderror' => 'Le champ $1 est requis dans ce formulaire.',
	'formsavesummary' => 'Nouvelle page utilisant [[Special:Form/$1|le formulaire $1]]',
	'formsaveerror' => "Une erreur s'est produite pendant la sauvegarde.",
	'formsaveerrortext' => "Une erreur inconnue s'est produite pendant la sauvegarde de ''$1''.",
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
	'formrequiredfieldpluralerror' => 'Os campos $1 son requiridos para este formulario. Por favor, énchaos.',
	'formrequiredfielderror' => 'O campo $1 é requerido para este formulario. Énchao.',
	'formsavesummary' => 'Nova páxina usando [[Special:Form/$1|o formulario $1]]',
	'formsaveerror' => 'Erro ao gardar o formulario',
	'formsaveerrortext' => "Houbo un erro descoñecido ao gardar a páxina '$1'.",
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
	'formrequiredfieldpluralerror' => 'השדות $1 נדרשים להשלמת טופס זה.
אנא מלאו אותם.',
	'formrequiredfielderror' => 'מילוי השדה $1 נדרש להשלמת טופס זה.
אנא מלאו אותו.',
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
	'formrequiredfieldpluralerror' => 'Pola $1 su trěbne pola. Prošu wupjelń je.',
	'formrequiredfielderror' => 'Polo $1 je trěbne polo. Prošu wupjelń je.',
	'formsavesummary' => 'Nowa strona, kotraž [[Special:Form/$1|formular $1]] wužiwa.',
	'formsaveerror' => 'Zmylk při składowanju formulara',
	'formsaveerrortext' => 'Bě njeznaty zmylk při składowanju nastawka "$1".',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'formsave' => 'Mentés',
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
	'formbadrecaptcha' => 'Valores incorrecte pro reCaptcha. Reprova.',
	'formbadpagenametext' => 'Le datos de formulario que tu entrava resulta in un nomine de pagina invalide, "$1".',
	'formrequiredfieldpluralerror' => 'Le campos $1 es requirite pro iste formulario.
Per favor completa los.',
	'formrequiredfielderror' => 'Le campo $1 es requirite pro iste formulario.
Per favor completa lo.',
	'formsavesummary' => 'Nove pagina con [[Special:Form/$1|le formulario $1]]',
	'formsaveerror' => 'Error durante le immagazinage del formulario',
	'formsaveerrortext' => "Il occurreva un error incognite durante le immagazinage del pagina '$1'.",
);

/** Indonesian (Bahasa Indonesia)
 * @author Irwangatot
 */
$messages['id'] = array(
	'formsave' => 'Simpan',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'formsave' => 'Vista',
);

/** Japanese (日本語)
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'formsave' => '保存',
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
	'formrequiredfielderror' => 'Lapangan $1 diperlokaké kanggo formulir iki.
Tulung diisi.',
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
	'formrequiredfieldpluralerror' => 'De Felder $1 möße aanjejovve wäde. Donn se ußfölle.',
	'formrequiredfielderror' => 'Dat Feld $1 moß aanjejovve wäde. Donn et ußfölle.',
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
 * @author Robby
 */
$messages['lb'] = array(
	'form-desc' => 'E [[Special:Form|Formulaire]] fir nei Säiten unzefänken',
	'form' => 'Formulaire',
	'formnoname' => 'Keen Numm vum Formulaire',
	'formbadname' => 'Falsche Numm vum Formulaire',
	'formbadnametext' => 'Et gëtt kee Formaulaire mat dem Numm.',
	'formpattern' => '$1-Formulaire',
	'formtitlepattern' => 'Nei $1 derbäisetzen',
	'formsave' => 'Späicheren',
	'formarticleexists' => "D'Säit gëtt et schonn.",
	'formarticleexiststext' => "D'Säit [[$1]] gëtt et schonn.",
	'formbadpagename' => 'Falsche Säitennumm',
	'formbadpagenametext' => 'Déi Donnéeën déi Dir an de Formulaire aginn hutt erginn e Säitennumm, den net ka gespäichert ginn: "$1".',
	'formrequiredfieldpluralerror' => "D'Felder $1 sinn obligatoresch fir dëse Formulaire.
Fëllt se w.e.g. aus.",
	'formrequiredfielderror' => "D'Feld $1 muss an dësem Formulaire ausgefëllt ginn.",
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
	'formrequiredfieldpluralerror' => '$1 रकाने या अर्जाकरिता आवश्यक आहेत.
कृपया ते भरा.',
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
	'formrequiredfieldpluralerror' => 'De velden $1 zijn verplicht voor dit formulier. Vul ze alstublieft in.',
	'formrequiredfielderror' => 'Het veld $1 is verplicht voor dit formulier. Vul het alstublieft in.',
	'formsavesummary' => 'Nieuwe pagina via [[Special:Form/$1|formulier $1]]',
	'formsaveerror' => 'Fout bij opslaan formulier',
	'formsaveerrortext' => "Er is een onbekende fout opgetreden bij het opslaan van pagina '$1'.",
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Frokor
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
	'formrequiredfieldpluralerror' => 'Felta $1 er påkrevde for dette skjemaet. Ver venleg å fyll dei inn.',
	'formrequiredfielderror' => 'Feltet $1 er påkrevd for dette skjemaet. Ver venleg å fyll det inn.',
	'formsavesummary' => 'Ny side vha. [[Special:Form/$1|skjemaet $1]]',
	'formsaveerror' => 'Feil under skjemalagring',
	'formsaveerrortext' => 'Det var ein ukjend feil under lagring av sida ‘$1’.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
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
	'formrequiredfieldpluralerror' => 'Feltene $1 er påkrevde for dette skjemaet. Vennligst fyll dem inn.',
	'formrequiredfielderror' => 'Feltet $1 er påkrevd for dette skjemaet. Vennligst fyll det inn.',
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
	'formrequiredfieldpluralerror' => 'Los camps $1 son requeses dins aqueste formulari.',
	'formrequiredfielderror' => 'Lo camp $1 es requés dins aqueste formulari.',
	'formsavesummary' => "Crear un article novèl amb l'ajuda de [[Special:Form/$1|formulari $1]]",
	'formsaveerror' => "Una error s'es producha pendent lo salvament.",
	'formsaveerrortext' => "Una error desconeguda s'es producha pendent lo salvament de ''$1''.",
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
	'formrequiredfieldpluralerror' => 'Pola $1 są wymagane w tym formularzu. Prosimy o wypełnienie ich.',
	'formrequiredfielderror' => 'Pole $1 jest wymagane w tym formularzu. Wypełnij je.',
	'formsavesummary' => 'Nowa strona za pomocą [[Special:Form/$1|formularza $1]]',
	'formsaveerror' => 'Błąd przy zapisywaniu formularza',
	'formsaveerrortext' => "Wystąpił nieznany błąd przy zapisywaniu strony '$1'.",
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'form' => 'Domanda',
	'formnoname' => 'Domanda sensa tìtol',
	'formnonametext' => 'A venta deje un tìtol al mòdulo ëd domanda, coma "Special:Form/nòm_dla_domanda".',
	'formbadname' => 'Nòm dla domanda nen bon',
	'formbadnametext' => "A-i é pa gnun mòdulo ëd domanda ch'as ciama parej.",
	'formpattern' => '$1-domanda',
	'formtitlepattern' => 'Gionté $1 neuv',
	'formsave' => 'Salvé',
	'formindexmismatch' => "Ës mòdulo-sì a l'ha në schema ëd nòm e stamp malcobià a parte da 'nt l'ìndess $1.",
	'formarticleexists' => 'La pàgina a-i é',
	'formarticleexiststext' => 'La pàgina [[$1]] a-i é già',
	'formbadpagename' => 'Nòm ëd pàgina pa bon',
	'formbadpagenametext' => 'Ij dat ant sël mòdulo ëd domanda ch\'a l\'ha butà a dan un nòm ëd pàgina nen bon, "$1".',
	'formrequiredfieldpluralerror' => "Ij camp $1 a son obligatòri për ës mòdulo ëd domanda-sì. Për piasì, ch'a jë compila.",
	'formrequiredfielderror' => "Ël camp $1 a l'é obligatòri për ës mòdulo ëd domanda-sì. Për piasì, ch'a lo compila.",
	'formsavesummary' => "Neuva pàgina ch'a dòvra [[Special:Form/$1]]",
	'formsaveerror' => 'Eror ën salvand ël mòdulo ëd domanda',
	'formsaveerrortext' => "A-i é sta-ie n'eror amprevist ën salvand la pàgina '$1'.",
);

/** Portuguese (Português)
 * @author 555
 * @author Lijealso
 * @author Malafaya
 */
$messages['pt'] = array(
	'form' => 'Formulário',
	'formtitlepattern' => 'Adicionar Novo $1',
	'formsave' => 'Salvar',
	'formarticleexists' => 'Página Existe',
	'formarticleexiststext' => 'A página [[$1]] já existe.',
	'formrequiredfieldpluralerror' => 'Os campos $1 são obrigatórios neste formulário. Por favor, preencha-os.',
	'formsavesummary' => 'Nova página usando [[Special:Form/$1|formulário $1]]',
	'formsaveerror' => 'Erro ao salvar formulário',
	'formsaveerrortext' => "Houve um erro desconhecido ao salvar a página '$1'.",
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'formsave' => 'Salvează',
	'formarticleexists' => 'Pagina există',
	'formarticleexiststext' => 'Pagina [[$1]] deja există.',
	'formsaveerror' => 'Eroare la salvarea formularului',
	'formsaveerrortext' => "A intervenit o eroare necunoscută la salvarea paginii '$1'.",
);

/** Russian (Русский)
 * @author Innv
 * @author Rubin
 */
$messages['ru'] = array(
	'formsave' => 'Сохранить',
	'formarticleexists' => 'Страница существует',
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
	'formarticleexiststext' => 'Stránka [[$1]] úž existuje.',
	'formbadpagename' => 'Chybný názov stránky',
	'formbadrecaptcha' => 'Neplatné hodnoty reCaptcha. Skúste to znova.',
	'formbadpagenametext' => 'Údaje formulára, ktoré ste zadali tvoria chybný názov stránky - „$1“.',
	'formrequiredfieldpluralerror' => 'Tento formulár vyžaduje vyplnenie polí $1. Prosím, vyplňte ich.',
	'formrequiredfielderror' => 'Tento formulár vyžaduje vyplnenie poľa $1. Prosím, vyplňte ho.',
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

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'formsave' => 'Сачувај',
	'formarticleexists' => 'Страна постоји',
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
	'formrequiredfieldpluralerror' => 'Do Fäildere $1 sunt Plichtfäildere. Jädden uutfälle.',
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
	'formrequiredfieldpluralerror' => 'Eusieun $1 kudu dieusian. Mangga eusian heula.',
	'formsaveerrortext' => "Aya éror nu teu kanyahoan nalika nyimpen kaca '$1'.",
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Lejonel
 * @author M.M.S.
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
	'formrequiredfieldpluralerror' => 'Fälten $1 behövs för det här formuläret.
Var god fyll i dom.',
	'formrequiredfielderror' => 'Fältet $1 behövs för det här formuläret.
Var god fyll i det.',
	'formsavesummary' => 'Ny sida använder [[Special:Form/$1|formuläret $1]]',
	'formsaveerror' => 'Fel under sparning av formuläret',
	'formsaveerrortext' => 'Det uppstod ett okänt fel under sparning av sidan "$1".',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
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
	'formrequiredfieldpluralerror' => 'Ноҳияҳои $1 дар ин форм заруранд.
Лутфон онҳоро пур кунед.',
	'formsaveerror' => 'Хато дар ҳоли захираи форм',
	'formsaveerrortext' => "Дар ҳоли захираи саҳифаи '$1' хатои ношиносе буд.",
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'formsave' => 'บันทึก',
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
	'formrequiredfieldpluralerror' => 'Kinakailangan ang mga kahanayang $1 para sa pormularyong ito.
Pakipunuan lamang silang muli.',
	'formrequiredfielderror' => 'Kinakailangan ang kahanayang $1 para sa pormularyong ito.
Pakipunuan ito.',
	'formsavesummary' => 'Bagong pahinang gumagamit ng [[Special:Form/$1|pormularyong $1]]',
	'formsaveerror' => 'Kamalian sa pagsagip ng pormularyo',
	'formsaveerrortext' => "Nagkaroon ng isang hindi nalalamang kamalian habang sinasagip ang pahinang '$1'.",
);

/** Ukrainian (Українська)
 * @author Aleksandrit
 */
$messages['uk'] = array(
	'formsave' => 'Зберегти',
	'formarticleexists' => 'Сторінка існує',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'formsave' => '保存',
	'formarticleexists' => '页面存在',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'formsave' => '儲存',
	'formarticleexists' => '頁面存在',
);

