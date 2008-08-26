<?php
/* Internationalisation extension for SpecialCreateSignDocument
 * @MessageGroup SpecialCreateSignDocument
*/

$messages = array();

$messages['en'] = array(
	'createsigndocument'         => 'Enable document signing',
	'createsigndoc-head'         => "Use this form to create a 'Sign document' page for the provided page, such that users will be able to sign it via [[Special:SignDocument]].
Please specify the name of the page on which you wish to enable digital signing, members of which usergroup should be allowed to sign it, which fields you wish to be visible to users and which should be optional, a minimum age to require users to be to sign the document (no minimum if omitted);
and a brief introductory text describing the document and providing instructions to users.

<b>There is presently no way to delete or modify signature documents after they are created</b> without direct database access.
Additionally, the text of the page displayed on the signature page will be the ''current'' text of the page, regardless of changes made to it after today.
Please be absolutely positive that the document is to a point of stability for signing, and please also be sure that you specify all fields exactly as they should be, ''before submitting this form''.",
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

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'createsigndoc-pagename' => 'Лаштык:',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author SPQRobin
 * @author Naudefj
 */
$messages['af'] = array(
	'createsigndoc-pagename' => 'Bladsy:',
	'createsigndoc-email'    => 'E-pos adres',
	'createsigndoc-create'   => 'Skep',
);

/** Old English (Anglo-Saxon)
 * @author Meno25
 * @author SPQRobin
 */
$messages['ang'] = array(
	'createsigndoc-pagename' => 'Tramet:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Siebrand
 */
$messages['ar'] = array(
	'createsigndocument'                 => 'فعل توقيع الوثيقة',
	'createsigndoc-head'                 => "استخدم هذه الوثيقة لإنشاء صفحة 'Sign Document' للصفحة المعطاة، بحيث
يمكن للمستخدمين توقيعها من خلال [[Special:SignDocument]].
من فضلك حدد اسم
الصفحة التي تود تفعيل التوقيع الرقمي عليها، أعضاء أي
مجموعة مستخدم مسموح لهم بتوقيعها، أي حقول تود أن تكون مرئية للمستخدمين
وأي يجب أن تكون اختيارية، عمر أدنى لمستخدمين ليمكن لهم توقيع
الوثيقة (لا حد أدنى لو حذفت)، ونص تقديمي مختصر يصف الوثيقة ويوفر التعليمات للمستخدمين.

<b>لا توجد حاليا أية طريقة لحذف أو تعديل توقيعات الوثائق بعد
إنشائها</b> بدون دخول قاعدة البيانات مباشرة. إضافة إلى ذلك، نص الصفحة 
المعروض في صفحة التوقيع سيكون النص ''الحالي'' للصفحة، بغض النظر عن
التغييرات بها بعد اليوم. من فضلك كن متأكدا تماما من أن الوثيقة
وصلت لنقطة ثبات للتوقيع، ومن فضلك أيضا تأكد أنك حددت
كل الحقول تماما كما يجب أن تكون، ''قبل تنفيذ هذه الاستمارة''.",
	'createsigndoc-pagename'             => 'صفحة:',
	'createsigndoc-allowedgroup'         => 'المجموعة المسموحة:',
	'createsigndoc-email'                => 'عنوان البريد الإلكتروني:',
	'createsigndoc-address'              => 'عنوان المنزل:',
	'createsigndoc-extaddress'           => 'المدينة، الولاية، البلد:',
	'createsigndoc-phone'                => 'رقم الهاتف:',
	'createsigndoc-bday'                 => 'تاريخ الميلاد:',
	'createsigndoc-minage'               => 'العمر الأدنى:',
	'createsigndoc-introtext'            => 'مقدمة:',
	'createsigndoc-hidden'               => 'مخفية',
	'createsigndoc-optional'             => 'اختياري',
	'createsigndoc-create'               => 'أنشيء',
	'createsigndoc-error-generic'        => 'خطأ: $1',
	'createsigndoc-error-pagenoexist'    => 'خطأ: الصفحة [[$1]] غير موجودة.',
	'createsigndoc-success'              => 'توقيع الوثيقة تم تفعيله بنجاح على [[$1]]. لاختباره، من فضلك زر [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} هذه الصفحة].',
	'createsigndoc-error-alreadycreated' => 'توقيع الوثيقة "$1" موجود بالفعل.',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'createsigndoc-pagename'      => 'Páhina:',
	'createsigndoc-bday'          => 'Kamondágan:',
	'createsigndoc-create'        => 'Maggibo',
	'createsigndoc-error-generic' => 'Salâ: $1',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'createsigndoc-pagename'          => 'Страница:',
	'createsigndoc-allowedgroup'      => 'Позволена група:',
	'createsigndoc-email'             => 'Електронна поща:',
	'createsigndoc-address'           => 'Домашен адрес:',
	'createsigndoc-extaddress'        => 'Град, щат, държава:',
	'createsigndoc-phone'             => 'Телефонен номер:',
	'createsigndoc-bday'              => 'Дата на раждане:',
	'createsigndoc-minage'            => 'Минимална възраст:',
	'createsigndoc-introtext'         => 'Въведение:',
	'createsigndoc-hidden'            => 'Скрито',
	'createsigndoc-optional'          => 'Незадължително',
	'createsigndoc-create'            => 'Създаване',
	'createsigndoc-error-generic'     => 'Грешка: $1',
	'createsigndoc-error-pagenoexist' => 'Грешка: Страницата [[$1]] не съществува.',
);

/** Catalan (Català)
 * @author SMP
 */
$messages['ca'] = array(
	'createsigndoc-pagename' => 'Pàgina:',
	'createsigndoc-hidden'   => 'Amagat',
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

/** Greek (Ελληνικά)
 * @author Consta
 */
$messages['el'] = array(
	'createsigndoc-pagename'          => 'Σελίδα:',
	'createsigndoc-allowedgroup'      => 'Ομάδα:',
	'createsigndoc-email'             => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'createsigndoc-address'           => 'Διεύθυνση Οικίας:',
	'createsigndoc-extaddress'        => 'Πόλη, Περιοχή, Χώρα:',
	'createsigndoc-phone'             => 'Τηλεφωνικός αριθμός:',
	'createsigndoc-bday'              => 'Ημερομηνία Γέννησης:',
	'createsigndoc-introtext'         => 'Εισαγωγή:',
	'createsigndoc-error-generic'     => 'Σφάλμα: $1',
	'createsigndoc-error-pagenoexist' => 'Σφάλμα: Η σελίδα [[$1]] δεν υπάρχει.',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'createsigndocument'                 => 'Ebligu Dokumentan Subskribadon',
	'createsigndoc-pagename'             => 'Paĝo:',
	'createsigndoc-allowedgroup'         => 'Permesita grupo:',
	'createsigndoc-email'                => 'Retpoŝta adreso',
	'createsigndoc-address'              => 'Hejma Adreso:',
	'createsigndoc-extaddress'           => 'Urbo, Subŝtato, Lando:',
	'createsigndoc-phone'                => 'Nombro de telefono:',
	'createsigndoc-bday'                 => 'Naskodato:',
	'createsigndoc-minage'               => 'Minimuma aĝo:',
	'createsigndoc-introtext'            => 'Enkonduko:',
	'createsigndoc-hidden'               => 'Kaŝita',
	'createsigndoc-optional'             => 'Nedeviga',
	'createsigndoc-create'               => 'Krei',
	'createsigndoc-error-generic'        => 'Eraro: $1',
	'createsigndoc-error-pagenoexist'    => 'Eraro: La paĝo [[$1]] ne ekzistas.',
	'createsigndoc-success'              => 'Dokumenta subskribado estis sukcese ebligita ĉe [[$1]].
Por testi ĝin, bonvolu eniri [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} ĉi tiun paĝon].',
	'createsigndoc-error-alreadycreated' => 'Subskribado de dokumento "$1" jam ekzistas.',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'createsigndoc-pagename'          => 'Páhina:',
	'createsigndoc-allowedgroup'      => 'Alabán premitiu:',
	'createsigndoc-optional'          => 'Ocional',
	'createsigndoc-create'            => 'Creal',
	'createsigndoc-error-pagenoexist' => 'Marru: La páhina [[$1]] nu desisti.',
);

/** French (Français)
 * @author Sherbrooke
 * @author Urhixidur
 * @author Grondin
 */
$messages['fr'] = array(
	'createsigndocument'                 => "Activer l'authentification des documents",
	'createsigndoc-head'                 => "Utilisez ce formulaire pour créer une « page d'authentification » de documents pour l'article en question, de façon que chaque utilisateur soit capable d'authentifier via [[Special:SignDocument]]. Prière d'indiquer l'intitulé de l'article pour lequel vous souhaitez activer la fonction, les membres du groupe d'utilisateurs, quels champs seront accessibles aux utilisateurs (lesquels seront optionnels), l'âge minimal pour être membre du groupe (pas de minimum sinon) et un bref document expliquant le document et donnant des instructions aux utilisateurs.

'''Présentement, il n'y a aucun moyen d'effacer les documents une fois créés''', sauf en éditant la base de données du wiki. De plus, le texte de l'article affiché sur la page authentifiée sera le texte ''courant'', peu importe les modifications faites par la suite. Pour cette raison, soyez certain que le document soit sufisamment stable pour être authentifié et, ''avant de soumettre le formulaire'', vérifiez que vous avez bien choisi les champs tels que vous souhaitiez qu'ils soient.",
	'createsigndoc-pagename'             => 'Page :',
	'createsigndoc-allowedgroup'         => 'Groupe autorisé :',
	'createsigndoc-email'                => 'Addresse de courriel :',
	'createsigndoc-address'              => 'Adresse résidentielle :',
	'createsigndoc-extaddress'           => 'Ville, état (département ou province), pays :',
	'createsigndoc-phone'                => 'Numéro de téléphone :',
	'createsigndoc-bday'                 => 'Date de naissance :',
	'createsigndoc-minage'               => 'Âge minimum :',
	'createsigndoc-introtext'            => 'Introduction :',
	'createsigndoc-hidden'               => 'Caché',
	'createsigndoc-optional'             => 'Optionnel',
	'createsigndoc-create'               => 'Créer',
	'createsigndoc-error-generic'        => 'Erreur : $1',
	'createsigndoc-error-pagenoexist'    => "La page [[$1]] n'existe pas.",
	'createsigndoc-success'              => "L'authentification des documents est activée sur [[$1]]. Pour la tester, voir [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} cette page].",
	'createsigndoc-error-alreadycreated' => 'Le document d’authentification pour « $1 » a déjà été créé.',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'createsigndoc-pagename' => 'Side:',
	'createsigndoc-create'   => 'Oanmeitsje',
);

/** Irish (Gaeilge)
 * @author Moilleadóir
 */
$messages['ga'] = array(
	'createsigndoc-create' => 'Cruthaigh',
);

/** Galician (Galego)
 * @author Alma
 */
$messages['gl'] = array(
	'createsigndocument'                 => 'Habilitar a Sinatura de Documentos',
	'createsigndoc-head'                 => "Empregue este formulario para crear unha páxina \"Asinar Documento\" para a páxina relacionada, de tal xeito que os usuarios o poidan asinar mediante [[Special:SignDocument]]. Especifique o nome
da páxina na que quere activar a sinatura dixital, os membros de que grupo de usuarios poden
asinalo, que campos lles resultan visíbeis aos usuarios e cales han de ser optativos, a idade
mínima que se lles esixe aos usuarios para asinar o documento (sen mínimo se se omitir) e un
texto introdutorio breve que describa o documento e lles dea instrucións aos usuarios.

<b>Actualmente non resulta posíbel eliminar ou modificar os documentos de sinatura unha vez que sexan
creados</b> sen acceso directo á base de datos. Ademais, o texto da páxina que se amosa na páxina de
sinaturas será o texto ''actual'' da páxina, independentemente das modificacións que se lle fagan despois de hoxe. Asegúrese ben de que o documento está en situación de estabilidade antes de asinalo e asegúrese tamén de que especifica todos os campos exactamente como han de ser ''antes de enviar este formulario''.",
	'createsigndoc-pagename'             => 'Páxina:',
	'createsigndoc-allowedgroup'         => 'Grupo permitido:',
	'createsigndoc-email'                => 'Enderezo electrónico:',
	'createsigndoc-address'              => 'Enderezo familiar:',
	'createsigndoc-extaddress'           => 'Cidade, Estado, País:',
	'createsigndoc-phone'                => 'Número de teléfono:',
	'createsigndoc-bday'                 => 'Aniversario:',
	'createsigndoc-minage'               => 'Idade minima:',
	'createsigndoc-introtext'            => 'Introdución:',
	'createsigndoc-hidden'               => 'Oculto',
	'createsigndoc-optional'             => 'Opcional',
	'createsigndoc-create'               => 'Crear',
	'createsigndoc-error-generic'        => 'Erro: $1',
	'createsigndoc-error-pagenoexist'    => 'Erro: A páxina [[$1]] non existe.',
	'createsigndoc-success'              => 'O documento asinado foi habilitado con éxito en [[$1]]. Para comprobalo, visite [{{SERVER}}{{localurl: Special: SignDocument|doc=$2}} esta páxina].',
	'createsigndoc-error-alreadycreated' => 'O documento asinado "$1" xa existe.',
);

/** Hawaiian (Hawai`i)
 * @author Singularity
 */
$messages['haw'] = array(
	'createsigndoc-pagename' => '‘Ao‘ao:',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 */
$messages['hi'] = array(
	'createsigndoc-pagename' => 'पन्ना:',
	'createsigndoc-hidden'   => 'छुपाई हुई',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'createsigndocument'                 => 'Podpisanje dokumentow zmóžnić',
	'createsigndoc-head'                 => "Wužij tutón formular, zo by stronu 'Podpisny dokument' za wotpowědny nastawk wutworił, zo by wužiwarjo přez [[Special:SignDocument]] podpisać móhli. Prošu podaj mjeno nastawka, na kotrymž chceš digatalny podpis zmóžnił, kotři čłonojo kotreje wužiwarskeje skupiny smědźa tam podpisać, kotre pola wužiwarjo smědźa widźeć a kotre měli opcionalne być, trěbnu minimalnu starobu za podpisanje dokumenta (njeje minimum, jeli žane podaće njeje) a krótki zawodny tekst, kotryž tutón dokumement wopisuje a wužiwarjam pokiwy poskića.

<b>Tuchwilu bjez přistupa k datowej bance žana móžnosć njeje, zo bychu so podpisne dokumenty zničili abo změnili, po tym zo su wutworjene.</b> Nimo toho budźe tekst, kotryž so na podpisnej stronje zwobraznja, ''aktualny'' tekst strony, njedźiwajo na změny ščinjene pozdźišo. Prošu budźe tebi absolutnje wěsty, zo je tutón dokument za podpisanje stabilny dosć, a zawěsć so tež, zo sy wšě pola takle kaž trjeba wupjelnił, ''prjedy hač tutón formular wotesćele''.",
	'createsigndoc-pagename'             => 'Strona:',
	'createsigndoc-allowedgroup'         => 'Dowolena skupina:',
	'createsigndoc-email'                => 'E-mejlowa adresa:',
	'createsigndoc-address'              => 'Bydlenska adresa:',
	'createsigndoc-extaddress'           => 'Město, stat, kraj:',
	'createsigndoc-phone'                => 'Telefonowe čisło:',
	'createsigndoc-bday'                 => 'Narodniny:',
	'createsigndoc-minage'               => 'Minimalna staroba:',
	'createsigndoc-introtext'            => 'Zawod:',
	'createsigndoc-hidden'               => 'Schowany',
	'createsigndoc-optional'             => 'Opcionalny',
	'createsigndoc-create'               => 'Wutworić',
	'createsigndoc-error-generic'        => 'Zmylk: $1',
	'createsigndoc-error-pagenoexist'    => 'Zmylk: Strona [[$1]] njeeksistuje.',
	'createsigndoc-success'              => 'Podpisanje dokumentow bu wuspěšnje na [[$1]]aktiwizowane. Zo by je testował, wopytaj prošu [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} tutu stronu:].',
	'createsigndoc-error-alreadycreated' => 'Podpis dokumenta "$1" hižo eksistuje.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'createsigndoc-create' => 'Crear',
);

/** Icelandic (Íslenska)
 * @author SPQRobin
 */
$messages['is'] = array(
	'createsigndoc-pagename' => 'Síða:',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'createsigndocument'              => 'Uripna Panapak-tanganan Dokumèn',
	'createsigndoc-pagename'          => 'Kaca:',
	'createsigndoc-allowedgroup'      => 'Grup sing diparengaké:',
	'createsigndoc-email'             => 'Alamat e-mail:',
	'createsigndoc-address'           => 'Alamat omah:',
	'createsigndoc-extaddress'        => 'Kutha, Negara bagéyan, Negara:',
	'createsigndoc-phone'             => 'Nomer tilpun:',
	'createsigndoc-bday'              => 'Tanggal lair:',
	'createsigndoc-minage'            => 'Umur minimum:',
	'createsigndoc-introtext'         => 'Introduksi:',
	'createsigndoc-hidden'            => 'Kadelikaké',
	'createsigndoc-optional'          => 'Opsional',
	'createsigndoc-create'            => 'Nggawé',
	'createsigndoc-error-generic'     => 'Luput: $1',
	'createsigndoc-error-pagenoexist' => 'Luput: Kaca [[$1]] ora ana.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Chhorran
 */
$messages['km'] = array(
	'createsigndoc-pagename'  => 'ទំព័រ៖',
	'createsigndoc-email'     => 'អាសយដ្ឋានអ៊ីមែល៖',
	'createsigndoc-address'   => 'អាស័យដ្ឋាន ផ្ទះ ៖',
	'createsigndoc-phone'     => 'លេខទូរស័ព្ទ៖',
	'createsigndoc-bday'      => 'ថ្ងៃខែឆ្នាំកំនើត៖',
	'createsigndoc-introtext' => 'សេចក្តីណែនាំ៖',
	'createsigndoc-hidden'    => 'ត្រូវបានបិទបាំង',
	'createsigndoc-create'    => 'បង្កើត',
);

/** Korean (한국어)
 * @author ToePeu
 */
$messages['ko'] = array(
	'createsigndoc-create' => '만들기',
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
	'createsigndoc-create' => 'Aanläje',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'createsigndoc-pagename'          => 'Pagina:',
	'createsigndoc-error-pagenoexist' => 'Error: Pagina [[$1]] non existit.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'createsigndocument'                 => 'Ënnerschreiwen vun Dokumenter erméiglechen',
	'createsigndoc-pagename'             => 'Säit:',
	'createsigndoc-allowedgroup'         => 'Erlaabte Grupp:',
	'createsigndoc-email'                => 'E-mail Adress:',
	'createsigndoc-extaddress'           => 'Stad, Regioun/Bundesstaat, Land:',
	'createsigndoc-phone'                => 'Telefonsnummer:',
	'createsigndoc-bday'                 => 'Geburtsdag:',
	'createsigndoc-minage'               => 'Mindesalter:',
	'createsigndoc-introtext'            => 'Aféierung:',
	'createsigndoc-hidden'               => 'Verstoppt',
	'createsigndoc-optional'             => 'Fakultativ',
	'createsigndoc-error-generic'        => 'Feeler: $1',
	'createsigndoc-error-pagenoexist'    => "Feeler: D'Säit [[$1]] gëtt et net.",
	'createsigndoc-error-alreadycreated' => 'Dokument ënnerschreiwen "$1" gëtt et schonn',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'createsigndoc-pagename'             => 'താള്‍:',
	'createsigndoc-allowedgroup'         => 'അനുവദനീയമായ ഗ്രൂപ്പ്:',
	'createsigndoc-email'                => 'ഇമെയില്‍ വിലാസം:',
	'createsigndoc-address'              => 'വീടിന്റെ വിലാസം:',
	'createsigndoc-extaddress'           => 'നഗരം. സംസ്ഥാനം, രാജ്യം:',
	'createsigndoc-phone'                => 'ഫോണ്‍ നമ്പര്‍:',
	'createsigndoc-bday'                 => 'ജനനതീയ്യതി:',
	'createsigndoc-minage'               => 'കുറഞ്ഞ പ്രായം:',
	'createsigndoc-introtext'            => 'പ്രാരംഭം:',
	'createsigndoc-hidden'               => 'മറഞ്ഞിരിക്കുന്നത്',
	'createsigndoc-optional'             => 'നിര്‍ബന്ധമില്ല',
	'createsigndoc-create'               => 'താള്‍ സൃഷ്ടിക്കുക',
	'createsigndoc-error-generic'        => 'പിഴവ്: $1',
	'createsigndoc-error-pagenoexist'    => 'പിശക്: [[$1]] എന്ന താള്‍ നിലവിലില്ല.',
	'createsigndoc-success'              => '[[$1]] പ്രമാണഒപ്പിടല്‍ വിജയകരമായി പ്രവര്‍ത്തനസജ്ജമാക്കിയിരിക്കുന്നു. അതു പരീക്ഷിക്കുവാന്‍ ദയവായി [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} ഈ താള്‍] സന്ദര്‍ശിക്കുക.',
	'createsigndoc-error-alreadycreated' => 'പ്രമാണ ഒപ്പിടല്‍ "$1" നിലവിലുണ്ട്.',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'createsigndocument'                 => 'डॉक्यूमेंटवर सही करणे सुरू करा',
	'createsigndoc-head'                 => "दिलेल्या पानासाठी एक 'डॉक्यूमेंटवर सही करा' पृष्ठ तयार करण्यासाठी या अर्जाचा वापर करा, ज्यामुळे सदस्यांना [[Special:SignDocument]] वापरून त्या पानावर सही करता येईल.
कॄपया ज्या पानावर सही करणे सुरू करायचे ते पान निवडा, तसेच कुठल्या सदस्यगटांना या पानावर सही करू द्यायची ते ठरवा, कुठले रकाने सदस्यांना दिसले पाहिजेत तसेच कुठले रकाने वैकल्पिक ठेवायचे ते ठरवा, त्यानंतर कमीतकमी वयाची अट द्या (जर रिकामे ठेवले तर वयाची अट नाही); तसेच एक छोटीशी डॉक्यूमेंटची ओळख तसेच सदस्यांना सूचना द्या.

<b>सध्या सही साठी डॉक्यूमेंट तयार झाल्यानंतर त्याला वगळण्याची कुठलिही सुविधा उपलब्ध नाही.</b> फक्त थेट डाटाबेसशी संपर्क करता येईल.
तसेच, तसेच सही साठी उपलब्ध पानावर '''सध्याचा''' मजकूर दाखविला जाईल, जरी तो आज नंतर बदलला तरीही.
कृपया हे डॉक्यूमेंट सही साठी उपलब्ध करण्यासाठी योग्य असल्याची खात्री करा, तसेच ''हा अर्ज पाठविण्यापूर्वी'' तुम्ही सर्व रकाने योग्य प्रकारे भरलेले आहेत, याची खात्री करा.",
	'createsigndoc-pagename'             => 'पान',
	'createsigndoc-allowedgroup'         => 'अधिकृत सदस्य गट:',
	'createsigndoc-email'                => 'इ-मेल पत्ता:',
	'createsigndoc-address'              => 'घरचा पत्ता:',
	'createsigndoc-extaddress'           => 'शहर, राज्य, देश:',
	'createsigndoc-phone'                => 'दूरध्वनी क्रमांक',
	'createsigndoc-bday'                 => 'जन्मदिवस',
	'createsigndoc-minage'               => 'कमीतकमी वय:',
	'createsigndoc-introtext'            => 'ओळख:',
	'createsigndoc-hidden'               => 'लपविलेले',
	'createsigndoc-optional'             => 'पर्यायी',
	'createsigndoc-create'               => 'निर्मीतकरा',
	'createsigndoc-error-generic'        => 'त्रुटी: $1',
	'createsigndoc-error-pagenoexist'    => 'त्रुटी: पान [[$1]] अस्तित्त्वात नाही.',
	'createsigndoc-success'              => '[[$1]] वर आता सही करता येऊ शकेल.
तपासण्यासाठी, [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} या पानाला] भेट द्या.',
	'createsigndoc-error-alreadycreated' => 'डॉक्यूमेंट सही "$1" अगोदरच अस्तित्त्वात आहे.',
);

/** Nahuatl (Nahuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'createsigndoc-pagename' => 'Zāzanilli:',
	'createsigndoc-create'   => 'Ticchīhuāz',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'createsigndocument'                 => 'Documentondertekening inschakelen',
	'createsigndoc-head'                 => "Gebruik dit formulier om een pagina 'Document ondertekenen' voor een gegeven pagina te maken, zodat gebruikers het kunnen ondertekenen via [[Special:SignDocument]].
Geef alstublieft op voor welke pagina u digitaal ondertekenen wilt inschakelen, welke gebruikersgroepen kunnen ondertekeken, welke velden zichtbaar moeten zijn voor gebruikers en welke optioneel zijn, een minimale leeftijd waaraan gebruikers moeten voldoen alvorens te kunnen ondertekenen (geen beperkingen als leeg gelaten);
en een korte inleidende tekst over het document en instructies voor de gebruikers.

<b>Er is op het moment geen mogelijkheid om te ondertekenen documenten te verwijderen of te wijzigen nadat ze zijn aangemaakt</b> zonder directe toegang tot de database.
Daarnaast is de tekst van de pagina die wordt weergegeven op de ondertekeningspagina de ''huidige'' tekst van de pagina, ongeacht de wijzigingen die erna gemaakt worden.
Zorg er alstublieft voor dat het document een stabiele versie heeft voordat u ondertekenen inschakelt, en zorg er alstublieft voor dat alle velden de juiste waarden hebben ''voordat u het formulier instuurt''.",
	'createsigndoc-pagename'             => 'Pagina:',
	'createsigndoc-allowedgroup'         => 'Toegelaten groep:',
	'createsigndoc-email'                => 'E-mailadres:',
	'createsigndoc-address'              => 'Adres:',
	'createsigndoc-extaddress'           => 'Stad, staat, land:',
	'createsigndoc-phone'                => 'Telefoonnummer:',
	'createsigndoc-bday'                 => 'Geboortedatum:',
	'createsigndoc-minage'               => 'Minimum leeftijd:',
	'createsigndoc-introtext'            => 'Inleiding:',
	'createsigndoc-hidden'               => 'Verborgen',
	'createsigndoc-optional'             => 'Optioneel',
	'createsigndoc-create'               => 'Aanmaken',
	'createsigndoc-error-generic'        => 'Fout: $1',
	'createsigndoc-error-pagenoexist'    => 'Error: De pagina [[$1]] bestaat niet.',
	'createsigndoc-success'              => 'Documentondertekening is ingeschakeld op
[[$1]]. Ga alstublieft naar [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} deze pagina] om het te testen.',
	'createsigndoc-error-alreadycreated' => 'De documentondertekening "$1" bestaat al.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'createsigndoc-pagename' => 'Side:',
	'createsigndoc-optional' => 'Valfri',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'createsigndocument'                 => 'Slå på dokumentsignering',
	'createsigndoc-head'                 => "Bruk dette skjemaet for å opprette et «signaturdokument» for denne siden, slik at brukere kan signere den via [[Special:SignDocument]]. Vennligst oppgi sidens navn, hvilken brukergruppe som skal kunne signere den, hvilke felter som skal være synlige for brukerne, hvilke som skal være valgfrie, minimumsalder for å kunne signere dokumentet (om denne ikke oppgis, er det ingen grense), og en kjapp introduksjonstekst som beskriver dokumentet og gir instruksjoner til brukerne.

<b>Det er ingen måte å slette eller endre signaturdokumenter etter at de opprettes</b> uten direkte databasetilgang. Teksten på siden på signatursiden vil også være den ''nåværende'' teksten, uavhengig av hvilke endringer som gjøres etter i dag. Vær hundre prosent sikker på at dokumentet er stabilt når det signeres, og vær også sikker på at du oppgir alle felt som de burde være, ''før du lagrer dette skjemaet''.",
	'createsigndoc-pagename'             => 'Side:',
	'createsigndoc-allowedgroup'         => 'Tillatt gruppe:',
	'createsigndoc-email'                => 'E-postadresse:',
	'createsigndoc-address'              => 'Hjemmeadresse:',
	'createsigndoc-extaddress'           => 'By, stat, land:',
	'createsigndoc-phone'                => 'Telefonnummer:',
	'createsigndoc-bday'                 => 'Fødselsdato:',
	'createsigndoc-minage'               => 'Minimumsalder:',
	'createsigndoc-introtext'            => 'Introduksjon:',
	'createsigndoc-hidden'               => 'Skjult',
	'createsigndoc-optional'             => 'Valgfri',
	'createsigndoc-create'               => 'Opprett',
	'createsigndoc-error-generic'        => 'Feil: $1',
	'createsigndoc-error-pagenoexist'    => 'Feil: Siden [[$1]] eksisterer ikke.',
	'createsigndoc-success'              => 'Dokumentsignering har blitt slått på for [[$1]]. For å signere det, besøk [{{fullurl:Special:SignDocument|doc=$2}} denne siden].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringen «$1» finnes allerede.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'createsigndocument'                 => "Activar l'autentificacion dels documents",
	'createsigndoc-head'                 => "Utilizatz aqueste formulari per crear una pagina d'autentificacion de documents per l'article en question, de biais que cada utilizaire serà capable d'autentificar via [[Special:SignDocument]]. Mercés d'indicar lo nom de l'article pelqual desiratz activar la foncion, los membres del grop d'utilizaires, quals camps seràn accessibles als utilizaires (losquals seràn opcionals), l'edat minimala per èsser membre del grop (pas de minimom siquenon) e un document brèu explicant lo document e balhant d'instruccions als utilizaires. 

<b>Presentadament, i a pas cap de mejan d'escafar los documents un còp creats</b>, al despart en editant la banca de donadas del wiki. E mai, lo tèxt de l'article afichat sus la pagina autentificada serà lo tèxt ''corrent'', pauc impòrta las modificacions fachas de per aprèp. Per aquesta rason, siatz segur que lo document es sufisentament estable per èsser autentificat e, ''abans de sometre lo formulari'', verificatz qu'avètz plan causit los camps tals coma desiratz que sián.",
	'createsigndoc-pagename'             => 'Pagina :',
	'createsigndoc-allowedgroup'         => 'Grop autorizat :',
	'createsigndoc-email'                => 'Adreça de corrièr electronic :',
	'createsigndoc-address'              => 'Adreça residenciala :',
	'createsigndoc-extaddress'           => 'Vila, estat (departament o província), país :',
	'createsigndoc-phone'                => 'Numèro de telèfon :',
	'createsigndoc-bday'                 => 'Data de naissença :',
	'createsigndoc-minage'               => 'Edat minimoma :',
	'createsigndoc-introtext'            => 'Introduccion :',
	'createsigndoc-hidden'               => 'Amagat',
	'createsigndoc-optional'             => 'Opcional',
	'createsigndoc-create'               => 'Crear',
	'createsigndoc-error-generic'        => 'Error : $1',
	'createsigndoc-error-pagenoexist'    => 'La pagina [[$1]] existís pas.',
	'createsigndoc-success'              => "L'autentificacion dels documents es activada sus [[$1]]. Per la testar, vejatz [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} aquesta pagina].",
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
	'createsigndoc-pagename'          => 'Strona:',
	'createsigndoc-email'             => 'Adres e-mail:',
	'createsigndoc-address'           => 'Adres domowy',
	'createsigndoc-extaddress'        => 'Miejscowość, kraj',
	'createsigndoc-phone'             => 'Numer telefonu:',
	'createsigndoc-bday'              => 'Data urodzenia:',
	'createsigndoc-minage'            => 'Minimalny wiek',
	'createsigndoc-create'            => 'Utwórz',
	'createsigndoc-error-generic'     => 'Błąd: $1',
	'createsigndoc-error-pagenoexist' => 'Błąd: Strona [[$1]] nie istnieje',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'createsigndocument'              => 'Visché la firma digital ëd na pàgina coma document',
	'createsigndoc-head'              => "Ch'a dòvra la domanda ambelessì sota për visché l'opsion ëd 'Firma Digital' ëd n'artìcol, ch'a lassa che j'utent a peulo firmé ën dovrand la fonsion ëd [[Special:SignDocument|firma digital]]. 

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
	'createsigndoc-pagename'          => 'Pàgina:',
	'createsigndoc-allowedgroup'      => "Partìe d'utent ch'a peulo firmé:",
	'createsigndoc-email'             => 'Adrëssa ëd pòsta eletrònica',
	'createsigndoc-address'           => 'Adrëssa ëd ca:',
	'createsigndoc-extaddress'        => 'Sità, Provinsa, Stat:',
	'createsigndoc-phone'             => 'Nùmer ëd telèfono:',
	'createsigndoc-bday'              => 'Nait(a) dël:',
	'createsigndoc-minage'            => 'Età mìnima:',
	'createsigndoc-introtext'         => 'Spiegon:',
	'createsigndoc-hidden'            => 'Stërmà',
	'createsigndoc-optional'          => 'Opsional',
	'createsigndoc-create'            => 'Buté an firma',
	'createsigndoc-error-generic'     => 'Eror: $1',
	'createsigndoc-error-pagenoexist' => "Eror: a-i é pa gnun-a pàgina ch'as ciama [[$1]].",
	'createsigndoc-success'           => "La procedura për buté an firma [[$1]] a l'é andaita a bonfin. Për provela, për piasì ch'a varda [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} ambelessì].",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'createsigndoc-pagename'   => 'مخ:',
	'createsigndoc-email'      => 'برېښليک پته:',
	'createsigndoc-address'    => 'د کور پته:',
	'createsigndoc-extaddress' => 'ښار، ايالت، هېواد:',
	'createsigndoc-phone'      => 'د ټيليفون شمېره:',
	'createsigndoc-bday'       => 'د زېږون نېټه:',
	'createsigndoc-hidden'     => 'پټ',
	'createsigndoc-create'     => 'جوړول',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'createsigndoc-pagename'          => 'Página:',
	'createsigndoc-allowedgroup'      => 'Grupo autorizado:',
	'createsigndoc-email'             => 'Endereço de e-mail:',
	'createsigndoc-extaddress'        => 'Cidade, Estado, País:',
	'createsigndoc-phone'             => 'Número de telefone:',
	'createsigndoc-bday'              => 'Data de nascimento:',
	'createsigndoc-minage'            => 'Idade mínima:',
	'createsigndoc-introtext'         => 'Introdução:',
	'createsigndoc-hidden'            => 'Escondido',
	'createsigndoc-optional'          => 'Opcional',
	'createsigndoc-create'            => 'Criar',
	'createsigndoc-error-generic'     => 'Erro: $1',
	'createsigndoc-error-pagenoexist' => 'Erro: A página [[$1]] não existe.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'createsigndoc-pagename' => 'Pagină:',
	'createsigndoc-email'    => 'Adresă e-mail:',
	'createsigndoc-hidden'   => 'Ascunse',
	'createsigndoc-create'   => 'Creează',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'createsigndocument'                 => 'Включить сбор подписей для документа',
	'createsigndoc-head'                 => "Вы можете использовать данную форму для инициации «подписания документа», участники смогут подписать документ с помощью служебной страницы [[Special:SignDocument]].
Пожалуйста, укажите название страницы, на которой вы желаете включить сбор цифровых подписей, члены каких групп участников могут подписывать документ, какие поля будут видны обычным участникам, какие поля не обязательны для заполнения, минимальный возраст участника, желающего подписать документ (по умолчанию нет ограничений по возрасту), а также краткый вступительный текст, описывающий документ и дающий указания участникам.

<b>В настоящее время нет способа удалить или изменить подписываемые документы после того, как они созданы</b>, без прямого доступа в базу данных.
Кроме того, текст страницы, отображаемый на странице сбора подписей будет ''текущим'' текстом страницы, не смотря на изменения, сделанные в нём после сегодняшнего дня.
Пожалуйста, твёрдо убедитесь, что документ достаточно стабилен для подписания и, пожалуйста, убедитесь также, что вы указываете все поля точно так, как они должны быть, ''перед отправкой этой формы''.",
	'createsigndoc-pagename'             => 'Страница:',
	'createsigndoc-allowedgroup'         => 'Допустимые группы:',
	'createsigndoc-email'                => 'Электронная почта:',
	'createsigndoc-address'              => 'Домашний адрес:',
	'createsigndoc-extaddress'           => 'Город, штат, страна:',
	'createsigndoc-phone'                => 'Номер телефона:',
	'createsigndoc-bday'                 => 'Дата рождения:',
	'createsigndoc-minage'               => 'Минимальный возраст:',
	'createsigndoc-introtext'            => 'Вступление:',
	'createsigndoc-hidden'               => 'Скрыто',
	'createsigndoc-create'               => 'Создать',
	'createsigndoc-error-generic'        => 'Ошибка: $1',
	'createsigndoc-error-pagenoexist'    => 'Ошибка: страницы [[$1]] не существует.',
	'createsigndoc-success'              => 'Подписание документа успешно включено на странице [[$1]].
Чтобы проверить сбор подписей, пожалуйста, зайдите на [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} эту страницу].',
	'createsigndoc-error-alreadycreated' => 'Сбор подписей для страницы «$1» уже включён.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'createsigndocument'                 => 'Zapnúť podpisovanie dokumentov',
	'createsigndoc-head'                 => "Tento formulár slúži na vytvorenie stránky „Podpísať dokument“ pre uvedenú stránku, aby
ju používatelia mohli podpisovať pomocou [[Special:SignDocument]]. Prosím, uveďte názov
stránky, na ktorej chcete zapnúť digitálne podpisovanie, členovia ktorých skupín ju budú
môcť podpisovať a, ktoré polia budú viditeľné používateľom a ktoré by mali byť voliteľné,
minimálny vek, ktorý je požadovaný na podpísanie dokumentu (ak údaj vynecháte, nebude
vyžiadovaný žiadny minimálny vek) a stručný úvodný text popisujúci dokument a poskytujúci
používateľom inštrukcie.

<b>Momentálne neexistuje spôsob ako zmazať alebo zmeniť podpisované dokumenty potom, ako boli vytvorené</b> bez použitia priameho prístupu do databázy. Naviac text stránky zobrazený na stránke podpisov bude ''aktuálny'' text stránky, nezávisle na zmenách, ktoré v ňom od dnes nastanú. Prosím, buďte si absolútne istý, že uvádzate všetky polia presne ako by mali byť ''predtým než odošlete formulár''.",
	'createsigndoc-pagename'             => 'Stránka:',
	'createsigndoc-allowedgroup'         => 'Povolená skupina:',
	'createsigndoc-email'                => 'Emailová adresa:',
	'createsigndoc-address'              => 'Domáca adresa:',
	'createsigndoc-extaddress'           => 'Mesto, štát, krajina:',
	'createsigndoc-phone'                => 'Telefónne číslo:',
	'createsigndoc-bday'                 => 'Dátum narodenia:',
	'createsigndoc-minage'               => 'Minimálny vek:',
	'createsigndoc-introtext'            => 'Úvodný text:',
	'createsigndoc-hidden'               => 'Skryté',
	'createsigndoc-optional'             => 'Voliteľné',
	'createsigndoc-create'               => 'Vytvoriť',
	'createsigndoc-error-generic'        => 'Chyba: $1',
	'createsigndoc-error-pagenoexist'    => 'Chyba: Stránka [[$1]] neexistuje.',
	'createsigndoc-success'              => 'Podpisovanie dokumentov bolo úspešne zapnuté pre stránku  [[$1]]. Otestovať ho môžete na [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} tejto stránke].',
	'createsigndoc-error-alreadycreated' => 'Podpis dokumentu „$1“ už existuje.',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'createsigndoc-pagename'     => 'Страна:',
	'createsigndoc-allowedgroup' => 'Дозвољена група:',
	'createsigndoc-email'        => 'Е-пошта:',
	'createsigndoc-extaddress'   => 'Град, држава:',
);

/** Swati (SiSwati)
 * @author Jatrobat
 */
$messages['ss'] = array(
	'createsigndoc-phone'  => 'Inombolo yelucingo:',
	'createsigndoc-create' => 'Kúdála',
);

/** Swedish (Svenska)
 * @author Lejonel
 * @author M.M.S.
 * @author Jon Harald Søby
 */
$messages['sv'] = array(
	'createsigndocument'                 => 'Möjliggör dokument signering',
	'createsigndoc-head'                 => "Använd detta formulär för att skapa ett \"signaturdokument\" för denna sida, så att användare kan signera det via [[Special:SignDocument]].
Var god ange sidans namn, vilken användargrupp som ska kunna signera det, vilka fält som ska vara synliga för användarna, vilka som ska vara valfria, minimumålder för att kunna signera dokumentet (om detta inte anges, finns det ingen gräns), och en kort introduktionstext som beskriver dokumentet och ger instruktioner till användarna.

<b>Det finns inget sätt att radera eller ändra signaturdokument efter att de har skapats</b> utan direkt databastillgång.
Texten på sidan på signatursidan kommer också vara den ''nuvarande'' texten, oavsätt av vilka ändringar som görs efter i dag.
Var hundra procent säker på att dokumentet är stabilt när det signeras, och var också säker på att du anger alla fält som de ska vara, ''innan du sparar detta formulär''.",
	'createsigndoc-pagename'             => 'Sida:',
	'createsigndoc-allowedgroup'         => 'Tillåten grupp:',
	'createsigndoc-email'                => 'E-postadress:',
	'createsigndoc-address'              => 'Gatuadress:',
	'createsigndoc-extaddress'           => 'Ort, delstat, land:',
	'createsigndoc-phone'                => 'Telefonnummer:',
	'createsigndoc-bday'                 => 'Födelsedatum:',
	'createsigndoc-minage'               => 'Minimiålder:',
	'createsigndoc-introtext'            => 'Introduktion:',
	'createsigndoc-hidden'               => 'dolt',
	'createsigndoc-optional'             => 'Frivilligt',
	'createsigndoc-create'               => 'Skapa',
	'createsigndoc-error-generic'        => 'Fel: $1',
	'createsigndoc-error-pagenoexist'    => 'Fel: Sidan [[$1]] finns inte.',
	'createsigndoc-success'              => 'Dokumentsignering har stängts av för [[$1]]. För att signera det, besök [{{fullurl:Special:SignDocument|doc=$2}} den här sidan].',
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
	'createsigndoc-pagename'          => 'పేజీ:',
	'createsigndoc-email'             => 'ఈ-మెయిల్ చిరునామా:',
	'createsigndoc-address'           => 'ఇంటి చిరునామా:',
	'createsigndoc-extaddress'        => 'నగరం, రాష్ట్రం, దేశం:',
	'createsigndoc-phone'             => 'ఫోన్ నంబర్:',
	'createsigndoc-bday'              => 'పుట్టినరోజు:',
	'createsigndoc-minage'            => 'కనిష్ట వయసు:',
	'createsigndoc-introtext'         => 'పరిచయం:',
	'createsigndoc-optional'          => 'ఐచ్చికం',
	'createsigndoc-create'            => 'సృష్టించు',
	'createsigndoc-error-generic'     => 'పొరపాటు: $1',
	'createsigndoc-error-pagenoexist' => 'పొరపాటు: [[$1]] అనే పేజీ లేనే లేదు.',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'createsigndoc-pagename' => 'Pájina:',
	'createsigndoc-email'    => 'Diresaun korreiu eletróniku:',
	'createsigndoc-create'   => 'Kria',
);

/** Tajik (Cyrillic) (Тоҷикӣ/tojikī (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'createsigndoc-pagename'          => 'Саҳифа:',
	'createsigndoc-email'             => 'Нишонаи E-mail:',
	'createsigndoc-address'           => 'Суроғаи Хона:',
	'createsigndoc-extaddress'        => 'Шаҳр, Вилоят, Кишвар:',
	'createsigndoc-phone'             => 'Шумораи телефон:',
	'createsigndoc-bday'              => 'Зодрӯз:',
	'createsigndoc-introtext'         => 'Шиносоӣ:',
	'createsigndoc-optional'          => 'Ихтиёрӣ',
	'createsigndoc-create'            => 'Эҷод',
	'createsigndoc-error-generic'     => 'Хато: $1',
	'createsigndoc-error-pagenoexist' => 'Хато: Саҳифаи [[$1]] вуҷуд надорад.',
);

/** Turkish (Türkçe)
 * @author Karduelis
 */
$messages['tr'] = array(
	'createsigndoc-pagename' => 'Sayfa:',
);

/** Vietnamese (Tiếng Việt)
 * @author Vinhtantran
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'createsigndocument'                 => 'Cho phép ký tài liệu',
	'createsigndoc-head'                 => "Hãy dùng mẫu này để tạo trang 'Ký tài liệu' cho trang chỉ định, sao cho người dùng sẽ có thể ký tên vào nó thông qua [[Special:SignDocument]].
Xin hãy ghi rõ tên trang bạn muốn cho phép ký tên điện tử, thành viên của nhóm thành viên nào được cho phép ký tên, vùng nào bạn muốn người dùng nhìn thấy và cái nào là tùy chọn, tuổi tối thiểu được được ký tài liệu (không có giới hạn nếu bỏ trống);
và một đoạn giới thiệu ngắn gọn mô tả tài liệu và cung cấp hướng dẫn cho người dùng.

<b>Hiện không có cách nào để xóa hay sửa tài liệu chữ ký sau khi chúng được tạo</b> mà không truy cập trực tiếp vào cơ sở dữ liệu.
Ngoài ra, nội dung của trang được hiển thị tại trang ký tên sẽ là văn bản ''hiện thời'' của trang, bất kể có sự thay đổi nào sau hôm nay.
Xin hãy cực kỳ chắc chắn rằng tài liệu đã đạt tới mức ổn định để có thể ký tên, và xin hãy chắc chắn rằng bạn chỉ định tất cả các vùng một cách chính xác như mong muốn, ''trước khi đăng mẫu này lên''.",
	'createsigndoc-pagename'             => 'Trang:',
	'createsigndoc-allowedgroup'         => 'Nhóm được phép:',
	'createsigndoc-email'                => 'Địa chỉ email:',
	'createsigndoc-address'              => 'Địa chỉ nhà:',
	'createsigndoc-extaddress'           => 'Thành phố, Bang, Quốc gia:',
	'createsigndoc-phone'                => 'Số điện thoại:',
	'createsigndoc-bday'                 => 'Ngày sinh:',
	'createsigndoc-minage'               => 'Tuổi tối thiểu:',
	'createsigndoc-introtext'            => 'Giới thiệu:',
	'createsigndoc-hidden'               => 'Bị ẩn',
	'createsigndoc-optional'             => 'Tùy chọn',
	'createsigndoc-create'               => 'Khởi tạo',
	'createsigndoc-error-generic'        => 'Lỗi: $1',
	'createsigndoc-error-pagenoexist'    => 'Lỗi: Trang [[$1]] không tồn tại.',
	'createsigndoc-success'              => 'Khả năng ký tên đã được kích hoạt tại trang [[$1]].
Để thử nghiệm, xin hãy thăm [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} trang này].',
	'createsigndoc-error-alreadycreated' => 'Văn bản ký tên "$1" đã tồn tại.',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'createsigndoc-pagename'      => 'Pad:',
	'createsigndoc-extaddress'    => 'Zif, Tat, Län:',
	'createsigndoc-error-generic' => 'Pöl: $1',
);

