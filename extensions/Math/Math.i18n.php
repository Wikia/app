<?php
/**
 * Internationalization file for the Math extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English */
$messages['en'] = array(
	'math-desc' => 'Render mathematical formulas between <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code> tags',
	// Edit toolbar stuff shown on ?action=edit (example text & tooltip)
	'math_sample' => 'Insert formula here',
	'math_tip' => 'Mathematical formula (LaTeX)',

	// Header on Special:Preferences (or something)
	'prefs-math' => 'Math',

	// Math options
	'mw_math_png' => 'Always render PNG',
	'mw_math_source' => 'Leave it as TeX (for text browsers)',

	// Math errors
	'math_failure' => 'Failed to parse',
	'math_unknown_error' => 'unknown error',
	'math_unknown_function' => 'unknown function',
	'math_lexing_error' => 'lexing error',
	'math_syntax_error' => 'syntax error',
	'math_image_error' => 'PNG conversion failed; check for correct installation of latex and dvipng (or dvips + gs + convert)',
	'math_bad_tmpdir' => 'Cannot write to or create math temp directory',
	'math_bad_output' => 'Cannot write to or create math output directory',
	'math_notexvc' => 'Missing texvc executable; please see math/README to configure.',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Kizito
 * @author Siebrand
 */
$messages['qqq'] = array(
	'math-desc' => '{{desc}}',
	'math_sample' => 'The sample formula text that you get when you press the fourth button from the right on the edit toolbar.',
	'math_tip' => 'This is the text that appears when you hover the mouse over the fourth button from the right on the edit toolbar.',
	'prefs-math' => 'Used in user preferences.',
	'mw_math_png' => 'In user preferences. All mw_math_* messages MUST be different, things will break otherwise!',
	'mw_math_source' => 'In user preferences (math). All mw_math_* messages MUST be different, things will break otherwise!',
	'math_syntax_error' => '{{Identical|Syntax error}}',
);

/** Test (site admin only) (Test (site admin only)) */
$messages['test'] = array(
	'math_sample' => 'x',
	'math_tip' => 'x',
);

/** Magyar (magázó) (Magyar (magázó))
 * @author Dani
 */
$messages['hu-formal'] = array(
	'math_image_error' => 'PNG-vé alakítás sikertelen; ellenőrizze, hogy a latex és dvipng (vagy dvips + gs + convert) helyesen van-e telepítve',
);

/** Moroccan Spoken Arabic (Maġribi)
 * @author Enzoreg
 * @author Zanatos
 */
$messages['ary'] = array(
	'math_sample' => 'Kṫeb ĝalaqa de l-mat hnaya',
	'math_tip' => 'Ĝalaqa de l-mat (LaTeX)',
	'prefs-math' => 'mat',
	'mw_math_png' => 'dima biyn bhal  PNG',
	'math_failure' => 'khata flmat',
	'math_unknown_error' => 'khat mjhol',
	'math_unknown_function' => 'wadifa mjhola',
	'math_lexing_error' => 'khata fsigha',
	'math_syntax_error' => 'khata fsiyagha',
);

/** Achinese (Acèh)
 * @author Si Gam Acèh
 */
$messages['ace'] = array(
	'math_sample' => 'Pasoë rumuh nyoë pat',
	'math_tip' => 'Rumuh matematik (LaTeX)',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'math_sample' => 'Plaas formule hier',
	'math_tip' => 'Wiskundige formule (LaTeX)',
	'prefs-math' => 'Wiskunde',
	'mw_math_png' => 'Gebruik altyd PNG.',
	'mw_math_source' => 'Los as TeX (vir teksblaaiers).',
	'math_failure' => 'Kon nie verbeeld nie',
	'math_unknown_error' => 'onbekende fout',
	'math_unknown_function' => 'onbekende funksie',
	'math_lexing_error' => 'leksikale fout',
	'math_syntax_error' => 'sintaksfout',
	'math_image_error' => 'PNG-omskakeling het gefaal.
Kontroleer of LaTeX en dvipng (of dvips + gs + convert) korrek geïnstalleer is.',
	'math_bad_tmpdir' => 'Die gids vir tydelike lêers vir wiskundige formules bestaan nie of kan nie geskep word nie',
	'math_bad_output' => 'Die gids vir lêers met wiskundige formules bestaan nie of kan nie geskep word nie',
	'math_notexvc' => 'Kan nie die texvc program vind nie;
stel asseblief op volgens die beskrywing in math/README.',
);

/** Gheg Albanian (Gegë)
 * @author Bresta
 * @author Cradel
 */
$messages['aln'] = array(
	'math_sample' => 'Vendos formulën këtu',
	'math_tip' => 'Formulë matematikore (LaTeX)',
	'prefs-math' => 'Formulë',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'math_sample' => 'የሒሳብ ቀመር በዚህ ይግባ',
	'math_tip' => 'የሒሳብ ቀመር (LaTeX) ለመጨመር',
	'prefs-math' => 'የሂሳብ መልክ',
	'mw_math_png' => 'ሁልጊዜ እንደ PNG',
	'math_failure' => 'ዘርዛሪው ተሳነው',
	'math_unknown_error' => 'የማይታወቅ ስኅተት',
	'math_unknown_function' => 'የማይታወቅ ተግባር',
	'math_lexing_error' => 'የlexing ስህተት',
	'math_syntax_error' => 'የሰዋሰው ስህተት',
	'math_bad_output' => 'ወደ math ውጤት ዶሴ መጻፍ ወይም መፍጠር አይቻልም',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'math_sample' => 'Escriba aquí a formula',
	'math_tip' => 'Formula matematica (LaTeX)',
	'prefs-math' => 'Esprisions matematicas',
	'mw_math_png' => 'Producir siempre PNG',
	'mw_math_source' => 'Deixar como TeX (ta navegadores en formato texto)',
	'math_failure' => 'Error en o codigo',
	'math_unknown_error' => 'error esconoxita',
	'math_unknown_function' => 'función esconoxita',
	'math_lexing_error' => 'error de lexico',
	'math_syntax_error' => 'error de sintaxi',
	'math_image_error' => 'A conversión enta PNG ha tenito errors;
comprebe si latex, dvips, gs y convert son bien instalatos.',
	'math_bad_tmpdir' => "No s'ha puesto escribir u creyar o directorio temporal d'esprisions matematicas",
	'math_bad_output' => "No s'ha puesto escribir u creyar o directorio de salida d'esprisions matematicas",
	'math_notexvc' => "No s'ha trobato o fichero executable ''texvc''. Por favor, leiga <em>math/README</em> ta confegurar-lo correctament.",
);

/** Old English (Ænglisc)
 * @author Wōdenhelm
 */
$messages['ang'] = array(
	'math_sample' => 'Ƿiċunge hēr ēacian',
	'math_tip' => 'Rīmcræftisc ƿiċung (LaTeX)',
	'prefs-math' => 'Rīmcræft',
	'math_unknown_error' => 'uncūþ ƿōh',
);

/** Angika (अङ्गिका)
 * @author Angpradesh
 */
$messages['anp'] = array(
	'math_sample' => 'गणितीय सूत्र यहाँ डालॊ',
	'math_tip' => 'गणितीय सूत्र (LaTeX)',
);

/** Arabic (العربية)
 * @author Ciphers
 * @author Meno25
 */
$messages['ar'] = array(
	'math_sample' => 'أدخل الصيغة هنا',
	'math_tip' => 'صيغة رياضية (لا تك)',
	'prefs-math' => 'رياضيات',
	'mw_math_png' => 'دائما اعرض على هيئة PNG',
	'mw_math_source' => 'اعرض على هيئة TeX (للمتصفحات النصية)',
	'math_failure' => 'خطأ رياضيات',
	'math_unknown_error' => 'خطأ غير معروف',
	'math_unknown_function' => 'وظيفة غير معروفة',
	'math_lexing_error' => 'خطأ في الصيغة',
	'math_syntax_error' => 'خطأ في الصياغة',
	'math_image_error' => 'فشل التحويل إلى صيغة PNG؛ تحقق من تثبيت كل من Latex و dvipng (أو dvips + gs + محول)',
	'math_bad_tmpdir' => 'لا يمكن الكتابة إلى أو إنشاء مجلد الرياضيات المؤقت',
	'math_bad_output' => 'لا يمكن الكتابة إلى أو إنشاء مجلد الخرج للرياضيات',
	'math_notexvc' => 'مفقود texvc executable؛
من فضلك انظر math/README للضبط.',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'prefs-math' => 'ܡܬܡܐܛܝܩܘܬܐ',
	'math_unknown_error' => 'ܦܘܕܐ ܠܐ ܝܕܝܥܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'math_sample' => 'اكتب المعادله هنا',
	'math_tip' => 'معادله رياضيه (لا تكس )',
	'prefs-math' => 'رياضة',
	'mw_math_png' => 'دايما اعرض PNG',
	'mw_math_source' => 'اعرض على هيئة TeX (للبراوزرات النصية)',
	'math_failure' => 'الاعراب فشل',
	'math_unknown_error' => 'غلط مش معروف',
	'math_unknown_function' => 'وظيفة مش معروفة',
	'math_lexing_error' => 'غلط فى الكلمة',
	'math_syntax_error' => 'غلط فى تركيب الجملة',
	'math_image_error' => 'فشل التحويل لـ PNG ؛
اتاكد من التثبيت المضبوط لـ :Latex و dvips و gs و convert.',
	'math_bad_tmpdir' => 'مش ممكن الكتابة أو انشاء مجلد الرياضة الموؤقت',
	'math_bad_output' => 'مش ممكن الكتابة لـ أو إنشاء مجلد الخرج للرياضيات',
	'math_notexvc' => 'ضايعtexvc executable ؛ لو سمحت شوفmath/README للضبط.',
);

/** Assamese (অসমীয়া)
 * @author Chaipau
 * @author Rajuonline
 */
$messages['as'] = array(
	'math_sample' => 'ইয়াত গণিতীয় সুত্ৰ সুমুৱাওক',
	'math_tip' => 'গণিতীয় সুত্ৰ (LaTeX)',
	'prefs-math' => 'গণিত',
	'math_failure' => 'পাৰ্চ কৰিব অসমৰ্থ',
	'math_unknown_error' => 'অপৰিচিত সমস্যা',
	'math_unknown_function' => 'অজ্ঞাত কাৰ্য্য',
);

/** Asturian (Asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'math-desc' => 'Dibuxa les fórmules matemátiques ente les etiquetes <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Inxertar fórmula equí',
	'math_tip' => 'Fórmula matemática',
	'prefs-math' => 'Fórmules matemátiques',
	'mw_math_png' => 'Renderizar siempre PNG',
	'mw_math_source' => 'Dexalo como TeX (pa navegadores de testu)',
	'math_failure' => 'Fallu al revisar la fórmula',
	'math_unknown_error' => 'error desconocíu',
	'math_unknown_function' => 'función desconocida',
	'math_lexing_error' => 'Error lléxicu',
	'math_syntax_error' => 'error de sintaxis',
	'math_image_error' => 'Falló la conversión PNG; comprueba que tea bien la instalación de latex y dvipng (o dvips + gs + convert)',
	'math_bad_tmpdir' => "Nun se pue escribir o crear el direutoriu temporal 'math'",
	'math_bad_output' => "Nun se pue escribir o crear el direutoriu de salida 'math'",
	'math_notexvc' => "Falta l'executable 'texvc'; por favor mira 'math/README' pa configuralo.",
);

/** Avaric (Авар)
 * @author Amire80
 */
$messages['av'] = array(
	'math_unknown_error' => 'Лъалареб гъалатӀ',
);

/** Kotava (Kotava) */
$messages['avk'] = array(
	'math_sample' => 'Va rinaf tazukoy batliz cenkal',
	'math_tip' => 'Solokseropaf tazukoy (LaTeX)',
	'prefs-math' => 'Rendu des maths',
	'mw_math_png' => 'Toujours produire une image PNG',
	'mw_math_source' => 'Laisser le code TeX original',
	'math_failure' => 'Erreur math',
	'math_unknown_error' => 'erreur indéterminée',
	'math_unknown_function' => 'megrupen fliok',
	'math_lexing_error' => 'ravlemafa rokla',
	'math_syntax_error' => 'erurafa rokla',
	'math_image_error' => "La conversion en PNG a échouée, vérifiez l'installation de Latex, dvips, gs et convert",
	'math_bad_tmpdir' => 'Redura ik sutera ko ugaloraxo tid merotisa',
	'math_bad_output' => 'Redura ik sutera ko divaxo tid merotisa',
	'math_notexvc' => "L'éxécutable « texvc » est introuvable. Lisez math/README pour le configurer.",
);

/** Azerbaijani (Azərbaycanca)
 * @author PrinceValiant
 */
$messages['az'] = array(
	'math_sample' => 'Riyazi formulu bura yazın',
	'math_tip' => 'Riyazi formul (LaTeX formatı)',
	'prefs-math' => 'Riyaziyyat',
	'mw_math_png' => 'Həmişə PNG formatında göstər',
	'mw_math_source' => 'TeX kimi saxla (mətn brouzerləri üçün)',
	'math_unknown_error' => 'bilinməyən xəta',
	'math_unknown_function' => 'bilinməyən funksiya',
	'math_syntax_error' => 'sintaksis xətası',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 * @author Рустам Нурыев
 */
$messages['ba'] = array(
	'math_sample' => 'Формуланы бында керетегеҙ',
	'math_tip' => 'Математик формула (LaTeX форматы)',
	'prefs-math' => 'Формулалар',
	'mw_math_png' => 'Һәр ваҡыт PNG яһа',
	'mw_math_source' => 'ТеХ форматында ҡалдырырға (текст браузерҙары өсөн)',
	'math_failure' => 'Уҡып булмай',
	'math_unknown_error' => 'билдәһеҙ хата',
	'math_unknown_function' => 'билдәһеҙ функция',
	'math_lexing_error' => 'лексик хата',
	'math_syntax_error' => 'синтаксик хата',
	'math_image_error' => 'PNG яһау хатаһы.
latex һәм dvipng (йәки dvips + gs + convert) дөрөҫ ҡуйылыуын тикшерегеҙ.',
	'math_bad_tmpdir' => 'Ваҡытлы математика директорияһы булдырып йәки директорияға яҙҙырып булмай',
	'math_bad_output' => 'Математика директорияһы булдырып йәки директорияға яҙҙырып булмай',
	'math_notexvc' => 'Башҡарыла торған texvc файлы юҡ. Көйләүҙәр буйынса белешмәне — math/README уҡығыҙ.',
);

/** Bavarian (Boarisch)
 * @author Mucalexx
 */
$messages['bar'] = array(
	'math_sample' => 'Formel dodan aifyng',
	'math_tip' => 'Mathematische Formel (LaTeX)',
	'math_unknown_function' => 'Unbekannte Funktion',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'math_sample' => 'فرمول اداں وارد کن',
	'math_tip' => 'فرمول ریاضی  (LaTeX)',
	'prefs-math' => 'ریاضی',
	'mw_math_png' => 'یکسره PNG تحویل دی',
	'mw_math_source' => 'آیء په داب TeX بل (په بروززان متنی)',
	'math_failure' => 'تجزیه پروش وارت',
	'math_unknown_error' => 'ناشناسین حطا',
	'math_unknown_function' => 'ناشناس عملگر',
	'math_lexing_error' => 'حطا نوشتاری',
	'math_syntax_error' => 'حطا ساختار',
	'math_image_error' => 'بدل کتن PNGپروش وارت;
کنترل کنیت په نصب latex, dvips, gs, و convert',
	'math_bad_tmpdir' => 'نه نونیت بنویسیت یا مسیر غیر دایمی ریاضی شرکنت',
	'math_bad_output' => 'نه تونیت بنویسیت یا مشیر خروجی ریاضی شرکنت.',
	'math_notexvc' => 'ترکیب کتن texvc  قابل اجرا;
لطفا بچار math/README په تنظیم کتن.',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 * @author Steven*fung
 */
$messages['bcl'] = array(
	'math_sample' => 'Isaliôt an pormula digdi',
	'math_tip' => 'Pórmulang matemátika (LaTeX)',
	'prefs-math' => 'Mat',
	'mw_math_png' => 'Itaô pirmi an PNG',
	'mw_math_source' => "Pabayaan na bilang TeX (para sa mga ''browser'' na teksto)",
	'math_failure' => 'Nagprakaso an pagatíd-atíd',
	'math_unknown_error' => 'dai aram an salâ',
	'math_unknown_function' => 'Dai aram an gamit',
	'math_lexing_error' => 'may salâ sa analisador léxico',
	'math_syntax_error' => 'may salâ sa analisador nin sintaksis',
	'math_image_error' => 'Nagprakaso an konbersyon kan PNG; sosogon tabî an pagkaag nin latex, dvips, gs, asin ikonbertir',
	'math_bad_tmpdir' => 'Dai masuratan o magibo an direktoryo nin mat temp',
	'math_bad_output' => 'Dai masuratan o magibo an direktoryo kan salida nin math',
	'math_notexvc' => 'May nawawarang texvc na ehekutable; hilingón tabî an mat/README para makonpigurar.',
);

/** Belarusian (Беларуская)
 * @author Mienski
 * @author Yury Tarasievich
 */
$messages['be'] = array(
	'math_sample' => 'Уставіць формулу тут',
	'math_tip' => 'Матэматычная формула (LaTeX)',
	'prefs-math' => 'Матэматыка',
	'mw_math_png' => 'Заўсёды вырабляць PNG',
	'mw_math_source' => 'Пакідаць у выглядзе TeX (для тэкставых браўзераў)',
	'math_failure' => 'Не ўдалося разабраць',
	'math_unknown_error' => 'невядомая памылка',
	'math_unknown_function' => 'невядомая функцыя',
	'math_lexing_error' => 'лексічная памылка',
	'math_syntax_error' => 'памылка сінтаксісу',
	'math_image_error' => 'Не ўдалося ператварыць PNG; праверце правільнасць устаноўкі пакетаў latex і dvipng (або dvips і gs і convert)',
	'math_bad_tmpdir' => 'Немагчыма запісаць у або стварыць тымчасовы каталог для матэматыкі',
	'math_bad_output' => 'Немагчыма запісаць у або стварыць выводны каталог для матэматыкі',
	'math_notexvc' => 'Не знойдзены выканальны модуль texvc; аб яго настаўленнях чытайце ў math/README.',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'math-desc' => 'Выводзіць матэматычныя формулы, запісаныя паміж тэгамі <code>&lt;math&gt;</code> і <code>&lt;/math&gt;</code>',
	'math_sample' => 'Зьмясьціце тут формулу',
	'math_tip' => 'Матэматычная формула (LaTeX)',
	'prefs-math' => 'Матэматыка',
	'mw_math_png' => 'Заўсёды паказваць як PNG',
	'mw_math_source' => 'Пакідаць у выглядзе TeX (для тэкставых браўзэраў)',
	'math_failure' => 'Немагчыма разабраць',
	'math_unknown_error' => 'невядомая памылка',
	'math_unknown_function' => 'невядомая функцыя',
	'math_lexing_error' => 'лексычная памылка',
	'math_syntax_error' => 'сынтаксычная памылка',
	'math_image_error' => 'Памылка пераўтварэньня ў фармат PNG;
праверце слушнасьць усталяваньня latex, dvips (ці dvips + gs + convert)',
	'math_bad_tmpdir' => 'Немагчыма запісаць ці стварыць часовую дырэкторыю для матэматыкі',
	'math_bad_output' => 'Немагчыма запісаць ці стварыць выходную матэматычную дырэкторыю',
	'math_notexvc' => 'Выканаўчы модуль texvc ня знойдзены.
Калі ласка, прачытайце math/README пра яго канфігурацыю.',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'math_sample' => 'Тук въведете формулата',
	'math_tip' => 'Математическа формула (LaTeX)',
	'prefs-math' => 'Математически формули',
	'mw_math_png' => 'Използване винаги на PNG',
	'mw_math_source' => 'Оставяне като TeX (за текстови браузъри)',
	'math_failure' => 'Неуспех при разбора',
	'math_unknown_error' => 'непозната грешка',
	'math_unknown_function' => 'непозната функция',
	'math_lexing_error' => 'лексикална грешка',
	'math_syntax_error' => 'синтактична грешка',
	'math_image_error' => 'Превръщането към PNG не сполучи. Проверете дали latex и dvipng (или dvips + gs + convert) са правилно инсталирани.',
	'math_bad_tmpdir' => 'Невъзможно е писането във или създаването на временна директория за математическите операции',
	'math_bad_output' => 'Невъзможно е писането във или създаването на изходяща директория за математическите операции',
	'math_notexvc' => 'Липсва изпълнимият файл на texvc. Прегледайте math/README за информация относно конфигурирането.',
);

/** Bihari (भोजपुरी)
 * @author Ganesh
 */
$messages['bh'] = array(
	'math_tip' => 'गणितिय सूत्र (LaTeX)',
	'prefs-math' => 'गणित',
);

/** Bhojpuri (भोजपुरी)
 * @author Ganesh
 */
$messages['bho'] = array(
	'math_tip' => 'गणितिय सूत्र (LaTeX)',
	'prefs-math' => 'गणित',
);

/** Banjar (Bahasa Banjar)
 * @author Ezagren
 * @author J Subhi
 */
$messages['bjn'] = array(
	'math_sample' => 'Masukakan rumus di sia',
	'math_tip' => 'Rumus matamatika (LaTeX)',
	'prefs-math' => 'Matik',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'math_sample' => 'সূত্র এখানে লিখুন',
	'math_tip' => 'গাণিতিক সূত্র (LaTeX)',
	'prefs-math' => 'গণিত',
	'mw_math_png' => 'সবসময় পিএনজি (PNG) দেখাও',
	'mw_math_source' => 'টেক (TeX) আকারে রেখে দাও (টেক্সট ব্রাউজারগুলোর জন্য)',
	'math_failure' => 'পার্স করতে ব্যর্থ',
	'math_unknown_error' => 'অজানা ত্রুটি',
	'math_unknown_function' => 'অজানা ফাংশন',
	'math_lexing_error' => 'লেক্সিং ত্রুটি',
	'math_syntax_error' => 'সিনট্যাক্স ত্রুটি',
	'math_image_error' => 'PNG রূপান্তর ব্যর্থ; latex, dvips, gs, এবং convert ঠিকমত ইন্সটল হয়েছে কি না পরীক্ষা করুন',
	'math_bad_tmpdir' => 'সাময়িক ম্যাথ ডিরেক্টরি সৃষ্টি করতে বা এতে লিখতে পারা যাচ্ছে না।',
	'math_bad_output' => 'ম্যাথ আউটপুট ডিরেক্টরি সৃষ্টি করতে বা এতে লিখতে পারা যাচ্ছে না।',
	'math_notexvc' => 'texvc executable হারানো গেছে; অনুগ্রহ করে কনফিগার করার জন্য math/README দেখুন।',
);

/** Bishnupria Manipuri (ইমার ঠার/বিষ্ণুপ্রিয়া মণিপুরী)
 * @author Usingha
 */
$messages['bpy'] = array(
	'math_sample' => 'এহাত সুত্র বরা',
	'math_tip' => 'অংকর সুত্র (LaTeX)',
	'prefs-math' => 'গণিত',
);

/** Bakhtiari (بختياري)
 * @author Behdarvandyani
 */
$messages['bqi'] = array(
	'math_sample' => 'فرمول نهادن ایچو',
	'math_tip' => 'فرمول ریاضی (LaTeX)',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'math_sample' => 'Lakait ho formulenn amañ',
	'math_tip' => 'Formulenn jedoniel (LaTeX)',
	'prefs-math' => 'Tres jedoniel',
	'mw_math_png' => 'Produiñ atav ur skeudenn PNG',
	'mw_math_source' => "Leuskel ar c'hod TeX orin",
	'math_failure' => 'Fazi jedoniezh',
	'math_unknown_error' => 'fazi dianav',
	'math_unknown_function' => 'kevreizhenn jedoniel dianav',
	'math_lexing_error' => 'fazi ger',
	'math_syntax_error' => 'fazi ereadur',
	'math_image_error' => "C'hwitet eo bet an amdroadur PNG; gwiriit eo staliet mat Latex ha devipng (pe dvips, gs ha convert)",
	'math_bad_tmpdir' => "N'hall ket krouiñ pe skrivañ er c'havlec'h da c'hortoz",
	'math_bad_output' => "N'hall ket krouiñ pe skrivañ er c'havlec'h ermaeziañ",
	'math_notexvc' => "N'hall ket an erounezeg 'texvc' bezañ kavet. Lennit math/README evit he c'hefluniañ.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'math_sample' => 'Unesite formulu ovdje',
	'math_tip' => 'Matematička formula (LaTeX)',
	'prefs-math' => 'Prikazivanje matematike',
	'mw_math_png' => 'Uvijek prikaži kao PNG',
	'mw_math_source' => 'Ostavi kao TeX (za tekstualne preglednike)',
	'math_failure' => 'Neuspjeh pri parsiranju',
	'math_unknown_error' => 'nepoznata greška',
	'math_unknown_function' => 'nepoznata funkcija',
	'math_lexing_error' => 'riječnička greška',
	'math_syntax_error' => 'sintaksna greška',
	'math_image_error' => 'PNG konverzija neuspješna; provjerite tačnu instalaciju latex-a i dvipng-a (ili dvips + gs + convert)',
	'math_bad_tmpdir' => 'Ne može se napisati ili napraviti privremeni matematični direktorijum',
	'math_bad_output' => 'Ne može se napisati ili napraviti direktorijum za matematični izvještaj.',
	'math_notexvc' => 'Nedostaje izvršno texvc; molimo Vas da pogledate math/README da podesite.',
);

/** Catalan (Català)
 * @author Martorell
 * @author SMP
 * @author Toniher
 * @author Vriullop
 */
$messages['ca'] = array(
	'math_sample' => 'Inseriu una fórmula ací',
	'math_tip' => 'Fórmula matemàtica (LaTeX)',
	'prefs-math' => 'Com es mostren les fórmules',
	'mw_math_png' => 'Produeix sempre PNG',
	'mw_math_source' => 'Deixa com a TeX (per a navegadors de text)',
	'math_failure' => "No s'ha pogut entendre",
	'math_unknown_error' => 'error desconegut',
	'math_unknown_function' => 'funció desconeguda',
	'math_lexing_error' => 'error de lèxic',
	'math_syntax_error' => 'error de sintaxi',
	'math_image_error' => 'Hi ha hagut una errada en la conversió a PNG. Verifiqueu la instaŀlació de latex i dvipng (o dvips, gs i convert).',
	'math_bad_tmpdir' => 'No ha estat possible crear el directori temporal de math o escriure-hi dins.',
	'math_bad_output' => "No ha estat possible crear el directori d'eixida de math o escriure-hi dins.",
	'math_notexvc' => "No s'ha trobat el fitxer executable ''texvc''; si us plau, vegeu math/README per a configurar-lo.",
);

/** Min Dong Chinese (Mìng-dĕ̤ng-ngṳ̄) */
$messages['cdo'] = array(
	'prefs-math' => 'Só-hŏk',
	'math_unknown_error' => 'muôi báik gì dâng',
	'math_unknown_function' => 'muôi báik hàng-só',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'math_sample' => 'Каьчдинарг чудила кхузе',
	'math_tip' => 'Матlематlекхиа каьчйар (барам LaTeX)',
);

/** Cebuano (Cebuano)
 * @author Jordz
 */
$messages['ceb'] = array(
	'math_sample' => 'I-insert dinhi ang formula',
	'math_tip' => 'Mathematical formula (LaTeX)',
	'prefs-math' => 'Math',
);

/** Chamorro (Chamoru)
 * @author Gadao01
 */
$messages['ch'] = array(
	'math_sample' => "Po'lo i fotmula mågi",
	'math_tip' => 'Fotmulan matematika (LaTeX)',
	'prefs-math' => 'Math',
	'math_failure' => 'Lachi ma parse',
	'math_unknown_error' => "linachi ti matungo'",
	'math_unknown_function' => "fonksion ti matungo'",
	'math_lexing_error' => 'linachi lexing',
	'math_syntax_error' => 'linachi syntax',
);

/** Sorani (کوردی)
 * @author Arastein
 * @author Asoxor
 * @author Marmzok
 */
$messages['ckb'] = array(
	'math_sample' => 'فۆرموول لێرە بنووسە',
	'math_tip' => 'فۆرموولی بیرکاری (LaTeX)',
	'prefs-math' => 'بیرکاری',
	'mw_math_png' => 'ھەموو جارێک وەک PNG نیشان بدە',
	'mw_math_source' => 'وەک TeX بمێنێتەوە (بۆ وێبگەڕە دەقی‌یەکان)',
	'math_unknown_error' => 'هەڵەیەکی نەزانراو',
	'math_unknown_function' => 'فەرمانێکی نەناسراو',
	'math_syntax_error' => 'ڕستەکار هەڵەیە',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'prefs-math' => 'Matematica',
	'math_syntax_error' => 'errore di sintassa',
);

/** Capiznon (Capiceño)
 * @author Oxyzen
 */
$messages['cps'] = array(
	'math_sample' => 'Isulod ang diya pormula',
	'math_tip' => 'Pormula nga pangmatematika (LaTeX)',
);

/** Crimean Turkish (Latin script) (‪Qırımtatarca (Latin)‬)
 * @author Don Alessandro
 */
$messages['crh-latn'] = array(
	'math_sample' => 'Bu yerge formulanı kirsetiñiz',
	'math_tip' => 'Riyaziy (matematik) formula (LaTeX formatında)',
	'prefs-math' => 'Riyaziy (matematik) işaretler',
	'mw_math_png' => 'Daima PNG resim formatına çevir',
	'mw_math_source' => 'Deñiştirmeden TeX olaraq taşla  (metin temelli brauzerler içün)',
	'math_failure' => 'Ayırıştırılamadı',
	'math_unknown_error' => 'bilinmegen hata',
	'math_unknown_function' => 'belgisiz funktsiya',
	'math_lexing_error' => 'leksik hata',
	'math_syntax_error' => 'sintaksis hatası',
);

/** Crimean Turkish (Cyrillic script) (‪Къырымтатарджа (Кирилл)‬)
 * @author Don Alessandro
 */
$messages['crh-cyrl'] = array(
	'math_sample' => 'Бу ерге формуланы кирсетинъиз',
	'math_tip' => 'Риязий (математик) формула (LaTeX форматында)',
	'prefs-math' => 'Риязий (математик) ишаретлер',
	'mw_math_png' => 'Даима PNG ресим форматына чевир',
	'mw_math_source' => 'Денъиштирмеден TeX оларакъ ташла  (метин темелли браузерлер ичюн)',
	'math_failure' => 'Айырыштырыламды',
	'math_unknown_error' => 'билинмеген хата',
	'math_unknown_function' => 'бельгисиз функция',
	'math_lexing_error' => 'лексик хата',
	'math_syntax_error' => 'синтаксис хатасы',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Mormegil
 */
$messages['cs'] = array(
	'math_sample' => 'Vložit sem vzorec',
	'math_tip' => 'Matematický vzorec (LaTeX)',
	'prefs-math' => 'Matematika',
	'mw_math_png' => 'Vždy jako PNG',
	'mw_math_source' => 'Ponechat jako TeX (pro textové prohlížeče)',
	'math_failure' => 'Nelze pochopit',
	'math_unknown_error' => 'neznámá chyba',
	'math_unknown_function' => 'neznámá funkce',
	'math_lexing_error' => 'chyba při lexingu',
	'math_syntax_error' => 'syntaktická chyba',
	'math_image_error' => 'Selhala konverze do PNG; zkontrolujte správnou instalaci latexu a dvipng (nebo dvips + gs + convert)',
	'math_bad_tmpdir' => 'Nelze zapsat nebo vytvořit dočasný adresář pro matematiku',
	'math_bad_output' => 'Nelze zapsat nebo vytvořit adresář pro výstup matematiky',
	'math_notexvc' => 'Chybí spustitelný texvc; podívejte se prosím do math/README na konfiguraci.',
);

/** Kashubian (Kaszëbsczi)
 * @author Kaszeba
 * @author Warszk
 */
$messages['csb'] = array(
	'math_sample' => 'Wstôwi tuwò fòrmùłã',
	'math_tip' => 'Matematicznô fòrmùła (LaTeX)',
	'prefs-math' => 'Matematika',
	'mw_math_png' => 'Wiedno wëskrzëniwôj jakno PNG',
	'mw_math_source' => 'Òstawi jakno TeX (dlô tekstowich przezérników)',
	'math_failure' => 'Parser nie rozmiôł rozpòznac',
);

/** Church Slavic (Словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author ОйЛ
 */
$messages['cu'] = array(
	'math_tip' => 'маѳиматїчьна формоула (LaTeX)',
);

/** Chuvash (Чӑвашла)
 * @author PCode
 */
$messages['cv'] = array(
	'math_sample' => 'Формулăна кунта кĕртĕр',
	'math_tip' => 'Математика формули (LaTeX форматпа)',
	'mw_math_png' => 'Яланах PNG хатĕрлемелле',
	'math_syntax_error' => 'синтаксис йăнăшĕ',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'math_sample' => 'Gosodwch fformwla yma',
	'math_tip' => 'Fformwla mathemategol (LaTeX)',
	'prefs-math' => 'Mathemateg',
	'mw_math_png' => 'Arddangos symbolau mathemateg fel delwedd PNG bob amser',
	'mw_math_source' => 'Gadewch fel côd TeX (ar gyfer porwyr testun)',
	'math_failure' => 'Wedi methu dosrannu',
	'math_unknown_error' => 'gwall anhysbys',
	'math_unknown_function' => 'ffwythiant anhysbys',
	'math_lexing_error' => 'gwall lecsio',
	'math_syntax_error' => 'gwall cystrawen',
	'math_image_error' => "Trosiad PNG wedi methu; gwiriwch fod latex a dvips (neu dvips + gs + convert) wedi'u gosod yn gywir cyn trosi.",
	'math_bad_tmpdir' => 'Yn methu creu cyfeiriadur mathemateg dros dro, nac ysgrifennu iddo',
	'math_bad_output' => 'Yn methu creu cyfeiriadur allbwn mathemateg nac ysgrifennu iddo',
	'math_notexvc' => 'Rhaglen texvc yn eisiau; gwelwch math/README er mwyn ei chyflunio.',
);

/** Danish (Dansk)
 * @author Nghtwlkr
 */
$messages['da'] = array(
	'math_sample' => 'Indsæt formel her (LaTeX)',
	'math_tip' => 'Matematisk formel (LaTeX)',
	'prefs-math' => 'Matematiske formler',
	'mw_math_png' => 'Vis altid som PNG',
	'mw_math_source' => 'Lad være som TeX (for tekstbrowsere)',
	'math_failure' => 'Fejl i matematikken',
	'math_unknown_error' => 'ukendt fejl',
	'math_unknown_function' => 'ukendt funktion',
	'math_lexing_error' => 'lexerfejl',
	'math_syntax_error' => 'syntaksfejl',
	'math_image_error' => 'PNG-konvertering mislykkedes; undersøg om latex og dvipng (eller dvips + gs + convert) er installeret korrekt',
	'math_bad_tmpdir' => 'Kan ikke skrive til eller oprette temp-mappe til math',
	'math_bad_output' => 'Kan ikke skrive til eller oprette uddata-mappe til math',
	'math_notexvc' => 'Manglende eksekvérbar texvc; se math/README for opsætningsoplysninger.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 * @author Revolus
 * @author Umherirrender
 */
$messages['de'] = array(
	'math-desc' => 'Ergänzt das Tag <code>&lt;math&gt;</code> zum Darstellen mathematischer Formeln',
	'math_sample' => 'Formel hier einfügen',
	'math_tip' => 'Mathematische Formel (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'Immer als PNG darstellen',
	'mw_math_source' => 'Als TeX belassen (für Textbrowser)',
	'math_failure' => 'Fehler beim Parsen',
	'math_unknown_error' => 'Unbekannter Fehler',
	'math_unknown_function' => 'Unbekannte Funktion ',
	'math_lexing_error' => 'Lexikalischer Fehler',
	'math_syntax_error' => 'Syntaxfehler',
	'math_image_error' => 'PNG-Konvertierung fehlgeschlagen. Bitte die korrekte Installation von LaTeX und dvipng überprüfen (oder dvips + gs + convert)',
	'math_bad_tmpdir' => 'Das temporäre Verzeichnis für mathematische Formeln kann nicht angelegt oder beschrieben werden.',
	'math_bad_output' => 'Das Ausgabeverzeichnis für mathematische Formeln kann nicht angelegt oder beschrieben werden.',
	'math_notexvc' => 'Das texvc-Programm wurde nicht gefunden. Bitte zur Konfiguration die Hinweise in der Datei math/README beachten.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'math_sample' => 'Formula itiya ra bınus',
	'math_tip' => 'Formulayo Matematik (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'Herzeman PNG render bike',
	'mw_math_source' => 'Bi TeX biman (qe nuşte browseroği)',
	'math_failure' => 'Parse de ğeleti biyo',
	'math_unknown_error' => 'ğeleti nizanyeno',
	'math_unknown_function' => 'fonksiyon nizanyeno',
	'math_lexing_error' => 'ğeleto lexing',
	'math_syntax_error' => 'ğeleto sintaks',
	'math_image_error' => 'Conversiyonê PNG de ğeleti esta;
qe ronayişê raşti ye latex, dvips, gs kontrol bike u convert bike',
	'math_bad_tmpdir' => 'Nieşkeno binusi ya zi direktorê mathi virazi',
	'math_bad_output' => 'Nieşkeno binusi ya zi direktorê mathi ye outputi virazi',
	'math_notexvc' => "xebetnayekarê texvc'i vindbiyo
qey 'eyar kerdışi bıewnê math/README'yi.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 * @author Nepl1
 * @author Pe7er
 * @author Qualia
 */
$messages['dsb'] = array(
	'math-desc' => 'Dodawa matematiske formule mjazy toflickoma <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Zapódaj how formulu',
	'math_tip' => 'Matematiska formula (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'Pśecej ako PNG zwobrazniś.',
	'mw_math_source' => 'Ako TeX wóstajiś (za tekstowe browsery)',
	'math_failure' => 'Zmólka',
	'math_unknown_error' => 'njeznata zmólka',
	'math_unknown_function' => 'njeznata funkcija',
	'math_lexing_error' => 'leksikaliska zmólka',
	'math_syntax_error' => 'syntaktiska zmólka',
	'math_image_error' => 'PNG-konwertěrowanje njejo se raźiło; pśekontrolěruj korektnu instalaciju latex a dvipng (abo dvips + gs + konwertěruj)',
	'math_bad_tmpdir' => 'Njejo móžno temporarny zapisk za matematiske formule załožyś resp. do njogo pisaś.',
	'math_bad_output' => 'Njejo móžno celowy zapisk za matematiske formule załožyś resp. do njogo pisaś.',
	'math_notexvc' => 'Program texvc felujo. Pšosym glědaj do math/README.',
);

/** Central Dusun (Dusun Bundu-liwan)
 * @author FRANCIS5091
 */
$messages['dtp'] = array(
	'math_sample' => 'Posuango puralanon do hiti',
	'math_tip' => 'Karalano monintaban (LaTeX)',
);

/** Dzongkha (ཇོང་ཁ)
 * @author Tenzin
 */
$messages['dz'] = array(
	'math_sample' => 'ནཱ་ལུ་ ཐབས་རྟགས་བཙུགས།',
	'math_tip' => 'ཨང་རྩིས་ཐབས་རྟགས་ (LaTeX)',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Geraki
 */
$messages['el'] = array(
	'math_sample' => 'Εισαγωγή τύπου εδώ',
	'math_tip' => 'Μαθηματικός τύπος (LaTeX)',
	'prefs-math' => 'Απόδοση μαθηματικών',
	'mw_math_png' => 'Απόδοση πάντα σε PNG',
	'mw_math_source' => 'Να παραμείνει ως TeX (για text browsers)',
	'math_failure' => 'Δεν μπόρεσε να γίνει ανάλυση του όρου.',
	'math_unknown_error' => 'άγνωστο σφάλμα',
	'math_unknown_function' => 'άγνωστη συνάρτηση',
	'math_lexing_error' => 'Σφάλμα στην λεξική ανάλυση',
	'math_syntax_error' => 'Λάθος σύνταξης',
	'math_image_error' => 'Η μετατροπή σε PNG απέτυχε. Παρακαλούμε ελέγξτε ότι έχουν εγκατασταθεί σωστά τα latex  και dvipng (ή dvips + gs + convert)',
	'math_bad_tmpdir' => 'Δεν είναι δυνατή η δημιουργία μαθηματικών δεδομένων (ή η εγγραφή σε προσωρινό κατάλογο)',
	'math_bad_output' => 'Δεν είναι δυνατή η δημιουργία  μαθηματικών δεδομένων (ή η εγγραφή σε κατάλογο εξόδου)',
	'math_notexvc' => 'Λείπει το εκτελέσιμο texvc -παρακαλούμε συμβουλευτείτε το math/README για να ρυθμίσετε τις παραμέτρους.',
);

/** Esperanto (Esperanto)
 * @author Mihxil
 * @author Yekrats
 * @author לערי ריינהארט
 */
$messages['eo'] = array(
	'math_sample' => 'Enmeti formulon ĉi tien',
	'math_tip' => 'Matematika formulo (LaTeX)',
	'prefs-math' => 'Matematikaĵoj',
	'mw_math_png' => 'Ĉiam krei PNG-bildon',
	'mw_math_source' => 'Lasu TeX-fonton (por tekstfoliumiloj)',
	'math_failure' => 'malsukcesis analizi formulon',
	'math_unknown_error' => 'nekonata eraro',
	'math_unknown_function' => 'nekonata funkcio',
	'math_lexing_error' => 'leksika analizo malsukcesis',
	'math_syntax_error' => 'sintakseraro',
	'math_image_error' => 'Konverto al PNG malsukcesis; kontrolu ĉu estas ĝuste instalitaj latex kaj dvipng (aŭ dvips + gs + convert)',
	'math_bad_tmpdir' => 'Ne povas skribi al aŭ krei matematikian labor-dosierujon.',
	'math_bad_output' => 'Ne povas enskribi aŭ krei matematikan eligan dosierujon',
	'math_notexvc' => 'Programo texvc ne ekzistas; bonvolu vidi math/README por konfiguri.',
);

/** Spanish (Español)
 * @author Dferg
 * @author Fitoschido
 * @author Platonides
 * @author Translationista
 */
$messages['es'] = array(
	'math_sample' => 'Escribir la fórmula aquí',
	'math_tip' => 'Fórmula matemática (LaTeX)',
	'prefs-math' => 'Fórmulas',
	'mw_math_png' => 'Renderizar siempre PNG',
	'mw_math_source' => 'Dejar como TeX (para navegadores de texto)',
	'math_failure' => 'No se pudo entender',
	'math_unknown_error' => 'error desconocido',
	'math_unknown_function' => 'función desconocida',
	'math_lexing_error' => 'error léxico',
	'math_syntax_error' => 'error de sintaxis',
	'math_image_error' => 'La conversión a PNG ha fallado; comprueba que latex, dvips, gs, y convert estén instalados correctamente',
	'math_bad_tmpdir' => 'No se puede escribir o crear el directorio temporal de <em>math</em>',
	'math_bad_output' => 'No se puede escribir o crear el directorio de salida de <em>math</em>',
	'math_notexvc' => 'Falta el ejecutable de <strong>texvc</strong>. Por favor, lea <em>math/README</em> para configurarlo.',
);

/** Estonian (Eesti)
 * @author KaidoKikkas
 * @author WikedKentaur
 */
$messages['et'] = array(
	'math_sample' => 'Sisesta valem siia',
	'math_tip' => 'Matemaatiline valem (LaTeX)',
	'prefs-math' => 'Valemite näitamine',
	'mw_math_png' => 'Alati PNG',
	'mw_math_source' => 'Säilitada TeX (tekstibrauserite puhul)',
	'math_failure' => 'Arusaamatu süntaks',
	'math_unknown_error' => 'Tundmatu viga',
	'math_unknown_function' => 'Tundmatu funktsioon',
	'math_lexing_error' => 'Väljalugemisviga',
	'math_syntax_error' => 'Süntaksiviga',
	'math_image_error' => "PNG konverteerimine ebaõnnestus;
kontrollige oma ''latex'', ''dvips'', ''gs'', ''convert'' installatsioonide korrektsust.",
	'math_bad_tmpdir' => 'Ajutise matemaatikakataloogi loomine või sinna kirjutamine ebaõnnestus',
	'math_bad_output' => 'Matemaatika-väljundkataloogi loomine või sinna kirjutamine ebaõnnestus',
	'math_notexvc' => 'Texvc-rakendus puudub; häälestamiseks vaata matemaatikakataloogist README-faili',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Bengoa
 */
$messages['eu'] = array(
	'math_sample' => 'Formula hemen idatzi',
	'math_tip' => 'Formula matematikoa (LaTeX)',
	'prefs-math' => 'Formulak',
	'mw_math_png' => 'Beti PNG irudiak sortu',
	'mw_math_source' => 'TeX bezala utzi (testu bidezko nabigatzaileentzako)',
	'math_failure' => 'Interpretazio errorea',
	'math_unknown_error' => 'errore ezezaguna',
	'math_unknown_function' => 'funtzio ezezaguna',
	'math_lexing_error' => 'errore lexikoa',
	'math_syntax_error' => 'sintaxi errorea',
	'math_image_error' => 'PNG bilakatze errorea; egiaztatu latex eta dvipng (edo dvips + gs + convert) ongi instalatuta dauden begiratu',
	'math_bad_tmpdir' => 'Ezin da math direktorio tenporala sortu edo bertan idatzi',
	'math_bad_output' => 'Ezin da math direktorioa sortu edo bertan idatzi',
	'math_notexvc' => 'texvc exekutagarria falta da; mesedez, ikus math/README konfiguratzeko.',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'math_sample' => 'Añiil la hórmula aquí',
	'math_tip' => 'Hórmula matemática (LaTeX)',
	'prefs-math' => 'Hórmulas',
	'mw_math_png' => 'Renderiçal sempri PNG',
	'mw_math_source' => 'Quealu cumu TeX (pa escrucaoris de testu)',
	'math_failure' => 'Nu es posibri entendel',
	'math_unknown_error' => 'marru andarriu',
	'math_unknown_function' => 'hunción andarria',
	'math_lexing_error' => 'marru lésicu',
	'math_syntax_error' => 'marru ena sintasis',
	'math_image_error' => 'Marru convirtiendu a PNG; compreba que latex, dvips, gs, i convert estén corretamenti istalaus',
	'math_bad_tmpdir' => 'Nu es posibri escribil u crial el diretoriu temporal de <em>math</em>',
	'math_bad_output' => 'Nu es posibri escribil u crial el diretoriu e salia e <em>math</em>',
	'math_notexvc' => 'Farta el ehecutabri e <strong>texvc</strong>; pol favol, lei <em>math/README</em> pa configuralu.',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'math_sample' => 'درج فرمول در اینجا',
	'math_tip' => 'فرمول ریاضی (LaTeX)',
	'prefs-math' => 'نمایش ریاضیات',
	'mw_math_png' => 'همیشه PNG کشیده شود',
	'mw_math_source' => 'در قالب TeX باقی بماند (برای مرورگرهای متنی)',
	'math_failure' => 'شکست در تجزیه',
	'math_unknown_error' => 'خطای ناشناخته',
	'math_unknown_function' => 'تابع ناشناختهٔ',
	'math_lexing_error' => 'خطای lexing',
	'math_syntax_error' => 'خطای نحوی',
	'math_image_error' => 'تبدیل به PNG شکست خورد؛ از نصب درست لاتکس و dvipng (یا dvips و gs و convert) اطمینان حاصل کنید',
	'math_bad_tmpdir' => 'امکان ایجاد یا نوشتن اطلاعات در پوشه موقت (temp) ریاضی وجود ندارد.',
	'math_bad_output' => 'امکان ایجاد یا نوشتن اطلاعات در پوشه خروجی (output) ریاضی وجود ندارد.',
	'math_notexvc' => 'برنامهٔ اجرایی texvc موجود نیست. برای اطلاعات بیشتر به <span dir=ltr>math/README</span> مراجعه کنید.',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Wix
 */
$messages['fi'] = array(
	'math_sample' => 'Lisää kaava tähän',
	'math_tip' => 'Matemaattinen kaava (LaTeX)',
	'prefs-math' => 'Matematiikka',
	'mw_math_png' => 'Näytä aina PNG:nä',
	'mw_math_source' => 'Näytä TeX-muodossa (tekstiselaimille)',
	'math_failure' => 'Jäsentäminen epäonnistui',
	'math_unknown_error' => 'Tuntematon virhe',
	'math_unknown_function' => 'Tuntematon funktio',
	'math_lexing_error' => 'Tulkintavirhe',
	'math_syntax_error' => 'Jäsennysvirhe',
	'math_image_error' => 'Muuntaminen PNG-tiedostomuotoon epäonnistui; tarkista, että latex ja dvipng (tai dvips, gs ja convert) on asennettu oikein.',
	'math_bad_tmpdir' => 'Matematiikan kirjoittaminen väliaikaishakemistoon tai tiedostonluonti ei onnistu',
	'math_bad_output' => 'Matematiikan tulostehakemistoon kirjoittaminen tai tiedostonluonti ei onnistu',
	'math_notexvc' => 'Texvc-sovellus puuttuu, lue math/READMEstä asennustietoja',
);

/** Faroese (Føroyskt)
 * @author Krun
 * @author Quackor
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'math_sample' => 'Set formil her',
	'math_tip' => 'Støddfrøðiligur formil (LaTeX)',
	'prefs-math' => 'Støddfrøðiligir formlar',
	'mw_math_png' => 'Vís altíð sum PNG',
	'mw_math_source' => 'Lat verða sum TeX (til tekstkagara)',
);

/** French (Français)
 * @author Gomoko
 * @author Peter17
 */
$messages['fr'] = array(
	'math-desc' => 'Rendre les formules mathématiques entre les balises <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Entrez votre formule ici',
	'math_tip' => 'Formule mathématique (LaTeX)',
	'prefs-math' => 'Rendu des maths',
	'mw_math_png' => 'Toujours produire une image PNG',
	'mw_math_source' => 'Laisser le code TeX original',
	'math_failure' => 'Erreur math',
	'math_unknown_error' => 'erreur indéterminée',
	'math_unknown_function' => 'fonction inconnue',
	'math_lexing_error' => 'erreur lexicale',
	'math_syntax_error' => 'erreur de syntaxe',
	'math_image_error' => 'La conversion en PNG a échoué ; vérifiez l’installation de latex et dvipng (ou dvips + gs + convert)',
	'math_bad_tmpdir' => 'Impossible de créer ou d’écrire dans le répertoire math temporaire',
	'math_bad_output' => 'Impossible de créer ou d’écrire dans le répertoire math de sortie',
	'math_notexvc' => 'L’exécutable « texvc » est introuvable. Lisez math/README pour le configurer.',
);

/** Cajun French (Français cadien)
 * @author RoyAlcatraz
 */
$messages['frc'] = array(
	'math_sample' => 'Mettez la formule ici',
	'math_tip' => "Formule d'arithmitique (LaTeX)",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'math_sample' => 'Buchiéd voutra formula ique',
	'math_tip' => 'Formula matèmatica (LaTeX)',
	'prefs-math' => 'Rendu de les formules matèmatiques',
	'mw_math_png' => 'Tojorn fâre una émâge PNG',
	'mw_math_source' => 'Lèssiér lo code TeX originâl',
	'math_failure' => 'Èrror d’analise sintaxica',
	'math_unknown_error' => 'èrror encognua',
	'math_unknown_function' => 'fonccion encognua',
	'math_lexing_error' => 'èrror lèxicâla',
	'math_syntax_error' => 'èrror de sintaxa',
	'math_image_error' => 'La convèrsion en PNG at pas reussia ; controlâd l’enstalacion de LaTeX et dvipng (ou ben dvips + gs + convert)',
	'math_bad_tmpdir' => 'Empossiblo d’ècrire dens ou ben de fâre lo rèpèrtouèro math temporèro',
	'math_bad_output' => 'Empossiblo d’ècrire dens ou ben de fâre lo rèpèrtouèro math de sortia',
	'math_notexvc' => 'L’ègzécutâblo « texvc » est entrovâblo.
Volyéd liére « math/README » por lo configurar.',
);

/** Northern Frisian (Nordfriisk)
 * @author Murma174
 * @author Pyt
 */
$messages['frr'] = array(
	'math_sample' => 'Formel heer önjfäige',
	'math_tip' => 'Matemaatisch formel (LaTex)',
	'prefs-math' => 'TeX',
);

/** Friulian (Furlan) */
$messages['fur'] = array(
	'math_sample' => 'Inserìs la formule culì',
	'math_tip' => 'Formule matematiche (LaTeX)',
	'prefs-math' => 'Matematiche',
	'mw_math_png' => 'Torne simpri PNG',
	'mw_math_source' => 'Lassile come TeX (par sgarfadôrs testuâi)',
);

/** Western Frisian (Frysk)
 * @author Pyt
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'math_sample' => 'Foechje hjir in formule yn',
	'math_tip' => 'Wiskundige formule (LaTeX)',
	'prefs-math' => 'Formules',
	'mw_math_png' => 'Altiten as PNG ôfbyldzje',
	'mw_math_source' => 'Lit de TeX ferzje stean (foar tekstblêders)',
	'math_failure' => 'Untsjutbere formule',
	'math_unknown_error' => 'Unbekinde fout',
	'math_unknown_function' => 'Unbekinde funksje',
	'math_lexing_error' => 'Unbekind wurd',
	'math_syntax_error' => 'Sinboufout',
	'math_image_error' => 'PNG-omsetting is mislearre.
Gean nei oft latex, dvips, en gs goed ynstallearre binne en set om',
	'math_bad_tmpdir' => 'De tydlike formulepad kin net skreaun of makke wêze.',
	'math_bad_output' => 'De formulepad kin net skreaun of makke wêze.',
	'math_notexvc' => 'It programma texvc net fûn; sjoch math/README te ynstallearjen.',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'math_sample' => 'Cuir foirmle isteach anseo',
	'math_tip' => 'Foirmle mhatamataice (LaTeX)',
	'prefs-math' => 'Matamaitice',
	'mw_math_png' => 'Déan PNG-íomhá gach uair',
	'mw_math_source' => 'Fág mar cló TeX (do teacsleitheoirí)',
	'math_failure' => 'Theip ó anailís na foirmle',
	'math_unknown_error' => 'earráid anaithnid',
	'math_unknown_function' => 'foirmle anaithnid',
	'math_lexing_error' => 'Theip ó anailís an fhoclóra',
	'math_syntax_error' => 'earráid comhréire',
	'math_image_error' => 'Theip ó aistriú an PNG; tástáil má tá na ríomh-oidis latex, dvips, gs, agus convert i suite go maith.',
	'math_bad_tmpdir' => 'Ní féidir scríobh chuig an fillteán mata sealadach, nó é a chruthú',
	'math_bad_output' => 'Ní féidir scríobh chuig an fillteán mata aschomhaid, nó é a chruthú',
	'math_notexvc' => 'Níl an ríomhchlár texvc ann; féach ar mata/EOLAIS chun é a sainathrú.',
);

/** Gagauz (Gagauz)
 * @author Cuman
 */
$messages['gag'] = array(
	'math_sample' => 'Matematik-formulanı-koyun',
	'math_tip' => 'Matematik formula (LaTeX formatında)',
);

/** Simplified Gan script (‪赣语(简体)‬) */
$messages['gan-hans'] = array(
	'math_sample' => '到个首扻入数学公式',
	'math_tip' => '数学公式 （LaTeX）',
	'prefs-math' => '数学公式',
	'mw_math_png' => '全部使用PNG图像',
	'mw_math_source' => '显示系TeX代码 （文字浏览器用）',
	'math_failure' => '分析失败',
	'math_unknown_error' => '未知错误',
	'math_unknown_function' => '未知函数',
	'math_lexing_error' => '句法错误',
	'math_syntax_error' => '文法错误',
	'math_image_error' => 'PNG转换失败；请检查系否装正嘞latex, dvips, gs同到convert',
	'math_bad_tmpdir' => '写伓正或建伓正数学公式临时目录',
	'math_bad_output' => '写伓正或建伓正数学公式输出目录',
	'math_notexvc' => '执行伓正"texvc"；请参看 math/README 再配置过。',
);

/** Traditional Gan script (‪贛語(繁體)‬) */
$messages['gan-hant'] = array(
	'math_sample' => '到箇首扻入數學公式',
	'math_tip' => '數學公式 （LaTeX）',
	'prefs-math' => '數學公式',
	'mw_math_png' => '全部使用PNG圖像',
	'mw_math_source' => '顯示係TeX代碼 （文字瀏覽器用）',
	'math_failure' => '分析失敗',
	'math_unknown_error' => '未知錯誤',
	'math_unknown_function' => '未知函數',
	'math_lexing_error' => '句法錯誤',
	'math_syntax_error' => '文法錯誤',
	'math_image_error' => 'PNG轉換失敗；請檢查係否裝正嘞latex, dvips, gs同到convert',
	'math_bad_tmpdir' => '寫伓正或建伓正數學公式臨時目錄',
	'math_bad_output' => '寫伓正或建伓正數學公式輸出目錄',
	'math_notexvc' => '執行伓正"texvc"；請參看 math/README 再配置過。',
);

/** Scottish Gaelic (Gàidhlig)
 * @author Akerbeltz
 */
$messages['gd'] = array(
	'math_sample' => 'Cuir a-steach foirmle an-seo',
	'math_tip' => 'Foirmle matamataig (LaTeX)',
	'math_unknown_error' => 'mearachd neo-aithnichte',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'math-desc' => 'Renderiza fórmulas matemáticas entre etiquetas <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Insira unha fórmula aquí',
	'math_tip' => 'Fórmula matemática (LaTeX)',
	'prefs-math' => 'Fórmulas matemáticas',
	'mw_math_png' => 'Orixinar sempre unha imaxe PNG',
	'mw_math_source' => 'Deixalo como TeX (para navegadores de texto)',
	'math_failure' => 'Fallou a conversión do código',
	'math_unknown_error' => 'erro descoñecido',
	'math_unknown_function' => 'función descoñecida',
	'math_lexing_error' => 'erro de léxico',
	'math_syntax_error' => 'erro de sintaxe',
	'math_image_error' => 'Fallou a conversión a PNG; comprobe que latex, dvips, gs e convert están ben instalados (ou dvips + gs + convert)',
	'math_bad_tmpdir' => 'Non se puido crear ou escribir no directorio temporal de fórmulas',
	'math_bad_output' => 'Non se puido crear ou escribir no directorio de saída de fórmulas',
	'math_notexvc' => 'Falta o executable texvc. Por favor consulte math/README para configurar.',
);

/** Guarani (Avañe'ẽ) */
$messages['gn'] = array(
	'math_tip' => 'Matemátika kuaareko (LaTeX)',
);

/** Gothic (Gothic)
 * @author Jocke Pirat
 */
$messages['got'] = array(
	'math_sample' => 'Lagjan formula her',
	'math_tip' => 'Maþemateikaleiks formula (LaTeX)',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Lefcant
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'math_sample' => 'Εἰσάγειν τύπον ὧδε',
	'math_tip' => 'Μαθηματικὸς τύπος (LaTeX)',
	'prefs-math' => 'Τὰ μαθηματικά',
	'mw_math_png' => 'Ἀπόδοσις PNG πάντοτε',
	'mw_math_source' => 'Ἄφες το ὡς TeX (διὰ τὰ πλοηγητήρια κειμένων)',
	'math_failure' => 'Λεξιανάλυσις ἀποτετυχηκυῖα',
	'math_unknown_error' => 'ἄγνωστον σφάλμα',
	'math_unknown_function' => 'ἄγνωστος ἐνέργεια',
	'math_lexing_error' => 'σφάλμα λεξικῆς ἀναλύσεως',
	'math_syntax_error' => 'σφάλμα συντάξεως',
	'math_image_error' => 'Ἡ PNG-μετατροπὴ ἀπετεύχθη·
ἔλεγξον τὴν ὀρθὴν ἐγκατάστασιν τῶν latex καὶ dvipng (ἢ dvips + gs + convert)',
	'math_bad_tmpdir' => 'Ἀδύνατος ἦτο ἡ ποίησις μαθηματικῶν δεδομένων ἢ ἡ ἐγγραφὴ ἐν προσκαίρῳ ἀρχειοκαταλόγῳ',
	'math_bad_output' => 'Ἀδύνατος ἦτο ἡ ποίησις μαθηματικῶν δεδομένων ἢ ἡ ἐγγραφὴ ἐν ἀρχειοκαταλόγῳ ἐξόδου',
	'math_notexvc' => 'Ἐλλεῖπον ἐκτελέσιμον texvc;
ἴδε math/README διὰ τὸ διαμορφοῦν.',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'math_sample' => 'Formel do yfüge',
	'math_tip' => 'Mathematisch Formel (LaTeX)',
	'prefs-math' => 'TeX',
	'mw_math_png' => 'Immer als PNG aazeige',
	'mw_math_source' => 'Als TeX la sy (für Tekschtbrowser)',
	'math_failure' => 'Parser-Fähler',
	'math_unknown_error' => 'Nit bekannte Fähler',
	'math_unknown_function' => 'Nit bekannti Funktion',
	'math_lexing_error' => "'Lexing'-Fähler",
	'math_syntax_error' => 'Syntaxfähler',
	'math_image_error' => 'D PNG-Konvertierig het nit funktioniert; prief di korrekt Installation vu LaTeX un dvipng (oder dvips + gs + convert)',
	'math_bad_tmpdir' => 'S temporär Verzeichnis fir mathematischi Formle cha nit aagleit oder bschribe wäre.',
	'math_bad_output' => 'S Ziilverzeichnis fir mathematischi Formle cha nit aagleit oder bschribe wäre.',
	'math_notexvc' => 'S texvc-Programm isch nit gfunde wore. Bitte acht gee uf math/README.',
);

/** Gujarati (ગુજરાતી)
 * @author Dsvyas
 * @author Mohit.dalal
 * @author Sushant savla
 */
$messages['gu'] = array(
	'math_sample' => 'સૂત્ર અહીં દાખલ કરો',
	'math_tip' => 'ગણિતિક સૂત્ર (LaTeX)',
	'prefs-math' => 'ગણિત',
	'mw_math_png' => 'PNG હંમેશા હાજર કરો',
	'mw_math_source' => 'આને TeX તરીકે રહેવા દો (ટેક્સ્ટ બ્રાઉઝરો માટે)',
	'math_failure' => 'પદચ્છેદ અસફળ',
	'math_unknown_error' => 'અજ્ઞાત ત્રુટિ',
	'math_unknown_function' => 'અજ્ઞાત કાર્ય',
	'math_lexing_error' => 'નિયમ ભંગ',
	'math_syntax_error' => 'સૂત્રલેખન ત્રુટિ',
	'math_image_error' => 'PNG રૂપાંતરણ નિષ્ફળ;  latex અને dvipng (or dvips + gs + convert)નું પ્રતિષ્ઠાપન બરાબર થયું છે કે નહી તે ચકાસો',
	'math_bad_tmpdir' => 'હંગામી ગણિત ડીરેક્ટરીમાં લખવું કે નવી બનાવવી શક્ય નથી',
	'math_bad_output' => 'ગણિત પરિણામ ડીરેક્ટરીમાં લખવું કે નવી બનાવવી શક્ય નથી',
	'math_notexvc' => 'ચલાવી શકાય તેવી texvc ગાયબ ; આને ચડાવવા math/README  જુઓ.',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'math_sample' => 'Cur formley stiagh ayns shoh',
	'math_tip' => 'Formley maddaghtoil (LaTeX)',
	'mw_math_png' => 'Jean PNG dagh ooilley hraa',
	'math_syntax_error' => 'Co-ordrail marranagh',
);

/** Hausa (هَوُسَ)
 * @author Mladanali
 */
$messages['ha'] = array(
	'math_sample' => 'Shigar da haɗi a nan',
	'math_tip' => 'Haɗin lissafi (LaTeX)',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'math_sample' => 'Chhai-chhṳ́chhap-ngi̍p sṳ-ho̍k kûng-sṳt',
	'math_tip' => 'Chhap-ngi̍p sṳ-ho̍k kûng-sṳt （LaTeX）',
	'prefs-math' => 'Sṳ-ho̍k kûng-sṳt',
	'mw_math_png' => 'Yún-yén sṳ́-yung PNG thù-chhiong',
	'mw_math_source' => 'Hién-sṳ TeX thoi-ho （sṳ́-yung vùn-sṳ hi-khí sṳ̀）',
	'math_failure' => 'Kié-sak sṳt-phai',
	'math_unknown_error' => 'Mò-tî chho-ngu',
	'math_unknown_function' => 'Mò-tî chhṳ-su',
	'math_lexing_error' => 'ki-fap chho-ngu',
	'math_syntax_error' => 'ngî-fap chho-ngu',
	'math_image_error' => 'PNG chón-von sṳt-phai; chhiáng kiám-chhà he-feu chṳn-khok ôn-chông latex, dvips, gs lâu convert',
	'math_bad_tmpdir' => 'Mò-fap siá-ngi̍p fe̍t-chá kien-li̍p su-ho̍k kûng-sṳt lìm-sṳ̀ muk-liu̍k',
	'math_bad_output' => 'Mò-fap siá-ngi̍p fe̍t-chá kien-li̍p su-ho̍k kûng-sṳt sû-chhut muk-liu̍k',
	'math_notexvc' => 'Mò-fap chṳp-hàng "texvc"; chhiáng chhâm-cheu math/README chin-hàng phi-chṳ.',
);

/** Hawaiian (Hawai`i)
 * @author Kolonahe
 * @author Singularity
 */
$messages['haw'] = array(
	'math_tip' => 'Ha‘ilula makemakika (LaTeX)',
	'prefs-math' => 'Makemakika',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'math_sample' => 'formula',
	'math_tip' => 'נוסחה מתמטית (LaTeX)',
	'prefs-math' => 'נוסחאות מתמטיות',
	'mw_math_png' => 'תמיד להציג כ־PNG',
	'mw_math_source' => 'להשאיר כקוד TeX (לדפדפני טקסט)',
	'math_failure' => 'עיבוד הנוסחה נכשל',
	'math_unknown_error' => 'שגיאה לא ידועה',
	'math_unknown_function' => 'פונקציה לא מוכרת',
	'math_lexing_error' => 'שגיאת לקסינג',
	'math_syntax_error' => 'שגיאת תחביר',
	'math_image_error' => 'ההמרה ל־PNG נכשלה; אנא בדקו אם התקנתם נכון את latex ואת dvipng (או צירוף של dvips‏, gs ו־convert)',
	'math_bad_tmpdir' => 'התוכנה לא הצליחה לכתוב או ליצור את הספרייה הזמנית של המתמטיקה',
	'math_bad_output' => 'התוכנה לא הצליחה לכתוב או ליצור את ספריית הפלט של המתמטיקה',
	'math_notexvc' => 'קובץ בר־ביצוע של texvc אינו זמין; אנא צפו בקובץ math/README למידע על ההגדרות.',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author आलोक
 */
$messages['hi'] = array(
	'math_sample' => 'गणितीय सूत्र यहाँ डालें',
	'math_tip' => 'गणितीय सूत्र (लेटेक्स)',
	'prefs-math' => 'गणित',
	'mw_math_png' => 'हमेशा PNG बनायें',
	'mw_math_source' => 'उसे TeX ही रखियें (पाठ ब्राउज़र के लिये)',
	'math_failure' => 'पार्स नहीं कर पायें',
	'math_unknown_error' => 'अपरिचीत समस्या',
	'math_unknown_function' => 'अज्ञात कार्य',
	'math_lexing_error' => 'लेक्सींग समस्या',
	'math_syntax_error' => 'सिन्टैक्स गलती',
	'math_image_error' => 'PNG में रुपांतरण अयशस्वी;
latex, dvips, gs, और convert के इन्स्टॉलेशन की जाँच करें',
	'math_bad_tmpdir' => 'मैथ अस्थायी डाइरेक्टरी या तो बना नहीं सकतें या फिर उसमें लिख नहीं सकतें',
	'math_bad_output' => 'मैथ आउटपुट डाइरेक्टरी या तो बना नहीं सकतें या फिर उसमें लिख नहीं सकतें',
	'math_notexvc' => 'texvc एक्झीक्यूटेबल फ़ाईल मिल नहीं रहीं;
समनुरूप बनाने के लियें math/README देखें।',
);

/** Fiji Hindi (Latin script) (Fiji Hindi)
 * @author Girmitya
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'math_sample' => 'Hian pe formula insert karo',
	'math_tip' => 'Mathematiical niyam (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'PNG ke sab time render karo',
	'mw_math_source' => 'TeX ke rakam chhorr do (text browsers ke khatir)',
	'math_failure' => 'Parse nai kare sakaa',
	'math_unknown_error' => 'galti ke nai samajhta',
	'math_unknown_function' => 'nai samajhta ki ii kon chij khatir hai',
	'math_lexing_error' => 'lexing me galti',
	'math_syntax_error' => 'syntax me galti',
	'math_image_error' => 'PNG conversion fail hoe gais; latex, dvips aur gs ke correct installation ke check kar ke convert convert karo',
	'math_bad_tmpdir' => 'Math temporary directory nai banae sakta hai',
	'math_bad_output' => 'Math output directory me likhe nai to banae nai sakta hai',
	'math_notexvc' => 'Texvc executable nai hai;
Configure kare khatir meharbani kar ke math/README ke dekho.',
);

/** Hiligaynon (Ilonggo)
 * @author Tagimata
 */
$messages['hil'] = array(
	'math_sample' => 'Ibutang ang pormula diri',
	'math_tip' => 'Math pormula (LaTeX)',
);

/** Croatian (Hrvatski)
 * @author Herr Mlinka
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'math_sample' => 'Ovdje unesi formulu',
	'math_tip' => 'Matematička formula (LaTeX)',
	'prefs-math' => 'Prikaz matematičkih formula',
	'mw_math_png' => 'Uvijek kao PNG',
	'mw_math_source' => 'Ostavi u formatu TeX (za tekstualne preglednike)',
	'math_failure' => 'Obrada nije uspjela.',
	'math_unknown_error' => 'nepoznata pogreška',
	'math_unknown_function' => 'nepoznata funkcija',
	'math_lexing_error' => 'rječnička pogreška (lexing error)',
	'math_syntax_error' => 'sintaksna pogreška',
	'math_image_error' => 'Pretvorba u PNG nije uspjela; provjerite jesu li dobro instalirani latex, dvips, gs, i convert',
	'math_bad_tmpdir' => 'Ne mogu otvoriti ili pisati u privremeni direktorij za matematiku',
	'math_bad_output' => 'Ne mogu otvoriti ili pisati u odredišni direktorij za matematiku',
	'math_notexvc' => 'Nedostaje izvršna datoteka texvc-a; pogledajte math/README za postavke.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'math-desc' => 'Přidawa matematiske formle mjez tafličkomaj <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Zasuń tu formulu',
	'math_tip' => 'Matematiska formula (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'Přeco jako PNG zwobraznić',
	'mw_math_source' => 'Jako TeX wostajić (za tekstowe wobhladowaki)',
	'math_failure' => 'Analyza njeje so poradźiła',
	'math_unknown_error' => 'njeznaty zmylk',
	'math_unknown_function' => 'njeznata funkcija',
	'math_lexing_error' => 'leksikalny zmylk',
	'math_syntax_error' => 'syntaktiski zmylk',
	'math_image_error' => 'Konwertowanje do PNG zwrěšćiło; kontroluj prawu instalaciju latex a dvipng (abo dvips + gs + konwertuj)',
	'math_bad_tmpdir' => 'Njemóžno do nachwilneho matematiskeho zapisa pisać abo jón wutworić',
	'math_bad_output' => 'Njemóžno do matematiskeho zapisa za wudaće pisać abo jón wutworić',
	'math_notexvc' => 'Wuwjedźomny texvc pobrachuje; prošu hlej math/README za konfiguraciju.',
);

/** Haitian (Kreyòl ayisyen)
 * @author Masterches
 */
$messages['ht'] = array(
	'math_sample' => 'Antre fòmil ou an isit',
	'math_tip' => 'Fòmil matematik (LaTeX)',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'math_sample' => 'Ide írd a képletet',
	'math_tip' => 'Matematikai képlet (LaTeX)',
	'prefs-math' => 'Képletek',
	'mw_math_png' => 'Mindig készítsen PNG-t',
	'mw_math_source' => 'Hagyja TeX formában (szöveges böngészőknek)',
	'math_failure' => 'Értelmezés sikertelen',
	'math_unknown_error' => 'ismeretlen hiba',
	'math_unknown_function' => 'ismeretlen függvény',
	'math_lexing_error' => 'lexikai hiba',
	'math_syntax_error' => 'formai hiba',
	'math_image_error' => 'PNG-vé alakítás sikertelen; ellenőrizd, hogy a latex és dvipng (vagy dvips + gs + convert) helyesen van-e telepítve',
	'math_bad_tmpdir' => 'Nem írható vagy nem hozható létre a matematikai ideiglenes könyvtár',
	'math_bad_output' => 'Nem lehet létrehozni vagy írni a matematikai függvények kimeneti könyvtárába',
	'math_notexvc' => 'HIányzó texvc végrehajtható fájl; a beállítást lásd a math/README fájlban.',
);

/** Armenian (Հայերեն)
 * @author Chaojoker
 * @author Teak
 * @author Xelgen
 */
$messages['hy'] = array(
	'math_sample' => 'Գրեք բանաձևը այստեղ',
	'math_tip' => 'Մաթեմատիկական բանաձև (LaTeX)',
	'prefs-math' => 'Մաթեմատիկական բանաձևեր',
	'mw_math_png' => 'Միշտ դարձնել PNG',
	'mw_math_source' => 'Թողնել որպես ТеХ (տեքստային բրաուզերների համար)',
	'math_failure' => 'Չհաջողվեց վերլուծել',
	'math_unknown_error' => 'անհայտ սխալ',
	'math_unknown_function' => 'անհայտ ֆունկցիա',
	'math_lexing_error' => 'բառական սխալ',
	'math_syntax_error' => 'շարահյուսության սխալ',
	'math_image_error' => 'PNG վերածումը ձախողվեց. ստուգեք latex, dvips, gs և convert ծրագրերի տեղադրման ճշտությունը։',
	'math_bad_tmpdir' => 'Չի հաջողվում ստեղծել կամ գրել մաթեմատիկայի ժամանակավոր թղթապանակին։',
	'math_bad_output' => 'Չի հաջողվում ստեղծել կամ գրել մաթեմատիկայի արտածման թղթապանակին',
	'math_notexvc' => 'Կատարման texvc նիշքը չի գտնվել։ Տեսեք math/README՝ կարգավորման համար։',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'math-desc' => 'Visualisar formulas mathematic inter etiquettas <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Inserer formula hic',
	'math_tip' => 'Formula mathematic (LaTeX)',
	'prefs-math' => 'Mathematica',
	'mw_math_png' => 'Sempre producer PNG',
	'mw_math_source' => 'Lassa lo como TeX (pro navigatores in modo texto)',
	'math_failure' => 'Error durante le analyse del syntaxe',
	'math_unknown_error' => 'error incognite',
	'math_unknown_function' => 'function incognite',
	'math_lexing_error' => 'error lexic',
	'math_syntax_error' => 'error de syntaxe',
	'math_image_error' => 'Le conversion in PNG ha fallite;
verifica le installation del programmas \'\'latex" e "dvipng" (o "dvips" + "gs" + \'\'convert\'\').',
	'math_bad_tmpdir' => 'Non pote scriber in o crear le directorio temporari "math".',
	'math_bad_output' => 'Non pote scriber in o crear le directorio de output "math".',
	'math_notexvc' => "Le executabile ''texvc'' manca;
per favor vide math/README pro configurar lo.",
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'math_sample' => 'Masukkan rumus di sini',
	'math_tip' => 'Rumus matematika (LaTeX)',
	'prefs-math' => 'Matematika',
	'mw_math_png' => 'Selalu buat PNG',
	'mw_math_source' => 'Biarkan sebagai TeX (untuk penjelajah web teks)',
	'math_failure' => 'Gagal memparse',
	'math_unknown_error' => 'Kesalahan yang tidak diketahui',
	'math_unknown_function' => 'fungsi yang tidak diketahui',
	'math_lexing_error' => 'kesalahan lexing',
	'math_syntax_error' => 'kesalahan sintaks',
	'math_image_error' => 'Konversi PNG gagal; periksa apakah latex dan dvips (atau dvips + gs + convert) terinstal dengan benar',
	'math_bad_tmpdir' => 'Tidak dapat menulisi atau membuat direktori sementara math',
	'math_bad_output' => 'Tidak dapat menulisi atau membuat direktori keluaran math',
	'math_notexvc' => 'Executable texvc hilang; silakan lihat math/README untuk cara konfigurasi.',
);

/** Interlingue (Interlingue)
 * @author Renan
 */
$messages['ie'] = array(
	'math_tip' => 'Formul mathematical (LaTeX)',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'math_sample' => 'Tinyé zùbe ómárí ngá',
	'math_tip' => 'Ihe ọtùtù ọmúmú-ónúọgụgụ (LaTeX)',
	'prefs-math' => 'Ọmúmú-ónúọgụgụ',
);

/** Eastern Canadian (Aboriginal syllabics) (ᐃᓄᒃᑎᑐᑦ) */
$messages['ike-cans'] = array(
	'math_unknown_error' => 'ᑐᓴᐅᒪᔭᐅᙱᑐᖅ ᑕᒻᒪᓇᖅᑐᖅ',
	'math_unknown_function' => 'ᑐᓴᐅᒪᔭᐅᙱᑐᖅ ᐃᓕᐅᕐᓂᖅ',
);

/** Eastern Canadian (Latin script) (inuktitut) */
$messages['ike-latn'] = array(
	'math_unknown_error' => 'tusaumajaunngituq tammanaqtuq',
	'math_unknown_function' => 'tusaumajaunngituq iliurniq',
);

/** Iloko (Ilokano)
 * @author Saluyot
 */
$messages['ilo'] = array(
	'math_sample' => 'Isulbong ti formula ditoy',
	'math_tip' => 'Matematikal a formula (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'Kanayon a pagbalinen a PNG',
	'mw_math_source' => 'Ibati lattan a kas TeX (para kadagiti text browsers)',
	'math_failure' => 'Napaay nga ag-parse',
	'math_unknown_error' => 'di ammo a biddut',
	'math_unknown_function' => 'di ammo a function',
	'math_lexing_error' => 'lexing error',
	'math_syntax_error' => 'biddut iti syntax',
	'math_image_error' => 'Napaay ti PNG conversion;
itsek ti husto a panangikapet iti latex, dvips, gs, samo i-convert',
);

/** Ido (Ido)
 * @author Lakaoso
 * @author Malafaya
 */
$messages['io'] = array(
	'math_sample' => 'Insertez formulo hike',
	'math_tip' => 'Formulo matematika (LaTeX)',
	'prefs-math' => 'Quale montrar la formuli',
	'math_unknown_error' => 'nekonocata eroro',
	'math_bad_tmpdir' => 'Onu ne povas skribar o krear la tempala matematikala arkivaro',
	'math_bad_output' => 'Onu ne povas skribar o krear la arkivaro por la matematiko',
);

/** Icelandic (Íslenska)
 * @author Krun
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'math_sample' => 'Sláið inn formúlu hér',
	'math_tip' => 'Stærðfræðiformúla (LaTeX)',
	'prefs-math' => 'Stærðfræðiformúlur',
	'mw_math_png' => 'Alltaf birta PNG mynd',
	'mw_math_source' => 'Sýna TeX jöfnu (fyrir textavafra)',
	'math_failure' => 'Þáttun mistókst',
	'math_unknown_error' => 'óþekkt villa',
	'math_unknown_function' => 'óþekkt virkni',
	'math_lexing_error' => 'lestrarvilla',
	'math_syntax_error' => 'málfræðivilla',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'math-desc' => 'Esegue il rendering di formule matematiche tra i tag <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Inserire qui la formula',
	'math_tip' => 'Formula matematica (LaTeX)',
	'prefs-math' => 'Formule matematiche',
	'mw_math_png' => 'Mostra sempre in PNG',
	'mw_math_source' => 'Lascia in formato TeX (per browser testuali)',
	'math_failure' => 'Errore del parser',
	'math_unknown_error' => 'errore sconosciuto',
	'math_unknown_function' => 'funzione sconosciuta',
	'math_lexing_error' => 'errore lessicale',
	'math_syntax_error' => 'errore di sintassi',
	'math_image_error' => 'Conversione in PNG non riuscita; verificare che siano correttamente installati i seguenti programmi: latex e dvipng (o dvips, gs e convert).',
	'math_bad_tmpdir' => 'Impossibile scrivere o creare la directory temporanea per math',
	'math_bad_output' => 'Impossibile scrivere o creare la directory di output per math',
	'math_notexvc' => 'Eseguibile texvc mancante; per favore consultare math/README per la configurazione.',
);

/** Japanese (日本語)
 * @author Ohgi
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'math_sample' => 'ここに数式を挿入',
	'math_tip' => '数式 (LaTeX)',
	'prefs-math' => '数式',
	'mw_math_png' => '常にPNGで描画',
	'mw_math_source' => 'TeXのまま（テキストブラウザー向け）',
	'math_failure' => '構文解析失敗',
	'math_unknown_error' => '不明なエラー',
	'math_unknown_function' => '不明な関数',
	'math_lexing_error' => '字句解析エラー',
	'math_syntax_error' => '構文エラー',
	'math_image_error' => 'PNGへの変換に失敗しました。dvipng（もしくはdvipsとgsとconvert）およびlatexが正しくインストールされているか確認してください。',
	'math_bad_tmpdir' => '数式一時ディレクトリーへの書き込みまたは作成ができません',
	'math_bad_output' => '数式一時ディレクトリーへの書き込みまたは作成ができません',
	'math_notexvc' => 'texvcの実行可能ファイルが見つかりません。math/READMEを読んで設定してください。',
);

/** Jamaican Creole English (Patois)
 * @author Yocahuna
 */
$messages['jam'] = array(
	'math_sample' => 'Insoert faamiula yaso',
	'math_tip' => 'Matimatikal faamiula (LaTeX)',
);

/** Jutish (Jysk)
 * @author Ælsån
 */
$messages['jut'] = array(
	'math_sample' => 'Endsæt åpstælsel her (LaTeX)',
	'math_tip' => 'Matematisk åpstælsel (LaTeX)',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'math_sample' => 'Lebokna rumus ing kéné',
	'math_tip' => 'Rumus matematika (LaTeX)',
	'prefs-math' => 'Matématika',
	'mw_math_png' => 'Mesthi nggawé PNG',
	'mw_math_source' => 'Dijarna waé minangka TeX (kanggo panjlajah wèb tèks)',
	'math_failure' => 'Gagal nglakoni parse',
	'math_unknown_error' => 'Kaluputan sing ora dimangertèni',
	'math_unknown_function' => 'fungsi sing ora dimangertèni',
	'math_lexing_error' => "kaluputan ''lexing''",
	'math_syntax_error' => "''syntax error'' (kaluputan sintaksis)",
	'math_image_error' => 'Konversi PNG gagal; priksa apa latex, dvips, gs, lan convert wis diinstalasi sing bener',
	'math_bad_tmpdir' => 'Ora bisa nulis utawa nggawé dirèktori sauntara math',
	'math_bad_output' => 'Ora bisa nulis utawa nggawé dirèktori paweton math',
	'math_notexvc' => 'Executable texvc ilang;
mangga delengen math/README kanggo cara konfigurasi.',
);

/** Georgian (ქართული)
 * @author Alsandro
 * @author David1010
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'math_sample' => 'ჩასვით ფორმულა აქ',
	'math_tip' => 'მათემატიკური ფორმულა (LaTeX)',
	'prefs-math' => 'მათემატიკა',
	'mw_math_png' => 'მუდამ გამოიყენე PNG',
	'mw_math_source' => 'დატოვე როგორც TeX (ტექსტური ბრაუზერებისთვის)',
	'math_failure' => 'შეუძლებელია გამონათქვამის გარჩევაშ',
	'math_unknown_error' => 'უცნობი შეცდომა',
	'math_unknown_function' => 'უცნობი ფუნქცია',
	'math_lexing_error' => 'ლექსიკური შეცდომა',
	'math_syntax_error' => 'სინტაქსი არასწორია',
	'math_image_error' => 'PNG-ში გარდაქმნისას წარმოიშვა შეცდომა; შეამოწმეთ latex, dvips, gs და convert-ის დაყენების სისწორე',
	'math_bad_tmpdir' => 'შეუძლებელია ჩანაწერის შექმნა მათემატიკურ დროებით კატალოგში',
	'math_bad_output' => 'შეუძლებელია შექმნა ან ჩაწერა მათემატიკურ გამსვლელ კატალოგში',
	'math_notexvc' => 'შემსრულებელი ფაილი texvc არ არის ნაპოვნი; იხ.math/README ინფორმაციისთვის.',
);

/** Kara-Kalpak (Qaraqalpaqsha)
 * @author Atabek
 * @author Jiemurat
 */
$messages['kaa'] = array(
	'math_sample' => "Usı jerge formulanı jazın'",
	'math_tip' => 'Matematik formula (LaTeX)',
	'prefs-math' => 'Formulalar',
	'math_unknown_error' => "belgisiz qa'telik",
	'math_unknown_function' => 'belgisiz funktsiya',
	'math_lexing_error' => "leksikalıq qa'telik",
	'math_syntax_error' => "sintaksikalıq qa'telik",
);

/** Kabyle (Taqbaylit)
 * @author Agurzil
 */
$messages['kab'] = array(
	'math_sample' => 'Ssekcem tasemselt dagi',
	'math_tip' => 'Tasemselt tusnakt (LaTeX)',
	'prefs-math' => 'Tusnakt',
	'mw_math_png' => 'Daymen err-it PNG',
	'mw_math_source' => 'Eǧǧ-it s TeX (i browsers/explorateurs n weḍris)',
	'math_failure' => 'Agul n tusnakt',
	'math_unknown_error' => 'Agul mačči d aḍahri',
	'math_unknown_function' => 'Tawuri mačči d taḍahrit',
	'math_lexing_error' => 'Agul n tmawalt',
	'math_syntax_error' => 'Agul n tseddast',
	'math_image_error' => 'Abeddil ɣer PNG yexser; ssenqed installation n latex, dvips, gs, umbeɛd eg abeddel',
	'math_bad_tmpdir' => 'Ur yezmir ara ad yaru ɣef/ɣer tusnakt n temp directory/dossier',
	'math_bad_output' => 'Ur yezmir ara ad yaru ɣef/ɣer tusnakt n tuffɣa directory/dossier',
	'math_notexvc' => "''texvc executable'' / ''executable texvc'' ulac-it; ẓer math/README akken a textareḍ isemyifiyen.",
);

/** Адыгэбзэ (Адыгэбзэ)
 * @author Bogups
 * @author Тамэ Балъкъэрхэ
 */
$messages['kbd-cyrl'] = array(
	'math_sample' => 'Мыбдеж формулэ итхэ',
	'math_tip' => 'Математикэм тещIыхьауэ формулэ (LaTeX)',
	'prefs-math' => 'формулэхэр гъэлъэгъуэн',
);

/** Khowar (کھوار)
 * @author Rachitrali
 */
$messages['khw'] = array(
	'math_sample' => 'فارمولو ھیارا درج کورے',
	'math_tip' => ' ریاضیاتی صیغہ (LaTeX)',
);

/** Kirmanjki (Kırmancki)
 * @author Mirzali
 */
$messages['kiu'] = array(
	'math_sample' => 'İta formuli cıke',
	'math_tip' => 'Formulê matematiki (formatê LaTeXi de)',
	'prefs-math' => 'Mat',
	'math_failure' => 'Analiz de xeta',
	'math_unknown_error' => 'xeta nêzanaiye',
	'math_unknown_function' => 'fonksiyono nêzanae',
	'math_lexing_error' => 'xeta grameri',
	'math_syntax_error' => 'xeta cumla',
	'math_image_error' => "Werênaisê ''PNG''y de xeta biye;
enstale-kerdena ''latex'', ''dvips'', ''gs'', u ''convert''i qontrol ke",
	'math_bad_tmpdir' => "Sıma nêşikinê indeksê ''math temp''i de bınusê ya ki bıafernê",
	'math_bad_output' => 'Sıma nêşikinê indeksê formulunê matematiki de bınusê ya ki bıafernê',
	'math_notexvc' => "''Texvc''o gurênae çino;
Serba areze-kerdene qaytê ''math/README''y ke.",
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'math_sample' => 'ورنەكتى مىندا ەنگىزىڭىز',
	'math_tip' => 'ماتەماتىيكا ورنەگى (LaTeX)',
	'prefs-math' => 'ورنەكتەر',
	'mw_math_png' => 'ارقاشان PNG پىشىنىمەن كورسەتكىز',
	'mw_math_source' => 'بۇنى TeX پىشىمىندە قالدىر (ماتىندىك شولعىشتارعا)',
	'math_failure' => 'قۇرىلىمىن تالداتۋى ٴساتسىز ٴبىتتى',
	'math_unknown_error' => 'بەلگىسىز قاتە',
	'math_unknown_function' => 'بەلگىسىز جەتە',
	'math_lexing_error' => 'ٴسوز كەنىنىڭ قاتەسى',
	'math_syntax_error' => 'سويلەم جۇيەسىنىڭ قاتەسى',
	'math_image_error' => 'PNG اۋدارىسى ٴساتسىز ٴبىتتى;
latex, dvips, gs جانە convert باعدارلامالارىنىڭ دۇرىس ورناتۋىن تەكسەرىپ شىعىڭىز',
	'math_bad_tmpdir' => 'math دەگەن ۋاقىتشا قالتاسىنا جازىلمادى, نە قالتا قۇرىلمادى',
	'math_bad_output' => 'math دەگەن بەرىس قالتاسىنا جازىلمادى, نە قالتا قۇرىلمادى',
	'math_notexvc' => 'texvc اتقارىلمالىسى تابىلمادى;
باپتاۋ ٴۇشىن math/README قۇجاتىن قاراڭىز.',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'math_sample' => 'Өрнекті мында енгізіңіз',
	'math_tip' => 'Математика өрнегі (LaTeX)',
	'prefs-math' => 'Өрнектер',
	'mw_math_png' => 'Әрқашан PNG пішінімен көрсеткіз',
	'mw_math_source' => 'Бұны TeX пішімінде қалдыр (мәтіндік шолғыштарға)',
	'math_failure' => 'Құрылымын талдатуы сәтсіз бітті',
	'math_unknown_error' => 'белгісіз қате',
	'math_unknown_function' => 'белгісіз жете',
	'math_lexing_error' => 'сөз кенінің қатесі',
	'math_syntax_error' => 'сөйлем жүйесінің қатесі',
	'math_image_error' => 'PNG аударысы сәтсіз бітті;
latex, dvips, gs және convert бағдарламаларының дұрыс орнатуын тексеріп шығыңыз',
	'math_bad_tmpdir' => 'math деген уақытша қалтасына жазылмады, не қалта құрылмады',
	'math_bad_output' => 'math деген беріс қалтасына жазылмады, не қалта құрылмады',
	'math_notexvc' => 'texvc атқарылмалысы табылмады;
баптау үшін math/README құжатын қараңыз.',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'math_sample' => 'Örnekti mında engiziñiz',
	'math_tip' => 'Matematïka örnegi (LaTeX)',
	'prefs-math' => 'Örnekter',
	'mw_math_png' => 'Ärqaşan PNG pişinimen körsetkiz',
	'mw_math_source' => 'Bunı TeX pişiminde qaldır (mätindik şolğıştarğa)',
	'math_failure' => 'Qurılımın taldatwı sätsiz bitti',
	'math_unknown_error' => 'belgisiz qate',
	'math_unknown_function' => 'belgisiz jete',
	'math_lexing_error' => 'söz keniniñ qatesi',
	'math_syntax_error' => 'söýlem jüýesiniñ qatesi',
	'math_image_error' => 'PNG awdarısı sätsiz bitti;
latex, dvips, gs jäne convert bağdarlamalarınıñ durıs ornatwın tekserip şığıñız',
	'math_bad_tmpdir' => 'math degen waqıtşa qaltasına jazılmadı, ne qalta qurılmadı',
	'math_bad_output' => 'math degen beris qaltasına jazılmadı, ne qalta qurılmadı',
	'math_notexvc' => 'texvc atqarılmalısı tabılmadı;
baptaw üşin math/README qujatın qarañız.',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'math_sample' => 'បញ្ចូលរូបមន្ត​នៅទីនេះ',
	'math_tip' => 'រូបមន្ត​គណិតវិទ្យា (LaTeX)',
	'prefs-math' => 'គណិត',
	'mw_math_png' => 'ជានិច្ចការជាPNG',
	'mw_math_source' => 'ទុកឱ្យនៅជា TeX (ចំពោះឧបករណ៍រាវរកអត្ថបទ)',
	'math_failure' => 'បរាជ័យ​ក្នុង​ការ​ញែក​ចេញ​',
	'math_unknown_error' => 'កំហុសមិនស្គាល់',
	'math_unknown_function' => 'អនុគមន៍​មិន​ស្គាល់',
	'math_lexing_error' => 'បញ្ហាក្នុងការអានតួអក្សរ',
	'math_syntax_error' => 'កំហុសពាក្យសម្ព័ន្ធ',
	'math_image_error' => 'ការបម្លែងជា PNG បានបរាជ័យ។
សូមពិនិត្យមើលតើ latex និង dvips (ឬ dvips + gs + convert), បានដំឡើងត្រឹមត្រូវឬអត់',
	'math_bad_tmpdir' => 'មិនអាចសរសេរទៅ ឬ បង្កើតថតឯកសារគណិតបណ្តោះអាសន្ន',
	'math_bad_output' => 'មិនអាច សរសេរទៅ ឬ បង្កើត ថតឯកសារ គណិត ទិន្នផល',
	'math_notexvc' => 'បាត់កម្មវិធី texvc។

សូមមើលក្នុង math/README ដើម្បីធ្វើការកំណត់លំអិត។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Shushruth
 */
$messages['kn'] = array(
	'math_sample' => 'ಇಲ್ಲಿ ಸೂತ್ರವನ್ನು ಅಳವಡಿಸಿ',
	'math_tip' => 'ಗಣಿತ ಸೂತ್ರ (LaTeX)',
	'prefs-math' => 'ಗಣಿತ',
	'mw_math_png' => 'ಯಾವಾಗಲೂ PNG ಪ್ರಕಾರ ತೋರಿಸು',
	'math_unknown_error' => 'ತಿಳಿದಿಲ್ಲದ ದೋಷ',
	'math_image_error' => 'PNGಗೆ ಬದಲಾವಣೆ ವಿಫಲವಾಯಿತು;
latex, dvips, gs, ಸರಿಯಾಗಿ ಸ್ಥಾಪಿತವಾಗಿದೆಯೆ ಎಂದು ಖಾತ್ರಿ ಮಾಡಿ ಬದಲಾಯಿಸಿ',
);

/** Korean (한국어)
 * @author IRTC1015
 * @author Klutzy
 * @author Kwj2772
 * @author PuzzletChung
 */
$messages['ko'] = array(
	'math-desc' => '<code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code> 태그 사이에 수학 수식을 표시함',
	'math_sample' => '여기에 수식을 쓰세요',
	'math_tip' => '수식(LaTeX)',
	'prefs-math' => '수식',
	'mw_math_png' => '항상 PNG로 표시',
	'mw_math_source' => 'TeX로 남겨둠 (텍스트 브라우저용)',
	'math_failure' => '해석 실패',
	'math_unknown_error' => '알 수 없는 오류',
	'math_unknown_function' => '알 수 없는 함수',
	'math_lexing_error' => '어휘 오류',
	'math_syntax_error' => '구문 오류',
	'math_image_error' => 'PNG 변환 실패 - latex, dvipng(혹은 dvips, gs, convert)가 올바르게 설치되어 있는지 확인해 주세요.',
	'math_bad_tmpdir' => '수식을 임시 폴더에 저장하거나 폴더를 만들 수 없습니다.',
	'math_bad_output' => '수식을 출력 폴더에 저장하거나 폴더를 만들 수 없습니다.',
	'math_notexvc' => '실행할 수 있는 texvc이 없습니다. 설정을 위해 math/README를 읽어 주세요.',
);

/** Komi-Permyak (Перем Коми)
 * @author Yufereff
 */
$messages['koi'] = array(
	'math_sample' => 'Пырт татчö формула',
	'math_tip' => 'Математикаись формула',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 * @author Къарачайлы
 */
$messages['krc'] = array(
	'math_sample' => 'Формуланы бери салыгъыз',
	'math_tip' => 'Математика формула (LaTeX формат)',
	'prefs-math' => 'Математика белгиле',
	'mw_math_png' => 'PNG сурат форматха кёчюргенлей тур',
	'mw_math_source' => 'Тюрлендирмей TeX болуб къой (текст браузерле ючюн)',
	'math_failure' => 'Ангылашынамады',
	'math_unknown_error' => 'билинмеген халат',
	'math_unknown_function' => 'билинмеген функция',
	'math_lexing_error' => 'лексика халат',
	'math_syntax_error' => 'синтаксис халат',
	'math_image_error' => 'PNG конвертация джетишимсиз болду; latex бла dvips джарашдырыуларына къарагъыз (неда dvips + gs + convert)',
	'math_bad_tmpdir' => 'Математиканы кёзюулю каталогуна не джазаргъа, неда къураргъа мадар джокъду',
	'math_bad_output' => 'Математиканы чыгъыш каталогуна не джазар, неда къурар мадар джокъду',
	'math_notexvc' => 'texvc файл табылмайды; джарашдырыр ючюн math/README-ге къара.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'math_sample' => 'Heh schriev de Formel en „LaTeX“ Forrem eren',
	'math_tip' => 'En mathematisch Formel',
	'prefs-math' => 'Mathematisch Formele',
	'mw_math_png' => 'Immer nor PNG aanzeije',
	'mw_math_source' => 'Lohß et als TeX (jod för de Tex-Brausere)',
	'math_failure' => 'Fähler vum Parser',
	'math_unknown_error' => 'Fähler, dä mer nit kenne',
	'math_unknown_function' => 'en Funktion, die mer nit kenne',
	'math_lexing_error' => 'Fähler beim Lexing',
	'math_syntax_error' => 'Fähler en de Syntax',
	'math_image_error' => 'Dat Ömwandele noh PNG es donevve jejange. Dun ens noh de richtije Enstallation luure bei <code lang="en">latex</code> un <code lang="en">dvips</code>, udder bei <code lang="en">dvips</code>, un <code lang="en">gs</code>, un <code lang="en">convert</code>.',
	'math_bad_tmpdir' => 'Dat Zwescheverzeichnis för de mathematische Formele lööt sich nit aanläje oder nix eren schrieve. Dat es Dress. Sag et enem Wiki-Köbes oder enem ẞööver-Minsch.',
	'math_bad_output' => 'Dat Verzeichnis för de mathematische Formele lööt sich nit aanläje oder mer kann nix eren schrieve. Dat es Dress. Sag et enem Wiki-Köbes oder enem ẞööver-Minsch.',
	'math_notexvc' => 'Dat Projamm <code>texvc</code> haM_mer nit jefunge.
Sag et enemWiki-Köbes, enem ẞööver-Minsch, oder luur ens en dä
<code>math/README</code>.',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author Bangin
 */
$messages['ku-latn'] = array(
	'math_sample' => 'Kurteristê matêmatîk li vir binivisîne',
	'math_tip' => 'Kurteristê matêmatîk (LaTeX)',
	'prefs-math' => 'TeX',
	'mw_math_png' => 'Her caran wek PNG nîşanbide',
	'mw_math_source' => "Wek TeX bêle (ji browser'ên gotaran ra)",
	'math_unknown_error' => 'şaşbûnekî nezanîn',
	'math_image_error' => 'Wêşandana PNG nemeşî',
);

/** Cornish (Kernowek)
 * @author Kw-Moon
 */
$messages['kw'] = array(
	'math_sample' => 'Keworrewgh an furvel obma',
	'math_tip' => 'Furvel galcoriethek (LaTeX)',
);

/** Kirghiz (Кыргызча) */
$messages['ky'] = array(
	'math_unknown_error' => 'белгисиз ката',
);

/** Latin (Latina)
 * @author Omnipaedista
 */
$messages['la'] = array(
	'math_sample' => 'Hic inscribe formulam',
	'math_tip' => 'Formula mathematica (LaTeX)',
	'prefs-math' => 'Interpretatio artis mathematicae',
	'mw_math_png' => 'Semper vertere PNG',
	'mw_math_source' => 'Stet ut TeX (pro navigatri texti)',
	'math_failure' => 'Excutare non potest',
	'math_unknown_error' => 'error ignotus',
	'math_unknown_function' => 'functio ignota',
	'math_lexing_error' => 'erratum lexicale',
	'math_syntax_error' => 'erratum syntaxis',
);

/** Ladino (Ladino)
 * @author Universal Life
 */
$messages['lad'] = array(
	'math_sample' => 'Escribe aquí una formula',
	'math_tip' => 'Fórmula matemática (LaTeX)',
	'prefs-math' => 'Fórmulas',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'math_sample' => 'Formel hei asetzen',
	'math_tip' => 'Mathematesch Formel (LaTeX)',
	'prefs-math' => 'Math/TeX',
	'mw_math_png' => 'Ëmmer als PNG duerstellen',
	'mw_math_source' => 'Als TeX loossen (fir Textbrowser)',
	'math_failure' => 'Parser-Feeler',
	'math_unknown_error' => 'Onbekannte Feeler',
	'math_unknown_function' => 'Onbekannte Funktioun',
	'math_lexing_error' => "'Lexing'-Feeler",
	'math_syntax_error' => 'Syntaxfeeler',
	'math_image_error' => "D'PNG-Konvertéierung huet net fonctionnéiert;
iwwerpréift déi korrekt Installatioun vu LaTeX an dvipng (oder dvips + gs + convert)",
	'math_bad_tmpdir' => 'Den temporäre Repertire fir mathematesch Formele kann net ugeluecht ginn oder et kann näischt do gespäichert ginn.',
	'math_bad_output' => 'Den Zilrepertoire fir mathematesch Formele kann net ugeluecht ginn oder et kann näischt do gespäichert ginn.',
	'math_notexvc' => 'Den texvc Programm feelt: Liest w.e.g. math/README fir en anzestellen.',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Cgboeree
 */
$messages['lfn'] = array(
	'math_sample' => 'Introdui formula asi',
	'math_tip' => 'Formula matematical (LaTeX)',
	'prefs-math' => 'Matematica',
);

/** Ganda (Luganda)
 * @author Kizito
 */
$messages['lg'] = array(
	'math_sample' => 'Wandika wano fomula yo',
	'math_tip' => "Bw'onyiga wano, ofuna w'osobolera okuwandika fomula ey'okubala. Okugiwandika, olina okukozesa empandika ey'enkola ya LaTeX.",
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'math_sample' => 'Veur de formule in',
	'math_tip' => 'Wiskóndige formule (LaTeX)',
	'prefs-math' => 'Mattemetik rendere',
	'mw_math_png' => 'Ummer PNG rendere',
	'mw_math_source' => 'Laot de TeX code sjtaon (vuur tèksbrowsers)',
	'math_failure' => 'Parse misluk',
	'math_unknown_error' => 'onbekènde fout',
	'math_unknown_function' => 'onbekènde functie',
	'math_lexing_error' => 'lexicografische fout',
	'math_syntax_error' => 'fout vanne syntax',
	'math_image_error' => 'PNG-conversie is mislök. Gank nao of LaTeX en dvipng (of dvips + gs + convert) korrek geïnstalleerd zien.',
	'math_bad_tmpdir' => 'De map veur tiedelike bestenj veur wiskóndige formules bestuit neet of kin neet gemaak waere',
	'math_bad_output' => 'Kin neet sjrieve nao de output directory veur mattematik',
	'math_notexvc' => "Kin 't programma texvc neet vinje; stel alles in volges de besjrieving in math/README.",
);

/** Ligure (Ligure)
 * @author ZeneizeForesto
 */
$messages['lij'] = array(
	'math_sample' => 'Inserî a formûla chì',
	'math_tip' => 'Fórmûla matemattica (LaTeX)',
);

/** Līvõ kēļ (Līvõ kēļ)
 * @author Warbola
 */
$messages['liv'] = array(
	'math_sample' => 'Kēratigid formula tǟnõ',
	'math_tip' => 'Matemātili formula (LaTeX)',
);

/** Lumbaart (Lumbaart)
 * @author Insübrich
 */
$messages['lmo'] = array(
	'math_sample' => 'Met dent una furmula chì',
	'math_tip' => 'Furmula matematega (LaTeX)',
	'prefs-math' => 'Matem',
	'mw_math_png' => 'Trasfurmá sempər in PNG',
	'mw_math_source' => 'Lassá in furmaa TeX (pər i prugráma də navigazziún dumá in furmaa da testu)',
);

/** Lao (ລາວ)
 * @author Tuinui
 */
$messages['lo'] = array(
	'math_sample' => 'ໃສ່ສູດຢູ່ນີ້',
	'math_tip' => 'ສູດຄະນິດສາດ (LaTeX)',
	'prefs-math' => 'ຄະນິດສາດ',
	'math_syntax_error' => 'ຜິດຫຼັກໄວຍະກອນ',
);

/** Lozi (Silozi)
 * @author Ooswesthoesbes
 */
$messages['loz'] = array(
	'math_sample' => 'Sebu di fomula',
	'math_tip' => 'Fomula di mat (LaTeX)',
	'prefs-math' => 'Mat',
);

/** Lithuanian (Lietuvių)
 * @author Perkunas
 */
$messages['lt'] = array(
	'math_sample' => 'Įveskite formulę',
	'math_tip' => 'Matematinė formulė (LaTeX formatu)',
	'prefs-math' => 'Matematika',
	'mw_math_png' => 'Visada formuoti PNG',
	'mw_math_source' => 'Palikti TeX formatą (tekstinėms naršyklėms)',
	'math_failure' => 'Nepavyko apdoroti',
	'math_unknown_error' => 'nežinoma klaida',
	'math_unknown_function' => 'nežinoma funkcija',
	'math_lexing_error' => 'leksikos klaida',
	'math_syntax_error' => 'sintaksės klaida',
	'math_image_error' => 'PNG konvertavimas nepavyko; patikrinkite, ar teisingai įdiegta latex ir dvipng (arba dvips, gs ir convert)',
	'math_bad_tmpdir' => 'Nepavyksta sukurti arba rašyti į matematikos laikinąjį aplanką',
	'math_bad_output' => 'Nepavyksta sukurti arba rašyti į matematikos išvesties aplanką',
	'math_notexvc' => 'Trūksta texvc vykdomojo failo; pažiūrėkite math/README kaip konfigūruoti.',
);

/** Latgalian (Latgaļu)
 * @author Jureits
 */
$messages['ltg'] = array(
	'math_sample' => 'Formulu īrokst ite',
	'math_tip' => 'Matematiska formula (LaTeX)',
);

/** Latvian (Latviešu)
 * @author Marozols
 * @author Yyy
 */
$messages['lv'] = array(
	'math_sample' => 'Šeit ievieto formulu',
	'math_tip' => 'Matemātikas formula (LaTeX)',
	'prefs-math' => 'Formulas',
	'mw_math_png' => 'Vienmēr attēlot PNG',
	'mw_math_source' => 'Saglabāt kā TeX (teksta pārlūkiem)',
	'math_failure' => 'Pārsēšanas kļūda',
	'math_unknown_error' => 'nezināma kļūda',
	'math_unknown_function' => 'nezināma funkcija',
	'math_lexing_error' => 'leksikas kļūda',
	'math_syntax_error' => 'sintakses kļūda',
	'math_image_error' => 'Kļūda konvertējot uz PNG formātu;
pārbaudi vai ir korekti uzinstalēti latex, dvips, gs, un convert',
);

/** Literary Chinese (文言) */
$messages['lzh'] = array(
	'math_sample' => '此書方程式',
	'math_tip' => '數學方程式（LaTeX）',
	'prefs-math' => '數學',
	'mw_math_png' => '屢作PNG',
	'mw_math_source' => 'TeX依舊，純文覽器適也。',
	'math_failure' => '譯不成',
	'math_unknown_error' => '未知之誤',
	'math_unknown_function' => '未知函式',
	'math_lexing_error' => '律有誤',
	'math_syntax_error' => '語法有誤',
	'math_image_error' => 'PNG 轉敗之；查已裝 latex, dvipng（或dvips + gs + convert）乎',
	'math_bad_tmpdir' => '無寫或建數式臨目',
	'math_bad_output' => '無寫或建數式出目',
	'math_notexvc' => '少「texvc」；參 math/README 置之。',
);

/** Lazuri (Lazuri)
 * @author Bombola
 */
$messages['lzz'] = array(
	'math_sample' => 'Matematʼikuri-ifade-doçʼarit',
	'math_tip' => 'Matʼematʼikuri formuli (LaTeX)',
);

/** Maithili (मैथिली)
 * @author Ggajendra
 * @author Vinitutpal
 */
$messages['mai'] = array(
	'math_sample' => 'सूत्र समाहित करू',
	'math_tip' => 'गणितीय सूत्र (LaTeX)',
	'prefs-math' => 'गणित',
);

/** Moksha (Мокшень)
 * @author Jarmanj Turtash
 * @author Kranch
 * @author Numulunj pilgae
 */
$messages['mdf'] = array(
	'math_sample' => 'Сувафтомс тязк формула',
	'math_tip' => 'Математиконь формула (LaTeX)',
	'prefs-math' => 'Няфтемс формулат',
	'mw_math_png' => 'Фалу ладямс PNG',
	'mw_math_source' => 'Катк тянь кода TeX (текстонь вальманди)',
	'math_failure' => 'Аф морафтови',
	'math_unknown_error' => 'аф содаф эльбятькс',
	'math_unknown_function' => 'аф содаф функцие',
	'math_lexing_error' => 'лексиконь эльбятькс',
	'math_syntax_error' => 'синтаксонь эльбятькс',
	'math_image_error' => 'PNG форматс сёрматфтомась изь лисев; ватт лац эли аф арафтовсть latex, dvips, gs эди convert',
	'math_bad_tmpdir' => 'Аф сёрматфтови ётконь математик директориес эди директориесь аф тиеви',
	'math_bad_output' => 'Аф сёрматфтови нолдамань математик директориес эди директориесь аф тиеви',
	'math_notexvc' => 'Нолдамань файл texvc изь мув; Ванк math/README ладямать колга.',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'math_sample' => 'Atsofohy eto ny raikipohy',
	'math_tip' => 'Raikipohy matematika (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => 'Anamboary sary PNG foana',
	'mw_math_source' => "
Avelao ho TeX (ho an'ny navigateurs textes)",
	'math_failure' => 'Tsy nety ny fanodinana ny raikipohy',
	'math_unknown_error' => 'tsy fahatomombanana tsy hay antony',
	'math_unknown_function' => 'fonction tsy fantatra',
	'math_lexing_error' => 'fahadisoana ara-teny',
	'math_syntax_error' => 'Misy diso ny raikipohy',
	'math_image_error' => 'Tsy voavadika ho PNG; hamarino fa mety voapetraka tsara ny rindrankajy latex, dvips, gs ary convert',
	'math_bad_tmpdir' => "Tsy afaka namorona na nanoratra répertoire vonjimaika ho an'ny matematika",
	'math_bad_output' => "Tsy afaka namorona na nanoratra tao amin'ny répertoire hampiasain'ny asa matematika",
	'math_notexvc' => 'Tsy hita ny rindrankajy texvc; azafady jereo math/README hanamboarana azy.',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'math_sample' => 'Формулым тышке шынде',
	'math_tip' => 'Математик формул (LaTeX)',
	'prefs-math' => 'Формуло-влак',
	'mw_math_png' => 'Эре PNG-ым генерироватлаш',
	'mw_math_source' => 'TeX-ым разметкыште кодаш (текст браузер-влаклан)',
);

/** Minangkabau (Baso Minangkabau)
 * @author VoteITP
 */
$messages['min'] = array(
	'math_sample' => 'Masuakkan rumus di siko',
	'math_tip' => 'Rumus matematika (LaTeX)',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'math-desc' => 'Испис на математички формули помеѓу ознаките <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Овде вметни формула',
	'math_tip' => 'Математичка формула (LaTeX)',
	'prefs-math' => 'Матем. формули',
	'mw_math_png' => 'Секогаш исцртувај во PNG',
	'mw_math_source' => 'Остави го како TeX (за текстуални прелистувачи)',
	'math_failure' => 'Не можев да парсирам',
	'math_unknown_error' => 'непозната грешка',
	'math_unknown_function' => 'непозната функција',
	'math_lexing_error' => 'лексичка грешка',
	'math_syntax_error' => 'синтаксна грешка',
	'math_image_error' => 'Претворањето во PNG не успеа. Проверете дали правилно ги имате инсталирано latex и dvipng (или dvips + gs + convert)',
	'math_bad_tmpdir' => 'Не можам да запишам во или да создадам привремен директориум за математички операции',
	'math_bad_output' => 'Не можев да запишам во или создадам излезен директориум математички операции',
	'math_notexvc' => 'Недостасува извршната податотека texvc;
погледнете math/README за нејзино нагодување.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Sadik Khalid
 * @author Shijualex
 */
$messages['ml'] = array(
	'math-desc' => '<code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code> റ്റാഗുകൾക്കുള്ളിൽ നൽകുന്ന ഗണിതശാസ്ത്ര സൂത്രവാക്യങ്ങൾ പ്രദർശിപ്പിക്കൽ',
	'math_sample' => 'ഇവിടെ സൂത്രവാക്യം ചേർക്കുക',
	'math_tip' => 'ഗണിതസൂത്രവാക്യം (LaTeX)',
	'prefs-math' => 'സമവാക്യം',
	'mw_math_png' => 'എപ്പോഴും PNG ആയി പ്രദർശിപ്പിക്കുക',
	'mw_math_source' => 'TeX ആയി തന്നെ പ്രദർശിപ്പിക്കുക (ടെക്സ്റ്റ് ബ്രൗസറുകൾക്ക്)',
	'math_failure' => 'പാഴ്സ് ചെയ്യൽ പരാജയപ്പെട്ടു',
	'math_unknown_error' => 'അപരിചിതമായ പിഴവ്',
	'math_unknown_function' => 'അജ്ഞാതമായ ഫങ്ങ്ഷൻ',
	'math_lexing_error' => 'ലെക്സിങ് പിഴവ്',
	'math_syntax_error' => 'തെറ്റായ പദവിന്യാസം',
	'math_image_error' => 'PNG രൂപത്തിലേയ്ക്കുള്ള മാറ്റം പരാജയപ്പെട്ടു;
latex, dvips,എന്നിവ ശരിയായാണോ ഇൻസ്റ്റോൾ ചെയ്തിരിക്കുന്നതെന്നു പരിശോധിക്കുക (അഥവാ dvips + gs +convert)',
	'math_bad_tmpdir' => 'math temp ഡയറക്ടറി ഉണ്ടാക്കാനോ അതിലേക്കു എഴുതാനോ സാധിച്ചില്ല',
	'math_bad_output' => 'math output ഡയറക്ടറി ഉണ്ടാക്കാനോ അതിലേക്കു എഴുതാനോ സാധിച്ചില്ല',
	'math_notexvc' => 'പ്രവർത്തനസജ്ജമായ texvc ലഭ്യമല്ല;
സജ്ജീകരിച്ചെടുക്കാനുള്ള സഹായത്തിനു ദയവായി math/README കാണുക.',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'math_sample' => 'Энд томъёогоо оруулна уу',
	'math_tip' => 'Математикийн томъёо （LaTeX）',
	'prefs-math' => 'Томъёонууд',
	'mw_math_png' => 'Байнга PNG болго',
	'mw_math_source' => 'TeX хэвээр үлдээх （текстэн броузеруудад）',
	'math_failure' => 'Задлан ялгал хийж чадсангүй',
	'math_unknown_error' => 'үл мэдэгдэх алдаа',
	'math_unknown_function' => 'үл мэдэгдэх функц',
	'math_lexing_error' => 'лекслэхэд алдаа гарлаа',
	'math_syntax_error' => 'синтаксийн алдаа',
	'math_image_error' => 'PNG руух хувиргал амжилтгүй боллоо;
latex, dvips, gs, convert-г зөв суулгасан эсэхийг шалгана уу',
	'math_bad_tmpdir' => 'Математикийн түр зуурын каталогыг үүсгэх, эсвэл түүн руу хуулж чадсангүй',
	'math_bad_output' => 'Математикийн гадагшлуулах каталогыг үүсгэх, эсвэл түүн руу хуулж чадсангүй',
	'math_notexvc' => 'texvc программ олдохгүй байна;
math/README-г уншиж тохируулна уу.',
);

/** Moldavian (Молдовеняскэ)
 * @author Node ue
 */
$messages['mo'] = array(
	'math_sample' => 'Интроду формула аичь',
	'math_tip' => 'Формулэ математикэ (LaTeX)',
);

/** Marathi (मराठी)
 * @author Htt
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'math_sample' => 'इथे सूत्र लिहा',
	'math_tip' => 'गणितीय सूत्र (LaTeX)',
	'prefs-math' => 'गणित',
	'mw_math_png' => 'नेहमीच पीएनजी (PNG) रेखाटा',
	'mw_math_source' => '(टेक्स्ट विचरकांकरिता)त्यास TeX म्हणून सोडून द्या',
	'math_failure' => 'पृथक्करणात अयशस्वी',
	'math_unknown_error' => 'अपरिचित त्रूटी',
	'math_unknown_function' => 'अज्ञात कार्य',
	'math_lexing_error' => 'लेक्झींग(कोशीय?)त्रूटी',
	'math_syntax_error' => 'आज्ञावली-विन्यास त्रूटी',
	'math_image_error' => 'पीएनजी रुपांतर अयशस्वी; लॅटेक्स, डीव्हीप्स, जीएसची  स्थापना योग्य झाली आहे काय ते तपासा आणि बदल करा',
	'math_bad_tmpdir' => '"गणितीय तूर्त धारिके"(math temp directory)ची  निर्मीती करू शकत नाही अथवा "मॅथ तूर्त धारिकेत" लिहू शकत नाही .',
	'math_bad_output' => 'गणितीय प्राप्त धारिकेची( math output directory) निर्मीती अथवा त्यात लेखन करू शकत नाही.',
	'math_notexvc' => 'texvcकरणी(texvc एक्झिक्यूटेबल)चूकमुकली आहे;कृपया,सज्जीत करण्याकरिता math/README पहा.',
);

/** Hill Mari (Кырык мары)
 * @author Amdf
 */
$messages['mrj'] = array(
	'math_sample' => 'Тишкӹ формулым шӹндӹдӓ',
	'math_tip' => 'Математика формула (формат LaTeX)',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author CoolCityCat
 * @author Kurniasan
 */
$messages['ms'] = array(
	'math-desc' => 'Mengolah rumus-rumus matematik antara teg-teg <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>',
	'math_sample' => 'Masukkan rumus di sini',
	'math_tip' => 'Rumus matematik (LaTeX)',
	'prefs-math' => 'Matematik',
	'mw_math_png' => 'Sentiasa lakar PNG',
	'mw_math_source' => 'Biarkan sebagai TeX (untuk pelayar teks)',
	'math_failure' => 'Gagal menghurai',
	'math_unknown_error' => 'ralat yang tidak dikenali',
	'math_unknown_function' => 'fungsi yang tidak dikenali',
	'math_lexing_error' => "ralat ''lexing''",
	'math_syntax_error' => 'ralat sintaks',
	'math_image_error' => 'Penukaran PNG gagal; periksa sama ada latex dan dvipng (atau dvips + gs + convert) telah dipasang dengan betul',
	'math_bad_tmpdir' => 'Direktori temp matematik tidak boleh ditulis atau dicipta',
	'math_bad_output' => 'Direktori output matematik tidak boleh ditulis atau dicipta',
	'math_notexvc' => 'Atur cara texvc hilang; sila lihat fail math/README untuk maklumat konfigurasi.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Giangian15
 */
$messages['mt'] = array(
	'math_sample' => 'Daħħal formula hawnhekk',
	'math_tip' => 'Formula matematika (LaTeX)',
	'prefs-math' => 'Formuli matematiċi',
	'mw_math_png' => "Uri dejjem f'PNG",
	'mw_math_source' => "Ħallija bħala TeX (għal browsers ta' test)",
	'math_failure' => "Problema fil-''parser''",
	'math_unknown_error' => 'Problema mhux magħrufa',
	'math_unknown_function' => 'funżjoni mhux magħrufa',
	'math_lexing_error' => 'żball lessikali',
	'math_syntax_error' => 'żball fis-sintassi',
	'math_image_error' => "Konverżjoni għal PNG falliet; iċċekkja għall-installazzjoni tajba ta' latex jew dvipng (jew dvips, gs u convert).",
	'math_bad_tmpdir' => "Impossibli tikteb jew toħloq direttorju temporanju għal ''math''",
	'math_bad_output' => "Impossibli tikteb jew toħloq direttorju tal-''output'' tal-''math''",
	'math_notexvc' => "Esekuzzjoni ''texvc'' nieqes; jekk jogħġbok konsultà ''math/README'' għal konfigurazzjoni.",
);

/** Mirandese (Mirandés)
 * @author Cecílio
 * @author MCruz
 */
$messages['mwl'] = array(
	'math_sample' => 'Poner fórmula eiqui',
	'math_tip' => 'Fórmula matemática (LaTeX)',
	'prefs-math' => 'Matemática',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Hintha
 * @author Lionslayer
 */
$messages['my'] = array(
	'math_sample' => 'ဤနေရာတွင် သင်္ချာပုံသေနည်း သုံးရန်',
	'math_tip' => 'သင်္ချာပုံသေနည်း (LaTeX)',
	'prefs-math' => 'သင်္ချာ',
	'mw_math_png' => 'PNG ဖိုင်အဖြစ် အမြဲပုံဖော်ရန်',
	'mw_math_source' => 'TeX အဖြစ်ထားခဲ့ပါ (စာသားသာပြသည့် ဘရောက်ဇာများအတွက်)',
	'math_unknown_error' => 'အမည်မသိ အမှား',
	'math_unknown_function' => 'အမည်မသိ ဖန်ရှင်',
);

/** Erzya (Эрзянь)
 * @author Amdf
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'math_sample' => 'Совавтомс тезэнь хвормула',
	'math_tip' => 'Математикань хвормула (LaTeX)',
	'prefs-math' => 'Математика',
	'mw_math_source' => 'Кадык TeX хорматсо (текст вальмас)',
	'math_failure' => 'А ловнови',
	'math_unknown_error' => 'апак содань ильведькс',
	'math_unknown_function' => 'апак содань функция',
	'math_lexing_error' => 'лексиконь манявкс',
	'math_syntax_error' => 'синтаксонь ильведевкс',
);

/** Mazanderani (مازِرونی)
 * @author Ali1986
 */
$messages['mzn'] = array(
	'math_sample' => 'فورمـول ره ایجـه دأکـه‌ن',
	'math_tip' => 'ریاضی فورمول',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'math_sample' => 'Xihcuiloa nicān',
	'math_tip' => 'Tlapōhualmatiliztlahtōl (LaTeX)',
	'prefs-math' => 'Tlapōhualmatiliztli',
);

/** Min Nan Chinese (Bân-lâm-gú)
 * @author Ianbu
 */
$messages['nan'] = array(
	'math_sample' => 'Chia siá hong-thêng-sek',
	'math_tip' => '數學的公式 （LaTeX）',
	'prefs-math' => 'Sò·-ha̍k ê rendering',
	'mw_math_png' => 'Tiāⁿ-tio̍h iōng PNG render',
	'mw_math_source' => 'Î-chhî TeX ê keh-sek (khah ha̍h bûn-jī-sek ê liû-lám-khì)',
	'math_failure' => '解析失敗',
	'math_unknown_error' => '毋知啥物錯誤',
	'math_unknown_function' => '毋知啥物函數',
	'math_lexing_error' => '句法錯誤',
	'math_syntax_error' => '語法錯誤',
	'math_image_error' => 'PNG 轉換失敗；請檢查看有正確安裝 latex, dvipng（或dvips + gs + convert）無？',
	'math_bad_tmpdir' => '無法度寫入抑是建立數學公式的臨時目錄',
	'math_bad_output' => '無法度寫入抑是建立數學公式的輸出目錄',
	'math_notexvc' => '無看"texvc"執行檔案；請看 math/README 做配置',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 * @author Stigmj
 */
$messages['nb'] = array(
	'math_sample' => 'Sett inn formel her',
	'math_tip' => 'Matematisk formel (LaTeX)',
	'prefs-math' => 'Matteformler',
	'mw_math_png' => 'Vis alltid som PNG',
	'mw_math_source' => 'Behold som TeX (for tekst-nettlesere)',
	'math_failure' => 'Feil i matematikken',
	'math_unknown_error' => 'ukjent feil',
	'math_unknown_function' => 'ukjent funksjon',
	'math_lexing_error' => 'lexerfeil',
	'math_syntax_error' => 'syntaksfeil',
	'math_image_error' => 'PNG-konversjon mislyktes; sjekk at latex og dvipng (eller dvips + gs + convert) er korrekt installert',
	'math_bad_tmpdir' => 'Kan ikke skrive til eller opprette midlertidig mappe',
	'math_bad_output' => 'Kan ikke skrive til eller opprette resultatmappe',
	'math_notexvc' => 'Mangler kjørbar texvc;
se math/README for oppsett.',
);

/** Low German (Plattdüütsch) */
$messages['nds'] = array(
	'math_sample' => 'Formel hier infögen',
	'math_tip' => 'Mathematsche Formel (LaTeX)',
	'prefs-math' => 'TeX',
	'mw_math_png' => 'Jümmer as PNG dorstellen',
	'mw_math_source' => 'As TeX laten (för Textbrowser)',
	'math_failure' => 'Parser-Fehler',
	'math_unknown_error' => 'Unbekannten Fehler',
	'math_unknown_function' => 'Unbekannte Funktschoon',
	'math_lexing_error' => "'Lexing'-Fehler",
	'math_syntax_error' => 'Syntaxfehler',
	'math_image_error' => 'dat Konverteren na PNG harr keen Spood.',
	'math_bad_tmpdir' => 'Kann dat Temporärverteken för mathematsche Formeln nich anleggen oder beschrieven.',
	'math_bad_output' => 'Kann dat Teelverteken för mathematsche Formeln nich anleggen oder beschrieven.',
	'math_notexvc' => 'Dat texvc-Programm kann nich funnen warrn. Kiek ok math/README.',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'math_sample' => 'a^2 + b^2 = c^2',
	'math_tip' => 'Wiskundige formule (in LaTeX)',
	'prefs-math' => 'Wiskundige formules',
	'mw_math_png' => 'Altied as PNG weergeven',
	'mw_math_source' => 'Laot TeX-bronkode staon (veur tekstblaojeraars)',
	'math_failure' => 'Wiskundige formule niet begriepelik',
	'math_unknown_error' => 'Onbekende fout in formule',
	'math_unknown_function' => 'Onbekende funksie in formule',
	'math_lexing_error' => 'Lexikografiese fout in formule',
	'math_syntax_error' => 'Syntaktiese fout in formule',
	'math_image_error' => 'De PNG-umzetting is mislokt. Kiek even nao of LaTeX en dvipng (of dvips + gs + convert) wel goed eïnstalleerd bin.',
	'math_bad_tmpdir' => 'De map veur tiedelike bestaanden veur wiskundige formules besteet niet of is kan niet an-emaakt wörden.',
	'math_bad_output' => 'De map veur wiskundebestaanden besteet niet of is niet an te maken.',
	'math_notexvc' => 'Kan t programma texvc niet vienen; configureer volgens de beschrieving in math/README.',
);

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author Bhawani Gautam Rhk
 * @author सरोज कुमार ढकाल
 */
$messages['ne'] = array(
	'math_sample' => 'सूत्र यहाँ थप्नुहोस्',
	'math_tip' => 'गणितीय सूत्र (LaTeX)',
	'prefs-math' => 'गणित',
	'mw_math_png' => 'जहिले  PNG खोल्ने',
	'mw_math_source' => 'यसलाई TeX को रुपमा  छोड्ने(पाठ प्रदर्शको लागि)',
	'math_failure' => 'पढ्न सकिएन',
	'math_unknown_error' => 'अज्ञात समस्या',
	'math_unknown_function' => 'अज्ञात निर्देशन',
	'math_lexing_error' => 'वर्ण(lexing) त्रुटी',
	'math_syntax_error' => 'सूत्र (syntax) त्रुटि',
);

/** Newari (नेपाल भाषा) */
$messages['new'] = array(
	'prefs-math' => 'गणित',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'math-desc' => 'Wiskundige formules tussen <code>&lt;math&gt;</code> ... <code>&lt;/math&gt;</code>-tags weergeven',
	'math_sample' => 'Voer de formule in',
	'math_tip' => 'Wiskundige formule (in LaTeX)',
	'prefs-math' => 'Formules',
	'mw_math_png' => 'Altijd als PNG weergeven',
	'mw_math_source' => 'De TeX-broncode behouden (voor tekstbrowsers)',
	'math_failure' => 'Parsen mislukt',
	'math_unknown_error' => 'onbekende fout',
	'math_unknown_function' => 'onbekende functie',
	'math_lexing_error' => 'lexicografische fout',
	'math_syntax_error' => 'syntactische fout',
	'math_image_error' => 'De PNG-omzetting is mislukt. Controleer of LaTeX en dvipng (of dvips + gs + convert) correct zijn geïnstalleerd.',
	'math_bad_tmpdir' => 'De map voor tijdelijke bestanden voor wiskundige formules bestaat niet of kan niet gemaakt worden',
	'math_bad_output' => 'De map voor bestanden met wiskundige formules bestaat niet of kan niet gemaakt worden.',
	'math_notexvc' => 'Kan het programma texvc niet vinden; stel alles in volgens de beschrijving in math/README.',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'math_sample' => 'Skriv formel her',
	'math_tip' => 'Matematisk formel (LaTeX)',
	'prefs-math' => 'Matematiske formlar',
	'mw_math_png' => 'Vis alltid som PNG',
	'mw_math_source' => 'Behald som TeX (for tekst-nettlesarar)',
	'math_failure' => 'Klarte ikkje å tolke formelen',
	'math_unknown_error' => 'ukjend feil',
	'math_unknown_function' => 'ukjend funksjon',
	'math_lexing_error' => 'lexerfeil',
	'math_syntax_error' => 'syntaksfeil',
	'math_image_error' => 'PNG-konverteringa var mislukka; sjekk at latex og dvipng (eller dvips + gs + convert) er rett installerte',
	'math_bad_tmpdir' => 'Kan ikkje skrive til eller laga mellombels mattemappe',
	'math_bad_output' => 'Kan ikkje skrive til eller laga mattemappe',
	'math_notexvc' => 'Manglar texvc-program; sjå math/README for konfigurasjon.',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'math_sample' => "Lokela ''formula'' mo",
	'math_tip' => 'Formula ya dipalo (LaTeX)',
	'math_unknown_error' => 'Phošo ya gose tsebege',
	'math_syntax_error' => 'phošo ya popafoko',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'math_sample' => 'Picatz vòstra formula aicí',
	'math_tip' => 'Formula matematica (LaTeX)',
	'prefs-math' => 'Rendut de las matas',
	'mw_math_png' => 'Totjorn produire un imatge PNG',
	'mw_math_source' => "Daissar lo còde TeX d'origina",
	'math_failure' => 'Error matas',
	'math_unknown_error' => 'error indeterminada',
	'math_unknown_function' => 'foncion desconeguda',
	'math_lexing_error' => 'error lexicala',
	'math_syntax_error' => 'error de sintaxi',
	'math_image_error' => 'La conversion en PNG a pas capitat ; verificatz l’installacion de Latex, dvips, gs e convert',
	'math_bad_tmpdir' => 'Impossible de crear o d’escriure dins lo repertòri math temporari',
	'math_bad_output' => 'Impossible de crear o d’escriure dins lo repertòri math de sortida',
	'math_notexvc' => 'L’executable « texvc » es introbable. Legissètz math/README per lo configurar.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'math_sample' => 'ଏଠି ଫରମୁଲା ପୁରାଅ',
	'math_tip' => 'ଗାଣିତିକ ସୁତର (ଲାଟେକ୍ସ)',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'math_sample' => 'Ныффысс формулæ',
	'math_tip' => 'Математикон формулæ (формат LaTeX)',
	'math_unknown_function' => 'нæзонгæ функци',
	'math_syntax_error' => 'синтаксисы рæдыд',
);

/** Punjabi (ਪੰਜਾਬੀ) */
$messages['pa'] = array(
	'math_tip' => 'ਗਣਿਤ ਫਾਰਮੂਲਾ (LaTeX)',
	'prefs-math' => 'ਗਣਿਤ',
	'math_failure' => 'ਪਾਰਸ ਕਰਨ ਲਈ ਫੇਲ੍ਹ',
	'math_unknown_error' => 'ਅਣਜਾਣ ਗਲਤੀ',
	'math_unknown_function' => 'ਅਣਜਾਣ ਫੰਕਸ਼ਨ',
	'math_lexing_error' => 'lexing ਗਲਤੀ',
	'math_syntax_error' => 'ਸੰਟੈਕਸ ਗਲਤੀ',
);

/** Pangasinan (Pangasinan) */
$messages['pag'] = array(
	'math_unknown_error' => 'aga-antan error',
);

/** Pampanga (Kapampangan)
 * @author Katimawan2005
 */
$messages['pam'] = array(
	'math_sample' => 'Isingit me ing formula keni',
	'math_tip' => 'Formulang pang-matematika (LaTeX)',
	'mw_math_png' => 'Pane yang pakit king ayus/format a PNG',
	'mw_math_source' => 'Paburen yang TeX (para kareng text browser)',
	'math_failure' => 'E melaus ing pamag-parse',
	'math_unknown_error' => 'e makikilalang pamagkamali',
	'math_unknown_function' => 'e makikilalang gamit (unknown function)',
	'math_lexing_error' => 'pamagkamali king lexing',
	'math_syntax_error' => 'pamagkamali king pamituki-tuki (syntax error)',
	'math_image_error' => 'E melaus ing pamanalis king PNG;
siguraduan mu ing ustung pamag-install king latex, dvips, gs, at kaibat iyalis (i-convert) me',
	'math_bad_tmpdir' => 'E makasulat king o makapaglalang piyakitan (directory) a math temp',
	'math_bad_output' => 'E makasulat king o makapaglalang piyakitan (directory) a math output',
	'math_notexvc' => 'Mawawala ya ing texvc executable;
pakilawe me ing math/README ba meng i-configure.',
);

/** Picard (Picard)
 * @author Geoleplubo
 */
$messages['pcd'] = array(
	'math_sample' => "Mètte l'formule ichi",
	'math_tip' => 'Formule matématike (LaTeX)',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'math_sample' => 'Formula hier eigewwe',
);

/** Plautdietsch (Plautdietsch)
 * @author Wikipeeta
 */
$messages['pdt'] = array(
	'mw_math_png' => 'Emma aus PNG wiese',
	'mw_math_source' => 'Aus TeX lote (fe Tatjstbrowser)',
);

/** Pälzisch (Pälzisch)
 * @author Als-Holder
 */
$messages['pfl'] = array(
	'math_sample' => 'Do Formel aigewwe',
	'math_tip' => 'Mathematische Formel (LaTeX)',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'math_sample' => 'Tutaj wprowadź wzór',
	'math_tip' => 'Wzór matematyczny (LaTeX)',
	'prefs-math' => 'Wzory',
	'mw_math_png' => 'Zawsze generuj grafikę PNG',
	'mw_math_source' => 'Pozostaw w TeXu (dla przeglądarek tekstowych)',
	'math_failure' => 'Parser nie mógł rozpoznać',
	'math_unknown_error' => 'nieznany błąd',
	'math_unknown_function' => 'nieznana funkcja',
	'math_lexing_error' => 'błędna nazwa',
	'math_syntax_error' => 'błąd składni',
	'math_image_error' => 'Konwersja z lub do formatu PNG nie powiodła się. Sprawdź, czy poprawnie zainstalowane są latex i dvipng (lub dvips, gs i convert)',
	'math_bad_tmpdir' => 'Nie można utworzyć lub zapisywać w tymczasowym katalogu dla wzorów matematycznych',
	'math_bad_output' => 'Nie można utworzyć lub zapisywać w wyjściowym katalogu dla wzorów matematycznych',
	'math_notexvc' => 'Brak programu texvc.
Zapoznaj się z math/README w celu konfiguracji.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'math-desc' => 'Renderisé de fòrmule matemàtiche tra le tichëtte <code>&lt;math&gt;</code> ... 
<code>&lt;/math&gt;</code>',
	'math_sample' => 'Che a buta la fòrmula ambelessì',
	'math_tip' => 'Fòrmula matemàtica (LaTeX)',
	'prefs-math' => 'Fòrmule ëd matemàtica',
	'mw_math_png' => 'Most-lo sempe coma PNG',
	'mw_math_source' => 'Lass-lo coma TeX (për ij programa ëd navigassion testual)',
	'math_failure' => 'Parsificassion falà',
	'math_unknown_error' => 'Eror nen conossù',
	'math_unknown_function' => 'funsion che as sa pa lòn che a la sia',
	'math_lexing_error' => 'eror ëd léssich',
	'math_syntax_error' => 'eror ëd sintassi',
	'math_image_error' => "La conversion an PNG a l'é falìa; che a contròla l'ùltima instalassion ëd latex e dvipng (o dvips + gs + convert)",
	'math_bad_tmpdir' => "Ël sistema a-i la fa pa a creé la diretriss '''math temp''', ò pura a-i la fa nen a scriv-je andrinta",
	'math_bad_output' => "Ël sistema a-i la fa pa a creé la diretriss '''math output''', ò pura a-i la fa nen a scriv-je andrinta",
	'math_notexvc' => 'Pa gnun texvc executable; për piasì, che a contròla math/README për la configurassion.',
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'math_sample' => 'ایتھے فارمولا لاؤ',
	'math_tip' => 'ریاضی دا فارمولا (LaTeX)',
	'prefs-math' => 'حساب کتاب',
	'math_unknown_error' => 'انجان مسئلہ',
	'math_unknown_function' => 'انجان کم',
);

/** Pontic (Ποντιακά)
 * @author Omnipaedista
 * @author Sinopeus
 */
$messages['pnt'] = array(
	'math_sample' => 'Αδά εισάγετε την φόρμουλαν',
	'math_tip' => 'Μαθεματικόν φόρμουλα (LaTeX)',
	'prefs-math' => 'Απόδοσην μαθηματικίων',
	'math_unknown_function' => 'άγνωρος συνάρτησην',
	'math_lexing_error' => 'σφάλμαν λεξικής ανάλυσης',
	'math_syntax_error' => 'σφάλμαν σύνταξης',
);

/** Prussian (Prūsiskan)
 * @author Nertiks
 */
$messages['prg'] = array(
	'math_sample' => 'Enpeisāis matemātiskan izbilīsenin stwi',
	'math_tip' => 'Matemātiskas izbilīsenis (LaTeX)',
	'prefs-math' => 'Matemātiki',
	'mw_math_png' => 'Wisaddan teīkeis PNG grāfikin',
	'mw_math_source' => 'Palaīdeis en TeX-as fōrmatu (per tekstas lasātlins)',
	'math_failure' => 'Parsers ni mazēi skaitātun',
	'math_unknown_error' => 'niwaistā blānda',
	'math_unknown_function' => 'niwaistā funkciōni',
	'math_lexing_error' => 'laksisis blānda',
	'math_syntax_error' => 'sīntaksis blānda',
	'math_image_error' => 'Mainasnā en PNG ni izpalla.
Izbandais, anga latex, dvips, gs be convert ast instalītan tikrōmiskai',
	'math_bad_tmpdir' => 'Ni mazīngi teīktun anga enpeisātun en kīsmingiskasmu matemātiskan fōlderin',
	'math_bad_output' => 'Ni mazīngi teīktun anga enpeisātun en izēiseniskasmu matemātiskan fōlderin',
	'math_notexvc' => 'Ni ast texvc prōgraman.
Wīdais math/README kāi kōnfigurilai.',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'math_sample' => 'فورمول دلته ځای کړی',
	'math_tip' => 'شمېرپوهنيز فورمول (LaTeX)',
	'prefs-math' => 'شمېرپوهنه',
	'math_unknown_error' => 'ناجوته ستونزه',
	'math_unknown_function' => 'ناجوته کړنه',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'math_sample' => 'Inserir fórmula aqui',
	'math_tip' => 'Fórmula matemática (LaTeX)',
	'prefs-math' => 'Matemática',
	'mw_math_png' => 'Gerar sempre como PNG',
	'mw_math_source' => 'Deixar como TeX (para browsers de texto)',
	'math_failure' => 'Falhou ao verificar gramática',
	'math_unknown_error' => 'Erro desconhecido',
	'math_unknown_function' => 'Função desconhecida',
	'math_lexing_error' => 'Erro léxico',
	'math_syntax_error' => 'Erro de sintaxe',
	'math_image_error' => 'Falha na conversão para PNG;
verifique que o latex, dvips, gs e convert foram correctamente instalados',
	'math_bad_tmpdir' => "Não foi possível criar o directório temporário ''math'' ou, se já existe, escrever nele",
	'math_bad_output' => "Não foi possível criar o directório de resultados ''math'' ou, se já existe, escrever nele",
	'math_notexvc' => 'O executável texvc não foi encontrado. Consulte math/README para instruções da configuração.',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Giro720
 */
$messages['pt-br'] = array(
	'math_sample' => 'Inserir fórmula aqui',
	'math_tip' => 'Fórmula matemática (LaTeX)',
	'prefs-math' => 'Matemática',
	'mw_math_png' => 'Gerar sempre como PNG',
	'mw_math_source' => 'Deixar como TeX (para navegadores de texto)',
	'math_failure' => 'Falhou ao verificar gramática',
	'math_unknown_error' => 'Erro desconhecido',
	'math_unknown_function' => 'Função desconhecida',
	'math_lexing_error' => 'Erro léxico',
	'math_syntax_error' => 'Erro de sintaxe',
	'math_image_error' => 'Falha na conversão para PNG;
verifique se o latex, dvips, gs e convert estão corretamente instalados',
	'math_bad_tmpdir' => 'Ocorreram problemas na criação ou escrita no diretório temporário math',
	'math_bad_output' => 'Ocorreram problemas na criação ou escrita no diretório de resultados math',
	'math_notexvc' => 'O executável texvc não foi encontrado. Consulte math/README para instruções da configuração.',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'math_sample' => 'Kayman minuywata qillqamuy',
	'math_tip' => 'Yupana minuywa (LaTeX)',
	'prefs-math' => 'Minuywa',
	'mw_math_png' => "Hayk'appas PNG-ta ruray",
	'mw_math_source' => "TeX hinatam saqiy (qillqa wamp'unapaq)",
	'math_failure' => "Manam hap'inichu",
	'math_unknown_error' => 'mana riqsisqa pantasqa',
	'math_unknown_function' => 'mana riqsisqa rurana',
	'math_lexing_error' => 'rima pantasqa',
	'math_syntax_error' => 'rimay ukhunpuray pantasqa',
	'math_image_error' => "Manam atinichu PNG-man t'ikrayta; latex nisqawan dvipng (icha dvips + gs + convert) nisqakunap tiyachisqa kayninta llanchiy",
	'math_bad_tmpdir' => "Manam atinichu <em>math</em> nisqapaq mit'alla willañiqi churanata kamayta icha qillqayta",
	'math_bad_output' => 'Manam atinichu <em>math</em> nisqapaq lluqsichina willañiqi churanata kamayta icha qillqayta',
	'math_notexvc' => 'Manam kanchu ruranalla <strong>texvc</strong>. Ama hina kaspa, <em>math/README</em> nisqata ñawiriy allinkachinaykipaq.',
);

/** Romagnol (Rumagnôl)
 * @author Sentruper
 */
$messages['rgn'] = array(
	'math_sample' => 'Mèt aquè dentar una formula',
	'math_tip' => 'Formula metemètica (LaTeX)',
);

/** Tarifit (Tarifit)
 * @author Agzennay
 */
$messages['rif'] = array(
	'math_sample' => 'Egg ijj n formula da',
	'math_tip' => 'Mathematical formula (LaTeX)',
);

/** Romansh (Rumantsch)
 * @author Gion-andri
 * @author Kazu89
 */
$messages['rm'] = array(
	'math_sample' => 'Scriva qua tia furmla',
	'math_tip' => 'Furmla matematica (LaTeX)',
	'prefs-math' => 'TeX',
	'mw_math_png' => 'Adina mussar sco PNG',
	'mw_math_source' => 'Laschar en furma da TeX (per navigaturs da text)',
	'math_failure' => 'Errur dal parser',
	'math_unknown_error' => 'errur nunenconuschenta',
	'math_unknown_function' => 'funcziun nunenconuschenta',
	'math_lexing_error' => 'Errur lexicala',
	'math_syntax_error' => 'Sbagl da la sintaxta',
	'math_image_error' => "La conversiun da PNG n'è betg reussida; 
controllescha l'installaziun correcta da latext, dvips, gs e convertescha lura",
	'math_bad_tmpdir' => "Betg pussaivel da scriver u crear l'ordinatur temporar math",
	'math_bad_output' => "Betg pussaivel da scriver u crear l'ordinatur da destinaziun math",
	'math_notexvc' => "Il program texvc n'è betg vegnì chattà. Legia math/README per al configurar.",
);

/** Romani (Romani)
 * @author Desiphral
 */
$messages['rmy'] = array(
	'prefs-math' => 'Matematika',
	'math_unknown_error' => 'bijangli dosh',
	'math_unknown_function' => 'bijangli funkciya',
	'math_syntax_error' => 'sintaksaki dosh',
	'math_bad_output' => 'Nashti te kerel pes vai te lekhavel po matematikano direktoro kai del pes avri.',
	'math_notexvc' => 'Nai o kerditori (eksekutabilo) texvc; dikh math/README te labyares les.',
);

/** Romanian (Română)
 * @author Emily
 * @author Laurap
 * @author Minisarm
 * @author Strainu
 */
$messages['ro'] = array(
	'math_sample' => 'Introduceți formula aici',
	'math_tip' => 'Formulă matematică (LaTeX)',
	'prefs-math' => 'Aspect formule',
	'mw_math_png' => 'Întodeauna afișează PNG',
	'mw_math_source' => 'Lasă ca TeX (pentru browser-ele text)',
	'math_failure' => 'Nu s-a putut interpreta',
	'math_unknown_error' => 'eroare necunoscută',
	'math_unknown_function' => 'funcție necunoscută',
	'math_lexing_error' => 'eroare lexicală',
	'math_syntax_error' => 'eroare de sintaxă',
	'math_image_error' => 'Conversie în PNG eșuată; verificați corectitudinea instalării sistemelor LaTex sau dvipng (sau dvips + gs + convert)',
	'math_bad_tmpdir' => 'Nu se poate crea sau nu se poate scrie în directorul temporar pentru formule matematice',
	'math_bad_output' => 'Nu se poate crea sau nu se poate scrie în directorul de ieșire pentru formule matematice',
	'math_notexvc' => 'Lipsește executabilul texvc; vezi math/README pentru configurare.',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'math_sample' => "Mitte 'a formule aqquà",
	'math_tip' => 'Formula matemateche (LaTeX)',
	'prefs-math' => 'Math',
	'mw_math_png' => "Fà sembre 'u render de le PNG",
	'mw_math_source' => "Lassele cumme a 'nu TeX (pe le browser de teste)",
	'math_failure' => 'Analisi fallite',
	'math_unknown_error' => 'errore scanusciute',
	'math_unknown_function' => 'funziona scanusciute',
	'math_lexing_error' => 'errore de lessiche',
	'math_syntax_error' => 'errore de sintassi',
	'math_image_error' => "'A conversione d'u PNG ha fallite;
condrolle ce l'installazione de latex e dvips (o dvipg + gs + convertitore) jè corrette",
	'math_bad_tmpdir' => "Non ge puè scrivere o ccrejà 'na cartelle temboranea de math",
	'math_bad_output' => "Non ge puè scrivere o ccrejà 'na cartelle de destinazzione de math",
	'math_notexvc' => 'texvc eseguibbele perdute;
pe piacere vide math/README pe configurà.',
);

/** Russian (Русский)
 * @author Amire80
 * @author MaxSem
 */
$messages['ru'] = array(
	'math_sample' => 'Введите сюда формулу',
	'math_tip' => 'Математическая формула (формат LaTeX)',
	'prefs-math' => 'Отображение формул',
	'mw_math_png' => 'Всегда генерировать PNG',
	'mw_math_source' => 'Оставить в разметке ТеХ (для текстовых браузеров)',
	'math_failure' => 'Невозможно разобрать выражение',
	'math_unknown_error' => 'неизвестная ошибка',
	'math_unknown_function' => 'неизвестная функция',
	'math_lexing_error' => 'лексическая ошибка',
	'math_syntax_error' => 'синтаксическая ошибка',
	'math_image_error' => 'Преобразование в PNG прошло с ошибкой — проверьте правильность установки latex и dvips (или dvips + gs + convert)',
	'math_bad_tmpdir' => 'Не удаётся создать или записать во временный каталог математики',
	'math_bad_output' => 'Не удаётся создать или записать в выходной каталог математики',
	'math_notexvc' => 'Выполняемый файл texvc не найден; См. math/README — справку по настройке.',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'math_sample' => 'Вложте ту формулу',
	'math_tip' => 'Математічна формула (LaTeX)',
	'prefs-math' => 'Математіка',
	'mw_math_png' => 'Все ґенеровати PNG',
	'mw_math_source' => 'Зохабити як TeX (про текстовы переглядачі)',
	'math_failure' => 'Не дасть ся розобрати выраз',
	'math_unknown_error' => 'незнама хыба',
	'math_unknown_function' => 'незнама функція',
	'math_lexing_error' => 'лексічна хыба',
	'math_syntax_error' => 'сінтаксічна хыба',
	'math_image_error' => 'Злигала конверзія до PNG; перевірте правилну іншталацію latex, dvips (або dvips + gs + convert)',
	'math_bad_tmpdir' => 'Не дасть ся записати або створити дочасный адресарь про математіку',
	'math_bad_output' => 'Не дасть ся записати або створити дочасный адресарь про выступ математіку',
	'math_notexvc' => 'Хыбить спустительный texvc; посмотьте ся до math/README на конфіґурацію.',
);

/** Megleno-Romanian (Cyrillic script) (Влахесте)
 * @author Макѕе
 */
$messages['ruq-cyrl'] = array(
	'math_sample' => 'Интродуца формула иси',
	'math_tip' => 'Формула с-математикс (LaTeX)',
);

/** Megleno-Romanian (Latin script) (Vlăheşte)
 * @author Макѕе
 */
$messages['ruq-latn'] = array(
	'math_sample' => 'Introduca formula isi',
	'math_tip' => "Formula s'matematiks (LaTeX)",
);

/** Sanskrit (संस्कृतम्)
 * @author Naveen Sankar
 */
$messages['sa'] = array(
	'math_sample' => 'सूत्रवाक्यं अत्र निवेशयतु',
	'math_tip' => 'गणितीयसूत्रम् (LaTeX)',
);

/** Sakha (Саха тыла)
 * @author Andrijko Z.
 * @author HalanTul
 */
$messages['sah'] = array(
	'math_sample' => 'Формуланы манна киллэр',
	'math_tip' => 'Математика формулата (LaTeX)',
	'prefs-math' => 'Фуормулалар',
	'mw_math_png' => 'Куруук PNG таһаарарга (туһанарга)',
	'mw_math_source' => 'TeX бэлиэтин (разметкатын) хааллар (тиэкиһинэн эрэ үлэлиир браузерга)',
	'math_failure' => 'Сатаан ааҕыллыбата',
	'math_unknown_error' => 'биллибэт алҕас',
	'math_unknown_function' => 'биллибэт дьайыы (функция)',
	'math_lexing_error' => 'лексиката алҕастаах',
	'math_syntax_error' => 'синтаксис алҕаһа',
	'math_image_error' => 'PNG-га уларытыы сатаммата; latex, dvips, gs, уонна convert туруоруулара сөбүн көр',
	'math_bad_tmpdir' => 'Математика быстах кэмнээҕи директорията сатаан оҥоһуллубута',
	'math_bad_output' => 'Математика таһынааҕы директорията сатаан оҥоһуллубата',
	'math_notexvc' => 'texvc кыайан толоруллубата; маны math/README көр.',
);

/** Sardinian (Sardu)
 * @author Andria
 */
$messages['sc'] = array(
	'math_sample' => 'Inserta sa fòrmula inoghe',
	'math_tip' => 'Fòrmula matemàtica (LaTeX)',
	'prefs-math' => 'Fòrmulas matemàticas',
	'math_unknown_error' => 'faddina disconnota',
);

/** Sicilian (Sicilianu)
 * @author Tonyfroio
 */
$messages['scn'] = array(
	'math_sample' => 'Nzirisci ccà na fòrmula',
	'math_tip' => 'Fòrmula matimàtica (LaTeX)',
	'prefs-math' => 'Fòrmuli',
	'mw_math_png' => "Ammustra sempri 'n PNG",
	'mw_math_source' => 'Lassa comu TeX (pi browser tistuali)',
	'math_failure' => "S'hà virificatu un erruri ntô parsing",
	'math_unknown_error' => 'erruri scanusciutu',
	'math_unknown_function' => 'funzioni scanusciuta',
	'math_lexing_error' => 'erruri lissicali',
	'math_syntax_error' => 'erruri di sintassi',
	'math_image_error' => "Cunvirsioni 'n PNG fallita; virificati la curretta nstallazzioni dî siquenti prugrammi: latex, dvips, gs e convert.",
	'math_bad_tmpdir' => 'Mpussìbbili scrìviri o criari la directory timpurània pi math',
	'math_bad_output' => 'Mpussìbbili scrìviri o criari la directory di output pi math',
	'math_notexvc' => 'Esiquìbbili texvc mancanti; pi favuri cunzurtari math/README pi la cunfigurazzioni.',
);

/** Scots (Scots)
 * @author OchAyeTheNoo
 */
$messages['sco'] = array(
	'math_sample' => 'Pit yer formula here',
	'math_tip' => 'Mathematical formula (LaTeX)',
	'prefs-math' => 'Renderin math',
	'mw_math_png' => 'Aye render PNG',
	'mw_math_source' => 'Leave it as TeX (for text brousers)',
);

/** Sindhi (سنڌي)
 * @author Aursani
 */
$messages['sd'] = array(
	'math_sample' => 'هتي فارمولو وجھو',
	'math_tip' => 'رياضياتي مساوات (LaTeX)',
);

/** Sassaresu (Sassaresu)
 * @author Felis
 */
$messages['sdc'] = array(
	'math_sample' => 'Insirì la fòimmura inogghi',
	'math_tip' => 'Fòimmura matemàtigga (LaTeX)',
	'prefs-math' => 'Fòimmuri matemàtigghi',
	'mw_math_png' => 'Musthra sempri in PNG',
	'mw_math_source' => 'Lassa in fuimmaddu TeX (pa nabiggadori testhuari)',
	'math_failure' => "Errori i'l'anàrisi sintàttigga",
	'math_unknown_error' => 'errori ischunisciddu',
	'math_unknown_function' => 'funzioni ischuniscidda',
	'math_lexing_error' => 'errori di lingàggiu',
	'math_syntax_error' => 'errori di sintassi',
	'math_image_error' => 'Cunvirthimentu in PNG nò ridisciddu; verifiggà chi siani isthalladdi currentementi i sighenti prugrammi: latex, dvips, gs, e convert.',
	'math_bad_tmpdir' => "Impussìbiri ischribì o crià la carthella timpurània pa ''math''",
	'math_bad_output' => "Impussìbiri ischribì o crià la carthella d'iscidda pa ''math''",
	'math_notexvc' => "Fattìbiri ''texvc'' mancanti; pa piazeri cunsulthà ''math/README'' pa la cunfigurazioni.",
);

/** Northern Sami (Sámegiella)
 * @author Skuolfi
 */
$messages['se'] = array(
	'math_sample' => 'Lasit dasa formula',
	'prefs-math' => 'Matematihkká',
	'mw_math_png' => 'Čájet álo PNG:n',
	'math_unknown_error' => 'Dovdameahtun feaila',
	'math_unknown_function' => 'Dovdameahtun funkšuvdna',
);

/** Cmique Itom (Cmique Itom)
 * @author SeriCtam
 */
$messages['sei'] = array(
	'math_sample' => 'Heformula cuerte damir',
	'math_tip' => 'Formula mathematatl (LaTeX)',
	'prefs-math' => 'HTML-cuat',
	'math_unknown_error' => 'römj ác',
	'math_unknown_function' => 'functión ác',
	'math_lexing_error' => 'römjde lexám',
	'math_syntax_error' => 'römjde syntáx',
);

/** Samogitian (Žemaitėška) */
$messages['sgs'] = array(
	'math_sample' => 'Iveskėt fuormolė',
	'math_tip' => 'Matematinė fuormolė (LaTeX fuormato)',
	'prefs-math' => 'Matematėka',
	'mw_math_png' => 'Vėsumet fuormuotė PNG',
	'mw_math_source' => 'Paliktė TeX fuormata (tekstinems naršīklems)',
	'math_failure' => 'Nepavīka apdoruotė',
	'math_unknown_error' => 'nežinuoma klaida',
	'math_unknown_function' => 'nežinuoma funkcėjė',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'math_sample' => 'Unesite formulu ovdje',
	'math_tip' => 'Matematička formula (LaTeX)',
	'prefs-math' => 'Prikazivanje matematike',
	'mw_math_png' => 'Uvijek prikaži kao PNG',
	'mw_math_source' => 'Ostavi kao TeX (za tekstualne preglednike)',
	'math_failure' => 'Neuspjeh pri parsiranju',
	'math_unknown_error' => 'nepoznata greška',
	'math_unknown_function' => 'nepoznata funkcija',
	'math_lexing_error' => 'riječnička greška',
	'math_syntax_error' => 'sintaksna greška',
	'math_image_error' => 'PNG konverzija neuspješna; provjerite tačnu instalaciju latex-a i dvipng-a (ili dvips + gs + convert)',
	'math_bad_tmpdir' => 'Ne može se napisati ili napraviti privremeni matematički direktorijum',
	'math_bad_output' => 'Ne može se napisati ili napraviti direktorijum za matematički izvještaj.',
	'math_notexvc' => 'Nedostaje izvršno texvc; molimo Vas da pogledate math/README da podesite.',
);

/** Tachelhit (Tašlḥiyt/ⵜⴰⵛⵍⵃⵉⵜ)
 * @author Dalinanir
 * @author Zanatos
 */
$messages['shi'] = array(
	'math_sample' => 'Skcm talɣat ɣid',
	'math_tip' => 'Talɣiwt tusnakt (LaTeX)',
	'prefs-math' => 'mat',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 * @author නන්දිමිතුරු
 * @author ශ්වෙත
 */
$messages['si'] = array(
	'math_sample' => 'සූත්‍රය මෙහි රුවන්න',
	'math_tip' => 'ගණිත සූත්‍රය (LaTeX)',
	'prefs-math' => 'ගණිත',
	'mw_math_png' => 'සැමවිට PNG ලෙසට විදැහන්න',
	'mw_math_source' => 'TeX  ලෙසින් පැවැතීමට හරින්න(පෙළ බ්‍රවුසරයන් සඳහා)',
	'math_failure' => 'ව්‍යාකරණ විග්‍රහය අසමත් විය',
	'math_unknown_error' => 'හඳුනා නොගත් දෝෂය',
	'math_unknown_function' => 'හඳුනා නොගත් ශ්‍රිතය',
	'math_lexing_error' => 'රීතිමය දෝෂයකි',
	'math_syntax_error' => 'කාරක-රීති දෝෂය',
	'math_image_error' => 'PNG අන්වර්තනය අසාර්ථකවිය;latex, සහ dvipng (හෝ dvips + gs + convert) හී නිදොස්  ස්ථාපනය සිදුවී ඇතිදැයි පිරික්සන්න',
	'math_bad_tmpdir' => 'තාවකාලික ගණිත  ඩිරෙක්ටරිය තැනීමට හෝ එහි ලිවීමට නොහැක',
	'math_bad_output' => 'ගණිත ප්‍රතිදාන ඩිරෙක්ටරිය තැනීමට හෝ එයට ලිවීමට නොහැක',
	'math_notexvc' => 'texvc අභිවාහකය දක්නට නොමැත;
වින්‍යාස කෙරුමට කරුණාකර math/README බලන්න.',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'math_sample' => 'Sem vložte vzorec',
	'math_tip' => 'Matematický vzorec (LaTeX)',
	'prefs-math' => 'Vykreslenie matematiky',
	'mw_math_png' => 'Vždy vykresľovať PNG',
	'mw_math_source' => 'Ponechať TeX (pre textové prehliadače)',
	'math_failure' => 'Syntaktická analýza (parsing) neúspešná',
	'math_unknown_error' => 'neznáma chyba',
	'math_unknown_function' => 'neznáma funkcia',
	'math_lexing_error' => 'lexikálna chyba',
	'math_syntax_error' => 'syntaktická chyba',
	'math_image_error' => 'PNG konverzia neúspešná; skontrolujte správnosť inštalácie programov: latex a dvipng (alebo dvips + gs + convert)',
	'math_bad_tmpdir' => 'Nemožno zapisovať alebo vytvoriť dočasný matematický adresár',
	'math_bad_output' => 'Nemožno zapisovať alebo vytvoriť výstupný matematický adresár',
	'math_notexvc' => 'Chýbajúci program texvc; konfigurácia je popísaná v math/README.',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'math-desc' => 'Izriši matematične formule med oznakama <code>&lt;math&gt;</code> in <code>&lt;/math&gt;</code>',
	'math_sample' => 'Tu vnesite enačbo',
	'math_tip' => 'Matematična enačba (LaTeX)',
	'prefs-math' => 'Prikaz matematičnega besedila',
	'mw_math_png' => 'Vedno prikaži PNG',
	'mw_math_source' => 'Pusti v TeX-ovi obliki (za besedilne brskalnike)',
	'math_failure' => 'Ni mi uspelo razčleniti',
	'math_unknown_error' => 'neznana napaka',
	'math_unknown_function' => 'neznana funkcija',
	'math_lexing_error' => 'slovarska napaka',
	'math_syntax_error' => 'skladenjska napaka',
	'math_image_error' => 'Pretvarjanje v PNG ni uspelo; preverite, ali sta latex in dvips (ali dvips + gs + convert) pravilno nameščena.',
	'math_bad_tmpdir' => 'Začasne mape za math ne morem ustvariti ali pisati vanjo.',
	'math_bad_output' => 'Izhodne mape za math ne morem ustvariti ali pisati vanjo.',
	'math_notexvc' => 'Manjka izvedbena datoteka texvc;
za njeno namestitev si poglejte math/README.',
);

/** Lower Silesian (Schläsch)
 * @author Schläsinger
 * @author Teutonius
 */
$messages['sli'] = array(
	'math_sample' => 'Formel hier eifiega',
	'mw_math_png' => 'Emmer ols PNG darstalla',
	'mw_math_source' => 'Ols TeX belassen (fier Textbrowser)',
	'math_failure' => 'Parser-Fahler',
	'math_unknown_error' => 'Unbekennter Fahler',
	'math_unknown_function' => 'Unbekennte Funksjonn',
	'math_lexing_error' => '„Lexing“-Fahler',
	'math_syntax_error' => 'Syntaxfahler',
	'math_image_error' => 'de PNG-Konvertierung schlug fehl',
	'math_bad_tmpdir' => 'Doas temporäre Verzeichnis fier mathematische Formeln koan ne oagelagt oder beschrieba waan.',
	'math_bad_output' => 'Doas Zielverzeichnis fier mathematische Formeln koan ne oagelegt oder beschrieba waan.',
	'math_notexvc' => 'Doas texvc-Programm wurde ne gefunda. Bitte math/README beachten.',
);

/** Southern Sami (Åarjelsaemien)
 * @author Andrijko Z.
 */
$messages['sma'] = array(
	'math_sample' => 'Bïejedh fårmele daesnie',
	'math_tip' => 'Ryökneme fårmele (LaTeX)',
	'math_unknown_error' => 'ammes båajhtede',
);

/** Somali (Soomaaliga) */
$messages['so'] = array(
	'prefs-math' => 'Xisaab',
);

/** Albanian (Shqip)
 * @author Mikullovci11
 */
$messages['sq'] = array(
	'math_sample' => 'Vendos formulen ketu',
	'math_tip' => 'Formulë matematike (LaTeX)',
	'prefs-math' => 'Formula',
	'mw_math_png' => 'Gjithmonë PNG',
	'mw_math_source' => 'Lëre si TeX (për shfletuesit tekst)',
	'math_failure' => 'Nuk e kuptoj',
	'math_unknown_error' => 'gabim i panjohur',
	'math_unknown_function' => 'funksion i panjohur',
	'math_lexing_error' => 'gabim leximi',
	'math_syntax_error' => 'Gabim sintakse',
	'math_image_error' => 'Konversioni PNG dështoi; kontrolloni për ndonjë gabim instalimi të latex-it, dvips-it, gs-it, dhe convert-it.',
	'math_bad_tmpdir' => 'Nuk munda të shkruaj ose krijoj dosjen e përkohshme për matematikë',
	'math_bad_output' => 'Nuk munda të shkruaj ose të krijoj prodhimin matematik në dosjen',
	'math_notexvc' => 'Mungon zbatuesi texvc; ju lutem shikoni math/README për konfigurimin.',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'math_sample' => 'Овде унесите формулу',
	'math_tip' => 'Математичка формула (LaTeX)',
	'prefs-math' => 'Приказ математичких формула',
	'mw_math_png' => 'Увек прикажи као PNG',
	'mw_math_source' => 'Остави у формату ТеХ (за текстуалне прегледаче)',
	'math_failure' => 'Рашчлањивање није успело',
	'math_unknown_error' => 'непозната грешка',
	'math_unknown_function' => 'непозната функција',
	'math_lexing_error' => 'речничка грешка',
	'math_syntax_error' => 'синтаксна грешка',
	'math_image_error' => 'Претварање у формат PNG није успело. Проверите да ли су добро инсталирани latex, dvips, gs и convert',
	'math_bad_tmpdir' => 'Стварање или писање у привремену фасциклу за математику није успело',
	'math_bad_output' => 'Стварање или писање у одредишној фасцикли за математику није успело',
	'math_notexvc' => 'Недостаје извршна датотека texvc-а. Погледајте math/README за подешавање.',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'math_sample' => 'Ovde unesite formulu',
	'math_tip' => 'Matematička formula (LaTeX)',
	'prefs-math' => 'Matematike',
	'mw_math_png' => 'Uvek prikaži PNG',
	'mw_math_source' => 'Ostavi kao TeH (za tekstualne brauzere)',
	'math_failure' => 'Neuspeh pri parsiranju',
	'math_unknown_error' => 'nepoznata greška',
	'math_unknown_function' => 'nepoznata funkcija',
	'math_lexing_error' => 'rečnička greška',
	'math_syntax_error' => 'sintaksna greška',
	'math_image_error' => 'Pretvaranje u format PNG nije uspelo. Proverite da li su dobro instalirani latex, dvips, gs i convert',
	'math_bad_tmpdir' => 'Ne mogu da napišem ili napravim privremeni math direktorijum',
	'math_bad_output' => 'Ne mogu da napišem ili napravim direktorijum za math izlaz.',
	'math_notexvc' => 'Nedostaje izvršno texvc; molimo pogledajte math/README da biste podesili.',
);

/** Sranan Tongo (Sranantongo)
 * @author Adfokati
 * @author Stretsh
 */
$messages['srn'] = array(
	'math_sample' => 'Poti formula dyaso',
	'math_tip' => 'Formula fu teri (LaTeX)',
	'prefs-math' => 'Fomula',
	'math_lexing_error' => 'leksikografi fowtu',
	'math_syntax_error' => 'sintaki fowtu',
);

/** Seeltersk (Seeltersk)
 * @author Maartenvdbent
 * @author Pyt
 */
$messages['stq'] = array(
	'math_sample' => 'Formel hier ienföigje',
	'math_tip' => 'Mathematiske Formel (LaTeX)',
	'prefs-math' => 'TeX',
	'mw_math_png' => 'Altied as PNG deerstaale',
	'mw_math_source' => 'As TeX beläite (foar Textbrowsere)',
	'math_failure' => 'Parser-Failer',
	'math_unknown_error' => 'Uunbekoande Failer',
	'math_unknown_function' => 'Uunbekoande Funktion',
	'math_lexing_error' => "'Lexing'-Failer",
	'math_syntax_error' => 'Syntaxfailer',
	'math_image_error' => 'ju PNG-Konvertierenge sluuch fail; korrekte Installation fon LaTeX un dvipng wröigje (of dvips + gs + convert)',
	'math_bad_tmpdir' => 'Kon dät Temporärferteeknis foar mathematiske Formeln nit anlääse of beskrieuwe.',
	'math_bad_output' => 'Kon dät Sielferteeknis foar mathematiske Formeln nit anlääse of beskrieuwe.',
	'math_notexvc' => 'Dät texvc-Program kon nit fuunen wäide. Beoachte jädden math/README.',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'math_sample' => 'Asupkeun rumus di dieu',
	'math_tip' => 'Rumus matematis (LaTeX)',
	'prefs-math' => 'Maté',
	'mw_math_png' => 'Jieun wae PNG',
	'mw_math_source' => 'Antep salaku TeX (pikeun panyungsi tulisan)',
	'math_failure' => "Peta ''parse'' gagal",
	'math_unknown_error' => 'Kasalahan teu kanyahoan',
	'math_unknown_function' => 'fungsi teu kanyahoan',
	'math_lexing_error' => 'kasalahan lexing',
	'math_syntax_error' => 'Kasalahan rumpaka',
	'math_image_error' => 'Konversi PNG gagal; pastikeun yén latex, dvips, gs, jeung convert geus bener nginstalna',
	'math_bad_tmpdir' => 'Henteu bisa nulis atawa nyieun direktori samentara math',
	'math_bad_output' => 'Henteu bisa nulisikeun atawa nyieun direktori keluaran math',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Habj
 * @author Nghtwlkr
 * @author Sannab
 */
$messages['sv'] = array(
	'math_sample' => 'Skriv formeln här',
	'math_tip' => 'Matematisk formel (LaTeX)',
	'prefs-math' => 'Matematik',
	'mw_math_png' => 'Rendera alltid PNG',
	'mw_math_source' => 'Låt vara TeX (för textbaserade webbläsare)',
	'math_failure' => 'Misslyckades med att tolka formel.',
	'math_unknown_error' => 'okänt fel',
	'math_unknown_function' => 'okänd funktion',
	'math_lexing_error' => 'regelfel',
	'math_syntax_error' => 'syntaxfel',
	'math_image_error' => 'Konvertering till PNG-format misslyckades; kontrollera om latex och dvipng (eller dvips + gs + convert) är korrekt installerade',
	'math_bad_tmpdir' => 'Kan inte skriva till eller skapa temporär mapp för matematikresultat',
	'math_bad_output' => 'Kan inte skriva till eller skapa mapp för matematikresultat',
	'math_notexvc' => 'Applicationen texvc saknas; läs math/README för konfigureringsanvisningar.',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 * @author Malangali
 */
$messages['sw'] = array(
	'math_sample' => 'Ingiza formula hapa',
	'math_tip' => 'Formula ya kihesabu (LaTeX)',
	'prefs-math' => 'Hisabati',
	'math_unknown_error' => 'hitilafu isiyojulikana',
);

/** Silesian (Ślůnski)
 * @author Lajsikonik
 * @author Timpul
 */
$messages['szl'] = array(
	'math_sample' => 'Sam tukej wprowadź wzůr',
	'math_tip' => 'Wzůr matymatyčny (LaTeX)',
	'prefs-math' => 'Wzory',
	'mw_math_png' => 'Zawše gyneruj grafika PNG',
	'mw_math_source' => 'Uostow w TeXu (dla přyglůndarek tekstowych)',
	'math_failure' => 'Parser ńy můg rozpoznać',
	'math_unknown_error' => 'ńyznany feler',
	'math_unknown_function' => 'ńyznano funkcyjo',
	'math_lexing_error' => 'feler leksera',
	'math_syntax_error' => 'felerno skuadńa',
	'math_image_error' => 'kůnwersyjo do formatu PNG ńy powjodua śe; uobadej, eli poprawńy zainštalowane sům lotex, dvips, gs i convert',
	'math_bad_tmpdir' => 'Ńy idźe utwořić abo naškryflać w tymčasowym katalůgu do wzorůw matymatyčnych',
	'math_bad_output' => 'Ńy idźe utwořić abo naškryflać we wyjśćowym katalůgu do wzorůw matymatyčnych',
	'math_notexvc' => 'Ńy ma sam texvc; zapoznej śe z math/README w celu kůnfiguracyje.',
);

/** Tamil (தமிழ்)
 * @author Trengarasu
 * @author செல்வா
 */
$messages['ta'] = array(
	'math_sample' => 'இங்கே வாய்பாட்டை இடுக',
	'math_tip' => 'கணித வாய்பாடு (LaTeX)',
	'prefs-math' => 'கணிதம்',
	'mw_math_png' => 'எப்போதும் பி.என்.ஞ்சி (PNG) ஆக மாற்று',
	'mw_math_source' => 'TeX  ஆக விட்டு வை (உரைசார் உலாவிகளுக்கு)',
	'math_failure' => 'பாகுபடுத்தல் தோல்வி',
	'math_unknown_error' => 'அறியாத ஏதோவொரு பிழை',
	'math_unknown_function' => 'அறியப்படாத செயற்பாடு',
	'math_lexing_error' => 'தொகுத்தல் (லெக்சிங்) தவறு',
	'math_syntax_error' => 'தொடரமைப்புத் தவறு',
	'math_bad_tmpdir' => 'தற்காலிக கணித அடைவை உருவாக்க அல்லது எழுத முடியவில்லை',
	'math_bad_output' => 'கணித அடைவை உருவாக்க அல்லது அதில் எழுத முடியவில்லை.',
);

/** Tulu (ತುಳು)
 * @author VinodSBangera
 */
$messages['tcy'] = array(
	'math_sample' => 'ಮುಲ್ಪ ಸೂತ್ರೊನು ಪಾಡ್’ಲೆ',
	'math_tip' => 'ಗಣಿತ ಸೂತ್ರ (LaTeX)',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Sunil Mohan
 * @author Veeven
 */
$messages['te'] = array(
	'math_sample' => 'సూత్రాన్ని ఇక్కడ ఇవ్వండి',
	'math_tip' => 'గణిత సూత్రం (LaTeX)',
	'prefs-math' => 'గణితం',
	'mw_math_png' => 'ఎల్లప్పుడూ PNGగా చూపించు',
	'mw_math_source' => 'టెక్ గానే ఉండనివ్వు (టెక్స్ట్‌ బ్రౌజర్ల కొరకు)',
	'math_failure' => 'పార్స్ చెయ్యలేకపోయాం',
	'math_unknown_error' => 'గుర్తుతెలియని పొరపాటు',
	'math_unknown_function' => 'తెలియని ఫంక్షన్',
	'math_lexing_error' => 'లెక్సింగ్ లోపం',
	'math_syntax_error' => 'సింటాక్సు లోపం',
	'math_image_error' => 'PNG మార్పిడి విఫలమైంది; latex మరియు divpng (లేదా dvips + gs + convert) లు స్థాపితమయ్యాయని సరిచూసుకోండి',
	'math_bad_tmpdir' => 'math తాత్కాలిక డైరెక్టరీని సృష్టించలేకపోడం కానీ, అందులో రాయలేకపోవడంగానీ జరిగింది',
	'math_bad_output' => 'math ఔట్‌పుట్ డైరెక్టరీని సృష్టించలేకపోడం కానీ, అందులో రాయలేకపోవడంగానీ జరిగింది',
	'math_notexvc' => 'texvc ఎక్జిక్యూటబుల్ కనబడడం లేదు; కాన్ఫిగరు చెయ్యడానికి math/README చూడండి.',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'math_sample' => 'Илова кардани формула дар инҷо',
	'math_tip' => 'Формулаи риёзӣ (LaTeX)',
	'prefs-math' => 'Риёзиёт',
	'mw_math_png' => 'Ҳамеша PNG кашида шавад',
	'mw_math_source' => 'Ҳамчун TeX боқӣ бимон (барои мурургарҳои матнӣ)',
	'math_failure' => 'Шикаст дар таҷзеҳ',
	'math_unknown_error' => 'хатои ношинос',
	'math_unknown_function' => 'амали номаълум',
	'math_lexing_error' => 'хатои lexing',
	'math_syntax_error' => 'хатои наҳвӣ',
	'math_image_error' => 'Табдил ба PNG шикаст хӯр; насби дурусти latex, dvips, gs, ва табдилотро баррасӣ кунед',
	'math_bad_tmpdir' => 'Имкони эҷод ё навистани иттилоот дар пӯшаи муваққатии риёзӣ (temp) вуҷуд надорад',
	'math_bad_output' => 'Имкони эҷод ё навистани иттилоот дар пӯшаи хуруҷии риёзӣ (output) вуҷуд надорад',
	'math_notexvc' => 'Барномаи ичроии texvc мавҷуд нест; барои иттилооти бештар ба math/README нигаред.',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'math_sample' => 'Ilova kardani formula dar inço',
	'math_tip' => 'Formulai rijozī (LaTeX)',
	'prefs-math' => 'Rijozijot',
	'mw_math_png' => 'Hameşa PNG kaşida şavad',
	'mw_math_source' => 'Hamcun TeX boqī bimon (baroi mururgarhoi matnī)',
	'math_failure' => 'Şikast dar taçzeh',
	'math_unknown_error' => 'xatoi noşinos',
	'math_unknown_function' => "amali noma'lum",
	'math_lexing_error' => 'xatoi lexing',
	'math_syntax_error' => 'xatoi nahvī',
	'math_image_error' => 'Tabdil ba PNG şikast xūr; nasbi durusti latex, dvips, gs, va tabdilotro barrasī kuned',
	'math_bad_tmpdir' => 'Imkoni eçod jo navistani ittiloot dar pūşai muvaqqatiji rijozī (temp) vuçud nadorad',
	'math_bad_output' => 'Imkoni eçod jo navistani ittiloot dar pūşai xuruçiji rijozī (output) vuçud nadorad',
	'math_notexvc' => 'Barnomai icroiji texvc mavçud nest; baroi ittilooti beştar ba math/README nigared.',
);

/** Thai (ไทย)
 * @author Ans
 * @author Octahedron80
 */
$messages['th'] = array(
	'math_sample' => 'ใส่สูตรที่นี่',
	'math_tip' => 'ใส่สูตรทางคณิตศาสตร์ (LaTeX)',
	'prefs-math' => 'คณิตศาสตร์',
	'mw_math_png' => 'เรนเดอร์เป็น PNG เสมอ',
	'mw_math_source' => 'ปล่อยข้อมูลเป็น TeX (สำหรับเว็บเบราว์เซอร์แบบข้อความ)',
	'math_failure' => 'ส่งผ่านค่าไม่ได้',
	'math_unknown_error' => 'ข้อผิดพลาดที่ไม่ทราบ',
	'math_unknown_function' => 'คำสั่งที่ไม่ทราบ',
	'math_lexing_error' => 'การจำแนกสูตรผิดพลาด',
	'math_syntax_error' => 'ไวยากรณ์ผิดพลาด',
	'math_image_error' => 'การแปลง PNG ล้มเหลว กรุณาตรวจสอบการติดตั้ง latex และ dvipng (หรือ dvips + gs + convert) ให้ถูกต้อง',
	'math_bad_tmpdir' => 'ไม่สามารถเขียนค่าหรือสร้าง ลงไดเรกทอรีชั่วคราวสำหรับเก็บค่าทางคณิตศาสตร์ได้',
	'math_bad_output' => 'ไม่สามารถเขียนค่าหรือสร้าง ลงไดเรกทอรีปลายทางสำหรับเก็บค่าทางคณิตศาสตร์ได้',
	'math_notexvc' => 'เกิดข้อความผิดพลาด texvc ไม่พบ กรุณาตรวจสอบ math/README เพื่อตั้งค่า',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'math_sample' => 'Matematiki formulany şu ýere ýazyň',
	'math_tip' => 'Matematiki formula (LaTeX formatynda)',
	'prefs-math' => 'Matematiki formulalar',
	'mw_math_png' => 'Hemişe PNG öwür',
	'mw_math_source' => 'TeX-ligine galdyr (tekst brauzerleri üçin)',
	'math_failure' => 'Derňäp bolmady',
	'math_unknown_error' => 'näbelli säwlik',
	'math_unknown_function' => 'näbelli funksiýa',
	'math_lexing_error' => 'leksiki säwlik',
	'math_syntax_error' => 'sintaktik säwlik',
	'math_image_error' => 'PNG öwürmeklik şowsuz boldy;
latex, dvips, gs we convert gurluşlarynyň dogrulygyny barlaň',
	'math_bad_tmpdir' => 'Matematikanyň wagtlaýyn katalogyny ýazyp ýa-da döredip bolanok',
	'math_bad_output' => 'Matematika çykyş katalogyny ýazyp ýa-da döredip bolanok',
	'math_notexvc' => 'texvc ýerine ýetirilýän faýl tapylmady;
konfigurirlemek üçin math/README serediň.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'math_sample' => 'Isingit ang pormula dito',
	'math_tip' => 'Pormulang pangmatematika (LaTeX)',
	'prefs-math' => 'Matematika',
	'mw_math_png' => 'Palaging ilarawan sa anyong PNG',
	'mw_math_source' => "Iwanan bilang TeX (para sa mga panghanap na pangteksto o ''text browser'')",
	'math_failure' => 'Nabigo sa pagbanghay',
	'math_unknown_error' => 'hindi nalalamang kamalian',
	'math_unknown_function' => 'hindi nalalamang tungkulin',
	'math_lexing_error' => 'kamalian sa pagbabatas',
	'math_syntax_error' => 'kamalian sa palaugnayan',
	'math_image_error' => 'Nabigo ang pagpapalit upang maging PNG; suriin kung tama ang pagtatalaga ng latex at dvipng (o dvips + gs + convert)',
	'math_bad_tmpdir' => 'Hindi maisulat sa o makalikha ng pansamantalang direktoryong pangmatematika',
	'math_bad_output' => 'Hindi maisulat sa o makalikha ng direktoryo ng produktong pangmatematika',
	'math_notexvc' => 'Nawawala ang maisasakatuparang texvc;
pakitingnan ang matematika/BASAHINAKO para maisaayos ang konpigurasyon.',
);

/** Tongan (lea faka-Tonga)
 * @author Tauʻolunga
 */
$messages['to'] = array(
	'math_tip' => "Kupuʻilea fakamatematika ''(LaTex)''",
	'prefs-math' => 'Matematika',
	'mw_math_png' => 'Fai PNG taimi kotoa',
	'mw_math_source' => "Fakatoe ʻi he ''TeX'' maʻa e ngaahi palausa tohi pē",
	'math_unknown_error' => 'hala taʻeʻiloa',
	'math_unknown_function' => 'lakanga taʻeʻiloa',
	'math_bad_output' => 'ʻOku ʻikai lava ʻo tohi pe fakatupu ʻa e takafi maʻa e fua matematika',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'math_tip' => 'Matematik formula (LaTeX)',
	'prefs-math' => 'Matematiks',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Runningfridgesrule
 * @author Srhat
 * @author Uğur Başak
 */
$messages['tr'] = array(
	'math_sample' => 'Matematiksel-ifadeyi-girin',
	'math_tip' => 'Matematik formülü (LaTeX formatında)',
	'prefs-math' => 'Matematiksel simgeler',
	'mw_math_png' => 'Daima PNG resim formatına çevir',
	'mw_math_source' => 'Değiştirmeden TeX olarak bırak  (metin tabanlı tarayıcılar için)',
	'math_failure' => 'Ayrıştırılamadı',
	'math_unknown_error' => 'bilinmeyen hata',
	'math_unknown_function' => 'bilinmeyen fonksiyon',
	'math_lexing_error' => 'lexing hatası',
	'math_syntax_error' => 'sözdizim hatası',
	'math_image_error' => 'PNG çevirisi başarısız; latex, dvips ve gs programlarının doğru yüklendiğine emin olun ve çeviri işlemini başlatın.',
	'math_bad_tmpdir' => 'Math geçici dizinine yazılamıyor ya da oluşturulamıyor',
	'math_bad_output' => 'Math çıktı dizinine yazılamıyor ya da oluşturulamıyor',
	'math_notexvc' => "texvc çalıştırılabiliri kayıp;
ayarlamak için math/README'ye bakın.",
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Don Alessandro
 * @author KhayR
 * @author Ерней
 * @author Ильнар
 * @author Рашат Якупов
 */
$messages['tt-cyrl'] = array(
	'math_sample' => 'Формуланы монда өстәгез',
	'math_tip' => 'Математик формула (LaTeX форматы)',
	'prefs-math' => 'Формулалар',
	'mw_math_png' => 'Һәрвакыт PNG белән бәйләү',
	'mw_math_source' => 'ТеХ билгеләнешендә калдырылсын (текстлы браузерлар өчен)',
	'math_failure' => 'Укый алмадым',
	'math_unknown_error' => 'беленмәгән хата',
	'math_unknown_function' => 'билгесез функция',
	'math_lexing_error' => 'лексик хата',
	'math_syntax_error' => 'синтаксик хата',
);

/** Tatar (Latin script) (Tatarça)
 * @author Don Alessandro
 */
$messages['tt-latn'] = array(
	'math_sample' => 'Formulanı monda östägez',
	'math_tip' => 'Matematik formula (LaTeX formatı)',
	'prefs-math' => 'Formulalar',
	'mw_math_png' => 'Härwaqıt PNG belän bäyläw',
	'mw_math_source' => 'TeX bilgeläneşendä qaldırılsın (tekstlı brauzerlar öçen)',
	'math_failure' => 'Uqıy almadım',
	'math_unknown_error' => 'belenmägän xata',
	'math_unknown_function' => 'bilgesez funksiä',
	'math_lexing_error' => 'leksik xata',
	'math_syntax_error' => 'sintaksik xata',
);

/** Tuvinian (Тыва дыл)
 * @author Sborsody
 */
$messages['tyv'] = array(
	'math_sample' => 'Формуланы мынаар киирери',
	'math_unknown_error' => 'билбес алдаг',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Sahran
 */
$messages['ug-arab'] = array(
	'math_sample' => 'بۇ جايغا فورمۇلا قىستۇر',
	'math_tip' => 'ماتېماتېكىلىق فورمۇلا (LaTeX)',
	'prefs-math' => 'ماتېماتېكىلىق فورمۇلا',
	'mw_math_png' => 'ھەمىشە PNG ئىشلەت',
	'mw_math_source' => 'TeX كودى كۆرسەت (تېكست توركۆرگۈ ئىشلەتكەندە)',
	'math_failure' => 'تەھلىل قىلالمىدى',
	'math_unknown_error' => 'نامەلۇم خاتالىق',
	'math_unknown_function' => 'نامەلۇم فونكسىيە',
	'math_lexing_error' => 'جۈملە خاتالىقى',
	'math_syntax_error' => 'گرامماتىكىلىق خاتالىق',
	'math_image_error' => 'PNG ئايلاندۇرۇش مەغلۇپ بولدى؛
latex، dvips، gs، ۋە convert توغرا قاچىلانغانلىقىنى تەكشۈرۈڭ',
	'math_bad_tmpdir' => 'ماتېماتېكىلىق فورمۇلا يازىدىغان ياكى قۇرىدىغان ۋاقىتلىق مۇندەرىجە قۇرالمىدى',
	'math_bad_output' => 'ماتېماتېكىلىق فورمۇلا چىقىرىدىغان مۇندەرىجىگە يازالمىدى ياكى قۇرالمىدى',
	'math_notexvc' => ' texvc ئىجرا قىلالمىدى؛ math/README دىن پايدىلىنىپ سەپلەڭ.',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'math_sample' => 'Вставте сюди формулу',
	'math_tip' => 'Математична формула (LaTeX)',
	'prefs-math' => 'Відображення формул',
	'mw_math_png' => 'Завжди генерувати PNG',
	'mw_math_source' => 'Залишити в вигляді ТеХ (для текстових браузерів)',
	'math_failure' => 'Неможливо розібрати вираз',
	'math_unknown_error' => 'невідома помилка',
	'math_unknown_function' => 'невідома функція',
	'math_lexing_error' => 'лексична помилка',
	'math_syntax_error' => 'синтаксична помилка',
	'math_image_error' => 'PNG перетворення не вдалося; перевірте правильність установки latex і dvipng (або dvips + gs + convert)',
	'math_bad_tmpdir' => 'Не вдається створити чи записати в тимчасовий каталог математики',
	'math_bad_output' => 'Не вдається створити чи записати в вихідний каталог математики',
	'math_notexvc' => 'Не знайдено програму texvc; Див. math/README — довідку про налаштування.',
);

/** Urdu (اردو)
 * @author محبوب عالم
 */
$messages['ur'] = array(
	'math_sample' => 'صیغہ یہاں درج کیجئے',
	'math_tip' => '(ریاضیاتی صیغہ LaTeX)',
	'prefs-math' => 'ریاضی',
	'math_failure' => 'تجزیہ میں ناکام',
	'math_unknown_error' => 'نامعلوم غلطی',
	'math_unknown_function' => 'نامعلوم فعل',
	'math_syntax_error' => 'نحوی غلطی',
	'math_image_error' => 'PNG; کی تحویل ناکام
latex، dvips، gs کی صحیح تنصیب کی جانچ کرنے کے بعد دوبارہ تحویل کی کوشش کیجئے.',
);

/** Uzbek (O'zbek)
 * @author Abdulla
 */
$messages['uz'] = array(
	'math_sample' => 'Formula qoʻying',
	'math_tip' => 'Matematik formula (LaTeX)',
	'prefs-math' => 'Formulalar',
);

/** Vèneto (Vèneto)
 * @author Candalua
 * @author Vajotwo
 */
$messages['vec'] = array(
	'math_sample' => 'Inserire qua ła formuła',
	'math_tip' => 'Formula matematega (LaTeX)',
	'prefs-math' => 'Formułe matematiche',
	'mw_math_png' => 'Mostra senpre in PNG',
	'mw_math_source' => 'Lassa in formato TeX (par browser testuali)',
	'math_failure' => 'Eror del parser',
	'math_unknown_error' => 'eror sconossiùo',
	'math_unknown_function' => 'funzion sconossiùa',
	'math_lexing_error' => 'eror lessicale',
	'math_syntax_error' => 'eror de sintassi',
	'math_image_error' => 'Conversion in PNG fałía',
	'math_bad_tmpdir' => 'Inpossibile scrìvar o crear la directory tenporanea par math',
	'math_bad_output' => 'Inpossibile scrìvar o crear la directory de output par math',
	'math_notexvc' => 'Eseguibile texvc mancante; par piaser consulta math/README par la configurazion.',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'math_sample' => 'Pangat formul nakhu',
	'math_tip' => 'Matematine formul (LaTeX-formatas)',
	'prefs-math' => 'Matematik',
	'mw_math_png' => 'Kaiken generiruida PNG',
	'mw_math_source' => 'Jätkat nece TeX-formas (tekstkaclimiden täht)',
	'math_failure' => 'Ei voi palastada',
	'math_unknown_error' => 'tundmatoi petuz',
	'math_unknown_function' => 'tundmatoi funkcii',
	'math_lexing_error' => 'leksine petuz',
	'math_syntax_error' => 'sintaksine petuz',
	'math_image_error' => 'PNG-ks kändmižes ozaižihe petuz;
kodvgat, oiged-ik oma järgetud: latex, dvips, gs da convert.',
	'math_bad_tmpdir' => 'Ei voi säta pordaigaline matematine katalog vai ei voi kirjutada sinnä',
	'math_bad_output' => 'Ei voi säta matematine lähtmižkatalog vai ei voi kirjutada sinnä',
	'math_notexvc' => 'En voi löuta texvc-töfailad;
kc. math/README järgendamižen täht.',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'math_sample' => 'Nhập công thức toán vào đây',
	'math_tip' => 'Công thức toán (LaTeX)',
	'prefs-math' => 'Công thức toán',
	'mw_math_png' => 'Luôn cho ra dạng hình PNG',
	'mw_math_source' => 'Để nguyên mã TeX (dành cho trình duyệt văn bản)',
	'math_failure' => 'Không thể phân tích cú pháp',
	'math_unknown_error' => 'lỗi lạ',
	'math_unknown_function' => 'hàm lạ',
	'math_lexing_error' => 'lỗi chính tả',
	'math_syntax_error' => 'lỗi cú pháp',
	'math_image_error' => 'Không chuyển sang định dạng PNG được; xin kiểm tra lại cài đặt latex, dvips, gs, và convert (hoặc dvips + gs + convert)',
	'math_bad_tmpdir' => 'Không tạo mới hay viết vào thư mục toán tạm thời được',
	'math_bad_output' => 'Không tạo mới hay viết vào thư mục kết quả được',
	'math_notexvc' => 'Không thấy hàm thực thi texvc; xin xem math/README để biết cách cấu hình.',
);

/** Upper Franconian (Mainfränkisch)
 * @author Altaileopard
 * @author Silvicola
 */
$messages['vmf'] = array(
	'math_sample' => 'Dô dii fôrml  (in TEX) nâjschrajm',
	'math_tip' => 'Mademaadische Fôrml (in LATEX)',
	'prefs-math' => 'TeX',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'math_sample' => 'Pladolös malatami isio',
	'math_tip' => 'Malatam matematik (LaTeX)',
	'prefs-math' => 'Logot formülas',
	'mw_math_png' => 'Ai el PNG',
	'mw_math_source' => 'Dakipolöd oni as TeX (pro bevüresodatävöms fomätü vödem)',
	'math_failure' => 'Diletam fomüla no eplöpon',
	'math_unknown_error' => 'pök nesevädik',
	'math_unknown_function' => 'dun nesevädik',
	'math_lexing_error' => 'vödidiletam no eplöpon',
	'math_syntax_error' => 'süntagapöl',
	'math_image_error' => 'Feajafam ela PNG no eplöpon;
vestigolös stitami verätik ela latex, ela dvips, ela gs, e feajafön',
	'math_bad_tmpdir' => 'No mögos ad penön ini / jafön ragiviär(i) matematik nelaidüpik.',
	'math_bad_output' => 'No mögos ad penön ini / jafön ragiviär(i) matematik labü seks',
	'math_notexvc' => 'Program-texvc ledunovik no petuvon;
logolös eli math/README ad givulön parametemi.',
);

/** Votic (Vaďďa)
 * @author 2Q
 */
$messages['vot'] = array(
	'math_sample' => 'Lissä formula tänne',
	'math_tip' => 'Matematillin formula (LaTeX)',
);

/** Võro (Võro)
 * @author Võrok
 */
$messages['vro'] = array(
	'math_sample' => 'Kirodaq vallõm siiäq',
	'math_tip' => 'Matõmaatigatekst (LaTeX)',
	'prefs-math' => 'Valõmidõ näütämine',
	'mw_math_png' => 'Kõgõ PNG',
	'mw_math_source' => 'Alalõ hoitaq TeX (tekstikaejin)',
	'math_failure' => 'Arvosaamalda süntaks',
	'math_unknown_error' => 'Tundmalda viga',
	'math_unknown_function' => 'Tundmalda tallitus',
	'math_lexing_error' => 'Vällälugõmisviga',
	'math_syntax_error' => 'Süntaksiviga',
	'math_image_error' => 'PNG-muutus lää-s kõrda; kaeq üle, et latex, dvips, gs ja convert ommaq õigõhe paika säedüq',
	'math_bad_tmpdir' => 'Matõmaatigateksti kirotaminõ aotlistõ kausta vai taa kausta luuminõ ei lääq kõrdaq',
	'math_bad_output' => 'Matõmaatigateksti kirotaminõ välläandmiskausta vai sääntse kausta luuminõ ei lääq kõrda',
	'math_notexvc' => 'Olõ-i texvc-tüüriista; loeq tuu paikasäädmise kotsilõ math/README-st.',
);

/** Walloon (Walon) */
$messages['wa'] = array(
	'math_sample' => "Tapez l' formule matematike chal",
	'math_tip' => 'Formule matematike (LaTeX)',
	'prefs-math' => 'Formules matematikes',
	'mw_math_png' => 'Håyner tofer come ene imådje PNG',
	'mw_math_source' => 'El leyî e TeX (po les betchteus e môde tecse)',
	'math_unknown_error' => 'aroke nén cnoxhowe',
	'math_unknown_function' => 'fonccion nén cnoxhowe',
	'math_syntax_error' => 'aroke di sintacse',
	'math_image_error' => 'Li cviersaedje e PNG a fwait berwete; verifyîz ki les programes latex, dvips, gs eyet convert ont stî astalés comifåt',
	'math_bad_tmpdir' => "Dji n' sai nén scrire ou ahiver l' ridant timporaire po les formules matematikes",
	'math_bad_output' => "Dji n' sai nén scrire ou ahiver l' ridant po les fitchîs di rexhowe des formules matematikes",
	'math_notexvc' => 'I manke li fitchî enondåve texvc; lijhoz math/README po-z apontyî.',
);

/** Wolof (Wolof)
 * @author Ibou
 */
$messages['wo'] = array(
	'math_sample' => 'Duggalal sa mbind fii',
	'math_tip' => 'Mbindu xayma (LaTeX)',
	'prefs-math' => 'Xayma',
	'math_failure' => 'Njuumte ci xayma',
	'math_unknown_error' => 'Njuumte li xamuñ ko',
	'math_unknown_function' => 'Solo si xamuñ ko',
	'math_lexing_error' => 'Njuumteg mbindin',
	'math_syntax_error' => 'njuumtey mbindin',
);

/** Wu (吴语)
 * @author Wu-chinese.com
 */
$messages['wuu'] = array(
	'math_sample' => '箇搭嵌入数学公式',
	'math_tip' => '插入数学公式 （LaTeX）',
	'prefs-math' => '数学公式',
);

/** Kalmyk (Хальмг)
 * @author Huuchin
 */
$messages['xal'] = array(
	'math_sample' => 'Энд тегштклиг бичтн',
	'math_tip' => 'Тегшткл (LaTeX)',
	'prefs-math' => 'Тетшкүлүд',
);

/** Mingrelian (მარგალური)
 * @author Dawid Deutschland
 */
$messages['xmf'] = array(
	'math_sample' => 'ქინახუნეთ ფორმულა თაქ',
	'math_tip' => 'მათემატიკურ ფორმულა (LaTeX)',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'math_sample' => 'לייגט אריין פארמל דא',
	'math_tip' => 'מאטעמאטישע פארמל (LaTeX)',
	'prefs-math' => 'פאָרמאַל',
	'math_unknown_error' => 'אומבאַקאַנטער פֿעלער',
	'math_unknown_function' => 'אומבאַקאַנטע פֿונקציע',
	'math_lexing_error' => 'לעקסינג טעות',
	'math_syntax_error' => 'סינטאקס גרייז',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'math_sample' => "Ẹ fi àgbékalẹ̀ s'íhín",
	'math_tip' => 'Àgbékalẹ̀ ìsirò (LaTeX)',
	'prefs-math' => 'Ìṣirò',
	'math_unknown_error' => 'àsiṣe àwámárìdí',
	'math_unknown_function' => 'ìfiṣe àwámárìdí',
	'math_lexing_error' => 'àsiṣe òye ọ̀rọ̀',
);

/** Cantonese (粵語)
 * @author Waihorace
 */
$messages['yue'] = array(
	'math_sample' => '喺呢度插入方程式',
	'math_tip' => '數學方程（LaTeX）',
	'prefs-math' => '數',
	'mw_math_png' => '全部用PNG表示',
	'mw_math_source' => '保留返用TeX（文字瀏覽器用）',
	'math_failure' => '語法拼砌失敗',
	'math_unknown_error' => '唔知錯乜',
	'math_unknown_function' => '唔知乜函數',
	'math_lexing_error' => 'lexing錯誤',
	'math_syntax_error' => '語法錯誤',
	'math_image_error' => 'PNG 轉換失敗；檢查latex、dvipng（或者dvips+gs+convert）係唔係已經正確咁樣安裝',
	'math_bad_tmpdir' => '唔能夠寫入或建立臨時數目錄',
	'math_bad_output' => '唔能夠寫入或建立輸出數目錄',
	'math_notexvc' => 'texvc 執行檔已經遺失；請睇睇 math/README 去較吓。',
);

/** Zeeuws (Zeêuws)
 * @author NJ
 */
$messages['zea'] = array(
	'math_sample' => 'Voer de formule in',
	'math_tip' => 'Wiskundihe formule (LaTeX)',
	'prefs-math' => 'Formules',
	'math_failure' => 'Parsen mislukt',
	'math_unknown_error' => 'onbekende fout',
	'math_unknown_function' => 'onbekende functie',
	'math_lexing_error' => 'lexicohraofische fout',
	'math_syntax_error' => 'syntactische fout',
	'math_image_error' => 'PNG-omzettieng is mislukt. Hi nae of an latex, dvips en gs correct heïnstalleerd zien en zet om',
	'math_bad_tmpdir' => "De map voe tiedelijke bestan'n voe wiskundihe formules besti nie of kan nie emikt worn",
	'math_bad_output' => "De map voe bestan'n mie wiskundihe formules besti nie of kan nie emikt worn.",
	'math_notexvc' => "Kan 't prohramma texvc nie vin'n; stel aolles in volhens de beschrievieng in math/README.",
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'math_sample' => '在此插入数学公式',
	'math_tip' => '插入数学公式 （LaTeX）',
	'prefs-math' => '数学公式',
	'mw_math_png' => '永远使用PNG图像',
	'mw_math_source' => '显示为TeX代码（使用文字浏览器时）',
	'math_failure' => '解析失败',
	'math_unknown_error' => '未知错误',
	'math_unknown_function' => '未知函数',
	'math_lexing_error' => '句法错误',
	'math_syntax_error' => '语法错误',
	'math_image_error' => 'PNG 转换失败 ；检查正确安装的 latex 和 dvipng （或 dvips + gs + convert）',
	'math_bad_tmpdir' => '无法写入或建立数学公式临时目录',
	'math_bad_output' => '无法写入或建立数学公式输出目录',
	'math_notexvc' => '"texvc"执行文件遗失；请参照math/README进行配置。',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'math_sample' => '在此插入數學公式',
	'math_tip' => '插入數學公式 （LaTeX）',
	'prefs-math' => '數學公式',
	'mw_math_png' => '永遠使用PNG圖片',
	'mw_math_source' => '顯示為TeX代碼 （使用文字瀏覽器時）',
	'math_failure' => '解析失敗',
	'math_unknown_error' => '未知錯誤',
	'math_unknown_function' => '未知函數',
	'math_lexing_error' => '句法錯誤',
	'math_syntax_error' => '語法錯誤',
	'math_image_error' => 'PNG 轉換失敗；請檢查是否正確安裝了 latex, dvipng（或dvips + gs + convert）',
	'math_bad_tmpdir' => '無法寫入或建立數學公式臨時目錄',
	'math_bad_output' => '無法寫入或建立數學公式輸出目錄',
	'math_notexvc' => '"texvc"執行檔案遺失；請參照 math/README 進行配置。',
);

/** Chinese (Taiwan) (‪中文(台灣)‬) */
$messages['zh-tw'] = array(
	'mw_math_png' => '永遠使用PNG圖片',
);

/** Zulu (isiZulu) */
$messages['zu'] = array(
	'math_sample' => 'Faka izibalo lapha',
	'prefs-math' => 'Izibalo',
);

