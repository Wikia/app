<?php
/* Internationalisation extension for SpecialCreateSignDocument
 * @MessageGroup SpecialCreateSignDocument
*/

$messages = array();

$messages['en'] = array(
	'createsigndocument'         => 'Enable document signing',
	'createsigndoc-head'         => "Use this form to create a 'Sign document' page for the provided page, such that users will be able to [[Special:SignDocument|sign it]].
Please specify the name of the page on which you wish to enable digital signing, members of which usergroup should be allowed to sign it, which fields you wish to be visible to users and which should be optional, a minimum age to require users to be to sign the document (no minimum if omitted);
and a brief introductory text describing the document and providing instructions to users.

<b>There is presently no way to delete or modify signature documents after they are created</b> without direct database access.
Additionally, the text of the page displayed on the signature page will be the ''current'' text of the page, regardless of changes made to it after today.
Please be absolutely positive that the document is to a point of stability for signing.
Please also be sure that you specify all fields exactly as they should be, ''before submitting this form''.",
	'createsigndoc-pagename'     => 'Page:',
	'createsigndoc-allowedgroup' => 'Allowed group:',
	'createsigndoc-email'        => 'E-mail address:',
	'createsigndoc-address'      => 'House address:',
	'createsigndoc-extaddress'   => 'City, state, country:',
	'createsigndoc-phone'        => 'Phone number:',
	'createsigndoc-bday'         => 'Birthdate:',
	'createsigndoc-minage'       => 'Minimum age:',
	'createsigndoc-introtext'    => 'Introduction:',
	'createsigndoc-hidden'       => 'Hidden',
	'createsigndoc-optional'     => 'Optional',
	'createsigndoc-create'       => 'Create',
	'createsigndoc-error-generic'=> 'Error: $1',
	'createsigndoc-error-pagenoexist' => 'Error: The page [[$1]] does not exist.',
	'createsigndoc-success'      => 'Document signing has been successfully enabled on [[$1]].
To test it, please visit [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} this page].',
	'createsigndoc-error-alreadycreated' => 'Document signing "$1" already exist.'
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 */
$messages['qqq'] = array(
	'createsigndoc-pagename' => '{{Identical|Page}}',
	'createsigndoc-email' => '{{Identical|E-mail address}}',
	'createsigndoc-phone' => '{{Identical|Phone number}}',
	'createsigndoc-hidden' => '{{Identical|Hidden}}',
	'createsigndoc-optional' => '{{Identical|Optional}}',
	'createsigndoc-create' => '{{Identical|Create}}',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'createsigndoc-pagename' => 'Bladsy:',
	'createsigndoc-email' => 'E-pos adres',
	'createsigndoc-create' => 'Skep',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'createsigndoc-email' => 'የኢ-ሜል አድራሻ:',
	'createsigndoc-phone' => 'የስልክ ቁጥር፦',
	'createsigndoc-error-generic' => 'ስህተት፦ $1',
);

/** Aragonese (Aragonés)
 * @author Remember the dot
 */
$messages['an'] = array(
	'createsigndoc-pagename' => 'Pachina:',
);

/** Old English (Anglo-Saxon)
 * @author Meno25
 */
$messages['ang'] = array(
	'createsigndoc-pagename' => 'Tramet:',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'createsigndocument' => 'فعل توقيع الوثيقة',
	'createsigndoc-head' => "استخدم هذه الاستمارة لإنشاء صفحة 'Sign Document' للصفحة المعطاة، بحيث يمكن للمستخدمين [[Special:SignDocument|توقيعها]].
من فضلك حدد اسم الصفحة التي تود تفعيل التوقيع الرقمي عليها، أعضاء أي مجموعة مستخدم مسموح لهم بتوقيعها، أي حقول تود أن تكون مرئية للمستخدمين وأي يجب أن تكون اختيارية، عمر أدنى لمستخدمين ليمكن لهم توقيع الوثيقة (لا حد أدنى لو حذفت)؛
ونص تقديمي مختصر يصف الوثيقة ويوفر التعليمات للمستخدمين.

<b>لا توجد حاليا أية طريقة لحذف أو تعديل توقيعات الوثائق بعد
إنشائها</b> بدون دخول قاعدة البيانات مباشرة.
إضافة إلى ذلك، نص الصفحة 
المعروض في صفحة التوقيع سيكون النص ''الحالي'' للصفحة، بغض النظر عن
التغييرات بها بعد اليوم.
من فضلك كن متأكدا تماما من أن الوثيقة وصلت لنقطة ثبات للتوقيع، ومن فضلك أيضا تأكد أنك حددت كل الحقول تماما كما يجب أن تكون، ''قبل تنفيذ هذه الاستمارة''.",
	'createsigndoc-pagename' => 'صفحة:',
	'createsigndoc-allowedgroup' => 'المجموعة المسموحة:',
	'createsigndoc-email' => 'عنوان البريد الإلكتروني:',
	'createsigndoc-address' => 'عنوان المنزل:',
	'createsigndoc-extaddress' => 'المدينة، الولاية، الدولة:',
	'createsigndoc-phone' => 'رقم الهاتف:',
	'createsigndoc-bday' => 'تاريخ الميلاد:',
	'createsigndoc-minage' => 'العمر الأدنى:',
	'createsigndoc-introtext' => 'مقدمة:',
	'createsigndoc-hidden' => 'مخفية',
	'createsigndoc-optional' => 'اختياري',
	'createsigndoc-create' => 'إنشاء',
	'createsigndoc-error-generic' => 'خطأ: $1',
	'createsigndoc-error-pagenoexist' => 'خطأ: الصفحة [[$1]] غير موجودة.',
	'createsigndoc-success' => 'توقيع الوثيقة تم تفعيله بنجاح على [[$1]].
لاختباره، من فضلك زر [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} هذه الصفحة].',
	'createsigndoc-error-alreadycreated' => 'توقيع الوثيقة "$1" موجود بالفعل.',
);

/** Araucanian (Mapudungun)
 * @author Remember the dot
 */
$messages['arn'] = array(
	'createsigndoc-pagename' => 'Pakina:',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'createsigndocument' => 'فعل توقيع الوثيقة',
	'createsigndoc-head' => "استخدم هذه الاستمارة لإنشاء صفحة 'Sign Document' للصفحة المعطاة، بحيث يمكن للمستخدمين [[Special:SignDocument|توقيعها]].
من فضلك حدد اسم الصفحة التى تود تفعيل التوقيع الرقمى عليها، أعضاء أى مجموعة مستخدم مسموح لهم بتوقيعها، أى حقول تود أن تكون مرئية للمستخدمين وأى يجب أن تكون اختيارية، عمر أدنى لمستخدمين ليمكن لهم توقيع الوثيقة (لا حد أدنى لو حذفت)؛
ونص تقديمى مختصر يصف الوثيقة ويوفر التعليمات للمستخدمين.

<b>لا توجد حاليا أية طريقة لحذف أو تعديل توقيعات الوثائق بعد
إنشائها</b> بدون دخول قاعدة البيانات مباشرة.
إضافة إلى ذلك، نص الصفحة 
المعروض فى صفحة التوقيع سيكون النص ''الحالي'' للصفحة، بغض النظر عن
التغييرات بها بعد اليوم.
من فضلك كن متأكدا تماما من أن الوثيقة وصلت لنقطة ثبات للتوقيع، ومن فضلك أيضا تأكد أنك حددت كل الحقول تماما كما يجب أن تكون، ''قبل تنفيذ هذه الاستمارة''.",
	'createsigndoc-pagename' => 'صفحة:',
	'createsigndoc-allowedgroup' => 'المجموعة المسموحة:',
	'createsigndoc-email' => 'عنوان البريد الإلكتروني:',
	'createsigndoc-address' => 'عنوان المنزل:',
	'createsigndoc-extaddress' => 'المدينة، الولاية، الدولة:',
	'createsigndoc-phone' => 'رقم الهاتف:',
	'createsigndoc-bday' => 'تاريخ الميلاد:',
	'createsigndoc-minage' => 'العمر الأدنى:',
	'createsigndoc-introtext' => 'مقدمة:',
	'createsigndoc-hidden' => 'مخفية',
	'createsigndoc-optional' => 'اختياري',
	'createsigndoc-create' => 'إنشاء',
	'createsigndoc-error-generic' => 'خطأ: $1',
	'createsigndoc-error-pagenoexist' => 'خطأ: الصفحة [[$1]] غير موجودة.',
	'createsigndoc-success' => 'توقيع الوثيقة تم تفعيله بنجاح على [[$1]].
لاختباره، من فضلك زر [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} هذه الصفحة].',
	'createsigndoc-error-alreadycreated' => 'توقيع الوثيقة "$1" موجود بالفعل.',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'createsigndoc-pagename' => 'Páhina:',
	'createsigndoc-bday' => 'Kamondágan:',
	'createsigndoc-create' => 'Maggibo',
	'createsigndoc-error-generic' => 'Salâ: $1',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 */
$messages['be-tarask'] = array(
	'createsigndoc-pagename' => 'Старонка:',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'createsigndoc-pagename' => 'Страница:',
	'createsigndoc-allowedgroup' => 'Позволена група:',
	'createsigndoc-email' => 'Електронна поща:',
	'createsigndoc-address' => 'Домашен адрес:',
	'createsigndoc-extaddress' => 'Град, щат, държава:',
	'createsigndoc-phone' => 'Телефонен номер:',
	'createsigndoc-bday' => 'Дата на раждане:',
	'createsigndoc-minage' => 'Минимална възраст:',
	'createsigndoc-introtext' => 'Въведение:',
	'createsigndoc-hidden' => 'Скрито',
	'createsigndoc-optional' => 'Незадължително',
	'createsigndoc-create' => 'Създаване',
	'createsigndoc-error-generic' => 'Грешка: $1',
	'createsigndoc-error-pagenoexist' => 'Грешка: Страницата [[$1]] не съществува.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'createsigndoc-pagename' => 'Stranica:',
	'createsigndoc-create' => 'Napravi',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'createsigndoc-pagename' => 'Pàgina:',
	'createsigndoc-hidden' => 'Amagat',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'createsigndoc-create' => 'Creà',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'createsigndoc-pagename' => 'страни́ца :',
);

