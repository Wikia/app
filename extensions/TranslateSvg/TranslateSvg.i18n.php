<?php
/**
 * Internationalisation for TranslateSVG extension
 *
 * @file
 * @ingroup Extensions
 */
 
$messages = array();

/** English
 * @author jarry1250
 */
$messages['en'] = array(
	'translatesvg'         => 'TranslateSVG', //Ignore
	'translatesvg-desc'    => 'Provides a native-style interface for translating SVGs in line with the SVG1.1 specification',
	'translatesvg-legend'  => 'File path',
	'translatesvg-page'    => 'File:',
	'translatesvg-submit'  => 'Go',
	'translatesvg-summary' => 'This special page allows you to add, remove and modify translations embedded within a given SVG image file.',
	'translatesvg-add'     => 'If your language is not listed already, you can [[#addlanguage|add it]].',
	'translatesvg-xcoordinate-pre' => 'X-coordinate (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Y-coordinate (vertical):',
	'translatesvg-specify' => 'Specify new language code (e.g. en, fr, de, es, ...)',
	'translatesvg-fallbackdesc' => 'Default (no language specified)',
	'translatesvg-qqqdesc' => 'Advice to translators',
	'translatesvg-nodesc'  => '(no description)',
	'translatesvg-remove'  => 'Remove all translations in this language',
	'translatesvg-unsuccessful'    => "This file '''could not be translated''', sorry.",
	'translatesvg-toggle-view'     => 'View translations in this language',
	'translatesvg-toggle-hide'     => 'Hide translations in this language'
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author jarry1250
 */
$messages['qqq'] = array(
	'translatesvg-desc' => '{{desc}}',
	'translatesvg-legend' => 'Form legend; general description of the purposes of the form (to ask for a file path)',
	'translatesvg-page' => 'Label for a form input.
{{Identical|File}}',
	'translatesvg-submit' => 'Text of a button to progress onto next stage of the translation.
{{Identical|Go}}',
	'translatesvg-summary' => 'General description of the special page, displayed at the top of it so users know what they are looking at',
	'translatesvg-add' => 'Introduction sentence available to JavaScript-enabled users including a link to add translations in a new language. The anchor (#addlanguage) does not need translation.',
	'translatesvg-xcoordinate-pre' => 'Label for a form input for the adjustment of the X-coordinate (horizontal position) of the text being translated',
	'translatesvg-ycoordinate-pre' => 'Label for a form input for the adjustment of the Y-coordinate (vertical position) of the text being translated',
	'translatesvg-specify' => 'Prompt asking for the two or three letter code (or similar) of the language they wish to translate into',
	'translatesvg-fallbackdesc' => 'The heading of the section that contains translations representing the fallback (default) language. The fallback language is used when translations aren\'t available. Comparable to other language headings such as "English", "Deutsch", etc.',
	'translatesvg-qqqdesc' => 'The heading of the section that contains descriptions of the context of each translation (i.e. translations into the language with code "qqq"). Comparable to other language headings such as "English", "Deutsch", etc.',
	'translatesvg-nodesc' => 'The text that appears next to a translation when no description (translation into language qqq) exists.',
	'translatesvg-remove' => 'Tooltip for a link attached to each translation language group which remove all form elements relating to the language group it is attached to',
	'translatesvg-unsuccessful' => 'A very general error message (bold and italics may be used to draw attention to it)',
	'translatesvg-toggle-view' => 'A toggle label; clicking on it causes extra form elements to appear',
	'translatesvg-toggle-hide' => 'A toggle label; clicking on it causes form elements to disappear',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'translatesvg-desc' => "Ufre una interfaz d'estilu nativu pa traducir en llinia ficheros SVG cola especificación SVG1.1.",
	'translatesvg-legend' => 'Camín al ficheru',
	'translatesvg-page' => 'Ficheru:',
	'translatesvg-submit' => 'Dir',
	'translatesvg-summary' => "Esta páxina especial te permite amestar, desaniciar y camudar les traducciones inxertaes nun ficheru d'imaxe SVG determináu.",
	'translatesvg-add' => 'Si la to llingua inda nun apaez na llista, pues [[#addlanguage|amestala]].',
	'translatesvg-xcoordinate-pre' => 'Coordenada X (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Coordenada Y (vertical):',
	'translatesvg-specify' => "Conseña'l códigu de la nueva llingua (p. ex. en, fr, de, es,...)",
	'translatesvg-fallbackdesc' => 'Predeterminada (nun se conseñó la llingua)',
	'translatesvg-qqqdesc' => 'Conseyu pa traductores',
	'translatesvg-nodesc' => '(ensin descripción)',
	'translatesvg-remove' => 'Desaniciar toles traducciones a esta llingua',
	'translatesvg-unsuccessful' => "Esti ficheru '''nun se pue traducir''', sentímoslo.",
	'translatesvg-toggle-view' => 'Ver les traducciones a esta llingua',
	'translatesvg-toggle-hide' => 'Anubrir les traducciones a esta llingua',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'translatesvg-desc' => 'Надае інтэрфэйс для перакладу SVG-файлаў, узгодненых са спэцыфікацыяй SVG1.1',
	'translatesvg-legend' => 'Шлях да файла',
	'translatesvg-page' => 'Файл:',
	'translatesvg-submit' => 'Пачаць',
	'translatesvg-summary' => 'Гэтая спэцыяльная старонка дазваляе дадаваць, рэдагаваць і выдаляць пераклады, убудаваныя ў дадзены SVG-файл.',
	'translatesvg-add' => 'Калі Вашая мова ня зьмешчаная ў сьпісе, Вы можаце [[#addlanguage|дадаць яе]].',
	'translatesvg-xcoordinate-pre' => 'X-каардыната (па гарызанталі):',
	'translatesvg-ycoordinate-pre' => 'Y-каардыната (па вэртыкалі):',
	'translatesvg-specify' => 'Пазначце новы код мовы (напрыклад: en, fr, de, be, …)',
	'translatesvg-fallbackdesc' => 'Па змоўчваньні (мова не пазначаная)',
	'translatesvg-qqqdesc' => 'Парада перакладчыкам',
	'translatesvg-nodesc' => '(апісаньня няма)',
	'translatesvg-remove' => 'Выдаліць усе пераклады на гэтай мове',
	'translatesvg-unsuccessful' => "Прабачце, гэты '''файл ня можа быць перакладзены'''.",
	'translatesvg-toggle-view' => 'Паказаць пераклады на гэтую мову',
	'translatesvg-toggle-hide' => 'Схаваць пераклады на гэтую мову',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'translatesvg-legend' => 'Hent moned ur restr',
	'translatesvg-page' => 'Restr :',
	'translatesvg-submit' => 'Mont',
	'translatesvg-add' => "Ma ne vez ket ho yezh er roll c'hoazh e c'hellit [[#addlanguage|ouzhpennañ anezhi]].",
	'translatesvg-xcoordinate-pre' => 'Daveenn X (a-led) :',
	'translatesvg-ycoordinate-pre' => 'Daveenn Y (a-serzh)',
	'translatesvg-specify' => "Spisait ar c'hod yezh nevez (da sk. br, en, fr, de, es...)",
	'translatesvg-fallbackdesc' => 'Dre ziouer (yezh spisaet ebet)',
	'translatesvg-qqqdesc' => "Kuzul d'an droerien",
	'translatesvg-nodesc' => '(deskrivadur ebet)',
	'translatesvg-remove' => 'Dilemel an holl droidigezhioù er yezh-se.',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'translatesvg-desc' => 'Ergänzt eine Spezialseite mit der SVG-Dateien in Einklang mit den SVG1.1-Spezifikationen übersetzt werden können',
	'translatesvg-legend' => 'Dateipfad',
	'translatesvg-page' => 'Datei:',
	'translatesvg-submit' => 'Ausführen',
	'translatesvg-summary' => 'Diese Spezialseite ermöglicht das Hinzufügen, Entfernen und Modifizieren von in SVG-Dateien eingebetteten Übersetzungen.',
	'translatesvg-add' => 'Sofern deine Sprache nicht bereits hier aufgeführt ist, kannst du sie [[#addlanguage|hinzufügen]].',
	'translatesvg-xcoordinate-pre' => 'X-Koordinate (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Y-Koordinate (vertikal):',
	'translatesvg-specify' => 'Einen neuen Sprachcode angeben (z. B. de, en, es, fr …)',
	'translatesvg-fallbackdesc' => 'Standard (keine Sprache ist angegeben)',
	'translatesvg-qqqdesc' => 'Ratschläge für Übersetzer',
	'translatesvg-nodesc' => '(keine Beschreibung)',
	'translatesvg-remove' => 'Alle Übersetzungen in dieser Sprache entfernen',
	'translatesvg-unsuccessful' => "Diese Datei konnte leider '''nicht''' übersetzt werden.",
	'translatesvg-toggle-view' => 'Alle Übersetzungen in dieser Sprache ansehen',
	'translatesvg-toggle-hide' => 'Alle Übersetzungen in dieser Sprache ausblenden',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'translatesvg-add' => 'Sofern Ihre Sprache nicht bereits hier aufgeführt ist, können Sie sie [[#addlanguage|hinzufügen]].',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'translatesvg-desc' => 'Stoj pówjerch za pśełožowanje SVG-datajow pó specifikaciji SVG1.1 k dispoziciji',
	'translatesvg-legend' => 'Datajowy puśik',
	'translatesvg-page' => 'Dataja:',
	'translatesvg-submit' => 'Wótpósłaś',
	'translatesvg-summary' => 'Toś ten specialny bok śi zmóžnja, psełožki pśidaś, wópóraś a změniś, kótarež su w danej SVG-dataji zasajźone.',
	'translatesvg-add' => 'Jolic twója rěc hyšći njejo pódana, móžoš ju [[#addlanguage|pśidaś]].',
	'translatesvg-xcoordinate-pre' => 'X-coordinate (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Y-koordinata (wertikalny):',
	'translatesvg-specify' => 'Nowy rěcny code pódaś (na př.  dsb,  de, en, fr, es ...)',
	'translatesvg-fallbackdesc' => 'Standard (žedna rěc pódana)',
	'translatesvg-qqqdesc' => 'Rady za pśełožowarjow',
	'translatesvg-nodesc' => '(žedno wopisanje)',
	'translatesvg-remove' => 'Wšykne pśełožki w toś tej rěcy wótpóraś',
	'translatesvg-unsuccessful' => "Toś ta dataja '''njedajo se''' bóžko pśełožowas.",
	'translatesvg-toggle-view' => 'Pśełožki  w toś tej rěcy pokazaś',
	'translatesvg-toggle-hide' => 'Pśełožki  w toś tej rěcy schowaś',
);

/** Finnish (Suomi)
 * @author Crt
 */
$messages['fi'] = array(
	'translatesvg-submit' => 'Siirry',
);

/** French (Français)
 * @author Gomoko
 * @author Od1n
 */
$messages['fr'] = array(
	'translatesvg-desc' => 'Fournit une interface de style natif pour traduire les SVGs en ligne conformément à la spécification SVG1.1',
	'translatesvg-legend' => 'Chemin du fichier',
	'translatesvg-page' => 'Fichier :',
	'translatesvg-submit' => 'Suivant',
	'translatesvg-summary' => "Cette page spéciale vous permet d'ajouter, supprimer et modifier les traductions intégrées dans un fichier d'image SVG donné.",
	'translatesvg-add' => "Si votre langue n'est pas déjà répertoriée, vous pouvez [[#addlanguage|l'ajouter]].",
	'translatesvg-xcoordinate-pre' => 'Coordonnée X (horizontal) :',
	'translatesvg-ycoordinate-pre' => 'Coordonnée Y (vertical) :',
	'translatesvg-specify' => 'Spécifiez le nouveau code de langue (par ex. en, fr, de, es,...)',
	'translatesvg-fallbackdesc' => 'Par défaut (aucune langue spécifiée)',
	'translatesvg-qqqdesc' => 'Conseil aux traducteurs',
	'translatesvg-nodesc' => '(aucune description)',
	'translatesvg-remove' => 'Supprimer toutes les traductions dans cette langue.',
	'translatesvg-unsuccessful' => "Ce fichier '''n’a pas pu être traduit''', désolé.",
	'translatesvg-toggle-view' => 'Voir les traductions dans cette langue',
	'translatesvg-toggle-hide' => 'Cacher les traductions dans cette langue',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'translatesvg-desc' => 'Proporciona unha inteface de estilo nativa para a tradución de ficheiros SVG en liña coa especificación SVG1.1.',
	'translatesvg-legend' => 'Ruta do ficheiro',
	'translatesvg-page' => 'Ficheiro:',
	'translatesvg-submit' => 'Ir',
	'translatesvg-summary' => 'Esta páxina especial permite engadir, eliminar e modificar as traducións incluídas no ficheiro de imaxe SVG especificado.',
	'translatesvg-add' => 'Se a súa lingua aínda non aparece na lista pode [[#addlanguage|engadila]].',
	'translatesvg-xcoordinate-pre' => 'Coordenada X (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Coordenada Y (vertical):',
	'translatesvg-specify' => 'Especifique o código da nova lingua (por exemplo: en, fr, de, es...)',
	'translatesvg-fallbackdesc' => 'Predeterminado (sen especificación de lingua)',
	'translatesvg-qqqdesc' => 'Consello para os tradutores',
	'translatesvg-nodesc' => '(sen descrición)',
	'translatesvg-remove' => 'Eliminar todas as traducións nesta lingua',
	'translatesvg-unsuccessful' => "Sentímolo, este ficheiro '''non se pode traducir'''.",
	'translatesvg-toggle-view' => 'Ollar todas as traducións nesta lingua',
	'translatesvg-toggle-hide' => 'Agochar todas as traducións nesta lingua',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'translatesvg-desc' => 'מתן ממשק ילידי לתרגום קובצי SVG בהתאם לתקן SVG1.1',
	'translatesvg-legend' => 'נתיב לקובץ',
	'translatesvg-page' => 'קובץ:',
	'translatesvg-submit' => 'קדימה',
	'translatesvg-summary' => 'הדף המיוחד הזה מאפשר לך להוסיף, להסיר ולשנות תרגומים ש מוטמעים בקובץ SVG.',
	'translatesvg-add' => 'עם שפתך אינה רשומה כבר, אפשר [[#addlanguage|להוסיף אותה]].',
	'translatesvg-xcoordinate-pre' => 'נקודה על ציר X (אופקי):',
	'translatesvg-ycoordinate-pre' => 'נקודה על ציר Y (אנכי):',
	'translatesvg-specify' => 'קוד השפה החדשה (למשל en‏, fr‏, es‏, he...)',
	'translatesvg-fallbackdesc' => 'בררת מחדל (ללא הגדרת שפה)',
	'translatesvg-qqqdesc' => 'עצות למתרגמים',
	'translatesvg-nodesc' => '(אין תיאור)',
	'translatesvg-remove' => 'הסרת כל התרגומים לשפה הזאת',
	'translatesvg-unsuccessful' => "'''לא התאפשר לתרגם את הקובץ הזה''', סליחה.",
	'translatesvg-toggle-view' => 'הצגת התרגומים לשפה הזאת',
	'translatesvg-toggle-hide' => 'הסתרת התרגומים לשפה הזאת',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'translatesvg-desc' => 'Steji powjerch za přełožowanje SVG-datajow po specifikaciji SVG1.1 k dispoziciji',
	'translatesvg-legend' => 'Datajowy pućik',
	'translatesvg-page' => 'Dataja:',
	'translatesvg-submit' => 'Wotpósłać',
	'translatesvg-summary' => 'Tuta specialna strona ći zmóžnja, přełožki přidać, wotstronić a změnić, kotrež su w datej SVG-dataji zasadźene.',
	'translatesvg-add' => 'Jeli twoja rěč hišće njeje podata, móžeš ju [[#addlanguage|přidać]].',
	'translatesvg-xcoordinate-pre' => 'X-koordinata (horicontalny):',
	'translatesvg-ycoordinate-pre' => 'Y-koordinata (wertikalny):',
	'translatesvg-specify' => 'Nowy rěčny kod podać (na př.  hsb,  de, en, fr, es ...)',
	'translatesvg-fallbackdesc' => 'Standard (žana rěč podata)',
	'translatesvg-qqqdesc' => 'Rady za přełožowarjow',
	'translatesvg-nodesc' => '(žane wopisanje)',
	'translatesvg-remove' => 'Wšě přełožki w tutej rěči wotstronić',
	'translatesvg-unsuccessful' => "Tuta dataja '''njeda so''' bohužel přełožować.",
	'translatesvg-toggle-view' => 'Přełožki  w tutej rěči pokazać',
	'translatesvg-toggle-hide' => 'Přełožki  w tutej rěči schować',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'translatesvg-desc' => 'Forni un interfacie in stilo native pro traducer SVGs de maniera conforme al specification SVG1.1',
	'translatesvg-legend' => 'Cammino del file',
	'translatesvg-page' => 'File:',
	'translatesvg-submit' => 'Va',
	'translatesvg-summary' => 'Iste pagina special permitte adder, remover e modificar traductiones incorporate in un file de imagine SVG.',
	'translatesvg-add' => 'Si tu lingua non es jam listate, tu pote [[#addlanguage|adder lo]].',
	'translatesvg-xcoordinate-pre' => 'Coordinata X (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Coordinata Y (vertical):',
	'translatesvg-specify' => 'Specifica un nove codice de lingua (p.ex. ia, fr, de, es, ...)',
	'translatesvg-fallbackdesc' => 'Predefinition (nulle lingua specificate)',
	'translatesvg-qqqdesc' => 'Consilio al traductores',
	'translatesvg-nodesc' => '(sin description)',
	'translatesvg-remove' => 'Remover tote le traductiones in iste lingua',
	'translatesvg-unsuccessful' => "Iste file '''non poteva esser traducite''', regrettabilemente.",
	'translatesvg-toggle-view' => 'Vider le traductiones in iste lingua',
	'translatesvg-toggle-hide' => 'Celar le traductiones in iste lingua',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'translatesvg-desc' => 'SVG 1.1 규격에 따라 SVG 파일을 번역하는 인터페이스를 제공',
	'translatesvg-legend' => '파일 경로',
	'translatesvg-page' => '파일:',
	'translatesvg-submit' => '확인',
	'translatesvg-summary' => '이 특수 문서에서 SVG 파일에 포함된 문자열의 번역을 추가, 제거, 수정할 수 있습니다.',
	'translatesvg-add' => '당신이 쓰는 언어가 나열되어 있지 않다면 [[#addlanguage|추가]]할 수 있습니다.',
	'translatesvg-xcoordinate-pre' => 'X좌표 (가로):',
	'translatesvg-ycoordinate-pre' => 'Y좌표 (세로):',
	'translatesvg-specify' => '새 언어 코드를 입력하세요 (예시: en, fr, de, es, ko ...)',
	'translatesvg-fallbackdesc' => '기본값 (언어 설정 없음)',
	'translatesvg-qqqdesc' => '번역자에 대한 조언',
	'translatesvg-nodesc' => '(설명 없음)',
	'translatesvg-remove' => '이 언어로 된 모든 번역 제거하기',
	'translatesvg-unsuccessful' => "이 파일은 '''번역할 수 없습니다''', 죄송합니다.",
	'translatesvg-toggle-view' => '이 언어로 된 번역 보기',
	'translatesvg-toggle-hide' => '이 언어로 된 번역 숨기기',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'translatesvg-legend' => 'Pad bei de Fichier',
	'translatesvg-page' => 'Fichier:',
	'translatesvg-submit' => 'Lass',
	'translatesvg-summary' => "Dës Spezialsäit erlaabt et fir Iwwersetzungen déi an SVG-Dateien integréiert sinn derbäizesetzen, ewechzehuelen an z'änneren.",
	'translatesvg-add' => 'Wann Är Sprooch net schonn an der Lëscht dran ass, kënnt Dir se [[#addlanguage|derbäisetzen]].',
	'translatesvg-xcoordinate-pre' => 'X-Koordinat (horizontal):',
	'translatesvg-ycoordinate-pre' => 'Y-Koordinat (vertikal):',
	'translatesvg-specify' => 'En neie Sproochcode uginn (z. Bsp. en, fr, de, es, fr, ...)',
	'translatesvg-fallbackdesc' => 'Standard (keng Sprooch ass spezifizéiert)',
	'translatesvg-qqqdesc' => 'Tuyau fir Iwwersetzer',
	'translatesvg-nodesc' => '(keng Beschreiwung)',
	'translatesvg-remove' => 'All Iwwersetzungen an dëser Sprooch ewechhuelen',
	'translatesvg-unsuccessful' => "Dëse Fichier '''konnt net iwwersat ginn''', sorry.",
	'translatesvg-toggle-view' => 'Iwwersetzungen an dëser Sprooch weisen',
	'translatesvg-toggle-hide' => 'Iwwersetzungen an dëser Sprooch verstoppen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'translatesvg-desc' => 'Дава поредник за преведување на SVG податотеки во склад со одредбите на SVG1.1',
	'translatesvg-legend' => 'Патека на податотеката',
	'translatesvg-page' => 'Податотека:',
	'translatesvg-submit' => 'Оди',
	'translatesvg-summary' => 'Оваа специјална страница ви овозможува да додавате, отстранувате и менувате преводи на содржините на SVG слики.',
	'translatesvg-add' => 'Ако го нема вашиот јазик, тогаш [[#addlanguage|додајте го]].',
	'translatesvg-xcoordinate-pre' => 'X-координата (хоризонтално):',
	'translatesvg-ycoordinate-pre' => 'Y-координата (вертикално):',
	'translatesvg-specify' => 'Внесете нов јазичен код (на пр. mk, en, fr, de...)',
	'translatesvg-fallbackdesc' => 'По основно (неукажан јазик)',
	'translatesvg-qqqdesc' => 'Совет за преведувачите',
	'translatesvg-nodesc' => '(нема опис)',
	'translatesvg-remove' => 'Отстрани ги сите преводи на овој јазик',
	'translatesvg-unsuccessful' => "Нажалост, податотекава '''не можеше да се преведе'''.",
	'translatesvg-toggle-view' => 'Прикажи преводи на овој јазик',
	'translatesvg-toggle-hide' => 'Скриј преводи на овој јазик',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'translatesvg-desc' => 'Menyediakan antaramuka bergaya natif untuk menterjemah SVG sejajar dengan tentuan SVG1.1',
	'translatesvg-legend' => 'Laluan fail',
	'translatesvg-page' => 'Fail:',
	'translatesvg-submit' => 'Pergi',
	'translatesvg-summary' => 'Laman khas ini membolehkan anda untuk menambahkan, membuang dan mengubahsuai terjemahan yang terbenam dalam fail imeg SVG yang tertentu.',
	'translatesvg-add' => 'Jika bahasa anda belum disenaraikan, anda boleh [[#addlanguage|menambahkannya]].',
	'translatesvg-xcoordinate-pre' => 'Koordinat X (melintang):',
	'translatesvg-ycoordinate-pre' => 'Koordinat Y (menegak):',
	'translatesvg-specify' => 'Nyatakan kod bahasa baru (cth. ms, en, zh, ta, ...)',
	'translatesvg-fallbackdesc' => 'Asali (tiada bahasa dinyatakan)',
	'translatesvg-qqqdesc' => 'Nasihat kepada para penterjemah',
	'translatesvg-nodesc' => '(tiada keterangan)',
	'translatesvg-remove' => 'Buang semua terjemahan dalam bahasa ini',
	'translatesvg-unsuccessful' => "Maaf, fail ini '''tidak boleh diterjemah'''.",
	'translatesvg-toggle-view' => 'Lihat terjemahan dalam bahasa ini',
	'translatesvg-toggle-hide' => 'Sorokkan terjemahan dalam bahasa ini',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'translatesvg-desc' => 'Biedt een interface voor het vertalen van SVG-bestanden in het bestand zelf volgens de SVG1.1-specificatie',
	'translatesvg-legend' => 'Bestandslocatie',
	'translatesvg-page' => 'Bestand:',
	'translatesvg-submit' => 'OK',
	'translatesvg-summary' => 'Via deze speciale pagina kunt u vertalingen in een SVG-afbeeldingsbestand toevoegen, verwijderen en aanpassen.',
	'translatesvg-add' => 'Als uw taal niet al in de lijst voorkomt, dan kunt u deze [[#addlanguage|toevoegen]].',
	'translatesvg-xcoordinate-pre' => 'X-coördinaat (horizontaal):',
	'translatesvg-ycoordinate-pre' => 'Y-coördinaat (verticaal):',
	'translatesvg-specify' => 'Geef de code van de nieuwe taal op (bijvoorbeeld: nl, en, fr, de, es, ...)',
	'translatesvg-fallbackdesc' => 'Standaard (geen taal opgegeven)',
	'translatesvg-qqqdesc' => 'Advies aan vertalers',
	'translatesvg-nodesc' => '(geen beschrijving)',
	'translatesvg-remove' => 'Alle vertalingen in deze taal verwijderen',
	'translatesvg-unsuccessful' => 'Dit bestand kan niet vertaald worden.',
	'translatesvg-toggle-view' => 'Vertalingen in deze taal bekijken',
	'translatesvg-toggle-hide' => 'Vertalen in deze taal verbergen',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'translatesvg-submit' => 'వెళ్ళు',
	'translatesvg-nodesc' => '(వివరణ లేదు)',
);

/** Ukrainian (Українська)
 * @author A1
 */
$messages['uk'] = array(
	'translatesvg-nodesc' => '(немає опису)',
);

