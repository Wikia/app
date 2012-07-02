<?php
/**
 * Internationalisation file for ExpandTemplates extension.
 *
 * @file
 * @ingroup Extensions
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
	'expand_templates_title'           => 'Context title, for {{FULLPAGENAME}} etc.:',
	'expand_templates_input'           => 'Input text:',
	'expand_templates_output'          => 'Result',
	'expand_templates_xml_output'      => 'XML output',
	'expand_templates_ok'              => 'OK',
	'expand_templates_remove_comments' => 'Remove comments',
	'expand_templates_remove_nowiki'   => 'Suppress <nowiki> tags in result',
	'expand_templates_generate_xml'    => 'Show XML parse tree',
	'expand_templates_preview'         => 'Preview',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Meno25
 * @author Mormegil
 * @author The Evil IP address
 * @author Yekrats
 */
$messages['qqq'] = array(
	'expandtemplates' => 'The name of the [[mw:Extension:ExpandTemplates|Expand Templates extension]].',
	'expandtemplates-desc' => 'The description of the [[mw:Extension:ExpandTemplates|Expand Templates extension]].
{{desc}}',
	'expand_templates_intro' => 'This is the explanation given in the heading of the [[Special:ExpandTemplates]] page; it describes its functionality to the users.
For more information, see [[mw:Extension:ExpandTemplates]]',
	'expand_templates_input' => '{{Identical|Input text}}',
	'expand_templates_output' => '{{Identical|Result}}',
	'expand_templates_ok' => '{{Identical|OK}}',
	'expand_templates_remove_comments' => 'Check box to tell [[mw:Extension:ExpandTemplates]] to not show comments in the expanded template.',
	'expand_templates_remove_nowiki' => 'Option on [[Special:Expandtemplates]]',
	'expand_templates_preview' => '{{Identical|Preview}}',
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
	'expand_templates_title' => 'Kontekstitel, vir {{FULLPAGENAME}}, ensovoorts:',
	'expand_templates_input' => 'Invoerteks:',
	'expand_templates_output' => 'Resultaat',
	'expand_templates_xml_output' => 'XML-afvoer',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Verwyder kommentaar',
	'expand_templates_remove_nowiki' => 'Onderdruk <nowiki> etikette in die resultaat',
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
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Estendilla as plantillas, funcions de parseyo y variables]] ta amostrar o wikitesto estendillato y preveyer a pachina',
	'expand_templates_intro' => 'Ista pachina especial prene bel testo y espande recursivament todas as plantillas que bi ha en el. Tamién espande as funcions parser como <nowiki>{{</nowiki>#if:...}}, y as variables como <nowiki>{{</nowiki>CURRENTDAY}}&mdash; en cheneral tot o que sía entre dobles claus.
Isto lo fa clamando ta o parser correspondient dende o propio MediaWiki.',
	'expand_templates_title' => 'Títol ta contestualizar ({{FULLPAGENAME}} etz.):',
	'expand_templates_input' => 'Testo ta espandir:',
	'expand_templates_output' => 'Resultau',
	'expand_templates_xml_output' => 'salida XML',
	'expand_templates_ok' => 'Confirmar',
	'expand_templates_remove_comments' => 'Sacar comentarios',
	'expand_templates_generate_xml' => "Amostrar l'árbol de parseyo XML",
	'expand_templates_preview' => 'Previsualización',
);

/** Arabic (العربية)
 * @author Meno25
 * @author Mido
 * @author OsamaK
 */
$messages['ar'] = array(
	'expandtemplates' => 'فرد القوالب',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|يفرد القوالب ودوال المحلل والمتغيرات]] لعرض نص الويكي الممدد ورؤية الصفحة الناتجة',
	'expand_templates_intro' => 'تتعامل هذه الصفحة الخاصة مع نصوص الويكي وتقوم بفرد كل القوالب الموجودة به.
