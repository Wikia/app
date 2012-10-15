<?php
/**
 * Internationalisation file for extension PageInCat
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'pageincat-desc' => 'Adds a parser function <code><nowiki>{{#incat:...}}</nowiki></code> to determine if the current page is in a specified category',
	'pageincat-wrong-warn' => '\'\'\'Warning:\'\'\' The {{PLURAL:$2|category $1 was|categories $1 were}} detected incorrectly by <code><nowiki>{{#incat:...}}</nowiki></code>, and as a result this preview may be incorrect. The saved version of this page should be displayed in the correct manner.',
	'pageincat-very-wrong-warn' => '\'\'\'Warning:\'\'\' The {{PLURAL:$2|category $1 was|categories $1 were}} detected incorrectly by <code><nowiki>{{#incat:...}}</nowiki></code>, and as a result this preview may be incorrect. This can be caused by including categories inside of <code><nowiki>{{#incat:...}}</nowiki></code> statements, and may result in inconsistent display.',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'pageincat-wrong-warn' => 'Warning displayed during preview when editing a page if #incat parser function acted incorrectly (Acting incorrectly means acting as if page was not in category, but page actually is). This can happen during preview, since the categories from the last saved revision are used instead of the categories specified in the page text. Once page is saved, the correct categories should be used. This error can also be caused by conditional category inclusion (<code><nowiki>{{#ifpageincat:Foo||[[category:Foo]]}}</nowiki></code>. See also {{msg-mw|pageincat-very-wrong-warn}}.

*$1 is the list of categories (in a localized comma separated list with the last two items separated by {{msg-mw|and}}. The individual category names will be italicized).
*$2 is how many categories',
	'pageincat-very-wrong-warn' => "Warning displayed during preview when editing a page if #incat parser function acted incorrectly (Acting incorrectly means acting as if page was not in category, but page actually is) . This can happen if someone does something like ''put this page in category foo only if its not in category foo'' or more generally when people include category links inside <code>#incat</code> functions. Compare this to {{msg-mw|pageincat-wrong-warn}}. Generally this error message can happen when support for checking actual categories in the preview is enabled (but the category functions still behave incorrectly), the other error message will be triggered when such support is disabled.

*$1 is the list of categories (in a localized comma separated list with the last two items separated by {{msg-mw|and}}. The individual category names will be italicized).
*$2 is how many categories",
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 */
$messages['de'] = array(
	'pageincat-desc' => 'Ergänzt die Parserfunktion <code>#incat:</code> mit der ermittelt werden kann, ob sich die aktuelle Seite in einer angegebenen Kategorie befindet',
	'pageincat-wrong-warn' => "'''Achtung:''' Die {{PLURAL:$2|Kategorie $1 wurde|Kategorien $1 wurden}} durch <code>#incat:</code> falsch erkannt. Deswegen könnte die Vorschau fehlerhaft sein. Die gespeicherte Version dieser Seite sollte korrekt angezeigt werden.",
	'pageincat-very-wrong-warn' => "'''Achtung:''' Die {{PLURAL:$2|Kategorie $1 wurde|Kategorien $1 wurden}} durch <code>#incat:</code> falsch erkannt. Deswegen könnte die Vorschau fehlerhaft sein. Dies kann durch die Angabe von Kategorien innerhalb der Funktionsangabe <code><nowiki>{{#incat:...}}</nowiki></code> verursacht werden und könnte daher zu einer inkonsistenten Anzeige führen.",
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'pageincat-desc' => 'Pśidawa parserowu funkciju <code><nowiki>{{#incat:...}}</nowiki></code>, aby zwěsćiło, lěc aktualny bok jo w pódanej kategoriji',
	'pageincat-wrong-warn' => "'''Warnowanje:''' {{PLURAL:$2|Kategorija $1 je|Kategoriji $1 stej|Kategorije $1 su|Kategorije $1 su}} se pśez <code><nowiki>{{#incat:...}}</nowiki></code> wopak {{PLURAL:$2|spóznała|spóznałej|spóznali|spóznali}}, a togodla mógał pśeglěd wopak byś. Składowana wersija boka by měła se korektnje zwobrazniś.",
	'pageincat-very-wrong-warn' => "'''Warnowanje:''' {{PLURAL:$2|Kategorija $1 jo|Kategoriji $1 stej|Kategorije $1 su|Kategorije $1 su}} se pśez <code><nowiki>{{#incat:...}}</nowiki></code> wopak {{PLURAL:$2|spóznała|spóznałej|spóznali|spóznali}}, a togodla mógał pśeglěd wopak byś. Pśicyna mógła byś, až su se kategorije do wurazow <code><nowiki>{{#incat:...}}</nowiki></code> zapśimjeli, což mógło k inkonsistentnemu zwobraznjenjeju wjasć.",
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'pageincat-desc' => "Ajoute une fonction de l'analyseur <code><nowiki>{{#incat:...}}</nowiki></code> pour déterminer si la page courante est dans une catégorie spécifiée",
	'pageincat-wrong-warn' => "'''Attention:''' {{PLURAL:$2|La catégorie $1a mal été détectée|Les catégories $1 ont mal été détectées}} par <code><nowiki>{{#incat:...}}</nowiki></code>, et par conséquent, cet aperçu peut être incorrect. La version enregistrée de cette page devrait être affichée correctement.",
	'pageincat-very-wrong-warn' => "'''Attention:''' {{PLURAL:$2|La catégorie $1a été mal détectée|Les catégories $1ont été mal détectées}} par <code><nowiki>{{#incat:...}}</nowiki></code>, et par conséquent cet aperçu peut être incorrect. Cela peut être causé par des catégories incluses à l'intérieur des déclarations <code><nowiki>{{#incat:...}}</nowiki></code>, et peut provoquer un affichage incohérent.",
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'pageincat-desc' => 'Engade unha función analítica, <code><nowiki>{{#incat:...}}</nowiki></code>, para determinar se a páxina actual está presente nunha categoría especificada',
	'pageincat-wrong-warn' => "'''Atención:''' <code><nowiki>{{#incat:...}}</nowiki></code> detectou incorrectamente {{PLURAL:$2|a categoría $1|as categorías $1}}. Debido a isto, esta vista previa pode non ser correcta. A versión gardada da páxina debería mostrarse correctamente.",
	'pageincat-very-wrong-warn' => "'''Atención:''' <code><nowiki>{{#incat:...}}</nowiki></code> detectou incorrectamente {{PLURAL:$2|a categoría $1|as categorías $1}}. Debido a isto, esta vista previa pode non ser correcta. Poida que incluíse categorías dentro de declaracións <code><nowiki>{{#incat:...}}</nowiki></code>, o que pode provocar que non se mostre correctamente.",
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'pageincat-desc' => 'Přidawa parserowu funkciju <code><nowiki>{{#incat...}}</nowiki></code>, zo by zwěsćiło, hač aktualna strona je w podatej kategoriji',
	'pageincat-wrong-warn' => "'''Warnowanje:''' {{PLURAL:$2|Kategorija $1 je|Kategoriji $1 stej|Kategorije $1 su|Kategorije $1 su}} so přez <code><nowiki>{{#incat:...}}</nowiki></code> wopak {{PLURAL:$2|spóznała|spóznałoj|spóznali|spóznali}}, a tohodla móhł přehlad wopak być. Składowana wersija strony měła so korektnje zwobraznić.",
	'pageincat-very-wrong-warn' => "'''Warnowanje:''' {{PLURAL:$2|Kategorija $1 je|Kategoriji $1 stej|Kategorije $1 su|Kategorije $1 su}} so přez <code><nowiki>{{#incat:...}}</nowiki></code> wopak {{PLURAL:$2|spóznała|spóznałoj|spóznali|spóznali}}, a tohodla móhł přehlad wopak być. Přičina móhła być, zo su so kategorije do wurazow <code><nowiki>{{#incat:...}}</nowiki></code> zapřijeli, štož móhło k inkonsistentnemu zwobraznjenju wjesć.",
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'pageincat-desc' => 'Adde al analysator syntactic un function <code><nowiki>{{#incat:...}}</nowiki></code> pro determinar si le pagina actual es in un categoria specificate',
	'pageincat-wrong-warn' => "'''Attention:''' Le {{PLURAL:$2|categoria|categorias}} $1 esseva detegite incorrectemente per <code><nowiki>{{#incat:...}}</nowiki></code>, e como resultato, iste previsualisation pote esser incorrecte. Le version salveguardate de iste pagina deberea esser presentate in le maniera correcte.",
	'pageincat-very-wrong-warn' => "'''Attention:''' Le {{PLURAL:$2|categoria|categorias}} $1 esseva detegite incorrectemente per <code><nowiki>{{#incat:...}}</nowiki></code>, e como resultato, iste previsualisation pote esser incorrecte. Isto pote esser causate per includer categorias intra commandos <code><nowiki>{{#incat:...}}</nowiki></code>, e pote resultar in un presentation inconsistente.",
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'pageincat-desc' => 'Setzt eng Parserfonctioun  <code><nowiki>{{#incat:...}}</nowiki></code> derbäi fir festzestellen ob déi aktuell Säit an enger spezifescher Kategorie dran ass',
	'pageincat-wrong-warn' => "'''Opgepasst:''' D'{{PLURAL:$2|Kategorie $1 gouf|Kategorien $1 goufen}} net korrekt duerch <code><nowiki>{{#incat:...}}</nowiki></code> erkannt, an doduerch kann dës net-gespäichert Versioun vun der Säit net korrekt sinn. Déi gespäichert Versioun vun dëser Säit misst richteg gewise ginn.",
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'pageincat-desc' => 'Додава парсерска функција <code><nowiki>{{#incat:...}}</nowiki></code> за да се утврди дали тековната страница стои во назначена категорија',
	'pageincat-wrong-warn' => "'''ПРЕДУПРЕДУВАЊЕ:''' {{PLURAL:$2|Категоријата $1 е погрешно утврдена|Категориите $1 се погрешно утврдени}} од страна на <code><nowiki>{{#incat:...}}</nowiki></code>. Поради тоа, овој преглед може да е неисправен. Зачуваната верзија на страницава треба да се прикажува на правилен начин.",
	'pageincat-very-wrong-warn' => "'''Предупредување:''' {{PLURAL:$2|Категоријата $1 е погрешно утврдена|Категориите $1 се погрешно утврдени}} од страна на <code><nowiki>{{#incat:...}}</nowiki></code>. Поради тоа, овој преглед може да е неисправен. Една можна причина е ако има категории ставени во искази со <code><nowiki>{{#incat:...}}</nowiki></code>. Проблемот може да произлегува и од недоследен приказ.",
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'pageincat-desc' => 'Voegt de parserfunctie <code><nowiki>{{#incat:...}}</nowiki></code> toe om te bepalen of de huidige pagina in een bepaalde categorie valt',
	'pageincat-wrong-warn' => "'''Waarschuwing:''' De {{PLURAL:$2|categorie $1 is|categorieën $1 zijn}} onjuist gedetecteerd door <code><nowiki>{{#incat:...}}</nowiki></code>, en als gevolg daarvan kan deze voorvertoning onjuist zijn. De opgeslagen versie van deze pagina zou op de juiste manier weergegeven moeten worden.",
	'pageincat-very-wrong-warn' => "'''Waarschuwing:''' De {{PLURAL:$2|categorie $1 is|categorieën $1 zijn}} onjuist gedetecteerd door <code><nowiki>{{#incat:...}}</nowiki></code>, en als gevolg daarvan kan deze voorvertoning onjuist zijn. Dit kan veroorzaakt worden door categorieën toe te voegen binnen <code><nowiki>{{#incat:...}}</nowiki></code> , en kan leiden tot inconsistente weergave.",
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'pageincat-desc' => "A gionta na funsion ëd l'analisator <code><nowiki>{{#incat:...}}</nowiki></code> për determiné se la pàgina corenta a l'é ant na categorìa spessificà",
	'pageincat-wrong-warn' => "'''Avis:''' {{PLURAL:$2|La categorìa $1 a l'é nen ëstàita|Le categorìe $1 a j'ero nen ëstàite}} andividuà për da bin da <code><nowiki>{{#incat:...}}</nowiki></code>, e com arzultà sta preuva a podrìa esse cioca. La version salvà ëd costa pàgina a dovrìa esse visualisà ant la manera giusta.",
	'pageincat-very-wrong-warn' => "'''Avis:''' {{PLURAL:$2|La categorìa $1 a l'é ne ëstàita|Le categorìe $1 a son nen ëstàite}} andividuà për da bin da <code><nowiki>{{#incat:...}}</nowiki></code>, e com arzultà costa previsualisassion a podrìa esse cioca. Sòn a peul esse causà da l'anclusion ëd le categorìe andrinta a l'istrussion <code><nowiki>{{#incat:...}}</nowiki></code>, e a peul arzulté an na visualisassion incoerenta.",
);

