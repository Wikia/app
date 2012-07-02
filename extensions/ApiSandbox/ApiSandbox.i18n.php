<?php
/**
 * Internationalization file for the API sandbox extension.
 *
 * @file
 * @ingroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'apisb-desc'              => 'Allows to debug [//www.mediawiki.org/wiki/API MediaWiki API] calls from browser',
	'apisandbox'              => 'API sandbox',
	'apisb-no-js'             => "'''Error''': this feature requires JavaScript.",
	'apisb-intro'             => "Use this page to experiment with the '''MediaWiki web service API'''.
	Refer to [//www.mediawiki.org/wiki/API:Main_page the API documentation] for further details of API usage.  Example: [//www.mediawiki.org/wiki/API#A_simple_example get the content of a Main Page].  Select an action to see more examples.",
	'apisb-api-disabled'      => 'API is disabled on this site.',
	'apisb-legend-parameters' => 'Parameters',
	'apisb-legend-result'     => 'Result',
	'apisb-legend-generic-parameters'=> 'Generic parameters',
	'apisb-legend-generator-parameters'=> 'Generator',
	'apisb-result-request-url' => 'Request URL:',
	'apisb-result-request-post' => 'POST data:',
	'apisb-select-action'     => '(select action)',
	'apisb-select-query'      => '(select query)',
	'apisb-select-value'      => '(select value)',
	'apisb-docs-more'         => 'read more',
	'apisb-params-param'      => 'Parameter',
	'apisb-params-input'      => 'Input',
	'apisb-params-desc'       => 'Description',
	'apisb-loading'           => 'Loading...',
	'apisb-load-error'        => 'Error loading API description',
	'apisb-request-error'     => 'Error performing API request',
	'apisb-namespaces-error'  => 'Error loading namespaces',
	'apisb-ns-main'           => '(Main)',
	'apisb-submit'            => 'Make request',
	'apisb-query-prop'        => 'Properties',
	'apisb-query-list'        => 'Lists',
	'apisb-query-meta'        => 'Meta information',
	'apisb-example'           => 'Example',
	'apisb-examples'          => 'Examples',
	'apisb-clear'             => 'Clear',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Krinkle
 * @author MaxSem
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'apisb-desc' => '{{desc}}',
	'apisandbox' => 'Special page title',
	'apisb-legend-parameters' => '{{Identical|Parameter}}',
	'apisb-legend-result' => 'Used as "legend" in the form fieldset containing read-only fields with info about an executed API request.
{{Identical|Result}}',
	'apisb-legend-generator-parameters' => 'Refers to an [https://www.mediawiki.org/wiki/API:Query#Generators API concept]',
	'apisb-result-request-url' => 'Used as "label" for a read-only form field containing the exact URL that was (or is going to be) loaded.',
	'apisb-result-request-post' => 'Used as "label" for a ready-only form field containing the POST query parameters of the HTTP request made',
	'apisb-select-action' => 'This is the placeholder text in the "select" dropdown menu containing options with various action modules.',
	'apisb-select-query' => 'This is the placeholder text in the "select" dropdown menu containing options with various query types.',
	'apisb-select-value' => 'This is the generic placeholder text in "select" dropdown menus containing custom options (e.g. wiki namespaces, content direction, ..)',
	'apisb-docs-more' => 'Used in parenthesis next to a short (but not cut off) version of the description. Links to a page on mediawiki.org with complete documentation.',
	'apisb-params-param' => 'Table heading of the column with the parameter identifiers.
{{Identical|Parameter}}',
	'apisb-params-input' => 'Table heading for the column with the input fields (e.g. text inputs, dropdown menus, checkboxes)',
	'apisb-params-desc' => 'Table heading of the column containing the descriptions.
{{Identical|Description}}',
	'apisb-loading' => '{{Identical|Loading}}',
	'apisb-ns-main' => 'Refers to the main namespace, commonly put in parenthesis.
{{Identical/Main namespace}}',
	'apisb-submit' => 'Submit button text that submits the form and performs the API request, after which the result is shown below',
	'apisb-query-prop' => '{{Identical|Property}}',
	'apisb-query-list' => '{{Identical|List}}',
	'apisb-example' => 'Button text that will reveal the example list, used if the list contains only 1 entry. See also {{msg-mw|apisb-examples}}',
	'apisb-examples' => 'Button text that will reveal the example list, used if the list contains multiple entries. See also {{msg-mw|apisb-example}}',
	'apisb-clear' => 'Title of the button that clears all inputs',
);

/** Afrikaans (Afrikaans)
 * @author Ansumang
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'apisb-api-disabled' => 'API is afgeskakel op hierdie webwerf.',
	'apisb-legend-result' => 'Resultaat',
	'apisb-legend-generic-parameters' => 'generiese parameters',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-select-action' => "Kies 'n aksie",
	'apisb-select-value' => "Kies 'n waarde",
	'apisb-loading' => 'Laai tans…',
	'apisb-load-error' => 'Fout met laai API beskrywing',
	'apisb-request-error' => 'Fout met die uitvoering van API-versoek',
	'apisb-namespaces-error' => 'Fout tydens laai naamspasies',
	'apisb-ns-main' => '(Hoofnaamruimte)',
	'apisb-submit' => 'Maak versoek',
	'apisb-query-prop' => 'Eienskappe',
	'apisb-query-list' => 'Lyste',
	'apisb-query-meta' => 'Meta-inligting',
);

/** Arabic (العربية)
 * @author روخو
 */
$messages['ar'] = array(
	'apisb-no-js' => "'''خطأ''' : هذه الخاصية تتطلب الجافا سكريبت.",
	'apisb-result' => 'النتيجة',
	'apisb-select-action' => 'اختر حدث',
	'apisb-ns-main' => '(رئيسي)',
	'apisb-query-prop' => 'الخصائص',
	'apisb-query-list' => 'قوائم',
	'apisb-query-meta' => 'معلومات الميتا',
	'apisb-generator-parameters' => 'مولد',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'apisb-parameters' => 'Parametrlər',
	'apisb-result' => 'Nəticə',
	'apisb-loading' => 'Yüklənir…',
	'apisb-ns-main' => '(Əsas)',
	'apisb-query-list' => 'Siyahılar',
	'apisb-query-meta' => 'Meta məlumatları',
);

/** Bashkir (Башҡортса)
 * @author Haqmar
 */