وتقوم أيضا بفرد دوال القوالب مثل
<nowiki>{{</nowiki>#if:...}}، والمتغيرات مثل
<nowiki>{{</nowiki>يوم}}-- وتقوم التعامل مع كل ما بين الأقواس المزدوجة.
تقوم بفعل هذا عن طريق استدعاء المعالج المناسب من الميدياويكي.',
	'expand_templates_title' => 'عنوان صفحة هذا النص، لأجل معالجة {{FULLPAGENAME}} إلخ.:',
	'expand_templates_input' => 'النص المدخل:',
	'expand_templates_output' => 'النتيجة',
	'expand_templates_xml_output' => 'خرج XML',
	'expand_templates_ok' => 'موافق',
	'expand_templates_remove_comments' => 'أزل التعليقات',
	'expand_templates_remove_nowiki' => 'أخفِ وسوم <nowiki> في الناتج',
	'expand_templates_generate_xml' => 'اعرض شجرة XML parse',
	'expand_templates_preview' => 'معاينة',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'expand_templates_output' => 'ܦܠܛܐ',
	'expand_templates_ok' => 'ܛܒ',
	'expand_templates_preview' => 'ܚܝܪܐ ܩܕܡܝܐ',
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
	'expand_templates_title' => 'عنوان السياق, لـ {{FULLPAGENAME}} الخ.:',
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
 * @author Xuacu
 */
$messages['ast'] = array(
	'expandtemplates' => 'Esparder plantíes',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Espande plantíes, funciones d'análisis sintáuticu y variables]] p'amosar wikitestu espandíu y previsualizar páxines renderizaes",
	'expand_templates_intro' => "Esta páxina especial ellabora un testu espardiendo toles
plantíes de forma recursiva. Tamién esparde les funciones d'análisis sintáuticu
como <nowiki>{{</nowiki>#if:...}}, y variables como
<nowiki>{{</nowiki>CURRENTDAY}}, en realidá cuasi tolo qu'heba ente llaves dobles. Funciona
llamando a les funciones afechisques d'análisis sintáuticu de MediaWiki.",
	'expand_templates_title' => 'Títulu del contestu, pa {{FULLPAGENAME}}, etc.:',
	'expand_templates_input' => "Testu d'entrada:",
	'expand_templates_output' => 'Resultáu',
	'expand_templates_xml_output' => 'Salida XML',
	'expand_templates_ok' => 'Aceutar',
	'expand_templates_remove_comments' => 'Eliminar comentarios',
	'expand_templates_remove_nowiki' => 'Quitar les etiquetes <nowiki> nos resultaos',
	'expand_templates_generate_xml' => "Amosar l'árbole d'análisis sintáuticu XML",
	'expand_templates_preview' => 'Entever',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'expand_templates_output' => 'Nəticə',
	'expand_templates_ok' => 'OK',
);

/** Bashkir (Башҡортса)
 * @author Assele
 */
$messages['ba'] = array(
	'expandtemplates' => 'Ҡалыптарҙы йәйелдереү',
	'expandtemplates-desc' => 'Йәйелдерелгән вики-текстты күрһәтеү һәм булдырылған битте ҡарап сығыу өсөн [[Special:ExpandTemplates|ҡалыптарҙы, укыу ҡоралдарын һәм үҙгәреүсән дәүмәлдәрҙе йәйелдерә]]',
	'expand_templates_intro' => 'Был махсус бит бирелгән тексттың бөтә ҡалыптарын ҡабатланмалы рәүештә йәйелдерә.
Шулай уҡ <nowiki>{{</nowiki>#if:…}} һымаҡ уҡыу ҡоралдары һәм <nowiki>{{</nowiki>CURRENTDAY}} һымаҡ үҙгәреүсән дәүмәлдәр,— ғөмүмән, икәүле йәйәләр эсендә барыһы ла йәйелдерелә.
Был MediaWiki-ның кәрәкле эшкәртеүсе ҡоралын саҡырыу ярҙамында эшләнә.',
	'expand_templates_title' => '{{FULLPAGENAME}} һ.б. өсөн бит исеме:',
	'expand_templates_input' => 'Сығанаҡ текст:',
	'expand_templates_output' => 'Һөҙөмтә',
	'expand_templates_xml_output' => 'XML һөҙөмтә',
	'expand_templates_ok' => 'Тамам',
	'expand_templates_remove_comments' => 'Аңлатмаларҙы юйырға',
	'expand_templates_remove_nowiki' => 'Һөҙөмтәлә <nowiki> билдәләрен йәшерергә',
	'expand_templates_generate_xml' => 'XML уҡыу ағасын күрһәтергә',
	'expand_templates_preview' => 'Ҡарап сығыу',
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
	'expand_templates_title' => 'عنوان متن په {{FULLPAGENAME}} و دگه.:',
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

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
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
	'expand_templates_title' => 'Загаловак старонкі, для {{FULLPAGENAME}} і г.д.:',
	'expand_templates_input' => 'Крынічны тэкст:',
	'expand_templates_output' => 'Вынік',
	'expand_templates_xml_output' => 'вынік у фармаце XML',
	'expand_templates_ok' => 'Добра',
	'expand_templates_remove_comments' => 'Выдаліць камэнтары',
	'expand_templates_remove_nowiki' => 'Падаўляць тэгі <nowiki> у выніку',
	'expand_templates_generate_xml' => 'Паказаць дрэва аналізу XML',
	'expand_templates_preview' => 'Папярэдні прагляд',
);

/** Bulgarian (Български)
 * @author Borislav
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'expandtemplates' => 'Разгръщане на шаблони',
	'expand_templates_title' => 'Заглавие на страницата (напр. за {{FULLPAGENAME}}):',
	'expand_templates_input' => 'Входящ текст:',
	'expand_templates_output' => 'Резултат',
	'expand_templates_xml_output' => 'Изход на XML',
	'expand_templates_ok' => 'ОК',
	'expand_templates_remove_comments' => 'Премахване на коментари',
	'expand_templates_remove_nowiki' => 'Потискане на елементите <nowiki> в резултата',
	'expand_templates_generate_xml' => 'Показване на дървото от разбора на XML',
	'expand_templates_preview' => 'Преглед',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 * @author Zaheen
 */
$messages['bn'] = array(
	'expandtemplates' => 'টেম্পলেট সম্প্রসারণ',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|টেম্পলেট, পার্সার ফাংশন এবং ভ্যারিয়েবল সপ্রসারণ করে]] সম্প্রসারিত উইকিটেক্সট দেখুন এবং উপস্থাপিত পাতাটি প্রাকদর্শন করুন',
	'expand_templates_intro' => 'এই বিশেষ পাতাটি কিছু টেক্সট গ্রহণ করে এবং এর ভেতরের সব টেম্পলেট বারংবার সম্প্রসারিত করে।
এছাড়াও এটি 
<nowiki>{{</nowiki>#if:...}}-এর মত পার্সার ফাংশন,
<nowiki>{{</nowiki>CURRENTDAY}}-এর মত ভ্যারিয়েবল &mdash; মোটকথা দ্বিতীয় বন্ধনীর মধ্যে অবস্থিত সবকিছুকেই সম্প্রসারিত করতে পারে।
এটি সংশ্লিষ্ট পার্সার পর্যায় থেকে স্বয়ং মিডিয়াউইকিকে কল করে এই কাজটি করে থাকে।',
	'expand_templates_title' => 'প্রাতিবেশিক শিরোনাম, {{FULLPAGENAME}}, ইত্যাদির জন্য:',
	'expand_templates_input' => 'ইনপুটকৃত লেখা:',
	'expand_templates_output' => 'ফলাফল',
	'expand_templates_xml_output' => 'XML আউটপুট',
	'expand_templates_ok' => 'ঠিক আছে',
	'expand_templates_remove_comments' => 'মন্তব্য মুছে ফেলো',
	'expand_templates_remove_nowiki' => 'ফলাফলে <nowiki> ট্যাগগুলো বাতিল করো',
	'expand_templates_generate_xml' => 'XML পার্স বৃক্ষ দেখাও',
	'expand_templates_preview' => 'প্রাকদর্শন',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'expandtemplates' => 'Emled ar patromoù',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Astenn a ra ar patromoù, an arc'hwelioù parser hag an argemmoù]] evit diskouez an testennoù wiki astennet ha rakwelet tres ar bajenn",
	'expand_templates_intro' => "Kemer a ra ar bajenn dibar-mañ tammoù testenn hag astenn a ra an holl batromoù enni en un doare azkizat.
Astenn a ra ivez an arc'hwelioù parser evel
<nowiki>{{</nowiki>#if:…}}, hag an argemmoù evel
<nowiki>{{</nowiki>CURRENTDAY}}&mdash; e gwirionez, koulz lavaret kement tra zo etre briataennoù.
Ober a ra kement-mañ dre c'hervel ar bazenn a zegouezh digant parser MediaWiki e-unan.",
	'expand_templates_title' => 'Titl ar gendestenn, evit {{FULLPAGENAME}} h.a. :',
	'expand_templates_input' => 'Merkañ ho testenn amañ :',
	'expand_templates_output' => "Disoc'h",
	'expand_templates_xml_output' => 'Ezvont XML',
	'expand_templates_ok' => 'Mat eo',
	'expand_templates_remove_comments' => 'Lemel an notennoù kuit',
	'expand_templates_remove_nowiki' => "Diverkañ a ra ar balizennoù <nowiki> en disoc'h",
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
	'expand_templates_title' => 'Naslov konteksta, za {{FULLPAGENAME}} itd.:',
	'expand_templates_input' => 'Tekst unosa:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'XML izlaz',
	'expand_templates_ok' => 'U redu',
	'expand_templates_remove_comments' => 'Ukloni komentare',
	'expand_templates_remove_nowiki' => 'Onemogući oznake <nowiki> u rezultatima',
	'expand_templates_generate_xml' => 'Prikaži XML stablo parsera',
	'expand_templates_preview' => 'Pregled',
);

/** Catalan (Català)
 * @author Davidpar
 * @author SMP
 * @author Solde
 * @author Toniher
 * @author Vriullop
 */
$messages['ca'] = array(
	'expandtemplates' => 'Expansió de plantilles',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandeix plantilles, funcions i variables]] per a mostrar-vos la sintaxi expandida i previsualitzar el resultat que es mostrarà a les pàgines',
	'expand_templates_intro' => "Aquesta pàgina especial expandeix de forma recursiva totes les plantilles d'un text donat.
També expandeix les funcions sintàctiques, com ara <tt><nowiki>{{</nowiki>#if:…}}</tt>, i les variables predefinides, com <tt><nowiki>{{</nowiki>CURRENTDAY}}</tt> &mdash;de fet, gairebé tot que estigui entre claus dobles.
Ho fa cridant el nivell sintàctic pertinent del mateix MediaWiki.",
	'expand_templates_title' => 'Títol per contextualitzar ({{FULLPAGENAME}}, etc):',
	'expand_templates_input' => 'El vostre text:',
	'expand_templates_output' => 'Resultat:',
	'expand_templates_xml_output' => 'Sortida XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Elimina els comentaris',
	'expand_templates_remove_nowiki' => "Suprimeix l'etiqueta <nowiki> en el resultat",
	'expand_templates_generate_xml' => "Mostra l'arbre XML",
	'expand_templates_preview' => 'Previsualitza',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'expandtemplates' => 'Хьадаста куцкепаш',
	'expand_templates_output' => 'Хилам',
	'expand_templates_remove_comments' => 'Дlадайа далийнадешнаш',
	'expand_templates_preview' => 'Хьалха муха ю хьажа',
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
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Rozbaluje šablony, funkce parseru a proměnné]], načež zobrazí výsledný wikitext a náhled stránky',
	'expand_templates_intro' => 'Pomocí této speciální stránky můžete nechat v textu substituovat všechny šablony a funkce parseru jako <code><nowiki>{{</nowiki>#if:…...}}</code> či proměnné jako <code><nowiki>{{</nowiki>CURRENTDAY}}</code> – tzn. prakticky všechno v dvojitých složených závorkách. K tomu se používají přímo odpovídající funkce parseru MediaWiki.',
	'expand_templates_title' => 'Název stránky kvůli kontextu pro {{FULLPAGENAME}} apod.:',
	'expand_templates_input' => 'Vstupní text:',
	'expand_templates_output' => 'Výstup',
	'expand_templates_xml_output' => 'Výstup XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Odstranit komentáře',
	'expand_templates_remove_nowiki' => 'Potlačit ve výsledku značky <nowiki>',
	'expand_templates_generate_xml' => 'Zobrazit syntaktický strom v XML',
	'expand_templates_preview' => 'Náhled',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Jon Harald Søby
 * @author Peter Alberti
 */
$messages['da'] = array(
	'expandtemplates' => 'Udfold skabeloner',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Udfolder skabeloner, oversætterfunktioner og variabler]] for at vise den resulterende wikitekst og en forhåndsvisning af en side med den',
	'expand_templates_intro' => 'Denne specialside tager noget tekst og folder alle skabeloner ud rekursivt.
Den udfolder også specielle oversætterfunktioner såsom <nowiki>{{#if:...}}</nowiki> samt variabler såsom <nowiki>{{CURRENTDAY}}</nowiki> –
faktisk folder den næsten hvad som helst i dobbelte krøllede parenteser ud.
Den gør det ved at kalde det relevante analysetrin i MediaWiki-softwaren.',
	'expand_templates_title' => 'Titlen på siden som {{FULLPAGENAME}} og tilsvarende skal tolkes ud fra:',
	'expand_templates_input' => 'Inputtekst:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-kode',
	'expand_templates_ok' => 'Udfold',
	'expand_templates_remove_comments' => 'Fjern kommentarer',
	'expand_templates_remove_nowiki' => 'Undertryk <nowiki>-tags i resultatet',
	'expand_templates_generate_xml' => 'Vis analysetræ som XML',
	'expand_templates_preview' => 'Forhåndsvisning',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 * @author Raimond Spekking
 * @author Umherirrender
 */
$messages['de'] = array(
	'expandtemplates' => 'Vorlagen expandieren',
	'expandtemplates-desc' => 'Ergänzt eine [[Special:ExpandTemplates|Spezialseite]] zum Anzeigen von Vorlagen, Parserfunktionen und Variablen in Wikitext und zeigt deren Vorschau',
	'expand_templates_intro' => 'In diese Spezialseite kann Text eingegeben werden und alle Vorlagen in ihr werden rekursiv expandiert. Auch Parserfunktionen wie <code><nowiki>{{</nowiki>#if:…}}</code> und Variablen wie <code><nowiki>{{</nowiki>CURRENTDAY}}</code> werden ausgewertet - faktisch alles was in doppelten geschweiften Klammern enthalten ist. Dies geschieht durch den Aufruf der jeweiligen Parser-Phasen in MediaWiki.',
	'expand_templates_title' => 'Kontexttitel, für {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Eingabefeld:',
	'expand_templates_output' => 'Ergebnis',
	'expand_templates_xml_output' => 'XML-Ausgabe',
	'expand_templates_ok' => 'Okay',
	'expand_templates_remove_comments' => 'Kommentare entfernen',
	'expand_templates_remove_nowiki' => '<nowiki>-Tags in der Ausgabe unterdrücken',
	'expand_templates_generate_xml' => 'XML-Parser-Baum zeigen',
	'expand_templates_preview' => 'Vorschau',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Xoser
 */
$messages['diq'] = array(
	'expandtemplates' => 'şablonan hêra ker',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Templateyan, parser fonsksiyonan and vunayîşan gird bike]] ke wikitext u pel renderî verqeyd bike',
	'expand_templates_intro' => 'no pelo xususi metın geno u şablonê ke tedeyê reyna reyna hêra keno.
U hem zi nê fonksiyonan hêra keno
<nowiki>{{</nowiki>#if:…}}, u zey nê parametreyan
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;',
	'expand_templates_title' => 'sernameyê weziyeti, misal qey {{FULLPAGENAME}}.:',
	'expand_templates_input' => 'sernameyê cıkewtışi:',
	'expand_templates_output' => 'netice',
	'expand_templates_xml_output' => 'XML vıraştış',
	'expand_templates_ok' => 'temam',
	'expand_templates_remove_comments' => 'mışoreyan hewna ker',
	'expand_templates_remove_nowiki' => 'neticeyan de etiketê <nowiki> yan çap bıker',
	'expand_templates_generate_xml' => 'dara arêdayoxi XML ramocın',
	'expand_templates_preview' => 'pêş-seyrkerdış',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'expandtemplates' => 'Pśedłogi ekspanděrowaś',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Ekspanděrujo pśedłogi, parserowe funkcije a wariable]], aby dopołny wikitekst pokazał a woblicony pśeglěd zwobraznił',
	'expand_templates_intro' => 'Na toś tom boku dajo se tekst zapódaś a wšykne pśedłogi na njom se rekursiwnje ekspanděruju. Teke parserowe funkcije kaž <nowiki>{{</nowiki>#if:…}} a wariable kaž <nowiki>{{</nowiki>CURRENTDAY}} se ekspanděruju - faktiski wšo, což stoj mjazy dwójnymi wugibnjonymi spinkami. To stawa se pśez zawołanje daneje parseroweje faze z MediaWiki.',
	'expand_templates_title' => 'Kontekstowy titel, za {{FULLPAGENAME}} atd.',
	'expand_templates_input' => 'Zapódany tekst:',
	'expand_templates_output' => 'Wuslědk',
	'expand_templates_xml_output' => 'Wudany XML',
	'expand_templates_ok' => 'W pórěźe',
	'expand_templates_remove_comments' => 'Komentary wótwónoźeś',
	'expand_templates_remove_nowiki' => 'Toflicki <nowiki> we wuslědku pódtłocyś',
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
 * @author Crazymadlover
 * @author Dead3y3
 * @author Omnipaedista
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
	'expand_templates_title' => 'Τίτλων συμφραζόμενων, για την {{FULLPAGENAME}} κ.τ.λ.:',
	'expand_templates_input' => 'Κείμενο εισόδου:',
	'expand_templates_output' => 'Αποτέλεσμα',
	'expand_templates_xml_output' => 'Έξοδος XML',
	'expand_templates_ok' => 'Εντάξει',
	'expand_templates_remove_comments' => 'Αφαίρεση σχολίων',
	'expand_templates_remove_nowiki' => 'Απόκρυψη της ετικέτας <nowiki> στο αποτέλεσμα',
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
	'expand_templates_title' => 'Kunteksta titolo, por {{FULLPAGENAME}}, ktp.:',
	'expand_templates_input' => 'Enigita teksto:',
	'expand_templates_output' => 'Rezulto',
	'expand_templates_xml_output' => 'XML-eligo',
	'expand_templates_ok' => 'Ek!',
	'expand_templates_remove_comments' => 'Forigi komentojn',
	'expand_templates_remove_nowiki' => 'Nuligi <nowiki> etikedojn en rezulto',
	'expand_templates_generate_xml' => 'Montri XML-sintaksarbon',
	'expand_templates_preview' => 'Antaŭrigardo',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Icvav
 * @author Muro de Aguas
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 */
$messages['es'] = array(
	'expandtemplates' => 'Expandir plantillas',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expande plantillas, funciones del parser y variables]] para mostrar la sintaxis expandida y previsualizar el aspecto final de la página',
	'expand_templates_intro' => 'Esta página especial toma un texto wiki y expande todas sus plantillas recursivamente.
También expande las funciones sintácticas como <nowiki>{{</nowiki>#if:…}} y variables como
<nowiki>{{</nowiki>CURRENTDAY}}. De hecho, expande casi cualquier cosa que esté entre llaves dobles.
Lo hace llamando al nivel del analizador sintáctico correspondiente del propio MediaWiki.',
	'expand_templates_title' => 'Título de la página, útil para expandir {{FULLPAGENAME}} o similares',
	'expand_templates_input' => 'Texto a expandir:',
	'expand_templates_output' => 'Resultado:',
	'expand_templates_xml_output' => 'Salida XML',
	'expand_templates_ok' => 'Aceptar',
	'expand_templates_remove_comments' => 'Eliminar comentarios (<!-- ... -->)',
	'expand_templates_remove_nowiki' => 'Suprimir <nowiki> etiquetas en resultado',
	'expand_templates_generate_xml' => 'Mostrar el árbol XML.',
	'expand_templates_preview' => 'Previsualización',
);

/** Estonian (Eesti)
 * @author Ker
 * @author Pikne
 */
$messages['et'] = array(
	'expandtemplates' => 'Mallide lahendamine',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Laiendab mallid, parserifunktsioonid ja muutujad]], et näidata täielikku vikiteksti ja kuvada visualiseeritud lehekülg.',
	'expand_templates_intro' => 'See erileht mahutab natuke teksti ja laiendab tekstis kõik mallid nende lähtekoodideks.
Samuti laiendab see parserifunktsioonid nagu <nowiki>{{</nowiki>#if:…}} ja muutujad nagu <nowiki>{{</nowiki>CURRENTDAY}} – teisisõnu enamvähem kõik, mis jääb looksulgude vahele.
Selleks kutsub lehekülg MediaWikist asjassepuutuva parserijärgu.',
	'expand_templates_title' => 'Sisu pealkiri, näiteks {{FULLPAGENAME}} jaoks:',
	'expand_templates_input' => 'Sisendtekst:',
	'expand_templates_output' => 'Tulemus',
	'expand_templates_xml_output' => 'XML-väljund',
	'expand_templates_ok' => 'Lahenda',
	'expand_templates_remove_comments' => 'Eemalda selgitavad märkused',
	'expand_templates_remove_nowiki' => 'Ära näita tulemuses <nowiki>-märgendeid',
	'expand_templates_generate_xml' => 'Näita XML sõelumispuud',
	'expand_templates_preview' => 'Eelvaade',
);

/** Basque (Euskara)
 * @author Theklan
 */
$messages['eu'] = array(
	'expandtemplates' => 'Txantiloi ordezkatzailea',
	'expand_templates_intro' => 'Aparteko orrialde honek modu errekurtsiboan txantiloiak ordezkatu egiten ditu. Funtzioak ere ordezkatu egiten ditu, hala nola <nowiki>{{</nowiki>#if:...}}, eta baita <nowiki>{{</nowiki>CURRENTDAY}} bezalako aldagaiak ere.',
	'expand_templates_title' => 'Izenburua ({{FULLPAGENAME}} ordezkatzeko, eta abar):',
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
 * @author Ebraminio
 * @author Huji
 * @author Wayiran
 */
$messages['fa'] = array(
	'expandtemplates' => 'بسط‌دادن الگوها',
	'expandtemplates-desc' => 'الگوها، دستورهای تجزیه‌کننده و متغیرها را گسترش می‌دهد تا متن نهایی را نمایش دهد و صفحه را به پیش‌نمایش در آورد',
	'expand_templates_intro' => 'این صفحهٔ ویژه متنی را دریافت کرده و تمام الگوهای به‌کاررفته در آن را به طور بازگشتی بسط می‌دهد. همچنین تابع‌های تجزیه چون <nowiki>{{</nowiki>#if:...}} و متغیرهایی چون  <nowiki>{{</nowiki>CURRENTDAY}} را هم بسط می‌دهد — در واقع تقریباً هرچه را که داخل دوآکولاد باشد. این کار با صدازدن مرحلهٔ تجزیهٔ مربوط در خود مدیاویکی صورت می‌گیرد.',
	'expand_templates_title' => 'عنوان موضوع، برای {{FULLPAGENAME}} و غیره:',
	'expand_templates_input' => 'متن ورودی:',
	'expand_templates_output' => 'نتیجه',
	'expand_templates_xml_output' => 'خروجی XML',
	'expand_templates_ok' => 'تأیید',
	'expand_templates_remove_comments' => 'حذف ملاحظات',
	'expand_templates_remove_nowiki' => 'خنثی کردن تگ‌های <nowiki> در نتیجه',
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
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Laajentaa mallineet, jäsentimen funktiot sekä muuttujat]] wikitekstiksi sekä näyttää esikatseluversion laajennetusta sivusta.',
	'expand_templates_intro' => 'Tämä toimintosivu ottaa syötteekseen tekstiä ja laajentaa kaikki mallineet rekursiivisesti sekä jäsenninfunktiot, kuten <nowiki>{{</nowiki>#if:...}}, ja -muuttujat, kuten <nowiki>{{</nowiki>CURRENTDAY}} &mdash; toisin sanoen melkein kaiken, joka on kaksoisaaltosulkeiden sisällä.',
	'expand_templates_title' => 'Otsikko (esimerkiksi muuttujaa {{FULLPAGENAME}} varten)',
	'expand_templates_input' => 'Teksti',
	'expand_templates_output' => 'Tulos',
	'expand_templates_xml_output' => 'XML-tuloste',
	'expand_templates_ok' => 'Laajenna',
	'expand_templates_remove_comments' => 'Poista kommentit',
	'expand_templates_remove_nowiki' => 'Poista <nowiki>-tagit tulosteesta',
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
 * @author Jean-Frédéric
 * @author Sherbrooke
 * @author Urhixidur
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'expandtemplates' => 'Expansion des modèles',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Réalise l’expansion des modèles, fonctions de l’analyseur syntaxique et variables]] afin de visionner le texte wiki obtenu après expansion et prévisualiser le rendu effectif de la page.',
	'expand_templates_intro' => 'Cette page spéciale accepte un texte wiki source et permet de réaliser récursivement l’expansion des modèles qu’il contient.
Elle réalise aussi l’expansion des fonctions du parseur telles que
<tt><nowiki>{{</nowiki>#if:...<nowiki>}}</nowiki></tt>  et des variables prédéfinies telles que
<tt><nowiki>{{</nowiki>CURRENTDAY<nowiki>}}</nowiki></tt> — en fait pratiquement tout ce qui est encadré par des doubles accolades.
Elle réalise ceci en appelant les étages successifs appropriés du parseur de MediaWiki lui-même.',
	'expand_templates_title' => 'Titre de la page, si le code utilise {{FULLPAGENAME}}, etc. :',
	'expand_templates_input' => 'Texte wiki source :',
	'expand_templates_output' => 'Texte wiki obtenu après expansion',
	'expand_templates_xml_output' => 'Résultat intermédiaire de l’analyse, au format XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Supprimer les commentaires',
	'expand_templates_remove_nowiki' => 'Supprime les marqueurs <nowiki> dans le résultat',
	'expand_templates_generate_xml' => 'Voir l’arborescence d’analyse XML',
	'expand_templates_preview' => 'Aperçu du rendu',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'expandtemplates' => 'Èxpension des modèlos',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Rèalise l’èxpension des modèlos, de les fonccions du parsor et de les variâbles]] por fâre vêre lo vouiquitèxto ètendu et pués prèvisualisar lo rendu èfèctif de la pâge.',
	'expand_templates_intro' => 'Ceta pâge spèciâla accèpte un vouiquitèxto sôrsa et pèrmèt de rèalisar rècursivament l’èxpension des modèlos que contint.
Rèalise asse-ben l’èxpension de les fonccions du parsor coment
<tt><nowiki>{{</nowiki>#if:...<nowiki>}}</nowiki></tt> et de les variâbles prèdèfenies coment
<tt><nowiki>{{</nowiki>CURRENTDAY<nowiki>}}</nowiki></tt> — en veré praticament tot cen qu’est encâdrâ per des dobles colâdes.
Rèalise cen en apelent los étâjos succèssifs que vont avouéc du parsor de MediaWiki lui-mémo.',
	'expand_templates_title' => 'Titro de la pâge, se lo code utilise {{FULLPAGENAME}}, etc. :',
	'expand_templates_input' => 'Vouiquitèxto sôrsa :',
	'expand_templates_output' => 'Rèsultat',
	'expand_templates_xml_output' => 'Rèsultat u format XML',
	'expand_templates_ok' => 'D’acôrd',
	'expand_templates_remove_comments' => 'Suprimar los comentèros',
	'expand_templates_remove_nowiki' => 'Suprime les balises <nowiki> dens lo rèsultat',
	'expand_templates_generate_xml' => 'Fâre vêre l’âbro du parsor u format XML',
	'expand_templates_preview' => 'Prèvisualisacion du rendu',
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
	'expandtemplates' => 'Expandir os modelos',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Amplía modelos, analiza funcións e variables]] para mostrar texto wiki expandido e unha vista previa da páxina renderizada',
	'expand_templates_intro' => 'Esta páxina especial toma texto e amplía todos os modelos dentro del recursivamente.
Tamén expande as funcións de análise como <nowiki>{{</nowiki>#if:…}} e variables como
<nowiki>{{</nowiki>CURRENTDAY}} (de feito, case calquera cousa entre chaves duplas).
Faino chamando a etapa de análise correspondente do propio MediaWiki.',
	'expand_templates_title' => 'Título do contexto, para {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Texto de entrada:',
	'expand_templates_output' => 'Resultado',
	'expand_templates_xml_output' => 'saída XML',
	'expand_templates_ok' => 'Aceptar',
	'expand_templates_remove_comments' => 'Eliminar os comentarios',
	'expand_templates_remove_nowiki' => 'Suprimir as etiquetas <nowiki> no resultado',
	'expand_templates_generate_xml' => 'Mostrar as árbores de análise XML',
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
	'expand_templates_title' => 'Kontexttitel, fir {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Yygabfäld:',
	'expand_templates_output' => 'Ergebnis',
	'expand_templates_xml_output' => 'XML-Usgab',
	'expand_templates_ok' => 'Uusfiere',
	'expand_templates_remove_comments' => 'Kommentar useneh',
	'expand_templates_remove_nowiki' => '<nowiki>-Befähl im Ergebnis unterdrucke',
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
	'expand_templates_title' => 'כותרת ההקשר לפענוח, בשביל משתנים כגון {{FULLPAGENAME}} וכדומה:',
	'expand_templates_input' => 'טקסט:',
	'expand_templates_output' => 'תוצאה',
	'expand_templates_xml_output' => 'פלט XML',
	'expand_templates_ok' => 'פריסת תבניות',
	'expand_templates_remove_comments' => 'הסרת הערות',
	'expand_templates_remove_nowiki' => 'הסרת תגיות <nowiki> בתוצאה',
	'expand_templates_generate_xml' => 'הצגת עץ הפענוח של XML',
	'expand_templates_preview' => 'תצוגה מקדימה',
);

/** Hindi (हिन्दी)
 * @author Ansumang
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
	'expand_templates_title' => '{{FULLPAGENAME}} इ. के लिये, कन्टेक्स्ट शीर्षक:',
	'expand_templates_input' => 'इनपुट पाठ:',
	'expand_templates_output' => 'रिज़ल्ट',
	'expand_templates_xml_output' => 'XML आउटपुट',
	'expand_templates_ok' => 'ओके',
	'expand_templates_remove_comments' => 'टिप्पणी हटायें',
	'expand_templates_remove_nowiki' => 'रोकें <nowiki> परिणाम में टैग',
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
 * @author Excaliboor
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'expandtemplates' => 'Prikaz sadržaja predložaka',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Proširanje predložaka, parserskih funkcija i varijabli]] za prikaz proširenog wikiteksta i pregled prevedene stranice',
	'expand_templates_intro' => 'Ova posebna stranica omogućuje unos wikiteksta i prikazuje njegov rezultat,
uključujući i (rekurzivno, tj. potpuno) sve uključene predloške u wikitekstu.
Prikazuje i rezultate funkcija kao <nowiki>{{</nowiki>#if:...}} i varijabli
kao <nowiki>{{</nowiki>CURRENTDAY}}. Funkcionira pozivanjem parsera same MedijeWiki.',
	'expand_templates_title' => 'Kontekstni naslov stranice, za {{FULLPAGENAME}} i sl.:',
	'expand_templates_input' => 'Ulazni tekst:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'XML kod',
	'expand_templates_ok' => 'Prikaži',
	'expand_templates_remove_comments' => 'Ukloni komentare',
	'expand_templates_remove_nowiki' => 'Ukloni <nowiki> tagove u rezultatima.',
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
	'expand_templates_title' => 'Kontekstowy titul, za {{FULLPAGENAME}} atd.:',
	'expand_templates_input' => 'Tekst zapodać:',
	'expand_templates_output' => 'Wuslědk',
	'expand_templates_xml_output' => 'Wudaće XML',
	'expand_templates_ok' => 'W porjadku',
	'expand_templates_remove_comments' => 'Komentary wotstronić',
	'expand_templates_remove_nowiki' => 'Taflički <nowiki> we wuslědku potłóčić',
	'expand_templates_generate_xml' => 'Analyzowy štom XML pokazać',
	'expand_templates_preview' => 'Přehlad',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 * @author KossuthRad
 */
$messages['hu'] = array(
	'expandtemplates' => 'Sablonok kibontása',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Kiértékeli a sablonokat, az értelmező-funkciókat és a változókat]], így megtekinthető a kész wikiszöveg, valamint az oldal',
	'expand_templates_intro' => 'Ez a speciális lap a bevitt szövegekben megkeresi a sablonokat és rekurzívan kibontja őket.
Kibontja az elemző függvényeket (pl. <nowiki>{{</nowiki>#if:...}}), és a változókat (pl. <nowiki>{{</nowiki>CURRENTDAY}}) is – mindent, ami a kettős kapcsos zárójelek között van.',
	'expand_templates_title' => 'Szöveg címe, például {{FULLPAGENAME}} sablonhoz:',
	'expand_templates_input' => 'Vizsgálandó szöveg',
	'expand_templates_output' => 'Eredmény',
	'expand_templates_xml_output' => 'XML kimenet',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Megjegyzések eltávolítása',
	'expand_templates_remove_nowiki' => '<nowiki> tagek mellőzése az eredményben',
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
	'expand_templates_title' => 'Titulo de contexto, pro {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Texto de entrata:',
	'expand_templates_output' => 'Resultato',
	'expand_templates_xml_output' => 'Output XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Eliminar commentos',
	'expand_templates_remove_nowiki' => 'Supprimer le etiquettas <nowiki> in le resultato',
	'expand_templates_generate_xml' => 'Monstrar arbore syntactic XML',
	'expand_templates_preview' => 'Previsualisation',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'expandtemplates' => 'Pengembangan templat',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Mengembangkan templat, fungsi parser dan variables]] untuk menunjukkan hasil teks wiki dan pratayang halaman hasilnya',
	'expand_templates_intro' => 'Halaman istimewa ini menerima teks dan mengembangkan semua templat di dalamnya secara rekursif. Halaman ini juga menerjemahkan semua fungsi parser seperti <nowiki>{{</nowiki>#if:...}}, dan variabel seperti <nowiki>{{</nowiki>CURRENTDAY}}&mdash;bahkan bisa dibilang segala sesuatu yang berada di antara dua tanda kurung. Ini dilakukan dengan memanggil tahapan parser yang sesuai dari MediaWiki.',
	'expand_templates_title' => 'Judul konteks, untuk {{FULLPAGENAME}} dan lain-lain:',
	'expand_templates_input' => 'Teks masukan:',
	'expand_templates_output' => 'Hasil',
	'expand_templates_xml_output' => 'Hasil XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Buang komentar',
	'expand_templates_remove_nowiki' => 'Tidak menampilkan tag <nowiki> pada hasilnya',
	'expand_templates_generate_xml' => 'Tampilkan pohon parser XML',
	'expand_templates_preview' => 'Pratayang',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'expand_templates_ok' => 'Ngwanu',
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
 * @author Civvì
 */
$messages['it'] = array(
	'expandtemplates' => 'Espansione dei template',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Espande i template, le funzioni del parser e le variabili]] per mostrare il wikitesto espanso e visualizzare un'anteprima della pagina nella sua forma finale",
	'expand_templates_intro' => 'Questa pagina speciale elabora un testo espandendo tutti i template presenti. Calcola inoltre il risultato delle funzioni supportate dal parser come <nowiki>{{</nowiki>#if:...}} e delle variabili di sistema quali <nowiki>{{</nowiki>CURRENTDAY}}, ovvero praticamente tutto ciò che si trova tra doppie parentesi graffe. Funziona richiamando le opportune funzioni del parser di MediaWiki.',
	'expand_templates_title' => 'Contesto (per {{FULLPAGENAME}} ecc.):',
	'expand_templates_input' => 'Testo da espandere:',
	'expand_templates_output' => 'Risultato',
	'expand_templates_xml_output' => 'Output in formato XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Ignora i commenti',
	'expand_templates_remove_nowiki' => 'Elimina il tag <nowiki> nel risultato',
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
	'expand_templates_title' => '{{FULLPAGENAME}} などの評価を行うページの名前:',
	'expand_templates_input' => '展開するテキスト',
	'expand_templates_output' => '展開結果',
	'expand_templates_xml_output' => 'XML出力',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'コメントを除去する',
	'expand_templates_remove_nowiki' => '結果中の <nowiki> タグを表示しない',
	'expand_templates_generate_xml' => 'XML 構文解析ツリーを表示する',
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
	'expand_templates_title' => 'Irah-irahan kontèks, kanggo {{FULLPAGENAME}} lan sabanjuré:',
	'expand_templates_input' => 'Tèks sumber:',
	'expand_templates_output' => 'Pituwas (kasil)',
	'expand_templates_xml_output' => 'Pituwas XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Busaken komentar',
	'expand_templates_generate_xml' => 'Tuduhna uwit parser XML',
	'expand_templates_preview' => 'Pratayang',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Dawid Deutschland
 */
$messages['ka'] = array(
	'expandtemplates' => 'გაშლილი თარგები',
	'expand_templates_title' => 'კონტექსტის სათაური, {{FULLPAGENAME}}-სთვის და ა.შ.:',
	'expand_templates_input' => 'შესაყვანი ტექსტი:',
	'expand_templates_output' => 'შედეგი',
	'expand_templates_ok' => 'შესრულება',
	'expand_templates_remove_comments' => 'კომენტარების წაშლა',
	'expand_templates_preview' => 'წინა',
);

/** Kazakh (Arabic script) (‫قازاقشا (تٴوتە)‬) */
$messages['kk-arab'] = array(
	'expandtemplates' => 'ۇلگىلەردى ۇلعايتۋ',
	'expand_templates_intro' => 'وسى قۇرال ارنايى بەتى الدەبىر ٴماتىندى الادى دا,
بۇنىڭ ىشىندەگى بارلىق كىرىكتەلگەن ۇلگىلەردى مەيلىنشە ۇلعايتادى.
مىنا <nowiki>{{#if:...}} سىيياقتى جوڭدەتۋ فۋنكتسىييالارىن دا, جانە {{CURRENTDAY}}
سىيياقتى اينامالىلارىن دا ۇلعايتادى (ناقتى ايتقاندا, قوس قابات ساداق جاقشالار اراسىنداعى بارلىعىن).
بۇنى ٴوز MediaWiki باعدارلاماسىنان قاتىستى جوڭدەتۋ ساتىن شاقىرىپ ىستەلىنەدى.',
	'expand_templates_title' => 'ٴماتىن ارالىق اتاۋى ({{FULLPAGENAME}} ت.ب. بەتتەر ٴۇشىن):',
	'expand_templates_input' => 'كىرىس ٴماتىنى:',
	'expand_templates_output' => 'ناتىيجەسى',
	'expand_templates_xml_output' => 'XML شىعارۋى',
	'expand_templates_ok' => 'جارايدى',
	'expand_templates_remove_comments' => 'ماندەمەلەرىن الاستاتىپ?',
	'expand_templates_generate_xml' => 'XML وڭدەتۋ بۇتاقتارىن كورسەت',
	'expand_templates_preview' => 'قاراپ شىعۋ',
);

/** Kazakh (Cyrillic script) (‪Қазақша (кирил)‬) */
$messages['kk-cyrl'] = array(
	'expandtemplates' => 'Үлгілерді ұлғайту',
	'expand_templates_intro' => 'Осы құрал арнайы беті әлдебір мәтінді алады да,
бұның ішіндегі барлық кіріктелген үлгілерді мейлінше ұлғайтады.
Мына <nowiki>{{</nowiki>#if:...}} сияқты жөңдету функцияларын да, және <nowiki>{{</nowiki>CURRENTDAY}}
сияқты айнамалыларын да ұлғайтады (нақты айтқанда, қос қабат садақ жақшалар арасындағы барлығын).
Бұны өз MediaWiki бағдарламасынан қатысты жөңдету сатын шақырып істелінеді.',
	'expand_templates_title' => 'Мәтін аралық атауы ({{FULLPAGENAME}} т.б. беттер үшін):',
	'expand_templates_input' => 'Кіріс мәтіні:',
	'expand_templates_output' => 'Нәтижесі',
	'expand_templates_xml_output' => 'XML шығаруы',
	'expand_templates_ok' => 'Жарайды',
	'expand_templates_remove_comments' => 'Мәндемелерін аластатып?',
	'expand_templates_generate_xml' => 'XML өңдету бұтақтарын көрсет',
	'expand_templates_preview' => 'Қарап шығу',
);

/** Kazakh (Latin script) (‪Qazaqşa (latın)‬) */
$messages['kk-latn'] = array(
	'expandtemplates' => 'Ülgilerdi ulğaýtw',
	'expand_templates_intro' => 'Osı qural arnaýı beti äldebir mätindi aladı da,
bunıñ işindegi barlıq kiriktelgen ülgilerdi meýlinşe ulğaýtadı.
Mına <nowiki>{{</nowiki>#if:...}} sïyaqtı jöñdetw fwnkcïyaların da, jäne <nowiki>{{</nowiki>CURRENTDAY}}
sïyaqtı aýnamalıların da ulğaýtadı (naqtı aýtqanda, qos qabat sadaq jaqşalar arasındağı barlığın).
Bunı öz MediaWiki bağdarlamasınan qatıstı jöñdetw satın şaqırıp istelinedi.',
	'expand_templates_title' => 'Mätin aralıq atawı ({{FULLPAGENAME}} t.b. better üşin):',
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

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'expand_templates_preview' => 'ಮುನ್ನೋಟ',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 */
$messages['ko'] = array(
	'expandtemplates' => '틀 전개',
	'expandtemplates-desc' => '틀, 파서 함수, 변수 등을 모두 풀어낸 문서를 볼 수 있는 [[Special:ExpandTemplates|틀 전개]] 기능',
	'expand_templates_intro' => '이 특수문서는 글의 모든 틀을 끝까지 풀어 줍니다.
<nowiki>{{</nowiki>#if:…}} 같은 파서 함수나 <nowiki>{{</nowiki>CURRENTDAY}} 같은 변수를 포함해 두개의 중괄호 사이에 있는 것은 모두 풀어줍니다.
미디어위키의 자체 파서로 작동합니다.',
	'expand_templates_title' => '문서 이름 ({{FULLPAGENAME}} 등):',
	'expand_templates_input' => '전개할 내용:',
	'expand_templates_output' => '결과',
	'expand_templates_xml_output' => 'XML 출력',
	'expand_templates_ok' => '확인',
	'expand_templates_remove_comments' => '주석 지우기',
	'expand_templates_remove_nowiki' => '결과에서 <nowiki> 태그를 숨기기',
	'expand_templates_generate_xml' => 'XML 구문 트리 보기',
	'expand_templates_preview' => '미리보기',
);

/** Karachay-Balkar (Къарачай-Малкъар)
 * @author Iltever
 */
$messages['krc'] = array(
	'expandtemplates' => 'Шаблонланы ачыу',
);

/** Kinaray-a (Kinaray-a)
 * @author Jose77
 */
$messages['krj'] = array(
	'expand_templates_ok' => 'OK dun',
	'expand_templates_preview' => 'Bilid',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'expandtemplates' => 'Schablone üvverpröfe',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Schablone, Parserfunktione un Variable oplöse]] un dä komplette Wikitex aanzeije',
	'expand_templates_intro' => 'Hee kanns de en Schablon usprobeere. Do jiss ene Oprof en, un dann kriss De dä komplett opjelös, och all die ennedren widder opjerofe Schablone, Parameter, Funktione, spezielle Name, un esu, bes nix mieh üvverich es, wat mer noch oplöse künnt. Wann jet en <nowiki>{{ … }} Klammere üvverbliet, dann wor et unbekannt. Do passeet jenau et selve wie söns em Wiki och, nor dat De hee tirek ze sinn kriss wat erus kütt.',
	'expand_templates_title' => 'Dä Siggetitel, also wat för {{FULLPAGENAME}} uew. enjeföllt weed:',
	'expand_templates_input' => 'Wat De üvverpröfe wells:',
	'expand_templates_output' => 'Wat erus kütt es',
	'expand_templates_xml_output' => 'XML ußjevve',
	'expand_templates_ok' => 'Lohß Jonn!',
	'expand_templates_remove_comments' => 'De ėnner Kommentare fottloohße',
	'expand_templates_remove_nowiki' => 'Donn de <nowiki>-Befähle ongerdröcke en dämm, wadd_eruß kütt',
	'expand_templates_generate_xml' => 'Och dä XML-Parser-Boum zeije',
	'expand_templates_preview' => 'Vör-Aansich',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'expand_templates_output' => 'Encam',
	'expand_templates_ok' => 'Temam',
	'expand_templates_preview' => 'Pêşdîtin',
);

/** Latin (Latina)
 * @author SPQRobin
 */
$messages['la'] = array(
	'expandtemplates' => 'Formulas resolvere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'expandtemplates' => 'Schablounen expandéieren',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Erweidert Schablounen, Parser-Funktiounen a Variabelen]] zu engem komplette Wikitext a weist d'Säiten esou wéi wann se ofgespäichert wieren.",
	'expand_templates_intro' => "Op dëser Spezialsäit kann Text agesat ginn an all Schablounen doran gi rekursiv expandéiert.
Och Parserfonctioune wéi <nowiki>{{</nowiki>#if:…}} a Variabele wéi 
<nowiki>{{</nowiki>CURRENTDAY}} ginn ausgewäert&mdash; faktesch alles wat duebelen Accolade steet.
Dat geschitt duerch d'Oprufe vun de jeeweilege Parser-Phase vu MediaWiki selwer.",
	'expand_templates_title' => 'Titel vun der Säit, dëst kann nëtzlech si wa(nn) {{FULLPAGENAME}} benotzt gëtt:',
	'expand_templates_input' => 'Gitt ären Text hei an:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'Resultat als XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Bemierkunge läschen',
	'expand_templates_remove_nowiki' => '<nowiki>-Taggen am Resultat suppriméieren',
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
	'expand_templates_title' => 'Contekstitel, veur {{FULLPAGENAME}}, etc:',
	'expand_templates_input' => 'Inlaajteks:',
	'expand_templates_output' => 'Rezultaot',
	'expand_templates_xml_output' => 'XML-oetveur',
	'expand_templates_ok' => 'ok',
	'expand_templates_remove_comments' => 'Wis opmerkinge',
	'expand_templates_remove_nowiki' => "Óngerdrök <nowiki>-tags in 't resultaat",
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
	'expand_templates_ok' => 'Йӧра',
	'expand_templates_preview' => 'Ончылгоч ончымаш',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'expandtemplates' => 'Прошири шаблони',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Проширува шаблони, парсерски функции и променливи]] за приказ на проширен викитекст и преглед на прикажаната слика',
	'expand_templates_intro' => 'Оваа специјална страница зема еден текст и рекурзивно ги проширува сите шаблони во него.
Исто така проширува и парсерски функции како
<nowiki>{{</nowiki>#if:…}}, и променливи како
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;всушност сето она што е во двојни големи загради.
Ова го врши со повикување на релевантната парсерска етапа од самиот МедијаВики.',
	'expand_templates_title' => 'Наслов на контекстот, за {{FULLPAGENAME}} и тн.:',
	'expand_templates_input' => 'Влезен текст:',
	'expand_templates_output' => 'Извод',
	'expand_templates_xml_output' => 'XML излез',
	'expand_templates_ok' => 'ОК',
	'expand_templates_remove_comments' => 'Отстрани коментари',
	'expand_templates_remove_nowiki' => 'Притаи <nowiki> ознаки во резултатот',
	'expand_templates_generate_xml' => 'Прикажи XML дрво на парсирање',
	'expand_templates_preview' => 'Преглед',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'expandtemplates' => 'ഫലകങ്ങൾ വിപുലീകരിക്കുക',
	'expandtemplates-desc' => 'വികസിപ്പിക്കാവുന്ന വിക്കിഎഴുത്തുകൾ പ്രദർശിപ്പിക്കാനും പ്രദർശിപ്പിക്കേണ്ട താൾ എങ്ങനെയുണ്ടെന്നു കാണാനുമുള്ള [[Special:ExpandTemplates|വികസിപ്പിക്കാവുന്ന ഫലകങ്ങളും പാഴ്സർ ഫങ്ഷനുകളും ചരങ്ങളും]]',
	'expand_templates_intro' => 'ഈ പ്രത്യേക താൾ ചില എഴുത്തുകൾ എടുത്ത് എല്ലാ ഫലകങ്ങളും പുനരാവർത്തിത സ്വഭാവത്തോടെ വികസിപ്പിക്കുന്നു.
<nowiki>{{</nowiki>#എങ്കിൽ:…}} തുടങ്ങിയ പാഴ്സർ ഫങ്ഷനുകളും
<nowiki>{{</nowiki>ഈദിവസം}}&mdash; തുടങ്ങിയ ചരങ്ങളും, ഈ താൾ വികസിപ്പിക്കുന്നുണ്ട്.
ചുരുക്കിപറഞ്ഞാൽ ഇരട്ട കോഷ്ഠകങ്ങളിലുള്ള എന്തിനേയും വികസിപ്പിക്കുന്നു.
മീഡിയവിക്കിയിലെ ബന്ധപ്പെട്ട പാഴ്സർ സൗകര്യം ഉപയോഗിച്ചാണ് ഇത് സാദ്ധ്യമാക്കുന്നത്.',
	'expand_templates_title' => '{{FULLPAGENAME}} താളിന്റെ ഉള്ളടക്ക തലക്കെട്ട് മുതലായവ.:',
	'expand_templates_input' => 'ഇൻപുട്ട് ടെക്സ്റ്റ്:',
	'expand_templates_output' => 'ഫലം',
	'expand_templates_xml_output' => 'XML ഔട്ട്പുട്ട്',
	'expand_templates_ok' => 'ശരി',
	'expand_templates_remove_comments' => 'അഭിപ്രായങ്ങൾ ഒഴിവാക്കുക',
	'expand_templates_remove_nowiki' => 'ഫലങ്ങളിലെ <nowiki> റ്റാഗുകൾ ഒതുക്കുക',
	'expand_templates_generate_xml' => 'XML പാർസർ ട്രീ പ്രദർശിപ്പിക്കുക',
	'expand_templates_preview' => 'എങ്ങനെയുണ്ടെന്നു കാണുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'expand_templates_input' => 'Оруулах бичиг:',
	'expand_templates_output' => 'Үр дүн',
	'expand_templates_remove_comments' => 'Товч агуулгыг авч хаях',
);

/** Marathi (मराठी)
 * @author Htt
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
	'expand_templates_title' => '{{FULLPAGENAME}} वगैरे करीता, कन्टेक्स्ट शीर्षक:',
	'expand_templates_input' => 'इनपुट मजकूर:',
	'expand_templates_output' => 'निकाल',
	'expand_templates_xml_output' => 'XML चे आऊटपुट',
	'expand_templates_ok' => 'ठिक',
	'expand_templates_remove_comments' => 'संदेश हटवा',
	'expand_templates_remove_nowiki' => 'निकालात <nowiki> अंकितक दाखवू नका',
	'expand_templates_generate_xml' => 'XML चा पार्स (parse) वृक्ष दाखवा',
	'expand_templates_preview' => 'झलक',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 * @author Aviator
 */
$messages['ms'] = array(
	'expandtemplates' => 'Kembangkan templat',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Mengembangkan templat, fungsi penghurai dan pemboleh ubah]] untuk memaparkan teks wiki yang dikembangkan dan pralihat laman yang terhasil',
	'expand_templates_intro' => 'Laman khas ini menerima sebarang teks dan mengembangkan semua templat di dalamnya secara rekursif. Laman ini juga mengembangkan fungsi penghurai seperti <nowiki>{{</nowiki>#if:…}} dan pemboleh ubah seperti <nowiki>{{</nowiki>CURRENTDAY}}&mdash;tentunya setiap benda dalam kurungan berganda. Proses ini dilakukan dengan memanggil tahap penghurai yang berkenaan dalam MediaWiki sendiri.',
	'expand_templates_title' => 'Tajuk konteks, untuk {{FULLPAGENAME}} dan sebagainya:',
	'expand_templates_input' => 'Teks input:',
	'expand_templates_output' => 'Hasil',
	'expand_templates_xml_output' => 'Output XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Buang ulasan',
	'expand_templates_remove_nowiki' => 'Sekat tag <nowiki> dalam hasil',
	'expand_templates_generate_xml' => 'Papar pepohon hurai XML',
	'expand_templates_preview' => 'Pralihat',
);

/** Maltese (Malti)
 * @author Giangian15
 */
$messages['mt'] = array(
	'expandtemplates' => 'Espandi l-mudelli',
	'expand_templates_output' => 'Riżultat',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Neħħi l-kummenti',
	'expand_templates_generate_xml' => 'Uri siġra sintattika XML',
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

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'expandtemplates' => 'Utvid maler',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Utvider maler, parserfunksjoner og variabler]] for å vise resultatråteksten og forhåndsvise siden slik den blir',
	'expand_templates_intro' => 'Denne siden tar en tekst og utvider alle maler brukt i teksten. Den utvider også alle funksjoner som <nowiki>{{</nowiki>#if:…}}, og variabler som <nowiki>{{</nowiki>CURRENTDAY}}. <!--It does this by calling the relevant parser stage from MediaWiki itself.-->',
	'expand_templates_title' => 'Konteksttittel, for {{FULLPAGENAME}}, etc.:',
	'expand_templates_input' => 'Skriv inn tekst:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-resultat',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Fjern kommentarer',
	'expand_templates_remove_nowiki' => 'Ikke vis <nowiki>-merkelapper i resultatet',
	'expand_templates_generate_xml' => 'Vis parsetre som XML',
	'expand_templates_preview' => 'Forhåndsvisning',
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
	'expand_templates_title' => 'Kontexttitel, för {{FULLPAGENAME}} etc.:',
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
	'expand_templates_intro' => 'Op disse spesiale pagina kan tekste in-evoerd wörden en alle mallen derin wörden rekursief esubstitueerd. Oek parserfunksies zo as <nowiki>{{</nowiki>#if:...}} en variabels zo as <nowiki>{{</nowiki>CURRENTDAY}} wörden esubstitueerd - eigenliks alles wat tussen dubbele krulhaken steet. Dit wörden edaon deur de betreffende parserfunksies op te reupen vanuut de MediaWiki-programmatuur.',
	'expand_templates_title' => 'Titel, veur {{FULLPAGENAME}}, enz.:',
	'expand_templates_input' => 'Invoertekste:',
	'expand_templates_output' => 'Resultaot',
	'expand_templates_ok' => 'Oké',
	'expand_templates_remove_comments' => 'Opmarking vorthaolen',
	'expand_templates_preview' => 'Naokieken',
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
	'expand_templates_title' => 'Contexttitel, voor {{FULLPAGENAME}}, enzovoort:',
	'expand_templates_input' => 'Invoertekst:',
	'expand_templates_output' => 'Resultaat',
	'expand_templates_xml_output' => 'XML-uitvoer',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Opmerkingen verwijderen',
	'expand_templates_remove_nowiki' => 'Tags <nowiki> in resultaat onderdrukken',
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
Dette gjer ho ved å kalla dei relevante parsersetega frå MediaWiki sjølv.',
	'expand_templates_title' => 'Konteksttittel, for {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Inntekst:',
	'expand_templates_output' => 'Resultat',
	'expand_templates_xml_output' => 'XML-resultat',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Fjern kommentarar',
	'expand_templates_remove_nowiki' => 'Ikkje vis <nowiki>-merke i resultatet',
	'expand_templates_generate_xml' => 'Vis parsertre som XML',
	'expand_templates_preview' => 'Førehandsvising',
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
	'expand_templates_title' => 'Títol de l’article, util per exemple se lo modèl utiliza {{FULLPAGENAME}} :',
	'expand_templates_input' => 'Picatz vòstre tèxte aicí :',
	'expand_templates_output' => 'Visualizatz lo resultat :',
	'expand_templates_xml_output' => 'Sortida XML',
	'expand_templates_ok' => "D'acòrdi",
	'expand_templates_remove_comments' => 'Suprimir los comentaris.',
	'expand_templates_remove_nowiki' => 'Suprimís los marcadors <nowiki> dins lo resultat',
	'expand_templates_generate_xml' => "Veire l'arborescéncia XML",
	'expand_templates_preview' => 'Previsualizacion',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 * @author Psubhashish
 */
$messages['or'] = array(
	'expand_templates_input' => 'ଇନପୁଟ ବିଷୟ:',
	'expand_templates_output' => 'ପରିଣାମ',
	'expand_templates_ok' => 'ଠିକ ଅଛି',
	'expand_templates_remove_comments' => 'ମତାମତ ହଟାନ୍ତୁ',
	'expand_templates_preview' => 'ଦେଖଣା',
);

/** Ossetic (Ирон)
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

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'expand_templates_output' => 'Result',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Anmaerrickinge lösche',
	'expand_templates_preview' => 'Aagucke',
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
	'expand_templates_title' => 'Pozorny tytuł strony dla zmiennych takich jak {{FULLPAGENAME}}',
	'expand_templates_input' => 'Tekst wejściowy',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'wynik w formacie XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Usuń komentarze',
	'expand_templates_remove_nowiki' => 'Ukrywaj w wyniku znaczniki <nowiki>',
	'expand_templates_generate_xml' => 'Pokaż drzewo analizatora składni w formacie XML',
	'expand_templates_preview' => 'Podgląd',
);

/** Piedmontese (Piemontèis)
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'expandtemplates' => 'Anàlisi djë stamp',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|A espand jë stamp, le funsion dël parser e le variabij]] për mosté ël wikitest espandù e fé vëdde la pàgina final',
	'expand_templates_intro' => "Sta pàgina special-sì a pija dël test e a-i fa n'anàlisi arcorsiva ëd tuti jë stamp ch'a l'ha andrinta. 
A l'analisa ëdcò le fonsion anterpretà coma
<nowiki>{{</nowiki>#if:...}}, e le variabij coma
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;visadì bele che tut lòn ch'a-i é antra dobie grafe.
Sòn a lo fa ën ciamand l'anterprete dal programa MediaWiki.",
	'expand_templates_title' => 'Tìtol ëd contest për {{FULLPAGENAME}} e via fòrt:',
	'expand_templates_input' => 'Test da analisé:',
	'expand_templates_output' => 'Arzultà',
	'expand_templates_xml_output' => 'Output an XML',
	'expand_templates_ok' => 'Bin parèj',
	'expand_templates_remove_comments' => 'Gava via ij coment',
	'expand_templates_remove_nowiki' => "Gava ij tag <nowiki> ant l'arzultà",
	'expand_templates_generate_xml' => "Mosta l'erbo ëd parse XML",
	'expand_templates_preview' => 'Preuva',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'expandtemplates' => 'کينډۍ غځول',
	'expand_templates_input' => 'ځايونکی متن:',
	'expand_templates_output' => 'پايله',
	'expand_templates_ok' => 'ښه',
	'expand_templates_preview' => 'مخکتنه',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Indech
 * @author Malafaya
 */
$messages['pt'] = array(
	'expandtemplates' => 'Expandir predefinições',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expande predefinições, funções do analisador sintáctico e variáveis]] para mostrar texto wiki expandido e antever o aspecto final da página',
	'expand_templates_intro' => "Esta página especial recebe um texto e expande recursivamente todas as predefinições nele existentes.
Também expande funções do analisador sintáctico ''(parser)'', tais como
<nowiki>{{</nowiki>#if:...}}, e variáveis, tais como
<nowiki>{{</nowiki>CURRENTDAY}} &mdash; de facto, expande tudo o que estiver entre chavetas duplas.
Isto é feito chamando o estágio relevante do analisador sintáctico a partir do próprio MediaWiki.
Ver o resultado nas secções abaixo.",
	'expand_templates_title' => 'Título de contexto para {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Texto a expandir:',
	'expand_templates_output' => 'Resultado',
	'expand_templates_xml_output' => 'Resultado XML',
	'expand_templates_ok' => 'Expandir',
	'expand_templates_remove_comments' => 'Remover comentários',
	'expand_templates_remove_nowiki' => "Suprimir ''tags'' <nowiki> no resultado",
	'expand_templates_generate_xml' => 'Mostrar a árvore de análise sintáctica do XML',
	'expand_templates_preview' => 'Antevisão do resultado',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 * @author Giro720
 * @author Hamilton Abreu
 */
$messages['pt-br'] = array(
	'expandtemplates' => 'Expandir predefinições',
	'expandtemplates-desc' => 'Expande predefinições, funções do analisador (parser) e variáveis para mostrar texto wiki expandido e prever o aspecto da página',
	'expand_templates_intro' => 'Esta página especial pega algum texto e expande todas as predefinições nele existentes recursivamente. Também expande funções do analisador (parser) como <nowiki>{{</nowiki>#if:...}}, e variáveis como <nowiki>{{</nowiki>CURRENTDAY}}&mdash;de fato, tudo entre chaves duplas. Isto é feito através da chamada ao estágio relevante do analisador (parser) do próprio MediaWiki.',
	'expand_templates_title' => 'Título de contexto para {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Texto de entrada:',
	'expand_templates_output' => 'Resultado',
	'expand_templates_xml_output' => 'Resultado XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Remover comentários',
	'expand_templates_remove_nowiki' => 'Suprima marcações <nowiki> no resultado',
	'expand_templates_generate_xml' => 'Mostrar árvore de análise (parse) do XML',
	'expand_templates_preview' => 'Pré-visualização',
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
 * @author Cin
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 */
$messages['ro'] = array(
	'expandtemplates' => 'Extindere formate',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Extinde formatele, funcțiile parser și variabilele]] pentru a vedea extins textul wiki și pentru a previzualiza modul de redare a paginii',
	'expand_templates_title' => 'Titlul paginii, pentru {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Text sursă:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'Ieșire XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Elimină comentariile',
	'expand_templates_remove_nowiki' => 'Suprimă etichetele <nowiki> în rezultat',
	'expand_templates_generate_xml' => 'Arată arborele analiză XML',
	'expand_templates_preview' => 'Previzualizare',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'expandtemplates' => 'Template spannute',
	'expandtemplates-desc' => "[[Special:ExpandTemplates|Template ca se spannene, funziune de analise e variabbele]] pe fà vedè 'u Uicchiteste espanse e fà vedè l'andeprime d'a pàgene renderizzate",
	'expand_templates_intro' => "Sta pàgena speciale pigghie quacche teste e spanne tutte le template jndr'à jidde recorsivamende.<br />
Jidde spanne pure le funziune de analise cumme<br />
<nowiki>{{</nowiki>#if:…}}, e variabbele cumme <br />
<nowiki>{{</nowiki>CURRENTDAY}}&mdash; in pratiche tutte quidde ca stè jndr'à le doppie parendesi graffe.<br />
'U face quiste, chiamanne l'analizzatore direttamende da MediaUicchi.",
	'expand_templates_title' => 'Titele condestuale, pe {{FULLPAGENAME}} ecc.:',
	'expand_templates_input' => 'Teste de input:',
	'expand_templates_output' => 'Resultete',
	'expand_templates_xml_output' => 'XML de output',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Live le commende',
	'expand_templates_remove_nowiki' => "No fà vede le tag <nowiki> jndr'à 'u resultate",
	'expand_templates_generate_xml' => "Fà vedè l'arvule de l'analisi XML",
	'expand_templates_preview' => 'Andeprime',
);

/** Russian (Русский)
 * @author AlexSm
 * @author KPu3uC B Poccuu
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'expandtemplates' => 'Развёртка шаблонов',
	'expandtemplates-desc' => 'Раскрывает шаблоны, функции парсера и переменные, чтобы показать развёрнутый вики-текст и просмотреть отрисованную страницу',
	'expand_templates_intro' => 'Эта служебная страница преобразует текст, рекурсивно разворачивая все шаблоны в нём.
Также развёртке подвергаются функции парсера
<code><nowiki>{{#if:…}}</nowiki></code> и переменные
<code><nowiki>{{CURRENTDAY}}</nowiki></code> — в общем, всё внутри двойных фигурных скобок.
Это производится корректным образом, с вызовом соответствующего обработчика MediaWiki.',
	'expand_templates_title' => 'Заголовок страницы для {{FULLPAGENAME}} и т. п.:',
	'expand_templates_input' => 'Входной текст:',
	'expand_templates_output' => 'Результат',
	'expand_templates_xml_output' => 'XML вывод',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Удалить комментарии',
	'expand_templates_remove_nowiki' => 'Подавлять теги <nowiki> в результате',
	'expand_templates_generate_xml' => 'Показать дерево разбора XML',
	'expand_templates_preview' => 'Предпросмотр',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'expandtemplates' => 'Розгортаня шаблон',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Розбалює шаблоны, функції парсера і перемінны]], жебы указати розгорнутый вікітекст і нагляд сторінкы',
	'expand_templates_intro' => 'Тота шпеціална сторінка перетворює текст, рекурзівно розгортаювші у ній вшыткы шаблоны як <code><nowiki>{{</nowiki>#if:…...}}</code> ці перемінны як <code><nowiki>{{</nowiki>CURRENTDAY}}</code> – тзн. практічно вшытко у двоїтых заперках. Ку тому ся хоснують прямо одповідаючі функціі парсера MediaWiki.',
	'expand_templates_title' => 'Назва сторінкы про контекст про {{FULLPAGENAME}} ітд.:',
	'expand_templates_input' => 'Вступный текст:',
	'expand_templates_output' => 'Резултат',
	'expand_templates_xml_output' => 'XML-выступ',
	'expand_templates_ok' => 'ОК',
	'expand_templates_remove_comments' => 'Одстранити коментарї',
	'expand_templates_remove_nowiki' => 'Іґноровати в резултатї значкы <nowiki>',
	'expand_templates_generate_xml' => 'Указати сінтаксічный стром в XML',
	'expand_templates_preview' => 'Нагляд',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'expand_templates_output' => 'परिणामम्',
	'expand_templates_ok' => 'अस्तु',
	'expand_templates_preview' => 'प्राग्दृश्यम् दर्श्यताम्',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'expandtemplates' => 'Халыыптары тэнитии',
	'expandtemplates-desc' => 'Халыыптар тэнитиллиилэрэ',
	'expand_templates_intro' => 'Бу аналлаах сирэй тиэкиһи уларытарытарыгар туох баар халыыптары тэнитэн көрдөрөр.
Парсер функциялара эмиэ тэнитиллэллэр. Холобур, <nowiki>{{</nowiki>#if:...}} уонна переменнайдар <nowiki>{{</nowiki>CURRENTDAY}} уо.&nbsp;д.&nbsp;а. — уопсайынан, хос фигурнай скобка иһигэр баар барыта.
Бу дьайыы сыыһата суох, MediaWiki көмөтүнэн оҥоһуллар.',
	'expand_templates_title' => '{{FULLPAGENAME}} сирэй аата уонна да атын сибидиэнньэлэр:',
	'expand_templates_input' => 'Киирэр сурук:',
	'expand_templates_output' => 'Түмүк',
	'expand_templates_xml_output' => 'XML тахсыыта',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Ырытыылары сот',
	'expand_templates_remove_nowiki' => 'Түмүккэ <nowiki> бэлиэни аахсыма',
	'expand_templates_generate_xml' => 'XML-ы мас курдук көрдөр',
	'expand_templates_preview' => 'Инники көрүү',
);

/** Sardinian (Sardu)
 * @author Marzedu
 */
$messages['sc'] = array(
	'expand_templates_preview' => 'Antiprima',
);

/** Samogitian (Žemaitėška)
 * @author Hugo.arg
 */
$messages['sgs'] = array(
	'expandtemplates' => 'Ėšskeistė šabluonus',
);

/** Sinhala (සිංහල)
 * @author නන්දිමිතුරු
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'expandtemplates' => 'සැකිලි පුළුල් කරන්න',
	'expandtemplates-desc' => 'පුළුල් කල විකිපෙළ පෙන්වීම හා විදැහුනු පිටුව පෙරදසුන සඳහා [[Special:ExpandTemplates|සැකිලි, ව්‍යාකරණ විග්‍රහ ශ්‍රීතයන් හා විචල්‍යයන් පුළුල් කරයි ]]',
	'expand_templates_intro' => 'මෙම විශේෂ පිටුව විසින් යම් පෙළක්  ගෙන එහි සියළු සැකිලි ආවර්තනික ලෙස පුළුල් කරයි.
එය  <nowiki>{{</nowiki>#if:…}} වැනි ව්‍යාකරණ විග්‍රහ ශ්‍රිතයන් හා, 
<nowiki>{{</nowiki>CURRENTDAY}}වැනි විචල්‍යයන් ද&mdash; ඇත්ත වශයෙන්ම 
ද්විත්ව-සඟල වරහන් තුල හමුවන සැම දෙයක්ම පාහේ  පුළුල් කරයි.
එය විසින් මෙය සිදුකරනුයේ මාධයවිකි විසින්ම අදාල ව්‍යාකරණ විග්‍රහ අදියර ඇමතීමෙනි.',
	'expand_templates_title' => '{{FULLPAGENAME}} වැන්න සඳහා, ප්‍රකරණ ශීර්ෂය.:',
	'expand_templates_input' => 'ප්‍රදාන පෙළ:',
	'expand_templates_output' => 'ප්‍රතිඵලය',
	'expand_templates_xml_output' => 'XML ප්‍රතිදානය',
	'expand_templates_ok' => 'හරි',
	'expand_templates_remove_comments' => 'පරිකථනයන්  ඉවත්කරන්න',
	'expand_templates_remove_nowiki' => 'ප්‍රතිපලයෙහි <nowiki> ටැග යටපත් කරන්න',
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
	'expand_templates_title' => 'Názov kontextu pre {{FULLPAGENAME}} atď.:',
	'expand_templates_input' => 'Vstupný text:',
	'expand_templates_output' => 'Výsledok',
	'expand_templates_xml_output' => 'XML výstup',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Odstrániť komentáre',
	'expand_templates_remove_nowiki' => 'Potlačiť značky <nowiki> vo výsledku',
	'expand_templates_generate_xml' => 'Zobraziť strom XML',
	'expand_templates_preview' => 'Náhľad',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'expandtemplates' => 'Razširi predloge',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Razširi predloge, funkcije razčlenjevalnika in spremenljivke]] ter prikaže razširjeno wikibesedilo in predogled upodobljene strani',
	'expand_templates_intro' => 'Ta posebna stran vnešeno besedilo predela tako, da klice predlog v njem zamenja z njihovo vsebino.
Prav tako razreši izraze kot
<nowiki>{{</nowiki>#if:...}} in spremenljivke kot
<nowiki>{{</nowiki>CURRENTDAY}} – pravzaprav skoraj vse v dvojnih zavitih oklepajih.
Deluje s pomočjo razčlenjevalnika kode iz samega programja MediaWiki.',
	'expand_templates_title' => 'Naslov sobesedila, za {{FULLPAGENAME}} ipd.:',
	'expand_templates_input' => 'Vhodno besedilo:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'Izhod XML',
	'expand_templates_ok' => 'V redu',
	'expand_templates_remove_comments' => 'Odstrani komentarje',
	'expand_templates_remove_nowiki' => 'V rezultatu odstrani oznake <nowiki>',
	'expand_templates_generate_xml' => 'Pokaži razčlenitveno drevo XML',
	'expand_templates_preview' => 'Predogled',
);

/** Albanian (Shqip) */
$messages['sq'] = array(
	'expandtemplates' => 'Parapamje stampash',
	'expand_templates_intro' => 'Kjo faqe speciale merr tekstin me stampa dhe të tregon se si do të duket teksti pasi të jenë stamposur të tëra. Kjo faqe gjithashtu tregon parapamjen e funksioneve dhe fjalëve magjike si p.sh. <nowiki>{{</nowiki>#if:...}} dhe <nowiki>{{</nowiki>CURRENTDAY}}.',
	'expand_templates_title' => 'Titulli i faqes për rrethanën, si <nowiki>{{</nowiki>FULLPAGENAME}} etj.:',
	'expand_templates_input' => 'Teksti me stampa:',
	'expand_templates_output' => 'Parapamja',
	'expand_templates_ok' => 'Shko',
	'expand_templates_remove_comments' => 'Hiq komentet',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'expandtemplates' => 'Замена шаблона',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Проширује шаблоне, рашчлањивачке функције и променљиве]] за приказ проширеног викитекста и преглед исцртане слике',
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
	'expand_templates_remove_nowiki' => 'Поништава ефекат <nowiki> тагова у приказу чланака',
	'expand_templates_generate_xml' => 'прикажи XML стабло',
	'expand_templates_preview' => 'Приказ',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Liangent
 * @author Michaello
 */
$messages['sr-el'] = array(
	'expandtemplates' => 'Zamena šablona',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Razvija šablone, parser-funkcije i promenljive]] kako bi pokazao razvijeni vikitekst i pregled prikazivane strane',
	'expand_templates_intro' => 'Ova posebna stranica uzima neki tekst i menja sve šablone u njemu rekurzivno.
Takođe menja funkcije parsera kao što je <nowiki>{{</nowiki>#if:...}}, i promenljive kao što je
<nowiki>{{</nowiki>TRENUTNIDAN}}&mdash;zapravo praktično sve što se nalazi između vitičastih zagrada.
Do ovoga dolazi tako što se zove odgovarajuće stanje parsera iz samog MedijaVikija.',
	'expand_templates_title' => 'Naziv konteksta; za <nowiki>{{</nowiki>STRANICA}} itd.:',
	'expand_templates_input' => 'Unos:',
	'expand_templates_output' => 'Rezultat',
	'expand_templates_xml_output' => 'XML izlaz',
	'expand_templates_ok' => 'U redu',
	'expand_templates_remove_comments' => 'Ukloni komentare',
	'expand_templates_remove_nowiki' => 'Poništava efekat <nowiki> tagova u prikazu članaka',
	'expand_templates_generate_xml' => 'prikaži XML stablo',
	'expand_templates_preview' => 'Prikaz',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'expandtemplates' => 'Foarloagen expandierje',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expandiert Foarloagen, Parser-Funktione un Variablen]] toun fulboodigen Wikitext un wiest ju renderde Foarbekiek',
	'expand_templates_intro' => "In disse Spezialsiede kon Text ienroat wäide un aal Foarloagen in hier wäide rekursiv expandierd. Uk Parserfunktione as <nowiki>{{</nowiki>#if:...}} un Variabelen as <nowiki>{{</nowiki>CURRENTDAY}} wäide benutsed - faktisk alles wät twiske dubbelde swoangene Klammere '''{{}}''' stoant. Dit geböärt truch dän Aproup fon apstuunse Parser-Phasen in MediaWiki.",
	'expand_templates_title' => 'Kontexttittel, foar {{FULLPAGENAME}} etc.:',
	'expand_templates_input' => 'Iengoawefäild:',
	'expand_templates_output' => 'Resultoat',
	'expand_templates_xml_output' => 'XML-Uutgoawe',
	'expand_templates_ok' => 'Uutfiere',
	'expand_templates_remove_comments' => 'Kommentoare wächhoalje',
	'expand_templates_generate_xml' => 'Wies XML Parser-Boom',
	'expand_templates_preview' => 'Foarskau',
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
 * @author Per
 */
$messages['sv'] = array(
	'expandtemplates' => 'Expandera mallar',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Expanderar]] mallar, parserfunktioner och variabler till wikikod och förhandsvisar den sida som renderas',
	'expand_templates_intro' => 'Den här specialsidan tar en text och expanderar rekursivt alla mallar som används. Även parserfunktioner (som <nowiki>{{</nowiki>#if:...}}), variabler som <nowiki>{{</nowiki>CURRENTDAY}} och annan kod med dubbla klammerparenteser expanderas.',
	'expand_templates_title' => 'Sidans titel, används för t.ex. {{FULLPAGENAME}}:',
	'expand_templates_input' => 'Text som ska expanderas:',
	'expand_templates_output' => 'Expanderad kod',
	'expand_templates_xml_output' => 'XML-kod',
	'expand_templates_ok' => 'Expandera',
	'expand_templates_remove_comments' => 'Ta bort kommentarer',
	'expand_templates_remove_nowiki' => 'Undertryck <nowiki> taggar i resultatet',
	'expand_templates_generate_xml' => 'Visa parseträd som XML',
	'expand_templates_preview' => 'Förhandsvisning',
);

/** Swahili (Kiswahili) */
$messages['sw'] = array(
	'expand_templates_ok' => 'Sawa',
	'expand_templates_preview' => 'Hakiki',
);

/** Silesian (Ślůnski)
 * @author Herr Kriss
 */
$messages['szl'] = array(
	'expand_templates_ok' => 'OK',
);

/** Tamil (தமிழ்)
 * @author TRYPPN
 */
$messages['ta'] = array(
	'expand_templates_output' => 'முடிவுகள்',
	'expand_templates_ok' => 'ஆம்',
	'expand_templates_preview' => 'முன்தோற்றம்',
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
	'expand_templates_title' => '{{FULLPAGENAME}} మొదలగు వాటి కొరకు సందర్భ శీర్షిక:',
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

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'expandtemplates' => 'Бастдодани шаблонҳо',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Шаблонҳо, дастурҳои таҷзеҳкунанда ва мутағйирҳоро густариш медиҳад]], то матни ниҳоиро намоиш диҳад ва саҳифаро ба пешнамоиш дароварад',
	'expand_templates_intro' => 'Ин саҳифаи вижа матнеро дарёфт карда ва тамоми шаблонҳои ба кор рафта дар онро ба таври бозгаште баст медиҳад. Ҳамчунин тобеҳои таҷзеҳ
<nowiki>{{</nowiki>#if:...}}, ва мутағйирҳое чун
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;ро ҳам баст медиҳад – дар воқеъ тақрибан ҳар чиро ки дохили ду акулот бошад.
Ин кор бо садо задани марҳилаи таҷзеҳи марбут дар худи МедиаВики сурат мегирад.',
	'expand_templates_title' => 'Унвони мавзӯъ, барои {{FULLPAGENAME}} ва ғайра.:',
	'expand_templates_input' => 'Матни вурудӣ:',
	'expand_templates_output' => 'Натиҷа',
	'expand_templates_xml_output' => 'Хуруҷӣ XML',
	'expand_templates_ok' => 'Таъйид',
	'expand_templates_remove_comments' => 'Ҳазфи тавзеҳот',
	'expand_templates_generate_xml' => 'Намоиши дарахти таҷзеҳи XML',
	'expand_templates_preview' => 'Пешнамоиш',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'expandtemplates' => 'Bastdodani şablonho',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Şablonho, dasturhoi taçzehkunanda va mutaƣjirhoro gustariş medihad]], to matni nihoiro namoiş dihad va sahifaro ba peşnamoiş darovarad',
	'expand_templates_intro' => "In sahifai viƶa matnero darjoft karda va tamomi şablonhoi ba kor rafta dar onro ba tavri bozgaşte bast medihad. Hamcunin tobehoi taçzeh
<nowiki>{{</nowiki>#if:...}}, va mutaƣjirhoe cun
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;ro ham bast medihad – dar voqe' taqriban har ciro ki doxili du akulot boşad.
In kor bo sado zadani marhilai taçzehi marbut dar xudi MediaViki surat megirad.",
	'expand_templates_title' => "Unvoni mavzū', baroi {{FULLPAGENAME}} va ƣajra.:",
	'expand_templates_input' => 'Matni vurudī:',
	'expand_templates_output' => 'Natiça',
	'expand_templates_xml_output' => 'Xuruçī XML',
	'expand_templates_ok' => "Ta'jid",
	'expand_templates_remove_comments' => 'Hazfi tavzehot',
	'expand_templates_generate_xml' => 'Namoişi daraxti taçzehi XML',
	'expand_templates_preview' => 'Peşnamoiş',
);

/** Thai (ไทย)
 * @author Ans
 * @author Octahedron80
 */
$messages['th'] = array(
	'expand_templates_ok' => 'ตกลง',
	'expand_templates_preview' => 'ตัวอย่างผลแสดง',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'expandtemplates' => 'Şablonlary giňelt',
	'expandtemplates-desc' => 'Giňeldilen wikiteksti görkezmek we işlenilen sahypany deslapky synlamak üçin [[Special:ExpandTemplates|şablonlary, parser funksiýalaryny we üýtgeýänleri giňeldýär]]',
	'expand_templates_intro' => 'Bu ýörite sahypa birazajyk tekst alýar we onuň içindäki ähli şablonlary rekursiw giňeldýär.
Şeýlede şu hili parser funksiýalaryny hem giňeldýär
<nowiki>{{</nowiki>#if:…}} we şuňa meňzeş üýtgeýänleri
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;aslynda jübüt ýaýly ähli zatlary diýen ýaly.
Ol muny degişli parser sepgidini MediaWikiniň özünden çagyryp edýär.',
	'expand_templates_title' => 'Kontekst ady, {{FULLPAGENAME}} we ş.m. üçin:',
	'expand_templates_input' => 'Giriş teksti:',
	'expand_templates_output' => 'Netije',
	'expand_templates_xml_output' => 'XML önümi',
	'expand_templates_ok' => 'Bolýar',
	'expand_templates_remove_comments' => 'Teswirleri aýyr',
	'expand_templates_remove_nowiki' => 'Netijelerde <nowiki> teglerini bökdäň',
	'expand_templates_generate_xml' => 'XML ýygnama agajyny görkez',
	'expand_templates_preview' => 'Deslapky syn',
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
	'expand_templates_title' => 'Pamagat na pampaunawa (ng konteksto), para sa {{FULLPAGENAME}} atbp.:',
	'expand_templates_input' => 'Tekstong ipinasok:',
	'expand_templates_output' => 'Kinalabasan',
	'expand_templates_xml_output' => 'kinalabasang XML',
	'expand_templates_ok' => "Sige/Ayos 'yan",
	'expand_templates_remove_comments' => 'Tanggalin ang mga puna (kumento)',
	'expand_templates_remove_nowiki' => 'Pigilin ang mga tatak na <nowiki> sa loob ng resulta',
	'expand_templates_generate_xml' => 'Ipakita ang puno na pambanghay ng XML',
	'expand_templates_preview' => 'Paunang tingin',
);

/** Tongan (lea faka-Tonga) */
$messages['to'] = array(
	'expandtemplates' => 'Fakalahiange ʻa e ngaahi sīpinga',
);

/** Tok Pisin (Tok Pisin)
 * @author Iketsi
 */
$messages['tpi'] = array(
	'expand_templates_ok' => 'OK',
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
<nowiki>{{</nowiki>CURRENTDAY}}&mdash;aslında çift-bağlı hemen her şey.
Bunu, ilgili derleyici aşamasını MedyaVikinin kendisinden çağırarak yapar.',
	'expand_templates_title' => 'Durum başlığı, ör {{FULLPAGENAME}} için.:',
	'expand_templates_input' => 'Giriş metni:',
	'expand_templates_output' => 'Sonuç',
	'expand_templates_xml_output' => 'XML üretim',
	'expand_templates_ok' => 'Tamam',
	'expand_templates_remove_comments' => 'Yorumları sil',
	'expand_templates_remove_nowiki' => 'Sonuçlarda <nowiki> etiketlerini bastır',
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

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'expandtemplates' => 'Үрнәкләрне ачу',
	'expand_templates_ok' => 'OK',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'expand_templates_ok' => 'ماقۇل',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'expand_templates_ok' => 'Maqul',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author NickK
 * @author Prima klasy4na
 */
$messages['uk'] = array(
	'expandtemplates' => 'Розгортання шаблонів',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Розгортає шаблони, функції парсера і змінні]], щоб показати розгорнутий вікі-текст і попередній перегляд сторінки',
	'expand_templates_intro' => 'Ця спеціальна сторінка перетворює текст, рекурсивно розгортаючи всі шаблони в ньому.
Також розгортаються всі функції парсера
(наприклад <nowiki>{{</nowiki>#if:...}}) і змінні
(наприклад <nowiki>{{</nowiki>CURRENTDAY}}) — загалом, усе всередині подвійних фігурних дужок.
Це відбувається коректним чином з викликом відповідного обробника MediaWiki.',
	'expand_templates_title' => 'Заголовок сторінки для {{FULLPAGENAME}} тощо:',
	'expand_templates_input' => 'Вхідний текст:',
	'expand_templates_output' => 'Результат',
	'expand_templates_xml_output' => 'XML-вивід',
	'expand_templates_ok' => 'Гаразд',
	'expand_templates_remove_comments' => 'Вилучити коментарі',
	'expand_templates_remove_nowiki' => 'Ігнорувати теги <nowiki> в результаті',
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
	'expand_templates_title' => 'Contesto (par {{FULLPAGENAME}} ecc.):',
	'expand_templates_input' => 'Testo da espàndar:',
	'expand_templates_output' => 'Risultato',
	'expand_templates_xml_output' => 'Output in formato XML',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => 'Ignora i comenti',
	'expand_templates_remove_nowiki' => 'Cava i tag <nowiki> dal risultato',
	'expand_templates_generate_xml' => 'Mostra àlbaro sintàtico XML',
	'expand_templates_preview' => 'Anteprima',
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

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'expandtemplates' => 'Bung bản mẫu',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|Mở rộng các bản mẫu, hàm cú pháp, và biến]] thành mã wiki cuối cùng và hiển thị trang dùng mã này',
	'expand_templates_intro' => 'Trang đặc biệt này sẽ nhận vào một đoạn văn bản và bung tất cả các bản mẫu trong nó ra một cách đệ quy cho đến hết. Nó cũng bung cả những hàm cú pháp như <nowiki>{{</nowiki>#if:…}}, và những biến số như <nowiki>{{</nowiki>CURRENTDAY}}&nbsp;– thực ra cũng là các dữ liệu bình thường đặt trong ngoặc móc. Nó thực hiện điều này bằng cách gọi tầng dịch cú pháp từ chính MediaWiki.',
	'expand_templates_title' => 'Tên của trang văn cảnh (để phân tích {{FULLPAGENAME}} v.v.):',
	'expand_templates_input' => 'Mã nguồn để bung:',
	'expand_templates_output' => 'Kết quả',
	'expand_templates_xml_output' => 'Xuất XML',
	'expand_templates_ok' => 'Bung',
	'expand_templates_remove_comments' => 'Bỏ các chú thích',
	'expand_templates_remove_nowiki' => 'Bỏ qua thẻ <nowiki> trong kết quả',
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
	'expand_templates_title' => 'Yumedatiäd, pro {{FULLPAGENAME}} e r.:',
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
	'expandtemplates' => 'פרואוו מוסטערן',
	'expand_templates_input' => 'אײַנגעבן טעקסט',
	'expand_templates_output' => 'רעזולטאט',
	'expand_templates_xml_output' => 'XML אויסגאָב',
	'expand_templates_ok' => 'אויספֿירן',
	'expand_templates_preview' => 'פֿאראויסשטעלונג',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'expandtemplates' => '展開模',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展開模、parser functions同埋變數]]去顯示展開嘅wiki文字同埋預覽處理後嘅版',
	'expand_templates_intro' => '呢個特別頁係用於將一啲文字中嘅模展開，包括響個模度引用嘅模。同時亦都展開解譯器函數好似<nowiki>{{</nowiki>#if:...}}，以及一啲變數好似<nowiki>{{</nowiki>CURRENTDAY}}&mdash;實際上，幾乎所有響雙括弧中嘅內容都會被展開。呢個特別頁係通過使用MediaWiki嘅相關解釋階段嘅功能完成嘅。',
	'expand_templates_title' => '內容標題，用於 {{FULLPAGENAME}} 等頁面：',
	'expand_templates_input' => '輸入文字：',
	'expand_templates_output' => '結果：',
	'expand_templates_xml_output' => 'XML輸出',
	'expand_templates_ok' => 'OK',
	'expand_templates_remove_comments' => '拎走注釋',
	'expand_templates_generate_xml' => '顯示XML語法樹',
	'expand_templates_preview' => '預覽',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'expandtemplates' => '展开模板',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展开模板、解析器函数和变量]]，以显示展开后的wiki文本并预览处理后的页面',
	'expand_templates_intro' => '此特殊页面可以递归地展开所给文本中的模板。它同时还可展开诸如<nowiki>{{</nowiki>#if:...}}的解析器函数、诸如<nowiki>{{</nowiki>CURRENTDAY}}的变量——实际上，几乎所有在双重花括号中的内容都会被展开。本特殊页面的功能是通过调用MediaWiki的相关解析步骤实现的。',
	'expand_templates_title' => '上下文标题，用于{{FULLPAGENAME}}等：',
	'expand_templates_input' => '输入文本：',
	'expand_templates_output' => '结果：',
	'expand_templates_xml_output' => 'XML输出',
	'expand_templates_ok' => '确定',
	'expand_templates_remove_comments' => '移除注释',
	'expand_templates_remove_nowiki' => '在结果中隐藏<nowiki>标签',
	'expand_templates_generate_xml' => '显示XML语法树',
	'expand_templates_preview' => '预览',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Liangent
 * @author PhiLiP
 */
$messages['zh-hant'] = array(
	'expandtemplates' => '展開模板',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展開模板、模版擴展語法以及變數]]去顯示展開之wiki文字和預覽處理後之頁面',
	'expand_templates_intro' => '本特殊頁面用於將一些文字中的模版展開，包括模版中引用的模版。同時也展開解譯器函數如<nowiki>{{</nowiki>#if:...}}，以及變數如<nowiki>{{</nowiki>CURRENTDAY}}&mdash;實際上，幾乎所有在雙括弧中的內容都被展開。本特殊頁面是通過使用MediaWiki的相關解釋階段的功能完成的。',
	'expand_templates_title' => '上下文標題，用於 {{FULLPAGENAME}} 等：',
	'expand_templates_input' => '輸入文字：',
	'expand_templates_output' => '結果：',
	'expand_templates_xml_output' => 'XML輸出',
	'expand_templates_ok' => '確定',
	'expand_templates_remove_comments' => '移除注釋',
	'expand_templates_remove_nowiki' => '在結果中隱藏<nowiki>標記',
	'expand_templates_generate_xml' => '顯示XML語法樹',
	'expand_templates_preview' => '預覽',
);

/** Chinese (Taiwan) (‪中文(台灣)‬)
 * @author Pbdragonwang
 */
$messages['zh-tw'] = array(
	'expandtemplates' => '展開模板',
	'expandtemplates-desc' => '[[Special:ExpandTemplates|展開模板、模版擴展語法以及變數]]去顯示展開之wiki文字和預覽處理後之頁面',
	'expand_templates_intro' => '本特殊頁面用於將一些文字中的模版展開，包括模版中引用的模版。同時也展開解譯器函數如<nowiki> {{</nowiki>#if:...}}，以及變數如<nowiki>{{< /nowiki>CURRENTDAY}}&mdash;實際上，幾乎所有在雙括弧中的內容都被展開。本特殊頁面是通過使用 MediaWiki的相關解釋階段的功能完成的。',
	'expand_templates_title' => '上下文標題，用於 {{FULLPAGENAME}} 等：',
	'expand_templates_input' => '輸入文字：',
	'expand_templates_output' => '結果：',
	'expand_templates_xml_output' => 'XML輸出',
	'expand_templates_ok' => '確定',
	'expand_templates_remove_comments' => '移除註釋',
	'expand_templates_remove_nowiki' => '在結果中隱藏<nowiki>標記',
	'expand_templates_generate_xml' => '顯示XML解析樹',
	'expand_templates_preview' => '預覽',
);