/** Danish (Dansk)
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'createsigndoc-create' => 'Opret',
);

/** German (Deutsch)
 * @author Leithian
 * @author Melancholie
 * @author Revolus
 */
$messages['de'] = array(
	'createsigndocument' => 'Dokumentensignieren erlauben',
	'createsigndoc-head' => "Benutze dieses Formular, um ein „Signaturdokument“ für die gegebene Seite zu erstellen, so dass Benutzer in der Lage sein werden, es zu [[Special:SignDocument|signieren]].
Bitte gib den Namen der Seite an, auf welcher du digitales Signieren erlauben willst, welche Benutzergruppen in der Lage sein sollen, sie zu signieren, welche Felder sichtbar sein sollen und welche optional, ein gegebenenfalls minimales Benutzeralter, um das Dokument zu unterzeichnen, und einen kurzen Einleitungstext, der dem Benutzer das Dokument beschreibt und ihm eine kurze Anleitung gibt.

<b>Derzeit ist es nicht möglich, einmal gegebene Signaturen zu modifizieren oder zu entfernen</b> ohne direkt die Datenbank zu bearbeiten.
Zusätzlich wird der angezeigte Text beim Signieren der Seite der ''derzeitige'' Text sein, egal welche Änderungen danach noch vorgenommen wurden.
Bitte sei dir absolut sicher, dass das Dokument in einem ausreichend stabilen Zustand zum Signieren ist.
Bitte sei dir ebenfalls sicher, dass du alle nötigen Felder angegeben hast, ''bevor du dieses Formular übersendest''.",
	'createsigndoc-pagename' => 'Seite:',
	'createsigndoc-allowedgroup' => 'Erlaubte Gruppen:',
	'createsigndoc-email' => 'E-Mail-Adresse:',
	'createsigndoc-address' => 'Hausanschrift:',
	'createsigndoc-extaddress' => 'Stadt, Staat, Land:',
	'createsigndoc-phone' => 'Telefonnummer:',
	'createsigndoc-bday' => 'Geburtstag:',
	'createsigndoc-minage' => 'Mindestalter:',
	'createsigndoc-introtext' => 'Anleitung:',
	'createsigndoc-hidden' => 'Versteckt',
	'createsigndoc-optional' => 'Optional',
	'createsigndoc-create' => 'Erstelle',
	'createsigndoc-error-generic' => 'Fehler: $1',
	'createsigndoc-error-pagenoexist' => 'Fehler: Die Seite [[$1]] existiert nicht.',
	'createsigndoc-success' => 'Das Signieren wurde erfolgreich auf [[$1]] aktiviert.
Besuche bitte [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} diese Seite], um es auszuprobieren.',
	'createsigndoc-error-alreadycreated' => 'Dokumentsignatur „$1“ exitiert bereits.',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Revolus
 */
$messages['de-formal'] = array(
	'createsigndoc-head' => "Benutzen Sie dieses Formular, um ein „Signaturdokument“ für die gegebene Seite zu erstellen, so dass Benutzer in der Lage sein werden, es zu [[Special:SignDocument|signieren]].
Bitte geben Sie den Namen der Seite an, auf welcher Sie digitales Signieren erlauben wollen, welche Benutzergruppen in der Lage sein sollen, sie zu signieren, welche Felder sichtbar sein sollen und welche optional, ein gegebenenfalls minimales Benutzeralter, um das Dokument zu unterzeichnen, und einen kurzen Einleitungstext, der dem Benutzer das Dokument beschreibt und ihm eine kurze Anleitung gibt.

<b>Derzeit ist es nicht möglich, einmal gegebene Signaturen zu modifizieren oder zu entfernen</b> ohne direkt die Datenbank zu bearbeiten.
Zusätzlich wird der angezeigte Text beim Signieren der Seite der ''derzeitige'' Text sein, egal welche Änderungen danach noch vorgenommen wurden.
Bitte seien Sie sich absolut sicher, dass das Dokument in einem ausreichend stabilen Zustand zum Signieren ist.
Bitte seien Sie sich ebenfalls sicher, dass Sie alle nötigen Felder angegeben haben, ''bevor Sie dieses Formular übersenden''.",
	'createsigndoc-success' => 'Das Signieren wurde erfolgreich auf [[$1]] aktiviert.
Besuchen Sie bitte [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} diese Seite], um es auszuprobieren.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'createsigndocument' => 'Signěrowanje dokumentow zmóžniś',
	'createsigndoc-pagename' => 'Bok:',
	'createsigndoc-allowedgroup' => 'Dowólona kupka:',
	'createsigndoc-email' => 'E-mailowa adresa:',
	'createsigndoc-address' => 'Bydleńska addresa:',
	'createsigndoc-extaddress' => 'Město, stat, kraj:',
	'createsigndoc-phone' => 'Telefonowy numer:',
	'createsigndoc-bday' => 'Naroźeński datum:',
	'createsigndoc-minage' => 'Minimalne starstwo:',
	'createsigndoc-introtext' => 'Zapokazanje:',
	'createsigndoc-hidden' => 'Schowany',
	'createsigndoc-optional' => 'Opcionalny',
	'createsigndoc-create' => 'Napóraś',
	'createsigndoc-error-generic' => 'Zmólka: $1',
	'createsigndoc-error-pagenoexist' => 'Zmólka: Bok [[$1]] njeeksistěrujo.',
	'createsigndoc-success' => 'Signěrowanje dokumentow jo se wuspěšnje zmóžniło na [[$1]].
Aby testował, woglědaj se [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} toś ten bok].',
	'createsigndoc-error-alreadycreated' => 'Dokumentowa signatura "$1" južo eksistěrujo.',
);

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'createsigndoc-pagename' => 'Σελίδα:',
	'createsigndoc-allowedgroup' => 'Ομάδα:',
	'createsigndoc-email' => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'createsigndoc-address' => 'Διεύθυνση Οικίας:',
	'createsigndoc-extaddress' => 'Πόλη, Περιοχή, Χώρα:',
	'createsigndoc-phone' => 'Τηλεφωνικός αριθμός:',
	'createsigndoc-bday' => 'Ημερομηνία Γέννησης:',
	'createsigndoc-introtext' => 'Εισαγωγή:',
	'createsigndoc-error-generic' => 'Σφάλμα: $1',
	'createsigndoc-error-pagenoexist' => 'Σφάλμα: Η σελίδα [[$1]] δεν υπάρχει.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'createsigndocument' => 'Ebligu Dokumentan Subskribadon',
	'createsigndoc-pagename' => 'Paĝo:',
	'createsigndoc-allowedgroup' => 'Permesita grupo:',
	'createsigndoc-email' => 'Retpoŝta adreso',
	'createsigndoc-address' => 'Hejma Adreso:',
	'createsigndoc-extaddress' => 'Urbo, Subŝtato, Lando:',
	'createsigndoc-phone' => 'Nombro de telefono:',
	'createsigndoc-bday' => 'Naskodato:',
	'createsigndoc-minage' => 'Minimuma aĝo:',
	'createsigndoc-introtext' => 'Enkonduko:',
	'createsigndoc-hidden' => 'Kaŝita',
	'createsigndoc-optional' => 'Nedeviga',
	'createsigndoc-create' => 'Krei',
	'createsigndoc-error-generic' => 'Eraro: $1',
	'createsigndoc-error-pagenoexist' => 'Eraro: La paĝo [[$1]] ne ekzistas.',
	'createsigndoc-success' => 'Dokumenta subskribado estis sukcese ebligita ĉe [[$1]].
Por testi ĝin, bonvolu eniri [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} ĉi tiun paĝon].',
	'createsigndoc-error-alreadycreated' => 'Subskribado de dokumento "$1" jam ekzistas.',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'createsigndoc-pagename' => 'Página:',
	'createsigndoc-email' => 'Dirección de correo electrónico:',
	'createsigndoc-phone' => 'Número de teléfono:',
	'createsigndoc-minage' => 'Edad mínima:',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'createsigndoc-pagename' => 'Orri:',
	'createsigndoc-email' => 'Email helbidea:',
	'createsigndoc-address' => 'Helbidea:',
	'createsigndoc-extaddress' => 'Udalerria, estatua, herrialdea:',
	'createsigndoc-phone' => 'Telefono zenbakia:',
	'createsigndoc-bday' => 'Urtebetetzea:',
	'createsigndoc-minage' => 'Gutxienezko adina:',
	'createsigndoc-optional' => 'Hautazkoa',
	'createsigndoc-create' => 'Sortu',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'createsigndoc-pagename' => 'Páhina:',
	'createsigndoc-allowedgroup' => 'Alabán premitiu:',
	'createsigndoc-optional' => 'Ocional',
	'createsigndoc-create' => 'Creal',
	'createsigndoc-error-pagenoexist' => 'Marru: La páhina [[$1]] nu desisti.',
);

/** Finnish (Suomi)
 * @author Str4nd
 * @author Vililikku
 */