$messages['ba'] = array(
	'apisb-legend-result' => 'Һөҙөмтә',
	'apisb-legend-generic-parameters' => 'Дөйөм параметрҙар',
	'apisb-legend-generator-parameters' => 'Генератор',
	'apisb-result-request-url' => 'Һоратыуҙың URL-адресы:',
	'apisb-result-request-post' => 'POST мәғлүмәттәр:',
	'apisb-select-action' => 'Хәрәкәт һайларға',
	'apisb-select-query' => 'Ни һоратырға?',
	'apisb-loading' => 'Асыла...',
	'apisb-ns-main' => '(Төп)',
	'apisb-submit' => 'Һоратыу яһарға',
	'apisb-query-prop' => 'Үҙенсәлектәр',
	'apisb-query-list' => 'Исемлектәр',
	'apisb-query-meta' => 'Мета-мәғлүмәт',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'apisb-desc' => 'Дазваляе налажваць выклікі [//www.mediawiki.org/wiki/API MediaWiki API] з браўзэра',
	'apisandbox' => 'Пясочніца API',
	'apisb-no-js' => "'''Памылка''': гэтая магчымасьць патрабуе JavaScript.",
	'apisb-intro' => "Выкарыстоўвайце гэтую старонку для экспэрымэнтаў з '''API вэб-сэрвіса MediaWiki'''.
Зьвяртайцеся да [//www.mediawiki.org/wiki/API:Main_page дакумэнтацыі API] для дадатковай інфармацыі па выкарыстаньні API. Напрыклад, [//www.mediawiki.org/wiki/API#A_simple_example як атрымаць зьмест Галоўнай старонкі]. Выберыце дзеяньне, каб пабачыць болей узораў.",
	'apisb-api-disabled' => 'API забаронены на гэтым сайце.',
	'apisb-legend-parameters' => 'Парамэтры',
	'apisb-legend-result' => 'Вынік',
	'apisb-legend-generic-parameters' => 'Агульныя парамэтры',
	'apisb-legend-generator-parameters' => 'Генэратар',
	'apisb-result-request-url' => 'URL-адрас запыту:',
	'apisb-result-request-post' => 'POST-зьвесткі:',
	'apisb-select-action' => 'Выбраць дзеяньне',
	'apisb-select-query' => '(выбраць чаргу)',
	'apisb-select-value' => '(выбраць значэньне)',
	'apisb-docs-more' => 'даведацца болей',
	'apisb-params-param' => 'Парамэтар',
	'apisb-params-input' => 'Увод',
	'apisb-params-desc' => 'Апісаньне',
	'apisb-loading' => 'Загрузка…',
	'apisb-load-error' => 'Немагчыма загрузіць апісаньне API',
	'apisb-request-error' => 'Немагчыма апрацаваць запыт API',
	'apisb-namespaces-error' => 'Немагчыма загрузіць прасторы назваў',
	'apisb-ns-main' => '(Асноўная)',
	'apisb-submit' => 'Зрабіць запыт',
	'apisb-query-prop' => 'Уласьцівасьці',
	'apisb-query-list' => 'Сьпісы',
	'apisb-query-meta' => 'Мэтазьвесткі',
	'apisb-example' => 'Прыклад',
	'apisb-examples' => 'Прыклады',
	'apisb-clear' => 'Ачысьціць',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'apisb-no-js' => "'''Грешка''': тази функционалност изисква Джаваскрипт.",
	'apisb-parameters' => 'Параметри',
	'apisb-result' => 'Резултат',
	'apisb-select-action' => 'Избиране на действие',
	'apisb-loading' => 'Зареждане...',
	'apisb-example' => 'Пример',
	'apisb-examples' => 'Примери',
	'apisb-clear' => 'Изчистване',
);

/** Bengali (বাংলা)
 * @author Bellayet
 */
$messages['bn'] = array(
	'apisb-legend-result' => 'ফলাফল',
	'apisb-select-value' => 'মান নির্বাচন',
	'apisb-loading' => 'লোডিং...',
	'apisb-ns-main' => '(প্রধান)',
	'apisb-submit' => 'অনুরোধ রাখুন',
	'apisb-query-list' => 'তালিকা',
	'apisb-query-meta' => 'মেটা তথ্য',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'apisb-desc' => 'Aotren dizreinañ galvadennoù [//www.mediawiki.org/wiki/API API MediaWikiI] eus ar merdeer',
	'apisandbox' => 'Poull-traezh API',
	'apisb-no-js' => "'''Fazi''' : Rekis eo JavaScript evit an arc'hwel-mañ.",
	'apisb-intro' => "Grit gant ar bajenn-mañ evit amprouiñ '''MediaWiki API'''.
Kit da deuler ur sell war [//www.mediawiki.org/wiki/API:Main_page teulioù API] evit gouzout hiroc'h penaos embreger API.",
	'apisb-api-disabled' => "Diweredekaet eo API war al lec'hienn-mañ.",
	'apisb-legend-result' => "Disoc'h",
	'apisb-legend-generic-parameters' => 'Arventennoù hollek',
	'apisb-legend-generator-parameters' => 'Ganer',
	'apisb-result-request-url' => 'Goulenn URL :',
	'apisb-result-request-post' => 'roadennoù POST :',
	'apisb-select-action' => 'Dibab un ober',
	'apisb-select-query' => 'Petra glask ?',
	'apisb-select-value' => 'Dibab an talvoud',
	'apisb-loading' => 'O kargañ...',
	'apisb-load-error' => 'Fazi en ur gargañ deskrivadur an API',
	'apisb-request-error' => 'Ur fazi zo bet o klask seveniñ ar goulenn API',
	'apisb-namespaces-error' => 'Fazi en ur gargañ an esaouennoù anv',
	'apisb-ns-main' => '(Pennañ)',
	'apisb-submit' => 'Sevel ar goulenn',
	'apisb-query-prop' => 'Perzhioù',
	'apisb-query-list' => 'Rolloù',
	'apisb-query-meta' => 'Titouroù Meta',
);

/** Catalan (Català)
 * @author Solde
 */
$messages['ca'] = array(
	'apisb-parameters' => 'Paràmetres',
	'apisb-result' => 'Resultat',
);

/** Czech (Česky)
 * @author Mormegil
 * @author Utar
 */
$messages['cs'] = array(
	'apisb-desc' => 'Umožňuje ladit volání [//www.mediawiki.org/wiki/API MediaWiki API] v prohlížeči',
	'apisandbox' => 'API pískoviště',
	'apisb-no-js' => "'''Chyba''': tato funkce vyžaduje JavaScript.",
	'apisb-intro' => "Pomocí této stránky můžete experimentovat s '''webovými službami MediaWiki API'''.
Podrobností využití API najdete v [//www.mediawiki.org/wiki/API:Main_page jeho dokumentaci]. Příklad: [//www.mediawiki.org/wiki/API#A_simple_example získání obsahu Hlavní stránky]. Další příklady uvidíte vybráním parametru action.",
	'apisb-api-disabled' => 'API je na tomto webu vypnuto.',
	'apisb-legend-parameters' => 'Parametry',
	'apisb-legend-result' => 'Výsledek',
	'apisb-legend-generic-parameters' => 'Obecné parametry',
	'apisb-legend-generator-parameters' => 'Generátor',
	'apisb-result-request-url' => 'URL požadavku:',
	'apisb-result-request-post' => 'POSTovaná data:',
	'apisb-select-action' => '(vyberte akci)',
	'apisb-select-query' => '(vyberte dotaz)',
	'apisb-select-value' => '(vyberte hodnotu)',
	'apisb-docs-more' => 'více informací',
	'apisb-params-param' => 'Parametr',
	'apisb-params-input' => 'Vstup',
	'apisb-params-desc' => 'Popis',
	'apisb-loading' => 'Načítá se…',
	'apisb-load-error' => 'Chyba při načítání popisu API',
	'apisb-request-error' => 'Chyba při provádění požadavku na API',
	'apisb-namespaces-error' => 'Chyba při načítání jmenných prostorů',
	'apisb-ns-main' => '(Hlavní)',
	'apisb-submit' => 'Odeslat požadavek',
	'apisb-query-prop' => 'Vlastnosti',
	'apisb-query-list' => 'Seznamy',
	'apisb-query-meta' => 'Meta informace',
	'apisb-example' => 'Příklad',
	'apisb-examples' => 'Příklady',
	'apisb-clear' => 'Vyčistit',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 * @author Purodha
 */
$messages['de'] = array(
	'apisb-desc' => 'Ermöglicht das Beseitigen von Fehlern bei Aufrufen der [//www.mediawiki.org/wiki/API MediaWiki-API] mit dem Browser',
	'apisandbox' => 'API-Spielwiese',
	'apisb-no-js' => "'''Fehler:''' Diese Funktion erfordert JavaSkript.",
	'apisb-intro' => "Diese Seite kannst du für Versuche mit der '''MediaWiki-API''' verwenden.
Die [//www.mediawiki.org/wiki/API:Main_page/de Dokumentation zur API] enthält weitere Hinweise zu ihrer Nutzung. Beispiel: [//www.mediawiki.org/wiki/API:Main_page/de#Beispiel Den Inhalt der Hauptseite abrufen]. Für weitere Beispiele eine der verfügbaren Aktionen auswählen.",
	'apisb-api-disabled' => 'Die API wurde auf diesem Wiki deaktiviert.',
	'apisb-legend-parameters' => 'Parameter',
	'apisb-legend-result' => 'Ergebnis',
	'apisb-legend-generic-parameters' => 'Generische Parameter',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'Anforderungs-URL:',
	'apisb-result-request-post' => 'POST-Daten:',
	'apisb-select-action' => 'Vorgang auswählen',
	'apisb-select-query' => '(Abfrage auswählen)',
	'apisb-select-value' => '(Wert auswählen)',
	'apisb-docs-more' => 'Mehr',
	'apisb-params-param' => 'Parameter',
	'apisb-params-input' => 'Eingabe',
	'apisb-params-desc' => 'Beschreibung',
	'apisb-loading' => 'Lade …',
	'apisb-load-error' => 'Fehler beim Laden der API-Beschreibung',
	'apisb-request-error' => 'Fehler beim Ausführen der API-Anforderung',
	'apisb-namespaces-error' => 'Fehler beim Laden der Namensräume',
	'apisb-ns-main' => '(Seiten)',
	'apisb-submit' => 'Anfrage ausführen',
	'apisb-query-prop' => 'Eigenschaften',
	'apisb-query-list' => 'Listen',
	'apisb-query-meta' => 'Metainformationen',
	'apisb-example' => 'Beispiel',
	'apisb-examples' => 'Beispiele',
	'apisb-clear' => 'Leeren',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'apisb-intro' => "Diese Seite können Sie für Versuche mit der '''MediaWiki-API''' verwenden.
Die [//www.mediawiki.org/wiki/API:Main_page/de Dokumentation zur API] enthält weitere Hinweise zu ihrer Nutzung. Beispiel: [//www.mediawiki.org/wiki/API:Main_page/de#Beispiel Den Inhalt der Hauptseite abrufen]. Für weitere Beispiele eine der verfügbaren Aktionen auswählen.",
);

/** Greek (Ελληνικά)
 * @author AK
 * @author Glavkos
 */
$messages['el'] = array(
	'apisb-no-js' => "'''Σφάλμα''': αυτό το χαρακτηριστικό απαιτεί τη χρήση της κονσόλας JavaScript.",
	'apisb-api-disabled' => 'Η Διεπαφή Προγραμματισμού Εφαρμογών (API) είναι απενεργοποιημένη σε αυτήν την τοποθεσία.',
	'apisb-legend-result' => 'Αποτέλεσμα',
	'apisb-legend-generic-parameters' => 'Γενικές παράμετροι',
	'apisb-legend-generator-parameters' => 'Γεννήτρια',
	'apisb-result-request-url' => 'Αίτηση URL:',
	'apisb-select-action' => 'Επιλέξτε ενέργεια',
	'apisb-select-query' => 'Τι πρέπει να ρωτήσω;',
	'apisb-select-value' => 'Επιλέξτε τιμή',
	'apisb-loading' => 'Φόρτωση...',
	'apisb-namespaces-error' => 'Σφάλμα φόρτωσης ονοματοχώρων',
	'apisb-ns-main' => '(Κύρια)',
	'apisb-submit' => 'Κάντε αίτημα',
	'apisb-query-prop' => 'Ιδιότητες',
	'apisb-query-list' => 'Λίστες',
	'apisb-query-meta' => 'Πληροφορίες Meta',
);

/** Esperanto (Esperanto)
 * @author Blahma
 * @author Lucas
 * @author Yekrats
 */
$messages['eo'] = array(
	'apisb-desc' => 'Permesas sencimigadon de vokoj al [//www.mediawiki.org/wiki/API MediaWiki API] el la retumilo',
	'apisandbox' => 'API testejo',
	'apisb-no-js' => "'''Eraro''': tiu ĉi funkcio postulas Ĝavaskripton.",
	'apisb-intro' => "Uzu tiun ĉi paĝon por eksperimenti kun '''MediaWiki API'''.
Vidu [//www.mediawiki.org/wiki/API:Main_page la API-dokumentadon] por pli da detaloj pri la uzo de API.",
	'apisb-api-disabled' => 'API estas malŝalta en ĉi tiu retejo.',
	'apisb-legend-result' => 'Rezulto',
	'apisb-legend-generic-parameters' => 'Komunaj parametroj',
	'apisb-legend-generator-parameters' => 'Generanto',
	'apisb-result-request-url' => 'Mendi URL-on.',
	'apisb-result-request-post' => 'POST-datumoj:',
	'apisb-select-action' => 'Elekti agojn',
	'apisb-select-query' => 'Kion peti?',
	'apisb-select-value' => 'Elekti valoron',
	'apisb-loading' => 'Ŝarĝante...',
	'apisb-load-error' => 'Okazis eraro dum ŝargado de la API-priskribo',
	'apisb-request-error' => 'Okazis eraro dum efektivigo de la API-peto',
	'apisb-namespaces-error' => 'Okazis eraro dum ŝargado de la nomspacoj',
	'apisb-ns-main' => '(Ĉefa)',
	'apisb-submit' => 'Fari mendon',
	'apisb-query-prop' => 'Atributoj',
	'apisb-query-list' => 'Listoj',
	'apisb-query-meta' => 'Metainformoj',
);

/** Spanish (Español)
 * @author Armando-Martin
 * @author Fitoschido
 * @author Imre
 * @author Platonides
 * @author Pvgreenzebra
 */
$messages['es'] = array(
	'apisb-desc' => 'Permite depurar llamadas a la [//www.mediawiki.org/wiki/API API de MediaWiki] desde el navegador',
	'apisandbox' => 'Zona de pruebas API',
	'apisb-no-js' => "'''Error ''': esta característica requiere JavaScript.",
	'apisb-intro' => "Utilice está página para experimentar con el '''API de MediaWiki'''.

Consulte [//www.mediawiki.org/wiki/API:Main_page la documentación API] para más detalles sobre su uso. Ejemplo: [//www.mediawiki.org/wiki/API#A_simple_example accede al contenido de una página principal].  Seleccione una acción para ver más ejemplos.",
	'apisb-api-disabled' => 'La API está desactivada en este sitio.',
	'apisb-legend-parameters' => 'Parámetros',
	'apisb-legend-result' => 'Resultado',
	'apisb-legend-generic-parameters' => 'Parámetros genéricos',
	'apisb-legend-generator-parameters' => 'Generador',
	'apisb-result-request-url' => 'URL solicitante:',
	'apisb-result-request-post' => 'Datos POST:',
	'apisb-select-action' => 'Selecciona acción',
	'apisb-select-query' => '(Seleccione la consulta)',
	'apisb-select-value' => '(Seleccione el valor)',
	'apisb-docs-more' => 'Leer más',
	'apisb-params-param' => 'Parámetro',
	'apisb-params-input' => 'Entrada',
	'apisb-params-desc' => 'Descripción',
	'apisb-loading' => 'Cargando...',
	'apisb-load-error' => 'Error al cargar la descripción de la API',
	'apisb-request-error' => 'Error al realizar la solicitud de API',
	'apisb-namespaces-error' => 'Error al cargar los espacios de nombres',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Realizar solicitud',
	'apisb-query-prop' => 'Propiedades',
	'apisb-query-list' => 'Listas',
	'apisb-query-meta' => 'información de Meta',
	'apisb-example' => 'Ejemplo',
	'apisb-examples' => 'Ejemplos',
	'apisb-clear' => 'Limpiar',
);

/** Estonian (Eesti)
 * @author Pikne
 */
$messages['et'] = array(
	'apisb-desc' => 'Võimaldab veebilehitseja kaudu tehtud [//www.mediawiki.org/wiki/API MediaWiki API] päringutest vigu leida.',
	'apisandbox' => 'API-liivakast',
	'apisb-no-js' => "'''Tõrge''': Selle funktsiooni jaoks on JavaScripti vaja.",
	'apisb-intro' => "Kasuta seda lehekülge '''MediaWiki API''' katsetamiseks.
Üksikasjad API kasutamise kohta leiad [//www.mediawiki.org/wiki/API:Main_page API dokumentatsioonist]. Näide: [//www.mediawiki.org/wiki/API#A_simple_example esilehe sisu hankimine]. Vali toiming, et näha veel näiteid.",
	'apisb-api-disabled' => 'API on selles võrgukohas keelatud.',
	'apisb-legend-parameters' => 'Parameetrid',
	'apisb-legend-result' => 'Tulemus',
	'apisb-legend-generic-parameters' => 'Üldised parameetrid',
	'apisb-legend-generator-parameters' => 'Generaator',
	'apisb-result-request-url' => 'Päringu URL:',
	'apisb-result-request-post' => 'POST-andmed:',
	'apisb-select-action' => 'Vali toiming',
	'apisb-select-query' => '(vali päring)',
	'apisb-select-value' => '(vali väärtus)',
	'apisb-docs-more' => 'loe veel',
	'apisb-params-param' => 'Parameeter',
	'apisb-params-input' => 'Sisend',
	'apisb-params-desc' => 'Kirjeldus',
	'apisb-loading' => 'Laadimine...',
	'apisb-load-error' => 'API kirjelduse laadimisel esines tõrge',
	'apisb-request-error' => 'API-päringu sooritamisel esines tõrge',
	'apisb-namespaces-error' => 'Nimeruumide laadimisel esines tõrge',
	'apisb-submit' => 'Tee päring',
	'apisb-query-prop' => 'Atribuudid',
	'apisb-query-list' => 'Loendid',
	'apisb-query-meta' => 'Metaandmed',
	'apisb-example' => 'Näide',
	'apisb-examples' => 'Näited',
	'apisb-clear' => 'Puhasta',
);

/** Basque (Euskara)
 * @author An13sa
 */
$messages['eu'] = array(
	'apisb-loading' => 'Kargatzen…',
	'apisb-query-list' => 'Zerrendak',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Leyth
 * @author Mjbmr
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'apisb-desc' => 'اشکال‌یابی فراخوانی‌های [//www.mediawiki.org/wiki/API رابط برنامه‌نویسی مدیاویکی] را از طریق مرورگر اجازه می‌دهد',
	'apisandbox' => 'گودال ماسه‌بازی رابط برنامه‌نویسی',
	'apisb-no-js' => "'''خطا''': این قابلیت نیازمند جاوااسکریپت است.",
	'apisb-api-disabled' => 'رابط برنامه‌نویسی در این تارنما غیرفعال شده‌است.',
	'apisb-legend-result' => 'نتیجه',
	'apisb-legend-generic-parameters' => 'پارامترهای عمومی',
	'apisb-legend-generator-parameters' => 'تولیدکننده',
	'apisb-result-request-url' => 'درخواست آدرس:',
	'apisb-result-request-post' => 'فرستادن داده‌ها:',
	'apisb-select-action' => 'انتخاب اقدامات',
	'apisb-select-value' => 'انتخاب مقدار',
	'apisb-loading' => 'در حال بارگذاری…',
	'apisb-load-error' => 'خطا در بارگذاری توضیحات ای‌پی‌آی',
	'apisb-request-error' => 'خطا در اجرای درخواست ای‌پی‌آی',
	'apisb-namespaces-error' => 'خطا در بارگذاری فضاهای نام',
	'apisb-ns-main' => '(اصلی)',
	'apisb-submit' => 'ایجاد درخواست',
	'apisb-query-prop' => 'ویژگی‌ها',
	'apisb-query-list' => 'فهرست‌ها',
	'apisb-query-meta' => 'اطلاعات متا',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nedergard
 * @author Olli
 */
$messages['fi'] = array(
	'apisb-desc' => '[//www.mediawiki.org/wiki/API MediaWiki API] -kyselyjen virheenkorjausmahdollisuus',
	'apisandbox' => 'API-hiekkalaatikko',
	'apisb-no-js' => "'''Virhe:''' Tämä ominaisuus vaatii JavaScriptin.",
	'apisb-intro' => "Tämä on '''MediaWiki API:n''' hiekkalaatikko.
[//www.mediawiki.org/wiki/API:Main_page API-dokumentaatio] kertoo lisää API:en käytöstä.",
	'apisb-api-disabled' => 'API on poistettu käytöstä tällä sivustolla.',
	'apisb-legend-result' => 'Tulos',
	'apisb-legend-generic-parameters' => 'Yleiset parametrit',
	'apisb-legend-generator-parameters' => 'Generoija',
	'apisb-result-request-url' => 'Pyynnön URL',
	'apisb-result-request-post' => 'POST-tiedot',
	'apisb-select-action' => '(valitse toiminto)',
	'apisb-select-query' => '(valitse kysely)',
	'apisb-select-value' => '(valitse arvo)',
	'apisb-docs-more' => 'lue lisää',
	'apisb-params-desc' => 'Kuvaus',
	'apisb-loading' => 'Ladataan...',
	'apisb-load-error' => 'API-kuvauksen latausvirhe',
	'apisb-request-error' => 'API-pyynnön suoritusvirhe',
	'apisb-namespaces-error' => 'Virhe ladattaessa nimiavaruuksia',
	'apisb-ns-main' => '(pää)',
	'apisb-submit' => 'Tee pyyntö',
	'apisb-query-prop' => 'Ominaisuudet',
	'apisb-query-list' => 'Luettelot',
	'apisb-query-meta' => 'Metatiedot',
	'apisb-example' => 'Esimerkki',
	'apisb-examples' => 'Esimerkit',
	'apisb-clear' => 'Tyhjennä',
);

/** French (Français)
 * @author Balzac 40
 * @author Crochet.david
 * @author Gomoko
 * @author Grondin
 * @author IAlex
 * @author Jean-Frédéric
 * @author Verdy p
 */
$messages['fr'] = array(
	'apisb-desc' => 'Permet de déboguer les appels de l’[//www.mediawiki.org/wiki/API API de MediaWiki] à partir du navigateur',
	'apisandbox' => 'Bac à sable API',
	'apisb-no-js' => "''' Erreur ''': cette fonctionnalité nécessite JavaScript.",
	'apisb-intro' => "Utilisez cette page pour expérimenter le '''webservice MediaWiki'''.
Reportez-vous à [//www.mediawiki.org/wiki/API:Main_page la documentation de l’API] pour plus de détails sur l’API. Exemple: [//www.mediawiki.org/wiki/API#A_simple_example obtenir le contenu d'une page principale]. Choisissez une option pour voir d'autres exemples.",
	'apisb-api-disabled' => 'API est désactivé sur ce site.',
	'apisb-legend-parameters' => 'Paramètres',
	'apisb-legend-result' => 'Résultat',
	'apisb-legend-generic-parameters' => 'Paramètres génériques',
	'apisb-legend-generator-parameters' => 'Générateur',
	'apisb-result-request-url' => 'Requête URL :',
	'apisb-result-request-post' => 'données POST :',
	'apisb-select-action' => 'Sélectionner une action',
	'apisb-select-query' => '(choisir la requête)',
	'apisb-select-value' => '(choisir la valeur)',
	'apisb-docs-more' => 'en savoir plus',
	'apisb-params-param' => 'Paramètre',
	'apisb-params-input' => 'Entrée',
	'apisb-params-desc' => 'Description',
	'apisb-loading' => 'Chargement...',
	'apisb-load-error' => 'Erreur lors du chargement de description de l’API',
	'apisb-request-error' => "Erreur lors de l'exécution d'une requête API",
	'apisb-namespaces-error' => 'Erreur lors du chargement des espaces de noms',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Faire la demande',
	'apisb-query-prop' => 'Propriétés',
	'apisb-query-list' => 'Listes',
	'apisb-query-meta' => 'Méta-information',
	'apisb-example' => 'Exemple',
	'apisb-examples' => 'Exemples',
	'apisb-clear' => 'Effacer',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'apisb-desc' => 'Pèrmèt d’èliminar les cofieries des apèls de l’[//www.mediawiki.org/wiki/API API de MediaWiki] dês lo navigator.',
	'apisandbox' => 'Bouèta de sabla API',
	'apisb-no-js' => "'''Èrror :''' cela fonccionalitât at fôta de JavaScript.",
	'apisb-intro' => "Utilisâd ceta pâge por èxpèrimentar avouéc '''MediaWiki API'''.
Reportâd-vos sur [//www.mediawiki.org/wiki/API:Main_page la documentacion de l’API] por més de dètalys sur l’usâjo de l’API.",
	'apisb-api-disabled' => 'API est dèsactivâ sur ceti seto.',
	'apisb-legend-result' => 'Rèsultat',
	'apisb-legend-generic-parameters' => 'Paramètres g·ènèricos',
	'apisb-legend-generator-parameters' => 'G·ènèrator',
	'apisb-result-request-url' => 'Requéta URL :',
	'apisb-result-request-post' => 'Balyês POST :',
	'apisb-select-action' => 'Chouèsir una accion',
	'apisb-select-query' => 'Que fôt-o entèrrogiér ?',
	'apisb-select-value' => 'Chouèsir la valor',
	'apisb-loading' => 'Chargement...',
	'apisb-load-error' => 'Èrror pendent lo chargement de la dèscripcion de l’API',
	'apisb-request-error' => 'Èrror pendent l’ègzécucion d’una requéta API',
	'apisb-namespaces-error' => 'Èrror pendent lo chargement des èspâços de noms',
	'apisb-ns-main' => '(Principâl)',
	'apisb-submit' => 'Fâre la demanda',
	'apisb-query-prop' => 'Propriètâts',
	'apisb-query-list' => 'Listes',
	'apisb-query-meta' => 'Mèta-enformacions',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'apisb-desc' => 'Permite a depuración das chamadas da [//www.mediawiki.org/wiki/API API de MediaWiki] desde o navegador',
	'apisandbox' => 'Zona de probas API',
	'apisb-no-js' => "'''Erro:''' Esta característica necesita JavaScript.",
	'apisb-intro' => "Use esta páxina para experimentar co '''servizo web da API de MediaWiki'''.
Consulte a [//www.mediawiki.org/wiki/API:Main_page documentación da API] para obter máis información sobre o uso da API. Exemplo: [//www.mediawiki.org/wiki/API#A_simple_example obter o contido dunha páxina de inicio]. Seleccione unha acción para ollar máis exemplos.",
	'apisb-api-disabled' => 'API está desactivado neste sitio.',
	'apisb-legend-parameters' => 'Parámetros',
	'apisb-legend-result' => 'Resultado',
	'apisb-legend-generic-parameters' => 'Parámetros xenéricos',
	'apisb-legend-generator-parameters' => 'Xerador',
	'apisb-result-request-url' => 'URL da solicitude:',
	'apisb-result-request-post' => 'Datos POST:',
	'apisb-select-action' => 'Seleccionar unha acción',
	'apisb-select-query' => '(seleccione a consulta)',
	'apisb-select-value' => '(seleccione o valor)',
	'apisb-docs-more' => 'ler máis',
	'apisb-params-param' => 'Parámetro',
	'apisb-params-input' => 'Entrada',
	'apisb-params-desc' => 'Descrición',
	'apisb-loading' => 'Cargando...',
	'apisb-load-error' => 'Erro ao cargar a descrición API',
	'apisb-request-error' => 'Erro ao executar a solicitude API',
	'apisb-namespaces-error' => 'Erro ao cargar o espazo de nomes',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Facer a solicitude',
	'apisb-query-prop' => 'Propiedades',
	'apisb-query-list' => 'Listas',
	'apisb-query-meta' => 'Metainformación',
	'apisb-example' => 'Exemplo',
	'apisb-examples' => 'Exemplos',
	'apisb-clear' => 'Limpar',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Deror avi
 * @author Ofekalef
 */
$messages['he'] = array(
	'apisb-desc' => 'הפעלת ניפוי שגיאות של קריאות ל־[//www.mediawiki.org/wiki/API API של מדיה־ויקי] מהדפדפן',
	'apisandbox' => 'ארגז חול של API',
	'apisb-no-js' => "'''שגיאה''': היכולת הזאת דורשת JavaScript",
	'apisb-intro' => "השתמשו בדף הזה כדי להתנסות עם '''API של מדיה־ויקי'''.
פנו ל־[//www.mediawiki.org/wiki/API:Main_page תיעוד של ה־API] למידע נוסף של שימוש ב־API (באנגלית). למשל: [//www.mediawiki.org/wiki/API#A_simple_example איך לקבל את התוכן של הדף הראשי]. בחרו בפעולה (action) לדוגמאות נוספות.",
	'apisb-api-disabled' => 'API אינו פעיל באתר הזה.',
	'apisb-legend-parameters' => 'פרמטרים',
	'apisb-legend-result' => 'תוצאה',
	'apisb-legend-generic-parameters' => 'פרמטרים כלליים',
	'apisb-legend-generator-parameters' => 'מחולל',
	'apisb-result-request-url' => 'כתובת ה-URL של הבקשה:',
	'apisb-result-request-post' => 'נתוני POST:',
	'apisb-select-action' => 'בחירת פעולה',
	'apisb-select-query' => '(בחירת שאילתה)',
	'apisb-select-value' => '(בחירת ערך)',
	'apisb-docs-more' => 'לקרוא עוד',
	'apisb-params-param' => 'פרמטר',
	'apisb-params-input' => 'קלט',
	'apisb-params-desc' => 'תיאור',
	'apisb-loading' => 'בטעינה...',
	'apisb-load-error' => 'שגיאה בטעינת תיאור API',
	'apisb-request-error' => 'שגיעה בביצוע בקשת API',
	'apisb-namespaces-error' => 'שגיעה בטעינת שם מתחם',
	'apisb-ns-main' => '(ראשי)',
	'apisb-submit' => 'ביצוע שאילתה',
	'apisb-query-prop' => 'מאפיינים',
	'apisb-query-list' => 'רשימות',
	'apisb-query-meta' => 'מידע נוסף',
	'apisb-example' => 'דוגמה',
	'apisb-examples' => 'דוגמאות',
	'apisb-clear' => 'ריקון',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'apisandbox' => 'एपीआई सांडबॉक्स',
	'apisb-legend-result' => 'परिणाम',
	'apisb-legend-generic-parameters' => 'जेनेरिक पैरामीटर्स',
	'apisb-legend-generator-parameters' => 'जेनरेटर',
	'apisb-result-request-url' => 'अनुरोध URL:',
	'apisb-result-request-post' => 'डेटा भेजें:',
	'apisb-select-action' => 'क्रिया चयन करें',
	'apisb-select-query' => 'क्वेरी क्या करना है?',
	'apisb-select-value' => 'मूल्य चयन करें',
	'apisb-loading' => 'लोड हो रहा है...',
	'apisb-namespaces-error' => 'नेमस्पेस लोड़ होने में त्रुटि',
	'apisb-ns-main' => '(मुख्य)',
	'apisb-submit' => 'अनुरोध करना',
	'apisb-query-prop' => 'गुणधर्म',
	'apisb-query-list' => 'सूचियाँ',
	'apisb-query-meta' => 'मेटा जानकारी',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'apisb-desc' => 'Zmóžnja wotstronjenje zmylkow při wołanju [//www.mediawiki.org/wiki/API MediaWiki API] z wobhladowaka',
	'apisandbox' => 'API-hrajkanišćo',
	'apisb-no-js' => "'''Zmylk''': tuta funkcija sej JavaScript wužaduje.",
	'apisb-intro' => "Wužij tutu stronu, zo by z '''websłužbu Mediawiki API''' eksperimentował.
Hlej [//www.mediawiki.org/wiki/API:Main_page API-dokumentaciju] za dalše podrobnosće za wužiwanje API. Přikład: [//www.mediawiki.org/wiki/API#A_simple_example Wobsah hłowneje strony wotwołać]. Wubjer akciju, zo by dalše přikłady widźał.",
	'apisb-api-disabled' => 'API je so na tutym sydle znjemóžnił.',
	'apisb-legend-parameters' => 'Parametry',
	'apisb-legend-result' => 'Wuslědk',
	'apisb-legend-generic-parameters' => 'Powšitkowne parametry',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'URL naprašowanja:',
	'apisb-result-request-post' => 'POST-daty:',
	'apisb-select-action' => 'Akciju wubrać',
	'apisb-select-query' => '(naprašowanje wubrać)',
	'apisb-select-value' => '(Hódnotu wubrać)',
	'apisb-docs-more' => 'dalše informacije',
	'apisb-params-param' => 'Parameter',
	'apisb-params-input' => 'Zapodaće',
	'apisb-params-desc' => 'Wopisanje',
	'apisb-loading' => 'Začituje so...',
	'apisb-load-error' => 'Zmylk při začitowanju API-wopisanja',
	'apisb-request-error' => 'Zmylk při přewjedźenju API-naprašowanja',
	'apisb-namespaces-error' => 'Zmylk při začitowanju mjenowych rumow',
	'apisb-ns-main' => '(Nastawki)',
	'apisb-submit' => 'Naprašowanje přewjesć',
	'apisb-query-prop' => 'Kajkosće',
	'apisb-query-list' => 'Lisćiny',
	'apisb-query-meta' => 'Metainformacije',
	'apisb-example' => 'Přikład',
	'apisb-examples' => 'Přikłady',
	'apisb-clear' => 'Wuprózdnić',
);

/** Hungarian (Magyar)
 * @author Bináris
 * @author Dj
 */
$messages['hu'] = array(
	'apisb-desc' => 'Lehetőséget biztosít az [//www.mediawiki.org/wiki/API MediaWiki API] hívások nyomkövetésére a böngészőből',
	'apisandbox' => 'API homokozó',
	'apisb-no-js' => "'''Hiba''': ehhez a szolgáltatáshoz JavaScript szükséges.",
	'apisb-intro' => "Ezen az oldalon kísérletezhetsz a '''MediaWiki web service API'''-val.
A használattal kapcsolatos további részletek az [//www.mediawiki.org/wiki/API:Main_page API-dokumentációnál] találhatók. Példa: [//www.mediawiki.org/wiki/API#A_simple_example olvasd el a főoldal tartalomjegyzékét]. További példákért válassz egy tevékenységet!",
	'apisb-api-disabled' => 'API le van tiltva ezen az oldalon.',
	'apisb-legend-parameters' => 'Paraméterek',
	'apisb-legend-result' => 'Eredmény',
	'apisb-legend-generic-parameters' => 'Általános paraméterek',
	'apisb-legend-generator-parameters' => 'Generátor',
	'apisb-result-request-url' => 'Kérő URL:',
	'apisb-result-request-post' => 'POST adat:',
	'apisb-select-action' => 'Műveletek kiválasztása',
	'apisb-select-query' => '(válassz lekérdezést)',
	'apisb-select-value' => '(válassz értéket)',
	'apisb-docs-more' => 'tudj meg többet',
	'apisb-params-param' => 'Paraméter',
	'apisb-params-input' => 'Input',
	'apisb-params-desc' => 'Leírás',
	'apisb-loading' => 'Betöltés…',
	'apisb-load-error' => 'Hiba a API leírás betöltésekor',
	'apisb-request-error' => 'Hiba az API kérés végrehajtásakor',
	'apisb-namespaces-error' => 'Hiba a névtér betöltése során',
	'apisb-ns-main' => '(Fő)',
	'apisb-submit' => 'Kérés végrehajtása',
	'apisb-query-prop' => 'Tulajdonságok',
	'apisb-query-list' => 'Listák',
	'apisb-query-meta' => 'Metaadatok',
	'apisb-example' => 'Példa',
	'apisb-examples' => 'Példák',
	'apisb-clear' => 'Törlés',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'apisb-desc' => 'Permitte cercar defectos in appellos del [//www.mediawiki.org/wiki/API API de MediaWiki] ab le navigator del web',
	'apisandbox' => 'Cassa de sablo pro API',
	'apisb-no-js' => "'''Error''': iste function require JavaScript.",
	'apisb-intro' => "Usa iste pagina pro experimentar con le '''API de servicio web de MediaWiki'''.
Consulta [//www.mediawiki.org/wiki/API:Main_page le documentation del API] pro ulterior detalios concernente le uso del API. Per exemplo: [//www.mediawiki.org/wiki/API#A_simple_example obtener le contento de un Pagina principal]. Selige un action pro vider altere exemplos.",
	'apisb-api-disabled' => 'Le API ha essite disactivate in iste sito.',
	'apisb-legend-parameters' => 'Parametros',
	'apisb-legend-result' => 'Resultato',
	'apisb-legend-generic-parameters' => 'Parametros generic',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'URL de requesta:',
	'apisb-result-request-post' => 'Datos POST:',
	'apisb-select-action' => 'Selige action',
	'apisb-select-query' => '(selige consulta)',
	'apisb-select-value' => '(selige valor)',
	'apisb-docs-more' => 'leger plus',
	'apisb-params-param' => 'Parametro',
	'apisb-params-input' => 'Entrata',
	'apisb-params-desc' => 'Description',
	'apisb-loading' => 'Cargamento…',
	'apisb-load-error' => 'Error durante le cargamento del description del API',
	'apisb-request-error' => 'Error durante le execution del requesta al API',
	'apisb-namespaces-error' => 'Error durante le cargamento del spatios de nomines',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Facer requesta',
	'apisb-query-prop' => 'Proprietates',
	'apisb-query-list' => 'Listas',
	'apisb-query-meta' => 'Metainformationes',
	'apisb-example' => 'Exemplo',
	'apisb-examples' => 'Exemplos',
	'apisb-clear' => 'Rader',
);

/** Indonesian (Bahasa Indonesia)
 * @author Anakmalaysia
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'apisb-desc' => 'Menyediakan fasilitas debug untuk pemanggilan [//www.mediawiki.org/wiki/API API MediaWiki] dari peramban',
	'apisandbox' => 'Bak pasir API',
	'apisb-no-js' => "'''Galat''': fitur ini memerlukan JavaScript.",
	'apisb-intro' => "Gunakan halaman ini untuk bereksperimen dengan '''MediaWiki API'''.
Lihat [//www.mediawiki.org/wiki/API:Main_page dokumentasi API] untuk perincian lanjut penggunaan API.",
	'apisb-api-disabled' => 'API dinonaktifkan pada situs ini.',
	'apisb-legend-result' => 'Hasil',
	'apisb-legend-generic-parameters' => 'Parameter generik',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'URL Permintaan:',
	'apisb-result-request-post' => 'Data POST:',
	'apisb-select-action' => 'Pilih tindakan',
	'apisb-select-query' => '(pilih permintaan)',
	'apisb-select-value' => '(pilih nilai)',
	'apisb-params-param' => 'Parameter',
	'apisb-params-input' => 'Masukan',
	'apisb-params-desc' => 'Keterangan',
	'apisb-loading' => 'Memuat...',
	'apisb-load-error' => 'Galat sewaktu memuat deskripsi API',
	'apisb-request-error' => 'Galat sewaktu melakukan permintaan API',
	'apisb-namespaces-error' => 'Galat sewaktu memuat ruang nama',
	'apisb-ns-main' => '(Utama)',
	'apisb-submit' => 'Kirim permintaan',
	'apisb-query-prop' => 'Properti',
	'apisb-query-list' => 'Daftar',
	'apisb-query-meta' => 'Informasi meta',
	'apisb-example' => 'Contoh',
	'apisb-examples' => 'Contoh',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'apisb-desc' => 'Agpalubos ti panag-kkat ti kiteb [//www.mediawiki.org/wiki/API MediaWiki API] a dagiti mangaw-awag manipud idiay pagbasabasa',
	'apisandbox' => 'API a pagpsubokan',
	'apisb-no-js' => "''Biddut''': daytoy a langa ket makasapul ti JavaScript.",
	'apisb-intro' => "Usaren daytoy a panid ti panagsubok ti '''MediaWiki apot a serbisio ti API'''.
Agiturong idiay [//www.mediawiki.org/wiki/API:Main_page the API dokumentasion] para iti adadu pay a detalye iti panag-usar ti API. Kas pagarigan: [//www.mediawiki.org/wiki/API#A_simple_example alaen ti linaon ti Umuna a Panid].  Agpili ti maaramid tapno makakita ti adu pay a kas pagarigan.",
	'apisb-api-disabled' => 'Ti API ket nabaldodo iti daytoy a pagsaadan.',
	'apisb-legend-result' => 'Nagbanagan',
	'apisb-legend-generic-parameters' => 'Dagiti kadawyan a parametro',
	'apisb-legend-generator-parameters' => 'Agpaandar',
	'apisb-result-request-url' => 'Agkiddaw ti URL:',
	'apisb-result-request-post' => 'POST data:',
	'apisb-select-action' => 'Agpili ti aramid',
	'apisb-select-query' => 'Ania ti damdamagen?',
	'apisb-select-value' => 'Agpili ti kuwenta',
	'apisb-loading' => 'Agkarkarga...',
	'apisb-load-error' => 'Biddut ti panagkarga ti deskripsion ti API',
	'apisb-request-error' => 'Biddut i panagtungpal ti kiniddaw nga API',
	'apisb-namespaces-error' => 'Biddut ti panag-karga dagiti nagan ti lugar',
	'apisb-ns-main' => '(Umuna)',
	'apisb-submit' => 'Agaramid ti kiddaw',
	'apisb-query-prop' => 'Dagiti tagikua',
	'apisb-query-list' => 'Dagiti listaan',
	'apisb-query-meta' => 'Pakaammo a meta',
	'apisb-example' => 'Kas pagarigan',
	'apisb-examples' => 'Dagiti kas pagarigan',
	'apisb-clear' => 'Dalusan',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author Beta16
 * @author F. Cosoleto
 * @author Gianfranco
 * @author Rippitippi
 */
$messages['it'] = array(
	'apisb-desc' => 'Permette di eseguire il debug delle chiamate [//www.mediawiki.org/wiki/API MediaWiki API] dal browser',
	'apisandbox' => 'Sandbox API',
	'apisb-no-js' => "'''Errore''': questa funzione richiede JavaScript.",
	'apisb-intro' => "Utilizza questa pagina per sperimentare con '''MediaWiki API'''.
Per ulteriori dettagli di utilizzo delle API, fai riferimento alla [//www.mediawiki.org/wiki/API:Main_page documentazione API].",
	'apisb-api-disabled' => 'Le funzionalità API sono disabilitate su questo sito.',
	'apisb-legend-result' => 'Risultato',
	'apisb-legend-generic-parameters' => 'Parametri generici',
	'apisb-legend-generator-parameters' => 'Generatore',
	'apisb-result-request-url' => 'URL di richiesta:',
	'apisb-result-request-post' => 'Dati POST:',
	'apisb-select-action' => 'Seleziona azione',
	'apisb-select-query' => 'Che cosa?',
	'apisb-select-value' => 'Selezionare il valore',
	'apisb-loading' => 'Caricamento in corso...',
	'apisb-load-error' => 'Errore durante il caricamento descrizione API',
	'apisb-request-error' => "Errore durante l'elaborazione della richiesta API",
	'apisb-namespaces-error' => 'Errore durante il caricamento dei namespace',
	'apisb-ns-main' => '(Principale)',
	'apisb-submit' => 'Inoltra richiesta',
	'apisb-query-prop' => 'Proprietà',
	'apisb-query-list' => 'Liste',
	'apisb-query-meta' => 'Informazioni meta',
);

/** Korean (한국어)
 * @author Kwj2772
 */
$messages['ko'] = array(
	'apisb-desc' => '브라우저에서 [//www.mediawiki.org/wiki/API 미디어위키 API] 호출을 디버그할 수 있도록 함',
	'apisandbox' => 'API 실험실',
	'apisb-no-js' => "'''오류''': 이 기능을 쓰려면 자바스크립트가 필요합니다.",
	'apisb-intro' => "'''미디어위키 웹 서비스 API'''를 시험해보려면 이 페이지를 이용해보세요.
사용법에 대해서는 [//www.mediawiki.org/wiki/API:Main_page API 사용법]을 참고해보십시오. 예시: [//www.mediawiki.org/wiki/API#A_simple_example 대문의 내용 요청하기]. 더 많은 예시를 보려면 동작을 선택하세요.",
	'apisb-api-disabled' => '이 사이트에서는 API가 꺼져 있습니다.',
	'apisb-legend-parameters' => '변수',
	'apisb-legend-result' => '결과',
	'apisb-legend-generic-parameters' => '일반 매개변수',
	'apisb-legend-generator-parameters' => '제네레이터',
	'apisb-result-request-url' => '요청 URL:',
	'apisb-result-request-post' => 'POST 데이터:',
	'apisb-select-action' => '동작을 선택하세요',
	'apisb-select-query' => '(쿼리 선택)',
	'apisb-select-value' => '(값 선택)',
	'apisb-docs-more' => '더 알아보기',
	'apisb-params-param' => '변수',
	'apisb-params-input' => '입력',
	'apisb-params-desc' => '설명',
	'apisb-loading' => '로딩중...',
	'apisb-load-error' => 'API 설명을 불러오는 중 오류가 발생했습니다',
	'apisb-request-error' => 'API 요청을 수행하는 중 오류가 발생했습니다',
	'apisb-namespaces-error' => '이름공간을 불러오는 중 오류가 발생했습니다',
	'apisb-ns-main' => '(문서)',
	'apisb-submit' => '요청하기',
	'apisb-query-prop' => '속성',
	'apisb-query-list' => '목록',
	'apisb-query-meta' => '메타 정보',
	'apisb-example' => '예시',
	'apisb-examples' => '예시',
	'apisb-clear' => '지우기',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'apisb-desc' => 'Hellef noh Fähler ze söhke bei [//www.mediawiki.org/wiki/API MediaWiki <i lang="en">API</i>] Oprohfe uss_em Brauser.',
	'apisb-parameters' => 'Parrameetere',
	'apisb-result' => 'Erus jekumme es',
	'apisb-request-url' => 'Dä URL vun dä Aanfrooch:',
	'apisb-query-prop' => 'Eijeschafte',
	'apisb-query-list' => 'Leste',
);

/** Kurdish (Latin script) (Kurdî (latînî))
 * @author George Animal
 */
$messages['ku-latn'] = array(
	'apisb-parameters' => 'Parametre',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'apisandbox' => 'API-Sandkëscht',
	'apisb-no-js' => "'''Feeler''': dës Fonctioun brauch JavaScript",
	'apisb-api-disabled' => 'API ass op dësem Site ausgeschalt.',
	'apisb-legend-parameters' => 'Parameteren',
	'apisb-legend-result' => 'Resultat',
	'apisb-result-request-url' => 'URL fir Ufroen:',
	'apisb-select-action' => 'Aktioun eraussichen',
	'apisb-select-value' => '(Wäert eraussichen)',
	'apisb-docs-more' => 'liest méi',
	'apisb-params-param' => 'Parameter',
	'apisb-params-desc' => 'Beschreiwung',
	'apisb-loading' => 'Lueden...',
	'apisb-load-error' => 'Feeler beim Luede vun der API- Beschreiwung',
	'apisb-namespaces-error' => 'Feeler beim Luede vun den Nummraim',
	'apisb-ns-main' => '(Haapt)',
	'apisb-submit' => 'Ufro maachen',
	'apisb-query-prop' => 'Eegeschaften',
	'apisb-query-list' => 'Lëschten',
	'apisb-query-meta' => 'Meta-Informatioun',
	'apisb-example' => 'Beispill',
	'apisb-examples' => 'Beispiller',
	'apisb-clear' => 'Eidel maachen',
);

/** Limburgish (Limburgs)
 * @author Pahles
 */
$messages['li'] = array(
	'apisb-desc' => "Maak 't mäögelik óm [//www.mediawiki.org/wiki/API API-verzeuke veur MediaWiki] vanoet 'ne browser te debugge",
	'apisandbox' => 'API-zandjbak',
	'apisb-no-js' => "'''Fout''': dees funktie vereis JavaScript.",
	'apisb-intro' => "Gebroek dees pagina óm te experimentere mit de '''MediaWiki API'''.
Zuuch de [//www.mediawiki.org/wiki/API:Main_page API-dokkemèntatie] veur mier details euver 't gebroek van de API.",
	'apisb-api-disabled' => 'API is oetgesjakeld op deze site.',
	'apisb-legend-result' => 'Rizzeltaat',
	'apisb-legend-generic-parameters' => 'Algemein parameters',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'Verzeuk-URL:',
	'apisb-result-request-post' => 'POST-gegaeves:',
	'apisb-select-action' => 'Hanjeling selektere',
	'apisb-select-query' => 'Wat is dien vraog?',
	'apisb-select-value' => 'Selekteer waerde',
	'apisb-loading' => 'Laje…',
	'apisb-load-error' => "Fout bie 't laje van de API-besjrieving",
	'apisb-request-error' => "Fout bie 't oetveure van 't API-verzeuk",
	'apisb-namespaces-error' => "Fout bie 't laje van de naamruumdes",
	'apisb-ns-main' => '(Hoofnaamruumde)',
	'apisb-submit' => 'Verzeuk oetveure',
	'apisb-query-prop' => 'Eigensjappe',
	'apisb-query-list' => 'Lieste',
	'apisb-query-meta' => 'Meta-infermasie',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Ignas693
 */
$messages['lt'] = array(
	'apisb-desc' => 'Leidžia derinti [MediaWiki API http://www.mediawiki.org/wiki/API] skambučių iš naršyklės',
	'apisandbox' => 'API smėlio dėžės',
	'apisb-no-js' => '"" Klaida "": ši funkcija reikalauja JavaScript.',
	'apisb-intro' => "Naudokite šį puslapį norėdami eksperimentuoti su '''MediaWiki API \"„.
	Ieškokite [//www.mediawiki.org/wiki/API:Main_page API dokumentacijoje] Išsamesnės informacijos apie API naudojimo.",
	'apisb-api-disabled' => 'API yra išjungtas šioje svetainėje.',
	'apisb-legend-result' => 'Rezultatai',
	'apisb-legend-generator-parameters' => 'Generatorius',
	'apisb-result-request-url' => 'Prašyti URL:',
	'apisb-result-request-post' => 'POST duomenys:',
	'apisb-select-action' => 'Pasirinkite veiksmą',
	'apisb-select-query' => 'Ką užklausą?',
	'apisb-select-value' => 'Pasirinkite vertę',
	'apisb-loading' => 'Kraunasi ...',
	'apisb-load-error' => 'Klaida įkeliant API aprašymas',
	'apisb-request-error' => 'Klaida scenos API prašymą',
	'apisb-namespaces-error' => 'Klaida pakrovimo vardų sritys',
	'apisb-ns-main' => '(Pagrindinė)',
	'apisb-submit' => 'Pateikti prašymą',
	'apisb-query-prop' => 'Nusttymai',
	'apisb-query-list' => 'Sąrašai',
	'apisb-query-meta' => 'Meta informacija',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 */
$messages['lv'] = array(
	'apisb-loading' => 'Ielādē…',
	'apisb-query-list' => 'Saraksti',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'apisb-desc' => 'Овозможува отстранување на грешки во повикувањата на [//www.mediawiki.org/wiki/API?uselang=mk посредникот за програмирање на прилози (API) на МедијаВики] од прелистувачот',
	'apisandbox' => 'API-песочница',
	'apisb-no-js' => "'''Грешка''': оваа функција бара JavaScript.",
	'apisb-intro' => "Страницава служи за експериментирање со '''МедијаВики API'''.
	Повеќе за употребата на овој API ќе најдете во [//www.mediawiki.org/wiki/API:Main_page неговата документација].  Пример: [//www.mediawiki.org/wiki/API#A_simple_example преземање на содржината на главната страница].  Одберете дејство за да видите повеќе примери.",
	'apisb-api-disabled' => 'API е оневозможен на ова мрежно место.',
	'apisb-legend-parameters' => 'Параметри',
	'apisb-legend-result' => 'Извод',
	'apisb-legend-generic-parameters' => 'Општи параметри',
	'apisb-legend-generator-parameters' => 'Создавач',
	'apisb-result-request-url' => 'URL на барањето:',
	'apisb-result-request-post' => 'POST-податоци:',
	'apisb-select-action' => 'Одберете дејство',
	'apisb-select-query' => '(изберете барање)',
	'apisb-select-value' => '(изерете вредност)',
	'apisb-docs-more' => 'прочитајте повеќе',
	'apisb-params-param' => 'Параметар',
	'apisb-params-input' => 'Внос',
	'apisb-params-desc' => 'Опис',
	'apisb-loading' => 'Вчитувам...',
	'apisb-load-error' => 'Грешка при вчитувањето на описот на API',
	'apisb-request-error' => 'Грешка при извршувањето на барањето од API',
	'apisb-namespaces-error' => 'Грешка при вчитувањето на именските простори',
	'apisb-ns-main' => '(Главен)',
	'apisb-submit' => 'Постави барање',
	'apisb-query-prop' => 'Својства',
	'apisb-query-list' => 'Списоци',
	'apisb-query-meta' => 'Метаинформации',
	'apisb-example' => 'Пример',
	'apisb-examples' => 'Примери',
	'apisb-clear' => 'Исчисти',
);

/** Malayalam (മലയാളം)
 * @author Junaidpv
 * @author Praveenp
 */
$messages['ml'] = array(
	'apisb-no-js' => "'''പിഴവ്''': ഈ വിശേഷഗുണത്തിനു ജാവാസ്ക്രിപ്റ്റ് ആവശ്യമാണ്.",
	'apisb-api-disabled' => 'ഈ സൈറ്റിൽ എ.പി.ഐ. പ്രവർത്തനരഹിതമാക്കിയിരിക്കുന്നു.',
	'apisb-legend-result' => 'ഫലം',
	'apisb-result-request-url' => 'അഭ്യർത്ഥിച്ച യൂ.ആർ.എൽ.:',
	'apisb-select-action' => 'പ്രവൃത്തി തിരഞ്ഞെടുക്കുക',
	'apisb-select-value' => 'വില തിരഞ്ഞെടുക്കുക',
	'apisb-docs-more' => 'കൂടുതൽ വായിക്കുക',
	'apisb-params-param' => 'ചരം',
	'apisb-params-desc' => 'വിവരണം',
	'apisb-loading' => 'ശേഖരിക്കുന്നു...',
	'apisb-ns-main' => '(മുഖ്യം)',
	'apisb-query-meta' => 'മെറ്റ വിവരങ്ങൾ',
	'apisb-example' => 'ഉദാഹരണം',
	'apisb-examples' => 'ഉദാഹരണങ്ങൾ',
	'apisb-clear' => 'ശൂന്യമാക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'apisb-desc' => 'Membolehkan penyahpepijatan panggilan [//www.mediawiki.org/wiki/API MediaWiki API] dari pelayar',
	'apisandbox' => 'Kotak pasir API',
	'apisb-no-js' => "'''Perhatian''': ciri ini memerlukan JavaScript.",
	'apisb-intro' => "Gunakan laman ini untuk bereksperimen dengan '''API perkhidmatan sesawang MediaWiki'''.
Rujuk [//www.mediawiki.org/wiki/API:Main_page dokumentasi API] untuk keterangan lanjut tentang penggunaan API.
Contoh: [//www.mediawiki.org/wiki/API#A_simple_example dapatkan kandungan Laman Utama].  Pilih satu tindakan untuk melihat banyak lagi contoh.",
	'apisb-api-disabled' => 'API dimatikan di tapak web ini.',
	'apisb-legend-parameters' => 'Parameter',
	'apisb-legend-result' => 'Hasil',
	'apisb-legend-generic-parameters' => 'Parameter am',
	'apisb-legend-generator-parameters' => 'Penjana',
	'apisb-result-request-url' => 'URL permohonan:',
	'apisb-result-request-post' => 'Data POST:',
	'apisb-select-action' => 'Pilih tindakan',
	'apisb-select-query' => '(pilih pertanyaan)',
	'apisb-select-value' => '(pilih nilai)',
	'apisb-docs-more' => 'baca lagi',
	'apisb-params-param' => 'Parameter',
	'apisb-params-input' => 'Input',
	'apisb-params-desc' => 'Keterangan',
	'apisb-loading' => 'Memuatkan...',
	'apisb-load-error' => 'Ralat ketika memuatkan keterangan API',
	'apisb-request-error' => 'Ralat ketika melakukan permohonan API',
	'apisb-namespaces-error' => 'Ralat ketika memuatkan ruang nama',
	'apisb-ns-main' => '(Utama)',
	'apisb-submit' => 'Buat permintaan',
	'apisb-query-prop' => 'Sifat',
	'apisb-query-list' => 'Senarai',
	'apisb-query-meta' => 'Maklumat meta',
	'apisb-example' => 'Contoh',
	'apisb-examples' => 'Contoh',
	'apisb-clear' => 'Padamkan',
);

/** Norwegian (bokmål) (Norsk (bokmål))
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'apisb-desc' => 'Tillater å feilsøke [//www.mediawiki.org/wiki/API MediaWiki API]-kall fra nettleseren',
	'apisandbox' => 'API-sandkasse',
	'apisb-no-js' => "'''Feil''': denne funksjonen krever JavaScript.",
	'apisb-intro' => "Bruk denne siden til å eksperimentere med '''MediaWiki API'''.
Sjekk [//www.mediawiki.org/wiki/API API-dokumentasjonen] for flere detaljer om bruk av API.",
	'apisb-api-disabled' => 'API er deaktivert på dette nettstedet.',
	'apisb-parameters' => 'Parametere',
	'apisb-result' => 'Resultat',
	'apisb-request-url' => 'Forespurt URL:',
	'apisb-request-post' => 'POST-data:',
	'apisb-select-action' => 'Velg handling',
	'apisb-select-query' => 'Hva skal du spørre etter?',
	'apisb-select-value' => 'Velg verdi',
	'apisb-loading' => 'Laster...',
	'apisb-load-error' => 'Feil under lasting av API-beskrivelse',
	'apisb-request-error' => 'Feil under utføring av API-forespørsel',
	'apisb-namespaces-error' => 'Feil under lasting av navnerom',
	'apisb-ns-main' => '(Hoved)',
	'apisb-submit' => 'Foreta en forespørsel',
	'apisb-query-prop' => 'Egenskaper',
	'apisb-query-list' => 'Lister',
	'apisb-query-meta' => 'Metainformasjon',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'apisb-desc' => 'Maakt het mogelijk om [//www.mediawiki.org/wiki/API API-verzoeken voor MediaWiki] vanuit een browser te debuggen',
	'apisandbox' => 'API-zandbak',
	'apisb-no-js' => "'''Fout''': deze functie vereist JavaScript.",
	'apisb-intro' => "Gebruik deze pagina om te experimenteren met de '''MediaWiki-API'''.
Zie de [//www.mediawiki.org/wiki/API:Main_page API-documentatie] voor verdere details over het gebruik van de API. Voorbeeld: [//www.mediawiki.org/wiki/API#A_simple_example hoe de inhoud van een Hoofdpagina ophalen]. Selecteer een handeling om meer voorbeelden te zien.",
	'apisb-api-disabled' => 'API is uitgeschakeld op deze site.',
	'apisb-legend-parameters' => 'Parameters',
	'apisb-legend-result' => 'Resultaat',
	'apisb-legend-generic-parameters' => 'Algemene parameters',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'Verzoek-URL:',
	'apisb-result-request-post' => 'POST-gegevens:',
	'apisb-select-action' => 'Handeling selecteren',
	'apisb-select-query' => '(selecteer zoekopdracht)',
	'apisb-select-value' => '(selecteer waarde)',
	'apisb-docs-more' => 'meer lezen',
	'apisb-params-param' => 'Parameter',
	'apisb-params-input' => 'Invoer',
	'apisb-params-desc' => 'Beschrijving',
	'apisb-loading' => 'Bezig met laden…',
	'apisb-load-error' => 'Fout bij het laden van de API-beschrijving',
	'apisb-request-error' => 'Fout bij het uitvoeren van het API-verzoek',
	'apisb-namespaces-error' => 'Fout laden bij het laden van de naamruimten',
	'apisb-ns-main' => '(Hoofdnaamruimte)',
	'apisb-submit' => 'Verzoek uitvoeren',
	'apisb-query-prop' => 'Eigenschappen',
	'apisb-query-list' => 'Lijsten',
	'apisb-query-meta' => 'Metaigegevens',
	'apisb-example' => 'Voorbeeld',
	'apisb-examples' => 'Voorbeelden',
	'apisb-clear' => 'Leegmaken',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'apisb-desc' => 'ବ୍ରାଉଜରରୁ [//www.mediawiki.org/wiki/API MediaWiki API]ରେ ଥିବା ଅସୁବିଧାକୁ ସୁଧାରିବା ପାଇଁ ଅନୁମତି ଦେବେ',
	'apisandbox' => 'API ପରଖଘର',
	'apisb-no-js' => "'''ଭୁଲ''': ଏହି ସୁବିଧା ପାଇଁ JavaScript ଲୋଡ଼ା ।",
	'apisb-api-disabled' => 'API ଟି ଏହି ସାଇଟରେ ଅଚଳ କରାଯାଇଛି ।',
	'apisb-legend-result' => 'ପରିଣାମ',
	'apisb-legend-generic-parameters' => 'ସାଧାରଣ ମୂଲ୍ୟାଙ୍କ',
	'apisb-legend-generator-parameters' => 'ଉତ୍ପାଦକ',
	'apisb-result-request-url' => 'URL ଅନୁରୋଧ କରିବେ:',
	'apisb-result-request-post' => 'POST ତଥ୍ୟ:',
	'apisb-select-action' => 'କାମ ବାଛିବେ',
	'apisb-select-query' => 'ପ୍ରଶ୍ନଟି କଣ?',
	'apisb-select-value' => 'ମୂଲ୍ୟ ବାଛିବେ',
	'apisb-loading' => 'ଲୋଡ଼ ହେଉଛି...',
	'apisb-load-error' => 'API ବିବରଣୀ ଲୋଡ଼ କରିବାରେ ଅସୁବିଧା',
	'apisb-request-error' => 'API ଅନୁରୋଧ କାର୍ଯ୍ୟକାରୀ କରିବାରେ ଅସୁବିଧା',
	'apisb-namespaces-error' => 'ନେମସ୍ପେସ ଲୋଡ଼ କରିବାରେ ଅସୁବିଧା',
	'apisb-ns-main' => '(ମୂଳ)',
	'apisb-submit' => 'ଅନୁରୋଧ କରିବେ',
	'apisb-query-prop' => 'ସଜାଣି',
	'apisb-query-list' => 'ତାଲିକା',
	'apisb-query-meta' => 'ମେଟା ତଥ୍ୟ',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'apisb-ns-main' => '(Bledder)',
);

/** Polish (Polski)
 * @author Beau
 * @author Olgak85
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'apisb-desc' => 'Pozwala debugować [//www.mediawiki.org/wiki/API MediaWiki API] zgłoszenia błędów z przeglądarki',
	'apisandbox' => 'API sandbox (środowisko testowe)',
	'apisb-no-js' => "'''Błąd''' – ta funkcja wymaga JavaScript.",
	'apisb-intro' => "Użyj tej strony do eksperymentowania z '''MediaWiki API'''.
Więcej szczegółów na temat użycia interfejsu API można znaleźć w [//www.mediawiki.org/wiki/API:Main_page API dokumentacji].",
	'apisb-api-disabled' => 'API jest wyłączone na tej stronie.',
	'apisb-legend-result' => 'Rezultat',
	'apisb-legend-generic-parameters' => 'Parametry podstawowe',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'Żądanie URL:',
	'apisb-result-request-post' => 'Dane POST:',
	'apisb-select-action' => 'Wybierz działanie',
	'apisb-select-query' => 'Podaj zapytanie?',
	'apisb-select-value' => 'Wybierz wartość',
	'apisb-loading' => 'Trwa ładowanie…',
	'apisb-load-error' => 'Błąd podczas ładowania opisu API.',
	'apisb-request-error' => 'Błąd podczas wykonywania żądania API.',
	'apisb-namespaces-error' => 'Błąd ładowania obszaru nazw.',
	'apisb-ns-main' => '(główna)',
	'apisb-submit' => 'Wykonaj żądanie',
	'apisb-query-prop' => 'Właściwości',
	'apisb-query-list' => 'Listy',
	'apisb-query-meta' => 'Matainformacje',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'apisb-desc' => 'A përmëtt ëd gavé ij bigat a le ciamà [//www.mediawiki.org/wiki/API API ëd MediaWiki] a parte dal navigador',
	'apisandbox' => 'Spassi dle preuve API',
	'apisb-no-js' => "'''Eror''': sta funsion a l'ha damanca ëd JavaScript",
	'apisb-intro' => "Ch'a deuvra sta pàgina për sperimenté ël '''servissi an sl'aragnà MediaWiki API'''.
Ch'a fasa riferiment a [//www.mediawiki.org/wiki/API:Main_page la documentassion ëd l'API] për d'àutri detaj an sl'utilisassion ëd l'API. Për esempi: [//www.mediawiki.org/wiki/API#A_simple_example oten-e ël contnù ëd na pàgina d'Intrada]. Ch'a selession-a n'assion për vëdde d'àutri esempi.",
	'apisb-api-disabled' => "API a l'é disabilità ansima a 's sit.",
	'apisb-legend-result' => 'Arzultà',
	'apisb-legend-generic-parameters' => 'Paràmetr genérich',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => "Anliura d'arcesta:",
	'apisb-result-request-post' => 'Dat ëd POST:',
	'apisb-select-action' => "Selessioné n'assion",
	'apisb-select-query' => "Lòn ch'a-i é da ciamé?",
	'apisb-select-value' => 'Selessioné ël valor',
	'apisb-loading' => 'A caria ...',
	'apisb-load-error' => "Eror an cariand la descrission dl'API",
	'apisb-request-error' => "Eror fasend la ciamà dl'API",
	'apisb-namespaces-error' => 'Eror cariand jë spassi nominaj',
	'apisb-ns-main' => '(Prinsipal)',
	'apisb-submit' => "Fé l'arcesta",
	'apisb-query-prop' => 'Proprietà',
	'apisb-query-list' => 'Liste',
	'apisb-query-meta' => 'Meta-anformassion',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'apisb-legend-result' => 'پايله',
	'apisb-result-request-url' => 'د URL غوښتنه کول:',
	'apisb-select-action' => 'چاره ټاکل',
	'apisb-select-value' => 'ارزښت ټاکل',
	'apisb-loading' => 'د برسېرېدلو په حال کې...',
	'apisb-ns-main' => '(آرنی)',
	'apisb-submit' => 'غوښته کول',
	'apisb-query-prop' => 'ځانتياوې',
	'apisb-query-list' => 'لړليکونه',
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 * @author Luckas Blade
 */
$messages['pt'] = array(
	'apisb-desc' => 'Permite depurar chamadas à [//www.mediawiki.org/wiki/API API do MediaWiki] a partir do browser',
	'apisandbox' => 'Testes da API',
	'apisb-no-js' => "'''Erro''': Esta funcionalidade requer o JavaScript.",
	'apisb-intro' => "Use esta página para fazer experiências com a '''API do MediaWiki'''.
Consulte a [//www.mediawiki.org/wiki/API:Main_page documentação da API] para informações sobre o uso da API.",
	'apisb-api-disabled' => 'A API está desactivada neste site.',
	'apisb-legend-parameters' => 'Parâmetros',
	'apisb-legend-result' => 'Resultado',
	'apisb-result-request-url' => 'URL do pedido:',
	'apisb-result-request-post' => 'Dados POST:',
	'apisb-select-action' => 'Seleccionar acção',
	'apisb-select-query' => 'O que pretende consultar?',
	'apisb-select-value' => 'Seleccionar o valor',
	'apisb-docs-more' => 'leia mais',
	'apisb-params-param' => 'Parâmetro',
	'apisb-params-input' => 'Entrada',
	'apisb-params-desc' => 'Descrição',
	'apisb-loading' => 'A carregar…',
	'apisb-load-error' => 'Erro ao carregar a descrição da API',
	'apisb-request-error' => 'Erro ao executar o pedido da API',
	'apisb-namespaces-error' => 'Erro ao carregar os espaços nominais',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Fazer o pedido',
	'apisb-query-prop' => 'Propriedades',
	'apisb-query-list' => 'Listas',
	'apisb-query-meta' => 'Meta informação',
	'apisb-example' => 'Exemplo',
	'apisb-examples' => 'Exemplos',
	'apisb-clear' => 'Limpar',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author Rafael Vargas
 */
$messages['pt-br'] = array(
	'apisb-desc' => 'Permite depurar chamadas do [//www.mediawiki.org/wiki/API API do MediaWiki] a partir do navegador',
	'apisandbox' => 'Caixa de areia da API',
	'apisb-no-js' => "'''Erro''': este recurso requer JavaScript.",
	'apisb-intro' => "Use esta página para experimentar com '''API MediaWiki'''.
Consulte [//www.mediawiki.org/wiki/API:Main_page the API documentation] para obter mais detalhes de uso da API.",
	'apisb-api-disabled' => 'A API está desabilitada neste site.',
	'apisb-legend-result' => 'Resultado',
	'apisb-legend-generic-parameters' => 'Parâmetros genéricos',
	'apisb-legend-generator-parameters' => 'Gerador',
	'apisb-result-request-url' => 'URL solicitante:',
	'apisb-result-request-post' => 'Dados POST:',
	'apisb-select-action' => 'Selecione a ação',
	'apisb-select-query' => 'Qual é a consulta?',
	'apisb-select-value' => 'Selecione o valor',
	'apisb-loading' => 'Carregando...',
	'apisb-load-error' => 'Erro ao carregar a descrição da API',
	'apisb-request-error' => 'Erro na requisição de API',
	'apisb-namespaces-error' => 'Erro carregando namespaces',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Fazer requisição',
	'apisb-query-prop' => 'Propriedades',
	'apisb-query-list' => 'Listas',
	'apisb-query-meta' => 'Meta informação',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Minisarm
 */
$messages['ro'] = array(
	'apisandbox' => 'Cutia cu nisip pentru API',
	'apisb-no-js' => "'''Eroare''': această caracteristică necesită JavaScript.",
	'apisb-api-disabled' => 'API este dezactivat pe acest site.',
	'apisb-legend-parameters' => 'Parametri',
	'apisb-legend-result' => 'Rezultat',
	'apisb-legend-generic-parameters' => 'Parametri generici',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'URL cerere:',
	'apisb-result-request-post' => 'Date POST:',
	'apisb-select-action' => 'Alegeți o acțiune',
	'apisb-select-query' => '(selectați interogarea)',
	'apisb-select-value' => '(selectați valoarea)',
	'apisb-docs-more' => 'citiți mai mult',
	'apisb-params-param' => 'Parametru',
	'apisb-params-input' => 'Date de intrare',
	'apisb-params-desc' => 'Descriere',
	'apisb-loading' => 'Se încarcă...',
	'apisb-load-error' => 'Eroare la încărcarea descrierii API',
	'apisb-request-error' => 'Eroare la executarea cererii API',
	'apisb-namespaces-error' => 'Eroare la încărcarea spațiilor de nume',
	'apisb-ns-main' => '(Principal)',
	'apisb-submit' => 'Efectuați cererea',
	'apisb-query-prop' => 'Proprietăți',
	'apisb-query-list' => 'Liste',
	'apisb-query-meta' => 'Meta-informații',
	'apisb-example' => 'Exemplu',
	'apisb-examples' => 'Exemple',
	'apisb-clear' => 'Curăță',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'apisb-desc' => "Permette de verificà le chiamate de [//www.mediawiki.org/wiki/API MediaWiki API] da 'u browser",
	'apisandbox' => "Sandbox de l'API",
	'apisb-no-js' => "'''Errore''': sta funzionalità vole 'u JavaScript.",
	'apisb-legend-result' => 'Resultate',
	'apisb-legend-generic-parameters' => 'Parametre generiche',
	'apisb-legend-generator-parameters' => 'Generatore',
	'apisb-result-request-url' => 'URL richieste:',
	'apisb-result-request-post' => "POST d'u date:",
	'apisb-select-action' => "Scacchie l'azione",
	'apisb-select-query' => "Ce ha 'nderrogà?",
	'apisb-select-value' => "Scacchie 'nu valore",
	'apisb-loading' => 'Stoche a careche…',
	'apisb-load-error' => "Errore jndr'à 'u carecamende d'a descrizione de l'API",
	'apisb-request-error' => "Errore in esecuzione d'a richieste de l'API",
	'apisb-namespaces-error' => 'Errore de caricamende de le namespace',
	'apisb-ns-main' => '(Prengepàle)',
	'apisb-submit' => "Fà 'na richieste",
	'apisb-query-prop' => 'probbietà',
	'apisb-query-list' => 'Elenghe',
	'apisb-query-meta' => "'Mbormaziune sus a le Meta",
);

/** Russian (Русский)
 * @author DCamer
 * @author Eleferen
 * @author Kaganer
 * @author KorneySan
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'apisb-desc' => 'Позволяет отлаживать вызовы [//www.mediawiki.org/wiki/API MediaWiki API] из браузера',
	'apisandbox' => 'Песочница API',
	'apisb-no-js' => "'''Ошибка''': эта возможность требует JavaScript.",
	'apisb-intro' => "Используйте эту страницу для экспериментов с '''MediaWiki API'''.
Обратитесь к [//www.mediawiki.org/wiki/API:Main_page документации API] для получения дополнительной информации об использовании API.  Например о том, [//www.mediawiki.org/wiki/API#A_simple_example как получить содержание Заглавной страницы]. Выберите действие, чтобы увидеть другие примеры.",
	'apisb-api-disabled' => 'API отключен на этом сайте.',
	'apisb-legend-parameters' => 'Параметры',
	'apisb-legend-result' => 'Результат',
	'apisb-legend-generic-parameters' => 'Общие параметры',
	'apisb-legend-generator-parameters' => 'Генератор',
	'apisb-result-request-url' => 'URL-адрес запроса:',
	'apisb-result-request-post' => 'POST данные:',
	'apisb-select-action' => 'Выберите действие',
	'apisb-select-query' => '(выберите запрос)',
	'apisb-select-value' => '(выберите значение)',
	'apisb-docs-more' => 'подробнее',
	'apisb-params-param' => 'Параметр',
	'apisb-params-input' => 'Ввод',
	'apisb-params-desc' => 'Описание',
	'apisb-loading' => 'Загрузка…',
	'apisb-load-error' => 'Ошибка при загрузке описания API',
	'apisb-request-error' => 'Ошибка выполнения запроса API',
	'apisb-namespaces-error' => 'Ошибка при загрузке пространств имен',
	'apisb-ns-main' => '(Основная)',
	'apisb-submit' => 'Сделать запрос',
	'apisb-query-prop' => 'Свойства',
	'apisb-query-list' => 'Списки',
	'apisb-query-meta' => 'Мета-информация',
	'apisb-example' => 'Пример',
	'apisb-examples' => 'Примеры',
	'apisb-clear' => 'Очистить',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'apisb-result' => 'परिणामम्',
	'apisb-ns-main' => '(मुख्य)',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 */
$messages['scn'] = array(
	'apisb-ns-main' => '(Principali)',
	'apisb-submit' => 'Addumanna',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'apisb-desc' => 'ගවේෂකයෙන් [//www.mediawiki.org/wiki/API මාධ්‍යවිකි API] ඇමතුම්වල දෝෂ ඉවත් කිරීමට ඉඩදෙන්න',
	'apisandbox' => 'API වැලිපිල්ල',
	'apisb-no-js' => "'''දෝෂය''': මෙම ගුණාංගය සඳහා ජාවාස්ක්‍රිප්ට් අවශ්‍ය වේ.",
	'apisb-intro' => "'''මාධ්‍යවිකි API''' සමඟ අත්හදා බැලීම සඳහා මෙම පිටුව භාවිතා කරන්න.
	API භාවිතය පිලිබඳ වැඩිදුර විස්තර සඳහා  [//www.mediawiki.org/wiki/API:Main_page API ප්‍රලේඛනය] හී ඉල්ලීමක් කරන්න.",
	'apisb-api-disabled' => 'මෙම අඩවියෙහි API අක්‍රීය කොට ඇත.',
	'apisb-legend-result' => 'ප්‍රතිඵලය',
	'apisb-legend-generic-parameters' => 'ප්‍රජාතීය පරාමිතීන්',
	'apisb-legend-generator-parameters' => 'උත්පාදකය',
	'apisb-result-request-url' => 'URL ලිපිනය අයදින්න:',
	'apisb-result-request-post' => 'POST දත්ත:',
	'apisb-select-action' => 'කාර්ය තෝරන්න',
	'apisb-select-query' => 'ප්‍රශ්නය කුමක්ද?',
	'apisb-select-value' => 'අගය තෝරන්න',
	'apisb-loading' => 'පූරණය වෙමින්...',
	'apisb-load-error' => 'API විස්තරය පූරණය වීමේ දෝෂය',
	'apisb-request-error' => 'API අයදුම රඟ දැක්වීමේ දෝෂය',
	'apisb-namespaces-error' => 'නාමඅවකාශ පූර්ණය කිරීමේ දෝෂය',
	'apisb-ns-main' => '(ප්‍රධාන)',
	'apisb-submit' => 'අයදුමක් සිදු කරන්න',
	'apisb-query-prop' => 'ගුණ',
	'apisb-query-list' => 'ලැයිස්තු',
	'apisb-query-meta' => 'මෙටා තොරතුරු',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'apisandbox' => 'API pieskovisko',
	'apisb-legend-result' => 'Výsledok',
	'apisb-result-request-url' => 'URL požiadavky:',
	'apisb-result-request-post' => 'Údaje POST:',
	'apisb-select-action' => 'Vyberte operáciu',
	'apisb-select-query' => 'Požiadavku na čo?',
	'apisb-select-value' => 'Vyberte hodnotu',
	'apisb-loading' => 'Načítava sa...',
	'apisb-ns-main' => '(Hlavné)',
	'apisb-submit' => 'Podať žiadosť',
	'apisb-query-prop' => 'Vlastnosti',
	'apisb-query-list' => 'Zoznamy',
	'apisb-query-meta' => 'Metainformácie',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'apisb-desc' => 'Omogoča popravljanje napak klicev [//www.mediawiki.org/wiki/API MediaWiki API] iz brskalnika',
	'apisandbox' => 'Peskovnik API',
	'apisb-no-js' => "'''Napaka''': funkcija potrebuje JavaScript.",
	'apisb-intro' => "Uporabite to stran za preizkušanje '''API spletnih storitev MediaWiki'''.
	Oglejte si [//www.mediawiki.org/wiki/API:Main_page dokumentacijo API] za nadaljnje podrobnosti o uporabi API.  Primer: [//www.mediawiki.org/wiki/API#A_simple_example pridobi vsebino Glavne strani].  Izberite dejanje, da si ogledate več primerov.",
	'apisb-api-disabled' => 'API je onemogočen na tej spletni strani.',
	'apisb-legend-result' => 'Rezultat',
	'apisb-legend-generic-parameters' => 'Generični parametri',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'URL zahteve:',
	'apisb-result-request-post' => 'Podatki POST:',
	'apisb-select-action' => 'Izberite dejanje',
	'apisb-select-query' => '(izberite poizvedbo)',
	'apisb-select-value' => '(izberite vrednost)',
	'apisb-loading' => 'Nalaganje ...',
	'apisb-load-error' => 'Napaka pri nalaganju opisa API',
	'apisb-request-error' => 'Napak pri izvajanju zahteve API',
	'apisb-namespaces-error' => 'Napaka pri nalaganju imenskih prostorov',
	'apisb-ns-main' => '(Osnovno)',
	'apisb-submit' => 'Izvedi zahtevo',
	'apisb-query-prop' => 'Lastnosti',
	'apisb-query-list' => 'Seznami',
	'apisb-query-meta' => 'Metapodatki',
	'apisb-example' => 'Primer',
	'apisb-examples' => 'Primeri',
	'apisb-clear' => 'Počisti',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'apisb-api-disabled' => 'АПИ је онемогућен на овом сајту.',
	'apisb-legend-result' => 'Резултат',
	'apisb-legend-generic-parameters' => 'Општи параметри',
	'apisb-legend-generator-parameters' => 'Стварач',
	'apisb-result-request-url' => 'Адреса захтева:',
	'apisb-result-request-post' => 'POST подаци:',
	'apisb-select-action' => 'Изаберите радњу',
	'apisb-select-query' => '(изаберите упит)',
	'apisb-select-value' => '(изаберите вредност)',
	'apisb-loading' => 'Учитавам…',
	'apisb-load-error' => 'Грешка при учитавању описа АПИ-ја',
	'apisb-request-error' => 'Грешка при извршавању захтева од АПИ-ја',
	'apisb-namespaces-error' => 'Грешка при учитавању именских простора',
	'apisb-ns-main' => '(главно)',
	'apisb-submit' => 'Постави захтев',
	'apisb-query-prop' => 'Својства',
	'apisb-query-list' => 'Спискови',
	'apisb-query-meta' => 'Метаподаци',
);

/** Swedish (Svenska)
 * @author Skalman
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'apisb-desc' => 'Gör det möjligt att felsöka [//www.mediawiki.org/wiki/API MediaWiki API]-samtal från webbläsaren',
	'apisandbox' => 'API-sandlåda',
	'apisb-no-js' => "'''Fel''': Denna funktion kräver JavaScript.",
	'apisb-intro' => "Använd denna sida för att experimentera med '''MediaWiki API'''.
Kolla på [//www.mediawiki.org/wiki/API:Main_page API-dokumentationen] för fler detaljer om API-användning.",
	'apisb-api-disabled' => 'API är inaktiverat på denna webbplats.',
	'apisb-legend-result' => 'Resultat',
	'apisb-legend-generator-parameters' => 'Generator',
	'apisb-result-request-url' => 'Begär URL:',
	'apisb-result-request-post' => 'POST-data:',
	'apisb-select-action' => 'Välj handling',
	'apisb-select-query' => 'Vad ska begäras?',
	'apisb-select-value' => 'Välj värde',
	'apisb-loading' => 'Läser in...',
	'apisb-load-error' => 'Fel uppstod när API-beskrivningen skulle läsas in',
	'apisb-request-error' => 'Fel uppstod när API skulle begäras',
	'apisb-namespaces-error' => 'Fel uppstod när namnrymden skulle läsas in',
	'apisb-ns-main' => '(Huvud)',
	'apisb-submit' => 'Gör en begäran',
	'apisb-query-prop' => 'Egenskaper',
	'apisb-query-list' => 'Listor',
	'apisb-query-meta' => 'Metainformation',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 */
$messages['ta'] = array(
	'apisb-legend-result' => 'முடிவு',
	'apisb-legend-generic-parameters' => 'பொதுவானஅளவுருக்கள்',
	'apisb-loading' => 'ஏற்றுகிறது...',
	'apisb-ns-main' => '(முதன்மை)',
	'apisb-submit' => 'கோரிக்கை செய்',
	'apisb-query-prop' => 'பண்புகள்',
	'apisb-query-list' => 'பட்டியல்கள்',
	'apisb-query-meta' => 'Meta தகவல்',
	'apisb-example' => 'உதாரணம்',
	'apisb-examples' => 'உதாரணங்கள்',
	'apisb-clear' => 'வெறுமையாக்கு',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'apisb-parameters' => 'పరామితులు',
	'apisb-result' => 'ఫలితం',
	'apisb-select-action' => 'చర్యను ఎంచుకోండి',
	'apisb-loading' => 'లోడవుతోంది...',
	'apisb-ns-main' => '(మొదటి)',
	'apisb-query-list' => 'జాబితాలు',
	'apisb-query-meta' => 'మెటా సమాచారం',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'apisb-desc' => 'Nagpapahintulot ng pagkumpuni ng mga pagtawag ng [//www.mediawiki.org/wiki/API MediaWiki API] mula sa pantingin-tingin',
	'apisandbox' => 'Kahong buhanginan ng API',
	'apisb-no-js' => "'''Kamalian''': nangangailangan ng JavaScript ang tampok na ito.",
	'apisb-intro' => "Gamitin ang pahinang ito upang mag-eksperimento sa pamamagitan ng '''API ng MediaWiki'''.
Sumangguni sa [//www.mediawiki.org/wiki/API:Main_page dokumentasyon ng API] para sa karagdagan pang mga detalye sa paggamit ng API.",
	'apisb-api-disabled' => 'Hindi pinagagana ang API sa sityong ito.',
	'apisb-legend-result' => 'Kinalabasan',
	'apisb-result-request-url' => 'Hilingin ang URL:',
	'apisb-result-request-post' => 'Dato ng POST:',
	'apisb-select-action' => 'Piliin ang kilos',
	'apisb-select-query' => 'Ano ang itatanong?',
	'apisb-select-value' => 'Piliin ang halaga',
	'apisb-loading' => 'Ikinakarga...',
	'apisb-load-error' => 'Kamalian sa pagkakarga ng paglalarawan ng API',
	'apisb-request-error' => 'Kamalian sa pagsasagawa ng hiling ng API',
	'apisb-namespaces-error' => 'Kamalian sa pagkakarga ng mga puwang ng pangalan',
	'apisb-ns-main' => '(Pangunahin)',
	'apisb-submit' => 'Gumawa ng kahilingan',
	'apisb-query-prop' => 'Mga katangiang-ari',
	'apisb-query-list' => 'Mga talaan',
	'apisb-query-meta' => 'Kabatirang meta',
);

/** Turkish (Türkçe)
 * @author Emperyan
 * @author Incelemeelemani
 */
$messages['tr'] = array(
	'apisb-legend-result' => 'Sonuç',
	'apisb-docs-more' => 'devamı',
	'apisb-params-param' => 'Parametre',
	'apisb-params-desc' => 'Tanım',
	'apisb-loading' => 'Yükleniyor...',
	'apisb-load-error' => 'API tanımı yüklenirken hata oluştu',
	'apisb-ns-main' => '(Ana)',
	'apisb-query-prop' => 'Özellikler',
	'apisb-query-list' => 'Listeler',
	'apisb-query-meta' => 'Meta bilgi',
	'apisb-example' => 'Örnek',
	'apisb-examples' => 'Örnekler',
	'apisb-clear' => 'Temizle',
);

/** Ukrainian (Українська)
 * @author Microcell
 * @author Sodmy
 * @author Тест
 */
$messages['uk'] = array(
	'apisb-desc' => 'Дозволяє налагоджувати виклики [//www.mediawiki.org/wiki/API MediaWiki API] з браузера',
	'apisandbox' => 'Майданчик для тестування API',
	'apisb-no-js' => "'''Помилка''': ця функція вимагає JavaScript.",
	'apisb-intro' => "Ця сторінка служить для експериментування з '''MediaWiki API'''.
Звертайтеся до [//www.mediawiki.org/wiki/API:Main_page документації] для докладнішої інформації про використання API.",
	'apisb-api-disabled' => 'API вимкнуто на цьому сайті.',
	'apisb-legend-result' => 'Результат',
	'apisb-legend-generic-parameters' => 'Загальні параметри',
	'apisb-legend-generator-parameters' => 'Генератор',
	'apisb-result-request-url' => 'URL-адреса запиту:',
	'apisb-result-request-post' => 'POST данні:',
	'apisb-select-action' => 'Виберіть дію',
	'apisb-select-query' => 'Що запитати?',
	'apisb-select-value' => '(виберіть значення)',
	'apisb-loading' => 'Завантаження...',
	'apisb-load-error' => 'Помилка завантаження API опису',
	'apisb-request-error' => 'Помилка виконання запиту API',
	'apisb-namespaces-error' => 'Помилка завантаження простору імен',
	'apisb-ns-main' => '(Основний)',
	'apisb-submit' => 'Зробити запит',
	'apisb-query-prop' => 'Властивості',
	'apisb-query-list' => 'Списки',
	'apisb-query-meta' => 'Мета-інформація',
);

/** Veps (Vepsän kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'apisb-parameters' => 'Parametrad',
	'apisb-result' => "Rezul'tat",
	'apisb-query-prop' => 'Ičendad',
	'apisb-query-list' => 'Nimikirjutesed',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Trần Nguyễn Minh Huy
 */
$messages['vi'] = array(
	'apisb-desc' => 'Cho phép gỡ lỗi các lần gọi [//www.mediawiki.org/wiki/API API của MediaWiki] trong trình duyệt',
	'apisandbox' => 'Chỗ thử API',
	'apisb-no-js' => "'''Lỗi:''' Tính năng này cần JavaScript.",
	'apisb-intro' => "Trang này dùng để thử nghiệm với '''API dịch vụ Web của MediaWiki'''.
	Hãy tra cứu [//www.mediawiki.org/wiki/API:Main_page tài liệu API] để biết chi tiết về cách sử dụng API. Ví dụ: [//www.mediawiki.org/wiki/API#A_simple_example lấy nội dung của Trang Chính]. Chọn một tác vụ để xem thêm ví dụ.",
	'apisb-api-disabled' => 'API đã bị vô hiệu hóa trên trang web này.',
	'apisb-legend-parameters' => 'Tham số',
	'apisb-legend-result' => 'Kết quả',
	'apisb-legend-generic-parameters' => 'Tham số chung',
	'apisb-legend-generator-parameters' => 'Bộ xuất phát',
	'apisb-result-request-url' => 'URL của yêu cầu:',
	'apisb-result-request-post' => 'Dữ liệu POST:',
	'apisb-select-action' => 'Chọn tác vụ',
	'apisb-select-query' => '(chọn truy vấn)',
	'apisb-select-value' => '(chọn giá trị)',
	'apisb-docs-more' => 'xem tiếp',
	'apisb-params-param' => 'Tham số',
	'apisb-params-input' => 'Đầu vào',
	'apisb-params-desc' => 'Miêu tả',
	'apisb-loading' => 'Đang tải…',
	'apisb-load-error' => 'Lỗi khi tải miêu tả API',
	'apisb-request-error' => 'Lỗi khi phản ứng yêu cầu API',
	'apisb-namespaces-error' => 'Lỗi khi tải các không gian tên',
	'apisb-ns-main' => '(Chính)',
	'apisb-submit' => 'Yêu cầu',
	'apisb-query-prop' => 'Thuộc tính',
	'apisb-query-list' => 'Danh sách',
	'apisb-query-meta' => 'Siêu thông tin',
	'apisb-example' => 'Ví dụ',
	'apisb-examples' => 'Ví dụ',
	'apisb-clear' => 'Tẩy trống',
);

/** Yiddish (ייִדיש)
 * @author Imre
 */
$messages['yi'] = array(
	'apisb-result' => 'רעזולטאט',
	'apisb-loading' => 'לאָדט…',
	'apisb-ns-main' => '(הויפט)',
	'apisb-query-list' => 'ליסטעס',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Hydra
 * @author Hzy980512
 * @author Liangent
 * @author PhiLiP
 * @author Shizhao
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'apisb-desc' => '允许从浏览器调试[//www.mediawiki.org/wiki/API MediaWiki API]调用',
	'apisandbox' => 'API沙盒',
	'apisb-no-js' => "'''错误'''：此功能需要 JavaScript。",
	'apisb-intro' => '使用这个页面来试验“MediaWiki Web 服务应用程序接口（API）”。
欲知API使用详情，请参阅[//www.mediawiki.org/wiki/API:Main_page API文档]。
例如：[//www.mediawiki.org/wiki/API#A_simple_example 取得某个主页的内容]，然后选择一个操作来看更多范例。',
	'apisb-api-disabled' => '此站点上禁用了API。',
	'apisb-legend-parameters' => '参数',
	'apisb-legend-result' => '结果',
	'apisb-legend-generic-parameters' => '通用参数',
	'apisb-legend-generator-parameters' => '生成器',
	'apisb-result-request-url' => '请求的URL：',
	'apisb-result-request-post' => 'POST数据：',
	'apisb-select-action' => '选择操作',
	'apisb-select-query' => '（请选择查询）',
	'apisb-select-value' => '（选择值）',
	'apisb-docs-more' => '阅读更多',
	'apisb-params-param' => '参数',
	'apisb-params-input' => '输入',
	'apisb-params-desc' => '说明',
	'apisb-loading' => '正在载入...',
	'apisb-load-error' => '加载 API 说明时出错',
	'apisb-request-error' => '执行 API 请求时出错',
	'apisb-namespaces-error' => '载入名字空间出错',
	'apisb-ns-main' => '（主）',
	'apisb-submit' => '提交请求',
	'apisb-query-prop' => '属性',
	'apisb-query-list' => '列表',
	'apisb-query-meta' => 'Meta 信息',
	'apisb-example' => '示例',
	'apisb-examples' => '示例',
	'apisb-clear' => '清除',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Liangent
 */
$messages['zh-hant'] = array(
	'apisb-desc' => '允許從瀏覽器調試[//www.mediawiki.org/wiki/API MediaWiki API]調用',
	'apisandbox' => 'API沙箱',
	'apisb-no-js' => "'''錯誤'''：此功能需要 JavaScript。",
	'apisb-intro' => '使用這個頁面來試驗“MediaWiki 網上服務應用程式介面（API）”。
欲知API使用詳情，請參閱[//www.mediawiki.org/wiki/API:Main_page API文檔]。
例如：[//www.mediawiki.org/wiki/API#A_simple_example 取得某個主頁的內容]，然後選擇一個操作來看更多範例。',
	'apisb-api-disabled' => '此站點上禁用了API。',
	'apisb-legend-parameters' => '參數',
	'apisb-legend-result' => '結果',
	'apisb-legend-generic-parameters' => '通用參數',
	'apisb-legend-generator-parameters' => '生成器',
	'apisb-result-request-url' => '請求的 URL：',
	'apisb-result-request-post' => 'POST數據：',
	'apisb-select-action' => '選擇操作',
	'apisb-select-query' => '（請選擇查詢）',
	'apisb-select-value' => '（選擇值）',
	'apisb-docs-more' => '閱讀更多',
	'apisb-params-param' => '參數',
	'apisb-params-input' => '輸入',
	'apisb-params-desc' => '說明',
	'apisb-loading' => '正在載入...',
	'apisb-load-error' => '加載 API 說明時出錯',
	'apisb-request-error' => '執行 API 請求時出錯',
	'apisb-namespaces-error' => '載入名字空間出錯',
	'apisb-ns-main' => '（主）',
	'apisb-submit' => '提出要求',
	'apisb-query-prop' => '屬性',
	'apisb-query-list' => '列表',
	'apisb-query-meta' => 'Meta 信息',
	'apisb-example' => '示例',
	'apisb-examples' => '示例',
	'apisb-clear' => '清除',
);

