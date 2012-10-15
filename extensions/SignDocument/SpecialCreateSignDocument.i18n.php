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

'''There is presently no way to delete or modify signature documents after they are created''' without direct database access.
Additionally, the text of the page displayed on the signature page will be the ''current'' text of the page, regardless of changes made to it after today.
Please be absolutely positive that the document is to a point of stability for signing.
Please also be sure that you specify all fields exactly as they should be, ''before submitting this form''.",
	'createsigndoc-pagename'     => 'Page:',
	'createsigndoc-allowedgroup' => 'Allowed group:',
	'createsigndoc-email'        => 'E-mail address:',
	'createsigndoc-address'      => 'Home address:',
	'createsigndoc-extaddress'   => 'City, state, country:',
	'createsigndoc-phone'        => 'Phone number:',
	'createsigndoc-bday'         => 'Birthdate:',
	'createsigndoc-minage'       => 'Minimum age:',
	'createsigndoc-introtext'    => 'Introduction:',
	'createsigndoc-hidden'       => 'Hidden',
	'createsigndoc-optional'     => 'Optional',
	'createsigndoc-create'       => 'Create',
	'createsigndoc-error-generic' => 'Error: $1',
	'createsigndoc-error-pagenoexist' => 'Error: The page [[$1]] does not exist.',
	'createsigndoc-success'      => 'Document signing has been successfully enabled on [[$1]].