$messages['fi'] = array(
	'createsigndocument' => 'Ota asiakirjojen allekirjoitus käyttöön',
	'createsigndoc-pagename' => 'Sivu',
	'createsigndoc-allowedgroup' => 'Sallittu ryhmä',
	'createsigndoc-email' => 'Sähköpostiosoite',
	'createsigndoc-address' => 'Kotiosoite',
	'createsigndoc-extaddress' => 'Kaupunki, lääni, maa',
	'createsigndoc-phone' => 'Puhelinnumero',
	'createsigndoc-bday' => 'Syntymäaika',
	'createsigndoc-minage' => 'Vähimmäisikä',
	'createsigndoc-introtext' => 'Johdanto',
	'createsigndoc-hidden' => 'Piilotettu',
	'createsigndoc-optional' => 'Valinnainen',
	'createsigndoc-create' => 'Luo',
	'createsigndoc-error-generic' => 'Virhe: $1',
	'createsigndoc-error-pagenoexist' => 'Virhe: sivua [[$1]] ei löydy.',
	'createsigndoc-error-alreadycreated' => 'Asiakirjan allekirjoitus ”$1” on jo olemassa.',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Urhixidur
 */
$messages['fr'] = array(
	'createsigndocument' => "Activer l'authentification des documents",
	'createsigndoc-head' => "Utilisez ce formulaire pour créer une « page d'authentification » de documents pour la page en question, de façon que chaque utilisateur soit capable de [[Special:SignDocument|l’authentifier]].
Prière d'indiquer l'intitulé de la page pour lequel vous souhaitez activer la fonction, les membres du groupe d'utilisateurs, quels champs seront accessibles aux utilisateurs et ceux qui seront optionnels, l'âge minimal pour être membre du groupe (pas de minimum par défaut) ;
et un bref document expliquant le document et donnant des instructions aux utilisateurs.

'''Présentement, il n'y a aucun moyen d'effacer les documents une fois créés''', sauf en éditant la base de données du wiki. De plus, le texte de la page affiché sur la page authentifiée sera le texte ''courant'', peu importe les modifications faites par la suite.
Pour cette raison, soyez certain que le document soit suffisamment stable pour être authentifié.
''Avant de soumettre le formulaire'', vérifiez que vous avez bien choisi les champs tels que vous souhaitiez qu'ils soient.",
	'createsigndoc-pagename' => 'Page :',
	'createsigndoc-allowedgroup' => 'Groupe autorisé :',
	'createsigndoc-email' => 'Addresse de courriel :',
	'createsigndoc-address' => 'Adresse résidentielle :',
	'createsigndoc-extaddress' => 'Ville, état (département ou province), pays :',
	'createsigndoc-phone' => 'Numéro de téléphone :',
	'createsigndoc-bday' => 'Date de naissance :',
	'createsigndoc-minage' => 'Âge minimum :',
	'createsigndoc-introtext' => 'Introduction :',
	'createsigndoc-hidden' => 'Caché',
	'createsigndoc-optional' => 'Optionnel',
	'createsigndoc-create' => 'Créer',
	'createsigndoc-error-generic' => 'Erreur : $1',
	'createsigndoc-error-pagenoexist' => "La page [[$1]] n'existe pas.",
	'createsigndoc-success' => "L'authentification des documents est activée sur [[$1]]. Pour la tester, voir [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} cette page].",
	'createsigndoc-error-alreadycreated' => 'Le document d’authentification pour « $1 » a déjà été créé.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'createsigndoc-pagename' => 'Side:',
	'createsigndoc-create' => 'Oanmeitsje',
);

/** Irish (Gaeilge)
 * @author Moilleadóir
 */
$messages['ga'] = array(
	'createsigndoc-create' => 'Cruthaigh',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 */
$messages['gl'] = array(
	'createsigndocument' => 'Habilitar a Sinatura de Documentos',
	'createsigndoc-head' => "Empregue este formulario para crear unha páxina \"Asinar o documento\" para a páxina relacionada, de tal xeito que os usuarios [[Special:SignDocument|o poidan asinar]].
Por favor, especifique o nome da páxina na que quere activar a sinatura dixital, os membros de que grupo de usuarios poden asinalo, que campos lles resultan visíbeis aos usuarios e cales han de ser optativos, a idade mínima que se lles esixe aos usuarios para asinar o documento (sen mínimo se se omitise);
e un texto introdutorio breve que describa o documento e lles dea instrucións aos usuarios.

<b>Actualmente non resulta posíbel eliminar ou modificar os documentos de sinatura unha vez que sexan creados</b> sen acceso directo á base de datos. Ademais, o texto da páxina que se amosa na páxina de sinaturas será o texto ''actual'' da páxina, independentemente das modificacións que se lle fagan despois de hoxe. Asegúrese ben de que o documento está en situación de estabilidade antes de asinalo e asegúrese tamén de que especifica todos os campos exactamente como han de ser ''antes de enviar este formulario''.",
	'createsigndoc-pagename' => 'Páxina:',
	'createsigndoc-allowedgroup' => 'Grupo permitido:',
	'createsigndoc-email' => 'Enderezo electrónico:',
	'createsigndoc-address' => 'Enderezo familiar:',
	'createsigndoc-extaddress' => 'Cidade, Estado, País:',
	'createsigndoc-phone' => 'Número de teléfono:',
	'createsigndoc-bday' => 'Aniversario:',
	'createsigndoc-minage' => 'Idade minima:',
	'createsigndoc-introtext' => 'Introdución:',
	'createsigndoc-hidden' => 'Oculto',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Erro: $1',
	'createsigndoc-error-pagenoexist' => 'Erro: A páxina [[$1]] non existe.',
	'createsigndoc-success' => 'O documento asinado foi habilitado con éxito en [[$1]]. Para comprobalo, visite [{{SERVER}}{{localurl: Special: SignDocument|doc=$2}} esta páxina].',
	'createsigndoc-error-alreadycreated' => 'O documento asinado "$1" xa existe.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'createsigndocument' => 'Ἐνεργοποιεῖν τὸ ὑπογράφειν τῶν ἐγγράφων',
	'createsigndoc-pagename' => 'Δέλτος:',
	'createsigndoc-allowedgroup' => 'Ἐπιτρεπομένη ὁμάς:',
	'createsigndoc-email' => 'Ἡλεκτρονικὴ διεύθυνσις:',
	'createsigndoc-address' => 'Διεύθυνσις οἴκου:',
	'createsigndoc-extaddress' => 'Πόλις, πολιτεῖα, κρᾶτος:',
	'createsigndoc-phone' => 'Ἀριθμὸς τηλεφώνου:',
	'createsigndoc-bday' => 'Γεννέθλια ἡμερομηνία:',
	'createsigndoc-minage' => 'Ἐλαχίστη ἡλικία:',
	'createsigndoc-introtext' => 'Είσαγωγή:',
	'createsigndoc-hidden' => 'Κεκρυμμένη',
	'createsigndoc-optional' => 'Προαιρετικόν',
	'createsigndoc-create' => 'Ποεῖν',
	'createsigndoc-error-generic' => 'Σφάλμα: $1',
	'createsigndoc-error-pagenoexist' => 'Σφάλμα: Ἡ δέλτος [[$1]]  οῦχ ὑπάρχει',
	'createsigndoc-error-alreadycreated' => 'Τὸ ἐγγράφον τὸ ὑπογράφον τὸ "$1" ἤδη ὑπάρχει.',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'createsigndoc-create' => 'Tshóng-kien',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'createsigndoc-pagename' => '‘Ao‘ao:',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'createsigndocument' => 'מתן האפשרות לחתימה על מסמכים',
	'createsigndoc-head' => "השתמש בטופס זה כדי ליצור דף 'מסמך חתימה' עבור הדף הנתון, כזה שמשתמשים יוכלו [[Special:SignDocument|לחתום בו]].
אנא ציינו את שם הדף בו תרצו לאפשר חתימה אלקטרונית, חברים של אילו קבוצות משתמשים יוכלו לחתום עליו, אילו שדות ברצונכם להפוך לגלויים בפני משתמשים ואילו שדות להפוך ללא מחייבים, הגיל המינימלי לחתימה על המסמך (אין גיל מינימלי אם לא צויין); וטקסט הכרות מקוצר המתאר את המסמך ומספק הנחיות למשתמשים.

<b>נכון לעכשיו אין דרך למחוק או לשנות מסמכי חתימות לאחר שהם נוצרו</b> ללא גישה ישירה למסד הנתונים.
בנוסף, הטקסט של הדף המוצג בדף החתימה יהיה הטקסט ''הנוכחי'' של הדף, ללא תלות בשינויים שנערכו לאחר היום.
אנא ודאו כי המסמך עומד בתנאי יציבות מסויימים וכי הוא אכן ראוי לחתימה.
כמו כן ודאו כי מילאתם את כל השדות בדיוק כפי שהם אמורים להיות, ''לפני שליחת הטופס''.",
	'createsigndoc-pagename' => 'דף:',
	'createsigndoc-allowedgroup' => 'קבוצה מורשית:',
	'createsigndoc-email' => 'כתובת הדוא"ל:',
	'createsigndoc-address' => 'כתובת הבית:',
	'createsigndoc-extaddress' => 'עיר, מדינה, ארץ:',
	'createsigndoc-phone' => 'מספר הטלפון:',
	'createsigndoc-bday' => 'תאריך הלידה:',
	'createsigndoc-minage' => 'הגיל המינימלי:',
	'createsigndoc-introtext' => 'הקדמה:',
	'createsigndoc-hidden' => 'מוסתר',
	'createsigndoc-optional' => 'אופציונאלי',
	'createsigndoc-create' => 'יצירה',
	'createsigndoc-error-generic' => 'שגיאה: $1',
	'createsigndoc-error-pagenoexist' => 'שגיאה: הדף [[$1]] אינו קיים.',
	'createsigndoc-success' => 'חתימת המסמכים עבור [[$1]] הופעלה בהצלחה.
על מנת לנסות אותה, אנא בקרו ב[{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} דף זה].',
	'createsigndoc-error-alreadycreated' => 'חתימת המסמך "$1" כבר קיימת.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'createsigndoc-pagename' => 'पन्ना:',
	'createsigndoc-hidden' => 'छुपाई हुई',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 */
$messages['hr'] = array(
	'createsigndoc-pagename' => 'Stranica:',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'createsigndocument' => 'Podpisanje dokumentow zmóžnić',
	'createsigndoc-head' => "Wužij tutón formular, zo by stronu 'Podpisny dokument' za wotpowědny nastawk wutworił, zo bychu so wužiwarjo přez [[Special:SignDocument|jón podpisali]]. Prošu podaj mjeno strony, na kotrejmž chceš digatalny podpis zmóžnił, čłonojo kotreje wužiwarskeje skupiny smědźa tam podpisać, kotre pola wužiwarjo smědźa widźeć a kotre měli opcionalne być, trěbnu minimalnu starobu, kotruž wužiwarjo dyrbja  za podpisanje dokumenta měć (njeje minimum, jeli žane podaće njeje) a krótki zawodny tekst, kotryž tutón dokumement wopisuje a wužiwarjam pokiwy poskića.

<b>Tuchwilu bjez přistupa k datowej bance žana móžnosć njeje, zo bychu so podpisne dokumenty zničili abo změnili, po tym zo su wutworjene.</b> Nimo toho budźe tekst strony, kotryž so na podpisnej stronje zwobraznja, ''aktualny'' tekst strony, njedźiwajo na změny ščinjene pozdźišo. Prošu budźe tebi absolutnje wěsty, zo je tutón dokument za podpisanje stabilny dosć, a zawěsć so tež, zo sy wšě pola takle kaž trjeba wupjelnił, ''prjedy hač tutón formular wotesćele''.",
	'createsigndoc-pagename' => 'Strona:',
	'createsigndoc-allowedgroup' => 'Dowolena skupina:',
	'createsigndoc-email' => 'E-mejlowa adresa:',
	'createsigndoc-address' => 'Bydlenska adresa:',
	'createsigndoc-extaddress' => 'Město, stat, kraj:',
	'createsigndoc-phone' => 'Telefonowe čisło:',
	'createsigndoc-bday' => 'Narodniny:',
	'createsigndoc-minage' => 'Minimalna staroba:',
	'createsigndoc-introtext' => 'Zawod:',
	'createsigndoc-hidden' => 'Schowany',
	'createsigndoc-optional' => 'Opcionalny',
	'createsigndoc-create' => 'Wutworić',
	'createsigndoc-error-generic' => 'Zmylk: $1',
	'createsigndoc-error-pagenoexist' => 'Zmylk: Strona [[$1]] njeeksistuje.',
	'createsigndoc-success' => 'Podpisanje dokumentow bu wuspěšnje na [[$1]]aktiwizowane. Zo by je testował, wopytaj prošu [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} tutu stronu:].',
	'createsigndoc-error-alreadycreated' => 'Podpis dokumenta "$1" hižo eksistuje.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'createsigndocument' => 'Activar le signatura de documentos',
	'createsigndoc-head' => "Usa iste formulario pro crear un pagina 'Signar documento' pro le pagina fornite, de modo que le usatores potera [[Special:SignDocument|signar lo]].
Per favor specifica le nomine del pagina in le qual tu vole activar le signatura digital, le gruppo cuje membros debe poter signar le pagina, qual campos tu vole render visibile al usatores e quales debe esser optional, un etate minime que le usatores debe haber pro poter signar le documento (nulle minimo si omittite);
e un breve texto introductori describente le documento e forniente instructiones al usatores.

<b>Al presente non existe un modo de deler o modificar le documentos de signatura post lor creation</b> sin accesso directe al base de datos.
In addition, le texto del pagina monstrate in le pagina de signatura essera le texto ''de iste momento'', non importa le cambios facite in illo post hodie.
Per favor sia absolutemente positive que le documento ha arrivate a un puncto de stabilitate pro esser signate.
In ultra, sia secur que tu specifica tote le campos exactemente como illos debe esser, ''ante que tu submitte iste formulario''.",
	'createsigndoc-pagename' => 'Pagina:',
	'createsigndoc-allowedgroup' => 'Gruppo autorisate:',
	'createsigndoc-email' => 'Adresse de e-mail:',
	'createsigndoc-address' => 'Adresse residential:',
	'createsigndoc-extaddress' => 'Citate, stato/provincia, pais:',
	'createsigndoc-phone' => 'Numero de telephono:',
	'createsigndoc-bday' => 'Data de nascentia:',
	'createsigndoc-minage' => 'Etate minime:',
	'createsigndoc-introtext' => 'Introduction:',
	'createsigndoc-hidden' => 'Celate',
	'createsigndoc-optional' => 'Optional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Error: $1',
	'createsigndoc-error-pagenoexist' => 'Error: Le pagina [[$1]] non existe.',
	'createsigndoc-success' => 'Le signatura del documento [[$1]] ha essite activate con successo.
Pro testar lo, visita [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} iste pagina].',
	'createsigndoc-error-alreadycreated' => 'Le signatura del documento "$1" es ja active.',
);

/** Icelandic (Íslenska) */
$messages['is'] = array(
	'createsigndoc-pagename' => 'Síða:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'createsigndoc-optional' => 'Opzionale',
	'createsigndoc-create' => 'Crea',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'createsigndoc-optional' => '任意',
	'createsigndoc-create' => '作成',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'createsigndocument' => 'Uripna Panapak-tanganan Dokumèn',
	'createsigndoc-pagename' => 'Kaca:',
	'createsigndoc-allowedgroup' => 'Grup sing diparengaké:',
	'createsigndoc-email' => 'Alamat e-mail:',
	'createsigndoc-address' => 'Alamat omah:',
	'createsigndoc-extaddress' => 'Kutha, Negara bagéyan, Negara:',
	'createsigndoc-phone' => 'Nomer tilpun:',
	'createsigndoc-bday' => 'Tanggal lair:',
	'createsigndoc-minage' => 'Umur minimum:',
	'createsigndoc-introtext' => 'Introduksi:',
	'createsigndoc-hidden' => 'Kadelikaké',
	'createsigndoc-optional' => 'Opsional',
	'createsigndoc-create' => 'Nggawé',
	'createsigndoc-error-generic' => 'Luput: $1',
	'createsigndoc-error-pagenoexist' => 'Luput: Kaca [[$1]] ora ana.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 */
$messages['km'] = array(
	'createsigndoc-pagename' => 'ទំព័រ៖',
	'createsigndoc-allowedgroup' => 'ក្រុម​ដែល​បាន​អនុញ្ញាត:',
	'createsigndoc-email' => 'អាសយដ្ឋានអ៊ីមែល៖',
	'createsigndoc-address' => 'អាសយដ្ឋាន​ផ្ទះ​៖',
	'createsigndoc-extaddress' => 'ទីក្រុង, រដ្ឋ, ប្រទេស​៖',
	'createsigndoc-phone' => 'លេខទូរស័ព្ទ៖',
	'createsigndoc-bday' => 'ថ្ងៃ​ខែ​ឆ្នាំកំណើត​៖',
	'createsigndoc-minage' => 'អាយុ​អប្បបរមារ:',
	'createsigndoc-introtext' => 'សេចក្តីណែនាំ៖',
	'createsigndoc-hidden' => 'ត្រូវបានបិទបាំង',
	'createsigndoc-optional' => 'តាម​ចំណង់ចំណូលចិត្ត',
	'createsigndoc-create' => 'បង្កើត',
	'createsigndoc-error-generic' => 'កំហុស​៖ $1',
	'createsigndoc-error-pagenoexist' => 'កំហុស​៖ មិនមាន​ទំព័រ [[$1]] ទេ​។',
);

/** Korean (한국어)
 * @author ToePeu
 */
$messages['ko'] = array(
	'createsigndoc-create' => '만들기',
);

/** Krio (Krio)
 * @author Jose77
 */
$messages['kri'] = array(
	'createsigndoc-create' => 'Mek sohmtin',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'createsigndoc-pagename' => 'Pahina:',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'createsigndocument' => 'Et Dokkemänte Ungerschriive zohlohße',
	'createsigndoc-head' => 'Met dämm Fommulaa hee, kanns De en Söndersigg ennreschte, för de aanjejovve Sigg [[Special:SignDocument|ungerschriive]] ze lohße.
Dodoför weed och ene Ungerschreffte-Mapp för die Sigg aanjelaat.
Jiff dä Tittel fun dä Sigg aan, woh De et dijjitaale Ungerschriive zohlohße wells. Dozoh, de Metjleeder fun wat för ene Metmaacherjrupp ungerschriive dörrve sulle. Dann, wat för en Felder för de Metmaachere bejm Ungerschriive zom Ußfölle ze sin sin sulle, un wat dofun ußjeföllt wääde kann, un wat moß. Dann, wi alt Eine beim Ungerschriive winnischßdens sin moß. Wann De doh nix aanjiß, dann eß jedes Allder rääsch. Zoletz jiff ene koote Tex en, met Äklieronge dren övver dat Dokkemänt, un för de Metmaachere, wat se donn sulle, un wie.

<b>För der Momang ham_mer kein Müjjeleshkeit, aan de Ungerschreffte jet ze änndere, wann se ens do sinn</b>, oohne ne tirekte Zohjang op de Dahtebangk. 
Ußerdämm, dä Täx zom Ungerschriive, dä och met dä Ongerschreffte zosamme jezeish weedt, is immer dä Täx fun jätz, jans ejaal, wat donoh noch för Änderunge aan dä Sigg jemaat wäde odder woodte. Dröm beß jannz secher, dat dat Dokkemänt en dä Sigg en enem shtabiile Zohshtand, un werklesch parraat för et Ungeschriive eß.
Beß och sescher, dat De all die Felder jenou esu aanjejovve häs, wi se sin sulle, ih dat De dat Fommulaa hee affschecks.',
	'createsigndoc-pagename' => 'Sigg:',
	'createsigndoc-allowedgroup' => 'Zojelohße Jroppe:',
	'createsigndoc-email' => 'De <i lang="en">e-mail</i> Addräß:',
	'createsigndoc-address' => 'Aanschreff ze hus:',
	'createsigndoc-extaddress' => 'Shtadt, Shtaat, Land:',
	'createsigndoc-phone' => 'Tellefon-Nommer:',
	'createsigndoc-bday' => 'Et Dattum fum Jebootsdach:',
	'createsigndoc-minage' => 'Et ungerschte Allder:',
	'createsigndoc-introtext' => 'Aanleidong:',
	'createsigndoc-hidden' => 'Verstoche',
	'createsigndoc-optional' => 'Kam_mer och fott lohße',
	'createsigndoc-create' => 'Aanläje',
	'createsigndoc-error-generic' => 'Fähler: $1',
	'createsigndoc-error-pagenoexist' => 'Fähler: En Sigg „[[$1]]“ jidd_et nit.',
	'createsigndoc-success' => 'Et Ungerschriive eß jetz för „[[$1]]“ enjeschalldt, en Ungerschreffte-Mapp es aanjelaat.
Mer kann jetz dat [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} Ungerschriive och ußprobbiere].',
	'createsigndoc-error-alreadycreated' => 'De Ongerschreffte-Mapp för de Sigg „$1“ es ald aanjelaat.',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'createsigndoc-pagename' => 'Pagina:',
	'createsigndoc-error-pagenoexist' => 'Error: Pagina [[$1]] non existit.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'createsigndocument' => 'Ënnerschreiwen vun Dokumenter erméiglechen',
	'createsigndoc-pagename' => 'Säit:',
	'createsigndoc-allowedgroup' => 'Erlaabte Grupp:',
	'createsigndoc-email' => 'E-mail Adress:',
	'createsigndoc-extaddress' => 'Stad, Regioun/Bundesstaat, Land:',
	'createsigndoc-phone' => 'Telefonsnummer:',
	'createsigndoc-bday' => 'Geburtsdag:',
	'createsigndoc-minage' => 'Mindesalter:',
	'createsigndoc-introtext' => 'Aféierung:',
	'createsigndoc-hidden' => 'Verstoppt',
	'createsigndoc-optional' => 'Fakultativ',
	'createsigndoc-create' => 'Uleeën',
	'createsigndoc-error-generic' => 'Feeler: $1',
	'createsigndoc-error-pagenoexist' => "Feeler: D'Säit [[$1]] gëtt et net.",
	'createsigndoc-success' => "D'Ënnerschreiwe vu Dokumenter ass op [[$1]] aktivéiert.
Fir et ze testen, gitt w.e.g. op [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} dës Säit].",
	'createsigndoc-error-alreadycreated' => 'Dokument ënnerschreiwen "$1" gëtt et schonn',
);

/** Limburgish (Limburgs)
 * @author Remember the dot
 */
$messages['li'] = array(
	'createsigndoc-pagename' => 'Pazjena:',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'createsigndoc-pagename' => 'Лаштык:',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'createsigndoc-pagename' => 'താള്‍:',
	'createsigndoc-allowedgroup' => 'അനുവദനീയമായ ഗ്രൂപ്പ്:',
	'createsigndoc-email' => 'ഇമെയില്‍ വിലാസം:',
	'createsigndoc-address' => 'വീടിന്റെ വിലാസം:',
	'createsigndoc-extaddress' => 'നഗരം. സംസ്ഥാനം, രാജ്യം:',
	'createsigndoc-phone' => 'ഫോണ്‍ നമ്പര്‍:',
	'createsigndoc-bday' => 'ജനനതീയ്യതി:',
	'createsigndoc-minage' => 'കുറഞ്ഞ പ്രായം:',
	'createsigndoc-introtext' => 'പ്രാരംഭം:',
	'createsigndoc-hidden' => 'മറഞ്ഞിരിക്കുന്നത്',
	'createsigndoc-optional' => 'നിര്‍ബന്ധമില്ല',
	'createsigndoc-create' => 'താള്‍ സൃഷ്ടിക്കുക',
	'createsigndoc-error-generic' => 'പിഴവ്: $1',
	'createsigndoc-error-pagenoexist' => 'പിശക്: [[$1]] എന്ന താള്‍ നിലവിലില്ല.',
	'createsigndoc-success' => '[[$1]] പ്രമാണഒപ്പിടല്‍ വിജയകരമായി പ്രവര്‍ത്തനസജ്ജമാക്കിയിരിക്കുന്നു. അതു പരീക്ഷിക്കുവാന്‍ ദയവായി [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} ഈ താള്‍] സന്ദര്‍ശിക്കുക.',
	'createsigndoc-error-alreadycreated' => 'പ്രമാണ ഒപ്പിടല്‍ "$1" നിലവിലുണ്ട്.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'createsigndocument' => 'डॉक्यूमेंटवर सही करणे सुरू करा',
	'createsigndoc-head' => "दिलेल्या पानासाठी एक 'डॉक्यूमेंटवर सही करा' पृष्ठ तयार करण्यासाठी या अर्जाचा वापर करा, ज्यामुळे सदस्यांना [[Special:SignDocument]] वापरून त्या पानावर सही करता येईल.
कॄपया ज्या पानावर सही करणे सुरू करायचे ते पान निवडा, तसेच कुठल्या सदस्यगटांना या पानावर सही करू द्यायची ते ठरवा, कुठले रकाने सदस्यांना दिसले पाहिजेत तसेच कुठले रकाने वैकल्पिक ठेवायचे ते ठरवा, त्यानंतर कमीतकमी वयाची अट द्या (जर रिकामे ठेवले तर वयाची अट नाही); तसेच एक छोटीशी डॉक्यूमेंटची ओळख तसेच सदस्यांना सूचना द्या.

<b>सध्या सही साठी डॉक्यूमेंट तयार झाल्यानंतर त्याला वगळण्याची कुठलिही सुविधा उपलब्ध नाही.</b> फक्त थेट डाटाबेसशी संपर्क करता येईल.
तसेच, तसेच सही साठी उपलब्ध पानावर '''सध्याचा''' मजकूर दाखविला जाईल, जरी तो आज नंतर बदलला तरीही.
कृपया हे डॉक्यूमेंट सही साठी उपलब्ध करण्यासाठी योग्य असल्याची खात्री करा, तसेच ''हा अर्ज पाठविण्यापूर्वी'' तुम्ही सर्व रकाने योग्य प्रकारे भरलेले आहेत, याची खात्री करा.",
	'createsigndoc-pagename' => 'पान',
	'createsigndoc-allowedgroup' => 'अधिकृत सदस्य गट:',
	'createsigndoc-email' => 'इ-मेल पत्ता:',
	'createsigndoc-address' => 'घरचा पत्ता:',
	'createsigndoc-extaddress' => 'शहर, राज्य, देश:',
	'createsigndoc-phone' => 'दूरध्वनी क्रमांक',
	'createsigndoc-bday' => 'जन्मदिवस',
	'createsigndoc-minage' => 'कमीतकमी वय:',
	'createsigndoc-introtext' => 'ओळख:',
	'createsigndoc-hidden' => 'लपविलेले',
	'createsigndoc-optional' => 'पर्यायी',
	'createsigndoc-create' => 'निर्मीतकरा',
	'createsigndoc-error-generic' => 'त्रुटी: $1',
	'createsigndoc-error-pagenoexist' => 'त्रुटी: पान [[$1]] अस्तित्त्वात नाही.',
	'createsigndoc-success' => '[[$1]] वर आता सही करता येऊ शकेल.
तपासण्यासाठी, [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} या पानाला] भेट द्या.',
	'createsigndoc-error-alreadycreated' => 'डॉक्यूमेंट सही "$1" अगोदरच अस्तित्त्वात आहे.',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'createsigndoc-pagename' => 'Лопась:',
	'createsigndoc-extaddress' => 'Ошось, штатось, масторось:',
	'createsigndoc-phone' => 'Телефон номерэть:',
	'createsigndoc-bday' => 'Чачома чить:',
	'createsigndoc-hidden' => 'Кекшезь',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'createsigndoc-pagename' => 'Zāzanilli:',
	'createsigndoc-extaddress' => 'Āltepētl, tlahtōcāyōtl, tlācatiyān:',
	'createsigndoc-hidden' => 'Ichtac',
	'createsigndoc-create' => 'Ticchīhuāz',
	'createsigndoc-error-generic' => 'Ahcuallōtl: $1',
	'createsigndoc-error-pagenoexist' => 'Ahcuallōtl: Zāzanilli [[$1]] ahmo ia.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'createsigndocument' => 'Documentondertekening inschakelen',
	'createsigndoc-head' => "Gebruik dit formulier om een pagina 'Document ondertekenen' voor een gegeven pagina te maken, zodat gebruikers het kunnen [[Special:SignDocument|ondertekenen]].
Geef alstublieft op voor welke pagina u digitaal ondertekenen wilt inschakelen, welke gebruikersgroepen kunnen ondertekenen, welke velden zichtbaar moeten zijn voor gebruikers en welke optioneel zijn, een minimale leeftijd waaraan gebruikers moeten voldoen alvorens te kunnen ondertekenen (geen beperkingen als leeg gelaten);
en een korte inleidende tekst over het document en instructies voor de gebruikers.

<b>Er is op het moment geen mogelijkheid om te ondertekenen documenten te verwijderen of te wijzigen nadat ze zijn aangemaakt</b> zonder directe toegang tot de database.
Daarnaast is de tekst van de pagina die wordt weergegeven op de ondertekeningspagina de ''huidige'' tekst van de pagina, ongeacht de wijzigingen die erna gemaakt worden.
Zorg er alstublieft voor dat het document een stabiele versie heeft voordat u ondertekenen inschakelt.
Zorg er ook voor dat alle velden de juiste waarden hebben ''voordat u het formulier instuurt''.",
	'createsigndoc-pagename' => 'Pagina:',
	'createsigndoc-allowedgroup' => 'Toegelaten groep:',
	'createsigndoc-email' => 'E-mailadres:',
	'createsigndoc-address' => 'Adres:',
	'createsigndoc-extaddress' => 'Stad, staat, land:',
	'createsigndoc-phone' => 'Telefoonnummer:',
	'createsigndoc-bday' => 'Geboortedatum:',
	'createsigndoc-minage' => 'Minimum leeftijd:',
	'createsigndoc-introtext' => 'Inleiding:',
	'createsigndoc-hidden' => 'Verborgen',
	'createsigndoc-optional' => 'Optioneel',
	'createsigndoc-create' => 'Aanmaken',
	'createsigndoc-error-generic' => 'Fout: $1',
	'createsigndoc-error-pagenoexist' => 'Error: De pagina [[$1]] bestaat niet.',
	'createsigndoc-success' => 'Documentondertekening is ingeschakeld op
[[$1]]. Ga alstublieft naar [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} deze pagina] om het te testen.',
	'createsigndoc-error-alreadycreated' => 'De documentondertekening "$1" bestaat al.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'createsigndocument' => 'Slå på dokumentsignering',
	'createsigndoc-head' => "Nytt dette skjemaet for å oppretta eit «signaturdokument» for denne sida, slik at brukarar kan [[Special:SignDocument|signera ho]]. Oppgje namnet på sida, kva brukargruppa som skal kunna signera ho, kva felt som skal vera synlege for brukarane, kven av dei som skal vera valfrie, minimumsalderen for å kunna signera dokumentet (om denne ikkje blir oppgjeven, er det inga grensa), og ein kjapp introduksjonstekst som skildrar dokumentet og gjev instruksjonar til brukarane.

