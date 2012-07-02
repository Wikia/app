<?php
/**
 * Localization file for mwEmbedSupport
 */

$messages = array();

$messages['en'] = array(
	'mwe-loading' => 'Loading...',
	'mwe-size-gigabytes' => '$1 GB',
	'mwe-size-megabytes' => '$1 MB',
	'mwe-size-kilobytes' => '$1 K',
	'mwe-size-bytes' => '$1 B',
	'mwe-error_load_lib' => 'Error: JavaScript $1 was not retrievable or does not define $2',
	'mwe-apiproxy-setup' => 'Setting up API proxy',
	'mwe-load-drag-item' => 'Loading dragged item',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Cancel',
	'mwe-enable-gadget' => 'Enable multimedia beta (mwEmbed) for all pages',
	'mwe-enable-gadget-done' => 'Multimedia beta gadget has been enabled',
	'mwe-must-login-gadget' => 'To enable gadget you must <a target="_new" href="$1">login</a>',
	'mwe-test-plural' => 'I ran {{PLURAL:$1|$1 test|$1 tests}}',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Nike
 * @author Raymond
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'mwe-loading' => '{{Identical|Loading}}',
	'mwe-size-gigabytes' => '{{optional}}
Size (of a file, typically) in gibibytes (1 gibibyte = 1024×1024×1024 bytes).

See also:
* {{msg-mw|mwe-size-gigabytes}}
* {{msg-mw|mwe-size-megabytes}}
* {{msg-mw|mwe-size-kilobytes}}
* {{msg-mw|mwe-size-bytes}}

* {{msg-mw|size-gigabytes}}
* {{msg-mw|size-megabytes}}
* {{msg-mw|size-kilobytes}}
* {{msg-mw|size-bytes}}',
	'mwe-size-megabytes' => '{{optional}}

See also:
* {{msg-mw|mwe-size-gigabytes}}
* {{msg-mw|mwe-size-megabytes}}
* {{msg-mw|mwe-size-kilobytes}}
* {{msg-mw|mwe-size-bytes}}

* {{msg-mw|size-gigabytes}}
* {{msg-mw|size-megabytes}}
* {{msg-mw|size-kilobytes}}
* {{msg-mw|size-bytes}}',
	'mwe-size-kilobytes' => '{{optional}}

See also:
* {{msg-mw|mwe-size-gigabytes}}
* {{msg-mw|mwe-size-megabytes}}
* {{msg-mw|mwe-size-kilobytes}}
* {{msg-mw|mwe-size-bytes}}

* {{msg-mw|size-gigabytes}}
* {{msg-mw|size-megabytes}}
* {{msg-mw|size-kilobytes}}
* {{msg-mw|size-bytes}}',
	'mwe-size-bytes' => '{{optional}}

See also:
* {{msg-mw|mwe-size-gigabytes}}
* {{msg-mw|mwe-size-megabytes}}
* {{msg-mw|mwe-size-kilobytes}}
* {{msg-mw|mwe-size-bytes}}

* {{msg-mw|size-gigabytes}}
* {{msg-mw|size-megabytes}}
* {{msg-mw|size-kilobytes}}
* {{msg-mw|size-bytes}}',
	'mwe-error_load_lib' => 'Parameters:
* $1 Corresponds to the JavaScript file that was not retrievable or does not define its class name.
* $2 Is the class name that was associated with the JavaScript file that was not found or could not be retrieved.',
	'mwe-ok' => '{{Identical|OK}}',
	'mwe-cancel' => '{{Identical|Cancel}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'mwe-loading' => 'laai ...',
	'mwe-error_load_lib' => 'Fout: JavaScript $1 kon nie gevind word of definieer nie $2 nie',
	'mwe-apiproxy-setup' => "Besig met die opstel van 'n API-proxy",
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Kanselleer',
	'mwe-test-plural' => 'Ek het {{PLURAL:$1|$1 toets|$1 toetse}} uitgevoer',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'mwe-loading' => 'Loading ...',
	'mwe-error_load_lib' => 'Gabim: $1 JavaScript nuk ishte shikohen ose nuk define $2',
	'mwe-apiproxy-setup' => 'Ngritja proxy API',
	'mwe-load-drag-item' => 'Loading zvarritur artikull',
	'mwe-ok' => 'Në rregull',
	'mwe-cancel' => 'Anuloj',
	'mwe-enable-gadget' => 'Aktivizo multimedial beta (mwEmbed) për të gjitha faqet',
	'mwe-enable-gadget-done' => 'Multimedia beta vegël ka qenë i aktivizuar',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'mwe-cancel' => 'Cancelar',
);

/** Arabic (العربية)
 * @author Meno25
 * @author OsamaK
 */
