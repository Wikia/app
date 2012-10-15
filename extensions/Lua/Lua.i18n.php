<?php
/**
 * Lua parser extensions for MediaWiki - Internationalization
 *
 * @author Fran Rogers
 * @ingroup Extensions
 * @license See 'COPYING'
 * @file
 */

$messages = array();

$messages['en'] = array(
	'lua_desc'               => 'Extends the parser with support for embedded blocks of [http://www.lua.org/ Lua] code',
	'lua_error'              => 'Error on line $1',
	'lua_extension_notfound' => 'Lua extension not configured',
	'lua_interp_notfound'    => 'Lua interpreter not found',
	'lua_error_internal'     => 'Internal error',
	'lua_overflow_recursion' => 'Recursion limit reached',
	'lua_overflow_loc'       => 'Maximum lines of code limit reached',
	'lua_overflow_time'      => 'Maximum execution time reached',
);

/** Message documentation (Message documentation)
 * @author McDutchie
 * @author Purodha
 * @author The Evil IP address
 */
$messages['qqq'] = array(
	'lua_desc' => '{{desc}}',
	'lua_error_internal' => '{{Identical|Internal error}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'lua_error_internal' => 'Interne fout',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'lua_desc' => 'يمدد المحلل بدعم لقطع مضمنة من كود [http://www.lua.org/ Lua]',
	'lua_error' => 'خطأ في السطر $1',
	'lua_extension_notfound' => 'امتداد لوا ليس مضبوطا',
	'lua_interp_notfound' => 'مفسر لوا لم يتم العثور عليه',
	'lua_error_internal' => 'خطأ داخلي',
	'lua_overflow_recursion' => 'تم الوصول إلى حد التكرار',
	'lua_overflow_loc' => 'تم الوصول إلى الحد الأقصى لسطور الكود',
	'lua_overflow_time' => 'تم الوصول إلى أقصى زمن للتنفيذ',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'lua_error_internal' => 'ܦܘܕܐ ܓܘܝܐ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'lua_desc' => 'يمدد المحلل بدعم لقطع مضمنة من كود [http://www.lua.org/ Lua]',
	'lua_error' => 'خطأ فى السطر $1',
	'lua_extension_notfound' => 'امتداد لوا ليس مضبوطا',
	'lua_interp_notfound' => 'مفسر لوا لم يتم العثور عليه',
	'lua_error_internal' => 'خطأ داخلي',
	'lua_overflow_recursion' => 'تم الوصول إلى حد التكرار',
	'lua_overflow_loc' => 'تم الوصول إلى الحد الأقصى لسطور الكود',
	'lua_overflow_time' => 'تم الوصول إلى أقصى زمن للتنفيذ',
);

/** Asturian (Asturianu)
 * @author Esbardu
 */
$messages['ast'] = array(
	'lua_desc' => "Espande l'análisis sintáuticu con soporte pa bloques incrustaos de códigu [http://www.lua.org/ Lua]",
	'lua_error' => 'Error na llinia $1',
	'lua_extension_notfound' => 'Estensión Lua non configurada',
	'lua_interp_notfound' => 'Intérprete Lua non atopáu',
	'lua_error_internal' => 'Error internu',
	'lua_overflow_recursion' => "Algamáu'l llímite de recursión",
	'lua_overflow_loc' => "Algamáu'l llímite máximu de llinies de códigu",
	'lua_overflow_time' => "Algamáu'l máximu tiempu d'execución",
);

/** Bavarian (Boarisch)
 * @author Man77
 */
$messages['bar'] = array(
	'lua_error_internal' => 'Inteana Fehla',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'lua_desc' => 'Пашырае парсэр падтрымкай убудаваных блёкаў коду [http://www.lua.org/ Lua]',
	'lua_error' => 'Памылка ў радку $1',
	'lua_extension_notfound' => 'Пашырэньне Lua не сканфігураванае',
	'lua_interp_notfound' => 'Інтэрпрэтатар Lua ня знойдзены',
	'lua_error_internal' => 'Унутраная памылка',
	'lua_overflow_recursion' => 'Дасягнуты ліміт рэкурсіўных выклікаў',
	'lua_overflow_loc' => 'Дасягнуты максымальны ліміт колькасьці радкоў у кодзе',
	'lua_overflow_time' => 'Дасягнуты максымальны час выкананьня',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'lua_error' => 'Грешка на ред $1',
	'lua_error_internal' => 'Вътрешна грешка',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'lua_error' => 'লাইন $1-এ ত্রুটি',
	'lua_extension_notfound' => 'লুয়া এক্সটেনশন কনফিগার করা হয়নি',
	'lua_interp_notfound' => 'লুয়া ইন্টারপ্রেটার খুঁজে পাওয়া যায়নি',
	'lua_error_internal' => 'অভ্যন্তরীণ ত্রুটি',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'lua_desc' => "Astenn a ra ar parser a-benn skoriñ bloc'hadennoù enframmet ar c'hod [http://www.lua.org/ Lua]",
	'lua_error' => 'Fazi el linenn $1',
	'lua_extension_notfound' => "N'eo ket kefluniet an astenn Lua",
	'lua_interp_notfound' => "N'eo ket bet kavet dielfenner Lua",
	'lua_error_internal' => 'Fazi diabarzh',
	'lua_overflow_recursion' => 'Bevenn ar rekursadur tizhet',
	'lua_overflow_loc' => 'Niver brasañ a linennoù kod tizhet',
	'lua_overflow_time' => 'Pad erounit hirañ tizhet',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'lua_desc' => 'Proširuje parser sa podrškom za umetnute blokove [http://www.lua.org/ Lua] koda',
	'lua_error' => 'Greška na liniji $1',
	'lua_extension_notfound' => 'Lua ekstenzija nije podešena',
	'lua_interp_notfound' => 'Lua prevodioc nije pronađen',
	'lua_error_internal' => 'Unutrašnja greška',
	'lua_overflow_recursion' => 'Ograničenje broja rekurzija je dostignuto',
	'lua_overflow_loc' => 'Ograničenje maksimuma linija koda je dostignuto',
	'lua_overflow_time' => 'Dostignuto maksimalno vrijeme izvršenja',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'lua_error_internal' => 'Error intern',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'lua_desc' => 'Rozšiřuje syntaktický analyzátor o možnost vkládání bloků kódu v jazyce [http://www.lua.org/ Lua]',
	'lua_error' => 'Chyba na řádku $1',
	'lua_extension_notfound' => 'Rozšíření Lua není nakonfigurováno',
	'lua_interp_notfound' => 'Nebyl nalezen překladač Lua',
	'lua_error_internal' => 'Vnitřní chyba',
	'lua_overflow_recursion' => 'Byl dosáhnut limit rekurze',
	'lua_overflow_loc' => 'Byl dosáhnut limit počtu řádků kódu',
	'lua_overflow_time' => 'Byl dosáhnut limit času běhu',
);

/** German (Deutsch)
 * @author Leithian
 * @author Melancholie
 * @author Revolus
 */
$messages['de'] = array(
	'lua_desc' => 'Erweitert den Parser mit einer Unterstützung für eingebettete Blöcke des [http://www.lua.org/ Lua]-Codes',
	'lua_error' => 'Fehler in Zeile $1',
	'lua_extension_notfound' => 'Lua-Erweiterung nicht konfiguriert',
	'lua_interp_notfound' => 'Lua-Interpreter nicht gefunden',
	'lua_error_internal' => 'Interner Fehler',
	'lua_overflow_recursion' => 'Maximale Anzahl von Rekursionen erreicht',
	'lua_overflow_loc' => 'Maximale Zeilenanzahl an Code erreicht',
	'lua_overflow_time' => 'Maximale Ausführungsdauer erreicht',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'lua_desc' => 'Rozšyrja parser wó pódpěru za zapśěgnjone kodowe bloki [http://www.lua.org/ Lua]',
	'lua_error' => 'Zmólka w smužce $1',
	'lua_extension_notfound' => 'Rozšyrjenje LUa njekonfiguěrowane',
	'lua_interp_notfound' => 'Interpreter Lua njenamakany',
	'lua_error_internal' => 'Interna zmólka',
	'lua_overflow_recursion' => 'Limit rekursijow dostany',
	'lua_overflow_loc' => 'Limit smužkow koda dostany',
	'lua_overflow_time' => 'Maksimalny cas wuwjeźenja dostany',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'lua_desc' => 'Επεκτείνει τον λεξιαναλυτή με υποστήριξη ενσωματωμένων πλοκάδων του κώδικα [http://www.lua.org/ Lua]',
	'lua_error' => 'Σφάλμα στη γραμμή $1',
	'lua_extension_notfound' => 'Η επέκταση Lua δεν διαμορφώθηκε',
	'lua_interp_notfound' => 'Ο διερμηνέας Lua δεν βρέθηκε',
	'lua_error_internal' => 'Εσωτερικό σφάλμα',
	'lua_overflow_recursion' => 'Φτάσατε στο όριο αναδρομής',
	'lua_overflow_loc' => 'Φτάσατε στο μέγιστο όριο γραμμών κώδικα',
	'lua_overflow_time' => 'Φτάσατε στο μέγιστο όριο εκτέλεσης',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'lua_desc' => 'Etendas la sintaksan analizilon kun subteno por internaj forbaroj de kodo [http://www.lua.org/ Lua]',
	'lua_error' => 'Eraro en linio $1',
	'lua_extension_notfound' => 'Etendilo Lua ne estas konfigurata',
	'lua_interp_notfound' => 'Interpretilo Lua ne estas trovita',
	'lua_error_internal' => 'Interna eraro',
	'lua_overflow_recursion' => 'Limo de rekursio atingis',
	'lua_overflow_loc' => 'Limo de maksimumaj linioj de kodo atingis',
	'lua_overflow_time' => 'Atingis maksimuma tempo de operaciado',
);

/** Spanish (Español)
 * @author Crazymadlover
 */
$messages['es'] = array(
	'lua_desc' => 'Extiende el analizador con soporte para bloques empotrados de código [http://www.lua.org/ Lua]',
	'lua_error' => 'Error en línea $1',
	'lua_extension_notfound' => 'Extensión Lua no configurada',
	'lua_interp_notfound' => 'Intérprete Lua no encontrado',
	'lua_error_internal' => 'Error interno',
	'lua_overflow_recursion' => 'Límite de recurso alcanzado',
	'lua_overflow_loc' => 'Límite máximo de líneas de código alcanzada',
	'lua_overflow_time' => 'Tiempo de ejecución máximo alcanzado',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'lua_error' => 'Errorea $1. lerroan',
	'lua_error_internal' => 'Barneko errorea',
);

/** Finnish (Suomi)
 * @author Mobe
 * @author Nike
 */
$messages['fi'] = array(
	'lua_desc' => 'Lisää jäsentimeen tuen upotetuille [http://www.lua.org/ Lua]-ohjelmalohkoille.',
	'lua_error' => 'Virhe rivillä $1',
	'lua_extension_notfound' => 'Lua-laajennuksen asetuksia ei ole tehty.',
	'lua_interp_notfound' => 'Lua-tulkkia ei löydy.',
	'lua_error_internal' => 'Sisäinen virhe',
	'lua_overflow_recursion' => 'Rekursion enimmäissyvyys saavutettu',
	'lua_overflow_loc' => 'Ohjelmarivien enimmäismäärä saavutettu',
	'lua_overflow_time' => 'Suorituksen enimmäiskesto saavutettu',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'lua_desc' => 'Étend le parseur avec le support pour les plages comprises du code [http://www.lua.org/ Lua]',
	'lua_error' => 'Erreur dans la ligne $1',
	'lua_extension_notfound' => 'Extension Lua non configurée',
	'lua_interp_notfound' => 'Interpréteur Lua introuvable',
	'lua_error_internal' => 'Erreur interne',
	'lua_overflow_recursion' => 'Limite de la récursion atteinte',
	'lua_overflow_loc' => 'Nombre maximal des lignes de code atteint',
	'lua_overflow_time' => 'Durée maximale d’exécution atteinte',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'lua_error' => 'Èrror dens la legne $1',
	'lua_extension_notfound' => 'Èxtension Lua pas configurâ',
	'lua_interp_notfound' => 'Entèrprètor Lua entrovâblo',
	'lua_error_internal' => 'Èrror de dedens',
	'lua_overflow_recursion' => 'Limita de la rècursion avengiê',
);

/** Western Frisian (Frysk)
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'lua_error_internal' => 'Ynterne fout',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'lua_error' => 'Earráid ar líne $1',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'lua_desc' => 'Extende as funcións analíticas con apoio para bloques embebidos de código [http://www.lua.org/ Lua]',
	'lua_error' => 'Erro na liña $1',
	'lua_extension_notfound' => 'Non está configurada a extensión Lua',
	'lua_interp_notfound' => 'Non se atopou o intérprete Lua',
	'lua_error_internal' => 'Erro interno',
	'lua_overflow_recursion' => 'Alcanzouse o límite do recurso',
	'lua_overflow_loc' => 'Alcanzáronse os límites das liñas de código',
	'lua_overflow_time' => 'Alcanzouse o tempo máximo de execución',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'lua_error_internal' => 'Ἐσώτερον σφάλμα',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'lua_desc' => 'Erwyteret dr Parser mit ere Unterstitzig fir yybetteti Bleck vum [http://www.lua.org/ Lua]-Code',
	'lua_error' => 'Fähler in dr Zyyle $1',
	'lua_extension_notfound' => 'Lua-Erwyterig nit konfiguriert',
	'lua_interp_notfound' => 'Lua-Interpreter nit gfunde',
	'lua_error_internal' => 'Intärne Fähler',
	'lua_overflow_recursion' => 'An di maximal Aazahl vu Rekursione chu',
	'lua_overflow_loc' => 'An di maximal Zyylenaazahl vum Code chu',
	'lua_overflow_time' => 'An di maximal Uusfierigsduur chu',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'lua_desc' => 'הרחבת המפענח לתמיכה במקטעים של קוד [http://www.lua.org/ Lua]',
	'lua_error' => 'שגיאה בשורה $1',
	'lua_extension_notfound' => 'הרחבת ה־Lua לא מוגדרת',
	'lua_interp_notfound' => 'מנוע הפירוש של Lua לא נמצא',
	'lua_error_internal' => 'שגיאה פנימית',
	'lua_overflow_recursion' => 'מגבלת הרקורסיה הושגה',
	'lua_overflow_loc' => 'מגבלת מספר שורות הקוד המירבי הושגה',
	'lua_overflow_time' => 'זמן הריצה המרבי הושג',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'lua_desc' => 'Rozšěrja parser wo podpěru za zapřijate bloki koda [http://www.lua.org/ Lua]',
	'lua_error' => 'Zmylk w lince $1',
	'lua_extension_notfound' => 'Rozšěrjenje Lux njekonfigurowane',
	'lua_interp_notfound' => 'Interpreter Lua njenamakany',
	'lua_error_internal' => 'Interny zmylk',
	'lua_overflow_recursion' => 'Limit rekursije docpěty',
	'lua_overflow_loc' => 'Maksimalne linki kodoweho limita docpěte',
	'lua_overflow_time' => 'Maksimalny čas wuwjedźenja docpěty',
);

/** Hungarian (Magyar)
 * @author Dani
 */
$messages['hu'] = array(
	'lua_desc' => 'Kiegészíti a szövegértelmezőt [http://www.lua.org/ Lua] kódok futtatási lehetőségével',
	'lua_error' => 'Hiba a(z) $1. sorban',
	'lua_extension_notfound' => 'A Lua kiegészítő nincs beállítva',
	'lua_interp_notfound' => 'A Lua értelmező nem található',
	'lua_error_internal' => 'Belső hiba',
	'lua_overflow_recursion' => 'Rekurziós korlát túllépve',
	'lua_overflow_loc' => 'A maximális sorok száma túllépve',
	'lua_overflow_time' => 'Maximális futtatási idő túllépve',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'lua_desc' => 'Extende le analysator syntactic con supporto pro le insertion de blocos a codice [http://www.lua.org/ Lua]',
	'lua_error' => 'Error in linea $1',
	'lua_extension_notfound' => 'Extension Lua non configurate',
	'lua_interp_notfound' => 'Interpretator Lua non trovate',
	'lua_error_internal' => 'Error interne',
	'lua_overflow_recursion' => 'Limite de recursion excedite',
	'lua_overflow_loc' => 'Numero maxime de lineas de codice excedite',
	'lua_overflow_time' => 'Durata maxime de execution excedite',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 */
$messages['id'] = array(
	'lua_desc' => 'Perkaya parser dengan dukungan untuk kode [http://www.lua.org/ Lua]',
	'lua_error' => 'Kesalahan pada baris $1',
	'lua_extension_notfound' => 'Pengaya Lua belum dikonfigurasi',
	'lua_interp_notfound' => 'Interpretasi Lua tidak ditemukan',
	'lua_error_internal' => 'Kesalahan internal',
	'lua_overflow_recursion' => 'Batas rekursi telah dicapai',
	'lua_overflow_loc' => 'Batas jumlah baris kode telah dicapai',
	'lua_overflow_time' => 'Batas waktu eksekusi telah dicapai',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'lua_desc' => 'Estende il parser con il supporto per blocchi incorporati di codice [http://www.lua.org/ Lua]',
	'lua_error' => 'Errore nella linea $1',
	'lua_extension_notfound' => 'Estensione Lua non configurata',
	'lua_interp_notfound' => 'Interprete Lua non trovato',
	'lua_error_internal' => 'Errore interno',
	'lua_overflow_recursion' => 'Raggiunto il limite di ricorsione',
	'lua_overflow_loc' => 'Limite di numero massimo di righe di codice raggiunto',
	'lua_overflow_time' => 'Tempo massimo di esecuzione raggiunto',
);

/** Japanese (日本語)
 * @author Fryed-peach
 */
$messages['ja'] = array(
	'lua_desc' => 'パーサーを拡張し、[http://www.lua.org/ Lua] コードのブロックを埋め込めるようにする',
	'lua_error' => '行 $1 上のエラー',
	'lua_extension_notfound' => 'Lua 拡張機能は設定されていません',
	'lua_interp_notfound' => 'Lua インタプリタが見つかりません',
	'lua_error_internal' => '内部エラー',
	'lua_overflow_recursion' => '再帰制限に達しました',
	'lua_overflow_loc' => '最大行数制限に達しました',
	'lua_overflow_time' => '最大実行時間に達しました',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'lua_error' => 'កំហុស​នៅលើ​បន្ទាត់ $1',
	'lua_error_internal' => 'កំហុស​ខាងក្នុង',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'lua_desc' => 'Määt et müjjelesch en Sigge em Wiki Stöcker met [http://www.lua.org/ Lua] Projrämmscher enzeboue.',
	'lua_error' => 'Fähler em LUA op Reih Nommer $1',
	'lua_extension_notfound' => 'Der LUA Zosatz es nit reschtesch ennjestellt',
	'lua_interp_notfound' => 'Der LUA ingerpreeter es nit ze finge',
	'lua_error_internal' => 'Enne innere Fähler em LUA es opjetrodde',
	'lua_overflow_recursion' => 'Em LUA es de Jrenß fun de sellf-Oproofe övverschrette woode',
	'lua_overflow_loc' => 'De jrüüßte müjjelische Aanzahl Reihe met LUA-Projamm-Tex es övverschrette',
	'lua_overflow_time' => 'Dat LUA Projramm hät zo lang jedooht',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'lua_error' => 'Feeler an der Linn $1',
	'lua_extension_notfound' => 'Lua-Erweiderung net configuréiert',
	'lua_interp_notfound' => 'Lua-Interpreter net fonnt',
	'lua_error_internal' => 'Interne Feeler',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'lua_desc' => 'Додава поддршка во парсерот за вметнати блокови со [http://www.lua.org/ Lua] код',
	'lua_error' => 'Грешка на ред $1',
	'lua_extension_notfound' => 'Додатокот Lua не е поставен',
	'lua_interp_notfound' => 'Lua интерпретаторот не е пронајден',
	'lua_error_internal' => 'Внатрешна грешка',
	'lua_overflow_recursion' => 'Достигнато е ограничувањето за рекурзија',
	'lua_overflow_loc' => 'Достигната е максималниот број на редови код',
	'lua_overflow_time' => 'Достигнато е максималното време за извршување',
);

/** Burmese (မြန်မာဘာသာ)
 * @author Erikoo
 */
$messages['my'] = array(
	'lua_error_internal' => 'အတွင်းပိုင်းအမှား',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'lua_error' => 'Ahcuallōtl pāmpan $1',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['nb'] = array(
	'lua_desc' => 'Utvider fortolkeren med støtte for innvevde blokker av [http://lua.org/ Lua]-kode',
	'lua_error' => 'Feil på linje $1',
	'lua_extension_notfound' => 'Lua-utvidelsen ikke konfigurert',
	'lua_interp_notfound' => 'Lua-fortolker ikke funnet',
	'lua_error_internal' => 'Intern feil',
	'lua_overflow_recursion' => 'Rekursjonsgrense nådd',
	'lua_overflow_loc' => 'Maksimalt antall linjer med kode nådd',
	'lua_overflow_time' => 'Maksimal utførelsestid nådd',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'lua_desc' => 'Breidt de parser uit met ondersteuning voor ingebedde blokken [http://www.lua.org/ Lua]-code',
	'lua_error' => 'Fout in regel $1',
	'lua_extension_notfound' => 'De uitbreiding Lua is niet ingesteld',
	'lua_interp_notfound' => 'De Lua-interpreter is niet aangetroffen',
	'lua_error_internal' => 'Interne fout',
	'lua_overflow_recursion' => 'Recursiegrens bereikt',
	'lua_overflow_loc' => 'Limiet voor aantal regels code bereikt',
	'lua_overflow_time' => 'Maximale verwerkingstijd bereikt',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'lua_desc' => 'Utvider tolkaren med støtte for innvovne blokkar av [http://lua.org/ Lua]-kode',
	'lua_error' => 'Feil på linje $1',
	'lua_extension_notfound' => 'Lua-utvidinga er ikkje stillt inn',
	'lua_interp_notfound' => 'Lua-tolkaren ikkje funnen',
	'lua_error_internal' => 'Intern feil',
	'lua_overflow_recursion' => 'Rekursjonsgrensa nådd',
	'lua_overflow_loc' => 'Høgste tal på kodelinjer nådd',
	'lua_overflow_time' => 'Høgste utføringstid nådd',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'lua_desc' => 'Espandís lo parser amb lo supòrt per las plajas compresas del còde [http://www.lua.org/ Lua]',
	'lua_error' => 'Error dins la linha $1',
	'lua_extension_notfound' => 'Extension Lua pas configurada',
	'lua_interp_notfound' => 'Interpretador Lua introbable',
	'lua_error_internal' => 'Error intèrna',
	'lua_overflow_recursion' => 'Limit de la recursion atench',
	'lua_overflow_loc' => 'Nombre maximal de linhas de còde atench',
	'lua_overflow_time' => 'Durada maximala d’execucion atencha',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'lua_error_internal' => 'Мидæг рæдыд',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'lua_error_internal' => 'Interner Fehler',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'lua_desc' => 'Rozszerza analizator składni o wsparcie dla wbudowanych bloków skryptów w języku [http://www.lua.org/ Lua]',
	'lua_error' => 'Błąd w wierszu $1',
	'lua_extension_notfound' => 'Rozszerzenie Lua nie zostało skonfigurowane',
	'lua_interp_notfound' => 'Brak interpretera Lua',
	'lua_error_internal' => 'Błąd wewnętrzny',
	'lua_overflow_recursion' => 'Osiągnięto ograniczenie głębokości rekurencji',
	'lua_overflow_loc' => 'Osiągnięto maksymalną liczbę linii kodu',
	'lua_overflow_time' => 'Osiągnięto maksymalny czas wykonywania',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'lua_desc' => 'A estend ël parser con apògg për ij blòch antern dël còdes [http://www.lua.org/ Lua]',
	'lua_error' => 'Eror an sla linia $1',
	'lua_extension_notfound' => 'Estension Lua pa configurà',
	'lua_interp_notfound' => 'Anterprete Lua pa trovà',
	'lua_error_internal' => 'Eror antern',
	'lua_overflow_recursion' => 'Lìmit ëd ricursion rivà',
	'lua_overflow_loc' => 'Lìmit dël massim nùmer ëd linie ëd còdes rivà',
	'lua_overflow_time' => "Temp massim d'esecussion rivà",
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Malafaya
 */
$messages['pt'] = array(
	'lua_desc' => 'Acrescenta ao analisador sintáctico suporte para blocos incorporados de código [http://www.lua.org/ Lua]',
	'lua_error' => 'Erro na linha $1',
	'lua_extension_notfound' => 'Extensão Lua não configurada',
	'lua_interp_notfound' => 'Interpretador Lua não encontrado',
	'lua_error_internal' => 'Erro interno',
	'lua_overflow_recursion' => 'Limite de chamadas recursivas atingido',
	'lua_overflow_loc' => 'Limite máximo de linhas de código atingido',
	'lua_overflow_time' => 'Tempo máximo de execução atingido',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'lua_desc' => 'Estende o analisador (parser) com suporte para blocos incorporados de código [http://www.lua.org/ Lua]',
	'lua_error' => 'Erro na linha $1',
	'lua_extension_notfound' => 'Extensão Lua não configurada',
	'lua_interp_notfound' => 'Interpretador Lua não encontrado',
	'lua_error_internal' => 'Erro interno',
	'lua_overflow_recursion' => 'Limite de chamadas recursivas atingido',
	'lua_overflow_loc' => 'Limite máximo de linhas de código atingido',
	'lua_overflow_time' => 'Tempo máximo de execução atingido',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'lua_error' => 'Eroare la linia $1',
	'lua_extension_notfound' => 'Extensia Lua neconfigurată',
	'lua_interp_notfound' => 'Interpretor Lua negăsit',
	'lua_error_internal' => 'Eroare internă',
	'lua_overflow_recursion' => 'Limita de recursie a fost atinsă',
	'lua_overflow_loc' => 'Numărul maxim de linii de cod a fost atins',
	'lua_overflow_time' => 'Timpul maxim de execuție a fost atins',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'lua_desc' => "Estenne l'analizzatore cu 'u supporte pe blocche 'nzertate de codece [http://www.lua.org/ Lua]",
	'lua_error' => "Errore sus 'a linee $1",
	'lua_extension_notfound' => 'Le estenziune de Lua non ge sonde configurete',
	'lua_interp_notfound' => "L'interprete Lua non g'a state acchiete",
	'lua_error_internal' => 'Errore inderne',
	'lua_overflow_recursion' => 'Limite de ricorsione raggiunde',
	'lua_overflow_loc' => 'Numere massime de linèe de codece raggiunde',
	'lua_overflow_time' => 'Numere massime de vote de esecuzione raggiunde',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'lua_desc' => 'Добавляет в парсер поддержку блоков кода [http://www.lua.org/ Lua]',
	'lua_error' => 'Ошибка на линии $1',
	'lua_extension_notfound' => 'Расширение Lua не настроено',
	'lua_interp_notfound' => 'Интерпретатор Lua не найден',
	'lua_error_internal' => 'Внутренняя ошибка',
	'lua_overflow_recursion' => 'Достигнут предел рекурсии',
	'lua_overflow_loc' => 'Достигнут предел максимального числа строчек кода',
	'lua_overflow_time' => 'Достигнут предел максимального времени выполнения',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'lua_desc' => 'Rozširuje syntaktický analyzátor o podporu vložených blokov kódu v jazyku [http://www.lua.org/ Lua]',
	'lua_error' => 'Chyba na riadku $1',
	'lua_extension_notfound' => 'Rozšírenie Lua nie je nastavené',
	'lua_interp_notfound' => 'Nebol nájdený interpreter Lua',
	'lua_error_internal' => 'Vnútorná chyba',
	'lua_overflow_recursion' => 'Bol dosiahnutý limit rekurzie',
	'lua_overflow_loc' => 'Bol dosiahnutý limit počtu riadkov kódu',
	'lua_overflow_time' => 'Bol dosiahnutý limit času behu',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'lua_error_internal' => 'Унутрашња грешка',
	'lua_overflow_recursion' => 'Достигнут лимит за рекурзију',
	'lua_overflow_loc' => 'Достигнут максимални број линија кода',
	'lua_overflow_time' => 'Достигнуто максимално време извршења',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬) */
$messages['sr-el'] = array(
	'lua_error_internal' => 'Interna greška',
	'lua_overflow_recursion' => 'Dostignut limit za rekurziju',
	'lua_overflow_loc' => 'Dostignut maksimalni broj linija koda',
	'lua_overflow_time' => 'Dostignuto maksimalno vreme izvršenja',
);

/** Swedish (Svenska)
 * @author Fluff
 */
$messages['sv'] = array(
	'lua_desc' => 'Utökar tolken med stöd för inbäddade block av [http://www.lua.org/ Luakod]',
	'lua_error' => 'Fel på rad $1',
	'lua_extension_notfound' => 'Lua-tillägget ej konfigurerat',
	'lua_interp_notfound' => 'Hittade inte Lua-tolken',
	'lua_error_internal' => 'Internt fel',
	'lua_overflow_recursion' => 'Rekursionsgräns uppnådd',
	'lua_overflow_loc' => 'Maximalt antal kodrader uppnått',
	'lua_overflow_time' => 'Maximal exekveringstid uppnådd',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'lua_error_internal' => 'అంతర్గత పొరపాటు',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'lua_desc' => 'Nagpapalawig sa banghay na may suporta para sa nakabaong mga bloke ng kodigong [http://www.lua.org/ Lua]',
	'lua_error' => 'Kamalian sa guhit na $1',
	'lua_extension_notfound' => 'Hindi nakaayos ang karugtong na Lua',
	'lua_interp_notfound' => 'Hindi natagpuan ang pampaunawa ng Lua',
	'lua_error_internal' => 'Panloob na kamalian',
	'lua_overflow_recursion' => 'Naabot na ang hangganan ng pagtawag sa sarili',
	'lua_overflow_loc' => 'Naabot na ang pinakamataas na hangganan ng guhit ng kodigo',
	'lua_overflow_time' => 'Naabot na ang pinakamataas na panahon ng pagsasakatuparan',
);

/** Turkish (Türkçe)
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'lua_desc' => 'Ayrıştırıcıyı [http://www.lua.org/ Lua] kodunun yerleşik blok desteği ile genişletir',
	'lua_error' => '$1. satırda hata',
	'lua_extension_notfound' => 'Lua eklentisi konfigüre edildi',
	'lua_interp_notfound' => 'Lua yorumlayıcısı bulunamadı',
	'lua_error_internal' => 'Dahili hata',
	'lua_overflow_recursion' => 'Özyineleme sınırına ulaşıldı',
	'lua_overflow_loc' => 'Azami kod satırı sınırına ulaşıldı',
	'lua_overflow_time' => 'Azami yürütme süresine ulaşıldı',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'lua_desc' => 'Mở rộng bộ phân tích để hỗ trợ các khối mã [http://www.lua.org/ Lua]',
	'lua_error' => 'Lỗi dòng $1',
	'lua_extension_notfound' => 'Chưa thiết lập phần mở rộng Lua',
	'lua_interp_notfound' => 'Không tìm được bộ thông dịch Lua',
	'lua_error_internal' => 'Lỗi nội bộ',
	'lua_overflow_recursion' => 'Quá hạn chế đệ quy',
	'lua_overflow_loc' => 'Quá số dòng mã tối đa',
	'lua_overflow_time' => 'Quá thời gian chạy tối đa',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'lua_error_internal' => 'Pöl ninik',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'lua_desc' => '通过支持嵌入[http://www.lua.org/ Lua]代码段来扩展解析器。',
	'lua_error' => '第$1行有错误',
	'lua_extension_notfound' => '未配置Lua插件',
	'lua_interp_notfound' => '未找到Lua解释器',
	'lua_error_internal' => '内部错误',
	'lua_overflow_recursion' => '递归越限',
	'lua_overflow_loc' => '代码行数越限',
	'lua_overflow_time' => '运行时间越限',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author PhiLiP
 */
$messages['zh-hant'] = array(
	'lua_desc' => '透過支援嵌入 [http://www.lua.org/ Lua] 程式碼段來擴充套件解析器。',
	'lua_error' => '第 $1 行有錯誤',
	'lua_extension_notfound' => '未設定 Lua 擴充套件',
	'lua_interp_notfound' => '未找到 Lua 直譯器',
	'lua_error_internal' => '內部錯誤',
	'lua_overflow_recursion' => '遞回的極限',
	'lua_overflow_loc' => '程式碼行數的極限',
	'lua_overflow_time' => '達到最大的執行時間',
);