<b>Det finst ingen måte å sletta eller endra signaturdokument på etter at dei er oppretta</b> utan direkte databasetilgjenge. Teksten på sida på signatursida vil òg vera den ''noverande'' teksten, uavhengig av kva endringar som blir gjort etter i dag. Ver hundre prosent sikker på at dokumentet er stabilt når det blir signert, og ver òg sikker på at du oppgjev alle felt som dei burde vera, ''før du lagrar dette skjemaet''.",
	'createsigndoc-pagename' => 'Side:',
	'createsigndoc-allowedgroup' => 'Tillate gruppa:',
	'createsigndoc-email' => 'E-postadressa:',
	'createsigndoc-address' => 'Heimadressa:',
	'createsigndoc-extaddress' => 'By, stat, land:',
	'createsigndoc-phone' => 'Telefonnummer:',
	'createsigndoc-bday' => 'Fødselsdato:',
	'createsigndoc-minage' => 'Minimumsalder:',
	'createsigndoc-introtext' => 'Introduksjon:',
	'createsigndoc-hidden' => 'Gøymd',
	'createsigndoc-optional' => 'Valfri',
	'createsigndoc-create' => 'Opprett',
	'createsigndoc-error-generic' => 'Feil: $1',
	'createsigndoc-error-pagenoexist' => 'Feil: Sida [[$1]] finst ikkje.',
	'createsigndoc-success' => 'Dokumentsignering har blitt slege på for [[$1]]. 
