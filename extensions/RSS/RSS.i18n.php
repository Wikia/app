<?php
/**
 * Internationalization file for RSS extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 */

$messages['en'] = array(
	'rss-desc' => 'Displays RSS feeds on MediaWiki pages in a standard or in user-definable formats using template pages',
	'rss-error' => 'Failed to load RSS feed from $1: $2',
	'rss-empty' => 'Failed to load RSS feed from $1!',
	'rss-fetch-nourl' => 'Fetch called without a URL!',
	'rss-invalid-url' => 'Not a valid URL: $1',
	'rss-parse-error' => 'Error parsing XML for RSS',
	'rss-ns-permission' => 'RSS is not allowed in this namespace',
	'rss-url-permission' => 'This URL is not allowed to be included',
	'rss-item' => '{{$1 | title = {{{title}}} | link = {{{link}}} | date = {{{date}}} | author = {{{author}}} | description = {{{description}}} }}',
 	'rss-feed' => "<!--  the following are two alternative templates. The first is the basic default template for feeds -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- don't use newline here --><!-- The second is an improved version which requires Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Message documentation (Message documentation)
 * @author Raymond
 * @author Yekrats
 */
$messages['qqq'] = array(
	'rss-invalid-url' => '$1 is the invalid URL for the RSS feed',
	'rss-feed' => "; $1
: ''not to be localised''
: The RSS extension substitutes this placeholder with the name of a template page. The content of this template page determines the final layout of the RSS feed on the rendered wiki page. The Extension:RSS currently uses 'MediaWiki:Rss-feed' as default for $1. This means that the content of [[MediaWiki:Rss-feed]] determines how RSS feed items are rendered.
: It allows users to let RSS feeds rendered differently by using different (optional) 'template=<pagename>' parameters in the rss wiki tags.
; title = {{{title}}} | link = {{{link}}} | ...
: 'title' (left) is the variable name under which the content of an RSS feed field 'title' (right) is passed to the Template $1 where this is then used in the feed rendering.
: This ''may'' be localised, but the content of the template $1 page (default [[MediaWiki:Rss-feed]] and potentially other RSS feed template pages on this wiki) needs then to be localised, too.
: 'title' (right) is a name (property) of RSS feeds and is certainly not to be localised in any way.
: ''I suggest not to localise anything.''",
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'rss-desc' => "Bied 'n RSS-voer vir 'n wikibladsy",
	'rss-error' => 'Kon nie die RSS-voer van $1 laai nie, fout: $2',
	'rss-empty' => 'Kon nie die RSS-voer van $1 laai nie!',
	'rss-invalid-url' => "Nie 'n geldige URL nie: $1",
	'rss-parse-error' => 'Ontleding van die RSS se XML het gefaal',
	'rss-ns-permission' => 'RSS word nie in die naamruimte toegelaat nie',
	'rss-url-permission' => 'Hierdie URL mag nie ingesluit word nie',
);

/** Arabic (العربية)
 * @author زكريا
 */
$messages['ar'] = array(
	'rss-desc' => 'اترك تعليقات RSS في صفحة الميدياويكي بصيغة عادية أو محددة الاستخدام باستعمال صفحات القوالب',
	'rss-error' => 'فشل في تحميل تغذية RSS من $1: $2',
	'rss-empty' => 'فشل في تحميل تغذية RSS من $1!',
	'rss-fetch-nourl' => 'طلب تفحص بدون URL!',
	'rss-invalid-url' => 'عنوان URL غير صالح: $1',
	'rss-parse-error' => 'خطأ في تحليل XML من أجل RSS',
	'rss-ns-permission' => 'RSS غير مسموح به في هذا النطاق',
	'rss-url-permission' => 'URL لا يسمح بإدراجه',
	'rss-feed' => "<!--  the following are two alternative templates. The first is the basic default template for feeds -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- don't use newline here --><!-- The second is an improved version which requires Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'rss-desc' => 'Amuesa fluxos RSS nes páxines de Mediawiki en formatu estándar o configurable pol usuariu usando páxines de plantía',
	'rss-error' => 'Nun se pudo cargar el fluxu RSS dende $1: $2',
	'rss-empty' => '¡Nun se pudo cargar el fluxu RSS dende $1!',
	'rss-fetch-nourl' => '¡Se llamó a la baxada ensin una URL!',
	'rss-invalid-url' => 'Nun ye una URL válida: $1',
	'rss-parse-error' => 'Fallu al analizar el XML pal RSS',
	'rss-ns-permission' => 'El RSS nun ta permitíu nesti espaciu de nomes',
	'rss-url-permission' => 'Nun se permite incluir esta URL',
	'rss-feed' => "<!--  darréu vienen dos plantíes alternatives. La primera ye la plantía básica predeterminada pa fluxos -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- nun usar nueva llinia equí --><!-- La segunda ye una versión ameyorada que necesita Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Renessaince
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'rss-desc' => 'Паказвае RSS-стужкі на вікі-старонках',
	'rss-error' => 'Памылка загрузкі RSS-стужкі з $1: $2',
	'rss-empty' => 'Памылка загрузкі RSS-стужкі з $1!',
	'rss-fetch-nourl' => 'Выбарка выкліканая без URL-адрасу!',
	'rss-invalid-url' => 'Няслушны URL-адрас: $1',
	'rss-parse-error' => 'Памылка аналізу XML для RSS',
	'rss-ns-permission' => 'RSS у гэтай прасторы назваў не дазволены',
	'rss-url-permission' => 'Даданьне гэтага URL-адрасу не дазволенае',
	'rss-feed' => "<!--  ніжэй рададзеныя два магчымыя шаблёны. Першы — асноўны шаблён па змоўчваньні для стужкі -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- не ўжывайце тут новы радок --><!-- Другі — палепшаная вэрсія, якая патрабуе Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Breton (Brezhoneg)
 * @author Fulup
 * @author Y-M D
 */
$messages['br'] = array(
	'rss-desc' => 'Diskouez ur gwazh RSS war ur bajenn eus ar wiki',
	'rss-error' => 'Dibosupl eo kargañ ar gwazh RSS eus $1 : $2',
	'rss-empty' => 'Dibosupl eo kargañ gwazh RSS eus $1 !',
	'rss-fetch-nourl' => 'Galvadenn klask hep URL !',
	'rss-invalid-url' => 'URL direizh : $1',
	'rss-parse-error' => 'Fazi en dielfennañ XML evit RSS',
	'rss-ns-permission' => "N'haller ket ober gant lanvadoù RSS en esaouenn anv-mañ",
	'rss-url-permission' => "N'haller ket ober gant an URL-mañ.",
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'rss-desc' => 'Prikazuje RSS fid na wiki stranici',
	'rss-error' => 'Nije uspjelo učitavanje RSS fida iz $1: $2',
	'rss-empty' => 'Nije uspjelo učitavanje RSS fida iz $1!',
	'rss-fetch-nourl' => 'Akcija pozvana bez URL!',
	'rss-invalid-url' => 'Nije valjan URL: $1',
	'rss-parse-error' => 'Greška pri parsiranju XML za RSS',
	'rss-ns-permission' => 'RSS nije dozvoljen u ovom imenskom prostoru',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'rss-desc' => 'Zobrazuje na wikistránce RSS kanál',
	'rss-error' => 'Nepodařilo se načíst RSS kanál z $1: $2',
	'rss-empty' => 'Nepodařilo se načíst RSS kanál z $1!',
	'rss-fetch-nourl' => 'Nebylo určeno URL, které se má načíst!',
	'rss-invalid-url' => 'Není platné URL: $1',
	'rss-parse-error' => 'Chyba parsování XML pro RSS',
	'rss-ns-permission' => 'V tomto jmenném prostoru není RSS dovoleno',
	'rss-url-permission' => 'Není dovoleno vložit toto URL',
	'rss-feed' => "<!--  Následují dvě alternativní šablony. První je základní implicitní šablona zdrojů -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- zde nevkládat nový řádek --><!-- Druhá je vylepšná verze, která vyžaduje rozšíření Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'rss-invalid-url' => 'Ikke en gyldig URL: $1',
	'rss-ns-permission' => 'RSS er ikke tilladt i dette navnerum',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'rss-desc' => 'Ermöglicht es, einen RSS-Feed auf einer Wikiseite anzuzeigen',
	'rss-error' => 'Der RSS-Feed konnte nicht von $1 geladen werden: $2',
	'rss-empty' => 'Der RSS-Feed konnte nicht von $1 geladen werden!',
	'rss-fetch-nourl' => 'Abruf ohne Angabe einer URL!',
	'rss-invalid-url' => 'Ungültige URL: $1',
	'rss-parse-error' => 'Fehler beim Parsen von XML für RSS',
	'rss-ns-permission' => 'RSS ist in diesem Namensraum nicht erlaubt',
	'rss-url-permission' => 'Diese URL darf nicht enthalten sein',
	'rss-feed' => "<!-- Die folgenden Vorlagen sind zwei alternativ zueinander einsetzbare Vorlagen. Die erste ist die Standardvorlage für Feeds. -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- An dieser Stelle bitte keine neue Zeile einfügen. --><!-- Die zweite ist eine verbesserte Vorlage, für die die Softwareerweiterung ParserFunctions benötigt wird. --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'rss-desc' => 'Zwobraznjujo RSS-kanal na wikiboku',
	'rss-error' => 'RSS-kanal njejo dał se z $1 zacytaś: $2',
	'rss-empty' => 'RSS-kanal njejo dał se z $1 zacytaś!',
	'rss-fetch-nourl' => 'Wótwołanje bźez URL!',
	'rss-invalid-url' => 'Njepłaśiwy URL: $1',
	'rss-parse-error' => 'Zmólka pśi parsowanju XML za RSS',
);

/** Greek (Ελληνικά)
 * @author Evropi
 */
$messages['el'] = array(
	'rss-desc' => 'Εμφανίζει μια τροφοδοσία RSS σε μια σελίδα wiki',
	'rss-error' => 'Απέτυχε η φόρτωση της τροφοδοσίας RSS από το $1: $2',
	'rss-empty' => 'Απέτυχε η φόρτωση της τροφοδοσίας RSS από το $1!',
	'rss-invalid-url' => 'Άκυρη διεύθυνση URL: $1',
	'rss-parse-error' => 'Σφάλμα κατά την ανάλυση XML για RSS',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'rss-desc' => 'Montras RSS-fluon en vikia paĝo',
	'rss-error' => 'Malsukcesis ŝarĝi RSS-fonton de $1: $2',
	'rss-empty' => 'Malsukcesis ŝarĝi RSS-fonton de $1!',
	'rss-fetch-nourl' => 'Akiro vokita sen URL-o!',
	'rss-invalid-url' => 'Malvalida URL-o: $1',
	'rss-parse-error' => 'Eraro interpretante XML-on de RSS-o',
	'rss-ns-permission' => 'RSS-abonado ne estas permesita en ĉi tiu nomspaco',
	'rss-url-permission' => 'Ĉi tiu URL-o ne estas permesita inkluzivi',
	'rss-feed' => "<!-- Jen du alternativaj ŝablonoj. La unua estas la baza defaŭlta ŝablono por abonfontoj. -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- ne uzu novlinio ĉi tie --><!-- La dua estas plibonigita versio kiu devigas ilon Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Spanish (Español)
 * @author Imre
 * @author Locos epraix
 */
$messages['es'] = array(
	'rss-desc' => 'Muestra un feed RSS en una página wiki',
	'rss-error' => 'No se pudo cargar el feed RSS desde $1: $2',
	'rss-empty' => 'No se pudo cargar feed RSS desde $1!',
	'rss-invalid-url' => 'No es una URL válida: $1',
);

/** Persian (فارسی)
 * @author Mjbmr
 */
$messages['fa'] = array(
	'rss-desc' => 'خوراک‌های آراس‌اس را در صفحه‌های مدیاویکی به حالت استاندارد و حالت تعریف شده توسط کاربر با استفاده از صفحه‌های الگو، نشان می‌دهد',
	'rss-error' => 'بارگیری خوراک آراس‌اس از $1 ناموفق بود: $2',
	'rss-empty' => 'بارگیری خوراک آراس‌اس از $1 ناموفق بود!',
	'rss-fetch-nourl' => 'دریافت بدون نشانی صدا زده شد!',
	'rss-invalid-url' => 'نشانی اینترنتی نامعتبر: $1',
	'rss-parse-error' => 'خطا در تجزیهٔ ایکس‌ام‌ال برای آراس‌اس',
	'rss-ns-permission' => 'آراس‌اس برای این فضای نامی مجاز نمی‌باشد',
	'rss-url-permission' => 'این نشانی برای شامل شدن مجاز نمی‌باشد',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 * @author Nike
 * @author Olli
 */
$messages['fi'] = array(
	'rss-desc' => 'Näyttää RSS-syötteitä MediaWiki-sivuilla yleisessä tai käyttäjän määrittämässä muodossa mallinesivuja käyttäen',
	'rss-error' => 'RSS-syötteen lataaminen osoitteesta $1 epäonnistui: $2',
	'rss-empty' => 'RSS-syötteen lataaminen osoitteesta $1 epäonnistui!',
	'rss-fetch-nourl' => 'Syötettä kutsuttiin ilman osoitetta!',
	'rss-invalid-url' => 'Ei kelpaava osoite: $1',
	'rss-parse-error' => 'Virhe jäsennettäessä XML:ää RSS:ää varten',
	'rss-ns-permission' => 'RSS ei ole sallittu tässä nimiavaruudessa',
	'rss-url-permission' => 'Tätä osoitetta ei saa käyttää',
	'rss-feed' => "<!--  seuraavat ovat kaksi vaihtoehtoista mallinetta. Ensimmäinen on perusmalline syötteille -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- älä käytä rivinvaihtoa tässä --><!-- Toinen on kehittyneempi versio, joka tarvitsee ParserFunctions-laajennoksen --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** French (Français)
 * @author Crochet.david
 * @author Faure.thomas
 * @author Gomoko
 * @author IAlex
 * @author Peter17
 */
$messages['fr'] = array(
	'rss-desc' => 'Affiche un flux RSS sur une page du wiki',
	'rss-error' => 'Impossible de charger le flux RSS de $1 : $2',
	'rss-empty' => 'Impossible de charger le flux RSS de $1 !',
	'rss-fetch-nourl' => 'Appel passé sans fournir d’URL !',
	'rss-invalid-url' => 'URL non valide : $1',
	'rss-parse-error' => 'Erreur lors de l’analyse XML du RSS',
	'rss-ns-permission' => 'Les flux RSS ne sont pas autorisés dans cet espace de noms',
	'rss-url-permission' => 'Cette URL n’est pas autorisée à être incluse',
	'rss-feed' => "<!--  ce qui suit est une alternative entre deux modèles. Le premier est le modèle de base par défaut pour les alimentations -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- ne pas mettre de retour à la ligne ici --><!-- Le second est une version améliorée qui requiert Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'rss-desc' => 'Montre los flux RSS sur les pâges MediaWiki dens un format estandârd ou ben dens un format dèfeni per l’utilisator avouéc les pâges du modèlo.',
	'rss-error' => 'Empossiblo de chargiér lo flux RSS de $1 : $2',
	'rss-empty' => 'Empossiblo de chargiér lo flux RSS de $1 !',
	'rss-fetch-nourl' => 'Apèl passâ sen balyér d’URL !',
	'rss-invalid-url' => 'URL envalida : $1',
	'rss-parse-error' => 'Èrror pendent l’analise XML du RSS',
	'rss-ns-permission' => 'Los flux RSS sont pas ôtorisâs dens cél èspâço de noms',
	'rss-url-permission' => 'Cela URL est pas ôtorisâ a étre encllua',
	'rss-feed' => "<!--  cen que siut est una altèrnativa entre doux modèlos. Lo premiér est lo modèlo de bâsa per dèfôt por los flux -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- pas betar de retôrn a la legne ique --><!-- Lo second est una vèrsion mèlyorâ qu’at fôta de l’Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'rss-desc' => 'Mostra unha fonte de novas RSS nunha páxina wiki',
	'rss-error' => 'Erro ao cargar a fonte de novas RSS de "$1": $2',
	'rss-empty' => 'Erro ao cargar a fonte de novas RSS de "$1"!',
	'rss-fetch-nourl' => 'Non deu ningún enderezo URL!',
	'rss-invalid-url' => 'O enderezo URL non é válido: $1',
	'rss-parse-error' => 'Erro analítico de XML para o RSS',
	'rss-ns-permission' => 'O RSS non está permitido neste espazo de nomes',
	'rss-url-permission' => 'Non está permitido incluír ese enderezo URL',
	'rss-feed' => "<!--  os seguintes son dous modelos alternativos. O primeiro é o modelo por defecto básico para as fontes de novas -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- non empregar unha liña nova aquí --><!-- O segundo é unha versión mellora que necesita Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'rss-desc' => 'Zeigt e RSS-Feed uf ere Wikisyte aa',
	'rss-error' => 'Dr RSS-Feed het nit vu $1 chenne glade wäre: $2',
	'rss-empty' => 'Dr RSS-Feed het nit vu $1 chenne glade wäre!',
	'rss-fetch-nourl' => 'Abruef ohni Aagab vun ere URL!',
	'rss-invalid-url' => 'Uugiltigi URL: $1',
	'rss-parse-error' => 'Fähler bim Parse vu XML fir RSS',
	'rss-ns-permission' => 'RSS isch in däm Namensruum nit erlaubt',
	'rss-url-permission' => 'Die URL derf nit enthalte sy',
	'rss-feed' => "<!-- Die Vorlage wo folge sin zwei alternativ zuenander yysetzbari Vorlage. Die erst isch d Standardvorlag für Feeds. -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- Aa dere Stell bitte kei nöii Zyyle yyfiege. --><!-- D zweit isch e verbesserti Vorlag, wo für d Softwareerwyterig ParserFunctions bruucht wird. --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'rss-desc' => 'מציג הזנת RSS על דף ויקי',
	'rss-error' => 'נכשלה טעינת הזנת RSS מ־$1: $2',
	'rss-empty' => 'נכשלה טעינת הזנת RSS מ־$1!',
	'rss-fetch-nourl' => 'קריאה לאחזור ללא כתובת URL!',
	'rss-invalid-url' => 'כתובת URL לא תקינה: $1',
	'rss-parse-error' => 'שגיאה בניתוח XML עבור RSS',
	'rss-ns-permission' => 'שימוש ב־RSS אינו מופעל במרחב השם הזה',
	'rss-url-permission' => 'לא ניתן לכלול את הכתובת הזאת',
	'rss-feed' => "<!--  the following are two alternative templates. The first is the basic default template for feeds -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- don't use newline here --><!-- The second is an improved version which requires Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'rss-invalid-url' => 'मान्य URL नहीं:$1',
);

/** Croatian (Hrvatski)
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'rss-desc' => 'Prikazuje RSS slijed na wiki stranici',
	'rss-error' => 'Nije uspjelo učitavanje RSS slijeda iz $1: $2',
	'rss-empty' => 'Nije uspjelo učitavanje RSS slijeda iz $1!',
	'rss-fetch-nourl' => 'Akcija pozvana bez URL-a!',
	'rss-invalid-url' => 'Nevaljan URL: $1',
	'rss-parse-error' => 'Pogreška pri parsiranju XML za RSS',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'rss-desc' => 'Zwobraznja RSS-kanal na wikistronje',
	'rss-error' => 'Začitowanje RSS-kanala z $1 je so njeporadźiło: $2',
	'rss-empty' => 'Začitowanje RSS-kanala z $1 je so njeporadźiło!',
	'rss-fetch-nourl' => 'Wotwołanje bjez URL!',
	'rss-invalid-url' => 'Njepłaćiwy URL: $1',
	'rss-parse-error' => 'Zmylk při parsowanju XML za RSS',
	'rss-ns-permission' => 'RSS njeje dowoleny w tutym mjenowym rumje',
	'rss-url-permission' => 'Tutón URL njesmě wobsahowany być',
	'rss-feed' => "<!--  the following are two alternative templates. The first is the basic default template for feeds -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- don't use newline here --><!-- The second is an improved version which requires Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'rss-desc' => 'Monstra un syndication RSS in un pagina wiki',
	'rss-error' => 'Falleva de cargar le syndication RSS de $1: $2',
	'rss-empty' => 'Falleva de cargar le syndication RSS de $1!',
	'rss-fetch-nourl' => 'Tentativa de obtention sin URL!',
	'rss-invalid-url' => 'URL non valide: $1',
	'rss-parse-error' => 'Error de syntaxe in XML de RSS',
	'rss-ns-permission' => 'RSS non es permittite in iste spatio de nomines',
	'rss-url-permission' => 'Le inclusion de iste URL es prohibite',
	'rss-feed' => "<!--  Ecce duo patronos alternative. Le prime es le patrono simple e standard pro syndicationes. -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- non comenciar un nove linea hic --><!-- Le secunde es un version meliorate que require le extension ParserFunctions. --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Indonesian (Bahasa Indonesia)
 * @author Farras
 * @author IvanLanin
 */
$messages['id'] = array(
	'rss-desc' => 'Menampilkan arus RSS di halaman wiki',
	'rss-error' => 'Gagal memuat arus RSS dari $1: $2',
	'rss-empty' => 'Gagal memuat arus RSS dari $1!',
	'rss-fetch-nourl' => 'Pengambilan dilakukan tanpa URL!',
	'rss-invalid-url' => 'Bukan URL yang sah: $1',
	'rss-parse-error' => 'Kesalahan parsing XML untuk RSS',
	'rss-ns-permission' => 'RSS tidak diizinkan pada ruang nama ini',
);

/** Italian (Italiano)
 * @author Beta16
 * @author F. Cosoleto
 * @author Gianfranco
 */
$messages['it'] = array(
	'rss-desc' => 'Visualizza un feed RSS in una pagina wiki',
	'rss-error' => 'Non è stato possibile caricare da $1 il feed RSS: $2',
	'rss-empty' => 'Non è stato possibile possibile caricare feed RSS da $1!',
	'rss-fetch-nourl' => 'Chiamata sprovvista di un URL!',
	'rss-invalid-url' => 'Non è un URL valido: $1',
	'rss-parse-error' => 'Errore di parsing XML per RSS',
	'rss-ns-permission' => 'RSS non è consentito in questo namespace',
	'rss-url-permission' => 'Questo URL non può essere incluso',
);

/** Japanese (日本語)
 * @author Iwai.masaharu
 * @author Schu
 * @author 青子守歌
 */
$messages['ja'] = array(
	'rss-desc' => '標準、又はテンプレートページを使用したユーザー定義可能なフォーマットで、MediaWiki ページにRSSフィードを表示します。',
	'rss-error' => '$1からのRSSフィードの読み込みに失敗しました：$2',
	'rss-empty' => '$1からのRSSフィードの読み込みに失敗しました！',
	'rss-fetch-nourl' => '取得する URL が指定されていません！',
	'rss-invalid-url' => '無効な URL: $1',
	'rss-parse-error' => 'RSS の XML 解析エラー',
	'rss-ns-permission' => 'RSSは、この名前空間に許可されていません',
	'rss-url-permission' => 'この URL を含ませることは許可されていません',
	'rss-feed' => "<!--  以下は、代替の2つのテンプレートです。 最初は、フィードの基本的な既定のテンプレートです。 -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- 改行文字をここで使わないでください。 --><!-- 次は、拡張機能:パーサー関数が必要な改良されたバージョンです。 --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Georgian (ქართული)
 * @author Dawid Deutschland
 */
$messages['ka'] = array(
	'rss-invalid-url' => 'არასწორი URL: $1',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'rss-desc' => 'Zeisch ene RSS-Kannaal op en Sigg em Wiki.',
	'rss-error' => 'Mer kunnte dä RSS-Kannaal vun $1 nit laade: $2',
	'rss-empty' => 'Mer kunnte dä RSS-Kannaal vun $1 nit laade.',
	'rss-fetch-nourl' => 'Et Affroofe (<code lang="en">fetch</code>) der ohne ene URL jeiht nit!',
	'rss-invalid-url' => '„$1“ es keine jöltijje URL.',
	'rss-parse-error' => 'Ene Fähler es opjetrodde beim Ongersöhke vun dämm XML för dat RSS.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'rss-desc' => 'Weist en RSS-Feed op enger Wiki-Säit',
	'rss-error' => 'Den RSS-Feed vun $1 konnt net geluede ginn: $2',
	'rss-empty' => 'Den RSS-Feed vun $1 konnt net geluede ginn!',
	'rss-fetch-nourl' => 'Ufro ouni URL!',
	'rss-invalid-url' => 'Keng valabel URL: $1',
	'rss-parse-error' => 'Feeler beim Parse vum XML fir RSS',
	'rss-ns-permission' => 'RSS ass an dësem Nummraum net erlaabt',
	'rss-url-permission' => 'Dës URL däerf net dra sinn',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Perkunas
 */
$messages['lt'] = array(
	'rss-desc' => 'Rodo RSS kanalą wiki puslapyje',
	'rss-error' => 'Nepavyko įkelti RSS kanalo iš $1: $2',
	'rss-empty' => 'Nepavyko įkelti RSS kanalo iš $1!',
	'rss-fetch-nourl' => 'Atsiuntimas iškviestas be nuorodos!',
	'rss-invalid-url' => 'Nekorektiška nuoroda: $1',
	'rss-parse-error' => "Klaida analizuojant RSS kanalo XML'ą",
	'rss-url-permission' => 'Šio URL neleidžiama įtraukti',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'rss-desc' => 'Прикажува RSS-канал на викистраница',
	'rss-error' => 'Не успеав да го вчитам RSS-каналот од $1: $2',
	'rss-empty' => 'Не успеав да го вчитам RSS-каналот од $1!',
	'rss-fetch-nourl' => 'Повикувањето за добивање нема URL!',
	'rss-invalid-url' => 'Не претставува важечка URL: $1',
	'rss-parse-error' => 'Грешка при парсирање на XML за RSS',
	'rss-ns-permission' => 'RSS не е допуштен во овој именски простор',
	'rss-url-permission' => 'Оваа URL-адреса не е дозволена',
	'rss-feed' => "<!--  Ова се два алтернативни шаблона. Првиот е основно зададениот шаблон за канали -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- туак не вметнувајте нов ред --><!-- Вториот е подобрена верзија што бара Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'rss-desc' => 'വിക്കി താളിൽ ആർ.എസ്.എസ്. ഫീഡ് പ്രദർശിപ്പിക്കുന്നു',
	'rss-error' => '$1 എന്നതിന്റെ ആർ.എസ്.എസ്. ഫീഡ് എടുക്കൽ പരാജയപ്പെട്ടു: $2',
	'rss-empty' => '$1 എന്നതിന്റെ ആർ.എസ്.എസ്. ഫീഡ് എടുക്കൽ പരാജയപ്പെട്ടു!',
	'rss-fetch-nourl' => 'യൂ.ആർ.എൽ. ഇല്ലാതെ ശേഖരിക്കാൻ ആവശ്യപ്പെട്ടിരിക്കുന്നു!',
	'rss-invalid-url' => 'സാധുവായ യൂ.ആർ.എൽ. അല്ല: $1',
	'rss-parse-error' => 'അർ.എസ്.എസിനായി എക്സ്.എം.എൽ. പാഴ്സ് ചെയ്തപ്പോൾ പിഴവുണ്ടായി',
	'rss-ns-permission' => 'ഈ നാമമേഖലയിൽ ആർ.എസ്.എസ്. അനുവദിക്കപ്പെട്ടിട്ടില്ല',
	'rss-url-permission' => 'ഈ യൂ.ആർ.എൽ. ഉൾപ്പെടുത്തുന്നത് അനുവദനീയമല്ല',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'rss-desc' => 'Memaparkan suapan RSS pada laman wiki',
	'rss-error' => 'Suapan RSS gagal dimuatkan dari $1: $2',
	'rss-empty' => 'Suapan RSS gagal dimuatkan dari $1!',
	'rss-fetch-nourl' => 'Ambilan dipanggil tanpa URL!',
	'rss-invalid-url' => 'URL tidak sah: $1',
	'rss-parse-error' => 'Ralat ketika menghurai XML untuk RSS',
	'rss-ns-permission' => 'RSS tidak dibenarkan di ruang nama ini',
	'rss-url-permission' => 'URL ini tidak dibenarkan untuk disertakan',
	'rss-feed' => "<!--  Berikut ialah dua templat alternatif. Yang pertama ialah templat asas untuk suapan -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- jangan letak baris baru di sini --><!-- Yang kedua ialah versi diperkemas yang memerlukan Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'rss-desc' => 'Viser en RSS-mating på en wikiside',
	'rss-error' => 'Kunne ikke laste RSS-mating fra $1: $2',
	'rss-empty' => 'Kunne ikke laste RSS-mating fra $1.',
	'rss-fetch-nourl' => 'Henting kallet uten en URL!',
	'rss-invalid-url' => 'Ikke en gyldig URL: $1',
	'rss-parse-error' => 'Feil ved XML-tolkning for RSS',
);

/** Dutch (Nederlands)
 * @author Mitchel Corstjens
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'rss-desc' => 'Biedt een RSS-feed voor een wikipagina',
	'rss-error' => 'Kon RSS feed van $1 niet laden, fout: $2',
	'rss-empty' => 'Kon RSS feed van $1 niet laden!',
	'rss-fetch-nourl' => 'Fetch is aangeroepen zonder een URL!',
	'rss-invalid-url' => 'Geen geldige URL: $1',
	'rss-parse-error' => 'Fout bij het verwerken van de XML voor RSS',
	'rss-ns-permission' => 'RSS is niet toegestaan in deze naamruimte',
	'rss-url-permission' => 'Deze URL mag niet worden opgenomen',
	'rss-feed' => "<!--  Hieronder staan twee alternatieve sjablonen. Het eerste is het standaardsjabloon voor feeds. -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- Hier geen nieuwe regel starten. --><!-- Het tweede sjabloon is een verbeterde versie waarvoor de uitbreiding ParserFunctions nodig is. --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'rss-desc' => 'Wyświetla kanał RSS na stronie wiki',
	'rss-error' => 'Nie udało się odczytać kanału $1: $2',
	'rss-empty' => 'Nie udało się odczytać kanału $1!',
	'rss-fetch-nourl' => 'Wywołano pobieranie bez adresu URL!',
	'rss-invalid-url' => 'Nieprawidłowy adres URL – $1',
	'rss-parse-error' => 'Błąd analizowania XML dla RSS',
	'rss-ns-permission' => 'RSS nie jest dostępne w tej przestrzeni nazw',
	'rss-url-permission' => 'Tego adresu URL nie można załączyć',
	'rss-feed' => "<!--  Poniżej znajdują się dwa alternatywne szablony. Pierwszy jest podstawowym domyślnym szablonem dla kanałów. -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- nie łam tutaj wiersza --><!-- Drugi to ulepszona wersja, która wymaga Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'rss-desc' => 'A mostra un fluss RSS su na pàgina dla wiki',
	'rss-error' => 'Falì a carié ël fluss RSS da $1: $2',
	'rss-empty' => 'Falì a carié ël fluss RSS da $1!',
	'rss-fetch-nourl' => "Arcesta fàita sensa n'adrëssa dl'aragnà!",
	'rss-invalid-url' => "Pa n'anliura bon-a: $1",
	'rss-parse-error' => "Eror ant l'anàlisi XML për RSS",
	'rss-ns-permission' => "RSS a l'é pa përmëttù an cost ëspassi nominal-sì",
	'rss-url-permission' => "Costa adrëssa dl'aragnà a l'é pa autorisà a esse anserìa",
	'rss-feed' => "<!--  coj ch'a ven-o a son doi stamp alternativ. Ël prim a l'é lë stamp base ëd default për ij feed -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- dòvra pa ël newline ambelessì --><!-- Lë scond a l'é na vërsion mejorà ch'a ciama Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Portuguese (Português)
 * @author Giro720
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'rss-desc' => 'Mostra um feed RSS numa página wiki',
	'rss-error' => 'Não foi possível carregar o feed RSS de $1: $2',
	'rss-empty' => 'Não foi possível carregar o feed RSS de $1!',
	'rss-fetch-nourl' => 'Chamada fetch sem uma URL!',
	'rss-invalid-url' => 'A URL não é válida: $1',
	'rss-parse-error' => 'Erro ao analisar XML para o RSS',
	'rss-ns-permission' => 'O RSS não é permitido neste espaço nominal',
	'rss-url-permission' => 'Não é permitido incluir a URL',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 * @author MetalBrasil
 */
$messages['pt-br'] = array(
	'rss-desc' => 'Mostra um feed RSS em uma página wiki',
	'rss-error' => 'Falha ao carregar feed RSS de $1: $2',
	'rss-empty' => 'Falha ao carregar feed RSS de $1!',
	'rss-fetch-nourl' => 'Chamada fetch sem uma URL!',
	'rss-invalid-url' => 'Não é uma URL válida: $1',
	'rss-parse-error' => 'Erro ao analisar XML para o RSS',
	'rss-ns-permission' => 'O RSS não é permitido neste espaço nominal',
	'rss-url-permission' => 'Não é permitido a inclusão desta URL',
	'rss-feed' => "<!--  Os seguintes são dois modelos alternativos. O primeiro é o padrão básico para fontes novas -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- Não adicionar uma linha nova aqui --><!-- O segundo é uma versão melhorada quer requer Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Romanian (Română)
 * @author Firilacroco
 * @author Minisarm
 */
$messages['ro'] = array(
	'rss-desc' => 'Afișează un flux RSS pe o pagină wiki',
	'rss-error' => 'Eroare la încărcarea fluxului RSS de la $1: $2',
	'rss-empty' => 'Eroare la încărcarea fluxului RSS de la $1!',
	'rss-fetch-nourl' => 'Apel trimis fără un URL!',
	'rss-invalid-url' => 'Nu este un URL valid: $1',
	'rss-parse-error' => 'Eroare de analiză XML pentru RSS',
	'rss-ns-permission' => 'RSS nu este permis în acest spațiu de nume',
	'rss-url-permission' => 'Acest URL nu este permis să fie inclus',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'rss-desc' => "Fà vedè 'nu feed RSS sus a 'na pàgene de uicchi",
	'rss-error' => "Carecamende d'u feed RSS fallite da $1: $2",
	'rss-empty' => "Carecamende d'u feed RSS fallite da $1!",
	'rss-fetch-nourl' => 'Esecuzione chiamate senza URL!',
	'rss-invalid-url' => "Non g'è 'na URL valide: $1",
	'rss-parse-error' => "Errore analizzanne l'XML pu RSS",
	'rss-ns-permission' => "Le RSS non ge sonde permesse jndr'à stu namespace",
	'rss-url-permission' => "Sta URL non g'è consendite pe essere ingluse",
	'rss-feed' => "<!--  le seguende sonde doje template alternative. 'U prime jè 'nu template de base pe le feed -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- no scè ausanne 'na linea nove aqquà --><!-- 'U seconde jè 'na versione migliorate ca vole le Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'rss-desc' => 'Показывает RSS-канал на викистранице',
	'rss-error' => 'Не удалось загрузить RSS-канал из $1: $2',
	'rss-empty' => 'Не удалось загрузить RSS-канал из $1!',
	'rss-fetch-nourl' => 'Выборка вызвана без URL!',
	'rss-invalid-url' => 'Недопустимый URL: $1',
	'rss-parse-error' => 'Ошибка разбора XML для RSS',
	'rss-ns-permission' => 'RSS не допускается в этом пространстве имён',
	'rss-url-permission' => 'Этот URL-адрес не может быть добавлен',
	'rss-feed' => "<!--  ниже представлены два возможных шаблона. Первый - это основной шаблон по умолчанию для ленты -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- не используйте здесь перевод строки --><!-- Второй - улучшенная версия, требующая расширения Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'rss-desc' => 'Зобразує на вікісторінцї RSS канал',
	'rss-error' => 'Не подарило ся начітати RSS канал з $1: $2',
	'rss-empty' => 'Не подарило ся начітати RSS канал з $1!',
	'rss-fetch-nourl' => 'Не быв становленый URL, котрый ся мать начітати!',
	'rss-invalid-url' => 'Неправилне URL: $1',
	'rss-parse-error' => 'Хыба парсованя XML про RSS',
	'rss-ns-permission' => 'У тім просторї назв не є доволене RSS',
	'rss-url-permission' => 'Тота URL не є доволена быти включена',
	'rss-feed' => "<!--  ниже суть дві можны шаблоны. Перша - основна шаблона про каналы -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- не хоснуйте ту переход на новый рядок --><!-- Другый - вылїпшена верзія, котра потребує росшырїня Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'rss-desc' => 'Биики сирэйгэ RSS көрдөрөр',
	'rss-error' => 'RSS-канаал мантан $1 кыайан хостоммото: $2',
	'rss-empty' => 'RSS-канаал мантан $1 хостоммото!',
	'rss-fetch-nourl' => 'Выборканы URL-ла суох көрдөөбүккүн!',
	'rss-invalid-url' => 'Сатаммат URL: $1',
	'rss-parse-error' => 'RSS аналлаах XML ырытыытын алҕаһа',
);

/** Sinhala (සිංහල)
 * @author පසිඳු කාවින්ද
 */
$messages['si'] = array(
	'rss-error' => '$1 ගෙන් RSS පෝෂණය පූරණය කිරීමට අපොහොසත් වුණි: $2',
	'rss-empty' => '$1 ගෙන් RSS පෝෂණය පූරණය කිරීමට අපොහොසත් වුණි!',
	'rss-fetch-nourl' => 'URL ලිපිනයකින් තොරව පමුණුවන්න කියා ඇත!',
	'rss-invalid-url' => 'වලංගු URL ලිපිනයක් නොවේ: $1',
	'rss-parse-error' => 'RSS සඳහා XML සැකසීමේ දෝෂය',
	'rss-ns-permission' => 'මෙම නාමඅවකාශයෙහි RSS සඳහා ඉඩ ලබා නොදේ',
	'rss-url-permission' => 'මෙම URL ලිපිනය අඩංගු කිරීමට ඉඩ නොදේ',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'rss-desc' => 'Zobrazí kanál RSS na wiki stránke',
	'rss-error' => 'Nepodarilo sa načítať RSS kanál z $1: $2',
	'rss-empty' => 'Nepodarilo sa načítať RSS kanál z $1!',
	'rss-fetch-nourl' => 'Stiahnutie stránky zavolané bez URL!',
	'rss-invalid-url' => 'Nie je platný URL: $1',
	'rss-parse-error' => 'Chyba pri spracovaní XML pre RSS',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'rss-desc' => 'Prikaže vir RSS na wikistrani',
	'rss-error' => 'Napaka pri nalaganju RSS z $1: $2',
	'rss-empty' => 'Napaka pri nalaganju RSS z $1!',
	'rss-fetch-nourl' => 'Pridobivanje klicano brez URL!',
	'rss-invalid-url' => 'Neveljavni URL: $1',
	'rss-parse-error' => 'Napaka pri razčlenjevanju XML za RSS',
	'rss-ns-permission' => 'RSS v tem imenskem prostoru ni dovoljen',
	'rss-url-permission' => 'Vključitev tega URL ni dovoljena',
	'rss-feed' => "<!--  sledita dve alternativni predlogi. Prva je osnovna privzeta predloga za vire -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- tukaj ne uporabi nove vrstice --><!-- Druga je izboljšana različica, ki potrebuje Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Swedish (Svenska)
 * @author Ainali
 * @author Lokal Profil
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'rss-desc' => 'Visar en RSS-feed på en wiki-sida',
	'rss-error' => 'Det gick inte att läsa in RSS-feed från $1: $2',
	'rss-empty' => 'Det gick inte att läsa in RSS-feed från $1!',
	'rss-fetch-nourl' => 'Hämtningsförök utan en URL!',
	'rss-invalid-url' => 'Inte en giltig URL: $1',
	'rss-parse-error' => 'Fel vid parsning av XML för RSS',
	'rss-ns-permission' => 'RSS är inte tillåtet i denna namnrymden',
	'rss-url-permission' => 'Denna URL tillåts inte att inkluderas',
);

/** Telugu (తెలుగు)
 * @author రహ్మానుద్దీన్
 */
$messages['te'] = array(
	'rss-desc' => 'RSS ఫీడ్ ను ఒక వికీ పుటపై చూపుతుంది',
	'rss-error' => '$1 నుండి RSS ఫీడ్ లోడ్ చేయడంలో అసమర్థత : $2',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'rss-desc' => 'Nagpapakita ng isang pakaing RSS sa isang pahina ng wiki',
	'rss-error' => 'Nabigong ikarga ang pakaing RSS mula sa $1: $2',
	'rss-empty' => 'Nabigong ikarga ang pakaing RSS mula sa $1!',
	'rss-fetch-nourl' => 'Tinawag ang pagkuha na walang isang URL!',
	'rss-invalid-url' => 'Hindi isang tanggap na URL: $1',
	'rss-parse-error' => 'Mali ang pagbabanghay ng XML para sa RSS',
);

/** Tatar (Cyrillic script) (Татарча)
 * @author Ильнар
 */
$messages['tt-cyrl'] = array(
	'rss-desc' => 'RSS-тасманы викибиттә ачу',
	'rss-error' => '$1: $2 битләреннән RSS-тасманы ачып булмады',
	'rss-empty' => '$1: битеннән  RSS-тасманы ачып булмады',
);

/** Ukrainian (Українська)
 * @author Arturyatsko
 * @author Dim Grits
 */
$messages['uk'] = array(
	'rss-desc' => 'Відображає канал RSS на сторінці вікі',
	'rss-error' => 'Не вдалося завантажити RSS-канал від $1: $2',
	'rss-empty' => 'Не вдалося завантажити RSS-канал від $1!',
	'rss-fetch-nourl' => 'Вибірка викликана без URL!',
	'rss-invalid-url' => 'Неприпустима адреса URL: $1',
	'rss-parse-error' => 'Помилка розбору XML для RSS',
	'rss-ns-permission' => 'RSS не дозволено в цьому просторі імен',
	'rss-url-permission' => 'Ця URL-адреса не може бути включена',
	'rss-feed' => "<!--  нижче наведено два можливих шаблони. Перший - це основний шаблон для стрічки -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- не використовуйте тут перехід на новий рядок --><!-- Другий - покращена версія, що потребує розширення Extension:ParserFunctions --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'rss-desc' => 'Hiển thị nguồn cấp RSS trên trang wiki',
	'rss-error' => 'Thất bại khi tải nguồn cấp RSS từ $1: $2',
	'rss-empty' => 'Thất bại khi tải nguồn cấp RSS từ $1!',
	'rss-fetch-nourl' => 'Cần URL để tải!',
	'rss-invalid-url' => 'URL không hợp lệ: $1',
	'rss-parse-error' => 'Lỗi phân tích XML như RSS',
	'rss-ns-permission' => 'Không được phép xem RSS trong không gian tên này',
	'rss-url-permission' => 'Không cho phép bao gồm URL này',
	'rss-feed' => "<!--  Sau đây có hai bản mẫu thay cho nhau. Thứ nhất là bản mẫu mặc định cơ bản dành cho các nguồn tin: -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- không ngắt dòng tại đây --><!-- Thứ hai là phiên bản cải tiến cần phần mở rộng Extension:ParserFunctions: --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: — {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: — {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Chenxiaoqino
 * @author Hydra
 * @author PhiLiP
 */
$messages['zh-hans'] = array(
	'rss-desc' => '在MediaWiki页面上使用模板页面，以标准或使用者自订格式显示RSS源',
	'rss-error' => '自$1: $2加载RSS失败',
	'rss-empty' => '自$1加载RSS失败',
	'rss-fetch-nourl' => '无网址情况中进行读取！',
	'rss-invalid-url' => '不是有效的网址：$1',
	'rss-parse-error' => 'RSS 的解析 XML 时出现错误',
	'rss-ns-permission' => '此名字空间不允许使用RSS',
	'rss-url-permission' => '此URL已被禁止使用',
	'rss-feed' => "<!--  以下是两种可供选择的模板，第一种是默认的进料模板 -->; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- don't use newline here --><!-- 第二种是需要Extension:ParserFunctions的改进版本 --><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{{date}}}}}|}} -->",
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author Mark85296341
 */
$messages['zh-hant'] = array(
	'rss-desc' => '在MediaWiki頁面上使用模板頁面，以標準或用戶自定義格式顯示RSS源',
	'rss-error' => '自 $1：$2 載入 RSS 失敗',
	'rss-empty' => '自 $1 載入 RSS 失敗',
	'rss-fetch-nourl' => '無網址情況中進行讀取！',
	'rss-invalid-url' => '不是有效的網址：$1',
	'rss-parse-error' => 'RSS 解析 XML 時出現錯誤',
	'rss-ns-permission' => '此名字空間不允許使用RSS',
	'rss-url-permission' => '此網址已被禁止使用',
	'rss-feed' => "<!-​​- 以下是兩種可供選擇的模板，第一種是默認的進料模板-->; '''<span class='plainlinks'>[{{{link}}} {{{title }}}]</span>'''
: {{{description}}}
: {{{author}}} {{{date}}}<!-- 在此切勿換行 --><!-- 第二種是需要Extension:ParserFunctions的改進版本--><!-- ; '''<span class='plainlinks'>[{{{link}}} {{{title}}}]</span>'''{{#if: {{{description|}}}|: {{{description}}}}}{{#if: {{{author|}}} | {{#if: {{{date|}}} |: &mdash; {{{author}}} {{{ date}}}}} | {{#if: {{{author|}}}|: &mdash; {{{author}}}}} {{#if: {{{date|}}}|:{{ {date}}}}}|}} -->",
);

