<?php
/**
 * Internationalisation file for ExpandTemplates extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'expandtemplates'                  => 'Expand templates',
	'expandtemplates-desc'             => '[[Special:ExpandTemplates|Expands templates, parser functions and variables]] to show expanded wikitext and preview rendered page',
	'expand_templates_intro'           => 'This special page takes some text and expands all templates in it recursively.
It also expands parser functions like
<nowiki>{{</nowiki>#if:…}}, and variables like
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;in fact pretty much everything in double-braces.
It does this by calling the relevant parser stage from MediaWiki itself.',
	'expand_templates_title'           => 'Context title, for {{PAGENAME}} etc.:',
	'expand_templates_input'           => 'Input text:',
	'expand_templates_output'          => 'Result',
	'expand_templates_xml_output'      => 'XML output',
	'expand_templates_ok'              => 'OK',
	'expand_templates_remove_comments' => 'Remove comments',
	'expand_templates_generate_xml'    => 'Show XML parse tree',
	'expand_templates_preview'         => 'Preview',
);

/** Message documentation (Message documentation)
 * @author Jon Harald Søby
 * @author Meno25
 */
$messages['qqq'] = array(
	'expandtemplates-desc' => 'Short description of the ExpandTemplates extension, shown on [[Special:Version]]. Do not translate or change links.',
	'expand_templates_intro' => 'This is the explanation given in the heading of the [[Special:ExpandTemplates]] page; it describes its functionality to the users.',
	'expand_templates_input' => '{{Identical|Input text}}',
	'expand_templates_ok' => '{{Identical|OK}}',
	'expand_templates_preview' => '{{Identical|Preview}}',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'expand_templates_input' => 'Tekst:',
	'expand_templates_output' => "Rezul'tat",
	'expand_templates_xml_output' => 'XML-lähtmižvend',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Čuta kommentarijad',
	'expand_templates_preview' => 'Ezikacund',
);

/** Afrikaans (Afrikaans)
 * @author Arnobarnard
 * @author Naudefj
 * @author SPQRobin
 */
$messages['af'] = array(
	'expandtemplates' => 'Brei sjablone uit',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Vervang sjablone, ontlederfunksies en veranderlikes]] en gee wikiteks en 'n kontroleweergawe van die bladsy",
	'expand_templates_intro' => 'Hierdie spesiale bladsy lees die invoerteks en vervang al die sjablone rekursief.