For å testa det, vitj [{{fullurl:Special:SignDocument|doc=$2}} denne sida].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringa «$1» finst frå før.',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'createsigndocument' => 'Slå på dokumentsignering',
	'createsigndoc-head' => "Bruk dette skjemaet for å opprette et «signaturdokument» for denne siden, slik at brukere kan [[Special:SignDocument|signere den]]. Vennligst oppgi sidens navn, hvilken brukergruppe som skal kunne signere den, hvilke felter som skal være synlige for brukerne, hvilke som skal være valgfrie, minimumsalder for å kunne signere dokumentet (om denne ikke oppgis, er det ingen grense), og en kjapp introduksjonstekst som beskriver dokumentet og gir instruksjoner til brukerne.

<b>Det er ingen måte å slette eller endre signaturdokumenter etter at de opprettes</b> uten direkte databasetilgang. Teksten på siden på signatursiden vil også være den ''nåværende'' teksten, uavhengig av hvilke endringer som gjøres etter i dag. Vær hundre prosent sikker på at dokumentet er stabilt når det signeres, og vær også sikker på at du oppgir alle felt som de burde være, ''før du lagrer dette skjemaet''.",
	'createsigndoc-pagename' => 'Side:',
	'createsigndoc-allowedgroup' => 'Tillatt gruppe:',
	'createsigndoc-email' => 'E-postadresse:',
	'createsigndoc-address' => 'Hjemmeadresse:',
	'createsigndoc-extaddress' => 'By, stat, land:',
	'createsigndoc-phone' => 'Telefonnummer:',
	'createsigndoc-bday' => 'Fødselsdato:',
	'createsigndoc-minage' => 'Minimumsalder:',
	'createsigndoc-introtext' => 'Introduksjon:',
	'createsigndoc-hidden' => 'Skjult',
	'createsigndoc-optional' => 'Valgfri',
	'createsigndoc-create' => 'Opprett',
	'createsigndoc-error-generic' => 'Feil: $1',
	'createsigndoc-error-pagenoexist' => 'Feil: Siden [[$1]] eksisterer ikke.',
	'createsigndoc-success' => 'Dokumentsignering har blitt slått på for [[$1]]. For å signere det, besøk [{{fullurl:Special:SignDocument|doc=$2}} denne siden].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringen «$1» finnes allerede.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'createsigndocument' => "Activar l'autentificacion dels documents",
	'createsigndoc-head' => "Utilizatz aqueste formulari per crear una pagina d'autentificacion de documents per l'article en question, de biais que cada utilizaire serà capable d'autentificar via [[Special:SignDocument|Signit]].