$messages['ar'] = array(
	'mwe-loading' => 'يحمل...',
	'mwe-size-gigabytes' => '$1 جيجابايت',
	'mwe-size-megabytes' => '$1 ميجا بايت',
	'mwe-size-kilobytes' => '$1 كيلوبايت',
	'mwe-size-bytes' => '$1 بايت',
	'mwe-ok' => 'موافق',
	'mwe-cancel' => 'ألغِ',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 */
$messages['arc'] = array(
	'mwe-ok' => 'ܛܒ',
	'mwe-cancel' => 'ܒܛܘܠ',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 */
$messages['az'] = array(
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'İmtina',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Zedlik
 */
$messages['be-tarask'] = array(
	'mwe-loading' => 'загрузка …',
	'mwe-error_load_lib' => 'Памылка: JavaScript $1 не даступны альбо не вызначае $2',
	'mwe-apiproxy-setup' => 'Налада API-проксі',
	'mwe-load-drag-item' => 'Загрузка перанесенага элемэнту',
	'mwe-ok' => 'Добра',
	'mwe-cancel' => 'Адмяніць',
	'mwe-enable-gadget' => 'Уключыць бэта-мультымэдыя (mwEmbed) для ўсіх старонак',
	'mwe-enable-gadget-done' => 'Дапаўненьне бэта-мультымэтыя ўключанае',
	'mwe-must-login-gadget' => 'Для ўключэньня дапаўненьня Вам неабходна <a target="_new" href="$1">ўвайсьці ў сыстэму</a>',
	'mwe-test-plural' => 'Я прайшоў $1 {{PLURAL:$1|тэст|тэсты|тэстаў}}',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'mwe-loading' => 'Зареждане ...',
);

/** Bengali (বাংলা)
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'mwe-loading' => 'লোডিং ...',
	'mwe-apiproxy-setup' => 'এপিআই প্রক্সি সেট করা হচ্ছে',
	'mwe-ok' => 'ঠিক আছে',
	'mwe-cancel' => 'বাতিল',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'mwe-loading' => 'o kargañ...',
	'mwe-error_load_lib' => "Fazi : n'eo ket bet kavet JavaScript $1 pe n'eo ket termenet gant $2",
	'mwe-apiproxy-setup' => 'Kefluniadur ar proksi API',
	'mwe-load-drag-item' => 'O kargañ an elfenn digargañ',
	'mwe-ok' => 'Mat eo',
	'mwe-cancel' => 'Nullañ',
	'mwe-enable-gadget' => 'Gweredekaat liesvedia beta (mwEmbed) war an holl bajennoù',
	'mwe-enable-gadget-done' => 'Gweredekaet eo bet ar gadjet liesvedia beta',
	'mwe-must-login-gadget' => 'Evit gweredekaat ar gadjet e rankit <a target="_new" href="$1">kevreañ</a>',
	'mwe-test-plural' => 'Sevenet em eus $1 amprouadenn{{PLURAL:$1||}}',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'mwe-loading' => 'učitavam ...',
	'mwe-error_load_lib' => 'Greška: JavaScript $1 se ne može učitati ili nije definiran $2',
	'mwe-apiproxy-setup' => 'Postavljanje API proksija',
	'mwe-load-drag-item' => 'Učitavam povučenu stavku',
	'mwe-ok' => 'U redu',
	'mwe-cancel' => 'Odustani',
	'mwe-enable-gadget' => 'Omogući beta verziju multimedije (mwEmbed) za sve stranice',
	'mwe-enable-gadget-done' => 'Beta verzija multimedija dodatka je omogućena',
	'mwe-must-login-gadget' => 'Da omogućite dodatak morate biti <a target="_new" href="$1">prijavljeni</a>',
	'mwe-test-plural' => 'Pokrenuo sam {{PLURAL:$1|$1 provjeru|$1 provjere|$1 provjera}}',
);

/** Catalan (Català)
 * @author Toniher
 */
$messages['ca'] = array(
	'mwe-loading' => "S'està carregant...",
	'mwe-error_load_lib' => "Error: no s'ha pogut recuperar el JavaScript $1 o no defineix $2",
	'mwe-apiproxy-setup' => "S'està configurant l'intermediari de l'API",
	'mwe-load-drag-item' => "S'està carregant l'element arrossegat",
	'mwe-ok' => "D'acord",
	'mwe-cancel' => 'Cancel·la',
	'mwe-enable-gadget' => 'Habilita la beta multimèdia (mwEmbed) per a totes les pàgines',
	'mwe-enable-gadget-done' => "S'ha habilitat el giny multimèdia beta",
	'mwe-must-login-gadget' => 'Per habilitar el giny heu d\'<a target="_new" href="$1">iniciar una sessió</a>',
	'mwe-test-plural' => 'He executat {{PLURAL:$1|$1 test|$1 tests}}',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'mwe-loading' => 'Načítá se …',
	'mwe-cancel' => 'Storno',
);

/** Welsh (Cymraeg) */
$messages['cy'] = array(
	'mwe-loading' => "wrthi'n llwytho ...",
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'mwe-loading' => 'lade …',
	'mwe-error_load_lib' => 'Fehler: JavaScript $1 war nicht abrufbar oder lässt $2 nicht zu',
	'mwe-apiproxy-setup' => 'API-Proxy-Konfiguration',
	'mwe-load-drag-item' => 'Lade das verschobene Element',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Abbrechen',
	'mwe-enable-gadget' => 'Aktiviere die Beta-Version des Multimedia-Helferleins (mwEmbed) für alle Seiten',
	'mwe-enable-gadget-done' => 'Beta-Version des Multimedia-Helferleins wurde aktiviert',
	'mwe-must-login-gadget' => 'Um das Helferlein aktivieren zu können, musst du dich <a target="_new" href="$1">anmelden</a>',
	'mwe-test-plural' => '{{PLURAL:$1|$1 Test|$1 Tests}} durchlaufen',
);

/** Zazaki (Zazaki)
 * @author Aspar
 */
$messages['diq'] = array(
	'mwe-loading' => 'bar beno...',
	'mwe-error_load_lib' => 'xeta: $1 JavaScript re nêresiyeno ya zi pê $2yi şınasnaye niyo.',
	'mwe-apiproxy-setup' => 'proxyê APIyi eyar beno',
	'mwe-load-drag-item' => 'unsur bar beno',
	'mwe-ok' => 'temam',
	'mwe-cancel' => 'iptal',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'mwe-loading' => 'zacytujo se ...',
	'mwe-error_load_lib' => 'Zmólka: JavaScript $1 njejo wótwołujobny był abo njedefiněrujo $2',
	'mwe-apiproxy-setup' => 'Proksy API zarědowaś',
	'mwe-load-drag-item' => 'Wlecony zapisk se zacytujo',
	'mwe-ok' => 'W pórědku',
	'mwe-cancel' => 'Pśetergnuś',
	'mwe-enable-gadget' => 'Multimedia beta (mwEmbed) za wšykne boki zmóžniś',
	'mwe-enable-gadget-done' => 'Pśisłušk Multimedia beta jo se zmóžnił',
	'mwe-must-login-gadget' => 'Aby pśisłušk zmóžnił, musyš se <a target="_new" href="$1">pśizjawiś</a>',
	'mwe-test-plural' => 'Som {{PLURAL:$1|$1 test|$1 testa|$1 testy|$1 testow}} pśewjadł',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Evropi
 */
$messages['el'] = array(
	'mwe-loading' => 'φόρτωση ...',
	'mwe-apiproxy-setup' => 'Ρύθμιση του μεσολαβητή ΔΠΕ (API)',
	'mwe-load-drag-item' => 'Φόρτωση συρόμενου στοιχείου',
	'mwe-ok' => 'Εντάξει',
	'mwe-cancel' => 'Ακύρωση',
	'mwe-enable-gadget' => 'Ενεργοποίηση του beta για τα πολυμέσα (mwEmbed) για όλες τις σελίδες',
	'mwe-enable-gadget-done' => 'Ενεργοποιήθηκε η beta μικροεφαρμογή πολυμέσων',
	'mwe-must-login-gadget' => 'Για να ενεργοποιήσετε τη μικροεφαρμογή πρέπει να κάνετε <a target="_new" href="$1">είσοδο</a>',
	'mwe-test-plural' => 'Εκτέλεσα {{PLURAL:$1|$1 δοκιμή|$1 δοκιμές}}',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'mwe-loading' => 'ŝarĝante ...',
	'mwe-cancel' => 'Nuligi',
);

/** Spanish (Español)
 * @author Fitoschido
 * @author Translationista
 */
$messages['es'] = array(
	'mwe-loading' => 'cargando ...',
	'mwe-error_load_lib' => 'Error: JavaScript $1 no ha podido ser recuperado o no define $2',
	'mwe-apiproxy-setup' => 'Configurando proxi de la API',
	'mwe-load-drag-item' => 'Cargando el objeto arrastrado',
	'mwe-ok' => 'Aceptar',
	'mwe-cancel' => 'Cancelar',
	'mwe-enable-gadget' => 'Habilitar multimedia beta (mwEmbed) en todas las páginas',
	'mwe-enable-gadget-done' => 'Se ha habilitado el gadget multimedia beta',
	'mwe-must-login-gadget' => 'Para habilitar el gadget debes <a target="_new" href="$1">ingresar</a>',
	'mwe-test-plural' => 'Realicé {{PLURAL:$1|$1 prueba|$1 pruebas}}',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'mwe-ok' => 'Sobib',
	'mwe-cancel' => 'Loobu',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'mwe-loading' => 'Kargatzen ...',
	'mwe-ok' => 'Ados',
	'mwe-cancel' => 'Utzi',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Str4nd
 */
$messages['fi'] = array(
	'mwe-loading' => 'Ladataan...',
	'mwe-error_load_lib' => 'Virhe: JavaScript $1 ei ollut haettavissa tai se ei määrittele luokkaa $2',
	'mwe-apiproxy-setup' => 'Pystytetään API-välityspalvelinta',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Peruuta',
	'mwe-must-login-gadget' => 'Sinun tulee <a target="_new" href="$1">kirjautua sisään</a>, jotta voisit käyttää pienoisohjelmaa',
	'mwe-test-plural' => 'Ajoin {{PLURAL:$1|$1 testin|$1 testiä}}',
);

/** French (Français)
 * @author IAlex
 * @author Jean-Frédéric
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'mwe-loading' => 'chargement ...',
	'mwe-error_load_lib' => "Erreur : JavaScript $1 n'a pas pu être trouvé ou ne définit pas $2",
	'mwe-apiproxy-setup' => 'Configuration du proxy API',
	'mwe-load-drag-item' => 'Chargement de l’élément dépose',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Annuler',
	'mwe-enable-gadget' => 'Activer beta multimédia (mwEmbed) sur toutes les pages',
	'mwe-enable-gadget-done' => 'Le gadget multimédia beta a été activé',
	'mwe-must-login-gadget' => 'Afin d\'activer le gadget vous devez vous <a target="_new" href="$1">connecter</a>',
	'mwe-test-plural' => "J'ai exécuté {{PLURAL:$1|$1 test|$1 tests}}",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'mwe-loading' => 'Chargement ...',
	'mwe-ok' => 'D’acôrd',
	'mwe-cancel' => 'Anular',
	'mwe-test-plural' => 'J’é ègzécutâ $1 èprôv{{PLURAL:$1|a|es}}',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'mwe-loading' => 'cargando...',
	'mwe-size-kilobytes' => '$1 kB',
	'mwe-error_load_lib' => 'Erro: o JavaScript $1 non se puido atopar ou non definía $2',
	'mwe-apiproxy-setup' => 'Configurando o proxy API',
	'mwe-load-drag-item' => 'Cargando o elemento arrastrado',
	'mwe-ok' => 'Aceptar',
	'mwe-cancel' => 'Cancelar',
	'mwe-enable-gadget' => 'Activar a beta multimedia (mwEmbed) en todas as páxinas',
	'mwe-enable-gadget-done' => 'Activouse o trebello beta multimedia',
	'mwe-must-login-gadget' => 'Para activar o trebello ten que <a target="_new" href="$1">acceder ao sistema</a>',
	'mwe-test-plural' => '{{PLURAL:$1|Fíxose unha proba|Fixéronse $1 probas}}',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 */
$messages['grc'] = array(
	'mwe-ok' => 'εἶεν',
	'mwe-cancel' => 'Ἀκυροῦν',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'mwe-loading' => 'Am Lade ...',
	'mwe-error_load_lib' => 'Fähler: s JavaScript $1 het nit chenne glade wäre oder s losst $2 nit zue',
	'mwe-apiproxy-setup' => 'API-Proxy-Konfiguration',
	'mwe-load-drag-item' => 'Am Lade vu mitgschleipfte Poschte',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Abbräche',
	'mwe-enable-gadget' => 'D Beta-Version vum  Multimedia-Heälferli (mwEmbed) fir alli Syte aktiviere',
	'mwe-enable-gadget-done' => 'Beta-Version vum Multimedia-Hälferli isch aktiviert wore',
	'mwe-must-login-gadget' => 'Go s Hälferli aktiviere chenne, muesch di <a target="_new" href="$1">aamälde</a>',
	'mwe-test-plural' => '{{PLURAL:$1|$1 Tescht|$1 Tescht}} uusgfiert',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'mwe-cancel' => 'Soke',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'mwe-loading' => 'בטעינה ...',
	'mwe-error_load_lib' => 'שגיאה: לא ניתן היה לטעון את ספריית ה־JavaScript בשם $1 או שהיא אינה מגדירה את $2',
	'mwe-apiproxy-setup' => 'הגדרה של API proxy',
	'mwe-load-drag-item' => 'טעינה של פריט שנגרר',
	'mwe-ok' => 'אישור',
	'mwe-cancel' => 'ביטול',
	'mwe-enable-gadget' => 'הפעלת גרסה ניסיונית של mwEmbed להצגת מולטימדיה בכל הדפים',
	'mwe-enable-gadget-done' => 'הופעל תוסף ניסיוני להצגת מולטימדיה',
	'mwe-must-login-gadget' => 'כדי להפעיל את התוסף, צריך <a target="_new" href="$1">להתחבר לחשבון</a>',
	'mwe-test-plural' => '{{PLURAL:$1|הופעלה בדיקה אחת|הופעלו $1 בדיקות}}',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'mwe-loading' => 'začituje so ...',
	'mwe-size-gigabytes' => '$1 GB',
	'mwe-size-megabytes' => '$1 MB',
	'mwe-size-kilobytes' => '$1 KB',
	'mwe-size-bytes' => '$1 B',
	'mwe-error_load_lib' => 'Zmylk: JavaScript $1 njeda so wotwołać abo njedefinuje $2',
	'mwe-apiproxy-setup' => 'Proksy API zarjadować',
	'mwe-load-drag-item' => 'Wlečeny zapisk so začituje',
	'mwe-ok' => 'W porjadku',
	'mwe-cancel' => 'Přetorhnyć',
	'mwe-enable-gadget' => 'Multimedia beta (mwEmbed) za wšě strony zmóžnić',
	'mwe-enable-gadget-done' => 'Přisłušk za Multimedia beta je so zmóžnił',
	'mwe-must-login-gadget' => 'Zo by přisłušk zmóžnił, dyrbiš so <a target="_new" href="$1">přizjewić</a>',
	'mwe-test-plural' => 'Sym {{PLURAL:$1|$1 test|$1 testaj|testy|testow}} přewjedł',
);

/** Hungarian (Magyar)
 * @author Dani
 * @author Glanthor Reviol
 */
$messages['hu'] = array(
	'mwe-loading' => 'betöltés…',
	'mwe-error_load_lib' => 'Hiba: a(z) $1 JavaScript-fájl nem elérhető, vagy nem definiálja a(z) $2 osztályt.',
	'mwe-apiproxy-setup' => 'API proxy beállítása',
	'mwe-load-drag-item' => 'Vonszolt elem betöltése',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Mégse',
	'mwe-enable-gadget' => 'A multimédia béta (mwEmbed) engedélyezése az összes lapon',
	'mwe-enable-gadget-done' => 'A multimédia béta segédeszköz engedélyezve',
	'mwe-must-login-gadget' => 'Hogy engedélyezni tudd a segédeszközt, <a target="_new" href="$1">be kell jelentkezned</a>',
	'mwe-test-plural' => '$1 tesztet futtattam',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'mwe-loading' => 'cargamento ...',
	'mwe-error_load_lib' => 'Error: JavaScript $1 non esseva recuperabile o non defini $2',
	'mwe-apiproxy-setup' => 'Configuration del proxy pro le API',
	'mwe-load-drag-item' => 'Cargamento del file trahite',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Cancellar',
	'mwe-enable-gadget' => 'Activar beta multimedia (mwEmbed) pro tote le paginas',
	'mwe-enable-gadget-done' => 'Le gadget beta multimedia ha essite activate',
	'mwe-must-login-gadget' => 'Pro activar le gadget tu debe <a target="_new" href="$1">aperir un session</a>',
	'mwe-test-plural' => 'Io ha executate {{PLURAL:$1|$1 test|$1 tests}}',
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 */
$messages['id'] = array(
	'mwe-loading' => 'memuat...',
	'mwe-error_load_lib' => 'Kesalahan: JavaScript $1 tidak dapat diambil atau tidak mendefinisikan $2',
	'mwe-apiproxy-setup' => 'Menyiapkan proksi API',
	'mwe-load-drag-item' => 'Memuat butir terseret',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Batalkan',
	'mwe-enable-gadget' => 'Aktifkan beta multimedia (mwEmbed) untuk semua halaman',
	'mwe-enable-gadget-done' => 'Gadget beta multimedia telah diaktifkan',
	'mwe-must-login-gadget' => 'Untuk mengaktifkan gadget Anda harus <a target="_new" href="$1">masuk log</a>',
	'mwe-test-plural' => 'Saya menjalankan {{PLURAL:$1|$1 tes|$1 tes}}',
);

/** Igbo (Igbo) */
$messages['ig'] = array(
	'mwe-ok' => 'Ngwanu',
	'mwe-cancel' => 'Emekwàlà',
);

/** Italian (Italiano)
 * @author Beta16
 * @author Gianfranco
 */
$messages['it'] = array(
	'mwe-loading' => 'Caricamento in corso...',
	'mwe-error_load_lib' => 'Errore: JavaScript $1 non è recuperabile o non definisce $2',
	'mwe-load-drag-item' => "Caricamento dell'elemento trascinato",
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Annulla',
	'mwe-enable-gadget' => 'Abilita multimedia beta (mwEmbed) per tutte le pagine',
	'mwe-enable-gadget-done' => 'Il gadget multimediale beta è stato abilitato',
	'mwe-must-login-gadget' => 'Per abilitare il gadget è necessario <a target="_new" href="$1">accedere</a>',
	'mwe-test-plural' => 'Ho eseguito {{PLURAL:$1|$1 test|$1 test}}',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author 青子守歌
 */
$messages['ja'] = array(
	'mwe-loading' => '読み込み中 …',
	'mwe-error_load_lib' => 'エラー：JavaScript $1 は参照不能か、$2 を定義していません。',
	'mwe-apiproxy-setup' => 'API プロキシーをセットアップ中',
	'mwe-load-drag-item' => 'ドラッグされた項目を読み込み中',
	'mwe-ok' => 'OK',
	'mwe-cancel' => '中止',
	'mwe-enable-gadget' => 'マルチメディアベータ(mwEmbed)を全ページで有効化',
	'mwe-enable-gadget-done' => 'マルチメディアベータのガジェットが有効です',
	'mwe-must-login-gadget' => 'ガジェットを有効にするには<a target="_new" href="$1">ログイン</a>が必要です',
	'mwe-test-plural' => '{{PLURAL:$1|$1のテスト}}を実行する',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'mwe-cancel' => 'ರದ್ದು ಮಾಡು',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'mwe-loading' => '불러오는 중...',
	'mwe-cancel' => '취소',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'mwe-loading' => 'aam Laade …',
	'mwe-size-gigabytes' => '$1&nbsp;GB',
	'mwe-size-megabytes' => '$1&nbsp;MB',
	'mwe-size-kilobytes' => '$1&nbsp;KB',
	'mwe-size-bytes' => '$1&nbsp;Bytes',
	'mwe-error_load_lib' => 'Fähler: Dat JavaSkrep „<code lang="en">$1</code>“ wohr nit ze laade udder et leiht „<code lang="en">$2</code>“ nit faß.',
	'mwe-apiproxy-setup' => 'Ben de dä <i lang="en">proxy</i>-ẞööver för de <i title="Application Programmers Interface" lang="en">API</i> aam opsäzze.',
	'mwe-load-drag-item' => 'Mer sen dat jetrocke Denge aam laade&nbsp;…',
	'mwe-ok' => 'Jot!',
	'mwe-cancel' => 'Affbräsche',
	'mwe-enable-gadget' => 'Don de Beta_Version fun dä Verbäßerong (<code lang="en">mwEmbed</code>) för Mulitmeedija för alle Sigge aanschallde.',
	'mwe-enable-gadget-done' => 'De Beta_Version fun dä Verbäßerong för Mulitmeedija es aanjeschalldt.',
	'mwe-must-login-gadget' => 'Öm di Verbäßerong aanzeschallde, moß De <a target="_new" href="$1">enlogge</a>.',
	'mwe-test-plural' => 'Mer han {{PLURAL:$1|ein Prööfong|$1 Prööfonge|kein Prööfong}} loufe lohße.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'mwe-loading' => 'lueden ...',
	'mwe-error_load_lib' => 'Feeler: JavaScript $1 konnt net ofgeruf ginn oder definéiert $2 net',
	'mwe-apiproxy-setup' => 'API-Proxy astellen',
	'mwe-load-drag-item' => 'Den agebonnen Objet gëtt gelueden',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Ofbriechen',
	'mwe-enable-gadget' => 'Multimedia-Beta-Gadget (mwEmbed) fir all Säiten aktivéieren',
	'mwe-enable-gadget-done' => 'De Multimedia-Beta-Gadget gouf aktivéiert',
	'mwe-must-login-gadget' => 'Fir de Gadget aktivéieren ze kënne musst Dir Iech <a target="_new" href="$1">aloggen</a>',
	'mwe-test-plural' => 'Ech hunn {{PLURAL:$1|$1 Test|$1 Tester}} gemaach',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'mwe-loading' => 'Вчитувам...',
	'mwe-size-gigabytes' => '$1 ГБ',
	'mwe-size-megabytes' => '$1 МБ',
	'mwe-size-kilobytes' => '$1 К',
	'mwe-size-bytes' => '$1 Б',
	'mwe-error_load_lib' => 'Грешка: JavaScript $1 не е достапен или не определува $2',
	'mwe-apiproxy-setup' => 'Поставувам API застапник (proxy)',
	'mwe-load-drag-item' => 'Го вчитувам повлечениот елемент',
	'mwe-ok' => 'ОК',
	'mwe-cancel' => 'Откажи',
	'mwe-enable-gadget' => 'Овозможи бета-мултимедија (mwEmbed) за сите страници',
	'mwe-enable-gadget-done' => 'Овозможена е алатката за бета-мултимедија',
	'mwe-must-login-gadget' => 'За да ја овозможите алатката морате да се <a target="_new" href="$1">најавите</a>',
	'mwe-test-plural' => 'Направив {{PLURAL:$1|$1 проверка|$1 проверки}}',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'mwe-loading' => 'ശേഖരിക്കുന്നു ...',
	'mwe-error_load_lib' => 'പിഴവ്: ജാവാസ്ക്രിപ്റ്റ് $1 ശേഖരിക്കാൻ കഴിഞ്ഞില്ല അല്ലെങ്കിൽ $2 നിർവചിച്ചിട്ടില്ല',
	'mwe-apiproxy-setup' => 'എ.പി.ഐ. പ്രോക്സി സജ്ജീകരിക്കുക',
	'mwe-load-drag-item' => 'വലിച്ചിട്ടത് ശേഖരിക്കുന്നു',
	'mwe-ok' => 'ശരി',
	'mwe-cancel' => 'റദ്ദാക്കുക',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'mwe-cancel' => 'Цуцлах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Batalkan',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'mwe-loading' => 'Йовкстамозо моли…',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'mwe-loading' => 'Laster ...',
	'mwe-error_load_lib' => 'Feil: JavaScript $1 kunne ikke gjenhentes eller definerer ikke $2',
	'mwe-apiproxy-setup' => 'Setter opp API-mellomtjener',
	'mwe-load-drag-item' => 'Laster dratt element',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Avbryt',
	'mwe-enable-gadget' => 'Aktiver multimedia-beta (mwEmbed) for alle sider',
	'mwe-enable-gadget-done' => 'Skjermelement for multimedia-beta har blitt aktivert',
	'mwe-must-login-gadget' => 'For å aktivere skjermelement må du <a target="_new" href="$1">logge inn</a>',
	'mwe-test-plural' => 'Jeg kjørte {{PLURAL:$1|én test|$1 tester}}',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'mwe-loading' => 'Bezig met laden…',
	'mwe-error_load_lib' => 'Fout: JavaScript $1 kon niet opgehaald worden of definieert $2 niet',
	'mwe-apiproxy-setup' => 'Bezig met het opzetten van een API-proxy',
	'mwe-load-drag-item' => 'Bezig met het laden van het gesleepte bestand',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Annuleren',
	'mwe-enable-gadget' => "Multimedia beta (mwEmbed) voor alle pagina's inschakelen",
	'mwe-enable-gadget-done' => 'Multimedia beta is ingeschakeld',
	'mwe-must-login-gadget' => 'Om de uitbreiding in te schakelen, moet u <a target="_new" href="$1">aanmelden</a>',
	'mwe-test-plural' => '{{PLURAL:$1|$1 test|$1 tests}} uitgevoerd',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Nghtwlkr
 */
$messages['nn'] = array(
	'mwe-loading' => 'Lastar …',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Avbryt',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'mwe-loading' => 'cargament ...',
	'mwe-error_load_lib' => 'Error : JavaScript $1 a pas pogut èsser trobat o definís pas $2',
	'mwe-apiproxy-setup' => 'Configuracion del proxy API',
	'mwe-load-drag-item' => 'Cargament de l’element depausat',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Anullar',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Psubhashish
 */
$messages['or'] = array(
	'mwe-ok' => 'ଠିକ ଅଛି',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'mwe-loading' => 'Am laade…',
	'mwe-ok' => 'OK',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'mwe-loading' => 'ładowanie ...',
	'mwe-error_load_lib' => 'Błąd – W plik JavaScript $1 brak jest możliwości pobrania oraz definicji $2',
	'mwe-apiproxy-setup' => 'Konfiguracja proxy dla API',
	'mwe-load-drag-item' => 'Ładowanie przeciągniętego elementu',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Anuluj',
	'mwe-enable-gadget' => 'Włącz wersję testową multimediów (wmEmbed) na wszystkich stronach',
	'mwe-enable-gadget-done' => 'Testowy gadżet multimediów został włączony',
	'mwe-must-login-gadget' => 'Gadżet można włączyć dopiero po <a target="_new" href="$1">zalogowaniu się</a>',
	'mwe-test-plural' => 'Wykonałem $1 {{PLURAL:$1|test|testy|testów}}',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'mwe-loading' => 'A caria ...',
	'mwe-error_load_lib' => 'Eror: JavaScript $1 as peul pa trovesse o a definiss pa $2',
	'mwe-apiproxy-setup' => 'Amposté ël proxy API',
	'mwe-load-drag-item' => "carié l'element tirà",
	'mwe-ok' => 'Va bin',
	'mwe-cancel' => 'Scancela',
	'mwe-enable-gadget' => 'Abìlita la beta multimedia (mwEmbed) për tute le pàgine',
	'mwe-enable-gadget-done' => "L'acessòri beta multimedia a l'é stàit abilità",
	'mwe-must-login-gadget' => 'Për abilité l\'acessòri a dev <a target="_new" href="$1">intré ant ël sistema</a>',
	'mwe-test-plural' => "I l'heu fàit {{PLURAL:$1|$1 test|$1 test}}",
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'mwe-ok' => 'ښه',
	'mwe-cancel' => 'ناګارل',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Malafaya
 */
$messages['pt'] = array(
	'mwe-loading' => 'A carregar ...',
	'mwe-error_load_lib' => 'Erro: O JavaScript $1 não pode ser importado ou não define $2',
	'mwe-apiproxy-setup' => "A preparar o ''proxy'' da API",
	'mwe-load-drag-item' => 'A carregar o objecto arrastado',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Cancelar',
	'mwe-enable-gadget' => 'Activar beta de multimédia (mwEmbed) para todas as páginas',
	'mwe-enable-gadget-done' => 'Gadget beta de multimédia foi activado',
	'mwe-must-login-gadget' => 'Para activar o gadget tem de estar <a target="_new" href="$1">autenticado</a>',
	'mwe-test-plural' => 'Fiz $1 {{PLURAL:$1|teste|testes}}',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author Luckas Blade
 */
$messages['pt-br'] = array(
	'mwe-loading' => 'Carregando ...',
	'mwe-error_load_lib' => 'Erro: O JavaScript $1 não pode ser importado ou não define $2',
	'mwe-apiproxy-setup' => 'Configurando proxy da API',
	'mwe-load-drag-item' => 'Carregando o objeto arrastado',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Cancelar',
	'mwe-enable-gadget' => 'Ativar beta de multimídia (mwEmbed) para todas as páginas',
	'mwe-enable-gadget-done' => 'O Gadget beta de multimídia foi ativado',
	'mwe-must-login-gadget' => 'Para ativar o gadget você deve estar <a target="_new" href="$1">autenticado</a>',
	'mwe-test-plural' => 'Eu fiz $1 {{PLURAL:$1|teste|testes}}',
);

/** Romanian (Română)
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'mwe-loading' => 'Se încarcă ...',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Renunţă',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'mwe-loading' => 'загрузка …',
	'mwe-error_load_lib' => 'Ошибка. JavaScript $1 не доступен или не определяет $2',
	'mwe-apiproxy-setup' => 'Настройка API-прокси',
	'mwe-load-drag-item' => 'Загрузка перетащенного элемента',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Отмена',
	'mwe-enable-gadget' => 'Включить бета-мультимедиа (mwEmbed) для всех страниц',
	'mwe-enable-gadget-done' => 'Включён гаджет бета-мультимедиа',
	'mwe-must-login-gadget' => 'Для включения гаджета вам следует <a target="_new" href="$1">представиться</a>.',
	'mwe-test-plural' => 'Я прошёл {{PLURAL:$1|$1 проверку|$1 проверки|$1 проверок}}',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'mwe-ok' => 'ОК',
	'mwe-cancel' => 'Сторно',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'mwe-loading' => 'načítava sa ...',
	'mwe-error_load_lib' => 'Error: JavaScript $1 nebolo možné získať alebo neobsahuje definíciu $2',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'mwe-loading' => 'Учитавам…',
	'mwe-size-gigabytes' => '$1 GB',
	'mwe-size-megabytes' => '$1 MB',
	'mwe-size-kilobytes' => '$1 K',
	'mwe-size-bytes' => '$1 B',
	'mwe-ok' => 'У реду',
	'mwe-cancel' => 'Откажи',
	'mwe-test-plural' => 'Покренуо/ла сам {{PLURAL:$1|$1 тест|$1 тестова}}',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Rancher
 */
$messages['sr-el'] = array(
	'mwe-loading' => 'Učitavanje ...',
	'mwe-size-gigabytes' => '$1 GB',
	'mwe-size-megabytes' => '$1 MB',
	'mwe-size-kilobytes' => '$1 K',
	'mwe-size-bytes' => '$1 B',
	'mwe-ok' => 'U redu',
	'mwe-cancel' => 'Otkaži',
	'mwe-test-plural' => 'Pokrenuo/la sam {{PLURAL:$1|$1 test|$1 testova}}',
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Dafer45
 * @author GameOn
 */
$messages['sv'] = array(
	'mwe-loading' => 'Laddar…',
	'mwe-error_load_lib' => 'Fel: JavaScript $1 var inte tillgänglig eller definierade inte $2',
	'mwe-apiproxy-setup' => 'Konfigurerar API-proxy',
	'mwe-load-drag-item' => 'Laddar draget objekt',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Avbryt',
	'mwe-enable-gadget' => 'Aktivera multimedia beta (mwEmbed) på alla sidor',
	'mwe-enable-gadget-done' => 'Multimedia beta finessen har aktiverats',
	'mwe-must-login-gadget' => 'För att aktivera finessen måste du <a target="_new" href="$1">logga in</a>',
	'mwe-test-plural' => 'Jag gjorde {{PLURAL:$1|$1 test|$1 test}}',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'mwe-loading' => 'లోడవుతోంది...',
	'mwe-ok' => 'సరే',
	'mwe-cancel' => 'రద్దుచేయి',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'mwe-loading' => 'Ikinakarga...',
	'mwe-error_load_lib' => 'Kamalian: hindi makukuha ang JavaScript na $1 o hindi nagbigay kahulugan sa $2',
	'mwe-apiproxy-setup' => 'Nagtatalaga ng pamalit na API',
	'mwe-load-drag-item' => 'Ikinakarga ang hinilang bagay',
	'mwe-ok' => 'Okey',
	'mwe-cancel' => 'Huwag ituloy',
	'mwe-enable-gadget' => 'Paganahin ang betang multimidya (mwEmbed) para sa lahat ng mga pahina',
	'mwe-enable-gadget-done' => 'Pinagana ang gadyet na pangbetang multimidya',
	'mwe-must-login-gadget' => 'Upang mapagana ang gadyet dapat kang <a target="_new" href="$1">lumagda</a>',
	'mwe-test-plural' => 'Nagpatakbo ako ng {{PLURAL:$1|$1 pagsusulit|$1 mga pagsusulit}}',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'mwe-loading' => 'yükleniyor ...',
	'mwe-error_load_lib' => 'Hata: $1 JavaScripti erişilebilir değil ya da $2 tanımlı değil',
	'mwe-apiproxy-setup' => 'API vekili ayarlanıyor',
	'mwe-load-drag-item' => 'Sürüklenen öğe yükleniyor',
	'mwe-ok' => 'Tamam',
	'mwe-cancel' => 'İptal',
);

/** Ukrainian (Українська)
 * @author Тест
 */
$messages['uk'] = array(
	'mwe-loading' => 'Завантаження ...',
	'mwe-cancel' => 'Скасувати',
);

/** Urdu (اردو) */
$messages['ur'] = array(
	'mwe-cancel' => 'منسوخ',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'mwe-loading' => "so' drio cargar ...",
	'mwe-ok' => 'Va ben',
	'mwe-cancel' => 'Anula',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'mwe-loading' => 'Đang tải…',
	'mwe-size-kilobytes' => '$1 kB',
	'mwe-error_load_lib' => 'Lỗi: JavaScript $1 không truy xuất được hoặc không định nghĩa $2',
	'mwe-apiproxy-setup' => 'Đang thiết lập proxy API',
	'mwe-load-drag-item' => 'Đang tải các mục đã kéo',
	'mwe-ok' => 'OK',
	'mwe-cancel' => 'Hủy bỏ',
	'mwe-enable-gadget' => 'Kích hoạt đa phương tiện bản beta (mwEmbed) cho mọi trang',
	'mwe-enable-gadget-done' => 'Công cụ đa năng đa phương tiện bản beta đã được kích hoạt',
	'mwe-must-login-gadget' => 'Để kích hoạt công cụ đa năng bạn phải <a target="_new" href="$1">đăng nhập</a>',
	'mwe-test-plural' => 'Tôi đã chạy {{PLURAL:$1|$1 mẫu thử|$1 mẫu thử}}',
);

/** Wu (吴语) */
$messages['wuu'] = array(
	'mwe-cancel' => '取消',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'mwe-loading' => '正在载入...',
	'mwe-error_load_lib' => '错误：JavaScript $1 是不可检索或未定义 $2',
	'mwe-apiproxy-setup' => 'API 的代理设定',
	'mwe-load-drag-item' => '拖动项载入中',
	'mwe-ok' => '确定',
	'mwe-cancel' => '取消',
	'mwe-enable-gadget' => '在所有页面启用多媒体测试版（mwEmbed）。',
	'mwe-enable-gadget-done' => '小工具多媒体测试版已启用',
	'mwe-must-login-gadget' => '要启用小工具，你必须先<a target="_new" href="$1">登入</a>。',
	'mwe-test-plural' => '我在执行 {{PLURAL:$1|$1 个|$1 个}}测试',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Mark85296341
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'mwe-loading' => '載入中...',
	'mwe-error_load_lib' => '錯誤：JavaScript $1 是不可檢索或未定義 $2',
	'mwe-apiproxy-setup' => 'API 的代理設定',
	'mwe-load-drag-item' => '拖動項載入中',
	'mwe-ok' => '確定',
	'mwe-cancel' => '取消',
	'mwe-enable-gadget' => '在所有頁面啟用多媒體測試版（mwEmbed）。',
	'mwe-enable-gadget-done' => '小工具多媒體測試版已啟用',
	'mwe-must-login-gadget' => '要啟用小工具，你必須先<a target="_new" href="$1">登入</a>。',
	'mwe-test-plural' => '我在執行 {{PLURAL:$1|$1 個|$1 個}}測試',
);