You can [{{fullurl:{{#Special:SignDocument}}|doc=$2}} test it].',
	'createsigndoc-error-alreadycreated' => 'Document signing "$1" already exist.
This cannot be done a second time.'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 */
$messages['qqq'] = array(
	'createsigndoc-pagename' => '{{Identical|Page}}',
	'createsigndoc-email' => '{{Identical|E-mail address}}',
	'createsigndoc-phone' => '{{Identical|Phone number}}',
	'createsigndoc-introtext' => '{{Identical|Introduction}}',
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
	'createsigndoc-email' => 'E-posadres:',
	'createsigndoc-phone' => 'Telefoonnommer:',
	'createsigndoc-introtext' => 'Inleiding:',
	'createsigndoc-hidden' => 'Verborge',
	'createsigndoc-optional' => 'Opsioneel',
	'createsigndoc-create' => 'Skep',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'createsigndocument' => 'Aktivizo nënshkrimin dokument',
	'createsigndoc-head' => "Përdorni këtë formular për të krijuar një 'dokument argument' faqe për faqe me kusht, të tilla që shfrytëzuesit do të jenë në gjendje të [[Special:SignDocument|shenjë atë]].
Ju lutem specifikoni emrin e faqe në të cilën ju dëshironi të bërë të mundur nënshkrimin dixhital, anëtarët e të cilit grup duhet të lejohet të nënshkruajnë atë, cilat fusha ju dëshironi që të jetë i dukshëm për përdoruesit e cila duhet të jetë dëshirë, një moshë minimale për të kërkojë përdoruesve të të nënshkruajnë dokumentin (minimale nëse nuk ka lënë jashtë)
dhe një tekst të shkurtër hyrës përshkruar në dokument dhe siguruar udhëzimet për përdoruesit.
'''Nuk ka aktualisht asnjë mënyrë për të fshij apo modifikojë dokumentet e nënshkrimit, pasi ata janë të krijuar''' pa qasje të bazës së të dhënave të drejtpërdrejtë. Përveç kësaj, tekstin e faqes shfaqet në faqen e nënshkrimit do të jetë '''' Tekst i tanishëm e faqe, pa marrë parasysh ndryshimet e bëra në atë pasi sot. Ju lutemi të jetë absolutisht pozitiv se dokumenti është në një pikë të stabilitetit për nënshkrimin. Ju lutemi gjithashtu, të jetë i sigurt që e keni dhënë të gjitha fushat pikërisht si ata duhet të jenë, ''para paraqitjes këtë formë''.",
	'createsigndoc-pagename' => 'Faqe:',
	'createsigndoc-allowedgroup' => 'Grupi i Lejuar:',
	'createsigndoc-email' => 'E-mail adresa:',
	'createsigndoc-address' => 'Adresa:',
	'createsigndoc-extaddress' => 'City, shteti, vendi:',
	'createsigndoc-phone' => 'Numri i telefonit:',
	'createsigndoc-bday' => 'Ditëlindja:',
	'createsigndoc-minage' => 'Mosha minimale:',
	'createsigndoc-introtext' => 'Hyrje:',
	'createsigndoc-hidden' => 'I fshehur',
	'createsigndoc-optional' => 'Fakultativ',
	'createsigndoc-create' => 'Krijo',
	'createsigndoc-error-generic' => 'Gabim: $1',
	'createsigndoc-error-pagenoexist' => 'Gabim: page [[$1]] nuk ekziston.',
	'createsigndoc-success' => 'nënshkrimin e dokumentit ka qenë i aktivizuar me sukses për [[$1]]. Ju mund [{{fullurl:{{#Special:SignDocument}}|doc=$2}} provë atë].',
	'createsigndoc-error-alreadycreated' => 'Dokumenti i nënshkruar "$1" tashmë ekzistojnë. Kjo nuk mund të bëhet një herë të dytë.',
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
 * @author Juanpabl
 * @author Remember the dot
 */
$messages['an'] = array(
	'createsigndoc-pagename' => 'Pachina:',
	'createsigndoc-create' => 'Creyar',
);

/** Old English (Ænglisc)
 * @author Meno25
 */
$messages['ang'] = array(
	'createsigndoc-pagename' => 'Tramet:',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'createsigndocument' => 'فعل توقيع الوثيقة',
	'createsigndoc-head' => "استخدم هذه الاستمارة لإنشاء صفحة 'Sign Document' للصفحة المعطاة، بحيث يمكن للمستخدمين [[Special:SignDocument|توقيعها]].
من فضلك حدد اسم الصفحة التي تود تفعيل التوقيع الرقمي عليها، أعضاء أي مجموعة مستخدم مسموح لهم بتوقيعها، أي حقول تود أن تكون مرئية للمستخدمين وأي يجب أن تكون اختيارية، عمر أدنى لمستخدمين ليمكن لهم توقيع الوثيقة (لا حد أدنى لو حذفت)؛
ونص تقديمي مختصر يصف الوثيقة ويوفر التعليمات للمستخدمين.

'''لا توجد حاليا أية طريقة لحذف أو تعديل توقيعات الوثائق بعد
إنشائها''' بدون دخول قاعدة البيانات مباشرة.
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
	'createsigndoc-create' => 'أنشئ',
	'createsigndoc-error-generic' => 'خطأ: $1',
	'createsigndoc-error-pagenoexist' => 'خطأ: الصفحة [[$1]] غير موجودة.',
	'createsigndoc-success' => 'توقيع الوثيقة تم تفعيله بنجاح في [[$1]].
أنت يمكنك [{{fullurl:{{#Special:SignDocument}}|doc=$2}} اختباره].',
	'createsigndoc-error-alreadycreated' => 'توقيع الوثيقة "$1" موجود بالفعل.
هذا لا يمكن عمله مرة ثانية.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'createsigndoc-pagename' => 'ܦܐܬܐ:',
	'createsigndoc-email' => 'ܦܪܫܓܢܐ ܕܒܝܠܕܪܐ ܐܠܩܛܪܘܢܝܐ:',
	'createsigndoc-address' => 'ܦܪܫܓܢܐ ܕܒܝܬܐ:',
	'createsigndoc-extaddress' => 'ܡܕܝܢܬܐ، ܐܘܚܕܢܐ، ܐܬܪܐ:',
	'createsigndoc-phone' => 'ܡܢܝܢܐ ܕܙܥܘܩܐ:',
	'createsigndoc-bday' => 'ܣܝܩܘܡܐ ܕܡܘܠܕܐ:',
	'createsigndoc-minage' => 'ܡܬܚܐ ܬܚܬܝܐ ܕܥܘܡܪܐ:',
	'createsigndoc-introtext' => 'ܥܘܬܕܐ:',
	'createsigndoc-hidden' => 'ܛܘܫܝܐ',
	'createsigndoc-optional' => 'ܓܒܝܝܐ',
	'createsigndoc-create' => 'ܒܪܝ',
	'createsigndoc-error-generic' => 'ܦܘܕܐ: $1',
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

'''لا توجد حاليا أية طريقة لحذف أو تعديل توقيعات الوثائق بعد
إنشائها''' بدون دخول قاعدة البيانات مباشرة.
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
	'createsigndoc-success' => 'توقيع الوثيقة تم تفعيله بنجاح فى [[$1]].
أنت يمكنك [{{fullurl:{{#Special:SignDocument}}|doc=$2}} اختباره].',
	'createsigndoc-error-alreadycreated' => 'توقيع الوثيقة "$1" موجود بالفعل.
هذا لا يمكن عمله مرة ثانية.',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'createsigndoc-pagename' => 'Səhifə:',
	'createsigndoc-email' => 'E-poçt ünvanı:',
	'createsigndoc-address' => 'Ev ünvanı:',
	'createsigndoc-extaddress' => 'Şəhər, dövlət, ölkə:',
	'createsigndoc-phone' => 'Telefon nömrəsi:',
	'createsigndoc-bday' => 'Doğum tarixi:',
	'createsigndoc-hidden' => 'Gizlədilib',
	'createsigndoc-error-generic' => 'Xəta: $1',
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

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 */
$messages['be-tarask'] = array(
	'createsigndocument' => 'Уключыць падпісаньне дакумэнта',
	'createsigndoc-head' => "Карыстайцеся гэтай формай для стварэньня старонкі 'Падпісаньня дакумэнту', якую ўдзельнікі змогуць [[Special:SignDocument|падпісаць]].
Калі ласка пазначце назву старонкі, на якой трэба ўключыць збор лічбавых подпісаў, удзельнікі якіх групаў змогуць яе падпісваць, якія палі будуць бачныя ўдзельнікам, якія палі неабавязковыя да запаўненьня, мінімальны ўзрост удзельнікаў, якія змогуць падпісаць дакумэнт (па змоўчваньні абмежаваньняў па ўзросьце няма);
а таксама кароткія ўводзіны, якія апісваюць дакумэнт і даюць парады ўдзельнікам.

'''Зараз няма спосабаў выдаленьня ці зьмены падпісаных дакумэнтаў пасьля іх стварэньня''' без непасрэднага доступу да базы зьвестак.
Дадаткова, тэкст старонкі, які адлюстроўваецца на старонцы збору подпісаў будзе ''цяперашнім'' тэкстам старонкі, нягледзячы на зьмены зробленыя пасьля сёньняшняга дня.
Калі ласка упэўніцеся, што дакумэнт поўнасьцю падрыхтаваны да падпісаньня.
Калі ласка, таксама ўпэўніцеся, што Вы вызначылі ўсе палі так як яны павінны быць, ''перад адпраўкай гэтай формы''.",
	'createsigndoc-pagename' => 'Старонка:',
	'createsigndoc-allowedgroup' => 'Дазволеныя групы:',
	'createsigndoc-email' => 'Адрас электроннай пошты:',
	'createsigndoc-address' => 'Дамашні адрас:',
	'createsigndoc-extaddress' => 'Горад, штат, краіна:',
	'createsigndoc-phone' => 'Нумар тэлефону:',
	'createsigndoc-bday' => 'Дата нараджэньня:',
	'createsigndoc-minage' => 'Мінімальны ўзрост:',
	'createsigndoc-introtext' => 'Уводзіны:',
	'createsigndoc-hidden' => 'Схавана',
	'createsigndoc-optional' => 'Неабавязкова',
	'createsigndoc-create' => 'Стварыць',
	'createsigndoc-error-generic' => 'Памылка: $1',
	'createsigndoc-error-pagenoexist' => 'Памылка: Старонка [[$1]] не існуе.',
	'createsigndoc-success' => 'Падпісаньне дакумэнта было пасьпяхова ўключана на старонцы [[$1]].
Вы можаце [{{fullurl:{{#Special:SignDocument}}|doc=$2}} гэта праверыць].',
	'createsigndoc-error-alreadycreated' => 'Падпісаньне дакумэнту «$1» ужо існуе.
Немагчыма зрабіць гэта двойчы.',
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

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'createsigndoc-pagename' => 'পাতা:',
	'createsigndoc-allowedgroup' => 'অনুমতিপ্রাপ্ত দল:',
	'createsigndoc-email' => 'ইমেইল ঠিকানা:',
	'createsigndoc-address' => 'বাসার ঠিকানা:',
	'createsigndoc-extaddress' => 'শহর, প্রদেশ, দেশ:',
	'createsigndoc-phone' => 'ফোন নম্বর:',
	'createsigndoc-bday' => 'জন্ম তারিখ:',
	'createsigndoc-minage' => 'নূন্যতম বয়স:',
	'createsigndoc-introtext' => 'সূচনা:',
	'createsigndoc-hidden' => 'লুকায়িত',
	'createsigndoc-optional' => 'ঐচ্ছিক',
	'createsigndoc-create' => 'তৈরি করুন',
	'createsigndoc-error-generic' => 'ত্রুটি: $1',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 */
$messages['br'] = array(
	'createsigndocument' => 'Gweredekaat ar gwiriañ teulioù',
	'createsigndoc-head' => "Ober gant ar furmskrid-mañ evit krouiñ ur bajenn 'Teul sinañ' evit ar bajenn merket, d'an implijerien da c'hellout [[Special:SignDocument|he sinañ]].
Merkit anv ar bajenn a fell deoc'h gweredekaat ar sinadur niverel eviti, izili ar strollad implijerien a vo aotreet da sinañ, peseurt maeziennoù a c'hallo an implijerien gwelet ha peseurt re a vo diret, an oad bihanañ evit gellout emezelañ er strollad (n'eus ket a oad bihanañ dre ziouer);
hag ur rakskrid a ginnig an teul berr-ha-berr hag a bourchas kuzulioù d'an implijerien.

'''Evit ar mare n'haller ket diverkañ un teul sinañ ur wezh m'eo bet krouet''' nemet dre gemmañ diaz titouroù ar wiki.
A zo muioc'h, an destenn diskwelet war an teul sinañ a vo an destenn \"red\", ne vern ar c'hemmoù a vo degaset enni goude-se.
Se zo kaoz e rankit bezañ peursur eo stabil a-walc'h an teul evit bezañ sinet.
Hag \"a-raok kas ar furmskrid-mañ\", bezit sur eo bet leuniet an holl vaeziennoù tre evel ma oa ret ober.",
	'createsigndoc-pagename' => 'Pajenn :',
	'createsigndoc-allowedgroup' => 'Strollad aotreet :',
	'createsigndoc-email' => "Chomlec'h postel :",
	'createsigndoc-address' => "Chomlec'h post :",
	'createsigndoc-extaddress' => 'Kêr, bro/proviñs/departamant, Stad :',
	'createsigndoc-phone' => 'Niverenn bellgomz',
	'createsigndoc-bday' => 'Deiziad ganedigezh :',
	'createsigndoc-minage' => 'Oad yaouankañ :',
	'createsigndoc-introtext' => 'Digoradur :',
	'createsigndoc-hidden' => 'Kuzhet',
	'createsigndoc-optional' => 'Diret',
	'createsigndoc-create' => 'Krouiñ',
	'createsigndoc-error-generic' => 'Fazi : $1',
	'createsigndoc-error-pagenoexist' => "Fazi : Ar bajenn [[$1]] n'eus ket anezhi.",
	'createsigndoc-success' => 'Gweredekaet eo ar gwiriañ teulioù war [[$1]].
Gallout a rit [{{fullurl:{{#Special:SignDocument}}|doc=$2}} amprouiñ].',
	'createsigndoc-error-alreadycreated' => 'Krouet eo bet an teul gwiriekaat evit "$1" dija.
N\'hall ket bezañ graet un eil gwech.',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'createsigndocument' => 'Omogućuje potpisivanje dokumenata',
	'createsigndoc-head' => "Koristite ovaj obrazac za pravljenje stranice 'Potpis dokumenta' za navedenu stranicu, tako da bi ti korisnici imali mogućnost da ih [[Special:SignDocument|potpišu]].
Molimo navedite naziv stranice na kojoj želite omogućiti digitalni potpis, članove koje korisničke grupe će moći ih potpisivati, koja polja želite da budu vidljiva korisnicima a koja bi bila opcionalna, najmanju starost za obavezno potpisivanje dokumenta od strane korisnika (bez minimuma ako nije navedeno);
i kratki uvodni tekst koji opisuje dokument i daje uputstva korisnicima.

'''Trenutno ne postoji način da se obrišu ili izmijene potpisani dokumenti nakon što su napravljeni''' bez direktnog pristupa bazi podataka.
Dodatno, tekst stranice koji je prikazan na stranici potpisa će biti ''trenutni'' tekst stranice, bez obzira na promjene koje su učinjene nakon današnjeg dana.
Molimo budite potpuno sigurni, da je dokument spreman i stabilan za potpisivanje.
Također budite potpuno sigurni da ste naveli sva polja ispravno kako bi trebalo, ''prije nego pošaljete ovaj obrazac''.",
	'createsigndoc-pagename' => 'Stranica:',
	'createsigndoc-allowedgroup' => 'Dopuštena grupa:',
	'createsigndoc-email' => 'E-mail adresa:',
	'createsigndoc-address' => 'Kućna adresa:',
	'createsigndoc-extaddress' => 'Grad, pokrajina, država:',
	'createsigndoc-phone' => 'Broj telefona:',
	'createsigndoc-bday' => 'Rođendan:',
	'createsigndoc-minage' => 'Najmanja starost:',
	'createsigndoc-introtext' => 'Uvod:',
	'createsigndoc-hidden' => 'Sakriveno',
	'createsigndoc-optional' => 'Opcionalno',
	'createsigndoc-create' => 'Napravi',
	'createsigndoc-error-generic' => 'Greška: $1',
	'createsigndoc-error-pagenoexist' => 'Greška: Stranica [[$1]] ne postoji.',
	'createsigndoc-success' => 'Potpisivanje dokumenata je uspješno omogućeno na [[$1]].
Možete [{{fullurl:{{#Special:SignDocument}}|doc=$2}} ga isprobati].',
	'createsigndoc-error-alreadycreated' => 'Potpisani dokument "$1" već postoji.
Ne možete ga potpisati po drugi put.',
);

/** Catalan (Català)
 * @author Loupeter
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'createsigndoc-pagename' => 'Pàgina:',
	'createsigndoc-email' => 'Correu electrònic:',
	'createsigndoc-address' => 'Adreça:',
	'createsigndoc-extaddress' => 'Ciutat, estat, país:',
	'createsigndoc-phone' => 'Telèfon:',
	'createsigndoc-bday' => 'Data de naixement:',
	'createsigndoc-minage' => 'Edat mínima:',
	'createsigndoc-introtext' => 'Introducció:',
	'createsigndoc-hidden' => 'Amagat',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Error: $1',
	'createsigndoc-error-pagenoexist' => 'Error: La pàgina [[$1]] no existeix.',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'createsigndoc-introtext' => 'Дlадолош:',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'createsigndoc-create' => 'Creà',
);

/** Czech (Česky) */
$messages['cs'] = array(
	'createsigndoc-pagename' => 'Stránka:',
	'createsigndoc-email' => 'E-mailová adresa:',
	'createsigndoc-bday' => 'Datum narození:',
	'createsigndoc-hidden' => 'Skrytý',
	'createsigndoc-optional' => 'Volitelné',
	'createsigndoc-create' => 'Vytvořit',
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
 * @author Kghbln
 * @author Leithian
 * @author Melancholie
 * @author Revolus
 * @author The Evil IP address
 */
$messages['de'] = array(
	'createsigndocument' => 'Dokumentensignieren erlauben',
	'createsigndoc-head' => "Benutze dieses Formular, um ein „Signaturdokument“ für die gegebene Seite zu erstellen, so dass Benutzer in der Lage sein werden, es zu [[Special:SignDocument|signieren]].
Bitte gib den Namen der Seite an, auf welcher du digitales Signieren erlauben willst, welche Benutzergruppen in der Lage sein sollen, sie zu signieren, welche Felder sichtbar sein sollen und welche optional, ein gegebenenfalls minimales Benutzeralter, um das Dokument zu unterzeichnen, und einen kurzen Einleitungstext, der dem Benutzer das Dokument beschreibt und ihm eine kurze Anleitung gibt.

'''Derzeit ist es nicht möglich, einmal gegebene Signaturen zu modifizieren oder zu entfernen''' ohne direkt die Datenbank zu bearbeiten.
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
	'createsigndoc-create' => 'Erstellen',
	'createsigndoc-error-generic' => 'Fehler: $1',
	'createsigndoc-error-pagenoexist' => 'Fehler: Die Seite [[$1]] ist nicht vorhanden.',
	'createsigndoc-success' => 'Das Signieren wurde auf [[$1]] erfolgreich aktiviert.
Du kannst es [{{fullurl:{{#Special:SignDocument}}|doc=$2}} hier ausprobieren].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsignatur „$1“ existiert bereits.
Es kann nicht erneut signiert werden.',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Revolus
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de-formal'] = array(
	'createsigndoc-head' => "Benutzen Sie dieses Formular, um ein „Signaturdokument“ für die gegebene Seite zu erstellen, so dass Benutzer in der Lage sein werden, es zu [[Special:SignDocument|signieren]].
Bitte geben Sie den Namen der Seite an, auf welcher Sie digitales Signieren erlauben wollen, welche Benutzergruppen in der Lage sein sollen, sie zu signieren, welche Felder sichtbar sein sollen und welche optional, ein gegebenenfalls minimales Benutzeralter, um das Dokument zu unterzeichnen, und einen kurzen Einleitungstext, der dem Benutzer das Dokument beschreibt und ihm eine kurze Anleitung gibt.

'''Derzeit ist es nicht möglich, einmal gegebene Signaturen zu modifizieren oder zu entfernen''' ohne direkt die Datenbank zu bearbeiten.
Zusätzlich wird der angezeigte Text beim Signieren der Seite der ''derzeitige'' Text sein, egal welche Änderungen danach noch vorgenommen wurden.
Bitte seien Sie sich absolut sicher, dass das Dokument in einem ausreichend stabilen Zustand zum Signieren ist.
Bitte seien Sie sich ebenfalls sicher, dass Sie alle nötigen Felder angegeben haben, ''bevor Sie dieses Formular übersenden''.",
	'createsigndoc-success' => 'Das Signieren wurde auf [[$1]] erfolgreich aktiviert.
Sie können es [{{fullurl:{{#Special:SignDocument}}|doc=$2}} hier ausprobieren].',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'createsigndocument' => 'Signěrowanje dokumentow zmóžniś',
	'createsigndoc-head' => "Wužyj toś ten formular, aby napórał 'signaturowy dokument' za pódany bok, tak až wužywarje mógu jen [[Special:SignDocument|signěrowaś]].
Pšosym pódaj mě boka, za kótaryž coš digitalne signěrowanje zmóžniś, cłonki kótareje wužywarskeje kupki směju jen signěrowaś, kótare póla maju widobne byś a kótare maju opcionalne byś, minimalne starstwo, kótarež wužywarje deje měś, aby wóne mógu dokument signěrowaś (jolic to se wuwóstaja, minimum njejo) a krotki zawjeźeński tekst, kótaryž wopisujo dokument a dawa wukazanja wužywarjeju.

'''Tuchylu njejo žedna móžnosć signaturowe dokumenty pó jich napóranju wulašowaś abo změniś''' bźez direktnego pśistup k datowej bance.
Pśidatnje buźo tekst boka, kótaryž se zwobraznjujo na signaturowem boku, ''aktualny'' tekst boka, njeglědajucy na změny, kótarež su se na njen pśewjadli pótom.
Pšosym pśeznań se, až dokument jo pśigótowany za signěrowanje.
Pšosym pśeznań se teke, až sy pódał wše póla tak, ako maju byś, ''pjerwjej až wótpósćeloš toś ten formular''.",
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
Móžoš jo [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testowaś].',
	'createsigndoc-error-alreadycreated' => 'Dokumentowa signatura "$1" južo eksistěrujo.
To njedajo se drugi raz cyniś.',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'createsigndoc-pagename' => 'Axa:',
	'createsigndoc-bday' => 'Dzigbe:',
	'createsigndoc-create' => 'Dze egɔme',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'createsigndocument' => 'Ενεργοποίηση υπογραφής εγγράφων',
	'createsigndoc-pagename' => 'Σελίδα:',
	'createsigndoc-allowedgroup' => 'Ομάδα:',
	'createsigndoc-email' => 'Διεύθυνση ηλεκτρονικού ταχυδρομείου:',
	'createsigndoc-address' => 'Διεύθυνση Οικίας:',
	'createsigndoc-extaddress' => 'Πόλη, Περιοχή, Χώρα:',
	'createsigndoc-phone' => 'Τηλεφωνικός αριθμός:',
	'createsigndoc-bday' => 'Ημερομηνία Γέννησης:',
	'createsigndoc-minage' => 'Ελάχιστη ηλικία:',
	'createsigndoc-introtext' => 'Εισαγωγή:',
	'createsigndoc-hidden' => 'Κρυμμένος',
	'createsigndoc-optional' => 'Προαιρετικός',
	'createsigndoc-create' => 'Δημιουργία',
	'createsigndoc-error-generic' => 'Σφάλμα: $1',
	'createsigndoc-error-pagenoexist' => 'Σφάλμα: Η σελίδα [[$1]] δεν υπάρχει.',
);

/** Esperanto (Esperanto)
 * @author Michawiki
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
	'createsigndoc-success' => 'Dokumenta subskribado estas sukcese ebligita ĉe [[$1]].
Vi povas [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testi ĝin].',
	'createsigndoc-error-alreadycreated' => 'Subskribado de dokumento "$1" jam ekzistas.
Tio ne estas dufoje ebla.',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Imre
 */
$messages['es'] = array(
	'createsigndocument' => 'Habilitar firma de documentos',
	'createsigndoc-head' => "Usar este formulario para crear una página 'Firmar documento' para la página proveída, tal que los usuarios podrán [[Special:SignDocument|firmarla]].
Por favor especifica el nombre de la página en el cual deseas habilitar el firmado digital, miembros de cuales grupos deberían estar permitidos de firmala, que campos desearías hacer visibles a los usuarios y cuales deberían ser opcionales, una mínima edad a ser requerida a los usuarios para firmar el documento (sin mínimo si fue omitida);
y un breve texto introductorio que describa el documento y que provea instrucciones a los usuarios.
'''No hay actualmente manera de borrar o modificar la página de firma después de que son creados ''' sin acceso directo a la base de datos.
Adicionalmente, el texto de la página mostrada en la página de firma será el texto ''actual'' de la página, a pesar de los cambios hechos a esta después de hoy.
Por favor ser absolutamente positivo que el documento es a un punto de estabilidad para firmado.
Por favor también asegúrate que especificas todos los campos exactamente como debería ser, ''antes de enviar este formulario''.",
	'createsigndoc-pagename' => 'Página:',
	'createsigndoc-allowedgroup' => 'Grupo permitido:',
	'createsigndoc-email' => 'Dirección de correo electrónico:',
	'createsigndoc-address' => 'Dirección domiciliaria:',
	'createsigndoc-extaddress' => 'Ciudad, estado/región/departamento, país:',
	'createsigndoc-phone' => 'Número de teléfono:',
	'createsigndoc-bday' => 'Fecha de nacimiento:',
	'createsigndoc-minage' => 'Edad mínima:',
	'createsigndoc-introtext' => 'Introducción:',
	'createsigndoc-hidden' => 'Oculto',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Error: $1',
	'createsigndoc-error-pagenoexist' => 'Error: La página [[$1]] no existe.',
	'createsigndoc-success' => 'Firmado de documento ha sido exitosamente habilitado en [[$1]].
Puedes [{{fullurl:{{#Special:SignDocument}}|doc=$2}} probarlo].',
	'createsigndoc-error-alreadycreated' => 'Firmado de documento "$1" ya existe.
Esto puede no ser hecho por segunda vez.',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 */
$messages['eu'] = array(
	'createsigndoc-pagename' => 'Orri:',
	'createsigndoc-allowedgroup' => 'Baimendutako taldea:',
	'createsigndoc-email' => 'E-posta helbidea:',
	'createsigndoc-address' => 'Helbidea:',
	'createsigndoc-extaddress' => 'Udalerria, estatua, herrialdea:',
	'createsigndoc-phone' => 'Telefono zenbakia:',
	'createsigndoc-bday' => 'Jaiotza data:',
	'createsigndoc-minage' => 'Gutxienezko adina:',
	'createsigndoc-introtext' => 'Sarrera:',
	'createsigndoc-hidden' => 'Ezkutaturik',
	'createsigndoc-optional' => 'Hautazkoa',
	'createsigndoc-create' => 'Sortu',
	'createsigndoc-error-generic' => 'Errorea: $1',
	'createsigndoc-error-pagenoexist' => 'Errorea: [[$1]] orrialdea ez da existitzen.',
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
 * @author Crt
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
	'createsigndoc-error-alreadycreated' => 'Asiakirjan allekirjoitus ”$1” on jo olemassa.
Tätä ei voi tehdä toista kertaa.',
);

/** French (Français)
 * @author Crochet.david
 * @author Grondin
 * @author IAlex
 * @author Peter17
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'createsigndocument' => 'Activer l’authentification des documents',
	'createsigndoc-head' => "Utilisez ce formulaire pour créer une page de « document de signature » pour la page indiquée, afin que les utilisateurs soient capables de [[Special:SignDocument|l’authentifier]].
Prière d’indiquer l’intitulé de la page pour laquelle vous souhaitez activer la signature numérique, les membres du groupe d’utilisateurs qui seront habilités à la signer, quels champs vous voulez rendre visibles aux utilisateurs et ceux qui seront optionnels, l’âge minimal pour être membre du groupe (pas de minimum par défaut) ;
et un bref texte d’introduction pour décrire le document et donner des instructions aux utilisateurs.

'''Il n’y a actuellement aucun moyen d’effacer un document de signature une fois celui-ci créé''', sauf en modifiant directement la base de données du wiki.
De plus, le texte de la page affichée sur le document de signature sera son texte ''actuel'', quelles que soient ses modifications faites par la suite.
Pour cette raison, soyez absolument certain que le document soit suffisamment stable pour être signé.
''Avant de soumettre ce formulaire'', vérifiez que vous en avez renseigné tous les champs exactement comme ils devraient l’être.",
	'createsigndoc-pagename' => 'Page :',
	'createsigndoc-allowedgroup' => 'Groupe autorisé :',
	'createsigndoc-email' => 'Adresse électronique :',
	'createsigndoc-address' => 'Adresse résidentielle :',
	'createsigndoc-extaddress' => 'Ville, état (département ou province), pays :',
	'createsigndoc-phone' => 'Numéro de téléphone :',
	'createsigndoc-bday' => 'Date de naissance :',
	'createsigndoc-minage' => 'Âge minimum :',
	'createsigndoc-introtext' => 'Introduction :',
	'createsigndoc-hidden' => 'Masqué',
	'createsigndoc-optional' => 'Optionnel',
	'createsigndoc-create' => 'Créer',
	'createsigndoc-error-generic' => 'Erreur : $1',
	'createsigndoc-error-pagenoexist' => 'La page [[$1]] n’existe pas.',
	'createsigndoc-success' => 'L’authentification des documents est activée sur [[$1]].
Vous pouvez [{{fullurl:{{#Special:SignDocument}}|doc=$2}} le tester].',
	'createsigndoc-error-alreadycreated' => 'Le document d’authentification pour « $1 » a déjà été créé.
Il ne peut l’être une seconde fois.',
);

/** Franco-Provençal (Arpetan)
 * @author Cedric31
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'createsigndocument' => 'Activar la signatura des documents',
	'createsigndoc-pagename' => 'Pâge :',
	'createsigndoc-allowedgroup' => 'Tropa ôtorisâ :',
	'createsigndoc-email' => 'Adrèce èlèctronica :',
	'createsigndoc-address' => 'Adrèce de mêson :',
	'createsigndoc-extaddress' => 'Vela, ètat (dèpartement ou ben province), payis :',
	'createsigndoc-phone' => 'Numerô de tèlèfono :',
	'createsigndoc-bday' => 'Dâta de nèssence :',
	'createsigndoc-minage' => 'Âjo u muens :',
	'createsigndoc-introtext' => 'Entroduccion :',
	'createsigndoc-hidden' => 'Cachiê',
	'createsigndoc-optional' => 'U chouèx',
	'createsigndoc-create' => 'Fâre',
	'createsigndoc-error-generic' => 'Èrror : $1',
	'createsigndoc-error-pagenoexist' => 'Èrror : la pâge [[$1]] ègziste pas.',
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
	'createsigndocument' => 'Habilitar o asinado de documentos',
	'createsigndoc-head' => "Empregue este formulario para crear unha páxina \"Asinar o documento\", de tal xeito que os usuarios [[Special:SignDocument|a poidan asinar]].
Por favor, especifique o nome da páxina na que quere activar a sinatura dixital, os membros de que grupo de usuarios poden asinalo, que campos lles resultan visibles aos usuarios e cales han ser optativos, a idade mínima que se lles esixe aos usuarios para asinar o documento (sen mínimo se se omitise);
e un texto introdutorio breve que describa o documento e lles dea instrucións aos usuarios.

'''Actualmente non resulta posible eliminar ou modificar os documentos de sinatura unha vez que sexan creados''' sen acceso directo á base de datos.
Ademais, o texto da páxina que se mostra na páxina de sinaturas será o texto ''actual'' da páxina, independentemente das modificacións que se lle fagan despois de hoxe.
Asegúrese ben de que o documento está en situación de estabilidade antes de asinalo.
Asegúrese tamén de que especifica todos os campos exactamente como han de ser ''antes de enviar este formulario''.",
	'createsigndoc-pagename' => 'Páxina:',
	'createsigndoc-allowedgroup' => 'Grupo permitido:',
	'createsigndoc-email' => 'Enderezo de correo electrónico:',
	'createsigndoc-address' => 'Enderezo familiar:',
	'createsigndoc-extaddress' => 'Cidade, estado, país:',
	'createsigndoc-phone' => 'Número de teléfono:',
	'createsigndoc-bday' => 'Data de nacemento:',
	'createsigndoc-minage' => 'Idade mínima:',
	'createsigndoc-introtext' => 'Introdución:',
	'createsigndoc-hidden' => 'Agochado',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Erro: $1',
	'createsigndoc-error-pagenoexist' => 'Erro: A páxina "[[$1]]" non existe.',
	'createsigndoc-success' => 'O asinado de documentos foi activado con éxito en [[$1]].
Pode [{{fullurl:{{#Special:SignDocument}}|doc=$2}} probalo].',
	'createsigndoc-error-alreadycreated' => 'O asinado do documento "$1" xa existe.
Isto non se pode facer unha segunda vez.',
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
	'createsigndoc-error-alreadycreated' => 'Τὸ ἐγγράφον τὸ ὑπογράφον τὸ "$1" ἤδη ἐποιήθη.
Μὴ δυνατὴ ἡ ποίησις τοῦδε δίς.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'createsigndocument' => 'Dokumäntesigniere erlaube',
	'createsigndoc-head' => "Verwänd des Formular go ne „Signaturdokumänt“ fir d Seite aalege, ass Benutzer in dr Lag sin, s z [[Special:SignDocument|signiere]].
Bitte gib dr Name vu dr Syte aa, wu Du digital Signiere wit druf erlaube, weli Benutzergruppe in dr Lage solle syy, si z  signiere, weli Fälder sichtbar solle syy un weli optional, imfall e Mindeschtalter go s Dokumänt unterzeichne, un e churzi Yyfierig wu im Benutzer s Dokumänt bschrybt un em e churzi Aaleitig git.

'''Im Momänt isch s nit megli, Signature, wu emol yytrait sin z verändere oder usezneh''' ohni diräkt d Datebank z bearbeite.
Zuesätzli scih dr aazeigt Täxt bim Signiere vu dr Syte dr ''jetzig'' Täxt, egal weli Änderige derno no dra gmacht wäre.
Bitte bii absolut sicher, ass es Dokumänt in eme Zuestand isch, wu längt zum Signiere.
Bitte bii au no sicher, ass Du alli notwändige Fälder aagee hesch, ''voreb Du des Formular abschicksch''.",
	'createsigndoc-pagename' => 'Syte:',
	'createsigndoc-allowedgroup' => 'Erlaubti Gruppe:',
	'createsigndoc-email' => 'E-Mail-Adräss:',
	'createsigndoc-address' => 'Huusaaschrift:',
	'createsigndoc-extaddress' => 'Stadt, Staat, Land:',
	'createsigndoc-phone' => 'Telifonnummere:',
	'createsigndoc-bday' => 'Geburtstag:',
	'createsigndoc-minage' => 'Mindeschtalter:',
	'createsigndoc-introtext' => 'Yyfierig:',
	'createsigndoc-hidden' => 'Versteckt',
	'createsigndoc-optional' => 'Optional',
	'createsigndoc-create' => 'Leg aa',
	'createsigndoc-error-generic' => 'Fähler: $1',
	'createsigndoc-error-pagenoexist' => 'Fähler: D Syte [[$1]] git s nit.',
	'createsigndoc-success' => 'S Signiere isch erfolgryych uf [[$1]] aktiviert wore.
Bsuech bitte [{{fullurl:{{#Special:SignDocument}}|doc=$2}} die Syte] go s uusprobiere.',
	'createsigndoc-error-alreadycreated' => 'Dokumäntsignatur „$1“ git s scho.
Zweimol goht nit.',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'createsigndoc-pagename' => 'Shafi:',
	'createsigndoc-create' => 'Ƙirƙira',
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

'''נכון לעכשיו אין דרך למחוק או לשנות מסמכי חתימות לאחר שהם נוצרו''' ללא גישה ישירה למסד הנתונים.
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
תוכלו [{{fullurl:{{#Special:SignDocument}}|doc=$2}} לנסות אותה].',
	'createsigndoc-error-alreadycreated' => 'חתימת המסמך "$1" כבר קיימת.
לא ניתן לבצע פעולה זו פעמיים.',
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

'''Tuchwilu bjez přistupa k datowej bance žana móžnosć njeje, zo bychu so podpisne dokumenty zničili abo změnili, po tym zo su wutworjene.''' Nimo toho budźe tekst strony, kotryž so na podpisnej stronje zwobraznja, ''aktualny'' tekst strony, njedźiwajo na změny ščinjene pozdźišo. Prošu budźe tebi absolutnje wěsty, zo je tutón dokument za podpisanje stabilny dosć, a zawěsć so tež, zo sy wšě pola takle kaž trjeba wupjelnił, ''prjedy hač tutón formular wotesćele''.",
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
	'createsigndoc-success' => 'Podpisanje dokumentow bu wuspěšnje na [[$1]] zmóžnjene. Móžeš jo [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testować].',
	'createsigndoc-error-alreadycreated' => 'Podpis dokumenta "$1" hižo eksistuje
To njeda so druhi raz činić.',
);

/** Hungarian (Magyar)
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'createsigndocument' => 'Dokumentumok aláírásának engedélyezése',
	'createsigndoc-head' => "Ezzel az űrlappal egy „Dokumentum aláírása” lapot készíthetsz a megadott laphoz, így a felhasználók képesek lesznek [[Special:SignDocument|aláírni azt]].
Kérlek add meg, melyik lapon szeretnéd engedélyezni a digitális aláírást, melyik felhasználói csoport tagjai írhatják alá, mely mezők legyenek láthatóak a felhasználóknak és melyek legyenek opcionálisak, az aláíráshoz szükséges életkort (nem lesz minimális életkor, ha kihagyod); valamint egy rövid bevezetőt, ami leírja a dokumentumot és útmutatást ad a felhasználóknak.

'''Jelenleg semmilyen módon nem lehet törölni vagy módosítani aláírás dokumentumokat elkészültük után''' közvetlen adatbázis-hozzáférés nélkül. Ráadásul az aláírás lapon megjelenített lapszöveg a lap ''aktuális'' tartalma lesz, függetlenül az esetleges későbbi módosításoktól.
Légy abszolút biztos benne, hogy a dokumentum stabil állapotban van az aláíráshoz.
Végül bizonyosodj meg róla, hogy minden mezőt megfelelően kitöltöttél ''még mielőtt elküldöd az űrlapot''.",
	'createsigndoc-pagename' => 'Lap:',
	'createsigndoc-allowedgroup' => 'Engedélyezett csoport:',
	'createsigndoc-email' => 'E-mail cím:',
	'createsigndoc-address' => 'Otthoni cím:',
	'createsigndoc-extaddress' => 'Város, megye, ország:',
	'createsigndoc-phone' => 'Telefonszám:',
	'createsigndoc-bday' => 'Születési dátum:',
	'createsigndoc-minage' => 'Minimális kor:',
	'createsigndoc-introtext' => 'Bevezetés:',
	'createsigndoc-hidden' => 'Rejtett',
	'createsigndoc-optional' => 'Nem kötelező',
	'createsigndoc-create' => 'Létrehozás',
	'createsigndoc-error-generic' => 'Hiba: $1',
	'createsigndoc-error-pagenoexist' => 'Hiba: nincs [[$1]] nevű lap.',
	'createsigndoc-success' => 'A dokumentum aláírása sikeresen engedélyezve itt: [[$1]].
[{{fullurl:{{#Special:SignDocument}}|doc=$2}} Tesztelheted].',
	'createsigndoc-error-alreadycreated' => 'A(z) „$1” dokumentum-aláírás már létezik.
Ezt nem lehet újból megtenni.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'createsigndocument' => 'Activar le signatura de documentos',
	'createsigndoc-head' => "Usa iste formulario pro crear un pagina 'Signar documento' pro le pagina fornite, de modo que le usatores potera [[Special:SignDocument|signar lo]].
Per favor specifica le nomine del pagina in le qual tu vole activar le signatura digital, le gruppo cuje membros debe poter signar le pagina, qual campos tu vole render visibile al usatores e quales debe esser optional, un etate minime que le usatores debe haber pro poter signar le documento (nulle minimo si omittite);
e un breve texto introductori describente le documento e forniente instructiones al usatores.

'''Al presente non existe un modo de deler o modificar le documentos de signatura post lor creation''' sin accesso directe al base de datos.
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
Tu pote [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testar lo].',
	'createsigndoc-error-alreadycreated' => 'Le signatura del documento "$1" es ja active.
Isto non pote esser facite un secunde vice.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 */
$messages['id'] = array(
	'createsigndocument' => 'Aktifkan penandatanganan dokumen',
	'createsigndoc-head' => "Gunakan formulir ini untuk membuat suatu 'Dokumen tanda tangan' untuk halaman yang diberikan, sehingga pengguna akan dapat [[Special:SignDocument|menandatanganinya]].
Silakan tentukan nama halaman yang ingin Anda aktifkan penandatanganan digitalnya, anggota yang kelompok penggunanya diperbolehkan untuk menandatanganinya, isian-isian mana yang ingin Anda perlihatkan ke pengguna dan mana yang bersifat opsional, usia minimum untuk mengharuskan pengguna untuk menandatangani dokumen (tidak ada minimum jika diabaikan);
serta teks pengantar singkat yang menjelaskan dokumen dan memberikan instruksi kepada pengguna.

'''Saat ini tidak ada cara untuk menghapus atau mengubah dokumen tanda tangan setelah dibuat''' tanpa akses langsung ke basis data.
Tambahan, teks halaman yang ditampilkan pada halaman tanda tangan akan menjadi teks ''terkini'' halaman, tanpa mempedulikan perubahan yang dibuat setelah ini.
Harap pastikan bahwa dokumen ini sudah cukup stabil untuk ditandatangani.
Harap pastikan juga bahwa Anda menentukan semua isian persis seperti yang seharusnya ''sebelum menyimpan formulir ini''.",
	'createsigndoc-pagename' => 'Halaman:',
	'createsigndoc-allowedgroup' => 'Grup yang diizinkan:',
	'createsigndoc-email' => 'Alamat surel:',
	'createsigndoc-address' => 'Alamat rumah:',
	'createsigndoc-extaddress' => 'Kota, negara bagian, negara:',
	'createsigndoc-phone' => 'Nomor telepon:',
	'createsigndoc-bday' => 'Tanggal lahir:',
	'createsigndoc-minage' => 'Umur minimum:',
	'createsigndoc-introtext' => 'Pendahuluan:',
	'createsigndoc-hidden' => 'Tersembunyi',
	'createsigndoc-optional' => 'Opsional',
	'createsigndoc-create' => 'Buat',
	'createsigndoc-error-generic' => 'Kesalahan: $1',
	'createsigndoc-error-pagenoexist' => 'Kesalahan: Halaman [[$1]] tidak ada.',
	'createsigndoc-success' => 'Penandatanganan dokumen telah berhasil diaktifkan pada [[$1]].
Anda dapat [{{fullurl:{{#Special:SignDocument}}|doc=$2}} mengujinya].',
	'createsigndoc-error-alreadycreated' => 'Penandatangan "$1" telah ada.
Hal ini tidak dapat dilakukan dua kali.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'createsigndoc-pagename' => 'Ihü:',
	'createsigndoc-phone' => 'Onuogụgụ nkpo go:',
	'createsigndoc-bday' => 'Ogẹ òmúmú:',
	'createsigndoc-introtext' => 'Ndubata:',
	'createsigndoc-hidden' => 'Zonarịrị',
	'createsigndoc-optional' => 'I cho, ka I chogị',
	'createsigndoc-create' => 'Ké',
	'createsigndoc-error-generic' => 'Nsogbu: $1',
	'createsigndoc-error-pagenoexist' => 'Nsogbu: Ihü [[$1]] a digì.',
);

/** Icelandic (Íslenska) */
$messages['is'] = array(
	'createsigndoc-pagename' => 'Síða:',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'createsigndoc-pagename' => 'Pagina:',
	'createsigndoc-email' => 'Indirizzo e-mail:',
	'createsigndoc-bday' => 'Data di nascita:',
	'createsigndoc-minage' => 'Anzianità minima:',
	'createsigndoc-introtext' => 'Introduzione:',
	'createsigndoc-hidden' => 'Nascosto',
	'createsigndoc-optional' => 'Opzionale',
	'createsigndoc-create' => 'Crea',
	'createsigndoc-error-generic' => 'Errore: $1',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Whym
 */
$messages['ja'] = array(
	'createsigndocument' => '文書署名の有効化',
	'createsigndoc-head' => "このフォームを使って、指定したページに「{{int:Signdocument}}」ページを作成し、利用者が[[Special:SignDocument|署名]]できるようにします。デジタル署名を有効にしたいページの名前と、どの利用者グループに属す者が署名できるのか、どの欄を利用者に表示しどの欄を任意とするのか、文書に署名するのに必要な最低の年齢(既定では年齢制限なし)、さらに文書を解説し手順を説明する手短な序文、を指定してください。

'''現時点では、署名文書を作成した後にそれを削除もしくは改変するための手段は提供していません。'''データベースに直接アクセスするのが唯一の手段です。くわえて、署名ページに表示される該当ページの内容はそのページの''現時点''の内容であり、現時点以降になされた変更は反映されません。その文書が署名にふさわしい安定度に達していると、絶対の確信をもってから行ってください。また、''このフォームの送信前に''、すべての欄の内容が完全に正確であることを確認してください。",
	'createsigndoc-pagename' => 'ページ:',
	'createsigndoc-allowedgroup' => '許可するグループ:',
	'createsigndoc-email' => '電子メールアドレス:',
	'createsigndoc-address' => '自宅の住所:',
	'createsigndoc-extaddress' => '国・都道府県・市町村:',
	'createsigndoc-phone' => '電話番号:',
	'createsigndoc-bday' => '誕生日:',
	'createsigndoc-minage' => '最低年齢:',
	'createsigndoc-introtext' => '序文:',
	'createsigndoc-hidden' => '非表示',
	'createsigndoc-optional' => '省略可能',
	'createsigndoc-create' => '作成',
	'createsigndoc-error-generic' => 'エラー: $1',
	'createsigndoc-error-pagenoexist' => 'エラー: ページ [[$1]] は存在しません。',
	'createsigndoc-success' => '[[$1]] での文書署名の有効化に成功しました。[{{fullurl:{{#Special:SignDocument}}|doc=$2}} 試してみる]ことができます。',
	'createsigndoc-error-alreadycreated' => '「$1」の文書署名はすでに作成されています。二度は不可能です。',
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

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'createsigndoc-introtext' => 'ಪರಿಚಯ:',
	'createsigndoc-optional' => 'ಐಚ್ಛಿಕ',
);

/** Korean (한국어)
 * @author Klutzy
 * @author ToePeu
 */
$messages['ko'] = array(
	'createsigndoc-create' => '생성',
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

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'createsigndocument' => 'Et Dokkemänte Ungerschriive zohlohße',
	'createsigndoc-head' => "Met dämm Fommulaa hee, kanns De en Söndersigg ennreschte, för de aanjejovve Sigg [[Special:SignDocument|ungerschriive]] ze lohße.
Dodoför weed och ene Ungerschreffte-Mapp för die Sigg aanjelaat.
Jiff dä Tittel fun dä Sigg aan, woh De et dijjitaale Ungerschriive zohlohße wells. Dozoh, de Metjleeder fun wat för ene Metmaacherjrupp ungerschriive dörrve sulle. Dann, wat för en Felder för de Metmaachere bejm Ungerschriive zom Ußfölle ze sin sin sulle, un wat dofun ußjeföllt wääde kann, un wat moß. Dann, wi alt Eine beim Ungerschriive winnischßdens sin moß. Wann De doh nix aanjiß, dann eß jedes Allder rääsch. Zoletz jiff ene koote Tex en, met Äklieronge dren övver dat Dokkemänt, un för de Metmaachere, wat se donn sulle, un wie.

'''För der Momang ham_mer kein Müjjeleshkeit, aan de Ungerschreffte jet ze änndere, wann se ens do sinn''', oohne ne tirekte Zohjang op de Dahtebangk.
Ußerdämm, dä Täx zom Ungerschriive, dä och met dä Ongerschreffte zosamme jezeish weedt, es immer dä Täx fun jätz, jans ejaal, wat donoh noch för Änderunge aan dä Sigg jemaat wäde odder woodte. Dröm beß jannz secher, dat dat Dokkemänt en dä Sigg en enem shtabiile Zohshtand, un verhafesch parraat för et Ungeschriive eß.
Beß och sescher, dat De all die Felder jenou esu aanjejovve häs, wi se sin sulle, ih dat De dat Fommulaa hee affschecks.",
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
	'createsigndoc-success' => 'Et Dokkemänt „[[$1]]“ ze ungerschriive eß jetz müjjelesch, en Ungerschreffte-Mapp es aanjelaat.
Mer kann jetz dat [{{fullurl:{{#Special:SignDocument}}|doc=$2}} Ungerschriive och ußprobbiere].',
	'createsigndoc-error-alreadycreated' => 'De Ongerschreffte-Mapp för de Sigg „$1“ es ald aanjelaat.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'createsigndoc-pagename' => 'Rûpel:',
	'createsigndoc-extaddress' => 'Bajarr, dewlet, welat:',
	'createsigndoc-bday' => 'Jidayîkbûn:',
);

/** Cornish (Kernowek)
 * @author Kernoweger
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'createsigndoc-introtext' => 'Raglavar:',
);

/** Latin (Latina)
 * @author Omnipaedista
 * @author SPQRobin
 */
$messages['la'] = array(
	'createsigndoc-pagename' => 'Pagina:',
	'createsigndoc-create' => 'Creare',
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
	'createsigndoc-address' => 'Wunnadress:',
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
	'createsigndoc-success' => "D'Ënnerschreiwe vun Dokumenter ass op [[$1]] aktivéiert.
Dir kënnt [{{fullurl:{{#Special:SignDocument}}|doc=$2}} et testen].",
	'createsigndoc-error-alreadycreated' => 'Dokument ënnerschreiwen "$1" gëtt et schonn.
Dir kënnt et keng zweete Kéier maachen.',
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

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'createsigndocument' => 'Овозможи потпишување документи',
	'createsigndoc-head' => "Употребувајте го овој образец за да создадете страница „Потпиши документ“ за наведената страница, така што корисниците ќе можат [[Special:SignDocument|да го потпишуваат]].
Назначете го името на страницата на која сакате да овозможите дигитално потпишување, членовите од која група ќе можат да се потпишуваат, кои полиња сакате да бидат видливи за корисниците и кои треба да бидат незадолжителни, минимална возраст на корисникот за да може да се потпише (ако не се наведе, тогаш ќе нема старосна граница);
и краток воведен текст кој го опшишува документот и им дава напатствија на корисниците.

'''Моментално не постои начин да се избришат или менуваат потпишани документи откако ќе се создадат''' без директен пристап кон базата на податоци.
Покрај ова, текстот на прикажаната страница кај потписот ќе биде ''тековниот'' текст на страницата, без разлика на тоа дали се вршени промени по денешниот ден.
Уверете се дека сте апсолутно сигурни дека документот е на таков степен на стабилност што може да се потпипше.
Исто така проверете дали сте ги назначиле сите полиња токму како што треба да стојат, ''пред да го испратите овој образец''.",
	'createsigndoc-pagename' => 'Страница:',
	'createsigndoc-allowedgroup' => 'Дозволена група:',
	'createsigndoc-email' => 'Е-пошта:',
	'createsigndoc-address' => 'Домашна адреса:',
	'createsigndoc-extaddress' => 'Град, сојузна држава, земја:',
	'createsigndoc-phone' => 'Телефонски број:',
	'createsigndoc-bday' => 'Датум на раѓање:',
	'createsigndoc-minage' => 'Минимална возраст:',
	'createsigndoc-introtext' => 'Вовед:',
	'createsigndoc-hidden' => 'Скриено',
	'createsigndoc-optional' => 'Незадолжително',
	'createsigndoc-create' => 'Создај',
	'createsigndoc-error-generic' => 'Грешка: $1',
	'createsigndoc-error-pagenoexist' => 'Грешка: Страницата [[$1]] не постои.',
	'createsigndoc-success' => 'Потпишувањето документи е успешно овозможено на [[$1]].
Можете да [{{fullurl:{{#Special:SignDocument}}|doc=$2}} го испробате].',
	'createsigndoc-error-alreadycreated' => 'Потпишувањето за „$1“ веќе постои.
Ова не може да се направи по втор пат.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'createsigndoc-pagename' => 'താൾ:',
	'createsigndoc-allowedgroup' => 'അനുവദനീയമായ സംഘം:',
	'createsigndoc-email' => 'ഇമെയിൽ വിലാസം:',
	'createsigndoc-address' => 'വീടിന്റെ വിലാസം:',
	'createsigndoc-extaddress' => 'നഗരം. സംസ്ഥാനം, രാജ്യം:',
	'createsigndoc-phone' => 'ഫോൺ നമ്പർ:',
	'createsigndoc-bday' => 'ജനന തീയതി:',
	'createsigndoc-minage' => 'കുറഞ്ഞ പ്രായം:',
	'createsigndoc-introtext' => 'പ്രാരംഭം:',
	'createsigndoc-hidden' => 'മറഞ്ഞിരിക്കുന്നത്',
	'createsigndoc-optional' => 'നിർബന്ധമില്ല',
	'createsigndoc-create' => 'താൾ സൃഷ്ടിക്കുക',
	'createsigndoc-error-generic' => 'പിഴവ്: $1',
	'createsigndoc-error-pagenoexist' => 'പിഴവ്: [[$1]] എന്ന താൾ നിലവിലില്ല.',
	'createsigndoc-success' => '[[$1]] പ്രമാണഒപ്പിടൽ വിജയകരമായി പ്രവർത്തനസജ്ജമാക്കിയിരിക്കുന്നു. അതു പരീക്ഷിക്കുവാൻ ദയവായി [{{fullurl:{{#Special:SignDocument}}|doc=$2}} ഈ താൾ] സന്ദർശിക്കുക.',
	'createsigndoc-error-alreadycreated' => 'പ്രമാണ ഒപ്പിടൽ "$1" നിലവിലുണ്ട്.',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'createsigndoc-pagename' => 'Хуудас:',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'createsigndocument' => 'डॉक्यूमेंटवर सही करणे सुरू करा',
	'createsigndoc-head' => "दिलेल्या पानासाठी एक 'डॉक्यूमेंटवर सही करा' पृष्ठ तयार करण्यासाठी या अर्जाचा वापर करा, ज्यामुळे सदस्यांना [[Special:SignDocument]] वापरून त्या पानावर सही करता येईल.
कॄपया ज्या पानावर सही करणे सुरू करायचे ते पान निवडा, तसेच कुठल्या सदस्यगटांना या पानावर सही करू द्यायची ते ठरवा, कुठले रकाने सदस्यांना दिसले पाहिजेत तसेच कुठले रकाने वैकल्पिक ठेवायचे ते ठरवा, त्यानंतर कमीतकमी वयाची अट द्या (जर रिकामे ठेवले तर वयाची अट नाही); तसेच एक छोटीशी डॉक्यूमेंटची ओळख तसेच सदस्यांना सूचना द्या.

'''सध्या सही साठी डॉक्यूमेंट तयार झाल्यानंतर त्याला वगळण्याची कुठलिही सुविधा उपलब्ध नाही.''' फक्त थेट डाटाबेसशी संपर्क करता येईल.
तसेच, तसेच सही साठी उपलब्ध पानावर '''सध्याचा''' मजकूर दाखविला जाईल, जरी तो आज नंतर बदलला तरीही.
कृपया हे डॉक्यूमेंट सही साठी उपलब्ध करण्यासाठी योग्य असल्याची खात्री करा, तसेच ''हा अर्ज पाठविण्यापूर्वी'' तुम्ही सर्व रकाने योग्य प्रकारे भरलेले आहेत, याची खात्री करा.",
	'createsigndoc-pagename' => 'पान',
	'createsigndoc-allowedgroup' => 'अधिकृत सदस्य गट:',
	'createsigndoc-email' => 'विपत्र पत्ता:',
	'createsigndoc-address' => 'घरचा पत्ता:',
	'createsigndoc-extaddress' => 'शहर, राज्य, देश:',
	'createsigndoc-phone' => 'दूरध्वनी क्रमांक',
	'createsigndoc-bday' => 'जन्मदिवस',
	'createsigndoc-minage' => 'कमीतकमी वय:',
	'createsigndoc-introtext' => 'ओळख:',
	'createsigndoc-hidden' => 'लपविलेले',
	'createsigndoc-optional' => 'पर्यायी',
	'createsigndoc-create' => 'निर्माण करा',
	'createsigndoc-error-generic' => 'त्रुटी: $1',
	'createsigndoc-error-pagenoexist' => 'त्रुटी: पान [[$1]] अस्तित्त्वात नाही.',
	'createsigndoc-success' => '[[$1]] वर आता सही करता येऊ शकेल.
तपासण्यासाठी, [{{fullurl:{{#Special:SignDocument}}|doc=$2}} या पानाला] भेट द्या.',
	'createsigndoc-error-alreadycreated' => 'दस्तऐवज सही "$1" अगोदरच अस्तित्त्वात आहे.
ती दुसर्‍यांदा होत नाही.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'createsigndoc-pagename' => 'Laman:',
	'createsigndoc-email' => 'Alamat e-mel:',
	'createsigndoc-create' => 'Cipta',
);

/** Mirandese (Mirandés)
 * @author Malafaya
 */
$messages['mwl'] = array(
	'createsigndoc-pagename' => 'Páigina:',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'createsigndocument' => 'Slå på dokumentsignering',
	'createsigndoc-head' => "Bruk dette skjemaet for å opprette et «signaturdokument» for denne siden, slik at brukere kan [[Special:SignDocument|signere den]]. Vennligst oppgi sidens navn, hvilken brukergruppe som skal kunne signere den, hvilke felter som skal være synlige for brukerne, hvilke som skal være valgfrie, minimumsalder for å kunne signere dokumentet (om denne ikke oppgis, er det ingen grense), og en kjapp introduksjonstekst som beskriver dokumentet og gir instruksjoner til brukerne.

'''Det er ingen måte å slette eller endre signaturdokumenter etter at de opprettes''' uten direkte databasetilgang. Teksten på siden på signatursiden vil også være den ''nåværende'' teksten, uavhengig av hvilke endringer som gjøres etter i dag. Vær hundre prosent sikker på at dokumentet er stabilt når det signeres, og vær også sikker på at du oppgir alle felt som de burde være, ''før du lagrer dette skjemaet''.",
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
	'createsigndoc-success' => 'Dokumentsignering har blitt slått på for [[$1]].
Du kan [{{fullurl:{{#Special:SignDocument}}|doc=$2}} teste det].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringen «$1» finnes allerede.
Dette kan ikke gjøres to ganger.',
);

/** Dutch (Nederlands)
 * @author Siebrand
 * @author Tvdm
 */
$messages['nl'] = array(
	'createsigndocument' => 'Documentondertekening inschakelen',
	'createsigndoc-head' => "Gebruik dit formulier om een pagina 'Document ondertekenen' voor een gegeven pagina te maken, zodat gebruikers het kunnen [[Special:SignDocument|ondertekenen]].
Geef alstublieft op voor welke pagina u digitaal ondertekenen wilt inschakelen, welke gebruikersgroepen kunnen ondertekenen, welke velden zichtbaar moeten zijn voor gebruikers en welke optioneel zijn, een minimale leeftijd waaraan gebruikers moeten voldoen alvorens te kunnen ondertekenen (geen beperkingen als leeg gelaten);
en een korte inleidende tekst over het document en instructies voor de gebruikers.

'''Er is op het moment geen mogelijkheid om te ondertekenen documenten te verwijderen of te wijzigen nadat ze zijn aangemaakt''' zonder directe toegang tot de database.
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
	'createsigndoc-success' => 'Documentondertekening is ingeschakeld op [[$1]].
U kunt [{{fullurl:{{#Special:SignDocument}}|doc=$2}} dit testen].',
	'createsigndoc-error-alreadycreated' => 'De documentondertekening "$1" bestaat al.
Deze kan geen tweede keer aangemaakt worden.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'createsigndocument' => 'Slå på dokumentsignering',
	'createsigndoc-head' => "Nytt dette skjemaet for å oppretta eit «signaturdokument» for denne sida, slik at brukarar kan [[Special:SignDocument|signera ho]]. Oppgje namnet på sida, kva brukargruppa som skal kunna signera ho, kva felt som skal vera synlege for brukarane, kven av dei som skal vera valfrie, minimumsalderen for å kunna signera dokumentet (om denne ikkje blir oppgjeven, er det inga grensa), og ein kjapp introduksjonstekst som skildrar dokumentet og gjev instruksjonar til brukarane.

'''Det finst ingen måte å sletta eller endra signaturdokument på etter at dei er oppretta''' utan direkte databasetilgjenge. Teksten på sida på signatursida vil òg vera den ''noverande'' teksten, uavhengig av kva endringar som blir gjort etter i dag. Ver hundre prosent sikker på at dokumentet er stabilt når det blir signert, og ver òg sikker på at du oppgjev alle felt som dei burde vera, ''før du lagrar dette skjemaet''.",
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
Du kan [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testa det].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringa «$1» finst frå før. Dette kan ikkje bli gjort to gonger.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'createsigndocument' => "Activar l'autentificacion dels documents",
	'createsigndoc-head' => "Utilizatz aqueste formulari per crear una pagina d'autentificacion de documents per l'article en question, de biais que cada utilizaire serà capable d'autentificar via [[Special:SignDocument|Signit]].
Mercés d'indicar lo nom de l'article pel qual desiratz activar la foncion, los membres del grop d'utilizaires, quins camps seràn accessibles als utilizaires (seràn opcionals), l'edat minimala per èsser membre del grop (pas de minimom siquenon) e un document brèu explicant lo document e balhant d'instruccions als utilizaires.

'''Actualament, i a pas cap de mejan d'escafar los documents un còp creats''', al despart en editant la banca de donadas del wiki. E mai, lo tèxte de l'article afichat sus la pagina autentificada serà lo tèxte ''corrent'', pauc impòrta las modificacions fachas de per aprèp. Per aquesta rason, siatz segur que lo document es sufisentament estable per èsser autentificat e, ''abans de sometre lo formulari'', verificatz qu'avètz plan causit los camps tals coma desiratz que sián.",
	'createsigndoc-pagename' => 'Pagina :',
	'createsigndoc-allowedgroup' => 'Grop autorizat :',
	'createsigndoc-email' => 'Adreça de corrièr electronic :',
	'createsigndoc-address' => 'Adreça residenciala :',
	'createsigndoc-extaddress' => 'Vila, estat (departament o província), país :',
	'createsigndoc-phone' => 'Numèro de telefòn :',
	'createsigndoc-bday' => 'Data de naissença :',
	'createsigndoc-minage' => 'Edat minimoma :',
	'createsigndoc-introtext' => 'Introduccion :',
	'createsigndoc-hidden' => 'Amagat',
	'createsigndoc-optional' => 'Opcional',
	'createsigndoc-create' => 'Crear',
	'createsigndoc-error-generic' => 'Error : $1',
	'createsigndoc-error-pagenoexist' => 'La pagina [[$1]] existís pas.',
	'createsigndoc-success' => "L'autentificacion dels documents es activada sus [[$1]].
La podètz [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testar].",
	'createsigndoc-error-alreadycreated' => 'Lo document d’autentificacion per « $1 » ja es estat creat.
O pòt pas èsser un segond còp.',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'createsigndoc-pagename' => 'Фарс:',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'createsigndoc-pagename' => 'Blatt:',
	'createsigndoc-create' => 'Schtaerte',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Maikking
 * @author Sp5uhe
 * @author ToSter
 */
$messages['pl'] = array(
	'createsigndocument' => 'Włącz podpisywanie dokumentów',
	'createsigndoc-head' => "Formularz służy do tworzenia dokumentu, który użytkownicy będą mogli [[Special:SignDocument|podpisać]].
Podaj nazwę strony na której chcesz włączyć podpisy elektroniczne, grupę której członkowie będą upoważnieni do podpisywania, które pola mają być widoczne, a które są opcjonalne, wymagany minimalny wiek użytkownika uprawniający do podpisywania dokumentu (brak ograniczenia jeśli pominięte),
a także krótki tekst wprowadzający opisujący dokument oraz zawierający instrukcję dla użytkowników.

'''Brak jest możliwości usunięcia lub zmiany podpisanych dokumentów po ich utworzeniu''' bez bezpośredniego dostępu do bazy danych.
Na podpisywanej stronie wyświetlany będzie zawsze ''obecny'' tekst strony, bez względu na zmiany wprowadzone do niej później.
Należy się upewnić, że dokument jest w pełni gotowy do podpisywania.
''Przed zapisaniem tego formularza'' należy również upewnić się, że wszystkie pola zostały określone, tak jak powinny.",
	'createsigndoc-pagename' => 'Strona:',
	'createsigndoc-allowedgroup' => 'Dozwolone grupy:',
	'createsigndoc-email' => 'Adres e‐mail:',
	'createsigndoc-address' => 'Adres domowy',
	'createsigndoc-extaddress' => 'Miejscowość, kraj',
	'createsigndoc-phone' => 'Numer telefonu:',
	'createsigndoc-bday' => 'Data urodzenia:',
	'createsigndoc-minage' => 'Minimalny wiek',
	'createsigndoc-introtext' => 'Wstęp:',
	'createsigndoc-hidden' => 'Ukryte',
	'createsigndoc-optional' => 'Nieobowiązkowe',
	'createsigndoc-create' => 'Utwórz',
	'createsigndoc-error-generic' => 'Błąd: $1',
	'createsigndoc-error-pagenoexist' => 'Błąd: Strona [[$1]] nie istnieje',
	'createsigndoc-success' => 'Mechanizm podpisywania dokumentów został włączony na  [[$1]].
Możesz [{{fullurl:{{#Special:SignDocument}}|doc=$2}} go przetestować].',
	'createsigndoc-error-alreadycreated' => 'Dokument „$1” został już podpisany.
Nie można go podpisać dwukrotnie.',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
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
#'''Për adess a-i é gnun-a manera dë scancelé ò modifiché ij document ch'as mando an firma, na vira ch'a sio stait creà''' sensa dovej travajé ant sla base dat da fòra.
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
	'createsigndoc-success' => "La procedura për buté an firma [[$1]] a l'é andaita a bonfin. 
Për provela, për piasì ch'a [{{fullurl:{{#Special:SignDocument}}|doc=$2}} la preuva].",
	'createsigndoc-error-alreadycreated' => 'La firma dël document "$1" a esist già.
Sòn sì a peul pa esse fàit na sconda vira.',
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
	'createsigndoc-introtext' => 'پېژندنه:',
	'createsigndoc-hidden' => 'پټ',
	'createsigndoc-create' => 'جوړول',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'createsigndocument' => 'Activar a assinatura de documentos',
	'createsigndoc-head' => "Use este formulário para criar uma página \"Assinar o documento\" para a página relacionada, de forma a que os utilizadores [[Special:SignDocument|o possam assinar]].
Por favor, especifique o nome da página na qual quer activar a assinatura digital, o grupo de utilizadores cujos membros podem assiná-lo, quais os campos que quer que sejam visíveis para os utilizadores e quais deverão ser opcionais, a idade mínima a exigir dos utilizadores para poderem assinar o documento (sem mínimo, se omitido);
e um breve texto introdutório que descreva o documento e forneça instruções aos utilizadores.

<b>Actualmente não há forma de eliminar ou modificar os documentos de assinatura depois de serem criados</b> sem acesso directo à base de dados. Além disso, o texto da página apresentado na página de assinaturas será o texto ''actual'' da página, independentemente das alterações que lhe sejam feitas a partir de hoje.
Por favor, certifique-se com o máximo rigor de que o documento está numa situação de estabilidade antes de assiná-lo.
Assegure-se também de que especificou todos os campos exactamente como devem ser, ''antes de enviar este formulário''.",
	'createsigndoc-pagename' => 'Página:',
	'createsigndoc-allowedgroup' => 'Grupo autorizado:',
	'createsigndoc-email' => 'Correio electrónico:',
	'createsigndoc-address' => 'Endereço da residência:',
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
	'createsigndoc-success' => 'A assinatura de documentos foi activada com sucesso em [[$1]].
Pode agora [{{SERVER}}{{localurl: Special:SignDocument|doc=$2}} testá-la].',
	'createsigndoc-error-alreadycreated' => 'A assinatura de documentos "$1" já existe.
Isto não pode ser feito segunda vez.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'createsigndocument' => 'Ativar a assinatura de documentos',
	'createsigndoc-head' => "Use este formulário para criar uma página \"Assinar o documento\" para a página relacionada, de forma a que os utilizadores [[Special:SignDocument|possam assiná-lo]].
Por favor, especifique o nome da página na qual quer ativar a assinatura digital, o grupo de utilizadores cujos membros podem assiná-lo, quais os campos que quer que estejam visíveis aos utilizadores e quais deverão ser opcionais, a idade mínima a exigir dos utilizadores para poderem assinar o documento (sem mínimo se omitido);
e um breve texto introdutório que descreva o documento e forneça instruções aos utilizadores.
'''Atualmente não há forma de eliminar ou modificar os documentos de assinatura depois de serem criados''' sem acesso direto à base de dados. Além disso, o texto da página apresentado na página de assinaturas será o texto ''atual'' da página, independentemente das alterações que sejam feitas a ela a partir de hoje.
Por favor, certifique-se com o máximo rigor de que o documento está numa situação de estabilidade antes de assiná-lo.
Assegure-se também de que especificou todos os campos exatamente como devem ser, ''antes de enviar este formulário''.",
	'createsigndoc-pagename' => 'Página:',
	'createsigndoc-allowedgroup' => 'Grupo autorizado:',
	'createsigndoc-email' => 'Endereço de e-mail:',
	'createsigndoc-address' => 'Endereço residencial:',
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
Você pode agora [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testá-la].',
	'createsigndoc-error-alreadycreated' => 'A assinatura do documento "$1" já existe.
Isto não pode ser feito pela segunda vez.',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'createsigndoc-pagename' => 'Pagină:',
	'createsigndoc-email' => 'Adresă e-mail:',
	'createsigndoc-address' => 'Adresă domiciliu:',
	'createsigndoc-extaddress' => 'Oraș, stat, țară:',
	'createsigndoc-phone' => 'Număr de telefon:',
	'createsigndoc-bday' => 'Zi de naștere:',
	'createsigndoc-minage' => 'Vârstă minimă:',
	'createsigndoc-introtext' => 'Introducere:',
	'createsigndoc-hidden' => 'Ascunse',
	'createsigndoc-optional' => 'Opțional',
	'createsigndoc-create' => 'Creează',
	'createsigndoc-error-generic' => 'Eroare: $1',
	'createsigndoc-error-pagenoexist' => 'Eroare: Pagina [[$1]] nu există.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'createsigndocument' => "Abbilite le firme sus a 'u documende",
	'createsigndoc-head' => "Ause sta schermate pe ccrejà 'na vôsce de 'Documende Firmate' pa pàgene, cumme a certe utinde ca 'u ponne [[Special:SignDocument|firmà]].
Pe piacere specifiche 'u nome d'a vôsce sus a quale tu vuè ccu abbilitesce 'a firma diggitale, le membre de quale gruppe utinde avessere avè 'u permesse pe firmà, cè cambe tu vuè face vedè a l'utinde e quale avessere a essere facoltative, l'età minime da cercà a l'utinde pe farle firmà 'nu documende (ce non ge mitte ninde non ge serve l'età); e 'n'indroduziona piccenne ca descrive 'u documente e dè le istruziune a l'utinde.

'''Non ge stè nisciune mode pe luvà o cangià 'a firme de le documinde apprisse ca onne state ccrejate''' senza 'n'accesse dirette a 'u database.
In aggiunde, 'u teste d'a pàgene visualizzate sus a pàgene de firme addevènde 'u teste ''corrende'' d'a pàgene, senze scè penzanne a le cangiaminde fatte apprisse a osce.
Pe piacere vide ce sì secure secure ca 'u documende jè 'nu punde de securezze pa firme.
Pe piacere fà attenzione a specificà tutte le cambe esattamende cumme avessera essere, ''apprime de confermà sta schermata''.",
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
	'createsigndoc-success' => "'A firme d'u documende ha state abbilitate cu successe sus a [[$1]].
Tu puè [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testarle].",
	'createsigndoc-error-alreadycreated' => '\'U documende firmate "$1" già esiste.
Non ge pò essere fatte do vote.',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'createsigndocument' => 'Включить сбор подписей для документа',
	'createsigndoc-head' => "Вы можете использовать данную форму для инициации «подписания документа», участники смогут [[Special:SignDocument|подписать его]] с помощью специальной страницы.
Пожалуйста, укажите название страницы, на которой вы желаете включить сбор цифровых подписей, члены каких групп участников могут подписывать документ, какие поля будут видны обычным участникам, какие поля не обязательны для заполнения, минимальный возраст участника, желающего подписать документ (по умолчанию нет ограничений по возрасту), а также краткый вступительный текст, описывающий документ и дающий указания участникам.

'''В настоящее время нет способа удалить или изменить подписываемые документы после того, как они созданы''', без прямого доступа в базу данных.
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
Вы можете [{{fullurl:{{#Special:SignDocument}}|doc=$2}} проверить его].',
	'createsigndoc-error-alreadycreated' => 'Сбор подписей для страницы «$1» уже включён.
Это не может быть сделано ещё раз.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'createsigndoc-pagename' => 'Сторінка:',
	'createsigndoc-allowedgroup' => 'Поволена ґрупа:',
	'createsigndoc-email' => 'Адреса електронічной пошты:',
	'createsigndoc-address' => 'Домашня адреса:',
	'createsigndoc-extaddress' => 'Місто, штат, країна:',
	'createsigndoc-phone' => 'Телефонне чісло:',
	'createsigndoc-bday' => 'День народжіня:',
	'createsigndoc-minage' => 'Мінімалны рокы:',
	'createsigndoc-introtext' => 'Уведжіня:',
	'createsigndoc-hidden' => 'Схованый',
	'createsigndoc-optional' => 'Опціоналный',
	'createsigndoc-create' => 'Створити',
	'createsigndoc-error-generic' => 'Хыба: $1',
	'createsigndoc-error-pagenoexist' => 'Хыба: Сторінка [[$1]] не екзістує.',
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

'''Momentálne neexistuje spôsob ako zmazať alebo zmeniť podpisované dokumenty potom, ako boli vytvorené''' bez použitia priameho prístupu do databázy.
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
	'createsigndoc-success' => 'Podpisovanie dokumentov bolo úspešne zapnuté pre stránku [[$1]].
Otestovať ho môžete na [{{fullurl:{{#Special:SignDocument}}|doc=$2}} tejto stránke].',
	'createsigndoc-error-alreadycreated' => 'Podpis dokumentu „$1“ už existuje.
Túto operáciu nie je možné druhýkrát vrátiť.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'createsigndocument' => 'Omogoča podpisovanje dokumentov',
	'createsigndoc-pagename' => 'Stran:',
	'createsigndoc-allowedgroup' => 'Dovoljena skupina:',
	'createsigndoc-email' => 'E-poštni naslov:',
	'createsigndoc-address' => 'Domači naslov:',
	'createsigndoc-extaddress' => 'Mesto, država:',
	'createsigndoc-phone' => 'Telefonska številka:',
	'createsigndoc-bday' => 'Datum rojstva:',
	'createsigndoc-minage' => 'Najnižja starost:',
	'createsigndoc-introtext' => 'Uvod:',
	'createsigndoc-hidden' => 'Skrito',
	'createsigndoc-optional' => 'Izbirno',
	'createsigndoc-create' => 'Ustvari',
	'createsigndoc-error-generic' => 'Napaka: $1',
	'createsigndoc-error-pagenoexist' => 'Napaka: Stran [[$1]] ne obstaja.',
	'createsigndoc-success' => 'Podpisovanje dokumentov je uspešno omogočeno na [[$1]].
Lahko ga [{{fullurl:{{#Special:SignDocument}}|doc=$2}} preizkusite].',
	'createsigndoc-error-alreadycreated' => 'Podpisovanje dokumentov »$1« že obstaja.
Tega ne morete storiti dvakrat.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'createsigndoc-pagename' => 'Страница:',
	'createsigndoc-allowedgroup' => 'Дозвољена група:',
	'createsigndoc-email' => 'Е-адреса:',
	'createsigndoc-address' => 'Кућна адреса:',
	'createsigndoc-extaddress' => 'Град, држава:',
	'createsigndoc-phone' => 'Телефонски број:',
	'createsigndoc-bday' => 'Датум рођења:',
	'createsigndoc-minage' => 'Најмања старост:',
	'createsigndoc-introtext' => 'Увод:',
	'createsigndoc-hidden' => 'Сакривено',
	'createsigndoc-optional' => 'Необавезно',
	'createsigndoc-create' => 'Направи',
	'createsigndoc-error-generic' => 'Грешка: $1',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 */
$messages['sr-el'] = array(
	'createsigndoc-pagename' => 'Stranica:',
	'createsigndoc-allowedgroup' => 'Dozvoljena grupa:',
	'createsigndoc-email' => 'E-adresa:',
	'createsigndoc-address' => 'Kućna adresa:',
	'createsigndoc-extaddress' => 'Grad, država:',
	'createsigndoc-phone' => 'Telefonski broj:',
	'createsigndoc-bday' => 'Datum rođenja:',
	'createsigndoc-minage' => 'Najmanja starost:',
	'createsigndoc-introtext' => 'Uvod:',
	'createsigndoc-hidden' => 'Sakriveno',
	'createsigndoc-optional' => 'Neobavezno',
	'createsigndoc-create' => 'Napravi',
	'createsigndoc-error-generic' => 'Greška: $1',
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
 * @author Najami
 */
$messages['sv'] = array(
	'createsigndocument' => 'Möjliggör dokument signering',
	'createsigndoc-head' => "Använd detta formulär för att skapa ett \"signaturdokument\" för denna sida, så att användare kan [[Special:SignDocument|signera det]].
Var god ange sidans namn, vilken användargrupp som ska kunna signera det, vilka fält som ska vara synliga för användarna, vilka som ska vara valfria, minimumålder för att kunna signera dokumentet (om detta inte anges, finns det ingen gräns), och en kort introduktionstext som beskriver dokumentet och ger instruktioner till användarna.

'''Det finns inget sätt att radera eller ändra signaturdokument efter att de har skapats''' utan direkt databastillgång.
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
	'createsigndoc-success' => 'Dokumentsignering har möjliggjorts för [[$1]].
Du kan [{{fullurl:{{#Special:SignDocument}}|doc=$2}} testa det].',
	'createsigndoc-error-alreadycreated' => 'Dokumentsigneringen "$1" finns redan.
Det här kan inte göras en andra gång.',
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

/** Tajik (Cyrillic script) (Тоҷикӣ)
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

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'createsigndoc-pagename' => 'Sahifa:',
	'createsigndoc-email' => 'Nişonai E-mail:',
	'createsigndoc-address' => 'Suroƣai Xona:',
	'createsigndoc-extaddress' => 'Şahr, Vilojat, Kişvar:',
	'createsigndoc-phone' => 'Şumorai telefon:',
	'createsigndoc-bday' => 'Zodrūz:',
	'createsigndoc-introtext' => 'Şinosoī:',
	'createsigndoc-optional' => 'Ixtijorī',
	'createsigndoc-create' => 'Eçod',
	'createsigndoc-error-generic' => 'Xato: $1',
	'createsigndoc-error-pagenoexist' => 'Xato: Sahifai [[$1]] vuçud nadorad.',
);

/** Thai (ไทย)
 * @author Passawuth
 */
$messages['th'] = array(
	'createsigndoc-email' => 'อีเมล:',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'createsigndoc-pagename' => 'Sahypa:',
	'createsigndoc-create' => 'Döret',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'createsigndocument' => 'Paganahin/paandarin ang paglalagda sa kasulatan (dokumento)',
	'createsigndoc-head' => "Gamitin ang pormularyong ito upang makalikha ng isang pahinang 'Lagdaan ang pahina' (lumagda sa pahina) para sa ibinigay na pahina, upang magkaroon ng kakayahan ang mga tagagamit na [[Special:SignDocument|malagdaan ito]].
Pakitukoy ang pangalan ng pahina kung saan mo ibig paganahin/paandarin ang paglagda sa paraang dihital, kung anong pangkat ng tagagamit ang dapat pahintulutang lagdaan ito, kung anong mga hanay ang nais mong matanaw ng mga tagagamit at kung alin ang maaaring wala o hindi talaga kailangang mayroon, isang pinakamababang gulang/edad na dapat mayroon ang mga tagagamit upang makalagda sa kasulatan/dokumento (walang pinakamababa kapag hindi isinali/nakaligtaan);
at isang maiksing teksto ng pagpapakilala/pambungad na naglalarawan sa kasulatan/dokumento at nagbibigay ng mga pagtuturo/panuto sa mga tagagamit.

'''Sa pangkasalukuyan, walang kaparaanan upang mabura o mabago pa ang mga kasulatang may lagda na makaraang malikha/likhain sila''' na hindi tuwirang pinupuntahan ang kalipunan ng dato.
Bilang karagdagan, ang teksto ng pahinang nakalitaw/ipinapakita sa pahina ng lagda ay ang ''pangkasalukuyang'' teksto ng pahina, sa kabila ng lahat ng mga pagbabagong ginawa rito makalipas mula sa araw na ito.
Pakitiyak lamang ng lubusan na ang kasulatan/dokumento ay nasa isang punto/panahon ng katatagan para sa paglalagda.
Pakitiyak lamang din na tinukoy/tutukuyin mo ang lahat ng mga kahanayan ayon sa talagang nararapat/naaangkop para sa kanila, ''bago ipadala/ipasa ang pormularyong ito''.",
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
	'createsigndoc-success' => 'Matagumpay na napagana ang paglalagda ng kasulatan sa ibabaw ng [[$1]].
Maaari mong [{{fullurl:{{#Special:SignDocument}}|doc=$2}} subukan ito].',
	'createsigndoc-error-alreadycreated' => 'Umiiral na ang paglalagda ng kasulatang "$1".
Hindi na ito magagawa sa ikalawang pagkakataon.',
);

/** Turkish (Türkçe)
 * @author Karduelis
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'createsigndocument' => 'Belge imzalamayı etkinleştir',
	'createsigndoc-pagename' => 'Sayfa:',
	'createsigndoc-allowedgroup' => 'İzin verilen grup:',
	'createsigndoc-email' => 'E-posta adresi:',
	'createsigndoc-address' => 'Ev adresi:',
	'createsigndoc-extaddress' => 'Şehir, eyalet, ülke:',
	'createsigndoc-phone' => 'Telefon numarası:',
	'createsigndoc-bday' => 'Doğum günü:',
	'createsigndoc-minage' => 'Minimum yaş:',
	'createsigndoc-introtext' => 'Giriş:',
	'createsigndoc-hidden' => 'Gizli',
	'createsigndoc-optional' => 'Opsiyonel',
	'createsigndoc-create' => 'Oluştur',
	'createsigndoc-error-generic' => 'Hata: $1',
	'createsigndoc-error-pagenoexist' => 'Hata: [[$1]] sayfası bulunamadı.',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'createsigndoc-pagename' => 'Bet:',
);

/** Ukrainian (Українська)
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'createsigndoc-pagename' => 'Сторінка:',
	'createsigndoc-email' => 'Адреса електронної пошти:',
	'createsigndoc-introtext' => 'Вступ:',
	'createsigndoc-hidden' => 'Прихований',
	'createsigndoc-create' => 'Створити',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'createsigndoc-pagename' => "Lehtpol'",
	'createsigndoc-allowedgroup' => 'Lasktud gruppad',
	'createsigndoc-email' => 'E-počtan adres:',
	'createsigndoc-address' => 'Kodiadres:',
	'createsigndoc-extaddress' => 'Lidn, štat, valdkund:',
	'createsigndoc-phone' => 'Telefonnomer:',
	'createsigndoc-bday' => 'Sündundpäiv:',
	'createsigndoc-minage' => 'Minimaline igä:',
	'createsigndoc-introtext' => 'Tulend:',
	'createsigndoc-hidden' => 'Peittud',
	'createsigndoc-optional' => 'Opcionaline',
	'createsigndoc-create' => 'Säta',
	'createsigndoc-error-generic' => 'Petuz: $1',
	'createsigndoc-error-pagenoexist' => "Petuz: ei ole [[$1]]-lehtpol't.",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'createsigndocument' => 'Cho phép ký tài liệu',
	'createsigndoc-head' => "Hãy dùng mẫu này để tạo trang 'Ký tài liệu' cho trang chỉ định, sao cho người dùng sẽ có thể [[Special:SignDocument|ký tên vào nó]].
Xin hãy ghi rõ tên trang bạn muốn cho phép ký tên điện tử, thành viên của nhóm thành viên nào được cho phép ký tên, vùng nào bạn muốn người dùng nhìn thấy và cái nào là tùy chọn, tuổi tối thiểu được được ký tài liệu (không có giới hạn nếu bỏ trống);
và một đoạn giới thiệu ngắn gọn mô tả tài liệu và cung cấp hướng dẫn cho người dùng.

'''Hiện không có cách nào để xóa hay sửa tài liệu chữ ký sau khi chúng được tạo''' mà không truy cập trực tiếp vào cơ sở dữ liệu.
Ngoài ra, nội dung của trang được hiển thị tại trang ký tên sẽ là văn bản ''hiện thời'' của trang, bất kể có sự thay đổi nào sau hôm nay.
Xin hãy cực kỳ chắc chắn rằng tài liệu đã đạt tới mức ổn định để có thể ký tên, và xin hãy chắc chắn rằng bạn chỉ định tất cả các vùng một cách chính xác như mong muốn, ''trước khi đăng mẫu này lên''.",
	'createsigndoc-pagename' => 'Trang:',
	'createsigndoc-allowedgroup' => 'Nhóm được phép:',
	'createsigndoc-email' => 'Địa chỉ thư điện tử:',
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
Bạn có thể [{{fullurl:{{#Special:SignDocument}}|doc=$2}} thử nghiệm nó].',
	'createsigndoc-error-alreadycreated' => 'Văn bản ký tên "$1" đã tồn tại.
Bạn không thể làm điều này hai lần.',
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

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'createsigndocument' => 'לאזן אונטערשרייבן דאקומענטן',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Hydra
 * @author Liangent
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'createsigndocument' => '启用文档签名',
	'createsigndoc-pagename' => '页面：',
	'createsigndoc-email' => '电邮地址：',
	'createsigndoc-address' => '家的地址',
	'createsigndoc-phone' => '电话号码：',
	'createsigndoc-bday' => '出生日期：',
	'createsigndoc-hidden' => '隐藏',
	'createsigndoc-optional' => '可选',
	'createsigndoc-create' => '创造',
	'createsigndoc-error-generic' => '错误：$1',
	'createsigndoc-error-pagenoexist' => '错误：页面 [[$1]] 不存在。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Liangent
 * @author Mark85296341
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'createsigndocument' => '啟用文件簽名',
	'createsigndoc-pagename' => '頁面：',
	'createsigndoc-email' => '電郵地址：',
	'createsigndoc-address' => '家的地址',
	'createsigndoc-phone' => '電話號碼：',
	'createsigndoc-bday' => '出生日期：',
	'createsigndoc-hidden' => '隱藏',
	'createsigndoc-optional' => '可選擇',
	'createsigndoc-create' => '建立',
	'createsigndoc-error-generic' => '錯誤：$1',
	'createsigndoc-error-pagenoexist' => '錯誤：頁面 [[$1]] 不存在。',
);