Mercés d'indicar lo nom de l'article pelquin desiratz activar la foncion, los membres del grop d'utilizaires, quins camps seràn accessibles als utilizaires (seràn opcionals), l'edat minimala per èsser membre del grop (pas de minimom siquenon) e un document brèu explicant lo document e balhant d'instruccions als utilizaires. 

<b>Presentadament, i a pas cap de mejan d'escafar los documents un còp creats</b>, al despart en editant la banca de donadas del wiki. E mai, lo tèxt de l'article afichat sus la pagina autentificada serà lo tèxt ''corrent'', pauc impòrta las modificacions fachas de per aprèp. Per aquesta rason, siatz segur que lo document es sufisentament estable per èsser autentificat e, ''abans de sometre lo formulari'', verificatz qu'avètz plan causit los camps tals coma desiratz que sián.",
	'createsigndoc-pagename' => 'Pagina :',
	'createsigndoc-allowedgroup' => 'Grop autorizat :',
	'createsigndoc-email' => 'Adreça de corrièr electronic :',
	'createsigndoc-address' => 'Adreça residenciala :',
	'createsigndoc-extaddress' => 'Vila, estat (departament o província), país :',
	'createsigndoc-phone' => 'Numèro de telèfon :',
	'createsigndoc-bday' => 'Data de naissença :',
	'createsigndoc-minage' => 'Edat minimoma :',
	'createsigndoc-introtext' => 'Introduccion :',
	'createsigndoc-hidden' => 'Amagat',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Error : $1',
	'createsigndoc-error-pagenoexist' => 'La pagina [[$1]] existís pas.',
	'createsigndoc-success' => "L'autentificacion dels documents es activada sus [[$1]]. Per la testar, vejatz [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} aquesta pagina].",
	'createsigndoc-error-alreadycreated' => 'Lo document d’autentificacion per « $1 » ja es estat creat.',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'createsigndoc-pagename' => 'Фарс:',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'createsigndoc-pagename' => 'Strona:',
	'createsigndoc-email' => 'Adres e-mail:',
	'createsigndoc-address' => 'Adres domowy',
	'createsigndoc-extaddress' => 'Miejscowość, kraj',
	'createsigndoc-phone' => 'Numer telefonu:',
	'createsigndoc-bday' => 'Data urodzenia:',
	'createsigndoc-minage' => 'Minimalny wiek',
	'createsigndoc-create' => 'Utwórz',
	'createsigndoc-error-generic' => 'Błąd: $1',
	'createsigndoc-error-pagenoexist' => 'Błąd: Strona [[$1]] nie istnieje',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'createsigndocument' => 'Visché la firma digital ëd na pàgina coma document',
	'createsigndoc-head' => "Ch'a dòvra la domanda ambelessì sota për visché l'opsion ëd 'Firma Digital' ëd n'artìcol, ch'a lassa che j'utent a peulo firmé ën dovrand la fonsion ëd [[Special:SignDocument|firma digital]]. 