Dit vervang ook ontlederfunksies soos
<nowiki>{{</nowiki>#if:…}}, en veranderlikes soos
<nowiki>{{</nowiki>CURRENTDAY}}&mdash; omtrent alles tussen dubbele krulhakkies word vervang.
Dit word gedoen deur die relevante funksies in die MediaWiki-ontleder te roep.',
	'expand_templates_title' => 'Kontekstitel, vir {{PAGENAME}}, ensovoorts:',
	'expand_templates_input' => 'Invoerteks:',
	'expand_templates_output' => 'Resultaat',
	'expand_templates_xml_output' => 'XML-afvoer',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Verwyder kommentaar',
	'expand_templates_generate_xml' => 'Wys XML-ontledingsboom',
	'expand_templates_preview' => 'Voorskou',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'expand_templates_ok' => 'እሺ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'expandtemplates' => 'Espandir plantillas',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Estendilla as plantillas, funzions de parseyo y bariables]] ta amostrar o wikitesto estendillato y prebeyer a pachina',
	'expand_templates_intro' => 'Ista pachina espezial prene bel testo y espande recursibament todas as plantillas que bi ha en el. Tamién espande as funzions parser como <nowiki>{{</nowiki>#if:...}}, y as bariables como <nowiki>{{</nowiki>CURRENTDAY}}&mdash; en cheneral tot o que sía entre dobles claus.
Isto lo fa clamando ta o parser correspondient dende o propio MediaWiki.',
	'expand_templates_title' => 'Títol ta contestualizar ({{PAGENAME}} etz.):',
	'expand_templates_input' => 'Testo ta espandir:',
	'expand_templates_output' => 'Resultau',
	'expand_templates_xml_output' => 'salida XML',
	'expand_templates_ok' => 'Confirmar',
	'expand_templates_remove_comments' => 'Sacar comentarios',
	'expand_templates_generate_xml' => "Amostrar l'árbol de parseyo XML",
	'expand_templates_preview' => 'Prebeyer',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mido
 */
$messages['ar'] = array(
	'expandtemplates' => 'فرد القوالب',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|يفرد القوالب، دوال المحلل والمتغيرات]] لعرض نص الويكي الممدد ورؤية الصفحة الناتجة',
	'expand_templates_intro' => 'تتعامل هذه الصفحة الخاصة مع نصوص الويكي وتقوم بفرد كل القوالب الموجودة به.
وتقوم أيضا بفرد دوال القوالب مثل
<nowiki>{{</nowiki>#if:...}}، والمتغيرات مثل
<nowiki>{{</nowiki>يوم}}-- وتقوم التعامل مع كل ما بين الأقواس المزدوجة.
تقوم بفعل هذا عن طريق استدعاء المعالج المناسب من الميدياويكي.',
	'expand_templates_title' => 'عنوان صفحة هذا النص، لأجل معالجة {{PAGENAME}} إلخ.:',
	'expand_templates_input' => 'النص المدخل:',
	'expand_templates_output' => 'النتيجة',
	'expand_templates_xml_output' => 'خرج XML',
	'expand_templates_ok' => 'موافق',
	'expand_templates_remove_comments' => 'أزل التعليقات',
	'expand_templates_generate_xml' => 'اعرض شجرة XML parse',
	'expand_templates_preview' => 'عرض مسبق',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'expandtemplates' => 'تكبير القوالب',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|بيمدد القوالب, دوال المحلل و المتغيرات]] لعرض نص الويكى المتمدد و بروفة الصفحة الناتجة',
	'expand_templates_intro' => 'الصفحة المخصوصة دى بتاخد بعض النصوص و بتفرد كل القوالب اللى موجودة فيها.
و كمان بتفرد دوال القوالب زي
<nowiki>{{</nowiki>#if:…}}, و المتغيرات زي
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;فى الحقيقة كل حاجة بين قوسين مزدوجين.
و بتعمل دا عن طريق استعداء المعالج المناسب من الميدياويكى نفسها..',
	'expand_templates_title' => 'عنوان السياق, لـ {{PAGENAME}} الخ.:',
	'expand_templates_input' => 'النص المدخل:',
	'expand_templates_output' => 'النتيجه',
	'expand_templates_xml_output' => 'خرج XML',
	'expand_templates_ok' => 'موافق',
	'expand_templates_remove_comments' => 'امسح التعليقات',
	'expand_templates_generate_xml' => 'اعرض شجرة XML',
	'expand_templates_preview' => 'بروفه',
);

/** Assamese (অসমীয়া)
 * @author Rajuonline
 */
$messages['as'] = array(
	'expandtemplates' => 'সাঁচবোৰ বহলাওক',
	'expand_templates_input' => 'পাঠ্য ভৰাওক',
	'expand_templates_output' => 'ফলাফল',
	'expand_templates_ok' => 'ওকে',
	'expand_templates_remove_comments' => 'মন্তব্য গু়চাওক',
	'expand_templates_preview' => 'খচৰা',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'expandtemplates' => 'Esparder plantíes',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Espande plantíes, funciones d'análisis sintáuticu y variables]] p'amosar wikitestu espandíu y previsualizar páxines renderizaes",
	'expand_templates_intro' => "Esta páxina especial ellabora un testu espardiendo toles
plantíes de forma recursiva. Tamién esparde les funciones d'análisis sintáuticu
como <nowiki>{{</nowiki>#if:...}}, y variables como
<nowiki>{{</nowiki>CURRENTDAY}}, en realidá cuasi tolo qu'heba ente llaves dobles. Funciona
llamando a les funciones afechisques d'análisis sintáuticu de MediaWiki.",
	'expand_templates_title' => 'Títulu del contestu, pa {{PAGENAME}}, etc.:',
	'expand_templates_input' => "Testu d'entrada:",
	'expand_templates_output' => 'Resultáu',
	'expand_templates_xml_output' => 'Salida XML',
	'expand_templates_ok' => 'Aceutar',
	'expand_templates_remove_comments' => 'Eliminar comentarios',
	'expand_templates_generate_xml' => "Amosar l'árbole d'análisis sintáuticu XML",
	'expand_templates_preview' => 'Previsualizar',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['bat-smg'] = array(
	'expandtemplates' => 'Ėšskeistė šabluonus',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'expandtemplates' => 'پچ کن تمپلیت آنء',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|تمپلتان مزن کنت،متغییران و عملگران وانت]] په پیشدارگ متون ویکی مزنین و بازبینی شربوتگین صفحات',
	'expand_templates_intro' => 'ای صفحه حاص لهتی متنء گریت و کل تمپلتان ته آییء برگشتی مزنش کنت.
آیی هنچوش عمگر تجزیه کنوکء مزن کنت په داب
<nowiki>{{</nowiki>#if:…}}, و متغییرانی په داب
<nowiki>{{</nowiki>CURRENTDAY}}&mdash; در حقیقت هر چیزی که ته دو براکتن.
آیی ای کارء گون توار کنگ تجزیه کنوک مناسب چه مدیا وی کی وت انجام دنت.',
	'expand_templates_title' => 'عنوان متن په {{PAGENAME}} و دگه.:',
	'expand_templates_input' => 'ورودی متن',
	'expand_templates_output' => 'نتیجه',
	'expand_templates_xml_output' => 'خروجی XML',
	'expand_templates_ok' => 'هوبنت',
	'expand_templates_remove_comments' => 'بزور نظرات',
	'expand_templates_generate_xml' => 'پیش دار درچک تجزیه XMLء',
	'expand_templates_preview' => 'بازبین',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'expand_templates_output' => 'Resulta',
	'expand_templates_remove_comments' => 'Tanggalon an mga komento',
	'expand_templates_preview' => 'Patânaw',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'expandtemplates' => 'Разгортваньне шаблёнаў',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Разгортвае шаблёны, функцыі парсэра і зьменныя]] для паказу разгорнутага вікі-тэксту і папярэдняга прагляду старонкі',
	'expand_templates_intro' => 'Гэта спэцыяльная старонка пераўтварае тэкст і разгортвае ўсе шаблёны рэкурсіўна.
Адначасова разгортваюцца функцыі парсэра накшталт 
<nowiki>{{</nowiki>#if:…}}, і зьменныя накшталт 

<nowiki>{{</nowiki>CURRENTDAY}}&mdash; увогуле, усё ўнутры падвойных фігурных дужак.
Гэта адбываецца праз вызаў адпаведнага парсэра апрацоўшчыка MediaWiki.',
	'expand_templates_title' => 'Загаловак старонкі, для {{PAGENAME}} і г.д.:',
	'expand_templates_input' => 'Крынічны тэкст:',
	'expand_templates_output' => 'Вынік',
	'expand_templates_xml_output' => 'вынік у фармаце XML',
	'expand_templates_ok' => 'Добра',
	'expand_templates_remove_comments' => 'Выдаліць камэнтары',
	'expand_templates_generate_xml' => 'Паказаць дрэва аналізу XML',
	'expand_templates_preview' => 'Папярэдні прагляд',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author Spiritia
 */
$messages['bg'] = array(
	'expandtemplates' => 'Разгръщане на шаблони',
	'expand_templates_title' => 'Заглавие на страницата (напр. за {{PAGENAME}}):',
	'expand_templates_input' => 'Входящ текст:',
	'expand_templates_output' => 'Резултат',
	'expand_templates_xml_output' => 'Изход на XML',
	'expand_templates_ok' => 'ОК',
	'expand_templates_remove_comments' => 'Премахване на коментари',
	'expand_templates_generate_xml' => 'Показване на дървото от разбора на XML',
	'expand_templates_preview' => 'Преглед',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Zaheen
 */
$messages['bn'] = array(
	'expandtemplates' => 'টেম্পলেট সম্প্রসারণ',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|টেম্পলেট, পার্সার ফাংশন এবং ভ্যারিয়েবল সপ্রসারণ করে]] সম্প্রসারিত উইকিটেক্সট দেখুন এবং উপস্থাপিত পাতাটি প্রাকদর্শন করুন',
	'expand_templates_intro' => 'এই বিশেষ পাতাটি কিছু টেক্সট গ্রহণ করে এবং এর ভেতরের সব টেম্পলেট বারংবার সম্প্রসারিত করে।
এছাড়াও এটি 
<nowiki>{{</nowiki>#if:...}}-এর মত পার্সার ফাংশন,
<nowiki>{{</nowiki>CURRENTDAY}-এর মত ভ্যারিয়েবল &mdash; মোটকথা দ্বিতীয় বন্ধনীর মধ্যে অবস্থিত সবকিছুকেই সম্প্রসারিত করতে পারে।
এটি সংশ্লিষ্ট পার্সার পর্যায় থেকে স্বয়ং মিডিয়াউইকিকে কল করে এই কাজটি করে থাকে।',
	'expand_templates_title' => 'প্রাতিবেশিক শিরোনাম, {{PAGENAME}}, ইত্যাদির জন্য:',
	'expand_templates_input' => 'ইনপুটকৃত লেখা:',
	'expand_templates_output' => 'ফলাফল',
	'expand_templates_xml_output' => 'XML আউটপুট',
	'expand_templates_ok' => 'ঠিক আছে',
	'expand_templates_remove_comments' => 'মন্তব্য মুছে ফেলো',
	'expand_templates_generate_xml' => 'XML পার্স বৃক্ষ দেখাও',
	'expand_templates_preview' => 'প্রাকদর্শন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'expandtemplates' => 'Emled ar patromoù',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Astenn a ra ar patromoù, an arc'hwelioù parser hag an argemmoù]] evit diskouez an testennoù wiki astennet ha rakwelet tres ar pajennoù a seurt-se.",
	'expand_templates_intro' => "Kemer a ra ar bajenn zibar-mañ tammoù testenn hag astenn a ra an holl batromoù enni en un doare azkizat.
Astenn a ra ivez an arc'hwelioù parser evel
<nowiki>{{</nowiki>#if:…}}, hag an argemmoù evel
<nowiki>{{</nowiki>CURRENTDAY}}&mdash; e gwirionez, koulz lavaret kement tra zo etre briataennoù.
Ober a ra kement-mañ dre c'hervel pazenn ar parser a zegouezh digant MediaWiki e-unan.",
	'expand_templates_title' => 'Titl ar gendestenn, evit {{PAGENAME}} h.a. :',
	'expand_templates_input' => 'Merkañ ho testenn amañ :',
	'expand_templates_output' => "Disoc'h :",
	'expand_templates_xml_output' => 'Ezvont XML',
	'expand_templates_ok' => 'Mat eo',
	'expand_templates_remove_comments' => 'Lemel an notennoù kuit',
	'expand_templates_generate_xml' => 'Gwelet ar gwezennadur XML',
	'expand_templates_preview' => 'Rakwelet',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'expandtemplates' => 'Proširi šablone',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Proširivanje šablona, parserskih funkcija i promijenjivih]] za prikaz proširenog wiki teksta i pregleda iscrtanih stranica',
	'expand_templates_intro' => 'Ova posebna stranica uzima neki tekst i proširuje sve šablone u njemu rekurzivno.
Ona također proširuje parserske funkcije poput
<nowiki>{{</nowiki>#if:…}} i varijable poput
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;u principu gotovo sve između dvostrukih zagrada.
Ovo se uradi putem poziva relevantnog parserskog nivoa iz same MediaWiki.',
	'expand_templates_title' => 'Naslov konteksta, za {{PAGENAME}} itd.:',
	'expand_templates_input' => 'Tekst unosa:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'XML izlaz',
	'expand_templates_ok' => 'U redu',
	'expand_templates_remove_comments' => 'Ukloni komentare',
	'expand_templates_generate_xml' => 'Prikaži XML stablo parsera',
	'expand_templates_preview' => 'Pregled',
);

/** Catalan (Català)
 * @author SMP
 * @author Toniher
 */
$messages['ca'] = array(
	'expandtemplates' => 'Expansió de plantilles',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandeix plantilles, funcions i variables]] per a mostrar-vos la sintaxi expandida i previsualitzar el resultat que es mostrarà a les pàgines',
	'expand_templates_intro' => 'Aquesta pàgina especial permet provar plantilles, amb expansions recursives. Les funcions i les variables predefinides, com ara <nowiki>{{</nowiki>#if:...}} o <nowiki>{{</nowiki>CURRENTDAY}}, també són substituïdes.',
	'expand_templates_title' => 'Títol per contextualitzar ({{PAGENAME}}, etc):',
	'expand_templates_input' => 'El vostre text:',
	'expand_templates_output' => 'Resultat:',
	'expand_templates_xml_output' => 'Sortida XML',
	'expand_templates_ok' => "D'acord",
	'expand_templates_remove_comments' => 'Elimina els comentaris',
	'expand_templates_generate_xml' => "Mostra l'arbre XML",
	'expand_templates_preview' => 'Previsualitza',
);

/** Chechen (Нохчийн) */
$messages['ce'] = array(
	'expand_templates_remove_comments' => 'Комментариш дIаяккха',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'expand_templates_output' => 'Risultatu',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Li-sung
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'expandtemplates' => 'Substituce šablon',
	'expandtemplates-desc' => 'Rozbaluje šablony, funkce parseru a proměnné; zobrazuje rozbalený wikitext a náhled stránky, jak se zobrazí',
	'expand_templates_intro' => 'Pomocí této speciální stránky můžete nechat v textu substituovat všechny šablony a funkce parseru jako <code><nowiki>{{</nowiki>#if:…...}}</code> či proměnné jako <code><nowiki>{{</nowiki>CURRENTDAY}}</code> – tzn. prakticky všechno v dvojitých složených závorkách. K tomu se používají přímo odpovídající funkce parseru MediaWiki.',
	'expand_templates_title' => 'Název stránky kvůli kontextu pro {{PAGENAME}} apod.:',
	'expand_templates_input' => 'Vstupní text:',
	'expand_templates_output' => 'Výstup',
	'expand_templates_xml_output' => 'Výstup XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Odstranit komentáře',
	'expand_templates_generate_xml' => 'Zobrazit syntaktický strom v XML',
	'expand_templates_preview' => 'Náhled',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 */
$messages['da'] = array(
	'expandtemplates' => 'Udfold skabeloner',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Udfolder skabeloner, oversætterfunktioner og variabler]] for at vise den resulterende wikitekst og en forhåndsvisning af en side med den',
	'expand_templates_intro' => 'Denne specialside tager noget tekst og folder alle skabeloner ud rekursivt.
Den udfolder også specielle oversætterfunktioner såsom <nowiki>{{#if:...}}</nowiki> samt variabler såsom <nowiki>{{CURRENTDAY}}</nowiki> –
faktisk folder den næsten hvad som helst i dobbelte krøllede parenteser ud.
Den gør det ved at kalde det relevante analysetrin i MediaWiki-softwaren.',
	'expand_templates_title' => 'Titlen på siden som {{PAGENAME}} og tilsvarende skal tolkes ud fra:',
	'expand_templates_input' => 'Inputtekst:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-kode',
	'expand_templates_ok' => 'Udfold',
	'expand_templates_remove_comments' => 'Fjern kommentarer',
	'expand_templates_generate_xml' => 'Vis analysetræ som XML',
	'expand_templates_preview' => 'Forhåndsvisning',
);

/** German (Deutsch)
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'expandtemplates' => 'Vorlagen expandieren',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandiert Vorlagen, Parser-Funktionen und Variablen]] zu vollständigem Wikitext und zeigt die gerenderte Vorschau',
	'expand_templates_intro' => 'In diese Spezialseite kann Text eingegeben werden und alle Vorlagen in ihr werden rekursiv expandiert. Auch Parserfunkionen wie <code><nowiki>{{</nowiki>#if:…}}</code> und Variablen wie <code><nowiki>{{</nowiki>CURRENTDAY}}</code> werden ausgewertet - faktisch alles was in doppelten geschweiften Klammern enthalten ist. Dies geschieht durch den Aufruf der jeweiligen Parser-Phasen in MediaWiki.',
	'expand_templates_title' => 'Kontexttitel, für {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Eingabefeld:',
	'expand_templates_output' => 'Ergebnis',
	'expand_templates_xml_output' => 'XML-Ausgabe',
	'expand_templates_ok' => 'Ausführen',
	'expand_templates_remove_comments' => 'Kommentare entfernen',
	'expand_templates_generate_xml' => 'Zeige XML-Parser-Baum',
	'expand_templates_preview' => 'Vorschau',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'expandtemplates' => 'Pśedłogi ekspanděrowaś',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Ekspanděrujo pśedłogi, parserowe funkcije a wariable]], aby dopołny wikitekst pokazał a woblicony pśeglěd zwobraznił',
	'expand_templates_intro' => 'Na toś tom boku dajo se tekst zapódaś a wšykne pśedłogi na njom se rekursiwnje ekspanděruju. Teke parserowe funkcije kaž <nowiki>{{</nowiki>#if:…}} a wariable kaž <nowiki>{{</nowiki>CURRENTDAY}} se ekspanděruju - faktiski wšo, což stoj mjazy dwójnymi wugibnjonymi spinkami. To stawa se pśez zawołanje daneje parseroweje faze z MediaWiki.',
	'expand_templates_title' => 'Kontekstowy titel, za {{PAGENAME}} atd.',
	'expand_templates_input' => 'Zapódany tekst:',
	'expand_templates_output' => 'Wuslědk',
	'expand_templates_xml_output' => 'Wudany XML',
	'expand_templates_ok' => 'W pórěźe',
	'expand_templates_remove_comments' => 'Komentary wótwónoźeś',
	'expand_templates_generate_xml' => 'Parsowański bom XML pokazaś',
	'expand_templates_preview' => 'Pśeglěd',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'expand_templates_preview' => 'Kpɔe do ŋgɔ',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Dead3y3
 * @author ZaDiak
 */
$messages['el'] = array(
	'expandtemplates' => 'Επέκτεινε τα πρότυπα',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Αναπτύσσει πρότυπα, συναρτήσεις συντακτικού αναλυτή και μεταβλητές]] για την εμφάνιση του αναπτυγμένου κειμένου wiki και της προεπισκόπησης της ερμηνευμένης σελίδας',
	'expand_templates_intro' => 'Αυτή η ειδική σελίδα παίρνει κάποιο κείμενο και αναπτύσσει όλα τα πρότυπα σε αυτό αναδρομικά.<br />
Επίσης αναπτύσσει συναρτήσεις συντακτικού αναλυτή όπως η<br />
<nowiki>{{</nowiki>#if:…}}, και μεταβλητές όπως η<br />
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;Ουσιαστικά τα πάντα σε διπλές αγκύλες.<br />
Αυτό το κάνει καλώντας το σχετικό στάδιο του συντακτικού αναλυτή από το MediaWiki αυτό καθαυτό.',
	'expand_templates_title' => 'Τίτλων συμφραζόμενων, για την {{PAGENAME}} κ.τ.λ.:',
	'expand_templates_input' => 'Κείμενο εισόδου:',
	'expand_templates_output' => 'Αποτέλεσμα',
	'expand_templates_xml_output' => 'Έξοδος XML',
	'expand_templates_ok' => 'ΟΚ',
	'expand_templates_remove_comments' => 'Αφαίρεση σχολίων',
	'expand_templates_generate_xml' => 'Εμφάνιση δέντρου συντακτικής ανάλυσης XML',
	'expand_templates_preview' => 'Προεπισκόπηση',
);

/** Esperanto (Esperanto)
 * @author Tlustulimu
 * @author Yekrats
 */
$messages['eo'] = array(
	'expandtemplates' => 'Ampleksigi ŝablonojn',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Etendas ŝablonojn, sintaksaj funkciojn, kaj variablojn]] montri etenditan vikitekston kaj antaŭvidi faritan paĝon',
	'expand_templates_intro' => 'Ĉi tiu speciala paĝo traktas tekston kaj ampleksigas ĉiujn ŝablonojn en ĝi rekursie.
Ĝi ankaŭ ampleksigas sintaksajn funkciojn kiel 
<nowiki>{{</nowiki>#if:…}}, variablojn kiel
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;fakte preskaŭ iujn ajn en duoblaj krampoj.
Ĝi faras tion per vokado de la koncerna sintaksa kodpeco de MediaWiki mem.',
	'expand_templates_title' => 'Kunteksta titolo, por {{PAGENAME}}, ktp.:',
	'expand_templates_input' => 'Enigita teksto:',
	'expand_templates_output' => 'Rezulto',
	'expand_templates_xml_output' => 'XML-eligo',
	'expand_templates_ok' => 'Ek!',
	'expand_templates_remove_comments' => 'Forigi komentojn',
	'expand_templates_generate_xml' => 'Montri XML-sintaksarbon',
	'expand_templates_preview' => 'Antaŭrigardo',
);

/** Spanish (Español)
 * @author Icvav
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 */
$messages['es'] = array(
	'expandtemplates' => 'Sustituidor de plantillas',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expande plantillas, funciones del parser y variables]] para mostrar wikitexto expandido y previstar la página renderizada',
	'expand_templates_intro' => 'Esta página especial toma texto cualquiera y expande todas sus plantillas recursivamente.
También expande las funciones sintácticas como <nowiki>{{</nowiki>#if:…}} y variables como
<nowiki>{{</nowiki>CURRENTDAY}}. De hecho, expande casi cualquier cosa que esté entre llaves dobles.
Lo hace llamando al nivel del analizador sintáctico correspondiente del propio MediaWiki.',
	'expand_templates_title' => 'Título para contexto, para {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Texto a expandir:',
	'expand_templates_output' => 'Resultado:',
	'expand_templates_xml_output' => 'Salida XML',
	'expand_templates_ok' => 'Aceptar',
	'expand_templates_remove_comments' => 'Eliminar comentarios',
	'expand_templates_generate_xml' => 'Mostrar el árbol XML.',
	'expand_templates_preview' => 'Previsualización',
);

/** Estonian (Eesti)
 * @author Ker
 */
$messages['et'] = array(
	'expandtemplates' => 'Mallide lahendamine',
);

/** Basque (Euskara)
 * @author Theklan
 */
$messages['eu'] = array(
	'expandtemplates' => 'Txantiloi ordezkatzailea',
	'expand_templates_intro' => 'Aparteko orrialde honek modu errekurtsiboan txantiloiak ordezkatu egiten ditu. Funtzioak ere ordezkatu egiten ditu, hala nola <nowiki>{{</nowiki>#if:...}}, eta baita <nowiki>{{</nowiki>CURRENTDAY}} bezalako aldagaiak ere.',
	'expand_templates_title' => 'Izenburua ({{PAGENAME}} ordezkatzeko, eta abar):',
	'expand_templates_input' => 'Sarrerako testua:',
	'expand_templates_output' => 'Emaitza',
	'expand_templates_xml_output' => 'XML irteera',
	'expand_templates_ok' => 'Ados',
	'expand_templates_remove_comments' => 'Iruzkinak kendu',
	'expand_templates_generate_xml' => 'Erakutsi XML parse zuhaitza',
	'expand_templates_preview' => 'Aurreikusi',
);

/** Extremaduran (Estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'expand_templates_preview' => 'Previsoreal',
);

/** Persian (فارسی)
 * @author Huji
 */
$messages['fa'] = array(
	'expandtemplates' => 'بسط‌دادن الگوها',
	'expandtemplates-desc' => 'الگوها، دستورهای تجزیه‌کننده و متغیرها را گسترش می‌دهد تا متن نهایی را نمایش دهد و صفحه را به پیش‌نمایش در آورد',
	'expand_templates_intro' => 'این صفحهٔ ویژه متنی را دریافت کرده و تمام الگوهای به‌کاررفته در آن را به طور بازگشتی بسط می‌دهد. همچنین تابع‌های تجزیه چون <nowiki>{{</nowiki>#if:...}} و متغیرهایی چون  <nowiki>{{</nowiki>CURRENTDAY}} را هم بسط می‌دهد — در واقع تقریباً هرچه را که داخل دوآکولاد باشد. این کار با صدازدن مرحلهٔ تجزیهٔ مربوط در خود مدیاویکی صورت می‌گیرد.',
	'expand_templates_title' => 'عنوان موضوع، برای {{PAGENAME}} و غیره:',
	'expand_templates_input' => 'متن ورودی:',
	'expand_templates_output' => 'نتیجه',
	'expand_templates_xml_output' => 'خروجی XML',
	'expand_templates_ok' => 'تایید',
	'expand_templates_remove_comments' => 'حذف توضیحات',
	'expand_templates_generate_xml' => 'نمایش درخت تجزیهٔ XML',
	'expand_templates_preview' => 'پیش‌نمایش',
);

/** Finnish (Suomi)
 * @author Agony
 * @author Crt
 * @author Nike
 */
$messages['fi'] = array(
	'expandtemplates' => 'Mallineiden laajennus',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Laajentaa mallineet, jäsentimen funktiot sekä muuttujat]] wikitekstiksi sekä näyttää esikatseluversion laajennetusta sivusta',
	'expand_templates_intro' => 'Tämä toimintosivu ottaa syötteekseen tekstiä ja laajentaa kaikki mallineet rekursiivisesti sekä jäsenninfunktiot, kuten <nowiki>{{</nowiki>#if:...}}, ja -muuttujat, kuten <nowiki>{{</nowiki>CURRENTDAY}} &mdash; toisin sanoen melkein kaiken, joka on kaksoisaaltosulkeiden sisällä.',
	'expand_templates_title' => 'Otsikko (esimerkiksi muuttujaa {{PAGENAME}} varten)',
	'expand_templates_input' => 'Teksti',
	'expand_templates_output' => 'Tulos',
	'expand_templates_xml_output' => 'XML-tuloste',
	'expand_templates_ok' => 'Laajenna',
	'expand_templates_remove_comments' => 'Poista kommentit',
	'expand_templates_generate_xml' => 'Näytä XML-jäsennyspuu',
	'expand_templates_preview' => 'Esikatselu',
);

/** Faroese (Føroyskt)
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'expand_templates_output' => 'Úrslit',
	'expand_templates_ok' => 'Í lagi',
	'expand_templates_preview' => 'Forskoðan',
);

/** French (Français)
 * @author Grondin
 * @author IAlex
 * @author Sherbrooke
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'expandtemplates' => 'Expansion des modèles',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Réalise l’expansion des modèles, fonctions parseurs et variables]] afin de visionner le texte wiki obtenu après expansion et prévisualiser le rendu effectif de la page.',
	'expand_templates_intro' => 'Cette page spéciale accepte un texte wiki source et permet de réaliser récursivement l’expansion des modèles qu’il contient.
Elle réalise aussi l’expansion des fonctions du parseur telles que
<tt><nowiki>{{</nowiki>#if:...<nowiki>}}</nowiki></tt>  et des variables prédéfinies telles que
<tt><nowiki>{{</nowiki>CURRENTDAY<nowiki>}}</nowiki></tt> — en fait pratiquement tout ce qui est encadré par des doubles accolades.
Elle réalise ceci en appelant les étages successifs appropriés du parseur de MediaWiki lui-même.',
	'expand_templates_title' => 'Titre de la page, si le code utilise {{PAGENAME}}, etc. :',
	'expand_templates_input' => 'Texte wiki source :',
	'expand_templates_output' => 'Texte wiki obtenu après expansion',
	'expand_templates_xml_output' => 'Résultat intermédiaire de l’analyse, au format XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Supprimer les commentaires',
	'expand_templates_generate_xml' => "Afficher l’arbre d'analyse au format XML",
	'expand_templates_preview' => 'Aperçu du rendu',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'expandtemplates' => 'Èxpension des modèlos',
	'expandtemplates-desc' => 'Ôgmente los modèlos, les fonccions d’analisa et les variâbles por visionar los tèxtes vouiquis ètendus et prèvisualise les pâges rendues d’ense.',
	'expand_templates_intro' => 'Ceta pâge pèrmèt d’èprovar l’èxpension de modèlos,
que sont dèvelopâs rècursivament. Les fonccions et les variâbles prèdèfenies,
tâles que <nowiki>{{</nowiki>#if:...}} et <nowiki>{{</nowiki>CURRENTDAY}}, sont asse-ben dèvelopâs.',
	'expand_templates_title' => 'Titro de l’articllo, utilo per ègzemplo se lo modèlo utilise {{PAGENAME}} :',
	'expand_templates_input' => 'Entrâd voutron tèxte ique :',
	'expand_templates_output' => 'Rèsultat',
	'expand_templates_xml_output' => 'Sortia XML',
	'expand_templates_ok' => 'D’acôrd',
	'expand_templates_remove_comments' => 'Suprimar los comentèros.',
	'expand_templates_generate_xml' => 'Afichiér l’arborèscence XML.',
	'expand_templates_preview' => 'Prèvisualisacion',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'expand_templates_output' => 'Risultât',
	'expand_templates_ok' => 'Va ben',
	'expand_templates_preview' => 'Anteprime',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'expand_templates_remove_comments' => 'Scrios nótaí tráchta',
);

/** Galician (Galego)
 * @author Alma
 * @author Toliño
 * @author Xosé
 */
$messages['gl'] = array(
	'expandtemplates' => 'Ampliar os modelos',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Amplía modelos, analiza funcións e variables]] para amosar wikitexto expandido e unha vista previa da páxina renderizada',
	'expand_templates_intro' => 'Esta páxina especial toma texto e amplía todos os modelos dentro del recursivamente.
Tamén expande as funcións de análise como <nowiki>{{</nowiki>#if:…}} e variables como
<nowiki>{{</nowiki>CURRENTDAY}} &mdash;de feito, case calquera cousa entre chaves duplas.
Faino chamando a etapa de análise correspondente do propio MediaWiki.',
	'expand_templates_title' => 'Título do contexto, para {{PAGENAME}}, etc.:',
	'expand_templates_input' => 'Texto de entrada:',
	'expand_templates_output' => 'Resultado',
	'expand_templates_xml_output' => 'saída XML',
	'expand_templates_ok' => 'De acordo',
	'expand_templates_remove_comments' => 'Eliminar os comentarios',
	'expand_templates_generate_xml' => 'Amosar as árbores de análise XML',
	'expand_templates_preview' => 'Vista previa',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'expandtemplates' => 'Ἐπεκτείνειν τὰ πρότυπα',
	'expand_templates_output' => 'Ἀποτέλεσμα',
	'expand_templates_ok' => 'εἶεν',
	'expand_templates_preview' => 'Προθεώρησις',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 * @author J. 'mach' wust
 */
$messages['gsw'] = array(
	'expandtemplates' => 'Vorlage expandiere',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandiert Vorlage, Parser-Funktione un Variable]] zue vollständigem Wikitext un zeigt di grendert Vorschau',
	'expand_templates_intro' => 'In däre Spezialsyte cha Täxt yygee wäre und alli Vorlage in ere wäre rekursiv expandiert. Au Parserfunkione wie <nowiki>{{</nowiki>#if:…}} un Variable wie <nowiki>{{</nowiki>CURRENTDAY}} wäre usgwärtet - faktisch alles was in dopplete gschweifte Chlammere din isch. Des gschiht dur dr Ufruef vu dr jewyylige Parser-Phase in MediaWiki.',
	'expand_templates_title' => 'Kontexttitel, fir {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Yygabfäld:',
	'expand_templates_output' => 'Ergebnis',
	'expand_templates_xml_output' => 'XML-Usgab',
	'expand_templates_ok' => 'Uusfiere',
	'expand_templates_remove_comments' => 'Kommentar useneh',
	'expand_templates_generate_xml' => 'Zeig XML-Parser-Baum',
	'expand_templates_preview' => 'Vorschou',
);

/** Gujarati (ગુજરાતી) */
$messages['gu'] = array(
	'expand_templates_output' => 'પરિણામ:',
	'expand_templates_ok' => 'મંજૂર',
);

/** Manx (Gaelg)
 * @author MacTire02
 */
$messages['gv'] = array(
	'expand_templates_ok' => 'OK',
	'expand_templates_preview' => 'Roie-haishbynys',
);

/** Hawaiian (Hawai`i)
 * @author Kalani
 * @author Singularity
 */
$messages['haw'] = array(
	'expand_templates_ok' => 'Hiki nō',
	'expand_templates_preview' => 'Nāmua',
);

/** Hebrew (עברית)
 * @author Meno25
 * @author Rotem Liss
 */
$messages['he'] = array(
	'expandtemplates' => 'פריסת תבניות',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|פריסת תבניות, הוראות תנאי ומשתנים]] כדי להציג את טקסט הוויקי הפרוס ולבצע תצוגה מקדימה של דף מפוענח',
	'expand_templates_intro' => 'דף זה מקבל כמות מסוימת של טקסט ופורס ומפרש את כל התבניות שבתוכו באופן רקורסיבי. בנוסף, הוא פורס הוראות פירוש כגון <nowiki>{{</nowiki>#תנאי:...}}, ומשתנים כגון <nowiki>{{</nowiki>יום נוכחי}}, ולמעשה פחות או יותר כל דבר בסוגריים מסולסלות כפולות. הוא עושה זאת באמצעות קריאה לפונקציות הפענוח המתאימות מתוך תוכנת מדיה־ויקי עצמה.',
	'expand_templates_title' => 'כותרת ההקשר לפענוח, בשביל משתנים כגון {{PAGENAME}} וכדומה:',
	'expand_templates_input' => 'טקסט:',
	'expand_templates_output' => 'תוצאה',
	'expand_templates_xml_output' => 'פלט XML',
	'expand_templates_ok' => 'פריסת תבניות',
	'expand_templates_remove_comments' => 'הסרת הערות',
	'expand_templates_generate_xml' => 'הצגת עץ הפענוח של XML',
	'expand_templates_preview' => 'תצוגה מקדימה',
);

/** Hindi (हिन्दी)
 * @author Kaustubh
 * @author Shyam
 */
$messages['hi'] = array(
	'expandtemplates' => 'टेम्प्लेट्स बढायें',
	'expandtemplates-desc' => 'विकी विषय वस्तु में विस्तार प्रदर्शन एवं पूर्वदर्शन प्रदर्शन हेतु [[Special:ExpandTemplates|सांचे, प्रेजर फलनों एवं परिवर्तों में विस्तार करें]]।',
	'expand_templates_intro' => 'यह विशेष पृष्ठ कुछ विषय वस्तु लेता है और सभी सांचों को बार-बार फैलाता है।
यह प्रेजर फलनों को भी फैलाता है, जैसे - 
<nowiki>{{</nowiki>#if:…}}, और परिवर्तियों को, जैसे -
<nowiki>{{</nowiki>तत्कालीनदिन}}&mdash; वास्तव में दोहरे-कोष्टक में लगभग सभी को फैलाता है।
यह मीडियाविकी ही से संबंधित प्रेजर स्तर को बुलाकर कार्य करता है।',
	'expand_templates_title' => '{{PAGENAME}} इ. के लिये, कन्टेक्स्ट शीर्षक:',
	'expand_templates_input' => 'इनपुट पाठ:',
	'expand_templates_output' => 'रिज़ल्ट',
	'expand_templates_xml_output' => 'XML आउटपुट',
	'expand_templates_ok' => 'ओके',
	'expand_templates_remove_comments' => 'टिप्पणी हटायें',
	'expand_templates_generate_xml' => 'XML का पार्स (parse) वृक्ष दर्शायें',
	'expand_templates_preview' => 'झलक',
);

/** Hiligaynon (Ilonggo)
 * @author Jose77
 */
$messages['hil'] = array(
	'expand_templates_preview' => 'Ipakita subong',
);

/** Croatian (Hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'expandtemplates' => 'Prikaz sadržaja predložaka',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Proširanje predložaka, parserskih funkcija i varijabli]] za prikaz proširenog wikiteksta i pregled prevedene stranice',
	'expand_templates_intro' => 'Ova posebna stranica omogućuje unos wikiteksta i prikazuje njegov rezultat,
uključujući i (rekurzivno, tj. potpuno) sve uključene predloške u wikitekstu.
Prikazuje i rezultate funkcija kao <nowiki>{{</nowiki>#if:...}} i varijabli
kao <nowiki>{{</nowiki>CURRENTDAY}}. Funkcionira pozivanjem parsera same MedijeWiki.',
	'expand_templates_title' => 'Kontekstni naslov stranice, za {{PAGENAME}} i sl.:',
	'expand_templates_input' => 'Ulazni tekst:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'XML kod',
	'expand_templates_ok' => 'Prikaži',
	'expand_templates_remove_comments' => 'Ukloni komentare',
	'expand_templates_generate_xml' => 'Prikaži XML stablo',
	'expand_templates_preview' => 'Vidi kako će izgledati',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'expandtemplates' => 'Předłohi ekspandować',
	'expandtemplates-desc' => 'Rozšěrja předłohi, parserowe funkcije a wariable, zo by so rozšěrjeny wikitekst pokazał a wobličena strona zwobrazniła',
	'expand_templates_intro' => 'Na tutej specialnej stronje móžeš tekst zapodać a wšitke do njeje zapřijate předłohi so rekursiwnje ekspanduja. Tež funkcije parsera kaž <nowiki>{{</nowiki>#if:...}} a wariable kaž <nowiki>{{</nowiki>CURRENTDAY}} so wuhódnočeja – faktisce wšo, štož steji mjezy dwójnymaj wopušatymaj spinkomaj. To so přez zawołanje jednotliwych fazow parsera software MediaWiki stawa.',
	'expand_templates_title' => 'Kontekstowy titul, za {{PAGENAME}} atd.:',
	'expand_templates_input' => 'Tekst zapodać:',
	'expand_templates_output' => 'Wuslědk',
	'expand_templates_xml_output' => 'Wudaće XML',
	'expand_templates_ok' => 'Wuwjesć',
	'expand_templates_remove_comments' => 'Komentary wotstronić',
	'expand_templates_generate_xml' => 'Analyzowy štom XML pokazać',
	'expand_templates_preview' => 'Přehlad',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author KossuthRad
 */
$messages['hu'] = array(
	'expandtemplates' => 'Sablonok kibontása',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Kiértékeli a sablonokat, az értelmező-funkciókat és a változókat]], így megtekinthető a kész wikiszöveg, valamint az oldal',
	'expand_templates_intro' => 'Ez a speciális lap a bevitt szövegekben megkeresi a sablonokat és rekurzívan kibontja őket.
Kibontja az elemző függvényeket (pl. <nowiki>{{</nowiki>#if:...}}), és a változókat (pl. <nowiki>{{</nowiki>CURRENTDAY}}) is – mindent, ami a kettős kapcsos zárójelek között van.',
	'expand_templates_title' => 'Szöveg címe, például {{PAGENAME}} sablonhoz:',
	'expand_templates_input' => 'Vizsgálandó szöveg',
	'expand_templates_output' => 'Eredmény',
	'expand_templates_xml_output' => 'XML kimenet',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Megjegyzések eltávolítása',
	'expand_templates_generate_xml' => 'XML elemzési fa mutatása',
	'expand_templates_preview' => 'Előnézet',
);

/** Armenian (Հայերեն)
 * @author Teak
 */
$messages['hy'] = array(
	'expandtemplates' => 'Կաղապարների ընդարձակում',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'expandtemplates' => 'Expander patronos',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expande le patronos, functiones del analysator syntactic e variabiles]] pro revelar le texto wiki expandite e previsualisar le aspecto del pagina',
	'expand_templates_intro' => 'Iste pagina special prende alcun texto e expande recursivemente tote le patronos in illo.
Illo expande etiam le functiones del analysator syntactic como
<nowiki>{{</nowiki>#if:…}}, e variabiles como
<nowiki>{{</nowiki>CURRENTDAY}}; de facto, quasi toto inter accolladas duple.
Illo functiona per appellar le stadio relevante del analysator syntactic a partir de MediaWiki mesme.',
	'expand_templates_title' => 'Titulo de contexto, pro {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Texto de entrata:',
	'expand_templates_output' => 'Resultato',
	'expand_templates_xml_output' => 'Output XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Eliminar commentos',
	'expand_templates_generate_xml' => 'Monstrar arbore syntactic XML',
	'expand_templates_preview' => 'Previsualisation',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'expandtemplates' => 'Pengembangan templat',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Mengembangkan templat, fungsi parser dan variables]] untuk menunjukkan hasil teks wiki dan pratayang halaman hasilnya',
	'expand_templates_intro' => 'Halaman istimewa ini menerima teks dan mengembangkan semua templat di dalamnya secara rekursif. Halaman ini juga menerjemahkan semua fungsi parser seperti <nowiki>{{</nowiki>#if:...}}, dan variabel seperti <nowiki>{{</nowiki>CURRENTDAY}}&mdash;bahkan bisa dibilang segala sesuatu yang berada di antara dua tanda kurung. Ini dilakukan dengan memanggil tahapan parser yang sesuai dari MediaWiki.',
	'expand_templates_title' => 'Judul konteks, untuk {{PAGENAME}} dan lain-lain:',
	'expand_templates_input' => 'Teks sumber:',
	'expand_templates_output' => 'Hasil',
	'expand_templates_xml_output' => 'Hasil XML',
	'expand_templates_ok' => 'Jalankan',
	'expand_templates_remove_comments' => 'Buang komentar',
	'expand_templates_generate_xml' => 'Tampilkan pohon parser XML',
	'expand_templates_preview' => 'Pratayang',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'expand_templates_output' => 'Rezulto',
	'expand_templates_ok' => 'O.K.',
	'expand_templates_preview' => 'Previdar',
);

/** Icelandic (Íslenska)
 * @author S.Örvarr.S
 */
$messages['is'] = array(
	'expand_templates_input' => 'Inntakstexti:',
	'expand_templates_output' => 'Útkoma',
	'expand_templates_xml_output' => 'XML-úttak',
	'expand_templates_ok' => 'Í lagi',
	'expand_templates_remove_comments' => 'Fjarlægja athugasemdir',
	'expand_templates_preview' => 'Forskoða',
);

/** Italian (Italiano)
 * @author .anaconda
 * @author BrokenArrow
 */
$messages['it'] = array(
	'expandtemplates' => 'Espansione dei template',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Espande i template, le funzioni del parser e le variabili]] per mostrare il wikitesto espanso e visualizzare un'anteprima della pagina nella sua forma finale",
	'expand_templates_intro' => 'Questa pagina speciale elabora un testo espandendo tutti i template presenti. Calcola inoltre il risultato delle funzioni supportate dal parser come <nowiki>{{</nowiki>#if:...}} e delle variabili di sistema quali <nowiki>{{</nowiki>CURRENTDAY}}, ovvero praticamente tutto ciò che si trova tra doppie parentesi graffe. Funziona richiamando le opportune funzioni del parser di MediaWiki.',
	'expand_templates_title' => 'Contesto (per {{PAGENAME}} ecc.):',
	'expand_templates_input' => 'Testo da espandere:',
	'expand_templates_output' => 'Risultato',
	'expand_templates_xml_output' => 'Output in formato XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Ignora i commenti',
	'expand_templates_generate_xml' => 'Mostra albero sintattico XML',
	'expand_templates_preview' => 'Anteprima',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author JtFuruhata
 */
$messages['ja'] = array(
	'expandtemplates' => 'テンプレートを展開',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|テンプレート・パーサー関数・変数を展開し]]、展開されたウィキテキストと生成されたプレビューページを表示する',
	'expand_templates_intro' => 'この特別ページは入力したテキストに含まれているすべてのテンプレートを再帰的に展開します。<nowiki>{{</nowiki>#if:…}} のようなパーサー関数や、<nowiki>{{</nowiki>CURRENTDAY}} のような変数など、<nowiki>{{</nowiki> ～ }} で囲まれているほとんどのものを展開します。この機能は、MediaWiki 自身から関連する構文解析段階を呼び出すことで実現されています。',
	'expand_templates_title' => '{{PAGENAME}} などの評価を行うページの名前:',
	'expand_templates_input' => '展開するテキスト',
	'expand_templates_output' => '展開結果',
	'expand_templates_xml_output' => 'XML出力',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'コメントを除去',
	'expand_templates_generate_xml' => 'XML構文解釈ツリーを表示',
	'expand_templates_preview' => 'プレビュー',
);