Për piasì, ch'an buta:
*ël nòm dl'artìcol andova ch'a veul visché la fonsion ëd firma digital, 
*ij component ëd che partìa d'utent ch'a resto aotorisà a firmé, 
*che camp ch'a debio smon-se a j'utent e coj ch'a debio resté opsionaj, 
*n'eta mìnima përché n'utent a peula firmé (a peulo tuti s'a buta nen ël mìnim), 
*un cit ëspiegon ch'a disa lòn ch'a l'é ës document e ch'a-j disa a j'utent coma fé. 

Anans che dovré sossì ch'a ten-a present che:
#<b>Për adess a-i é gnun-a manera dë scancelé ò modifiché ij document ch'as mando an firma, na vira ch'a sio stait creà</b> sensa dovej travajé ant sla base dat da fòra. 
#Ël test smonù ant sla pàgina an firma a resta col ëd quand as anandio a cheuje le firme, donca la version ''corenta'' al moment ch'as fa sossì, e qualsëssìa modìfica ch'as fasa peuj '''an firma a la riva pì nen'''. 

Për piasì, ch'a varda d'avej controlà sò test coma ch'as dev anans che mandelo an firma, e ch'a varda che tuti ij camp a sio coma ch'a-j ven-o bin a chiel, ''anans dë mandé la domanda''.",
	'createsigndoc-pagename' => 'Pàgina:',
	'createsigndoc-allowedgroup' => "Partìe d'utent ch'a peulo firmé:",
	'createsigndoc-email' => 'Adrëssa ëd pòsta eletrònica',
	'createsigndoc-address' => 'Adrëssa ëd ca:',
	'createsigndoc-extaddress' => 'Sità, Provinsa, Stat:',
	'createsigndoc-phone' => 'Nùmer ëd telèfono:',
	'createsigndoc-bday' => 'Nait(a) dël:',
	'createsigndoc-minage' => 'Età mìnima:',
	'createsigndoc-introtext' => 'Spiegon:',
	'createsigndoc-hidden' => 'Stërmà',
	'createsigndoc-optional' => 'Opsional',
	'createsigndoc-create' => 'Buté an firma',
	'createsigndoc-error-generic' => 'Eror: $1',
	'createsigndoc-error-pagenoexist' => "Eror: a-i é pa gnun-a pàgina ch'as ciama [[$1]].",
	'createsigndoc-success' => "La procedura për buté an firma [[$1]] a l'é andaita a bonfin. Për provela, për piasì ch'a varda [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} ambelessì].",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'createsigndoc-pagename' => 'مخ:',
	'createsigndoc-email' => 'برېښليک پته:',
	'createsigndoc-address' => 'د کور پته:',
	'createsigndoc-extaddress' => 'ښار، ايالت، هېواد:',
	'createsigndoc-phone' => 'د ټيليفون شمېره:',
	'createsigndoc-bday' => 'د زېږون نېټه:',
	'createsigndoc-hidden' => 'پټ',
	'createsigndoc-create' => 'جوړول',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'createsigndocument' => 'Ativar a assinatura de documentos',
	'createsigndoc-pagename' => 'Página:',
	'createsigndoc-allowedgroup' => 'Grupo autorizado:',
	'createsigndoc-email' => 'Endereço de e-mail:',
	'createsigndoc-extaddress' => 'Cidade, Estado, País:',
	'createsigndoc-phone' => 'Número de telefone:',
	'createsigndoc-bday' => 'Data de nascimento:',
	'createsigndoc-minage' => 'Idade mínima:',
	'createsigndoc-introtext' => 'Introdução:',
	'createsigndoc-hidden' => 'Escondido',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Criar',
	'createsigndoc-error-generic' => 'Erro: $1',
	'createsigndoc-error-pagenoexist' => 'Erro: A página [[$1]] não existe.',
	'createsigndoc-success' => 'A assinatura de documentos foi ativada com sucesso em [[$1]].
Para testar a funcionalidade, por favor visite [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} esta página].',
	'createsigndoc-error-alreadycreated' => 'A assinatura de documentos "$1" já existe.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'createsigndoc-pagename' => 'Pagină:',
	'createsigndoc-email' => 'Adresă e-mail:',
	'createsigndoc-phone' => 'Număr de telefon:',
	'createsigndoc-bday' => 'Zi de naştere:',
	'createsigndoc-minage' => 'Vârstă minimă:',
	'createsigndoc-introtext' => 'Introducere:',
	'createsigndoc-hidden' => 'Ascunse',
	'createsigndoc-optional' => 'Opţional',
	'createsigndoc-create' => 'Creează',
	'createsigndoc-error-generic' => 'Eroare: $1',
	'createsigndoc-error-pagenoexist' => 'Eroare: Pagina [[$1]] nu există.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'createsigndoc-pagename' => 'Pàgene:',
	'createsigndoc-allowedgroup' => 'Gruppe permesse:',
	'createsigndoc-email' => 'Indirizze e-mail:',
	'createsigndoc-address' => 'Indirizze de case:',
	'createsigndoc-extaddress' => 'Cetate, province, state:',
	'createsigndoc-phone' => 'Numere de telefone:',
	'createsigndoc-bday' => 'Date de nascite:',
	'createsigndoc-minage' => 'Età minime:',
	'createsigndoc-introtext' => "'Ndroduzione:",
	'createsigndoc-hidden' => 'Scunnute',
	'createsigndoc-optional' => 'A scelte',
	'createsigndoc-create' => 'Ccreje',
	'createsigndoc-error-generic' => 'Errore: $1',
	'createsigndoc-error-pagenoexist' => "Errore: 'A pàgene [[$1]] non g'esiste.",
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'createsigndocument' => 'Включить сбор подписей для документа',
	'createsigndoc-head' => "Вы можете использовать данную форму для инициации «подписания документа», участники смогут [[Special:SignDocument|подписать его]] с помощью специальной страницы.
Пожалуйста, укажите название страницы, на которой вы желаете включить сбор цифровых подписей, члены каких групп участников могут подписывать документ, какие поля будут видны обычным участникам, какие поля не обязательны для заполнения, минимальный возраст участника, желающего подписать документ (по умолчанию нет ограничений по возрасту), а также краткый вступительный текст, описывающий документ и дающий указания участникам.

<b>В настоящее время нет способа удалить или изменить подписываемые документы после того, как они созданы</b>, без прямого доступа в базу данных.
Кроме того, текст страницы, отображаемый на странице сбора подписей будет ''текущим'' текстом страницы, не смотря на изменения, сделанные в нём после сегодняшнего дня.
Пожалуйста, твёрдо убедитесь, что документ достаточно стабилен для подписания и, пожалуйста, убедитесь также, что вы указываете все поля точно так, как они должны быть, ''перед отправкой этой формы''.",
	'createsigndoc-pagename' => 'Страница:',
	'createsigndoc-allowedgroup' => 'Допустимые группы:',
	'createsigndoc-email' => 'Электронная почта:',
	'createsigndoc-address' => 'Домашний адрес:',
	'createsigndoc-extaddress' => 'Город, штат, страна:',
	'createsigndoc-phone' => 'Номер телефона:',
	'createsigndoc-bday' => 'Дата рождения:',
	'createsigndoc-minage' => 'Минимальный возраст:',
	'createsigndoc-introtext' => 'Вступление:',
	'createsigndoc-hidden' => 'Скрыто',
	'createsigndoc-optional' => 'Необязательное',
	'createsigndoc-create' => 'Создать',
	'createsigndoc-error-generic' => 'Ошибка: $1',
	'createsigndoc-error-pagenoexist' => 'Ошибка: страницы [[$1]] не существует.',
	'createsigndoc-success' => 'Подписание документа успешно включено на странице [[$1]].
Чтобы проверить сбор подписей, пожалуйста, зайдите на [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} эту страницу].',
	'createsigndoc-error-alreadycreated' => 'Сбор подписей для страницы «$1» уже включён.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'createsigndocument' => 'Zapnúť podpisovanie dokumentov',
	'createsigndoc-head' => "Tento formulár slúži na vytvorenie stránky „Podpísať dokument“ pre uvedenú stránku, aby
ju používatelia mohli [[Special:SignDocument|podpisovať]]. Prosím, uveďte názov
stránky, na ktorej chcete zapnúť digitálne podpisovanie, členovia ktorých skupín ju budú
môcť podpisovať a, ktoré polia budú viditeľné používateľom a ktoré by mali byť voliteľné,
minimálny vek, ktorý je požadovaný na podpísanie dokumentu (ak údaj vynecháte, nebude
vyžiadovaný žiadny minimálny vek) a stručný úvodný text popisujúci dokument a poskytujúci
používateľom inštrukcie.

<b>Momentálne neexistuje spôsob ako zmazať alebo zmeniť podpisované dokumenty potom, ako boli vytvorené</b> bez použitia priameho prístupu do databázy.
Naviac text stránky zobrazený na stránke podpisov bude ''aktuálny'' text stránky, nezávisle na zmenách, ktoré v ňom od dnes nastanú.
Prosím, buďte si absolútne istý, že dokument je stabilný, keď ho podpisujete. 
Tiež si prosím buďte istý, že uvádzate všetky polia presne ako by mali byť ''predtým než odošlete formulár''.",
	'createsigndoc-pagename' => 'Stránka:',
	'createsigndoc-allowedgroup' => 'Povolená skupina:',
	'createsigndoc-email' => 'Emailová adresa:',
	'createsigndoc-address' => 'Domáca adresa:',
	'createsigndoc-extaddress' => 'Mesto, štát, krajina:',
	'createsigndoc-phone' => 'Telefónne číslo:',
	'createsigndoc-bday' => 'Dátum narodenia:',
	'createsigndoc-minage' => 'Minimálny vek:',
	'createsigndoc-introtext' => 'Úvodný text:',
	'createsigndoc-hidden' => 'Skryté',
	'createsigndoc-optional' => 'Voliteľné',
	'createsigndoc-create' => 'Vytvoriť',
	'createsigndoc-error-generic' => 'Chyba: $1',
	'createsigndoc-error-pagenoexist' => 'Chyba: Stránka [[$1]] neexistuje.',
	'createsigndoc-success' => 'Podpisovanie dokumentov bolo úspešne zapnuté pre stránku  [[$1]]. Otestovať ho môžete na [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} tejto stránke].',
	'createsigndoc-error-alreadycreated' => 'Podpis dokumentu „$1“ už existuje.',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'createsigndoc-pagename' => 'Страна:',
	'createsigndoc-allowedgroup' => 'Дозвољена група:',
	'createsigndoc-email' => 'Е-пошта:',
	'createsigndoc-extaddress' => 'Град, држава:',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'createsigndoc-phone' => 'Inombolo yelucingo:',
	'createsigndoc-create' => 'Kúdála',
);

/** Swedish (Svenska)
 * @author Jon Harald Søby
 * @author Lejonel
 * @author M.M.S.
 */
$messages['sv'] = array(
	'createsigndocument' => 'Möjliggör dokument signering',
	'createsigndoc-head' => "Använd detta formulär för att skapa ett \"signaturdokument\" för denna sida, så att användare kan [[Special:SignDocument|signera det]].
Var god ange sidans namn, vilken användargrupp som ska kunna signera det, vilka fält som ska vara synliga för användarna, vilka som ska vara valfria, minimumålder för att kunna signera dokumentet (om detta inte anges, finns det ingen gräns), och en kort introduktionstext som beskriver dokumentet och ger instruktioner till användarna.

<b>Det finns inget sätt att radera eller ändra signaturdokument efter att de har skapats</b> utan direkt databastillgång.
Texten på sidan på signatursidan kommer också vara den ''nuvarande'' texten, oavsätt av vilka ändringar som görs efter i dag.
Var hundra procent säker på att dokumentet är stabilt när det signeras, och var också säker på att du anger alla fält som de ska vara, ''innan du sparar detta formulär''.",
	'createsigndoc-pagename' => 'Sida:',
	'createsigndoc-allowedgroup' => 'Tillåten grupp:',
	'createsigndoc-email' => 'E-postadress:',
	'createsigndoc-address' => 'Gatuadress:',
	'createsigndoc-extaddress' => 'Ort, delstat, land:',
	'createsigndoc-phone' => 'Telefonnummer:',
	'createsigndoc-bday' => 'Födelsedatum:',
	'createsigndoc-minage' => 'Minimiålder:',
	'createsigndoc-introtext' => 'Introduktion:',
	'createsigndoc-hidden' => 'dolt',
	'createsigndoc-optional' => 'Frivilligt',
	'createsigndoc-create' => 'Skapa',
	'createsigndoc-error-generic' => 'Fel: $1',
	'createsigndoc-error-pagenoexist' => 'Fel: Sidan [[$1]] finns inte.',
	'createsigndoc-success' => 'Dokumentsignering har stängts av för [[$1]]. För att signera det, besök [{{fullurl:Special:SignDocument|doc=$2}} den här sidan].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringen "$1" finns redan.',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'createsigndoc-pagename' => 'Zajta:',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'createsigndoc-pagename' => 'పేజీ:',
	'createsigndoc-email' => 'ఈ-మెయిల్ చిరునామా:',
	'createsigndoc-address' => 'ఇంటి చిరునామా:',
	'createsigndoc-extaddress' => 'నగరం, రాష్ట్రం, దేశం:',
	'createsigndoc-phone' => 'ఫోన్ నంబర్:',
	'createsigndoc-bday' => 'పుట్టినరోజు:',
	'createsigndoc-minage' => 'కనిష్ట వయసు:',
	'createsigndoc-introtext' => 'పరిచయం:',
	'createsigndoc-optional' => 'ఐచ్చికం',
	'createsigndoc-create' => 'సృష్టించు',
	'createsigndoc-error-generic' => 'పొరపాటు: $1',
	'createsigndoc-error-pagenoexist' => 'పొరపాటు: [[$1]] అనే పేజీ లేనే లేదు.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'createsigndoc-pagename' => 'Pájina:',
	'createsigndoc-email' => 'Diresaun korreiu eletróniku:',
	'createsigndoc-create' => 'Kria',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'createsigndoc-pagename' => 'Саҳифа:',
	'createsigndoc-email' => 'Нишонаи E-mail:',
	'createsigndoc-address' => 'Суроғаи Хона:',
	'createsigndoc-extaddress' => 'Шаҳр, Вилоят, Кишвар:',
	'createsigndoc-phone' => 'Шумораи телефон:',
	'createsigndoc-bday' => 'Зодрӯз:',
	'createsigndoc-introtext' => 'Шиносоӣ:',
	'createsigndoc-optional' => 'Ихтиёрӣ',
	'createsigndoc-create' => 'Эҷод',
	'createsigndoc-error-generic' => 'Хато: $1',
	'createsigndoc-error-pagenoexist' => 'Хато: Саҳифаи [[$1]] вуҷуд надорад.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'createsigndocument' => 'Paganahin/paandarin ang paglalagda sa kasulatan (dokumento)',
	'createsigndoc-pagename' => 'Pahina:',
	'createsigndoc-allowedgroup' => 'Pinapahintulutang pangkat:',
	'createsigndoc-email' => 'Adres ng e-liham:',
	'createsigndoc-address' => 'Adres ng bahay:',
	'createsigndoc-extaddress' => 'Lungsod, estado, bansa:',
	'createsigndoc-phone' => 'Bilang (numero) ng telepono:',
	'createsigndoc-bday' => 'Kaarawan:',
	'createsigndoc-minage' => 'Pinakamababang gulang (edad):',
	'createsigndoc-introtext' => 'Pagpapakilala:',
	'createsigndoc-hidden' => 'Nakatago',
	'createsigndoc-optional' => 'Hindi talaga kailangan (maaaring wala nito)',
	'createsigndoc-create' => 'Likhain',
	'createsigndoc-error-generic' => 'Kamalian: $1',
	'createsigndoc-error-pagenoexist' => 'Kamalian: Hindi umiiral ang pahinang [[$1]].',
	'createsigndoc-success' => 'Matagumpay na napaandar/napagana ang paglalagda sa kasulatan (dokumento) sa [[$1]].
Upang masubok muna ito, pakidalaw ang [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} pahinang ito].',
	'createsigndoc-error-alreadycreated' => 'Umiiral na ang paglalagda sa kasulatan/dokumentong "$1".',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'createsigndoc-pagename' => 'Sayfa:',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'createsigndocument' => 'Cho phép ký tài liệu',
	'createsigndoc-head' => "Hãy dùng mẫu này để tạo trang 'Ký tài liệu' cho trang chỉ định, sao cho người dùng sẽ có thể ký tên vào nó thông qua [[Special:SignDocument]].
Xin hãy ghi rõ tên trang bạn muốn cho phép ký tên điện tử, thành viên của nhóm thành viên nào được cho phép ký tên, vùng nào bạn muốn người dùng nhìn thấy và cái nào là tùy chọn, tuổi tối thiểu được được ký tài liệu (không có giới hạn nếu bỏ trống);
và một đoạn giới thiệu ngắn gọn mô tả tài liệu và cung cấp hướng dẫn cho người dùng.

<b>Hiện không có cách nào để xóa hay sửa tài liệu chữ ký sau khi chúng được tạo</b> mà không truy cập trực tiếp vào cơ sở dữ liệu.
Ngoài ra, nội dung của trang được hiển thị tại trang ký tên sẽ là văn bản ''hiện thời'' của trang, bất kể có sự thay đổi nào sau hôm nay.
Xin hãy cực kỳ chắc chắn rằng tài liệu đã đạt tới mức ổn định để có thể ký tên, và xin hãy chắc chắn rằng bạn chỉ định tất cả các vùng một cách chính xác như mong muốn, ''trước khi đăng mẫu này lên''.",
	'createsigndoc-pagename' => 'Trang:',
	'createsigndoc-allowedgroup' => 'Nhóm được phép:',
	'createsigndoc-email' => 'Địa chỉ email:',
	'createsigndoc-address' => 'Địa chỉ nhà:',
	'createsigndoc-extaddress' => 'Thành phố, Bang, Quốc gia:',
	'createsigndoc-phone' => 'Số điện thoại:',
	'createsigndoc-bday' => 'Ngày sinh:',
	'createsigndoc-minage' => 'Tuổi tối thiểu:',
	'createsigndoc-introtext' => 'Giới thiệu:',
	'createsigndoc-hidden' => 'Bị ẩn',
	'createsigndoc-optional' => 'Tùy chọn',
	'createsigndoc-create' => 'Khởi tạo',
	'createsigndoc-error-generic' => 'Lỗi: $1',
	'createsigndoc-error-pagenoexist' => 'Lỗi: Trang [[$1]] không tồn tại.',
	'createsigndoc-success' => 'Khả năng ký tên đã được kích hoạt tại trang [[$1]].
Để thử nghiệm, xin hãy thăm [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} trang này].',
	'createsigndoc-error-alreadycreated' => 'Văn bản ký tên "$1" đã tồn tại.',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'createsigndocument' => 'Mögükön dispenami dokümas',
	'createsigndoc-pagename' => 'Pad:',
	'createsigndoc-allowedgroup' => 'Grup pedälöl:',
	'createsigndoc-email' => 'Ladet leäktronik:',
	'createsigndoc-address' => 'Domaladet:',
	'createsigndoc-extaddress' => 'Zif, Tat, Län:',
	'createsigndoc-phone' => 'Telefonanüm:',
	'createsigndoc-bday' => 'Motedadät:',
	'createsigndoc-minage' => 'Bäldot puik:',
	'createsigndoc-introtext' => 'Nüdugot:',
	'createsigndoc-hidden' => 'Klänedik',
	'createsigndoc-create' => 'Jafön',
	'createsigndoc-error-generic' => 'Pöl: $1',
	'createsigndoc-error-pagenoexist' => 'Pöl: Pad: [[$1]] no dabinon.',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 */
$messages['zh-hans'] = array(
	'createsigndocument' => '启用文档签名',
	'createsigndoc-phone' => '电话号码：',
	'createsigndoc-bday' => '出生日期：',
	'createsigndoc-hidden' => '隐藏',
	'createsigndoc-optional' => '可选',
	'createsigndoc-error-generic' => '错误：$1',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'createsigndocument' => '啟用文件簽名',
	'createsigndoc-phone' => '電話號碼：',
	'createsigndoc-bday' => '出生日期：',
	'createsigndoc-hidden' => '隱藏',
	'createsigndoc-optional' => '可選擇',
	'createsigndoc-error-generic' => '錯誤：$1',
);