/** Jutish (Jysk)
 * @author Huslåke
 */
$messages['jut'] = array(
	'expandtemplates' => 'Engråt templater',
	'expand_templates_title' => 'Context titel, før {{SITENAME}}:',
	'expand_templates_input' => 'Input skrevselenger:',
	'expand_templates_output' => 'Resultåt',
	'expand_templates_xml_output' => 'XML output',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Slet kommentår',
	'expand_templates_generate_xml' => 'Se XML parse træ',
	'expand_templates_preview' => 'Førhåndsvesnenge',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 */
$messages['jv'] = array(
	'expandtemplates' => 'Cithakan dikembangaké',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Ngembangaké cithakan, fungsi parser lan variabel]] kanggo nuduhaké kasil tèks wiki lan pratayang kaca kasilé',
	'expand_templates_intro' => 'Kaca astaméwa iki njupuk sawetara tèks lan ngembangaké kabèh cithakan sajroning iku sacara rékursif.
Kaca iki uga ngembangaké fungsi parser kaya ta
<nowiki>{{</nowiki>#if:…}}, lan variabel kaya ta
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;sajatiné mèh kabèh sing ana ing antara rong tandha kurung akolade.
Perkara iki dilakokaké caranémawa nyeluk tahapan parser sing rélévan saka MediaWiki dhéwé.',
	'expand_templates_title' => 'Irah-irahan kontèks, kanggo {{PAGENAME}} lan sabanjuré:',
	'expand_templates_input' => 'Tèks sumber:',
	'expand_templates_output' => 'Pituwas (kasil)',
	'expand_templates_xml_output' => 'Pituwas XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Busaken komentar',
	'expand_templates_generate_xml' => 'Tuduhna uwit parser XML',
	'expand_templates_preview' => 'Pratayang',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'expandtemplates' => 'ۇلگىلەردى ۇلعايتۋ',
	'expand_templates_intro' => 'وسى قۇرال ارنايى بەتى الدەبىر ٴماتىندى الادى دا,
بۇنىڭ ىشىندەگى بارلىق كىرىكتەلگەن ۇلگىلەردى مەيلىنشە ۇلعايتادى.
مىنا <nowiki>{{#if:...}} سىيياقتى جوڭدەتۋ فۋنكتسىييالارىن دا, جانە {{CURRENTDAY}}
سىيياقتى اينامالىلارىن دا ۇلعايتادى (ناقتى ايتقاندا, قوس قابات ساداق جاقشالار اراسىنداعى بارلىعىن).
بۇنى ٴوز MediaWiki باعدارلاماسىنان قاتىستى جوڭدەتۋ ساتىن شاقىرىپ ىستەلىنەدى.',
	'expand_templates_title' => 'ٴماتىن ارالىق اتاۋى ({{PAGENAME}} ت.ب. بەتتەر ٴۇشىن):',
	'expand_templates_input' => 'كىرىس ٴماتىنى:',
	'expand_templates_output' => 'ناتىيجەسى',
	'expand_templates_xml_output' => 'XML شىعارۋى',
	'expand_templates_ok' => 'جارايدى',
	'expand_templates_remove_comments' => 'ماندەمەلەرىن الاستاتىپ?',
	'expand_templates_generate_xml' => 'XML وڭدەتۋ بۇتاقتارىن كورسەت',
	'expand_templates_preview' => 'قاراپ شىعۋ',
);

/** Kazakh (Cyrillic) (Қазақша (Cyrillic)) */
$messages['kk-cyrl'] = array(
	'expandtemplates' => 'Үлгілерді ұлғайту',
	'expand_templates_intro' => 'Осы құрал арнайы беті әлдебір мәтінді алады да,
бұның ішіндегі барлық кіріктелген үлгілерді мейлінше ұлғайтады.
Мына <nowiki>{{</nowiki>#if:...}} сияқты жөңдету функцияларын да, және <nowiki>{{</nowiki>CURRENTDAY}}
сияқты айнамалыларын да ұлғайтады (нақты айтқанда, қос қабат садақ жақшалар арасындағы барлығын).
Бұны өз MediaWiki бағдарламасынан қатысты жөңдету сатын шақырып істелінеді.',
	'expand_templates_title' => 'Мәтін аралық атауы ({{PAGENAME}} т.б. беттер үшін):',
	'expand_templates_input' => 'Кіріс мәтіні:',
	'expand_templates_output' => 'Нәтижесі',
	'expand_templates_xml_output' => 'XML шығаруы',
	'expand_templates_ok' => 'Жарайды',
	'expand_templates_remove_comments' => 'Мәндемелерін аластатып?',
	'expand_templates_generate_xml' => 'XML өңдету бұтақтарын көрсет',
	'expand_templates_preview' => 'Қарап шығу',
);

/** Kazakh (Latin) (Қазақша (Latin)) */
$messages['kk-latn'] = array(
	'expandtemplates' => 'Ülgilerdi ulğaýtw',
	'expand_templates_intro' => 'Osı qural arnaýı beti äldebir mätindi aladı da,
bunıñ işindegi barlıq kiriktelgen ülgilerdi meýlinşe ulğaýtadı.
Mına <nowiki>{{</nowiki>#if:...}} sïyaqtı jöñdetw fwnkcïyaların da, jäne <nowiki>{{</nowiki>CURRENTDAY}}
sïyaqtı aýnamalıların da ulğaýtadı (naqtı aýtqanda, qos qabat sadaq jaqşalar arasındağı barlığın).
Bunı öz MediaWiki bağdarlamasınan qatıstı jöñdetw satın şaqırıp istelinedi.',
	'expand_templates_title' => 'Mätin aralıq atawı ({{PAGENAME}} t.b. better üşin):',
	'expand_templates_input' => 'Kiris mätini:',
	'expand_templates_output' => 'Nätïjesi',
	'expand_templates_xml_output' => 'XML şığarwı',
	'expand_templates_ok' => 'Jaraýdı',
	'expand_templates_remove_comments' => 'Mändemelerin alastatıp?',
	'expand_templates_generate_xml' => 'XML öñdetw butaqtarın körset',
	'expand_templates_preview' => 'Qarap şığw',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 */
$messages['km'] = array(
	'expandtemplates' => 'ពង្រីកទំព័រគំរូ',
	'expand_templates_input' => 'សរសេរឃ្លា',
	'expand_templates_output' => 'លទ្ធផល',
	'expand_templates_ok' => 'យល់ព្រម',
	'expand_templates_remove_comments' => 'ដកចេញ វិចារនានា',
	'expand_templates_preview' => 'បង្ហាញការមើលជាមុន',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Klutzy
 * @author ToePeu
 */
$messages['ko'] = array(
	'expandtemplates' => '틀 전개',
	'expandtemplates-desc' => '틀, 파서 함수, 변수 등을 모두 풀어낸 문서를 볼 수 있는 [[Special:ExpandTemplates|틀 전개]] 기능',
	'expand_templates_intro' => '이 특수문서는 글의 모든 틀을 끝까지 풀어 줍니다.
<nowiki>{{</nowiki>#if:…}} 같은 파서 함수나 <nowiki>{{</nowiki>CURRENTDAY}} 같은 변수를 포함해 두개의 중괄호 사이에 있는 것은 모두 풀어줍니다.
미디어위키의 자체 파서로 작동합니다.',
	'expand_templates_title' => '문서 이름 ({{PAGENAME}} 등):',
	'expand_templates_input' => '전개할 내용:',
	'expand_templates_output' => '결과',
	'expand_templates_xml_output' => 'XML 출력',
	'expand_templates_ok' => '확인',
	'expand_templates_remove_comments' => '주석 지우기',
	'expand_templates_generate_xml' => 'XML 구문 트리 보기',
	'expand_templates_preview' => '미리보기',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'expand_templates_ok' => 'OK dun',
	'expand_templates_preview' => 'Bilid',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'expandtemplates' => 'Schablone üvverpröfe',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Schablone, Parserfunktione un Variable oplöse]] un dä komplette Wikitex aanzeije',
	'expand_templates_intro' => 'Hee kanns de en Schablon usprobeere. Do jiss ene Oprof en, un dann kriss De dä komplett opjelös, och all die ennedren widder opjerofe Schablone, Parameter, Funktione, spezielle Name, un esu, bes nix mieh üvverich es, wat mer noch oplöse künnt. Wann jet en <nowiki>{{ … }} Klammere üvverbliet, dann wor et unbekannt. Do passeet jenau et selve wie söns em Wiki och, nor dat De hee tirek ze sinn kriss wat erus kütt.',
	'expand_templates_title' => 'Dä Siggetitel, also wat för {{PAGENAME}} uew. enjeföllt weed:',
	'expand_templates_input' => 'Wat De üvverpröfe wells:',
	'expand_templates_output' => 'Wat erus kütt es',
	'expand_templates_xml_output' => 'XML ußjevve',
	'expand_templates_ok' => 'Loß Jonn!',
	'expand_templates_remove_comments' => 'De ėnner Kommentare fottloohße',
	'expand_templates_generate_xml' => 'Och dä XML-Parser-Boum zeije',
	'expand_templates_preview' => 'Vör-Aansich',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'expandtemplates' => 'Formulas resolvere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'expandtemplates' => 'Schablounen expandéieren',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Erweidert Schablounen, Parser-Funktiounen a Variabelen]] zu engem komplette Wikitext a weist d'Säiten esou wéi wann se ofgespäichert wieren.",
	'expand_templates_intro' => 'Op dëser Spezialsäit kann Text agi ginn an all Schablounen doran gi rekursiv expandéiert.
Och Parserfonctioune wéi <nowiki>{{</nowiki>#if:…}} a Variabele wéi 
<nowiki>{{</nowiki>CURRENTDAY}} ginn ausgewert&mdash; faktisch alles wat an duebele geschweefte Klamere steet.
Dëst geschitt duerch Oprufe vun de jeweiligen Parser-Phase vu MediaWiki selwer.',
	'expand_templates_title' => 'Titel vun der Säit, dëst kann nëtzlech si wa(nn) {{PAGENAME}} benotzt gëtt:',
	'expand_templates_input' => 'Gitt ären Text hei an:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'Resultat als XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Bemierkunge läschen',
	'expand_templates_generate_xml' => "Weis d'Struktur vum XML",
	'expand_templates_preview' => 'Kucken ouni ofzespäicheren',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'expand_templates_ok' => 'Oce',
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'expandtemplates' => 'Sjablone plekke',
	'expandtemplates-desc' => "Substitueert sjablone, parserfunctions, variabele en toent wikiteksti en 'n controleversioe van 'n pagina",
	'expand_templates_intro' => "Dees speciaal pazjena laes de ingegaeve teks in en plektj (mitte functie subst) recursief alle sjablone in de teks. 't Plek ouch alle parserfuncties wie <nowiki>{{</nowiki>#if:...}} en variabele wie <nowiki>{{</nowiki>CURRENTDAY}} - vriejwaal al tösse dóbbel accolades.
Hiej veur waere de relevante functies van de MediaWiki-parser gebroek.",
	'expand_templates_title' => 'Contekstitel, veur {{PAGENAME}}, etc:',
	'expand_templates_input' => 'Inlaajteks:',
	'expand_templates_output' => 'Rezultaot',
	'expand_templates_xml_output' => 'XML-oetveur',
	'expand_templates_ok' => 'ok',
	'expand_templates_remove_comments' => 'Wis opmerkinge',
	'expand_templates_generate_xml' => 'XML-parserboum bekieke',
	'expand_templates_preview' => 'Veurvertoeaning',
);

/** Lao (ລາວ) */
$messages['lo'] = array(
	'expandtemplates' => 'ຂະຫຍາຍແມ່ແບບ',
);

/** Lithuanian (Lietuvių)
 * @author Matasg
 */
$messages['lt'] = array(
	'expand_templates_output' => 'Rezultatas',
	'expand_templates_ok' => 'Gerai',
	'expand_templates_remove_comments' => 'Pašalinti komentarus',
	'expand_templates_preview' => 'Peržiūra',
);

/** Latvian (Latviešu)
 * @author Xil
 */
$messages['lv'] = array(
	'expand_templates_preview' => 'Pirmskats',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'expand_templates_preview' => 'Ончылгоч ончымаш',
);

/** Malayalam (മലയാളം)
 * @author Shijualex
 */
$messages['ml'] = array(
	'expandtemplates' => 'ഫലകങ്ങള്‍ വിപുലീകരിക്കുക',
	'expand_templates_input' => 'ഇന്‍പുട്ട് ടെക്സ്റ്റ്:',
	'expand_templates_output' => 'ഫലം',
	'expand_templates_xml_output' => 'XML ഔട്ട്പുട്ട്',
	'expand_templates_ok' => 'ശരി',
	'expand_templates_remove_comments' => 'അഭിപ്രായങ്ങള്‍ ഒഴിവാക്കുക',
	'expand_templates_generate_xml' => 'XML പാര്‍സര്‍ ട്രീ പ്രദര്‍ശിപ്പിക്കുക',
	'expand_templates_preview' => 'പ്രിവ്യൂ',
);

/** Marathi (मराठी)
 * @author Kaustubh
 * @author Mahitgar
 */
$messages['mr'] = array(
	'expandtemplates' => 'साचे वाढवा',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|साचे, पार्सर फंक्शन्स व व्हेरियेबल्स]] वाढवा जेणेकरून विकिसंज्ञा व्यवस्थित दिसतील.',
	'expand_templates_intro' => 'हे पान काही मजकूर घेऊन त्यातिल सर्व साचे वाढविते. तसेच हे पान पार्सर फंक्शन्स जसे की
<nowiki>{{</nowiki>#if:...}}, व बदलणार्‍या किमती (variables) जसे की
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;म्हणजेच दोन ब्रेसेसमधील सर्व मजकूर वाढविते.
मीडियाविकिमधून पार्सर स्टेज मागवून हे केले जाते.',
	'expand_templates_title' => '{{PAGENAME}} वगैरे करीता, कन्टेक्स्ट शीर्षक:',
	'expand_templates_input' => 'इनपुट मजकूर:',
	'expand_templates_output' => 'निकाल',
	'expand_templates_xml_output' => 'XML चे आऊटपुट',
	'expand_templates_ok' => 'ठिक',
	'expand_templates_remove_comments' => 'संदेश हटवा',
	'expand_templates_generate_xml' => 'XML चा पार्स (parse) वृक्ष दाखवा',
	'expand_templates_preview' => 'झलक',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 * @author Aviator
 */
$messages['ms'] = array(
	'expandtemplates' => 'Kembangkan templat',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Mengembangkan templat, fungsi penghurai dan pemboleh ubah]] untuk memaparkan teks wiki yang dikembangkan dan pralihat laman yang terhasil',
	'expand_templates_intro' => 'Laman khas ini menerima sebarang teks dan mengembangkan semua templat di dalamnya secara rekursif. Laman ini juga mengembangkan fungsi penghurai seperti <nowiki>{{</nowiki>#if:…}} dan pemboleh ubah seperti <nowiki>{{</nowiki>CURRENTDAY}}&mdash;tentunya setiap benda dalam kurungan berganda. Proses ini dilakukan dengan memanggil tahap penghurai yang berkenaan dalam MediaWiki sendiri.',
	'expand_templates_title' => 'Tajuk konteks, untuk {{PAGENAME}} dan sebagainya:',
	'expand_templates_input' => 'Teks input:',
	'expand_templates_output' => 'Hasil',
	'expand_templates_xml_output' => 'Output XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Buang ulasan',
	'expand_templates_generate_xml' => 'Papar pepohon hurai XML',
	'expand_templates_preview' => 'Pralihat',
);

/** Maltese (Malti)
 * @author Giangian15
 */
$messages['mt'] = array(
	'expand_templates_ok' => 'OK',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'expand_templates_preview' => 'Васнянь неевтезэ',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'expand_templates_ok' => 'Cualli',
	'expand_templates_preview' => 'Xiquitta achtochīhualiztli',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'expandtemplates' => 'Khok-chhiong pang-bô͘',
	'expand_templates_input' => 'Su-ji̍p bûn-jī:',
	'expand_templates_output' => 'Kiat-kó:',
	'expand_templates_remove_comments' => 'Comments the̍h tiāu',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'expandtemplates' => 'Vörlagen oplösen',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Wannelt Vörlagen, Parser-Funkschonen un Variablen]] to Wikitext un wiest de Sied, so as se naher utsüht',
	'expand_templates_intro' => 'Mit disse Spezialsied köönt Vörlagen in ingeven Text in Wikitext ümwannelt warrn.
Ok Parserfunkschonen so as
<nowiki>{{</nowiki>#if:…}}, un Variabeln so as
<nowiki>{{</nowiki>CURRENTDAY}} warrt ümwannelt. Also so temlich allens, wat twischen swiefte Klammern steit.
Dorto warrt de nödigen Parser-Phasen in MediaWiki direkt opropen.',
	'expand_templates_title' => 'Kontexttitel, för {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Inputtext:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-Utgaav',
	'expand_templates_ok' => 'Los',
	'expand_templates_remove_comments' => 'Kommentaren rutnehmen',
	'expand_templates_generate_xml' => 'XML-Parser-Boom wiesen',
	'expand_templates_preview' => 'Vörschau',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'expandtemplates' => 'Mallen substitueren',
	'expand_templates_intro' => 'Op disse speciale pagina kan tekse in-evoerd wonnen en alle mallen derin wonnen recursief esubstitueerd. Oek parserfuncties zoas <nowiki>{{</nowiki>#if:...}} en variabelen zoas <nowiki>{{</nowiki>CURRENTDAY}} wonnen esubstitueerd - eigenlijks alles wat tussen dubbele krulhaken steet. Dit wonnen edaon deur de betreffende parserfuncties op te reupen vanuut de MediaWiki-pregrammetuur.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'expandtemplates' => 'Sjablonen substitueren',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Substitueert sjablonen, parserfuncties en variabelen]] en geeft wikitekst en een controleversie van een pagina weer',
	'expand_templates_intro' => 'Deze speciale pagina leest de ingegeven tekst in en
substitueert recursief alle sjablonen in de tekst.
Het substitueert ook alle parserfuncties zoals <nowiki>{{</nowiki>#if:…}} en
variabelen als <nowiki>{{</nowiki>CURRENTDAY}} — vrijwel alles tussen dubbele accolades.
Hiervoor worden de relevante functies van de MediaWiki-parser gebruikt.',
	'expand_templates_title' => 'Contexttitel, voor {{PAGENAME}}, enzovoort:',
	'expand_templates_input' => 'Invoertekst:',
	'expand_templates_output' => 'Resultaat',
	'expand_templates_xml_output' => 'XML-uitvoer',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Opmerkingen verwijderen',
	'expand_templates_generate_xml' => 'XML-parserboom bekijken',
	'expand_templates_preview' => 'Voorvertoning',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 * @author Jon Harald Søby
 */
$messages['nn'] = array(
	'expandtemplates' => 'Utvid malar',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Utvid malar, parserfunksjonar og variablar]] for å visa resulterande råtekst og førehandsvisa sida slik ho vert',
	'expand_templates_intro' => 'Denne sida tek ein tekst og utvider alle malar som er bruka i teksten. 
Ho utvider òg alle funksjonar som 
<nowiki>{{</nowiki>#if:…}}, og variablar som
<nowiki>{{</nowiki>CURRENTDAY}}&mdash; bortimot alt som står i dobbelte klammeparentesar.
Dette gjer han ved å kalla dei relevante parsersetega frå MediaWiki sjølv.',
	'expand_templates_title' => 'Konteksttittel, for {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Inntekst:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-resultat',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Fjern kommentarar',
	'expand_templates_generate_xml' => 'Vis parsertre som XML',
	'expand_templates_preview' => 'Førehandsvising',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'expandtemplates' => 'Utvid maler',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Utvider maler, parserfunksjoner og variabler]] for å vise resultatråteksten og forhåndsvise siden slik den blir',
	'expand_templates_intro' => 'Denne siden tar en tekst og utvider alle maler brukt i teksten. Den utvider også alle funksjoner som <nowiki>{{</nowiki>#if:…}}, og variabler som <nowiki>{{</nowiki>CURRENTDAY}}. <!--It does this by calling the relevant parser stage from MediaWiki itself.-->',
	'expand_templates_title' => 'Konteksttittel, for {{PAGENAME}}, etc.:',
	'expand_templates_input' => 'Skriv inn tekst:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-resultat',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Fjern kommentarer',
	'expand_templates_generate_xml' => 'Vis parsetre som XML',
	'expand_templates_preview' => 'Forhåndsvisning',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'expand_templates_output' => 'Phetho',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'expandtemplates' => 'Espandiment dels modèls',
	'expandtemplates-desc' => 'Augmenta los modèls, las foncions parsairs e las variablas per visionar los tèxtes wikis espandits e previsualiza las paginas atal rendudas.',
	'expand_templates_intro' => 'Aquesta pagina permet de testar l’espandiment de modèls, que son desvolopats recursivament. Las foncions e las variablas predefinidas, coma <nowiki>{{</nowiki>#if:...}} e <nowiki>{{</nowiki>CURRENTDAY}} tanben son desvolopadas.',
	'expand_templates_title' => 'Títol de l’article, util per exemple se lo modèl utiliza {{PAGENAME}} :',
	'expand_templates_input' => 'Picatz vòstre tèxt aicí :',
	'expand_templates_output' => 'Visualizatz lo resultat :',
	'expand_templates_xml_output' => 'Sortida XML',
	'expand_templates_ok' => "D'acòrdi",
	'expand_templates_remove_comments' => 'Suprimir los comentaris.',
	'expand_templates_generate_xml' => "Veire l'arborescéncia XML",
	'expand_templates_preview' => 'Previsualizacion',
);

/** Ossetic (Иронау)
 * @author Amikeco
 */
$messages['os'] = array(
	'expand_templates_ok' => 'Афтæ уæд!',
	'expand_templates_preview' => 'Разæркаст',
);

/** Punjabi (ਪੰਜਾਬੀ)
 * @author Gman124
 */
$messages['pa'] = array(
	'expand_templates_preview' => 'ਝਲਕ',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'expandtemplates' => 'Rozwijanie szablonów',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Rozwija szablony, funkcje analizatora składni oraz zmienne]] by pokazać rozwiniętą składnię wiki oraz podgląd zinterpretowanej strony',
	'expand_templates_intro' => 'We wprowadzonym na tej stronie tekście źródłowym zostaną rozwinięte wszystkie szablony.
Rozwinięte także zostaną funkcje parsera takie jak
<nowiki>{{</nowiki>#if...}} i zmienne jak 
<nowiki>{{</nowiki>CURRENTDAY}} &ndash; w zasadzie prawie wszystko w podwójnych nawiasach klamrowych.
Wykonywane jest to poprzez wywołanie odpowiedniego przebiegu (etapu) parsera z samego MediaWiki.',
	'expand_templates_title' => 'Pozorny tytuł strony dla zmiennych takich jak {{PAGENAME}}',
	'expand_templates_input' => 'Tekst wejściowy',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'wynik w formacie XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Usuń komentarze',
	'expand_templates_generate_xml' => 'Pokaż drzewo analizatora składni w formacie XML',
	'expand_templates_preview' => 'Podgląd',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 */
$messages['pms'] = array(
	'expandtemplates' => 'Anàlisi djë stamp',
	'expand_templates_intro' => "Sta pàgina special-sì a pija dël test e a-i fa n'anàlisi arcorsiva ëd tuti jë stamp ch'a l'ha andrinta. 
A l'analisa ëdcò le fonsion anterpretà coma
<nowiki>{{</nowiki>#if:...}}, e le variabij coma
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;visadì bele che tut lòn ch'a-i é antra dobie grafe.
Sòn a lo fa ën ciamand l'anterprete dal programa MediaWiki.",
	'expand_templates_title' => 'Tìtol ëd contest për {{PAGENAME}} e via fòrt:',
	'expand_templates_input' => 'Test da analisé:',
	'expand_templates_output' => 'Arzultà',
	'expand_templates_ok' => 'Bin parèj',
	'expand_templates_remove_comments' => 'Gava via ij coment',
	'expand_templates_preview' => 'Preuva',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'expandtemplates' => 'کينډۍ غځول',
	'expand_templates_input' => 'ځايونکی متن:',
	'expand_templates_output' => 'پايله',
	'expand_templates_ok' => 'ښه/هو',
	'expand_templates_preview' => 'مخکتنه',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'expandtemplates' => 'Expandir pré-definições',
	'expandtemplates-desc' => 'Expande predefinições, funções do analisador "parser" e variáveis para mostrar texto wiki expandido e prever o aspecto da página',
	'expand_templates_intro' => 'Esta página especial pega em algum texto e expande todas as pré-definições nele existentes recursivamente. Também expande funções do analisador (parser) como <nowiki>{{</nowiki>#if:...}}, e variáveis como <nowiki>{{</nowiki>CURRENTDAY}}&mdash;de facto, tudo entre chavetas duplas. Isto é feito através da chamada ao estágio do analisador (parser) relevante do próprio MediaWiki.',
	'expand_templates_title' => 'Título de contexto para {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Texto de entrada:',
	'expand_templates_output' => 'Resultado',
	'expand_templates_xml_output' => 'Resultado XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Remover comentários',
	'expand_templates_generate_xml' => 'Mostrar árvore de análise (parse) do XML',
	'expand_templates_preview' => 'Previsão',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'expandtemplates' => 'Expandir predefinições',
	'expandtemplates-desc' => 'Expande predefinições, funções do analisador (parser) e variáveis para mostrar texto wiki expandido e prever o aspecto da página',
	'expand_templates_intro' => 'Esta página especial pega algum texto e expande todas as predefinições nele existentes recursivamente. Também expande funções do analisador (parser) como <nowiki>{{</nowiki>#if:...}}, e variáveis como <nowiki>{{</nowiki>CURRENTDAY}}&mdash;de fato, tudo entre chaves duplas. Isto é feito através da chamada ao estágio relevante do analisador (parser) do próprio MediaWiki.',
	'expand_templates_title' => 'Título de contexto para {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Texto de entrada:',
	'expand_templates_output' => 'Resultado',
	'expand_templates_xml_output' => 'Resultado XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Remover comentários',
	'expand_templates_generate_xml' => 'Mostrar árvore de análise (parse) do XML',
	'expand_templates_preview' => 'Previsão',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'expandtemplates' => "Plantillakunata mast'ariy",
	'expand_templates_input' => 'Yaykuchina qillqa:',
	'expand_templates_output' => 'Lluqsiynin:',
	'expand_templates_remove_comments' => 'Willapusqakunata qichuy',
	'expand_templates_preview' => 'Ñawpaqta qhawallay',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 * @author Mihai
 */
$messages['ro'] = array(
	'expandtemplates' => 'Expandarea formatelor',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandează formatele, funcţiile parser şi variabilele]] pentru a vedea expandat textul wiki şi pentru a previzualiza modul de redare a paginii',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'Ieşire XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Elimină comentarii',
	'expand_templates_generate_xml' => 'Arată arborele analiză XML',
	'expand_templates_preview' => 'Previzualizare',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'expand_templates_output' => 'Resultete',
	'expand_templates_xml_output' => 'XML de output',
	'expand_templates_ok' => 'OK',
	'expand_templates_preview' => 'Andeprime',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'expandtemplates' => 'Развёртка шаблонов',
	'expandtemplates-desc' => 'Раскрывает шаблоны, функции парсера и переменные, чтобы показать развёрнутый вики-текст и просмотреть отрисованную страницу',
	'expand_templates_intro' => 'Эта служебная страница преобразует текст, рекурсивно разворачивая все шаблоны в нём.
Также развёртке подвергаются функции парсера
<nowiki>{{</nowiki>#if:…}} и переменные
<nowiki>{{</nowiki>CURRENTDAY}} — в общем, всё внутри двойных фигурных скобок.
Это производится корректным образом, с вызовом соответствующего обработчика MediaWiki.',
	'expand_templates_title' => 'Заголовок страницы для {{PAGENAME}} и т.&nbsp;п.:',
	'expand_templates_input' => 'Входной текст:',
	'expand_templates_output' => 'Результат',
	'expand_templates_xml_output' => 'XML вывод',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Удалить комментарии',
	'expand_templates_generate_xml' => 'Показать дерево разбора XML',
	'expand_templates_preview' => 'Предпросмотр',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'expandtemplates' => 'Халыыптары тэнитии',
	'expandtemplates-desc' => 'Халыыптар тэнитиллиилэрэ',
	'expand_templates_intro' => 'Бу аналлаах сирэй тиэкиһи уларытарытарыгар туох баар халыыптары тэнитэн көрдөрөр.
Парсер функциялара эмиэ тэнитиллэллэр. Холобур, <nowiki>{{</nowiki>#if:...}} уонна переменнайдар (<nowiki>{{</nowiki>CURRENTDAY}} уо.&nbsp;д.&nbsp;а. — уопсайынан, хос фигурнай скобка иһигэр баар барыта.
Бу дьайыы сыыһата суох, MediaWiki көмөтүнэн оҥоһуллар.',
	'expand_templates_title' => '{{PAGENAME}} сирэй аата уонна да атын сибидиэнньэлэр:',
	'expand_templates_input' => 'Киирэр сурук:',
	'expand_templates_output' => 'Түмүк',
	'expand_templates_xml_output' => 'XML тахсыыта',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Ырытыылары сот',
	'expand_templates_generate_xml' => 'XML-ы мас курдук көрдөр',
	'expand_templates_preview' => 'Инники көрүү',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 */
$messages['si'] = array(
	'expandtemplates' => 'සැකිලි පුළුල් කරන්න',
	'expandtemplates-desc' => 'පුළුල් කල විකිපෙළ පෙන්වීම හා විදැහුනු පිටුව පෙරදසුන සඳහා [[Special:ExpandTemplates|සැකිලි, ව්‍යාකරණ විග්‍රහ ශ්‍රීතයන් හා විචල්‍යයන් පුළුල් කරයි ]]',
	'expand_templates_intro' => 'මෙම විශේෂ පිටුව විසින් යම් පෙළක්  ගෙන එහි සියළු සැකිලි ආවර්තනික ලෙස පුළුල් කරයි.
එය  <nowiki>{{</nowiki>#if:…}} වැනි ව්‍යාකරණ විග්‍රහ ශ්‍රිතයන් හා, 
<nowiki>{{</nowiki>CURRENTDAY}}වැනි විචල්‍යයන් ද&mdash; ඇත්ත වශයෙන්ම 
ද්විත්ව-සඟල වරහන් තුල හමුවන සැම දෙයක්ම පාහේ  පුළුල් කරයි.
එය විසින් මෙය සිදුකරනුයේ මාධයවිකි විසින්ම අදාල ව්‍යාකරණ විග්‍රහ අදියර ඇමතීමෙනි.',
	'expand_templates_title' => '{{PAGENAME}} වැන්න සඳහා, ප්‍රකරණ ශීර්ෂය.:',
	'expand_templates_input' => 'ප්‍රදාන පෙළ:',
	'expand_templates_output' => 'ප්‍රතිඵලය',
	'expand_templates_xml_output' => 'XML ප්‍රතිදානය',
	'expand_templates_ok' => 'හරි',
	'expand_templates_remove_comments' => 'පරිකථනයන්  ඉවත්කරන්න',
	'expand_templates_generate_xml' => 'XML ව්‍යාකරණ විග්‍රහ රුක පෙන්වන්න',
	'expand_templates_preview' => 'පෙරදසුන',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'expandtemplates' => 'Substituovať šablóny',
	'expandtemplates-desc' => 'Rozbaľuje šablóny, funkcie syntaktického analyzátora a premenné; zobrazuje rozbalený wikitext a náhľad stránky ako sa zobrazí',
	'expand_templates_intro' => 'Táto špeciálna stránka prijme na
vstup text a rekurzívne substituuje všetky šablóny,
ktoré sú v ňom použité. Tiež expanduje funkcie
syntaktického analyzátora ako <nowiki>{{</nowiki>#if:...}}
a premenné ako <nowiki>{{</nowiki>CURRENTDAY}}—v podstate
takmer všetko v zložených zátvorkách. Robí to pomocou
volania relevantnej fázy syntaktického analyzátora
samotného MediaWiki.',
	'expand_templates_title' => 'Názov kontextu pre {{PAGENAME}} atď.:',
	'expand_templates_input' => 'Vstupný text:',
	'expand_templates_output' => 'Výsledok',
	'expand_templates_xml_output' => 'XML výstup',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Odstrániť komentáre',
	'expand_templates_generate_xml' => 'Zobraziť strom XML',
	'expand_templates_preview' => 'Náhľad',
);

/** Albanian (Shqip) */
$messages['sq'] = array(
	'expandtemplates' => 'Parapamje stampash',
	'expand_templates_intro' => 'Kjo faqe speciale merr tekstin me stampa dhe të tregon se si do të duket teksti pasi të jenë stamposur të tëra. Kjo faqe gjithashtu tregon parapamjen e funksioneve dhe fjalëve magjike si p.sh. <nowiki>{{</nowiki>#if:...}} dhe <nowiki>{{</nowiki>CURRENTDAY}}.',
	'expand_templates_title' => 'Titulli i faqes për rrethanën, si <nowiki>{{</nowiki>PAGENAME}} etj.:',
	'expand_templates_input' => 'Teksti me stampa:',
	'expand_templates_output' => 'Parapamja',
	'expand_templates_ok' => 'Shko',
	'expand_templates_remove_comments' => 'Hiq komentet',
);

/** Serbian Cyrillic ekavian (ћирилица)
 * @author Millosh
 * @author Sasa Stefanovic
 */
$messages['sr-ec'] = array(
	'expandtemplates' => 'Замена шаблона',
	'expand_templates_intro' => 'Ова посебна страница узима неки текст и мења све шаблоне у њему рекурзивно.
Такође мења функције парсера као што је <nowiki>{{</nowiki>#if:...}}, и променљиве као што је
<nowiki>{{</nowiki>ТРЕНУТНИДАН}}&mdash;заправо практично све што се налази између витичастих заграда.
До овога долази тако што се зове одговарајуће стање парсера из самог МедијаВикија.',
	'expand_templates_title' => 'Назив контекста; за <nowiki>{{</nowiki>СТРАНИЦА}} итд.:',
	'expand_templates_input' => 'Унос:',
	'expand_templates_output' => 'Резултат',
	'expand_templates_xml_output' => 'XML излаз',
	'expand_templates_ok' => 'У реду',
	'expand_templates_remove_comments' => 'Уклони коментаре',
	'expand_templates_generate_xml' => 'прикажи XML стабло',
	'expand_templates_preview' => 'Приказ',
);

/** latinica (latinica) */
$messages['sr-el'] = array(
	'expandtemplates' => 'Zamena šablona',
	'expand_templates_intro' => 'Ova posebna stranica uzima neki tekst i menja sve šablone u njemu rekurzivno.
Takođe menja funkcije parsera kao što je <nowiki>{{</nowiki>#if:...}}, i promenljive kao što je
<nowiki>{{</nowiki>TRENUTNIDAN}}&mdash;zapravo praktično sve što se nalazi između vitičastih zagrada.
Do ovoga dolazi tako što se zove odgovarajuće stanje parsera iz samog MedijaVikija.',
	'expand_templates_title' => 'Naziv konteksta; za <nowiki>{{</nowiki>STRANICA}} itd.:',
	'expand_templates_input' => 'Unos:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_ok' => 'U redu',
	'expand_templates_remove_comments' => 'Ukloni komentare',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'expandtemplates' => 'Foarloagen expandierje',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandiert Foarloagen, Parser-Funktione un Variablen]] toun fulboodigen Wikitext un wiest ju renderde Foarschau',
	'expand_templates_intro' => "In disse Spezialsiede kon Text ienroat wäide un aal Foarloagen in hier wäide rekursiv expandierd. Uk Parserfunktione as <nowiki>{{</nowiki>#if:...}} un Variabelen as <nowiki>{{</nowiki>CURRENTDAY}} wäide benutsed - faktisk alles wät twiske dubbelde swoangene Klammere '''{{}}''' stoant. Dit geböärt truch dän Aproup fon apstuunse Parser-Phasen in MediaWiki.",
	'expand_templates_title' => 'Kontexttittel, foar {{PAGENAME}} etc.:',
	'expand_templates_input' => 'Iengoawefäild:',
	'expand_templates_output' => 'Resultoat',
	'expand_templates_xml_output' => 'XML-Uutgoawe',
	'expand_templates_ok' => 'Uutfiere',
	'expand_templates_remove_comments' => 'Kommentoare wächhoalje',
	'expand_templates_generate_xml' => 'Wies XML Parser-Boom',
	'expand_templates_preview' => 'Foarschau',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'expandtemplates' => 'Mekarkeun citakan',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Ngembangkeun citakan, fungsi parser sarta variabel]] pikeun némbongkeun hasil teks wiki sarta pramidang kaca hasilna',
	'expand_templates_input' => 'Téks input:',
	'expand_templates_output' => 'Hasil:',
	'expand_templates_xml_output' => 'Output XML',
	'expand_templates_ok' => 'Heug',
	'expand_templates_preview' => 'Pramidang',
);

/** Swedish (Svenska)
 * @author Lejonel
 */
$messages['sv'] = array(
	'expandtemplates' => 'Expandera mallar',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expanderar]] mallar, parserfunktioner och variabler till wikikod och förhandsvisar den sida som renderas',
	'expand_templates_intro' => 'Den här specialsidan tar en text och expanderar rekursivt alla mallar som används. Även parserfunktioner (som <nowiki>{{</nowiki>#if:...}}), variabler som <nowiki>{{</nowiki>CURRENTDAY}} och annan kod med dubbla klammerparenteser expanderas.',
	'expand_templates_title' => 'Sidans titel, används för t.ex. {{PAGENAME}}:',
	'expand_templates_input' => 'Text som ska expanderas:',
	'expand_templates_output' => 'Expanderad kod',
	'expand_templates_xml_output' => 'XML-kod',
	'expand_templates_ok' => 'Expandera',
	'expand_templates_remove_comments' => 'Ta bort kommentarer',
	'expand_templates_generate_xml' => 'Visa parseträd som XML',
	'expand_templates_preview' => 'Förhandsvisning',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'expand_templates_ok' => 'OK',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'expandtemplates' => 'మూసలను విస్తరించు',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|మూసలు, పార్సరు ఫంక్షన్లు, చరరాశులను విస్తరించి]] వాటిలోని వికీటెక్స్టును, అవి రెండరు చేసే పేజీని చూపిస్తుంది',
	'expand_templates_intro' => 'ఈ ప్రత్యేక పేజీ మీరిచ్చిన మూసలను పూర్తిగా విస్తరించి, చూపిస్తుంది. ఇది <nowiki>{{</nowiki>#if:...}} వంటి పార్సరు ఫంక్షన్లను, <nowiki>{{</nowiki>CURRENTDAY}} వంటి చరరాశులను(వేరియబుల్) కూడా విస్తరిస్తుంది &mdash; నిజానికి జమిలి(మీసాల) బ్రాకెట్లలో ఉన్న ప్రతీదాన్నీ ఇది విస్తరిస్తుంది. మీడియావికీ నుండి సంబంధిత పార్సరు స్టేజిని పిలిచి ఇది ఈ పనిని సాధిస్తుంది.',
	'expand_templates_title' => '{{PAGENAME}} మొదలగు వాటి కొరకు సందర్భ శీర్షిక:',
	'expand_templates_input' => 'ఇన్&zwnj;పుట్ పాఠ్యం:',
	'expand_templates_output' => 'ఫలితం',
	'expand_templates_xml_output' => 'XML ఔట్&zwnj;పుట్',
	'expand_templates_ok' => 'సరే',
	'expand_templates_remove_comments' => 'వ్యాఖ్యలను తొలగించు',
	'expand_templates_generate_xml' => 'XML పార్స్ ట్రీని చూపించు',
	'expand_templates_preview' => 'మునుజూపు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'expand_templates_ok' => 'OK',
);

/** Tajik (Cyrillic) (Тоҷикӣ (Cyrillic))
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'expandtemplates' => 'Бастдодани шаблонҳо',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Шаблонҳо, дастурҳои таҷзеҳкунанда ва мутағйирҳоро густариш медиҳад]], то матни ниҳоиро намоиш диҳад ва саҳифаро ба пешнамоиш дароварад',
	'expand_templates_intro' => 'Ин саҳифаи вижа матнеро дарёфт карда ва тамоми шаблонҳои ба кор рафта дар онро ба таври бозгаште баст медиҳад. Ҳамчунин тобеҳои таҷзеҳ
<nowiki>{{</nowiki>#if:...}}, ва мутағйирҳое чун
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;ро ҳам баст медиҳад – дар воқеъ тақрибан ҳар чиро ки дохили ду акулот бошад.
Ин кор бо садо задани марҳилаи таҷзеҳи марбут дар худи МедиаВики сурат мегирад.',
	'expand_templates_title' => 'Унвони мавзӯъ, барои {{PAGENAME}} ва ғайра.:',
	'expand_templates_input' => 'Матни вурудӣ:',
	'expand_templates_output' => 'Натиҷа',
	'expand_templates_xml_output' => 'Хуруҷӣ XML',
	'expand_templates_ok' => 'Таъйид',
	'expand_templates_remove_comments' => 'Ҳазфи тавзеҳот',
	'expand_templates_generate_xml' => 'Намоиши дарахти таҷзеҳи XML',
	'expand_templates_preview' => 'Пешнамоиш',
);

/** Thai (ไทย)
 * @author Ans
 * @author Octahedron80
 */
$messages['th'] = array(
	'expand_templates_ok' => 'ตกลง',
	'expand_templates_preview' => 'ตัวอย่างผลแสดง',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'expandtemplates' => 'Palaparin (palawakin) ang mga suleras',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Nagpapalawak ng mga suleras, mga tungkuling pambanghay, at mga halagang pabagu-bago]] upang maipakita ang lumapad/lumawak na mga tesktong pangwiki at pahinang hinainan ng paunang tingin',
	'expand_templates_intro' => 'Ang natatanging pahinang ito ay kumukuha ng ilang mga teksto at nagpapalawak ng lahat ng mga suleras sa loob nito sa kaparaanang "pagtawag sa sarili" (rekursibo).
Nagpapalapad din ito ng mga tungkuling pambanghay katulad ng
<nowiki>{{</nowiki>#kung:…}}, at pabagubagong mga halagang katulad ng
<nowiki>{{</nowiki>KASALUKUYANGARAW}}&mdash;sa katotohanan ay halos lahat ng mga bagay-bagay na may dalawang mga bantas na pansalalay (brakete).
Ginagawa ito nito sa pamamagitan ng pagtawag sa mga kaugnay na mga tanghalang pambanghay mula sa sarili mismo ng MediaWiki.',
	'expand_templates_title' => 'Pamagat na pampaunawa (ng konteksto), para sa {{PAGENAME}} atbp.:',
	'expand_templates_input' => 'Tekstong ipinasok:',
	'expand_templates_output' => 'Kinalabasan',
	'expand_templates_xml_output' => 'kinalabasang XML',
	'expand_templates_ok' => "Sige/Ayos 'yan",
	'expand_templates_remove_comments' => 'Tanggalin ang mga puna (kumento)',
	'expand_templates_generate_xml' => 'Ipakita ang puno na pambanghay ng XML',
	'expand_templates_preview' => 'Paunang tingin',
);

/** Tonga (faka-Tonga) */
$messages['to'] = array(
	'expandtemplates' => 'Fakalahiange ʻa e ngaahi sīpinga',
);

/** Turkish (Türkçe)
 * @author Erkan Yilmaz
 * @author Joseph
 * @author Karduelis
 * @author Runningfridgesrule
 */
$messages['tr'] = array(
	'expandtemplates' => 'Şablonları genişlet',
	'expandtemplates-desc' => 'Genişletilmiş vikimetin göstermek ve işlenmiş sayfayı önizlemek için [[Special:ExpandTemplates|şablonları, derleyici fonksiyonlarını ve değişkenleri genişletir]]',
	'expand_templates_intro' => 'Bu özel sayfa biraz metni alır ve içindeki tüm şablonları yinelemeli olarak genişletir.
Ayrıca şu gibi derleyici fonksiyonlarını da genişletir
<nowiki>{{</nowiki>#if:…}}, ve şu gibi değişkenleri
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;aslında çift-bağlı hemen herşey.
Bunu, ilgili derleyici aşamasını MedyaVikinin kendisinden çağırarak yapar.',
	'expand_templates_title' => 'Durum başlığı, ör {{PAGENAME}} için.:',
	'expand_templates_input' => 'Giriş metni:',
	'expand_templates_output' => 'Sonuç',
	'expand_templates_xml_output' => 'XML üretim',
	'expand_templates_ok' => 'Tamam',
	'expand_templates_remove_comments' => 'Yorumları sil',
	'expand_templates_generate_xml' => 'XML derleyici ağacını göster',
	'expand_templates_preview' => 'Ön izleme',
);

/** Tsonga (Xitsonga)
 * @author Thuvack
 */
$messages['ts'] = array(
	'expand_templates_ok' => 'Hiswona',
	'expand_templates_preview' => 'Ringanisa',
);

/** Uighur (Latin) (Uyghurche‎ / ئۇيغۇرچە (Latin))
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'expand_templates_ok' => 'Maqul',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author NickK
 */
$messages['uk'] = array(
	'expandtemplates' => 'Розгортання шаблонів',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Розгортає шаблони, функції парсера і змінні]], щоб показати розгорнутий вікі-текст і попередній перегляд сторінки',
	'expand_templates_intro' => 'Ця спеціальна сторінка перетворює текст, рекурсивно розгортаючи всі шаблони в ньому.
Також розгортаються всі функції парсера
(наприклад <nowiki>{{</nowiki>#if:...}}) і змінні
(наприклад <nowiki>{{</nowiki>CURRENTDAY}}) — загалом, усе всередині подвійних фігурних дужок.
Це відбувається коректним чином з викликом відповідного обробника MediaWiki.',
	'expand_templates_title' => 'Заголовок сторінки для {{PAGENAME}} тощо:',
	'expand_templates_input' => 'Вхідний текст:',
	'expand_templates_output' => 'Результат',
	'expand_templates_xml_output' => 'XML-вивід',
	'expand_templates_ok' => 'Гаразд',
	'expand_templates_remove_comments' => 'Вилучити коментарі',
	'expand_templates_generate_xml' => 'Показати дерево аналізу XML',
	'expand_templates_preview' => 'Попередній перегляд',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'expandtemplates' => 'Espansion dei template',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Espande i template, le funzion del parser e le variabili]] par mostrar el wikitesto espanso e visualizar n'anteprima de la pagina ne la so forma final",
	'expand_templates_intro' => 'Sta pagina speciale la elabora un testo espandendo tuti i template presenti. La calcola inoltre el risultato de le funzion suportàe dal parser come <nowiki>{{</nowiki>#if:...}} e de le variabili de sistema quali <nowiki>{{</nowiki>CURRENTDAY}}, overo in pratica tuto quel che se cata tra dopie parentesi grafe. La funsiona riciamando le oportune funzion del parser de MediaWiki.',
	'expand_templates_title' => 'Contesto (par {{PAGENAME}} ecc.):',
	'expand_templates_input' => 'Testo da espàndar:',
	'expand_templates_output' => 'Risultato',
	'expand_templates_xml_output' => 'Output in formato XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Ignora i comenti',
	'expand_templates_generate_xml' => 'Mostra àlbaro sintàtico XML',
	'expand_templates_preview' => 'Anteprima',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'expandtemplates' => 'Bung tiêu bản',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Mở rộng các tiêu bản, hàm cú pháp, và biến]] thành mã wiki cuối cùng và hiển thị trang dùng mã này',
	'expand_templates_intro' => 'Trang đặc biệt này sẽ nhận vào một đoạn văn bản và bung tất cả các tiêu bản trong nó ra một cách đệ quy cho đến hết. Nó cũng bung cả những hàm cú pháp như <nowiki>{{</nowiki>#if:…}}, và những biến số như <nowiki>{{</nowiki>CURRENTDAY}}&nbsp;– thực ra cũng là các dữ liệu bình thường đặt trong ngoặc móc. Nó thực hiện điều này bằng cách gọi tầng dịch cú pháp từ chính MediaWiki.',
	'expand_templates_title' => 'Tựa đề, đối với {{PAGENAME}}, v.v.:',
	'expand_templates_input' => 'Văn bản nhập:',
	'expand_templates_output' => 'Kết quả',
	'expand_templates_xml_output' => 'Xuất XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Bỏ các chú thích',
	'expand_templates_generate_xml' => 'Xem cây phân tích XML',
	'expand_templates_preview' => 'Xem thử',
);

/** Volapük (Volapük)
 * @author Smeira
 */
$messages['vo'] = array(
	'expandtemplates' => 'stäänükön samafomotis',
	'expand_templates_intro' => 'Pad patik at sumon vödemi e stäänükon samafomotis onik valik okvokölo. Stäänükon i programasekätis soäs <nowiki>{{</nowiki>#if:...}} e vödis soäs <nowiki>{{</nowiki>CURRENTDAY}}... e valikosi vü els <nowiki>{{ }}</nowiki>.
Dunon atosi medä vokon programadili tefik se el MediaWiki it.',
	'expand_templates_title' => 'Yumedatiäd, pro {{PAGENAME}} e r.:',
	'expand_templates_input' => 'Penolös vödem:',
	'expand_templates_output' => 'Seks',
	'expand_templates_xml_output' => 'Seks fomätü XML',
	'expand_templates_ok' => 'Baiced',
	'expand_templates_remove_comments' => 'Moükön küpetis',
	'expand_templates_generate_xml' => 'Jonön bimi: XML',
	'expand_templates_preview' => 'Büologed',
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'expand_templates_output' => 'רעזולטאט',
);

/** Yue (粵語) */
$messages['yue'] = array(
	'expandtemplates' => '展開模',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展開模、parser functions同埋變數]]去顯示展開嘅wiki文字同埋預覽處理後嘅版',
	'expand_templates_intro' => '呢個特別頁係用於將一啲文字中嘅模展開，包括響個模度引用嘅模。同時亦都展開解譯器函數好似<nowiki>{{</nowiki>#if:...}}，以及一啲變數好似<nowiki>{{</nowiki>CURRENTDAY}}&mdash;實際上，幾乎所有響雙括弧中嘅內容都會被展開。呢個特別頁係通過使用MediaWiki嘅相關解釋階段嘅功能完成嘅。',
	'expand_templates_title' => '內容標題，用於 {{PAGENAME}} 等頁面：',
	'expand_templates_input' => '輸入文字：',
	'expand_templates_output' => '結果：',
	'expand_templates_xml_output' => 'XML輸出',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => '拎走注釋',
	'expand_templates_generate_xml' => '顯示XML語法樹',
	'expand_templates_preview' => '預覽',
);

/** Simplified Chinese (‪中文(简体)‬) */
$messages['zh-hans'] = array(
	'expandtemplates' => '展开模板',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展开模板、模版扩展语法以及变数]]去显示展开之wiki文字和预览处理后之页面',
	'expand_templates_intro' => '本特殊页面用于将一些文字中的模板展开，包括模板中引用的模板。同时也展开解释器函数如<nowiki>{{</nowiki>#if:...}}，以及变量如<nowiki>{{</nowiki>CURRENTDAY}}&mdash;实际上，几乎所有在双括号中的内容都被展开。本特殊页面是通过调用MediaWiki的相关解释阶段的功能完成的。',
	'expand_templates_title' => '上下文标题，用于 {{PAGENAME}} 等页面：',
	'expand_templates_input' => '输入文字：',
	'expand_templates_output' => '结果：',
	'expand_templates_xml_output' => 'XML输出',
	'expand_templates_ok' => '确定',
	'expand_templates_remove_comments' => '移除注释',
	'expand_templates_generate_xml' => '显示XML语法树',
	'expand_templates_preview' => '预览',
);

/** Traditional Chinese (‪中文(繁體)‬) */
$messages['zh-hant'] = array(
	'expandtemplates' => '展開模板',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展開模板、模版擴展語法以及變數]]去顯示展開之wiki文字和預覽處理後之頁面',
	'expand_templates_intro' => '本特殊頁面用於將一些文字中的模版展開，包括模版中引用的模版。同時也展開解譯器函數如<nowiki>{{</nowiki>#if:...}}，以及變數如<nowiki>{{</nowiki>CURRENTDAY}}&mdash;實際上，幾乎所有在雙括弧中的內容都被展開。本特殊頁面是通過使用MediaWiki的相關解釋階段的功能完成的。',
	'expand_templates_title' => '上下文標題，用於 {{PAGENAME}} 等頁面：',
	'expand_templates_input' => '輸入文字：',
	'expand_templates_output' => '結果：',
	'expand_templates_xml_output' => 'XML輸出',
	'expand_templates_ok' => '確定',
	'expand_templates_remove_comments' => '移除注釋',
	'expand_templates_generate_xml' => '顯示XML語法樹',
	'expand_templates_preview' => '預覽',
);

